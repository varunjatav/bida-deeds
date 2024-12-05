<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
?>
<div class="popup-overlay">
    <div class="popup-wrap pp-small-x">
        <div class="popup-header" style="cursor: move;">
            <span class="popup-title text-wrapping">Add new Kashtkar</span>
        </div>
        <div id="popupDiv">
            <div class="popup-body">
                <form id="kfrm">
                    <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv" style="font-size: 16px; font-weight: 600;">Khata No: <?php echo $_GET['khata_no']; ?></div>
                        <div class="frm-er-msg"></div>
                    </div>
                    <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv" style="font-size: 16px; font-weight: 600;">Gata No: <?php echo $_GET['gata_name']; ?></div>
                        <div class="frm-er-msg"></div>
                    </div>
                    <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv">Kashtkar Name*</div>
                        <div class="form-type dev_req_msg">
                            <input type="text" class="frm-txtbox dept-frm-input fldrequired" name="kashtkar" maxlength="45" placeholder="Kashtkar Name">
                        </div>
                        <div class="frm-er-msg"></div>
                    </div>
                    <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv">Kashtkar Father Name*</div>
                        <div class="form-type dev_req_msg">
                            <input type="text" class="frm-txtbox dept-frm-input fldrequired" name="kashtkar_father" maxlength="45" placeholder="Kashtkar Father Name">
                        </div>
                        <div class="frm-er-msg"></div>
                    </div>
                    <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv">Area*</div>
                        <div class="form-type dev_req_msg">
                            <input type="text" class="frm-txtbox dept-frm-input fldrequired numeric" name="area" maxlength="10" placeholder="Area">
                        </div>
                        <div class="frm-er-msg"></div>
                    </div>
                    <input type="hidden" name="village_code" value="<?php echo $_GET['village_code']; ?>" autocomplete="off">
                    <input type="hidden" name="gata_no" value="<?php echo $_GET['gata_no']; ?>" autocomplete="off">
                    <input type="hidden" name="khata_no" value="<?php echo $_GET['khata_no']; ?>" autocomplete="off">
                </form>
            </div>
            <div class="popup-actionwrap posrel">
                <div class="posabsolut act_btn_ovrly"></div>
                <a style="cursor: pointer;" id="save_kashtkar" class="pp-primact right">Save</a>
                <a style="cursor: pointer;" id="cancel_popup" class="pp-secact right">Close</a>
                <div class="clr"></div>
            </div>
        </div>
        <div id="popup_conf_msg" style="display: none;">
            <div class="popup-body cnfrm-task redtxt"></div>
            <div class="popup-actionwrap"></div>
        </div>
    </div>
</div>