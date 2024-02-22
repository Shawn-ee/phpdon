<?php
namespace app\massage\model;

use app\BaseModel;
use longbingcore\wxcore\WxSetting;
use think\facade\Db;

class Police extends BaseModel
{
    //定义表名
    protected $name = 'massage_service_coach_police';






    /**
     * @author chenniang
     * @DataTime: 2020-09-29 11:04
     * @功能说明:添加
     */
    public function dataAdd($data){

        $data['create_time'] = time();

        $res = $this->insert($data);

        return $res;

    }



    /**
     * @author chenniang
     * @DataTime: 2020-09-29 11:05
     * @功能说明:编辑
     */
    public function dataUpdate($dis,$data){

        $res = $this->where($dis)->update($data);

        return $res;

    }


    /**
     * @author chenniang
     * @DataTime: 2020-09-29 11:06
     * @功能说明:列表
     */
    public function dataList($dis,$page=10){

//        $data = $this->where($dis)->order('top desc,id desc')->paginate($page)->toArray();

        $data = $this->alias('a')
                ->join('massage_service_coach_list b','b.id = a.coach_id')
                ->where($dis)
                ->field('a.*,b.coach_name')
                ->group('a.id')
                ->order('a.id desc')
                ->paginate($page)
                ->toArray();



        return $data;

    }


    /**
     * @author chenniang
     * @DataTime: 2020-09-29 11:43
     * @功能说明:
     */
    public function dataInfo($dis){

        $data = $this->where($dis)->find();

        return !empty($data)?$data->toArray():[];

    }



    /**
     * @author chenniang
     * @DataTime: 2021-04-01 09:51
     * @功能说明:技师求救通知小程序
     */
    public function helpSendMsgWechat($uniacid,$coach_id,$address,$openid)
    {

        $cap_model = new Coach();

        $config_model = new SendMsgConfig();

        $config_model->initData($uniacid);

        $x_config = $config_model->dataInfo(['uniacid'=>$uniacid]);

        $config = longbingGetAppConfig($uniacid);

        if (empty($x_config['gzh_appid']) || empty($x_config['help_tmpl_id'])) {

            return false;
        }

        $coach_name = $cap_model->where(['id'=>$coach_id])->value('coach_name');

        $access_token = longbingGetAccessToken($uniacid);

        $page = "/pages/index";
        //post地址
        $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/uniform_send?access_token={$access_token}";

        $data = [
            //用户小程序openid
            'touser' => $openid,

            'mp_template_msg' => [
                //公众号appid
                'appid' => $x_config['gzh_appid'],

                "url" => "http://weixin.qq.com/download",
                //公众号模版id
                'template_id' => $x_config['help_tmpl_id'],

                'miniprogram' => [
                    //小程序appid
                    'appid' => $config['appid'],
                    //跳转小程序地址
                    'page' => $page,
                ],

                'data' => array(

                    //服务名称
                    'keyword1' => array(

                        'value' => $coach_name,

                        'color' => '#93c47d',
                    ),
                    //下单人
                    'keyword2' => array(
                        //内容
                        'value' => $address,

                        'color' => '#0000ff',
                    ),
                    'keyword3' => array(
                        //内容
                        'value' => date('Y-m-d H:i',time()),

                        'color' => '#0000ff',
                    ),


                )

            ]

        ];

        $data = json_encode($data);

        $tmp = [

            'url' => $url,

            'data' => $data,
        ];
        $rest = lbCurlPost($tmp['url'], $tmp['data']);

        $rest = json_decode($rest, true);

        return $rest;

    }


    /**
     * @author chenniang
     * @DataTime: 2021-04-01 09:51
     * @功能说明:技师求救通知公众号
     */
    public function helpSendMsgWeb($uniacid,$coach_id,$address,$openid)
    {

        $cap_model = new Coach();

        $config_model = new SendMsgConfig();

        $config_model->initData($uniacid);

        $x_config = $config_model->dataInfo(['uniacid'=>$uniacid]);

        if (empty($x_config['gzh_appid']) || empty($x_config['help_tmpl_id'])) {

            return false;
        }

        $coach_name = $cap_model->where(['id'=>$coach_id])->value('coach_name');

        $wx_setting = new WxSetting($uniacid);

        $access_token = $wx_setting->getGzhToken();

        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$access_token}";

        $data = [
            //用户小程序openid
            'touser' => $openid,
            //公众号appid
            'appid' => $x_config['gzh_appid'],

            "url" => 'https://' . $_SERVER['HTTP_HOST'] . '/h5/',
            //公众号模版id
            'template_id' => $x_config['help_tmpl_id'],

            'data' => array(

                //服务名称
                'keyword1' => array(

                    'value' => $coach_name,

                    'color' => '#93c47d',
                ),
                'keyword2' => array(

                    'value' => $address,

                    'color' => '#93c47d',
                ),
                'keyword3' => array(

                    'value' => date('Y-m-d H:i', time()),

                    'color' => '#93c47d',
                )


            )

        ];

        $data = json_encode($data);

        $tmp = [

            'url' => $url,

            'data' => $data,
        ];
        $rest = lbCurlPost($tmp['url'], $tmp['data']);

        $rest = json_decode($rest, true);

        return $rest;

    }



    /**
     * @author chenniang
     * @DataTime: 2022-06-01 15:17
     * @功能说明:发送技师求救消息
     */
    public function helpSendMsg($uniacid,$coach_id,$address)
    {

        $help_model = new HelpConfig();

        $help_user  = $help_model->where(['uniacid'=>$uniacid])->value('help_user_id');

        $help_user  = !empty($help_user)?explode(',',$help_user):[];

        $user_model = new User();

        $user_list = $user_model->where('id','in',$help_user)->select()->toArray();

        if (empty($user_list)) {

            return false;
        }

        foreach ($user_list as $user_info){
            //pe 1小程序 2公众号
            $type = $user_info['last_login_type'] == 0 && !empty($user_info['wechat_openid']) ? 1 : 2;

            if ($type == 1) {

                $res = $this->helpSendMsgWechat($uniacid,$coach_id,$address,$user_info['wechat_openid']);

            } else {

                $res = $this->helpSendMsgWeb($uniacid,$coach_id,$address,$user_info['web_openid']);

            }
        }

        return $res;

    }




}