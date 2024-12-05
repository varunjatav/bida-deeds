<?php
include_once 'config.php';
include_once 'includes/checkSession.php';
include_once 'includes/get_time_zone.php';
include_once 'dbcon/db_connect.php';
include_once 'functions/common.function.php';
include_once 'core/permission.core.php';
include_once 'core/officeOrderModule.core.php';
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
                        <div class="col-pagename left">Office Order Module (<tCount><?php echo $total_count; ?></tCount>)
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="master-creation right">
                        <div class="posabsolut act_btn_ovrly"></div>
                        <a style="cursor:pointer;" class="office_order">
                            <span class="crticn"><img src="img/plus.svg" alt="" width="16px"></span>
                            <span class="crtxt">Add New Office Order</span>
                            <div class="clr"></div>
                        </a>
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
                                <p>Order Month & Year</p><a style="cursor:pointer;" onclick="sort_name(1, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Subject</p><a style="cursor:pointer;" onclick="sort_name(2, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Order No</p><a style="cursor:pointer;" onclick="sort_name(3, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Order Issue Authority</p><a style="cursor:pointer;" onclick="sort_name(4, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Document</p><a style="cursor:pointer;" onclick="sort_name(5, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Creation Date</p><a style="cursor:pointer;" onclick="sort_name(6, '');"><img
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
                                    while ($row = $sql->fetch()) {
                                        $first_val = implode(',', array_slice(explode(',', $row['Subject']), 0, 4));
                                        $subject_count = count_(explode(',', $row['Subject']));

                                        $first_val_spc = implode(' ', array_slice(explode(' ', $row['Subject']), 0, 7));
                                        $subject_count_spc = count_(explode(' ', $row['Subject']));

                                        $rest_val_count = '';
                                        if ($subject_count > 4) {
                                            $first_val = $first_val_spc;
                                            $rest_val_count = ' + see more';
                                        } else if ($subject_count_spc > 8) {
                                            $first_val = $first_val_spc;
                                            $rest_val_count = ' + see more';
                                        }
                                        $subject_short = $first_val . ' ' . '<span style="color:blue;cursor:pointer;">' . $rest_val_count . '</span>';

                                        $auth_first_val = implode(',', array_slice(explode(',', $row['OrderIssueAuthority']), 0, 4));
                                        $auth_subject_count = count_(explode(',', $row['OrderIssueAuthority']));

                                        $auth_first_val_spc = implode(' ', array_slice(explode(' ', $row['OrderIssueAuthority']), 0, 7));
                                        $auth_subject_count_spc = count_(explode(' ', $row['OrderIssueAuthority']));

                                        $auth_rest_val_count = '';
                                        if ($auth_subject_count > 4) {
                                            $auth_first_val = $auth_first_val_spc;
                                            $auth_rest_val_count = ' + see more';
                                        } else if ($auth_subject_count_spc > 8) {
                                            $auth_first_val = $auth_first_val_spc;
                                            $auth_rest_val_count = ' + see more';
                                        }
                                        $auth_subject_short = $auth_first_val . ' ' . '<span style="color:blue;cursor:pointer;">' . $auth_rest_val_count . '</span>';
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['OrderMonth'] ? date('M Y', $row['OrderMonth']) : '--'; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <span class="tool" data-tip="<?php echo $row['Subject']; ?>"><?php echo $subject_short; ?></span>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['EnterOrderNo'] ? $row['EnterOrderNo'] : "--"; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <span class="tool" data-tip="<?php echo $row['OrderIssueAuthority']; ?>"><?php echo $auth_subject_short; ?></span>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php if ($row['OrderAttachment']) { ?>
                                                    <a class="" title="Download Report" target="_blank" href="download?file=<?php echo base64_encode($row['OrderAttachment']); ?>&type=<?php echo base64_encode('office_order'); ?>">Download</a>
                                                <?php } else { ?>
                                                    --
                                                <?php } ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo $row['DateCreated'] ? date('d-m-Y', $row['DateCreated']) : '--'; ?>
                                            </div>
                                            <!--                                        <div class="cellDiv cellDivacts">
                                                                                        <div class="posrel tblactns">
                                                                                            <a style="cursor:pointer;" class="showAction">
                                                                                                <img src="img/more-vertical-dark.svg" alt="" height="18px">
                                                                                            </a>
                                            
                                                                                            <div class="posabsolut nwactdrops" style="display:none;">
                                                                                                <a style="cursor: pointer;" class="edit_office_order" id="<?php echo encryptIt($row['ID']); ?>">Edit
                                                                                                </a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>-->
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
                                    <div class="clr"></div>
                                </div>
                                <?php
                            } else {
                                ?>
                                <input type="hidden" id="pagelimit" autocomplete="off" value="100">
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
<script src="scripts/officeordermodule.js"></script>
<script>
                                    $(document).ready(function () {
                                        $('.full-column').on('click', '.paginate', function () {
                                            loadMoreOfficeOrderModule(parseInt($(this).text()) - 1);
                                        });
                                        $('.full-column').on('click', '.paginate_next', function () {
                                            loadMoreOfficeOrderModule(parseInt($('.current').attr('id')));
                                        });
                                        $('.full-column').on('click', '.paginate_prev', function () {
                                            loadMoreOfficeOrderModule(parseInt($('.current').attr('id')) - 2);
                                        });
                                        $('.full-column').on('click', '.paginate_last', function () {
                                            loadMoreOfficeOrderModule(parseInt($('.paginate:last').text()) - 1);
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