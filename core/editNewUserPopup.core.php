<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       // Include database connection
       require 'db_connection.php';

       // Sanitize input data
       // $file_id = (int) htmlspecialchars($_POST['file_id']);

       if (!isset($_POST['file_id']) || !is_numeric($_POST['file_id'])) {
              die("Invalid ID. Only numeric values are allowed.");
       }
       error_log("Received file_id: " . print_r($_POST['file_id'], true)); // Log the value of file_id

       $file_id = (int) htmlspecialchars($_POST['file_id']);
       $file_uid = htmlspecialchars($_POST['file_uid']);
       $file_vcode = htmlspecialchars($_POST['file_vcode']);
       $name = htmlspecialchars($_POST['name']);
       $user_name = htmlspecialchars($_POST["user_name"]);
       $email = htmlspecialchars($_POST['email']);
       $mobile = htmlspecialchars($_POST['mobile']);
       $password = htmlspecialchars($_POST['password']);
       $c_password = htmlspecialchars(($_POST["confirm_password"]));
       $designation = htmlspecialchars($_POST["designation"]);
       $address = htmlspecialchars($_POST["address"]);
       $gender = htmlspecialchars($_POST["gender"]);
       try {
              // Prepare the update query
              $update_query = $db->prepare("UPDATE user_info 
                                      SET Name = ?, USER_NAME = ?, Email = ?, Password = ?, Confirm_Password = ?, Mobile_NO = ?, 
                                      Desingation = ?, Address = ?
                                      WHERE ID = ?");
              $update_query->bindParam(1, $name);
              $update_query->bindParam(2, $user_name);
              $update_query->bindParam(3, $email);
              $update_query->bindParam(4, $password);
              $update_query->bindParam(5, $c_password);
              $update_query->bindParam(6, $mobile);
              $update_query->bindParam(7, $designation);
              $update_query->bindParam(8, $address);
              $update_query->bindParam(9, $gender);
              //  $update_query->bindParam(6, $file_vcode);

              // Execute the query
              if ($update_query->execute()) {
                     echo "Data updated successfully.";
              } else {
                     print_r($update_query->errorInfo());
              }
       } catch (PDOException $e) {
              echo "Error: " . $e->getMessage();
       }
}
