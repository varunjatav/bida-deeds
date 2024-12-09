<?php

ini_set('memory_limit', '-1');
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once "../functions/insert_queue.function.php";
include_once "../functions/notification.function.php";
include_once "../vendor/autoload.php";

// ini_set('display_errors', 1);

// error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

use PhpOffice\PhpSpreadsheet\Spreadsheet;

$user_id = $_SESSION['UserID'];
if (isset($_POST['action']) && $_POST['action'] == 'edit_master_details') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $shreni_4145 = $_POST['shreni_4145'] ? __fi(validateMaxLen($_POST['shreni_4145'], 45)) : "";
        $original_gata_fasli_khatauni_1359 = $_POST['original_gata_fasli_khatauni_1359'] ? __fi(validateMaxLen($_POST['original_gata_fasli_khatauni_1359'], 45)) : "";
        $rakba_4145 = $_POST['rakba_4145'] ? __fi(validateMaxLen($_POST['rakba_4145'], 25)) : '';
        $shreni_1359 = $_POST['shreni_1359'] ? __fi(validateMaxLen($_POST['shreni_1359'], 255)) : "";
        $rakba_1359 = $_POST['rakba_1359'] ? __fi(validateMaxLen($_POST['rakba_1359'], 25)) : '';
        $fasli_kism = $_POST['fasli_kism'] ? __fi(validateMaxLen($_POST['fasli_kism'], 255)) : '';
        $address = __fi($_POST['kastkar_status']);
        $lm_file_id = __fi(validateInteger(decryptIt(myUrlEncode($_POST['file_id'])), 'File ID'));
        $timestamp = time();
        $created_by = $_SESSION['UserID'];

        $updt = $db->prepare("UPDATE  lm_gata  SET ch41_45_ke_anusar_sreni = ?, ch41_45_ke_anusar_rakba = ?, fasali_ke_anusar_sreni = ?, fasali_ke_anusar_rakba = ?, khate_me_fasali_ke_anusar_kism = ?, fasali_me_kastkar_darj_status = ?, updated_by = ?,  updated_date = ?, 1359_phasalee_khataunee_mein_mool_gaata = ? WHERE ID = ?");
        $updt->bindParam(1, $shreni_4145);
        $updt->bindParam(2, $rakba_4145);
        $updt->bindParam(3, $shreni_1359);
        $updt->bindParam(4, $rakba_1359);
        $updt->bindParam(5, $fasli_kism);
        $updt->bindParam(6, $kastkar_status);
        $updt->bindParam(7, $created_by);
        $updt->bindParam(8, $timestamp);
        $updt->bindParam(9, $original_gata_fasli_khatauni_1359);
        $updt->bindParam(10, $lm_file_id);
        $updt->execute();

        // Make the changes to the database permanent
        $db_respose_data = array();
        // Make the changes to the database permanent
        commit($db, 'Updated successfully', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} elseif (isset($_POST['action']) && $_POST['action'] == 'tehsildar_validate') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // Check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $tehsildar_validate_status = '1';
        $lm_file_id = __fi(validateInteger(decryptIt(myUrlEncode($_POST['file_id'])), 'File ID'));
        $timestamp = time();
        $created_by = $_SESSION['UserID'];

        $updt = $db->prepare("UPDATE lm_gata SET tehsildar_validate_status = ?, updated_by = ?, updated_date = ? WHERE ID = ?");
        $updt->bindParam(1, $tehsildar_validate_status);
        $updt->bindParam(2, $created_by);
        $updt->bindParam(3, $timestamp);
        $updt->bindParam(4, $lm_file_id);
        $updt->execute();

        // Prepare response data
        $db_respose_data = array();

        // Make the changes to the database permanent
        commit($db, 'Validate successfully', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // Log error and return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} elseif (isset($_POST['action']) && $_POST['action'] == 'change_language') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $_SESSION['Lng'] = $_POST['lng'];

        // Make the changes to the database permanent
        $db_respose_data = array();
        // Make the changes to the database permanent
        commit($db, '', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} elseif (isset($_POST['action']) && $_POST['action'] == 'upload_perman_patr') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // Check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $validate_status = '1';
        $lm_file_id = __fi(validateInteger(decryptIt(myUrlEncode($_POST['file_id'])), 'Village ID'));
        $viilage_code = __fi(validateInteger(decryptIt(myUrlEncode($_POST['viilage_code'])), 'Village Code'));
        $timestamp = time();
        $created_by = $_SESSION['UserID'];
        $target_dir_image = dirname(dirname(__FILE__)) . "/" . $media_village_certificate_path . "/";

        $allowed_ext = array("pdf", "PDF", 'JPG', 'jpg', 'PNG', 'DOCX', 'docx', 'DOC', 'doc', 'jpeg', 'JPEG'); // allowed extension

        if (is_uploaded_file($_FILES['order_file']['tmp_name'])) {

            $name = $_FILES['order_file']['name'];
            $ext = strtolower(end(explode('.', $name)));

            if (!in_array($ext, $allowed_ext)) {
                // return response
                $db_respose_data = json_encode(array('status' => '-1', 'message' => 'Attached file type not allowed.'));
                print_r($db_respose_data);
                exit();
            }
        }

        /** image move to folder  * */
        if (is_uploaded_file($_FILES['order_file']['tmp_name']) && !empty($_FILES['order_file']['tmp_name'])) {
            $name = $_FILES['order_file']['name'];
            $tmpfile = $_FILES['order_file']['tmp_name'];
            $path = $target_dir_image;

            if (strlen($name)) {

                $ext = strtolower(end(explode('.', $name)));
                $orig_file_size = filesize($tmpfile);

                // rename image
                $name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $name);
                $rand_1 = rand(9999, 9999999);
                $rand_2 = rand(9999999, 9999999999);
                $rand_3 = rand();
                $rename_image = strtolower(str_replace(' ', '', 'village_certificate' . '' . $orig_file_size . '' . time() . '' . $rand_1 . '' . $rand_2 . '_' . $rand_3));
                $actual_document_name = $rename_image . "." . $ext;
                $target_file = $path . '/' . $actual_document_name;

                // upload videos from client to server in chunks
                $chunk_size = 1024; // chunk in bytes
                $upload_start = 0;
                $handle = fopen($tmpfile, "rb");
                $fp = fopen($target_file, 'w');

                while ($upload_start < $orig_file_size) {
                    $contents = fread($handle, $chunk_size);
                    fwrite($fp, $contents);
                    $upload_start += strlen($contents);
                    fseek($handle, $upload_start);
                }

                fclose($handle);
                fclose($fp);
                unlink($tmpfile);
            }
        }
        try {
            $insrt = $db->prepare("INSERT INTO  lm_upload_village_certificate (VillageID, VillageCode, Attachment, UploadBy, UploadDate) VALUES (?, ?, ?, ?, ?)");
            $insrt->bindParam(1, $lm_file_id);
            $insrt->bindParam(2, $viilage_code);
            $insrt->bindParam(3, $actual_document_name);
            $insrt->bindParam(4, $created_by);
            $insrt->bindParam(5, $timestamp);
            $insrt->execute();
        } catch (PDOException $ex) {
            if ($ex->getCode() == 23000) {
                $updt = $db->prepare("UPDATE lm_upload_village_certificate SET Attachment = ?, UploadBy = ?, UploadDate = ? WHERE VillageCode = ? AND VillageID = ? ");
                $updt->bindParam(1, $actual_document_name);
                $updt->bindParam(2, $created_by);
                $updt->bindParam(3, $timestamp);
                $updt->bindParam(4, $viilage_code);
                $updt->bindParam(5, $lm_file_id);
                $updt->execute();
            }
        }

        $updt = $db->prepare("UPDATE  lm_village SET VerifiedStatus = ?,  DateEdited = ? WHERE ID = ?");
        $updt->bindParam(1, $validate_status);
        $updt->bindParam(2, $timestamp);
        $updt->bindParam(3, $lm_file_id);
        $updt->execute();

        // Prepare response data
        $db_respose_data = array();

        // Make the changes to the database permanent
        commit($db, 'Certificate upload successfully', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // Log error and return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} elseif (isset($_POST['action']) && $_POST['action'] == 'add_user_data') {

    try {
        // Begin Transaction
        $db->beginTransaction();

        // Check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $name = __fi(validateMaxLen($_POST['name'], 'Name', 8));
        $user_name = __fi(validateMaxLen($_POST['user_name'], 'User Name', 25));
        $email = __fi(validateMaxLen($_POST['email'], 'Email', 45));
        $mobile_no = __fi(validateMaxLen($_POST['mobile_no'], 'Mobile no', 10));
        $designation = __fi(validateMaxLen($_POST['designation'], 'Designation', 10));
        $address = __fi(validateMaxLen($_POST['address'], 'Address', 50));
        $gender = __fi(validateMaxLen($_POST['gender'], 'Gender', 10));
        $password = __fi(validateMaxLen($_POST['password'], 'Password', 20));
        $c_password = __fi(validateMaxLen($_POST['cpassword'], 'Confirm Password', 20));

        echo $name;
        // $gata_no = $_POST['gata_no'];

        // if (count_($gata_no) == 0) {
        //     // return response
        //     $db_respose_data = json_encode(array('status' => '-1', 'message' => 'Please add atleast one gata'));
        //     print_r($db_respose_data);
        //     exit();
        // }
        $timestamp = time();
        $created_by = $_SESSION['UserID'];
        //$name = generate_unique_id($db, 'user_info', 'UniqueID', 1, 6); // Generate unique code per iteration

        $insrt1 = $db->prepare("INSERT INTO  user_info  (Name, User_Name, Email, Mobile_No, Designation, Address, Gender, Password, Confirm_Password) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?)");
        $insrt1->bindParam(1, $name);
        $insrt1->bindParam(2, $user_name);
        $insrt1->bindParam(3, $email);
        $insrt1->bindParam(4, $mobile_no);
        $insrt1->bindParam(5, $designation);
        $insrt1->bindParam(6, $address);
        $insrt1->bindParam(7, $gender);
        $insrt1->bindParam(8, $password);
        $insrt1->bindParam(9, $c_password);
        // $insrt1->bindParam(10, $timestamp);
        // $insrt1->bindParam(11, $created_by);
        $insrt1->execute();

        // $data_id = $db->lastInsertId();

 
        $db_response_data = array();
        commit($db, 'User data added successfully', $db_response_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'edit_user_data') {
    print_r ($_POST);
    exit();

    try {
        // Begin Transaction
        $db->beginTransaction();

        // Check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }
        $id = __fi(validateInteger(decryptIt($_POST['id']), 'ID'));
        $name = __fi(validateMaxLen($_POST['name'], 'Name', 100));
        $user_name = __fi(validateMaxLen($_POST['user_name'], 'User_Name', 100));
        $email = __fi(validateMaxLen($_POST['email'], 'Email', 100));
        $password = __fi(validateMaxLen($_POST['password'], 'Password', 100));
        $c_password = __fi(validateMaxLen($_POST['confirm_password'], 'Confirm_Password', 100));
        $mobile_no = __fi(validateMaxLen($_POST['mobile_no'], 'Mobile_NO', 10));
        $designation = __fi(validateMaxLen($_POST['designation'], 'Designation', 100));
        $address =  __fi(validateMaxLen($_POST['address'], 'Address', 100));
        $gender =  __fi(validateMaxLen($_POST['gender'], 'Gender', 10));
        $timestamp = time();
        $created_by = $_SESSION['UserID'];

        echo $id;
        echo $name;

        $update1 = $db->prepare("UPDATE user_info SET Name = ?, User_Name = ?, Email = ?, PASSWORD = ?, Confirm_Password = ? , Mobile_No =?,Designation = ?,Address = ?, Gender = ? FROM user_info WHERE ID = ?");
        $update1->bindParam(1, $name);
        $update1->bindParam(2, $user_name);
        $update1->bindParam(3, $email);
        $update1->bindParam(4, $password);
        $update1->bindParam(5, $c_password);
        $update1->bindParam(6, $mobile_no);
        $update1->bindParam(7, $designation);
        $update1->bindParam(8, $address);
        $update1->bindParam(9, $gender);
        $update1->bindParam(10, $id);
        $update1->execute();


        $db_response_data = array();
        commit($db, 'User data updated successfully', $db_response_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'sync_village_detail_data') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $timestamp = time();
        $village_codes = validateInteger($_POST['village_code']);
        $count = $_POST['count'] ? validateInteger($_POST['count']) : 0;
        $village_gata_array = array();
        $village_code = array();
        $plot_number = array();
        $khata_number = array();
        $plot_area = array();
        $owner_number = array();
        $land_type = array();
        $plot_owner = array();
        $plot_no_with_max_owner_array = array();
        $gata_uid = array();
        $time_start = microtime(true);

        // get village gat data
        $url = "https://upbhulekh.gov.in/WS_BIDA/service?type=json&api_key=apikey&get=detail&village=" . $village_codes;
        // $url = "https://upbhulekh.gov.in/WS_BIDA/service?type=json&api_key=apikey&get=detail&village=152731";
        $data = array();
        $postdata = json_encode($data);
        $curl = curl_init();
        // Send HTTP request
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postdata,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'X-Requested-With: application/json'
            ),
        ));
        $response = curl_exec($curl);
        if ($response === false) {
            echo "Error in cURL : " . curl_error($curl);
        }
        curl_close($curl);

        $village_gata_array = json_decode($response, TRUE);

        // delete old entries of village
        $delt = $db->prepare("DELETE FROM lm_api_data WHERE VillageCode = ?");
        $delt->bindParam(1, $village_codes);
        $delt->execute();

        $delt = $db->prepare("DELETE FROM lm_api_gata_kashtkar WHERE VillageCode = ?");
        $delt->bindParam(1, $village_codes);
        $delt->execute();

        if (count_($village_gata_array['DATA']['village_detail'])) {

            $byPlotKhataAreaArray = array();
            foreach ($village_gata_array['DATA']['village_detail'] as $item) {
                if (array_key_exists('khata_number', $item) && array_key_exists('plot_number', $item) && array_key_exists('plot_area', $item)) {
                    $byPlotKhataAreaArray[$item['khata_number']][$item['plot_number']][$item['plot_area']][] = array(
                        'village_code' => $item['village_code'],
                        'plot_number' => $item['plot_number'],
                        'khata_number' => $item['khata_number'],
                        'plot_area' => $item['plot_area'],
                        'owner_number' => $item['owner_number'],
                        'land_type' => $item['land_type']
                    );
                }
            }
            //print_r($byPlotKhataAreaArray);

            if (count_($byPlotKhataAreaArray)) {
                foreach ($byPlotKhataAreaArray as $bkey => $bvalue) {
                    if (count_($bvalue) && $bkey) {
                        foreach ($bvalue as $b1key => $b1value) {
                            if (count_($b1value) && $b1key) {
                                foreach ($b1value as $b2key => $b2value) {
                                    $maxs = max(array_column($b2value, 'owner_number'));
                                    $ovillage_code = $b2value[0]['village_code'];
                                    $oplot_number = $b2value[0]['plot_number'];
                                    $okhata_number = $b2value[0]['khata_number'];
                                    $oplot_area = $b2value[0]['plot_area'];
                                    $oland_type = $b2value[0]['land_type'];

                                    if ($ovillage_code && $maxs) {
                                        $plot_no_with_max_owner_array[] = array(
                                            'village_code' => $ovillage_code,
                                            'plot_number' => $oplot_number,
                                            'khata_number' => $okhata_number,
                                            'plot_area' => $oplot_area,
                                            'owner_number' => $maxs,
                                            'land_type' => $oland_type
                                        );
                                    }
                                }
                            }
                        }
                    }
                }
            }
            //print_r($plot_no_with_max_owner_array);

            if (count_($plot_no_with_max_owner_array)) {
                foreach ($plot_no_with_max_owner_array as $pwkey => $pwvalue) {
                    $uid[] = ++$count;
                    $village_code[] = $pwvalue['village_code'];
                    $plot_number[] = $pwvalue['plot_number'];
                    $khata_number[] = $pwvalue['khata_number'];
                    $plot_area[] = $pwvalue['plot_area'];
                    $owner_number[] = $pwvalue['owner_number'];
                    $land_type[] = $pwvalue['land_type'];
                }
            }
            if (count_($uid)) {
                $batch_size = 2000;
                $chunks1 = array_chunk($uid, $batch_size);
                $chunks2 = array_chunk($village_code, $batch_size);
                $chunks3 = array_chunk($plot_number, $batch_size);
                $chunks4 = array_chunk($khata_number, $batch_size);
                $chunks5 = array_chunk($plot_area, $batch_size);
                $chunks6 = array_chunk($owner_number, $batch_size);
                $chunks7 = array_chunk($land_type, $batch_size);
                $loop_size = ceil(count_($village_code) / $batch_size);

                for ($i = 0; $i < $loop_size; $i++) {
                    $query = "INSERT INTO lm_api_data (UID, VillageCode, GataNo, KhataNo, Area, OwnerNo, password, SyncedOn) VALUES "; //Prequery
                    $qPart = array_fill(0, count_($chunks1[$i]), "(?, ?, ?, ?, ?, ?, ?, ?)");
                    $query .= implode(",", $qPart);

                    $stmt2 = $db->prepare($query);
                    $k = 1;
                    foreach ($chunks1[$i] as $itemKey => $item) { //bind the values one by one
                        $stmt2->bindValue($k++, __fi($chunks1[$i][$itemKey]));
                        $stmt2->bindValue($k++, __fi($chunks2[$i][$itemKey]));
                        $stmt2->bindValue($k++, __fi($chunks3[$i][$itemKey]));
                        $stmt2->bindValue($k++, __fi($chunks4[$i][$itemKey]));
                        $stmt2->bindValue($k++, __fi($chunks5[$i][$itemKey]));
                        $stmt2->bindValue($k++, __fi($chunks6[$i][$itemKey]));
                        $stmt2->bindValue($k++, __fi($chunks7[$i][$itemKey]));
                        $stmt2->bindValue($k++, $timestamp);
                        $gata_uid[$chunks3[$i][$itemKey]] = $chunks1[$i][$itemKey];
                    }
                    $stmt2->execute();
                }

                // add owner/kashtakar details of every gata
                $ksht_uid = array();
                $ksht_village_code = array();
                $ksht_plot_number = array();
                $ksht_khata_number = array();
                $ksht_owner_number = array();
                $ksht_owner_name = array();
                $ksht_owner_father = array();
                $ksht_plot_area = array();

                foreach ($village_gata_array['DATA']['village_detail'] as $vitem) {
                    if (array_key_exists('village_code', $vitem) && $vitem['village_code']) {
                        $ksht_uid[] = $gata_uid[$vitem['plot_number']];
                        $ksht_village_code[] = $vitem['village_code'];
                        $ksht_plot_number[] = $vitem['plot_number'];
                        $ksht_khata_number[] = $vitem['khata_number'];
                        $ksht_owner_number[] = $vitem['owner_number'];
                        $ksht_owner_name[] = $vitem['owner_name'];
                        $ksht_owner_father[] = $vitem['owner_father'];
                        $ksht_plot_area[] = $vitem['share_area'];
                    }
                }

                if (count_($ksht_uid)) {
                    $ksht_batch_size = 2000;
                    $ksht_chunks1 = array_chunk($ksht_uid, $ksht_batch_size);
                    $ksht_chunks2 = array_chunk($ksht_village_code, $ksht_batch_size);
                    $ksht_chunks3 = array_chunk($ksht_plot_number, $ksht_batch_size);
                    $ksht_chunks4 = array_chunk($ksht_khata_number, $ksht_batch_size);
                    $ksht_chunks5 = array_chunk($ksht_owner_number, $ksht_batch_size);
                    $ksht_chunks6 = array_chunk($ksht_owner_name, $ksht_batch_size);
                    $ksht_chunks7 = array_chunk($ksht_owner_father, $ksht_batch_size);
                    $ksht_chunks8 = array_chunk($ksht_plot_area, $ksht_batch_size);
                    $ksht_loop_size = ceil(count_($ksht_village_code) / $ksht_batch_size);

                    for ($i = 0; $i < $ksht_loop_size; $i++) {
                        $ksht_query = "INSERT INTO lm_api_gata_kashtkar (UID, VillageCode, GataNo, KhataNo, OwnerNo, owner_name, owner_father, Area) VALUES "; //Prequery
                        $ksht_qPart = array_fill(0, count_($ksht_chunks1[$i]), "(?, ?, ?, ?, ?, ?, ?, ?)");
                        $ksht_query .= implode(",", $ksht_qPart);

                        $stmt2 = $db->prepare($ksht_query);
                        $k = 1;
                        foreach ($ksht_chunks1[$i] as $ksht_itemKey => $ksht_item) { //bind the values one by one
                            $stmt2->bindValue($k++, __fi($ksht_chunks1[$i][$ksht_itemKey]));
                            $stmt2->bindValue($k++, __fi($ksht_chunks2[$i][$ksht_itemKey]));
                            $stmt2->bindValue($k++, __fi($ksht_chunks3[$i][$ksht_itemKey]));
                            $stmt2->bindValue($k++, __fi($ksht_chunks4[$i][$ksht_itemKey]));
                            $stmt2->bindValue($k++, __fi($ksht_chunks5[$i][$ksht_itemKey]));
                            $stmt2->bindValue($k++, __fi($ksht_chunks6[$i][$ksht_itemKey]));
                            $stmt2->bindValue($k++, __fi($ksht_chunks7[$i][$ksht_itemKey]));
                            $stmt2->bindValue($k++, __fi($ksht_chunks8[$i][$ksht_itemKey]));
                        }
                        $stmt2->execute();
                    }
                }
            }

            $village_code_f = array();
            $khata_number_f = array();
            $owner_name_f = array();
            $owner_father_f = array();
            $owner_number_f = array();
            $plot_number_f = array();
            $plot_area_f = array();
            $plot_seq_number_f = array();
            $land_possession_year_f = array();
            $land_type_f = array();
            $share_area_f = array();
            $is_ansh_f = array();
            $owner_address_f = array();

            foreach ($village_gata_array['DATA']['village_detail'] as $item_f) {
                if ($item_f['village_code'] && $item_f['khata_number'] && $item_f['plot_number']) {
                    $village_code_f[] = $item_f['village_code'];
                    $khata_number_f[] = $item_f['khata_number'];
                    $owner_name_f[] = $item_f['owner_name'];
                    $owner_father_f[] = $item_f['owner_father'];
                    $owner_number_f[] = $item_f['owner_number'];
                    $plot_number_f[] = $item_f['plot_number'];
                    $plot_area_f[] = $item_f['plot_area'];
                    $plot_seq_number_f[] = $item_f['plot_seq_number'];
                    $land_possession_year_f[] = $item_f['land_possession_year'];
                    $land_type_f[] = $item_f['land_type'];
                    $share_area_f[] = $item_f['share_area'];
                    $is_ansh_f[] = $item_f['is_ansh'];
                    $owner_address_f[] = $item_f['owner_address'];
                }
            }

            if (count_($village_code_f)) {
                $fasli_batch_size = 2000;
                $fasli_chunks1 = array_chunk($village_code_f, $fasli_batch_size);
                $fasli_chunks2 = array_chunk($plot_number_f, $fasli_batch_size);
                $fasli_chunks3 = array_chunk($khata_number_f, $fasli_batch_size);
                $fasli_chunks4 = array_chunk($owner_number_f, $fasli_batch_size);
                $fasli_chunks5 = array_chunk($owner_name_f, $fasli_batch_size);
                $fasli_chunks6 = array_chunk($owner_father_f, $fasli_batch_size);
                $fasli_chunks7 = array_chunk($share_area_f, $fasli_batch_size);
                $fasli_chunks8 = array_chunk($plot_seq_number_f, $fasli_batch_size);
                $fasli_chunks9 = array_chunk($land_possession_year_f, $fasli_batch_size);
                $fasli_chunks10 = array_chunk($is_ansh_f, $fasli_batch_size);
                $fasli_chunks11 = array_chunk($owner_address_f, $fasli_batch_size);
                $fasli_chunks12 = array_chunk($land_type_f, $fasli_batch_size);
                $fasli_chunks13 = array_chunk($plot_area_f, $fasli_batch_size);
                $fasli_batch_size_count = ceil(count_($village_code_f) / $fasli_batch_size);

                for ($i = 0; $i < $fasli_batch_size_count; $i++) {
                    $fasli_query = "INSERT INTO lm_api_1359_fasli_data (VillageCode, GataNo, KhataNo, Area, OwnerNo, password, kashtkar_owner_no, kashtkar_owner_name, kashtkar_owner_father, kashtkar_area, SyncedOn, OwnerAddress, PlotSeqNumber, LandPosYear, isAnsh) VALUES";; //Prequery
                    $fasli_qPart = array_fill(0, count_($fasli_chunks1[$i]), "(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $fasli_query .= implode(",", $fasli_qPart);

                    $stmt3 = $db->prepare($fasli_query);
                    $k = 1;
                    foreach ($fasli_chunks1[$i] as $fasli_itemKey => $fasli_item) { //bind the values one by one
                        $stmt3->bindValue($k++, __fi($fasli_chunks1[$i][$fasli_itemKey]));
                        $stmt3->bindValue($k++, __fi($fasli_chunks2[$i][$fasli_itemKey]));
                        $stmt3->bindValue($k++, __fi($fasli_chunks3[$i][$fasli_itemKey]));
                        $stmt3->bindValue($k++, __fi($fasli_chunks13[$i][$fasli_itemKey]));
                        $stmt3->bindValue($k++, __fi($fasli_chunks4[$i][$fasli_itemKey]));
                        $stmt3->bindValue($k++, __fi($fasli_chunks12[$i][$fasli_itemKey]));
                        $stmt3->bindValue($k++, __fi($fasli_chunks4[$i][$fasli_itemKey]));
                        $stmt3->bindValue($k++, __fi($fasli_chunks5[$i][$fasli_itemKey]));
                        $stmt3->bindValue($k++, __fi($fasli_chunks6[$i][$fasli_itemKey]));
                        $stmt3->bindValue($k++, __fi($fasli_chunks7[$i][$fasli_itemKey]));
                        $stmt3->bindValue($k++, __fi($timestamp));
                        $stmt3->bindValue($k++, __fi($fasli_chunks11[$i][$fasli_itemKey]));
                        $stmt3->bindValue($k++, __fi($fasli_chunks8[$i][$fasli_itemKey]));
                        $stmt3->bindValue($k++, __fi($fasli_chunks9[$i][$fasli_itemKey]));
                        $stmt3->bindValue($k++, __fi($fasli_chunks10[$i][$fasli_itemKey]));
                    }
                    $stmt3->execute();
                }
            }
        }

        $time_end = microtime(true);
        $execution_time_sec = (int) ($time_end - $time_start);
        $fval = (int) ($execution_time_sec / 60);
        $mins = floor($fval % 60) . ' mins';
        $secs = floor($execution_time_sec % 60) . ' secs';

        // Make the changes to the database permanent
        $db_respose_data = array('count' => $count, 'time_execution' => $mins . ' ' . $secs, 'time' => $execution_time_sec);

        // Make the changes to the database permanent
        commit($db, '', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'rtk_mapping_data') {

    try {
        // Begin Transaction
        $db->beginTransaction();

        // Check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }
        $id = __fi(validateInteger(decryptIt(myUrlEncode($_POST['id'])), 'Village ID'));
        $village_code = __fi(validateMaxLen($_POST['village_id'], 'Village', 10));
        $email = __fi(validateMaxLen($_POST['email'], 'Mahal Name', 25));
        $khata_no = __fi(validateMaxLen($_POST['khata_no'], 'Khata no', 10));
        $village_id = __fi(validateMaxLen($_POST['village_id'], 'Village ID', 10));
        $email = isset($_POST['email']) ? __fi(validateMaxLen($_POST['email'], 255)) : '';
        $gata = isset($_POST['gata']) ? __fi($_POST['gata']) : '';
        $timestamp = time();

        $update = $db->prepare("UPDATE lm_api_1359_fasli_data SET MahalName = ?, 1359_fasli_khata = ?, 1359_fasli_gata = ? WHERE ID = ? AND VillageCode = ?");
        $update->bindParam(1, $email);
        $update->bindParam(2, $khata_no);
        $update->bindParam(3, $gata);
        $update->bindParam(4, $id);
        $update->bindParam(5, $village_id);
        $update->execute();

        // Commit the changes to the database
        $db_response_data = array('email' => $email, 'khata' => $khata_no, 'gata' => $gata);
        commit($db, 'Fasli data mapped successfully', $db_response_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'update_sync_village_detail_data') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $timestamp = time();
        $village_codes = validateInteger($_POST['village_code'], 'VillageCode');
        $count = $_POST['count'] ? validateInteger($_POST['count'], 'Count') : 0;
        $village_gata_array = array();
        $time_start = microtime(true);

        // get village gat data
        $url = "https://upbhulekh.gov.in/WS_BIDA/service?type=json&api_key=apikey&get=detail&village=" . $village_codes;
        //$url = "https://upbhulekh.gov.in/WS_BIDA/service?type=json&api_key=apikey&get=detail&village=152748";
        $data = array();
        $postdata = json_encode($data);
        $curl = curl_init();
        // Send HTTP request
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postdata,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'X-Requested-With: application/json'
            ),
        ));
        $response = curl_exec($curl);
        if ($response === false) {
            echo "Error in cURL : " . curl_error($curl);
        }
        curl_close($curl);

        $village_gata_array = json_decode($response, TRUE);

        if (count_($village_gata_array['DATA']['village_detail'])) {

            $village_code_f = array();
            $khata_number_f = array();
            $owner_name_f = array();
            $owner_father_f = array();
            $owner_number_f = array();
            $plot_number_f = array();
            $plot_area_f = array();
            $land_type_f = array();
            $bandhak_f = array();

            foreach ($village_gata_array['DATA']['village_detail'] as $item_f) {
                if ($item_f['village_code'] && $item_f['khata_number'] && $item_f['plot_number']) {
                    $village_code_f[] = $item_f['village_code']; // village code
                    $plot_number_f[] = $item_f['plot_number']; // gata number
                    $khata_number_f[] = $item_f['khata_number']; // khata number
                    $owner_name_f[] = $item_f['owner_name']; // owner name
                    $owner_father_f[] = $item_f['owner_father']; // owner father name
                    $owner_number_f[] = $item_f['owner_number']; //owner number
                    $plot_area_f[] = $item_f['plot_area']; // area
                    $land_type_f[] = $item_f['land_type']; // password
                    $bandhak_f[] = $item_f['remark']; // bandhak data
                }
            }

            if (count_($village_code_f)) {
                $fasli_batch_size = 2000;
                $fasli_chunks1 = array_chunk($village_code_f, $fasli_batch_size); // village code
                $fasli_chunks2 = array_chunk($plot_number_f, $fasli_batch_size); // gata number
                $fasli_chunks3 = array_chunk($khata_number_f, $fasli_batch_size); // khata number
                $fasli_chunks4 = array_chunk($owner_number_f, $fasli_batch_size); // owner number
                $fasli_chunks12 = array_chunk($land_type_f, $fasli_batch_size); // password
                $fasli_chunks13 = array_chunk($plot_area_f, $fasli_batch_size); // area
                $fasli_chunks5 = array_chunk($owner_name_f, $fasli_batch_size); // owner name
                $fasli_chunks6 = array_chunk($owner_father_f, $fasli_batch_size); // owner father name
                $fasli_chunks14 = array_chunk($bandhak_f, $fasli_batch_size); //  bandhak
                $fasli_batch_size_count = ceil(count_($village_code_f) / $fasli_batch_size);

                for ($i = 0; $i < $fasli_batch_size_count; $i++) {
                    foreach ($fasli_chunks1[$i] as $fasli_itemKey => $fasli_item) {
                        $k = 1;
                        $area = number_format((float) $fasli_chunks13[$i][$fasli_itemKey], 3, '.', '');
                        $bandhak_remark = json_encode($fasli_chunks14[$i][$fasli_itemKey], JSON_UNESCAPED_UNICODE);

                        $stmt3 = $db->prepare("UPDATE lm_api_1359_fasli_data SET Bandhak = ?  WHERE VillageCode = ? AND GataNo = ? AND KhataNo = ? AND Area = ? AND OwnerNo = ? AND Shreni = ? AND kashtkar_owner_no = ? AND kashtkar_owner_name = ? AND kashtkar_owner_father = ?");
                        $stmt3->bindValue($k++, __fi($bandhak_remark)); // bandhak data
                        $stmt3->bindValue($k++, __fi($fasli_chunks1[$i][$fasli_itemKey])); // village code
                        $stmt3->bindValue($k++, __fi($fasli_chunks2[$i][$fasli_itemKey])); // gata number
                        $stmt3->bindValue($k++, __fi($fasli_chunks3[$i][$fasli_itemKey])); // khata number
                        $stmt3->bindValue($k++, __fi($area)); // area
                        $stmt3->bindValue($k++, __fi($fasli_chunks4[$i][$fasli_itemKey])); // owner number
                        $stmt3->bindValue($k++, __fi($fasli_chunks12[$i][$fasli_itemKey])); // shreni
                        $stmt3->bindValue($k++, __fi($fasli_chunks4[$i][$fasli_itemKey])); // kashtkar owner number
                        $stmt3->bindValue($k++, __fi($fasli_chunks5[$i][$fasli_itemKey])); // kashtkar name
                        $stmt3->bindValue($k++, __fi($fasli_chunks6[$i][$fasli_itemKey])); // kashtkar father name
                        $stmt3->execute();
                    }
                }
            }
        }

        $time_end = microtime(true);
        $execution_time_sec = (int) ($time_end - $time_start);
        $fval = (int) ($execution_time_sec / 60);
        $mins = floor($fval % 60) . ' mins';
        $secs = floor($execution_time_sec % 60) . ' secs';

        // Make the changes to the database permanent
        $db_respose_data = array('count' => $count, 'time_execution' => $mins . ' ' . $secs, 'time' => $execution_time_sec);

        // Make the changes to the database permanent
        commit($db, '', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
}
