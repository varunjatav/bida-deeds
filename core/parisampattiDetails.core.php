<?php

$asset_survey_id = decryptIt(myUrlEncode($_REQUEST['asset_surveyId']));
$department_name = $_REQUEST['department_name'];
$village_name = $_REQUEST['village_name'];
$gata_no = $_REQUEST['gata_no'];
$khata_no = $_REQUEST['khata_no'];

$sql = "SELECT SQL_CALC_FOUND_ROWS T1.ID,  T1.DimensionNumber, T1.DimensionAmount, T1.Amount, T1.DifferentAmountType, T1.TotalDimentsionCount, T1.TotalDimensionAmount, T2.TreeName, T3.SubTreeName, T4.MinorPropertyName, T5.PropertyName
                        FROM lm_asset_survey_data_details T1
                        LEFT JOIN lm_asset_survey_tree T2 ON T2.ID = T1.TreeID
                        LEFT JOIN lm_asset_survey_sub_tree T3 ON T3.ID = T1.SubTreeID
                        LEFT JOIN lm_asset_survey_minor_property T4 ON T4.ID = T1.MinorID
                        LEFT JOIN lm_asset_survey_property T5 ON T5.ID = T1.PropertyID
                        WHERE T1.AssetSurveyID = ?
                        ORDER BY T1.ID DESC
                        ";
// echo $sql;
$i = 1;
$sql = $db->prepare($sql);
$sql->bindParam($i++, $asset_survey_id);
$sql->execute();
$rs1 = $db->query('SELECT FOUND_ROWS()');
$total_count = (int) $rs1->fetchColumn();
$sql->setFetchMode(PDO::FETCH_ASSOC);
