<?php
include_once 'config.php';
include_once 'includes/checkSession.php';
include_once 'includes/get_time_zone.php';
include_once 'dbcon/db_connect.php';
include_once 'functions/common.function.php';
include_once 'core/permission.core.php';
include_once 'core/feedbacks.core.php';
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
                        <div class="col-pagename left">Feedbacks (<tCount><?php echo $total_count; ?></tCount>)
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
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
                                <p>Sr.No.</p><a style="cursor:pointer;" onclick="sort_name(1, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Resource</p><a style="cursor:pointer;" onclick="sort_name(2, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Report Type</p><a style="cursor:pointer;" onclick="sort_name(3, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Village Name</p><a style="cursor:pointer;" onclick="sort_name(4, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Gata No</p><a style="cursor:pointer;" onclick="sort_name(5, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Report No</p><a style="cursor:pointer;" onclick="sort_name(6, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Satisfied</p><a style="cursor:pointer;" onclick="sort_name(7, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Date Posted</p><a style="cursor:pointer;" onclick="sort_name(8, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Remarks</p><a style="cursor:pointer;" onclick="sort_name(9, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                        </div>
                        <div id="main-body" style="display: contents;">
                            <div id="paginate-body" style="display: contents;">
                                <?php
                                $srno = 0;
                                while ($row = $sql->fetch()) {
                                    $srno++;
                                    $resource_type = '';
                                    $report_type = '';
                                    $village_name = '--';
                                    $gata_no = '--';
                                    $report_no = '--';
                                    if ($row['ResourceType'] == '1') {
                                        $resource_type = 'DASHBOARD';
                                    } else if ($row['ResourceType'] == '2') {
                                        $resource_type = 'SYNC DATA';
                                    } else if ($row['ResourceType'] == '3') {
                                        $resource_type = 'E-BASTA';
                                    } else if ($row['ResourceType'] == '4') {
                                        $resource_type = 'REPORTS';
                                    } else if ($row['ResourceType'] == '5') {
                                        $resource_type = 'MIS DASHBOARD';
                                    } else if ($row['ResourceType'] == '6') {
                                        $resource_type = 'MIS REPORTS';
                                    }
                                    if ($row['ReportType'] == 'village_wise') {
                                        $report_type = 'Village Wise';
                                    } else if ($row['ReportType'] == 'gata_wise') {
                                        $report_type = 'Gata Wise';
                                    } else if ($row['ReportType'] == 'dashboard_data') {
                                        $report_type = 'Dashboard Data';
                                    } else if ($row['ReportType'] == 'sync_data') {
                                        $report_type = 'Sync Data';
                                    } else if ($row['ReportType'] == 'mis_dashboard') {
                                        $report_type = 'MIS Dahshboard';
                                    } else if ($row['ReportType'] == 'mis_report') {
                                        if ($row['ReportNo'] == '1') {
                                            $report_type = 'Sehmati';
                                        } else if ($row['ReportNo'] == '2') {
                                            $report_type = 'Bainama';
                                        } else if ($row['ReportNo'] == '3') {
                                            $report_type = 'Khatauni';
                                        } else if ($row['ReportNo'] == '4') {
                                            $report_type = 'Kabza';
                                        } else if ($row['ReportNo'] == '5') {
                                            $report_type = 'Dhanrashi';
                                        }
                                    }
                                    if ($row['Feedback'] == '1') {
                                        $feedback = 'YES';
                                    } else {
                                        $feedback = 'NO';
                                    }
                                    $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
                                    $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
                                    $report_no = $row['ReportNo'] ? $row['ReportNo'] : '--';
                                    ?>
                                    <div class="rowDiv">
                                        <div class="cellDiv col1">
                                            <?php echo $srno; ?>
                                        </div>
                                        <div class="cellDiv col2">
                                            <?php echo $resource_type; ?>
                                        </div>
                                        <div class="cellDiv col3">
                                            <?php echo $report_type; ?>
                                        </div>
                                        <div class="cellDiv col4">
                                            <?php echo $village_name; ?>
                                        </div>
                                        <div class="cellDiv col5">
                                            <?php echo $gata_no; ?>
                                        </div>
                                        <div class="cellDiv col6">
                                            <?php echo $report_no; ?>
                                        </div>
                                        <div class="cellDiv col7">
                                            <?php echo $feedback; ?>
                                        </div>
                                        <div class="cellDiv col8">
                                            <?php echo date('d-m-Y g:i A', $row['DateCreated']); ?>
                                        </div>
                                        <div class="cellDiv col9">
                                            <?php echo $row['Remarks'] ? $row['Remarks'] : '--'; ?>
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
<script src="scripts/feedbacks.js"></script>
<script>
                                    $(document).ready(function () {
                                        $('.full-column').on('click', '.paginate', function () {
                                            loadMoreFeedbacks(parseInt($(this).text()) - 1);
                                        });
                                        $('.full-column').on('click', '.paginate_next', function () {
                                            loadMoreFeedbacks(parseInt($('.current').attr('id')));
                                        });
                                        $('.full-column').on('click', '.paginate_prev', function () {
                                            loadMoreFeedbacks(parseInt($('.current').attr('id')) - 2);
                                        });
                                        $('.full-column').on('click', '.paginate_last', function () {
                                            loadMoreFeedbacks(parseInt($('.paginate:last').text()) - 1);
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