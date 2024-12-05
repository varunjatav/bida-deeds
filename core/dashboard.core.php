<?php

$user_type = $_SESSION['UserType'];
$sum_since_feb = 0;
$sum_current_month = 0;
$avg_purchase_rate_per_month = 0;
$avg_purchase_rate_per_week = 0;
$avg_purchase_rate_per_day = 0;
$avg_purchase_rate_last_day = 0;

$days = get_days_between_dates("2024-02-09", "");
$months = get_months_between_dates("2024-02-09", "");
$weeks = get_weeks_between_dates("02-09-2024", date('m-d-Y'));
$current_month = date('m');
$current_month_start_date = date('Y') . '-' . date('m') . '-01';
$current_month_start_date_mdy = date('m') . '-01' . '-' . date('Y');
$current_month_days = get_days_between_dates($current_month_start_date, "");
$last_date = date('Y-m-d', strtotime("-2 days"));

//////////////////////////////////////////
////////////// CHART 1 ///////////////////
//////////////////////////////////////////

$chart_1_x_axis = array('Per day since 09-02-2024', 'Per month since 09-02-2024', 'Per week since 09-02-2024', 'Per day in current month', 'Last day (' . date('dS M', strtotime($last_date)) . ')');

$sql = $db->prepare("SELECT SUM(T1.AnshRakba) AS Rakba
                    FROM lm_gata_ebasta T1
                    LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                    WHERE MATCH(T1.Ebasta2) AGAINST (?)
                    AND (T2.Shreni = ? OR T2.Shreni = ?)
                    AND T2.BoardApproved = ?
                    AND FROM_UNIXTIME(T1.AnshDate, '%Y-%m-%d') >= ?
                    GROUP BY T1.Ebasta2
                    ");
$sql->bindValue(1, 'file_name');
$sql->bindValue(2, '1-क');
$sql->bindValue(3, '2');
$sql->bindValue(4, 'YES');
$sql->bindValue(5, '2024-02-09');
$sql->execute();
while ($row = $sql->fetch()) {
    $sum_since_feb += $row['Rakba'];
}

$sql = $db->prepare("SELECT SUM(T1.AnshRakba) AS Rakba
                    FROM lm_gata_ebasta T1
                    LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                    WHERE MATCH(T1.Ebasta2) AGAINST (?)
                    AND (T2.Shreni = ? OR T2.Shreni = ?)
                    AND T2.BoardApproved = ?
                    AND FROM_UNIXTIME(T1.AnshDate, '%m') = ?
                    GROUP BY T1.Ebasta2
                    ");
$sql->bindValue(1, 'file_name');
$sql->bindValue(2, '1-क');
$sql->bindValue(3, '2');
$sql->bindValue(4, 'YES');
$sql->bindParam(5, $current_month);
$sql->execute();
while ($row = $sql->fetch()) {
    $sum_current_month += $row['Rakba'];
}

$sql = $db->prepare("SELECT SUM(T1.AnshRakba) AS Rakba
                    FROM lm_gata_ebasta T1
                    LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                    WHERE MATCH(T1.Ebasta2) AGAINST (?)
                    AND (T2.Shreni = ? OR T2.Shreni = ?)
                    AND T2.BoardApproved = ?
                    AND FROM_UNIXTIME(T1.AnshDate, '%Y-%m-%d') = ?
                    GROUP BY T1.Ebasta2
                    ");
$sql->bindValue(1, 'file_name');
$sql->bindValue(2, '1-क');
$sql->bindValue(3, '2');
$sql->bindValue(4, 'YES');
$sql->bindParam(5, $last_date);
$sql->execute();
while ($row = $sql->fetch()) {
    $sum_since_last_day += $row['Rakba'];
}

$total_since_feb = round(($sum_since_feb / $days));
$avg_purchase_rate_per_month = round(($sum_since_feb / $months));
$avg_purchase_rate_per_week = round(($sum_since_feb / $weeks));
$avg_purchase_rate_per_day = round(($sum_current_month / $current_month_days));
$avg_purchase_rate_last_day = round($sum_since_last_day);

$chart_1_y_axis = array($total_since_feb, $avg_purchase_rate_per_month, $avg_purchase_rate_per_week, $avg_purchase_rate_per_day, $avg_purchase_rate_last_day);

//////////////////////////////////////////
////////////// CHART 2 ///////////////////
//////////////////////////////////////////

$chart_2_sum_since_feb = 0;
$chart_2_sum_current_month = 0;
$chart_2_avg_purchase_rate_per_month = 0;
$chart_2_avg_purchase_rate_per_week = 0;
$chart_2_avg_purchase_rate_per_day = 0;
$chart_2_avg_purchase_rate_last_day = 0;

$chart_2_x_axis = array('Per day since 09-02-2024', 'Per month since 09-02-2024', 'Per week since 09-02-2024', 'Per day in current month', 'Last day (' . date('dS M', strtotime($last_date)) . ')');

$sql = $db->prepare("SELECT T1.PaymentAmount
                    FROM lm_gata_ebasta T1
                    LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                    WHERE MATCH(T1.Ebasta2) AGAINST (?)
                    AND (T2.Shreni = ? OR T2.Shreni = ?)
                    AND T2.BoardApproved = ?
                    GROUP BY T1.VillageCode, T1.Ebasta2
                    ");
$sql->bindValue(1, 'file_name');
$sql->bindValue(2, '1-क');
$sql->bindValue(3, '2');
$sql->bindValue(4, 'YES');
$sql->execute();
while ($row = $sql->fetch()) {
    $chart_2_sum_since_feb += $row['PaymentAmount'];
}

$sql = $db->prepare("SELECT T1.PaymentAmount
                    FROM lm_gata_ebasta T1
                    LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                    WHERE MATCH(T1.Ebasta2) AGAINST (?)
                    AND (T2.Shreni = ? OR T2.Shreni = ?)
                    AND T2.BoardApproved = ?
                    AND FROM_UNIXTIME(T1.PaymentDate, '%m') = ?
                    GROUP BY T1.VillageCode, T1.Ebasta2
                    ");
$sql->bindValue(1, 'file_name');
$sql->bindValue(2, '1-क');
$sql->bindValue(3, '2');
$sql->bindValue(4, 'YES');
$sql->bindParam(5, $current_month);
$sql->execute();
while ($row = $sql->fetch()) {
    $chart_2_sum_current_month += $row['PaymentAmount'];
}

$sql = $db->prepare("SELECT T1.PaymentAmount
                    FROM lm_gata_ebasta T1
                    LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                    WHERE MATCH(T1.Ebasta2) AGAINST (?)
                    AND (T2.Shreni = ? OR T2.Shreni = ?)
                    AND T2.BoardApproved = ?
                    AND FROM_UNIXTIME(T1.PaymentDate, '%Y-%m-%d') = ?
                    GROUP BY T1.VillageCode, T1.Ebasta2
                    ");
$sql->bindValue(1, 'file_name');
$sql->bindValue(2, '1-क');
$sql->bindValue(3, '2');
$sql->bindValue(4, 'YES');
$sql->bindParam(5, $last_date);
$sql->execute();
while ($row = $sql->fetch()) {
    $chart_2_sum_since_last_day += $row['PaymentAmount'];
}

$chart_2_total_since_feb = round(($chart_2_sum_since_feb / $days));
$chart_2_avg_purchase_rate_per_month = round(($chart_2_sum_since_feb / $months));
$chart_2_avg_purchase_rate_per_week = round(($chart_2_sum_since_feb / $weeks));
$chart_2_avg_purchase_rate_per_day = round(($chart_2_sum_current_month / $current_month_days));
$chart_2_avg_purchase_rate_last_day = round($chart_2_sum_since_last_day);

$chart_2_y_axis = array($chart_2_total_since_feb, $chart_2_avg_purchase_rate_per_month, $chart_2_avg_purchase_rate_per_week, $chart_2_avg_purchase_rate_per_day, $chart_2_avg_purchase_rate_last_day);

//////////////////////////////////////////
////////////// CHART 3 ///////////////////
//////////////////////////////////////////

$month_name_reverse = array_reverse(array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'));
$month_no_reverse = array('12', '11', '10', '09', '08', '07', '06', '05', '04', '03', '02', '01');

$sql = $db->prepare("SELECT FROM_UNIXTIME(T1.AnshDate, '%M') AS Month, SUM(T1.AnshRakba) AS Rakba
                    FROM lm_gata_ebasta T1
                    LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                    WHERE MATCH(T1.Ebasta2) AGAINST (?)
                    AND (T2.Shreni = ? OR T2.Shreni = ?)
                    AND T2.BoardApproved = ?
                    GROUP BY FROM_UNIXTIME(T1.AnshDate, '%m')
                    ");
$sql->bindValue(1, 'file_name');
$sql->bindValue(2, '1-क');
$sql->bindValue(3, '2');
$sql->bindValue(4, 'YES');
$sql->execute();
$chart_3_y_data = array();
$chart_3_y_axis = array();
while ($row = $sql->fetch()) {
    $chart_3_y_data[$row['Month']] = round($row['Rakba']);
}

foreach ($month_name_reverse as $key => $value) {
    $arr_srch_key = array_search($value, $month_name_reverse);
    if (date('m') >= $month_no_reverse[$arr_srch_key]) {
        $chart_3_x_axis[] = $value;
        $chart_3_y_axis[] = $chart_3_y_data[$value];
    }
}

//////////////////////////////////////////
////////////// CHART 4 ///////////////////
//////////////////////////////////////////

$sql = $db->prepare("SELECT MONTH(FROM_UNIXTIME(T1.AnshDate, '%Y-%m-%d')) AS Month, WEEK(FROM_UNIXTIME(T1.AnshDate, '%Y-%m-%d')) - (WEEK(FROM_UNIXTIME(T1.AnshDate, '%Y-%m-01')) - 1) AS Week, SUM(T1.AnshRakba) AS Rakba
                    FROM lm_gata_ebasta T1
                    LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                    WHERE MATCH(T1.Ebasta2) AGAINST (?)
                    AND (T2.Shreni = ? OR T2.Shreni = ?)
                    AND T2.BoardApproved = ?
                    GROUP BY MONTH(FROM_UNIXTIME(T1.AnshDate, '%Y-%m-%d')), WEEK(FROM_UNIXTIME(T1.AnshDate, '%Y-%m-%d'))
                    ORDER BY Month DESC
                    LIMIT 5
                    ");
$sql->bindValue(1, 'file_name');
$sql->bindValue(2, '1-क');
$sql->bindValue(3, '2');
$sql->bindValue(4, 'YES');
$sql->execute();
$week_count = $sql->rowCount();
$chart_4_y_axis = array();
while ($row = $sql->fetch()) {
    $chart_4_y_axis[] = round($row['Rakba']);
}
foreach ($chart_4_y_axis as $key => $value) {
    if ($key == 0) {
        $chart_4_x_axis[] = 'Current week';
    } else if ($key == 1) {
        $chart_4_x_axis[] = 'Last week';
    } else if ($key == 2) {
        $chart_4_x_axis[] = 'Second last week';
    } else if ($key == 3) {
        $chart_4_x_axis[] = 'Third last week';
    } else if ($key == 4) {
        $chart_4_x_axis[] = 'Fourth last week';
    }
}

//////////////////////////////////////////
////////////// CHART 0 ///////////////////
//////////////////////////////////////////

//echo '<pre>';

$sql = $db->prepare("SELECT T1.VillageName, T1.VillageCode
                        FROM lm_village T1
                        WHERE T1.Active = ?
                        ORDER BY T1.VillageName ASC
                        ");
$sql->bindValue(1, 1);
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
while ($row = $sql->fetch()) {
    $village_names[$row['VillageCode']] = $row['VillageName'];
    $village_codes[] = $row['VillageCode'];
}

$placeholders = '';
$qPart = array_fill(0, count_($village_codes), "?");
$placeholders .= implode(",", $qPart);

$sql = $db->prepare("SELECT T1.VillageCode, ROUND(SUM(T1.AnshRakba)) AS AnshRakba
                        FROM lm_gata_ebasta T1
                        LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo
                        WHERE T2.BoardApproved = ?
                        AND (T2.Shreni LIKE ? OR T2.Shreni LIKE ?)
                        AND MATCH(T1.Ebasta2) AGAINST (?)
                        AND T1.VillageCode IN ($placeholders)
                        GROUP BY T1.VillageCode
                        ");
$sql->bindValue(1, 'YES');
$sql->bindValue(2, '5%');
$sql->bindValue(3, '6%');
$sql->bindValue(4, 'file_name');
$i = 5;
foreach ($village_codes as $key => $id) {
    $sql->bindParam($i++, $village_codes[$key]);
}
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
$village_area_resumpted = array();
$village_resumpted_area = array();
while ($row = $sql->fetch()) {
    $village_area_resumpted[$row['VillageCode']] = $row['AnshRakba'];
}

foreach ($village_codes as $key => $value) {
    if ($village_area_resumpted[$value]) {
        $village_resumpted_area[$value] = $village_area_resumpted[$value];
    } else {
        $village_resumpted_area[$value] = 0;
    }
}

$sql = $db->prepare("SELECT T1.VillageCode, ROUND(SUM(T1.AnshRakba)) AS AnshRakba
                        FROM lm_gata_ebasta T1
                        LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo
                        WHERE T2.BoardApproved = ?
                        AND (T2.Shreni = ? OR T2.Shreni = ? OR T2.Shreni LIKE ? OR T2.Shreni LIKE ?)
                        AND MATCH(T1.Ebasta2) AGAINST (?)
                        AND T1.VillageCode IN ($placeholders)
                        GROUP BY T1.VillageCode
                        ");
$sql->bindValue(1, 'YES');
$sql->bindValue(2, '1-क');
$sql->bindValue(3, '2');
$sql->bindValue(4, '5%');
$sql->bindValue(5, '6%');
$sql->bindValue(6, 'file_name');
$i = 7;
foreach ($village_codes as $key => $id) {
    $sql->bindParam($i++, $village_codes[$key]);
}
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
$village_area_acquired = array();
while ($row = $sql->fetch()) {
    $village_area_acquired[$row['VillageCode']] = $row['AnshRakba'];
}

$sql = $db->prepare("SELECT T1.VillageCode, ROUND(SUM(T1.agricultural_area)) AS agricultural_area, ROUND(SUM(T1.road_area)) AS road_area, ROUND(SUM(T1.aabadi_area)) AS aabadi_area
                        FROM lm_gata T1
                        WHERE T1.BoardApproved = ?
                        AND (T1.Shreni = ? OR T1.Shreni = ?)
                        AND T1.VillageCode IN ($placeholders)
                        GROUP BY T1.VillageCode
                        ");
$sql->bindValue(1, 'YES');
$sql->bindValue(2, '1-क');
$sql->bindValue(3, '2');
$i = 4;
foreach ($village_codes as $key => $id) {
    $sql->bindParam($i++, $village_codes[$key]);
}
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
$village_dar_nirdharit_area = array();
while ($row = $sql->fetch()) {
    $village_dar_nirdharit_area[$row['VillageCode']] = ($row['agricultural_area'] + $row['road_area'] + $row['aabadi_area']);
}

$sql = $db->prepare("SELECT T1.VillageCode, ROUND(SUM(T1.Area)) AS Area
                        FROM lm_gata T1
                        WHERE T1.VillageCode IN ($placeholders)
                        GROUP BY T1.VillageCode
                        ");
$i = 1;
foreach ($village_codes as $key => $id) {
    $sql->bindParam($i++, $village_codes[$key]);
}
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
$village_total_area = array();
while ($row = $sql->fetch()) {
    $village_total_area[$row['VillageCode']] = $row['Area'];
}

$village_with_a_percent = array();
$village_with_b_percent = array();
$dar_nirdharit_and_resumpted_area = array();
$chart_0_x_axis = array();
$total_area_of_village = array();
$village_dar_nirdharit_and_resumpted_area = array();
$village_acquired_area = array();
$a_village_percent = array();
$b_village_percent = array();

foreach ($village_codes as $key => $value) {
    $a_percent = $village_total_area[$value] ? round(($village_area_acquired[$value] / $village_total_area[$value]) * 100) : 0;
    if ($a_percent) {
        $village_with_a_percent[$value] = $a_percent;
    } else {
        $village_with_out_a_percent[$value] = 0;
    }
    
    $dar_nirdharit_and_resumpted_area[$value] = $village_dar_nirdharit_area[$value] + $village_resumpted_area[$value];
    $b_percent = $village_total_area[$value] ? round(($dar_nirdharit_and_resumpted_area[$value] / $village_total_area[$value]) * 100) : 0;
    if ($b_percent) {
        $village_with_b_percent[$value] = $b_percent;
    } else {
        $village_with_out_b_percent[$value] = 0;
    }
}
//echo "resumpted area<br>";
//print_r($village_resumpted_area);
//echo "acquired area<br>";
//print_r($village_area_acquired);
//echo "dar nirdharit area<br>";
//print_r($village_dar_nirdharit_area);
//echo "dar nirdharit and resumpted area<br>";
//print_r($dar_nirdharit_and_resumpted_area);
//echo "a percent<br>";
//print_r($village_with_a_percent);
//echo "b percent<br>";
//print_r($village_with_b_percent);

arsort($village_with_b_percent, SORT_NUMERIC);

//echo "sorted b percent<br>";
//print_r($village_with_b_percent);

foreach ($village_with_b_percent as $bkey => $bvalue) {
    $chart_0_x_axis[] = $village_names[$bkey];
    $total_area_of_village[] = $village_total_area[$bkey];
    $village_dar_nirdharit_and_resumpted_area[] = $dar_nirdharit_and_resumpted_area[$bkey];
    $village_acquired_area[] = $village_area_acquired[$bkey];
    $a_village_percent[$village_names[$bkey]] = $village_with_a_percent[$bkey].'%';
    $b_village_percent[$village_names[$bkey]] = $village_with_b_percent[$bkey].'%';
}
