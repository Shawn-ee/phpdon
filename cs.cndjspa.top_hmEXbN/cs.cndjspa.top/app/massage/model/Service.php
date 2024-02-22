<?php
namespace app\massage\model;

use app\BaseModel;
use think\facade\Db;

class Service extends BaseModel
{
    //定义表名
    protected $name = 'massage_service_service_list';


    protected $append = [

        'create_time_text',

      //  'coach'

    ];


//    /**
//     * @author chenniang
//     * @DataTime: 2021-07-06 23:52
//     * @功能说明:绑定的技师
//     */
//    public function getCoachAttr($value,$data){
//
//        if(!empty($data['id'])){
//
//            $coach_s_model = new ServiceCoach();
//
//            $coach_model = new Coach();
//
//            $list  = $coach_s_model->where(['ser_id'=>$data['id']])->column('coach_id');
//
//            $coach = $coach_model->where('id','in',$list)->where(['status'=>2])->field('id,coach_name,work_img')->select()->toArray();
//
//            return $coach;
//        }
//
//
//    }




    /**
     * @param $value
     * @param $data
     * @功能说明:
     * @author chenniang
     * @DataTime: 2021-03-23 11:12
     */
    public function getImgsAttr($value,$data){

        if(!empty($value)){

            return explode(',',$value);

        }

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-23 11:12
     * @功能说明:
     */
    public function getCreateTimeTextAttr($value,$data){

        if(!empty($data['create_time'])){

            return date('Y-m-d H:i:s',$data['create_time']);
        }

    }








    /**
     * @author chenniang
     * @DataTime: 2020-09-29 11:04
     * @功能说明:添加
     */
    public function dataAdd($data){

        $data['create_time'] = time();

        if(isset($data['sale'])){

            $data['total_sale'] = $data['sale'];
        }

//        $data['update_time'] = time();

        $coach = $data['coach'];

        unset($data['coach']);

        $data['imgs'] = !empty($data['imgs'])?implode(',',$data['imgs']):'';

        $res = $this->insert($data);

        $id  = $this->getLastInsID();

        $this->updateSome($id,$data['uniacid'],$coach);

        return $id;

    }


    /**
     * @author chenniang
     * @DataTime: 2020-09-29 11:05
     * @功能说明:编辑
     */
    public function dataUpdate($dis,$data){

//        $data['update_time'] = time();

        if(isset($data['coach'])){

            $coach = $data['coach'];

            unset($data['coach']);
        }

        if(isset($data['imgs'])){

            $data['imgs'] = !empty($data['imgs'])?implode(',',$data['imgs']):'';

        }

        if(isset($data['sale'])&&isset($data['true_sale'])){

            $data['total_sale'] = $data['sale']+$data['true_sale'];
        }

        $res = $this->where($dis)->update($data);

        if(isset($coach)){

            $this->updateSome($dis['id'],$data['uniacid'],$coach);
        }


        return $res;

    }


    /**
     * @param $id
     * @param $uniacid
     * @param $spe
     * @功能说明:
     * @author chenniang
     * @DataTime: 2021-03-23 13:35
     */
    public function updateSome($id,$uniacid,$coach){

        $s_model = new ServiceCoach();

        $s_model->where(['ser_id'=>$id])->delete();

        if(!empty($coach)){

            foreach ($coach as $value){

                $insert['coach_id'] = $value;

                $insert['uniacid']  = $uniacid;

                $insert['ser_id']   = $id;

                $s_model->dataAdd($insert);

            }

        }

        return true;

    }



//    /**
//     * @author chenniang
//     * @DataTime: 2020-09-29 11:05
//     * @功能说明:编辑
//     */
//    public function dataUpdate($dis,$data){
//
//        $res = $this->where($dis)->update($data);
//
//        return $res;
//
//    }


    /**
     * @author chenniang
     * @DataTime: 2020-09-29 11:06
     * @功能说明:列表
     */
    public function dataList($dis,$page){

        $data = $this->where($dis)->order('top desc,id desc')->paginate($page)->toArray();

        return $data;

    }


    /**
     * @author chenniang
     * @DataTime: 2020-09-29 11:06
     * @功能说明:列表
     */
    public function indexDataList($dis,$page,$sort){

        $data = $this->where($dis)->order("$sort,id desc")->paginate($page)->toArray();

        return $data;

    }









    /**
     * @author chenniang
     * @DataTime: 2020-09-29 11:43
     * @功能说明:
     */
    public function dataInfo($dis){

        $data = $this->where($dis)->find();

        if(!empty($data)){

            $data->toArray();

            $data['coach'] = $this->getServiceCoach($data['id']);

            return $data;
        }else{

            return [];
        }

    }


    /**
     * @author chenniang
     * @DataTime: 2020-09-29 11:43
     * @功能说明:
     */
    public function serviceInfo($dis){

        $data = $this->where($dis)->find();

        return !empty($data)?$data->toArray():[];


    }

    /**
     * @author chenniang
     * @DataTime: 2021-07-07 10:21
     * @功能说明:服务技师列表
     */
    public function serviceCoachList($dis){

        $data = $this->alias('a')
            ->join('massage_service_service_coach b','a.id = b.ser_id','left')
            ->where($dis)
            ->field(['a.*'])
            ->group('a.id')
            ->order('a.top desc,a.id desc')
            ->select()
            ->toArray();

        return $data;

    }


    /**
     * @author chenniang
     * @DataTime: 2022-09-15 16:20
     * @功能说明:获取销量最高的技师
     */
    public function getSaleTopOne($uniacid){

        $key = 'getSaleTopOnezzz';

        $data = getCache($key,$uniacid);

        if(!empty($data)){

            return $data;
        }

        $order_model = new Order();

        $coach_model = new Coach();

        $coach_id = $coach_model->where(['status'=>2,'uniacid'=>$uniacid])->column('id');

        $dis[] = ['pay_type','>',1];

        $dis[] = ['uniacid','=',$uniacid];

        $dis[] = ['coach_id','in',$coach_id];

        $data = $order_model->where($dis)->field('SUM(true_service_price) as all_price,coach_id')->whereTime('create_time','week')->group('coach_id')->order('all_price desc,id desc')->find();

        if(!empty($data)){

            setCache($key,$data->coach_id,10,$uniacid);

            return $data->coach_id;

        }else{

            return 0;
        }

    }


    /**
     * @author chenniang
     * @DataTime: 2022-09-15 16:20
     * @功能说明:获取最近其他的技师
     */
    public function getSaleTopSeven($uniacid){

        $coach_model = new Coach();

        $dis[] = ['status','=',2];

        $dis[] = ['uniacid','=',$uniacid];

        $data = $coach_model->where($dis)->whereTime('sh_time','-7 days')->column('id');

        return $data;

    }


    /**
     * @author chenniang
     * @DataTime: 2022-09-15 16:20
     * @功能说明:获取销量最高的技师
     */
    public function getSaleTopFive($uniacid,$coach_id){

      //  $coach_model = new Coach();

      //  $coach_id = $coach_model->where(['status'=>2,'uniacid'=>$uniacid])->where('id','<>',$coach_id)->column('id');

        $order_model = new Order();

        $dis[] = ['pay_type','>',1];

        $dis[] = ['uniacid','=',$uniacid];

        $dis[] = ['coach_id','<>',$coach_id];

        $data = $order_model->where($dis)->field('COUNT(id) as counts,coach_id')->whereTime('create_time','week')->group('coach_id')->order('counts desc,id desc')->limit(5)->select()->toArray();

        return array_column($data,'coach_id');

    }

    /**
     * @author chenniang
     * @DataTime: 2021-03-18 10:07
     * @功能说明:增加|减少库存 增加|减少销量
     */
    public function setOrDelStock($goods_id,$num,$type=2){

        if(empty($goods_id)){

            return true;
        }

        $goods_info = $this->dataInfo(['id'=>$goods_id]);
        //退货
        if($type==1){

            $update = [

                'true_sale' => $goods_info['true_sale']-$num,

                'total_sale'=> $goods_info['total_sale']-$num,

                'lock'      => $goods_info['lock']+1,

            ];
            //如果是售后增加退款数量
//            if($refund==1){
//
//                $update['refund_num'] = $goods_info['refund_num']+$num;
//            }
            //减销量 加退款数量
            $res = $this->where(['id'=>$goods_id,'lock'=>$goods_info['lock']])->update($update);

            if($res!=1){

                return ['code'=>500,'msg'=>'提交失败'];
            }

        }else{

            $update = [

                'true_sale' => $goods_info['true_sale']+$num,

                'total_sale'=> $goods_info['total_sale']+$num,

                'lock'      => $goods_info['lock']+1,

            ];
            //增加销量
            $res = $this->where(['id'=>$goods_id,'lock'=>$goods_info['lock']])->update($update);

            if($res!=1){

                return ['code'=>500,'msg'=>'提交失败'];
            }


        }

        return true;
    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-06 23:52
     * @功能说明:绑定的技师
     */
    public function getServiceCoach($ser_id){

        if(!empty($ser_id)){

            $coach_s_model = new ServiceCoach();

            $coach_model = new Coach();

            $list  = $coach_s_model->where(['ser_id'=>$ser_id])->column('coach_id');

            $coach = $coach_model->where('id','in',$list)->where(['status'=>2])->field('id,coach_name,work_img')->select()->toArray();

            return $coach;
        }


    }


}