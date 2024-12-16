<?php

error_reporting(0);
$db_hostname = "localhost";
$db_database = "deed@2024";
$db_username = "root";
$db_password = "";
define("DOCUMENT_MAX_SIZE", "2000");

/* * ************ path for village ebasta ************* */
$media_village_ebasta_path = "media/ebasta";

/* * ************ path for gata ebasta ************* */
$media_gata_ebasta_path = "media/ebasta";

/* * ************ path for lekhpal gata ebasta ************* */
$media_lekhpal_ebasta_path = "media/lekhpal_ebasta";

/* * ************ path for kashtkar sahmati ************* */
$media_kashtkar_sahmati_path = "media/kashtkar_sahmati";

/* * ************ path for grievance report ************* */
$media_grievance_report_path = "media/grievance_report";

/* * ************ path for office order ************* */
$media_office_order_path = "media/office_order";

/* * ************ path for village certificate ************* */
$media_village_certificate_path = "media/village_certificate";

// excel export path
$media_export = "media/excel";

$url_head = 'http://';

$main_path = $url_head . 'localhost/dgms';

$kasht_main_path = $url_head . 'localhost/bida_lams/kashtkarlogin';

$cookie_domain = '';

// login attempts
$login_attempts = 3;

// block time for login
$block_time = 5;

// attempts to black list ip
$lockout_attempts = 3;

//prefix for user unique id
$prefix_user_id = 'P';

// This is TimeOut period in minutes
$TimeOutMinutes = 1440;

// TimeOut in Seconds
$TimeOutSeconds = $TimeOutMinutes * 60;

// cookie time to live
$cookie_ttl = 86400;

// max life span of session cookie
$session_cookie_lifespan = 86400;

// max life span of garbage collection
$garbage_max_lifespan = 86400;

// No of rows that should be backup before permanent delete(msg)
$msg_rows_count = 10000;

// cipher variables
$ciphering = "AES-128-CTR";
$cipher_options = 0;
$encryption_iv = '53414e544f53484b';
$encryption_key = "qJB0tInSUaJNHtxOGs0H3efyCp";

// cookie name
$cookie_name = "bida_lams";

// kashtkar cookie name
$kasht_cookie_name = "kasht_bida_lams";

// landing page
$landing_page = 'dashboard';

// set timeout for downloading attachments
$download_file_timeout = 2;

// api access variables
$server_api_key = 'S1613474816O';
$api_key_length = 12;
$api_timestamp_length = 10;
$api_timestamp_diff = 2;
$api_secret_key = 'qJB0tInSUaJNHtxOGs0H3efyCp';

// redis access variables
$redis_host = '34.131.134.43';
$redis_port = 6379;
$redis_timeout = 0.8;
$redis_password = '!123Redis789';
$redis_client_total_api_ttl = 60; // in seconds
$redis_client_total_api_hit_count = 80; // how many times api can be hit with in api usage timeout
$redis_client_each_api_ttl = 2; // in seconds
$redis_client_api_hit_count = 4; // how many times api can be hit with in api usage timeout
//app latest version in playstore
$app_version = '3.1.0';

//////////////////////////
//// SMS Configuration////
//////////////////////////

/* Default Sender */
$default_Sender_msg_otp = 'OTPINB';
$default_Sender_msg = 'INOBLS';

// No of text msg process at one time
$text_msg_process_at_one_time = 1;

// Set text msg provider/host
$text_msg_host = 'http://api.smscountry.com/SMSCWebservice_MultiMessages.asp';

// Delivery reports ( Y/N )
$delivery_report = 'Y';

// Message Type
$message_type = 'N';

// Set username for text sending
$text_msg_user = 'innobles';
$text_msg_user_otp = 'innobles';

// Set password for text msg sending
$text_msg_password = '27525468';

// No of rows that should be backup before permanent delete(msg)
$msg_rows_count = 10000;

// No of attemts allow to an msg
$msg_attempts_allowed = 1;

$sms_key = '';

// redis access variables
$redis_host = '34.131.120.133';
$redis_port = 6379;
$redis_timeout = 0.8;
$redis_password = '!123Redis789';
$redis_client_total_api_ttl = 60; // in seconds
$redis_client_total_api_hit_count = 5; // how many times api can be hit with in api usage timeout
$redis_client_each_api_ttl = 2; // in seconds
$redis_client_api_hit_count = 3; // how many times api can be hit with in api usage timeout

// prefrence village code
$village_names_code_array = array(
    "152800",
    "152797",
    "152730",
    "152751",
    "152754",
    "152750",
    "152737"
);
// 1359_shreni list
$sherni_list_1359_array = array(
    'जिम्मन- 1. सीर मालकान',
    'जिम्मन- 2. खुदकाश्त',
    'जिम्मन - 3. साराजी जिसपर असामियान कब्जा मुस्तकिल काबिज हो',
    'जिम्मन - 4. आराजी जिसपर असामियान शरह मुख्यत काबिज हो',
    'जिम्मन - 5. आराजी जिस पर असामियान साफतुल मिलकियत काबिज हो',
    'जिम्मन - 6. आराजी जिसपर आसामियान देखीलकार काबिज हो',
    'जिम्मन - 7. आराजी जिसपर असामियान काबिज खतौनी मुदत 133340',
    'जिम्मन - 8. आराजी जिसपर मौरूसी असामियान काबिज हो',
    'जिम्मन-9. आराजी जिस पर मौकसी असामियान काबिज हो और जिनके खास हेकंक हो',
    'जिम्मन - 10. काबिजान - आराजी जिसपर आसामियात गैर देखीलकार का हो',
    'जिम्मन - 11. बिना लगानी दाखिलमात',
    'जिम्मन - 12.',
    'जिम्मन - 13.',
    'जिम्मन - 14. आराजी काबिल जिरायत - 1- परती जदीद',
    'जिम्मन - 14. आराजी काबिल जिरायत - 2- परती कदीम',
    'जिम्मन - 14. आराजी काबिल जिरायत - 3- बंजर - दीगर काबिन जिरायत',
    'जिम्मन - 15. गैर मुमकिन - (i). आराजी जिस पर पानी हो',
    'जिम्मन - 15. गैर मुमकिन - (ii).आराजी सड़क मकानात वगैरह',
    'जिम्मन - 15. गैर मुमकिन - (iii). कब्रिस्तान मरघट वगैरह',
    'जिम्मन - 15. गैर मुमकिन - (iv). और किसी तरह से गैरमुमकिन (ठेका आदि)',
    'जिम्मन - 16. असामियान कदारान कब्जा मुस्तकिल',
    'जिम्मन - 17. असामियान सीर और असामियान खुदकाश्त 133340 या उसके बाद',
    'जिम्मन - 18.',
    'जिम्मन - 19. असामियान शिकमी',
    'जिम्मन - 20. ऐसे काश्तकार आराजी जिन्होंने कब्जा कर लिया हो'
);

// 2359_khasra list
$kismList_1359_array = array(
    'बंज़र',
    'पत्थर',
    'नाला',
    'पहाड़',
    'टौरिया',
    'रास्ता',
    'पुखरिया',
    'कदीम',
    'जदीद',
    'आबादी',
    'कृषि'
);

$branch_list_array = array(
    'Banking',
    'Agriculture',
    'Technology',
    'Development',
    'Finances'
);