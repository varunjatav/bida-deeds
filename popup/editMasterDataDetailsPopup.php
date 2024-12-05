<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../functions/common.function.php';
include_once '../dbcon/db_connect.php';
include_once '../core/editMasterDataDeatils.core.php';
include_once '../core/permission.core.php';
include_once '../languages/' . $lang_file;
?>
<style>
    .form-field-wrap {
        margin-bottom: 20px;
        padding-bottom: 2px;
    }
    .login-wrapper .frm-txtbox,.popup-body .frm-txtbox,.hbdt-div .frm-txtbox,.attachment-div .frm-txtbox {
        padding: 10px  !important; 
    }
    .frm-lbl-actv{
        font-weight: 600;
        font-size: 14px;
    }
</style>
<div class="popup-overlay">
    <div class="popup-wrap  pp-large-x">
        <div class="popup-header" style="cursor: move;">
            <span class="popup-title text-wrapping"><?php echo $edit_master_data_details['title']; ?></span>
        </div>
        <div id="popupDiv">
            <div class="popup-body pp-large-y">
                <!--                <div class="containerDiv">
                                    <div class="rowDivHeader">
                                        <div class="cellDivHeader">
                                            <p><?php //echo $master_data_details['kashtkar_name'];   ?></p></a>
                                        </div>
                                        <div class="cellDivHeader">
                                            <p><?php //echo $master_data_details['father_name'];   ?></p></a>
                                        </div>
                                        <div class="cellDivHeader">
                                            <p><?php //echo $master_data_details['rakba'];   ?></p></a>
                                        </div>
                                    </div>
                                    <div id="main-body" style="display: contents;">
                                        <div id="paginate-body" style="display: contents;">
                <?php foreach ($kastakar_details as $key => $val) { ?>
                                                        <div class="rowDiv <?php echo $color; ?>">
                                                            <div class="cellDiv col1">
                    <?php //echo $val; ?>
                                                            </div>
                                                            <div class="cellDiv col2">
                    <?php //echo $owner_father[$key]; ?>
                                                            </div>
                                                            <div class="cellDiv col2">
                    <?php //echo $Kashtkar_Area[$key]; ?>
                                                            </div>
                                                        </div>
                <?php } ?>
                                        </div>
                                    </div>
                                </div>-->
                <div id="main-body" style="display: contents;">
                    <div id="paginate-body" style="display: contents;">

                        <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['sr']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['UID']; ?>
                            </div>
                        </div>
                        <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['village_name']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['VillageName']; ?>
                            </div>
                        </div>
                        <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['shreni']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['Shreni']; ?>
                            </div>
                        </div>
                        <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['title'];?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['GataNo'] ;?>
                            </div>
                        </div>
                        <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_list['rakba']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['Area']; ?>
                            </div>
                        </div>
                        <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['khata_no']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['KhataNo']; ?>
                            </div>
                        </div>

                        <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['area_required']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['RequiredArea']; ?>
                            </div>
                        </div>
                        <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['board_approved']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['BoardApproved']; ?>
                            </div>
                        </div>
<!--                        <div class="rowDiv <?php //echo $color;   ?>">
                            <div class="cellDiv col1">
                                <b><?php //echo $master_data_details['gata_hold_by_DM'];   ?></b>
                            </div>
                            <div class="cellDiv col2">
                        <?php //echo $data['HoldByDM']; ?>
                            </div>
                        </div>-->
                    </div>
                </div><br><br><br><br>
                <form id="pfrm">
                    <?php if ($chakbandi_status_array == 1) { ?>
                        <div class="form-field-wrap posrel">
                            <div class="posabsolut frm-lbl-actv"><?php echo $edit_master_data_details['shreni_4145']; ?>*</div>
                            <div class="form-type dev_req_msg">
                                <input type="text" class="frm-txtbox dept-frm-input fldrequired" name="shreni_4145"
                                       maxlength="45" placeholder="<?php echo $edit_master_data_details['shreni_4145']; ?>" value="<?php echo $data['ch41_45_ke_anusar_sreni']; ?>" autocomplete="off">
                            </div>
                            <div class="frm-er-msg"></div>
                        </div>
                        <div class="form-field-wrap posrel">
                            <div class="posabsolut frm-lbl-actv"><?php echo $edit_master_data_details['rakba_4145']; ?>*</div>
                            <div class="form-type dev_req_msg">
                                <input type="text" class="frm-txtbox dept-frm-input fldrequired"  name="rakba_4145"
                                       placeholder="<?php echo $edit_master_data_details['rakba_4145']; ?>" maxlength="25" value="<?php echo $data['ch41_45_ke_anusar_rakba']; ?>" autocomplete="off">
                            </div>
                            <div class="frm-er-msg"></div>
                        </div>
                    <?php } else If ($chakbandi_status_array == 0) { ?>
                        <div class="form-field-wrap posrel">
                            <div class="posabsolut frm-lbl-actv"><?php echo $edit_master_data_details['original_gata_fasli_khatauni_1359']; ?>*</div>
                            <div class="form-type dev_req_msg">
                                <input type="text" class="frm-txtbox dept-frm-input fldrequired"  name="original_gata_fasli_khatauni_1359"
                                       placeholder="<?php echo $edit_master_data_details['original_gata_fasli_khatauni_1359']; ?>" maxlength="45" value="<?php echo $data['1359_phasalee_khataunee_mein_mool_gaata']; ?>" autocomplete="off">
                            </div>
                            <div class="frm-er-msg"></div>
                        </div>
                        <div class="form-field-wrap posrel">
                            <div class="posabsolut frm-lbl-actv"><?php echo $edit_master_data_details['shreni_1359']; ?>*</div>
                            <div class="select dev_req_msg left rmarg">
                                <select name="shreni_1359" id="status">
                                    <option value=""><?php echo $edit_master_data_details['select_shreni_1359']; ?></option>
                                    <?php foreach ($sherni_list_1359_array as $value) { ?>
                                        <option value="<?php echo $value; ?>" 
                                                <?php echo ($value == $data['fasali_ke_anusar_sreni']) ? 'selected' : ''; ?>>
                                                    <?php echo $value; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <div class="select__arrow"></div>
                            </div>
                            <div class="clr"></div>
                            <div class="frm-er-msg"></div>
                        </div>
                        <div class="form-field-wrap posrel">
                            <div class="posabsolut frm-lbl-actv"><?php echo $edit_master_data_details['rakba_1359']; ?>*</div>
                            <div class="form-type dev_req_msg">
                                <input type="text" class="frm-txtbox dept-frm-input fldrequired"  name="rakba_1359"
                                       placeholder="<?php echo $edit_master_data_details['rakba_1359']; ?>" maxlength="25" value="<?php echo $data['fasali_ke_anusar_rakba']; ?>" autocomplete="off">
                            </div>
                            <div class="frm-er-msg"></div>
                        </div>
                        <div class="form-field-wrap posrel">
                            <div class="posabsolut frm-lbl-actv"><?php echo $edit_master_data_details['fasli_kism']; ?>*</div>
                            <div class="select dev_req_msg left rmarg">
                                <select name="fasli_kism" id="status" >
                                    <option value=""><?php echo $edit_master_data_details['select_fasli_khasra_kism']; ?></option>
                                    <?php foreach ($kismList_1359_array as $val) { ?>
                                        <option value="<?php echo $val; ?>" 
                                                <?php echo ($val == $data['khate_me_fasali_ke_anusar_kism']) ? 'selected' : ''; ?>>
                                                    <?php echo $val; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <div class="select__arrow"></div>
                            </div>
                            <div class="clr"></div>
                            <div class="frm-er-msg"></div>
                        </div>
                        <div class="form-field-wrap posrel">
                            <div class="posabsolut frm-lbl-actv"><?php echo $edit_master_data_details['kastkar_status']; ?>*</div>
                            <div class="select dev_req_msg left rmarg">
                                <select name="kastkar_status" id="status" >
    <!--                                <option value="" <?php //echo $data['fasali_me_kastkar_darj_status'] == '' ? 'selected' : '';        ?>>खाली है</option>-->
                                    <option value="--" <?php echo $data['fasali_me_kastkar_darj_status'] == '--' ? 'selected' : ''; ?>>--</option>
                                    <option value="YES" <?php echo $data['fasali_me_kastkar_darj_status'] == 'YES' ? 'selected' : ''; ?>><?php echo $edit_master_data_details['yes']; ?></option>
                                    <option value="NO" <?php echo $data['fasali_me_kastkar_darj_status'] == 'NO' ? 'selected' : ''; ?>><?php echo $edit_master_data_details['no']; ?></option>   
                                    <option value="YES/NO" <?php echo $data['fasali_me_kastkar_darj_status'] == 'YES/NO' ? 'selected' : ''; ?>><?php echo $edit_master_data_details['yse_no']; ?></option> 
                                </select>
                                <div class="select__arrow"></div>
                            </div>
                            <div class="frm-er-msg"></div>
                        </div>
                    <?php } ?>
                    <div class="frm_hidden_data"></div>
                    <input type="hidden" name="file_id" value="<?php echo $_REQUEST['file_id']; ?>" autocomplete="off"> 
                </form>
            </div>
            <div class="popup-actionwrap posrel">
                <div class="posabsolut act_btn_ovrly"></div>
                <a style="cursor: pointer;" id="edit_master_details" class="pp-primact right">Save</a>
                <a style="cursor: pointer;" id="cancel_popup" class="pp-secact right">Close</a>
                <div class="clr"></div>
            </div>
        </div>
        <div id="popup_conf_msg" style="display: none;">
            <div class="popup-body cnfrm-task redtxt"></div>
            <div class="popup-actionwrap"></div>
        </div>
    </div>
</div>