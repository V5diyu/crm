<?php

namespace app\admin\controller;

class OrderPayDetail extends Base
{


    private $mod_payDetail;

    public function __construct()
    {
        $this->mod_payDetail = new \OrderPayDetailDb();
    }

    public function get ()
    {
        $contract = input('row');
        $where = ['contract'=> $contract];
        $data = $this->mod_payDetail->get($where);
        $list = [];
        foreach ($data as $item) {
            $item['paydate'] = date('Y年m月d日',strtotime($item['paydate']['date']));
            $list[] = $item;
        }
        return json(ok($list));
    }
}

