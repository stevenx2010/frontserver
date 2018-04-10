<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\App;
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});

$app->get('/', function(Request $req, Response $res) {
    echo $req->getUri();
    echo '<br />';
    echo $req->getMethod();

    $headers = $req->getHeaders();
    foreach($headers as $name => $values) {
        echo $name . ':' . implode(',', $values);
        echo '<br />';
    }

    echo '<br/>';
    $userAgent = $req->getHeader('User-agent');
    echo implode(',', $userAgent);
    echo '<br/>';

    echo $req->getHeaderLine('User-agent');
    echo '<br/>';

    echo $req->getContentType();
    echo '<br/>';

    echo implode($req->GetHeader('Content-type'));

    
    require '../src/getAd.php';

    return $res;
});

require '../routes/adRequest.php' ;

$app->run();