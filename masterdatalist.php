<?php
include_once 'config.php';
include_once 'includes/checkSession.php';
include_once 'includes/get_time_zone.php';
include_once 'dbcon/db_connect.php';
include_once 'functions/common.function.php';
include_once 'core/permission.core.php';
include_once 'core/masterDataList.core.php';
include_once 'languages/' . $lang_file;
?>
<!doctype html>

<head>
    <meta charset="UTF-8">
    <title>DGMS</title>
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
<style>
    .pgntn a {
        padding: 15px;
        color: grey;
    }
</style>

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
                        <div class="col-pagename left"><?php echo $master_data_list['title']; ?>(<tCount><?php echo $total_count; ?></tCount>)
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
                    <div class="right fltrbtn lmarg" style="cursor:pointer;" nav="all" id="showFilter">
                        <span><img src="img/filterb.svg" height="18px;" alt=""></span>
                        <p><?php echo $common_name['search_filter']; ?></p>
                        <div class="clr"></div>
                    </div>
                    <form method="GET" action="masterdatalist">
                        <div class="ebasta_select dev_req_msg right rmarg">
                            <select name="sort_by" id="sort_by" style="padding: 8px 14px 10px 14px; margin-top: 2px; font-size: 12px;" onchange="this.form.submit()">
                                <option value=""><?php echo $filter_master_data_list['sort_by']; ?></option>
                                <option value="1" <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == '1') { ?>selected="selected"<?php } ?>><?php echo $filter_master_data_list['asc_name']; ?></option>
                                <option value="2" <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == '2') { ?>selected="selected"<?php } ?>><?php echo $filter_master_data_list['dsc_name']; ?></option>
                                <option value="3" <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == '3') { ?>selected="selected"<?php } ?>><?php echo $filter_master_data_list['asc_gata']; ?></option>
                                <option value="4" <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == '4') { ?>selected="selected"<?php } ?>><?php echo $filter_master_data_list['dsc_gata']; ?></option>
                                <option value="5" <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == '5') { ?>selected="selected"<?php } ?>><?php echo $filter_master_data_list['asc_khata']; ?></option>
                                <option value="6" <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == '6') { ?>selected="selected"<?php } ?>><?php echo $filter_master_data_list['dsc_khata']; ?></option>
                                <option value="7" <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == '7') { ?>selected="selected"<?php } ?>><?php echo $filter_master_data_list['asc_rakba']; ?></option>
                                <option value="8" <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == '8') { ?>selected="selected"<?php } ?>><?php echo $filter_master_data_list['dsc_rakba']; ?></option>
                                <option value="9" <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == '9') { ?>selected="selected"<?php } ?>><?php echo $filter_master_data_list['asc_sherni']; ?></option>
                                <option value="10" <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == '10') { ?>selected="selected"<?php } ?>><?php echo $filter_master_data_list['dsc_sherni']; ?></option>
                                <option value="11" <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == '11') { ?>selected="selected"<?php } ?>><?php echo $filter_master_data_list['asc_board_approved']; ?></option>
                                <option value="12" <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == '12') { ?>selected="selected"<?php } ?>><?php echo $filter_master_data_list['dsc_board_approved']; ?></option>
                                <option value="13" <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == '13') { ?>selected="selected"<?php } ?>><?php echo $filter_master_data_list['asc_validate']; ?></option>
                                <option value="14" <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == '14') { ?>selected="selected"<?php } ?>><?php echo $filter_master_data_list['dsc_validate']; ?></option>
                            </select>
                            <div class="ebasta_select__arrow"></div>
                        </div>
                    </form>
                    <div class="tbl-data right posrel" title="Refresh" style="margin-right: 15px;margin-top: 2px">
                        <div class="posabsolut act_btn_ovrly"></div>
                        <a style="cursor:pointer;" class="refresh" id="refresh">
                            <img src="img/refresh.svg" height="22px" width="20px">
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
                                <p><?php echo $master_data_list['sr']; ?></p><a style="cursor:pointer;" onclick="sort_name(1, 'numeric');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p><?php echo $master_data_list['name']; ?></p><a style="cursor:pointer;" onclick="sort_name(2, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p><?php echo $master_data_list['gata_no']; ?></p><a style="cursor:pointer;" onclick="sort_name(3, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p><?php echo $master_data_list['khata_no']; ?></p><a style="cursor:pointer;" onclick="sort_name(4, 'numeric');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p><?php echo $master_data_list['rakba']; ?></p><a style="cursor:pointer;" onclick="sort_name(5, 'numeric');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p><?php echo $master_data_list['shreni']; ?></p><a style="cursor:pointer;" onclick="sort_name(6, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p><?php echo $master_data_list['board_approved']; ?></p><a style="cursor:pointer;" onclick="sort_name(7, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <!-- <div class="cellDivHeader">
                                <p>Ansh</p><a style="cursor:pointer;" onclick="sort_name(8, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Rakba</p><a style="cursor:pointer;" onclick="sort_name(9, 'numeric');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Attachment</p><a style="cursor:pointer;" onclick="sort_name(10, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p>Date Submitted</p><a style="cursor:pointer;" onclick="sort_name(11, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div> -->
                            <div class="cellDivHeader ">
                                <p><?php echo $master_data_list['validate_status']; ?></p><a style="cursor:pointer;" onclick="sort_name(8, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p><?php echo $master_data_list['action']; ?></p><a style="cursor:pointer;" onclick="sort_name(9, '');"></a>
                            </div>
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
                                    $validate_status = '--';
                                    $validate_color = '';
                                    if ($row['tehsildar_validate_status'] == '1') {
                                        $validate_status = $master_data_details['validate_message'];
                                        $validate_color = 'row-highlight-green';
                                    }
                                    $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
                                    $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
                                    $khata_no = $row['KhataNo'] ? $row['KhataNo'] : '--';
                                    $area = $row['Area'] ? $row['Area'] : '--';
                                    $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
                                    $board_approved = $row['BoardApproved'] ? $row['BoardApproved'] : '--';
                                    // $owner_father = $row['OwnerFather'] ? $row['OwnerFather'] : '--';
                                    // $grievance = $row['Grievance'] ? $row['Grievance'] : '--';
                                    // $remarks = $row['Remarks'] ? $row['Remarks'] : '--';
                                    // $ansh = $row['Ansh'] ? $row['Ansh'] : '--';
                                    ?>
                                    <div class="rowDiv <?php echo $validate_color; ?>">
                                        <div class="cellDiv col1" name="<?php echo $srno; ?>">
                                            <?php echo $srno; ?>
                                        </div>
                                        <div class="cellDiv col2">
                                            <?php echo $village_name; ?>
                                        </div>
                                        <div class="cellDiv col3">
                                            <?php echo $gata_no; ?>
                                        </div>
                                        <div class="cellDiv col4" name="<?php echo $khata_no; ?>">
                                            <?php echo $khata_no; ?>
                                        </div>
                                        <div class="cellDiv col5" name="<?php echo $area; ?>">
                                            <?php echo $area; ?>
                                        </div>
                                        <div class="cellDiv col6">
                                            <?php echo $shreni; ?>
                                        </div>
                                        <div class="cellDiv col7">
                                            <?php echo $board_approved; ?>
                                        </div>
                                        <div class="cellDiv col8">
                                            <?php echo $validate_status; ?>
                                        </div>
                                        <!-- <div class="cellDiv col8">
                                        <?php echo $ansh; ?>
                                        </div>
                                        <div class="cellDiv col9" name="<?php echo str_replace('.', '', $area); ?>">
                                        <?php echo $area; ?>
                                        </div>
                                        <div class="cellDiv col10" style="text-align: center;">
                                        <?php if ($row['Attachment']) { ?>
                                                                                    <a class="" title="Download Sahmati" target="_blank" href="download?file=<?php echo base64_encode($row['Attachment']); ?>&type=<?php echo base64_encode('kashtkar_sahmati'); ?>">
                                                                                        <img src="img/download_1.svg" height="18px">
                                                                                    </a>
                                        <?php } else { ?>
                                                                                    --
                                        <?php } ?>
                                        </div>
                                        <div class="cellDiv col11">
                                        <?php echo date('d-m-Y g:i A', $row['DateCreated']); ?>
                                        </div> -->
                                        <div class="cellDiv cellDivacts col9">
                                            <div class="posrel tblactns">
                                                <a style="cursor:pointer;" class="showAction">
                                                    <img src="img/more-vertical-dark.svg" alt="" height="18px">
                                                </a>
                                                <div class="posabsolut nwactdrops" style="display:none;">
                                                    <a style="cursor: pointer;" href="masterdatadetails?id=<?php echo myUrlEncode(encryptIt($row['ID'])); ?>" class="text-wrapping"><?php echo $master_data_list['view_details']; ?></a>
                                                </div>
                                            </div>
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
    <div id="notify"></div>
    <div id="saveFilter" class="hide"></div>
</body>
<script src="scripts/jquery-ui.min.js"></script>
<script src="scripts/jquery.confirm.js"></script>
<script src="scripts/common.js"></script>
<script src="scripts/masterdatalist.js"></script>
<script>
                                    $(document).ready(function () {
                                        $('.full-column').on('click', '.paginate', function () {
                                            loadMoreMasterData(parseInt($(this).text()) - 1);
                                        });
                                        $('.full-column').on('click', '.paginate_next', function () {
                                            loadMoreMasterData(parseInt($('.current').attr('id')));
                                        });
                                        $('.full-column').on('click', '.paginate_prev', function () {
                                            loadMoreMasterData(parseInt($('.current').attr('id')) - 2);
                                        });
                                        $('.full-column').on('click', '.paginate_last', function () {
                                            loadMoreMasterData(parseInt($('.paginate:last').text()) - 1);
                                        });
                                        $('.full-column').on('click', '#refresh', function () {
                                            let baseUrl = window.location.origin + window.location.pathname;
                                            window.location.href = baseUrl;
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