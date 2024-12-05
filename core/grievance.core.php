<?php

$user_id = $_SESSION['UserID'];
$mobile = $_SESSION['Mobile'];

$village_query = $db->prepare("SELECT T1.VillageName, T1.VillageNameHi, T1.VillageCode
                        FROM lm_village T1
                        WHERE T1.Active = ?
                        ORDER BY T1.VillageName ASC
                        ");
$village_query->bindValue(1, 1);
$village_query->execute();
$village_query->setFetchMode(PDO::FETCH_ASSOC);
$villageInfo = $village_query->fetchAll();

$griev_query = $db->prepare("SELECT T1.*
                                FROM lm_global_grievances T1
                                WHERE T1.Active = ?
                                ");
$griev_query->bindValue(1, 1);
$griev_query->execute();
$griev_query->setFetchMode(PDO::FETCH_ASSOC);
$griev_query->setFetchMode(PDO::FETCH_ASSOC);
$grievInfo = $griev_query->fetchAll();