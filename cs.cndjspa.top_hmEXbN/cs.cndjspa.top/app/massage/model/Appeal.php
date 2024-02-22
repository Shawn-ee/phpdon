<?php


namespace app\massage\model;


use app\BaseModel;

class Appeal extends BaseModel
{
    protected $name = 'massage_service_coach_appeal';

    /**
     * 列表
     * @param $where
     * @param int $page
     * @return mixed
     */
    public static function getList($where, $page = 10)
    {
        return self::where($where)
            ->alias('a')
            ->field('a.id,a.create_time,a.order_code,a.order_id,a.content,a.status,a.reply_content,a.reply_date,b.coach_name,b.mobile')
            ->leftJoin('massage_service_coach_list b', 'a.coach_id=b.id')
            ->order('a.create_time desc')
            ->paginate($page)->each(function ($item) {
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
            ->field('a.id,a.create_time,a.order_code,a.content,a.status,a.reply_content,a.reply_date,b.coach_name,b.mobile')
            ->leftJoin('massage_service_coach_list b', 'a.coach_id=b.id')
            ->find();
        if ($data) {
            $data['images'] = json_decode($data['images'], true);
            $data['create_time'] = date('Y-m-d H:i:s', $data['create_time']);
        }
        return $data;
    }
}