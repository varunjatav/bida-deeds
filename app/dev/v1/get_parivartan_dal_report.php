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
    $count = 1;
    $village_code = $_REQUEST['village_code'];
    $gata_no = $_REQUEST['gata_no'];
    $khata_no = $_REQUEST['khata_no'];
    $gata_area = $_REQUEST['gata_area'];
    $user_type = $_REQUEST['user_type'];

    if ($user_id && $village_code && $gata_no && $khata_no && $gata_area && $user_type == '8') {

        $village_query = $db->prepare("SELECT T1.parisampatti_name, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE T1.VillageCode = ?
                                AND T1.GataNo = ?
                                AND T1.KhataNo = ?
                                AND ROUND(CAST(T1.Area AS FLOAT), 4) = ?
                                LIMIT 1
                                ");
        $village_query->bindParam(1, $village_code);
        $village_query->bindParam(2, $gata_no);
        $village_query->bindParam(3, $khata_no);
        $village_query->bindParam(4, $gata_area);
        $village_query->execute();
        $village_query->setFetchMode(PDO::FETCH_ASSOC);
        $village_count = $village_query->rowCount();
        $gataInfo = $village_query->fetch();

        $chakbandi_query = $db->prepare("SELECT T1.*, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE T1.VillageCode = ?
                                AND CAST(ch41_45_ke_anusar_rakba AS FLOAT) > ?
                                LIMIT 1
                                ");
        $chakbandi_query->bindParam(1, $village_code);
        $chakbandi_query->bindValue(2, 0);
        $chakbandi_query->execute();
        $chakbandi_query->setFetchMode(PDO::FETCH_ASSOC);
        $chakbandi_status = $chakbandi_query->rowCount();

        if ($village_count > 0) {

            $answer_29 = '';

            if ($gataInfo['parisampatti_name'] && $gataInfo['parisampatti_name'] != '--') {
                $answer_29 = explode(',', $gataInfo['parisampatti_name']);
            } else {
                $answer_29 = '';
            }

            // Define dynamic questions and answers
            $reports = [
                "color" => "",
                "tab" => "क्रo सo " . $count++,
                'villageName' => $gataInfo['VillageName'],
                "question" => "गाटा पर परिसम्पत्तियाँ क्या-क्या है?",
                "result" => $answer_29,
                "description" => ""
            ];

            $data = array('status' => true, 'message' => 'Data Fetched Successfully', 'reports' => $reports);
        } else {
            $data = array('status' => false, 'message' => 'Data Not Found');
        }
    } else {
        //Creating JSON
        $data = array('status' => false, 'message' => 'Oops.. something went wrong.');
    }
    $data = removeEmptyValues($data);
    print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
}
