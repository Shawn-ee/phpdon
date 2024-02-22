<?php
// +----------------------------------------------------------------------
// | Longbing [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright Chengdu longbing Technology Co., Ltd.
// +----------------------------------------------------------------------
// | Website http://longbing.org/
// +----------------------------------------------------------------------
// | Sales manager: +86-13558882532 / +86-13330887474
// | Technical support: +86-15680635005
// | After-sale service: +86-17361005938
// +----------------------------------------------------------------------

declare(strict_types=1);

namespace app\agent\controller;


include_once LONGBING_EXTEND_PATH . 'LongbingUpgrade.php';

use app\admin\model\WxUpload;
use app\admin\service\UpdateService;
use app\AdminRest;
use app\AgentRest;
use app\diy\service\DiyService;
use longbingcore\wxcore\WxSetting;
use LongbingUpgrade;
use think\facade\Env;

class AppUpgrade extends AdminRest
{

    /**
     * @author jingshuixian
     * @DataTime: 2020-06-08 9:33
     * @功能说明: 获得升级信息
     */
    public function getUpgradeInfo(){

        $goods_name   = config('app.AdminModelList')['app_model_name'];

        $auth_uniacid =  config('app.AdminModelList')['auth_uniacid'];

        $version_no   =  config('app.AdminModelList')['version_no'];

        $upgrade      = new LongbingUpgrade($auth_uniacid , $goods_name , Env::get('j2hACuPrlohF9BvFsgatvaNFQxCBCc' , false));

        $data = $upgrade->checkAuth();

        $data['location_version_no'] =  $version_no ;

        $data['is_upgrade'] = $this->getIsUpgrade();

        $this->update();

        return $this->success( $data );
    }


    /**
     * By.jingshuixian
     * 2019年11月23日21:43:47
     * 升级脚本导入执行
     */
    public function update(){

        $key  = 'init_all_data';

        setCache($key,'',7200,$this->_uniacid);

        UpdateService::installSql($this->_uniacid);

       // UpdateService::initWeiqinConfigData();

     //   DiyService::addDefaultDiyData($this->_uniacid);
        //各个模块初始化数据事件
        //event('InitModelData');
        //处理雷达
       // lbInitRadarMsg($this->_uniacid);

        return $this->success([]);

    }
    /**
     * @author jingshuixian
     * @DataTime: 2020-06-08 18:04
     * @功能说明: 判断是否有升级权限
     */
    private function getIsUpgrade(){

       // $goods_name = config('app.AdminModelList')['app_model_name'];

        if(!longbingIsWeiqin()){

            return true;

        }else{

            return false  ;
        }
    }

    /**
     * @author jingshuixian
     * @DataTime: 2020-06-08 14:43
     * @功能说明: 升级后台系统
     */
    public function upgrade(){

        if($this->getIsUpgrade()){
            $goods_name = config('app.AdminModelList')['app_model_name'];
            $auth_uniacid =  config('app.AdminModelList')['auth_uniacid'];
            $version_no =  config('app.AdminModelList')['version_no'];

            $upgrade = new LongbingUpgrade($auth_uniacid , $goods_name , Env::get('j2hACuPrlohF9BvFsgatvaNFQxCBCc' , false));

            $file_temp_path =  ROOT_PATH . "runtime/" ;
            $toFilePath =  ROOT_PATH ;
            // 自动下载文件到  core/runtime     解压到  core/    根目是thinkphp所在目录
            $data = $upgrade->update( $toFilePath ,$file_temp_path );
            //获取数据
            $uniacid = $this->_uniacid;

            clearCache($uniacid);
            //更新数据库
            UpdateService::installSql($uniacid,0);

            $a = new WxSetting($this->_uniacid);

            $a->setH5Info();

            return $this->success( true );
        }else{
            return $this->success( [] );
        }


    }
}