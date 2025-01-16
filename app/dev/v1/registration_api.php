<?php
error_reporting(0);
$script_file_name = basename($_SERVER['SCRIPT_FILENAME']);
include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.php';
include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/vendor/autoload.php';
include_once dirname(dirname(dirname(__FILE__))) . '/apiAccess.php';
$api_validate = 1; //apiValidate($_REQUEST, $script_file_name);




if($api_validate == 1){
    include_once dirname(dirname(dirname(__FILE__))) . '/get_time_zone.php';
    include_once dirname(dirname(dirname(__FILE__))) . '/common_functions.php';
    include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/dbcon/db_connect.php';

    $email = __fi(validateMaxLen(validateEmail($_REQUEST["email"]), 50 , "Email"));
    $username = __fi(validateMaxLen($_REQUEST["username"], 50 , "User Name"));
    $password = __fi(validateMaxLen($_REQUEST["password"], 255 , "Password"));
    $gender = __fi(validateMaxLen(validateGender($_REQUEST["gender"]), 20 ,"Gender"));
    $job = __fi(validateMaxLen($_REQUEST["job"], 50 , "Job"));
    $salary = __fi(validateMaxLen($_REQUEST["salary"], 20 , "Salary"));

if($email && $username && $password){
   
    try {
        $db->beginTransaction();
   

        $stmt = $db->prepare("SELECT * FROM lm_employees WHERE email = ?");
        
        $stmt->bindParam(1,$email);
        $stmt->execute();
      
        $check = $stmt->rowCount();
       
        if($check > 0){
                $data = array(
                    "status" => false,
                    "message" => "This user is already registered."
                );
                
        }else{
            $hash_password = password_hash($password,PASSWORD_DEFAULT);
            $insert = $db->prepare("INSERT INTO lm_employees (username, email,password) VALUES (?,?,?)");
            $insert->bindParam(1,$username);
            $insert->bindParam(2,$email);
            $insert->bindParam(3,$hash_password);
            $insert->execute();

            $id = $db->lastInsertId();

           
            $insert2 = $db->prepare("INSERT INTO lm_employee_details (employee_id,gender,job,salary) VALUES (?,?,?,?)");
            $insert2->bindParam(1, $id);
            $insert2->bindParam(2, $gender);
            $insert2->bindParam(3, $job);
            $insert2->bindParam(4, $salary);
            $insert2->execute();

             // Make the changes to the database permanent
            $db->commit();
            $data = array(
                "status" => true,
                "message" => "User Successfully Created"
            );
          
            
        }
    } catch (\Throwable $e) {
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
}

else {
    $data = array(
        "status"=> false,
        "message"=>"Oops.. something went wrong."
    );
   
}
$data = removeEmptyValues($data);
print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));

}