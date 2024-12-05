<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/sreniGarta.core.php';
?>
<option value="">Select shreni</option>
<?php
foreach ($gataInfo as $key => $value) {
    ?>
    <option value="<?php echo $value['Shreni']; ?>"><?php echo $value['Shreni']; ?></option>
    <?php
}
