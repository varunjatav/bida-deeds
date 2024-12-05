<?php

$user_type = $_SESSION['UserType'];
$data_point = $_POST['data_point'];
$count = $_POST['count'] ? $_POST['count'] : 1;
$data_count = 0;
ini_set('precision', 10);
ini_set('serialize_precision', 10);

if ($data_point == '1') {
    $village_count = $db->prepare("SELECT COUNT(T1.ID) AS VillageCount
                                FROM lm_village T1
                                WHERE T1.Active = ?
                                ");
    $village_count->bindValue(1, 1);
    $village_count->execute();
    $village_count = $village_count->fetch();
    $village_count = $village_count['VillageCount'];
    $count++;
    $db_respose_array = array('count' => $count, 'point1' => $village_count);
} else if ($data_point == '2') {
    $village_acquired = $db->prepare("SELECT T2.VillageCode, COUNT(T3.ID) AS KashtkarCount, KashtkarBainamaCount
                                    FROM lm_village T1
                                    LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                    LEFT JOIN lm_gata_kashtkar T3 ON (T3.VillageCode = T2.VillageCode AND T3.GataNo = T2.GataNo)
                                    LEFT JOIN (
                                        SELECT T4.VillageCode, T4.GataNo, T4.KhataNo, COUNT(T4.ID) AS KashtkarBainamaCount
                                        FROM lm_gata_ebasta T4
                                        WHERE MATCH(T4.Ebasta2) AGAINST (?)
                                        GROUP BY T4.VillageCode
                                    ) TMP ON TMP.VillageCode = T2.VillageCode
                                    WHERE T1.Active = ?
                                    AND T2.BoardApproved = ?
                                    GROUP BY T2.VillageCode
                                    ");
    $village_acquired->bindValue(1, 'file_name');
    $village_acquired->bindValue(2, 1);
    $village_acquired->bindValue(3, 'YES');
    $village_acquired->execute();
    $village_acquired_count = 0;
    $village_partially_acquired_count = 0;
    while ($row = $village_acquired->fetch()) {
        if ($row['KashtkarCount'] == $row['KashtkarBainamaCount']) {
            $village_acquired_count++;
        } else {
            if ($row['KashtkarBainamaCount']) {
                $village_partially_acquired_count++;
            }
        }
    }
    $count++;
    $db_respose_array = array('count' => $count, 'point1' => $village_acquired_count, 'point2' => $village_partially_acquired_count);
} else if ($data_point == '3') {
    $block17_count = $db->prepare("SELECT ROUND(SUM(T2.Area), 4) AS AreaAccquired
                                FROM lm_village T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                WHERE T1.Active = ?
                                AND T2.BoardApproved = ?
                                AND (T2.Shreni = ? OR T2.Shreni = ? OR T2.Shreni LIKE ? OR T2.Shreni LIKE ?)
                                ");
    $block17_count->bindValue(1, '1');
    $block17_count->bindValue(2, 'YES');
    $block17_count->bindValue(3, '1-क');
    $block17_count->bindValue(4, '2');
    $block17_count->bindValue(5, '5%');
    $block17_count->bindValue(6, '6%');
    $block17_count->execute();
    $block17_count = $block17_count->fetch();
    $area_to_acquired = $block17_count['AreaAccquired'];
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $area_to_acquired);
} else if ($data_point == '4') {
    $block29_count = $db->prepare("SELECT T1.ID, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.OwnerNo, ROUND(SUM(T1.AnshRakba), 4) AS AnshRakba, T2.Shreni
                                FROM lm_gata_ebasta T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo

                                WHERE T2.BoardApproved = ?
                                AND (T2.Shreni = ? OR T2.Shreni = ? OR T2.Shreni LIKE ? OR T2.Shreni LIKE ?)
                                AND MATCH(T1.Ebasta2) AGAINST (?)
                                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                                ");
    $block29_count->bindValue(1, 'YES');
    $block29_count->bindValue(2, '1-क');
    $block29_count->bindValue(3, '2');
    $block29_count->bindValue(4, '5%');
    $block29_count->bindValue(5, '6%');
    $block29_count->bindValue(6, 'file_name');
    $block29_count->execute();
    $area_purchased_till_date = 0;
    while ($row = $block29_count->fetch()) {
        $area_purchased_till_date += $row['AnshRakba'];
    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $area_purchased_till_date);
} else if ($data_point == '5') {
    $block17_count = $db->prepare("SELECT ROUND(SUM(CASE
                                        WHEN T2.Shreni = ? OR T2.Shreni = ? THEN T2.Area
                                        ELSE 0
                                        END), 4) AS AreaTobePurchased
                                FROM lm_village T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                WHERE T1.Active = ?
                                AND T2.BoardApproved = ?
                                ");
    $block17_count->bindValue(1, '1-क');
    $block17_count->bindValue(2, '2');
    $block17_count->bindValue(3, '1');
    $block17_count->bindValue(4, 'YES');
    $block17_count->execute();
    $block17_count = $block17_count->fetch();
    $area_to_be_purchased = $block17_count['AreaTobePurchased'];
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $area_to_be_purchased);
} else if ($data_point == '6') {
    $block30_count = $db->prepare("SELECT T1.ID, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.OwnerNo, ROUND(SUM(T1.AnshRakba), 4) AS AnshRakba, T2.Shreni
                                FROM lm_gata_ebasta T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo

                                WHERE T2.BoardApproved = ?
                                AND (T2.Shreni = ? OR T2.Shreni = ?)
                                AND MATCH(T1.Ebasta2) AGAINST (?)
                                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                                ");
    $block30_count->bindValue(1, 'YES');
    $block30_count->bindValue(2, '1-क');
    $block30_count->bindValue(3, '2');
    $block30_count->bindValue(4, 'file_name');
    $block30_count->execute();
    $gata_fully_purchased = 0;
    $gata_partially_purchased = 0;
    $area_purchased = 0;
    while ($row = $block30_count->fetch()) {
        $area_purchased += $row['AnshRakba'];
    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $area_purchased);
} else if ($data_point == '7') {
    $block17_count = $db->prepare("SELECT ROUND(SUM(CASE
                                        WHEN T2.Shreni LIKE ? OR T2.Shreni LIKE ? THEN T2.Area
                                        ELSE 0
                                        END), 4) AS AreaTobeResumpted
                                FROM lm_village T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                WHERE T1.Active = ?
                                AND T2.BoardApproved = ?
                                ");
    $block17_count->bindValue(1, '5%');
    $block17_count->bindValue(2, '6%');
    $block17_count->bindValue(3, '1');
    $block17_count->bindValue(4, 'YES');
    $block17_count->execute();
    $block17_count = $block17_count->fetch();
    $area_to_be_resumpted = $block17_count['AreaTobeResumpted'];
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $area_to_be_resumpted);
} else if ($data_point == '8') {
    $block31_count = $db->prepare("SELECT T1.ID, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.OwnerNo, ROUND(SUM(T1.AnshRakba), 4) AS AnshRakba, T2.Shreni
                                FROM lm_gata_ebasta T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo

                                WHERE T2.BoardApproved = ?
                                AND (T2.Shreni LIKE ? OR T2.Shreni LIKE ?)
                                AND MATCH(T1.Ebasta2) AGAINST (?)
                                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                                ");
    $block31_count->bindValue(1, 'YES');
    $block31_count->bindValue(2, '5%');
    $block31_count->bindValue(3, '6%');
    $block31_count->bindValue(4, 'file_name');
    $block31_count->execute();
    $gata_fully_resumpted = 0;
    $gata_partially_resumpted = 0;
    $area_resumption = 0;
    while ($row = $block31_count->fetch()) {
        $area_resumption += $row['AnshRakba'];
    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $area_resumption);
} else if ($data_point == '9') {
    $block17_count = $db->prepare("SELECT COUNT(T2.ID) AS GataCount
                                    FROM lm_village T1
                                    LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                    WHERE T1.Active = ?
                                    AND T2.BoardApproved = ?
                                ");
    $block17_count->bindValue(1, '1');
    $block17_count->bindValue(2, 'YES');
    $block17_count->execute();
    $block17_count = $block17_count->fetch();
    $gata_approved_by_board = $block17_count['GataCount'];
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $gata_approved_by_board);
} else if ($data_point == '10') {

    $block29_count = $db->prepare("SELECT T1.ID
                                FROM lm_gata_ebasta T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode AND T2.KhataNo = T1.KhataNo AND T2.GataNo = T1.GataNo
                                WHERE MATCH(T1.Ebasta2) AGAINST (?)
                                AND T2.BoardApproved = ?
                                AND (T2.Shreni = ? OR T2.Shreni = ? OR T2.Shreni LIKE ? OR T2.Shreni LIKE ?)
                                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                                ");
    $block29_count->bindValue(1, 'file_name');
    $block29_count->bindValue(2, 'YES');
    $block29_count->bindValue(3, '1-क');
    $block29_count->bindValue(4, '2');
    $block29_count->bindValue(5, '5%');
    $block29_count->bindValue(6, '6%');
    $block29_count->execute();
    $gata_acquired_till_date = $block29_count->rowCount();
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $gata_acquired_till_date);
} else if ($data_point == '11') {
    $block28_count = $db->prepare("SELECT T1.GataNo
                                FROM lm_gata T1
                                WHERE T1.BoardApproved = ?
                                AND (T1.Shreni = ? OR T1.Shreni = ?)
                                ");
    $block28_count->bindValue(1, 'YES');
    $block28_count->bindValue(2, '1-क');
    $block28_count->bindValue(3, '2');
    $block28_count->execute();
    $gata_to_be_purchased = 0;
    while ($row = $block28_count->fetch()) {
        $gata_to_be_purchased++;
    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $gata_to_be_purchased);
} else if ($data_point == '12') {
    $block30_count = $db->prepare("SELECT T1.VillageCode, T1.GataNo, T1.KhataNo, T1.OwnerNo, T2.owner_name, ROUND(SUM(T1.AnshRakba), 4) AS AnshRakba, KashtkarBainamaCount, GataArea
                                FROM lm_gata_ebasta T1
                                LEFT JOIN lm_gata_kashtkar T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo AND T2.OwnerNo = T1.OwnerNo)
                                LEFT JOIN
                                        (SELECT T3.VillageCode, T3.GataNo, T3.KhataNo, COUNT(T3.ID) AS KashtkarBainamaCount, ROUND(SUM(T3.Area), 4) AS GataArea
                                            FROM lm_gata T3
                                            WHERE T3.BoardApproved = ?
                                            AND (T3.Shreni = ? OR T3.Shreni = ?)
                                            GROUP BY T3.VillageCode, T3.KhataNo, T3.GataNo
                                        ) TMP ON TMP.VillageCode = T2.VillageCode AND TMP.GataNo = T2.GataNo AND TMP.KhataNo = T2.KhataNo
                                WHERE MATCH(T1.Ebasta2) AGAINST (?)
                                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                                HAVING KashtkarBainamaCount IS NOT NULL
                                ");
    $block30_count->bindValue(1, 'YES');
    $block30_count->bindValue(2, '1-क');
    $block30_count->bindValue(3, '2');
    $block30_count->bindValue(4, 'file_name');
    $block30_count->execute();
    $gata_fully_purchased = 0;
    $gata_partially_purchased = 0;
    $area_purchased = 0;
    while ($row = $block30_count->fetch()) {
        $area_purchased += $row['AnshRakba'];
        if ($row['AnshRakba'] == $row['GataArea']) {
            $gata_fully_purchased++;
        } else if (($row['AnshRakba'] != $row['GataArea'])) {
            $gata_partially_purchased++;
        }
    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $gata_fully_purchased, 'point2' => $gata_partially_purchased);
} else if ($data_point == '13') {
    $block29_count = $db->prepare("SELECT T1.GataNo
                                FROM lm_gata T1
                                WHERE T1.BoardApproved = ?
                                AND (T1.Shreni LIKE ? OR T1.Shreni LIKE ?)
                                ");
    $block29_count->bindValue(1, 'YES');
    $block29_count->bindValue(2, '5%');
    $block29_count->bindValue(3, '6%');
    $block29_count->execute();
    $gata_to_be_resumption = 0;
    while ($row = $block29_count->fetch()) {
        $gata_to_be_resumption++;
    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $gata_to_be_resumption);
} else if ($data_point == '14') {
    $block31_count = $db->prepare("SELECT T1.VillageCode, T1.GataNo, T1.KhataNo, T1.OwnerNo, T2.owner_name, ROUND(SUM(T1.AnshRakba), 4) AS AnshRakba, KashtkarBainamaCount, GataArea
                                FROM lm_gata_ebasta T1
                                LEFT JOIN lm_gata_kashtkar T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo AND T2.OwnerNo = T1.OwnerNo)
                                LEFT JOIN
                                        (SELECT T3.VillageCode, T3.GataNo, T3.KhataNo, COUNT(T3.ID) AS KashtkarBainamaCount, ROUND(SUM(T3.Area), 4) AS GataArea
                                            FROM lm_gata T3
                                            WHERE T3.BoardApproved = ?
                                            AND (T3.Shreni LIKE ? OR T3.Shreni LIKE ?)
                                            GROUP BY T3.VillageCode, T3.KhataNo, T3.GataNo
                                        ) TMP ON TMP.VillageCode = T2.VillageCode AND TMP.GataNo = T2.GataNo AND TMP.KhataNo = T2.KhataNo
                                WHERE MATCH(T1.Ebasta2) AGAINST (?)
                                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                                HAVING KashtkarBainamaCount IS NOT NULL
                                ");
    $block31_count->bindValue(1, 'YES');
    $block31_count->bindValue(2, '5%');
    $block31_count->bindValue(3, '6%');
    $block31_count->bindValue(4, 'file_name');
    $block31_count->execute();
    $gata_fully_resumpted = 0;
    $gata_partially_resumpted = 0;
    $area_resumption = 0;
    while ($row = $block31_count->fetch()) {
        $area_resumption += $row['AnshRakba'];
        if ($row['AnshRakba'] == $row['GataArea']) {
            $gata_fully_resumpted++;
        } else if (($row['AnshRakba'] != $row['GataArea']) && $row['AnshRakba'] && $row['GataArea']) {
            $gata_partially_resumpted++;
        }
    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $gata_fully_resumpted, 'point2' => $gata_partially_resumpted);
} else if ($data_point == '15') {
    $block29_count = $db->prepare("SELECT T1.Amount, T1.BankStatus
                                FROM lm_slao_report T1
                                WHERE T1.RowDeleted = ?
                                ");
    $block29_count->bindValue(1, '0');
    $block29_count->execute();
    $money_to_disbursed = 0;
    $money_disbursed = 0;
    while ($row = $block29_count->fetch()) {
        if ($row['BankStatus'] == '1') {
            $money_disbursed += $row['Amount'];
        } else {
            $money_to_disbursed += $row['Amount'];
        }
    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => format_rupees($money_to_disbursed));
} else if ($data_point == '16') {
    $block29_count = $db->prepare("SELECT T1.Amount, T1.BankStatus
                                FROM lm_slao_report T1
                                WHERE T1.RowDeleted = ?
                                ");
    $block29_count->bindValue(1, '0');
    $block29_count->execute();
    $money_to_disbursed = 0;
    $money_disbursed = 0;
    while ($row = $block29_count->fetch()) {
        if ($row['BankStatus'] == '1') {
            $money_disbursed += $row['Amount'];
        } else {
            $money_to_disbursed += $row['Amount'];
        }
    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => format_rupees($money_disbursed));
} else if ($data_point == '17') {
    if (!isset($_SESSION['kashtkar_count'])) {
        $kashtkar_count_query = $db->prepare("SELECT T2.VillageCode, T2.GataNo, T3.owner_name, T3.owner_father
                                            FROM lm_village T1
                                            LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                            LEFT JOIN lm_gata_kashtkar T3 ON (T3.VillageCode = T2.VillageCode AND T3.GataNo = T2.GataNo)
                                            WHERE T1.Active = ?
                                            AND T2.BoardApproved = ?
                                            AND (T2.Shreni = ? OR T2.Shreni = ?)
                                            GROUP BY T3.VillageCode, T3.owner_name, T3.owner_father
                                            ");
        $kashtkar_count_query->bindValue(1, 1);
        $kashtkar_count_query->bindValue(2, 'YES');
        $kashtkar_count_query->bindValue(3, '1-क');
        $kashtkar_count_query->bindValue(4, '2');
        $kashtkar_count_query->execute();
        $kashtkar_count = $kashtkar_count_query->rowCount();
        $_SESSION['kashtkar_count'] = $kashtkar_count;
    } else {
        $kashtkar_count = $_SESSION['kashtkar_count'];
    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $kashtkar_count);
} else if ($data_point == '18') {
    $khastkar_bainama_query = $db->prepare("SELECT T1.ID
                                        FROM lm_gata_ebasta T1
                                        LEFT JOIN lm_gata T3 ON (T3.VillageCode = T1.VillageCode AND T3.GataNo = T1.GataNo AND T3.KhataNo = T1.KhataNo)
                                        WHERE MATCH(T1.Ebasta1) AGAINST (?)
                                        AND (T3.Shreni = ? OR T3.Shreni = ?)
                                        GROUP BY T1.VillageCode, T1.owner_name, T1.owner_father
                                        ");
    $khastkar_bainama_query->bindValue(1, 'file_name');
    $khastkar_bainama_query->bindValue(2, '1-क');
    $khastkar_bainama_query->bindValue(3, '2');
    $khastkar_bainama_query->execute();
    $kashtkar_sahmati_count = $khastkar_bainama_query->rowCount();
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $kashtkar_sahmati_count);
} else if ($data_point == '19') {
    if (!isset($_SESSION['kashtkar_count'])) {
        $kashtkar_count_query = $db->prepare("SELECT T2.VillageCode, T2.GataNo, T3.owner_name, T3.owner_father
                                            FROM lm_village T1
                                            LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                            LEFT JOIN lm_gata_kashtkar T3 ON (T3.VillageCode = T2.VillageCode AND T3.GataNo = T2.GataNo)
                                            WHERE T1.Active = ?
                                            AND T2.BoardApproved = ?
                                            AND (T2.Shreni = ? OR T2.Shreni = ?)
                                            GROUP BY T3.VillageCode, T3.owner_name, T3.owner_father
                                            ");
        $kashtkar_count_query->bindValue(1, 1);
        $kashtkar_count_query->bindValue(2, 'YES');
        $kashtkar_count_query->bindValue(3, '1-क');
        $kashtkar_count_query->bindValue(4, '2');
        $kashtkar_count_query->execute();
        $kashtkar_count = $kashtkar_count_query->rowCount();
        $_SESSION['kashtkar_count'] = $kashtkar_count;
    } else {
        $kashtkar_count = $_SESSION['kashtkar_count'];
    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $kashtkar_count);
} else if ($data_point == '20') {
    $khastkar_bainama_query = $db->prepare("SELECT T1.ID
                                        FROM lm_gata_ebasta T1
                                        LEFT JOIN lm_gata T3 ON (T3.VillageCode = T1.VillageCode AND T3.GataNo = T1.GataNo AND T3.KhataNo = T1.KhataNo)
                                        WHERE MATCH(T1.Ebasta2) AGAINST (?)
                                        AND (T3.Shreni = ? OR T3.Shreni = ?)
                                        GROUP BY T1.VillageCode, T1.owner_name, T1.owner_father
                                        ");
    $khastkar_bainama_query->bindValue(1, 'file_name');
    $khastkar_bainama_query->bindValue(2, '1-क');
    $khastkar_bainama_query->bindValue(3, '2');
    $khastkar_bainama_query->execute();
    $kashtkar_bainama_count = $khastkar_bainama_query->rowCount();
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $kashtkar_bainama_count);
} else if ($data_point == '21') {
    if (!isset($_SESSION['kashtkar_count'])) {
        $kashtkar_count_query = $db->prepare("SELECT T2.VillageCode, T2.GataNo, T3.owner_name, T3.owner_father
                                            FROM lm_village T1
                                            LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                            LEFT JOIN lm_gata_kashtkar T3 ON (T3.VillageCode = T2.VillageCode AND T3.GataNo = T2.GataNo)
                                            WHERE T1.Active = ?
                                            AND T2.BoardApproved = ?
                                            AND (T2.Shreni = ? OR T2.Shreni = ?)
                                            GROUP BY T3.VillageCode, T3.owner_name, T3.owner_father
                                            ");
        $kashtkar_count_query->bindValue(1, 1);
        $kashtkar_count_query->bindValue(2, 'YES');
        $kashtkar_count_query->bindValue(3, '1-क');
        $kashtkar_count_query->bindValue(4, '2');
        $kashtkar_count_query->execute();
        $kashtkar_count = $kashtkar_count_query->rowCount();
        $_SESSION['kashtkar_count'] = $kashtkar_count;
    } else {
        $kashtkar_count = $_SESSION['kashtkar_count'];
    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $kashtkar_count);
} else if ($data_point == '22') {
    $khastkar_bainama_query = $db->prepare("SELECT T1.ID
                                        FROM lm_gata_ebasta T1
                                        LEFT JOIN lm_gata T3 ON (T3.VillageCode = T1.VillageCode AND T3.GataNo = T1.GataNo AND T3.KhataNo = T1.KhataNo)
                                        WHERE MATCH(T1.Ebasta3) AGAINST (?)
                                        AND (T3.Shreni = ? OR T3.Shreni = ?)
                                        GROUP BY T1.VillageCode, T1.owner_name, T1.owner_father
                                        ");
    $khastkar_bainama_query->bindValue(1, 'file_name');
    $khastkar_bainama_query->bindValue(2, '1-क');
    $khastkar_bainama_query->bindValue(3, '2');
    $khastkar_bainama_query->execute();
    $kashtkar_kabza_count = $khastkar_bainama_query->rowCount();
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $kashtkar_kabza_count);
} else if ($data_point == '23') {
    if (!isset($_SESSION['kashtkar_count'])) {
        $kashtkar_count_query = $db->prepare("SELECT T2.VillageCode, T2.GataNo, T3.owner_name, T3.owner_father
                                            FROM lm_village T1
                                            LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                            LEFT JOIN lm_gata_kashtkar T3 ON (T3.VillageCode = T2.VillageCode AND T3.GataNo = T2.GataNo)
                                            WHERE T1.Active = ?
                                            AND T2.BoardApproved = ?
                                            AND (T2.Shreni = ? OR T2.Shreni = ?)
                                            GROUP BY T3.VillageCode, T3.owner_name, T3.owner_father
                                            ");
        $kashtkar_count_query->bindValue(1, 1);
        $kashtkar_count_query->bindValue(2, 'YES');
        $kashtkar_count_query->bindValue(3, '1-क');
        $kashtkar_count_query->bindValue(4, '2');
        $kashtkar_count_query->execute();
        $kashtkar_count = $kashtkar_count_query->rowCount();
        $_SESSION['kashtkar_count'] = $kashtkar_count;
    } else {
        $kashtkar_count = $_SESSION['kashtkar_count'];
    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $kashtkar_count);
} else if ($data_point == '24') {
    $khastkar_bainama_query = $db->prepare("SELECT T1.ID
                                        FROM lm_gata_ebasta T1
                                        LEFT JOIN lm_gata T3 ON (T3.VillageCode = T1.VillageCode AND T3.GataNo = T1.GataNo AND T3.KhataNo = T1.KhataNo)
                                        WHERE MATCH(T1.Ebasta4) AGAINST (?)
                                        AND (T3.Shreni = ? OR T3.Shreni = ?)
                                        GROUP BY T1.VillageCode, T1.owner_name, T1.owner_father
                                        ");
    $khastkar_bainama_query->bindValue(1, 'file_name');
    $khastkar_bainama_query->bindValue(2, '1-क');
    $khastkar_bainama_query->bindValue(3, '2');
    $khastkar_bainama_query->execute();
    $kashtkar_khatauni_count = $khastkar_bainama_query->rowCount();
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $kashtkar_khatauni_count);
} else if ($data_point == '25') {
    $block32_count = $db->prepare("SELECT T1.GataNo, T1.KhataNo, T1.Area
                                FROM lm_gata T1
                                LEFT JOIN lm_gata_kashtkar T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                                WHERE T1.BoardApproved = ?
                                AND (T1.Shreni = ? OR T1.Shreni = ?)
                                AND T2.owner_name LIKE ?
                                GROUP BY T1.VillageCode, T1.KhataNo
                                ");
    $block32_count->bindValue(1, 'YES');
    $block32_count->bindValue(2, '1-क');
    $block32_count->bindValue(3, '2');
    $block32_count->bindValue(4, 'बुन्देलखण्ड औद्योगिक%');
    $block32_count->execute();
    $khata_having_bida_count = 0;
    $khata_having_bida_count_array = array();
    while ($row = $block32_count->fetch()) {
        $khata_having_bida_count_array[] = $row['KhataNo'];
    }

    $khata_having_bida_count = count_($khata_having_bida_count_array);
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $khata_having_bida_count);
} else if ($data_point == '26') {
    $block24_count = $db->prepare("SELECT T1.GataNo, T1.KhataNo, ROUND(SUM(T1.Area), 4) AS Area
                                FROM lm_gata T1
                                LEFT JOIN lm_gata_kashtkar T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                                WHERE T1.BoardApproved = ?
                                AND (T1.Shreni = ? OR T1.Shreni = ?)
                                AND T2.owner_name LIKE ?
                                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                                ");
    $block24_count->bindValue(1, 'YES');
    $block24_count->bindValue(2, '1-क');
    $block24_count->bindValue(3, '2');
    $block24_count->bindValue(4, 'बुन्देलखण्ड औद्योगिक%');
    $block24_count->execute();
    $gata_having_bida_count = 0;
    $gata_rakba_having_bida_count = 0;
    $gata_having_bida_count_array = array();
    $gata_rakba_having_bida_count_array = array();
    while ($row = $block24_count->fetch()) {
        $gata_having_bida_count_array[] = $row['GataNo'];
        $gata_rakba_having_bida_count += $row['Area'];
    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $gata_rakba_having_bida_count);
} else if ($data_point == '27') {
    $block30_count = $db->prepare("SELECT T1.VillageCode, T1.GataNo, T1.KhataNo, T1.OwnerNo, T2.owner_name, ROUND(SUM(T1.AnshRakba), 4) AS AnshRakba, KashtkarBainamaCount, GataArea
                                FROM lm_gata_ebasta T1
                                LEFT JOIN lm_gata_kashtkar T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo AND T2.OwnerNo = T1.OwnerNo)
                                LEFT JOIN
                                        (SELECT T3.VillageCode, T3.GataNo, T3.KhataNo, COUNT(T3.ID) AS KashtkarBainamaCount, ROUND(SUM(T3.Area), 4) AS GataArea
                                            FROM lm_gata T3
                                            WHERE T3.BoardApproved = ?
                                            AND (T3.Shreni = ? OR T3.Shreni = ?)
                                            GROUP BY T3.VillageCode, T3.KhataNo, T3.GataNo
                                        ) TMP ON TMP.VillageCode = T2.VillageCode AND TMP.GataNo = T2.GataNo AND TMP.KhataNo = T2.KhataNo
                                WHERE MATCH(T1.Ebasta2) AGAINST (?)
                                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                                HAVING KashtkarBainamaCount IS NOT NULL
                                ");
    $block30_count->bindValue(1, 'YES');
    $block30_count->bindValue(2, '1-क');
    $block30_count->bindValue(3, '2');
    $block30_count->bindValue(4, 'file_name');
    $block30_count->execute();
    $area_purchased = 0;
    while ($row = $block30_count->fetch()) {
        $area_purchased += $row['AnshRakba'];
    }

    $block24_count = $db->prepare("SELECT T1.GataNo, T1.KhataNo, ROUND(SUM(T1.Area), 4) AS Area
                                FROM lm_gata T1
                                LEFT JOIN lm_gata_kashtkar T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                                WHERE T1.BoardApproved = ?
                                AND (T1.Shreni = ? OR T1.Shreni = ?)
                                AND T2.owner_name LIKE ?
                                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                                ");
    $block24_count->bindValue(1, 'YES');
    $block24_count->bindValue(2, '1-क');
    $block24_count->bindValue(3, '2');
    $block24_count->bindValue(4, 'बुन्देलखण्ड औद्योगिक%');
    $block24_count->execute();
    $gata_having_bida_count = 0;
    $gata_rakba_having_bida_count = 0;
    $gata_having_bida_count_array = array();
    $gata_rakba_having_bida_count_array = array();
    while ($row = $block24_count->fetch()) {
        $gata_having_bida_count_array[] = $row['GataNo'];
        $gata_rakba_having_bida_count += $row['Area'];
    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => ($area_purchased - $gata_rakba_having_bida_count));
} else if ($data_point == '28') {
    $block25_count = $db->prepare("SELECT T1.GataNo, T1.KhataNo, ROUND(SUM(T1.Area), 4) AS Area
                                FROM lm_gata T1
                                LEFT JOIN lm_gata_kashtkar T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                                WHERE T1.BoardApproved = ?
                                AND (T1.Shreni LIKE ? OR T1.Shreni LIKE ?)
                                AND T2.owner_name LIKE ?
                                GROUP BY T1.VillageCode, T2.GataNo, T2.owner_name, T2.owner_father
                                ");
    $block25_count->bindValue(1, 'YES');
    $block25_count->bindValue(2, '5%');
    $block25_count->bindValue(3, '6%');
    $block25_count->bindValue(4, 'बुन्देलखण्ड औद्योगिक%');
    $block25_count->execute();
    $gata_having_punargrahan_bida_count = 0;
    $gata_rakba_having_bida_count2 = 0;
    while ($row = $block25_count->fetch()) {
        $gata_having_punargrahan_bida_count++;
        $gata_rakba_having_bida_count2 += $row['Area'];
    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $gata_having_punargrahan_bida_count);
} else if ($data_point == '29') {
    $block25_count = $db->prepare("SELECT T1.GataNo, T1.KhataNo, ROUND(SUM(T1.Area), 4) AS Area
                                FROM lm_gata T1
                                LEFT JOIN lm_gata_kashtkar T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                                WHERE T1.BoardApproved = ?
                                AND (T1.Shreni LIKE ? OR T1.Shreni LIKE ?)
                                AND T2.owner_name LIKE ?
                                GROUP BY T1.VillageCode, T2.GataNo, T2.owner_name, T2.owner_father
                                ");
    $block25_count->bindValue(1, 'YES');
    $block25_count->bindValue(2, '5%');
    $block25_count->bindValue(3, '6%');
    $block25_count->bindValue(4, 'बुन्देलखण्ड औद्योगिक%');
    $block25_count->execute();
    $gata_having_punargrahan_bida_count = 0;
    $gata_rakba_having_bida_count2 = 0;
    while ($row = $block25_count->fetch()) {
        $gata_having_punargrahan_bida_count++;
        $gata_rakba_having_bida_count2 += $row['Area'];
    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $gata_rakba_having_bida_count2);
} else if ($data_point == '30') {
    $block33_count = $db->prepare("SELECT T1.ID
                                FROM lm_gata T1
                                WHERE T1.Shreni = ?
                                AND (
                                LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                OR LOWER(T1.khate_me_fasali_ke_anusar_kism LIKE ?)
                                )
                                ");
    $i = 1;
    $block33_count->bindValue($i++, '1-क');
    $block33_count->bindValue($i++, 'nala%');
    $block33_count->bindValue($i++, 'nali%');
    $block33_count->bindValue($i++, 'pathar%');
    $block33_count->bindValue($i++, 'patthar%');
    $block33_count->bindValue($i++, 'paatthar%');
    $block33_count->bindValue($i++, 'paathar%');
    $block33_count->bindValue($i++, 'pathaar%');
    $block33_count->bindValue($i++, 'pahad%');
    $block33_count->bindValue($i++, 'paahaad%');
    $block33_count->bindValue($i++, 'pahaad%');
    $block33_count->bindValue($i++, 'paahad%');
    $block33_count->bindValue($i++, 'pukhariya%');
    $block33_count->bindValue($i++, 'pokhar%');
    $block33_count->bindValue($i++, 'talab%');
    $block33_count->bindValue($i++, 'dev sthan%');
    $block33_count->bindValue($i++, 'khaliyan%');
    $block33_count->bindValue($i++, 'khalihan%');
    $block33_count->bindValue($i++, 'rasta%');
    $block33_count->bindValue($i++, 'rashta%');
    $block33_count->bindValue($i++, 'gochar%');
    $block33_count->bindValue($i++, 'chakroad%');
    $block33_count->bindValue($i++, 'chakmarg%');
    $block33_count->bindValue($i++, 'jhadi%');
    $block33_count->bindValue($i++, 'aabadi%');
    $block33_count->bindValue($i++, 'abadi%');
    $block33_count->bindValue($i++, 'abaadi%');
    $block33_count->bindValue($i++, 'nadi%');
    $block33_count->bindValue($i++, 'nahar%');
    $block33_count->bindValue($i++, 'tauriya%');
    $block33_count->bindValue($i++, 'jangal%');
    $block33_count->bindValue($i++, 'van%');
    $block33_count->execute();
    $surakshit_gate_count = $block33_count->rowCount();
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $surakshit_gate_count);
} else if ($data_point == '31') {
    $ch4145_count = $db->prepare("SELECT COUNT(T2.ID) AS CH4145Count
                                FROM lm_village T1
                                LEFT JOIN lm_village_ebasta T2 ON (T2.VillageCode = T1.VillageCode)
                                WHERE T1.Active = ?
                                AND T2.Ebasta13 IS NOT NULL
                            ");
    $ch4145_count->bindValue(1, 1);
    $ch4145_count->execute();
    $ch4145_count = $ch4145_count->fetch();
    $ch_41_45_uploaded = $ch4145_count['CH4145Count'];
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $ch_41_45_uploaded);
} else if ($data_point == '32') {
    $ch1359_count = $db->prepare("SELECT COUNT(T2.ID) AS CH1359Count
                                FROM lm_village T1
                                LEFT JOIN lm_village_ebasta T2 ON (T2.VillageCode = T1.VillageCode)
                                WHERE T1.Active = ?
                                AND T2.Ebasta11 IS NOT NULL
                            ");
    $ch1359_count->bindValue(1, 1);
    $ch1359_count->execute();
    $ch1359_count = $ch1359_count->fetch();
    $ch_1359_uploaded = $ch1359_count['CH1359Count'];
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $ch_1359_uploaded);
} else if ($data_point == '33') {
    $ebasta_count = $db->prepare("SELECT COUNT(T2.ID) AS EbastaCount
                                FROM lm_village T1
                                LEFT JOIN lm_village_ebasta T2 ON (T2.VillageCode = T1.VillageCode)
                                WHERE T1.Active = ?
                                AND T2.Ebasta1 IS NOT NULL
                                AND T2.Ebasta2 IS NOT NULL
                                AND T2.Ebasta3 IS NOT NULL
                                AND T2.Ebasta4 IS NOT NULL
                                AND T2.Ebasta5 IS NOT NULL
                                AND T2.Ebasta6 IS NOT NULL
                                AND T2.Ebasta7 IS NOT NULL
                                AND T2.Ebasta8 IS NOT NULL
                                AND T2.Ebasta9 IS NOT NULL
                                AND T2.Ebasta10 IS NOT NULL
                                AND T2.Ebasta11 IS NOT NULL
                                AND T2.Ebasta12 IS NOT NULL
                                AND T2.Ebasta13 IS NOT NULL
                                AND T2.Ebasta14 IS NOT NULL
                                AND T2.Ebasta15 IS NOT NULL
                                AND T2.Ebasta16 IS NOT NULL
                                AND T2.Ebasta17 IS NOT NULL
                                AND T2.Ebasta18 IS NOT NULL
                                AND T2.Ebasta19 IS NOT NULL
                                AND T2.Ebasta20 IS NOT NULL
                            ");
    $ebasta_count->bindValue(1, 1);
    $ebasta_count->execute();
    $ebasta_count = $ebasta_count->fetch();
    $ebasta_uploaded = $ebasta_count['EbastaCount'];
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $ebasta_uploaded);
} else if ($data_point == '34') {
    $block9_count = $db->prepare("SELECT COUNT(T2.ID) AS GataCount
                                FROM lm_village T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                WHERE T1.Active = ?
                                AND CAST(T2.Area AS FLOAT) > CAST(T2.fasali_ke_anusar_rakba AS FLOAT)
                                AND T2.fasali_ke_anusar_rakba > 0
                                AND T2.BoardApproved = ?
                                ");
    $block9_count->bindValue(1, 1);
    $block9_count->bindValue(2, 'YES');
    $block9_count->execute();
    $block9_count = $block9_count->fetch();
    $block9_count = $block9_count['GataCount'];
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $block9_count);
} else if ($data_point == '35') {
    $block10_count = $db->prepare("SELECT COUNT(T2.ID) AS GataCount
                                FROM lm_village T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                WHERE T1.Active = ?
                                AND CAST(T2.Area AS FLOAT) < CAST(T2.fasali_ke_anusar_rakba AS FLOAT)
                                AND T2.fasali_ke_anusar_rakba > 0
                                AND T2.BoardApproved = ?
                                ");
    $block10_count->bindValue(1, 1);
    $block10_count->bindValue(2, 'YES');
    $block10_count->execute();
    $block10_count = $block10_count->fetch();
    $block10_count = $block10_count['GataCount'];
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $block10_count);
} else if ($data_point == '36') {
    $block11_count = $db->prepare("SELECT COUNT(T2.ID) AS GataCount
                                FROM lm_village T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                WHERE T1.Active = ?
                                AND CAST(T2.Area AS FLOAT) > CAST(T2.ch41_45_ke_anusar_rakba AS FLOAT)
                                AND T2.ch41_45_ke_anusar_rakba > 0
                                AND T2.BoardApproved = ?
                                ");
    $block11_count->bindValue(1, 1);
    $block11_count->bindValue(2, 'YES');
    $block11_count->execute();
    $block11_count = $block11_count->fetch();
    $block11_count = $block11_count['GataCount'];
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $block11_count);
} else if ($data_point == '37') {
    $block12_count = $db->prepare("SELECT COUNT(T2.ID) AS GataCount
                                FROM lm_village T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                WHERE T1.Active = ?
                                AND CAST(T2.Area AS FLOAT) < CAST(T2.ch41_45_ke_anusar_rakba AS FLOAT)
                                AND T2.ch41_45_ke_anusar_rakba > 0
                                AND T2.BoardApproved = ?
                                ");
    $block12_count->bindValue(1, 1);
    $block12_count->bindValue(2, 'YES');
    $block12_count->execute();
    $block12_count = $block12_count->fetch();
    $block12_count = $block12_count['GataCount'];
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $block12_count);
} else if ($data_point == '38') {
    $block13_count = $db->prepare("SELECT COUNT(T2.ID) AS GataCount
                                FROM lm_village T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                WHERE T1.Active = ?
                                AND T2.Shreni != T2.ch41_45_ke_anusar_sreni
                                AND T2.ch41_45_ke_anusar_sreni != ?
                                AND T2.BoardApproved = ?
                                ");
    $block13_count->bindValue(1, 1);
    $block13_count->bindValue(2, '');
    $block13_count->bindValue(3, 'YES');
    $block13_count->execute();
    $block13_count = $block13_count->fetch();
    $block13_count = $block13_count['GataCount'];
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $block13_count);
} else if ($data_point == '39') {
    $block17_count = $db->prepare("SELECT COUNT(T2.ID) AS GataCount
                                    FROM lm_village T1
                                    LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                    WHERE T1.Active = ?
                                    AND T2.BoardApproved = ?
                                ");
    $block17_count->bindValue(1, '1');
    $block17_count->bindValue(2, 'YES');
    $block17_count->execute();
    $block17_count = $block17_count->fetch();
    $gata_approved_by_board = $block17_count['GataCount'];
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $gata_approved_by_board);
} else if ($data_point == '40') {
    $block15_count = $db->prepare("SELECT COUNT(T2.ID) AS GataCount
                                FROM lm_village T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                WHERE T1.Active = ?
                                AND T2.HoldByDM = ?
                                ");
    $block15_count->bindValue(1, 1);
    $block15_count->bindValue(2, 'YES');
    $block15_count->execute();
    $block15_count = $block15_count->fetch();
    $block15_count = $block15_count['GataCount'];
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $block15_count);
} else if ($data_point == '41') {
    $block16_count = $db->prepare("SELECT COUNT(T2.ID) AS GataCount
                                FROM lm_village T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                WHERE T1.Active = ?
                                AND T2.HoldByBIDA = ?
                                AND T2.HoldByDM = ?
                                ");
    $block16_count->bindValue(1, 1);
    $block16_count->bindValue(2, 'YES');
    $block16_count->bindValue(3, 'NO');
    $block16_count->execute();
    $block16_count = $block16_count->fetch();
    $block16_count = $block16_count['GataCount'];
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $block16_count);
} else if ($data_point == '42') {
    $block18_count = $db->prepare("SELECT COUNT(T2.ID) AS GataCount
                                FROM lm_village T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                WHERE T1.Active = ?
                                AND T2.HoldByNirdharan = ?
                                AND T2.HoldByDM = ?
                                AND T2.HoldByBIDA = ?
                                ");
    $block18_count->bindValue(1, 1);
    $block18_count->bindValue(2, 'YES');
    $block18_count->bindValue(3, 'NO');
    $block18_count->bindValue(4, 'NO');
    $block18_count->execute();
    $block18_count = $block18_count->fetch();
    $block18_count = $block18_count['GataCount'];
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $block18_count);
} else if ($data_point == '43') {
    $block19_count = $db->prepare("SELECT COUNT(T2.ID) AS GataCount
                                FROM lm_village T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                WHERE T1.Active = ?
                                AND T2.BinamaHoldByBIDA = ?
                                ");
    $block19_count->bindValue(1, 1);
    $block19_count->bindValue(2, 'YES');
    $block19_count->execute();
    $block19_count = $block19_count->fetch();
    $block19_count = $block19_count['GataCount'];
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $block19_count);
} else if ($data_point == '45') {
    $chakbandi_query = $db->prepare("SELECT T1.VillageCode,
                                        SUM(CASE
                                        WHEN (T1.ch41_45_ke_anusar_rakba != ? AND T1.ch41_45_ke_anusar_rakba != ?) THEN 1
                                        ELSE 0
                                        END) AS Count
                                FROM lm_gata T1
                                WHERE 1 = 1
                                GROUP BY T1.VillageCode
                                HAVING Count > 0
                                ");
    $chakbandi_query->bindValue(1, '');
    $chakbandi_query->bindValue(2, '--');
    $chakbandi_query->execute();
    $chakbandi_query->setFetchMode(PDO::FETCH_ASSOC);
    $chakbandi_status_array = array();
    while ($row = $chakbandi_query->fetch()) {
        $chakbandi_status_array[] = $row['VillageCode'];
    }

    $village_query = $db->prepare("SELECT T2.*, T3.VillageName
                                FROM lm_gata_ebasta T1
                                LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.KhataNo = T1.KhataNo AND T2.GataNo = T1.GataNo)
                                LEFT JOIN lm_village T3 ON T3.VillageCode = T1.VillageCode
                                WHERE MATCH(T1.Ebasta2) AGAINST (?)
                                AND (T2.Shreni = ? OR T2.Shreni = ?)
                                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                                ");
    $village_query->bindValue(1, 'file_name');
    $village_query->bindValue(2, '1-क');
    $village_query->bindValue(3, '2');
    $village_query->execute();
    $village_query->setFetchMode(PDO::FETCH_ASSOC);
    $aniyamit_bainama_count = 0;
    while ($gataInfo = $village_query->fetch()) {
        $aniyamit_bainama = 0;
        $aniyamit_array = array();
        if (strtolower($gataInfo['BoardApproved']) == 'yes') {
            
        } else {
            $aniyamit_bainama++;
            $aniyamit_array[] = 1;
        }

//        if ((float) $gataInfo['fasali_ke_anusar_rakba'] > 0) {
//
//        } else {
//            $aniyamit_bainama++;
//            $aniyamit_array[] = 2;
//        }
//
//        /*         * ********* */
//        if (in_array($gataInfo['VillageCode'], $chakbandi_status_array)) {
//            if ((float) $gataInfo['ch41_45_ke_anusar_rakba']) {
//
//            } else {
//                $aniyamit_bainama++;
//                $aniyamit_array[] = 3;
//            }
//        }

        /*         * ********* */
        if ($gataInfo['Shreni'] == '1-क' && $gataInfo['khate_me_fasali_ke_anusar_kism'] != '--') {
            //$var = array_keys(explode('(', $gataInfo['khate_me_fasali_ke_anusar_kism']));
            $data = strtolower($gataInfo['khate_me_fasali_ke_anusar_kism']);
            if (str_contains($data, 'nala') || str_contains($data, 'nali') || str_contains($data, 'pathar') || str_contains($data, 'patthar') || str_contains($data, 'paatthar') || str_contains($data, 'paathar') || str_contains($data, 'pathaar') || str_contains($data, 'pahad') || str_contains($data, 'paahaad') || str_contains($data, 'pahaad') || str_contains($data, 'paahad') || str_contains($data, 'pukhariya') || str_contains($data, 'pokhar') || str_contains($data, 'talab') || str_contains($data, 'dev sthan') || str_contains($data, 'khaliyan') || str_contains($data, 'khalihan') || str_contains($data, 'rasta') || str_contains($data, 'rashta') || str_contains($data, 'gochar') || str_contains($data, 'chakroad') || str_contains($data, 'chakmarg') || str_contains($data, 'jhadi') || str_contains($data, 'aabadi') || str_contains($data, 'abadi') || str_contains($data, 'abaadi') || str_contains($data, 'nadi') || str_contains($data, 'nahar') || str_contains($data, 'tauriya') || str_contains($data, 'jangal') || str_contains($data, 'van')) {
                $aniyamit_bainama++;
                $aniyamit_array[] = 4;
            } else {
                
            }
        } else {
            
        }

        /*         * ********* */
        if (in_array($gataInfo['VillageCode'], $chakbandi_status_array)) {
            if ($gataInfo['ch41_45_ke_anusar_sreni'] != '--') {
                if (substr($gataInfo['ch41_45_ke_anusar_sreni'], 0, 1) == substr($gataInfo['Shreni'], 0, 1)) {
                    
                } else {
                    $aniyamit_bainama++;
                    $aniyamit_array[] = 5;
                }
            }
        }

        /*         * ********* */
        if ((float) $gataInfo['fasali_ke_anusar_rakba']) {
            if ((float) $gataInfo['Area'] > (float) $gataInfo['fasali_ke_anusar_rakba']) {
                $aniyamit_bainama++;
                $aniyamit_array[] = 6;
            } else {
                
            }
        }

        /*         * ********* */
        if (in_array($gataInfo['VillageCode'], $chakbandi_status_array)) {
            if ((float) $gataInfo['ch41_45_ke_anusar_rakba']) {
                if ((float) $gataInfo['Area'] > (float) $gataInfo['ch41_45_ke_anusar_rakba']) {
                    $aniyamit_bainama++;
                    $aniyamit_array[] = 7;
                } else {
                    
                }
            }
        }

        //echo $gataInfo['GataNo']. ' == ' .implode(', ', $aniyamit_array). ' == ' . $aniyamit_bainama . '<br>';
        if ($aniyamit_bainama) {
            $aniyamit_bainama_count++;
            $str .= $gataInfo['GataNo'] . ' == ' . implode(', ', $aniyamit_array) . ' == ' . $aniyamit_bainama . ' == ' . $aniyamit_bainama_count;
            $str .= "\r\n";
        }
    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $aniyamit_bainama_count);
} else if ($data_point == '46') {
    $kashtkar_count_query = $db->prepare("SELECT T2.VillageCode, T2.GataNo, T3.owner_name, T3.owner_father
                                        FROM lm_village T1
                                        LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                        LEFT JOIN lm_gata_kashtkar T3 ON (T3.VillageCode = T2.VillageCode AND T3.GataNo = T2.GataNo)
                                        WHERE T1.Active = ?
                                        AND T2.BoardApproved = ?
                                        GROUP BY T3.VillageCode, T3.owner_name, T3.owner_father
                                        ");
    $kashtkar_count_query->bindValue(1, 1);
    $kashtkar_count_query->bindValue(2, 'YES');
    $kashtkar_count_query->execute();
    $kashtkar_count = $kashtkar_count_query->rowCount();
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $kashtkar_count);
} else if ($data_point == '47') {
    $block17_count = $db->prepare("SELECT COUNT(T2.ID) AS GataCount
                                    FROM lm_village T1
                                    LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                    WHERE T1.Active = ?
                                    AND T2.BoardApproved = ?
                                ");
    $block17_count->bindValue(1, '1');
    $block17_count->bindValue(2, 'YES');
    $block17_count->execute();
    $block17_count = $block17_count->fetch();
    $gata_approved_by_board = $block17_count['GataCount'];

    $block23_count = $db->prepare("SELECT T1.VillageCode, T1.GataNo, COUNT(T2.ID) AS Count, T2.ID
                                FROM lm_gata T1
                                LEFT JOIN lm_gata_kashtkar T2 ON (T2.VillageCode = T1.VillageCode AND T2.KhataNo = T1.KhataNo AND T2.GataNo = T1.GataNo)
                                WHERE T1.BoardApproved = ?
                                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                                HAVING Count = ?
                                ");
    $block23_count->bindValue(1, 'YES');
    $block23_count->bindValue(2, 1);
    $block23_count->execute();
    $gata_ka_ansh = 0;
    $kashtkar_ansh_count = 0;
    $kashtkar_ansh_array = array();
    while ($row = $block23_count->fetch()) {
        $gata_ka_ansh++;
        $kashtkar_ansh_array[] = $row['GataNo'];
    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => ($gata_approved_by_board - $gata_ka_ansh));
} else if ($data_point == '48') {
    $block23_count = $db->prepare("SELECT T1.VillageCode, T1.GataNo, COUNT(T2.ID) AS Count, T2.ID
                                FROM lm_gata T1
                                LEFT JOIN lm_gata_kashtkar T2 ON (T2.VillageCode = T1.VillageCode AND T2.KhataNo = T1.KhataNo AND T2.GataNo = T1.GataNo)
                                WHERE T1.BoardApproved = ?
                                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                                HAVING Count = ?
                                ");
    $block23_count->bindValue(1, 'YES');
    $block23_count->bindValue(2, 1);
    $block23_count->execute();
    $gata_ka_ansh = 0;
    $kashtkar_ansh_count = 0;
    $kashtkar_ansh_array = array();
    while ($row = $block23_count->fetch()) {
        $gata_ka_ansh++;
        $kashtkar_ansh_array[] = $row['GataNo'];
    }

    if (count_($kashtkar_ansh_array)) {
        $placeholders = '';
        $qPart = array_fill(0, count_($kashtkar_ansh_array), "?");
        $placeholders .= implode(",", $qPart);
        $kashtkar_ansh_query = $db->prepare("SELECT T1.VillageCode, T1.GataNo, T2.owner_name, T2.owner_father
                                        FROM lm_gata T1
                                        LEFT JOIN lm_gata_kashtkar T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                                        WHERE T1.BoardApproved = ?
                                        AND T1.GataNo NOT IN ($placeholders)
                                        GROUP BY T1.VillageCode, T2.owner_name, T2.owner_father
                                        ");
        $kashtkar_ansh_query->bindValue(1, 'YES');
        $i = 2;
        foreach ($kashtkar_ansh_array as $key => $id) {
            $kashtkar_ansh_query->bindParam($i++, $kashtkar_ansh_array[$key]);
        }
        $kashtkar_ansh_query->execute();
        $kashtkar_ansh_count = $kashtkar_ansh_query->rowCount();
    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $kashtkar_ansh_count);
} else if ($data_point == '49') {
    $block17_count = $db->prepare("SELECT COUNT(T2.ID) AS GataCount,
                                        ROUND(SUM(CASE
                                        WHEN T2.Shreni = ? OR T2.Shreni = ? THEN T2.Area
                                        ELSE 0
                                        END), 4) AS AreaTobePurchased
                                FROM lm_village T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                WHERE T1.Active = ?
                                AND T2.BoardApproved = ?
                                ");
    $block17_count->bindValue(1, '1-क');
    $block17_count->bindValue(2, '2');
    $block17_count->bindValue(3, '1');
    $block17_count->bindValue(4, 'YES');
    $block17_count->execute();
    $block17_count = $block17_count->fetch();
    $area_to_be_purchased = $block17_count['AreaTobePurchased'];

    $block30_count = $db->prepare("SELECT T1.VillageCode, T1.GataNo, T1.KhataNo, T1.OwnerNo, T2.owner_name, ROUND(SUM(T1.AnshRakba), 4) AS AnshRakba, KashtkarBainamaCount, GataArea
                                FROM lm_gata_ebasta T1
                                LEFT JOIN lm_gata_kashtkar T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo AND T2.OwnerNo = T1.OwnerNo)
                                LEFT JOIN
                                        (SELECT T3.VillageCode, T3.GataNo, T3.KhataNo, COUNT(T3.ID) AS KashtkarBainamaCount, ROUND(SUM(T3.Area), 4) AS GataArea
                                            FROM lm_gata T3
                                            WHERE T3.BoardApproved = ?
                                            AND (T3.Shreni = ? OR T3.Shreni = ?)
                                            GROUP BY T3.VillageCode, T3.KhataNo, T3.GataNo
                                        ) TMP ON TMP.VillageCode = T2.VillageCode AND TMP.GataNo = T2.GataNo AND TMP.KhataNo = T2.KhataNo
                                WHERE MATCH(T1.Ebasta2) AGAINST (?)
                                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                                HAVING KashtkarBainamaCount IS NOT NULL
                                ");
    $block30_count->bindValue(1, 'YES');
    $block30_count->bindValue(2, '1-क');
    $block30_count->bindValue(3, '2');
    $block30_count->bindValue(4, 'file_name');
    $block30_count->execute();
    $area_purchased = 0;
    while ($row = $block30_count->fetch()) {
        $area_purchased += $row['AnshRakba'];
    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => ($area_to_be_purchased - $area_purchased));
} else if ($data_point == '50') {
    $block24_count = $db->prepare("SELECT T1.GataNo, T1.KhataNo, ROUND(SUM(T1.Area), 4) AS Area
                                FROM lm_gata T1
                                LEFT JOIN lm_gata_kashtkar T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                                WHERE T1.BoardApproved = ?
                                AND (T1.Shreni = ? OR T1.Shreni = ?)
                                AND T2.owner_name LIKE ?
                                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                                ");
    $block24_count->bindValue(1, 'YES');
    $block24_count->bindValue(2, '1-क');
    $block24_count->bindValue(3, '2');
    $block24_count->bindValue(4, 'बुन्देलखण्ड औद्योगिक%');
    $block24_count->execute();
    $gata_having_bida_count = 0;
    $gata_rakba_having_bida_count = 0;
    $gata_having_bida_count_array = array();
    $gata_rakba_having_bida_count_array = array();
    while ($row = $block24_count->fetch()) {
        $gata_having_bida_count_array[] = $row['GataNo'];
        $gata_rakba_having_bida_count += $row['Area'];
    }

    $gata_having_bida_count = count_($gata_having_bida_count_array);
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $gata_having_bida_count);
} else if ($data_point == '51') {
    $block24_count = $db->prepare("SELECT COUNT(T1.ID) AS MortgagedGataCount, SUM(T1.MortgagedAmount) AS MortgagedGataAmount
                                    FROM lm_gata_martgaged_info T1
                                    WHERE T1.Mortgaged = ?
                                    GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                                    ");
    $block24_count->bindValue(1, '1');
    $block24_count->execute();
    $mortgaged_gata_count = $block24_count->rowCount();
    $mortgaged_gata_amount = 0;
    while ($row = $block24_count->fetch()) {
        $mortgaged_gata_amount += $row['MortgagedGataAmount'];
    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $mortgaged_gata_count);
} else if ($data_point == '52') {
    $block24_count = $db->prepare("SELECT COUNT(T1.ID) AS MortgagedGataCount, SUM(T1.MortgagedAmount) AS MortgagedGataAmount
                                    FROM lm_gata_martgaged_info T1
                                    WHERE T1.Mortgaged = ?
                                    GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo, T1.OwnerNo
                                    ");
    $block24_count->bindValue(1, '1');
    $block24_count->execute();
    $mortgaged_kashtkar_count = $block24_count->rowCount();
    $mortgaged_gata_amount = 0;
    while ($row = $block24_count->fetch()) {
        $mortgaged_gata_amount += $row['MortgagedGataAmount'];
    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $mortgaged_kashtkar_count);
} else if ($data_point == '53') {
    $sql = $db->prepare("SELECT T1.ID
                        FROM lm_gata_ebasta T1
                        LEFT JOIN lm_gata T3 ON (T3.VillageCode = T1.VillageCode AND T3.GataNo = T1.GataNo AND T3.KhataNo = T1.KhataNo)
                        WHERE MATCH(T1.Ebasta1) AGAINST (?)
                        AND (T3.Shreni = ? OR T3.Shreni = ?)
                        GROUP BY T1.VillageCode, T1.Ebasta1
                        ");
    $sql->bindValue(1, 'file_name');
    $sql->bindValue(2, '1-क');
    $sql->bindValue(3, '2');
    $sql->execute();
    $document_count = $sql->rowCount();
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $document_count);
} else if ($data_point == '54') {
    $sql = $db->prepare("SELECT T1.ID
                        FROM lm_gata_ebasta T1
                        LEFT JOIN lm_gata T3 ON (T3.VillageCode = T1.VillageCode AND T3.GataNo = T1.GataNo AND T3.KhataNo = T1.KhataNo)
                        WHERE MATCH(T1.Ebasta2) AGAINST (?)
                        AND (T3.Shreni = ? OR T3.Shreni = ?)
                        GROUP BY T1.VillageCode, T1.Ebasta2
                        ");
    $sql->bindValue(1, 'file_name');
    $sql->bindValue(2, '1-क');
    $sql->bindValue(3, '2');
    $sql->execute();
    $document_count = $sql->rowCount();
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $document_count);
} else if ($data_point == '55') {
    $sql = $db->prepare("SELECT T1.ID
                        FROM lm_gata_ebasta T1
                        LEFT JOIN lm_gata T3 ON (T3.VillageCode = T1.VillageCode AND T3.GataNo = T1.GataNo AND T3.KhataNo = T1.KhataNo)
                        WHERE MATCH(T1.Ebasta3) AGAINST (?)
                        AND (T3.Shreni = ? OR T3.Shreni = ?)
                        GROUP BY T1.VillageCode, T1.Ebasta3
                        ");
    $sql->bindValue(1, 'file_name');
    $sql->bindValue(2, '1-क');
    $sql->bindValue(3, '2');
    $sql->execute();
    $document_count = $sql->rowCount();
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $document_count);
} else if ($data_point == '56') {
    $sql = $db->prepare("SELECT T1.ID
                        FROM lm_gata_ebasta T1
                        LEFT JOIN lm_gata T3 ON (T3.VillageCode = T1.VillageCode AND T3.GataNo = T1.GataNo AND T3.KhataNo = T1.KhataNo)
                        WHERE MATCH(T1.Ebasta4) AGAINST (?)
                        AND (T3.Shreni = ? OR T3.Shreni = ?)
                        GROUP BY T1.VillageCode, T1.Ebasta4
                        ");
    $sql->bindValue(1, 'file_name');
    $sql->bindValue(2, '1-क');
    $sql->bindValue(3, '2');
    $sql->execute();
    $document_count = $sql->rowCount();
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $document_count);
}

$db_respose_data = json_encode(array('status' => '1', 'message' => '', 'success_array' => $db_respose_array));
print_r($db_respose_data);
exit();
