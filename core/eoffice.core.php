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
$msg_id = $_REQUEST['msg_id'];
$srno = ($page - 1) * $limit;

// get post data if filter appplied
if ($action == 'filter_applied') {
    $department_name = trim($_REQUEST['department_name']) . '%';
    $file_no = trim($_REQUEST['file_no']) . '%';
    $name = trim($_REQUEST['name']) . '%';
    $subject = trim($_REQUEST['subject']);
    $folder_name = trim($_REQUEST['folder_name']) . '%';
    $file_creator = trim($_REQUEST['file_creator']) . '%';
}

$sql = "SELECT SQL_CALC_FOUND_ROWS T1.ID, T1.DepartmentName, T1.FileNo, T1.Name, T1.Subject, T1.FolderNameForNoteSheet, T1.FileCreator, T1.Active
                        FROM lm_eoffice T1
                        WHERE  T1.RowDeleted = ?
                        ";
if ($_REQUEST['department_name']) {
    $sql .= " AND T1.DepartmentName LIKE ?";
}
if ($_REQUEST['file_no']) {
    $sql .= " AND T1.FileNo LIKE ?";
}
if ($_REQUEST['name']) {
    $sql .= " AND T1.Name LIKE ?";
}
if ($_REQUEST['subject']) {
    $sql .= " AND MATCH(T1.Subject) AGAINST (?)";
}
if ($_REQUEST['folder_name']) {
    $sql .= " AND T1.FolderNameForNoteSheet LIKE ?";
}
if ($_REQUEST['file_creator']) {
    $sql .= " AND T1.FileCreator LIKE ?";
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
if ($_REQUEST['department_name']) {
    $sql->bindParam($i++, $department_name);
}
if ($_REQUEST['file_no']) {
    $sql->bindParam($i++, $file_no);
}
if ($_REQUEST['name']) {
    $sql->bindParam($i++, $name);
}
if ($_REQUEST['subject']) {
    $sql->bindParam($i++, $subject);
}
if ($_REQUEST['folder_name']) {
    $sql->bindParam($i++, $folder_name);
}
if ($_REQUEST['file_creator']) {
    $sql->bindParam($i++, $file_creator);
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