<?php
include_once 'config.php';
include_once 'includes/checkSession.php';
include_once 'includes/get_time_zone.php';
include_once 'dbcon/db_connect.php';
include_once 'functions/common.function.php';
include_once 'core/permission.core.php';
include_once 'core/syncData.core.php';
include_once 'core/village.core.php';
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
<!--                        <div class="col-pagename left">Upload & Sync Data (<tCount><?php // echo $total_count;  ?></tCount>)
                        </div>-->
                        <div class="clr"></div>
                    </div>
                    <?php // if ($user_type == '0') { ?>
                    <div class="master-creation right">
                        <div class="posabsolut act_btn_ovrly"></div>
                        <a style="cursor:pointer;" class="update_sync_data">
                            <span class="crticn"><img src="img/plus.svg" alt="" width="16px"></span>
                            <span class="crtxt"><?php echo $common_name['update_sync_status']; ?></span>
                            <div class="clr"></div>
                        </a>
                    </div>
                    
                    <div class="master-creation right"  style="margin-right: 20px">
                        <div class="posabsolut act_btn_ovrly"></div>
                        <a style="cursor:pointer;" class="sync_data">
                            <span class="crticn"><img src="img/plus.svg" alt="" width="16px"></span>
                            <span class="crtxt"><?php echo $common_name['sync_status']; ?></span>
                            <div class="clr"></div>
                        </a>
                    </div>
                    <!--                        <div class="master-creation right rmarg">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <a style="cursor:pointer;" class="secndry import_excel_data">
                                                    <span class="crticn"><img src="img/plus.svg" alt="" width="16px"></span>
                                                    <span class="crtxt">Import Excel Data</span>
                                                    <div class="clr"></div>
                                                </a>
                                                <form id="exfrm">
                                                    <input type="file" style="display:none" class="browseFile" id="browse_file" name="file">
                                                </form>
                                            </div>-->
                    <?php // } ?>
                    <div class="clr"></div>
                </div>

                <div class="clr"></div>
                <!--                <div class="filter-div">
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
                                </div>-->
                <div class="clr"></div>
                <!--                <div class="scrl-tblwrap">
                                    <div class="containerDiv">
                
                                        <div class="rowDivHeader">
                                            <div class="cellDivHeader">
                                                <p>UID</p><a style="cursor:pointer;" onclick="sort_name(1, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>village_name</p><a style="cursor:pointer;" onclick="sort_name(2, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>village_code</p><a style="cursor:pointer;" onclick="sort_name(3, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>gata_no</p><a style="cursor:pointer;" onclick="sort_name(4, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>khata_no</p><a style="cursor:pointer;" onclick="sort_name(5, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>area</p><a style="cursor:pointer;" onclick="sort_name(6, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>owner_no</p><a style="cursor:pointer;" onclick="sort_name(7, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>shreni</p><a style="cursor:pointer;" onclick="sort_name(8, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>area_required</p><a style="cursor:pointer;" onclick="sort_name(9, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>is_gata_approved_by_board</p><a style="cursor:pointer;" onclick="sort_name(10, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>gata_hold_by_dm</p><a style="cursor:pointer;" onclick="sort_name(11, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>gata_hold_by_bida_before_vigyapti</p><a style="cursor:pointer;" onclick="sort_name(12, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>gata_hold_by_dar_nirdharan_samiti</p><a style="cursor:pointer;" onclick="sort_name(13, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>bainama_hold_by_bida_after_dar_nirdharan</p><a style="cursor:pointer;" onclick="sort_name(14, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>ch41_45_ke_anusar_sreni</p><a style="cursor:pointer;" onclick="sort_name(15, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>ch41_45_ke_anusar_rakba</p><a style="cursor:pointer;" onclick="sort_name(16, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>fasali_ke_anusar_sreni</p><a style="cursor:pointer;" onclick="sort_name(17, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>fasali_ke_anusar_rakba</p><a style="cursor:pointer;" onclick="sort_name(18, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>khate_me_fasali_ke_anusar_kism</p><a style="cursor:pointer;" onclick="sort_name(19, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>fasali_me_kastkar_darj_status</p><a style="cursor:pointer;" onclick="sort_name(20, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>parisampatti_by_lkp</p><a style="cursor:pointer;" onclick="sort_name(21, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>dispute_status</p><a style="cursor:pointer;" onclick="sort_name(22, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>dispute_court_name</p><a style="cursor:pointer;" onclick="sort_name(23, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>dispute_court_number</p><a style="cursor:pointer;" onclick="sort_name(24, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>stay_court_status</p><a style="cursor:pointer;" onclick="sort_name(25, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>adhisuchana_ke_anusar_mauke_ki_stithi</p><a style="cursor:pointer;" onclick="sort_name(26, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>gata_notification_status</p><a style="cursor:pointer;" onclick="sort_name(27, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>gata_map_not_field</p><a style="cursor:pointer;" onclick="sort_name(28, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>nahar_map_but_kastkar</p><a style="cursor:pointer;" onclick="sort_name(29, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>sadak_map_but_kastkar</p><a style="cursor:pointer;" onclick="sort_name(30, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>total_tree</p><a style="cursor:pointer;" onclick="sort_name(31, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>vartaman_circle_rate</p><a style="cursor:pointer;" onclick="sort_name(32, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>agricultural_area</p><a style="cursor:pointer;" onclick="sort_name(33, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>current_circle_rate</p><a style="cursor:pointer;" onclick="sort_name(34, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>agri_amount</p><a style="cursor:pointer;" onclick="sort_name(35, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>road_area</p><a style="cursor:pointer;" onclick="sort_name(36, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>road_rate</p><a style="cursor:pointer;" onclick="sort_name(37, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>road_amount</p><a style="cursor:pointer;" onclick="sort_name(38, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>aabadi_area</p><a style="cursor:pointer;" onclick="sort_name(39, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>aabadi_rate</p><a style="cursor:pointer;" onclick="sort_name(40, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>aabadi_amount</p><a style="cursor:pointer;" onclick="sort_name(41, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>govt_amount</p><a style="cursor:pointer;" onclick="sort_name(42, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>land_total_amount</p><a style="cursor:pointer;" onclick="sort_name(43, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>parisampatti_name</p><a style="cursor:pointer;" onclick="sort_name(44, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>total_parisampatti_amount</p><a style="cursor:pointer;" onclick="sort_name(45, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>extra_2015_amount</p><a style="cursor:pointer;" onclick="sort_name(46, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>total_land_and_parisampatti_amount</p><a style="cursor:pointer;" onclick="sort_name(47, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>total_land_parisampati_amount_roundof</p><a style="cursor:pointer;" onclick="sort_name(48, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>exp_stamp_duty</p><a style="cursor:pointer;" onclick="sort_name(49, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>exp_nibandh_sulk</p><a style="cursor:pointer;" onclick="sort_name(50, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>lekhpal_pratilipi_tax</p><a style="cursor:pointer;" onclick="sort_name(51, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>grand_total</p><a style="cursor:pointer;" onclick="sort_name(52, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>last_year_bainama_circle_rate</p><a style="cursor:pointer;" onclick="sort_name(53, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>last_two_year_bainama_circle_rate</p><a style="cursor:pointer;" onclick="sort_name(54, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>vrihad_pariyojna</p><a style="cursor:pointer;" onclick="sort_name(55, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>sc_st_kashtkar</p><a style="cursor:pointer;" onclick="sort_name(56, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>dhara_98</p><a style="cursor:pointer;" onclick="sort_name(57, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                            <div class="cellDivHeader">
                                                <p>dhara_80_143</p><a style="cursor:pointer;" onclick="sort_name(58, '');"><img
                                                        src="img/sorting.svg" alt="" height="24px"></a>
                                            </div>
                                        </div>
                                        <div id="main-body" style="display: contents;">
                                            <div id="paginate-body" style="display: contents;">
                <?php
                while ($row = $sql->fetch()) {
                    ?>
                                                        <div class="rowDiv">
                                                            <div class="cellDiv col1">
                    <?php echo $row['UID'] ? $row['UID'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col2">
                    <?php echo $row['VillageName'] ? $row['VillageName'] : "--"; ?>
                                                            </div>
                                                            <div class="cellDiv col3">
                    <?php echo $row['VillageCode'] ? $row['VillageCode'] : "--"; ?>
                                                            </div>
                                                            <div class="cellDiv col4">
                    <?php echo $row['GataNo'] ? $row['GataNo'] : "--"; ?>
                                                            </div>
                                                            <div class="cellDiv col5">
                    <?php echo $row['KhataNo'] ? $row['KhataNo'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col6">
                    <?php echo $row['Area'] ? $row['Area'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col7">
                    <?php echo $row['OwnerNo'] ? $row['OwnerNo'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col8">
                    <?php echo $row['Shreni'] ? $row['Shreni'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col9">
                    <?php echo $row['RequiredArea'] ? $row['RequiredArea'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col10">
                    <?php echo $row['BoardApproved'] ? $row['BoardApproved'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col11">
                    <?php echo $row['HoldByDM'] ? $row['HoldByDM'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col12">
                    <?php echo $row['HoldByBIDA'] ? $row['HoldByBIDA'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col13">
                    <?php echo $row['HoldByNirdharan'] ? $row['HoldByNirdharan'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col14">
                    <?php echo $row['BinamaHoldByBIDA'] ? $row['BinamaHoldByBIDA'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col15">
                    <?php echo $row['ch41_45_ke_anusar_sreni'] ? $row['ch41_45_ke_anusar_sreni'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col16">
                    <?php echo $row['ch41_45_ke_anusar_rakba'] ? $row['ch41_45_ke_anusar_rakba'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col17">
                    <?php echo $row['fasali_ke_anusar_sreni'] ? $row['fasali_ke_anusar_sreni'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col18">
                    <?php echo $row['fasali_ke_anusar_rakba'] ? $row['fasali_ke_anusar_rakba'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col19">
                    <?php echo $row['khate_me_fasali_ke_anusar_kism'] ? $row['khate_me_fasali_ke_anusar_kism'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col20">
                    <?php echo $row['fasali_me_kastkar_darj_status'] ? $row['fasali_me_kastkar_darj_status'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col21">
                    <?php echo $row['parisampatti_by_lkp'] ? $row['parisampatti_by_lkp'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col22">
                    <?php echo $row['dispute_status'] ? $row['dispute_status'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col23">
                    <?php echo $row['dispute_court_name'] ? $row['dispute_court_name'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col24">
                    <?php echo $row['dispute_court_number'] ? $row['dispute_court_number'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col25">
                    <?php echo $row['stay_court_status'] ? $row['stay_court_status'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col26">
                    <?php echo $row['adhisuchana_ke_anusar_mauke_ki_stithi'] ? $row['adhisuchana_ke_anusar_mauke_ki_stithi'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col27">
                    <?php echo $row['gata_notification_status'] ? $row['gata_notification_status'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col28">
                    <?php echo $row['gata_map_not_field'] ? $row['gata_map_not_field'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col29">
                    <?php echo $row['nahar_map_but_kastkar'] ? $row['nahar_map_but_kastkar'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col30">
                    <?php echo $row['sadak_map_but_kastkar'] ? $row['sadak_map_but_kastkar'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col31">
                    <?php echo $row['total_tree'] ? $row['total_tree'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col32">
                    <?php echo $row['vartaman_circle_rate'] ? $row['vartaman_circle_rate'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col33">
                    <?php echo $row['agricultural_area'] ? $row['agricultural_area'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col34">
                    <?php echo $row['current_circle_rate'] ? $row['current_circle_rate'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col35">
                    <?php echo $row['agri_amount'] ? $row['agri_amount'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col36">
                    <?php echo $row['road_area'] ? $row['road_area'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col37">
                    <?php echo $row['road_rate'] ? $row['road_rate'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col38">
                    <?php echo $row['road_amount'] ? $row['road_amount'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col39">
                    <?php echo $row['aabadi_area'] ? $row['aabadi_area'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col40">
                    <?php echo $row['aabadi_rate'] ? $row['aabadi_rate'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col41">
                    <?php echo $row['aabadi_amount'] ? $row['aabadi_amount'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col42">
                    <?php echo $row['govt_amount'] ? $row['govt_amount'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col43">
                    <?php echo $row['land_total_amount'] ? $row['land_total_amount'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col44">
                    <?php echo $row['parisampatti_name'] ? $row['parisampatti_name'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col45">
                    <?php echo $row['total_parisampatti_amount'] ? $row['total_parisampatti_amount'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col46">
                    <?php echo $row['extra_2015_amount'] ? $row['extra_2015_amount'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col47">
                    <?php echo $row['total_land_and_parisampatti_amount'] ? $row['total_land_and_parisampatti_amount'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col48">
                    <?php echo $row['total_land_parisampati_amount_roundof'] ? $row['total_land_parisampati_amount_roundof'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col49">
                    <?php echo $row['exp_stamp_duty'] ? $row['exp_stamp_duty'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col50">
                    <?php echo $row['exp_nibandh_sulk'] ? $row['exp_nibandh_sulk'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col51">
                    <?php echo $row['lekhpal_pratilipi_tax'] ? $row['lekhpal_pratilipi_tax'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col52">
                    <?php echo $row['grand_total'] ? $row['grand_total'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col53">
                    <?php echo $row['last_year_bainama_circle_rate'] ? $row['last_year_bainama_circle_rate'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col54">
                    <?php echo $row['last_two_year_bainama_circle_rate'] ? $row['last_two_year_bainama_circle_rate'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col55">
                    <?php echo $row['vrihad_pariyojna'] ? $row['vrihad_pariyojna'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col56">
                    <?php echo $row['sc_st_kashtkar'] ? $row['sc_st_kashtkar'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col57">
                    <?php echo $row['dhara_98'] ? $row['dhara_98'] : '--'; ?>
                                                            </div>
                                                            <div class="cellDiv col58">
                    <?php echo $row['dhara_80_143'] ? $row['dhara_80_143'] : '--'; ?>
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
                                </div>-->
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
<script src="scripts/syncdata.js"></script>
<script>
                            $(document).ready(function () {
                                $('.full-column').on('click', '.paginate', function () {
                                    loadMoreSyncData(parseInt($(this).text()) - 1);
                                });
                                $('.full-column').on('click', '.paginate_next', function () {
                                    loadMoreSyncData(parseInt($('.current').attr('id')));
                                });
                                $('.full-column').on('click', '.paginate_prev', function () {
                                    loadMoreSyncData(parseInt($('.current').attr('id')) - 2);
                                });
                                $('.full-column').on('click', '.paginate_last', function () {
                                    loadMoreSyncData(parseInt($('.paginate:last').text()) - 1);
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