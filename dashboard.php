<?php
include_once 'config.php';
include_once 'includes/checkSession.php';
include_once 'includes/get_time_zone.php';
include_once 'dbcon/db_connect.php';
include_once 'functions/common.function.php';
include_once 'core/permission.core.php';
//include_once 'core/dashboard.core.php';
//include_once 'core/village.core.php';
include_once 'languages/' . $lang_file;
header('location: landdatalist');
exit();
?>
<!doctype html>
<html>

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
                a("body").css("display", "block")
            });
        </script>
    </head>

    <body>
        <?php include "includes/header.php"; ?>

        <div class="col-wrapper dev_wrap">
            <?php include "includes/sidebarmenu.php"; ?>
            <div class="full-column db-cont-wrap right">
                <div class="column-head">
                    <div class="left pageback" style="display:flex;">
                        <a style="cursor: pointer;" onclick="history.go(-1)">
                            <img src="img/back.svg" alt="" width="18px">
                        </a>
                        <div class="col-pagename left">Dashboard</div>
                        <div class="clr"></div>
                    </div>
                    <?php if ($user_type == '2') { ?>
                        <div class="tbl-data right posrel" title="Give report feedback">
                            <div class="posabsolut act_btn_ovrly"></div>
                            <a style="cursor:pointer;" class="report_feedback" id="1" report_type="dashboard_data">
                                <img src="img/click_action.svg" height="25px">
                            </a>
                        </div>
                    <?php } ?>
                    <div class="clr"></div>
                </div>

                <div class="hero-box" style="margin-top: 10px;">
                    <div class="left-box" style="overflow: hidden; width: 50%">
                        <div class="main-card">
                            <div id="dash_chart_0" style="height: 1600px;"></div>
                        </div>
                    </div>
                    <div class="right-box" style="overflow: hidden; width: 50%">
                        <div class="main-card">
                            <div id="dash_chart_1" style="height: 400px;"></div>
                        </div>
                        <div class="main-card">
                            <div id="dash_chart_2" style="height: 400px;"></div>
                        </div>
                        <div class="main-card">
                            <div id="dash_chart_3" style="height: 400px;"></div>
                        </div>
                        <div class="main-card">
                            <div id="dash_chart_4" style="height: 400px;"></div>
                        </div>
                    </div>
                </div>

                <div class="hero-box" style="margin-top: 20px;">
                    <div class="left-box" style="width: 99.5%;">
                        <div class="main-card">
                            <ul class="dash_cards">
                                <li class="dash_cards_item posrel" id="pmt_data_block_1">
                                    <div class="block_loader"></div>
                                    <div class="dash_card">
                                        <div class="card_content">
                                            <div class="posabsolut act_btn_ovrly"></div>
                                            <p><span class="text-name"><?php echo $lang['PMT_DASH_BLOCK_1']; ?></span><span class="view_pmt_data card_text" id="pmt_dash_data_1"></span></p>
                                        </div>
                                    </div>
                                </li>
                                <li class="dash_cards_item posrel" id="pmt_data_block_2">
                                    <div class="block_loader"></div>
                                    <div class="dash_card">
                                        <div class="card_content">
                                            <p><span class="text-name"><?php echo $lang['PMT_DASH_BLOCK_2']; ?></span><span class="view_pmt_data card_text" id="pmt_dash_data_2"></span></p>
                                        </div>
                                    </div>
                                </li>
                                <li class="dash_cards_item posrel" id="pmt_data_block_3">
                                    <div class="block_loader"></div>
                                    <div class="dash_card">
                                        <div class="card_content">
                                            <div class="posabsolut act_btn_ovrly"></div>
                                            <p><span class="text-name"><?php echo $lang['PMT_DASH_BLOCK_3']; ?></span><span class="view_pmt_data card_text" id="pmt_dash_data_3"></span></p>
                                        </div>
                                    </div>
                                </li>
                                <li class="dash_cards_item posrel" id="pmt_data_block_4">
                                    <div class="block_loader"></div>
                                    <div class="card posrel">
                                        <div class="card_content">
                                            <p><span class="text-name"><?php echo $lang['PMT_DASH_BLOCK_4']; ?></span><span class="view_pmt_data card_text" id="pmt_dash_data_4"></span></p>
                                        </div>
                                    </div>
                                </li>
                                <li class="dash_cards_item posrel" id="pmt_data_block_5">
                                    <div class="block_loader"></div>
                                    <div class="dash_card">
                                        <div class="card_content">
                                            <div class="posabsolut act_btn_ovrly"></div>
                                            <p><span class="text-name"><?php echo $lang['PMT_DASH_BLOCK_5']; ?></span><span class="view_pmt_data card_text" id="pmt_dash_data_5"></span></p>
                                        </div>
                                    </div>
                                </li>
                                <li class="dash_cards_item posrel" id="pmt_data_block_6">
                                    <div class="block_loader"></div>
                                    <div class="card posrel">
                                        <div class="card_content">
                                            <p><span class="text-name"><?php echo $lang['PMT_DASH_BLOCK_6']; ?></span><span class="view_pmt_data card_text" id="pmt_dash_data_6"></span></p>
                                        </div>
                                    </div>
                                </li>
                                <li class="dash_cards_item posrel" id="pmt_data_block_7">
                                    <div class="block_loader"></div>
                                    <div class="dash_card">
                                        <div class="card_content">
                                            <div class="posabsolut act_btn_ovrly"></div>
                                            <p><span class="text-name"><?php echo $lang['PMT_DASH_BLOCK_7']; ?></span><span class="view_pmt_data card_text" id="pmt_dash_data_7"></span></p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="hero-box" style="margin-top: 20px;">
                    <div class="left-box" style="width: 99.5%;">
                        <div class="main-card">
                            <ul class="dash_cards">
                                <li class="report_cards_item posrel">
                                    <div class="">
                                        <div class="report_content">
                                            <div class="ebasta_select dev_req_msg left">
                                                <select id="village_code">
                                                    <option value="">Select Village</option>
                                                    <?php foreach ($villageInfo as $sKey => $sValue) { ?>
                                                        <option value="<?php echo $sValue['VillageCode']; ?>"><?php echo $sValue['VillageName']; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <div class="ebasta_select__arrow"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="report_content">
                                            <div class="ebasta_select dev_req_msg left">
                                                <select id="village_gata">
                                                    <option value="">Select Gata</option>
                                                </select>
                                                <div class="ebasta_select__arrow"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="report_content">
                                            <div class="right fltrbtn" style="cursor:pointer; border-radius: 4px; margin-top: 0;" id="showGataReports">
                                                <p>Show Gata Report</p>
                                                <div class="clr"></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="expDiv" style="margin-top: 20px;">
                    <div class="posrel" style="margin-bottom: 10px;">
                        <p class="hero-head" style="cursor: pointer;">
                            <span>Other Reports</span>
                            <img src="img/down-arrow.svg" height="20">
                        </p>
                    </div>
                    <div class="hero-box" style="display: none;">
                        <div class="left-box">
                            <div class="main-card">
                                <ul class="cards">
                                    <li class="cards_item posrel" id="data_block_1">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_1']; ?></span><span class="view_data card_text" id="dashboard_data_1"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_2">
                                        <div class="block_loader"></div>
                                        <div class="card posrel">
                                            <div class="card_content">
                                                <p class="border-right"><span class="text-name"><?php echo $lang['DASH_BLOCK_2_1']; ?></span><span class="view_data card_text" id="dashboard_data_2"></span></p>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_2_2']; ?></span><span class="view_data card_text" id="dashboard_data_3"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_3">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_3']; ?></span><span class="view_data card_text" id="dashboard_data_12"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_4">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content">
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_4']; ?></span><span class="view_data card_text" id="dashboard_data_6"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_5">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_5']; ?> </span><span class="view_data card_text" id="dashboard_data_13"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_6">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content">
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_6']; ?></span><span class="view_data card_text" id="dashboard_data_15"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_7">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_7']; ?></span><span class="view_data card_text" id="dashboard_data_14"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_8">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content">
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_8']; ?></span><span class="view_data card_text" id="dashboard_data_16"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_9">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_9']; ?></span><span class="view_data card_text" id="dashboard_data_17"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_10">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content">
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_10']; ?></span><span class="view_data card_text" id="dashboard_data_8"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_11">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_11']; ?></span><span class="view_data card_text" id="dashboard_data_18"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_12">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content">
                                                <p class="border-right"><span class="text-name"><?php echo $lang['DASH_BLOCK_12_1']; ?></span><span class="view_data card_text" id="dashboard_data_20"></span></p>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_12_2']; ?></span><span class="view_data card_text" id="dashboard_data_21"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_13">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_13']; ?></span><span class="view_data card_text" id="dashboard_data_19"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_14">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content">
                                                <p class="border-right"><span class="text-name"><?php echo $lang['DASH_BLOCK_14_1']; ?></span><span class="view_data card_text" id="dashboard_data_22"></span></p>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_14_2']; ?></span><span class="view_data card_text" id="dashboard_data_23"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_15">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_15']; ?></span><span class="view_data card_text" id="dashboard_data_24"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_16">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content">
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_16']; ?></span><span class="view_data card_text" id="dashboard_data_25"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_17">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_17']; ?></span><span class="view_data card_text" id="dashboard_data_4"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_18">
                                        <div class="block_loader"></div>
                                        <div class="card posrel">
                                            <div class="card_content">
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_18']; ?></span><span class="view_data card_text" id="dashboard_data_48"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_19">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_19']; ?></span><span class="view_data card_text" id="dashboard_data_4"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_20">
                                        <div class="block_loader"></div>
                                        <div class="card posrel">
                                            <div class="card_content">
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_20']; ?></span><span class="view_data card_text" id="dashboard_data_5"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_21">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_21']; ?></span><span class="view_data card_text" id="dashboard_data_4"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_22">
                                        <div class="block_loader"></div>
                                        <div class="card posrel">
                                            <div class="card_content">
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_22']; ?></span><span class="view_data card_text" id="dashboard_data_49"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_23">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_23']; ?></span><span class="view_data card_text" id="dashboard_data_4"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_24">
                                        <div class="block_loader"></div>
                                        <div class="card posrel">
                                            <div class="card_content">
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_24']; ?></span><span class="view_data card_text" id="dashboard_data_50"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_50">
                                        <div class="block_loader"></div>
                                        <div class="card posrel">
                                            <div class="card_content">
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_50']; ?></span><span class="view_data card_text" id="dashboard_data_40"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_25">
                                        <div class="block_loader"></div>
                                        <div class="card posrel">
                                            <div class="card_content">
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_25']; ?></span><span class="view_data card_text" id="dashboard_data_41"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_26">
                                        <div class="block_loader"></div>
                                        <div class="card posrel">
                                            <div class="card_content">
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_26']; ?></span><span class="view_data card_text" id="dashboard_data_42"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_27">
                                        <div class="block_loader"></div>
                                        <div class="card posrel">
                                            <div class="card_content">
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_27']; ?></span><span class="view_data card_text" id="dashboard_data_43"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_28">
                                        <div class="block_loader"></div>
                                        <div class="card posrel">
                                            <div class="card_content">
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_28']; ?></span><span class="view_data card_text" id="dashboard_data_44"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_29">
                                        <div class="block_loader"></div>
                                        <div class="card posrel">
                                            <div class="card_content">
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_29']; ?> </span><span class="view_data card_text" id="dashboard_data_45"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_30">
                                        <div class="block_loader"></div>
                                        <div class="card posrel">
                                            <div class="card_content">
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_30']; ?></span><span class="view_data card_text" id="dashboard_data_46"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_53">
                                        <div class="block_loader"></div>
                                        <div class="card posrel">
                                            <div class="card_content">
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_53']; ?></span><span class="view_data card_text" id="dashboard_data_53"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_54">
                                        <div class="block_loader"></div>
                                        <div class="card posrel">
                                            <div class="card_content">
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_54']; ?></span><span class="view_data card_text" id="dashboard_data_54"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_55">
                                        <div class="block_loader"></div>
                                        <div class="card posrel">
                                            <div class="card_content">
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_55']; ?></span><span class="view_data card_text" id="dashboard_data_55"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_56">
                                        <div class="block_loader"></div>
                                        <div class="card posrel">
                                            <div class="card_content">
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_56']; ?></span><span class="view_data card_text" id="dashboard_data_56"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_31">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_31']; ?></span><span class="view_data card_text" id="dashboard_data_7"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_32">
                                        <div class="block_loader"></div>
                                        <div class="card posrel">
                                            <div class="card_content">
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_32']; ?></span><span class="view_data card_text" id="dashboard_data_9"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_33">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_33']; ?></span><span class="view_data card_text" id="dashboard_data_11"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_34">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_34']; ?></span><span class="view_data card_text" id="dashboard_data_26"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_35">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_35']; ?></span><span class="view_data card_text" id="dashboard_data_27"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_36">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_36']; ?></span><span class="view_data card_text" id="dashboard_data_28"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_37">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_37']; ?></span><span class="view_data card_text" id="dashboard_data_29"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_38">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_38']; ?></span><span class="view_data card_text" id="dashboard_data_30"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_39">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_39']; ?></span><span class="view_data card_text" id="dashboard_data_31"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_40">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_40']; ?></span><span class="view_data card_text" id="dashboard_data_32"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_41">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_41']; ?></span><span class="view_data card_text" id="dashboard_data_33"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_42">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_42']; ?></span><span class="view_data card_text" id="dashboard_data_34"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_43">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_43']; ?></span><span class="view_data card_text" id="dashboard_data_35"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_45">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_45']; ?></span><span class="view_data card_text" id="dashboard_data_47"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_46">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_46']; ?></span><span class="view_data card_text" id="dashboard_data_36"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_47">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_47']; ?></span><span class="view_data card_text" id="dashboard_data_37"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_48">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_48']; ?></span><span class="view_data card_text" id="dashboard_data_38"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_49">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_49']; ?></span><span class="view_data card_text" id="dashboard_data_39"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_51">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_51']; ?></span><span class="view_data card_text" id="dashboard_data_51"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_52">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo $lang['DASH_BLOCK_52']; ?></span><span class="view_data card_text" id="dashboard_data_52"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="clr"></div>
            <div id="notify"></div>
            <input type="hidden" id="tiles_count" value="">
            <input type="hidden" id="chart_2_y_axis" value="<?php echo implode(',', $chart_2_y_axis); ?>" autocomplete="off">
        </div>
    </body>
    <script src="scripts/jquery-ui.js"></script>
    <script src="scripts/highcharts.js"></script>
    <script src="scripts/common.js"></script>
    <script src="scripts/dashboard.js"></script>
    <script src="scripts/accessibility.js"></script>
    <script>
                            $(document).ready(function () {
                                var chart_2_y_axis = $("#chart_2_y_axis").val();
                                var chart_2_y_axis_arr = chart_2_y_axis.split(',');

                                var a_village_percent = <?php echo json_encode($a_village_percent); ?>;
                                var b_village_percent = <?php echo json_encode($b_village_percent); ?>;

                                Highcharts.chart('dash_chart_0', {
                                    chart: {
                                        type: 'bar'
                                    },
                                    title: {
                                        text: '',
                                        align: 'left'
                                    },
                                    xAxis: {
                                        categories: <?php echo json_encode($chart_0_x_axis); ?>,
                                        title: {
                                            text: null
                                        },
                                        gridLineWidth: 1,
                                        lineWidth: 0
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: '',
                                            align: 'low'
                                        },
                                        labels: {
                                            overflow: 'justify'
                                        },
                                        gridLineWidth: 0
                                    },
                                    tooltip: {
                                        valueSuffix: ' Hectares'
                                    },
                                    plotOptions: {
                                        bar: {
                                            borderRadius: '50%',
                                            dataLabels: {
                                                enabled: false
                                            },
                                            groupPadding: 0.1
                                        }
                                    },
                                    credits: {
                                        enabled: false
                                    },
                                    series: [{
                                            name: 'Total Area',
                                            data: <?php echo json_encode($total_area_of_village); ?>
                                        }, {
                                            name: 'Darnirdharit + Resumpted Area',
                                            data: <?php echo json_encode($village_dar_nirdharit_and_resumpted_area); ?>
                                        }, {
                                            name: 'Purchased + Resumpted Area',
                                            dataLabels: {
                                                enabled: true,
                                                formatter: function () {
                                                    return '(A: ' + a_village_percent[this.key] + '), (B: ' + b_village_percent[this.key] + ')';
                                                },
                                                style: {
                                                    fontSize: "11px", fontFamily: "Verdana, sans-serif, font-weight: 400"
                                                }
                                            },
                                            data: <?php echo json_encode($village_acquired_area); ?>
                                        }]
                                });


//                                Highcharts.chart('dash_chart_0', {
//                                    chart: {
//                                        type: 'bar'
//                                    },
//                                    title: {
//                                        text: 'Village wise acquired area/total area'
//                                    },
//                                    xAxis: {
//                                        categories: <?php echo json_encode($chart_0_x_axis); ?>
//                                    },
//                                    yAxis: {
//                                        min: 0,
//                                        title: {
//                                            text: ''
//                                        }
//                                    },
//                                    legend: {
//                                        reversed: true
//                                    },
//                                    plotOptions: {
//                                        bar: {
//                                            dataLabels: {
//                                                enabled: true,
//                                                formatter: function () {
//                                                    return textToDisplay[this.key];
//                                                },
//                                                style: {
//                                                    fontSize: "11px", fontFamily: "Verdana, sans-serif, font-weight: 400"
//                                                }
//                                            }
//                                        }
//                                    },
//                                    tooltip: {
//                                        formatter: function () {
//                                            return 'Purchased area <b>' + area_purchased[this.x] +
//                                                    ' (Hectares)</b>, Darnirdharit Area <b>' + darnirdharit_area[this.x] + ' (Heactares)</b>';
//                                        }
//                                    },
//                                    series: [{
//                                            color: "#00D872D9",
//                                            name: 'Acquired area (Hectares)',
//                                            pointPadding: -0.1,
//                                            pointPlacement: 0.2,
//                                            data: <?php echo json_encode($chart_0_b_y_axis); ?>,
//                                            dataLabels: {
//                                                enabled: true,
//                                                style: {
//                                                    fontSize: "11px", fontFamily: "Verdana, sans-serif, font-weight: 400"
//                                                }
//                                            }
//                                        }]
//                                });

                                Highcharts.chart('dash_chart_1', {
                                    chart: {
                                        type: 'bar'
                                    },
                                    title: {
                                        text: 'Average rate of purchase'
                                    },
                                    xAxis: {
                                        categories: <?php echo json_encode($chart_1_x_axis); ?>
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: ''
                                        }
                                    },
                                    legend: {
                                        reversed: true
                                    },
                                    plotOptions: {
                                        series: {
                                            stacking: 'normal',
                                            dataLabels: {
                                                enabled: true,
                                                style: {
                                                    fontSize: "11px", fontFamily: "Verdana, sans-serif, font-weight: 400"
                                                }
                                            }
                                        }
                                    },
                                    series: [{
                                            "color": "#45C8FF",
                                            name: 'Area (Hectares)',
                                            data: <?php echo json_encode($chart_1_y_axis); ?>
                                        }]
                                });

                                Highcharts.chart('dash_chart_2', {
                                    chart: {
                                        type: 'bar'
                                    },
                                    title: {
                                        text: 'Average rate of payment done'
                                    },
                                    xAxis: {
                                        categories: <?php echo json_encode($chart_2_x_axis); ?>
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: ''
                                        }
                                    },
                                    legend: {
                                        reversed: true
                                    },
                                    plotOptions: {
                                        series: {
                                            stacking: 'normal',
                                            dataLabels: {
                                                formatter: function () {
                                                    return changeNumberFormat(chart_2_y_axis_arr[this.series.data.indexOf(this.point)]);
                                                },
                                                enabled: true,
                                                style: {
                                                    fontSize: "11px", fontFamily: "Verdana, sans-serif, font-weight: 400", color: "#000"
                                                }
                                            }
                                        }
                                    },
                                    series: [{
                                            "color": "#19FB8B",
                                            name: 'Payment Done',
                                            data: <?php echo json_encode($chart_2_y_axis); ?>
                                        }]
                                });

                                Highcharts.chart('dash_chart_3', {
                                    chart: {
                                        type: 'bar'
                                    },
                                    title: {
                                        text: 'Month wise area acquired'
                                    },
                                    xAxis: {
                                        categories: <?php echo json_encode($chart_3_x_axis); ?>
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: ''
                                        }
                                    },
                                    legend: {
                                        reversed: true
                                    },
                                    plotOptions: {
                                        series: {
                                            stacking: 'normal',
                                            dataLabels: {
                                                enabled: true,
                                                style: {
                                                    fontSize: "11px", fontFamily: "Verdana, sans-serif, font-weight: 400"
                                                }
                                            }
                                        }
                                    },
                                    series: [{
                                            "color": "#00E272D9",
                                            name: 'Area (Hectares)',
                                            data: <?php echo json_encode($chart_3_y_axis); ?>
                                        }]
                                });

                                Highcharts.chart('dash_chart_4', {
                                    chart: {
                                        type: 'bar'
                                    },
                                    title: {
                                        text: 'Weekly area acquired'
                                    },
                                    xAxis: {
                                        categories: <?php echo json_encode($chart_4_x_axis); ?>
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: ''
                                        }
                                    },
                                    legend: {
                                        reversed: true
                                    },
                                    plotOptions: {
                                        series: {
                                            stacking: 'normal',
                                            dataLabels: {
                                                enabled: true,
                                                style: {
                                                    fontSize: "11px", fontFamily: "Verdana, sans-serif, font-weight: 400"
                                                }
                                            }
                                        }
                                    },
                                    series: [{
                                            "color": "#FEB56AD9",
                                            name: 'Area (Hectares)',
                                            data: <?php echo json_encode($chart_4_y_axis); ?>
                                        }]
                                });
                            });

                            function changeNumberFormat(number, decimals, recursiveCall) {
                                //const decimalPoints = decimals || 2;
                                const decimalPoints = 0;
                                const noOfLakhs = number / 100000;
                                let displayStr;
                                let isPlural;

                                // Rounds off digits to decimalPoints decimal places
                                function roundOf(integer) {
                                    return +integer.toLocaleString(undefined, {
                                        minimumFractionDigits: decimalPoints,
                                        maximumFractionDigits: decimalPoints,
                                    });
                                }

                                if (noOfLakhs >= 1 && noOfLakhs <= 99) {
                                    const lakhs = roundOf(noOfLakhs);
                                    isPlural = lakhs > 1 && !recursiveCall;
                                    displayStr = `${lakhs} Lac${isPlural ? 's' : ''}`;
                                } else if (noOfLakhs >= 100) {
                                    const crores = roundOf(noOfLakhs / 100);
                                    const crorePrefix = crores >= 100000 ? changeNumberFormat(crores, decimals, true) : crores;
                                    isPlural = crores > 1 && !recursiveCall;
                                    displayStr = `${crorePrefix} Cr${isPlural ? 's' : ''}`;
                                } else {
                                    displayStr = roundOf(+number);
                                }

                                return displayStr;
                            }
    </script>
</html>