<?php

$mahal_name = $_REQUEST['mahal_name'];
$village_id = $_REQUEST['village_id'];


$mahal_query = $db->prepare("SELECT DISTINCT T1.KhataNo
                        FROM lm_land_data T1
                        WHERE T1.MahalKaName = ?
                        AND T1.VillageCode = ?
                        ORDER BY T1.KhataNo ASC
                        ");
$mahal_query->bindParam(1, $mahal_name);
$mahal_query->bindParam(2, $village_id);
$mahal_query->execute();
$mahal_query->setFetchMode(PDO::FETCH_ASSOC);
$khataInfo = $mahal_query->fetchAll();

