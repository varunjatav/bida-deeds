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

    $user_id = $_REQUEST['userid'];
    $user_type = $_REQUEST['user_type'];
    $fcm_token = $_REQUEST['fcm'];
    $os_type = $_REQUEST['os_type'];

    if ($user_id && $user_type) {

        $update = $db->prepare("UPDATE lm_users SET FcmToken = ?, OsType = ? WHERE ID = ?");
        $update->bindParam(1, $fcm_token);
        $update->bindParam(2, $os_type);
        $update->bindParam(3, $user_id);
        $update->execute();

        if ($user_type == '1') {
            $sql = $db->prepare("SELECT T1.VillageName, T1.VillageCode
                                    FROM lm_village T1
                                    LEFT JOIN lm_user_village_mapping T2 ON T2.VillageCode = T1.VillageCode
                                    WHERE T1.Active = ?
                                    AND T2.UserID = ?
                                    GROUP BY T1.VillageCode
                                    ORDER BY T1.VillageName ASC
                                    ");
        } else if ($user_type == '7') {
            $sql = $db->prepare("SELECT T1.VillageName, T1.VillageCode
                                FROM lm_village T1
                                LEFT JOIN lm_user_village_gata_mapping T2 ON T2.VillageCode = T1.VillageCode
                                WHERE T1.Active = ?
                                AND T2.UserID = ?
                                GROUP BY T1.VillageCode
                                ORDER BY T1.VillageName ASC
                                ");
        } else if ($user_type == '8' || $user_type == '9') {
            $sql = $db->prepare("SELECT T1.VillageName, T1.VillageCode
                                FROM lm_village T1
                                LEFT JOIN lm_user_village_gata_mapping T2 ON T2.VillageCode = T1.VillageCode
                                WHERE T1.Active = ?
                                GROUP BY T1.VillageCode
                                ORDER BY T1.VillageName ASC
                                ");
        }
        if ($user_type == '8' || $user_type == '9') {
            $sql->bindValue(1, 1);
        } else {
            $sql->bindValue(1, 1);
            $sql->bindParam(2, $user_id);
        }
        $sql->execute();
        $rowcount = $sql->rowCount();

        if ($rowcount == 0) {
            $data = array('status' => false, 'message' => 'No villages mapped with you.');
        } else {
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            while ($row = $sql->fetch()) {
                $villageInfo[] = array("villageName" => $row['VillageName'], "villageCode" => $row['VillageCode']);
            }

            //Creating JSON
            $data = array('status' => true, 'message' => 'Villages', "villageInfo" => $villageInfo);
        }
    } else {
        //Creating JSON
        $data = array('status' => false, 'message' => 'Oops.. something went wrong.');
    }
    $data = removeEmptyValues($data);
    print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
}