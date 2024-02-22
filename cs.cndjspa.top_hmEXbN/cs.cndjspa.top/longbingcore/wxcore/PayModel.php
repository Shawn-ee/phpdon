<?php
declare(strict_types=1);

namespace longbingcore\wxcore;

use AopCertClient;
use app\ApiRest;
use Exception;
use think\App;
use think\facade\Db;

class PayModel extends ApiRest {

   // static protected $uniacid;

    protected $pay_config_data;

    public function __construct($pay_config)
    {
        $this->pay_config_data = $pay_config;

    }


    /**
     * @author chenniang
     * @DataTime: 2022-08-17 14:36
     * @功能说明:
     */
    public function findOrder(){

        $pay_config = $this->payConfig();

        require_once  EXTEND_PATH.'alipay/aop/AopClient.php';

        require_once  EXTEND_PATH.'alipay/aop/request/AlipayTradeQueryRequest.php';

        $aop = new \AopClient ();

        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
       // $aop->gatewayUrl = 'https://openapi.alipaydev.com/gateway.do';

        $aop->appId = $pay_config[ 'payment' ][ 'ali_appid' ];

        $aop->rsaPrivateKey = $pay_config['payment']['ali_privatekey'];

        $aop->alipayrsaPublicKey=$pay_config['payment']['ali_publickey'];
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA2';
        $aop->postCharset='UTF-8';
        $aop->format='json';
        $object = new \stdClass();
        $object->out_trade_no = '20150320010101001';
//$object->trade_no = '2014112611001004680073956707';
        $json = json_encode($object);
        $request = new \AlipayTradeQueryRequest();
        $request->setBizContent($json);

        $result = $aop->execute ( $request);

        return $result;
    }


    /**
     * @author chenniang
     * @DataTime: 2022-08-10 16:36
     * @功能说明:支付宝支付
     */
    public function aliPay($order_code,$price,$subject,$type=1){

        require_once  EXTEND_PATH.'alipay/aop/AopClient.php';

        require_once  EXTEND_PATH.'alipay/aop/request/AlipayTradeAppPayRequest.php';
        require_once  EXTEND_PATH.'alipay/aop/request/AlipayTradeWapPayRequest.php';

        $pay_config = $this->pay_config_data;

        $aop = new \AopClient ();

        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';

        $aop->appId =  $pay_config[ 'payment' ][ 'ali_appid' ];

        $aop->rsaPrivateKey     = $pay_config['payment']['ali_privatekey'];;

        $aop->alipayrsaPublicKey= $pay_config['payment']['ali_publickey'];;

        $aop->apiVersion = '1.0';

        $aop->signType = 'RSA2';

        $aop->postCharset='UTF-8';

        $aop->format='json';

        $object = new \stdClass();

        $object->out_trade_no = $order_code;

        $object->total_amount = $price;

        $object->subject = $subject;

        $object->product_code ='QUICK_MSECURITY_PAY';

        //$object->time_expire = date('Y-m-d H:i:s',time());

        $json = json_encode($object);
        //1app支付 0web
        $request = $pay_config['is_app']==1?new \AlipayTradeAppPayRequest():new \AlipayTradeWapPayRequest();

        if($type==1){

            $request->setNotifyUrl("https://".$_SERVER['HTTP_HOST'].'/index.php/massage/IndexWxPay/aliNotify');
        }else{

            $request->setNotifyUrl("https://".$_SERVER['HTTP_HOST'].'/index.php/massage/IndexWxPay/aliNotifyBalance');
        }

        $request->setBizContent($json);

        $result = $pay_config['is_app']==1?$aop->sdkExecute ( $request):$aop->pageExecute($request);

        return $result;

    }


    /**
     * @author chenniang
     * @DataTime: 2022-08-11 17:23
     * @功能说明:退款
     */
    public function aliRefund($order_code,$price){

        require_once  EXTEND_PATH.'alipay/aop/AopClient.php';

        require_once  EXTEND_PATH.'alipay/aop/request/AlipayTradeRefundRequest.php';

        $pay_config = $this->pay_config_data;

        $aop = new \AopClient ();

        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';

        $aop->appId = $pay_config[ 'payment' ][ 'ali_appid' ];

        $aop->rsaPrivateKey     = $pay_config['payment']['ali_privatekey'];;

        $aop->alipayrsaPublicKey= $pay_config['payment']['ali_publickey'];;

        $aop->apiVersion = '1.0';

        $aop->signType = 'RSA2';

        $aop->postCharset='UTF-8';

        $aop->format='json';

        $object = new \stdClass();

        $object->trade_no = $order_code;

        $object->refund_amount = $price;

        $object->out_request_no = 'HZ01RF001';

        $json = json_encode($object);

        $request = new \AlipayTradeRefundRequest();

        $request->setBizContent($json);

        $result = $aop->execute ( $request);

        $result = !empty($result)?object_array($result):[];

        return $result;

    }


    /**
     * @param $alipayUserId
     * @param $nMoney
     * @功能说明:支付宝转账到账户（密钥模式）
     * @author chenniang
     * @DataTime: 2023-01-19 15:34
     */
    public function onPaymentByAlipay($alipayUserId, $nMoney){

        $pay_config = $this->pay_config_data;

        require_once  EXTEND_PATH.'alipay/aop/AopClient.php';

        require_once  EXTEND_PATH.'alipay/aop/request/AlipayFundTransToaccountTransferRequest.php';

        $aop = new \AopClient ();

        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $aop->appId = $pay_config['payment']['ali_appid'];
       // $aop->appId = 11;

        $aop->rsaPrivateKey =  $pay_config['payment']['ali_privatekey'];
        $aop->alipayrsaPublicKey=$pay_config['payment']['ali_publickey'];
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA2';
        $aop->postCharset='UTF-8';
        $aop->format='json';
        $request = new \AlipayFundTransToaccountTransferRequest ();

        $biz_content = [

            'out_biz_no' => orderCode(),

            'payee_type' => "ALIPAY_LOGONID",

            'payee_account' => $alipayUserId,

            'amount' => $nMoney,
        ];

        $request->setBizContent(json_encode($biz_content,256));

        $result = $aop->execute($request);

        $result = !empty($result)?object_array($result):[];

         return $result;

    }










}