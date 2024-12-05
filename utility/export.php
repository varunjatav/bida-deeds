<?php

set_time_limit(0);
include_once '../config.php';
include_once '../dbcon/db_connect.php';
$mysqlUserName = $db_username;
$mysqlPassword = $db_password;
$mysqlHostName = $db_hostname;
$DbName = $db_database;
$tables = explode(',', $_GET['tables']);

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
//echo '<pre>';

Export_Database($mysqlHostName, $mysqlUserName, $mysqlPassword, $DbName, $tables, $backup_name = false, $media_export);

function Export_Database($host, $user, $pass, $name, $tables, $backup_name = false, $media_export) {
    $mysqli = new mysqli($host, $user, $pass, $name);
    $mysqli->select_db($name);
    $mysqli->query("SET NAMES 'utf8mb4'");

    $target_tables = array();
    if ($queryTables = $mysqli->query('SHOW TABLES FROM ' . $name)) {
        while ($row = $queryTables->fetch_row()) {
            $target_tables[] = $row[0];
        }
    }
    if ($tables !== false) {
        $target_tables = array_intersect($target_tables, $tables);
    }

    foreach ($target_tables as $table) {
        $result = $mysqli->query('SELECT * FROM ' . $table);
        $fields_amount = $result->field_count;
        $rows_num = $mysqli->affected_rows;
        $res = $mysqli->query('SHOW CREATE TABLE ' . $table);
        $TableMLine = $res->fetch_row();
        $content = (!isset($content) ? '' : $content) . "\n\n" . $TableMLine[1] . ";\n\n";
        
        $content .= "\nINSERT INTO " . $table . " VALUES";
        foreach (funcGenerator($mysqli, $table) as $chunk) {
            $content .= "\n(";
            foreach ($chunk as $key => $row) {
                $row = str_replace("\n", "\\n", addslashes($row ?? ''));
                if (isset($row)) {
                    $content .= '"' . $row . '"';
                } else {
                    $content .= '""';
                }
                if ($key < ($fields_amount - 1)) {
                    $content .= ',';
                }
            }
            $content .= "),";
        }
        $content = rtrim($content, ','); // Remove the trailing comma
        $content .= ";\n";
        $content .= "\n\n\n";
    }

    $context = stream_context_create(
            array('wrapper' =>
                array(
                    'method' => "GET",
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'http' => array(
                        'timeout' => 60,
                        'ignore_errors' => true,
                    )
                )
            )
    );

    $path = dirname(dirname(__FILE__)) . "/" . $media_export . "/";
    $backup_name = $name . "_" . date('d_m_Y_h_i_A', time()) . ".sql";
    $file_path = $path . $backup_name;

    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file_path));
    header("Content-Transfer-Encoding: Binary");
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file_path));
    ob_clean();
    flush();
    file_put_contents($file_path, $content);
    readfile($file_path, false, $context);
    exit;
}

function funcGenerator($mysqli, $table) {
    $result1 = $mysqli->query('SELECT * FROM ' . $table);
    while ($row = $result1->fetch_row()) {
        yield $row;
    }
}
