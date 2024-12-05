<?php

$user_type = $_SESSION['UserType'];
$data_point = $_POST['data_point'];
$count = $_POST['count'] ? $_POST['count'] : 1;
$data_count = 0;
ini_set('precision', 10);
ini_set('serialize_precision', 10);

if ($data_point == '1') {
//    $village_count = $db->prepare("SELECT COUNT(T1.ID) AS VillageCount
//                                FROM lm_village T1
//                                WHERE T1.Active = ?
//                                ");
//    $village_count->bindValue(1, 1);
//    $village_count->execute();
//    $village_count = $village_count->fetch();
//    $village_count = $village_count['VillageCount'];
    $count++;
    $db_respose_array = array('count' => $count, 'point1' => '--');
} else if ($data_point == '2') {
//    $village_acquired = $db->prepare("SELECT T2.VillageCode, COUNT(T3.ID) AS KashtkarCount, KashtkarBainamaCount
//                                    FROM lm_village T1
//                                    LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
//                                    LEFT JOIN lm_gata_kashtkar T3 ON (T3.VillageCode = T2.VillageCode AND T3.GataNo = T2.GataNo)
//                                    LEFT JOIN (
//                                        SELECT T4.VillageCode, T4.GataNo, T4.KhataNo, COUNT(T4.ID) AS KashtkarBainamaCount
//                                        FROM lm_gata_ebasta T4
//                                        WHERE MATCH(T4.Ebasta2) AGAINST (?)
//                                        GROUP BY T4.VillageCode
//                                    ) TMP ON TMP.VillageCode = T2.VillageCode
//                                    WHERE T1.Active = ?
//                                    AND T2.BoardApproved = ?
//                                    GROUP BY T2.VillageCode
//                                    ");
//    $village_acquired->bindValue(1, 'file_name');
//    $village_acquired->bindValue(2, 1);
//    $village_acquired->bindValue(3, 'YES');
//    $village_acquired->execute();
//    $village_acquired_count = 0;
//    $village_partially_acquired_count = 0;
//    while ($row = $village_acquired->fetch()) {
//        if ($row['KashtkarCount'] == $row['KashtkarBainamaCount']) {
//            $village_acquired_count++;
//        } else {
//            if ($row['KashtkarBainamaCount']) {
//                $village_partially_acquired_count++;
//            }
//        }
//    }
    $count++;
    $db_respose_array = array('count' => $count, 'point1' => '--');
} else if ($data_point == '3') {
//    $block17_count = $db->prepare("SELECT ROUND(SUM(T2.Area), 4) AS AreaAccquired
//                                FROM lm_village T1
//                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
//                                WHERE T1.Active = ?
//                                AND T2.BoardApproved = ?
//                                AND (T2.Shreni = ? OR T2.Shreni = ? OR T2.Shreni LIKE ? OR T2.Shreni LIKE ?)
//                                ");
//    $block17_count->bindValue(1, '1');
//    $block17_count->bindValue(2, 'YES');
//    $block17_count->bindValue(3, '1-क');
//    $block17_count->bindValue(4, '2');
//    $block17_count->bindValue(5, '5%');
//    $block17_count->bindValue(6, '6%');
//    $block17_count->execute();
//    $block17_count = $block17_count->fetch();
//    $area_to_acquired = $block17_count['AreaAccquired'];
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => '--');
} else if ($data_point == '4') {
//    $block29_count = $db->prepare("SELECT T1.ID, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.OwnerNo, ROUND(SUM(T1.AnshRakba), 4) AS AnshRakba, T2.Shreni
//                                FROM lm_gata_ebasta T1
//                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo
//
//                                WHERE T2.BoardApproved = ?
//                                AND (T2.Shreni = ? OR T2.Shreni = ? OR T2.Shreni LIKE ? OR T2.Shreni LIKE ?)
//                                AND MATCH(T1.Ebasta2) AGAINST (?)
//                                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
//                                ");
//    $block29_count->bindValue(1, 'YES');
//    $block29_count->bindValue(2, '1-क');
//    $block29_count->bindValue(3, '2');
//    $block29_count->bindValue(4, '5%');
//    $block29_count->bindValue(5, '6%');
//    $block29_count->bindValue(6, 'file_name');
//    $block29_count->execute();
//    $area_purchased_till_date = 0;
//    while ($row = $block29_count->fetch()) {
//        $area_purchased_till_date += $row['AnshRakba'];
//    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => '--');
} else if ($data_point == '5') {
//    $block29_count = $db->prepare("SELECT T1.ID, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.OwnerNo, ROUND(SUM(T1.AnshRakba), 4) AS AnshRakba, T2.Shreni
//                                FROM lm_gata_ebasta T1
//                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo
//
//                                WHERE T2.BoardApproved = ?
//                                AND (T2.Shreni = ? OR T2.Shreni = ? OR T2.Shreni LIKE ? OR T2.Shreni LIKE ?)
//                                AND MATCH(T1.Ebasta2) AGAINST (?)
//                                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
//                                ");
//    $block29_count->bindValue(1, 'YES');
//    $block29_count->bindValue(2, '1-क');
//    $block29_count->bindValue(3, '2');
//    $block29_count->bindValue(4, '5%');
//    $block29_count->bindValue(5, '6%');
//    $block29_count->bindValue(6, 'file_name');
//    $block29_count->execute();
//    $area_purchased_till_date = 0;
//    while ($row = $block29_count->fetch()) {
//        $area_purchased_till_date += $row['AnshRakba'];
//    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => '--');
} else if ($data_point == '6') {
//    $village_acquired = $db->prepare("SELECT T2.VillageCode, COUNT(T3.ID) AS KashtkarCount, KashtkarBainamaCount
//                                    FROM lm_village T1
//                                    LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
//                                    LEFT JOIN lm_gata_kashtkar T3 ON (T3.VillageCode = T2.VillageCode AND T3.GataNo = T2.GataNo)
//                                    LEFT JOIN (
//                                        SELECT T4.VillageCode, T4.GataNo, T4.KhataNo, COUNT(T4.ID) AS KashtkarBainamaCount
//                                        FROM lm_gata_ebasta T4
//                                        WHERE MATCH(T4.Ebasta2) AGAINST (?)
//                                        GROUP BY T4.VillageCode
//                                    ) TMP ON TMP.VillageCode = T2.VillageCode
//                                    WHERE T1.Active = ?
//                                    AND T2.BoardApproved = ?
//                                    GROUP BY T2.VillageCode
//                                    ");
//    $village_acquired->bindValue(1, 'file_name');
//    $village_acquired->bindValue(2, 1);
//    $village_acquired->bindValue(3, 'YES');
//    $village_acquired->execute();
//    $village_acquired_count = 0;
//    $village_partially_acquired_count = 0;
//    while ($row = $village_acquired->fetch()) {
//        if ($row['KashtkarCount'] == $row['KashtkarBainamaCount']) {
//            $village_acquired_count++;
//        } else {
//            if ($row['KashtkarBainamaCount']) {
//                $village_partially_acquired_count++;
//            }
//        }
//    }
    $count++;
    $db_respose_array = array('count' => $count, 'point1' => '--');
} else if ($data_point == '7') {
//    $block17_count = $db->prepare("SELECT ROUND(SUM(T2.Area), 4) AS AreaAccquired
//                                FROM lm_village T1
//                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
//                                WHERE T1.Active = ?
//                                AND T2.BoardApproved = ?
//                                AND (T2.Shreni = ? OR T2.Shreni = ? OR T2.Shreni LIKE ? OR T2.Shreni LIKE ?)
//                                ");
//    $block17_count->bindValue(1, '1');
//    $block17_count->bindValue(2, 'YES');
//    $block17_count->bindValue(3, '1-क');
//    $block17_count->bindValue(4, '2');
//    $block17_count->bindValue(5, '5%');
//    $block17_count->bindValue(6, '6%');
//    $block17_count->execute();
//    $block17_count = $block17_count->fetch();
//    $area_to_acquired = $block17_count['AreaAccquired'];
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => '--');
} else if ($data_point == '8') {
//    $block29_count = $db->prepare("SELECT T1.ID, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.OwnerNo, ROUND(SUM(T1.AnshRakba), 4) AS AnshRakba, T2.Shreni
//                                FROM lm_gata_ebasta T1
//                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo
//
//                                WHERE T2.BoardApproved = ?
//                                AND (T2.Shreni = ? OR T2.Shreni = ? OR T2.Shreni LIKE ? OR T2.Shreni LIKE ?)
//                                AND MATCH(T1.Ebasta2) AGAINST (?)
//                                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
//                                ");
//    $block29_count->bindValue(1, 'YES');
//    $block29_count->bindValue(2, '1-क');
//    $block29_count->bindValue(3, '2');
//    $block29_count->bindValue(4, '5%');
//    $block29_count->bindValue(5, '6%');
//    $block29_count->bindValue(6, 'file_name');
//    $block29_count->execute();
//    $area_purchased_till_date = 0;
//    while ($row = $block29_count->fetch()) {
//        $area_purchased_till_date += $row['AnshRakba'];
//    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => '--');
} else if ($data_point == '9') {
//    $block29_count = $db->prepare("SELECT T1.ID, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.OwnerNo, ROUND(SUM(T1.AnshRakba), 4) AS AnshRakba, T2.Shreni
//                                FROM lm_gata_ebasta T1
//                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo
//
//                                WHERE T2.BoardApproved = ?
//                                AND (T2.Shreni = ? OR T2.Shreni = ? OR T2.Shreni LIKE ? OR T2.Shreni LIKE ?)
//                                AND MATCH(T1.Ebasta2) AGAINST (?)
//                                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
//                                ");
//    $block29_count->bindValue(1, 'YES');
//    $block29_count->bindValue(2, '1-क');
//    $block29_count->bindValue(3, '2');
//    $block29_count->bindValue(4, '5%');
//    $block29_count->bindValue(5, '6%');
//    $block29_count->bindValue(6, 'file_name');
//    $block29_count->execute();
//    $area_purchased_till_date = 0;
//    while ($row = $block29_count->fetch()) {
//        $area_purchased_till_date += $row['AnshRakba'];
//    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => '--');
}

$db_respose_data = json_encode(array('status' => '1', 'message' => '', 'success_array' => $db_respose_array));
print_r($db_respose_data);
exit();
