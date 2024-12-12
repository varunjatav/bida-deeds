<?php
   include_once '../config.php';
   include_once '../includes/checkSession.php';
   include_once '../includes/get_time_zone.php';
   include_once '../dbcon/db_connect.php';
   include_once '../functions/common.function.php';
   //include_once '../core/propertType.core.php';
   ?>
<div class="change_tree_append" style="margin-top: 25px;">
    <div style="display: flex; margin-top:10px;">
        <div class="form-field-wrap posrel">
            <div class="posabsolut frm-lbl-actv">1) Name*</div>
            <div class="select dev_req_msg left rmarg">

                <input type="text" class="frm-txtbox fldrequired" name="name" maxlength="100" placeholder="Your Name*"
                    autocomplete="off">

            </div>
            <div class="frm-er-msg"></div>
            <div class="clr"></div>
        </div>
        <div class="form-field-wrap posrel">
            <div class="posabsolut frm-lbl-actv">2) Mobile*</div>
            <div class="select dev_req_msg left rmarg">
                <input type="text" class="frm-txtbox dept-frm-input fldrequired" name="mobile_no" maxlength="10"
                    placeholder="Your Mobile No*" autocomplete="off">
            </div>
            <div class="frm-er-msg"></div>
            <div class="clr"></div>
        </div>
        <div class="form-field-wrap posrel">
            <div class="posabsolut frm-lbl-actv">3) Gender*</div>
            <div class="" style=" display:flex; justify-content:left; align-items:center; flex-direction:column">
                <div style="display:flex; justify-content:left; align-items:center; width: 100px;">
                    <input type="radio" name="gender" id="gender_male" value="male">
                    <label for="gender_male">Male</label>
                </div>
                <div style=" display:flex; justify-content:left; align-items:center; width: 100px;">
                    <input type="radio" name="gender" id="gender_female" value="female">
                    <label for="gender_female">Female</label>
                </div>
                <div style=" display:flex; justify-content:left; align-items:center;  width: 100px;">
                    <input type="radio" name="gender" id="gender_other" value="other">
                    <label for="gender_other">Other</label>
                </div>
            </div>
            <div class="frm-er-msg"></div>
            <div class="clr"></div>
        </div>
        <div class="form-field-wrap posrel">
            <div class="posabsolut frm-lbl-actv">4) DOB*</div>
            <div class="form-type dev_req_msg">
                <input type="date" class="frm-txtbox dept-frm-input integer fldrequired" name="date" autocomplete="off">
            </div>
            <div class="frm-er-msg"></div>
            <div class="clr"></div>
        </div>
        <div class="form-field-wrap posrel">
            <div class="posabsolut frm-lbl-actv">5) Email*</div>
            <div class="select dev_req_msg left rmarg" style="width: 100%;">
                <input type="email" class="frm-txtbox fldrequired" name="email" maxlength="20" placeholder="Your Email*"
                    autocomplete="off">
            </div>
            <div class="frm-er-msg"></div>
            <div class="clr"></div>
        </div>
        <div class="form-field-wrap posrel">
            <div class="posabsolut frm-lbl-actv">6) PAN*</div>
            <div class="select dev_req_msg left rmarg">

                <input type="text" class="frm-txtbox fldrequired" name="name" maxlength="100"
                    placeholder="Your PAN Card No*" autocomplete="off">

            </div>
            <div class="frm-er-msg"></div>
            <div class="clr"></div>
        </div>
        <div class="form-field-wrap posrel">
            <div class="posabsolut frm-lbl-actv">7) Adhaar*</div>
            <div class="select dev_req_msg left rmarg">
                <input type="text" class="frm-txtbox dept-frm-input fldrequired" name="mobile_no" maxlength="100"
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
                <input type="text" class="frm-txtbox dept-frm-input fldrequired" name="address" maxlength="100"
                    placeholder="Your Address*" autocomplete="off">
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

                <input type="file" class="frm-txtbox fldrequired" name="document" autocomplete="off">

            </div>
            <div class="frm-er-msg"></div>
            <div class="clr"></div>
        </div>
        <div class="form-field-wrap posrel left">
            <div class="posabsolut frm-lbl-actv">Profile*</div>
            <div class="form-type dev_req_msg">
                <input type="file" class="frm-txtbox fldrequired" name="profle" autocomplete="off">
            </div>
            <div class="frm-er-msg"></div>
        </div>
        <div class="form-field-wrap posrel left">
            <div class="posabsolut frm-lbl-actv">Branch*</div>
            <div class="select dev_req_msg left rmarg vivran_parent" id="villageDropdown">
                <div class="dropdown-header posrel" id="dropdownHeader">Choose Branch<span
                        class="dropdown-arrow">&#9662;</span></div>
                <div class="dropdown-content">

                    <div class="checkbox-wrapper">
                        <input type="checkbox" name="branch" value="banking" class="fldrequired village-dropdown">
                        <label for="banking">Banking</label>
                    </div>
                    <div class="checkbox-wrapper">
                        <input type="checkbox" name="branch" value="banking" class="fldrequired village-dropdown">
                        <label for="banking">Banking</label>
                    </div>
                    <div class="checkbox-wrapper">
                        <input type="checkbox" name="branch" value="banking" class="fldrequired village-dropdown">
                        <label for="banking">Banking</label>
                    </div>

                </div>
                <input type="hidden" name="vivran_data[]" class="vivran_data" value="">
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