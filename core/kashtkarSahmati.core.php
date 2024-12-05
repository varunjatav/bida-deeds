<?php

$user_id = $_SESSION['UserID'];
$mobile = $_SESSION['Mobile'];

$griev_query = $db->prepare("SELECT T1.*, T2.VillageNameHi, T4.Name AS Lekhpal, T4.Mobile AS LekhpalMobile, T6.Name AS OSD, T6.Mobile AS OsdMobile
                                FROM lm_kashtkar_sahmati T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                LEFT JOIN lm_user_village_gata_mapping T3 ON (T3.VillageCode = T1.VillageCode AND T3.GataNo = T1.GataNo)
                                LEFT JOIN lm_users T4 ON T4.ID = T3.UserID
                                LEFT JOIN lm_user_village_mapping T5 ON T5.VillageCode = T1.VillageCode
                                LEFT JOIN lm_users T6 ON T6.ID = T5.UserID
                                WHERE T1.Mobile = ?
                                ORDER BY T1.ID DESC
                                ");
$griev_query->bindValue(1, 1);
$griev_query->bindParam(1, $mobile);
$griev_query->execute();
$griev_query->setFetchMode(PDO::FETCH_ASSOC);
$grievInfo = $griev_query->fetchAll();
