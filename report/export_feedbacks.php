<?php

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);

include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/feedbacks.core.php';
include_once "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Add headers
$hcount = 0;
foreach ($column_head as $colValue) {
    $index = columnFromIndex($hcount);
    $sheet->setCellValue($index . '1', $colValue);
    $hcount++;
}

// Add rows
$count = 2;
$srno = 0;
while ($row = $sql->fetch()) {
    $srno++;
    $resource_type = '';
    $report_type = '';
    $village_name = '--';
    $gata_no = '--';
    $report_no = '--';
    if ($row['ResourceType'] == '1') {
        $resource_type = 'DASHBOARD';
    } else if ($row['ResourceType'] == '2') {
        $resource_type = 'SYNC DATA';
    } else if ($row['ResourceType'] == '3') {
        $resource_type = 'E-BASTA';
    } else if ($row['ResourceType'] == '4') {
        $resource_type = 'REPORTS';
    } else if ($row['ResourceType'] == '5') {
        $resource_type = 'MIS DASHBOARD';
    } else if ($row['ResourceType'] == '6') {
        $resource_type = 'MIS REPORTS';
    }
    if ($row['ReportType'] == 'village_wise') {
        $report_type = 'Village Wise';
    } else if ($row['ReportType'] == 'gata_wise') {
        $report_type = 'Gata Wise';
    } else if ($row['ReportType'] == 'dashboard_data') {
        $report_type = 'Dashboard Data';
    } else if ($row['ReportType'] == 'sync_data') {
        $report_type = 'Sync Data';
    } else if ($row['ReportType'] == 'mis_dashboard') {
        $report_type = 'MIS Dahshboard';
    } else if ($row['ReportType'] == 'mis_report') {
        if ($row['ReportNo'] == '1') {
            $report_type = 'Sehmati';
        } else if ($row['ReportNo'] == '2') {
            $report_type = 'Bainama';
        } else if ($row['ReportNo'] == '3') {
            $report_type = 'Khatauni';
        } else if ($row['ReportNo'] == '4') {
            $report_type = 'Kabza';
        } else if ($row['ReportNo'] == '5') {
            $report_type = 'Dhanrashi';
        }
    }
    if ($row['Feedback'] == '1') {
        $feedback = 'YES';
    } else {
        $feedback = 'NO';
    }
    $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
    $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
    $report_no = $row['ReportNo'] ? $row['ReportNo'] : '--';
    $remarks = $row['Remarks'] ? $row['Remarks'] : '--';
    $hcount = 0;
    foreach ($column_arr as $colVal) {
        if ($colVal == 0) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $srno);
        } else if ($colVal == 1) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $resource_type);
        } else if ($colVal == 2) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $report_type);
        } else if ($colVal == 3) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $village_name);
        } else if ($colVal == 4) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $gata_no);
        } else if ($colVal == 5) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $report_no);
        } else if ($colVal == 6) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $feedback);
        } else if ($colVal == 7) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, date('d-m-Y g:i A', $row['DateCreated']));
        } else if ($colVal == 8) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $remarks);
        }
        $hcount++;
    }
    $count++;
}

$target_dir = dirname(dirname(__FILE__)) . "/" . $media_export . "/";
$file_name = 'feedbacks_' . date('d_m_Y_H_i_s') . '.xlsx';
$filename = $target_dir . $file_name;

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=$filename');
header('Cache-Control: max-age=0');
$db_respose_data = json_encode(array('status' => '1', 'url' => base64_encode($file_name)));
print_r($db_respose_data);
exit();
