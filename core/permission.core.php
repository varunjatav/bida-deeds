<?php

// get user language
$lang_file = getLanguage($_SESSION['Lng']);
$explodeUrl = explode("?", $_SERVER['REQUEST_URI']);
$urlStr = explode("/", $explodeUrl[0]);
$urlStr = end($urlStr);
$_SESSION['SessionStartTime'] = time();
$user_type = $_SESSION['UserType'];

if ($user_type == '0' && $user_type == '1') {
    header('Location:dashboard');
} else {
    
}