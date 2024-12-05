<?php

$user_id = $_SESSION['UserID'];
$user_type = $_SESSION['UserType'];
$report_type = $_POST['report_type'];

if ($report_type == '1') {
    $repo_query = $db->prepare("SELECT T1.ReportDate
                                FROM lm_village_sahmati_report T1
                                GROUP BY T1.ReportDate
                                ORDER BY T1.ReportDate DESC
                                ");
    $repo_query->execute();
    $repo_query->setFetchMode(PDO::FETCH_ASSOC);
    $row_count = $repo_query->rowCount();
    while ($row = $repo_query->fetch()) {
        $reportDates[] = $row['ReportDate'];
    }
} else if ($report_type == '2') {
    $repo_query = $db->prepare("SELECT T1.ReportDate
                                FROM lm_village_bainama_report T1
                                GROUP BY T1.ReportDate
                                ORDER BY T1.ReportDate DESC
                                ");
    $repo_query->execute();
    $row_count = $repo_query->rowCount();
    $repo_query->setFetchMode(PDO::FETCH_ASSOC);
    while ($row = $repo_query->fetch()) {
        $reportDates[] = $row['ReportDate'];
    }
} else if ($report_type == '3') {
    $repo_query = $db->prepare("SELECT T1.ReportDate
                                FROM lm_village_khatauni_report T1
                                GROUP BY T1.ReportDate
                                ORDER BY T1.ReportDate DESC
                                ");
    $repo_query->execute();
    $row_count = $repo_query->rowCount();
    $repo_query->setFetchMode(PDO::FETCH_ASSOC);
    while ($row = $repo_query->fetch()) {
        $reportDates[] = $row['ReportDate'];
    }
} else if ($report_type == '4') {
    $repo_query = $db->prepare("SELECT T1.ReportDate
                                FROM lm_village_dhanrashi_report T1
                                GROUP BY T1.ReportDate
                                ORDER BY T1.ReportDate DESC
                                ");
    $repo_query->execute();
    $row_count = $repo_query->rowCount();
    $repo_query->setFetchMode(PDO::FETCH_ASSOC);
    while ($row = $repo_query->fetch()) {
        $reportDates[] = $row['ReportDate'];
    }
} else if ($report_type == '5') {
    $repo_query = $db->prepare("SELECT T1.ReportDate
                                FROM lm_village_kabja_report T1
                                GROUP BY T1.ReportDate
                                ORDER BY T1.ReportDate DESC
                                ");
    $repo_query->execute();
    $row_count = $repo_query->rowCount();
    $repo_query->setFetchMode(PDO::FETCH_ASSOC);
    while ($row = $repo_query->fetch()) {
        $reportDates[] = $row['ReportDate'];
    }
}