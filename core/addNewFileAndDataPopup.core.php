<?php
// echo "inside cores file";

// try {
//     $city_query = $db->prepare("SELECT city_name FROM lm_city;");
//     // echo $city_query;
//     $city_query->execute();
//     $city_query->setFetchMode(PDO::FETCH_ASSOC);
//     $cityInfo = $city_query->fetchAll();
//     echo "<pre>", print_r($cityInfo);

//     // $pincode_query = $db->prepare("SELECT pincode FROM lm_pincodes LIMIT 1;");
//     // $pincode_query->execute();
//     // $pincode_query->setFetchMode(PDO::FETCH_ASSOC);
//     // $pincodeInfo = $pincode_query->fetchAll();
//     // echo "pincode query -->", $pincode_query;
// } catch (Exception $e) {
//     echo "Error: " . $e->getMessage();
// }


// // if (!$db) {
// //     die("Database connection failed.");
// // }else{
// //     echo "Database connection passed.";
// // }

$village_query = $db->prepare("SELECT T1.city_name
                        FROM lm_city T1");
// $village_query->bindValue(1, 1);
// $village_query->bindParam(2, $user_id);
$village_query->execute();
$village_query->setFetchMode(PDO::FETCH_ASSOC);
$villageInfo = $village_query->fetchAll();

print_r($villageInfo);