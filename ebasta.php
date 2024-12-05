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
                        <div class="col-pagename left">Upload E-BASTA FILES
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                </div>

                <div class="clr"></div>
                <div class="filter-div" style="border-bottom: 2px solid #ddd; padding: 0px 0px 10px 0px;">
                    <div class="ebasta_select dev_req_msg left rmarg">
                        <select id="type">
                            <option value="1">By Village</option>
                            <option value="2">By Gata</option>
                        </select>
                        <div class="ebasta_select__arrow"></div>
                    </div>
                    <div class="ebasta_select dev_req_msg left rmarg">
                        <select id="village_code">
                            <option value="">Select Village</option>
                            <?php foreach ($villageInfo as $sKey => $sValue) { ?>
                                <option value="<?php echo $sValue['VillageCode']; ?>"><?php echo $sValue['VillageName']; ?></option>
                            <?php } ?>
                        </select>
                        <div class="ebasta_select__arrow"></div>
                    </div>
                    <div class="tbl-data right posrel" title="Export Excel">
                        <div class="posabsolut act_btn_ovrly"></div>
                        <a style="cursor:pointer;" class="export_village_ansh_excel" id="all">
                            <img src="img/excel.svg" height="22px">
                        </a>
                    </div>
                    <?php if ($user_type == '2') { ?>
                        <div class="tbl-data right posrel" title="Give report feedback">
                            <div class="posabsolut act_btn_ovrly"></div>
                            <a style="cursor:pointer;" class="report_feedback" id="3" report_type="village_wise">
                                <img src="img/click_action.svg" height="25px">
                            </a>
                        </div>
                    <?php } ?>
                    <div class="clr"></div>
                </div>

                <div class="bmarg filter-div hide gata_div" style="border-bottom: 2px solid #ddd; padding: 0px 0px 10px 0px;">
                    <div class="gata_kashtkar_div bmarg">
                        <div class="ebasta_gata_select dev_req_msg left rmarg hide">
                            <select class="village_gata fldrequired" id="village_gata" name="gata[]">
                                <option value="">Select Gata</option>
                            </select>
                            <div class="ebasta_gata_select__arrow"></div>
                        </div>
                        <div class="ebasta_gata_select dev_req_msg left rmarg hide">
                            <select class="village_khata fldrequired" id="village_khata" name="khata[]">
                                <option value="">Select Khata</option>
                            </select>
                            <div class="ebasta_gata_select__arrow"></div>
                        </div>
                        <div class="ebasta_select dev_req_msg left rmarg hide">
                            <select class="kashtkar fldrequired" name="kashtkar[]">
                                <option value="">Select Kashtkar</option>
                            </select>
                            <div class="ebasta_select__arrow"></div>
                        </div>
                        <div class="append_ansh_rakba_div"></div>
                        <div class="posrel left lmarg hide" style="width:28px; height:28px; top:4px;">
                            <a class="ebasta_dwnldfilediv dwnld_ebasta_doc1" title="Download Sehmati Document" target="_blank">
                                <div style="position: relative;">
                                    <img src="img/download_1.svg">
                                </div>
                            </a>
                        </div>
                        <div class="posrel left lmarg hide" style="width:28px; height:28px; top:4px;">
                            <a class="ebasta_dwnldfilediv dwnld_ebasta_doc2" title="Download Bainama/Letter Document" target="_blank">
                                <div style="position: relative;">
                                    <img src="img/download_1.svg">
                                </div>
                            </a>
                        </div>
                        <div class="posrel left lmarg hide" style="width:28px; height:28px; top:4px;" target="_blank">
                            <a class="ebasta_dwnldfilediv dwnld_ebasta_doc3" title="Download Kabza Document">
                                <div style="position: relative;">
                                    <img src="img/download_1.svg">
                                </div>
                            </a>
                        </div>
                        <div class="posrel left lmarg hide" style="width:28px; height:28px; top:4px;" target="_blank">
                            <a class="ebasta_dwnldfilediv dwnld_ebasta_doc4" title="Download Khatauni Document">
                                <div style="position: relative;">
                                    <img src="img/download_1.svg">
                                </div>
                            </a>
                        </div>
                        <div class="posrel left lmarg hide" style="width:28px; height:28px; top:4px;" target="_blank">
                            <a class="ebasta_dwnldfilediv dwnld_ebasta_doc5" title="Download Titimma Document">
                                <div style="position: relative;">
                                    <img src="img/download_1.svg">
                                </div>
                            </a>
                        </div>
                        <div class="clr"></div>
                    </div>

                    <div class="clr"></div>
                    <div id="appendDiv"></div>
                    <div class="left rmarg hide">
                        <a id="add_more_kashtkar" style="cursor: pointer; font-size: 14px; line-height: 40px; font-weight: 500; color: blue;">+ Add more kashtkar</a>
                    </div>
                    <div class="right rmarg hide">
                        <a id="add_kashtkar" style="cursor: pointer; font-size: 14px; line-height: 40px; font-weight: 500; color: green;">+ Create kashtkar</a>
                    </div>
                    <div class="clr"></div>
                    <div class="left rmarg hide">
                        <label><input type="checkbox" class="titimma_chk chk">क्या इन गाटों में तितिम्मा हुआ है ?</label>
                    </div>
                    <div class="clr"></div>
                </div>

                <div class="containerDiv posrel" style="min-height: 500px;">

                </div>
            </div>
            <div class="clr"></div>
            <?php include "includes/footer.php"; ?>
        </div>
    </div>
    <div id="notify"></div>
</body>
<script src="scripts/jquery-ui.min.js"></script>
<script src="scripts/jquery.confirm.js"></script>
<script src="scripts/common.js"></script>
<script src="scripts/syncdata.js"></script>
</html>