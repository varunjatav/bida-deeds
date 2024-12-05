<?php

$mahal_name = $_REQUEST['mahal_name'];
$village_id = $_REQUEST['village_id'];
$khata_no = $_REQUEST['khata_no'];

$mahal_query = $db->prepare("SELECT DISTINCT T1.GataNo
                        FROM lm_land_data T1
                        WHERE T1.MahalKaName = ?
                        AND T1.VillageCode = ?
                        AND T1.KhataNo = ?
                        ORDER BY T1.GataNo ASC
                        ");
$mahal_query->bindParam(1, $mahal_name);
$mahal_query->bindParam(2, $village_id);
$mahal_query->bindParam(3, $khata_no);
$mahal_query->execute();
$mahal_query->setFetchMode(PDO::FETCH_ASSOC);
$gataInfo = $mahal_query->fetchAll();

