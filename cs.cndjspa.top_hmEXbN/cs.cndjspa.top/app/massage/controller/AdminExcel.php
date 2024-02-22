<?php
namespace app\massage\controller;
use app\AdminRest;
use app\massage\model\Article;

use app\massage\model\ArticleList;
use app\massage\model\Cap;
use app\massage\model\Date;

use app\massage\model\OrderAddress;
use app\massage\model\OrderGoods;
use app\massage\model\RefundOrder;
use app\massage\model\SubData;
use app\massage\model\SubList;
use app\massage\model\User;
use app\massage\model\Wallet;
use longbingcore\wxcore\Excel;
use think\App;
use app\massage\model\Order as Model;


class AdminExcel extends AdminRest
{


    protected $model;

    protected $order_goods_model;

    protected $refund_order_model;

    public function __construct(App $app) {

        parent::__construct($app);

        $this->model = new Model();

        $this->order_goods_model = new OrderGoods();

        $this->refund_order_model = new RefundOrder();

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-15 14:43
     * @功能说明:列表
     */
    public function orderList(){

        $input = $this->_param;

        $dis[] = ['a.uniacid','=',$this->_uniacid];
        //时间搜素
        if(!empty($input['start_time'])&&!empty($input['end_time'])){

            $start_time = $input['start_time'];

            $end_time = $input['end_time'];

            $dis[] = ['a.create_time','between',"$start_time,$end_time"];
        }
        //商品名字搜索
        if(!empty($input['goods_name'])){

            $dis[] = ['c.goods_name','like','%'.$input['goods_name'].'%'];
        }
        //手机号搜索
        if(!empty($input['mobile'])){

            $order_address_model = new OrderAddress();

            $order_address_dis[] = ['mobile','like','%'.$input['mobile'].'%'];

            $order_id = $order_address_model->where($order_address_dis)->column('order_id');

            $dis[] = ['a.id','in',$order_id];
        }

        if($this->_user['is_admin']==0){

            $dis[] = ['a.admin_id','in',$this->admin_arr];
        }

        if(!empty($input['admin_id'])){

            $dis[] = ['a.admin_id','=',$input['admin_id']];
        }

        if(!empty($input['pay_type'])){
            //订单状态搜索
            $dis[] = ['a.pay_type','=',$input['pay_type']];

        }else{
            //除开待转单
            $dis[] = ['a.pay_type','<>',8];

        }

        $map = [];
        //店铺名字搜索
        if(!empty($input['coach_name'])){

            $map[] = ['b.coach_name','like','%'.$input['coach_name'].'%'];

            $map[] = ['d.now_coach_name','like','%'.$input['coach_name'].'%'];
        }

        if(!empty($input['order_code'])){

            $dis[] = ['a.order_code','like','%'.$input['order_code'].'%'];
        }

        if(!empty($input['channel_cate_id'])){

            $dis[] = ['e.cate_id','=',$input['channel_cate_id']];

        }

        if(!empty($input['channel_name'])){

            $dis[] = ['e.user_name','like','%'.$input['channel_name'].'%'];
        }

        if(!empty($input['is_channel'])){

            $dis[] = ['a.pay_type','>',1];

            $dis[] = ['a.channel_id','<>',0];

        }
        //是否是加钟
        if(isset($input['is_add'])){

            $dis[] = ['a.is_add','=',$input['is_add']];

        }

        if(!empty($input['is_coach'])){

            if($input['is_coach']==2){

                $dis[] = ['a.coach_id','=',0];
            }else{

                $dis[] = ['a.coach_id','>',0];

            }

        }

        $data = $this->model->adminDataSelect($dis,$map);

        if(!empty($input['is_channel'])){

            if(!empty($input['is_add'])){

                $name = '渠道财务加单';

                $type = 2;

            }else{

                $name = '渠道财务订单';

                $type = 1;

            }

        }else{

            if(!empty($input['is_add'])&&$input['is_add']==1){

                $name = '加单列表';

                $type = 3;

            }else{

                $name = '订单列表';

                $type = 2;

            }

        }

        $header[] = '订单ID';
        $header[] = '服务项目';
        $header[] = '项目价格';
        $header[] = '项目数量';
        $header[] = '下单人';
        $header[] = '手机号';
        $header[] = '技师';
        if(empty($input['is_add'])){
             $header[] = '技师类型';
        }

        if(!empty($input['is_channel'])){

            $header[] = '渠道商';

            $header[] = '渠道';
        }

        $header[] = '服务开始时间';

        if(empty($input['is_add'])){

            $header[] = '出行费用';
        }

        $header[] = '服务项目费用';

        if(empty($input['is_add'])){

            $header[] = '实收金额';
        }
        $header[] = '退款金额';

        if(empty($input['is_add'])){

            $header[] = '子订单号';

        }else{

            $header[] = '主订单号';

        }

        $header[] = '系统订单号';
        $header[] = '付款订单号';
        $header[] = '代理商';
        $header[] = '下单时间';
        $header[] = '支付方式';
        $header[] = '状态';

        $new_data = [];

        foreach ($data as $v){

            $info   = array();

            $info[] = $v['id'];

            $info[] = $v['goods_name'];

            $info[] = $v['price'];

            $info[] = $v['num'];

            $info[] = $v['user_name'];

            $info[] = $v['mobile'];

            $info[] = !empty($v['coach_info']['coach_name'])?$v['coach_info']['coach_name']:'';

            if(empty($input['is_add'])){

                $info[] = $v['coach_id']>0?'入驻技师':'非入驻技师';
            }

            if(!empty($input['is_channel'])){

                $info[] = $v['channel_name'];

                $info[] = $v['channel'];
            }

            $info[] = date('Y-m-d H:i:s',$v['start_time']);

            if(empty($input['is_add'])) {

                $info[] = $v['car_price'];

            }

            $info[] = $v['init_service_price'];

            if(empty($input['is_add'])) {

                $info[] = $v['pay_price'];
            }

            $info[] = $v['refund_price'];

            if(empty($input['is_add'])){

                $info[] = !empty($v['add_order_id'][0]['order_code'])?$v['add_order_id'][0]['order_code']:'';

            }else{

                $info[] = !empty($v['add_pid']['order_code'])?$v['add_pid']['order_code']:'';;

            }

            $info[] = $v['order_code'];

            $info[] = $v['transaction_id'];

            $info[] = $v['admin_name'];

            $info[] = date('Y-m-d H:i:s',$v['create_time']);

            $info[] = $this->payModel($v['pay_model']);

            $info[] = $this->orderStatusText($v['pay_type']);

            $new_data[] = $info;
        }


        $excel = new Excel();

        $excel->excelExport($name,$header,$new_data,'',$type);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-12-26 21:59
     * @功能说明:支付方式
     */
    public function payModel($type){

        switch ($type){

            case 1;

                $text = '微信支付';
                break;

            case 2;

                $text = '余额支付';
                break;
            case 3;

                $text = '支付宝支付';
                break;
        }

        return $text;

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-30 16:32
     * @功能说明:
     */
    public function orderStatusText($status){

        switch ($status){

            case 1:
                return '待支付';

                break;
            case 2:
                return '待服务';

                break;
            case 3:
                return '技师接单';

                break;
            case 4:
                return '技师出发';

                break;
            case 5:
                return '技师到达';

                break;
            case 6:
                return '服务中';

                break;

            case 7:
                return '已完成';

                break;
            case 8:
                return '待转单';

                break;

            case -1:
                return '已取消';

                break;

        }

    }




    /**
     * @author chenniang
     * @DataTime: 2021-03-18 13:37
     * @功能说明:财务数据统计导出
     */
    public function dateCount(){

        $input = $this->_param;

        $cap_id = $input['cap_id'];

        $date_model   = new Date();

        $wallet_model = new Wallet();

        $cap_model    = new Cap();

        $date_model->dataInit($this->_uniacid);

        $dis[] = ['uniacid','=',$this->_uniacid];
        //时间搜素
        if(!empty($input['start_time'])&&!empty($input['end_time'])){

            $start_time = $input['start_time'];

            $end_time = $input['end_time'];

            $dis[] = ['date_str','between',"$start_time,$end_time"];
        }

        $date_list = $date_model->dataList($dis,100000);
        //店铺名字
        $store_name = $cap_model->where(['id'=>$cap_id])->value('store_name');
        //开始时间结束时间
        if(!empty($start_time)){

            $date_list['start_time'] = $start_time;

            $date_list['end_time']   = $end_time;

        }else{

            $date_list['start_time'] = $date_model->where(['uniacid'=>$this->_uniacid])->min('date_str');

            $date_list['end_time']   = $date_model->where(['uniacid'=>$this->_uniacid])->max('date_str');

        }

        if(!empty($date_list['data'])){

            foreach ($date_list['data'] as $k=>$v){
                //订单金额
                $date_list['data'][$k]['order_price']  = $this->model->datePrice($v['date_str'],$this->_uniacid,$cap_id);
                //退款金额
                $date_list['data'][$k]['refund_price'] = $this->refund_order_model->datePrice($v['date_str'],$this->_uniacid,$cap_id);
                //提现金额
                $date_list['data'][$k]['wallet_price'] = $wallet_model->datePrice($v['date_str'],$this->_uniacid,$cap_id);

            }

        }

        $name  = $store_name.'财务报表';

        $header=[
            '收支时间',
            '订单收入',
            '订单退款',
            '提现（元）',
        ];

        $new_data = [];

        foreach ($date_list['data'] as $v){

            $info   = array();

            $info[] = $v['date'];

            $info[] = $v['order_price'];

            $info[] = $v['refund_price'];

            $info[] = $v['wallet_price'];

            $new_data[] = $info;
        }

        $excel = new Excel();

        $excel->excelExport($name,$header,$new_data);

        return $this->success($date_list);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-12-15 12:05
     * @功能说明:提交内容导出
     */
    public function subDataList(){

        $input = $this->_param;

        $article_model = new ArticleList();

        $sub_list_model= new SubList();

        $sub_data_model= new SubData();

        $article_title = $article_model->where(['id'=>$input['article_id']])->value('title');
        //获取导出标题
        $title_data = $article_model->getFieldTitle($input['article_id']);

        $title = ['用户ID','微信昵称'];

        $title = array_merge($title,array_column($title_data,'title'));

        $title[] = '提交时间';

        $name  = '文章表单数据导出-'.$article_title;

        $diss[] = ['article_id','=',$input['article_id']];

        $diss[] = ['status','=',1];

        if(!empty($input['start_time'])&&!empty($input['end_time'])){

            $diss[] = ['create_time','between',"{$input['start_time']},{$input['end_time']}"];

        }

        if(!empty($input['id'])){

            $diss[] = ['id','in',$input['id']];

        }

        $list = $sub_list_model->where($diss)->order('id desc')->select()->toArray();

        $new_data = [];

        if(!empty($list)){

            $user_model = new User();

            foreach ($list as &$v){

                $user_info = $user_model->where(['id'=>$v['user_id']])->field('nickName,avatarUrl')->find();

                $info   = array();

                $info[] = $v['user_id'];

                $info[] = $user_info['nickName'];

                if(!empty($title_data)){

                    foreach ($title_data as $vs){

                        $dis = [

                            'field_id' => $vs['field_id'],

                            'sub_id'   => $v['id']
                        ];

                        $find = $sub_data_model->where($dis)->value('value');;

                        $info[] = !empty($find)?$find:'';
                    }
                }

                $info[] = date('Y-m-d H:i:s',$v['create_time']);

                $new_data[] = $info;

            }

        }

        $excel = new Excel();

        $excel->excelExport($name,$title,$new_data);

        return $this->success(true);

    }








}
