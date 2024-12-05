<?php

$column_arr = array();
$column_head = array();
$diff_amt = array();

$user_type = $_SESSION['UserType'];
$action = $_REQUEST['action'];
$exportlist = $_REQUEST['exportlist'];
$column_arr = explode(',', $_REQUEST['column_arr']);
$column_head = explode(',', $_REQUEST['column_head']);
$limit = $_POST['pagelimit'] == '' ? 100 : $_POST['pagelimit'];
$offset = $_POST['offset'] == '' ? 0 : $_POST['offset'];
$start = (int) $limit * (int) $offset;
$page = (int) $offset + 1;
$msg_id = $_REQUEST['msg_id'];
$srno = ($page - 1) * $limit;

// get post data if filter appplied
if ($action == 'filter_applied') {
    $department_id = $_REQUEST['department_id'];
    $village_code = $_REQUEST['village_code'];
    $diff_amt = $_REQUEST['diff_amt'];
    $diffPart = array_fill(0, count_($diff_amt), "?");
    $diff_placeholders .= implode(",", $diffPart);
}

$sql = "SELECT SQL_CALC_FOUND_ROWS T1.ID, T1.GataNo, T1.KhataNo, T1.owner_name, T1.owner_father,  T1.PropertyCount, T1.DateCreated, T1.Active, T1.DifferentAmountType, T2.DepartmentName, T3.VillageName
                        FROM lm_asset_survey_data T1
                        LEFT JOIN lm_asset_survey_department T2 ON T2.ID = T1.DepartmentID
                        LEFT JOIN lm_village T3 ON T3.VillageCode = T1.VillageCode
                        WHERE  T1.RowDeleted = ?
                        ";
if ($_REQUEST['department_id']) {
    $sql .= " AND T1.DepartmentID = ?";
}
if ($_REQUEST['village_code']) {
    $sql .= " AND T1.VillageCode = ?";
}
if (count_($diff_amt)) {
    $sql .= " AND T1.DifferentAmountType IN ($diff_placeholders)";
}
$sql .= " ORDER BY T1.ID DESC";

if ($exportlist != 'export') {
    $sql .= " LIMIT " . $start . ", " . $limit . "";
}
// echo $sql;
$i = 1;
$sql = $db->prepare($sql);
$sql->bindValue($i++, 0);
// bind every placeholder
if ($_REQUEST['department_id']) {
    $sql->bindParam($i++, $department_id);
}
if ($_REQUEST['village_code']) {
    $sql->bindParam($i++, $village_code);
}
if (count_($diff_amt)) {
    foreach ($diff_amt as $dkey => $val) {
        $sql->bindParam($i++, $diff_amt[$dkey]);
    }
}
$sql->execute();
$rs1 = $db->query('SELECT FOUND_ROWS()');
$total_count = (int) $rs1->fetchColumn();
$sql->setFetchMode(PDO::FETCH_ASSOC);
$parisamInfo = array();
$survey_id = array();
while ($prow = $sql->fetch()) {
    $parisamInfo[] = $prow;
    $survey_id[] = $prow['ID'];
}

if (count_($survey_id) > 0) {

    $qPart = array_fill(0, count_($survey_id), '?');
    $placeholder .= implode(',', $qPart);

    $survey_details = $db->prepare("SELECT T1.AssetSurveyID, SUM(T1.TotalDimensionAmount) AS TotalDimensionAmount , SUM(T1.Amount) AS ManualAmount
            FROM lm_asset_survey_data_details T1
            WHERE T1.AssetSurveyID IN ($placeholder)
            GROUP BY T1.AssetSurveyID
                            ");
    $j = 1;
    foreach ($survey_id as $pkey => $pval) {
        $survey_details->bindParam($j++, $survey_id[$pkey]);
    }
    $survey_details->execute();
    $survey_details->setFetchMode(PDO::FETCH_ASSOC);
    $surveyAmount = array();
    while ($arow = $survey_details->fetch()) {
        $surveyAmount[$arow['AssetSurveyID']] = array(
            'total_dimenAmt' => $arow['TotalDimensionAmount'],
            'manual_amt' => $arow['ManualAmount'],
        );
    }
}

if ($exportlist != 'export') {
    // start pagination
    $total_pages = ceil($total_count / $limit);

    if ($total_pages > 1) {
        if ($page == 1) {
            $output = $output . '<a class="page_disabled"><img src="img/first.svg"page_disabled width="14px">'
                    . '<a class="page_disabled"><img src="img/previous.svg"page_disabled width="14px"></a></a>';
        } else {
            $output = $output . '<a style="cursor:pointer;" class="paginate first"><img src="img/first.svg" width="14px"></a>'
                    . '<a style="cursor:pointer;" class="paginate_prev"><img src="img/previous.svg" width="14px"></a>';
        }

        if (($page - 3) > 0) {
            if ($page == 1) {
                $output = $output . '<span id=1 class="paginate current">1</span>';
            } else {
                $output = $output . '<a style="cursor:pointer;" class="paginate">1</a>';
            }
        }
        if (($page - 3) > 1) {
            $output = $output . '<span class="dot">...</span>';
        }

        for ($i = ($page - 2); $i <= ($page + 2); $i++) {
            if ($i < 1)
                continue;
            if ($i > $total_pages)
                break;
            if ($page == $i) {
                $output = $output . '<span id=' . $i . ' class="paginate current">' . $i . '</span>';
            } else {
                $output = $output . '<a style="cursor:pointer;" class="paginate">' . $i . '</a>';
            }
        }

        if (($total_pages - ($page + 2)) > 1) {
            $output = $output . '<span class="dot">...</span>';
        }
        if (($total_pages - ($page + 2)) > 0) {
            if ($page == $total_pages) {
                $output = $output . '<span id=' . ($total_pages) . ' class="paginate current">' . ($total_pages) . '</span>';
            } else {
                $output = $output . '<a style="cursor:pointer;" class="paginate">' . ($total_pages) . '</a>';
            }
        }

        if ($page < $total_pages) {
            $output = $output . '<a style="cursor:pointer;" class="paginate_next"><img src="img/next2.svg" width="14px"></a>'
                    . '<a style="cursor:pointer;" class="paginate_last"><img src="img/last.svg" width="14px"></a>';
        } else {
            $output = $output . '<a class="page_disabled"><img src="img/next2.svg" width="14px"></a>'
                    . '<a class="page_disabled"><img src="img/last.svg" width="14px"></a>';
        }
    }
}