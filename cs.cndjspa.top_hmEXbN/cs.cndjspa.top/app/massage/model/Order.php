<?php
namespace app\massage\model;

use app\BaseModel;
use think\facade\Db;

class Order extends BaseModel
{
    //定义表名
    protected $name = 'massage_service_order_list';


     protected $append = [

         'coach_info',

         'order_goods',

         'all_goods_num',

         'address_info'

     ];



    /**
     * @param $value
     * @param $data
     * @功能说明:
     * @author chenniang
     * @DataTime: 2022-11-10 11:38
     */
     public function getPayModelAttr($value,$data){
         //兼容
         if(isset($value)&&isset($data['balance'])){

             if($value==1&&$data['balance']>0){

                 $value = 2;
             }

             return $value;
         }

     }


    /**
     * @param $value
     * @param $data
     * @功能说明:地址信息
     * @author chenniang
     * @DataTime: 2021-04-08 10:11
     */
     public function getAddressInfoAttr($value,$data){

         if(!empty($data['id'])){

             $address_model = new OrderAddress();

             $address_info = $address_model->dataInfo(['order_id'=>$data['id']]);

             return $address_info;
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

             $order_goods_model = new OrderGoods();

             $dis = [

                 'order_id' => $data['id'],

                 'status' => 1
             ];

             $num = $order_goods_model->where($dis)->sum('num');

             return $num;
         }


     }


    /**
     * @author chenniang
     * @DataTime: 2021-03-19 17:05
     * @功能说明:子订单信息
     */

     public function getOrderGoodsAttr($value,$data){

         if(!empty($data['id'])){

             $order_goods_model = new OrderGoods();

             $dis = [

                 'order_id' => $data['id'],

                 'status' => 1
             ];

             $list = $order_goods_model->where($dis)->select()->toArray();

             return $list;

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

         if(isset($data['coach_id'])&&isset($data['id'])&&isset($data['add_pid'])){

             if(!empty($data['coach_id'])&&$data['coach_id']>0){

                 $cap_model = new Coach();

                 $info = $cap_model->where(['id'=>$data['coach_id']])->field('id,coach_name,mobile,work_img')->find();

             }else{

                 $change_log_model = new CoachChangeLog();

                 $order_id = !empty($data['add_pid'])?$data['add_pid']:$data['id'];

                 $info['coach_name'] = $change_log_model->where(['order_id'=>$order_id])->order('id desc')->value('now_coach_name');

                 $info['mobile']   = $change_log_model->where(['order_id'=>$order_id])->order('id desc')->value('now_coach_mobile');

                 $info['work_img'] = defaultCoachAvatar();
             }

             return $info;
         }

     }


    /**
     * @author chenniang
     * @DataTime: 2021-03-19 16:23
     * @功能说明:前端订单列表
     */

     public function indexDataList($dis,$mapor,$page=10){

         $data = $this->alias('a')
             ->join('massage_service_order_goods_list b','a.id = b.order_id')
             ->where($dis)
             ->where(function ($query) use ($mapor){
                 $query->whereOr($mapor);
             })
             ->field('a.id,a.coach_id,a.order_code,a.pay_type,a.pay_price,a.start_time,a.create_time,a.user_id,a.end_time,a.add_pid,a.is_add')
             ->group('a.id')
             ->order('a.id desc')
             ->paginate($page)
             ->toArray();

         if(!empty($data['data'])){

             foreach ($data['data'] as &$v){

                 $v['create_time'] = date('Y-m-d H:i:s',$v['create_time']);

                 $v['start_time']  = date('Y-m-d H:i',$v['start_time']);

                 $v['end_time']    = date('Y-m-d H:i',$v['end_time']);

             }
         }

         return $data;

     }


    /**
     * @author chenniang
     * @DataTime: 2023-03-08 11:53
     * @功能说明:通过搜索获取订单id
     */
     public function SearchCoachOrderId($uniacid,$coach_name){






     }



    /**
     * @author chenniang
     * @DataTime: 2021-03-15 14:37
     * @功能说明:后台列表
     */
    public function adminDataList($dis,$page=10,$map=[]){

        $data = $this->alias('a')
                ->join('massage_service_coach_list b','a.coach_id = b.id','left')
                ->join('massage_order_coach_change_logs c','(a.add_pid = c.order_id||a.id = c.order_id) AND c.is_new = 1','left')
                ->join('massage_channel_list e','a.channel_id = e.id','left')
                ->where($dis)
                ->where(function ($query) use ($map){
                    $query->whereOr($map);
                })
                ->field('a.*,b.coach_name,e.user_name as channel_name,e.cate_id as channel_cate')
                ->group('a.id')
                ->order('a.id desc')
                ->paginate($page)
                ->toArray();

        if(!empty($data['data'])){

            $user_model  = new User();

            $admin_model = new Admin();

            $refund_model = new RefundOrder();

            $channel_cate = new ChannelCate();

            foreach ($data['data'] as &$v){

                $v['admin_name'] = $admin_model->where(['id'=>$v['admin_id']])->value('username');

                $v['mobile'] = !empty($v['address_info'])?$v['address_info']['mobile']:'';

                $v['user_name'] = !empty($v['address_info'])?$v['address_info']['user_name']:'';

                $v['channel'] = $channel_cate->where(['id'=>$v['channel_cate']])->value('title');

                $v['nickName'] = $user_model->where(['id'=>$v['user_id']])->value('nickName');

                $v['distance'] = distance_text($v['distance']);

                $v['refund_price'] = $refund_model->where(['order_id'=>$v['id'],'status'=>2])->sum('refund_price');
                //加钟订单
                if($v['is_add']==0){

                    $v['add_order_id'] = $this->where(['add_pid'=>$v['id']])->where('pay_type','>',1)->field('id,order_code')->select()->toArray();

                }else{

                    $v['add_pid'] = $this->where(['id'=>$v['add_pid']])->field('id,order_code')->find();

                }
            }
        }

        return $data;

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-15 14:37
     * @功能说明:后台列表
     */
    public function adminOrderPrice($dis,$type=1,$map=[]){

        $data = $this->alias('a')
            ->join('massage_service_coach_list b','a.coach_id = b.id','left')
            ->join('massage_order_coach_change_logs c','(a.add_pid = c.order_id||a.id = c.order_id) AND c.is_new = 1','left')
            ->join('massage_channel_list e','a.channel_id = e.id','left')
            ->where($dis)
            ->where(function ($query) use ($map){
                $query->whereOr($map);
            })
            ->column('a.id');

        if($type==1){

            $price = $this->where('id','in',$data)->sum('true_service_price');

        }else{

            $price = $this->where('id','in',$data)->sum('true_car_price');
        }

        return round($price,2);
    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-15 14:37
     * @功能说明:后台列表
     */
    public function adminDataSelect($dis,$map=[]){

        $data = $this->alias('a')
            ->join('massage_service_coach_list b','a.coach_id = b.id','left')
            ->join('massage_service_order_goods_list c','a.id = c.order_id')
            ->join('massage_channel_list e','a.channel_id = e.id','left')
            ->join('massage_order_coach_change_logs d','(a.add_pid = d.order_id||a.id = d.order_id) AND d.is_new = 1','left')
            ->where($dis)
            ->where(function ($query) use ($map){
                $query->whereOr($map);
            })
            ->field('a.*,b.coach_name,c.goods_id,c.goods_name,c.price,c.num,e.user_name as channel_name,e.cate_id as channel_cate')
            ->group('a.id,c.goods_id')
            ->order('a.id desc')
            ->select()
            ->toArray();

        if(!empty($data)){

            $user_model  = new User();

            $refund_model= new RefundOrder();

            $channel_cate= new ChannelCate();

            $admin_model = new Admin();

            foreach ($data as &$v){

                $v['admin_name'] = $admin_model->where(['id'=>$v['admin_id']])->value('username');

                $v['mobile'] = !empty($v['address_info'])?$v['address_info']['mobile']:'';

                $v['user_name'] = !empty($v['address_info'])?$v['address_info']['user_name']:'';

                $v['channel'] = $channel_cate->where(['id'=>$v['channel_cate']])->value('title');

                $v['nickName'] = $user_model->where(['id'=>$v['user_id']])->value('nickName');

                $v['refund_price'] = $refund_model->where(['order_id'=>$v['id'],'status'=>2])->sum('refund_price');
                //加钟订单
                if($v['is_add']==0){

                    $v['add_order_id'] = $this->where(['add_pid'=>$v['id']])->where('pay_type','>',1)->field('id,order_code')->select()->toArray();

                }else{

                    $v['add_pid'] = $this->where(['id'=>$v['add_pid']])->field('id,order_code')->find();

                }
            }
        }

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
     * @DataTime: 2021-03-18 14:33
     * @功能说明:
     */
    public function datePrice($date,$uniacid,$cap_id=0,$end_time = '',$type=1){

        $end_time = !empty($end_time)?$end_time:$date+86399;

        $dis = [];

        $dis[] = ['transaction_id','<>',''];

        $dis[] = ['auto_refund','=',0];

        $dis[] = ['create_time','between',"$date,$end_time"];

        $dis[] = ['uniacid',"=",$uniacid];

        if(!empty($cap_id)){

            $dis[] = ['cap_id','=',$cap_id];
        }

        if($type==1){

            $price = $this->where($dis)->sum('pay_price');

            return round($price,2);

        }else{

            $count = $this->where($dis)->count();

            return $count;

        }


    }




    /**
     * @author chenniang
     * @DataTime: 2021-03-19 09:28
     * @功能说明:计算用户下单时候的各类金额
     */
    public function payOrderInfo($user_id,$cap_id,$lat=0,$lng=0,$car_type=0,$coupon=0,$order_id=0){

        $car_model = new Car();

        $coupon_model = new Coupon();

        $coach_model = new Coach();

        $car_config_model = new CarPrice();

        $coach = $coach_model->dataInfo(['id'=>$cap_id]);
        //获取购物车里面的信息
        $car_list = $car_model->carPriceAndCount($user_id,$cap_id,0,$order_id);

        $car_list = $coupon_model->orderCouponData($car_list,$coupon);

        $goods_price = $car_list['car_price'];

        $data['coupon_id']   = $car_list['coupon_id'];
        //购物车列表
        $data['order_goods'] = $car_list['list'];
        //优惠券优惠
        $data['discount']    = $car_list['total_discount'];
        //商品总价格
        $data['init_goods_price'] = round($goods_price,2);

        $data['goods_price'] = round($goods_price-$data['discount'],2);

        if(!empty($cap_id)){

            $data['car_config'] = $car_config_model->getCityConfig($coach['uniacid'],$coach['city_id']);

            if($lat==0){

                $data['car_price'] = 0;

                $data['distance'] = 0;

            }else{

                $data['distance']  = getDriveDistance($coach['lng'],$coach['lat'],$lng,$lat,$coach['uniacid']);

                $data['distance'] += $data['car_config']['invented_distance']*$data['distance']/100;
                //车费
                $data['car_price'] = $this->getCarPrice($data['distance'],$data['car_config'],$car_type);
            }
        }else{

            $data['car_price'] = 0;

            $data['distance'] = 0;
        }
        //订单支付价
        $data['pay_price']   = round($data['goods_price']+$data['car_price'] ,2);

        $data['coach_id']    = $cap_id;

        return $data;
    }


    /**
     * @author chenniang
     * @DataTime: 2023-02-16 10:45
     * @功能说明:代理商的分销比例
     */
    public function agentCashData($admin,$order){
        //县级代理商
        if(!empty($admin)&&!empty($admin['admin_pid'])&&in_array($admin['city_type'],[1,2])){

            $order['level_balance'] = $admin['level_balance'];

            $order['admin_pid']     = $admin['admin_pid'];
            //查看是否还有上级
            $admin_pdata = $this->dataInfo(['id'=>$order['admin_pid']]);
            //只有市才有上级
            if(!empty($admin_pdata)&&$admin_pdata['city_type']==1){

                $order['p_level_balance'] = $admin_pdata['level_balance'];

                $order['p_admin_pid']     = $admin_pdata['admin_pid'];
            }
        }

        return $order;

    }




    /**
     * @param $order
     * @功能说明:获取佣金数据
     * @author chenniang
     * @DataTime: 2022-06-13 13:42
     */
    public function getCashData($order,$type=1){

        $coach_model = new Coach();

        $admin_model = new Admin();

        $comm_model  = new Commission();

        $clock_model = new ClockSetting();
        //下单
        if($type==1){

            $coach = $coach_model->dataInfo(['id'=>$order['coach_id']]);
            //技师等级
            $coach_level = $coach_model->getCoachLevel($order['coach_id'],$order['uniacid']);

            if(empty($coach_level)&&!empty($order['coach_id'])){

                return ['code'=>300];
            }

            $coach_level['balance'] = !empty($coach_level)?$coach_level['balance']:0;
            //技师佣金比列
            $order['coach_balance'] = $coach_level['balance'];
            //加钟的时候比例可能是特殊设置
            $order['coach_balance'] = $clock_model->getCoachBalance($order);

            $admin_id = !empty($coach['admin_id'])?$coach['admin_id']:0;

            $order = $admin_model->agentBalanceData($admin_id,$order);
            //获取分销商的金额并添加分销记录
            $order['user_cash'] = $comm_model->commissionAddData($order);

        }
        //平台抽层
        $order['company_cash'] = round($order['admin_balance']*$order['true_service_price']/100,2);
        //技师佣金
        $order['coach_cash']   = round($order['coach_balance']*$order['true_service_price']/100,2);
        //剩下的佣金
        $admin_cash = $order['true_service_price'] - $order['user_cash'] - $order['coach_cash'];

        $admin_cash = $admin_cash>0?$admin_cash:0;
        //平台抽成
        $order['company_cash'] = $order['company_cash'] - $admin_cash>0?$admin_cash:$order['company_cash'];

        $admin_cash -= $order['company_cash'];
        //代理商佣金
        $order = $admin_model->agentCashData($order,$admin_cash);

        $admin_cash = $order['over_cash'];
        //加盟商佣金
        $order['admin_cash'] = $admin_cash>0&&!empty($order['admin_id'])?round($admin_cash,2):0;
        //增加分销记录
        if($type==1){
            //技师佣金记录
            $comm_model->coachCommission($order);
            //加盟商佣金记录
            $comm_model->adminCommission($order);
            //有二级
            $comm_model->adminLevelCommission($order);
            //省代
            $comm_model->adminProvinceCommission($order);

        }

        $arr = ['coach_balance','admin_balance','admin_id','user_cash','company_cash','coach_cash','admin_cash'];

        foreach ($arr as $value){

            if(key_exists($value,$order)){

                $list[$value] = $order[$value];
            }
        }

        $arr_data['order_data'] = $list;

        $arr_data['data'] = $order;

        return $arr_data;

    }













    /**
     * @author chenniang
     * @DataTime: 2021-07-09 17:43
     * @功能说明:计算车费
     */
    public function getCarPrice($distance,$config,$car_type=1){

        if($car_type==0){

            return 0;
        }
        //起步距离
        $start = $config['start_distance'];
        //起步价
        $start_price = $config['start_price'];
        //每公里多少钱
        $to_price = $config['distance_price'];

        $distance = $distance/1000;
        //多少公里内免费
        if($distance<$config['distance_free']){

            return 0;
        }
        //超过起步距离
        if($distance>$start){

            $to_price = round($distance - $start,2)*$to_price;

            $total    = $to_price+$start_price;

            return round($total*2,2);

        }else{

            return round($start_price*2,2);
        }

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-22 11:31
     * @功能说明:订单支付回调
     */
    public function orderResult($order_code,$transaction_id){

        $order = $this->dataInfo(['order_code'=>$order_code,'transaction_id'=>'']);

        if(!empty($order)){

            Db::startTrans();

            $update = [

                'transaction_id' => $transaction_id,

                'pay_type'       => 2,

                'pay_time'       => time(),

            ];

            $res = $this->dataUpdate(['id'=>$order['id'],'transaction_id'=>''],$update);

            if($res==0){

                Db::rollback();

                return false;

            }
            //扣除余额
            if($order['balance']>0){

                $water_model = new BalanceWater();

                $res = $water_model->updateUserBalance($order,2);

                if($res==0){

                    Db::rollback();

                    return false;
                }
            }
            //分销
            $comm_model = new Commission();
            //将分销记录打开
            $comm_model->dataUpdate(['order_id'=>$order['id'],'status'=>-1],['status'=>1]);

            Db::commit();

            $order_price_log = new OrderPrice();
            //增加订单金额日志
            $order_price_log->logAdd($order,$order['id'],1);

            $notice_model = new NoticeList();
            //增加后台提醒
            $notice_model->dataAdd($order['uniacid'],$order['id'],1,$order['admin_id']);

            $coach_model = new Coach();
            //发送通知
            $coach_model->paySendMsg($order);
            //打印
            $print_model = new Printer();

            $print_model->printer($order['id'],0);
            //语音电话通知
            $call_model = new \app\reminder\model\Config();

            $call_model->sendCalled($order);

        }

        return true;

    }





    /**
     * @author chenniang
     * @DataTime: 2021-03-22 15:31
     * @功能说明:团长冻结资金
     */
    public function capFrozenPrice($cap_id,$total=0,$toDay=0){

        $dis[] = ['cap_id','=',$cap_id];

        if($total==0){

            $dis[] = ['have_tx','=',0];
        }

        $dis[] = ['pay_type','>',1];

        if($toDay==1){
            //当日
            $price = $this->where($dis)->whereDay('create_time')->sum('cap_price');

        }else{

            $price = $this->where($dis)->sum('cap_price');

        }

        return round($price,2);

    }

    /**
     * @author chenniang
     * @DataTime: 2021-03-22 15:31
     * @功能说明:团长冻结资金
     */
    public function capFrozenCount($cap_id,$total=0,$toDay=0){

        $dis[] = ['cap_id','=',$cap_id];

        if($total==0){

            $dis[] = ['have_tx','=',0];
        }

        $dis[] = ['pay_type','>',1];

        if($toDay==1){
            //当日
            $price = $this->where($dis)->whereDay('create_time')->count();

        }else{

            $price = $this->where($dis)->count();

        }

        return $price;

    }








    /**
     * @author chenniang
     * @DataTime: 2021-03-26 15:15
     * @功能说明:核销订单
     */
    public function hxOrder($order,$cap_id=0){

        $update = [

            'order_end_time' => time(),

            'pay_type'       => 7,

            'hx_user'        => $cap_id,
            //可申请退款的时间
            'can_tx_date'    => time()+$order['can_tx_time']*60*60

        ];

        $res = $this->dataUpdate(['id'=>$order['id']],$update);
        //解除虚拟电话绑定
        $called = new \app\virtual\model\Config();

        $called->delBindVirtualPhone($order);

        return $res;

    }


    /**
     * @author chenniang
     * @DataTime: 2021-04-01 10:13
     * @功能说明:超时自动退款
     */
    public function autoCancelOrder($uniacid,$user_id=0){

        $dis[] = ['uniacid','=',$uniacid];

        $dis[] = ['pay_type','=',1];

        $dis[] = ['over_time','<',time()];

        if(!empty($user_id)){

            $dis[] = ['user_id','=',$user_id];
        }

        $time_key = 'order_key_massage_time';

        if(!empty(getCache($time_key,$uniacid))){

            return false;
        }

        setCache($time_key,1,10,$uniacid);

        $key = 'order_key_massage';

        incCache($key,1,$uniacid);

        $key_value = getCache($key,$uniacid);

        if($key_value==1){

            $arr = [new Order(),new UpOrderList()];

            foreach ($arr as $k=>$values){

                $order = $values->where($dis)->limit(5)->select()->toArray();

                if(!empty($order)){

                    foreach ($order as $value){

                        $this->cancelOrder($value,$k);

                    }

                }

            }
        }

        decCache($key,1,$uniacid);

        return true;
    }


    /**
     * @author chenniang
     * @DataTime: 2021-04-01 10:13
     * @功能说明:退款
     */
    public function cancelOrder($order,$is_up=0){

        Db::startTrans();

        if($is_up==0){

            $res = $this->where(['id'=>$order['id']])->where('pay_type','<>',-1)->update(['pay_type'=>-1]);

        }else{

            $order_model = new UpOrderList();

            $res = $order_model->where(['id'=>$order['id']])->where('pay_type','<>',-1)->update(['pay_type'=>-1]);
        }

        if($res!=1){

            Db::rollback();

            return ['code'=>500,'msg'=>'取消失败'];
        }

        $goods_model = new Service();
        //退换库存
        foreach ($order['order_goods'] as $v){

            $res = $goods_model->setOrDelStock($v['goods_id'],$v['num'],1);

            if(!empty($res['code'])){

                Db::rollback();

                return $res;

            }

        }

        if($is_up==0&&$order['pay_type']<3){
            //退换优惠券
            $coupon_model = new CouponRecord();

            $coupon_model->couponRefund($order['id']);
        }
        //删除佣金
        $comm_model = new Commission();

        $comm_model->dataUpdate(['order_id' => $order['id']], ['status' => -1]);
        //如果是加钟订单后面的加钟订单时间要往前移(但是目前只能一单一单加，这个接口暂时没用)
        $this->updateAddOrderTime($order,$order['time_long']);

        Db::commit();

        return true;

    }


    /**
     * @param $coach
     * @param $start_time
     * @param $end_time
     * @功能说明:校验技师时间
     * @author chenniang
     * @DataTime: 2023-03-02 14:48
     */
    public function checkCoachTime($coach,$start_time,$end_time){

        $all_day = 1;
        //判断不是全体24小时上班
        if($coach['start_time']!=$coach['end_time']){

            $all_day = 0;

        }
        //全天不判断
        if($all_day==0){
            //教练上班时间
            $coach_start_time = strtotime($coach['start_time'])-strtotime(date('Y-m-d',time()))+strtotime(date('Y-m-d',$start_time));
            //教练下班时间
            $coach_end_time   = strtotime($coach['end_time'])-strtotime(date('Y-m-d',time()))+strtotime(date('Y-m-d',$start_time));

            if($end_time<$coach_start_time){

                $coach_start_time -= 86400;

                $coach_end_time   -= 86400;
            }

            $coach_end_time = $coach_end_time>$coach_start_time?$coach_end_time:$coach_end_time+86400;

            // if($start_time<$coach_start_time||$end_time>$coach_end_time){

            //     return ['code'=>500,'msg'=>'不在技师服务时间内,技师服务时间:'.$coach['start_time'].'-'.$coach['end_time']];

            // }

        }

        return true;

    }


    /**
     * @param $order_list
     * @param $config
     * @param $start_time
     * @param $end_time
     * @功能说明:校验订单时间
     * @author chenniang
     * @DataTime: 2023-03-02 14:53
     */
    public function checkOrderTime($order_list,$config,$start_time,$end_time,$coach_id=0){

        $order_model = new Order();

        if(!empty($order_list)){

            foreach ($order_list as $value){

                if(!empty($coach_id)&&$coach_id!=$value['coach_id']){

                    continue ;
                }

                $order_end_time = $order_model->where(['add_pid'=>$value['id']])->where('pay_type','>',-1)->max('end_time');

                $value['end_time'] = !empty($order_end_time)&&$order_end_time>$value['end_time']?$order_end_time:$value['end_time'];

                $time_interval = $config['time_interval']>0?$config['time_interval']*60-1:0;
                //判断两个时间段是否有交集(不允许时间相同)
                $res = is_time_crossV2($start_time,$end_time,$value['start_time']-$time_interval,$value['end_time']+$time_interval);

               // if($res==false){

                 //   return ['code'=>500,'msg'=>'该技师该时间段已经被预约:'.date('Y-m-d H:i',$value['start_time']).'-'.date('Y-m-d H:i',$value['end_time']).'-'.$value['id']];

               // }

            }

        }

        return true;

    }


    /**
     * @param $rest_arr
     * @param $start_time
     * @param $end_time
     * @功能说明:校验技师休息时间
     * @author chenniang
     * @DataTime: 2023-03-02 15:09
     */
    public function checkCoachRestTime($rest_arr,$start_time,$end_time){

        if(!empty($rest_arr)){

            foreach ($rest_arr as $values){

                $res = is_time_cross($start_time,$end_time,$values['time_str'],$values['time_str_end']);

                if($res==false&&$values['is_click']==1){

                    return ['code'=>500,'msg'=>'该技师该时间段正在休息'];

                }

            }

        }

        return true;
    }





    /**
     * @param $order
     * @param $start_time
     * @param int $order_id 加钟订单
     * @param int $p_order_id 升级订单
     * @功能说明:
     * @author chenniang
     * @DataTime: 2023-03-02 11:56
     */
    public function checkTime($order,$start_time,$order_id=0,$p_order_id=0){

        $service_model = new Service();

        $coach_model   = new Coach();

        $order_model   = new Order();

        $total_long = 0;

        $config_model = new Config();

        foreach ($order['order_goods'] as $v){

            $time_long = $service_model->where(['id'=>$v['service_id']])->value('time_long');

            $total_long += $time_long*$v['num'];

        }

        $end_time = $start_time+$total_long*60;

        if(!empty($order['coach_id'])){

            $coach  = $coach_model->dataInfo(['id'=>$order['coach_id']]);

            $config = $config_model->dataInfo(['uniacid' => $coach['uniacid']]);
            //校验技师时间
            $res = $this->checkCoachTime($coach,$start_time,$end_time);

            if(!empty($res['code'])){

                return $res;
            }
            //检查该时间段是否被预约
            $where[] = ['coach_id','=',$order['coach_id']];

            $where[] = ['pay_type','not in',[-1,7]];

            $where[] = ['end_time','>',time()];

            if(!empty($p_order_id)){
                //升级订单的时候
                $where[] = ['id','<>',$p_order_id];

                $where[] = ['add_pid','<>',$p_order_id];

            }
            //加单的时候
            if(!empty($order_id)){

                $where[] = ['add_pid','<>',$order_id];

                $where[] = ['id','<>',$order_id];

            }

            $order_list = $order_model->where($where)->field('id,start_time,end_time,order_end_time,pay_type,coach_id')->select()->toArray();
            //校验技师时间
            $res = $this->checkOrderTime($order_list,$config,$start_time,$end_time);

            if(!empty($res['code'])){

                return $res;
            }
            //校验技师休息时间
            $rest_arr = $coach_model->getCoachRestTime($coach,$start_time,$end_time,$config);

            $res = $this->checkCoachRestTime($rest_arr,$start_time,$end_time);

            if(!empty($res['code'])){

                return $res;
            }

        }

        $arr = [

            'end_time'  => $end_time,

            'time_long' => $total_long,

        ];

        return $arr;

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-11 22:39
     * @功能说明:技师修改订单信息
     */
    public function coachOrdertext($input,$is_admin=0){

        $update['pay_type'] = $input['type'];

        switch ($input['type']){

            case 3:

                $update['receiving_time'] = time();

                break;
            case 4:

                $update['serout_time'] = time();

                $update['serout_lng']    = !empty($input['serout_lng'])?$input['serout_lng']:0;

                $update['serout_lat']    = !empty($input['serout_lat'])?$input['serout_lat']:0;

                $update['serout_address']= !empty($input['serout_address'])?$input['serout_address']:'';

                break;
            case 5:

                $update['arrive_time'] = time();

                $update['arrive_img'] = !empty($input['arrive_img'])?$input['arrive_img']:'';

                $update['arr_lng']    = !empty($input['arr_lng'])?$input['arr_lng']:0;

                $update['arr_lat']    = !empty($input['arr_lat'])?$input['arr_lat']:0;

                $update['arr_address']= !empty($input['arr_address'])?$input['arr_address']:'';

                break;
            case 6:

                $update['start_service_time'] = time();

                break;

            case 7:

                $update['order_end_time'] = time();

                $update['end_lng']    = !empty($input['end_lng'])?$input['end_lng']:0;

                $update['end_lat']    = !empty($input['end_lat'])?$input['end_lat']:0;

                $update['end_address']= !empty($input['end_address'])?$input['end_address']:'';

                $update['end_img']    = !empty($input['end_img'])?$input['end_img']:'';

                break;
            case -1:

                if($is_admin==0){

                    $update['coach_refund_time'] = time();

                    $update['coach_refund_text'] = !empty($input['coach_refund_text'])?$input['coach_refund_text']:'';
                }

                break;

        }

        return $update;

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-11 23:18
     * @功能说明:技师佣金到账
     */
    public function coachBalanceArr($uniacid){

        $dis[] = ['uniacid','=',$uniacid];

        $dis[] = ['pay_type','=',7];

        $dis[] = ['have_tx','=',0];

        $dis[] = ['coach_id','<>',0];

//        $dis[] = ['can_tx_date','<',time()];

        $order = $this->where($dis)->field('admin_id,admin_cash,id,coach_id,service_price,car_price,true_service_price,true_car_price,admin_cash,coach_cash')->select()->toArray();

        if(!empty($order)){

            $refund_model= new RefundOrder();

            $coach_model = new Coach();

            $comm_model  = new Commission();

            foreach ($order as $value){

                $refund_order = $refund_model->dataInfo(['order_id'=>$value['id'],'status'=>1]);

                if(empty($refund_order)){

                    Db::startTrans();
                    //修改订单状态
                    $res = $this->where(['id'=>$value['id'],'have_tx'=>0])->update(['have_tx'=>1]);
                    //增加团长佣金
                    if($res!=0){

                        $cap_cash = $value['coach_cash'];

                        $car_cash = $value['true_car_price'];

                        if($cap_cash>0||$car_cash>0){

                            $res = $coach_model->where(['id'=>$value['coach_id']])->update(['service_price'=>Db::raw("service_price+$cap_cash"),'car_price'=>Db::raw("car_price+$car_cash")]);

                            if($res==0){

                                Db::rollback();

                            }

                        }
                        //用户分销佣金
                        $res = $comm_model->successCash($value['id']);

                        if($res==0){

                            Db::rollback();

                        }
                        //给加盟商加佣金
                        $res = $comm_model->adminSuccessCash($value['id']);

                        if($res==0){

                            Db::rollback();

                        }
                    }else{

                        Db::rollback();
                    }

                    Db::commit();

                }

            }

        }

        return true;
    }


    /**
     * @author chenniang
     * @DataTime: 2022-08-30 14:12
     * @功能说明:获取渠道商订单信息
     */
    public function channelData($channel_id,$input=[]){

        $dis[] = ['a.channel_id','=',$channel_id];

        $dis[] = ['a.pay_type','>',1];

        if(!empty($input['start_time'])&&!empty($input['end_time'])){

            $dis[] = ['a.create_time','between',"{$input['start_time']},{$input['end_time']}"];

        }

        $where = [];

        if(!empty($input['name'])){

            $where[] = ['b.goods_name','like','%'.$input['name'].'%'];

            $where[] = ['a.order_code','like','%'.$input['name'].'%'];

        }

        $id = $this->alias('a')
            ->join('massage_service_order_goods_list b','a.id = b.order_id')
            ->where($dis)
            ->where(function ($query) use ($where){
                $query->whereOr($where);
            })
            ->column('a.id');


        $service_price = $this->where('id','in',$id)->sum('true_service_price');

        $data['order_price'] = round($service_price,2);

        $data['order_count'] = $this->where('id','in',$id)->count();;

        return $data;
    }

    /**
     * 获取订单数量
     * @param $where
     * @return int
     */
    public function getOrderNum($where)
    {
        return $this->where($where)->count();
    }


    /**
     * 车费列表
     * @param $dis
     * @param $page
     * @return \think\Paginator
     * @throws \think\db\exception\DbException
     */
    public function carMoneyList($dis,$page=10)
    {
        $data =  $this->where($dis)
            ->field('id,coach_id,serout_time,arrive_time,car_price,order_code,trip_start_address,trip_end_address')
            ->group('id')
            ->order('id desc')
            ->paginate($page)
            ->each(function($item){
                $item['serout_time'] = date('Y-m-d H:i:s',$item['serout_time']);
                $item['arrive_time'] = date('Y-m-d H:i:s',$item['arrive_time']);
                return $item;
            })
            ->toArray();

        $address_model = new OrderAddress();

        $coach_model = new Coach();

        if(!empty($data['data'])){

            foreach ($data['data'] as &$v){
                //兼容老数据
                if(empty($v['trip_end_address'])){

                    $address = $address_model->dataInfo(['order_id'=>$v['id']]);

                    $v['trip_end_address'] = !empty($address)?$address['address'].' '.$address['address_info']:'';
                }

                if(empty($v['trip_start_address'])){

                    $v['trip_start_address'] = $coach_model->where(['id'=>$v['coach_id']])->value('address');
                }

            }

        }

        return $data;
    }


    /**
     * @author chenniang
     * @DataTime: 2022-10-26 11:16
     * @功能说明:获取加钟的开始时间结束时间
     */
    public function addOrderTime($order_id){
        //查询是否已经有加钟
        $end_time = $this->where(['add_pid'=>$order_id])->where('pay_type','>',0)->field('id,start_time,end_time')->max('end_time');

        if(empty($end_time)){

            $end_time = $this->where(['id'=>$order_id])->value('end_time');

        }

        return $end_time;
    }


    /**
     * @author chenniang
     * @DataTime: 2023-02-17 11:46
     * @功能说明:获取加钟的次数
     */
    public function addOrderTimes($order_id){

        $times = $this->where(['add_pid'=>$order_id])->where('pay_type','>',0)->count();

        return !empty($times)?$times:1;
    }


    /**
     * @author chenniang
     * @DataTime: 2022-10-26 13:40
     * @功能说明:获取订单服务结束时间
     */
    public function getOrderEndTime($order_goods,$start_time){

        $total_long = 0;

        $service_model = new Service();

        foreach ($order_goods as $v){

            $time_long = $service_model->where(['id'=>$v['service_id']])->value('time_long');

            $total_long+=$time_long*$v['num'];

        }

        $end_time = $start_time+$total_long*60;

        return $end_time;

    }


    /**
     * @author chenniang
     * @DataTime: 2022-10-27 10:52
     * @功能说明:订单是否能加钟
     */
    public function orderCanAdd($order){

       // $add_order = $this->where(['add_pid'=>$order['id']])->where('pay_type','>',0)->field('id,start_time,end_time')->find();

        return in_array($order['pay_type'],[6])&&$order['is_add']==0&&!empty($order['address_info']['address_id'])?1:0;
    }




    /**
     * @author chenniang
     * @DataTime: 2023-02-17 14:20
     * @功能说明:如果是加钟订单后面的加钟订单时间要往前移
     */
    public function updateAddOrderTime($pay_order,$time_long){

        if(!empty($pay_order['is_add'])){

            $list = $this->where(['add_pid'=>$pay_order['add_pid']])->where('pay_type','>',0)->where('start_time','>',$pay_order['start_time'])->select()->toArray();

            if(!empty($list)){

                foreach ($list as $value){

                    $this->dataUpdate(['id'=>$value['id']],['start_time'=>$value['start_time']-$time_long,'end_time'=>$value['end_time']-$time_long]);

                }
            }

        }

        return true;

    }



    /**
     * @author chenniang
     * @DataTime: 2023-02-23 16:42
     * @功能说明:
     */
    public function coachCashList($dis,$page=10,$month=''){

        if(!empty($month)){

            $firstday = date('Y-m-01', $month);

            $lastday  = date('Y-m-d H:i:s', strtotime("$firstday +1 month")-1);

            $data = $this->where($dis)->whereTime('create_time','<=',$lastday)->field('id,coach_id,order_code,pay_type,pay_price,start_time,create_time,user_id,end_time,add_pid,is_add,coach_cash,true_car_price')
                ->order('create_time desc,id desc')->paginate($page)->toArray();
        }else{

            $data = $this->where($dis)->order('create_time desc,id desc')->field('id,coach_id,order_code,pay_type,pay_price,start_time,create_time,user_id,end_time,add_pid,is_add,coach_cash,true_car_price')->paginate($page)->toArray();
        }

        return $data;

    }




}