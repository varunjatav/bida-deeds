<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../functions/common.query.function.php';
include_once '../core/get1359FasliEditData.core.php';

$village_name = $row['VillageName'] ? $row['VillageName'] : '--';
$village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
$khata_no = $row['KhataNo'] ? $row['KhataNo'] : '--';
$gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
$shreni = $row['Shreni'] ? $row['Shreni'] : '--';
$gata_ka_rakba = $row['Area'] ? $row['Area'] : '--';
$gata_ka_rakba_acre = $row['RakbaA'] ? $row['RakbaA'] : '--';
$Kashtkar_Ka_Name = $row['kashtkar_owner_name'] ? $row['kashtkar_owner_name'] : '--';
$Kashtkar_Ka_father_Name = $row['kashtkar_owner_father'] ? $row['kashtkar_owner_father'] : '--';
$Kashtkar_Ka_area = $row['kashtkar_area'] ? $row['kashtkar_area'] : '--';
$ans_huai_ya_nhi = '--';
$Muhal_Ka_Name = $row['MahalName'] ? $row['MahalName'] : '--';
$Khata_1359_ke_anusar = '--';
$Gata_1359_ke_anusar = '--';
$Shreni_1359_ke_anusar = '--';
$Area_1359_ke_anusar = '--';
?>

<!-- <div class="cellDiv col1">
<?php echo $village_name; ?>
</div> -->
<div class="cellDiv table-body col1">
    <?php echo $khata_no; ?>
</div>
<div class="cellDiv table-body col2">
    <?php echo $gata_no; ?>
</div>
<div class="cellDiv table-body col3">
    <?php echo $shreni; ?>
</div>
<div class="cellDiv table-body col4" name="<?php echo $row['Area']; ?>">
    <?php echo $gata_ka_rakba; ?>
</div>
<div class="cellDiv table-body col5" name="<?php echo $row['RakbaA']; ?>">
    <?php echo $gata_ka_rakba_acre; ?>
</div>
<div class="cellDiv col6">
    <?php echo $Kashtkar_Ka_Name; ?>
</div>
<div class="cellDiv col7">
    <?php echo $Kashtkar_Ka_father_Name; ?>
</div>
<!-- <div class="cellDiv col8" name="<?php echo $Kashtkar_Ka_area; ?>">
<?php echo $Kashtkar_Ka_area; ?>
</div> -->
<!-- <div class="cellDiv col9">
<?php echo $ans_huai_ya_nhi; ?>
   </div> -->
<div class="cellDiv col8">
    <div class="mahal_dpdn">
        <select name="cars" class="mahal_1359 ">
            <option value="">Select Mahal Name</option>
            <?php foreach ($mahal_data_array as $key => $mrow) { ?>
                <option value="<?php echo $mrow['MahalName']; ?>" <?php echo $mrow['MahalName'] == $mahal_name ? 'selected' : ''; ?>><?php echo $mrow['MahalName']; ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="cellDiv col9">
    <div class="khata_dpdn">
        <select name="khata_1359" class="khata_1359">
            <option value="">Select Khata</option>
            <?php
            foreach ($khataInfo as $key => $value) {
                ?>
                <option value="<?php echo $value['KhataNo']; ?>" <?php echo $value['KhataNo'] == $khata_no_1359 ? 'selected' : ''; ?>><?php echo $value['KhataNo']; ?></option>
                <?php }
            ?>
        </select>
    </div>
</div>
<div class="cellDiv col10" name="<?php echo $Gata_1359_ke_anusar; ?>">
    <div class="gata_dpdn">
        <select name="gata_1359" class="gata_1359">
            <option value="">Select Gata</option>
            <?php
            foreach ($gataInfo as $key => $value) {
                ?>
                <option value="<?php echo $value['GataNo']; ?>" <?php echo $value['GataNo'] == $gata_no_1359 ? 'selected' : ''; ?>><?php echo $value['GataNo']; ?></option>
                <?php
            }
            ?>
        </select>
    </div>
</div>
<div class="cellDiv col11">
    <div class="save_btn">
        <a style="cursor:pointer;" id="<?php echo encryptIt($row['ID']); ?>" class="save_rtk_mapping_data save-btn">save</a>
    </div>
</div>
<input type="hidden" name="village_code" class="village_code_class" value="<?php echo $village_id; ?>">