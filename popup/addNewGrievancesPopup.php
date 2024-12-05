<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/grievance.core.php';
?>
<div class="popup-overlay">
    <div class="popup-wrap pp-small-x">
        <div class="popup-header" style="cursor: move;">
            <span class="popup-title text-wrapping">Add Offline Grievances</span>
        </div>
        <div id="popupDiv">
            <div class="popup-body pp-large-y">
                <form id="pfrm">
                    <div class="card_item">
                        <div class="form-field-wrap posrel">
                            <div class="posabsolut frm-lbl-actv">गाँव चुनें*</div>
                            <div class="select dev_req_msg left rmarg">
                                <select name="village_code" Class="fldrequired village_code">
                                    <option value="">गाँव चुनें</option>
                                    <?php foreach ($villageInfo as $dKey => $dValue) { ?>
                                        <option value="<?php echo $dValue['VillageCode']; ?>">
                                            <?php echo $dValue['VillageName']; ?> (<?php echo $dValue['VillageNameHi']; ?>)
                                        </option>
                                    <?php } ?>
                                </select>
                                <div class="select__arrow"></div>
                            </div>
                            <div class="frm-er-msg"></div>
                            <div class="clr"></div>
                        </div>
                        <div class="form-field-wrap posrel">
                            <div class="posabsolut frm-lbl-actv">गाटा चुनें*</div>
                            <div class="select dev_req_msg left rmarg">
                                <select name="gata_no" class="fldrequired village_gata">
                                    <option value="">गाटा चुनें</option>
                                </select>
                                <div class="select__arrow"></div>
                            </div>
                            <div class="frm-er-msg"></div>
                            <div class="clr"></div>
                        </div>
                        <div class="form-field-wrap posrel">
                            <div class="posabsolut frm-lbl-actv">खाता चुनें*</div>
                            <div class="select dev_req_msg left rmarg">
                                <select name="khata_no" class="fldrequired village_khata">
                                    <option value="">खाता चुनें</option>
                                </select>
                                <div class="select__arrow"></div>
                            </div>
                            <div class="frm-er-msg"></div>
                            <div class="clr"></div>
                        </div>
                        <div class="form-field-wrap posrel">
                            <div class="posabsolut frm-lbl-actv">काश्तकार चुनें*</div>
                            <div class="select dev_req_msg left rmarg">
                                <select name="kashtkar" class="form-select fldrequired kashtkar" id="griev_kashtkar">
                                    <option value="">काश्तकार चुनें</option>
                                </select>
                                <div class="select__arrow"></div>
                            </div>
                            <div class="frm-er-msg"></div>
                            <div class="clr"></div>
                        </div>
                        <div class="new_kashtkar"></div>
                        <div class="form-field-wrap posrel">
                            <div class="posabsolut frm-lbl-actv">मोबाइल नम्बर  डालें</div>
                            <div class="form-type dev_req_msg">
                                <input type="text" class="frm-txtbox dept-frm-input integer"name="mobile"
                                       maxlength="10" placeholder="मोबाइल नम्बर  डालें" autocomplete="off">
                            </div>
                            <div class="frm-er-msg"></div>
                        </div>
                        <div class="form-field-wrap posrel">
                            <div class="posabsolut frm-lbl-actv">शिकायत चुनें*</div>
                            <div class="select dev_req_msg left rmarg">
                                <select name="type" class="form-select fldrequired type">
                                    <option value="">शिकायत चुनें</option>
                                    <?php foreach ($grievInfo as $dKey => $dValue) { ?>
                                        <option value="<?php echo $dValue['ID']; ?>">
                                            <?php echo $dValue['Type']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <div class="select__arrow"></div>
                            </div>
                            <div class="frm-er-msg"></div>
                            <div class="clr"></div>
                        </div>
                        <div style="position:relative">
                            <div class="form_div dev_req_msg" style="margin-bottom:20px">
                                <div class="upload left brPic1" style="margin-right:15px; cursor: pointer;">
                                    <div class="upload-img left" style="margin-right:20px">
                                        <img src="img/fileupload.svg" alt="upload files">
                                    </div>
                                    <div class="upload-stt left">
                                        <span>Click here to upload</span>
                                        <span>Maximum size : 100 MB each</span>
                                        <span style="color: blue;margin-left:28px;margin-bottom: 5px" class="hide"
                                              id="grievances_file"></span>
                                        <div class="frm-er-msg" style="margin-left:22px"></div>
                                    </div>
                                </div>
                                <input type="file" style="display:none" id="file"
                                       class="browsePic1"
                                       accept="application/pdf" multiple
                                       name="grievances_file">
                                <div class="clr"></div>
                            </div>
                            <div class="frm-er-msg" style="position:absolute;top:44px;left:95px;"></div>
                        </div>
                    </div>
                    <div class="frm_hidden_data"></div>
                </form>
            </div>
            <div class="popup-actionwrap posrel">
                <div class="posabsolut act_btn_ovrly"></div>
                <a style="cursor: pointer;" id="add_grievances" class="pp-primact right">Save</a>
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