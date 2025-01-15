<?php
include_once '../../../config.php';
include_once "../../../dbcon/db_connect.php";

header('Content-type: application/json');

if($_SERVER['REQUEST_METHOD'] === "POST"){
  
    try {
       $email = $_POST["email"];
       $password = $_POST["password"];
   

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
            http_response_code(200);
            $user_verify_data = array(
                "code" => http_response_code(200),
                "status" => true,
                "message" => "User Verified",
                "userData" => $user_array
            );
            echo json_encode($user_verify_data);
        }else{
            http_response_code(404);
            $server__response__error = array(
                "code" => http_response_code(404),
                "status" => false,
                "message" => "Opps!! Incorrect Login Credentials"
            );
            echo json_encode($server__response__error);
        }
       }
       else
       {
        http_response_code(404);
        $server__response__error = array(
            "code" => http_response_code(404),
            "status" => true,
            "message" => "User Not Registered",
            "userData" => null
        );
        echo json_encode($server__response__error);
       }

    } 
    catch (\Throwable $th) 
    {
        http_response_code(404);
        $server__response__error = array(
            "code" => http_response_code(404),
            "status" => false,
            "message" => "Opps!! Something Went Wrong! " . $th->getMessage()
        );
        echo json_encode($server__response__error);
    }
}
else {
    http_response_code(404);
    $server__response__error = array(
        "code" => http_response_code(404),
        "status"=>false,
        "message"=>"Failed"
    );
    echo json_encode($server__response__error);
}

?>