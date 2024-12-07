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
            <div class="popup-body pp-large-y">
                <form id="ffrm">
                    <div class="filter-box">
                        <div class="filter-tabber left">
                            <a style="cursor:pointer;" id="1" class="ftab active"><?php echo 'Name'; ?></a>
                            <a style="cursor:pointer;" id="2" class="ftab"><?php echo 'User Name'; ?></a>
                            <a style="cursor:pointer;" id="3" class="ftab"><?php echo 'Email'; ?></a>
                            <a style="cursor:pointer;" id="4" class="ftab"><?php echo 'Mobile No'; ?></a>
                            <a style="cursor:pointer;" id="5" class="ftab"><?php echo 'Designation'; ?></a>
                            <a style="cursor:pointer;" id="6" class="ftab"><?php echo 'Address'; ?></a>
                            <a style="cursor:pointer;" id="7" class="ftab"><?php echo 'Gender'; ?></a>
                        </div>

                        <div class="left filter-taboptions">
                            <div class="tab1" id="stab_1" style="border: none;">
                                <div class="frm-lbl-actv"><?php echo 'Name'; ?>:</div>
                                <input type="text" name="Name" class="frm-txtbox dept-frm-input apply_filter_keyup" maxlenth="20" placeholder="<?php echo 'Name'; ?>" autocomplete="off">
                            </div>

                            <div class="tab1" id="stab_2" style="display:none; border: none;">
                                <div class="frm-lbl-actv"><?php echo 'User Name'; ?>:</div>
                                <input type="text" name="User_Name" class="frm-txtbox dept-frm-input apply_filter_keyup" maxlenth="20" placeholder="<?php echo 'User Name'; ?>" autocomplete="off">
                            </div>

                            <div class="tab1" id="stab_3" style="display:none; border: none;">
                                <div class="frm-lbl-actv"><?php echo 'Email'; ?>:</div>
                                <input type="text" name="Email" class="frm-txtbox dept-frm-input apply_filter_keyup" maxlenth="20" placeholder="<?php echo 'Email'; ?>" autocomplete="off">
                            </div>

                            <div class="tab1" id="stab_4" style="display:none; border: none;">
                                <div class="frm-lbl-actv"><?php echo 'Mobile No'; ?>:</div>
                                <input type="text" name="MobileNO" class="frm-txtbox dept-frm-input apply_filter_keyup" maxlenth="20" placeholder="<?php echo 'Mobile No'; ?>" autocomplete="off">
                            </div>

                            <div class="tab1" id="stab_5" style="display:none; border: none;">
                                <div class="frm-lbl-actv"><?php echo 'Designation'; ?>:</div>
                                <input type="text" name="Designation" class="frm-txtbox dept-frm-input apply_filter_keyup" maxlenth="20" placeholder="<?php echo 'Designation'; ?>" autocomplete="off">
                            </div>

                            <div class="tab1" id="stab_6" style="display:none; border: none;">
                                <div class="frm-lbl-actv"><?php echo 'Address'; ?>:</div>
                                <input type="text" name="Address" class="frm-txtbox dept-frm-input apply_filter_keyup" maxlenth="20" placeholder="<?php echo 'Address'; ?>" autocomplete="off">
                            </div>

                            <div class="tab1" id="stab_7" style="display:none; border: none;">
                                <div class="filter-choice">
                                    <div class="frm-lbl-actv" style="margin-bottom: 5px;"><?php echo "Select Gender"; ?>:</div>
                                    <div class="select dev_req_msg left rmarg">
                                        <select name="Gender" id="Gender" class="apply_filter_change">
                                            <option value=""><?php echo "Select Gender"; ?></option>
                                            <option value="male"><?php echo "Male"; ?></option>
                                            <option value="female"><?php echo "Female"; ?></option>
                                            <option value="other"><?php echo "Other"; ?></option>
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