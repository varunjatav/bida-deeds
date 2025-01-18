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
        $fetch_data = $db->prepare("SELECT T1.ID,T1.username, T1.email, T2.gender, T2.salary, T2.job, T3.profile_pic FROM lm_employees T1 INNER JOIN lm_employee_details T2 ON T1.ID = T2.employee_id INNER JOIN lm_employee_profile T3 ON T1.ID = T3.employee_id WHERE T1.ID = ?");
        $fetch_data->bindParam(1, $user_Id);
        $fetch_data->execute();
       
        


        $result = $fetch_data->fetchAll(PDO::FETCH_ASSOC);
        // $db->commit();
        $data = array(
            "status" => true,
            "user_list" => $result,
            "total_count" => $total_count
        );
      
    } catch (\Throwable $e) {
        //throw $th;
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