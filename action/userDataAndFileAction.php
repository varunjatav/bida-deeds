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

// print_r($_FILES);
// exit();


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
        

        // Check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

     
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
        // $branch = $_POST['branch'];
         $branch = isset($_POST['branch_data']) ? $_POST['branch_data'] : array();   
         
         
          
        $profilePicture = array();

        $imageArray = array();

        


        $target_dir = "../media/uploads/";
        $allowed_ext = array("jpg", "jpeg", "png", "doc", "docx", "ppt", "pdf", "PDF");
    
    
        $profilePicture = upload_attachments($_FILES['profile'], $target_dir, DOCUMENT_MAX_SIZE, $allowed_ext, 'user_profile', $userId, 640, 760, 95);
    
        
       
     
        $imageArray = upload_attachments($_FILES['document'], $target_dir, DOCUMENT_MAX_SIZE, $allowed_ext, 'user_documents', $userId, 640, 760, 95);


       
        // $timestamp = time();

        
  

        // print_r($profilePicture);
        // exit();

foreach($name as $key => $unival){

        $name_value = isset($name[$key]) ? __fi(validateMaxLen($name[$key],100)) : "--";
        $mobile_value = isset($mobile[$key]) ?  __fi(validateMaxLen($mobile[$key],20)) : "--";
        $gender_value = isset($gender[$key]) ? __fi(validateMaxLen($gender[$key],20)) : "--";
        $dob_value = isset($dob[$key]) ? $dob[$key] : "--";
        $email_value = isset($email[$key]) ? __fi(validateMaxLen($email[$key],100)) : "--";
        $pan_value = isset($pan[$key]) ? __fi(validateMaxLen($pan[$key],50)) : "--";
        $adhaar_value = isset($adhaar[$key]) ? __fi(validateMaxLen($adhaar[$key],50)) : "--";
        $address_value = isset($address[$key]) ? __fi(validateMaxLen($address[$key],100)) : "--";
        $city_value = isset($city[$key]) ? __fi(validateMaxLen($city[$key],100)) : "--";
        $pincode_value = isset($pincode[$key]) ? __fi(validateMaxLen($pincode[$key],50)) : "--";

        // $branchString = implode(",", $branch);
        $branch_value = isset($branch[$key]) ? $branch[$key] : "--";
        
        //echo $branch_value;
        // exit();
        // exit();
        $validated_email = validateEmail($email_value);
        
        $validated_mobile = validateMobile($mobile_value);
       

           
        if (!empty($adhaar_value)) 
        {
            $valid = aadharValidation($adhaar_value);
            if ($valid == 0) 
            {
                 $db_respose_data = json_encode(array('status' => false, 'message' => 'Invalid aadhar card number.'));
                 print_r($db_respose_data);
                 exit();
            }    
       }



      if (!empty($pan_value)) {
          $valid = panValidation($pan_value);
          if ($valid == 0) {
              $db_respose_data = json_encode(array('status' => false, 'message' => 'Invalid pan card number.'));
              print_r($db_respose_data);
              exit();
          }
        }

        $insrt1 = $db->prepare("INSERT INTO lm_user_data 
            (Name, Mobile, Gender, DOB, Email, Pan, Adhaar, Address, City, Pincode, Branch) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");


        $insrt1->bindParam(1, $name_value, PDO::PARAM_STR);
        $insrt1->bindParam(2, $validated_mobile, PDO::PARAM_STR);
        $insrt1->bindParam(3, $gender_value, PDO::PARAM_STR);
        $insrt1->bindParam(4, $dob_value, PDO::PARAM_STR);
        $insrt1->bindParam(5, $validated_email, PDO::PARAM_STR);
        $insrt1->bindParam(6, $pan_value, PDO::PARAM_STR); 
        $insrt1->bindParam(7, $adhaar_value, PDO::PARAM_STR);
        $insrt1->bindParam(8, $address_value, PDO::PARAM_STR);
        $insrt1->bindParam(9, $city_value, PDO::PARAM_STR);
        $insrt1->bindParam(10, $pincode_value, PDO::PARAM_STR);
        $insrt1->bindParam(11, $branch_value, PDO::PARAM_STR);


        $insrt1->execute();
       
        $userId = $db->lastInsertId();


         
  
       
        //  $profile = json_encode($profilePicture[0]);

     
            $image = json_encode($imageArray);
    if($imageArray){

        $insrt2 = $db->prepare("INSERT INTO lm_multiple_documents (user_id, documents) VALUES (?, ?)");
        $insrt2->bindParam(1, $userId, PDO::PARAM_INT);
        $insrt2->bindParam(2, $image, PDO::PARAM_STR);
        $insrt2->execute();  
    }
           
       

        
       
        if($profilePicture){
            $insrt3 = $db->prepare("INSERT INTO  lm_single_profile (user_id, profile) VALUES (?, ?)");
            $insrt3->bindParam(1, $userId, PDO::PARAM_INT);
            $insrt3->bindParam(2, $profilePicture[0], PDO::PARAM_STR);
            $insrt3->execute();
        }
        

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
elseif (isset($_POST['action']) && $_POST['action'] == 'edit_user_data_and_file') {

    try {
        // Begin Transaction
        $db->beginTransaction();

        // Check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }



        $decodedId = decryptIt(myUrlEncode($_POST['id']));
        $id = __fi(validateInteger($decodedId, "ID"));


        $name = __fi(validateMaxLen($_POST['name'], 100));
        $mobile = __fi(validateMaxLen($_POST['mobile'],  20));
        $gender = __fi(validateMaxLen($_POST['gender'],20));
        $dob = $_POST['dob'];
        $email = __fi(validateMaxLen($_POST['email'], 100));
        $pan = __fi(validateMaxLen($_POST['pan'], 50));
        $adhaar = __fi(validateMaxLen($_POST['adhaar'], 50));
        $address = __fi(validateMaxLen($_POST['address'], 100));
        
        $city = __fi(validateMaxLen($_POST['city'], 100));
        $pincode = __fi(validateMaxLen($_POST['pincode'], 50));
        $branch = isset($_POST['branch_data']) ? $_POST['branch_data'] : array(); 
        $branchString = implode(",", $branch);
          
        // print_r($gender);
        // exit;


        $validated_email = validateEmail($email);
        
        $validated_mobile = validateMobile($mobile);
       

           
        if (!empty($adhaar)) 
        {
            $valid = aadharValidation($adhaar);
            if ($valid == 0) 
            {
                 $db_respose_data = json_encode(array('status' => false, 'message' => 'Invalid aadhar card number.'));
                 print_r($db_respose_data);
                 exit();
            }    
       }



      if (!empty($pan)) {
          $valid = panValidation($pan);
          if ($valid == 0) {
              $db_respose_data = json_encode(array('status' => false, 'message' => 'Invalid pan card number.'));
              print_r($db_respose_data);
              exit();
          }
        }



        $timestamp = time();

        $update1 = $db->prepare("UPDATE lm_user_data SET Name = ?, Mobile = ?, Gender = ?, DOB = ?, Email = ? , Pan = ?,Adhaar = ?,Address = ?, City = ?, Pincode = ?, Branch=?  WHERE ID = ?");
        $update1->bindParam(1, $name);
        $update1->bindParam(2, $validated_mobile);
        $update1->bindParam(3, $gender);
        $update1->bindParam(4, $dob);
        $update1->bindParam(5, $validated_email);
        $update1->bindParam(6, $pan);
        $update1->bindParam(7, $adhaar);
        $update1->bindParam(8, $address);
        $update1->bindParam(9, $city);
        $update1->bindParam(10, $pincode);
        $update1->bindParam(11, $branchString);
        $update1->bindParam(12, $id);
        $update1->execute();




        $profilePicture = array();

        $imageArray = array();

        $target_dir = "../media/uploads/";
        $allowed_ext = array("jpg", "jpeg", "png", "doc", "docx", "ppt", "pdf", "PDF");
    
    
        $profilePicture = upload_attachments($_FILES['profile'], $target_dir, (int)DOCUMENT_MAX_SIZE, $allowed_ext, 'user_profile', $id, (int)640, (int)760, (int)95);
    
        
       
     
        $imageArray = upload_attachments($_FILES['document'], $target_dir,(int)DOCUMENT_MAX_SIZE, $allowed_ext, 'user_documents', $id, (int)640, (int)760, (int)95);


        $image = json_encode($imageArray);


        if($imageArray){
            $update2 = $db->prepare("UPDATE  lm_multiple_documents SET documents = ? WHERE user_id =?");
            $update2->bindParam(2, $id, PDO::PARAM_INT);
            $update2->bindParam(1, $image, PDO::PARAM_STR);
            $update2->execute();  
        }
               
           
    
            
           
            if($profilePicture){
                $update3 = $db->prepare("UPDATE lm_single_profile SET profile = ? WHERE user_id = ?");
                $update3->bindParam(2, $id, PDO::PARAM_INT);
                $update3->bindParam(1, $profilePicture[0], PDO::PARAM_STR);
                $update3->execute();
            }
            


        $db_response_data = array();
        commit($db, 'User data and file updated successfully', $db_response_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
}