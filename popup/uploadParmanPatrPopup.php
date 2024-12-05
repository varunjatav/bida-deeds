<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../functions/common.function.php';
include_once '../dbcon/db_connect.php';
include_once '../core/editVillageDataDeatils.core.php';
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
    <div class="popup-wrap  pp-small-x">
        <div class="popup-header" style="cursor: move;">
            <span class="popup-title text-wrapping"><?php echo $village_data_list['title']; ?></span>
        </div>
        <div id="popupDiv">
            <div class="popup-body pp-small-x">
                <div id="main-body" style="display: contents;">
                    <div id="paginate-body" style="display: contents;">
                             <div class="rowDiv">
                            <div class="cellDiv col1">
                                <b><?php echo $village_data_list['village_code']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['VillageCode']; ?>
                            </div>
                        </div>
                        <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $village_data_list['village_name']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['VillageNameHi']; ?>
                            </div>
                        </div>
                    </div>
                </div><br><br><br><br>
                <form id="pfrm">
                          <div style="position:relative">
                        <div class="form_div dev_req_msg" style="margin-bottom:20px">
                            <div class="upload left brPic" style="margin-right:15px; cursor: pointer;">
                                <div class="upload-img left" style="margin-right:20px">
                                    <img src="img/fileupload.svg" alt="upload files">
                                </div>
                                <div class="upload-stt left">
                                    <span>Click here to upload order</span>
                                    <span>Maximum size : 100 MB</span>
                                    <span style="color: blue;margin-left:28px;margin-bottom: 5px" class="hide"
                                          id="office_order"></span>
                                    <div class="frm-er-msg" style="margin-left:22px"></div>
                                </div>
                            </div>
                            <input type="file" style="display:none" id="file" class="browsePic" accept="image/jpg,image/jpeg, image/png,.doc,.docx,.pdf" multiple name="order_file">
                            <div class="clr"></div>
                        </div>
                        <div class="frm-er-msg" style="position:absolute;top:44px;left:95px;"></div>
                    </div>
                    <div class="frm_hidden_data"></div>
                    <input type="hidden" name="file_id" value="<?php echo $_REQUEST['file_id']; ?>" autocomplete="off"> 
                    <input type="hidden" name="viilage_code" value="<?php echo encryptIt($data['VillageCode']); ?>" autocomplete="off"> 
                </form>
            </div>
            <div class="popup-actionwrap posrel">
                <div class="posabsolut act_btn_ovrly"></div>
                <a style="cursor: pointer;" id="upload_perman_patr" class="pp-primact right">Save</a>
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