<?php

$user_type = $_SESSION['UserType'];
$report_data = $_REQUEST['report_data'];
$village_code = $_REQUEST['village_code'];
$title = $_REQUEST['title'];
$column_arr = array();
$column_head = array();

$column_arr = explode(',', $_REQUEST['column_arr']);
$column_head = explode(',', $_REQUEST['column_head']);

if ($report_data == '1') {
    //$title = 'Total Villages';
    $query = "SELECT T1.*, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                AND (CAST(T1.fasali_ke_anusar_rakba AS FLOAT) = ?
                AND T1.fasali_ke_anusar_sreni = ?)
                ORDER BY T2.VillageName ASC";

    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 0);
    $sql->bindValue($i++, '--');
    $sql->execute();
} else if ($report_data == '2') {

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

    $placeholders = '';
    $qPart = array_fill(0, count_($chakbandi_status_array), "?");
    $placeholders .= implode(",", $qPart);

    //$title = 'Total villages accquired';
    $query = "SELECT T1.*, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                AND (
                    CAST(T1.ch41_45_ke_anusar_rakba AS FLOAT) <= ?
                    OR T1.ch41_45_ke_anusar_rakba = ?
                )
                AND T1.VillageCode IN ($placeholders)
                ORDER BY T2.VillageName ASC";

    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 0);
    $sql->bindValue($i++, '--');
    foreach ($chakbandi_status_array as $key => $id) {
        $sql->bindParam($i++, $chakbandi_status_array[$key]);
    }
    $sql->execute();
} else if ($report_data == '3') {
    //$title = 'Total villages partially accquired';
    $query = "SELECT T1.*, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                AND T1.Shreni = ?
                AND (
                    MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.khate_me_fasali_ke_anusar_kism) AGAINST (? IN BOOLEAN MODE)
                )
                ORDER BY T2.VillageName ASC";

    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, '1-क');
    $sql->bindValue($i++, '+nala');
    $sql->bindValue($i++, '+nali');
    $sql->bindValue($i++, '+pathar');
    $sql->bindValue($i++, '+patthar');
    $sql->bindValue($i++, '+paatthar');
    $sql->bindValue($i++, '+paathar');
    $sql->bindValue($i++, '+pathaar');
    $sql->bindValue($i++, '+pahad');
    $sql->bindValue($i++, '+paahaad');
    $sql->bindValue($i++, '+pahaad');
    $sql->bindValue($i++, '+paahad');
    $sql->bindValue($i++, '+pukhariya');
    $sql->bindValue($i++, '+pokhar');
    $sql->bindValue($i++, '+talab');
    $sql->bindValue($i++, '+dev sthan');
    $sql->bindValue($i++, '+khaliyan');
    $sql->bindValue($i++, '+khalihan');
    $sql->bindValue($i++, '+rasta');
    $sql->bindValue($i++, '+rashta');
    $sql->bindValue($i++, '+gochar');
    $sql->bindValue($i++, '+chakroad');
    $sql->bindValue($i++, '+chakmarg');
    $sql->bindValue($i++, '+jhadi');
    $sql->bindValue($i++, '+aabadi');
    $sql->bindValue($i++, '+abadi');
    $sql->bindValue($i++, '+abaadi');
    $sql->bindValue($i++, '+nadi');
    $sql->bindValue($i++, '+nahar');
    $sql->bindValue($i++, '+tauriya');
    $sql->bindValue($i++, '+jangal');
    $sql->bindValue($i++, '+van');
    $sql->execute();
} else if ($report_data == '4') {

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

    $placeholders = '';
    $qPart = array_fill(0, count_($chakbandi_status_array), "?");
    $placeholders .= implode(",", $qPart);

    //$title = 'Total villages accquired';
    $query = "SELECT T1.*, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                AND CAST(T1.ch41_45_ke_anusar_rakba AS FLOAT) > ?
                AND T1.ch41_45_ke_anusar_sreni != T1.Shreni
                AND T1.VillageCode IN ($placeholders)
                ORDER BY T2.VillageName ASC";

    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 0);
    foreach ($chakbandi_status_array as $key => $id) {
        $sql->bindParam($i++, $chakbandi_status_array[$key]);
    }
    $sql->execute();
} else if ($report_data == '5') {
    //$title = 'Total villages accquired';
    $query = "SELECT T1.*, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                AND CAST(T1.fasali_ke_anusar_rakba AS FLOAT) != CAST(T1.Area AS FLOAT)
                AND CAST(T1.fasali_ke_anusar_rakba AS FLOAT) >  ?
                ORDER BY T2.VillageName ASC";

    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, '0');
    $sql->execute();
} else if ($report_data == '6') {
    //$title = 'Total villages accquired';

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

    $placeholders = '';
    $qPart = array_fill(0, count_($chakbandi_status_array), "?");
    $placeholders .= implode(",", $qPart);

    $query = "SELECT T1.*, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                AND CAST(T1.ch41_45_ke_anusar_rakba AS FLOAT) != CAST(T1.Area AS FLOAT)
                AND CAST(T1.ch41_45_ke_anusar_rakba AS FLOAT) > ?
                AND T1.VillageCode IN ($placeholders)
                ORDER BY T2.VillageName ASC";

    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, '0');
    foreach ($chakbandi_status_array as $key => $id) {
        $sql->bindParam($i++, $chakbandi_status_array[$key]);
    }
    $sql->execute();
} else if ($report_data == '7') {
    //$title = 'Total CH 41/45 uploaded';
    $query = "SELECT T1.*, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                AND CAST(T1.current_circle_rate AS FLOAT) = ?
                ORDER BY T2.VillageName ASC";

    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 0);
    $sql->execute();
} else if ($report_data == '8') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.*, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                AND CAST(T1.aabadi_rate AS FLOAT) = ?
                ORDER BY T2.VillageName ASC";

    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 0);
    $sql->execute();
} else if ($report_data == '9') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.*, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                AND CAST(T1.road_rate AS FLOAT) = ?
                ORDER BY T2.VillageName ASC";

    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 0);
    $sql->execute();
} else if ($report_data == '10') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.*, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                AND (
                    (
                        CAST(T1.current_circle_rate AS FLOAT) > ?
                        AND CAST(T1.aabadi_rate AS FLOAT) > ?
                    )
                    OR (
                        CAST(T1.aabadi_rate AS FLOAT) > ?
                        AND CAST(T1.road_rate AS FLOAT) > ?
                    )
                    OR (
                        CAST(T1.current_circle_rate AS FLOAT) > ?
                        AND CAST(T1.road_rate AS FLOAT) > ?
                    )
                )
                ORDER BY T2.VillageName ASC";

    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 0);
    $sql->bindValue($i++, 0);
    $sql->bindValue($i++, 0);
    $sql->bindValue($i++, 0);
    $sql->bindValue($i++, 0);
    $sql->bindValue($i++, 0);
    $sql->execute();
} else if ($report_data == '11') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.*, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                AND CAST(T1.last_year_bainama_circle_rate AS FLOAT) > (CAST(T1.land_total_amount AS FLOAT) / ?)
                ORDER BY T2.VillageName ASC";

    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 4);
    $sql->execute();
} else if ($report_data == '12') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.*, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                AND CAST(T1.last_two_year_bainama_circle_rate AS FLOAT) > (CAST(T1.land_total_amount AS FLOAT) / ?)
                ORDER BY T2.VillageName ASC";

    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 4);
    $sql->execute();
} else if ($report_data == '13') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.*, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                AND (
                    CAST(T1.land_total_amount AS FLOAT) / (? * CAST(T1.agricultural_area AS FLOAT)) > CAST(T1.current_circle_rate AS FLOAT)
                    OR CAST(T1.land_total_amount AS FLOAT) / (? * CAST(T1.agricultural_area AS FLOAT)) > CAST(T1.aabadi_rate AS FLOAT)
                    OR CAST(T1.land_total_amount AS FLOAT) / (? * CAST(T1.agricultural_area AS FLOAT)) > CAST(T1.road_rate AS FLOAT)
                )
                ORDER BY T2.VillageName ASC";

    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 4);
    $sql->bindValue($i++, 4);
    $sql->bindValue($i++, 4);
    $sql->execute();
} else if ($report_data == '14') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.*, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                AND CAST(T1.total_parisampatti_amount AS FLOAT) > (? * CAST(T1.land_total_amount AS FLOAT) / ?)
                ORDER BY T2.VillageName ASC";

    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 10);
    $sql->bindValue($i++, 100);
    $sql->execute();
} else if ($report_data == '15') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.*, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                AND CAST(T1.total_parisampatti_amount AS FLOAT) > ?
                ORDER BY T2.VillageName ASC";

    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 1000000);
    $sql->execute();
} else if ($report_data == '16') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.*, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                AND LOWER(T1.HoldByDM) = ?
                ORDER BY T2.VillageName ASC";

    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'yes');
    $sql->execute();
} else if ($report_data == '17') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.*, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                AND LOWER(T1.HoldByBIDA) = ?
                ORDER BY T2.VillageName ASC";

    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'yes');
    $sql->execute();
} else if ($report_data == '18') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.*, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                AND LOWER(T1.HoldByNirdharan) = ?
                ORDER BY T2.VillageName ASC";

    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'yes');
    $sql->execute();
} else if ($report_data == '19') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.*, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                AND LOWER(T1.BinamaHoldByBIDA) = ?
                ORDER BY T2.VillageName ASC";

    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'yes');
    $sql->execute();
} else if ($report_data == '20') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.*, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                AND T1.gata_map_not_field != ?
                AND T1.gata_map_not_field != ?
                ORDER BY T2.VillageName ASC";

    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, '--');
    $sql->bindValue($i++, '');
    $sql->execute();
} else if ($report_data == '21') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.*, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                AND T1.nahar_map_but_kastkar != ?
                AND T1.nahar_map_but_kastkar != ?
                ORDER BY T2.VillageName ASC";

    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, '--');
    $sql->bindValue($i++, '');
    $sql->execute();
} else if ($report_data == '22') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T1.*, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE 1 = 1
                                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND T1.BoardApproved = ?
                AND T1.sadak_map_but_kastkar != ?
                AND T1.sadak_map_but_kastkar != ?
                ORDER BY T2.VillageName ASC";

    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, '--');
    $sql->bindValue($i++, '');
    $sql->execute();
} else if ($report_data == '23') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T3.VillageName, T1.VillageCode, T1.Ebasta2, T1.GataNo, T1.KhataNo, T1.AnshRakba
                    FROM lm_gata_ebasta T1
                    LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                    LEFT JOIN lm_village T3 ON T3.VillageCode = T2.VillageCode
                    WHERE 1 = 1
                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND MATCH(T1.Ebasta2) AGAINST (?)
                AND (T2.Shreni = ? OR T2.Shreni = ?)
                AND T2.BoardApproved = ?
                AND CAST(T2.land_total_amount AS FLOAT) = ?
                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                ORDER BY T3.VillageName ASC";

    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'file_name');
    $sql->bindValue($i++, '1-क');
    $sql->bindValue($i++, '2');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 0);
    $sql->execute();
} else if ($report_data == '24') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T3.VillageName, T1.VillageCode, T1.Ebasta2, T1.GataNo, T1.KhataNo, T1.AnshRakba, T1.BainamaAmount, COUNT(T1.GataNo) AS TotalGata, SUM((CAST(T2.current_circle_rate AS FLOAT) * T1.AnshRakba)) AS current_circle_rate, SUM((CAST(T2.road_rate AS FLOAT) * T1.AnshRakba)) AS road_rate, SUM((CAST(T2.aabadi_rate AS FLOAT) * T1.AnshRakba)) AS aabadi_rate
                    FROM lm_gata_ebasta T1
                    LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                    LEFT JOIN lm_village T3 ON T3.VillageCode = T2.VillageCode
                    WHERE 1 = 1
                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND MATCH(T1.Ebasta2) AGAINST (?)
                AND (T2.Shreni = ? OR T2.Shreni = ?)
                AND T2.BoardApproved = ?
                GROUP BY T1.Ebasta2
                HAVING (current_circle_rate + road_rate + aabadi_rate) > BainamaAmount
                ORDER BY T3.VillageName ASC";

    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'file_name');
    $sql->bindValue($i++, '1-क');
    $sql->bindValue($i++, '2');
    $sql->bindValue($i++, 'YES');
    $sql->execute();
} else if ($report_data == '25') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T3.VillageName, T1.VillageCode, T1.Ebasta2, T1.GataNo, T1.KhataNo, T1.AnshRakba, T1.VilekhSankhya, Gatas, owner_names_count, owner_names, owner_fathers, KashtkarKaAnsh, AnshKaRakba
                    FROM lm_gata_ebasta T1
                    LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                    LEFT JOIN lm_village T3 ON T3.VillageCode = T2.VillageCode
                    LEFT JOIN (
                            SELECT T1.ID, T1.VillageCode, T1.Ebasta2, T1.GataNo, COUNT(T1.GataNo) AS TotalGata, GROUP_CONCAT(T1.GataNo) AS Gatas, COUNT(T1.owner_name) AS owner_names_count, (T1.owner_name) AS owner_names, (T1.owner_father) AS owner_fathers, GROUP_CONCAT(T1.KashtkarAnsh) AS KashtkarKaAnsh, GROUP_CONCAT(T1.AnshRakba) AS AnshKaRakba
                            FROM lm_gata_ebasta T1
                            WHERE MATCH(T1.Ebasta2) AGAINST (?)
                            ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " GROUP BY T1.VillageCode, T1.Ebasta2, T1.GataNo, T1.owner_name, T1.owner_father
                    ) AS TMP ON TMP.VillageCode = T1.VillageCode AND TMP.ID = T1.ID
                    WHERE 1 = 1";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND MATCH(T1.Ebasta2) AGAINST (?)
                AND (T2.Shreni = ? OR T2.Shreni = ?)
                AND T2.BoardApproved = ?
                GROUP BY T1.VillageCode, T1.Ebasta2, T1.GataNo
                HAVING owner_names_count > 1
                ORDER BY T3.VillageName ASC";

    $sql = $db->prepare($query);
    $i = 1;
    $sql->bindValue($i++, 'file_name');
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'file_name');
    $sql->bindValue($i++, '1-क');
    $sql->bindValue($i++, '2');
    $sql->bindValue($i++, 'YES');
    $sql->execute();
} else if ($report_data == '26') {
    //$title = 'Total CH 41/45';
    $query = "SELECT T3.VillageName, T1.VillageCode, T1.Ebasta5, T1.VilekhSankhya, T1.BainamaAmount
                    FROM lm_gata_ebasta T1
                    LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                    LEFT JOIN lm_village T3 ON T3.VillageCode = T2.VillageCode
                    WHERE 1 = 1
                    ";
    if ($village_code) {
        $query .= " AND T1.VillageCode = ?";
    }
    $query .= " AND MATCH(T1.Ebasta5) AGAINST (?)
                AND (T2.Shreni = ? OR T2.Shreni = ?)
                AND T2.BoardApproved = ?
                GROUP BY T1.Ebasta5
                ORDER BY T3.VillageName ASC";

    $sql = $db->prepare($query);
    $i = 1;
    if ($village_code) {
        $sql->bindValue($i++, $village_code);
    }
    $sql->bindValue($i++, 'file_name');
    $sql->bindValue($i++, '1-क');
    $sql->bindValue($i++, '2');
    $sql->bindValue($i++, 'YES');
    $sql->execute();
}