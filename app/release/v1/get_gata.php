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
    $village_code = $_REQUEST['village_code'];
    $user_type = $_REQUEST['user_type'];

    if ($user_id && $village_code && $user_type) {
        if ($user_type == '1') {
            $sql = $db->prepare("SELECT T1.GataNo
                            FROM lm_gata T1
                            WHERE T1.VillageCode = ?
                            AND T1.BoardApproved = ?
                            GROUP BY T1.GataNo
                            ORDER BY CAST(T1.GataNo AS FLOAT), T1.GataNo ASC
                            ");
            $sql->bindParam(1, $village_code);
            $sql->bindValue(2, 'YES');
        } else if ($user_type == '7') {
            $sql = $db->prepare("SELECT T1.GataNo
                            FROM lm_user_village_gata_mapping T1
                            LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo)
                            WHERE T1.VillageCode = ?
                            AND T1.UserID = ?
                            AND T2.BoardApproved = ?
                            GROUP BY T1.GataNo
                            ORDER BY CAST(T1.GataNo AS FLOAT), T1.GataNo ASC
                            ");
            $sql->bindParam(1, $village_code);
            $sql->bindParam(2, $user_id);
            $sql->bindValue(3, 'YES');
        } else if ($user_type == '9') {
            $sql = $db->prepare("SELECT T1.GataNo
                            FROM lm_gata T1
                            WHERE T1.VillageCode = ?
                            AND T1.BoardApproved = ?
                            GROUP BY T1.GataNo
                            ORDER BY CAST(T1.GataNo AS FLOAT), T1.GataNo ASC
                            ");
             $sql->bindParam(1, $village_code);
             $sql->bindValue(2, 'YES');
        }

        $sql->execute();
        $rowcount = $sql->rowCount();

        if ($rowcount == 0) {
            $data = array('status' => false, 'message' => 'No gata found for this village.');
        } else {
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            while ($row = $sql->fetch()) {
                $gataInfo[] = array("gataNo" => $row['GataNo']);
            }

            //Creating JSON
            $data = array('status' => true, 'message' => 'Gata', "gataInfo" => $gataInfo);
        }
    } else {
        //Creating JSON
        $data = array('status' => false, 'message' => 'Oops.. something went wrong.');
    }
    $data = removeEmptyValues($data);
    print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
}