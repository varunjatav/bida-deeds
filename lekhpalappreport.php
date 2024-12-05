<?php
include_once 'config.php';
include_once 'includes/checkSession.php';
include_once 'includes/get_time_zone.php';
include_once 'dbcon/db_connect.php';
include_once 'functions/common.function.php';
include_once 'core/permission.core.php';
include_once 'core/lekhpalAppReport.core.php';
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
                        <div class="col-pagename left">Lekhpal Report
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                </div>

                <div class="clr"></div>
                <div class="filter-div">
                    <div style="" class="left">
                        <div class="tabl3">
                            <a href="lekhpalreport">
                                <p>E-Basta Wise</p>
                            </a>
                            <a href="lekhpalappreport" class="active">
                                <p>Mobile-App Wise</p>
                            </a>
                            <div class="clr"></div>
                        </div>
                    </div>
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
                        <a style="cursor:pointer;" class="export_excel_lekhpal_app_report" id="all">
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
                            <div class="repoCellDivHeaderCenter">
                                <p>Lekhpal Name</p>
                            </div>
                            <div class="repoCellDivHeaderCenter">
                                <p>Total Kashtkar</p>
                            </div>
                            <div class="repoCellDivHeaderCenter">
                                <p>Dar Nirdharit Area</p>
                            </div>
                            <div class="repoCellDivHeaderCenter">
                                <p>Uploaded Sahmati</p>
                            </div>
                            <div class="repoCellDivHeaderCenter">
                                <p>Uploaded Sahmati Area</p>
                            </div>
                            <div class="repoCellDivHeaderCenter">
                                <p>Remaining Sahmati</p>
                            </div>
                            <div class="repoCellDivHeaderCenter">
                                <p>Remaining Sahmati Area</p>
                            </div>
                            <div class="repoCellDivHeaderCenter">
                                <p>Uploaded Bainama</p>
                            </div>
                            <div class="repoCellDivHeaderCenter">
                                <p>Uploaded Bainama Area</p>
                            </div>
                            <div class="repoCellDivHeaderCenter">
                                <p>Remaining Bainama</p>
                            </div>
                            <div class="repoCellDivHeaderCenter">
                                <p>Remaining Bainama Area</p>
                            </div>
                        </div>
                        <div id="main-body" style="display: contents;">
                            <div id="paginate-body" style="display: contents;">
                                <?php
                                foreach ($lekhpalInfo as $key => $value) {
                                    $total_kashtkar = $kashtkar_count_array[$value['UserID']] ? $kashtkar_count_array[$value['UserID']] : 0;
                                    $sahmati_uploaded = $sahmati_count_array[$value['UserID']] ? $sahmati_count_array[$value['UserID']] : 0;
                                    $bainama_uploaded = $bainama_count_array[$value['UserID']] ? $bainama_count_array[$value['UserID']] : 0;
                                    $total_sahmati_area = $total_sahmati_area_array[$value['UserID']]['RequiredArea'] ? $total_sahmati_area_array[$value['UserID']]['RequiredArea'] : 0;
                                    $uploaded_sahmati_area = $uploaded_sahmati_area_array[$value['UserID']]['AnshRakba'] ? $uploaded_sahmati_area_array[$value['UserID']]['AnshRakba'] : 0;
                                    $uploaded_bainama_area = $uploaded_bainama_area_array[$value['UserID']]['AnshRakba'] ? $uploaded_bainama_area_array[$value['UserID']]['AnshRakba'] : 0;
                                    $remaining_sahmati_area = $total_sahmati_area - $uploaded_sahmati_area;
                                    $remaining_bainama_area = $total_sahmati_area - $uploaded_bainama_area;
                                    $col1_total += $total_kashtkar;
                                    $col2_total += $total_sahmati_area;
                                    $col3_total += $sahmati_uploaded;
                                    $col4_total += $uploaded_sahmati_area;
                                    $col5_total += $total_kashtkar - $sahmati_uploaded;
                                    $col6_total += $remaining_sahmati_area;
                                    $col7_total += $bainama_uploaded;
                                    $col8_total += $uploaded_bainama_area;
                                    $col9_total += $total_kashtkar - $bainama_uploaded;
                                    $col10_total += $remaining_bainama_area;
                                    ?>
                                    <div class="rowDiv <?php echo $color; ?>">
                                        <div class="cellDivCenter col1">
                                            <a href="lekhpalappreportview?id=<?php echo encryptIt($value['UserID']); ?>"><?php echo $value['Name']; ?></a>
                                        </div>
                                        <div class="cellDivCenter col2" name="<?php echo $total_kashtkar; ?>">
                                            <?php echo $total_kashtkar; ?>
                                        </div>
                                        <div class="cellDivCenter col2" name="<?php echo $total_sahmati_area; ?>">
                                            <?php echo $total_sahmati_area; ?>
                                        </div>
                                        <div class="cellDivCenter col3" name="<?php echo $sahmati_uploaded; ?>">
                                            <?php echo $sahmati_uploaded; ?>
                                        </div>
                                        <div class="cellDivCenter col4" name="<?php echo $uploaded_sahmati_area; ?>">
                                            <?php echo $uploaded_sahmati_area; ?>
                                        </div>
                                        <div class="cellDivCenter col5" name="<?php echo ($total_kashtkar - $sahmati_uploaded); ?>">
                                            <?php echo ($total_kashtkar - $sahmati_uploaded); ?>
                                        </div>
                                        <div class="cellDivCenter col6" name="<?php echo $remaining_sahmati_area; ?>">
                                            <?php echo $remaining_sahmati_area; ?>
                                        </div>
                                        <div class="cellDivCenter col7" name="<?php echo $bainama_uploaded; ?>">
                                            <?php echo $bainama_uploaded; ?>
                                        </div>
                                        <div class="cellDivCenter col8" name="<?php echo $uploaded_bainama_area; ?>">
                                            <?php echo $uploaded_bainama_area; ?>
                                        </div>
                                        <div class="cellDivCenter col9" name="<?php echo ($total_kashtkar - $bainama_uploaded); ?>">
                                            <?php echo ($total_kashtkar - $bainama_uploaded); ?>
                                        </div>
                                        <div class="cellDivCenter col10" name="<?php echo $remaining_bainama_area; ?>">
                                            <?php echo $remaining_bainama_area; ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="rowDiv">
                                    <div class="cellDivCenter col1">

                                    </div>
                                    <?php
                                    for ($j = 1; $j < 11; $j++) {
                                        ?>
                                        <div class="cellDivCenter col<?php echo ($j + 1); ?>" style="font-weight: 600; font-size: 16px;">
                                            <a style="cursor: pointer; color: #000;" class="view_grid_total_data" id="<?php echo $j; ?>"><?php echo ${"col" . $j . "_total"}; ?></a>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
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
            <input type="hidden" id="village_code" autocomplete="off" value="<?php echo encryptIt($village_code); ?>">
            <input type="hidden" id="village_name" autocomplete="off" value="<?php echo encryptIt($village_name); ?>">
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
<script src="scripts/lekhpal_report.js"></script>
</html>