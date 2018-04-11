<?php

require_once 'globals.php';
require_once 'getAd.php';

$imageUrl = getImageUrl();
if(!$imageUrl) {
    $body['status'] = 0;
} else {
    $body['status'] = 1;
    $body['iurl'] = $imageUrl;

    $timestamp = md5((string)$GLOBALS['request'] . (string)time() . (string)$GLOBALS['cnt']);
    echo $timestamp;
    $body['id'] = $timestamp;
    echo $GLOBALS['cnt'];

}

?>