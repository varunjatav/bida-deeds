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
            <span class="popup-title text-wrapping">Change Password</span>
        </div>
        <div id="popupDiv">
            <div class="popup-body">
                <form id="frm">
                    <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv">Current Password*</div>
                        <div class="form-type dev_req_msg">
                            <input type="password" class="frm-txtbox dept-frm-input fldrequired" name="crpass" maxlength="20" id="crpass" placeholder="Current Password">
                        </div>
                        <div class="frm-er-msg"></div>
                    </div>

                    <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv">New Password*</div>
                        <div class="form-type dev_req_msg">
                            <input type="password" class="frm-txtbox dept-frm-input fldrequired" name="pass" id="pass" maxlength="20" placeholder="New Password">
                        </div>
                        <div class="frm-er-msg"></div>
                        <div class="frm-file-specs">
                            <p>Must contain a case sensitive, numeric & special character</p>
                        </div>
                    </div>

                    <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv">Confirm New Password*</div>
                        <div class="form-type dev_req_msg">
                            <input type="password" class="frm-txtbox dept-frm-input fldrequired" name="cpass" id="cpass" maxlength="20" placeholder="Confirm New Password">
                        </div>
                        <div class="frm-er-msg"></div>
                    </div>
                </form>
            </div>
            <div class="popup-actionwrap posrel">
                <div class="posabsolut act_btn_ovrly"></div>
                <a style="cursor: pointer;" id="save_password" class="pp-primact right">Save</a>
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