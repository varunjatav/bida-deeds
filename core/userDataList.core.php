<?php

$column_arr = array();
$column_head = array();

$user_id = $_SESSION['UserID'];
$user_type = $_SESSION['UserType'];
$action = $_REQUEST['action'];
$village_id = $_REQUEST['village_id'];
$exportlist = $_REQUEST['exportlist'];
$column_arr = explode(',', $_REQUEST['column_arr']);
$column_head = explode(',', $_REQUEST['column_head']);
$limit = $_POST['pagelimit'] == '' ? 100 : $_POST['pagelimit'];
$srno_list = $_POST['srno'];
$offset = $_POST['offset'] == '' ? 0 : $_POST['offset'];
$start = (int) $limit * (int) $offset;
$page = (int) $offset + 1;
$msg_id = decryptIt($_REQUEST['id']);
$srno = ($page - 1) * $limit;

if ($action == 'filter_applied') {
    // $khata_no = trim($_REQUEST['Name']) . '%';
    // $village_code = trim($_REQUEST['village_code']);
    // $gata_no = trim($_REQUEST['village_gata']) . '%';
    // $shreni = trim($_REQUEST['shreni']) . '%';
    // $board_approved = trim($_REQUEST['board_approved']);
    // $select_village_with_gata = decryptIt(myUrlEncode(trim($_REQUEST['select_village_with_gata'])));
    // $decrypt_data = $_POST['mahal_name'] ? trim($_POST['mahal_name']) : '';
    // $explode_data = explode('@', $decrypt_data);
    // $mahal_name = $explode_data[0];

    $name = trim($_REQUEST['Name']) > '%';
    $user_name = trim($_REQUEST['User_Name']) > '%';
    $email = trim($_REQUEST['Email']) > '%';
    $designation = trim($_REQUEST['Designation']) > '%';
    $address = trim($_REQUEST['Address']) > '%';
    $gender = trim($_REQUEST['Gender']) > '%';
    $mobile_no = trim($_REQUEST['Mobie_NO']) > '%';
}

$village_code_list = implode("','", $village_names_code_array);

$sql = "SELECT Name,User_Name,Email,Mobile_NO,Designation,Address,Gender FROM `user_info` WHERE 1";
if ($_REQUEST['Name']) {
    $sql .= " AND Name = ?";
}
if ($_REQUEST['User_Name']) {
    $sql .= " AND User_Name Like ?";
}
if ($_REQUEST['Email']) {
    $sql .= " AND Email = ?";
}
if ($_REQUEST['Mobile_NO']) {
    $sql .= " AND Mobile_NO Like ?";
}
if ($_REQUEST['Designation']) {
    $sql .= " AND Designation Like ?";
}
if ($_REQUEST['Address']) {
    $sql .= " AND Address = ?";
}
if ($_REQUEST['Gender']) {
    $sql .= " AND Gender = ?";
}

$sql .= " ORDER BY Name DESC";

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
if ($_REQUEST['village_code']) {
    $sql->bindParam($i++, $village_code);
}
if ($_REQUEST['village_gata']) {
    $sql->bindParam($i++, $gata_no);
}
if ($_REQUEST['shreni']) {
    $sql->bindParam($i++, $shreni);
}
if ($_REQUEST['board_approved']) {
    $sql->bindParam($i++, $board_approved);
}
if ($_REQUEST['mahal_name'] && $_REQUEST['select_village_with_gata']) {
    $sql->bindParam($i++, $mahal_name);
    $sql->bindParam($i++, $select_village_with_gata);
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
