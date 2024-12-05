<?php

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);

include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/exportParisampattiModule.core.php';
include_once "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Add headers
$column_head = array(
    'विभाग नाम', 'गाँव नाम', 'गाटा नम्बर', 'खाता नम्बर', 'वृक्ष नाम', 'उप वृक्ष नाम', 'छोटी संपत्ति नाम', 'संपत्ति नाम',
    'वृक्ष का आयाम', 'एक वृक्ष का मूल्य', 'कुल वृक्षों की संख्या', 'वृक्षों की कुल राशि (सॉफ्टवेर द्वारा)', 'कुल राशि',
);
$hcount = 0;
foreach ($column_head as $colValue) {
    $index = columnFromIndex($hcount);
    $sheet->setCellValue($index . '1', $colValue);
    $sheet->getStyle($index . '1')->getFont()->setBold(false)->setSize(12);
    $hcount++;
}

// Add rows
$count = 2;
while ($row = $parisampatti->fetch()) {
    if ($row['DimensionNumber'] == '1') {
        $dimentionNumber = '0-1';
    } else if ($row['DimensionNumber'] == '2') {
        $dimentionNumber = '1-2';
    } else if ($row['DimensionNumber'] == '3') {
        $dimentionNumber = '2-3';
    } else if ($row['DimensionNumber'] == '4') {
        $dimentionNumber = '3-4';
    } else if ($row['DimensionNumber'] == '5') {
        $dimentionNumber = '4-5';
    } else if ($row['DimensionNumber'] == '6') {
        $dimentionNumber = '5-6';
    } else if ($row['DimensionNumber'] == '7') {
        $dimentionNumber = '6-7';
    } else {
        $dimentionNumber = $row['DimensionNumber'] ? $row['DimensionNumber'] : '--';
    }
    $record = array(
        $row['DepartmentName'] ? $row['DepartmentName'] : '--',
        $row['VillageName'] ? $row['VillageName'] : '--',
        $row['GataNo'] ? $row['GataNo'] : '--',
        $row['KhataNo'] ? $row['KhataNo'] : '--',
        $row['TreeName'] ? $row['TreeName'] : '--',
        $row['SubTreeName'] ? $row['SubTreeName'] : '--',
        $row['MinorPropertyName'] ? $row['MinorPropertyName'] : '--',
        $row['PropertyName'] ? $row['PropertyName'] : '--',
        $dimentionNumber,
        $row['DimensionAmount'] ? $row['DimensionAmount'] : '--',
        $row['TotalDimentsionCount'] ? $row['TotalDimentsionCount'] : '--',
        $row['TotalDimensionAmount'] ? $row['TotalDimensionAmount'] : '--',
        $row['Amount'] ? $row['Amount'] : '--',
    );

    $hcount = 0;
    foreach ($record as $record_index => $data) {
        $sheet->setCellValue(columnFromIndex($record_index) . $count, $data);
    }
    $count++;
}

$target_dir = dirname(dirname(__FILE__)) . "/" . $media_export . "/";
$file_name = 'parisampatti_' . date('d_m_Y_H_i_s') . '.xlsx';
$filename = $target_dir . $file_name;

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=$filename');
header('Cache-Control: max-age=0');
$db_respose_data = json_encode(array('status' => '1', 'url' => base64_encode($file_name)));
print_r($db_respose_data);
exit();
