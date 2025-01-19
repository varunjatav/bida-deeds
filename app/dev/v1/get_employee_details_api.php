<?php 
error_reporting(0);
$script_file_name = basename($_SERVER['SCRIPT_FILENAME']);
include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.php';
include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/vendor/autoload.php';
include_once dirname(dirname(dirname(__FILE__))) . '/apiAccess.php';
$api_validate = 1; //apiValidate($_REQUEST, $script_file_name);
header("Content-Type: application/json");

if($api_validate == 1){
    include_once dirname(dirname(dirname(__FILE__))) . '/get_time_zone.php';
    include_once dirname(dirname(dirname(__FILE__))) . '/common_functions.php';
    include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/dbcon/db_connect.php';
    
  
 if($_SERVER['REQUEST_METHOD'] == 'GET' && $_REQUEST['userid']){
    try {
        $user_Id = $_REQUEST['userid'];

        $stmt = $db->prepare("SELECT * FROM lm_employee_profile WHERE employee_id = ?");
        $stmt->bindParam(1,$user_Id);
        $stmt->execute();
        $check = $stmt->rowCount();
      
        if($check == 0){
            $fetch_data = $db->prepare("SELECT T1.ID,T1.username, T1.email, T2.gender, T2.salary, T2.job, T2.hobbies FROM lm_employees T1 INNER JOIN lm_employee_details T2 ON T1.ID = T2.employee_id WHERE T1.ID = ?");
            $fetch_data->bindParam(1, $user_Id);
            $fetch_data->execute();
        }else{
            $fetch_data = $db->prepare("SELECT T1.ID,T1.username, T1.email, T2.gender, T2.salary, T2.job, T2.hobbies, T3.profile_pic, T3.documents FROM lm_employees T1 INNER JOIN lm_employee_details T2 ON T1.ID = T2.employee_id INNER JOIN lm_employee_profile T3 ON T1.ID = T3.employee_id WHERE T1.ID = ?");
            $fetch_data->bindParam(1, $user_Id);
            $fetch_data->execute();
        }

        
       
        


        $result = $fetch_data->fetchAll(PDO::FETCH_ASSOC);
        // echo $result;
        // exit();
        $data = array(
            "status" => true,
            "user_details" => $result[0],
        );
      
    } catch (\Throwable $e) {
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
 }else{
    $data = array(
        "status" => false,
        "message" => "Oops.. something went wrong."
    );
   }

   $data = removeEmptyValues($data);
   print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
}
?>