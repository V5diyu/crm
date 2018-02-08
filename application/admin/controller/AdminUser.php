<?php
namespace app\admin\controller;

use think\Session;

class AdminUser extends Base
{
    private $mod;

    public function __construct()
    {
        $this->mod = new \AdminUserDB();
    }

    public function addAdmin()
    {
        $code = input('code');
        if (empty($code)) {
            return json(error('缺少必要参数'));
        }
        if ($code != 'dingding') {
            return json(error($code));
        }
        $inserData = [
            'account' => 'admin',
            'pwd'     => md5(md5('taiklh')),
            'power'   => 1,
            'name'    => 'admin',
            'setUp'   => 1,
            'create'  => time()
        ];
        $this->mod->add($inserData);
        return json(ok());
    }

    public function create()
    {
        if (!$this->isAdmin()) {
            return json(error('权限不足'));
        }
        $account = input('account');
        $pwd     = input('pwd');
        $name    = input('name');
        $setUp   = input('setUp/d');    //1：超级管理员 2：销售助理 3:财务 4：销售人员
        if (empty($account) || empty($pwd) || empty($setUp)) {
            return json(error('缺少必要参数'));
        }
        $inserData = [
            'account' => $account,
            'pwd'     => md5(md5($pwd)),
            'power'   => 2,
            'name'    => $name,
            'setUp'   => $setUp,
            'create'  => time()
        ];
        $this->mod->add($inserData);
        return json(ok());
    }

    public function login()
    {
        $account = input('account');
        $pwd     = input('pwd');
        if (empty($account) || empty($pwd)) {
            return json(error('缺少必要参数'));
        }

        $res = $this->mod->checkPwd($account, $pwd);
        if (!$res) {
            return json(error('账号或密码错误'));
        }
        Session::set('user', [
            'id'      => $res['id'],
            'account' => $res['account'],
            'name'    => $res['name'],
            'power'   => $res['power'],
            'setUp'   => $res['setUp']
        ]);
        return json(ok($res));
    }

    public function logout()
    {
        Session::clear();
        return json(ok());
    }

    public function get()
    {
        $name  = input('name');
        $where = ['power' => 2];
        if (!empty($name)) {
            $where['name'] = ['$regex' => $name, '$options' => 'i'];
        }
        $data = $this->mod->get($where, ['_id' => false]);
        $list = [];
        foreach ($data as $item) {
            $item['create'] = date('Y-m-d H:i', $item['create']);
            $list[]         = $item;
        }
        return json(ok($list));
    }

    public function update()
    {
        $id    = input('id');
        $pwd   = input('pwd');
        $name  = input('name');
        $setUp = input('setUp');
        if (empty($id) || empty($name) || empty($pwd) || empty($setUp)) {
            return json(error('缺少必要参数'));
        }
        $userInfo = $this->mod->getInfo($id);
        $setData  = [
            'name'  => $name,
            'setUp' => $setUp,
        ];
        if ($pwd != $userInfo['pwd']) {
            $setData['pwd'] = md5(md5($pwd));
        }
        $this->mod->update($setData, $id);
        return json(ok());
    }

    public function delete()
    {
        if (!$this->isAdmin()) {
            return json(error('权限不足'));
        }
        $id = input('id');
        if (empty($id)) {
            return json(error('缺少必要参数'));
        }
        $this->mod->delete($id);
        return json(ok());
    }

    public function updatePwd()
    {
        $id   = input('id');
        $yPwd = input('yPwd');
        $pwd  = input('pwd');
        if (empty($id) || empty($pwd)) {
            return json(error('缺少必要参数'));
        }
        $info = $this->mod->getInfo($id);
        if (empty($info)) {
            return json(error('用户信息不存在'));
        }
        if (md5(md5($yPwd)) != $info['pwd']) {
            return json(error('原密码错误'));
        }
        $setData = [
            'pwd' => md5(md5($pwd)),
        ];
        $this->mod->update($setData, $id);
        return json(ok());
    }

}
