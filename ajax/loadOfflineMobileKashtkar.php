<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/OfflineGataKashtkar.core.php';
?>
<option value="">Select Kashtkar</option>
<?php
foreach ($kashtkarInfo as $key => $value) {
    ?>
    <option value="<?php echo encryptIt($value['OwnerNo'] . '@' . $value['Area'] . '@' . $value['owner_name'] . '@' . $value['owner_father']); ?>" area="<?php echo $value['Area']; ?>"><?php echo $value['owner_name']; ?> (रकबा: <?php echo $value['Area']; ?> हेक्टेयर)</option>
    <?php
}
?>
<option value="other">नया काश्तकार यहाँ जोड़ें</option>