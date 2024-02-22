<?php
namespace app\massage\model;

use app\BaseModel;
use think\facade\Db;

class CoachCollect extends BaseModel
{
    //定义表名
    protected $name = 'massage_service_coach_collect';






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



    /**
     * @author chenniang
     * @DataTime: 2021-07-07 22:41
     * @功能说明:教练收藏列表
     */

    public function coachCollectListTypeOne($input,$user_id,$uniacid){

        $lat = !empty($input['lat'])?$input['lat']:0;

        $lng = !empty($input['lng'])?$input['lng']:0;

        $dis[] = ['a.uniacid','=',$uniacid];

        $dis[] = ['a.status','=',2];

        $dis[] = ['b.user_id','=',$user_id];

        $dis[] = ['a.is_work','=',1];

        $shield_model = new ShieldList();

        $coach_model  = new Coach();

        $coach_id = $shield_model->where(['user_id'=>$user_id,'type'=>2])->column('coach_id');

        $dis[] = ['a.id','not in',$coach_id];
        //服务中
        $working_coach = $coach_model->getWorkingCoach($uniacid);
        //当前时间不可预约
        $cannot = CoachTimeList::getCannotCoach($uniacid);

        $working_coach = array_diff($working_coach,$cannot);

        $alh = 'ACOS(SIN(('.$lat.' * 3.1415) / 180 ) *SIN((a.lat * 3.1415) / 180 ) +COS(('.$lat.' * 3.1415) / 180 ) * COS((a.lat * 3.1415) / 180 ) *COS(('.$lng.' * 3.1415) / 180 - (a.lng * 3.1415) / 180 ) ) * 6378.137*1000 as distance';

        $data  = $coach_model->coachCollectList($dis,$alh);

        if(!empty($data['data'])){

            $config_model = new Config();

            $service_model= new Service();

            $config= $config_model->dataInfo(['uniacid'=>$uniacid]);
            //销冠
            $top   = $service_model->getSaleTopOne($uniacid);
            //销售单量前5
            $five  = $service_model->getSaleTopFive($uniacid,$top);
            //最近七天注册
            $seven = $service_model->getSaleTopSeven($uniacid);

            foreach ($data['data'] as &$v){

                $v['near_time'] = $coach_model->getCoachEarliestTime($v['id'],$config);

                if (in_array($v['id'],$working_coach)){

                    $text_type = 2;

                }elseif (!in_array($v['id'],$cannot)){

                    $text_type = 1;

                }else{

                    $text_type = 3;
                }

                $v['text_type'] = $text_type;

                if($v['id']==$top){

                    $v['coach_type_status'] = 1;

                }elseif (in_array($v['id'],$five)){

                    $v['coach_type_status'] = 2;

                }elseif (in_array($v['id'],$seven)){

                    $v['coach_type_status'] = 3;

                }else{

                    $v['coach_type_status'] = 0;

                }
            }

        }

        return $data;

    }



    /**
     * @author chenniang
     * @DataTime: 2021-07-07 22:41
     * @功能说明:教练收藏列表
     */

    public function coachCollectListTypeTow($input,$user_id,$uniacid){

        $lat = !empty($input['lat'])?$input['lat']:0;

        $lng = !empty($input['lng'])?$input['lng']:0;

        $dis[] = ['a.uniacid','=',$uniacid];

        $dis[] = ['a.status','=',2];

        $dis[] = ['b.user_id','=',$user_id];

        $shield_model = new ShieldList();

        $coach_id = $shield_model->where(['user_id'=>$user_id,'type'=>2])->column('coach_id');

        $dis[] = ['a.id','not in',$coach_id];

        $coach_model = new Coach();

        $coach_model->setIndexTopCoach($uniacid);

        $alh = 'ACOS(SIN(('.$lat.' * 3.1415) / 180 ) *SIN((a.lat * 3.1415) / 180 ) +COS(('.$lat.' * 3.1415) / 180 ) * COS((a.lat * 3.1415) / 180 ) *COS(('.$lng.' * 3.1415) / 180 - (a.lng * 3.1415) / 180 ) ) * 6378.137*1000 as distance';

        $data  = $coach_model->typeCoachCollectList($dis,$alh);

        if(!empty($data['data'])){

            $config_model = new Config();

            $service_model= new Service();

            $config= $config_model->dataInfo(['uniacid'=>$uniacid]);
            //销冠
            $top   = $service_model->getSaleTopOne($uniacid);
            //销售单量前5
            $five  = $service_model->getSaleTopFive($uniacid,$top);
            //最近七天注册
            $seven = $service_model->getSaleTopSeven($uniacid);

            foreach ($data['data'] as &$v){

                $v['near_time']  = $coach_model->getCoachEarliestTime($v['id'],$config);

                if ($v['is_work']==0){

                    $text_type = 4;

                }elseif ($v['index_top']==1){

                    $text_type = 1;

                }else{

                    $text_type = 3;
                }

                $v['text_type'] = $text_type;

                if($v['id']==$top){

                    $v['coach_type_status'] = 1;

                }elseif (in_array($v['id'],$five)){

                    $v['coach_type_status'] = 2;

                }elseif (in_array($v['id'],$seven)){

                    $v['coach_type_status'] = 3;

                }else{

                    $v['coach_type_status'] = 0;

                }
            }

        }

        return $data;

    }




}