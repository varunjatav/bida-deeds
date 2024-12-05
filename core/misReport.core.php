<?php

$user_id = $_SESSION['UserID'];
$user_type = $_SESSION['UserType'];
$report_type = $_POST['report_type'];
$report_date = date('Y-m-d', strtotime($_POST['mis_date']));
$column_arr = array();
$column_head = array();

$column_arr = explode(',', $_REQUEST['column_arr']);
$column_head = explode(',', $_REQUEST['column_head']);

if ($report_type == '1') {
    $repo_query = $db->prepare("SELECT T1.VillageCode, T1.Report
                                FROM lm_village_sahmati_report T1
                                WHERE T1.ReportDate = ?
                                ");
    $repo_query->bindParam(1, $report_date);
    $repo_query->execute();
    $repo_query->setFetchMode(PDO::FETCH_ASSOC);
    while ($row = $repo_query->fetch()) {
        $reportInfo[$row['VillageCode']] = $row;
    }
} else if ($report_type == '2') {
    $repo_query = $db->prepare("SELECT T1.VillageCode, T1.Report
                                FROM lm_village_bainama_report T1
                                WHERE T1.ReportDate = ?
                                ");
    $repo_query->bindParam(1, $report_date);
    $repo_query->execute();
    $repo_query->setFetchMode(PDO::FETCH_ASSOC);
    while ($row = $repo_query->fetch()) {
        $reportInfo[$row['VillageCode']] = $row;
    }
} else if ($report_type == '3') {
    $repo_query = $db->prepare("SELECT T1.VillageCode, T1.Report
                                FROM lm_village_khatauni_report T1
                                WHERE T1.ReportDate = ?
                                ");
    $repo_query->bindParam(1, $report_date);
    $repo_query->execute();
    $repo_query->setFetchMode(PDO::FETCH_ASSOC);
    while ($row = $repo_query->fetch()) {
        $reportInfo[$row['VillageCode']] = $row;
    }
} else if ($report_type == '4') {
    $repo_query = $db->prepare("SELECT T1.VillageCode, T1.Report
                                FROM lm_village_dhanrashi_report T1
                                WHERE T1.ReportDate = ?
                                ");
    $repo_query->bindParam(1, $report_date);
    $repo_query->execute();
    $repo_query->setFetchMode(PDO::FETCH_ASSOC);
    while ($row = $repo_query->fetch()) {
        $reportInfo[$row['VillageCode']] = $row;
    }
} else if ($report_type == '5') {
    $repo_query = $db->prepare("SELECT T1.VillageCode, T1.Report
                                FROM lm_village_kabja_report T1
                                WHERE T1.ReportDate = ?
                                ");
    $repo_query->bindParam(1, $report_date);
    $repo_query->execute();
    $repo_query->setFetchMode(PDO::FETCH_ASSOC);
    while ($row = $repo_query->fetch()) {
        $reportInfo[$row['VillageCode']] = $row;
    }
}