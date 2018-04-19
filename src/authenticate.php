<?php
require_once 'setupDatabase.php';

function validateConnection($ipAddress) {
    $mysqli = dbConnection();

    $sql = "SELECT * from ip_addresses A INNER JOIN publishers B ON A.publisherid=B.publisherid where A.ip='$ipAddress'";

    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sql);
    
    if(!$stmt->execute()) {
        $result = array(
            'msg' => "DB Error: cannot get records from database...",
            'isLegal' => false
        );

        $stmt->close();
        $mysqli->close();
        return $result;
    }

    if(!$stmt->fetch()) {
        $result = array(
            'msg' => "Illegal connection: your IP ($ipAddress) is not authorized to connect to this server",
            'isLegal' => false
        );
 
        $stmt->close();
        $mysqli->close();
        return $result;
    }

    $stmt->close();
    $mysqli->close();

    $result = array(
        'msg' => "Valid connection",
        'isLegal' => true
    );

    return $result;
}

?>