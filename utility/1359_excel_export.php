<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);

include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once "../vendor/autoload.php";
include_once '../core/permission.core.php';
include_once '../languages/' . $lang_file;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Database query
$sql = "SELECT T1.VillageName, T1.VillageNameHi, T1.VillageCode, 
                 COUNT(T2.GataNo) AS TOTAL_GATA_COUNT, 
                 COUNT(DISTINCT T2.GataNo) AS TOTAL_UNIQUE_GATA_COUNT 
          FROM lm_village T1 
          LEFT JOIN lm_land_data T2 
          ON T2.VillageCode = T1.VillageCode 
          GROUP BY T1.VillageCode";

$stmt = $db->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Add headers
$hcount = 0;
$column_head = array_keys($data[0]);
foreach ($column_head as $colValue) {
    $index = columnFromIndex($hcount);
    $sheet->setCellValue($index . '1', $colValue);
    $hcount++;
}
// Add rows
$count = 2;
foreach ($data as $row) {
    $hcount = 0;
    foreach ($column_head as $colValue) {
        $index = columnFromIndex($hcount);
        $sheet->setCellValue($index . $count, $row[$colValue] ?? '--');
        $hcount++;
    }
    $count++;
}

$target_dir = dirname(__FILE__) . "/exports/";

// Ensure the directory exists
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}
if (!is_writable($target_dir)) {
    die("Error: Folder is not writable.");
}

// Generate the file name
$file_name = 'village_data_' . date('d_m_Y_H_i_s') . '.xlsx';
$filename = $target_dir . $file_name;

try {
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save($filename);
} catch (Exception $e) {
    die("Error saving file: " . $e->getMessage());
}

// Check if file is created
if (!file_exists($filename)) {
    die("Error: File was not created.");
}

// Set headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$file_name\"");
header('Cache-Control: max-age=0');
readfile($filename);
exit();


