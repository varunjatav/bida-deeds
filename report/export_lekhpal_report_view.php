<?php

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);

include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/lekhpalReportView.core.php';
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

$count = 2;
foreach ($villageInfo as $key => $value) {
    $total_kashtkar = $kashtkar_count_array[$value['VillageCode']] ? $kashtkar_count_array[$value['VillageCode']] : 0;
    $sahmati_uploaded = $sahmati_count_array[$value['VillageCode']] ? $sahmati_count_array[$value['VillageCode']] : 0;
    $bainama_uploaded = $bainama_count_array[$value['VillageCode']] ? $bainama_count_array[$value['VillageCode']] : 0;
    $khatauni_uploaded = $khatauni_count_array[$value['VillageCode']] ? $khatauni_count_array[$value['VillageCode']] : 0;
    $kabza_uploaded = $kabza_count_array[$value['VillageCode']] ? $kabza_count_array[$value['VillageCode']] : 0;
    $total_sahmati_area = $total_sahmati_area_array[$value['VillageCode']]['RequiredArea'] ? $total_sahmati_area_array[$value['VillageCode']]['RequiredArea'] : 0;
    $uploaded_sahmati_area = $uploaded_sahmati_area_array[$value['VillageCode']]['AnshRakba'] ? $uploaded_sahmati_area_array[$value['VillageCode']]['AnshRakba'] : 0;
    $uploaded_bainama_area = $uploaded_bainama_area_array[$value['VillageCode']]['AnshRakba'] ? $uploaded_bainama_area_array[$value['VillageCode']]['AnshRakba'] : 0;
    $uploaded_khatauni_area = $uploaded_khatauni_area_array[$value['VillageCode']]['AnshRakba'] ? $uploaded_khatauni_area_array[$value['VillageCode']]['AnshRakba'] : 0;
    $uploaded_kabza_area = $uploaded_kabza_area_array[$value['VillageCode']]['AnshRakba'] ? $uploaded_kabza_area_array[$value['VillageCode']]['AnshRakba'] : 0;
    $remaining_sahmati_area = $total_sahmati_area - $uploaded_sahmati_area;
    $remaining_bainama_area = $total_sahmati_area - $uploaded_bainama_area;
    $remaining_khatauni_area = $total_sahmati_area - $uploaded_khatauni_area;
    $remaining_kabza_area = $total_sahmati_area - $uploaded_kabza_area;

    $hcount = 0;
    foreach ($column_arr as $colVal) {
        if ($colVal == 0) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $value['VillageName']);
        } else if ($colVal == 1) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $total_kashtkar);
        } else if ($colVal == 2) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $total_sahmati_area);
        } else if ($colVal == 3) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $sahmati_uploaded);
        } else if ($colVal == 4) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $uploaded_sahmati_area);
        } else if ($colVal == 5) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, ($total_kashtkar - $sahmati_uploaded));
        } else if ($colVal == 6) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $remaining_sahmati_area);
        } else if ($colVal == 7) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $bainama_uploaded);
        } else if ($colVal == 8) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $uploaded_bainama_area);
        } else if ($colVal == 9) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, ($total_kashtkar - $bainama_uploaded));
        } else if ($colVal == 10) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $remaining_bainama_area);
        } else if ($colVal == 11) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $khatauni_uploaded);
        } else if ($colVal == 12) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $uploaded_khatauni_area);
        } else if ($colVal == 13) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, ($total_kashtkar - $khatauni_uploaded));
        } else if ($colVal == 14) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $remaining_khatauni_area);
        } else if ($colVal == 15) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $kabza_uploaded);
        } else if ($colVal == 16) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $uploaded_kabza_area);
        } else if ($colVal == 17) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, ($total_kashtkar - $kabza_uploaded));
        } else if ($colVal == 18) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $remaining_kabza_area);
        }
        $hcount++;
    }
    $count++;
}

$target_dir = dirname(dirname(__FILE__)) . "/" . $media_export . "/";
$file_name = 'lekhpal_report_view_' . date('d_m_Y_H_i_s') . '.xlsx';
$filename = $target_dir . $file_name;

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=$filename');
header('Cache-Control: max-age=0');
$db_respose_data = json_encode(array('status' => '1', 'url' => base64_encode($file_name)));
print_r($db_respose_data);
exit();
