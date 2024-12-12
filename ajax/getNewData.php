<?php
   include_once '../config.php';
   include_once '../includes/checkSession.php';
   include_once '../includes/get_time_zone.php';
   include_once '../dbcon/db_connect.php';
   include_once '../functions/common.function.php';
   //include_once '../core/propertType.core.php';
   ?>
<div class="change_tree_append index" style="display: flex;   margin-top: 25px;">
    <div class="form-field-wrap posrel left">
        <div class="posabsolut frm-lbl-actv">गाटा संख्या*</div>
        <div class="form-type dev_req_msg">
            <input type="text" class="frm-txtbox dept-frm-input fldrequired" name="gata_no[]" maxlength="100"
                placeholder="गाटा संख्या*" autocomplete="off">
        </div>
        <div class="frm-er-msg"></div>
    </div>
    <div class="form-field-wrap posrel left">
        <div class="posabsolut frm-lbl-actv">रकबा*</div>
        <div class="form-type dev_req_msg">
            <input type="text" class="frm-txtbox dept-frm-input numeric fldrequired" name="rakba[]" maxlength="10"
                placeholder="रकबा*" autocomplete="off">
        </div>
        <div class="frm-er-msg"></div>
    </div>
    <div class="form-field-wrap posrel left">
        <div class="posabsolut frm-lbl-actv">विवरण*</div>
        <div class="select dev_req_msg left rmarg vivran_parent" id="villageDropdown">
            <div class="dropdown-header posrel" id="dropdownHeader">विवरण चुनें <span
                    class="dropdown-arrow">&#9662;</span></div>
            <div class="dropdown-content">
                <?php foreach ($kismList_1359_array as $dKey => $dValue) { ?>
                <div class="checkbox-wrapper">
                    <input type="checkbox" name="vivran[]" value="<?php echo $dValue; ?>"
                        class="fldrequired village-dropdown">
                    <label for="<?php $dKey; ?>"><?php echo $dValue; ?></label>
                </div>
                <?php } ?>
            </div>
            <input type="hidden" name="vivran_data[]" class="vivran_data" value="">
        </div>
    </div>
    <div class="posrel left lmarg" style="width:28px; height:28px; top:4px; right:-8px;">
        <div class="upldfilediv_crs rm_parisampatti_div" title="Remove">
            <div style="position: relative;">
                <img src="img/close_remove.svg">
            </div>
        </div>
    </div>
    <div class="frm-er-msg"></div>
</div>