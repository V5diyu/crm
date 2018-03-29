<?php
/**
 * Created by PhpStorm.
 * User: w
 * Date: 2018/3/14
 * Time: 19:10
 */

namespace app\admin\controller;

class Bill extends Base
{
    private $mod_bill;

    public function __construct()
    {
        $this->mod_bill = new \BillDB();
    }

    public function uploadExcel()
    {

    }


    public function get()
    {
        $search    = input('search');           //客户简称
        $startTime = input('startTime');
        $endTime   = input('endTime');
        $pn        = input('pn', 1);
        $ps        = 15;
        $start     = ($pn - 1) * $ps;
        $where     = [];
        $sort      = [];

        if (!empty($search)) {
            $where['A_pjhm'] = ['$regex' => $search, '$options' => 'i'];
        }
        if (!empty($startTime) || !empty($endTime)) {
            $timeWhere = [];
            if (!empty($startTime)) {
                $timeWhere['$gte'] = $startTime / 1000;
            }
            if (!empty($endTime)) {
                $timeWhere['$lt'] = $endTime / 1000;
            }
            $where['C_kpsj'] = $timeWhere;
        }

        $accountInfo = $this->getUserInfo();
        if ($accountInfo['setUp'] == 4) {
            $where['E_xhry'] = $accountInfo['name'];
        }
        $data  = $this->mod_lend->get($where, $start, $ps, $sort);
        $count = $this->mod_lend->count($where);
        $list  = [];

        foreach ($data as $item) {
            $item['B_jcrq'] = date('Y-m-d', $item['B_jcrq']);
            //(是否与发货时间有关系？)(为空，显示空字符串，不为空显示时间格式)
            //$item['J_dqsj'] = date("Y-m-d", $item['J_dqsj']);
            $item['I_ghbl'] = $item['I_ghbl'] . '%';
            $item['G_fhbl'] = $item['G_fhbl'] . '%';
            $list[]           = $item;
        }

        return json(ok(['list' => $list, 'count' => $count]));

        return json(ok());


    }

    public function update()
    {
        //
    }

    public function delete()
    {

    }

    public function downfile()
    {
        $search    = input('search');           //客户简称
        $startTime = input('startTime');
        $endTime   = input('endTime');
        $where     = [];

    }

}