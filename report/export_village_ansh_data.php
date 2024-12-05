<?php

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);

include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/ebasta.core.php';
include_once "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Add headers
$column_head = array('Shreni', 'Gata No', 'Area', 'Khata No', 'Owner No', 'Owner Name', 'Owner Father', 'Ansh', 'Rakba', 'Bainama Date', 'Bainama/Document Uploaded', 'Vilekh Sankhya');
$hcount = 0;
foreach ($column_head as $colValue) {
    $index = columnFromIndex($hcount);
    $sheet->setCellValue($index . '1', $colValue);
    $hcount++;
}
// Add rows
$count = 2;

foreach ($ebastaInfo as $key => $row) {
    $hcount = 0;
    $khata_no = $row['KhataNo'] ? $row['KhataNo'] : '--';
    $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
    $area = $row['Area'] ? $row['Area'] : '--';
    $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
    $owner_no = $row['OwnerNo'] ? $row['OwnerNo'] : '--';
    $owner_name = $row['owner_name'] ? $row['owner_name'] : '--';
    $owner_father = $row['owner_father'] ? $row['owner_father'] : '--';
    $ansh = $row['KashtkarAnsh'] ? $row['KashtkarAnsh'] : '--';
    $ansh_rakba = $row['AnshRakba'] ? $row['AnshRakba'] : '--';
    $ansh_date = $row['AnshDate'] ? date('d-m-Y', $row['AnshDate']) : '--';
    $document = $row['Ebasta2'] ? 'YES' : 'NO';
    $vilekh_sankhya = $row['VilekhSankhya'] ? $row['VilekhSankhya'] : '';

    $index = columnFromIndex($hcount);
    $sheet->setCellValue($index . $count, $shreni);

    $hcount++;
    $index = columnFromIndex($hcount);
    $sheet->setCellValue($index . $count, $gata_no);

    $hcount++;
    $index = columnFromIndex($hcount);
    $sheet->setCellValue($index . $count, $area);

    $hcount++;
    $index = columnFromIndex($hcount);
    $sheet->setCellValue($index . $count, $khata_no);

    $hcount++;
    $index = columnFromIndex($hcount);
    $sheet->setCellValue($index . $count, $owner_no);

    $hcount++;
    $index = columnFromIndex($hcount);
    $sheet->setCellValue($index . $count, $owner_name);

    $hcount++;
    $index = columnFromIndex($hcount);
    $sheet->setCellValue($index . $count, $owner_father);

    $hcount++;
    $index = columnFromIndex($hcount);
    $sheet->setCellValue($index . $count, $ansh);

    $hcount++;
    $index = columnFromIndex($hcount);
    $sheet->setCellValue($index . $count, $ansh_rakba);

    $hcount++;
    $index = columnFromIndex($hcount);
    $sheet->setCellValue($index . $count, $ansh_date);

    $hcount++;
    $index = columnFromIndex($hcount);
    $sheet->setCellValue($index . $count, $document);

    $hcount++;
    $index = columnFromIndex($hcount);
    $sheet->setCellValue($index . $count, $vilekh_sankhya);

    $count++;
}

$target_dir = dirname(dirname(__FILE__)) . "/" . $media_export . "/";
$file_name = $village_name . '_kastkar_ansh_' . date('d_m_Y_H_i_s') . '.xlsx';
$filename = $target_dir . $file_name;

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=$filename');
header('Cache-Control: max-age=0');
$db_respose_data = json_encode(array('status' => '1', 'url' => base64_encode($file_name)));
print_r($db_respose_data);
exit();
