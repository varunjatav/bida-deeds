<?php

$column_arr = array();
$column_head = array();

$user_id = $_SESSION['UserID'];
$user_type = $_SESSION['UserType'];
$column_arr = explode(',', $_REQUEST['column_arr']);
$column_head = explode(',', $_REQUEST['column_head']);

$lekhpal_query = $db->prepare("SELECT T2.UserID, T3.Name
                                FROM lm_user_village_gata_mapping T2
                                LEFT JOIN lm_users T3 ON T3.ID = T2.UserID
                                WHERE 1 = 1
                                GROUP BY T2.UserID
                                ORDER BY T3.Name ASC
                                ");
$lekhpal_query->execute();
$lekhpal_query->setFetchMode(PDO::FETCH_ASSOC);
$lekhpalInfo = $lekhpal_query->fetchAll();

$kashtkar_count_query = $db->prepare("SELECT T1.UserID
                                        FROM lm_user_village_gata_mapping T1
                                        LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo)
                                        LEFT JOIN lm_gata_kashtkar T3 ON (T3.VillageCode = T2.VillageCode AND T3.GataNo = T2.GataNo)
                                        WHERE T2.BoardApproved = ?
                                        AND 1 = 1
                                        AND (T2.Shreni = ? OR T2.Shreni = ?)
                                        GROUP BY T1.UserID, T1.VillageCode, T3.owner_name, T3.owner_father
                                        ");
$kashtkar_count_query->bindValue(1, 'YES');
$kashtkar_count_query->bindValue(2, '1-क');
$kashtkar_count_query->bindValue(3, '2');
$kashtkar_count_query->execute();
$kashtkar_count_query->setFetchMode(PDO::FETCH_ASSOC);
$kashtkar_count = array();
$kashtkar_count = $kashtkar_count_query->fetchAll();
$kashtkar_count_array = array();
$kashtkar_count_array = array_count_values(array_column($kashtkar_count, 'UserID'));

$dar_nirdharit_query = $db->prepare("SELECT T1.UserID, ROUND(SUM(T2.RequiredArea), 4) AS RequiredArea
                                        FROM lm_user_village_gata_mapping T1
                                        LEFT JOIN lm_gata T2 ON T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo
                                        WHERE 1 = 1
                                        AND T2.BoardApproved = ?
                                        AND (T2.Shreni = ? OR T2.Shreni = ?)
                                        AND CAST(T2.land_total_amount AS Float) > ?
                                        GROUP BY T1.UserID, T1.VillageCode, T2.KhataNo, T2.GataNo
                                        ");
$dar_nirdharit_query->bindValue(1, 'YES');
$dar_nirdharit_query->bindValue(2, '1-क');
$dar_nirdharit_query->bindValue(3, '2');
$dar_nirdharit_query->bindValue(4, 0);
$dar_nirdharit_query->execute();
$dar_nirdharit_query->setFetchMode(PDO::FETCH_ASSOC);
$dar_nirdharit_area = array();
$dar_nirdharit_area = $dar_nirdharit_query->fetchAll();
$total_sahmati_area_array = array();
$total_sahmati_area_array = twod_array_sum_count_values($dar_nirdharit_area, 'UserID', 'RequiredArea');

$sql = $db->prepare("SELECT T1.UserID, ROUND(SUM(T2.AnshRakba), 4) AS AnshRakba
                        FROM lm_user_village_gata_mapping T1
                        LEFT JOIN lm_gata_ebasta T2 ON T2.VillageCode = T1.VillageCode AND T2.KhataNo = T1.KhataNo AND T2.GataNo = T1.GataNo
                        LEFT JOIN lm_gata T3 ON T3.VillageCode = T2.VillageCode AND T3.GataNo = T2.GataNo AND T3.KhataNo = T2.KhataNo
                        WHERE 1 = 1
                        AND MATCH(T2.Ebasta1) AGAINST (?)
                        AND (T3.Shreni = ? OR T3.Shreni = ?)
                        AND T3.BoardApproved = ?
                        GROUP BY T1.UserID, T1.VillageCode, T1.KhataNo, T1.GataNo
                        ");
$sql->bindValue(1, 'file_name');
$sql->bindValue(2, '1-क');
$sql->bindValue(3, '2');
$sql->bindValue(4, 'YES');
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
$sahmati_count = array();
$sahmati_count = $sql->fetchAll();
$sahmati_count_array = array();
$sahmati_count_array = array_count_values(array_column($sahmati_count, 'UserID'));
$uploaded_sahmati_area_array = twod_array_sum_count_values($sahmati_count, 'UserID', 'AnshRakba');

$sql = $db->prepare("SELECT T1.UserID, ROUND(SUM(T2.AnshRakba), 4) AS AnshRakba
                        FROM lm_user_village_gata_mapping T1
                        LEFT JOIN lm_gata_ebasta T2 ON T2.VillageCode = T1.VillageCode AND T2.KhataNo = T1.KhataNo AND T2.GataNo = T1.GataNo
                        LEFT JOIN lm_gata T3 ON T3.VillageCode = T2.VillageCode AND T3.GataNo = T2.GataNo AND T3.KhataNo = T2.KhataNo
                        WHERE 1 = 1
                        AND MATCH(T2.Ebasta2) AGAINST (?)
                        AND (T3.Shreni = ? OR T3.Shreni = ?)
                        AND T3.BoardApproved = ?
                        GROUP BY T1.UserID, T1.VillageCode, T1.KhataNo, T1.GataNo
                        ");
$sql->bindValue(1, 'file_name');
$sql->bindValue(2, '1-क');
$sql->bindValue(3, '2');
$sql->bindValue(4, 'YES');
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
$bainama_count = array();
$bainama_count = $sql->fetchAll();
$bainama_count_array = array();
$bainama_count_array = array_count_values(array_column($bainama_count, 'UserID'));
$uploaded_bainama_area_array = twod_array_sum_count_values($bainama_count, 'UserID', 'AnshRakba');

$sql = $db->prepare("SELECT T1.UserID, ROUND(SUM(T2.AnshRakba), 4) AS AnshRakba
                        FROM lm_user_village_gata_mapping T1
                        LEFT JOIN lm_gata_ebasta T2 ON T2.VillageCode = T1.VillageCode AND T2.KhataNo = T1.KhataNo AND T2.GataNo = T1.GataNo
                        LEFT JOIN lm_gata T3 ON T3.VillageCode = T2.VillageCode AND T3.GataNo = T2.GataNo AND T3.KhataNo = T2.KhataNo
                        WHERE 1 = 1
                        AND MATCH(T2.Ebasta3) AGAINST (?)
                        AND (T3.Shreni = ? OR T3.Shreni = ?)
                        AND T3.BoardApproved = ?
                        GROUP BY T1.UserID, T1.VillageCode, T1.KhataNo, T1.GataNo
                        ");
$sql->bindValue(1, 'file_name');
$sql->bindValue(2, '1-क');
$sql->bindValue(3, '2');
$sql->bindValue(4, 'YES');
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
$khatauni_count = array();
$khatauni_count = $sql->fetchAll();
$khatauni_count_array = array();
$khatauni_count_array = array_count_values(array_column($khatauni_count, 'UserID'));
$uploaded_khatauni_area_array = twod_array_sum_count_values($khatauni_count, 'UserID', 'AnshRakba');

$sql = $db->prepare("SELECT T1.UserID, ROUND(SUM(T2.AnshRakba), 4) AS AnshRakba
                        FROM lm_user_village_gata_mapping T1
                        LEFT JOIN lm_gata_ebasta T2 ON T2.VillageCode = T1.VillageCode AND T2.KhataNo = T1.KhataNo AND T2.GataNo = T1.GataNo
                        LEFT JOIN lm_gata T3 ON T3.VillageCode = T2.VillageCode AND T3.GataNo = T2.GataNo AND T3.KhataNo = T2.KhataNo
                        WHERE 1 = 1
                        AND MATCH(T2.Ebasta4) AGAINST (?)
                        AND (T3.Shreni = ? OR T3.Shreni = ?)
                        AND T3.BoardApproved = ?
                        GROUP BY T1.UserID, T1.VillageCode, T1.KhataNo, T1.GataNo
                        ");
$sql->bindValue(1, 'file_name');
$sql->bindValue(2, '1-क');
$sql->bindValue(3, '2');
$sql->bindValue(4, 'YES');
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
$kabza_count = array();
$kabza_count = $sql->fetchAll();
$kabza_count_array = array();
$kabza_count_array = array_count_values(array_column($kabza_count, 'UserID'));
$uploaded_khatauni_area_array = twod_array_sum_count_values($kabza_count, 'UserID', 'AnshRakba');
