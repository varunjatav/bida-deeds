<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/gataMortgaged.core.php';
?>
<div style="display: flex; flex-wrap: wrap; flex-direction: row; padding: 0px 0px 0px 10px;">
    <div class="upldfilediv" style="cursor: pointer;">
        <div class="form_div dev_req_msg posrel">
            <div class="upload left mort" style="margin-right:15px; width: 190px;" id="mort_1">
                <div class="upload-img left" style="margin-right:10px;">
                    <?php if ($mortgaged == '1') { ?>
                        <img src="img/radio-button.svg" width="30" alt="Mark Yes">
                    <?php } else { ?>
                        <img src="img/unchk-radio-button.svg" width="30" alt="Mark Yes">
                    <?php } ?>
                </div>
                <div class="upload-stt left">
                    <span class="upldfilediv_bmarg">Click here to Mark YES</span>
                    <span class="upldfilediv_bmarg">Land is mortgaged ?</span>
                    <span class="upldfilediv_file_txt"></span>
                    <div class="frm-er-msg" style="margin-left:22px"></div>
                </div>
            </div>
            <div class="clr"></div>
        </div>
        <div class="frm-er-msg" style="position:absolute;top:44px;left:95px;"></div>
    </div>
    <div class="upldfilediv" style="cursor: pointer;">
        <div class="form_div dev_req_msg posrel">
            <div class="upload left mort" style="margin-right:15px; width: 190px;" id="mort_2">
                <div class="upload-img left" style="margin-right:10px;">
                    <?php if ($mortgaged == '2') { ?>
                        <img src="img/radio-button.svg" width="30" alt="Mark No">
                    <?php } else { ?>
                        <img src="img/unchk-radio-button.svg" width="30" alt="Mark No">
                    <?php } ?>
                </div>
                <div class="upload-stt left">
                    <span class="upldfilediv_bmarg">Click here to Mark No</span>
                    <span class="upldfilediv_bmarg">Land is mortgaged ?</span>
                    <span class="upldfilediv_file_txt"></span>
                    <div class="frm-er-msg" style="margin-left:22px"></div>
                </div>
            </div>
            <div class="clr"></div>
        </div>
        <div class="frm-er-msg" style="position:absolute;top:44px;left:95px;"></div>
    </div>
    <div class="upldfilediv <?php if ($mortgaged != '1') { ?>hide<?php } ?>">
        <div class="form_div dev_req_msg posrel">
            <div class="upload left" style="margin-right:15px; width: 190px;">
                <div class="dev_req_msg left rmarg upload-stt" style="width:190px;">
                    <span>Mortgaged Amount</span>
                    <input type="text" name="mortgaged_amount" class="frm-txtbox frm-focus mortgaged_amount numeric" maxlenth="20" placeholder="" autocomplete="off" value="<?php echo $mortgaged_amount; ?>">
                </div>
            </div>
            <div class="clr"></div>
        </div>
    </div>
    <input type="hidden" id="mortgaged" name="mortgaged" class="numeric" maxlenth="1" autocomplete="off" value="<?php echo $mortgaged; ?>">
</div>

<?php if ($user_type == '4') { ?>
    <div class="actionbuttons" style="margin-bottom:20px; margin-left: 20px;">
        <a class="secondary left rmarg" style="cursor:pointer;" onclick="window.location.reload();">Cancel</a>
        <div class="posabsolut act_btn_ovrly"></div>
        <a class="save_mortgaged primary left" style="cursor:pointer;">Save</a>
        <div class="clr"></div>
    </div>
<?php } ?>
<script>
    // Another way to bind the event
    $(window).bind('beforeunload', function () {
        if (unsaved) {
            return "You have unsaved changes on this page. Do you want to leave this page and discard your changes or stay on this page?";
        }
    });

    // Monitor dynamic inputs
    $(document).on('change', 'input', 'textarea', function () { //triggers change in all input fields including text type
        unsaved = true;
    });
</script>