<?php

$column_arr = array();
$column_head = array();

$action = $_REQUEST['action'];
$exportlist = $_REQUEST['exportlist'];
$column_arr = explode(',', $_REQUEST['column_arr']);
$column_head = explode(',', $_REQUEST['column_head']);
$limit = $_POST['pagelimit'] == '' ? 100 : $_POST['pagelimit'];
$offset = $_POST['offset'] == '' ? 0 : $_POST['offset'];
$start = (int) $limit * (int) $offset;
$page = (int) $offset + 1;
$village_code = $_POST['village_code'];
$report_type = $_POST['report_type'];

$query = "";
$query .= "SELECT SQL_CALC_FOUND_ROWS T1.*
            FROM lm_gata T1
            WHERE T1.VillageCode = ?";

if ($report_type == '1') {
    $query .= " AND T1.Shreni = ?
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
                )";
}
//if ($report_type == '2') {
//    $query .= " AND T1.Shreni = ?
//                AND fasali_me_kastkar_darj_status = ?";
//}
if ($report_type == '3') {
    $query .= " AND T1.Shreni = ?
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
                )";
}
if ($report_type == '4') {
    $query .= " AND CAST(T1.Area AS FLOAT) < CAST(T1.fasali_ke_anusar_rakba AS FLOAT)
                AND T1.fasali_ke_anusar_rakba > ?
                AND T1.BoardApproved = ?";
}
if ($report_type == '5') {
    $query .= " AND CAST(T1.Area AS FLOAT) > CAST(T1.fasali_ke_anusar_rakba AS FLOAT)
                AND T1.fasali_ke_anusar_rakba > ?
                AND T1.BoardApproved = ?";
}
if ($report_type == '6') {
    $query .= " AND CAST(T1.RequiredArea AS FLOAT) > CAST(T1.Area AS FLOAT)
                AND CAST(T1.RequiredArea AS FLOAT) > ?
                AND T1.BoardApproved = ?";
}
if ($report_type == '7') {
    $query .= " AND CAST(T1.RequiredArea AS FLOAT) < CAST(T1.Area AS FLOAT)
                AND CAST(T1.RequiredArea AS FLOAT) > ?
                AND T1.BoardApproved = ?";
}
if ($report_type == '8') {
    $query .= " AND MATCH(T1.adhisuchana_ke_anusar_mauke_ki_stithi) AGAINST (? IN BOOLEAN MODE)
                AND MATCH(T1.adhisuchana_ke_anusar_mauke_ki_stithi) AGAINST (? IN BOOLEAN MODE)
                AND T1.BoardApproved = ?";
}
if ($report_type == '9') {
    $query .= " AND (MATCH(T1.adhisuchana_ke_anusar_mauke_ki_stithi) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.adhisuchana_ke_anusar_mauke_ki_stithi) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.adhisuchana_ke_anusar_mauke_ki_stithi) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.adhisuchana_ke_anusar_mauke_ki_stithi) AGAINST (? IN BOOLEAN MODE)
                    )
                AND CAST(T1.current_circle_rate AS FLOAT) = ?
                AND T1.BoardApproved = ?";
}
if ($report_type == '10') {
    $query .= " AND (MATCH(T1.adhisuchana_ke_anusar_mauke_ki_stithi) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.adhisuchana_ke_anusar_mauke_ki_stithi) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.adhisuchana_ke_anusar_mauke_ki_stithi) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.adhisuchana_ke_anusar_mauke_ki_stithi) AGAINST (? IN BOOLEAN MODE)
                    OR MATCH(T1.adhisuchana_ke_anusar_mauke_ki_stithi) AGAINST (? IN BOOLEAN MODE)
                    )
                AND T1.aabadi_amount > ?
                AND T1.BoardApproved = ?";
}
if ($report_type == '11') {
    $query .= " AND CAST(T1.current_circle_rate AS FLOAT) > ?
                AND T1.BoardApproved = ?";
}
if ($report_type == '12') {
    $query .= " AND T1.aabadi_rate > ?
                AND T1.BoardApproved = ?";
}
if ($report_type == '13') {
    $query .= " AND T1.road_rate > ?
                AND T1.BoardApproved = ?";
}
if ($report_type == '14') {
    $query .= " AND ((CAST(T1.current_circle_rate AS FLOAT) > ? AND T1.aabadi_rate > ?)
                    OR (CAST(T1.current_circle_rate AS FLOAT) > ? AND T1.road_rate > ?)
                    OR (T1.aabadi_rate > ? AND T1.road_rate > ?))
                AND T1.BoardApproved = ?
                    ";
}
if ($report_type == '15') {
    $query .= " AND CAST(T1.current_circle_rate AS FLOAT) < CAST(T1.vartaman_circle_rate AS FLOAT)
                AND CAST(T1.current_circle_rate AS FLOAT) > ?
                AND T1.BoardApproved = ?";
}
if ($report_type == '16') {
    $query .= " AND CAST(T1.current_circle_rate AS FLOAT) > CAST(T1.vartaman_circle_rate AS FLOAT)
                AND CAST(T1.current_circle_rate AS FLOAT) > ?
                AND T1.BoardApproved = ?";
}
if ($report_type == '17') {
    $query .= " AND ((CAST(T1.land_total_amount / (4 * T1.agricultural_area) AS FLOAT) > CAST(T1.current_circle_rate AS FLOAT) AND T1.current_circle_rate > 0)
                    OR (CAST(T1.land_total_amount / (4 * T1.agricultural_area) AS FLOAT) > CAST(T1.road_rate AS FLOAT) AND T1.road_rate > 0)
                    OR (CAST(T1.land_total_amount / (4 * T1.agricultural_area) AS FLOAT) > CAST(T1.aabadi_rate AS FLOAT) AND T1.aabadi_rate > 0)
                    )
                 AND T1.BoardApproved = ?
                 ";
}
if ($report_type == '18') {
    $query .= " AND T1.vrihad_pariyojna = ?
                AND T1.BoardApproved = ?";
}
if ($report_type == '19') {
    $query .= " AND T1.dispute_status = ?
                AND T1.BoardApproved = ?";
}
if ($report_type == '20') {
    $query .= " AND T1.sc_st_kashtkar = ?
                AND T1.BoardApproved = ?";
}
if ($report_type == '21') {
    $query .= " AND T1.dhara_98 = ?
                AND T1.BoardApproved = ?";
}
if ($report_type == '22') {
    $query .= " AND T1.dhara_80_143 = ?
                AND T1.BoardApproved = ?";
}
if ($report_type == '23') {
    $query .= " AND T1.nahar_map_but_kastkar = ?
                AND T1.BoardApproved = ?";
}
if ($report_type == '24') {
    $query .= " AND T1.sadak_map_but_kastkar = ?
                AND T1.BoardApproved = ?";
}
if ($report_type == '25') {
    $query .= " AND (T1.HoldByDM = ?
                    OR T1.HoldByBIDA = ?
                    OR T1.HoldByNirdharan = ?
                    OR T1.BinamaHoldByBIDA = ?
                    )
                AND T1.BoardApproved = ?
                ";
}
if ($report_type == '26') {
    $query .= " AND CAST(T1.Area AS FLOAT) < CAST(T1.ch41_45_ke_anusar_rakba AS FLOAT)
                AND CAST(T1.ch41_45_ke_anusar_rakba AS FLOAT) > ?
                AND T1.BoardApproved = ?";
}
if ($report_type == '27') {
    $query .= " AND CAST(T1.Area AS FLOAT) > CAST(T1.ch41_45_ke_anusar_rakba AS FLOAT)
                AND CAST(T1.ch41_45_ke_anusar_rakba AS FLOAT) > ?
                AND T1.BoardApproved = ?";
}
//if ($report_type == '28') {
//    $query .= " AND T1.fasali_ke_anusar_rakba < CAST(T1.ch41_45_ke_anusar_rakba AS FLOAT)
//                AND T1.fasali_ke_anusar_rakba > ?
//                AND CAST(T1.ch41_45_ke_anusar_rakba AS FLOAT) > ?
//                AND T1.BoardApproved = ?";
//}
if ($report_type == '29') {
    $query .= " AND T1.total_parisampatti_amount > ?
                AND T1.total_parisampatti_amount > (10 * T1.land_total_amount / 100)
                AND T1.BoardApproved = ?";
}
if ($report_type == '30') {
    $query .= " AND T1.total_parisampatti_amount > ?
                AND T1.total_parisampatti_amount > 1000000
                AND T1.BoardApproved = ?";
}
if ($report_type == '31') {

    $query .= " AND";

    $query .= " (T1.Shreni = ?
                AND (
                MATCH(T1.khate_me_fasali_ke_anusar_kism ) AGAINST (? IN BOOLEAN MODE)
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
                ))";

    $query .= "AND";

    $query .= " (CAST(T1.Area AS FLOAT) < CAST(T1.fasali_ke_anusar_rakba AS Float)
                AND CAST(T1.fasali_ke_anusar_rakba AS Float) > ?
                AND T1.BoardApproved = ?)";

    $query .= "AND";

    $query .= " (CAST(T1.Area AS FLOAT) > CAST(T1.fasali_ke_anusar_rakba AS Float)
                AND CAST(T1.fasali_ke_anusar_rakba AS Float) > ?
                AND T1.BoardApproved = ?)";

    $query .= "AND";

    $query .= " (CAST(T1.RequiredArea AS FLOAT) < CAST(T1.Area AS FLOAT)
                AND CAST(T1.RequiredArea AS FLOAT) > ?
                AND T1.BoardApproved = ?)";

    $query .= "AND";

    $query .= " (CAST(T1.RequiredArea AS FLOAT) > CAST(T1.Area AS FLOAT)
                AND CAST(T1.RequiredArea AS FLOAT) > ?
                AND T1.BoardApproved = ?)";

    $query .= "AND";

    $query .= " (MATCH(T1.adhisuchana_ke_anusar_mauke_ki_stithi) AGAINST (? IN BOOLEAN MODE)
                AND T1.aabadi_amount = ?
                AND T1.BoardApproved = ?)";

    $query .= "AND";

    $query .= " (MATCH(T1.adhisuchana_ke_anusar_mauke_ki_stithi) AGAINST (? IN BOOLEAN MODE)
                AND T1.aabadi_amount > ?
                AND T1.BoardApproved = ?)";

    $query .= "AND";

    $query .= " (CAST(T1.current_circle_rate AS FLOAT) > CAST(T1.vartaman_circle_rate AS FLOAT)
                AND CAST(T1.current_circle_rate AS FLOAT) > ?
                AND T1.BoardApproved = ?)";

    $query .= "AND";

    $query .= " (CAST(T1.current_circle_rate AS FLOAT) < CAST(T1.vartaman_circle_rate AS FLOAT)
                AND CAST(T1.current_circle_rate AS FLOAT) > ?
                AND T1.BoardApproved = ?)";

    $query .= "AND";

    $query .= " ((T1.land_total_amount / (4 * T1.agricultural_area) < CAST(T1.current_circle_rate AS FLOAT)
                    OR T1.land_total_amount / (4 * T1.agricultural_area) < T1.road_rate
                    OR T1.land_total_amount / (4 * T1.agricultural_area) < T1.aabadi_rate
                    )
                AND T1.BoardApproved = ?
                )";

    $query .= "AND";

    $query .= " (T1.vrihad_pariyojna != ? AND T1.BoardApproved = ?)";

    $query .= "AND";

    $query .= " (T1.dispute_status != ? AND T1.BoardApproved = ?)";

    $query .= "AND";

    $query .= " (T1.sc_st_kashtkar != ? AND T1.BoardApproved = ?)";

    $query .= "AND";

    $query .= " (T1.dhara_98 != ? AND T1.BoardApproved = ?)";

    $query .= "AND";

    $query .= " (T1.dhara_80_143 != ? AND T1.BoardApproved = ?)";

    $query .= "AND";

    $query .= " (T1.nahar_map_but_kastkar != ? AND T1.BoardApproved = ?)";

    $query .= "AND";

    $query .= " (T1.sadak_map_but_kastkar != ? AND T1.BoardApproved = ?)";

    $query .= "AND";

    $query .= " ((T1.HoldByDM != ?
                    OR T1.HoldByBIDA != ?
                    OR T1.HoldByNirdharan != ?
                    OR T1.BinamaHoldByBIDA != ?
                    )
                AND T1.BoardApproved = ?
                )";

    $query .= "AND";

    $query .= " (CAST(T1.Area AS FLOAT) > CAST(T1.ch41_45_ke_anusar_rakba AS FLOAT)
                AND CAST(T1.ch41_45_ke_anusar_rakba AS FLOAT) > ?
                AND T1.BoardApproved = ?)";

    $query .= "AND";

    $query .= " (CAST(T1.Area AS FLOAT) < CAST(T1.ch41_45_ke_anusar_rakba AS FLOAT)
                AND CAST(T1.ch41_45_ke_anusar_rakba AS FLOAT) > ?
                AND T1.BoardApproved = ?)";

    $query .= "AND";

    $query .= " (T1.total_parisampatti_amount > ?
                AND T1.total_parisampatti_amount < (10 * T1.land_total_amount / 100)
                AND T1.BoardApproved = ?)";

    $query .= "AND";

    $query .= " (T1.total_parisampatti_amount > ?
                AND T1.total_parisampatti_amount < 1000000
                AND T1.BoardApproved = ?)";
}
$query .= " ORDER BY T1.ID DESC";

if ($exportlist != 'export') {
    $query .= " LIMIT " . $start . ", " . $limit . "";
}

$sql = $db->prepare($query);

$i = 1;
$sql->bindParam($i++, $village_code);
if ($report_type == '1') {
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
}
if ($report_type == '2') {
    $sql->bindValue($i++, '1-क');
    $sql->bindValue($i++, 'NO');
}
if ($report_type == '3') {
    $sql->bindValue($i++, '1-क');
    $sql->bindValue($i++, '+banzar');
    $sql->bindValue($i++, '+banjar');
    $sql->bindValue($i++, '+jadid');
    $sql->bindValue($i++, '+parti');
    $sql->bindValue($i++, '+patthar');
    $sql->bindValue($i++, '+pathaar');
    $sql->bindValue($i++, '+patthaar');
    $sql->bindValue($i++, '+patthar');
    $sql->bindValue($i++, '+patthaar');
}
if ($report_type == '4') {
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
}
if ($report_type == '5') {
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
}
if ($report_type == '6') {
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
}
if ($report_type == '7') {
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
}
if ($report_type == '8') {
    $sql->bindValue($i++, '+कृषि/खेती');
    $sql->bindValue($i++, '');
    $sql->bindValue($i++, 'YES');
}
if ($report_type == '9') {
    $sql->bindValue($i++, '+आबादी');
    $sql->bindValue($i++, '+abadi');
    $sql->bindValue($i++, '+abaadi');
    $sql->bindValue($i++, '+aabadi');
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
}
if ($report_type == '10') {
    $sql->bindValue($i++, '+कृषि/खेती');
    $sql->bindValue($i++, '+krashi');
    $sql->bindValue($i++, '+krishi');
    $sql->bindValue($i++, '+KRSHI');
    $sql->bindValue($i++, '+kheti');
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
}
if ($report_type == '11') {
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
}
if ($report_type == '12') {
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
}
if ($report_type == '13') {
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
}
if ($report_type == '14') {
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
}
if ($report_type == '15') {
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
}
if ($report_type == '16') {
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
}
if ($report_type == '17') {
    $sql->bindValue($i++, 'YES');
}
if ($report_type == '18') {
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
}
if ($report_type == '19') {
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
}
if ($report_type == '20') {
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
}
if ($report_type == '21') {
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
}
if ($report_type == '22') {
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
}
if ($report_type == '23') {
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
}
if ($report_type == '24') {
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
}
if ($report_type == '25') {
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
}
if ($report_type == '26') {
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
}
if ($report_type == '27') {
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
}
if ($report_type == '28') {
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
}
if ($report_type == '29') {
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
}
if ($report_type == '30') {
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
}
if ($report_type == '31') {
    $sql->bindValue($i++, '1-क');
    $sql->bindValue($i++, '-nala');
    $sql->bindValue($i++, '-nali');
    $sql->bindValue($i++, '-pathar');
    $sql->bindValue($i++, '-patthar');
    $sql->bindValue($i++, '-paatthar');
    $sql->bindValue($i++, '-paathar');
    $sql->bindValue($i++, '-pathaar');
    $sql->bindValue($i++, '-pahad');
    $sql->bindValue($i++, '-paahaad');
    $sql->bindValue($i++, '-pahaad');
    $sql->bindValue($i++, '-paahad');
    $sql->bindValue($i++, '-pukhariya');
    $sql->bindValue($i++, '-pokhar');
    $sql->bindValue($i++, '-talab');
    $sql->bindValue($i++, '-dev sthan');
    $sql->bindValue($i++, '-khaliyan');
    $sql->bindValue($i++, '-khalihan');
    $sql->bindValue($i++, '-rasta');
    $sql->bindValue($i++, '-rashta');
    $sql->bindValue($i++, '-gochar');
    $sql->bindValue($i++, '-chakroad');
    $sql->bindValue($i++, '-chakmarg');
    $sql->bindValue($i++, '-jhadi');
    $sql->bindValue($i++, '-aabadi');
    $sql->bindValue($i++, '-abadi');
    $sql->bindValue($i++, '-abaadi');
    $sql->bindValue($i++, '-nadi');
    $sql->bindValue($i++, '-nahar');
    $sql->bindValue($i++, '-tauriya');
    $sql->bindValue($i++, '-jangal');
    $sql->bindValue($i++, '-van');
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, '-आबादी');
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, '-कृषि/खेती');
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
    $sql->bindValue($i++, '0');
    $sql->bindValue($i++, 'YES');
}

$sql->execute();
$rs1 = $db->query('SELECT FOUND_ROWS()');
$total_count = (int) $rs1->fetchColumn();
$sql->setFetchMode(PDO::FETCH_ASSOC);

if ($exportlist != 'export') {
    // start pagination
    $total_pages = ceil($total_count / $limit);

    if ($total_pages > 1) {
        if ($page == 1) {
            $output = $output . '<a class="page_disabled"><img src="img/first.svg"page_disabled width="14px">'
                    . '<a class="page_disabled"><img src="img/previous.svg"page_disabled width="14px"></a></a>';
        } else {
            $output = $output . '<a style="cursor:pointer;" class="paginate first"><img src="img/first.svg" width="14px"></a>'
                    . '<a style="cursor:pointer;" class="paginate_prev"><img src="img/previous.svg" width="14px"></a>';
        }

        if (($page - 3) > 0) {
            if ($page == 1) {
                $output = $output . '<span id=1 class="paginate current">1</span>';
            } else {
                $output = $output . '<a style="cursor:pointer;" class="paginate">1</a>';
            }
        }
        if (($page - 3) > 1) {
            $output = $output . '<span class="dot">...</span>';
        }

        for ($i = ($page - 2); $i <= ($page + 2); $i++) {
            if ($i < 1) continue;
            if ($i > $total_pages) break;
            if ($page == $i) {
                $output = $output . '<span id=' . $i . ' class="paginate current">' . $i . '</span>';
            } else {
                $output = $output . '<a style="cursor:pointer;" class="paginate">' . $i . '</a>';
            }
        }

        if (($total_pages - ($page + 2)) > 1) {
            $output = $output . '<span class="dot">...</span>';
        }
        if (($total_pages - ($page + 2)) > 0) {
            if ($page == $total_pages) {
                $output = $output . '<span id=' . ($total_pages) . ' class="paginate current">' . ($total_pages) . '</span>';
            } else {
                $output = $output . '<a style="cursor:pointer;" class="paginate">' . ($total_pages) . '</a>';
            }
        }

        if ($page < $total_pages) {
            $output = $output . '<a style="cursor:pointer;" class="paginate_next"><img src="img/next2.svg" width="14px"></a>'
                    . '<a style="cursor:pointer;" class="paginate_last"><img src="img/last.svg" width="14px"></a>';
        } else {
            $output = $output . '<a class="page_disabled"><img src="img/next2.svg" width="14px"></a>'
                    . '<a class="page_disabled"><img src="img/last.svg" width="14px"></a>';
        }
    }
}

