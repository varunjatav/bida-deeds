<?php
// echo "inside cores file";

try {
    $city_query = $db->prepare("SELECT city_name FROM lm_city");
    $city_query->execute();
    $city_query->setFetchMode(PDO::FETCH_ASSOC);
    $cityInfo = $city_query->fetchAll();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}


if (!$db) {
    die("Database connection failed.");
}