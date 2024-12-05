<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/bainamaReport.core.php';
?>
<style type="text/css">
    .cellDivHeader p {
        font-size: 16px;
        font-weight: 600;
    }
</style>
<div class="rowDivHeader">
    <div class="cellDivHeader">
        <p>क्रo सo</p>
    </div>
    <div class="cellDivHeader">
        <p>बैनामा के सम्बन्ध में</p>
    </div>
    <div class="cellDivHeader">
        <p>रिजल्ट</p>
    </div>
</div>
<div id="main-body" style="display: contents; font-size: 16px;">
    <div id="paginate-body" style="display: contents;">
        <div class="rowDiv">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                ऐसे बैनामे, जहाँ गाटों का दर निर्धारण नहीं हुआ
            </div>
            <div class="cellDiv col3">
                <a style="cursor:pointer;" class="view_report_data" id="report_data_23"><?php echo $answer_28; ?></a>
            </div>
        </div>
        <div class="rowDiv">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                ऐसे बैनामे, जहाँ दर निर्धारण से ज्यादा भुगतान हो गया है
            </div>
            <div class="cellDiv col3">
                <a style="cursor:pointer;" class="view_report_data" id="report_data_24"><?php echo $answer_29; ?></a>
            </div>
        </div>
        <div class="rowDiv">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                ऐसे बैनामे, जहाँ एक ही काश्तकार का एक ही गाटा पर एक से ज्यादा बार बैनामा हुआ है
            </div>
            <div class="cellDiv col3">
                <a style="cursor:pointer;" class="view_report_data" id="report_data_25"><?php echo $answer_30; ?></a>
            </div>
        </div>
        <div class="rowDiv">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                ऐसे बैनामे, जिनमें तितिम्मा हुआ है
            </div>
            <div class="cellDiv col3">
                <a style="cursor:pointer;" class="view_report_data" id="report_data_26"><?php echo $answer_31; ?></a>
            </div>
        </div>
    </div>
</div>