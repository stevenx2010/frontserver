<?php

require_once 'utils.php';
require_once '../config/env.php';
require_once 'getAd.php';

function genAdResponse($host, $path) {
    // get image from DSP server
    $imageUrl = getImageUrl($GLOBALS['DSP_Server']['name'], $GLOBALS['DSP_Server']['port'], $GLOBALS['DSP_Server']['zone']);

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
        $body['burl'] = 'http://' . $host . $path . '/' . $timestamp;

    }

    return $body;
}

?>