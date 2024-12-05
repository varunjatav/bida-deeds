<?php

$file = base64_decode($_GET["file"]);
$type = base64_decode($_GET['type']);
include_once 'config.php';

if ($type == 'village_ebasta') {
    $file_path = $media_village_ebasta_path . '/' . $file;
} else if ($type == 'gata_ebasta') {
    $file_path = $media_gata_ebasta_path . '/' . $file;
} else if ($type == 'kashtkar_sahmati') {
    $file_path = $media_kashtkar_sahmati_path . '/' . $file;
} else if ($type == 'grievance_report') {
    $file_path = $media_grievance_report_path . '/' . $file;
} else if ($type == 'lekhpal_ebasta') {
    $file_path = $media_lekhpal_ebasta_path . '/' . $file;
} else if ($type == 'offline_grievance') {
    $file_path = $media_grievance_report_path . '/' . $file;
} else if ($type == 'office_order') {
    $file_path = $media_office_order_path . '/' . $file;
}
$context = stream_context_create(
        array(
            'wrapper' =>
            array(
                'method' => "GET",
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ),
                'http' => array(
                    'timeout' => $download_file_timeout,
                    'ignore_errors' => true,
                )
            )
        )
);
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . basename($file_path));
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
readfile($file_path, false, $context);
exit;
