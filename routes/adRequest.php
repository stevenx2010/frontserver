<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/', function(Request $req, Response $res, array $args) {

    $parsedBody = $req->getParsedBody();

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

    //return $res->withHeader('Content-type', 'application/json');

    return $res;
});

?>