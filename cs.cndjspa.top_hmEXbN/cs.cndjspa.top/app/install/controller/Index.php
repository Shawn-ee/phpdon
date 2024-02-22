<?php
namespace app\install\controller;
use app\admin\service\UpdateService;
use app\agent\service\AdminUserService;

class Index
{
    public function index()
    {

        $lockPath = dirname(__FILE__) .DS . 'install.lock';
        if(!file_exists($lockPath)){

            //更新数据库
            UpdateService::installSql(8888);
//
//            //添加管理员
//            $input['uuid'] = '123895549b6d11e9a5c4db13993d64a1' ;
//            $input['account'] = 'admin' ;
//            $input['passwd'] = 'admin123456' ;
//            $input['admin_id'] =  0 ;
//            $input['role_id'] =  'e1af223e997011e997cb77d35351cc48' ;
//            AdminUserService::addAdminUser(8888 ,$input) ;
//            AdminUserService::initDefaultRole() ;
//
//            $appAdminData = [
//                'id'=>'123895549b6d11e9a5c4db13993d64a2',
//                'admin_id' => '123895549b6d11e9a5c4db13993d64a1',
//                'modular_id'=> '8888',
//                'create_time' => null,
//                'update_time' => null,
//                'delete_time' => null,
//                'deleted' => '0',
//                'uniacid' => '8888'
//            ];
//            AdminUserService::bindAppAdmin($appAdminData) ;

            file_put_contents($lockPath,time());

            echo ' install ok ;' ;
        }else{
            echo ' install no ;' ;
        }



    }
}
