<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../functions/common.query.function.php';
include_once '../core/fasliLandVillage.core.php';
include_once '../core/permission.core.php';
include_once '../languages/' . $lang_file;
?>
<div class="popup-overlay">
    <div class="popup-wrap pp-medium-x">
        <div class="popup-header" style="cursor: move;">
            <span class="popup-title text-wrapping left"><?php echo $common_name['s_apply']; ?></span>
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
                            <a style="cursor:pointer;" id="1" class="ftab active"><?php echo $landmaster_filter_popup['khata_no']; ?></a>
                            <!--<a style="cursor:pointer;" id="2" class="ftab"><?php echo $landmaster_filter_popup['shreni']; ?></a>-->
                            <a style="cursor:pointer;" id="3" class="ftab"><?php echo $landmaster_filter_popup['gata_wise']; ?></a>
                            <a style="cursor:pointer;" id="4" class="ftab"><?php echo $rtk_data_list['mahal_name']; ?></a>
                            <a style="cursor:pointer;" id="5" class="ftab"><?php echo $rtk_data_list['khata_1359_anusar']; ?></a>
                            <a style="cursor:pointer;" id="6" class="ftab"><?php echo $rtk_data_list['gata_1359_anusar']; ?></a>
                        </div>

                        <div class="left filter-taboptions">
                            <div class="tab1" id="stab_1" style="border: none;">
                                <div class="frm-lbl-actv"><?php echo $landmaster_filter_popup['khata_no']; ?>:</div>
                                <input type="text" name="khata_no" class="frm-txtbox dept-frm-input apply_filter_keyup integer" maxlenth="20" placeholder="<?php echo $landmaster_filter_popup['khata_no']; ?>" autocomplete="off">
                            </div>
                            <!--                            <div class="tab1" id="stab_2" style="display:none; border: none;">
                                                            <div class="frm-lbl-actv"><?php echo $landmaster_filter_popup['shreni']; ?>:</div>
                                                            <div class="select dev_req_msg left rmarg">
                                                                <select name="shreni" class="apply_filter_change">
                                                                    <option value=""><?php echo $edit_master_data_details['select_shreni_1359']; ?></option>
                            <?php foreach ($sherni_list_1359_array as $value) { ?>
                                                                            <option value="<?php echo $value; ?>">
                                <?php echo $value; ?>
                                                                            </option>
                            <?php } ?>
                                                                </select>
                                                                <div class="select__arrow"></div>
                                                            </div>
                                                        </div>-->
                            <div class="tab1" id="stab_3" style="display:none; border: none;">
                                <div class="frm-lbl-actv"><?php echo $land_data_list['gata_no']; ?>:</div>
                                <input type="text" name="village_gata" class="frm-txtbox dept-frm-input apply_filter_keyup integer" maxlenth="20" placeholder="<?php echo $land_data_list['gata_no']; ?>" autocomplete="off">
                            </div>
                            <div class="tab1" id="stab_4" style="display:none; border: none;">
                                <div class="filter-choice">
                                    <div class="frm-lbl-actv" style="margin-bottom: 5px;"><?php echo $rtk_data_list['mahal_name']; ?>:</div>
                                    <div class="select dev_req_msg left rmarg">
                                        <select name="mahal_name" id="mahal_name" class="apply_filter_change">
                                            <option value=""><?php echo $rtk_data_list['mahal_name']; ?></option>
                                            <?php foreach ($mahal_data_array as $sKey => $sValue) { ?>
                                                <option value="<?php echo $sValue['MahalName']; ?>"><?php echo $sValue['MahalName']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="select__arrow"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab1" id="stab_5" style="display:none; border: none;">
                                <div class="frm-lbl-actv"><?php echo $rtk_data_list['khata_1359_anusar']; ?>:</div>
                                <input type="text" name="khata_1359_anusar" class="frm-txtbox dept-frm-input apply_filter_keyup integer" maxlenth="20" placeholder="<?php echo $rtk_data_list['khata_1359_anusar']; ?>" autocomplete="off">
                            </div>

                            <div class="tab1" id="stab_6" style="display:none; border: none;">
                                <div class="frm-lbl-actv"><?php echo $rtk_data_list['gata_1359_anusar']; ?>:</div>
                                <input type="text" name="gata_1359_anusar" class="frm-txtbox dept-frm-input apply_filter_keyup integer" maxlenth="20" placeholder="<?php echo $rtk_data_list['gata_1359_anusar']; ?>" autocomplete="off">
                            </div>                            
                        </div>
                        <div class="clr"></div>
                    </div>
                    <input type="hidden" id="nav" name="status" value="<?php echo $_REQUEST['status']; ?>" autocomplete="off">
                    <input type="hidden" id="sorting_database" class="sorting_database" name="sorting_database" value="" autocomplete="off">
                </form>
            </div>
        </div>
    </div>
</div>
