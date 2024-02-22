<?php
namespace app\massage\model;

use app\BaseModel;
use think\facade\Db;

class ClockSetting extends BaseModel
{
    //定义表名
    protected $name = 'massage_add_clock_setting';



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

        return !empty($data)?$data->toArray():[];

    }


    /**
     * @author chenniang
     * @DataTime: 2023-02-17 13:44
     * @功能说明:获取技师提成佣金
     * 1678435200
     * 1678438800
     */
    public function getCoachBalance($order){

        $order_model = new Order();

        $add_order = $order_model->where(['pay_type'=>1,'add_pid'=>$order['add_pid']])->where('id','<>',$order['id'])->select()->toArray();
        //取消未支付的
        if(!empty($add_order)){

            foreach ($add_order as $value){

                $order_model->cancelOrder($value);
            }

        }

        if(empty($order['coach_id'])){

            return 0;
        }

        if($order['is_add']!=1){

            return $order['coach_balance'];
        }

        $config_model = new MassageConfig();

        $config = $config_model->dataInfo(['uniacid'=>$order['uniacid']]);

        if($config['clock_cash_status']!=1){

            return $order['coach_balance'];
        }

        $times = $order_model->addOrderTimes($order['add_pid']);

        $balance = $this->dataInfo(['uniacid'=>$order['uniacid'],'times'=>$times]);

        if(empty($balance)){

            $balance = $this->where(['uniacid'=>$order['uniacid']])->order('times desc,id desc')->find();

            $balance = !empty($balance)?$balance->toArray():[];
        }

        $balance = !empty($balance)?$balance['balance']:0;

        return $balance;

    }








}