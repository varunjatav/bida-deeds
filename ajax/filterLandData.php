<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/permission.core.php';
include_once '../core/landDataList.core.php';
include_once '../languages/' . $lang_file;
if ($total_count == 0) {
    ?>
    <div class="blank-widget">
        <a>No Data Found</a>
    </div>
<?php } else { ?>
    <div id="paginate-body" style="display: contents;">
        <?php
        $srno = 0;
        while ($row = $sql->fetch()) {
            $srno++;
            $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
            $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
            $khata_no = $row['KhataNo'] ? $row['KhataNo'] : '--';
            $area = $row['Area'] ? $row['Area'] : '--';
            $rakba_h = $row['RakbaH'] ? $row['RakbaH'] : '--';
            $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
            $mahal_ka_name = $row['MahalKaName'] ? $row['MahalKaName'] : '--';
            $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
            $kashtkar_darj_stithi = $row['KashtkarDarjStithi'] ? $row['KashtkarDarjStithi'] : '--';
            $unique_id = $row['UniqueID'] ? $row['UniqueID'] : '--';
            $vivran = $row['Vivran'] ? $row['Vivran'] : '--';
            ?>
            <div class="rowDiv <?php echo $validate_color; ?>">
                <div class="cellDiv col1" name="<?php echo $srno; ?>">
                    <?php echo $srno; ?>
                </div>
                <div class="cellDiv col2">
                    <?php echo $village_name; ?>
                </div>
                <div class="cellDiv col3">
                    <?php echo $mahal_ka_name; ?>
                </div>
                <div class="cellDiv col4">
                    <?php echo $shreni; ?>
                </div>
                <div class="cellDiv col5" name="<?php echo $khata_no; ?>">
                    <?php echo $khata_no; ?>
                </div>
                <div class="cellDiv col6">
                    <?php echo $kashtkar_darj_stithi; ?>
                </div>
                <div class="cellDiv col7">
                    <?php echo $gata_no; ?>
                </div>
                <div class="cellDiv col8" name="<?php echo $row['Area']; ?>">
                    <?php echo $area; ?>
                </div>
                <div class="cellDiv col9" name="<?php echo $row['RakbaH']; ?>">
                    <?php echo $rakba_h; ?>
                </div>
                <div class="cellDiv col10">
                    <?php echo $vivran; ?>
                </div>
                <div class="cellDiv cellDivacts col10">
                    <div class="posrel tblactns">
                        <a style="cursor:pointer;" class="showAction">
                            <img src="img/more-vertical-dark.svg" alt="" height="18px">
                        </a>
                        <div class="posabsolut nwactdrops" style="display:none;">
                            <a style="cursor:pointer;" class="edit_file" id="<?php echo encryptIt(myUrlEncode($row['ID'])); ?>" 
                               uid="<?php echo encryptIt(myUrlEncode($row['UniqueID'])); ?>"
                               vicode="<?php echo encryptIt(myUrlEncode($row['VillageCode'])); ?>">
                                   <?php echo $master_data_details['edit']; ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
    }
    ?>
</div>
<?php
if ($output) {
    ?>
    <div class="pagination">
        <div class="left rsltpp">
            <div class="rsl-hding left">Result Per Page</div>
            <div class="rsl-counter left posrel">
                <a style="cursor:pointer;" class="perPage">100</a>
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
        <input type="hidden" id="pagelimit" autocomplete="off" value="100">
        <input type="hidden" id="srno" autocomplete="off" value="<?php echo $srno; ?>">
        <div class="clr"></div>
    </div>
    <?php
}
?>
<input type="hidden" name="total_count" id="total_count" value="<?php echo $total_count; ?>" autocomplete="off">