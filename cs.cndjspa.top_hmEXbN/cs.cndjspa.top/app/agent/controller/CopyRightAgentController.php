<?php
namespace app\agent\controller;

use app\agent\model\Cardauth2ConfigModel;
use think\App;
use app\agent\model\Cardauth2CopyrightModel;
use app\AgentRest;
use app\agent\validate\CopyRightAgentValidate;

class CopyRightAgentController extends AgentRest
{
    public function __construct ( App $app ){
        parent::__construct( $app );
        if ($this->_user['role_name'] != 'admin') {
            echo json_encode(['code' => 401, 'error' => lang('Permission denied')]);
            exit;
        }
    }
    public function list()
    {

        $param= $this->_param;

        $list = Cardauth2CopyrightModel::where([['status', '=', 1],['uniacid','in',$this->_uniacid_arr]])
            ->paginate(['list_rows' => $param['page_count'] ? $param['page_count'] : 10, 'page' => $param['page'] ? $param['page'] : 1])
            ->toArray();
        return $this->success($list);
    }

    public function getAll()
    {
        $list = Cardauth2CopyrightModel::field(['id', 'name'])->where([['status', '=', 1],['uniacid','in',$this->_uniacid_arr]])->select()
            ->toArray();
        return $this->success($list);
    }


    public function create()
    {
        $data = $this->_input;
        $validate = new CopyRightAgentValidate();
        $check = $validate->scene('create')->check($data);
        if ($check == false) {
            return $this->error($validate->getError());
        }

        $data['uniacid'] = $this->_uniacid;

        $m = new Cardauth2CopyrightModel();
        $m->data($data, true, ['name', 'image', 'text', 'phone', 'uniacid']);
        if ($m->save()) {
            $id = $m->id;
            return $this->success($id);
        }
        return $this->error('fail');
    }


    public function update()
    {
        $data = $this->_input;
        $validate = new CopyRightAgentValidate();
        $check = $validate->scene('update')->check($data);
        if ($check == false) {
            return $this->error($validate->getError());
        }

        $copyRight = Cardauth2CopyrightModel::find($data['id']);
        if (!$copyRight) {
            return $this->error('系统错误');
        }

        if ($copyRight->allowField(['name', 'image', 'text', 'phone'])->save($data)) {
            return $this->success('success');
        };
        return $this->error('fail');
    }


    public function get()
    {
        $copyRight = Cardauth2CopyrightModel::find($this->_param['id']);
        return $this->success($copyRight);
    }

    public function destroy()
    {
        $validate = new CopyRightAgentValidate();
        $check = $validate->scene('destroy')->check($this->_input);
        if ($check == false) {
            return $this->error($validate->getError());
        }
        $m_config = new Cardauth2ConfigModel();

        $auth_config = $m_config->where(['copyright_id'=>$this->_input['id']])->find();
        if(!empty($auth_config)){
            return $this->error('This copyright is in use and cannot be deleted');
        }

        $rst = Cardauth2CopyrightModel::destroy(function ($query) {
            $query->where('id', '=', $this->_input['id'] ?? 0);
        });

        return $this->success($rst);
    }


}