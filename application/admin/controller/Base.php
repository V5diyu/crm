<?php
namespace app\admin\controller;

use think\Controller;
use think\Session;

class Base extends Controller
{
    public function isAdmin()
    {
//        return true;
        $setUp = session('user')['setUp'];
        if ($setUp == 1) {
            return true;
        }
        else {
            return false;
        }
    }

    public function getUserInfo()
    {
//        return [
//            'id'      => '15082236132212551',
//            'account' => 'admin',
//            'name'    => 'admin',
//            'power'   => 1,
//            'setUp'   => 1,
//        ];
        /*return session('user');*/
        return Session::get('user');
    }
}
