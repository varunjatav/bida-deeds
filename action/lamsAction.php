<?php

ini_set('memory_limit', '-1');
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once "../functions/insert_queue.function.php";
include_once "../functions/notification.function.php";
include_once "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;

$user_id = $_SESSION['UserID'];

if (isset($_POST['action']) && $_POST['action'] == 'sync_village_data') {

    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $timestamp = time();
        $village_array = array();

        // get village data
        $url = "https://upbhulekh.gov.in/WS_BIDA/service?type=json&api_key=apikey&get=village";
        $data = array();
        $postdata = json_encode($data);
        $curl = curl_init();
        // Send HTTP request
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postdata,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'X-Requested-With: application/json'
            ),
        ));
        $response = curl_exec($curl);
        if ($response === false) {
            echo "Error in cURL : " . curl_error($curl);
        }
        curl_close($curl);

        $village_array = json_decode($response, TRUE);
        $village_codes = array();
        foreach ($village_array['DATA']['village'] as $key => $value) {
            $village_codes[] = $value['village_code'];
            try {
                $insrt = $db->prepare("INSERT INTO lm_village (VillageName, VillageNameHi, VillageCode, DateCreated, Active) VALUES (?, ?, ?, ?, ?)");
                $insrt->bindParam(1, $value['village_name_en']);
                $insrt->bindParam(2, $value['village_name_hi']);
                $insrt->bindParam(3, $value['village_code']);
                $insrt->bindParam(4, $timestamp);
                $insrt->bindValue(5, 1);
                $insrt->execute();
            } catch (PDOException $ex) {
                if ($ex->getCode() == 23000) {
                    $updt = $db->prepare("UPDATE lm_village SET VillageName = ?, VillageNameHi = ?, DateEdited = ? WHERE VillageCode = ? ");
                    $updt->bindParam(1, $value['village_name_en']);
                    $updt->bindParam(2, $value['village_name_hi']);
                    $updt->bindParam(3, $timestamp);
                    $updt->bindParam(4, $value['village_code']);
                    $updt->execute();
                }
            }
        }

        // Make the changes to the database permanent
        $db_respose_data = array(
            'village_data' => implode(',', $village_codes)
        );

        // Make the changes to the database permanent
        commit($db, '', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'sync_village_detail_data') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $timestamp = time();
        $village_codes = validateInteger($_POST['village_code']);
        $count = $_POST['count'] ? validateInteger($_POST['count']) : 0;
        $village_gata_array = array();
        $village_code = array();
        $plot_number = array();
        $khata_number = array();
        $plot_area = array();
        $owner_number = array();
        $land_type = array();
        $plot_owner = array();
        $plot_no_with_max_owner_array = array();
        $gata_uid = array();
        $time_start = microtime(true);

        // get village gat data
        $url = "https://upbhulekh.gov.in/WS_BIDA/service?type=json&api_key=apikey&get=detail&village=" . $village_codes;
        $data = array();
        $postdata = json_encode($data);
        $curl = curl_init();
        // Send HTTP request
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postdata,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'X-Requested-With: application/json'
            ),
        ));
        $response = curl_exec($curl);
        if ($response === false) {
            echo "Error in cURL : " . curl_error($curl);
        }
        curl_close($curl);

        $village_gata_array = json_decode($response, TRUE);

        // delete old entries of village
        $delt = $db->prepare("DELETE FROM lm_api_data WHERE VillageCode = ?");
        $delt->bindParam(1, $village_codes);
        $delt->execute();

        $delt = $db->prepare("DELETE FROM lm_api_gata_kashtkar WHERE VillageCode = ?");
        $delt->bindParam(1, $village_codes);
        $delt->execute();

        if (count_($village_gata_array['DATA']['village_detail'])) {

            $byPlotKhataAreaArray = array();
            foreach ($village_gata_array['DATA']['village_detail'] as $item) {
                if (array_key_exists('khata_number', $item) && array_key_exists('plot_number', $item) && array_key_exists('plot_area', $item)) {
                    $byPlotKhataAreaArray[$item['khata_number']][$item['plot_number']][$item['plot_area']][] = array('village_code' => $item['village_code'],
                        'plot_number' => $item['plot_number'],
                        'khata_number' => $item['khata_number'],
                        'plot_area' => $item['plot_area'],
                        'owner_number' => $item['owner_number'],
                        'land_type' => $item['land_type']);
                }
            }
            //print_r($byPlotKhataAreaArray);

            if (count_($byPlotKhataAreaArray)) {
                foreach ($byPlotKhataAreaArray as $bkey => $bvalue) {
                    if (count_($bvalue) && $bkey) {
                        foreach ($bvalue as $b1key => $b1value) {
                            if (count_($b1value) && $b1key) {
                                foreach ($b1value as $b2key => $b2value) {
                                    $maxs = max(array_column($b2value, 'owner_number'));
                                    $ovillage_code = $b2value[0]['village_code'];
                                    $oplot_number = $b2value[0]['plot_number'];
                                    $okhata_number = $b2value[0]['khata_number'];
                                    $oplot_area = $b2value[0]['plot_area'];
                                    $oland_type = $b2value[0]['land_type'];

                                    if ($ovillage_code && $maxs) {
                                        $plot_no_with_max_owner_array[] = array(
                                            'village_code' => $ovillage_code,
                                            'plot_number' => $oplot_number,
                                            'khata_number' => $okhata_number,
                                            'plot_area' => $oplot_area,
                                            'owner_number' => $maxs,
                                            'land_type' => $oland_type
                                        );
                                    }
                                }
                            }
                        }
                    }
                }
            }
            //print_r($plot_no_with_max_owner_array);

            if (count_($plot_no_with_max_owner_array)) {
                foreach ($plot_no_with_max_owner_array as $pwkey => $pwvalue) {
                    $uid[] = ++$count;
                    $village_code[] = $pwvalue['village_code'];
                    $plot_number[] = $pwvalue['plot_number'];
                    $khata_number[] = $pwvalue['khata_number'];
                    $plot_area[] = $pwvalue['plot_area'];
                    $owner_number[] = $pwvalue['owner_number'];
                    $land_type[] = $pwvalue['land_type'];
                }
            }
            //echo count_($plot_no_with_max_owner_array);
            //print_r($plot_no_with_max_owner_array);
            //echo $count;
            if (count_($uid)) {
                $batch_size = 2000;
                $chunks1 = array_chunk($uid, $batch_size);
                $chunks2 = array_chunk($village_code, $batch_size);
                $chunks3 = array_chunk($plot_number, $batch_size);
                $chunks4 = array_chunk($khata_number, $batch_size);
                $chunks5 = array_chunk($plot_area, $batch_size);
                $chunks6 = array_chunk($owner_number, $batch_size);
                $chunks7 = array_chunk($land_type, $batch_size);
                $loop_size = ceil(count_($village_code) / $batch_size);

                for ($i = 0; $i < $loop_size; $i++) {
                    $query = "INSERT INTO lm_api_data (UID, VillageCode, GataNo, KhataNo, Area, OwnerNo, Shreni, SyncedOn) VALUES "; //Prequery
                    $qPart = array_fill(0, count_($chunks1[$i]), "(?, ?, ?, ?, ?, ?, ?, ?)");
                    $query .= implode(",", $qPart);

                    $stmt2 = $db->prepare($query);
                    $k = 1;
                    foreach ($chunks1[$i] as $itemKey => $item) { //bind the values one by one
                        $stmt2->bindValue($k++, __fi($chunks1[$i][$itemKey]));
                        $stmt2->bindValue($k++, __fi($chunks2[$i][$itemKey]));
                        $stmt2->bindValue($k++, __fi($chunks3[$i][$itemKey]));
                        $stmt2->bindValue($k++, __fi($chunks4[$i][$itemKey]));
                        $stmt2->bindValue($k++, __fi($chunks5[$i][$itemKey]));
                        $stmt2->bindValue($k++, __fi($chunks6[$i][$itemKey]));
                        $stmt2->bindValue($k++, __fi($chunks7[$i][$itemKey]));
                        $stmt2->bindValue($k++, $timestamp);
                        $gata_uid[$chunks3[$i][$itemKey]] = $chunks1[$i][$itemKey];
                    }
                    $stmt2->execute();
                }

                // add owner/kashtakar details of every gata
                $ksht_uid = array();
                $ksht_village_code = array();
                $ksht_plot_number = array();
                $ksht_khata_number = array();
                $ksht_owner_number = array();
                $ksht_owner_name = array();
                $ksht_owner_father = array();
                $ksht_plot_area = array();

                foreach ($village_gata_array['DATA']['village_detail'] as $vitem) {
                    if (array_key_exists('village_code', $vitem) && $vitem['village_code']) {
                        $ksht_uid[] = $gata_uid[$vitem['plot_number']];
                        $ksht_village_code[] = $vitem['village_code'];
                        $ksht_plot_number[] = $vitem['plot_number'];
                        $ksht_khata_number[] = $vitem['khata_number'];
                        $ksht_owner_number[] = $vitem['owner_number'];
                        $ksht_owner_name[] = $vitem['owner_name'];
                        $ksht_owner_father[] = $vitem['owner_father'];
                        $ksht_plot_area[] = $vitem['plot_area'];
                    }
                }

                if (count_($ksht_uid)) {
                    $ksht_batch_size = 2000;
                    $ksht_chunks1 = array_chunk($ksht_uid, $ksht_batch_size);
                    $ksht_chunks2 = array_chunk($ksht_village_code, $ksht_batch_size);
                    $ksht_chunks3 = array_chunk($ksht_plot_number, $ksht_batch_size);
                    $ksht_chunks4 = array_chunk($ksht_khata_number, $ksht_batch_size);
                    $ksht_chunks5 = array_chunk($ksht_owner_number, $ksht_batch_size);
                    $ksht_chunks6 = array_chunk($ksht_owner_name, $ksht_batch_size);
                    $ksht_chunks7 = array_chunk($ksht_owner_father, $ksht_batch_size);
                    $ksht_chunks8 = array_chunk($ksht_plot_area, $ksht_batch_size);
                    $ksht_loop_size = ceil(count_($ksht_village_code) / $ksht_batch_size);

                    for ($i = 0; $i < $ksht_loop_size; $i++) {
                        $ksht_query = "INSERT INTO lm_api_gata_kashtkar (UID, VillageCode, GataNo, KhataNo, OwnerNo, owner_name, owner_father, Area) VALUES "; //Prequery
                        $ksht_qPart = array_fill(0, count_($ksht_chunks1[$i]), "(?, ?, ?, ?, ?, ?, ?, ?)");
                        $ksht_query .= implode(",", $ksht_qPart);

                        $stmt2 = $db->prepare($ksht_query);
                        $k = 1;
                        foreach ($ksht_chunks1[$i] as $ksht_itemKey => $ksht_item) { //bind the values one by one
                            $stmt2->bindValue($k++, __fi($ksht_chunks1[$i][$ksht_itemKey]));
                            $stmt2->bindValue($k++, __fi($ksht_chunks2[$i][$ksht_itemKey]));
                            $stmt2->bindValue($k++, __fi($ksht_chunks3[$i][$ksht_itemKey]));
                            $stmt2->bindValue($k++, __fi($ksht_chunks4[$i][$ksht_itemKey]));
                            $stmt2->bindValue($k++, __fi($ksht_chunks5[$i][$ksht_itemKey]));
                            $stmt2->bindValue($k++, __fi($ksht_chunks6[$i][$ksht_itemKey]));
                            $stmt2->bindValue($k++, __fi($ksht_chunks7[$i][$ksht_itemKey]));
                            $stmt2->bindValue($k++, __fi($ksht_chunks8[$i][$ksht_itemKey]));
                        }
                        $stmt2->execute();
                    }
                }
            }

            // insert in gata table
            $village_code = array();
            $plot_number = array();
            $khata_number = array();
            $plot_area = array();
            $owner_number = array();
            $land_type = array();
            $uid = array();
            $new_gata_uid = array();
            $new_count = $count;
            $qPart = array();

            $intersect_query = $db->prepare("SELECT T1.UID, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.Area, T1.OwnerNo, T1.Shreni
                                        FROM lm_api_data T1
                                        WHERE T1.VillageCode = ?
                                        AND (T1.VillageCode, T1.GataNo, T1.KhataNo, T1.Area) NOT IN (
                                                            SELECT T2.VillageCode, T2.GataNo, T2.KhataNo, T2.Area
                                                            FROM lm_gata T2
                                                            WHERE T2.VillageCode = ?
                                                        )
                                        ");
            $intersect_query->bindParam(1, $village_codes);
            $intersect_query->bindParam(2, $village_codes);
            $intersect_query->execute();
            $intersect_query->setFetchMode(PDO::FETCH_ASSOC);

            while ($row = $intersect_query->fetch()) {
                //print_r($row);
                $uid[] = $new_count++;
                $village_code[] = $row['VillageCode'];
                $plot_number[] = $row['GataNo'];
                $khata_number[] = $row['KhataNo'];
                $plot_area[] = $row['Area'];
                $owner_number[] = $row['OwnerNo'];
                $land_type[] = $row['Shreni'];
            }
            //print_r($uid);
            //print_r($village_code);
            if (count_($uid)) {
                $batch_size = 2000;
                $chunks1 = array_chunk($uid, $batch_size);
                $chunks2 = array_chunk($village_code, $batch_size);
                $chunks3 = array_chunk($plot_number, $batch_size);
                $chunks4 = array_chunk($khata_number, $batch_size);
                $chunks5 = array_chunk($plot_area, $batch_size);
                $chunks6 = array_chunk($owner_number, $batch_size);
                $chunks7 = array_chunk($land_type, $batch_size);
                $loop_size = ceil(count_($village_code) / $batch_size);
                //print_r($chunks3);
                for ($i = 0; $i < $loop_size; $i++) {
                    $query = "INSERT INTO lm_gata (UID, VillageCode, GataNo, KhataNo, Area, OwnerNo, Shreni, SyncedOn) VALUES "; //Prequery
                    $qPart = array_fill(0, count_($chunks1[$i]), "(?, ?, ?, ?, ?, ?, ?, ?)");
                    $query .= implode(",", $qPart);

                    $stmt2 = $db->prepare($query);
                    $k = 1;
                    foreach ($chunks1[$i] as $itemKey => $item) { //bind the values one by one
                        //echo $chunks1[$i][$itemKey],', '.$chunks2[$i][$itemKey],', '.$chunks3[$i][$itemKey],', '.$chunks4[$i][$itemKey],', '.$chunks5[$i][$itemKey],', '.$chunks6[$i][$itemKey],', '.$chunks7[$i][$itemKey]."\r\n";
                        $stmt2->bindValue($k++, __fi($chunks1[$i][$itemKey]));
                        $stmt2->bindValue($k++, __fi($chunks2[$i][$itemKey]));
                        $stmt2->bindValue($k++, __fi($chunks3[$i][$itemKey]));
                        $stmt2->bindValue($k++, __fi($chunks4[$i][$itemKey]));
                        $stmt2->bindValue($k++, __fi($chunks5[$i][$itemKey]));
                        $stmt2->bindValue($k++, __fi($chunks6[$i][$itemKey]));
                        $stmt2->bindValue($k++, __fi($chunks7[$i][$itemKey]));
                        $stmt2->bindValue($k++, $timestamp);
                        $new_gata_uid[$chunks3[$i][$itemKey]] = $chunks1[$i][$itemKey];
                    }
                    $stmt2->execute();
                }
                //print_r($new_gata_uid);
            }

            // insert in gata kashtkar table
            $ksht_uid = array();
            $ksht_village_code = array();
            $ksht_plot_number = array();
            $ksht_khata_number = array();
            $ksht_owner_number = array();
            $ksht_owner_name = array();
            $ksht_owner_father = array();
            $ksht_plot_area = array();
            $ksht_qPart = array();

            $kasht_intersect_query = $db->prepare("SELECT T1.UID, T1.VillageCode, T1.GataNo, T1.KhataNo, T1.OwnerNo, T1.owner_name, T1.owner_father, T1.Area
                                        FROM lm_api_gata_kashtkar T1
                                        WHERE T1.VillageCode = ?
                                        AND (T1.VillageCode, T1.GataNo, T1.KhataNo, T1.owner_name, T1.owner_father, T1.Area) NOT IN (
                                                            SELECT T2.VillageCode, T2.GataNo, T2.KhataNo, T2.owner_name, T2.owner_father, T2.Area
                                                            FROM lm_gata_kashtkar T2
                                                            WHERE T2.VillageCode = ?
                                                        )
                                        ");
            $kasht_intersect_query->bindParam(1, $village_codes);
            $kasht_intersect_query->bindParam(2, $village_codes);
            $kasht_intersect_query->execute();
            $kasht_intersect_query->setFetchMode(PDO::FETCH_ASSOC);
//echo $kasht_intersect_query->rowCount();
            while ($row = $kasht_intersect_query->fetch()) {
                $ksht_uid[] = array_key_exists('GataNo', $new_gata_uid) ? $new_gata_uid[$row['GataNo']] : $row['UID'];
                $ksht_village_code[] = $row['VillageCode'];
                $ksht_plot_number[] = $row['GataNo'];
                $ksht_khata_number[] = $row['KhataNo'];
                $ksht_owner_number[] = $row['OwnerNo'];
                $ksht_owner_name[] = $row['owner_name'];
                $ksht_owner_father[] = $row['owner_father'];
                $ksht_plot_area[] = $row['Area'];
            }
//print_r($ksht_uid);
            if (count_($ksht_uid)) {
                $ksht_batch_size = 2000;
                $ksht_chunks1 = array_chunk($ksht_uid, $ksht_batch_size);
                $ksht_chunks2 = array_chunk($ksht_village_code, $ksht_batch_size);
                $ksht_chunks3 = array_chunk($ksht_plot_number, $ksht_batch_size);
                $ksht_chunks4 = array_chunk($ksht_khata_number, $ksht_batch_size);
                $ksht_chunks5 = array_chunk($ksht_owner_number, $ksht_batch_size);
                $ksht_chunks6 = array_chunk($ksht_owner_name, $ksht_batch_size);
                $ksht_chunks7 = array_chunk($ksht_owner_father, $ksht_batch_size);
                $ksht_chunks8 = array_chunk($ksht_plot_area, $ksht_batch_size);
                $ksht_loop_size = ceil(count_($ksht_village_code) / $ksht_batch_size);

                for ($i = 0; $i < $ksht_loop_size; $i++) {
                    $ksht_query = "INSERT INTO lm_gata_kashtkar (UID, VillageCode, GataNo, KhataNo, OwnerNo, owner_name, owner_father, Area) VALUES "; //Prequery
                    $ksht_qPart = array_fill(0, count_($ksht_chunks1[$i]), "(?, ?, ?, ?, ?, ?, ?, ?)");
                    $ksht_query .= implode(",", $ksht_qPart);

                    $stmt2 = $db->prepare($ksht_query);
                    $k = 1;
                    foreach ($ksht_chunks1[$i] as $ksht_itemKey => $ksht_item) { //bind the values one by one
                        $stmt2->bindValue($k++, __fi($ksht_chunks1[$i][$ksht_itemKey]));
                        $stmt2->bindValue($k++, __fi($ksht_chunks2[$i][$ksht_itemKey]));
                        $stmt2->bindValue($k++, __fi($ksht_chunks3[$i][$ksht_itemKey]));
                        $stmt2->bindValue($k++, __fi($ksht_chunks4[$i][$ksht_itemKey]));
                        $stmt2->bindValue($k++, __fi($ksht_chunks5[$i][$ksht_itemKey]));
                        $stmt2->bindValue($k++, __fi($ksht_chunks6[$i][$ksht_itemKey]));
                        $stmt2->bindValue($k++, __fi($ksht_chunks7[$i][$ksht_itemKey]));
                        $stmt2->bindValue($k++, __fi($ksht_chunks8[$i][$ksht_itemKey]));
                    }
                    $stmt2->execute();
                }
            }
        }

        $time_end = microtime(true);
        $execution_time_sec = (int) ($time_end - $time_start);
        $fval = (int) ($execution_time_sec / 60);
        $mins = floor($fval % 60) . ' mins';
        $secs = floor($execution_time_sec % 60) . ' secs';

        // Make the changes to the database permanent
        $db_respose_data = array('count' => $count, 'time_execution' => $mins . ' ' . $secs, 'time' => $execution_time_sec);

        // Make the changes to the database permanent
        commit($db, '', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'import_excel_data') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $timestamp = time();

        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            // save attached file
            $uploadedfile = $_FILES['file']['tmp_name'];

            $name = $_FILES['file']['name'];
            $ext = strtolower(end(explode('.', $name)));
            $size = filesize($_FILES['file']['tmp_name']);
            $target_dir = "../media/import_data/";

            // rename image
            $name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $name);
            $rand_1 = rand(9999, 9999999);
            $rand_2 = rand(9999999, 9999999999);
            $rand_3 = rand();
            $actual_image_name = strtolower(str_replace(' ', '', $size . '_' . time() . '_' . $rand_1 . '_' . $rand_2 . '_' . $rand_3 . "." . $ext));
            move_uploaded_file($uploadedfile, $target_dir . $actual_image_name);

            if ($ext === 'xls') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($target_dir . $actual_image_name);
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet = $reader->load($target_dir . $actual_image_name);
            }
            $total_rows = $spreadsheet->getActiveSheet()->getHighestRow();
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            //remove first row of sheet
            array_shift($sheetData);
            //echo '<pre>';
            //print_r($sheetData);
            //exit;
            $records = 0;
            $total_record = count_($sheetData);

            //make chunks to update data in small units
            $chunks1 = array();
            $batch_size = 100;
            $chunks1 = array_chunk($sheetData, $batch_size);
            $loop_size = ceil(count($sheetData) / $batch_size);

            $uid = array();
            $village_name = array();
            $village_code = array();
            $gata_no = array();
            $khata_no = array();
            $area = array();
            $owner_number = array();
            $shreni = array();
            $synced_on = array();
            $area_required = array();
            $direction = array();
            $is_gata_approved_by_board = array();
            $gata_hold_by_dm = array();
            $gata_hold_by_bida_before_vigyapti = array();
            $gata_hold_by_dar_nirdharan_samiti = array();
            $bainama_hold_by_bida_after_dar_nirdharan = array();
            $ch41_45_ke_anusar_sreni = array();
            $ch41_45_ke_anusar_rakba = array();
            $fasali_ke_anusar_sreni = array();
            $fasali_ke_anusar_rakba = array();
            $parisampatti_by_lkp = array();
            $gata_ki_current_sreni = array();
            $road_status = array();
            $bida_hetu_anumanit_baimane = array();
            $dispute_status = array();
            $dispute_court_name = array();
            $dispute_court_number = array();
            $stay_court_status = array();
            $adhisuchana_ke_anusar_mauke_ki_stithi = array();
            $gata_notification_status = array();
            $gata_map_not_field = array();
            $nahar_map_but_kastkar = array();
            $sadak_map_but_kastkar = array();
            $total_tree = array();
            $vartaman_circle_rate = array();
            $khate_me_fasali_ke_anusar_kism = array();
            $fasali_me_kastkar_darj_status = array();

            $line_number = 1;

            //loop for iterate all chunks
            for ($j = 0; $j < $loop_size; $j++) {
                foreach ($chunks1[$j] as $itemKey => $item) {
                    $line_number++;
                    $uid[] = __fi(trim((string) $item[0]));
                    $village_name[] = __fi(trim((string) $item[1]));
                    $village_code[] = __fi(trim((string) $item[2]));
                    $gata_no[] = __fi(trim((string) $item[3]));
                    $khata_no[] = __fi(trim((string) $item[4]));
                    $area[] = __fi(trim((string) $item[5]));
                    $owner_number[] = __fi(trim((string) $item[6]));
                    $shreni[] = __fi(trim((string) $item[7]));
                    $area_required[] = __fi(trim((string) $item[8]));
                    $is_gata_approved_by_board[] = __fi(trim((string) $item[9]));
                    $gata_hold_by_dm[] = __fi(trim((string) $item[10]));
                    $gata_hold_by_bida_before_vigyapti[] = __fi(trim((string) $item[11]));
                    $gata_hold_by_dar_nirdharan_samiti[] = __fi(trim((string) $item[12]));
                    $bainama_hold_by_bida_after_dar_nirdharan[] = __fi(trim((string) $item[13]));
                    $ch41_45_ke_anusar_sreni[] = __fi(trim((string) $item[14]));
                    $ch41_45_ke_anusar_rakba[] = __fi(trim((string) $item[15]));
                    $fasali_ke_anusar_sreni[] = __fi(trim((string) $item[16]));
                    $fasali_ke_anusar_rakba[] = __fi(trim((string) $item[17]));
                    $khate_me_fasali_ke_anusar_kism[] = __fi(trim((string) $item[18]));
                    $fasali_me_kastkar_darj_status[] = __fi(trim((string) $item[19]));
                    $parisampatti_by_lkp[] = __fi(trim((string) $item[20]));
                    $dispute_status[] = __fi(trim((string) $item[21]));
                    $dispute_court_name[] = __fi(trim((string) $item[22]));
                    $dispute_court_number[] = __fi(trim((string) $item[23]));
                    $stay_court_status[] = __fi(trim((string) $item[24]));
                    $adhisuchana_ke_anusar_mauke_ki_stithi[] = __fi(trim((string) $item[25]));
                    $gata_notification_status[] = __fi(trim((string) $item[26]));
                    $gata_map_not_field[] = __fi(trim((string) $item[27]));
                    $nahar_map_but_kastkar[] = __fi(trim((string) $item[28]));
                    $sadak_map_but_kastkar[] = __fi(trim((string) $item[29]));
                    $total_tree[] = __fi(trim((string) $item[30]));
                    $vartaman_circle_rate[] = __fi(trim((string) $item[31]));
                    $agricultural_area[] = __fi(trim((string) $item[32]));
                    $current_circle_rate[] = __fi(trim((string) $item[33]));
                    $agri_amount[] = __fi(trim((string) $item[34]));
                    $road_area[] = __fi(trim((string) $item[35]));
                    $road_rate[] = __fi(trim((string) $item[36]));
                    $road_amount[] = __fi(trim((string) $item[37]));
                    $aabadi_area[] = __fi(trim((string) $item[38]));
                    $aabadi_rate[] = __fi(trim((string) $item[39]));
                    $aabadi_amount[] = __fi(trim((string) $item[40]));
                    $govt_amount[] = __fi(trim((string) $item[41]));
                    $land_total_amount[] = __fi(trim((string) $item[42]));
                    $parisampatti_name[] = __fi(trim((string) $item[43]));
                    $total_parisampatti_amount[] = __fi(trim((string) $item[44]));
                    $extra_2015_amount[] = __fi(trim((string) $item[45]));
                    $total_land_and_parisampatti_amount[] = __fi(trim((string) $item[46]));
                    $total_land_parisampati_amount_roundof[] = __fi(trim((string) $item[47]));
                    $exp_stamp_duty[] = __fi(trim((string) $item[48]));
                    $exp_nibandh_sulk[] = __fi(trim((string) $item[49]));
                    $lekhpal_pratilipi_tax[] = __fi(trim((string) $item[50]));
                    $grand_total[] = __fi(trim((string) $item[51]));
                    $last_year_bainama_circle_rate[] = __fi(trim((string) $item[52]));
                    $last_two_year_bainama_circle_rate[] = __fi(trim((string) $item[53]));
                    $vrihad_pariyojna[] = __fi(trim((string) $item[54]));
                    $sc_st_kashtkar[] = __fi(trim((string) $item[55]));
                    $dhara_98[] = __fi(trim((string) $item[56]));
                    $dhara_80_143[] = __fi(trim((string) $item[57]));
                }
            }
        }

        if (($line_number - 1) == count_($uid)) {
            foreach ($uid as $key => $value) {
                $updt = $db->prepare("UPDATE lm_gata SET
                    RequiredArea = ?,
                    BoardApproved = ?,
                    HoldByDM = ?,
                    HoldByBIDA = ?,
                    HoldByNirdharan = ?,
                    BinamaHoldByBIDA = ?,
                    ch41_45_ke_anusar_sreni = ?,
                    ch41_45_ke_anusar_rakba = ?,
                    fasali_ke_anusar_sreni = ?,
                    fasali_ke_anusar_rakba = ?,
                    parisampatti_by_lkp = ?,
                    dispute_status = ?,
                    dispute_court_name = ?,
                    dispute_court_number = ?,
                    stay_court_status = ?,
                    adhisuchana_ke_anusar_mauke_ki_stithi = ?,
                    gata_notification_status = ?,
                    gata_map_not_field = ?,
                    nahar_map_but_kastkar = ?,
                    sadak_map_but_kastkar = ?,
                    total_tree = ?,
                    vartaman_circle_rate = ?,
                    khate_me_fasali_ke_anusar_kism = ?,
                    fasali_me_kastkar_darj_status = ?,
                    agricultural_area = ?,
                    current_circle_rate = ?,
                    agri_amount = ?,
                    road_area = ?,
                    road_rate = ?,
                    road_amount = ?,
                    aabadi_area = ?,
                    aabadi_rate = ?,
                    aabadi_amount = ?,
                    govt_amount = ?,
                    land_total_amount = ?,
                    parisampatti_name = ?,
                    total_parisampatti_amount = ?,
                    extra_2015_amount = ?,
                    total_land_and_parisampatti_amount = ?,
                    total_land_parisampati_amount_roundof = ?,
                    exp_stamp_duty = ?,
                    exp_nibandh_sulk = ?,
                    lekhpal_pratilipi_tax = ?,
                    grand_total = ?,
                    last_year_bainama_circle_rate = ?,
                    last_two_year_bainama_circle_rate = ?,
                    vrihad_pariyojna = ?,
                    sc_st_kashtkar = ?,
                    dhara_98 = ?,
                    dhara_80_143 = ?
                    WHERE UID = ?
                    AND VillageCode = ?
                    ");
                $updt->bindParam(1, $area_required[$key]);
                $updt->bindParam(2, $is_gata_approved_by_board[$key]);
                $updt->bindParam(3, $gata_hold_by_dm[$key]);
                $updt->bindParam(4, $gata_hold_by_bida_before_vigyapti[$key]);
                $updt->bindParam(5, $gata_hold_by_dar_nirdharan_samiti[$key]);
                $updt->bindParam(6, $bainama_hold_by_bida_after_dar_nirdharan[$key]);
                $updt->bindParam(7, $ch41_45_ke_anusar_sreni[$key]);
                $updt->bindParam(8, $ch41_45_ke_anusar_rakba[$key]);
                $updt->bindParam(9, $fasali_ke_anusar_sreni[$key]);
                $updt->bindParam(10, $fasali_ke_anusar_rakba[$key]);
                $updt->bindParam(11, $parisampatti_by_lkp[$key]);
                $updt->bindParam(12, $dispute_status[$key]);
                $updt->bindParam(13, $dispute_court_name[$key]);
                $updt->bindParam(14, $dispute_court_number[$key]);
                $updt->bindParam(15, $stay_court_status[$key]);
                $updt->bindParam(16, $adhisuchana_ke_anusar_mauke_ki_stithi[$key]);
                $updt->bindParam(17, $gata_notification_status[$key]);
                $updt->bindParam(18, $gata_map_not_field[$key]);
                $updt->bindParam(19, $nahar_map_but_kastkar[$key]);
                $updt->bindParam(20, $sadak_map_but_kastkar[$key]);
                $updt->bindParam(21, $total_tree[$key]);
                $updt->bindParam(22, $vartaman_circle_rate[$key]);
                $updt->bindParam(23, $khate_me_fasali_ke_anusar_kism[$key]);
                $updt->bindParam(24, $fasali_me_kastkar_darj_status[$key]);
                $updt->bindParam(25, $agricultural_area[$key]);
                $updt->bindParam(26, $current_circle_rate[$key]);
                $updt->bindParam(27, $agri_amount[$key]);
                $updt->bindParam(28, $road_area[$key]);
                $updt->bindParam(29, $road_rate[$key]);
                $updt->bindParam(30, $road_amount[$key]);
                $updt->bindParam(31, $aabadi_area[$key]);
                $updt->bindParam(32, $aabadi_rate[$key]);
                $updt->bindParam(33, $aabadi_amount[$key]);
                $updt->bindParam(34, $govt_amount[$key]);
                $updt->bindParam(35, $land_total_amount[$key]);
                $updt->bindParam(36, $parisampatti_name[$key]);
                $updt->bindParam(37, $total_parisampatti_amount[$key]);
                $updt->bindParam(38, $extra_2015_amount[$key]);
                $updt->bindParam(39, $total_land_and_parisampatti_amount[$key]);
                $updt->bindParam(40, $total_land_parisampati_amount_roundof[$key]);
                $updt->bindParam(41, $exp_stamp_duty[$key]);
                $updt->bindParam(42, $exp_nibandh_sulk[$key]);
                $updt->bindParam(43, $lekhpal_pratilipi_tax[$key]);
                $updt->bindParam(44, $grand_total[$key]);
                $updt->bindParam(45, $last_year_bainama_circle_rate[$key]);
                $updt->bindParam(46, $last_two_year_bainama_circle_rate[$key]);
                $updt->bindParam(47, $vrihad_pariyojna[$key]);
                $updt->bindParam(48, $sc_st_kashtkar[$key]);
                $updt->bindParam(49, $dhara_98[$key]);
                $updt->bindParam(50, $dhara_80_143[$key]);
                $updt->bindParam(51, $value);
                $updt->bindParam(52, $village_code[$key]);
                $updt->execute();
            }
        }

        // Make the changes to the database permanent
        $db_respose_data = array();

        // Make the changes to the database permanent
        commit($db, 'Data imported successfully', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'save_village_ebasta') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $timestamp = time();
        $village_code = validateInteger($_POST['village_code']);
        $files_count = validateInteger($_POST['files_count']);
        $count = $_POST['count'] ? validateInteger($_POST['count']) : 1;
        $target_dir_image = '../' . $media_village_ebasta_path . '/';
        $column = 'Ebasta' . $files_count;
        $ebasta_array = array();

        /** image move to folder  * */
        if (is_uploaded_file($_FILES['ebasta_' . $files_count]['tmp_name']) && !empty($_FILES['ebasta_' . $files_count]['tmp_name'])) {
            $name = $_FILES['ebasta_' . $files_count]['name'];
            $tmpfile = $_FILES['ebasta_' . $files_count]['tmp_name'];
            $path = $target_dir_image;

            if (strlen($name)) {

                $ext = strtolower(end(explode('.', $name)));
                $orig_file_size = filesize($tmpfile);

                // rename image
                $name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $name);
                $rand_1 = rand(9999, 9999999);
                $rand_2 = rand(9999999, 9999999999);
                $rand_3 = rand();
                $rename_image = strtolower(str_replace(' ', '', $village_code . '_ebasta' . '_' . $orig_file_size . '_' . time() . '_' . $rand_1 . '_' . $rand_2 . '_' . $rand_3));
                $actual_image_name = $rename_image . "." . $ext;
                $target_file = $path . '/' . $actual_image_name;

                // upload videos from client to server in chunks
                $chunk_size = 1024; // chunk in bytes
                $upload_start = 0;
                $handle = fopen($tmpfile, "rb");
                $fp = fopen($target_file, 'w');

                while ($upload_start < $orig_file_size) {
                    $contents = fread($handle, $chunk_size);
                    fwrite($fp, $contents);
                    $upload_start += strlen($contents);
                    fseek($handle, $upload_start);
                }

                fclose($handle);
                fclose($fp);
                unlink($tmpfile);
                $ebasta_array[] = array(
                    'file_name' => $actual_image_name,
                    'uploaded_on' => $timestamp
                );

                try {
                    $insrt = $db->prepare("INSERT INTO lm_village_ebasta (VillageCode, $column) VALUES (?, ?)");
                    $insrt->bindParam(1, $village_code);
                    $insrt->bindParam(2, json_encode($ebasta_array));
                    $insrt->execute();
                } catch (PDOException $ex) {
                    if ($ex->getCode() == 23000) {
                        $updt = $db->prepare("UPDATE lm_village_ebasta SET $column = ? WHERE VillageCode = ? ");
                        $updt->bindParam(1, json_encode($ebasta_array));
                        $updt->bindParam(2, $village_code);
                        $updt->execute();
                    }
                }
            }
        }

        // Make the changes to the database permanent
        $db_respose_data = array('count' => $count);

        // Make the changes to the database permanent
        commit($db, '', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'save_gata_ebasta') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $gata_no = array();
        $kashtkar = array();
        $timestamp = time();
        $village_code = validateInteger($_POST['village_code']);
        $gata_no = explode(',', $_POST['gata_no']);
        $khata_no = explode(',', $_POST['khata_no']);
        $kashtkar = explode(',', $_POST['kashtkar']);
        $kashtkar_ansh = explode(',', $_POST['kashtkar_ansh']);
        $ansh_rakba = explode(',', $_POST['ansh_rakba']);
        $ansh_date = explode(',', $_POST['ansh_date']);
        $owner_name = explode(',', $_POST['owner_name']);
        $owner_father = explode(',', $_POST['owner_father']);
        $files_count = validateInteger($_POST['files_count']);
        $count = $_POST['count'] ? validateInteger($_POST['count']) : 1;
        $target_dir_image = '../' . $media_gata_ebasta_path . '/';
        $column = 'Ebasta' . $files_count;
        $ebasta_array = array();

        /** image move to folder  * */
        if (is_uploaded_file($_FILES['ebasta_' . $files_count]['tmp_name']) && !empty($_FILES['ebasta_' . $files_count]['tmp_name'])) {
            $name = $_FILES['ebasta_' . $files_count]['name'];
            $tmpfile = $_FILES['ebasta_' . $files_count]['tmp_name'];
            $path = $target_dir_image;

            if (strlen($name)) {

                $ext = strtolower(end(explode('.', $name)));
                $orig_file_size = filesize($tmpfile);

                // rename image
                $name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $name);
                $rand_1 = rand(9999, 9999999);
                $rand_2 = rand(9999999, 9999999999);
                $rand_3 = rand();
                $rename_image = strtolower(str_replace(' ', '', $village_code . '_gataebasta' . '_' . $orig_file_size . '_' . time() . '_' . $rand_1 . '_' . $rand_2 . '_' . $rand_3));
                $actual_image_name = $rename_image . "." . $ext;
                $target_file = $path . '/' . $actual_image_name;

                // upload videos from client to server in chunks
                $chunk_size = 1024; // chunk in bytes
                $upload_start = 0;
                $handle = fopen($tmpfile, "rb");
                $fp = fopen($target_file, 'w');

                while ($upload_start < $orig_file_size) {
                    $contents = fread($handle, $chunk_size);
                    fwrite($fp, $contents);
                    $upload_start += strlen($contents);
                    fseek($handle, $upload_start);
                }

                fclose($handle);
                fclose($fp);
                unlink($tmpfile);
                $ebasta_array[] = array(
                    'file_name' => $actual_image_name,
                    'uploaded_on' => $timestamp
                );

                foreach ($gata_no as $key => $value) {
                    if ($kashtkar[$key]) {
                        $kashtkar_data = explode('@', decryptIt(myUrlEncode($kashtkar[$key])));
                        $ansh_ka_date = $ansh_date[$key] ? strtotime($ansh_date[$key]) : 0;
                        try {
                            $insrt = $db->prepare("INSERT INTO lm_gata_ebasta (VillageCode, GataNo, KhataNo, OwnerNo, owner_name, owner_father, $column, KashtkarAnsh, AnshRakba, AnshDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                            $insrt->bindParam(1, $village_code);
                            $insrt->bindParam(2, $value);
                            $insrt->bindParam(3, $khata_no[$key]);
                            $insrt->bindParam(4, $kashtkar_data[0]);
                            $insrt->bindParam(5, $kashtkar_data[1]);
                            $insrt->bindParam(6, $kashtkar_data[2]);
                            $insrt->bindParam(7, json_encode($ebasta_array));
                            $insrt->bindParam(8, $kashtkar_ansh[$key]);
                            $insrt->bindParam(9, $ansh_rakba[$key]);
                            $insrt->bindParam(10, $ansh_ka_date);
                            $insrt->execute();
                        } catch (PDOException $ex) {
                            if ($ex->getCode() == 23000) {
                                $updt = $db->prepare("UPDATE lm_gata_ebasta SET KashtkarAnsh = ?, AnshRakba = ?, AnshDate = ?, $column = ? WHERE VillageCode = ? AND GataNo = ? AND KhataNo = ? AND OwnerNo = ? AND owner_name = ? AND owner_father = ?");
                                $updt->bindParam(1, $kashtkar_ansh[$key]);
                                $updt->bindParam(2, $ansh_rakba[$key]);
                                $updt->bindParam(3, $ansh_ka_date);
                                $updt->bindParam(4, json_encode($ebasta_array));
                                $updt->bindParam(5, $village_code);
                                $updt->bindParam(6, $value);
                                $updt->bindParam(7, $khata_no[$key]);
                                $updt->bindParam(8, $kashtkar_data[0]);
                                $updt->bindParam(9, $kashtkar_data[1]);
                                $updt->bindParam(10, $kashtkar_data[2]);
                                $updt->execute();
                            }
                        }
                    }
                }
            }
            // Make the changes to the database permanent
            $db_respose_data = array('count' => $count);

            // Make the changes to the database permanent
            commit($db, '', $db_respose_data);
        } else {
            $db_respose_data = json_encode(array('status' => '-1', 'message' => 'Error Code: ' . $_FILES['ebasta_' . $files_count]['error'] . '. Some problem with uploaded file.'));
            print_r($db_respose_data);
            exit();
        }
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'save_kashtkar') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $timestamp = time();
        $village_code = validateInteger($_POST['village_code']);
        $gata_no = __fi($_POST['gata_no']);
        $khata_no = __fi($_POST['khata_no']);
        $area = __fi(validateNumeric($_POST['area'], 'Area'));
        $kashtkar = __fi(validateMaxLen($_POST['kashtkar'], 100, 'Kahstkar Name'));
        $kashtkar_father = __fi(validateMaxLen($_POST['kashtkar_father'], 100, 'Kashtkar Father'));

        $village_query = $db->prepare("SELECT T1.UID, T1.KhataNo, T1.OwnerNo
                                    FROM lm_gata_kashtkar T1
                                    WHERE T1.VillageCode = ?
                                    AND T1.GataNo = ?
                                    AND T1.KhataNo = ?
                                    ORDER BY T1.OwnerNo DESC
                                    LIMIT 1
                                ");
        $village_query->bindParam(1, $village_code);
        $village_query->bindParam(2, $gata_no);
        $village_query->bindParam(3, $khata_no);
        $village_query->execute();
        $village_query->setFetchMode(PDO::FETCH_ASSOC);
        $kashtkarInfo = $village_query->fetch();
        $uid = $kashtkarInfo['UID'];
        //$khata_no = $kashtkarInfo['KhataNo'];
        $last_owner_no = $kashtkarInfo['OwnerNo'] + 1;

        $insrt = $db->prepare("INSERT INTO lm_gata_kashtkar (UID, VillageCode, GataNo, KhataNo, OwnerNo, owner_name, owner_father, Area, CreatedBy) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insrt->bindParam(1, $uid);
        $insrt->bindParam(2, $village_code);
        $insrt->bindParam(3, $gata_no);
        $insrt->bindParam(4, $khata_no);
        $insrt->bindParam(5, $last_owner_no);
        $insrt->bindParam(6, $kashtkar);
        $insrt->bindParam(7, $kashtkar_father);
        $insrt->bindParam(8, $area);
        $insrt->bindParam(9, $user_id);
        $insrt->execute();

        $db_respose_data = array('kashtkar' => $kashtkar, 'owner_no' => $last_owner_no);

        // Make the changes to the database permanent
        commit($db, 'Kashtkar added successfully.', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'save_mis_report') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $timestamp = time();
        $report_type = $_POST['report_type'];
        $report_date = date('Y-m-d', strtotime($_POST['mis_date']));

        if ($report_type == '1') {
            foreach ($_POST['village_code'] as $key => $value) {

                $updt = $db->prepare("UPDATE lm_village_sahmati_report SET Current = ? WHERE VillageCode = ?");
                $updt->bindValue(1, 0);
                $updt->bindParam(2, $value);
                $updt->execute();

                $updt = $db->prepare("DELETE FROM lm_village_sahmati_report WHERE VillageCode = ? AND ReportDate = ?");
                $updt->bindParam(1, $value);
                $updt->bindParam(2, $report_date);
                $updt->execute();

                $report_array = array();
                foreach ($_POST[$value . '_cell'] as $cellKey => $cellValue) {
                    $cell_count = $cellKey + 1;
                    $report_array[] = array(
                        'name' => 'cell_' . $cell_count,
                        'value' => $cellValue
                    );
                }

                $insrt = $db->prepare("INSERT INTO lm_village_sahmati_report (VillageCode, Report, DateEdited, EditedBy, ReportDate, Current) VALUES (?, ?, ?, ?, ?, ?)");
                $insrt->bindParam(1, $value);
                $insrt->bindParam(2, json_encode($report_array));
                $insrt->bindParam(3, $timestamp);
                $insrt->bindParam(4, $user_id);
                $insrt->bindParam(5, $report_date);
                $insrt->bindValue(6, 1);
                $insrt->execute();
            }
        } else if ($report_type == '2') {
            foreach ($_POST['village_code'] as $key => $value) {

                $updt = $db->prepare("UPDATE lm_village_bainama_report SET Current = ? WHERE VillageCode = ?");
                $updt->bindValue(1, 0);
                $updt->bindParam(2, $value);
                $updt->execute();

                $updt = $db->prepare("DELETE FROM lm_village_bainama_report WHERE VillageCode = ? AND ReportDate = ?");
                $updt->bindParam(1, $value);
                $updt->bindParam(2, $report_date);
                $updt->execute();

                $report_array = array();
                foreach ($_POST[$value . '_cell'] as $cellKey => $cellValue) {
                    $cell_count = $cellKey + 1;
                    $report_array[] = array(
                        'name' => 'cell_' . $cell_count,
                        'value' => $cellValue
                    );
                }

                $insrt = $db->prepare("INSERT INTO lm_village_bainama_report (VillageCode, Report, DateEdited, EditedBy, ReportDate, Current) VALUES (?, ?, ?, ?, ?, ?)");
                $insrt->bindParam(1, $value);
                $insrt->bindParam(2, json_encode($report_array));
                $insrt->bindParam(3, $timestamp);
                $insrt->bindParam(4, $user_id);
                $insrt->bindParam(5, $report_date);
                $insrt->bindValue(6, 1);
                $insrt->execute();
            }
        } else if ($report_type == '3') {
            foreach ($_POST['village_code'] as $key => $value) {

                $updt = $db->prepare("UPDATE lm_village_khatauni_report SET Current = ? WHERE VillageCode = ?");
                $updt->bindValue(1, 0);
                $updt->bindParam(2, $value);
                $updt->execute();

                $updt = $db->prepare("DELETE FROM lm_village_khatauni_report WHERE VillageCode = ? AND ReportDate = ?");
                $updt->bindParam(1, $value);
                $updt->bindParam(2, $report_date);
                $updt->execute();

                $report_array = array();
                foreach ($_POST[$value . '_cell'] as $cellKey => $cellValue) {
                    $cell_count = $cellKey + 1;
                    $report_array[] = array(
                        'name' => 'cell_' . $cell_count,
                        'value' => $cellValue
                    );
                }

                $insrt = $db->prepare("INSERT INTO lm_village_khatauni_report (VillageCode, Report, DateEdited, EditedBy, ReportDate, Current) VALUES (?, ?, ?, ?, ?, ?)");
                $insrt->bindParam(1, $value);
                $insrt->bindParam(2, json_encode($report_array));
                $insrt->bindParam(3, $timestamp);
                $insrt->bindParam(4, $user_id);
                $insrt->bindParam(5, $report_date);
                $insrt->bindValue(6, 1);
                $insrt->execute();
            }
        } else if ($report_type == '4') {
            foreach ($_POST['village_code'] as $key => $value) {

                $updt = $db->prepare("UPDATE lm_village_dhanrashi_report SET Current = ? WHERE VillageCode = ?");
                $updt->bindValue(1, 0);
                $updt->bindParam(2, $value);
                $updt->execute();

                $updt = $db->prepare("DELETE FROM lm_village_dhanrashi_report WHERE VillageCode = ? AND ReportDate = ?");
                $updt->bindParam(1, $value);
                $updt->bindParam(2, $report_date);
                $updt->execute();

                $report_array = array();
                foreach ($_POST[$value . '_cell'] as $cellKey => $cellValue) {
                    $cell_count = $cellKey + 1;
                    $report_array[] = array(
                        'name' => 'cell_' . $cell_count,
                        'value' => $cellValue
                    );
                }

                $insrt = $db->prepare("INSERT INTO lm_village_dhanrashi_report (VillageCode, Report, DateEdited, EditedBy, ReportDate, Current) VALUES (?, ?, ?, ?, ?, ?)");
                $insrt->bindParam(1, $value);
                $insrt->bindParam(2, json_encode($report_array));
                $insrt->bindParam(3, $timestamp);
                $insrt->bindParam(4, $user_id);
                $insrt->bindParam(5, $report_date);
                $insrt->bindValue(6, 1);
                $insrt->execute();
            }
        } else if ($report_type == '5') {
            foreach ($_POST['village_code'] as $key => $value) {

                $updt = $db->prepare("UPDATE lm_village_kabja_report SET Current = ? WHERE VillageCode = ?");
                $updt->bindValue(1, 0);
                $updt->bindParam(2, $value);
                $updt->execute();

                $updt = $db->prepare("DELETE FROM lm_village_kabja_report WHERE VillageCode = ? AND ReportDate = ?");
                $updt->bindParam(1, $value);
                $updt->bindParam(2, $report_date);
                $updt->execute();

                $report_array = array();
                foreach ($_POST[$value . '_cell'] as $cellKey => $cellValue) {
                    $cell_count = $cellKey + 1;
                    $report_array[] = array(
                        'name' => 'cell_' . $cell_count,
                        'value' => $cellValue
                    );
                }

                $insrt = $db->prepare("INSERT INTO lm_village_kabja_report (VillageCode, Report, DateEdited, EditedBy, ReportDate, Current) VALUES (?, ?, ?, ?, ?, ?)");
                $insrt->bindParam(1, $value);
                $insrt->bindParam(2, json_encode($report_array));
                $insrt->bindParam(3, $timestamp);
                $insrt->bindParam(4, $user_id);
                $insrt->bindParam(5, $report_date);
                $insrt->bindValue(6, 1);
                $insrt->execute();
            }
        }
        $db_respose_data = array();

        // Make the changes to the database permanent
        commit($db, 'Report updated successfully.', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'change_password') {

    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $timestamp = time();
        $pass = __fi(validateMaxLen($_POST['pass'], 20, 'New Password'));
        $cpass = __fi(validateMaxLen($_POST['cpass'], 20, 'Confirm New Password'));
        $crpass = __fi(hash('sha512', $_POST['crpass']));

        // Validate password strength
        $uppercase = preg_match('@[A-Z]@', $pass);
        $lowercase = preg_match('@[a-z]@', $pass);
        $number = preg_match('@[0-9]@', $pass);
        $specialChars = preg_match('@[^\w]@', $pass);

        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($pass) < 8) {
            $db_respose_data = json_encode(array('status' => '-1', 'message' => 'Password should be at least 8 characters in length and at least one upper case letter, one number, and one special character.'));
            print_r($db_respose_data);
            exit();
        }

        // check password
        $check_query = $db->prepare("SELECT T1.ID, T1.Password
                                    FROM lm_users T1
                                    WHERE T1.ID = ?
                                    AND T1.CipherPassword = ?
                                    AND T1.Active = ?
                                    LIMIT 1
                                    ");

        $check_query->bindParam(1, $user_id);
        $check_query->bindParam(2, $crpass);
        $check_query->bindValue(3, 1);
        $check_query->execute();
        $check_query_count = $check_query->rowCount();

        if ($check_query_count == 0) {
            $db_respose_data = json_encode(array('status' => '-1', 'message' => 'Entered current password is wrong.'));
            print_r($db_respose_data);
            exit();
        }

        $updt = $db->prepare("UPDATE lm_users SET Password = ?, CipherPassword = ? WHERE ID = ?");
        $updt->bindParam(1, $pass);
        $updt->bindParam(2, hash('sha512', $pass));
        $updt->bindParam(3, $user_id);
        $updt->execute();

        $db_respose_data = array();

        // Make the changes to the database permanent
        commit($db, 'Password changed successfully.', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }
        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'send_report_feedback') {

    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $timestamp = time();
        $resource_type = $_POST['resource_type'] ? __fi(validateInteger($_POST['resource_type'])) : 0;
        $report_type = __fi(validateMaxLen($_POST['report_type'], 20, ''));
        $village_code = $_POST['village_code'] ? __fi(validateInteger($_POST['village_code'])) : 0;
        $village_gata = __fi(validateMaxLen($_POST['village_gata'], 15, ''));
        $report_no = $_POST['report_no'] ? __fi(validateInteger($_POST['report_no'])) : 0;
        $report_feedback = __fi(validateInteger($_POST['report_feedback']));
        $remarks = __fi(validateMaxLen($_POST['message'], 320, 'Remarks'));

        $insrt = $db->prepare("INSERT INTO lm_dm_report_feedbacks (UserID, ResourceType, ReportType, VillageCode, GataNo, ReportNo, Feedback, Remarks, DateCreated) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insrt->bindParam(1, $user_id);
        $insrt->bindParam(2, $resource_type);
        $insrt->bindParam(3, $report_type);
        $insrt->bindParam(4, $village_code);
        $insrt->bindParam(5, $village_gata);
        $insrt->bindParam(6, $report_no);
        $insrt->bindParam(7, $report_feedback);
        $insrt->bindParam(8, $remarks);
        $insrt->bindParam(9, $timestamp);
        $insrt->execute();
        $feedback_id = $db->lastInsertId();

        $notify_query = $db->prepare("SELECT T1.ID, T1.Name
                                        FROM lm_users T1
                                        WHERE T1.UserType = ?
                                        LIMIT 1
                                        ");
        $notify_query->bindValue(1, 0);
        $notify_query->execute();
        $admin_id = 0;
        $admin_name = '';
        if ($notify_query->rowCount()) {
            $notify_query->setFetchMode(PDO::FETCH_ASSOC);
            $notifyInfo = $notify_query->fetch();
            $admin_name = $notifyInfo['Name'];
            $admin_id = $notifyInfo['ID'];
        }

        // send notifications
        if ($admin_id) {
            $row_data = array();

            $origin = 'dm_feedback'; //set origin to idetntify source of action
            $type = 'dm_feedback'; //set notification key for payload
            $priority = '1'; //set priority for for notification
            $row_data[] = array(
                'SenderID' => $user_id,
                'ReceiverID' => $admin_id,
                'Mobile' => '',
                'FcmToken' => '',
                'OsType' => '0',
                'Medium' => 'web',
                'Email' => '',
                'Attachment' => '',
                'Message' => 'New feedback for reports from DM.',
                'ID' => $feedback_id,
                'NotifyTo' => 'admin' //enter users, whom to send notification
            );
            // queue data
            $queue_params = queueData($db, $row_data, $origin, $type, $priority);

            // insert into queue table
            insert_into_queue($db, $queue_params);
        }

        $db_respose_data = array();

        // Make the changes to the database permanent
        commit($db, 'Feedback submitted successfully.', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }
        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'remove_alert_notiy') {

    $timestamp = __fi(time());
    $user_id = __fi($_SESSION['UserID']);
    $id = __fi($_POST['id']);

    try {
        // Begin Transaction
        $db->beginTransaction();

        // update queue table
        $updt = $db->prepare("UPDATE lm_web_queue SET Readed = ?, ReadTime = ? WHERE Readed = ? AND ID = ?");
        $updt->bindValue(1, 1);
        $updt->bindParam(2, $timestamp);
        $updt->bindValue(3, 0);
        $updt->bindParam(4, $id);
        $updt->execute();

        $db_respose_data = array();

        // Make the changes to the database permanent
        commit($db, '', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }
        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'remove_all_alert_notiy') {

    $timestamp = __fi(time());
    $user_id = __fi($_SESSION['UserID']);

    try {
        // Begin Transaction
        $db->beginTransaction();

        // insert into user table
        $updt = $db->prepare("UPDATE lm_web_queue SET Readed = ?, ReadTime = ? WHERE Readed = ?");
        $updt->bindValue(1, 1);
        $updt->bindParam(2, $timestamp);
        $updt->bindValue(3, 0);
        $updt->execute();

        $db_respose_data = array();

        // Make the changes to the database permanent
        commit($db, '', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }
        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'import_slao_data') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $timestamp = time();

        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            // save attached file
            $uploadedfile = $_FILES['file']['tmp_name'];

            $name = $_FILES['file']['name'];
            $ext = strtolower(end(explode('.', $name)));
            $size = filesize($_FILES['file']['tmp_name']);
            $target_dir = "../media/import_data/";

            // rename image
            $name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $name);
            $rand_1 = rand(9999, 9999999);
            $rand_2 = rand(9999999, 9999999999);
            $rand_3 = rand();
            $actual_image_name = strtolower(str_replace(' ', '', 'slao_report_' . $size . '_' . time() . '_' . $rand_1 . '_' . $rand_2 . '_' . $rand_3 . "." . $ext));
            move_uploaded_file($uploadedfile, $target_dir . $actual_image_name);

            if ($ext === 'xls') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($target_dir . $actual_image_name);
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet = $reader->load($target_dir . $actual_image_name);
            }
            $total_rows = $spreadsheet->getActiveSheet()->getHighestRow();
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            //remove first row of sheet
            array_shift($sheetData);
            //echo '<pre>';
            //print_r($sheetData);
            //exit;
            $records = 0;
            $total_record = count_($sheetData);

            //make chunks to update data in small units
            $chunks1 = array();
            $batch_size = 100;
            $chunks1 = array_chunk($sheetData, $batch_size);
            $loop_size = ceil(count($sheetData) / $batch_size);

            $village_code = array();
            $village_name = array();
            $kashtkar = array();
            $bank = array();
            $accno = array();
            $khata_no = array();
            $gata_no = array();
            $rakba = array();
            $bainama_date = array();
            $payment_date = array();
            $amount = array();

            $line_number = 1;

            //loop for iterate all chunks
            for ($j = 0; $j < $loop_size; $j++) {
                foreach ($chunks1[$j] as $itemKey => $item) {
                    if (trim((string) $item[0])) {
                        $village_query = $db->prepare("SELECT T1.VillageName, T1.VillageCode
                                                    FROM lm_village T1
                                                    WHERE T1.Active = ?
                                                    AND (T1.VillageName = ? OR T1.VillageNameHi = ?)
                                                    LIMIT 1
                                                    ");
                        $village_query->bindValue(1, 1);
                        $village_query->bindParam(2, __fi(trim((string) $item[0])));
                        $village_query->bindParam(3, __fi(trim((string) $item[0])));
                        $village_query->execute();
                        $village_query->setFetchMode(PDO::FETCH_ASSOC);
                        $villageInfo = $village_query->fetch();

                        $line_number++;
                        $village_code[] = $villageInfo['VillageCode'] ? $villageInfo['VillageCode'] : 0;
                        $village_name[] = validateMinLen(__fi(trim((string) $item[0])), 1, 'Village Name at line number ' . $line_number);
                        $bainama_date[] = validateMinLen(__fi(trim((string) $item[1])), 1, 'Bainama Date at line number ' . $line_number);
                        $vilekh_sankhya[] = validateMinLen(__fi(trim((string) $item[2])), 1, 'Vilekh Sankhya at line number ' . $line_number);
                        $kashtkar[] = validateMaxLen(__fi(trim((string) $item[3])), 255, 'Kastkar Name at line number ' . $line_number);
                        $gata_no[] = validateMaxLen(__fi(trim((string) $item[4])), 15, 'Gata No at line number ' . $line_number);
                        $gata_area[] = validateMaxLen(__fi(trim((string) $item[5])), 15, 'Gata Area at line number ' . $line_number);
                        $rakba[] = validateNumeric(__fi(trim((string) $item[6])), 'Rakba at line number ' . $line_number);
                        $bank[] = validateMaxLen(__fi(trim((string) $item[7])), 255, 'Bank Name at line number ' . $line_number);
                        $accno[] = validateMaxLen(__fi(trim((string) $item[8])), 45, 'Account Number at line number ' . $line_number);
                        $ifsc[] = validateMaxLen(__fi(trim((string) $item[9])), 15, 'IFSC at line number ' . $line_number);
                        $amount[] = validateNumeric(__fi(str_replace(',', '', trim((string) $item[10]))), 'Amount at line number ' . $line_number);
                    }
                }
            }
        }
        //echo $line_number . ' == ' . $total_record . '==' . count_($accno);
        if (($line_number - 1) == count_($accno)) {
            $batch_size = 100;
            $chunks1 = array_chunk($village_code, $batch_size);
            $chunks2 = array_chunk($village_name, $batch_size);
            $chunks3 = array_chunk($bainama_date, $batch_size);
            $chunks4 = array_chunk($vilekh_sankhya, $batch_size);
            $chunks5 = array_chunk($kashtkar, $batch_size);
            $chunks6 = array_chunk($gata_no, $batch_size);
            $chunks7 = array_chunk($gata_area, $batch_size);
            $chunks8 = array_chunk($rakba, $batch_size);
            $chunks9 = array_chunk($bank, $batch_size);
            $chunks10 = array_chunk($accno, $batch_size);
            $chunks11 = array_chunk($ifsc, $batch_size);
            $chunks12 = array_chunk($amount, $batch_size);
            $qPart = array();

            for ($i = 0; $i < $loop_size; $i++) {
                $query = "INSERT INTO lm_slao_report (VillageCode, VillageName, BainamaDate, VilekhSankhya, KashtkarName, GataNo, GataArea, Rakba, BankName, AccountNo, IFSC, Amount, DateCreated) VALUES "; //Prequery
                $qPart = array_fill(0, count_($chunks1[$i]), "(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $query .= implode(",", $qPart);

                $stmt2 = $db->prepare($query);
                $k = 1;
                foreach ($chunks1[$i] as $itemKey => $item) { //bind the values one by one
                    $stmt2->bindParam($k++, __fi($chunks1[$i][$itemKey]));
                    $stmt2->bindParam($k++, __fi($chunks2[$i][$itemKey]));
                    $stmt2->bindParam($k++, __fi($chunks3[$i][$itemKey]));
                    $stmt2->bindParam($k++, __fi($chunks4[$i][$itemKey]));
                    $stmt2->bindParam($k++, __fi($chunks5[$i][$itemKey]));
                    $stmt2->bindParam($k++, __fi($chunks6[$i][$itemKey]));
                    $stmt2->bindParam($k++, __fi($chunks7[$i][$itemKey]));
                    $stmt2->bindParam($k++, __fi($chunks8[$i][$itemKey]));
                    $stmt2->bindParam($k++, __fi($chunks9[$i][$itemKey]));
                    $stmt2->bindParam($k++, __fi($chunks10[$i][$itemKey]));
                    $stmt2->bindParam($k++, __fi($chunks11[$i][$itemKey]));
                    $stmt2->bindParam($k++, __fi($chunks12[$i][$itemKey]));
                    $stmt2->bindParam($k++, __fi($timestamp));
                }
                $stmt2->execute();
            }
        } else {
            $db_respose_data = json_encode(array('status' => '-1', 'message' => 'Something wrong with excel.'));
            print_r($db_respose_data);
            exit();
        }

        // Make the changes to the database permanent
        $db_respose_data = array();

        // Make the changes to the database permanent
        commit($db, 'Data imported successfully', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'import_bank_data') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $timestamp = time();

        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            // save attached file
            $uploadedfile = $_FILES['file']['tmp_name'];

            $name = $_FILES['file']['name'];
            $ext = strtolower(end(explode('.', $name)));
            $size = filesize($_FILES['file']['tmp_name']);
            $target_dir = "../media/import_data/";

            // rename image
            $name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $name);
            $rand_1 = rand(9999, 9999999);
            $rand_2 = rand(9999999, 9999999999);
            $rand_3 = rand();
            $actual_image_name = strtolower(str_replace(' ', '', 'bank_report_' . $size . '_' . time() . '_' . $rand_1 . '_' . $rand_2 . '_' . $rand_3 . "." . $ext));
            move_uploaded_file($uploadedfile, $target_dir . $actual_image_name);

            if ($ext === 'xls') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($target_dir . $actual_image_name);
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet = $reader->load($target_dir . $actual_image_name);
            }
            $total_rows = $spreadsheet->getActiveSheet()->getHighestRow();
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            //remove first row of sheet
            array_shift($sheetData);
            //echo '<pre>';
            //print_r($sheetData);
            //exit;
            $records = 0;
            $total_record = count_($sheetData);

            //make chunks to update data in small units
            $chunks1 = array();
            $batch_size = 100;
            $chunks1 = array_chunk($sheetData, $batch_size);
            $loop_size = ceil(count($sheetData) / $batch_size);

            $kashtkar = array();
            $bank = array();
            $accno = array();
            $payment_date = array();
            $amount = array();
            $status = array();
            $txn_no = array();

            $line_number = 1;

            //loop for iterate all chunks
            for ($j = 0; $j < $loop_size; $j++) {
                foreach ($chunks1[$j] as $itemKey => $item) {
                    $line_number++;
                    $kashtkar[] = validateMaxLen(__fi(trim((string) $item[0])), 255, 'Kastkar Name at line number ' . $line_number);
                    $bank[] = validateMaxLen(__fi(trim((string) $item[1])), 255, 'Bank IFSC at line number ' . $line_number);
                    $accno[] = validateMaxLen(__fi(trim((string) $item[2])), 45, 'Account Number at line number ' . $line_number);
                    $payment_date[] = validateMinMaxLen(__fi(trim((string) $item[3])), 1, 10, 'Payment Date at line number ' . $line_number);
                    $amount[] = validateNumeric(__fi((double) str_replace(',', '', trim((string) $item[4]))), 'Amount at line number ' . $line_number);
                    $status[] = __fi(trim((string) $item[5])) == 'PROCESSED' ? '1' : '0';
                    $txn_no[] = validateMaxLen(__fi(trim((string) $item[6])), 'Txn No at line number ' . $line_number);
                }
            }
        }

        if (($line_number - 1) == count_($accno)) {
            $batch_size = 100;
            $chunks1 = array_chunk($kashtkar, $batch_size);
            $chunks2 = array_chunk($bank, $batch_size);
            $chunks3 = array_chunk($accno, $batch_size);
            $chunks4 = array_chunk($payment_date, $batch_size);
            $chunks5 = array_chunk($status, $batch_size);
            $chunks6 = array_chunk($txn_no, $batch_size);
            $chunks7 = array_chunk($amount, $batch_size);
            $qPart = array();

            for ($i = 0; $i < $loop_size; $i++) {
                $query = "INSERT INTO lm_bank_report (KashtkarName, BankIFSC, AccountNo, PaymentDate, BankStatus, TxnNo, Amount, DateCreated) VALUES "; //Prequery
                $qPart = array_fill(0, count_($chunks1[$i]), "(?, ?, ?, ?, ?, ?, ?, ?)");
                $query .= implode(",", $qPart);

                $stmt2 = $db->prepare($query);
                $k = 1;
                foreach ($chunks1[$i] as $itemKey => $item) { //bind the values one by one
                    $stmt2->bindParam($k++, __fi($chunks1[$i][$itemKey]));
                    $stmt2->bindParam($k++, __fi($chunks2[$i][$itemKey]));
                    $stmt2->bindParam($k++, __fi($chunks3[$i][$itemKey]));
                    $stmt2->bindParam($k++, __fi($chunks4[$i][$itemKey]));
                    $stmt2->bindParam($k++, __fi($chunks5[$i][$itemKey]));
                    $stmt2->bindParam($k++, __fi($chunks6[$i][$itemKey]));
                    $stmt2->bindParam($k++, __fi($chunks7[$i][$itemKey]));
                    $stmt2->bindParam($k++, __fi($timestamp));
                }
                $stmt2->execute();
            }

            foreach ($accno as $key => $value) {
                $bank_status = $status[$key];
                $bank_txn_no = $txn_no[$key];
                $bank_amount = $amount[$key];
                $updt = $db->prepare("UPDATE lm_slao_report SET BankStatus = ?, TxnNo = ?, UpdatedFrom = ? WHERE AccountNo = ? AND BankStatus = ? AND Amount = ?");
                $updt->bindParam(1, $bank_status);
                $updt->bindParam(2, $bank_txn_no);
                $updt->bindValue(3, 1);
                $updt->bindParam(4, $value);
                $updt->bindValue(5, 0);
                $updt->bindParam(6, $bank_amount);
                $updt->execute();
            }
        } else {
            $db_respose_data = json_encode(array('status' => '-1', 'message' => 'Something wrong with excel.'));
            print_r($db_respose_data);
            exit();
        }

        // Make the changes to the database permanent
        $db_respose_data = array();

        // Make the changes to the database permanent
        commit($db, 'Data imported successfully', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'import_treasury_data') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $timestamp = time();

        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            // save attached file
            $uploadedfile = $_FILES['file']['tmp_name'];

            $name = $_FILES['file']['name'];
            $ext = strtolower(end(explode('.', $name)));
            $size = filesize($_FILES['file']['tmp_name']);
            $target_dir = "../media/import_data/";

            // rename image
            $name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $name);
            $rand_1 = rand(9999, 9999999);
            $rand_2 = rand(9999999, 9999999999);
            $rand_3 = rand();
            $actual_image_name = strtolower(str_replace(' ', '', 'treasury_report_' . $size . '_' . time() . '_' . $rand_1 . '_' . $rand_2 . '_' . $rand_3 . "." . $ext));
            move_uploaded_file($uploadedfile, $target_dir . $actual_image_name);

            if ($ext === 'xls') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($target_dir . $actual_image_name);
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet = $reader->load($target_dir . $actual_image_name);
            }
            $total_rows = $spreadsheet->getActiveSheet()->getHighestRow();
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            //remove first row of sheet
            array_shift($sheetData);
            //echo '<pre>';
            //print_r($sheetData);
            //exit;
            $records = 0;
            $total_record = count_($sheetData);

            //make chunks to update data in small units
            $chunks1 = array();
            $batch_size = 100;
            $chunks1 = array_chunk($sheetData, $batch_size);
            $loop_size = ceil(count($sheetData) / $batch_size);

            $kashtkar = array();
            $bank = array();
            $accno = array();
            $payment_date = array();
            $amount = array();
            $status = array();
            $txn_no = array();

            $line_number = 1;

            //loop for iterate all chunks
            for ($j = 0; $j < $loop_size; $j++) {
                foreach ($chunks1[$j] as $itemKey => $item) {
                    $line_number++;
                    $kashtkar[] = validateMaxLen(__fi(trim((string) $item[0])), 255, 'Kastkar Name at line number ' . $line_number);
                    $bank[] = validateMaxLen(__fi(trim((string) $item[1])), 255, 'Bank IFSC at line number ' . $line_number);
                    $accno[] = validateMaxLen(__fi(trim((string) $item[2])), 45, 'Account Number at line number ' . $line_number);
                    $payment_date[] = validateMinMaxLen(__fi(trim((string) $item[3])), 1, 10, 'Payment Date at line number ' . $line_number);
                    $amount[] = validateNumeric(__fi((double) str_replace(',', '', trim((string) $item[4]))), 'Amount at line number ' . $line_number);
                    $status[] = __fi(trim((string) $item[5])) == 'PROCESSED' ? '1' : '0';
                    $txn_no[] = validateMaxLen(__fi(trim((string) $item[6])), 'Txn No at line number ' . $line_number);
                }
            }
        }

        if (($line_number - 1) == count_($accno)) {
            $batch_size = 100;
            $chunks1 = array_chunk($kashtkar, $batch_size);
            $chunks2 = array_chunk($bank, $batch_size);
            $chunks3 = array_chunk($accno, $batch_size);
            $chunks4 = array_chunk($payment_date, $batch_size);
            $chunks5 = array_chunk($status, $batch_size);
            $chunks6 = array_chunk($txn_no, $batch_size);
            $chunks7 = array_chunk($amount, $batch_size);
            $qPart = array();

            for ($i = 0; $i < $loop_size; $i++) {
                $query = "INSERT INTO lm_treasury_report (KashtkarName, BankIFSC, AccountNo, PaymentDate, BankStatus, TxnNo, Amount, DateCreated) VALUES "; //Prequery
                $qPart = array_fill(0, count_($chunks1[$i]), "(?, ?, ?, ?, ?, ?, ?, ?)");
                $query .= implode(",", $qPart);

                $stmt2 = $db->prepare($query);
                $k = 1;
                foreach ($chunks1[$i] as $itemKey => $item) { //bind the values one by one
                    $stmt2->bindParam($k++, __fi($chunks1[$i][$itemKey]));
                    $stmt2->bindParam($k++, __fi($chunks2[$i][$itemKey]));
                    $stmt2->bindParam($k++, __fi($chunks3[$i][$itemKey]));
                    $stmt2->bindParam($k++, __fi($chunks4[$i][$itemKey]));
                    $stmt2->bindParam($k++, __fi($chunks5[$i][$itemKey]));
                    $stmt2->bindParam($k++, __fi($chunks6[$i][$itemKey]));
                    $stmt2->bindParam($k++, __fi($chunks7[$i][$itemKey]));
                    $stmt2->bindParam($k++, __fi($timestamp));
                }
                $stmt2->execute();
            }

            foreach ($accno as $key => $value) {
                $bank_status = $status[$key];
                $bank_txn_no = $txn_no[$key];
                $bank_amount = $amount[$key];
                $updt = $db->prepare("UPDATE lm_slao_report SET BankStatus = ?, TxnNo = ?, UpdatedFrom = ? WHERE AccountNo = ? AND BankStatus = ? AND Amount = ?");
                $updt->bindParam(1, $bank_status);
                $updt->bindParam(2, $bank_txn_no);
                $updt->bindValue(3, 1);
                $updt->bindParam(4, $value);
                $updt->bindValue(5, 0);
                $updt->bindParam(6, $bank_amount);
                $updt->execute();
            }
        } else {
            $db_respose_data = json_encode(array('status' => '-1', 'message' => 'Something wrong with excel.'));
            print_r($db_respose_data);
            exit();
        }

        // Make the changes to the database permanent
        $db_respose_data = array();

        // Make the changes to the database permanent
        commit($db, 'Data imported successfully', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'delete_slao_data') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $timestamp = time();
        $id = __fi(validateInteger(decryptIt(myUrlEncode($_POST['id']))), 'ID');

        $updt = $db->prepare("UPDATE lm_slao_report SET RowDeleted = ?, DeleteTime = ?, DeletedBy = ? WHERE ID = ?");
        $updt->bindValue(1, 1);
        $updt->bindParam(2, $timestamp);
        $updt->bindParam(3, $user_id);
        $updt->bindParam(4, $id);
        $updt->execute();

        // Make the changes to the database permanent
        $db_respose_data = array();

        // Make the changes to the database permanent
        commit($db, 'Data deleted successfully', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'delete_bulk_slao_data') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $timestamp = time();
        $ids = explode(',', __fi($_POST['ids']));

        $placeholders = '';
        $qPart = array_fill(0, count_($ids), "?");
        $placeholders .= implode(",", $qPart);

        $updt = $db->prepare("UPDATE lm_slao_report SET RowDeleted = ?, DeleteTime = ?, DeletedBy = ? WHERE ID IN ($placeholders)");
        $updt->bindValue(1, 1);
        $updt->bindParam(2, $timestamp);
        $updt->bindParam(3, $user_id);
        $i = 4;
        foreach ($ids as $key => $id) {
            $updt->bindParam($i++, $ids[$key]);
        }
        $updt->execute();

        // Make the changes to the database permanent
        $db_respose_data = array();

        // Make the changes to the database permanent
        commit($db, 'Data deleted successfully', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'delete_bank_data') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $timestamp = time();
        $id = __fi(validateInteger(decryptIt(myUrlEncode($_POST['id']))), 'ID');
        $txn = __fi(decryptIt(myUrlEncode($_POST['txn'])));

        $updt = $db->prepare("UPDATE lm_bank_report SET RowDeleted = ?, DeleteTime = ?, DeletedBy = ? WHERE ID = ?");
        $updt->bindValue(1, 1);
        $updt->bindParam(2, $timestamp);
        $updt->bindParam(3, $user_id);
        $updt->bindParam(4, $id);
        $updt->execute();

        $updt = $db->prepare("UPDATE lm_slao_report SET BankStatus = ?, TxnNo = ?, UpdatedFrom = ? WHERE TxnNo = ?");
        $updt->bindValue(1, 0);
        $updt->bindValue(2, '');
        $updt->bindValue(3, 0);
        $updt->bindParam(4, $txn);
        $updt->execute();

        // Make the changes to the database permanent
        $db_respose_data = array();

        // Make the changes to the database permanent
        commit($db, 'Data deleted successfully', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'delete_bulk_bank_data') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $timestamp = time();
        $ids = explode(',', __fi($_POST['ids']));
        $txns = explode(',', __fi($_POST['txn']));

        $placeholders = '';
        $qPart = array();
        $qPart = array_fill(0, count_($ids), "?");
        $placeholders .= implode(",", $qPart);

        $updt = $db->prepare("UPDATE lm_bank_report SET RowDeleted = ?, DeleteTime = ?, DeletedBy = ? WHERE ID IN ($placeholders)");
        $updt->bindValue(1, 1);
        $updt->bindParam(2, $timestamp);
        $updt->bindParam(3, $user_id);
        $i = 4;
        foreach ($ids as $key => $id) {
            $updt->bindParam($i++, $ids[$key]);
        }
        $updt->execute();

        $placeholders = '';
        $qPart = array();
        $qPart = array_fill(0, count_($txns), "?");
        $placeholders .= implode(",", $qPart);

        $updt = $db->prepare("UPDATE lm_slao_report SET BankStatus = ?, TxnNo = ?, UpdatedFrom = ? WHERE TxnNo IN ($placeholders)");
        $updt->bindValue(1, 0);
        $updt->bindValue(2, '');
        $updt->bindValue(3, 0);
        $i = 4;
        foreach ($txns as $key => $id) {
            $updt->bindParam($i++, $txns[$key]);
        }
        $updt->execute();

        // Make the changes to the database permanent
        $db_respose_data = array();

        // Make the changes to the database permanent
        commit($db, 'Data deleted successfully', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'save_mortgaged') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $gata_no = array();
        $kashtkar = array();
        $timestamp = time();
        $village_code = validateInteger($_POST['village_code'], 'Village');
        $gata_no = explode(',', $_POST['gata_no']);
        $khata_no = explode(',', $_POST['khata_no']);
        $kashtkar = explode(',', $_POST['kashtkar']);
        $option = __fi(validateInteger($_POST['mortgaged']), 'Option');
        $amount = $option == '1' ? __fi(validateNumeric($_POST['mortgaged_amount']), 'Amount') : 0;

        foreach ($gata_no as $key => $value) {
            $kashtkar_data = explode('@', decryptIt(myUrlEncode($kashtkar[$key])));
            $village_query = $db->prepare("SELECT T1.OwnerNo, T1.owner_name, T1.owner_father, T1.Area, T1.CreatedBy
                                FROM lm_gata_kashtkar T1
                                WHERE T1.VillageCode = ?
                                AND T1.GataNo = ?
                                AND T1.KhataNo = ?
                                AND T1.OwnerNo = ?
                                LIMIT 1
                                ");
            $village_query->bindParam(1, $village_code);
            $village_query->bindParam(2, $value);
            $village_query->bindParam(3, $khata_no[$key]);
            $village_query->bindParam(4, $kashtkar_data[0]);
            $village_query->execute();
            $village_query->setFetchMode(PDO::FETCH_ASSOC);
            $kashtkarInfo = $village_query->fetch();

            if ($kashtkar[$key]) {
                try {
                    $insrt = $db->prepare("INSERT INTO lm_gata_martgaged_info (VillageCode, GataNo, KhataNo, OwnerNo, owner_name, owner_father, Area, CreatedBy, Mortgaged, MortgagedAmount, BankID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $insrt->bindParam(1, $village_code);
                    $insrt->bindParam(2, $value);
                    $insrt->bindParam(3, $khata_no[$key]);
                    $insrt->bindParam(4, $kashtkar_data[0]);
                    $insrt->bindParam(5, $kashtkarInfo['owner_name']);
                    $insrt->bindParam(6, $kashtkarInfo['owner_father']);
                    $insrt->bindParam(7, $kashtkarInfo['Area']);
                    $insrt->bindParam(8, $kashtkarInfo['CreatedBy']);
                    $insrt->bindParam(9, $option);
                    $insrt->bindParam(10, $amount);
                    $insrt->bindParam(11, $user_id);
                    $insrt->execute();
                } catch (PDOException $ex) {
                    if ($ex->getCode() == 23000) {
                        $updt = $db->prepare("UPDATE lm_gata_martgaged_info SET Mortgaged = ?, MortgagedAmount = ? WHERE VillageCode = ? AND GataNo = ? AND KhataNo = ? AND OwnerNo = ? AND BankID = ? AND owner_name = ? AND owner_father = ?");
                        $updt->bindParam(1, $option);
                        $updt->bindParam(2, $amount);
                        $updt->bindParam(3, $village_code);
                        $updt->bindParam(4, $value);
                        $updt->bindParam(5, $khata_no[$key]);
                        $updt->bindParam(6, $kashtkar_data[0]);
                        $updt->bindParam(7, $user_id);
                        $updt->bindParam(8, $kashtkarInfo['owner_name']);
                        $updt->bindParam(9, $kashtkarInfo['owner_father']);
                        $updt->execute();
                    }
                }
            }
        }

        // Make the changes to the database permanent
        $db_respose_data = array();

        // Make the changes to the database permanent
        commit($db, 'Data updated successfully', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'add_file') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $department_name = __fi(validateMaxLen($_POST['department_name'], 100));
        $file_no = __fi(validateMaxLen($_POST['file_no'], 100));
        $name = __fi(validateMaxLen($_POST['name'], 100));
        $subject = __fi(validateMaxLen($_POST['subject'], 750));
        $folder_name = $_POST['folder_name'] ? __fi(validateMaxLen($_POST['folder_name'], 100)) : '';
        $file_creator = __fi(validateMaxLen($_POST['file_creator'], 100));
        $status = __fi(validateInteger($_POST['status'], 'Status'));
        $timestamp = time();
        $created_by = $_SESSION['UserID'];

        $office_file = $db->prepare("SELECT  T1.ID
                                                FROM lm_eoffice T1
                                                WHERE  T1.RowDeleted = ?
                                                AND T1.FileNo = ?
                                                ");
        $office_file->bindValue(1, 0);
        $office_file->bindParam(2, $file_no);
        $office_file->execute();
        $office_file->setFetchMode(PDO::FETCH_ASSOC);
        $office_count = $office_file->rowCount();

        if ($office_count > 0) {
            $db_respose_data = json_encode(array('status' => '-1', 'message' => 'File no. already exist.'));
            print_r($db_respose_data);
            exit();
        }

        $insrt = $db->prepare("INSERT INTO lm_eoffice (DepartmentName, FileNo, Name, Subject, FolderNameForNoteSheet, FileCreator, Active, CreatedDate, CreatedBy) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insrt->bindParam(1, $department_name);
        $insrt->bindParam(2, $file_no);
        $insrt->bindParam(3, $name);
        $insrt->bindParam(4, $subject);
        $insrt->bindParam(5, $folder_name);
        $insrt->bindParam(6, $file_creator);
        $insrt->bindParam(7, $status);
        $insrt->bindParam(8, $timestamp);
        $insrt->bindParam(9, $created_by);
        $insrt->execute();

        // Make the changes to the database permanent
        $db_respose_data = array();
        // Make the changes to the database permanent
        commit($db, 'New file added successfully', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'edit_file') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $department_name = __fi(validateMaxLen($_POST['department_name'], 100));
        $file_no = __fi(validateMaxLen($_POST['file_no'], 100));
        $name = __fi(validateMaxLen($_POST['name'], 100));
        $subject = __fi(validateMaxLen($_POST['subject'], 750));
        $folder_name = $_POST['folder_name'] ? __fi(validateMaxLen($_POST['folder_name'], 100)) : '';
        $file_creator = __fi(validateMaxLen($_POST['file_creator'], 100));
        $status = __fi(validateInteger($_POST['status'], 'Status'));
        $file_id = __fi(validateInteger(decryptIt(myUrlEncode($_POST['file_id'])), 'File ID'));
        $timestamp = time();
        $created_by = $_SESSION['UserID'];

        $office_file = $db->prepare("SELECT  T1.*
                                                FROM lm_eoffice T1
                                                WHERE  T1.RowDeleted = ?
                                                AND T1.ID = ?
                                                ");
        $office_file->bindValue(1, 0);
        $office_file->bindParam(2, $file_id);
        $office_file->execute();
        $office_file->setFetchMode(PDO::FETCH_ASSOC);
        $office_fileInfo = $office_file->fetch();

        $sql = $db->prepare("SELECT  T1.FileNo
                                                FROM lm_eoffice T1
                                                WHERE  T1.RowDeleted = ?
                                                AND T1.ID != ?
                                                ");
        $sql->bindValue(1, 0);
        $sql->bindParam(2, $file_id);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $office_count = $sql->rowCount();

        while ($row = $sql->fetch()) {
            if ($row['FileNo'] == $file_no) {
                $db_respose_data = json_encode(array('status' => '-1', 'message' => 'File no. already exist.'));
                print_r($db_respose_data);
                exit();
            }
        }

        $insrt = $db->prepare("INSERT INTO lm_eoffice_history (EofficeID, DepartmentName, FileNo, Name, Subject, FolderNameForNoteSheet, FileCreator, Active, RowDeleted, CreatedDate, EditDate, CreatedBy, UpdatedDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insrt->bindParam(1, $file_id);
        $insrt->bindParam(2, $office_fileInfo['DepartmentName']);
        $insrt->bindParam(3, $office_fileInfo['FileNo']);
        $insrt->bindParam(4, $office_fileInfo['Name']);
        $insrt->bindParam(5, $office_fileInfo['Subject']);
        $insrt->bindParam(6, $office_fileInfo['FolderNameForNoteSheet']);
        $insrt->bindParam(7, $office_fileInfo['FileCreator']);
        $insrt->bindParam(8, $office_fileInfo['Active']);
        $insrt->bindParam(9, $office_fileInfo['RowDeleted']);
        $insrt->bindParam(10, $office_fileInfo['CreatedDate']);
        $insrt->bindParam(11, $office_fileInfo['EditDate']);
        $insrt->bindParam(12, $office_fileInfo['CreatedBy']);
        $insrt->bindParam(13, $timestamp);
        $insrt->execute();

        $updt = $db->prepare("UPDATE lm_eoffice SET DepartmentName = ?, FileNo = ?, Name = ?, Subject = ?, FolderNameForNoteSheet = ?, FileCreator = ?, Active = ?, EditDate = ? WHERE ID = ?");
        $updt->bindParam(1, $department_name);
        $updt->bindParam(2, $file_no);
        $updt->bindParam(3, $name);
        $updt->bindParam(4, $subject);
        $updt->bindParam(5, $folder_name);
        $updt->bindParam(6, $file_creator);
        $updt->bindParam(7, $status);
        $updt->bindParam(8, $timestamp);
        $updt->bindParam(9, $file_id);
        $updt->execute();

        // Make the changes to the database permanent
        $db_respose_data = array();
        // Make the changes to the database permanent
        commit($db, 'Updated successfully', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'submit_grievance_report') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $griev_id = __fi(validateInteger(decryptIt(myUrlEncode($_POST['griev_id'])), 'ID'));
        $remarks = __fi(validateMaxLen($_POST['remarks'], 320, 'Remarks'));
        $timestamp = time();
        $allowed_ext = array("pdf"); // allowed extension
        $target_dir = dirname(dirname(__FILE__)) . "/" . $media_grievance_report_path . "/";

        if ($_FILES['griev_report']['size']) {
            // validate attachments
            validate_attachments($_FILES['griev_report'], $allowed_ext);

            // copy attachments to folder
            $imageArray = upload_attachments($_FILES['griev_report'], $target_dir, 209600, $allowed_ext, 'griev_report', $user_id, 1024, 768, 95);
            $actual_image_name = $imageArray[0];
        }

        $updt = $db->prepare("UPDATE lm_kashtkar_grievances SET Status = ?, StatusDate = ?, Attachment = ?, AttachmentBy = ?, Remarks = ? WHERE ID = ?");
        $updt->bindValue(1, 1);
        $updt->bindParam(2, $timestamp);
        $updt->bindParam(3, $actual_image_name);
        $updt->bindParam(4, $user_id);
        $updt->bindParam(5, $remarks);
        $updt->bindParam(6, $griev_id);
        $updt->execute();

        $griev_query = $db->prepare("SELECT T1.*
                                FROM lm_kashtkar_grievances T1
                                WHERE T1.ID = ?
                                ");
        $griev_query->bindParam(1, $griev_id);
        $griev_query->execute();
        $griev_query->setFetchMode(PDO::FETCH_ASSOC);
        $grievInfo = $griev_query->fetch();
        $mobile = $grievInfo['Mobile'];

        if ($mobile) {
            $row_data = array();

            $origin = 'kashtkar_grievance'; //set origin to idetntify source of action
            $type = 'kashtkar_grievance'; //set notification key for payload
            $priority = '1'; //set priority for for notification
            $row_data[] = array(
                'SenderID' => $user_id,
                'ReceiverID' => $mobile,
                'Mobile' => $mobile,
                'FcmToken' => '',
                'OsType' => '0',
                'Medium' => 'text',
                'Email' => '',
                'Attachment' => '',
                'Message' => 'आपकी शिकायत का निस्तारण कर दिया गया है।  कृपया निस्तारण हेतु अपने मोबाइल से लॉगिन कर के चेक करे। ',
                'NotifyTo' => 'kashtkar' //enter users, whom to send notification
            );
            // queue data
            $queue_params = queueData($db, $row_data, $origin, $type, $priority);

            // insert into queue table
            insert_into_queue($db, $queue_params);
        }

        // Make the changes to the database permanent
        $db_respose_data = array();
        // Make the changes to the database permanent
        commit($db, 'Report submitted successfully', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'change_language') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $_SESSION['Lng'] = $_POST['lng'];

        // Make the changes to the database permanent
        $db_respose_data = array();
        // Make the changes to the database permanent
        commit($db, '', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'save_bainama_amount') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $ebasta_id = __fi(decryptIt(myUrlEncode($_POST['id'])));
        $village_code = __fi(validateInteger(decryptIt(myUrlEncode($_POST['village_code'])), 'Village Code'));
        $vilekh = __fi(validateMaxLen($_POST['vilekh'], 10, 'Vilekh Sankhya'));
        $bainama_date = __fi($_POST['bainama_date']);
        $bainama_area = $_POST['bainama_area'] ? __fi(validateNumeric($_POST['bainama_area'], 'Bainama Area')) : 0;
        $amount = $_POST['amount'] ? __fi(validateMaxLen($_POST['amount'], 14, 'Bainama Amount')) : 0;
        $land_amount = $_POST['land_amount'] ? __fi(validateMaxLen($_POST['land_amount'], 14, 'Land Amount')) : 0;
        $pari_amount = $_POST['pari_amount'] ? __fi(validateMaxLen($_POST['pari_amount'], 14, 'Parisampatti Amount')) : 0;
        $pamount = $_POST['payment_amount'] ? __fi(validateMaxLen($_POST['payment_amount'], 14, 'Payment Amount')) : 0;
        $pdate = $_POST['payment_date'] ? strtotime(__fi(validateDDMMYYYY($_POST['payment_date'], 'Payment Date'))) : 0;
        $timestamp = time();
        $total_amount = $land_amount + $pari_amount;
        $explode_ebasta_ids = explode(',', $ebasta_id);
        $placeholders = '';
        $qPart = array_fill(0, count_($explode_ebasta_ids), "?");
        $placeholders .= implode(",", $qPart);

        $sql = $db->prepare("SELECT T1.ID
                                FROM lm_gata_ebasta T1
                                WHERE T1.VillageCode = ?
                                AND T1.AnshDate = ?
                                AND T1.VilekhSankhya = ?
                                AND T1.ID NOT IN ($placeholders)
                                ");
        $sql->bindValue(1, $village_code);
        $sql->bindValue(2, $bainama_date);
        $sql->bindValue(3, $vilekh);
        $i = 4;
        foreach ($explode_ebasta_ids as $key => $id) {
            $sql->bindParam($i++, $explode_ebasta_ids[$key]);
        }
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $row_count = $sql->rowCount();

        if ($row_count) {
            $db_respose_data = json_encode(array('status' => '-1', 'message' => 'Vilekh sankhya already filled.'));
            print_r($db_respose_data);
            exit();
        }

        foreach ($explode_ebasta_ids as $key => $value) {
            $updt = $db->prepare("UPDATE lm_gata_ebasta SET VilekhSankhya = ?, BainamaArea = ?, BainamaAmount = ?, LandAmount = ?, ParisampattiAmount = ?, PaymentAmount = ?, PaymentDate = ? WHERE ID = ?");
            $updt->bindValue(1, $vilekh);
            $updt->bindParam(2, $bainama_area);
            $updt->bindParam(3, $amount);
            $updt->bindParam(4, $land_amount);
            $updt->bindParam(5, $pari_amount);
            $updt->bindParam(6, $pamount);
            $updt->bindParam(7, $pdate);
            $updt->bindParam(8, $value);
            $updt->execute();
        }
        // Make the changes to the database permanent
        $db_respose_data = array('vilekh' => $vilekh ? $vilekh : '--', 'amount' => $amount, 'land_amount' => $land_amount, 'pari_amount' => $pari_amount, 'bainama_area' => $bainama_area ? $bainama_area : 0, 'payment_amount' => $pamount, 'payment_date' => $_POST['payment_date'] ? date('d-m-Y', $pdate) : '--');

        // Make the changes to the database permanent
        commit($db, 'Bainama amount saved successfully', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'update_patravali') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $ebasta_id = __fi(decryptIt(myUrlEncode($_POST['id'])));
        $status = __fi(validateInteger($_POST['status'], 'Status'));
        $timestamp = time();
        $explode_ebasta_ids = explode(',', $ebasta_id);

        foreach ($explode_ebasta_ids as $key => $value) {
            $updt = $db->prepare("UPDATE lm_gata_ebasta SET PatravaliStatus = ? WHERE ID = ?");
            $updt->bindValue(1, $status);
            $updt->bindParam(2, $value);
            $updt->execute();
        }

        // Make the changes to the database permanent
        $db_respose_data = array();
        // Make the changes to the database permanent
        commit($db, 'Patravali status saved successfully', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'add_grievances') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $timestamp = time();
        $created_by = $_SESSION['UserID'];
        $mobile = $_POST['mobile'] ? __fi(validateMobile($_POST['mobile'], 'Mobile No')) : 0;
        $village_code = validateInteger($_POST['village_code'], 'Village Code');
        $gata_no = __fi($_POST['gata_no']);
        $khata_no = __fi($_POST['khata_no']);
        $type = $_POST['type'];
        $kashtkar_type = $_POST['kashtkar'];

        $griev_query = $db->prepare("SELECT T1.*
                                FROM lm_global_grievances T1
                                WHERE T1.Active = ?
                                AND T1.ID = ?
                                ");
        $griev_query->bindValue(1, 1);
        $griev_query->bindParam(2, $type);
        $griev_query->execute();
        $griev_query->setFetchMode(PDO::FETCH_ASSOC);
        $grievInfo = $griev_query->fetch();
        $griev_type = $grievInfo['Type'];

        $village_query = $db->prepare("SELECT T1.UID, T1.KhataNo, T1.OwnerNo
                                    FROM lm_gata_kashtkar T1
                                    WHERE T1.VillageCode = ?
                                    AND T1.GataNo = ?
                                    AND T1.KhataNo = ?
                                    ORDER BY T1.OwnerNo DESC
                                    LIMIT 1
                                ");
        $village_query->bindParam(1, $village_code);
        $village_query->bindParam(2, $gata_no);
        $village_query->bindParam(3, $khata_no);
        $village_query->execute();
        $village_query->setFetchMode(PDO::FETCH_ASSOC);
        $kashtkarInfo = $village_query->fetch();
        $uid = $kashtkarInfo['UID'];
        $last_owner_no = $kashtkarInfo['OwnerNo'] + 1;

        if ($kashtkar_type == 'other') {
            $owner_no = $last_owner_no;
            $owner_name = __fi(validateMaxLen($_POST['fname'], 100, 'Kahstkar Name'));
            $owner_father = __fi(validateMaxLen($_POST['pname'], 100, 'Kashtkar Father'));
            $gata_area = $_POST['area'] ? __fi(validateNumeric($_POST['area'], 'Area')) : 0;
        } else {
            $kashtkar_info = explode('@', decryptIt($_POST['kashtkar']));
            $owner_no = $kashtkar_info[0];
            $gata_area = $kashtkar_info[1] ? $kashtkar_info[1] : 0;
            $owner_name = $kashtkar_info[2];
            $owner_father = $kashtkar_info[3];
        }

        if ($kashtkar_type == 'other') {
            $insert = $db->prepare("INSERT INTO lm_gata_kashtkar (UID, VillageCode, GataNo, KhataNo, OwnerNo, owner_name, owner_father, Area, CreatedBy) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insert->bindParam(1, $uid);
            $insert->bindParam(2, $village_code);
            $insert->bindParam(3, $gata_no);
            $insert->bindParam(4, $khata_no);
            $insert->bindParam(5, $last_owner_no);
            $insert->bindParam(6, $owner_name);
            $insert->bindParam(7, $owner_father);
            $insert->bindParam(8, $gata_area);
            $insert->bindParam(9, $created_by);
            $insert->execute();
        }

        $target_dir_image = dirname(dirname(__FILE__)) . "/" . $media_grievance_report_path . "/";

        $allowed_ext = array("PDF", "pdf"); // allowed extension

        if (is_uploaded_file($_FILES['grievances_file']['tmp_name'])) {

            $name = $_FILES['grievances_file']['name'];
            $ext = strtolower(end(explode('.', $name)));

            if (!in_array($ext, $allowed_ext)) {
                // return response
                $db_respose_data = json_encode(array('status' => '-1', 'message' => 'Attached file type not allowed.'));
                print_r($db_respose_data);
                exit();
            }
        }

        /** image move to folder  * */
        if (is_uploaded_file($_FILES['grievances_file']['tmp_name']) && !empty($_FILES['grievances_file']['tmp_name'])) {
            $name = $_FILES['grievances_file']['name'];
            $tmpfile = $_FILES['grievances_file']['tmp_name'];
            $path = $target_dir_image;

            if (strlen($name)) {

                $ext = strtolower(end(explode('.', $name)));
                $orig_file_size = filesize($tmpfile);

                // rename image
                $name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $name);
                $rand_1 = rand(9999, 9999999);
                $rand_2 = rand(9999999, 9999999999);
                $rand_3 = rand();
                $rename_image = strtolower(str_replace(' ', '', 'grievances' . '' . $orig_file_size . '' . time() . '' . $rand_1 . '' . $rand_2 . '_' . $rand_3));
                $actual_document_name = $rename_image . "." . $ext;
                $target_file = $path . '/' . $actual_document_name;

                // upload videos from client to server in chunks
                $chunk_size = 1024; // chunk in bytes
                $upload_start = 0;
                $handle = fopen($tmpfile, "rb");
                $fp = fopen($target_file, 'w');

                while ($upload_start < $orig_file_size) {
                    $contents = fread($handle, $chunk_size);
                    fwrite($fp, $contents);
                    $upload_start += strlen($contents);
                    fseek($handle, $upload_start);
                }

                fclose($handle);
                fclose($fp);
                unlink($tmpfile);
            }
        }

        $insrt = $db->prepare("INSERT INTO lm_kashtkar_grievances (VillageCode, GataNo, KhataNo, OwnerNo, owner_name, owner_father, Area, Grievance, Mobile, DateCreated, Mode, OfflineAttachment, OfflineAttachmentBy) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insrt->bindParam(1, $village_code);
        $insrt->bindParam(2, $gata_no);
        $insrt->bindParam(3, $khata_no);
        $insrt->bindParam(4, $owner_no);
        $insrt->bindParam(5, $owner_name);
        $insrt->bindParam(6, $owner_father);
        $insrt->bindParam(7, $gata_area);
        $insrt->bindParam(8, $griev_type);
        $insrt->bindParam(9, $mobile);
        $insrt->bindParam(10, $timestamp);
        $insrt->bindValue(11, '1');
        $insrt->bindParam(12, $actual_document_name);
        $insrt->bindParam(13, $created_by);
        $insrt->execute();

        $db_respose_data = array();
        // Make the changes to the database permanent
        commit($db, 'Offline grievances saved successfully.', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'add_parisampatti') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $timestamp = time();
        $created_by = $_SESSION['UserID'];
        $department = explode('@BIDA', $_POST['department']);
        $department_id = __fi($department[0]);
        $tree_id = array();
        $sub_tree_id = array();
        $dimention_number = array();
        $dimention_amount = array();
        $property_amount = array();
        $minor_property_id = array();
        $property_id = array();
        $dimention_number_count = array();
        $total_dimention_amt = array();
        $tree_id = $_POST['tree_id'];
        $sub_tree_id = $_POST['sub_tree'];
        $dimention_number = $_POST['dimention_number'];
        $dimention_amount = $_POST['dimention_amount'];
        $property_amount = $_POST['property_amount'];
        $minor_property_id = $_POST['minor_property'];
        $property_id = $_POST['property'];
        $dimention_number_count = $_POST['dimention_number_count'];
        $total_dimention_amt = $_POST['total_dimention_amt'];
        $village_code = __fi(validateInteger($_POST['village_code'], 'Village Code'));
        $gata_no = __fi($_POST['gata_no']);
        $khata_no = __fi($_POST['khata_no']);
        $kashtkar_info = $_POST['kashtkar'] ? explode('@', decryptIt($_POST['kashtkar'])) : 0;
        if ($kashtkar_info) {
            $owner_no = __fi($kashtkar_info[0]);
            $gata_area = $kashtkar_info[1] ? __fi($kashtkar_info[1]) : 0;
            $owner_name = __fi($kashtkar_info[2]);
            $owner_father = __fi($kashtkar_info[3]);
        } else {
            $owner_name = '';
            $owner_father = '';
        }

        $different_amt_type = array();
        foreach ($property_amount as $key => $val) {

            $total_dimentionAmt = count_($total_dimention_amt) > 0 ? str_replace('₹', '', $total_dimention_amt[$key]) : 0;
            if (count_($tree_id) > 0 && $total_dimentionAmt == $property_amount[$key]) {
                $different_amt_type[] = '0';
            } else if (count_($tree_id) > 0 && $total_dimentionAmt != $property_amount[$key]) {
                $different_amt_type[] = '1';
            } else {
                $different_amt_type[] = '0';
            }
        }

        $different_amtount_type = in_array(1, $different_amt_type) ? 1 : 0;

        $property_count = 0;
        if (count_($tree_id) > 0) {
            $property_count = count_($tree_id);
        } else if (count_($minor_property_id) > 0) {
            $property_count = count_($minor_property_id);
        } else if (count_($property_id) > 0) {
            $property_count = count_($property_id);
        }

        $insrt = $db->prepare("INSERT INTO lm_asset_survey_data (DepartmentID, VillageCode, GataNo, KhataNo, owner_name, owner_father, DifferentAmountType, PropertyCount, CreatedBy, DateCreated) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insrt->bindParam(1, $department_id);
        $insrt->bindParam(2, $village_code);
        $insrt->bindParam(3, $gata_no);
        $insrt->bindParam(4, $khata_no);
        $insrt->bindParam(5, $owner_name);
        $insrt->bindParam(6, $owner_father);
        $insrt->bindParam(7, $different_amtount_type);
        $insrt->bindParam(8, $property_count);
        $insrt->bindParam(9, $created_by);
        $insrt->bindParam(10, $timestamp);
        $insrt->execute();
        $assetSurveyId = $db->lastInsertId();

        foreach ($property_amount as $key => $val) {

            $total_dimentionAmt = count_($total_dimention_amt) > 0 ? str_replace('₹', '', $total_dimention_amt[$key]) : 0;
            if (count_($tree_id) > 0 && $total_dimentionAmt == $property_amount[$key]) {
                $different_amt_type = '0';
            } else if (count_($tree_id) > 0 && $total_dimentionAmt != $property_amount[$key]) {
                $different_amt_type = '1';
            } else {
                $different_amt_type = '0';
            }

            $dimentionAmount = count_($dimention_amount) > 0 ? str_replace('₹', '', $dimention_amount[$key]) : 0;
            $dimention_numberCount = count_($dimention_number_count) > 0 ? $dimention_number_count[$key] : 0;
            $treeId = count_($tree_id) > 0 ? $tree_id[$key] : 0;
            $sub_treeId = count_($sub_tree_id) > 0 ? $sub_tree_id[$key] : 0;
            $dimentionNumber = count_($dimention_number) > 0 ? $dimention_number[$key] : 0;
            $minor_propertyId = count_($minor_property_id) > 0 ? $minor_property_id[$key] : 0;
            $propertyId = count_($property_id) > 0 ? $property_id[$key] : 0;

            $insrt = $db->prepare("INSERT INTO lm_asset_survey_data_details (AssetSurveyID, TreeID, SubTreeID, MinorID, PropertyID, DimensionNumber, DimensionAmount, Amount, TotalDimentsionCount, TotalDimensionAmount, DifferentAmountType, DateCreated) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insrt->bindParam(1, $assetSurveyId);
            $insrt->bindParam(2, __fi($treeId));
            $insrt->bindParam(3, __fi($sub_treeId));
            $insrt->bindParam(4, __fi($minor_propertyId));
            $insrt->bindParam(5, __fi($propertyId));
            $insrt->bindParam(6, __fi($dimentionNumber));
            $insrt->bindParam(7, __fi($dimentionAmount));
            $insrt->bindParam(8, __fi($property_amount[$key]));
            $insrt->bindParam(9, __fi($dimention_numberCount));
            $insrt->bindParam(10, __fi($total_dimentionAmt));
            $insrt->bindParam(11, __fi($different_amt_type));
            $insrt->bindParam(12, $timestamp);
            $insrt->execute();
        }

        $db_respose_data = array();
        // Make the changes to the database permanent
        commit($db, 'Parisampatti saved successfully.', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'office_order') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $timestamp = time();
        $created_by = $_SESSION['UserID'];
        $order_month = __fi(strtotime(validateDDMMYYYY($_POST['order_month'], 'Select Month')));
        $order_no = __fi(validateMaxLen($_POST['order_no'], 25, 'Order No'));
        $subject = __fi(validateMaxLen($_POST['subject'], 750, 'Subject'));
        $issue_authority = __fi(validateMaxLen($_POST['issue_authority'], 250, 'Order Issuing Authority'));

        $target_dir_image = dirname(dirname(__FILE__)) . "/" . $media_office_order_path . "/";

        $allowed_ext = array("PDF", "pdf"); // allowed extension

        if (is_uploaded_file($_FILES['order_file']['tmp_name'])) {

            $name = $_FILES['order_file']['name'];
            $ext = strtolower(end(explode('.', $name)));

            if (!in_array($ext, $allowed_ext)) {
                // return response
                $db_respose_data = json_encode(array('status' => '-1', 'message' => 'Attached file type not allowed.'));
                print_r($db_respose_data);
                exit();
            }
        }

        /** image move to folder  * */
        if (is_uploaded_file($_FILES['order_file']['tmp_name']) && !empty($_FILES['order_file']['tmp_name'])) {
            $name = $_FILES['order_file']['name'];
            $tmpfile = $_FILES['order_file']['tmp_name'];
            $path = $target_dir_image;

            if (strlen($name)) {

                $ext = strtolower(end(explode('.', $name)));
                $orig_file_size = filesize($tmpfile);

                // rename image
                $name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $name);
                $rand_1 = rand(9999, 9999999);
                $rand_2 = rand(9999999, 9999999999);
                $rand_3 = rand();
                $rename_image = strtolower(str_replace(' ', '', 'order_file' . '' . $orig_file_size . '' . time() . '' . $rand_1 . '' . $rand_2 . '_' . $rand_3));
                $actual_document_name = $rename_image . "." . $ext;
                $target_file = $path . '/' . $actual_document_name;

                // upload videos from client to server in chunks
                $chunk_size = 1024; // chunk in bytes
                $upload_start = 0;
                $handle = fopen($tmpfile, "rb");
                $fp = fopen($target_file, 'w');

                while ($upload_start < $orig_file_size) {
                    $contents = fread($handle, $chunk_size);
                    fwrite($fp, $contents);
                    $upload_start += strlen($contents);
                    fseek($handle, $upload_start);
                }

                fclose($handle);
                fclose($fp);
                unlink($tmpfile);
            }
        }

        $insrt = $db->prepare("INSERT INTO lm_office_order_module (OrderMonth, Subject, EnterOrderNo, OrderIssueAuthority, OrderAttachment, DateCreated, CreatedBy) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insrt->bindParam(1, $order_month);
        $insrt->bindParam(2, $subject);
        $insrt->bindParam(3, $order_no);
        $insrt->bindParam(4, $issue_authority);
        $insrt->bindParam(5, $actual_document_name);
        $insrt->bindParam(6, $timestamp);
        $insrt->bindParam(7, $created_by);
        $insrt->execute();

        $db_respose_data = array();
        // Make the changes to the database permanent
        commit($db, 'Office order saved successfully.', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} 