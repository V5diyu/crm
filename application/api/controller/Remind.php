<?php
/**
 * Created by PhpStorm.
 * User: luotao
 * Date: 2017/10/17
 * Time: 上午11:47
 */

namespace app\api\controller;


use think\Loader;

class Remind extends Base
{
    private $mod;
    private $mod_customer;
    private $mod_agent;
    private $mod_programme;

    public function __construct()
    {
        $this->mod           = new \RemindDB();
        $this->mod_customer  = new \CustomerDB();
        $this->mod_agent     = new \AgentDB();
        $this->mod_programme = new \CustomerProgrammeDB();
    }

    public function create()
    {
        $userId  = input('userId');
        $type    = input('type/d', 2);       //2:客户  3：代理商
        $objId   = input('objId');
        $time    = input('time');
        $content = input('content');
        if (!strtotime($time)) {
            $time = time();
        }
        if (empty($userId) || empty($type) || empty($objId) || empty($time) || empty($content)) {
            return json(error('缺少必要参数'));
        }
        $insertData = [
            'userId'     => $userId,
            'type'       => $type,
            'objId'      => $objId,
            'time'       => strtotime($time),
            'status'     => 0,     //0：未读  1：已读
            'sendStatus' => 0,     //0:未发送 1：已发送
            'content'    => $content,
        ];
        $this->mod->add($insertData);
        return json(ok());
    }

    public function get()
    {
        $userId = input('userId');
        $pn     = input('pn', 1);
        $ps     = 15;
        $start  = ($pn - 1) * $ps;
        $where  = ['userId' => $userId];
        $data   = $this->mod->get($where, $start, $ps);
        $list   = [];
        foreach ($data as $item) {
            $list[] = [
                'id'      => $item['id'],
                'type'    => $item['type'],
                'objId'   => $item['objId'],
                'time'    => date('Y-m-d H:i', $item['time']),
                'status'  => $item['status'],     //0：未读  1：已读
                'content' => $item['content'],
            ];
        }
        return json(ok($list));
    }

    public function operationSign()
    {
        $id = input('id');
        if (empty($id)) {
            return json(error('缺少必要的参数'));
        }
        $this->mod->update(['status' => 1], $id);
        return json(ok());
    }

    public function sendMsg()
    {
        $id = input('id');
        if (empty($id)) {
            return json(error('缺少必要的参数'));
        }
        $info = $this->mod->getInfo($id);
        if (empty($info)) {
            return json(error('参数错误'));
        }
        switch ($info['type']) {
            case 1:
                $info_programme = $this->mod_programme->getInfo($info['objId']);
                if (!empty($info_programme)) {
                    $info_customer = $this->mod_customer->getInfo($info_programme['customerId']);
                    if (empty($info_customer)) {
                        $name = '';
                    }
                    else {
                        $name = $info_customer['name'];
                    }
                }
                else {
                    $name = '';
                }
                $content = '提醒：您给客户（' . $name . '）添加的跟踪方案（' . $info['content'] . '）时间已经到啦';
                break;
            case 2:
                $info_customer = $this->mod_customer->getInfo($info['objId']);
                if (empty($info_customer)) {
                    $name = '';
                }
                else {
                    $name = $info_customer['name'];
                }
                $content = '提醒：您给客户（' . $name . '）添加的提醒（' . $info['content'] . '）时间已经到啦';
                break;
            case 3:
                $info_agent = $this->mod_agent->getInfo($info['objId']);
                if (empty($info_agent)) {
                    $name = '';
                }
                else {
                    $name = $info_agent['name'];
                }
                $content = '提醒：您给代理商（' . $name . '）添加的提醒（' . $info['content'] . '）时间已经到啦';
                break;
            default:
                return json(error('数据错误'));
        }
        Loader::import('dingdingSDK/TopSdk');
        $config = config('dingding');
        $c      = new \DingTalkClient();
        $req    = new \CorpMessageCorpconversationAsyncsendRequest();
        $req->setMsgtype('text');
        $req->setAgentId($config['agentId']);
        $req->setUseridList($info['userId']);
        $req->setMsgcontent(json_encode(['content' => $content]));
        $resp = $c->execute($req, $this->getAccessToken());
        $resp = json_decode(json_encode($resp), true);
        if ($resp['result']['ding_open_errcode'] == 0) {
            $this->mod->update(['sendStatus' => 1], $id);
            return json(ok());
        }
        else {
            return json(error('钉钉错误：' . $resp['result']['error_msg']));
        }
    }
}