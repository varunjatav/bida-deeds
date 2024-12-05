<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/dimentionAmount.core.php';
?>

<div class="form-field-wrap posrel"  id="dimention_amount" style="margin-top: 6px">
    <div class="posabsolut frm-lbl-actv title-text-name">एक वृक्ष का मूल्य</div>
    <div class="form-type dev_req_msg">
        <input type="text" class="frm-txtbox dept-frm-input integer fldrequired dimention_amount"name="dimention_amount[]"
               maxlength="4" placeholder="एक वृक्ष का मूल्य" value="₹ <?php echo $treeAmountInfo['TreeValue']; ?>" readonly autocomplete="off">
    </div>
    <div class="frm-er-msg"></div>
</div>
