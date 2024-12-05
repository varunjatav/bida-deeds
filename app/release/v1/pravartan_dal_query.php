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

    $user_id = __fi(validateInteger($_REQUEST['userid'], 'UserID'));
    $user_type = $_REQUEST['user_type'];
    $village_code = __fi(validateInteger($_REQUEST['village_code'], 'Village Code'));
    $gata_no = __fi(validateMaxLen($_REQUEST['gata_no'], 25, 'Gata No'));
    $khata_no = __fi(validateMaxLen($_REQUEST['khata_no'], 10, 'Khata No'));
    $gata_area = __fi(validateNumeric($_REQUEST['gata_area'], 'Gata Area No'));
    $data = $_REQUEST['data'];
    $timestamp = time();

    if ($user_id && $village_code && $gata_no && $khata_no && $user_type == '8') {

        try {
            // Begin Transaction
            $db->beginTransaction();

            $sql = $db->prepare("SELECT T1.ID, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.Area,  T1.PravartanDalQuery, T1.CreatedBy, T1.DateCreated, T1.EditDate
                                                  FROM lm_pravartan_dal_query T1
                                                  WHERE T1.VillageCode = ?
                                                  AND T1.GataNo = ?
                                                  AND T1.KhataNo = ?
                                                  AND BINARY T1.Area = ?
                                                  LIMIT 1
                                                ");
            $sql->bindParam(1, $village_code);
            $sql->bindParam(2, $gata_no);
            $sql->bindParam(3, $khata_no);
            $sql->bindParam(4, $gata_area);
            $sql->execute();
            $row_count = $sql->rowCount();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $row = $sql->fetch();

            try {
                
                $insrt = $db->prepare("INSERT INTO lm_pravartan_dal_query (VillageCode, GataNo, KhataNo, Area, PravartanDalQuery, CreatedBy, DateCreated) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $insrt->bindParam(1, $village_code);
                $insrt->bindParam(2, $gata_no);
                $insrt->bindParam(3, $khata_no);
                $insrt->bindParam(4, $gata_area);
                $insrt->bindParam(5, $data);
                $insrt->bindParam(6, $user_id);
                $insrt->bindParam(7, $timestamp);
                $insrt->execute(); 
                
            } catch (PDOException $ex) {
                if ($ex->getCode() == 23000) {
                    $updt = $db->prepare("UPDATE lm_pravartan_dal_query SET PravartanDalQuery = ?, EditDate = ? WHERE VillageCode = ? AND GataNo = ? AND KhataNo = ? AND BINARY Area = ?");
                    $updt->bindParam(1, $data);
                    $updt->bindParam(2, $timestamp);
                    $updt->bindParam(3, $village_code);
                    $updt->bindParam(4, $gata_no);
                    $updt->bindParam(5, $khata_no);
                    $updt->bindParam(6, $gata_area); 
                    $updt->execute();
                } else {
                    //Creating JSON
                    $data = array('status' => false, 'message' => 'Oops.. something went wrong.');
                    $data = removeEmptyValues($data);
                    print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
                }
            }

            if ($row_count > 0) {
                $insert = $db->prepare("INSERT INTO lm_pravartan_dal_query_history (PravartanID, VillageCode, GataNo, KhataNo, Area,  PravartanDalQuery, CreatedBy, DateCreated, EditDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $insert->bindParam(1, $row['ID']);
                $insert->bindParam(2, $row['VillageCode']);
                $insert->bindParam(3, $row['GataNo']);
                $insert->bindParam(4, $row['KhataNo']);
                $insert->bindParam(5, $row['Area']);
                $insert->bindParam(6, $row['PravartanDalQuery']);
                $insert->bindParam(7, $row['CreatedBy']);
                $insert->bindParam(8, $row['DateCreated']);
                $insert->bindParam(9, $row['EditDate']);
                $insert->execute();
            }

            // Make the changes to the database permanent
            $db_respose_data = array();

            // Make the changes to the database permanent
            $db->commit();

            // return response
            $data = array('status' => true, 'message' => 'Submitted successfully');
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