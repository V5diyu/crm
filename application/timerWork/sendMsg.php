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
$postUrl     = $configArray['domain'] . '/api/remind/sendMsg';
/*
 * 消息提处理
 * */
while (true) {
    $con  = mongoConnect()->remind;
    $data = $con->find(['sendStatus' => 0, 'time' => ['$lte' => time()]])->skip(0)->limit(20);
    foreach ($data as $item) {
       echo dopost($postUrl, ['id' => $item['id']]);
    }
    sleep(60);
}
