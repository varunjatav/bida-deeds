<?php
error_reporting(0);
$script_file_name = basename($_SERVER['SCRIPT_FILENAME']);
include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.php';
include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/vendor/autoload.php';
include_once dirname(dirname(dirname(__FILE__))) . '/apiAccess.php';
$api_validate = 1; //apiValidate($_REQUEST, $script_file_name);

if ($api_validate) {
    include_once dirname(dirname(dirname(__FILE__))) . '/get_time_zone.php';
    include_once dirname(dirname(dirname(__FILE__))) . '/common_functions.php';
    include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/dbcon/db_connect.php';

    // print_r($_FILES['profile']);
    // exit();
  
    if ($_FILES['profile']['name'] != '' && $_FILES['profile']['full_path'] != '' && $_FILES['profile']['type'] != '' && $_FILES['profile']['tmp_name'] != '' && $_FILES['profile']['error'] != '' && $_FILES['profile']['size'] !='') {
        try {

            $db->beginTransaction();
            $allowed_ext = array("pdf");
          
            $user_id = $_REQUEST['userid'];
            
            $target_dir_image = dirname(dirname(dirname(dirname(__FILE__)))) . "/" . $user_profile . "/";
         
           
            if (is_uploaded_file($_FILES['profile']['tmp_name'])) {
               
                $name = $_FILES['profile']['name'];
                $ext = strtolower(end(explode('.', $name)));

              
                if (!in_array($ext, $allowed_ext)) {
                    
                    // return response
                    $data = json_encode(array('status' => false, 'message' => 'Profile Picture extention type not allowed.'));
                    print_r($data);
                    exit();
                }
            }
    
            /** image move to folder  * */
            if (is_uploaded_file($_FILES['profile']['tmp_name']) && !empty($_FILES['profile']['tmp_name'])) {
             
                $name = $_FILES['profile']['name'];
                $tmpfile = $_FILES['profile']['tmp_name'];
                $path = $target_dir_image;
    
                if (strlen($name)) {
                   
                    $ext = strtolower(end(explode('.', $name)));
                    $orig_file_size = filesize($tmpfile);
    
                    // rename image
                    $name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $name);
                    $rand_1 = rand(9999, 9999999);
                    $rand_2 = rand(9999999, 9999999999);
                    $rand_3 = rand();
                    $rename_image = strtolower(str_replace(' ', '', 'profile' . '' . $orig_file_size . '' . time() . '' . $rand_1 . '' . $rand_2 . '_' . $rand_3));
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
           
                    $insert = $db->prepare("INSERT INTO lm_employee_profile (employee_id,profile_pic) VALUES (?,?)");
                    $insert->bindParam(1, $user_id);
                    $insert->bindParam(2, $actual_document_name);
                    $insert->execute();
          

            $db->commit();
            $data = array(
                "status" => true,
                "message" => "Profile Pic Uploaded Successfully."
            );
        } catch (\Throwable $e) {
            $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
            rollback($db, $e->getCode(), $log_error_msg);
        }
    } else {
        $data = array(
            "status" => false,
            "message" => "Oops.. something went wrong."
        );
    }

    $data = removeEmptyValues($data);
    print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
}
