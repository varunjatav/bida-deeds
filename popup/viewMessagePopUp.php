<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
?>
<div class="popup-overlay">
    <form id="frm">
        <div class="popup-wrap pp-small-x">
            <div id="popupDiv">
                <div class="popup-header">
                    <span class="popup-title left text-wrapping"><?php echo $_GET['title']; ?></span>
                    <span class="popup-close right">
                        <a style="cursor: pointer;" id="cancel_popup">
                            <img src="img/clear-w.svg" alt="" width="18px">
                        </a>
                    </span>
                    <div class="clr"></div>
                </div>

                <div class="popup-body pp-small-y">
                    <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv"></div>
                        <div class="form-type dev_req_msg">
                            <b>Message:</b> <?php echo nl2br($_GET['message']); ?>
                        </div>
                    </div>
                    <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv"></div>
                        <div class="form-type dev_req_msg">
                            <b>Date:</b> <?php echo nl2br($_GET['message_date']); ?>
                        </div>
                    </div>
                </div>
                <div class="popup-actionwrap posrel">
                    <div class="posabsolut act_btn_ovrly"></div>
                    <a style="cursor: pointer;" id="cancel_popup" class="pp-secact right cancel">Cancel</a>
                    <div class="clr"></div>
                </div>
            </div>
            <div id="popup_conf_msg" style="display: none;">
                <div class="popup-body cnfrm-task"></div>
                <div class="popup-actionwrap"></div>
            </div>
        </div>
    </form>
</div>