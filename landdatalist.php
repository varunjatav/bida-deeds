<?php
include_once 'config.php';
include_once 'includes/checkSession.php';
include_once 'includes/get_time_zone.php';
include_once 'dbcon/db_connect.php';
include_once 'functions/common.function.php';
include_once 'core/permission.core.php';
include_once 'core/landDataList.core.php';
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
                        <div class="col-pagename left">
                            <?php echo $master_data_list['title']; ?>(<tCount><?php echo $total_count; ?></tCount>)
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="master-creation right">
                        <div class="posabsolut act_btn_ovrly"></div>
                        <a style="cursor:pointer;" class="add_new_data">
                            <span class="crticn"><img src="img/plus.svg" alt="" width="16px"></span>
                            <span class="crtxt"><?php echo $land_data_list['add_new_data']; ?></span>
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
                        <p><?php echo $common_name['search_filter']; ?></p>
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
                                <p><?php echo $land_data_list['sr']; ?></p>
                                <a style="cursor:pointer;" onclick="sort_name(1, 'numeric');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p><?php echo $land_data_list['name']; ?></p>
                                <a style="cursor:pointer;" onclick="sort_name(2, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p><?php echo $land_data_list['mahal_name']; ?></p>
                                <a style="cursor:pointer;" onclick="sort_name(3, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p><?php echo $land_data_list['shreni']; ?></p>
                                <a style="cursor:pointer;" onclick="sort_name(4, 'numeric');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p><?php echo $land_data_list['khata_no']; ?></p>
                                <a style="cursor:pointer;" onclick="sort_name(5, 'numeric');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p><?php echo $land_data_list['kashtkar_darj_stithi']; ?></p>
                                <a style="cursor:pointer;" onclick="sort_name(6, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p><?php echo $land_data_list['gata_no']; ?></p>
                                <a style="cursor:pointer;" onclick="sort_name(7, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader ">
                                <p><?php echo $land_data_list['rakba']; ?></p>
                                <a style="cursor:pointer;" onclick="sort_name(8, 'numeric');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader ">
                                <p><?php echo $land_data_list['rakba_hect']; ?></p>
                                <a style="cursor:pointer;" onclick="sort_name(9, 'numeric');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader ">
                                <p><?php echo $land_data_list['vivran']; ?></p>
                                <a style="cursor:pointer;" onclick="sort_name(10, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p><?php echo $land_data_list['action']; ?></p>
                                <a style="cursor:pointer;" onclick="sort_name(11, '');"></a>
                            </div> 
                        </div>
                        <div id="main-body" style="display: contents;">
                            <div id="paginate-body" style="display: contents;">
                                <?php
                                $srno = 0;
                                while ($row = $sql->fetch()) {
                                    $srno++;
                                    $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
                                    $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
                                    $khata_no = $row['KhataNo'] ? $row['KhataNo'] : '--';
                                    $area = $row['Area'] ? $row['Area'] : '--';
                                    $rakba_h = $row['RakbaH'] ? $row['RakbaH'] : '--';
                                    $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
                                    $mahal_ka_name = $row['MahalKaName'] ? $row['MahalKaName'] : '--';
                                    $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
                                    $kashtkar_darj_stithi = $row['KashtkarDarjStithi'] ? $row['KashtkarDarjStithi'] : '--';
                                    $unique_id = $row['UniqueID'] ? $row['UniqueID'] : '--';
                                    $vivran = $row['Vivran'] ? $row['Vivran'] : '--';
                                    ?>
                                    <div class="rowDiv <?php echo $validate_color; ?>">
                                        <div class="cellDiv col1" name="<?php echo $srno; ?>">
                                            <?php echo $srno; ?>
                                        </div>
                                        <div class="cellDiv col2">
                                            <?php echo $village_name; ?>
                                        </div>
                                        <div class="cellDiv col3">
                                            <?php echo $mahal_ka_name; ?>
                                        </div>
                                        <div class="cellDiv col4">
                                            <?php echo $shreni; ?>
                                        </div>
                                        <div class="cellDiv col5" name="<?php echo $khata_no; ?>">
                                            <?php echo $khata_no; ?>
                                        </div>
                                        <div class="cellDiv col6">
                                            <?php echo $kashtkar_darj_stithi; ?>
                                        </div>
                                        <div class="cellDiv col7">
                                            <?php echo $gata_no; ?>
                                        </div>
                                        <div class="cellDiv col8" name="<?php echo $row['Area']; ?>">
                                            <?php echo $area; ?>
                                        </div>
                                        <div class="cellDiv col9" name="<?php echo $row['RakbaH']; ?>">
                                            <?php echo $rakba_h; ?>
                                        </div>
                                        <div class="cellDiv col10">
                                            <?php echo $vivran; ?>
                                        </div>
                                        <div class="cellDiv cellDivacts col10">
                                            <div class="posrel tblactns">
                                                <a style="cursor:pointer;" class="showAction">
                                                    <img src="img/more-vertical-dark.svg" alt="" height="18px">
                                                </a>
                                                <div class="posabsolut nwactdrops" style="display:none;">
                                                    <a style="cursor:pointer;" class="edit_file" id="<?php echo encryptIt(myUrlEncode($row['ID'])); ?>" 
                                                       uid="<?php echo encryptIt(myUrlEncode($row['UniqueID'])); ?>"
                                                       vicode="<?php echo encryptIt(myUrlEncode($row['VillageCode'])); ?>">
                                                           <?php echo $master_data_details['edit']; ?>
                                                    </a>
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
<script src="scripts/landdatalist.js"></script>
<script>
                                    $(document).ready(function () {
                                        $('.full-column').on('click', '.paginate', function () {
                                            loadMoreFasliLandData(parseInt($(this).text()) - 1);
                                        });
                                        $('.full-column').on('click', '.paginate_next', function () {
                                            loadMoreFasliLandData(parseInt($('.current').attr('id')));
                                        });
                                        $('.full-column').on('click', '.paginate_prev', function () {
                                            loadMoreFasliLandData(parseInt($('.current').attr('id')) - 2);
                                        });
                                        $('.full-column').on('click', '.paginate_last', function () {
                                            loadMoreFasliLandData(parseInt($('.paginate:last').text()) - 1);
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