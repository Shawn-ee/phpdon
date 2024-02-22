<?php
namespace app\reminder\controller;
use app\AdminRest;
use app\ApiRest;
use app\reminder\model\Config;
use app\virtual\model\PlayRecord;
use longbingcore\wxcore\PayNotify;
use think\App;
use think\facade\Db;
use WxPayApi;


class CallBack  extends ApiRest
{

    protected $app;

    public function __construct ( App $app )
    {
        $this->app = $app;
    }


    /**
     * @author chenniang
     * @DataTime: 2022-12-09 14:13
     * @功能说明:语音通知定时任务
     */
    public function timingSendCalled(){

        $called_model = new Config();

        $res = $called_model->timingSendCalled($this->_uniacid);

        return $this->success($res);
    }



}
