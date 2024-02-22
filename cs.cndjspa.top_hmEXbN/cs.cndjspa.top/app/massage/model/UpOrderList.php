<?php
namespace app\massage\model;

use AlibabaCloud\Client\AlibabaCloud;
use app\BaseModel;
use Exception;
use think\facade\Db;

class UpOrderList extends BaseModel
{
    //定义表名
    protected $name = 'massage_service_up_order_list';



    protected $append = [


        'order_goods',


    ];
    /**
     * @author chenniang
     * @DataTime: 2021-03-19 17:05
     * @功能说明:子订单信息
     */

    public function getOrderGoodsAttr($value,$data){

        if(!empty($data['id'])){

            $order_goods_model = new UpOrderGoods();

            $dis = [

                'order_id' => $data['id'],

            ];

            $list = $order_goods_model->where($dis)->select()->toArray();

            return $list;

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

            Db::startTrans();

            $update = [

                'transaction_id' => $transaction_id,

                'pay_type'       => 2,

                'pay_time'       => time(),

            ];

            $res = $this->dataUpdate(['id'=>$order['id'],'transaction_id'=>''],$update);

            if($res==0){

                Db::rollback();

                return false;

            }
            //扣除余额
            if($order['balance']>0){

                $water_model = new BalanceWater();

                $res = $water_model->updateUserBalance($order,4);

                if($res==0){

                    Db::rollback();

                    return false;

                }
            }

            $order_price_log = new OrderPrice();
            //增加订单金额日志
            $order_price_log->logAdd($order,$order['order_id']);

            $res = $this->changeOrder($order);

            if($res==0){

                Db::rollback();

                return false;

            }

            Db::commit();

        }

        return true;

    }


    /**
     * @param $time_long
     * @param $order_id
     * @功能说明:校验加钟订单
     * @author chenniang
     * @DataTime: 2023-02-27 11:13
     */
    public function checkAddOrderTime($time_long,$order_id){

        $order_model = new Order();

        $where[] = ['pay_type','not in',[-1]];

        $where[] = ['add_pid','=',$order_id];

        $where[] = ['is_add','=',1];
        //目前加单只能一单一单对加 所以这里其实只有一条数据
        $order_list = $order_model->where($where)->field('id,coach_id,start_time,end_time,order_end_time,pay_type,add_pid')->select()->toArray();

        if(!empty($order_list)){

            foreach ($order_list as $value){

                $start_time = $value['start_time'] + $time_long;
                //校验时间
                $check = $order_model->checkTime($value,$start_time,$value['add_pid']);

                if(!empty($check['code'])){

                    return $check;

                }

            }

        }

        return true;

    }


    /**
     * @author chenniang
     * @DataTime: 2022-12-13 16:23
     * @功能说明:修改原来的订单
     */
    public function changeOrder($order){

        $order_model       = new Order();

        $order_goods_model = new OrderGoods();

        $up_goods_model    = new UpOrderGoods();

        $order_goods = $up_goods_model->where(['order_id'=>$order['id']])->field('*,goods_name as title,goods_cover as cover,goods_id as service_id')->select()->toArray();
        //添加订单商品
        $res = $order_goods_model->upOrderGoodsAdd($order_goods,$order['order_id'],$order['coach_id'],$order['user_id']);

        if($res==0){

            return false;
        }

        $goods_model = new Service();

        foreach ($order_goods as $v){

            $p_order_goods = $order_goods_model->dataInfo(['id'=>$v['order_goods_id']]);
            //退回销量
            $goods_model->setOrDelStock($p_order_goods['goods_id'],$v['num'],1);
            //说明全部升级
            if($v['num']>=$p_order_goods['num']){

                $res = $order_goods_model->dataUpdate(['id'=>$v['order_goods_id']],['status'=>-1]);

            }else{

                $update = [

                    'num' => $p_order_goods['num']-$v['num'],

                    'can_refund_num' => $p_order_goods['can_refund_num']-$v['num']
                ];

                $res = $order_goods_model->dataUpdate(['id'=>$v['order_goods_id']],$update);
            }

            if($res==0){

                return false;
            }
        }

        $p_order = $order_model->dataInfo(['id'=>$order['order_id']]);

        $order_update['time_long']          = $p_order['time_long'] + $order['time_long'];

        $order_update['true_time_long']     = $p_order['true_time_long'] + $order['time_long'];

        $order_update['end_time']           = $p_order['end_time'] + $order['time_long']*60;

        $order_update['pay_price']          = round($p_order['pay_price'] + $order['pay_price'],2);

        $order_update['service_price']      = round($p_order['service_price'] + $order['true_service_price'],2);

        $order_update['true_service_price'] = round($p_order['true_service_price'] + $order['true_service_price'],2);

        $order_update['init_service_price'] = round($p_order['init_service_price'] + $order['service_price'],2);

        $order_update['discount']           = round($p_order['discount'] - $order['discount'],2);

        $order_model->dataUpdate(['id'=>$order['order_id']],$order_update);

        $p_order = $order_model->dataInfo(['id'=>$order['order_id']]);

        $comm_model  = new Commission();

        $comm_model->where(['order_id'=>$order['order_id'],'status'=>1])->delete();
        //重新算佣金
        $order_update = $order_model->getCashData($p_order);

        $comm_model->dataUpdate(['order_id'=>$order['order_id'],'status'=>-1],['status'=>1]);

        $order_model->dataUpdate(['id'=>$order['order_id']],$order_update['order_data']);
        //更改加钟订单的时间
        $this->changeAddOrderTime($order['time_long']*60,$order['order_id']);

        return $res;
    }


    /**
     * @param $time_long
     * @param $order_id
     * @功能说明:更改加钟订单的时间
     * @author chenniang
     * @DataTime: 2023-02-27 11:54
     */
    public function changeAddOrderTime($time_long,$order_id){

        $order_model = new Order();

        $where[] = ['pay_type','not in',[-1]];

        $where[] = ['add_pid','=',$order_id];

        $where[] = ['is_add','=',1];
        //目前加单只能一单一单对加 所以这里其实只有一条数据
        $order_list = $order_model->where($where)->field('id,start_time,end_time,order_end_time,pay_type')->select()->toArray();

        if(!empty($order_list)){

            foreach ($order_list as $value){

                $update['start_time'] = $value['start_time'] + $time_long;

                $update['end_time'] = $value['end_time'] + $time_long;

                $order_model->dataUpdate(['id'=>$value['id']],$update);

            }

        }

        return true;

    }



    /**
     * @author chenniang
     * @DataTime: 2022-12-15 11:18
     * @功能说明:订单升级记录
     */
    public function orderUpRecord($order_id){

        $dis = [

            'order_id'=>$order_id,

            'pay_type'=>2
        ];

        $data = $this->where($dis)->order('id desc')->select()->toArray();

        return $data;

    }






}