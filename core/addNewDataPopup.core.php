<?php

$user_id = $_SESSION['UserID'];
$mobile = $_SESSION['Mobile'];

$village_query = $db->prepare("SELECT T1.VillageName, T1.VillageNameHi, T1.VillageCode
                        FROM lm_village T1
                        LEFT JOIN lm_user_village_mapping T2 ON T2.VillageCode = T1.VillageCode
                        WHERE T1.Active = ?
                        AND T2.UserID = ?
                        ORDER BY T1.VillageName ASC
                        ");
$village_query->bindValue(1, 1);
$village_query->bindParam(2, $user_id);
$village_query->execute();
$village_query->setFetchMode(PDO::FETCH_ASSOC);
$villageInfo = $village_query->fetchAll();

$village_id = $villageInfo[0]['VillageCode'];

$mahal_query = $db->prepare("SELECT T1.ID, T1.MahalName
                        FROM lm_village_mahal_names T1
                        WHERE T1.Active = ?
                        AND T1.VillageCode = ?
                        ORDER BY T1.MahalName ASC
                        ");
$mahal_query->bindValue(1, 1);
$mahal_query->bindParam(2, $village_id);
$mahal_query->execute();
$mahal_query->setFetchMode(PDO::FETCH_ASSOC);
