<?php
namespace app\massage\controller;
use app\AdminRest;
use app\massage\info\PermissionMassage;
use app\massage\model\Appeal;
use app\massage\model\ArticleList;
use app\massage\model\CarPrice;
use app\massage\model\City;
use app\massage\model\ClockSetting;
use app\massage\model\Config;
use app\massage\model\ConfigSetting;
use app\massage\model\Feedback;
use app\massage\model\HelpConfig;
use app\massage\model\Lable;
use app\massage\model\MassageConfig;
use app\massage\model\Order;
use app\massage\model\SendMsgConfig;
use app\massage\model\ShortCodeConfig;
use app\massage\model\User;
use app\massage\model\UserLabelList;
use app\reminder\info\PermissionReminder;
use app\shop\model\Article;
use app\massage\model\Banner;
use app\massage\model\MsgConfig;
use app\massage\model\PayConfig;
use app\virtual\info\PermissionVirtual;
use longbingcore\permissions\AdminMenu;
use longbingcore\permissions\SaasAuthConfig;
use think\App;
use app\massage\model\Config as Model;


class AdminSetting extends AdminRest
{


    protected $model;

    protected $admin_model;


    public function __construct(App $app) {

        parent::__construct($app);

        $this->model = new Model();

        $this->admin_model = new \app\massage\model\Admin();

        SaasAuthConfig::getSAuthConfig($this->_uniacid);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-12 15:04
     * @功能说明:配置详情
     */
    public function configInfo(){

        $dis = [

            'uniacid' => $this->_uniacid
        ];

        $data  = $this->model->dataInfo($dis);
        //代理商文章标题
        if(!empty($data['agent_article_id'])){

            $article_model = new ArticleList();

            $data['agent_article_title'] = $article_model->where(['id'=>$data['agent_article_id']])->value('title');
        }

        $config_model = new ConfigSetting();

        $arr = $config_model->dataInfo($this->_uniacid);

        $data = array_merge($data,$arr);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-12 16:14
     * @功能说明:编辑配置
     */
    public function configUpdate(){

        $input = $this->_input;

        $dis = [

            'uniacid' => $this->_uniacid
        ];

        $dataPath = APP_PATH  . 'massage/info/ConfigSetting.php' ;

        $list =  include $dataPath ;

        $list = array_column($list,'key');

        foreach ($input as $k=>$v){

            if(in_array($k,$list)){

                $arr[$k] = $v;

                unset($input[$k]);
            }

        }

        if(!empty($arr)){

            $config_model = new ConfigSetting();

            $config_model->dataUpdate($arr,$this->_uniacid);
        }

        $data = $this->model->dataUpdate($dis,$input);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-12 16:15
     * @功能说明:banner列表
     */
    public function bannerList(){

        $input = $this->_param;

        $dis[] = ['uniacid','=',$this->_uniacid];

        $dis[] = ['status','>',-1];

        $banner_model = new Banner();

        $data = $banner_model->dataList($dis,$input['limit']);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-12 16:18
     * @功能说明:添加banner
     */
    public function bannerAdd(){

        $input = $this->_input;

        $input['uniacid'] = $this->_uniacid;

        $banner_model = new Banner();

        $res = $banner_model->dataAdd($input);

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-12 16:20
     * @功能说明:编辑banner
     */
    public function bannerUpdate(){

        $input = $this->_input;

        $dis = [

            'id' => $input['id']
        ];

        $banner_model = new Banner();

        $res = $banner_model->dataUpdate($dis,$input);

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-19 13:27
     * @功能说明:banner详情
     */
    public function bannerInfo(){

        $input = $this->_param;

        $dis = [

            'id' => $input['id']
        ];

        $banner_model = new Banner();

        $res = $banner_model->dataInfo($dis);

        $article_model = new ArticleList();

        $res['type_title'] = $article_model->where(['id'=>$res['type_id']])->value('title');

        return $this->success($res);
    }







    /**
     * @author chenniang
     * @DataTime: 2021-03-18 10:53
     * @功能说明:支付配置详情
     */
    public function payConfigInfo(){

        $dis = [

            'uniacid' => $this->_uniacid
        ];

        $pay_model = new PayConfig();

        $data = $pay_model->dataInfo($dis);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-18 10:55
     * @功能说明:编辑支付配置
     */
    public function payConfigUpdate(){

        $input = $this->_input;


        $dis = [

            'uniacid' => $this->_uniacid
        ];

        if(isset($input['cert_path'])&&isset($input['key_path'])){

            if(!strstr($input['cert_path'],FILE_UPLOAD_PATH)){

                $input['cert_path'] = FILE_UPLOAD_PATH.$input['cert_path'];

            }
            if(!strstr($input['key_path'],FILE_UPLOAD_PATH)){

                $input['key_path']  = FILE_UPLOAD_PATH.$input['key_path'];
            }
        }

        $pay_model = new PayConfig();

        $data = $pay_model->dataUpdate($dis,$input);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-31 15:16
     * @功能说明:修改密码
     */
    public function updatePass(){

        $input = $this->_input;

        $admin = new \app\massage\model\Admin();

        $update = [

            'passwd'  => checkPass($input['pass']),
        ];

        $res = $admin->dataUpdate(['uniacid'=>$this->_uniacid,'is_admin'=>1],$update);
        //添加缓存数据
        clearCache(7777);

        SaasAuthConfig::getSAuthConfig($this->_uniacid);

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-12 15:04
     * @功能说明:配置详情
     */
    public function msgConfigInfo(){

        $msg_model = new MsgConfig();

        $dis = [

            'uniacid' => $this->_uniacid
        ];

        $data  = $msg_model->dataInfo($dis);

        return $this->success($data);


    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-12 16:14
     * @功能说明:编辑配置
     */
    public function msgConfigUpdate(){

        $input = $this->_input;

        $msg_model = new MsgConfig();

        $dis = [

            'uniacid' => $this->_uniacid
        ];

        $data  = $msg_model->dataUpdate($dis,$input);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-05 23:09
     * @功能说明:评价标签列表
     */
    public function lableList(){

        $input = $this->_param;

        $dis[] = ['uniacid','=',$this->_uniacid];

        $dis[] = ['status','>',-1];

        $lable_model = new Lable();

        $data = $lable_model->dataList($dis,$input['limit']);

        return $this->success($data);


    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-05 23:09
     * @功能说明:评价标签详情
     */
    public function lableInfo(){

        $input = $this->_param;

        $dis = [

            'id' => $input['id']
        ];

        $lable_model = new Lable();

        $data = $lable_model->dataInfo($dis);

        return $this->success($data);


    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-05 23:09
     * @功能说明:添加评价标签
     */
    public function lableAdd(){

        $input = $this->_input;

        $input['uniacid'] = $this->_uniacid;

        $lable_model = new Lable();

        $data = $lable_model->dataAdd($input);

        return $this->success($data);


    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-05 23:09
     * @功能说明:编辑评价标签
     */
    public function lableUpdate(){

        $input = $this->_input;

        $dis = [

            'id' => $input['id']
        ];


        $lable_model = new Lable();

        $data = $lable_model->dataUpdate($dis,$input);

        return $this->success($data);


    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-16 18:46
     * @功能说明:车费配置详情
     */
    public function carConfigInfo(){

        $car_model = new CarPrice();

        $dis = [

            'uniacid' => $this->_uniacid,

            'city_id' => 0
        ];

        $data = $car_model->dataInfo($dis);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-16 18:46
     * @功能说明:车费配置详情
     */
    public function carConfigUpdate(){

        $input = $this->_input;

        $car_model = new CarPrice();

        $dis = [

            'uniacid' => $this->_uniacid,

            'city_id' => 0
        ];

        $data = $car_model->dataUpdate($dis,$input);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2023-02-02 16:11
     * @功能说明:获取车费配置列表
     */
    public function getCarConfigList(){

        $input = $this->_param;

        $dis[] = ['uniacid','=',$this->_uniacid];

        $dis[] = ['city_id','>',0];

        $car_model = new CarPrice();

        $data = $car_model->dataList($dis,$input['limit']);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2023-02-02 16:11
     * @功能说明:获取车费配置列表
     */
    public function getCarConfigAdd(){

        $input = $this->_param;

        $dis = [

            'uniacid' => $this->_uniacid,

            'city_id' => $input['city_id']
        ];

        $car_model = new CarPrice();

        $find = $car_model->where($dis)->find();

        if(!empty($find)){

            $this->errorMsg('该城市已有车费设置');
        }

        $input['uniacid'] = $this->_uniacid;

        $data = $car_model->dataAdd($input);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2023-02-02 16:11
     * @功能说明:获取车费配置列表
     */
    public function getCarConfigInfo(){

        $input = $this->_param;

        $dis = [

            'id' => $input['id']
        ];

        $car_model = new CarPrice();

        $find = $car_model->where($dis)->find();

        return $this->success($find);

    }


    /**
     * @author chenniang
     * @DataTime: 2023-02-02 16:11
     * @功能说明:获取车费配置编辑
     */
    public function getCarConfigUpdate(){

        $input = $this->_param;

        $car_model = new CarPrice();

        if(!empty($input['city_id'])){

            $dis = [

                'uniacid' => $this->_uniacid,

                'city_id' => $input['city_id']
            ];

            $find = $car_model->where($dis)->where('id','<>',$input['id'])->find();

            if(!empty($find)){

                $this->errorMsg('该城市已有车费设置');
            }
        }

        $dis = [

            'id' => $input['id']
        ];

        $find = $car_model->dataUpdate($dis,$input);

        return $this->success($find);

    }



    /**
     * @author chenniang
     * @DataTime: 2023-02-02 16:11
     * @功能说明:获取车费配置编辑
     */
    public function getCarConfigDel(){

        $input = $this->_param;

        $dis = [

            'id' => $input['id']
        ];

        $car_model = new CarPrice();

        $find = $car_model->where($dis)->delete();

        return $this->success($find);

    }




    /**
     * @author chenniang
     * @DataTime: 2022-06-08 17:17
     * @功能说明:加盟商列表
     */
    public function adminList(){

        $input = $this->_param;

        $dis[] = ['a.status','>',-1];

        $dis[] = ['a.uniacid','=',$this->_uniacid];

        $dis[] = ['a.is_admin','=',0];

        if(!empty($input['city_id'])){

            $dis[] = ['a.city_id','in',$input['city_id']];

        }
        if(!empty($input['username'])){

            $dis[] = ['a.username','like','%'.$input['username'].'%'];

        }

        if(!empty($input['nickName'])){

            $dis[] = ['b.nickName','like','%'.$input['nickName'].'%'];

        }

        if(!empty($input['id'])){

            $dis[] = ['a.id','<>',$input['id']];

        }

        $data = $this->admin_model->adminUserList($dis,$input['limit']);

        if(!empty($data['data'])){

            $city_model = new City();

            foreach ($data['data'] as &$v){

                $v['city_data'] = [];

                $city = $city_model->dataInfo(['id'=>$v['city_id']]);

                if(!empty($city)){
                    //城市代理
                    if($v['city_type']==1){

                        array_push($v['city_data'],$city['pid']);

                        array_push($v['city_data'],$v['city_id']);

                        $v['city'] = $city['title'];

                        $v['province'] = $city_model->where(['id'=>$city['pid']])->value('title');

                    }elseif($v['city_type']==2){

                        $v['area'] = $city['title'];

                        $v['city'] = $city_model->where(['id'=>$city['pid']])->value('title');

                        $province_id =  $city_model->where(['id'=>$city['pid']])->value('pid');

                        $v['province'] = $city_model->where(['id'=>$province_id])->value('title');

                        array_push($v['city_data'],$province_id);
                        //区县代理
                        array_push($v['city_data'],$city['pid']);

                        array_push($v['city_data'],$v['city_id']);

                    }else{

                        array_push($v['city_data'],$v['city_id']);

                        $v['province'] = $city['title'];
                    }
                }
                if(!empty($v['admin_pid'])){

                    $v['admin_ptitle'] = $this->admin_model->where(['id'=>$v['admin_pid']])->value('username');
                }

            }
        }

        return $this->success($data);
    }




    /**
     * @author chenniang
     * @DataTime: 2022-06-08 17:31
     * @功能说明:添加加盟商
     */
    public function adminAdd(){

        $input = $this->_input;

        $input['uniacid'] = $this->_uniacid;

        $input['is_admin'] = 0;

        $check = $this->admin_model->jionAdminCheck($input);

        if(!empty($check['code'])){

            $this->errorMsg($check['msg']);
        }

        $input['passwd']  = checkPass($input['passwd_text']);

        $res = $this->admin_model->dataAdd($input);

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-06-22 21:30
     * @功能说明:加盟商下拉框
     */
    public function adminSelect(){

        $input = $this->_param;

        $dis = [

            'is_admin' => 0,

            'status'   => 1,

            'uniacid'  => $this->_uniacid
        ];

        $data = $this->admin_model->where($dis)->field('id,username')->select()->toArray();

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-06-08 22:45
     * @功能说明:编辑加盟商
     */
    public function adminUpdate(){

        $input = $this->_input;

        $input['uniacid'] = $this->_uniacid;

        $check = $this->admin_model->jionAdminCheck($input);

        if(!empty($check['code'])){

            $this->errorMsg($check['msg']);
        }

        $dis = [

            'id' => $input['id']
        ];

        if(!empty($input['passwd_text'])){

            $input['passwd'] = checkPass($input['passwd_text']);
        }

        $res = $this->admin_model->dataUpdate($dis,$input);

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-06-08 22:49
     * @功能说明:修改状态
     */
    public function adminStatusUpdate(){

        $input = $this->_input;

        $dis = [

            'id' => $input['id']
        ];

        $res = $this->admin_model->dataUpdate($dis,['status'=>$input['status']]);

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-06-08 22:50
     * @功能说明:加盟商详情
     */
    public function adminInfo(){

        $input = $this->_param;

        $dis = [

            'id' => $input['id']
        ];

        $res = $this->admin_model->dataInfo($dis);

        $user_model = new User();

        $res['nickName'] = $user_model->where(['id'=>$res['user_id']])->value('nickName');

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-06-08 23:33
     * @功能说明:用户下拉框
     */
    public function userSelect1(){

        $input = $this->_param;

        $user_model = new User();

        $dis[] = ['uniacid','=',$this->_uniacid];

        if(empty($input['nickName'])){

            return $this->success([]);

        }

        $where[] = ['nickName','like','%'.$input['nickName'].'%'];

        $where[] = ['id','=',$input['nickName']];

        $res = $user_model->where($dis)->where(function ($query) use ($where){
            $query->whereOr($where);
        })->field('id,nickName')->order('id desc')->select()->toArray();

        if(!empty($res)){

            foreach ($res as &$v){

                $v['nickName'] = $v['nickName'].'(ID:'.$v['id'].')';
            }

        }

        return $this->success($res);


    }


    /**
     * @author chenniang
     * @DataTime: 2021-09-22 15:19
     * @功能说明:团长用户列表
     */
    public function userSelect(){

        $input = $this->_param;

        $where1 = [];

        if(!empty($input['nickName'])){

            $where1[] = ['nickName','like','%'.$input['nickName'].'%'];

            $where1[] = ['phone','like','%'.$input['nickName'].'%'];
        }

        $user_model = new User();

        $where[] = ['uniacid','=',$this->_uniacid];

        $list = $user_model->dataList($where,$input['limit'],$where1);

        return $this->success($list);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-06-16 09:56
     * @功能说明:城市列表
     */
    public function cityList(){

        $input = $this->_param;

        $city_model = new City();

        $city_model->provinceInit($this->_uniacid);

        $dis[] = ['uniacid','=',$this->_uniacid];

        $dis[] = ['status','>',-1];

        $dis[] = ['city_type','=',3];

        if(!empty($input['name'])){

            $dis[] = ['title','like','%'.$input['name'].'%'];
        }

        $data = $city_model->dataList($dis,$input['limit']);

        if(!empty($data['data'])){

            foreach ($data['data'] as &$v){

                $v['children'] = $city_model->where(['pid'=>$v['id']])->where('status','>',-1)->select()->toArray();

                if(!empty($v['children'])){

                    foreach ($v['children'] as &$v){

                        $v['children'] = $city_model->where(['pid'=>$v['id']])->where('status','>',-1)->select()->toArray();

                    }
                }

            }
        }

        return $this->success($data);
    }



    /**
     * @author chenniang
     * @DataTime: 2022-06-16 09:58
     * @功能说明:添加城市
     */
    public function cityAdd(){

        $input = $this->_input;

        $input['uniacid'] = $this->_uniacid;

        $city_model = new City();

        $res = $city_model->checkCity($input);

        if(!empty($res['code'])){

            $this->errorMsg($res['msg']);
        }

        $input['true_name'] = $input['title'];

        $res = $city_model->dataAdd($input);

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-06-16 09:59
     * @功能说明:城市详情
     */
    public function cityInfo(){

        $input = $this->_param;

        $dis=[

            'id' => $input['id']
        ];

        $city_model = new City();

        $res = $city_model->dataInfo($dis);

        return $this->success($res);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-06-16 10:37
     * @功能说明:编辑城市
     */
    public function cityUpdate(){

        $input = $this->_input;

        $dis=[

            'id' => $input['id']
        ];

        $input['uniacid'] = $this->_uniacid;

        $city_model = new City();

        if(!empty($input['title'])){

            $res = $city_model->checkCity($input);

            if(!empty($res['code'])){

                $this->errorMsg($res['msg']);
            }

            $last_font = mb_substr(trim($input['title']),-1);


            $input['true_name'] = $last_font=='市'?$input['title']:$input['title'].'市';
        }
        //删除的时候
        if(isset($input['status'])&&$input['status']==-1){

            $data = $city_model->dataInfo($dis);
            //删除省需要删除下面的市
            if($data['city_type']==3){

                $find = $city_model->dataInfo(['pid'=>$data['id'],'status'=>1]);

                if(!empty($find)){

                    $this->errorMsg('请删除下面的市');
                }
            }
            //删除市需要直接删除下面的区
            if($data['city_type']==1){

                $city_model->dataUpdate(['pid'=>$data['id']],['status'=>-1]);

            }

        }

        $res = $city_model->dataUpdate($dis,$input);

        return $this->success($res);

    }




    /**
     * @author chenniang
     * @DataTime: 2022-06-16 09:56
     * @功能说明:城市列表
     */
    public function citySelect(){

        $input = $this->_param;

        $city_type = !empty($input['city_type'])?$input['city_type']:1;

        $dis[] = ['uniacid','=',$this->_uniacid];

        $dis[] = ['status','=',1];

        $dis[] = ['city_type','=',$city_type];

        if(!empty($input['name'])){

            $dis[] = ['title','like','%'.$input['name'].'%'];
        }

        $city_model = new City();

        $data = $city_model->where($dis)->select()->toArray();

        if(!empty($data)){

            foreach ($data as &$v){

                $v['children'] = $city_model->where(['pid'=>$v['id']])->where('status','>',-1)->select()->toArray();

                if(!empty($v['children'])){

                    foreach ($v['children'] as &$vs){

                        $vs['children'] = $city_model->where(['pid'=>$vs['id']])->where('status','>',-1)->select()->toArray();

                    }

                }

            }

        }

        return $this->success($data);
    }


    /**
     * @author chenniang
     * @DataTime: 2022-08-12 10:34
     * @功能说明:获取授权
     */
    public function getSaasAuth(){

        // $data = AdminMenu::getAuthList($this->_uniacid);
        //
        // $p = new PermissionMassage($this->_uniacid,[],'APP');
        //
        // $data['app'] = $p->getSaasValue();
        //
        // $p = new PermissionMassage($this->_uniacid,[],'H5');
        //
        // $data['h5'] = $p->getSaasValue();
        //
        // $p = new PermissionMassage($this->_uniacid,[],'WECHAT');
        //
        // $data['wechat'] = $p->getSaasValue();
        $data = [
          "app"=>1,
          "dynamic"=>true,
          "h5"=>true,
          "massage"=>true,
          "node"=>true,
          "recommend"=>true,
          "reminder"=>true,
          "shop"=>true,
          "store"=>true,
          "virtual"=>true,
          "wechat"=>true
        ];

        return $this->success($data);

    }

    /**
     * 反馈列表
     * @return \think\Response
     */
    public function feedbackList()
    {
        $input = $this->request->param();
        $limit = $this->request->param('limit',10);
        $where = [];
        if (isset($input['status']) && in_array($input['status'], [1, 2])) {
            $where[] = ['a.status', '=', $input['status']];
        }
        $where[] = ['a.uniacid', '=', $this->_uniacid];
        $data = Feedback::getList($where,$limit);
        $data['status1'] = Feedback::where(['uniacid' => $this->_uniacid, 'status' => 1])->count();
        $data['status2'] = Feedback::where(['uniacid' => $this->_uniacid, 'status' => 2])->count();
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
     * 处理反馈
     * @return \think\Response
     */
    public function feedbackHandle()
    {
        $id = $this->request->param('id');
        $reply_content = $this->request->param('reply_content','');
        $reply_content = html_entity_decode($reply_content);
        if (empty($id)) {
            return $this->error('参数错误');
        }
        $res = Feedback::update(['status'=>2,'reply_content'=>$reply_content,'reply_date'=>date('Y-m-d H:i:s')],['id'=>$id]);
        if ($res===false){
            return $this->error('处理失败');
        }
        return $this->success('');
    }


    /**
     * 反馈列表
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
        $where[] = ['a.uniacid', '=', $this->_uniacid];
        $data = Appeal::getList($where,$limit);
        $data['status1'] = Appeal::where(['uniacid' => $this->_uniacid, 'status' => 1])->count();
        $data['status2'] = Appeal::where(['uniacid' => $this->_uniacid, 'status' => 2])->count();
        return $this->success($data);
    }

    /**
     * 详情
     * @return \think\Response
     */
    public function appealInfo()
    {
        $id = $this->request->param('id');
        if (empty($id)) {
            return $this->error('参数错误');
        }
        $data = Appeal::getInfo(['a.id' => $id]);
        return $this->success($data);
    }

    /**
     * 处理反馈
     * @return \think\Response
     */
    public function appealHandle()
    {
        $id = $this->request->param('id');
        $reply_content = $this->request->param('reply_content','');
        if (empty($id)) {
            return $this->error('参数错误');
        }
        $res = Appeal::update(['status'=>2,'reply_content'=>$reply_content,'reply_date'=>date('Y-m-d H:i:s')],['id'=>$id]);
        if ($res===false){
            return $this->error('处理失败');
        }
        return $this->success('');
    }


    /**
     * @author chenniang
     * @DataTime: 2022-10-24 14:53
     * @功能说明:用户标签
     */
    public function userLabelList(){

        $input = $this->_param;

        $dis[] = ['uniacid','=',$this->_uniacid];

        $dis[] = ['status','>',-1];

        $label_model = new UserLabelList();

        $data = $label_model->dataList($dis,$input['limit']);

        return $this->success($data);
    }


    /**
     * @author chenniang
     * @DataTime: 2022-10-24 14:53
     * @功能说明:添加用户标签
     */
    public function userLabelAdd(){

        $input = $this->_input;

        $input['uniacid'] = $this->_uniacid;

        $label_model = new UserLabelList();

        $data = $label_model->dataAdd($input);

        return $this->success($data);
    }



    /**
     * @author chenniang
     * @DataTime: 2022-10-24 14:53
     * @功能说明:添加用户标签
     */
    public function userLabelInfo(){

        $input = $this->_param;

        $dis = [

            'id' => $input['id']
        ];

        $label_model = new UserLabelList();

        $data = $label_model->dataInfo($dis);

        return $this->success($data);
    }



    /**
     * @author chenniang
     * @DataTime: 2022-10-24 14:53
     * @功能说明:添加用户标签
     */
    public function userLabelUpdate(){

        $input = $this->_input;

        $dis = [

            'id' => $input['id']
        ];

        $label_model = new UserLabelList();

        $data = $label_model->dataUpdate($dis,$input);

        return $this->success($data);
    }




    /**
     * @author chenniang
     * @DataTime: 2021-03-12 15:04
     * @功能说明:配置详情
     */
    public function helpConfigInfo(){

        $dis = [

            'uniacid' => $this->_uniacid
        ];

        $config = new HelpConfig();

        $data  = $config->dataInfo($dis);

        $user_model = new User();

        $data['help_user_id'] = !empty($data['help_user_id'])?explode(',',$data['help_user_id']):[];

        $data['help_user_id'] = $user_model->where('id','in',$data['help_user_id'])->field('id,nickName,avatarUrl,phone')->select()->toArray();

        return $this->success($data);


    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-12 16:14
     * @功能说明:编辑配置
     */
    public function helpConfigUpate(){

        $input = $this->_input;

        $dis = [

            'uniacid' => $this->_uniacid
        ];

        $config = new HelpConfig();

        $input['help_user_id'] = !empty($input['help_user_id'])?implode(',',$input['help_user_id']):'';

        $data = $config->dataUpdate($dis,$input);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-12 15:04
     * @功能说明:配置详情
     */
    public function configInfoSchedule(){

        $dis = [

            'uniacid' => $this->_uniacid
        ];

        $config_model = new MassageConfig();

        $data  = $config_model->dataInfo($dis);

        return $this->success($data);


    }


    /**
     * @author chenniang
     * @DataTime: 2021-03-12 16:14
     * @功能说明:编辑配置
     */
    public function configUpdateSchedule(){

        $input = $this->_input;

        $dis = [

            'uniacid' => $this->_uniacid
        ];

        $config_model = new MassageConfig();

        $data  = $config_model->dataUpdate($dis,$input);

        return $this->success($data);

    }



    /**
     * @author chenniang
     * @DataTime: 2021-07-16 18:46
     * @功能说明:模版消息配置详情
     */
    public function sendMsgConfigInfo(){

        $config_model = new SendMsgConfig();

        $config_model->initData($this->_uniacid);

        $dis = [

            'uniacid' => $this->_uniacid,

        ];

        $data = $config_model->dataInfo($dis);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-16 18:46
     * @功能说明:模版消息配置编辑
     */
    public function sendMsgConfigUpdate(){

        $input = $this->_input;

        $config_model = new SendMsgConfig();

        $dis = [

            'uniacid' => $this->_uniacid,
        ];

        $data = $config_model->dataUpdate($dis,$input);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-16 18:46
     * @功能说明:短信配置详情
     */
    public function shortCodeConfigInfo(){

        $config_model = new ShortCodeConfig();

        $config_model->initData($this->_uniacid);

        $dis = [

            'uniacid' => $this->_uniacid,

        ];

        $data = $config_model->dataInfo($dis);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2021-07-16 18:46
     * @功能说明:模版消息配置编辑
     */
    public function shortCodeConfigUpdate(){

        $input = $this->_input;

        $config_model = new ShortCodeConfig();

        $dis = [

            'uniacid' => $this->_uniacid,
        ];

        $data = $config_model->dataUpdate($dis,$input);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2023-02-16 17:56
     * @功能说明:获取加钟配置详情
     */
    public function addClockInfo(){

        $config_model = new MassageConfig();

        $config = $config_model->dataInfo(['uniacid'=>$this->_uniacid]);

        $clock_model = new ClockSetting();

        $arr['list'] = $clock_model->where(['uniacid'=>$this->_uniacid])->order('times,id')->select()->toArray();

        $arr['clock_cash_status'] = $config['clock_cash_status'];

        return $this->success($arr);
    }


    /**
     * @author chenniang
     * @DataTime: 2023-02-16 18:02
     * @功能说明:编辑加钟配置
     */
    public function addClockUpdate(){

        $input = $this->_input;

        $config_model = new MassageConfig();

        $config_model->dataUpdate(['uniacid'=>$this->_uniacid],['clock_cash_status'=>$input['clock_cash_status']]);

        $clock_model = new ClockSetting();

        $clock_model->where(['uniacid'=>$this->_uniacid])->delete();

        if(!empty($input['list'])){

            foreach ($input['list'] as $k=>$value){

                $insert[$k] = [

                    'uniacid' => $this->_uniacid,

                    'times'   => $value['times'],

                    'balance' => $value['balance']
                ];

            }
            $clock_model->saveAll($insert);
        }

        return $this->success(true);
    }


    /**
     * @author chenniang
     * @DataTime: 2023-02-20 11:18
     * @功能说明:省份列表
     */
    public function provinceList(){

        $input = $this->_param;

        $city_model = new City();

        $dis = [

            'uniacid' => $this->_uniacid,

            'status'  => 1
        ];

        $list = $city_model->where($dis)->group('province')->order('id desc')->column('province');

        return $this->success($list);
    }


    /**
     * @author chenniang
     * @DataTime: 2023-02-23 13:53
     * @功能说明:配置详情
     */
    public function configSettingInfo(){

        $config_model = new ConfigSetting();

        $data = $config_model->dataInfo($this->_uniacid);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2023-02-23 13:54
     * @功能说明:编辑配置
     */
    public function configSettingUpdate(){

        $input = $this->_input;

        $config_model = new ConfigSetting();

        $data = $config_model->dataUpdate($input,$this->_uniacid);

        return $this->success($data);

    }




}
