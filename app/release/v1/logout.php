<?php

error_reporting(0);
$script_file_name = basename($_SERVER['SCRIPT_FILENAME']);
include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.php';
include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/vendor/autoload.php';
include_once dirname(dirname(dirname(__FILE__))) . '/apiAccess.php';
$api_validate = 1; //apiValidate($_REQUEST, $script_file_name);

if ($api_validate == 1) {
    include_once dirname(dirname(dirname(__FILE__))) . '/get_time_zone.php';
    include_once dirname(dirname(dirname(__FILE__))) . '/common_functions.php';
    include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/dbcon/db_connect.php';

    $userid = $_REQUEST['userid'];

    // update fcm token
    $updt = $db->prepare("UPDATE lm_users SET Token = ?, FcmToken = ? WHERE ID = ?");
    $updt->bindValue(1, '');
    $updt->bindValue(2, '');
    $updt->bindParam(3, $userid);
    $updt->execute();

    // return response
    $data = array('status' => true, 'message' => 'logged out');

    $data = removeEmptyValues($data);
    print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
}
