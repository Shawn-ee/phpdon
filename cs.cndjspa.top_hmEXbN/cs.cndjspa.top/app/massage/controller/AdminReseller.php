<?php
namespace app\massage\controller;
use app\AdminRest;
use app\massage\model\Commission;
use app\massage\model\DistributionList;
use app\massage\model\User;
use app\massage\model\Wallet;
use longbingcore\wxcore\YsCloudApi;
use think\App;



class AdminReseller extends AdminRest
{


    protected $model;

    protected $user_model;

    protected $cash_model;

    protected $wallet_model;



    public function __construct(App $app) {

        parent::__construct($app);

        $this->model        = new DistributionList();

        $this->user_model   = new User();

        $this->cash_model   = new Commission();

        $this->wallet_model   = new Wallet();



    }



    /**
     * @author chenniang
     * @DataTime: 2021-03-15 14:43
     * @功能说明:列表
     */
    public function resellerList(){

        $input = $this->_param;

        $dis[] = ['a.uniacid','=',$this->_uniacid];

        if(!empty($input['status'])){

            $dis[] = ['a.status','=',$input['status']];

        }else{

            $dis[] = ['a.status','>',-1];

        }

        if(!empty($input['start_time'])&&!empty($input['end_time'])){

            $start_time = $input['start_time'];

            $end_time   = $input['end_time'];

            $dis[] = ['a.create_time','between',"$start_time,$end_time"];

        }

        $where = [];

        if(!empty($input['name'])){

            $where[] = ['a.user_name','like','%'.$input['name'].'%'];

            $where[] = ['a.mobile','like','%'.$input['name'].'%'];
        }

        $data = $this->model->adminDataList($dis,$input['limit'],$where);

        $list = [

            0=>'all',

            1=>'ing',

            2=>'pass',

            4=>'nopass'
        ];

        foreach ($list as $k=> $value){

            $dis_s = [];

            $dis_s[] =['uniacid','=',$this->_uniacid];

            if(!empty($k)){

                $dis_s[] = ['status','=',$k];

            }else{

                $dis_s[] = ['status','>',-1];

            }

            $data[$value] = $this->model->where($dis_s)->count();

        }

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-08-03 11:53
     * @功能说明:
     */
    public function resellerInfo(){

        $input = $this->_param;

        $dis = [

            'id' => $input['id']
        ];

        $info = $this->model->dataInfo($dis);

        $user_model = new User();

        $info['nickName'] = $user_model->where(['id'=>$info['user_id']])->value('nickName');

        return $this->success($info);

    }



    /**
     * @author chenniang
     * @DataTime: 2021-07-03 00:15
     * @功能说明:审核(2通过,3取消,4拒绝)
     */
    public function resellerUpdate(){

        $input = $this->_input;

        $diss = [

            'id' => $input['id']
        ];

        $info = $this->model->dataInfo($diss);

        if(!empty($input['status'])&&in_array($input['status'],[2,4,-1])){

            $input['sh_time'] = time();

            if($input['status']==-1){

                $fx_cash = $this->user_model->where(['id'=>$info['user_id']])->sum('new_cash');

                if($fx_cash>0){

                    $this->errorMsg('分销商还有佣金未提现');
                }

                $dis = [

                    'top_id'  => $info['user_id'],

                    'status'  => 1,

                    'type'    => 1
                ];

                $cash = $this->cash_model->dataInfo($dis);

                if(!empty($cash)){

                    $this->errorMsg('分销商还有佣金未到账');

                }

                $dis = [

                    'user_id' => $info['user_id'],

                    'status'  => 1,

                    'type'    => 4
                ];

                $wallet = $this->wallet_model->dataInfo($dis);

                if(!empty($wallet)){

                    $this->errorMsg('分销商还有提现未处理');

                }

            }

        }

        $data = $this->model->dataUpdate($diss,$input);

        if(isset($input['status'])){

            $update = [

                'is_fx' => 0
            ];

            if($input['status']==2){

                $update['is_fx'] = 1;

            }

            $this->user_model->dataUpdate(['id'=>$info['user_id']],$update);

        }

        return $this->success($data);

    }









}
