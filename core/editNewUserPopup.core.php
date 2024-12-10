<?php



if (isset($_REQUEST['file_id'])) {
   
       $file_id = decryptIt(myUrlEncode($_REQUEST['file_id']));
       // echo "step 1: ",$file_id ,"<br>";
       // $user_id = $_SESSION['UserID'];

       // echo "step 2: ",$user_id ,"<br>";
       // Prepare the SQL query
       $stmt = $db->prepare("SELECT * FROM user_info WHERE ID = ?");

       // Bind the parameter to the prepared statement (the first parameter is 1)
       $stmt->bindParam(1, $file_id, PDO::PARAM_INT); // Use $userId, bind to index 1

       // Execute the statement
       $stmt->execute();

       // Fetch the result
       $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
       // print_r($file_id, return: $user_id);
}
   
