<?php 

include_once('E:\xampp\htdocs\application\dbhelp\OrderInfoDB.php');
include_once('E:\xampp\htdocs\application\dbhelp\OrderInfoDataDB.php');
include_once('E:\xampp\htdocs\application\dbhelp\SalespersonStatisticsDB.php');
include_once('E:\xampp\htdocs\application\dbhelp\CompanyStatisticsDB.php');
include_once('E:\xampp\htdocs\application\dbhelp\AutosynLogDb.php');
//include_once('../application/common.php');
//include_once('../application/config.php');
//use \OrderInfoDataDB;
//use \SalespersonStatisticsDB;
//use \CompanyStatisticsDB;
//header("Content-Type:text/html;charset=utf-8");
date_default_timezone_set("PRC");

$servern="localhost";
$coninfo=array("Database"=>"DB_TK","UID"=>"sa","PWD"=>"123qwe123","CharacterSet"=>"utf-8");
$conn=sqlsrv_connect($servern,$coninfo) or die ("连接失败!");
if($conn){
	echo "OK ! HELLO SQL SERVER<br />";
}else{ 
	echo "Connection could not be established.<br />"; 
	die( print_r(sqlsrv_errors(), true)); 
}
//$mod                       = new OrderInfoDB();
$mod_data                  = new OrderInfoDataDB();
//$mod_salesperson           = new SalespersonDB();
$mod_autoSynLog            = new AutosynLogDb();
$mod_salespersonStatistics = new SalespersonStatisticsDB();
$mod_companyStatistics     = new CompanyStatisticsDB();
//$mod_correctError          = new CorrectErrorDB();

$time_current = time();
$time_pre = time() - 60*30;
$str_current = date('Y-m-d H:i:s',$time_current);
$str_pre = date('Y-m-d H:i:s');
//var_dump($str_current);
$ret_1 = [];
$sql_1 = "select p.cus_os_no as contract,p.OS_DD as contractTime, c.NAME as customer,SUM(tp.AMT) as totalprice, min(s.Name) as salesman   from MF_POS p left join CUST c on p.cus_no =c.cus_no left join TF_POS tp on tp.os_no = p.os_no left join SALM s on s.sal_no = p.sal_no where p.OS_DD >='2017-12-01 00:00:00' AND p.OS_DD<'2018-01-01 00:00:00' and p.cus_os_no is not null GROUP BY p.cus_os_no,c.NAME,p.OS_DD ORDER BY contract ";
$sql_2 = "select p.cus_os_no as contract, count(ts.ps_no)*100/count(tp.os_no) as delivery from MF_POS p left join TF_PSS ts on ts.cus_os_no = p.cus_os_no left join TF_POS tp on tp.cus_os_no = p.cus_os_no where p.OS_DD >='2017-12-01 00:00:00' AND p.OS_DD<'2018-01-01 00:00:00' and p.cus_os_no is not null GROUP BY p.cus_os_no ORDER BY contract  ";
$sql_3 = "select p.cus_os_no as contract, tm.amtn_bb as paid, cm.amtn_cls as payment  from MF_POS p left join TF_MON tm on tm.CAS_NO = p.cus_os_no left join TC_MON cm on cm.RP_NO = tm.RP_NO where p.OS_DD >='2017-12-01 00:00:00' AND p.OS_DD<'2018-01-01 00:00:00' and p.cus_os_no is not null order by p.cus_os_no, tm.amtn_bb desc";
$sql_4 = "select p.cus_os_no as contract, ml.AMT as paid, tl.AMT as payment  from MF_POS p left join MF_LZ ml on ml.CAS_NO = p.cus_os_no left join TF_LZ tl on tl.cus_os_no = p.cus_os_no where p.OS_DD >='2017-12-01 00:00:00' AND p.OS_DD<'2018-01-01 00:00:00' and p.cus_os_no is not null order by p.cus_os_no, ml.AMT desc";
//var_dump($sql_1);
$stmt = sqlsrv_query($conn,$sql_1);
//var_dump($stmt);
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
//var_dump($ret_1);

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
        'J_fkje'     => strEmptyFloat($v['paid1']),                     //付款金额
        'K_fkbl'     => 0,                                              //付款比例
        'L_fkxq'     => '',                                             //付款详情
        'M_qkje'     => 0,                                              //欠款金额
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
$data_orderData             = $mod_data->get(['A_hth' => ['$in' => $list_hth]]);
$data_hth                   = array_column(iterator_to_array($data_orderData), 'A_hth');
$insert_orderData           = [];
$data_salespersonStatistics = [];
$data_companyStatistics     = [];

$data_log = [];
$id_unique = '';
foreach ($excel_list as $item) {
    //订单数据组合
    if (!in_array($item['A_hth'], $data_hth)) {
        $insert_orderData[] = $item;

        //更新日志数据组合
        $id_unique = getUuid();
        $data_log[$id_unique]['id'] = $id_unique;
        $data_log[$id_unique]['syn_time'] = $str_current;
        $data_log[$id_unique]['db_name'] = 'orderinfo_data';
        $data_log[$id_unique]['syn_cont'] = '订单数据';
        $data_log[$id_unique]['flag'] = $item['A_hth'];
        $data_log[$id_unique]['type'] = 'insert';

    } else {
        $info    = $mod_data->getInfo(['A_hth' => $item['A_hth']]);
        //$E_zj    = $info['E_zj'] + $item['E_zj'];               //总价
        //$M_qkje  = $info['M_qkje'] + $item['M_qkje'];           //欠款金额
        //$R_zsdsl = $info['R_zsdsl'] + $item['R_zsdsl'];         //总销货数量
        $E_zj    = $item['E_zj'];                       //总价
        $J_fkje  = $item['J_fkje'];                     //付款金额
        $mod_data->update(['E_zj' => $E_zj, 'J_fkje' => $J_fkje], $info['id']);
        //var_dump('orderCollectionUpdated');

        //更新日志数据
        $id_unique = getUuid();
        $data_log[$id_unique]['id'] = $id_unique;
        $data_log[$id_unique]['syn_time'] = $str_current;
        $data_log[$id_unique]['db_name'] = 'orderinfo_data';
        $data_log[$id_unique]['syn_cont'] = '订单数据';
        $data_log[$id_unique]['flag'] = $item['A_hth'];
        $data_log[$id_unique]['type'] = 'update';

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
//var_dump($insert_orderData);

//写入订单信息
if (!empty($insert_orderData)) {
    $mod_data->batchInsert($insert_orderData);
    //var_dump('orderInsert');
}

//写入销售统计信息
$list_salespersonStatistics = [];
foreach ($data_salespersonStatistics as $k => $v) {
    foreach ($v as $key => $value) {
        $info = $mod_salespersonStatistics->getInfo(['name' => $value['name'], 'time' => $value['time']]);
        if (empty($info)) {
            $list_salespersonStatistics[] = $value;
        }
        else {
            //$myContractVolume = $value['myContractVolume'] + $info['myContractVolume'];
            //$myReceivables    = $value['myReceivables'] + $info['myReceivables'];
            $myContractVolume = $value['myContractVolume'];
            $myReceivables    = $value['myReceivables'];
            $mod_salespersonStatistics->update([
                'myContractVolume' => $myContractVolume,
                'myReceivables'    => $myReceivables
            ], [
                'name' => $value['name'],
                'time' => $value['time']
            ]);
            //var_dump('saleStaticsUpdate');
        }
    }
}
//var_dump($list_salespersonStatistics);
if (!empty($list_salespersonStatistics)) {
    $mod_salespersonStatistics->batchInsert($list_salespersonStatistics);
    //var_dump('saleStaticsInsert');
}
//写入公司总统计
$list_companyStatistics = [];
foreach ($data_companyStatistics as $k => $v) {
    $info = $mod_companyStatistics->getInfo(['time' => $k]);
    if (empty($info)) {
        $list_companyStatistics[] = [
            'time'                  => $k,
            'companyContractVolume' => $v,
        ];
    } else {
        $companyContractVolume = $info['companyContractVolume'] + $v;
        $mod_companyStatistics->update(['companyContractVolume' => $companyContractVolume], ['time' => $k]);
        //var_dump('companyStaticsUpdate');
    }
}
if (!empty($list_companyStatistics)) {
    //$mod_companyStatistics->batchInsert($list_companyStatistics);
    /*var_dump('companyStatisticsInsert');*/
    echo "companyStasticsInsert <br >";
}

//写入自动更新日志

if (!empty($data_log)) {
    $mod_autoSynLog->batchInsert($data_log);
    echo "autoSynLog <br >";
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

//释放资源、数组。测试脚本是否执行

echo  $str_current . "<br />";
file_put_contents("E:\\xampp\\htdocs\\public\\test.txt",$str_current);
