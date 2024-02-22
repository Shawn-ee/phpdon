<?php
namespace app\massage\model;

use AlibabaCloud\Client\AlibabaCloud;
use app\BaseModel;
use Exception;
use think\facade\Db;

class ShortCodeConfig extends BaseModel
{
    //定义表名
    protected $name = 'massage_short_code_config';


    /**
     * @author chenniang
     * @DataTime: 2020-09-29 11:04
     * @功能说明:添加
     */
    public function dataAdd($data){

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
    public function dataList($dis,$page){

        $data = $this->where($dis)->order('id desc')->paginate($page)->toArray();

        return $data;

    }


    /**
     * @author chenniang
     * @DataTime: 2020-09-29 11:43
     * @功能说明:
     */
    public function dataInfo($dis){

        $data = $this->where($dis)->find();

        if(empty($data)){

            $this->dataAdd($dis);

            $data = $this->where($dis)->find();

        }

        return !empty($data)?$data->toArray():[];

    }


    /**
     * @param $uniacid
     * @功能说明:
     * @author chenniang
     * @DataTime: 2023-02-03 10:39
     */
    public function initData($uniacid){

        $data = $this->dataInfo(['uniacid'=>$uniacid]);

        $config_model = new Config();

        $config = $config_model->dataInfo(['uniacid'=>$uniacid]);
        //开始初始化
        if(!empty($config['short_sign'])){

            $update = [

                'short_sign' => $config['short_sign'],
                'order_short_code' => $config['order_short_code'],
                'refund_short_code' => $config['refund_short_code'],
                'help_short_code' => $config['help_short_code'],
                'short_code' => $config['short_code'],
                'short_code_status' => $config['short_code_status'],
            ];

            $this->dataUpdate(['id'=>$data['id']],$update);

            $prefix = longbing_get_prefix();
            //执行sql删除废弃字段
            $sql = <<<updateSql
            
ALTER TABLE `{$prefix}shequshop_school_config` DROP COLUMN  `short_sign`;
ALTER TABLE `{$prefix}shequshop_school_config` DROP COLUMN  `order_short_code`;
ALTER TABLE `{$prefix}shequshop_school_config` DROP COLUMN  `refund_short_code`;
ALTER TABLE `{$prefix}shequshop_school_config` DROP COLUMN  `help_short_code`;
ALTER TABLE `{$prefix}shequshop_school_config` DROP COLUMN  `short_code`;
ALTER TABLE `{$prefix}shequshop_school_config` DROP COLUMN  `short_code_status`;
                

updateSql;

            $sql = str_replace(PHP_EOL, '', $sql);
            $sqlArray = explode(';', $sql);

            foreach ($sqlArray as $_value) {
                if(!empty($_value)){

                    try{
                        Db::query($_value) ;
                    }catch (\Exception $e){
                        if (!APP_DEBUG){

                        }

                    }
                }
            }

        }

        return true;
    }


    /**
     * @param $str_phone
     * @param $uniacid
     * @功能说明:发送短信验证码
     * @author chenniang
     * @DataTime: 2022-03-14 10:43
     */
    public function sendSms($str_phone,$uniacid,$order_code,$type=1){

        $dis = [

            'uniacid' => $uniacid
        ];

        $config = $this->dataInfo($dis);

        $setting_model = new Config();

        $setting = $setting_model->dataInfo($dis);

        $keyId     = trim($setting['short_id']);

        $keySecret = trim($setting['short_secret']);

        $SignName  = trim($config['short_sign']);

        if($type==1){

            $TemplateCode = trim($config['order_short_code']);

        }else{

            $TemplateCode = trim($config['refund_short_code']);

        }

        if(empty($keyId)||empty($keySecret)||empty($TemplateCode)){

            return false;
        }


        AlibabaCloud::accessKeyClient($keyId, $keySecret)->regionId('cn-hangzhou') // replace regionId as you need
        ->asDefaultClient();
//        dump(1);exit;

        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->options([
                    'query' => [
                        'RegionId' => "default",
                        'PhoneNumbers' => $str_phone,
                        //必填项 签名(需要在阿里云短信服务后台申请)
                        'SignName' => $SignName,
                        //必填项 短信模板code (需要在阿里云短信服务后台申请)
                        'TemplateCode' => $TemplateCode,
                        //如果在短信中添加了${code} 变量则此项必填 要求为JSON格式
                        'TemplateParam' => "{'name':$order_code}",
                    ],
                ])
                ->request();

            return !empty($result)?$result->toArray():[];
        } catch(Exception $e)
        {}
    }




    /**
     * @param $str_phone
     * @param $uniacid
     * @功能说明:发送短信验证码
     * @author chenniang
     * @DataTime: 2022-03-14 10:43
     */
    public function sendSmsCode($str_phone,$uniacid){

        $dis = [

            'uniacid' => $uniacid
        ];

        $config = $this->dataInfo($dis);

        $setting_model = new Config();

        $setting   = $setting_model->dataInfo($dis);

        $keyId     = trim($setting['short_id']);

        $keySecret = trim($setting['short_secret']);

        $SignName = $config['short_sign'];

        $TemplateCode = $config['short_code'];

        if(empty($keyId)||empty($keySecret)||empty($TemplateCode)){

            return false;
        }
        $code = mt_rand(100000,999999);

        setCache($str_phone,$code,600,$uniacid);

        AlibabaCloud::accessKeyClient($keyId, $keySecret)->regionId('cn-hangzhou') // replace regionId as you need
        ->asDefaultClient();

        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->options([
                    'query' => [
                        'RegionId' => "default",
                        'PhoneNumbers' => $str_phone,
                        //必填项 签名(需要在阿里云短信服务后台申请)
                        'SignName' => $SignName,
                        //必填项 短信模板code (需要在阿里云短信服务后台申请)
                        'TemplateCode' => $TemplateCode,
                        //如果在短信中添加了${code} 变量则此项必填 要求为JSON格式
                        'TemplateParam' => "{'code':$code}",
                    ],
                ])
                ->request();


            return !empty($result)?$result->toArray():[];
        } catch(Exception $e)
        {}
    }



    /**
     * @param $str_phone
     * @param $uniacid
     * @功能说明:发送求救通知
     * @author chenniang
     * @DataTime: 2022-03-14 10:43
     */
    public function sendHelpCode($uniacid,$coach_id,$address){

        $address = !empty($address)?$address:'暂无';

        $dis = [

            'uniacid' => $uniacid
        ];

        $config = $this->dataInfo($dis);

        $setting_model = new Config();

        $setting   = $setting_model->dataInfo($dis);

        $keyId     = trim($setting['short_id']);

        $keySecret = trim($setting['short_secret']);

        $SignName = $config['short_sign'];

        $TemplateCode = $config['help_short_code'];

        if(empty($keyId)||empty($keySecret)||empty($TemplateCode)){

            return false;
        }

        $help_cofig_model = new HelpConfig();

        $str_phone = $help_cofig_model->where(['uniacid'=>$uniacid])->value('help_phone');

        if(empty($str_phone)){

            return false;
        }

        $coach_model= new Coach();

        $coach_name= $coach_model->where(['id'=>$coach_id])->value('coach_name');

        AlibabaCloud::accessKeyClient($keyId, $keySecret)->regionId('cn-hangzhou') // replace regionId as you need
        ->asDefaultClient();

        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->options([
                    'query' => [
                        'RegionId' => "default",
                        'PhoneNumbers' => $str_phone,
                        //必填项 签名(需要在阿里云短信服务后台申请)
                        'SignName' => $SignName,
                        //必填项 短信模板code (需要在阿里云短信服务后台申请)
                        'TemplateCode' => $TemplateCode,
                        //如果在短信中添加了${code} 变量则此项必填 要求为JSON格式
                        //'TemplateParam' => "{'name':$coach_name,'address':$address}",

                        'TemplateParam' => json_encode(['name'=>$coach_name.'(ID:'.$coach_id.')','address'=>$address]),
                    ],
                ])
                ->request();


            return !empty($result)?$result->toArray():[];
        } catch(Exception $e)
        {}
    }



}