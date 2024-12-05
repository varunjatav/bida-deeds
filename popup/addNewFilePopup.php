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
            <span class="popup-title text-wrapping">Add New File</span>
        </div>
        <div id="popupDiv">
            <div class="popup-body pp-large-y">
                <form id="pfrm">
                    <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv">Department Name*</div>
                        <div class="form-type dev_req_msg">
                            <input type="text" class="frm-txtbox dept-frm-input fldrequired"name="department_name"
                                   maxlength="100" placeholder="Department Name*" autocomplete="off">
                        </div>
                        <div class="frm-er-msg"></div>
                    </div>
                    <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv">File No*</div>
                        <div class="form-type dev_req_msg">
                            <input type="text" class="frm-txtbox dept-frm-input fldrequired" maxlength="100" name="file_no"
                                   placeholder="File No*" autocomplete="off">
                        </div>
                        <div class="frm-er-msg"></div>
                    </div>
                    <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv">Name*</div>
                        <div class="form-type dev_req_msg">
                            <input type="text" class="frm-txtbox dept-frm-input fldrequired" maxlength="100" name="name"
                                   placeholder="Name*" autocomplete="off">
                        </div>
                        <div class="frm-er-msg"></div>
                    </div>
                    <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv">Subject*</div>
                        <div class="popup_msg dev_req_msg">
                            <textarea name="subject" class="str-txarea fldrequired" cols="67" rows="5" maxlength="750" placeholder="Enter your subject here..." autocomplete="off" style="width: 370px;"></textarea>
                        </div>
                        <div class="frm-er-msg"></div>
                    </div>
                    <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv">Folder Name For Note Sheet</div>
                        <div class="form-type dev_req_msg">
                            <input type="text" class="frm-txtbox dept-frm-input" maxlength="100" name="folder_name"
                                   placeholder="Folder Name For Note Sheet" autocomplete="off">
                        </div>
                        <div class="frm-er-msg"></div>
                    </div>
                    <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv">File Creator*</div>
                        <div class="form-type dev_req_msg">
                            <input type="text" class="frm-txtbox dept-frm-input fldrequired" maxlength="100" name="file_creator"
                                   placeholder="File Creator*" autocomplete="off">
                        </div>
                        <div class="frm-er-msg"></div>
                    </div>
                    <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv">Select Status*</div>
                        <div class="select dev_req_msg left rmarg">
                            <select name="status" id="status" >
                                <option value="1">Active</option>
                                <option value="0">Inactive</option> 
                            </select>
                            <div class="select__arrow"></div>
                        </div>
                        <div class="frm-er-msg"></div>
                    </div>
                    <div class="frm_hidden_data"></div>
                </form>
            </div>
            <div class="popup-actionwrap posrel">
                <div class="posabsolut act_btn_ovrly"></div>
                <a style="cursor: pointer;" id="add_file" class="pp-primact right">Save</a>
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