<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../functions/common.function.php';
include_once '../dbcon/db_connect.php';
include_once '../core/dashboardSummary.core.php';
?>
<div class="popup-overlay center-screen">
    <div class="popup-wrap pp-large-x">
        <form id="confrm" autocomplete="off">
            <div class="popup-header" style="cursor: move;">
                <span class="popup-title text-wrapping left">Dashboard Summary</span>
                <span class="popup-close right">
                    <a style="cursor:pointer;" id="cancel_popup">
                        <img src="img/clear-w.svg" alt="" width="18px">
                    </a>
                </span>
                <div class="clr"></div>
            </div>

            <div class="popup-body pp-large-y">
                <div class="filter-div">
                    <div class="left" style="font-size: 16px; font-weight: 600; line-height: 34px;"><?php echo $title; ?> (<tCount></tCount>)</div>
                    <div class="left lmarg" style="font-size: 14px; line-height: 35px; font-weight: 600; color: darkgreen;">
                        <div id="disp_row_count"></div>
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
                        <a style="cursor:pointer;" class="export_dashboard_excel" id="<?php echo $dashboard_data; ?>">
                            <img src="img/excel.svg" height="22px">
                        </a>
                    </div>
                    <div class="tbl-data right posrel hide" title="Export Qgis Excel">
                        <div class="posabsolut act_btn_ovrly"></div>
                        <a style="cursor:pointer;" class="export_qgis_excel" id="<?php echo $dashboard_data; ?>">
                            <img src="img/map.svg" height="22px">
                        </a>
                    </div>
                    <div class="ebasta_select dev_req_msg right">
                        <select id="filter_village_code">
                            <option value="">Select Village</option>
                        </select>
                        <div class="ebasta_select__arrow"></div>
                    </div>
                    <div class="tbl-data right posrel rmarg" title="Switch to chart mode">
                        <div class="posabsolut act_btn_ovrly"></div>
                        <a style="cursor:pointer;" class="open_chart" id="<?php echo $dashboard_data; ?>" name="<?php echo $title; ?>">
                            <img src="img/survey.svg" width="20">
                        </a>
                    </div>
                    <div class="clr"></div>
                    <div class="filter-nos left hide"></div>
                    <div id="appliedFilter"></div>
                    <div class="clr"></div>
                </div>
                <div class="scrl-tblwrap">
                    <div class="containerDiv posrel">
                        <?php
                        if ($dashboard_data == '1') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $village_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '2') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $village_acquired->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '3') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $village_acquired->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '4') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Kashtkar Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Father Name</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $kashtkar_count_query->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['owner_name']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['owner_father']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '49') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Khata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Kashtkar Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Father Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Ansh</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Rakba</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Download</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $khastkar_bainama_query->fetch()) {
                                        $srno++;
                                        $ebasta_4 = json_decode($row['Ebasta4'], true);
                                        $file_name = $ebasta_4[0]['file_name'];
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['KhataNo']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['owner_name']; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo $row['owner_father']; ?>
                                            </div>
                                            <div class="cellDiv col7">
                                                <?php echo $row['KashtkarAnsh']; ?>
                                            </div>
                                            <div class="cellDiv col8">
                                                <?php echo $row['AnshRakba']; ?>
                                            </div>
                                            <div class="cellDiv col9">
                                                <a class="" title="Download Document" target="_blank" href="download?file=<?php echo base64_encode($file_name); ?>&type=<?php echo base64_encode('gata_ebasta'); ?>">
                                                    <div style="position: relative;">
                                                        <img src="img/download_1.svg" height="18px;">
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '6') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Khata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Ansh Rakba</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $village_acquired->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['KhataNo']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['AnshRakba']; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '7') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $ch4145_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '8') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Khata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata Area</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Ansh Rakba</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Owner Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Owner Father</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $village_acquired->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['KhataNo']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo $row['Area']; ?>
                                            </div>
                                            <div class="cellDiv col7">
                                                <?php echo $row['AnshRakba']; ?>
                                            </div>
                                            <div class="cellDiv col8">
                                                <?php echo $row['owner_name']; ?>
                                            </div>
                                            <div class="cellDiv col9">
                                                <?php echo $row['owner_father']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '9') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $ch1359_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '10') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $village_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '11') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $ebasta_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '12') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Area</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block17_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['Area']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '13') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Area</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block17_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['Area']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '14') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Area</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block17_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['Area']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '15') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Khata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Ansh Rakba</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block17_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['KhataNo']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['AnshRakba']; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '16') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Khata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Ansh Rakba</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block31_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['KhataNo']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['AnshRakba']; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '17') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Area</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block17_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['Area']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '18') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Area</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block17_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['Area']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '19') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Area</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block17_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['Area']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '20') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Rakba</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Total Area</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block30_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['AnshRakba']; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo $row['GataArea']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '21') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Rakba</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Total Area</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block30_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['AnshRakba']; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo $row['GataArea']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '22') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Rakba</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Total Area</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block30_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['AnshRakba']; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo $row['GataArea']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '23') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Rakba</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Total Area</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block30_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['AnshRakba']; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo $row['GataArea']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '24') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Vilekh Sankhya</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Kashtkar Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata Area</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Rakba</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Bank Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Account No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>IFSC</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Bainama Date</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Amount</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block29_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['VilekhSankhya']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['KashtkarName']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo $row['GataArea']; ?>
                                            </div>
                                            <div class="cellDiv col7">
                                                <?php echo $row['Rakba']; ?>
                                            </div>
                                            <div class="cellDiv col8">
                                                <?php echo $row['BankName']; ?>
                                            </div>
                                            <div class="cellDiv col9">
                                                <?php echo $row['AccountNo']; ?>
                                            </div>
                                            <div class="cellDiv col10">
                                                <?php echo $row['IFSC']; ?>
                                            </div>
                                            <div class="cellDiv col11">
                                                <?php echo $row['BainamaDate']; ?>
                                            </div>
                                            <div class="cellDiv col12">
                                                <?php echo format_rupees($row['Amount']); ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '25') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Vilekh Sankhya</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Kashtkar Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata Area</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Rakba</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Bank Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Account No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>IFSC</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Bainama Date</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Amount</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Txn No</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block29_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['VilekhSankhya']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['KashtkarName']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo $row['GataArea']; ?>
                                            </div>
                                            <div class="cellDiv col7">
                                                <?php echo $row['Rakba']; ?>
                                            </div>
                                            <div class="cellDiv col8">
                                                <?php echo $row['BankName']; ?>
                                            </div>
                                            <div class="cellDiv col9">
                                                <?php echo $row['AccountNo']; ?>
                                            </div>
                                            <div class="cellDiv col10">
                                                <?php echo $row['IFSC']; ?>
                                            </div>
                                            <div class="cellDiv col11">
                                                <?php echo $row['BainamaDate']; ?>
                                            </div>
                                            <div class="cellDiv col12">
                                                <?php echo format_rupees($row['Amount']); ?>
                                            </div>
                                            <div class="cellDiv col13">
                                                <?php echo $row['TxnNo']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '26') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Area</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block9_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['Area']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '27') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Area</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block9_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['Area']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '28') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Area</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block9_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['Area']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '29') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Area</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block9_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['Area']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '30') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Area</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block9_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['Area']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '31') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Area</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block9_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['Area']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '32') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Area</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block9_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['Area']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '33') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Area</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block9_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['Area']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '34') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Area</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block9_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['Area']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '35') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Area</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block9_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['Area']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '36') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Kashtkar Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Father Name</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $kashtkar_count_query->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['owner_name']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['owner_father']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '37') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Area</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Total Kashtkar</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block23_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['Area']; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo $row['Count']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '38') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Area</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Owner Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Father Name</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $kashtkar_ansh_query->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['Area']; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo $row['owner_name']; ?>
                                            </div>
                                            <div class="cellDiv col7">
                                                <?php echo $row['owner_father']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '39') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Area</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block17_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['Area']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '40') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Area</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block24_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['Area']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '41') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Khata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Area</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block24_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['KhataNo']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo $row['Area']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '42') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Khata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Area</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block24_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['KhataNo']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo $row['Area']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '43') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Khata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Area</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Owner Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Owner Father</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block24_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['KhataNo']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo $row['Area']; ?>
                                            </div>
                                            <div class="cellDiv col7">
                                                <?php echo $row['owner_name']; ?>
                                            </div>
                                            <div class="cellDiv col7">
                                                <?php echo $row['owner_father']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '44') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Khata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Area</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block25_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['KhataNo']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo $row['Area']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '45') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Khata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Area</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block25_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['KhataNo']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo $row['Area']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '46') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Khata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Area</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>khate_me_fasali_ke_anusar_kism</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $block33_count->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['KhataNo']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo $row['Area']; ?>
                                            </div>
                                            <div class="cellDiv col7">
                                                <?php echo $row['khate_me_fasali_ke_anusar_kism']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '47') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>UID</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>village_name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>village_code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>gata_no</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>khata_no</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>area</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>owner_no</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>area_required</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>is_gata_approved_by_board</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>gata_hold_by_dm</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>gata_hold_by_bida_before_vigyapti</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>gata_hold_by_dar_nirdharan_samiti</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>bainama_hold_by_bida_after_dar_nirdharan</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>ch41_45_ke_anusar_sreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>ch41_45_ke_anusar_rakba</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>fasali_ke_anusar_sreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>fasali_ke_anusar_rakba</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>khate_me_fasali_ke_anusar_kism</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>fasali_me_kastkar_darj_status</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>parisampatti_by_lkp</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>dispute_status</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>dispute_court_name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>dispute_court_number</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>stay_court_status</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>adhisuchana_ke_anusar_mauke_ki_stithi</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>gata_notification_status</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>gata_map_not_field</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>nahar_map_but_kastkar</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>sadak_map_but_kastkar</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>total_tree</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>vartaman_circle_rate</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>agricultural_area</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>current_circle_rate</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>agri_amount</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>road_area</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>road_rate</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>road_amount</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>aabadi_area</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>aabadi_rate</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>aabadi_amount</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>govt_amount</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>land_total_amount</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>parisampatti_name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>total_parisampatti_amount</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>extra_2015_amount</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>total_land_and_parisampatti_amount</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>total_land_parisampati_amount_roundof</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>exp_stamp_duty</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>exp_nibandh_sulk</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>lekhpal_pratilipi_tax</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>grand_total</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>last_year_bainama_circle_rate</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>last_two_year_bainama_circle_rate</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>vrihad_pariyojna</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>sc_st_kashtkar</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>dhara_98</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>dhara_80_143</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $kashtkar_ansh_query->fetch()) {
                                        $srno++;
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
                            </div>
                            <?php
                        } else if ($dashboard_data == '48') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Khata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Kashtkar Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Father Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Ansh</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Rakba</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Download</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $khastkar_bainama_query->fetch()) {
                                        $srno++;
                                        $ebasta_1 = json_decode($row['Ebasta1'], true);
                                        $file_name = $ebasta_1[0]['file_name'];
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['KhataNo']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['owner_name']; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo $row['owner_father']; ?>
                                            </div>
                                            <div class="cellDiv col7">
                                                <?php echo $row['KashtkarAnsh']; ?>
                                            </div>
                                            <div class="cellDiv col8">
                                                <?php echo $row['AnshRakba']; ?>
                                            </div>
                                            <div class="cellDiv col9">
                                                <a class="" title="Download Document" target="_blank" href="download?file=<?php echo base64_encode($file_name); ?>&type=<?php echo base64_encode('gata_ebasta'); ?>">
                                                    <div style="position: relative;">
                                                        <img src="img/download_1.svg" height="18px;">
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '5') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Khata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Kashtkar Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Father Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Ansh</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Rakba</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Download</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $khastkar_bainama_query->fetch()) {
                                        $srno++;
                                        $ebasta_2 = json_decode($row['Ebasta2'], true);
                                        $file_name = $ebasta_2[0]['file_name'];
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['KhataNo']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['owner_name']; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo $row['owner_father']; ?>
                                            </div>
                                            <div class="cellDiv col7">
                                                <?php echo $row['KashtkarAnsh']; ?>
                                            </div>
                                            <div class="cellDiv col8">
                                                <?php echo $row['AnshRakba']; ?>
                                            </div>
                                            <div class="cellDiv col9">
                                                <a class="" title="Download Document" target="_blank" href="download?file=<?php echo base64_encode($file_name); ?>&type=<?php echo base64_encode('gata_ebasta'); ?>">
                                                    <div style="position: relative;">
                                                        <img src="img/download_1.svg" height="18px;">
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '50') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Khata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Kashtkar Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Father Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Ansh</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Rakba</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Download</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $khastkar_bainama_query->fetch()) {
                                        $srno++;
                                        $ebasta_4 = json_decode($row['Ebasta4'], true);
                                        $file_name = $ebasta_4[0]['file_name'];
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['KhataNo']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['owner_name']; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo $row['owner_father']; ?>
                                            </div>
                                            <div class="cellDiv col7">
                                                <?php echo $row['KashtkarAnsh']; ?>
                                            </div>
                                            <div class="cellDiv col8">
                                                <?php echo $row['AnshRakba']; ?>
                                            </div>
                                            <div class="cellDiv col9">
                                                <a class="" title="Download Document" target="_blank" href="download?file=<?php echo base64_encode($file_name); ?>&type=<?php echo base64_encode('gata_ebasta'); ?>">
                                                    <div style="position: relative;">
                                                        <img src="img/download_1.svg" height="18px;">
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '51') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Khata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Mortgaged Amount</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $sql->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['KhataNo']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo format_rupees($row['MortgagedAmount']); ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '52') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Khata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Area</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Owner Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Owner Father</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Mortgaged Amount</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $sql->fetch()) {
                                        $srno++;
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['KhataNo']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['Area']; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo $row['owner_name']; ?>
                                            </div>
                                            <div class="cellDiv col7">
                                                <?php echo $row['owner_father']; ?>
                                            </div>
                                            <div class="cellDiv col8">
                                                <?php echo format_rupees($row['MortgagedAmount']); ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '53') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Khata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Ansh</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Rakba</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Download</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $sql->fetch()) {
                                        $srno++;
                                        $ebasta_1 = json_decode($row['Ebasta1'], true);
                                        $file_name = $ebasta_1[0]['file_name'];
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['KhataNo']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['KashtkarAnsh']; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo $row['AnshRakba']; ?>
                                            </div>
                                            <div class="cellDiv col7">
                                                <a class="" title="Download Document" target="_blank" href="download?file=<?php echo base64_encode($file_name); ?>&type=<?php echo base64_encode('gata_ebasta'); ?>">
                                                    <div style="position: relative;">
                                                        <img src="img/download_1.svg" height="18px;">
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '54') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Khata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Ansh</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Rakba</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Download</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $sql->fetch()) {
                                        $srno++;
                                        $ebasta_1 = json_decode($row['Ebasta2'], true);
                                        $file_name = $ebasta_1[0]['file_name'];
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['KhataNo']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['KashtkarAnsh']; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo $row['AnshRakba']; ?>
                                            </div>
                                            <div class="cellDiv col7">
                                                <a class="" title="Download Document" target="_blank" href="download?file=<?php echo base64_encode($file_name); ?>&type=<?php echo base64_encode('gata_ebasta'); ?>">
                                                    <div style="position: relative;">
                                                        <img src="img/download_1.svg" height="18px;">
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '55') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Khata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Ansh</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Rakba</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Download</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $sql->fetch()) {
                                        $srno++;
                                        $ebasta_1 = json_decode($row['Ebasta3'], true);
                                        $file_name = $ebasta_1[0]['file_name'];
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['KhataNo']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['KashtkarAnsh']; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo $row['AnshRakba']; ?>
                                            </div>
                                            <div class="cellDiv col7">
                                                <a class="" title="Download Document" target="_blank" href="download?file=<?php echo base64_encode($file_name); ?>&type=<?php echo base64_encode('gata_ebasta'); ?>">
                                                    <div style="position: relative;">
                                                        <img src="img/download_1.svg" height="18px;">
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else if ($dashboard_data == '56') {
                            ?>
                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Code</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Khata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Ansh</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Rakba</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Download</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    while ($row = $sql->fetch()) {
                                        $srno++;
                                        $ebasta_1 = json_decode($row['Ebasta4'], true);
                                        $file_name = $ebasta_1[0]['file_name'];
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['GataNo']; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['KhataNo']; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['KashtkarAnsh']; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo $row['AnshRakba']; ?>
                                            </div>
                                            <div class="cellDiv col7">
                                                <a class="" title="Download Document" target="_blank" href="download?file=<?php echo base64_encode($file_name); ?>&type=<?php echo base64_encode('gata_ebasta'); ?>">
                                                    <div style="position: relative;">
                                                        <img src="img/download_1.svg" height="18px;">
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <input type="hidden" id="dashboard_data" value="<?php echo $dashboard_data; ?>" autocomplete="off">
            <div class="popup-actionwrap posrel">
                <div class="posabsolut act_btn_ovrly"></div>
                <a style="cursor: pointer;" id="cancel_popup" class="pp-secact right cancel">Cancel</a>
                <div class="clr"></div>
            </div>
            <div class="frm_hidden_data"></div>
        </form>
    </div>
</div>