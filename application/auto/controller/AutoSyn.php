<?php

namespace app\auto\controller;

use think\Controller;
use think\Db;
//use app\auto\model\AutoSyn as AutoModel;

class AutoSyn extends Controller
{
    private $mod;
    private $mod_data;
    private $mod_salesperson;
    private $mod_salespersonStatistics;
    private $mod_companyStatistics;
    private $mod_correctError;
    //标志位
    private $flag = null;
    private $startTime;
	public function __construct()
    {
        $this->mod                       = new \OrderInfoDB();
        $this->mod_data                  = new \OrderInfoDataDB();
        $this->mod_salesperson           = new \SalespersonDB();
        $this->mod_salespersonStatistics = new \SalespersonStatisticsDB();
        $this->mod_companyStatistics     = new \CompanyStatisticsDB();
        $this->mod_correctError          = new \CorrectErrorDB();
    }

    public function showData ()
    {
        $servern = "localhost";
        $coninfo=array("Database"=>"DB_TK","UID"=>"sa","PWD"=>"123qwe123","CharacterSet"=>"utf-8");
        $conn=sqlsrv_connect($servern,$coninfo) or die ("连接失败!");
        if($conn){ 
            echo "OK ！HELLO SQL_SERVER<br />"; 
        }else{ 
            echo "Connection could not be established.<br />"; 
            die( print_r(sqlsrv_errors(), true)); 
        }

        if (empty($this->flag)) {
            $this->flag = true;
            $this->startTime = date('Y-m-d H:i:s',time());

            while (true && !empty($this->flag)) {
                $time_current = time();
                $time_pre = time() - 60*30;
                $str_current = date('Y-m-d H:i:s',$time_current);
                $str_pre = date('Y-m-d H:i:s');
                dump($str_current);
                $ret_1 = [];
                $sql_1 = "select p.cus_os_no as contract,p.OS_DD as contractTime, c.NAME as customer,SUM(tp.AMT) as totalprice, min(s.Name) as salesman   from MF_POS p left join CUST c on p.cus_no =c.cus_no left join TF_POS tp on tp.os_no = p.os_no left join SALM s on s.sal_no = p.sal_no where p.OS_DD >='2017-12-01 00:00:00' AND p.OS_DD<'2018-01-01 00:00:00' and p.cus_os_no is not null GROUP BY p.cus_os_no,c.NAME,p.OS_DD ORDER BY contract ";
                $sql_2 = "select p.cus_os_no as contract, count(ts.ps_no)*100/count(tp.os_no) as delivery from MF_POS p left join TF_PSS ts on ts.cus_os_no = p.cus_os_no left join TF_POS tp on tp.cus_os_no = p.cus_os_no where p.OS_DD >='2017-12-01 00:00:00' AND p.OS_DD<'2018-01-01 00:00:00' and p.cus_os_no is not null GROUP BY p.cus_os_no ORDER BY contract  ";
                $sql_3 = "select p.cus_os_no as contract, tm.amtn_bb as paid, cm.amtn_cls as payment  from MF_POS p left join TF_MON tm on tm.CAS_NO = p.cus_os_no left join TC_MON cm on cm.RP_NO = tm.RP_NO where p.OS_DD >='2017-12-01 00:00:00' AND p.OS_DD<'2018-01-01 00:00:00' and p.cus_os_no is not null order by p.cus_os_no, tm.amtn_bb desc";
                $sql_4 = "select p.cus_os_no as contract, ml.AMT as paid, tl.AMT as payment  from MF_POS p left join MF_LZ ml on ml.CAS_NO = p.cus_os_no left join TF_LZ tl on tl.cus_os_no = p.cus_os_no where p.OS_DD >='2017-12-01 00:00:00' AND p.OS_DD<'2018-01-01 00:00:00' and p.cus_os_no is not null order by p.cus_os_no, ml.AMT desc";
                //dump($sql_1);
                $stmt = sqlsrv_query($conn,$sql_1);
                //dump($stmt);
                while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                    //print_r($row["contract"].", ".$row["customer"]."<br/>");
                    //print_r($row);
                    $ret_1[$row['contract']]['contract'] = $row['contract'];
                    $ret_1[$row['contract']]['customer'] = $row['customer'];
                    $ret_1[$row['contract']]['totalprice'] = $row['totalprice'];
                    $arr = (array)$row['contractTime'];
                    $ret_1[$row['contract']]['contractTime']  = $arr['date'];
                    unset($arr);
                    unset($row);
                }
                $stmt = sqlsrv_query($conn,$sql_2);
                while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                    $ret_1[$row['contract']]['delivery'] = $row['delivery'];
                    unset($row);
                }
                $stmt = sqlsrv_query($conn,$sql_3);
                while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                    $ret_1[$row['contract']]['paid1'] = $row['paid'];
                    $ret_1[$row['contract']]['pavement1'] = $row['payment'];
                    unset($row);
                }
                $stmt = sqlsrv_query($conn,$sql_4);
                while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                    $ret_1[$row['contract']]['paid2'] = $row['paid'];
                    $ret_1[$row['contract']]['pavement2'] = $row['payment'];
                    unset($row);
                }
                //dump($ret_1);

                foreach ($ret_1 as $k => $v) {
                    $item         = [
                        'id'         => getUuid(),
                        'A_hth'      => strEmptyChange($v['contract']),                 //合同号
                        'B_htqyrq'   => strtotime(strEmptychange($v['contractTime'])),  //合同签约日期
                        'C_ssxm'     => '',                                             //所属项目
                        'D_khdw'     => '',                          //客户单位
                        'E_zj'       => strEmptyChange($v['totalprice']),               //总价
                        'F_xsry'     => strEmptyChange(trim($v['customer'])),           //销售人员
                        'G_fh'       => '未发货',                                        //发货
                        'H_fhbl'     => strEmptyFloat($v['delivery']),                  //发货比例
                        'I_fp'       => '',                                             //发票
                        'J_fkje'     => 0,                                              //付款金额
                        'K_fkbl'     => 0,                                              //付款比例
                        'L_fkxq'     => '',                                             //付款详情
                        'M_qkje'     => strEmptyChange($v['paid1']),                    //欠款金额
                        'N_wkdqr'    => '',                                             //尾款到期日
                        'O_sfcq'     => '',                                             //是否超期
                        'P_cwhxclyj' => '',                                             //财务后续处理意见
                        'Q_xsclfk'   => '',                                             //销售处理反馈
                        'R_zsdsl'    => '',                                             //总受订数量
                        'S_zxhsl'    => 0,                                              //总销货数量

                    ];
                    $excel_list[] = $item;
                    unset($item);
                }
                $list_hth                   = array_column($excel_list, 'A_hth');
                $data_orderData             = $this->mod_data->get(['A_hth' => ['$in' => $list_hth]]);
                //dump($data_orderData);
                $data_hth                   = array_column(iterator_to_array($data_orderData), 'A_hth');
                $insert_orderData           = [];
                $data_salespersonStatistics = [];
                $data_companyStatistics     = [];
                foreach ($excel_list as $item) {

                    //订单数据组合
                    if (!in_array($item['A_hth'], $data_hth)) {
                        $insert_orderData[] = $item;
                    } else {
                        $info    = $this->mod_data->getInfo(['A_hth' => $item['A_hth']]);
                        $E_zj    = $info['E_zj'] + $item['E_zj'];               //总价
                        $M_qkje  = $info['M_qkje'] + $item['M_qkje'];           //欠款金额
                        $R_zsdsl = $info['R_zsdsl'] + $item['R_zsdsl'];         //总销货数量
                        $this->mod_data->update(['E_zj' => $E_zj, 'M_qkje' => $M_qkje, 'R_zsdsl' => $R_zsdsl], $info['id']);
                        dump('orderCollectionUpdated');
                    }
                    //统计数据组合
                    $time   = date('Y-m', $item['B_htqyrq']);
                    $time_y = date('Y', $item['B_htqyrq']);

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
                //dump($insert_orderData);

                //写入订单信息
                if (!empty($insert_orderData)) {
                    //$this->mod_data->batchInsert($insert_orderData);
                    dump('orderInsert');
                }

                //写入销售统计信息
                $list_salespersonStatistics = [];
                foreach ($data_salespersonStatistics as $k => $v) {
                    foreach ($v as $key => $value) {
                        $info = $this->mod_salespersonStatistics->getInfo(['name' => $value['name'], 'time' => $value['time']]);
                        if (empty($info)) {
                            $list_salespersonStatistics[] = $value;
                        }
                        else {
                            $myContractVolume = $value['myContractVolume'] + $info['myContractVolume'];
                            $myReceivables    = $value['myReceivables'] + $info['myReceivables'];
                            $this->mod_salespersonStatistics->update([
                                'myContractVolume' => $myContractVolume,
                                'myReceivables'    => $myReceivables
                            ], [
                                'name' => $value['name'],
                                'time' => $value['time']
                            ]);
                            dump('saleStaticsUpdate');
                        }
                    }
                }
                //dump($list_salespersonStatistics);
                if (!empty($list_salespersonStatistics)) {
                    //$this->mod_salespersonStatistics->batchInsert($list_salespersonStatistics);
                    dump('saleStaticsInsert');
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
                        dump('companyStaticsUpdate');
                    }
                }
                if (!empty($list_companyStatistics)) {
                    //$this->mod_companyStatistics->batchInsert($list_companyStatistics);
                    dump('companyStatisticsInsert');
                }
                //dump($list_companyStatistics);
                //dump($data_companyStatistics);

                sleep(10);
            }
        }

    }
    public function getLog ()
    {

    }
}