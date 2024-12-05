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
            <span class="popup-title text-wrapping">Update Patravali Status</span>
        </div>
        <div id="popupDiv">
            <div class="popup-body">
                <form id="kfrm">
                    <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv" style="font-size: 16px; font-weight: 600;">Village Name: <?php echo $_GET['village']; ?></div>
                        <div class="frm-er-msg"></div>
                    </div>
                    <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv" style="font-size: 15px; font-weight:500;">Rakba: <?php echo $_GET['rakba']; ?></div>
                        <div class="frm-er-msg"></div>
                    </div>
                    <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv" style="font-size: 15px; font-weight: 500;">Bainama Date: <?php echo $_GET['date']; ?></div>
                        <div class="frm-er-msg"></div>
                    </div>
                    <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv" style="font-size: 15px; font-weight: 500;">Vilekh Sankhya: <?php echo $_GET['vilekh']; ?></div>
                        <div class="frm-er-msg"></div>
                    </div>
                    <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv" style="font-size: 15px; font-weight: 500;">Bainama Amount: <?php echo $_GET['amount']; ?></div>
                        <div class="frm-er-msg"></div>
                    </div>
                    <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv">Patravali Status*</div>
                        <div class="ebasta_select dev_req_msg left rmarg">
                            <select name="status" id="status">
                                <option value="">Select</option>
                                <option value="1">तहसील के पास (Gulab Singh & Lalit)</option>
                                <option value="2">बंधक पत्रावली (RK Shukla)</option>
                                <option value="3">बंजर पत्रावली (Gulab singh & Lalit)</option>
                                <option value="4">तितिम्मा पत्रावली (Lal Krishna)</option>
                                <option value="5">पेमेंट हो चुका</option>
                                <option value="6">SLAO के पास</option>
                            </select>
                            <div class="ebasta_select__arrow"></div>
                        </div>
                        <div class="frm-er-msg"></div>
                    </div>

                    <input type="hidden" id="ebasta_id" value="<?php echo myUrlEncode($_GET['id']); ?>" autocomplete="off">
                </form>
            </div>
            <div class="popup-actionwrap posrel">
                <div class="posabsolut act_btn_ovrly"></div>
                <a style="cursor: pointer;" id="update_patravali" class="pp-primact right">Save</a>
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