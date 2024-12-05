<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/parisampattiModule.core.php';
if ($total_count) {
    ?>
    <div id="paginate-body" style="display: contents;">
        <?php
        foreach ($parisamInfo as $peky => $row) {

            if ($row['DifferentAmountType'] == '1') {
                $row_color = 'row-highlight-yellow';
            } else {
                $row_color = '';
            }
            $total_dimenAmt = $surveyAmount[$row['ID']]['total_dimenAmt'] ? $surveyAmount[$row['ID']]['total_dimenAmt'] : 0;

            $manual_amt = $surveyAmount[$row['ID']]['manual_amt'] ? $surveyAmount[$row['ID']]['manual_amt'] : 0;
            ?>
            <div class="rowDiv <?php echo $row_color; ?>">
                <div class="cellDiv col1">
                    <?php echo $row['DepartmentName'] ? $row['DepartmentName'] : '--'; ?>
                </div>
                <div class="cellDiv col2">
                    <?php echo $row['VillageName'] ? $row['VillageName'] : '--'; ?>
                </div>
                <div class="cellDiv col3">
                    <?php echo $row['GataNo'] ? $row['GataNo'] : '--'; ?>
                </div>
                <div class="cellDiv col4">
                    <?php echo $row['KhataNo'] ? $row['KhataNo'] : '--'; ?>
                </div>
                <div class="cellDiv col5" name="<?php echo $row['DateCreated']; ?>">
                    <a style="cursor:pointer; color: blue;" class="parisamaptti_details" id="<?php echo encryptIt($row['ID']); ?>" village_name="<?php echo $row['VillageName']; ?>" gata_no="<?php echo $row['GataNo']; ?>" khata_no="<?php echo $row['KhataNo']; ?>" department_name="<?php echo $row['DepartmentName']; ?>">
                        <?php echo 'Count (' . ($row['PropertyCount'] ? $row['PropertyCount'] : 0) . ')'; ?>
                    </a>
                </div>
                <div class="cellDiv col6" name="<?php echo $total_dimenAmt; ?>">
                    <?php echo format_rupees($total_dimenAmt); ?>
                </div>
                <div class="cellDiv col7" name="<?php echo $manual_amt; ?>">
                    <?php echo format_rupees($manual_amt); ?>
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