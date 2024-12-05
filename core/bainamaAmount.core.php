<?php

$column_arr = array();
$column_head = array();

$user_type = $_SESSION['UserType'];
$sort_by = $_REQUEST['sort_by'];
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
    $village_code = trim($_REQUEST['village_code']);
    $vilekh_sankhya = trim($_REQUEST['vilekh']) . '%';
    $rakba = trim($_REQUEST['rakba']) . '%';
    $bainama_sdate = trim(date('Y-m-d', strtotime($_REQUEST['sdate'])));
    $bainama_edate = trim(date('Y-m-d', strtotime($_REQUEST['edate'])));
    $status = trim($_REQUEST['pstatus']);
    $entry = trim($_REQUEST['entry']);
    $spsdate = trim(date('Y-m-d', strtotime($_REQUEST['spsdate'])));
    $spedate = trim(date('Y-m-d', strtotime($_REQUEST['spedate'])));
    $pmt_status = trim($_REQUEST['pmtstatus']);
    $unmatched_data = trim($_REQUEST['unmatched_data']);
}

/* * ****** query for amount calculation ******* */
$sql_amount = "SELECT T1.BainamaAmount, T1.PaymentAmount, T1.ParisampattiAmount, T1.BainamaArea
                        FROM lm_gata_ebasta T1
                        WHERE 1 = 1
                        ";
if ($_REQUEST['village_code']) {
    $sql_amount .= " AND T1.VillageCode = ?";
}
if ($_REQUEST['vilekh']) {
    $sql_amount .= " AND T1.VilekhSankhya LIKE ?";
}
if ($_REQUEST['rakba']) {
    $sql_amount .= " AND T1.AnshRakba LIKE ?";
}
if ($_REQUEST['date']) {
    $sql_amount .= " AND T1.AnshDate = ?";
}
if ($_REQUEST['pstatus']) {
    $sql_amount .= " AND T1.PatravaliStatus = ?";
}
if ($_REQUEST['sdate'] && $_REQUEST['edate']) {
    $sql_amount .= " AND FROM_UNIXTIME(T1.AnshDate, '%Y-%m-%d') BETWEEN ? AND ?";
}
if ($_REQUEST['spsdate'] && $_REQUEST['spedate']) {
    $sql_amount .= " AND FROM_UNIXTIME(T1.PaymentDate, '%Y-%m-%d') BETWEEN ? AND ?";
}
if ($_REQUEST['pmtstatus']) {
    if ($_REQUEST['pmtstatus'] == '1') {
        $sql_amount .= " AND T1.PaymentAmount > ?";
    } else {
        $sql_amount .= " AND T1.PaymentAmount = ?";
    }
}
if ($_REQUEST['unmatched_data']) {
    if ($_REQUEST['unmatched_data'] == '1') {
        $sql_amount .= " AND T1.BainamaAmount <> (T1.LandAmount + T1.ParisampattiAmount)";
    } else if ($_REQUEST['unmatched_data'] == '2') {
        $sql_amount .= " AND T1.PaymentAmount <> T1.BainamaAmount AND T1.PaymentAmount > ?";
    } else if ($_REQUEST['unmatched_data'] == '3') {
        $sql_amount .= " AND T1.AnshDate = ?";
    } else if ($_REQUEST['unmatched_data'] == '4') {
        $sql_amount .= " AND T1.PaymentAmount > ? AND T1.PaymentDate = ?";
    } else if ($_REQUEST['unmatched_data'] == '5') {
        $sql_amount .= " AND T1.VilekhSankhya = ?";
    } else if ($_REQUEST['unmatched_data'] == '6') {
        $sql_amount .= " AND T1.BainamaArea = ?";
    }
}
$sql_amount .= " AND MATCH(T1.Ebasta2) AGAINST (?)
                GROUP BY T1.VillageCode, T1.Ebasta2
                ";

$i = 1;
$sql_amount = $db->prepare($sql_amount);

// bind every placeholder
if ($_REQUEST['village_code']) {
    $sql_amount->bindParam($i++, $village_code);
}
if ($_REQUEST['vilekh']) {
    $sql_amount->bindParam($i++, $vilekh_sankhya);
}
if ($_REQUEST['rakba']) {
    $sql_amount->bindParam($i++, $rakba);
}
if ($_REQUEST['date']) {
    $sql_amount->bindParam($i++, $bainama_date);
}
if ($_REQUEST['pstatus']) {
    $sql_amount->bindParam($i++, $status);
}
if ($_REQUEST['sdate'] && $_REQUEST['edate']) {
    $sql_amount->bindParam($i++, $bainama_sdate);
    $sql_amount->bindParam($i++, $bainama_edate);
}
if ($_REQUEST['spsdate'] && $_REQUEST['spedate']) {
    $sql_amount->bindParam($i++, $spsdate);
    $sql_amount->bindParam($i++, $spedate);
}
if ($_REQUEST['pmtstatus']) {
    $sql_amount->bindValue($i++, 0);
}
if ($_REQUEST['unmatched_data']) {
    if ($_REQUEST['unmatched_data'] == '2') {
        $sql_amount->bindValue($i++, 0);
    } else if ($_REQUEST['unmatched_data'] == '3') {
        $sql_amount->bindValue($i++, 0);
    } else if ($_REQUEST['unmatched_data'] == '4') {
        $sql_amount->bindValue($i++, 0);
        $sql_amount->bindValue($i++, 0);
    } else if ($_REQUEST['unmatched_data'] == '5') {
        $sql_amount->bindValue($i++, '');
    } else if ($_REQUEST['unmatched_data'] == '6') {
        $sql_amount->bindValue($i++, 0);
    }
}
$sql_amount->bindValue($i++, 'file_name');
$sql_amount->execute();
$sql_amount->setFetchMode(PDO::FETCH_ASSOC);
$bainama_total_amount = 0;
$payment_total_amount = 0;
$total_bainama_area = 0;
$total_parisampatti_amount = 0;
while ($row = $sql_amount->fetch()) {
    $bainama_total_amount += $row['BainamaAmount'];
    $payment_total_amount += $row['PaymentAmount'];
    $total_bainama_area += $row['BainamaArea'];
    $total_parisampatti_amount += $row['ParisampattiAmount'];
}
$total_bainama_area = round($total_bainama_area, 2);
$total_parisampatti_amount = round($total_parisampatti_amount, 2);

/* * ****** query for vilekh without payment calculation ******* */
$sql_amount = "SELECT COUNT(T1.VilekhSankhya) AS CountVilekhSankhya
                        FROM lm_gata_ebasta T1
                        WHERE 1 = 1
                        AND T1.PaymentAmount = ?
                        ";
if ($_REQUEST['village_code']) {
    $sql_amount .= " AND T1.VillageCode = ?";
}
if ($_REQUEST['vilekh']) {
    $sql_amount .= " AND T1.VilekhSankhya LIKE ?";
}
if ($_REQUEST['rakba']) {
    $sql_amount .= " AND T1.AnshRakba LIKE ?";
}
if ($_REQUEST['date']) {
    $sql_amount .= " AND T1.AnshDate = ?";
}
if ($_REQUEST['pstatus']) {
    $sql_amount .= " AND T1.PatravaliStatus = ?";
}
if ($_REQUEST['sdate'] && $_REQUEST['edate']) {
    $sql_amount .= " AND FROM_UNIXTIME(T1.AnshDate, '%Y-%m-%d') BETWEEN ? AND ?";
}
if ($_REQUEST['spsdate'] && $_REQUEST['spedate']) {
    $sql_amount .= " AND FROM_UNIXTIME(T1.PaymentDate, '%Y-%m-%d') BETWEEN ? AND ?";
}
if ($_REQUEST['pmtstatus']) {
    if ($_REQUEST['pmtstatus'] == '1') {
        $sql_amount .= " AND T1.PaymentAmount > ?";
    } else {
        $sql_amount .= " AND T1.PaymentAmount = ?";
    }
}
$sql_amount .= " AND MATCH(T1.Ebasta2) AGAINST (?)
                GROUP BY T1.VillageCode, T1.Ebasta2
                HAVING CountVilekhSankhya > ?
                ";

$i = 1;
$sql_amount = $db->prepare($sql_amount);

// bind every placeholder
$sql_amount->bindValue($i++, 0);
// bind every placeholder
if ($_REQUEST['village_code']) {
    $sql_amount->bindParam($i++, $village_code);
}
if ($_REQUEST['vilekh']) {
    $sql_amount->bindParam($i++, $vilekh_sankhya);
}
if ($_REQUEST['rakba']) {
    $sql_amount->bindParam($i++, $rakba);
}
if ($_REQUEST['date']) {
    $sql_amount->bindParam($i++, $bainama_date);
}
if ($_REQUEST['pstatus']) {
    $sql_amount->bindParam($i++, $status);
}
if ($_REQUEST['sdate'] && $_REQUEST['edate']) {
    $sql_amount->bindParam($i++, $bainama_sdate);
    $sql_amount->bindParam($i++, $bainama_edate);
}
if ($_REQUEST['spsdate'] && $_REQUEST['spedate']) {
    $sql_amount->bindParam($i++, $spsdate);
    $sql_amount->bindParam($i++, $spedate);
}
if ($_REQUEST['pmtstatus']) {
    $sql_amount->bindValue($i++, 0);
}
$sql_amount->bindValue($i++, 'file_name');
$sql_amount->bindValue($i++, 0);
$sql_amount->execute();
$sql_amount->setFetchMode(PDO::FETCH_ASSOC);
$vilekh_without_payment = 0;
while ($row = $sql_amount->fetch()) {
    $vilekh_without_payment++;
}

/* * ****** query for listing ******* */
$db->query('SET SESSION group_concat_max_len = 1000000');
$sql = "SELECT SQL_CALC_FOUND_ROWS T1.ID, GROUP_CONCAT(T1.ID) AS EbastaIds, T3.VillageName, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.KashtkarAnsh, T1.AnshDate, T1.Ebasta2, T1.VilekhSankhya, T1.BainamaArea, ROUND(T1.BainamaArea, 4) AS RoundoffBainamaArea, T1.BainamaAmount, T1.LandAmount, T1.ParisampattiAmount, T1.PatravaliStatus, T1.PaymentAmount, T1.PaymentDate, COUNT(T1.VilekhSankhya) AS CountVilekhSankhya, ROUND(SUM(T1.AnshRakba), 4) AS AnshRakba
                        FROM lm_gata_ebasta T1
                        LEFT JOIN lm_gata T2 ON (T2.VillageCode = T1.VillageCode AND T2.GataNo = T1.GataNo AND T2.KhataNo = T1.KhataNo)
                        LEFT JOIN lm_village T3 ON T3.VillageCode = T1.VillageCode
                        WHERE 1 = 1
                        ";
if ($_REQUEST['village_code']) {
    $sql .= " AND T1.VillageCode = ?";
}
if ($_REQUEST['vilekh']) {
    $sql .= " AND T1.VilekhSankhya LIKE ?";
}
if ($_REQUEST['rakba']) {
    $sql .= " AND T1.AnshRakba LIKE ?";
}
if ($_REQUEST['date']) {
    $sql .= " AND T1.AnshDate = ?";
}
if ($_REQUEST['pstatus']) {
    $sql .= " AND T1.PatravaliStatus = ?";
}
if ($_REQUEST['sdate'] && $_REQUEST['edate']) {
    $sql .= " AND FROM_UNIXTIME(T1.AnshDate, '%Y-%m-%d') BETWEEN ? AND ?";
}
if ($_REQUEST['spsdate'] && $_REQUEST['spedate']) {
    $sql .= " AND FROM_UNIXTIME(T1.PaymentDate, '%Y-%m-%d') BETWEEN ? AND ?";
}
if ($_REQUEST['pmtstatus']) {
    if ($_REQUEST['pmtstatus'] == '1') {
        $sql .= " AND T1.PaymentAmount > ?";
    } else {
        $sql .= " AND T1.PaymentAmount = ?";
    }
}
if ($_REQUEST['unmatched_data']) {
    if ($_REQUEST['unmatched_data'] == '1') {
        $sql .= " AND T1.BainamaAmount <> (T1.LandAmount + T1.ParisampattiAmount)";
    } else if ($_REQUEST['unmatched_data'] == '2') {
        $sql .= " AND T1.PaymentAmount <> T1.BainamaAmount AND T1.PaymentAmount > ?";
    } else if ($_REQUEST['unmatched_data'] == '3') {
        $sql .= " AND T1.AnshDate = ?";
    } else if ($_REQUEST['unmatched_data'] == '4') {
        $sql .= " AND T1.PaymentAmount > ? AND T1.PaymentDate = ?";
    } else if ($_REQUEST['unmatched_data'] == '5') {
        $sql .= " AND T1.VilekhSankhya = ?";
    } else if ($_REQUEST['unmatched_data'] == '6') {
        $sql .= " AND T1.BainamaArea = ?";
    }
}
$sql .= " AND MATCH(T1.Ebasta2) AGAINST (?)
                AND (T2.Shreni = ? OR T2.Shreni = ?)
                GROUP BY T1.VillageCode, T1.Ebasta2
                ";

if ($_REQUEST['entry']) {
    if ($entry == '1') {
        $sql .= " HAVING CountVilekhSankhya > ?";
    } else if ($entry == '2') {
        $sql .= " HAVING CountVilekhSankhya = ?";
    }
    if ($_REQUEST['unmatched_data']) {
        if ($_REQUEST['unmatched_data'] == '7') {
            $sql .= " AND RoundoffBainamaArea <> AnshRakba";
        }
    }
} else {
    if ($_REQUEST['unmatched_data']) {
        if ($_REQUEST['unmatched_data'] == '7') {
            $sql .= " HAVING RoundoffBainamaArea <> AnshRakba";
        }
    }
}

if ($sort_by == '1') {
    $sql .= " ORDER BY T1.AnshDate ASC";
} else if ($sort_by == '2') {
    $sql .= " ORDER BY T1.AnshDate DESC";
} else if ($sort_by == '3') {
    $sql .= " ORDER BY T1.PaymentDate ASC";
} else if ($sort_by == '4') {
    $sql .= " ORDER BY T1.PaymentDate DESC";
} else if ($sort_by == '5') {
    $sql .= " ORDER BY CAST(T1.BainamaArea AS FLOAT) ASC";
} else if ($sort_by == '6') {
    $sql .= " ORDER BY CAST(T1.BainamaArea AS FLOAT) DESC";
} else if ($sort_by == '7') {
    $sql .= " ORDER BY CAST(T1.VilekhSankhya AS FLOAT) ASC";
} else if ($sort_by == '8') {
    $sql .= " ORDER BY CAST(T1.VilekhSankhya AS FLOAT) DESC";
} else if ($sort_by == '9') {
    $sql .= " ORDER BY CAST(T1.BainamaAmount AS FLOAT) ASC";
} else if ($sort_by == '10') {
    $sql .= " ORDER BY CAST(T1.BainamaAmount AS FLOAT) DESC";
} else if ($sort_by == '11') {
    $sql .= " ORDER BY CAST(T1.PaymentAmount AS FLOAT) ASC";
} else if ($sort_by == '12') {
    $sql .= " ORDER BY CAST(T1.PaymentAmount AS FLOAT) DESC";
} else {
    $sql .= " ORDER BY T1.AnshDate ASC";
}

if ($exportlist != 'export') {
    $sql .= " LIMIT " . $start . ", " . $limit . "";
}
//echo $sql;
$i = 1;
$sql = $db->prepare($sql);

// bind every placeholder
if ($_REQUEST['village_code']) {
    $sql->bindParam($i++, $village_code);
}
if ($_REQUEST['vilekh']) {
    $sql->bindParam($i++, $vilekh_sankhya);
}
if ($_REQUEST['rakba']) {
    $sql->bindParam($i++, $rakba);
}
if ($_REQUEST['date']) {
    $sql->bindParam($i++, $bainama_date);
}
if ($_REQUEST['pstatus']) {
    $sql->bindParam($i++, $status);
}
if ($_REQUEST['sdate'] && $_REQUEST['edate']) {
    $sql->bindParam($i++, $bainama_sdate);
    $sql->bindParam($i++, $bainama_edate);
}
if ($_REQUEST['spsdate'] && $_REQUEST['spedate']) {
    $sql->bindParam($i++, $spsdate);
    $sql->bindParam($i++, $spedate);
}
if ($_REQUEST['pmtstatus']) {
    $sql->bindValue($i++, 0);
}
if ($_REQUEST['unmatched_data']) {
    if ($_REQUEST['unmatched_data'] == '2') {
        $sql->bindValue($i++, 0);
    } else if ($_REQUEST['unmatched_data'] == '3') {
        $sql->bindValue($i++, 0);
    } else if ($_REQUEST['unmatched_data'] == '4') {
        $sql->bindValue($i++, 0);
        $sql->bindValue($i++, 0);
    } else if ($_REQUEST['unmatched_data'] == '5') {
        $sql->bindValue($i++, '');
    } else if ($_REQUEST['unmatched_data'] == '6') {
        $sql->bindValue($i++, 0);
    }
}
$sql->bindValue($i++, 'file_name');
$sql->bindValue($i++, '1-क');
$sql->bindValue($i++, '2');
if ($_REQUEST['entry'] && $entry == '1') {
    $sql->bindValue($i++, 0);
}
if ($_REQUEST['entry'] && $entry == '2') {
    $sql->bindValue($i++, 0);
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