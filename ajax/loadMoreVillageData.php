<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/permission.core.php';
include_once '../core/villageDataList.core.php';
include_once '../languages/' . $lang_file;
if ($total_count) {
    ?>
    <div id="paginate-body" style="display: contents;">
        <?php
        while ($row = $sql->fetch()) {
            $srno++;
            $validate_status = '--';
            $validate_color = '';
            if ($row['VerifiedStatus'] == '1') {
                $validate_status = $village_data_list['validate_status'];
                $validate_color = 'row-highlight-green';
            }
            $village_name = $row['VillageNameHi'] ? $row['VillageNameHi'] : '--';
            $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
            ?>
            <div class="rowDiv <?php echo $validate_color; ?>">
                <div class="cellDiv col1" name="<?php echo $srno; ?>">
                    <?php echo $srno; ?>
                </div>
                <div class="cellDiv col2" name="<?php echo $village_code; ?>">
                    <?php echo $village_code; ?>
                </div>
                <div class="cellDiv col3">
                    <?php echo $village_name; ?>
                </div>
                <div class="cellDiv col4" name="">
                    <?php echo $validate_status; ?>
                </div>
                <div class="cellDiv cellDivacts col5">
                    <div class="posrel tblactns">
                        <a style="cursor:pointer;" class="showAction">
                            <img src="img/more-vertical-dark.svg" alt="" height="18px">
                        </a>
                        <div class="posabsolut nwactdrops" style="display:none;">
                            <a style="cursor:pointer;" class="edit_file" id="<?php echo encryptIt(myUrlEncode($row['ID'])); ?>">
                                <?php echo $village_data_list['upload_parmar']; ?>
                            </a>
                        </div>
                    </div>
                </div>
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
        <div class="clr"></div>
    </div>
    <?php
} else {
    echo '';
}