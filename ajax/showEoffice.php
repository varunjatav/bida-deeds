<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
?>
<div class="popup-overlay">
    <div class="popup-wrap pp-medium-x">
        <div class="popup-header" style="cursor: move;">
            <span class="popup-title text-wrapping left">Select filters to apply</span>
            <span class="popup-close right">
                <a style="cursor: pointer;" id="cancelFilter">
                    <img src="img/clear-w.svg" alt="" width="18px">
                </a>
            </span>
            <div class="clr"></div>
        </div>
        <div id="popupDiv">
            <div class="popup-body pp-medium-y">
                <form id="ffrm">
                    <div class="filter-box">
                        <div class="filter-tabber left">
                            <a style="cursor:pointer;" id="1" class="ftab active">Department Name</a>
                            <a style="cursor:pointer;" id="2" class="ftab">File No</a>
                            <a style="cursor:pointer;" id="3" class="ftab">Name</a>
                            <a style="cursor:pointer;" id="4" class="ftab">Subject</a>
                            <a style="cursor:pointer;" id="5" class="ftab">Folder Name For Note Sheet</a>
                            <a style="cursor:pointer;" id="6" class="ftab">File Creator</a> 
                        </div>

                        <div class="left filter-taboptions">
                            <div class="tab1" id="stab_1" style="border: none;">
                                <div class="frm-lbl-actv">Department Name:</div>
                                <input type="text" name="department_name" class="frm-txtbox dept-frm-input apply_filter_keyup" maxlenth="100" placeholder="Enter department name" autocomplete="off">
                            </div>
                            <div class="tab1" id="stab_2" style="display:none; border: none;">
                                <div class="frm-lbl-actv">File No:</div>
                                <input type="text" name="file_no" class="frm-txtbox dept-frm-input apply_filter_keyup" maxlenth="100" placeholder="Enter file no" autocomplete="off">
                            </div>
                            <div class="tab1" id="stab_3" style="display:none; border: none;">
                                <div class="frm-lbl-actv">Name:</div>
                                <input type="text" name="name" class="frm-txtbox dept-frm-input apply_filter_keyup" maxlenth="100" placeholder="Enter name" autocomplete="off">
                            </div>
                            <div class="tab1" id="stab_4" style="display:none; border: none;">
                                <div class="frm-lbl-actv">Subject:</div>
                                <input type="text" name="subject" class="frm-txtbox dept-frm-input apply_filter_keyup" maxlenth="750" placeholder="Enter subject" autocomplete="off">
                            </div>
                            <div class="tab1" id="stab_5" style="display:none; border: none;">
                                <div class="frm-lbl-actv">Folder Name For Note Sheet:</div>
                                <input type="text" name="folder_name" class="frm-txtbox dept-frm-input apply_filter_keyup" maxlenth="100" placeholder="Enter folder name for note sheet" autocomplete="off">
                            </div>
                            <div class="tab1" id="stab_6" style="display:none; border: none;">
                                <div class="frm-lbl-actv">File Creator:</div>
                                <input type="text" name="file_creator" class="frm-txtbox dept-frm-input apply_filter_keyup" maxlenth="100" placeholder="Enter file creator" autocomplete="off">
                            </div>
                        </div>
                        <div class="clr"></div>
                    </div>
                    <input type="hidden" id="nav" name="status" value="<?php echo $_REQUEST['status']; ?>" autocomplete="off">
                </form>
            </div>
        </div>
    </div>
</div>