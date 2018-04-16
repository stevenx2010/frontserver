<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/beacon/{id}', function(Request $req, Response $res, array $args) {
    $id = $args['id'];
    echo $id;
 
    // update database

    return $res;
});