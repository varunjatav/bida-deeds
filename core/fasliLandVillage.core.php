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
    $user_village_code = getUserVillageMapping($db, $user_id);
    $village_code_list_array = implode("','", $user_village_code);
    $mahal = $db->prepare("SELECT T1.ID, T1.MahalName, T1.VillageCode
                        FROM lm_village_mahal_names T1
                        WHERE T1.VillageCode IN ('$village_code_list_array')
                        ORDER BY T1.MahalName ASC
                        ");
    $mahal->execute();
    $mahal->setFetchMode(PDO::FETCH_ASSOC);
    $mahal_data_array = array();
    while ($row = $mahal->fetch()) {
        $mahal_data_array[] = $row;
    }
}