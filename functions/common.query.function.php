<?php

function getUserVillageMapping($db, $user_id) {
    $mahal_query = $db->prepare("SELECT T1.VillageCode
                                FROM lm_user_village_mapping T1
                                WHERE T1.UserID = ?");
    $mahal_query->bindParam(1, $user_id);
    $mahal_query->execute();
    $mahal_query->setFetchMode(PDO::FETCH_ASSOC);
    $mahal_data_array = array();
    while ($row = $mahal_query->fetch()) {
        $mahal_data_array[] = $row['VillageCode'];
    }
    return $mahal_data_array;
}

