<?php
   include_once '../config.php';
   include_once '../includes/checkSession.php';
   include_once '../includes/get_time_zone.php';
   include_once '../dbcon/db_connect.php';
   include_once '../functions/common.function.php';
   include_once '../core/getMahalByVillage.core.php';
?>
<option value="">महल का नाम चुनें*</option>
<?php while($row = $mahal_query->fetch()){ ?>
      <option value="<?php echo $row['MahalName']; ?>"><?php echo $row['MahalName']; ?></option>
<?php } ?>