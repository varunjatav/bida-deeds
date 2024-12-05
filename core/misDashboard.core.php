<?php

$user_id = $_SESSION['UserID'];
$user_type = $_SESSION['UserType'];

$block1 = 0;
$block2 = 0;
$block3 = 0;
$block4 = 0;
$block5 = 0;
$block6 = 0;
$block7 = 0;
$block8 = 0;
$block9 = 0;
$block10 = 0;
$block11 = 0;
$block12 = 0;
$block13 = 0;
$block14 = 0;
$block15 = 0;
$block16 = 0;
$block17 = 0;
$block18 = 0;
$block19 = 0;
$block20 = 0;
$block21 = 0;
$block22 = 0;
$block23 = 0;
$block24 = 0;
$block25 = 0;
$block26 = 0;
$block27 = 0;
$block28 = 0;
$block29 = 0;

if ($user_type == '0' || $user_type == '2') {
    $repo_query = $db->prepare("SELECT T1.VillageCode, T1.Report, T1.Current
                            FROM lm_village_sahmati_report T1
                            WHERE 1 = ?
                            ");
    $repo_query->bindValue(1, 1);
    $repo_query->execute();
    $repo_query->setFetchMode(PDO::FETCH_ASSOC);
    while ($row = $repo_query->fetch()) {
        $reportInfo[] = $row;
        $data = json_decode($row['Report'], true);
        if (is_numeric($data[0]['value'])) {
            if ($row['Current'] == '1') {
                $block1 += $data[0]['value'];
            }
        }
        if (is_numeric($data[1]['value'])) {
            if ($row['Current'] == '1') {
                $block2 += $data[1]['value'];
            }
        }
        if (is_numeric($data[2]['value'])) {
            if ($row['Current'] == '1') {
                $block3 += $data[2]['value'];
            }
        }
        if (is_numeric($data[9]['value'])) {
            $block4 += $data[9]['value'];
        }
        if (is_numeric($data[4]['value'])) {
            $block5 += $data[4]['value'];
        }
        if (is_numeric($data[7]['value'])) {
            $block6 += $data[7]['value'];
        }
        if (is_numeric($data[5]['value'])) {
            if ($row['Current'] == '1') {
                $block7 += $data[5]['value'];
            }
        }
        if (is_numeric($data[6]['value'])) {
            if ($row['Current'] == '1') {
                $block8 += $data[6]['value'];
            }
        }
    }

    $repo_query = $db->prepare("SELECT T1.VillageCode, T1.Report, T1.Current
                            FROM lm_village_khatauni_report T1
                            WHERE 1 = ?
                            ");
    $repo_query->bindValue(1, 1);
    $repo_query->execute();
    $repo_query->setFetchMode(PDO::FETCH_ASSOC);
    while ($row = $repo_query->fetch()) {
        $reportInfo[] = $row;
        $data = json_decode($row['Report'], true);
        if (is_numeric($data[6]['value'])) {
            $block9 += $data[6]['value'];
        }
        if (is_numeric($data[7]['value'])) {
            $block10 += $data[7]['value'];
        }
        if (is_numeric($data[8]['value'])) {
            $block11 += $data[8]['value'];
        }
        if (is_numeric($data[4]['value'])) {
            if ($row['Current'] == '1') {
                $block13 += $data[4]['value'];
            }
        }
        if (is_numeric($data[5]['value'])) {
            if ($row['Current'] == '1') {
                $block14 += $data[5]['value'];
            }
        }
        if (is_numeric($data[9]['value'])) {
            $block15 += $data[9]['value'];
        }
        if (is_numeric($data[5]['value'])) {
            $blck_value = $data[10]['value'] ? $data[10]['value'] : 0;
            $block16 += ($data[5]['value'] - $blck_value);
        }
    }

    $repo_query = $db->prepare("SELECT T1.VillageCode, T1.Report
                            FROM lm_village_bainama_report T1
                            WHERE 1 = ?
                            ");
    $repo_query->bindValue(1, 1);
    $repo_query->execute();
    $repo_query->setFetchMode(PDO::FETCH_ASSOC);
    while ($row = $repo_query->fetch()) {
        $reportInfo[] = $row;
        $data = json_decode($row['Report'], true);
        if (is_numeric($data[8]['value'])) {
            $block12 += $data[8]['value'];
        }
        if (is_numeric($data[3]['value'])) {
            $block17 += $data[3]['value'];
        }
        if (is_numeric($data[4]['value'])) {
            $block18 += $data[4]['value'];
        }
        if (is_numeric($data[5]['value'])) {
            $block19 += $data[5]['value'];
        }
        if (is_numeric($data[7]['value'])) {
            $block20 += $data[7]['value'];
        }
    }

    $repo_query = $db->prepare("SELECT T1.VillageCode, T1.Report
                            FROM lm_village_dhanrashi_report T1
                            WHERE 1 = ?
                            ");
    $repo_query->bindValue(1, 1);
    $repo_query->execute();
    $repo_query->setFetchMode(PDO::FETCH_ASSOC);
    while ($row = $repo_query->fetch()) {
        $reportInfo[] = $row;
        $data = json_decode($row['Report'], true);
        if (is_numeric($data[3]['value'])) {
            $block21 += $data[3]['value'];
        }
        if (is_numeric($data[4]['value'])) {
            $block22 += $data[4]['value'];
        }
        if (is_numeric($data[5]['value'])) {
            $block23 += $data[5]['value'];
        }
        if (is_numeric($data[6]['value'])) {
            $block24 += $data[6]['value'];
        }
        if (is_numeric($data[7]['value'])) {
            $block25 += $data[7]['value'];
        }
    }

    $repo_query = $db->prepare("SELECT T1.VillageCode, T1.Report
                            FROM lm_village_kabja_report T1
                            WHERE 1 = ?
                            ");
    $repo_query->bindValue(1, 1);
    $repo_query->execute();
    $repo_query->setFetchMode(PDO::FETCH_ASSOC);
    while ($row = $repo_query->fetch()) {
        $reportInfo[] = $row;
        $data = json_decode($row['Report'], true);
        if (is_numeric($data[5]['value'])) {
            $block26 += $data[5]['value'];
        }
        if (is_numeric($data[6]['value'])) {
            $block27 += $data[6]['value'];
        }
        if (is_numeric($data[4]['value'])) {
            $blck_value = $data[6]['value'] ? $data[6]['value'] : 0;
            $block28 += ($data[4]['value'] - $blck_value);
        }
        if (is_numeric($data[7]['value'])) {
            $block29 += $data[7]['value'];
        }
    }
} else {
    $repo_query = $db->prepare("SELECT T1.VillageCode, T1.Report
                            FROM lm_village_sahmati_report T1
                            LEFT JOIN lm_user_village_mapping T2 ON T2.VillageCode = T1.VillageCode
                            WHERE 1 = ?
                            AND T2.UserID = ?
                            ");
    $repo_query->bindValue(1, 1);
    $repo_query->bindParam(2, $user_id);
    $repo_query->execute();
    $repo_query->setFetchMode(PDO::FETCH_ASSOC);
    while ($row = $repo_query->fetch()) {
        $reportInfo[] = $row;
        $data = json_decode($row['Report'], true);
        if (is_numeric($data[0]['value'])) {
            $block1 += $data[0]['value'];
        }
        if (is_numeric($data[1]['value'])) {
            $block2 += $data[1]['value'];
        }
        if (is_numeric($data[2]['value'])) {
            $block3 += $data[2]['value'];
        }
        if (is_numeric($data[9]['value'])) {
            $block4 += $data[9]['value'];
        }
        if (is_numeric($data[4]['value'])) {
            $block5 += $data[4]['value'];
        }
        if (is_numeric($data[7]['value'])) {
            $block6 += $data[7]['value'];
        }
        if (is_numeric($data[5]['value'])) {
            $block7 += $data[5]['value'];
        }
        if (is_numeric($data[6]['value'])) {
            $block8 += $data[6]['value'];
        }
    }

    $repo_query = $db->prepare("SELECT T1.VillageCode, T1.Report
                            FROM lm_village_khatauni_report T1
                            LEFT JOIN lm_user_village_mapping T2 ON T2.VillageCode = T1.VillageCode
                            WHERE 1 = ?
                            AND T2.UserID = ?
                            ");
    $repo_query->bindValue(1, 1);
    $repo_query->bindParam(2, $user_id);
    $repo_query->execute();
    $repo_query->setFetchMode(PDO::FETCH_ASSOC);
    while ($row = $repo_query->fetch()) {
        $reportInfo[] = $row;
        $data = json_decode($row['Report'], true);
        if (is_numeric($data[6]['value'])) {
            $block9 += $data[6]['value'];
        }
        if (is_numeric($data[7]['value'])) {
            $block10 += $data[7]['value'];
        }
        if (is_numeric($data[8]['value'])) {
            $block11 += $data[8]['value'];
        }
        if (is_numeric($data[4]['value'])) {
            $block13 += $data[4]['value'];
        }
        if (is_numeric($data[5]['value'])) {
            $block14 += $data[5]['value'];
        }
        if (is_numeric($data[9]['value'])) {
            $block15 += $data[9]['value'];
        }
        if (is_numeric($data[5]['value'])) {
            $blck_value = $data[10]['value'] ? $data[10]['value'] : 0;
            $block16 += ($data[5]['value'] - $blck_value);
        }
    }

    $repo_query = $db->prepare("SELECT T1.VillageCode, T1.Report
                            FROM lm_village_bainama_report T1
                            LEFT JOIN lm_user_village_mapping T2 ON T2.VillageCode = T1.VillageCode
                            WHERE 1 = ?
                            AND T2.UserID = ?
                            ");
    $repo_query->bindValue(1, 1);
    $repo_query->bindParam(2, $user_id);
    $repo_query->execute();
    $repo_query->setFetchMode(PDO::FETCH_ASSOC);
    while ($row = $repo_query->fetch()) {
        $reportInfo[] = $row;
        $data = json_decode($row['Report'], true);
        if (is_numeric($data[8]['value'])) {
            $block12 += $data[8]['value'];
        }
        if (is_numeric($data[3]['value'])) {
            $block17 += $data[3]['value'];
        }
        if (is_numeric($data[4]['value'])) {
            $block18 += $data[4]['value'];
        }
        if (is_numeric($data[5]['value'])) {
            $block19 += $data[5]['value'];
        }
        if (is_numeric($data[7]['value'])) {
            $block20 += $data[7]['value'];
        }
    }

    $repo_query = $db->prepare("SELECT T1.VillageCode, T1.Report
                            FROM lm_village_dhanrashi_report T1
                            LEFT JOIN lm_user_village_mapping T2 ON T2.VillageCode = T1.VillageCode
                            WHERE 1 = ?
                            AND T2.UserID = ?
                            ");
    $repo_query->bindValue(1, 1);
    $repo_query->bindParam(2, $user_id);
    $repo_query->execute();
    $repo_query->setFetchMode(PDO::FETCH_ASSOC);
    while ($row = $repo_query->fetch()) {
        $reportInfo[] = $row;
        $data = json_decode($row['Report'], true);
        if (is_numeric($data[3]['value'])) {
            $block21 += $data[3]['value'];
        }
        if (is_numeric($data[4]['value'])) {
            $block22 += $data[4]['value'];
        }
        if (is_numeric($data[5]['value'])) {
            $block23 += $data[5]['value'];
        }
        if (is_numeric($data[6]['value'])) {
            $block24 += $data[6]['value'];
        }
        if (is_numeric($data[7]['value'])) {
            $block25 += $data[7]['value'];
        }
    }

    $repo_query = $db->prepare("SELECT T1.VillageCode, T1.Report
                            FROM lm_village_kabja_report T1
                            LEFT JOIN lm_user_village_mapping T2 ON T2.VillageCode = T1.VillageCode
                            WHERE 1 = ?
                            AND T2.UserID = ?
                            ");
    $repo_query->bindValue(1, 1);
    $repo_query->bindParam(2, $user_id);
    $repo_query->execute();
    $repo_query->setFetchMode(PDO::FETCH_ASSOC);
    while ($row = $repo_query->fetch()) {
        $reportInfo[] = $row;
        $data = json_decode($row['Report'], true);
        if (is_numeric($data[5]['value'])) {
            $block26 += $data[5]['value'];
        }
        if (is_numeric($data[6]['value'])) {
            $block27 += $data[6]['value'];
        }
        if (is_numeric($data[4]['value'])) {
            $blck_value = $data[6]['value'] ? $data[6]['value'] : 0;
            $block28 += ($data[4]['value'] - $blck_value);
        }
        if (is_numeric($data[7]['value'])) {
            $block29 += $data[7]['value'];
        }
    }
}