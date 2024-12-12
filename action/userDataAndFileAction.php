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
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PhpOffice\PhpSpreadsheet\Spreadsheet;

$user_id = $_SESSION['UserID'];

if (isset($_POST['action']) && $_POST['action'] == 'add_user_data_and_file') {

    try {
        // Begin Transaction
        $db->beginTransaction();

        // Check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

     

        $name = __fi(validateMaxLen($_POST['name'], 100));
        $mobile = __fi(validateMaxLen($_POST['Mobile'],  10));
        $gender = __fi(validateMaxLen($_POST['gender'], 10));
        // $email = __fi(validateMaxLen($_POST['email'], 100));
        $dob = __fi(validateMaxLen($_POST['dob'], 10));
        $email = __fi(validateMaxLen($_POST['email'], 100));
        $pan = __fi(validateMaxLen($_POST['pan'], 50));
        $adhaar = __fi(validateMaxLen($_POST['adhaar'], 50));
        $address = __fi(validateMaxLen($_POST['address'], 50));
        $city = __fi(validateMaxLen($_POST['city'], 50));
        $pincode = __fi(validateMaxLen($_POST['pincode'], 50));
        $document = __fi($_POST['document']);
        $profile = __fi($_POST['profile']);
        $branch = __fi(validateMaxLen($_POST['branch'], 50));

       
      
        $timestamp = time();
        $created_by = $_SESSION['UserID'];

        $insrt1 = $db->prepare("INSERT INTO  lm_user_data_and_file  (Name, Mobile, Gender, DOB, Email, Pan, Adhaar,Address, City, Pincode, Document, Profile,Branch) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?)");
        $insrt1->bindParam(1, $name);
        $insrt1->bindParam(2, $mobile);
        $insrt1->bindParam(3, $gender);
        $insrt1->bindParam(4, $dob);
        $insrt1->bindParam(5, $email);
        $insrt1->bindParam(6, $pan);
        $insrt1->bindParam(7, $adhaar);
        $insrt1->bindParam(8, $address);
        $insrt1->bindParam(9, $city);
        $insert->bindParam(10,$pincode);
        $insert->bindParam(11,$document);
        $insert->bindParam(12,$profile);
        $insert->bindParam(13,$branch);
      
        $insrt1->execute();

        // $data_id = $db->lastInsertId();


        $db_response_data = array();
        commit($db, 'User data and file added successfully', $db_response_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} elseif (isset($_POST['action']) && $_POST['action'] == 'edit_user_data') {

    try {
        // Begin Transaction
        $db->beginTransaction();

        // Check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }
     


         $id = __fi(validateInteger(decryptIt(myUrlEncode($_POST['id'])), "ID")); 

        $name = __fi(validateMaxLen($_POST['name'], 100));
        $user_name = __fi(validateMaxLen($_POST['user_name'],  100));
        $email = __fi(validateMaxLen($_POST['email'], 100));
        $mobile_no = __fi(validateMaxLen($_POST['mobile_no'], 10));
        $designation = __fi(validateMaxLen($_POST['designation'], 100));
        $address = __fi(validateMaxLen($_POST['address'], 50));
        $gender = __fi(validateMaxLen($_POST['gender'], 10));
        $password = __fi(validateMaxLen($_POST['password'], 20));
        $c_password = __fi(validateMaxLen($_POST['cpassword'], 20));

     



        $timestamp = time();

        $update1 = $db->prepare("UPDATE user_info SET Name = ?, User_Name = ?, Email = ?, Password = ?, Confirm_Password = ? , Mobile_No = ?,Designation = ?,Address = ?, Gender = ?  WHERE ID = ?");
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
} 

