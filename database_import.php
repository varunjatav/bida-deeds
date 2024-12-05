<?php

include_once 'config.php';
include_once 'dbcon/db_connect.php';
include_once 'functions/common.function.php';
set_time_limit(0);
ini_set('memory_limit', '6024M'); // or you could use 6G
$filePath = 'bida-deed-dev.sql';

$res = importSqlFile($db, $filePath);

function importSqlFile($pdo, $sqlFile, $tablePrefix = null, $InFilePath = null) {
    try {

        // Enable LOAD LOCAL INFILE
        $pdo->setAttribute(\PDO::MYSQL_ATTR_LOCAL_INFILE, true);

        $errorDetect = false;

        // Temporary variable, used to store current query
        $tmpLine = '';

        // Read in entire file
        $lines = file($sqlFile);

        // Loop through each line
        foreach ($lines as $line) {
            // Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || trim($line) == '') {
                continue;
            }

            // Read & replace prefix
            $line = str_replace(['<<prefix>>', '<<InFilePath>>'], [$tablePrefix, $InFilePath], $line);

            // Add this line to the current segment
            $tmpLine .= $line;

            // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';') {
                try {
                    // Perform the Query
                    $pdo->exec($tmpLine);
                } catch (\PDOException $e) {
                    echo "<br><pre>Error performing Query: '<strong>" . $tmpLine . "</strong>': " . $e->getMessage() . "</pre>\n";
                    $errorDetect = true;
                }

                // Reset temp variable to empty
                $tmpLine = '';
            }
        }

        // Check if error is detected
        if ($errorDetect) {
            return false;
        }
    } catch (\Exception $e) {
        echo "<br><pre>Exception => " . $e->getMessage() . "</pre>\n";
        return false;
    }
    return true;
}
