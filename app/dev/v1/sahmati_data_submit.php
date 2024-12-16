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
    $user_type = __fi(validateInteger($_REQUEST['user_type'], 'User Type'));
    $village_code = __fi(validateInteger($_REQUEST['village_code'], 'Village Code'));
    $gata_no = __fi(validateMaxLen($_REQUEST['gata_no'], 25, 'Gata No'));
    $khata_no = __fi(validateMaxLen($_REQUEST['khata_no'], 10, 'Khata No'));
    $is_bhandhak_bhumi = $_REQUEST['is_bhandhak_bhumi'] ? __fi(validateMaxLen($_REQUEST['is_bhandhak_bhumi'], 20, 'Is Bandhak Bhumi')) : '';
    $owner_name = __fi(validateMaxLen($_REQUEST['owner_name'], 100, 'Owner Name'));
    $owner_father = __fi(validateMaxLen($_REQUEST['owner_father'], 100, 'Owner Father'));
    $gata_dar_nirdharn = $_REQUEST['gata_dar_nirdharn'] ?__fi(validateMaxLen($_REQUEST['gata_dar_nirdharn'], 20, 'Gata Dar Nirdharn')) : '';
    $kashtkar_category = $_REQUEST['kashtkar_category'] ? __fi(validateMaxLen($_REQUEST['kashtkar_category'], 45, 'Kashtkar Category')) : '';
    $mobile = $_REQUEST['mobile'] ? __fi(validateMobile($_REQUEST['mobile'])) : '';
    $pan = $_REQUEST['pan'] ? __fi($_REQUEST['pan']) : '';
    $aadhar = $_REQUEST['aadhar'] ? __fi($_REQUEST['aadhar']) : '';
    $shear_ansh = $_REQUEST['shear_ansh'] ? __fi(validateNumeric($_REQUEST['shear_ansh'], 'Shear Ansh')) : 0;
    $ans_rakba = $_REQUEST['ans_rakba'] ? __fi(validateNumeric($_REQUEST['ans_rakba'], 'Ans Rakba')) : 0;
    $bhaumic_adhikar_shrot = $_REQUEST['bhaumic_adhikar_shrot'] ? __fi(validateMaxLen($_REQUEST['bhaumic_adhikar_shrot'], 200, 'Bhaumic Adhikar Shrot')) : '';
    $Muhal_name = $_REQUEST['Muhal_name'] ?  __fi(validateMaxLen($_REQUEST['Muhal_name'], 100, 'Muhal Name')) : '';
    $Land_gata =  $_REQUEST['land_gata'] ? __fi(validateMaxLen($_REQUEST['land_gata'], 45, 'Land Gata')) : '';
    $land_khata = $_REQUEST['land_khata'] ? __fi(validateMaxLen($_REQUEST['land_khata'], 10, 'Land Khata')) : '';
    $anusar_1359_shreni = $_REQUEST['1359_anusar_shreni'] ?  __fi(validateMaxLen($_REQUEST['1359_anusar_shreni'], 500, '1359 Anusar Shreni')) : '';
    $Is_bandhak_bhumi_kashtkar = $_REQUEST['is_bandhak_bhumi_kashtkar'] ? __fi(validateMaxLen($_REQUEST['is_bandhak_bhumi_kashtkar'], 10, 'Is Bandhak Bhumi Kashtkar')) : '';
    $bank_name =  $_REQUEST['bank_name'] ? __fi(validateMaxLen($_REQUEST['bank_name'], 100, 'Bank Name')) : '';
    $account_no =  $_REQUEST['account_no'] ? __fi(validateMaxLen($_REQUEST['account_no'], 25, 'Account No')) : '';
    $anusar_4145_shreni =  $_REQUEST['4145_anusar_shreni'] ? __fi(validateMaxLen($_REQUEST['4145_anusar_shreni'], 100, '4145 Anusar Shreni ')) : '';
    $Poorv = $_REQUEST['Poorv'] ? __fi($_REQUEST['Poorv']) : '';
    $Pashchim = $_REQUEST['Pashchim'] ? __fi($_REQUEST['Pashchim']) : '';
    $Uttar =  $_REQUEST['Uttar'] ? __fi($_REQUEST['Uttar']) : '';
    $Dakshin =  $_REQUEST['Dakshin'] ? __fi($_REQUEST['Dakshin']) : '';
    $passbook =  $_FILES['passbook_file'] ? $_FILES['passbook_file'] : '';
    $ans_nirdharn_sajra_file =  $_FILES['ans_nirdharn_sajra_file'] ? $_FILES['ans_nirdharn_sajra_file'] : '';
    $sahmati_file =  $_FILES['sahmati_file'] ? $_FILES['sahmati_file'] : '';
    $kastkar_photo = $_FILES['kastkar_photo'] ? $_FILES['kastkar_photo'] : '';
    $patrawali_file = $_FILES['patrawali_file'] ? $_FILES['patrawali_file'] : '';
    $timestamp = time();
    $allowed_ext = array("jpg", "png", "jpeg", "pdf"); // allowed extension
    $passbook_file_target_dir = dirname(dirname(dirname(dirname(__FILE__)))) . "/" . $media_passbook_file_path . "/";
    $sahmati_file_target_dir = dirname(dirname(dirname(dirname(__FILE__)))) . "/" . $media_sahmati_file_path . "/";
    $kastkar_photo_target_dir = dirname(dirname(dirname(dirname(__FILE__)))) . "/" . $media_kastkar_photo_path . "/";
    $ans_sijra_file_target_dir = dirname(dirname(dirname(dirname(__FILE__)))) . "/" . $media_ans_sijra_file_path . "/";
    $patrawali_file_target_dir = dirname(dirname(dirname(dirname(__FILE__)))) . "/" . $media_patrawali_file_path . "/";
    
    if ($user_id && $village_code && $gata_no && $khata_no && $owner_father && $owner_name && $Land_gata && $land_khata && $user_type == 7) {

        try {
            // Begin Transaction
            $db->beginTransaction();
            
//            if (!empty($aadhar)) {
//            $valid = aadharValidation($aadhar);
//            if ($valid == 0) {
//                $db_respose_data = json_encode(array('status' => false, 'message' => 'Invalid aadhar card number.'));
//                   print_r($db_respose_data);
//                exit();
//            }
//        }
//        if (!empty($pan)) {
//            $valid = panValidation($pan);
//            if ($valid == 0) {
//                $db_respose_data = json_encode(array('status' => false, 'message' => 'Invalid pan card number.'));
//                print_r($db_respose_data);
//                exit();
//            }
//        }

            // passbook image file
            if ($passbook) {
                // validate attachments
                validate_attachments($passbook, $allowed_ext);

                // copy attachments to folder
                $passbookArray = upload_attachments($passbook, $passbook_file_target_dir, 209600, $allowed_ext, 'passbook_file', $user_id, 1024, 768, 95);
                $passbook_image_name = $passbookArray[0];
            }

            // sahmati file
            if ($sahmati_file) {
                // validate attachments
                validate_attachments($sahmati_file, $allowed_ext);

                // copy attachments to folder
                $sahmati_fileArray = upload_attachments($sahmati_file, $sahmati_file_target_dir, 209600, $allowed_ext, 'sahmati_file', $user_id, 1024, 768, 95);
                $sahmati_file_name = $sahmati_fileArray[0];
            }
            // kastkar photo
            if ($kastkar_photo) {
                // validate attachments
                validate_attachments($kastkar_photo, $allowed_ext);

                // copy attachments to folder
                $kastkar_photoArray = upload_attachments($kastkar_photo, $kastkar_photo_target_dir, 209600, $allowed_ext, 'kastkar_photo', $user_id, 1024, 768, 95);
                 $kastkar_photo_name = $kastkar_photoArray[0];
            }

            // ans nirdharn sajra file
            if ($ans_nirdharn_sajra_file) {
                // validate attachments
                validate_attachments($ans_nirdharn_sajra_file, $allowed_ext);

                // copy attachments to folder
                $ans_nirdharn_sajra_fileArray = upload_attachments($ans_nirdharn_sajra_file, $ans_sijra_file_target_dir, 209600, $allowed_ext, 'ans_nirdharn_sajra_file', $user_id, 1024, 768, 95);
                  $ans_nirdharn_sajra_file_name = $ans_nirdharn_sajra_fileArray[0];
            }
            
            // patrawali file
            if ($patrawali_file) {
                // validate attachments
                validate_attachments($patrawali_file, $allowed_ext);

                // copy attachments to folder
                $patrawali_fileArray = upload_attachments($patrawali_file, $patrawali_file_target_dir, 209600, $allowed_ext, 'patrawali_file', $user_id, 1024, 768, 95);
                  $patrawali_file_name = $patrawali_fileArray[0];
            }
            try {
                $insrt = $db->prepare("INSERT INTO lm_kastkar_sahmati (VillageCode, GataNo, KhataNo, Kastkar_name, Kastkar_father_name, Is_bandhak_bhumi, Is_gata_dar_nirdharrn, Kashtkar_category, MobileNo, PanNo, AadharNo, Ans_rakba, shear_ansh, Bhaumic_adhikar_shrot, Muhal_name, Land_gata, Land_Khata, 1359_anusar_shreni, Is_bandhak_bhumi_kashtkar,  BankName,  AccountNo,  4145_anusar_shreni, DateCreated, CreatedBy) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $insrt->bindParam(1, $village_code);
                $insrt->bindParam(2, $gata_no);
                $insrt->bindParam(3, $khata_no);
                $insrt->bindParam(4, $owner_name);
                $insrt->bindParam(5, $owner_father);
                $insrt->bindParam(6, $is_bhandhak_bhumi);
                $insrt->bindParam(7, $gata_dar_nirdharn);
                $insrt->bindParam(8, $kashtkar_category);
                $insrt->bindParam(9, $mobile);
                $insrt->bindParam(10, $pan);
                $insrt->bindParam(11, $aadhar);
                $insrt->bindValue(12, $ans_rakba);
                $insrt->bindParam(13, $shear_ansh);
                $insrt->bindParam(14, $bhaumic_adhikar_shrot);
                $insrt->bindParam(15, $Muhal_name);
                $insrt->bindParam(16, $Land_gata);
                $insrt->bindParam(17, $land_khata);
                $insrt->bindParam(18, $anusar_1359_shreni);
                $insrt->bindParam(19, $Is_bandhak_bhumi_kashtkar);
                $insrt->bindParam(20, $bank_name);
                $insrt->bindParam(21, $account_no);
                $insrt->bindParam(22, $anusar_4145_shreni);
                $insrt->bindParam(23, $timestamp);
                $insrt->bindParam(24, $user_id);
                $insrt->execute();

                $sahmati_id = $db->lastInsertId();

                $insrt1 = $db->prepare("INSERT INTO  lm_rtk_muhal_gata_mapping_data (SahmatiID, VillageCode, GataNo, KhataNo, Kastkar_name, Kastkar_father_name, Is_bandhak_bhumi, Muhal_name, Land_gata, Land_Khata, 1359_anusar_shreni) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $insrt1->bindParam(1, $sahmati_id);
                $insrt1->bindParam(2, $village_code);
                $insrt1->bindParam(3, $gata_no);
                $insrt1->bindParam(4, $khata_no);
                $insrt1->bindParam(5, $owner_name);
                $insrt1->bindParam(6, $owner_father);
                $insrt1->bindParam(7, $is_bhandhak_bhumi);
                $insrt1->bindParam(8, $Muhal_name);
                $insrt1->bindParam(9, $Land_gata);
                $insrt1->bindParam(10, $land_khata);
                $insrt1->bindParam(11, $anusar_1359_shreni);
                $insrt1->execute();

                $insrt2 = $db->prepare("INSERT INTO  lm_gata_chauhaddi_data (SahmatiID, Poorv, Pashchim, Uttar,  Dakshin) VALUES (?, ?, ?, ?, ?)");
                $insrt2->bindParam(1, $sahmati_id);
                $insrt2->bindParam(2, $Poorv);
                $insrt2->bindParam(3, $Pashchim);
                $insrt2->bindParam(4, $Uttar);
                $insrt2->bindParam(5, $Dakshin);
                $insrt2->execute();

                // passbook file insert
                if ($passbook) {
                  //  foreach ($passbookArray as $pkey => $pitem) {
                        $insrt = $db->prepare("INSERT INTO   lm_kashtkar_passbook_document(SahmatiID, file) VALUES (?, ?)");
                        $insrt->bindParam(1, $sahmati_id);
                        $insrt->bindParam(2, $passbook_image_name);
                        $insrt->execute();
                   // }
                }
                // sahmati file insert
                if ($sahmati_file) {
                   // foreach ($sahmati_fileArray as $skey => $sitem) {
                        $insrt = $db->prepare("INSERT INTO  lm_kashtkar_sahmati_document (SahmatiID, file) VALUES (?, ?)");
                        $insrt->bindParam(1, $sahmati_id);
                        $insrt->bindParam(2, $sahmati_file_name);
                        $insrt->execute();
                  //  }
                }

                // kastkar photo insert
                if ($kastkar_photo) {
                  //  foreach ($kastkar_photoArray as $kkey => $kitem) {
                        $insrt = $db->prepare("INSERT INTO   lm_kashtkar_photo_document (SahmatiID, file) VALUES (?, ?)");
                        $insrt->bindParam(1, $sahmati_id);
                        $insrt->bindParam(2, $kastkar_photo_name);
                        $insrt->execute();
                  //  }
                }

                // ans nirdharn sijra
                if ($ans_nirdharn_sajra_file) {
                   // foreach ($ans_nirdharn_sajra_fileArray as $akey => $aitem) {
                        $insrt = $db->prepare("INSERT INTO   lm_ans_nirdharn_shajra_document (SahmatiID, file) VALUES (?, ?)");
                        $insrt->bindParam(1, $sahmati_id);
                        $insrt->bindParam(2, $ans_nirdharn_sajra_file_name);
                        $insrt->execute();
                  //  }
                }
                  // patrawali file
                if ($patrawali_file) {
                   // foreach ($patrawali_fileArray as $ptkey => $ptitem) {
                        $insrt = $db->prepare("INSERT INTO   lm_patrawali_document (SahmatiID, file) VALUES (?, ?)");
                        $insrt->bindParam(1, $sahmati_id);
                        $insrt->bindParam(2, $patrawali_file_name);
                        $insrt->execute();
                  //  }
                }
            } catch (PDOException $ex) {
                if ($ex->getCode() == 23000) {
                    
                } else {
                    //Creating JSON
                    $data = array('status' => false, 'message' => 'Oops.. something went wrong.');
                    $data = removeEmptyValues($data);
                    print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
                }
            }

            // Make the changes to the database permanent
            $db_respose_data = array();

            // Make the changes to the database permanent
            $db->commit();

            // return response
            $data = array('status' => true, 'message' => 'Sahmati submitted successfully');
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