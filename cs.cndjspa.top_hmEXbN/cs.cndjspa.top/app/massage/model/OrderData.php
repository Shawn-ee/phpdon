<?php
namespace app\massage\model;

use AlibabaCloud\Client\AlibabaCloud;
use app\BaseModel;
use Exception;
use think\facade\Db;

class OrderData extends BaseModel
{
    //定义表名
    protected $name = 'massage_service_order_list_data';


//    /**
//     * @param $value
//     * @param $data
//     * @功能说明:
//     * @author chenniang
//     * @DataTime: 2022-12-19 13:33
//     */
//    public function getSignTimeAttr($value,$data){
//
//        if (isset($value)){
//
//            return !empty($value)?date('Y-m-d H:i:s',$value):'';
//        }
//
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

        $data = $this->where($dis)->field('sign_time,sign_img')->find();

        if(empty($data)){

            $this->dataAdd($dis);

            $data = $this->where($dis)->field('sign_time,sign_img')->find();

        }

        return !empty($data)?$data->toArray():[];

    }





}