<?php
// echo "inside cores file";

try {
    $city_query = $db->prepare("SELECT city_name FROM lm_city;");
    // echo $city_query;
    $city_query->execute();
    $city_query->setFetchMode(PDO::FETCH_ASSOC);
    $cityInfo = $city_query->fetchAll();
    // echo $cityInfo;

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}


// if (!$db) {
//     die("Database connection failed.");
// }else{
//     echo "Database connection passed.";
// }