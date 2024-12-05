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
    $owner_no = __fi(validateInteger($_REQUEST['owner_no'], 'Owner No'));
    $owner_name = __fi(validateMaxLen($_REQUEST['owner_name'], 100, 'Owner Name'));
    $owner_father = __fi(validateMaxLen($_REQUEST['owner_father'], 100, 'Owner Father'));
    $type = __fi(validateInteger($_REQUEST['type'], 'Type'));
    $sub_type = $_REQUEST['subtype'] ? __fi(validateInteger($_REQUEST['subtype'], 'Sub Type')) : 0;
    $option = __fi(validateInteger($_REQUEST['option'], 'Option'));
    $ansh = __fi(validateMaxLen($_REQUEST['ansh'], 15, 'Ansh'));
    $rakba = $_REQUEST['rakba'] ? __fi(validateNumeric($_REQUEST['rakba'], 'Rakba')) : 0;
    $date = $_REQUEST['date'] ? strtotime(__fi(validateDDMMYYYY($_REQUEST['date'], 'Date'))) : 0;
    $remarks = $_REQUEST['remarks'] ? __fi(validateMaxLen($_REQUEST['remarks'], 255, 'Remarks')) : '';
    $timestamp = time();
    $allowed_ext = array("jpg", "png", "jpeg", "pdf"); // allowed extension
    $target_dir = dirname(dirname(dirname(dirname(__FILE__)))) . "/" . $media_lekhpal_ebasta_path . "/";

    if ($user_id && $village_code && $gata_no && $khata_no && $owner_no && $owner_name && $type && $option) {

        try {
            // Begin Transaction
            $db->beginTransaction();

            if ($_FILES['images']['size']) {
                // validate attachments
                validate_attachments($_FILES['images'], $allowed_ext);

                // copy attachments to folder
                $imageArray = upload_attachments($_FILES['images'], $target_dir, 209600, $allowed_ext, 'ebasta', $user_id, 1024, 768, 95);
                $actual_image_name = $imageArray[0];
            }

            try {
                $insrt = $db->prepare("INSERT INTO lm_lekhpal_ebasta (VillageCode, GataNo, KhataNo, OwnerNo, owner_name, owner_father, Type, Subtype, Options, Ansh, Rakba, AnshDate, Attachment, Remarks, DateCreated, CreatedBy) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $insrt->bindParam(1, $village_code);
                $insrt->bindParam(2, $gata_no);
                $insrt->bindParam(3, $khata_no);
                $insrt->bindParam(4, $owner_no);
                $insrt->bindParam(5, $owner_name);
                $insrt->bindParam(6, $owner_father);
                $insrt->bindParam(7, $type);
                $insrt->bindParam(8, $sub_type);
                $insrt->bindParam(9, $option);
                $insrt->bindParam(10, $ansh);
                $insrt->bindParam(11, $rakba);
                $insrt->bindValue(12, $date);
                $insrt->bindParam(13, $actual_image_name);
                $insrt->bindParam(14, $remarks);
                $insrt->bindParam(15, $timestamp);
                $insrt->bindParam(16, $user_id);
                $insrt->execute();
            } catch (PDOException $ex) {
                if ($ex->getCode() == 23000) {
                    $updt = $db->prepare("UPDATE lm_lekhpal_ebasta SET Subtype = ?, Options = ?, Ansh = ?, Rakba = ?, AnshDate = ?, Attachment = ?, Remarks = ?, DateCreated = ?, CreatedBy = ? WHERE VillageCode = ? AND GataNo = ? AND KhataNo = ? AND OwnerNo = ? AND owner_name = ? AND owner_father = ? AND Type = ?");
                    $updt->bindParam(1, $sub_type);
                    $updt->bindParam(2, $option);
                    $updt->bindParam(3, $ansh);
                    $updt->bindParam(4, $rakba);
                    $updt->bindParam(5, $date);
                    $updt->bindParam(6, $actual_image_name);
                    $updt->bindParam(7, $remarks);
                    $updt->bindParam(8, $timestamp);
                    $updt->bindParam(9, $user_id);
                    $updt->bindParam(10, $village_code);
                    $updt->bindParam(11, $gata_no);
                    $updt->bindParam(12, $khata_no);
                    $updt->bindParam(13, $owner_no);
                    $updt->bindParam(14, $owner_name);
                    $updt->bindParam(15, $owner_father);
                    $updt->bindParam(16, $type);
                    $updt->execute();
                } else {
                    //Creating JSON
                    $data = array('status' => false, 'message' => 'Oops.. something went wrong.');
                    $data = removeEmptyValues($data);
                    print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
                }
            }

            $insrt = $db->prepare("INSERT INTO lm_lekhpal_ebasta_history (VillageCode, GataNo, KhataNo, OwnerNo, owner_name, owner_father, Type, Subtype, Options, Ansh, Rakba, AnshDate, Attachment, Remarks, DateCreated, CreatedBy) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insrt->bindParam(1, $village_code);
            $insrt->bindParam(2, $gata_no);
            $insrt->bindParam(3, $khata_no);
            $insrt->bindParam(4, $owner_no);
            $insrt->bindParam(5, $owner_name);
            $insrt->bindParam(6, $owner_father);
            $insrt->bindParam(7, $type);
            $insrt->bindParam(8, $sub_type);
            $insrt->bindParam(9, $option);
            $insrt->bindParam(10, $ansh);
            $insrt->bindParam(11, $rakba);
            $insrt->bindValue(12, $date);
            $insrt->bindParam(13, $actual_image_name);
            $insrt->bindParam(14, $remarks);
            $insrt->bindParam(15, $timestamp);
            $insrt->bindParam(16, $user_id);
            $insrt->execute();

            // Make the changes to the database permanent
            $db_respose_data = array();

            // Make the changes to the database permanent
            $db->commit();

            // return response
            $data = array('status' => true, 'message' => 'E-basta updated successfully');
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