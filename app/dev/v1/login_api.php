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
    $password = __fi(validateMaxLen($_REQUEST["password"], 255 , "Password"));

if($email & $password){
  
    try {

       $find_user = $db->prepare("SELECT * FROM lm_employees WHERE email = ?");
       $find_user->bindParam(1,$email);
       $find_user->execute();
       $check = $find_user->rowCount();

       if($check > 0)
       {
      
        $user_data = $find_user->fetch();
   
        
        if(password_verify($password, $user_data["password"]))
        {
            // echo "i/s verify";
            $user_array = array(
                "email" => $user_data["email"],
                "username" => $user_data["username"]
            );
            $data = array(
                "status" => true,
                "message" => "User Login Successfully",
                "userData" => $user_array
            );
           
        }else{
          
            $data = array(
                "status" => false,
                "message" => "Opps!! Incorrect Login Credentials"
            );
           
        }
       }
       else
       {
       
        $data = array(
            "status" => false,
            "message" => "User Not Registered",
            "userData" => null
        );
       
       }

    } 
    catch (\Throwable $e) 
    {
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
}
else {
    $data = array(
        "status"=>false,
        "message"=>"Opps!! Something Went Wrong! "
    );
    
}

$data = removeEmptyValues($data);
print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
}
?>