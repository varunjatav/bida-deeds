<?php

date_default_timezone_set('Asia/Kolkata');
include_once '../config.php';
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_lifetime', $session_cookie_lifespan);
ini_set('session.gc_maxlifetime', $garbage_max_lifespan);
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once "../functions/insert_queue.function.php";
include_once "../functions/notification.function.php";
include_once '../pdf/mpdf/bootstrap.php';
include_once '../core/timezone.core.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;

if (isset($_POST['action']) && $_POST['action'] == 'send_otp') {

    $mobile = validateMobile($_POST['mobile'], 'Mobile');
    $os_type = 'web';

    if ($mobile) {
        try {
            // call generate otp function
            $otp = generate_otp($mobile, $db, $os_type);

            $user = $text_msg_user_otp; //your username
            $password = $text_msg_password; //your password

            $senderid = $default_Sender_msg_otp; //Your senderid
            $messagetype = $message_type; //Type Of Your Message
            $DReports = $delivery_report; //Delivery Reports
            $url = $text_msg_host; //"http://Domain name)/WebserviceSMS.aspx";
            //domain name: Domain name Replace With Your Domain
            $message = '91' . $mobile . '^' . urlencode(html_entity_decode('Dear user, ' . $otp . ' is your OTP. Valid for 15 min only and do not share with anyone - BIDA'));
            $ch = curl_init();
            if (!$ch) {
                die("Couldn't initialize a cURL handle");
            }
            $ret = curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "User=" . $user . "&passwd=" . $password . "&mno_msg=" . $message . "&sid=" . $senderid . "&mtype=" . $messagetype . "&DR=" . $DReports);
            $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $curlresponse = curl_exec($ch); // execute
            if (curl_errno($ch)) $curlresponse = 'curl error : ' . curl_error($ch);
            if (empty($ret)) {
                die(curl_error($ch));
                curl_close($ch); // close cURL handler

                $data = array('status' => '-1', 'message' => 'OTP नहीं भेजा गया है');
                // send response to application
                print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                exit();
            } else {
                $info = curl_getinfo($ch);
                curl_close($ch); // close cURL handler

                $data = array('status' => '1', 'message' => 'आपके मोबाइल पर OTP भेजा गया है');
                // send response to application
                print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                exit();
            }
        } catch (Exception $e) {
            
        }
    } else {
        //Creating JSON
        $data = array('status' => '-1', 'message' => 'Something wrong with input data.');
        // send response to application
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        exit();
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'check_otp') {

    try {

        $mobile = validateMobile($_POST['mobile'], 'Mobile');
        $otp = implode('', $_POST['otp']);
        $offset = $_POST['offset'];
        $dst = $_POST['dst'];
        $timestamp = time();

        $em_sql = $db->prepare("SELECT COUNT(*) AS Count, T1.OtpUpdated
                                FROM lm_login_otp T1
                                WHERE T1.Mobile = ?
                                AND T1.OTP = ?
                                AND T1.Used = ?
                                AND T1.OS = ?
                                ");
        $em_sql->bindParam(1, $mobile);
        $em_sql->bindParam(2, $otp);
        $em_sql->bindValue(3, 0);
        $em_sql->bindValue(4, 'web');
        $em_sql->execute();
        $rowcount = $em_sql->rowCount();
        $em_sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql = $em_sql->fetch();

        if ($sql['Count'] == 0) { 
            $data = array('status' => '-1', 'message' => 'OTP अमान्य। पुन: प्रयास करें');
            print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
            exit();
        } else {
            if (time() - $sql['OtpUpdated'] > 900) {

                $update_otp = $db->prepare("UPDATE lm_login_otp SET Used = ?, Expired = ?, ExpiredTime = ? WHERE OTP = ? AND Mobile = ?");
                $update_otp->bindValue(1, 1);
                $update_otp->bindValue(2, 1);
                $update_otp->bindParam(3, time());
                $update_otp->bindParam(4, $otp);
                $update_otp->bindParam(5, $mobile);
                $update_otp->execute();

                $data = array('status' => '-1', 'message' => 'OTP समाप्त हो गया। पुन: प्रयास करें।');
                print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
                exit();
            }

            session_start();
            session_regenerate_id(true);
            $_SESSION["Mobile"] = $mobile;
            $_SESSION['user_login_time'] = $timestamp;
            $timezone_name = Timezone::detect_timezone_id($offset, $dst);
            $_SESSION['user_timezone_name'] = $timezone_name;
            date_default_timezone_set($_SESSION['user_timezone_name']);
            $expiry_time = $timestamp + $cookie_ttl;
            $cookie_value = $mobile . '_' . $offset . '_' . $dst;
            setcookie($kasht_cookie_name, $cookie_value, [
                'expires' => $expiry_time,
                'path' => '/',
                'domain' => $cookie_domain,
                'secure' => true,
                'httponly' => true,
                'samesite' => 'None'
            ]);

            $update_otp = $db->prepare("UPDATE lm_login_otp SET Used = ? WHERE Mobile = ? AND OTP = ?");
            $update_otp->bindValue(1, 1);
            $update_otp->bindParam(2, $mobile);
            $update_otp->bindParam(3, $otp);
            $update_otp->execute();

            //Creating JSON
            $data = array('status' => '1', 'message' => 'OTP मान्य');
            print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
            exit();
        }
    } catch (Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'check_sahmati_eligibility') {

    $village_code = $_POST['village_code'];
    $gata_no = $_POST['gata_no'];
    $khata_no = $_POST['khata_no'];
    $decrypt_data = decryptIt(myUrlEncode($_POST['kashtkar']));
    $explode_data = explode('@', $decrypt_data);
    $owner_no = $explode_data[0];
    $gata_area = $explode_data[1];
    $owner_name = $explode_data[2];
    $owner_father = $explode_data[3];
    $sahmati_eligible = 0;

    $village_query = $db->prepare("SELECT T1.*, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE T1.VillageCode = ?
                                AND T1.GataNo = ?
                                AND T1.KhataNo = ?
                                AND ROUND(CAST(T1.Area AS FLOAT), 4) = ?
                                ");
    $village_query->bindParam(1, $village_code);
    $village_query->bindParam(2, $gata_no);
    $village_query->bindParam(3, $khata_no);
    $village_query->bindParam(4, $gata_area);
    $village_query->execute();
    $gata_count = $village_query->rowCount();
    $village_query->setFetchMode(PDO::FETCH_ASSOC);
    $gataInfo = $village_query->fetch();

    if ($gata_count) {
        $chakbandi_query = $db->prepare("SELECT T1.*, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE T1.VillageCode = ?
                                AND CAST(ch41_45_ke_anusar_rakba AS FLOAT) > ?
                                ");
        $chakbandi_query->bindParam(1, $village_code);
        $chakbandi_query->bindValue(2, 0);
        $chakbandi_query->execute();
        $chakbandi_query->setFetchMode(PDO::FETCH_ASSOC);
        $chakbandi_status = $chakbandi_query->rowCount();

        $answer_1 = '';
        $answer_2 = '';
        $answer_6 = '';
        $answer_7 = '';
        $answer_8 = '';
        $answer_10 = '';
        $sahmati_eligible = 0;

        if ((float) $gataInfo['fasali_ke_anusar_rakba'] > 0) {
            $sahmati_eligible++;
            $answer_1 = 'हाँ';
            $answer_color_1 = 'row-highlight-green';
        } else {
            $answer_1 = 'ना';
            $answer_color_1 = 'row-highlight-red';
            $answer_info_1 = 'डाटा उपलब्ध नहीं है';
        }

        if ($chakbandi_status) {
            if ((float) $gataInfo['ch41_45_ke_anusar_rakba']) {
                $sahmati_eligible++;
                $answer_2 = 'हाँ';
                $answer_color_2 = 'row-highlight-green';
                $answer_info_2 = 'ch41_45_ke_anusar_rakba: ' . $gataInfo['ch41_45_ke_anusar_rakba'];
            } else {
                $answer_2 = 'ना';
                $answer_color_2 = 'row-highlight-red';
                $answer_info_2 = 'डाटा उपलब्ध नहीं है';
            }
        } else {
            $sahmati_eligible++;
            $answer_2 = 'ना';
            $answer_color_2 = 'row-highlight-green';
            $answer_info_2 = 'इस ग्राम में चकबंदी नहीं हुई है';
        }

        if ($gataInfo['Shreni'] == '1-क' && $gataInfo['khate_me_fasali_ke_anusar_kism'] != '--') {
            //$var = array_keys(explode('(', $gataInfo['khate_me_fasali_ke_anusar_kism']));
            $data = strtolower($gataInfo['khate_me_fasali_ke_anusar_kism']);
            if (str_contains($data, 'nala') || str_contains($data, 'nali') || str_contains($data, 'pathar') || str_contains($data, 'patthar') || str_contains($data, 'paatthar') || str_contains($data, 'paathar') || str_contains($data, 'pathaar') || str_contains($data, 'pahad') || str_contains($data, 'paahaad') || str_contains($data, 'pahaad') || str_contains($data, 'paahad') || str_contains($data, 'pukhariya') || str_contains($data, 'pokhar') || str_contains($data, 'talab') || str_contains($data, 'dev sthan') || str_contains($data, 'khaliyan') || str_contains($data, 'khalihan') || str_contains($data, 'rasta') || str_contains($data, 'rashta') || str_contains($data, 'gochar') || str_contains($data, 'chakroad') || str_contains($data, 'chakmarg') || str_contains($data, 'jhadi') || str_contains($data, 'aabadi') || str_contains($data, 'abadi') || str_contains($data, 'abaadi') || str_contains($data, 'nadi') || str_contains($data, 'nahar') || str_contains($data, 'tauriya') || str_contains($data, 'jangal') || str_contains($data, 'van')) {
                $answer_6 = 'हाँ';
                $answer_color_6 = 'row-highlight-red';
                $answer_info_6 = 'current shreni: ' . $gataInfo['Shreni'] . ', khate_me_fasali_ke_anusar_kism: ' . $gataInfo['khate_me_fasali_ke_anusar_kism'];
            } else {
                $sahmati_eligible++;
                $vivran = $gataInfo['khate_me_fasali_ke_anusar_kism'] ? $gataInfo['khate_me_fasali_ke_anusar_kism'] : 'डाटा उपलब्ध नहीं है';
                $answer_6 = 'ना';
                $answer_color_6 = 'row-highlight-green';
                $answer_info_6 = 'current shreni: ' . $gataInfo['Shreni'] . ', khate_me_fasali_ke_anusar_kism: ' . $vivran;
            }
        } else {
            $sahmati_eligible++;
            $vivran = $gataInfo['khate_me_fasali_ke_anusar_kism'] ? $gataInfo['khate_me_fasali_ke_anusar_kism'] : 'डाटा उपलब्ध नहीं है';
            $answer_6 = 'ना';
            $answer_color_6 = 'row-highlight-green';
            $answer_info_6 = 'current shreni: ' . $gataInfo['Shreni'] . ', khate_me_fasali_ke_anusar_kism: ' . $vivran;
        }

        if ($chakbandi_status) {
            if ($gataInfo['ch41_45_ke_anusar_sreni'] != '--') {
                if (substr($gataInfo['ch41_45_ke_anusar_sreni'], 0, 1) == substr($gataInfo['Shreni'], 0, 1)) {
                    $sahmati_eligible++;
                    $answer_7 = 'हाँ';
                    $answer_color_7 = 'row-highlight-green';
                    $answer_info_7 = 'current shreni: ' . $gataInfo['Shreni'] . ', ch41_45_ke_anusar_sreni: ' . $gataInfo['ch41_45_ke_anusar_sreni'];
                } else {
                    $answer_7 = 'ना';
                    $answer_color_7 = 'row-highlight-red';
                    $answer_info_7 = 'current shreni: ' . $gataInfo['Shreni'] . ', ch41_45_ke_anusar_sreni: ' . $gataInfo['ch41_45_ke_anusar_sreni'];
                }
            } else {
                $answer_7 = 'ना';
                $answer_color_7 = 'row-highlight-red';
                $answer_info_7 = 'डाटा उपलब्ध नहीं है';
            }
        } else {
            $sahmati_eligible++;
            $answer_7 = 'ना';
            $answer_color_7 = 'row-highlight-green';
            $answer_info_7 = 'इस गाटे में चकबंदी नहीं हुई है';
        }

        if ((float) $gataInfo['fasali_ke_anusar_rakba']) {
            if ((float) $gataInfo['Area'] == (float) $gataInfo['fasali_ke_anusar_rakba']) {
                $sahmati_eligible++;
                $vivran = $gataInfo['fasali_ke_anusar_rakba'] ? $gataInfo['fasali_ke_anusar_rakba'] : 'डाटा उपलब्ध नहीं है';
                $answer_8 = 'ना';
                $answer_color_8 = 'row-highlight-green';
                $answer_info_8 = 'current area: ' . $gataInfo['Area'] . ', fasali_ke_anusar_rakba: ' . $vivran;
            } else {
                $vivran = $gataInfo['fasali_ke_anusar_rakba'] ? $gataInfo['fasali_ke_anusar_rakba'] : 'डाटा उपलब्ध नहीं है';
                $answer_8 = 'हाँ';
                if ((float) $gataInfo['Area'] < (float) $gataInfo['fasali_ke_anusar_rakba']) {
                    $sahmati_eligible++;
                    $answer_color_8 = 'row-highlight-green';
                } else {
                    $answer_color_8 = 'row-highlight-red';
                }
                $answer_info_8 = 'current area: ' . $gataInfo['Area'] . ', fasali_ke_anusar_rakba: ' . $vivran;
            }
        } else {
            $sahmati_eligible++;
            $answer_8 = 'ना';
            $answer_color_8 = 'row-highlight-green';
            $answer_info_8 = 'डाटा उपलब्ध नहीं है';
        }

        if ($chakbandi_status) {
            if ((float) $gataInfo['ch41_45_ke_anusar_rakba']) {
                if ((float) $gataInfo['Area'] == (float) $gataInfo['ch41_45_ke_anusar_rakba']) {
                    $sahmati_eligible++;
                    $vivran = $gataInfo['ch41_45_ke_anusar_rakba'] ? $gataInfo['ch41_45_ke_anusar_rakba'] : 'डाटा उपलब्ध नहीं है';
                    $answer_10 = 'ना';
                    $answer_color_10 = 'row-highlight-green';
                    $answer_info_10 = 'current area: ' . $gataInfo['Area'] . ', ch41_45_ke_anusar_rakba: ' . $vivran;
                } else {
                    $vivran = $gataInfo['ch41_45_ke_anusar_rakba'] ? $gataInfo['ch41_45_ke_anusar_rakba'] : 'डाटा उपलब्ध नहीं है';
                    $answer_10 = 'हाँ';
                    if ((float) $gataInfo['Area'] < (float) $gataInfo['ch41_45_ke_anusar_rakba']) {
                        $sahmati_eligible++;
                        $answer_color_10 = 'row-highlight-green';
                    } else {
                        $answer_color_10 = 'row-highlight-red';
                    }
                    $answer_info_10 = 'current area: ' . $gataInfo['Area'] . ', ch41_45_ke_anusar_rakba: ' . $vivran;
                }
            } else {
                $sahmati_eligible++;
                $answer_10 = 'ना';
                $answer_color_10 = 'row-highlight-green';
                $answer_info_10 = 'डाटा उपलब्ध नहीं है';
            }
        } else {
            $sahmati_eligible++;
            $answer_color_10 = 'row-highlight-green';
            $answer_10 = 'ना';
            $answer_info_10 = 'इस गाटे में चकबंदी नहीं हुई है';
        }
    }

    if ($sahmati_eligible == 6) {
        //Creating JSON
        $data = array('status' => '1', 'message' => '', 'owner_no' => $owner_no, 'owner_name' => $owner_name, 'owner_father' => $owner_father, 'gata_area' => $gata_area);
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        exit();
    } else {

        $lekhpal_query = $db->prepare("SELECT T2.ID, T2.Name, T2.Mobile, T2.FcmToken, T2.Medium, T2.OsType
                                        FROM lm_user_village_gata_mapping T1
                                        LEFT JOIN lm_users T2 ON T2.ID = T1.UserID
                                        WHERE T1.VillageCode = ?
                                        AND T1.GataNo = ?
                                        LIMIT 1
                                        ");
        $lekhpal_query->bindParam(1, $village_code);
        $lekhpal_query->bindParam(2, $gata_no);
        $lekhpal_query->execute();
        $lekhpal_name = '';
        $lekhpal_mobile = '';
        if ($lekhpal_query->rowCount()) {
            $lekhpal_query->setFetchMode(PDO::FETCH_ASSOC);
            $lekhpalInfo = $lekhpal_query->fetch();
            $lekhpal_id = $lekhpalInfo['ID'];
            $lekhpal_name = $lekhpalInfo['Name'];
            $lekhpal_mobile = $lekhpalInfo['Mobile'];
            $lekhpal_fcm = $lekhpalInfo['FcmToken'] ? $lekhpalInfo['FcmToken'] : '1';
            $lekhpal_medium = $lekhpalInfo['Medium'];
            $lekhpal_os_type = $lekhpalInfo['OsType'] ? $lekhpalInfo['OsType'] : '1';
        }

        $osd_query = $db->prepare("SELECT T2.ID, T2.Name, T2.Mobile
                                        FROM lm_user_village_mapping T1
                                        LEFT JOIN lm_users T2 ON T2.ID = T1.UserID
                                        WHERE T1.VillageCode = ?
                                        LIMIT 1
                                        ");
        $osd_query->bindParam(1, $village_code);
        $osd_query->execute();
        $osd_id = 0;
        $osd_name = '';
        $osd_mobile = '';
        if ($osd_query->rowCount()) {
            $osd_query->setFetchMode(PDO::FETCH_ASSOC);
            $osdInfo = $osd_query->fetch();
            $osd_name = $osdInfo['Name'];
            $osd_mobile = $osdInfo['Mobile'];
            $osd_id = $osdInfo['ID'];
        }

        $msg = '';
        if ($lekhpal_mobile && $osd_mobile == '') {
            $msg = 'कृपया सहमति के लिए लेखपाल (' . $lekhpal_mobile . ') तथा OSD से संपर्क करें';
        } else if ($lekhpal_mobile == '' && $osd_mobile) {
            $msg = 'कृपया सहमति के लिए लेखपाल तथा OSD (' . $osd_mobile . ') से संपर्क करें';
        } else if ($lekhpal_mobile && $osd_mobile) {
            $msg = 'कृपया सहमति के लिए लेखपाल (' . $lekhpal_mobile . ') तथा OSD (' . $osd_mobile . ') से संपर्क करें';
        } else {
            $msg = 'कृपया सहमति के लिए लेखपाल तथा OSD से संपर्क करें';
        }

        //Creating JSON
        $data = array('status' => '-1', 'message' => $msg);
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        exit();
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'upload_sahmati_otp') {

    $mobile = validateMobile($_POST['mobile'], 'Mobile');
    $os_type = 'sahmati';
    $allowed_ext = array("jpg", "png", "jpeg", "pdf"); // allowed extension

    if ($mobile) {

        try {
            // call generate otp function
            $otp = generate_otp($mobile, $db, $os_type);

            $user = $text_msg_user_otp; //your username
            $password = $text_msg_password; //your password

            $senderid = $default_Sender_msg_otp; //Your senderid
            $messagetype = $message_type; //Type Of Your Message
            $DReports = $delivery_report; //Delivery Reports
            $url = $text_msg_host; //"http://Domain name)/WebserviceSMS.aspx";
            //domain name: Domain name Replace With Your Domain
            $message = '91' . $mobile . '^' . urlencode(html_entity_decode('Dear user, ' . $otp . ' is your OTP. Valid for 15 min only and do not share with anyone - BIDA'));
            $ch = curl_init();
            if (!$ch) {
                die("Couldn't initialize a cURL handle");
            }
            $ret = curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "User=" . $user . "&passwd=" . $password . "&mno_msg=" . $message . "&sid=" . $senderid . "&mtype=" . $messagetype . "&DR=" . $DReports);
            $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $curlresponse = curl_exec($ch); // execute
            if (curl_errno($ch)) $curlresponse = 'curl error : ' . curl_error($ch);
            if (empty($ret)) {
                die(curl_error($ch));
                curl_close($ch); // close cURL handler

                $data = array('status' => '-1', 'message' => 'OTP नहीं भेजा गया है');
                // send response to application
                print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                exit();
            } else {
                $info = curl_getinfo($ch);
                curl_close($ch); // close cURL handler

                $data = array('status' => '1', 'message' => 'आपके मोबाइल पर OTP भेजा गया है');
                // send response to application
                print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                exit();
            }
        } catch (Exception $e) {
            
        }
    } else {
        //Creating JSON
        $data = array('status' => '-1', 'message' => 'Something wrong with input data.');
        // send response to application
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        exit();
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'upload_sahmati') {

    $mobile = validateMobile($_POST['mobile'], 'Mobile');
    $otp = implode('', $_POST['otp']);
    $village_code = $_POST['village_code'];
    $gata_no = $_POST['gata_no'];
    $khata_no = $_POST['khata_no'];
    $owner_no = $_POST['owner_no'];
    $gata_area = $_POST['gata_area'];
    $owner_name = $_POST['owner_name'];
    $owner_father = $_POST['owner_father'];
    $ansh = $_POST['ansh'];
    $timestamp = time();
    $target_dir = dirname(dirname(__FILE__)) . "/" . $media_kashtkar_sahmati_path . "/";
    $filename = 'sahmati_patra_' . microtime() . '.pdf';

    $em_sql = $db->prepare("SELECT COUNT(*) AS Count, T1.OtpUpdated
                                FROM lm_login_otp T1
                                WHERE T1.Mobile = ?
                                AND T1.OTP = ?
                                AND T1.Used = ?
                                AND T1.OS = ?
                                ");
    $em_sql->bindParam(1, $mobile);
    $em_sql->bindParam(2, $otp);
    $em_sql->bindValue(3, 0);
    $em_sql->bindValue(4, 'sahmati');
    $em_sql->execute();
    $rowcount = $em_sql->rowCount();
    $em_sql->setFetchMode(PDO::FETCH_ASSOC);
    $sql = $em_sql->fetch();

    if ($sql['Count'] == 0) {
        $data = array('status' => '-1', 'message' => 'OTP अमान्य। पुन: प्रयास करें');
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        exit();
    } else {
        if (time() - $sql['OtpUpdated'] > 900) {

            $update_otp = $db->prepare("UPDATE lm_login_otp SET Used = ?, Expired = ?, ExpiredTime = ? WHERE OTP = ? AND Mobile = ?");
            $update_otp->bindValue(1, 1);
            $update_otp->bindValue(2, 1);
            $update_otp->bindParam(3, time());
            $update_otp->bindParam(4, $otp);
            $update_otp->bindParam(5, $mobile);
            $update_otp->execute();

            $data = array('status' => '-1', 'message' => 'OTP समाप्त हो गया। पुन: प्रयास करें।');
            print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
            exit();
        }

        try {
            // Begin Transaction
            $db->beginTransaction();

            $update_otp = $db->prepare("UPDATE lm_login_otp SET Used = ? WHERE Mobile = ? AND OTP = ?");
            $update_otp->bindValue(1, 1);
            $update_otp->bindParam(2, $mobile);
            $update_otp->bindParam(3, $otp);
            $update_otp->execute();

            // generate sahmati patra PDF
            include_once '../pdf/mpdf/sahmati_form.php';

            $insrt = $db->prepare("INSERT INTO lm_kashtkar_sahmati (Mobile, VillageCode, GataNo, KhataNo, OwnerNo, OwnerName, OwnerFather, Ansh, Area, Attachment, DateCreated) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insrt->bindParam(1, $mobile);
            $insrt->bindParam(2, $village_code);
            $insrt->bindParam(3, $gata_no);
            $insrt->bindParam(4, $khata_no);
            $insrt->bindParam(5, $owner_no);
            $insrt->bindParam(6, $owner_name);
            $insrt->bindParam(7, $owner_father);
            $insrt->bindParam(8, $ansh);
            $insrt->bindParam(9, $gata_area);
            $insrt->bindParam(10, $filename);
            $insrt->bindParam(11, $timestamp);
            $insrt->execute();

            $lekhpal_query = $db->prepare("SELECT T2.ID, T2.Name, T2.Mobile, T2.FcmToken, T2.Medium, T2.OsType
                                        FROM lm_user_village_gata_mapping T1
                                        LEFT JOIN lm_users T2 ON T2.ID = T1.UserID
                                        WHERE T1.VillageCode = ?
                                        AND T1.GataNo = ?
                                        LIMIT 1
                                        ");
            $lekhpal_query->bindParam(1, $village_code);
            $lekhpal_query->bindParam(2, $gata_no);
            $lekhpal_query->execute();
            $lekhpal_name = '';
            $lekhpal_mobile = '';
            if ($lekhpal_query->rowCount()) {
                $lekhpal_query->setFetchMode(PDO::FETCH_ASSOC);
                $lekhpalInfo = $lekhpal_query->fetch();
                $lekhpal_id = $lekhpalInfo['ID'];
                $lekhpal_name = $lekhpalInfo['Name'];
                $lekhpal_mobile = $lekhpalInfo['Mobile'];
                $lekhpal_fcm = $lekhpalInfo['FcmToken'] ? $lekhpalInfo['FcmToken'] : '1';
                $lekhpal_medium = $lekhpalInfo['Medium'];
                $lekhpal_os_type = $lekhpalInfo['OsType'] ? $lekhpalInfo['OsType'] : '1';
            }

            if ($lekhpal_mobile) {
                $row_data = array();

                $origin = 'kashtkar_sahmati'; //set origin to idetntify source of action
                $type = 'kashtkar_sahmati'; //set notification key for payload
                $priority = '1'; //set priority for for notification
                $row_data[] = array(
                    'SenderID' => $mobile,
                    'ReceiverID' => $lekhpal_id,
                    'Mobile' => $lekhpal_mobile,
                    'FcmToken' => $lekhpal_fcm,
                    'OsType' => $lekhpal_os_type,
                    'Medium' => 'app',
                    'Email' => '',
                    'Attachment' => '',
                    'Message' => 'काश्तकार के द्वारा नए गाटे पर सहमति दी गयी है',
                    'NotifyTo' => 'lekhpal' //enter users, whom to send notification
                );
                // queue data
                $queue_params = queueData($db, $row_data, $origin, $type, $priority);

                // insert into queue table
                insert_into_queue($db, $queue_params);
            }

            $osd_query = $db->prepare("SELECT T2.ID, T2.Name, T2.Mobile
                                        FROM lm_user_village_mapping T1
                                        LEFT JOIN lm_users T2 ON T2.ID = T1.UserID
                                        WHERE T1.VillageCode = ?
                                        LIMIT 1
                                        ");
            $osd_query->bindParam(1, $village_code);
            $osd_query->execute();
            $osd_id = 0;
            $osd_name = '';
            $osd_mobile = '';
            if ($osd_query->rowCount()) {
                $osd_query->setFetchMode(PDO::FETCH_ASSOC);
                $osdInfo = $osd_query->fetch();
                $osd_name = $osdInfo['Name'];
                $osd_mobile = $osdInfo['Mobile'];
                $osd_id = $osdInfo['ID'];
            }

            $msg = '';
            if ($lekhpal_mobile && $osd_mobile == '') {
                $msg = 'सहमति सफलतापूर्वक अपलोड हो गई है। कृपया लेखपाल (' . $lekhpal_mobile . ') तथा OSD से संपर्क करें';
            } else if ($lekhpal_mobile == '' && $osd_mobile) {
                $msg = 'सहमति सफलतापूर्वक अपलोड हो गई है। कृपया लेखपाल तथा OSD (' . $osd_mobile . ') से संपर्क करें';
            } else if ($lekhpal_mobile && $osd_mobile) {
                $msg = 'सहमति सफलतापूर्वक अपलोड हो गई है। कृपया लेखपाल (' . $lekhpal_mobile . ') तथा OSD (' . $osd_mobile . ') से संपर्क करें';
            } else {
                $msg = 'सहमति सफलतापूर्वक अपलोड हो गई है। कृपया लेखपाल तथा OSD से संपर्क करें';
            }

            // Make the changes to the database permanent
            $db_respose_data = array();

            // Make the changes to the database permanent
            commit($db, $msg, $db_respose_data);
        } catch (\Exception $e) {
            if ($db->inTransaction()) {
                $db->rollback();
            }

            // return response
            $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
            rollback($db, $e->getCode(), $log_error_msg);
        }
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'preview_form') {

    $mobile = validateMobile($_POST['mobile'], 'Mobile');
    $otp = implode('', $_POST['otp']);
    $village_code = $_POST['village_code'];
    $gata_no = $_POST['gata_no'];
    $khata_no = $_POST['khata_no'];
    $owner_no = $_POST['owner_no'];
    $gata_area = $_POST['gata_area'];
    $owner_name = $_POST['owner_name'];
    $owner_father = $_POST['owner_father'];
    $ansh = $_POST['ansh'];
    $timestamp = time();

    $html = '
            <style>
                ol,td,th{text-align:center}body{font-size:17px;letter-spacing:1px;text-align:justify}body,div,p,td{font-family:freesans}.title-container{display:flex;flex-direction:column;align-items:center;justify-content:center}.fw-600{font-weight:600}table,td,th{border-collapse:collapse;border:1px solid #000}td,th{padding:2px}td{overflow:hidden;height:50px}.lt-container,.table-container{margin-bottom:30px}@media (max-width:768px){.lt-container{padding:2% 5%}td,th{font-size:14px;padding:5px}td{overflow:hidden;height:50px}}@media (max-width:480px){body{font-size:15px}.lt-container{padding:2% 2% 30% 2%}td,th{font-size:12px;padding:3px}td{overflow:hidden;height:50px}.title-container{text-align:center}table{width:100%;display:block;overflow-x:auto}}@media (max-width:320px){body{font-size:14px}.lt-container{padding:10px}td,th{font-size:10px;padding:2px}td{overflow:hidden;height:50px}}
            </style>
            <body>
            <div class="lt-container">

                <div style="text-align:center;font-weight:bold">
                    <div class="lt-title">प्रारूप संख्या-1</div>
                    <div class="ext-title">भूस्वामी/भूस्वामियों और क्रय निकाय के बीच लोक प्रयोजनों के लिए समझौते द्वाराभूमि क्रय किये जाने हेतु निष्पादित किया जाने वाला समझौता प्रमाण पत्र।</div>
                </div>

                <div class="cntr-2">
                    <p>यह समझौता पत्र आज दिनांक ' . date('d-m-Y', time()) . ' वर्ष ' . date('Y', time()) . ' को निम्न भूस्वामी/भूस्वामियों जो सम्पत्ति का/के पूर्ण स्वामी है/हैं जिसे आगे उल्लिखित किया गया है और निम्नलिखित अंशो में एतद्द्वारा वर्णित किया गया है, अर्थात</p>
                        ';

    $html .= '<p><span style="font-weight:bold">1) </span> ' . $owner_name . ' <span style="font-weight:bold">पति/पिता श्री</span> ' . $owner_father . ' <span style="font-weight:bold">अंश</span> ' . $ansh . '</p>';

    $html .= '<p style="font-weight:bold">प्रथम पक्ष (जिसे एतद्रपश्चात ’’भूस्वामी’’ कहा गया है) और;</p>
                <p>उत्तर प्रदेश के श्री राज्यपाल/राज्य सरकार के माध्यम से कार्य कर रहे-</p>
                <p style="font-weight:bold">बुन्देलखण्ड औद्योगिक विकास प्राधिकरण </p>
                <p style="font-weight:bold">द्वितीय पक्ष (जिसे एतद्रपश्चात ’’क्रय निकाय’’ कहा गया है) के मध्य एतद्द्वारा हस्ताक्षरित/निष्पादित किया गया है-</p>
                <p>चूंकि उल्लिखित पक्षकार भूमि के सापेक्ष देय दर तथा कुल भूमि मूल्य पर सहमत है/हैं जिसका विवरण अनुसूची में दिया गया है,
                    और चूंकि भूस्वामी अग्रेतर सहमत है/हैं कि अनुसूची में वर्णित भूबद्ध कोई बात या भूबद्ध किसी चीज से अस्थाई रूप से सम्बद्ध सभी बातें क्रय निकाय के पूर्व अनुमोदन से वापस ली जा सकेगी।
                    अतएव अब भूस्वामी और क्रय निकाय से एतद्द्वारा निम्न प्रकार सहमत होता/होते हैः-
                </p>
                <p>(1) यह कि क्रय निकाय इस समझौता पत्र के निष्पादन की तिथि से अधिकतम 12 माह के भीतर अनिवार्य अर्जन के बिना, कार्यवाही करने में सक्षम होगा।</p>
                <p>(2) यह कि यदि क्रय निकाय भूमि का तुरन्त कब्जा लेना आवश्यक समझता है तो वह/वे ऐसा करने का हकदार होगा/होंगे, भले ही इस पर फसल खड़ी हो, परन्तु यह कि अनुसूची में वर्णित ’’दर और कुल भूमि मूल्य’’ का भुगतान कर दिया हो।</p>
                <p>(3) यह कि यदि कुल भूमि में मूल्य मे भुगतान के पश्चात यह प्रकट होता है कि भूमिस्वामी इस समझौता पत्र में निष्पादित विक्रय विलेख के अनुसार प्रतिकर की सम्पूर्ण धनराशि का/के अन्यन्य रूप से हकदार नहीं है/हैं और क्रय निकाय की ओर से किसी अन्य व्यक्ति को किसी प्रतिकर का भुगतान करने की अपेक्षा की जाती है तो भूस्वामी द्वारा ऐसी धनराशि, जो क्रय निकाय द्वारा अवधारित की जाये, मांग किये जाने पर वापस कर देगा। और किसी अन्य व्यक्ति/व्यक्तियों द्वारा किसी दावे या प्रतिकर या उसके भाग के विरूद्व क्रय निकाय/राज्य सरकार को (संयुक्तः और पृथकतः) क्षतिपूर्ति करेगा और उठायी गयी किसी हानि या नुकसान की सभी कार्यवाहियों और दायित्वों के विरूद्व उसे/उनको भुगतान के कारण क्रय निकाय द्वारा उपगत किसी लागत प्रभार या क्रय की गयी धनराशि पर विरूद्व उसे/उनकों भुगतान के कारण क्रय निकाय द्वारा उपगत किसी लागत प्रभार या व्यय की गयी धनराशि पर प्रथम वर्ष 9 प्रतिशत की दर पर और पश्चातवर्ती वर्षों के लिए 15 प्रतिशत की दर पर व्याज भुगतान करेगा/करेगें।</p>
                <p>(4) यदि भूस्वामी पूर्ववर्ती पैरा में उल्लिखित धनराशि क्रय निकाय को वापस करने में असफल रहता है/रहते हैं। तो क्रय निकाय को कलेक्टर के माध्यम से उसे भू-राजस्व के बकाये के रूप में वसूल करने या ऐसी धनराशि को वसूली के लिए प्रवृत्त किसी विधि के अधीन कार्यवाही करने का/देने का पूरा अधिकार होगा।</p>
                <p>(5) यदि अनुसूची में वर्णित भूमि पर कोई सरकारी देय/अंश/प्रीमियम भूस्वामी द्वारा देय है या किसी वित्तीय संस्था का ऋण उक्त भूमि के विरूद्व वकाया है तो उस धनराशि को कुल भूमि मूल्य की धनराशि से कटौती करके शेष धनराशि का भुगतान भू-स्वामी को किया जायेगा।</p>
                <p>(6) क्रय निकाय और भू-स्वामी के मध्य हस्ताक्षरित इस समझौता पत्र के अनुमोदन के उपरान्त आवश्यक विक्रय विलेख का निष्पादन किया जाएगा, जिसके पंजीकरण/निबन्धन सम्बन्धी समस्त शुल्क, जिसमें स्टाम्प शुल्क भी सम्मिलित होता है, को क्रय निकाय द्वारा व्यय वहन किया जाएगा।</p>
                <p>(7) विक्रय विलेख के निष्पादन के दिनांक पर ही सम्बन्धित भू-स्वामी से अनुसूची-1 में वर्णित भूमि का कब्जा क्रय निकाय द्वारा प्राप्त किया जाता है।</p>
                <p>(8) क्रय निकाय के द्वारा निम्नलिखित आधारों पर इस समझौता पत्र को भू-स्वामी को 15 दिन का नोटिस देकर निरस्त किया जा सकेगाः-</p>
                <p>(क) यदि भूस्वामी ने समझौता पत्र को कपटपूर्ण व्यवहार करके सम्पादित कराया है,</p>
                <p>(ख) यदि भूस्वामी के द्वारा समझौता पत्र के किसी शर्त का उल्लंघन किया जाता है,</p>
                <p>(ग) यदि इस समझौता पत्र के निष्पादन के उपरान्त यह प्रकट होता है कि अनुसूची-1 में वर्णित भूमि का स्वामित्व भू-स्वामी में नहीं है। </p>
            </div>

            <div class="table-container">

                <div style="text-align:center;font-weight:bold">अनुसूची</div>
                <div style="width:100%"><div style="float: left;width:25%;">ग्राम </div><div style="float: left;width:25%;">परगना </div><div style="float: left;width:25%;">तहसील- झाँसी</div><div style="float: left;">जिला- झाँसी</div>
            <div style="clear:both"></div>
            </div>
                <table>
                    <caption></caption>
                    <tr>
                        <th rowspan="2">खाता सं0</th>
                        <th rowspan="2">खसरा सं0</th>
                        <th rowspan="2">क्षेत्रफल हे0 मे</th>
                        <th rowspan="2">भूमि का विवरण, यदि वह सर्वेक्षण संख्या का भाग हो (चारों सीमाओ और लगी हुई भूस्वामी का स्वामित्व प्रदर्शित करते हुए)</th>
                        <th rowspan="2">भूमि के कुल मूल्य के लिए निर्धारित दर (रू0 में)</th>
                        <th colspan="2">भूमि पर खड़ी फसल</th>
                    </tr>
                    <tr>
                        <th>विवरण</th>
                        <th>मूल्यांकन के अनुसार देय राशि (रू0 में)</th>
                    </tr>
                    ';
    $html .= '<tr>
                    <td>' . $khata_no . '</td>
                    <td>' . $gata_no . '</td>
                    <td>' . $gata_area . '</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            ';

    $html .= '</table>
                </div>

                <div class="table-container">
                    <table style="width: 100%;">
                        <caption></caption>
                        <tr>
                            <th colspan="2">भूबद्ध अन्य सम्पत्ति का विवरण</th>
                            <th rowspan="2">देय कुल मूल्य (योग कालम-7,8,9)</th>
                            <th rowspan="2">व्यक्ति/व्यक्तियों का/के नाम और पता जिनको देय हैं और उनका परिमाण विवरण</th>
                        </tr>
                        <tr>
                            <th>विवरण</th>
                            <th>मूल्यांकन के अनुसार देय राशि (रू0 में)</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div>

                <div style="width:100%;">
                    <div style="float:left;width:65%; ">भूस्वामी/ भूस्वामियों के हस्ताक्षर</div>
                    <div style="float:right">क्रय निकाय की ओर से अधिकृत अधिकारी हस्ताक्षर</div>
                    <div style="clear:both"></div>
                </div>
                <div>
                   <div>1-	</div>
                   <div style="width:100%"><div style="float: left;width:45%">2-</div> <div style="float:right">पूरा नाम</div></div>
                   <div style="clear:both"></div>
                   <div><div style="float: left;width:45%">3-</div> <div style="float:left">पद नाम</div></div>
                   <div style="clear:both"></div>
                </div>
                <div style="width:100%;">
                <div style="float:left;width:65%;">गवाह/अभिसाक्षी</div>
                    <div style="float:right"> गवाह/अभिसाक्षी</div>
                    <div style="clear:both"></div>
                </div>

            </div>
            </body>
        ';
    $data = array('status' => '1', 'message' => '', 'data' => $html);
    // send response to application
    print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    exit();
} else if (isset($_POST['action']) && $_POST['action'] == 'save_kashtkar') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $timestamp = time();
        $mobile = __fi($_POST['mobile']);
        $village_code = validateInteger($_POST['village_code']);
        $gata_no = __fi($_POST['gata_no']);
        $khata_no = __fi($_POST['khata_no']);
        $kashtkar = __fi(validateMaxLen($_POST['fname'], 100, 'Kahstkar Name'));
        $kashtkar_father = __fi(validateMaxLen($_POST['pname'], 100, 'Kashtkar Father'));
        $area = $_POST['area'] ? __fi(validateNumeric($_POST['area'], 'Area')) : 0;

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
        $insrt->bindParam(9, $mobile);
        $insrt->execute();

        $db_respose_data = array('owner_no' => $last_owner_no, 'owner_name' => $kashtkar, 'owner_father' => $kashtkar_father, 'gata_area' => $area, 'area' => $area, 'kashtkar' => $kashtkar . ' (रकबा: ' . $area . ' हेक्टेयर)', 'owner_no' => $last_owner_no, 'kasht_info' => encryptIt($last_owner_no . '@' . $area . '@' . $kashtkar . '@' . $kashtkar_father));

        // Make the changes to the database permanent
        commit($db, 'काश्तकर सफलतापूर्वक जोड़ा गया', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'save_grievance') {
    try {
        // Begin Transaction
        $db->beginTransaction();

        // check user input for valid data
        foreach ($_POST as $postValue) {
            check_user_input($postValue);
        }

        $timestamp = time();
        $mobile = __fi($_POST['mobile']);
        $village_code = validateInteger($_POST['village_code']);
        $gata_no = __fi($_POST['gata_no']);
        $khata_no = __fi($_POST['khata_no']);
        $owner_no = $_POST['owner_no'];
        $gata_area = $_POST['gata_area'];
        $owner_name = $_POST['owner_name'];
        $owner_father = $_POST['owner_father'];
        $type = $_POST['type'];

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

        $insrt = $db->prepare("INSERT INTO lm_kashtkar_grievances (VillageCode, GataNo, KhataNo, OwnerNo, owner_name, owner_father, Area, Grievance, Mobile, DateCreated) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
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
        $insrt->execute();
        $grievance_id = $db->lastInsertId();

        $lekhpal_query = $db->prepare("SELECT T2.ID, T2.Name, T2.Mobile, T2.FcmToken, T2.Medium, T2.OsType
                                        FROM lm_user_village_gata_mapping T1
                                        LEFT JOIN lm_users T2 ON T2.ID = T1.UserID
                                        WHERE T1.VillageCode = ?
                                        AND T1.GataNo = ?
                                        LIMIT 1
                                        ");
        $lekhpal_query->bindParam(1, $village_code);
        $lekhpal_query->bindParam(2, $gata_no);
        $lekhpal_query->execute();
        $lekhpal_name = '';
        $lekhpal_mobile = '';
        if ($lekhpal_query->rowCount()) {
            $lekhpal_query->setFetchMode(PDO::FETCH_ASSOC);
            $lekhpalInfo = $lekhpal_query->fetch();
            $lekhpal_id = $lekhpalInfo['ID'];
            $lekhpal_name = $lekhpalInfo['Name'];
            $lekhpal_mobile = $lekhpalInfo['Mobile'];
            $lekhpal_fcm = $lekhpalInfo['FcmToken'];
            $lekhpal_medium = $lekhpalInfo['Medium'];
            $lekhpal_os_type = $lekhpalInfo['OsType'];
        }

        $osd_query = $db->prepare("SELECT T2.ID, T2.Name, T2.Mobile
                                        FROM lm_user_village_mapping T1
                                        LEFT JOIN lm_users T2 ON T2.ID = T1.UserID
                                        WHERE T1.VillageCode = ?
                                        LIMIT 1
                                        ");
        $osd_query->bindParam(1, $village_code);
        $osd_query->execute();
        $osd_id = 0;
        $osd_name = '';
        $osd_mobile = '';
        if ($osd_query->rowCount()) {
            $osd_query->setFetchMode(PDO::FETCH_ASSOC);
            $osdInfo = $osd_query->fetch();
            $osd_name = $osdInfo['Name'];
            $osd_mobile = $osdInfo['Mobile'];
            $osd_id = $osdInfo['ID'];
        }

        if ($osd_id) {
            $row_data = array();

            $origin = 'kashtkar_grievance'; //set origin to idetntify source of action
            $type = 'kashtkar_grievance'; //set notification key for payload
            $priority = '1'; //set priority for for notification
            $row_data[] = array(
                'SenderID' => $mobile,
                'ReceiverID' => $osd_id,
                'Mobile' => $osd_mobile,
                'FcmToken' => '',
                'OsType' => '0',
                'Medium' => 'web',
                'Email' => '',
                'Attachment' => '',
                'Message' => 'New grievance submitted by kashtkar',
                'ID' => $grievance_id,
                'NotifyTo' => 'osd' //enter users, whom to send notification
            );
            // queue data
            $queue_params = queueData($db, $row_data, $origin, $type, $priority);

            // insert into queue table
            insert_into_queue($db, $queue_params);
        }

        $db_respose_data = array();
        if ($lekhpal_mobile && $osd_mobile == '') {
            $db_respose_data = array('info' => 'शिकायत के निस्तारण हेतु आपसे लेखपाल (' . $lekhpal_mobile . ') तथा OSD संपर्क करेगा');
        } else if ($lekhpal_mobile == '' && $osd_mobile) {
            $db_respose_data = array('info' => 'शिकायत के निस्तारण हेतु आपसे लेखपाल तथा OSD (' . $osd_mobile . ') संपर्क करेगा');
        } else if ($lekhpal_mobile && $osd_mobile) {
            $db_respose_data = array('info' => 'शिकायत के निस्तारण हेतु आपसे लेखपाल (' . $lekhpal_mobile . ') तथा OSD (' . $osd_mobile . ') संपर्क करेगा');
        } else {
            $db_respose_data = array('info' => 'शिकायत के निस्तारण हेतु आपसे लेखपाल तथा OSD संपर्क करेगा');
        }

        // Make the changes to the database permanent
        commit($db, 'शिकायत सफलतापूर्वक भेजी गई', $db_respose_data);
    } catch (\Exception $e) {
        if ($db->inTransaction()) {
            $db->rollback();
        }

        // return response
        $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($_POST) . ']';
        rollback($db, $e->getCode(), $log_error_msg);
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'get_kashtkar_info') {

    $village_code = $_POST['village_code'];
    $gata_no = $_POST['gata_no'];
    $khata_no = $_POST['khata_no'];
    $decrypt_data = decryptIt(myUrlEncode($_POST['kashtkar']));
    $explode_data = explode('@', $decrypt_data);
    $owner_no = $explode_data[0];
    $gata_area = $explode_data[1];
    $owner_name = $explode_data[2];
    $owner_father = $explode_data[3];

    //Creating JSON
    $data = array('status' => '1', 'message' => '', 'owner_no' => $owner_no, 'owner_name' => $owner_name, 'owner_father' => $owner_father, 'gata_area' => $gata_area);
    print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    exit();
}

//funtion generate otp
function generate_otp($mobile, $db, $os_type) {
    $timestamp = time();
    $sql_check_old_otp = $db->query("SELECT ID, OTP, OtpCreated, OtpUpdated
                                            FROM lm_login_otp
                                            WHERE Mobile = '" . $mobile . "'
                                            AND Used = '0'
                                            AND Expired = '0'
                                            AND OS = '" . $os_type . "'
                                            ");
    $sql_check_old_otp->setFetchMode(PDO::FETCH_ASSOC);
    $row_count = $sql_check_old_otp->rowCount();
    if ($row_count > 0) {
        while ($row = $sql_check_old_otp->fetch()) {
            $otp = $row['OTP'];
        }
        $update_otp = $db->prepare("UPDATE lm_login_otp SET OtpUpdated = ? WHERE OTP = ? AND Mobile = ?");
        $update_otp->bindParam(1, $timestamp);
        $update_otp->bindParam(2, $otp);
        $update_otp->bindParam(3, $mobile);
        $update_otp->execute();
        return $otp;
    } else {
        $otp = rand(1000, 9999);
        $sql_check_otp = $db->query("SELECT COUNT(*) AS Count
                                    FROM lm_login_otp
                                    WHERE Mobile = '" . $mobile . "'
                                    AND OTP = '" . $otp . "'
                                    AND Used = '0'
                                    AND Expired = '0'
                                    AND OS = '" . $os_type . "'
                                    ");
        $sql_check_otp->setFetchMode(PDO::FETCH_ASSOC);
        while ($row = $sql_check_otp->fetch()) {
            $row_check_otp = $row['Count'];
        }
        if ($row_check_otp > 0) {
            generate_otp($mobile, $db, $os_type);
        } else {
            $insert_otp = $db->prepare("INSERT INTO lm_login_otp (Mobile, OTP, OtpCreated, OtpUpdated, OS) VALUES ('" . $mobile . "', '" . $otp . "', '" . $timestamp . "', '" . $timestamp . "', '" . $os_type . "')");
            $insert_otp->execute();
            return $otp;
        }
    }
}
