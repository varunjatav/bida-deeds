<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);1178747;

$user_id = $_SESSION['UserID'];
$user_type = $_SESSION['UserType'];
$id = decryptIt(myUrlEncode($_REQUEST['id']));

$sql = "SELECT SQL_CALC_FOUND_ROWS T1.*, GROUP_CONCAT(T3.owner_name) AS owner_name, GROUP_CONCAT(T3.owner_father) AS owner_father, GROUP_CONCAT(T3.Area) AS Kashtkar_Area, T2.VillageName
                        FROM lm_gata T1
                        LEFT JOIN lm_gata_kashtkar T3 ON (T3.VillageCode = T1.VillageCode AND T3.GataNo = T1.GataNo AND T3.KhataNo = T1.KhataNo AND T3.Area = T1.Area)
                        LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                        WHERE T1.ID  = ?
                        GROUP BY T1.ID
                        ";
$sql = $db->prepare($sql);
$sql->bindParam(1, $id);
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
$data = $sql->fetch();

$kastakar_details = explode(',', $data['owner_name']);
$owner_father = explode(',', $data['owner_father']);
$Kashtkar_Area = explode(',', $data['Kashtkar_Area']);

$chakbandi_query = $db->prepare("SELECT T1.VillageCode,
                                                            SUM(CASE
                                                                WHEN (T1.ch41_45_ke_anusar_rakba != ? AND T1.ch41_45_ke_anusar_rakba != ?) THEN 1
                                                                ELSE 0
                                                                END) AS Count
                                                     FROM lm_gata T1
                                                     WHERE T1.ID = ?
                                        ");
$chakbandi_query->bindValue(1, '');
$chakbandi_query->bindValue(2, '--');
$chakbandi_query->bindParam(3, $id);
$chakbandi_query->execute();
$chakbandi_query->setFetchMode(PDO::FETCH_ASSOC);
$chakbandi_status_array = array();
while ($row = $chakbandi_query->fetch()) {
    $chakbandi_status_array= $row['Count'];
}
