<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/villageEbasta.core.php';
?>
<div style="display: flex; flex-wrap: wrap; flex-direction: row; padding: 0px 0px 0px 10px;">
    <?php
    for ($frm = 1; $frm <= 20; $frm++) {
        if ($frm == 1) {
            $title = '28 जुलाई 2023 जिलाधिकारी प्रस्ताव';
            $file_name = $ebasta_1[0]['file_name'];
        } else if ($frm == 2) {
            $title = '27 दिसंबर 2023 जिलाधिकारी प्रस्ताव( साइड एक्सकैल एंड नक्सा )';
            $file_name = $ebasta_2[0]['file_name'];
        } else if ($frm == 3) {
            $title = 'जिलाधिकारी का प्रेस विज्ञप्ति हेतु प्रस्ताव';
            $file_name = $ebasta_3[0]['file_name'];
        } else if ($frm == 4) {
            $title = 'बीड़ा समिति की प्रेस विज्ञप्ति हेतु प्रस्ताव';
            $file_name = $ebasta_4[0]['file_name'];
        } else if ($frm == 5) {
            $title = 'विज्ञप्ति प्रकाशन हेतु जिलाधिकारी द्वारा भेजी गयी सूची';
            $file_name = $ebasta_5[0]['file_name'];
        } else if ($frm == 6) {
            $title = 'प्रकाशित विज्ञप्ति';
            $file_name = $ebasta_6[0]['file_name'];
        } else if ($frm == 7) {
            $title = 'विज्ञप्ति प्रकाशन उपरांत विज्ञप्ति की जांच आख्या';
            $file_name = $ebasta_7[0]['file_name'];
        } else if ($frm == 8) {
            $title = 'दर निर्धारण सूची';
            $file_name = $ebasta_8[0]['file_name'];
        } else if ($frm == 9) {
            $title = 'जिला दर निर्धारण सिमिति की आख्या';
            $file_name = $ebasta_9[0]['file_name'];
        } else if ($frm == 10) {
            $title = 'दर निर्धारण पत्रावली';
            $file_name = $ebasta_10[0]['file_name'];
        } else if ($frm == 11) {
            $title = '1359 फसली की खतौनी';
            $file_name = $ebasta_11[0]['file_name'];
        } else if ($frm == 12) {
            $title = '1359 फसली की खसरा';
            $file_name = $ebasta_12[0]['file_name'];
        } else if ($frm == 13) {
            $title = 'जोत चकबंदी आकार पत्र 41/45';
            $file_name = $ebasta_13[0]['file_name'];
        } else if ($frm == 14) {
            $title = 'वर्तमान खतौनी';
            $file_name = $ebasta_14[0]['file_name'];
        } else if ($frm == 15) {
            $title = 'वर्तमान खसरा';
            $file_name = $ebasta_15[0]['file_name'];
        } else if ($frm == 16) {
            $title = 'ग्राम का बदोबस्ती नक्शा';
            $file_name = $ebasta_16[0]['file_name'];
        } else if ($frm == 17) {
            $title = 'गाटा आवंटन आदेश';
            $file_name = $ebasta_17[0]['file_name'];
        } else if ($frm == 18) {
            $title = 'मास्टर फाइल (प्रारूप अ )';
            $file_name = $ebasta_18[0]['file_name'];
        } else if ($frm == 19) {
            $title = 'प्रारूप ब';
            $file_name = $ebasta_19[0]['file_name'];
        } else if ($frm == 20) {
            $title = 'पेड़ो की सूचना';
            $file_name = $ebasta_20[0]['file_name'];
        }
        ?>
        <form id="frm_<?php echo $frm; ?>">
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
                    <?php
                    if (file_exists(dirname(dirname(__FILE__)) . '/' . $media_village_ebasta_path . '/' . $file_name) && $file_name) {
                        ?>
                        <a href="download?file=<?php echo base64_encode($file_name); ?>&type=<?php echo base64_encode('village_ebasta'); ?>">
                            <div class="dwnldfilediv" title="Download file">
                                <div style="position: relative;">
                                    <img src="img/download_1.svg">
                                </div>
                            </div>
                        </a>
                        <?php
                    }
                    ?>
                </div>
                <div class="frm-er-msg" style="position:absolute;top:44px;left:95px;"></div>
            </div>
        </form>
        <?php
    }
    ?>
</div>
<?php if ($user_type == '0') { ?>
    <input type="hidden" id="total_files_count" name="total_files_count" autocomplete="off">
    <div class="actionbuttons" style="margin-bottom:20px; margin-left: 20px;">
        <a class="secondary left rmarg" style="cursor:pointer;" onclick="window.location.reload();">Cancel</a>
        <div class="posabsolut act_btn_ovrly"></div>
        <a class="save_village_ebasta primary left" style="cursor:pointer;">Save</a>
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