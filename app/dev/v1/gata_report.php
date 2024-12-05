<?php

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
    $count = 1;
    $village_code = $_REQUEST['village_code'];
    $gata_no = $_REQUEST['gata_no'];
    $khata_no = $_REQUEST['khata_no'];
    $gata_area = $_REQUEST['gata_area'];
    $red = '#ffe8e8';
    $green = '#e4fbe4';

    if ($user_id && $village_code && $gata_no && $khata_no && $gata_area) {

        $village_query = $db->prepare("SELECT T1.*, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE T1.VillageCode = ?
                                AND T1.GataNo = ?
                                AND T1.KhataNo = ?
                                AND ROUND(CAST(T1.Area AS FLOAT), 4) = ?
                                ");
        $village_query->bindParam(1, $village_code);
        $village_query->bindParam(2, $gata_no);
        $village_query->bindParam(3, $khata_no);
        $village_query->bindParam(4, $gata_area);
        $village_query->execute();
        $village_query->setFetchMode(PDO::FETCH_ASSOC);
        $village_count = $village_query->rowCount();
        $gataInfo = $village_query->fetch();

        $chakbandi_query = $db->prepare("SELECT T1.*, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE T1.VillageCode = ?
                                AND CAST(ch41_45_ke_anusar_rakba AS FLOAT) > ?
                                ");
        $chakbandi_query->bindParam(1, $village_code);
        $chakbandi_query->bindValue(2, 0);
        $chakbandi_query->execute();
        $chakbandi_query->setFetchMode(PDO::FETCH_ASSOC);
        $chakbandi_status = $chakbandi_query->rowCount();

        if ($village_count > 0){
        $answer_15_count = 0;
        $answer_0 = '';
        $answer_1 = '';
        $answer_2 = '';
        $answer_3 = '';
        $answer_4 = '';
        $answer_5 = '';
        $answer_6 = '';
        $answer_7 = '';
        $answer_8 = '';
        $answer_9 = '';
        $answer_10 = '';
        $answer_11 = '';
        $answer_12 = '';
        $answer_13 = '';
        $answer_14 = '';
        $answer_15 = '';
        $answer_16 = '';
        $answer_17 = '';
        $answer_18 = '';
        $answer_19 = '';
        $answer_20 = '';
        $answer_21 = '';
        $answer_22 = '';
        $answer_23 = '';
        $answer_24 = '';
        $answer_25 = '';
        $answer_26 = '';
        $answer_27 = '';
        $answer_28 = '';
        $answer_29 = '';
        $answer_30 = '';

        $answer_color_1 = '';
        $answer_color_2 = '';
        $answer_color_6 = '';
        $answer_color_7 = '';
        $answer_color_8 = '';
        $answer_color_10 = '';
        $answer_color_12 = '';
        $answer_color_13 = '';
        $answer_color_14 = '';
        $answer_color_15 = '';
        $answer_color_16 = '';
        $answer_color_17 = '';
        $answer_color_18 = '';
        $answer_color_19 = '';
        $answer_color_20 = '';
        $answer_color_21 = '';
        $answer_color_22 = '';
        $answer_color_23 = '';
        $answer_color_24 = '';
        $answer_color_25 = '';
        $answer_color_26 = '';
        $answer_color_27 = '';
        $answer_color_30 = '';

        $answer_info_1 = '';
        $answer_info_2 = '';
        $answer_info_6 = '';
        $answer_info_7 = '';
        $answer_info_8 = '';
        $answer_info_10 = '';
        $answer_info_16 = '';
        $answer_info_17 = '';
        $answer_info_18 = '';
        $answer_info_19 = '';
        $answer_info_20 = '';
        $answer_info_21 = '';
        $answer_info_22 = '';
        $answer_info_23 = '';
        $answer_info_24 = '';
        $answer_info_25 = '';
        $answer_info_26 = '';
        $answer_info_27 = '';

        if (strtolower($gataInfo['BoardApproved']) == 'yes') {
            $answer_0 = 'हाँ';
        } else {
            $answer_0 = 'ना';
        }

        if ((float) $gataInfo['fasali_ke_anusar_rakba'] > 0) {
            $answer_1 = 'हाँ';
            $answer_color_1 = $green;
        } else {
            $answer_1 = 'ना';
            $answer_color_1 = $red;
            $answer_info_1 = 'डाटा उपलब्ध नहीं है';
        }

        if ($chakbandi_status) {
            if ((float) $gataInfo['ch41_45_ke_anusar_rakba']) {
                $answer_2 = 'हाँ';
                $answer_color_2 = $green;
                $answer_info_2 = 'ch41_45_ke_anusar_rakba: ' . $gataInfo['ch41_45_ke_anusar_rakba'];
            } else {
                $answer_2 = 'ना';
                $answer_color_2 = $red;
                $answer_info_2 = 'डाटा उपलब्ध नहीं है';
            }
        } else {
            $answer_2 = 'ना';
            $answer_color_2 = $green;
            $answer_info_2 = 'इस ग्राम में चकबंदी नहीं हुई है';
        }

//if ($gataInfo['khate_me_fasali_ke_anusar_kism']) {
//    $answer_3 = $gataInfo['khate_me_fasali_ke_anusar_kism'];
//} else {
//    $answer_3 = 'डाटा उपलब्ध नहीं है';
//}
//
//if (strtolower($gataInfo['fasali_me_kastkar_darj_status']) == 'yes') {
//    $answer_4 = 'हाँ';
//} else if (strtolower($gataInfo['fasali_me_kastkar_darj_status']) == 'no') {
//    $answer_4 = 'ना';
//} else if (strtolower($gataInfo['fasali_me_kastkar_darj_status']) == 'yes/no') {
//    $answer_4 = 'हाँ/ना';
//} else {
//    $answer_4 = 'डाटा उपलब्ध नहीं है';
//}
//

        if ($gataInfo['adhisuchana_ke_anusar_mauke_ki_stithi'] != '--') {
            $answer_5 = $gataInfo['adhisuchana_ke_anusar_mauke_ki_stithi'];
        } else {
            $answer_5 = 'डाटा उपलब्ध नहीं है';
        }

        if ($gataInfo['Shreni'] == '1-क' && $gataInfo['khate_me_fasali_ke_anusar_kism'] != '--') {
            //$var = array_keys(explode('(', $gataInfo['khate_me_fasali_ke_anusar_kism']));
            $data = strtolower($gataInfo['khate_me_fasali_ke_anusar_kism']);
            if (str_contains($data, 'nala') || str_contains($data, 'nali') || str_contains($data, 'pathar') || str_contains($data, 'patthar') || str_contains($data, 'paatthar') || str_contains($data, 'paathar') || str_contains($data, 'pathaar') || str_contains($data, 'pahad') || str_contains($data, 'paahaad') || str_contains($data, 'pahaad') || str_contains($data, 'paahad') || str_contains($data, 'pukhariya') || str_contains($data, 'pokhar') || str_contains($data, 'talab') || str_contains($data, 'dev sthan') || str_contains($data, 'khaliyan') || str_contains($data, 'khalihan') || str_contains($data, 'rasta') || str_contains($data, 'rashta') || str_contains($data, 'gochar') || str_contains($data, 'chakroad') || str_contains($data, 'chakmarg') || str_contains($data, 'jhadi') || str_contains($data, 'aabadi') || str_contains($data, 'abadi') || str_contains($data, 'abaadi') || str_contains($data, 'nadi') || str_contains($data, 'nahar') || str_contains($data, 'tauriya') || str_contains($data, 'jangal') || str_contains($data, 'van')) {
                $answer_6 = 'हाँ';
                $answer_color_6 = $red;
                $answer_info_6 = 'current shreni: ' . $gataInfo['Shreni'] . ', khate_me_fasali_ke_anusar_kism: ' . $gataInfo['khate_me_fasali_ke_anusar_kism'];
            } else {
                $vivran = $gataInfo['khate_me_fasali_ke_anusar_kism'] ? $gataInfo['khate_me_fasali_ke_anusar_kism'] : 'डाटा उपलब्ध नहीं है';
                $answer_6 = 'ना';
                $answer_color_6 = $green;
                $answer_info_6 = 'current shreni: ' . $gataInfo['Shreni'] . ', khate_me_fasali_ke_anusar_kism: ' . $vivran;
            }
        } else {
            $vivran = $gataInfo['khate_me_fasali_ke_anusar_kism'] ? $gataInfo['khate_me_fasali_ke_anusar_kism'] : 'डाटा उपलब्ध नहीं है';
            $answer_6 = 'ना';
            $answer_color_6 = $green;
            $answer_info_6 = 'current shreni: ' . $gataInfo['Shreni'] . ', khate_me_fasali_ke_anusar_kism: ' . $vivran;
        }

        if ($chakbandi_status) {
            if ($gataInfo['ch41_45_ke_anusar_sreni'] != '--') {
                if (substr($gataInfo['ch41_45_ke_anusar_sreni'], 0, 1) == substr($gataInfo['Shreni'], 0, 1)) {
                    $answer_7 = 'हाँ';
                    $answer_color_7 = $green;
                    $answer_info_7 = 'current shreni: ' . $gataInfo['Shreni'] . ', ch41_45_ke_anusar_sreni: ' . $gataInfo['ch41_45_ke_anusar_sreni'];
                } else {
                    $answer_7 = 'ना';
                    $answer_color_7 = $red;
                    $answer_info_7 = 'current shreni: ' . $gataInfo['Shreni'] . ', ch41_45_ke_anusar_sreni: ' . $gataInfo['ch41_45_ke_anusar_sreni'];
                }
            } else {
                $answer_7 = 'ना';
                $answer_color_7 = $red;
                $answer_info_7 = 'डाटा उपलब्ध नहीं है';
            }
        } else {
            $answer_7 = 'ना';
            $answer_color_7 = $green;
            $answer_info_7 = 'इस गाटे में चकबंदी नहीं हुई है';
        }

        if ((float) $gataInfo['fasali_ke_anusar_rakba']) {
            if ((float) $gataInfo['Area'] == (float) $gataInfo['fasali_ke_anusar_rakba']) {
                $vivran = $gataInfo['fasali_ke_anusar_rakba'] ? $gataInfo['fasali_ke_anusar_rakba'] : 'डाटा उपलब्ध नहीं है';
                $answer_8 = 'ना';
                $answer_color_8 = $green;
                $answer_info_8 = 'current area: ' . $gataInfo['Area'] . ', fasali_ke_anusar_rakba: ' . $vivran;
            } else {
                $vivran = $gataInfo['fasali_ke_anusar_rakba'] ? $gataInfo['fasali_ke_anusar_rakba'] : 'डाटा उपलब्ध नहीं है';
                $answer_8 = 'हाँ';
                if ((float) $gataInfo['Area'] < (float) $gataInfo['fasali_ke_anusar_rakba']) {
                    $answer_color_8 = $green;
                } else {
                    $answer_color_8 = $red;
                }
                $answer_info_8 = 'current area: ' . $gataInfo['Area'] . ', fasali_ke_anusar_rakba: ' . $vivran;
            }
        } else {
            $answer_8 = 'ना';
            $answer_color_8 = $green;
            $answer_info_8 = 'डाटा उपलब्ध नहीं है';
        }

//if ($gataInfo['Area'] < $gataInfo['fasali_ke_anusar_rakba']) {
//    $answer_9 = 'हाँ';
//} else {
//    $answer_9 = 'ना';
//}

        if ($chakbandi_status) {
            if ((float) $gataInfo['ch41_45_ke_anusar_rakba']) {
                if ((float) $gataInfo['Area'] == (float) $gataInfo['ch41_45_ke_anusar_rakba']) {
                    $vivran = $gataInfo['ch41_45_ke_anusar_rakba'] ? $gataInfo['ch41_45_ke_anusar_rakba'] : 'डाटा उपलब्ध नहीं है';
                    $answer_10 = 'ना';
                    $answer_color_10 = $green;
                    $answer_info_10 = 'current area: ' . $gataInfo['Area'] . ', ch41_45_ke_anusar_rakba: ' . $vivran;
                } else {
                    $vivran = $gataInfo['ch41_45_ke_anusar_rakba'] ? $gataInfo['ch41_45_ke_anusar_rakba'] : 'डाटा उपलब्ध नहीं है';
                    $answer_10 = 'हाँ';
                    if ((float) $gataInfo['Area'] < (float) $gataInfo['ch41_45_ke_anusar_rakba']) {
                        $answer_color_10 = $green;
                    } else {
                        $answer_color_10 = $red;
                    }
                    $answer_info_10 = 'current area: ' . $gataInfo['Area'] . ', ch41_45_ke_anusar_rakba: ' . $vivran;
                }
            } else {
                $answer_10 = 'ना';
                $answer_color_10 = $green;
                $answer_info_10 = 'डाटा उपलब्ध नहीं है';
            }
        } else {
            $answer_color_10 = $green;
            $answer_10 = 'ना';
            $answer_info_10 = 'इस गाटे में चकबंदी नहीं हुई है';
        }

//if ($gataInfo['ch41_45_ke_anusar_rakba']) {
//    if ($gataInfo['Area'] < $gataInfo['ch41_45_ke_anusar_rakba']) {
//        $answer_11 = 'हाँ';
//    } else {
//        $answer_11 = 'ना';
//    }
//} else {
//    $answer_11 = 'इस गाटे में चकबंदी नहीं हुई है';
//}

        if ((float) $gataInfo['current_circle_rate']) {
            $answer_12 = $gataInfo['current_circle_rate'];
            $answer_15_count++;
        } else {
            $answer_12 = 0;
        }

        if ((float) $gataInfo['aabadi_rate']) {
            $answer_13 = $gataInfo['aabadi_rate'];
            $answer_15_count++;
        } else {
            $answer_13 = 0;
        }

        if ((float) $gataInfo['road_rate']) {
            $answer_14 = $gataInfo['road_rate'];
            $answer_15_count++;
        } else {
            $answer_14 = 0;
        }

        if ((float) $answer_15_count > 1) {
            $answer_15 = 'हाँ';
            $answer_color_15 = $red;
            $answer_color_12 = $red;
            $answer_color_13 = $red;
            $answer_color_14 = $red;
        } else {
            $answer_15 = 'ना';
            $answer_color_15 = $green;
            $answer_color_12 = $green;
            $answer_color_13 = $green;
            $answer_color_14 = $green;
        }

        if ((float) $gataInfo['last_year_bainama_circle_rate'] && (float) $gataInfo['land_total_amount']) {
            if ((float) $gataInfo['last_year_bainama_circle_rate'] > ((float) $gataInfo['land_total_amount'] / 4)) {
                $answer_16 = 'हाँ';
                $answer_color_16 = $red;
            } else {
                $answer_16 = 'ना';
                $answer_color_16 = $green;
            }
        } else {
            $answer_16 = 'डाटा उपलब्ध नहीं है';
            $answer_info_16 = 'last_year_bainama_circle_rate: ' . $gataInfo['last_year_bainama_circle_rate'] . ', land_total_amount: ' . $gataInfo['land_total_amount'];
        }

        if ((float) $gataInfo['last_two_year_bainama_circle_rate'] && (float) $gataInfo['land_total_amount']) {
            if ((float) $gataInfo['last_two_year_bainama_circle_rate'] > ((float) $gataInfo['land_total_amount'] / 4)) {
                $answer_17 = 'हाँ';
                $answer_color_17 = $red;
            } else {
                $answer_17 = 'ना';
                $answer_color_17 = $green;
            }
        } else {
            $answer_17 = 'डाटा उपलब्ध नहीं है';
            $answer_info_17 = 'last_two_year_bainama_circle_rate: ' . $gataInfo['last_two_year_bainama_circle_rate'] . ', land_total_amount: ' . $gataInfo['land_total_amount'];
        }

        if ((float) $gataInfo['agricultural_area'] && (float) $gataInfo['land_total_amount']) {
            $data = (float) $gataInfo['agricultural_area'] ? (float) ($gataInfo['land_total_amount'] / (4 * (float) $gataInfo['agricultural_area'])) : 0;
            if (((float) $gataInfo['current_circle_rate'] > 0 && $data > (float) $gataInfo['current_circle_rate']) || ((float) $gataInfo['road_rate'] > 0 && $data > (float) $gataInfo['road_rate']) || ((float) $gataInfo['aabadi_rate'] > 0 && $data > (float) $gataInfo['aabadi_rate'])) {
                $answer_18 = 'हाँ';
                $answer_color_18 = $red;
            } else {
                $answer_18 = 'ना';
                $answer_color_18 = $green;
            }
        } else {
            $answer_18 = 'डाटा उपलब्ध नहीं है';
            $answer_info_18 = 'agricultural_area: ' . $gataInfo['agricultural_area'] . ', land_total_amount: ' . $gataInfo['land_total_amount'];
        }

        if ((float) $gataInfo['total_parisampatti_amount'] && (float) $gataInfo['land_total_amount']) {
            $data = (10 * (float) $gataInfo['land_total_amount'] / 100);
            if ((float) $gataInfo['total_parisampatti_amount'] > $data) {
                $answer_19 = 'हाँ';
                $answer_color_19 = $red;
            } else {
                $answer_19 = 'ना';
                $answer_color_19 = $green;
            }
        } else {
            $answer_19 = 'डाटा उपलब्ध नहीं है';
            $answer_info_19 = 'total_parisampatti_amount: ' . $gataInfo['total_parisampatti_amount'] . ', land_total_amount: ' . $gataInfo['land_total_amount'];
        }

        if ((float) $gataInfo['total_parisampatti_amount']) {
            if ((float) $gataInfo['total_parisampatti_amount'] > 1000000) {
                $answer_20 = 'हाँ';
                $answer_color_20 = $red;
            } else {
                $answer_20 = 'ना';
                $answer_color_20 = $green;
            }
        } else {
            $answer_20 = 'डाटा उपलब्ध नहीं है';
            $answer_info_20 = 'total_parisampatti_amount: ' . $gataInfo['total_parisampatti_amount'];
        }

        if (strtolower($gataInfo['HoldByDM']) == 'yes') {
            $answer_21 = 'हाँ';
            $answer_color_21 = $red;
        } else if (strtolower($gataInfo['HoldByDM']) == 'no') {
            $answer_21 = 'ना';
            $answer_color_21 = $green;
        } else {
            $answer_21 = 'डाटा उपलब्ध नहीं है';
            $answer_info_21 = 'hold by dm: ' . $gataInfo['HoldByDM'];
        }

        if (strtolower($gataInfo['HoldByBIDA']) == 'yes') {
            $answer_22 = 'हाँ';
            $answer_color_22 = $red;
        } else if (strtolower($gataInfo['HoldByBIDA']) == 'no') {
            $answer_22 = 'ना';
            $answer_color_22 = $green;
        } else {
            $answer_22 = 'डाटा उपलब्ध नहीं है';
            $answer_info_22 = 'hold by bida: ' . $gataInfo['HoldByDM'];
        }

        if (strtolower($gataInfo['HoldByNirdharan']) == 'yes') {
            $answer_23 = 'हाँ';
            $answer_color_23 = $red;
        } else if (strtolower($gataInfo['HoldByNirdharan']) == 'no') {
            $answer_23 = 'ना';
            $answer_color_23 = $green;
        } else {
            $answer_23 = 'डाटा उपलब्ध नहीं है';
            $answer_info_23 = 'hold by dar nirdharan: ' . $gataInfo['HoldByNirdharan'];
        }

        if (strtolower($gataInfo['BinamaHoldByBIDA']) == 'yes') {
            $answer_24 = 'हाँ';
            $answer_color_24 = $red;
        } else if (strtolower($gataInfo['BinamaHoldByBIDA']) == 'no') {
            $answer_24 = 'ना';
            $answer_color_24 = $green;
        } else {
            $answer_24 = 'डाटा उपलब्ध नहीं है';
            $answer_info_24 = 'bainama hold by bida: ' . $gataInfo['BinamaHoldByBIDA'];
        }

        if (strtolower($gataInfo['gata_map_not_field']) == 'yes') {
            $answer_25 = 'हाँ';
            $answer_color_25 = $red;
        } else if (strtolower($gataInfo['gata_map_not_field']) == 'no') {
            $answer_25 = 'ना';
            $answer_color_25 = $green;
        } else {
            $answer_25 = 'डाटा उपलब्ध नहीं है';
            $answer_info_25 = 'gata_map_not_field: ' . $gataInfo['gata_map_not_field'];
        }

        if (strtolower($gataInfo['nahar_map_but_kastkar']) == 'yes') {
            $answer_26 = 'हाँ';
            $answer_color_26 = $red;
        } else if (strtolower($gataInfo['nahar_map_but_kastkar']) == 'no') {
            $answer_25 = 'ना';
            $answer_color_26 = $green;
        } else {
            $answer_26 = 'डाटा उपलब्ध नहीं है';
            $answer_info_26 = 'nahar_map_but_kastkar: ' . $gataInfo['nahar_map_but_kastkar'];
        }

        if (strtolower($gataInfo['sadak_map_but_kastkar']) == 'yes') {
            $answer_27 = 'हाँ';
            $answer_color_27 = $red;
        } else if (strtolower($gataInfo['nahar_map_but_kastkar']) == 'no') {
            $answer_27 = 'ना';
            $answer_color_27 = $green;
        } else {
            $answer_27 = 'डाटा उपलब्ध नहीं है';
            $answer_info_27 = 'sadak_map_but_kastkar: ' . $gataInfo['sadak_map_but_kastkar'];
        }

        if ($gataInfo['total_tree'] !== '--') {
            $answer_28 = $gataInfo['total_tree'];
        } else {
            $answer_28 = 0;
        }

        if ($gataInfo['parisampatti_name']) {
            $answer_29 = $gataInfo['parisampatti_name'];
            $first_val = array_shift(explode(',', $gataInfo['parisampatti_name']));
            $order_count = count_(explode(',', $gataInfo['parisampatti_name']));
            $rest_val_count = '';
            if ($order_count > 1) {
                $rest_val_count = ' +' . ($order_count - 1) . ' more';
            }
            $answer_29_short = $first_val . ' ' . '<span style="color:blue;cursor:pointer;">' . $rest_val_count . '</span>';
        } else {
            $answer_29 = 'डाटा उपलब्ध नहीं है';
        }

        // Define dynamic questions and answers
        $reports = [
            [
                "header" => "गाटे के परीक्षण का बिंदु/सवाल",
                "items" => [
                    [
                        "color" => $answer_color_1,
                        "tab" => "क्रo सo " . $count++,
                        "question" => "क्या गाटा 1359 फसली खतौनी में उपलब्ध है?",
                        "result" => $answer_1,
                        "description" => $answer_info_1
                    ],
                    [
                        "color" => $answer_color_2,
                        "tab" => "क्रo सo " . $count++,
                        "question" => "क्या गाटा सीएच 41-45 में उपलब्ध है?",
                        "result" => $answer_2,
                        "description" => $answer_info_2
                    ]
                ]
            ],
            [
                "header" => "गाटे की श्रेणी के संबंध में",
                "items" => [
                    [
                        "color" => $answer_color_6,
                        "tab" => "क्रo सo " . $count++,
                        "question" => "क्या गाटे की वर्तमान खतौनी 1-क है और 1359 फसली खसरे के अनुसार सुरक्षित श्रेणी में है?",
                        "result" => $answer_6,
                        "description" => $answer_info_6
                    ],
                    [
                        "color" => $answer_color_7,
                        "tab" => "क्रo सo " . $count++,
                        "question" => "क्या गाटे की वर्तमान श्रेणी सीएच 41-45 के समान हैं?",
                        "result" => $answer_7,
                        "description" => $answer_info_7
                    ]
                ]
            ],
            [
                "header" => "गाटे की रकबे के संबंध में",
                "items" => [
                    [
                        "color" => $answer_color_8,
                        "tab" => "क्रo सo " . $count++,
                        "question" => "गाटे का वर्तमान रकबा 1359 फसली खतौनी के रकबे के बराबर है या नहीं?",
                        "result" => $answer_8,
                        "description" => $answer_info_8
                    ],
                    [
                        "color" => $answer_color_10,
                        "tab" => "क्रo सo " . $count++,
                        "question" => "गाटे का वर्तमान रकबा 41-45 के रकबे के बराबर है या नहीं?",
                        "result" => $answer_10,
                        "description" => $answer_info_10
                    ]
                ]
            ],
            [
                "header" => "गाटे के दर निर्धारण के सम्बन्ध में",
                "items" => [
                    [
                        "color" => $answer_color_12,
                        "tab" => "क्रo सo " . $count++,
                        "question" => "गाटे की कृषि दर क्या निर्धारित की गयी हैं?",
                        "result" => $answer_12,
                        "description" => ""
                    ],
                    [
                        "color" => $answer_color_13,
                        "tab" => "क्रo सo " . $count++,
                        "question" => "गाटे की आबादी दर क्या निर्धारित की गयी हैं?",
                        "result" => $answer_13,
                        "description" => ""
                    ],
                    [
                        "color" => $answer_color_14,
                        "tab" => "क्रo सo " . $count++,
                        "question" => "गाटे की सड़क किनारे की दर क्या निर्धारित की गयी हैं?",
                        "result" => $answer_14,
                        "description" => ""
                    ],
                    [
                        "color" => $answer_color_15,
                        "tab" => "क्रo सo " . $count++,
                        "question" => "क्या गाटे पर एक से अधिक प्रकार की दर निर्धारित की गयी है?",
                        "result" => $answer_15,
                        "description" => ""
                    ],
                    [
                        "color" => $answer_color_16,
                        "tab" => "क्रo सo " . $count++,
                        "question" => "क्या पिछले एक साल की मार्केट रेट गाटे की सर्किल रेट से अधिक है?",
                        "result" => $answer_16,
                        "description" => $answer_info_16
                    ],
                    [
                        "color" => $answer_color_17,
                        "tab" => "क्रo सo " . $count++,
                        "question" => "क्या पिछले दो साल की मार्केट रेट गाटे की सर्किल रेट से अधिक है?",
                        "result" => $answer_17,
                        "description" => $answer_info_17
                    ],
                    [
                        "color" => $answer_color_18,
                        "tab" => "क्रo सo " . $count++,
                        "question" => "क्या गाटे का भूमि मूल्य सर्किल के 4 गुने से अधिक हैं?",
                        "result" => $answer_18,
                        "description" => $answer_info_18
                    ],
                    [
                        "color" => $answer_color_19,
                        "tab" => "क्रo सo " . $count++,
                        "question" => "क्या परिसंपत्तियों का मूल्य कुल भूमि के मूल्य के 10 प्रतिशत से अधिक है?",
                        "result" => $answer_19,
                        "description" => $answer_info_19
                    ],
                    [
                        "color" => $answer_color_20,
                        "tab" => "क्रo सo " . $count++,
                        "question" => "क्या परिसंपत्तियों का मूल्य 10 लाख रुपये से अधिक है?",
                        "result" => $answer_20,
                        "description" => $answer_info_20
                    ]
                ]
            ],
            [
                "header" => "गाटे के होल्ड करने के सम्बन्ध में",
                "items" => [
                    [
                        "color" => $answer_color_21,
                        "tab" => "क्रo सo " . $count++,
                        "question" => "क्या गाटा जिलाधिकारी द्वारा प्रेस विज्ञप्ति के पूर्व रोका गया है?",
                        "result" => $answer_21,
                        "description" => $answer_info_21
                    ],
                    [
                        "color" => $answer_color_22,
                        "tab" => "क्रo सo " . $count++,
                        "question" => "क्या गाटा बीडा द्वारा प्रेस विज्ञप्ति से पहले रोका गया है?",
                        "result" => $answer_22,
                        "description" => $answer_info_22
                    ],
                    [
                        "color" => $answer_color_23,
                        "tab" => "क्रo सo " . $count++,
                        "question" => "क्या गाटा दर निर्धारण समिति द्वारा रोका गया है?",
                        "result" => $answer_23,
                        "description" => $answer_info_23
                    ],
                    [
                        "color" => $answer_color_24,
                        "tab" => "क्रo सo " . $count++,
                        "question" => "क्या गाटे का बैनामा बीडा द्वारा दर निर्धारण उपरान्त रोका गया है?",
                        "result" => $answer_24,
                        "description" => $answer_info_24
                    ],
                    [
                        "color" => $answer_color_25,
                        "tab" => "क्रo सo " . $count++,
                        "question" => "क्या गाटा नक्शे पर है, परन्तु मौके पर नहीं है?",
                        "result" => $answer_25,
                        "description" => $answer_info_25
                    ],
                    [
                        "color" => $answer_color_26,
                        "tab" => "क्रo सo " . $count++,
                        "question" => "क्या मानचित्र/मौके पर नहर है एवं खतौनी में काश्तकार हैं?",
                        "result" => $answer_26,
                        "description" => $answer_info_26
                    ],
                    [
                        "color" => $answer_color_27,
                        "tab" => "क्रo सo " . $count++,
                        "question" => "क्या मानचित्र/मौके पर सड़क है एवं खतौनी में काश्तकार हैं?",
                        "result" => $answer_27,
                        "description" => $answer_info_27
                    ]
                ]
            ],
            [
                "header" => "अन्य बिन्दु",
                "items" => [
                    [
                        "color" => "",
                        "tab" => "क्रo सo " . $count++,
                        "question" => "गाटे पर कुल वृक्ष कितने है?",
                        "result" => $answer_28,
                        "description" => ""
                    ],
                    [
                        "color" => "",
                        "tab" => "क्रo सo " . $count++,
                        "question" => "गाटा पर परिसम्पत्तियाँ क्या-क्या है?",
                        "result" => $answer_29,
                        "description" => ""
                    ],
                    [
                        "color" => "",
                        "tab" => "क्रo सo " . $count++,
                        "question" => "क्या एग्री स्टेक के अनुसार मौके पर फसल हैं?",
                        "result" => $answer_5,
                        "description" => ""
                    ]
                ]
            ]
        ];

        $data = array('status' => true, 'message' => 'Data Fetched Successfully', 'reports' => $reports);
        } else {
          $data = array('status' => false, 'message' => 'Data Not Found');
        }
    } else {
        //Creating JSON
        $data = array('status' => false, 'message' => 'Oops.. something went wrong.');
    }
    $data = removeEmptyValues($data);
    print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
}
