<?php
/**
 * Created by PhpStorm.
 * User: w
 * Date: 2018/2/24
 * Time: 15:42
 */

namespace app\api\controller;

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
            $item['paydate'] = date('Y年m月d日 H:i:s',strtotime($item['paydate']['date']));
            $list[] = $item;
        }
        /*return json(ok($list));*/
        return json(ok($list));
    }
}