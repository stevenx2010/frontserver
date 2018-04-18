<?php

require_once 'utils.php';
require_once '../config/env.php';
require_once 'getAd.php';

function genAdResponse() {
    // get image from DSP server
    $imageUrl = getImageUrl($GLOBALS['DSP_Server']['name'], $GLOBALS['DSP_Server']['port'], $GLOBALS['DSP_Server']['zone']);

    if(!$imageUrl) {
        $body['status'] = 0;
        $body['msg'] = 'Error: cannot get ads from the DSP server...';
    } else {
        $body['status'] = 1;
        
        // generate unique id
        $myCounter = new Counter('127.0.0.1');
        $count = $myCounter->getCount();
        $myCounter->setCount();
        $timestamp = md5((string)$GLOBALS['request'] . (string)time() . $count);

        $GLOBALS['ad_serving_log']['response_id'] = $timestamp;

        $body['id'] = $timestamp;
        $body['iurl'] = $imageUrl;
        $body['burl'] = 'http://' . $GLOBALS['Beacon_Server']['name'] . ':' . $GLOBALS['Beacon_Server']['port'] . 
                        '/beacon/' . $timestamp;

    }

    return $body;
}

?>