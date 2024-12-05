<?php

error_reporting(0);
date_default_timezone_set('Asia/Kolkata');
include_once dirname(dirname(__FILE__)) . "/config.php";
include_once dirname(dirname(__FILE__)) . "/dbcon/db_connect.php";
include_once dirname(dirname(__FILE__)) . "/functions/common.function.php";

$APP_Array = array();
$engaged_ids = array();

// count total number of records exists in app queue
$total_records_query = $db->query("SELECT Deleted, count(*) as total_records FROM lm_app_queue WHERE FcmToken != '' GROUP BY Deleted");
$total_records_query->setFetchMode(PDO::FETCH_ASSOC);

while ($row_records = $total_records_query->fetch()) {
    if ($row_records['Deleted'] == '0') {
        $total_records = $row_records['total_records']; // get non deleted rows
    } else if ($row_records['Deleted'] == '1') {
        $cnt = $row_records['total_records']; // get deleted rows
    }
}

// find batch size of app
$SMS_Batch = blockSize($total_records);

// check if app batch is not full then continue
if ($SMS_Batch > 0) {
    // get records of school
    $sql_insid_sms = $db->query("SELECT T1.ID, T1.ReceiverID, T1.SenderID, T1.Origin, T1.Message, T1.MessageData, T1.TrySent, T1.FcmToken, T1.OsType, T1.SentTo
                                  FROM lm_app_queue T1
                                  WHERE T1.Deleted = '0'
                                  AND T1.TrySent = '0'
				  AND T1.SentTime = 0
				  AND T1.DeleteTime = 0
                                  AND T1.FcmToken != ''
                                  LIMIT " . $SMS_Batch . "
                                  ");

    $sql_insid_sms->setFetchMode(PDO::FETCH_ASSOC);
    while ($row_insid_sms = $sql_insid_sms->fetch()) {
        $APP_Array[] = $row_insid_sms;
        $engaged_ids[] = $row_insid_sms['ID'];
    }
}

// mark trysent 1 for the resultset
$db->query("UPDATE lm_app_queue SET TrySent = TrySent + 1 WHERE ID IN (" . implode(",", $engaged_ids) . ")");

foreach ($APP_Array as $key => $rowMsg) {
    $key = $rowMsg['FcmToken'];
    $fcm_data = html_entity_decode($rowMsg['MessageData']);
    $os_type = $rowMsg['OsType'];
    $sent_to = $rowMsg['SentTo'];
    if ($os_type == '1') {
        $fcm_response = send_android_notification($key, $fcm_data, $firebase_app_key);
        $fcm_response_array = json_decode($fcm_response, true);
        if ($fcm_response_array['results'][0]['message_id']) {
            $db->query("UPDATE lm_app_queue SET SentStatus = '1', SentTime = '" . time() . "', Deleted = '1' WHERE ID = '" . $rowMsg['ID'] . "'");
        }
    } else if ($os_type == '2') {
        $fcm_response = send_ios_notification($key, $fcm_data, $firebase_app_key);
        $fcm_response_array = json_decode($fcm_response, true);
        if ($fcm_response_array['results'][0]['message_id']) {
            $db->query("UPDATE lm_app_queue SET SentStatus = '1', SentTime = '" . time() . "', Deleted = '1' WHERE ID = '" . $rowMsg['ID'] . "'");
        }
    }

}

// delete from app_queue table and take backup of deleted records
// if deleted records count exceeds
if ($cnt > $msg_rows_count) {
    $deleted = 0;
    exec('mysqldump --user=' . $db_username . ' --password=' . $db_password . ' --host=' . $db_hostname . ' --databases ' . $db_database . ' --tables lm_app_queue --where="Deleted > ' . $deleted . '" > ' . dirname(dirname(__FILE__)) . '/logs/app_logs/queue_mail-' . date('d-m-Y') . '-' . date('H-i-s', time()) . '.sql');
    $db->query("DELETE FROM lm_app_queue WHERE Deleted = '1'");
}

function send_android_notification($registration_ids, $message, $firebase_key) {
    $fields = array(
        'registration_ids' => array($registration_ids),
        'data' => array('data' => json_decode($message, TRUE))
    );

    $headers = array(
        'Authorization: key=' . $firebase_key,
        'Content-Type: application/json'
    );
    // Open connection
    $ch = curl_init();

    // Set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Disabling SSL Certificate support temporarly
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

    // Execute post
    $result = curl_exec($ch);
    if ($result === false) {
        die('Curl failed:' . curl_errno($ch));
    }

    // Close connection
    curl_close($ch);
    return $result;
}

function send_ios_notification($registration_ids, $message, $firebase_key) {
    $url = "https://fcm.googleapis.com/fcm/send";
    $token[] = $registration_ids;
    $serverKey = $firebase_key;
    $notification = json_decode($message, TRUE);

    $arrayToSend = array('time_to_live' => 20000, 'content_available' => true, 'registration_ids' => $token, 'notification' => array('body' => $notification['message']), 'priority' => 'high', 'topic' => 'production');
    $json = json_encode($arrayToSend);
    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Authorization: key=' . $serverKey;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Disabling SSL Certificate support temporarly
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //Send the request
    $response = curl_exec($ch);

    //Close request
    if ($response === FALSE) {
        die('FCM Send Error: ' . curl_error($ch));
    }
    curl_close($ch);
    return $response;
}

