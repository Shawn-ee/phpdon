<?php
namespace app\massage\model;

use app\BaseModel;
use think\facade\Db;

class BalanceOrder extends BaseModel
{
    //定义表名
    protected $name = 'massage_service_balance_order_list';

//
    protected $append = [

        'nick_name',


    ];


    /**
     * @author chenniang
     * @DataTime: 2021-07-11 15:47
     * @功能说明:用户昵称
     */
    public function getNickNameAttr($value,$data){

        if(!empty($data['user_id'])){

            $user_model = new User();

            return $user_model->where(['id'=>$data['user_id']])->value('nickName');

        }

    }







    /**
     * @author chenniang
     * @DataTime: 2020-09-29 11:04
     * @功能说明:添加
     */
    public function dataAdd($data){

        $data['status'] = 1;

        $data['create_time'] = time();

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
    public function dataList($dis,$page=10){

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

        return !empty($data)?$data->toArray():[];

    }



    /**
     * @author chenniang
     * @DataTime: 2021-03-22 11:31
     * @功能说明:订单支付回调
     */
    public function orderResult($order_code,$transaction_id){

        $order = $this->dataInfo(['order_code'=>$order_code,'transaction_id'=>'']);

        if(!empty($order)){

            $user_model = new User();

            $water_model= new BalanceWater();

            $user = $user_model->dataInfo(['id'=>$order['user_id']]);

            Db::startTrans();

            $update = [

                'transaction_id' => $transaction_id,

                'status'         => 2,

                'pay_time'       => time(),

                'now_balance'    => $order['true_price']+$user['balance']

            ];
            //修改订单信息
            $res = $this->dataUpdate(['id'=>$order['id'],'transaction_id'=>''],$update);

            if($res==0){

                Db::rollback();

            }
            //修改用户余额
            $res = $user_model->dataUpdate(['id'=>$order['user_id']],['balance'=>$order['true_price']+$user['balance']]);

            if($res==0){

                Db::rollback();

            }
            //添加余额流水
            $insert = [

                'uniacid' => $order['uniacid'],

                'user_id' => $order['user_id'],

                'price'   => $order['true_price'],

                'order_id'=> $order['id'],

                'add'     => 1,

                'type'    => 1,

                'before_balance' => $user['balance'],

                'after_balance'  => $order['true_price']+$user['balance'],
            ];

            $res = $water_model->dataAdd($insert);

            if($res==0){

                Db::rollback();

            }

            $integral_model = new Integral();

            $coach_model = new Coach();

            $integral_record = $integral_model->dataInfo(['order_id'=>$order['id'],'type'=>0,'status'=>-1]);
            //分销返佣积分
            if(!empty($integral_record)){

                $integral_model->dataUpdate(['id'=>$integral_record['id']],['status'=>1]);

                $integral = $integral_record['integral'];

                $coach_model->where(['id'=>$order['coach_id']])->update(['integral'=>Db::Raw("integral+$integral")]);
            }

            $comm_model = new Commission();

            $comm_data = $comm_model->dataInfo(['order_id'=>$order['id'],'status'=>-1,'type'=>7]);
            //分销返佣佣金
            if(!empty($comm_data)){

                $integral_model->dataUpdate(['order_id'=>$order['id'],'type'=>1,'status'=>-1],['status'=>1]);

                $comm_model->dataUpdate(['id'=>$comm_data['id']],['status'=>2,'cash_time'=>time()]);

                $cash = $comm_data['cash'];

                $coach_model->where(['id'=>$order['coach_id']])->update(['service_price'=>Db::Raw("service_price+$cash"),'balance_cash'=>Db::Raw("balance_cash+$cash")]);
            }

            Db::commit();

        }

        return true;

    }





}