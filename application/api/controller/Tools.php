<?php
namespace app\api\controller;

use Qiniu\Auth;


class Tools extends Base
{
    /**
     * 获取七牛上传token
     * @return \think\response\Json
     */
    public function getToken()
    {
        $accessKey = config('qiniu.accessKey');
        $secretKey = config('qiniu.secretKey');
        $auth      = new Auth($accessKey, $secretKey);
        $bucket    = config('qiniu.bucket');
        $policy    = array(
            'scope'        => $bucket,
            'saveKey'      => 'data/$(year)/$(mon)/$(day)/' . uniqueID(),
            'callbackUrl'  => 'http://' . $_SERVER['HTTP_HOST'] . '/api/tools/qiniuCallback',
            'callbackBody' => 'fname=$(key)'
        );
        $token     = $auth->uploadToken($bucket, null, 3600, $policy);
        return json(['uptoken' => $token]);
    }

    /**
     * 七牛上传回调
     * @return mixed
     */
    public function qiniuCallback()
    {
        $key    = $_POST['fname'];
        $bucket = config('qiniu.url');
        return json(ok(['url' => $bucket . '/' . $key]));
    }

    public function getJsapiConfig()
    {
        $url       = input('url', '');
        $token     = $this->getAccessToken();
        $getUrl    = config('dingding.apiUrl') . '/get_jsapi_ticket?access_token=' . $token;
        $res       = json_decode(getHttpRequest($getUrl), true);
        $ticket    = $res['ticket'];
        $noncestr  = uniqueID();
        $timestamp = time();
        $arr       = [
            'noncestr=' . $noncestr,
            'timestamp=' . $timestamp,
            'jsapi_ticket=' . $ticket,
            'url=' . urldecode($url)
        ];
        sort($arr);
        $str = '';
        foreach ($arr as $item) {
            $str .= $item . '&';
        }
        $str       = substr($str, 0, -1);
        $signature = sha1($str);
        $res       = [
            'agentId'   => config('dingding.agentId'),
            'corpId'    => config('dingding.corpid'),
            'timeStamp' => $timestamp,
            'nonceStr'  => $noncestr,
            'signature' => $signature,
            'jsticket'  => $ticket
        ];
        return json($res);
    }

}
