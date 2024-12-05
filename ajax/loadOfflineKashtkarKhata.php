<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/offlineGataKhata.core.php';
?>
<option value="">Select Khata</option>
<?php
foreach ($khataInfo as $key => $value) {
    ?>
    <option value="<?php echo $value['KhataNo']; ?>"><?php echo $value['KhataNo']; ?></option>
    <?php
}