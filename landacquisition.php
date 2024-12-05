<?php
include_once 'config.php';
include_once 'includes/checkSession.php';
include_once 'includes/get_time_zone.php';
include_once 'dbcon/db_connect.php';
include_once 'functions/common.function.php';
include_once 'core/permission.core.php';
include_once 'core/consolidateVillageReport.core.php';
include_once 'core/village.core.php';
include_once 'languages/' . $lang_file;
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
    <style type="text/css">
        .cellDivHeader p {
            font-size: 16px;
            font-weight: 600;
        }
    </style>
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
                        <div class="col-pagename left">Land Acquisition Module
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                </div>

                <div class="clr"></div>
                <div class="filter-div" style="border-bottom: 2px solid #f00; padding: 0px 0px 10px 0px;">

                    <div class="ebasta_select dev_req_msg left rmarg">
                        <select id="village_code">
                            <option value="">Select Village</option>
                            <?php foreach ($villageInfo as $sKey => $sValue) { ?>
                                <option value="<?php echo $sValue['VillageCode']; ?>"><?php echo $sValue['VillageName']; ?></option>
                            <?php } ?>
                        </select>
                        <div class="ebasta_select__arrow"></div>
                    </div>
                    <div class="ebasta_select dev_req_msg left rmarg">
                        <select id="village_gata">
                            <option value="">Select Gata</option>
                        </select>
                        <div class="ebasta_select__arrow"></div>
                    </div>
                    <div class="left fltrbtn" style="cursor:pointer; border-radius: 4px; margin-top: 0;" id="showGataReports">
                        <p>Show Gata Report</p>
                        <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
                <div class="scrl-tblwrap" style="padding:10px; height: 42vh;">
                    <div class="containerDiv">
                        <div class="rowDivHeader" style="">
                            <div class="cellDivHeader">
                                <p>क्रo सo</p>
                            </div>
                            <div class="cellDivHeader">
                                <p>गाटे के परीक्षण का बिंदु/सवाल</p>
                            </div>
                            <div class="cellDivHeader">
                                <p>रिजल्ट</p>
                            </div>
                        </div>
                        <div id="main-body" style="display: contents; font-size: 16px;">
                            <div id="paginate-body" style="display: contents;">
                                <div class="rowDiv <?php echo $answer_color_6; ?>">
                                    <div class="cellDiv col1">
                                        <?php echo $count++; ?>
                                    </div>
                                    <div class="cellDiv col2">
                                        ऐसे गाटो की संख्या जो 1359 फसली खसरे के अनुसर सुरक्षित श्रेणि में है
                                    </div>
                                    <div class="cellDiv col3">
                                        <a style="cursor:pointer;" class="view_report_data" id="report_data_3"><?php echo $answer_6; ?></a>
                                    </div>
                                </div>
                                <div class="rowDiv <?php echo $answer_color_7; ?>">
                                    <div class="cellDiv col1">
                                        <?php echo $count++; ?>
                                    </div>
                                    <div class="cellDiv col2">
                                        ऐसे गाटो की संख्या जिनकी वर्तमान श्रेनी सीएच 41-45 के समान नहीं है
                                    </div>
                                    <div class="cellDiv col3">
                                        <a style="cursor:pointer;" class="view_report_data" id="report_data_4"><?php echo $answer_7; ?></a>
                                    </div>
                                </div>
                                <div class="rowDiv <?php echo $answer_color_8; ?>">
                                    <div class="cellDiv col1">
                                        <?php echo $count++; ?>
                                    </div>
                                    <div class="cellDiv col2">
                                        ऐसे गाटो की संख्या जिनका वर्तमान रकबा 1359 फसली के रकबे के बराबर नहीं है
                                    </div>
                                    <div class="cellDiv col3">
                                        <a style="cursor:pointer;" class="view_report_data" id="report_data_5"><?php echo $answer_8; ?></a>
                                    </div>
                                </div>
                                <div class="rowDiv <?php echo $answer_color_10; ?>">
                                    <div class="cellDiv col1">
                                        <?php echo $count++; ?>
                                    </div>
                                    <div class="cellDiv col2">
                                        ऐसे गाटो की संख्या जिनका वर्तमान रकबा सीएच 41-45 के रकबे के बराबर नहीं है
                                    </div>
                                    <div class="cellDiv col3">
                                        <a style="cursor:pointer;" class="view_report_data" id="report_data_6"><?php echo $answer_10; ?></a>
                                    </div>
                                </div>
                                <div class="rowDiv">
                                    <div class="cellDiv col1">
                                        <?php echo $count++; ?>
                                    </div>
                                    <div class="cellDiv col2">
                                        ऐसे गाटो की संख्या जहां गाटे का भूमि मूल्य सर्किल रेट के चार गुने से अधिक है
                                    </div>
                                    <div class="cellDiv col3">
                                        <a style="cursor:pointer;" class="view_report_data" id="report_data_13"><?php echo $answer_18; ?></a>
                                    </div>
                                </div>
                                <div class="rowDiv">
                                    <div class="cellDiv col1">
                                        <?php echo $count++; ?>
                                    </div>
                                    <div class="cellDiv col2">
                                        ऐसे गाटो की संख्या जहां परिसम्पत्तियों का मुल्य कुल भूमि के मुल्य के 10 प्रतिषत से अधिक है
                                    </div>
                                    <div class="cellDiv col3">
                                        <a style="cursor:pointer;" class="view_report_data" id="report_data_14"><?php echo $answer_19; ?></a>
                                    </div>
                                </div>
                                <div class="rowDiv">
                                    <div class="cellDiv col1">
                                        <?php echo $count++; ?>
                                    </div>
                                    <div class="cellDiv col2">
                                        ऐसे गाटो की संख्या जहां एक से अधिक प्रकार की दर निर्धारित की गई है
                                    </div>
                                    <div class="cellDiv col3">
                                        <a style="cursor:pointer;" class="view_report_data" id="report_data_10"><?php echo $answer_15; ?></a>
                                    </div>
                                </div>
                            </div>
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
            <input type="hidden" id="name_order" value="asc">
            <div class="clr"></div>
            <?php include "includes/footer.php"; ?>
        </div>
    </div>
    <div id="notify"></div>
</body>
<script src="scripts/jquery-ui.min.js"></script>
<script src="scripts/jquery.confirm.js"></script>
<script src="scripts/common.js"></script>
<script src="scripts/highcharts.js"></script>
<script src="scripts/landacquisition.js"></script>
</html>