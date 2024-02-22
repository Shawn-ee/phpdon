<?php
namespace app\massage\model;

use app\BaseModel;
use app\massage\model\User;
use think\facade\Db;

class DistributionList extends BaseModel
{



    protected $name = 'massage_distribution_list';




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

        return !empty($data)?$data->toArray():[];

    }




    /**
     * @param $user_id
     * @param int $type
     * @功能说明:团队人数
     * @author chenniang
     * @DataTime: 2022-07-28 17:58
     */
    public function teamCount($user_id,$type=1){

        $user_model = new User();

        $dis[] = ['is_fx','=',1];

        if($type==1){

            $dis[] = ['pid','=',$user_id];

        }else{

            $top_id = $user_model->where(['pid'=>$user_id,'is_fx'=>1])->column('id');

            $dis[] = ['pid','in',$top_id];

        }

        $data = $user_model->where($dis)->count();

        return $data;

    }

    /**
     * @author chenniang
     * @DataTime: 2021-12-30 11:26
     * @功能说明:后台列表
     */
    public function adminDataList($dis,$page=10,$where=[]){

        $data = $this->alias('a')
            ->join('massage_service_user_list b','a.user_id = b.id','left')
            ->where($dis)
            ->where(function ($query) use ($where){
                $query->whereOr($where);
            })
            ->field('a.*,b.nickName,b.avatarUrl')
            ->group('a.id')
            ->order('a.id desc')
            ->paginate($page)
            ->toArray();

        return $data;

    }


    /**
     * @param $dis
     * @param int $page
     * @功能说明:用户收益列表
     * @author chenniang
     * @DataTime: 2022-07-29 14:50
     */
    public function userProfitList($dis,$page=10,$where=[]){

        $user_model = new User();

        $data = $user_model->alias('a')
                ->join('massage_distribution_list b','a.id = b.user_id','left')
                ->where($dis)
                ->where(function ($query) use ($where){
                    $query->whereOr($where);
                })
                ->field('b.*,a.nickName,a.avatarUrl,a.fx_cash')
                ->group('a.id')
                ->order('a.id desc')
                ->paginate($page)
                ->toArray();

        return $data;
    }


    /**
     * @param $dis
     * @param int $page
     * @功能说明:用户收益列表
     * @author chenniang
     * @DataTime: 2022-07-29 14:50
     */
    public function userProfitSelect($dis,$where=[]){

        $user_model = new User();

        $data = $user_model->alias('a')
            ->join('massage_distribution_list b','a.id = b.user_id','left')
            ->where($dis)
            ->where(function ($query) use ($where){
                $query->whereOr($where);
            })
            ->field('b.*,a.nickName,a.avatarUrl,a.fx_cash')
            ->group('a.id')
            ->order('a.id desc')
            ->select()
            ->toArray();

        return $data;
    }




}