<?php
declare ( strict_types = 1 );

namespace app;

use app\admin\model\Admin;
use app\admin\service\UpdateService;
use app\BaseController;
use app\massage\info\PermissionMassage;
use app\massage\model\Config;
use app\massage\model\PayConfig;
use app\massage\model\ShopCarte;
use LongbingUpgrade;
use think\App;
use think\exception\HttpResponseException;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\Env;
use think\Validate;
use think\Response;
use think\facade\Lang;



/**
 * 控制器基础类
 */
abstract class AdminRest extends BaseController
{
    //app名称
    public $_app = null;
    //控制器名称
    public $_controller = null;
    //执行方法名称
    public $_action = null;
    //method
    public $_method = 'GET';
    //query参数
    public $_param = [];
    //body参数
    public $_input = [];
    //头部
    public $_header = [];
    //头部token
    public $_token = null;
    //获取配置信息
    protected $_config = [];
    //语言信息
    public $_lang = 'zh-cn';
    //角色
    public $_role = 'guest';
    //host信息
    public $_host = null;
    //访问ip信息
    public $_ip = null;
    //用户信息
    public $_user = null;
    //唯一app标示
    public $_uniacid = '2';
    //定义检查中间件
    protected $middleware = ['app\middleware\AppInit'];
    //判断是否是微擎
    public $_is_weiqin = false;
    /**
     * 小程序版本
     * 0 => 无限开版 其他 = 几开版
     * @var array
     */
    protected $card_auth_version = 0;

    protected $admin_arr = [];

    /**
     * 可开通名片数量
     * 0 => 无限开版 其他 = 名片数量
     * @var array
     */
    protected $card_auth_card = 0;

    public function __construct ( App $app )
    {


        parent::__construct( $app);
        //获取method
        $this->_method = $this->request->method( true );

        $this->_is_weiqin = longbingIsWeiqin();
        //获取app名称
        $this->_app = $app->http->getName();
        //获取controller
        $this->_controller = $this->request->controller();
        //获取action名称
        $this->_action = $this->request->action();
        //获取param
        $this->_param = $this->request->param();
        //获取body参数
        $this->_input = json_decode( $this->request->getInput(), true );
        //获取头部信息
        $this->_header = $this->request->header();
        //获取请求host
        $this->_host = $this->_header[ 'host' ];
        //获取访问ip
        $this->_ip = $_SERVER[ 'REMOTE_ADDR' ];


        if ( $this->_is_weiqin ) {

            global $_GPC, $_W;

            $this->_uniacid = $_W[ 'uniacid' ];

            if (empty($_W['user']) || empty($_W[ 'uniacid' ])) {

                echo json_encode(['code' => 401, 'error' => '请登录管理系统!']);
                exit;
            }

        }else{

            //获取token 通过header获取token,如果不存在,则从param中获取。
            if ( !isset( $this->_header[ 'token' ] ) || empty($this->_header[ 'token' ]))
            {
                if(!isset( $this->_param[ 'token' ] ) || empty($this->_param[ 'token' ]))
                {
                    //返回数数据
                    echo json_encode(['code' => 401, 'error' => '请重新登录!']);
                    exit;
                }else{
                    $this->_header[ 'token' ] = $this->_param[ 'token' ];
                }
            }

            //获取token
            $this->_token = $this->_header[ 'token' ] ;
            //语言
            if ( isset( $this->_header[ 'lang' ] ) ) $this->_lang = $this->_header[ 'lang' ];
             //获取用户信息
            $this->_user = getUserForToken( $this->_token );

            if ($this->_user == null) {

                echo json_encode(['code' => 401, 'error' => '请登录系统!']);
                exit;
            }

//            if(empty(getCache(getIP().$this->_user['passwd'],$this->_user['uniacid']))){
//
//                echo json_encode(['code' => 401, 'error' => '请登录系统!']);
//                exit;
//            }

            setUserForToken($this->_token, $this->_user);

            $this->_uniacid =  !empty( $this->_user ) && isset( $this->_user[ 'uniacid' ] )  ? $this->_user[ 'uniacid' ] : 2;

            $this->admin_arr = $this->getAdminId($this->_user);
        }

    }



    //返回请求成功的数据
    public function success ( $data, $code = 200 )
    {

        $result[ 'data' ] = $data;
        $result[ 'code' ] = $code;
        $result[ 'sign' ] = null;
        //复杂的签名
        //        if(isset($this->_user['keys'])){
        //            $result['sign'] = rsa2CreateSign($this->_user['keys'] ,json_encode($data));
        //        }

       // dump($this->_method,$this->request);exit;

       // dump($this->_controller,$this->_action);exit;

//        $id = Db::name('massage_service_shop_carte')->getLastInsID();
//
//        dump($id);exit;
        //简单的签名
        if ( !empty( $this->_token ) ) $result[ 'sign' ] = createSimpleSign( $this->_token, is_string( $data ) ? $data : json_encode( $data ) );
        return $this->response( $result, 'json', $code  );
    }




//    /**
//     * 析构函数 用于添加操作日志
//     */
//    public function __destruct(){
//
//
//       // ob_start(); $a = ob_get_contents(); ob_end_clean();
//
//      //  $a = $GLOBALS['HTTP_RAW_POST_DATA'];
//
//        dump(1);exit;
////dump(2);exit;
//       // dump($res);exit;
////        $dataPath = APP_PATH  . 'massage/info/LogSetting.php' ;
////
////        $data =  include $dataPath ;
////
////        foreach ($data as $k=>$v){
////
////            if($k==$this->_controller){
////
////                foreach ($v as $value){
////
////                    if($value['code_action']==$this->_action){
////
////                        if($value['method']=='post'){
////
////                            $input = $this->_input;
////
////                        }else{
////
////                            $input = $this->_param;
////                        }
////
////                        $boj_id = $input[$value['parameter']];
////
////
////                        $insert = [
////
////                            'uniacid' => $this->_uniacid,
////
////                            'user_id'=> $this->_user['id'],
////
////                            'ip'     => getIP(),
////
////                            'model'  => $k,
////
////                            'action' => $value['code_action']
////                        ];
////
////                        dump($value);exit;
////                    }
////
////                }
////
////            }
////
////
////        }
//
//
//    }



    /**
     * @author chenniang
     * @DataTime: 2022-11-03 13:38
     * @功能说明:获取代理商以及下级id
     */
    public function getAdminId($user){
        //县级代理
        if(isset($user['city_type'])&&$user['city_type']==2){

            return [$user['id']];
        }
        //市级代理
        if(isset($user['city_type'])&&$user['city_type']==1){

            $admin_model = new \app\massage\model\Admin();

            $id = $admin_model->where(['admin_pid'=>$user['id']])->column('id');

            $id[] = $user['id'];

            return $id;
        }
        //省级代理
        if(isset($user['city_type'])&&$user['city_type']==3){

            $admin_model = new \app\massage\model\Admin();

            $id = $admin_model->where(['admin_pid'=>$user['id']])->column('id');

            $son_id = $admin_model->where('admin_pid','in',$id)->column('id');

            $id = array_merge($id,$son_id);

            $id[] = $user['id'];

            return $id;
        }

        return [];
    }
    /**
     * @author chenniang
     * @DataTime: 2020-08-21 17:43
     * @功能说明:
     */
    public function shareChangeData($input){

        $arr = ['/admin/admin/config/clear','/massage/admin/AdminOrder/noLookCount','/massage/admin/AdminSetting/getSaasAuth'];

        if(!empty($input['s'])&&in_array($input['s'],$arr)){

            return false;
        }

        return true;
    }



    /**
     * REST 调用
     * @access public
     * @param string $method 方法名
     * @return mixed
     * @throws \Exception
     */
    public function _empty ( $method )
    {
        if ( method_exists( $this, $method . '_' . $this->method . '_' . $this->type ) ) {
            // RESTFul方法支持
            $fun = $method . '_' . $this->method . '_' . $this->type;
        }
        elseif ( $this->method == $this->restDefaultMethod && method_exists( $this, $method . '_' . $this->type ) ) {
            $fun = $method . '_' . $this->type;
        }
        elseif ( $this->type == $this->restDefaultType && method_exists( $this, $method . '_' . $this->method ) ) {
            $fun = $method . '_' . $this->method;
        }
        if ( isset( $fun ) ) {
            return App::invokeMethod( [
                $this,
                $fun
            ]
            );
        }
        else {
            // 抛出异常
            throw new \Exception( 'error action :' . $method );
        }
    }



    /**
     *
     * 获取支付信息
     */
    public function payConfig ($is_app=0){

        $uniacid_id = !empty($uniacid)?$uniacid:$this->_uniacid;

        $pay_model    = new PayConfig();

        $config_model = new Config();

        $pay    = $pay_model->dataInfo(['uniacid' => $uniacid_id]);

        $config = $config_model->dataInfo(['uniacid' => $uniacid_id]);

        if (empty($pay['mch_id']) || empty($pay['pay_key'])) {

            $this->errorMsg('未配置支付信息'.$uniacid_id);
        }

        $setting['payment'] = [
            'merchant_id'         => $pay['mch_id'],
            'key'                 => $pay['pay_key'],
            'cert_path'           => $pay['cert_path'],
            'key_path'            => $pay['key_path'],
            'ali_appid'           => $pay['ali_appid'],
            'ali_privatekey'      => $pay['ali_privatekey'],
            'ali_publickey'       => $pay['ali_publickey'],
            'appCretPublicKey'    => $pay['appCretPublicKey'],
            'alipayCretPublicKey' => $pay['alipayCretPublicKey'],
            'alipayRootCret'      => $pay['alipayRootCret'],
            'alipay_type'         => $pay['alipay_type'],
        ];

        $setting['company_pay'] = $config['company_pay'];

        if($is_app==0){

            $setting[ 'app_id' ] = $config['appid'];

            $setting[ 'secret' ] = $config['appsecret'];

        }elseif($is_app==1){

            $setting[ 'app_id' ] = $config['app_app_id'];

            $setting[ 'secret' ] = $config['app_app_secret'];

        }else{

            $setting[ 'app_id' ] = $config['web_app_id'];

            $setting[ 'secret' ] = $config['web_app_secret'];

        }

        $setting[ 'is_app' ]= $is_app;

        return $setting;
    }



}
