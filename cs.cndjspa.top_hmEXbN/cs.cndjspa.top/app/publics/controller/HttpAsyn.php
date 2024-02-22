<?php
namespace app\publics\controller;
use app\BaseController;
use app\card\service\UserService;
use think\facade\Db;
use think\facade\Log;
use think\facade\Request;

class HttpAsyn extends BaseController {


    public function message(){


        $param = Request::param();

        $data = json_decode($param['message'],true) ;

        //try{
        switch ( $action = $data['action']  )
        {
            //发送消息服务通知
            case 'sendMessageWxServiceNotice':
                longbingSendMessageWxServiceNotice($data['message']);
                break;
            //发送普通服务通知
            case 'SendWxServiceNotice':
                longbingSendWxServiceNotice($data['count_id']);
                break;
            //发送普通服务通知
            case 'longbingSendWxServiceNotice':
                longbingSendWxServiceNotice($data['count_id']);
                break;
            case 'longbingSendWxServiceNoticeBase':
                longbingSendWxServiceNoticeBase($data['data']);
                break;
            case 'updatecollectionRate':
                //updatecollectionRate($data['client_id']);
                break;
            case 'updateCustomerRate':
                //updateCustomerRate($data['page'] ,$data['page_count']);
                break;
            case 'longbingCreateWxCode':
                longbingCreateWxCode($data['uniacid'] ,$data['data'] ,$data['page'] ,$data['type']);
                break;
            case 'longbingCreateSharePng':
                UserService::createHeaderQr($data['uniacid'],['staff_id'=> $data['user_id']]);
                longbingCreateSharePng($data['gData'] ,$data['user_id'] ,$data['uniacid']);
                break;
            case 'longbingSaveFormId':
                longbingSaveFormId($data['data']);
                break;
            case 'longbingCreateHeaderQr':
                UserService::createHeaderQr($data['uniacid'],['staff_id'=> $data['user_id']]);
                break;

        }
        //}catch(Exception $e)
        //{}
        echo 'message ok ';

    }

}
