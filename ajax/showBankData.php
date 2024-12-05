<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
?>
<div class="popup-overlay">
    <div class="popup-wrap pp-medium-x">
        <div class="popup-header" style="cursor: move;">
            <span class="popup-title text-wrapping left">Select filters to apply</span>
            <span class="popup-close right">
                <a style="cursor: pointer;" id="cancelFilter">
                    <img src="img/clear-w.svg" alt="" width="18px">
                </a>
            </span>
            <div class="clr"></div>
        </div>
        <div id="popupDiv">
            <div class="popup-body pp-medium-y">
                <form id="ffrm">
                    <div class="filter-box">
                        <div class="filter-tabber left">
                            <a style="cursor:pointer;" id="1" class="ftab">Kashtkar Name</a>
                            <a style="cursor:pointer;" id="2" class="ftab">Bank IFSC</a>
                            <a style="cursor:pointer;" id="3" class="ftab">Account No</a>
                            <a style="cursor:pointer;" id="4" class="ftab">Txn No</a>
                        </div>

                        <div class="left filter-taboptions">
                            <div class="tab1" id="stab_1" style="border: none;">
                                <div class="frm-lbl-actv">Kashtkar Name:</div>
                                <input type="text" name="kashtkar" class="frm-txtbox dept-frm-input apply_filter_keyup" maxlenth="100" placeholder="Enter kashtkar name" autocomplete="off">
                            </div>
                            <div class="tab1" id="stab_2" style="display:none; border: none;">
                                <div class="frm-lbl-actv">Bank IFSC:</div>
                                <input type="text" name="ifsc" class="frm-txtbox dept-frm-input apply_filter_keyup" maxlenth="100" placeholder="Enter bank ifsc" autocomplete="off">
                            </div>
                            <div class="tab1" id="stab_3" style="display:none; border: none;">
                                <div class="frm-lbl-actv">Account No:</div>
                                <input type="text" name="acc_no" class="frm-txtbox dept-frm-input apply_filter_keyup" maxlenth="45" placeholder="Enter account number" autocomplete="off">
                            </div>
                            <div class="tab1" id="stab_4" style="display:none; border: none;">
                                <div class="frm-lbl-actv">Txn No:</div>
                                <input type="text" name="txn_no" class="frm-txtbox dept-frm-input apply_filter_keyup" maxlenth="20" placeholder="Enter txn number" autocomplete="off">
                            </div>
                        </div>
                        <div class="clr"></div>
                    </div>
                    <input type="hidden" id="nav" name="status" value="<?php echo $_REQUEST['status']; ?>" autocomplete="off">
                </form>
            </div>
        </div>
    </div>
</div>