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
        $url = input('url', '');
        $con       = mdb()->jsapitoken;
        $info      = $con->findOne();
        $timestamp = time();
        if (empty($info) || ($info['time'] + 3600 * 1.5) < time()) {
            $token  = $this->getAccessToken();
            $getUrl = config('dingding.apiUrl') . '/get_jsapi_ticket?access_token=' . $token . '&type=jsapi';
            $res    = json_decode(getHttpRequest($getUrl), true);
            $ticket = $res['ticket'];
            if (empty($info)) {
                $con->insert(['ticket' => $ticket, 'time' => $timestamp]);
            }
            else {
                $con->update([], ['$set' => ['ticket' => $ticket, 'time' => $timestamp]]);
            }
        }
        else {
            $ticket    = $info['ticket'];
            $timestamp = $info['time'];
        }
        $noncestr = uniqueID();

        $arr = [
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


    public function testGetApi () 
    {
        //$token  = $this->getAccessToken();
        $url = input('url', '');
        $con       = mdb()->jsapitoken;
        $info      = $con->findOne();
        $timestamp = time();
        if (empty($info) || ($info['time'] + 3600 * 1.5) < time()) {
            $token  = $this->getAccessToken();
            dump($token);
            $getUrl = config('dingding.apiUrl') . '/get_jsapi_ticket?access_token=' . $token . '&type=jsapi';
            dump($getUrl);
            $res    = json_decode(getHttpRequest($getUrl), true);
            dump($res);

            $ticket = $res['ticket'];
            if (empty($info)) {
                $con->insert(['ticket' => $ticket, 'time' => $timestamp]);
            }
            else {
                $con->update([], ['$set' => ['ticket' => $ticket, 'time' => $timestamp]]);
            }
        }
        else {
            $ticket    = $info['ticket'];
            $timestamp = $info['time'];
        }
        $noncestr = uniqueID();

        $arr = [
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
        //return json($res);
        dump($res);
        
    }


    public function testGetToken() 
    {
        $config_dingding = config('dingding');
        $getUrl          = $config_dingding['apiUrl'] . '/gettoken?corpid=' . $config_dingding['corpid'] . '&corpsecret=' . $config_dingding['corpsecret'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:24.0) Gecko/20100101 Firefox/24.0');

        $output = curl_exec($ch);
        if ($output === FALSE) {
            echo 'CURL ERROR',curl_error($ch);
        }
        curl_close($ch);

        $output = (array)json_decode($output);
        dump($output);
        $token = $output['access_token'];

        $ticket_url = config('dingding.apiUrl') . '/get_jsapi_ticket?access_token=' . $token . '&type=jsapi';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ticket_url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:24.0) Gecko/20100101 Firefox/24.0');

        $get_ticket = curl_exec($ch);
        if ($get_ticket === FALSE) {
            echo 'CURL ERROR',curl_error($ch);
        }
        curl_close($ch);

        var_dump($get_ticket);

        //echo $getUrl;
        //dump($token);
    }


}
