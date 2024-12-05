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
    $village_code = $_REQUEST['village_code'];

    if ($user_id && $user_type && $village_code) {

        if ($user_type == '1') {
            $sql = $db->prepare("SELECT T1.Mobile, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.OwnerName, T1.OwnerFather, T1.Ansh, T1.Area, T1.Attachment, T1.DateCreated
                                    FROM lm_kashtkar_sahmati T1
                                    LEFT JOIN lm_user_village_mapping T2 ON T2.VillageCode = T1.VillageCode
                                    WHERE T2.UserID = ?
                                    AND T1.VillageCode = ?
                                    ORDER BY T1.OwnerName ASC
                                    ");
        } else if ($user_type == '7') {
            $sql = $db->prepare("SELECT T1.Mobile, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.OwnerName, T1.OwnerFather, T1.Ansh, T1.Area, T1.Attachment, T1.DateCreated
                                FROM lm_kashtkar_sahmati T1
                                LEFT JOIN lm_user_village_gata_mapping T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo)
                                WHERE T2.UserID = ?
                                AND T1.VillageCode = ?
                                ORDER BY T1.OwnerName ASC
                                ");
        } else if ($user_type == '9') {
            $sql = $db->prepare("SELECT T1.Mobile, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.OwnerName, T1.OwnerFather, T1.Ansh, T1.Area, T1.Attachment, T1.DateCreated
                                FROM lm_kashtkar_sahmati T1
                                WHERE  T1.VillageCode = ?
                                ORDER BY T1.OwnerName ASC
                                ");
        }
        if ($user_type == '9'){
            $sql->bindParam(1, $village_code);
        } else {
        $sql->bindParam(1, $user_id);
        $sql->bindParam(2, $village_code);
        }
        $sql->execute();
        $rowcount = $sql->rowCount();

        if ($rowcount == 0) {
            $data = array('status' => false, 'message' => 'Data Not Found.');
        } else {
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            while ($row = $sql->fetch()) {
                if ($row['Attachment']){
                    $attachment = $main_path . '/' . $media_kashtkar_sahmati_path . '/' . $row['Attachment'];;
                } else {
                    $attachment = 'NA';
                }
                $sahmati[] = array("mobile" => $row['Mobile'], "villageCode" => $row['VillageCode'], "gataNo" => $row['GataNo'], "khataNo" => $row['KhataNo'], "ownerName" => $row['OwnerName'], "ownerFather" => $row['OwnerFather'], "ansh" => $row['Ansh'], "area" => $row['Area'], "attachment" => $attachment, "dateCreated" => date('d-m-Y', $row['DateCreated']));
            }

            //Creating JSON
            $data = array('status' => true, 'message' => 'Sahmati', "sahmatiInfo" => $sahmati);
        }
    } else {
        //Creating JSON
        $data = array('status' => false, 'message' => 'Oops.. something went wrong.');
    }
    $data = removeEmptyValues($data);
    print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
}