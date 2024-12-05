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
            <div class="popup-body pp-medium-y">
                <form id="ffrm">
                    <div class="filter-box">
                        <div class="filter-tabber left">
                            <a style="cursor:pointer;" id="1" class="ftab active">Village Wise</a>
                            <a style="cursor:pointer;" id="2" class="ftab">Gata Wise</a>
                            <a style="cursor:pointer;" id="3" class="ftab">Khata No</a>
                            <a style="cursor:pointer;" id="4" class="ftab">Status</a>
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
                                <div class="filter-choice">
                                    <div class="frm-lbl-actv" style="margin-bottom: 5px;">Select Village:</div>
                                    <div class="select dev_req_msg left rmarg">
                                        <select id="village_code">
                                            <option value="">Select Village</option>
                                            <?php foreach ($villageInfo as $sKey => $sValue) { ?>
                                                <option value="<?php echo $sValue['VillageCode']; ?>"><?php echo $sValue['VillageName']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="select__arrow"></div>
                                    </div>
                                    <div class="clr"></div>
                                </div>
                                <div class="filter-choice">
                                    <div class="frm-lbl-actv" style="margin-bottom: 5px;">Select Gata:</div>
                                    <div class="select dev_req_msg left rmarg">
                                        <select name="village_gata" id="village_gata" class="apply_filter_change">
                                            <option value="">Select Gata</option>
                                        </select>
                                        <div class="select__arrow"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab1" id="stab_3" style="display:none; border: none;">
                                <div class="frm-lbl-actv">Khata No:</div>
                                <input type="text" name="khata_no" class="frm-txtbox dept-frm-input apply_filter_keyup" maxlenth="20" placeholder="Enter khata number" autocomplete="off">
                            </div>
                            <div class="tab1" id="stab_4" style="display:none; border: none;">
                                <div class="frm-lbl-actv" style="margin-bottom: 5px;">Status:</div>
                                <div class="select dev_req_msg left rmarg">
                                    <select id="griev_status" name="griev_status" class="apply_filter_change">
                                        <option value="">Select Status</option>
                                        <option value="1">Solved</option>
                                        <option value="0">Pending</option>
                                    </select>
                                    <div class="select__arrow"></div>
                                </div>
                            </div>
                        </div>
                        <div class="clr"></div>
                    </div>
                    <input type="hidden" id="nav" name="status" value="<?php echo $_REQUEST['status']; ?>" autocomplete="off">
                </form>
            </div>
        </div>
    </div>
</div>