<?php 
error_reporting(0);
$script_file_name = basename($_SERVER['SCRIPT_FILENAME']);
include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.php';
include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/vendor/autoload.php';
include_once dirname(dirname(dirname(__FILE__))) . '/apiAccess.php';
$api_validate = 1; //apiValidate($_REQUEST, $script_file_name);
header("Content-Type: application/json");
if($api_validate){
    include_once dirname(dirname(dirname(__FILE__))) . '/get_time_zone.php';
    include_once dirname(dirname(dirname(__FILE__))) . '/common_functions.php';
    include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/dbcon/db_connect.php';
    
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        try {
            // $db->beginTransaction();
           
            $fetch_data = $db->prepare("SELECT SQL_CALC_FOUND_ROWS T1.ID,t1.username, T1.email FROM lm_employees T1 WHERE 1=1 GROUP BY T1.ID ORDER BY T1.ID DESC");
            $fetch_data->execute();
           
            $rs1 = $db->query('SELECT FOUND_ROWS()');
            $total_count = (int) $rs1->fetchColumn();
    

            $result = $fetch_data->fetchAll(PDO::FETCH_ASSOC);
            // $db->commit();
            $data = array(
                "status" => true,
                "user_list" => $result,
                "total_count" => $total_count
            );
          
        } 
         catch (\Throwable $e) 
        {
            $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
            rollback($db, $e->getCode(), $log_error_msg);
        }
    }else{
        $data = array(
            "status"=>false,
            "message"=>"Opps!! Something Went Wrong! "
        );
    }
    $data = removeEmptyValues($data);
    print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
    
}
?>