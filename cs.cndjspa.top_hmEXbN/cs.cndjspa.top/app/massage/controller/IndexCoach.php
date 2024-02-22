<?php

namespace app\massage\controller;

use app\ApiRest;

use app\massage\model\Appeal;
use app\massage\model\BalanceOrder;
use app\massage\model\BalanceWater;
use app\massage\model\Coach;

use app\massage\model\CoachChangeLog;
use app\massage\model\CoachLevel;
use app\massage\model\CoachUpdate;
use app\massage\model\Commission;
use app\massage\model\Config;
use app\massage\model\ConfigSetting;
use app\massage\model\CouponRecord;
use app\massage\model\Feedback;
use app\massage\model\Goods;

use app\massage\model\Integral;
use app\massage\model\MassageConfig;
use app\massage\model\Order;
use app\massage\model\OrderData;
use app\massage\model\OrderLog;
use app\massage\model\Police;
use app\massage\model\RefundOrder;
use app\massage\model\RefundOrderGoods;
use app\massage\model\ShieldList;
use app\massage\model\ShopCarte;
use app\massage\model\ShopGoods;
use app\massage\model\ShortCodeConfig;
use app\massage\model\User;
use app\massage\model\UserLabelData;
use app\massage\model\UserLabelList;
use app\massage\model\Wallet;
use app\massage\model\WorkLog;
use longbingcore\wxcore\WxSetting;
use think\App;
use think\facade\Db;
use think\Request;


class IndexCoach extends ApiRest
{

    protected $order_model;

    protected $model;

    protected $cap_info;

    public function __construct(App $app)
    {

        parent::__construct($app);

        $this->model = new Coach();

        $this->order_model = new Order();

        $cap_dis[] = ['user_id', '=', $this->getUserId()];

        $cap_dis[] = ['status', 'in', [2, 3]];

        $this->cap_info = $this->model->dataInfo($cap_dis);

        if (empty($this->cap_info)) {

            $this->errorMsg('你还不是技师');
        }

    }

    /**
     * @author chenniang
     * @DataTime: 2021-07-08 11:39
     * @功能说明:技师首页
     */
    public function coachIndex()
    {

        $data = $this->cap_info;

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-23 09:59
     * @功能说明:修改技师信息
     */
    public function coachUpdate()
    {
        $input = $this->_input;

        $dis = [

            'id' => $this->cap_info['id']
        ];

        if (!empty($input['id_card'])) {

            $input['id_card'] = implode(',', $input['id_card']);
        }

        if (!empty($input['license'])) {

            $input['license'] = implode(',', $input['license']);
        }

        if (!empty($input['self_img'])) {

            $input['self_img'] = implode(',', $input['self_img']);
        }

        if(isset($input['service_price'])){

            unset($input['service_price']);
        }

        if(isset($input['car_price'])){

            unset($input['car_price']);
        }

        $res = $this->model->dataUpdate($dis, $input);

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-23 09:59
     * @功能说明:修改技师信息
     */
    public function coachUpdateV2(){

        $input = $this->_input;

        $dis = [

            'id' => $this->cap_info['id']
        ];

        $input['uniacid'] = $this->_uniacid;

        $input['coach_id'] = $this->cap_info['id'];

        $input['user_id'] = $this->getUserId();

        if (isset($input['id'])) {

            unset($input['id']);
        }

        if (!empty($input['id_card'])) {

            $input['id_card'] = implode(',', $input['id_card']);
        }

        if (!empty($input['license'])) {

            $input['license'] = implode(',', $input['license']);
        }

        if (!empty($input['self_img'])) {

            $input['self_img'] = implode(',', $input['self_img']);
        }

        $update_model = new CoachUpdate();

        $res = $update_model->dataAdd($input);

        $this->model->dataUpdate($dis, ['is_update' => 1]);

        return $this->success($res);

    }

    /**
     * @author chenniang
     * @DataTime: 2021-03-19 15:48
     * @功能说明:个人中心
     */
    public function index()
    {

        $data = $this->getUserInfo();

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-19 15:48
     * @功能说明:个人中心
     */
    public function orderList()
    {

        $input = $this->_param;

        $dis[] = ['a.uniacid', '=', $this->_uniacid];

        $dis[] = ['a.coach_id', '=', $this->cap_info['id']];

        $where = [];

        if (!empty($input['name'])) {

            $where[] = ['b.goods_name', 'like', '%' . $input['name'] . '%'];

            $where[] = ['a.order_code', 'like', '%' . $input['name'] . '%'];

        }

        if ($input['pay_type'] == 5) {

            $dis[] = ['a.pay_type', 'in', [3, 4, 5]];

        } else {

            $dis[] = ['a.pay_type', '=', $input['pay_type']];

        }

        $order_model = new Order();

        $data = $order_model->indexDataList($dis, $where);

        if(!empty($data['data'])){

            $shield_model = new ShieldList();

            foreach ($data['data'] as &$v){
                //是否还能屏蔽用户
                $can_shield = $shield_model->dataInfo(['user_id'=>$v['user_id'],'coach_id'=>$v['coach_id'],'type'=>3]);

                $v['can_shield'] = empty($can_shield)?1:0;
            }
        }
        //待接单数量
        $data['agent_order_count'] = $order_model->where(['coach_id' => $this->cap_info['id'], 'pay_type' => 2])->count();
        $data['wait_order_count'] = $order_model->where([['coach_id', '=', $this->cap_info['id']], ['pay_type', 'in', [3, 4, 5]]])->count();
        $data['service_order_count'] = $order_model->where(['coach_id' => $this->cap_info['id'], 'pay_type' => 6])->count();

        return $this->success($data);

    }





    /**
     * @author chenniang
     * @DataTime: 2021-03-24 13:33
     * @功能说明:团长审核提现
     */
    public function applyWallet()
    {

        $input = $this->_input;

        if (empty($input['apply_price']) || $input['apply_price'] < 0.01) {

            $this->errorMsg('提现费最低一分');
        }
        //服务费
        if ($input['apply_price'] > $this->cap_info['service_price'] && $input['type'] == 1) {

            $this->errorMsg('余额不足');
        }
        //车费
        if ($input['apply_price'] > $this->cap_info['car_price'] && $input['type'] == 2) {

            $this->errorMsg('余额不足');
        }

        //   $coach_level = $this->model->getCoachLevel($this->cap_info['id'],$this->_uniacid);
//        //车费没有服务费
//        $balance = !empty($coach_level)&&$input['type']==1?$coach_level['balance']:100;

        $balance = 100;

        $key = 'cap_wallet' . $this->getUserId();

        $value = getCache($key);

        if (!empty($value)) {

            $this->errorMsg('网络错误，请刷新重试');

        }
        //加一个锁防止重复提交
        incCache($key, 1, $this->_uniacid);

        Db::startTrans();

        if ($input['type'] == 1) {
            //减佣金
            $res = $this->model->dataUpdate(['id' => $this->cap_info['id']], ['service_price' => $this->cap_info['service_price'] - $input['apply_price']]);

        } else {

            $res = $this->model->dataUpdate(['id' => $this->cap_info['id']], ['car_price' => $this->cap_info['car_price'] - $input['apply_price']]);

        }

        if ($res != 1) {

            Db::rollback();
            //减掉
            delCache($key, $this->_uniacid);

            $this->errorMsg('申请失败');
        }

        $insert = [

            'uniacid' => $this->_uniacid,

            'user_id' => $this->getUserId(),

            'coach_id' => $this->cap_info['id'],

            'admin_id' => $this->cap_info['admin_id'],

            'total_price' => $input['apply_price'],

            'balance' => $balance,

            'apply_price' => round($input['apply_price'] * $balance / 100, 2),

            'service_price' => round($input['apply_price'] - $input['apply_price'] * $balance / 100, 2),

            'code' => orderCode(),

            'text' => $input['text'],

            'type' => $input['type'],

            'apply_transfer' => !empty($input['apply_transfer'])?$input['apply_transfer']:0

        ];

        $wallet_model = new Wallet();
        //提交审核
        $res = $wallet_model->dataAdd($insert);

        if ($res != 1) {

            Db::rollback();
            //减掉
            delCache($key, $this->_uniacid);

            $this->errorMsg('申请失败');
        }

        Db::commit();
        //减掉
        delCache($key, $this->_uniacid);

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-25 17:14
     * @功能说明:楼长核销订单
     */
    public function hxOrder()
    {

        $input = $this->_input;

        $order_model = new Order();

        $order = $order_model->dataInfo(['id' => $input['id']]);

        if (empty($order)) {

            $this->errorMsg('订单未找到');
        }

        if ($order['pay_type'] != 5) {

            $this->errorMsg('订单状态错误');
        }

        if ($order['coach_id'] != $this->cap_info['id']) {

            $this->errorMsg('你不是该订单的楼长');

        }

        $refund_model = new RefundOrder();
        //判断有无申请中的退款订单
        $refund_order = $refund_model->dataInfo(['order_id' => $order['id'], 'status' => 1]);

        if (!empty($refund_order)) {

            $this->errorMsg('该订单正在申请退款，请先处理再核销');

        }

        $res = $order_model->hxOrder($order, $this->cap_info['id']);

        return $this->success($res);


    }

    /**
     * @author chenniang
     * @DataTime: 2021-03-30 13:38
     * @功能说明:团长端佣金信息
     */
    public function capCashInfo()
    {

        $this->order_model->coachBalanceArr($this->_uniacid);

        $key = 'cap_wallet' . $this->getUserId();
        //减掉
        delCache($key, $this->_uniacid);

        $wallet_model = new Wallet();
        //可提现佣金
        $data['cap_cash'] = $this->cap_info['service_price'];
        //累计提现
        $data['extract_total_price'] = $wallet_model->capCash($this->cap_info['id'], 2, 1);
        //提现中
        $data['extract_ing_price'] = $wallet_model->capCash($this->cap_info['id'], 1, 1);

        $dis = [

            'pay_type' => 7,

            'coach_id' => $this->cap_info['id'],

            'have_tx' => 0
        ];
        //未到账
        $data['no_received'] = $this->order_model->where($dis)->sum('service_price');

        $data['coach_level'] = $this->model->getCoachLevel($this->cap_info['id'], $this->_uniacid);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-30 13:38
     * @功能说明:团长端佣金信息
     */
    public function capCashInfoCar()
    {

        $key = 'cap_wallet' . $this->getUserId();
        //减掉
        delCache($key, $this->_uniacid);

        $wallet_model = new Wallet();
        //可提现佣金
        $data['cap_cash'] = $this->cap_info['car_price'];
        //累计提现
        $data['extract_total_price'] = $wallet_model->capCash($this->cap_info['id'], 2, 2);
        //提现中
        $data['extract_ing_price'] = $wallet_model->capCash($this->cap_info['id'], 1, 2);

        $dis = [

            'pay_type' => 7,

            'coach_id' => $this->cap_info['id'],

            'have_tx' => 0
        ];
        //未到账
        $data['no_received'] = $this->order_model->where($dis)->sum('car_price');

        $data['coach_level'] = $this->model->getCoachLevel($this->cap_info['id'], $this->_uniacid);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-30 14:39
     * @功能说明:团长提现记录
     */
    public function capCashList()
    {

        $wallet_model = new Wallet();

        $input = $this->_param;

        $dis = [

            'coach_id' => $this->cap_info['id']
        ];

        if (!empty($input['status'])) {

            $dis['status'] = $input['status'];
        }

        $dis['type'] = $input['type'];
        //提现记录
        $data = $wallet_model->dataList($dis, 10);

        if (!empty($data['data'])) {

            foreach ($data['data'] as &$v) {

                $v['create_time'] = date('Y-m-d H:i:s', $v['create_time']);
            }
        }
        //累计提现
        $data['extract_total_price'] = $wallet_model->capCash($this->cap_info['id'], 2, $input['type']);

        return $this->success($data);


    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-08 17:09
     * @功能说明:报警
     */
    public function police()
    {

        $input = $this->_input;

        $insert = [

            'uniacid' => $this->_uniacid,

            'coach_id' => $this->cap_info['id'],

            'user_id' => $this->cap_info['user_id'],

            'text' => '正在发出求救信号，请及时查看技师正在服务的订单地址和电话，确认报警信息',

            'lng'  => !empty($input['lng'])?$input['lng']:'',

            'lat'  => !empty($input['lat'])?$input['lat']:'',

            'address'  => !empty($input['address'])?$input['address']:'',
        ];


        $police_model = new Police();

        $res = $police_model->dataAdd($insert);

        $config_model = new ShortCodeConfig();
        //发送短信通知
        $config_model->sendHelpCode($insert['uniacid'],$insert['coach_id'],$insert['address']);
        //发送公众号通知
        $police_model->helpSendMsg($insert['uniacid'],$insert['coach_id'],$insert['address']);

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-11 22:34
     * @功能说明:技师修改订单信息)
     */
    public function updateOrder()
    {

        $input = $this->_input;

        $order = $this->order_model->dataInfo(['id' => $input['order_id']]);

        $update = $this->order_model->coachOrdertext($input);

        $refund_model = new RefundOrder();
        //判断有无申请中的退款订单
        $refund_order = $refund_model->dataInfo(['order_id' => $order['id'], 'status' => 1]);

        if (!empty($refund_order)) {

            $this->errorMsg('该订单正在申请退款，请先联系平台处理再进行下一步');

        }

        if($order['pay_type']<2){

            $this->errorMsg('订单已被取消');
        }
        //拒单，如果开启了派单就到转单状态
        if($input['type']==-1){

            $config_model = new ConfigSetting();

            $config = $config_model->dataInfo($this->_uniacid);

            $input['type'] = $update['pay_type'] = $config['order_dispatch']==1?8:-1;

        }

        Db::startTrans();

        if($input['type']==7){

            if ($order['pay_type'] != 6) {

                $this->errorMsg('订单状态错误');
            }

            $this->order_model->hxOrder($order, $this->cap_info['id']);

        }elseif ($input['type'] == -1){

            if ($order['pay_type'] != 2) {

                Db::rollback();

                $this->errorMsg('已接单');

            }
            //取消订单
            $res = $this->order_model->cancelOrder($order);

            if (!empty($res['code'])) {

                Db::rollback();

                $this->errorMsg($res['msg']);

            }

            if ($order['pay_price'] > 0) {

                $refund_model = new RefundOrder();

                $res = $refund_model->refundCash($this->payConfig(), $order, $order['pay_price']);

                if (!empty($res['code'])) {

                    Db::rollback();

                    $this->errorMsg($res['msg']);

                }

                if ($res != true) {

                    Db::rollback();

                    $this->errorMsg('退款失败，请重试2');

                }
            }

        }
        $this->order_model->dataUpdate(['id' => $input['order_id']], $update);

        $log_model = new OrderLog();

        $log_model->addLog($input['order_id'],$this->_uniacid,$input['type'],$order['pay_type'],2,$this->_user['id']);

        Db::commit();

        return $this->success(true);
    }

    /**
     * 时间管理回显
     * @return \think\Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getTimeConfig()
    {
        $coach_info = $this->cap_info;

        $config_model = new Config();

        $config = $config_model->dataInfo(['uniacid'=>$this->_uniacid]);

        $data = [
            "is_work" => $coach_info['is_work'],
            "start_time" => $coach_info['start_time'],
            "end_time" => $coach_info['end_time'],
            'coach_status' => $coach_info['status'],
            'day_list' => $this->getDay(),
            'time_unit' => $config['time_unit'],


        ];
        return $this->success($data);
    }

    /**
     * 设置
     * @return \think\Response
     */
    public function setTimeConfig()
    {
        $data = $this->request->only(['start_time', 'end_time', 'is_work', 'time_text','time_unit']);
        $rule = [
            'start_time'=> 'require',
            'end_time'  => 'require',
            'is_work'   => 'require',
            'time_text' => 'require',
            'time_unit' => 'require',
        ];
        $validate = \think\facade\Validate::rule($rule);
        if (!$validate->check($data)) {
            return $this->error($validate->getError());
        }

        $log_model = new WorkLog();
        //结算在线时间
        $log_model->updateTimeOnline($this->cap_info['id']);

        $data['coach_id'] = $this->cap_info['id'];
        $data['uniacid'] = $this->_uniacid;
        $res = Coach::timeEdit($data);
        if ($res === false) {
            return $this->error('设置失败');
        }
        return $this->success('');
    }

    /**
     * 根据接单时间获取维度
     * @return \think\Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getTime()
    {
        $input = $this->request->param();
        if (empty($input['start_time']) || empty($input['end_time'] || empty($input['dat_str']))) {
            return $this->error('请选择接单时间');
        }
        $coach_id = $this->cap_info['id'];
        $data = $this->getTimeData($input['start_time'], $input['end_time'], $coach_id, $input['dat_str'],1);
        return $this->success($data);
    }

    /**
     * 获取天数
     * @return mixed
     */
    protected function getDay()
    {

        $config_model = new Config();

        $config = $config_model->dataInfo(['uniacid' => $this->_uniacid]);

        $start_time = strtotime(date('Y-m-d', time()));

        $i = 0;

        while ($i < $config['max_day']) {

            $str = $start_time + $i * 86400;

            $data[$i]['dat_str'] = $str;

            $data[$i]['dat_text'] = date('m-d', $str);

            $data[$i]['week'] = changeWeek(date('w', $str));

            $i++;
        }

        return $data;


    }

    /**
     * 车费列表
     * @return \think\Response
     * @throws \think\db\exception\DbException
     */
    public function carMoneyList()
    {
        $input = $this->_param;

        $dis[] = ['uniacid', '=', $this->_uniacid];
        $dis[] = ['coach_id', '=', $this->cap_info['id']];

        if (!empty($input['name'])) {
            $dis[] = ['order_code', 'like', '%' . $input['name'] . '%'];
        }

        if (!empty($input['start_time'])) {
            $dis[] = ['serout_time', '>=', $input['start_time']];;
        }

        if (!empty($input['end_time'])) {
            $dis[] = ['serout_time', '<=', $input['end_time']];;
        }

        $dis[] = ['pay_type', '=', 7];
        $dis[] = ['car_type', '=', 1];

        $list = $this->order_model->carMoneyList($dis);
        return $this->success($list);
    }

    /**
     * 订单数量
     * @return \think\Response
     */
    public function getOrderNum()
    {
        $data = [
            'wait'     => $this->order_model->getOrderNum([['uniacid', '=', $this->_uniacid], ['coach_id', '=', $this->cap_info['id']], ['pay_type', '=', 2]]),
            'start'    => $this->order_model->getOrderNum([['uniacid', '=', $this->_uniacid], ['coach_id', '=', $this->cap_info['id']], ['pay_type', 'in', [3, 4, 5]]]),
            'progress' => $this->order_model->getOrderNum([['uniacid', '=', $this->_uniacid], ['coach_id', '=', $this->cap_info['id']], ['pay_type', '=', 6]]),
        ];
        return $this->success($data);
    }

    /**
     * 分类列表
     * @return \think\Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function carteList()
    {
        $list = ShopCarte::getListNoPage(['status' => 1, 'uniacid' => $this->_uniacid]);
        return $this->success($list);
    }

    /**
     * 商品列表
     * @return \think\Response
     * @throws \think\db\exception\DbException
     */
    public function goodsList()
    {
        $input = $this->request->param();
        $where = [];
        if (!empty($input['name'])) {
            $where[] = ['name', 'like', '%' . $input['name'] . '%'];
        }
        if (!empty($input['carte'])) {
            $where[] = ['', 'exp', Db::raw("find_in_set({$input['carte']},carte)")];
        }
        $where[] = ['status', '=', 1];
        $data = ShopGoods::getList($where);
        return $this->success($data);
    }

    /**
     * 商品详情
     * @return \think\Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function goodsInfo()
    {
        $id = $this->request->param('id', '');
        if (empty($id)) {
            return $this->error('商品不存在');
        }
        $data = ShopGoods::getInfo(['id' => $id]);
        $data['images'] = json_decode($data['images'], true);
        return $this->success($data);
    }

    /**
     * 添加反馈
     * @return \think\Response
     */
    public function addFeedback()
    {
        $input = $this->request->only(['type_name', 'order_code', 'content', 'images', 'video_url']);
        $rule = [
            'type_name' => 'require',
            'content'   => 'require',
        ];
        $validate = \think\facade\Validate::rule($rule);
        if (!$validate->check($input)) {
            return $this->error($validate->getError());
        }
        $input['coach_id'] = $this->cap_info['id'];
        $input['uniacid'] = $this->_uniacid;
        if (!empty($input['images'])) {
            $input['images'] = json_encode($input['images']);
        }
        $input['create_time'] = time();
        $res = Feedback::insert($input);
        if ($res) {
            return $this->success('');
        }
        return $this->error('提交失败');
    }

    /**
     * 反馈列表
     * @return \think\Response
     */
    public function listFeedback()
    {
        $input = $this->request->param();
        $where = [];
        if (isset($input['status']) && in_array($input['status'], [1, 2])) {
            $where[] = ['a.status', '=', $input['status']];
        }
        $where[] = ['a.coach_id', '=', $this->cap_info['id']];
        $where[] = ['a.uniacid', '=', $this->_uniacid];
        $data = Feedback::getList($where);
        $data['wait'] = Feedback::where(['coach_id' => $this->cap_info['id'], 'uniacid' => $this->_uniacid, 'status' => 1])->count();
        return $this->success($data);
    }

    /**
     * 详情
     * @return \think\Response
     */
    public function feedbackInfo()
    {
        $id = $this->request->param('id');
        if (empty($id)) {
            return $this->error('参数错误');
        }
        $data = Feedback::getInfo(['a.id' => $id]);
        return $this->success($data);
    }

    /**
     * 订单列表
     * @return \think\Response
     */
    public function appealOrder()
    {
        $name = $this->request->param('name', '');
        $dis = [];

        if (!empty($name)) {

            $dis[] = ['b.goods_name', 'like', '%' . $name . '%'];

            $dis[] = ['a.order_code', 'like', '%' . $name . '%'];

        }
        $where = [
            'a.coach_id' => $this->cap_info['id'],
            'a.pay_type' => 7,
            'a.is_comment' => 1,
            'a.uniacid' => $this->_uniacid
        ];
        $order = (new Order())->indexDataList($where, $dis);
        return $this->success($order);
    }

    /**
     * 提交申诉
     * @return \think\Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function addAppeal()
    {
        $input = $this->request->only(['order_code', 'content']);
        if (empty($input['order_code']) || empty($input['content'])) {
            return $this->error('请检查参数');
        }
        $order = Order::where(['order_code' => $input['order_code'], 'coach_id' => $this->cap_info['id'], 'pay_type' => 7, 'is_comment' => 1])->find();
        if (empty($order)) {
            return $this->error('订单不存在');
        }
        $input['coach_id'] = $this->cap_info['id'];
        $input['create_time'] = time();
        $input['order_id'] = $order['id'];
        $input['uniacid'] = $this->_uniacid;
        $res = Appeal::insert($input);
        if ($res) {
            return $this->success('');
        }
        return $this->error('申诉失败');
    }

    /**
     * 申诉列表
     * @return \think\Response
     */
    public function appealList()
    {
        $input = $this->request->param();
        $limit = $this->request->param('limit',10);
        $where = [];
        if (isset($input['status']) && in_array($input['status'], [1, 2])) {
            $where[] = ['a.status', '=', $input['status']];
        }
        $where[] = ['a.coach_id', '=', $this->cap_info['id']];
        $where[] = ['a.uniacid', '=', $this->_uniacid];
        $data = Appeal::getList($where,$limit);
        $data['wait'] = Appeal::where(['coach_id' => $this->cap_info['id'], 'uniacid' => $this->_uniacid, 'status' => 1])->count();
        return $this->success($data);
    }


    /**
     * @author chenniang
     * @DataTime: 2022-10-24 15:25
     * @功能说明:获取用户标签
     */
    public function userLabelList(){

        $input = $this->_param;

        $label_model = new UserLabelData();

        $data = $label_model->getUserLabel($input['user_id']);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-10-24 15:25
     * @功能说明:获取标签列表
     */
    public function labelList(){

        $input = $this->_param;

        $label_model = new UserLabelList();

        $dis = [

            'uniacid' => $this->_uniacid,

            'status'  => 1
        ];

        $data = $label_model->where($dis)->order('id desc')->select()->toArray();

        return $this->success($data);

    }




    /**
     * @author chenniang
     * @DataTime: 2022-10-24 15:25
     * @功能说明:添加用户标签
     */
    public function userLabelAdd(){

        $input = $this->_input;

        $label_model = new UserLabelData();

        $list_model  = new UserLabelList();

        $order_mdoel = new Order();

        $order_mdoel->dataUpdate(['id'=>$input['order_id']],['label_time'=>time()]);

        foreach ($input['label'] as $k=>$value){

            $title = $list_model->where(['id'=>$value])->value('title');

            $arr[$k] = [

                'uniacid' => $this->_uniacid,

                'label_id'=> $value,

                'user_id' => $input['user_id'],

                'title'   => $title,

                'create_time' => time(),

            ];

        }

        $data = $label_model->saveAll($arr);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-25 17:40
     * @功能说明：技师重置分享码
     *
     */

    public function coachBalanceQr(){

        $input = $this->_param;

        $key = 'balance_coach'.$this->cap_info['id'].'-'.$this->is_app;

        $qr  = getCache($key,$this->_uniacid);

        if(empty($qr)){
            //小程序
            if($this->is_app==0){

                $input['page'] = 'user/pages/stored/list';

                $input['coach_id'] = $this->cap_info['id'];

                $user_model = new User();
                //获取二维码
                $qr = $user_model->orderQr($input,$this->_uniacid);

            }else{

                $page = 'https://'.$_SERVER['HTTP_HOST'].'/h5/#/user/pages/stored/list?coach_id='.$this->cap_info['id'];

                $qr = base64ToPng(getCode($this->_uniacid,$page));
            }

            setCache($key,$qr,86400,$this->_uniacid);
        }

        $qr = !empty($qr)?$qr:'https://'.$_SERVER['HTTP_HOST'].'/favicon.ico';

        return $this->success($qr);
    }


    /**
     * @author chenniang
     * @DataTime: 2022-11-08 18:26
     * @功能说明:技师等级
     */
    public function coachLevel(){
        //本期业绩
        $current_achievement = $this->model->getCurrentAchievement($this->cap_info['id'],$this->_uniacid);

        $coach_level = $this->model->getCoachLevel($this->cap_info['id'],$this->_uniacid);

        $coach_level = array_merge($coach_level,$current_achievement);

        $level_model  = new CoachLevel();

        $dis = [

            'uniacid' => $this->_uniacid,

            'status'  => 1
        ];

        $cap_info['level_list'] = $level_model->where($dis)->order('top,id desc')->select()->toArray();

        if(!empty($cap_info['level_list'])){

            foreach ($cap_info['level_list'] as $key=> &$value){

                $value['lower'] = $level_model->where($dis)->where('time_long','<',$value['time_long'])->max('time_long');

                $level = $this->model->coachLevelInfo($value);

                $value['data'] = $level;

            }

        }

        $cap_info['coach_level'] = $coach_level;

        $config_model = new ConfigSetting();

        $config = $config_model->dataInfo($this->_uniacid);

        $cap_info['coach_level_show'] = $config['coach_level_show'];

        return $this->success($cap_info);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-12-09 15:18
     * @功能说明:技师获取客户虚拟电话
     */
    public function getVirtualPhone(){

        $input = $this->_input;

        $order = $this->order_model->dataInfo(['id'=>$input['order_id']]);

        $called = new \app\virtual\model\Config();

        $res = $called->getVirtual($order);

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2023-02-23 15:15
     * @功能说明:储值佣金总金额
     */
    public function balanceCommissionData(){

        $input = $this->_param;

        $integral_model = new Integral();

        $dis[] = ['status','=',1];

        $dis[] = ['coach_id','=',$this->cap_info['id']];

        $data['total_cash'] = $integral_model->where($dis)->where('type','=',1)->sum('integral');

        $data['total_integral'] = $integral_model->where($dis)->where('type','=',0)->sum('integral');

        $data['total_cash'] = round($data['total_cash'],2);

        $data['total_integral'] = round($data['total_integral'],2);

        if(!empty($input['start_time'])){

            $dis[] = ['create_time','between',"{$input['start_time']},{$input['end_time']}"];

            $data['cash'] = $integral_model->where($dis)->where('type','=',1)->sum('integral');

            $data['integral'] = $integral_model->where($dis)->where('type','=',0)->sum('integral');

            $data['cash'] = round($data['cash'],2);

            $data['integral'] = round($data['integral'],2);

        }

        return $this->success($data);

    }

    /**
     * @author chenniang
     * @DataTime: 2023-02-23 15:06
     * @功能说明：储值佣金列表
     */
    public function balanceCommissionList(){

        $input = $this->_param;

        $integral_model = new Integral();

        $dis[] = ['status','=',1];

        $dis[] = ['coach_id','=',$this->cap_info['id']];

        if(!empty($input['start_time'])){

            $dis[] = ['create_time','between',"{$input['start_time']},{$input['end_time']}"];

        }

        $month = !empty($input['month'])?$input['month']:'';

        $data = $integral_model->coachDataList($dis,10,$month);

        if(!empty($data['data'])){

            $user_model = new User();

            $balance_model = new BalanceOrder();

            foreach ($data['data'] as &$v){

                $order = $balance_model->dataInfo(['id'=>$v['order_id']]);

                $v['nickName'] = $user_model->where(['id'=>$order['user_id']])->value('nickName');

                $v['user_cash']= $order['pay_price'];

                $year  = date('Y',$v['create_time']);

                $month = date('m',$v['create_time']);

                $v['month_text'] = $year.'年'.$month.'月';

                $v['month'] = date('Y-m',$v['create_time']);

                $v['create_time'] = date('Y.m.d H:i:s',$v['create_time']);

                $v['total_cash']     = $integral_model->where($dis)->where('type','=',1)->whereMonth('create_time',$v['month'])->sum('integral');

                $v['total_integral'] = $integral_model->where($dis)->where('type','=',0)->whereMonth('create_time',$v['month'])->sum('integral');

                $v['total_cash'] = round($v['total_cash'],2);

                $v['total_integral'] = round($v['total_integral'],2);

            }

        }

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2023-02-27 14:24
     * @功能说明:技师佣金列表
     */
    public function coachCommissionList(){

        $input = $this->_param;

        $order_model = new Order();

        $dis[] = ['pay_type','=',7];

        $dis[] = ['coach_id','=',$this->cap_info['id']];

        $dis[] = ['is_add','=',0];

        if(!empty($input['start_time'])){

            $dis[] = ['create_time','between',"{$input['start_time']},{$input['end_time']}"];

        }

        $month = !empty($input['month'])?$input['month']:'';

        $data = $order_model->coachCashList($dis,10,$month);

        if(!empty($data['data'])){

            foreach ($data['data'] as &$v){

                $son_cash = $order_model->where(['pay_type'=>7,'add_pid'=>$v['id']])->sum('coach_cash');

                $v['coach_cash'] = round($son_cash + $v['coach_cash']+$v['true_car_price'],2);

                $year  = date('Y',$v['create_time']);

                $month = date('m',$v['create_time']);

                $v['month_text'] = $year.'年'.$month.'月';

                $v['month'] = date('Y-m',$v['create_time']);

                $v['create_time'] = date('Y.m.d H:i:s',$v['create_time']);

                $v['total_cash']  = $order_model->where($dis)->whereMonth('create_time',$v['month'])->sum('coach_cash');

                $v['total_count'] = $order_model->where($dis)->whereMonth('create_time',$v['month'])->count();

                $order_id = $order_model->where($dis)->whereMonth('create_time',$v['month'])->column('id');

                $add_order_cash = $order_model->where(['pay_type'=>7])->where('add_pid','in',$order_id)->sum('coach_cash');

                $car_price = $order_model->where($dis)->whereMonth('create_time',$v['month'])->sum('true_car_price');

                $v['total_cash']= round($v['total_cash']+$add_order_cash+$car_price,2);

            }

        }

        return $this->success($data);

    }




    /**
     * @author chenniang
     * @DataTime: 2023-02-23 15:15
     * @功能说明:技师佣金总金额
     */
    public function coachCommissionData(){

        $input = $this->_param;

        $order_model = new Order();

        $dis[] = ['pay_type','=',7];

        $dis[] = ['coach_id','=',$this->cap_info['id']];

        $dis[] = ['is_add','=',0];

        $coach_cash = $order_model->where($dis)->sum('coach_cash');

        $car_price  = $order_model->where($dis)->sum('true_car_price');

        $order_id   = $order_model->where($dis)->column('id');

        $add_coach_price= $order_model->where(['pay_type'=>7])->where('add_pid','in',$order_id)->sum('coach_cash');

        $data['total_service_cash'] = round($coach_cash+$add_coach_price,2);

        $data['total_car_cash'] = round($car_price,2);

        if(!empty($input['start_time'])){

            $dis[] = ['create_time','between',"{$input['start_time']},{$input['end_time']}"];

            $coach_cash = $order_model->where($dis)->sum('coach_cash');

            $car_price  = $order_model->where($dis)->sum('true_car_price');

            $data['count']  = $order_model->where($dis)->count();

            $order_id   = $order_model->where($dis)->column('id');

            $add_coach_price= $order_model->where(['pay_type'=>7])->where('add_pid','in',$order_id)->sum('coach_cash');

            $data['service_cash'] = round($coach_cash+$car_price+$add_coach_price,2);

        }

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2023-02-28 11:03
     * @功能说明:技师佣金详情
     */
    public function coachCommissionInfo(){

        $input = $this->_param;

        $order_model = new Order();

        $order = $order_model->where(['id'=>$input['id']])->field('id,order_code,true_service_price,true_car_price,coach_cash,coach_balance,service_price,discount,start_time,end_time')->find()->toArray();

        $order['time_text'] = date('Y-m-d H:i',$order['start_time']).'~'.date('H:i',$order['end_time']);
        //加钟订单
        $order['add_order'] = $order_model->where(['pay_type'=>7,'add_pid'=>$input['id']])->field('id,order_code,true_service_price,true_car_price,coach_cash,coach_balance,service_price,discount,start_time,end_time')->select()->toArray();

        if(!empty($order['add_order'])){

            foreach ($order['add_order'] as &$value){

                $value['time_text'] = date('Y-m-d H:i',$value['start_time']).'~'.date('H:i',$value['end_time']);
            }

        }

        return $this->success($order);

    }




    /**
     * @author chenniang
     * @DataTime: 2021-03-15 14:58
     * @功能说明:订单详情
     */
    public function orderInfo(){

        $input = $this->_param;

        $dis = [

            'id' => $input['id'],

        ];

        $data = $this->order_model->dataInfo($dis);

        if(empty($data)){

            $this->errorMsg('订单已被删除');
        }
        //是否能加钟
        $data['can_add_order'] = $this->order_model->orderCanAdd($data);

        $arr = ['create_time','pay_time','serout_time','arrive_time','receiving_time','start_service_time','order_end_time'];

        foreach ($arr as $value){

            $data[$value] = !empty($data[$value])?date('Y-m-d H:i:s',$data[$value]):0;
        }

        $data['start_time'] = date('Y-m-d H:i',$data['start_time']).'-'.date('H:i',$data['end_time']);
        //剩余可申请退款数量
        $can_refund_num = array_sum(array_column($data['order_goods'],'can_refund_num'));
        //是否可以申请退款
        if((in_array($data['pay_type'],[2,3,4,5])&&$can_refund_num>0)){

            $data['can_refund'] = 1;

        }else{

            $data['can_refund'] = 0;
        }

        $data['distance']   = distance_text($data['distance']);

        $data['over_time'] -= time();

        $data['over_time']  = $data['over_time']>0?$data['over_time']:0;
        //加钟订单
        if($data['is_add']==0){

            $data['add_order_id'] = $this->order_model->where(['add_pid'=>$data['id']])->where('pay_type','>',1)->field('id,order_code')->select()->toArray();

        }else{

            $data['add_pid'] = $this->order_model->where(['id'=>$data['add_pid']])->field('id,order_code')->find();

        }

        $order_model = new OrderData();
        //订单附表
        $order_data = $order_model->dataInfo(['order_id'=>$input['id'],'uniacid'=>$this->_uniacid]);

        $data = array_merge($order_data,$data);

        $data['sign_time'] = !empty($data['sign_time'])?date('Y-m-d H:i:s',$data['sign_time']):'';

        $shield_model = new ShieldList();

        $shield = $shield_model->dataInfo(['user_id'=>$data['user_id'],'type'=>2,'coach_id'=>$data['coach_id']]);

        $data['can_again'] = !empty($shield)?0:1;
        //查询是否有转派记录
        $change_log_model = new CoachChangeLog();

        $change_log = $change_log_model->dataInfo(['order_id'=>$data['id'],'status'=>1]);

        if(!empty($change_log)){

            $data['old_coach_name'] = $this->model->where(['id'=>$change_log['init_coach_id']])->value('coach_name');
        }

        $admin_model = new \app\massage\model\Admin();
        //代理商电话
        $data['admin_phone'] = $admin_model->where(['id'=>$data['admin_id']])->value('phone');

        return $this->success($data);

    }




    /**
     * @author chenniang
     * @DataTime: 2023-01-30 16:03
     * @功能说明:屏蔽用户
     */
    public function shieldUserAdd(){

        $input = $this->_input;

        $dis = [

            'coach_id' => $this->cap_info['id'],

            'user_id'  => $input['user_id'],

            'type'     => 3,

            'uniacid'  => $this->_uniacid
        ];

        $shield_model = new ShieldList();
        //没屏蔽过再屏蔽
        $find = $shield_model->dataInfo($dis);

        if(empty($find)){

            $shield_model->dataAdd($dis);

        }

        return $this->success(true);

    }


    /**
     * @author chenniang
     * @DataTime: 2023-01-30 16:03
     * @功能说明:解除用户屏蔽
     */
    public function shieldUserDel(){

        $input = $this->_input;

        $dis = [

            'id' => $input['id'],
        ];

        $shield_model = new ShieldList();

        $res = $shield_model->where($dis)->delete();

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2023-01-30 16:03
     * @功能说明:用户屏蔽列表
     */
    public function shieldCoachList(){

        $input = $this->_param;

        $dis = [

            'a.coach_id' => $this->cap_info['id'],

            'a.type'    => 3
        ];

        $shield_model = new ShieldList();

        $res = $shield_model->dataUserList($dis);

        return $this->success($res);

    }

}
