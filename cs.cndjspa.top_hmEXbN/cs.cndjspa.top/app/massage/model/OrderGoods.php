<?php
namespace app\massage\model;

use app\BaseModel;
use Darabonba\GatewaySpi\Models\InterceptorContext\response;
use think\facade\Db;

class OrderGoods extends BaseModel
{
    //定义表名
    protected $name = 'massage_service_order_goods_list';


    protected $append = [

        'refund_num',

        'service_id'
    ];


    /**
     * @param $value
     * @param $data
     * @功能说明:
     * @author chenniang
     * @DataTime: 2023-02-28 15:21
     */
    public function getServiceIdAttr($value,$data){

        if(isset($data['goods_id'])){

            return $data['goods_id'];
        }


    }


    /**
     * @param $value
     * @param $data
     * @功能说明:获取退款的数量
     * @author chenniang
     * @DataTime: 2021-04-12 10:46
     */
    public function getRefundNumAttr($value,$data){

        if(!empty($data['id'])){

            $refund_model = new RefundOrder();

            $num = $refund_model->refundNum($data['id']);

            return $num;
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
     * @DataTime: 2020-09-29 11:06
     * @功能说明:列表
     */
    public function dataSelect($dis){

        $data = $this->where($dis)->order('id desc')->select()->toArray();

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
     * @DataTime: 2021-03-22 11:12
     * @功能说明:添加商品子订单
     */
    public function orderGoodsAdd($order_goods,$order_id,$cap_id,$user_id){

        $goods_model = new Service();

        $car_model   = new Car();

        foreach ($order_goods as $v){

            $ser_status = $goods_model->where(['id'=>$v['service_id']])->value('status');

            if($ser_status!=1){

                return ['code'=>500,'msg'=>'服务已经下架'];
            }

            $insert = [

                'uniacid'        => $v['uniacid'],

                'order_id'       => $order_id,

                'user_id'        => $user_id,

                'pay_type'       => 1,

                'coach_id'       => $cap_id,

                'goods_name'     => $v['title'],

                'goods_cover'    => $v['cover'],

                'price'          => $v['price'],

                'true_price'     => round($v['true_price']/$v['num'],5),

                'time_long'      => $v['time_long'],

                'num'            => $v['num'],

                'can_refund_num' => $v['num'],

                'goods_id'       => $v['service_id'],


            ];

            $res = $this->dataAdd($insert);

            if($res!=1){

                return ['code'=>500,'msg'=>'下单失败'];
            }
            //减少库存 增加销量
            $res = $goods_model->setOrDelStock($v['service_id'],$v['num']);

            if(!empty($res['code'])){

                return $res;
            }

        }
        //删除购物车
        $car_model->where(['user_id'=>$user_id,'coach_id'=>$cap_id,'status'=>1])->delete();

        return true;

    }



    /**
     * @author chenniang
     * @DataTime: 2021-03-22 11:12
     * @功能说明:升级订单添加商品子订单
     */
    public function upOrderGoodsAdd($order_goods,$order_id,$cap_id,$user_id){

        foreach ($order_goods as $v){

            $dis = [

                'goods_name'   => $v['title'],

                'goods_cover'  => $v['cover'],

                'price'        => $v['price'],

                'true_price'   => $v['true_price'],

                'time_long'    => $v['time_long'],

                'order_id'     => $order_id,

            ];

            $find = $this->dataInfo($dis);

            if(empty($find)){

                $insert = [

                    'uniacid'        => $v['uniacid'],

                    'order_id'       => $order_id,

                    'user_id'        => $user_id,

                    'pay_type'       => 1,

                    'coach_id'       => $cap_id,

                    'goods_name'     => $v['title'],

                    'goods_cover'    => $v['cover'],

                    'price'          => $v['price'],

                    'true_price'     => $v['true_price'],

                    'time_long'      => $v['time_long'],

                    'num'            => $v['num'],

                    'can_refund_num' => $v['num'],

                    'goods_id'       => $v['service_id'],

                ];

                $res = $this->dataAdd($insert);

            }else{

                $res = $this->dataUpdate(['id'=>$find['id']],['num'=>$find['num']+$v['num']]);
            }

        }

        return $res;

    }
    /**
     * @author chenniang
     * @DataTime: 2022-12-13 11:17
     * @功能说明:获取升级的价格
     */
    public function getUpGoodsData($order_goods_list){

        $service_model = new Service();

        $order_goods_model = new OrderGoods();

        foreach ($order_goods_list as &$v){
            //原项目信息
            $order_goods = $order_goods_model->dataInfo(['id'=>$v['order_goods_id']]);

            if(empty($order_goods)){

                return ['code'=>500,'msg'=>'升级商品错误'];
            }
            //新项目
            $service = $service_model->serviceInfo(['id'=>$v['service_id']]);

            $v = array_merge($service,$v);

            $num[$v['order_goods_id']] = !empty($num[$v['order_goods_id']])?$num[$v['order_goods_id']]+$v['num']:$v['num'];
            //校验数量
            if($num[$v['order_goods_id']]>$order_goods['num']){

                return ['code'=>500,'msg'=>'升级商品数量错误错误'];

            }
            //校验价格
            if($v['price']<$order_goods['true_price']){

                return ['code'=>500,'msg'=>'只能选择价格更高的服务，请刷新重新选择'];

            }
            //校验项目
            if($order_goods['goods_id']==$v['service_id']){

                return ['code'=>500,'msg'=>'不能升级本来项目'];

            }
            //项目价格
            $v['true_price'] = $v['price']*$v['num'];
            //支付价格(差价)
            $v['pay_price']  = round(($v['price'] - $order_goods['true_price'])*$v['num'],2);
            //总时长
            $v['total_time_long'] = $v['time_long']*$v['num'];
            //相差时长
            $v['del_time_long'] = ($v['time_long'] - $order_goods['time_long'])*$v['num'];
            //原价
            $goods_price        = $v['num']*$order_goods['price'];

            $true_goods_price   = $v['num']*$order_goods['true_price'];
            //相差的服务价格
            $v['service_price'] = round($v['true_price'] - $goods_price,2);

            $v['true_service_price'] = round($v['true_price'] - $true_goods_price,2);
            //原服务的时长
            $v['old_time_long'] = $order_goods['time_long']*$v['num'];
            //原项目的折扣
            $v['old_discount']  = ($order_goods['price'] - $order_goods['true_price'])*$v['num'];
        }

        $data['order_goods']     = $order_goods_list;

        $data['order_price']     = round(array_sum(array_column($order_goods_list,'true_price')),2);

        $data['service_price']   = round(array_sum(array_column($order_goods_list,'service_price')),2);

        $data['true_service_price']   = round(array_sum(array_column($order_goods_list,'true_service_price')),2);

        $data['pay_price']       = round(array_sum(array_column($order_goods_list,'pay_price')),2);

        $data['total_time_long'] = array_sum(array_column($order_goods_list,'total_time_long'));
        //相差时长
        $data['time_long']       = array_sum(array_column($order_goods_list,'del_time_long'));

        $data['old_time_long']   = array_sum(array_column($order_goods_list,'old_time_long'));

        $data['discount']        = array_sum(array_column($order_goods_list,'old_discount'));

        return $data;
    }









}