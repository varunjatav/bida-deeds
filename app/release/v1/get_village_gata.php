<?php

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

    if ($user_id && $village_code) {
         $gata_query = $db->prepare("SELECT T1.UID, T1.KhataNo, T1.GataNo, T1.Area
                                FROM lm_gata T1
                                WHERE T1.VillageCode = ?
                                AND T1.BoardApproved = ?
                                GROUP BY T1.KhataNo, T1.GataNo, T1.Area
                                ORDER BY CAST(T1.GataNo AS FLOAT), T1.GataNo ASC
                                ");
    $gata_query->bindParam(1, $village_code);
    $gata_query->bindValue(2, 'YES');
    $gata_query->execute();
    $rowcount = $gata_query->rowCount();

        if ($rowcount == 0) {
            $data = array('status' => false, 'message' => 'No gata found for this village.');
        } else { 
            $gata_query->setFetchMode(PDO::FETCH_ASSOC);
            while ($row = $gata_query->fetch()) {
                $gata = $row['GataNo'] . '-'  . '(' . 'Area: ' . $row['Area'] . ', Khata: ' . $row['KhataNo']. ')';
                $gata_no = $row['GataNo'];
                $area = $row['Area'];
                $khata_no = $row['KhataNo'];
                $gataInfo[] = array("text" =>  $gata, 'gataNo' => $gata_no, 'area' => $area, 'khataNo' => $khata_no);
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