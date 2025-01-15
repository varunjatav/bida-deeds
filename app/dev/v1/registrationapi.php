<?php
include_once '../../../config.php';
include_once "../../../dbcon/db_connect.php";

header('Content-type: application/json');


if($_SERVER['REQUEST_METHOD']==='POST'){
   
    try {
        $email = $_POST["email"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $gender = $_POST["gender"];
        $job = $_POST["job"];
        $salary = $_POST["salary"];
   

        $stmt = $db->prepare("SELECT * FROM lm_employees WHERE email = ?");
        $stmt->bindParam(1,$email);
        $stmt->execute();
        $check = $stmt->rowCount();
       
        if($check > 0){
            http_response_code(404);
                $server__response__error = array(
                    "code" => http_response_code(404),
                    "status" => false,
                    "message" => "This user is already registered."
                );
                echo json_encode($server__response__error);
        }else{
            $hash_password = password_hash($password,PASSWORD_DEFAULT);
            $insert = $db->prepare("INSERT INTO lm_employees (username, email,password) VALUES (?,?,?)");
            $insert->bindParam(1,$username);
            $insert->bindParam(2,$email);
            $insert->bindParam(3,$hash_password);
            $insert->execute();

            $id = $db->lastInsertId();

           
            $insert2 = $db->prepare("INSERT INTO  lm_employee_details (employee_id,gender,job,salary) VALUES (?,?,?,?)");
            $insert2->bindParam(1, $id);
            $insert2->bindParam(2, $gender);
            $insert2->bindParam(3, $job);
            $insert2->bindParam(4, $salary);
            $insert2->execute();

            http_response_code(200);
            $server__response__error = array(
                "code" => http_response_code(200),
                "status" => true,
                "message" => "User Successfully Created"
            );
            echo json_encode($server__response__error);
            
        }
    } catch (\Throwable $th) {
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