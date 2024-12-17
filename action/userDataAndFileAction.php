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
        // Begin transaction
        $db->beginTransaction();


        

        // Check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        // Sanitize and validate input data
        $name = $_POST['name'];
        $mobile = $_POST['mobile'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $email = $_POST['email'];
        $pan = $_POST['pan'];
        $adhaar = $_POST['adhaar'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $pincode = $_POST['pincode'];
        $branch = $_POST['branch'];
        $branch = $_POST['branch'];
        // $branchString = implode(",", $branch);

       

    
        // if (count_($name) == 0) {
        //     // return response
        //     $db_respose_data = json_encode(array('status' => '-1', 'message' => 'Please add atleast one gata'));
        //     print_r($db_respose_data);
        //     exit();
        // }

        // foreach($name as $key => $unival){
        //     echo $key;
        // }
        // exit();

// Default values for conditional bindings
// $panValue = ($validated_pan == 1) ? $pan : "--";
// $adhaarValue = ($validated_adhaar == 1) ? $adhaar : "--";
// $profilePicture = array();

// exit();





      
      

foreach($name as $key => $unival){

        $name_value = isset($name[$key]) ? $name[$key] : "--";
        $mobile_value = isset($mobile[$key]) ? $mobile[$key] : "--";
        $gender_value = isset($gender[$key]) ? $gender[$key] : "--";
        $dob_value = isset($dob[$key]) ? $dob[$key] : "--";
        $email_value = isset($email[$key]) ? $email[$key] : "--";
        $pan_value = isset($pan[$key]) ? $pan[$key] : "--";
        $adhaar_value = isset($adhaar[$key]) ? $adhaar[$key] : "--";
        $address_value = isset($address[$key]) ? $address[$key] : "--";
        $city_value = isset($city[$key]) ? $city[$key] : "--";
        $pincode_value = isset($pincode[$key]) ? $pincode[$key] : "--";
        $branchString = isset($branch[$key]) ? $branch[$key] : "--";

        // $validated_email = validateEmail($email_value);
        
        // $validated_mobile = validateMobile($mobile_value);
       

           
    //     if (!empty($adhaar_value)) 
    //     {
    //         $valid = aadharValidation($adhaar_value);
    //         if ($valid == 0) 
    //         {
    //              $db_respose_data = json_encode(array('status' => false, 'message' => 'Invalid aadhar card number.'));
    //              print_r($db_respose_data);
    //              exit();
    //         }    
    //    }

    //   if (!empty($pan_value)) {
    //       $valid = panValidation($pan_value);
    //       if ($valid == 0) {
    //           $db_respose_data = json_encode(array('status' => false, 'message' => 'Invalid pan card number.'));
    //           print_r($db_respose_data);
    //           exit();
    //       }
    //     }

        $insrt1 = $db->prepare("INSERT INTO lm_user_data 
            (Name, Mobile, Gender, DOB, Email, Pan, Adhaar, Address, City, Pincode, Branch) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");


        $insrt1->bindParam(1, $name_value, PDO::PARAM_STR);
        $insrt1->bindParam(2, $mobile_value, PDO::PARAM_STR);
        $insrt1->bindParam(3, $gender_value, PDO::PARAM_STR);
        $insrt1->bindParam(4, $dob_value, PDO::PARAM_STR);
        $insrt1->bindParam(5, $email_value, PDO::PARAM_STR);
        $insrt1->bindParam(6, $pan_value, PDO::PARAM_STR); 
        $insrt1->bindParam(7, $adhaar_value, PDO::PARAM_STR);
        $insrt1->bindParam(8, $address_value, PDO::PARAM_STR);
        $insrt1->bindParam(9, $city_value, PDO::PARAM_STR);
        $insrt1->bindParam(10, $pincode_value, PDO::PARAM_STR);
        $insrt1->bindParam(11, $branchString, PDO::PARAM_STR);

        $insrt1->execute();


    
        $imageArray = array();
       
        $timestamp = time();

       

        $userId = $db->lastInsertId();
        $target_dir = "../media/uploads/";
        $allowed_ext = array("jpg", "jpeg", "png", "doc", "docx", "ppt", "pdf", "PDF"); // allowed extensions
        $profilePicture = upload_attachments($_FILES['profile'], $target_dir, DOCUMENT_MAX_SIZE, $allowed_ext, 'user_profile', $userId, 640, 760, 95);

        
       
     
        $imageArray = upload_attachments($_FILES['document'], $target_dir, DOCUMENT_MAX_SIZE, $allowed_ext, 'user_documents', $userId, 640, 760, 95);



       
         $profile = json_encode($profilePicture);




        $image = json_encode($imageArray);
      
       
            $insrt2 = $db->prepare("INSERT INTO lm_multiple_documents (user_id, documents) VALUES (?, ?)");
            $insrt2->bindParam(1, $userId, PDO::PARAM_INT);
            $insrt2->bindParam(2, $image, PDO::PARAM_STR);
            $insrt2->execute();  
       

        
        $insrt3 = $db->prepare("INSERT INTO  lm_single_profile (user_id, profile) VALUES (?, ?)");

        $insrt3->bindParam(1, $userId, PDO::PARAM_INT);
        $insrt3->bindParam(2, $profile, PDO::PARAM_STR);
        
        $insrt3->execute();

    }




        // Commit transaction
        $db_response_data = array();
        commit($db, 'User data added successfully', $db_response_data);
       
    } catch (Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }
        error_log('Error: ' . $e->getMessage());
        echo "Error occurred: " . $e->getMessage();
    }
} 
elseif (isset($_POST['action']) && $_POST['action'] == 'edit_user_data') {

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