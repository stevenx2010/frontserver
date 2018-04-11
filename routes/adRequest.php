<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once '../src/globals.php';

$app->post('/', function(Request $req, Response $res, array $args) {
    $GLOBALS['cnt'] += 1;
 
    $parsedBody = $req->getParsedBody();
    $GLOBALS['request'] = implode($parsedBody);
/*
    foreach($parsedBody as $key => $value) {
        echo $key . ':' . $value;
        echo '<br/>';
    }

    echo '<br/>';
    echo $parsedBody['apiVersion'];
    echo '<br/>';
    echo $req->getContentLength();
 
    echo '<br/>';
    echo $req->getContentType();
*/
    require '../src/prepareResponse.php';
    //return $res->withHeader('Content-type', 'application/json');

    return $res;
});

?>