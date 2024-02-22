<?php
namespace app\massage\controller;
use app\AdminRest;
use app\massage\model\Config;
use app\massage\model\Order;
use app\massage\model\Service;
use app\shop\model\Article;
use app\shop\model\Banner;
use app\shop\model\Cap;
use app\shop\model\GoodsCate;
use app\shop\model\GoodsSh;
use app\shop\model\GoodsShList;
use longbingcore\wxcore\aliyun;
use longbingcore\wxcore\aliyunVirtual;
use think\App;
use app\shop\model\Goods as Model;
use think\Db;


class AdminService extends AdminRest
{


    protected $model;

    protected $goods_sh;

    protected $goods_sh_list;

    public function __construct(App $app) {

        parent::__construct($app);

        $this->model = new Service();


    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-15 14:43
     * @功能说明:商品列表
     */
    public function serviceList(){

       // $a = new aliyunVirtual();

       // $res = $a->bindPhone($this->_uniacid,13689612582,18284514093,'2022-12-12 06:32:01','FC100000165926010');
       // $res = $a->delBind($this->_uniacid,1000082385048408,17031981056,'FC100000165926010');

        //https://secret-axb-record-files.oss-cn-shanghai.aliyuncs.com/1000082425773941_0b6391a81217b315_0.mp3?Expires=1673082142&OSSAccessKeyId=LTAI4G1kg5pSvJMv2rKNc7Pz&Signature=po5My96fV6RoCTrClCUS19yCdsw%3D
//        $config = new \app\virtual\model\Config();
//
//        $order_model  = new Order();
//
//        $order = $order_model->dataInfo(['id'=>1874]);
//
//        $res = $config->getVirtual($order);
//
//        dump($res);exit;

        $input = $this->_param;

        $dis[] = ['uniacid','=',$this->_uniacid];

        if(!empty($input['status'])){

            $dis[] = ['status','=',$input['status']];

        }else{

            $dis[] = ['status','>',-1];

        }

        if(!empty($input['name'])){

            $dis[] = ['title','like','%'.$input['name'].'%'];

        }

        $is_add = !empty($input['is_add'])?$input['is_add']:0;

        $dis[] = ['is_add','=',$is_add];

        $data = $this->model->dataList($dis,$input['limit']);

        return $this->success($data);

    }





    /**
     * @author chenniang
     * @DataTime: 2021-03-15 14:58
     * @功能说明:审核详情
     */
    public function serviceInfo(){

        $input = $this->_param;

        $dis = [

            'id' => $input['id']
        ];

        $data = $this->model->dataInfo($dis);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-03 00:27
     * @功能说明:添加
     */
    public function serviceAdd(){

        $input = $this->_input;

        $input['uniacid'] = $this->_uniacid;

        $res = $this->model->dataAdd($input);

        return $this->success($res);

    }



    /**
     * @author chenniang
     * @DataTime: 2021-07-03 00:27
     * @功能说明:添加
     */
    public function serviceUpdate(){

        $input = $this->_input;

        $input['uniacid'] = $this->_uniacid;

        $dis = [

            'id' => $input['id']
        ];

        $res = $this->model->dataUpdate($dis,$input);

        return $this->success($res);

    }













}
