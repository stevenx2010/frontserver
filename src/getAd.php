<?php
require_once 'setupDatabase.php';

function getImageUrl($host = 'adserver.yitongxun.cn', $port = 8080, $zones = 5) {
    // Construct uri to Revive AdServer
    $path = '/revive/www/delivery/asyncspc.php';
    $prefix = 'revive-0-';
    $block = 1;
    $loc = 'http://adserver.yitongxun.cn:8080/index2.html';

    $query = 'zones=' . $zones . '&';
    $query .= 'prefix=' . $prefix . '&';
    $query .= 'block=' . $block . '&';
    $query .= 'loc=' . $loc;

    $url = 'http://' . $host . ':' . $port  . $path .'?' . $query;

    /* send HTTP request by curl
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

    // send HTTP request by file_get_contents
    ini_set('user_agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36');
    $content = file_get_contents($url);
    //print_r(explode('img', ((array)((array)json_decode($content))['revive-0-0'])['html']));

    // Analyze content returned by Revive AdServer
    // extract 'bannerid' from response
    $pattern = '/(.*bannerid=)(\d+)(&.*)/ism';
    $replacement = '$2';
    $bannerid = preg_replace($pattern, $replacement, $content);
    $GLOBALS['ad_serving_log']['revive_bannerid'] = $bannerid;

    // extract 'campaignid' from response
    $pattern = '/(.*campaignid=)(\d+)(&.*)/ism';
    $replacement = '$2';
    $campaignid = preg_replace($pattern, $replacement, $content);
    $GLOBALS['ad_serving_log']['revive_campaignid'] = $campaignid;

    // extract 'destinaton' url from response
    $pattern = '/(.*dest=)(.*)(\' target)(.*)/ism';
    $replacement = '$2';
    $dest = preg_replace($pattern, $replacement, $content);
    if(strncmp($dest, 'http', 4) != 0) $dest = '';
    $GLOBALS['ad_serving_log']['destination'] = urldecode($dest);
 
    // extract the 'image' url from response
    $pattern = '/(.*<img src=\')(.*)(jpg|png|gif)(.*)/ism';
    $replacement = '$2$3';
    $imgurl = preg_replace($pattern, $replacement, $content);

    // remove the backslashes in the image url
    $pattern = '#\\\#';
    $url_array = preg_split($pattern, $imgurl);
    $imgurl = implode($url_array);
    
    return $imgurl;


    /* send HTTP request by fsockopen, fwrite, fgets & fclose
    $fs = fsockopen($host, $port, $errcode, $errstr, 30);

    if(!$fs) {
        echo "$errstr ($errcode)<br />";
    } else {
        $header = "GET $path?$query HTTP/1.1\r\n";
        $header = $header . "Host: adserver.yitongxun.cn\r\n";
        $header = $header . "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36";
        $header = $header . "Connection: close\r\n\r\n";

        fwrite($fs, $header);

        $content = '';

        while(!feof($fs)) {
            global $content;
            $content .= fgets($fs, 256);
        }

        echo $content;
        print_r(explode(' ', $content));
        
        fclose($fs);
    }*/
}
?>