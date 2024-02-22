<?php
namespace app\massage\controller;
use app\AdminRest;
use app\massage\model\Coach;
use app\massage\model\Commission;
use app\massage\model\Order;
use app\massage\model\UserLabelData;
use app\shop\model\Article;
use app\shop\model\Banner;
use app\shop\model\Date;
use app\massage\model\OrderGoods;
use app\massage\model\RefundOrder;
use app\shop\model\Wallet;
use think\App;
use app\massage\model\User as Model;
use think\facade\Db;


class AdminUser extends AdminRest
{


    protected $model;

    protected $order_goods_model;

    protected $refund_order_model;

    public function __construct(App $app) {

        parent::__construct($app);

        $this->model = new Model();

        $this->order_goods_model = new OrderGoods();

        $this->refund_order_model = new RefundOrder();

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-24 10:24
     * @功能说明:用户列表
     */
    public function userList(){

        $input = $this->_param;

        $dis[] = ['uniacid','=',$this->_uniacid];
        //是否授权
        if(!empty($input['type'])){

            if($input['type']==1){

                $dis[] = ['nickName','=',''];

            }else{

                $dis[] = ['nickName','<>',''];

            }

        }

        $where = [];

        if(!empty($input['nickName'])){

            $where[] = ['nickName','like','%'.$input['nickName'].'%'];

            $where[] = ['phone','like','%'.$input['nickName'].'%'];
        }

        if(!empty($input['start_time'])&&!empty($input['end_time'])){

            $start_time = $input['start_time'];

            $end_time = $input['end_time'];

            $dis[] = ['create_time','between',"$start_time,$end_time"];
        }

        if(!empty($input['id'])){

            $dis[] = ['id','=',$input['id']];
        }

        if(!empty($input['phone'])){

            $dis[] = ['phone','like','%'.$input['phone'].'%'];
        }

        $data = $this->model->dataList($dis,$input['limit'],$where);

        if(!empty($data['data'])){

            $label_model = new UserLabelData();

            foreach ($data['data'] as &$v){

                $v['user_label'] = $label_model->getUserLabel($v['id']);

            }

        }

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-08-28 23:03
     * @功能说明:佣金记录
     */
    public function commList(){

        $input = $this->_param;

        $order_model = new Order();

        $order_model->coachBalanceArr($this->_uniacid);

        $dis[] = ['a.uniacid','=',$this->_uniacid];

        $dis[] = ['a.cash','>',0];

        if(!empty($input['status'])){

            $dis[] = ['a.status','=',$input['status']];
        }else{

            $dis[] = ['a.status','>',-1];

        }

        $where = [];

        if(!empty($input['top_name'])){

            $where[] = ['c.nickName','like','%'.$input['top_name'].'%'];

            $where[] = ['e.username','like','%'.$input['top_name'].'%'];

            $where[] = ['f.coach_name','like','%'.$input['top_name'].'%'];
        }

        if($this->_user['is_admin']==0){

            $dis[] = ['a.admin_id','in',$this->admin_arr];

        }

        if(!empty($input['type'])){

            if($input['type']==2){

                $dis[] = ['a.type','in',[2,5,6]];
            }else{

                $dis[] = ['a.type','=',$input['type']];
            }

        }

        $comm_model = new Commission();

        $data = $comm_model->recordListV2($dis,$where,$input['limit']);

        $admin_model = new \app\massage\model\Admin();

        $coach_model = new Coach();

        if(!empty($data['data'])){

            foreach ($data['data'] as &$v){

                if($v['car_price']>0){

                    $v['pay_price'] = $v['pay_price'].'(含车费'.$v['car_price'].')';
                }

                if(in_array($v['type'],[2,5,6])){

                    $v['top_name'] = $admin_model->where(['id'=>$v['top_id']])->value('username');

                }elseif ($v['type']==3){

                    $v['top_name'] = $coach_model->where(['id'=>$v['top_id']])->value('coach_name');
                }

                if($v['type']==2){

                    $v['balance'] = '平台抽成-'.$v['balance'];
                }

            }

        }

        if($this->_user['is_admin']==0){
            //可提现记录
            $data['total_cash'] = $admin_model->where(['id'=>$this->_user['id']])->sum('cash');

            $dis = [

                'admin_id' => $this->_user['id'],

                'status'   => 1,

                'type'     => 2
            ];
            //未入账金额
            $data['unrecorded_cash'] = $comm_model->where($dis)->sum('cash');

            $wallet_model = new \app\massage\model\Wallet();

            $dis = [

                'user_id' => $this->_user['id'],

                'status'  => 2,

                'type'    => 3
            ];
            //加盟商提现
            $data['wallet_cash'] = $wallet_model->where($dis)->sum('true_price');
        }

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-08-28 23:03
     * @功能说明:佣金记录
     */
    public function cashList(){

        $input = $this->_param;

        $order_model = new Order();

        $order_model->coachBalanceArr($this->_uniacid);

        $dis[] = ['a.uniacid','=',$this->_uniacid];

        $dis[] = ['a.cash','>',0];

        if(!empty($input['status'])){

            $dis[] = ['a.status','=',$input['status']];
        }else{

            $dis[] = ['a.status','>',-1];

        }

        $where = [];

        if(!empty($input['top_name'])){

            $where[] = ['c.nickName','like','%'.$input['top_name'].'%'];

            $where[] = ['e.username','like','%'.$input['top_name'].'%'];

            $where[] = ['f.coach_name','like','%'.$input['top_name'].'%'];
        }

        if($this->_user['is_admin']==0){

            $dis[] = ['a.admin_id','in',$this->admin_arr];

        }

        if(!empty($input['type'])){

            if($input['type']==2){

                $dis[] = ['a.type','in',[2,5,6]];

            }else{

                $dis[] = ['a.type','=',$input['type']];
            }

        }

        $comm_model = new Commission();

        $data = $comm_model->recordListV2($dis,$where,$input['limit']);

        $admin_model = new \app\massage\model\Admin();

        $coach_model = new Coach();

        if(!empty($data['data'])){

            foreach ($data['data'] as &$v){

                if($v['car_price']>0){

                    $v['pay_price'] = $v['pay_price'].'(含车费'.$v['car_price'].')';
                }

                if(in_array($v['type'],[2,5,6])){

                    $v['top_name'] = $admin_model->where(['id'=>$v['top_id']])->value('username');

                }elseif ($v['type']==3){

                    $v['top_name'] = $coach_model->where(['id'=>$v['top_id']])->value('coach_name');

                }

                if($v['type']==2){

                    $v['balance'] = '平台抽成-'.$v['balance'];
                }

            }

        }

        if($this->_user['is_admin']==0){
            //可提现记录
            $data['total_cash'] = $admin_model->where(['id'=>$this->_user['id']])->sum('cash');

            $dis = [

                'admin_id' => $this->_user['id'],

                'status'   => 1,
            ];
            //未入账金额
            $data['unrecorded_cash'] = $comm_model->where($dis)->where('type','in',[2,5,6])->sum('cash');

            $wallet_model = new \app\massage\model\Wallet();

            $dis = [

                'user_id' => $this->_user['id'],

                'status'  => 2,

                'type'    => 3
            ];
            //加盟商提现
            $data['wallet_cash'] = $wallet_model->where($dis)->sum('true_price');

            $data['total_cash'] = round($data['total_cash'],2);

            $data['unrecorded_cash'] = round($data['unrecorded_cash'],2);

            $data['wallet_cash'] = round($data['wallet_cash'],2);
        }

        return $this->success($data);

    }




    /**
     * @author chenniang
     * @DataTime: 2021-03-24 13:33
     * @功能说明:团长审核提现
     */
    public function applyWallet(){

        $input = $this->_input;

        if(empty($input['apply_price'])||$input['apply_price']<0.01){

            $this->errorMsg('提现费最低一分');
        }

        if($this->_user['is_admin']!=0){

            $this->errorMsg('只有加盟商才能提现');

        }

        $admin_model = new \app\massage\model\Admin();

        $admin_user = $admin_model->dataInfo(['id'=>$this->_user['id']]);
        //服务费
        if($input['apply_price']>$admin_user['cash']){

            $this->errorMsg('余额不足');
        }

        $balance = 100;

        $key = 'cap_wallets'.$this->_user['id'];

        $value = getCache($key,$this->_uniacid);

        if(!empty($value)){

            $this->errorMsg('网络错误，请刷新重试');

        }

        Db::startTrans();
        //减佣金
        $res = $admin_model->dataUpdate(['id'=>$this->_user['id'],'lock'=>$admin_user['lock']],['cash'=>$admin_user['cash']-$input['apply_price'],'lock'=>$admin_user['lock']+1]);

        if($res!=1){

            Db::rollback();
            //减掉
            delCache($key,$this->_uniacid);

            $this->errorMsg('申请失败');
        }

        $insert = [

            'uniacid'       => $this->_uniacid,

            'user_id'       => $admin_user['id'],

            'admin_id'      => $admin_user['id'],

            'coach_id'      => 0,

            'total_price'   => $input['apply_price'],

            'balance'       => $balance,

            'apply_price'   => round($input['apply_price']*$balance/100,2),

            'service_price' => 0,

            'code'          => orderCode(),

            'text'          => !empty($input['text'])?$input['text']:'',

            'type'          => 3,

        ];

        $wallet_model = new \app\massage\model\Wallet();
        //提交审核
        $res = $wallet_model->dataAdd($insert);

        if($res!=1){

            Db::rollback();
            //减掉
            delCache($key,$this->_uniacid);

            $this->errorMsg('申请失败');
        }

        Db::commit();
        //减掉
        delCache($key,$this->_uniacid);

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-10-24 16:44
     * @功能说明:删除用户标签
     */
    public function delUserLabel(){

        $input = $this->_input;

        $label_model = new UserLabelData();

        $res = $label_model->dataUpdate(['user_id'=>$input['user_id'],'label_id'=>$input['label_id']],['status'=>-1]);

        return $this->success($res);

    }








}
