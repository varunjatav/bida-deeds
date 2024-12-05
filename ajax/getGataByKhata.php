<?php
include_once '../config.php';
// include_once '../includes/kashtCheckSession.php';
// include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/getGataByKhata.core.php';
?>
<option value="">Select Gata</option>
<?php
foreach ($gataInfo as $key => $value) {
    ?>
    <option value="<?php echo $value['GataNo']; ?>"><?php echo $value['GataNo']; ?></option>
    <?php
}
