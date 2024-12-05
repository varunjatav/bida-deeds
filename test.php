<?php

include_once 'config.php';
include_once 'includes/checkSession.php';
include_once 'includes/get_time_zone.php';
include_once 'dbcon/db_connect.php';
include_once 'functions/common.function.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/*
 *
  $files = '152730_gataebasta_606051_1721411116_6774918_1321906133_274249380.pdf,152730_gataebasta_606051_1721409339_8109208_20653015_1442955339.pdf,152751_gataebasta_455395_1720685219_5626077_3782892619_1545881845.pdf,152751_gataebasta_482694_1721307808_2321885_8674287033_2145607550.pdf,152746_gataebasta_2487248_1722428456_6685263_5168312312_1479029868.pdf,152746_gataebasta_2487248_1722428251_3377536_6098230559_359490723.pdf,152737_gataebasta_582151_1721578304_7292133_4363432917_420679504.pdf,152737_gataebasta_582151_1721390384_1714695_6288301549_624645556.pdf,152754_gataebasta_362863_1722428228_8504256_8934102667_1318563872.pdf,152754_gataebasta_362863_1722683860_1741757_8406493693_482678054.pdf,152754_gataebasta_370332_1720619718_95397_1717786850_1688545985.pdf,152754_gataebasta_370332_1722429350_3745465_924737354_1042464381.pdf,152754_gataebasta_440487_1721136560_7974408_7644234209_584262186.pdf,152754_gataebasta_440487_1722488251_7241950_1168734821_806541325.pdf,152754_gataebasta_567685_1722062017_7893700_884122022_1677383121.pdf,152754_gataebasta_534286_1721311556_3478033_5913699130_1041348480.pdf,152759_gataebasta_704999_1722435218_2833352_8568808274_1638684352.pdf,152759_gataebasta_704999_1721731792_7753230_6618699317_1324676362.pdf,152759_gataebasta_704999_1721805360_3120323_5043520546_1826596019.pdf,152759_gataebasta_542803_1721806724_4419262_6742649474_1554057817.pdf,152759_gataebasta_542803_1722663327_7667033_1837121469_1793228898.pdf,152759_gataebasta_479142_1722429086_8871933_30653764_1920860805.pdf,152741_gataebasta_658680_1716894306_9449783_9873910865_208881653.pdf,152741_gataebasta_658680_1716893764_6757772_217845851_1466723177.pdf,152741_gataebasta_534707_1716623265_8685304_5676486645_1558214548.pdf,152741_gataebasta_534707_1716636420_2937396_8694875445_1559793063.pdf';

  foreach (explode(',', $files) as $file) {
  $village_query = $db->prepare("SELECT T1.ID
  FROM lm_gata_ebasta T1
  WHERE T1.Ebasta2 LIKE ?
  ");

  $village_query->bindValue(1, '%'.$file.'%');
  $village_query->execute();
  $village_query->setFetchMode(PDO::FETCH_ASSOC);
  while ($row = $village_query->fetch()) {
  $info[] = $row['ID'];
  }
  }

  echo implode(',', $info);
 */

/*
  $village_query = $db->prepare("SELECT T1.VillageCode
  FROM lm_village T1
  ");

  $village_query->execute();
  $village_query->setFetchMode(PDO::FETCH_ASSOC);
  while ($row = $village_query->fetch()) {

  $village_query1 = $db->prepare("SELECT T1.VillageCode, T1.GataNo, T1.KhataNo
  FROM lm_user_village_gata_mapping T1
  WHERE T1.VillageCode = ?

  ");

  $village_query1->bindParam(1, $row['VillageCode']);
  $village_query1->execute();
  $village_query1->setFetchMode(PDO::FETCH_ASSOC);
  while ($row1 = $village_query1->fetch()) {
  $gata_no = str_replace(' ', '', preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $row1['GataNo']));
  //echo $gata_no.'<br>';
  $updt = $db->prepare("UPDATE lm_user_village_gata_mapping SET GataNo = ? WHERE VillageCode = ? AND GataNo = ?");
  $updt->bindParam(1, $gata_no);
  $updt->bindParam(2, $row1['VillageCode']);
  $updt->bindParam(3, $row1['GataNo']);
  $updt->execute();
  }
  }

  $village_query = $db->prepare("SELECT T1.VillageCode
  FROM lm_village T1
  WHERE T1.VillageCode = 152743
  ");

  $village_query->execute();
  $village_query->setFetchMode(PDO::FETCH_ASSOC);
  while ($row = $village_query->fetch()) {

  $village_query1 = $db->prepare("SELECT T1.VillageCode, T1.GataNo, T1.KhataNo
  FROM lm_gata T1
  LEFT JOIN lm_user_village_gata_mapping T2 ON T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo
  WHERE T1.VillageCode = ?
  ");

  $village_query1->bindParam(1, $row['VillageCode']);
  $village_query1->execute();
  $village_query1->setFetchMode(PDO::FETCH_ASSOC);
  while ($row1 = $village_query1->fetch()) {
  //echo "UPDATE lm_user_village_gata_mapping SET KhataNo = " . $row1['KhataNo'] . " WHERE VillageCode = " . $row1['VillageCode'] . " AND GataNo = " . $row1['GataNo'] . " <br>";
  $updt = $db->prepare("UPDATE lm_user_village_gata_mapping SET KhataNo = ? WHERE VillageCode = ? AND GataNo = ? ");
  $updt->bindParam(1, $row1['KhataNo']);
  $updt->bindParam(2, $row1['VillageCode']);
  $updt->bindParam(3, $row1['GataNo']);
  $updt->execute();
  }
  }
 *
 */

$village_query = $db->prepare("SELECT T1.VilekhSankhya, T1.Ebasta2, T1.BainamaAmount, T1.PatravaliStatus, T1.PaymentAmount, T1.PaymentDate, T1.BainamaArea
                                FROM lm_gata_ebasta T1
                                WHERE T1.VilekhSankhya > 0
                                GROUP BY T1.VilekhSankhya
                                ");

$village_query->execute();
$village_query->setFetchMode(PDO::FETCH_ASSOC);
$info = array();
while ($row = $village_query->fetch()) {

    $vilekh_sankhya = $row['VilekhSankhya'];
    $bainama_amount = $row['BainamaAmount'];
    $patravali_status = $row['PatravaliStatus'];
    $payment_amount = $row['PaymentAmount'];
    $payment_date = $row['PaymentDate'];
    $bainama_area = $row['BainamaArea'];
    $ebasta_2 = json_decode($row['Ebasta2'], true);
    $file = $ebasta_2[0]['file_name'];

    $village_query1 = $db->prepare("SELECT T1.ID, T1.VilekhSankhya, T1.Ebasta2
                                FROM lm_gata_ebasta T1
                                WHERE T1.Ebasta2 LIKE ?
                                ");

    $village_query1->bindValue(1, '%' . $file . '%');
    $village_query1->execute();
    $village_query1->setFetchMode(PDO::FETCH_ASSOC);

    $file_ids = array();
    while ($row1 = $village_query1->fetch()) {
        $ebasta2 = json_decode($row1['Ebasta2'], true);
        $file2 = $ebasta2[0]['file_name'];

        if (!$row1['VilekhSankhya']) {
            if ($file == $file2) {
                $file_ids[] = $row1['ID'];
            }
        }
    }
    if ($file_ids) {
        $info[] = array('file' => $file, 'vilekh' => $vilekh_sankhya, 'bainama_amount' => $bainama_amount, 'patravali_status' => $patravali_status, 'payment_amount' => $payment_amount, 'payment_date' => $payment_date, 'bainama_area' => $bainama_area, 'ID' => implode(',', $file_ids));

        $placeholders = '';
        $qPart = array_fill(0, count_($file_ids), "?");
        $placeholders .= implode(",", $qPart);

        $updt = $db->prepare("UPDATE lm_gata_ebasta SET VilekhSankhya = ?, BainamaAmount = ?, PatravaliStatus = ?, PaymentAmount = ?, PaymentDate = ?, BainamaArea = ? WHERE ID IN ($placeholders)");
        $updt->bindParam(1, $vilekh_sankhya);
        $updt->bindParam(2, $bainama_amount);
        $updt->bindParam(3, $patravali_status);
        $updt->bindParam(4, $payment_amount);
        $updt->bindParam(5, $payment_date);
        $updt->bindParam(6, $bainama_area);
        $i = 7;
        foreach ($file_ids as $key => $id) {
            $updt->bindParam($i++, $file_ids[$key]);
        }
        $updt->execute();
    }
}

echo '<pre>';
print_r($info);
