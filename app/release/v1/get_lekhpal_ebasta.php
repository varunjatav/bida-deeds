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

    if ($user_id && $user_type) {

        if ($user_id && $user_type == '7') {

            $query = "SELECT SQL_CALC_FOUND_ROWS T1.VillageCode, T1.GataNo, T1.KhataNo, T1.OwnerNo, T1.owner_name, T1.owner_father, T1.Type, T1.Subtype, T1.Options, T1.Ansh, T1.Rakba, T1.AnshDate, T1.Attachment, T1.Remarks, T1.DateCreated, T2.VillageName
                                    FROM lm_lekhpal_ebasta T1
                                     LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                    LEFT JOIN lm_user_village_gata_mapping T3 ON (T3.VillageCode = T1.VillageCode AND T3.GataNo = T1.GataNo)
                                    WHERE T3.UserID = ?
                                    ORDER BY T1.ID DESC
                                    ";
            $query .= " LIMIT " . $start . ", " . $limit . "";
            $sql = $db->prepare($query);
            $sql->bindParam(1, $user_id);
            $sql->execute();
            $rowcount = $sql->rowCount();
        } else if ($user_id && $user_type == '9') {
            $query = "SELECT SQL_CALC_FOUND_ROWS T1.VillageCode, T1.GataNo, T1.KhataNo, T1.OwnerNo, T1.owner_name, T1.owner_father, T1.Type, T1.Subtype, T1.Options, T1.Ansh, T1.Rakba, T1.AnshDate, T1.Attachment, T1.Remarks, T1.DateCreated, T2.VillageName
                                    FROM lm_lekhpal_ebasta T1
                                    LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                    WHERE 1 = 1
                                    ORDER BY T1.ID DESC
                                    ";
            $query .= " LIMIT " . $start . ", " . $limit . "";
            $sql = $db->prepare($query);
            $sql->execute();
            $rowcount = $sql->rowCount();
        }

        if ($rowcount == 0) {
            $data = array('status' => false, 'message' => 'Data Not Found.');
        } else {
            $rs1 = $db->query('SELECT FOUND_ROWS()');
            $total_count = (int) $rs1->fetchColumn();
            $total_pages = ceil($total_count / $limit);
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            while ($row = $sql->fetch()) {
                $type = '';
                if ($row['Type'] == '1') {
                    $type = 'Sahmati';
                } else if ($row['Type'] == '2') {
                    $type = 'Bainama';
                } else if ($row['Type'] == '3') {
                    $type = 'Dhanrashi';
                } else if ($row['Type'] == '4') {
                    $type = 'kabza';
                }

                $sub_type = '';
                if ($row['Subtype'] == '1') {
                    $sub_type = 'Parisampatti';
                } else if ($row['Subtype'] == '2') {
                    $sub_type = 'Dakhalnama';
                }

                $options = '';
                if ($row['Options'] == '1') {
                    $options = 'हाँ';
                } else if ($row['Options'] == '2') {
                    $options = 'नहीं';
                }

                if ($row['Attachment']) {
                    $attachment = $main_path . '/' . $media_lekhpal_ebasta_path . '/' . $row['Attachment'];
                } else {
                    $attachment = '';
                }
                $anshDate = $row['AnshDate'] ? date('d-m-Y', $row['AnshDate']) : '';

                $lekhpal_ebasta[] = array("villageName" => $row['VillageName'], "gataNo" => $row['GataNo'], "khataNo" => $row['KhataNo'], "ownerNo" => $row['OwnerNo'], "ownerName" => $row['owner_name'], "ownerFather" => $row['owner_father'], "type" => $type, "subType" => $sub_type, "options" => $options, "ansh" => $row['Ansh'], "rakba" => $row['Rakba'], "anshDate" => $anshDate, "attachment" => $attachment, "remarks" => $row['Remarks'], 'dateSubmitted' => date('d-m-Y', $row['DateCreated']));
            }

            //Creating JSON
            $data = array('status' => true, 'message' => 'Lekhpal Ebasta', 'total_pages' => $total_pages, "lekhpalEbasta" => $lekhpal_ebasta);
        }
    } else {
        //Creating JSON
        $data = array('status' => false, 'message' => 'Oops.. something went wrong.');
    }
    $data = removeEmptyValues($data);
    print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
}