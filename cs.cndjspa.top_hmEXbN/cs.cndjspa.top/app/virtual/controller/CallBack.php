<?php
namespace app\virtual\controller;
use app\AdminRest;
use app\ApiRest;
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
     * @DataTime: 2022-12-08 15:33
     * @功能说明:阿里云支付回调
     */
    public function aliyunCallBack(){

        $this->request = $this->app->request;

        $inputs = json_decode($this->request->getInput(), true);

        if(empty($inputs)){

            $inputs = $_POST;
        }

        $model = new PlayRecord();

        if(!empty($inputs)){

            foreach ($inputs as $input){

                $insert = [

                    'uniacid' => $this->_uniacid,

                    'pool_key'=> !empty($input['pool_key'])?$input['pool_key']:'',

                    'phone_x' => $input['secret_no'],

                    'phone_a' => $input['phone_no'],

                    'phone_b' => $input['peer_no'],

                    'call_time' => strtotime($input['call_time']),

                    'start_time' => strtotime($input['start_time']),

                    'end_time' => strtotime($input['release_time']),

                    'record_url' => !empty($input['record_url'])?$input['record_url']:'',

                    'call_type'  => !empty($input['call_type'])?$input['call_type']:0,

                    'ring_record_url' => !empty($input['ring_record_url'])?$input['ring_record_url']:'',

                    'out_id' => !empty($input['out_id'])?$input['out_id']:'',

                    'call_id' => $input['call_id'],

                    'sub_id' => $input['sub_id'],
                ];

                $model->dataAdd($insert);
            }
        }

        $res = ['code'=>0,'msg'=>'成功'];

        echo json_encode($res);exit;


    }

}
