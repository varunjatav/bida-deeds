<?php

$column_arr = array();
$column_head = array();

$user_id = $_SESSION['UserID'];
$user_type = $_SESSION['UserType'];
$action = $_REQUEST['action'];
// $village_id = $_REQUEST['village_id'];
$exportlist = $_REQUEST['exportlist'];
$column_arr = explode(',', $_REQUEST['column_arr']);
$column_head = explode(',', $_REQUEST['column_head']);
$limit = $_POST['pagelimit'] == '' ? 10 : $_POST['pagelimit']; 
$srno_list = $_POST['srno'];
$offset = $_POST['offset'] == '' ? 0 : $_POST['offset'];
$start = (int) $limit * (int) $offset;
$page = (int) $offset + 1;
$id = decryptIt($_REQUEST['id']);
$srno = ($page - 1) * $limit;


if ($action == 'filter_applied') {
    $name = trim($_REQUEST['name']) . '%';
    $mobile = trim($_REQUEST['mobile']) . '%';
    $gender = trim($_REQUEST['gender']);
    $dob = trim($_REQUEST['dob']) . '%';
    $email = trim($_REQUEST['email']) . '%';
    $pan = trim($_REQUEST['pan']) . '%';
    $adhaar = trim($_REQUEST['adhaar']) . '%';
    $address = trim($_REQUEST['address']) . '%';
    $pincode = trim($_REQUEST['pincode']) . '%';
    $document = trim($_REQUEST['document']) . '%';
    $profile = trim($_REQUEST['profile']) . '%';
    $branch = trim($_REQUEST['branch']) . '%';
}


$sql = "SELECT SQL_CALC_FOUND_ROWS 
        lm_user_data.ID, 
        lm_user_data.Name, 
        lm_user_data.Mobile, 
        lm_user_data.Gender, 
        lm_user_data.DOB, 
        lm_user_data.Email, 
        lm_user_data.Pan, 
        lm_user_data.Adhaar, 
        lm_user_data.Address, 
        lm_user_data.City, 
        lm_user_data.PinCode, 
        lm_user_data.Branch,
        lm_user_documents.document,
        lm_user_documents.profile
    FROM 
        lm_user_data
    LEFT JOIN 
        lm_user_documents 
    ON 
        lm_user_data.ID = lm_user_documents.user_id
    WHERE 
        1 = 1
";

if ($_REQUEST["id"]) {
    $sql .= " AND lm_user_data.ID LIKE ?";
}
if ($_REQUEST['name']) {
    $sql .= " AND lm_user_data.Name Like ?";
}
if ($_REQUEST['mobile']) {
    $sql .= " AND lm_user_data.Mobile Like ?";
}
if ($_REQUEST['gender']) {
    $sql .= " AND lm_user_data.Gender = ?";
}
if ($_REQUEST['dob']) {
    $sql .= " AND lm_user_data.DOB Like ?";
}
if ($_REQUEST['email']) {
    $sql .= " AND lm_user_data.Email Like ?";
}
if ($_REQUEST['pan']) {
    $sql .= " AND lm_user_data.Pan Like ?";
}
if ($_REQUEST['address']) {
    $sql .= " AND lm_user_data.Address Like ?";
}
if ($_REQUEST['adhaar']) {
    $sql .= " AND lm_user_data.Adhaar Like ?";
}
if ($_REQUEST['city']) {
    $sql .= " AND lm_user_data.City Like ?";
}
if ($_REQUEST['pincode']) {
    $sql .= " AND lm_user_data.PinCode Like ?";
}
if ($_REQUEST['document']) {
    $sql .= " AND lm_user_documents.document Like ?";
}
if ($_REQUEST['profile']) {
    $sql .= " AND lm_user_documents.profile Like ?";
}
if ($_REQUEST['branch']) {
    $sql .= " AND lm_user_data.Branch Like ?";
}

$sql .= " ORDER BY lm_user_data.Name DESC";

if ($exportlist != 'export') {
    $sql .= " LIMIT " . $start . ", " . $limit;
}

$i = 1;
$sql = $db->prepare($sql);
if ($_REQUEST['id']) {
    $sql ->bindParam($i++, $id);
}
if ($_REQUEST['name']) {
    $sql ->bindParam($i++, $name);
}
if ($_REQUEST['mobile']) {
    $sql ->bindParam($i++, $mobile);
}
if ($_REQUEST['gender']) {
    $sql ->bindParam($i++, $gender);
}
if ($_REQUEST['dob']) {
    $sql ->bindParam($i++, $dob);
}
if ($_REQUEST['email']) {
    $sql ->bindParam($i++, $email);
}
if ($_REQUEST['pan']) {
    $sql ->bindParam($i++, $pan);
}
if ($_REQUEST['adhaar']) {
    $sql ->bindParam($i++, $adhaar);
}
if ($_REQUEST['address']) {
    $sql ->bindParam($i++, $address);
}
if ($_REQUEST['pincode']) {
    $sql ->bindParam($i++, $pincode);
}
if ($_REQUEST['document']) {
    $sql ->bindParam($i++, $document);
}
if ($_REQUEST['profile']) {
    $sql ->bindParam($i++, $profile);
}
if ($_REQUEST['branch']) {
    $sql ->bindParam($i++, $branch);
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
                $output = $output . '<a id=1  style="cursor:pointer;" class="paginate">1</a>';
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


