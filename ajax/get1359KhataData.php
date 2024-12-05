<?php
$village_code = $_REQUEST['village_code'];
$gata_query = $db->prepare("SELECT T1.UID, T1.KhataNo, T1.GataNo, T1.Area
                                FROM lm_api_1359_fasli_data T1
                                WHERE T1.VillageCode = ?
                                ");
    $gata_query->bindParam(1, $village_code);
    $gata_query->execute();
    $gata_query->setFetchMode(PDO::FETCH_ASSOC);
    $gataInfo = $gata_query->fetchAll();

