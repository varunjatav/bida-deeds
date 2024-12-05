<?php

$user_id = $_SESSION['UserID'];
$user_type = $_SESSION['UserType'];

$village_code_list = implode("','", $village_names_code_array);
if ($user_type == '0' || $user_type == '2' || $user_type == '3' || $user_type == '4' || $user_type == '6' || $user_type == '8') {
    $village_query = $db->prepare("SELECT T1.VillageName, T1.VillageCode
                        FROM lm_village T1
                        WHERE T1.Active = ?
                        AND T1.VillageCode NOT IN ('$village_code_list')
                        ORDER BY T1.VillageName ASC
                        ");
    $village_query->bindValue(1, 1);
    $village_query->execute();
    $village_query->setFetchMode(PDO::FETCH_ASSOC);
    $villageInfo = $village_query->fetchAll();
} else {
    $village_query = $db->prepare("SELECT T1.VillageName, T1.VillageCode
                        FROM lm_village T1
                        LEFT JOIN lm_user_village_mapping T2 ON T2.VillageCode = T1.VillageCode
                        WHERE T1.Active = ?
                        AND T2.UserID = ?
                        AND T1.VillageCode NOT IN ('$village_code_list')
                        ORDER BY T1.VillageName ASC
                        ");
    $village_query->bindValue(1, 1);
    $village_query->bindParam(2, $user_id);
    $village_query->execute();
    $village_query->setFetchMode(PDO::FETCH_ASSOC);
    $villageInfo = $village_query->fetchAll();
}