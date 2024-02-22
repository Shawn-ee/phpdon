<?php
namespace app\massage\model;

use app\BaseModel;
use think\facade\Db;

class Car extends BaseModel
{
    //定义表名
    protected $name = 'massage_service_car';


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

        return !empty($data)?$data->toArray():[];

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-18 17:21
     * @功能说明:购物车价格
     */
    public function carPriceAndCount($user_id,$cap_id,$is_car=0,$order_id=0){

        $list = $this->carList($user_id,$cap_id,0,$order_id);

        $data['list'] = $this->carList($user_id,$cap_id,$is_car,$order_id);

        if(!empty($list)){

            $data['car_price'] = round(array_sum(array_column($list,'all_price')),2);

            $data['car_count'] = array_sum(array_column($list,'num'));

            $data['total_discount'] = 0;

            $data['coupon_id'] = 0;

        }else{

            $data['car_price'] = 0;

            $data['car_count'] = 0;

            $data['total_discount'] = 0;

            $data['coupon_id'] = 0;

        }

        return $data;
    }



    /**
     * @author chenniang
     * @DataTime: 2021-03-18 17:35
     * @功能说明:购物车列表
     */
    public function carList($user_id,$cap_id,$all=0,$order_id=0){

        $dis = [

            'a.user_id' => $user_id,

            'a.coach_id'=> $cap_id,

            'b.status'  => 1,

            'a.order_id'=> $order_id,

        ];

        if(!empty($cap_id)){

            $dis['c.coach_id'] = $cap_id;

        }

        if($all==0){

            $dis['a.status'] = 1;
        }

        $data = $this->alias('a')
                ->join('massage_service_service_list b','a.service_id = b.id')
                ->join('massage_service_service_coach c','b.id = c.ser_id','left')
                ->where($dis)
                ->field('a.id,a.status,a.uniacid,a.num,b.total_sale,b.time_long,b.title,b.cover,b.price,ROUND(b.price*a.num,2) as all_price,ROUND(b.price*a.num,2) as true_price,a.service_id')
                ->group('a.id')
                ->select()
                ->toArray();

        return $data;

    }







}