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
        $name = __fi(validateMaxLen($_POST['name'], 100));
        $mobile = __fi(validateMaxLen($_POST['mobile'], 10));
        $gender = __fi(validateMaxLen($_POST['gender'], 10));
        $dob = __fi(validateMaxLen($_POST['dob'], 10));
        $email = __fi(validateMaxLen($_POST['email'], 100));
        $pan = __fi(validateMaxLen($_POST['pan'], 50));
        $adhaar = __fi(validateMaxLen($_POST['adhaar'], 50));
        $address = __fi(validateMaxLen($_POST['address'], 50));
        $city = __fi(validateMaxLen($_POST['city'], 50));
        $pincode = __fi(validateMaxLen($_POST['pincode'], 50));
        $branch = __fi(validateMaxLen($_POST['branch'], 50));

        $allowed_ext = array("pdf", "jpg", "jpeg", "png", "docx", "doc"); // allowed extensions
        $uploadedDocuments = [];
        $uploadDirectory = '../uploads/';

        // Handle multiple document uploads
        foreach ($_FILES['document']['name'] as $key => $filename) {
            $fileTmpPath = $_FILES['document']['tmp_name'][$key];
            $fileInfo = pathinfo($filename);
            $fileType = strtolower($fileInfo['extension']);

            if (in_array($fileType, $allowed_ext)) {
                $newFileName = uniqid() . '-' . basename($fileInfo['basename']);
                $destination = $uploadDirectory . $newFileName;

                if (move_uploaded_file($fileTmpPath, $destination)) {
                    $uploadedDocuments[] = $newFileName;
                } else {
                    throw new Exception("Failed to upload file: " . $filename);
                }
            } else {
                throw new Exception("Invalid file type for: " . $filename);
            }
        }

        // Handle profile picture upload
        $profilePicture = '';
        if (!empty($_FILES['profile']['name'])) {
            $profileFileName = $_FILES['profile']['name'];
            $profileTmpPath = $_FILES['profile']['tmp_name'];
            $profileInfo = pathinfo($profileFileName);
            $profileFileType = strtolower($profileInfo['extension']);

            if (in_array($profileFileType, $allowed_ext)) {
                $profilePicture = uniqid() . '-' . basename($profileInfo['basename']);
                $profileDestination = $uploadDirectory . $profilePicture;

                if (!move_uploaded_file($profileTmpPath, $profileDestination)) {
                    throw new Exception("Failed to upload profile picture.");
                }
            } else {
                throw new Exception("Invalid profile picture file type.");
            }
        }

        // Insert user data into the first table (lm_user_data)
        $insrt1 = $db->prepare("INSERT INTO lm_user_data 
            (Name, Mobile, Gender, DOB, Email, Pan, Adhaar, Address, City, Pincode, Branch) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Bind parameters
        $insrt1->bindParam(1, $name, PDO::PARAM_STR);
        $insrt1->bindParam(2, $mobile, PDO::PARAM_STR);
        $insrt1->bindParam(3, $gender, PDO::PARAM_STR);
        $insrt1->bindParam(4, $dob, PDO::PARAM_STR);
        $insrt1->bindParam(5, $email, PDO::PARAM_STR);
        $insrt1->bindParam(6, $pan, PDO::PARAM_STR);
        $insrt1->bindParam(7, $adhaar, PDO::PARAM_STR);
        $insrt1->bindParam(8, $address, PDO::PARAM_STR);
        $insrt1->bindParam(9, $city, PDO::PARAM_STR);
        $insrt1->bindParam(10, $pincode, PDO::PARAM_STR);
        $insrt1->bindParam(11, $branch, PDO::PARAM_STR);

        // Execute first query
        $insrt1->execute();

        // Get the last inserted ID
        $userId = $db->lastInsertId();

        // Insert documents and profile picture into the second table (lm_user_documents)
        $documentsString = implode(",", $uploadedDocuments);
        $insrt2 = $db->prepare("INSERT INTO lm_user_documents (user_id, document, profile) VALUES (?, ?, ?)");

        // Bind parameters
        $insrt2->bindParam(1, $userId, PDO::PARAM_INT);
        $insrt2->bindParam(2, $documentsString, PDO::PARAM_STR);
        $insrt2->bindParam(3, $profilePicture, PDO::PARAM_STR);

        // Execute second query
        $insrt2->execute();

        // Commit transaction
        $db_response_data = array();
        commit($db, 'User data added successfully', $db_response_data);
        // echo "User data and files added successfully.";
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