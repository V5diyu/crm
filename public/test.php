<?php




die();

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
    echo "OK ! HELLO SQL SERVER<br />";
} else {
    echo "Connection could not be established.";
    die( print_r(sqlsrv_errors(), true)); 
}

$mod_data                  = new OrderInfoDataDB();
$mod_autoSynLog            = new AutosynLogDb();
$mod_salespersonStatistics = new SalespersonStatisticsDB();
$mod_companyStatistics     = new CompanyStatisticsDB();
$mod_payDetail             = new OrderPayDetailDb();
$mod_personReceive         = new SalespersonReceiveDB();



$ret_1 = [];
$pay_detail = [];
$data_log = [];
$sale_man_arr = [];
$company_arr = [];
$pay_detail_arr = [];
$sale_receive_arr = [];
$str_pre = '2016-01-01 00:00:00';
$str_current = '2018-03-26 13:30:00';

//$sql_pay_detail = "select min(tm.CAS_NO)  as contract, min(tm.amtn_bb) as payment, min(tm.RP_DD) as paydate, min(tm.rp_no) as payno, min(s.Name) as salesman from  TF_MON tm left join MF_POS p on p.cus_os_no = tm.CAS_NO left join SALM s on s.sal_no = p.sal_no where ((tm.rp_DD >='". $str_pre ."' AND tm.rp_DD<'" . $str_current . "') or (tm.Modify_dd >='". $str_pre ."' AND tm.Modify_dd<'" . $str_current . "') or (tm.sys_date >='". $str_pre ."' AND tm.sys_date<'" . $str_current . "')) and tm.CAS_NO is not null and tm.CAS_NO <>'' and tm.RP_ID =1";
$sql_pay_detail = "select tm.CAS_NO as contract, min(tm.amtn_bb) as payment, min(tm.RP_DD) as paydate, tm.rp_no as payno, min(s.Name) as salesman from  TF_MON tm left join MF_POS p on p.cus_os_no = tm.CAS_NO left join SALM s on s.sal_no = p.sal_no where ((tm.rp_DD >='". $str_pre ."' AND tm.rp_DD<'" . $str_current . "') or (tm.Modify_dd >='". $str_pre ."' AND tm.Modify_dd<'" . $str_current . "') or (tm.sys_date >='". $str_pre ."' AND tm.sys_date<'" . $str_current . "')) and tm.CAS_NO is not null and tm.CAS_NO <>'' and tm.RP_ID =1 group by tm.CAS_NO,tm.rp_no";
$stmt = sqlsrv_query($conn,$sql_pay_detail);
while ($row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)) {
    $id_pay = getUuid();
    $pay_detail[$id_pay]['id'] = getUuid();
    $pay_detail[$id_pay]['contract'] = $row['contract'];
    $pay_detail[$id_pay]['payment'] = empty($row['payment']) ? 0 : (round($row['payment']));
    $pay_detail[$id_pay]['paydate'] = $row['paydate'];
    $pay_detail[$id_pay]['payno']   = $row['payno'];
    $pay_detail[$id_pay]['name']    = empty($row['salesman']) ? 'noName' : $row['salesman'];

    $pay_date_arr = (array)$row['paydate'];
    $pay_time_y = date('Y',strtotime($pay_date_arr['date']));
    $pay_time_m = date('Y-m',strtotime($pay_date_arr['date']));
    $pay_detail[$id_pay]['time_y'] = $pay_time_y;
    $pay_detail[$id_pay]['time_m'] = $pay_time_m;

    unset($row);
}

echo count($pay_detail) , '<br >';
echo $sql_pay_detail, '<br >';
//var_dump($pay_detail);
//die();

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
        }

    }
}


//写入付款明细
if (!empty($pay_detail_arr)) {
    $mod_payDetail->batchInsert($pay_detail_arr);
}


$list_personReceive    = [];


//销售月份回款统计
if (!empty($sale_receive_arr)) {
    foreach ( $sale_receive_arr as $receive_key => $receive_value) { 
        //echo $receive_value, '<br >';
        $arr_explode = explode('=',$receive_value);
        $sale_man = $arr_explode[1];
        $time_m   = $arr_explode[0];
        $time_y   = date('Y',strtotime($time_m));
        $mod_personReceive->delete(['name'=>$sale_man,'time_m'=>$time_m]);
        $info = iterator_to_array($mod_payDetail->get(['time_m'=>$time_m,'name'=>$sale_man]));
        $list_personReceive[$receive_key]['time']       = $time_m;
        $list_personReceive[$receive_key]['name']       = $sale_man;
        $list_personReceive[$receive_key]['time_y']     = $time_y;
        $list_personReceive[$receive_key]['receive']    = array_sum(array_column($info,"payment"));
    }
}


//var_dump($list_personReceive);

//写入销售月回款统计
if (!empty($list_personReceive)) {
    $mod_personReceive->batchInsert($list_personReceive);
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

