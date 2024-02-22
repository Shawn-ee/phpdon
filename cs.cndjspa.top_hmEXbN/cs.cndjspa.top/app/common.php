<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
use app\agent\model\Cardauth2ConfigModel;
use app\card\controller\CardCacheKey;
use app\card\model\CardCount;
use app\card\model\CardFormId;
use app\card\model\UserSk;
use app\card\model\Collection;
use app\card\model\UserPhone;
use app\card\model\Company as CompanyModel;
use app\diy\model\DiyModel;
use app\massage\info\PermissionMassage;
use app\massage\model\Config;
use longbingcore\permissions\AdminMenu;
use longbingcore\wxcore\WxSetting;
use think\facade\Cache;
use think\facade\Db;
use think\facade\File;
use think\facade\Request;
use app\Common\JsonSchema;
use app\Common\Rsa2;
use app\Common\Rsa2Sign;
use app\Common\ConsumerApi;
use app\Common\LongbingServiceNotice;
use app\Common\LongbingCurl;
use app\Common\WeChatCode;
use app\Common\model\LongbingCardCount;
use app\Common\model\LongbingUser;
use app\Common\model\LongbingUserInfo;
use app\Common\model\LongbingCardWechatCode;
use app\Common\model\LongbingCardRate;
use app\Common\model\LongbingCardUserMark;
use app\Common\model\LongbingCardCommonModel;
use app\admin\model\AppConfig;
use app\admin\model\AppTabbar;
use app\admin\model\OssConfig;
use app\im\model\ImChat;
use app\im\model\ImMessage;
use app\card\model\Job as CardJob;
use app\card\model\Company as CardCompany;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use think\facade\Log;
use think\facade\Env;


//判断是否是微擎
function longbingIsWeiqin ()
{


    return false;
    $is_wiqing_path = APP_PATH . 'Common/extend/sNSKAvGja2azLtFSadUYWda93UKJE23l.longbing';


    $result = file_exists($is_wiqing_path);

//     dump($result,empty($result));exit;
    return empty($result);
}










/**
 * 判断Schema文件是否存在
 * @param string $schemamethod schemamethod
 * @return boolean
 *
 */
function jsonSchemaExist ( $schemaMethod )
{

    //  var_dump('../schema/' . $schemaMethod . '.json');die;
    return file_exists( APP_PATH . $schemaMethod . '.json' );
}

//根据Rsamy uuid 生成32位uuid
function uuid ()
{
    try
    {
        // Generate a version 1 (time-based) UUID object
        // Generate a version 3 (name-based and hashed with MD5) UUID object
        // Generate a version 4 (random) UUID object
        // Generate a version 5 (name-based and hashed with SHA1) UUID object
        $uuid1 = Uuid::uuid4();
        return str_replace( '-', '', $uuid1->toString() );
        // i.e. e4eaaaf2-d142-11e1-b3e4-080027620cdd
    }
    catch ( UnsatisfiedDependencyException $e )
    {
        // Some dependency was not met. Either the method cannot be called on a
        // 32-bit system, or it can, but it relies on Moontoast\Math to be present.
        error( 'Caught exception: ' . $e->getMessage(), 1100 );
    }
}

/**
 * TODO回调函数
 * @param string $description 未完成需求描述
 * @return
 */
function todo ( $description )
{
    //  $req = think\Request::instance();
    //  trace('[TODO] {' . join('/', [$req->module(), $req->controller(), $req->action()])  . '} ' . $description, 'log');
}

//设置缓存
function setCache ( $key, $value, $expire = 0, $uniacid = '7777' )
{
    $key.=$_SERVER['HTTP_HOST'];

    $tag = 'longbing_card_' . $uniacid;
    //    if(is_array($value)) $value = json_encode($value ,ture);
    $key = $key . '_' . $uniacid;



    return Cache::tag( $tag )
                ->set( $key, $value, $expire );
}

//获取缓存
function getCache ( $key, $uniacid = '7777' )
{

    if ( !hasCache( $key, $uniacid ) ) return false;

    $key.=$_SERVER['HTTP_HOST'];

    $key = $key . '_' . $uniacid;

    return Cache::get( $key );
}

//设置缓存
function setCacheAll ( $key, $value, $expire = 0, $uniacid = '7777' )
{

    $tag = 'longbing_card_' . $uniacid;
    //    if(is_array($value)) $value = json_encode($value ,ture);
    $key = $key . '_' . $uniacid;

    return Cache::tag( $tag )
        ->set( $key, $value, $expire );
}

function getCacheAll ( $key, $uniacid = '7777' )
{

    if ( !hasCacheAll( $key, $uniacid ) ) return false;

    $key = $key . '_' . $uniacid;

    return Cache::get( $key );
}


//追加缓存
function pushCache ( $key, $value, $uniacid = '7777' )
{
    $key.=$_SERVER['HTTP_HOST'];
    $key = $key . '_' . $uniacid;
    return Cache::push( $key, $value );
}

//删除缓存
function delCache ( $key, $uniacid = '7777' )
{
    $key.=$_SERVER['HTTP_HOST'];
    $key = $key . '_' . $uniacid;
    return Cache::delete( $key );
}

//获取并删除缓存
function pullCache ( $key, $uniacid = '7777' )
{
    $key.=$_SERVER['HTTP_HOST'];
    $key = $key . '_' . $uniacid;
    return Cache::pull( $key );
}

//不存在则写入缓存数据后返回
function rememberCache ( $key, $value, $uniacid = '7777' )
{
    $key.=$_SERVER['HTTP_HOST'];
    $key = $key . '_' . $uniacid;
    return Cache::remember( $key, $value );
}

//清空缓存
function clearCache ( $uniacid = '7777' )
{
    $tag = 'longbing_card_' . $uniacid;

    return Cache::tag( $tag )
                ->clear();
}

//缓存自增
function incCache ( $key, $step = 1, $uniacid = '7777',$time=null )
{
    $key.=$_SERVER['HTTP_HOST'];

    $key = $key . '_' . $uniacid;

    $tag = 'longbing_card_' . $uniacid;

    return Cache::tag( $tag )->inc($key, $step,$time );
}

//缓存自减
function decCache ( $key, $step = 1, $uniacid = '7777' )
{
    $key.=$_SERVER['HTTP_HOST'];
    $key = $key . '_' . $uniacid;

    $tag = 'longbing_card_' . $uniacid;

    return Cache::tag( $tag )->dec( $key, $step );

    return Cache::dec( $key, $step );
}

//判断缓存是否存在
function hasCache ( $key, $uniacid = '7777' )
{
    $key.=$_SERVER['HTTP_HOST'];

    $key = $key . '_' . $uniacid;

    return Cache::has( $key );
}


function hasCacheAll ( $key, $uniacid = '7777' )
{
   // $key.=$_SERVER['HTTP_HOST'];

    $key = $key . '_' . $uniacid;

    return Cache::has( $key );
}
//获取controller 和 action
function getRouteMessage ( $route )
{
    $data = explode( "\\", $route );
    $data = explode( "@", $data[ count( $data ) - 1 ] );
    return $data;
}

//通过Token获取用户信息
function getUserForToken ( $token )
{
    return getCache( "Token_" . $token );
}

/**
 * 生成RSA2类获取秘钥
 */
function getRsa2Keys ()
{
    $rsa2 = new Rsa2();
    return $rsa2->getKeys();
}

/**
 * 获取两组交叉keys
 */
function get2keys ()
{
    $key1 = getRsa2Keys();
    $key2 = getRsa2Keys();
    if ( isset( $key1[ 'public_key' ] ) && isset( $key1[ 'private_key' ] ) && isset( $key2[ 'public_key' ] ) && isset( $key2[ 'private_key' ] ) )
    {
        $result[ 'api_key' ]   = [ 'public_key' => $key1[ 'public_key' ], 'private_key' => $key1[ 'private_key' ] ];
        $result[ 'sever_key' ] = [ 'public_key' => $key2[ 'public_key' ], 'private_key' => $key2[ 'private_key' ] ];
        return $result;
    }
    return false;
}

/**
 * 获取RSA2秘钥（测试）
 */
function setRsa2Key ()
{
    $rsa2_key  = getRsa2Keys();
    $rsa2_sign = new Rsa2Sign( $rsa2_key );
    //设置签名
    $sign = $rsa2_sign->createSign( "12333212" );
    //验证签名
    $data = $rsa2_sign->verifySign( "12333212", $sign );
    //生成加密数据
    $jiami = $rsa2_sign->encrypt( json_encode( "123", true ) );
    //数据解密
    $jiemi = $rsa2_sign->decrypt( $jiami );
    return $data;
}

//签名
function rsa2CreateSign ( $keys, $data )
{
    $rsa2_sign = new Rsa2Sign( $keys );
    $sign      = $rsa2_sign->createSign( $data );
    return $sign;
}

//验证签名
function rsa2VerifySign ( $keys, $data, $sign )
{
    $rsa2_sign = new Rsa2Sign( $keys );
    $jiemi     = $rsa2_sign->verifySign( $data, $sign );
    return $jiemi;
}

//加密
function rsa2Encrypt ( $keys, $data )
{
    $rsa2_sign = new Rsa2Sign( $keys );
    $cipher    = $rsa2_sign->encrypt( $data );
    return $cipher;
}

//解密
function rsa2Decrypt ( $keys, $cipher )
{
    $rsa2_sign = new Rsa2Sign( $keys );
    $clear     = $rsa2_sign->decrypt( $cipher );
    return $clear;
}

//批量加密
function rsa2Encrypts ( $keys, $arrs )
{
    //判断需要加密的文件是否为空
    if ( !is_array( $arrs ) ) return false;
    $rsa2_sign = new Rsa2Sign( $keys );
    $result    = [];
    foreach ( $arrs as $arr )
    {
        $result = $rsa2_sign->encrypt( $arr );
    }
    return $result;
}

//批量解密
function rsa2Decrypts ( $keys, $ciphers )
{
    if ( !is_array( $ciphers ) ) return false;
    $rsa2_sign = new Rsa2Sign( $keys );
    $result    = [];
    foreach ( $ciphers as $cipher )
    {
        $result[] = $rsa2_sign->decrypt( $cipher );
    }
    return $result;
}

//创建签名 (一个超级简单的签名)
function createSimpleSign ( $token, $data )
{
    //    $key1 = md5($token);
    //    $key2 = md5($data);
    //    $sign = md5($key1 . $key2 .$token);
    $sign = md5( $token . $data . $token );
    return $sign;
}

//异步消息控制
function messagesProcess ( $msg )
{
    //获取消息内容
    if ( is_object( $msg ) )
    {
        $messages = [ $msg->getBody() ];
        $ack      = true;
    }
    else
    {
        // 兼容以前的消息格式
        $messages = $msg;
        $ack      = false;
    }

    //循环处理消息

    foreach ( $messages as $message )
    {
        //解析json数据
        $data = json_decode( $message, true );
        //处理
//      var_dump($data);
        try{
            switch ( $action = $data[ 'action' ] )
            {
                case 'previewSchedule':
                    $Schedule = new app\preview\Schedule( $data->preview, [ $data->source ] );
                    $Schedule->process();
                    break;
                // 定时任务调度
                case 'SCHEDULER':
                    // 确认消息已经被处理，则返回此信号
                    $msg->delivery_info[ 'channel' ]->basic_ack( $msg->delivery_info[ 'delivery_tag' ] );
                    scheduleProcess( $data );
                    $ack = false;
                    break;
                case 'addMessage':
                    asyncAddMessage( $data[ 'message' ] );
                    break;
                //发送消息服务通知
                case 'sendMessageWxServiceNotice':
                    longbingSendMessageWxServiceNotice($data['message']);
                    break;
                //发送普通服务通知
                case 'SendWxServiceNotice':
                    longbingSendWxServiceNotice($data['count_id']);
                    break;
                case 'longbingSendWxServiceNoticeBase':
                    longbingSendWxServiceNoticeBase($data['data']);
                    break;
                case 'updatecollectionRate':
                    updatecollectionRate($data['client_id']);
                    break;
                case 'updateCustomerRate':
                    updateCustomerRate($data['page'] ,$data['page_count']);
                    break;
                case 'longbingCreateWxCode':
                    longbingCreateWxCode($data['uniacid'] ,$data['data'] ,$data['page'] ,$data['type']);
                    break;
                case 'longbingCreateSharePng':
                    longbingCreateSharePng($data['gData'] ,$data['user_id'] ,$data['uniacid']);
                    break;
                case 'longbingSaveFormId':
                    longbingSaveFormId($data['data']);
                    break;
                case 'test':
                    test( $data[ 'uuid' ], $data[ 'data' ] );
                    break;

            }
        }catch(Exception $e)
        {}
    }
    if ( $ack )
    {
        // 确认消息已经被处理，则返回此信号
        $msg->delivery_info[ 'channel' ]->basic_ack( $msg->delivery_info[ 'delivery_tag' ] );
    }

    // 保存并清空日志，避免导致内存溢出
    //  \think\Log::save();
    //  \think\Log::clear();

}

//计划任务
function scheduleProcess ( $data )
{
    //获取计划任务
    if ( is_object( $data ) ) $data = get_object_vars( $data );

    $taskName         = $data[ 'event' ];
    $lockName         = 'SCHEDULER_RUNNING_LOCK_' . $taskName;
    $processLock      = 'SCHEDULER_PROCESS_LOCK_' . $taskName;
    $schedulerConfigs = \think\Config::get( 'SCHEDULER' );
    $redisConfig      = \think\Config::get( 'cache' );
    $publisherapi     = new \think\PublisherApi();
    $redis            = Cache::connect( $redisConfig );

    // 判断配置中是否还存在该任务
    if ( !isset( $schedulerConfigs[ 'tasks' ][ $taskName ] ) ) return false;
    // 读取配置
    list( $interval, $callback, $params, $wait ) = $schedulerConfigs[ 'tasks' ][ $taskName ];

    // 更新运行锁
    $redis->handler()
          ->setnx( $lockName, time() );
    $redis->handler()
          ->expire( $lockName, $interval + $schedulerConfigs[ 'LOCKDELAY' ] );

    // 任务唯一性判断
    $info = $publisherapi->scheduleInfo( $taskName, $interval * 1000 );
    if ( $info[ 'ready' ] > 0 )
    {
        // 等待下次任务启动，本次不做处理
        return false;
    }

    // 设置执行锁
    if ( $redis->handler()
               ->setnx( $processLock, time() ) )
    {
        // 执行锁为1秒，避免大量启动
        $redis->handler()
              ->expire( $processLock, 1 );
    }
    else
    {
        // 抛弃多余的数据
        return false;
    }
    //生成异步消息
    $msg = array( 'action' => 'SCHEDULER', 'event' => $taskName, 'options' => $data[ 'options' ] );
    //判断回调
    if ( is_array( $callback ) )
    {
        $class = new $callback[ 0 ];
        $func  = $callback[ 1 ];
        $call  = array( $class, $func );
    }
    else if ( is_string( $callback ) )
    {
        $call = $callback;
    }
    else
    {
        return false;
    }
    if ( !$wait ) $publisherapi->scheduleMessage( json_encode( $msg ), $taskName, $interval * 1000 );

    // 执行过程，避免报错，catch出所有错误
    try
    {
        if ( is_null( $params ) )
        {
            call_user_func( $call );
        }
        else
        {
            call_user_func( $call, $params );
        }
    }
    catch ( Exception $error )
    {

    }
    if ( $wait ) $publisherapi->scheduleMessage( json_encode( $msg ), $taskName, $interval * 1000 );
}

//消费者

function consumer ()
{
    $consumerapi = new ConsumerApi();
    $messages    = $consumerapi->consumerMessage();
    messagesProcess( $messages );
}

//生成者

function publisher ( $messages, $delayTime = null )
{
    $param = Request::param() ;
    $param['s'] =  "publics/HttpAsyn/message" ;
    $url = Request::baseFile(true);
    $url = $url . '?' . http_build_query($param);
    $res = longbing_do_request($url,  ['message' => $messages] );

    return $res;

}


//获取毫秒级时间戳
function getMillisecond ()
{
    list( $s1, $s2 ) = explode( ' ', microtime() );
    return (float)sprintf( '%.0f', ( floatval( $s1 ) + floatval( $s2 ) ) * 1000 );
}

/**
 * 发送邮件
 * @param string $address 需要发送的邮箱地址 发送给多个地址需要写成数组形式
 * @param string $subject 标题
 * @param string $content 内容
 * @return boolean       是否成功
 */
function send_email ( $address, $subject, $content )
{
    $email_smtp        = \think\Config::get( 'API_CONFIG.EMAIL_SMTP' );
    $email_username    = \think\Config::get( 'API_CONFIG.EMAIL_USERNAME' );
    $email_password    = \think\Config::get( 'API_CONFIG.EMAIL_PASSWORD' );
    $email_from_name   = \think\Config::get( 'API_CONFIG.EMAIL_FROM_NAME' );
    $email_smtp_secure = \think\Config::get( 'API_CONFIG.EMAIL_SMTP_SECURE' );
    $email_port        = \think\Config::get( 'API_CONFIG.EMAIL_PORT' );

    if ( empty( $email_smtp ) || empty( $email_username ) || empty( $email_password ) || empty( $email_from_name ) )
    {
        return error( 'The mailbox configuration is incomplete!', '1109' );
    }
    require_once '../thinkphp/library/think/class.phpmailer.php';
    require_once '../thinkphp/library/think/class.smtp.php';
    $phpmailer = new \Phpmailer();
    // 设置PHPMailer使用SMTP服务器发送Email
    $phpmailer->IsSMTP();
    // 设置设置smtp_secure
    $phpmailer->SMTPSecure = $email_smtp_secure;
    // 设置port
    $phpmailer->Port = $email_port;
    // 设置为html格式
    $phpmailer->IsHTML( true );
    // 设置邮件的字符编码'
    $phpmailer->CharSet = 'UTF-8';
    // 设置SMTP服务器。
    $phpmailer->Host = $email_smtp;
    // 设置为"需要验证"
    $phpmailer->SMTPAuth = true;
    // 设置用户名
    $phpmailer->Username = $email_username;
    // 设置密码
    $phpmailer->Password = $email_password;
    // 设置邮件头的From字段。
    $phpmailer->From = $email_username;
    // 设置发件人名字
    $phpmailer->FromName = $email_from_name;
    // 添加收件人地址，可以多次使用来添加多个收件人
    if ( is_array( $address ) )
    {
        foreach ( $address as $addressv )
        {
            $phpmailer->AddAddress( $addressv );
        }
    }
    else
    {
        $phpmailer->AddAddress( $address );
    }
    // 设置邮件标题
    $phpmailer->Subject = $subject;
    // 设置邮件正文
    $phpmailer->Body = $content;
    // 发送邮件。

    if ( !$phpmailer->Send() )
    {
        $phpmailererror = $phpmailer->ErrorInfo;
        return error( $phpmailererror, '1102' );
    }
    else
    {
        return array( "status" => 'success' );
    }
}

//测试数据
//use app\admin\model\Test as TestModel;
function test ( $uuid, $data )
{
    dump( $data );
    //    $test_model = new TestModel;
    //    $data['uuid'] = $uuid;
    //    $test_model->createTest($data);

}

/**
 * @Purpose: 处理数组中的图片为完整能访问的URL
 *
 * @Param: array $data 需要处理图片的数组，可以是一维数组也可以是多维数组
 * @Param: array $target 需要处理字段名组成的数组，一维数组
 * @Param: string $split 多张图片放在一起的分隔符
 *
 * @Author: zzf
 *
 * @Return: mixed 查询返回值（结果集对象）
 */
if ( !function_exists( 'transImages' ) )
{
    function transImages ( $data, $target, $split = ',' )
    {

        if ( !is_array( $data ) )
        {
            return $data;
        }


        foreach ( $data as $index => $item )
        {
            if ( is_array( $item ) )
            {
                $data[ $index ] = transImages( $item, $target, $split );
                continue;
            }


            if ( in_array( $index, $target ) && $item )
            {
                $tmpArr         = explode( $split, $item );
                $data[ $index ] = handleImages( $tmpArr );
            }
        }


        return $data;
    }
}

/**
 * @Purpose: 处理数组中的图片为完整能访问的URL--单张图片
 *
 * @Param: array $data 需要处理图片的数组，可以是一维数组也可以是多维数组
 * @Param: array $target 需要处理字段名组成的数组，一维数组
 * @Param: string $split 多张图片放在一起的分隔符
 *
 * @Author: zzf
 *
 * @Return: mixed 查询返回值（结果集对象）
 */
if ( !function_exists( 'transImagesOne' ) )
{
    function transImagesOne ( $data, $target ,$uniacid = '7777')
    {
        if(longbingIsWeiqin())
        {
            global $_W;
            if (isset($_W['uniacid']))
            {
                $uniacid = $_W['uniacid'];
            }
            else
            {
                if(defined('LONGBING_CARD_UNIACID'))
                {
                    $uniacid = LONGBING_CARD_UNIACID;
                }
             }
        }
        if ( !is_array( $data ) )
        {
             return $data;
        }
        foreach ( $data as $index => $item )
        {
            if ( is_array( $item ) )
            {
                $data[ $index ] = transImagesOne( $item, $target ,$uniacid);
                continue;
            }

            if ( in_array( $index, $target ) && $item )
            {
                $src = trim( $item );

                //  老版本微擎的图片
                if ( empty( $src ) || !$src )
                {
                    $data[ $index ] = $src;
                    continue;
                }

                $sub = substr( $src, 0, 4 );
                //  连接已经是完整的连接了，无需在处理
                if ( $sub == 'http' )
                {
                    continue;
                }
                $sub = substr( $src, 0, 2 );
                if ( $sub == '//' || $sub == 'wx' )
                {
                    continue;
                }

                //  是新版的图片id用新的处理方法
                if ( is_numeric( $src ) )
                {
                    //TODO 新版的图片处理方法
                    continue;
                }
                if(longbingIsWeiqin())
                {

                     if ( strstr( $src, 'addons/' ) !== false )
                     {
                         $data[ $index ] = $_W[ 'siteroot' ] . substr( $src, strpos( $src, 'addons/' ) );
                     }
                     if ( strstr( $src, $_W[ 'siteroot' ] ) !== false && strstr( $src, '/addons/' ) === false )
                     {
                         $urls           = parse_url( $src );
                         $data[ $index ] = $t = substr( $urls[ 'path' ], strpos( $urls[ 'path' ], 'images' ) );
                         continue;
                     }
                     if ( empty( $_W[ 'setting' ][ 'remote' ][ 'type' ] ) && ( empty( $_W[ 'uniacid' ] ) || !empty( $_W[ 'uniacid' ] ) && empty( $_W[ 'setting' ][ 'remote' ][ $_W[ 'uniacid' ] ][ 'type' ] ) ) || file_exists( IA_ROOT . '/' . $_W[ 'config' ][ 'upload' ][ 'attachdir' ] . '/' . $src ) )
                     {

                         $data[ $index ] = $_W[ 'siteroot' ] . $_W[ 'config' ][ 'upload' ][ 'attachdir' ] . '/' . $src;

                     }
                     else
                     {

                         $result = longbingGetOssConfig($uniacid);

                         if (isset($result['default_url']) && !$result['default_url']){
                             $result['default_url'] = $_SERVER['HTTP_HOST'] . '/attachment/upload';
                         }
                         $data[ $index ] = $result['default_url'] . '/' . $src;

                    }
                }
                if(strpos($src,'http') === false){
                    $longbingOssConfig = longbingGetOssConfig($uniacid);
                     $http_agreemet = 'https';
                    if(!isset($longbingOssConfig['default_url']) || empty($longbingOssConfig['default_url']) || empty($longbingOssConfig['open_oss']))
                    {
                        $longbingOssConfig['default_url'] = $_SERVER['HTTP_HOST'] . '/attachment';
                        if(isset($_SERVER['REQUEST_SCHEME']) && !empty($_SERVER['REQUEST_SCHEME'])) $http_agreemet = $_SERVER['REQUEST_SCHEME'];
                    }
                    if(longbingHasLocalFile($src))
                    {
                        $longbingOssConfig['default_url'] = $_SERVER['HTTP_HOST'] . '/attachment';
                        if(isset($_SERVER['REQUEST_SCHEME']) && !empty($_SERVER['REQUEST_SCHEME'])) $http_agreemet = $_SERVER['REQUEST_SCHEME'];
                    }
                    //http协议
                    if(strpos($longbingOssConfig['default_url'],'http') === false){
                        $longbingOssConfig['default_url'] = $http_agreemet . '://'.$longbingOssConfig['default_url'];
                    }
                    $data[ $index ] = $longbingOssConfig['default_url'] . '/' . $src;
                }else{
                    $data[ $index ] = $src;
                }
            }

        }
        return $data;
    }
}

function longbingHasLocalFile($file_name)
{
    $file_path = FILE_UPLOAD_PATH . $file_name;
    return file_exists($file_path);
}


/**
 * @Purpose: 微擎处理本地图片
 *
 * @Param: array $data 需要处理图片的数组，可以是一维数组也可以是多维数组
 * @Param: array $target 需要处理字段名组成的数组，一维数组
 * @Param: string $split 多张图片放在一起的分隔符
 *
 * @Author: zzf
 *
 * @Return: mixed 查询返回值（结果集对象）
 */
if ( !function_exists( 'handleImagesWe7Local' ) )
{
    function handleImagesWe7Local ( $data, $target, $split = ',' )
    {
        global $_W;
        if ( !is_array( $data ) )
        {
            return $data;
        }


        foreach ( $data as $index => $item )
        {
            if ( is_array( $item ) )
            {
                $data[ $index ] = handleImagesWe7Local( $item, $target, $split );
                continue;
            }


            if ( in_array( $index, $target ) && $item )
            {
                $item   = trim( $item, $split );
                $tmpArr = explode( $split, $item );
                foreach ( $tmpArr as $index2 => $item2 )
                {
                    $tmpArr[ $index2 ] = $_W[ 'siteroot' ] . $_W[ 'config' ][ 'upload' ][ 'attachdir' ] . '/' . $item2;
                }
                $data[ $index ] = $tmpArr;
            }
        }


        return $data;
    }
}

/**
 * @Purpose: 处理图片
 *
 * @Param: array $data 图片数组
 * @Author: zzf
 *
 * @Return: mixed 查询返回值（结果集对象）
 */
if ( !function_exists( 'handleImages' ) )
{
    function handleImages ( $data )
    {
        global $_W;

        if (isset($_W['uniacid']))
        {
            $uniacid = $_W['uniacid'];
        }
        else
        {
            if(defined('LONGBING_CARD_UNIACID'))
            {
                $uniacid = LONGBING_CARD_UNIACID;
            }
            else
            {
                $uniacid = 7777;
            }
        }


        if ( !is_array( $data ) )
        {
            return $data;
        }

        foreach ( $data as $index => $item )
        {
            $src = trim( $item );
            //$src = strtolower( $src );

            $sub = substr( $src, 0, 4 );
            //  连接已经是完整的连接了，无需在处理
            if ( $sub == 'http' )
            {
                continue;
            }
            $sub = substr( $src, 0, 2 );
            if ( $sub == '//' || $sub == 'wx' )
            {
                continue;
            }


            //  是新版的图片id用新的处理方法
            if ( is_numeric( $src ) )
            {
                //TODO 新版的图片处理方法
                continue;
            }


            //  老版本微擎的图片
            if ( empty( $src ) || !$src )
            {
                $data[ $index ] = $src;
                continue;
            }

            if ( strstr( $src, 'addons/' ) !== false )
            {
                $data[ $index ] = $_W[ 'siteroot' ] . substr( $src, strpos( $src, 'addons/' ) );
            }
            if ( strstr( $src, $_W[ 'siteroot' ] ) !== false && strstr( $src, '/addons/' ) === false )
            {
                $urls           = parse_url( $src );
                $data[ $index ] = $t = substr( $urls[ 'path' ], strpos( $urls[ 'path' ], 'images' ) );
                continue;
            }

//            if ( empty( $_W[ 'setting' ][ 'remote' ][ 'type' ] ) && ( !empty( $_W[ 'uniacid'] ) && empty( $_W[ 'setting' ][ 'remote' ][ $_W[ 'uniacid' ] ][ 'type' ] ) ) || file_exists( IA_ROOT . '/' . $_W[ 'config' ][ 'upload' ][ 'attachdir' ] . '/' . $src ) )
//            {
//
//
//                $data[ $index ] = $_W[ 'siteroot' ] . $_W[ 'config' ][ 'upload' ][ 'attachdir' ] . '/' . $src;
//
//            }
//            else
//            {
//              $result = longbingGetOssConfig($uniacid,true);
//              if (empty($result['default_url'])){
//                  $result['default_url'] = $_SERVER['HTTP_HOST'] . '/attachment/upload';
//              }
//              if(strpos($result['default_url'],'http') === false){
//                  $result['default_url'] = 'https://'.$result['default_url'];
//              }
//              $data[ $index ] = $result['default_url'] . '/' . $src;

                if(strpos($src,'http') === false){
                    $longbingOssConfig = longbingGetOssConfig($uniacid);
                     $http_agreemet = 'https';
                    if(!isset($longbingOssConfig['default_url']) || empty($longbingOssConfig['default_url']) || empty($longbingOssConfig['open_oss']))
                    {
                        $longbingOssConfig['default_url'] = $_SERVER['HTTP_HOST'] . '/attachment';
                        if(isset($_SERVER['REQUEST_SCHEME']) && !empty($_SERVER['REQUEST_SCHEME'])) $http_agreemet = $_SERVER['REQUEST_SCHEME'];
                    }
                    if(longbingHasLocalFile($src))
                    {
                        $longbingOssConfig['default_url'] = $_SERVER['HTTP_HOST'] . '/attachment';
                        if(isset($_SERVER['REQUEST_SCHEME']) && !empty($_SERVER['REQUEST_SCHEME'])) $http_agreemet = $_SERVER['REQUEST_SCHEME'];
                    }
                    //http协议
                    if(strpos($longbingOssConfig['default_url'],'http') === false){
                        $longbingOssConfig['default_url'] = $http_agreemet . '://'.$longbingOssConfig['default_url'];
                    }
                    $data[ $index ] = $longbingOssConfig['default_url'] . '/' . $src;
                }else{
                    $data[ $index ] = $src;
                }
            }

//        }
        return $data;
    }
}

/**
 * @Purpose: 打印并终止程序
 *
 * @Param: array $data 需要打印的数据
 *
 * @Author: zzf
 *
 * @Return: mixed 查询返回值（结果集对象）
 */
if ( !function_exists( 'zDumpAndDie' ) )
{
    function zDumpAndDie ( $data )
    {
        echo '<pre>';
        var_dump( $data );
        echo '</pre>';
        die;
    }
}

/**
 * @Purpose: 打印数据
 *
 * @Param: array $data 需要打印的数据
 *
 * @Author: zzf
 *
 * @Return: mixed 查询返回值（结果集对象）
 */
if ( !function_exists( 'zDump' ) )
{
    function zDump ( $data )
    {
        echo '<pre>';
        var_dump( $data );
        echo '</pre>';
    }
}


/**
 * 检验数据的真实性，并且获取解密后的明文.
 * @param $encryptedData string 加密的用户数据
 * @param $iv string 与用户数据一同返回的初始向量
 * @param $data string 解密后的原文
 *
 * @return int 成功0，失败返回对应的错误码
 */
if ( !function_exists( 'decryptDataLongbing' ) )
{
    function decryptDataLongbing ( $appid, $sessionKey, $encryptedData, $iv, &$data )
    {
        $OK                = 0;
        $IllegalAesKey     = -41001;
        $IllegalIv         = -41002;
        $IllegalBuffer     = -41003;
        $DecodeBase64Error = -41004;

        if ( strlen( $sessionKey ) != 24 )
        {
            return $IllegalAesKey;
        }
        $aesKey = base64_decode( $sessionKey );


        if ( strlen( $iv ) != 24 )
        {
            return $IllegalIv;
        }
        $aesIV = base64_decode( $iv );

        $aesCipher = base64_decode( $encryptedData );

        $result = openssl_decrypt( $aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV );

        $dataObj = json_decode( $result );

        if ( $dataObj == NULL )
        {
            return $IllegalBuffer;
        }
        if ( $dataObj->watermark->appid != $appid )
        {
            return $IllegalBuffer;
        }
        $data = $result;
        return $OK;
    }



}

/**
 * 数据解密：低版本使用mcrypt库（PHP < 5.3.0），高版本使用openssl库（PHP >= 5.3.0）。
 *
 * @param string $ciphertext    待解密数据，返回的内容中的data字段
 * @param string $iv            加密向量，返回的内容中的iv字段
 * @param string $app_key       创建小程序时生成的app_key
 * @param string $session_key   登录的code换得的
 * @return string | false
 */
if ( !function_exists( 'baiduDecryptDataLongbing' ) )
{
    function baiduDecryptDataLongbing($ciphertext, $iv, $app_key, $session_key) {
        $session_key = base64_decode($session_key);
        $iv = base64_decode($iv);
        $ciphertext = base64_decode($ciphertext);

        $plaintext = false;
        if (function_exists("openssl_decrypt")) {
            $plaintext = openssl_decrypt($ciphertext, "AES-192-CBC", $session_key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);
        } else {
            $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, null, MCRYPT_MODE_CBC, null);
            mcrypt_generic_init($td, $session_key, $iv);
            $plaintext = mdecrypt_generic($td, $ciphertext);
            mcrypt_generic_deinit($td);
            mcrypt_module_close($td);
        }
        if ($plaintext == false) {
            return false;
        }

        // trim pkcs#7 padding
        $pad = ord(substr($plaintext, -1));
        $pad = ($pad < 1 || $pad > 32) ? 0 : $pad;
        $plaintext = substr($plaintext, 0, strlen($plaintext) - $pad);

        // trim header
        $plaintext = substr($plaintext, 16);
        // get content length
        $unpack = unpack("Nlen/", substr($plaintext, 0, 4));
        // get content
        $content = substr($plaintext, 4, $unpack['len']);
        // get app_key
        $app_key_decode = substr($plaintext, $unpack['len'] + 4);

        return $app_key == $app_key_decode ? $content : false;
    }
}

/**
 * @Purpose: 获取随机字符串
 *
 * @Author: zzf
 *
 * @Return: mixed 查询返回值（结果集对象）
 */

if ( !function_exists( 'getRandStr' ) )
{
    function getRandStr ( $len )
    {
        $len = intval( $len );
        $a   = "A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,S,Y,Z";
        $a   = explode( ',', $a );
        $tmp = '';
        for ( $i = 0; $i < $len; $i++ )
        {
            $rand = rand( 0, count( $a ) - 1 );
            $tmp  .= $a[ $rand ];
        }
        return $tmp;
    }
}


/**
 * @Purpose: 处理腾讯视频
 *
 * @Author: zzf
 *
 * @Return: mixed 查询返回值（结果集对象）
 */
if ( !function_exists( 'lbGetTencentVideo' ) )
{
    function lbGetTencentVideo ( $src )
    {
        if ( !$src )
        {
            return '';
        }

        if ( !strstr( $src, 'v.qq.com' ) )
        {
            return 0;
        }

        if ( strstr( $src, 'vid' ) )
        {
            $str    = strstr( $src, 'vid' );
            $tmpArr = explode( '=', $str );
            $str    = $tmpArr[ 1 ];
        }
        else
        {
            $tmpArr = explode( '/', $src );
            $str    = $tmpArr[ count( $tmpArr ) - 1 ];
            $tmpArr = explode( '.', $str );
            $str    = $tmpArr[ 0 ];
        }

        if ( $str )
        {
            return $str;
        }
        return $src;
    }
}


/**
 * @Purpose: 处理雷达数据返回文字
 *
 * @Author: zzf
 *
 * @Return: mixed 查询返回值（结果集对象）
 */
if ( !function_exists( 'lbHandelRadarList' ) )
{
    function lbHandelRadarList ( $data )
    {
        $tmp = array();
        foreach ( $data as $index => $item )
        {
            switch ( $item[ 'sign' ] )
            {
                case 'copy':
                    break;
                case 'view':
                    break;
                case 'praise':
                    break;
                case 'order':
                    break;
                case 'qr':
                    break;
            }
        }
        return $tmp;
    }
}


/**
 * @Purpose: 处理雷达日期
 *
 * @Author: zzf
 *
 * @Return: mixed 查询返回值（结果集对象）
 */
if ( !function_exists( 'lbHandelRadarDate' ) )
{
    function lbHandelRadarDate ( $data, $field = 'create_time' )
    {
        //  今天的时间戳
        $time = time();
        //  昨天的时间戳
        $Yesterday = $time - ( 24 * 60 * 60 );

        $today     = mktime( 0, 0, 0, date( "m", $time ), date( "d", $time ), date( "Y", $time ) );
        $Yesterday = mktime( 0, 0, 0, date( "m", $Yesterday ), date( "d", $Yesterday ), date( "Y", $Yesterday ) );

        foreach ( $data as $index => $item )
        {

            if(!key_exists($field,$item)){

                continue;
            }

            $tmpTime = $item[ $field ];

            if ( $tmpTime > $today )
            {
                //                $data[ $index ][ 'radar_time' ] = '今天 ';
                $data[ $index ][ 'radar_group' ] = '今天';
                $data[ $index ][ 'radar_time' ]  = date( 'H:i', $item[ $field ] );
            }
            else if ( $tmpTime > $Yesterday )
            {
                //                $data[ $index ][ 'radar_time' ] = '昨天 ';
                $data[ $index ][ 'radar_group' ] = '昨天';
                $data[ $index ][ 'radar_time' ]  = date( 'H:i', $item[ $field ] );
            }
            else
            {
                $thisYear = date( 'Y' );
                $itemYear = date( 'Y', $item[ $field ] );
                if ( $thisYear == $itemYear )
                {
                    $data[ $index ][ 'radar_group' ] = date( 'm-d', $item[ $field ] );
                    $data[ $index ][ 'radar_time' ]  = date( ' H:i', $item[ $field ] );
                }
                else
                {
                    $data[ $index ][ 'radar_group' ] = date( 'Y-m-d', $item[ $field ] );
                    $data[ $index ][ 'radar_time' ]  = date( ' H:i', $item[ $field ] );
                }

            }
        }

        return $data;
    }
}

/**
 * @Purpose: 处理雷达用户来源
 *
 * @Author: zzf
 *
 * @Return: mixed 查询返回值（结果集对象）
 */
if ( !function_exists( 'lbHandelRadarSource' ) )
{
    function lbHandelRadarSource ( $data )
    {

        $modelUser = new \app\card\model\User();
        // share_source 用户端来源 1 => 微信小程序
        foreach ( $data as $index => $item )
        {
            $data[ $index ][ 'share_str' ]    = [ [ 'title' => '来自搜索', 'is_openGId' => 0 ] ];
            $data[ $index ][ 'share_source' ] = 1;


            if ( isset($item[ 'from_uid' ]) )
            {
                $share_info = $modelUser->where( [ [ 'id', '=', $item[ 'from_uid' ] ] ] )
                                        ->find();
                if ( $share_info )
                {
                    $data[ $index ][ 'share_str' ] = [ [ 'title' => '来自' . $share_info[ 'nickName' ], 'is_openGId' => 0 ] ];
                    if ( $share_info[ 'is_staff' ] == 1 )
                    {
                        $share_info = \app\card\model\UserInfo::where( [ [ 'fans_id', '=', $item[ 'from_uid' ] ] ]
                        )
                                                              ->find();
                        //                    $data['share_str']  = '来自' . $share_info['name'] . '分享的名片';
                        if ( isset( $share_info[ 'name' ] ) && $share_info[ 'name' ] )
                        {
                            $data[ $index ][ 'share_str' ] = [ [ 'title' => '来自' . $share_info[ 'name' ], 'is_openGId' => 0 ] ];
                        }
                    }

                    if ( $item[ 'is_qr' ] == 0 && $item[ 'is_group' ] == 0 )
                    {
                        $data[ $index ][ 'share_str' ][1] = [ 'title' => '分享的名片', 'is_openGId' => 0 ];
                    }

                    if ( $item[ 'is_qr' ] )
                    {
                        $data[ $index ][ 'share_str' ][1] = [ 'title' => '分享的二维码', 'is_openGId' => 0 ];
                    }
                    if ( $item[ 'is_group' ] )
                    {
                        $data[ $index ][ 'share_str' ][1]    = [ 'title' => '分享到群的名片', 'is_openGId' => 0 ];
                        $data[ $index ][ 'is_group_opGId' ] = $item[ 'openGId' ];
                    }
                    if ( $item[ 'is_group' ] && $item[ 'is_qr' ] )
                    {
                        $data[ $index ][ 'share_str' ][1]    = [ 'title' => '分享到群的二维码', 'is_openGId' => 0 ];
                        $data[ $index ][ 'is_group_opGId' ] = $item[ 'openGId' ];
                    }
                    if ( $item[ 'is_group' ] && $item[ 'openGId' ] )
                    {
                        $data[ $index ][ 'share_str' ][1]    = [ 'title' => '分享到群', 'is_openGId' => 0 ];
                        $data[ $index ][ 'share_str' ][2]    = [ 'title' => $item[ 'openGId' ], 'is_openGId' => 1 ];
                        $data[ $index ][ 'share_str' ][3]    = [ 'title' => '的名片', 'is_openGId' => 0 ];
                        $data[ $index ][ 'is_group_opGId' ] = $item[ 'openGId' ];
                    }
                    if ( $item[ 'is_group' ] && $item[ 'is_qr' ] && $item[ 'openGId' ] )
                    {
                        $data[ $index ][ 'share_str' ][1]    = [ 'title' => '分享到群', 'is_openGId' => 0 ];
                        $data[ $index ][ 'share_str' ][2]    = [ 'title' => $item[ 'openGId' ], 'is_openGId' => 1 ];
                        $data[ $index ][ 'share_str' ][3]    = [ 'title' => '的二维码', 'is_openGId' => 0 ];
                        $data[ $index ][ 'is_group_opGId' ] = $item[ 'openGId' ];
                    }
                }
            }
            if ( $item &&isset($item[ 'from_uid' ])&&$item[ 'from_uid' ] == 0 )
            {
                if ( $item[ 'is_qr' ] )
                {
                    $data[ $index ][ 'share_str' ] = [ [ 'title' => '来自二维码', 'is_openGId' => 0 ] ];
                }
                if ( $item[ 'is_group' ] )
                {
                    $data[ $index ][ 'share_str' ]      = [ [ 'title' => '来自群分享', 'is_openGId' => 0 ] ];
                    $data[ $index ][ 'is_group_opGId' ] = $item[ 'openGId' ];
                }
                if ( $item[ 'is_group' ] && $item[ 'openGId' ] )
                {
                    $data[ $index ][ 'share_str' ]      = [ [ 'title' => '来自群', 'is_openGId' => 0 ] ];
                    $data[ $index ][ 'share_str' ][]    = [ 'title' => $item[ 'openGId' ], 'is_openGId' => 1 ];
                    $data[ $index ][ 'share_str' ][]    = [ 'title' => '分享', 'is_openGId' => 0 ];
                    $data[ $index ][ 'is_group_opGId' ] = $item[ 'openGId' ];
                }
            }
            if ( $item &&isset($item[ 'handover_name' ])&&$item[ 'handover_name' ])
            {
                $data[ $index ][ 'share_str' ] = [ [ 'title' => '来自' . $item[ 'handover_name' ] . '的工作交接', 'is_openGId' => 0 ] ];
            }

            //  导入客户头像
            if ( isset($item[ 'import' ])&&$item[ 'import' ] )
            {
                $data[ $index ][ 'avatarUrl' ] = $item[ 'avatarUrl' ];
                $data[ $index ][ 'share_str' ] = [ [ 'title' => '来自后台管理员导入', 'is_openGId' => 0 ] ];
            }
            //  导入客户头像
            if ( $item && isset($item[ 'is_auto' ])&&$item[ 'is_auto' ] )
            {
                $data[ $index ][ 'share_str' ] = [ [ 'title' => '来自系统自动分配', 'is_openGId' => 0 ] ];
            }
        }

        return $data;
    }
}


/**
 * 获取地步菜单名字
 */
if ( !function_exists( 'tabbarName' ) )
{

    function tabbarName($key,$uniacid){


        $web   = [];

        $m_diy = new DiyModel();

        $data = $m_diy->where(['uniacid'=>$uniacid,'status'=>1])->find();

        if(!empty($data)){

            $data = $data->toArray();

            $tabbar = json_decode($data['tabbar'],true);

            $list   = $tabbar['list'];

            if(!empty($list)){
                foreach ($list as $value){

                    if($value['key'] == $key){

                        $web = $value['name'];
                    }
                }
            }
        }
        return $web;
    }
}


if ( !function_exists( 'changeRadarMsg' ) )
{

    function changeRadarMsg($msgList,$uniacid){

        if(!empty($msgList)){

            foreach ($msgList as $k=>$v){
                //官网
                if(($v['sign']=='view'&&$v['type']==6)||($v['sign']=='view'&&$v['type']==18)){

                    $name = tabbarName(4,$uniacid);

                    if(!empty($name)&&$name!='官网'){

                        $msgList[$k]['item']     = str_replace('企业官网',$name, $msgList[$k]['item']);

                        $msgList[$k]['operation'] = str_replace('官网',$name, $msgList[$k]['operation']);
                    }
                }
            }
        }
        return $msgList;
    }
}


/**
 * @Purpose: 处理雷达激励提醒文案
 *
 * @Author: zzf
 *
 * @Return: mixed 查询返回值（结果集对象）
 */
if ( !function_exists( 'lbHandelRadarMsg' ) )
{
    function lbHandelRadarMsg ( $data )
    {
        $result = [];
        if ( empty( $data )||empty($data[ 0 ][ 'uniacid' ]) )
        {
            return $data;
        }
        $msgList = \app\radar\model\RadarMsg::where( [ [ 'uniacid', '=', $data[ 0 ][ 'uniacid' ] ] ])->order( [ 'mini' => 'desc' ] )->select()->toArray();
        if ( !$msgList || empty( $msgList ) )
        {
            $msgList = lbInitRadarMsg( $data[ 0 ][ 'uniacid' ] );
        }


        //替换文字
        $msgList =  changeRadarMsg($msgList,$data[ 0 ][ 'uniacid' ]);

//dump($msgList);exit;

        foreach ( $data as $index => $item )
        {


            $data[ $index ][ 'radar_arr' ] = [];

            foreach ( $msgList as $index2 => $item2 )
            {



                if ( $item2[ 'sign' ] != $item[ 'sign' ] || $item2[ 'type' ] != $item[ 'type' ] )
                {
                    continue;
                }


                $radar = $item2;

                if ( $radar[ 'show_count' ] )
                {
                    $showCount = lbHandelRadarShowCount( $item );

                    $out = false;

                    if ( $showCount <= $radar[ 'mini' ] || $showCount >= $radar[ 'max' ] )
                    {
                        $out = true;
                    }

                    if ( $showCount >= $radar[ 'mini' ] && $radar[ 'max' ] == 0 )
                    {
                        $out = false;
                    }

                    if ( $radar[ 'mini' ] == 0 && $radar[ 'max' ] == 0 )
                    {
                        $out = false;
                    }

                    if ( $out )
                    {
                        continue;
                    }

                    if ( $showCount === 0 )
                    {
                        $data[ $index ][ 'radar_arr' ][] = [ 'title' => '首次', 'color' => 0 ];
                    }
                    else
                    {
                        $data[ $index ][ 'radar_arr' ][] = [ 'title' => '第' . ($showCount+1) . '次', 'color' => 0 ];
                    }
                }

                $data[ $index ][ 'radar_arr' ][] = [ 'title' => $radar[ 'operation' ], 'color' => 1 ];

                if ( $radar[ 'item' ] )
                {
                    $data[ $index ][ 'radar_arr' ][] = [ 'title' => '你的', 'color' => 0 ];
                    $data[ $index ][ 'radar_arr' ][] = [ 'title' => $radar[ 'item' ], 'color' => 1 ];
                }

                if ( $radar[ 'table_name' ] && $item[ 'target' ] && $radar[ 'field' ] )
                {
                    $info   = @\think\facade\Db::name( $radar[ 'table_name' ] )
                                               ->find( $item[ 'target' ] );


                    $tmpArr = explode( ',', $radar[ 'field' ] );
                    //预约零时解决方案
                    $tmpStr1 = null;
                    if(in_array($radar['sign'], ['order']) && in_array($radar['type'], ['3']))
                    {
                        $project_name = '';
                        if(isset($info['project_id']) && !empty($info['project_id']))
                        {
                            $project = @\think\facade\Db::name( 'lb_appoint_project' )->field('title')->find($info['project_id']);
                            if(!empty($project) && !empty($project['title'])) $project_name = $project['title'];
                        }
                        $time = time();
                        if(!empty($info['start_time'])) $time = $info['start_time'];
                        $remerk = '暂无';
                        if(!empty($info['remerk'])) $remerk = $info['remerk'];
                        $tmpStr1 = $project_name .' ,预约时间:' . date('y-m-d H:m:s' ,$time) . ' ,备注信息:' .$remerk;
                    }
                    if ( $info && !empty( $tmpArr ) )
                    {
                        $tmpStr = '';
                        foreach ( $info as $index2 => $item2 )
                        {

                            if ( in_array( $index2, $tmpArr ) )
                            {
                                $tmpStr .= '，' . $item2;
                            }
                        }

                        $tmpStr = $tmpStr.' ';

                        $tmpStr = trim( $tmpStr, '，' );


                        if(!empty($tmpStr1)) $tmpStr = $tmpStr1;
                        if ( $tmpStr )
                        {
                            $data[ $index ][ 'radar_arr' ][] = [ 'title' => ': ', 'color' => 0 ];
                            $data[ $index ][ 'radar_arr' ][] = [ 'title' => $tmpStr, 'color' => 0 ];
                        }
                    }

                }

                if ( !empty( $data[ $index ][ 'radar_arr' ] ) && $radar[ 'msg' ] )
                {
                    $data[ $index ][ 'radar_arr' ][] = [ 'title' => '，', 'color' => 0 ];
                }


                $data[ $index ][ 'radar_arr' ][] = [ 'title' => $radar[ 'msg' ], 'color' => 0 ];

                if ( $item[ 'duration' ] )
                {
                    $data[ $index ][ 'radar_arr' ][] = [ 'title' => '时长: ' . $item[ 'duration' ] . '秒', 'color' => 1 ];
                }


            }

            if ( empty( $data[ $index ][ 'radar_arr' ] ) )
            {
                $data[ $index ][ 'radar_arr' ][] = [ 'title' => '进入你的名片，请把握商机！', 'color' => 0 ];
            }


            if(!json_encode($data))
            {
                unset($data[ $index ]);
            }else{

                if(key_exists($index,$data)){
                    $result[] = $data[ $index ];
                }

            }
        }

        return $result;
    }
}
if ( !function_exists( 'lbHandelRadarMsgBac' ) )
{
    function lbHandelRadarMsgBac ( $data )
    {
        if ( empty( $data ) )
        {
            return $data;
        }
        $msgList = \app\radar\model\RadarMsg::where([['uniacid', '=', $data[0]['uniacid']]])->select()->toArray();

        //自动导入雷达数据
        if ( !$msgList || empty( $msgList ) )
        {
            $msgList = lbInitRadarMsg( $data[ 0 ][ 'uniacid' ] );
        }

        $tmpMsgList = array();
        foreach ( $msgList as $index => $item )
        {
            $tmpMsgList[ $item[ 'sign' ] . $item[ 'type' ] ] = $item;
        }

        foreach ( $data as $index => $item )
        {
            $data[ $index ][ 'radar_arr' ] = [];
            if ( isset( $tmpMsgList[ $item[ 'sign' ] . $item[ 'type' ] ] ) )
            {
                $radar = $tmpMsgList[ $item[ 'sign' ] . $item[ 'type' ] ];

                if ( $radar[ 'show_count' ] )
                {
                    $showCount = lbHandelRadarShowCount( $item );
                    if ( $showCount === 0 )
                    {
                        $data[ $index ][ 'radar_arr' ][] = [ 'title' => '首次', 'color' => 0 ];
                    }
                    else
                    {
                        $data[ $index ][ 'radar_arr' ][] = [ 'title' => '第' . $showCount . '次', 'color' => 0 ];
                    }
                }

                $data[ $index ][ 'radar_arr' ][] = [ 'title' => $radar[ 'operation' ], 'color' => 1 ];

                if ( $radar[ 'item' ] )
                {
                    $data[ $index ][ 'radar_arr' ][] = [ 'title' => '你的', 'color' => 0 ];
                    $data[ $index ][ 'radar_arr' ][] = [ 'title' => $radar[ 'item' ], 'color' => 1 ];
                }

                if ( $radar[ 'table_name' ] && $item[ 'target' ] && $radar[ 'field' ] )
                {
                    $info   = @\think\facade\Db::name( $radar[ 'table_name' ] )
                                               ->find( $item[ 'target' ] );
                    $tmpArr = explode( ',', $radar[ 'field' ] );
                    if ( $info && !empty( $tmpArr ) )
                    {
                        $tmpStr = '';
                        foreach ( $info as $index2 => $item2 )
                        {
                            if ( in_array( $index2, $tmpArr ) )
                            {
                                $tmpStr .= '，' . $item2;
                            }
                        }
                        $tmpStr = trim( $tmpStr, '，' );
                        if ( $tmpStr )
                        {
                            $data[ $index ][ 'radar_arr' ][] = [ 'title' => ': ', 'color' => 0 ];
                            $data[ $index ][ 'radar_arr' ][] = [ 'title' => $tmpStr, 'color' => 0 ];
                        }
                    }
                }

                if ( !empty( $data[ $index ][ 'radar_arr' ] ) && $radar[ 'msg' ] )
                {
                    $data[ $index ][ 'radar_arr' ][] = [ 'title' => '，', 'color' => 0 ];
                }

                $data[ $index ][ 'radar_arr' ][] = [ 'title' => $radar[ 'msg' ], 'color' => 0 ];

                if ( $item[ 'duration' ] )
                {
                    $data[ $index ][ 'radar_arr' ][] = [ 'title' => '时长: ' . $item[ 'duration' ] . '秒', 'color' => 1 ];
                }


            }
            else
            {
                $data[ $index ][ 'radar_arr' ][] = [ 'title' => '进入你的名片，请把握商机！', 'color' => 0 ];
            }
        }

        return $data;
    }
}

/**
 * @Purpose: 雷达相同类型出现的次数
 *
 * @Author: zzf
 *
 * @Return: mixed 查询返回值（结果集对象）
 */
if ( !function_exists( 'lbHandelRadarShowCount' ) )
{
    function lbHandelRadarShowCount ( $item )
    {
        $model = new \app\radar\model\RadarCount();

        $count = $model->where( [ [ 'uniacid', '=', $item[ 'uniacid' ] ], [ 'to_uid', '=', $item[ 'to_uid' ] ],
                                    [ 'sign', '=', $item[ 'sign' ] ], [ 'type', '=', $item[ 'type' ] ],
                                    [ 'id', '<', $item[ 'id' ] ], [ 'user_id', '=', $item[ 'user_id' ] ], ]
        )
                       ->count();
        return intval( $count );
    }
}

/**
 * @Purpose: 初始化雷达激励提醒文案
 *
 * @Author: zzf
 *
 * @Return: mixed 查询返回值（结果集对象）
 */
if ( !function_exists( 'lbInitRadarMsg' ) )
{
    function lbInitRadarMsg ( $uniacid )
    {

        $model = new \app\radar\model\RadarMsg();
        //$list  = longbingInitRadarMessage();
        $list = longbing_init_info_data('RadarMessage');

        //var_dump($list);exit;

        $time = time();
        $saveList = [];
        foreach ( $list as $index => $item )
        {
            //判断是否新增过了 , 应该判断几个核心字段,可能需要新增字段判断,这里判断不科学
            $whereCountData[ 'uniacid' ]     = $uniacid;
            $whereCountData[ 'sign' ]     = $item['sign'];
            $whereCountData[ 'type' ]     = $item['type'];

            $radarMsgData = $model->where($whereCountData)->find();

            if(!$radarMsgData){
                $item[ 'create_time' ] = $time;
                $item[ 'update_time' ] = $time;
                $item[ 'uniacid' ]     = $uniacid;
                //$saveList[] = $item;
                $model->insert($item);
            }else{
                $item[ 'update_time' ] = $time;
                $item[ 'uniacid' ]     = $uniacid;
                $item = array_merge($radarMsgData->toArray(),$item);  //合并配置更新
                $model->update($item);
            }

        }
        //判断一个加入一个,还没有好办法判断导入的$list 去重
        //$result = $model->saveAll( $saveList );

        return $model->where( [ [ 'uniacid', '=', $uniacid ] ])->select()->toArray();
    }
}

/**
 * @Purpose: 参数验证
 *
 * @Author: zzf
 *
 * @Return: mixed 查询返回值（结果集对象）
 */
if ( !function_exists( 'lbGetParamVerify' ) )
{
    function lbGetParamVerify ( $data, $verify )
    {
        $tmpData = [];
        foreach ( $verify as $index => $item )
        {
            if ( isset( $data[ $index ] ) )
            {
                if ( $item === 'required' && is_string( $data[ $index ] ) && !$data[ $index ] )
                {
                    echo json_encode( [ 'code' => 400, 'error' => '缺少参数' . $index ] );
                    exit;
                }
                if ( ( is_string( $data[ $index ] ) || is_numeric( $data[ $index ] ) ) && !is_array( $data[ $index ] ) )
                {
                    $data[ $index ] = trim( $data[ $index ] );
                }
                $tmpData[ $index ] = $data[ $index ];
            }
            else
            {
                if ( $item === 'required' )
                {
                    echo json_encode( [ 'code' => 400, 'error' => 'need param ' . $index ] );
                    exit;
                }
                else
                {
                    if ( ( is_string( $item ) || is_numeric( $item ) ) && !is_array( $item ) )
                    {
                        $item = trim( $item );
                    }
                    $tmpData[ $index ] = $item;
                }
            }
        }

        return $tmpData;
    }
}

/**
 * @Purpose: 处理时间戳--单个
 *
 * @Param: $data    array   需要处理的二维数组
 *
 * @Author: zzf
 *
 * @Return: mixed 查询返回值（结果集对象）
 */
if ( !function_exists( 'handleTimes' ) )
{
    function handleTimes ( $data, $item_name = 'create_time', $rule = 'Y-m-d H:i:s' )
    {
        foreach ( $data as $index => $item )
        {
            $data[ $index ][ $item_name ] = date( $rule, $item[ $item_name ] );
        }

        return $data;
    }
}

/**
 * @Purpose: 处理时间戳--数组
 *
 * @Param: $data    array   需要处理的二维数组
 *
 * @Author: zzf
 *
 * @Return: mixed 查询返回值（结果集对象）
 */
if ( !function_exists( 'handleTimesByArray' ) )
{
    function handleTimesByArray ( $data, $item_name = ['create_time'], $rule = 'Y-m-d H:i:s' )
    {
        foreach ( $data as $index => $item )
        {

            foreach ($item_name as $index2 => $item2)
            {
                $data[ $index ][$item2] = date( $rule, $item[ $item2 ] );
            }

        }

        return $data;
    }
}

/**
 * @Purpose: 生成小程序码
 *
 * @Param: $staff_id    number  员工id
 * @Param: $from_id    number  来自谁的ID
 * @Param: $target_id    number  详情id，商品详情，动态详情等
 * @Param: $page    number  用户端首页tabbar页面类型 1=>名片；2=>商城；3=>动态；4=>官网；5=>房产；6=>活动；7=>预约；
 * @Param: $name    string  用户小程序码区分命名  card_qr = 名片码
 * @Param: $version    string  小程序码版本
 * @Param: $miniPath    string  小程序页面路径
 * @Param: $imagePath    string  本地图片存储路径
 *
 * @Author: zzf
 *
 * @Return: mixed 查询返回值（结果集对象）
 *
 * 已弃用
 */
if ( !function_exists( 'createMiniQr' ) )
{
    function createMiniQr ( $staff_id, $from_id, $name, $uniacid, $miniPath, $imagePath, $target_id = 0, $page = 1, $version = 'v2' )
    {
        global $_W;
        $imageName = "{$name}_{$staff_id}_{$from_id}_{$uniacid}_{$version}.png";

        $scene = "$staff_id-$staff_id-$target_id-$page";

        $accessToken = getAccessToken( $uniacid );

        if ( $accessToken === 0 )
        {
            return '';
        }

        if ( defined( 'IS_WE7' ) && IS_WE7 )
        {
            if ( defined( 'ATTACHMENT_ROOT' ) && ATTACHMENT_ROOT )
            {
                $imagePathRoot = ATTACHMENT_ROOT . '/' . $imagePath;
            }
            else
            {
                $imagePathRoot = $_SERVER[ 'DOCUMENT_ROOT' ] . '/public/upload/' . $imagePath;
            }
        }
        else
        {
            $imagePathRoot = $_SERVER[ 'DOCUMENT_ROOT' ] . '/public/upload/' . $imagePath;
        }
        $result = mkdirs_v2( $imagePathRoot );

        if ( $result === false )
        {
            return '';
        }

        $post_data = '{"scene":"' . $scene . '","page":"' . $miniPath . '"}';
        $url       = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=$accessToken";

//      $result = lbSingleCurlPost( $url, $post_data );
        $result = longbingCurl($url ,$post_data ,'POST');
        if ( strstr( $accessToken, 'errcode' ) )
        {
            return '';
        }

        $result = file_put_contents( $imagePathRoot . $imageName, $result );

        if ( !$result )
        {
            return '';
        }

        if ( defined( 'IS_WE7' ) && IS_WE7 )
        {
            if ( defined( 'ATTACHMENT_ROOT' ) && ATTACHMENT_ROOT )
            {
                $src = $_W[ 'siteroot' ] . $_W[ 'config' ][ 'upload' ][ 'attachdir' ] . '/' . $imagePath . '/' . $imageName;
            }
            else
            {
                $src = $_SERVER[ 'HTTP_HOST' ] . '/public/upload/' . $imagePath . '/' .$imageName;
            }
        }
        else
        {
            $src = $_SERVER[ 'HTTP_HOST' ] . '/public/upload/' . $imagePath .  '/' .$imageName;
        }

        return $src;
    }
}


if ( !function_exists( 'getMiniQr' ) )
{
    function getMiniQr ( $staff_id, $from_id, $name, $uniacid, $imagePath, $version = 'v2' )
    {
        global $_W;
        $imageName = "{$name}_{$staff_id}_{$from_id}_{$uniacid}_{$version}.png";

        if ( defined( 'IS_WE7' ) && IS_WE7 )
        {
            if ( defined( 'ATTACHMENT_ROOT' ) && ATTACHMENT_ROOT )
            {
                $src = $_W[ 'siteroot' ] . $_W[ 'config' ][ 'upload' ][ 'attachdir' ] . '/' . $imagePath . '/' . $imageName;
            }
            else
            {
                $src = $_SERVER[ 'HTTP_HOST' ] . '/public/upload/' . $imagePath . '/' .$imageName;
            }
        }
        else
        {
            $src = $_SERVER[ 'HTTP_HOST' ] . '/public/upload/' . $imagePath .  '/' .$imageName;
        }

        return $src;
    }
}

/**
 * @Purpose: 处理数字
 *
 * @Param: $staff_id    number  员工id
 *
 * @Author: zzf
 *
 * @Return: mixed 查询返回值（结果集对象）
 */
if ( !function_exists( 'formatNumberPrice' ) )
{
    function formatNumberPrice ( $data, $target = [ 'price' ], $un = 10000, $unit = '万' )
    {
        global $_W;

        foreach ( $data as $index => $item )
        {
            if ( is_array( $item ) )
            {
                $data[ $index ] = formatNumberPrice( $item, $target, $un );
            }
            else
            {
                if ( in_array( $index, $target ) && $item > $un )
                {
                    $data[ $index ] = bcdiv( $item, $un, 2 ) . $unit;
                }
            }
        }
        return $data;
    }
}

/**
 * @Purpose: 处理默认图片
 *
 * @Author: zzf
 *
 * @Return: mixed 查询返回值（结果集对象）
 */
if ( !function_exists( 'formatDefaultImage' ) )
{
    function formatDefaultImage ( $data, $target, $default, $defaultArr )
    {

        foreach ( $data as $index => $item )
        {
            if ( is_array( $item ) )
            {
                $data[ $index ] = formatDefaultImage( $item, $target, $default, $defaultArr );
            }
            else
            {
                if ($index == $target && $item == '' && isset($defaultArr[$default]))
                {
                    $data[$index] = $defaultArr[$default];
                }
            }
        }
        return $data;
    }
}

/**
 * @Purpose: 清除用户相关缓存
 *
 * @Author: zzf
 *
 * @Return: mixed 查询返回值（结果集对象）
 */
if ( !function_exists( 'clearUserCache' ) )
{
    function clearUserCache ( $user_id )
    {
        $key  = 'longbing_user_autograph_' . $uid;
        foreach ( $data as $index => $item )
        {
            if ( is_array( $item ) )
            {
                $data[ $index ] = formatDefaultImage( $item, $target, $default, $defaultArr );
            }
            else
            {
                if ($index == $target && $item == '' && isset($defaultArr[$default]))
                {
                    $data[$index] = $defaultArr[$default];
                }
            }
        }
        return $data;
    }
}

if ( !function_exists( 'mkdirs_v2' ) )
{
    function mkdirs_v2 ( $dir, $mode = 0777 )
    {

        if ( is_dir( $dir ) || @mkdir( $dir, $mode ) ) return TRUE;

        if ( !mkdirs_v2( dirname( $dir ), $mode ) ) return FALSE;

        return @mkdir( $dir, $mode );

    }
}


if ( !function_exists( 'getAccessToken' ) )
{
    function getAccessToken ( $uniacid )
    {
        $key = "longbing_card_access_token";

        $value = getCache( $key,$uniacid);

        if ( $value !== false )
        {
            return $value;
        }

        $modelConfig = new \app\card\model\Config();
        $config      = $modelConfig->getConfig( $uniacid );
        $key         = '';
        $secret      = '';

        if ( defined( 'IS_WE7' ) && IS_WE7 )
        {
            global $_W;
            $key    = $_W[ 'account' ][ 'key' ];
            $secret = $_W[ 'account' ][ 'secret' ];
        }

        if ( isset( $config[ 'appid' ] ) && $config[ 'appid' ] )
        {
            $key = $config[ 'appid' ];
        }

        if ( isset( $config[ 'app_secret' ] ) && $config[ 'app_secret' ] )
        {
            $secret = $config[ 'app_secret' ];
        }

        if ( !$key || !$secret )
        {
            echo json_encode( [ 'code' => 402, 'error' => 'need appid appsecret' ] );
            exit;
        }

        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$key&secret={$secret}";

        $accessToken = file_get_contents( $url );

        if ( strstr( $accessToken, 'errcode' ) )
        {
            return 0;
        }

        $accessToken = json_decode( $accessToken, true );
        $accessToken = $accessToken[ 'access_token' ];

        setCache( $key, $accessToken, 7000, $uniacid );

        return $accessToken;
    }
}

if ( !function_exists( 'lbCurlPost' ) )
{
    function lbCurlPost ( $url, $data )
    {
        //初使化init方法
        $ch = curl_init();

        //指定URL
        curl_setopt( $ch, CURLOPT_URL, $url );

        //设定请求后返回结果
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

        //声明使用POST方式来进行发送
        curl_setopt( $ch, CURLOPT_POST, 1 );

        //发送什么数据呢
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );


        //忽略证书
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );

        //忽略header头信息
        curl_setopt( $ch, CURLOPT_HEADER, 0 );

        //设置超时时间
        curl_setopt( $ch, CURLOPT_TIMEOUT, 10 );

        //发送请求
        $output = curl_exec( $ch );

        //关闭curl
        curl_close( $ch );

        //返回数据
        return $output;
    }
}

if ( !function_exists( 'lbGetDates' ) )
{
    function lbGetDates ( $time )
    {
        if ( $time >= 86400 * 30 )
        {
            $month = floor( $time / ( 86400 * 30 ) ) . '月后过期';
            return $month;
        }

        if ( $time >= 86400 )
        {
            $day = floor( $time / ( 86400 ) ) . '天后过期';
            return $day;
        }

        if ( $time >= 3600 )
        {
            $hour = floor( $time / ( 3600 ) ) . '时后过期';
            return $hour;
        }

        if ( $time >= 60 )
        {
            $min = floor( $time / ( 60 ) ) . '分后过期';
            return $min;
        }

        if ( $time >= 1 )
        {
            $sin = $time . '秒后过期';
            return $sin;
        }
        else
        {
            return '已过期';
        }
    }
}


if ( !function_exists( 'lbGetDatesNoMonth' ) )
{
    function lbGetDatesNoMonth ( $time )
    {
//        if ( $time >= 86400 * 30 )
//        {
//            $month = floor( $time / ( 86400 * 30 ) ) . '月后过期';
//            return $month;
//        }

        if ( $time >= 86400 )
        {
            $day = floor( $time / ( 86400 ) ) . '天后过期';
            return $day;
        }

        if ( $time >= 3600 )
        {
            $hour = floor( $time / ( 3600 ) ) . '时后过期';
            return $hour;
        }

        if ( $time >= 60 )
        {
            $min = floor( $time / ( 60 ) ) . '分后过期';
            return $min;
        }

        if ( $time >= 1 )
        {
            $sin = $time . '秒后过期';
            return $sin;
        }
        else
        {
            return '已过期';
        }
    }
}

if ( !function_exists( 'lbGetDatess' ) )
{
    function lbGetDatess ( $time )
    {
        $s_time = $time;

        if ( $time >= 86400 * 30 )
        {
            $month = floor( $time / ( 86400 * 30 ) );
            $time  -= 86400 * 30 * $month;
            $month .= '月';
        }
        else
        {
            $month = '';
        }
        if ( $time >= 86400 )
        {
            $day  = floor( $time / ( 86400 ) );
            $time -= 86400 * $day;
            $day  .= '天';

        }
        else
        {
            $day = '';
        }
        if ( $time >= 3600 )
        {
            $hour = floor( $time / ( 3600 ) );
            $time -= 3600 * $hour;
            $hour .= '时';

        }
        else
        {
            $hour = '';
        }
        if ( $time >= 60 )
        {
            $min  = floor( $time / ( 60 ) );
            $time -= 60 * $min;
            $min  .= '分';
        }
        else
        {
            $min = '';
        }

        if ( $time >= 1 )
        {
            $sin = $time . '秒';

        }elseif($s_time == $time&&$time<=0){

            return '已过期';

        }else{

            $sin = '';
        }
        return '还剩' . $month . $day . $hour . $min . $sin;

    }
}

if ( !function_exists( 'lbGetDatesss' ) )
{
    function lbGetDatesss ( $time )
    {
        $s_time = $time;

        if ( $time >= 86400 * 30 )
        {
            $month = floor( $time / ( 86400 * 30 ) );
            $time  -= 86400 * 30 * $month;
            $month .= '月';
        }
        else
        {
            $month = '';
        }
        if ( $time >= 86400 )
        {
            $day  = floor( $time / ( 86400 ) );
            $time -= 86400 * $day;
            $day  .= '天';

        }
        else
        {
            $day = '';
        }
        if ( $time >= 3600 )
        {
            $hour = floor( $time / ( 3600 ) );
            $time -= 3600 * $hour;
            $hour .= '时';

        }
        else
        {
            $hour = '';
        }
        if ( $time >= 60 )
        {
            $min  = floor( $time / ( 60 ) );
            $time -= 60 * $min;
            $min  .= '分';
        }
        else
        {
            $min = '';
        }

        if ( $time >= 1 )
        {
            $sin = $time . '秒';

        }elseif($s_time == $time&&$time<=0){

            return '已过期';

        }else{

            $sin = '';
        }
        return  $month . $day . $hour . $min . $sin;

    }
}


if ( !function_exists( 'lbGetfDate' ) )
{
    function lbGetfDate ( $time )
    {
        if ( $time >= 86400 * 30 )
        {
            $month = floor( $time / ( 86400 * 30 ) ) . '月前';
            return $month;
        }
        if ( $time >= 86400 * 7 )
        {
            $month = floor( $time / ( 86400 * 7 ) ) . '周前';
            return $month;
        }
        if ( $time >= 86400 ) {
            $day = floor($time / (86400)) . '天前';
            return $day;
        }else{
            return '今天';
        }
    }
}


//插入消息数据(异步)

function asyncAddMessage ( $data )
{
    //存储消息
    $message_model = new ImMessage();
    $result        = $message_model->createMessage( $data );
    //修改时间chat
    $chat_model    = new ImChat();
    $chat_model->updateChat(['id' => $data['chat_id']] ,[]);
    return $result;
}

//创建文件夹
function longbingMkdirs ( $path )
{
    if ( !is_dir( $path ) )
    {
        mkdirs( dirname( $path ) );
        mkdir( $path );
    }

    return is_dir( $path );
}

//复制文件
function longbingFileCopy ( $src, $des, $filter )
{
    $dir = opendir( $src );
    @mkdir( $des );
    while ( false !== ( $file = readdir( $dir ) ) )
    {
        if ( ( $file != '.' ) && ( $file != '..' ) )
        {
            if ( is_dir( $src . '/' . $file ) )
            {
                file_copy( $src . '/' . $file, $des . '/' . $file, $filter );
            }
            elseif ( !in_array( substr( $file, strrpos( $file, '.' ) + 1 ), $filter ) )
            {
                copy( $src . '/' . $file, $des . '/' . $file );
            }
        }
    }
    closedir( $dir );
}

//删除文件
function longbingRmdirs ( $path, $clean = false )
{
    if ( !is_dir( $path ) )
    {
        return false;
    }
    $files = glob( $path . '/*' );
    if ( $files )
    {
        foreach ( $files as $file )
        {
            is_dir( $file ) ? rmdirs( $file ) : @unlink( $file );
        }
    }

    return $clean ? true : @rmdir( $path );
}

function longbingStrexists ( $string, $find )
{
    return !( strpos( $string, $find ) === FALSE );
}


//微擎方法
function longbingTomedia ( $src, $local_path = false, $is_cahce = false )
{
    global $_W;
    $src = trim( $src );
    if ( empty( $src ) )
    {
        return '';
    }
    if ( $is_cahce )
    {
        $src .= "?v=" . time();
    }

    if ( longbingStrexists( $src, "c=utility&a=wxcode&do=image&attach=" ) )
    {
        return $src;
    }

    $t = strtolower( $src );
    if ( longbingStrexists( $t, 'https://mmbiz.qlogo.cn' ) || longbingStrexists( $t, 'http://mmbiz.qpic.cn' ) )
    {
        $url = url( 'utility/wxcode/image', array( 'attach' => $src ) );
        return $_W[ 'siteroot' ] . 'web' . ltrim( $url, '.' );
    }

    if ( substr( $src, 0, 2 ) == '//' )
    {
        return 'http:' . $src;
    }
    if ( ( substr( $src, 0, 7 ) == 'http://' ) || ( substr( $src, 0, 8 ) == 'https://' ) )
    {
        return $src;
    }

    if ( longbingStrexists( $src, 'addons/' ) )
    {
        return $_W[ 'siteroot' ] . substr( $src, strpos( $src, 'addons/' ) );
    }
    if ( longbingStrexists( $src, $_W[ 'siteroot' ] ) && !longbingStrexists( $src, '/addons/' ) )
    {
        $urls = parse_url( $src );
        $src  = $t = substr( $urls[ 'path' ], strpos( $urls[ 'path' ], 'images' ) );
    }
    if ( $local_path || empty( $_W[ 'setting' ][ 'remote' ][ 'type' ] ) && ( empty( $_W[ 'uniacid' ] ) || !empty( $_W[ 'uniacid' ] ) && empty( $_W[ 'setting' ][ 'remote' ][ $_W[ 'uniacid' ] ][ 'type' ] ) ) || file_exists( IA_ROOT . '/' . $_W[ 'config' ][ 'upload' ][ 'attachdir' ] . '/' . $src ) )
    {
        $src = $_W[ 'siteroot' ] . $_W[ 'config' ][ 'upload' ][ 'attachdir' ] . '/' . $src;
    }
    else
    {
        $src = $_W[ 'attachurl_remote' ] . $src;

    }
    return $src;
}


//获取文件地址
function longbingGetFilePath($path , $web_url,$uniacid = '7777' ,$type = null)
{
    $oss_config = longbingGetOssConfig($uniacid);
//    if(longbingIsWeiqin() && empty($oss_config)){
//        return longbingTomedia($path);
//    }
    $website_url = $web_url . '/attachment';
    if(!empty($oss_config) && !empty($oss_config['open_oss']) && !in_array($type, ['loacl']))
    {
        $website_url = $oss_config['default_url'];
    }
    return $website_url . '/' .$path;
}


//获取配置
function longbingGetOssConfig($uniacid = '7777' ,$is_update = false)
{
    $key = 'longbing_oos_config_';
    //判断是否更新数据
    if(!$is_update)
    {
        if(hasCache($key ,$uniacid))
        {
            return getCache($key ,$uniacid);
        }
    }
    //生成操作模型
    $oss_config_model = new OssConfig();
    //小程序授权模型
//    $card_Auth_model  = new Cardauth2ConfigModel();
//    //获取代理端配置端上传信息
//    $uplode_setting   = $card_Auth_model->where(['modular_id'=>$uniacid])->find();
//    //如果统一使用了上传配置
//    if(!empty($uplode_setting['upload_setting'])){
//        //获取数据
//        $config = $oss_config_model->getConfig(['id' => $uplode_setting['upload_setting']]);
//    }else{
        //获取数据
        $config = $oss_config_model->getConfig(['uniacid' => $uniacid]);
//    }

    $result = [];
    if(!empty($config))
    {
        $filter = [];
        switch($config['open_oss'])
        {
            case 0:
                $filter = ['uniacid','miniapp_name' ,'open_oss' ,'is_sync'];
                break;
            case 1:
                $filter = ['uniacid','miniapp_name' ,'open_oss' ,'is_sync' ,'aliyun_bucket' ,'aliyun_access_key_id' ,'aliyun_access_key_secret' ,'aliyun_base_dir' ,'aliyun_zidinyi_yuming' ,'aliyun_endpoint' ,'aliyun_rules'];
                break;
            case 2:
                $filter = ['uniacid','miniapp_name' ,'open_oss' ,'is_sync' ,'qiniu_accesskey' ,'qiniu_secretkey' ,'qiniu_bucket' ,'qiniu_yuming' ,'qiniu_rules'];
                break;
            case 3:
                $filter = ['uniacid','miniapp_name' ,'open_oss' ,'is_sync' ,'tenxunyun_appid' ,'tenxunyun_secretid' ,'tenxunyun_secretkey' ,'tenxunyun_bucket' ,'tenxunyun_region' ,'tenxunyun_yuming'];
                break;
            default:
                $filter = ['uniacid','miniapp_name' ,'open_oss' ,'is_sync'];
                break;
        }
        foreach($config as $k => $v)
        {
            if(in_array($k, $filter))
            {
                $result[$k] = $v;
               }
        }
        switch($result['open_oss'])
        {
            case 1:
                $result['default_url'] = $result['aliyun_zidinyi_yuming'];
                break;
            case 2:
                $result['default_url'] = $result['qiniu_yuming'];
                break;
            case 3:
                $result['default_url'] = $result['tenxunyun_yuming'];
                break;
            default:
                $result['default_url'] = $_SERVER['HTTP_HOST'];
                break;
        }

    }else{
        $oss_config_model->createConfig(['uniacid' => $uniacid ,'open_oss' => 0]);
        $result = longbingGetOssConfig($uniacid ,true);
    }
    if(!empty($result)) setCache($key, $result , 3600 ,$uniacid);
    return $result;
}


//微信接口返回数据处理
function LongbingGetWxApiReturnData($result)
{
        if (!is_array($result)) return $result;
    if(isset($result['page'])) $result['current_page'] = $result['page'];unset($result['page']);
    if(isset($result['page_count'])) $result['per_page'] = $result['page_count'];unset($result['page_count']);
    if(isset($result['total_page'])) $result['last_page'] = $result['total_page'];unset($result['total_page']);
    return $result;
}
function getStr($str){
    $vid = strstr($str, 'vid=');
    if($vid){
        $sdd = substr($str,strpos($str,"vid=")+4);
        $dd = explode('&quot',$sdd)[0];
    }else{
        $aa = basename($str);
        $bb = explode('.',$aa);
        $dd = $bb[0];
    }
    return $dd;
}
//获取html src里面的内容替换
function getimgs($str)
{
    $arr1 = [];
    $arr2 = [];
    $reg = "/src=\"(.+?)\"/";
    $matches = array();
    $str = htmlspecialchars_decode($str);
    preg_match_all($reg, $str, $matches);
    foreach ($matches[0] as $value) {
        if(!strstr($value, '/v.qq.com/')){
            continue;
        }
        $in = rtrim(getStr($value),'"');
        $sf = "src=\"$in\" lbType=vid";
        $arr1[] = $value;
        $arr2[] = $sf;
    }
    $ssf = str_replace($arr1, $arr2, $str);
    return htmlspecialchars($ssf);
}

function getimgsV2($str)
{
    $arr1 = [];
    $arr2 = [];
    $reg = "/src=\"(.+?)\"/";
    $matches = array();
    $str = htmlspecialchars_decode($str);
    preg_match_all($reg, $str, $matches);
    foreach ($matches[0] as $value) {
        if(!strstr($value, '/v.qq.com/')){
            continue;
        }
        $in = rtrim(getStr($value),'"');
        $sf = "src=\"$in\" lbType=\"vid\"";
        $arr1[] = $value;
        $arr2[] = $sf;
    }
    $ssf = str_replace($arr1, $arr2, $str);
    $ssf = str_replace('lbType=vid','lbType="vid"',$ssf);

    return ($ssf);
}

function datachange($data,$field = 'create_time'){

//    dump($data);exit;
    //  今天的时间戳
    $time = time();
    //  昨天的时间戳
    $Yesterday = $time - ( 24 * 60 * 60 );

    $today     = mktime( 0, 0, 0, date( "m", $time ), date( "d", $time ), date( "Y", $time ) );
    $Yesterday = mktime( 0, 0, 0, date( "m", $Yesterday ), date( "d", $Yesterday ), date( "Y", $Yesterday ) );



    $tmpTime = $data[ $field ];
    if ( $tmpTime > $today )
    {
        //                $data[ $index ][ 'radar_time' ] = '今天 ';
        $data[ 'radar_group' ] = '今天';
        $data[ 'radar_time' ]  = date( 'H:i', $data[ $field ] );
    }
    else if ( $tmpTime > $Yesterday )
    {
        //                $data[ $index ][ 'radar_time' ] = '昨天 ';
        $data[ 'radar_group' ] = '昨天';
        $data[ 'radar_time' ]  = date( 'H:i', $data[ $field ] );
    }
    else
    {
        $thisYear = date( 'Y' );
        $itemYear = date( 'Y', $data[ $field ] );
        if ( $thisYear == $itemYear )
        {
            $data[ 'radar_group' ] = date( 'm-d', $data[ $field ] );
            $data[ 'radar_time' ]  = date( ' H:i', $data[ $field ] );
        }
        else
        {
            $data[ 'radar_group' ] = date( 'Y-m-d', $data[ $field ] );
            $data[ 'radar_time' ]  = date( ' H:i', $data[ $field ] );
        }

    }
    return $data;
}

//服务通知
function longbingSendWxServiceNotice($count_id)
{
    //生成count操作模型
    $count_model = new LongbingCardCount();
    //获取count数据
    $count       = $count_model->getCount(['id' => $count_id]);
    //判断count是否存在
    if(empty($count) || !isset($count['uniacid'])) return false;
    //生成服务通知模型
//    var_dump($count);die;
    $service_notice_model = new LongbingServiceNotice($count['uniacid']);
    //发送
    return $service_notice_model->sendServiceNoticeToStaff($count_id);
}

//服务通知
function longbingSendMessageWxServiceNotice($message)
{
    //判断messange是否为空
    if(empty($message) || !isset($message['content']) || !isset($message['user_id']) || !isset($message['target_id']) || !isset($message['uniacid'])) return false;
    $message['to_user_id'] = $message['target_id'];
    //生成服务通知模型
    $service_notice_model = new LongbingServiceNotice($message['uniacid']);
    //发送
    return $service_notice_model->sendMessageServiceNotice($message);
}

function longbingSendWxServiceNoticeBase($data)
{
    $openid   = null;
    $form_id  = null;
    $nickName = null;
    $send_body = null;
    $uniacid = null;
    $time = time();
    $page_data = "longbing_card/staff/radar/radar";
    if(isset($data['open_id']) && !empty($data['open_id'])) $openid = $data['open_id'];
    if(isset($data['uniacid']) && !empty($data['uniacid'])) $uniacid = $data['uniacid'];
    if(isset($data['form_id']) && !empty($data['form_id'])) $form_id = $data['form_id'];
    if(isset($data['nickName']) && !empty($data['nickName'])) $nickName = $data['nickName'];
    if(isset($data['send_body']) && !empty($data['send_body'])) $send_body = $data['send_body'];
    if(isset($data['time']) && !empty($data['time'])) $time = $data['time'];
    if(isset($data['page_data']) && !empty($data['page_data'])) $page_data = $data['page_data'];

    //判断数据是否存在
    if(empty($openid) || empty($form_id) || empty($nickName) || empty($send_body)||empty($uniacid)) return;

    $service_notice_model = new LongbingServiceNotice($uniacid);
    return $service_notice_model->sendWxService($openid ,$form_id ,$nickName ,$send_body ,$time ,$page_data);
}






//获取用户信息
function longbingGetUser($user_id ,$uniacid ='7777' ,$is_update = false)
{

    //缓存数据key
    $key = 'longbing_card_user_' . $user_id;
    //数据
    $user = null;
    //判断缓存是否存在
    if(hasCache($key ,$uniacid) && empty($is_update)){
        //获取缓存数据
        $user = getCache($key ,$uniacid);
        //判断缓存数据是否为空,否则返回
        if(!empty($user)) return $user;
    }
    //获取用户数据
    $user_model = new LongbingUser();//生成查询类

    //获取数据
    $user = $user_model->getUser(['id' => $user_id ,'uniacid' => $uniacid]);

    //判断用户是否为空
    if(empty($user)) return null;
    $user['need_auth'] = 0;
    if(!isset($user['avatarUrl']) || empty($user['avatarUrl']) || in_array($user['avatarUrl'], ['https://retail.xiaochengxucms.com/defaultAvatar.png'])) $user['need_auth'] = 1;
    //获取用户授权手机号
    $user['phone'] = longbingGetUserAuthorizationPhone($user_id ,$uniacid);
    //设置缓存
    //setCache ( $key, $user, 3600, $uniacid);
    longbingSetUser($user_id ,$uniacid ,$user);
    //返回数据
    return $user;
}

//设置用户信息
function longbingSetUser($user_id ,$uniacid ,$data)
{
    //缓存数据key
    $key = 'longbing_card_user_' . $user_id;
    if(empty($data) || empty($uniacid) || empty($user_id)) return false;
    return setCache ( $key, $data, 3600, $uniacid);
}
//获取用户授权手机号信息
function longbingGetUserAuthorizationPhone($user_id ,$uniacid)
{
    $phone_model = new UserPhone();
    $phone       = $phone_model->getUserPhone($user_id ,$uniacid);
    if(isset($phone['phone'])) $phone = $phone['phone'];
    return $phone;
}

////获取用户信息
//function longbingGetUserInfo($user_id ,$uniacid ='7777' ,$is_update = false)
//{
//  //缓存数据key
//  $key = 'longbing_card_user_info_' . $user_id;
//  //数据
//  $user = null;
//  //判断缓存是否存在
//  if(hasCache($key ,$uniacid) && empty($is_update)){
//      //获取缓存数据
//      $user = getCache($key ,$uniacid);
//      //判断缓存数据是否为空,否则返回
//      if(!empty($user)) return $user;
//  }
//  //获取用户数据
//  $user_model = new LongbingUserInfo();//生成查询类
//  //获取数据
//  $user = $user_model->getUser(['fans_id' => $user_id ,'uniacid' => $uniacid]);
//  //判断用户是否为空
//  if(empty($user)) return null;
//  $user['share_img'] = "images/share_img/{$uniacid}/share-{$user_id}.png";
//  if(!longbingHasLocalFile($user['share_img'])) {
//      $user['share_img'] = null;
//  }else{
//      $user = transImagesOne($user, ['share_img']);
//  }
//  //设置缓存
////    setCache ( $key, $user, 600, $uniacid);
//  longbingSetUserInfo($user_id ,$uniacid ,$user);
//  //返回数据
//  return $user;
//}

function longbingGetUserInfo($user_id ,$uniacid ='7777' ,$is_update = false)
{
    //缓存数据key
    $key = 'longbing_card_user_info_' . $user_id;
    //数据
    $user = null;
    //判断缓存是否存在
    if(hasCache($key ,$uniacid) && empty($is_update)){
        //获取缓存数据
        $user = getCache($key ,$uniacid);
        //判断缓存数据是否为空,否则返回
        if(!empty($user)) return $user;
    }
    //获取用户数据
    $user_model = new LongbingUserInfo();//生成查询类
    //获取数据
    $user = $user_model->getStaff($user_id ,$uniacid);
    //判断用户是否为空
    if(empty($user)) return null;

    $user['share_img'] = "images/share_img/{$uniacid}/share-{$user_id}.png";
    if(!longbingHasLocalFile($user['share_img'])) {
        $user['share_img'] = null;
    }else{
        $user = transImagesOne($user, ['share_img']);
    }
    //设置缓存
    setCache ( $key, $user, 600, $uniacid);
    longbingSetUserInfo($user_id ,$uniacid ,$user);
    //返回数据
    return $user;
}

function longbingGetUserCard($user_id ,$uniacid ='7777' ,$is_update = false)
{

    $user = longbingGetUserInfo($user_id ,$uniacid);
    if(empty($user) || empty($user['is_staff'])) return FALSE;
    $user['company_info'] = [];
    $user['company_name'] = '';
    if(isset($user['company_id']) && !empty($user['company_id'])) {
        $company = longbingGetUserCompany($user['company_id'] ,$uniacid);
        $user['company_info'] = $company;
        if(!empty($user['company_info']) && isset($user['company_info']['name'])) $user['company_name'] = $user['company_info']['name'];
    }
    return $user;
}

function longbingGetUserCompany($company_id ,$uniacid = '7777' ,$is_update = false)
{
    //获取公司信息
    $company = null;
    $key = 'longbing_card_company_' . $company_id;
    if(hasCache($key ,$uniacid) && empty($is_update)){
        //获取缓存数据
        $company = getCache($key ,$uniacid);
        //判断缓存数据是否为空,否则返回
        if(!empty($company)) return $company;

    }
    $company_model = new CompanyModel();

    $company = $company_model->getCompany([['id' ,'=' , $company_id] ,['status' ,'>' ,-1]]);
    if(empty($company)) return null;
    setCache ( $key, $company, 600, $uniacid);
    return $company;
}
//设置缓存数据
function longbingSetUserInfo($user_id ,$uniacid ,$data)
{
    //缓存数据key
    $key = 'longbing_card_user_info_' . $user_id;
    if(empty($data) || empty($uniacid) || empty($user_id)) return false;
    return setCache ( $key, $data, 600, $uniacid);
}

//获取小程序配置信息
function longbingGetAppConfig($uniacid ,$is_update = false)
{
    //获取缓存信息
    $key = 'shequshop_school_config';

    $result = getCache($key ,$uniacid);

    if(empty($result)||$is_update==true) {

        $config_model = new \app\massage\model\Config();

        $dis = [

            'uniacid' => $uniacid
        ];

        $result = $config_model->dataInfo($dis);
    }
    //返回数据
    return $result;
}

//获取小程序底部菜单信息
function longbingGetAppTabbar($uniacid ,$is_update = false)
{
    $key = 'longbing_app_tabbar_' . $uniacid;
    if(hasCache($key ,$uniacid) && empty($is_update))
    {
        $result = getCache($key ,$uniacid);
        if(!empty($result)) return $result;
    }
    //获取数据
    $app_tabbar_model = new AppTabbar();
    $result = $app_tabbar_model->getTabbar(['uniacid' => $uniacid]);
    //设置缓存
    if(!empty($result))
    {
        setCache($key, $result ,600 ,$uniacid);
    }else{
        $tabbar_model = new AppTabbar();
        $data = array(
                      'uniacid' => $uniacid,
                      'menu2_is_hide'         => 0,
                      'menu3_is_hide'         => 0,
                      'menu4_is_hide'         => 0,
                      'menu_activity_is_show' => 0,
                      'menu_house_is_show'    => 0,
                      'menu_appoint_is_hide'  => 0
                    );
        $tabbar_model->createTabbar($data);
        $result = longbingGetAppTabbar($uniacid ,true);
    }
    //返回数据
    return $result;
}

if ( !function_exists( 'longbingArticleToXml' ) ) {
    function longbingArticleToXml ($data)
    {
        include_once __DIR__."/../extend/html2wxml/class.ToWXML.php";

        $content = htmlspecialchars_decode($data);


        if ( $content != strip_tags($content) ) {
        } else {
            $content = '<p><span style="color: rgb(0, 0, 0);">' . $content . '</span></p>';
        }

        $towxml = new ToWXML2();
        $json   = $towxml->towxml($content, array(
            'type'                => 'html',
            'highlight'           => true,
            'linenums'            => true,
            'imghost'             => null,
            'encode'              => false,
            'highlight_languages' => array( 'html', 'js', 'php', 'css' )
        ));
        return $json;
    }
}

//获取accessToken
function longbingSingleGetAccessToken($appid ,$appsecret ,$uniacid ,$is_update = false)
{

    $setting = new WxSetting($uniacid);

    $token   = $setting->lbSingleGetAccessToken();

    return $token;

}

//获取accesstoken通过uniacid
function longbingSingleGetAccessTokenByUniacid($uniacid ,$is_update = false)
{
    $config = longbingGetAppConfig($uniacid ,$is_update);
    if(!isset($config['appid']) || empty($config['appid']) || !isset($config['app_secret']) || empty($config['app_secret'])) return false;
    $access_token  = longbingSingleGetAccessToken($config['appid'] ,$config['app_secret'] ,$uniacid ,$is_update);
    if(empty($access_token)) $access_token = false;
    return $access_token;
}

//生成curl方法
function longbingCurl($url,$post,$method = 'GET')
{
    $curl_model = new LongbingCurl();
    return $curl_model->curlPublic($url,$post,$method);
}

//获取usersession key
function longbingGetUserSk($user_id ,$uniacid  ,$is_update = false)
{
    //生成key
    $key = 'longbing_user_sk_' . $user_id;
    //判断缓存是否存在
    $sk = null;
    if(hasCache($key ,$uniacid) && !empty($is_update))
    {
        $sk = getCache($key ,$uniacid);
        if(empty($result)) return $sk;
    }
    $user_sk_model = new UserSk();
    //获取数据
    $result = $user_sk_model->getSk(['user_id' => $user_id ,'uniacid' => $uniacid ,'status' => 1]);
    //判断数据是否存在
    if(isset($result['sk']) && !empty($result['sk']))
    {
        setCache($key, $result['sk'] ,3600 ,$uniacid);
        $sk = $result['sk'];
    }
    return $sk;
}

/**
 * 友好的时间显示
 *
 * @param int    $sTime 待显示的时间
 * @param string $type  类型. normal | mohu | full | ymd | other
 * @param string $alt   已失效
 * @return string
 */
if (!function_exists('lb_friendly_date')) {
    function lb_friendly_date($sTime,$type = 'mohu',$alt = 'false') {
        if (!$sTime)
            return '';
        //sTime=源时间，cTime=当前时间，dTime=时间差
        $cTime      =   time();
        $dTime      =   $cTime - $sTime;

        //$dDay       =   intval(date("z",$    cTime)) - intval(date("z",$sTime));

        $dDay     =   intval($dTime/3600/24);

        $dYear      =   intval(date("Y",$cTime)) - intval(date("Y",$sTime));
        //normal：n秒前，n分钟前，n小时前，日期
        if($type=='normal'){
            if( $dTime < 60 ){
                if($dTime < 10){
                    return '刚刚';    //by yangjs
                }else{
                    return intval(floor($dTime / 10) * 10).'秒前';
                }
            } elseif( $dTime < 3600 ){
                return intval($dTime/60).'分钟前';
                //今天的数据.年份相同.日期相同.
            } elseif( $dYear==0 && $dDay == 0  ){
                //return intval($dTime/3600).L('_HOURS_AGO_');
                return '今天'.date('H:i',$sTime);
            } elseif( $dDay > 0 && $dDay<=3 ){
                return intval($dDay).'天前';
            } elseif($dYear==0){
                return date("m月d日 H:i",$sTime);
            } else{
                return date("m-d H:i",$sTime);
            }
        } elseif($type=='mohu'){
            if( $dTime < 60 ){
                return $dTime.'秒前';
            } elseif( $dTime < 3600 ){
                return intval($dTime/60).'分钟前';
            } elseif( $dTime >= 3600 && $dDay == 0  ){
                return intval($dTime/3600).'小时前';
            } elseif( $dDay > 0 && $dDay<=7 ){
                return intval($dDay).'天前';
            } elseif( $dDay > 7 &&  $dDay <= 30 ){
                return intval($dDay/7) . '周前';
            } elseif( $dDay > 30 ){
                return intval($dDay/30) .'个月前';
            }
            //full: Y-m-d , H:i:s
        } elseif($type=='full'){
            return date("m-d , H:i",$sTime);
        } elseif($type=='ymd'){
            return date("Y-m-d",$sTime);
        } else{
            if( $dTime < 60 ){
                return $dTime.'秒前';
            } elseif( $dTime < 3600 ){
                return intval($dTime/60).'分钟前';
            } elseif( $dTime >= 3600 && $dDay == 0  ){
                return intval($dTime/3600).'小时前';
            } elseif($dYear==0){
                return date("m-d H:i",$sTime);
            } else{
                return date("m-d H:i",$sTime);
            }
        }
    }
}

function longbingGetAccessToken($uniacid , $is_update = false)
{


    $setting = new WxSetting($uniacid);

    $token   = $setting->lbSingleGetAccessToken();

    return $token;

}
//生成微信小程序二维码
function longbingCreateWxCode($uniacid ,$data ,$page = '' ,$type = 3)
{
    $code_id = md5($uniacid . json_encode($data ,true));
    //上传路径
    $path = 'image/' . $uniacid . '/' . 'wxcode';

    if(!mkdirs_v2(FILE_UPLOAD_PATH . $path)) return false;
    //设置文件权限
//  longbingchmodr(FILE_UPLOAD_PATH);
    //封装数据
    if(!isset($data['data'])) $data['data'] = $data;
    $code_data = array(
        'uniacid' => $uniacid,
        'data'    => json_encode($data['data'] ,true)
    );
    //写入数据
    $wechat_code_model = new LongbingCardWechatCode();

    //判断数据是否存在
    $code = longbingGetWxCode($code_id ,$uniacid);
    //创建
    if(empty($code))
    {
        $code_data['id'] = $code_id;
        $result = $wechat_code_model->createCode($code_data);
    }else{
        $result = $wechat_code_model->updateCode(['id' => $code_id] ,$code_data);
    }


    //刷新缓存
    longbingGetWxCode($code_id ,$uniacid ,true);
    if(empty($result)) return false;
    $path = null;
    $with = 430;
    $auto_color = true;
    $line_color = '{"r":0,"g":0,"b":0}';
    $is_hyaline = false;
    //获取数据
    if(isset($data['path'])) $path = $data['path'];
    if(isset($data['with'])) $with = $data['with'];
    if(isset($data['auto_color'])) $auto_color = $data['auto_color'];
    if(isset($data['line_color'])) $line_color = $data['line_color'];
    if(isset($data['is_hyaline'])) $is_hyaline = $data['is_hyaline'];
    //生成获取微信code接口
    $wechat_code_model = new WeChatCode($uniacid);
    switch($type)
    {
        case 1:
            $result = $wechat_code_model->getQRCode($path ,$width = 430);
            break;
        case 2:
            $result = $wechat_code_model->getWxCode($path ,$width = 430 ,$auto_color = true ,$line_color = '{"r":0,"g":0,"b":0}' ,$is_hyaline    = false);
            break;
        default:
            $result = $wechat_code_model->getUnlimitedCode($code_id ,$page ,$width = 430 ,$auto_color = false ,$line_color = '{"r":0,"g":0,"b":0}' ,$is_hyaline    = true);
            break;
    }
    //判断是否生成失败
    $data = json_decode($result ,true);
    if(isset($data['errcode']) || isset($data['errmsg'])) return false;
    //存储文件
    $path = 'image/' . $uniacid . '/' . 'wxcode';
    $file_name = $code_id . '.jpeg';
    $path = $path . '/' . $file_name;
    if(longbingHasLocalFile($path)) unlink(FILE_UPLOAD_PATH . $path);
    $data = file_put_contents(FILE_UPLOAD_PATH . $path ,$result);
    //设置文件权限


    //上传到云端
//  $file = new UploadedFile($path ,$file_name);
//  $file_upload_model = new Upload($uniacid);
//  $result = $file_upload_model->upload('picture' ,$file);
    //删除文件
//  unlink($path);
    if(empty($data)) return false;
    //数据转换
    return ['qr_path' => $path ,'path' => $path];

}
//获取微信小程序二维码数据
function longbingGetWxCode($code_id ,$uniacid , $is_update = false)
{
    //生成key
    $key = 'longbing_wechat_code_' . $code_id;
    $data = null;
    //获取缓存数据
//    if(hasCache($key ,$uniacid) && empty($is_update))
//    {
//        $data = getCache($key ,$uniacid);
//        if(!empty($data)) return $data;
//    }
    //从数据库中获取数据
    $wechat_code_model = new LongbingCardWechatCode();
    $data = $wechat_code_model->getCode(['id' => $code_id ,'uniacid' => $uniacid]);
    if(!empty($data)) {
        if(isset($data['data'])) $data['data'] = json_decode($data['data'],true);

    }
    return $data;
}
//获取企业的token
function qyGetAccessToken ( $uniacid )
{
    $key = "longbing_card_access_token_qy";

    $value = getCache( $key );

    if ( $value !== false )
    {
        return $value;
    }

    $modelConfig = new \app\card\model\Config();
    $config      = $modelConfig->getConfig( $uniacid );
    $key         = '';
    $secret      = '';
    if ( isset( $config[ 'corpid' ] ) && $config[ 'corpid' ] )
    {
        $key = $config[ 'corpid' ];
    }

    if ( isset( $config[ 'corpsecret' ] ) && $config[ 'corpsecret' ] )
    {
        $secret = $config[ 'corpsecret' ];
    }

    if ( !$key || !$secret )
    {
        echo json_encode( [ 'code' => 402, 'error' => 'need corpid corpsecret' ] );
        exit;
    }

    $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$key&corpsecret=$secret";

    $accessToken = file_get_contents( $url );
    $accessToken = json_decode( $accessToken, true );
    if($accessToken['errcode'] != 0){
        echo json_encode( [ 'code' => 402, 'error' => '获取token失败' ] );
        exit;
    }
    $accessToken = $accessToken[ 'access_token' ];
    setCache( $key, $accessToken, 7200, $uniacid );
    return $accessToken;
}


/**
 * @Purpose: 检查能不能使用获客文章
 *
 * @Author: zzf
 *
 * @Return: mixed 查询返回值（结果集对象）
 */
if (!function_exists('lbSingleCheckArticleV2')) {
    function lbSingleCheckArticleV2($uniacid, $user_id)
    {
        $userInfo = Db::name('longbing_card_user_info')->where(['fans_id' => $user_id, 'is_staff' => 1])->find();
        if (!$userInfo) {
            return 0;
        }

        $cacheKey = 'article_' . $userInfo['id'];

//        delCache($cacheKey, $uniacid);
        $cache = getCache($cacheKey, $uniacid);
        if ($cache === 1) {
            return 1;
        }


//
//        if (!defined('LONGBING_AUTH_ARTICLE_SINGLE')) {
//            return 2;
//        }
//
//        if ($userInfo['signature'] > LONGBING_AUTH_ARTICLE_SINGLE) {
//            return 8;
//        }

        if ($userInfo['autograph'] == 0 || $userInfo['signature'] == 0) {
            return 7;
        }

        $time = time();

        if ($userInfo['autograph'] - 123456789 < $time) {
            return 9;
        }

        setCache($cacheKey, 1, $userInfo['autograph'] - 123456789 - $time, $uniacid);
        return 1;
    }
}


//获取插件的权限
if (!function_exists('longbingGetPluginAuth')) {
    function longbingGetPluginAuth($uniacid, $user_id = null, $auth_info_pass = false): array
    {
        $auth_info = false;
        do {
            if ($auth_info_pass) {
                $auth_info = $auth_info_pass;
                break;
            }

            $cardauth2_config_exist = Db::query('show tables like "%longbing_cardauth2_config%"');
            if (!empty($cardauth2_config_exist)) {
                $auth_info = Db::name('longbing_cardauth2_config')
                    ->where([['modular_id', '=', $uniacid]])
                    ->find();
                break;
            }
        } while (false);

        $data = [];

        /**
         * @var int $has_plugin_send 短信群发插件 0-没有， 1-有
         *      验权条件：
         *      1. ims_longbing_cardauth2_config表不存在， 或者 ims_longbing_cardauth2_config.send_switch的值等于1
         */

        $permission_send        = new \app\sendmsg\info\PermissionSendmsg($uniacid);

        $data['checkSend']      = $permission_send->pAuth();

        $data['plugin']['send'] = $data['checkSend']==true?1:0;

        /**
         * @var int $has_plugin_appoint 预约插件 0-没有， 1-有
         *      验权条件：
         *      1. 系统中存在LONGBING_AUTH_APPOINT_SINGLE， 且等于1
         *      2. ims_longbing_cardauth2_config表不存在， 或者 ims_longbing_cardauth2_config.appoint的值等于1
         *      3. ims_lb_appoint_record_check这张表存在
         */

        $permission_appoint        = new \app\appoint\info\PermissionAppoint($uniacid);

        $data['checkAppoint']      = $permission_appoint->pAuth();

        $data['plugin']['appoint'] = $data['checkAppoint']==true?1:0;

        /**
         * @var int $has_plugin_payqr 扫码支付插件  0-没有， 1-有
         *      验权条件：
         *      1. 系统中存在 LONGBING_AUTH_PAYQR_SINGLE， 且等于1
         *      2. ims_longbing_cardauth2_config表不存在， 或者 ims_longbing_cardauth2_config.payqr的值等于1
         *      3. ims_lb_pay_qr_config 存在
         */

        $permission_payqr        = new \app\payqr\info\PermissionPayqr($uniacid);

        $data['checkPayQr']      = $permission_payqr->pAuth();

        $data['plugin']['payqr'] = $data['checkPayQr']==true?1:0;

        /**
         * @var int $has_plugin_article 获客文章插件 0-没有， 1-有
         *      验权条件：
         *      1. 系统中定义 LONGBING_AUTH_ARTICLE_SINGLE 常量， 并且值大于0；
         *      2. 不存在ims_longbing_cardauth2_config这样表，或者 ims_longbing_cardauth2_config.article的值等于1
         *      3. 存在ims_lb_marketing_record这张表
         *      4. ims_longbing_card_config.autograph - 80666， 这个值大于等于 ims_longbing_card_config.signature
                   && ims_longbing_cardauth2_article.number 这个值大于0
         */

        $permission_article        = new \app\article\info\PermissionArticle($uniacid);

        $data['checkArticle']      = $permission_article->pAuth();

        $data['plugin']['article'] = $data['checkArticle']==true?1:0;

        /**
         * @var int $has_plugin_activity 活动报名插件  0-没有， 1-有
         *      验权条件:
         *          1. 系统中有定义LONGBING_AUTH_ACTIVITY_SINGLE 且 值大于0;
         *          2. ims_longbing_cardauth2_config表不存在，
         *             或者 (ims_longbing_cardauth2_config.activity_switch值不存在，
         *                  或者ims_longbing_cardauth2_config.activity_switch的值等于1，
         *                 );
         *         3. longbing_cardauth2_activity.sum(count) < LONGBING_AUTH_ACTIVITY_SINGLE
         *         4. longbing_cardauth2_activity.sign > time() && longbing_cardauth2_activity.count > 0;
         *
         */

        $permission_atv             = new \app\activity\info\PermissionActivity($uniacid);

        $data['checkActivity']      = $permission_atv->pAuth();

        $data['plugin']['activity'] = $data['checkActivity']==true?1:0;

        /**
         * @var int $has_plugin_house 房产插件  0-没有， 1-有
         *     验权条件:
         *     1. 系统中有定义 LONGBING_AUTH_HOUSE 且 值大于0；
         *     2. ims_longbing_cardauth2_config表不存在，
                  或者 ims_longbing_cardauth2_config.house_switch 的值等于1，
         *     3. longbing_cardauth2_house.count > 0,
         *     4. longbing_cardauth2_house.sign>time()  && longbing_cardauth2_house.sum(count) < LONGBING_AUTH_HOUSE

         */

        $permission_house        = new \app\house\info\PermissionHouse($uniacid);

        $data['checkHouse']      = $permission_house->pAuth();

        $data['plugin']['house'] = $data['checkHouse']==true?1:0;


        /**
         * @var int $has_plugin_poster 获客海报  0-没有， 1-有
         *      验权条件:
         *      所有小程序都可以使用
         */
        $has_plugin_poster = 1;

        $data['plugin']['poster'] = $has_plugin_poster;

        $data['checkPoster'] = true;

        /**
         * @var int $has_plugin_boss 公司部门  0-没有， 1-有
         *     验权条件:
         *     1. 系统中有定义 LONGBING_AUTH_BOSS_SINGLE 且 值大于0；
         *     2. ims_longbing_cardauth2_config表不存在，
                 或者 ims_longbing_cardauth2_config.boss 的值 > 已开通的boss值，
         *     3. longbing_cardauth2_boss.count > 0,
         *     4. longbing_cardauth2_boss.sign>time()  && longbing_cardauth2_boss.sum(count) < LONGBING_AUTH_HOUSE
         */

        $permission_boss = new \app\boss\info\PermissionBoss($uniacid);

        $data[ 'checkBoss' ] = $permission_boss->pAuth();

        $data['plugin']['boss'] = $data[ 'checkBoss' ]==true?1:0;



//      $adminMenus  = config('app.adminMenus');
        $myModelList =  \config('app.AdminModelList');

        $myModelList = $myModelList['saas_auth_admin_model_list'];

        $adminMenus = [];

        foreach($myModelList as $key=>$value ) {

            $adminMenus[] = $key;
        }

        /**
         * @var array $web_manage_meta_config 后台导航列配置
         */
        $web_manage_meta_config = [
            'survey'       => in_array('survey', $adminMenus) ? 1 : 0,                                   //概况
            'card'         => in_array('card', $adminMenus) ? 1 : 0,                             //名片
            'shop'         => (!$auth_info || $auth_info['shop_switch']) && in_array('shop', $adminMenus) ? 1:  0,       //商城
            'Malls'        => (!$auth_info || $auth_info['shop_switch']) && in_array('shop', $adminMenus) ? 1:  0,       //商城(兼容老版本)
            'dynamic'      => (!$auth_info || $auth_info['timeline_switch'])  && in_array('dynamic', $adminMenus)? 1 : 0, //动态
            'website'      => (!$auth_info || $auth_info['website_switch']) && in_array('Website', $adminMenus) ? 1 : 0, //官网
            'customer'     =>  in_array('customer', $adminMenus) ? 1: 0,                                 //客户
            'company'      =>  in_array('company', $adminMenus) ? 1: 0,                                  //公司
            'system'       =>  in_array('admin', $adminMenus) ? 1: 0,                                   //系统
            'renovation'   => in_array('renovation', $adminMenus) ? 1: 0,                               //装修
            'diy'          => in_array('diy', $adminMenus) ? 1: 0,                                      //Diy
            'copyright_id' => $auth_info['copyright_id'] ?? 0,
            'appstore' => in_array('app', $adminMenus) ? [ //应用
                'payqr' => $has_plugin_payqr,              //扫码支付
                'poster' => $has_plugin_poster,            //海报
                'send' => $has_plugin_send,                //群发
                'appiont' => $has_plugin_appoint,          //活动
                'house' => $has_plugin_house,              //房产
                'activity' => $has_plugin_activity,        //活动
                'article' => $has_plugin_article,          //文章
            ] : []
        ];

        $data['web_manage_meta_config'] = $web_manage_meta_config;

        //$data['card_number'] = isset($auth_info['number']) ? $auth_info['number'] : LONGBING_AUTH_CARD;
        //$data['boss_num'] = isset($auth_info['boos']) ? $auth_info['boos'] : LONGBING_AUTH_CARD;
        //新的名片数量获取方式
        $permissionCard = new \app\card\info\PermissionCard($uniacid) ;
        $authCardNumber = $permissionCard->getAuthNumber() ;

        $data['boss_num'] =  isset($auth_info['boos']) ? $auth_info['boos'] : $authCardNumber ;
        $data['card_number']  =  $authCardNumber ;


        return $data;
    }
}

/**
 * 获取应用模块列表
 */


//获取connection数据
function longbingGetCollectionById($client_id ,$is_update = false)
{
    $uniacid = 'longbing';
    //获取缓存数据
    $key = 'longbing_collection_id_' . $client_id;
    if(hasCache($key,$uniacid) && empty($is_update))
    {
        $result = getCache($key ,$uniacid);
        if(empty($result)) return $result;
    }
    //获取数据库数据
    $collection_model = new Collection();
    $result = $collection_model->getCollection(['id' => $client_id]);
    if(!empty($result)) setCache($key, $result ,300 ,$uniacid);
    return $result;
}
//获取connection数据
function longbingGetCollection($user_id ,$staff_id ,$uniacid ,$is_update = false)
{
    $key = 'longbing_collection_' . $user_id. '_' .$staff_id;
    if(hasCache($key,$uniacid) && empty($is_update))
    {
        $result = getCache($key ,$uniacid);
        if(empty($result)) return $result;
    }
    //获取数据库数据
    $collection_model = new Collection();
    $result = $collection_model->getCollection(['uid' => $user_id ,'to_uid' => $staff_id ,'uniacid' => $uniacid]);
    if(!empty($result))
    {
        setCache($key, $result ,300 ,$uniacid);
    }else{
        //创建
        $collection_model = new Collection();
        $collection_model->createCollection(['uid' => $user_id ,'to_uid' => $staff_id ,'uniacid' => $uniacid]);
        $result = longbingGetCollection($user_id ,$staff_id ,$uniacid);
    }
    return $result;
    }

//更新collection数据
function longbingUpdateCollection($collection_id ,$rate)
{
    $collection_model = new Collection();
    return $collection_model->updateCollection(['id' => $collection_id ] ,['rate' => $rate ,'update_rate_time' => time()]);
}

//获取rate更新信息
function longbingGetRate($user_id ,$staff_id ,$uniacid ,$is_update = false)
{
    $key = 'longbing_rate_update_' . $user_id. '_' .$staff_id;
    if(hasCache($key,$uniacid) && empty($is_update))
    {
        $result = getCache($key ,$uniacid);
        if(empty($result)) return $result;
    }
    //获取数据库数据
    $rate_model = new LongbingCardRate();
    $result = $rate_model->getRate(['user_id' => $user_id ,'staff_id' => $staff_id ,'uniacid' => $uniacid]);
    if(empty($result))
    {
        $rate_model = new LongbingCardRate();
        $rate_model->createRate(['user_id' => $user_id ,'staff_id' => $staff_id ,'uniacid' => $uniacid]);
        $result = longbingGetRate($user_id ,$staff_id ,$uniacid);
    }else{
        setCache($key, $result ,60 ,$uniacid);
    }
    return $result;
}

/*
 * 更新Rate信息
 * @creator yangqi
 */
function longbingUpdateRate($rate_id ,$rate)
{
    $rate_model = new LongbingCardRate();
    $result = $rate_model->updateRate(['id' => $rate_id] ,['rate' => $rate]);
    return $result;
}
/*
 * 更新客户成交率
 * @creator yangqi
 */

function updateCustomerRate($page = 1 ,$page_count = 200)
{
    //获取客户数据
    $collections = listCollections($page ,$page_count);
//  var_dump($collections['total']);die;
//  var_dump($page . '--------------------------------------------------' .$collections['total_page']);
    //判断当前页数是否小于总页数
    if($page < $collections['total_page'])
    {
        //递归查询
        $page += 1;
        $push_data = array(
            'action'     => 'updateCustomerRate',
            'event'      => 'updateCustomerRate',
            'page'       => $page,
            'page_count' =>$page_count
        );
        publisher(json_encode($push_data ,true));
    }
    //查询更新数据
    foreach($collections['data'] as $collection)
    {
        $push_data = array(
            'action' => 'updatecollectionRate',
            'event' => 'updatecollectionRate',
            'client_id' => $collection['id']
        );
//      var_dump($collection['id']);
        publisher(json_encode($push_data ,true) ,30000);
    }
    return $collections;
}

//获取客户列表
function listCollections($page ,$page_count)
{
    //设置分页默认参数
    $page_config = array(
        'page' => 1,
        'page_count' => 200
    );
    //获取分页参数
    if(!empty($page) && $page > 0) $page_config['page'] = $page;
    if(!empty($page_count) && $page_count > 0) $page_config['page_count'] = $page_count;
//  var_dump($page_config);
    //获取数据
    $collection_model     = new Collection();
    //获取总数
    $page_config['total'] = $collection_model->getCollectionJoinRateCount();
    //获取数据
    $collections          = $collection_model->listCollectionJoinRate($page_config);
    //生成总页数
    $page_config['total_page'] = (int)($page_config['total'] / $page_config['page_count']);
    if(($page_config['total'] % $page_config['page_count']) > 0) $page_config['total_page'] = $page_config['total_page'] + 1;
    //返回客户数据
    $page_config['data'] = $collections;
    $result = $page_config;
    return $result;
}

//更新单个客户列表rate
function updatecollectionRate($client_id)
{
//  return ;
    //获取collection
    $collection = longbingGetCollectionById($client_id);
    if(empty($collection) || ($collection['update_rate_time'] + 12*3600) > time()) return;
    //获取信息数据
    $user_id  = $collection['uid'];
    $staff_id = $collection['to_uid'];
    $uniacid  = $collection['uniacid'];
    $rate     = longbingGetRate($user_id ,$staff_id ,$uniacid);
    if(isset($collection['rate']) && in_array($collection['rate'], [100 ,'100'])){
        longbingUpdateRate($rate['id'] ,100);
        longbingUpdateCollection($collection['id'] ,100);
        return;
    }
    //获取rate分数
    $count = countRate($client_id);
    //更新数据
    longbingUpdateCollection($collection['id'] ,$count);

    longbingUpdateRate($rate['id'] ,$count);
    return $rate;
}

//获取最新的rate
function countRate($client_id)
{
    //获取client(uid ,to_uid ,uniacid)
    $collection = longbingGetCollectionById($client_id);
    if(empty($collection)) return 0;
    $user_id  = $collection['uid'];
    $staff_id = $collection['to_uid'];
    $uniacid  = $collection['uniacid'];
    //检查mark
    $mark_model = new LongbingCardUserMark();
    $mark_count = $mark_model->getMarkCount(['user_id' => $user_id ,'staff_id' => $staff_id ,'uniacid' => $uniacid ,'mark' => 2 ,'status' => 1]);
    if(!empty($mark_count)) return 100;
    //获取count
    $staff_count = 5;
    $client_count = 0;

    //mark
    $info = longbingGetCount('longbing_card_user_mark' ,['user_id' => $user_id ,'staff_id' => $staff_id ,'uniacid' => $uniacid]);
    if(!empty($info)) $staff_count += 5;
    //聊天
    $chat_model = new ImChat();
    $info  = $chat_model->getChat($user_id ,$staff_id ,$uniacid);
    if(isset($info['chat_id']))
    {
        $info = longbingGetCount('longbing_card_message' ,['chat_id' => $info['chat_id']]);
        if(!empty($info)) $client_count += 4;
        if($info > 15) $info = 15;
        $staff_count += $info;
    }
    //打标签
    $info = longbingGetCount('longbing_card_user_label' ,['user_id' => $user_id, 'staff_id' => $staff_id]);
    if($info >10) $info = 10;
    $staff_count += $info * 2;
    //用户留下电话
    $info = longbingGetCount('longbing_card_user_phone' ,['user_id' => $user_id, 'to_uid' => $staff_id]);
    if(!empty($info))  $client_count += 6;
    //打电话
    $info = longbingGetCount('longbing_card_count' , ['user_id' => $user_id, 'to_uid' => $staff_id, 'sign' => 'copy', 'type' => 2]);
    if(!empty($info))  $client_count += 4;

    //存电话
    $info = longbingGetCount('longbing_card_count' , ['user_id' => $user_id, 'to_uid' => $staff_id, 'sign' => 'copy', 'type' => 1]);
    if(!empty($info))  $client_count += 4;

    //复制微信
    $info = longbingGetCount('longbing_card_count' , ['user_id' => $user_id, 'to_uid' => $staff_id, 'sign' => 'copy', 'type' => 4]);
    if(!empty($info))  $client_count += 4;

    //语音点赞
    $info = longbingGetCount('longbing_card_count' , ['user_id' => $user_id, 'to_uid' => $staff_id, 'sign' => 'praise', 'type' => 1]);
    if(!empty($info))  $client_count += 1;
    //靠谱
    $info = longbingGetCount('longbing_card_count' , ['user_id' => $user_id, 'to_uid' => $staff_id, 'sign' => 'praise', 'type' => 3]);
    if(!empty($info))  $client_count += 1;
    //浏览名片
    $client_count += 2;
    //浏览商城列表
    $info = longbingGetCount('longbing_card_count' , ['user_id' => $user_id, 'to_uid' => $staff_id, 'sign' => 'view', 'type' => 1]);
    if(!empty($info))  $client_count += 2;
    //浏览商城详情
    $info = longbingGetCount('longbing_card_count' , ['user_id' => $user_id, 'to_uid' => $staff_id, 'sign' => 'view', 'type' => 2]);
    if(!empty($info))  $client_count += 2;
    //浏览动态
    $info = longbingGetCount('longbing_card_count' , ['user_id' => $user_id, 'to_uid' => $staff_id, 'sign' => 'view', 'type' => 3]);
    if(!empty($info))  $client_count += 2;
    //浏览官网
    $info = longbingGetCount('longbing_card_count' , ['user_id' => $user_id, 'to_uid' => $staff_id, 'sign' => 'view', 'type' => 6]);
    if(!empty($info))  $client_count += 2;
    //授权基本信息
    $info = longbingGetCount('longbing_card_user' , ['id' => $user_id]);
    if(!empty($info) && !empty($info['avatarUrl']))  $client_count += 2;
    //分享
    $info = longbingGetCount('longbing_card_forward' , ['user_id' => $user_id, 'staff_id' => $staff_id ,'type' => 1]);
    if(!empty($info) && !empty($info['avatarUrl']))  $client_count += 2;

    $count = $staff_count + $client_count;

    if($count>92) $count = 92;
    return $count;
}

//获取数量
function longbingGetCount($table_name ,$filter)
{
    if(empty($table_name) || empty($filter) || !is_array($filter)) return false;
    $common_model = new LongbingCardCommonModel();
    return $common_model->getCount($table_name ,$filter);
}

//获取相关数据
function longbingListData($table_name ,$filter ,$field = [])
{
    if(empty($table_name) || empty($filter) || !is_array($filter)) return false;
    $common_model = new LongbingCardCommonModel();
    return $common_model->listRows($table_name ,$filter ,$field);
}
//浏览人数
function longbingView(){
    $card_count = new CardCount();
    //$yesterday = date("Y-m-d",strtotime("-1 day"));
    //统计昨天的CardCount s数据
//    $where = [];
//    $card_count->getYesterdaylist($where);

    //统计昨日新增客户
//    $collect = new Collection();
//    $where['intention'] = 1;
//    $collect->getTodaylist($where);
//    //转发名片
//    $forward_count = new CardForward();
//    $where2['type'] =  1;
//    $where2['status'] =  1;
//    $forward_count->getCount($where2);
    //消息
//    $where4[] = [
//        ['status','=',1],
//        ['deleted','=',0],
//    ];
//    $card_message = new CardMessage();
//    $card_message->getCountlist($where4);
    //
}

function getImageExt ( $src = '' )
{
    $src   = explode( '.', $src );
    $count = count( $src );
    if ( $count < 2 )
    {
        return false;
    }
    $ext = strtolower( $src[ $count - 1 ] );
    if ( $ext == 'jpg' )
    {
        return 'jpg';
    }
    if ( $ext == 'png' )
    {
        return 'png';
    }
    if ( $ext == 'jpeg' )
    {
        return 'jpeg';
    }
    return false;
}

function longbingCreateSharePng ( $gData, $codeName, $uniacid )
{
    //创建画布
    //    $im = imagecreatetruecolor(680, 390);
    $im = imagecreatetruecolor( 738, 420 );
//  longbingchmodr(FILE_UPLOAD_PATH);
    //填充画布背景色
    $color = imagecolorallocate( $im, 255, 255, 255 );
    imagefill( $im, 0, 0, $color );

    //字体文件
    $font_file = APP_PATH . "Common/extend/vista.ttf";


    //设定字体的颜色
    $font_color_1   = ImageColorAllocate( $im, 140, 140, 140 );
    $font_color_2   = ImageColorAllocate( $im, 28, 28, 28 );
    $font_color_3   = ImageColorAllocate( $im, 129, 129, 129 );
    $font_color_4   = ImageColorAllocate( $im, 50, 50, 50 );
    $font_color_5   = ImageColorAllocate( $im, 68, 68, 68 );
    $font_color_red = ImageColorAllocate( $im, 217, 45, 32 );


    //    画又边的图
    list( $l_w, $l_h ) = getimagesize( $gData[ 'img' ] );
    $ext = longbingSingleGetImageExtWx( $gData[ 'img' ] );
    if ( $ext == 'jpg' || $ext == 'jpeg' )
    {
        $logoImg = @imagecreatefromjpeg( $gData[ 'img' ] );
    }
    else if ( $ext == 'png' )
    {
        $logoImg = @imagecreatefrompng( $gData[ 'img' ] );
    }
    else
    {
        return false;
    }
    //    imagecopyresized($im, $logoImg, 368, 0, 0, 0, 312, 390, $l_w, $l_h);
    //    imagecopyresized($im, $logoImg, 399, 0, 0, 0, 339, 420, $l_w, $l_h);
    imagecopyresized( $im, $logoImg, 358, 0, 0, 0, 420, 420, $l_w, $l_h );


    //    画左边的图
    list( $l_w1, $l_h1 ) = getimagesize( 'http://retail.xiaochengxucms.com/images/2/2018/12/F9O1e9o7EfFC9ZT3eVE3w739irRWs1.png' );
    $logoImg1 = @imagecreatefrompng( 'http://retail.xiaochengxucms.com/images/2/2018/12/F9O1e9o7EfFC9ZT3eVE3w739irRWs1.png' );

    imagecopyresized( $im, $logoImg1, 0, 0, 0, 0, 738, 420, $l_w1, $l_h1 );


    //By.jingshuixian  判断logo是否存在,不存在使用默认图片
    if( \longbingcore\tools\LongbingImg::exits( $gData[ 'company_logo' ] ) ){
        //$gData[ 'company_logo' ]  = \app\company\controller\CompanyDefine::$logo_404 ;

        //    画logo
        list( $l_w, $l_h ) = getimagesize( $gData[ 'company_logo' ] );
        $ext = getImageExt( $gData[ 'company_logo' ] );

        if ( $ext == 'jpg' || $ext == 'jpeg' )
        {
            $logoImg = @imagecreatefromjpeg( $gData[ 'company_logo' ] );
        }
        else if ( $ext == 'png' )
        {
            $logoImg = @imagecreatefrompng( $gData[ 'company_logo' ] );
        }

        if(!$logoImg){


            if ( $ext == 'jpg' || $ext == 'jpeg' )
            {
                $logoImg = @imagecreatefrompng( $gData[ 'company_logo' ] );
            }
            else if ( $ext == 'png' )
            {
                $logoImg = @imagecreatefromjpeg( $gData[ 'company_logo' ] );
            }
        }


        imagecopyresized( $im, $logoImg, 32, 22, 0, 0, 30, 30, $l_w, $l_h );

    }

    //    画图标
    //    list($l_w, $l_h) = getimagesize('http://longbingcard.xiaochengxucms.com/images/4/2018/11/Wz22ev7946Q5EN7E82F6R8ZTe2Rx24.png');
    //    $logoImg = @imagecreatefrompng('http://longbingcard.xiaochengxucms.com/images/4/2018/11/Wz22ev7946Q5EN7E82F6R8ZTe2Rx24.png');
    //
    //
    //    imagecopyresized($im, $logoImg, 30, 230, 0, 0, 30, 117, $l_w, $l_h);


    imagettftext( $im, 14, 0, 68, 42, $font_color_4, $font_file, $gData[ 'company_name' ] );
    imagettftext( $im, 14, 0, 78, 250, $font_color_5, $font_file, $gData[ 'phone' ] );
    imagettftext( $im, 14, 0, 78, 295, $font_color_5, $font_file, $gData[ 'email' ] );
    imagettftext( $im, 14, 0, 78, 338, $font_color_5, $font_file, $gData[ 'address' ] );

    imagettftext( $im, 22, 0, 30, 115, $font_color_4, $font_file, $gData[ 'name' ] );
    imagettftext( $im, 14, 0, 30, 155, $font_color_5, $font_file, $gData[ 'job' ] );


    $radius = 30;
    // lt(左上角)
    $lt_corner = longbingGetItRoundCorner( $radius );

    imagecopymerge( $im, $lt_corner, 0, 0, 0, 0, $radius, $radius, 100 );
    // lb(左下角)
    $lb_corner = imagerotate( $lt_corner, 90, 0 );
    imagecopymerge( $im, $lb_corner, 0, 420 - $radius, 0, 0, $radius, $radius, 100 );
    // rb(右上角)
    $rb_corner = imagerotate( $lt_corner, 180, 0 );
    imagecopymerge( $im, $rb_corner, 738 - $radius, 420 - $radius, 0, 0, $radius, $radius, 100 );
    // rt(右下角)
    $rt_corner = imagerotate( $lt_corner, 270, 0 );
    imagecopymerge( $im, $rt_corner, 738 - $radius, 0, 0, 0, $radius, $radius, 100 );

    $file_path = FILE_UPLOAD_PATH . "images/share_img/{$uniacid}";
    mkdirs_v2($file_path);
    $fileName = FILE_UPLOAD_PATH . "images/share_img/{$uniacid}/share-{$codeName}.png";
    imagepng( $im, $fileName );


    //    $im    = imagecreatetruecolor(780, 500);
    $im    = imagecreatetruecolor( 780, 624 );
    $color = imagecolorallocate( $im, 223, 223, 223 );
    imagefill( $im, 0, 0, $color );
    list( $l_w1, $l_h1 ) = getimagesize( 'http://retail.xiaochengxucms.com/images/2/2018/12/WzRC39R9CsgmC9Rqq8b3rm8xBTsYG9.png' );
    $bg = @imagecreatefrompng( 'http://retail.xiaochengxucms.com/images/2/2018/12/WzRC39R9CsgmC9Rqq8b3rm8xBTsYG9.png' );
    //    $im = @imagecreatefrompng('http://retail.xiaochengxucms.com/images/2/2018/12/WzRC39R9CsgmC9Rqq8b3rm8xBTsYG9.png');

    imagecopyresized( $im, $bg, 0, 0, 0, 0, 780, 624, $l_w1, $l_h1 );


    list( $l_w1, $l_h1 ) = getimagesize( $fileName );
    $bg = @imagecreatefrompng( $fileName );

    imagecopyresized( $im, $bg, 20, 20, 0, 0, 740, 420, $l_w1, $l_h1 );

    $fileName = FILE_UPLOAD_PATH  . "images/share_img/{$uniacid}/share-{$codeName}.png";
    imagepng( $im, $fileName );
    imagedestroy( $im );
    imagedestroy( $logoImg );
    imagedestroy( $logoImg1 );
    imagedestroy( $bg );
    return true;


    //输出图片
//  if ( $fileName )
//  {
//      imagepng( $im, $fileName );
//  }
//  else
//  {
//      Header( "Content-Type: image/png" );
//      imagepng( $im );
//  }
}

function longbingGetItRoundCorner ( $radius )
{
    $img     = imagecreatetruecolor( $radius, $radius );    // 创建一个正方形的图像
    $bgcolor = imagecolorallocate( $img, 210, 210, 210 );     // 图像的背景
    $fgcolor = imagecolorallocate( $img, 0, 0, 0 );
    imagefill( $img, 0, 0, $bgcolor );

    // $radius,$radius：以图像的右下角开始画弧
    // $radius*2, $radius*2：已宽度、高度画弧
    // 180, 270：指定了角度的起始和结束点
    // fgcolor：指定颜色
    imagefilledarc( $img, $radius, $radius, $radius * 2, $radius * 2, 180, 270, $fgcolor, IMG_ARC_PIE );
    // 将弧角图片的颜色设置为透明
    imagecolortransparent( $img, $fgcolor );
    // 变换角度
    // $img = imagerotate($img, 90, 0);
    // $img = imagerotate($img, 180, 0);
    // $img = imagerotate($img, 270, 0);
    //     header('Content-Type: image/png');
    //     imagepng($img);
    //     die;
    return $img;
}

function longbingSortStr ( $str, $len )
{
    if ( mb_strlen( $str, 'utf8' ) > $len )
    {
        $str = mb_substr( $str, 0, $len, "UTF-8" ) . '...';
    }
    return $str;
}
//初始化公司和职务
function longbingGetCompanyConfig($uniacid){
    if($uniacid){
        $company = new CardCompany();
        //公司
        $key = 'longbing_company_init_'.$uniacid;
        if(hasCache($key ,$uniacid)) return ;
        $company_count = $company->where('uniacid', '=', $uniacid)->count();
        if( empty($company_count) )
        {
            $rest = $company->createRow([
                'name'=>'某某科技公司',
                'short_name'=>'某公司',
                'addr'=>'某某地址',
                'phone'=>'1008611',
                'desc'=>'',
                'culture'=>'',
                'uniacid'=>$uniacid,
            ]);
        }else{
            setCache($key, $company_count ,7200 ,$uniacid);
        }
        //职位
        $key1 = 'longbing_job'.$uniacid;
        $job = new CardJob();
        if($job->where('uniacid', '=', $uniacid)->count() == 0)
        {
            $res = $job->createRow([
                'name'=>'某某职位',
                'uniacid'=>$uniacid,
            ]);
        }
    }
}

/**
 * @Purpose: 获取文件后缀名
 *
 * @Author: zzf
 *
 * @Return: mixed 查询返回值（结果集对象）
 */
function longbingSingleGetImageExt ( $src = '' )
{
    $src   = explode( '.', $src );
    $count = count( $src );
    if ( $count < 2 )
    {
        return false;
    }
    $ext = strtolower( $src[ $count - 1 ] );
    if ( $ext == 'jpg' )
    {
        return 'jpg';
    }
    if ( $ext == 'png' )
    {
        return 'png';
    }
    if ( $ext == 'jpeg' )
    {
        return 'jpeg';
    }
    return false;
}

function longbingSingleGetImageExtWx ( $src = '' )
{
    $src   = explode( '.', $src );
    $count = count( $src );
    if ( $count < 2 )
    {
        return false;
    }
    $ext = strtolower( $src[ $count - 1 ] );
    if ( $ext == 'jpg' )
    {
        return 'jpg';
    }
    if ( $ext == 'png' )
    {
        return 'png';
    }
    if ( $ext == 'jpeg' )
    {
        return 'jpeg';
    }
    return 'jpg';
}

/**
 * @Purpose: 将图片处理为圆形
 *
 * @Author: zzf
 *
 * @Return: mixed 查询返回值（结果集对象）
 */
function longbingSingleYuanImg ( $imgpath )
{
    //$ext     = pathinfo( $imgpath );
    //$src_img = null;

    $wh  = getimagesize( $imgpath );
    $ext   = $wh[ 'mime' ];

    switch ( $ext)
    {
        case 'image/jpg' :
        case 'image/jpeg' :
            $src_img = imagecreatefromjpeg( $imgpath );
            break;
        case 'image/png':
            $src_img = imagecreatefrompng( $imgpath );
            break;
    }

    $w   = $wh[ 0 ];
    $h   = $wh[ 1 ];
    $w   = min( $w, $h );
    $h   = $w;
    $img = imagecreatetruecolor( $w, $h );
    //这一句一定要有
    imagesavealpha( $img, true );
    //拾取一个完全透明的颜色,最后一个参数127为全透明
    $bg = imagecolorallocatealpha( $img, 255, 255, 255, 127 );
    imagefill( $img, 0, 0, $bg );
    $r   = $w / 2; //圆半径
    $y_x = $r; //圆心X坐标
    $y_y = $r; //圆心Y坐标
    for ( $x = 0; $x < $w; $x++ )
    {
        for ( $y = 0; $y < $h; $y++ )
        {
            $rgbColor = imagecolorat( $src_img, $x, $y );
            if ( ( ( ( $x - $r ) * ( $x - $r ) + ( $y - $r ) * ( $y - $r ) ) < ( $r * $r ) ) )
            {
                imagesetpixel( $img, $x, $y, $rgbColor );
            }
        }
    }

    return $img;
}

function longbingUpdateQrByAvatar($avatar ,$qrImage ,$uniacid ,$image_name)
{

    $img       = longbingSingleYuanImg( $avatar );

    $extAvatar = longbingSingleGetImageExtWx( $avatar );

    $local     = FILE_UPLOAD_PATH . 'images/test' . rand( 10000, 99999 ) . '.' . $extAvatar;
//    dump(1);exit;

    imagepng( $img, $local );



    $im = imagecreatetruecolor( 430, 430 );

    //填充画布背景色
    $color = imagecolorallocate( $im, 255, 255, 255 );
    imagefill( $im, 0, 0, $color );

    // 画背景二维码
    $result = getimagesize( $qrImage );

    $l_w1   = $result[ 0 ];
    $l_h1   = $result[ 1 ];
    $mime   = $result[ 'mime' ];
    if ( $mime == 'image/png' ) {
        $qr = imagecreatefrompng( $qrImage );
    }
    else if ( $mime == 'image/jpeg' ) {
        $qr = imagecreatefromjpeg( $qrImage );
    }
    else {

        return false;
    }

    imagecopyresized( $im, $qr, 0, 0, 0, 0, 430, 430, $l_w1, $l_h1 );

    // 画中间头像
    $result = getimagesize( $local );
    $l_w1   = $result[ 0 ];
    $l_h1   = $result[ 1 ];
    $mime   = $result[ 'mime' ];
    if ( $mime == 'image/png' ) {
        $avatar = imagecreatefrompng( $local );
    }
    else if ( $mime == 'image/jpeg' ) {
        $avatar = imagecreatefromjpeg( $local );
    }
    else {
        die;
    }
    imagecopyresized( $im, $avatar, 120, 120, 0, 0, 190, 190, $l_w1, $l_h1 );
    $localAvatarQr = realpath(FILE_UPLOAD_PATH  . $image_name);
    if(longbingHasLocalFile($image_name)) unlink($localAvatarQr);
    // die;
    $result = imagepng( $im, $localAvatarQr );
    imagedestroy( $im );
    @unlink( $local );
    return $result;
}


//if (!function_exists('debugOneService') ){
//function longbingDebugOneService ($data, $log_file = '') {
//    if (env('APP_DEBUG') != true) {
//        return;
//    }
//    $default_file = '/www/wwwroot/longbingtest.xiaochengxucms.com/xinlingshou_caoshi/addons/longbing_card/core2/runtime/article/log/201910/09.log';
//    if (!is_file($default_file)) {
//        return;
//    }
//    $filename = $log_file == '' ?  $default_file : $log_file;
//    file_put_contents($filename, 'debug ====' . json_encode($data, JSON_UNESCAPED_UNICODE)  . PHP_EOL, FILE_APPEND);
//}
//}

if (!function_exists('lbIsStaff') ){

    function lbIsStaff($id){
       $data =  Db::name('longbing_card_user_info')->where(['fans_id'=>$id,'is_staff'=>1])->field('id')->find();
       return !empty($data)?1:0;
    }
}
//获取当前小程序名片总数
function longbingGetCardNum($uniacid ,$is_update = false)
{
//  $key = 'longbing_card_card_num_' . $uniacid;
//
//  //判断缓存是否存在
//  if(hasCache($key ,$uniacid) && empty($is_update)){
//      //获取缓存数据
//      $count = getCache($key ,$uniacid);
//      //判断缓存数据是否为空,否则返回
//      if(!empty($count)) return $count;
//  }
    //获取用户数据
    $staff_model = new LongbingUserInfo();//生成查询类
    //获取数据
    $count = $staff_model->getUserCount(['uniacid' => $uniacid ,'is_staff' => 1]);
    //设置缓存
//  setCache ( $key, $count, 600, $uniacid);
    //返回数据
    return $count;
}


if (!function_exists('lbGetCopyrightInfo'))  {
    function lbGetCopyrightInfo ($copyright_id)   {
        $cardauth2_copyright = Db::name('longbing_cardauth2_copyright')->where('id', '=', $copyright_id)->find();
        return $cardauth2_copyright ?? null;
    }
}


function longbingGetBossNum($uniacid ,$is_update = false)
{
//  $key = 'longbing_card_boss_num_' .$uniacid;
//  //判断缓存是否存在
//  if(hasCache($key ,$uniacid) && empty($is_update)){
//      //获取缓存数据
//      $count = getCache($key ,$uniacid);
//      //判断缓存数据是否为空,否则返回
//      if(!empty($count)) return $count;
//  }
    //获取用户数据
    $user_model = new LongbingUser();//生成查询类
    //获取数据
    $count = $user_model->getUserCount(['uniacid' => $uniacid ,'is_staff' => 1 ,'is_boss' => 1]);
    //设置缓存
//  setCache ( $key, $count, 600, $uniacid);
    //返回数据
    return $count;
}

function longbingGetCompany($company_id ,$filter = [])
{
    $company_model = new CompanyModel();
    $company       = $company_model->getCompany(['id' => $company_id] ,$filter);
    return $company;
}

function longbingGetUpCompanyIds($company_id)
{
    $result = [];
    $company       = longbingGetCompany(['id' => $company_id] ,['pid']);
    if(!empty($company))  $result[] = $company_id;
    if(!empty($company) && !empty($company['pid']))
    {
        $result[] = $company['pid'];
        $pid = $company['pid'];
        while(!empty($pid))
        {
            $company = longbingGetCompany(['id' => $pid] ,['pid']);
            if(!empty($company) && !empty($company['pid']))
            {
                $result[] = $company['pid'];
                $pid = $company['pid'];
            }else{
                $pid = 0;
            }
        }
    }
    if(!empty($result)) $result = array_reverse($result);
    return $result;
}

/**
 * 获取插件配置
 */
if (!function_exists('lbPulgSettingInfo'))  {
    function lbPulgSettingInfo($uniacid,$name,$key=[]){
        $dis['uniacid']= $uniacid;
        $dis['name']   = $name;
        if(empty($key)){
            $data = Db::name('longbing_card_plug_setting')->where($dis)->select();
        }else{
            foreach ($key as $value){
                $dis['key'] = $value;
                $singe = Db::name('longbing_card_plug_setting')->where($dis)->find();
                if(empty($singe['key'])){
                    $singe = lbPulgSettingInsert($uniacid,$name,$value);
                }
                $data[] = $singe;
            }
        }
        $arr = [];
        if(!empty($data)){
            foreach ($data as $k=>$v){
                $v['value'] = !empty($v['value'])?json_decode($v['value'],true):$v['value'];
                $arr[$v['key']] = $v['value'];
            }
        }
        return $arr;
    }
}


/**
 * 插入插件配置
 */
if (!function_exists('lbPulgSettingInsert'))  {
    function lbPulgSettingInsert($uniacid,$name,$key){
        $ins['uniacid']     = $uniacid;
        $ins['name']        = $name;
        $ins['key']         = $key;
        $ins['value']       = 0;
        $ins['create_time'] = time();
        $ins['update_time'] = time();
        $res = Db::name('longbing_card_plug_setting')->insert($ins);
        $data= Db::name('longbing_card_plug_setting')->where(['uniacid'=>$uniacid,'name'=>$name,'key'=>$key])->find();
        return $data;
    }
}


/**
 * 编辑插件配置
 */
if (!function_exists('lbPulgSettingUpdate'))  {
    function lbPulgSettingUpdate($uniacid,$name,$key,$vaule){
        $res = Db::name('longbing_card_plug_setting')->where(['uniacid'=>$uniacid,'name'=>$name,'key'=>$key])->update(['value'=>json_encode($vaule),'update_time'=>time()]);
        return $res;
    }
}



//按顺序分配客服
function lingbingGetAutoStaff($uniacid)
{
    $user_model = new LongbingUserInfo();//生成查询类
    $staff      = $user_model->getOneStaff($uniacid);
    return $staff;
}

//通过账号获取员工信息
function longbingGetStaff($account)
{
    if(empty($account)) return false;
    //获取数据
    $staff_model = new LongbingUserInfo();
    $staff       = $staff_model->getUser(['account' => $account ,'is_staff' => 1]);
    return $staff;
}

//检查账号是否存在
function longbingCheckStaffAccount($account)
{
    if(empty($account)) return false;
    //获取数据
    $staff_model = new LongbingUserInfo();
    $count       = $staff_model->getCount(['account' => $account]);
    return !empty($count);
}

if (!function_exists('lbUserInfoAvatar')) {

    function lbUserInfoAratar($uid){
        $data = Db::name('longbing_card_user')->where(['id'=>$uid])->value('avatarUrl');
        $data = !empty($data)?$data:'https://retail.xiaochengxucms.com/defaultAvatar.png';
        return $data;
    }

}

//默认员工头像
if (!function_exists('lbUserAvatar')) {

    function lbUserAvatar($uid){

        $data = Db::name('longbing_card_user_info')->where(['fans_id'=>$uid])->value('avatar');

        $data = !empty($data)?$data:Db::name('longbing_card_user')->where(['id'=>$uid])->value('avatarUrl');

        $data = !empty($data)?$data:'https://retail.xiaochengxucms.com/defaultAvatar.png';

        return $data;
    }
}

//员工姓名
if (!function_exists('lbUserName')) {

    function lbUserName($uid){

        $data = Db::name('longbing_card_user_info')->where(['fans_id'=>$uid])->value('name');

        $data = !empty($data)?$data:Db::name('longbing_card_user')->where(['id'=>$uid])->value('nickName');

        return $data;
    }
}
//员工姓名
if (!function_exists('lbUserCompany')) {

    function lbUserCompany($uid){

        $company_id = Db::name('longbing_card_user_info')->where(['fans_id'=>$uid])->value('company_id');

        $top_id     = Db::name('longbing_card_company')->where(['id'=>$company_id])->value('top_id');

        $company_id = !empty($top_id)?$top_id:$company_id;

        $data = Db::name('longbing_card_company')->where(['id'=>$company_id])->value('name');;

        return $data;
    }
}



//收集formId
function longbingSaveFormId($data)
{
    $model = new CardFormId();
    if(!is_array($data) || empty($data)) return ;
    return $model->saveAll( $data );
}

function longbingchmodr($path) {

    $filemode = 0777;
    //判断文件夹是否存在
    if (!is_dir($path)) return chmod($path, $filemode);
    //获取文件夹下
    $dh = opendir($path);

    while (($file = readdir($dh)) !== false) {

        if($file != '.' && $file != '..') {

            $fullpath = $path.'/'.$file;

            if(is_link($fullpath))
            {
                return FALSE;
            }elseif(!is_dir($fullpath) && !chmod($fullpath, $filemode)){
                return FALSE;
            }elseif(!longbingchmodr($fullpath, $filemode))
            {
                return FALSE;
            }
        }
    }
    closedir($dh);

    if(chmod($path, $filemode))
    {
        return TRUE;
    }else{
        return FALSE;
    }
}

/**
 * 功能说明
 *
 * @param $infoName
 * @param string $type
 * @param int $uniacid  大于0时,需要做权限过滤
 * @return array
 * @author shuixian
 * @DataTime: 2019/12/26 15:29
 */
function longbing_init_info_data($infoName , $type = '' , $uniacid = 0 ){

    $myModelList =  \config('app.AdminModelList');

    $myModelList = $myModelList['saas_auth_admin_model_list'];

    $returnMenuData = [];
    //获取模权限
    $denyAdminMenuKeys = AdminMenu::getAuthList(intval($uniacid));
    //加载所有配置内容
    foreach ($myModelList as $model_name => $model_item ) {
        //过滤权限
        if(!empty($uniacid) &&  !array_key_exists($model_name, $denyAdminMenuKeys)){
            continue ;
        }
        //需要判断文件是否存在
        $dataPath =  APP_PATH . $model_name . '/info/' . $infoName . '.php' ;

        if(file_exists($dataPath)){

            $admin_menu =  include $dataPath ;
            //空数据不放入
            if ($admin_menu != []) {

                if (in_array($infoName,['DiyMenu','DiyCompoents','DiyLink', 'DiyTabbar','RadarMessage','FunctionPage'])) { //小程序底部菜单,需要合并数组

                    foreach ($admin_menu as $diyMenu){

                        array_push($returnMenuData,$diyMenu);

                    }

                }else if(in_array($infoName,['Info'])){

                    if(!empty($type) && array_key_exists('type' ,  $admin_menu)  &&  $type == $admin_menu['type'] ){

                        array_push($returnMenuData ,$admin_menu);
                    }

                } else if(in_array($infoName,['AdminMenu'])){  //AdminMenu获取指定数据


                    //导入info信息查看
                    $infoDataPath =  APP_PATH . $model_name . '/info/Info.php' ;

                    $infoData =  include $infoDataPath ;

                    if(!empty($type) && array_key_exists('type' ,  $infoData)  &&  $type == $infoData['type'] ){

                        $returnMenuData[key($admin_menu)] = $admin_menu[key($admin_menu)];
                    }

                }elseif(in_array($infoName,['DiyDefaultCompoents'])){

                    $returnMenuData[] = $admin_menu;

                }else{

                    $returnMenuData[key($admin_menu)] = $admin_menu[key($admin_menu)];
                }

            }

        }

    }

    return $returnMenuData;
}


/**
 * @author chenniang
 * @DataTime: 2020-06-28 11:37
 * @功能说明:获取有权限的组建
 */
function getAuthCompoentsData($returnCompoentsData,$uniacid){

    $data = [];

    if(!empty($returnCompoentsData)){

        $denyAdminMenuKeys = AdminMenu::getAuthList(intval($uniacid));



        foreach ($returnCompoentsData as $k=>$v){

            $new_data = [];

            if(!empty($v['data'])){

                foreach ($v['data'] as $vs){

                    if(isset($vs['re_name_key'])){

                        $intersect = array_intersect($vs['re_name_key'],array_keys($denyAdminMenuKeys));

                    }

                    if(!empty($intersect)||!isset($vs['model_name_key'])||(isset($vs['model_name_key'])&&array_key_exists($vs['model_name_key'],$denyAdminMenuKeys))){

                        $new_data[] = $vs;
                    }
                }
            }

            $v['data'] = $new_data;

            if(!empty($new_data)){

                $data[$k] = $v;
            }
        }
    }

    return array_values($data);

}

/**
 * @author chenniang
 * @DataTime: 2020-06-11 14:27
 * @功能说明:默认页面
 */
function longbing_default_Page($key){

    $DiyCompoentsData = longbing_init_info_data('DiyDefaultCompoents');

    $data =[];

    foreach ($DiyCompoentsData as $v){

        if($v['key']==$key){

            $data = $v;
            break;
        }
    }

    return $data;
}


/**
 * @author yangqi
 * @time   2019年11月28日00:15:10
 * 加载雷达信息
 */
function longbingInitRadarMessage() {
    //雷达模块数据
    $config_path = APP_PATH . 'RadarInfo.php';
    //判断文件是否存在
    if(!file_exists($config_path)) return [];
    //获取模块数据
    $model_list = include_once($config_path);
    $result = [];
    if(!is_array($model_list)) return $result;
    foreach($model_list as $value){
        $data_path = APP_PATH . $value . '/info/RadarMessage.php';
        if(file_exists($data_path)){
            $val = require $data_path;
            if(!empty($val) && is_array($val)){
                $result = array_merge($result ,$val);
            }
        }
    }
    return $result;
}

/**
 * @author yangqi
 * 2019年11月29日11:43:26
 * 多维数据拆分成一维数组
 */

function longbingGetArrToOne($arr)
{
    $result = array();
    foreach ($arr as $key => $val) {
        if( is_array($val) ) {
            $result = array_merge($result, longbingGetArrToOne($val));
        } else {
            $result[$key] = $val;
        }
    }
  return $result;
}

/**
 * @author yangqi
 * @time   2019年11月28日00:15:10
 * 加载雷达信息
 */
function longbingGetPersionalCenterMenu($uniacid) {
    //雷达模块数据
    $config_path = APP_PATH . 'PersonalCenterConfig.php';
    //判断文件是否存在
    if(!file_exists($config_path)) return [];
    //获取模块数据
    $model_list = include_once($config_path);
    $result = [];
    if(!is_array($model_list)) return $result;
    //权限验证（获取权限）
    $pluginAuth = longbingGetPluginAuth($uniacid);
    $auth = $pluginAuth['web_manage_meta_config'];

    //数据处理
    foreach($model_list as $key=>$value){
        //是否导入
        $is_load = false;
        //判断是否是默认
        if(isset($value['is_default']) && !empty($value['is_default'])) $is_load = true;
        //权限判断
        if(empty($is_load) && isset($auth[$key]) && !empty($auth[$key])) $is_load = true;
        if($is_load){
            $data_path = APP_PATH . $key . '/info/PersonalCenterMenu.php';
            if(file_exists($data_path)){
                $val = require $data_path;
//              var_dump($val);die;
                if(!empty($val) && is_array($val)){
                    $result = array_merge($result ,$val);
                }
            }
        }
    }
    return $result;
}

/**
 * @author yangqi
 * @time   2019年11月28日00:15:10
 * 加载雷达信息
 */
function longbingGetStaffCenterMenu($uniacid) {
    //雷达模块数据
    $config_path = APP_PATH . 'StaffCenterConfig.php';
    //判断文件是否存在
    if(!file_exists($config_path)) return [];
    //获取模块数据
    $model_list = include_once($config_path);
    $result = [];
    if(!is_array($model_list)) return $result;
    //权限验证（获取权限）
    $pluginAuth = longbingGetPluginAuth($uniacid);
    $auth = $pluginAuth['web_manage_meta_config'];

    foreach($model_list as $key=>$value){
        //是否导入
        $is_load = false;
        //判断是否是默认
        if(isset($value['is_default']) && !empty($value['is_default'])) $is_load = true;
        //权限判断
        if(empty($is_load) && isset($auth[$key]) && !empty($auth[$key])) $is_load = true;
        if($is_load){
            $data_path = APP_PATH . $key . '/info/StaffCenterMenu.php';
            if(file_exists($data_path)){
                $val = require $data_path;
                if(!empty($val) && is_array($val)){
                    $result = array_merge($result ,$val);
                }
            }
        }
    }
    return $result;
}

/**
 * @author yangqi
 * @time   2019年11月28日00:15:10
 * 加载雷达信息
 */
function longbingGetWorkCenterMenu($uniacid) {
    //雷达模块数据
    $config_path = APP_PATH . 'WorkCenterConfig.php';
    //判断文件是否存在
    if(!file_exists($config_path)) return [];
    //获取模块数据
    $model_list = include_once($config_path);
    $result = [];
    if(!is_array($model_list)) return $result;
    //权限验证（获取权限）
    $pluginAuth = longbingGetPluginAuth($uniacid);
    $auth = $pluginAuth['web_manage_meta_config'];
    foreach($model_list as $key=>$value){
        //是否导入
        $is_load = false;
        //判断是否是默认
        if(isset($value['is_default']) && !empty($value['is_default'])) $is_load = true;
        //权限判断
        if(empty($is_load) && isset($auth[$key]) && !empty($auth[$key])) $is_load = true;
        //是否载入
        if($is_load){
            $data_path = APP_PATH . $key . '/info/WorkCenterMenu.php';
            if(file_exists($data_path)){
                $val = require $data_path;
                if(!empty($val) && is_array($val)){
                    $result = array_merge($result ,$val);
                }
            }
        }
    }
    return $result;
}

/**
 * @author yangqi
 * @time   2019年11月29日15:04:05
 * 加载tabbar
 */

function longbingGetTabbarMenu()
{
    $myModelList =  \config('app.AdminModelList');
    $myModelList = array_merge($myModelList['saas_auth_admin_model_list'] ,$myModelList['saas_auth_app_list']);
    $result      = [];
    foreach($myModelList as $key=>$val)
    {
        $result[] = $key;
    }
    return $result;
}

/**
 * By.jingshuixian
 * 2019年11月24日19:37:43
 * 获取缓存key
 */
function longbing_get_cache_key($key , $uniacid){
    //longbing_端口_key_7777
    //龙兵科技前缀_区分端口_key_平台ID
    return 'longbing_' . $key . '_' . $uniacid;
}

/**
 * By.jingshuixian
 * 2019年11月24日19:46:35
 * 自动缓存方法,具体实现打算使用闭包方式
 */
function longbing_auto_cahe(){

    //自动获取模块/查件名称、类名称、方法名称、来组合缓存key


}

/**
 * By.jingshuixian
 * 2019年11月26日13:57:16
 * 执行异步的方法
 * @param $url
 * @param array $param
 */
if (!function_exists('getRangeMem')) {


    function longbing_do_request($url, $param = array())
    {

//        try {
            $urlinfo = parse_url($url);

            $host = $urlinfo['host'];

            $query_url = $urlinfo['query'];

            //By.jingshuixian  2019年12月4日00:19:11
            // 当前请求的内容里有get 参数时 , 拼接 path
            if (!empty($query_url)) {
                $path = $urlinfo['path'] . '?' . $query_url;
            }
//            dump($path,$host);exit;
            $query = isset($param) ? http_build_query($param) : '';
            if (empty($host)) return false;

            $port = !empty($urlinfo['scheme']) && $urlinfo['scheme'] == 'https' ? 443 : 80;//判断https 还是 http
            $errno = 0;
            $errstr = '';
            $timeout = 50;
            $c_houst = !empty($urlinfo['scheme']) && $urlinfo['scheme'] == 'https' ? 'ssl://' . $host : $host;//判断https 还是 http

            $fp = fsockopen($c_houst, $port, $errno, $errstr, $timeout);


            $out = "POST " . $path . " HTTP/1.1\r\n";
            $out .= "host:" . $host . "\r\n";
            $out .= "content-length:" . strlen($query) . "\r\n";
            $out .= "content-type:application/x-www-form-urlencoded\r\n";
            $out .= "connection:close\r\n\r\n";
            $out .= $query;


            fputs($fp, $out);
            $resp_str = '';
            while (!feof($fp)) {
                $resp_str .= fgets($fp, 512);//返回值放入$resp_str
            }
            fclose($fp);

            //By.jingshuixian  增加内容返回值
            return [$resp_str, $out];
//
//        } catch (\Exception $e) {
//
//        }

    }
}
/**
 * 记录区间的内存使用情况
 * @param string            $start 开始标签
 * @param string            $end 结束标签
 * @param integer|string    $dec 小数位
 * @return string
 */
if (!function_exists('getRangeMem')) {
    function getRangeMem($start, $end = null, $dec = 2)
    {
        if (!isset($end)) {
            $end = memory_get_usage();
        }
        $size = $end - $start;
        $a = ['B', 'KB', 'MB', 'GB', 'TB'];
        $pos = 0;
        while ($size >= 1024) {
            $size /= 1024;
            $pos++;
        }
        return round($size, $dec) . " " . $a[$pos];
    }
}


/**
 * 统计某个区间的时间（微秒）使用情况 返回值以秒为单位
 * @param string            $start 开始标签
 * @param string            $end 结束标签
 * @param integer|string    $dec 小数位
 * @return integer
 */
if (!function_exists('getRangeTime')) {
    function getRangeTime($start, $end = null, $dec = 6)
    {
        if (!isset($end)) {
            $end = microtime(true);
        }
        return number_format(($end - $start), $dec);
    }
}



if (!function_exists('longbing_init_info_subscribe')) {
    /**
     * 自动加载监听事件
     *
     * @return array
     * @author shuixian
     * @DataTime: 2019/12/12 9:47
     */
    function longbing_init_info_subscribe()
    {
        $myModelList = \config('app.AdminModelList');

        $saas_auth_admin_model_list = $myModelList['saas_auth_admin_model_list'] ;


        $returnMenuData = [];
        foreach ($saas_auth_admin_model_list as $model_name => $model_item) {


            //需要判断文件是否存在
            $dataPath = app_path() . $model_name . '/info/Subscribe.php';
            if (file_exists($dataPath)) {
                $returnMenuData[] = 'app\\' . $model_name . '\\info\\Subscribe';
            }
        }
        return $returnMenuData;
    }
}


if (!function_exists('longbing_array_columns')) {
    /**
     * 取出数组里的一列或者多列
     *
     * @param $arr
     * @param $keys
     * @return array
     * @author shuixian
     * @DataTime: 2019/12/16 10:39
     */
    function longbing_array_columns($arr, $keys)
    {
        $returnArray = [] ;
        foreach ($arr as $v) {
            foreach ($keys as $k) {
                if(array_key_exists($k,$v)){
                    $n[$k] = $v[$k];
                }
            }
            $returnArray[] = $n;
        }
        return $returnArray;
    }
}

if (!function_exists('longbing_get_auth_prefix')) {
    /**
     * 获得SAAS授权的参数前缀内容 , 需要不要分行业授权,需要根据实际需求确定
     *
     * @return string
     * @author shuixian
     * @DataTime: 2019/12/19 16:31
     */
    function longbing_get_auth_prefix($authName)
    {
        //统一添加参数前缀

        $prefix = strtoupper(APP_MODEL_NAME);
        $prefix = (($prefix == 'LONGBING_CARD') ? 'LONGBING_' : $prefix . '_');
        return $prefix . $authName;
    }
}

if (!function_exists('longbing_dd')) {

    /**
     * 打印调试信息
     * @access public
     * @param mixed $message 日志信息
     * @param array $context 替换内容
     * @return void
     * @author shuixian
     * @DataTime: 2019/12/23 16:31
     */
    function longbing_dd($message, array $context = [])
    {
        if(Env::get('APP_DEBUG', false) ){
            Log::debug($message, $context);
        }

    }
}


if (!function_exists('longbing_compare_version')) {
    /**
     * 功能说明
     *
     * @param $oldVersion 老版本号
     * @param $newVersion 新版本号
     * @return bool       是否升级,新版本号大于老版本号,就升级
     * @author shuixian
     * @DataTime: 2019/12/17 10:16
     */
    function longbing_compare_version($oldVersion, $newVersion)
    {
        $isNew = false;
        $oldVersion = explode('.', $oldVersion);
        $newVersion = explode('.', $newVersion);
        foreach ($newVersion as $key => $value) {

            if (intval($value) > intval($oldVersion[$key])) {
                $isNew = true;
                break;
            }

        }

        return $isNew;
    }
}

if (!function_exists('longbing_tablename')) {
    /**
     * 根据当前表名获取完整的前缀+表名
     *
     * @param $tablename
     * @return string
     * @author shuixian
     * @DataTime: 2019/12/17 11:01
     */
    function longbing_tablename($tablename)
    {
        $prefix = config('database.connections.mysql.prefix');
        return $prefix . $tablename;
    }
}
if (!function_exists('longbing_get_prefix')) {
    /**
     * 获得数据库表前缀
     *
     * @return mixed
     * @author shuixian
     * @DataTime: 2019/12/17 13:44
     */
    function longbing_get_prefix()
    {
        $prefix = config('database.connections.mysql.prefix');
        return $prefix;
    }
}
if (!function_exists('longbing_get_table_prefix')) {
    /**
     * 获得数据库表前缀(感觉名字比较易懂一点)
     *
     * @return mixed
     * @author shuixian
     * @DataTime: 2019/12/17 13:44
     */
    function longbing_get_table_prefix()
    {
        $prefix = config('database.connections.mysql.prefix');
        return $prefix;
    }
}

if (!function_exists('longbing_check_install')) {
    /**
     * 检查是否安装,没有安装就自动安装
     *
     * @author shuixian
     * @DataTime: 2020/1/2 18:34
     */
    function longbing_check_install()
    {
        $lockPath = APP_PATH . 'install/controller/install.lock';
        if (!file_exists($lockPath)) {
            \app\admin\service\UpdateService::installSql(8888);
            file_put_contents($lockPath, time());
        }
    }
}
if (!function_exists('longbing_get_app_type')) {
    /**
     * 获取app类型
     *
     * @return string
     * @author shuixian
     * @DataTime: 2020/1/3 15:43
     */
    function longbing_get_app_type()
    {
        $type = '';
        $agent = Request::header('user-agent');
        if (strpos($agent, 'baiduboxapp')) {
            $type = 'baiduboxapp';
        }
        return $type;
    }
}
if (!function_exists('longbing_get_mobile_type')) {
    /**
     * 获取app类型
     *
     * @return string
     * @author shuixian
     * @DataTime: 2020/1/3 15:43
     */
    function longbing_get_mobile_type()
    {
        $type = '';
        $agent = Request::header('user-agent');
        if (strpos($agent, 'Android')) {
            $type = 'Android';
        }elseif (strpos($agent, 'iPhone')) {
            $type = 'iPhone';
        }
        return $type;
    }
}

if (!function_exists('longbing_filterEmoji')) {
    /**
     * @param $str
     * @return string|string[]|null
     * 过滤表情包
     */
    function longbing_filterEmoji($str)
    {
        $str = preg_replace_callback(
            '/./u',
            function (array $match) {
                return strlen($match[0]) >= 4 ? '' : $match[0];
            },
            $str);

        return $str;
    }
}

if(!function_exists('longbing_auth_status')){
    /**
     **@author lichuanming
     * @DataTime: 2020/5/15 10:35
     * @功能说明: 账户状态
     */
    function longbing_auth_status($uniacid){
        $resData = [
            'name' => '', #套餐名称
            'time' => '', #到期时间
            'status' => 0, #状态 0未过期  1即将到期  2已到期
        ];

        //如果是微擎 则不判断是否到期
        if(!longbingIsWeiqin()){
            $info = Db::name('longbing_cardauth2_config')->where('modular_id','=',$uniacid)
                ->field('end_time,mini_name')->find(); #获取过期时间

            $end_time = $info['end_time'];

            if($end_time <= time()){ //已过期
                list($resData['name'],$resData['time'],$resData['status']) = array($info['mini_name'],date('Y-m-d',$end_time),2);

            }else if($end_time < time() + 30*86400 && $end_time > time()){ #即将过期/30天

                list($resData['name'],$resData['time'],$resData['status']) = array($info['mini_name'],date('Y-m-d',$end_time),1);
            }
        }
        return $resData;
    }
}


//随机生成偏移量
function createOffset() {
    return substr(uuid() ,8,10);
}

//生成密码
function createPasswd($passwd ,$offset) {
    return password_hash($offset.$passwd.$offset ,PASSWORD_DEFAULT);
}

//多维数组排序
if(!function_exists('arraySort')){

    function arraySort($array,$keys,$sort='asc'){

        $newArr = $valArr = array();

        foreach ($array as $key=>$value) {

            $valArr[$key] = $value[$keys];
        }
        ($sort == 'asc') ?  asort($valArr) : arsort($valArr);
        reset($valArr);

        foreach($valArr as $key=>$value) {
            $newArr[$key] = $array[$key];
        }

        return array_values($newArr);
    }
}

/**
 * 转星期
 */
if(!function_exists('changeWeek')){


     function changeWeek($week){

        switch ($week){
            case 1:
                return '周一';
                break;
            case 2:
                return '周二';
                break;
            case 3:
                return '周三';
                break;
            case 4:
                return '周四';
                break;
            case 5:
                return '周五';
                break;
            case 6:
                return '周六';
                break;
            case 0:
                return '周天';
                break;
        }
    }
}

if(!function_exists('orderCode')){

    function orderCode(){

        $i = rand(1,999);

        $out_trade_no = date( 'YmdHis' ) . '0' . $i. '0';

        $idlen        = strlen($i);

        $out_trade_no = $out_trade_no . str_repeat( '0', 7 - $idlen ) . $i;

        return $out_trade_no;
    }
}

if(!function_exists('orderRefundApi')){

     function orderRefundApi($paymentApp,$total_fee,$refund_fee,$order_code){

        $setting['mini_appid']         = $paymentApp['app_id'];

        $setting['mini_appsecrept']    = $paymentApp['secret'];

        $setting['mini_mid']           = $paymentApp['payment']['merchant_id'];

        $setting['mini_apicode']       = $paymentApp['payment']['key'];

        $setting['apiclient_cert']     = $paymentApp['payment']['cert_path'];

        $setting['apiclient_cert_key'] = $paymentApp['payment']['key_path'];

        if(!is_file($setting['apiclient_cert'])||!is_file($setting['apiclient_cert_key'])){

            return ['return_msg'=>'未配置支付证书，或支付证书错误请重新上传','code'=>500];

        }
        defined('WX_APPID') or define('WX_APPID', $setting['mini_appid']);

        defined('WX_MCHID') or define('WX_MCHID', $setting['mini_mid']);

        defined('WX_KEY') or define('WX_KEY', $setting['mini_apicode']);

        defined('WX_APPSECRET') or define('WX_APPSECRET', $setting['mini_appsecrept']);

        defined('WX_SSLCERT_PATH') or define('WX_SSLCERT_PATH', $setting['apiclient_cert']);

        defined('WX_SSLKEY_PATH') or define('WX_SSLKEY_PATH', $setting['apiclient_cert_key']);

        defined('WX_CURL_PROXY_HOST') or  define('WX_CURL_PROXY_HOST', '0.0.0.0');

        defined('WX_CURL_PROXY_PORT') or define('WX_CURL_PROXY_PORT', 0);

        defined('WX_REPORT_LEVENL') or define('WX_REPORT_LEVENL', 0);

        require_once PAY_PATH . "/weixinpay/lib/WxPay.Api.php";

        require_once PAY_PATH . "/weixinpay/example/WxPay.JsApiPay.php";

        $input = new \WxPayRefund();

        $input->SetTotal_fee($total_fee*100);

        $input->SetRefund_fee($refund_fee*100);

        $input->SetOut_refund_no(WX_MCHID.date("YmdHis"));

        $input->SetTransaction_id($order_code);

        $input->SetOp_user_id(WX_MCHID);

        $order = \WxPayApi::refund($input);

        return $order;

    }
}



if(!function_exists('getdistance')){

/**
 * User: chenniang
 * Date: 2019-10-18 16:00
 * @param $lng1
 * @param $lat1
 * @param $lng2
 * @param $lat2
 * @return float|int
 * descption:获取距离
 */
   function getdistance($lng1, $lat1, $lng2, $lat2) {
        $radLat1 = deg2rad($lat1); //deg2rad()函数将角度转换为弧度
        $radLat2 = deg2rad($lat2);
        $radLng1 = deg2rad($lng1);
        $radLng2 = deg2rad($lng2);
        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;

        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000;
        return $s;


    }
}
if(!function_exists('getDistances')){

function getDistances($longitude1, $latitude1, $longitude2, $latitude2, $unit=2, $decimal=2){

    $EARTH_RADIUS = 6370.996; // 地球半径系数
    $PI = 3.1415926;

    $radLat1 = $latitude1 * $PI / 180.0;
    $radLat2 = $latitude2 * $PI / 180.0;

    $radLng1 = $longitude1 * $PI / 180.0;
    $radLng2 = $longitude2 * $PI /180.0;

    $a = $radLat1 - $radLat2;
    $b = $radLng1 - $radLng2;

    $distance = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1) * cos($radLat2) * pow(sin($b/2),2)));
    $distance = $distance * $EARTH_RADIUS * 1000;

//    if($unit==2){
//        $distance = $distance / 1000;
//    }

    return $distance;

}
}


if(!function_exists('checkPass')){

    function checkPass ($pass){

        return md5('shequ'.$pass);

    }


}


if(!function_exists('initLogin')){

    function initLogin ($uniacid = 666){

        $admin_model = new \app\massage\model\Admin();

        $admin = $admin_model->dataInfo(['uniacid'=>$uniacid]);

        if(empty($admin)){

            $insert = [

                'uniacid' => $uniacid,

                'username'=> 'admin',

                'passwd'  => checkPass('admin123'),

                'create_time' => time()
            ];

            $admin_model->dataAdd($insert);

        }

        return true;

    }


}

if(!function_exists('setUserForToken')){

    function setUserForToken($token ,$user) {

        return setCache("Token_" . $token ,$user ,86400);
    }
}



if(!function_exists('is_time_cross')){

    /**
     * PHP计算两个时间段是否有交集（边界重叠不算）
     *
     * @param string $beginTime1 开始时间1
     * @param string $endTime1 结束时间1
     * @param string $beginTime2 开始时间2
     * @param string $endTime2 结束时间2
     * @return bool
     */
    function is_time_cross($beginTime1 = '', $endTime1 = '', $beginTime2 = '', $endTime2 = '') {

        $status = $beginTime2 - $beginTime1;

        if ($status > 0) {

            $status2 = $beginTime2 - $endTime1;

            if ($status2 >= 0) {

                return true;

            } else {

                return false;
            }
        } else {

            $status2 = $endTime2 - $beginTime1;

            if ($status2 > 0) {

                return false;

            } else {

                return true;
            }

        }

    }
}


if(!function_exists('is_time_crossV2')){

    /**
     * PHP计算两个时间段是否有交集（边界重叠不算）
     *
     * @param string $beginTime1 开始时间1
     * @param string $endTime1 结束时间1
     * @param string $beginTime2 开始时间2
     * @param string $endTime2 结束时间2
     * @return bool
     */
    function is_time_crossV2($beginTime1 = '', $endTime1 = '', $beginTime2 = '', $endTime2 = '') {

        $status = $beginTime2 - $beginTime1;

        if ($status > 0) {

            $status2 = $beginTime2 - $endTime1;

            if ($status2 > 0) {

                return true;

            } else {

                return false;
            }
        } else {

            $status2 = $endTime2 - $beginTime1;

            if ($status2 >= 0) {

                return false;

            } else {

                return true;
            }

        }

    }
}

if(!function_exists('distance_text')){

    /**
     * PHP计算两个时间段是否有交集（边界重叠不算）
     *
     * @param string $beginTime1 开始时间1
     * @param string $endTime1 结束时间1
     * @param string $beginTime2 开始时间2
     * @param string $endTime2 结束时间2
     * @return bool
     */
    function distance_text($distance) {

        if($distance>1000){

            $distance = round($distance/1000,2);

            $text = $distance.'km';
        }else{

            $text = round($distance,2).'m';

        }

        return $text;

    }
}


if(!function_exists('getCode')){

    function getCode($uniacid,$data,$type=1,$page='pages/home'){

        if($type==1){

            $model = new WxSetting($uniacid);

            $data = $model->phpQrCode($data);

        }else{
            //小程序码
            $data = longbingCreateWxCode($uniacid,$data,$page,1);

            $data = transImagesOne($data ,['qr_path'] ,$uniacid);

            $data = $data['qr_path'];

        }

        return $data;

    }

}

if(!function_exists('base64ToPng')){
    /**
     * @author chenniang
     * @DataTime: 2021-07-07 15:22
     * @功能说明:base64转图片
     */
    function base64ToPng($v){

        if(!empty($v)){

            $path = MATER_UPLOAD_PATH.date('Y-m-d',time()).'/img';

            if (!file_exists($path)){

                mkdir ($path,0777,true);
            }

            if (strpos($v, 'https://') !== false) {

                $file_arr[] = $v;

            } else {

                if (strstr($v,",")){

                    $v = explode(',',$v);

                    $v = $v[1];
                }

                $imageName = "/25220_".date("His",time())."_".rand(1111,9999).'.jpg';

                file_put_contents($path.$imageName, base64_decode($v));

                $file = str_replace(FILE_UPLOAD_PATH,HTTPS_PATH,$path.$imageName);

            }

            return $file;

        }

        return [];

    }

}
if(!function_exists('getCityByLongLat')) {

    function getCityByLongLat($lng, $lat,$uniacid)
    {

        $dis = [

            'uniacid' => $uniacid
        ];

        $config_model = new Config();

        $config = $config_model->dataInfo($dis);

        $map_secret = !empty($config['map_secret'])?$config['map_secret']:'bViFglag7C7G7QlZ1MglFyvh40yK1Tir';

        $URL  = "https://apis.map.qq.com/ws/geocoder/v1/?location=$lat,$lng&key=$map_secret";

        $data =  longbingCurl($URL,[]);

        $data =  json_decode($data,true);

        $data = !empty($data['result']['address_component']['city'])?$data['result']['address_component']['city']:'';

        return $data;

    }
}


if(!function_exists('getCityNumber')) {

    function getCityNumber($uniacid)
    {

        $a = new PermissionMassage($uniacid,[]);

        $num = $a->getCityNumber();

        return $num;
    }
}



if(!function_exists('getDriveDistance')) {

    /**
     * @param $start_lang
     * @param $start_lat
     * @param $end_lng
     * @param $end_lat
     * @param $uniacid
     * @功能说明:计算两地的驾驶距离
     * @author chenniang
     * @DataTime: 2022-10-17 12:01
     */
    function getDriveDistance($start_lang,$start_lat, $end_lng,$end_lat,$uniacid)
    {

        $dis = [

            'uniacid' => $uniacid
        ];

        $start = "$start_lat,$start_lang";

        $end   = "$end_lat,$end_lng";

        $config_model = new Config();

        $config = $config_model->dataInfo($dis);

        $key = !empty($config['map_secret'])?$config['map_secret']:'bViFglag7C7G7QlZ1MglFyvh40yK1Tir';; //腾讯地图开发自己申请

        $mode = 'driving'; //driving(驾车)、walking(步行)

        $from = $start; //例如：39.14122,117.14428

        $to = $end; //例如(格式：终点坐标;起点坐标)：39.10149,117.10199;39.14122,117.14428

        $url = 'https://apis.map.qq.com/ws/distance/v1/?mode='.$mode.'&from='.$from.'&to='.$to.'&key='.$key;

        $info = file_get_contents($url);
        //如果请求失败用直线距离
        if(empty($info)){

            getDistances($start_lang,$start_lat, $end_lng,$end_lat);
        }

        $info = json_decode($info, true);

        if(!empty($info['message'])&&$info['message']=='query ok'&&!empty($info['result']['elements'][0]['distance'])){

          return $info['result']['elements'][0]['distance'];
        }

        getDistances($start_lang,$start_lat, $end_lng,$end_lat);

    }
}

if(!function_exists('object_array')) {

    function object_array($array)
    {
        if (is_object($array)) {
            $array = (array)$array;
        }
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $array[$key] = object_array($value);
            }
        }
        return $array;
    }
}



if(!function_exists('getIP')) {

     function getIP(){
        global $ip;
        if (getenv("HTTP_CLIENT_IP"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if(getenv("HTTP_X_FORWARDED_FOR"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if(getenv("REMOTE_ADDR"))
            $ip = getenv("REMOTE_ADDR");
        else $ip = "Unknow";
        return $ip;
    }
}




