<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/village.core.php';
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
            <div class="popup-body pp-large-y">
                <form id="ffrm">
                    <div class="filter-box">
                        <div class="filter-tabber left">
                            <a style="cursor:pointer;" id="1" class="ftab active">Village</a>
                            <a style="cursor:pointer;" id="2" class="ftab">Vilekh Sankhya</a>
                            <a style="cursor:pointer;" id="3" class="ftab">Rakba</a>
                            <a style="cursor:pointer;" id="4" class="ftab">Bainama Date</a>
                            <!--<a style="cursor:pointer;" id="5" class="ftab">Patravali Status</a>-->
                            <a style="cursor:pointer;" id="6" class="ftab">Unfilled Bainama</a>
                            <a style="cursor:pointer;" id="7" class="ftab">Payment Approval Date</a>
                            <a style="cursor:pointer;" id="8" class="ftab">Payment Done</a>
                            <a style="cursor:pointer;" id="9" class="ftab">Unmatched Data</a>
                        </div>

                        <div class="left filter-taboptions">
                            <div class="tab1" id="stab_1" style="border: none;">
                                <div class="filter-choice">
                                    <div class="frm-lbl-actv" style="margin-bottom: 5px;">Select Village:</div>
                                    <div class="select dev_req_msg left rmarg">
                                        <select name="village_code" class="apply_filter_change">
                                            <option value="">Select Village</option>
                                            <?php foreach ($villageInfo as $sKey => $sValue) { ?>
                                                <option value="<?php echo $sValue['VillageCode']; ?>"><?php echo $sValue['VillageName']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="select__arrow"></div>
                                    </div>
                                    <div class="clr"></div>
                                </div>
                            </div>
                            <div class="tab1" id="stab_2" style="display:none; border: none;">
                                <div class="frm-lbl-actv">Vilekh Sankhya:</div>
                                <input type="text" name="vilekh" class="frm-txtbox dept-frm-input apply_filter_keyup" maxlenth="100" placeholder="Enter vilekh sankhya" autocomplete="off">
                            </div>
                            <div class="tab1" id="stab_3" style="display:none; border: none;">
                                <div class="frm-lbl-actv">Rakba:</div>
                                <input type="text" name="rakba" class="frm-txtbox dept-frm-input apply_filter_keyup" maxlenth="100" placeholder="Enter rakba" autocomplete="off">
                            </div>
                            <div class="tab1" id="stab_4" style="display:none; border: none;">
                                <div class="form-field-wrap posrel">
                                    <div class="frm-lbl-actv">Start Date:</div>
                                    <input type="text" name="sdate" class="frm-txtbox dept-frm-input spbdate" maxlenth="100" placeholder="Enter start date" autocomplete="off">
                                </div>
                                <div class="form-field-wrap posrel">
                                    <div class="frm-lbl-actv">End Date:</div>
                                    <input type="text" name="edate" class="frm-txtbox dept-frm-input spbedate apply_filter_change" maxlenth="100" placeholder="Enter end date" autocomplete="off">
                                </div>
                            </div>
                            <!--<div class="tab1" id="stab_5" style="display:none; border: none;">
                                <div class="frm-lbl-actv" style="margin-bottom: 5px;">Select Patravali Status:</div>
                                <div class="select dev_req_msg left rmarg">
                                    <select name="pstatus" class="apply_filter_change">
                                        <option value="">All</option>
                                        <option value="6">SLAO के पास</option>
                                        <option value="2">बंधक पत्रावली (RK Shukla)</option>
                                        <option value="3">बंजर पत्रावली (Gulab Singh & Lalit)</option>
                                        <option value="4">तितिम्मा पत्रावली (Lal Krishna)</option>
                                        <option value="1">तहसील के पास (Gulab Singh & Lalit)</option>
                                        <option value="5">पेमेंट हो चुका</option>
                                    </select>
                                    <div class="select__arrow"></div>
                                </div>
                                <div class="clr"></div>
                            </div>-->
                            <div class="tab1" id="stab_6" style="display:none; border: none;">
                                <div class="frm-lbl-actv" style="margin-bottom: 5px;">Select:</div>
                                <div class="select dev_req_msg left rmarg">
                                    <select name="entry" class="apply_filter_change">
                                        <option value="">All</option>
                                        <option value="1">Entry Filled</option>
                                        <option value="2">Entry Left</option>
                                    </select>
                                    <div class="select__arrow"></div>
                                </div>
                                <div class="clr"></div>
                            </div>
                            <div class="tab1" id="stab_7" style="display:none; border: none;">
                                <div class="form-field-wrap posrel">
                                    <div class="frm-lbl-actv">Start Date:</div>
                                    <input type="text" name="spsdate" class="frm-txtbox dept-frm-input spbdate" maxlenth="100" placeholder="Enter start date" autocomplete="off">
                                </div>
                                <div class="form-field-wrap posrel">
                                    <div class="frm-lbl-actv">End Date:</div>
                                    <input type="text" name="spedate" class="frm-txtbox dept-frm-input spbedate apply_filter_change" maxlenth="100" placeholder="Enter end date" autocomplete="off">
                                </div>
                            </div>
                            <div class="tab1" id="stab_8" style="display:none; border: none;">
                                <div class="filter-choice">
                                    <div class="frm-lbl-actv" style="margin-bottom: 5px;">Select:</div>
                                    <div class="select dev_req_msg left rmarg">
                                        <select name="pmtstatus" class="apply_filter_change">
                                            <option value="">Select</option>
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                        </select>
                                        <div class="select__arrow"></div>
                                    </div>
                                    <div class="clr"></div>
                                </div>
                            </div>
                            <div class="tab1" id="stab_9" style="display:none; border: none;">
                                <div class="filter-choice">
                                    <div class="frm-lbl-actv" style="margin-bottom: 5px;">Select:</div>
                                    <div class="select dev_req_msg left rmarg">
                                        <select name="unmatched_data" class="apply_filter_change">
                                            <option value="">Select</option>
                                            <option value="1">Bainama amount is not equal to (Land + Parisampatti)</option>
                                            <option value="2">Payment amount is not equal to Bainama amount</option>
                                            <option value="3">Empty bainama date</option>
                                            <option value="4">Payment amount filled but payment date empty</option>
                                            <option value="5">Empty vilekh sankhya</option>
                                            <option value="6">Bainama area not filled</option>
                                            <option value="7">Bainama area is not equal to sum of ansh rakba</option>
                                        </select>
                                        <div class="select__arrow"></div>
                                    </div>
                                    <div class="clr"></div>
                                </div>
                            </div>
                        </div>
                        <div class="clr"></div>
                    </div>
                    <input type="hidden" id="sort_by" name="sort_by" value="<?php echo $_REQUEST['sort_by']; ?>" autocomplete="off">
                </form>
            </div>
        </div>
    </div>
</div>