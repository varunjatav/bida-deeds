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

// get post data if filter appplied
if ($action == 'filter_applied') {
    $khata_no = trim($_REQUEST['khata_no']) . '%';
    $village_code = trim($_REQUEST['village_code']);
    $decrypt_data = $_POST['village_gata'] ? decryptIt(myUrlEncode(trim($_POST['village_gata']))) : '';
    $explode_data = explode('@', $decrypt_data);
    $gata_no = $explode_data[0];
    $khata_no = $explode_data[1];
    $gata_area = $explode_data[2];
    $uid_no = trim($_REQUEST['uid_no']);
}

$sql = "SELECT SQL_CALC_FOUND_ROWS T1.*, T2.VillageName
                        FROM lm_gata T1
                        LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                        WHERE 1 = 1
                        ";
if ($_REQUEST['khata_no']) {
    $sql .= " AND T1.KhataNo = ?";
}
if ($_REQUEST['village_code']) {
    $sql .= " AND T1.VillageCode = ?";
}
if ($_REQUEST['village_gata']) {
    $sql .= " AND T1.GataNo = ? AND T1.KhataNo = ? AND ROUND(CAST(T1.Area AS FLOAT), 4) = ?";
}
if ($_REQUEST['uid_no']) {
    $sql .= " AND T1.UID = ?";
}
$sql .= " ORDER BY T1.ID DESC";

if ($exportlist != 'export') {
    $sql .= " LIMIT " . $start . ", " . $limit . "";
}
// echo $sql;
$i = 1;
$sql = $db->prepare($sql);
// bind every placeholder
if ($_REQUEST['khata_no']) {
    $sql->bindParam($i++, $khata_no);
}
if ($_REQUEST['village_code']) {
    $sql->bindParam($i++, $village_code);
}
if ($_REQUEST['village_gata']) {
    $sql->bindParam($i++, $gata_no);
    $sql->bindParam($i++, $khata_no);
    $sql->bindParam($i++, $gata_area);
}
if ($_REQUEST['uid_no']) {
    $sql->bindParam($i++, $uid_no);
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