<?php

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);

include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/grievances.core.php';
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
    $status = 'Pending';
    $color = '';
    if ($row['Status'] == '1') {
        $status = 'Solved';
        $color = 'row-highlight-green';
    }
    $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
    $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
    $khata_no = $row['KhataNo'] ? $row['KhataNo'] : '--';
    $area = $row['Area'] ? $row['Area'] : '--';
    $mobile = $row['Area'] ? $row['Mobile'] : '--';
    $owner_name = $row['owner_name'] ? $row['owner_name'] : '--';
    $grievance = $row['Grievance'] ? $row['Grievance'] : '--';
    $remarks = $row['Remarks'] ? $row['Remarks'] : '--';
    $attachment = $row['Attachment'] ? $row['Attachment'] : '--';
    $mode = $row['Mode'] == '1' ? 'Offline' : 'Online';
    $offline_attachment = $row['OfflineAttachment'] ? $row['OfflineAttachment'] : '--';
    $hcount = 0;
    foreach ($column_arr as $colVal) {
        if ($colVal == 0) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $srno);
        } else if ($colVal == 1) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $village_name);
        } else if ($colVal == 2) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $gata_no);
        } else if ($colVal == 3) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $khata_no);
        } else if ($colVal == 4) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $area);
        } else if ($colVal == 5) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $mobile);
        } else if ($colVal == 6) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $owner_name);
        } else if ($colVal == 7) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $grievance);
        } else if ($colVal == 8) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, date('d-m-Y g:i A', $row['DateCreated']));
        } else if ($colVal == 9) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $status);
        } else if ($colVal == 10) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $attachment);
        } else if ($colVal == 11) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $remarks);
        } else if ($colVal == 12) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $mode);
        } else if ($colVal == 13) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $offline_attachment);
        }
        $hcount++;
    }
    $count++;
}

$target_dir = dirname(dirname(__FILE__)) . "/" . $media_export . "/";
$file_name = 'grievances_' . date('d_m_Y_H_i_s') . '.xlsx';
$filename = $target_dir . $file_name;

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=$filename');
header('Cache-Control: max-age=0');
$db_respose_data = json_encode(array('status' => '1', 'url' => base64_encode($file_name)));
print_r($db_respose_data);
exit();
