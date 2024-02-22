<?php
namespace app\massage\model;

use app\BaseModel;
use think\facade\Db;

class BalanceWater extends BaseModel
{
    //定义表名
    protected $name = 'massage_service_balance_water';

//
    protected $append = [

        'goods_title',

    ];


    /**
     * @author chenniang
     * @DataTime: 2021-07-07 17:44
     * @功能说明:项目名称
     */
    public function getGoodsTitleAttr($value,$data){

        if(!empty($data['type'])&&!empty($data['order_id'])){

            $balance_order_model = new BalanceOrder();
            //充值
            if($data['type']==1){

                $title = $balance_order_model->where(['id'=>$data['order_id']])->value('title');

            }else{

                $order_goods_model = $data['type']==4?new UpOrderGoods():new OrderGoods();
                //消费
                $title = $order_goods_model->where(['order_id'=>$data['order_id']])->column('goods_name');

                $title = !empty($title)?implode(',',$title):'';

            }

            return $title;

        }


    }







    /**
     * @author chenniang
     * @DataTime: 2020-09-29 11:04
     * @功能说明:添加
     */
    public function dataAdd($data){

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

//        if(){
//
//        }

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
     * @DataTime: 2022-12-13 16:20
     * @功能说明:修改用户的余额并添加流水记录
     */
    public function updateUserBalance($order,$type,$add=0){

        $user_model  = new User();

        $water_model = new BalanceWater();

        $user = $user_model->dataInfo(['id'=>$order['user_id']]);

        if($add==0){
            //修改用户余额
            $res = $user_model->dataUpdate(['id'=>$order['user_id'],'lock'=>$user['lock']],['balance'=>$user['balance']-$order['pay_price'],'lock'=>$user['lock']+1]);
        }else{
            //修改用户余额
            $res = $user_model->dataUpdate(['id'=>$order['user_id'],'lock'=>$user['lock']],['balance'=>$user['balance']+$order['pay_price'],'lock'=>$user['lock']+1]);
        }

        if($res==0){

            return false;

        }
        //添加余额流水
        $insert = [

            'uniacid' => $order['uniacid'],

            'user_id' => $order['user_id'],

            'price'   => $order['pay_price'],

            'order_id'=> $order['id'],

            'add'     => $add,

            'type'    => $type,

            'before_balance' => $user['balance'],

            'after_balance'  => $add==0?$user['balance']-$order['pay_price']:$user['balance']+$order['pay_price'],
        ];

        $res = $water_model->dataAdd($insert);

        return $res;
    }







}