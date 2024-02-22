<?php
namespace app\massage\controller;
use app\AdminRest;
use app\massage\info\PermissionMassage;
use app\massage\model\City;
use app\massage\model\Coach;
use app\massage\model\CoachLevel;

use app\massage\model\CoachUpdate;
use app\massage\model\Config;
use app\massage\model\Order;
use app\massage\model\Police;
use app\massage\model\User;
use app\massage\model\UserLabelData;
use app\massage\model\WorkLog;
use app\shop\model\Wallet;
use longbingcore\wxcore\PayModel;
use longbingcore\wxcore\WxPay;
use longbingcore\wxcore\WxSetting;
use think\App;
use app\shop\model\Order as Model;
use think\facade\Db;
use think\facade\Env;


class AdminCoach extends AdminRest
{


    protected $model;

    protected $order_goods_model;

    protected $wallet_model;

    public function __construct(App $app) {

        parent::__construct($app);

        $this->model = new Coach();

        $this->level_model = new CoachLevel();
//
        $this->wallet_model = new \app\massage\model\Wallet();

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-15 14:43
     * @功能说明:列表
     */
    public function coachList(){

        $input = $this->_param;

        $dis[] = ['uniacid','=',$this->_uniacid];

        if(!empty($input['is_update'])){

            $dis[] = ['is_update','=',1];
        }

        if(!empty($input['status'])){

            $dis[] = ['status','=',$input['status']];

        }else{

            $dis[] = ['status','>',-1];

        }

        if($this->_user['is_admin']==0){

            $dis[] = ['admin_id','in',$this->admin_arr];
        }

        if(!empty($input['admin_id'])){

            $dis[] = ['admin_id','=',$input['admin_id']];
        }

        if(!empty($input['start_time'])&&!empty($input['end_time'])){

            $start_time = $input['start_time'];

            $end_time   = $input['end_time'];

            $dis[] = ['create_time','between',"$start_time,$end_time"];

        }

        $where = [];

        if(!empty($input['name'])){

            $where[] = ['coach_name','like','%'.$input['name'].'%'];

            $where[] = ['mobile','like','%'.$input['name'].'%'];
        }

        if(!empty($input['is_user'])){

            if($input['is_user']==1){

                $dis[] = ['user_id','>',0];

            }else{

                $dis[] = ['user_id','=',0];
            }
        }

        $data = $this->model->dataList($dis,$input['limit'],$where);

        if(!empty($data['data'])){

            $admin_model = new \app\massage\model\Admin();

            foreach ($data['data'] as &$v){

                $v['admin_name'] = $admin_model->where(['id'=>$v['admin_id']])->value('username');

                $v['admin_add']  = 1;
            }

        }

        $list = [

           '0'=>'all',

            1=>'ing',

            2=>'pass',

            4=>'nopass',

            5=>'update_num'
        ];

        foreach ($list as $k=> $value){

            $dis_s = [];

            $dis_s[] =['uniacid','=',$this->_uniacid];

            if($this->_user['is_admin']==0){

                $dis_s[] = ['admin_id','=',$this->_user['id']];
            }

            if(!empty($k)&&$k!=5){

                $dis_s[] = ['status','=',$k];

            }else{

                $dis_s[] = ['status','>',-1];

            }

            if($k==5){

                $dis_s[] = ['is_update','=',1];
            }

            $data[$value] = $this->model->where($dis_s)->count();
        }

        return $this->success($data);

    }



    /**
     * @author chenniang
     * @DataTime: 2021-03-15 14:58
     * @功能说明:订单详情
     */
    public function coachInfo(){

        $input = $this->_param;

        $dis = [

            'id' => $input['id']
        ];

        $data = $this->model->dataInfo($dis);

        $user_model = new User();

        $city_model = new City();

        $data['nickName'] = $user_model->where(['id'=>$data['user_id']])->value('nickName');

        $data['city'] = $city_model->where(['id'=>$data['city_id']])->value('title');

        $data['order_num'] = $this->model->where(['id' => $data['id']])->value('order_num');

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-13 19:11
     * @功能说明:
     */
    public function financeList(){

        $input = $this->_param;

        $order_model = new Order();

        $order_model->coachBalanceArr($this->_uniacid);

        $dis[] = ['uniacid','=',$this->_uniacid];

        $dis[] = ['status','in',[2,3]];

        if(!empty($input['coach_name'])){

            $dis[] = ['coach_name','like','%'.$input['coach_name'].'%'];

        }

        $coach = $this->model->dataList($dis,$input['limit']);

        if(!empty($coach['data'])){

            foreach ($coach['data'] as &$v){

                $v['wallet_price'] = $this->wallet_model->where(['coach_id'=>$v['id']])->where('status','in',[2])->sum('apply_price');
                //到账多少元
                $v['wallet_price'] = round($v['wallet_price'],2);

                $v['total_price']  = $this->wallet_model->where(['coach_id'=>$v['id']])->where('status','in',[1,2])->sum('total_price');
                //申请多少元
                $v['total_price']  = round($v['total_price'],2);
                //到账笔数
                $v['wallet_count'] = $this->wallet_model->where(['coach_id'=>$v['id']])->where('status','in',[2])->count();
                //申请笔数
                $v['total_count']  = $this->wallet_model->where(['coach_id'=>$v['id']])->where('status','in',[1,2])->count();

                $order_price  = $order_model->where(['coach_id'=>$v['id'],'pay_type'=>7])->sum('true_service_price');

                $car_price    = $order_model->where(['coach_id'=>$v['id'],'pay_type'=>7])->sum('true_car_price');

                $v['order_count'] = $order_model->where(['coach_id'=>$v['id'],'pay_type'=>7])->count();

                $v['order_price'] = round($order_price+$car_price,2);
                //余额
                $v['balance']  = round($v['service_price']+$v['car_price'],2);


            }

        }

        return $this->success($coach);

    }

    /**
     * @author chenniang
     * @DataTime: 2021-09-22 15:19
     * @功能说明:团长用户列表
     */
    public function coachUserList(){

        $input = $this->_param;

        $dis[] = ['uniacid','=',$this->_uniacid];

        $dis[] = ['status','in',[0,1,2,3]];

        $user_id = $this->model->where($dis)->column('user_id');

        $where1 = [];

        if(!empty($input['nickName'])){

            $where1[] = ['nickName','like','%'.$input['nickName'].'%'];

            $where1[] = ['phone','like','%'.$input['nickName'].'%'];
        }

        $user_model = new User();

        $where[] = ['uniacid','=',$this->_uniacid];

        $where[] = ['id','not in',$user_id];

        $list = $user_model->dataList($where,$input['limit'],$where1);

        return $this->success($list);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-03 00:15
     * @功能说明:审核(2通过,3取消,4拒绝)
     */
    public function coachAdd(){

        $input = $this->_input;


        if(!empty($input['user_id'])){

            $cap_dis[] = ['user_id','=',$input['user_id']];

            $cap_dis[] = ['status','>',-1];

            if(!empty($input['id'])){

                $cap_dis[] = ['id','<>',$input['id']];

            }

            $cap_info = $this->model->dataInfo($cap_dis);

            if(empty($input['id'])&&!empty($cap_info)&&in_array($cap_info['status'],[1,2,3])){

                $this->errorMsg('已经申请过技师了，');
            }

        }else{

            $wehre[] = ['mobile','=',$input['mobile']];

            $wehre[] = ['status','>',-1];

            if(!empty($input['id'])){

                $wehre[] = ['id','<>',$input['id']];

            }

            $find = $this->model->where($wehre)->find();

            if(!empty($find)){

                $this->errorMsg('该电话号码已经注册技师');
            }

        }

        $input['admin_add'] = 1;

        $input['uniacid'] = $this->_uniacid;

        $input['id_card']  = !empty($input['id_card'])?implode(',',$input['id_card']):'';

        $input['license']  = !empty($input['license'])?implode(',',$input['license']):'';

        $input['self_img'] = !empty($input['self_img'])?implode(',',$input['self_img']):'';

        if(!empty($input['id'])){

            $coach_info = $this->model->dataInfo(['id'=>$input['id']]);

            if(!empty($input['status'])&&in_array($input['status'],[2,4])&&$coach_info['status']==1){

                $input['sh_time'] = time();
            }

            $res = $this->model->dataUpdate(['id'=>$input['id']],$input);

        }else{

            if($this->_user['is_admin']==0){

                $input['admin_id'] = $this->_user['id'];

                $input['status'] = 1;
            }

            if(!empty($input['status'])&&in_array($input['status'],[2,4])){

                $input['sh_time'] = time();
            }

            $res = $this->model->dataAdd($input);

        }

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-09-16 10:36
     * @功能说明:审核技师编辑信息
     */
    public function coachUpdateCheck(){

        $input = $this->_input;

        $update_model = new CoachUpdate();

        $dis = [

            'coach_id' => $input['id'],

            'status'   => 1
        ];

        $info = $update_model->where($dis)->order('id desc')->find();

        if(empty($info)){

            $this->errorMsg('暂无更新信息');
        }

        $res = $update_model->dataUpdate(['coach_id'=>$input['id'],'status'=>1],['status'=>$input['status'],'sh_text'=>$input['sh_text']]);

        $update = [];

        $update['is_update'] = 0;
        //通过覆盖技师信息
        if($input['status']==2){

            $info = $info->toArray();

            $arr = ['coach_name','sex','work_time','mobile','city_id','address','text','id_card','license','work_img','self_img','id_code','video','lng','lat'];

            foreach ($arr as $value){

                $update[$value] = $info[$value];
            }

        }

        $res = $this->model->dataUpdate(['id'=>$input['id']],$update);
        //发送审核结果通知
        $res = $this->model->updateSendMsg($input['id'],$input['status'],$input['sh_text']);

        return $this->success($res);

    }




    /**
     * @author chenniang
     * @DataTime: 2021-03-15 14:58
     * @功能说明:技师提交信息
     */
    public function coachUpdateInfo(){

        $input = $this->_param;

        $dis = [

            'coach_id'=> $input['id'],

            'status' => 1

        ];

        $update_model = new CoachUpdate();

        $data = $update_model->dataInfo($dis);

        if(empty($data)){

            $this->errorMsg('暂无更新信息');
        }

        if(!empty($data['id_card'])){

            $data['id_card'] = explode(',',$data['id_card']);
        }

        if(!empty($data['license'])){

            $data['license'] = explode(',',$data['license']);
        }

        if(!empty($data['self_img'])){

            $data['self_img'] = explode(',',$data['self_img']);
        }

        $user_model = new User();

        $city_model = new City();

        $data['nickName'] = $user_model->where(['id'=>$data['user_id']])->value('nickName');

        $data['city'] = $city_model->where(['id'=>$data['city_id']])->value('title');

        return $this->success($data);

    }
    /**
     * @author chenniang
     * @DataTime: 2021-07-03 00:15
     * @功能说明:审核(2通过,3取消,4拒绝)
     */
    public function coachUpdate(){

        $input = $this->_input;

        $dis = [

            'id' => $input['id']
        ];

        $coach = $this->model->dataInfo(['id'=>$input['id']]);

        if(!empty($input['status'])&&in_array($input['status'],[2,4])&&$coach['status']==1){

            $input['sh_time'] = time();
        }

        if(empty($input['user_id'])&&!empty($input['mobile'])){

            $find = $this->model->where(['mobile'=>$input['mobile']])->where('status','>',-1)->where('id','<>',$input['id'])->find();

            if(!empty($find)){

                $this->errorMsg('该电话号码已经注册技师');
            }
        }
        //如果是删除需要判断有无余额
        if(!empty($input['status'])&&$input['status']==-1){

            $coach = $this->model->dataInfo(['id'=>$input['id']]);

            if($this->_user['is_admin']==0&&$coach['status']!=1){

                $this->errorMsg('你无权操作');
            }

            if(!empty($coach['service_price'])||!empty($coach['car_price'])){

                $this->errorMsg('该技师还有未提现的费用，无法删除');
            }

            $order_model = new Order();

            $where[] = ['uniacid','=',$this->_uniacid];

            $where[] = ['coach_id','=',$input['id']];

            $where[] = ['pay_type','in',[2,3,4,5,6]];

            $order = $order_model->dataInfo($where);

            if(!empty($order)){

                $this->errorMsg('该技师还有未完成的订单，无法删除');
            }

            $wallet_dis = [

                'coach_id' => $input['id'],

                'status'   => 1
            ];

            $wallet = $this->wallet_model->dataInfo($wallet_dis);

            if(!empty($wallet)){

                $this->errorMsg('该技师还有提现申请中，无法删除');

            }
            //冻结金额
            $arr_dis = [

                'pay_type' => 7,

                'have_tx'  => 0,

                'coach_id' => $input['id']
            ];

            $no_arr_order = $order_model->dataInfo($arr_dis);

            if(!empty($no_arr_order)){

                $this->errorMsg('该技师还有冻结订单，无法删除');

            }

        }

        $log_model = new WorkLog();
        //结算在线时间
        $log_model->updateTimeOnline($input['id'],2);

        $data = $this->model->dataUpdate($dis,$input);

        return $this->success($data);

    }






    /**\
     * @author chenniang
     * @DataTime: 2021-03-18 09:28
     * @功能说明:同意退款
     */
    public function passRefund(){

        $input = $this->_input;

        $res = $this->refund_order_model->passOrder($input['id'],$input['price'],$this->payConfig(),0,$input['text']);

        if(!empty($res['code'])){

            $this->errorMsg($res['msg']);
        }

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-04 18:53
     * @功能说明:等级列表
     */
    public function levelList(){

        $input = $this->_param;

        $this->level_model->initTop($this->_uniacid);

        $dis[] = ['uniacid','=',$this->_uniacid];

        $dis[] = ['status','=',1];

        $dis = [

            'uniacid' => $this->_uniacid,

            'status'  => 1
        ];

        $data = $this->level_model->dataList($dis,$input['limit']);

        if(!empty($data['data'])){

            foreach ($data['data'] as &$v){

                $v['lower'] = $this->level_model->where($dis)->where('time_long','<',$v['time_long'])->max('time_long');

                $v['lower_price'] = $this->level_model->where($dis)->where('time_long','<',$v['time_long'])->max('price');

            }
        }

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-04 18:56
     * @功能说明:添加等级
     */
    public function levelAdd(){

        $input = $this->_input;

        $input['uniacid'] = $this->_uniacid;

        $dis = [

            'uniacid' => $this->_uniacid,

            'status'  => 1,
        ];

        $arr = [

            'time_long' => '累计时长不能相同',

           // 'top'       => '等级排序值不能相同',

            'price'     => '最低业绩不能相同',
        ];

        foreach ($arr as $k=>$value){

            $find = $this->level_model->where($dis)->where([$k=>$input[$k]])->find();

            if(!empty($find)){

                $this->errorMsg($value);
            }
        }

//        if($input['top']<1){
//
//            $this->errorMsg('等级排序值不能小于1');
//
//        }

        $res = $this->level_model->dataAdd($input);

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-04 18:57
     * @功能说明:编辑等级
     */
    public function levelUpdate(){

        $input = $this->_input;

        $dis = [

            'id' => $input['id']
        ];

        if(isset($input['time_long'])){

            $diss = [

                'uniacid' => $this->_uniacid,

                'status'  => 1,
            ];

            $arr = [

                'time_long' => '累计时长不能相同',

               // 'top'       => '等级排序值不能相同',

                'price'     => '最低业绩不能相同',
            ];


            foreach ($arr as $k=>$value){

                $find = $this->level_model->where($diss)->where('id','<>',$input['id'])->where([$k=>$input[$k]])->find();

                if(!empty($find)){

                    $this->errorMsg($value);
                }
            }

//            if($input['top']<1){
//
//                $this->errorMsg('等级排序值不能小于1');
//
//            }
        }

        $res = $this->level_model->dataUpdate($dis,$input);

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-04 18:59
     * @功能说明:等级详情
     */
    public function levelInfo(){

        $input = $this->_input;

        $dis = [

            'id' => $input['id']
        ];

        $res = $this->level_model->dataInfo($dis);

        return $this->success($res);


    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-07 18:46
     * @功能说明:提现列表
     */
    public function walletList(){

        $input = $this->_param;

        $dis[] = ['a.uniacid','=',$this->_uniacid];

        if($this->_user['is_admin']==0){

            $dis[] = ['a.admin_id','in',$this->admin_arr];

            $input['type'] = 3;

        }

        if(!empty($input['type'])){

            $dis[] = ['a.type','=',$input['type']];
        }

        if(!empty($input['code'])){

            $dis[] = ['a.code','like','%'.$input['code'].'%'];
        }

        if(!empty($input['status'])){

            $dis[] = ['a.status','=',$input['status']];
        }

        $data = $this->wallet_model->adminList($dis,$input['limit']);

        $admin_model = new \app\massage\model\Admin();

        $user_model  = new User();

        if(!empty($data['data'])){

            foreach ($data['data'] as &$v){

                if($v['type']==3){

                    $v['coach_name'] = $admin_model->where(['id'=>$v['user_id']])->value('username');

                }elseif ($v['type']==4){

                    $v['coach_name'] = $user_model->where(['id'=>$v['user_id']])->value('nickName');
                }
            }
        }

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-07 18:57
     * @功能说明:提现详情
     */
    public function walletInfo(){

        $input = $this->_param;

        $dis = [

            'id' => $input['id']
        ];

        $data = $this->wallet_model->dataInfo($dis);

        return $this->success($data);


    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-07 18:58
     * @功能说明:通过提现申请
     */
    public function walletPass(){

        $input = $this->_input;

        $dis = [

            'id' => $input['id']
        ];

        $data = $this->wallet_model->dataInfo($dis);

        if($data['status']!=1){

            $this->errorMsg('申请已审核');
        }

        if($this->_user['is_admin']==0){

            $this->errorMsg('你无权操作');
        }

        $update = [

            'sh_time'   => time(),

            'status'    => 2,

            'online'    => $input['online'],

            'true_price'=> $data['apply_price']
        ];

        Db::startTrans();

        $res = $this->wallet_model->dataUpdate(['id'=>$input['id'],'status'=>1],$update);

        if($res!=1){

            Db::rollback();

            $this->errorMsg('打款失败');

        }

        $user_model = new \app\massage\model\User();
        //线上转账
        if($input['online']==1){

            if(in_array($data['type'],[1,2,4])){

                $openid = $user_model->where(['id'=>$data['user_id']])->value('openid');

                $last_login_type = $user_model->where(['id'=>$data['user_id']])->value('last_login_type');

            }elseif (in_array($data['type'],[3])){

                $admin_model = new \app\massage\model\Admin();

                $user_id = $admin_model->where(['id'=>$data['admin_id']])->value('user_id');

                $openid = $user_model->where(['id'=>$user_id])->value('openid');
            }

            if(empty($openid)){

                return $this->error('用户信息错误，未获取到openid');
            }
            //微信相关模型
            $wx_pay = new WxPay($this->_uniacid);
            //微信提现
            $res    = $wx_pay->crteateMchPay($this->payConfig($last_login_type),$openid,$update['true_price']);
return $res;
            if($res['result_code']=='SUCCESS'&&$res['return_code']=='SUCCESS'){

                if(!empty($res['payment_no'])){

                    $this->wallet_model->dataUpdate(['id'=>$input['id']],['payment_no'=>$res['payment_no']]);
                }

            }else{

                Db::rollback();

                return $this->error(!empty($res['err_code_des'])?$res['err_code_des']:'你还未该权限');

            }

        }elseif ($input['online']==2){
            //支付宝转账
            $pay_model = new PayModel($this->payConfig());

            if(in_array($data['type'],[1,2,4])){

                $alipay_number = $user_model->where(['id'=>$data['user_id']])->value('alipay_number');

            }elseif (in_array($data['type'],[3])){

                $admin_model = new \app\massage\model\Admin();

                $user_id = $admin_model->where(['id'=>$data['admin_id']])->value('user_id');

                $alipay_number = $user_model->where(['id'=>$user_id])->value('alipay_number');
            }

            if(empty($alipay_number)){

                return $this->error('该用户未绑定支付宝账号');
            }

            $res = $pay_model->onPaymentByAlipay($alipay_number,$update['true_price']);

            if(!empty($res['alipay_fund_trans_toaccount_transfer_response']['code'])&&$res['alipay_fund_trans_toaccount_transfer_response']['code']==10000&&$res['alipay_fund_trans_toaccount_transfer_response']['msg']=='Success'){

                $this->wallet_model->dataUpdate(['id'=>$input['id']],['payment_no'=>$res['alipay_fund_trans_toaccount_transfer_response']['order_id']]);
            }else{

                Db::rollback();

                return $this->error(!empty($res['alipay_fund_trans_toaccount_transfer_response']['sub_msg'])?$res['alipay_fund_trans_toaccount_transfer_response']['sub_msg']:'你还未该权限');
            }

        }

        Db::commit();

        return $this->success($res);

    }



    /**
     * @author chenniang
     * @DataTime: 2021-03-26 15:03
     * @功能说明:决绝提现
     */
    public function walletNoPass(){

        $input = $this->_input;

        $info = $this->wallet_model->dataInfo(['id'=>$input['id']]);

        if($this->_user['is_admin']==0){

            $this->errorMsg('你无权操作');
        }

        if($info['status']==2){

            $this->errorMsg('已同意打款');
        }

        if($info['status']==3){

            $this->errorMsg('已拒绝打款');
        }

        Db::startTrans();


        $update = [

            'sh_time' => time(),

            //'text'      => !empty($input['text'])?$input['text']:'',

            'status'    => 3,

        ];

        $res = $this->wallet_model->dataUpdate(['id'=>$input['id'],'status'=>1],$update);

        if($res!=1){

            Db::rollback();

            $this->errorMsg('打款失败');

        }

        $cap_info = $this->model->dataInfo(['id'=>$info['coach_id']]);

        if($info['type']==1){

            $res = $this->model->dataUpdate(['id'=>$info['coach_id']],['service_price'=>$cap_info['service_price']+$info['total_price']]);

        }elseif($info['type']==2){

            $res = $this->model->dataUpdate(['id'=>$info['coach_id']],['car_price'=>$cap_info['car_price']+$info['total_price']]);

        }elseif($info['type']==3){

            $admin_model = new \app\massage\model\Admin();

            $user_info = $admin_model->dataInfo(['id'=>$info['user_id']]);

            $res = $admin_model->dataUpdate(['id'=>$info['user_id']],['cash'=>$user_info['cash']+$info['total_price']]);

        }else{

            $user_model = new User();

            $user_info = $user_model->dataInfo(['id'=>$info['user_id']]);

            $res = $user_model->dataUpdate(['id'=>$info['user_id']],['new_cash'=>$user_info['new_cash']+$info['total_price']]);

        }

        if($res!=1){

            Db::rollback();

            $this->errorMsg('审核失败');

        }

        Db::commit();


        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-08 17:15
     * @功能说明:报警
     */
    public function policeList(){

        $input = $this->_param;

        $dis[] = ['a.uniacid','=',$this->_uniacid];

        $dis[] = ['a.status','>',-1];

        if(isset($input['have_look'])){

            $dis[] = ['a.have_look','=',$input['have_look']];

        }

        if(!empty($input['start_time'])){

            $start_time = $input['start_time'];

            $end_time = $input['end_time'];

            $dis[] = ['a.create_time','between',"$start_time,$end_time"];
        }

        $police_model = new Police();

        $data = $police_model->dataList($dis,$input['limit']);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-08 17:19
     * @功能说明:编辑报警
     */
    public function policeUpdate(){

        $input = $this->_input;

        $dis = [

            'id' => $input['id']
        ];

        $police_model = new Police();

        $res = $police_model->dataUpdate($dis,$input);

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-10-24 15:25
     * @功能说明:获取用户标签
     */
    public function userLabelList(){

        $input = $this->_param;

        $label_model = new UserLabelData();

        $data = $label_model->getUserLabel($input['user_id']);

        return $this->success($data);

    }









}
