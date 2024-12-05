<?php

$user_id = $_SESSION['UserID'];
$mobile = $_SESSION['Mobile'];
$file_id = decryptIt(myUrlEncode($_REQUEST['file_id']));
$file_uid = decryptIt(myUrlEncode($_REQUEST['file_uid']));
$file_vcode = decryptIt(myUrlEncode($_REQUEST['file_vcode']));

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

$village_id = $file_vcode;//$villageInfo[0]['VillageCode'];

$mahal_query = $db->prepare("SELECT T1.ID, T1.MahalName
                        FROM lm_village_mahal_names T1
                        WHERE T1.Active = ?
                        AND T1.VillageCode = ?
                        ");
$mahal_query->bindValue(1, 1);
$mahal_query->bindParam(2, $village_id);
$mahal_query->execute();
$mahal_query->setFetchMode(PDO::FETCH_ASSOC);

$village_code_list = implode("','", $village_names_code_array);

$lm_data = $db->prepare("SELECT SQL_CALC_FOUND_ROWS T1.ID, T1.UniqueID, T1.MahalKaName, T1.VillageCode, T1.Shreni, T1.KhataNo, T1.KashtkarDarjStithi, T1.DateCreated, T1.Vivran, T2.VillageName, T1.GataNo, T1.Area, T1.Vivran
                    FROM lm_land_data T1
                    LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                    WHERE T1.ID = ? 
                    AND T1.UniqueID = ?
                    AND T2.VillageCode NOT IN ('$village_code_list')
                    LIMIT 1
       ");
$lm_data->bindParam(1, $file_id);
$lm_data->bindParam(2, $file_uid);
$lm_data->execute();
$lm_data->setFetchMode(PDO::FETCH_ASSOC);
$lm_dataInfo = $lm_data->fetch();
