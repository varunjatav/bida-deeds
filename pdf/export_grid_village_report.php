<?php

require('main-pdf.php');
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/gridVillageReport.core.php';
require_once('tcpdf/examples/tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf = new TCPDF('L', 'mm', 'A4', TRUE, 'UTF-8', false);
//$pdf->setPrintHeader(FALSE);
//$pdf->setPrintFooter(FALSE);
// set default header data
$pdf->setHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'BUNDELKHAND INDUSTRIAL DEVELOPMENT AUTHORITY', '');

// set margins
$pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->setHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
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

$txt = 'Name';
$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 255, 255)));
$pdf->MultiCell(14, 68, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'कितने गाटे 1359 फसली खतौनी में उपलब्ध नहीं है ?';
$pdf->MultiCell(12, 68, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'कितने गाटे सीएच 41-45 में उपलब्ध नहीं है ?';
$pdf->MultiCell(12, 68, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जो 1359 फसली खसरे के अनुसर सुरक्षित श्रेणि में है';
$pdf->MultiCell(12, 68, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जिनकी वर्तमान श्रेनी सीएच 41-45 के समान नहीं है';
$pdf->MultiCell(12, 68, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जिनका वर्तमान रकबा 1359 फसली के रकबे के बराबर नहीं है';
$pdf->MultiCell(12, 68, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जिनका वर्तमान रकबा सीएच 41-45 के रकबे के बराबर नहीं है';
$pdf->MultiCell(12, 68, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जहां कृषि दर निर्धारित नहीं की गई है';
$pdf->MultiCell(12, 68, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जहां आबादी दर निर्धारित नहीं की गई है';
$pdf->MultiCell(12, 68, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जहां सड़क किनारे की दर निर्धारित नहीं की गई है';
$pdf->MultiCell(12, 68, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जहां एक से अधिक प्रकार की दर निर्धारित की गई है';
$pdf->MultiCell(12, 68, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जहां पिछले एक साल की मार्केट रेट गाटे की सर्कल रेट अधिक है';
$pdf->MultiCell(12, 68, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जहां पिछले दो साल में सर्किल रेट अधिक है';
$pdf->MultiCell(12, 68, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जहां गाटे का भूमि मूल्य सर्किल रेट के चार गुने से अधिक है';
$pdf->MultiCell(12, 68, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जहां परिसम्पत्तियों का मुल्य कुल भूमि के मुल्य के 10 प्रतिषत से अधिक है';
$pdf->MultiCell(12, 68, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जहां परिसम्पत्तियों का मूल्य 10 लाख रूपये से अधिक है';
$pdf->MultiCell(12, 68, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जिन्हे जिलाधिकरी द्वार विज्ञपति से पहले रोका गया है';
$pdf->MultiCell(12, 68, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जिन्हे बीड़ा द्वार प्रेस विज्ञपति से पूर्व रोका गया है';
$pdf->MultiCell(12, 68, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जिन्हे दर निर्धारण समिति द्वारा रोका गया है';
$pdf->MultiCell(12, 68, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जिनका बैनामा बीड़ा द्वार दर निर्धारण के उपरान्त रोका गया है';
$pdf->MultiCell(12, 68, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जो नक्शे पर है परंतु मौके पर नहीं है';
$pdf->MultiCell(12, 68, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जो मानचित्र/मौके पर नहर है परंतु खतौनी में काश्तकार के नाम दर्ज है';
$pdf->MultiCell(12, 68, $txt, 1, 'L', 1, 0, '', '', true);
$txt = 'ऐसे गाटो की संख्या जो मानचित्र/मौके पर सड़क है परंतु खतौनी में काश्तकार के नाम दर्ज हैं';
$pdf->MultiCell(12, 68, $txt, 1, 'L', 1, 0, '', '', true);
$pdf->Ln();

$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));

// set color for background
$pdf->setFillColor(255, 255, 255);
$pdf->SetTextColor(0, 0, 0);
$srno = 0;
$point_1_total = 0;
$point_2_total = 0;
$y = 0;
foreach ($villageInfo as $vKey => $vValue) {
    $srno++;
    for ($j = 1; $j < 23; $j++) {
        ${"point_" . $j . "_total"} += (float) ${"point_" . $j}[$vValue['VillageCode']];
    }
    $txt = $vValue['VillageName'];
    $pdf->MultiCell(14, 25, $txt, 1, 'L', 1, 0, '', '', true);
    $txt = $point_2[$vValue['VillageCode']];
    $pdf->MultiCell(12, 25, $txt, 1, 'L', 1, 0, '', '', true);
    $txt = $point_3[$vValue['VillageCode']];
    $pdf->MultiCell(12, 25, $txt, 1, 'L', 1, 0, '', '', true);
    $txt = $point_4[$vValue['VillageCode']];
    $pdf->MultiCell(12, 25, $txt, 1, 'L', 1, 0, '', '', true);
    $pdf->Ln();
    $y += $pdf->GetY();
    if ($y > 397) {
        $y = 0;
        $pdf->AddPage();
    }
}

//Close and output PDF document
$filename = 'grid_reports_' . time() . '.pdf';
$pdf->Output(dirname(dirname(__FILE__)) . '/' . $media_export . '/' . $filename, 'F');

$db_respose_data = json_encode(array('status' => '1', 'url' => base64_encode($filename), 'ftype' => base64_encode('referral_pdf')));
print_r($db_respose_data);
exit();
