<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../functions/common.function.php';
?>
<div class="popup-overlay center-screen">
    <div class="popup-wrap">
        <div class="popup-header" style="cursor: move;">
            <span class="popup-title text-wrapping">Update Data</span>
        </div>
        <div class="popup-body pp-medium-y" id="log_content">
            <div class="form-field-wrap posrel">
                <div class="">
                    <div class="slcdstc">
                    </div>
                </div>
            </div>
        </div>
        <div class="popup-actionwrap" style="display: none;">
            <a style="cursor: pointer;" id="cancel_sync_popup" class="pp-primact right">Close</a>
            <div class="clr"></div>
        </div>
    </div>
</div>