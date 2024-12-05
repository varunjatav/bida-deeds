<?php

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/dashboardSummary.core.php';
include_once "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Add headers
$hcount = 0;
$column_head = array('Village Name', 'Remarks');
foreach ($column_head as $colValue) {
    $index = columnFromIndex($hcount);
    $sheet->setCellValue($index . '1', $colValue);
    $hcount++;
}

// Add rows
$count = 2;
if ($dashboard_data == '8') {
    $gata_info = array();
    $gata_prefix_array = array();
    while ($row = $village_acquired->fetch()) {
        $info[] = $row;
    }

    foreach ($info as $infoKey => $infoValue) {
        if (strpos($infoValue['GataNo'], "/")) {
            $gata_prefix = substr($infoValue['GataNo'], 0, strpos($infoValue['GataNo'], "/"));
            if (!in_array($gata_prefix, $gata_prefix_array)) {
                $purchased_gata_count = 0;
                $resumpted_gata_count = 0;
                foreach ($info as $infoKey1 => $infoValue1) {
                    if (strpos($infoValue1['GataNo'], "/")) {
                        if ($gata_prefix == substr($infoValue1['GataNo'], 0, strpos($infoValue1['GataNo'], "/"))) {
                            if ($infoValue1['Shreni'] == '1-क' || $infoValue1['Shreni'] == '2') {
                                $purchased_gata_count++;
                            }
                            if (str_contains($infoValue1['Shreni'], '5') || str_contains($infoValue1['Shreni'], '6')) {
                                $resumpted_gata_count++;
                            }
                        }
                    }
                }
                if ($purchased_gata_count && !$resumpted_gata_count) {
                    $gata_info[$infoValue['VillageName'] . '-' . $gata_prefix] = 'PURCHASED';
                } else if (!$purchased_gata_count && $resumpted_gata_count) {
                    $gata_info[$infoValue['VillageName'] . '-' . $gata_prefix] = 'RESUMPTED';
                } else {
                    $gata_info[$infoValue['VillageName'] . '-' . $gata_prefix] = 'PURCHASED/RESUMPTED';
                }
                $gata_prefix_array[] = $gata_prefix;
            }
        } else {
            $gata_no = preg_replace('/[^A-Za-z0-9\-]/', '', $infoValue['GataNo']);
            if ($infoValue['Shreni'] == '1-क' || $infoValue['Shreni'] == '2') {
                $gata_info[$infoValue['VillageName'] . '-' . $gata_no] = 'PURCHASED';
            } else if (str_contains($infoValue['Shreni'], '5') || str_contains($infoValue['Shreni'], '6')) {
                $gata_info[$infoValue['VillageName'] . '-' . $gata_no] = 'RESUMPTED';
            }
        }
    }
    //print_r($gata_info);

    foreach ($gata_info as $key => $value) {
        $hcount = 0;
        foreach ($column_arr as $colVal) {
            if ($colVal == 0) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $key);
            } else if ($colVal == 1) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $value);
            }
            $hcount++;
        }
        $count++;
    }
}

$target_dir = dirname(dirname(__FILE__)) . "/" . $media_export . "/";
$file_name = 'dashboard_qgis_data.csv';
$filename = $target_dir . $file_name;

$writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
$writer->save($filename);

header('Content-Type: application/vnd.ms-excel');
header('Content-Type: application/csv');
header('Content-Disposition: attachment;filename=$filename');
header('Cache-Control: max-age=0');
$db_respose_data = json_encode(array('status' => '1', 'url' => base64_encode($file_name)));
print_r($db_respose_data);
exit();
