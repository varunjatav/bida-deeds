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
include_once '../core/fileDataList.core.php';
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
    $name = $row['Name'] ? $row['Name'] : '--';
    $mobile = $row['Mobile'] ? $row['Mobile'] : '--';
    $gender = $row['Gender'] ? $row['Gender'] : '--';
    $dob = $row['DOB'] ? $row['DOB'] : '--';
    $email = $row['Email'] ? $row['Email'] : '--';
    $pan = $row['Pan'] ? $row['Pan'] : '--';
    $adhaar = $row['Adhaar'] ? $row['Adhaar'] : '--';
    $address = $row['Address'] ? $row['Address'] : '--';
    $city = $row['City'] ? $row['City'] : '--';
    $pincode = $row['PinCode'] ? $row['PinCode'] : '--';
    $document = $row['Document'] ? $row['Document'] : '--';
    $profile = $row['Profile'] ? $row['Profile'] : '--';
    $branch = $row['Branch'] ? $row['Branch'] : '--';

    $hcount = 0;
    foreach ($column_arr as $colVal) {
        if ($colVal == 0) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $serial_number);
        } else if ($colVal == 1) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $name);
        } else if ($colVal == 2) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $mobile);
        } else if ($colVal == 3) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $gender);
        } else if ($colVal == 4) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $dob);
        } else if ($colVal == 5) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $email);
        } else if ($colVal == 6) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $pan);
        } else if ($colVal == 7) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $adhaar);
        } else if ($colVal == 8) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $address);
        } else if ($colVal == 9) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $city);
        }
        else if ($colVal == 10) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $pincode);
        }
        else if ($colVal == 11) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $document);
        }
        else if ($colVal == 12) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $profile);
        }
        else if ($colVal == 13) {
            $index = columnFromIndex($hcount);
            $sheet->setCellValue($index . $count, $branch);
        }
        $hcount++;
    }
    $count++;
    $serial_number++;
}

$target_dir = dirname(dirname(__FILE__)) . "/" . $media_export . "/";
$file_name = 'all_user_data_and_documents' . date('d_m_Y_H_i_s') . '.xlsx';
$filename = $target_dir . $file_name;

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=$filename');
header('Cache-Control: max-age=0');
$db_respose_data = json_encode(array('status' => '1', 'url' => base64_encode($file_name)));
print_r($db_respose_data);
exit();
