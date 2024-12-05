<?php

$column_arr = array();
$column_head = array();

$user_type = $_SESSION['UserType'];
$action = $_REQUEST['action'];
$exportlist = $_REQUEST['exportlist'];
$column_arr = explode(',', $_REQUEST['column_arr']);
$column_head = explode(',', $_REQUEST['column_head']);
$limit = $_POST['pagelimit'] == '' ? 100 : $_POST['pagelimit'];
$offset = $_POST['offset'] == '' ? 0 : $_POST['offset'];
$start = (int) $limit * (int) $offset;
$page = (int) $offset + 1;

$resource_type = myUrlEncode($_GET['resource_type']);
$report_type = myUrlEncode($_GET['report_type']);
$village_code = myUrlEncode($_GET['village_code']);
$gata_no = myUrlEncode($_GET['village_gata']);
$report_no = myUrlEncode($_GET['report_no']);

$sql = "SELECT SQL_CALC_FOUND_ROWS T1.*, T2.VillageName
                        FROM lm_dm_report_feedbacks T1
                        LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                        WHERE 1 = 1
                        ";
if ($_REQUEST['resource_type']) {
    $sql .= " AND T1.ResourceType = ?";
}
if ($_REQUEST['report_type']) {
    $sql .= " AND T1.ReportType = ?";
}
if ($_REQUEST['village_code']) {
    $sql .= " AND T1.VillageCode = ?";
}
if ($_REQUEST['village_gata']) {
    $sql .= " AND T1.GataNo = ?";
}
if ($_REQUEST['report_no']) {
    $sql .= " AND T1.ReportNo = ?";
}
$sql .= " ORDER BY T1.ID DESC";

if ($exportlist != 'export') {
    $sql .= " LIMIT " . $start . ", " . $limit . "";
}
// echo $sql;
$i = 1;
$sql = $db->prepare($sql);
// bind every placeholder
if ($_REQUEST['resource_type']) {
    $sql->bindParam($i++, $resource_type);
}
if ($_REQUEST['report_type']) {
    $sql->bindParam($i++, $report_type);
}
if ($_REQUEST['village_code']) {
    $sql->bindParam($i++, $village_code);
}
if ($_REQUEST['village_gata']) {
    $sql->bindParam($i++, $gata_no);
}
if ($_REQUEST['report_no']) {
    $sql->bindParam($i++, $report_no);
}
$sql->execute();
$rs1 = $db->query('SELECT FOUND_ROWS()');
$total_count = (int) $rs1->fetchColumn();
$sql->setFetchMode(PDO::FETCH_ASSOC);

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
            if ($i < 1) continue;
            if ($i > $total_pages) break;
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