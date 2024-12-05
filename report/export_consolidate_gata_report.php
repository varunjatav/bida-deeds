<?php

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);

include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/consolidateGataReport.core.php';
include_once "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Add rows
$count = 1;
$srno = 0;

$count++;
$sheet->setCellValue('A' . $count, 'क्रo सo');
$sheet->setCellValue('B' . $count, 'गाटे के परीक्षण का बिंदु/सवाल');
$sheet->setCellValue('C' . $count, 'रिजल्ट');

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'कितने गाटे 1359 फसली खतौनी में उपलब्ध नहीं है ?');
$sheet->setCellValue('C' . $count, $answer_1);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'कितने गाटे सीएच 41-45 में उपलब्ध नहीं है ?');
$sheet->setCellValue('C' . $count, $answer_2);

$count++;
$sheet->setCellValue('A' . $count, '');
$sheet->setCellValue('B' . $count, '');
$sheet->setCellValue('C' . $count, '');

$count++;
$sheet->setCellValue('A' . $count, 'क्रo सo');
$sheet->setCellValue('B' . $count, 'गाटे की श्रेणी के संबंध में');
$sheet->setCellValue('C' . $count, 'रिजल्ट');

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'ऐसे गाटो की संख्या जो 1359 फसली खसरे के अनुसर सुरक्षित श्रेणि में है');
$sheet->setCellValue('C' . $count, $answer_6);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'ऐसे गाटो की संख्या जिनकी वर्तमान श्रेनी सीएच 41-45 के समान नहीं है');
$sheet->setCellValue('C' . $count, $answer_7);

$count++;
$sheet->setCellValue('A' . $count, '');
$sheet->setCellValue('B' . $count, '');
$sheet->setCellValue('C' . $count, '');

$count++;
$sheet->setCellValue('A' . $count, 'क्रo सo');
$sheet->setCellValue('B' . $count, 'गाटे की रकबे के संबंध में');
$sheet->setCellValue('C' . $count, 'रिजल्ट');

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'ऐसे गाटो की संख्या जिनका वर्तमान रकबा 1359 फसली के रकबे के बराबर नहीं है');
$sheet->setCellValue('C' . $count, $answer_8);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'ऐसे गाटो की संख्या जिनका वर्तमान रकबा सीएच 41-45 के रकबे के बराबर नहीं है');
$sheet->setCellValue('C' . $count, $answer_10);

$count++;
$sheet->setCellValue('A' . $count, '');
$sheet->setCellValue('B' . $count, '');
$sheet->setCellValue('C' . $count, '');

$count++;
$sheet->setCellValue('A' . $count, 'क्रo सo');
$sheet->setCellValue('B' . $count, 'गाटे के दर निर्धारण के सम्बन्ध में');
$sheet->setCellValue('C' . $count, 'रिजल्ट');

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'ऐसे गाटो की संख्या जहां कृषि दर निर्धारित नहीं की गई है');
$sheet->setCellValue('C' . $count, $answer_12);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'ऐसे गाटो की संख्या जहां आबादी दर निर्धारित नहीं की गई है');
$sheet->setCellValue('C' . $count, $answer_13);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'ऐसे गाटो की संख्या जहां सड़क किनारे की दर निर्धारित नहीं की गई है');
$sheet->setCellValue('C' . $count, $answer_14);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'ऐसे गाटो की संख्या जहां एक से अधिक प्रकार की दर निर्धारित की गई है');
$sheet->setCellValue('C' . $count, $answer_15);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'ऐसे गाटो की संख्या जहां पिछले एक साल की मार्केट रेट गाटे की सर्कल रेट अधिक है');
$sheet->setCellValue('C' . $count, $answer_16);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'ऐसे गाटो की संख्या जहां पिछले दो साल में सर्किल रेट अधिक है');
$sheet->setCellValue('C' . $count, $answer_17);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'ऐसे गाटो की संख्या जहां गाटे का भूमि मूल्य सर्किल रेट के चार गुने से अधिक है');
$sheet->setCellValue('C' . $count, $answer_18);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'ऐसे गाटो की संख्या जहां परिसम्पत्तियों का मुल्य कुल भूमि के मुल्य के 10 प्रतिषत से अधिक है');
$sheet->setCellValue('C' . $count, $answer_19);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'ऐसे गाटो की संख्या जहां परिसम्पत्तियों का मूल्य 10 लाख रूपये से अधिक है');
$sheet->setCellValue('C' . $count, $answer_20);

$count++;
$sheet->setCellValue('A' . $count, '');
$sheet->setCellValue('B' . $count, '');
$sheet->setCellValue('C' . $count, '');

$count++;
$sheet->setCellValue('A' . $count, 'क्रo सo');
$sheet->setCellValue('B' . $count, 'गाटे के होल्ड करने के सम्बन्ध में');
$sheet->setCellValue('C' . $count, 'रिजल्ट');

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'ऐसे गाटो की संख्या जिन्हे जिलाधिकरी द्वार विज्ञपति से पहले रोका गया है');
$sheet->setCellValue('C' . $count, $answer_21);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'ऐसे गाटो की संख्या जिन्हे बीड़ा द्वार प्रेस विज्ञपति से पूर्व रोका गया है');
$sheet->setCellValue('C' . $count, $answer_22);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'ऐसे गाटो की संख्या जिन्हे दर निर्धारण समिति द्वारा रोका गया है');
$sheet->setCellValue('C' . $count, $answer_23);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'ऐसे गाटो की संख्या जिनका बैनामा बीड़ा द्वार दर निर्धारण के उपरान्त रोका गया है');
$sheet->setCellValue('C' . $count, $answer_24);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'ऐसे गाटो की संख्या जो नक्शे पर है परंतु मौके पर नहीं है');
$sheet->setCellValue('C' . $count, $answer_25);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'ऐसे गाटो की संख्या जो मानचित्र/मौके पर नहर है परंतु खतौनी में काश्तकार के नाम दर्ज है');
$sheet->setCellValue('C' . $count, $answer_26);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'ऐसे गाटो की संख्या जो मानचित्र/मौके पर सड़क है परंतु खतौनी में काश्तकार के नाम दर्ज हैं');
$sheet->setCellValue('C' . $count, $answer_27);

$target_dir = dirname(dirname(__FILE__)) . "/" . $media_export . "/";
$file_name = 'consolidate_gata_report_' . date('d_m_Y_H_i_s') . '.xlsx';
$filename = $target_dir . $file_name;

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=$filename');
header('Cache-Control: max-age=0');
$db_respose_data = json_encode(array('status' => '1', 'url' => base64_encode($file_name)));
print_r($db_respose_data);
exit();
