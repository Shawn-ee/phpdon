<?php
namespace app\reminder\model;

use AlibabaCloud\Client\AlibabaCloud;
use app\BaseModel;
use app\massage\model\Admin;
use app\massage\model\Coach;
use app\massage\model\Order;
use app\massage\model\RefundOrder;
use app\massage\model\ShortCodeConfig;
use app\massage\model\User;
use app\reminder\info\PermissionReminder;
use app\virtual\info\PermissionVirtual;
use Exception;
use longbingcore\wxcore\aliyun;
use longbingcore\wxcore\aliyunVirtual;
use think\facade\Db;

class Config extends BaseModel
{
    //定义表名
    protected $name = 'massage_aliyun_phone_config';


    /**
     * @param $value
     * @param $data
     * @功能说明:
     * @author chenniang
     * @DataTime: 2022-12-15 10:58
     */
    public function getReminderAdminPhoneAttr($value,$data){

        if(isset($value)){

            return !empty($value)?explode(',',$value):'';
        }

    }

    /**
     * @author chenniang
     * @DataTime: 2020-09-29 11:04
     * @功能说明:添加
     */
    public function dataAdd($data){

        $res = $this->insert($data);

        return $res;

    }



    /**
     * @author chenniang
     * @DataTime: 2020-09-29 11:05
     * @功能说明:编辑
     */
    public function dataUpdate($dis,$data){

        $res = $this->where($dis)->update($data);

        return $res;

    }


    /**
     * @author chenniang
     * @DataTime: 2020-09-29 11:06
     * @功能说明:列表
     */
    public function dataList($dis,$page){

        $data = $this->where($dis)->order('id desc')->paginate($page)->toArray();

        return $data;

    }


    /**
     * @author chenniang
     * @DataTime: 2020-09-29 11:43
     * @功能说明:
     */
    public function dataInfo($dis){

        $data = $this->where($dis)->find();

        if(empty($data)){

            $this->dataAdd($dis);

            $data = $this->where($dis)->find();

        }

        return !empty($data)?$data->toArray():[];

    }


    /**
     * @author chenniang
     * @DataTime: 2022-12-09 10:04
     * @功能说明:发送语音
     */
    public function sendCalled($order){

        $p = new PermissionReminder($order['uniacid']);

        $auth = $p->pAuth();

        if($auth==false){

            return true;
        }

        $config_model = new Config();

        $config = $config_model->dataInfo(['uniacid'=>$order['uniacid']]);

        if($config['reminder_status']==0){

            return false;
        }

        $aliyun = new aliyun();

        $coach_model = new Coach();

        $record_model = new Record();

        $config_model = new ShortCodeConfig();

        $phone = $coach_model->where(['id'=>$order['coach_id']])->value('mobile');
        //发送语音通知
        $res = $aliyun::main($order['uniacid'],$phone);
        //添加发送记录
        $insert  = [

            'uniacid' => $order['uniacid'],

            'order_id'=> $order['id'],

            'res'     => json_encode($res)

        ];

        $record_model->dataAdd($insert);
        //给管理员发通知
        if(!empty($config['reminder_admin_status'])&&!empty($config['reminder_admin_phone'])&&is_array($config['reminder_admin_phone'])){

            foreach ($config['reminder_admin_phone'] as $value){
                //发送语音通知
                $res = $aliyun::main($order['uniacid'],$value);
                //如果被限流 就发短信
                if($res['code']=='isv.BUSINESS_LIMIT_CONTROL'){

                     $config_model->sendSms($value, $order['uniacid'], $order['order_code'], 1);
                }

            }

        }
        //给代理商发通知
        if($config['notice_agent']==1&&!empty($order['admin_id'])){

            $admin_model = new Admin();

            $phone = $admin_model->where(['id'=>$order['admin_id']])->value('phone');

            if(!empty($phone)){
                //发送语音通知
                $res = $aliyun::main($order['uniacid'],$phone);
                //如果被限流 就发短信
                if($res['code']=='isv.BUSINESS_LIMIT_CONTROL'){

                    $config_model->sendSms($phone, $order['uniacid'], $order['order_code'], 1);
                }
            }
        }

        return $res;
    }


    /**
     * @author chenniang
     * @DataTime: 2023-03-08 10:06
     * @功能说明:发送通知
     */
    public function sendPhoneNotice($uniacid,$phone){

        $p = new PermissionReminder($uniacid);

        $auth = $p->pAuth();

        if($auth==false){

            return true;
        }

        $config_model = new Config();

        $config = $config_model->dataInfo(['uniacid'=>$uniacid]);

        if($config['reminder_status']==0){

            return false;
        }

        $aliyun = new aliyun();

        $res = $aliyun::main($uniacid,$phone);

        return $res;

    }



    /**
     * @author chenniang
     * @DataTime: 2022-12-09 11:35
     * @功能说明:定时任务给未截单的技师发送语音通知
     */
    public function timingSendCalled($uniacid){

        $p = new PermissionReminder($uniacid);

        $auth = $p->pAuth();

        if($auth==false){

            return true;
        }

        $config_model = new Config();

        $config = $config_model->dataInfo(['uniacid'=>$uniacid]);
        //未开启语音通知 或未开启定时任务
        if($config['reminder_status']==0||$config['reminder_timing']==0){

            return false;
        }

        $order_model = new Order();

        $dis = [

            'uniacid' => $uniacid,
            //未接单单
            'pay_type'=> 2
        ];

        $order = $order_model->where($dis)->where('pay_time','<',time()-$config['reminder_timing']*60)->order('id desc')->limit(30)->select()->toArray();

        $record_model = new Record();

        $aliyun = new aliyun();

        $coach_model = new Coach();

        $refund_model = new RefundOrder();

        if(!empty($order)){

            foreach ($order as $value){
                //判断有无申请中的退款订单
                $refund_order = $refund_model->dataInfo(['order_id' => $value['id'], 'status' => 1]);

                $dis = [

                    'order_id' => $value['id'],

                    'uniacid'  => $value['uniacid']
                ];

                $find = $record_model->where($dis)->where('create_time','>',time()-$config['reminder_timing']*60)->find();
                //如果没有发送过通知
                if(empty($find)&&empty($refund_order)){

                    $phone = $coach_model->where(['id'=>$value['coach_id']])->value('mobile');

                    $res = $aliyun::main($value['uniacid'],$phone);

                    $insert  = [

                        'uniacid' => $value['uniacid'],

                        'order_id'=> $value['id'],

                        'res'     => json_encode($res)

                    ];

                    $record_model->dataAdd($insert);

                }

            }

        }

        return true;
    }









}