<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/getMahalByVillageFilter.core.php';
include_once '../core/permission.core.php';
include_once '../languages/' . $lang_file;
?>
<option value=""><?php echo $landmaster_filter_popup['select_mahal'];?>*</option>
<?php while ($row = $mahal_query->fetch()) { ?>
    <option value="<?php echo $row['MahalName']; ?>"><?php echo $row['MahalName']; ?></option>
<?php } ?>