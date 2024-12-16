<?php

// count items in array
function count_($array) {
    return is_array($array) ? count($array) : 0;
}

// FUNCTION TO GENERATE RANDOM ALPHA NUMEIRIC STRING
function random_string($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));
    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }
    return $key;
}

// sort result array using key
function aasort($array, $key) {
    $sorter = array();
    $ret = array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii] = $va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii] = $array[$ii];
    }
    $array = $ret;
    return $array;
}

function encryptIt($q) {
    global $ciphering;
    global $cipher_options;
    global $encryption_iv;
    global $encryption_key;

    // Using OpenSSl Encryption method
    $iv_length = openssl_cipher_iv_length($ciphering);

    // Using openssl_encrypt() function to encrypt the data
    $qEncoded = openssl_encrypt($q, $ciphering, $encryption_key, $cipher_options, $encryption_iv);
    return $qEncoded;
}

function decryptIt($qq) {
    global $ciphering;
    global $cipher_options;
    global $encryption_iv;
    global $encryption_key;

    // Using openssl_decrypt() function to decrypt the data
    $qDecoded = openssl_decrypt($qq, $ciphering, $encryption_key, $cipher_options, $encryption_iv);
    return $qDecoded;
}

// filter inputs for XSS attacks
function __fi($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// get file extension
function getExtension($str) {
    $i = strrpos($str, ".");
    if (!$i) {
        return "";
    }
    $l = strlen($str) - $i;
    $ext = substr($str, $i + 1, $l);
    return $ext;
}

function time_elapsed_string($ptime) {
    $etime = time() - $ptime;
    if ($etime < 1) {
        return '0 seconds';
    }
    $a = array(365 * 24 * 60 * 60 => 'year',
        30 * 24 * 60 * 60 => 'month',
        24 * 60 * 60 => 'day',
        60 * 60 => 'hour',
        60 => 'minute',
        1 => 'second'
    );
    $a_plural = array('year' => 'years',
        'month' => 'months',
        'day' => 'days',
        'hour' => 'hours',
        'minute' => 'minutes',
        'second' => 'seconds'
    );
    foreach ($a as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
        }
    }
}

// commit database transactions
function commit($db, $msg, $success_array) {
    // Make the changes to the database permanent
    $db->commit();
    // return response
    $db_respose_data = json_encode(array('status' => '1', 'message' => $msg, 'success_array' => $success_array));
    print_r($db_respose_data);
    exit();
}

// rollback database transactions
function rollback($db, $err_code, $msg) {
    // Rollback all transaction in database
    if ($db->inTransaction()) {
        $db->rollback();
    }
    // return response
    $logfile = dirname(dirname(__FILE__)) . "/logs/error_logs/error_log.txt";
    $myfile = fopen($logfile, "a+") or die("Unable to open file! ");
    fwrite($myfile, $msg . "\n\n");
    fclose($myfile);

    if ($err_code == '42S22') {
        $err_msg = 'Syntax Error.';
    } else if ($err_code == '42000') {
        $err_msg = 'Syntax Error.';
    } else {
        $err_msg = 'Something wrong with input data.';
    }

    $db_respose_data = json_encode(array('status' => '0', 'message' => $err_msg));
    print_r($db_respose_data);
    exit();
}

// generate unique id
function generate_unique_id($db, $table_name, $column_name, $type, $length_of_string) {
    switch ($type) {
        case 1:
            $str_result = '0123456789';
            break;
        case 2:
            $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            break;
        case 3:
            $str_result = 'abcdefghijklmnopqrstuvwxyz';
            break;
        case 4:
            $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            break;
        case 5:
            $str_result = '0123456789abcdefghijklmnopqrstuvwxyz';
            break;
        default :
            $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    }
    // Shuffle the $str_result and returns substring
    // of specified length
    $uniq_id = substr(str_shuffle($str_result), 0, $length_of_string);
    $sqlCheck = $db->prepare("SELECT COUNT(*)
                                FROM $table_name T1
                                WHERE T1.$column_name = ?
                                ");
    $sqlCheck->bindParam(1, $uniq_id);
    $sqlCheck->execute();
    $number_of_rows = $sqlCheck->fetchColumn();
    if ($number_of_rows > 0) {
        return generate_unique_id($db, $table_name, $column_name, $type, $length_of_string);
    } else {
        return $uniq_id;
    }
}

// recursive function to delete null/empty values
function removeEmptyValues(&$array) {
    foreach ($array as $key => &$value) {
        if (is_array($value)) {
            $value = removeEmptyValues($value);
        }
        if (empty($value)) {
            unset($array[$key]);
        }
    }
    return $array;
}

// calculate duration between two timestamp
function duration($start, $end) {
    $start = date('g:i A', $start);
    $end = date('g:i A', $end);
    $datetime1 = new DateTime($start);
    $datetime2 = new DateTime($end);
    $intervals = $datetime1->diff($datetime2);
    if ($intervals->format('%h') == 0) {
        $duration = $intervals->format('%i Minutes');
    } else {
        $duration = $intervals->format('%h Hours %i Minutes');
    }
    return $duration;
}

function check_user_input($str) {
    $_never_allowed_str = array(
        'document.cookie',
        'document.write',
        '.parentNode',
        '.innerHTML',
        'window.location',
        '-moz-binding',
        '<!--',
        '-->',
        '<![CDATA[',
        '<comment>'
    );
    if (!is_array($str)) {
        foreach ($_never_allowed_str as $key => $value) {
            if (strpos($str, $value) !== false) {
                $respose_data = json_encode(array('status' => '-1', 'message' => 'Invalid data: ' . $str . ' not allowed.'));
                print_r($respose_data);
                exit();
            }
        }
    }
}

function myUrlEncode($string) {
    $entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
    $replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
    return str_replace($entities, $replacements, urlencode($string));
}

function aadharValidation($aadharNumber) {
    /* ...multiplication table... */
    $multiplicationTable = [
        [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
        [1, 2, 3, 4, 0, 6, 7, 8, 9, 5],
        [2, 3, 4, 0, 1, 7, 8, 9, 5, 6],
        [3, 4, 0, 1, 2, 8, 9, 5, 6, 7],
        [4, 0, 1, 2, 3, 9, 5, 6, 7, 8],
        [5, 9, 8, 7, 6, 0, 4, 3, 2, 1],
        [6, 5, 9, 8, 7, 1, 0, 4, 3, 2],
        [7, 6, 5, 9, 8, 2, 1, 0, 4, 3],
        [8, 7, 6, 5, 9, 3, 2, 1, 0, 4],
        [9, 8, 7, 6, 5, 4, 3, 2, 1, 0],
    ];
    /* ...permutation table... */
    $permutationTable = [
        [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
        [1, 5, 7, 6, 2, 8, 3, 0, 9, 4],
        [5, 8, 0, 3, 7, 9, 6, 1, 4, 2],
        [8, 9, 1, 6, 0, 4, 3, 5, 2, 7],
        [9, 4, 5, 3, 1, 2, 6, 8, 7, 0],
        [4, 2, 8, 6, 5, 7, 3, 9, 0, 1],
        [2, 7, 9, 3, 8, 0, 6, 4, 1, 5],
        [7, 0, 4, 6, 9, 1, 3, 2, 5, 8],
    ];
    /* ...split aadhar number... */
    $aadharNumberArr = str_split($aadharNumber);
    /* ...check length of aadhar number... */
    if (count($aadharNumberArr) == 12) {
        /* ...reverse aadhar number... */
        $aadharNumberArrRev = array_reverse($aadharNumberArr);
        $tableIndex = 0;
        /* ...validate... */
        foreach ($aadharNumberArrRev as $aadharNumberArrKey => $aadharNumberDetail) {
            $tableIndex = $multiplicationTable[$tableIndex][$permutationTable[($aadharNumberArrKey % 8)][$aadharNumberDetail]];
        }
        return ($tableIndex === 0);
    }
    return false;
}

function panValidation($pancard) {
    $pattern = '/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/';
    $result = preg_match($pattern, $pancard);
    if ($result) {
        $findme = ucfirst(substr($pancard, 3, 1));
        $mystring = 'CPHFATBLJG';
        $pos = strpos($mystring, $findme);
        if ($pos === false) {
            $msg = 0;
        } else {
            $msg = 1;
        }
    } else {
        $msg = 0;
    }
    return $msg;
}

function secondsToTime($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a') == 0 ? $dtF->diff($dtT)->format('%h hours') : $dtF->diff($dtT)->format('%a days, %h hours');
}

function getDatesFromRange($start, $end, $format = 'd-m-Y') {
    // Declare an empty array
    $array = array();
    // Variable that store the date interval
    // of period 1 day
    $interval = new DateInterval('P1D');
    $realEnd = new DateTime($end);
    $realEnd->add($interval);
    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);
    // Use loop to store date into array
    foreach ($period as $date) {
        $array[] = $date->format($format);
    }
    // Return the array elements
    return $array;
}

//queue notification size
function blockSize($queue_size) {
    if ($queue_size >= 1 && $queue_size < 500) {
        $block_size = 100;
    } else {
        $block_size = 200;
    }
    return $block_size;
}

// convert timer to seconds
function time2sec($time) {
    $durations = array_reverse(explode(':', $time));
    $second = array_shift($durations);
    foreach ($durations as $duration) {
        $second += (60 * $duration);
    }
    return $second;
}

function conv_pdf_var($string) {
    return html_entity_decode(iconv("UTF-8", "CP1252//IGNORE", $string), ENT_QUOTES);
}

function validateYYYYMMDD($date, $field = NULL) {
    $date_pattern = '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/';

    if (preg_match($date_pattern, $date)) {
        return $date;
    } else {
        $data = array('status' => '-1', 'message' => 'Invalid date format(YYY-MM-DD) in ' . $field);
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateDDMMYYYY($date, $field = NULL) {
    $date_pattern = '/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/';

    if (preg_match($date_pattern, $date)) {
        return $date;
    } else {
        $data = array('status' => '-1', 'message' => 'Invalid date format(DD-MM-YYYY) in ' . $field);
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateEmail($email) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return $email;
    } else {
        $data = array('status' => '-1', 'message' => 'Invalid email address');
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateAlphabet($string, $field = NULL) {
    $pattern = '/^[a-zA-Z.\s]+$/';

    if (preg_match($pattern, $string)) {
        return $string;
    } else {
        $data = array('status' => '-1', 'message' => 'Only alphabets are allowed in ' . $field);
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateNumeric($string, $field = NULL) {

    if (is_numeric($string)) {
        return $string;
    } else {
        $data = array('status' => '-1', 'message' => 'Only numerics are allowed in ' . $field);
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateInteger($string, $field = NULL) {
    $pattern = '/^[0-9]+$/';

    if (preg_match($pattern, $string)) {
        return $string;
    } else {
        $data = array('status' => '-1', 'message' => 'Only integers allowed in ' . $field);
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateAlphaNum($string, $field = NULL) {
    $pattern = '/[a-zA-Z0-9 ]$/';
    if (preg_match($pattern, $string)) {
        return $string;
    } else {
        $data = array('status' => '-1', 'message' => 'Only alphanumerics allowed in ' . $field);
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateDecimalPlace($string, $upto, $field = NULL) {
    $pattern = "/(\d\.\d{" . $upto . "})(?!\d)/";
    if (preg_match($pattern, $string)) {
        return $string;
    } else {
        $data = array('status' => '-1', 'message' => 'Only ' . $upto . ' digit decimal allowed in ' . $field);
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateDecimalValue($string, $upto, $field = NULL) {
    $pattern = "#^\d+(?:\.\d{1," . $upto . "})?$#";
    if (preg_match($pattern, $string)) {
        return $string;
    } else {
        $data = array('status' => '-1', 'message' => 'Only decimal value allowed upto ' . $upto . ' in ' . $field);
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateMaxLen($string, $len, $field = NULL) {
    $length = strlen($string);
    if ($length <= $len) {
        return $string;
    } else {
        $data = array('status' => '-1', 'message' => 'Max length should be ' . $len . ' in ' . $field);
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateMinLen($string, $len, $field = NULL) {
    $length = strlen($string);
    if ($length >= $len) {
        return $string;
    } else {
        $data = array('status' => '-1', 'message' => 'Min length should be ' . $len . ' in ' . $field);
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateMinMaxLen($string, $min, $max, $field = NULL) {
    $length = strlen($string);
    if ($length > $max || $length < $min) {
        $data = array('status' => '-1', 'message' => 'Length should be between ' . $min . ' and ' . $max . ' in ' . $field);
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    } else {
        return $string;
    }
}

function validateLatitude($string) {
    if (preg_match('/^(\+|-)?(?:90(?:(?:\.0{1,15})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,15})?))$/', $string)) {
        return $string;
    } else {
        $data = array('status' => '-1', 'message' => 'Invalid Latitude');
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateLongitude($string) {
    if (preg_match('/^(\+|-)?(?:180(?:(?:\.0{1,15})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,15})?))$/', $string)) {
        return $string;
    } else {
        $data = array('status' => '-1', 'message' => 'Invalid Longitude');
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateMobile($string) {
    $pattern = "/^[6-9][0-9]{9}$/";
    if (preg_match($pattern, $string) !== 1 || strlen($string) != 10) {
        $data = array('status' => '-1', 'message' => 'Invalid mobile number');
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    } else {
        return $string;
    }
}

function validateUrl($string) {
    if (filter_var($string, FILTER_VALIDATE_URL) !== false) {
        return $string;
    } else {
        $data = array('status' => '-1', 'message' => 'Invalid Url');
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateGender($string) {
    $pattern = array('male', 'female', 'other');
    if (in_array(strtolower($string), $pattern)) {
        return $string;
    } else {
        $data = array('status' => '-1', 'message' => 'Invalid gender');
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateComment($string) {
    
}

function validateMaxValue($string, $compval, $field = NULL) {
    if ($string > $compval) {
        $data = array('status' => '-1', 'message' => 'Maximum value should be ' . $compval . ' in ' . $field);
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
    return $string;
}

function validateMinValue($string, $compval, $field = NULL) {
    if ($string < $compval) {
        $data = array('status' => '-1', 'message' => 'Minimum value should be ' . $compval . ' in ' . $field);
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
    return $string;
}

function fieldRequired($string, $field = NULL) {
    if (strlen(trim($string)) == 0) {
        $data = array('status' => '-1', 'message' => $field . ' field is mandatory.');
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
    return $string;
}

function generate_unique_string($type, $length_of_string) {
    switch ($type) {
        case 1:
            $str_result = '0123456789';
            break;
        case 2:
            $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            break;
        case 3:
            $str_result = 'abcdefghijklmnopqrstuvwxyz';
            break;
        case 4:
            $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            break;
        case 5:
            $str_result = '0123456789abcdefghijklmnopqrstuvwxyz';
            break;
        default :
            $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    }
    // Shuffle the $str_result and returns substring
    // of specified length
    $uniq_id = substr(str_shuffle($str_result), 0, $length_of_string);

    return $uniq_id;
}

function compareDates($sdate, $edate) {
    if ($edate > $sdate) {
        return true;
    } else {
        return false;
    }
}

function validate_attachments($source, $allowed_ext) {
    // check for valid attachments
    $ab = 0;
    $check_attachments = 0;
    foreach ($source['tmp_name'] as $nameFile) {
        if (is_uploaded_file($source['tmp_name'][$ab])) {
            $name = $source['name'][$ab];
            $tmp = explode('.', $name);
            $file_extension = end($tmp);
            $ext = strtolower( $file_extension);
            // if not valid image
            if (!in_array($ext, $allowed_ext)) {
                $check_attachments++;
                $data = array('status' => '-1', 'message' => 'Some problem with attachments.');
                print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
                exit();
            }
            $ab++;
        }
    }
    return true;
}

function validate_attachments_single($source, $allowed_ext) {
    // check for valid attachments
    $ab = 0;
    $check_attachments = 0;
  
        if (is_uploaded_file($source['tmp_name'][$ab])) {
            $name = $source['name'][$ab];
            $tmp = explode('.', $name);
            $file_extension = end($tmp);
            $ext = strtolower( $file_extension);
            // if not valid image
            if (!in_array($ext, $allowed_ext)) {
                $check_attachments++;
                $data = array('status' => '-1', 'message' => 'Some problem with attachments.');
                print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
                exit();
            }
            $ab++;
        }
  
    return true;
}

function upload_attachments($source, $target_dir, $max_size, $allowed_ext, $identifier, $user_id, $newwidth, $newheight, $compress_factor) {
    // copy attachments to folder
    $a = 0;
    $imageArray = array();
    foreach ($source['tmp_name'] as $nameFile) {
        if (is_uploaded_file($source['tmp_name'][$a])) {
            // save attached file
            $uploadedfile = $source['tmp_name'][$a];

            $name = $source['name'][$a];
            $ext = strtolower(end(explode('.', $name)));
            $size = filesize($source['tmp_name'][$a]);

            // rename image
            $name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $name);
            $rand_1 = rand(9999, 9999999);
            $rand_2 = rand(9999999, 9999999999);
            $rand_3 = rand();
            $actual_image_name = strtolower(str_replace(' ', '', $identifier . '_' . $size . '_' . $user_id . '_' . time() . '_' . $rand_1 . '_' . $rand_2 . '_' . $rand_3 . "." . $ext));

            if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
                if ($size > $max_size) {
                    $imgInfo = getimagesize($uploadedfile);
                    list($width, $height) = $imgInfo;
                    $mime = $imgInfo['mime'];
                    if ($mime == 'image/jpeg') {
                        $src = imagecreatefromjpeg($uploadedfile);
                    } else if ($mime == 'image/png') {
                        $src = imagecreatefrompng($uploadedfile);
                    } else {
                        $src = imagecreatefromjpeg($uploadedfile);
                    }

                    //try max width first...
                    $ratio = $newwidth / $width;
                    $new_w = $newwidth;
                    $new_h = $height * $ratio;

                    //if that didn't work
                    if ($new_h > $newheight) {
                        $ratio = $newheight / $height;
                        $new_h = $newheight;
                        $new_w = $width * $ratio;
                    }

                    $tmp = imagecreatetruecolor($new_w, $new_h);
                    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $new_w, $new_h, $width, $height);
                    $filename = $target_dir . $actual_image_name;
                    imagejpeg($tmp, $filename, $compress_factor);
                    imagedestroy($src);
                    imagedestroy($tmp);
                } else {
                    move_uploaded_file($uploadedfile, $target_dir . $actual_image_name);
                }
            } else {
                move_uploaded_file($uploadedfile, $target_dir . $actual_image_name);
            }
            $a++;
            $imageArray[] = $actual_image_name;
        }
    }
    return $imageArray;
}

// convert size if size in bytes
function convert_bytes_readable($size) {
    //conert size in readable format
    if ($size > 1048576) {
        $converted_size = number_format(($size / 1048576), 2) . ' MB';
    } else if ($size > 1024 && $size <= 1048576) {
        $converted_size = number_format(($size / 1024), 2) . ' KB';
    } else {
        $converted_size = $size . ' Bytes';
    }

    return $converted_size;
}

function convertNumberToWords(float $number) {
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number] . '' . $digits[$counter] . $plural . '' . $hundred : $words[floor($number / 10) * 10] . '' . $words[$number % 10] . '' . $digits[$counter] . $plural . '' . $hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . "" . $words[$decimal % 10]) . '' : '';
    return ($Rupees ? $Rupees . '' : '') . $paise;
}

function getAgeByTimestamp($dob) {
    $age = array();
    $sdate = date('Y-m-d', $dob);
    $edate = date('Y-m-d', time());
    $date_diff = abs(strtotime($edate) - strtotime($sdate));
    $years = floor($date_diff / (365 * 60 * 60 * 24));
    $months = floor(($date_diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
    $days = floor(($date_diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

    $age = array('year' => $years, 'month' => $months, 'day' => $days == 0 && $months == 0 && $years == 0 ? 1 : $days);

    return $age;
}

function format_rupees($amount) {
    return '₹ ' . preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", round($amount, 2));
}

function format_number($amount) {
    return preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", round($amount, 2));
}

function convert_rupee($amount) {
    $length = strlen($amount);
    if ($length >= 6 && $length <= 7) {
        $converted_amount = format_rupees(round($amount / 100000, 2)) . ' Lac(s)';
    } else if ($length >= 8) {
        $converted_amount = format_rupees(round($amount / 10000000, 2)) . ' Cr';
    } else if ($length >= 4 && $length <= 5) {
        $converted_amount = format_rupees(round($amount / 1000, 2)) . ' K';
    } else {
        $converted_amount = 0;
    }
    return $converted_amount;
}

function convert_rupee_roundoff($amount) {
    $length = strlen($amount);
    if ($length >= 6 && $length <= 7) {
        $converted_amount = format_rupees(round($amount / 100000)) . ' Lac(s)';
    } else if ($length >= 8) {
        $converted_amount = format_rupees(round($amount / 10000000)) . ' Cr';
    } else if ($length >= 4 && $length <= 5) {
        $converted_amount = format_rupees(round($amount / 1000)) . ' K';
    } else {
        $converted_amount = 0;
    }
    return $converted_amount;
}

function password_generate($n, $l, $s) {
    $numbers = '1234567890';
    $letters = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
    $special = '-!@#';
    return substr(str_shuffle($numbers), 0, $n) . substr(str_shuffle($letters), 0, $l) . substr(str_shuffle($special), 0, $s);
}

function getAddressFromLatLong($lat, $long, $gmaps_geocoding_api_key) {
    $geocode = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&sensor=false&key=" . $gmaps_geocoding_api_key;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $geocode);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $output = json_decode($response);
    $dataarray = get_object_vars($output);
    if ($dataarray['status'] != 'ZERO_RESULTS' && $dataarray['status'] != 'INVALID_REQUEST') {
        if (isset($dataarray['results'][0]->formatted_address)) {

            $address = $dataarray['results'][0]->formatted_address;
        } else {
            $address = 'Not Found';
        }
    } else {
        $address = 'Not Found';
    }
    return $address;
}

function getLocationFromLatLong($lat, $long, $gmaps_geocoding_api_key) {

    $geocode = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&sensor=false&key=" . $gmaps_geocoding_api_key;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $geocode);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $output = json_decode($response);
    $dataarray = get_object_vars($output);
    $area_array = array();
    $zip = '';
    $area = '';
    $block = '';
    $road = '';
    $address = 'Not Found';
    if ($dataarray['status'] == 'OK') {

        foreach ($dataarray['results'][0]->address_components as $adr_node) {
            if ($adr_node->types[0] == 'postal_code') {
                $zip = $adr_node->long_name;
            }
        }
        $road = $dataarray['results'][0]->address_components[1]->long_name;
        $block = $dataarray['results'][0]->address_components[1]->long_name;
        $area = $dataarray['results'][0]->address_components[1]->long_name;
        $address = $dataarray['results'][0]->formatted_address;
    }

    $area_array = array('area' => $area, 'block' => $block, 'road' => $road, 'zip' => $zip, 'location' => $address);
    return $area_array;
}

// chek all error
function checkAllErrors() {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

function user_log($msg) {
    // return response
    $logfile = dirname(dirname(__FILE__)) . "/logs/history_logs/" . date('Y') . "_history_log.txt";
    $myfile = fopen($logfile, "a+") or die("Unable to open file! ");
    fwrite($myfile, $msg . "\n\n");
    fclose($myfile);
}

function columnFromIndex($number) {
    if ($number === 0) return "A";
    $name = '';
    while ($number > 0) {
        $name = chr(65 + $number % 26) . $name;
        $number = intval($number / 26) - 1;
        if ($number === 0) {
            $name = "A" . $name;
            break;
        }
    }
    return $name;
}

// languages
function getLanguage($lang = 'en') {

    switch ($lang) {
        case 'en':
            //English
            $lang_file = 'lang.en.php';
            break;
        case 'hi':
            //Hindi
            $lang_file = 'lang.hi.php';
            break;
        // Default English
        default:
            $lang_file = 'lang.en.php';
    }
    return $lang_file;
}

function connectRedis($redis_host, $redis_port, $redis_timeout, $redis_password, $api_file_name) {

    global $redis_client_total_api_ttl;
    global $redis_client_total_api_hit_count;
    global $redis_client_each_api_ttl;
    global $redis_client_api_hit_count;
    // Redis configuration
    $vm = array(
        'host' => $redis_host,
        'port' => $redis_port,
        'timeout' => $redis_timeout // (expressed in seconds) used to connect to a Redis server after which an exception is thrown.
    );

    // start redis client
    $redis = new Predis\Client($vm);
    try {
        $redis->auth($redis_password);
        //   echo $redis->ping();
        $redis_each_api_access_key_ttl = 0;
        $redis_total_api_access_key_ttl = 0;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $client_ip = $_SERVER['REMOTE_ADDR'];
            $client_file_access_key = $client_ip . '_' . $api_file_name;

            // get redis counter for each key, 0 default & increment every hit
            $client_total_api_hit_count = $redis->incr($client_ip);
            $client_each_api_hit_count = $redis->incr($client_file_access_key);

            if ($client_total_api_hit_count == 1) {
                $redis->expire($client_ip, $redis_client_total_api_ttl);
            }

            if ($client_each_api_hit_count == 1) {
                $redis->expire($client_file_access_key, $redis_client_each_api_ttl);
            }

            if ($client_total_api_hit_count < $redis_client_total_api_hit_count) {
                if ($client_each_api_hit_count < $redis_client_api_hit_count) {
                    return 1;
                } else {
                    $redis_each_api_access_key_ttl = $redis->ttl($client_file_access_key);
                    //printError('Oops... that was too fast.');
                    return 'Oops... that was too fast. Please try again.';
                }
            } else {
                $redis_total_api_access_key_ttl = $redis->ttl($client_ip);
                //printError('API limit expired. Try again in ' . $redis_total_api_access_key_ttl . ' seconds.');
                return 'Limit expired. Try again in ' . $redis_total_api_access_key_ttl . ' seconds.';
            }
        }
    } catch (Exception $e) {
        //echo ' LOG that redis is down : ' . $e->getMessage();
        //printError($e->getMessage());
        return $e->getMessage();
    }
}

function twod_array_sum_count_values($input_array, $first_key, $second_key) {
    $result = array_reduce(
            $input_array,
            function (array $carry, array $key_array) use ($first_key, $second_key): array {
                $prev = $carry[$key_array[$first_key]][$second_key] ?? 0;
                $carry[$key_array[$first_key]] = $key_array;
                $carry[$key_array[$first_key]][$second_key] += $prev;
                return $carry;
            },
            []
    );
    return $result;
}

function getAllDates($startingDate, $endingDate, $format) {
    $datesArray = [];
    $startingDate = strtotime($startingDate);
    $endingDate = strtotime($endingDate);

    for ($currentDate = $startingDate; $currentDate <= $endingDate; $currentDate += (86400)) {
        $date = date($format, $currentDate);
        $datesArray[] = $date;
    }

    return $datesArray;
}

function get_days_between_dates($start_date, $end_date) {
    $now = $end_date ? $end_date : time();
    $your_date = strtotime($start_date);
    $datediff = $now - $your_date;
    return round($datediff / (60 * 60 * 24));
}

function get_months_between_dates($start_date, $end_date) {
    $date1 = $start_date;
    $date2 = $end_date ? $end_date : date('Y-m-d', time());

    $ts1 = strtotime($date1);
    $ts2 = strtotime($date2);

    $year1 = date('Y', $ts1);
    $year2 = date('Y', $ts2);

    $month1 = date('m', $ts1);
    $month2 = date('m', $ts2);

    $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
    return $diff + 1;
}

function get_weeks_between_dates($date1, $date2) {
    if ($date1 > $date2) return get_weeks_between_dates($date2, $date1);
    $first = DateTime::createFromFormat('m-d-Y', $date1);
    $second = DateTime::createFromFormat('m-d-Y', $date2);
    return floor($first->diff($second)->days / 7);
}


function upload_chunks_attachments($source, $target_dir, $max_size, $allowed_ext, $identifier, $user_id, $newwidth, $newheight, $compress_factor) {
    $a = 0;
    $imageArray = array();

    foreach ($source['tmp_name'] as $nameFile) {
        if (is_uploaded_file($source['tmp_name'][$a])) {
            $uploadedfile = $source['tmp_name'][$a];
            $name = $source['name'][$a];
            
            // Use a variable to store the result of explode
            $nameParts = explode('.', $name);
            $ext = strtolower(end($nameParts));
            $size = filesize($source['tmp_name'][$a]);

            // Rename image
            $name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $name);

            // Check if the file type is allowed
            if (!in_array($ext, $allowed_ext)) {
                // Return response
                return json_encode(array('status' => '-1', 'message' => 'Attached file type not allowed.'));
            }

            // Rename image
            $rand_1 = rand(9999, 9999999);
            $rand_2 = rand(9999999, 9999999999);
            $rand_3 = rand();
            $actual_image_name = strtolower(str_replace(' ', '', $identifier . '_' . $size . '_' . $user_id . '_' . time() . '_' . $rand_1 . '_' . $rand_2 . '_' . $rand_3 . "." . $ext));

            if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
                if ($size > $max_size) {
                    $imgInfo = getimagesize($uploadedfile);
                    list($width, $height) = $imgInfo;
                    $mime = $imgInfo['mime'];
                    if ($mime == 'image/jpeg') {
                        $src = imagecreatefromjpeg($uploadedfile);
                    } else if ($mime == 'image/png') {
                        $src = imagecreatefrompng($uploadedfile);
                    } else {
                        $src = imagecreatefromjpeg($uploadedfile);
                    }

                    // Resize image
                    $ratio = $newwidth / $width;
                    $new_w = (int) $newwidth;
                    $new_h = (int)$height * $ratio;
                    if ($new_h > $newheight) {
                        $ratio = $newheight / $height;
                        $new_h = (int)$newheight;
                        $new_w = (int)($width * $ratio);
                    }

                    $tmp = imagecreatetruecolor($new_w, $new_h);
                    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $new_w, $new_h, $width, $height);
                    $filename = $target_dir . $actual_image_name;
                    imagejpeg($tmp, $filename, $compress_factor);
                    imagedestroy($src);
                    imagedestroy($tmp);
                } else {
                    move_uploaded_file($uploadedfile, $target_dir . $actual_image_name);
                }
            } else {
                // Process and move the file if not an image
                $target_file = $target_dir . $actual_image_name;

                // Upload file in chunks (optional, can be omitted if not needed)
                $chunk_size = 1024; // Chunk in bytes
                $upload_start = 0;
                $handle = fopen($uploadedfile, "rb");
                $fp = fopen($target_file, 'w');

                while ($upload_start < $size) {
                    $contents = fread($handle, $chunk_size);
                    fwrite($fp, $contents);
                    $upload_start += strlen($contents);
                    fseek($handle, $upload_start);
                }

                fclose($handle);
                fclose($fp);
                unlink($uploadedfile);
            }

            $a++;
            $imageArray[] = $actual_image_name;
        }
    }
    return $imageArray;
}



function upload_chunks_attachments_single($source, $target_dir, $max_size, $allowed_ext, $identifier, $user_id, $newwidth, $newheight, $compress_factor) {
    $a = 0;
    $imageArray = array();

   
        if (is_uploaded_file($source['tmp_name'][$a])) {
            $uploadedfile = $source['tmp_name'][$a];
            $name = $source['name'][$a];
            
            // Use a variable to store the result of explode
            $nameParts = explode('.', $name);
            $ext = strtolower(end($nameParts));
            $size = filesize($source['tmp_name'][$a]);

            // Rename image
            $name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $name);

            // Check if the file type is allowed
            if (!in_array($ext, $allowed_ext)) {
                // Return response
                return json_encode(array('status' => '-1', 'message' => 'Attached file type not allowed.'));
            }

            // Rename image
            $rand_1 = rand(9999, 9999999);
            $rand_2 = rand(9999999, 9999999999);
            $rand_3 = rand();
            $actual_image_name = strtolower(str_replace(' ', '', $identifier . '_' . $size . '_' . $user_id . '_' . time() . '_' . $rand_1 . '_' . $rand_2 . '_' . $rand_3 . "." . $ext));

            if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
                if ($size > $max_size) {
                    $imgInfo = getimagesize($uploadedfile);
                    list($width, $height) = $imgInfo;
                    $mime = $imgInfo['mime'];
                    if ($mime == 'image/jpeg') {
                        $src = imagecreatefromjpeg($uploadedfile);
                    } else if ($mime == 'image/png') {
                        $src = imagecreatefrompng($uploadedfile);
                    } else {
                        $src = imagecreatefromjpeg($uploadedfile);
                    }

                    // Resize image
                    $ratio = $newwidth / $width;
                    $new_w = $newwidth;
                    $new_h = $height * $ratio;
                    if ($new_h > $newheight) {
                        $ratio = $newheight / $height;
                        $new_h = $newheight;
                        $new_w = $width * $ratio;
                    }

                    $tmp = imagecreatetruecolor($new_w, $new_h);
                    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $new_w, $new_h, $width, $height);
                    $filename = $target_dir . $actual_image_name;
                    imagejpeg($tmp, $filename, $compress_factor);
                    imagedestroy($src);
                    imagedestroy($tmp);
                } else {
                    move_uploaded_file($uploadedfile, $target_dir . $actual_image_name);
                }
            } else {
                // Process and move the file if not an image
                $target_file = $target_dir . $actual_image_name;

                // Upload file in chunks (optional, can be omitted if not needed)
                $chunk_size = 1024; // Chunk in bytes
                $upload_start = 0;
                $handle = fopen($uploadedfile, "rb");
                $fp = fopen($target_file, 'w');

                while ($upload_start < $size) {
                    $contents = fread($handle, $chunk_size);
                    fwrite($fp, $contents);
                    $upload_start += strlen($contents);
                    fseek($handle, $upload_start);
                }

                fclose($handle);
                fclose($fp);
                unlink($uploadedfile);
            }

            $a++;
            $imageArray[] = $actual_image_name;
        }
    
    return $imageArray;
}