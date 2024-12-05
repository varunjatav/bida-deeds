<?php

$column_arr = array();
$column_head = array();
$point_1 = array();
$point_2 = array();
$point_3 = array();
$point_4 = array();
$point_5 = array();
$point_6 = array();
$point_7 = array();
$point_8 = array();
$point_9 = array();
$point_10 = array();
$point_11 = array();
$point_12 = array();
$point_13 = array();
$point_14 = array();
$point_15 = array();
$point_16 = array();
$point_17 = array();
$point_18 = array();
$point_19 = array();
$point_20 = array();
$point_21 = array();
$point_22 = array();
$point_23 = array();
$point_24 = array();
$point_25 = array();
$point_26 = array();
$user_type = $_SESSION['UserType'];
$column_arr = explode(',', $_REQUEST['column_arr']);
$column_head = explode(',', $_REQUEST['column_head']);

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

$sql = $db->prepare("SELECT T1.VillageName, T1.VillageCode
                                FROM lm_village T1
                                WHERE T1.Active = ?
                                ");
$sql->bindValue(1, 1);
$sql->execute();
$villageInfo = $sql->fetchAll();

foreach ($villageInfo as $vKey => $vValue) {
    $answer_1 = 0;
    $answer_2 = 0;
    $answer_6 = 0;
    $answer_7 = 0;
    $answer_8 = 0;
    $answer_9 = 0;
    $answer_10 = 0;
    $answer_11 = 0;
    $answer_12 = 0;
    $answer_13 = 0;
    $answer_14 = 0;
    $answer_15 = 0;
    $answer_16 = 0;
    $answer_17 = 0;
    $answer_18 = 0;
    $answer_19 = 0;
    $answer_20 = 0;
    $answer_21 = 0;
    $answer_22 = 0;
    $answer_23 = 0;
    $answer_24 = 0;
    $answer_25 = 0;
    $answer_26 = 0;
    $answer_27 = 0;
    $answer_15_count = 0;

    $village_query = $db->prepare("SELECT T1.*
                                    FROM lm_gata T1
                                    WHERE T1.BoardApproved = ?
                                    AND T1.VillageCode = ?
                                    ");
    $village_query->bindValue(1, 'YES');
    $village_query->bindParam(2, $vValue['VillageCode']);
    $village_query->execute();
    $village_query->setFetchMode(PDO::FETCH_ASSOC);

    while ($gataInfo = $village_query->fetch()) {
        if ($gataInfo['fasali_ke_anusar_sreni'] != '--' || $gataInfo['fasali_ke_anusar_rakba'] > 0) {

        } else {
            $answer_1++;
        }

        /*         * ********* */
        if (in_array($vValue['VillageCode'], $chakbandi_status_array)) {
            if ((float) $gataInfo['ch41_45_ke_anusar_rakba']) {

            } else {
                $answer_2++;
            }
        }

        /*         * ********* */
        if ($gataInfo['Shreni'] == '1-क' && $gataInfo['khate_me_fasali_ke_anusar_kism'] != '--') {
            //$var = array_keys(explode('(', $gataInfo['khate_me_fasali_ke_anusar_kism']));
            $data = strtolower($gataInfo['khate_me_fasali_ke_anusar_kism']);
            if (str_contains($data, 'nala') || str_contains($data, 'nali') || str_contains($data, 'pathar') || str_contains($data, 'patthar') || str_contains($data, 'paatthar') || str_contains($data, 'paathar') || str_contains($data, 'pathaar') || str_contains($data, 'pahad') || str_contains($data, 'paahaad') || str_contains($data, 'pahaad') || str_contains($data, 'paahad') || str_contains($data, 'pukhariya') || str_contains($data, 'pokhar') || str_contains($data, 'talab') || str_contains($data, 'dev sthan') || str_contains($data, 'khaliyan') || str_contains($data, 'khalihan') || str_contains($data, 'rasta') || str_contains($data, 'rashta') || str_contains($data, 'gochar') || str_contains($data, 'chakroad') || str_contains($data, 'chakmarg') || str_contains($data, 'jhadi') || str_contains($data, 'aabadi') || str_contains($data, 'abadi') || str_contains($data, 'abaadi') || str_contains($data, 'nadi') || str_contains($data, 'nahar') || str_contains($data, 'tauriya') || str_contains($data, 'jangal') || str_contains($data, 'van')) {
                $answer_6++;
            } else {

            }
        } else {

        }

        /*         * ********* */
        if (in_array($gataInfo['VillageCode'], $chakbandi_status_array)) {
            if ($gataInfo['ch41_45_ke_anusar_sreni'] != '--') {
                if (substr($gataInfo['ch41_45_ke_anusar_sreni'], 0, 1) == substr($gataInfo['Shreni'], 0, 1)) {

                } else {
                    $answer_7++;
                }
            } else {

            }
        }

        /*         * ********* */
        if ((float) $gataInfo['fasali_ke_anusar_rakba']) {
            if ((float) $gataInfo['Area'] == (float) $gataInfo['fasali_ke_anusar_rakba']) {

            } else {
                $answer_8++;
            }
        }

        /*         * ********* */
        if (in_array($gataInfo['VillageCode'], $chakbandi_status_array)) {
            if ((float) $gataInfo['ch41_45_ke_anusar_rakba']) {
                if ((float) $gataInfo['Area'] == (float) $gataInfo['ch41_45_ke_anusar_rakba']) {

                } else {
                    $answer_10++;
                }
            }
        }

        /*         * ********* */
        if ((float) $gataInfo['current_circle_rate'] > 0) {
            $answer_15_count++;
        } else {
            $answer_12++;
        }

        /*         * ********* */
        if ((float) $gataInfo['aabadi_rate'] > 0) {
            $answer_15_count++;
        } else {
            $answer_13++;
        }

        /*         * ********* */
        if ((float) $gataInfo['road_rate'] > 0) {
            $answer_15_count++;
        } else {
            $answer_14++;
        }

        /*         * ********* */
        if (((float) $gataInfo['current_circle_rate'] > 0 && (float) $gataInfo['aabadi_rate'] > 0) || ((float) $gataInfo['aabadi_rate'] > 0 && (float) $gataInfo['road_rate'] > 0) || ((float) $gataInfo['current_circle_rate'] > 0 && (float) $gataInfo['road_rate'] > 0)) {
            $answer_15++;
        } else {

        }

        /*         * ********* */
        if ((float) $gataInfo['land_total_amount']) {
            if ((float) $gataInfo['last_year_bainama_circle_rate'] > ((float) $gataInfo['land_total_amount'] / 4)) {
                $answer_16++;
            } else {

            }
        } else {

        }

        /*         * ********* */
        if ((float) $gataInfo['land_total_amount']) {
            if ((float) $gataInfo['last_two_year_bainama_circle_rate'] > ((float) $gataInfo['land_total_amount'] / 4)) {
                $answer_17++;
            } else {

            }
        } else {

        }

        /*         * ********* */
        if ((float) $gataInfo['land_total_amount']) {
            $data = (float) $gataInfo['agricultural_area'] ? ((float) $gataInfo['land_total_amount'] / (4 * (float) $gataInfo['agricultural_area'])) : 0;
            if (((float) $gataInfo['current_circle_rate'] > 0 && $data > (float) $gataInfo['current_circle_rate']) || ((float) $gataInfo['road_rate'] > 0 && $data > (float) $gataInfo['road_rate']) || ((float) $gataInfo['aabadi_rate'] > 0 && $data > (float) $gataInfo['aabadi_rate'])) {
                $answer_18++;
            } else {

            }
        } else {

        }

        /*         * ********* */
        if ((float) $gataInfo['total_parisampatti_amount']) {
            $data = (10 * (float) $gataInfo['land_total_amount'] / 100);
            if ((float) $gataInfo['total_parisampatti_amount'] > $data) {
                $answer_19++;
            } else {

            }
        } else {

        }

        /*         * ********* */
        if ((float) $gataInfo['total_parisampatti_amount']) {
            if ((float) $gataInfo['total_parisampatti_amount'] > 1000000) {
                $answer_20++;
            } else {

            }
        } else {

        }

        /*         * ********* */
        if (strtolower($gataInfo['HoldByDM']) == 'yes') {
            $answer_21++;
        } else {

        }

        /*         * ********* */
        if (strtolower($gataInfo['HoldByBIDA']) == 'yes') {
            $answer_22++;
        } else {

        }

        /*         * ********* */
        if (strtolower($gataInfo['HoldByNirdharan']) == 'yes') {
            $answer_23++;
        } else {

        }

        /*         * ********* */
        if (strtolower($gataInfo['BinamaHoldByBIDA']) == 'yes') {
            $answer_24++;
        } else {

        }

        /*         * ********* */
        if ($gataInfo['gata_map_not_field'] && $gataInfo['gata_map_not_field'] != '--') {
            $answer_25++;
        } else {

        }

        /*         * ********* */
        if ($gataInfo['nahar_map_but_kastkar'] && $gataInfo['nahar_map_but_kastkar'] != '--') {
            $answer_26++;
        } else {

        }

        /*         * ********* */
        if ($gataInfo['sadak_map_but_kastkar'] && $gataInfo['sadak_map_but_kastkar'] != '--') {
            $answer_27++;
        } else {

        }
    }
    if ($answer_2 == 0) {
        $answer_2 = 'इस ग्राम में चकबंदी नहीं हुई है';
    }
    if ($answer_7 == 0) {
        $answer_7 = 'इस ग्राम में चकबंदी नहीं हुई है';
    }
    if ($answer_10 == 0) {
        $answer_10 = 'इस ग्राम में चकबंदी नहीं हुई है';
    }
    $point_1[$vValue['VillageCode']] = $answer_1;
    $point_2[$vValue['VillageCode']] = $answer_2;
    $point_3[$vValue['VillageCode']] = $answer_6;
    $point_4[$vValue['VillageCode']] = $answer_7;
    $point_5[$vValue['VillageCode']] = $answer_8;
    $point_6[$vValue['VillageCode']] = $answer_10;
    $point_7[$vValue['VillageCode']] = $answer_12;
    $point_8[$vValue['VillageCode']] = $answer_13;
    $point_9[$vValue['VillageCode']] = $answer_14;
    $point_10[$vValue['VillageCode']] = $answer_15;
    $point_11[$vValue['VillageCode']] = $answer_16;
    $point_12[$vValue['VillageCode']] = $answer_17;
    $point_13[$vValue['VillageCode']] = $answer_18;
    $point_14[$vValue['VillageCode']] = $answer_19;
    $point_15[$vValue['VillageCode']] = $answer_20;
    $point_16[$vValue['VillageCode']] = $answer_21;
    $point_17[$vValue['VillageCode']] = $answer_22;
    $point_18[$vValue['VillageCode']] = $answer_23;
    $point_19[$vValue['VillageCode']] = $answer_24;
    $point_20[$vValue['VillageCode']] = $answer_25;
    $point_21[$vValue['VillageCode']] = $answer_26;
    $point_22[$vValue['VillageCode']] = $answer_27;

//    $point_24[$vValue['VillageCode']] = $answer_29;
//    $point_25[$vValue['VillageCode']] = $answer_30;
//    $point_26[$vValue['VillageCode']] = $answer_31;
}

$sql = $db->prepare("SELECT T1.VillageCode
                    FROM lm_gata_ebasta T1
                    LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                    WHERE MATCH(T1.Ebasta2) AGAINST (?)
                    AND (T2.Shreni = ? OR T2.Shreni = ?)
                    AND T2.BoardApproved = ?
                    AND CAST(T2.land_total_amount AS FLOAT) = ?
                    GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                    ");
$sql->bindValue(1, 'file_name');
$sql->bindValue(2, '1-क');
$sql->bindValue(3, '2');
$sql->bindValue(4, 'YES');
$sql->bindValue(5, 0);
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
$answer_28 = $sql->fetchAll();
$point_23 = array_count_values(array_column($answer_28, 'VillageCode'));

$sql = $db->prepare("SELECT T1.VillageCode, T1.BainamaAmount, COUNT(T1.GataNo) AS TotalGata, SUM((CAST(T2.current_circle_rate AS FLOAT) * T1.AnshRakba)) AS current_circle_rate, SUM((CAST(T2.road_rate AS FLOAT) * T1.AnshRakba)) AS road_rate, SUM((CAST(T2.aabadi_rate AS FLOAT) * T1.AnshRakba)) AS aabadi_rate
                    FROM lm_gata_ebasta T1
                    LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                    WHERE MATCH(T1.Ebasta2) AGAINST (?)
                    AND (T2.Shreni = ? OR T2.Shreni = ?)
                    AND T2.BoardApproved = ?
                    GROUP BY T1.Ebasta2
                    HAVING (current_circle_rate + road_rate + aabadi_rate) > BainamaAmount
                    ");
$sql->bindValue(1, 'file_name');
$sql->bindValue(2, '1-क');
$sql->bindValue(3, '2');
$sql->bindValue(4, 'YES');
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
$answer_29 = $sql->fetchAll();
$point_24 = array_count_values(array_column($answer_29, 'VillageCode'));

$sql = $db->prepare("SELECT T1.VillageCode, T1.Ebasta2, T1.VilekhSankhya, T1.KhataNo, T1.GataNo, owner_names, owner_fathers
                    FROM lm_gata_ebasta T1
                    LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                    LEFT JOIN (
                            SELECT T1.ID, T1.VillageCode, T1.Ebasta2, T1.GataNo, COUNT(T1.GataNo) AS TotalGata, GROUP_CONCAT(T1.GataNo) AS Gatas, COUNT(T1.owner_name) AS owner_names, COUNT(T1.owner_father) AS owner_fathers
                            FROM lm_gata_ebasta T1
                            WHERE MATCH(T1.Ebasta2) AGAINST (?)
                            GROUP BY T1.VillageCode, T1.Ebasta2, T1.GataNo, T1.owner_name, T1.owner_father
                    ) AS TMP ON TMP.VillageCode = T1.VillageCode AND TMP.ID = T1.ID
                    WHERE MATCH(T1.Ebasta2) AGAINST (?)
                    AND (T2.Shreni = ? OR T2.Shreni = ?)
                    AND T2.BoardApproved = ?
                    GROUP BY T1.VillageCode, T1.Ebasta2, T1.GataNo
                    HAVING owner_names > 1
                    ");
$sql->bindValue(1, 'file_name');
$sql->bindValue(2, 'file_name');
$sql->bindValue(3, '1-क');
$sql->bindValue(4, '2');
$sql->bindValue(5, 'YES');
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
$answer_30 = $sql->fetchAll();
$point_25 = array_count_values(array_column($answer_30, 'VillageCode'));

$sql = $db->prepare("SELECT T1.VillageCode
                    FROM lm_gata_ebasta T1
                    LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                    WHERE MATCH(T1.Ebasta5) AGAINST (?)
                    AND (T2.Shreni = ? OR T2.Shreni = ?)
                    AND T2.BoardApproved = ?
                    GROUP BY T1.Ebasta5
                    ");
$sql->bindValue(1, 'file_name');
$sql->bindValue(2, '1-क');
$sql->bindValue(3, '2');
$sql->bindValue(4, 'YES');
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
$answer_31 = $sql->fetchAll();
$point_26 = array_count_values(array_column($answer_31, 'VillageCode'));
