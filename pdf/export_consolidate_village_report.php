<?php

require('main-pdf.php');
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/consolidateVillageReport.core.php';
require_once('tcpdf/examples/tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf = new TCPDF('p', 'mm', 'A4', TRUE, 'UTF-8', false);
//$pdf->setPrintHeader(FALSE);
//$pdf->setPrintFooter(FALSE);
// set default header data
$pdf->setHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'BUNDELKHAND INDUSTRIAL DEVELOPMENT AUTHORITY', '');

// set margins
$pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->setHeaderMargin(PDF_MARGIN_HEADER);

$pdf->AddPage();
$pdf->SetFont('freesans', '', 10);

// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
$pdf->setCellMargins(0.1, 1, 0, 1);

/* * ******* block ********* */
// set color for background
$pdf->setFillColor(0, 0, 0);
$pdf->SetTextColor(255, 255, 255);

$txt = 'क्रo सo';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'गाटे के परीक्षण का बिंदु/सवाल';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'रिजल्ट';
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

// set color for background
$pdf->setFillColor(255, 255, 255);
$pdf->SetTextColor(0, 0, 0);
$txt = '1';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'कितने गाटे 1359 फसली खतौनी में उपलब्ध नहीं है ?';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_1;
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '2';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'कितने गाटे सीएच 41-45 में उपलब्ध नहीं है ?';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_2;
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

/* * ******* block ********* */
// set color for background
$pdf->setFillColor(0, 0, 0);
$pdf->SetTextColor(255, 255, 255);

$txt = 'क्रo सo';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'गाटे की श्रेणी के संबंध में';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'रिजल्ट';
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

// set color for background
$pdf->setFillColor(255, 255, 255);
$pdf->SetTextColor(0, 0, 0);
$txt = '3';
$pdf->MultiCell(15, 11, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जो 1359 फसली खसरे के अनुसर सुरक्षित श्रेणि में है';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_6;
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '4';
$pdf->MultiCell(15, 11, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जिनकी वर्तमान श्रेनी सीएच 41-45 के समान नहीं है';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_7;
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

/* * ******* block ********* */
// set color for background
$pdf->setFillColor(0, 0, 0);
$pdf->SetTextColor(255, 255, 255);

$txt = 'क्रo सo';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'गाटे की रकबे के संबंध में';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'रिजल्ट';
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

// set color for background
$pdf->setFillColor(255, 255, 255);
$pdf->SetTextColor(0, 0, 0);
$txt = '5';
$pdf->MultiCell(15, 11, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जिनका वर्तमान रकबा 1359 फसली के रकबे के बराबर नहीं है';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_8;
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '6';
$pdf->MultiCell(15, 11, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जिनका वर्तमान रकबा सीएच 41-45 के रकबे के बराबर नहीं है';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_10;
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

/* * ******* block ********* */
// set color for background
$pdf->setFillColor(0, 0, 0);
$pdf->SetTextColor(255, 255, 255);

$txt = 'क्रo सo';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'गाटे के दर निर्धारण के सम्बन्ध में';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'रिजल्ट';
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

// set color for background
$pdf->setFillColor(255, 255, 255);
$pdf->SetTextColor(0, 0, 0);
$txt = '7';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जहां कृषि दर निर्धारित नहीं की गई है';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_12;
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '8';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जहां आबादी दर निर्धारित नहीं की गई है';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_13;
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '9';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जहां सड़क किनारे की दर निर्धारित नहीं की गई है';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_14;
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '10';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जहां एक से अधिक प्रकार की दर निर्धारित की गई है';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_15;
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '11';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जहां पिछले एक साल की मार्केट रेट गाटे की सर्कल रेट अधिक है';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_16;
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '12';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जहां पिछले दो साल में सर्किल रेट अधिक है';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_17;
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '13';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जहां गाटे का भूमि मूल्य सर्किल रेट के चार गुने से अधिक है';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_18;
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '14';
$pdf->MultiCell(15, 11, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जहां परिसम्पत्तियों का मुल्य कुल भूमि के मुल्य के 10 प्रतिषत से अधिक है';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_19;
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '15';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जहां परिसम्पत्तियों का मूल्य 10 लाख रूपये से अधिक है';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_20;
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

/* * ******* block ********* */
// set color for background
$pdf->setFillColor(0, 0, 0);
$pdf->SetTextColor(255, 255, 255);

$txt = 'क्रo सo';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'गाटे के होल्ड करने के सम्बन्ध में';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'रिजल्ट';
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

// set color for background
$pdf->setFillColor(255, 255, 255);
$pdf->SetTextColor(0, 0, 0);
$txt = '16';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जिन्हे जिलाधिकरी द्वार विज्ञपति से पहले रोका गया है';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_21;
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '17';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जिन्हे बीड़ा द्वार प्रेस विज्ञपति से पूर्व रोका गया है';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_22;
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '18';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जिन्हे दर निर्धारण समिति द्वारा रोका गया है';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_23;
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '19';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जिनका बैनामा बीड़ा द्वार दर निर्धारण के उपरान्त रोका गया है';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_24;
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '20';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जो नक्शे पर है परंतु मौके पर नहीं है';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_25;
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '21';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जो मानचित्र/मौके पर नहर है परंतु खतौनी में काश्तकार के नाम दर्ज है';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_26;
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '22';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जो मानचित्र/मौके पर सड़क है परंतु खतौनी में काश्तकार के नाम दर्ज हैं';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_27;
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '23';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे बैनामे, जहाँ गाटों का दर निर्धारण नहीं हुआ';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_28;
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '24';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे बैनामे, जहाँ दर निर्धारण से ज्यादा भुगतान हो गया है';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_29;
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '25';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे बैनामे, जहाँ एक ही काश्तकार का एक ही गाटा पर एक से ज्यादा बार बैनामा हुआ है';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_30;
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '26';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे बैनामे, जिनमें तितिम्मा हुआ है';
$pdf->MultiCell(130, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_31;
$pdf->MultiCell(45, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

//Close and output PDF document
$filename = 'consolidate_village_reports_' . time() . '.pdf';
$pdf->Output(dirname(dirname(__FILE__)) . '/' . $media_export . '/' . $filename, 'F');

$db_respose_data = json_encode(array('status' => '1', 'url' => base64_encode($filename), 'ftype' => base64_encode('referral_pdf')));
print_r($db_respose_data);
exit();
