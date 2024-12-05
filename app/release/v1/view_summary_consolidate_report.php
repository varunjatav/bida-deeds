<?php

error_reporting(0);
$script_file_name = basename($_SERVER['SCRIPT_FILENAME']);
include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.php';
include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/vendor/autoload.php';
include_once dirname(dirname(dirname(__FILE__))) . '/apiAccess.php';
$api_validate = 1; //apiValidate($_REQUEST, $script_file_name);

if ($api_validate == 1) {
    include_once dirname(dirname(dirname(__FILE__))) . '/get_time_zone.php';
    include_once dirname(dirname(dirname(__FILE__))) . '/common_functions.php';
    include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/dbcon/db_connect.php';

    $user_id = $_REQUEST['userid'];
    $report_data = $_REQUEST['report_data'];
    $village_code = $_REQUEST['village_code'];
    $title = $_REQUEST['title'];
    $limit = $_REQUEST['pagelimit'] == '' ? 100 : $_REQUEST['pagelimit'];
    $page = $_REQUEST['page'] == '' ? 0 : $_REQUEST['page'];
    $start = (int) $limit * (int) $page;

    if ($user_id && $report_data && $title) {

        if ($report_data == '1') {
            //$title = 'Total Villages';
            $query = "SELECT SQL_CALC_FOUND_ROWS T1.*, T2.VillageName
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

            $query .= " LIMIT " . $start . ", " . $limit . "";

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

            $chakbandi_query = $db->prepare("SELECT SQL_CALC_FOUND_ROWS T1.VillageCode,
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
            $query = "SELECT SQL_CALC_FOUND_ROWS T1.*, T2.VillageName
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

            $query .= " LIMIT " . $start . ", " . $limit . "";

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
            $query = "SELECT SQL_CALC_FOUND_ROWS T1.*, T2.VillageName
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

            $query .= " LIMIT " . $start . ", " . $limit . "";

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

            $chakbandi_query = $db->prepare("SELECT SQL_CALC_FOUND_ROWS T1.VillageCode,
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
            $query = "SELECT SQL_CALC_FOUND_ROWS T1.*, T2.VillageName
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

            $query .= " LIMIT " . $start . ", " . $limit . "";

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
            $query = "SELECT SQL_CALC_FOUND_ROWS T1.*, T2.VillageName
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

            $query .= " LIMIT " . $start . ", " . $limit . "";

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

            $chakbandi_query = $db->prepare("SELECT SQL_CALC_FOUND_ROWS T1.VillageCode,
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

            $query = "SELECT SQL_CALC_FOUND_ROWS T1.*, T2.VillageName
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

            $query .= " LIMIT " . $start . ", " . $limit . "";

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
            $query = "SELECT SQL_CALC_FOUND_ROWS T1.*, T2.VillageName
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

            $query .= " LIMIT " . $start . ", " . $limit . "";

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
            $query = "SELECT SQL_CALC_FOUND_ROWS T1.*, T2.VillageName
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

            $query .= " LIMIT " . $start . ", " . $limit . "";

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
            $query = "SELECT SQL_CALC_FOUND_ROWS T1.*, T2.VillageName
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

            $query .= " LIMIT " . $start . ", " . $limit . "";

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
            $query = "SELECT SQL_CALC_FOUND_ROWS T1.*, T2.VillageName
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

            $query .= " LIMIT " . $start . ", " . $limit . "";

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
            $query = "SELECT SQL_CALC_FOUND_ROWS T1.*, T2.VillageName
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

            $query .= " LIMIT " . $start . ", " . $limit . "";

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
            $query = "SELECT SQL_CALC_FOUND_ROWS T1.*, T2.VillageName
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

            $query .= " LIMIT " . $start . ", " . $limit . "";

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
            $query = "SELECT SQL_CALC_FOUND_ROWS T1.*, T2.VillageName
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

            $query .= " LIMIT " . $start . ", " . $limit . "";

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
            $query = "SELECT SQL_CALC_FOUND_ROWS T1.*, T2.VillageName
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

            $query .= " LIMIT " . $start . ", " . $limit . "";

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
            $query = "SELECT SQL_CALC_FOUND_ROWS T1.*, T2.VillageName
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

            $query .= " LIMIT " . $start . ", " . $limit . "";

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
            $query = "SELECT SQL_CALC_FOUND_ROWS T1.*, T2.VillageName
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

            $query .= " LIMIT " . $start . ", " . $limit . "";

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
            $query = "SELECT SQL_CALC_FOUND_ROWS T1.*, T2.VillageName
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

            $query .= " LIMIT " . $start . ", " . $limit . "";

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
            $query = "SELECT SQL_CALC_FOUND_ROWS T1.*, T2.VillageName
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

            $query .= " LIMIT " . $start . ", " . $limit . "";

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
            $query = "SELECT SQL_CALC_FOUND_ROWS T1.*, T2.VillageName
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

            $query .= " LIMIT " . $start . ", " . $limit . "";

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
            $query = "SELECT SQL_CALC_FOUND_ROWS T1.*, T2.VillageName
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

            $query .= " LIMIT " . $start . ", " . $limit . "";

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
            $query = "SELECT SQL_CALC_FOUND_ROWS T1.*, T2.VillageName
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

            $query .= " LIMIT " . $start . ", " . $limit . "";

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
            $query = "SELECT SQL_CALC_FOUND_ROWS T1.*, T2.VillageName
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

            $query .= " LIMIT " . $start . ", " . $limit . "";

            $sql = $db->prepare($query);
            $i = 1;
            if ($village_code) {
                $sql->bindValue($i++, $village_code);
            }
            $sql->bindValue($i++, 'YES');
            $sql->bindValue($i++, '--');
            $sql->bindValue($i++, '');
            $sql->execute();
        }
        $rowcount = $sql->rowCount();

        if ($rowcount == 0) {
            $data = array('status' => false, 'message' => 'Data Not Found.');
        } else {
            $rs1 = $db->query('SELECT FOUND_ROWS()');
            $total_count = (int) $rs1->fetchColumn();
            $total_pages = ceil($total_count / $limit);

            $sql->setFetchMode(PDO::FETCH_ASSOC);
            if ($report_data == '1') {
                while ($row = $sql->fetch()) {
                    $villageNames[] = array("key" => $row['VillageName']);
                    $villageCode[] = array("key" => $row['VillageCode']);
                    $gataNo[] = array("key" => $row['GataNo']);
                    $khataNo[] = array("key" => $row['KhataNo']);
                    $shreni[] = array("key" => $row['Shreni']);
                    $fasaliKeAnusarSreni[] = array("key" => $row['fasali_ke_anusar_sreni']);
                    $fasaliKeAnusarRakba[] = array("key" => $row['fasali_ke_anusar_rakba']);
                }
                $report_summary[] = array("header" => "Village Name", "items" => $villageNames);
                $report_summary[] = array("header" => "Village Code", "items" => $villageCode);
                $report_summary[] = array("header" => "Gata No", "items" => $gataNo);
                $report_summary[] = array("header" => "Khata No", "items" => $khataNo);
                $report_summary[] = array("header" => "Shreni", "items" => $shreni);
                $report_summary[] = array("header" => "fasali_ke_anusar_sreni", "items" => $fasaliKeAnusarSreni);
                $report_summary[] = array("header" => "fasaliKeAnusarRakba", "items" => $fasaliKeAnusarRakba);
            } else if ($report_data == '2') {
                while ($row = $sql->fetch()) {
                    $villageNames[] = array("key" => $row['VillageName']);
                    $villageCode[] = array("key" => $row['VillageCode']);
                    $gataNo[] = array("key" => $row['GataNo']);
                    $khataNo[] = array("key" => $row['KhataNo']);
                    $shreni[] = array("key" => $row['Shreni']);
                    $ch4145keAnusarSreni[] = array("key" => $row['ch41_45_ke_anusar_sreni']);
                    $ch4145KeAnusarRakba[] = array("key" => $row['ch41_45_ke_anusar_rakba']);
                }
                $report_summary[] = array("header" => "Village Name", "items" => $villageNames);
                $report_summary[] = array("header" => "Village Code", "items" => $villageCode);
                $report_summary[] = array("header" => "Gata No", "items" => $gataNo);
                $report_summary[] = array("header" => "Khata No", "items" => $khataNo);
                $report_summary[] = array("header" => "Shreni", "items" => $shreni);
                $report_summary[] = array("header" => "ch41_45_ke_anusar_sreni", "items" => $ch4145keAnusarSreni);
                $report_summary[] = array("header" => "ch41_45_ke_anusar_rakba", "items" => $ch4145KeAnusarRakba);
            } else if ($report_data == '3') {
                while ($row = $sql->fetch()) {
                    $villageNames[] = array("key" => $row['VillageName']);
                    $villageCode[] = array("key" => $row['VillageCode']);
                    $gataNo[] = array("key" => $row['GataNo']);
                    $khataNo[] = array("key" => $row['KhataNo']);
                    $shreni[] = array("key" => $row['Shreni']);
                    $khateMeFasaliKeAnusarKism[] = array("key" => $row['khate_me_fasali_ke_anusar_kism']);
                }
                $report_summary[] = array("header" => "Village Name", "items" => $villageNames);
                $report_summary[] = array("header" => "Village Code", "items" => $villageCode);
                $report_summary[] = array("header" => "Gata No", "items" => $gataNo);
                $report_summary[] = array("header" => "Khata No", "items" => $khataNo);
                $report_summary[] = array("header" => "Shreni", "items" => $shreni);
                $report_summary[] = array("header" => "khate_me_fasali_ke_anusar_kism", "items" => $khateMeFasaliKeAnusarKism);
            } else if ($report_data == '4') {
                while ($row = $sql->fetch()) {
                    $villageNames[] = array("key" => $row['VillageName']);
                    $villageCode[] = array("key" => $row['VillageCode']);
                    $gataNo[] = array("key" => $row['GataNo']);
                    $khataNo[] = array("key" => $row['KhataNo']);
                    $shreni[] = array("key" => $row['Shreni']);
                    $ch4145keAnusarSreni[] = array("key" => $row['ch41_45_ke_anusar_sreni']);
                    $ch4145keAnusarRakba[] = array("key" => $row['ch41_45_ke_anusar_rakba']);
                }
                $report_summary[] = array("header" => "Village Name", "items" => $villageNames);
                $report_summary[] = array("header" => "Village Code", "items" => $villageCode);
                $report_summary[] = array("header" => "Gata No", "items" => $gataNo);
                $report_summary[] = array("header" => "Khata No", "items" => $khataNo);
                $report_summary[] = array("header" => "Shreni", "items" => $shreni);
                $report_summary[] = array("header" => "ch41_45_ke_anusar_sreni", "items" => $ch4145keAnusarSreni);
                $report_summary[] = array("header" => "ch41_45_ke_anusar_rakba", "items" => $ch4145keAnusarRakba);
            } else if ($report_data == '5') {
                while ($row = $sql->fetch()) {
                    $villageNames[] = array("key" => $row['VillageName']);
                    $villageCode[] = array("key" => $row['VillageCode']);
                    $gataNo[] = array("key" => $row['GataNo']);
                    $khataNo[] = array("key" => $row['KhataNo']);
                    $shreni[] = array("key" => $row['Shreni']);
                    $area[] = array("key" => $row['Area']);
                    $fasaliKeAnusarSreni[] = array("key" => $row['fasali_ke_anusar_sreni']);
                    $fasaliKeAnusarRakba[] = array("key" => $row['fasali_ke_anusar_rakba']);
                }
                $report_summary[] = array("header" => "Village Name", "items" => $villageNames);
                $report_summary[] = array("header" => "Village Code", "items" => $villageCode);
                $report_summary[] = array("header" => "Gata No", "items" => $gataNo);
                $report_summary[] = array("header" => "Khata No", "items" => $khataNo);
                $report_summary[] = array("header" => "Shreni", "items" => $shreni);
                $report_summary[] = array("header" => "Area", "items" => $area);
                $report_summary[] = array("header" => "fasali_ke_anusar_sreni", "items" => $fasaliKeAnusarSreni);
                $report_summary[] = array("header" => "fasali_ke_anusar_rakba", "items" => $fasaliKeAnusarRakba);
            } else if ($report_data == '6') {
                while ($row = $sql->fetch()) {
                    $villageNames[] = array("key" => $row['VillageName']);
                    $villageCode[] = array("key" => $row['VillageCode']);
                    $gataNo[] = array("key" => $row['GataNo']);
                    $khataNo[] = array("key" => $row['KhataNo']);
                    $shreni[] = array("key" => $row['Shreni']);
                    $area[] = array("key" => $row['Area']);
                    $ch4145keAnusarSreni[] = array("key" => $row['ch41_45_ke_anusar_sreni']);
                    $ch4145keAnusarRakba[] = array("key" => $row['ch41_45_ke_anusar_rakba']);
                }
                $report_summary[] = array("header" => "Village Name", "items" => $villageNames);
                $report_summary[] = array("header" => "Village Code", "items" => $villageCode);
                $report_summary[] = array("header" => "Gata No", "items" => $gataNo);
                $report_summary[] = array("header" => "Khata No", "items" => $khataNo);
                $report_summary[] = array("header" => "Shreni", "items" => $shreni);
                $report_summary[] = array("header" => "Area", "items" => $area);
                $report_summary[] = array("header" => "ch41_45_ke_anusar_sreni", "items" => $ch4145keAnusarSreni);
                $report_summary[] = array("header" => "ch41_45_ke_anusar_rakba", "items" => $ch4145keAnusarRakba);
            } else if ($report_data == '7') {
                while ($row = $sql->fetch()) {
                    $villageNames[] = array("key" => $row['VillageName']);
                    $villageCode[] = array("key" => $row['VillageCode']);
                    $gataNo[] = array("key" => $row['GataNo']);
                    $khataNo[] = array("key" => $row['KhataNo']);
                    $shreni[] = array("key" => $row['Shreni']);
                    $area[] = array("key" => $row['Area']);
                    $currentCircleRate[] = array("key" => $row['current_circle_rate']);
                }
                $report_summary[] = array("header" => "Village Name", "items" => $villageNames);
                $report_summary[] = array("header" => "Village Code", "items" => $villageCode);
                $report_summary[] = array("header" => "Gata No", "items" => $gataNo);
                $report_summary[] = array("header" => "Khata No", "items" => $khataNo);
                $report_summary[] = array("header" => "Shreni", "items" => $shreni);
                $report_summary[] = array("header" => "Area", "items" => $area);
                $report_summary[] = array("header" => "current_circle_rate", "items" => $currentCircleRate);
            } else if ($report_data == '8') {
                while ($row = $sql->fetch()) {
                    $villageNames[] = array("key" => $row['VillageName']);
                    $villageCode[] = array("key" => $row['VillageCode']);
                    $gataNo[] = array("key" => $row['GataNo']);
                    $khataNo[] = array("key" => $row['KhataNo']);
                    $shreni[] = array("key" => $row['Shreni']);
                    $area[] = array("key" => $row['Area']);
                    $aabadiRate[] = array("key" => $row['aabadi_rate']);
                }
                $report_summary[] = array("header" => "Village Name", "items" => $villageNames);
                $report_summary[] = array("header" => "Village Code", "items" => $villageCode);
                $report_summary[] = array("header" => "Gata No", "items" => $gataNo);
                $report_summary[] = array("header" => "Khata No", "items" => $khataNo);
                $report_summary[] = array("header" => "Shreni", "items" => $shreni);
                $report_summary[] = array("header" => "Area", "items" => $area);
                $report_summary[] = array("header" => "aabadi_rate", "items" => $aabadiRate);
            } else if ($report_data == '9') {
                while ($row = $sql->fetch()) {
                    $villageNames[] = array("key" => $row['VillageName']);
                    $villageCode[] = array("key" => $row['VillageCode']);
                    $gataNo[] = array("key" => $row['GataNo']);
                    $khataNo[] = array("key" => $row['KhataNo']);
                    $shreni[] = array("key" => $row['Shreni']);
                    $area[] = array("key" => $row['Area']);
                    $roadRate[] = array("key" => $row['road_rate']);
                }
                $report_summary[] = array("header" => "Village Name", "items" => $villageNames);
                $report_summary[] = array("header" => "Village Code", "items" => $villageCode);
                $report_summary[] = array("header" => "Gata No", "items" => $gataNo);
                $report_summary[] = array("header" => "Khata No", "items" => $khataNo);
                $report_summary[] = array("header" => "Shreni", "items" => $shreni);
                $report_summary[] = array("header" => "Area", "items" => $area);
                $report_summary[] = array("header" => "road_rate", "items" => $roadRate);
            } else if ($report_data == '10') {
                while ($row = $sql->fetch()) {
                    $villageNames[] = array("key" => $row['VillageName']);
                    $villageCode[] = array("key" => $row['VillageCode']);
                    $gataNo[] = array("key" => $row['GataNo']);
                    $khataNo[] = array("key" => $row['KhataNo']);
                    $shreni[] = array("key" => $row['Shreni']);
                    $area[] = array("key" => $row['Area']);
                    $currentCircleRate[] = array("key" => $row['current_circle_rate']);
                    $aabadiRate[] = array("key" => $row['aabadi_rate']);
                    $roadRate[] = array("key" => $row['road_rate']);
                }
                $report_summary[] = array("header" => "Village Name", "items" => $villageNames);
                $report_summary[] = array("header" => "Village Code", "items" => $villageCode);
                $report_summary[] = array("header" => "Gata No", "items" => $gataNo);
                $report_summary[] = array("header" => "Khata No", "items" => $khataNo);
                $report_summary[] = array("header" => "Shreni", "items" => $shreni);
                $report_summary[] = array("header" => "Area", "items" => $area);
                $report_summary[] = array("header" => "current_circle_rate", "items" => $currentCircleRate);
                $report_summary[] = array("header" => "aabadi_rate", "items" => $aabadiRate);
                $report_summary[] = array("header" => "road_rate", "items" => $roadRate);
            } else if ($report_data == '11') {
                while ($row = $sql->fetch()) {
                    $villageNames[] = array("key" => $row['VillageName']);
                    $villageCode[] = array("key" => $row['VillageCode']);
                    $gataNo[] = array("key" => $row['GataNo']);
                    $khataNo[] = array("key" => $row['KhataNo']);
                    $shreni[] = array("key" => $row['Shreni']);
                    $area[] = array("key" => $row['Area']);
                    $lastYearBainamaCircleRate[] = array("key" => $row['last_year_bainama_circle_rate']);
                    $landTotalAmount[] = array("key" => $row['land_total_amount']);
                }
                $report_summary[] = array("header" => "Village Name", "items" => $villageNames);
                $report_summary[] = array("header" => "Village Code", "items" => $villageCode);
                $report_summary[] = array("header" => "Gata No", "items" => $gataNo);
                $report_summary[] = array("header" => "Khata No", "items" => $khataNo);
                $report_summary[] = array("header" => "Shreni", "items" => $shreni);
                $report_summary[] = array("header" => "Area", "items" => $area);
                $report_summary[] = array("header" => "last_year_bainama_circle_rate", "items" => $lastYearBainamaCircleRate);
                $report_summary[] = array("header" => "land_total_amount", "items" => $landTotalAmount);
            } else if ($report_data == '12') {
                while ($row = $sql->fetch()) {
                    $villageNames[] = array("key" => $row['VillageName']);
                    $villageCode[] = array("key" => $row['VillageCode']);
                    $gataNo[] = array("key" => $row['GataNo']);
                    $khataNo[] = array("key" => $row['KhataNo']);
                    $shreni[] = array("key" => $row['Shreni']);
                    $area[] = array("key" => $row['Area']);
                    $lastTwoYearBainamaCircleRate[] = array("key" => $row['last_two_year_bainama_circle_rate']);
                    $landTotalAmount[] = array("key" => $row['land_total_amount']);
                }
                $report_summary[] = array("header" => "Village Name", "items" => $villageNames);
                $report_summary[] = array("header" => "Village Code", "items" => $villageCode);
                $report_summary[] = array("header" => "Gata No", "items" => $gataNo);
                $report_summary[] = array("header" => "Khata No", "items" => $khataNo);
                $report_summary[] = array("header" => "Shreni", "items" => $shreni);
                $report_summary[] = array("header" => "Area", "items" => $area);
                $report_summary[] = array("header" => "last_two_year_bainama_circle_rate", "items" => $lastTwoYearBainamaCircleRate);
                $report_summary[] = array("header" => "land_total_amount", "items" => $landTotalAmount);
            } else if ($report_data == '13') {
                while ($row = $sql->fetch()) {
                    $villageNames[] = array("key" => $row['VillageName']);
                    $villageCode[] = array("key" => $row['VillageCode']);
                    $gataNo[] = array("key" => $row['GataNo']);
                    $khataNo[] = array("key" => $row['KhataNo']);
                    $shreni[] = array("key" => $row['Shreni']);
                    $area[] = array("key" => $row['Area']);
                    $agriculturalArea[] = array("key" => $row['agricultural_area']);
                    $landTotalAmount[] = array("key" => $row['land_total_amount']);
                    $currentCircleRate[] = array("key" => $row['current_circle_rate']);
                    $aabadiRate[] = array("key" => $row['aabadi_rate']);
                    $roadRate[] = array("key" => $row['road_rate']);
                }
                $report_summary[] = array("header" => "Village Name", "items" => $villageNames);
                $report_summary[] = array("header" => "Village Code", "items" => $villageCode);
                $report_summary[] = array("header" => "Gata No", "items" => $gataNo);
                $report_summary[] = array("header" => "Khata No", "items" => $khataNo);
                $report_summary[] = array("header" => "Shreni", "items" => $shreni);
                $report_summary[] = array("header" => "Area", "items" => $area);
                $report_summary[] = array("header" => "agricultural_area", "items" => $agriculturalArea);
                $report_summary[] = array("header" => "land_total_amount", "items" => $landTotalAmount);
                $report_summary[] = array("header" => "current_circle_rate", "items" => $currentCircleRate);
                $report_summary[] = array("header" => "aabadi_rate", "items" => $aabadiRate);
                $report_summary[] = array("header" => "road_rate", "items" => $roadRate);
            } else if ($report_data == '14') {
                while ($row = $sql->fetch()) {
                    $villageNames[] = array("key" => $row['VillageName']);
                    $villageCode[] = array("key" => $row['VillageCode']);
                    $gataNo[] = array("key" => $row['GataNo']);
                    $khataNo[] = array("key" => $row['KhataNo']);
                    $shreni[] = array("key" => $row['Shreni']);
                    $area[] = array("key" => $row['Area']);
                    $totalParisampattiAmount[] = array("key" => $row['total_parisampatti_amount']);
                    $landTotalAmount[] = array("key" => $row['land_total_amount']);
                }
                $report_summary[] = array("header" => "Village Name", "items" => $villageNames);
                $report_summary[] = array("header" => "Village Code", "items" => $villageCode);
                $report_summary[] = array("header" => "Gata No", "items" => $gataNo);
                $report_summary[] = array("header" => "Khata No", "items" => $khataNo);
                $report_summary[] = array("header" => "Shreni", "items" => $shreni);
                $report_summary[] = array("header" => "Area", "items" => $area);
                $report_summary[] = array("header" => "total_parisampatti_amount", "items" => $totalParisampattiAmount);
                $report_summary[] = array("header" => "land_total_amount", "items" => $landTotalAmount);
            } else if ($report_data == '15') {
                while ($row = $sql->fetch()) {
                    $villageNames[] = array("key" => $row['VillageName']);
                    $villageCode[] = array("key" => $row['VillageCode']);
                    $gataNo[] = array("key" => $row['GataNo']);
                    $khataNo[] = array("key" => $row['KhataNo']);
                    $shreni[] = array("key" => $row['Shreni']);
                    $area[] = array("key" => $row['Area']);
                    $totalParisampattiAmount[] = array("key" => $row['total_parisampatti_amount']);
                    $landTotalAmount[] = array("key" => $row['land_total_amount']);
                }
                $report_summary[] = array("header" => "Village Name", "items" => $villageNames);
                $report_summary[] = array("header" => "Village Code", "items" => $villageCode);
                $report_summary[] = array("header" => "Gata No", "items" => $gataNo);
                $report_summary[] = array("header" => "Khata No", "items" => $khataNo);
                $report_summary[] = array("header" => "Shreni", "items" => $shreni);
                $report_summary[] = array("header" => "Area", "items" => $area);
                $report_summary[] = array("header" => "total_parisampatti_amount", "items" => $totalParisampattiAmount);
                $report_summary[] = array("header" => "land_total_amount", "items" => $landTotalAmount);
            } else if ($report_data == '16') {
                while ($row = $sql->fetch()) {
                    $villageNames[] = array("key" => $row['VillageName']);
                    $villageCode[] = array("key" => $row['VillageCode']);
                    $gataNo[] = array("key" => $row['GataNo']);
                    $khataNo[] = array("key" => $row['KhataNo']);
                    $area[] = array("key" => $row['Area']);
                    $shreni[] = array("key" => $row['Shreni']);
                }
                $report_summary[] = array("header" => "Village Name", "items" => $villageNames);
                $report_summary[] = array("header" => "Village Code", "items" => $villageCode);
                $report_summary[] = array("header" => "Gata No", "items" => $gataNo);
                $report_summary[] = array("header" => "Khata No", "items" => $khataNo);
                $report_summary[] = array("header" => "Area", "items" => $area);
                $report_summary[] = array("header" => "Shreni", "items" => $shreni);
            } else if ($report_data == '17') {
                while ($row = $sql->fetch()) {
                    $villageNames[] = array("key" => $row['VillageName']);
                    $villageCode[] = array("key" => $row['VillageCode']);
                    $gataNo[] = array("key" => $row['GataNo']);
                    $khataNo[] = array("key" => $row['KhataNo']);
                    $area[] = array("key" => $row['Area']);
                    $shreni[] = array("key" => $row['Shreni']);
                }
                $report_summary[] = array("header" => "Village Name", "items" => $villageNames);
                $report_summary[] = array("header" => "Village Code", "items" => $villageCode);
                $report_summary[] = array("header" => "Gata No", "items" => $gataNo);
                $report_summary[] = array("header" => "Khata No", "items" => $khataNo);
                $report_summary[] = array("header" => "Area", "items" => $area);
                $report_summary[] = array("header" => "Shreni", "items" => $shreni);
            } else if ($report_data == '18') {
                while ($row = $sql->fetch()) {
                    $villageNames[] = array("key" => $row['VillageName']);
                    $villageCode[] = array("key" => $row['VillageCode']);
                    $gataNo[] = array("key" => $row['GataNo']);
                    $khataNo[] = array("key" => $row['KhataNo']);
                    $area[] = array("key" => $row['Area']);
                    $shreni[] = array("key" => $row['Shreni']);
                }
                $report_summary[] = array("header" => "Village Name", "items" => $villageNames);
                $report_summary[] = array("header" => "Village Code", "items" => $villageCode);
                $report_summary[] = array("header" => "Gata No", "items" => $gataNo);
                $report_summary[] = array("header" => "Khata No", "items" => $khataNo);
                $report_summary[] = array("header" => "Area", "items" => $area);
                $report_summary[] = array("header" => "Shreni", "items" => $shreni);
            } else if ($report_data == '19') {
                while ($row = $sql->fetch()) {
                    $villageNames[] = array("key" => $row['VillageName']);
                    $villageCode[] = array("key" => $row['VillageCode']);
                    $gataNo[] = array("key" => $row['GataNo']);
                    $khataNo[] = array("key" => $row['KhataNo']);
                    $area[] = array("key" => $row['Area']);
                    $shreni[] = array("key" => $row['Shreni']);
                }
                $report_summary[] = array("header" => "Village Name", "items" => $villageNames);
                $report_summary[] = array("header" => "Village Code", "items" => $villageCode);
                $report_summary[] = array("header" => "Gata No", "items" => $gataNo);
                $report_summary[] = array("header" => "Khata No", "items" => $khataNo);
                $report_summary[] = array("header" => "Area", "items" => $area);
                $report_summary[] = array("header" => "Shreni", "items" => $shreni);
            } else if ($report_data == '20') {
                while ($row = $sql->fetch()) {
                    $villageNames[] = array("key" => $row['VillageName']);
                    $villageCode[] = array("key" => $row['VillageCode']);
                    $gataNo[] = array("key" => $row['GataNo']);
                    $khataNo[] = array("key" => $row['KhataNo']);
                    $area[] = array("key" => $row['Area']);
                    $shreni[] = array("key" => $row['Shreni']);
                    $gataMapNotField[] = array("key" => $row['gata_map_not_field']);
                }
                $report_summary[] = array("header" => "Village Name", "items" => $villageNames);
                $report_summary[] = array("header" => "Village Code", "items" => $villageCode);
                $report_summary[] = array("header" => "Gata No", "items" => $gataNo);
                $report_summary[] = array("header" => "Khata No", "items" => $khataNo);
                $report_summary[] = array("header" => "Area", "items" => $area);
                $report_summary[] = array("header" => "Shreni", "items" => $shreni);
                $report_summary[] = array("header" => "gata_map_not_field", "items" => $gataMapNotField);
            } else if ($report_data == '21') {
                while ($row = $sql->fetch()) {
                    $villageNames[] = array("key" => $row['VillageName']);
                    $villageCode[] = array("key" => $row['VillageCode']);
                    $gataNo[] = array("key" => $row['GataNo']);
                    $khataNo[] = array("key" => $row['KhataNo']);
                    $area[] = array("key" => $row['Area']);
                    $shreni[] = array("key" => $row['Shreni']);
                    $naharMapButKastkar[] = array("key" => $row['nahar_map_but_kastkar']);
                }
                $report_summary[] = array("header" => "Village Name", "items" => $villageNames);
                $report_summary[] = array("header" => "Village Code", "items" => $villageCode);
                $report_summary[] = array("header" => "Gata No", "items" => $gataNo);
                $report_summary[] = array("header" => "Khata No", "items" => $khataNo);
                $report_summary[] = array("header" => "Area", "items" => $area);
                $report_summary[] = array("header" => "Shreni", "items" => $shreni);
                $report_summary[] = array("header" => "nahar_map_but_kastkar", "items" => $naharMapButKastkar);
            } else if ($report_data == '22') {
                while ($row = $sql->fetch()) {
                    $villageNames[] = array("key" => $row['VillageName']);
                    $villageCode[] = array("key" => $row['VillageCode']);
                    $gataNo[] = array("key" => $row['GataNo']);
                    $khataNo[] = array("key" => $row['KhataNo']);
                    $area[] = array("key" => $row['Area']);
                    $shreni[] = array("key" => $row['Shreni']);
                    $sadakMapButKastkar[] = array("key" => $row['sadak_map_but_kastkar']);
                }
                $report_summary[] = array("header" => "Village Name", "items" => $villageNames);
                $report_summary[] = array("header" => "Village Code", "items" => $villageCode);
                $report_summary[] = array("header" => "Gata No", "items" => $gataNo);
                $report_summary[] = array("header" => "Khata No", "items" => $khataNo);
                $report_summary[] = array("header" => "Area", "items" => $area);
                $report_summary[] = array("header" => "Shreni", "items" => $shreni);
                $report_summary[] = array("header" => "sadak_map_but_kastkar", "items" => $sadakMapButKastkar);
            }

            //Creating JSON
            $data = array('status' => true, 'message' => 'Successfull', 'title' => $title, 'recordFound' => $total_count, 'total_pages' => $total_pages, 'reportSummary' => $report_summary);
        }
    } else {
        //Creating JSON
        $data = array('status' => false, 'message' => 'Oops.. something went wrong.');
    }
    $data = removeEmptyValues($data);
    print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
}