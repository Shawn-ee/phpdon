<?php


namespace app\massage\model;


use app\BaseModel;

class Feedback extends BaseModel
{
    protected $name = 'massage_service_coach_feedback';

    /**
     * 获取列表
     * @param $where
     * @param $page
     * @return mixed
     */
    public static function getList($where, $page = 10)
    {
        return self::where($where)
            ->alias('a')
            ->field('a.id,a.type_name,a.create_time,a.order_code,a.content,a.images,a.video_url,a.status,a.reply_content,a.reply_date,b.nickName as coach_name,b.phone as mobile')
            ->leftJoin('massage_service_user_list b', 'a.coach_id=b.id')
            ->order('a.create_time desc')
            ->paginate($page)->each(function ($item) {
                $item['images'] = json_decode($item['images'], true);
                $item['create_time'] = date('Y-m-d H:i:s', $item['create_time']);
                return $item;
            })->toArray();
    }

    /**
     * 单条数据
     * @param $where
     * @return mixed
     */
    public static function getInfo($where)
    {
        $data = self::where($where)
            ->alias('a')
            ->field('a.id,a.type_name,a.create_time,a.order_code,a.content,a.images,a.video_url,a.status,a.reply_content,a.reply_date,b.nickName as coach_name,b.phone as mobile,b.id as user_id')
            ->leftJoin('massage_service_user_list b', 'a.coach_id=b.id')
            ->find();
        if ($data) {
            $data['images'] = json_decode($data['images'], true);
            $data['create_time'] = date('Y-m-d H:i:s', $data['create_time']);
        }
        return $data;
    }
}