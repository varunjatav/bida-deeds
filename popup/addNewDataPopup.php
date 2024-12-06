<?php
   include_once '../config.php';
   include_once '../includes/checkSession.php';
   include_once '../includes/get_time_zone.php';
   include_once '../dbcon/db_connect.php';
   include_once '../functions/common.function.php';
   include_once '../core/addNewDataPopup.core.php';
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
   .form-field-wrap{
   margin-right: 15px;
   }
   .village-dropdown{
   width: 29px !important;
   }
   .dropdown-content{
   left: 0 !important;
   }
</style>
<div class="popup-overlay">
   <div class="popup-wrap pp-large-x">
      <div class="popup-header" style="cursor: move;">
         <span class="popup-title text-wrapping left">नया 1359 फसली डेटा जोड़ें</span>
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
                  <div style="display: flex; margin-top:10px;">
                     <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv">1) गाँव चुनें*</div>
                        <div class="select dev_req_msg left rmarg">
                           <select name="village_code" class="fldrequired village_code" id="village_code">
                              <?php foreach ($villageInfo as $dKey => $dValue) { ?>
                              <option value="<?php echo encryptIt($dValue['VillageCode']); ?>">
                                 <?php echo $dValue['VillageName']; ?> (<?php echo $dValue['VillageNameHi']; ?>)
                              </option>
                              <?php } ?>
                           </select>
                           <div class="select__arrow"></div>
                        </div>
                        <div class="frm-er-msg"></div>
                        <div class="clr"></div>
                     </div>
                     <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv">2) महल का नाम/ नंबर*</div>
                        <div class="select dev_req_msg left rmarg">
                           <select name="mahal_name" class="fldrequired mahal_name" id="mahal_name">
                              <option value="">महल का नाम चुनें*</option>
                              <?php while($row = $mahal_query->fetch()){ ?>
                                 <option value="<?php echo $row['MahalName']; ?>"><?php echo $row['MahalName']; ?></option>
                              <?php } ?>
                           </select>
                           <div class="select__arrow"></div>
                        </div>
                        <div class="frm-er-msg"></div>
                        <div class="clr"></div>
                     </div>
                     <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv">3) श्रेनी चुनें*</div>
                        <div class="select dev_req_msg left rmarg">
                           <select name="shreni" class="fldrequired village_gata">
                              <option value="">श्रेनी चुनें*</option>
                              <?php foreach ($sherni_list_1359_array as $value) { ?>
                              <option value="<?php echo $value; ?>" 
                                 <?php echo ($value == $data['fasali_ke_anusar_sreni']) ? 'selected' : ''; ?>>
                                 <?php echo $value; ?>
                              </option>
                              <?php } ?>
                           </select>
                           <div class="select__arrow"></div>
                        </div>
                        <div class="frm-er-msg"></div>
                        <div class="clr"></div>
                     </div>
                     <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv">4) खाता नंबर*</div>
                        <div class="form-type dev_req_msg">
                           <input type="text" class="frm-txtbox dept-frm-input integer fldrequired" name="khata_no"
                              maxlength="20" placeholder="खाता नंबर*" autocomplete="off">
                        </div>
                        <div class="frm-er-msg"></div>
                     </div>
                     <div class="form-field-wrap posrel">
                        <div class="posabsolut frm-lbl-actv">5) काश्तकार के नाम दर्ज है या नहीं?</div>
                        <div class="select dev_req_msg left rmarg">
                           <select name="kashtkar" class="form-select fldrequired" id="">
                              <option value="">काश्तकार के नाम दर्ज स्थिति चुनें*</option>
                              <option value="हाँ">हाँ</option>
                              <option value="नहीं">नहीं</option>
                              <option value="पता नहीं">पता नहीं</option>
                           </select>
                           <div class="select__arrow"></div>
                        </div>
                        <div class="frm-er-msg"></div>
                        <div class="clr"></div>
                     </div>
                  </div>
                  <hr>
                  <div class="change_tree_append index" style="display: flex;   margin-top: 25px;">
                     <div class="form-field-wrap posrel left">
                        <div class="posabsolut frm-lbl-actv">गाटा संख्या*</div>
                        <div class="form-type dev_req_msg">
                           <input type="text" class="frm-txtbox dept-frm-input fldrequired" name="gata_no[]"
                              maxlength="100" placeholder="गाटा संख्या*" autocomplete="off">
                        </div>
                        <div class="frm-er-msg"></div>
                     </div>
                     <div class="form-field-wrap posrel left">
                        <div class="posabsolut frm-lbl-actv">रकबा*</div>
                        <div class="form-type dev_req_msg">
                           <input type="text" class="frm-txtbox dept-frm-input numeric fldrequired" name="rakba[]"
                              maxlength="10" placeholder="रकबा*" autocomplete="off">
                        </div>
                        <div class="frm-er-msg"></div>
                     </div>
                     <div class="form-field-wrap posrel left">
                        <div class="posabsolut frm-lbl-actv">विवरण*</div>
                        <div class="select dev_req_msg left rmarg vivran_parent" id="villageDropdown">
                           <div class="dropdown-header posrel" id="dropdownHeader">विवरण चुनें <span class="dropdown-arrow">&#9662;</span></div>
                           <div class="dropdown-content">
                              <?php foreach ($kismList_1359_array as $dKey => $dValue) { ?>
                              <div class="checkbox-wrapper">
                                 <input type="checkbox" name="vivran[]" value="<?php echo $dValue; ?>" class="fldrequired village-dropdown">
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
                  <div class="clr"></div>
                  <div class="property_type"></div>
                  <div class="left rmarg" id="add_more_hide">
                     <a id="add_more_data" style="cursor: pointer; font-size: 14px; line-height: 40px; font-weight: 500; color: blue;">+ Add More Gata</a>
                  </div>
               </div>
               <div class="frm_hidden_data"></div>
            </form>
         </div>
         <div class="popup-actionwrap posrel">
            <div class="posabsolut act_btn_ovrly"></div>
            <a style="cursor: pointer;" id="add_land_data" class="pp-primact right">Save</a>
            <a style="cursor: pointer;" id="" class="pp-secact right cancel_popup">Close</a>
            <div class="clr"></div>
         </div>
      </div>
      <div id="popup_conf_msg" style="display: none;">
         <div class="popup-body cnfrm-task"></div>
         <div class="popup-actionwrap"></div>
      </div>
   </div>
</div>
<script src="../scripts/jquery-ui.js"></script>
<script>
    $(document).ready(function () {
        function initializeDropdown() {
            $(document).on('click', '.dropdown-header', function () {
                $(this).parent().toggleClass("show");
            });

            $(document).click(function (e) {
                if (!$(e.target).closest(".select").length) {
                    $(".dropdown-content").parent().removeClass("show");
                }
            });

            $(document).on('change', '.village-dropdown', function () {
                let $currentDropdown = $(this).closest('.select');
                updateDropdownHeader($currentDropdown);
            });
        }
        function updateDropdownHeader($dropdown) {
            let selectedValues = [];
            $dropdown.find('.village-dropdown:checked').each(function () {
                selectedValues.push($(this).val());
            });
            let displayText = selectedValues.length > 0 ? selectedValues.join(', ') : 'विवरण चुनें';
            $dropdown.find('.dropdown-header').text(displayText);
            $dropdown.closest('.vivran_parent').find('.vivran_data').val(displayText);
        }
        initializeDropdown();
        $('#addMoreButton').click(function () {
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
                    <input type="hidden" name="vivran_data[]" class="vivran_data" value="">
                    <div class="frm-er-msg"></div>
                    <div class="clr"></div>
                </div>`;
            $('.change_tree_append').append(newDiv);
            updateDropdownHeader($('.change_tree_append .select:last'));
        });
        $(document).on('shown.bs.modal', '#yourModalId', function () { 
            initializeDropdown();
        });
    });
</script>
