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
            <span class="popup-title text-wrapping">Submit Report</span>
        </div>
        <div id="popupDiv">
            <div class="popup-body">
                <form id="pfrm">
                    <div class="form-field-wrap posrel">
                        <div class="upldfilediv">
                            <div class="form_div dev_req_msg posrel">
                                <div class="upload left brPic" style="margin-right:15px;">
                                    <div class="upload-img left" style="margin-right:10px;">
                                        <img src="img/upload_file.svg" width="30" alt="upload files">
                                    </div>
                                    <div class="upload-stt left">
                                        <span class="upldfilediv_bmarg">Click here to select report</span>
                                        <span class="upldfilediv_file_txt"></span>
                                        <div class="frm-er-msg" style="margin-left:22px"></div>
                                    </div>
                                </div>
                                <input type="file" style="display:none" class="browsePic" accept="application/pdf" name="griev_report[]">
                                <div class="clr"></div>
                            </div>
                            <div class="frm-er-msg" style="position:absolute;top:44px;left:95px;"></div>
                        </div>
                        <div class="frm-er-msg"></div>
                    </div>

                    <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv"></div>
                        <div class="form-type dev_req_msg">
                            <textarea class="str-txarea frm-txarea" data-maxlength="320" placeholder="Remarks (if any)" oninput="validateMaxlength(0)" onpaste="return false;" ondrop="return false;" name="remarks" id="message_txt"></textarea>
                            <div class="frm-er-msg"></div>
                        </div>
                    </div>
                    <span><i class="msg_txt" style="color:red;">* 320 characters remaining.</i></span>
                    <input type="hidden" name="griev_id" value="<?php echo myUrlEncode($_GET['id']); ?>" autocomplete="off">
                    <div class="frm_hidden_data"></div>
                </form>
            </div>
            <div class="popup-actionwrap posrel">
                <div class="posabsolut act_btn_ovrly"></div>
                <a style="cursor: pointer;" id="submit_grievance_report" class="pp-primact right">Save</a>
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