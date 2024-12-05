<?php

include_once dirname(dirname(dirname(__FILE__))) . '/config.php';
include_once dirname(dirname(dirname(__FILE__))) . '/dbcon/db_connect.php';
include_once dirname(dirname(dirname(__FILE__))) . '/functions/common.function.php';

$block17_count = $db->prepare("SELECT ROUND(SUM(T2.Area), 4) AS AreaAccquired
                                FROM lm_village T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode
                                WHERE T1.Active = ?
                                AND T2.BoardApproved = ?
                                AND (T2.Shreni = ? OR T2.Shreni = ? OR T2.Shreni LIKE ? OR T2.Shreni LIKE ?)
                                ");
$block17_count->bindValue(1, '1');
$block17_count->bindValue(2, 'YES');
$block17_count->bindValue(3, '1-क');
$block17_count->bindValue(4, '2');
$block17_count->bindValue(5, '5%');
$block17_count->bindValue(6, '6%');
$block17_count->execute();
$block17_count = $block17_count->fetch();
$area_to_acquired = $block17_count['AreaAccquired'];

$block29_count = $db->prepare("SELECT T1.ID, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.OwnerNo, ROUND(SUM(T1.AnshRakba), 4) AS AnshRakba, T2.Shreni
                                FROM lm_gata_ebasta T1
                                LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo

                                WHERE T2.BoardApproved = ?
                                AND (T2.Shreni = ? OR T2.Shreni = ? OR T2.Shreni LIKE ? OR T2.Shreni LIKE ?)
                                AND MATCH(T1.Ebasta2) AGAINST (?)
                                GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                                ");
$block29_count->bindValue(1, 'YES');
$block29_count->bindValue(2, '1-क');
$block29_count->bindValue(3, '2');
$block29_count->bindValue(4, '5%');
$block29_count->bindValue(5, '6%');
$block29_count->bindValue(6, 'file_name');
$block29_count->execute();
$area_purchased_till_date = 0;
while ($row = $block29_count->fetch()) {
    $area_purchased_till_date += $row['AnshRakba'];
}

$area_of_land_to_acquired = 0;
$total_land_to_be_acquired = 0;
$land_data_array = array(
    'total_land' => $area_purchased_till_date,
    'tobe_aquire_land' => $area_to_acquired
);
print(json_encode($land_data_array, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
