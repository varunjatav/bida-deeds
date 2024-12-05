<?php

$village_code = $_POST['village_code'];
$type = $_POST['type'];

if ($type == '1') {
    $gata_query = $db->prepare("SELECT T1.UID, T1.KhataNo, T1.GataNo, T1.Area
                                FROM lm_gata T1
                                WHERE T1.VillageCode = ?
                                AND T1.BoardApproved = ?
                                GROUP BY T1.KhataNo, T1.GataNo, T1.Area
                                ORDER BY CAST(T1.GataNo AS FLOAT), T1.GataNo ASC
                                ");
    $gata_query->bindParam(1, $village_code);
    $gata_query->bindValue(2, 'YES');
    $gata_query->execute();
    $gata_query->setFetchMode(PDO::FETCH_ASSOC);
    $gataInfo = $gata_query->fetchAll();
} else if ($type == '2') {
    $gata_query = $db->prepare("SELECT T1.UID, T1.KhataNo, T1.GataNo, T1.Area
                                FROM lm_gata T1
                                WHERE T1.VillageCode = ?
                                AND T1.BoardApproved = ?
                                GROUP BY T1.GataNo
                                ORDER BY CAST(T1.GataNo AS FLOAT), T1.GataNo ASC
                                ");
    $gata_query->bindParam(1, $village_code);
    $gata_query->bindValue(2, 'YES');
    $gata_query->execute();
    $gata_query->setFetchMode(PDO::FETCH_ASSOC);
    $gataInfo = $gata_query->fetchAll();
} else {
    $gata_query = $db->prepare("SELECT T1.UID, T1.KhataNo, T1.GataNo, T1.Area
                                FROM lm_gata T1
                                WHERE T1.VillageCode = ?
                                AND T1.BoardApproved = ?
                                GROUP BY T1.KhataNo, T1.GataNo, T1.Area
                                ORDER BY CAST(T1.GataNo AS FLOAT), T1.GataNo ASC
                                ");
    $gata_query->bindParam(1, $village_code);
    $gata_query->bindValue(2, 'YES');
    $gata_query->execute();
    $gata_query->setFetchMode(PDO::FETCH_ASSOC);
    $gataInfo = $gata_query->fetchAll();
}