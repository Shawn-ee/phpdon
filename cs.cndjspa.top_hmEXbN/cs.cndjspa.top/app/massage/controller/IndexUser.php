<?php
namespace app\massage\controller;
use app\ApiRest;

use app\card\model\UserPhone;
use app\card\model\UserSk;
use app\dynamic\model\DynamicFollow;
use app\massage\model\ChannelCate;
use app\massage\model\ChannelList;
use app\massage\model\City;
use app\massage\model\Coach;
use app\massage\model\CoachCollect;
use app\massage\model\CoachLevel;
use app\massage\model\CoachTimeList;
use app\massage\model\Commission;
use app\massage\model\Config;
use app\massage\model\ConfigSetting;
use app\massage\model\CouponAtv;
use app\massage\model\CouponAtvRecord;
use app\massage\model\CouponAtvRecordCoupon;
use app\massage\model\CouponAtvRecordList;
use app\massage\model\CouponRecord;
use app\massage\model\Address;

use app\massage\model\DistributionList;
use app\massage\model\Feedback;
use app\massage\model\Order;
use app\massage\model\Service;
use app\massage\model\ShieldList;
use app\massage\model\ShortCodeConfig;
use app\massage\model\User;
use app\massage\model\Wallet;
use think\App;
use think\facade\Db;
use think\Request;


class IndexUser extends ApiRest
{

    protected $model;

    protected $address_model;

    protected $coach_model;

    protected $coupon_record_model;

    protected $follow_model;

    public function __construct(App $app) {

        parent::__construct($app);

        $this->model = new User();

        $this->address_model = new Address();

        $this->coach_model = new Coach();

        $this->coupon_record_model = new CouponRecord();

        $this->follow_model = new DynamicFollow();

    }


    /**
     * @author chenniang
     * @DataTime: 2021-12-08 14:12
     * @功能说明:认证技师
     */
    public function attestationCoach(){

        $data = $this->model->dataInfo(['id'=>$this->getUserId()]);

        $cap_dis[] = ['user_id','=',$this->getUserId()];

        $cap_dis[] = ['status','in',[1,2,3,4]];
        //查看是否是团长
        $cap_info = $this->coach_model->where($cap_dis)->order('status')->find();

        $cap_info = !empty($cap_info)?$cap_info->toArray():[];
        //-1表示未申请团长，1申请中，2已通过，3取消,4拒绝
        $data['coach_status'] = !empty($cap_info)?$cap_info['status']:-1;
        //认证技师
        if($data['coach_status']==-1){

            $this->coach_model->attestationCoach($data);
        }
        //查看是否是团长
        $cap_info = $this->coach_model->where($cap_dis)->order('status')->find();

        $cap_info = !empty($cap_info)?$cap_info->toArray():[];
        //-1表示未申请团长，1申请中，2已通过，3取消,4拒绝
        $data['coach_status'] = !empty($cap_info)?$cap_info['status']:-1;

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-19 15:48
     * @功能说明:个人中心
     */
    public function index(){

        if(empty($this->getUserId())){

            return $this->success([]);

        }

        $data = $this->model->dataInfo(['id'=>$this->getUserId()]);

        $cap_dis[] = ['user_id','=',$this->getUserId()];

        $cap_dis[] = ['status','in',[1,2,3,4]];
        //查看是否是团长
        $cap_info = $this->coach_model->where($cap_dis)->order('status')->find();

        $cap_info = !empty($cap_info)?$cap_info->toArray():[];
        //-1表示未申请团长，1申请中，2已通过，3取消,4拒绝
        $data['coach_status'] = !empty($cap_info)?$cap_info['status']:-1;

        $data['sh_text'] = !empty($cap_info)?$cap_info['sh_text']:'';
        //优惠券数
        $data['coupon_count'] = $this->coupon_record_model->couponCount($this->getUserId());

        $data['balance'] = $this->model->where(['id'=>$this->getUserId()])->sum('balance');

        $data['balance'] = round($data['balance'] ,2);
        //说明是技师
        if(in_array($data['coach_status'],[2,3])){
            //技师等级
            $data['coach_level'] = $this->coach_model->getCoachLevel($cap_info['id'],$this->_uniacid);

            $level_model = new CoachLevel();

            $config_model= new Config();

            $config = $config_model->dataInfo(['uniacid'=>$this->_uniacid]);
            //服务时长
            $data['service_time_long'] = $level_model->getMinTimeLong($cap_info['id'],$config['level_cycle']);

            $data['coach_id'] = $cap_info['id'];

        }

        $admin_where = [

            'user_id' => $this->getUserId(),

            'status'  => 1
        ];

        $admin_model = new \app\massage\model\Admin();

        $admin_user = $admin_model->dataInfo($admin_where);
        //是否是加盟商
        $data['is_admin'] = !empty($admin_user)?1:0;

        $atv_model  = new CouponAtv();

        $atv_record_model = new CouponAtvRecord();

        $dis = [

            'user_id' => $this->getUserId(),

            'status'  => 1
        ];
        //查询有没有进行中的活动
        $atv_ing = $atv_record_model->dataInfo($dis);

        $is_atv  = 0;

        if(!empty($atv_ing)){

            $is_atv = 1;

        }else{

            $atv_config = $atv_model->dataInfo(['uniacid'=>$this->_uniacid]);

            $where[] = ['user_id','=',$this->getUserId()];

            $where[] = ['status','<>',3];

            $count = $atv_record_model->where($where)->count();

            if($atv_config['status']==1&&$atv_config['start_time']<time()&&$atv_config['end_time']>time()&&$count<$atv_config['atv_num']){

                $is_atv = 1;

            }

        }

        $data['is_atv'] = $is_atv;

        $where = [];

        $where[] = ['user_id','=',$this->getUserId()];

        $where[] = ['status','in',[1,2,3,4]];

        $distri_model = new DistributionList();

        $fx = $distri_model->dataInfo($where);

        $data['fx_status'] = !empty($fx)?$fx['status']:-1;

        $data['fx_text']   = !empty($fx)?$fx['sh_text']:'';

        $channel_model = new ChannelList();

        $channel = $channel_model->dataInfo($where);

        $data['channel_status'] = !empty($channel)?$channel['status']:-1;

        $data['channel_text']   = !empty($channel)?$channel['sh_text']:'';
        //是否开启了推荐有礼
        $data['is_atv_status'] = $atv_model->where(['uniacid'=>$this->_uniacid])->value('is_atv_status');

        $data['is_atv_status'] = !empty($data['is_atv_status'])?$data['is_atv_status']:0;
        //技师收藏
        $data['collect_count'] = $this->coach_model->coachCollectCount($this->getUserId(),$this->_uniacid);
        //关注技师数量
        $data['follow_count']  = $this->follow_model->followCoachNum($this->getUserId());

        return $this->success($data);

    }





    /**
     * @author chenniang
     * @DataTime: 2021-03-19 15:54
     * @功能说明:用户地址列表
     */
    public function addressList(){

        $dis[] = ['user_id','=',$this->getUserId()];

        $dis[] = ['status','>',-1];

        $data = $this->address_model->dataList($dis,10);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-19 15:57
     * @功能说明:用户地址详情
     */
    public function addressInfo(){

        $input = $this->_param;

        $dis = [

            'id' => $input['id']
        ];

        $data = $this->address_model->dataInfo($dis);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-19 15:58
     * @功能说明:添加用户地址
     */
    public function addressAdd(){

        $input = $this->_input;

        $input['uniacid'] = $this->_uniacid;

        $input['user_id'] = $this->getUserId();

        $res = $this->address_model->dataAdd($input);

        if($input['status']==1){

            $id = $this->address_model->getLastInsID();

            $this->address_model->updateOne($id);
        }

        return $this->success($res);

    }

    /**
     * @author chenniang
     * @DataTime: 2021-03-19 15:58
     * @功能说明:添加用户地址
     */
    public function addressUpdate(){

        $input = $this->_input;

        $dis = [

            'id' => $input['id']
        ];

        $res = $this->address_model->dataUpdate($dis,$input);

        if(!empty($input['status'])&&$input['status']==1){

            $this->address_model->updateOne($input['id']);

        }

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-11 22:54
     * @功能说明:获取默认地址
     */
    public function getDefultAddress(){

        $address_model = new Address();

        $address = $address_model->dataInfo(['user_id'=>$this->getUserId(),'status'=>1]);

        return $this->success($address);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-19 16:13
     * @功能说明:删除地址
     */
    public function addressDel(){

        $input = $this->_input;

        $dis = [

            'id' => $input['id']
        ];

        $res = $this->address_model->where($dis)->delete();

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-22 13:56
     * @功能说明:修改用户信息 授权微信信息等
     */
    public function userUpdate(){

        $input = $this->_input;

        $dis = [

            'id' => $this->getUserId()
        ];

        if(!empty($input['coupon_atv_id'])&&empty($this->getUserInfo()['nickName'])&&!empty($input['nickName'])){

            $coupon_atv_model = new CouponAtv();

            $coupon_atv_model->invUser($this->getUserId(),$input['coupon_atv_id']);
        }

        $update = [

            'nickName' => $input['nickName'],

            'gender'   => !empty($input['gender'])?$input['gender']:'',

            'language' => !empty($input['language'])?$input['language']:'',

            'city'     => !empty($input['city'])?$input['city']:'',

            'province' => !empty($input['province'])?$input['province']:'',

            'country'  => !empty($input['country'])?$input['country']:'',

            'avatarUrl'=> !empty($input['avatarUrl'])?$input['avatarUrl']:'',

        ];

        $res = $this->model->dataUpdate($dis,$update);

        //
        if(!empty($input['encryptedData'])){

            $encryptedData = $input[ 'encryptedData' ];

            $iv            = $input[ 'iv' ];

            $config    = longbingGetAppConfig($this->_uniacid);

            $appid     = $config[ 'appid' ];

            $session_key = $this->model->where(['id'=>$this->getUserId()])->value('session_key');

            if(empty($session_key)){

                $this->errorMsg('need login',401);
            }
            $datas = null;
            //  解密
            $errCode = decryptDataLongbing( $appid, $session_key, $encryptedData, $iv, $datas );
            //获取unionid
            if ( $errCode == 0 )
            {
                $data = json_decode( $datas, true );

                $unionid = !empty($data['unionid'])?$data['unionid']:'';

                if(!empty($unionid)){

                    $dis = [

                        'unionid' => $unionid,

                        'uniacid' => $this->uniacid

                    ];

                    $find = $this->model->dataInfo($dis);

                    if(!empty($find)){

                        $this->errorMsg('need login',401);

                    }else{

                        $this->model->dataUpdate(['id'=>$this->getUserId()],['unionid'=>$unionid]);

                    }
                }

            }
            else
            {
                return $this->error( $errCode );
            }

        }

        $user_info = $this->model->dataInfo(['id'=>$this->getUserId()]);

        setCache($this->autograph, $user_info, 7200, $this->_uniacid);

        return $this->success($res);

    }



    /**
     * @author chenniang
     * @DataTime: 2021-03-22 14:08
     * @功能说明:用户信息
     */
    public function userInfo(){

        $data = $this->model->dataInfo(['id'=>$this->getUserId()]);

        $cap_dis[] = ['user_id','=',$this->getUserId()];

        $cap_dis[] = ['status','in',[1,2,3,4]];
        //查看是否是团长
        $cap_info = $this->coach_model->where($cap_dis)->order('status')->find();

        $cap_info = !empty($cap_info)?$cap_info->toArray():[];
        //-1表示未申请团长，1申请中，2已通过，3取消,4拒绝
        $data['coach_status'] = !empty($cap_info)?$cap_info['status']:-1;

        $data['coach_position'] = !empty($cap_info['coach_position'])&&$data['coach_status']==2?1:0;

        $distri_model = new DistributionList();

        $fx = $distri_model->dataInfo($cap_dis);

        $data['fx_status'] = !empty($fx)?$fx['status']:-1;

        $data['fx_text']   = !empty($fx)?$fx['sh_text']:'';

        $channel_model = new ChannelList();

        $channel = $channel_model->dataInfo($cap_dis);

        $data['channel_status'] = !empty($channel)?$channel['status']:-1;

        $data['channel_text']   = !empty($channel)?$channel['sh_text']:'';

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-23 09:39
     * @功能说明:团长详情
     */
    public function coachInfo(){

        if(empty($this->getUserId())){

            return $this->success([]);

        }
        $order_model = new Order();

        $order_model->coachBalanceArr($this->_uniacid);

        $cap_dis[] = ['user_id','=',$this->getUserId()];

        $cap_dis[] = ['status','in',[1,2,3,4]];

        $cap_info = $this->coach_model->dataInfo($cap_dis);

        $city_model = new City();

        if(!empty($cap_info)){

            $cap_info['city'] = $city_model->where(['id'=>$cap_info['city_id']])->value('title');
            //技师真正的等级
            $coach_level = $this->coach_model->getCoachLevel($cap_info['id'],$this->_uniacid);
            //技师等级
            $cap_info['coach_level'] = $this->coach_model->coachLevelInfo($coach_level);

            $cap_info['text_type']  = $this->coach_model->getCoachWorkStatus($cap_info['id'],$this->_uniacid);

        }

        return $this->success($cap_info);

    }

    /**
     * @author chenniang
     * @DataTime: 2021-03-22 13:35
     * @功能说明:申请团长
     */
    public function coachApply(){

        $input = $this->_input;

        $cap_dis[] = ['user_id','=',$this->getUserId()];

        $cap_dis[] = ['status','>',-1];

        $cap_info = $this->coach_model->dataInfo($cap_dis);

        if(!empty($cap_info)&&in_array($cap_info['status'],[1,2,3])){

            $this->errorMsg('你已经申请过技师了，');
        }
        if(isset($input['id'])){

            unset($input['id']);
        }

        $input['uniacid'] = $this->_uniacid;

        $input['user_id'] = $this->getUserId();

        $input['status']  = 1;

        $input['id_card'] = !empty($input['id_card'])?implode(',',$input['id_card']):'';

        $input['license'] = !empty($input['license'])?implode(',',$input['license']):'';

        $input['self_img'] = !empty($input['self_img'])?implode(',',$input['self_img']):'';

        if(!empty($cap_info)&&$cap_info['status']==4){

            $res = $this->coach_model->dataUpdate(['id'=>$cap_info['id']],$input);

        }else{

            $res = $this->coach_model->dataAdd($input);

        }

        return $this->success($res);
    }







    /**
     * @author chenniang
     * @DataTime: 2021-07-07 22:41
     * @功能说明:教练收藏列表
     */

    public function coachCollectList(){

        $input = $this->_param;

        $config_model = new ConfigSetting();

        $config = $config_model->dataInfo($this->_uniacid);

        $collect_model = new CoachCollect();

        if($config['coach_format']==1){

            $data = $collect_model->coachCollectListTypeOne($input,$this->_user['id'],$this->_uniacid);

        }else{

            $data = $collect_model->coachCollectListTypeTow($input,$this->_user['id'],$this->_uniacid);
        }

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-07 22:57
     * @功能说明:添加技师收藏
     */
    public function addCollect(){

        $input = $this->_input;

        $insert = [

            'uniacid' => $this->_uniacid,

            'coach_id'=> $input['coach_id'],

            'user_id' => $this->getUserId()
        ];

        $collect_model = new CoachCollect();

        $res = $collect_model->dataAdd($insert);

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-07 22:59
     * @功能说明:取消收藏
     */
    public function delCollect(){

        $input = $this->_input;

        $dis = [

            'uniacid' => $this->_uniacid,

            'coach_id'=> $input['coach_id'],

            'user_id' => $this->getUserId()
        ];

        $collect_model = new CoachCollect();

        $res = $collect_model->where($dis)->delete();

        return $this->success($res);
    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-08 11:51
     * @功能说明:用户优惠券列表
     */
    public function userCouponList(){

        $input = $this->_param;

        $this->coupon_record_model->initCoupon($this->_uniacid);

        $dis = [

            'user_id' => $this->getUserId(),

            'status'  => $input['status'],

            'is_show' => 1
        ];

        $data = $this->coupon_record_model->dataList($dis);

        if(!empty($data['data'])){

            foreach ($data['data'] as &$v){

                $v['start_time'] = date('Y.m.d H:i',$v['start_time']).' - '.date('Y.m.d H:i',$v['end_time']);

            }
        }

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-16 22:09
     * @功能说明:删除优惠券
     */
    public function couponDel(){

        $input = $this->_input;

        $coupon = $this->coupon_record_model->dataInfo(['id'=>$input['coupon_id']]);

        if($coupon['status']==1){

            $this->errorMsg('待使用待卡券不能删除');
        }

        $res = $this->coupon_record_model->dataUpdate(['id'=>$input['coupon_id']],['is_show'=>0]);

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-13 19:45
     * @功能说明:优惠券活动详情
     */
    public function couponAtvInfo(){

        $input = $this->_input;

        $atv_record_model = new CouponAtvRecord();

        $atv_record_list_model = new CouponAtvRecordList();

        $atv_model = new CouponAtv();

        if(empty($input['id'])){

            $dis_where[] = ['status','=',1];

            $dis_where[] = ['end_time','<',time()];
            //修改过期状态
            $atv_record_model->dataUpdate($dis_where,['status'=>3]);

            $dis = [

                'user_id' => $this->getUserId(),

                'status'  => 1
            ];
            //查询有没有进行中的活动
            $atv_ing = $atv_record_model->dataInfo($dis);

            if(empty($atv_ing)){

                $atv_ing = $this->couponAtvAdd();
            }
            //
            if(empty($atv_ing)){

                $atv_ing = $atv_record_model->where(['user_id'=>$this->getUserId()])->order('id desc')->find();

                $atv_ing = !empty($atv_ing)?$atv_ing->toArray():[];
            }

            if(empty($atv_ing)){

                $this->errorMsg('你没有可以进行的活动');
            }

        }else{

            $dis = [

                'id'  => $input['id']
            ];
            //查询有没有进行中的活动
            $atv_ing = $atv_record_model->dataInfo($dis);
        }

        $atv = $atv_model->dataInfo(['uniacid'=>$this->_uniacid]);

        $atv_ing['atv_num']   = $atv['atv_num'];

        $atv_ing['end_time'] -= time();

        $atv_ing['end_time']  = $atv_ing['end_time']>0?$atv_ing['end_time']:0;

        $data['atv_info']    = $atv_ing;
        //邀请记录
        $data['record_list'] = $atv_record_list_model->dataList(['a.record_id'=>$atv_ing['id']],50);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-12 16:29
     * @功能说明:发起优惠券活动
     */
    public function couponAtvAdd(){

        $atv_model  = new CouponAtv();

        $atv_record_model = new CouponAtvRecord();

        $atv_record_coupon_model = new CouponAtvRecordCoupon();

        $atv_config = $atv_model->dataInfo(['uniacid'=>$this->_uniacid]);


        if($atv_config['status']==0){

            return [];
        }

        if($atv_config['start_time']>time()||$atv_config['end_time']<time()){

            return [];

        }

        if(empty($atv_config['coupon'])){

            return [];

        }

        $where[] = ['user_id','=',$this->getUserId()];

        $where[] = ['status','<>',3];

        $count = $atv_record_model->where($where)->count();

        if($count>=$atv_config['atv_num']){

            return [];

        }

        $insert = [

            'uniacid' => $this->_uniacid,

            'user_id' => $this->getUserId(),

            'atv_id'  => $atv_config['id'],

            'atv_start_time' => $atv_config['start_time'],

            'atv_end_time'   => $atv_config['end_time'],

            'inv_user_num'   => $atv_config['inv_user_num'],

            'inv_time'     => $atv_config['inv_time'],

            'start_time'   => time(),

            'end_time'     => time()+$atv_config['inv_time']*3600,

            'inv_user'     => $atv_config['inv_user'],

            'to_inv_user'  => $atv_config['to_inv_user'],

            'share_img'    => $atv_config['share_img'],

         ];

        Db::startTrans();

         $res = $atv_record_model->dataAdd($insert);

         if($res==0){

             Db::rollback();

             $this->errorMsg('发起活动失败');
         }

         $record_id = $atv_record_model->getLastInsID();
         //记录该活动需要派发那些券
         foreach ($atv_config['coupon'] as $value){

             $insert = [

                 'uniacid'   => $this->_uniacid,

                 'atv_id'    => $atv_config['id'],

                 'record_id' => $record_id,

                 'coupon_id' => $value['coupon_id'],

                 'num'       => $value['num'],

             ];

             $res = $atv_record_coupon_model->dataAdd($insert);

             if($res==0){

                 Db::rollback();

                 $this->errorMsg('发起活动失败');
             }

         }

        Db::commit();

        $record = $atv_record_model->dataInfo(['id'=>$record_id]);

        return $record;
    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-25 17:40
     * @功能说明：生产二维码
     */

    public function atvQr(){

        $input = $this->_input;

        $key = 'atv_coupon'.$input['coupon_atv_id'];

        $qr  = getCache($key,$this->_uniacid);

        if(empty($qr)){

//            $qr_insert = [
//
//                'coupon_atv_id' => $input['coupon_atv_id']
//            ];
            //获取二维码
            $qr = $this->model->orderQr($input,$this->_uniacid);

            setCache($key,$qr,86400,$this->_uniacid);
        }

        $qr = !empty($qr)?$qr:$this->defaultImage['image'];

        return $this->success($qr);
    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-14 19:22
     * @功能说明:授权手机号
     */
    public function reportPhone ()
    {

        $params = $this->_input;

        $encryptedData = $params[ 'encryptedData' ];

        $iv            = $params[ 'iv' ];

        $config    = longbingGetAppConfig($this->_uniacid);

        $appid     = $config[ 'appid' ];

       // $appsecret = $config[ 'app_secret' ];

        $session_key = $this->model->where(['id'=>$this->getUserId()])->value('session_key');

        if(empty($session_key)){

            $this->errorMsg('need login',401);
        }
        $data = null;
        //  解密
        $errCode = decryptDataLongbing( $appid, $session_key, $encryptedData, $iv, $data );

        if ( $errCode == 0 )
        {
            $data = json_decode( $data, true );

            $phone = $data[ 'purePhoneNumber' ];

        }
        else
        {
            return $this->error( $errCode );
        }

        $res = $this->model->dataUpdate(['id'=>$this->getUserId()],['phone'=>$phone]);

        $user_info = $this->model->dataInfo(['id'=>$this->getUserId()]);

        setCache($this->autograph, $user_info, 7200, $this->_uniacid);

        return $this->success($phone);
    }


    /**
     * @author chenniang
     * @DataTime: 2021-08-28 23:03
     * @功能说明:佣金记录
     */
    public function commList(){

        $input = $this->_param;

        $limit = !empty($input['limit'])?$input['limit']:10;

        $dis[] = ['a.uniacid','=',$this->_uniacid];

        $dis[] = ['a.top_id','=',$this->getUserId()];

        $dis[] = ['a.type','=',1];

        if(!empty($input['status'])){

            $dis[] = ['a.status','=',$input['status']];
        }else{

            $dis[] = ['a.status','>',-1];

        }

        $comm_model = new Commission();

        $order_model = new Order();

        $order_model->coachBalanceArr($this->_uniacid);

        $coach_model = new Coach();

        $data = $comm_model->recordList($dis,$limit);

        $user_model = new User();

        $data['total_cash'] = $comm_model->where(['top_id'=>$this->getUserId(),'type'=>1])->where('status','>',-1)->sum('cash');

        $data['total_cash'] = round($data['total_cash'],2);

        if(!empty($data['data'])){

            foreach ($data['data'] as &$v){

                $coach_id = $order_model->where(['id'=>$v['order_id']])->value('coach_id');

                $v['coach_name'] = $coach_model->where(['id'=>$coach_id])->value('coach_name');

            }
        }

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-03-09 13:43
     * @功能说明:base64转图片
     */
    public function base64ToImg(){

        $input = $this->_input;

        $image = $input['img'];

        $imageName = "25220_".date("His",time())."_".rand(1111,9999).'.png';

        if (strstr($image,",")){
            $image = explode(',',$image);
            $image = $image[1];
        }

        $base_path = '/image/' . $this->uniacid . '/' . date('y') . '/' . date('m');

        $path = FILE_UPLOAD_PATH.$base_path;

        if (!is_dir($path)){ //判断目录是否存在 不存在就创建
            mkdir($path,0777,true);
        }
        $imageSrc=  $path."/". $imageName;  //图片名字

        $r = file_put_contents($imageSrc, base64_decode($image));//返回的是字节数
//        if (!$r) {
//            return json(['data'=>null,"code"=>1,"msg"=>"图片生成失败"]);
//        }else{
//            return json(['data'=>1,"code"=>0,"msg"=>"图片生成成功"]);
//        }

        $img = UPLOAD_PATH.$imageSrc;

        return $this->success($img);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-25 17:40
     * @功能说明：加盟商邀请技师二维码
     */

    public function adminCoachQr(){

        $input = $this->_param;

        $admin_model = new \app\massage\model\Admin();

        $dis = [

            'user_id' => $this->getUserId(),

            'status'  => 1
        ];

        $admin_user = $admin_model->dataInfo($dis);

        if(empty($admin_user)){

            $this->errorMsg('你还不是加盟商');
        }

        $key = 'join_admin'.$admin_user['id'].'-'.$this->is_app;

        $qr  = getCache($key,$this->_uniacid);

        if(empty($qr)){
            //小程序
            if($this->is_app==0){

                $input['page'] = 'technician/pages/apply';

             //   $input['page'] = 'pages/user/home';

                $input['admin_id'] = $admin_user['id'];
                //获取二维码
                $qr = $this->model->orderQr($input,$this->_uniacid);

            }else{

                $page = 'https://'.$_SERVER['HTTP_HOST'].'/h5/#/technician/pages/apply?admin_id='.$admin_user['id'];

                $qr = base64ToPng(getCode($this->_uniacid,$page));

            }

            setCache($key,$qr,86400,$this->_uniacid);
        }

        $qr = !empty($qr)?$qr:'https://'.$_SERVER['HTTP_HOST'].'/favicon.ico';

        return $this->success($qr);
    }


    /**
     * @author chenniang
     * @DataTime: 2022-06-14 18:44
     * @功能说明:用户分销数据
     */
    public function userCashInfo(){

        $user_info = $this->model->dataInfo(['id'=>$this->getUserId()]);

        $data['new_cash'] = $user_info['new_cash'];

        $dis = [

            'top_id' => $this->getUserId(),

            'type'     => 1
        ];

        $comm_model = new Commission();

        $wallet_model = new Wallet();

        $data['total_cash']      = $comm_model->where($dis)->where('status','>',-1)->sum('cash');

        $dis['status'] = 1;
        //未入账金额
        $data['unrecorded_cash'] = $comm_model->where($dis)->sum('cash');

        $data['unrecorded_cash'] = round($data['unrecorded_cash'],2);

        $data['total_cash']      = round($data['total_cash'],2);
        //累计提现
        $data['extract_total_price'] = $wallet_model->userCash($this->getUserId(),2);

        $data['extract_ing_price'] = $wallet_model->userCash($this->getUserId(),1);

        return $this->success($data);

    }



    /**
     * @author chenniang
     * @DataTime: 2021-03-24 13:33
     * @功能说明:用户申请提现
     */
    public function applyWallet(){

        $input = $this->_input;

        $user_info = $this->model->dataInfo(['id'=>$this->getUserId()]);

        $new_cash = $user_info['new_cash'];

        if(empty($input['apply_price'])||$input['apply_price']<0.01){

            $this->errorMsg('提现费最低一分');
        }
        //服务费
        if($input['apply_price']>$new_cash){

            $this->errorMsg('余额不足');
        }

        $balance = 100;

        $key = 'user_wallet'.$this->getUserId();

        $value = getCache($key);

        if(!empty($value)){

            $this->errorMsg('网络错误，请刷新重试');

        }
        //加一个锁防止重复提交
        incCache($key,1,$this->_uniacid);

        Db::startTrans();
        //减佣金
        $res = $this->model->dataUpdate(['id'=>$this->getUserId(),'lock'=>$user_info['lock']],['new_cash'=>$user_info['new_cash']-$input['apply_price'],'lock'=>$user_info['lock']+1]);

        if($res!=1){

            Db::rollback();
            //减掉
            delCache($key,$this->_uniacid);

            $this->errorMsg('申请失败');
        }

        $insert = [

            'uniacid'       => $this->_uniacid,

            'user_id'       => $this->getUserId(),

            'coach_id'      => 0,

            'admin_id'      => 0,

            'total_price'   => $input['apply_price'],

            'balance'       => $balance,

            'apply_price'   => round($input['apply_price']*$balance/100,2),

            'service_price' => 0,

            'code'          => orderCode(),

            'text'          => $input['text'],

            'type'          => 4,

            'apply_transfer' => !empty($input['apply_transfer'])?$input['apply_transfer']:0

        ];

        $wallet_model = new Wallet();
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
     * @DataTime: 2021-03-30 14:39
     * @功能说明:用户分销提现记录
     */
    public function walletList(){

        $wallet_model = new Wallet();

        $input = $this->_param;

        $dis = [

            'user_id' => $this->getUserId()
        ];

        if(!empty($input['status'])){

            $dis['status'] = $input['status'];
        }

        $dis['type'] = 4;
        //提现记录
        $data = $wallet_model->dataList($dis,10);

        if(!empty($data['data'])){

            foreach ($data['data'] as &$v){

                $v['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
            }
        }
        //累计提现
        $data['extract_total_price'] = $wallet_model->userCash($this->getUserId(),2);

        return $this->success($data);
    }


    /**
     * @author chenniang
     * @DataTime: 2022-06-15 14:56
     * @功能说明:我的团队
     */
    public function myTeam(){

        $user_model = new User();

        $dis = [

            'a.pid' => $this->getUserId()
        ];

        $data = $user_model->alias('a')
                ->join('massage_service_order_list b','a.id = b.user_id AND b.pay_type > 1','left')
                ->where($dis)
                ->field('a.id,a.nickName,a.avatarUrl,ifnull(SUM(b.true_service_price),0) as pay_price,ifnull(COUNT(b.id),0) as order_count')
                ->group('a.id')
                ->order('pay_price desc,a.id desc')
                ->paginate(10)
                ->toArray();

        return $this->success($data);

    }



    /**
     * @author chenniang
     * @DataTime: 2021-03-25 17:40
     * @功能说明：加盟商邀请技师二维码
     */

    public function userCommQr(){

        $input = $this->_param;

        $key = 'user_commss'.$this->getUserId().'-'.$this->is_app;

        $qr  = getCache($key,$this->_uniacid);

        if(empty($qr)){
            //小程序
            if($this->is_app==0){

                $input['page'] = 'user/pages';

                $input['pid'] = $this->getUserId();
                //获取二维码
                $qr = $this->model->orderQr($input,$this->_uniacid);

            }else{

                $page = 'https://'.$_SERVER['HTTP_HOST'].'/h5/#/user/pages/gzh?pid='.$this->getUserId();

                $qr = base64ToPng(getCode($this->_uniacid,$page));
            }

            setCache($key,$qr,86400,$this->_uniacid);
        }

        $qr = !empty($qr)?$qr:'https://'.$_SERVER['HTTP_HOST'].'/favicon.ico';

        return $this->success($qr);
    }


    /**
     * @author chenniang
     * @DataTime: 2022-07-21 17:08
     * @功能说明:申请分销商
     */
    public function applyReseller(){

        $input = $this->_input;

        $distribution_model = new DistributionList();

        $dis[] = ['status','>',-1];

        $dis[] = ['user_id','=',$this->getUserId()];

        $find = $distribution_model->dataInfo($dis);

        if(!empty($find)&&in_array($find['status'],[1,2,3])){

            $this->errorMsg('你已经申请');

        }

        $insert = [

            'uniacid'  => $this->_uniacid,

            'user_id'  => $this->getUserId(),

            'user_name'=> $input['user_name'],

            'mobile'   => $input['mobile'],

            'text'     => $input['text'],

            'status'   => 1,

        ];

        if(!empty($find)&&$find['status']==4){

            $res = $distribution_model->dataUpdate(['id'=>$find['id']],$insert);

        }else{

            $res = $distribution_model->dataAdd($insert);
        }

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-23 09:39
     * @功能说明:分销商详情
     */
    public function resellerInfo(){

        $cap_dis[] = ['user_id','=',$this->getUserId()];

        $cap_dis[] = ['status','in',[1,2,3,4]];

        $distribution_model = new DistributionList();

        $cap_info = $distribution_model->dataInfo($cap_dis);

        return $this->success($cap_info);

    }



    /**
     * @author chenniang
     * @DataTime: 2022-07-21 17:08
     * @功能说明:申请渠道商
     */
    public function applyChannel(){

        $input = $this->_input;

        $distribution_model = new ChannelList();

        $dis[] = ['status','>',-1];

        $dis[] = ['user_id','=',$this->getUserId()];

        $find = $distribution_model->dataInfo($dis);

        if(!empty($find)&&in_array($find['status'],[1,2,3])){

            $this->errorMsg('你已经申请');

        }

        $insert = [

            'uniacid'  => $this->_uniacid,

            'user_id'  => $this->getUserId(),

            'user_name'=> $input['user_name'],

            'mobile'   => $input['mobile'],

            'cate_id'  => $input['cate_id'],

            'text'     => !empty($input['text'])?$input['text']:'',

            'status'   => 1,

        ];

        if(!empty($find)&&$find['status']==4){

            $res = $distribution_model->dataUpdate(['id'=>$find['id']],$insert);

        }else{

            $res = $distribution_model->dataAdd($insert);
        }

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-23 09:39
     * @功能说明:渠道商详情
     */
    public function channelInfo(){

        if(empty($this->getUserId())){

            return $this->success([]);

        }

        $cap_dis[] = ['user_id','=',$this->getUserId()];

        $cap_dis[] = ['status','in',[1,2,3,4]];

        $distribution_model = new ChannelList();

        $cap_info = $distribution_model->dataInfo($cap_dis);

        return $this->success($cap_info);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-08-30 14:57
     * @功能说明:渠道商分类下拉框
     */
    public function channelCateSelect(){

        $cate_model = new ChannelCate();

        $dis = [

            'uniacid' => $this->_uniacid,

            'status'  => 1
        ];

        $data = $cate_model->where($dis)->select()->toArray();

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-03-14 11:55
     * @功能说明:发送验证码
     */
    public function sendShortMsg(){

        $input = $this->_input;
        //验证码验证
        $config = new ShortCodeConfig();

        $dis = [

            'uniacid' =>$this->_uniacid,

            'phone'   => $input['phone']
        ];

        $find = $this->model->dataInfo($dis);

        if(!empty($find)){

           // $this->errorMsg('该手机号已经被绑定');
        }

        $res = $config->sendSmsCode($input['phone'],$this->_uniacid);

        if(!empty($res['Message'])&&$res['Message']=='OK'){

            return $this->success(1);

        }else{

            return $this->error($res['Message']);

        }

    }


    /**
     * @author chenniang
     * @DataTime: 2022-08-26 10:29
     * @功能说明:判断用户手机号
     */
    public function bindUserPhone(){

        $input = $this->_input;

        $dis = [

            'uniacid' =>$this->_uniacid,

            'phone'   => $input['phone']
        ];

        $find = $this->model->dataInfo($dis);

//        if(!empty($find)){
//
//           // $this->errorMsg('该手机号已经被绑定');
//        }

        $short_code = getCache($input['phone'],$this->_uniacid);
        //验证码验证手机号
        if($input['short_code']!=$short_code){

            return $this->error('验证码错误');

        }
        if(!empty($find)){
            //解除绑定
             $this->model->dataUpdate($dis,['phone'=>'']);
        }

        $res = $this->model->dataUpdate(['id'=>$this->getUserId()],$dis);

        $user = $this->getUserInfo();

        $user['phone'] = $input['phone'];

        $key = 'longbing_user_autograph_' . $user['id'];

        $key = md5($key);

        setCache($key, $user, 7200);

        return $this->success($res);

    }

    /**
     * 添加反馈
     * @return \think\Response
     */
    public function addFeedback()
    {
        $input = $this->request->only(['type_name', 'order_code', 'content', 'images', 'video_url']);
        $rule = [
            'type_name' => 'require',
            'content' => 'require',
        ];
        $validate = \think\facade\Validate::rule($rule);
        if (!$validate->check($input)) {
            return $this->error($validate->getError());
        }
        $input['coach_id'] = $this->getUserId();
        $input['uniacid'] = $this->_uniacid;
        if (!empty($input['images'])) {
            $input['images'] = json_encode($input['images']);
        }
        $input['create_time'] = time();
        $res = Feedback::insert($input);
        if ($res) {
            return $this->success('');
        }
        return $this->error('提交失败');
    }

    /**
     * 反馈列表
     * @return \think\Response
     */
    public function listFeedback()
    {
        $input = $this->request->param();
        $limit = $this->request->param('limit',10);
        $where = [];
        if (isset($input['status']) && in_array($input['status'], [1, 2])) {
            $where[] = ['a.status', '=', $input['status']];
        }
        $where[] = ['a.coach_id', '=', $this->getUserId()];
        $where[] = ['a.uniacid', '=', $this->_uniacid];
        $data = Feedback::getList($where,$limit);
        $data['wait'] = Feedback::where(['coach_id' => $this->getUserId(), 'uniacid' => $this->_uniacid, 'status' => 1])->count();
        return $this->success($data);
    }

    /**
     * 详情
     * @return \think\Response
     */
    public function feedbackInfo()
    {
        $id = $this->request->param('id');
        if (empty($id)) {
            return $this->error('参数错误');
        }
        $data = Feedback::getInfo(['a.id' => $id]);
        return $this->success($data);
    }


    /**
     * @author chenniang
     * @DataTime: 2022-10-18 15:31
     * @功能说明:
     */
    public function delUserInfo(){

        if(empty($this->getUserId())){

            $this->errorMsg('请先登录');
        }

        $order_model = new Order();

        $order = $order_model->where(['user_id'=>$this->getUserId()])->where('pay_type','not in',[-1,7])->find();

        if(!empty($order)){

            $this->errorMsg('你还有订单未完成');
        }

        $cap_dis[] = ['user_id','=',$this->getUserId()];

        $cap_dis[] = ['status','>',-1];

        $cap_info = $this->coach_model->dataInfo($cap_dis);

        if(!empty($cap_info)){

            $this->errorMsg('技师不能注销');

        }

        $open_id = $this->getUserInfo()['openid'].time();

        $res = $this->model->dataUpdate(['id'=>$this->getUserId()],['status'=>-1,'openid'=>$open_id]);

        setCache($this->autograph,'',0);

        return $this->success(true);

    }




    /**
     * @author chenniang
     * @DataTime: 2023-01-30 16:03
     * @功能说明:屏蔽技师和屏蔽技师动态 type1动态 2技师
     */
    public function shieldCoachAdd(){

        $input = $this->_input;

        $dis = [

            'coach_id' => $input['coach_id'],

            'user_id'  => $this->_user_id,

            'type'     => $input['type'],

            'uniacid'  => $this->_uniacid
        ];

        $shield_model = new ShieldList();
        //没屏蔽过再屏蔽
        $find = $shield_model->dataInfo($dis);

        if(empty($find)){

            $shield_model->dataAdd($dis);

        }

        return $this->success(true);

    }


    /**
     * @author chenniang
     * @DataTime: 2023-01-30 16:03
     * @功能说明:解除技师屏蔽
     */
    public function shieldCoachDel(){

        $input = $this->_input;

        $dis = [

            'id' => $input['id'],
        ];

        $shield_model = new ShieldList();

        $res = $shield_model->where($dis)->delete();

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2023-01-30 16:03
     * @功能说明:解除技师屏蔽
     */
    public function shieldCoachList(){

        $input = $this->_param;

        $dis = [

            'a.user_id' => $this->_user_id,

            'a.type'    => $input['type']
        ];

        $shield_model = new ShieldList();

        $res = $shield_model->dataList($dis);

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2023-02-24 11:31
     * @功能说明:绑定支付宝账号
     */
    public function bindAlipayNumber(){

        $input = $this->_input;

        $dis = [

            'id' => $this->_user_id
        ];

        $res = $this->model->dataUpdate($dis,['alipay_number'=>$input['alipay_number']]);

        return $this->success($res);

    }



    /**
     * @author chenniang
     * @DataTime: 2022-12-09 15:18
     * @功能说明:技师获取客户虚拟电话
     */
    public function getVirtualPhone(){

        $input = $this->_param;

        $order_model = new Order();

        $order = $order_model->dataInfo(['id'=>$input['order_id']]);

        $called = new \app\virtual\model\Config();

        $res = $called->getVirtual($order,2);

        return $this->success($res);

    }







}
