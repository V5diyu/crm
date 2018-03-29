<?php
/**
 * Created by PhpStorm.
 * User: luotao
 * Date: 2017/10/18
 * Time: 下午2:23
 */

namespace app\admin\controller;


class OrderInfo extends Base
{
    private $mod;
    private $mod_data;
    private $mod_salesperson;
    private $mod_salespersonStatistics;
    private $mod_companyStatistics;
    private $mod_correctError;


    public function __construct()
    {
        $this->mod                       = new \OrderInfoDB();
        $this->mod_data                  = new \OrderInfoDataDB();
        $this->mod_salesperson           = new \SalespersonDB();
        $this->mod_salespersonStatistics = new \SalespersonStatisticsDB();
        $this->mod_companyStatistics     = new \CompanyStatisticsDB();
        $this->mod_correctError          = new \CorrectErrorDB();
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
        $list = [];
        foreach ($excel_array as $k => $v) {
            if (isset($v[0]) && !empty($v[0]) && strtotime(substr(strstr($v[0], '2'), 0, 8))) {
                $item   = [
                    'id'         => getUuid(),
                    'A_hth'      => strEmptyChange($v[0]),
                    //合同号
                    'B_htqyrq'   => strtotime($v[1]) ? strtotime($v[1]) : \PHPExcel_Shared_Date::ExcelToPHP($v[1]),
                    //合同签约日期
                    'C_ssxm'     => strEmptyChange($v[2]),
                    //所属项目
                    'D_khdw'     => strEmptyChange($v[3]),
                    //客户单位
                    'E_zj'       => strEmptyFloat($v[4]),
                    //总价
                    'F_xsry'     => strEmptyChange(trim($v[5])),
                    //销售人员
                    'G_fh'       => strEmptyChange($v[6]),
                    //发货
                    'H_fhbl'     => round(strEmptyChange($v[7]) * 100, 2),
                    //发货比例
                    'I_fp'       => strEmptyChange($v[8]),
                    //发票
                    'J_fkje'     => strEmptyFloat($v[9]),
                    //付款金额
                    'K_fkbl'     => round(strEmptyChange($v[10]) * 100, 2),
                    //付款比例
                    'L_fkxq'     => strEmptyChange($v[11]),
                    //付款详情
                    'M_qkje'     => strEmptyFloat($v[12]),
                    //欠款金额
                    'N_wkdqr'    => empty($v[13]) ? '' : (strtotime($v[13]) ? strtotime($v[13]) : (is_string($v[13]) ? $v[13] : \PHPExcel_Shared_Date::ExcelToPHP($v[13]))),
                    //尾款到期日
                    'O_sfcq'     => strEmptyChange($v[14]),
                    //是否超期
                    'P_cwhxclyj' => strEmptyChange($v[15]),
                    //财务后续处理意见
                    'Q_xsclfk'   => strEmptyChange($v[16]),
                    //销售处理反馈
                    'R_zsdsl'    => 0,
                    //总受订数量
                    'S_zxhsl'    => 0,
                    //总销货数量
                ];
                $list[] = $item;
            }
        }
        $data_salespersonStatistics = [];
        $data_companyStatistics     = [];

        foreach ($list as $item) {
            $time   = date('Y-m', $item['B_htqyrq']);
            $time_y = date('Y', $item['B_htqyrq']);
            if (!isset($data_salespersonStatistics[$item['F_xsry']][$time])) {
                $data_salespersonStatistics[$item['F_xsry']][$time] = [
                    'name'             => $item['F_xsry'],
                    'time'             => $time,
                    'time_y'           => $time_y,
                    'myContractVolume' => $item['E_zj'],        //本人签约额
                    'myReturnAmount'   => $item['J_fkje'],      //本人回款额
                    'myReceivables'    => $item['M_qkje'],      //本人应收款
                ];
            }
            else {
                $data_salespersonStatistics[$item['F_xsry']][$time] = [
                    'name'             => $item['F_xsry'],
                    'time'             => $time,
                    'time_y'           => $time_y,
                    'myContractVolume' => $data_salespersonStatistics[$item['F_xsry']][$time]['myContractVolume'] + $item['E_zj'],
                    'myReturnAmount'   => $data_salespersonStatistics[$item['F_xsry']][$time]['myReturnAmount'] + $item['J_fkje'],
                    'myReceivables'    => $data_salespersonStatistics[$item['F_xsry']][$time]['myReceivables'] + $item['M_qkje'],
                ];
            }
            if (isset($data_companyStatistics[$time])) {
                $data_companyStatistics[$time] = $data_companyStatistics[$time] + $item['E_zj'];
            }
            else {
                $data_companyStatistics[$time] = $item['E_zj'];
            }
        }
        if (!empty($list)) {
            $this->mod_data->batchInsert($list);
        }
        $list_salespersonStatistics = [];
        foreach ($data_salespersonStatistics as $k => $v) {
            foreach ($v as $key => $value) {
                $list_salespersonStatistics[] = $value;
            }
        }
        $this->mod_salespersonStatistics->delete([]);
        $this->mod_salespersonStatistics->batchInsert($list_salespersonStatistics);

        $list_companyStatistics = [];
        foreach ($data_companyStatistics as $k => $v) {
            $list_companyStatistics[] = [
                'time'                  => $k,
                'companyContractVolume' => $v,
            ];
        }
        $this->mod_companyStatistics->delete([]);
        $this->mod_companyStatistics->batchInsert($list_companyStatistics);
        return json(ok());
    }

    /**
     *  导入合同
     */
    public function uploadOne()
    {
        if (empty($_FILES)) {
            return json(error());
        }
        $postfix = substr(strrchr($_FILES['file']['name'], '.'), 0);
        if ($postfix != '.xlsx' && $postfix != '.xls') {
            return json(error('上传文件格式不正确,请上传excel文件'));
        }
        $file_name = $_FILES['file']['tmp_name'];
        $objReader = \PHPExcel_IOFactory::createReader(\PHPExcel_IOFactory::identify($file_name));
        $objReader->setReadDataOnly(true);
        $obj_PHPExcel = $objReader->load($file_name);  //加载文件内容,编码utf-8
        $excel_array  = $obj_PHPExcel->getsheet(0)->toArray();   //转换为数组格式
        array_shift($excel_array);
        $excel_list = [];
        foreach ($excel_array as $k => $v) {
            if (isset($v[1]) && !empty($v[1]) && strtotime(substr(strstr($v[1], '2'), 0, 8))) {
                $item         = [
                    'id'         => getUuid(),
                    'A_hth'      => strEmptyChange($v[1]),                          //合同号
                    'B_htqyrq'   => strtotime(substr(strstr($v[1], '2'), 0, 8)),    //合同签约日期
                    'C_ssxm'     => '',                                             //所属项目
                    'D_khdw'     => strEmptyChange($v[0]),                          //客户单位
                    'E_zj'       => strEmptyChange($v[4]),                          //总价
                    'F_xsry'     => strEmptyChange(trim($v[2])),                    //销售人员
                    'G_fh'       => '未发货',                                        //发货
                    'H_fhbl'     => 0,                                              //发货比例
                    'I_fp'       => '',                                             //发票
                    'J_fkje'     => 0,                                              //付款金额
                    'K_fkbl'     => 0,                                              //付款比例
                    'L_fkxq'     => '',                                             //付款详情
                    'M_qkje'     => strEmptyChange($v[4]),                          //欠款金额
                    'N_wkdqr'    => '',                                             //尾款到期日
                    'O_sfcq'     => '',                                             //是否超期
                    'P_cwhxclyj' => '',                                             //财务后续处理意见
                    'Q_xsclfk'   => '',                                             //销售处理反馈
                    'R_zsdsl'    => strEmptyChange($v[3]),                          //总受订数量
                    'S_zxhsl'    => 0,                                              //总销货数量

                ];
                $excel_list[] = $item;
            }
        }
        $list_hth                   = array_column($excel_list, 'A_hth');
        $data_orderData             = $this->mod_data->get(['A_hth' => ['$in' => $list_hth]]);
        $data_hth                   = array_column(iterator_to_array($data_orderData), 'A_hth');
        $insert_orderData           = [];
        $data_salespersonStatistics = [];
        $data_companyStatistics     = [];
        foreach ($excel_list as $item) {
            //订单数据组合
            if (!in_array($item['A_hth'], $data_hth)) {
                $insert_orderData[] = $item;
            }
            else {
                $info    = $this->mod_data->getInfo(['A_hth' => $item['A_hth']]);
                $E_zj    = $info['E_zj'] + $item['E_zj'];               //总价
                $M_qkje  = $info['M_qkje'] + $item['M_qkje'];           //欠款金额
                $R_zsdsl = $info['R_zsdsl'] + $item['R_zsdsl'];         //总销货数量
                $this->mod_data->update(['E_zj' => $E_zj, 'M_qkje' => $M_qkje, 'R_zsdsl' => $R_zsdsl], $info['id']);
            }
            //统计数据组合
            $time   = date('Y-m', $item['B_htqyrq']);
            $time_y = date('Y', $item['B_htqyrq']);

            /*error*/
            if (!isset($data_salespersonStatistics[$item['F_xsry']][$time])) {
                $data_salespersonStatistics[$item['F_xsry']][$time] = [
                    'name'             => $item['F_xsry'],
                    'time'             => $time,
                    'time_y'           => $time_y,
                    'myContractVolume' => $item['E_zj'],        //本人签约额
                    'myReturnAmount'   => 0,                    //本人回款额
                    'myReceivables'    => $item['E_zj'],        //本人应收款
                ];
            } else {
                $data_salespersonStatistics[$item['F_xsry']][$time] = [
                    'name'             => $item['F_xsry'],
                    'time'             => $time,
                    'time_y'           => $time_y,
                    'myContractVolume' => $data_salespersonStatistics[$item['F_xsry']][$time]['myContractVolume'] + $item['E_zj'],
                    'myReceivables'    => $data_salespersonStatistics[$item['F_xsry']][$time]['myReceivables'] + $item['E_zj'],
                ];
            }
            if (isset($data_companyStatistics[$time])) {
                $data_companyStatistics[$time] = $data_companyStatistics[$time] + $item['E_zj'];
            }
            else {
                $data_companyStatistics[$time] = $item['E_zj'];
            }

        }
        //写入订单信息
        if (!empty($insert_orderData)) {
            $this->mod_data->batchInsert($insert_orderData);
        }
        //写入销售统计信息
        $list_salespersonStatistics = [];
        foreach ($data_salespersonStatistics as $k => $v) {
            foreach ($v as $key => $value) {
                $info = $this->mod_salespersonStatistics->getInfo(['name' => $value['name'], 'time' => $value['time']]);
                if (empty($info)) {
                    $list_salespersonStatistics[] = $value;
                } else {
                    $myContractVolume = $value['myContractVolume'] + $info['myContractVolume'];
                    $myReceivables    = $value['myReceivables'] + $info['myReceivables'];
                    $this->mod_salespersonStatistics->update([
                        'myContractVolume' => $myContractVolume,
                        'myReceivables'    => $myReceivables
                    ], [
                        'name' => $value['name'],
                        'time' => $value['time']
                    ]);
                }
            }
        }
        if (!empty($list_salespersonStatistics)) {
            $this->mod_salespersonStatistics->batchInsert($list_salespersonStatistics);
        }
        //写入公司总统计
        $list_companyStatistics = [];
        foreach ($data_companyStatistics as $k => $v) {
            $info = $this->mod_companyStatistics->getInfo(['time' => $k]);
            if (empty($info)) {
                $list_companyStatistics[] = [
                    'time'                  => $k,
                    'companyContractVolume' => $v,
                ];
            } else {
                $companyContractVolume = $info['companyContractVolume'] + $v;
                $this->mod_companyStatistics->update(['companyContractVolume' => $companyContractVolume], ['time' => $k]);
            }
        }
        if (!empty($list_companyStatistics)) {
            $this->mod_companyStatistics->batchInsert($list_companyStatistics);
        }
        return json(ok());
    }

    /**
     * 导入发货统计
     */
    public function uploadTwo()
    {
        if (empty($_FILES)) {
            return json(error());
        }
        $postfix = substr(strrchr($_FILES['file']['name'], '.'), 0);
        if ($postfix != '.xlsx' && $postfix != '.xls') {
            return json(error('上传文件格式不正确,请上传excel文件'));
        }
        $file_name = $_FILES['file']['tmp_name'];
        $objReader = \PHPExcel_IOFactory::createReader(\PHPExcel_IOFactory::identify($file_name));
        $objReader->setReadDataOnly(true);
        $obj_PHPExcel = $objReader->load($file_name);  //加载文件内容,编码utf-8
        $excel_array  = $obj_PHPExcel->getsheet(0)->toArray();   //转换为数组格式
        array_shift($excel_array);
        $excel_list = [];
        foreach ($excel_array as $k => $v) {
            if (isset($v[1]) && !empty($v[1]) && strtotime(substr(strstr($v[1], '2'), 0, 8))) {
                $item         = [
                    'A_hth'   => strEmptyChange($v[1]),      //合同号
                    'S_zxhsl' => strEmptyChange($v[2]),      //总销货数量
                ];
                $excel_list[] = $item;
            }
        }
        foreach ($excel_list as $item) {
            $info = $this->mod_data->getInfo(['A_hth' => $item['A_hth']]);
            if (!empty($info)) {
                $R_zsdsl = $info['R_zsdsl'];
                $S_zxhsl = $info['S_zxhsl'] + $item['S_zxhsl'];
                $H_fhbl  = round(($S_zxhsl / $R_zsdsl) * 100, 2);
                $setData = ['G_fh' => '已发货', 'H_fhbl' => $H_fhbl, 'S_zxhsl' => $S_zxhsl];
                if ($H_fhbl == 100) {
                    $setData['N_wkdqr'] = time() + 3600 * 24 * 90;
                }
                $this->mod_data->update($setData, $info['id']);
            }
        }
        return json(ok());
    }

    /**
     * 导入收款明细
     */
    public function uploadThree()
    {
        if (empty($_FILES)) {
            return json(error());
        }
        $postfix = substr(strrchr($_FILES['file']['name'], '.'), 0);
        if ($postfix != '.xlsx' && $postfix != '.xls') {
            return json(error('上传文件格式不正确,请上传excel文件'));
        }
        $file_name = $_FILES['file']['tmp_name'];
        $objReader = \PHPExcel_IOFactory::createReader(\PHPExcel_IOFactory::identify($file_name));
        $objReader->setReadDataOnly(true);
        $obj_PHPExcel = $objReader->load($file_name);  //加载文件内容,编码utf-8
        $excel_array  = $obj_PHPExcel->getsheet(0)->toArray();   //转换为数组格式
        array_shift($excel_array);
        $excel_list = [];
        foreach ($excel_array as $k => $v) {
            if (isset($v[0]) && !empty($v[0]) && strtotime(substr(strstr($v[0], '2'), 0, 8))) {
                $item         = [
                    'A_hth'  => strEmptyChange($v[0]),      //合同号
                    'J_fkje' => strEmptyChange($v[3]),                                             //付款金额
                ];
                $excel_list[] = $item;
            }
        }
        $data_salespersonStatistics = [];
        foreach ($excel_list as $item) {
            $info = $this->mod_data->getInfo(['A_hth' => $item['A_hth']]);
            if (!empty($info)) {
                $E_zj    = $info['E_zj'];
                $J_fkje  = $info['J_fkje'] + $item['J_fkje'];
                $K_fkbl  = round(($J_fkje / $E_zj) * 100, 2);
                $setData = ['J_fkje' => $J_fkje, 'K_fkbl' => $K_fkbl];
                if ($E_zj != $J_fkje && $E_zj > 0) {
                    $setData['M_qkje'] = $info['E_zj'] - $J_fkje;
                }
                $this->mod_data->update($setData, $info['id']);

                //统计数据组合
                $time   = date('Y-m', $item['B_htqyrq']);
                $time_y = date('Y', $item['B_htqyrq']);
                if (!isset($data_salespersonStatistics[$item['F_xsry']][$time])) {
                    $data_salespersonStatistics[$item['F_xsry']][$time] = [
                        'name'           => $item['F_xsry'],
                        'time'           => $time,
                        'time_y'         => $time_y,
                        'myReturnAmount' => $item['J_fkje'],          //本人回款额
                    ];
                }
                else {
                    $data_salespersonStatistics[$item['F_xsry']][$time] = [
                        'name'           => $item['F_xsry'],
                        'time'           => $time,
                        'time_y'         => $time_y,
                        'myReturnAmount' => $data_salespersonStatistics[$item['F_xsry']][$time]['myReturnAmount'] + $item['J_fkje'],
                    ];
                }
            }
        }
        //修改销售统计信息
        foreach ($data_salespersonStatistics as $k => $v) {
            foreach ($v as $key => $value) {
                $info = $this->mod_salespersonStatistics->getInfo(['name' => $value['name'], 'time' => $value['time']]);
                if (!empty($info)) {
                    $myReturnAmount = $value['myReturnAmount'] + $info['myReturnAmount'];
                    $this->mod_salespersonStatistics->update([
                        'myReturnAmount' => $myReturnAmount,
                    ], [
                        'name' => $value['name'],
                        'time' => $value['time']
                    ]);
                }
            }
        }
        return json(ok());
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
        $sort      = ['B_htqyrq' => -1];
        if (!empty($search)) {
            $where['$or'] = [
                ['D_khdw' => ['$regex' => $search, '$options' => 'i']],
                ['A_hth' => ['$regex' => $search, '$options' => 'i']]
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
            $where['B_htqyrq'] = $timeWhere;
        }
        $accountInfo = $this->getUserInfo();
        if ($accountInfo['setUp'] == 4) {
            $where['F_xsry'] = $accountInfo['name'];
        }
        $data  = $this->mod_data->get($where, $start, $ps, $sort);
        $count = $this->mod_data->count($where);
        $list  = [];
        foreach ($data as $item) {
            $item['B_htqyrq'] = date('Y-m-d', $item['B_htqyrq']);
            $item['N_wkdqr']  = empty($item['N_wkdqr']) ? '' : (is_string($item['N_wkdqr']) ? $item['N_wkdqr'] : date('Y-m-d', $item['N_wkdqr']));
            $item['H_fhbl']   = $item['H_fhbl'] . '%';
            $item['K_fkbl']   = $item['K_fkbl'] . '%';
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
        $info['B_htqyrq'] = date('Y-m-d', $info['B_htqyrq']);
        $info['N_wkdqr']  = empty($info['N_wkdqr']) ? '' : date('Y-m-d', $info['N_wkdqr']);
        return json(ok($info));
    }


    public function update()
    {
        $id         = input('id');
        $A_hth      = input('A_hth');           //合同号（disabled属性）
        $B_htqyrq   = input('B_htqyrq');        //合同签约日期（disabled属性）
        $C_ssxm     = input('C_ssxm');          //所属项目
        $D_khdw     = input('D_khdw');          //客户单位
        $E_zj       = input('E_zj/d');          //总价
        $F_xsry     = input('F_xsry');          //销售人员
        $G_fh       = input('G_fh');            //发货
        $H_fhbl     = input('H_fhbl/d');        //发货比例
        $I_fp       = input('I_fp');            //发票
        $J_fkje     = input('J_fkje/d');        //付款金额
        //$K_fkbl     = input('K_fkbl/d');          //付款比例
        $L_fkxq     = input('L_fkxq');          //付款详情
        //$M_qkje     = input('M_qkje/d');          //欠款金额
        $N_wkdqr    = input('N_wkdqr');         //尾款到期日
        $O_sfcq     = input('O_sfcq');          //是否超期
        $P_cwhxclyj = input('P_cwhxclyj');      //财务后续处理意见
        $Q_xsclfk   = input('Q_xsclfk');        //销售处理反馈

        //付款比例由计算得出(类似处理欠款金额)
        $K_fkbl     = empty($E_zj) ? 0 : round($J_fkje / $E_zj, 3) * 100 ;
        $M_qkje     = empty($E_zj) ? 0 : (float)($E_zj - $J_fkje);

        if (empty($id) || empty($A_hth) || empty($B_htqyrq)) {
            return json(error('缺少必要参数'));
        }
        $setData = [
            'C_ssxm'     => $C_ssxm,        //所属项目
            'D_khdw'     => $D_khdw,        //客户单位
            'E_zj'       => $E_zj,          //总价
            'F_xsry'     => $F_xsry,        //销售人员
            'G_fh'       => $G_fh,          //发货
            'H_fhbl'     => $H_fhbl,        //发货比例
            'I_fp'       => $I_fp,          //发票
            'J_fkje'     => $J_fkje,        //付款金额
            'K_fkbl'     => $K_fkbl,        //付款比例
            'L_fkxq'     => $L_fkxq,        //付款详情
            'M_qkje'     => $M_qkje,        //欠款金额
            'N_wkdqr'    => strtotime($N_wkdqr) ? strtotime($N_wkdqr) : $N_wkdqr,       //尾款到期日
            'O_sfcq'     => $O_sfcq,        //是否超期
            'P_cwhxclyj' => $P_cwhxclyj,    //财务后续处理意见
            'Q_xsclfk'   => $Q_xsclfk,      //销售处理反馈
        ];


        $this->mod_data->update($setData, $id);

        //合同签约日期不发生修改！！！
        //订单修改（上述步骤已完成修改），销售统计，公司统计数据都要发生变化！！！
        //订单修改是单条的，数据修改也是单条的。

        $date_month = date('Y-m',strtotime($B_htqyrq));
        $date_year  = date('Y',strtotime($B_htqyrq));

        $time_start = strtotime($date_month);
        $time_end   = strtotime("$date_month +1 month -1 second");

        //公司统计更新

        $company_info = iterator_to_array($this->mod_data->get(['B_htqyrq' => ['$gte' => $time_start, '$lte' => $time_end] ]));
        $company_sum = array_sum(array_column($company_info, "E_zj"));

        $this->mod_companyStatistics->update(['companyContractVolume'=>$company_sum],['time'=>$date_month]);

        //销售统计更新
        $sale_man_info = iterator_to_array($this->mod_data->get(['B_htqyrq' => ['$gte' => $time_start, '$lte' => $time_end], 'F_xsry' => $F_xsry ]));

        $set_data = [
            "myContractVolume" => array_sum(array_column($sale_man_info,"E_zj")),
            "myReturnAmount" => array_sum(array_column($sale_man_info,"J_fkje")),
            "myReceivables"  => array_sum(array_column($sale_man_info,"M_qkje"))
        ];

        $this->mod_salespersonStatistics->update($set_data,['time'=>$date_month,'name'=>$F_xsry]);


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

    public function downfileBak()
    {
        $search    = input('search');           //客户简称
        $startTime = input('startTime');
        $endTime   = input('endTime');
        $where     = [];
        if (!empty($search)) {
            $where['$or'] = [
                ['D_khdw' => ['$regex' => $search, '$options' => 'i']],
                ['A_hth' => ['$regex' => $search, '$options' => 'i']]
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
            $where['B_htqyrq'] = $timeWhere;
        }
        $accountInfo = $this->getUserInfo();
        if ($accountInfo['setUp'] == 4) {
            $where['F_xsry'] = $accountInfo['name'];
        }

        $PHPExcel = new \PHPExcel();
        $PHPSheet = $PHPExcel->getActiveSheet();
        $name     = '订单信息_' . date('Y-m-d');
        setExcelTitleStyle($PHPSheet, 17);
        $PHPSheet->setCellValue("A1", "合同号")->setCellValue("B1", "合同签约日期")->setCellValue("C1", "所属项目")->setCellValue("D1", "客户单位")->setCellValue("E1", "总价")->setCellValue("F1", "销售人员")->setCellValue("G1", "发货")->setCellValue("H1", "发货比例")->setCellValue("I1", "发票")->setCellValue("J1", "付款金额")->setCellValue("K1", "付款比例")->setCellValue("L1", "付款详情")->setCellValue("M1", "欠款金额")->setCellValue("N1", "尾款到期日")->setCellValue("O1", "是否超期")->setCellValue("P1", "财务后续处理意见")->setCellValue("Q1", "销售处理反馈");
        $PHPSheet->setTitle($name);
        $data = $this->mod_data->get($where);
        $i    = 1;
        foreach ($data as $item) {
            $i++;
            $PHPSheet->setCellValue("A$i", $item['A_hth'])->setCellValue("B$i", date('Y-m-d', $item['B_htqyrq']))->setCellValue("C$i", $item['C_ssxm'])->setCellValue("D$i", $item['D_khdw'])->setCellValue("E$i", $item['E_zj'])->setCellValue("F$i", $item['F_xsry'])->setCellValue("G$i", $item['G_fh'])->setCellValue("H$i", $item['H_fhbl'] . '%')->setCellValue("I$i", $item['I_fp'])->setCellValue("J$i", $item['J_fkje'])->setCellValue("K$i", $item['K_fkbl'] . '%')->setCellValue("L$i", $item['L_fkxq'])->setCellValue("M$i", $item['M_qkje'])->setCellValue("N$i", empty($item['N_wkdqr']) ? '' : date('Y-m-d', $item['N_wkdqr']))->setCellValue("O$i", $item['O_sfcq'])->setCellValue("P$i", $item['P_cwhxclyj'])->setCellValue("Q$i", $item['Q_xsclfk']);
        }
        $PHPWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, "Excel2007");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=$name.xlsx");
        $PHPWriter->save("php://output");
    }


    public function downfile ()
    {
        $search    = input('search');           //客户简称
        $startTime = input('startTime');
        $endTime   = input('endTime');
        $where     = [];
        if (!empty($search)) {
            $where['$or'] = [
                ['D_khdw' => ['$regex' => $search, '$options' => 'i']],
                ['A_hth' => ['$regex' => $search, '$options' => 'i']]
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
            $where['B_htqyrq'] = $timeWhere;
        }
        $accountInfo = $this->getUserInfo();
        if ($accountInfo['setUp'] == 4) {
            $where['F_xsry'] = $accountInfo['name'];
        }

        $PHPExcel = new \PHPExcel();
        $PHPSheet = $PHPExcel->getActiveSheet();
        $name     = '订单信息_' . date('Y-m-d');
        setExcelTitleStyle($PHPSheet, 16);
        $PHPSheet->setCellValue("A1", "合同号")->setCellValue("B1", "合同签约日期")->setCellValue("C1", "客户单位")->setCellValue("D1", "总价")->setCellValue("E1", "销售人员")->setCellValue("F1", "发货")->setCellValue("G1", "发货比例")->setCellValue("H1", "发票")->setCellValue("I1", "付款金额")->setCellValue("J1", "付款比例")->setCellValue("K1", "付款详情")->setCellValue("L1", "欠款金额")->setCellValue("M1", "尾款到期日")->setCellValue("N1", "是否超期")->setCellValue("O1", "财务后续处理意见")->setCellValue("P1", "销售处理反馈");
        $PHPSheet->setTitle($name);
        $data = $this->mod_data->get($where);
        $i    = 1;
        foreach ($data as $item) {
            $i++;
            $PHPSheet->setCellValue("A$i", $item['A_hth'])->setCellValue("B$i", date('Y-m-d', $item['B_htqyrq']))->setCellValue("C$i", $item['C_ssxm'])->setCellValue("C$i", $item['D_khdw'])->setCellValue("D$i", $item['E_zj'])->setCellValue("E$i", $item['F_xsry'])->setCellValue("F$i", $item['G_fh'])->setCellValue("G$i", $item['H_fhbl'] . '%')->setCellValue("H$i", $item['I_fp'])->setCellValue("I$i", $item['J_fkje'])->setCellValue("J$i", $item['K_fkbl'] . '%')->setCellValue("K$i", $item['L_fkxq'])->setCellValue("L$i", $item['M_qkje'])->setCellValue("M$i", empty($item['N_wkdqr']) ? '' : date('Y-m-d', $item['N_wkdqr']))->setCellValue("N$i", $item['O_sfcq'])->setCellValue("O$i", $item['P_cwhxclyj'])->setCellValue("P$i", $item['Q_xsclfk']);
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