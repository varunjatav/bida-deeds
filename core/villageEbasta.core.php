<?php

$village_code = $_POST['village_code'];
$user_type = $_SESSION['UserType'];

$village_query = $db->prepare("SELECT T1.*
                                FROM lm_village_ebasta T1
                                WHERE T1.VillageCode = ?
                                ");
$village_query->bindParam(1, $village_code);
$village_query->execute();
$village_query->setFetchMode(PDO::FETCH_ASSOC);
$ebastaInfo = $village_query->fetch();

$ebasta_1 = json_decode($ebastaInfo['Ebasta1'], true);
$ebasta_2 = json_decode($ebastaInfo['Ebasta2'], true);
$ebasta_3 = json_decode($ebastaInfo['Ebasta3'], true);
$ebasta_4 = json_decode($ebastaInfo['Ebasta4'], true);
$ebasta_5 = json_decode($ebastaInfo['Ebasta5'], true);
$ebasta_6 = json_decode($ebastaInfo['Ebasta6'], true);
$ebasta_7 = json_decode($ebastaInfo['Ebasta7'], true);
$ebasta_8 = json_decode($ebastaInfo['Ebasta8'], true);
$ebasta_9 = json_decode($ebastaInfo['Ebasta9'], true);
$ebasta_10 = json_decode($ebastaInfo['Ebasta10'], true);
$ebasta_11 = json_decode($ebastaInfo['Ebasta11'], true);
$ebasta_12 = json_decode($ebastaInfo['Ebasta12'], true);
$ebasta_13 = json_decode($ebastaInfo['Ebasta13'], true);
$ebasta_14 = json_decode($ebastaInfo['Ebasta14'], true);
$ebasta_15 = json_decode($ebastaInfo['Ebasta15'], true);
$ebasta_16 = json_decode($ebastaInfo['Ebasta16'], true);
$ebasta_17 = json_decode($ebastaInfo['Ebasta17'], true);
$ebasta_18 = json_decode($ebastaInfo['Ebasta18'], true);
$ebasta_19 = json_decode($ebastaInfo['Ebasta19'], true);
$ebasta_20 = json_decode($ebastaInfo['Ebasta20'], true);
