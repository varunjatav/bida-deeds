<?php

$village_code = $_POST['village_code'];
$gata_no = $_POST['gata_no'];
$khata_no = $_POST['khata_no'];

$village_query = $db->prepare("SELECT T1.OwnerNo, T1.owner_name, T1.owner_father, T1.Area
                                FROM lm_gata_kashtkar T1
                                WHERE T1.VillageCode = ?
                                AND T1.GataNo = ?
                                AND T1.KhataNo = ?
                                ");
$village_query->bindParam(1, $village_code);
$village_query->bindParam(2, $gata_no);
$village_query->bindParam(3, $khata_no);
$village_query->execute();
$village_query->setFetchMode(PDO::FETCH_ASSOC);
$kashtkarInfo = $village_query->fetchAll();
