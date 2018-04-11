<?php

require_once 'globals.php';
require_once 'getAd.php';

function GenResponse($host, $path) {
    $imageUrl = getImageUrl();

    if(!$imageUrl) {
        $body['status'] = 0;
    } else {
        $body['status'] = 1;
        

        // generate unique id
        $myCounter = new Counter('127.0.0.1');
        $count = $myCounter->getCount();
        $myCounter->setCount();
        $timestamp = md5((string)$GLOBALS['request'] . (string)time() . $count);

        $body['id'] = $timestamp;
        $body['iurl'] = $imageUrl;
        $body['burl'] = 'http://' . $host . $path;

    }

    return $body;
}

?>