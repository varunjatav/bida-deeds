<?php

$query = "SELECT COUNT(*) as count
            FROM prtms_blacklisted_ip T1
            WHERE T1.IP = ?
            ";

$query_exec = $db->prepare($query);
$query_exec->bindParam(1, $_SERVER['REMOTE_ADDR']);
$query_exec->execute();
$query_exec->setFetchMode(PDO::FETCH_ASSOC);
$result = $query_exec->fetchAll();

$count = $result[0]['count'];
if ($count > 0) {
    $data = array('status' => -3, 'page' => '');
    print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
    exit();
}
?>
