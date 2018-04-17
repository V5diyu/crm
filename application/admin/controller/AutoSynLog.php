<?php
/**
 * Created by PhpStorm.
 * User: w
 * Date: 2018/2/8
 * Time: 18:06
 */
namespace app\admin\controller;

class AutoSynLog extends Base
{
    private $mod_autoSynLog;

    public function __construct()
    {
        $this->mod_autoSynLog = new \AutosynLogDb();
    }

    public function get ()
    {
        $search    = input('search');
        $startTime = input('startTime');
        $endTime   = input('endTime');
        $pn    = input('pn', 1);
        $ps    = 15;
        $start = ($pn - 1) * $ps;
        $where = [];
        $sort = ['syn_timestamp'=> -1];
        if (!empty($search)) {
            $where['flag'] = $search;
        }

        if (!empty($startTime) || !empty($endTime)) {
            $timeWhere = [];
            if (!empty($startTime)) {
                $timeWhere['$gte'] = $startTime / 1000;
            }
            if (!empty($endTime)) {
                $timeWhere['$lt'] = $endTime / 1000;
            }
            $where['syn_timestamp'] = $timeWhere;
        }
        $accountInfo = $this->getUserInfo();
        if ($accountInfo['setUp'] == 4) {
            $where['sale_man'] = $accountInfo['name'];
        }
        $data = $this->mod_autoSynLog->get($where, $start, $ps, $sort);
        $count = $this->mod_autoSynLog->count($where);

        $list = [];
        foreach ($data as $key => $item) {
            $item['syn_time'] = date('Y-m-d H:i:s',$item['syn_timestamp']);
            $list[] = $item;
        }
        return json(ok(['list'=>$list,'count'=>$count]));
    }

    public function getInfo ()
    {

    }

    public function downFile ()
    {
        $search    = input('search');           //合同号
        $startTime = input('startTime');
        $endTime   = input('endTime');
        $where     = [];
        if (!empty($search)) {
            $where['flag'] = $search;
        }
        if (!empty($startTime) || !empty($endTime)) {
            $timeWhere = [];
            if (!empty($startTime)) {
                $timeWhere['$gte'] = $startTime / 1000;
            }
            if (!empty($endTime)) {
                $timeWhere['$lt'] = $endTime / 1000;
            }
            $where['syn_timestamp'] = $timeWhere;
        }
        $PHPExcel = new \PHPExcel();
        $PHPSheet = $PHPExcel->getActiveSheet();
        $name     = '自动同步日志_' . date('Y-m-d-H-i-s');
        setExcelTitleStyle($PHPSheet,5);
        $PHPSheet->setCellValue("A1", "同步时间")->setCellValue("B1", "数据表")->setCellValue("C1", "同步内容")->setCellValue("D1", "标记ID")->setCellValue("E1", "操作类型");
        $PHPSheet->setTitle($name);
        $data = $this->mod_autoSynLog->get($where);
        $i    = 1;
        foreach ($data as $item) {
            $i++;

            $PHPSheet->setCellValue("A$i", date('Y-m-d H:i:s',$item['syn_timestamp']))->setCellValue("B$i", $item['syn_cont'])->setCellValue("C$i", $item['syn_field'])->setCellValue("D$i", $item['flag'])->setCellValue("E$i", ($item['type'] == 1) ? '插入' : '更新' );
        }
        $PHPWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, "Excel2007");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=$name.xlsx");
        $PHPWriter->save("php://output");
    }
}