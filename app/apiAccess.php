<?php

function apiValidate($query_string, $api_file_name) {
    global $server_api_key;
    global $api_key_length;
    global $api_timestamp_length;
    global $api_timestamp_diff;
    global $api_secret_key;
    global $redis_host;
    global $redis_port;
    global $redis_timeout;
    global $redis_password;

    // connect to redis
    //$check_redis = connectRedis($redis_host, $redis_port, $redis_timeout, $redis_password, $api_file_name);

    $server_secret_key[$server_api_key] = $api_secret_key;
    //print_r($query_string);

    $api_key = $query_string['apikey'];
    $timestamp = $query_string['apitimestamp'];
    $request_hash = $query_string['hash'];

    // check if API key is present
    getApiKey($api_key, $api_key_length);

    // check if Time Stamp is present and valid
    getTimeStamp($timestamp, $api_timestamp_length, $api_timestamp_diff);

    // check secret key
    $secret_key = getSecretKey($api_key, $server_secret_key);

    // check request hash
    return prepareHash($api_key, $timestamp, $secret_key, $request_hash);
}

/**
 * function to connect redis server
 * @return boolean false if unable to connect
 */
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

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
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
                    printError('Oops... that was too fast.');
                }
            } else {
                $redis_total_api_access_key_ttl = $redis->ttl($client_ip);
                printError('API limit expired. Try again in ' . $redis_total_api_access_key_ttl . ' seconds.');
            }
        }
    } catch (Exception $e) {
        //echo ' LOG that redis is down : ' . $e->getMessage();
        printError($e->getMessage());
    }
}

/**
 * function to get api key from request
 * @return boolean false if api key missing
 */
function getApiKey($api_key, $api_key_length) {
    if ($api_key) {
        if (strlen($api_key) != $api_key_length) {
            printError('Invalid Api Key');
            return false;
        } else {
            return true;
        }
    } else {
        printError('Missing Api Key');
        return false;
    }
}

/**
 * function to get time stamp
 * @return boolean false if time stamp is missing
 */
function getTimeStamp($timestamp, $timestamp_length, $timestamp_diff) {
    if ($timestamp) {
        if (strlen($timestamp) != $timestamp_length) {
            printError('Invalid Timestamp');
            return false;
        } else if (time() - $timestamp > $timestamp_diff) {
            printError('Timestamp Expired');
            return false;
            //return true;
        } else {
            return true;
        }
    } else {
        printError('Missing Timestamp');
        return false;
    }
}

/**
 * function to get secret key
 * @param string $api_key
 * @return boolean false if invalid APi key else secret key
 */
function getSecretKey($api_key, $server_secret_key) {
    foreach ($server_secret_key as $sKey => $svalue) {
        if ($sKey != $api_key) {
            printError('Secret key not found');
            return false;
        } else {
            return $svalue;
        }
    }
}

/**
 * Function to create encoded hash
 * @param String $api_key
 * @param String $time_stamp
 * @param String $secret_key
 * @return String generated hash
 */
function prepareHash($api_key, $time_stamp, $secret_key, $requested_hash) {
    if ($requested_hash) {
        // get request params
        $params = $_REQUEST;

        unset($params['hash']);

        // change param names to lower case
        $params = array_change_key_case($params, CASE_LOWER);
        // sort params alphabetically
        ksort($params);

        // create string of keys & it's values in params
        // using concatenation
        $keys_string = '';
        $values_string = '';
        foreach ($params as $prmKey => $prmValue) {
            $keys_string .= $prmKey;
            $values_string .= $prmValue;
        }

        // concatenate base64 encode key string & value
        $paramsJsonStr = base64_encode($keys_string) . base64_encode($values_string);

        // append APi key and time stamp
        $paramsStrtoHash = $paramsJsonStr . $api_key . $time_stamp;

        $prepared_hash = hash_hmac('sha256', $paramsStrtoHash, $secret_key);

        if ($prepared_hash == $requested_hash) {
            return 1;
        } else {
            printError('Authorization failed invalid request');
            return false;
        }
    } else {
        printError('Missing hash value');
        return false;
    }
}

/**
 * function to get error message
 * @return string error message
 */
function printError($error_msg) {
    //Creating JSON
    $data = array('status' => false, 'message' => $error_msg);
    print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES));
    exit;
}
