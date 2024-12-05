<?php

date_default_timezone_set('Asia/Kolkata');
include_once dirname(dirname(__FILE__)) . "/dbcon/db_connect.php";
include_once dirname(dirname(__FILE__)) . "/config.php";
include_once dirname(dirname(__FILE__)) . "/functions/common.function.php";
include_once dirname(dirname(__FILE__)) . "/vendor/autoload.php";

use Mailgun\Mailgun;

$mgClient = Mailgun::create($mailgun_key, $mailgun_api_url);
$timestamp = time();

// count total number of records exists in sms queue
$total_records_query = $db->query("SELECT Deleted, COUNT(*) as total_records FROM fa_email_queue WHERE Email != '' GROUP BY Deleted");
$total_records_query->setFetchMode(PDO::FETCH_ASSOC);

while ($row_records = $total_records_query->fetch()) {
    if ($row_records['Deleted'] == '0') {
        $total_records = $row_records['total_records']; // get non deleted rows
    } else if ($row_records['Deleted'] == '1') {
        $cnt = $row_records['total_records']; // get deleted rows
    }
}

$EMAIL_Batch = blockSize($total_records);

// check if sms batch is not full then continue
if ($EMAIL_Batch > 0) {

    $sql_insid_sms = $db->query("SELECT T1.ID, T1.Message, T1.MessageData, T1.Email, T1.TrySent, T1.Attachment, T1.Origin
                                  FROM fa_email_queue T1
                                  WHERE T1.Deleted = '0'
				  AND T1.Email != ''
				  AND T1.Email != '--'
                                  LIMIT " . $EMAIL_Batch . "
                                  ");

    $sql_insid_sms->setFetchMode(PDO::FETCH_ASSOC);
    $execute = 0;
    while ($row = $sql_insid_sms->fetch()) {
        if (filter_var($row['Email'], FILTER_VALIDATE_EMAIL)) {
            $execute = 1;
        }
        if ($row['TrySent'] <= 3 && $execute == 1) {
            $mailgun_attachment_arr = array();
            $row_attachment = json_decode(html_entity_decode($row['Attachment']), true);
            if ($row_attachment) {
                $attachment_array = explode(',', $row_attachment);
                if ($row['Origin'] == 'DecSecStatus') {
                    foreach ($attachment_array as $attKey => $attValue) {
                        $mailgun_attachment_arr[] = array('filePath' => $main_path . "/" . $remark_attachment . "/" . $attValue, 'filename' => end(explode('/', $attValue)));
                    }
                } elseif ($row['Origin'] == 'RaiseQuery') {
                    foreach ($attachment_array as $attKey => $attValue) {
                        $mailgun_attachment_arr[] = array('filePath' => $main_path . "/" . $raise_query_attachment . "/" . $attValue, 'filename' => end(explode('/', $attValue)));
                    }
                } else {
                    foreach ($attachment_array as $attKey => $attValue) {
                        if (file_exists(dirname(dirname(__FILE__)) . "/" . $attValue)) {
                            $mailgun_attachment_arr[] = array('filePath' => dirname(dirname(__FILE__)) . "/" . $attValue, 'filename' => end(explode('/', $attValue)));
                        }
                    }
                }
            }

            // make template
            $tmplt = '';
            $tmplt .= '<!doctype html>
                        <html>
                            <head>
                                <meta charset="UTF-8">
                                <title>Untitled Document</title>
                            </head>

                            <body style="font-family:Roboto, sans-serif; font-size: 14px;">

                                <div style="width: 600px; margin:0 auto; border: 1px solid #ddd; border-radius: 8px; overflow: hidden;">
                                    <div>
                                       <a href="' . $main_path . '">
                                         <img src="' . $main_path . '/img/logoimage.jpg" width="150" alt="">
                                        </a>
                                        <div style="clear: both"></div>
                                    </div>

                                    <div style="min-height: 400px; padding: 20px;">
                                        <div style="font-weight: bold; margin-top: 30px;"></div>
                                        <div style="margin-top: 30px; text-align: justify;">' . html_entity_decode($row['MessageData']) . '</div>
                                        <div style="color: #666; line-height: 20px; margin-top: 50px;">
                                            Regards';
            $tmplt .= "<br>";
            $tmplt .= 'Team - Farishtey';
            $tmplt .= '</div>
                                    </div>
                                </div>
                            </body>
                        </html>';

            # send email to mailgun
            $params = array(
                'from' => $mail_from_alias . ' <' . $mail_from . '>',
                'to' => $row['Email'],
                'subject' => html_entity_decode($row['Message']),
                'html' => $tmplt,
                'attachment' => $mailgun_attachment_arr
            );

            # Make the call to the client.
            $result = $mgClient->messages()->send($mail_domain, $params);

            if ($result->getId()) {
                $db->query("UPDATE fa_email_queue SET SentStatus = '1', SentTime = " . $timestamp . ", TrySent = TrySent + 1, Deleted = '1' WHERE ID = " . $row['ID'] . "");
            } else {
                $db->query("UPDATE fa_email_queue SET TrySent = TrySent + 1 WHERE ID = " . $row['ID'] . "");
            }
        } else {
            $db->query("UPDATE fa_email_queue SET TrySent = TrySent + 1, Deleted = '1' WHERE ID = " . $row['ID'] . "");
        }
    }
}

// delete from sms_queue table and take backup of deleted records
// if deleted records count exceeds
if ($cnt > $msg_rows_count) {
    $deleted = 0;
    exec('mysqldump --user=' . $db_username . ' --password=' . $db_password . ' --host=' . $db_hostname . ' --databases ' . $db_database . ' --tables ps_email_queue --where="Deleted > ' . $deleted . '" > ' . dirname(dirname(__FILE__)) . '/logs/mail_logs/queue_mail-' . date('d-m-Y') . '-' . date('H-i-s', time()) . '.sql');
    $db->query("DELETE FROM fa_email_queue WHERE Deleted = '1'");
}
