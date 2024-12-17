<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
//include_once '../core/propertType.core.php';
?>
<div class="change_tree_append index" style="margin-top: 25px;">
    <div style="display: flex; margin-top:10px;">
        <div class="form-field-wrap posrel">
            <div class="posabsolut frm-lbl-actv">1) Name*</div>
            <div class="select dev_req_msg left rmarg">

                <input type="text" class="frm-txtbox fldrequired" name="name[]" maxlength="100" placeholder="Your Name*"
                    autocomplete="off">

            </div>
            <div class="frm-er-msg"></div>
            <div class="clr"></div>
        </div>
        <div class="form-field-wrap posrel">
            <div class="posabsolut frm-lbl-actv">2) Mobile*</div>
            <div class="select dev_req_msg left rmarg">
                <input type="text" class="frm-txtbox dept-frm-input fldrequired" name="mobile[]" maxlength="10"
                    placeholder="Your Mobile No*" autocomplete="off">
            </div>
            <div class="frm-er-msg"></div>
            <div class="clr"></div>
        </div>
        <div class="form-field-wrap posrel">
            <div class="posabsolut frm-lbl-actv">3) Gender*</div>
            <div class="select dev_req_msg left rmarg" style="width: 100%;">
                <select name="gender[]" class="form-select fldrequired" id="">
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
                <input type="date" class="frm-txtbox dept-frm-input integer fldrequired" name="dob[]" autocomplete="off">
            </div>
            <div class="frm-er-msg"></div>
            <div class="clr"></div>
        </div>
        <div class="form-field-wrap posrel">
            <div class="posabsolut frm-lbl-actv">5) Email*</div>
            <div class="select dev_req_msg left rmarg" style="width: 100%;">
                <input type="email" class="frm-txtbox fldrequired" name="email[]" maxlength="100" placeholder="Your Email*"
                    autocomplete="off">
            </div>
            <div class="frm-er-msg"></div>
            <div class="clr"></div>
        </div>
        <div class="form-field-wrap posrel">
            <div class="posabsolut frm-lbl-actv">6) PAN*</div>
            <div class="select dev_req_msg left rmarg">

                <input type="text" class="frm-txtbox fldrequired" name="pan[]" maxlength="100"
                    placeholder="Your PAN Card No*" autocomplete="off">

            </div>
            <div class="frm-er-msg"></div>
            <div class="clr"></div>
        </div>
        <div class="form-field-wrap posrel">
            <div class="posabsolut frm-lbl-actv">7) Adhaar*</div>
            <div class="select dev_req_msg left rmarg">
                <input type="text" class="frm-txtbox dept-frm-input fldrequired" name="adhaar[]" maxlength="100"
                    placeholder="Your Adhaar No*" autocomplete="off">
            </div>
            <div class="frm-er-msg"></div>
            <div class="clr"></div>
        </div>
    </div>
    <div style="display: flex; margin-top:10px;">


        <div class="form-field-wrap posrel">
            <div class="posabsolut frm-lbl-actv">8) Address*</div>
            <div class="select dev_req_msg left rmarg" style="width: 100%;">
                <input type="text" class="frm-txtbox dept-frm-input fldrequired" name="address[]" maxlength="100"
                    placeholder="Your Address*" autocomplete="off">
            </div>
            <div class="frm-er-msg"></div>
            <div class="clr"></div>
        </div>
        <div class="form-field-wrap posrel">
            <div class="posabsolut frm-lbl-actv">9) City*</div>
            <div class="form-type dev_req_msg">
                <select name="city[]" class="fldrequired">
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
                <select name="pincode[]" class="fldrequired village_gata">
                    <option value="">Pincodes*</option>

                    <option value="284001">
                        284001
                    </option>
                    <option value="284002">
                        284002
                    </option>
                    <option value="284003">
                        284003
                    </option>
                    <option value="284004">
                        284004
                    </option>
                    <option value="284005">
                        284005
                    </option>

                </select>
            </div>
            <div class="frm-er-msg"></div>
            <div class="clr"></div>
        </div>
        <div class="form-field-wrap posrel left">
            <div class="posabsolut frm-lbl-actv">11) Document*</div>
            <div class="form-type dev_req_msg">

                <input type="file" class="frm-txtbox fldrequired" name="document[]" id="file"
                    accept="image/jpg,image/jpeg, image/png,.doc,.docx,.pdf" multiple autocomplete="off">


            </div>
            <div class="frm-er-msg"></div>
            <div class="clr"></div>
        </div>
        <div class="form-field-wrap posrel left">
            <div class="posabsolut frm-lbl-actv">12)Profile*</div>
            <div class="form-type dev_req_msg">
                <input type="file" class="frm-txtbox fldrequired" name="profile[]" autocomplete="off">
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
    <div class="clr"></div>
    <div class="posrel left lmarg" style="width:28px; height:28px; top:4px; right:-8px;">
        <div class="upldfilediv_crs rm_parisampatti_div" title="Remove">
            <div style="position: relative;">
                <img src="img/close_remove.svg">
            </div>
        </div>
    </div>
</div>