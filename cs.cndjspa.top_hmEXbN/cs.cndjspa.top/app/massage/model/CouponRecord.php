<?php
namespace app\massage\model;

use app\BaseModel;
use think\facade\Db;

class CouponRecord extends BaseModel
{
    //定义表名
    protected $name = 'massage_service_coupon_record';


    protected $append = [

        'service'
    ];


    /**
     * @author chenniang
     * @DataTime: 2021-07-11 01:54
     * @功能说明:
     */
    public function getServiceAttr($value,$data){

        if(!empty($data['id'])){

            $id = !empty($data['pid'])?$data['pid']:$data['id'];

            $ser_model = new Service();

            $dis = [

                'a.status'    => 1,

                'b.coupon_id' => $id,

                'b.type'      => 1
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
     * @DataTime: 2021-03-15 14:37
     * @功能说明:后台列表
     */
    public function adminDataList($dis,$page=10,$where=[]){

        $data = $this->alias('a')
                ->join('shequshop_school_cap_list b','a.cap_id = b.id')
                ->where($dis)
                ->where(function ($query) use ($where){
                    $query->whereOr($where);
                })
                ->field('a.*,b.store_name,b.store_img,b.name,b.mobile')
                ->group('a.id')
                ->order('a.id desc')
                ->paginate($page)
                ->toArray();

        return $data;

    }

    /**
     * @author chenniang
     * @DataTime: 2021-03-15 14:37
     * @功能说明:后台审核详情
     */
    public function adminDataInfo($dis){

        $data = $this->alias('a')
            ->join('shequshop_school_cap_list b','a.cap_id = b.id')
            ->where($dis)
            ->field('a.*,b.store_name,b.store_img,b.school_name,b.mobile')
            ->find();

        return !empty($data)?$data->toArray():[];

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
     * @DataTime: 2021-04-08 17:08
     * @功能说明:审核中
     */
    public function shIng($cap_id){

        $dis = [

            'cap_id' => $cap_id,

            'status' => 1
        ];

        $count = $this->where($dis)->count();

        return $count;

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
     * @DataTime: 2021-07-06 00:02
     * @功能说明:用户订单数
     */
    public function couponCount($user_id){

        $dis[] = ['user_id','=',$user_id];

        $dis[] = ['status','=',1];

        $dis[] = ['end_time','>',time()];

        $data = $this->where($dis)->sum('num');

        return $data;

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-08 11:57
     * @功能说明:初始化
     */
    public function initCoupon($uniacid){

        $dis[] = ['status','=',1];

        $dis[] = ['uniacid','=',$uniacid];

        $dis[] = ['end_time','<',time()];

        $res = $this->dataUpdate($dis,['status'=>3]);

        return $res;

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-12 15:36
     * @功能说明:派发优惠券
     */
    public function recordAdd($coupon_id,$user_id,$num=1){

        $coupon_model = new Coupon();

        $coupon = $coupon_model->dataInfo(['id'=>$coupon_id]);

        if($coupon['send_type']==2&&$coupon['stock']<$num){

            return ['code'=>500,'msg'=>'库存不足'];
        }

        $insert = [

            'uniacid'   => $coupon['uniacid'],

            'user_id'   => $user_id,

            'coupon_id' => $coupon_id,

            'title'     => $coupon['title'],

            'type'      => $coupon['type'],

            'full'      => $coupon['full'],

            'discount'  => $coupon['discount'],

            'rule'      => $coupon['rule'],

            'text'      => $coupon['text'],

            'num'       => $num,

            'start_time'=> $coupon['time_limit']==1?time():$coupon['start_time'],

            'end_time'  => $coupon['time_limit']==1?time()+$coupon['day']*86400:$coupon['end_time'],

        ];

        $res = $this->dataAdd($insert);

        if($res==0){

            return $res;
        }

        $record_id = $this->getLastInsID();

        if($coupon['send_type']==2){

            //修改优惠券库存
            $res = $coupon_model->dataUpdate(['id'=>$coupon_id,'i'=>$coupon['i']],['stock'=>$coupon['stock']-$num,'i'=>$coupon['i']+1]);

            if($res==0){

                return $res;
            }
        }

        if(!empty($coupon['service'])){

            foreach ($coupon['service'] as $value){

                $insert = [

                    'uniacid' => $coupon['uniacid'],

                    'type'    => 1,

                    'goods_id'=> $value['goods_id'],

                    'coupon_id'=> $record_id
                ];

                $coupon_goods_model = new CouponService();

                $res = $coupon_goods_model->insert($insert);

            }

        }

        return $res;

    }


    /**
     * @author chenniang
     * @DataTime: 2021-08-29 23:02
     * @功能说明:退换优惠券
     */
    public function couponRefund($order_id){

        $order_model = new Order();

        $coupon_id   = $order_model->where(['id'=>$order_id])->value('coupon_id');

        if(!empty($coupon_id)){

            $this->dataUpdate(['id'=>$coupon_id],['status'=>1,'use_time'=>0,'order_id'=>0]);

        }

        return true;

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-13 09:34
     * @功能说明:使用优惠券
     */
    public function couponUse($coupon_id,$order_id){

        $record = $this->dataInfo(['id'=>$coupon_id]);

        if($record['num']>1){

            $this->dataUpdate(['id'=>$coupon_id],['num'=>$record['num']-1]);

            unset($record['id']);

            if(isset($record['service'])){

                unset($record['service']);
            }

            $record['pid']      = $coupon_id;

            $record['num']      = 1;

            $record['status']   = 2;

            $record['use_time'] = time();

            $record['order_id'] = $order_id;

            $this->insert($record);

            $coupon_id = $this->getLastInsID();

        }else{

             $this->dataUpdate(['id'=>$coupon_id],['status'=>2,'use_time'=>time(),'order_id'=>$order_id]);

        }

        return $coupon_id;

    }









}