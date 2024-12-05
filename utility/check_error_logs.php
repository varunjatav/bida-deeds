<?php

include_once '../config.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';

$file = dirname(dirname(__FILE__)) . '/logs/error_logs/error_log.txt';

echo "<pre>";
$block = 1024 * 1024;   // 1MB or counld be any higher than HDD block_size * 2
if ($fh = fopen($file, "r")) {
    $left = '';
    while (!feof($fh)) {    // read the file
        $temp = fread($fh, $block);
        $fgetslines = explode("\n", $temp);
        $fgetslines[0] = $left . $fgetslines[0];
        if (!feof($fh)) {
            $left = array_pop($lines);
        }
        foreach ($fgetslines as $k => $line) {
            echo $line . '<br>';
        }
    }
}