<?php

if ($_GET['password'] == '!123Bida-Lams') {
    if (unlink(dirname(dirname(__FILE__)) . "/logs/error_logs/error_log.txt")) {
        echo '<h4>Log Clear</h4>';
    } else {
        echo '<h4>Log not found</h4>';
    }
} else {
    echo '<h4 style="color: red;">Please enter password in url</h4>';
}