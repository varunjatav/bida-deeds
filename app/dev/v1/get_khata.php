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
    $gata_no = $_REQUEST['gata_no'];

    if ($user_id && $village_code && $gata_no) {
        $sql = $db->prepare("SELECT T1.KhataNo
                            FROM lm_gata_kashtkar T1
                            WHERE T1.VillageCode = ?
                            AND T1.GataNo = ?
                            GROUP BY T1.KhataNo
                            ");
        $sql->bindParam(1, $village_code);
        $sql->bindParam(2, $gata_no);
        $sql->execute();
        $rowcount = $sql->rowCount();

        if ($rowcount == 0) {
            $data = array('status' => false, 'message' => 'No khata found for this village & gata.');
        } else {
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            while ($row = $sql->fetch()) {
                $khataInfo[] = array("khataNo" => $row['KhataNo']);
            }

            //Creating JSON
            $data = array('status' => true, 'message' => 'Khata', "khataInfo" => $khataInfo);
        }
    } else {
        //Creating JSON
        $data = array('status' => false, 'message' => 'Oops.. something went wrong.');
    }
    $data = removeEmptyValues($data);
    print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
}