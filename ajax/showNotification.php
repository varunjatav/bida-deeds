<?php

include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';

$user_id = $_SESSION['UserID'];
$date = date('Y-m-d', time());

$alert_query = $db->prepare("SELECT SQL_CALC_FOUND_ROWS T1.ID, T1.*
                            FROM lm_web_queue T1
                            WHERE T1.ReceiverID = ?
                            AND T1.Readed = ?
                            AND T1.RowDeleted = ?
                            ORDER BY T1.ID DESC
                            LIMIT 200
                            ");

$alert_query->bindParam(1, $user_id);
$alert_query->bindValue(2, 0);
$alert_query->bindValue(3, 0);
$alert_query->execute();
$alert_query->setFetchMode(PDO::FETCH_ASSOC);
$alert_count = $alert_query->rowCount();

$rs1 = $db->query('SELECT FOUND_ROWS()');
$total_alert_count = (int) $rs1->fetchColumn();

$str = '';
$str .= '<div class="ntf-title left">' . $alert_count . ' of ' . $total_alert_count . ' unread notifications</div>';
$str .= '<div class="ntf-clr right"><a style="cursor: pointer;" class="clear_all_notify">Clear all</a></div>';
$str .= '<div class="clr"></div>';
$str .= '<div class="ntf-list">';

if ($alert_count > 0) {
    while ($row = $alert_query->fetch()) {
        if ($row['Message'] == '1') {
            $msg_data = 'New feedback from DM for DASHBOARD.';
        } else if ($row['Message'] == '2') {
            $msg_data = 'New feedback from DM for SYNC data.';
        } else if ($row['Message'] == '3') {
            $msg_data = 'New feedback from DM for E-BASTA.';
        } else if ($row['Message'] == '4') {
            $msg_data = 'New feedback from DM for REPORTS.';
        } else if ($row['Message'] == '5') {
            $msg_data = 'New feedback from DM for MIS DASHBOARD.';
        } else if ($row['Message'] == '6') {
            $msg_data = 'New feedback from DM for MIS REPORTS.';
        } else {
            $msg_data = $row['Message'];
        }
        $msg_id = $row['ID'];
        $link_page = $row['LinkPage'];
        $basename = array_shift(explode('?', $link_page));
        $url_components = parse_url($link_page);
        parse_str($url_components['query'], $params);
        $newlink_page = array();
        foreach ($params as $pKey => $pVal) {
            $newlink_page[] = $pKey . '=' . encryptIt($pVal);
        }
        $link_page = $basename . '?' . implode('&', $newlink_page);
        $create_time = date('d M Y, g:i A', $row['CreateTime']);

        $str .= '<div class="ntf-wrap untap box-sizing">';
        $str .= '<div class="left ntf-txt">' . $msg_data . '<br><span>' . $create_time . '</span></div>';
        $str .= '<div class="right ntf-close"><a style="cursor: pointer;" class="rmbtmpop" id="' . $msg_id . '" name="0" title="Remove"><img src="img/clear.svg" alt="" width="8px"></a></div>';
        $str .= '<div class="right ntf-close rmarg"><a style="cursor: pointer;" class="view_notify" id="' . $msg_id . '" name="' . $link_page . '" title="View"><img src="img/eye.svg" alt="" width="13px" style="margin-top: 4px;"></a></div>';
        $str .= '<div class="clr"></div>';
        $str .= '</div>';
    }
    $str .= '<div class="ntf-all">That\'s all the alerts we had for you!</div>';
    $str .= '</div>';
    echo $str;
} else {
    $str = '<div class="ntf-blnk">No pending notifications</div>';
    echo $str;
}