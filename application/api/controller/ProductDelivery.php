<?php
/**
 * Created by PhpStorm.
 * User: luotao
 * Date: 2017/10/18
 * Time: 下午2:23
 */

namespace app\api\controller;


use think\Loader;

class ProductDelivery extends Base
{
    private $mod_info;
    private $mod_data;
    private $mod_salesperson;
    private $mod_correctError;

    public function __construct()
    {
        $this->mod_info         = new \ProductDeliveryDB();
        $this->mod_data         = new \ProductDeliveryDataDB();
        $this->mod_salesperson  = new \SalespersonDB();
        $this->mod_correctError = new \CorrectErrorDB();
    }

    public function get()
    {
        $userName = input('userName');
        $isCharge = input('isCharge/d', 1);  //1:不是 2：是
        $A_khmc   = input('A_khmc');
        $pn       = input('pn/d', 1);
        $ps       = 15;
        $start    = ($pn - 1) * $ps;
        if (empty($userName)) {
            return json(error('缺少必要的参数'));
        }
        if ($isCharge == 2) {
            $where = [];
        }
        else {
            $where = ['B_ywy' => $userName];
        }
        if (!empty($A_khmc)) {
            $where['A_khmc'] = ['$regex' => $A_khmc, '$options' => 'i'];
        }
        $data = $this->mod_data->get($where, $start, $ps);
        $list = [];
        foreach ($data as $item) {
            $list[] = [
                'id'       => $item['id'],
                'A_khmc'   => $item['A_khmc'],
                'D_dh'     => $item['D_dh'],
                'F_pm'     => $item['F_pm'],
                'J_sl'     => $item['J_sl'],
                'N_yjfhrq' => is_int($item['N_yjfhrq']) ? date('Y-m-d', $item['N_yjfhrq']) : $item['N_yjfhrq'],
            ];
        }
        return json(ok($list));
    }

    public function getInfo()
    {
        $id = input('id');
        if (empty($id)) {
            return json(error('缺少必要的参数'));
        }
        $info             = $this->mod_data->getInfo($id);
        $info['N_yjfhrq'] = is_int($info['N_yjfhrq']) ? date('Y-m-d', $info['N_yjfhrq']) : $info['N_yjfhrq'];
        return json(ok($info));
    }

    public function correctError()
    {
        $id       = input('id');
        $userId   = input('userId');
        $userName = input('userName');
        $content  = input('content');
        if (empty($id) || empty($userId) || empty($userName) || empty($content)) {
            return json(error('缺少必要的参数'));
        }
        $data = $this->mod_info->get([], 0, 1);
        $info = iterator_to_array($data)[0];
        if (empty($info)) {
            return json(error('信息不存在'));
        }
        $insertData = [
            'objId'    => $id,
            'infoId'   => $info['id'],
            'userId'   => $userId,
            'userName' => $userName,
            'content'  => $content,
            'type'     => 1,          //1:交期  2：订单
            'create'   => time(),
        ];
        $this->mod_correctError->add($insertData);
        $this->mod_info->updateInc(['errorNum' => 1, 'errorStatus' => 1], $info['id']);
        return json(ok());
    }

    public function sendMsg()
    {
        $content = input('content');
        $userId  = input('userId');
        if (empty($content) || empty($userId)) {
            return json(error('缺少必要的参数'));
        }
        Loader::import('dingdingSDK/TopSdk');
        $config = config('dingding');
        $c      = new \DingTalkClient();
        $req    = new \CorpMessageCorpconversationAsyncsendRequest();
        $req->setMsgtype('text');
        $req->setAgentId($config['agentId']);
        $req->setUseridList($userId);
        $req->setMsgcontent(json_encode(['content' => $content]));
        $resp = $c->execute($req, $this->getAccessToken());
        $resp = json_decode(json_encode($resp), true);
        if ($resp['result']['ding_open_errcode'] == 0) {
            return json(ok());
        }
        else {
            return json(error('钉钉错误：' . $resp['result']['error_msg']));
        }
    }

}