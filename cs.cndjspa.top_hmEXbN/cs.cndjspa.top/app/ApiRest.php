<?php
declare (strict_types=1);

namespace app;

use app\BaseController;
use app\card\model\User;
use app\card\model\UserPhone;
use app\massage\model\Coach;
use app\massage\model\Config;
use app\massage\model\Order;
use app\massage\model\PayConfig;
use app\restaurant\model\Table;
use app\shop\model\Cap;
use longbingcore\tools\LongbingArr;
use Qiniu\Auth;
use think\App;
use think\exception\HttpResponseException;
use think\exception\ValidateException;
use think\Request;
use think\Validate;
use think\Response;
use think\facade\Db;
use think\facade\Lang;

/**
 * 控制器基础类
 */
abstract class ApiRest extends BaseController
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
    //获取用户id
    public $_user_id = null;
    //唯一app标示
    public $_uniacid = 666;
    //定义检查中间件
     protected $middleware = [ 'app\middleware\AppInit' ];
    //获取配置信息
    protected $_config = [];
    //小程序登陆每个用户产生的唯一表示
    protected $autograph = '';

    protected $uniacid = 0;

    public $is_app = 0;

    protected $defaultImage = array(
        //  默认用户头像
        'avatar' => 'https://lbqnyv2.migugu.com/defaultAvatar.png',
        //  默认内容图片
        'image' => 'https://lbqnyv2.migugu.com/lbCardDefaultImage.png',
    );



    protected $_is_weiqin = false;

    protected $check_url = "";

    /**
     * 无需登录的方法,同时也就不需要鉴权了
     * @var array
     */
    protected $noNeedLogin = [];


    public function __construct(App $app)
    {

        parent::__construct($app);

        if (in_array($this->_method, ['options', 'Options', 'OPTIONS'])) {

            echo true;
            exit;
        }
        //获取param
        $this->_param = $this->request->param();
        //获取body参数
        $this->_input = json_decode($this->request->getInput(), true);
        //获取头部信息
        $this->_header = $this->request->header();

        $this->_action = $this->request->action();

        if (defined('IS_WEIQIN')) {
            global $_GPC, $_W;

            $this->_uniacid = $_W['uniacid'];

        } else {

            $this->_uniacid = !empty($this->_param['i'])?$this->_param['i']:666;
        }

        if (defined('LONGBING_CARD_UNIACID')) {

            define('LONGBING_CARD_UNIACID', $this->_uniacid);
        }

        $this->is_app = !empty($this->_header['isapp']) ? $this->_header['isapp'] : 0;

        $this->shareChangeDatas($this->_param);

        //获取autograph 小程序用户唯一标示
        if ( isset( $this->_header[ 'autograph' ] )){

            $this->autograph = $this->_header['autograph'];
        }
        //获取配置信息
        $this->_config = longbingGetAppConfig($this->_uniacid);
        //语言
        if (isset($this->_header['lang'])) $this->_token = $this->_header['lang'];

        if (isset($this->autograph) && !$this->match($this->noNeedLogin)) {

            $this->_user_id = $this->getUserId();

            $this->_user    = $this->getUserInfo();

            setCache($this->autograph, $this->_user, 86400*3,999999999999);

        }

    }


    /**
     * @author chenniang
     * @DataTime: 2020-08-21 17:43
     * @功能说明:
     */
    public function shareChangeDatas($input){

        if(!empty($input['pid'])|| $this->is_app==0){

            return true;
        }

        $arr = [
            'massage/app/Index/configInfo',
            'shop/app/Index/configInfo',
            'massage/app/Index/index',
            'massage/app/Index/serviceList',
            'massage/app/Index/couponList',
            'massage/app/Index/getMapInfo',
            'massage/app/Index/serviceCoachList',
            'massage/app/Index/typeServiceCoachList',
            'massage/app/Index/getCity',
            'massage/app/Index/coachServiceList',
            'massage/app/IndexUser/index',
            'massage/app/IndexUser/channelCateSelect',
            'massage/app/IndexUser/channelInfo',
            'massage/app/IndexBalance/cardList',
            'massage/app/IndexArticle/articleInfo',
            'massage/app/Index/serviceInfo',
            'massage/app/Index/coachInfo',
            'massage/app/Index/commentList',
            'massage/app/Index/plugAuth',
            'dynamic/app/IndexDynamicList/dynamicList',
            'dynamic/app/IndexDynamicList/getFollowData',
        ];

        if ( !empty($input['urls']) && in_array($input['urls'], $arr)) {

            $input['urls'] = trim(strrchr($input['urls'], '/'), '/');

            $this->noNeedLogin[] = $input['urls'];
        }

        return true;
    }


    /**
     * @author chenniang
     * @DataTime: 2020-07-09 12:00
     * @功能说明:检测方法传递
     */
    public function match($arr)
    {

        $arr = is_array($arr) ? $arr : explode(',', $arr);
        if (!$arr) {
            return FALSE;
        }
        $arr = array_map('strtolower', $arr);

        // 是否存在
        if (in_array(strtolower($this->request->action()), $arr) || in_array('*', $arr)) {
            return TRUE;
        }

        // 没找到匹配
        return FALSE;
    }



    /**
     * REST 调用
     * @access public
     * @param string $method 方法名
     * @return mixed
     * @throws \Exception
     */
    public function _empty($method)
    {
        if (method_exists($this, $method . '_' . $this->method . '_' . $this->type)) {
            // RESTFul方法支持
            $fun = $method . '_' . $this->method . '_' . $this->type;
        } elseif ($this->method == $this->restDefaultMethod && method_exists($this, $method . '_' . $this->type)) {
            $fun = $method . '_' . $this->type;
        } elseif ($this->type == $this->restDefaultType && method_exists($this, $method . '_' . $this->method)) {
            $fun = $method . '_' . $this->method;
        }
        if (isset($fun)) {
            return App::invokeMethod([$this, $fun]
            );
        } else {
            // 抛出异常
            throw new \Exception('error action :' . $method);
        }
    }

    /**
     * @Purpose: 通过小程序端的用户标示获取用户信息
     *
     * @Author: zzf
     *
     * @Return: mixed 查询返回值（结果集对象）
     */
    protected function getUserInfo()
    {
        $value = !empty(getCache($this->autograph,999999999999))?getCache($this->autograph,999999999999):getCache($this->autograph,$this->_uniacid);

        if (empty($value)) {

            $this->errorMsg('need login', 401);
        }

        $user_model = new \app\massage\model\User();

        $value['balance'] = $user_model->where(['id' => $value['id']])->value('balance');

        if ($this->is_app == 1) {

            $value['openid'] = $value['app_openid'];

        } elseif ($this->is_app == 0) {

            $value['openid'] = $value['wechat_openid'];

        } else {

            $value['openid'] = $value['web_openid'];

        }

        return $value;
    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-19 15:22
     * @功能说明:获取当前的团长信息
     */
    public function getCapInfo($err = 1)
    {

        $user_id = $this->getUserId();

        $user_model = new \app\shop\model\User();

        $cap_id = $user_model->where(['id' => $user_id])->value('cap_id');

        $cap_info = [];

        if (!empty($cap_id)) {

            $cap_model = new Cap();

            $cap_info = $cap_model->dataInfo(['id' => $cap_id, 'status' => 2]);
        }

        if (empty($cap_info) && $err == 1) {

            $this->errorMsg('请选择楼长', -407);

        }

        return $cap_info;

    }


    /**
     * @Purpose: 通过小程序端的用户标示获取用户id
     *
     * @Author: zzf
     *
     * @Return: mixed 查询返回值（结果集对象）
     */
    protected function getUserId()
    {
        $value = !empty(getCache($this->autograph,999999999999))?getCache($this->autograph,999999999999):getCache($this->autograph,$this->_uniacid);

        if ($value === false && !$this->match($this->noNeedLogin)) {

            $this->errorMsg('need login', 401);

        }

        return !empty($value[ 'id' ])?$value[ 'id' ]:0;
    }

    /**
     * @param string $uniacid
     * @param int $is_app
     * @功能说明:支付配置
     * @author chenniang
     * @DataTime: 2023-01-19 14:05
     */
    public function payConfig($uniacid = '', $is_app = 7){

        if ($is_app == 7) {

            $is_app = $this->is_app;
        }

        $uniacid_id = !empty($uniacid) ? $uniacid : $this->_uniacid;

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

        if ($is_app == 0) {

            $setting['app_id'] = $config['appid'];

            $setting['secret'] = $config['appsecret'];

        } elseif ($is_app == 1) {

            $setting['app_id'] = $config['app_app_id'];

            $setting['secret'] = $config['app_app_secret'];

        } else {

            $setting['app_id'] = $config['web_app_id'];

            $setting['secret'] = $config['web_app_secret'];

        }

        $setting['is_app'] = $is_app;

        return $setting;
    }







    /**
     * 根据时间获取时间维度
     * @param $start_time
     * @param $end_time
     * @param $coach_id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function getTimeData($start_time, $end_time, $coach_id, $time_,$is_coach=0)
    {
        $time_ = (int)$time_;

        $config_model = new Config();

        $config = $config_model->dataInfo(['uniacid' => $this->_uniacid]);

        $end_time   = strtotime($end_time) - strtotime(date("Y-m-d", time())) + strtotime(date("Y-m-d", $time_));

        $start_time = strtotime($start_time) - strtotime(date("Y-m-d", time())) + strtotime(date("Y-m-d", $time_));

        $coach_model = new Coach();

        $coach = $coach_model->dataInfo(['id'=>$coach_id]);

        $rest_arr = $coach_model->getCoachRestTime($coach,$start_time,$end_time,$config);

        $end_time = $end_time>$start_time?$end_time:$end_time+86400;

        $i = 0;

        $data = [];

        $time = $start_time;

        $time_interval = $is_coach==1?0:$config['time_interval']*60-1;

        $where[] = ['coach_id', '=', $coach_id];

        $where[] = ['end_time', '>=', time()];

        $where[] = ['pay_type', 'not in', [-1,7]];

        $order = Db::name('massage_service_order_list')->where($where)->field('start_time,end_time,order_end_time,pay_type')->select();

        while ($time < $end_time) {

            $time = $start_time + $config['time_unit'] * $i * 60;

            $times = date("Y-m-d", $time) == date("Y-m-d", $time_) ? $time : $time - 86400;

            if ($time >= $end_time) {

                break;
            }

            if (!empty($data[0]) && $times == $data[0]['time_str']) {

                $i++;

                continue;
            }
            //过期时间直接不显示
            if ($times<time()&&$is_coach==0) {

                $i++;

                continue;
            }

            $max_time = $times + $config['time_unit']* 60-1;
            //时间戳
            $data[$i]['time_str']   = $times;

            $data[$i]['time_text']  = date('H:i', $times);

            $data[$i]['time_texts'] = date('Y-m-d', $times);

            $data[$i]['is_click'] = 0;

            $data[$i]['is_order'] = 0;

            $data[$i]['status']   = 1;

            if(!empty($order)){

                foreach ($order as $value){

                    $res = is_time_crossV2($times,$max_time,$value['start_time']-$time_interval,$value['end_time']+$time_interval);

                    if($res==false){

                        $data[$i]['is_order'] = 1;

                        $data[$i]['status'] = 0;

                    }

                }

            }

            if(!empty($rest_arr)&&$data[$i]['status']==1){

                $order_model = new Order();

                $res = $order_model->checkCoachRestTime($rest_arr,$times,$max_time);

                if(!empty($res['code'])){

                    $data[$i]['status'] = 0;

                    $data[$i]['is_click'] = 1;
                }

//                foreach ($rest_arr as $values){
//
//                    if($times==$values['time_str']){
//
//                        $data[$i]['status'] = 0;
//
//                        $data[$i]['is_click'] = 1;
//                    }
//
//                }

            }

            if($times-$time_interval<=time()){

                $data[$i]['status'] = 0;

            }

//            if(empty($is_eve)){
//
//                $data[$i]['status'] = $time == $end_time ? 0 : $data[$i]['status'];
//            }

            $i++;
        }

        $data = !empty($data)?arraySort($data,'time_str'):$data;

        return $data;
    }







    protected function getTimeDataV2($start_time, $end_time, $coach_id, $time_)
    {
        $time_ = (int)$time_;
        $config_model = new Config();
        $config = $config_model->dataInfo(['uniacid' => $this->_uniacid]);
        $where = [
            'start_time' => $start_time,
            'end_time' => $end_time,
            'coach_id' => $coach_id,
            'date' => date('Y-m-d', $time_),
            'max_day' => $config['max_day'],
            'time_unit' => $config['time_unit']
        ];
        $info = Db::name('massage_service_coach_time')->where($where)->find();
        if ($info) {
            $info = json_decode($info['info'], true);
            foreach ($info as &$value) {
                $where = [];
                $where[] = ['coach_id', '=', $coach_id];
                $where[] = ['start_time', '<=', $value['time_str']];
                $where[] = ['end_time', '>=', $value['time_str']];
                $where[] = ['pay_type', 'not in', [-1]];
                $order = Db::name('massage_service_order_list')->where($where)->find();
                if (!empty($order)) {
                    $value['status'] = 0;
                    $value['is_order'] = 1;
                } else {
                    $value['is_order'] = 0;
                }
                $value['status'] = $value['time_str'] < time() ? 0 : $value['status'];
            }
            return $info;
        }

        $end_time = strtotime($end_time) - strtotime(date("Y-m-d", time())) + strtotime(date("Y-m-d", $time_));

        $start_time = strtotime($start_time) - strtotime(date("Y-m-d", time())) + strtotime(date("Y-m-d", $time_));

        $end_time = $end_time > $start_time ? $end_time : $end_time + 86400;

        $i = 0;

        $data = [];

        $time = $start_time;

        while ($time < $end_time) {

            $time = $start_time + $config['time_unit'] * $i * 60;

            $times = date("Y-m-d", $time) == date("Y-m-d", $time_) ? $time : $time - 86400;

            if ($time > $end_time) {

                break;
            }

            if (!empty($data[0]) && $times == $data[0]['time_str']) {

                continue;
            }
            //时间戳
            $data[$i]['time_str'] = $times;

            $data[$i]['time_text'] = date('H:i', $times);

            $data[$i]['time_texts'] = date('Y-m-d', $times);

            $data[$i]['is_click'] = 0;

            $where = [];

            $where[] = ['coach_id', '=', $coach_id];

            $where[] = ['start_time', '<=', $times];

            $where[] = ['end_time', '>=', $times];

            $where[] = ['pay_type', 'not in', [-1]];

            $order = Db::name('massage_service_order_list')->where($where)->find();

            if (!empty($order)) {
                $data[$i]['is_order'] = 1;

                $data[$i]['status'] = 0;

            } else {
                $data[$i]['is_order'] = 0;

                $data[$i]['status'] = 1;

            }

            $t = '1666281540';

            $data[$i]['status'] = $times <$t ? 0 : $data[$i]['status'];

            $i++;
        }

        $data = !empty($data) ? arraySort($data, 'time_str') : $data;

        return $data;
    }
}
