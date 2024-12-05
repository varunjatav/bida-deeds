<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/gata.core.php';
if ($type == '1') {
    ?>
    <option value="">Select Gata</option>
    <?php
    foreach ($gataInfo as $key => $value) {
        ?>
        <option value="<?php echo encryptIt($value['GataNo'] . '@' . $value['KhataNo'] . '@' . $value['Area']); ?>"><?php echo $value['GataNo']; ?> - (Area: <?php echo $value['Area']; ?>, Khata: <?php echo $value['KhataNo']; ?>)</option>
        <?php
    }
} else if ($type == '2') {
    ?>
    <option value="">Select Gata</option>
    <?php
    foreach ($gataInfo as $key => $value) {
        ?>
        <option value="<?php echo $value['GataNo']; ?>"><?php echo $value['GataNo']; ?></option>
        <?php
    }
} else {
    ?>
    <option value="">Select Gata</option>
    <option value="0">All Gata</option>
    <?php
    foreach ($gataInfo as $key => $value) {
        ?>
        <option value="<?php echo encryptIt($value['GataNo'] . '@' . $value['KhataNo'] . '@' . $value['Area']); ?>"><?php echo $value['GataNo']; ?> - (Area: <?php echo $value['Area']; ?>, Khata: <?php echo $value['KhataNo']; ?>)</option>
        <?php
    }
}