<?php
namespace app\massage\model;

use app\BaseModel;
use think\facade\Db;

class Commission extends BaseModel
{
    //定义表名
    protected $name = 'massage_service_order_commission';



    protected $append = [

        'order_goods'

    ];



    public function getOrderGoodsAttr($value,$data){

        if(!empty($data['id'])){

            $order_goods_model = new CommissionGoods();

            $list = $order_goods_model->goodsList(['a.commission_id'=>$data['id']]);

            return $list;

        }

    }





    /**
     * @author chenniang
     * @DataTime: 2021-08-25 23:24
     * @功能说明:记录
     */
    public function recordList($dis,$page=10){

        $data = $this->alias('a')
                ->join('massage_service_user_list b','a.user_id = b.id','left')
                ->join('massage_service_user_list c','a.top_id = c.id','left')
                ->join('massage_service_order_list d','a.order_id = d.id','left')
                ->where($dis)
                ->field('a.*,b.nickName,c.nickName as top_name,d.order_code,d.pay_type,d.pay_price,d.transaction_id,d.car_price')
                ->group('a.id')
                ->order('a.id desc')
                ->paginate($page)
                ->toArray();

        return $data;

    }


    /**
     * @author chenniang
     * @DataTime: 2021-08-25 23:24
     * @功能说明:记录
     */
    public function recordListV2($dis,$where,$page=10){

        $data = $this->alias('a')
            ->join('massage_service_user_list b','a.user_id = b.id','left')
            ->join('massage_service_user_list c','a.top_id = c.id  AND a.type=1','left')
            ->join('massage_service_order_list d','a.order_id = d.id','left')
            ->join('shequshop_school_admin e','a.top_id = e.id AND a.type in (2,5,6)','left')
            ->join('massage_service_coach_list f','a.top_id = f.id AND a.type=3','left')
            ->where($dis)
            ->where(function ($query) use ($where){
                $query->whereOr($where);
            })
            ->field('a.*,b.nickName,c.nickName as top_name,d.order_code,d.pay_type,d.pay_price,d.transaction_id,d.car_price')
            ->group('a.id')
            ->order('a.id desc')
            ->paginate($page)
            ->toArray();

        return $data;

    }


    /**
     * @author chenniang
     * @DataTime: 2021-08-25 23:34
     * @功能说明:佣金到账
     */
    public function successCash($order_id){

        $data = $this->dataInfo(['order_id'=>$order_id,'type'=>1]);

        if(!empty($data)&&$data['status']==1&&$data['cash']>0){

            $user_model = new User();

            $user = $user_model->dataInfo(['id'=>$data['top_id']]);

            $res = $user_model->where(['id'=>$data['top_id'],'new_cash'=>$user['new_cash']])->update(['new_cash'=>$user['new_cash']+$data['cash'],'cash'=>$user['cash']+$data['cash']]);

            if($res==0){

                return $res;
            }

        }

        return 1;
    }


    /**
     * @author chenniang
     * @DataTime: 2022-11-07 16:21
     * @功能说明:代理商以及上级代理佣金到账
     */
    public function adminSuccessCash($order_id){

        $dis = [

            'order_id' => $order_id,

            'status'   => 1
        ];

        $data = $this->where($dis)->where('type','in',[2,5,6])->select()->toArray();

        $admin_model = new Admin();

        if(!empty($data)){

            foreach ($data as $v){

                $cash = $v['cash'];

                $admin = $admin_model->dataInfo(['id'=>$v['admin_id']]);

                if(!empty($admin)&&$cash>0){

                    $res = $admin_model->where(['id'=>$v['admin_id'],'cash'=>$admin['cash']])->update(['cash'=>Db::raw("cash+$cash")]);

                    if($res==0){

                        return $res;
                    }
                }

            }

        }
        //结束所有佣金
        $this->dataUpdate(['order_id'=>$order_id],['status'=>2,'cash_time'=>time()]);

        return true;

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

        $data['update_time'] = time();

        $res = $this->where($dis)->update($data);

        return $res;

    }


    /**
     * @author chenniang
     * @DataTime: 2020-09-29 11:06
     * @功能说明:列表
     */
    public function dataList($dis,$page=10){

        $data = $this->where($dis)->order('top desc,id desc')->paginate($page)->toArray();

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
     * @DataTime: 2021-08-26 23:39
     * @功能说明:添加佣金
     */
    public function commissionAdd($order){
        //技师佣金
        $this->coachCommission($order);
        //加盟商佣金
        $this->adminCommission($order);

        $user_model = new User();
        //上级
        $top = $user_model->where(['id'=>$order['user_id']])->value('pid');

        if(!empty($top)){

            $ser_model = new Service();

            $com_mdoel = new Commission();

            $com_goods_mdoel = new CommissionGoods();

            foreach ($order['order_goods'] as $v){
                //查看是否有分销
                $ser = $ser_model->dataInfo(['id'=>$v['goods_id']]);

                if(!empty($ser['com_balance'])){

                    $insert = [

                        'uniacid' => $order['uniacid'],

                        'user_id' => $order['user_id'],

                        'top_id'  => $top,

                        'order_id'=> $order['id'],

                        'order_code' => $order['order_code'],

                    ];

                   $find = $com_mdoel->dataInfo($insert);

                   $cash = $v['true_price']*$ser['com_balance']/100*$v['num'];

                   if(empty($find)){

                       $insert['cash'] = $cash;

                       $com_mdoel->dataAdd($insert);

                       $id = $com_mdoel->getLastInsID();

                   }else{

                       $id = $find['id'];

                       $update = [

                           'cash' => $find['cash']+$cash
                       ];
                        //加佣金
                       $com_mdoel->dataUpdate(['id'=>$find['id']],$update);

                   }

                   $insert = [

                       'uniacid' => $order['uniacid'],

                       'order_goods_id' => $v['id'],

                       'commission_id'  => $id,

                       'cash'           => $cash,

                       'num'            => $v['num'],

                       'balance'        => $ser['com_balance']
                   ];
                   //添加到自订单记录表
                   $res = $com_goods_mdoel->dataAdd($insert);

                }

            }

        }

        return true;

    }






    /**
     * @author chenniang
     * @DataTime: 2021-08-26 23:39
     * @功能说明:添加佣金
     */
    public function commissionAddData($order){

        $user_model = new User();

        $config_model = new Config();

        $config = $config_model->dataInfo(['uniacid'=>$order['uniacid']]);

        $dis = [

            'id' => $order['user_id'],

        ];
        //上级
        $top_id = $user_model->where($dis)->value('pid');

        $top = $user_model->dataInfo(['id'=>$top_id]);

        $total_cash = 0;

        if(!empty($top)){

            if($config['fx_check']==1&&$top['is_fx']==0){

                return $total_cash;
            }

            $top = $top['id'];

            $ser_model = new Service();

            $com_mdoel = new Commission();

            $com_goods_mdoel = new CommissionGoods();

            foreach ($order['order_goods'] as $v){
                //查看是否有分销
                $ser = $ser_model->dataInfo(['id'=>$v['goods_id']]);

                if(!empty($ser['com_balance'])){

                    $insert = [

                        'uniacid' => $order['uniacid'],

                        'user_id' => $order['user_id'],

                        'top_id'  => $top,

                        'order_id'=> $order['id'],

                        'order_code' => $order['order_code'],

                    ];

                    $find = $com_mdoel->dataInfo($insert);

                    $cash = $v['true_price']*$ser['com_balance']/100*$v['num'];

                    $total_cash += $cash;

                    if(empty($find)){

                        $insert['cash'] = $cash;

                        $insert['status'] = -1;

                        $insert['admin_id'] = !empty($order['admin_id'])?$order['admin_id']:0;

                        $com_mdoel->dataAdd($insert);

                        $id = $com_mdoel->getLastInsID();

                    }else{

                        $id = $find['id'];

                        $update = [

                            'cash' => $total_cash
                        ];
                        //加佣金
                        $com_mdoel->dataUpdate(['id'=>$find['id']],$update);

                    }

                    $insert = [

                        'uniacid' => $order['uniacid'],

                        'order_goods_id' => $v['id'],

                        'commission_id'  => $id,

                        'cash'           => $cash,

                        'num'            => $v['num'],

                        'balance'        => $ser['com_balance']
                    ];
                    //添加到自订单记录表
                    $res = $com_goods_mdoel->dataAdd($insert);

                }

            }

        }

        return $total_cash;

    }



    /**
     * @param $order
     * @功能说明:技师佣金
     * @author chenniang
     * @DataTime: 2022-06-12 13:14
     */
    public function coachCommission($order){

        if(empty($order['coach_id'])){

            return true;
        }

        $insert = [

            'uniacid' => $order['uniacid'],

            'user_id' => $order['user_id'],

            'top_id'  => $order['coach_id'],

            'order_id'=> $order['id'],

            'order_code' => $order['order_code'],

            'type'    => 3,

            'cash'    => $order['coach_cash'],

            'admin_id'=> $order['admin_id'],

            'balance' => $order['coach_balance'],

            'status'  => -1,
        ];

        $res = $this->dataAdd($insert);

        return $res;
    }


    /**
     * @author chenniang
     * @DataTime: 2022-06-12 13:32
     * @功能说明:加盟商佣金
     */
    public function adminCommission($order){

        if(!empty($order['admin_id'])){

            $admin_model = new Admin();

            $city_type = $admin_model->where(['id'=>$order['admin_id']])->value('city_type');

            $insert = [

                'uniacid' => $order['uniacid'],

                'user_id' => $order['user_id'],

                'top_id'  => $order['admin_id'],

                'order_id'=> $order['id'],

                'order_code' => $order['order_code'],

                'type'    => 2,

                'cash'    => $order['admin_cash'],

                'admin_id'=> $order['admin_id'],

                'balance' => $order['admin_balance'],

                'status'  => -1,

                'city_type' => $city_type,
            ];

            $res = $this->dataAdd($insert);
        }

        return true;

    }


    /**
     * @author chenniang
     * @DataTime: 2022-06-12 13:32
     * @功能说明:加盟商上级佣金
     */
    public function adminLevelCommission($order){

        if(!empty($order['admin_pid'])){

            $admin_model = new Admin();

            $city_type = $admin_model->where(['id'=>$order['admin_pid']])->value('city_type');

            $insert = [

                'uniacid' => $order['uniacid'],

                'user_id' => $order['user_id'],

                'top_id'  => $order['admin_pid'],

                'order_id'=> $order['id'],

                'order_code' => $order['order_code'],

                'type'    => 5,

                'cash'    => $order['level_cash'],

                'admin_id'=> $order['admin_pid'],

                'balance' => $order['level_balance'],

                'status'  => -1,

                'city_type' => $city_type,

            ];

            $res = $this->dataAdd($insert);

        }

        return true;

    }


    /**
     * @author chenniang
     * @DataTime: 2022-06-12 13:32
     * @功能说明:省代理商佣金
     */
    public function adminProvinceCommission($order){

        if(!empty($order['p_admin_pid'])){

            $admin_model = new Admin();

            $city_type = $admin_model->where(['id'=>$order['p_admin_pid']])->value('city_type');

            $insert = [

                'uniacid' => $order['uniacid'],

                'user_id' => $order['user_id'],

                'top_id'  => $order['p_admin_pid'],

                'order_id'=> $order['id'],

                'order_code' => $order['order_code'],

                'type'    => 6,

                'cash'    => $order['p_level_cash'],

                'admin_id'=> $order['p_admin_pid'],

                'balance' => $order['p_level_balance'],

                'status'  => -1,

                'city_type' => $city_type,

            ];

            $res = $this->dataAdd($insert);

        }

        return true;

    }
    /**
     * @author chenniang
     * @DataTime: 2021-08-28 14:35
     * @功能说明:佣金到账
     */
    public function successCommission($order_id){

        $comm = $this->dataInfo(['order_id'=>$order_id,'status'=>1]);

        if(!empty($comm)){

            $user_model = new User();

            $user = $user_model->dataInfo(['id'=>$comm['top_id']]);

            if(!empty($user)){

                $update = [

                    'balance' => $user['balance']+$comm['cash'],

                    'cash'    => $user['cash']+$comm['cash'],
                ];

                $user_model->dataUpdate(['id'=>$comm['top_id']],$update);

                $this->dataUpdate(['id'=>$comm['id']],['status'=>2,'cash_time'=>time()]);

            }

        }

        return true;

    }


    /**
     * @author chenniang
     * @DataTime: 2021-08-28 14:48
     * @功能说明:退款的时候要减去分销
     */
    public function refundComm($refund_id){

        $refund_model    = new RefundOrder();

        $com_goods_mdoel = new CommissionGoods();

        $order_model     = new Order();

        $refund_order = $refund_model->dataInfo(['id'=>$refund_id]);

        if(!empty($refund_order)){
            //查询这笔等待有无佣金
            $comm = $this->dataInfo(['order_id'=>$refund_order['order_id'],'status'=>1,'type'=>1]);

            if(!empty($comm)){

                foreach ($refund_order['order_goods'] as $v){

                    $comm_goods = $com_goods_mdoel->dataInfo(['commission_id'=>$comm['id'],'order_goods_id'=>$v['order_goods_id']]);

                    if(!empty($comm_goods)){

                        $comm_goods_cash = $comm_goods['cash']/$comm_goods['num'];

                        $true_num = $comm_goods['num'] - $v['num'];

                        $true_num = $true_num>0?$true_num:0;

                        $update = [

                            'num' => $true_num,

                            'cash'=> $comm_goods_cash*$true_num
                        ];

                        $com_goods_mdoel->dataUpdate(['id'=>$comm_goods['id']],$update);
                    }

                }

                $total_cash = $com_goods_mdoel->where(['commission_id'=>$comm['id']])->sum('cash');

                $total_cash = $total_cash>0?$total_cash:0;

                $update = [

                    'cash' => $total_cash,

                    'status' => $total_cash>0?1:-1
                ];

                $this->dataUpdate(['id'=>$comm['id']],$update);

                $order_model->dataUpdate(['id'=>$refund_order['order_id']],['user_cash'=>$total_cash]);

            }

        }

        return true;

    }


    /**
     * @author chenniang
     * @DataTime: 2022-06-13 14:50
     * @功能说明:订单退款修改佣金记录
     */
    public function refundCash($order_id){

        $order_model = new Order();

        $pay_order = $order_model->dataInfo(['id'=>$order_id]);

        $level_cash_data = $this->where(['order_id'=>$pay_order['id'],'status'=>1])->where('type','in',[5,6])->select()->toArray();
        //查询有无二级市级代理佣金或者省代
        if(!empty($level_cash_data)){

            foreach ($level_cash_data as $v){

                $cash_text = $this->getTypeText($v['type']);

                $pay_order[$cash_text['admin_id']] = $v['admin_id'];

                $pay_order[$cash_text['balance']] = $v['balance'];
            }
        }
        //修改佣金信息
        $cash_data = $order_model->getCashData($pay_order,2);

        $cash_data = $cash_data['data'];

        $cash_order_update = [

            'admin_cash'  => $cash_data['admin_cash'],

            'coach_cash'  => $cash_data['coach_cash'],

            'company_cash'=> $cash_data['company_cash'],
        ];

        $arr = [2,3,5,6];

        foreach ($arr as $value){

            $cash_text = $this->getTypeText($value);

            if(key_exists($cash_text['cash'],$cash_data)){
                //修改各类佣金记录
                $this->dataUpdate(['order_id'=>$pay_order['id'],'type'=>$value,'status'=>1],['cash'=>$cash_data[$cash_text['cash']]]);
            }
        }

        $res = $order_model->dataUpdate(['id'=>$pay_order['id']],$cash_order_update);

        return $res;
    }


    /**
     * @param $type
     * @功能说明:
     * @author chenniang
     * @DataTime: 2023-02-17 16:05
     */
    public function getTypeText($type){

        switch ($type){

            case 2:
                $arr['cash'] = 'admin_cash';

                $arr['balance'] = 'admin_balance';

                break;
            case 3:
                $arr['cash'] = 'coach_cash';

                $arr['cash'] = 'coach_balance';

                break;

            case 5:
                $arr['cash'] = 'level_cash';

                $arr['balance'] = 'level_balance';

                $arr['admin_id'] = 'admin_pid';

                break;

            case 6:
                $arr['cash'] = 'p_level_cash';

                $arr['balance'] = 'p_level_balance';

                $arr['admin_id'] = 'p_admin_pid';

                break;

        }

        return $arr;
    }









}