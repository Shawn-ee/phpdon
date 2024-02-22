<?php
namespace app\massage\controller;
use app\AdminRest;
use app\massage\model\Coupon;
use app\massage\model\CouponAtv;
use app\massage\model\CouponAtvRecord;
use app\massage\model\CouponRecord;
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


class AdminCoupon extends AdminRest
{


    protected $model;

    protected $atv_model;

    protected $record_model;

    public function __construct(App $app) {

        parent::__construct($app);

        $this->model = new Coupon();

        $this->atv_model = new CouponAtv();

        $this->record_model = new CouponRecord();


    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-04 19:09
     * @功能说明:优惠券列表
     */
    public function couponList(){

        $input = $this->_param;

        $dis[] = ['uniacid','=',$this->_uniacid];

        if(!empty($input['status'])){

            $dis[] = ['status','=',$input['status']];

        }else{

            $dis[] = ['status','>',-1];

        }

        if(isset($input['send_type'])){

            $dis[] = ['send_type','=',$input['send_type']];

        }

        if(!empty($input['name'])){

            $dis[] = ['title','like','%'.$input['name'].'%'];

        }

        $data = $this->model->dataList($dis,$input['limit']);

        return $this->success($data);

    }



    /**
     * @author chenniang
     * @DataTime: 2021-07-04 18:56
     * @功能说明:添加优惠券
     */
    public function couponAdd(){

        $input = $this->_input;

        $input['uniacid'] = $this->_uniacid;

        $res = $this->model->dataAdd($input);

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-04 18:57
     * @功能说明:编辑优惠券
     */
    public function couponUpdate(){

        $input = $this->_input;

        $dis = [

            'id' => $input['id']
        ];


        $input['uniacid'] = $this->_uniacid;
        //删除优惠券 需要判断该优惠券是否正在参加活动
        if(isset($input['status'])&&$input['status']==-1){

            $atv_record_model = new CouponAtvRecord();

            $have_atv = $atv_record_model->couponIsAtv($input['id']);

            if($have_atv==true){

                $this->errorMsg('该优惠券正在参加活动，只有等用户发起等活动结束后才能删除');
            }

        }

        $res = $this->model->dataUpdate($dis,$input);

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-04 18:59
     * @功能说明:优惠券详情
     */
    public function couponInfo(){

        $input = $this->_param;

        $dis = [

            'id' => $input['id']
        ];

        $res = $this->model->dataInfo($dis);

        return $this->success($res);


    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-06 19:19
     * @功能说明:活动详情
     */
    public function couponAtvInfo(){

        $input = $this->_param;

        $dis = [

            'uniacid' => $this->_uniacid
        ];

        $data = $this->atv_model->dataInfo($dis);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-06 19:22
     * @功能说明:活动编辑
     */
    public function couponAtvUpdate(){

        $input = $this->_input;

        $dis = [

            'uniacid' => $this->_uniacid
        ];

        $input['uniacid'] = $this->_uniacid;

        $data = $this->atv_model->dataUpdate($dis,$input);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-12 16:26
     * @功能说明:后台派发卡劵
     */
    public function couponRecordAdd(){

        $input = $this->_input;

        foreach ($input['user'] as $value){

            $res = $this->record_model->recordAdd($input['coupon_id'],$value['id'],$value['num']);

            if(!empty($res['code'])){

                $this->errorMsg($res['msg']);
            }

        }

        return $this->success($res);

    }







}
