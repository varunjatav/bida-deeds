<?php
echo "inside cores file";
$user_id = $_SESSION['UserID'];
// $mobile = $_SESSION['Mobile'];
echo $user_id;
// $city_name = $_REQUEST["city_name"];
// echo $city_name;

$city_query = $db->prepare(" SELECT c.city_name, p.pincode 
    FROM lm_city c
    INNER JOIN lm_pincodes p ON c.ID = p.city_id
    WHERE c.ID = ?
    ORDER BY c.city_name, p.pincode
                        ");
$city_query->bindValue(1, 1);
$city_query->bindParam(2, $user_id);
$city_query->execute();
$city_query->setFetchMode(PDO::FETCH_ASSOC);
$cityInfo = $city_query->fetchAll();

// $city_id = $cityInfo[0]['city_id'];

// $pincode_query = $db->prepare("SELECT p.pincode
//                                     FROM pincodes p
//                                     INNER JOIN city c ON c.ID = p.city_id
//                                     WHERE c.city_name = 'Jhansi';
//                         ");
// $pincode_query->bindValue(1, 1);
// $pincode_query->bindParam(2, $city_id);
// $pincode_query->execute();
// $pincode_query->setFetchMode(PDO::FETCH_ASSOC);