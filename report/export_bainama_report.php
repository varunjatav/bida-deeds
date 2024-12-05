<?php

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);

include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/bainamaReport.core.php';
include_once "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Add rows
$count = 1;
$srno = 0;

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'ऐसे बैनामे, जहाँ गाटों का दर निर्धारण नहीं हुआ');
$sheet->setCellValue('C' . $count, $answer_28);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'ऐसे बैनामे, जहाँ दर निर्धारण से ज्यादा भुगतान हो गया है');
$sheet->setCellValue('C' . $count, $answer_29);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'ऐसे बैनामे, जहाँ एक ही काश्तकार का एक ही गाटा पर एक से ज्यादा बार बैनामा हुआ है');
$sheet->setCellValue('C' . $count, $answer_30);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'ऐसे बैनामे, जिनमें तितिम्मा हुआ है');
$sheet->setCellValue('C' . $count, $answer_31);

$target_dir = dirname(dirname(__FILE__)) . "/" . $media_export . "/";
$file_name = 'bainama_report_' . date('d_m_Y_H_i_s') . '.xlsx';
$filename = $target_dir . $file_name;

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=$filename');
header('Cache-Control: max-age=0');
$db_respose_data = json_encode(array('status' => '1', 'url' => base64_encode($file_name)));
print_r($db_respose_data);
exit();
