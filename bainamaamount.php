<?php
include_once 'config.php';
include_once 'includes/checkSession.php';
include_once 'includes/get_time_zone.php';
include_once 'dbcon/db_connect.php';
include_once 'functions/common.function.php';
include_once 'core/permission.core.php';
include_once 'core/bainamaAmount.core.php';
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
            <div class="full-column db-cont-wrap right dev_wrap">
                <div class="column-head">
                    <div class="left pageback" style="display:flex;">
                        <a style="cursor: pointer;" onclick="history.go(-1)">
                            <img src="img/back.svg" alt="" width="18px">
                        </a>
                        <div class="col-pagename left">Vilekh Module (<tCount><?php echo $total_count; ?></tCount>)
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="expDiv" style="margin-top: 20px;">
                    <div class="hero-box" style="margin-top: 20px;">
                        <div class="left-box" style="width: 99.5%;">
                            <div class="main-card">
                                <ul class="cards">
                                    <li class="cards_item posrel" id="data_block_1">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name">ऐसे बैनामे, जहाँ गाटों का दर निर्धारण नहीं हुआ</span><span class="view_data card_text" id="dashboard_data_1"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_2">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name">ऐसे बैनामे, जहाँ दर निर्धारण से ज्यादा भुगतान हो गया है</span><span class="view_data card_text" id="dashboard_data_2"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_3">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content">
                                                <p><span class="text-name">ऐसे बैनामे, जहाँ एक ही काश्तकार का एक ही गाटा पर एक से ज्यादा बार बैनामा हुआ है</span><span class="view_data card_text" id="dashboard_data_3"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_4">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name">ऐसे बैनामे, जिनमें तितिम्मा हुआ है</span><span class="view_data card_text" id="dashboard_data_4"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_5">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name">ऐसे गाटे जहाँ बैनामे का मूल्य दर निर्धारण के मूल्य से अधिक है</span><span class="view_data card_text" id="dashboard_data_4"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_6">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name">ऐसे गाटे जहाँ परिसंपत्ति का मूल्य दर निर्धारण के मूल्य से अधिक है</span><span class="view_data card_text" id="dashboard_data_4"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_7">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name">ऐसे गाटे जहाँ बैनामे का रकवा दर निर्धारित रकवे से अधिक है</span><span class="view_data card_text" id="dashboard_data_4"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_8">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name">ऐसे गाटे/विलेख का मूल्य जहाँ कुल मूल्य फॉर्म-20 पर दर्शाए गए मूल्य से अधिक है</span><span class="view_data card_text" id="dashboard_data_4"></span></p>
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
                    <div class="left fltrbtn">
                        <p>Total Amount: <total_bainama_amount><?php echo format_rupees($bainama_total_amount); ?></total_bainama_amount></p>
                        <div class="clr"></div>
                    </div>
                    <div class="left fltrbtn lmarg">
                        <p>Payment Done: <payment_total_amount><?php echo format_rupees($payment_total_amount); ?></payment_total_amount></p>
                        <div class="clr"></div>
                    </div>
                    <div class="left fltrbtn lmarg">
                        <p>Amount Left: <amount_left><?php echo format_rupees($bainama_total_amount - $payment_total_amount); ?></amount_left></p>
                        <div class="clr"></div>
                    </div>
                    <div class="left fltrbtn lmarg">
                        <p>Vilekh Without Payment: <vilekh_without_payment><?php echo format_number($vilekh_without_payment); ?></vilekh_without_payment></p>
                        <div class="clr"></div>
                    </div>
                    <div class="left fltrbtn lmarg">
                        <p>Bainama Area: <total_bainama_area><?php echo $total_bainama_area; ?></total_bainama_area></p>
                        <div class="clr"></div>
                    </div>
                    <div class="left fltrbtn lmarg">
                        <p>Parisampatti Amount: <total_parisampatti_amount><?php echo format_rupees($total_parisampatti_amount); ?></total_parisampatti_amount></p>
                        <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                </div>
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
                    <div class="ebasta_select dev_req_msg right rmarg">
                        <select name="sort_by" id="sort_by" style="padding: 8px 14px 10px 14px; margin-top: 2px; font-size: 12px;">
                            <option value="">Sort By</option>
                            <option value="1" <?php if ($sort_by == '1') { ?>selected="selected"<?php } ?>>Bainama Date (ASC)</option>
                            <option value="2" <?php if ($sort_by == '2') { ?>selected="selected"<?php } ?>>Bainama Date (DESC)</option>
                            <option value="3" <?php if ($sort_by == '3') { ?>selected="selected"<?php } ?>>Payment Approval Date (ASC)</option>
                            <option value="4" <?php if ($sort_by == '4') { ?>selected="selected"<?php } ?>>Payment Approval Date (DESC)</option>
                            <option value="5" <?php if ($sort_by == '5') { ?>selected="selected"<?php } ?>>Bainama Area (ASC)</option>
                            <option value="6" <?php if ($sort_by == '6') { ?>selected="selected"<?php } ?>>Bainama Area (DESC)</option>
                            <option value="7" <?php if ($sort_by == '7') { ?>selected="selected"<?php } ?>>Vilekh Sankhya (ASC)</option>
                            <option value="8" <?php if ($sort_by == '8') { ?>selected="selected"<?php } ?>>Vilekh Sankhya (DESC)</option>
                            <option value="9" <?php if ($sort_by == '9') { ?>selected="selected"<?php } ?>>Bainama Amount (ASC)</option>
                            <option value="10" <?php if ($sort_by == '10') { ?>selected="selected"<?php } ?>>Bainama Amount (DESC)</option>
                            <option value="11" <?php if ($sort_by == '11') { ?>selected="selected"<?php } ?>>Payment Amount (ASC)</option>
                            <option value="12" <?php if ($sort_by == '12') { ?>selected="selected"<?php } ?>>Payment Amount (DESC)</option>
                        </select>
                        <div class="ebasta_select__arrow"></div>
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
                                <p>Village Name</p><a style="cursor:pointer;" onclick="sort_name(1, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <!--<div class="cellDivHeader">
                                <p>Village Code</p><a style="cursor:pointer;" onclick="sort_name(2, 'numeric');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>-->
                            <div class="cellDivHeader">
                                <p>Document</p><a style="cursor:pointer;" onclick="sort_name(3, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Bainama Date</p><a style="cursor:pointer;" onclick="sort_name(4, 'numeric');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>E-Basta Area</p><a style="cursor:pointer;" onclick="sort_name(5, 'numeric');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Vilekh Sankhya</p><a style="cursor:pointer;" onclick="sort_name(6, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Bainama Area</p><a style="cursor:pointer;" onclick="sort_name(7, 'numeric');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Land Amount</p><a style="cursor:pointer;" onclick="sort_name(8, 'numeric');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Parisampatti Amount</p><a style="cursor:pointer;" onclick="sort_name(9, 'numeric');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Bainama Amount</p><a style="cursor:pointer;" onclick="sort_name(10, 'numeric');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <!--<div class="cellDivHeader">
                                <p>Patravali Status</p><a style="cursor:pointer;" onclick="sort_name(8, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>-->
                            <div class="cellDivHeader">
                                <p>Payment Amount</p><a style="cursor:pointer;" onclick="sort_name(11, 'numeric');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Payment Approval Date</p><a style="cursor:pointer;" onclick="sort_name(12, 'numeric');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Action</p>
                            </div>
                        </div>
                        <div id="main-body" style="display: contents;">
                            <div id="paginate-body" style="display: contents;">
                                <?php
                                while ($row = $sql->fetch()) {
                                    $patravali_status = '--';
                                    if ($row['PatravaliStatus'] == '1') {
                                        $patravali_status = 'तहसील के पास (Gulab Singh & Lalit)';
                                    } else if ($row['PatravaliStatus'] == '2') {
                                        $patravali_status = 'बंधक पत्रावली (RK Shukla)';
                                    } else if ($row['PatravaliStatus'] == '3') {
                                        $patravali_status = 'बंजर पत्रावली (Gulab singh & Lalit)';
                                    } else if ($row['PatravaliStatus'] == '4') {
                                        $patravali_status = 'तितिम्मा पत्रावली (Lal Krishna)⁠';
                                    } else if ($row['PatravaliStatus'] == '5') {
                                        $patravali_status = 'पेमेंट हो चुका';
                                    } else if ($row['PatravaliStatus'] == '6') {
                                        $patravali_status = 'SLAO के पास';
                                    }
                                    $ebasta_2 = json_decode($row['Ebasta2'], true);
                                    $file_name = $ebasta_2[0]['file_name'];
                                    //echo $row['EbastaIds'];
                                    ?>
                                    <div class="rowDiv">
                                        <div class="cellDiv col1">
                                            <?php echo $row['VillageName'] ? $row['VillageName'] : '--'; ?>
                                        </div>
                                        <!--<div class="cellDiv col2" name="<?php echo $row['VillageCode'] ? $row['VillageCode'] : 0; ?>">
                                        <?php echo $row['VillageCode'] ? $row['VillageCode'] : "--"; ?>
                                        </div>-->
                                        <div class="cellDiv col2">
                                            <div style="position: relative;">
                                                <a class="" title="Download Document" target="_blank" href="download?file=<?php echo base64_encode($file_name); ?>&type=<?php echo base64_encode('gata_ebasta'); ?>">
                                                    <img src="img/download_1.svg" height="18px;">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="cellDiv col3" name="<?php echo $row['AnshDate'] ? $row['AnshDate'] : 0; ?>">
                                            <?php echo $row['AnshDate'] ? date('d-m-Y', $row['AnshDate']) : "--"; ?>
                                        </div>
                                        <div class="cellDiv col4" name="<?php echo $row['AnshRakba'] ? $row['AnshRakba'] : 0; ?>">
                                            <?php echo $row['AnshRakba'] ? $row['AnshRakba'] : "--"; ?>
                                        </div>
                                        <div class="cellDiv col5">
                                            <span class="vilekh_sankhya"><?php echo $row['VilekhSankhya'] ? $row['VilekhSankhya'] : "--"; ?></span>
                                            <input type="text" class="frm-txtbox frm-txtbox-brdr vilekh hide" name="vilekh" maxlength="10" placeholder="Vilekh Sankhya">
                                        </div>
                                        <div class="cellDiv col6" name="<?php echo $row['BainamaArea'] ? $row['BainamaArea'] : 0; ?>">
                                            <span class="bainama_area_text"><?php echo $row['BainamaArea'] ? $row['BainamaArea'] : "--"; ?></span>
                                            <input type="text" class="frm-txtbox frm-txtbox-brdr bainama_area numeric hide" name="bainama_area" maxlength="14" placeholder="Bainama Area">
                                        </div>
                                        <div class="cellDiv col7" name="<?php echo $row['LandAmount'] ? $row['LandAmount'] : 0; ?>">
                                            <span class="land_amount_text"><?php echo $row['LandAmount'] ? $row['LandAmount'] : "--"; ?></span>
                                            <input type="text" class="frm-txtbox frm-txtbox-brdr land_amount numeric hide" name="land_amount" maxlength="14" placeholder="Land Amount">
                                        </div>
                                        <div class="cellDiv col8" name="<?php echo $row['ParisampattiAmount'] ? $row['ParisampattiAmount'] : 0; ?>">
                                            <span class="pari_amount_text"><?php echo $row['ParisampattiAmount'] ? $row['ParisampattiAmount'] : "--"; ?></span>
                                            <input type="text" class="frm-txtbox frm-txtbox-brdr pari_amount numeric hide" name="pari_amount" maxlength="14" placeholder="Parisampatti Amount">
                                        </div>
                                        <div class="cellDiv col9" name="<?php echo $row['BainamaAmount'] ? $row['BainamaAmount'] : 0; ?>">
                                            <span class="bainama_amount"><?php echo $row['BainamaAmount'] ? $row['BainamaAmount'] : "--"; ?></span>
                                            <input type="text" class="frm-txtbox frm-txtbox-brdr amount numeric hide" name="amount" maxlength="14" placeholder="Bainama Amount">
                                        </div>
                                        <!--<div class="cellDiv col8">
                                        <?php echo $patravali_status; ?>
                                        </div>-->
                                        <div class="cellDiv col10" name="<?php echo $row['PaymentAmount'] ? $row['PaymentAmount'] : 0; ?>">
                                            <span class="payment_amount_text"><?php echo $row['PaymentAmount'] ? $row['PaymentAmount'] : "--"; ?></span>
                                            <input type="text" class="frm-txtbox frm-txtbox-brdr payment_amount numeric hide" name="payment_amount" maxlength="14" placeholder="Payment Amount">
                                        </div>
                                        <div class="cellDiv col11" name="<?php echo $row['PaymentDate'] ? $row['PaymentDate'] : 0; ?>">
                                            <span class="payment_date_text"><?php echo $row['PaymentDate'] ? date('d-m-Y', $row['PaymentDate']) : "--"; ?></span>
                                            <input type="text" class="frm-txtbox frm-txtbox-brdr spbdate payment_date hide" name="payment_date" placeholder="Payment Date">
                                        </div>
                                        <div class="cellDiv col12 cellDivacts">
                                            <?php if ($user_type == '0') { ?>
                                                <img src="img/edit.svg" height="18" alt="" class="edit_bainama_amount" style="cursor:pointer;">
                                                <div class="btn-min-actionwrap posrel action-btn hide">
                                                    <div class="posabsolut act_btn_ovrly"></div>
                                                    <a style="cursor: pointer;" class="pp-primact save_bainama_amount" id="<?php echo encryptIt($row['EbastaIds']); ?>" village_code="<?php echo encryptIt($row['VillageCode']); ?>" bainama_date="<?php echo $row['AnshDate'] ? $row['AnshDate'] : 0; ?>">Save</a>
                                                    <a style="cursor: pointer;" class="pp-secact cancel_bainama_amount">Cancel</a>
                                                </div>
                                            <?php } else if ($user_type == '8') { ?>
                                                <div class="posrel tblactns">
                                                    <a style="cursor:pointer;" class="showAction">
                                                        <img src="img/more-vertical-dark.svg" alt="" height="18px">
                                                    </a>
                                                    <div class="posabsolut nwactdrops" style="display:none;">
                                                        <a style="cursor: pointer;" id="<?php echo encryptIt($row['EbastaIds']); ?>" class="update_patravali text-wrapping">Update Patravali</a>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php
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
<script src="scripts/bainama.js"></script>
<script>
                                    $(document).ready(function () {
                                        $('.full-column').on('click', '.paginate', function () {
                                            loadMoreBainamaAmount(parseInt($(this).text()) - 1);
                                        });
                                        $('.full-column').on('click', '.paginate_next', function () {
                                            loadMoreBainamaAmount(parseInt($('.current').attr('id')));
                                        });
                                        $('.full-column').on('click', '.paginate_prev', function () {
                                            loadMoreBainamaAmount(parseInt($('.current').attr('id')) - 2);
                                        });
                                        $('.full-column').on('click', '.paginate_last', function () {
                                            loadMoreBainamaAmount(parseInt($('.paginate:last').text()) - 1);
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