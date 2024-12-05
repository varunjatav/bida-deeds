<?php
include_once 'config.php';
include_once 'includes/checkSession.php';
include_once 'includes/get_time_zone.php';
include_once 'dbcon/db_connect.php';
include_once 'functions/common.function.php';
include_once 'core/permission.core.php';
include_once 'core/village.core.php';
?>
<!doctype html>

<head>
    <meta charset="UTF-8">
    <title>BIDA LAMS</title>
    <link href="css/stylus.css" rel="stylesheet" type="text/css">
    <link href="css/common_master.css" rel="stylesheet" type="text/css">
    <link href="css/font.css" rel="stylesheet" type="text/css">
    <link href="css/jquery-ui.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="scripts/jquery.min.js"></script>
    <script>
        document.write('<style type="text/css">body{display:none}</style>');
        jQuery(function (a) {
            a("body").css("display", "block");
        });
    </script>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <div id="appendFilter"></div>
    <div class="wrapper">
        <div class="col-wrapper">
            <?php include "includes/sidebarmenu.php"; ?>
            <div class="full-column db-cont-wrap right">
                <div class="column-head">
                    <div class="left pageback" style="display:flex;">
                        <a style="cursor: pointer;" onclick="history.go(-1)">
                            <img src="img/back.svg" alt="" width="18px">
                        </a>
                        <div class="col-pagename left">OSD MIS Module
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                </div>

                <div class="clr"></div>
                <div class="filter-div" style="border-bottom: 2px solid #f00; padding: 0px 0px 10px 0px;">
                    <div style="" class="left">
                        <div class="tabl3">
                            <a href="misdashboard">
                                <p>MIS Dashboard</p>
                            </a>
                            <a href="misreport" class="active">
                                <p>MIS Report</p>
                            </a>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="tbl-data right" title="Show Columns">
                        <a style="cursor:pointer; display: none;" id="columnFilter">
                            <img src="img/table.svg" height="22px">
                        </a>
                        <div id="checkboxes"
                             style="min-width:200px; margin-top: -2px; min-height: 100px; max-height: 300px; overflow: auto; position: absolute; background: #fff; z-index: 10; right: 15px;">
                            <div style="height: 20px; padding: 10px; font-weight: 600;">
                                Displayed Columns
                            </div>
                            <div id="columnFilterData"></div>
                        </div>
                    </div>
                    <div class="tbl-data right posrel" title="Export Excel">
                        <div class="posabsolut act_btn_ovrly"></div>
                        <a style="cursor:pointer; display: none;" id="export_excel">
                            <img src="img/excel.svg" height="22px">
                        </a>
                    </div>

                    <?php if ($user_type == '2') { ?>
                        <div class="tbl-data right posrel" title="Give report feedback">
                            <div class="posabsolut act_btn_ovrly"></div>
                            <a style="cursor:pointer;" class="report_feedback" id="6" report_type="mis_report">
                                <img src="img/click_action.svg" height="25px">
                            </a>
                        </div>
                    <?php } ?>

                    <?php if ($user_type == '0' || $user_type == '1') { ?>
                        <div class="btn-actionwrap posrel right" style="display: none;">
                            <div class="posabsolut act_btn_ovrly"></div>
                            <a style="cursor: pointer;" id="save_report" class="pp-primact right">Save Report</a>
                            <a style="cursor: pointer;" id="cancel_report" class="pp-secact right cancel">Cancel</a>
                            <div class="clr"></div>
                        </div>
                        <div class="right fltrbtn" style="cursor:pointer; display: none;" id="edit_report">
                            <span><img src="img/edit.svg" height="18px;" alt=""></span>
                            <p>Edit Report</p>
                            <div class="clr"></div>
                        </div>
                    <?php } ?>
                    <span class="left rmarg" style="font-size: 14px; line-height: 36px;"></span>
                    <div class="ebasta_select dev_req_msg left rmarg">
                        <select id="report_type">
                            <option value="">Report Type</option>
                            <option value="1">सहमति एवं अंश निर्धारण के संबंध में</option>
                            <option value="2">बैनामा प्राप्ति के संबंध मे</option>
                            <option value="3">खतौनी प्राप्ति के संबंध मे</option>
                            <option value="4">धनराशि वितरण के संबंध में</option>
                            <option value="5">कब्जा प्राप्ति के संबंध मे</option>
                        </select>
                        <div class="ebasta_select__arrow"></div>
                    </div>
                    <div class="ebasta_select dev_req_msg left rmarg hide">
                        <select id="mis_report_date">
                            <option value="">Select Date</option>
                        </select>
                        <div class="ebasta_select__arrow"></div>
                    </div>
                    <div class="form-type dev_req_msg left lmarg hide" style="padding: 15px 0px 0px 0px;">
                        <input type="text" class="frm-txtbox spbdate" id="mis_date" placeholder="Select Report Date" value="">
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
                <form id="rfrm">
                    <div class="scrl-repo-tblwrap">
                        <div class="containerDiv" style="table-layout: fixed;">

                        </div>
                    </div>
                    <div class="frm_hidden_data"></div>
                </form>
            </div>
            <input type="hidden" id="name_order" value="asc">
            <div class="clr"></div>
            <?php include "includes/footer.php"; ?>
        </div>
    </div>
    <input type="hidden" id="village_codes">
    <div id="notify"></div>
    <div id="saveFilter" class="hide"></div>
</body>
<script src="scripts/jquery-ui.min.js"></script>
<script src="scripts/jquery.confirm.js"></script>
<script src="scripts/common.js"></script>
<script src="scripts/misreport.js"></script>
<script>
                            const slider = document.querySelector('.scrl-repo-tblwrap');
                            let mouseDown = false;
                            let startX, scrollLeft;

                            let startDragging = function (e) {
                                mouseDown = true;
                                startX = e.pageX - slider.offsetLeft;
                                scrollLeft = slider.scrollLeft;
                            };
                            let stopDragging = function (event) {
                                mouseDown = false;
                            };

                            slider.addEventListener('mousemove', (e) => {
                                e.preventDefault();
                                if (!mouseDown) {
                                    return;
                                }
                                const x = e.pageX - slider.offsetLeft;
                                const scroll = x - startX;
                                slider.scrollLeft = scrollLeft - scroll;
                            });

                            slider.addEventListener('mousedown', startDragging, false);
                            slider.addEventListener('mouseup', stopDragging, false);
                            slider.addEventListener('mouseleave', stopDragging, false);
</script>

</html>