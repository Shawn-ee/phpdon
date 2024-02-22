<?php
namespace app\massage\controller;
use app\AdminRest;
use app\massage\model\City;
use app\massage\model\Coach;
use app\massage\model\CoachTimeList;
use app\massage\model\Comment;
use app\massage\model\Order;

use app\massage\model\User;
use app\shop\model\OrderGoods;

use app\shop\model\Wallet;
use think\App;
use app\shop\model\Order as Model;
use think\facade\Db;


class AdminIndex extends AdminRest
{


    protected $model;

    protected $order_goods_model;

    protected $refund_order_model;

    protected $comment_model;

    public function __construct(App $app) {

        parent::__construct($app);

        $this->model = new Order();

        $this->refund_order_model = new \app\massage\model\RefundOrder();

        $this->comment_model = new Comment();

    }


    /**
     * @author chenniang
     * @DataTime: 2022-05-25 15:16
     * @功能说明:销售额订单数据
     */
    public function orderData(){

        $input = $this->_param;

        $dis[] = ['uniacid','=',$this->_uniacid];

        $dis[] = ['pay_time','>',0];

        $dis[] = ['coach_refund_time','=',0];
        //全年
        if($input['day']==4){

            $start = strtotime(date('Y-01'));

            $i = 0;

            while ($i<12){

                $arr[$i]['month'] = $i+1;

                $arr[$i]['time'] = $start;

                $time_text = date('Y-m',$start);

                $arr[$i]['time_text'] = $time_text;
                //商城收益
                $shop_price = $this->model->where($dis)->whereMonth('create_time',$time_text)->sum('true_service_price');

              //  $car_price = $this->model->where($dis)->whereMonth('create_time',$time_text)->sum('true_car_price');
                //录入订单
                $arr[$i]['shop_price']  = round($shop_price,2);

                $i++;

                $start = strtotime("$time_text +1 month");
            }

        }else{
            //自定义
            if($input['day']==5) {

                $start = $input['start_time'];

                $end   = $input['end_time'];

            }else{

                if($input['day']==1){

                    $time = 1;

                }elseif ($input['day']==2){

                    $time = 7;

                }else{

                    $time = 30;

                }

                $end   = strtotime(date('Y-m-d',time()));

                $start = $end - ($time-1)*86400;

            }

            $i = 0;

            while ($start<=$end){

                $arr[$i]['time'] = $start;

                $time_text = date('Y-m-d',$start);

                $arr[$i]['time_text'] = $time_text;

                $shop_price = $this->model->where($dis)->whereDay('create_time',$time_text)->sum('true_service_price');

               // $car_price  = $this->model->where($dis)->whereDay('create_time',$time_text)->sum('true_car_price');

                $arr[$i]['shop_price']  = round($shop_price,2);

                $start += 86400;

                $i++;
            }

        }

        return $this->success($arr);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-10-21 13:52
     * @功能说明:代理商订单数据
     */
    public function agentOrderData(){

        $input = $this->_param;

        $admin_model = new \app\massage\model\Admin();

        $dis = [

            'uniacid' => $this->_uniacid,

            'status'  => 1,

            'is_admin'=> 0,

            'city_type' => 1
        ];

        $list = $admin_model->where($dis)->limit(20)->select()->toArray();

        if(!empty($list)){

            foreach ($list as &$value){

                $dis = [];

                $admin_id = $admin_model->getAdminAndSon($value['id']);

                $dis[] = ['admin_id','in',$admin_id];

                $dis[] = ['coach_refund_time','=',0];

                if($input['day']==4){
                    //全年
                    $price = $this->model->where($dis)->where('pay_time','>',0)->whereTime('create_time','year')->sum("true_service_price");

                  //  $car_price = $this->model->where($dis)->where('pay_time','>',0)->whereTime('create_time','year')->sum('true_car_price');

                }else{
                    //自定义时间
                    if($input['day']==5){

                        $start = $input['start_time'];

                        $end   = $input['end_time'];

                        $price = $this->model->where($dis)->where('pay_time','>',0)->where('create_time','between',"$start,$end")->sum('true_service_price');

                      //  $car_price = $this->model->where($dis)->where('pay_time','>',0)->where('create_time','between',"$start,$end")->sum('true_car_price');


                    }else{
                        //今日
                        if($input['day']==1){

                            $price = $this->model->where($dis)->where('pay_time','>',0)->whereTime('create_time','today')->sum('true_service_price');

                          //  $car_price = $this->model->where($dis)->where('pay_time','>',0)->whereTime('create_time','today')->sum('true_car_price');

                        }elseif ($input['day']==2){
                        //近7日
                            $price = $this->model->where($dis)->where('pay_time','>',0)->whereTime('create_time','-7 days')->sum('true_service_price');

                           // $car_price = $this->model->where($dis)->where('pay_time','>',0)->whereTime('create_time','-7 days')->sum('true_car_price');

                        }else{
                        //近30日
                            $price = $this->model->where($dis)->where('pay_time','>',0)->whereTime('create_time','-30 days')->sum('true_service_price');

                          //  $car_price = $this->model->where($dis)->where('pay_time','>',0)->whereTime('create_time','-30 days')->sum('true_car_price');

                        }
                    }

                }

                $value['sale_price'] = round($price,2);

            }

        }

        $list = arraySort($list,'sale_price','desc');

        return $this->success($list);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-10-21 14:20
     * @功能说明:技师用户数据
     */
    public function coachAndUserData(){

        $dis = [

            'uniacid' => $this->_uniacid,

            'status'  => 2
        ];

        $coach_model = new Coach();
        //全部技师
        $data['total_coach'] = $coach_model->where($dis)->count();

        $dis['is_work'] = 1;

        $cannot = CoachTimeList::getCannotCoach($this->_uniacid);

        $working_coach = $coach_model->getWorkingCoach($this->_uniacid);

        $working_coach = array_merge($working_coach,$cannot);
        //休息技师
        $data['rest_coach'] = $coach_model->where($dis)->where('user_id','>',0)->where('id','in',$cannot)->count();
        //可服务
        $data['app_coach']  = $coach_model->where($dis)->where('user_id','>',0)->where('id','not in',$working_coach)->count();
        //在线
        $data['work_coach'] = $coach_model->where($dis)->where('user_id','>',0)->where('id','not in',$cannot)->count();

        $user_model = new User();

        $dis = [

            'uniacid' => $this->_uniacid,

        ];
        //用户数量
        $data['user_count'] = $user_model->where($dis)->where('nickName','<>','')->count();
        //城市
        $dis = [

            'uniacid' => $this->_uniacid,

            'status'  => 1,

            'city_type'=> 1

        ];

        $city_model = new City();

        $data['city_list'] = $city_model->where($dis)->select()->toArray();

        return $this->success($data);
    }


    /**
     * @author chenniang
     * @DataTime: 2022-10-21 14:48
     * @功能说明:技师销售数据
     */
    public function coachSaleData(){

        $input = $this->_param;

        $dis[] = ['a.uniacid','=',$this->_uniacid];

        $dis[] = ['a.status','=',2];

        $dis[] = ['b.coach_refund_time','=',0];

        if(!empty($input['start_time'])){

            $dis[] = ['b.create_time','between',"{$input['start_time']},{$input['end_time']}"];
        }

        $coach_model = new Coach();

        $data = $coach_model->alias('a')
                ->join('massage_service_order_list b','a.id = b.coach_id','left')
                ->where($dis)
                ->where('b.pay_type','>',1)
                ->field('a.coach_name,a.id,SUM(b.coach_cash) as total_coach_cash')
                ->group('a.id')
                ->order('total_coach_cash desc,a.id desc')
                ->paginate($input['limit'])
                ->toArray();

        if(!empty($data['data'])){

            foreach ($data['data'] as &$v){

                $v['coach_level'] = $coach_model->getCoachLevel($v['id'],$this->_uniacid);
            }
        }

        $list['yesterday_count'] = $this->model->where(['uniacid'=>$this->_uniacid,'coach_refund_time'=>0])->where('pay_time','>',0)->whereTime('create_time','yesterday')->count();

        $price = $this->model->where(['uniacid'=>$this->_uniacid,'coach_refund_time'=>0])->where('pay_time','>',0)->whereTime('create_time','yesterday')->sum('true_service_price');

       // $car_price = $this->model->where(['uniacid'=>$this->_uniacid,'coach_refund_time'=>0])->where('pay_time','>',0)->whereTime('create_time','yesterday')->sum('true_car_price');

        $list['yesterday_price'] = round($price,2);

        $list['list'] = $data;

        return $this->success($list);
    }


}
