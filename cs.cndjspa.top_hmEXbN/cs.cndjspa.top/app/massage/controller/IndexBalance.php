<?php
namespace app\massage\controller;
use app\ApiRest;

use app\massage\model\BalanceCard;
use app\massage\model\BalanceOrder;
use app\massage\model\BalanceWater;
use app\massage\model\Coach;
use app\massage\model\Commission;
use app\massage\model\Integral;
use app\massage\model\MassageConfig;
use app\massage\model\User;
use app\Rest;


use longbingcore\wxcore\PayModel;
use think\App;

use think\Request;



class IndexBalance extends ApiRest
{

    protected $model;

    protected $article_model;

    protected $coach_model;

    protected $water_model;


    public function __construct(App $app) {

        parent::__construct($app);

        $this->model = new BalanceCard();

        $this->balance_order = new BalanceOrder();

        $this->water_model    = new BalanceWater();

    }



    /**
     * @author chenniang
     * @DataTime: 2021-07-04 19:09
     * @功能说明:储值充值卡列表
     */
    public function cardList(){

        $input = $this->_param;

        $dis[] = ['uniacid','=',$this->_uniacid];

        $dis[] = ['status','=',1];

        if(!empty($input['name'])){

            $dis[] = ['title','like','%'.$input['name'].'%'];

        }

        $data = $this->model->dataList($dis,$input['limit']);

        if(!empty($data['data'])){

            foreach ($data['data'] as &$v){

                $v['create_time'] = date('Y-m-d H:i:s',$v['create_time']);

            }
        }

        if(!empty($input['coach_id'])){

            $coach_model = new Coach();

            $data['coach_name'] = $coach_model->where(['id'=>$input['coach_id']])->value('coach_name');
        }

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-07 17:00
     * @功能说明:充值余额
     */
    public function payBalanceOrder(){

        $input = $this->_input;

        $dis = [

            'id'     => $input['card_id'],

            'status' => 1
        ];

        $card = $this->model->dataInfo($dis);

        if(empty($card)){

            $this->errorMsg('充值卡已被下架');
        }

        $pay_model = isset($input['pay_model'])?$input['pay_model']:1;

        $insert = [

            'uniacid'    => $this->_uniacid,

            'user_id'    => $this->getUserId(),

            'order_code' => orderCode(),

            'pay_price'  => $card['price'],

            'integral'   => $card['price'],

            'sale_price' => $card['price'],

            'true_price' => $card['true_price'],

            'card_id'    => $card['id'],

            'title'      => $card['title'],

            'coach_id'   => !empty($input['coach_id'])?$input['coach_id']:0,

            'app_pay'    => $this->is_app,

            'pay_model' => $pay_model

        ];

        $res = $this->balance_order->dataAdd($insert);

        if($res==0){

            $this->errorMsg('充值失败');

        }

        $order_id = $this->balance_order->getLastInsID();

        $config_model = new MassageConfig();

        $config = $config_model->dataInfo(['uniacid'=>$this->_uniacid]);
        //储值返回佣金
        if(!empty($input['coach_id'])&&$config['balance_cash']==1){

            $cash_insert = [

                'uniacid' => $this->_uniacid,

                'user_id' => $this->getUserId(),

                'top_id'  => $input['coach_id'],

                'order_id'=> $order_id,

                'order_code' => $insert['order_code'],

                'type'    => 7,

                'cash'    => round($config['balance_balance']*$card['price']/100,2),

                'balance' => $config['balance_balance'],

                'status'  => -1,

            ];

            $comm_model = new Commission();

            $comm_model->dataAdd($cash_insert);
            //
            $integral_insert = [

                'uniacid' => $this->_uniacid,

                'coach_id' => $input['coach_id'],

                'order_id'=> $order_id,

                'integral'   => round($config['balance_balance']*$card['price']/100,2),

                'balance' => $config['balance_balance'],

                'status'  => -1,

                'type'    => 1,

                'user_id' => $this->getUserId(),

                'user_cash'=>  $card['price']

            ];

            $integral_model = new Integral();

            $integral_model->dataAdd($integral_insert);
        }
        //储值返回积分
        if(!empty($input['coach_id'])&&$config['balance_integral']==1){

            $integral_insert = [

                'uniacid' => $this->_uniacid,

                'coach_id' => $input['coach_id'],

                'order_id'=> $order_id,

                'integral'   => round($card['price'],2),

                'balance' => 100,

                'status'  => -1,

                'user_id' => $this->getUserId(),

                'user_cash'=> $card['price']

            ];

            $integral_model = new Integral();

            $integral_model->dataAdd($integral_insert);
        }

        if($pay_model==1){
            //微信支付
            $pay_controller = new \app\shop\controller\IndexWxPay($this->app);
            //支付
            $jsApiParameters= $pay_controller->createWeixinPay($this->payConfig(),$this->getUserInfo()['openid'],$this->_uniacid,"储值",['type' => 'Balance' , 'out_trade_no' => $insert['order_code']],$insert['pay_price']);

            $arr['pay_list']= $jsApiParameters;
        }else{

            $pay_model = new PayModel($this->payConfig());

            $jsApiParameters = $pay_model->aliPay($insert['order_code'],$insert['pay_price'],'充值订单',2);

            $arr['pay_list']= $jsApiParameters;

            $arr['order_code']= $insert['order_code'];
        }

        return $this->success($arr);

    }


    /**
     * @author chenniang
     * @DataTime: 2023-02-22 10:16
     * @功能说明:技师列表
     */
    public function coachList(){

        $input = $this->_param;

        $dis[] = ['a.uniacid','=',$this->_uniacid];

        $dis[] = ['a.status','=',2];

        $dis[] = ['a.user_id','>',0];

        if(!empty($input['coach_name'])){

            $dis[] = ['a.coach_name','like','%'.$input['coach_name'].'%'];

        }

        $lat = !empty($input['lat'])?$input['lat']:0;

        $lng = !empty($input['lng'])?$input['lng']:0;

        $alh = 'ACOS(SIN(('.$lat.' * 3.1415) / 180 ) *SIN((a.lat * 3.1415) / 180 ) +COS(('.$lat.' * 3.1415) / 180 ) * COS((a.lat * 3.1415) / 180 ) *COS(('.$lng.' * 3.1415) / 180 - (a.lng * 3.1415) / 180 ) ) * 6378.137*1000 as distance';

        $coach_model = new Coach();

        $data = $coach_model->serviceCoachList($dis,$alh);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-07 17:34
     * @功能说明:充值订单列表
     */
    public function balaceOrder(){

        $input = $this->_param;

        $dis[] = ['status','=',2];

        $dis[] = ['user_id','=',$this->getUserId()];

        if(!empty($input['start_time'])){

            $dis[] = ['pay_time','between',"{$input['start_time']},{$input['end_time']}"];

        }

        $data = $this->balance_order->dataList($dis);

        if(!empty($data['data'])){

            foreach ($data['data'] as &$v){

                $v['create_time'] = date('Y-m-d H:i:s',$v['create_time']);

                $v['pay_time']    = date('Y-m-d H:i:s',$v['pay_time']);

            }
        }


        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-07 18:00
     * @功能说明:消费明细
     */
    public function payWater(){

        $input = $this->_param;

        $dis[] = ['user_id','=',$this->getUserId()];

//        $dis[] = ['type','=',2];

        if(!empty($input['start_time'])){

            $dis[] = ['create_time','between',"{$input['start_time']},{$input['end_time']}"];

        }

        $data = $this->water_model->dataList($dis);

        if(!empty($data['data'])){

            foreach ($data['data'] as &$v){

                $v['create_time'] = date('Y-m-d H:i:s',$v['create_time']);

            }

        }

        return $this->success($data);

    }











}
