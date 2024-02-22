<?php
namespace app\massage\model;

use app\BaseModel;
use think\facade\Db;

class ShieldList extends BaseModel
{
    //定义表名
    protected $name = 'massage_shield_list';


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

        $data = $this->alias('a')
                ->join('massage_service_coach_list b','a.coach_id = b.id','left')
                ->where($dis)
                ->field('a.*,b.coach_name,b.work_img')
                ->group('a.id')
                ->order('a.id desc')
                ->paginate($page)
                ->toArray();

        return $data;

    }


    /**
     * @author chenniang
     * @DataTime: 2020-09-29 11:06
     * @功能说明:列表
     */
    public function dataUserList($dis,$page=10){

        $data = $this->alias('a')
            ->join('massage_service_user_list b','a.user_id = b.id','left')
            ->where($dis)
            ->field('a.*,b.nickName,b.avatarUrl')
            ->group('a.id')
            ->order('a.id desc')
            ->paginate($page)
            ->toArray();

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












}