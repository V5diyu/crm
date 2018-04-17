<?php
/**
 * Created by PhpStorm.
 * User: luotao
 * Date: 2017/10/18
 * Time: 下午2:23
 */

namespace app\admin\controller;


class ProductDelivery extends Base
{
    private $mod;
    private $mod_data;
    private $mod_correctError;
    private $mod_msg;

    public function __construct()
    {
        $this->mod              = new \ProductDeliveryDB();
        $this->mod_data         = new \ProductDeliveryDataDB();
        $this->mod_correctError = new \CorrectErrorDB();
        $this->mod_msg          = new \ProductDeliveryMsgDB();
    }

    public function uploadExcel()
    {
        if (empty($_FILES)) {
            return json(error());
        }
        $postfix = substr(strrchr($_FILES['file']['name'], '.'), 0);
        if ($postfix != '.xlsx' && $postfix != '.xls') {
            return json(error('上传文件格式不正确,请上传excel文件'));
        }
        $url = '/upload/excel/' . uniqueID() . $postfix;
        move_uploaded_file($_FILES['file']['tmp_name'], DEF_PATH . $url);
        $file_name = '.' . $url;
        $objReader = \PHPExcel_IOFactory::createReader(\PHPExcel_IOFactory::identify($file_name));
        $objReader->setReadDataOnly(true);
        $obj_PHPExcel = $objReader->load($file_name);  //加载文件内容,编码utf-8
        $excel_array  = $obj_PHPExcel->getsheet(0)->toArray();   //转换为数组格式
        array_shift($excel_array);
        $this->mod_data->delete([]);
        $list         = [];
        $list_sendMsg = [];
        $list_gcah    = [];
        foreach ($excel_array as $k => $v) {
            if (!empty($v[0])) {
                $item   = [
                    'id'       => getUuid(),
                    'A_khmc'   => trim($v[0]),
                    //客户名称
                    'B_ywy'    => strEmptyChange(trim($v[1])),
                    //业务员
                    'C_gcah'   => strEmptyChange($v[2]),
                    //工程案号
                    'D_dh'     => strEmptyChange($v[3]),
                    //单号
                    'E_ph'     => strEmptyChange($v[4]),
                    //品号
                    'F_pm'     => strEmptyChange($v[5]),
                    //品名
                    'G_hpgg'   => strEmptyChange($v[6]),
                    //货品规格
                    'H_dw'     => strEmptyChange($v[7]),
                    //单位
                    'I_ckrq'   => strEmptyChange($v[11]),
                    //出库日期
                    'J_sl'     => strEmptyChange($v[8]),
                    //数量
                    'K_xhsl'   => strEmptyChange($v[9]),
                    //销货数量
                    'L_wzxhsl' => strEmptyChange($v[10]),
                    //未转销货数量
                    'M_shrmc'  => strEmptyChange($v[12]),
                    //审核人名称
                    'N_yjfhrq' => is_float($v[13]) ? \PHPExcel_Shared_Date::ExcelToPHP($v[13]) : $v[13],
                    //预计发货日期
                    'O_bz'     => strEmptyChange($v[16]),
                    //备注
                    'P_jqsftc' => strEmptyChange($v[14]),
                    //交期是否推迟
                    'Q_jqtcyy' => strEmptyChange($v[15]),
                    //交期推迟原因
                ];
                $list[] = $item;
                if (strEmptyChange($v[14]) == '是' && !in_array($v[2], $list_gcah)) {
                    $list_gcah[]         = $v[2];
                    $list_sendMsg[] = [
                        'id'     => getUuid(),
                        'khmc'   => trim($v[0]),
                        'ywy'    => strEmptyChange(trim($v[1])),
                        'dh'     => strEmptyChange($v[3]),
                        'pm'     => strEmptyChange($v[5]),
                        'yjfhrq' => is_float($v[13]) ? \PHPExcel_Shared_Date::ExcelToPHP($v[13]) : $v[13],
                        'jqtcyy' => strEmptyChange($v[15]),
                    ];
                }
            }
        }
        if (!empty($list)) {
            $this->mod_data->batchInsert($list);
        }
        if (!empty($list_sendMsg)) {
            $this->mod_msg->batchInsert($list_sendMsg);
        }

        return json(ok());
    }

    public function get()
    {
        $name  = input('name');
        $pn    = input('pn', 1);
        $ps    = 15;
        $start = ($pn - 1) * $ps;
        $where = [];
        if (!empty($name)) {
            $where['A_khmc'] = ['$regex' => $name, '$options' => 'i'];
        }
        $accountInfo = $this->getUserInfo();
        if ($accountInfo['setUp'] == 4) {
            $where['B_ywy'] = $accountInfo['name'];
        }
        $data  = $this->mod_data->get($where, $start, $ps);
        $count = $this->mod_data->count($where);
        $list  = [];
        foreach ($data as $item) {
            $item['J_sl']   = (int)$item['J_sl'];
            $item['I_ckrq'] = is_int($item['I_ckrq']) ? date('Y-m-d', $item['I_ckrq']) : $item['I_ckrq'];
            $item['N_yjfhrq'] = empty($item['N_yjfhrq']) ? '' : (is_int($item['N_yjfhrq']) ? date('Y-m-d', $item['N_yjfhrq']) : $item['N_yjfhrq']);
            $list[]           = $item;
        }
        return json(ok(['list' => $list, 'count' => $count]));
    }

    public function getInfo()
    {
        $id = input('id');
        if (empty($id)) {
            return json(error('缺少必要参数'));
        }
        $info             = $this->mod_data->getInfo($id);
        $info['N_yjfhrq'] = is_int($info['N_yjfhrq']) ? date('Y-m-d', $info['N_yjfhrq']) : $info['N_yjfhrq'];
        return json(ok($info));
    }

    public function update()
    {
        $id       = input('id');
        $A_khmc   = input('A_khmc');        //客户名称
        $B_ywy    = input('B_ywy');         //业务员
        $C_gcah   = input('C_gcah');        //工程案号
        $D_dh     = input('D_dh');          //单号
        $E_ph     = input('E_ph');          //品号
        $F_pm     = input('F_pm');          //品名
        $G_hpgg   = input('G_hpgg');        //货品规格
        $H_dw     = input('H_dw');          //单位
        $I_ckrq   = input('I_ckrq');        //出库日期
        $J_sl     = input('J_sl');          //数量
        $K_xhsl   = input('K_xhsl');        //销货数量
        $L_wzxhsl = input('L_wzxhsl');      //未转销货数量
        $M_shrmc  = input('M_shrmc');       //审核人名称
        $N_yjfhrq = input('N_yjfhrq');      //预计发货日期
        $O_bz     = input('O_bz');          //备注
        if (empty($id) || empty($A_khmc) || empty($C_gcah)) {
            return json(error('缺少必要参数'));
        }
        $info = $this->mod_data->getInfo($id);
        if (empty($info)) {
            return json(error('参数错误'));
        }
        $setData = [
            'A_khmc'   => $A_khmc,
            'B_ywy'    => $B_ywy,
            'C_gcah'   => $C_gcah,
            'D_dh'     => $D_dh,
            'E_ph'     => $E_ph,
            'F_pm'     => $F_pm,
            'G_hpgg'   => $G_hpgg,
            'H_dw'     => $H_dw,
            'I_ckrq'   => strtotime($I_ckrq) ? strtotime($I_ckrq) : $I_ckrq,
            'J_sl'     => $J_sl,
            'K_xhsl'   => $K_xhsl,
            'L_wzxhsl' => $L_wzxhsl,
            'M_shrmc'  => $M_shrmc,
            'N_yjfhrq' => strtotime($N_yjfhrq) ? strtotime($N_yjfhrq) : $N_yjfhrq,
            'O_bz'     => $O_bz,
        ];
        $this->mod_data->update($setData, $id);
        return json(ok());
    }

    public function delete()
    {
        $id = input('id');
        if (empty($id)) {
            return json(error('缺少必要参数'));
        }
        $info = $this->mod_data->getInfo($id);
        if (empty($info)) {
            return json(error('参数错误'));
        }
        $this->mod_data->delete($id);
        return json(ok());
    }

    public function downfile()
    {
        $PHPExcel = new \PHPExcel();
        $PHPSheet = $PHPExcel->getActiveSheet();
        $name     = '产品交期';
        setExcelTitleStyle($PHPSheet, 15);
        $PHPSheet->setCellValue("A1", "客户名称")->setCellValue("B1", "业务员")->setCellValue("C1", "工程案号")->setCellValue("D1", "单号")->setCellValue("E1", "品号")->setCellValue("F1", "品名")->setCellValue("G1", "货品规格")->setCellValue("H1", "单位")->setCellValue("I1", "出库日期")->setCellValue("J1", "数量")->setCellValue("K1", "销货数量")->setCellValue("L1", "未转销货数量")->setCellValue("M1", "审核人名称")->setCellValue("N1", "预计发货日期")->setCellValue("O1", "备注");
        $PHPSheet->setTitle($name);
        $where       = [];
        $accountInfo = $this->getUserInfo();
        if ($accountInfo['setUp'] == 4) {
            $where['B_ywy'] = $accountInfo['name'];
        }
        $data = $this->mod_data->get($where);
        $i    = 1;
        foreach ($data as $item) {
            $i++;
            $PHPSheet->setCellValue("A$i", $item['A_khmc'])->setCellValue("B$i", $item['B_ywy'])->setCellValue("C$i", $item['C_gcah'])->setCellValue("D$i", $item['D_dh'])->setCellValue("E$i", $item['E_ph'])->setCellValue("F$i", $item['F_pm'])->setCellValue("G$i", $item['G_hpgg'])->setCellValue("H$i", $item['H_dw'])->setCellValue("I$i", $item['I_ckrq'])->setCellValue("J$i", $item['J_sl'])->setCellValue("K$i", $item['K_xhsl'])->setCellValue("L$i", $item['L_wzxhsl'])->setCellValue("M$i", $item['M_shrmc'])->setCellValue("N$i", is_int($item['N_yjfhrq']) ? date('Y-m-d', $item['N_yjfhrq']) : $item['N_yjfhrq'])->setCellValue("O$i", $item['O_bz']);
        }
        $PHPWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, "Excel2007");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=$name.xlsx");
        $PHPWriter->save("php://output");
    }

    //    public function getErrorList()
    //    {
    //        $id = input('id');
    //        if (empty($id)) {
    //            return json(error('缺少必要的参数'));
    //        }
    //        $data = $this->mod_correctError->get(['infoId' => $id]);
    //        $list = [];
    //        foreach ($data as $item) {
    //            $item['create'] = date('Y-m-d H:i:s', $item['create']);
    //            $list[]         = $item;
    //        }
    //        $this->mod->update(['errorStatus' => 0], $id);
    //        return json(ok($list));
    //    }
}