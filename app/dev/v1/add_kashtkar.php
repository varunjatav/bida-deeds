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

    $user_id = __fi($_REQUEST['userid']);
    $village_code = __fi(validateInteger($_REQUEST['village_code'], 'Village Code'));
    $gata_no = __fi(validateMaxLen($_REQUEST['gata_no'], 25, 'Gata No'));
    $khata_no = __fi(validateMaxLen($_REQUEST['khata_no'], 10, 'Khata No'));
    $area = $_REQUEST['area'] ? __fi(validateNumeric($_REQUEST['area'], 'Area')) : 0;
    $kashtkar = __fi(validateMaxLen($_REQUEST['kashtkar'], 100, 'Kahstkar Name'));
    $kashtkar_father = __fi(validateMaxLen($_REQUEST['kashtkar_father'], 100, 'Kashtkar Father'));
    $timestamp = time();

    if ($user_id && $village_code && $gata_no && $khata_no && $kashtkar) {

        try {
            // Begin Transaction
            $db->beginTransaction();

            $village_query = $db->prepare("SELECT T1.UID, T1.KhataNo, T1.OwnerNo
                                            FROM lm_gata_kashtkar T1
                                            WHERE T1.VillageCode = ?
                                            AND T1.GataNo = ?
                                            AND T1.KhataNo = ?
                                            ORDER BY T1.OwnerNo DESC
                                            LIMIT 1
                                            ");
            $village_query->bindParam(1, $village_code);
            $village_query->bindParam(2, $gata_no);
            $village_query->bindParam(3, $khata_no);
            $village_query->execute();
            $village_query->setFetchMode(PDO::FETCH_ASSOC);
            $kashtkarInfo = $village_query->fetch();
            $uid = $kashtkarInfo['UID'];
            //$khata_no = $kashtkarInfo['KhataNo'];
            $last_owner_no = $kashtkarInfo['OwnerNo'] + 1;

            $insrt = $db->prepare("INSERT INTO lm_gata_kashtkar (UID, VillageCode, GataNo, KhataNo, OwnerNo, owner_name, owner_father, Area, CreatedBy) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insrt->bindParam(1, $uid);
            $insrt->bindParam(2, $village_code);
            $insrt->bindParam(3, $gata_no);
            $insrt->bindParam(4, $khata_no);
            $insrt->bindParam(5, $last_owner_no);
            $insrt->bindParam(6, $kashtkar);
            $insrt->bindParam(7, $kashtkar_father);
            $insrt->bindParam(8, $area);
            $insrt->bindParam(9, $user_id);
            $insrt->execute();

            // Make the changes to the database permanent
            $db_respose_data = array();

            // Make the changes to the database permanent
            $db->commit();

            // return response
            $data = array('status' => true, 'message' => 'Kashtkar added successfully');
        } catch (\Exception $e) {
            // return response
            $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
            rollback($db, $e->getCode(), $log_error_msg);
        }
    } else {
        //Creating JSON
        $data = array('status' => false, 'message' => 'Oops.. something went wrong.');
    }
    $data = removeEmptyValues($data);
    print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
}