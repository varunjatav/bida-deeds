<?php

$user_id = $_SESSION['UserID'];
$user_type = $_SESSION['UserType'];
$id = decryptIt(myUrlEncode($_POST['id']));

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

$village_code_list = implode("','", $village_names_code_array);

$sql = "SELECT T1.*, T2.VillageName, T2.VillageNameHi
        FROM lm_api_1359_fasli_data T1
        LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
        WHERE T1.VillageCode  IN ('$village_code_list_array')
        AND T1.ID = ?
        ";
$i = 1;
$sql = $db->prepare($sql);
$sql->bindParam($i++, $id);
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
$row = $sql->fetch();

$mahal_name = $row['MahalName'];
$village_id =  $row['VillageCode'];
$khata_no_1359 = $row['1359_fasli_khata'];
$gata_no_1359 = $row['1359_fasli_gata'];

$mahal_query = $db->prepare("SELECT DISTINCT T1.KhataNo
                        FROM lm_land_data T1
                        WHERE T1.MahalKaName = ?
                        AND T1.VillageCode = ?
                        ORDER BY T1.KhataNo ASC
                        ");
$mahal_query->bindParam(1, $mahal_name);
$mahal_query->bindParam(2, $village_id);
$mahal_query->execute();
$mahal_query->setFetchMode(PDO::FETCH_ASSOC);
$khataInfo = $mahal_query->fetchAll();

$gata_query = $db->prepare("SELECT DISTINCT T1.GataNo
                        FROM lm_land_data T1
                        WHERE T1.MahalKaName = ?
                        AND T1.VillageCode = ?
                        AND T1.KhataNo = ?
                        ORDER BY T1.GataNo ASC
                        ");
$gata_query->bindParam(1, $mahal_name);
$gata_query->bindParam(2, $village_id);
$gata_query->bindParam(3, $khata_no_1359);
$gata_query->execute();
$gata_query->setFetchMode(PDO::FETCH_ASSOC);
$gataInfo = $gata_query->fetchAll();

