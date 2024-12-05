<?php

$column_arr = array();
$column_head = array();

$user_id = $_SESSION['UserID'];
$user_type = $_SESSION['UserType'];
$sorting_database = $_REQUEST['sorting_database'];
$action = $_REQUEST['action'];
$village_id = $_REQUEST['village_id'];
$exportlist = $_REQUEST['exportlist'];
$column_arr = explode(',', $_REQUEST['column_arr']);
$column_head = explode(',', $_REQUEST['column_head']);
$limit = is_numeric($_POST['pagelimit']) ? $_POST['pagelimit'] : 100;
$srno_list = $_POST['srno'];
$offset = $_POST['offset'] == '' ? 0 : $_POST['offset'];
$start = (int) $limit * (int) $offset;
$page = (int) $offset + 1;
$msg_id = decryptIt($_REQUEST['id']);
$srno = ($page - 1) * $limit;
$user_village_code = getUserVillageMapping($db, $user_id);
$village_code_list_array = implode("','", $user_village_code);
$mahal = $db->prepare("SELECT T1.ID, T1.MahalName, T1.VillageCode
                        FROM lm_village_mahal_names T1
                        WHERE T1.VillageCode IN ('$village_code_list_array')
                        ORDER BY T1.MahalName ASC
                        ");
$mahal->execute();
$mahal->setFetchMode(PDO::FETCH_ASSOC);
$mahal_data_array = array();
while ($row = $mahal->fetch()) {
    $mahal_data_array[] = $row;
}

if ($action == 'filter_applied') {
    $khata_no = trim($_REQUEST['khata_no']) . '%';
    $village_gata = trim($_REQUEST['village_gata']) . '%';
    //$shreni = trim($_REQUEST['shreni']) . '%';
    $gata_1359_anusar = trim($_REQUEST['gata_1359_anusar']);
    $khata_1359_anusar = trim($_REQUEST['khata_1359_anusar']);
    $mahal_name = trim($_POST['mahal_name']);
}

$village_code_list = implode("','", $village_names_code_array);

$sql = "SELECT SQL_CALC_FOUND_ROWS T1.*, T2.VillageName, T2.VillageNameHi
        FROM lm_api_1359_fasli_data T1
        LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
        WHERE T1.VillageCode  IN ('$village_code_list_array')";
if ($_REQUEST['id']) {
    $sql .= " AND T1.ID = ?";
}
if ($_REQUEST['khata_no']) {
    $sql .= " AND T1.KhataNo Like ?";
}
if ($_REQUEST['village_gata']) {
    $sql .= " AND T1.GataNo Like ?";
}
//if ($_REQUEST['shreni']) {
//    $sql .= " AND T1.Shreni Like ?";
//}
if ($_REQUEST['mahal_name']) {
    $sql .= " AND T1.MahalName = ?";
}
if ($_REQUEST['khata_1359_anusar']) {
    $sql .= " AND T1.1359_fasli_khata = ?";
}
if ($_REQUEST['gata_1359_anusar']) {
    $sql .= " AND T1.1359_fasli_gata = ?";
}

if ($sorting_database == '1') {
    $sql .= " ORDER BY T1.KhataNo ASC";
} else if ($sorting_database == '2') {
    $sql .= " ORDER BY T1.KhataNo DESC";
} else if ($sorting_database == '3') {
    $sql .= " ORDER BY T1.GataNo ASC";
} else if ($sorting_database == '4') {
    $sql .= " ORDER BY T1.GataNo DESC";
} else if ($sorting_database == '5') {
    $sql .= " ORDER BY T1.Shreni ASC";
} else if ($sorting_database == '6') {
    $sql .= " ORDER BY T1.Shreni DESC";
} else if ($sorting_database == '7') {
    $sql .= " ORDER BY T1.Area ASC";
} else if ($sorting_database == '8') {
    $sql .= " ORDER BY T1.Area DESC";
} else if ($sorting_database == '9') {
    $sql .= " ORDER BY T1.RakbaA ASC";
} else if ($sorting_database == '10') {
    $sql .= " ORDER BY T1.RakbaA DESC";
} else if ($sorting_database == '11') {
    $sql .= " ORDER BY T1.kashtkar_owner_name ASC";
} else if ($sorting_database == '12') {
    $sql .= " ORDER BY T1.kashtkar_owner_name DESC";
} else if ($sorting_database == '13') {
    $sql .= " ORDER BY T1.kashtkar_owner_father ASC";
} else if ($sorting_database == '14') {
    $sql .= " ORDER BY T1.kashtkar_owner_father DESC";
} else if ($sorting_database == '15') {
    $sql .= " ORDER BY T1.MahalName ASC";
} else if ($sorting_database == '16') {
    $sql .= " ORDER BY T1.MahalName DESC";
} else if ($sorting_database == '17') {
    $sql .= " ORDER BY T1.1359_fasli_khata ASC";
} else if ($sorting_database == '18') {
    $sql .= " ORDER BY T1.1359_fasli_khata DESC";
} else if ($sorting_database == '19') {
    $sql .= " ORDER BY T1.1359_fasli_gata ASC";
} else if ($sorting_database == '20') {
    $sql .= " ORDER BY T1.1359_fasli_gata DESC";
} else {
    $sql .= " ORDER BY T1.KhataNo ASC";
}

if ($exportlist != 'export') {
    $sql .= " LIMIT " . $start . ", " . $limit;
}
$i = 1;
$sql = $db->prepare($sql);
if ($_REQUEST['id']) {
    $sql->bindParam($i++, $msg_id);
}
if ($_REQUEST['khata_no']) {
    $sql->bindParam($i++, $khata_no);
}
if ($_REQUEST['village_gata']) {
    $sql->bindParam($i++, $village_gata);
}
//if ($_REQUEST['shreni']) {
//    $sql->bindParam($i++, $shreni);
//}
if ($_REQUEST['mahal_name']) {
    $sql->bindParam($i++, $mahal_name);
}
if ($_REQUEST['khata_1359_anusar']) {
    $sql->bindParam($i++, $khata_1359_anusar);
}
if ($_REQUEST['gata_1359_anusar']) {
    $sql->bindParam($i++, $gata_1359_anusar);
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