<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/bankReport.core.php';
if ($total_count) {
    ?>
    <div id="paginate-body" style="display: contents;">
        <?php
        //$srno = 0;
        while ($row = $sql->fetch()) {
            $srno++;
            ?>
            <div class="rowDiv">
                <label>
                    <div class="cellDiv">
                        <input type="checkbox" class="selct_data chk_box_20" value="<?php echo $row['ID']; ?>" name="<?php echo $row['TxnNo']; ?>">
                    </div>
                </label>
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
                <div class="cellDiv cellDivacts">
                    <div class="posrel tblactns">
                        <a style="cursor:pointer;" class="showAction">
                            <img src="img/more-vertical-dark.svg" alt="" height="18px">
                        </a>
                        <div class="posabsolut nwactdrops" style="display:none;">
                            <a style="cursor: pointer;" id="<?php echo encryptIt($row['ID']); ?>" name="<?php echo encryptIt($row['TxnNo']); ?>" class="delete_bank_data text-wrapping">Delete</a>
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