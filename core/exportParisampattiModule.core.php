<?php

$user_id = $_SESSION['UserID'];
$mobile = $_SESSION['Mobile'];

$parisampatti = $db->prepare("SELECT T1.ID, T1.DimensionNumber, T1.DimensionAmount, T1.Amount, T1.DifferentAmountType, T1.TotalDimentsionCount, T1.TotalDimensionAmount, T2.GataNo, T2.KhataNo, T3.TreeName, T4.SubTreeName, T5.MinorPropertyName, T6.PropertyName,  T7.DepartmentName, T8.VillageName
                        FROM lm_asset_survey_data_details T1
                         LEFT JOIN lm_asset_survey_data T2 ON T2.ID = T1.AssetSurveyID
                        LEFT JOIN lm_asset_survey_tree T3 ON T3.ID = T1.TreeID
                        LEFT JOIN lm_asset_survey_sub_tree T4 ON T4.ID = T1.SubTreeID
                        LEFT JOIN lm_asset_survey_minor_property T5 ON T5.ID = T1.MinorID
                        LEFT JOIN lm_asset_survey_property T6 ON T6.ID = T1.PropertyID
                        LEFT JOIN lm_asset_survey_department T7 ON T7.ID = T2.DepartmentID
                        LEFT JOIN lm_village T8 ON T8.VillageCode = T2.VillageCode
                        Where T2.RowDeleted = ?
                        ORDER BY T1.ID DESC
                        ");
$parisampatti->bindValue(1, 0);
$parisampatti->execute();
$parisampatti->setFetchMode(PDO::FETCH_ASSOC);

