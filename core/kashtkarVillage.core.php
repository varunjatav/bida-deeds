<?php

$user_id = $_SESSION['UserID'];
$mobile = $_SESSION['Mobile'];

$village_query = $db->prepare("SELECT T1.VillageName, T1.VillageNameHi, T1.VillageCode
                        FROM lm_village T1
                        WHERE T1.Active = ?
                        ORDER BY T1.VillageName ASC
                        ");
$village_query->bindValue(1, 1);
$village_query->execute();
$village_query->setFetchMode(PDO::FETCH_ASSOC);
$villageInfo = $village_query->fetchAll();

$sahmati_query = $db->prepare("SELECT T1.*
                        FROM lm_kashtkar_sahmati T1
                        WHERE T1.Mobile = ?
                        ORDER BY T1.ID DESC
                        LIMIT 1
                        ");
$sahmati_query->bindParam(1, $mobile);
$sahmati_query->execute();
$row_count = $sahmati_query->rowCount();
$sahmati_query->setFetchMode(PDO::FETCH_ASSOC);
$sahmatiInfo = $sahmati_query->fetch();
$sahmati_form = '1';
$status = 'Pending';
$status_color = '';
if ($row_count) {
    if ($sahmatiInfo['Status'] == '1') {
        $sahmati_form = '0';
        $status = 'Approved';
        $status_color = 'alert-success';
    } else if ($sahmatiInfo['Status'] == '2') {
        $sahmati_form = '1';
        $status = 'Rejected';
        $status_color = 'alert-danger';
    } else {
        $sahmati_form = '0';
    }
}