<?php
/**
 * Created by PhpStorm.
 * User: luotao
 * Date: 2017/10/18
 * Time: 下午2:23
 */

namespace app\api\controller;


class OrderInfo extends Base
{
    private $mod_info;
    private $mod_data;
    private $mod_salesperson;
    private $mod_correctError;

    public function __construct()
    {
        $this->mod_info         = new \OrderInfoDB();
        $this->mod_data         = new \OrderInfoDataDB();
        $this->mod_salesperson  = new \SalespersonDB();
        $this->mod_correctError = new \CorrectErrorDB();
    }

    public function get()
    {
        $userName = input('userName');
        $isCharge = input('isCharge/d', 1);  //1:不是 2：是
        $D_khdw   = input('D_khdw');
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
            $where = ['F_xsry' => $userName];
        }
        if (!empty($D_khdw)) {
            $where['D_khdw'] = ['$regex' => $D_khdw, '$options' => 'i'];
        }
        $data = $this->mod_data->get($where, $start, $ps);
        $list = [];
        foreach ($data as $item) {
            $list[] = [
                'id'     => $item['id'],
                'D_khdw' => $item['D_khdw'],
                'A_hth'  => $item['A_hth'],
                'C_ssxm' => $item['C_ssxm'],
                'J_fkje' => empty($item['J_fkje']) ? 0 : $item['J_fkje'],
                'K_fkbl' => round($item['K_fkbl'] * 100, 2) . '%',
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
        $info           = $this->mod_data->getInfo($id);
        $info['J_fkje'] = empty($info['J_fkje']) ? 0 : $info['J_fkje'];
        $info['K_fkbl'] = round($info['K_fkbl'] * 100, 2) . '%';
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
            'type'     => 2,          //1:交期  2：订单
            'create'   => time(),
        ];
        $this->mod_correctError->add($insertData);
        $this->mod_info->updateInc(['errorNum' => 1, 'errorStatus' => 1], $info['id']);
        return json(ok());
    }

}