<?php
/**
 * Created by PhpStorm.
 * User: w
 * Date: 2018/3/29
 * Time: 17:52
 */

namespace app\api\controller;

class Lend extends Base
{
    private $mod_info;
    private $mod_data;
    private $mod_salesperson;


    public function __construct()
    {
        $this->mod_data         = new \LendDB();
        $this->mod_salesperson  = new \SalespersonDB();

    }

    public function get ()
    {
        $userName = input('userName');
        $isCharge = input('isCharge/d', 1);  //1:不是 2：是
        $C_khmc   = input('C_khmc');
        $pn       = input('pn/d', 1);
        $ps       = 15;
        $start    = ($pn - 1) * $ps;

        if (empty($userName)) {
            return json(error('缺少必要的参数'));
        }

        if ($isCharge == 2) {
            $where = [];
        } else {
            $where = ['E_xsry' => $userName];
        }

        if (!empty($C_khmc)) {
            $where['C_khmc'] = ['$regex' => $C_khmc, '$options' => 'i'];
        }

        $data = $this->mod_data->get($where,$start,$ps);
        $list = [];
        foreach ($data as $item) {
            $list[] = [
                'id'        => $item['id'],
                'A_dh'      => $item['A_dh'],
                'C_khmc'    => $item['C_khmc'],
                'D_zj'      => $item['D_zj'],
                'F_fh'      => $item['F_fh'],
                'G_fhbl'    => $item['G_fhbl'] . '%',
                'I_ghbl'    => $item['I_ghbl'] . '%',
                'J_dqsj'    => date('Y-m-d',$item['J_dqsj']),
                'K_jqsj'    => date('Y-m-d',$item['K_jqsj']),

            ];
        }

    }

    public function getInfo ()
    {

    }
}
