<?php


namespace app\admin\behavior;

use think\Session;

class CheckAuth
{
    public function run()
    {
        $url  = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $l    = stripos($url, '/admin/admin_user/login');
        $a    = stripos($url, '/admin/admin_user/addAdmin');
        $user = Session::get('user');
        // if (empty($user)) {
        //     if (!$l && !$a) {
        //         die(json_encode(error('用户信息过期，请重新登录', 501)));
        //     }
        // }
    }
}