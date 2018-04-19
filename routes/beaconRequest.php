<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once '../src/setupDatabase.php';

$app->get('/beacon/{id}', function(Request $req, Response $res, array $args) {
    $id = $args['id'];
    echo 'Creative in response (' . $id . ') has been viewed.';
 
    // update database
    $datetime = getDateTime();

    $sql = "UPDATE ad_serving_log SET beacon_received='$datetime' WHERE response_id='$id'";

    $mysqli = dbConnection();
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sql);
    if(!$stmt->execute()) {
        echo "Error: Cannot find the response with id: $id";
    }

    $stmt->close();
    $mysqli->close();

    return $res;
});
?>