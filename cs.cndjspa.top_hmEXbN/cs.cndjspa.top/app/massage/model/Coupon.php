<?php
namespace app\massage\model;

use app\BaseModel;
use think\facade\Db;

class Coupon extends BaseModel
{
    //定义表名
    protected $name = 'massage_service_coupon';


    protected $append = [

        'service',

        'send_count'

    ];


    /**
     * @author chenniang
     * @DataTime: 2021-07-15 15:22
     * @功能说明:已派发多少张
     */
    public function getSendCountAttr($value,$data){

        if(!empty($data['id'])){

            $record_model = new CouponRecord();

            $count = $record_model->where(['coupon_id'=>$data['id']])->sum('num');

            return $count;

        }

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-11 01:54
     * @功能说明:
     */
    public function getServiceAttr($value,$data){

        if(!empty($data['id'])){

            $ser_model = new Service();

            $dis = [
                'a.status' => 1,

                'b.coupon_id' => $data['id'],

                'b.type' => 0
            ];

            $list =  $ser_model->alias('a')
                    ->join('massage_service_coupon_goods b','b.goods_id = a.id')
                    ->where($dis)
                    ->field('a.id,a.title,a.price,b.goods_id')
                    ->group('a.id')
                    ->order('a.top desc,a.id desc')
                    ->select()
                    ->toArray();

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

        $service = $data['service'];

        unset($data['service']);

        $res = $this->insert($data);

        $id  = $this->getLastInsID();

        $this->updateSome($id,$data['uniacid'],$service);

        return $id;

    }



    /**
     * @author chenniang
     * @DataTime: 2020-09-29 11:05
     * @功能说明:编辑
     */
    public function dataUpdate($dis,$data){


//        $data['update_time'] = time();

        if(isset($data['service'])){

            $service = $data['service'];

            unset($data['service']);
        }

        $res = $this->where($dis)->update($data);

        if(isset($service)){

            $this->updateSome($dis['id'],$data['uniacid'],$service);
        }


        return $res;

    }


    /**
     * @param $id
     * @param $uniacid
     * @param $spe
     * @功能说明:
     * @author chenniang
     * @DataTime: 2021-03-23 13:35
     */
    public function updateSome($id,$uniacid,$goods){

        $s_model = new CouponService();

        $s_model->where(['coupon_id'=>$id])->delete();

        if(!empty($goods)){

            foreach ($goods as $value){

                $insert['uniacid']   = $uniacid;

                $insert['coupon_id'] = $id;

                $insert['goods_id']  = $value;

                $s_model->dataAdd($insert);

            }

        }

        return true;

    }

    /**
     * @author chenniang
     * @DataTime: 2020-09-29 11:06
     * @功能说明:列表
     */
    public function dataList($dis,$page){

        $data = $this->where($dis)->order('top desc,id desc')->paginate($page)->toArray();

        return $data;

    }


    /**
     * @author chenniang
     * @DataTime: 2020-09-29 11:43
     * @功能说明:
     */
    public function dataInfo($dis,$filed='*'){

        $data = $this->where($dis)->field($filed)->find();

        return !empty($data)?$data->toArray():[];

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-09 23:22
     * @功能说明:计算优惠券可以优惠多少钱
     */

    public function getDicountPrice($order_goods,$coupon_id){

        $coupon_se_model = new CouponService();

        $goods_id = $coupon_se_model->where(['coupon_id'=>$coupon_id,'type'=>1])->column('goods_id');

        $price = 0;

        foreach ($order_goods as $v){

            if(in_array($v['service_id'],$goods_id)){

                $price += $v['all_price'];
            }

        }

        $data['discount']   = $price;

        $data['service_id'] = $goods_id;

        return $data;

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-09 23:37
     * @功能说明:订单优惠券
     */
    public function orderCouponData($order_goods,$coupon_id){

        if(empty($coupon_id)){

            return $order_goods;
        }

        $coupon_record_model = new CouponRecord();

        $info = $coupon_record_model->dataInfo(['id'=>$coupon_id]);
        //是否被使用或者过期
        if(empty($info)||$info['status']!=1){

            return $order_goods;
        }

        if($info['start_time']<time()&&$info['end_time']>time()){

            $p_coupon_id = !empty($info['pid'])?$info['pid']:$coupon_id;

            $can_discount_price = $this->getDicountPrice($order_goods['list'],$p_coupon_id);
            //是否满足满减条件
            if($info['full']>$can_discount_price['discount']){

                return $order_goods;
            }

            $total_discount = 0;

            foreach ($order_goods['list'] as &$v){
                //如果该商品可以使用优惠券
                if(in_array($v['service_id'],$can_discount_price['service_id'])){

                    $bin = $v['true_price']/$can_discount_price['discount'];
                    //该商品减去的折扣
                    $discount = $bin*$info['discount']<$v['true_price']?$bin*$info['discount']:$v['true_price'];
                    //总计折扣
                    $total_discount+=$discount;

                    $v['true_price'] = round($v['true_price']-$discount,2);

                }

            }

            $total_discount = $info['full']>$info['discount']?$info['discount']:round($total_discount,2);

            $order_goods['total_discount'] = $total_discount;

            $order_goods['coupon_id'] = $coupon_id;

        }

        return $order_goods;
    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-13 11:58
     * @功能说明:用户可用的优惠券
     */
    public function canUseCoupon($user_id,$coach_id){

        $coupon_model = new CouponRecord();

        $coupon_model->where(['user_id'=>$user_id,'status'=>1])->where('end_time','<',time())->update(['status'=>3]);

        $list = $coupon_model->where(['user_id'=>$user_id,'status'=>1])->order('discount desc,id desc')->select()->toArray();

        $car_model = new Car();
        //获取购物车里面的信息
        $car_list  = $car_model->carPriceAndCount($user_id,$coach_id,1);

        $car_list  = $car_list['list'];

        $data = [];

        if(!empty($list)){

            foreach ($list as &$v){

                if($v['start_time']<time()&&$v['end_time']>time()){

                    $id = !empty($v['pid'])?$v['pid']:$v['id'];

                    $info = $this->getDicountPrice($car_list,$id);
                    //无门槛
                    if($v['type']==1){

                        $v['full'] = 0;
                    }

                    if($v['full']<=$info['discount']&&$info['discount']>0){

                        $data[] = $v['id'];

                    }
                }

            }

        }

        return $data;

    }







}