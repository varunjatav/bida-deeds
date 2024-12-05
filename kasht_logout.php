<?php

ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);

include_once "config.php";
ini_set('session.cookie_lifetime', $session_cookie_lifespan);
ini_set('session.gc_maxlifetime', $garbage_max_lifespan);

session_start();
session_regenerate_id(true);

// expire session due to inactivity
if (isset($_POST['expireTime'])) {
    if (isset($_SESSION['SessionStartTime'])) {
        $InActiveTime = time() - $_SESSION['SessionStartTime'];
        if ($InActiveTime >= $TimeOutSeconds) {
            unset($_COOKIE[$kasht_cookie_name]);
            setcookie($kasht_cookie_name, "", [
                'expires' => -1,
                'path' => '/',
                'domain' => $cookie_domain,
                'secure' => true,
                'httponly' => true,
                'samesite' => 'None'
            ]);
            $session_file = 'session_log/' . $_SESSION['CheckUser'] . '.json';
            unlink($session_file);
            $_SESSION = array();
            session_unset();
            session_destroy();
            $data = array('status' => '1', 'page' => $kasht_main_path);
            print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
            exit;
        }
        $_SESSION['SessionStartTime'] = time();
    }
}

// logout only if valid
else if (!isset($_POST['expireTime'])) {
    unset($_COOKIE[$kasht_cookie_name]);
    setcookie($kasht_cookie_name, "", [
        'expires' => -1,
        'path' => '/',
        'domain' => $cookie_domain,
        'secure' => true,
        'httponly' => true,
        'samesite' => 'None'
    ]);
    $session_file = 'session_log/' . $_SESSION['CheckUser'] . '.json';
    unlink($session_file);
    $_SESSION = array();
    session_unset();
    session_destroy();
    $data = array('status' => '1', 'page' => $kasht_main_path);
    print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    exit;
}