<?php
/**
 * Created by PhpStorm.
 * User: w
 * Date: 2018/3/14
 * Time: 19:32
 */

namespace app\admin\controller;

class BillDetail extends Base
{
    private $mod_billDetail;

    public function __construct()
    {
        $this->mod_billDetail = new \BillDetailDB();

    }

    public function get()
    {
        $contract = input('row');
        $where = ['contract'=> $contract];
        $data = $this->mod_billDetail->get($where);
        $list = [];
        foreach ($data as $item ) {
            //时间格式需要处理

            $list[] = $item;
        }
        return json(ok($list));
    }
}