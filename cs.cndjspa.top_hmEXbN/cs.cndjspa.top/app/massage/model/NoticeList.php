<?php
namespace app\massage\model;

use app\BaseModel;
use think\facade\Db;

class NoticeList extends BaseModel
{
    //定义表名
    protected $name = 'massage_service_notice_list';


    /**
     * @author chenniang
     * @DataTime: 2021-07-16 10:44
     * @功能说明:
     */
    public function getCreateTimeAttr($value,$data){

        if(!empty($value)){

            return date('Y-m-d H:i:s',$value);

        }

    }
    /**
     * @author chenniang
     * @DataTime: 2020-09-29 11:04
     * @功能说明:添加
     */
    public function dataAdd($uniacid,$order_id,$type=1,$admin_id=0){

        $data['uniacid']  = $uniacid;

        $data['order_id'] = $order_id;

        $data['type']     = $type;

        $data['admin_id'] = $admin_id;

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

//        if(empty($data)){
//
//            $this->dataAdd($dis);
//
//            $data = $this->where($dis)->find();
//
//        }

        return !empty($data)?$data->toArray():[];

    }







}