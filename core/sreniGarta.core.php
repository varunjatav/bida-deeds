<?php

$village_code = $_POST['village_code'];
$type = $_POST['type'];

    $gata_query = $db->prepare("SELECT T1.UID, T1.KhataNo, T1.GataNo, T1.Shreni , T1.Area
                                FROM lm_gata T1
                                WHERE T1.VillageCode = ?
                                ");
    $gata_query->bindParam(1, $village_code);
    $gata_query->execute();
    $gata_query->setFetchMode(PDO::FETCH_ASSOC);
    $gataInfo = $gata_query->fetchAll();