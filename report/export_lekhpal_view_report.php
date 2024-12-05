<?php

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);

include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/viewLekhpalReport.core.php';
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
while ($row = $sql->fetch()) {
    $ebasta_1 = json_decode($row['Ebasta1'], true);
    $sahmati_file_name = $ebasta_1[0]['file_name'];
    $ebasta_2 = json_decode($row['Ebasta2'], true);
    $bainama_file_name = $ebasta_2[0]['file_name'];
    $ebasta_3 = json_decode($row['Ebasta3'], true);
    $khatauni_file_name = $ebasta_3[0]['file_name'];
    $ebasta_4 = json_decode($row['Ebasta4'], true);
    $kabza_file_name = $ebasta_4[0]['file_name'];

    $hcount = 0;
    foreach ($column_arr as $colVal) {
        if ($colVal == 0) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $row['GataNo']);
        } else if ($colVal == 1) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $row['KhataNo']);
        } else if ($colVal == 2) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $row['owner_name']);
        } else if ($colVal == 3) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $row['owner_father']);
        } else if ($colVal == 4) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $sahmati_file_name);
        } else if ($colVal == 5) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $bainama_file_name);
        } else if ($colVal == 6) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $khatauni_file_name);
        } else if ($colVal == 7) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $kabza_file_name);
        }
        $hcount++;
    }
    $count++;
}

$target_dir = dirname(dirname(__FILE__)) . "/" . $media_export . "/";
$file_name = 'lekhpal_view_report_' . date('d_m_Y_H_i_s') . '.xlsx';
$filename = $target_dir . $file_name;

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=$filename');
header('Cache-Control: max-age=0');
$db_respose_data = json_encode(array('status' => '1', 'url' => base64_encode($file_name)));
print_r($db_respose_data);
exit();
