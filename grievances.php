<?php
include_once 'config.php';
include_once 'includes/checkSession.php';
include_once 'includes/get_time_zone.php';
include_once 'dbcon/db_connect.php';
include_once 'functions/common.function.php';
include_once 'core/permission.core.php';
include_once 'core/grievances.core.php';
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
        .new-kashkar{
            background-color: rgba(105, 108, 255, 0.16) !important;
        }
        .frm-lbl-actv {
            top: -20px;
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
                        <div class="col-pagename left">Grievances (<tCount><?php echo $total_count; ?></tCount>)
                        </div>
                        <div class="clr"></div>
                    </div>
                    <?php if ($user_type == '0') { ?>
                        <div class="master-creation right">
                            <div class="posabsolut act_btn_ovrly"></div>
                            <a style="cursor:pointer;" class="add_grienvaces">
                                <span class="crticn"><img src="img/plus.svg" alt="" width="16px"></span>
                                <span class="crtxt">Add Offline Grienvaces</span>
                                <div class="clr"></div>
                            </a>
                        </div>
                    <?php } ?>
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
                        <a style="cursor:pointer;" class="export_excel_grievances" id="all">
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
                                <p>Sr.No.</p><a style="cursor:pointer;" onclick="sort_name(1, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Village Name</p><a style="cursor:pointer;" onclick="sort_name(2, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Gata No</p><a style="cursor:pointer;" onclick="sort_name(3, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Khata No</p><a style="cursor:pointer;" onclick="sort_name(4, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Area</p><a style="cursor:pointer;" onclick="sort_name(5, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Mobile</p><a style="cursor:pointer;" onclick="sort_name(6, 'numeric');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Kashtkar Name</p><a style="cursor:pointer;" onclick="sort_name(7, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Complain</p><a style="cursor:pointer;" onclick="sort_name(8, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Date Submitted</p><a style="cursor:pointer;" onclick="sort_name(9, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Status</p><a style="cursor:pointer;" onclick="sort_name(10, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Report By OSD</p><a style="cursor:pointer;" onclick="sort_name(11, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Remarks</p><a style="cursor:pointer;" onclick="sort_name(12, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Mode</p><a style="cursor:pointer;" onclick="sort_name(13, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Offline Report</p><a style="cursor:pointer;" onclick="sort_name(14, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <?php if ($user_type == '1') { ?>
                                <div class="cellDivHeader">
                                    <p>Action</p><a style="cursor:pointer;" onclick="sort_name(15, '');"><img
                                            src="img/sorting.svg" alt="" height="24px"></a>
                                </div>
                            <?php } ?>
                        </div>
                        <div id="main-body" style="display: contents;">
                            <div id="paginate-body" style="display: contents;">
                                <?php
                                $srno = 0;
                                while ($row = $sql->fetch()) {
                                    $srno++;
                                    $status = 'Pending';
                                    $color = '';
                                    if ($row['Status'] == '1') {
                                        $status = 'Solved';
                                        $color = 'row-highlight-green';
                                    }
                                    $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
                                    $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
                                    $khata_no = $row['KhataNo'] ? $row['KhataNo'] : '--';
                                    $area = $row['Area'] ? $row['Area'] : '--';
                                    $mobile = $row['Mobile'] ? $row['Mobile'] : '--';
                                    $owner_name = $row['owner_name'] ? $row['owner_name'] : '--';
                                    $grievance = $row['Grievance'] ? $row['Grievance'] : '--';
                                    $remarks = $row['Remarks'] ? $row['Remarks'] : '--';
                                    ?>
                                    <div class="rowDiv <?php echo $color; ?>">
                                        <div class="cellDiv col1">
                                            <?php echo $srno; ?>
                                        </div>
                                        <div class="cellDiv col2">
                                            <?php echo $village_name; ?>
                                        </div>
                                        <div class="cellDiv col3">
                                            <?php echo $gata_no; ?>
                                        </div>
                                        <div class="cellDiv col4">
                                            <?php echo $khata_no; ?>
                                        </div>
                                        <div class="cellDiv col5">
                                            <?php echo $area; ?>
                                        </div>
                                        <div class="cellDiv col6">
                                            <?php echo $mobile; ?>
                                        </div>
                                        <div class="cellDiv col7">
                                            <?php echo $owner_name; ?>
                                        </div>
                                        <div class="cellDiv col8">
                                            <?php echo $grievance; ?>
                                        </div>
                                        <div class="cellDiv col9">
                                            <?php echo date('d-m-Y g:i A', $row['DateCreated']); ?>
                                        </div>
                                        <div class="cellDiv col10">
                                            <?php echo $status; ?>
                                        </div>
                                        <div class="cellDiv col11">
                                            <?php if ($row['Attachment']) { ?>
                                                <a class="" title="Download Report" target="_blank" href="download?file=<?php echo base64_encode($row['Attachment']); ?>&type=<?php echo base64_encode('grievance_report'); ?>">Download</a>
                                            <?php } else { ?>
                                                --
                                            <?php } ?>
                                        </div>
                                        <div class="cellDiv col12">
                                            <?php echo $remarks; ?>
                                        </div>
                                        <div class="cellDiv col13">
                                            <?php echo $row['Mode'] == '1' ? 'Offline' : 'Online'; ?>
                                        </div>
                                        <div class="cellDiv col14">
                                            <?php if ($row['OfflineAttachment']) { ?>
                                                <a class="" title="Download Report" target="_blank" href="download?file=<?php echo base64_encode($row['OfflineAttachment']); ?>&type=<?php echo base64_encode('offline_grievance'); ?>">Download</a>
                                            <?php } else { ?>
                                                --
                                            <?php } ?>
                                        </div>
                                        <?php if ($user_type == '1') { ?>
                                            <div class="cellDiv cellDivacts">
                                                <div class="posrel tblactns">
                                                    <a style="cursor:pointer;" class="showAction">
                                                        <img src="img/more-vertical-dark.svg" alt="" height="18px">
                                                    </a>
                                                    <div class="posabsolut nwactdrops" style="display:none;">
                                                        <a style="cursor: pointer;" id="<?php echo encryptIt($row['ID']); ?>" class="upload_griev_report text-wrapping">Submit Report</a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
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
                                <input type="hidden" id="pagelimit" autocomplete="off" value="5">
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
                                                loadMoreGrievances(parseInt($(this).text()) - 1);
                                            });
                                            $('.full-column').on('click', '.paginate_next', function () {
                                                loadMoreGrievances(parseInt($('.current').attr('id')));
                                            });
                                            $('.full-column').on('click', '.paginate_prev', function () {
                                                loadMoreGrievances(parseInt($('.current').attr('id')) - 2);
                                            });
                                            $('.full-column').on('click', '.paginate_last', function () {
                                                loadMoreGrievances(parseInt($('.paginate:last').text()) - 1);
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