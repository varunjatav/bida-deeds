<?php

// count items in array
function count_($array) {
    return is_array($array) ? count($array) : 0;
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

function getFolderSize($path) {
    // path for directory
    $f = $path;
    $io = popen('/usr/bin/du -sk ' . $f, 'r'); //open directory for path and read files
    $size = fgets($io, 4096);
    $size = substr($size, 0, strpos($size, "\t"));
    pclose($io);
    $size = str_replace(',', '', $size); // remove ',' from size
    // convert size as readable format
    if ($size > 1048576) {
        $real_size = number_format(($size / 1048576), 2) . ' GB';
    } else if ($size > 1024 && $size < 1048576) {
        $real_size = number_format(($size / 1024), 2) . ' MB';
    } else {
        $real_size = number_format($size, 2) . ' KB';
    }
    // return size
    return $real_size;
}

function encryptIt($q) {
    // Storing the cipher method
    $ciphering = "AES-128-CTR";

    // Using OpenSSl Encryption method
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;

    // Non-NULL Initialization Vector for encryption
    $encryption_iv = '53414e544f53484b';

    // Storing the encryption key
    $encryption_key = "qJB0tInSUaJNHtxOGs0H3efyCp";

    // Using openssl_encrypt() function to encrypt the data
    $qEncoded = openssl_encrypt($q, $ciphering, $encryption_key, $options, $encryption_iv);
    return $qEncoded;
}

function decryptIt($qq) {
    //replace string
    $qq = str_replace(' ', '+', $qq);

    // Storing the cipher method
    $ciphering = "AES-128-CTR";
    $options = 0;

    // Non-NULL Initialization Vector for decryption
    $decryption_iv = '53414e544f53484b';

    // Storing the decryption key
    $decryption_key = "qJB0tInSUaJNHtxOGs0H3efyCp";

    // Using openssl_decrypt() function to decrypt the data
    $qDecoded = openssl_decrypt($qq, $ciphering, $decryption_key, $options, $decryption_iv);
    return $qDecoded;
}

// filter inputs for XSS attacks
function __fi($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// commit database transactions
function commit($db, $msg, $success_array) {
    // Make the changes to the database permanent
    $db->commit();
    // return response
    $db_respose_data = json_encode(array('status' => true, 'message' => $msg, 'success_array' => $success_array));
    print_r($db_respose_data);
    // Closing the database connection
    $db = null;
    exit();
}

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

    $db_respose_data = json_encode(array('status' => false, 'message' => $err_msg));
    print_r($db_respose_data);
    // Closing the database connection
    $db = null;
    exit();
}

// recursive function to delete null/empty values
function removeEmptyValues($value) {
    if (is_array($value)) {
        $value = array_map('removeEmptyValues', $value);
        $value = array_filter($value, function ($v) {
            // Change the below to determine which values get removed
            return !($v === "" || $v === null || $v === false || (is_array($v) && empty($v)));
        });
    }
    return $value;
}

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

function secondsToTime($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a') == 0 ? $dtF->diff($dtT)->format('%h hours') : $dtF->diff($dtT)->format('%a days, %h hours');
}

function microservice_call($microservice_url, $http_basic_auth_username, $http_basic_auth_key, $array_object) {

    $customerKey = $http_basic_auth_username;

    $customerSecret = $http_basic_auth_key;

    $credentials = $customerKey . ":" . $customerSecret;

    // Encode with base64
    $base64Credentials = base64_encode($credentials);

    // Create authorization header
    $arr_header = "Authorization: Basic " . $base64Credentials;

    // host url
    $url = $microservice_url;

    $data = $array_object;

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
            $arr_header,
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

    return $response;
}

function myUrlEncode($string) {
    $entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
    $replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
    return str_replace($entities, $replacements, urlencode($string));
}

function validate_attachments($source, $allowed_ext) {
    // check for valid attachments
    $ab = 0;
    $check_attachments = 0;
    foreach ($source['tmp_name'] as $nameFile) {
        if (is_uploaded_file($source['tmp_name'][$ab])) {
            $name = $source['name'][$ab];
            $ext = strtolower(end(explode('.', $name)));
            // if not valid image
            if (!in_array($ext, $allowed_ext)) {
                $check_attachments++;
                $data = array('status' => false, 'message' => 'Some problem with attachments.');
                print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
                exit();
            }
            $ab++;
        }
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

//check profile completeness
function profileCompleteness($db, $user_gender, $userid) {

    // get questionnaire filled by user
    $total_question_count = 0;
    $gender = 0;
    if ($user_gender == 'Male') {
        $gender = 3;
    } else if ($user_gender == 'Female') {
        $gender = 2;
    } else {
        $gender = 4;
    }

    // get questionnaire filled by user
    $sql_total_ques = $db->prepare("SELECT COUNT(T1.ID) AS TotalQuestion
                                FROM ha_self_assesment_question T1
                                WHERE T1.Active = ?
                                AND (T1.UserType = ?
                                OR T1.UserType = ?)

                                UNION ALL

                                SELECT COUNT(T2.ID) AS TotalQuestion
                                FROM ha_pandemic_health_question T2
                                WHERE T2.Active = ?
                                AND (T2.UserType = ?
                                OR T2.UserType = ?)

                                UNION ALL

                                SELECT COUNT(T3.ID) AS TotalQuestion
                                FROM ha_chronic_disease_question T3
                                WHERE T3.Active = ?
                                AND (T3.UserType = ?
                                OR T3.UserType = ?)

                                UNION ALL

                                SELECT COUNT(T4.ID) AS TotalQuestion
                                FROM ha_daily_routine_question T4
                                WHERE T4.Active = ?
                                AND (T4.UserType = ?
                                OR T4.UserType = ?)

                                UNION ALL

                                SELECT COUNT(T5.ID) AS TotalQuestion
                                FROM ha_immune_question T5
                                WHERE T5.Active = ?
                                AND (T5.UserType = ?
                                OR T5.UserType = ?)

                                UNION ALL

                                SELECT COUNT(T6.ID) AS TotalQuestion
                                FROM ha_medical_history_question T6
                                WHERE T6.Active = ?
                                AND (T6.UserType = ?
                                OR T6.UserType = ?)

                                UNION ALL

                                SELECT COUNT(T7.ID) AS TotalQuestion
                                FROM ha_current_health_question T7
                                WHERE T7.Active = ?
                                AND (T7.UserType = ?
                                OR T7.UserType = ?)
                            ");
    $sql_total_ques->bindValue(1, 1);
    $sql_total_ques->bindValue(2, 1);
    $sql_total_ques->bindParam(3, $gender);
    $sql_total_ques->bindValue(4, 1);
    $sql_total_ques->bindValue(5, 1);
    $sql_total_ques->bindParam(6, $gender);
    $sql_total_ques->bindValue(7, 1);
    $sql_total_ques->bindValue(8, 1);
    $sql_total_ques->bindParam(9, $gender);
    $sql_total_ques->bindValue(10, 1);
    $sql_total_ques->bindValue(11, 1);
    $sql_total_ques->bindParam(12, $gender);
    $sql_total_ques->bindValue(13, 1);
    $sql_total_ques->bindValue(14, 1);
    $sql_total_ques->bindParam(15, $gender);
    $sql_total_ques->bindValue(16, 1);
    $sql_total_ques->bindValue(17, 1);
    $sql_total_ques->bindParam(18, $gender);
    $sql_total_ques->bindValue(19, 1);
    $sql_total_ques->bindValue(20, 1);
    $sql_total_ques->bindParam(21, $gender);
    $sql_total_ques->execute();
    $sql_total_ques->setFetchMode(PDO::FETCH_ASSOC);
    $ques_filled = 0;
    while ($row_total_ques = $sql_total_ques->fetch()) {
        $total_question_count += $row_total_ques['TotalQuestion'];
    }

    // get questionnaire filled by user
    $sql_ques = $db->prepare("(SELECT T1.Options
                            FROM ha_user_self_assesment T1
                            WHERE T1.UserID = ?
                            LIMIT 1
                            )
                            UNION ALL
                            (
                            SELECT T2.Options
                            FROM ha_user_pandemic_health T2
                            WHERE T2.UserID = ?
                            LIMIT 1
                            )
                            UNION ALL
                            (
                            SELECT T3.Options
                            FROM ha_user_chronic_disease T3
                            WHERE T3.UserID = ?
                            LIMIT 1
                            )
                            UNION ALL
                            (
                            SELECT T4.Options
                            FROM ha_user_current_health T4
                            WHERE T4.UserID = ?
                            LIMIT 1
                            )
                            UNION ALL
                            (
                            SELECT T5.Options
                            FROM ha_user_medical_history T5
                            WHERE T5.UserID = ?
                            LIMIT 1
                            )
                            UNION ALL
                            (
                            SELECT T6.Options
                            FROM ha_user_daily_routine T6
                            WHERE T6.UserID = ?
                            LIMIT 1
                            )
                            UNION ALL
                            (
                            SELECT T7.Options
                            FROM ha_user_immune T7
                            WHERE T7.UserID = ?
                            LIMIT 1
                            )
                        ");
    $sql_ques->bindParam(1, $userid);
    $sql_ques->bindParam(2, $userid);
    $sql_ques->bindParam(3, $userid);
    $sql_ques->bindParam(4, $userid);
    $sql_ques->bindParam(5, $userid);
    $sql_ques->bindParam(6, $userid);
    $sql_ques->bindParam(7, $userid);
    $sql_ques->execute();
    $sql_ques->setFetchMode(PDO::FETCH_ASSOC);
    $ques_filled = 0;
    while ($row_ques = $sql_ques->fetch()) {
        $ques_filled += count(json_decode($row_ques['Options'], true));
    }

    $questionnaire_completeness = floor(($ques_filled / $total_question_count) * 100);
    $questionnaire_completeness = $questionnaire_completeness > 100 ? '100' : $questionnaire_completeness;

    return $questionnaire_completeness;
}

// function to create aha log
function user_aha_log($user_id, $source, $script_file_name, $request_msg, $request_param_data) {
    $logfile = dirname(dirname(__FILE__)) . "/logs/user_aha_logs/" . $user_id . "_aha_log.txt";
    $myfile = fopen($logfile, "a+") or die("Unable to open file! " . $user_id);
    $req_data = ' ' . $request_msg . ' ' . json_encode($request_param_data) . '';
    fwrite($myfile, date('d-m-Y h:i A') . " | " . $source . " | " . $script_file_name . " | " . $req_data . "\n");
    fwrite($myfile, "---------------------------------------------------------------------------------------------------------------------------------------------------------\n");
    fclose($myfile);
}

function apply_coupon($db, $coupon_data) {
    $current_time = time();
    $user_id = $coupon_data['userid'];
    $coupon = $coupon_data['coupon'];

    $sql = $db->prepare("SELECT T1.Type, T1.DiscountAmount, T1.UsedByUser, T1.MaxUses, T1.MaxUsesUser, T1.MinimumValue, T1.MaximumDiscountValue, T1.MetaData
                                FROM ha_coupon_codes T1
                                WHERE T1.CouponCode = ?
                                AND T1.DateExpired = ?
                                AND T1.ValidUpto > ?
                                LIMIT 1
                                ");

    $sql->bindParam(1, $coupon);
    $sql->bindValue(2, 0);
    $sql->bindParam(3, $current_time);
    $sql->execute();
    $rowcount = $sql->rowCount();
    if ($rowcount) {
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        while ($row = $sql->fetch()) {
            $minimum_value = $row['MinimumValue'];
            $coupon_type = $row['Type'];
            $coupon_discount_amount = $row['DiscountAmount'];
            $max_discount_value = $row['MaximumDiscountValue'];
            $max_user = $row['MaxUsesUser'];
            $max_uses = $row['MaxUses'];
            $meta_data = json_decode($row['MetaData'], true);
            $user_array = array_filter(explode(',', $row['UsedByUser']));
            $user_array_count = count($user_array);
            $user_used_coupon_count_array = array_count_values($user_array);
            $user_used_coupon_count = $user_used_coupon_count_array[$user_id];

            $response_data = array(
                'coupon_type' => $coupon_type,
                'minimum_value' => $minimum_value,
                'user_used_coupon_count' => $user_used_coupon_count,
                'max_uses' => $max_uses,
                'max_user' => $max_user,
                'meta_data' => $meta_data,
                'max_discount_value' => $max_discount_value,
                'coupon_discount_amount' => $coupon_discount_amount,
                'user_array_count' => $user_array_count
            );
            //Creating JSON
            $data = array('status' => true, 'message' => '', 'coupon_data' => $response_data);
        }
    } else {
        //Creating JSON
        $data = array('status' => false, 'message' => 'Invalid code.');
    }
    return $data;
}

// function to create user app activity log
function user_app_activity_log($user_id, $type) {
    $logfile = dirname(dirname(__FILE__)) . "/logs/user_app_activity_logs/" . $user_id . ".txt";
    $myfile = fopen($logfile, "a+") or die("Unable to open file! " . $user_id);
    $info = '';
    $info .= ' ' . $type . '';
    fwrite($myfile, date('d-m-Y h:i A') . " | " . $info . "\n");
    fwrite($myfile, "--------------------------------\n");
    fclose($myfile);
}

function validateYYYYMMDD($date, $field = NULL) {
    $date_pattern = '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/';

    if (preg_match($date_pattern, $date)) {
        return $date;
    } else {
        $data = array('status' => false, 'message' => 'Invalid date format(YYY-MM-DD) in ' . $field);
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateDDMMYYYY($date, $field = NULL) {
    $date_pattern = '/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/';

    if (preg_match($date_pattern, $date)) {
        return $date;
    } else {
        $data = array('status' => false, 'message' => 'Invalid date format(DD-MM-YYYY) in ' . $field);
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateEmail($email) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return $email;
    } else {
        $data = array('status' => false, 'message' => 'Invalid email address');
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateAlphabet($string, $field = NULL) {
    $pattern = '/[a-zA-Z ]$/';

    if (preg_match($pattern, $string)) {
        return $string;
    } else {
        $data = array('status' => false, 'message' => 'Only alphabets are allowed in ' . $field);
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateNumeric($string, $field = NULL) {

    if (is_numeric($string)) {
        return $string;
    } else {
        $data = array('status' => false, 'message' => 'Only numerics are allowed in ' . $field);
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateInteger($string, $field = NULL) {
    $pattern = '/^[0-9]+$/';

    if (preg_match($pattern, $string)) {
        return $string;
    } else {
        $data = array('status' => false, 'message' => 'Only integers allowed in ' . $field);
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateAlphaNum($string, $field = NULL) {
    $pattern = '/[a-zA-Z0-9 ]$/';
    if (preg_match($pattern, $string)) {
        return $string;
    } else {
        $data = array('status' => false, 'message' => 'Only alphanumerics allowed in ' . $field);
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateDecimalValue($string, $upto, $field = NULL) {
    $pattern = "/(\d\.\d{" . $upto . "})(?!\d)/";
    if (preg_match($pattern, $string)) {
        return $string;
    } else {
        $data = array('status' => false, 'message' => 'Only decimal value allowed upto ' . $upto . ' in ' . $field);
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateMaxLen($string, $len, $field = NULL) {
    $length = strlen($string);
    if ($length < $len) {
        return $string;
    } else {
        $data = array('status' => false, 'message' => 'Max length should be ' . $len . ' in ' . $field);
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateMinLen($string, $len, $field = NULL) {
    $length = strlen($string);
    if ($length > $len) {
        return $string;
    } else {
        $data = array('status' => false, 'message' => 'Min length should be ' . $len . ' in ' . $field);
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateMinMaxLen($string, $min, $max, $field = NULL) {
    $pattern = '/^[0-9]{' . $min . ',' . $max . '}$/i';
    if (preg_match($pattern, $string)) {
        return $string;
    } else {
        $data = array('status' => false, 'message' => 'Length should be between ' . $min . ' and ' . $max . ' in ' . $field);
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateLatitude($string) {
    if (preg_match('/^(\+|-)?(?:90(?:(?:\.0{1,15})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,15})?))$/', $string)) {
        return $string;
    } else {
        $data = array('status' => false, 'message' => 'Invalid Latitude');
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateLongitude($string) {
    if (preg_match('/^(\+|-)?(?:180(?:(?:\.0{1,15})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,15})?))$/', $string)) {
        return $string;
    } else {
        $data = array('status' => false, 'message' => 'Invalid Longitude');
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateMobile($string) {
    $pattern = "/^[6-9][0-9]{9}$/";
    if (preg_match($pattern, $string) !== 1 || strlen($string) != 10) {
        $data = array('status' => false, 'message' => 'Invalid mobile number');
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
        $data = array('status' => false, 'message' => 'Invalid Url');
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateGender($string) {
    $pattern = array('male', 'female', 'other');
    if (in_array(strtolower($string), $pattern)) {
        return $string;
    } else {
        $data = array('status' => false, 'message' => 'Invalid gender');
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function validateComment($string) {

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

function get_cache($path, $ttl) {
    if (file_exists($path)) {
        if ($ttl) {
            $cache_mtime = filemtime($path);
            $current_time = time();
            if (($current_time - $cache_mtime) > $ttl) {
                unlink($path);
                return 0;
            } else {
                return 1;
            }
        } else {
            return 1;
        }
    } else {
        return 0;
    }
}

function set_cache($path, $data) {
    $cache_file_name = fopen($path, "w") or die("Unable to open file!");
    fwrite($cache_file_name, $data);
    fclose($cache_file_name);
    return true;
}

function delete_cache($path) {
    if (file_exists($path)) {
        unlink($path);
        return true;
    }
}

function json_validate($string) {
    // decode the JSON data
    $result = json_decode($string, true);

    // switch and check possible JSON errors
    switch (json_last_error()) {
        case JSON_ERROR_NONE:
            $error = ''; // JSON is valid // No error has occurred
            break;
        case JSON_ERROR_DEPTH:
            $error = 'The maximum stack depth has been exceeded.';
            break;
        case JSON_ERROR_STATE_MISMATCH:
            $error = 'Invalid or malformed JSON.';
            break;
        case JSON_ERROR_CTRL_CHAR:
            $error = 'Control character error, possibly incorrectly encoded.';
            break;
        case JSON_ERROR_SYNTAX:
            $error = 'Syntax error, malformed JSON.';
            break;
        // PHP >= 5.3.3
        case JSON_ERROR_UTF8:
            $error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
            break;
        // PHP >= 5.5.0
        case JSON_ERROR_RECURSION:
            $error = 'One or more recursive references in the value to be encoded.';
            break;
        // PHP >= 5.5.0
        case JSON_ERROR_INF_OR_NAN:
            $error = 'One or more NAN or INF values in the value to be encoded.';
            break;
        case JSON_ERROR_UNSUPPORTED_TYPE:
            $error = 'A value of a type that cannot be encoded was given.';
            break;
        default:
            $error = 'Unknown JSON error occured.';
            break;
    }

    if ($error !== '') {
        // throw the Exception or exit // or whatever :)
        //exit($error);
        return 0;
    }

    // everything is OK
    return json_encode($result, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

function validateAgeByYears($dob, $age) { // Date in time stamp and age shoud be in years
    $sdate = date('Y-m-d', $dob);
    $edate = date('Y-m-d', time());
    $date_diff = abs(strtotime($edate) - strtotime($sdate));
    $years = floor($date_diff / (365 * 60 * 60 * 24));

    if ($years < $age) {
        $data = array('status' => false, 'message' => 'Age should be greater than ' . $age . ' years.');
        print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
        exit();
    }
}

function searchValueInMultiArray($array_key, $id, $array) {
    if (is_array($array)) {
        foreach ($array as $key => $val) {
            if ($val[$array_key] === $id) {
                return $key;
            }
        }
    }
    return null;
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

// generate unique invoice series

function generate_invoice_series($db, $table_name, $invoice_series_column, $invoice_createtime_column, $invoice_series_change_date) {

    $date_count = 1;

    if (date('Ymd', time()) == $invoice_series_change_date) {

        $sql_check = $db->prepare("SELECT COUNT(*) AS DateCount
                                    FROM $table_name
                                    WHERE FROM_UNIXTIME($invoice_createtime_column, '%Y%m%d') = ?
                                 ");
        $sql_check->bindParam(1, $invoice_series_change_date);
        $sql_check->execute();
        $sql_check->setFetchMode(PDO::FETCH_ASSOC);
        $date_check = $sql_check->fetch();
        $date_count = $date_check['DateCount'];
    }

    $sql = $db->prepare("SELECT $invoice_series_column, $invoice_createtime_column
                                FROM $table_name
                                ORDER BY ID DESC
                                LIMIT 1
                            ");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $row_series = $sql->fetch();

    if (date('Ymd', time()) == $invoice_series_change_date && $date_count == 0) {
        $invoice_series = '01';
    } else {
        $invoice_series = $row_series[$invoice_series_column] + 1;
        $invoice_series = $invoice_series < 10 ? '0' . $invoice_series : $invoice_series;
    }

    return $invoice_series;
}
