<?php

ini_set('session.cookie_lifetime', $session_cookie_lifespan);
ini_set('session.gc_maxlifetime', $garbage_max_lifespan);
session_start();

$request_method = $_SERVER['REQUEST_METHOD'];

if (!isset($_COOKIE[$kasht_cookie_name])) {
    if ($request_method == 'GET') {
        include_once 'error.php';
        exit();
    } else if ($request_method == 'POST') {
        $db_respose_data = json_encode(array('status' => '-2', 'message' => 'Session expired. Please login again.'));
        print_r($db_respose_data);
        exit();
    }
} else if (!isset($_SESSION['mobile'])) {
    include_once 'core/kasht_cookie_login.core.php';
}