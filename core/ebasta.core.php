<?php

$user_type = $_SESSION['UserType'];
$village_code = $_POST['village_code'];
$village_name = $_POST['village_name'];

$village_query = $db->prepare("SELECT T3.Shreni, T1.GataNo, T3.Area, T1.KhataNo, T1.OwnerNo, T1.owner_name, T1.owner_father, T2.KashtkarAnsh, T2.AnshRakba, T2.AnshDate, T2.Ebasta2, T2.VilekhSankhya
                                FROM lm_gata_kashtkar T1
                                LEFT JOIN lm_gata_ebasta T2 ON T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.OwnerNo = T1.OwnerNo AND T2.KhataNo = T1.KhataNo
                                LEFT JOIN lm_gata T3 ON T3.VillageCode = T1.VillageCode AND T3.GataNo = T1.GataNo AND T3.KhataNo = T1.KhataNo
                                WHERE T1.VillageCode = ?
                                AND T3.BoardApproved = ?
                                ");
$village_query->bindParam(1, $village_code);
$village_query->bindValue(2, 'YES');
$village_query->execute();
$village_query->setFetchMode(PDO::FETCH_ASSOC);
$ebastaInfo = $village_query->fetchAll();
