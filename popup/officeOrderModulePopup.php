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
            <span class="popup-title text-wrapping left">Add New Office Order</span>
            <span class="popup-close right">
                <a style="cursor:pointer;" id="cancel_popup">
                    <img src="img/clear-w.svg" alt="" width="18px">
                </a>
            </span>
            <div class="clr"></div>
        </div>
        <div id="popupDiv">
            <div class="popup-body pp-large-y">
                <form id="pfrm">
                    <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv">Select Order Date*</div>
                        <div class="form-type dev_req_msg">
                            <input type="text" class="frm-txtbox dept-frm-input fldrequired spdate"name="order_month"
                                   placeholder="Select order Date*" autocomplete="off">
                        </div>
                        <div class="frm-er-msg"></div>
                    </div>

                    <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv">Enter Subject*</div>
                        <div class="form-type dev_req_msg">
                            <textarea class="str-txarea frm-txarea fldrequired" name="subject" maxlength="750" placeholder="Enter Subject" autocomplete="off" style="height: 50px;"></textarea>
                        </div>
                        <div class="frm-er-msg"></div>
                    </div>
                    <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv">Enter Order No*</div>
                        <div class="form-type dev_req_msg">
                            <input type="text" class="frm-txtbox dept-frm-input fldrequired" maxlength="25" name="order_no"
                                   placeholder="Enter Order No*" autocomplete="off">
                        </div>
                        <div class="frm-er-msg"></div>
                    </div>
                    <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv">Enter Order Issuing Authority*</div>
                        <div class="form-type dev_req_msg">
                            <textarea class="str-txarea frm-txarea fldrequired" name="issue_authority" maxlength="250" placeholder="Enter Order Issuing Authority" autocomplete="off" style="height: 50px;"></textarea>
                        </div>
                        <div class="frm-er-msg"></div>
                    </div>
                    <div style="position:relative">
                        <div class="form_div dev_req_msg" style="margin-bottom:20px">
                            <div class="upload left brPic" style="margin-right:15px; cursor: pointer;">
                                <div class="upload-img left" style="margin-right:20px">
                                    <img src="img/fileupload.svg" alt="upload files">
                                </div>
                                <div class="upload-stt left">
                                    <span>Click here to upload order</span>
                                    <span>Maximum size : 100 MB each</span>
                                    <span style="color: blue;margin-left:28px;margin-bottom: 5px" class="hide"
                                          id="office_order"></span>
                                    <div class="frm-er-msg" style="margin-left:22px"></div>
                                </div>
                            </div>
                            <input type="file" style="display:none" id="file" class="browsePic" accept="application/pdf" multiple name="order_file">
                            <div class="clr"></div>
                        </div>
                        <div class="frm-er-msg" style="position:absolute;top:44px;left:95px;"></div>
                    </div>
                    <div class="frm_hidden_data"></div>
                </form>
            </div>
            <div class="popup-actionwrap posrel">
                <div class="posabsolut act_btn_ovrly"></div>
                <a style="cursor: pointer;" id="add_office_order" class="pp-primact right">Save</a>
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