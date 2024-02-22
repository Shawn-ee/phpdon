<?php
namespace app\massage\model;

use app\BaseModel;
use think\facade\Db;

class Integral extends BaseModel
{
    //定义表名
    protected $name = 'massage_integral_list';




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

        return $data;

    }


    /**
     * @author chenniang
     * @DataTime: 2023-02-23 16:42
     * @功能说明:
     */
    public function coachDataList($dis,$page=10,$month=''){

        if(!empty($month)){

            $firstday = date('Y-m-01', $month);

            $lastday  = date('Y-m-d H:i:s', strtotime("$firstday +1 month")-1);

            $data = $this->where($dis)->whereTime('create_time','<=',$lastday)->order('create_time desc,id desc')->paginate($page)->toArray();
        }else{

            $data = $this->where($dis)->order('create_time desc,id desc')->paginate($page)->toArray();
        }

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
     * @DataTime: 2021-03-19 16:08
     * @功能说明:开启默认
     */
    public function updateOne($id){

        $user_id = $this->where(['id'=>$id])->value('user_id');

        $res = $this->where(['user_id'=>$user_id])->where('id','<>',$id)->update(['status'=>0]);

        return $res;
    }






}