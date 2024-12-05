<?php
include_once 'config.php';
include_once 'includes/checkSession.php';
include_once 'includes/get_time_zone.php';
include_once 'dbcon/db_connect.php';
include_once 'functions/common.function.php';
include_once 'functions/common.query.function.php';
include_once 'core/permission.core.php';
include_once 'core/rtkFasliDataList.core.php';
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
    .save-btn{
        background: #5e300f;
        padding: 7px 13px;
        border-radius: 6px;
        color: #fff !important;
    }
    .edit-btn{
        background: #6495ED;
        padding: 7px 13px;
        border-radius: 6px;
        color: #fff !important;
    }
    .table-head-width{
        width: 10px !important;
    }
    .table-body{
        width: 10px !important;
    }
    .cellDivHeader p{
        padding-right: 17px;
    }
</style>
<body>
    <?php include "includes/header.php"; ?>
    <div id="appendFilter"></div>
    <div class="wrapper dev_wrap">
        <div class="col-wrapper">
            <?php include "includes/sidebarmenu.php"; ?>
            <div class="full-column db-cont-wrap right">
                <div class="column-head">
                    <div class="left pageback" style="display:flex;">
                        <a style="cursor: pointer;" onclick="history.go(-1)">
                            <img src="img/back.svg" alt="" width="18px">
                        </a>
                        <div class="col-pagename left">
                            <?php echo $rtk_data_list['title']; ?>:-
                            <t class="page_title"></t>
                            (
                            <tCount><?php echo $total_count; ?></tCount>
                            )
                        </div>
                        <div class="clr"></div>
                    </div>
                    <!--                    <div class="master-creation right">
                       <div class="posabsolut act_btn_ovrly"></div>
                       <a style="cursor:pointer;" class="add_new_data">
                           <span class="crticn"><img src="img/plus.svg" alt="" width="16px"></span>
                           <span class="crtxt"><?php //echo $rtk_data_list['add_new_1359_fasali_data'];       ?></span>
                           <div class="clr"></div>
                       </a>
                       </div>-->
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
                <div class="filter-div">
                    <!-- <div class="tbl-data right" title="Show Columns">
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
                       </div> -->
                    <!-- <div class="tbl-data right posrel" title="Export Excel">
                       <div class="posabsolut act_btn_ovrly"></div>
                       <a style="cursor:pointer;" class="export_excel" id="all">
                           <img src="img/excel.svg" height="22px">
                       </a>
                       </div>  -->
                    <div class="right fltrbtn lmarg" style="cursor:pointer;" nav="all" id="showFilter">
                        <span><img src="img/filterb.svg" height="18px;" alt=""></span>
                        <p><?php echo $common_name['search_filter']; ?></p>
                        <div class="clr"></div>
                    </div>
                    <div class="ebasta_select dev_req_msg right rmarg">
                        <select name="sorting_database" id="sort_by" style="padding: 8px 14px 10px 14px; margin-top: 2px; font-size: 12px;">
                            <option value=""><?php echo $land_data_asc['sortby']; ?></option>
                            <option value="1"><?php echo $rtk_data_list['khata'] . ' (' . $land_data_asc['asc'] . ')'; ?></option>
                            <option value="2"><?php echo $rtk_data_list['khata'] . ' (' . $land_data_asc['desc'] . ')'; ?></option>
                            <option value="3"><?php echo $rtk_data_list['gata'] . ' (' . $land_data_asc['asc'] . ')'; ?></option>
                            <option value="4"><?php echo $rtk_data_list['gata'] . ' (' . $land_data_asc['desc'] . ')'; ?></option>
                            <option value="5"><?php echo $rtk_data_list['sherni'] . ' (' . $land_data_asc['asc'] . ')'; ?></option>
                            <option value="6"><?php echo $rtk_data_list['sherni'] . ' (' . $land_data_asc['desc'] . ')'; ?></option>
                            <option value="7"><?php echo $rtk_data_list['gata_rakba'] . ' (' . $land_data_asc['asc'] . ')'; ?></option>
                            <option value="8"><?php echo $rtk_data_list['gata_rakba'] . ' (' . $land_data_asc['desc'] . ')'; ?></option>
                            <option value="9"><?php echo $rtk_data_list['gata_rakba_acre'] . ' (' . $land_data_asc['asc'] . ')'; ?></option>
                            <option value="10"><?php echo $rtk_data_list['gata_rakba_acre'] . ' (' . $land_data_asc['desc'] . ')'; ?></option>
                            <option value="11"><?php echo $rtk_data_list['kastkar_name'] . ' (' . $land_data_asc['asc'] . ')'; ?></option>
                            <option value="12"><?php echo $rtk_data_list['kastkar_name'] . ' (' . $land_data_asc['desc'] . ')'; ?></option>
                            <option value="13"><?php echo $rtk_data_list['kastkar_father_name'] . ' (' . $land_data_asc['asc'] . ')'; ?></option>
                            <option value="14"><?php echo $rtk_data_list['kastkar_father_name'] . ' (' . $land_data_asc['desc'] . ')'; ?></option>
                            <option value="15"><?php echo $rtk_data_list['mahal_name'] . ' (' . $land_data_asc['asc'] . ')'; ?></option>
                            <option value="16"><?php echo $rtk_data_list['mahal_name'] . ' (' . $land_data_asc['desc'] . ')'; ?></option>
                            <option value="17"><?php echo $rtk_data_list['khata_1359_anusar'] . ' (' . $land_data_asc['asc'] . ')'; ?></option>
                            <option value="18"><?php echo $rtk_data_list['khata_1359_anusar'] . ' (' . $land_data_asc['desc'] . ')'; ?></option>
                            <option value="19"><?php echo $rtk_data_list['gata_1359_anusar'] . ' (' . $land_data_asc['asc'] . ')'; ?></option>
                            <option value="20"><?php echo $rtk_data_list['gata_1359_anusar'] . ' (' . $land_data_asc['desc'] . ')'; ?></option>
                        </select>
                        <div class="ebasta_select__arrow"></div>
                    </div>
                    <div class="clr"></div>
                    <div class="filter-nos left hide"></div>
                    <div id="appliedFilter"></div>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>

                <div style="display:flex;font-size: 15px; font-weight: 600; gap:2px">
                    <div style="background: #ccc; width: 53%; text-align: center; padding: 10px;border-right:2px solid #000; border: 3px solid red;"><?php echo $side_menu['rtk_1359']; ?></div>
                    <div style="background: #ccc; width: 48%; text-align: center; padding: 10px;border: 3px solid blue;"><?php echo $side_menu['1359_fasali_data']; ?></div>
                </div>
                <div class="scrl-tblwrap">
                    <div class="containerDiv">
                        <div class="rowDivHeader">
                            <!-- <div class="cellDivHeader">
                               <p><?php echo $land_data_list['name']; ?></p>
                               <a style="cursor:pointer;" onclick="sort_name(1, '');"><img
                                  src="img/sorting.svg" alt="" height="24px"></a>
                            </div> -->
                            <div class="cellDivHeader table-head-width">
                                <p><?php echo $rtk_data_list['khata']; ?></p>
                                <a style="cursor:pointer;" onclick="sort_name(1, 'numeric');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader table-head-width">
                                <p><?php echo $rtk_data_list['gata']; ?></p>
                                <a style="cursor:pointer;" onclick="sort_name(2, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader table-head-width">
                                <p><?php echo $rtk_data_list['sherni']; ?></p>
                                <a style="cursor:pointer;" onclick="sort_name(3, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader table-head-width">
                                <p><?php echo $rtk_data_list['gata_rakba']; ?></p>
                                <a style="cursor:pointer;" onclick="sort_name(4, 'numeric');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader table-head-width">
                                <p><?php echo $rtk_data_list['gata_rakba_acre']; ?></p>
                                <a style="cursor:pointer;" onclick="sort_name(5, 'numeric');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p><?php echo $rtk_data_list['kastkar_name']; ?></p>
                                <a style="cursor:pointer;" onclick="sort_name(6, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p><?php echo $rtk_data_list['kastkar_father_name']; ?></p>
                                <a style="cursor:pointer;" onclick="sort_name(7, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <!-- <div class="cellDivHeader ">
                               <p><?php echo $rtk_data_list['kastkar_area']; ?></p>
                               <a style="cursor:pointer;" onclick="sort_name(8, '');"><img
                                  src="img/sorting.svg" alt="" height="24px"></a>
                            </div> -->
                            <!-- <div class="cellDivHeader ">
                               <p><?php echo $rtk_data_list['ans_hua_hai?']; ?></p>
                               <a style="cursor:pointer;" onclick="sort_name(9, '');"><img
                                       src="img/sorting.svg" alt="" height="24px"></a>
                               </div> -->
                            <div class="cellDivHeader ">
                                <p><?php echo $rtk_data_list['mahal_name']; ?></p>
                                <a style="cursor:pointer;" onclick="sort_name(8, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader ">
                                <p><?php echo $rtk_data_list['khata_1359_anusar']; ?></p>
                                <a style="cursor:pointer;" onclick="sort_name(9, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader ">
                                <p><?php echo $rtk_data_list['gata_1359_anusar']; ?></p>
                                <a style="cursor:pointer;" onclick="sort_name(10, '');"><img
                                        src="img/sorting.svg" alt="" height="24px"></a>
                            </div>
                            <div class="cellDivHeader">
                                <p><?php echo $rtk_data_list['action']; ?></p>
                                <a style="cursor:pointer;" onclick="sort_name(11, '');"></a>
                            </div>
                        </div>
                        <div id="main-body" style="display: contents;">
                            <div id="paginate-body" style="display: contents;">
                                <?php
                                $srno = 0;
                                while ($row = $sql->fetch()) {
                                    $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
                                    $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
                                    $khata_no = $row['KhataNo'] ? $row['KhataNo'] : '--';
                                    $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
                                    $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
                                    $gata_ka_rakba = $row['Area'] ? $row['Area'] : '--';
                                    $gata_ka_rakba_acre = $row['RakbaA'] ? $row['RakbaA'] : '--';
                                    $Kashtkar_Ka_Name = $row['kashtkar_owner_name'] ? $row['kashtkar_owner_name'] : '--';
                                    $Kashtkar_Ka_father_Name = $row['kashtkar_owner_father'] ? $row['kashtkar_owner_father'] : '--';
                                    $Kashtkar_Ka_area = $row['kashtkar_area'] ? $row['kashtkar_area'] : '--';
                                    $ans_huai_ya_nhi = '--';
                                    $Muhal_Ka_Name = $row['MahalName'] ? $row['MahalName'] : '--';
                                    $Khata_1359_ke_anusar = '--';
                                    $Gata_1359_ke_anusar = '--';
                                    $Shreni_1359_ke_anusar = '--';
                                    $Area_1359_ke_anusar = '--';
                                    ?>
                                    <div class="rowDiv <?php echo $validate_color; ?>">
                                        <!-- <div class="cellDiv col1">
                                        <?php echo $village_name; ?>
                                        </div> -->
                                        <div class="cellDiv col1 table-body" name="<?php echo $row['KhataNo']; ?>">
                                            <?php echo $khata_no; ?>
                                        </div>
                                        <div class="cellDiv col2 table-body">
                                            <?php echo $gata_no; ?>
                                        </div>
                                        <div class="cellDiv col3 table-body">
                                            <?php echo $shreni; ?>
                                        </div>
                                        <div class="cellDiv col4 table-body" name="<?php echo $row['Area']; ?>">
                                            <?php echo $gata_ka_rakba; ?>
                                        </div>
                                        <div class="cellDiv col5 table-body" name="<?php echo $row['RakbaA']; ?>">
                                            <?php echo $gata_ka_rakba_acre; ?>
                                        </div>
                                        <div class="cellDiv col6">
                                            <?php echo $Kashtkar_Ka_Name; ?>
                                        </div>
                                        <div class="cellDiv col7">
                                            <?php echo $Kashtkar_Ka_father_Name; ?>
                                        </div>
                                        <!-- <div class="cellDiv col8" name="<?php echo $Kashtkar_Ka_area; ?>">
                                        <?php echo $Kashtkar_Ka_area; ?>
                                        </div> -->
                                        <!-- <div class="cellDiv col9">
                                        <?php echo $ans_huai_ya_nhi; ?>
                                           </div> -->

                                        <div class="cellDiv col8">
                                            <?php if ($row['MahalName']) { ?>
                                                <?php echo $row['MahalName']; ?>
                                            <?php } else { ?>
                                                <div class="mahal_dpdn">
                                                    <select name="cars" class="mahal_1359 ">
                                                        <option value="">Select Mahal Name</option>
                                                        <?php foreach ($mahal_data_array as $key => $mrow) { ?>
                                                            <option value="<?php echo $mrow['MahalName']; ?>"><?php echo $mrow['MahalName']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="cellDiv col9">
                                            <?php if ($row['1359_fasli_khata']) { ?>
                                                <?php echo $row['1359_fasli_khata']; ?>
                                            <?php } else { ?>
                                                <div class="khata_dpdn">
                                                    <select name="khata_1359" class="khata_1359">
                                                        <option value="">Select Khata</option>
                                                    </select>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="cellDiv col10" name="<?php echo $Gata_1359_ke_anusar; ?>">
                                            <?php if ($row['1359_fasli_gata']) { ?>
                                                <?php echo $row['1359_fasli_gata']; ?>
                                            <?php } else { ?>
                                                <div class="gata_dpdn">
                                                    <select name="gata_1359" class="gata_1359">
                                                        <option value="">Select Gata</option>
                                                    </select>
                                                </div>
                                            <?php } ?>
                                        </div>

                                        <?php if ($row['MahalName'] == '' || $row['1359_fasli_gata'] == '' || $row['1359_fasli_khata'] == '') { ?>
                                            <div class="cellDiv col13">
                                                <div class="save_btn">
                                                    <a style="cursor:pointer;" id="<?php echo encryptIt($row['ID']); ?>" class="save_rtk_mapping_data save-btn">save</a>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="cellDiv col13">
                                                <div class="edit_btn">
                                                    <a style="cursor:pointer;" id="<?php echo encryptIt($row['ID']); ?>" class="edit_rtk_1359_data edit-btn">Edit</a>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <input type="hidden" name="village_code" class="village_code_class" value="<?php echo $village_code; ?>">
                                        <?php if ($lang_file == 'lang.en.php') { ?>
                                            <input type="hidden" class="village_name_class" value="<?php echo $row['VillageName']; ?>">
                                        <?php } else { ?>
                                            <input type="hidden" class="village_name_class" value="<?php echo $row['VillageNameHi']; ?>">
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
<script src="scripts/rtkfaslidatalist.js"></script>
<script>
                                    $(document).ready(function () {
                                        $('.full-column').on('click', '.paginate', function () {
                                            loadMoreRTKFasliLandData(parseInt($(this).text()) - 1);
                                        });
                                        $('.full-column').on('click', '.paginate_next', function () {
                                            loadMoreRTKFasliLandData(parseInt($('.current').attr('id')));
                                        });
                                        $('.full-column').on('click', '.paginate_prev', function () {
                                            loadMoreRTKFasliLandData(parseInt($('.current').attr('id')) - 2);
                                        });
                                        $('.full-column').on('click', '.paginate_last', function () {
                                            loadMoreRTKFasliLandData(parseInt($('.paginate:last').text()) - 1);
                                        });

                                        $('.page_title').text("<?php echo $land_data_list['name']; ?>" + ': ' + $('.village_name_class').val());
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
