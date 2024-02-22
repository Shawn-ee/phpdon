<?php
namespace app\massage\model;

use app\BaseModel;
use think\facade\Db;

class Wallet extends BaseModel
{
    //定义表名
    protected $name = 'massage_service_wallet_list';

    protected $append = [

        'service_cash'
    ];


    /**
     * @author chenniang
     * @DataTime: 2021-04-09 09:28
     * @功能说明:手续费
     */
    public function getServiceCashAttr($value,$data){

        if(isset($data['apply_cash'])&&isset($data['true_cash'])&&isset($data['pay_cash'])){

            return !empty($data['pay_cash'])?round($data['apply_cash']-$data['pay_cash'],2):round($data['apply_cash']-$data['true_cash'],2);

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
     * @DataTime: 2021-03-18 14:33
     * @功能说明:
     */
    public function datePrice($date,$uniacid,$cap_id,$end_time='',$type=1){

        $end_time = !empty($end_time)?$end_time:$date+86399;

        $dis = [];

        $dis[] = ['status','=',2];

        $dis[] = ['create_time','between',"$date,$end_time"];

        $dis[] = ['uniacid',"=",$uniacid];

        if(!empty($cap_id)){

            $dis[] = ['cap_id','=',$cap_id];
        }

        if($type==1){

            $price = $this->where($dis)->sum('true_cash');

            return round($price,2);

        }else{

            $count = $this->where($dis)->count();

            return $count;

        }

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-18 16:06
     * @功能说明:
     */
    public function adminList($dis,$page=10){

        $data = $this->alias('a')
                ->join('massage_service_coach_list b','a.coach_id = b.id','left')
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
     * @DataTime: 2021-03-30 14:36
     * @功能说明:团长提现
     */
    public function capCash($cap_id,$status=2,$type=0){

        $dis = [


            'coach_id' => $cap_id,

            'status' => $status
        ];

        if(!empty($type)){

            $dis['type'] = $type;
        }

        $price = $this->where($dis)->sum('apply_price');

        return round($price,2);


    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-30 14:36
     * @功能说明:用户提现
     */
    public function userCash($user_id,$status=2){

        $dis = [

            'user_id'=> $user_id,

            'type'   => 4
        ];

        if(!empty($status)){

            $dis['status'] = $status;
        }

        $price = $this->where($dis)->sum('apply_price');

        return round($price,2);


    }

    /**
     * @author chenniang
     * @DataTime: 2021-03-30 14:36
     * @功能说明:团长提现
     */
    public function capCashCount($cap_id,$status=2){

        $dis = [


            'cap_id' => $cap_id,

            'status' => $status
        ];

        $count = $this->where($dis)->count();

        return $count;


    }



}