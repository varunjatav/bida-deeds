<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/misReportDates.core.php';
if ($row_count) {
    ?>
    <option value="">Select Date</option>
    <?php
    foreach ($reportDates as $key => $value) {
        ?>
        <option value="<?php echo date('d-m-Y', strtotime($value)); ?>"><?php echo date('d-m-Y', strtotime($value)); ?></option>
        <?php
    }
} else {
    echo '-1';
}