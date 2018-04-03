<?php
/**
 * Created by PhpStorm.
 * User: w
 * Date: 2018/3/14
 * Time: 18:57
 */

namespace app\admin\controller;

use think\Request;

class Lend extends Base
{
    private $mod_lend;

    public function __construct()
    {
        $this->mod_lend = new \LendDB();
    }


    public function uploadExcel()
    {

    }


    public function get()
    {
        $search    = input('search');           //单号或者客户简称
        $startTime = input('startTime');
        $endTime   = input('endTime');
        $pn        = input('pn', 1);
        $ps        = 15;
        $start     = ($pn - 1) * $ps;

        $where     = [];
        $sort      = [];
        if (!empty($search)) {
            $where['$or'] = [
                ['A_dh'     => ['$regex' => $search, '$options' => 'i']],
                ['F_khmc'   => ['$regex' => $search, '$options' => 'i']]
            ];
        }
        if (!empty($startTime) || !empty($endTime)) {
            $timeWhere = [];
            if (!empty($startTime)) {
                $timeWhere['$gte'] = $startTime / 1000;
            }
            if (!empty($endTime)) {
                $timeWhere['$lt'] = $endTime / 1000;
            }
            $where['I_jcsj'] = $timeWhere;
        }

        $accountInfo = $this->getUserInfo();
        if ($accountInfo['setUp'] == 4) {
            $where['E_xhry'] = $accountInfo['name'];
        }
        $data  = $this->mod_lend->get($where, $start, $ps, $sort);
        $count = $this->mod_lend->count($where);
        $list  = [];

        foreach ($data as $item) {

            $item['I_jcsj'] = empty($item['I_jcsj']) ? '' : date('Y-m-d', $item['I_jcsj']);
            $item['J_ghsj'] = empty($item['J_ghsj']) ? '' : date("Y-m-d", $item['J_ghsj']);
            $item['K_dqsj'] = empty($item['K_dqsj']) ? '' : date("Y-m-d", $item['K_dqsj']);
            $list[]           = $item;
        }

        return json(ok(['list' => $list, 'count' => $count]));
    }

    public function update()
    {
        $id         = input('id');
        $A_hth      = input('A_dh');            //单号（disabled属性）

        $E_xsry     = input('E_xsry');          //销售人员
        $F_khmc     = input('F_khmc');          //客户单位
        $G_jysl     = input('G_jysl');          //借出数量
        $H_ghsl     = input('H_ghsl');          //归还数量
        $I_jcsj     = input('I_jcsj');          //借出日期（disabled属性）
        $J_ghsj     = input('J_ghsj');          //归还日期
        $K_dqsj     = input('K_dqsj');          //到期时间

        $D_zj       = input('D_zj');            //总价计算



        if (empty($id) || empty($A_hth) || empty($B_jcrq)) {
            return json(error('缺少必要参数'));
        }
        $setData = [
            'E_xsry'     => $E_xsry,            //所属项目
            'F_khmc'     => $F_khmc,            //客户单位
            'G_jysl'     => $G_jysl,            //总价
            'H_ghsl'     => $H_ghsl,            //销售人员
            'I_jcsj'     => $I_jcsj,            //发货
            'J_ghsj'     => $J_ghsj,            //发货比例
            'K_dqsj'     => $K_dqsj,            //发票
        ];

        $this->mod_lend->update($setData,$id);
        return json(ok());

    }

    public function delete ()
    {
        $id = input('id');
        if (empty($id)) {
            return json(error('缺少必要参数'));
        }
        $info = $this->mod_lend->getInfo($id);
        if (empty($info)) {
            return json(error('参数错误'));
        }
        $this->mod_lend->delete($id);
        return json(ok());
    }

    public function downfile()
    {
        $search    = input('search');           //单号或者客户简称
        $startTime = input('startTime');
        $endTime   = input('endTime');
        $pn        = input('pn', 1);
        $ps        = 15;
        $start     = ($pn - 1) * $ps;

        $where     = [];
        $sort      = [];
        if (!empty($search)) {
            $where['$or'] = [
                ['A_dh'     => ['$regex' => $search, '$options' => 'i']],
                ['F_khmc'   => ['$regex' => $search, '$options' => 'i']]
            ];
        }
        if (!empty($startTime) || !empty($endTime)) {
            $timeWhere = [];
            if (!empty($startTime)) {
                $timeWhere['$gte'] = $startTime / 1000;
            }
            if (!empty($endTime)) {
                $timeWhere['$lt'] = $endTime / 1000;
            }
            $where['I_jcsj'] = $timeWhere;
        }

        $accountInfo = $this->getUserInfo();
        if ($accountInfo['setUp'] == 4) {
            $where['E_xhry'] = $accountInfo['name'];
        }

        $data  = $this->mod_lend->get($where, $start, $ps, $sort);

        $PHPExcel = new \PHPExcel();
        $PHPSheet = $PHPExcel->getActiveSheet();
        $name     = '借用信息_' . date('Y-m-d-H:i:s');
        setExcelTitleStyle($PHPSheet, 11);
        $PHPSheet->setCellValue("A1", "单号")->setCellValue("B1", "品号")->setCellValue("C1", "品名")->setCellValue("D1", "总价")->setCellValue("E1", "销售人员")->setCellValue("F1", "客户名称")->setCellValue("G1", "借用数量")->setCellValue("H1", "归还数量")->setCellValue("I1", "借出时间")->setCellValue("J1", "归还时间")->setCellValue("K1", "到期日期");
        $PHPSheet->setTitle($name);
        $i    = 1;
        foreach ($data as $item) {
            $i++;

            //时间格式修改（应该存入时间戳）
            $PHPSheet->setCellValue("A$i", $item['A_dh'])->setCellValue("B$i", ($item['B_ph']))->setCellValue("C$i", $item['C_pm'])->setCellValue("D$i", $item['D_zj'])->setCellValue("E$i", $item['E_xsry'])->setCellValue("F$i", $item['F_khmc'])->setCellValue("G$i", $item['G_jysl'] )->setCellValue("H$i", $item['H_ghsl'])->setCellValue("I$i", date("Y-m-d",$item['I_jcsj']))->setCellValue("J$i", date("Y-m-d",$item['J_ghsj']))->setCellValue("K$i", date("Y-m-d",$item['K_jqsj']));
        }
        $PHPWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, "Excel2007");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=$name.xlsx");
        $PHPWriter->save("php://output");
    }
}