<?php
namespace app\massage\model;

use AlibabaCloud\Client\AlibabaCloud;
use app\BaseModel;
use Exception;
use think\facade\Db;

class SendMsgConfig extends BaseModel
{
    //定义表名
    protected $name = 'massage_send_msg_config';


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
        if(!empty($config['gzh_appid'])){

            $update = [

                'help_tmpl_id' => $config['help_tmpl_id'],
                'order_tmp_id' => $config['order_tmp_id'],
                'cancel_tmp_id' => $config['cancel_tmp_id'],
                'coachupdate_tmp_id' => $config['coachupdate_tmp_id'],
                'gzh_appid' => $config['gzh_appid'],
            ];

            $this->dataUpdate(['id'=>$data['id']],$update);

            $prefix = longbing_get_prefix();
            //执行sql删除废弃字段
            $sql = <<<updateSql
            
ALTER TABLE `{$prefix}shequshop_school_config` DROP COLUMN  `help_tmpl_id`;
ALTER TABLE `{$prefix}shequshop_school_config` DROP COLUMN  `order_tmp_id`;
ALTER TABLE `{$prefix}shequshop_school_config` DROP COLUMN  `cancel_tmp_id`;
ALTER TABLE `{$prefix}shequshop_school_config` DROP COLUMN  `coachupdate_tmp_id`;
ALTER TABLE `{$prefix}shequshop_school_config` DROP COLUMN  `gzh_appid`;

                

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

}