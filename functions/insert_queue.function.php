<?php

function insert_into_queue($db, $params) {
    // check receiver count
    if (count_($params['app_receiver'])) {
        $origin = array_key_exists('ivr_call', $params) ? $params['origin'] : '';
        $priority = array_key_exists('priority', $params) ? $params['priority'] : '';
        $link_page = array_key_exists('link_page', $params) ? $params['link_page'] : '';
        $medium = array_intersect($params['user_medium'], $params['source_medium']);
        $medium_reff_arr = array();
        $common_medium_str = '';
        foreach ($medium as $mkey => $mval) {
            if ($mval == 'app') {
                $medium_reff_arr[] = '1';
            }
            if ($mval == 'text') {
                $medium_reff_arr[] = '2';
            }
            if ($mval == 'email') {
                $medium_reff_arr[] = '3';
            }
            if ($mval == 'whatsapp') {
                $medium_reff_arr[] = '4';
            }
            if ($mval == 'web') {
                $medium_reff_arr[] = '5';
            }
        }
        $common_medium_str = implode(',', $medium_reff_arr);

        //make array for queue table
        foreach ($params['app_receiver'] as $aKey => $aValue) {

            $ivr_call = array_key_exists('ivr_call', $params) ? $params['ivr_call'][$aKey] : '';
            $text_msg = array_key_exists('message_text', $params) ? $params['message_text'][$aKey] : '';
            $email_msg = array_key_exists('message_email', $params) ? $params['message_email'][$aKey] : '';
            $whatsapp_msg = array_key_exists('message_whatsapp', $params) ? $params['message_whatsapp'][$aKey] : '';
            $web_msg = array_key_exists('message_web', $params) ? $params['message_web'][$aKey] : '';
            $sender = array_key_exists('app_sender', $params) ? $params['app_sender'][$aKey] : '';
            $msgs = array_key_exists('app_message', $params) ? $params['app_message'][$aKey] : '';
            $fcm = array_key_exists('app_fcm', $params) ? $params['app_fcm'][$aKey] : '';
            $app_target_user = array_key_exists('app_target_user', $params) ? $params['app_target_user'][$aKey] : '';
            $os_type = array_key_exists('os_type', $params) ? $params['os_type'][$aKey] : 0;
            $mobile = array_key_exists('mobile', $params) ? $params['mobile'][$aKey] : '';
            $email = array_key_exists('email', $params) ? $params['email'][$aKey] : '';
            $attachments = array_key_exists('attachments', $params) ? json_encode($params['attachments'][$aKey]) : '';
            $message_data = array_key_exists('message_data', $params) ? $params['message_data'][$aKey] : '';

            if ($message_data || $email_msg || $web_msg || $whatsapp_msg || $text_msg || $ivr_call) {
                $encode_notify_data = json_encode($message_data);
                $msg_content = $message_data;
                $app_value[] = array('CreateTime' => time(), 'SenderID' => $sender, 'ReceiverID' => $aValue, 'FcmToken' => $fcm, 'Message' => $msgs, 'MessageData' => $encode_notify_data, 'MessageText' => $text_msg, 'MessageEmail' => $email_msg, 'MessageWhatsapp' => $whatsapp_msg, 'MessageWeb' => $web_msg, 'Attachment' => $attachments, 'Origin' => $origin, 'SentTo' => $app_target_user, 'OsType' => $os_type, 'Mobile' => $mobile, 'Email' => $email, 'Priority' => $priority, 'LinkPage' => $link_page, 'Medium' => $common_medium_str, 'VoiceClip' => $ivr_call);
            }
        }

        //queue operation for app notifiacation
        if (in_array('app', $params['user_medium']) && in_array('app', $params['source_medium']) && count($params['os_type']) && count($params['app_fcm'])) {

            // statement to insert in queue
            $queue_query = "INSERT INTO lm_app_queue (ReceiverID, CreateTime, FcmToken, Message, MessageData, SenderID, Priority, Origin, SentTo, OsType) VALUES "; //Prequery
            $queue_qPart = array_fill(0, count(array_filter($params['app_fcm'])), "(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $queue_query .= implode(",", $queue_qPart);

            $queue_stmt = $db->prepare($queue_query);
            $queue_i = 1;

            foreach ($app_value as $queue_itemKey => $queue_item) { //bind the values one by one
                if ($queue_item['FcmToken']) {
                    $queue_stmt->bindValue($queue_i++, __fi($queue_item['ReceiverID']));
                    $queue_stmt->bindValue($queue_i++, __fi($queue_item['CreateTime']));
                    $queue_stmt->bindValue($queue_i++, __fi($queue_item['FcmToken']));
                    $queue_stmt->bindValue($queue_i++, __fi($queue_item['Message']));
                    $queue_stmt->bindValue($queue_i++, __fi($queue_item['MessageData']));
                    $queue_stmt->bindValue($queue_i++, __fi($queue_item['SenderID']));
                    $queue_stmt->bindValue($queue_i++, __fi($queue_item['Priority']));
                    $queue_stmt->bindValue($queue_i++, __fi($queue_item['Origin']));
                    $queue_stmt->bindValue($queue_i++, __fi($queue_item['SentTo']));
                    $queue_stmt->bindValue($queue_i++, __fi($queue_item['OsType']));
                }
            }
            $queue_stmt->execute();
        }

        //queue operation for web notifiacation
        if (in_array('web', $params['user_medium']) && in_array('web', $params['source_medium'])) {

            // statement to insert in queue
            $queue_query = "INSERT INTO lm_web_queue (ReceiverID, CreateTime, Message, MessageData, SenderID, LinkPage, Priority, Origin, SentTo) VALUES "; //Prequery
            $queue_qPart = array_fill(0, count($app_value), "(?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $queue_query .= implode(",", $queue_qPart);

            $queue_stmt = $db->prepare($queue_query);
            $queue_i = 1;

            foreach ($app_value as $queue_itemKey => $queue_item) { //bind the values one by one
                $queue_stmt->bindValue($queue_i++, __fi($queue_item['ReceiverID']));
                $queue_stmt->bindValue($queue_i++, __fi($queue_item['CreateTime']));
                $queue_stmt->bindValue($queue_i++, __fi($queue_item['Message']));
                $queue_stmt->bindValue($queue_i++, __fi($queue_item['MessageWeb']));
                $queue_stmt->bindValue($queue_i++, __fi($queue_item['SenderID']));
                $queue_stmt->bindValue($queue_i++, __fi($queue_item['LinkPage']));
                $queue_stmt->bindValue($queue_i++, __fi($queue_item['Priority']));
                $queue_stmt->bindValue($queue_i++, __fi($queue_item['Origin']));
                $queue_stmt->bindValue($queue_i++, __fi($queue_item['SentTo']));
            }
            $queue_stmt->execute();
        }

        //queue operation for text notifiacation
        if (in_array('text', $params['user_medium']) && in_array('text', $params['source_medium']) && count($params['mobile']) != 0) {

            // statement to insert in queue
            $queue_query = "INSERT INTO lm_text_queue (ReceiverID, Mobile, CreateTime, Message, MessageData, SenderID, Priority, Origin) VALUES "; //Prequery
            $queue_qPart = array_fill(0, count(array_filter($params['mobile'])), "(?, ?, ?, ?, ?, ?, ?, ?)");
            $queue_query .= implode(",", $queue_qPart);

            $queue_stmt = $db->prepare($queue_query);
            $queue_i = 1;

            foreach ($app_value as $queue_itemKey => $queue_item) { //bind the values one by one
                if ($queue_item['Mobile']) {
                    $queue_stmt->bindParam($queue_i++, __fi($queue_item['ReceiverID']));
                    $queue_stmt->bindParam($queue_i++, __fi($queue_item['Mobile']));
                    $queue_stmt->bindParam($queue_i++, __fi($queue_item['CreateTime']));
                    $queue_stmt->bindParam($queue_i++, __fi($queue_item['Message']));
                    $queue_stmt->bindParam($queue_i++, __fi($queue_item['MessageText']));
                    $queue_stmt->bindParam($queue_i++, __fi($queue_item['SenderID']));
                    $queue_stmt->bindParam($queue_i++, __fi($queue_item['Priority']));
                    $queue_stmt->bindParam($queue_i++, __fi($queue_item['Origin']));
                }
            }
            $queue_stmt->execute();
        }
    }
}
