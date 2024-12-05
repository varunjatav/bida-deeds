<?php

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);

include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once "../vendor/autoload.php";
include_once '../core/permission.core.php';
include_once '../core/landDataList.core.php';
include_once '../languages/' . $lang_file;

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
$serial_number = 1;
while ($row = $sql->fetch()) {
    $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
    $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
    $khata_no = $row['KhataNo'] ? $row['KhataNo'] : '--';
    $area = $row['Area'] ? $row['Area'] : '--';
    $rakba_h = $row['RakbaH'] ? $row['RakbaH'] : '--';
    $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
    $mahal_ka_name = $row['MahalKaName'] ? $row['MahalKaName'] : '--';
    $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
    $kashtkar_darj_stithi = $row['KashtkarDarjStithi'] ? $row['KashtkarDarjStithi'] : '--';
    $unique_id = $row['UniqueID'] ? $row['UniqueID'] : '--';
    $vivran = $row['Vivran'] ? $row['Vivran'] : '--';

    $hcount = 0;
    foreach ($column_arr as $colVal) {
        if ($colVal == 0) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $serial_number);
        } else if ($colVal == 1) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $village_name);
        } else if ($colVal == 2) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $mahal_ka_name);
        } else if ($colVal == 3) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $shreni);
        } else if ($colVal == 4) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $khata_no);
        } else if ($colVal == 5) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $kashtkar_darj_stithi);
        } else if ($colVal == 6) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $gata_no);
        } else if ($colVal == 7) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $area);
        } else if ($colVal == 8) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $rakba_h);
        } else if ($colVal == 9) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $vivran);
        }
        $hcount++;
    }
    $count++;
    $serial_number++;
}

$target_dir = dirname(dirname(__FILE__)) . "/" . $media_export . "/";
$file_name = 'all_master_data_' . date('d_m_Y_H_i_s') . '.xlsx';
$filename = $target_dir . $file_name;

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=$filename');
header('Cache-Control: max-age=0');
$db_respose_data = json_encode(array('status' => '1', 'url' => base64_encode($file_name)));
print_r($db_respose_data);
exit();
