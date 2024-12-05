<?php

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);

include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/bainamaAmount.core.php';
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
while ($row = $sql->fetch()) {
    $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
    $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
    $ansh_rakba = $row['AnshRakba'] ? $row['AnshRakba'] : '--';
    $bainama_date = $row['AnshDate'] ? date('d-m-Y', $row['AnshDate']) : "--";
    $vilekh_sankhya = $row['VilekhSankhya'] ? $row['VilekhSankhya'] : '--';
    $bainama_amount = $row['BainamaAmount'] ? $row['BainamaAmount'] : '--';
    $land_amount = $row['LandAmount'] ? $row['LandAmount'] : '--';
    $parisampatti_amount = $row['ParisampattiAmount'] ? $row['ParisampattiAmount'] : '--';
    $patravali_status = '--';
    if ($row['PatravaliStatus'] == '1') {
        $patravali_status = 'तहसील के पास (Gulab Singh & Lalit)';
    } else if ($row['PatravaliStatus'] == '2') {
        $patravali_status = 'बंधक पत्रावली (RK Shukla)';
    } else if ($row['PatravaliStatus'] == '3') {
        $patravali_status = 'बंजर पत्रावली (Gulab singh & Lalit)';
    } else if ($row['PatravaliStatus'] == '4') {
        $patravali_status = 'तितिम्मा पत्रावली (Lal Krishna)⁠';
    } else if ($row['PatravaliStatus'] == '5') {
        $patravali_status = 'पेमेंट हो चुका';
    } else if ($row['PatravaliStatus'] == '6') {
        $patravali_status = 'SLAO के पास';
    }
    $ebasta_2 = json_decode($row['Ebasta2'], true);
    $file_name = $ebasta_2[0]['file_name'];
    $bainama_area = $row['BainamaArea'] ? $row['BainamaArea'] : 0;
    $payment_amount = $row['PaymentAmount'] ? $row['PaymentAmount'] : 0;
    $payment_approval_date = $row['PaymentDate'] ? date('d-m-Y', $row['PaymentDate']) : "--";

    $hcount = 0;
    foreach ($column_arr as $colVal) {
        if ($colVal == 0) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $village_name);
        } else if ($colVal == 1) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $file_name);
        } else if ($colVal == 2) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $bainama_date);
        } else if ($colVal == 3) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $ansh_rakba);
        } else if ($colVal == 4) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $vilekh_sankhya);
        } else if ($colVal == 5) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $bainama_area);
        } else if ($colVal == 6) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $land_amount);
        } else if ($colVal == 7) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $parisampatti_amount);
        } else if ($colVal == 8) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $bainama_amount);
        } else if ($colVal == 9) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $payment_amount);
        } else if ($colVal == 10) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $payment_approval_date);
        }
        $hcount++;
    }
    $count++;
}

$target_dir = dirname(dirname(__FILE__)) . "/" . $media_export . "/";
$file_name = 'bainama_amount_' . date('d_m_Y_H_i_s') . '.xlsx';
$filename = $target_dir . $file_name;

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=$filename');
header('Cache-Control: max-age=0');
$db_respose_data = json_encode(array('status' => '1', 'url' => base64_encode($file_name)));
print_r($db_respose_data);
exit();
