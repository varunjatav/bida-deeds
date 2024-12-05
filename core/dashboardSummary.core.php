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
    //$title = 'Total Villages';
    $query = "SELECT T1.VillageName, T1.VillageCode
                FROM lm_village T1
                WHERE 1 = 1
                ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Active = ?
                ORDER BY T1.VillageName ASC";

    $village_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $village_count->bindValue($i++, $village_code);
    }
    $village_count->bindValue($i++, 1);
    $village_count->execute();
} else if ($dashboard_data == '2') {
    //$title = 'Total villages accquired';
    $query = "SELECT T1.VillageName, T2.VillageCode, COUNT(T3.ID) AS KashtkarCount, KashtkarBainamaCount
                                    FROM lm_village T1
                                    LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                    LEFT JOIN lm_gata_kashtkar T3 ON (T3.VillageCode = T2.VillageCode AND T3.GataNo = T2.GataNo)
                                    LEFT JOIN (
                                        SELECT T4.VillageCode, T4.GataNo, T4.KhataNo, COUNT(T4.ID) AS KashtkarBainamaCount
                                        FROM lm_gata_ebasta T4
                                        WHERE T4.Ebasta2 IS NOT NULL
                                        GROUP BY T4.VillageCode
                                    ) TMP ON TMP.VillageCode = T2.VillageCode
                                    WHERE 1 = 1
                                    ";

    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Active = ?
                                    AND T2.BoardApproved = ?
                                    GROUP BY T2.VillageCode
                                    HAVING KashtkarCount = KashtkarBainamaCount
                                    ORDER BY T1.VillageName ASC";

    $village_acquired = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $village_acquired->bindValue($i++, $village_code);
    }
    $village_acquired->bindValue($i++, 1);
    $village_acquired->bindValue($i++, 'YES');
    $village_acquired->execute();
} else if ($dashboard_data == '3') {
    //$title = 'Total villages partially accquired';
    $query = "SELECT T1.VillageName, T2.VillageCode, COUNT(T3.ID) AS KashtkarCount, KashtkarBainamaCount
                                    FROM lm_village T1
                                    LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                    LEFT JOIN lm_gata_kashtkar T3 ON (T3.VillageCode = T2.VillageCode AND T3.GataNo = T2.GataNo)
                                    LEFT JOIN (
                                        SELECT T4.VillageCode, T4.GataNo, T4.KhataNo, COUNT(T4.ID) AS KashtkarBainamaCount
                                        FROM lm_gata_ebasta T4
                                        WHERE MATCH(T4.Ebasta2) AGAINST (?)
                                        GROUP BY T4.VillageCode
                                    ) TMP ON TMP.VillageCode = T2.VillageCode
                                    WHERE 1 = 1
                                    ";

    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Active = ?
                                    AND T2.BoardApproved = ?
                                    GROUP BY T2.VillageCode
                                    HAVING KashtkarCount != KashtkarBainamaCount
                                    ORDER BY T1.VillageName ASC";

    $village_acquired = $db->prepare($query);
    $i = 1;
    $village_acquired->bindValue($i++, 'file_name');
    if ($village_code) {
        $village_acquired->bindValue($i++, $village_code);
    }
    $village_acquired->bindValue($i++, 1);
    $village_acquired->bindValue($i++, 'YES');
    $village_acquired->execute();
} else if ($dashboard_data == '4') {
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
    $kashtkar_count_query = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $kashtkar_count_query->bindValue($i++, $village_code);
    }
    $kashtkar_count_query->bindValue($i++, 1);
    $kashtkar_count_query->bindValue($i++, 'YES');
    $kashtkar_count_query->bindValue($i++, '1-क');
    $kashtkar_count_query->bindValue($i++, '2');
    $kashtkar_count_query->execute();
} else if ($dashboard_data == '5') {
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
    $khastkar_bainama_query = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $khastkar_bainama_query->bindValue($i++, $village_code);
    }
    $khastkar_bainama_query->bindValue($i++, 'file_name');
    $khastkar_bainama_query->bindValue($i++, '1-क');
    $khastkar_bainama_query->bindValue($i++, '2');
    $khastkar_bainama_query->execute();
} else if ($dashboard_data == '6') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T3.VillageName, T1.ID, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.OwnerNo, ROUND(SUM(T1.AnshRakba), 4) AS AnshRakba, T2.Shreni
                                FROM lm_gata_ebasta T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo
                                LEFT JOIN lm_village T3 ON T3.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";

    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T2.BoardApproved = ?
                                AND (T2.Shreni = ? OR T2.Shreni = ? OR T2.Shreni LIKE ? OR T2.Shreni LIKE ?)
                                AND MATCH(T1.Ebasta2) AGAINST (?)
                                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                ORDER BY T3.VillageName ASC, CAST(T2.GataNo AS FLOAT), T2.GataNo ASC";

    $village_acquired = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $village_acquired->bindValue($i++, $village_code);
    }
    $village_acquired->bindValue($i++, 'YES');
    $village_acquired->bindValue($i++, '1-क');
    $village_acquired->bindValue($i++, '2');
    $village_acquired->bindValue($i++, '5%');
    $village_acquired->bindValue($i++, '6%');
    $village_acquired->bindValue($i++, 'file_name');
    $village_acquired->execute();
} else if ($dashboard_data == '7') {
    //$title = 'Total CH 41/45 uploaded';
    $query = "SELECT T1.VillageName, T1.VillageCode
                                FROM lm_village T1
                                LEFT JOIN lm_village_ebasta T2 ON (T2.VillageCode = T1.VillageCode)
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Active = ?
                                AND T2.Ebasta13 IS NOT NULL";

    $ch4145_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $ch4145_count->bindValue($i++, $village_code);
    }
    $ch4145_count->bindValue($i++, 1);
    $ch4145_count->execute();
} else if ($dashboard_data == '8') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.VillageName, T2.VillageCode, T3.Shreni, T3.Area, T2.GataNo, T2.KhataNo, T2.AnshRakba, T4.owner_name, T4.owner_father
                                    FROM lm_village T1
                                    LEFT JOIN lm_gata_ebasta T2 ON T2.VillageCode = T1.VillageCode
                                    LEFT JOIN lm_gata T3 ON T3.VillageCode = T2.VillageCode AND T3.KhataNo = T2.KhataNo AND T3.GataNo = T2.GataNo
                                    LEFT JOIN lm_gata_kashtkar T4 ON T4.VillageCode = T2.VillageCode AND T4.KhataNo = T2.KhataNo AND T4.GataNo = T2.GataNo AND T4.OwnerNo = T2.OwnerNo
                                    WHERE 1 = 1
                                    ";

    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND MATCH(T2.Ebasta2) AGAINST (?)
                AND T3.BoardApproved = ?
                AND (T3.Shreni = ? OR T3.Shreni = ? OR T3.Shreni LIKE ? OR T3.Shreni LIKE ?)
                GROUP BY T2.VillageCode, T2.KhataNo, T2.GataNo
                ORDER BY T1.VillageName ASC, CAST(T2.GataNo AS FLOAT), T2.GataNo ASC";

    $village_acquired = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $village_acquired->bindValue($i++, $village_code);
    }
    $village_acquired->bindValue($i++, 'file_name');
    $village_acquired->bindValue($i++, 'YES');
    $village_acquired->bindValue($i++, '1-क');
    $village_acquired->bindValue($i++, '2');
    $village_acquired->bindValue($i++, '5%');
    $village_acquired->bindValue($i++, '6%');
    $village_acquired->execute();
} else if ($dashboard_data == '9') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.VillageName, T1.VillageCode
                                FROM lm_village T1
                                LEFT JOIN lm_village_ebasta T2 ON (T2.VillageCode = T1.VillageCode)
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Active = ?
                                AND T2.Ebasta11 IS NOT NULL";
    $ch1359_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $ch1359_count->bindValue($i++, $village_code);
    }
    $ch1359_count->bindValue($i++, 1);
    $ch1359_count->execute();
} else if ($dashboard_data == '10') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.VillageName, T1.VillageCode
                                    FROM lm_village T1
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Active = ?
                ORDER BY T1.VillageName ASC";

    $village_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $village_count->bindValue($i++, $village_code);
    }
    $village_count->bindValue($i++, 1);
    $village_count->execute();
} else if ($dashboard_data == '11') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.VillageName, T1.VillageCode
                                FROM lm_village T1
                                LEFT JOIN lm_village_ebasta T2 ON (T2.VillageCode = T1.VillageCode)
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Active = ?
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
                ORDER BY T1.VillageName ASC";
    $ebasta_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $ebasta_count->bindValue($i++, $village_code);
    }
    $ebasta_count->bindValue($i++, 1);
    $ebasta_count->execute();
} else if ($dashboard_data == '12') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.VillageName, T1.VillageCode, T2.GataNo, T2.Shreni, T2.Area
                                FROM lm_village T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Active = ?
                                AND T2.BoardApproved = ?
                                AND (T2.Shreni = ? OR T2.Shreni = ? OR T2.Shreni LIKE ? OR T2.Shreni LIKE ?)
                                ORDER BY T1.VillageName ASC, CAST(T2.GataNo AS FLOAT), T2.GataNo ASC";
    $block17_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $block17_count->bindValue($i++, $village_code);
    }
    $block17_count->bindValue($i++, '1');
    $block17_count->bindValue($i++, 'YES');
    $block17_count->bindValue($i++, '1-क');
    $block17_count->bindValue($i++, '2');
    $block17_count->bindValue($i++, '5%');
    $block17_count->bindValue($i++, '6%');
    $block17_count->execute();
} else if ($dashboard_data == '13') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.VillageName, T1.VillageCode, T2.GataNo, T2.Shreni, T2.Area
                                    FROM lm_village T1
                                    LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Active = ?
                                    AND T2.BoardApproved = ?
                                    AND (T2.Shreni = ? OR T2.Shreni = ?)
                                    ORDER BY T1.VillageName ASC, CAST(T2.GataNo AS FLOAT), T2.GataNo ASC";
    $block17_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $block17_count->bindValue($i++, $village_code);
    }
    $block17_count->bindValue($i++, '1');
    $block17_count->bindValue($i++, 'YES');
    $block17_count->bindValue($i++, '1-क');
    $block17_count->bindValue($i++, '2');
    $block17_count->execute();
} else if ($dashboard_data == '14') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.VillageName, T1.VillageCode, T2.GataNo, T2.Shreni, T2.Area
                                    FROM lm_village T1
                                    LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Active = ?
                                    AND T2.BoardApproved = ?
                                    AND (T2.Shreni LIKE ? OR T2.Shreni LIKE ?)
                                    ORDER BY T1.VillageName ASC, CAST(T2.GataNo AS FLOAT), T2.GataNo ASC";
    $block17_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $block17_count->bindValue($i++, $village_code);
    }
    $block17_count->bindValue($i++, '1');
    $block17_count->bindValue($i++, 'YES');
    $block17_count->bindValue($i++, '5%');
    $block17_count->bindValue($i++, '6%');
    $block17_count->execute();
} else if ($dashboard_data == '15') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T3.VillageName, T1.ID, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.OwnerNo, ROUND(SUM(T1.AnshRakba), 4) AS AnshRakba, T2.Shreni
                                FROM lm_gata_ebasta T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo
                                LEFT JOIN lm_village T3 ON T3.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T2.BoardApproved = ?
                                AND (T2.Shreni = ? OR T2.Shreni = ?)
                                AND MATCH(T1.Ebasta2) AGAINST (?)
                                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                                ORDER BY T3.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC";
    $block17_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $block17_count->bindValue($i++, $village_code);
    }
    $block17_count->bindValue($i++, 'YES');
    $block17_count->bindValue($i++, '1-क');
    $block17_count->bindValue($i++, '2');
    $block17_count->bindValue($i++, 'file_name');
    $block17_count->execute();
} else if ($dashboard_data == '16') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T3.VillageName, T1.ID, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.OwnerNo, ROUND(SUM(T1.AnshRakba), 4) AS AnshRakba, T2.Shreni
                                FROM lm_gata_ebasta T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo
                                LEFT JOIN lm_village T3 ON T3.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T2.BoardApproved = ?
                                AND (T2.Shreni LIKE ? OR T2.Shreni LIKE ?)
                                AND MATCH(T1.Ebasta2) AGAINST (?)
                                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                                ORDER BY T3.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC";
    $block31_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $block31_count->bindValue($i++, $village_code);
    }
    $block31_count->bindValue($i++, 'YES');
    $block31_count->bindValue($i++, '5%');
    $block31_count->bindValue($i++, '6%');
    $block31_count->bindValue($i++, 'file_name');
    $block31_count->execute();
} else if ($dashboard_data == '17') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.VillageName, T1.VillageCode, T2.GataNo, T2.Shreni, T2.Area
                                FROM lm_village T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Active = ?
                                AND T2.BoardApproved = ?
                                ORDER BY T1.VillageName ASC, CAST(T2.GataNo AS FLOAT), T2.GataNo ASC";
    $block17_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $block17_count->bindValue($i++, $village_code);
    }
    $block17_count->bindValue($i++, '1');
    $block17_count->bindValue($i++, 'YES');
    $block17_count->execute();
} else if ($dashboard_data == '18') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.VillageName, T1.VillageCode, T2.GataNo, T2.Shreni, T2.Area
                                FROM lm_village T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Active = ?
                                AND T2.BoardApproved = ?
                                AND (T2.Shreni = ? OR T2.Shreni = ?)
                                ORDER BY T1.VillageName ASC, CAST(T2.GataNo AS FLOAT), T2.GataNo ASC";
    $block17_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $block17_count->bindValue($i++, $village_code);
    }
    $block17_count->bindValue($i++, '1');
    $block17_count->bindValue($i++, 'YES');
    $block17_count->bindValue($i++, '1-क');
    $block17_count->bindValue($i++, '2');
    $block17_count->execute();
} else if ($dashboard_data == '19') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.VillageName, T1.VillageCode, T2.GataNo, T2.Shreni, T2.Area
                                FROM lm_village T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Active = ?
                                AND T2.BoardApproved = ?
                                AND (T2.Shreni LIKE ? OR T2.Shreni LIKE ?)
                                ORDER BY T1.VillageName ASC, CAST(T2.GataNo AS FLOAT), T2.GataNo ASC";
    $block17_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $block17_count->bindValue($i++, $village_code);
    }
    $block17_count->bindValue($i++, '1');
    $block17_count->bindValue($i++, 'YES');
    $block17_count->bindValue($i++, '5%');
    $block17_count->bindValue($i++, '6%');
    $block17_count->execute();
} else if ($dashboard_data == '20') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T4.VillageName, T1.VillageCode, T1.GataNo, Shreni, T1.KhataNo, T1.OwnerNo, T2.owner_name, ROUND(SUM(T1.AnshRakba), 4) AS AnshRakba, KashtkarBainamaCount, GataArea
                                FROM lm_gata_ebasta T1
                                LEFT JOIN lm_gata_kashtkar T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo AND T2.OwnerNo = T1.OwnerNo)
                                LEFT JOIN
                                        (SELECT T3.VillageCode, T3.GataNo, T3.KhataNo, T3.Shreni, COUNT(T3.ID) AS KashtkarBainamaCount, ROUND(SUM(T3.Area), 4) AS GataArea
                                            FROM lm_gata T3
                                            WHERE T3.BoardApproved = ?
                                            AND (T3.Shreni = ? OR T3.Shreni = ?)
                                            GROUP BY T3.VillageCode, T3.KhataNo, T3.GataNo
                                        ) TMP ON TMP.VillageCode = T2.VillageCode AND TMP.GataNo = T2.GataNo AND TMP.KhataNo = T2.KhataNo
                                LEFT JOIN lm_village T4 ON T4.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND MATCH(T1.Ebasta2) AGAINST (?)
                                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                                HAVING (KashtkarBainamaCount IS NOT NULL
                                        AND AnshRakba = GataArea
                                        )
                                ORDER BY T4.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC";
    $block30_count = $db->prepare($query);
    $i = 1;
    $block30_count->bindValue($i++, 'YES');
    $block30_count->bindValue($i++, '1-क');
    $block30_count->bindValue($i++, '2');
    if ($village_code) {
        $block30_count->bindValue($i++, $village_code);
    }
    $block30_count->bindValue($i++, 'file_name');
    $block30_count->execute();
} else if ($dashboard_data == '21') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T4.VillageName, T1.VillageCode, T1.GataNo, Shreni, T1.KhataNo, T1.OwnerNo, T2.owner_name, ROUND(SUM(T1.AnshRakba), 4) AS AnshRakba, KashtkarBainamaCount, GataArea
                                FROM lm_gata_ebasta T1
                                LEFT JOIN lm_gata_kashtkar T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo AND T2.OwnerNo = T1.OwnerNo)
                                LEFT JOIN
                                        (SELECT T3.VillageCode, T3.GataNo, T3.KhataNo, T3.Shreni, COUNT(T3.ID) AS KashtkarBainamaCount, ROUND(SUM(T3.Area), 4) AS GataArea
                                            FROM lm_gata T3
                                            WHERE T3.BoardApproved = ?
                                            AND (T3.Shreni = ? OR T3.Shreni = ?)
                                            GROUP BY T3.VillageCode, T3.KhataNo, T3.GataNo
                                        ) TMP ON TMP.VillageCode = T2.VillageCode AND TMP.GataNo = T2.GataNo AND TMP.KhataNo = T2.KhataNo
                                LEFT JOIN lm_village T4 ON T4.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND MATCH(T1.Ebasta2) AGAINST (?)
                                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                                HAVING (KashtkarBainamaCount IS NOT NULL
                                        AND AnshRakba != GataArea
                                        )
                                ORDER BY T4.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC";
    $block30_count = $db->prepare($query);
    $i = 1;
    $block30_count->bindValue($i++, 'YES');
    $block30_count->bindValue($i++, '1-क');
    $block30_count->bindValue($i++, '2');
    if ($village_code) {
        $block30_count->bindValue($i++, $village_code);
    }
    $block30_count->bindValue($i++, 'file_name');
    $block30_count->execute();
} else if ($dashboard_data == '22') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T4.VillageName, T1.VillageCode, T1.GataNo, Shreni, T1.KhataNo, T1.OwnerNo, T2.owner_name, ROUND(SUM(T1.AnshRakba), 4) AS AnshRakba, KashtkarBainamaCount, GataArea
                                FROM lm_gata_ebasta T1
                                LEFT JOIN lm_gata_kashtkar T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo AND T2.OwnerNo = T1.OwnerNo)
                                LEFT JOIN
                                        (SELECT T3.VillageCode, T3.GataNo, T3.KhataNo, T3.Shreni, COUNT(T3.ID) AS KashtkarBainamaCount, ROUND(SUM(T3.Area), 4) AS GataArea
                                            FROM lm_gata T3
                                            WHERE T3.BoardApproved = ?
                                            AND (T3.Shreni LIKE ? OR T3.Shreni LIKE ?)
                                            GROUP BY T3.VillageCode, T3.KhataNo, T3.GataNo
                                        ) TMP ON TMP.VillageCode = T2.VillageCode AND TMP.GataNo = T2.GataNo AND TMP.KhataNo = T2.KhataNo
                                LEFT JOIN lm_village T4 ON T4.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND MATCH(T1.Ebasta2) AGAINST (?)
                                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                                HAVING (KashtkarBainamaCount IS NOT NULL
                                        AND AnshRakba = GataArea
                                        )
                                ORDER BY T4.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC";
    $block30_count = $db->prepare($query);
    $i = 1;
    $block30_count->bindValue($i++, 'YES');
    $block30_count->bindValue($i++, '5%');
    $block30_count->bindValue($i++, '6%');
    if ($village_code) {
        $block30_count->bindValue($i++, $village_code);
    }
    $block30_count->bindValue($i++, 'file_name');
    $block30_count->execute();
} else if ($dashboard_data == '23') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T4.VillageName, T1.VillageCode, T1.GataNo, Shreni, T1.KhataNo, T1.OwnerNo, T2.owner_name, ROUND(SUM(T1.AnshRakba), 4) AS AnshRakba, KashtkarBainamaCount, GataArea
                                FROM lm_gata_ebasta T1
                                LEFT JOIN lm_gata_kashtkar T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo AND T2.OwnerNo = T1.OwnerNo)
                                LEFT JOIN
                                        (SELECT T3.VillageCode, T3.GataNo, T3.KhataNo, T3.Shreni, COUNT(T3.ID) AS KashtkarBainamaCount, ROUND(SUM(T3.Area), 4) AS GataArea
                                            FROM lm_gata T3
                                            WHERE T3.BoardApproved = ?
                                            AND (T3.Shreni LIKE ? OR T3.Shreni LIKE ?)
                                            GROUP BY T3.VillageCode, T3.KhataNo, T3.GataNo
                                        ) TMP ON TMP.VillageCode = T2.VillageCode AND TMP.GataNo = T2.GataNo AND TMP.KhataNo = T2.KhataNo
                                LEFT JOIN lm_village T4 ON T4.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND MATCH(T1.Ebasta2) AGAINST (?)
                                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                                HAVING (KashtkarBainamaCount IS NOT NULL
                                        AND AnshRakba != GataArea
                                        )
                                ORDER BY T4.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC";
    $block30_count = $db->prepare($query);
    $i = 1;
    $block30_count->bindValue($i++, 'YES');
    $block30_count->bindValue($i++, '5%');
    $block30_count->bindValue($i++, '6%');
    if ($village_code) {
        $block30_count->bindValue($i++, $village_code);
    }
    $block30_count->bindValue($i++, 'file_name');
    $block30_count->execute();
} else if ($dashboard_data == '24') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.*
                                FROM lm_slao_report T1
                                    WHERE 1 = 1
                                    AND T1.RowDeleted = ?
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BankStatus != ?
                                ORDER BY T1.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC";
    $block29_count = $db->prepare($query);
    $i = 1;
    $block29_count->bindValue($i++, '0');
    if ($village_code) {
        $block29_count->bindValue($i++, $village_code);
    }
    $block29_count->bindValue($i++, '1');
    $block29_count->execute();
} else if ($dashboard_data == '25') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.*
                                FROM lm_slao_report T1
                                    WHERE 1 = 1
                                    AND T1.RowDeleted = ?
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BankStatus = ?
                                ORDER BY T1.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC";
    $block29_count = $db->prepare($query);
    $i = 1;
    $block29_count->bindValue($i++, '0');
    if ($village_code) {
        $block29_count->bindValue($i++, $village_code);
    }
    $block29_count->bindValue($i++, '1');
    $block29_count->execute();
} else if ($dashboard_data == '26') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.VillageName, T1.VillageCode, T2.GataNo, T2.Shreni, T2.Area
                                FROM lm_village T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Active = ?
                                AND CAST(T2.Area AS FLOAT) > CAST(T2.fasali_ke_anusar_rakba AS FLOAT)
                                AND T2.fasali_ke_anusar_rakba > 0
                                AND T2.BoardApproved = ?
                                ORDER BY T1.VillageName ASC, CAST(T2.GataNo AS FLOAT), T2.GataNo ASC";
    $block9_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $block9_count->bindValue($i++, $village_code);
    }
    $block9_count->bindValue($i++, 1);
    $block9_count->bindValue($i++, 'YES');
    $block9_count->execute();
} else if ($dashboard_data == '27') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.VillageName, T1.VillageCode, T2.GataNo, T2.Shreni, T2.Area
                                FROM lm_village T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Active = ?
                                AND CAST(T2.Area AS FLOAT) < CAST(T2.fasali_ke_anusar_rakba AS FLOAT)
                                AND T2.fasali_ke_anusar_rakba > 0
                                AND T2.BoardApproved = ?
                                ORDER BY T1.VillageName ASC, CAST(T2.GataNo AS FLOAT), T2.GataNo ASC";
    $block9_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $block9_count->bindValue($i++, $village_code);
    }
    $block9_count->bindValue($i++, 1);
    $block9_count->bindValue($i++, 'YES');
    $block9_count->execute();
} else if ($dashboard_data == '28') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.VillageName, T1.VillageCode, T2.GataNo, T2.Shreni, T2.Area
                                FROM lm_village T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Active = ?
                                    AND CAST(T2.Area AS FLOAT) > CAST(T2.ch41_45_ke_anusar_rakba AS FLOAT)
                                    AND T2.ch41_45_ke_anusar_rakba > 0
                                    AND T2.BoardApproved = ?
                                    ORDER BY T1.VillageName ASC, CAST(T2.GataNo AS FLOAT), T2.GataNo ASC";
    $block9_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $block9_count->bindValue($i++, $village_code);
    }
    $block9_count->bindValue($i++, 1);
    $block9_count->bindValue($i++, 'YES');
    $block9_count->execute();
} else if ($dashboard_data == '29') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.VillageName, T1.VillageCode, T2.GataNo, T2.Shreni, T2.Area
                                    FROM lm_village T1
                                    LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Active = ?
                                    AND CAST(T2.Area AS FLOAT) < CAST(T2.ch41_45_ke_anusar_rakba AS FLOAT)
                                    AND T2.ch41_45_ke_anusar_rakba > 0
                                    AND T2.BoardApproved = ?
                                    ORDER BY T1.VillageName ASC, CAST(T2.GataNo AS FLOAT), T2.GataNo ASC";
    $block9_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $block9_count->bindValue($i++, $village_code);
    }
    $block9_count->bindValue($i++, 1);
    $block9_count->bindValue($i++, 'YES');
    $block9_count->execute();
} else if ($dashboard_data == '30') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.VillageName, T1.VillageCode, T2.GataNo, T2.Shreni, T2.Area
                                    FROM lm_village T1
                                    LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Active = ?
                                    AND T2.Shreni != T2.ch41_45_ke_anusar_sreni
                                    AND T2.ch41_45_ke_anusar_sreni != ?
                                    AND T2.BoardApproved = ?
                                    ORDER BY T1.VillageName ASC, CAST(T2.GataNo AS FLOAT), T2.GataNo ASC";
    $block9_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $block9_count->bindValue($i++, $village_code);
    }
    $block9_count->bindValue($i++, 1);
    $block9_count->bindValue($i++, '');
    $block9_count->bindValue($i++, 'YES');
    $block9_count->execute();
} else if ($dashboard_data == '31') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.VillageName, T1.VillageCode, T2.GataNo, T2.Shreni, T2.Area
                                    FROM lm_village T1
                                    LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Active = ?
                                    AND T2.BoardApproved = ?
                                    ORDER BY T1.VillageName ASC, CAST(T2.GataNo AS FLOAT), T2.GataNo ASC";
    $block9_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $block9_count->bindValue($i++, $village_code);
    }
    $block9_count->bindValue($i++, 1);
    $block9_count->bindValue($i++, 'YES');
    $block9_count->execute();
} else if ($dashboard_data == '32') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.VillageName, T1.VillageCode, T2.GataNo, T2.Shreni, T2.Area
                                    FROM lm_village T1
                                    LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Active = ?
                                    AND T2.HoldByDM = ?
                                    ORDER BY T1.VillageName ASC, CAST(T2.GataNo AS FLOAT), T2.GataNo ASC";
    $block9_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $block9_count->bindValue($i++, $village_code);
    }
    $block9_count->bindValue($i++, 1);
    $block9_count->bindValue($i++, 'YES');
    $block9_count->execute();
} else if ($dashboard_data == '33') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.VillageName, T1.VillageCode, T2.GataNo, T2.Shreni, T2.Area
                                    FROM lm_village T1
                                    LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Active = ?
                                    AND T2.HoldByBIDA = ?
                                    AND T2.HoldByDM = ?
                                    ORDER BY T1.VillageName ASC, CAST(T2.GataNo AS FLOAT), T2.GataNo ASC";
    $block9_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $block9_count->bindValue($i++, $village_code);
    }
    $block9_count->bindValue($i++, 1);
    $block9_count->bindValue($i++, 'YES');
    $block9_count->bindValue($i++, 'No');
    $block9_count->execute();
} else if ($dashboard_data == '34') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.VillageName, T1.VillageCode, T2.GataNo, T2.Shreni, T2.Area
                                    FROM lm_village T1
                                    LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Active = ?
                                    AND T2.HoldByNirdharan = ?
                                    AND T2.HoldByDM = ?
                                    AND T2.HoldByBIDA = ?
                                    ORDER BY T1.VillageName ASC, CAST(T2.GataNo AS FLOAT), T2.GataNo ASC";
    $block9_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $block9_count->bindValue($i++, $village_code);
    }
    $block9_count->bindValue($i++, 1);
    $block9_count->bindValue($i++, 'YES');
    $block9_count->bindValue($i++, 'NO');
    $block9_count->bindValue($i++, 'NO');
    $block9_count->execute();
} else if ($dashboard_data == '35') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.VillageName, T1.VillageCode, T2.GataNo, T2.Shreni, T2.Area
                                    FROM lm_village T1
                                    LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Active = ?
                                    AND T2.BinamaHoldByBIDA = ?
                                    ORDER BY T1.VillageName ASC, CAST(T2.GataNo AS FLOAT), T2.GataNo ASC";
    $block9_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $block9_count->bindValue($i++, $village_code);
    }
    $block9_count->bindValue($i++, 1);
    $block9_count->bindValue($i++, 'YES');
    $block9_count->execute();
} else if ($dashboard_data == '36') {
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
                                        GROUP BY T3.VillageCode, T3.owner_name, T3.owner_father
                                        ORDER BY T1.VillageName ASC, CAST(T2.GataNo AS FLOAT), T2.GataNo ASC";
    $kashtkar_count_query = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $kashtkar_count_query->bindValue($i++, $village_code);
    }
    $kashtkar_count_query->bindValue($i++, 1);
    $kashtkar_count_query->bindValue($i++, 'YES');
    $kashtkar_count_query->execute();
} else if ($dashboard_data == '37') {
    //$title = 'Total Kashtkars';
    $query = "SELECT T3.VillageName, T1.VillageCode, T1.GataNo, T1.Shreni, T1.Area, Count
                                    FROM lm_gata T1
                                    LEFT JOIN (
                                        SELECT T2.VillageCode, T2.KhataNo, T2.GataNo, COUNT(T2.ID) AS Count
                                        FROM lm_gata_kashtkar T2
                                        GROUP BY T2.VillageCode, T2.KhataNo, T2.GataNo
                                        ) TMP ON TMP.VillageCode = T1.VillageCode AND TMP.KhataNo = T1.KhataNo AND TMP.GataNo = T1.GataNo
                                    LEFT JOIN lm_village T3 ON T3.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                                    HAVING Count > ?
                                    ORDER BY T3.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC";
    $block23_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $block23_count->bindValue($i++, $village_code);
    }
    $block23_count->bindValue($i++, 'YES');
    $block23_count->bindValue($i++, 1);
    $block23_count->execute();
} else if ($dashboard_data == '38') {
    //$title = 'Total Kashtkars';
    $query = "SELECT T1.VillageCode, T1.GataNo, COUNT(T2.ID) AS Count, T2.ID
                                    FROM lm_gata T1
                                    LEFT JOIN lm_gata_kashtkar T2 ON (T2.VillageCode = T1.VillageCode AND T2.KhataNo = T1.KhataNo AND T2.GataNo = T1.GataNo)
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                                    GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                                    HAVING Count = ?";
    $block23_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $block23_count->bindValue($i++, $village_code);
    }
    $block23_count->bindValue($i++, 'YES');
    $block23_count->bindValue($i++, 1);
    $block23_count->execute();
    $kashtkar_ansh_count = 0;
    $kashtkar_ansh_array = array();
    while ($row = $block23_count->fetch()) {
        $kashtkar_ansh_array[] = $row['GataNo'];
    }

    if (count_($kashtkar_ansh_array)) {
        $placeholders = '';
        $qPart = array_fill(0, count_($kashtkar_ansh_array), "?");
        $placeholders .= implode(",", $qPart);

        $query = "SELECT T3.VillageName, T1.VillageCode, T1.GataNo, T1.Shreni, T1.Area, T2.owner_name, T2.owner_father
                                        FROM lm_gata T1
                                        LEFT JOIN lm_gata_kashtkar T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                                        LEFT JOIN lm_village T3 ON T3.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
        if ($village_code) {
            $query .= " AND T1.VillageCode = ?";
        }
        $query .= " AND T1.BoardApproved = ?
                                        AND T1.GataNo NOT IN ($placeholders)
                                        GROUP BY T1.VillageCode, T2.owner_name, T2.owner_father
                                        ORDER BY T3.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC";

        $kashtkar_ansh_query = $db->prepare($query);
        $i = 1;
        if ($village_code) {
            $kashtkar_ansh_query->bindValue($i++, $village_code);
        }
        $kashtkar_ansh_query->bindValue($i++, 'YES');
        $j = $i++;
        foreach ($kashtkar_ansh_array as $key => $id) {
            $kashtkar_ansh_query->bindParam($j++, $kashtkar_ansh_array[$key]);
        }
        $kashtkar_ansh_query->execute();
    }
} else if ($dashboard_data == '39') {
    $query = "SELECT T1.VillageName, T1.VillageCode, T2.GataNo, T2.Shreni, T2.Area
                                    FROM lm_village T1
                                    LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                    LEFT JOIN lm_gata_ebasta T3 ON (T3.VillageCode = T2.VillageCode AND T3.KhataNo = T2.KhataNo AND T3.GataNo = T2.GataNo)
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Active = ?
                                    AND T2.BoardApproved = ?
                                    AND (T2.Shreni = ? OR T2.Shreni = ?)
                                    AND T3.Ebasta2 IS NULL
                                    GROUP BY T2.VillageCode, T2.KhataNo, T2.GataNo
                                    ORDER BY T1.VillageName ASC, CAST(T2.GataNo AS FLOAT), T2.GataNo ASC";
    $block17_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $block17_count->bindValue($i++, $village_code);
    }
    $block17_count->bindValue($i++, '1');
    $block17_count->bindValue($i++, 'YES');
    $block17_count->bindValue($i++, '1-क');
    $block17_count->bindValue($i++, '2');
    $block17_count->execute();
} else if ($dashboard_data == '40') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T3.VillageName, T1.VillageCode, T1.GataNo, T1.Shreni, T1.KhataNo, T1.Area, COUNT(T2.ID) AS Count
                                FROM lm_gata T1
                                LEFT JOIN lm_gata_kashtkar T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                                LEFT JOIN lm_village T3 ON T3.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                                AND (T1.Shreni = ? OR T1.Shreni = ?)
                                AND T2.owner_name LIKE ?
                                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                                ORDER BY T3.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC";
    $block24_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $block24_count->bindValue($i++, $village_code);
    }
    $block24_count->bindValue($i++, 'YES');
    $block24_count->bindValue($i++, '1-क');
    $block24_count->bindValue($i++, '2');
    $block24_count->bindValue($i++, 'बुन्देलखण्ड औद्योगिक%');
    $block24_count->execute();
} else if ($dashboard_data == '41') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T3.VillageName, T1.VillageCode, T1.GataNo, T1.Shreni, T1.KhataNo, T1.Area, COUNT(T2.ID) AS Count
                                FROM lm_gata T1
                                LEFT JOIN lm_gata_kashtkar T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                                LEFT JOIN lm_village T3 ON T3.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                                AND (T1.Shreni = ? OR T1.Shreni = ?)
                                AND T2.owner_name LIKE ?
                                GROUP BY T1.VillageCode, T1.KhataNo
                                ORDER BY T3.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC, T1.KhataNo ASC";
    $block24_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $block24_count->bindValue($i++, $village_code);
    }
    $block24_count->bindValue($i++, 'YES');
    $block24_count->bindValue($i++, '1-क');
    $block24_count->bindValue($i++, '2');
    $block24_count->bindValue($i++, 'बुन्देलखण्ड औद्योगिक%');
    $block24_count->execute();
} else if ($dashboard_data == '42') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T3.VillageName, T1.VillageCode, T1.GataNo, T1.Shreni, T1.KhataNo, ROUND(SUM(T1.Area), 4) AS Area
                                FROM lm_gata T1
                                LEFT JOIN lm_gata_kashtkar T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                                LEFT JOIN lm_village T3 ON T3.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                                AND (T1.Shreni = ? OR T1.Shreni = ?)
                                AND T2.owner_name LIKE ?
                                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                                ORDER BY T3.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC";
    $block24_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $block24_count->bindValue($i++, $village_code);
    }
    $block24_count->bindValue($i++, 'YES');
    $block24_count->bindValue($i++, '1-क');
    $block24_count->bindValue($i++, '2');
    $block24_count->bindValue($i++, 'बुन्देलखण्ड औद्योगिक%');
    $block24_count->execute();
} else if ($dashboard_data == '43') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T4.VillageName, T1.VillageCode, T1.GataNo, T1.KhataNo, T3.Shreni, T2.owner_name, T2.owner_father, ROUND(SUM(T1.AnshRakba), 4) AS Area
                FROM lm_gata_ebasta T1 
                LEFT JOIN lm_gata_kashtkar T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo AND T2.OwnerNo = T1.OwnerNo) 
                LEFT JOIN lm_gata T3 ON T3.VillageCode = T2.VillageCode AND T3.GataNo = T2.GataNo AND T3.KhataNo = T2.KhataNo 
                LEFT JOIN lm_village T4 ON T4.VillageCode = T1.VillageCode
                WHERE 1 = 1
                ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T3.BoardApproved = ? 
                AND (T3.Shreni = ? OR T3.Shreni = ?)
                AND MATCH(T1.Ebasta2) AGAINST(?) 
                AND NOT EXISTS (
                                SELECT T5.VillageCode, T5.KhataNo, T5.GataNo, ROUND(SUM(T4.Area), 4) AS Area 
                                    FROM lm_gata T4 
                                    LEFT JOIN lm_gata_kashtkar T5 ON (T5.VillageCode = T4.VillageCode AND T5.GataNo = T4.GataNo AND T5.KhataNo = T4.KhataNo) 
                                    WHERE 1 = 1 
                                    AND T4.BoardApproved = ? 
                                    AND (T4.Shreni = ? OR T4.Shreni = ?) 
                                    AND T5.owner_name LIKE ?
                                    AND T5.VillageCode = T2.VillageCode 
                                    AND T5.KhataNo = T2.KhataNo 
                                    AND T5.GataNo = T2.GataNo 
                                    GROUP BY T4.VillageCode, T4.KhataNo, T4.GataNo 
                                ) 
                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo 
                ORDER BY T4.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC";
    $block24_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $block24_count->bindValue($i++, $village_code);
    }
    $block24_count->bindValue($i++, 'YES');
    $block24_count->bindValue($i++, '1-क');
    $block24_count->bindValue($i++, '2');
    $block24_count->bindValue($i++, 'file_name');
    $block24_count->bindValue($i++, 'YES');
    $block24_count->bindValue($i++, '1-क');
    $block24_count->bindValue($i++, '2');
    $block24_count->bindValue($i++, 'बुन्देलखण्ड औद्योगिक%');
    $block24_count->execute();
} else if ($dashboard_data == '44') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T3.VillageName, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.Shreni, ROUND(SUM(T1.Area), 4) AS Area
                                FROM lm_gata T1
                                LEFT JOIN lm_gata_kashtkar T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                                LEFT JOIN lm_village T3 ON T3.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                                AND (T1.Shreni LIKE ? OR T1.Shreni LIKE ?)
                                AND T2.owner_name LIKE ?
                                GROUP BY T1.VillageCode, T2.GataNo, T2.owner_name, T2.owner_father
                                ORDER BY T3.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC";
    $block25_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $block25_count->bindValue($i++, $village_code);
    }
    $block25_count->bindValue($i++, 'YES');
    $block25_count->bindValue($i++, '5%');
    $block25_count->bindValue($i++, '6%');
    $block25_count->bindValue($i++, 'बुन्देलखण्ड औद्योगिक%');
    $block25_count->execute();
} else if ($dashboard_data == '45') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T3.VillageName, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.Shreni, ROUND(SUM(T1.Area), 4) AS Area
                                FROM lm_gata T1
                                LEFT JOIN lm_gata_kashtkar T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                                LEFT JOIN lm_village T3 ON T3.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                                AND (T1.Shreni LIKE ? OR T1.Shreni LIKE ?)
                                AND T2.owner_name LIKE ?
                                GROUP BY T1.VillageCode, T2.GataNo, T2.owner_name, T2.owner_father
                                ORDER BY T3.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC";
    $block25_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $block25_count->bindValue($i++, $village_code);
    }
    $block25_count->bindValue($i++, 'YES');
    $block25_count->bindValue($i++, '5%');
    $block25_count->bindValue($i++, '6%');
    $block25_count->bindValue($i++, 'बुन्देलखण्ड औद्योगिक%');
    $block25_count->execute();
} else if ($dashboard_data == '46') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T2.VillageName, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.Shreni, T1.Area, T1.khate_me_fasali_ke_anusar_kism
                                    FROM lm_gata T1
                                    LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Shreni = ?
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
                                    GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                                    ORDER BY T2.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC";

    $aniyamit_bainama_array = array();
    $block33_count = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $block33_count->bindValue($i++, $village_code);
    }
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
} else if ($dashboard_data == '47') {
    //$title = 'Total CH 41/45';
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

    $query = "SELECT T2.*, T3.VillageName
                                FROM lm_gata_ebasta T1
                                LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.KhataNo = T1.KhataNo AND T2.GataNo = T1.GataNo)
                                LEFT JOIN lm_village T3 ON T3.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND MATCH(T1.Ebasta2) AGAINST (?)
                AND (T2.Shreni = ? OR T2.Shreni = ?)
                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                                ORDER BY T3.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC";

    $village_query = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $village_query->bindValue($i++, $village_code);
    }
    $village_query->bindValue($i++, 'file_name');
    $village_query->bindValue($i++, '1-क');
    $village_query->bindValue($i++, '2');
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

        //echo $gataInfo['GataNo'] . ' == ' . $aniyamit_bainama.' == '.$gataInfo['khate_me_fasali_ke_anusar_kism'].' == '.str_contains($data, 'pathar') . '<br>';
        if ($aniyamit_bainama) {
            $aniyamit_bainama_array[] = $gataInfo['ID'];
        }
    }

    if (count_($aniyamit_bainama_array)) {
        $placeholders = '';
        $qPart = array_fill(0, count_($aniyamit_bainama_array), "?");
        $placeholders .= implode(",", $qPart);
        $kashtkar_ansh_query = $db->prepare("SELECT T2.VillageName, T1.*
                                            FROM lm_gata T1
                                            LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                            WHERE T1.ID IN ($placeholders)
                                            ORDER BY T2.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC
                                            ");
        $i = 1;
        foreach ($aniyamit_bainama_array as $key => $id) {
            $kashtkar_ansh_query->bindParam($i++, $aniyamit_bainama_array[$key]);
        }
        $kashtkar_ansh_query->execute();
    }
} else if ($dashboard_data == '48') {
    //$title = 'Total kashtkars whose bainama done';
    $query = "SELECT T4.VillageName, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.KashtkarAnsh, ROUND(SUM(T1.AnshRakba), 4) AS AnshRakba, T1.Ebasta1, T1.owner_name, T1.owner_father
                                        FROM lm_gata_ebasta T1
                                        LEFT JOIN lm_gata T3 ON (T3.VillageCode = T1.VillageCode AND T3.GataNo = T1.GataNo AND T3.KhataNo = T1.KhataNo)
                                        LEFT JOIN lm_village T4 ON T4.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";

    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Ebasta1 IS NOT NULL
                                        AND (T3.Shreni = ? OR T3.Shreni = ?)
                                        GROUP BY T1.VillageCode, T1.owner_name, T1.owner_father
                                        ORDER BY T4.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC";
    $khastkar_bainama_query = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $khastkar_bainama_query->bindValue($i++, $village_code);
    }
    $khastkar_bainama_query->bindValue($i++, '1-क');
    $khastkar_bainama_query->bindValue($i++, '2');
    $khastkar_bainama_query->execute();
} else if ($dashboard_data == '49') {
    //$title = 'Total kashtkars whose bainama done';
    $query = "SELECT T4.VillageName, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.KashtkarAnsh, ROUND(SUM(T1.AnshRakba), 4) AS AnshRakba, T1.Ebasta3, T1.owner_name, T1.owner_father
                                        FROM lm_gata_ebasta T1
                                        LEFT JOIN lm_gata T3 ON (T3.VillageCode = T1.VillageCode AND T3.GataNo = T1.GataNo AND T3.KhataNo = T1.KhataNo)
                                        LEFT JOIN lm_village T4 ON T4.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";

    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Ebasta3 IS NOT NULL
                                        AND (T3.Shreni = ? OR T3.Shreni = ?)
                                        GROUP BY T1.VillageCode, T1.owner_name, T1.owner_father
                                        ORDER BY T4.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC";
    $khastkar_bainama_query = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $khastkar_bainama_query->bindValue($i++, $village_code);
    }
    $khastkar_bainama_query->bindValue($i++, '1-क');
    $khastkar_bainama_query->bindValue($i++, '2');
    $khastkar_bainama_query->execute();
} else if ($dashboard_data == '50') {
    //$title = 'Total kashtkars whose bainama done';
    $query = "SELECT T4.VillageName, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.KashtkarAnsh, ROUND(SUM(T1.AnshRakba), 4) AS AnshRakba, T1.Ebasta4, T1.owner_name, T1.owner_father
                                        FROM lm_gata_ebasta T1
                                        LEFT JOIN lm_gata T3 ON (T3.VillageCode = T1.VillageCode AND T3.GataNo = T1.GataNo AND T3.KhataNo = T1.KhataNo)
                                        LEFT JOIN lm_village T4 ON T4.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";

    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Ebasta4 IS NOT NULL
                                        AND (T3.Shreni = ? OR T3.Shreni = ?)
                                        GROUP BY T1.VillageCode, T1.owner_name, T1.owner_father
                                        ORDER BY T4.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC";
    $khastkar_bainama_query = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $khastkar_bainama_query->bindValue($i++, $village_code);
    }
    $khastkar_bainama_query->bindValue($i++, '1-क');
    $khastkar_bainama_query->bindValue($i++, '2');
    $khastkar_bainama_query->execute();
} else if ($dashboard_data == '51') {
    //$title = 'Total kashtkars whose bainama done';
    $query = "SELECT T2.VillageName, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.Area, T1.owner_name, T1.owner_father, SUM(T1.MortgagedAmount) AS MortgagedAmount
                FROM lm_gata_martgaged_info T1
                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                WHERE 1 = 1
                ";

    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Mortgaged = ?
                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                ORDER BY T2.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC";
    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, '1');
    $sql->execute();
} else if ($dashboard_data == '52') {
    //$title = 'Total kashtkars whose bainama done';
    $query = "SELECT T2.VillageName, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.Area, T1.owner_name, T1.owner_father, T1.MortgagedAmount
                FROM lm_gata_martgaged_info T1
                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                WHERE 1 = 1
                ";

    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.Mortgaged = ?
                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo, T1.OwnerNo
                ORDER BY T2.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC";
    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, '1');
    $sql->execute();
} else if ($dashboard_data == '53') {
    $query = "SELECT T3.VillageName, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.KashtkarAnsh, T1.AnshRakba, T1.Ebasta1
                FROM lm_gata_ebasta T1
                LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                LEFT JOIN lm_village T3 ON T3.VillageCode = T1.VillageCode
                WHERE 1 = 1
                ";

    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND MATCH(T1.Ebasta1) AGAINST (?)
                AND (T2.Shreni = ? OR T2.Shreni = ?)
                GROUP BY T1.VillageCode, T1.Ebasta1
                ORDER BY T3.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC";
    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'file_name');
    $sql->bindValue($i++, '1-क');
    $sql->bindValue($i++, '2');
    $sql->execute();
} else if ($dashboard_data == '54') {
    $query = "SELECT T3.VillageName, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.KashtkarAnsh, T1.AnshRakba, T1.Ebasta2
                FROM lm_gata_ebasta T1
                LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                LEFT JOIN lm_village T3 ON T3.VillageCode = T1.VillageCode
                WHERE 1 = 1
                ";

    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND MATCH(T1.Ebasta2) AGAINST (?)
                AND (T2.Shreni = ? OR T2.Shreni = ?)
                GROUP BY T1.VillageCode, T1.Ebasta2
                ORDER BY T3.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC";
    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'file_name');
    $sql->bindValue($i++, '1-क');
    $sql->bindValue($i++, '2');
    $sql->execute();
} else if ($dashboard_data == '55') {
    $query = "SELECT T3.VillageName, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.KashtkarAnsh, T1.AnshRakba, T1.Ebasta3
                FROM lm_gata_ebasta T1
                LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                LEFT JOIN lm_village T3 ON T3.VillageCode = T1.VillageCode
                WHERE 1 = 1
                ";

    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND MATCH(T1.Ebasta3) AGAINST (?)
                AND (T2.Shreni = ? OR T2.Shreni = ?)
                GROUP BY T1.VillageCode, T1.Ebasta3
                ORDER BY T3.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC";
    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'file_name');
    $sql->bindValue($i++, '1-क');
    $sql->bindValue($i++, '2');
    $sql->execute();
} else if ($dashboard_data == '56') {
    $query = "SELECT T3.VillageName, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.KashtkarAnsh, T1.AnshRakba, T1.Ebasta4
                FROM lm_gata_ebasta T1
                LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                LEFT JOIN lm_village T3 ON T3.VillageCode = T1.VillageCode
                WHERE 1 = 1
                ";

    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND MATCH(T1.Ebasta4) AGAINST (?)
                AND (T2.Shreni = ? OR T2.Shreni = ?)
                GROUP BY T1.VillageCode, T1.Ebasta4
                ORDER BY T3.VillageName ASC, CAST(T1.GataNo AS FLOAT), T1.GataNo ASC";
    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'file_name');
    $sql->bindValue($i++, '1-क');
    $sql->bindValue($i++, '2');
    $sql->execute();
}