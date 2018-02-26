<?php
/**
 * Created by PhpStorm.
 * User: w
 * Date: 2018/2/13
 * Time: 14:45
 */

include_once('E:\xampp\htdocs\application\dbhelp\OrderInfoDB.php');
include_once('E:\xampp\htdocs\application\dbhelp\OrderInfoDataDB.php');
include_once('E:\xampp\htdocs\application\dbhelp\SalespersonStatisticsDB.php');
include_once('E:\xampp\htdocs\application\dbhelp\CompanyStatisticsDB.php');
include_once('E:\xampp\htdocs\application\dbhelp\OrderPayDetailDb.php');
include_once('E:\xampp\htdocs\application\dbhelp\AutosynLogDb.php');

date_default_timezone_set("PRC");

header("Content-type:text/html;charset=utf-8");
//远程数据库
$host = "";
$port = '1433';
$dbname = "DB_TLU";
$username = "sa";
$pw = "SAsa123";
$dbh = null;

//本地数据库


$host = "127.0.0.1";
$port = '1433';
$dbname = "DB_TK";
$username = "sa";
$pw = "123qwe123";
$dbh = null;


try {
    $dbh = new PDO ("sqlsrv:Server=$host,1433;Database=$dbname","$username","$pw");
} catch (PDOException $e) {
    echo "Failed to get DB handle: " . $e->getMessage() . "\n";
    exit;
}
