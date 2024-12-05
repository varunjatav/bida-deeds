<?php

$village_code = $_POST['village_code'];
$gata_no = $_POST['gata_no'];

$village_query = $db->prepare("SELECT T1.KhataNo
                                FROM lm_gata_kashtkar T1
                                WHERE T1.VillageCode = ?
                                AND T1.GataNo = ?
                                GROUP BY T1.KhataNo
                                ");
$village_query->bindParam(1, $village_code);
$village_query->bindParam(2, $gata_no);
$village_query->execute();
$village_query->setFetchMode(PDO::FETCH_ASSOC);
$khataInfo = $village_query->fetchAll();
