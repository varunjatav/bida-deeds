<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
// include_once '../core/addNewDataPopup.core.php';
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
            <span class="popup-title text-wrapping left">Add New User Data and File</span>
            <span class="popup-close right">
                <a style="cursor:pointer;" class="cancel_popup">
                    <img src="img/clear-w.svg" alt="" width="18px">
                </a>
            </span>
            <div class="clr"></div>
        </div>
        <div id="popupDiv">
            <div class="popup-body pp-large-y">
                <form id="pfrm" enctype="multipart/form-data">
                    <div class="card_item" style="padding-bottom:50px;">

                        <div style="display: flex; margin-top:10px;">
                            <div class="form-field-wrap posrel">
                                <div class="posabsolut frm-lbl-actv">1) Name*</div>
                                <div class="select dev_req_msg left rmarg">

                                    <input type="text" class="frm-txtbox fldrequired" name="name" maxlength="100"
                                        placeholder="Your Name*" autocomplete="off">

                                </div>
                                <div class="frm-er-msg"></div>
                                <div class="clr"></div>
                            </div>
                            <div class="form-field-wrap posrel">
                                <div class="posabsolut frm-lbl-actv">2) Mobile*</div>
                                <div class="select dev_req_msg left rmarg">
                                    <input type="text" class="frm-txtbox dept-frm-input fldrequired" name="mobile"
                                        maxlength="10" placeholder="Your Mobile No*" autocomplete="off">
                                </div>
                                <div class="frm-er-msg"></div>
                                <div class="clr"></div>
                            </div>
                            <div class="form-field-wrap posrel">
                                <div class="posabsolut frm-lbl-actv">3) Gender*</div>
                                <div class="select dev_req_msg left rmarg" style="width: 100%;">
                                    <select name="gender" class="form-select fldrequired" id="">
                                        <option value="">Choose Your Gender*</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                    <div class="select__arrow"></div>
                                </div>
                                <div class="frm-er-msg"></div>
                                <div class="clr"></div>
                            </div>
                            <div class="form-field-wrap posrel">
                                <div class="posabsolut frm-lbl-actv">4) DOB*</div>
                                <div class="form-type dev_req_msg">
                                    <input type="date" class="frm-txtbox dept-frm-input integer fldrequired" name="dob"
                                        autocomplete="off">
                                </div>
                                <div class="frm-er-msg"></div>
                                <div class="clr"></div>
                            </div>
                            <div class="form-field-wrap posrel">
                                <div class="posabsolut frm-lbl-actv">5) Email*</div>
                                <div class="select dev_req_msg left rmarg" style="width: 100%;">
                                    <input type="email" class="frm-txtbox fldrequired" name="email" maxlength="20"
                                        placeholder="Your Email*" autocomplete="off">
                                </div>
                                <div class="frm-er-msg"></div>
                                <div class="clr"></div>
                            </div>
                            <div class="form-field-wrap posrel">
                                <div class="posabsolut frm-lbl-actv">6) PAN*</div>
                                <div class="select dev_req_msg left rmarg">

                                    <input type="text" class="frm-txtbox fldrequired" name="pan" maxlength="100"
                                        placeholder="Your PAN Card No*" autocomplete="off">

                                </div>
                                <div class="frm-er-msg"></div>
                                <div class="clr"></div>
                            </div>
                            <div class="form-field-wrap posrel">
                                <div class="posabsolut frm-lbl-actv">7) Adhaar*</div>
                                <div class="select dev_req_msg left rmarg">
                                    <input type="text" class="frm-txtbox dept-frm-input fldrequired" name="adhaar"
                                        maxlength="100" placeholder="Your Adhaar No*" autocomplete="off">
                                </div>
                                <div class="frm-er-msg"></div>
                                <div class="clr"></div>
                            </div>
                        </div>
                        <div style="display: flex; margin-top:10px;">


                            <div class="form-field-wrap posrel">
                                <div class="posabsolut frm-lbl-actv">8) Address*</div>
                                <div class="select dev_req_msg left rmarg" style="width: 100%;">
                                    <input type="text" class="frm-txtbox dept-frm-input fldrequired" name="address"
                                        maxlength="100" placeholder="Your Address*" autocomplete="off">
                                </div>
                                <div class="frm-er-msg"></div>
                                <div class="clr"></div>
                            </div>
                            <div class="form-field-wrap posrel">
                                <div class="posabsolut frm-lbl-actv">9) City*</div>
                                <div class="form-type dev_req_msg">
                                    <select name="city" class="fldrequired village_gata">
                                        <option value="">City*</option>

                                        <option value="delhi">
                                            Delhi
                                        </option>
                                        <option value="mumbai">
                                            Mumbai
                                        </option>
                                        <option value="Pune">
                                            Pune
                                        </option>
                                        <option value="jhansi">
                                            Jhansi
                                        </option>
                                        <option value="kanpur">
                                            Kanpur
                                        </option>

                                    </select>
                                </div>
                                <div class="frm-er-msg"></div>
                                <div class="clr"></div>
                            </div>
                            <div class="form-field-wrap posrel">
                                <div class="posabsolut frm-lbl-actv">10) Pincode*</div>
                                <div class="select dev_req_msg left rmarg" style="width: 100%;">
                                    <input type="text" class="frm-txtbox fldrequired" name="pincode" maxlength="20"
                                        placeholder="Your Pincode*" autocomplete="off">
                                </div>
                                <div class="frm-er-msg"></div>
                                <div class="clr"></div>
                            </div>
                            <div class="form-field-wrap posrel left">
                                <div class="posabsolut frm-lbl-actv">11)Document*</div>
                                <div class="form-type dev_req_msg">

                                    <input type="file" class="frm-txtbox fldrequired" name="document[]" id="file" accept="image/jpg,image/jpeg, image/png,.doc,.docx,.pdf" multiple
                                        autocomplete="off">

                                </div>
                                <div class="frm-er-msg"></div>
                                <div class="clr"></div>
                            </div>
                            <div class="form-field-wrap posrel left">
                                <div class="posabsolut frm-lbl-actv">12)Profile*</div>
                                <div class="form-type dev_req_msg">
                                    <input type="file" class="frm-txtbox fldrequired" name="profile" autocomplete="off">
                                </div>
                                <div class="frm-er-msg"></div>
                            </div>
                            <div class="form-field-wrap posrel left">
                                <div class="posabsolut frm-lbl-actv">13)Branch*</div>
                                <div class="select dev_req_msg left rmarg branch_parent" id="branchDropDown">
                                    <div class="dropdown-header posrel" id="dropdownHeader">Choose Branch<span
                                            class="dropdown-arrow">&#9662;</span></div>
                                    <div class="dropdown-content">

                                        <div class="checkbox-wrapper">
                                            <input type="checkbox" id="Finance" name="branch[]" value="Finance"
                                                class="fldrequired village-dropdown">
                                            <label for="Finance">Finance</label>
                                        </div>
                                        <div class="checkbox-wrapper">
                                            <input type="checkbox" id="Banking" name="branch[]" value="Banking"
                                                class="fldrequired village-dropdown">
                                            <label for="Banking">Banking</label>
                                        </div>
                                        <div class="checkbox-wrapper">
                                            <input type="checkbox" id="Agriculture" name="branch[]" value="Agriculture"
                                                class="fldrequired village-dropdown">
                                            <label for="Agriculture">Agriculture</label>
                                        </div>

                                    </div>
                                    <!-- <input type="hidden" name="branch[]" class="branch" value=""> -->
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="clr"></div>
                        <div class="property_type"></div>
                        <div class="left rmarg" id="add_more_hide">
                            <a id="add_more_data"
                                style="cursor: pointer; font-size: 14px; line-height: 40px; font-weight: 500; color: blue;">+
                                Add More Data</a>
                        </div>
                    </div>
                    <div class="frm_hidden_data"></div>

                    <div class="popup-actionwrap posrel">
                        <div class="posabsolut act_btn_ovrly"></div>
                        <a style="cursor: pointer;" id="add_user_data_and_file" class="pp-primact right">Save</a>
                        <a style="cursor: pointer;" id="" class="pp-secact right cancel_popup">Close</a>
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
<!-- <script src="scripts/filelistdata.js"></script> -->
<script>
$(document).ready(function() {
    function initializeDropdown() {
        $(document).on('click', '.dropdown-header', function() {
            $(this).parent().toggleClass("show");
        });

        $(document).click(function(e) {
            if (!$(e.target).closest(".select").length) {
                $(".dropdown-content").parent().removeClass("show");
            }
        });

        $(document).on('change', '.village-dropdown', function() {
            let $currentDropdown = $(this).closest('.select');
            updateDropdownHeader($currentDropdown);
        });
    }

    function updateDropdownHeader($dropdown) {
        let selectedValues = [];
        $dropdown.find('.village-dropdown:checked').each(function() {
            selectedValues.push($(this).val());
        });
        let displayText = selectedValues.length > 0 ? selectedValues.join(', ') : 'विवरण चुनें';
        $dropdown.find('.dropdown-header').text(displayText);
        $dropdown.closest('.branch_parent').find('.branch').val(displayText);
    }
    initializeDropdown();
    $('#addMoreButton').click(function() {
        let newDiv = `
                <div class="form-field-wrap posrel left">
                    <div class="posabsolut frm-lbl-actv">विवरण*</div>
                    <div class="select dev_req_msg left rmarg branchDropDown">
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
                    <input type="hidden" name="branch[]" class="branch" value="">
                    <div class="frm-er-msg"></div>
                    <div class="clr"></div>
                </div>`;
        $('.change_tree_append').append(newDiv);
        updateDropdownHeader($('.change_tree_append .select:last'));
    });
    $(document).on('shown.bs.modal', '#yourModalId', function() {
        initializeDropdown();
    });
});
</script>