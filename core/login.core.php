<?php

include_once "../config.php";

ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_lifetime', $session_cookie_lifespan);
ini_set('session.gc_maxlifetime', $garbage_max_lifespan);

session_start();
session_regenerate_id(true);

include_once "../dbcon/db_connect.php";
include_once "detect_device.core.php";
include_once "timezone.core.php";
include_once "../functions/common.function.php";
include_once '../vendor/autoload.php';

$aip = $_SERVER['REMOTE_ADDR'];
$agent = $_SERVER['HTTP_USER_AGENT'];
$user_system = Detect::systemInfo();
$user_browser = Detect::browser();

$userName = __fi(trim($_POST['username']));
$pass = __fi(trim($_POST['password']));
$offset = $_POST['offset'];
$dst = $_POST['dst'];
$userPassKeyVal = hash("sha512", $pass);
$timestamp = time();

if ($userName && $pass) {
    // connect to redis
    $check_redis = 1;//connectRedis($redis_host, $redis_port, $redis_timeout, $redis_password, 'login');

    if ($check_redis == 1) {
        try {
            $query = $db->prepare("SELECT T1.*
                                FROM lm_users T1
                                WHERE T1.UserName = ?
                                AND T1.CipherPassword = ?
                                AND T1.Active = ?
                                LIMIT 1
                            ");

            $query->bindParam(1, $userName);
            $query->bindParam(2, $userPassKeyVal);
            $query->bindValue(3, 1);
            $query->execute();
            $login_check = $query->rowCount();
            $query->setFetchMode(PDO::FETCH_ASSOC);

            // check if user exists or not
            if ($login_check == 0) {
                $data = array('status' => '-1', 'page' => 'The username or password entered is incorrect');
                print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
                exit();
            }

            $_SESSION['DistrictID'] = array();
            while ($row = $query->fetch()) {
                $timezone_name = Timezone::detect_timezone_id($offset, $dst);
                $_SESSION['user_timezone_name'] = $timezone_name;
                date_default_timezone_set($_SESSION['user_timezone_name']);

                /* store user basic info */
                $_SESSION['UserName'] = $row['Name'];
                $_SESSION['UserID'] = $row['ID'];
                $_SESSION['UserType'] = $row['UserType'];
                $_SESSION['csrftoken'] = uniqid();
                if ($row['UserType'] == '0' || $row['UserType'] == '2') {
                    $_SESSION['LandingPage'] = $landing_page;
                } else if ($row['UserType'] == '1') {
                    $landing_page = 'misdashboard';
                    $_SESSION['LandingPage'] = $landing_page;
                } else if ($row['UserType'] == '3') {
                    $landing_page = 'slaoreport';
                    $_SESSION['LandingPage'] = $landing_page;
                } else if ($row['UserType'] == '4') {
                    if ($_SESSION['UserID'] == '8') {
                        $landing_page = 'bankreport';
                    } else {
                        $landing_page = 'bankebasta';
                    }
                    $_SESSION['LandingPage'] = $landing_page;
                } else if ($row['UserType'] == '5') {
                    $landing_page = 'treasreport';
                    $_SESSION['LandingPage'] = $landing_page;
                } else if ($row['UserType'] == '6') {
                    $landing_page = 'reports';
                    $_SESSION['LandingPage'] = $landing_page;
                }
                $user_id = $row['ID'];

                /* insert last login activity */
                $insrt = $db->prepare("INSERT INTO lm_user_login_history (UserID, LastLogin, UserIP, UserOS, UserBrowser) VALUES (?, ?, ?, ?, ?)");
                $insrt->bindParam(1, $row['ID']);
                $insrt->bindValue(2, time());
                $insrt->bindValue(3, $_SERVER['REMOTE_ADDR']);
                $insrt->bindParam(4, $user_system['os']);
                $insrt->bindParam(5, $user_browser);
                $insrt->execute();

                /* end store user basic info */
                $_SESSION['CheckUser'] = hash("sha512", $user_id . $aip . $agent); // store user device info in session


                $session_details[] = array('UserID' => $user_id, 'SessionToken' => hash("sha512", $user_id . $aip . $agent), 'Time' => $timestamp);
                $token_file_name = hash("sha512", $user_id . $aip . $agent) . '.json';

                $fp = fopen(dirname(dirname(__FILE__)) . '/session_log/' . $token_file_name, 'w');
                fwrite($fp, json_encode($session_details));
                fclose($fp);
                $expiry_time = $timestamp + $cookie_ttl;
                $cookie_value = $user_id . '_' . $offset . '_' . $dst . '_' . $user_type;
                setcookie($cookie_name, $cookie_value, [
                    'expires' => $expiry_time,
                    'path' => '/',
                    'domain' => $cookie_domain,
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'None'
                ]);

                $token = encryptIt($cookie_value);

                $updt = $db->prepare("UPDATE lm_users SET Token = ? WHERE ID = ?");
                $updt->bindParam(1, $token);
                $updt->bindParam(2, $user_id);
                $updt->execute();

                $data = array('status' => '1', 'page' => $landing_page);
                print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
            }
        } catch (\Exception $e) {
            // return response
            $log_error_msg = '==> [' . date('d-m-Y h:i A', time()) . '] [Error Code: ' . $e->getCode() . '] [Path: ' . $e->getFile() . '] [Line: ' . $e->getLine() . '] [Message: ' . $e->getMessage() . '] [Input: ' . json_encode($data) . ']';
            rollback($db, $e->getCode(), $log_error_msg);
        }
    }
}