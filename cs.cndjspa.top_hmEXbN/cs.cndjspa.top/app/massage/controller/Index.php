<?php
namespace app\massage\controller;
use app\ApiRest;

use app\massage\model\ArticleList;
use app\massage\model\City;
use app\massage\model\Coach;
use app\massage\model\CoachCollect;
use app\massage\model\CoachTimeList;
use app\massage\model\Comment;
use app\massage\model\ConfigSetting;
use app\massage\model\Coupon;
use app\massage\model\CouponRecord;
use app\massage\model\MassageConfig;
use app\massage\model\Order;
use app\massage\model\PayConfig;
use app\massage\model\Service;
use app\massage\model\ShortCodeConfig;
use app\Rest;


use app\massage\model\Banner;

use app\massage\model\Car;
use app\massage\model\Config;

use app\massage\model\User;
use longbingcore\permissions\AdminMenu;
use think\App;

use think\facade\Db;
use think\Request;



class Index extends ApiRest
{

    protected $model;

    protected $article_model;

    protected $coach_model;

    protected $banner_model;

    protected $car_model;


    public function __construct(App $app) {

        parent::__construct($app);

        $this->model = new Service();

        $this->banner_model = new Banner();

        $this->car_model = new Car();

        $this->coach_model = new Coach();

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-23 09:20
     * @功能说明:首页
     */
   public function index(){

       $input = $this->_param;

       $dis = [

           'uniacid' => $this->_uniacid,

           'status'  => 1
       ];
       $data['banner'] = $this->banner_model->where($dis)->field('id,img,link,type_id,connect_type')->order('top desc,id desc')->select()->toArray();
       //判断插件权限没有返回空
    //   $auth = AdminMenu::getAuthList((int)$this->_uniacid,['recommend']);
        $auth['recommend']=true;

       if(!empty($auth['recommend'])||$auth['recommend']==true){

           $where[] = ['uniacid','=',$this->_uniacid];

           $where[] = ['status','=',2];

           $where[] = ['is_work','=',1];

           $where[] = ['recommend','=',1];

           $where[] = ['user_id','>',0];

           if(!empty($input['city_id'])){

               $where[] = ['city_id','=',$input['city_id']];
           }

           if(!empty($this->getUserId())){

               $shield_coach = $this->coach_model->getShieldCoach($this->getUserId());

               if(!empty($shield_coach)){

                   $where[] = ['id','not in',$shield_coach];
               }
           }

           $lat = !empty($input['lat'])?$input['lat']:0;

           $lng = !empty($input['lng'])?$input['lng']:0;

           $alh = 'ACOS(SIN(('.$lat.' * 3.1415) / 180 ) *SIN((lat * 3.1415) / 180 ) +COS(('.$lat.' * 3.1415) / 180 ) * COS((lat * 3.1415) / 180 ) *COS(('.$lng.' * 3.1415) / 180 - (lng * 3.1415) / 180 ) ) * 6378.137*1000 as distance';

           $list = $this->coach_model->coachRecommendSelect($where,$alh);

           if(!empty($list)){

               $order_model = new Order();
               //最近七天注册
               $seven = $this->model->getSaleTopSeven($this->_uniacid);

               foreach ($list as &$v){
                   //是否是新人
                   $v['is_new'] = in_array($v['id'],$seven)?1:0;
                   //近30天单量
                   $v['order_count'] = $order_model->where(['coach_id' => $v['id'], 'pay_type' => 7])->whereTime('create_time','-30 days')->count();

               }

           }

           $config_model = new ConfigSetting();

           $config = $config_model->dataInfo($this->_uniacid);

           $data['recommend_style'] = $config['recommend_style'];

           $data['recommend_list'] = $list;

       }

       return $this->success($data);

   }


    /**
     * @author chenniang
     * @DataTime: 2021-03-15 14:43
     * @功能说明:服务列表
     */
    public function serviceList(){

        $input = $this->_param;

        $dis[] = ['uniacid','=',$this->_uniacid];

        $dis[] = ['status','=',1];

        $dis[] = ['is_add','=',0];

        if(!empty($input['name'])){

            $dis[] = ['title','like','%'.$input['name'].'%'];

        }

        $input['sort'] = !empty($input['sort'])?$input['sort']:'top desc';

        $data = $this->model->indexDataList($dis,10,$input['sort']);

        return $this->success($data);

    }



    /**
     * @author chenniang
     * @DataTime: 2021-03-15 14:58
     * @功能说明:审核详情
     */
    public function serviceInfo(){

        $input = $this->_param;

        $dis = [

            'id' => $input['id']
        ];

        $data = $this->model->dataInfo($dis);

        return $this->success($data);


    }

    /**
     * @author chenniang
     * @DataTime: 2021-03-23 14:16
     * @功能说明:获取配置信息
     */
   public function configInfo(){

       $dis = [

           'uniacid' => $this->_uniacid
       ];

       $config_model = new Config();

       $config_model->dataInfo($dis);

       $arr = 'uniacid,appsecret,app_app_secret,appid,app_app_id,web_app_id,web_app_secret,gzh_appid,order_tmp_id,cancel_tmp_id,max_day,time_unit,service_cover_time,can_tx_time,company_pay,short_id,short_secret';

       $config = $config_model->where($dis)->withoutField($arr)->find()->toArray();

       $pay_config_model = new PayConfig();

       $pay_config = $pay_config_model->dataInfo($dis);

       $config['alipay_status'] = $pay_config['alipay_status'];

       $short_config_model = new ShortCodeConfig();

       $short_config = $short_config_model->dataInfo($dis);

       $config['short_code_status'] = $short_config['short_code_status'];
       //代理商文章标题
       if(!empty($config['agent_article_id'])){

           $article_model = new ArticleList();

           $config['agent_article_title'] = $article_model->where(['id'=>$config['agent_article_id']])->value('title');
       }

       $config_model = new ConfigSetting();

       $data = $config_model->dataInfo($this->_uniacid);

       $config = array_merge($config,$data);

       return $this->success($config);

   }


    /**
     * @author chenniang
     * @DataTime: 2021-07-11 17:12
     * @功能说明:技师的服务列表
     */

   public function coachServiceList(){

       $input = $this->_param;

       $dis[] = ['a.uniacid','=',$this->_uniacid];

       $dis[] = ['a.status','=',1];

       if(!empty($input['coach_id'])){

           $dis[] = ['b.coach_id','=',$input['coach_id']];
       }

       $is_add = !empty($input['is_add'])?$input['is_add']:0;

       $dis[] = ['a.is_add','=',$is_add];

       $data['data'] = $this->model->serviceCoachList($dis);

       if(!empty($data['data'])){

           $car_model = new Car();

           foreach ($data['data'] as &$v){

               $dis = [

                   'service_id' => $v['id'],

                   'coach_id'   => $input['coach_id']
               ];

               $v['car_num'] = $car_model->where($dis)->sum('num');

           }
       }

       return $this->success($data);

   }

    /**
     * @author chenniang
     * @DataTime: 2021-07-07 10:21
     * @功能说明:服务技师列表
     */
   public function serviceCoachList(){

       $input = $this->_param;

       $dis[] = ['a.uniacid','=',$this->_uniacid];

       $dis[] = ['a.status','=',2];

       $dis[] = ['a.is_work','=',1];

       $dis[] = ['a.user_id','>',0];

       if(!empty($input['ser_id'])){

           $dis[] = ['b.ser_id','=',$input['ser_id']];
       }

       if(!empty($input['coach_name'])){

           $dis[] = ['a.coach_name','like','%'.$input['coach_name'].'%'];
       }

       if(!empty($input['city_id'])){

           $dis[] = ['a.city_id','=',$input['city_id']];
       }
       //服务中
       $working_coach = $this->coach_model->getWorkingCoach($this->_uniacid);
       //当前时间不可预约
       $cannot = CoachTimeList::getCannotCoach($this->_uniacid);

       $working_coach = array_diff($working_coach,$cannot);
       //如果登录不返回被屏蔽的技师
       if(!empty($this->getUserId())){

           $shield_coach = $this->coach_model->getShieldCoach($this->getUserId());

           if(!empty($shield_coach)){

               $dis[] = ['a.id','not in',$shield_coach];
           }

       }
       //可服务不可服务
       if(!empty($input['type'])){
           //可服务
           if($input['type']==1){

               $array = array_merge($working_coach,$cannot);

               $dis[] = ['a.id','not in',$array];

           }elseif($input['type']==2){//服务中

               $dis[] = ['a.id','in',$working_coach];

           }elseif ($input['type']==3){//不可预约

               $dis[] = ['a.id','in',$cannot];
           }

       }

       $lat = !empty($input['lat'])?$input['lat']:0;

       $lng = !empty($input['lng'])?$input['lng']:0;

       $alh = 'ACOS(SIN(('.$lat.' * 3.1415) / 180 ) *SIN((a.lat * 3.1415) / 180 ) +COS(('.$lat.' * 3.1415) / 180 ) * COS((a.lat * 3.1415) / 180 ) *COS(('.$lng.' * 3.1415) / 180 - (a.lng * 3.1415) / 180 ) ) * 6378.137*1000 as distance';

       $data = $this->coach_model->serviceCoachList($dis,$alh);

       if(!empty($data['data'])){

           $collect_model= new CoachCollect();

           $config_model = new Config();

           $coach_model  = new Coach();

           $config= $config_model->dataInfo(['uniacid'=>$this->_uniacid]);
            //销冠
           $top   = $this->model->getSaleTopOne($this->_uniacid);
            //销售单量前5
           $five  = $this->model->getSaleTopFive($this->_uniacid,$top);
            //最近七天注册
           $seven = $this->model->getSaleTopSeven($this->_uniacid);

           $user_id = !empty($this->getUserId())?$this->getUserId():0;

           $collect = $collect_model->where(['user_id'=>$user_id])->column('coach_id');

           foreach ($data['data'] as &$v){

               $v['is_collect'] = in_array($v['id'],$collect)?1:0;

               $v['near_time']  = $coach_model->getCoachEarliestTime($v['id'],$config);

               if (in_array($v['id'],$working_coach)){

                   $text_type = 2;

               }elseif (!in_array($v['id'],$cannot)){

                   $text_type = 1;

               }else{

                   $text_type = 3;
               }

               $v['text_type']  = $text_type;

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

       return $this->success($data);

   }


    /**
     * @author chenniang
     * @DataTime: 2023-02-21 17:03
     * @功能说明:第二中板式第技师列表
     */
   public function typeServiceCoachList(){

       $input = $this->_param;

       $dis[] = ['a.uniacid','=',$this->_uniacid];

       $dis[] = ['a.status','=',2];

       $dis[] = ['a.user_id','>',0];

       if(!empty($input['ser_id'])){

           $dis[] = ['b.ser_id','=',$input['ser_id']];
       }

       if(!empty($input['coach_name'])){

           $dis[] = ['a.coach_name','like','%'.$input['coach_name'].'%'];
       }

       if(!empty($input['city_id'])){

           $dis[] = ['a.city_id','=',$input['city_id']];
       }
       $this->coach_model->setIndexTopCoach($this->_uniacid);
       //如果登录不返回被屏蔽的技师
       if(!empty($this->getUserId())){

           $shield_coach = $this->coach_model->getShieldCoach($this->getUserId());

           if(!empty($shield_coach)){

               $dis[] = ['a.id','not in',$shield_coach];
           }

       }

       $lat = !empty($input['lat'])?$input['lat']:0;

       $lng = !empty($input['lng'])?$input['lng']:0;

       $alh = 'ACOS(SIN(('.$lat.' * 3.1415) / 180 ) *SIN((a.lat * 3.1415) / 180 ) +COS(('.$lat.' * 3.1415) / 180 ) * COS((a.lat * 3.1415) / 180 ) *COS(('.$lng.' * 3.1415) / 180 - (a.lng * 3.1415) / 180 ) ) * 6378.137*1000 as distance';

       $data = $this->coach_model->typeServiceCoachList($dis,$alh);

       if(!empty($data['data'])){

           $collect_model= new CoachCollect();

           $config_model = new Config();

           $coach_model  = new Coach();

           $config= $config_model->dataInfo(['uniacid'=>$this->_uniacid]);
           //销冠
           $top   = $this->model->getSaleTopOne($this->_uniacid);
           //销售单量前5
           $five  = $this->model->getSaleTopFive($this->_uniacid,$top);
           //最近七天注册
           $seven = $this->model->getSaleTopSeven($this->_uniacid);

           $user_id = !empty($this->getUserId())?$this->getUserId():0;

           $collect = $collect_model->where(['user_id'=>$user_id])->column('coach_id');

           foreach ($data['data'] as &$v){

               $v['is_collect'] = in_array($v['id'],$collect)?1:0;

               $v['near_time']  = $coach_model->getCoachEarliestTime($v['id'],$config);

               if ($v['is_work']==0){

                   $text_type = 4;

               }elseif ($v['index_top']==1){

                   $text_type = 1;

               }else{

                   $text_type = 3;
               }

               $v['text_type']  = $text_type;

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

       return $this->success($data);
   }


    /**
     * @author chenniang
     * @DataTime: 2021-03-24 14:07
     * @功能说明:购物车信息
     */
    public function carInfo(){

        $input = $this->_param;

        $order_id = !empty($input['order_id'])?$input['order_id']:0;
        //购物车信息
        $car_info = $this->car_model->carPriceAndCount($this->getUserId(),$input['coach_id'],1,$order_id);

        return $this->success($car_info);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-23 09:48
     * @功能说明:再来一单
     */
    public function onceMoreOrder(){

        $input = $this->_input;

        $order_model = new Order();

        $order = $order_model->dataInfo(['id'=>$input['order_id']]);

        $coach = $this->coach_model->dataInfo(['id'=>$order['coach_id']]);

        if($coach['status']!=2||$coach['is_work']==0){

            $this->errorMsg('技师未上班');
        }
        //清空购物车
        $this->car_model->where(['user_id'=>$this->getUserId(),'coach_id'=>$order['coach_id']])->delete();

        Db::startTrans();

        foreach ($order['order_goods'] as $v){

            $ser = $this->model->dataInfo(['id'=>$v['goods_id']]);

            if(empty($ser)||$ser['status']!=1){

                Db::rollback();

                $this->errorMsg('服务已经下架');
            }

            $dis = [

                'user_id'   => $this->getUserId(),

                'uniacid'   => $this->_uniacid,

                'coach_id'  => $order['coach_id'],

                'service_id'=> $v['goods_id'],

                'num'       => $v['num']
            ];

            $res = $this->car_model->dataAdd($dis);
        }

        Db::commit();

        return $this->success($res);

    }



    /**
     * @author chenniang
     * @DataTime: 2021-03-24 14:46
     * @功能说明:添加到购物车
     */
    public function addCar(){

        $input = $this->_input;

        $order_id = !empty($input['order_id'])?$input['order_id']:0;

        $insert = [

            'uniacid'   => $this->_uniacid,

            'user_id'   => $this->getUserId(),

            'coach_id'  => $input['coach_id'],

            'service_id'=> $input['service_id'],

            'order_id'  => $order_id,

        ];
        //目前只能加钟一个
        if(!empty($order_id)){

            $this->car_model->where(['order_id'=>$order_id])->delete();
        }

        $info = $this->car_model->dataInfo($insert);
        //增加数量
        if(!empty($info)){

            if(!empty($input['is_top'])){

                return $this->success(1);

            }

            $res = $this->car_model->dataUpdate(['id'=>$info['id']],['num'=>$info['num']+$input['num']]);

        }else{
            //添加到购物车
            $insert['num'] = $input['num'];

            $insert['status'] = 1;

            $res = $this->car_model->dataAdd($insert);

            $id  = $this->car_model->getLastInsID();

            return $this->success($id);
        }

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-24 14:54
     * @功能说明:删除购物车
     */
    public function delCar(){

        $input = $this->_input;

        $info = $this->car_model->dataInfo(['id'=>$input['id']]);
        //加少数量
        if($info['num']>$input['num']){

            $res = $this->car_model->dataUpdate(['id'=>$info['id']],['num'=>$info['num']-$input['num']]);

        }else{

            $res = $this->car_model->where(['id'=>$info['id']])->delete();
        }

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-25 10:39
     * @功能说明:
     */
    public function carUpdate(){

        $input = $this->_input;

        $res = $this->car_model->where('id','in',$input['id'])->update(['status'=>$input['status']]);

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-24 14:59
     * @功能说明:批量删除购物车
     */
    public function delSomeCar(){

        $input = $this->_input;

        $dis = [

            'uniacid' => $this->_uniacid,

            'user_id' => $this->getUserId(),

            'coach_id'=> $input['coach_id'],

        ];

        $res = $this->car_model->where($dis)->delete();

        return $this->success($res);

    }



    /**
     * @author chenniang
     * @DataTime: 2021-07-05 23:16
     * @功能说明:评价列表
     */
    public function commentList(){

        $input = $this->_param;

        $dis[] = ['a.uniacid','=',$this->_uniacid];

        $dis[] = ['a.status','=',1];

        if(!empty($input['coach_id'])){

            $dis[] = ['d.id','=',$input['coach_id']];
        }

        if(!empty($input['coach_name'])){

            $dis[] = ['d.coach_name','like','%'.$input['coach_name'].'%'];
        }

        if(!empty($input['goods_name'])){

            $dis[] = ['c.goods_name','like','%'.$input['goods_name'].'%'];

        }

        $comment_model = new Comment();

        $config_model  = new Config();

        $data = $comment_model->dataList($dis);

        $anonymous_evaluate = $config_model->where(['uniacid'=>$this->_uniacid])->value('anonymous_evaluate');

        if(!empty($data['data'])){

            foreach ($data['data'] as &$v){

                $v['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
                //开启匿名评价
                if($anonymous_evaluate==1){

                    $v['nickName'] = '匿名用户';

                    $v['avatarUrl']= 'https://lbqny.migugu.com/admin/farm/default-user.png';
                }

            }
        }

        return $this->success($data);

    }

    /**
     * @author chenniang
     * @DataTime: 2021-03-15 14:58
     * @功能说明:技师详情
     */
    public function coachInfo(){

        $input = $this->_param;

        $dis = [

            'id' => $input['id']
        ];

        $data = $this->coach_model->where($dis)->withoutField('id_card,id_code,mobile,service_price')->find()->toArray();

        $user_model = new User();

        $data['nickName'] = $user_model->where(['id'=>$data['user_id']])->value('nickName');

        $city_model = new City();

        $data['city'] = $city_model->where(['id'=>$data['city_id']])->value('title');
        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-02-28 11:50
     * @功能说明:获取腾讯地图信息
     */
    public function getMapInfo(){

        $input = $this->_param;

        $dis = [

            'uniacid' => $this->_uniacid
        ];

        $config_model = new Config();

        $config = $config_model->dataInfo($dis);

        $key = $input['location'];

        $data = getCache($key,$this->_uniacid);

        if(empty($data)){

            $url  = 'https://apis.map.qq.com/ws/geocoder/v1/?location=';

            $url  = $url.$input['location'].'&key='.$config['map_secret'];

            $data = longbingCurl($url,[]);

            $data_arr = json_decode($data,true);

            if(!empty($data_arr['message'])&&$data_arr['message']=='query ok'){

                setCache($key,$data,300,$this->_uniacid);

            }else{

                $msg = !empty($data_arr['message'])?$data_arr['message']:'定位失败';

                $this->errorMsg($msg);
            }

        }

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-06-15 15:48
     * @功能说明:获取
     */
    public function getCity(){

        $input = $this->_param;

        $city_model = new City();

        $dis[] = ['uniacid','=',$this->_uniacid];

        $dis[] = ['status','=',1];

        $dis[] = ['city_type','=',1];

        $lat = $input['lat'];

        $lng = $input['lng'];

        $alh = 'ACOS(SIN(('.$lat.' * 3.1415) / 180 ) *SIN((lat * 3.1415) / 180 ) +COS(('.$lat.' * 3.1415) / 180 ) * COS((lat * 3.1415) / 180 ) *COS(('.$lng.' * 3.1415) / 180 - (lng * 3.1415) / 180 ) ) * 6378.137*1000 as distance';

        $data = $city_model->where($dis)->field(['*',$alh])->order('distance asc,id desc')->select()->toArray();

        if(!empty($data)){

            $k = isset($key)&&is_numeric($key)?$key:0;

            $data[$k]['is_select'] = 1;
        }

        if(empty($lat)){

            $key = 'articleJsapiTicket-';

            $keys= 'articleToken-';

            setCache($key,'',1,$this->_uniacid);

            setCache($keys,'',1,$this->_uniacid);

        }

        return $this->success($data);
    }

    /**
     * @author chenniang
     * @DataTime: 2022-06-15 16:29
     * @功能说明:优惠券
     */
    public function couponList(){

        if(empty($this->getUserId())){

            return $this->success([]);
        }

        $coupon_record_model = new CouponRecord();

        $user_model = new User();

        $user_info = $user_model->dataInfo(['id'=>$this->getUserId()]);

        $have_get = $coupon_record_model->where(['user_id'=>$this->getUserId()])->column('coupon_id');

        $dis[] = ['uniacid','=',$this->_uniacid];

        $dis[] = ['send_type','=',2];

        $dis[] = ['status','=',1];

        $dis[] = ['stock','>',0];

        $dis[] = ['id','not in',$have_get];

        $data = Db::name('massage_service_coupon')->where($dis)->field('id,title,user_limit,full,discount')->select();

        $list = [];

        $time = strtotime(date('Y-m-d',time()));

        if(!empty($data)){

            foreach ($data as $v){

                if($v['user_limit']==2&&$user_info['create_time']>$time){

                    $list[] = $v;

                }elseif ($v['user_limit']==1){

                    $list[] = $v;

                }

            }
        }

        $list = array_values($list);

        return $this->success($list);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-06-15 22:49
     * @功能说明:用户获取卡券
     */
    public function userGetCoupon(){

        $input = $this->_input;

        $coupon_record_model = new CouponRecord();

        $coupon_model = new Coupon();

        if(!empty($input['coupon_id'])){

            foreach ($input['coupon_id'] as $value){

                $dis = [

                    'coupon_id' => $value,

                    'user_id'   => $this->getUserId()
                ];
                //判断是否领取过
                $find = $coupon_record_model->dataInfo($dis);

                if(!empty($find)){

                    continue;
                }

                $dis = [

                    'status' => 1,

                    'uniacid'=> $this->_uniacid,

                    'send_type' => 2,

                    'id' => $value
                ];
                //检查优惠券
                $coupon = $coupon_model->dataInfo($dis);

                if(!empty($coupon)){

                    $coupon_record_model->recordAdd($value,$this->getUserId());
                }

            }

        }
        return $this->success(true);
    }


    /**
     * @author chenniang
     * @DataTime: 2023-01-30 16:59
     * @功能说明:获取插件的权限
     */
    public function plugAuth(){

        // $data = AdminMenu::getAuthList((int)$this->_uniacid,['dynamic','recommend']);

        $config_model = new MassageConfig();

        $config = $config_model->dataInfo(['uniacid'=>$this->_uniacid]);
        // var_dump($config['dynamic_status']);die;
        $data['dynamic'] = !empty($config['dynamic_status'])?$config['dynamic_status']:0;
        //  $data['dynamic'] = true;
         $data['recommend'] = true;

        return $this->success($data);
    }







}
