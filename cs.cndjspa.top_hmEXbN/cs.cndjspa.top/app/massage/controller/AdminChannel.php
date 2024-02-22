<?php
namespace app\massage\controller;
use app\AdminRest;
use app\massage\model\BalanceCard;
use app\massage\model\BalanceOrder;
use app\massage\model\ChannelCate;
use app\massage\model\ChannelList;
use app\massage\model\Coupon;
use app\massage\model\User;
use app\shop\model\Article;
use app\shop\model\Banner;
use app\shop\model\Cap;
use app\shop\model\Date;
use app\shop\model\MsgConfig;
use app\shop\model\OrderAddress;
use app\shop\model\OrderGoods;
use app\shop\model\RefundOrder;
use app\shop\model\RefundOrderGoods;
use app\shop\model\Wallet;
use think\App;
use app\shop\model\Order as Model;
use think\facade\Db;


class AdminChannel extends AdminRest
{


    protected $model;

    protected $cate_model;

    public function __construct(App $app) {

        parent::__construct($app);

        $this->model = new ChannelList();

        $this->cate_model = new ChannelCate();


    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-04 19:09
     * @功能说明:类目列表
     */
    public function cateList(){

        $input = $this->_param;

        $dis[] = ['uniacid','=',$this->_uniacid];

        $dis[] = ['status','>',-1];

        if(!empty($input['title'])){

            $dis[] = ['title','like','%'.$input['title'].'%'];

        }

        $data = $this->cate_model->dataList($dis,$input['limit']);

        return $this->success($data);

    }



    /**
     * @author chenniang
     * @DataTime: 2022-08-30 14:54
     * @功能说明:渠道商下拉
     */
    public function cateSelect(){

        $input = $this->_param;

        $dis[] = ['uniacid','=',$this->_uniacid];

        $dis[] = ['status','=',1];

        $data = $this->cate_model->where($dis)->select()->toArray();

        return $this->success($data);

    }
    /**
     * @author chenniang
     * @DataTime: 2022-08-30 10:53
     * @功能说明:添加类目
     */
    public function cateAdd(){

        $input = $this->_input;

        $input['uniacid'] = $this->_uniacid;

        $res = $this->cate_model->dataAdd($input);

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-08-30 10:53
     * @功能说明:添加类目
     */
    public function cateUpdate(){

        $input = $this->_input;

        $dis = [

            'id' => $input['id']
        ];

        $input['uniacid'] = $this->_uniacid;

        $res = $this->cate_model->dataUpdate($dis,$input);

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-08-30 10:56
     * @功能说明:分类详情
     */
    public function cateInfo(){

        $input = $this->_param;

        $dis = [

            'id' => $input['id']
        ];

        $res = $this->cate_model->dataInfo($dis);

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-08-30 14:54
     * @功能说明:渠道商下拉
     */
    public function channelSelect(){

        $input = $this->_param;

        $dis[] = ['uniacid','=',$this->_uniacid];

        $dis[] = ['status','in',[2,3]];

        $data = $this->model->where($dis)->field('id,user_name')->select()->toArray();

        return $this->success($data);

    }




    /**
     * @author chenniang
     * @DataTime: 2022-08-30 11:30
     * @功能说明:渠道商列表
     */
    public function channelList(){

        $input = $this->_param;

        $dis[] = ['a.uniacid','=',$this->_uniacid];

        if(!empty($input['status'])){

            $dis[] = ['a.status','=',$input['status']];

        }else{

            $dis[] = ['a.status','>',-1];

        }

        if(!empty($input['start_time'])&&!empty($input['end_time'])){

            $start_time = $input['start_time'];

            $end_time   = $input['end_time'];

            $dis[] = ['a.create_time','between',"$start_time,$end_time"];

        }

        $where = [];

        if(!empty($input['name'])){

            $where[] = ['a.user_name','like','%'.$input['name'].'%'];

            $where[] = ['a.mobile','like','%'.$input['name'].'%'];
        }

        $data = $this->model->adminDataList($dis,$input['limit'],$where);

        $list = [

            0=>'all',

            1=>'ing',

            2=>'pass',

            4=>'nopass'
        ];

        foreach ($list as $k=> $value){

            $dis_s = [];

            $dis_s[] =['uniacid','=',$this->_uniacid];

            if(!empty($k)){

                $dis_s[] = ['status','=',$k];

            }else{

                $dis_s[] = ['status','>',-1];

            }

            $data[$value] = $this->model->where($dis_s)->count();

        }

        return $this->success($data);
    }




    /**
     * @author chenniang
     * @DataTime: 2022-08-03 11:53
     * @功能说明:
     */
    public function channelInfo(){

        $input = $this->_param;

        $dis = [

            'id' => $input['id']
        ];

        $info = $this->model->dataInfo($dis);

        $user_model = new User();

        $info['nickName'] = $user_model->where(['id'=>$info['user_id']])->value('nickName');

        return $this->success($info);

    }



    /**
     * @author chenniang
     * @DataTime: 2021-07-03 00:15
     * @功能说明:审核(2通过,3取消,4拒绝)
     */
    public function channelUpdate(){

        $input = $this->_input;

        $diss = [

            'id' => $input['id']
        ];

        $info = $this->model->dataInfo($diss);

        if(!empty($input['status'])&&in_array($input['status'],[2,4,-1])){

            $input['sh_time'] = time();
        }

        $data = $this->model->dataUpdate($diss,$input);

        return $this->success($data);

    }








}
