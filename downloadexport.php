<?php

include_once 'config.php';
$file = base64_decode($_GET["file"]);
$file_path = dirname(__FILE__) . "/" . $media_export . "/" . $file;
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . basename($file_path));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($file_path));
ob_clean();
flush();
readfile($file_path);
unlink($file_path);
exit;
