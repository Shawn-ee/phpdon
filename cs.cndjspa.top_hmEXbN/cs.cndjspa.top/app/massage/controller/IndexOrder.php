<?php
namespace app\massage\controller;
use app\ApiRest;

use app\massage\model\Address;
use app\massage\model\Car;
use app\massage\model\CarPrice;
use app\massage\model\Coach;
use app\massage\model\CoachChangeLog;
use app\massage\model\Comment;
use app\massage\model\CommentGoods;
use app\massage\model\CommentLable;
use app\massage\model\Config;

use app\massage\model\Coupon;
use app\massage\model\CouponRecord;
use app\massage\model\Lable;
use app\massage\model\MsgConfig;
use app\massage\model\NoticeList;
use app\massage\model\Order;
use app\massage\model\OrderAddress;
use app\massage\model\OrderData;
use app\massage\model\OrderGoods;
use app\massage\model\OrderLog;
use app\massage\model\OrderPrice;
use app\massage\model\RefundOrder;
use app\massage\model\Service;
use app\massage\model\ShieldList;
use app\massage\model\UpOrderGoods;
use app\massage\model\UpOrderList;
use app\massage\model\User;
use app\massage\controller\IndexWxPay;
use longbingcore\wxcore\PayModel;
use think\App;
use think\facade\Db;
use think\Request;


class IndexOrder extends ApiRest
{

    protected $model;

    protected $refund_model;

    protected $order_goods_model;

    protected $coach_model;

    public function __construct(App $app) {

        parent::__construct($app);

        $this->model = new Order();

        $this->refund_model = new RefundOrder();

        $this->order_goods_model = new OrderGoods();

        $this->coach_model = new Coach();

        $this->model->coachBalanceArr($this->_uniacid);
        //超时自动取消订单
        $this->model->autoCancelOrder($this->_uniacid);

    }

    /**
     * @author chenniang
     * @DataTime: 2021-07-12 00:26
     * @功能说明:天数
     */
    public function dayText(){

        $config_model = new Config();

        $config = $config_model->dataInfo(['uniacid'=>$this->_uniacid]);

        $start_time = strtotime(date('Y-m-d',time()));

       // $start_time = $start_time+$config['max_day']*86400;

        $i=0;

        while ($i<$config['max_day']){

            $str = $start_time+$i*86400;

            $data[$i]['dat_str'] = $str;

            $data[$i]['dat_text'] = date('m-d',$str);

            $data[$i]['week'] = changeWeek(date('w',$str));

            $i++;

        }

        return $this->success($data);


    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-09 14:41
     * @功能说明:时间段
     */
    public function timeText(){

        $input = $this->_param;

        $coach_model  = new Coach();

        $coach  = $coach_model->dataInfo(['id'=>$input['coach_id']]);

        $data = $this->getTimeData($coach['start_time'],$coach['end_time'],$coach['id'],$input['day']);

        return $this->success($data);

    }



    /**
     * @author chenniang
     * @DataTime: 2021-03-19 15:48
     * @功能说明:个人中心
     */
    public function orderList(){

        if(empty($this->getUserId())){

            return $this->success([]);

        }

        $input = $this->_param;

        $dis[] = ['a.uniacid','=',$this->_uniacid];

        $dis[] = ['a.user_id','=',$this->getUserId()];

        $dis[] = ['a.is_show','=',1];

        $where = [];

        if(!empty($input['name'])){

            $where[] = ['b.goods_name','like','%'.$input['name'].'%'];

            $where[] = ['a.order_code','like','%'.$input['name'].'%'];

        }

        if(!empty($input['pay_type'])){

            if($input['pay_type']==5){

                $dis[] = ['a.pay_type','in',[2,3,4,5]];

            }else{

                $dis[] = ['a.pay_type','=',$input['pay_type']];

            }

        }
        //是否是加钟
        $data = $this->model->indexDataList($dis,$where);

        if(!empty($data['data'])){

            $shield_model = new ShieldList();

            foreach ($data['data'] as &$v){

                $can_refund_num = is_array($v['order_goods'])?array_sum(array_column($v['order_goods'],'can_refund_num')):0;
                //是否可以申请退款
                if((in_array($v['pay_type'],[2,3,4,5])&&$can_refund_num>0)){

                    $v['can_refund'] = 1;

                }else{

                    $v['can_refund'] = 0;
                }
                //是否能加钟
                $v['can_add_order'] = $this->model->orderCanAdd($v);

                $shield = $shield_model->where(['user_id'=>$v['user_id'],'coach_id'=>$v['coach_id']])->where('type','in',[2,3])->find();

                $v['can_again'] = !empty($shield)?0:1;

            }

        }

        return $this->success($data);

    }

    /**
     * @author chenniang
     * @DataTime: 2021-03-15 14:58
     * @功能说明:订单详情
     */
    public function orderInfo(){

        $input = $this->_param;

        $dis = [

            'id' => $input['id'],

            'is_show' => 1
        ];

        $data = $this->model->dataInfo($dis);

        if(empty($data)){

            $this->errorMsg('订单已被删除');
        }
        //是否能加钟
        $data['can_add_order'] = $this->model->orderCanAdd($data);

        $arr = ['create_time','pay_time','serout_time','arrive_time','receiving_time','start_service_time','order_end_time'];

        foreach ($arr as $value){

            $data[$value] = !empty($data[$value])?date('Y-m-d H:i:s',$data[$value]):0;
        }

        $data['start_time'] = date('Y-m-d H:i',$data['start_time']).'-'.date('H:i',$data['end_time']);
        //剩余可申请退款数量
        $can_refund_num = array_sum(array_column($data['order_goods'],'can_refund_num'));
        //是否可以申请退款
        if((in_array($data['pay_type'],[2,3,4,5])&&$can_refund_num>0)){

            $data['can_refund'] = 1;

        }else{

            $data['can_refund'] = 0;
        }

        $data['distance']   = distance_text($data['distance']);

        $data['over_time'] -= time();

        $data['over_time']  = $data['over_time']>0?$data['over_time']:0;
        //加钟订单
        if($data['is_add']==0){

            $data['add_order_id'] = $this->model->where(['add_pid'=>$data['id']])->where('pay_type','>',1)->field('id,order_code')->select()->toArray();

        }else{

            $data['add_pid'] = $this->model->where(['id'=>$data['add_pid']])->field('id,order_code')->find();

        }

        $order_model = new OrderData();
        //订单附表
        $order_data = $order_model->dataInfo(['order_id'=>$input['id'],'uniacid'=>$this->_uniacid]);

        $data = array_merge($order_data,$data);

        $data['sign_time'] = !empty($data['sign_time'])?date('Y-m-d H:i:s',$data['sign_time']):'';

        $shield_model = new ShieldList();

        $shield = $shield_model->where(['user_id'=>$data['user_id'],'coach_id'=>$data['coach_id']])->where('type','in',[2,3])->find();

        $data['can_again'] = !empty($shield)?0:1;
        //查询是否有转派记录
        $change_log_model = new CoachChangeLog();

        $change_log = $change_log_model->dataInfo(['order_id'=>$data['id'],'status'=>1]);

        if(!empty($change_log)){

            $data['old_coach_name'] = $this->coach_model->where(['id'=>$change_log['init_coach_id']])->value('coach_name');
        }

        $have_car_price = $change_log_model->dataInfo(['order_id'=>$data['id'],'status'=>1,'have_car_price'=>1]);
       
        //是否可以退车费
        $data['can_refund_car_price'] = empty($have_car_price)&&$data['pay_type']<4?1:0;

        $admin_model = new \app\massage\model\Admin();
        //代理商电话
        $data['admin_phone'] = $admin_model->where(['id'=>$data['admin_id']])->value('phone');

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2023-02-23 18:32
     * @功能说明:获取加钟订单
     */
    public function getAddClockOrder(){

        $input = $this->_param;

        $dis[] = ['a.add_pid','=',$input['order_id']];

        $dis[] = ['a.pay_type','>',1];

        $dis[] = ['a.is_show','=',1];

        $data = $this->model->indexDataList($dis,[]);

        if(!empty($data['data'])){

            $shield_model = new ShieldList();

            foreach ($data['data'] as &$v){

                $can_refund_num = is_array($v['order_goods'])?array_sum(array_column($v['order_goods'],'can_refund_num')):0;

                if((in_array($v['pay_type'],[2,3,4,5])&&$can_refund_num>0)){

                    $v['can_refund'] = 1;

                }else{

                    $v['can_refund'] = 0;
                }

                $shield = $shield_model->where(['user_id'=>$v['user_id'],'coach_id'=>$v['coach_id']])->where('type','in',[2,3])->find();

                $v['can_again'] = !empty($shield)?0:1;

            }

        }

        return $this->success($data);

    }









    /**
     * @author chenniang
     * @DataTime: 2021-03-19 17:29
     * @功能说明:退款订单详情
     *
     */
    public function refundOrderList(){

        $input = $this->_param;

        $dis[] = ['a.uniacid','=',$this->_uniacid];

        $dis[] = ['a.user_id','=',$this->getUserId()];

        $where = [];

        if(!empty($input['name'])){

            $where[] = ['b.goods_name','like','%'.$input['name'].'%'];

            $where[] = ['a.order_code','like','%'.$input['name'].'%'];

        }

        if(!empty($input['status'])){

            $dis[] = ['a.status','=',$input['status']];

        }else{

            $dis[] = ['a.status','>',-1];

        }

        $data = $this->refund_model->indexDataList($dis,$where);
        //待接单数量
        $data['agent_order_count'] = $this->refund_model->where(['user_id'=>$this->getUserId(),'status'=>1])->count();

        return $this->success($data);
    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-19 17:50
     * @功能说明:退款订单详情
     */

    public function refundOrderInfo(){

        $input = $this->_param;

        $dis = [

            'id' => $input['id']
        ];

        $data = $this->refund_model->dataInfo($dis);

        $data['create_time'] = date('Y-m-d H:i:s',$data['create_time']);

        $data['refund_time'] = date('Y-m-d H:i:s',$data['refund_time']);

        $order = $this->model->dataInfo(['id'=>$data['order_id']]);

        if(!empty($order)){
            //加钟订单
            if($order['is_add']==0){

                $data['add_order_id'] = $this->model->where(['add_pid'=>$order['id']])->where('pay_type','>',1)->field('id,order_code')->select()->toArray();

            }else{

                $data['add_pid'] = $this->model->where(['id'=>$order['add_pid']])->field('id,order_code')->find();

            }
        }

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-22 09:43
     * @功能说明:下单页面详情
     */
    public function payOrderInfo(){

        $input = $this->_param;

        $coupon = !empty($input['coupon_id'])?$input['coupon_id']:0;

        $order_id = !empty($input['order_id'])?$input['order_id']:0;

        $address_model = new Address();

        $coupon_modle  = new Coupon();

        $coupon_record_model  = new CouponRecord();

        if(!empty($input['address_id'])){

            $address = $address_model->dataInfo(['id'=>$input['address_id']]);

        }
        //加钟订单
        if(!empty($order_id)){

            $input['car_type'] = 0;

            $p_order = $this->model->dataInfo(['id'=>$order_id]);

            $address = $p_order['address_info'];

        }
        //可用优惠券数量
        $canUseCoupon = $coupon_modle->canUseCoupon($this->getUserId(),$input['coach_id']);

        if(!empty($input['coupon_id'])){

            $coupon = $input['coupon_id'];

        }elseif (!empty($canUseCoupon)){

            $coupon = $canUseCoupon[0];
        }

        $lat = !empty($address['lat'])?$address['lat']:0;

        $lng = !empty($address['lng'])?$address['lng']:0;

        $order_info = $this->model->payOrderInfo($this->getUserId(),$input['coach_id'],$lat,$lng,$input['car_type'],$coupon,$order_id);
        //默认地址
        $order_info['address_info'] = $address;

        $coach_model = new Coach();

        if(!empty($input['coach_id'])&&$input['coach_id']>0){

            $order_info['coach_info'] = $coach_model->where(['id'=>$input['coach_id']])->field('id,coach_name,mobile,work_img')->find();

        }else{

            $change_log_model = new CoachChangeLog();

            $order_info['coach_info']['coach_name'] = $change_log_model->where(['order_id'=>$order_id])->order('id desc')->value('now_coach_name');

            $order_info['coach_info']['work_img'] = defaultCoachAvatar();

        }

        $order_info['distance'] = distance_text($order_info['distance']);

        $order_info['canUseCoupon'] = $coupon_record_model->where('id','in',$canUseCoupon)->sum('num');

        $car_model = new CarPrice();

        if(!empty($input['coach_id'])){

            $dis = [

                'uniacid' => $this->_uniacid,

                'city_id' => $order_info['coach_info']['city_id'],

                'status'  => 1
            ];
            //获取指定城市的车费配置
            $order_info['car_config'] = $car_model->where($dis)->find();
        }
        //没有就获取全局配置
        if(empty($order_info['car_config'])){

            $order_info['car_config'] = $car_model->dataInfo(['uniacid'=>$this->_uniacid]);
        }

        $config_model = new Config();

        $order_info['trading_rules'] = $config_model->where(['uniacid'=>$this->_uniacid])->value('trading_rules');
        //加钟订单开始
        if(!empty($order_id)){

            $order_start_time = $this->model->addOrderTime($order_id);

            $order_end_time   = $this->model->getOrderEndTime($order_info['order_goods'],$order_start_time);

            $order_info['order_end_time']  = date('Y-m-d H:i:s',$order_end_time);

            $order_info['order_start_time']= date('Y-m-d H:i:s',$order_start_time);

        }

        $config_model = new Config();

        $config = $config_model->dataInfo(['uniacid'=>$this->_uniacid]);
        //默认时间
        $near_time  = $coach_model->getCoachEarliestTime($input['coach_id'],$config,1);

        if(!empty($near_time)){

            $order_info['near_time']['text'] = date('m-d',$near_time).' '.changeWeek(date('w',$near_time)).' '.date('H:i',$near_time);

            $order_info['near_time']['str']  = $near_time;
        }

        return $this->success($order_info);

    }





    /**
     * @author chenniang
     * @DataTime: 2021-07-10 00:40
     * @功能说明:可用的优惠券列表
     */
    public function couponList(){

        $input = $this->_param;

        $coupon_model = new Coupon();

        $coupon_record_model = new CouponRecord();

        $coupon_id = $coupon_model->canUseCoupon($this->getUserId(),$input['coach_id']);

        $data = $coupon_record_model->where('id','in',$coupon_id)->order('id desc')->paginate(10)->toArray();

        if(!empty($data['data'])){

            foreach ($data['data'] as &$v){

                $v['start_time'] = date('Y.m.d H:i',$v['start_time']).' - '.date('Y.m.d H:i',$v['end_time']);

            }
        }

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2023-03-06 14:09
     * @功能说明:校验是否可以加单
     */
    public function checkAddOrder(){

        $input = $this->_input;

        $add_order = $this->model->where(['add_pid'=>$input['order_id']])->where('pay_type','in',[2,3,4,5,6,8])->field('id,start_time,end_time')->find();

        if(!empty($add_order)){

            $this->errorMsg('请先完成上一次加钟订单，才能继续加钟');

        }

        return $this->success(true);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-22 09:53
     * @功能说明:下单
     */
    public function payOrder(){

        $input = $this->_input;

        $address_order_model = new OrderAddress();

        $address_model       = new Address();

        $coupon_record_model = new CouponRecord();

        $coach_model         = new Coach();

        $cap_dis[] = ['user_id','=',$this->getUserId()];
        //查看是否是团长
        $my_cap_id = $coach_model->where($cap_dis)->value('id');

        $cap_info  = $coach_model->dataInfo(['id'=>$input['coach_id']]);

        $order_id = !empty($input['order_id'])?$input['order_id']:0;

        if($input['coach_id']==$my_cap_id){

            //$this->errorMsg('技师不能给自己下单');
        }

        if(!empty($cap_info)&&$cap_info['is_work']==0){

            $this->errorMsg('该技师未上班');

        }

        if(!empty($cap_info)&&$cap_info['status']!=2){

            $this->errorMsg('该技师已下架');

        }

        $coupon_id  = !empty($input['coupon_id'])?$input['coupon_id']:0;
        //加钟订单
        if(!empty($order_id)){

            $p_order = $this->model->dataInfo(['id'=>$order_id]);

            $can_add = $this->model->orderCanAdd($p_order);

            if($can_add==0){

                $this->errorMsg('该订单不能加钟');
            }

            $add_order = $this->model->where(['add_pid'=>$order_id])->where('pay_type','in',[2,3,4,5,6,8])->field('id,start_time,end_time')->find();

            if(!empty($add_order)){

                $this->errorMsg('请先完成上一次加钟订单，才能继续加钟');

            }

            $address = $p_order['address_info'];

            $address['id'] = $address['address_id'];
            //加钟订单不计算车费
            $input['car_type'] = 0;
            //加钟
            $input['start_time'] = $this->model->addOrderTime($order_id);

        }else{

            $address = $address_model->dataInfo(['id'=>$input['address_id']]);
        }

        if(empty($address)){

            $this->errorMsg('请添加地址');
        }

        $order_info = $this->model->payOrderInfo($this->getUserId(),$input['coach_id'],$address['lat'],$address['lng'],$input['car_type'],$coupon_id,$order_id);

        $config_model = new Config();

        $config = $config_model->dataInfo(['uniacid'=>$this->_uniacid]);

        Db::startTrans();

        $key = $order_info['coach_id'].'order_key';

        incCache($key,1,$this->_uniacid);

        $key_value = getCache($key,$this->_uniacid);

        if($key_value!=1){

            decCache($key,1,$this->_uniacid);

            Db::rollback();

            $this->errorMsg('下单人数过多，请重试');

        }
        //检查技师时间(返回结束时间)
        $check = $this->model->checkTime($order_info,$input['start_time'],$order_id);

        if(!empty($check['code'])){

            decCache($key,1,$this->_uniacid);

            Db::rollback();

            $this->errorMsg($check['msg']);
        }
        //默认微信
        $pay_model = isset($input['pay_model'])?$input['pay_model']:1;

        $order_insert = [

            'uniacid'    => $this->_uniacid,

            'over_time'  => time()+$config['over_time']*60,

            'order_code' => orderCode(),

            'user_id'    => $this->getUserId(),

            'pay_price'  => $order_info['pay_price'],

            'balance'    => $pay_model==2?$order_info['pay_price']:0,

            'init_service_price'=> $order_info['init_goods_price'],

            'service_price'=> $order_info['goods_price'],

            'true_service_price' => $order_info['goods_price'],

            'discount'    => $order_info['discount'],

            'car_price'   => $order_info['car_price'],

            'true_car_price' => $order_info['car_price'],

            'pay_type'    => 1,

            'coach_id'    => $order_info['coach_id'],

            'start_time'  => $input['start_time'],

            'end_time'    => $check['end_time'],

            'distance'    => $order_info['distance'],

            'time_long'   => $check['time_long'],

            'true_time_long' => $check['time_long'],
            //备注
            'text'        => !empty($input['text'])?$input['text']:'',

            'can_tx_time' => $config['can_tx_time'],

            'car_type'    => $input['car_type'],

            'channel_id'  => !empty($input['channel_id'])?$input['channel_id']:0,

            'app_pay'     => $this->is_app,
            //技师出发地址
            'trip_start_address' => !empty($cap_info['address'])?$cap_info['address']:'',
            //订单到达地址
            'trip_end_address' => $address['address'].' '.$address['address_info'],
            //加钟fu
            'add_pid' => $order_id,

            'is_add'  => !empty($order_id)?1:0,

            'pay_model' => $pay_model

        ];
        //下单
        $res = $this->model->dataAdd($order_insert);

        if($res!=1){

            decCache($key,1,$this->_uniacid);

            Db::rollback();

            $this->errorMsg('下单失败');
        }

        decCache($key,1,$this->_uniacid);

        $order_id = $this->model->getLastInsID();
        //使用优惠券
        if(!empty($coupon_id)){

            $coupon_id = $coupon_record_model->couponUse($coupon_id,$order_id);

            $this->model->dataUpdate(['id'=>$order_id],['coupon_id'=>$coupon_id]);

        }
        //添加下单地址
        $res = $address_order_model->orderAddressAdd($address['id'],$order_id);

        if(!empty($res['code'])){

            Db::rollback();

            $this->errorMsg($res['msg']);
        }

     //   if(empty($order_info['order_goods'])){

          //  Db::rollback();

         //   $this->errorMsg('请选择服务项目，请刷新重试');
       // }
        //添加到子订单
        $res = $this->order_goods_model->orderGoodsAdd($order_info['order_goods'],$order_id,$input['coach_id'],$this->getUserId());

        if(!empty($res['code'])){

            Db::rollback();

            $this->errorMsg($res['msg']);
        }

        $order_insert_data = $this->model->dataInfo(['id'=>$order_id]);
        //处理各类佣金情况
        $order_update = $this->model->getCashData($order_insert_data);

        if(!empty($order_update['code'])&&$order_update['code']==300){

            $this->errorMsg('请添加技师等级');

        }

        if(!empty($order_update['order_data'])){

            $this->model->dataUpdate(['id'=>$order_id],$order_update['order_data']);
        }

        Db::commit();
        //如果是0元
        if($order_insert['pay_price']<=0){

            $this->model->orderResult($order_insert['order_code'],$order_insert['order_code']);

            return $this->success(true);
        }
        //余额支付
        if($pay_model==2){

            $user_model = new User();

            $user_balance= $user_model->where(['id'=>$this->getUserId()])->value('balance');

            if($user_balance<$order_insert['pay_price']){

                $this->errorMsg('余额不足');
            }

            $this->model->orderResult($order_insert['order_code'],$order_insert['order_code']);

            return $this->success(true);

        }elseif ($pay_model==3){

            $pay_model = new PayModel($this->payConfig());

            $jsApiParameters = $pay_model->aliPay($order_insert['order_code'],$order_insert['pay_price'],'MassageOrder',1);

            $arr['pay_list']= $jsApiParameters;

            $arr['order_code']= $order_insert['order_code'];

            $arr['order_id']= $order_id;

        }else{
            //微信支付
            $pay_controller = new \app\shop\controller\IndexWxPay($this->app);
            //支付
            $jsApiParameters= $pay_controller->createWeixinPay($this->payConfig(),$this->getUserInfo()['openid'],$this->_uniacid,"anmo",['type' => 'Massage' , 'out_trade_no' => $order_insert['order_code']],$order_insert['pay_price']);

            $arr['pay_list']= $jsApiParameters;

            $arr['order_id']= $order_id;
        }

        return $this->success($arr);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-25 15:59
     * @功能说明:重新支付
     */
    public function rePayOrder(){

        $input = $this->_input;

        $order_insert = $this->model->dataInfo(['id'=>$input['id']]);

        if($order_insert['pay_type']!=1){

            $this->errorMsg('订单状态错误');

        }

        if($order_insert['app_pay']==1&&$this->is_app!=1){

            $this->errorMsg('请到APP完成支付');

        }

        if($order_insert['app_pay']==0&&$this->is_app!=0){

            $this->errorMsg('请到小程序完成支付');
        }

        if($order_insert['app_pay']==2&&$this->is_app!=2) {

            $this->errorMsg('请到公众号完成支付');

        }

        if($order_insert['pay_model']==2){

            $user_model = new User();

            $user_balance= $user_model->where(['id'=>$this->getUserId()])->value('balance');

            if($user_balance<$order_insert['pay_price']){

                $this->errorMsg('余额不足');
            }

            $this->model->orderResult($order_insert['order_code'],$order_insert['order_code']);

            return $this->success(true);

        }elseif ($order_insert['pay_model']==3){

            $pay_model = new PayModel($this->payConfig());

            $jsApiParameters = $pay_model->aliPay($order_insert['order_code'],$order_insert['pay_price'],'MassageOrder');

            $arr['pay_list']= $jsApiParameters;

            $arr['order_code']= $order_insert['order_code'];
        }else{
            //微信支付
            $pay_controller = new \app\shop\controller\IndexWxPay($this->app);
            //支付
            $jsApiParameters= $pay_controller->createWeixinPay($this->payConfig(),$this->getUserInfo()['openid'],$this->_uniacid,"anmo",['type' => 'Massage' , 'out_trade_no' => $order_insert['order_code']],$order_insert['pay_price']);

            $arr['pay_list']= $jsApiParameters;
        }

        return $this->success($arr);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-25 16:38
     * @功能说明:取消订单
     */

    public function cancelOrder(){

        $input = $this->_input;

        $order_insert = $this->model->dataInfo(['id'=>$input['id']]);

        if($order_insert['pay_type']!=1){

            $this->errorMsg('订单状态错误');

        }

       $res = $this->model->cancelOrder($order_insert);

       if(!empty($res['code'])){

           $this->errorMsg($res['msg']);
       }

       $log_model = new OrderLog();

       $log_model->addLog($input['id'],$this->_uniacid,-1,$order_insert['pay_type'],2,$this->_user['id']);

       return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-26 11:39
     * @功能说明:申请退款
     */
    public function applyOrder(){

        $input = $this->_input;

        $order = $this->model->dataInfo(['id'=>$input['order_id']]);

        if(empty($order)){

            $this->errorMsg('订单未找到');
        }

        if($order['pay_type']<2){

            $this->errorMsg('订单状态错误');

        }

        if(empty($input['list'])){

            $this->errorMsg('请选择商品');

        }

//        if($order['can_tx_date']<time()&&$order['pay_type']==7){
//
//            $this->errorMsg('核销后24小时内才能申请退款哦');
//
//        }

        if($order['pay_type']==7){

            $this->errorMsg('核销后不能退款');

        }
        //加钟订单
        if($order['is_add']==0){

            $where[] = ['add_pid','=',$order['id']];

            $where[] = ['pay_type','>',1];

            $add_order = $this->model->dataInfo($where);

            if(!empty($add_order)){

                $this->errorMsg('请先申请加钟订单退款');
            }

            $add_order = $this->model->where(['add_pid'=>$order['id'],'pay_type'=>1])->select()->toArray();

            if(!empty($add_order)){

                foreach ($add_order as $value){

                    $this->model->cancelOrder($value);
                }
            }
        }
        //申请退款
        $res = $this->refund_model->applyRefund($order,$input);

        if(!empty($res['code'])){

            $this->errorMsg($res['msg']);
        }

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-26 15:55
     * @功能说明:取消退款
     */
    public function cancelRefundOrder(){

        $input = $this->_input;

        $order = $this->refund_model->dataInfo(['id'=>$input['id']]);

        if($order['status']!=1){

            $this->errorMsg('订单已经审核');

        }

        Db::startTrans();

        $res = $this->refund_model->dataUpdate(['id'=>$input['id']],['status'=>-1,'cancel_time'=>time()]);

        if($res!=1){

            Db::rollback();

            $this->errorMsg('取消失败');
        }

        if(!empty($order['order_goods'])){

            $order_goods_model = new OrderGoods();

            foreach ($order['order_goods'] as $v){

                if(!empty($v['order_goods_id'])){

                    $num = $v['num'];

                    $res = $order_goods_model->where(['id'=>$v['order_goods_id']])->update(['can_refund_num'=>Db::Raw("can_refund_num+$num")]);

                    if($res!=1){

                        Db::rollback();

                        $this->errorMsg('取消失败');
                    }

                }

            }

        }

        $notice_model = new NoticeList();
        //增加后台提醒
        $notice_model->where(['type'=>2,'order_id'=>$input['id']])->delete();

        Db::commit();

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-04-07 15:30
     * @功能说明:刷新订单二维码
     */
    public function refreshQr(){

        $input = $this->_input;

        $qr_insert = [

            'id' => $input['id']
        ];
        //获取二维码
        $qr = $this->model->orderQr($qr_insert,$this->_uniacid);

        if(!empty($qr)){

            $this->model->dataUpdate(['id'=>$input['id']],['qr'=>$qr]);

        }

        return $this->success($qr);
    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-13 00:18
     * @功能说明:评价标签
     */
    public function lableList(){

        $dis = [

            'uniacid' => $this->_uniacid,

            'status'  => 1
        ];

        $lable_model = new Lable();

        $res = $lable_model->where($dis)->order('top desc,id desc')->select()->toArray();

        return $this->success($res);

    }

    /**
     * @author chenniang
     * @DataTime: 2021-07-12 14:01
     * @功能说明:添加评价
     */
    public function addComment(){

        $input = $this->_input;

        $order = $this->model->dataInfo(['id'=>$input['order_id']]);

        if($order['is_comment']==1){

            $this->errorMsg('你已经评价过了');
        }

        $insert = [

            'uniacid' => $this->_uniacid,

            'user_id' => $this->getUserId(),

            'order_id'=> $input['order_id'],

            'star'    => $input['star'],

            'text'    => $input['text'],

            'coach_id'=> $order['coach_id'],

            'admin_id'=> $order['admin_id'],

        ];

        Db::startTrans();

        $comment_model = new Comment();

        $comment_lable_model   = new CommentLable();

        $lable_model = new Lable();

        $res = $comment_model->dataAdd($insert);

        if($res==0){

            Db::rollback();

            $this->errorMsg('评价失败');
        }

        $comment_id = $comment_model->getLastInsID();

        if(!empty($input['lable'])){

            foreach ($input['lable'] as $value){

                $title = $lable_model->where(['id'=>$value])->value('title');

                $insert = [

                    'uniacid'    => $this->_uniacid,

                    'comment_id' => $comment_id,

                    'lable_id'   => $value,

                    'lable_title'=> $title,

                ];

                $comment_lable_model->dataAdd($insert);
            }

        }

        $comment_model->updateStar($order['coach_id']);

        $res = $this->model->dataUpdate(['id'=>$order['id']],['is_comment'=>1]);

        if($res==0){

            Db::rollback();

            $this->errorMsg('评价失败');
        }
        //添加服务评价
        if(!empty($input['service_star'])){

            $comment_goods_model = new CommentGoods();

            $comment_goods_model->commentAdd($input['service_star'],$this->_uniacid,$comment_id);
        }

        Db::commit();

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-16 18:35
     * @功能说明:删除订单
     */
    public function delOrder(){

        $input = $this->_input;

        $order = $this->model->dataInfo(['id'=>$input['id']]);

        if(!in_array($order['pay_type'],[-1,7])){

            $this->errorMsg('只有取消或完成的订单才能删除');
        }

        $res = $this->model->dataUpdate(['id'=>$input['id']],['is_show'=>0]);

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-06-30 14:27
     * @功能说明:是否支持bus
     */
    public function getIsBus(){

        $input = $this->_param;

        $config_model = new Config();

        $config = $config_model->dataInfo(['uniacid'=>$this->_uniacid]);

        $is_bus = $config['is_bus'];

        if(!empty($input['start_time'])&&!empty($config['bus_start_time'])&&!empty($config['bus_end_time'])){

            $z_time = strtotime(date('Y-m-d',$input['start_time']));

            $start_time = strtotime($config['bus_start_time'])-strtotime(date('Y-m-d',time()))+$z_time;

            $end_time   = strtotime($config['bus_end_time'])-strtotime(date('Y-m-d',time()))+$z_time;

            if($input['start_time']<$start_time){

                $start_time -= 86400;

                $end_time   -= 86400;
            }

            $end_time = $end_time<$start_time?$end_time+86400:$end_time;

            if($input['start_time']<$start_time||$input['start_time']>$end_time){

                $is_bus = 0;
            }

        }

        return $this->success($is_bus);
    }


    /**
     * @author chenniang
     * @DataTime: 2022-12-13 10:04
     * @功能说明:回去可以升级的服务
     */
    public function getUpOrderGoods(){

        $input = $this->_param;

        $order_goods = $this->order_goods_model->dataInfo(['id'=>$input['order_goods_id'],'status'=>1]);

        if(empty($order_goods)){

            $this->errorMsg('未找到升级项目');
        }

        $is_add = $this->model->where(['id'=>$order_goods['order_id']])->value('is_add');

        $coach_id =  $this->model->where(['id'=>$order_goods['order_id']])->value('coach_id');

        $dis[] = ['a.uniacid','=',$this->_uniacid];

        $dis[] = ['a.status','=',1];

        if(!empty($coach_id)){

            $dis[] = ['b.coach_id','=',$coach_id];
        }

        $dis[] = ['a.price','>',$order_goods['true_price']];

        $dis[] = ['a.is_add','=',$is_add];

        $dis[] = ['a.id','<>',$order_goods['goods_id']];

        $service_model = new Service();

        $data = $service_model->serviceCoachList($dis);

        return $this->success($data);
    }


    /**
     * @author chenniang
     * @DataTime: 2022-12-16 11:44
     * @功能说明:服务升级下单页面
     */
    public function upOrderInfo(){

        $input = $this->_input;

        $order = $this->model->dataInfo(['id'=>$input['order_id']]);

        if(empty($order)||!in_array($order['pay_type'],[2,3,4,5,6])){

            $this->errorMsg('订单已关闭');

        }
        //获取升级的服务价格
        $order_data = $this->order_goods_model->getUpGoodsData($input['order_goods']);

        if(!empty($check['code'])){

            $this->errorMsg($check['msg']);

        }

        $order_data['order_start_time'] = date('Y-m-d H:i:s',$order['start_time']);

        $order_data['pay_model'] = $order['pay_model'];

        $order_data['end_time'] = $order['start_time'] + $order_data['total_time_long']*60;

        $order_data['order_end_time'] = date('Y-m-d H:i:s',$order_data['end_time']);

        $coach_model = new Coach();

        if(!empty($order['coach_id'])&&$order['coach_id']>0){

            $order_data['coach_info']['coach_name'] = $coach_model->where(['id'=>$order['coach_id']])->value('coach_name');

        }else{

            $change_log_model = new CoachChangeLog();

            $order_data['coach_info']['coach_name'] = $change_log_model->where(['order_id'=>$input['order_id']])->order('id desc')->value('now_coach_name');

        }

        return $this->success($order_data);
    }


    /**
     * @author chenniang
     * @DataTime: 2022-12-13 10:27
     * @功能说明:服务项目升级
     */
    public function upOrderGoods(){

        $input = $this->_input;

        $order_price_log = new OrderPrice();

        $price_log = $order_price_log->dataInfo(['top_order_id'=>$input['order_id']]);

        if(empty($price_log)){

            $this->error('改订单无法升级,请重新下单');
        }

        $order = $this->model->dataInfo(['id'=>$input['order_id']]);

        if(empty($order)||!in_array($order['pay_type'],[2,3,4,5,6])){

            $this->errorMsg('订单已关闭');

        }

        $refund_model = new RefundOrder();
        //判断有无申请中的退款订单
        $refund_order = $refund_model->dataInfo(['order_id' => $order['id'], 'status' => 1]);

        if (!empty($refund_order)) {

            $this->errorMsg('该订单正在申请退款，无法升级');

        }
        //获取升级的服务价格
        $order_data = $this->order_goods_model->getUpGoodsData($input['order_goods']);

        if(!empty($check['code'])){

            $this->errorMsg($check['msg']);

        }

        $start_time = $order['start_time'];

        $order_data['coach_id'] = $order['coach_id'];
        //校验时间
        $check = $this->model->checkTime($order_data,$start_time,$order['add_pid'],$order['id']);

        if(!empty($check['code'])){

            $this->errorMsg($check['msg']);

        }

        $up_order_model = new UpOrderList();
        //校验加钟订单时间 如果有加钟订单时间需要往后面推
        $check = $up_order_model->checkAddOrderTime($order_data['time_long']*60,$order['id']);

        if(!empty($check['code'])){

            $this->errorMsg($check['msg']);

        }
        $config_model = new Config();

        $config = $config_model->dataInfo(['uniacid'=>$this->_uniacid]);

        Db::startTrans();

        $insert = [

            'uniacid' => $this->_uniacid,

            'order_id'=> $order['id'],

            'user_id' => $order['user_id'],

            'coach_id' => $order['coach_id'],

            'order_code' => orderCode(),

            'order_price'=> $order_data['order_price'],

            'pay_price'  => $order_data['pay_price'],

            'service_price' => $order_data['service_price'],

            'true_service_price' => $order_data['true_service_price'],

            'surplus_price' => $order_data['pay_price'],

            'pay_model'  => $order['pay_model'],

            'over_time'  => time()+$config['over_time']*60,

            'balance'    => $order['pay_model']==2?$order_data['pay_price']:0,

            'time_long' => $order_data['time_long'],

            'discount'  => $order_data['discount'],
        ];

        $up_goods_model = new UpOrderGoods();

        $up_order_model->dataAdd($insert);

        $id = $up_order_model->getLastInsID();
        //添加订单商品
        $res = $up_goods_model->orderGoodsAdd($order_data['order_goods'],$id);

        if(!empty($res['code'])){

            Db::rollback();

            $this->errorMsg($res['msg']);
        }

        Db::commit();
        //如果是0元
        if($insert['pay_price']<=0){

            $up_order_model->orderResult($insert['order_code'],$insert['order_code']);

            return $this->success(true);
        }
        //余额支付
        if($insert['pay_model']==2){

            $user_model = new User();

            $user_balance= $user_model->where(['id'=>$this->getUserId()])->value('balance');

            if($user_balance<$insert['pay_price']){

                $this->errorMsg('余额不足');
            }

            $res = $up_order_model->orderResult($insert['order_code'],$insert['order_code']);

            return $this->success($res);

        }elseif ($insert['pay_model']==3){

            $pay_model = new PayModel($this->payConfig());

            $jsApiParameters = $pay_model->aliPay($insert['order_code'],$insert['pay_price'],'MassageOrder',1);

            $arr['pay_list']  = $jsApiParameters;

            $arr['order_code']= $insert['order_code'];

        }else{
            //微信支付
            $pay_controller = new \app\shop\controller\IndexWxPay($this->app);
            //支付
            $jsApiParameters= $pay_controller->createWeixinPay($this->payConfig(),$this->getUserInfo()['openid'],$this->_uniacid,"anmo",['type' => 'MassageUp' , 'out_trade_no' => $insert['order_code']],$insert['pay_price']);

            $arr['pay_list']= $jsApiParameters;
        }

        return $this->success($arr);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-12-14 17:26
     * @功能说明:客户订单签字
     */
    public function userSignOrder(){

        $input = $this->_input;

        $dis = [

            'uniacid' => $this->_uniacid,

            'order_id'=> $input['id']
        ];

        $order_model = new OrderData();

        $order_model->dataInfo($dis);

        $update = [

            'sign_time' => time(),

            'sign_img'  => $input['sign_img']
        ];

        $res = $order_model->dataUpdate($dis,$update);

        return $this->success($res);
    }


    /**
     * @author chenniang
     * @DataTime: 2022-12-15 11:34
     * @功能说明:订单升级记录
     */
    public function orderUpRecord(){

        $input = $this->_param;

        $order_model = new UpOrderList();

        $data = $order_model->orderUpRecord($input['order_id']);

        return $this->success($data);

    }




}
