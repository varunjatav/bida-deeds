<?php
date_default_timezone_set('Asia/Kolkata');
$rootPath = dirname(__FILE__, 5); 

// Include the config.php file from the root directory
include_once $rootPath . '/config.php';
include_once $rootPath . '/includes/checkSession.php';
include_once $rootPath . '/includes/get_time_zone.php';
include_once $rootPath .'/dbcon/db_connect.php';
include_once $rootPath .'/functions/common.function.php';




if(isset($_POST["action"]) && $_POST["action"] === "create_user"){

    try {

        $db->beginTransaction(); 
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }
        $username = __fi($_POST["username"]);
        $email = __fi($_POST["email"]);
        $password = __fi($_POST["password"]);

        // Example insertion query
        $stmt = $db->prepare("INSERT INTO lm_employees (username, email, password) VALUES (?, ?, ?)");
        $stmt->bindParam(1,$username);
        $stmt->bindParam(2,$email);
        $stmt->bindParam(3,$password);

        $db->commit();
        header('Content-Type: application/json');
        commit($db, 'Employee Created Successfully', $db_respose_data);
    } catch (\Throwable $th) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
   

}
 
?>