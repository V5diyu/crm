<?php
/**
 * Created by PhpStorm.
 * User: w
 * Date: 2018/2/13
 * Time: 16:02
 */

include_once('E:\xampp\htdocs\application\dbhelp\OrderInfoDB.php');
include_once('E:\xampp\htdocs\application\dbhelp\OrderInfoDataDB.php');
include_once('E:\xampp\htdocs\application\dbhelp\SalespersonStatisticsDB.php');
include_once('E:\xampp\htdocs\application\dbhelp\CompanyStatisticsDB.php');
include_once('E:\xampp\htdocs\application\dbhelp\OrderPayDetailDb.php');
include_once('E:\xampp\htdocs\application\dbhelp\AutosynLogDb.php');

date_default_timezone_set("PRC");
header("Content-Type:text/html;charset=utf-8");

$mod_data = new OrderInfoDataDB();

/*$data = $mod_data->get();
foreach ($data as $key => $item) {
    foreach($item as $key_table => $value_table) {
        echo $key_table . '=>' . $value_table . '<br />';
    }
}*/

$item[0] = [
    'A_hth'     =>'TLU2017113071',
    'B_htqyrq'  =>1512057600,
    'C_ssxm'    =>'',
    'D_khdw'    =>'江西卓尔金属设备集团有限公司',
    'E_zj'      =>13,275.00,
    'F_xsry'    =>'杨阳',
    'G_fh'      =>'未发货',
    'H_fhbl'    =>0,
    'I_fp'      =>'',
    'J_fkje'    =>'',
    'K_fkbl'    =>'',
    'L_fkxq'    =>'',
    'M_qkje'    =>'',
    'N_wkdqr'   =>'',
    'O_sfcq'    =>'',
    'P_cwhxclyj'=>'',
    'Q_xsclfk'  =>'',
    'R_zsdsl'   =>'',
    'S_zxhsl'   =>0,
];

$mod_data->batchInsert($item);

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
