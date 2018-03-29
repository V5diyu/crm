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
                ['C_khmc'   => ['$regex' => $search, '$options' => 'i']]
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
            $where['B_jcrq'] = $timeWhere;
        }

        $accountInfo = $this->getUserInfo();
        if ($accountInfo['setUp'] == 4) {
            $where['E_xhry'] = $accountInfo['name'];
        }
        $data  = $this->mod_lend->get($where, $start, $ps, $sort);
        $count = $this->mod_lend->count($where);
        $list  = [];

        foreach ($data as $item) {

            //(是否与发货时间有关系？)(为空，显示空字符串，不为空显示时间格式)
            //$item['B_jcrq'] = date('Y-m-d', $item['B_jcrq']);
            //$item['J_dqsj'] = date("Y-m-d", $item['J_dqsj']);
            //$item['K_jqsj'] = date("Y-m-d", $item['K_jqsj']);
            $item['I_ghbl'] = $item['I_ghbl'] ;
            $item['G_fhbl'] = $item['G_fhbl'] ;
            $list[]           = $item;
        }

        return json(ok(['list' => $list, 'count' => $count]));
    }

    public function update()
    {
        $id         = input('id');
        $A_hth      = input('A_dh');            //单号（disabled属性）
        $B_jcrq     = input('B_jcrq');          //借出日期（disabled属性）
        $C_khmc     = input('C_khmc');          //客户单位
        $D_zj       = input('D_zj');            //总价
        $E_xsry     = input('E_xsry');          //销售人员
        $F_fh       = input('F_fh');            //发货
        $G_fhbl     = input('G_fhbl');          //发货比例
        $H_gh       = input('H_gh');            //归还
        $I_ghbl     = input('I_ghbl');          //归还比例
        $J_dqsj     = input('J_dqsj');          //到期时间
        $K_jqsj     = input('K_jqsj');          //交期时间


        if (empty($id) || empty($A_hth) || empty($B_jcrq)) {
            return json(error('缺少必要参数'));
        }
        $setData = [
            'C_khmc'     => $C_khmc,            //所属项目
            'D_zj'       => $D_zj,              //客户单位
            'E_xsry'     => $E_xsry,            //总价
            'F_fh'       => $F_fh,              //销售人员
            'G_fhbl'     => $G_fhbl,            //发货
            'H_gh'       => $H_gh,              //发货比例
            'I_ghbl'     => $I_ghbl,            //发票
            'J_dqsj'     => $J_dqsj,            //付款金额
            'K_jqsj'     => strtotime($K_jqsj)  //交期时间
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
                ['C_khmc'   => ['$regex' => $search, '$options' => 'i']]
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
            $where['B_jcrq'] = $timeWhere;
        }

        $accountInfo = $this->getUserInfo();
        if ($accountInfo['setUp'] == 4) {
            $where['E_xhry'] = $accountInfo['name'];
        }

        $data  = $this->mod_lend->get($where, $start, $ps, $sort);

        $PHPExcel = new \PHPExcel();
        $PHPSheet = $PHPExcel->getActiveSheet();
        $name     = '借用信息_' . date('Y-m-d');
        setExcelTitleStyle($PHPSheet, 11);
        $PHPSheet->setCellValue("A1", "单号")->setCellValue("B1", "借出日期")->setCellValue("C1", "客户名称")->setCellValue("D1", "总价")->setCellValue("E1", "销售人员")->setCellValue("F1", "发货")->setCellValue("G1", "发货比例")->setCellValue("H1", "归还")->setCellValue("I1", "归还比例")->setCellValue("J1", "到期时间")->setCellValue("K1", "交期日期");
        $PHPSheet->setTitle($name);
        $i    = 1;
        foreach ($data as $item) {
            $i++;

            //时间格式修改（应该存入时间戳）
            $PHPSheet->setCellValue("A$i", $item['A_dh'])->setCellValue("B$i", date('Y-m-d', strtotime($item['B_jcrq'])))->setCellValue("C$i", $item['C_khmc'])->setCellValue("D$i", $item['D_zj'])->setCellValue("E$i", $item['E_xsry'])->setCellValue("F$i", $item['F_fh'])->setCellValue("G$i", $item['G_fhbl'] . '%')->setCellValue("H$i", $item['H_gh'])->setCellValue("I$i", $item['I_ghbl'] . '%')->setCellValue("J$i", $item['J_dqsj'])->setCellValue("K$i", $item['K_jqsj']);
        }
        $PHPWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, "Excel2007");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=$name.xlsx");
        $PHPWriter->save("php://output");
    }
}