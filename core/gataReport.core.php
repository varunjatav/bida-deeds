<?php

$count = 1;
$village_code = $_POST['village_code'];
$decrypt_data = decryptIt(myUrlEncode($_POST['gata_no']));
$explode_data = explode('@', $decrypt_data);
$gata_no = $explode_data[0];
$khata_no = $explode_data[1];
$gata_area = $explode_data[2];

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

$mortgage_query = $db->prepare("SELECT T1.ID
                                FROM lm_gata_martgaged_info T1
                                WHERE T1.VillageCode = ?
                                AND T1.GataNo = ?
                                AND T1.KhataNo = ?
                                AND ROUND(CAST(T1.Area AS FLOAT), 4) = ?
                                ");
$mortgage_query->bindParam(1, $village_code);
$mortgage_query->bindParam(2, $gata_no);
$mortgage_query->bindParam(3, $khata_no);
$mortgage_query->bindParam(4, $gata_area);
$mortgage_query->execute();
$mortgage_query->setFetchMode(PDO::FETCH_ASSOC);
$mortgaged_count = $mortgage_query->rowCount();

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
    $answer_color_1 = 'row-highlight-green';
} else {
    $answer_1 = 'ना';
    $answer_color_1 = 'row-highlight-red';
    $answer_info_1 = 'डाटा उपलब्ध नहीं है';
}

if ($chakbandi_status) {
    if ((float) $gataInfo['ch41_45_ke_anusar_rakba']) {
        $answer_2 = 'हाँ';
        $answer_color_2 = 'row-highlight-green';
        $answer_info_2 = 'ch41_45_ke_anusar_rakba: ' . $gataInfo['ch41_45_ke_anusar_rakba'];
    } else {
        $answer_2 = 'ना';
        $answer_color_2 = 'row-highlight-red';
        $answer_info_2 = 'डाटा उपलब्ध नहीं है';
    }
} else {
    $answer_2 = 'ना';
    $answer_color_2 = 'row-highlight-green';
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
        $answer_color_6 = 'row-highlight-red';
        $answer_info_6 = 'current shreni: ' . $gataInfo['Shreni'] . ', khate_me_fasali_ke_anusar_kism: ' . $gataInfo['khate_me_fasali_ke_anusar_kism'];
    } else {
        $vivran = $gataInfo['khate_me_fasali_ke_anusar_kism'] ? $gataInfo['khate_me_fasali_ke_anusar_kism'] : 'डाटा उपलब्ध नहीं है';
        $answer_6 = 'ना';
        $answer_color_6 = 'row-highlight-green';
        $answer_info_6 = 'current shreni: ' . $gataInfo['Shreni'] . ', khate_me_fasali_ke_anusar_kism: ' . $vivran;
    }
} else {
    $vivran = $gataInfo['khate_me_fasali_ke_anusar_kism'] ? $gataInfo['khate_me_fasali_ke_anusar_kism'] : 'डाटा उपलब्ध नहीं है';
    $answer_6 = 'ना';
    $answer_color_6 = 'row-highlight-green';
    $answer_info_6 = 'current shreni: ' . $gataInfo['Shreni'] . ', khate_me_fasali_ke_anusar_kism: ' . $vivran;
}

if ($chakbandi_status) {
    if ($gataInfo['ch41_45_ke_anusar_sreni'] != '--') {
        if (substr($gataInfo['ch41_45_ke_anusar_sreni'], 0, 1) == substr($gataInfo['Shreni'], 0, 1)) {
            $answer_7 = 'हाँ';
            $answer_color_7 = 'row-highlight-green';
            $answer_info_7 = 'current shreni: ' . $gataInfo['Shreni'] . ', ch41_45_ke_anusar_sreni: ' . $gataInfo['ch41_45_ke_anusar_sreni'];
        } else {
            $answer_7 = 'ना';
            $answer_color_7 = 'row-highlight-red';
            $answer_info_7 = 'current shreni: ' . $gataInfo['Shreni'] . ', ch41_45_ke_anusar_sreni: ' . $gataInfo['ch41_45_ke_anusar_sreni'];
        }
    } else {
        $answer_7 = 'ना';
        $answer_color_7 = 'row-highlight-red';
        $answer_info_7 = 'डाटा उपलब्ध नहीं है';
    }
} else {
    $answer_7 = 'ना';
    $answer_color_7 = 'row-highlight-green';
    $answer_info_7 = 'इस गाटे में चकबंदी नहीं हुई है';
}

if ((float) $gataInfo['fasali_ke_anusar_rakba']) {
    if ((float) $gataInfo['Area'] == (float) $gataInfo['fasali_ke_anusar_rakba']) {
        $vivran = $gataInfo['fasali_ke_anusar_rakba'] ? $gataInfo['fasali_ke_anusar_rakba'] : 'डाटा उपलब्ध नहीं है';
        $answer_8 = 'ना';
        $answer_color_8 = 'row-highlight-green';
        $answer_info_8 = 'current area: ' . $gataInfo['Area'] . ', fasali_ke_anusar_rakba: ' . $vivran;
    } else {
        $vivran = $gataInfo['fasali_ke_anusar_rakba'] ? $gataInfo['fasali_ke_anusar_rakba'] : 'डाटा उपलब्ध नहीं है';
        $answer_8 = 'हाँ';
        if ((float) $gataInfo['Area'] < (float) $gataInfo['fasali_ke_anusar_rakba']) {
            $answer_color_8 = 'row-highlight-green';
        } else {
            $answer_color_8 = 'row-highlight-red';
        }
        $answer_info_8 = 'current area: ' . $gataInfo['Area'] . ', fasali_ke_anusar_rakba: ' . $vivran;
    }
} else {
    $answer_8 = 'ना';
    $answer_color_8 = 'row-highlight-green';
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
            $answer_color_10 = 'row-highlight-green';
            $answer_info_10 = 'current area: ' . $gataInfo['Area'] . ', ch41_45_ke_anusar_rakba: ' . $vivran;
        } else {
            $vivran = $gataInfo['ch41_45_ke_anusar_rakba'] ? $gataInfo['ch41_45_ke_anusar_rakba'] : 'डाटा उपलब्ध नहीं है';
            $answer_10 = 'हाँ';
            if ((float) $gataInfo['Area'] < (float) $gataInfo['ch41_45_ke_anusar_rakba']) {
                $answer_color_10 = 'row-highlight-green';
            } else {
                $answer_color_10 = 'row-highlight-red';
            }
            $answer_info_10 = 'current area: ' . $gataInfo['Area'] . ', ch41_45_ke_anusar_rakba: ' . $vivran;
        }
    } else {
        $answer_10 = 'ना';
        $answer_color_10 = 'row-highlight-green';
        $answer_info_10 = 'डाटा उपलब्ध नहीं है';
    }
} else {
    $answer_color_10 = 'row-highlight-green';
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
    $answer_color_15 = 'row-highlight-red';
    $answer_color_12 = 'row-highlight-red';
    $answer_color_13 = 'row-highlight-red';
    $answer_color_14 = 'row-highlight-red';
} else {
    $answer_15 = 'ना';
    $answer_color_15 = 'row-highlight-green';
    $answer_color_12 = 'row-highlight-green';
    $answer_color_13 = 'row-highlight-green';
    $answer_color_14 = 'row-highlight-green';
}

if ((float) $gataInfo['last_year_bainama_circle_rate'] && (float) $gataInfo['land_total_amount']) {
    if ((float) $gataInfo['last_year_bainama_circle_rate'] > ((float) $gataInfo['land_total_amount'] / 4)) {
        $answer_16 = 'हाँ';
        $answer_color_16 = 'row-highlight-red';
    } else {
        $answer_16 = 'ना';
        $answer_color_16 = 'row-highlight-green';
    }
} else {
    $answer_16 = 'डाटा उपलब्ध नहीं है';
    $answer_info_16 = 'last_year_bainama_circle_rate: ' . $gataInfo['last_year_bainama_circle_rate'] . ', land_total_amount: ' . $gataInfo['land_total_amount'];
}

if ((float) $gataInfo['last_two_year_bainama_circle_rate'] && (float) $gataInfo['land_total_amount']) {
    if ((float) $gataInfo['last_two_year_bainama_circle_rate'] > ((float) $gataInfo['land_total_amount'] / 4)) {
        $answer_17 = 'हाँ';
        $answer_color_17 = 'row-highlight-red';
    } else {
        $answer_17 = 'ना';
        $answer_color_17 = 'row-highlight-green';
    }
} else {
    $answer_17 = 'डाटा उपलब्ध नहीं है';
    $answer_info_17 = 'last_two_year_bainama_circle_rate: ' . $gataInfo['last_two_year_bainama_circle_rate'] . ', land_total_amount: ' . $gataInfo['land_total_amount'];
}

if ((float) $gataInfo['agricultural_area'] && (float) $gataInfo['land_total_amount']) {
    $data = (float) $gataInfo['agricultural_area'] ? (float) ($gataInfo['land_total_amount'] / (4 * (float) $gataInfo['agricultural_area'])) : 0;
    if (((float) $gataInfo['current_circle_rate'] > 0 && $data > (float) $gataInfo['current_circle_rate']) || ((float) $gataInfo['road_rate'] > 0 && $data > (float) $gataInfo['road_rate']) || ((float) $gataInfo['aabadi_rate'] > 0 && $data > (float) $gataInfo['aabadi_rate'])) {
        $answer_18 = 'हाँ';
        $answer_color_18 = 'row-highlight-red';
    } else {
        $answer_18 = 'ना';
        $answer_color_18 = 'row-highlight-green';
    }
} else {
    $answer_18 = 'डाटा उपलब्ध नहीं है';
    $answer_info_18 = 'agricultural_area: ' . $gataInfo['agricultural_area'] . ', land_total_amount: ' . $gataInfo['land_total_amount'];
}

if ((float) $gataInfo['total_parisampatti_amount'] && (float) $gataInfo['land_total_amount']) {
    $data = (10 * (float) $gataInfo['land_total_amount'] / 100);
    if ((float) $gataInfo['total_parisampatti_amount'] > $data) {
        $answer_19 = 'हाँ';
        $answer_color_19 = 'row-highlight-red';
    } else {
        $answer_19 = 'ना';
        $answer_color_19 = 'row-highlight-green';
    }
} else {
    $answer_19 = 'डाटा उपलब्ध नहीं है';
    $answer_info_19 = 'total_parisampatti_amount: ' . $gataInfo['total_parisampatti_amount'] . ', land_total_amount: ' . $gataInfo['land_total_amount'];
}

if ((float) $gataInfo['total_parisampatti_amount']) {
    if ((float) $gataInfo['total_parisampatti_amount'] > 1000000) {
        $answer_20 = 'हाँ';
        $answer_color_20 = 'row-highlight-red';
    } else {
        $answer_20 = 'ना';
        $answer_color_20 = 'row-highlight-green';
    }
} else {
    $answer_20 = 'डाटा उपलब्ध नहीं है';
    $answer_info_20 = 'total_parisampatti_amount: ' . $gataInfo['total_parisampatti_amount'];
}

if (strtolower($gataInfo['HoldByDM']) == 'yes') {
    $answer_21 = 'हाँ';
    $answer_color_21 = 'row-highlight-red';
} else if (strtolower($gataInfo['HoldByDM']) == 'no') {
    $answer_21 = 'ना';
    $answer_color_21 = 'row-highlight-green';
} else {
    $answer_21 = 'डाटा उपलब्ध नहीं है';
    $answer_info_21 = 'hold by dm: ' . $gataInfo['HoldByDM'];
}

if (strtolower($gataInfo['HoldByBIDA']) == 'yes') {
    $answer_22 = 'हाँ';
    $answer_color_22 = 'row-highlight-red';
} else if (strtolower($gataInfo['HoldByBIDA']) == 'no') {
    $answer_22 = 'ना';
    $answer_color_22 = 'row-highlight-green';
} else {
    $answer_22 = 'डाटा उपलब्ध नहीं है';
    $answer_info_22 = 'hold by bida: ' . $gataInfo['HoldByDM'];
}

if (strtolower($gataInfo['HoldByNirdharan']) == 'yes') {
    $answer_23 = 'हाँ';
    $answer_color_23 = 'row-highlight-red';
} else if (strtolower($gataInfo['HoldByNirdharan']) == 'no') {
    $answer_23 = 'ना';
    $answer_color_23 = 'row-highlight-green';
} else {
    $answer_23 = 'डाटा उपलब्ध नहीं है';
    $answer_info_23 = 'hold by dar nirdharan: ' . $gataInfo['HoldByNirdharan'];
}

if (strtolower($gataInfo['BinamaHoldByBIDA']) == 'yes') {
    $answer_24 = 'हाँ';
    $answer_color_24 = 'row-highlight-red';
} else if (strtolower($gataInfo['BinamaHoldByBIDA']) == 'no') {
    $answer_24 = 'ना';
    $answer_color_24 = 'row-highlight-green';
} else {
    $answer_24 = 'डाटा उपलब्ध नहीं है';
    $answer_info_24 = 'bainama hold by bida: ' . $gataInfo['BinamaHoldByBIDA'];
}

if (strtolower($gataInfo['gata_map_not_field']) == 'yes') {
    $answer_25 = 'हाँ';
    $answer_color_25 = 'row-highlight-red';
} else if (strtolower($gataInfo['gata_map_not_field']) == 'no') {
    $answer_25 = 'ना';
    $answer_color_25 = 'row-highlight-green';
} else {
    $answer_25 = 'डाटा उपलब्ध नहीं है';
    $answer_info_25 = 'gata_map_not_field: ' . $gataInfo['gata_map_not_field'];
}

if (strtolower($gataInfo['nahar_map_but_kastkar']) == 'yes') {
    $answer_26 = 'हाँ';
    $answer_color_26 = 'row-highlight-red';
} else if (strtolower($gataInfo['nahar_map_but_kastkar']) == 'no') {
    $answer_25 = 'ना';
    $answer_color_26 = 'row-highlight-green';
} else {
    $answer_26 = 'डाटा उपलब्ध नहीं है';
    $answer_info_26 = 'nahar_map_but_kastkar: ' . $gataInfo['nahar_map_but_kastkar'];
}

if (strtolower($gataInfo['sadak_map_but_kastkar']) == 'yes') {
    $answer_27 = 'हाँ';
    $answer_color_27 = 'row-highlight-red';
} else if (strtolower($gataInfo['nahar_map_but_kastkar']) == 'no') {
    $answer_27 = 'ना';
    $answer_color_27 = 'row-highlight-green';
} else {
    $answer_27 = 'डाटा उपलब्ध नहीं है';
    $answer_info_27 = 'sadak_map_but_kastkar: ' . $gataInfo['sadak_map_but_kastkar'];
}

if ($gataInfo['total_tree'] != '--') {
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

if ($mortgaged_count) {
    $answer_30 = 'हाँ';
    $answer_color_30 = 'row-highlight-red';
} else {
    $answer_30 = 'ना';
    $answer_color_30 = 'row-highlight-green';
}