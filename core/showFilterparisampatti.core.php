<?php

$village_query = $db->prepare("SELECT T1.VillageName, T1.VillageCode
                        FROM lm_village T1
                        WHERE T1.Active = ?
                        ORDER BY T1.VillageName ASC
                        ");
$village_query->bindValue(1, 1);
$village_query->execute();
$village_query->setFetchMode(PDO::FETCH_ASSOC);
$villageInfo = $village_query->fetchAll();

$dept_query = $db->prepare("SELECT T1.ID, T1.DepartmentName
                                FROM lm_asset_survey_department T1
                                WHERE T1.Active = ?
                                ");
$dept_query->bindValue(1, 1);
$dept_query->execute();
$dept_query->setFetchMode(PDO::FETCH_ASSOC);
$dept_query->setFetchMode(PDO::FETCH_ASSOC);
$deptInfo = $dept_query->fetchAll();

