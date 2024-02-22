<?php
namespace app\massage\model;

use app\BaseModel;
use think\facade\Db;

class ChannelList extends BaseModel
{
    //定义表名
    protected $name = 'massage_channel_list';


    protected $append = [

        'cate_text'

    ];


    /**
     * @param $value
     * @param $data
     * @功能说明:返回渠道
     * @author chenniang
     * @DataTime: 2022-09-02 16:32
     */
    public function getCateTextAttr($value,$data){

        if(isset($data['cate_id'])){

            $cate_model = new ChannelCate();

            return $cate_model->where(['id'=>$data['cate_id']])->value('title');

        }


    }

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

        return !empty($data)?$data->toArray():[];

    }



    /**
     * @author chenniang
     * @DataTime: 2021-12-30 11:26
     * @功能说明:后台列表
     */
    public function adminDataList($dis,$page=10,$where=[]){

        $data = $this->alias('a')
            ->join('massage_service_user_list b','a.user_id = b.id','left')
            ->where($dis)
            ->where(function ($query) use ($where){
                $query->whereOr($where);
            })
            ->field('a.*,b.nickName,b.avatarUrl')
            ->group('a.id')
            ->order('a.id desc')
            ->paginate($page)
            ->toArray();

        return $data;

    }

   









}