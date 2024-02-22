<?php
namespace app\virtual\model;

use AlibabaCloud\Client\AlibabaCloud;
use app\BaseModel;
use app\massage\model\Coach;
use app\reminder\model\Record;
use app\virtual\info\PermissionVirtual;
use Exception;
use longbingcore\wxcore\aliyunVirtual;
use think\facade\Db;

class Config extends BaseModel
{
    //定义表名
    protected $name = 'massage_aliyun_phone_config';


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
     * @DataTime: 2023-01-03 12:09
     * @功能说明:获取虚拟电话权限
     */
    public function getVirtualAuth($uniacid){

        $p = new PermissionVirtual($uniacid);

        $auth = $p->pAuth();
        //如果没有权限返回真实号码
        if($auth==false){

            return false;
        }

        $config = $this->dataInfo(['uniacid'=>$uniacid]);
        //如果未开启返回真实号码
        if($config['virtual_status']==0){

            return false;

        }

        return true;
    }


    /**
     * @author chenniang
     * @DataTime: 2022-12-08 11:53
     * @功能说明:获取虚拟电话
     */
    public function getVirtual($order,$type=1){

        $p = new PermissionVirtual($order['uniacid']);

        $auth = $p->pAuth();
        //如果没有权限返回真实号码
        if($auth==false){

            if($type==1){

                return $order['address_info']['mobile'];

            }else{

                return $order['coach_info']['mobile'];

            }
        }

        $config = $this->dataInfo(['uniacid'=>$order['uniacid']]);
        //如果未开启返回真实号码
        if($config['virtual_status']==0){

            if($type==1){

                return $order['address_info']['mobile'];

            }else{

                return $order['coach_info']['mobile'];

            }

        }

        $core_model   = new aliyunVirtual();

        $record_model = new \app\virtual\model\Record();

        $coach_phone  = $order['coach_info']['mobile'];
        //查询客户电话和技师电话有无绑定关系
        $arr = [$order['address_info']['mobile'],$coach_phone];

        foreach ($arr as $value){

            $find = $record_model->findRecord($value,$config['pool_key']);
            //解除绑定关系
            if(!empty($find)){

                $record_model->dataUpdate(['id'=>$find['id']],['status'=>-1]);

                $core_model->delBind($order['uniacid'],$find['subs_id'],$find['phone_x'],$find['pool_key']);
            }

        }
        //新增绑定关系 过期时间
        $expiration = date('Y-m-d H:i:s',time()+3600);

        $res = $core_model->bindPhone($order['uniacid'],$coach_phone,$order['address_info']['mobile'],$expiration,$config['pool_key'],$order['id']);

        $insert  = [

            'uniacid' =>$order['uniacid'],

            'order_id' =>$order['id'],

            'order_code' =>$order['order_code'],

            'phone_a' => $coach_phone,

            'phone_b' => $order['address_info']['mobile'],

            'phone_x' => !empty($res['secretBindDTO']['secretNo'])?$res['secretBindDTO']['secretNo']:'',

            'subs_id' => !empty($res['secretBindDTO']['subsId'])?$res['secretBindDTO']['subsId']:'',

            'pool_key'=> $config['pool_key'],

            'expire_date' => strtotime($expiration),

            'create_time' => time(),

            'status' => -1,

            'text' => json_encode($res)

        ];
        //绑定成功
        if(!empty($res['code'])&&$res['code']=='OK'&&!empty($res['message'])&&$res['message']=='OK'){

            $insert['status'] = 1;
            //返回虚拟号码
            $true_phone =  $insert['phone_x'];

        }else{

            $true_phone =  $order['address_info']['mobile'];

        }

        $record_model->dataAdd($insert);

        return $true_phone;

    }


    /**
     * @author chenniang
     * @DataTime: 2022-12-09 16:22
     * @功能说明:解除绑定虚拟号码
     */
    public function delBindVirtualPhone($order){

        $record_model = new \app\virtual\model\Record();

        $virtual_model = new aliyunVirtual();

        $data = $record_model->dataInfo(['order_id'=>$order['id'],'status'=>1]);

        if(!empty($data)){

            $record_model->dataUpdate(['id'=>$data['id']],['status'=>-1]);
            //解除绑定
            $virtual_model->delBind($order['uniacid'],$data['subs_id'],$data['phone_x'],$data['pool_key']);

        }

        return true;
    }











}