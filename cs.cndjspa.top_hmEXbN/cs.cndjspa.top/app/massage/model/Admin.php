<?php
namespace app\massage\model;

use app\BaseModel;
use think\facade\Db;

class Admin extends BaseModel
{
    //定义表名
    protected $name = 'shequshop_school_admin';


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
     * @DataTime: 2022-06-08 17:21
     * @功能说明:加盟商列表
     */
    public function adminUserList($dis,$page){

        $data = $this->alias('a')
                ->join('massage_service_user_list b','a.user_id = b.id','left')
                ->where($dis)
                ->field('a.*,b.nickName')
                ->group('a.id')
                ->order('a.id')
                ->paginate($page)
                ->toArray();

        return $data;
    }


    /**
     * @author chenniang
     * @DataTime: 2022-06-08 23:06
     * @功能说明:加盟商
     */
    function jionAdminCheck($input){

        if(!empty($input['username']&&$input['username']=='admin')){

            return ['code'=>500,'msg'=>'用户名不能和超管账号相同'];

        }

        $dis[] = ['user_id','=',$input['user_id']];

        $dis[] = ['is_admin','=',0];

        $dis[] = ['uniacid','=',$input['uniacid']];

        $dis[] = ['status','>',-1];

        if(!empty($input['id'])){

            $dis[] = ['id','<>',$input['id']];

        }

        $find = $this->where($dis)->find();

        if(!empty($find)){

            return ['code'=>500,'msg'=>'该用户已经绑定过加盟商'];

        }

        $where[] = ['username','=',$input['username']];

        $where[] = ['uniacid','=',$input['uniacid']];

        $where[] = ['status','>',-1];

        if(!empty($input['id'])){

            $where[] = ['id','<>',$input['id']];

        }

        $find = $this->where($where)->find();

        if(!empty($find)){

            return ['code'=>500,'msg'=>'已经有该用户名的账户'];

        }

        return true;

    }


    /**
     * @author chenniang
     * @DataTime: 2022-10-21 14:06
     * @功能说明:获取代理商已经下级的id
     */
    public function getAdminAndSon($admin_id){

        $dis = [

            'admin_pid' => $admin_id
        ];

        $id = $this->where($dis)->column('id');

        $id[] = $admin_id;

        return $id;

    }




    /**
     * @author chenniang
     * @DataTime: 2023-02-16 10:45
     * @功能说明:代理商的分销比例
     */
    public function agentBalanceData($admin_id,$order){

        $admin = $this->dataInfo(['id'=>$admin_id]);
        //平台抽层比列
        $order['admin_balance'] = !empty($admin)?$admin['balance']:0;

        $order['admin_id']      = $admin_id;
        //县级代理商
        if(!empty($admin)&&!empty($admin['admin_pid'])&&in_array($admin['city_type'],[1,2])){

            $order['level_balance'] = $admin['level_balance'];

            $order['admin_pid']     = $admin['admin_pid'];
            //查看是否还有上级
            $admin_pdata = $this->dataInfo(['id'=>$order['admin_pid']]);
            //只有市才有上级
            if(!empty($admin_pdata)&&$admin_pdata['city_type']==1){

                $order['p_level_balance'] = $admin_pdata['level_balance'];

                $order['p_admin_pid']     = $admin_pdata['admin_pid'];
            }
        }

        return $order;

    }


    /**
     * @author chenniang
     * @DataTime: 2023-02-16 17:03
     * @功能说明:代理商佣金
     */
    public function agentCashData($order,$admin_cash){

        if(isset($order['p_level_balance'])){
            //上级代理提成
            $order['p_level_cash'] = round($order['p_level_balance']*$order['true_service_price']/100,2);

            $order['p_level_cash'] = $order['p_level_cash'] - $admin_cash>0?$admin_cash:$order['p_level_cash'];

            $admin_cash -= $order['p_level_cash'];

        }

        if(isset($order['level_balance'])){
            //上级代理提成
            $order['level_cash'] = round($order['level_balance']*$order['true_service_price']/100,2);

            $order['level_cash'] = $order['level_cash'] - $admin_cash>0?$admin_cash:$order['level_cash'];

            $admin_cash -= $order['level_cash'];

        }

        $order['over_cash'] = $admin_cash;

        return $order;
    }


}