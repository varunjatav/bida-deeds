<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.query.function.php';
include_once '../functions/common.function.php';
include_once '../core/permission.core.php';
include_once '../core/rtkFasliDataList.core.php';
include_once '../languages/' . $lang_file;
if ($total_count) {
    ?>
    <div id="paginate-body" style="display: contents;">
        <?php
        $srno = 0;
        while ($row = $sql->fetch()) {
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
            <div class="rowDiv <?php echo $validate_color; ?>">
                <!-- <div class="cellDiv col1">
                <?php echo $village_name; ?>
                </div> -->
                <div class="cellDiv table-body col1" name="<?php echo $row['KhataNo']; ?>">
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
                    <?php if ($row['MahalName']) { ?>
                        <?php echo $row['MahalName']; ?>
                    <?php } else { ?>
                        <div class="mahal_dpdn">
                            <select name="cars" class="mahal_1359 ">
                                <option value="">Select Mahal Name</option>
                                <?php foreach ($mahal_data_array as $key => $mrow) { ?>
                                    <option value="<?php echo $mrow['MahalName']; ?>"><?php echo $mrow['MahalName']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } ?>
                </div>
                <div class="cellDiv col9">
                    <?php if ($row['1359_fasli_khata']) { ?>
                        <?php echo $row['1359_fasli_khata']; ?>
                    <?php } else { ?>
                        <div class="khata_dpdn">
                            <select name="khata_1359" class="khata_1359">
                                <option value="">Select Khata</option>
                            </select>
                        </div>
                    <?php } ?>
                </div>
                <div class="cellDiv col10" name="<?php echo $Gata_1359_ke_anusar; ?>">
                    <?php if ($row['1359_fasli_gata']) { ?>
                        <?php echo $row['1359_fasli_gata']; ?>
                    <?php } else { ?>
                        <div class="gata_dpdn">
                            <select name="gata_1359" class="gata_1359">
                                <option value="">Select Gata</option>
                            </select>
                        </div>
                    <?php } ?>
                </div>

                <?php if ($row['MahalName'] == '' || $row['1359_fasli_gata'] == '' || $row['1359_fasli_khata'] == '') { ?>
                    <div class="cellDiv col13">
                        <div class="save_btn">
                            <a style="cursor:pointer;" id="<?php echo encryptIt($row['ID']); ?>" class="save_rtk_mapping_data save-btn">save</a>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="cellDiv col13">
                        <div class="edit_btn">
                            <a style="cursor:pointer;" id="<?php echo encryptIt($row['ID']); ?>" class="edit_rtk_1359_data edit-btn">Edit</a>
                        </div>
                    </div>
                <?php } ?>
                <input type="hidden" name="village_code" class="village_code_class" value="<?php echo $village_code; ?>">
                <?php if ($lang_file == 'lang.en.php') { ?>
                    <input type="hidden" class="village_name_class" value="<?php echo $row['VillageName']; ?>">
                <?php } else { ?>
                    <input type="hidden" class="village_name_class" value="<?php echo $row['VillageNameHi']; ?>">
                <?php } ?>
            </div>
            <?php
        }
        ?>
    </div>
    <div class="pagination">
        <div class="left rsltpp">
            <div class="rsl-hding left">Result Per Page</div>
            <div class="rsl-counter left posrel">
                <a style="cursor:pointer;" class="perPage"><?php echo $limit; ?></a>
                <ul class="posabsolut" style="display: none;">
                    <li><a style="cursor:pointer;" class="setPage">1000</a></li>
                    <li><a style="cursor:pointer;" class="setPage">500</a></li>
                    <li><a style="cursor:pointer;" class="setPage">200</a></li>
                    <li><a style="cursor:pointer;" class="setPage">100</a></li>
                    <li><a style="cursor:pointer;" class="setPage">50</a></li>
                </ul>
            </div>
            <div class="clr"></div>
        </div>
        <div class="right pgntn">
            <?php echo $output; ?>
            <div class="clr"></div>
        </div>
        <input type="hidden" id="pagelimit" autocomplete="off" value="<?php echo $limit; ?>">
        <input type="hidden" id="srno" autocomplete="off" value="<?php echo $srno; ?>">
        <input type="hidden" id="sorting_database" name="sorting_database" value="<?php echo $_REQUEST['sorting_database']; ?>" autocomplete="off">
        <div class="clr"></div>
    </div>
    <?php
} else {
    echo '';
}