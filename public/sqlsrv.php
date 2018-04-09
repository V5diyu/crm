<?php 

include_once('C:\xampp\htdocs\application\dbhelp\SalespersonReceiveDB.php');
include_once('C:\xampp\htdocs\application\dbhelp\OrderInfoDB.php');
include_once('C:\xampp\htdocs\application\dbhelp\OrderInfoDataDB.php');
include_once('C:\xampp\htdocs\application\dbhelp\SalespersonStatisticsDB.php');
include_once('C:\xampp\htdocs\application\dbhelp\CompanyStatisticsDB.php');
include_once('C:\xampp\htdocs\application\dbhelp\OrderPayDetailDb.php');
include_once('C:\xampp\htdocs\application\dbhelp\AutosynLogDb.php');

date_default_timezone_set("PRC");

$servern="localhost";
$coninfo=array("Database"=>"DB_TK01","UID"=>"sa","PWD"=>"SAsa123","CharacterSet"=>"utf-8");

/*$servern="47.104.133.136";
$coninfo=array("Database"=>"DB_TLU","UID"=>"sa","PWD"=>"SAsa123 ","CharacterSet"=>"utf-8");*/
$conn=sqlsrv_connect($servern,$coninfo) or die ("connect deny!");
if($conn){
	echo "OK ! HELLO SQL SERVER";
} else {
	echo "Connection could not be established.";
	die( print_r(sqlsrv_errors(), true)); 
}
//$mod                       = new OrderInfoDB();
$mod_data                  = new OrderInfoDataDB();
//$mod_salesperson           = new SalespersonDB();
$mod_autoSynLog            = new AutosynLogDb();
$mod_salespersonStatistics = new SalespersonStatisticsDB();
$mod_companyStatistics     = new CompanyStatisticsDB();
$mod_payDetail             = new OrderPayDetailDb();
$mod_personReceive         = new SalespersonReceiveDB();
//$mod_correctError          = new CorrectErrorDB();

$time_current = time();
$time_pre = time() - 60*30;

//间隔时间
$str_current = date('Y-m-d H:i:s',$time_current);
$str_pre = date('Y-m-d H:i:s',$time_pre);
//var_dump($str_current);
$ret_1 = [];
$pay_detail = [];
$data_log = [];
$sale_man_arr = [];
$company_arr = [];
$pay_detail_arr = [];
$sale_receive_arr = [];

$sql_1 = "select p.cus_os_no as contract,c.NAME as customer,(select sum(tp.AMT) from TF_POS tp where tp.CUS_OS_NO = p.CUS_OS_NO and tp.os_id = 'SO') as totalprice, (select sum(tp.AMT) from TF_POS tp where tp.CUS_OS_NO = p.CUS_OS_NO and tp.os_id = 'SR') as returnprice,min(s.Name) as salesman, min(p.OS_DD) as orderdate   from MF_POS p left join CUST c on p.cus_no =c.cus_no  left join SALM s on s.sal_no = p.sal_no  where ((p.OS_DD >='" . $str_pre . "' AND p.OS_DD<'" . $str_current. "') or (p.Modify_dd >='". $str_pre ."' AND p.Modify_dd<'" . $str_current . "') or (p.sys_date >='". $str_pre ."' AND p.sys_date<'" . $str_current . "')) and (p.os_id = 'SO' or p.os_id = 'SR') and p.cus_os_no is not null and p.cus_os_no<>'' and substring(p.SAL_NO,1,1) ='2' GROUP by p.cus_os_no,c.NAME";

$sql_2 = "SET ANSI_WARNINGS OFF;SET ARITHIGNORE ON;SET ARITHABORT OFF;select p.cus_os_no as contract, (select SUM(ts.AMT) from TF_PSS ts where ts.cus_os_no = p.cus_os_no and ts.ps_id = 'SA') as delivergoods, ((select SUM(ts.AMT) from TF_PSS ts where ts.cus_os_no = p.cus_os_no and ts.ps_id = 'SA')/(select SUM(tp.AMT) from TF_POS tp where tp.cus_os_no = p.cus_os_no and tp.os_id = 'SO')) as delivery, ((select SUM(ts.AMT) from TF_PSS ts where ts.cus_os_no = p.cus_os_no and ts.ps_id = 'SB')/(select SUM(tp.AMT) from TF_POS tp where tp.cus_os_no = p.cus_os_no and tp.os_id = 'SO')) as returned,   max(p.ps_dd) as deliverydate from MF_PSS p where  ((p.ps_dd >='". $str_pre ."' AND p.ps_dd<'". $str_current ."') or (p.Modify_dd >='". $str_pre ."' AND p.Modify_dd<'". $str_current ."') or (p.sys_date >='". $str_pre ."' AND p.sys_date<'". $str_current ."')) and p.cus_os_no is not null and substring(p.SAL_NO,1,1) ='2' and p.cus_os_no <>'' group by p.cus_os_no";

$sql_3 = "select tm.CAS_NO  as contract, (select sum(ts.amtn_bb) from  TF_MON ts WHERE ts.cas_no = tm.cas_no) as paid  from  TF_MON tm  where ((tm.rp_DD >='" . $str_pre ."' AND tm.rp_DD<'". $str_current ."') or (tm.Modify_dd >='". $str_pre ."' AND tm.Modify_dd<'" . $str_current . "')  or (tm.sys_date >='". $str_pre ."' AND tm.sys_date<'" . $str_current . "')) and tm.CAS_NO is not null and tm.CAS_NO <>'' and tm.RP_ID =1 group by tm.CAS_NO";

//$sql_4 = "select p.cus_os_no as contract, ml.AMT as paid, tl.AMT as payment  from MF_POS p left join MF_LZ ml on ml.CAS_NO = p.cus_os_no left join TF_LZ tl on tl.cus_os_no = p.cus_os_no where p.OS_DD >='2017-12-01 00:00:00' AND p.OS_DD<'2018-01-01 00:00:00' and p.cus_os_no is not null order by p.cus_os_no, ml.AMT desc";
//$sql_pay_detail = "select tm.CAS_NO  as contract, tm.amtn_bb as payment, tm.RP_DD as paydate, tm.rp_no as payno  from  TF_MON tm  where ((tm.rp_DD >='" . $str_pre ."' AND tm.rp_DD<'". $str_current ."') or (tm.Modify_dd >='". $str_pre ."' AND tm.Modify_dd<'" . $str_current . "') or (tm.sys_date >='". $str_pre ."' AND tm.sys_date<'" . $str_current . "')) and tm.CAS_NO is not null and tm.CAS_NO <>'' and tm.RP_ID =1";
$sql_pay_detail = "select min(tm.CAS_NO)  as contract, min(tm.amtn_bb) as payment, min(tm.RP_DD) as paydate, min(tm.rp_no) as payno, min(s.Name) as salesman from  TF_MON tm left join MF_POS p on p.cus_os_no = tm.CAS_NO left join SALM s on s.sal_no = p.sal_no where ((tm.rp_DD >='". $str_pre ."' AND tm.rp_DD<'" . $str_current . "') or (tm.Modify_dd >='". $str_pre ."' AND tm.Modify_dd<'" . $str_current . "') or (tm.sys_date >='". $str_pre ."' AND tm.sys_date<'" . $str_current . "')) and tm.CAS_NO is not null and tm.CAS_NO <>'' and tm.RP_ID =1 group by tm.CAS_NO, tm.rp_no";

$stmt = sqlsrv_query($conn,$sql_1);
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
    //var_dump($row);
    $ret_1[$row['contract']]['contract'] = $row['contract'];
    $ret_1[$row['contract']]['customer'] = $row['customer'];
    $ret_1[$row['contract']]['salesman'] = $row['salesman'];
    $ret_1[$row['contract']]['totalprice'] = empty($row['totalprice']) ? 0 : round($row['totalprice'],2);//umber_format($row['totalprice'],2,".","");
    $ret_1[$row['contract']]['returnprice'] = empty($row['returnprice']) ? 0 : round($row['returnprice'],2);//number_format($row['returnprice'],2,".","");
    $arr = (array)$row['orderdate'];
    $ret_1[$row['contract']]['contractTime']  = $arr['date'];
    unset($arr);
    unset($row);
}
$stmt = sqlsrv_query($conn,$sql_2);
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
    //$ret_1[$row['contract']]['delivery'] = number_format($row['delivery'],2,".","");
    $ret_1[$row['contract']]['contract'] = $row['contract'];
    $ret_1[$row['contract']]['delivery'] = empty($row['delivery']) ? 0 : round($row['delivery'],2);
    $ret_1[$row['contract']]['returned'] = empty($row['returned']) ? 0 : round($row['returned'],2);
    $ret_1[$row['contract']]['delivergoods'] = empty($row['delivergoods']) ? 0 : round($row['delivergoods'],2);
    $arr_2 = (array)$row['deliverydate'];

    $ret_1[$row['contract']]['deliverydate'] = $arr_2['date'];
    $ret_1[$row['contract']]['overdate']     = strtotime($arr_2['date'] . ' +3 month');
    unset($row);
}
$stmt = sqlsrv_query($conn,$sql_3);
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
    $ret_1[$row['contract']]['contract'] = $row['contract'];
    $ret_1[$row['contract']]['paid1'] = number_format($row['paid'],2,".","");
    unset($row);
}
//var_dump($ret_1);
$stmt = sqlsrv_query($conn,$sql_pay_detail);
while ($row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)) {
    $id_pay = getUuid();
    $pay_detail[$id_pay]['id'] = getUuid();
    $pay_detail[$id_pay]['contract'] = $row['contract'];
    $pay_detail[$id_pay]['payment'] = empty($row['payment']) ? 0 : (round($row['payment']));
    $pay_detail[$id_pay]['paydate'] = $row['paydate'];
    $pay_detail[$id_pay]['payno']   = $row['payno'];
    $pay_detail[$id_pay]['name']    = $row['salesman'];

    $pay_date_arr = (array)$row['paydate'];

    /*if (empty($pay_date_arr['date'])) {
    	var_dump($$row['paydate']);
    	break;	
    }*/

    $pay_time_y = date('Y',strtotime($pay_date_arr['date']));
    $pay_time_m = date('Y-m',strtotime($pay_date_arr['date']));
    $pay_detail[$id_pay]['time_y'] = $pay_time_y;
    $pay_detail[$id_pay]['time_m'] = $pay_time_m;

    //更新日志数据-----------订单付款明细的同步信息
    /*$id = getUuid();
    $data_log[$id]['id'] = $id;
    $data_log[$id]['syn_timestamp'] = $time_current;
    //$data_log[$id_unique]['db_name'] = 'orderinfo_data';
    $data_log[$id]['syn_field'] = (string)json_encode(['合同号'=>$row['contract'],'付款金额'=>(empty($row['payment']) ? 0 : (round($row['payment'],2)))],JSON_UNESCAPED_UNICODE);
    $data_log[$id]['syn_cont'] = '付款明细';
    $data_log[$id]['flag'] = $row['contract'];
    $data_log[$id]['type'] = '1';*/

    unset($row);
}

if (!empty($pay_detail)) {

    $list_payno                 = array_column($pay_detail, 'payno');
    $data_payDetail             = $mod_payDetail->get(['payno' => ['$in' => $list_payno]]);
    $data_payno                 = array_column(iterator_to_array($data_payDetail), 'payno');
    /*$insert_orderData           = [];*/

    foreach ( $pay_detail as $pay_key => $pay_value ) {

        if (empty($pay_value['contract'])) {
            continue;
        }

        $month_person = $pay_value['time_m'] . '=' . $pay_value['name'];
        if (!in_array($month_person,$sale_receive_arr)) {
            $sale_receive_arr[] = $month_person;
        }

        if (!in_array($pay_value['payno'],$data_payno)) {
            $pay_detail_arr[] = $pay_value;

            //订单明细，同步日志记录
            $id         = getUuid();
            $data_log[$id]['id']            = $id;
            $data_log[$id]['syn_timestamp'] = $time_current;
            $data_log[$id]['syn_field']     = (string)json_encode(['订单号'=>$pay_value['contract'],'付款金额'=>(empty($pay_value) ? 0 : (round($pay_value['payment'],2))),'付款单号'=>$pay_value['payno']],JSON_UNESCAPED_UNICODE);
            $data_log[$id]['syn_cont']      = '付款明细';
            $data_log[$id]['flag']          = $pay_value['contract'];
            $data_log[$id]['type']          = '1';

        } else {
            $info       = $mod_payDetail->getInfo(['payno' => $pay_value['payno']]);

            $contract   = $pay_value['contract'];
            $payment    = $pay_value['payment'];
            $paydate    = $pay_value['paydate'];
            $payno      = $pay_value['payno'];
            $name       = $pay_value['name'];
            $time_m     = $pay_value['time_m'];

            //付款明细更新
            $mod_payDetail->update([
                'contract'  => $contract,
                'payment'   => $payment, 
                'paydate'   => $paydate, 
                'payno'     => $payno,
                'name'      => $name,
                'time_m'    => $time_m,
            ], $info['id']);

            //付款明细，更新日志数据记录
            $id         = getUuid();
            $data_log[$id]['id']            = $id;
            $data_log[$id]['syn_timestamp'] = $time_current;
            $data_log[$id]['syn_field']     = (string)json_encode(['订单号'=>$pay_value['contract'],'付款金额'=>(empty($pay_value) ? 0 : (round($pay_value['payment'],2))),'付款单号'=>$pay_value['payno']],JSON_UNESCAPED_UNICODE);
            $data_log[$id]['syn_cont']      = '付款明细';
            $data_log[$id]['flag']          = $pay_value['contract'];
            $data_log[$id]['type']          = '2';

        }

    }
}


if (!empty($ret_1)) {
    foreach ($ret_1 as $k => $v) {
        //var_dump($v);
        if (empty($v['contract'])) {
             //var_dump($k);
             continue;
        }

        //$original_data = iterator_to_array($mod_data->get(['A_hth'=>$v['contract']]));
        $original_data = iterator_to_array($mod_data->get(['A_hth'=>['$regex' => $v['contract']]]));

        $item         = [
            'id'         => getUuid(),
            'A_hth'      => strEmptyChange($v['contract']),                 //合同号
            'B_htqyrq'   => isset($v['contractTime']) ? strtotime(strEmptychange($v['contractTime'])) : $original_data[0]['B_htqyrq'] ,  //合同签约日期
            'C_ssxm'     => '',                                             //所属项目
            'D_khdw'     => isset($v['customer']) ? strEmptyChange(trim($v['customer'])) : $original_data[0]['D_khdw'],                                     //客户单位
            'E_zj'       => isset($v['totalprice']) ? strEmptyFloat($v['totalprice']-$v['returnprice']) : $original_data[0]['E_zj'],                                    //总价
            'F_xsry'     => isset($v['salesman']) ? strEmptyChange(trim($v['salesman'])) : $original_data[0]['F_xsry'],                                     //销售人员
            'G_fh'       => isset($v['delivery']) ? (empty($v['delivery'])?'未发货' : '已发货') : (empty($original_data[0]['G_fh']) ? '' : $original_data[0]['G_fh']),                                  //发货
            'H_fhbl'     => isset($v['delivery']) ? (strEmptyFloat($v['delivery']) * 100) : (empty($original_data[0]['H_fhbl']) ? 0 : $original_data[0]['H_fhbl']),                                    //发货比例
            'I_fp'       => '',                                                                 //发票
            'J_fkje'     => isset($v['paid1']) ? (empty($v['paid1']) ? 0: strEmptyFloat($v['paid1'])) : $original_data[0]['J_fkje'],                    //付款金额
            'K_fkbl'     => isset($v['totalprice']) ? (isset($v['paid1']) ? (round(strEmptyFloat($v['paid1']) / strEmptyFloat($v['totalprice']), 3) * 100 ) : (empty($original_data[0]['J_fkje']) ? 0 : (round($original_data[0]['J_fkje'] / strEmptyFloat($v['totalprice']),3) * 100))) : (isset($v['paid1'] ) ? (round(strEmptyFloat($v['paid1']) / $original_data[0]['E_zj'],3) * 100) : ($original_data[0]['K_fkbl'])),         //付款比例       
            'L_fkxq'     => isset($v['L_fkxq']) ? $v['L_fkxq'] : (empty($original_data[0]['L_fkxq']) ? '' : $original_data[0]['L_fkxq'] ),                                                               //付款详情
            //'M_qkje'     => (isset($v['totalprice'])) ? (strEmptyFloat($v['totalprice'])-$v['returnprice'] - (empty($v['paid1']) ? 0: strEmptyFloat($v['paid1']))) : $original_data[0]['M_qkje'],         //欠款金额
            'M_qkje'     => isset($v['totalprice']) ? (  isset($v['paid1']) ? ( $v['totalprice'] - (empty($v['returnprice']) ? 0 : $v['returnprice']) - (empty($v['paid1']) ? 0 : $v['paid1']) ) : (  $v['totalprice'] - $v['returnprice']) ) : ( isset($v['paid1']) ? ($original_data[0]['E_zj'] - $v['paid1']) : ($original_data[0]['M_qkje']) ) ,   //欠款金额
            'N_wkdqr'    => (isset($v['delivery']) && $v['delivery'] == 1 ) ? $v['overdate'] : '',                       //尾款到期日
            'O_sfcq'     => (isset($v['delivery']) && $v['delivery'] == 1 && $v['overdate'] >= time()) ? '是' : '否' ,   //是否超期
            'P_cwhxclyj' => '',                                             //财务后续处理意见
            'Q_xsclfk'   => '',                                             //销售处理反馈
            'R_zsdsl'    => '',                                             //总受订数量
            'S_zxhsl'    => 0,                                              //总销货数量
            'company'    => 'TK01'                                          //company

        ];
        $excel_list[] = $item;

        $year_mon = date('Y-m',$item['B_htqyrq']);
        $year = date('Y',$item['B_htqyrq']);
        $date_saleman = $year_mon . '=' .strEmptyChange(trim($item['F_xsry']));
        if (array_key_exists($year_mon, $company_arr)) {
            /*$company_arr[$year_mon] += strEmptyFloat($v['totalprice']);*/
        } else {
            $company_arr[$year_mon] = $year_mon;
            /*$company_arr[$year_mon] = strEmptyFloat($v['totalprice']);*/
        }
        if (array_key_exists($date_saleman,$sale_man_arr)) {

        } else {
            $sale_man_arr[$date_saleman] = $date_saleman;
        }

        unset($item);
    }

    $list_hth                   = array_column($excel_list, 'A_hth');
    $data_orderData             = $mod_data->get(['A_hth' => ['$in' => $list_hth]]);
    $data_hth                   = array_column(iterator_to_array($data_orderData), 'A_hth');
    $insert_orderData           = [];
    $data_salespersonStatistics = [];
    $data_companyStatistics     = [];
    //$data_log = [];
    $id_unique = '';

    foreach ($excel_list as $item) {
        //订单数据组合
        if (!in_array($item['A_hth'], $data_hth)) {
            $insert_orderData[] = $item;

            //更新日志数据组合
            $id_unique = getUuid();
            $data_log[$id_unique]['id'] = $id_unique;
            $data_log[$id_unique]['syn_timestamp'] = $time_current;
            //$data_log[$id_unique]['db_name'] = 'orderinfo_data';
            $data_log[$id_unique]['syn_field'] = (string)json_encode(['总金额'=>$item['E_zj'],'发货比例'=>$item['H_fhbl'] ."%",'付款金额'=>$item['J_fkje'],'付款比例'=>$item['K_fkbl'] . "%"],JSON_UNESCAPED_UNICODE);
            $data_log[$id_unique]['syn_cont'] = '订单数据';
            $data_log[$id_unique]['flag'] = $item['A_hth'];
            $data_log[$id_unique]['type'] = '1';

        } else {
            $info    = $mod_data->getInfo(['A_hth' => $item['A_hth']]);
            //$E_zj    = $info['E_zj'] + $item['E_zj'];                 //总价
            //$M_qkje  = $info['M_qkje'] + $item['M_qkje'];             //欠款金额
            //$R_zsdsl = $info['R_zsdsl'] + $item['R_zsdsl'];           //总销货数量

            $D_khdw  = $item['D_khdw'];                                 //客户单位
            $E_zj    = $item['E_zj'];                                   //总价
            $F_xsry  = $item['F_xsry'];                                 //销售人员
            $G_fh    = $item['G_fh'];                                   //发货
            $H_fhbl  = $item['H_fhbl'];                                 //发货比例
            $J_fkje  = $item['J_fkje'];                                 //付款金额
            $K_fkbl  = $item['K_fkbl'];                                 //付款比例
            $M_qkje  = $item['M_qkje'];                                 //欠款金额
            $N_wkdqr = $item['N_wkdqr'];                                //尾款到期日
            $O_sfcq  = $item['O_sfcq'];                                 //是否超期


            $mod_data->update([
                'D_khdw'    =>$D_khdw,
                'E_zj'      => $E_zj,
                'F_xsry'    =>$F_xsry, 
                'G_fh'      => $G_fh,
                'H_fhbl'    =>$H_fhbl,
                'J_fkje'    => $J_fkje,
                'K_fkbl'    => $K_fkbl, 
                'M_qkje'    => $M_qkje, 
                'N_wkdqr'   => $N_wkdqr,
                'O_sfcq'    => $O_sfcq
            ], $info['id']);
            //更新日志数据
            $id_unique = getUuid();
            $data_log[$id_unique]['id'] = $id_unique;
            $data_log[$id_unique]['syn_timestamp'] = $time_current;
            //$data_log[$id_unique]['db_name'] = 'orderinfo_data';
            $data_log[$id_unique]['syn_field'] = (string)json_encode(['总金额'=>$item['E_zj'],'发货比例'=>$item['H_fhbl']  . "%",'付款金额'=>$item['J_fkje'],'付款比例'=>$item['K_fkbl'] . "%"],JSON_UNESCAPED_UNICODE);
            $data_log[$id_unique]['syn_cont'] = '订单数据';
            $data_log[$id_unique]['flag'] = $item['A_hth'];
            $data_log[$id_unique]['type'] = '2';
        }

    }

}

//写入订单信息
if (!empty($insert_orderData)) {
    $mod_data->batchInsert($insert_orderData);
}

//写入付款明细
if (!empty($pay_detail_arr)) {
    $mod_payDetail->batchInsert($pay_detail_arr);
}

//写入自动更新日志
if (!empty($data_log)) {
    //$mod_autoSynLog->batchInsert($data_log);
    echo "autoSynLog";
}

//



$salesman_statistics = [];
$company_statistics = [];
$list_companyStatistics = [];
$list_personStatistics = [];
$list_personReceive    = [];

//公司统计数据组合(避免重复记录)
if (!empty($company_arr)) {
    foreach ($company_arr as $key_company => $value_company) {
        $time_start     = strtotime($key_company);
        $time_end       = strtotime("$key_company +1 month -1 second");
        $mod_companyStatistics->delete(['time'=> $value_company]);
        $info = iterator_to_array($mod_data->get(['B_htqyrq' => ['$gte' => $time_start, '$lte' => $time_end] ]));

        $list_companyStatistics[$key_company]['time'] = $value_company;
        $list_companyStatistics[$key_company]['companyContractVolume'] = array_sum(array_column($info, "E_zj"));
    }
}

//销售月份回款统计
if (!empty($sale_receive_arr)) {
    foreach ( $sale_receive_arr as $receive_key => $receive_value) { 
        $arr_explode = explode('=',$receive_value);
        $sale_man = $arr_explode[1];
        $time_m   = $arr_explode[0];
        $time_y   = date('Y',strtotime($time_m));
        $mod_personReceive->delete(['name'=>$sale_man,'time'=>$time_m]);
        $info = iterator_to_array($mod_payDetail->get(['time_m'=>$time_m,'name'=> $sale_man]));

        $list_personReceive[$receive_key]['time']       = $time_m;
        $list_personReceive[$receive_key]['name']       = $sale_man;
        $list_personReceive[$receive_key]['time_y']     = $time_y;
        $list_personReceive[$receive_key]['receive']    = array_sum(array_column($info,"payment"));

    }
}


//销售统计数据组合(避免重复记录)
if (!empty($sale_man_arr)) {
    foreach ($sale_man_arr as $key_person => $value_person) {
        $arr_explode = explode('=',$value_person);
        $sale_man    = $arr_explode[1];
        $time_start  = strtotime($arr_explode[0]);
        $time_end    = strtotime("$arr_explode[0] +1 month -1 second");
        $time_y      = date('Y',$time_start);
        //
        $mod_salespersonStatistics->delete(['name'=> $sale_man, 'time'=> $arr_explode[0]]);
        $info = iterator_to_array($mod_data->get(['B_htqyrq' => ['$gte' => $time_start, '$lte' => $time_end], 'F_xsry' => $sale_man]));

        $list_personStatistics[$key_person]['name']     = $sale_man;
        $list_personStatistics[$key_person]['time']     = $arr_explode[0];
        $list_personStatistics[$key_person]['time_y']   = $time_y;
        $list_personStatistics[$key_person]['myContractVolume'] = array_sum(array_column($info,'E_zj'));
        $list_personStatistics[$key_person]['myReturnAmount']  = array_sum(array_column($info,'J_fkje'));
        $list_personStatistics[$key_person]['myReceivables']   = array_sum(array_column($info,'M_qkje'));
        
    }
}

//写入公司统计数据
if (!empty($list_companyStatistics)) {
    $mod_companyStatistics->batchInsert($list_companyStatistics);
}

//写入销售统计数据
if (!empty($list_personStatistics)) {
    $mod_salespersonStatistics->batchInsert($list_personStatistics);
}


//写入销售月回款统计
if (!empty($list_personReceive)) {
    $mod_personReceive->batchInsert($list_personReceive);
}



$salesman_statistics = [];
$company_statistics = [];


/*if (!empty($excel_list)) {
    foreach ($excel_list as $key =>  $item) {
    //销售信息数据重新写入
        $salesman = $item['F_xsry'];
        $date_time = date('Y-m-d H:i:s',$item['B_htqyrq']);
        $date_month = date('Y-m',$item['B_htqyrq']);
        $date_year = date('Y',$item['B_htqyrq']);
        $timestamp_s = strtotime($date_month . '-01 00:00:00');
        $date_start = date('Y-m-d',$timestamp_s);
        $timestamp_e = strtotime(" $date_start +1 month -1 second");

        //下面逻辑需要修改，取出来的是月份的订单的数据，个人的统计信息需要删掉重新添加
        $info_order_statistics = $mod_data->get(['F_xsry'=>$salesman,'B_htqyrq'=>['$gte'=>$timestamp_s,'$lte'=>$timestamp_e]]);
        //var_dump($info_order_statistics);

        foreach ($info_order_statistics as $key_order => $order) {
            if (empty($salesman_statistics[$key][$salesman])) {

            } else {

            }
        }
        //公司总统计信息数据重新写入

    }
}*/







function mdb ()
{
    $config = [
        'host'     => '127.0.0.1',
        'prot'     => '27017',
        'dbname'   => 'dingding',
        'username' => 'root',
        'password' => 'yelangying'
    ];
    $host     = $config['host'];
    $port     = $config['prot'];
    $dbname   = $config['dbname'];
    $username = $config['username'];
    $password = $config['password'];
    //$mongo    = new MongoClient('mongodb://' . $username . ':' . $password . '@' . $host . ':' . $port . '/admin');
    $mongo    = new MongoClient();
    return $mongo->selectDB($dbname);
}

function getUuid()
{
    mt_srand(( double )microtime() * 10000);
    $charid = strtoupper(md5(uniqid(rand(), true)));
    $hyphen = chr(45);
    $uuid   = substr($charid, 0, 8) . $hyphen . substr($charid, 8, 4) . $hyphen . substr($charid, 12, 4) . $hyphen . substr($charid, 16, 4) . $hyphen . substr($charid, 20, 12);
    return $uuid;
}
function strEmptyChange($str)
{
    if (empty($str)) {
        return '';
    }
    return $str;
}

function strEmptyFloat($str)
{
    if (empty($str)) {
        return 0;
    }
    return floatval($str);
}

//!!!!!!!!!!!!!!!!!!!!!!!!!!!释放资源,  销毁数组， 清除内存 !!!!!!!!!!!!!!!!!!!!!!!


//测试脚本是否执行
sqlsrv_close($conn);
$str = file_get_contents("C:\\xampp\\htdocs\\public\\test.txt");
$str .= "\tTK" . $str_current  . "\n" ;
file_put_contents("C:\\xampp\\htdocs\\public\\test.txt",$str);
