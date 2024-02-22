<?php
namespace app\massage\model;

use app\BaseModel;
use think\facade\Db;

class CarPrice extends BaseModel
{
    //定义表名
    protected $name = 'massage_service_car_price';


    protected $append = [

        'city_name'
    ];


    /**
     * @param $value
     * @param $data
     * @功能说明:
     * @author chenniang
     * @DataTime: 2023-02-02 16:33
     */
    public function getCityNameAttr($value,$data){

        if(!empty($data['city_id'])){

            $city_model = new City();

            $name = $city_model->where(['id'=>$data['city_id']])->value('title');

            return $name;

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

        if(empty($data)){

            $this->dataAdd($dis);

            $data = $this->where($dis)->find();

        }

        return !empty($data)?$data->toArray():[];

    }


    /**
     * @param $uniacid
     * @param $city_id
     * @功能说明:获取城市车费配置
     * @author chenniang
     * @DataTime: 2023-02-08 10:08
     */
    public function getCityConfig($uniacid,$city_id){

        $dis = [

            'uniacid' => $uniacid,

            'city_id' => $city_id,

            'status'  => 1
        ];

        $data = $this->where($dis)->find();

        if(!empty($data)){

            $data = $data->toArray();
        }else{

            $data = $this->dataInfo(['uniacid'=>$uniacid]);
        }

        return $data;
    }







}