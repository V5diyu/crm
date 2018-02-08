<?php
namespace app\api\controller;

use think\Controller;

class Base extends Controller
{
    public function getAccessToken()
    {
        $config_dingding = config('dingding');
        $getUrl          = $config_dingding['apiUrl'] . '/gettoken?corpid=' . $config_dingding['corpid'] . '&corpsecret=' . $config_dingding['corpsecret'];
        $res             = json_decode(getHttpRequest($getUrl), true);
        return $res['access_token'];
    }
}
