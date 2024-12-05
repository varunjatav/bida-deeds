<?php

include_once '../config.php';
include_once '../dbcon/db_connect.php';
include_once '../includes/checkSession.php';

$user_id = $_SESSION['UserID'];
$user_type = $_SESSION['UserType'];
$date = date('Y-m-d', time());
$info = array();
$noti_query_count = 0;

if ($user_type == '0' || $user_type == '1') {
    $noti_query = $db->prepare("SELECT T1.ID
                            FROM lm_web_queue T1
                            WHERE T1.ReceiverID = ?
                            AND T1.Readed = ?
                            AND T1.RowDeleted = ?
                            ORDER BY T1.ID DESC
                            LIMIT 200
                            ");

    $noti_query->bindParam(1, $user_id);
    $noti_query->bindValue(2, 0);
    $noti_query->bindValue(3, 0);
    $noti_query->execute();
    $noti_query->setFetchMode(PDO::FETCH_ASSOC);
    $noti_query_count = $noti_query->rowCount();
} else {

}
$info = array('new_notification' => $noti_query_count);
print(json_encode($info, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
