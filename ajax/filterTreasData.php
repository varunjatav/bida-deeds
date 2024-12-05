<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/treasReport.core.php';
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
            ?>
            <div class="rowDiv">
                <div class="cellDiv col1">
                    <?php echo $srno; ?>
                </div>
                <div class="cellDiv col2">
                    <?php echo $row['KashtkarName'] ? $row['KashtkarName'] : "--"; ?>
                </div>
                <div class="cellDiv col3">
                    <?php echo $row['BankIFSC'] ? $row['BankIFSC'] : "--"; ?>
                </div>
                <div class="cellDiv col4">
                    <?php echo $row['AccountNo'] ? $row['AccountNo'] : "--"; ?>
                </div>
                <div class="cellDiv col5">
                    <?php echo $row['PaymentDate'] ? $row['PaymentDate'] : '--'; ?>
                </div>
                <div class="cellDiv col6">
                    <?php echo $row['Amount'] ? $row['Amount'] : '--'; ?>
                </div>
                <div class="cellDiv col7">
                    <?php echo $row['BankStatus'] == '1' ? 'Paid' : '--'; ?>
                </div>
                <div class="cellDiv col8">
                    <?php echo $row['TxnNo'] ? $row['TxnNo'] : '--'; ?>
                </div>
                <div class="cellDiv col9">
                    <?php echo $row['DateCreated'] ? date('d-m-Y', $row['DateCreated']) : '--'; ?>
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