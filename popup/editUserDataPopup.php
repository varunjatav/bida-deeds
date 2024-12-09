<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/editNewUserPopup.core.php';
include_once '../languages/' . $lang_file;


?>
<style>
    .dropdown-header {
        padding: 10px;
        border: 1px solid #ccc;
        background-color: white;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 4px;
    }

    .dropdown-arrow {
        font-size: 26px;
        margin-left: 10px;
        position: absolute;
        right: 0;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: white;
        border: 1px solid #ccc;
        max-height: 200px;
        overflow-y: auto;
        z-index: 1;
        width: 100%;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    .checkbox-wrapper {
        padding: 5px;
        display: flex;
        align-items: center;
    }

    .checkbox-wrapper input[type="checkbox"] {
        margin-right: 10px;
    }

    .show .dropdown-content {
        display: block;
    }

    .dept-frm-input {
        width: 161px !important;
    }

    .form-field-wrap {
        margin-right: 15px;
    }

    .village-dropdown {
        width: 29px !important;
    }

    .dropdown-content {
        left: 0 !important;
    }
</style>


<div class="popup-overlay">
  
    <div class="popup-wrap pp-large-x">
        <div class="popup-header" style="cursor: move;">
            <span class="popup-title text-wrapping left">User Data</span>
            <span class="popup-close right">
                <a style="cursor:pointer;" class="cancel_popup">
                    <img src="img/clear-w.svg" alt="" width="18px">
                </a>
            </span>
            <div class="clr"></div>
        </div>
        <div id="popupDiv">
            <div class="popup-body pp-large-y">
                <form id="pfrm">
                    <div class="card_item">
                        <div style="display: flex; margin-top:10px; flex-direction:column;">
                            <div class="form-field-wrap posrel">
                                <div class="posabsolut frm-lbl-actv">1) Name*</div>
                                <div class="select dev_req_msg left rmarg" style="width: 100%;">
                                    <input type="text" class="frm-txtbox fldrequired" name="name"
                                        maxlength="100" placeholder="Your Name*" autocomplete="off"
                                        value="<?php echo isset($userInfo['Name']) ? htmlspecialchars($userInfo['Name']) : ''; ?>">

                                </div>
                                <div class="frm-er-msg"></div>
                                <div class="clr"></div>
                            </div>
                            <div class="form-field-wrap posrel">
                                <div class="posabsolut frm-lbl-actv">2) User Name*</div>
                                <div class="select dev_req_msg left rmarg" style="width: 100%;">
                                    <input type="text" class="frm-txtbox fldrequired" name="user_name"
                                        maxlength="100" placeholder="Your User Name*" autocomplete="off" value="<?php echo isset($userInfo['User_Name']) ? htmlspecialchars($userInfo['User_Name']) : ''; ?>">
                                </div>
                                <div class="frm-er-msg"></div>
                                <div class="clr"></div>
                            </div>
                            <div class="form-field-wrap posrel">
                                <div class="posabsolut frm-lbl-actv">3) Email*</div>
                                <div class="select dev_req_msg left rmarg" style="width: 100%;">
                                    <input type="email" class="frm-txtbox fldrequired" name="email"
                                        maxlength="20" placeholder="Your Email*" autocomplete="off"
                                        value="<?php echo isset($userInfo['Email']) ? htmlspecialchars($userInfo['Email']) : ''; ?>">
                                </div>
                                <div class="frm-er-msg"></div>
                            </div>
                            <div class="form-field-wrap posrel left">
                                <div class="posabsolut frm-lbl-actv">4) Password*</div>
                                <div class="select dev_req_msg left rmarg" style="width: 100%;">
                                    <input type="password" class="frm-txtbox fldrequired" name="password"
                                        maxlength="100" placeholder="Your Password*" autocomplete="off"
                                        value="<?php echo isset($userInfo['Password']) ? htmlspecialchars($userInfo['Password']) : ''; ?>">
                                </div>
                                <div class="frm-er-msg"></div>
                            </div>
                            <div class="form-field-wrap posrel left">
                                <div class="posabsolut frm-lbl-actv">5) Confirm Password*</div>
                                <div class="select dev_req_msg left rmarg" style="width: 100%;">
                                    <input type="password" class="frm-txtbox dept-frm-input fldrequired" name="cpassword"
                                        maxlength="100" placeholder="Confirm Your Password*" autocomplete="off"
                                        value="<?php echo isset($userInfo['Confirm_Password']) ? htmlspecialchars($userInfo['Confirm_Password']) : ''; ?>">
                                </div>
                                <div class="frm-er-msg"></div>
                            </div>

                            <div class="form-field-wrap posrel">
                                <div class="posabsolut frm-lbl-actv">6) Mobile No*</div>
                                <div class="select dev_req_msg left rmarg" style="width: 100%;">
                                    <input type="text" class="frm-txtbox dept-frm-input fldrequired" name="mobile_no"
                                        maxlength="10" placeholder="Your Mobile No*" autocomplete="off"
                                        value="<?php echo isset($userInfo['Mobile_NO']) ? htmlspecialchars($userInfo['Mobile_NO']) : ''; ?>">
                                </div>
                                <div class="frm-er-msg"></div>
                                <div class="clr"></div>
                            </div>
                            <div class="form-field-wrap posrel">
                                <div class="posabsolut frm-lbl-actv">7) Designation</div>
                                <div class="select dev_req_msg left rmarg" style="width: 100%;">
                                    <input type="text" class="frm-txtbox dept-frm-input fldrequired" name="designation"
                                        maxlength="20" placeholder="Your Designation*" autocomplete="off"
                                        value="<?php echo isset($userInfo['Designation']) ? htmlspecialchars($userInfo['Designation']) : ''; ?>">
                                </div>
                                <div class="frm-er-msg"></div>
                                <div class="clr"></div>
                            </div>
                            <div class="form-field-wrap posrel left">
                                <div class="posabsolut frm-lbl-actv">8) Address*</div>
                                <div class="select dev_req_msg left rmarg" style="width: 100%;">
                                    <input type="text" class="frm-txtbox dept-frm-input fldrequired" name="address"
                                        maxlength="100" placeholder="Your Address*" autocomplete="off"
                                        value="<?php echo isset($userInfo['Address']) ? htmlspecialchars($userInfo['Address']) : ''; ?>">
                                </div>
                                <div class="frm-er-msg"></div>
                            </div>

                            <div class="form-field-wrap posrel left">
                                <div class="posabsolut frm-lbl-actv">9) Gender*</div>
                                <div style="width: 50%; display:flex; flex-direction:column; text-align:left">
                                    <div>
                                        <input type="radio" name="gender" id="gender_male" value="male"
                                            <?php echo isset($userInfo['Gender']) && $userInfo['Gender'] == 'male' ? 'checked' : ''; ?>>
                                        <label for="gender_male">Male</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="gender" id="gender_female" value="female"
                                            <?php echo isset($userInfo['Gender']) && $userInfo['Gender'] == 'female' ? 'checked' : ''; ?>>
                                        <label for="gender_female">Female</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="gender" id="gender_other" value="other"
                                            <?php echo isset($userInfo['Gender']) && $userInfo['Gender'] == 'other' ? 'checked' : ''; ?>>
                                        <label for="gender_other">Other</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $_REQUEST['file_id']; ?>">
                    <input type="hidden" name="uid" value="<?php echo $_REQUEST['file_uid']; ?>">

                    <div class="popup-actionwrap posrel">
                        <div class="posabsolut act_btn_ovrly"></div>
                        <a style="cursor: pointer;" id="edit_user_data" class="pp-primact right">Save</a>
                        <a style="cursor: pointer;" class="pp-secact right cancel_popup">Close</a>
                        <div class="clr"></div>
                    </div>
                </form>

            </div>

        </div>
        <div id="popup_conf_msg" style="display: none;">
            <div class="popup-body cnfrm-task"></div>
            <div class="popup-actionwrap"></div>
        </div>
    </div>
</div>
<!-- <script src="../scripts/jquery-ui.js"></script> -->
<!-- <script src="scripts/jquery-ui.min.js"></script>
<script src="scripts/jquery.confirm.js"></script>
<script src="scripts/common.js"></script>
<script src="scripts/userlists.js"></script> -->
<script>
    $(document).ready(function() {
        function initializeDropdownListeners() {
            $('.dropdown-header').off('click');
            $('.village-dropdown').off('change');
            $('.dropdown-header').on('click', function(e) {
                e.stopPropagation();
                $(this).parent().toggleClass("show");
                $('.select').not($(this).parent()).removeClass("show");
            });

            function updateDropdownHeader($dropdown) {
                let selectedValues = [];
                $dropdown.find('.village-dropdown:checked').each(function() {
                    selectedValues.push($(this).val());
                });
                let displayText = selectedValues.length > 0 ? selectedValues.join(', ') : 'विवरण चुनें';
                $dropdown.closest('.vivran_parent').find('.vivran_data').val(displayText); // Assuming vivran_data is hidden input
                $dropdown.find('.dropdown-header').text(displayText);
            }
            $('.village-dropdown').on('change', function() {
                let $currentDropdown = $(this).closest('.select');
                updateDropdownHeader($currentDropdown);
            });
            $(document).off('click').on('click', function(e) {
                if (!$(e.target).closest(".select").length) {
                    $(".dropdown-content").parent().removeClass("show");
                }
            });
        }
        initializeDropdownListeners();
        $('#addMoreButton').click(function() {
            let newDiv = `
            <div class="form-field-wrap posrel left">
                <div class="posabsolut frm-lbl-actv">विवरण*</div>
                <div class="select dev_req_msg left rmarg villageDropdown">
                    <div class="dropdown-header posrel">विवरण चुनें <span class="dropdown-arrow">&#9662;</span></div>
                    <div class="dropdown-content">
                        <div class="checkbox-wrapper">
                            <input type="checkbox" name="vivran[]" value="Option1" class="fldrequired village-dropdown">
                            <label for="village_code">Option 1</label>
                        </div>
                        <div class="checkbox-wrapper">
                            <input type="checkbox" name="vivran[]" value="Option2" class="fldrequired village-dropdown">
                            <label for="village_code">Option 2</label>
                        </div>
                    </div>
                </div>
                <div class="frm-er-msg"></div>
                <div class="clr"></div>
            </div>`;
            $('.change_tree_append').append(newDiv);
            initializeDropdownListeners();
        });
        $('#popup').on('shown.bs.modal', function() {
            initializeDropdownListeners();
        });
    });
</script>