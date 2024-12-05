<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/gataEbasta.core.php';
?>
<div style="display: flex; flex-wrap: wrap; flex-direction: row; padding: 0px 0px 0px 10px;">
    <?php
    for ($frm = 1; $frm <= 5; $frm++) {
        $class = '';
        if ($frm == 1) {
            $title = 'सहमति पत्र';
            $file_name = $ebasta_1[0]['file_name'];
        } else if ($frm == 2) {
            $title = 'बैनामा/जिलाधिकारी का अधिग्रहण पत्र';
            $file_name = $ebasta_2[0]['file_name'];
        } else if ($frm == 3) {
            $title = 'कब्ज़ा रिपोर्ट';
            $file_name = $ebasta_3[0]['file_name'];
        } else if ($frm == 4) {
            $title = 'नामांतरण खतौनी';
            $file_name = $ebasta_4[0]['file_name'];
        } else if ($frm == 5) {
            $title = 'तितिम्मा पत्र';
            $file_name = $ebasta_5[0]['file_name'];
            $class = 'hide';
        }
        ?>
        <form id="frm_<?php echo $frm; ?>" class="<?php echo $class; ?>">
            <div class="upldfilediv">
                <span class="upldfilediv_lbl"><?php echo $frm; ?>)</span>
                <div class="form_div dev_req_msg posrel">
                    <div class="upload left <?php if ($user_type == '0') { ?>brPic<?php } ?>" style="margin-right:15px;">
                        <div class="upload-img left" style="margin-right:10px;">
                            <img src="img/upload_file.svg" width="30" alt="upload files">
                        </div>
                        <div class="upload-stt left">
                            <span class="upldfilediv_bmarg">Click here to upload</span>
                            <span class="upldfilediv_bmarg"><?php echo $title; ?></span>
                            <span class="upldfilediv_file_txt"></span>
                            <div class="frm-er-msg" style="margin-left:22px"></div>
                        </div>
                        <div class="upldfilediv_crs hide" title="Remove file">
                            <div style="position: relative;">
                                <img src="img/close_remove.svg">
                            </div>
                        </div>
                    </div>
                    <input type="file" style="display:none" class="browsePic" accept="application/pdf" name="ebasta_<?php echo $frm; ?>">
                    <div class="clr"></div>
                </div>
                <div class="frm-er-msg" style="position:absolute;top:44px;left:95px;"></div>
            </div>
        </form>
        <?php
    }
    ?>
</div>
<input type="hidden" id="total_files_count" name="total_files_count" autocomplete="off">
<?php if ($user_type == '0') { ?>
    <div class="actionbuttons" style="margin-bottom:20px; margin-left: 20px;">
        <a class="secondary left rmarg" style="cursor:pointer;" onclick="window.location.reload();">Cancel</a>
        <div class="posabsolut act_btn_ovrly"></div>
        <a class="save_gata_ebasta primary left" style="cursor:pointer;">Save</a>
        <div class="clr"></div>
    </div>
<?php } ?>
<div id="ansh_rakba_div">
    <div class="dev_req_msg left rmarg" style="width:100px;">
        <span>काश्तकार का अंश</span>
        <input type="text" name="ansh[]" class="frm-txtbox frm-focus ansh" maxlenth="20" placeholder="" autocomplete="off" value="<?php echo $ebasta_6; ?>">
    </div>
    <div class="dev_req_msg left rmarg" style="width:100px;">
        <span>अंश का रकबा</span>
        <input type="text" name="ansh_rakba[]" class="frm-txtbox frm-focus numeric ansh_rakba" maxlenth="20" placeholder="" autocomplete="off" value="<?php echo $ebasta_7; ?>">
    </div>
    <div class="dev_req_msg left rmarg" style="width:100px;">
        <span>बैनामे का दिनांक</span>
        <input type="text" name="ansh_date[]" class="frm-txtbox frm-focus spbdate ansh_date" placeholder="" autocomplete="off" value="<?php echo $ebasta_8; ?>">
    </div>

    <?php
    for ($frm = 1; $frm <= 5; $frm++) {
        if ($frm == 1) {
            $file_name = $ebasta_1[0]['file_name'];
        } else if ($frm == 2) {
            $file_name = $ebasta_2[0]['file_name'];
        } else if ($frm == 3) {
            $file_name = $ebasta_3[0]['file_name'];
        } else if ($frm == 4) {
            $file_name = $ebasta_4[0]['file_name'];
        } else if ($frm == 5) {
            $file_name = $ebasta_5[0]['file_name'];
        }
        if (file_exists(dirname(dirname(__FILE__)) . '/' . $media_gata_ebasta_path . '/' . $file_name) && $file_name) {
            ?>
            <span class="ebasta_doc_<?php echo $frm; ?>" id="download?file=<?php echo base64_encode($file_name); ?>&type=<?php echo base64_encode('gata_ebasta'); ?>"></span>
            <?php
        }
    }
    ?>

</div>
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