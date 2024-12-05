<?php

$user_id = $_SESSION['UserID'];
$user_type = $_SESSION['UserType'];
$village_code = $_POST['village_code'];
$gata_no = $_POST['gata_no'];
$khata_no = $_POST['khata_no'];
$kashtkar_data = explode('@', decryptIt(myUrlEncode($_POST['kashtkar'])));
$owner_no = $kashtkar_data[0];
$kashtkar_name = $kashtkar_data[1];
$kashtkar_fname = $kashtkar_data[2];

$village_query = $db->prepare("SELECT T1.Mortgaged, T1.MortgagedAmount
                                FROM lm_gata_martgaged_info T1
                                WHERE T1.VillageCode = ?
                                AND T1.GataNo = ?
                                AND T1.KhataNo = ?
                                AND T1.OwnerNo = ?
                                AND T1.owner_name = ?
                                AND T1.owner_father = ?
                                AND T1.BankID = ?
                                ");
$village_query->bindParam(1, $village_code);
$village_query->bindParam(2, $gata_no);
$village_query->bindParam(3, $khata_no);
$village_query->bindParam(4, $owner_no);
$village_query->bindParam(5, $kashtkar_name);
$village_query->bindParam(6, $kashtkar_fname);
$village_query->bindParam(7, $user_id);
$village_query->execute();
$village_query->setFetchMode(PDO::FETCH_ASSOC);
$ebastaInfo = $village_query->fetch();

$mortgaged = $ebastaInfo['Mortgaged'];
$mortgaged_amount = $ebastaInfo['MortgagedAmount'];