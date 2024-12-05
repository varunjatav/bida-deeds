<?php

$user_type = $_SESSION['UserType'];
$dashboard_data = $_REQUEST['dashboard_data'];
$village_code = $_REQUEST['village_code'];
$village_name = $_REQUEST['village_name'];
$title = $_REQUEST['title'];
$date_type = $_REQUEST['date_type'];
$year = $_REQUEST['year'];
$chart_sdate = $_REQUEST['chart_sdate'];
$chart_edate = $_REQUEST['chart_edate'];
$sum_on_title = 0;

if ($dashboard_data == '6') {
    if ($date_type == 'last_day') {

        $text = 'Total area acquired till date';
        $last_date = date('Y-m-d', strtotime("-1 days"));

        // create x-axis array
        $x_axis = array($last_date);

        $query = "SELECT FROM_UNIXTIME(T1.AnshDate, '%Y-%m-%d') AS AnshDate, ROUND(SUM(T1.AnshRakba), 4) AS AnshRakba
                                FROM lm_gata_ebasta T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo
                                LEFT JOIN lm_village T3 ON T3.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";

        if ($village_code) {
            $text = 'Total area acquired till date (' . $village_name . ')';
            $query .= " AND T1.VillageCode = ?";
        }
        $query .= " AND T2.BoardApproved = ?
                                AND (T2.Shreni = ? OR T2.Shreni = ? OR T2.Shreni LIKE ? OR T2.Shreni LIKE ?)
                                AND MATCH(T1.Ebasta2) AGAINST (?)
                                AND YEAR(FROM_UNIXTIME(T1.AnshDate, '%Y-%m-%d')) = ?
                                AND FROM_UNIXTIME(T1.AnshDate, '%Y-%m-%d') = ?
                                ";

        $sql = $db->prepare($query);
        $i = 1;
        if ($village_code) {
            $sql->bindValue($i++, $village_code);
        }
        $sql->bindValue($i++, 'YES');
        $sql->bindValue($i++, '1-क');
        $sql->bindValue($i++, '2');
        $sql->bindValue($i++, '5%');
        $sql->bindValue($i++, '6%');
        $sql->bindValue($i++, 'file_name');
        $sql->bindParam($i++, $year);
        $sql->bindParam($i++, $last_date);
        $sql->execute();
        $color = array();
        $row_count = $sql->rowCount();
        while ($row = $sql->fetch()) {
            $info[$row['AnshDate']] = $row['AnshRakba'];
            $sum_on_title += round($row['AnshRakba'], 2);
        }

        // create y-axis array
        $month_arr = $row_count ? array_keys($info) : array();
        foreach ($x_axis as $key => $value) {
            $color[] = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            if (in_array($value, $month_arr)) {
                $y_axis[] = $info[$value];
            } else {
                $y_axis[] = 0;
            }
        }
    } else if ($date_type == 'last_week') {

        $text = 'Total area acquired till date';
        $start_date = date('Y-m-d', strtotime("-7 days"));
        $end_date = date('Y-m-d', time());
        $dates = getAllDates($start_date, $end_date, 'd-m-Y');

        // create x-axis array
        $x_axis = $dates;
        $placeholders = '';
        $qPart = array_fill(0, count_($dates), "?");
        $placeholders .= implode(",", $qPart);

        $query = "SELECT FROM_UNIXTIME(T1.AnshDate, '%Y-%m-%d') AS AnshDate, ROUND(SUM(T1.AnshRakba), 4) AS AnshRakba
                                FROM lm_gata_ebasta T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo
                                LEFT JOIN lm_village T3 ON T3.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";

        if ($village_code) {
            $text = 'Total area acquired till date (' . $village_name . ')';
            $query .= " AND T1.VillageCode = ?";
        }
        $query .= " AND T2.BoardApproved = ?
                                AND (T2.Shreni = ? OR T2.Shreni = ? OR T2.Shreni LIKE ? OR T2.Shreni LIKE ?)
                                AND MATCH(T1.Ebasta2) AGAINST (?)
                                AND YEAR(FROM_UNIXTIME(T1.AnshDate, '%Y-%m-%d')) = ?
                                AND FROM_UNIXTIME(T1.AnshDate, '%Y-%m-%d') IN ($placeholders)
                                GROUP BY FROM_UNIXTIME(T1.AnshDate, '%Y-%m-%d')
                                ";

        $sql = $db->prepare($query);
        $i = 1;
        if ($village_code) {
            $sql->bindValue($i++, $village_code);
        }
        $sql->bindValue($i++, 'YES');
        $sql->bindValue($i++, '1-क');
        $sql->bindValue($i++, '2');
        $sql->bindValue($i++, '5%');
        $sql->bindValue($i++, '6%');
        $sql->bindValue($i++, 'file_name');
        $sql->bindParam($i++, $year);
        foreach ($dates as $key => $id) {
            $sql->bindParam($i++, $dates[$key]);
        }
        $sql->execute();
        $color = array();
        $row_count = $sql->rowCount();
        while ($row = $sql->fetch()) {
            $info[$row['AnshDate']] = $row['AnshRakba'];
            $sum_on_title += round($row['AnshRakba'], 2);
        }

        // create y-axis array
        $month_arr = $row_count ? array_keys($info) : array();
        foreach ($x_axis as $key => $value) {
            $color[] = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            if (in_array($value, $month_arr)) {
                $y_axis[] = $info[$value];
            } else {
                $y_axis[] = 0;
            }
        }
    } else if ($date_type == 'monthly') {

        $text = 'Total area acquired till date';

        // create x-axis array
        $x_axis = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

        $query = "SELECT FROM_UNIXTIME(T1.AnshDate, '%b') AS Month, ROUND(SUM(T1.AnshRakba), 4) AS AnshRakba
                                FROM lm_gata_ebasta T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo
                                LEFT JOIN lm_village T3 ON T3.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";

        if ($village_code) {
            $text = 'Total area acquired till date (' . $village_name . ')';
            $query .= " AND T1.VillageCode = ?";
        }
        $query .= " AND T2.BoardApproved = ?
                                AND (T2.Shreni = ? OR T2.Shreni = ? OR T2.Shreni LIKE ? OR T2.Shreni LIKE ?)
                                AND MATCH(T1.Ebasta2) AGAINST (?)
                                AND YEAR(FROM_UNIXTIME(T1.AnshDate, '%Y-%m-%d')) = ?
                                GROUP BY MONTH(FROM_UNIXTIME(T1.AnshDate, '%Y-%m-%d'))";

        $sql = $db->prepare($query);
        $i = 1;
        if ($village_code) {
            $sql->bindValue($i++, $village_code);
        }
        $sql->bindValue($i++, 'YES');
        $sql->bindValue($i++, '1-क');
        $sql->bindValue($i++, '2');
        $sql->bindValue($i++, '5%');
        $sql->bindValue($i++, '6%');
        $sql->bindValue($i++, 'file_name');
        $sql->bindParam($i++, $year);
        $sql->execute();
        $color = array();
        $row_count = $sql->rowCount();
        while ($row = $sql->fetch()) {
            $info[$row['Month']] = $row['AnshRakba'];
            $sum_on_title += round($row['AnshRakba'], 2);
        }

        // create y-axis array
        $month_arr = $row_count ? array_keys($info) : array();
        foreach ($x_axis as $key => $value) {
            $mnth = $key + 1;
            if ($mnth <= date('m')) {
                $color[] = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
                if (in_array($value, $month_arr)) {
                    $y_axis[] = $info[$value];
                } else {
                    $y_axis[] = 0;
                }
            }
        }
    } else if ($date_type == 'date_range') {

        $text = 'Total area acquired till date';
        $start_date = date('Y-m-d', strtotime($chart_sdate));
        $end_date = date('Y-m-d', strtotime($chart_edate));
        $dates = getAllDates($start_date, $end_date, 'd-m-Y');

        // create x-axis array
        $x_axis = $dates;
        $placeholders = '';
        $qPart = array_fill(0, count_($dates), "?");
        $placeholders .= implode(",", $qPart);

        $query = "SELECT FROM_UNIXTIME(T1.AnshDate, '%Y-%m-%d') AS AnshDate, ROUND(SUM(T1.AnshRakba), 4) AS AnshRakba
                                FROM lm_gata_ebasta T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo
                                LEFT JOIN lm_village T3 ON T3.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ";

        if ($village_code) {
            $text = 'Total area acquired till date (' . $village_name . ')';
            $query .= " AND T1.VillageCode = ?";
        }
        $query .= " AND T2.BoardApproved = ?
                                AND (T2.Shreni = ? OR T2.Shreni = ? OR T2.Shreni LIKE ? OR T2.Shreni LIKE ?)
                                AND MATCH(T1.Ebasta2) AGAINST (?)
                                AND YEAR(FROM_UNIXTIME(T1.AnshDate, '%Y-%m-%d')) = ?
                                AND FROM_UNIXTIME(T1.AnshDate, '%Y-%m-%d') IN ($placeholders)
                                GROUP BY FROM_UNIXTIME(T1.AnshDate, '%Y-%m-%d')
                                ";

        $sql = $db->prepare($query);
        $i = 1;
        if ($village_code) {
            $sql->bindValue($i++, $village_code);
        }
        $sql->bindValue($i++, 'YES');
        $sql->bindValue($i++, '1-क');
        $sql->bindValue($i++, '2');
        $sql->bindValue($i++, '5%');
        $sql->bindValue($i++, '6%');
        $sql->bindValue($i++, 'file_name');
        $sql->bindParam($i++, $year);
        foreach ($dates as $key => $id) {
            $sql->bindParam($i++, $dates[$key]);
        }
        $sql->execute();
        $color = array();
        $row_count = $sql->rowCount();
        while ($row = $sql->fetch()) {
            $info[$row['AnshDate']] = $row['AnshRakba'];
            $sum_on_title += round($row['AnshRakba'], 2);
        }

        // create y-axis array
        $month_arr = $row_count ? array_keys($info) : array();
        foreach ($x_axis as $key => $value) {
            $color[] = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            if (in_array($value, $month_arr)) {
                $y_axis[] = $info[$value];
            } else {
                $y_axis[] = 0;
            }
        }
    }
}