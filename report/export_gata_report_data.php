<?php

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);

include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/gataReport.core.php';
include_once "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Add rows
$count = 1;
$srno = 0;

$sheet->setCellValue('A' . $count, 'Village Name');
$sheet->setCellValue('B' . $count, $gataInfo['VillageName']);

$count++;
$sheet->setCellValue('A' . $count, 'Gata No');
$sheet->setCellValue('B' . $count, $gata_no);

$count++;
$sheet->setCellValue('A' . $count, '');
$sheet->setCellValue('B' . $count, '');
$sheet->setCellValue('C' . $count, '');

$count++;
$sheet->setCellValue('A' . $count, '');
$sheet->setCellValue('B' . $count, '');
$sheet->setCellValue('C' . $count, '');

$count++;
$sheet->setCellValue('A' . $count, 'क्या गाटे का अधिकरण किया जा रहा है ?');
$sheet->setCellValue('B' . $count, $answer_0);

$count++;
$sheet->setCellValue('A' . $count, '');
$sheet->setCellValue('B' . $count, '');
$sheet->setCellValue('C' . $count, '');

$count++;
$sheet->setCellValue('A' . $count, 'क्रo सo');
$sheet->setCellValue('B' . $count, 'गाटे के परीक्षण का बिंदु/सवाल');
$sheet->setCellValue('C' . $count, 'रिजल्ट');
$sheet->setCellValue('D' . $count, 'विवरण');

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'क्या गाटा 1359 फसली खतौनी में उपलब्ध है ?');
$sheet->setCellValue('C' . $count, $answer_1);
$sheet->setCellValue('D' . $count, $answer_info_1);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'क्या गाटा सीएच 41-45 में उपलब्ध है ?');
$sheet->setCellValue('C' . $count, $answer_2);
$sheet->setCellValue('D' . $count, $answer_info_2);

$count++;
$sheet->setCellValue('A' . $count, '');
$sheet->setCellValue('B' . $count, '');
$sheet->setCellValue('C' . $count, '');

$count++;
$sheet->setCellValue('A' . $count, 'क्रo सo');
$sheet->setCellValue('B' . $count, 'गाटे की श्रेणी के संबंध में');
$sheet->setCellValue('C' . $count, 'रिजल्ट');
$sheet->setCellValue('D' . $count, 'विवरण');

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'क्या गाटा 1359 फसली खतौनी के अनुसार सुरक्षित श्रेणी में है ?');
$sheet->setCellValue('C' . $count, $answer_6);
$sheet->setCellValue('D' . $count, $answer_info_6);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'क्या गाटे की वर्तमान श्रेणी सीएच 41-45 के समान हैं ?');
$sheet->setCellValue('C' . $count, $answer_7);
$sheet->setCellValue('D' . $count, $answer_info_7);

$count++;
$sheet->setCellValue('A' . $count, '');
$sheet->setCellValue('B' . $count, '');
$sheet->setCellValue('C' . $count, '');

$count++;
$sheet->setCellValue('A' . $count, 'क्रo सo');
$sheet->setCellValue('B' . $count, 'गाटे की रकबे के संबंध में');
$sheet->setCellValue('C' . $count, 'रिजल्ट');
$sheet->setCellValue('D' . $count, 'विवरण');

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'क्या गाटे का रकबा 1359 फसली खतौनी से अधिक हैं ?');
$sheet->setCellValue('C' . $count, $answer_8);
$sheet->setCellValue('D' . $count, $answer_info_8);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'क्या गाटे का रकबा सीएच 41-45 के रकबे से अधिक हैं ?');
$sheet->setCellValue('C' . $count, $answer_10);
$sheet->setCellValue('D' . $count, $answer_info_10);

$count++;
$sheet->setCellValue('A' . $count, '');
$sheet->setCellValue('B' . $count, '');
$sheet->setCellValue('C' . $count, '');

$count++;
$sheet->setCellValue('A' . $count, 'क्रo सo');
$sheet->setCellValue('B' . $count, 'गाटे के दर निर्धारण के सम्बन्ध में');
$sheet->setCellValue('C' . $count, 'रिजल्ट');
$sheet->setCellValue('D' . $count, 'विवरण');

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'गाटे की कृषि दर क्या निर्धारित की गयी हैं ?');
$sheet->setCellValue('C' . $count, $answer_12);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'गाटे की आबादी दर क्या निर्धारित की गयी हैं ?');
$sheet->setCellValue('C' . $count, $answer_13);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'गाटे की सड़क किनारे की दर क्या निर्धारित की गयी हैं ?');
$sheet->setCellValue('C' . $count, $answer_14);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'क्या गाटे पर एक से अधिक प्रकार की दर निर्धारित की गयी है ?');
$sheet->setCellValue('C' . $count, $answer_15);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'क्या पिछले एक साल की मार्केट रेट गाटे की सर्किल रेट से अधिक है ?');
$sheet->setCellValue('C' . $count, $answer_16);
$sheet->setCellValue('D' . $count, $answer_info_16);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'क्या पिछले दो साल की मार्केट रेट गाटे की सर्किल रेट से अधिक है ?');
$sheet->setCellValue('C' . $count, $answer_17);
$sheet->setCellValue('D' . $count, $answer_info_17);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'क्या गाटे का भूमि मूल्य सर्किल के 4 गुने से अधिक हैं ?');
$sheet->setCellValue('C' . $count, $answer_18);
$sheet->setCellValue('D' . $count, $answer_info_18);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'क्या परिसंपत्तियों का मूल्य कुल भूमि के मूल्य के 10 प्रतिशत से अधिक है ?');
$sheet->setCellValue('C' . $count, $answer_19);
$sheet->setCellValue('D' . $count, $answer_info_19);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'क्या परिसंपत्तियों का मूल्य 10 लाख रुपये से अधिक है ?');
$sheet->setCellValue('C' . $count, $answer_20);
$sheet->setCellValue('D' . $count, $answer_info_20);

$count++;
$sheet->setCellValue('A' . $count, '');
$sheet->setCellValue('B' . $count, '');
$sheet->setCellValue('C' . $count, '');

$count++;
$sheet->setCellValue('A' . $count, 'क्रo सo');
$sheet->setCellValue('B' . $count, 'गाटे के होल्ड करने के सम्बन्ध में');
$sheet->setCellValue('C' . $count, 'रिजल्ट');
$sheet->setCellValue('D' . $count, 'विवरण');

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'क्या गाटा जिलाधिकारी द्वारा प्रेस विज्ञप्ति के पूर्व रोका गया है ?');
$sheet->setCellValue('C' . $count, $answer_21);
$sheet->setCellValue('D' . $count, $answer_info_21);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'क्या गाटा बीडा द्वारा प्रेस विज्ञप्ति से पहले रोका गया है ?');
$sheet->setCellValue('C' . $count, $answer_22);
$sheet->setCellValue('D' . $count, $answer_info_22);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'क्या गाटा दर निर्धारण समिति द्वारा रोका गया है ?');
$sheet->setCellValue('C' . $count, $answer_23);
$sheet->setCellValue('D' . $count, $answer_info_23);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'क्या गाटे का बैनामा बीडा द्वारा दर निर्धारण उपरान्त रोका गया है ?');
$sheet->setCellValue('C' . $count, $answer_24);
$sheet->setCellValue('D' . $count, $answer_info_24);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'क्या गाटा नक्शे पर है, परन्तु मौके पर नहीं है?');
$sheet->setCellValue('C' . $count, $answer_25);
$sheet->setCellValue('D' . $count, $answer_info_25);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'क्या मानचित्र/मौके पर नहर है एवं खतौनी में काश्तकार हैं ?');
$sheet->setCellValue('C' . $count, $answer_26);
$sheet->setCellValue('D' . $count, $answer_info_26);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'क्या मानचित्र/मौके पर सड़क है एवं खतौनी में काश्तकार हैं ?');
$sheet->setCellValue('C' . $count, $answer_27);
$sheet->setCellValue('D' . $count, $answer_info_27);

$count++;
$sheet->setCellValue('A' . $count, '');
$sheet->setCellValue('B' . $count, '');
$sheet->setCellValue('C' . $count, '');

$count++;
$sheet->setCellValue('A' . $count, 'क्रo सo');
$sheet->setCellValue('B' . $count, 'अन्य बिन्दु');
$sheet->setCellValue('C' . $count, 'रिजल्ट');
$sheet->setCellValue('D' . $count, 'विवरण');

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'गाटे पर कुल वृक्ष कितने है ?');
$sheet->setCellValue('C' . $count, $answer_28);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, ' गाटा पर परिसम्पत्तियाँ क्या-क्या है?');
$sheet->setCellValue('C' . $count, $answer_29);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'क्या एग्री स्टेक के अनुसार मौके पर फसल हैं ?');
$sheet->setCellValue('C' . $count, $answer_5);

$count++;
$srno++;
$sheet->setCellValue('A' . $count, $srno);
$sheet->setCellValue('B' . $count, 'क्या भूमि बंधक है ?');
$sheet->setCellValue('C' . $count, $answer_30);


$target_dir = dirname(dirname(__FILE__)) . "/" . $media_export . "/";
$file_name = 'gata_report_' . date('d_m_Y_H_i_s') . '.xlsx';
$filename = $target_dir . $file_name;

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=$filename');
header('Cache-Control: max-age=0');
$db_respose_data = json_encode(array('status' => '1', 'url' => base64_encode($file_name)));
print_r($db_respose_data);
exit();
