<?php

error_reporting(0);
$script_file_name = basename($_SERVER['SCRIPT_FILENAME']);
include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.php';
include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/vendor/autoload.php';
include_once dirname(dirname(dirname(__FILE__))) . '/apiAccess.php';
$api_validate = 1;//apiValidate($_REQUEST, $script_file_name);

if ($api_validate == 1) {
    include_once dirname(dirname(dirname(__FILE__))) . '/get_time_zone.php';
    include_once dirname(dirname(dirname(__FILE__))) . '/common_functions.php';
    include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/dbcon/db_connect.php';

    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];

    if ($username && $password) {
        $sql = $db->prepare("SELECT T1.ID, T1.Name, T1.UserType
                                FROM lm_users T1
                                WHERE T1.UserName = ?
                                AND T1.CipherPassword = ?
                                AND T1.Active = ?
                                LIMIT 1
                                ");

        $sql->bindParam(1, $username);
        $sql->bindParam(2, hash('sha512', $password));
        $sql->bindValue(3, '1');
        $sql->execute();
        $rowcount = $sql->rowCount();
        if ($rowcount == 0) {
            $data = array('status' => false, 'message' => 'Invalid Username or Password');
        } else {
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $user_data = $sql->fetch();

            $user_info = array("userId" => $user_data['ID'], "userName" => $user_data['Name'], "userType" => $user_data['UserType']);

            //Creating JSON
            $data = array('status' => true, 'message' => 'Login Successfull', "userInfo" => $user_info);
        }
    }
    $data = removeEmptyValues($data);
    print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
}