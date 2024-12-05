<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/gataKashtkar.core.php';
?>
<option value="">Select Kashtkar</option>
<?php
foreach ($kashtkarInfo as $key => $value) {
    ?>
    <option value="<?php echo encryptIt($value['OwnerNo'] . '@' . $value['owner_name'] . '@' . $value['owner_father']); ?>"><?php echo $value['owner_name']; ?> (Area: <?php echo $value['Area']; ?>)</option>
    <?php
}