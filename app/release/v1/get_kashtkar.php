<?php

error_reporting(0);
ini_set('precision', 10);
ini_set('serialize_precision', 10);
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
    $gata_no = $_REQUEST['gata_no'];
    $khata_no = $_REQUEST['khata_no'];

    if ($user_id && $village_code && $gata_no && $khata_no) {
        $sql = $db->prepare("SELECT T1.OwnerNo, T1.owner_name, T1.owner_father, T1.Area
                                FROM lm_gata_kashtkar T1
                                WHERE T1.VillageCode = ?
                                AND T1.GataNo = ?
                                AND T1.KhataNo = ?
                            ");
        $sql->bindParam(1, $village_code);
        $sql->bindParam(2, $gata_no);
        $sql->bindParam(3, $khata_no);
        $sql->execute();
        $rowcount = $sql->rowCount();

        if ($rowcount == 0) {
            $data = array('status' => false, 'message' => 'No kashtkar found for this village, gata & khata.');
        } else {
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            while ($row = $sql->fetch()) {
                $kashtkarInfo[] = array("ownerNo" => $row['OwnerNo'], "ownerName" => $row['owner_name'], "ownerFather" => $row['owner_father'], "area" => $row['Area']);
            }

            //Creating JSON
            $data = array('status' => true, 'message' => 'Kashtkar', "kashtkarInfo" => $kashtkarInfo);
        }
    } else {
        //Creating JSON
        $data = array('status' => false, 'message' => 'Oops.. something went wrong.');
    }
    $data = removeEmptyValues($data);
    print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
}