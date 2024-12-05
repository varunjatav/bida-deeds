<?php

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);

include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/officeOrderModule.core.php';
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
    $month = $row['OrderMonth'] ? date('M Y', $row['OrderMonth']) : '--';
    $subject = $row['Subject'] ? $row['Subject'] : '--';
    $order_no = $row['EnterOrderNo'] ? $row['EnterOrderNo'] : '--';
    $order_issue_auth = $row['OrderIssueAuthority'] ? $row['OrderIssueAuthority'] : '--';
    $attachment = $row['OrderAttachment'] ? $row['OrderAttachment'] : '--';
    $date_created = $row['DateCreated'] ? date('d-m-Y', $row['DateCreated']) : '--';
    $hcount = 0;
    foreach ($column_arr as $colVal) {
        if ($colVal == 0) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $month);
        } else if ($colVal == 1) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $subject);
        } else if ($colVal == 2) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $order_no);
        } else if ($colVal == 3) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $order_issue_auth);
        } else if ($colVal == 4) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $attachment);
        } else if ($colVal == 5) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $date_created);
        }
        $hcount++;
    }
    $count++;
}

$target_dir = dirname(dirname(__FILE__)) . "/" . $media_export . "/";
$file_name = 'office_order_' . date('d_m_Y_H_i_s') . '.xlsx';
$filename = $target_dir . $file_name;

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=$filename');
header('Cache-Control: max-age=0');
$db_respose_data = json_encode(array('status' => '1', 'url' => base64_encode($file_name)));
print_r($db_respose_data);
exit();
