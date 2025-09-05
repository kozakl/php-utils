<?php
namespace kozakl\utils;

use PDO;

function executeQuery($db, $query, $params, $paramTypes = []) {
    $stmt = $db->prepare($query);
    foreach ($params as $key => $value) {
        $type = $paramTypes[$key] ?? PDO::PARAM_STR;
        $stmt->bindValue($key, $value, $type);
    }
    
    $stmt->execute();
    return $stmt;
}
