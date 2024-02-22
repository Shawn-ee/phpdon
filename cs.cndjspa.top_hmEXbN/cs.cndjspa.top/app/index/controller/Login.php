<?php

namespace app\index\controller;

use app\baidu\model\AdminSetting;

use app\farm\model\User;
use app\massage\model\Config;
use app\massage\model\CouponAtv;
use app\massage\model\DistributionList;
use app\massage\model\MassageConfig;
use app\massage\model\ShortCodeConfig;
use app\redbag\model\Invitation;
use app\restaurant\model\ClassDate;
use Exception;
use longbingcore\tools\LongbingDefault;
use longbingcore\wxcore\WxSetting;
use think\App;
use think\facade\Db;
use think\facade\View;
use think\Response;
use app\baidu\model\AdminActive;

class Login
{
    //  小程序登陆每个用户产生的唯一表示
    protected $code = '';

    protected $uniacid;
    protected $request;
    protected $_param;
    protected $_input;

    function __construct(App $app)
    {
        global $_GPC, $_W;

        $this->request = $app->request;
        //获取param
        $this->_param = $this->request->param();

        $this->_input = json_decode($this->request->getInput(), true);
        //获取uniacid
        if (!isset($this->_param['i']) || !$this->_param['i']) {

            return $this->error('need uniacid',400);
        }

        $this->uniacid = $this->_param['i'];
    }

    /**
     * @author chenniang
     * @DataTime: 2021-03-17 10:06
     * @功能说明:小程序用户登陆接口
     */
    function index()
    {
        $input = $this->_input;

        if (!isset($input['code']) || !$input['code']) {

            return $this->error(['code' => 400, 'error' => 'need code']);

        }

        $cap_id = !empty($input['cap_id'])?$input['cap_id']:0;

        $code    = $input['code'];
        //  是否是微擎
        $config = longbingGetAppConfig($this->uniacid,true);

        $appid  = $config['appid'];

        $appsecret = $config['appsecret'];

//        $encryptedData = isset($this->_param['encryptedData']) ? $this->_param['encryptedData'] : '';
        //  从微信获取openid等
        $url  = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$appsecret}&js_code={$code}&grant_type=authorization_code";

        $arrContextOptions = array(

            "ssl"=>array(

                "verify_peer"     => false,

                "verify_peer_name"=> false,
            ),
        );

        $info = file_get_contents($url ,false, stream_context_create($arrContextOptions));

        $info = @json_decode($info, true);
        //  微信端返回错误
        if (isset($info['errcode'])) {

            return $this->error($info['errcode'] . ', errmsg: ' . $info['errmsg']);

        }
        if (!isset($info['session_key'])) {

            return $this->error('session_key not exists','402');

        }

        if(empty($info['openid'])){

            return $this->error('openid not exists');

        }

        $user_model = new \app\massage\model\User();

        $unionid = !empty($info['unionid'])?$info['unionid']:'';

        if(empty($unionid)){

           // return $this->error('请将小程序绑定到开发平台');

        }

        if(!empty($unionid)){

            $dis = [

                'unionid' => $unionid,

                'uniacid' => $this->uniacid

            ];

        }else{
            //没有移动应用
            $dis = [

                'openid'  => $info['openid'],

                'uniacid' => $this->uniacid

            ];
        }

        $user_info = $user_model->dataInfo($dis);

        if(empty($user_info)){

            $dis = [

                'wechat_openid' => $info['openid']
            ];

            $user_info = $user_model->dataInfo($dis);
        }

        $insert = [

            'uniacid'     => $this->uniacid,

            'openid'      => $info['openid'],

            'wechat_openid'=> $info['openid'],

            'cap_id'      => $cap_id,

            'session_key' => $info['session_key'],

            'unionid'     => $unionid,

            'last_login_type' => 0,

        ];

        if(empty($user_info)){

            if(!empty($input['pid'])){
                //开启了分销审核
                if($config['fx_check']==1){

                    $distribu_model = new DistributionList();

                    $dis = [

                        'user_id' => $input['pid'],

                        'status'  => 2
                    ];

                    $distribu_user = $distribu_model->dataInfo($dis);

                    if(!empty($distribu_user)){

                        $insert['pid'] = $input['pid'];
                    }

                }else{

                    $insert['pid'] = $input['pid'];
                }
            }

            $user_model->dataAdd($insert);

            $user_info = $user_model->dataInfo($insert);

        }else{

            $user_model->dataUpdate(['id'=>$user_info['id']],$insert);
        }

        $key = 'longbing_user_autograph_' . $user_info['id'];

        $key = md5($key);

        setCache($key, $user_info, 86400*3,999999999999);

        $arr = [

            'data'      => $user_info,

            'autograph' => $key
        ];

        return $this->success($arr);

    }

    //返回成功
    public function success($data, $code = 200)
    {
        $result['data'] = $data;
        $result['code'] = $code;
        $result['sign'] = null;

        return $this->response($result, 'json', $code);
    }

    //返回错误数据
    public function error($msg, $code = 400)
    {
        $result['error'] = $msg;
        $result['code'] = $code;
        return $this->response($result, 'json', $code);
    }

    //response
    protected function response($data, $type = 'json', $code = 200)
    {
        return Response::create($data, $type)->code($code);
    }




    /**
     * @author chenniang
     * @DataTime: 2021-03-17 10:06
     * @功能说明:微信登陆
     */
    function appLogin()
    {
        $input = $this->_input;

        $uniacid = $this->uniacid;

        $input = $input['data'];

        $cap_id = !empty($input['cap_id'])?$input['cap_id']:0;

        $user_model = new \app\massage\model\User();

        $dis = [

            'unionid' => $input['unionId'],

            'status'  => 1

        ];

        $user_info = $user_model->dataInfo($dis);

        $insert = [

            'uniacid'  => $uniacid,

            'nickName' => $input['nickName'],

            'avatarUrl'=> $input['avatarUrl'],

            'unionid'  => $input['unionId'],

            'gender'   => $input['gender'],

            'city'     => $input['city'],

            'province' => $input['province'],

            'country'  => $input['country'],

            'openid'   => $input['openId'],

            'app_openid'  => $input['openId'],

            //'create_time' => time(),

            'cap_id'      => $cap_id,

            'last_login_type'  => 1,

        ];

        if(empty($user_info)){

            $config = longbingGetAppConfig($this->uniacid,true);

            if(!empty($input['pid'])){
                //开启了分销审核
                if($config['fx_check']==1){

                    $distribu_model = new DistributionList();

                    $dis = [

                        'user_id' => $input['pid'],

                        'status'  => 2
                    ];

                    $distribu_user = $distribu_model->dataInfo($dis);

                    if(!empty($distribu_user)){

                        $insert['pid'] = $input['pid'];
                    }

                }else{

                    $insert['pid'] = $input['pid'];
                }
            }

            $user_model->dataAdd($insert);

            $user_id  = $user_model->getLastInsID();


        }else{

            $user_id = $user_info['id'];

            $user_model->dataUpdate(['id'=>$user_id],$insert);

        }

        $user_info = $user_model->dataInfo(['id'=>$user_id]);

        $key = 'longbing_user_autograph_' . $user_info['id'];

        $key = md5($key);

        setCache($key, $user_info, 86400*3,999999999999);

        $arr = [

            'data'      => $user_info,

            'autograph' => $key
        ];

        return $this->success($arr);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-10-27 16:32
     * @功能说明:获取code
     */
    public function getCode($appId){

        $url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];

        $url = str_replace('&state=STATE','',$url);

        $url  = str_replace('&from=singlemessage','',$url);

        $url2 = urlencode($url);

      //  $redirectUrl = urlencode('https://massage.cncnconnect.com/index.php?i=666&t=0&v=3.0&from=wxapp&c=entry&a=wxapp&do=api&core=core2&m=longbing_massages_city&s=index/webLogin');

        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appId}&redirect_uri={$url2}&response_type=code&scope=snsapi_userinfo&state=STATE&connect_redirect=1#wechat_redirect";

        header('Location:' . $url);

        exit;

    }



    public function test(){


        dump($_GET);exit;
    }



    /**
     * @author chenniang
     * @DataTime: 2022-02-24 10:28
     * @功能说明:h5公众号登陆
     */
    public function webLogin(){

        $input = $this->_input;

        $config = longbingGetAppConfig($this->uniacid,true);

        $appid  = $config['web_app_id'];

        if (!isset($input['code']) || !$input['code']) {

            return $this->error(['code' => 400, 'error' => 'need code']);

        }

        $uniacid = $this->_param['i'];

        $cap_id = !empty($input['cap_id'])?$input['cap_id']:0;

        $code   = $input['code'];
        //  是否是微擎
        $appsecret = $config['web_app_secret'];

        $url    = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$appsecret}&code={$code}&grant_type=authorization_code";

        $arrContextOptions = array(

            "ssl"=>array(

                "verify_peer"     => false,

                "verify_peer_name"=> false,
            ),
        );

        $info = file_get_contents($url ,false, stream_context_create($arrContextOptions));

        $info = @json_decode($info, true);

        if (isset($info['errcode'])) {

           // $this->getCode($appid,$code);

            return $this->error($info['errcode'] . ', errmsg: ' . $info['errmsg'],40163);

        }

        $token = $info['access_token'];

        $openid = $info['openid'];
        //拿到token后就可以获取用户基本信息了
        $url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$token.'&openid='.$openid;

        $json = file_get_contents($url);//获取微信用户基本信息

        $arr = json_decode($json,true);

        if (isset($arr['errcode'])) {

            return $this->error($arr['errcode'] . ', errmsg: ' . $arr['errmsg'],40163);

        }

        if(empty($info['openid'])){

            return $this->error('openid not exists');

        }

        $user_model = new \app\massage\model\User();

        $unionid = !empty($info['unionid'])?$info['unionid']:'';

        if(empty($unionid)){

           // return $this->error('请将公众号绑定到开发平台');

        }

        if(!empty($unionid)){

            $dis = [

                'unionid' => $unionid,

                'uniacid' => $this->uniacid,

                'status'  => 1

            ];

        }else{
            //没有移动应用
            $dis = [

                'openid'  => $info['openid'],

                'uniacid' => $this->uniacid,

                'status'  => 1

            ];
        }

        $user_info = $user_model->dataInfo($dis);

        if(empty($user_info)){

            $dis = [

                'web_openid' => $info['openid']
            ];

            $user_info = $user_model->dataInfo($dis);
        }

        $insert = [

            'uniacid'  => $uniacid,

            'nickName' => $arr['nickname'],

            'avatarUrl'=> $arr['headimgurl'],

            'unionid'  => $unionid,

            'gender'   => $arr['sex'],

            'city'     => $arr['city'],

            'province' => $arr['province'],

            'country'  => $arr['country'],

            'openid'   => $arr['openid'],

            'web_openid'  => $arr['openid'],

            'cap_id'      => $cap_id,

            'last_login_type' => 2,

        ];

        if(empty($user_info)){

            if(!empty($input['pid'])){
                //开启了分销审核
                if($config['fx_check']==1){

                    $distribu_model = new DistributionList();

                    $dis = [

                        'user_id' => $input['pid'],

                        'status'  => 2
                    ];

                    $distribu_user = $distribu_model->dataInfo($dis);

                    if(!empty($distribu_user)){

                        $insert['pid'] = $input['pid'];
                    }

                }else{

                    $insert['pid'] = $input['pid'];
                }
            }

            $user_model->dataAdd($insert);

            $user_id  = $user_model->getLastInsID();

            if(!empty($input['coupon_atv_id'])){

                $coupon_atv_model = new CouponAtv();

                $coupon_atv_model->invUser($user_id,$input['coupon_atv_id']);
            }

        }else{

            $user_id = $user_info['id'];

            $user_model->dataUpdate(['id'=>$user_id],$insert);

        }

        $user_info = $user_model->dataInfo(['id'=>$user_id]);

        $key = 'longbing_user_autograph_' . $user_info['id'];

        $key = md5($key);

        setCache($key, $user_info, 86400*3,999999999999);

        $arr = [

            'data'      => $user_info,

            'autograph' => $key
        ];

        return $this->success($arr);
    }

    /**
     * @author chenniang
     * @DataTime: 2022-01-09 13:47
     * @功能说明:获取隐私协议
     */
    public function getLoginProtocol(){

        $input     = $this->_param;

        $config    = longbingGetAppConfig($this->uniacid);

        $data = !empty($config['login_protocol'])?$config['login_protocol']:'';

        return $this->success($data);
    }


    /**
     * @author chenniang
     * @DataTime: 2022-08-10 18:30
     * @功能说明:
     */
    public function getConfig(){

        $config = longbingGetAppConfig($this->uniacid);

        $data['login_protocol'] = $config['login_protocol'];

        $data['app_text'] = $config['app_text'];

        $data['primaryColor'] = $config['primaryColor'];

        $data['subColor'] = $config['subColor'];

        $data['app_logo'] = $config['app_logo'];

        $data['web_code_img'] = $config['web_code_img'];

        $data['information_protection'] = $config['information_protection'];

        $setting_model = new MassageConfig();

        $setting = $setting_model->dataInfo(['uniacid'=>$this->uniacid]);

        $data['app_download_img'] = $setting['app_download_img'];

        $data['android_link'] = $setting['android_link'];

        $data['ios_link'] = $setting['ios_link'];

        $short_config_model = new ShortCodeConfig();

        $short_config = $short_config_model->dataInfo(['uniacid'=>$this->uniacid]);

        $data['short_code_status'] = $short_config['short_code_status'];

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-02-26 17:12
     * @功能说明:获取h5配置
     *
     */
    public function getWebConfig(){

        $input= $this->_param;

        $update = !empty($input['update'])?$input['update']:0;

        $config = longbingGetAppConfig($this->uniacid);

        $data['appid'] = $config['web_app_id'];

        $data['timestamp'] = time();

        $data['nonceStr']  = uniqid() . rand(10000, 99999);

        $wx_config = new WxSetting($this->uniacid);

        $jsapi_ticket = $wx_config->getWebTicket();

        $url_now = $input['page'];

        $str = "jsapi_ticket={$jsapi_ticket}&noncestr={$data['nonceStr']}&timestamp={$data['timestamp']}&url={$url_now}";

        $signature = sha1($str);

        $data['signature'] = $signature;

        $data['jsapi_ticket'] = $jsapi_ticket;

        return $this->success($data);

    }




    public function checkToken(){

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = '2232eefrfg'; //对应微信公众平台配置的token
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            echo $_GET['echostr'];
            exit;
        }else{
            return false;
        }
    }


    /**
     * @author chenniang
     * @DataTime: 2022-11-24 18:19
     * @功能说明:
     */
    public function incCoachOrderNum(){

        $time = rand(1,3);

        \think\facade\Db::name('massage_service_coach_list')->where(['uniacid'=>666])->update(['order_num'=>Db::raw("order_num+$time")]);

        $arr = [

            1 => rand(5,10),

            2 => rand(10,20),

            3 => rand(20,30),

            4 => rand(20,30),

            5 => rand(10,20),

            6 => rand(1,5),

            7 => rand(1,3),

            8 => rand(1,3),
        ];

        foreach ($arr as $key=> $value){

            Db::name('massage_service_service_list')->where(['id'=>$key])->update(['sale'=>Db::raw("sale+$value"),'total_sale'=>Db::raw("total_sale+$value")]);

        }

        return $this->success(true);

    }



    /**
     * @author chenniang
     * @DataTime: 2021-03-17 10:06
     * @功能说明:ios登陆
     */
    function iosLogin()
    {
        $input = $this->_input;

        $uniacid = $this->uniacid;

        $input = $input['data'];

        $cap_id = !empty($input['cap_id'])?$input['cap_id']:0;

        $user_model = new \app\massage\model\User();

        $dis = [

            'openid'  => $input['openId'],

            'status'  => 1

        ];

        $user_info = $user_model->dataInfo($dis);

        $familyName = !empty($input['fullName']['familyName'])?$input['fullName']['familyName']:'';

        $giveName   = !empty($input['fullName']['giveName'])?$input['fullName']['giveName']:'';

        $name = !empty($familyName.$giveName)?$familyName.$giveName:'默认用户';

        $insert = [

            'uniacid'  => $uniacid,

            'nickName' => $name,

            'avatarUrl'=> 'https://lbqny.migugu.com/admin/farm/default-user.png',

            'openid'   => $input['openId'],

            'push_id'  => !empty($input['push_id'])?$input['push_id']:'',

            'cap_id'   => $cap_id,

            'last_login_type' => 4,

            'ios_openid' => $input['openId'],

        ];

        $config = longbingGetAppConfig($this->uniacid,true);

        if(empty($user_info)){

            if(!empty($input['pid'])){
                //开启了分销审核
                if($config['fx_check']==1){

                    $distribu_model = new DistributionList();

                    $dis = [

                        'user_id' => $input['pid'],

                        'status'  => 2
                    ];

                    $distribu_user = $distribu_model->dataInfo($dis);

                    if(!empty($distribu_user)){

                        $insert['pid'] = $input['pid'];
                    }

                }else{

                    $insert['pid'] = $input['pid'];
                }
            }

            $user_model->dataAdd($insert);

            $user_id  = $user_model->getLastInsID();

            if(!empty($input['coupon_atv_id'])){

                $coupon_atv_model = new CouponAtv();

                $coupon_atv_model->invUser($user_id,$input['coupon_atv_id']);
            }

        }else{

            $user_id = $user_info['id'];

            $user_model->dataUpdate(['id'=>$user_id],$insert);

        }

        $user_info = $user_model->dataInfo(['id'=>$user_id]);

        $key = 'longbing_user_autograph_' . $user_info['id'];

        $key = md5($key);

        setCache($key, $user_info, 86400*3,999999999999);

        $arr = [

            'data'      => $user_info,

            'autograph' => $key
        ];

        return $this->success($arr);

    }





}
