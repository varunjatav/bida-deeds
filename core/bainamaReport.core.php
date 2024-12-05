<?php

$count = 1;

$sql = $db->prepare("SELECT T1.ID
                    FROM lm_gata_ebasta T1
                    LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                    WHERE MATCH(T1.Ebasta2) AGAINST (?)
                    AND (T2.Shreni = ? OR T2.Shreni = ?)
                    AND T2.BoardApproved = ?
                    AND CAST(T2.land_total_amount AS FLOAT) = ?
                    GROUP BY T1.VillageCode, T1.KhataNo, T1.GataNo
                    ");
$sql->bindValue(1, 'file_name');
$sql->bindValue(2, '1-क');
$sql->bindValue(3, '2');
$sql->bindValue(4, 'YES');
$sql->bindValue(5, 0);
$sql->execute();
$answer_28 = $sql->rowCount();

$sql = $db->prepare("SELECT T1.Ebasta2, T1.BainamaAmount, COUNT(T1.GataNo) AS TotalGata, SUM((CAST(T2.current_circle_rate AS FLOAT) * T1.AnshRakba)) AS current_circle_rate, SUM((CAST(T2.road_rate AS FLOAT) * T1.AnshRakba)) AS road_rate, SUM((CAST(T2.aabadi_rate AS FLOAT) * T1.AnshRakba)) AS aabadi_rate
                    FROM lm_gata_ebasta T1
                    LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                    WHERE MATCH(T1.Ebasta2) AGAINST (?)
                    AND (T2.Shreni = ? OR T2.Shreni = ?)
                    AND T2.BoardApproved = ?
                    GROUP BY T1.Ebasta2
                    HAVING (current_circle_rate + road_rate + aabadi_rate) > BainamaAmount
                    ");
$sql->bindValue(1, 'file_name');
$sql->bindValue(2, '1-क');
$sql->bindValue(3, '2');
$sql->bindValue(4, 'YES');
$sql->execute();
$answer_29 = $sql->rowCount();

$sql = $db->prepare("SELECT T1.Ebasta2, T1.BainamaAmount, COUNT(T1.GataNo) AS TotalGata, SUM((CAST(T2.current_circle_rate AS FLOAT) * T1.AnshRakba)) AS current_circle_rate, SUM((CAST(T2.road_rate AS FLOAT) * T1.AnshRakba)) AS road_rate, SUM((CAST(T2.aabadi_rate AS FLOAT) * T1.AnshRakba)) AS aabadi_rate
                    FROM lm_gata_ebasta T1
                    LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                    WHERE MATCH(T1.Ebasta2) AGAINST (?)
                    AND (T2.Shreni = ? OR T2.Shreni = ?)
                    AND T2.BoardApproved = ?
                    GROUP BY T1.Ebasta2
                    HAVING (current_circle_rate + road_rate + aabadi_rate) > BainamaAmount
                    ");
$sql->bindValue(1, 'file_name');
$sql->bindValue(2, '1-क');
$sql->bindValue(3, '2');
$sql->bindValue(4, 'YES');
$sql->execute();
$answer_29 = $sql->rowCount();

$sql = $db->prepare("SELECT T1.Ebasta2, T1.VilekhSankhya, T1.KhataNo, T1.GataNo, owner_names, owner_fathers
                    FROM lm_gata_ebasta T1
                    LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                    LEFT JOIN (
                            SELECT T1.ID, T1.VillageCode, T1.Ebasta2, T1.GataNo, COUNT(T1.GataNo) AS TotalGata, GROUP_CONCAT(T1.GataNo) AS Gatas, COUNT(T1.owner_name) AS owner_names, COUNT(T1.owner_father) AS owner_fathers
                            FROM lm_gata_ebasta T1
                            WHERE MATCH(T1.Ebasta2) AGAINST (?)
                            GROUP BY T1.VillageCode, T1.Ebasta2, T1.GataNo, T1.owner_name, T1.owner_father
                    ) AS TMP ON TMP.VillageCode = T1.VillageCode AND TMP.ID = T1.ID
                    WHERE MATCH(T1.Ebasta2) AGAINST (?)
                    AND (T2.Shreni = ? OR T2.Shreni = ?)
                    AND T2.BoardApproved = ?
                    GROUP BY T1.VillageCode, T1.Ebasta2, T1.GataNo
                    HAVING owner_names > 1
                    ");
$sql->bindValue(1, 'file_name');
$sql->bindValue(2, 'file_name');
$sql->bindValue(3, '1-क');
$sql->bindValue(4, '2');
$sql->bindValue(5, 'YES');
$sql->execute();
$answer_30 = $sql->rowCount();

$sql = $db->prepare("SELECT T1.ID
                    FROM lm_gata_ebasta T1
                    LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                    WHERE MATCH(T1.Ebasta5) AGAINST (?)
                    AND (T2.Shreni = ? OR T2.Shreni = ?)
                    AND T2.BoardApproved = ?
                    GROUP BY T1.Ebasta5
                    ");
$sql->bindValue(1, 'file_name');
$sql->bindValue(2, '1-क');
$sql->bindValue(3, '2');
$sql->bindValue(4, 'YES');
$sql->execute();
$answer_31 = $sql->rowCount();
