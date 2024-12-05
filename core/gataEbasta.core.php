<?php

$user_type = $_SESSION['UserType'];
$village_code = $_POST['village_code'];
$gata_no = $_POST['gata_no'];
$khata_no = $_POST['khata_no'];
$kashtkar_data = explode('@', decryptIt(myUrlEncode($_POST['kashtkar'])));
$owner_no = $kashtkar_data[0];
$kashtkar_name = $kashtkar_data[1];
$kashtkar_fname = $kashtkar_data[2];

$village_query = $db->prepare("SELECT T1.*
                                FROM lm_gata_ebasta T1
                                WHERE T1.VillageCode = ?
                                AND T1.GataNo = ?
                                AND T1.KhataNo = ?
                                AND T1.OwnerNo = ?
                                AND T1.owner_name = ?
                                AND T1.owner_father = ?
                                ");
$village_query->bindParam(1, $village_code);
$village_query->bindParam(2, $gata_no);
$village_query->bindParam(3, $khata_no);
$village_query->bindParam(4, $owner_no);
$village_query->bindParam(5, $kashtkar_name);
$village_query->bindParam(6, $kashtkar_fname);
$village_query->execute();
$village_query->setFetchMode(PDO::FETCH_ASSOC);
$ebastaInfo = $village_query->fetch();

$ebasta_1 = json_decode($ebastaInfo['Ebasta1'], true);
$ebasta_2 = json_decode($ebastaInfo['Ebasta2'], true);
$ebasta_3 = json_decode($ebastaInfo['Ebasta3'], true);
$ebasta_4 = json_decode($ebastaInfo['Ebasta4'], true);
$ebasta_5 = json_decode($ebastaInfo['Ebasta5'], true);
$ebasta_6 = $ebastaInfo['KashtkarAnsh'] ? $ebastaInfo['KashtkarAnsh'] : 0;
$ebasta_7 = $ebastaInfo['AnshRakba'] ? $ebastaInfo['AnshRakba'] : 0;
$ebasta_8 = $ebastaInfo['AnshDate'] ? date('d-m-Y', $ebastaInfo['AnshDate']) : '';
