<?php
namespace app\massage\model;

use app\BaseModel;
use think\facade\Db;

class User extends BaseModel
{
    //定义表名
    protected $name = 'massage_service_user_list';


    /**
     * @author chenniang
     * @DataTime: 2021-08-29 21:18
     * @功能说明:
     */
    public function getBalanceAttr($value,$data){

        if(isset($value)){

            return round($value,2);
        }

    }

    /**
     * @author chenniang
     * @DataTime: 2021-08-29 21:18
     * @功能说明:
     */
    public function getCashAttr($value,$data){

        if(isset($value)){

            return round($value,2);
        }

    }

    /**
     * @author chenniang
     * @DataTime: 2020-09-29 11:04
     * @功能说明:添加
     */
    public function dataAdd($data){

        $data['create_time'] = time();

        $data['status']      = 1;

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
    public function dataList($dis,$page,$mapor=[]){

        $data = $this->where($dis) ->where(function ($query) use ($mapor){
            $query->whereOr($mapor);
        })->order('id desc')->paginate($page)->toArray();

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
     * @DataTime: 2020-10-27 15:42
     * @功能说明:订单自提码
     */
    public function orderQr($input,$uniacid){

        $data = longbingCreateWxCode($uniacid,$input,$input['page']);

        $data = transImagesOne($data ,['qr_path'] ,$uniacid);

        $qr   = $data['qr_path'];

        return $qr;
    }







}