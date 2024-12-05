<?php

$user_type = $_SESSION['UserType'];
$data_point = $_POST['data_point'];
$count = $_POST['count'] ? $_POST['count'] : 1;
$data_count = 0;
ini_set('precision', 10);
ini_set('serialize_precision', 10);

if ($data_point == '1') {
    if (!isset($_SESSION['kashtkar_count'])) {
        $sql = $db->prepare("SELECT T2.VillageCode, T2.GataNo, T3.owner_name, T3.owner_father
                                            FROM lm_village T1
                                            LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                            LEFT JOIN lm_gata_kashtkar T3 ON (T3.VillageCode = T2.VillageCode AND T3.GataNo = T2.GataNo)
                                            WHERE T1.Active = ?
                                            AND T2.BoardApproved = ?
                                            AND (T2.Shreni = ? OR T2.Shreni = ?)
                                            GROUP BY T3.VillageCode, T3.owner_name, T3.owner_father
                                            ");
        $sql->bindValue(1, 1);
        $sql->bindValue(2, 'YES');
        $sql->bindValue(3, '1-क');
        $sql->bindValue(4, '2');
        $sql->execute();
        $kashtkar_count = $sql->rowCount();
        $_SESSION['kashtkar_count'] = $kashtkar_count;
    } else {
        $kashtkar_count = $_SESSION['kashtkar_count'];
    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $kashtkar_count);
} else if ($data_point == '2') {
    $sql = $db->prepare("SELECT SUM(T2.total_land_and_parisampatti_amount) AS total_land_and_parisampatti_amount
                        FROM lm_village T1
                        LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                        WHERE T1.Active = ?
                        AND T2.BoardApproved = ?
                        AND CAST(T2.total_land_and_parisampatti_amount AS FLOAT) > ?
                        ");
    $sql->bindValue(1, 1);
    $sql->bindValue(2, 'YES');
    $sql->bindValue(3, '0');
    $sql->execute();
    $block2_count = $sql->fetch();
    $total_land_and_parisampatti_amount = convert_rupee_roundoff($block2_count['total_land_and_parisampatti_amount']);
    $count++;
    $db_respose_array = array('count' => $count, 'point1' => $total_land_and_parisampatti_amount);
} else if ($data_point == '3') {
    $sql = $db->prepare("SELECT T1.ID
                                        FROM lm_gata_ebasta T1
                                        LEFT JOIN lm_gata T3 ON (T3.VillageCode = T1.VillageCode AND T3.GataNo = T1.GataNo AND T3.KhataNo = T1.KhataNo)
                                        WHERE MATCH(T1.Ebasta2) AGAINST (?)
                                        AND (T3.Shreni = ? OR T3.Shreni = ?)
                                        GROUP BY T1.VillageCode, T1.owner_name, T1.owner_father
                                        ");
    $sql->bindValue(1, 'file_name');
    $sql->bindValue(2, '1-क');
    $sql->bindValue(3, '2');
    $sql->execute();
    $kashtkar_bainama_count = $sql->rowCount();
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $kashtkar_bainama_count);
} else if ($data_point == '4') {
    $sql = $db->prepare("SELECT T1.BainamaAmount, T1.PaymentAmount, T1.BainamaArea
                            FROM lm_gata_ebasta T1
                            WHERE MATCH(T1.Ebasta2) AGAINST (?)
                            GROUP BY T1.VillageCode, T1.Ebasta2
                            ");
    $sql->bindValue(1, 'file_name');
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $bainama_total_amount = 0;
    while ($row = $sql->fetch()) {
        $bainama_total_amount += $row['BainamaAmount'];
    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => convert_rupee_roundoff($bainama_total_amount));
} else if ($data_point == '5') {
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

    $db_respose_array = array('count' => $count, 'point1' => convert_rupee_roundoff($money_disbursed));
} else if ($data_point == '6') {
    $sql = $db->prepare("SELECT T1.BainamaAmount, T1.PaymentAmount, T1.BainamaArea
                            FROM lm_gata_ebasta T1
                            WHERE MATCH(T1.Ebasta2) AGAINST (?)
                            GROUP BY T1.VillageCode, T1.Ebasta2
                            ");
    $sql->bindValue(1, 'file_name');
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $bainama_total_amount = 0;
    $payment_total_amount = 0;
    while ($row = $sql->fetch()) {
        $bainama_total_amount += $row['BainamaAmount'];
    }

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

    $db_respose_array = array('count' => $count, 'point1' => convert_rupee_roundoff($bainama_total_amount - $money_disbursed));
} else if ($data_point == '7') {
    $start_date = "2024-02-09";
    $last_date = date('Y-m-d', strtotime("-30 days"));

    $sql = $db->prepare("SELECT T1.VillageCode, COUNT(T1.VilekhSankhya) AS CountVilekhSankhya
                            FROM lm_gata_ebasta T1
                            LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                            WHERE MATCH(T1.Ebasta2) AGAINST (?)
                            AND (T2.Shreni = ? OR T2.Shreni = ?)
                            AND T1.PaymentAmount = ?
                            AND FROM_UNIXTIME(T1.AnshDate, '%Y-%m-%d') BETWEEN ? AND ?
                            GROUP BY T1.VillageCode, T1.Ebasta2
                            HAVING CountVilekhSankhya > ?
                            ");
    $sql->bindValue(1, 'file_name');
    $sql->bindValue(2, '1-क');
    $sql->bindValue(3, '2');
    $sql->bindValue(4, 0);
    $sql->bindParam(5, $start_date);
    $sql->bindParam(6, $last_date);
    $sql->bindValue(7, 0);
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $vilekh_without_payment = 0;
    while ($row = $sql->fetch()) {
        $vilekh_without_payment++;
    }
    $count++;

    $db_respose_array = array('count' => $count, 'point1' => $vilekh_without_payment);
}

$db_respose_data = json_encode(array('status' => '1', 'message' => '', 'success_array' => $db_respose_array));
print_r($db_respose_data);
exit();
