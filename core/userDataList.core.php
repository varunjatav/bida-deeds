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

    $name = trim($_REQUEST['name']) . '%';
    $user_name = trim($_REQUEST['user_name']) . '%';
    $email = trim($_REQUEST['email']) . '%';
    $designation = trim($_REQUEST['designation']) . '%';
    $address = trim($_REQUEST['address']) . '%';
    $gender = trim($_REQUEST['gender']);
    $mobile_no = trim($_REQUEST['mobile_no']) . '%';
}


$sql = "SELECT Name, User_Name, Email, Mobile_NO, Designation, Address, Gender FROM user_info WHERE 1 = 1";
if ($_REQUEST['name']) {
    $sql .= " AND Name Like ?";
}
if ($_REQUEST['user_name']) {
    $sql .= " AND User_Name Like ?";
}
if ($_REQUEST['email']) {
    $sql .= " AND Email Like ?";
}
if ($_REQUEST['mobile_no']) {
    $sql .= " AND Mobile_NO Like ?";
}
if ($_REQUEST['designation']) {
    $sql .= " AND Designation Like ?";
}
if ($_REQUEST['address']) {
    $sql .= " AND Address Like ?";
}
if ($_REQUEST['gender']) {
    $sql .= " AND Gender = ?";
}

$sql .= " ORDER BY Name DESC";

if ($exportlist != 'export') {
    $sql .= " LIMIT " . $start . ", " . $limit;
}
$i = 1;
$sql = $db->prepare($sql);
if ($_REQUEST['ID']) {
    $sql ->bindParam($i++,$msg_id);
}
if ($_REQUEST['name']) {
    $sql ->bindParam($i++,$name);
}
if ($_REQUEST['user_name']) {
    $sql ->bindParam($i++,$user_name);
}
if ($_REQUEST['email']) {
    $sql ->bindParam($i++,$email);
}
if ($_REQUEST['mobile_no']) {
    $sql ->bindParam($i++,$mobile_no);
}
if ($_REQUEST['designation']) {
    $sql ->bindParam($i++,$designation);
}
if ($_REQUEST['address']) {
    $sql ->bindParam($i++,$address);
}
if ($_REQUEST['gender']) {
    $sql ->bindParam($i++,$gender);
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
