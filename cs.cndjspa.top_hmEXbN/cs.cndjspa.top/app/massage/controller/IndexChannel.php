<?php
namespace app\massage\controller;
use app\ApiRest;

use app\massage\model\BalanceWater;
use app\massage\model\ChannelList;
use app\massage\model\Coach;

use app\massage\model\Commission;
use app\massage\model\Config;
use app\massage\model\Goods;

use app\massage\model\Order;
use app\massage\model\OrderGoods;
use app\massage\model\Police;
use app\massage\model\RefundOrder;
use app\massage\model\RefundOrderGoods;
use app\massage\model\User;
use app\massage\model\Wallet;
use longbingcore\wxcore\WxSetting;
use think\App;
use think\facade\Db;
use think\Request;


class IndexChannel extends ApiRest
{

    protected $model;

    protected $channel_info;

    protected $order_model;

    protected $user_model;

    public function __construct(App $app) {

        parent::__construct($app);

        $this->model = new ChannelList();

        $this->order_model = new Order();

        $this->user_model = new User();

        $cap_dis[] = ['user_id','=',$this->getUserId()];

        $cap_dis[] = ['status','in',[2,3]];

        $this->channel_info = $this->model->dataInfo($cap_dis);

        if(empty($this->channel_info)){

            $this->errorMsg('你还不是渠道商');
        }

    }

    /**
     * @author chenniang
     * @DataTime: 2021-07-08 11:39
     * @功能说明:技师首页
     */
    public function index(){

        $input = $this->_param;

        $data = $this->channel_info;

        $order_data = $this->order_model->channelData($this->channel_info['id'],$input);

        $data = array_merge($data,$order_data);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-08-30 14:18
     * @功能说明:渠道码
     */
    public function channelQr(){

        $input = $this->_param;

        $key = 'channel_qr'.$this->channel_info['id'].'-'.$this->is_app;

        $qr  = getCache($key,$this->_uniacid);

        if(empty($qr)){
            //小程序
            if($this->is_app==0){

                $input['page'] = 'pages/service';

                $input['channel_id'] = $this->channel_info['id'];
                //获取二维码
                $qr = $this->user_model->orderQr($input,$this->_uniacid);

            }else{

                $page = 'https://'.$_SERVER['HTTP_HOST'].'/h5/#/pages/service?channel_id='.$this->channel_info['id'];

                $qr = base64ToPng(getCode($this->_uniacid,$page));

            }

            setCache($key,$qr,86400,$this->_uniacid);
        }

        $qr = !empty($qr)?$qr:'https://'.$_SERVER['HTTP_HOST'].'/favicon.ico';

        return $this->success($qr);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-08-30 14:34
     * @功能说明:订单列表
     */
    public function orderList(){

        $input = $this->_param;

        $dis[] = ['a.uniacid','=',$this->_uniacid];

        $dis[] = ['a.pay_type','>',1];

        $dis[] = ['a.channel_id','=',$this->channel_info['id']];

        if(!empty($input['start_time'])&&!empty($input['end_time'])){

            $dis[] = ['a.create_time','between',"{$input['start_time']},{$input['end_time']}"];

        }

        $where = [];

        if(!empty($input['name'])){

            $where[] = ['b.goods_name','like','%'.$input['name'].'%'];

            $where[] = ['a.order_code','like','%'.$input['name'].'%'];

        }

        $data = $this->order_model->indexDataList($dis,$where);

        if(!empty($data['data'])){

            $order_goods_model = new OrderGoods();

            $refund_model = new RefundOrder();

            foreach ($data['data'] as &$v){

                $v['refund_price'] = $refund_model->where(['order_id'=>$v['id'],'status'=>2])->sum('refund_price');

//                $dis = [
//
//                    'order_id' => $v['id']
//                ];
//
//                $v['order_goods'] = $order_goods_model->where($dis)->where('can_refund_num','>',0)->select()->toArray();

            }
        }

        return $this->success($data);

    }








}
