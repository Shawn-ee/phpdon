<?php


namespace app\massage\controller;


use app\AdminRest;
use app\massage\model\Order;
use app\massage\model\ShopCarte;
use app\massage\model\ShopGoods;
use think\facade\Db;

class AdminShop extends AdminRest
{



    /**
     * 添加分类
     * @return \think\Response
     */
    public function addCarte()
    {


        $input = $this->request->only(['name', 'sort']);
        $rule = [
            'name' => 'require',
            'sort' => 'require',
        ];
        $validate = \think\facade\Validate::rule($rule);
        if (!$validate->check($input)) {
            return $this->error($validate->getError());
        }
        $input['name'] = trim($input['name']);
        $where = [
            ['name', '=', $input['name']],
            ['status', 'in', [0, 1]],
            ['uniacid', '=', $this->_uniacid]
        ];
        $info = ShopCarte::getInfo($where);

        if (!empty($info)) {
            return $this->error('此分类已存在，不可创建');
        }
        $input['uniacid'] = $this->_uniacid;
        $res = ShopCarte::add($input);
        if ($res) {
            return $this->success('');
        }

        return $this->error('创建失败');
    }

    /**
     * 编辑分类
     * @return \think\Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function editCarte()
    {
        $input = $this->request->only(['id', 'name', 'sort']);
        if ($this->request->isPost()) {
            $rule = [
                'name' => 'require',
                'sort' => 'require',
            ];
            $validate = \think\facade\Validate::rule($rule);
            if (!$validate->check($input)) {
                return $this->error($validate->getError());
            }
            $input['name'] = trim($input['name']);
            $where = [
                ['name', '=', $input['name']],
                ['status', 'in', [0, 1]],
                ['uniacid', '=', $this->_uniacid],
                ['id', '<>', $input['id']]
            ];
            $info = ShopCarte::getInfo($where);
            if (!empty($info)) {
                return $this->error('此分类已存在，不可编辑');
            }
            $res = ShopCarte::update($input, ['id' => $input['id']]);
            if ($res === false) {
                return $this->error('编辑失败');
            }
            return $this->success('');
        }
        if (empty($input['id'])) {
            return $this->error('参数错误');
        }
        $info = $info = ShopCarte::getInfo(['id' => $input['id']]);
        return $this->success($info);
    }

    /**
     * 分类列表
     * @return \think\Response
     * @throws \think\db\exception\DbException
     */
    public function carteList()
    {
        $limit = $this->request->param('limit', 10);
        $where = [
            ['uniacid', '=', $this->_uniacid,],
            ['status', '<>', '-1']
        ];
        $data = ShopCarte::getList($where, $limit);
        return $this->success($data);
    }

    /**
     * 上下架、删除
     * @return \think\Response
     */
    public function carteStatus()
    {
        $input = $this->request->only(['id', 'status']);
        $rule = [
            'id' => 'require',
            'status' => 'require|in:0,1,-1',
        ];
        $validate = \think\facade\Validate::rule($rule);
        if (!$validate->check($input)) {
            return $this->error($validate->getError());
        }
        if ($input['status'] == -1) {
            $where = [
                ['', 'exp', Db::raw("find_in_set({$input['id']},carte)")],
                ['status', '<>', '-1'],
                ['uniacid', '=', $this->_uniacid]
            ];
            $info = ShopGoods::getInfo($where);
            if (!empty($info)) {
                return $this->error('此分类下有商品，不可删除');
            }
        }
        $res = ShopCarte::update(['status' => $input['status']], ['id' => $input['id']]);
        if ($res === false) {
            return $this->error('操作失败');
        }
        return $this->success('');
    }

    /**
     * 下拉
     * @return \think\Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function goodsCarteList()
    {
        $list = ShopCarte::getListNoPage(['status' => 1, 'uniacid' => $this->_uniacid]);
        return $this->success($list);
    }

    /**
     *添加商品
     * @return \think\Response
     */
    public function addGoods()
    {
        $input = $this->request->only(['name', 'carte', 'cover', 'images', 'image_url', 'video_url', 'phone', 'desc', 'sort', 'price']);
        $rule = [
            'name' => 'require',
            'carte' => 'require',
            'cover' => 'require',
            'images' => 'require',
            'phone' => 'require',
            'desc' => 'require',
            'price' => 'require',
        ];
        $validate = \think\facade\Validate::rule($rule);
        if (!$validate->check($input)) {
            return $this->error($validate->getError());
        }
        $input['create_time'] = time();
        $input['images'] = json_encode($input['images']);
        $input['carte'] = implode(',', $input['carte']);
        $input['uniacid'] = $this->_uniacid;
        $res = ShopGoods::insert($input);
        if ($res) {
            return $this->success('');
        }
        return $this->error('添加失败');
    }

    /**
     * 编辑商品
     * @return \think\Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function editGoods()
    {
        $input = $this->request->only(['id', 'name', 'carte', 'cover', 'images', 'image_url', 'video_url', 'phone', 'desc', 'sort', 'price']);
        if ($this->request->isPost()) {
            $rule = [
                'id' => 'require',
                'name' => 'require',
                'carte' => 'require',
                'cover' => 'require',
                'images' => 'require',
                'phone' => 'require',
                'desc' => 'require',
                'price' => 'require',
            ];
            $validate = \think\facade\Validate::rule($rule);
            if (!$validate->check($input)) {
                return $this->error($validate->getError());
            }
            $input['images'] = json_encode($input['images']);
            $input['carte'] = implode(',', $input['carte']);
            $input['uniacid'] = $this->_uniacid;
            $res = ShopGoods::update($input, ['id' => $input['id']]);
            if ($res === false) {
                return $this->error('编辑失败');
            }
            return $this->success('');
        }
        if (empty($input['id'])) {
            return $this->error('参数错误');
        }
        $data = ShopGoods::getInfo(['id' => $input['id']]);
        $data['carte'] = explode(',', $data['carte']);
        $data['images'] = json_decode($data['images'], true);
        return $this->success($data);
    }

    /**
     * 商品列表
     * @return \think\Response
     * @throws \think\db\exception\DbException
     */
    public function goodsList()
    {
        $input = $this->request->param();
        $limit = $this->request->param('limit', 10);
        $where = [];
        $where[] = ['status', '<>', -1];
        $where[] = ['uniacid', '=', $this->_uniacid];
        if (!empty($input['name'])) {
            $where[] = ['name', 'like', '%' . $input['name'] . '%'];
        }
        if (!empty($input['carte'])) {
            $where[] = ['', 'exp', Db::raw("find_in_set({$input['carte']},carte)")];
        }
        $data = ShopGoods::getList($where, $limit);
        return $this->success($data);
    }

    /**
     * 上下架删除
     * @return \think\Response
     */
    public function goodsStatus()
    {
        $input = $this->request->only(['id', 'status']);
        $rule = [
            'id' => 'require',
            'status' => 'require|in:0,1,-1',
        ];
        $validate = \think\facade\Validate::rule($rule);
        if (!$validate->check($input)) {
            return $this->error($validate->getError());
        }
        $res = ShopGoods::update(['status' => $input['status']], ['id' => $input['id']]);
        if ($res === false) {
            return $this->error('操作失败');
        }
        return $this->success('');
    }
}