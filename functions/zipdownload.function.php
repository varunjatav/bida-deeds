<?php

include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/downloadAllAttachment.core.php';
$time = time();
$zip = new ZipArchive();
if ($zip->open($dir . $filename, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE) !== true) {
    exit("cannot open <$filename>\n");
}
foreach ($pdf as $file) {
    $new_filename = substr($dir . $file, strrpos($dir . $file, '/') + 1);
    $zip->addFile($dir . $file, $new_filename);
}
$zip->close();
header('Content-Type: application/zip');
header('Content-disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . filesize($dir . $filename));
readfile($dir . $filename);
flush();
unlink($dir . $filename);
