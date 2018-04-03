<?php
/**
 * Created by PhpStorm.
 * User: w
 * Date: 2018/4/3
 * Time: 13:18
 */


include_once('C:\xampp\htdocs\application\dbhelp\LendDB.php');                  //借用表
include_once('C:\xampp\htdocs\application\dbhelp\BillDB.php');
include_once('C:\xampp\htdocs\application\dbhelp\ProductDeliveryDataDB.php');
include_once('C:\xampp\htdocs\application\dbhelp\AutosynLogDb.php');            //同步表

date_default_timezone_set("PRC");

$servern="localhost";
$coninfo=array("Database"=>"DB_ZJTK","UID"=>"sa","PWD"=>"SAsa123","CharacterSet"=>"utf-8");

$conn=sqlsrv_connect($servern,$coninfo) or die ("connect deny!");
if($conn){
    echo "OK ! HELLO SQL SERVER";
} else {
    echo "Connection could not be established.";
    die( print_r(sqlsrv_errors(), true));
}

$mod_lend           = new LendDB();
$mod_autoSynLog     = new AutosynLogDb();
$mod_bill           = new BillDB();
$mod_product        = new ProductDeliveryDataDB();

//间隔时间
$time_current = time();
$time_pre = time() - 60*30;
$str_current = date('Y-m-d H:i:s',$time_current);
$str_pre = date('Y-m-d H:i:s',$time_pre);

$product_arr    = [];
$bill_arr       = [];
$lend_arr       = [];

$product_list   = [];
$bill_list      = [];
$lend_list      = [];

//借用(缺少单价或者借用总价)
//借用(缺少单价或者借用总价)
$sql_lend  = "select m.bl_no as A_dh, t.prd_no as B_ph, t.prd_name as C_pm, t.amt as price, m.BL_DD as lenddate,m.EST_DD as returndate,t.qty as G_jysl,t.qty_rtn as H_ghsl,(select c.name from CUST c where c.cus_no= m.cus_no)as customer,(select s.Name from SALM s where s.sal_no = m.sal_no) as salesman   from TF_BLN t,MF_BLN m where t.BL_NO = m.BL_NO and  ((m.BL_DD >='". $str_pre ."' AND m.bl_DD<'". $str_current ."') or (m.Modify_dd >='". $str_pre ."' AND m.Modify_dd<'" . $str_current . "') or (m.sys_date >='". $str_pre ."' AND m.sys_date<'". $str_current ."')) and m.bl_id = 'LN'";

//发票
$sql_bill = "select lz_no, lz_dd, amt,cas_no  from mf_lz m where ((m.lz_dd >='". $str_pre ."' AND m.lz_dd<'". $str_current ."') OR (m.Modify_dd >='". $str_pre ."' AND m.Modify_dd<'". $str_current ."') OR (m.sys_date >='". $str_pre ."' AND m.sys_date<'". $str_current ."')) AND m.lz_id = 'LO' ";

//交期
$sql_product = "select t.ck_no as D_dh, t.prd_no as E_ph, t.prd_name as F_pm,t.ck_dd, t.prd_mark as G_hpgg,t.unit as H_dw,t.REM as O_bz,t.qty as J_sl,t.est_dd,t.qty_ps as L_wzxhsl, m.cus_os_no as C_gcah, (select c.name from CUST c where c.cus_no= m.cus_no)as customer,(select s.Name from SALM s where s.sal_no = m.sal_no) as salesman from tf_ck t,mf_ck m where t.ck_no = m.ck_no and ((m.ck_dd >='". $str_pre ."' AND m.ck_dd<'". $str_current ."') or (m.Modify_dd >='". $str_pre ."' AND m.Modify_dd<'". $str_current ."') or (m.sys_date >='". $str_pre ."' AND m.sys_date<'". $str_current ."')) and t.ck_id = 'CK'";

$stmt = sqlsrv_query($conn,$sql_lend);
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $id = getUuid();
    $arr_1 = (array)$row['lenddate'];
    $arr_2 = (array)$row['returndate'];
    //$price = $row['price'];

    $lend_arr[$id]['id'] = $id;
    $lend_arr[$id]['A_dh']   = $row['A_dh'];
    $lend_arr[$id]['B_ph']   = $row['B_ph'];
    $lend_arr[$id]['C_pm']   = $row['C_pm'];
    $lend_arr[$id]['D_zj']   = $row['price'] * $row['G_jysl'];              //直接获取总价或者获取单价根据数量计算
    $lend_arr[$id]['E_xsry'] = $row['salesman'];
    $lend_arr[$id]['F_khmc'] = $row['customer'];
    $lend_arr[$id]['G_jysl'] = $row['G_jysl'];
    $lend_arr[$id]['H_ghsl'] = $row['H_ghsl'];
    $lend_arr[$id]['I_jcsj'] = strtotime($arr_1['date']);
    $lend_arr[$id]['J_ghsj'] = strtotime($arr_2['date']);
    $lend_arr[$id]['K_dqsj'] = strtotime(date('Y-m-d',$arr_1['date']) . ' +3 months');

    unset($arr_2) ;
    unset($arr_1) ;
}

$stmt = sqlsrv_query($conn,$sql_bill);
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $id = getUuid();
    $arr_1 = (array)$row['lz_dd'];

    $bill_arr[$id]['id']        = $id;
    $bill_arr[$id]['A_pjhm']    = $row['lz_no'];
    $bill_arr[$id]['B_pmje']    = $row['amt'];
    $bill_arr[$id]['C_kpsj']    = strtotime($arr_1['date']);
    $bill_arr[$id]['D_hth']     = $row['cas_no'];

    unset($arr_1);
}

$stmt = sqlsrv_query($conn,$sql_product);
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $id = getUuid();
    $arr_1 = (array)$row['ck_dd'];
    $arr_2 = (array)$row['est_dd'];

    $product_arr[$id]['id']         = $id;
    $product_arr[$id]['A_khmc']     = $row['customer'];
    $product_arr[$id]['B_ywy']      = $row['salesman'];
    $product_arr[$id]['C_gcah']     = $row['C_gcah'];
    $product_arr[$id]['D_dh']       = $row['D_dh'];
    $product_arr[$id]['E_ph']       = $row['E_ph'];
    $product_arr[$id]['F_pm']       = $row['F_pm'];
    $product_arr[$id]['G_hpgg']     = $row['G_hpgg']; //
    $product_arr[$id]['H_dw']       = $row['H_dw']; //
    $product_arr[$id]['I_ckrq']     = strtotime($arr_1['date']); //
    $product_arr[$id]['J_sl']       = $row['J_sl'];
    $product_arr[$id]['K_xhsl']     = $row['K_xhsl'];
    $product_arr[$id]['L_wzxhsl']   = $row['L_wzxhsl'];
    $product_arr[$id]['N_yjfhsj']   = $strtotime($arr_2['date']);
    $product_arr[$id]['O_bz']       = $row['O_bz']; //
}

//借用            联合主键
if (!empty($lend_arr)) {

    foreach ($lend_arr as $lend_item) {
        $data_find = $mod_lend->getInfo([ 'A_dh'=> $lend_item['A_dh'], 'B_ph' => $lend_item['B_ph'] ]);
        if (empty($data_find)) {
            $lend_list[] = $lend_item;

            //=============同步信息

        } else {
            $id = $data_find['id'];

            $D_zj   = $leng_item['D_zj'];
            $E_xsry = $lend_item['E_xsry'];
            $F_khmc = $lend_item['F_khmc'];
            $G_jysl = $lend_item['G_jysl'];
            $H_ghsl = $lend_item['H_ghsl'];
            $I_jcsj = $lend_item['I_jcsj'];
            $J_ghsj = $lend_item['J_ghsj'];
            $K_dqsj = $lend_item['K_dqsj'];

            //更新数据
            $mod_lend = update([
                'D_zj'      => $D_zj,
                'E_xsry'    => $E_xsry,
                'F_khmc'    => $F_khmc,
                'G_jysl'    => $G_jysl,
                'H_ghsl'    => $H_ghsl,
                'I_jcsj'    => $I_jcsj,
                'J_ghsj'    => $J_ghsj,
                'K_dqsj'    => $K_dqsj
            ],$id);

            //=============同步信息

        }
    }
}

//
if (!empty($bill_arr)) {

    $bill_no    = array_column($bill_arr,'A_pjhm');
    $data_bill  = $mod_bill->get(['A_pjhm'=>['$in' => $bill_no ]]);
    $data_no    = array_column(iterator_to_array($data_bill),'A_pjhm');

    foreach ($bill_arr as $bill_item) {
        if (!in_array($bill_item['A_pjhm'],$data_no)) {
            $bill_list[] = $bill_item;

            //=============同步信息

        } else {

            $info = $mod_bill->getInfo([ 'A_pjhm' => $bill_item['A_pjhm'] ]);

            //发票明细更新
            /*$mod_bill->uopdate([
                'A_pjhm' => $bill_item['A_pjhm'],
                'B_pmje' => $bill_item['B_pmje'],
                'C_kpsj' => $bill_item['C_kpsj'],
                'D_hth'  => $bill_item['D_hth']
            ],$info['id']);*/

            //=============同步信息

        }
    }
}

//交期        联合主键
if (!empty($product_arr)) {

    foreach ($product_arr as $product_item) {

        $data_find = $mod_product->getInfo([ 'D_dh' => $product_item['D_dh'], 'E_ph' => $product_item['E_ph'] ]);

        if (empty($data_find)) {
            $product_list[] = $product_item;

            //=============同步信息
        } else {

            $id = $data_find['id'];

            $A_khmc     = $product_item['A_khmc'];
            $B_ywy      = $product_item['B_ywy'];
            $C_gcah     = $product_item['C_gcah'];
            $D_dh       = $product_item['D_dh'];
            $E_ph       = $product_item['E_ph'];
            $F_pm       = $product_item['F_pm'];
            $G_hpgg     = $product_item['G_hpgg'];
            $H_dw       = $product_item['H_dw'];
            $I_ckrq     = $product_item['I_ckrq'];
            $J_sl       = $product_item['J_sl'];
            $K_xhsl     = $product_item['K_xhsl'];
            $L_wzxhsl   = $product_item['L_wzxhsl'];
            $N_yjfhsj   = $product_item['N_yjfhsj'];
            $O_bz       = $porduct_item['O_bz'];

            //更新交期信息
            /*$mod_product->update([
                'A_khmc'    => $A_khmc,
                'B_ywy'     => $B_ywy,
                'G_hpgg'    => $G_hpgg,
                'H_dw'      => $H_dw,
                'I_ckrq'    => $I_ckrq,
                'J_sl'      => $J_sl,
                'K_xhsl'    => $K_xhsl,
                'L_wzxhsl'  => $L_wzxhsl,
                'N_yjfhsj'  => $N_yjfhsj,
                'O_bz'      => $O_bz
            ],$id);*/
            //=============同步信息
        }

    }
}

//写入借用信息
if (!empty($lend_list)) {

    //

    //$mod_lend->batchInsert($lend_list);
}


//写入发票信息
if (!empty($bill_list)) {

    //

    //$mod_bill->batchInsert($bill_list);
}


//写入交期信息
if (!empty($product_list)) {

    //

    //$mod_product->batchInsert($product_list);
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
sqlsrv_close($conn);

