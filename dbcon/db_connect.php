<?php

error_reporting(0);

try {
    $db = new PDO("mysql:host=$db_hostname; dbname=$db_database", $db_username, $db_password, array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ));
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    //echo 'Connection failed:' . $e->getMessage();
    $data = array('status' => '0', 'message' => 'Database Connection failed');
    print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
    exit;
}
