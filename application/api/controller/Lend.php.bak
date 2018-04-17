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
        $F_khmc   = input('F_khmc');
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

        if (!empty($F_khmc)) {
            $where['F_khmc'] = ['$regex' => $F_khmc, '$options' => 'i'];
        }

        $data = $this->mod_data->get($where,$start,$ps);
        $list = [];
        if (!empty($data)) {
            foreach ($data as $item) {
                $list[] = [
                    'id'        => $item['id'],
                    'A_dh'      => $item['A_dh'],
                    'B_ph'      => $item['B_ph'],
                    'C_pm'      => $item['C_pm'],
                    'D_zj'      => $item['D_zj'],
                    'E_xsry'    => $item['E_xsry'],
                    'F_khmc'    => $item['F_khmc'],
                    'G_jysl'    => $item['G_jysl'],
                    'H_ghsl'    => $item['H_ghsl'],
                    'I_jcsj'    => date('Y-m-d',$item['I_jcsj']),
                    'J_ghsj'    => date('Y-m-d',$item['J_ghsj']),
                    'K_dqsj'    => date('Y-m-d',$item['K_dqsj']),
                ];
            }
        }
        return json(ok($list));

    }

    public function getInfo ()
    {

    }
}
