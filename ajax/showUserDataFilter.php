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
                            <a style="cursor:pointer;" id="1" class="ftab active">Name</a>
                            <a style="cursor:pointer;" id="2" class="ftab">User Name</a>
                            <a style="cursor:pointer;" id="3" class="ftab">Email</a>
                            <a style="cursor:pointer;" id="4" class="ftab">Gender</a>
                            <a style="cursor:pointer;" id="5" class="ftab">Designation</a>
                            <a style="cursor:pointer;" id="6" class="ftab">Address</a>
                            <a style="cursor:pointer;" id="7" class="ftab">Mobile No</a>
                        </div>

                        <div class="left filter-taboptions">
                            <div class="tab1" id="stab_1" style="border: none;">
                                <div class="frm-lbl-actv">Name :</div>
                                <input type="text" name="name" class="frm-txtbox dept-frm-input apply_filter_keyup" maxlenth="20" placeholder="Name" autocomplete="off">
                            </div>

                            <div class="tab1" id="stab_2" style="display:none; border: none;">
                                <div class="frm-lbl-actv">User Name :</div>
                                <input type="text" name="user_name" class="frm-txtbox dept-frm-input apply_filter_keyup" maxlenth="20" placeholder="User Name" autocomplete="off">
                            </div>

                            <div class="tab1" id="stab_3" style="display:none; border: none;">
                                <div class="frm-lbl-actv">Email :</div>
                                <input type="text" name="email" class="frm-txtbox dept-frm-input apply_filter_keyup" maxlenth="20" placeholder="Email" autocomplete="off">
                            </div>

                            <div class="tab1" id="stab_4" style="display:none; border: none;">
                                <div class="filter-choice">
                                    <div class="frm-lbl-actv" style="margin-bottom: 5px;">Select Gender:</div>
                                    <div class="select dev_req_msg left rmarg">
                                        <select name="gender" id="Gender" class="apply_filter_change">
                                            <option value="">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                        <div class="select__arrow"></div>
                                    </div>
                                </div>
                            </div>

                           

                            <div class="tab1" id="stab_5" style="display:none; border: none;">
                                <div class="frm-lbl-actv">Designation :</div>
                                <input type="text" name="designation" class="frm-txtbox dept-frm-input apply_filter_keyup" maxlenth="20" placeholder="Designation" autocomplete="off">
                            </div>

                            <div class="tab1" id="stab_6" style="display:none; border: none;">
                                <div class="frm-lbl-actv">Address :</div>
                                <input type="text" name="address" class="frm-txtbox dept-frm-input apply_filter_keyup" maxlenth="20" placeholder="Address" autocomplete="off">
                            </div>
                            <div class="tab1" id="stab_7" style="display:none; border: none;">
                                <div class="frm-lbl-actv">Mobile No :</div>
                                <input type="text" class="frm-txtbox dept-frm-input apply_filter_keyup" name="mobile_no"
                                maxlength="10" placeholder="Your Mobile No*" autocomplete="off">
                            </div>
                    </div>
                    <input type="hidden" id="nav" name="status" value="<?php echo $_REQUEST['status']; ?>" autocomplete="off">
                    <input type="hidden" id="sorting_database" class="sorting_database" name="sorting_database" value="" autocomplete="off">
                </form>
            </div>
        </div>
    </div>
</div>