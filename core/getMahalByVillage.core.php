<?php

$village_id = decryptIt(myUrlEncode($_REQUEST['village_id']));

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

