<?php

require('main-pdf.php');
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/gataReport.core.php';
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

// set color for background
$pdf->setFillColor(245, 245, 245);
$pdf->SetTextColor(0, 0, 0);

$txt = '';
$pdf->MultiCell(15, 8, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'क्या गाटे का अधिग्रहण किया जा रहा है ?';
$pdf->MultiCell(90, 8, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_0;
$pdf->MultiCell(30, 8, $txt, 1, 'L', 1, 0, '', '', true);
$txt = '';
$pdf->MultiCell(55, 8, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

/* * ******* block ********* */
// set color for background
$pdf->setFillColor(0, 0, 0);
$pdf->SetTextColor(255, 255, 255);

$txt = 'क्रo सo';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'गाटे के परीक्षण का बिंदु/सवाल';
$pdf->MultiCell(90, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'रिजल्ट';
$pdf->MultiCell(30, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'विवरण';
$pdf->MultiCell(55, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

// set color for background
$pdf->setFillColor(255, 255, 255);
$pdf->SetTextColor(0, 0, 0);
$txt = '1';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'क्या गाटा 1359 फसली खतौनी में उपलब्ध है ?';
$pdf->MultiCell(90, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_1;
$pdf->MultiCell(30, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_1_info;
$pdf->MultiCell(55, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '2';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'क्या गाटा सीएच 41-45 में उपलब्ध है ?';
$pdf->MultiCell(90, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_2;
$pdf->MultiCell(30, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_info_2;
$pdf->MultiCell(55, 7, $txt, 1, 'L', 1, 0, '', '', true, 0, false, true, 7, 'M', true);
$pdf->Ln();

/* * ******* block ********* */
// set color for background
$pdf->setFillColor(0, 0, 0);
$pdf->SetTextColor(255, 255, 255);

$txt = 'क्रo सo';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'गाटे की श्रेणी के संबंध में';
$pdf->MultiCell(90, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'रिजल्ट';
$pdf->MultiCell(30, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'विवरण';
$pdf->MultiCell(55, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

// set color for background
$pdf->setFillColor(255, 255, 255);
$pdf->SetTextColor(0, 0, 0);
$txt = '3';
$pdf->MultiCell(15, 11, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'क्या गाटे की वर्तमान खतौनी 1-क है और 1359 फसली खसरे के अनुसार सुरक्षित श्रेणी में है ?';
$pdf->MultiCell(90, 11, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_6;
$pdf->MultiCell(30, 11, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_info_6;
$pdf->MultiCell(55, 11, $txt, 1, 'L', 1, 0, '', '', true, 0, false, true, 11, 'M', true);
$pdf->Ln();

$txt = '4';
$pdf->MultiCell(15, 11, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'क्या गाटे की वर्तमान श्रेणी सीएच 41-45 के समान हैं ?';
$pdf->MultiCell(90, 11, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_7;
$pdf->MultiCell(30, 11, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_info_7;
$pdf->MultiCell(55, 11, $txt, 1, 'L', 1, 0, '', '', true, 0, false, true, 11, 'M', true);
$pdf->Ln();

/* * ******* block ********* */
// set color for background
$pdf->setFillColor(0, 0, 0);
$pdf->SetTextColor(255, 255, 255);

$txt = 'क्रo सo';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'गाटे की रकबे के संबंध में';
$pdf->MultiCell(90, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'रिजल्ट';
$pdf->MultiCell(30, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'विवरण';
$pdf->MultiCell(55, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

// set color for background
$pdf->setFillColor(255, 255, 255);
$pdf->SetTextColor(0, 0, 0);
$txt = '5';
$pdf->MultiCell(15, 11, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'गाटे का वर्तमान रकबा 1359 फसली खतौनी के रकबे के बराबर है या नहीं ?';
$pdf->MultiCell(90, 11, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_8;
$pdf->MultiCell(30, 11, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_info_8;
$pdf->MultiCell(55, 11, $txt, 1, 'L', 1, 0, '', '', true, 0, false, true, 11, 'M', true);
$pdf->Ln();

$txt = '6';
$pdf->MultiCell(15, 11, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'गाटे का वर्तमान रकबा 41-45 के रकबे के बराबर है या नहीं ?';
$pdf->MultiCell(90, 11, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_10;
$pdf->MultiCell(30, 11, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_info_10;
$pdf->MultiCell(55, 11, $txt, 1, 'L', 1, 0, '', '', true, 0, false, true, 11, 'M', true);
$pdf->Ln();

/* * ******* block ********* */
// set color for background
$pdf->setFillColor(0, 0, 0);
$pdf->SetTextColor(255, 255, 255);

$txt = 'क्रo सo';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'गाटे के दर निर्धारण के सम्बन्ध में';
$pdf->MultiCell(90, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'रिजल्ट';
$pdf->MultiCell(30, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'विवरण';
$pdf->MultiCell(55, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

// set color for background
$pdf->setFillColor(255, 255, 255);
$pdf->SetTextColor(0, 0, 0);
$txt = '7';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'गाटे की कृषि दर क्या निर्धारित की गयी हैं ?';
$pdf->MultiCell(90, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_12;
$pdf->MultiCell(30, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = '';
$pdf->MultiCell(55, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '8';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'गाटे की आबादी दर क्या निर्धारित की गयी हैं ?';
$pdf->MultiCell(90, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_13;
$pdf->MultiCell(30, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = '';
$pdf->MultiCell(55, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '9';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'गाटे की सड़क किनारे की दर क्या निर्धारित की गयी हैं ?';
$pdf->MultiCell(90, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_14;
$pdf->MultiCell(30, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = '';
$pdf->MultiCell(55, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '10';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'क्या गाटे पर एक से अधिक प्रकार की दर निर्धारित की गयी है ?';
$pdf->MultiCell(90, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_15;
$pdf->MultiCell(30, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = '';
$pdf->MultiCell(55, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '11';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'क्या पिछले एक साल की मार्केट रेट गाटे की सर्किल रेट से अधिक है ?';
$pdf->MultiCell(90, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_16;
$pdf->MultiCell(30, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = '';
$pdf->MultiCell(55, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '12';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'क्या पिछले दो साल की मार्केट रेट गाटे की सर्किल रेट से अधिक है ?';
$pdf->MultiCell(90, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_17;
$pdf->MultiCell(30, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = '';
$pdf->MultiCell(55, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '13';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'क्या गाटे का भूमि मूल्य सर्किल के 4 गुने से अधिक हैं ?';
$pdf->MultiCell(90, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_18;
$pdf->MultiCell(30, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = '';
$pdf->MultiCell(55, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '14';
$pdf->MultiCell(15, 11, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'क्या परिसंपत्तियों का मूल्य कुल भूमि के मूल्य के 10 प्रतिशत से अधिक है ?';
$pdf->MultiCell(90, 11, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_19;
$pdf->MultiCell(30, 11, $txt, 1, 'L', 1, 0, '', '', true);
$txt = '';
$pdf->MultiCell(55, 11, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '15';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'क्या परिसंपत्तियों का मूल्य 10 लाख रुपये से अधिक है ?';
$pdf->MultiCell(90, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_20;
$pdf->MultiCell(30, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = '';
$pdf->MultiCell(55, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

/* * ******* block ********* */
// set color for background
$pdf->setFillColor(0, 0, 0);
$pdf->SetTextColor(255, 255, 255);

$txt = 'क्रo सo';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'गाटे के होल्ड करने के सम्बन्ध में';
$pdf->MultiCell(90, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'रिजल्ट';
$pdf->MultiCell(30, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'विवरण';
$pdf->MultiCell(55, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

// set color for background
$pdf->setFillColor(255, 255, 255);
$pdf->SetTextColor(0, 0, 0);
$txt = '16';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'क्या गाटा जिलाधिकारी द्वारा प्रेस विज्ञप्ति के पूर्व रोका गया है ?';
$pdf->MultiCell(90, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_21;
$pdf->MultiCell(30, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = '';
$pdf->MultiCell(55, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '17';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'क्या गाटा बीडा द्वारा प्रेस विज्ञप्ति से पहले रोका गया है ?';
$pdf->MultiCell(90, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_22;
$pdf->MultiCell(30, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = '';
$pdf->MultiCell(55, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '18';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'क्या गाटा दर निर्धारण समिति द्वारा रोका गया है ?';
$pdf->MultiCell(90, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_23;
$pdf->MultiCell(30, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = '';
$pdf->MultiCell(55, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '19';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'क्या गाटे का बैनामा बीडा द्वारा दर निर्धारण उपरान्त रोका गया है ?';
$pdf->MultiCell(90, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_24;
$pdf->MultiCell(30, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = '';
$pdf->MultiCell(55, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '20';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'क्या गाटा नक्शे पर है, परन्तु मौके पर नहीं है?';
$pdf->MultiCell(90, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_25;
$pdf->MultiCell(30, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = '';
$pdf->MultiCell(55, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '21';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'क्या मानचित्र/मौके पर नहर है एवं खतौनी में काश्तकार हैं ?';
$pdf->MultiCell(90, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_26;
$pdf->MultiCell(30, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = '';
$pdf->MultiCell(55, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '22';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'क्या मानचित्र/मौके पर सड़क है एवं खतौनी में काश्तकार हैं ?';
$pdf->MultiCell(90, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_27;
$pdf->MultiCell(30, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = '';
$pdf->MultiCell(55, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

/* * ******* block ********* */
// set color for background
$pdf->setFillColor(0, 0, 0);
$pdf->SetTextColor(255, 255, 255);

$txt = 'क्रo सo';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'अन्य बिन्दु';
$pdf->MultiCell(90, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'रिजल्ट';
$pdf->MultiCell(30, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'विवरण';
$pdf->MultiCell(55, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

// set color for background
$pdf->setFillColor(255, 255, 255);
$pdf->SetTextColor(0, 0, 0);
$txt = '23';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'गाटे पर कुल वृक्ष कितने है ?';
$pdf->MultiCell(90, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_28;
$pdf->MultiCell(30, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = '';
$pdf->MultiCell(55, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$txt = '24';
$pdf->MultiCell(15, 11, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'गाटा पर परिसम्पत्तियाँ क्या-क्या है?';
$pdf->MultiCell(90, 11, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_29;
$pdf->MultiCell(85, 11, $txt, 1, 'L', 1, 0, '', '', true, 0, false, true, 11, 'M', true);
$pdf->Ln();

$txt = '25';
$pdf->MultiCell(15, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'क्या एग्री स्टेक के अनुसार मौके पर फसल हैं ?';
$pdf->MultiCell(90, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = $answer_5;
$pdf->MultiCell(30, 7, $txt, 1, 'L', 1, 0, '', '', true);
$txt = '';
$pdf->MultiCell(55, 7, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

//Close and output PDF document
$filename = 'gata_reports_' . time() . '.pdf';
$pdf->Output(dirname(dirname(__FILE__)) . '/' . $media_export . '/' . $filename, 'F');

$db_respose_data = json_encode(array('status' => '1', 'url' => base64_encode($filename), 'ftype' => base64_encode('referral_pdf')));
print_r($db_respose_data);
exit();