<?php

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);

include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/gridVillageReport.core.php';
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

$srno = 0;
$point_1_total = 0;
$point_2_total = 0;
$count = 2;
foreach ($villageInfo as $vKey => $vValue) {
    $srno++;
    for ($j = 1; $j < 27; $j++) {
        ${"point_" . $j . "_total"} += (float) ${"point_" . $j}[$vValue['VillageCode']];
    }

    $hcount = 0;
    foreach ($column_arr as $colVal) {
        if ($colVal == 0) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $vValue['VillageName']);
        } else if ($colVal == 1) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $vValue['VillageCode']);
        } else if ($colVal == 2) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $point_1[$vValue['VillageCode']]);
        } else if ($colVal == 3) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $point_2[$vValue['VillageCode']]);
        } else if ($colVal == 4) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $point_3[$vValue['VillageCode']]);
        } else if ($colVal == 5) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $point_4[$vValue['VillageCode']]);
        } else if ($colVal == 6) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $point_5[$vValue['VillageCode']]);
        } else if ($colVal == 7) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $point_6[$vValue['VillageCode']]);
        } else if ($colVal == 8) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $point_7[$vValue['VillageCode']]);
        } else if ($colVal == 9) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $point_8[$vValue['VillageCode']]);
        } else if ($colVal == 10) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $point_9[$vValue['VillageCode']]);
        } else if ($colVal == 11) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $point_10[$vValue['VillageCode']]);
        } else if ($colVal == 12) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $point_11[$vValue['VillageCode']]);
        } else if ($colVal == 13) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $point_12[$vValue['VillageCode']]);
        } else if ($colVal == 14) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $point_13[$vValue['VillageCode']]);
        } else if ($colVal == 15) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $point_14[$vValue['VillageCode']]);
        } else if ($colVal == 16) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $point_15[$vValue['VillageCode']]);
        } else if ($colVal == 17) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $point_16[$vValue['VillageCode']]);
        } else if ($colVal == 18) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $point_17[$vValue['VillageCode']]);
        } else if ($colVal == 19) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $point_18[$vValue['VillageCode']]);
        } else if ($colVal == 20) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $point_19[$vValue['VillageCode']]);
        } else if ($colVal == 21) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $point_20[$vValue['VillageCode']]);
        } else if ($colVal == 22) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $point_21[$vValue['VillageCode']]);
        } else if ($colVal == 23) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $point_22[$vValue['VillageCode']]);
        } else if ($colVal == 24) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $point_23[$vValue['VillageCode']]);
        } else if ($colVal == 25) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $point_24[$vValue['VillageCode']]);
        } else if ($colVal == 26) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $point_25[$vValue['VillageCode']]);
        } else if ($colVal == 27) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $point_26[$vValue['VillageCode']]);
        }
        $hcount++;
    }
    $count++;
}
$count++;

$hcount = 0;
$index = columnFromIndex($hcount);
$sheet->setCellValue($index . $count, 'Total');
$hcount++;

$index = columnFromIndex($hcount);
$sheet->setCellValue($index . $count, '');
$hcount++;

for ($j = 1; $j < 27; $j++) {
    $index = columnFromIndex($hcount);
    $sheet->setCellValue($index . $count, ${"point_" . $j . "_total"});
    $hcount++;
}

$target_dir = dirname(dirname(__FILE__)) . "/" . $media_export . "/";
$file_name = 'grid_village_report_' . date('d_m_Y_H_i_s') . '.xlsx';
$filename = $target_dir . $file_name;

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=$filename');
header('Cache-Control: max-age=0');
$db_respose_data = json_encode(array('status' => '1', 'url' => base64_encode($file_name)));
print_r($db_respose_data);
exit();
