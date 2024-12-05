<?php

$user_type = $_SESSION['UserType'];
$village_code = decryptIt(myUrlEncode($_REQUEST['village_code']));
$lekhpal_user_id = decryptIt(myUrlEncode($_REQUEST['lekhpal_user_id']));
$lekhpal_name = decryptIt(myUrlEncode($_REQUEST['lekhpal_name']));
$title = $_REQUEST['title'];

$column_arr = array();
$column_head = array();

$column_arr = explode(',', $_REQUEST['column_arr']);
$column_head = explode(',', $_REQUEST['column_head']);

$sql = $db->prepare("SELECT T1.GataNo, T3.KhataNo, T3.owner_name, T3.owner_father, GROUP_CONCAT(T4.Type) AS Type, GROUP_CONCAT(T4.Attachment) AS Attachment
                        FROM lm_user_village_gata_mapping T1
                        LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo)
                        LEFT JOIN lm_gata_kashtkar T3 ON (T3.VillageCode = T2.VillageCode AND T3.GataNo = T2.GataNo)
                        LEFT JOIN lm_lekhpal_ebasta T4 ON T4.VillageCode = T3.VillageCode AND T4.KhataNo = T3.KhataNo AND T4.GataNo = T3.GataNo AND T4.OwnerNo = T3.OwnerNo
                        WHERE T2.BoardApproved = ?
                        AND T1.VillageCode = ?
                        AND T1.UserID = ?
                        AND (T2.Shreni = ? OR T2.Shreni = ?)
                        GROUP BY T3.owner_name, T3.owner_father
                        ORDER BY CAST(T1.GataNo AS FLOAT), T1.GataNo ASC
                        ");
$sql->bindValue(1, 'YES');
$sql->bindParam(2, $village_code);
$sql->bindParam(3, $lekhpal_user_id);
$sql->bindValue(4, '1-क');
$sql->bindValue(5, '2');
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
