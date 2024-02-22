<?php
namespace app\massage\model;

use app\BaseModel;
use think\facade\Db;

class CoachUpdate extends BaseModel
{
    //定义表名
    protected $name = 'massage_service_coach_update';







    /**
     * @author chenniang
     * @DataTime: 2021-03-15 14:37
     * @功能说明:后台列表
     */
    public function adminDataList($dis,$mapor,$page=10){

        $data = $this->alias('a')
                ->join('shequshop_school_user_list b','a.user_id = b.id')
                ->where($dis)
                ->where(function ($query) use ($mapor){
                    $query->whereOr($mapor);
                })
                ->field('a.*,b.nickName,b.avatarUrl')
                ->group('a.id')
                ->order('a.id desc')
                ->paginate($page)
                ->toArray();

        return $data;

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
    public function dataList($dis,$page=10,$mapor){

        $data = $this->where($dis)->where(function ($query) use ($mapor){
            $query->whereOr($mapor);
        })->order('distance asc,id desc')->paginate($page)->toArray();

        return $data;

    }




    /**
     * @author chenniang
     * @DataTime: 2020-09-29 11:43
     * @功能说明:
     */
    public function dataInfo($dis,$file='*'){

        $data = $this->where($dis)->field($file)->find();

        return !empty($data)?$data->toArray():[];

    }









}