<?php
include_once '../config.php';
include_once '../includes/kashtCheckSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
?>
<div class="offcanvas offcanvas-end show" tabindex="-1" id="offcanvasEnd" aria-labelledby="offcanvasEndLabel" style="visibility: visible;">
    <div class="offcanvas-header">
        <h5 id="offcanvasEndLabel" class="offcanvas-title">नया काश्तकार जोड़ें </h5>
        <button type="button" class="btn-close text-reset close_popup" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="">
        <div class="card-body">
            <form id="pfrm" class="mb-3" autocomplete="off">
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="defaultSelect" class="form-label">काश्तकार का नाम डालें</label>
                        <input type="text" class="form-control fldrequired" name="fname" placeholder="काश्तकार का नाम डालें" value="" maxlength="100">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="defaultSelect" class="form-label">पति/पिता का नाम डालें</label>
                        <input type="text" class="form-control fldrequired" name="pname" placeholder="पति/पिता का नाम डालें" value="" maxlength="100">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="defaultSelect" class="form-label">गाटे का रकबा (हेक्टेयर में)</label>
                        <input type="text" class="form-control numeric" name="area" maxlength="10" pattern="[0-9.]*" inputmode="numeric" placeholder="गाटे का रकबा (हेक्टेयर में)">
                    </div>
                </div>
                <input type="hidden" name="mobile" id="mobile" value="<?php echo $_GET['mobile']; ?>">
                <input type="hidden" name="village_code" id="village_code" value="<?php echo $_GET['village_code']; ?>">
                <input type="hidden" name="gata_no" id="gata_no" value="<?php echo $_GET['gata_no']; ?>">
                <input type="hidden" name="khata_no" id="khata_no" value="<?php echo $_GET['khata_no']; ?>">
                <div class="frm_hidden_data"></div>
                <div class="posrel">
                    <div class="posabsolut act_btn_ovrly"></div>
                    <button class="btn btn-primary mb-2 d-grid w-100" id="save_kashtkar">काश्तकार जोड़ें</button>
                    <button class="btn btn-outline-secondary d-grid w-100 close_popup" data-bs-dismiss="offcanvas">रद्द करें</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="offcanvas-backdrop fade show"></div>