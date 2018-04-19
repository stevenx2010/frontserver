<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once '../config/env.php';
require_once '../src/utils.php';
require_once '../src/genAdResponse.php';
require_once '../src/setupDatabase.php';
require_once '../src/authenticate.php';

$app->post('/', function(Request $req, Response $res, array $args) {
 
    // Check if the connection is legal
    $ip = $_SERVER['REMOTE_ADDR'];

    $result = validateConnection($ip);
    if(!$result['isLegal']){
        $body['status'] = 0;
        $body['msg'] = $result['msg'];

        return $res->withHeader('Content-type', 'application/json')->withJson($body);
    } 

    // analyse response from DSP server
    $parsedBody = $req->getParsedBody();
    $GLOBALS['request'] = implode($parsedBody);
    $GLOBALS['zoneid'] = $parsedBody['zoneid'];
    $GLOBALS['ad_serving_log']['request'] = json_encode($parsedBody);
    $GLOBALS['ad_serving_log']['revive_zoneid'] = $parsedBody['zoneid']; 
    $GLOBALS['ad_serving_log']['request_received'] = getDateTime();

    // prepare response
    $body = genAdResponse();

    $GLOBALS['ad_serving_log']['response'] = json_encode($body);
    //print_r($GLOBALS['ad_serving_log']);

    // log the trasaction
    $sql = 'INSERT INTO ad_serving_log (request, request_received, response, response_id, revive_campaignid, revive_zoneid, revive_bannerid) ' .
        'VALUES (' . 
        "'" . $GLOBALS['ad_serving_log']['request'] . "'". ',' .
        "'" . $GLOBALS['ad_serving_log']['request_received'] . "'" . ',' .
        "'" . $GLOBALS['ad_serving_log']['response'] . "'" . ',' .
        "'" . $GLOBALS['ad_serving_log']['response_id'] . "'" . ',' .
        $GLOBALS['ad_serving_log']['revive_campaignid'] . ',' .
        $GLOBALS['ad_serving_log']['revive_zoneid'] . ',' .
        $GLOBALS['ad_serving_log']['revive_bannerid'] . ')';
  
    $mysqli = dbConnection();
    
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sql);
 
    if(!$stmt->execute()) {
        $body = array();
        $body['status'] = 0;
        $body['msg'] = 'DB Error: cannot log into db';

        return $res->withHeader('Content-type', 'application/json')->withJson($body);
    }

    $stmt->close();
    $mysqli->close();

    return $res->withHeader('Content-type', 'application/json')->withJson($body);
});

?>