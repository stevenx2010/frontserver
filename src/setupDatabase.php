<?php

require_once '../config/env.php';
require_once '../config/databases.php';

function dbConnection() {
    $mysqli = new mysqli($GLOBALS['Database_Server']['name'], $GLOBALS['database']['username'], 
                     $GLOBALS['database']['password'], $GLOBALS['database']['dbname']);

    if($mysqli->connect_errno) {
        echo 'db connection error';
        echo 'Error: ' . $mysqli->connect_errno;

        exit;
    }

    return $mysqli;
}
?>