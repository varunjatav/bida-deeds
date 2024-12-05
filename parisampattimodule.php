<?php
include_once 'config.php';
include_once 'includes/checkSession.php';
include_once 'includes/get_time_zone.php';
include_once 'dbcon/db_connect.php';
include_once 'functions/common.function.php';
include_once 'core/permission.core.php';
include_once 'core/parisampattiModule.core.php';
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
    <style>
        .dept-frm-input {
            width: 160px !important;
            margin-right: 25px;
            margin-left: 5px;
            font-size: 12px;
        }
        .popup_header{
            display: flex;
            margin-left: 5px;
        }
        .pop_header_name{
            margin-left: 5px;
            font-size: 14px;
            color: blue;
        }
        .title-text-name{
            left:5px;
        }
    </style>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <div id="appendFilter"></div>
    <div class="wrapper">
        <div class="col-wrapper">
            <?php include "includes/sidebarmenu.php"; ?>
            <div class="full-column db-cont-wrap right dev_wrap">
                <div class="column-head">
                    <div class="left pageback" style="display:flex;">
                        <a style="cursor: pointer;" onclick="history.go(-1)">
                            <img src="img/back.svg" alt="" width="18px">
                        </a>
                        <div class="col-pagename left">Parisampatti Module (<tCount><?php echo $total_count; ?></tCount>)
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="master-creation right">
                        <div class="posabsolut act_btn_ovrly"></div>
                        <a style="cursor:pointer;" class="add_new_parisampatti">
                            <span class="crticn"><img src="img/plus.svg" alt="" width="16px"></span>
                            <span class="crtxt">Add New Parisampatti</span>
                            <div class="clr"></div>
                        </a>
                    </div>
                    <div class="clr"></div>
                </div>

                <div class="expDiv" style="margin-top: 20px;">
                    <!--                    <div class="posrel" style="margin-bottom: 10px;">
                                            <p class="hero-head" style="cursor: pointer;">
                                                <span>Parisampatti Reports</span>
                                                <img src="img/down-arrow.svg" height="20">
                                            </p>
                                        </div>-->
                    <div class="hero-box" style="margin-top: 20px;">
                        <div class="left-box" style="width: 99.5%;">
                            <div class="main-card">
                                <ul class="cards">
                                    <li class="cards_item posrel" id="data_block_1">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo 'परिसम्पत्ति जो बीडा के नाम हो गई'; ?></span><span class="view_data card_text" id="dashboard_data_1"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_2">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo 'उन काश्तकारों की सूची जहां दर शीट में एक ही परिसम्पत्तियों का मूल्यांकन विभाग द्वारा किए गए सर्वेक्षण से भिन्न है
'; ?></span><span class="view_data card_text" id="dashboard_data_2"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_3">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content">
                                                <p><span class="text-name"><?php echo 'काश्तकारों की सूची जहां विभाग ने 1 या अधिक भिन्न काश्तकारों के लिए समान प्रकार की परिसंपत्ति का अलग-अलग मूल्यांकन किया है
'; ?></span><span class="view_data card_text" id="dashboard_data_3"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_4">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo 'काश्तकार की सूची जहां अपलोड बैनामें की परिसम्पत्ति के मूल्य एवं दर निर्धारण समिति के परिसम्पत्ति के मूल्य में अन्तर है।'; ?> </span><span class="view_data card_text" id="dashboard_data_4"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clr"></div>
                <div class="filter-div">
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
                    <div class="tbl-data right posrel" title="Export Excel">
                        <div class="posabsolut act_btn_ovrly"></div>
                        <a style="cursor:pointer;" class="export_excel" id="all">
                            <img src="img/excel.svg" height="22px">
                        </a>
                    </div>
                    <div class="right fltrbtn lmarg" style="cursor:pointer;" nav="all" id="showFilter">
                        <span><img src="img/filterb.svg" height="18px;" alt=""></span>
                        <p>Search &amp; Filter</p>
                        <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                    <div class="filter-nos left hide"></div>
                    <div id="appliedFilter"></div>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
                <div class="scrl-tblwrap">
                    <div class="containerDiv">

                        <div class="rowDivHeader">
                            <div class="cellDivHeader">
                                <p>विभाग का नाम</p><a style="cursor:pointer;" onclick="sort_name(1, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>गाँव का नाम</p><a style="cursor:pointer;" onclick="sort_name(2, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>गाटा नम्बर</p><a style="cursor:pointer;" onclick="sort_name(3, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>खाता नम्बर</p><a style="cursor:pointer;" onclick="sort_name(4, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>संपत्ति संख्या</p><a style="cursor:pointer;" onclick="sort_name(5, 'numeric');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>वृक्षों की कुल राशि (सॉफ्टवेर द्वारा)</p><a style="cursor:pointer;" onclick="sort_name(6, 'numeric');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>कुल राशि</p><a style="cursor:pointer;" onclick="sort_name(7, 'numeric');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                        </div>
                        <div id="main-body" style="display: contents;">
                            <?php if ($total_count == 0) {
                                ?>
                                <div class="blank-widget">
                                    <a>No Data Found</a>
                                </div>
                            <?php } else { ?>
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    foreach ($parisamInfo as $peky => $row) {

                                        if ($row['DifferentAmountType'] == '1') {
                                            $row_color = 'row-highlight-yellow';
                                        } else {
                                            $row_color = '';
                                        }
                                        $total_dimenAmt = $surveyAmount[$row['ID']]['total_dimenAmt'] ? $surveyAmount[$row['ID']]['total_dimenAmt'] : 0;

                                        $manual_amt = $surveyAmount[$row['ID']]['manual_amt'] ? $surveyAmount[$row['ID']]['manual_amt'] : 0;
                                        ?>
                                        <div class="rowDiv <?php echo $row_color; ?>">
                                            <div class="cellDiv col1">
                                                <?php echo $row['DepartmentName'] ? $row['DepartmentName'] : '--'; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageName'] ? $row['VillageName'] : '--'; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo'] ? $row['GataNo'] : '--'; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['KhataNo'] ? $row['KhataNo'] : '--'; ?>
                                            </div>
                                            <div class="cellDiv col5" name="<?php echo $row['DateCreated']; ?>">
                                                <a style="cursor:pointer; color: blue;" class="parisamaptti_details" id="<?php echo encryptIt($row['ID']); ?>" village_name="<?php echo $row['VillageName']; ?>" gata_no="<?php echo $row['GataNo']; ?>" khata_no="<?php echo $row['KhataNo']; ?>" department_name="<?php echo $row['DepartmentName']; ?>">
                                                    <?php echo 'Count (' . ($row['PropertyCount'] ? $row['PropertyCount'] : 0) . ')'; ?>
                                                </a>
                                            </div>
                                            <div class="cellDiv col6" name="<?php echo $total_dimenAmt; ?>">
                                                <?php echo format_rupees($total_dimenAmt); ?>
                                            </div>
                                            <div class="cellDiv col7" name="<?php echo $manual_amt; ?>">
                                                <?php echo format_rupees($manual_amt); ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <?php
                            if ($output) {
                                ?>
                                <div class="pagination">
                                    <div class="left rsltpp">
                                        <div class="rsl-hding left">Result Per Page</div>
                                        <div class="rsl-counter left posrel">
                                            <a style="cursor:pointer;" class="perPage">100</a>
                                            <ul class="posabsolut" style="display: none;">
                                                <li><a style="cursor:pointer;" class="setPage">1000</a></li>
                                                <li><a style="cursor:pointer;" class="setPage">500</a></li>
                                                <li><a style="cursor:pointer;" class="setPage">200</a></li>
                                                <li><a style="cursor:pointer;" class="setPage">100</a></li>
                                                <li><a style="cursor:pointer;" class="setPage">50</a></li>
                                            </ul>
                                        </div>
                                        <div class="clr"></div>
                                    </div>
                                    <div class="right pgntn">
                                        <?php echo $output; ?>
                                        <div class="clr"></div>
                                    </div>
                                    <input type="hidden" id="pagelimit" autocomplete="off" value="100">
                                    <input type="hidden" id="srno" autocomplete="off" value="<?php echo $srno; ?>">
                                    <div class="clr"></div>
                                </div>
                                <?php
                            } else {
                                ?>
                                <input type="hidden" id="pagelimit" autocomplete="off" value="100">
                                <input type="hidden" id="srno" autocomplete="off" value="0">
                                <?php
                            }
                            ?>
                        </div>
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
<script src="scripts/parisampattimodule.js"></script>
<script>
                                    $(document).ready(function () {
                                        $('.full-column').on('click', '.paginate', function () {
                                            loadMoreParisampattiModule(parseInt($(this).text()) - 1);
                                        });
                                        $('.full-column').on('click', '.paginate_next', function () {
                                            loadMoreParisampattiModule(parseInt($('.current').attr('id')));
                                        });
                                        $('.full-column').on('click', '.paginate_prev', function () {
                                            loadMoreParisampattiModule(parseInt($('.current').attr('id')) - 2);
                                        });
                                        $('.full-column').on('click', '.paginate_last', function () {
                                            loadMoreParisampattiModule(parseInt($('.paginate:last').text()) - 1);
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