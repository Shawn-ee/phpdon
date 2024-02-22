<?php
namespace app\node\controller;
use app\AdminRest;
use app\massage\model\Admin;
use app\massage\model\AdminRole;
use app\node\model\RoleAdmin;
use app\node\model\RoleList;
use app\node\model\RoleNode;
use think\App;



class AdminUser extends AdminRest
{

    public function __construct(App $app) {

        parent::__construct($app);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-01-04 14:02
     * @功能说明:角色列表
     */
    public function roleList(){

        $input = $this->_param;

        $dis[] = ['uniacid','=',$this->_uniacid];

        $dis[] = ['status','>',-1];

        if(!empty($input['title'])){

            $dis[] = ['title','like','%'.$input['title'].'%'];

        }

        $role_model = new RoleList();

        $data = $role_model->dataList($dis,$input['limit']);

        return $this->success($data);


    }


    /**
     * @author chenniang
     * @DataTime: 2022-01-04 14:02
     * @功能说明:角色列表
     */
    public function roleSelect(){

        $input = $this->_param;

        $dis[] = ['uniacid','=',$this->_uniacid];

        $dis[] = ['status','=',1];

        if(!empty($input['title'])){

            $dis[] = ['title','like','%'.$input['title'].'%'];

        }

        $role_model = new RoleList();

        $data = $role_model->where($dis)->select()->toArray();

        return $this->success($data);


    }

    /**
     * @author chenniang
     * @DataTime: 2022-01-04 13:56
     * @功能说明:添加角色
     */
    public function roleAdd(){

        $input = $this->_input;

        $input['uniacid'] = $this->_uniacid;

        $role_model = new RoleList();

        $data = $role_model->dataAdd($input);

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-01-04 14:17
     * @功能说明:编辑角色
     */
    public function roleUpdate(){

        $input = $this->_input;

        $dis = [

            'id' => $input['id']

        ];

        $input['uniacid'] = $this->_uniacid;

        $role_model = new RoleList();
        //删除
        if(isset($input['status'])&&$input['status']==-1){

            $adminRole_mdoel = new RoleAdmin();

            $find = $adminRole_mdoel->alias('a')
                ->join('shequshop_school_admin b','a.admin_id = b.id')
                ->where(['a.role_id'=>$input['id']])
                ->where('b.status','>',-1)
                ->find();

            if(!empty($find)){

                $this->errorMsg('该角色正在被使用');
            }

        }

        $data = $role_model->dataUpdate($dis,$input);

        return $this->success($data);


    }

    /**
     * @author chenniang
     * @DataTime: 2022-01-04 14:17
     * @功能说明:角色详情
     */
    public function roleInfo(){

        $input = $this->_param;

        $dis = [

            'id' => $input['id']

        ];

        $role_model = new RoleList();

        $data = $role_model->dataInfo($dis);

        $node_model = new RoleNode();

        $node = $node_model->where(['role_id'=>$input['id']])->select()->toArray();

        if(!empty($node)){

            foreach ($node as $k=>$v){

                $node[$k]['auth'] = !empty($v['auth'])?explode(',',$v['auth']):[];

            }

        }

        $data['node'] = $node;

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-01-04 14:18
     * @功能说明:给账号分配角色（多选）
     */
    public function adminRoleAdd(){

        $input = $this->_input;

        $adminRole_mdoel = new RoleAdmin();

        $adminRole_mdoel->where(['admin_id'=>$input['admin_id']])->delete();

        if(!empty($input['role'])){

            foreach ($input['role'] as $key => $value){

                $insert[$key] = [

                    'uniacid' => $this->_uniacid,

                    'admin_id'=> $input['admin_id'],

                    'role_id' => $value

                ];

            }

            $adminRole_mdoel->saveAll($insert);
        }

        return $this->success(true);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-01-04 14:24
     * @功能说明:账号所匹配的角色详情
     */
    public function adminInfo(){

        $input = $this->_param;

        $adminRole_mdoel = new RoleAdmin();

        $admin_model = new \app\massage\model\Admin();

        $dis= [

            'id' => $input['id']
        ];

        $data = $admin_model->dataInfo($dis);

        $dis = [

            'a.uniacid' => $this->_uniacid,

            'b.status'  => 1,

            'a.admin_id'=> $input['id']
        ];

        $data['role'] = $adminRole_mdoel->alias('a')
                ->join('massage_role_list b','a.role_id = b.id')
                ->where($dis)
                ->field('b.*,a.role_id')
                ->group('b.id')
                ->select()
                ->toArray();

        return $this->success($data);

    }



    /**
     * @author chenniang
     * @DataTime: 2022-01-04 14:24
     * @功能说明:账号所匹配的角色的节点详情
     */
    public function adminNodeInfo(){

        $input = $this->_param;

        $adminRole_mdoel = new RoleAdmin();

        $data['is_admin'] = isset($this->_user['is_admin'])?$this->_user['is_admin']:1;

        $dis = [

            'a.uniacid' => $this->_uniacid,

            'b.status'  => 1,

            'a.admin_id'=> $this->_user['id']
        ];

        $data['node'] = $adminRole_mdoel->alias('a')
            ->join('massage_role_list b','a.role_id = b.id')
            ->join('massage_role_node c','c.role_id = b.id')
            ->where($dis)
            ->field('c.*')
            ->group('c.id')
            ->select()
            ->toArray();

        if(!empty($data['node'])){

            foreach ($data['node'] as $k=>$v){

                $data['node'][$k]['auth'] = !empty($v['auth'])?explode(',',$v['auth']):[];

            }

        }

        return $this->success($data);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-01-04 14:41
     * @功能说明:账号列表
     */
    public function adminList(){

        $input = $this->_param;

        $admin_model = new Admin();

        $dis[] = ['uniacid','=',$this->_uniacid];

        $dis[] = ['status','>',-1];

        $dis[] = ['is_admin','=',2];

        if(!empty($input['title'])){

            $dis[] = ['username','like','%'.$input['title'].'%'];

        }

        $data = $admin_model->dataList($dis,$input['limit']);

        return $this->success($data);

    }



    /**
     * @author chenniang
     * @DataTime: 2022-01-04 14:47
     * @功能说明:添加账号
     */
    public function adminAdd(){

        $input = $this->_input;

        $admin_model = new Admin();

        $dis = [

            'uniacid' => $this->_uniacid,

            'username'=> $input['username'],


        ];

        $find = $admin_model->where($dis)->where('status','>',-1)->find();

        if(!empty($find)){

            if($find->is_admin==2){

                $this->errorMsg('账号名不能重复');

            }elseif ($find->is_admin==1){

                $this->errorMsg('admin为超管账号');

            }else{
                $this->errorMsg('该账号名为代理商账号');

            }

        }

        $insert = [

            'uniacid' => $this->_uniacid,

            'username'=> $input['username'],

            'passwd_text'=> $input['passwd'],

            'passwd'  => checkPass($input['passwd']),

            'is_admin'=> 2,

        ];

        $admin_model->dataAdd($insert);

        $admin_id = $admin_model->getLastInsID();

        $adminRole_mdoel = new RoleAdmin();

        $adminRole_mdoel->where(['admin_id'=>$admin_id])->delete();

        if(!empty($input['role'])){

            foreach ($input['role'] as $key => $value){

                $inserts[$key] = [

                    'uniacid' => $this->_uniacid,

                    'admin_id'=> $admin_id,

                    'role_id' => $value

                ];

            }

            $adminRole_mdoel->saveAll($inserts);
        }

        return $this->success(true);

    }


    /**
     * @author chenniang
     * @DataTime: 2022-01-04 14:47
     * @功能说明:添加账号
     */
    public function adminUpdate(){

        $input = $this->_input;

        $admin_model = new Admin();

        if(!empty($input['username'])){

            $dis = [

                'uniacid' => $this->_uniacid,

                'username'=> $input['username'],
            ];

            $find = $admin_model->where($dis)->where('status','>',-1)->where('id','<>',$input['id'])->find();

            if(!empty($find)){

                if($find->is_admin==2){

                    $this->errorMsg('账号名不能重复');

                }elseif ($find->is_admin==1){

                    $this->errorMsg('admin为超管账号');

                }else{
                    $this->errorMsg('该账号名为代理商账号');

                }
            }
        }

        if(!empty($input['passwd'])){

            $input['passwd_text'] = $input['passwd'];

            $input['passwd']   = checkPass($input['passwd']);

        }

        $dis = [

            'id' => $input['id']
        ];

        if(isset($input['role'])){

            $role = $input['role'];

            unset($input['role']);
        }

        $admin_model->dataUpdate($dis,$input);

        $adminRole_mdoel = new RoleAdmin();

        $adminRole_mdoel->where(['admin_id'=>$input['id']])->delete();

        if(!empty($role)){

            foreach ($role as $key => $value){

                $inserts[$key] = [

                    'uniacid' => $this->_uniacid,

                    'admin_id'=> $input['id'],

                    'role_id' => $value

                ];

            }

            $adminRole_mdoel->saveAll($inserts);
        }

        return $this->success(true);

    }





}
