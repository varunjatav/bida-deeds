<?php
include_once 'config.php';
include_once 'includes/checkSession.php';
include_once 'includes/get_time_zone.php';
include_once 'dbcon/db_connect.php';
include_once 'functions/common.function.php';
include_once 'core/permission.core.php';
include_once 'core/syncData.core.php';
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
                        <div class="col-pagename left">Generate Reports
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                </div>

                <div class="clr"></div>
                <div class="filter-div" style="border-bottom: 2px solid #f00; padding: 0px 0px 10px 0px;">
                    <div class="tbl-data right" title="Show Columns">
                        <a style="cursor:pointer;" id="columnFilter">
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
                    <div class="tbl-data right posrel" title="Export PDF">
                        <div class="posabsolut act_btn_ovrly"></div>
                        <a style="cursor:pointer;" class="export_village_report_pdf" id="allpdf">
                            <img src="img/pdficn.svg" height="22px">
                        </a>
                    </div>
                    <div class="tbl-data right posrel" title="Export Excel">
                        <div class="posabsolut act_btn_ovrly"></div>
                        <a style="cursor:pointer;" class="export_village_report_excel" id="all">
                            <img src="img/excel.svg" height="22px">
                        </a>
                    </div>
                    <?php if ($user_type == '2') { ?>
                        <div class="tbl-data right posrel" title="Give report feedback">
                            <div class="posabsolut act_btn_ovrly"></div>
                            <a style="cursor:pointer;" class="report_feedback" id="4" report_type="village_wise">
                                <img src="img/click_action.svg" height="25px">
                            </a>
                        </div>
                    <?php } ?>
                    <!--<span class="left rmarg" style="font-size: 14px; line-height: 36px;">Generate reports</span>-->
                    <div class="ebasta_gata_select dev_req_msg left rmarg">
                        <select id="type">
                            <option value="1">By Village</option>
                            <option value="2">By Gata</option>
                        </select>
                        <div class="ebasta_select__arrow"></div>
                    </div>
                    <div class="ebasta_select dev_req_msg left rmarg">
                        <select id="type1">
                            <option value="">Select</option>
                            <option value="1">Consolidated Village Report</option>
                            <option value="2">Individual Villages</option>
                            <option value="3">Grid Village Report</option>
                            <option value="4">Bainama Report</option>
                        </select>
                        <div class="ebasta_select__arrow"></div>
                    </div>
                    <div class="ebasta_select dev_req_msg left rmarg hide">
                        <select id="village_code">
                            <option value="">Select Village</option>
                            <?php foreach ($villageInfo as $sKey => $sValue) { ?>
                                <option value="<?php echo $sValue['VillageCode']; ?>"><?php echo $sValue['VillageName']; ?></option>
                            <?php } ?>
                        </select>
                        <div class="ebasta_select__arrow"></div>
                    </div>
                    <div class="ebasta_select dev_req_msg left rmarg hide">
                        <select id="type2">
                            <option value="">Select</option>
                            <option value="1">Consolidated Gata Report</option>
                            <option value="2">Individual Gata</option>
                        </select>
                        <div class="ebasta_select__arrow"></div>
                    </div>
                    <div class="ebasta_select dev_req_msg left rmarg hide">
                        <select id="report_type">
                            <option value="">Report Type</option>
                            <option value="1">ऐसे गाटे जिसकी वर्तमान खतौनी 1-क है एवं 1359 फसली खसरे में सुरक्षित श्रेणी है।</option>
                            <!--<option value="2">ऐसे गाटे जिसकी वर्तमान खतौनी 1-क है एवं 1359 फसली खसरे में कास्तकार दर्ज नहीं है। (useless)</option>-->
                            <option value="3">ऐसे गाटे जिसकी वर्तमान खतौनी 1-क है एवं 1359 फसली खसरे में किस्म कदीम, जदीद, परती, बंजर है।</option>
                            <option value="4">ऐसे गाटे जिसका 1359 रकबा वर्तमान खतौनी के रकबा से अधिक है।</option>
                            <option value="5">ऐसे गाटे जिसका 1359 रकबा वर्तमान खतौनी के रकबा से कम है।</option>
                            <option value="6">ऐसे गाटे जिनका प्रस्तावित रकबा कुल रकबे से अधिक है।</option>
                            <option value="7">ऐसे गाटे जिनका प्रस्तावित रकबा कुल रकबे से कम है।</option>
                            <option value="8">खसरे के अनुसार कृषि कार्य से भिन्न है।</option>
                            <option value="9">खसरे के अनुसार आबादी है परन्तु रेट कृषि का दिया गया है।</option>
                            <option value="10">खसरे के अनुसार कृषि हे परन्तु रेट आबादी का दिया गया है।</option>
                            <option value="11">ऐसे गाटे जिन पर कृषि की दर निर्धारित की गयी है।</option>
                            <option value="12">ऐसे गाटे जिन पर आबादी की दर निर्धारित की गयी है।</option>
                            <option value="13">ऐसे गाटे जिन पर सड़क की दर निर्धारित की गयी है।</option>
                            <option value="14">ऐसे गाटे जिन पर एक से अधिक प्रकार की दर निर्धारित की गयी है।</option>
                            <option value="15">ऐसे गाटे जिस पर भूमि मूल्य वर्त मान सर्किल रेट से कम दिया जा रहा है।</option>
                            <option value="16">ऐसे गाटे जिस पर भूमि मूल्य वर्त मान सर्किल रेट से अधिक दिया जा रहा है।</option>
                            <option value="17">ऐसे काश्तकार जहां पर दर निर्धारण से अधिक भुगतान किया जा रहा है। </option>
                            <option value="18">गाटे जिन पर वृहद परियोजना होने के कारण लिया जाना व्यवहारिक नहीं है।</option>
                            <option value="19">ऐसे गाटे जहां विवाद है।</option>
                            <option value="20">ऐसे गाटे जिनमें काश्तकार अनुसूचित जाति के हैं।</option>
                            <option value="21">ऐसे गाटे जिनमें धारा 98 के तहत अनुमति नहीं ली गई है।</option>
                            <option value="22">ऐसे गाटे जिनमें धारा 80/143 की जा चुकी है।</option>
                            <option value="23">ऐसे गाटे जहाँ मौके पर नहर है लेकिन काश्तकार का नाम दर्ज है।</option>
                            <option value="24">ऐसे गाटे जहाँ मौके पर सड़क है लेकिन काश्तकार का नाम दर्ज है।</option>
                            <option value="25">ऐसे गाटे जिनको किसी स्तर पर होल्ड/रोका गया है।</option>
                            <option value="26">ऐसे गाटे जहां वर्तमान रकबा सीएच 41,45 के रकबे से कम है।</option>
                            <option value="27">ऐसे गाटे जहां वर्तमान रकबा सीएच 41,45 के रकबे से अधिक है।</option>
                            <!--<option value="28">ऐसे गाटे जिसका 1359 फसली रकबा सीएच 41,45 की रकबा से कम है।</option>-->
                            <option value="29">ऐसे गाटे जहाँ परिसंपत्तियों का मूल्य कुल भूमि के मूल्य के 10 प्रतिशत से अधिक है।</option>
                            <option value="30">ऐसे गाटे जहाँ परिसंपत्तियों का मूल्य 10 लाख रुपये से अधिक है।</option>
                            <option value="31">ऐसे गाटे जो 28 बिन्दुओं के अनुरूप नहीं हैं।</option>
                        </select>
                        <div class="ebasta_select__arrow"></div>
                    </div>
                    <div class="ebasta_select dev_req_msg left rmarg hide">
                        <select id="village_gata">
                            <option value="">Select Gata</option>
                        </select>
                        <div class="ebasta_select__arrow"></div>
                    </div>
                    <div class="left rmarg" style="font-size: 14px; line-height: 40px; font-weight: 600; color: darkgreen;">
                        <div id="disp_row_count"></div>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
                <div class="scrl-tblwrap">
                    <div class="containerDiv">

                    </div>
                </div>
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
<script src="scripts/reports.js"></script>
<script>
                            $(document).ready(function () {
                                $('.full-column').on('click', '.paginate', function () {
                                    loadMoreVillageReport(parseInt($(this).text()) - 1);
                                });
                                $('.full-column').on('click', '.paginate_next', function () {
                                    loadMoreVillageReport(parseInt($('.current').attr('id')));
                                });
                                $('.full-column').on('click', '.paginate_prev', function () {
                                    loadMoreVillageReport(parseInt($('.current').attr('id')) - 2);
                                });
                                $('.full-column').on('click', '.paginate_last', function () {
                                    loadMoreVillageReport(parseInt($('.paginate:last').text()) - 1);
                                });
                            });

                            const slider = document.querySelector('.scrl-tblwrap');
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