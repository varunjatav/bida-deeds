<?php

include_once '../config.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';

try {
// Begin Transaction
    $db->beginTransaction();

    $sql = $db->prepare("SELECT T1.ID, T1.AssetSurveyID, T1.DimensionNumber 
                                      FROM lm_asset_survey_data_details T1
                                      WHERE T1.TreeID != ?
                                      AND T1.SubTreeID != ?
                                      AND T1.MinorID = ?
                                      AND T1.PropertyID = ?
                                         ");
    $sql->bindValue(1, 0);
    $sql->bindValue(2, 0);
    $sql->bindValue(3, 0);
    $sql->bindValue(4, 0);
    $sql->execute();
    $count = $sql->rowCount();
    $sql->setFetchMode(PDO::FETCH_ASSOC);

    while ($row = $sql->fetch()) {

        if ($row['DimensionNumber'] >= 0 && $row['DimensionNumber'] <= 30) {
            $diment_no = 1;
        } else if ($row['DimensionNumber'] >= 31 && $row['DimensionNumber'] <= 60) {
            $diment_no = 2;
        } else if ($row['DimensionNumber'] >= 61 && $row['DimensionNumber'] <= 90) {
            $diment_no = 3;
        } else if ($row['DimensionNumber'] >= 91 && $row['DimensionNumber'] <= 120) {
            $diment_no = 4;
        } else if ($row['DimensionNumber'] >= 121 && $row['DimensionNumber'] <= 150) {
            $diment_no = 5;
        } else if ($row['DimensionNumber'] >= 151 && $row['DimensionNumber'] <= 180) {
            $diment_no = 6;
        } else if ($row['DimensionNumber'] > 180) {
            $diment_no = 7;
        }

        $updt = $db->prepare("UPDATE lm_asset_survey_data_details SET DimensionNumber = ? WHERE ID = ? AND AssetSurveyID = ?");
        $updt->bindParam(1, $diment_no);
        $updt->bindParam(2, $row['ID']);
        $updt->bindParam(3, $row['AssetSurveyID']);
        $updt->execute();
    }

    $db_respose_data = array();
    // Make the changes to the database permanent
    commit($db, 'Updated successfully.', $db_respose_data);
} catch (\Exception $e) {
    if ($db->inTransaction()) {
        $db->rollback();
    }

    // return response
    $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
    rollback($db, $e->getCode(), $log_error_msg);
}