<?php
namespace app\massage\controller;
use app\AdminRest;
use app\massage\model\BalanceCard;
use app\massage\model\BalanceOrder;
use app\massage\model\Coupon;
use app\shop\model\Article;
use app\shop\model\Banner;
use app\shop\model\Cap;
use app\shop\model\Date;
use app\shop\model\MsgConfig;
use app\shop\model\OrderAddress;
use app\shop\model\OrderGoods;
use app\shop\model\RefundOrder;
use app\shop\model\RefundOrderGoods;
use app\shop\model\Wallet;
use think\App;
use app\shop\model\Order as Model;
use think\facade\Db;


class AdminBalance extends AdminRest
{


    protected $model;

    protected $order_model;

    protected $refund_order_model;

    public function __construct(App $app) {

        parent::__construct($app);

        $this->model = new BalanceCard();

        $this->order_model = new BalanceOrder();

      //  $this->refund_order_model = new RefundOrder();

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-04 19:09
     * @功能说明:储值充值卡列表
     */
    public function cardList(){

        $input = $this->_param;

        $dis[] = ['uniacid','=',$this->_uniacid];

        $dis[] = ['status','>',-1];

        if(!empty($input['name'])){

            $dis[] = ['title','like','%'.$input['name'].'%'];

        }

        $data = $this->model->dataList($dis,$input['limit']);

        return $this->success($data);

    }



    /**
     * @author chenniang
     * @DataTime: 2021-07-04 18:56
     * @功能说明:添加充值卡
     */
    public function cardAdd(){

        $input = $this->_input;

        $input['uniacid'] = $this->_uniacid;

        $res = $this->model->dataAdd($input);

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-04 18:57
     * @功能说明:编辑充值卡
     */
    public function cardUpdate(){

        $input = $this->_input;

        $dis = [

            'id' => $input['id']
        ];

        $res = $this->model->dataUpdate($dis,$input);

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-04 18:59
     * @功能说明:充值卡详情
     */
    public function cardInfo(){

        $input = $this->_input;

        $dis = [

            'id' => $input['id']
        ];

        $res = $this->model->dataInfo($dis);

        return $this->success($res);


    }




    /**
     * @author chenniang
     * @DataTime: 2021-07-04 19:09
     * @功能说明:储值订单列表
     */
    public function orderList(){

        $input = $this->_param;

        $dis[] = ['uniacid','=',$this->_uniacid];

        $dis[] = ['status','>',1];

        if(!empty($input['name'])){

            $dis[] = ['title','like','%'.$input['name'].'%'];

        }

        if(!empty($input['order_code'])){

            $dis[] = ['order_code','like','%'.$input['order_code'].'%'];

        }

        if(!empty($input['start_time'])){

            $dis[] = ['pay_time','between',"{$input['start_time']},{$input['end_time']}"];

        }

        $data = $this->order_model->dataList($dis,$input['limit']);



        return $this->success($data);

    }






    /**
     * @author chenniang
     * @DataTime: 2021-07-04 18:59
     * @功能说明:充值订单详情
     */
    public function orderInfo(){

        $input = $this->_input;

        $dis = [

            'id' => $input['id']
        ];

        $res = $this->order_model->dataInfo($dis);

        return $this->success($res);


    }




}
