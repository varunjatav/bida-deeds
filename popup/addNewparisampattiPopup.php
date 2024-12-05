<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/parisampattiModulePopup.core.php';
?>
<div class="popup-overlay">
    <div class="popup-wrap pp-large-x">
        <div class="popup-header" style="cursor: move;">
                <span class="popup-title text-wrapping left">Add Parisampatti</span>
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
                    <div class="card_item">
                        <div style="display: flex;">
                            <div class="form-field-wrap posrel">
                                <div class="posabsolut frm-lbl-actv">विभाग चुनें*</div>
                                <div class="select dev_req_msg left rmarg">
                                    <select name="department" class="form-select fldrequired department">
                                        <option value="">विभाग चुनें</option>
                                        <?php foreach ($deptInfo as $dKey => $dValue) { ?>
                                            <option value="<?php echo $dValue['ID'] . '@BIDA' . $dValue['DepartmentType']; ?>">
                                                <?php echo $dValue['DepartmentName']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <div class="select__arrow"></div>
                                </div>
                                <div class="frm-er-msg"></div>
                                <div class="clr"></div>
                            </div>
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
                                <div class="posabsolut frm-lbl-actv">काश्तकार चुनें</div>
                                <div class="select dev_req_msg left rmarg">
                                    <select name="kashtkar" class="form-select kashtkar" id="griev_kashtkar">
                                        <option value="">काश्तकार चुनें</option>
                                    </select>
                                    <div class="select__arrow"></div>
                                </div>
                                <div class="frm-er-msg"></div>
                                <div class="clr"></div>
                            </div>
                        </div>
                        <div class="property_type"></div>
                        <div class="hide left rmarg" id="add_more_hide">
                            <a id="add_more_prisampatti" style="cursor: pointer; font-size: 14px; line-height: 40px; font-weight: 500; color: blue;">+ Add more</a>
                        </div>
                    </div>
                    <div class="frm_hidden_data"></div>
                </form>
            </div>
            <div class="popup-actionwrap posrel">
                <div class="posabsolut act_btn_ovrly"></div>
                <a style="cursor: pointer;" id="add_parisampatti" class="pp-primact right">Save</a>
                <a style="cursor: pointer;" id="cancel_popup" class="pp-secact right">Close</a>
                <div class="clr"></div>
            </div>
        </div>
        <div id="popup_conf_msg" style="display: none;">
            <div class="popup-body cnfrm-task"></div>
            <div class="popup-actionwrap"></div>
        </div>
    </div>
</div>