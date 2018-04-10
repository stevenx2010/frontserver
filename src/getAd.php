<?php
$host = 'adserver.yitongxun.cn';
$path = '/revive/www/delivery/asyncspc.php';
$port = 8080;
$zones = 5;
$prefix = 'revive-0-';
$block = 1;
$loc = 'http://adserver.yitongxun.cn:8080/index2.html';

$query = 'zones=' . $zones . '&';
$query .= 'prefix=' . $prefix . '&';
$query .= 'block=' . $block . '&';
$query .= 'loc=' . $loc;

$url = 'http://' . $host . ':' . $port  . $path .'?' . $query;

echo $url;
echo '<br />';

/*

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36');
$result = curl_exec($ch);
//print_r(explode(' ', $result));
//echo $result;
$info = curl_getinfo($ch, CURLINFO_HTTP_CODE);
echo $info;
curl_close($ch);
*/
ini_set('user_agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36');
$content = file_get_contents($url);
echo $content;

/*
$fs = fsockopen($host, $port, $errcode, $errstr, 30);

if(!$fs) {
    echo "$errstr ($errcode)<br />";
} else {
    $header = "GET $path?$query HTTP/1.1\r\n";
    $header = $header . "Host: adserver.yitongxun.cn\r\n";
    $header = $header . "User_Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36";
    $header = $header . "\r\n\r\n";

    fwrite($fs, $header);

    while(!feof($fs)) {
       $result = fgets($fs, 128);
 //      print_r(explode(' ', ($result)));
       echo $result;
    }
    
    fclose($fs);
}*/
?>