<?php

$user_type = $_SESSION['UserType'];
$dashboard_data = $_REQUEST['dashboard_data'];
$village_code = $_REQUEST['village_code'];
$title = $_REQUEST['title'];
$column_arr = array();
$column_head = array();

$column_arr = explode(',', $_REQUEST['column_arr']);
$column_head = explode(',', $_REQUEST['column_head']);

if ($dashboard_data == '1') {
    //$title = 'Total Kashtkars';
    $query = "SELECT T1.VillageName, T2.VillageCode, T2.GataNo, T3.owner_name, T3.owner_father
                                        FROM lm_village T1
                                        LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                        LEFT JOIN lm_gata_kashtkar T3 ON (T3.VillageCode = T2.VillageCode AND T3.GataNo = T2.GataNo)
                                    WHERE 1 = 1
                                    ";

    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Active = ?
                                        AND T2.BoardApproved = ?
                                        AND (T2.Shreni = ? OR T2.Shreni = ?)
                                        GROUP BY T3.VillageCode, T3.owner_name, T3.owner_father
                                        ORDER BY T1.VillageName ASC, CAST(T2.GataNo AS FLOAT), T2.GataNo ASC";
    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 1);
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, '1-क');
    $sql->bindValue($i++, '2');
    $sql->execute();
} else if ($dashboard_data == '2') {
    $query = "SELECT T2.VillageName, T1.ID, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.Area, T1.Shreni, T1.total_land_and_parisampatti_amount
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";

    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                AND CAST(T1.total_land_and_parisampatti_amount AS FLOAT) > ?
                ORDER BY T2.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC";

    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 0);
    $sql->execute();
} else if ($dashboard_data == '3') {
    //$title = 'Total kashtkars whose bainama done';
    $query = "SELECT T4.VillageName, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.KashtkarAnsh, ROUND(SUM(T1.AnshRakba), 4) AS AnshRakba, T1.Ebasta2, T1.owner_name, T1.owner_father
                                        FROM lm_gata_ebasta T1
                                        LEFT JOIN lm_gata T3 ON (T3.VillageCode = T1.VillageCode AND T3.GataNo = T1.GataNo AND T3.KhataNo = T1.KhataNo)
                                        LEFT JOIN lm_village T4 ON T4.VillageCode = T1.VillageCode
                                        WHERE 1 = 1
                                        ";

    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND MATCH(T1.Ebasta2) AGAINST (?)
                                        AND (T3.Shreni = ? OR T3.Shreni = ?)
                                        GROUP BY T1.VillageCode, T1.owner_name, T1.owner_father
                                        ORDER BY T4.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC";
    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'file_name');
    $sql->bindValue($i++, '1-क');
    $sql->bindValue($i++, '2');
    $sql->execute();
} else if ($dashboard_data == '4') {
    //$title = 'Total kashtkars whose bainama done';
    $query = "SELECT T4.VillageName, T1.VillageCode, T1.VilekhSankhya, T1.AnshDate, T1.Ebasta2, T1.LandAmount, T1.BainamaArea, T1.ParisampattiAmount, T1.BainamaAmount, T1.PaymentAmount, T1.PaymentDate
                                        FROM lm_gata_ebasta T1
                                        LEFT JOIN lm_gata T3 ON (T3.VillageCode = T1.VillageCode AND T3.GataNo = T1.GataNo AND T3.KhataNo = T1.KhataNo)
                                        LEFT JOIN lm_village T4 ON T4.VillageCode = T1.VillageCode
                                        WHERE 1 = 1
                                        ";

    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND MATCH(T1.Ebasta2) AGAINST (?)
                                        AND (T3.Shreni = ? OR T3.Shreni = ?)
                                        GROUP BY T1.VillageCode, T1.Ebasta2
                                        ORDER BY T4.VillageName ASC, T1.AnshDate ASC";
    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'file_name');
    $sql->bindValue($i++, '1-क');
    $sql->bindValue($i++, '2');
    $sql->execute();
} else if ($dashboard_data == '5') {
    //$title = 'Total kashtkars whose bainama done';
    $query = "SELECT T4.VillageName, T1.VillageCode, T1.VilekhSankhya, T1.AnshDate, T1.Ebasta2, T1.LandAmount, T1.BainamaArea, T1.ParisampattiAmount, T1.BainamaAmount, T1.PaymentAmount, T1.PaymentDate
                                        FROM lm_gata_ebasta T1
                                        LEFT JOIN lm_gata T3 ON (T3.VillageCode = T1.VillageCode AND T3.GataNo = T1.GataNo AND T3.KhataNo = T1.KhataNo)
                                        LEFT JOIN lm_village T4 ON T4.VillageCode = T1.VillageCode
                                        WHERE 1 = 1
                                        ";

    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND MATCH(T1.Ebasta2) AGAINST (?)
                                        AND (T3.Shreni = ? OR T3.Shreni = ?)
                                        AND CAST(T1.PaymentAmount AS FLOAT) > ?
                                        GROUP BY T1.VillageCode, T1.Ebasta2
                                        ORDER BY T4.VillageName ASC, T1.AnshDate ASC";
    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'file_name');
    $sql->bindValue($i++, '1-क');
    $sql->bindValue($i++, '2');
    $sql->bindValue($i++, 0);
    $sql->execute();
} else if ($dashboard_data == '6') {
    //$title = 'Total kashtkars whose bainama done';
    $query = "SELECT T4.VillageName, T1.VillageCode, T1.VilekhSankhya, T1.AnshDate, T1.Ebasta2, T1.LandAmount, T1.BainamaArea, T1.ParisampattiAmount, T1.BainamaAmount, T1.PaymentAmount, T1.PaymentDate
                                        FROM lm_gata_ebasta T1
                                        LEFT JOIN lm_gata T3 ON (T3.VillageCode = T1.VillageCode AND T3.GataNo = T1.GataNo AND T3.KhataNo = T1.KhataNo)
                                        LEFT JOIN lm_village T4 ON T4.VillageCode = T1.VillageCode
                                        WHERE 1 = 1
                                        ";

    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND MATCH(T1.Ebasta2) AGAINST (?)
                                        AND (T3.Shreni = ? OR T3.Shreni = ?)
                                        AND CAST(T1.BainamaAmount AS FLOAT) > ?
                                        GROUP BY T1.VillageCode, T1.Ebasta2
                                        ORDER BY T4.VillageName ASC, T1.AnshDate ASC";
    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'file_name');
    $sql->bindValue($i++, '1-क');
    $sql->bindValue($i++, '2');
    $sql->bindValue($i++, 0);
    $sql->execute();
    
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
    
} else if ($dashboard_data == '7') {
    //$title = 'Total kashtkars whose bainama done';
    $start_date = "09-02-2024";
    $last_date = date('Y-m-d', strtotime("-30 days"));

    $query = "SELECT T4.VillageName, T1.VillageCode, T1.VilekhSankhya, T1.AnshDate, T1.Ebasta2, T1.LandAmount, T1.BainamaArea, T1.ParisampattiAmount, T1.BainamaAmount, T1.PaymentAmount, T1.PaymentDate, COUNT(T1.VilekhSankhya) AS CountVilekhSankhya
                                        FROM lm_gata_ebasta T1
                                        LEFT JOIN lm_gata T3 ON (T3.VillageCode = T1.VillageCode AND T3.GataNo = T1.GataNo AND T3.KhataNo = T1.KhataNo)
                                        LEFT JOIN lm_village T4 ON T4.VillageCode = T1.VillageCode
                                        WHERE 1 = 1
                                        ";

    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND MATCH(T1.Ebasta2) AGAINST (?)
                                        AND (T3.Shreni = ? OR T3.Shreni = ?)
                                        AND T1.PaymentAmount = ?
                                        AND FROM_UNIXTIME(T1.AnshDate, '%Y-%m-%d') BETWEEN ? AND ?
                                        GROUP BY T1.VillageCode, T1.Ebasta2
                                        HAVING CountVilekhSankhya > ?
                                        ORDER BY T4.VillageName ASC, T1.AnshDate ASC";
    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'file_name');
    $sql->bindValue($i++, '1-क');
    $sql->bindValue($i++, '2');
    $sql->bindValue($i++, 0);
    $sql->bindParam($i++, $start_date);
    $sql->bindParam($i++, $last_date);
    $sql->bindValue($i++, 0);
    $sql->execute();
}