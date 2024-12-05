<?php

error_reporting(0);
$script_file_name = basename($_SERVER['SCRIPT_FILENAME']);
include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.php';
include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/vendor/autoload.php';
include_once dirname(dirname(dirname(__FILE__))) . '/apiAccess.php';
$api_validate = 1; //apiValidate($_REQUEST, $script_file_name);

if ($api_validate == 1) {
    include_once dirname(dirname(dirname(__FILE__))) . '/get_time_zone.php';
    include_once dirname(dirname(dirname(__FILE__))) . '/common_functions.php';
    include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/dbcon/db_connect.php';

    $user_id = $_REQUEST['userid'];
    $user_type = $_REQUEST['user_type'];
    $limit = $_REQUEST['pagelimit'] == '' ? 100 : $_REQUEST['pagelimit'];
    $page = $_REQUEST['page'] == '' ? 0 : $_REQUEST['page'];
    $start = (int) $limit * (int) $page;

    if ($user_id && $user_type == '1') {

            $query = "SELECT SQL_CALC_FOUND_ROWS T1.*, T2.VillageName
                                    FROM lm_kashtkar_sahmati T1
                                    LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                    LEFT JOIN lm_user_village_mapping T3 ON T3.VillageCode = T1.VillageCode
                                    WHERE T3.UserID = ?
                                    ORDER BY T1.OwnerName ASC
                                    ";
        $query .= " LIMIT " . $start . ", " . $limit . "";
        $sql = $db->prepare($query);
        $sql->bindParam(1, $user_id);
        $sql->execute();
        $rowcount = $sql->rowCount();

        if ($rowcount == 0) {
            $data = array('status' => false, 'message' => 'Data Not Found.');
        } else {
            $rs1 = $db->query('SELECT FOUND_ROWS()');
            $total_count = (int) $rs1->fetchColumn();
            $total_pages = ceil($total_count / $limit);
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            while ($row = $sql->fetch()) {
               if ($row['Attachment']){
                    $attachment = $main_path . '/' . $media_kashtkar_sahmati_path . '/' . $row['Attachment'];
                } else {
                    $attachment = 'NA';
                }
                $kashtkar_sahmati[] = array("villageName" => $row['VillageName'], "villageCode" => $row['VillageCode'], "gataNo" => $row['GataNo'], "khataNo" => $row['KhataNo'], "mobile" => $row['Mobile'],  "ownerName" => $row['OwnerName'], "ownerFather" => $row['OwnerFather'], "ansh" => $row['Ansh'], "area" => $row['Area'], "attachment" => $attachment, "dateSubmitted" => date('d-m-Y', $row['DateCreated']));
            }

            //Creating JSON
            $data = array('status' => true, 'message' => 'Kashtkar Sahmati', 'total_pages' => $total_pages, "kashtkarsahmatiInfo" => $kashtkar_sahmati);
        }
    } else {
        //Creating JSON
        $data = array('status' => false, 'message' => 'Oops.. something went wrong.');
    }
    $data = removeEmptyValues($data);
    print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
}