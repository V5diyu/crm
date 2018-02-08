<?php
/**
 * Created by PhpStorm.
 * User: luotao
 * Date: 2017/11/14
 * Time: 上午11:39
 */
set_time_limit(0);
date_default_timezone_set('Asia/Shanghai');

$configArray = include './config.php';
$postUrl     = $configArray['domain'] . '/api/product_delivery/sendMsg';
/*
 * 销售交期消息提处理
 * */
while (true) {
    $con      = mongoConnect()->productDelivery_msg;
    $con_user = mongoConnect()->salesperson;
    $data     = $con->find()->skip(0)->limit(20);
    foreach ($data as $item) {
        $userInfo = $con_user->findOne(['name' => $item['ywy']]);
        if (!empty($userInfo)) {
            $content = '销售交期推后提醒：(' . $item['khmc'] . ')客户(' . $item['dh'] . ')单号的(' . $item['pm'] . ')等产品，预计发货时间推迟到(' . $item['yjfhrq'] . '),推迟原因为(' . $item['jqtcyy'] . '),请进去销售管理系统查看详细信息。';
            dopost($postUrl, ['userId' => $userInfo['userId'], 'content' => $content]);
        }
        $con->remove(['id' => $item['id']]);
    }
    sleep(300);
}
