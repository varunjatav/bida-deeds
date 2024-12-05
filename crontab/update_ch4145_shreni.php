<?php

date_default_timezone_set('Asia/Kolkata');
include_once dirname(dirname(__FILE__)) . "/config.php";
include_once dirname(dirname(__FILE__)) . "/dbcon/db_connect.php";
include_once dirname(dirname(__FILE__)) . "/functions/common.function.php";
include_once dirname(dirname(__FILE__)) . "/vendor/autoload.php";
$timestamp = time();

$village_query = $db->prepare("SELECT T1.ID, T1.ch41_45_ke_anusar_sreni
                                FROM lm_gata T1
                                WHERE T1.ch41_45_ke_anusar_sreni = ?
                                ");
$village_query->bindValue(1, '1(क)');
$village_query->execute();
if ($village_query->rowCount()) {
    while ($row = $village_query->fetch()) {
        $updt = $db->prepare("UPDATE lm_gata SET ch41_45_ke_anusar_sreni = ? WHERE ID = ?");
        $updt->bindValue(1, '1-क');
        $updt->bindParam(2, $row['ID']);
        $updt->execute();
    }
}