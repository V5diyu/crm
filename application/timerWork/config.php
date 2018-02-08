<?php

return [
    'domain'  => 'http://twelve.ylyedu.com',
    'mongodb' => [
        'host'     => '127.0.0.1',
        'prot'     => '27017',
        'dbname'   => 'dingding',
        'username' => 'root',
        'password' => 'yelangying'
    ],
];


function mongoConnect()
{
    global $configArray;
    $host     = $configArray['mongodb']['host'];
    $port     = $configArray['mongodb']['prot'];
    $dbname   = $configArray['mongodb']['dbname'];
    $username = $configArray['mongodb']['username'];
    $password = $configArray['mongodb']['password'];
    $mongo    = new MongoClient('mongodb://' . $username . ':' . $password . '@' . $host . ':' . $port . '/admin');
    return $mongo->selectDB($dbname);
}

/**
 * @param      $url
 * @param      $postDataArray
 * @param null $headers
 * @return mixed
 * @desc CURL工具
 */
function dopost($url, $postDataArray, $headers = null)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);

    if (!empty($headers)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postDataArray));

    $output = curl_exec($ch);

    curl_close($ch);
    return $output;
}