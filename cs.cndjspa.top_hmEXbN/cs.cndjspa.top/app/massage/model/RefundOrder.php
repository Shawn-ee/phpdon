<?php
namespace app\massage\model;

use app\admin\model\ShopOrderRefund;
use app\BaseModel;
use longbingcore\wxcore\PayModel;
use think\facade\Db;

class RefundOrder extends BaseModel
{
    //定义表名
    protected $name = 'massage_service_refund_order';



     protected $append = [

         'order_goods',

         'coach_info',

         'address_info',

         'all_goods_num',

     ];



    /**
     * @author chenniang
     * @DataTime: 2021-03-26 16:48
     * @功能说明:
     */
    public function getImgsAttr($value,$data){

        if(!empty($value)){

            return explode(',',$value);
        }

    }

    /**
     * @param $value
     * @param $data
     * @功能说明:总商品数量
     * @author chenniang
     * @DataTime: 2021-03-25 14:39
     */
    public function getAllGoodsNumAttr($value,$data){

        if(!empty($data['id'])){

            $order_goods_model = new RefundOrderGoods();

            $dis = [

                'refund_id' => $data['id']
            ];

            $num = $order_goods_model->where($dis)->sum('num');

            return $num;
        }


    }


    /**
     * @param $value
     * @param $data
     * @功能说明:订单的团长信息
     * @author chenniang
     * @DataTime: 2021-03-19 16:49
     */
    public function getCoachInfoAttr($value,$data){

        if(isset($data['coach_id'])&&isset($data['id'])&&isset($data['order_id'])&&isset($data['is_add'])){

            if(!empty($data['coach_id'])){

                $cap_model = new Coach();

                $info = $cap_model->where(['id'=>$data['coach_id']])->field('id,coach_name,mobile,work_img')->find();

            }else{

                $change_log_model = new CoachChangeLog();

                if($data['is_add']==1){

                    $order_model = new Order();

                    $order_id = $order_model->where(['id'=>$data['order_id']])->value('add_pid');

                }else{

                    $order_id = $data['order_id'];
                }

                $info['coach_name'] = $change_log_model->where(['order_id'=>$order_id])->order('id desc')->value('now_coach_name');

                $info['work_img'] = defaultCoachAvatar();
            }

            return $info;
        }

    }

    /**
     * @author chenniang
     * @DataTime: 2021-03-17 17:16
     * @功能说明:收货信息
     */
    public function getAddressInfoAttr($value,$data){

        if(!empty($data['order_id'])){

            $address_model = new OrderAddress();

            $info = $address_model->dataInfo(['order_id'=>$data['order_id']]);

            return $info;

        }

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-17 17:16
     * @功能说明:收货信息
     */
     public function getOrderGoodsAttr($value,$data){

         if(!empty($data['id'])){

             $goods_model = new RefundOrderGoods();

             $info = $goods_model->dataSelect(['refund_id'=>$data['id']]);

             return $info;

         }

     }

    /**
     * @author chenniang
     * @DataTime: 2021-03-15 14:37
     * @功能说明:后台列表
     */
    public function adminDataList($dis,$page=10,$mapor=[]){

        $data = $this->alias('a')
                ->join('massage_service_coach_list b','a.coach_id = b.id','left')
                ->join('massage_service_refund_order_goods c','a.id = c.refund_id')
                ->join('massage_service_order_list d','a.order_id = d.id')
                ->join('massage_service_order_address e','a.order_id = e.order_id')
                ->where($dis)
                ->where(function ($query) use ($mapor){
                    $query->whereOr($mapor);
                })
                ->field('a.*,e.mobile,d.order_code as pay_order_code,e.user_name,d.pay_price')
                ->group('a.id')
                ->order('a.id desc')
                ->paginate($page)
                ->toArray();


        if(!empty($data['data'])){

            $user_model = new User();

            $admin_model = new Admin();

            foreach ($data['data'] as &$v){

                $v['admin_name'] = $admin_model->where(['id'=>$v['admin_id']])->value('username');

                $v['nickName']   = $user_model->where(['id'=>$v['user_id']])->value('nickName');

            }
        }

        return $data;

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-19 17:46
     * @功能说明:小程序退款列表
     */
    public function indexDataList($dis,$where=[],$page=10){

        $data = $this->alias('a')
            ->join('massage_service_refund_order_goods c','a.id = c.refund_id')
            ->join('massage_service_order_list d','a.order_id = d.id')
            ->where($dis)
            ->where(function ($query) use ($where){
                $query->whereOr($where);
            })
            ->field('a.*,d.order_code as pay_order_code')
            ->group('a.id')
            ->order('a.id desc')
            ->paginate($page)
            ->toArray();

        return $data;

    }


    /**
     * @author chenniang
     * @DataTime: 2021-04-08 17:08
     * @功能说明:退款中
     */
    public function refundIng($cap_id){

        $dis = [

            'cap_id' => $cap_id,

            'status' => 1
        ];

        $count = $this->where($dis)->count();

        return $count;

    }


    /**
     * @author chenniang
     * @DataTime: 2020-09-29 11:04
     * @功能说明:添加
     */
    public function dataAdd($data){

        $data['status'] = 1;

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
     * @author chenniang
     * @DataTime: 2021-03-18 09:37
     * @功能说明:通过退款
     */
    public function passOrder($id,$price,$payConfig,$refund_user=0,$text=''){

        $refund_order= $this->dataInfo(['id'=>$id]);

        $order_model = new Order();

        $pay_order   = $order_model->dataInfo(['id'=>$refund_order['order_id']]);

        if($refund_order['status']!=1){

            return ['code'=>500,'msg'=>'订单状态错误'];
        }

        $update = [

            'status'      => 2,

            'refund_time' => time(),

            'refund_price'=> $price,

            'refund_text' => $text
        ];

        $comm_model = new Commission();

        Db::startTrans();
        //分销佣金
        $comm_model->refundComm($id);

        $res = $this->dataUpdate(['id'=>$refund_order['id']],$update);

        if($res!=1){

            Db::rollback();

            return ['code'=>500,'msg'=>'退款失败，请重试'];

        }
        //修改退款子订单的退款状态
        $order_refund_goods = new RefundOrderGoods();

        $res = $order_refund_goods->dataUpdate(['refund_id'=>$id],['status'=>2]);

        if($res==0){

            Db::rollback();

            return ['code'=>500,'msg'=>'退款失败，请重试1'.$res];

        }

        $goods_model = new Service();
        //退换库存
        foreach ($refund_order['order_goods'] as $v){

            $res = $goods_model->setOrDelStock($v['goods_id'],$v['num'],1);

            if(!empty($res['code'])){

                Db::rollback();

                return $res;

            }

        }
        //修改佣金加盟商技师信息
        $comm_model->refundCash($pay_order['id']);
        //如果是加钟订单后面的加钟订单时间要往前移
        $order_model->updateAddOrderTime($pay_order,$refund_order['time_long']*60);
        //修改支付订单的各类信息
        $res = $this->updatePayorderData($pay_order,$refund_order,$price);

        if($res!=1){

            Db::rollback();

            return ['code'=>500,'msg'=>'退款失败，请重试2'];

        }
        //退款
        if($price>0){

            $res = $this->refundCash($payConfig,$pay_order,$price,$id);

            if(!empty($res['code'])){

                Db::rollback();

                return ['code'=>500,'msg'=>$res['msg']];
            }

            if($res!=true){

                Db::rollback();

                return ['code'=>500,'msg'=>'退款失败，请重试2'];
            }

        }

        $log_model = new OrderLog();
        //订单操作日志
        $log_model->addLog($pay_order['id'],$pay_order['uniacid'],-1,$pay_order['pay_type'],1,$refund_user);

        Db::commit();

        return true;

    }


    /**
     * @author chenniang
     * @DataTime: 2023-02-17 16:18
     * @功能说明:退款修改主订单代信息
     */
    public function updatePayorderData($pay_order,$refund_order,$price){
        //退款的总时长
        $true_time_long = $pay_order['true_time_long'] - $refund_order['time_long'];

        $true_time_long = $true_time_long>0?$true_time_long:0;

        $order_update = [

            'true_time_long' => $true_time_long,

        ];

        if($refund_order['apply_price']>0){
            //服务费占总退款的比例
            $ser_bin = $refund_order['service_price']/$refund_order['apply_price'];
            //扣除退款后的服务费
            $coach_price = $pay_order['true_service_price'] - $price*$ser_bin;

            $coach_price = $coach_price>0?round($coach_price,2):0;

            $order_update['true_service_price'] = $coach_price;

        }
        //查看货是否退完了
        $refund_success = $this->checkRefundNum($refund_order['order_id']);
        //退完了 就修改订单状态
        if($refund_success==1){

            $order_update['pay_type'] = -1;
            //未接单退换优惠券
            if(!empty($pay_order['pay_type'])&&$pay_order['pay_type']<=3){
                //退换优惠券
                $coupon_model = new CouponRecord();

                $coupon_model->couponRefund($pay_order['id']);
            }
            //如果技师出发需要给技师车费
            if(!empty($pay_order['pay_type'])&&$pay_order['pay_type']>3&&!empty($pay_order['true_car_price'])){

                $coach_model = new Coach();

                $car_cash = $pay_order['true_car_price'];

                $coach_model->where(['id'=>$pay_order['coach_id']])->update(['car_price'=>Db::raw("car_price+$car_cash")]);
            }
            //分销
            $comm_model = new Commission();
            //将分销记录打开
            $comm_model->dataUpdate(['order_id'=>$refund_order['order_id'],'status'=>1],['status'=>-1]);
        }else{

            $order_update['end_time'] = $pay_order['end_time'] - $refund_order['time_long']*60;

        }

        $order_model = new Order();

        $res = $order_model->dataUpdate(['id'=>$refund_order['order_id']],$order_update);

        return $res;

    }





    /**
     * @author chenniang
     * @DataTime: 2022-12-14 12:19
     * @功能说明:是否升级过
     */
    public function isUpOrder($pay_order){

        $order_model = new UpOrderList();

        $dis = [

            'order_id' => $pay_order['id'],

            'pay_type' => 2
        ];

        $find = $order_model->dataInfo($dis);

        return !empty($find)?1:0;
    }


    /**
     * @author chenniang
     * @DataTime: 2022-12-14 12:35
     * @功能说明:升级订单退款（微信）
     */
    public function upOrderRefundWeixin($payConfig,$pay_order,$price,$refund_id=0){

        $price_log_model = new OrderPrice();

        $order_model = new Order();
        //订单金额日志
        $log = $price_log_model->where(['top_order_id'=>$pay_order['id']])->where('can_refund_price','>',0)->order('order_price desc,id')->select()->toArray();

        $refund_price = 0;

        foreach ($log as $value){

            $price -= $refund_price;
            //说明退完了
            if($price<=0){

                return true;
            }
            //要退的金额
            $app_price = $price>=$value['can_refund_price']?$value['can_refund_price']:$price;
            //修改订单日志里面的可退款金额
            $price_log_model->dataUpdate(['id'=>$value],['can_refund_price'=>$value['can_refund_price']-$app_price]);
            //增加退款金额
            $refund_price+= $app_price;

            $response = orderRefundApi($payConfig,$value['order_price'],$app_price,$value['transaction_id']);
            //如果退款成功修改一下状态
            if ( isset($response[ 'return_code' ]) && isset( $response[ 'result_code' ] ) && $response[ 'return_code' ] == 'SUCCESS' && $response[ 'result_code' ] == 'SUCCESS' ) {

                $response['out_refund_no'] = !empty($response['out_refund_no'])?$response['out_refund_no']:$pay_order['order_code'];

                if(!empty($refund_id)){

                    $this->dataUpdate(['id'=>$refund_id],['out_refund_no'=>$response['out_refund_no']]);

                }else{

                    $order_model->dataUpdate(['id'=>$pay_order['id']],['coach_refund_code'=>$response['out_refund_no']]);
                }

            }else {
                //失败就报错
                $discption = !empty($response['err_code_des'])?$response['err_code_des']:$response['return_msg'];

                return ['code'=>500,'msg'=> $discption];

            }

        }

        return true;
    }



    /**
     * @author chenniang
     * @DataTime: 2022-12-14 12:35
     * @功能说明:升级订单退款（支付宝）
     */
    public function upOrderRefundAli($payConfig,$pay_order,$price,$refund_id=0){

        $price_log_model = new OrderPrice();

        $order_model = new Order();
        //支付宝
        $pay_model = new PayModel($payConfig);
        //订单金额日志
        $log = $price_log_model->where(['top_order_id'=>$pay_order['id']])->where('can_refund_price','>',0)->order('order_price desc,id')->select()->toArray();

        $refund_price = 0;

        foreach ($log as $value){

            $price -= $refund_price;
            //说明退完了
            if($price<=0){

                return true;
            }
            //要退的金额
            $app_price = $price>=$value['can_refund_price']?$value['can_refund_price']:$price;
            //修改订单日志里面的可退款金额
            $price_log_model->dataUpdate(['id'=>$value],['can_refund_price'=>$value['can_refund_price']-$app_price]);
            //增加退款金额
            $refund_price+= $app_price;

            $res = $pay_model->aliRefund($pay_order['transaction_id'],$price);

            if(isset($res['alipay_trade_refund_response']['code'])&&$res['alipay_trade_refund_response']['code']==10000){

                if(!empty($refund_id)){

                    $this->dataUpdate(['id'=>$pay_order['id']],['out_refund_no'=>$res['alipay_trade_refund_response']['out_trade_no']]);

                }else{

                    $order_model->dataUpdate(['id'=>$pay_order['id']],['coach_refund_code'=>$res['alipay_trade_refund_response']['out_trade_no']]);
                }
            }else{

                return ['code'=>500,'msg'=> $res['alipay_trade_refund_response']['sub_msg']];

            }

        }

        return true;
    }
    /**
     * @param $payConfig
     * @param $pay_order
     * @param $price
     * @param int $refund_id
     * @功能说明:退钱
     * @author chenniang
     * @DataTime: 2021-07-12 20:31
     */
    public function refundCash($payConfig,$pay_order,$price,$refund_id=0){

        $order_model = new Order();

        $is_up = $this->isUpOrder($pay_order);

        if($pay_order['pay_model']==1){
            //没有升级过 目前的设计看来退款不会存在升级过，先保留
            if($is_up==0){
                //微信退款
                $response = orderRefundApi($payConfig,$pay_order['pay_price'],$price,$pay_order['transaction_id']);
                //如果退款成功修改一下状态
                if ( isset( $response[ 'return_code' ] ) && isset( $response[ 'result_code' ] ) && $response[ 'return_code' ] == 'SUCCESS' && $response[ 'result_code' ] == 'SUCCESS' ) {

                    $response['out_refund_no'] = !empty($response['out_refund_no'])?$response['out_refund_no']:$pay_order['order_code'];

                    if(!empty($refund_id)){

                        $this->dataUpdate(['id'=>$refund_id],['out_refund_no'=>$response['out_refund_no']]);

                    }else{

                        $order_model->dataUpdate(['id'=>$pay_order['id']],['coach_refund_code'=>$response['out_refund_no']]);
                    }

                }else {
                    //失败就报错
                    $discption = !empty($response['err_code_des'])?$response['err_code_des']:$response['return_msg'];

                    return ['code'=>500,'msg'=> $discption];

                }

            }else{

                $res = $this->upOrderRefundWeixin($payConfig,$pay_order,$price,$refund_id=0);

                if(!empty($res['code'])){

                    return $res;
                }

            }
        }elseif($pay_order['pay_model']==2){

            $water_model = new BalanceWater();

            $pay_order['pay_price'] = $price;

            $res = $water_model->updateUserBalance($pay_order,3,1);
            //修改用户余额
            if($res==0){

                return false;

            }

        }else{
            //没有升级过
            if($is_up==0) {
                //支付宝
                $pay_model = new PayModel($payConfig);

                $res = $pay_model->aliRefund($pay_order['transaction_id'], $price);

                if (isset($res['alipay_trade_refund_response']['code']) && $res['alipay_trade_refund_response']['code'] == 10000) {

                    if (!empty($refund_id)) {

                        $this->dataUpdate(['id' => $pay_order['id']], ['out_refund_no' => $res['alipay_trade_refund_response']['out_trade_no']]);

                    } else {

                        $order_model->dataUpdate(['id' => $pay_order['id']], ['coach_refund_code' => $res['alipay_trade_refund_response']['out_trade_no']]);
                    }
                } else {

                    return ['code' => 500, 'msg' => $res['alipay_trade_refund_response']['sub_msg']];

                }
            }else{

                $res = $this->upOrderRefundAli($payConfig,$pay_order,$price,$refund_id=0);

                if(!empty($res['code'])){

                    return $res;
                }
            }

        }

        return true;


    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-18 10:29
     * @功能说明:检查改订单款退完了没
     */
    public function checkRefundNum($order_id){

        $order_goods_model = new OrderGoods();

        $order_refund_goods_model = new RefundOrderGoods();

        $order_model = new Order();

        $dis = [

            'order_id' => $order_id
        ];

        $goods_num = $order_goods_model->where($dis)->sum('num');

        $dis['status'] = 2;

        $refund_num= $order_refund_goods_model->where($dis)->sum('num');

        return $refund_num>=$goods_num?1:0;

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-18 15:38
     * @功能说明:该天的退款
     */
    public function datePrice($date,$uniacid,$cap_id=0,$end_time='',$type=1){

        $end_time = !empty($end_time)?$end_time:$date+86399;

        $dis = [];

        $dis[] = ['status','=',2];

        $dis[] = ['create_time','between',"$date,$end_time"];

        $dis[] = ['uniacid',"=",$uniacid];

        if(!empty($cap_id)){

            $dis[] = ['cap_id','=',$cap_id];
        }

        if($type==1){

            $price = $this->where($dis)->sum('refund_price');

            return round($price,2);

        }else{

            $count = $this->where($dis)->count();

            return $count;
        }


    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-26 13:33
     * @功能说明:申请退款
     */
    public function applyRefund($order,$input){

        $order_goods_model = new OrderGoods();

        $refund_price = 0;

        Db::startTrans();

        $list = $input['list'];

        $time_long = 0;

        foreach ($list as $k=>$value){

            if(!empty($value['id'])){

                $order_goods = $order_goods_model->dataInfo(['id'=>$value['id']]);

                $time_long += $order_goods['time_long']*$value['num'];

                if(empty($order_goods)){

                    return ['code'=>500,'msg'=>'商品未找到'];
                }

                if($value['num']>$order_goods['can_refund_num']||$value['num']==0){

                    return ['code'=>500,'msg'=>'退款数量错误'];

                }
                //退款金额
                $refund_price += $order_goods['true_price']*$value['num'];

                $list[$k]['goods_id']    = $order_goods['goods_id'];

                $list[$k]['goods_name']  = $order_goods['goods_name'];

                $list[$k]['goods_cover'] = $order_goods['goods_cover'];

                $list[$k]['goods_price'] = $order_goods['price'];

                $res = $order_goods_model->where(['id'=>$value['id']])->update(['can_refund_num'=>$order_goods['can_refund_num']-$value['num']]);

                if($res!=1){

                    Db::rollback();

                    return ['code'=>500,'msg'=>'申请失败'];

                }
            }
        }

        $new_order_goods = $order_goods_model->where(['order_id'=>$order['id']])->select()->toArray();
        //剩余可申请退款数量
        $can_refund_num = array_sum(array_column($new_order_goods,'can_refund_num'));

        $car_price = 0;

        $refund_goods_model = new RefundOrderGoods();
        //有没有拒绝退款的
        $refund_goods_num = $refund_goods_model->where(['order_id'=>$order['id'],'status'=>3])->count();

        $change_log_model = new CoachChangeLog();
        //转派订单的时候是否给了车费
        $have_car_price = $change_log_model->dataInfo(['order_id'=>$order['id'],'status'=>1,'have_car_price'=>1]);
        //退车费
        if(!in_array($order['pay_type'],[4,5,6,7])&&$can_refund_num==0&&empty($refund_goods_num)&&empty($have_car_price)){

            $car_price = $order['car_price'];

        }

        $insert = [

            'uniacid'    => $order['uniacid'],

            'user_id'    => $order['user_id'],

            'admin_id'   => $order['admin_id'],

            'time_long'  => $time_long,

            'order_code' => orderCode(),

            'coach_id'   => $order['coach_id'],

            'apply_price'=> round($refund_price+$car_price,2),

            'service_price'=> $refund_price,

            'order_id'   => $order['id'],

            'is_add'     => $order['is_add'],

            'text'       => $input['text'],

            'car_price'  => $car_price,

            'imgs'       => !empty($input['imgs'])?implode(',',$input['imgs']):'',

            'balance'    => !empty($order['balance'])?$refund_price:0,

        ];

        $res = $this->dataAdd($insert);

        if($res!=1){

            Db::rollback();

            return ['code'=>500,'msg'=>'申请失败'];

        }

        $refund_id = $this->getLastInsID();

        foreach ($list as $value){

            $insert = [

                'uniacid'        => $order['uniacid'],

                'order_id'       => $order['id'],

                'refund_id'      => $refund_id,

                'order_goods_id' => $value['id'],

                'goods_id'       => $value['goods_id'],

                'goods_name'     => $value['goods_name'],

                'goods_cover'    => $value['goods_cover'],

                'num'            => $value['num'],

                'goods_price'    => $value['goods_price'],

                'status'         => 1
            ];

            $res = $refund_goods_model->dataAdd($insert);

            if($res!=1){

                Db::rollback();

                return ['code'=>500,'msg'=>'申请失败'];

            }

        }


        Db::commit();

        $notice_model = new NoticeList();
        //增加后台提醒
        $notice_model->dataAdd($order['uniacid'],$refund_id,2);

        $coach_model = new Coach();

        $refund_order = $this->dataInfo(['id'=>$refund_id]);
        //发送公众号消息
        $coach_model->refundSendMsg($refund_order);

        return $refund_id;

    }


    /**
     * @author chenniang
     * @DataTime: 2021-04-12 09:23
     * @功能说明:获取订单已经退款的数量
     */
    public function refundNum($order_goods_id){

        $dis = [

            'b.order_goods_id' => $order_goods_id,

            'a.status'   => 2
        ];

        $num = $this->alias('a')
                ->join('massage_service_refund_order_goods b','a.id = b.refund_id')
                ->where($dis)
                ->group('b.order_goods_id')
                ->sum('b.num');

        return $num;

    }


//    /**
//     * @author chenniang
//     * @DataTime: 2021-04-12 09:23
//     * @功能说明:获取订单已经退款的数量
//     */
//    public function refundPrice($order_goods_id){
//
//        $dis = [
//
//            'b.order_goods_id' => $order_goods_id,
//
//            'a.status'   => 2
//        ];
//
//        $num = $this->alias('a')
//            ->join('massage_service_refund_order_goods b','a.id = b.refund_id')
//            ->where($dis)
//            ->group('b.order_goods_id')
//            ->sum('b.num');
//
//        return $num;
//
//    }


    /**
     * @author chenniang
     * @DataTime: 2021-04-12 12:04
     * @功能说明:拒绝退款
     */
    public function noPassRefund($refund_id){

        $dis = [

            'id' => $refund_id
        ];

        $refund_order = $this->dataInfo($dis);

        if($refund_order['status']!=1){

            return ['code'=>500,'msg'=>'退款状态错误'];

        }

        $update = [

            'status'      => 3,

            'refund_time' => time()

        ];

        Db::startTrans();

        $res = $this->dataUpdate($dis,$update);

        if($res!=1){

            Db::rollback();

            return ['code'=>500,'msg'=>'退款失败，请重试'];

        }
        //修改退款子订单的退款状态
        $order_refund_goods = new RefundOrderGoods();

        $res = $order_refund_goods->dataUpdate(['refund_id'=>$refund_id],['status'=>3]);

        if($res!=1){

            Db::rollback();

            return ['code'=>500,'msg'=>'退款失败，请重试'];

        }

        Db::commit();

        return true;

    }










}