<?php 

include_once('E:\xampp\htdocs\application\dbhelp\OrderInfoDB.php');
include_once('E:\xampp\htdocs\application\dbhelp\OrderInfoDataDB.php');
include_once('E:\xampp\htdocs\application\dbhelp\SalespersonStatisticsDB.php');
include_once('E:\xampp\htdocs\application\dbhelp\CompanyStatisticsDB.php');
include_once('E:\xampp\htdocs\application\dbhelp\OrderPayDetailDb.php');
include_once('E:\xampp\htdocs\application\dbhelp\AutosynLogDb.php');

date_default_timezone_set("PRC");

$servern="localhost";
$coninfo=array("Database"=>"DB_TK","UID"=>"sa","PWD"=>"123qwe123","CharacterSet"=>"utf-8");
/*coninfo=array("Database"=>"DB_TK01","UID"=>"sa","PWD"=>"SAsa123","CharacterSet"=>"utf-8");*/
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
//$mod_correctError          = new CorrectErrorDB();

$time_current = time();
$time_pre = time() - 60*5;

//间隔时间
$str_current = date('Y-m-d H:i:s',$time_current);
$str_pre = date('Y-m-d H:i:s',$time_pre);
//var_dump($str_current);
$ret_1 = [];
$pay_detail = [];
$data_log = [];
$sale_man_arr = [];
$company_arr = [];

$sql_1 = "select p.cus_os_no as contract,c.NAME as customer,SUM(tp.AMT) as totalprice, min(s.Name) as salesman, min(p.OS_DD) as orderdate   from MF_POS p left join CUST c on p.cus_no =c.cus_no left join TF_POS tp on tp.os_no = p.os_no and tp.os_id = 'SO' left join SALM s on s.sal_no = p.sal_no where ((p.OS_DD >='2016-09-01 00:00:00' AND p.OS_DD<'2018-03-01 00:00:00') or (p.Modify_dd >='2016-09-01 00:00:00' AND p.Modify_dd<'2018-03-01 00:00:00')) and p.cus_os_no is not null GROUP BY p.cus_os_no,c.NAME";

$sql_2 = "SET ANSI_WARNINGS OFF;SET ARITHIGNORE ON;SET ARITHABORT OFF;select p.cus_os_no as contract, ((select SUM(ts.AMT) from TF_PSS ts where ts.cus_os_no = p.cus_os_no and ts.ps_id = 'SA')/(select SUM(tp.AMT) from TF_POS tp where tp.cus_os_no = p.cus_os_no and tp.os_id = 'SO')) as delivery, ((select SUM(ts.AMT) from TF_PSS ts where ts.cus_os_no = p.cus_os_no and ts.ps_id = 'SB')/(select SUM(tp.AMT) from TF_POS tp where tp.cus_os_no = p.cus_os_no and tp.os_id = 'SO')) as returned,   max(p.ps_dd) as deliverydate from MF_PSS p where  ((p.ps_dd >='2016-09-01 00:00:00' AND p.ps_dd<'2018-03-01 00:00:00') or (p.Modify_dd >='2016-09-01 00:00:00' AND p.Modify_dd<'2018-03-01 00:00:00')) and p.cus_os_no is not null and p.cus_os_no <>'' group by p.cus_os_no";

$sql_3 = "select tm.CAS_NO  as contract, sum(tm.amtn_bb) as paid  from  TF_MON tm  where ((tm.rp_DD >='2016-09-01 00:00:00' AND tm.rp_DD<'2018-03-01 00:00:00') or (tm.Modify_dd >='2016-09-01 00:00:00' AND tm.Modify_dd<'2018-03-01 00:00:00')) and tm.CAS_NO is not null and tm.CAS_NO <>'' and tm.RP_ID =1 group by tm.CAS_NO";

//$sql_4 = "select p.cus_os_no as contract, ml.AMT as paid, tl.AMT as payment  from MF_POS p left join MF_LZ ml on ml.CAS_NO = p.cus_os_no left join TF_LZ tl on tl.cus_os_no = p.cus_os_no where p.OS_DD >='2017-12-01 00:00:00' AND p.OS_DD<'2018-01-01 00:00:00' and p.cus_os_no is not null order by p.cus_os_no, ml.AMT desc";
$sql_pay_detail = "select tm.CAS_NO  as contract, tm.amtn_bb as payment, tm.RP_DD as paydate  from  TF_MON tm  where ((tm.rp_DD >='2016-09-01 00:00:00' AND tm.rp_DD<'2018-03-01 00:00:00') or (tm.Modify_dd >='2016-09-01 00:00:00' AND tm.Modify_dd<'2018-03-01 00:00:00')) and tm.CAS_NO is not null and tm.CAS_NO <>'' and tm.RP_ID =1";


$stmt = sqlsrv_query($conn,$sql_1);
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
    //var_dump($row);
    $ret_1[$row['contract']]['contract'] = $row['contract'];
    $ret_1[$row['contract']]['customer'] = $row['customer'];
    $ret_1[$row['contract']]['salesman'] = $row['salesman'];
    $ret_1[$row['contract']]['totalprice'] = number_format($row['totalprice'],2,".","");
    $arr = (array)$row['orderdate'];
    $ret_1[$row['contract']]['contractTime']  = $arr['date'];
    unset($arr);
    unset($row);
}
$stmt = sqlsrv_query($conn,$sql_2);


$test_arr = [];
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
   /* $ret_1[$row['contract']]['delivery'] = number_format($row['delivery'],2,".","");*/
    $ret_1[$row['contract']]['delivery'] = empty($row['delivery']) ? 0 : round($row['delivery'],2);
    $ret_1[$row['contract']]['returned'] = empty($row['returned']) ? 0 : round($row['returned'],2);
    /*if ($row['contract'] == 'TLU2017120431') {
        echo $row['delivery'] . "<br >";
        echo $ret_1[$row['contract']]['delivery'];
    }
    $test_arr[] = $row;*/
    unset($row);
}
$stmt = sqlsrv_query($conn,$sql_3);
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
    $ret_1[$row['contract']]['paid1'] = number_format($row['paid'],2,".","");
    unset($row);
}
//var_dump($ret_1);
$stmt = sqlsrv_query($conn,$sql_pay_detail);
while ($row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)) {
    $id_pay = getUuid();
    $pay_detail[$id_pay]['id'] = getUuid();
    $pay_detail[$id_pay]['contract'] = $row['contract'];
    $pay_detail[$id_pay]['payment'] = empty($row['payment']) ? 0 : (round($row['payment'],2));
    $pay_detail[$id_pay]['paydate'] = $row['paydate'];


    //更新日志数据-----------订单付款明细的同步信息
    $id = getUuid();
    $data_log[$id]['id'] = $id;
    $data_log[$id]['syn_timestamp'] = $time_current;
    //$data_log[$id_unique]['db_name'] = 'orderinfo_data';
    $data_log[$id]['syn_field'] = (string)json_encode(['订单号'=>$row['contract'],'付款金额'=>(empty($row['payment']) ? 0 : (round($row['payment'],2)))],JSON_UNESCAPED_UNICODE);
    $data_log[$id]['syn_cont'] = '付款明细';
    $data_log[$id]['flag'] = $row['contract'];
    $data_log[$id]['type'] = '1';
    //$data_log[$id]['sale_man'] =
    unset($row);
}
//var_dump($ret_1);
//var_dump($sql_1);
//exit();
/*if (!empty($pay_detail)) {
    foreach ($pay_detail as $key_detail => $value_detail) {
        //更新日志数据-----------订单付款明细的同步信息
        $id = getUuid();
        $data_log[$id]['id'] = $id;
        $data_log[$id_unique]['syn_timestamp'] = $time_current;
        //$data_log[$id_unique]['db_name'] = 'orderinfo_data';
        $data_log[$id_unique]['syn_field'] = (string)json_encode(['contract'=>$value_detail['contract'],'payment'=>$value_detail['payment']],JSON_UNESCAPED_UNICODE);
        $data_log[$id_unique]['syn_cont'] = '付款明细';
        $data_log[$id_unique]['flag'] = $value_detail['contract'];
        $data_log[$id_unique]['type'] = '1';
    }
}*/
if (!empty($ret_1)) {
    foreach ($ret_1 as $k => $v) {
        //var_dump($v);
        if (empty($v['contract'])) {
             //var_dump($k);
             continue;
        }
        $returned = empty($v['returned'])? 0:strEmptyFloat($v['returned']);

        $item         = [
            'id'         => getUuid(),
            'A_hth'      => strEmptyChange($v['contract']),                 //合同号
            'B_htqyrq'   => strtotime(strEmptychange($v['contractTime'])),  //合同签约日期
            'C_ssxm'     => '',                                             //所属项目
            'D_khdw'     => strEmptyChange(trim($v['customer'])),           //客户单位
            'E_zj'       => strEmptyFloat($v['totalprice']),                //总价
            'F_xsry'     => strEmptyChange(trim($v['salesman'])),           //销售人员
            'G_fh'       => empty($v['delivery'])?'未发货' : '已发货',                                       //发货
            'H_fhbl'     => empty($v['delivery'])? 0:strEmptyFloat($v['delivery']-$returned) * 100,       //发货比例
            'I_fp'       => '',                                                                 //发票
            'J_fkje'     => empty($v['paid1']) ? 0: strEmptyFloat($v['paid1']),                 //付款金额
            'K_fkbl'     => round((empty($v['paid1']) ? 0: strEmptyFloat($v['paid1']) / strEmptyFloat($v['totalprice'])),3) * 100 ,         //付款比例
            'L_fkxq'     => '',                                                                                             //付款详情
            'M_qkje'     => strEmptyFloat($v['totalprice']) - (empty($v['paid1']) ? 0: strEmptyFloat($v['paid1'])),         //欠款金额
            'N_wkdqr'    => '',                                             //尾款到期日
            'O_sfcq'     => '',                                             //是否超期
            'P_cwhxclyj' => '',                                             //财务后续处理意见
            'Q_xsclfk'   => '',                                             //销售处理反馈
            'R_zsdsl'    => '',                                             //总受订数量
            'S_zxhsl'    => 0,                                              //总销货数量

        ];
        $excel_list[] = $item;

        $year_mon = date('Y-m',strtotime($v['contractTime']));
        $year = date('Y',strtotime($v['contractTime']));
        $date_saleman = $year_mon . '=' .strEmptyChange(trim($v['salesman']));
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
            $data_log[$id_unique]['syn_field'] = (string)json_encode(['总金额'=>$item['E_zj'],'发货比例'=>$item['H_fhbl'] . "%",'付款金额'=>$item['J_fkje'],'付款比例'=>$item['K_fkbl'] . "%"],JSON_UNESCAPED_UNICODE);
            $data_log[$id_unique]['syn_cont'] = '订单数据';
            $data_log[$id_unique]['flag'] = $item['A_hth'];
            $data_log[$id_unique]['type'] = '1';

        } else {
            $info    = $mod_data->getInfo(['A_hth' => $item['A_hth']]);
            //$E_zj    = $info['E_zj'] + $item['E_zj'];                 //总价
            //$M_qkje  = $info['M_qkje'] + $item['M_qkje'];             //欠款金额
            //$R_zsdsl = $info['R_zsdsl'] + $item['R_zsdsl'];           //总销货数量

            $E_zj    = $item['E_zj'];                                   //总价
            $J_fkje  = $item['J_fkje'];                                 //付款金额
            $D_khdw  = $item['D_khdw'];                                 //客户单位
            $F_xsry  = $item['F_xsry'];                                 //销售人员
            $mod_data->update(['E_zj' => $E_zj,'D_khdw'=>$D_khdw,'F_xsry'=>$F_xsry, 'J_fkje' => $J_fkje],$info['id']);

            //更新日志数据
            $id_unique = getUuid();
            $data_log[$id_unique]['id'] = $id_unique;
            $data_log[$id_unique]['syn_timestamp'] = $time_current;
            //$data_log[$id_unique]['db_name'] = 'orderinfo_data';
            $data_log[$id_unique]['syn_field'] = (string)json_encode(['总金额'=>$item['E_zj'],'发货比例'=>$item['H_fhbl'] . "%",'付款金额'=>$item['J_fkje'],'付款比例'=>$item['K_fkbl'] . "%" ],JSON_UNESCAPED_UNICODE);
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
if (!empty($pay_detail)) {
    $mod_payDetail->batchInsert($pay_detail);
}

//写入自动更新日志
if (!empty($data_log)) {
    $mod_autoSynLog->batchInsert($data_log);
    echo "autoSynLog";
}


$salesman_statistics = [];
$company_statistics = [];
$list_companyStatistics = [];
$list_personStatistics = [];

//公司统计数据组合(避免重复记录)
if (!empty($company_arr)) {
    foreach ($company_arr as $key_company => $value_company) {
        $time_start     = strtotime($key_company);
        $time_end       = strtotime("$key_company +1 month -1 second");
        $mod_companyStatistics->delete(['time'=> $value_company]);
        $info = iterator_to_array($mod_data->get(['B_htqyrq' => ['$gte' => $time_start, '$lte' => $time_end] ]));
        foreach ($info as $key_info => $value_info) {
            if (empty($list_companyStatistics[$key_company])) {
                $list_companyStatistics[$key_company]['time'] = $value_company;
                $list_companyStatistics[$key_company]['companyContractVolume'] = $value_info["E_zj"];
            } else {
                $list_companyStatistics[$key_company]['companyContractVolume'] += $value_info["E_zj"];
            }
        }
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
        foreach ($info as $key_info => $value_info ) {
            if (empty($list_companyStatistics[$key_person])) {
                $list_personStatistics[$key_person]['name']     = $value_info['F_xsry'];
                $list_personStatistics[$key_person]['time']     = $arr_explode[0];
                $list_personStatistics[$key_person]['time_y']   = $time_y;
                $list_personStatistics[$key_person]['myContractVolume']     = $value_info['E_zj'];
                $list_personStatistics[$key_person]['myReturnAmount']       = $value_info['J_fkje'];
                $list_personStatistics[$key_person]['myReceivables']        = $value_info['M_qkje'];
            } else {
                $list_personStatistics[$key_person]['myContractVolume']     += $value_info['E_zj'];
                $list_personStatistics[$key_person]['myReturnAmount']       += $value_info['J_fkje'];
                $list_personStatistics[$key_person]['myReceivables']        += $value_info['M_qkje'];
            }
        }
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
$str = file_get_contents("E:\\xampp\\htdocs\\public\\test.txt");
$str .= "\t" . $str_current  . "\n" ;
file_put_contents("E:\\xampp\\htdocs\\public\\test.txt",$str);
