<?php
namespace app\massage\model;

use app\BaseModel;
use think\facade\Db;

class OrderAddress extends BaseModel
{
    //定义表名
    protected $name = 'massage_service_order_address';





//    public function getMobileAttr($value,$data){
//
//        return  substr_replace($value, "****", 2,4);
//
//    }
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
     * @DataTime: 2021-03-22 10:34
     * @功能说明:添加下单地址
     */
    public function orderAddressAdd($address_id,$order_id){

        if(empty($address_id)){

            return ['code'=>500,'msg'=>'请选择下单地址'];
        }

        $address_model = new Address();

        $address = $address_model->dataInfo(['id'=>$address_id]);

        if(empty($address)){

            return ['code'=>500,'msg'=>'下单地址已删除'];

        }

        $insert = [

            'uniacid'  => $address['uniacid'],

            'order_id' => $order_id,

            'user_name'=> $address['user_name'],

            'mobile'   => $address['mobile'],

            'province' => $address['province'],

            'city'     => $address['city'],

            'area'     => $address['area'],

            'lng'     => $address['lng'],

            'lat'      => $address['lat'],

            'address'  => $address['address'],

            'address_id'  => $address_id,

            'address_info' => $address['address_info'],

        ];

        $res = $this->dataAdd($insert);

        if($res!=1){

            return ['code'=>500,'msg'=>'下单失败'];

        }

        return $res;

    }






}