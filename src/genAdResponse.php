<?php

require_once 'utils.php';
require_once '../config/env.php';
require_once '../config/databases.php';
require_once 'getAd.php';

function genAdResponse() {
    $body = array();
    // get image from DSP server
    $imageUrl = getImageUrl($GLOBALS['DSP_Server']['name'], $GLOBALS['DSP_Server']['port'], $GLOBALS['zoneid']);

    if(!$imageUrl || strncmp($imageUrl, 'http', 4) != 0) {
        $body['status'] = 0;
        $body['msg'] = 'Info: no ad from DSP, possible reasons: ' . 
                        '1. the compaign has stopped; ' . 
                        '2. the ad has reached to its delivery limit; ' .
                        '3. ad server has problem';

        return $body;
    } 

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
    $body['curl'] = $GLOBALS['ad_serving_log']['destination'];

    return $body;
}

?>