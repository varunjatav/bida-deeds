<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/propertType.core.php';
?>
<?php
if ($department_id && $department_type == '1') {
    ?>
    <div class="change_tree_append" style="display: flex;">
        <div class="form-field-wrap posrel">
            <div class="posabsolut frm-lbl-actv">वृक्ष चुनें*</div>
            <div class="select dev_req_msg left rmarg" style=" min-width: 119px;">
                <select name="tree_id[]" Class="fldrequired tree_id">
                    <option value="">वृक्ष चुनें</option>
                    <?php foreach ($treeInfo as $tKey => $tValue) { ?>
                        <option value="<?php echo $tValue['ID']; ?>">
                            <?php echo $tValue['TreeName']; ?>
                        </option>
                    <?php } ?>
                </select>
                <div class="select__arrow"></div>
            </div>
            <div class="frm-er-msg"></div>
            <div class="clr"></div>
        </div>

        <div class="form-field-wrap posrel"  style="width: 100px;margin-right: 20px;">
            <div class="posabsolut frm-lbl-actv">उप वृक्ष चुनें*</div>
            <div class="select dev_req_msg left rmarg" style=" min-width: 119px;">
                <select name="sub_tree[]" Class="fldrequired sub_tree">
                    <option value="">उप वृक्ष चुनें</option>
                    <?php foreach ($sub_treeInfo as $sKey => $sValue) { ?>
                        <option value="<?php echo $sValue['ID']; ?>">
                            <?php echo $sValue['SubTreeName']; ?>
                        </option>
                    <?php } ?>
                </select>
                <div class="select__arrow"></div>
            </div>
            <div class="frm-er-msg"></div>
            <div class="clr"></div>
        </div>
        <div class="dimention_append" style="display: flex;">
            <div class="form-field-wrap posrel hide" id="dimention_number" style="width: 105px;margin-right: 28px;">
                <div class="posabsolut frm-lbl-actv">वृक्ष का आयाम चुनें*</div>
                <div class="select dev_req_msg left rmarg" style=" min-width: 119px;">
                    <select name="dimention_number[]" Class="fldrequired dimention_number">
                        <option value="">वृक्ष का आयाम चुनें</option>
                        <option value="1">0-1 (0-30)</option>
                        <option value="2">1-2 (31-60)</option>
                        <option value="3">2-3 (61-90)</option>
                        <option value="4">3-4 (91-120)</option>
                        <option value="5">4-5 (121-150)</option>
                        <option value="6">5-6 (151-180)</option>
                        <option value="7">6-7 (180 से ऊपर)</option>
                    </select>
                    <div class="select__arrow"></div>
                </div>
                <div class="frm-er-msg"></div>
                <div class="clr"></div>
            </div>


            <div class="dimen_amt" id="dimen_amount"></div>

            <div class="form-field-wrap posrel hide" id="dimention_number_count"  style="margin-top: 6px;">
                <div class="posabsolut frm-lbl-actv title-text-name">इस आयाम के कुल वृक्षों की संख्या*</div>
                <div class="form-type dev_req_msg">
                    <input type="text" class="frm-txtbox dept-frm-input integer fldrequired dimention_number_count"name="dimention_number_count[]"  onpaste="return false"
                           maxlength="4" placeholder="इस आयाम के कुल वृक्षों की संख्या*" autocomplete="off">
                </div>
                <div class="frm-er-msg"></div>
            </div>

            <div class="form-field-wrap posrel hide"  id="total_dimention_amt" style="margin-top: 6px;">
                <div class="posabsolut frm-lbl-actv title-text-name">सभी वृक्षों का मूल्य (सॉफ्टवेर द्वारा)*</div>
                <div class="form-type dev_req_msg">
                    <input type="text" class="frm-txtbox dept-frm-input fldrequired integer total_dimention_amt"name="total_dimention_amt[]"
                           maxlength="4" placeholder="सभी वृक्षों का मूल्य (सॉफ्टवेर द्वारा)*" value="" readonly autocomplete="off">
                </div>
                <div class="frm-er-msg"></div>
            </div>
        </div>

        <div class="form-field-wrap posrel hide" id="property_amount" style="margin-top: 6px;">
            <div class="posabsolut frm-lbl-actv title-text-name">सभी वृक्षों का मूल्य (मैन्युअल भरें)*
            </div>
            <div class="form-type dev_req_msg">
                <input type="text" class="frm-txtbox dept-frm-input integer fldrequired property_amount"name="property_amount[]"
                       maxlength="10" placeholder="सभी वृक्षों का मूल्य (मैन्युअल भरें)*" autocomplete="off" oninput="process(this)">
            </div>
            <div class="frm-er-msg"></div>
        </div>

        <?php if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'append cross') { ?>
            <div class="posrel left lmarg" style="width:28px; height:28px; top:4px; right:-8px;">
                <div class="upldfilediv_crs rm_parisampatti_div" title="Remove">
                    <div style="position: relative;">
                        <img src="img/close_remove.svg">
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php
} else if ($department_id && $department_type == '2') {
    ?>
    <div class="change_tree_append" style="display: flex;">
        <div class="form-field-wrap posrel">
            <div class="posabsolut frm-lbl-actv">छोटी संपत्ति चुनें*</div>
            <div class="select dev_req_msg left rmarg">
                <select name="minor_property[]" Class="fldrequired minor_property">
                    <option value="">छोटी संपत्ति चुनें</option>
                    <?php foreach ($minor_propInfo as $mKey => $mValue) { ?>
                        <option value="<?php echo $mValue['ID']; ?>">
                            <?php echo $mValue['MinorPropertyName']; ?>
                        </option>
                    <?php } ?>
                </select>
                <div class="select__arrow"></div>
            </div>
            <div class="frm-er-msg"></div>
            <div class="clr"></div>
        </div>
        <div class="form-field-wrap posrel">
            <div class="posabsolut frm-lbl-actv title-text-name">संपत्ति मूल्य डालें*</div>
            <div class="form-type dev_req_msg">
                <input type="text" class="frm-txtbox dept-frm-input integer fldrequired"name="property_amount[]"
                       maxlength="6" placeholder="संपत्ति मूल्य डालें*" autocomplete="off" oninput="process(this)">
            </div>
            <div class="frm-er-msg"></div>
        </div>
        <?php if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'append cross') { ?>
            <div class="posrel left lmarg" style="width:28px; height:28px; top:4px;">
                <div class="upldfilediv_crs rm_parisampatti_div" title="Remove">
                    <div style="position: relative;">
                        <img src="img/close_remove.svg">
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } else if ($department_id && $department_type == '3') { ?>
    <div class="change_tree_append" style="display: flex;">
        <div class="form-field-wrap posrel">
            <div class="posabsolut frm-lbl-actv">संपत्ति चुनें*</div>
            <div class="select dev_req_msg left rmarg">
                <select name="property[]" Class="fldrequired property">
                    <option value="">संपत्ति चुनें</option>
                    <?php foreach ($propertyInfo as $pKey => $pValue) { ?>
                        <option value="<?php echo $pValue['ID']; ?>">
                            <?php echo $pValue['PropertyName']; ?>
                        </option>
                    <?php } ?>
                </select>
                <div class="select__arrow"></div>
            </div>
            <div class="frm-er-msg"></div>
            <div class="clr"></div>
        </div>
        <div class="form-field-wrap posrel">
            <div class="posabsolut frm-lbl-actv title-text-name">संपत्ति मूल्य डालें*</div>
            <div class="form-type dev_req_msg">
                <input type="text" class="frm-txtbox dept-frm-input integer fldrequired"name="property_amount[]"
                       maxlength="6" placeholder="संपत्ति मूल्य डालें*" autocomplete="off" oninput="process(this)">
            </div>
            <div class="frm-er-msg"></div>
        </div>
        <?php if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'append cross') { ?>
            <div class="posrel left lmarg" style="width:28px; height:28px; top:4px;">
                <div class="upldfilediv_crs rm_parisampatti_div" title="Remove">
                    <div style="position: relative;">
                        <img src="img/close_remove.svg">
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>
