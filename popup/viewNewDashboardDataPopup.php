<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../functions/common.function.php';
include_once '../dbcon/db_connect.php';
include_once '../core/newDashboardSummary.core.php';
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
                        <a style="cursor:pointer;" class="export_new_dashboard_excel" id="<?php echo $dashboard_data; ?>">
                            <img src="img/excel.svg" height="22px">
                        </a>
                    </div>
                    <div class="ebasta_select dev_req_msg right">
                        <select id="dash_filter_village_code">
                            <option value="">Select Village</option>
                        </select>
                        <div class="ebasta_select__arrow"></div>
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
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
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
                        } else if ($dashboard_data == '2') {
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
                                    <p>Gata Area</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Shreni</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>total_land_and_parisampatti_amount</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    $total_land_and_parisampatti_amount = 0;
                                    while ($row = $sql->fetch()) {
                                        $srno++;
                                        $total_land_and_parisampatti_amount += $row['total_land_and_parisampatti_amount'];
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
                                                <?php echo $row['Shreni']; ?>
                                            </div>
                                            <div class="cellDiv col7">
                                                <?php echo format_rupees($row['total_land_and_parisampatti_amount']); ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <input type="hidden" id="tCount" value="<?php echo $total_land_and_parisampatti_amount; ?>" autocomplete="off">
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
                                    while ($row = $sql->fetch()) {
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
                                    <p>Vilekh Sankhya</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Bainama Date</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Bainama Area</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Land Amount</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Parisampatti Amount</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Bainama Amount</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Payment Amount</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Payment Approval Date</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Download</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    $total_bainama_amount = 0;
                                    while ($row = $sql->fetch()) {
                                        $srno++;
                                        $ebasta_2 = json_decode($row['Ebasta2'], true);
                                        $file_name = $ebasta_2[0]['file_name'];
                                        $total_bainama_amount += $row['BainamaAmount'];
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['VilekhSankhya'] ? $row['VilekhSankhya'] : '--'; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['AnshDate'] ? date('d-m-Y', $row['AnshDate']) : '--'; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['BainamaArea'] ? $row['BainamaArea'] : '--'; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo format_rupees($row['LandAmount']); ?>
                                            </div>
                                            <div class="cellDiv col7">
                                                <?php echo format_rupees($row['ParisampattiAmount']); ?>
                                            </div>
                                            <div class="cellDiv col8">
                                                <?php echo format_rupees($row['BainamaAmount']); ?>
                                            </div>
                                            <div class="cellDiv col9">
                                                <?php echo format_rupees($row['PaymentAmount']); ?>
                                            </div>
                                            <div class="cellDiv col10">
                                                <?php echo $row['PaymentDate'] ? date('d-m-Y', $row['PaymentDate']) : '--'; ?>
                                            </div>
                                            <div class="cellDiv col11">
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
                                <input type="hidden" id="tCount" value="<?php echo $total_bainama_amount; ?>" autocomplete="off">
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
                                    <p>Vilekh Sankhya</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Bainama Date</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Bainama Area</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Land Amount</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Parisampatti Amount</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Bainama Amount</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Payment Amount</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Payment Approval Date</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Download</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    $total_payment_amount = 0;
                                    while ($row = $sql->fetch()) {
                                        $srno++;
                                        $ebasta_2 = json_decode($row['Ebasta2'], true);
                                        $file_name = $ebasta_2[0]['file_name'];
                                        $total_payment_amount += $row['PaymentAmount'];
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['VilekhSankhya'] ? $row['VilekhSankhya'] : '--'; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['AnshDate'] ? date('d-m-Y', $row['AnshDate']) : '--'; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['BainamaArea'] ? $row['BainamaArea'] : '--'; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo format_rupees($row['LandAmount']); ?>
                                            </div>
                                            <div class="cellDiv col7">
                                                <?php echo format_rupees($row['ParisampattiAmount']); ?>
                                            </div>
                                            <div class="cellDiv col8">
                                                <?php echo format_rupees($row['BainamaAmount']); ?>
                                            </div>
                                            <div class="cellDiv col9">
                                                <?php echo format_rupees($row['PaymentAmount']); ?>
                                            </div>
                                            <div class="cellDiv col10">
                                                <?php echo $row['PaymentDate'] ? date('d-m-Y', $row['PaymentDate']) : '--'; ?>
                                            </div>
                                            <div class="cellDiv col11">
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
                                <input type="hidden" id="tCount" value="<?php echo $total_payment_amount; ?>" autocomplete="off">
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
                                    <p>Vilekh Sankhya</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Bainama Date</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Bainama Area</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Land Amount</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Parisampatti Amount</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Bainama Amount</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Payment Amount</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Payment Approval Date</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Download</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
                                    $total_left_amount = 0;
                                    while ($row = $sql->fetch()) {
                                        $srno++;
                                        $ebasta_2 = json_decode($row['Ebasta2'], true);
                                        $file_name = $ebasta_2[0]['file_name'];
                                        $total_left_amount += $row['BainamaAmount'];
                                        ?>
                                        <div class="rowDiv">
                                            <div class="cellDiv col1">
                                                <?php echo $row['VillageName']; ?>
                                            </div>
                                            <div class="cellDiv col2">
                                                <?php echo $row['VillageCode']; ?>
                                            </div>
                                            <div class="cellDiv col3">
                                                <?php echo $row['VilekhSankhya'] ? $row['VilekhSankhya'] : '--'; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['AnshDate'] ? date('d-m-Y', $row['AnshDate']) : '--'; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['BainamaArea'] ? $row['BainamaArea'] : '--'; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo format_rupees($row['LandAmount']); ?>
                                            </div>
                                            <div class="cellDiv col7">
                                                <?php echo format_rupees($row['ParisampattiAmount']); ?>
                                            </div>
                                            <div class="cellDiv col8">
                                                <?php echo format_rupees($row['BainamaAmount']); ?>
                                            </div>
                                            <div class="cellDiv col9">
                                                <?php echo format_rupees($row['PaymentAmount']); ?>
                                            </div>
                                            <div class="cellDiv col10">
                                                <?php echo $row['PaymentDate'] ? date('d-m-Y', $row['PaymentDate']) : '--'; ?>
                                            </div>
                                            <div class="cellDiv col11">
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
                                <input type="hidden" id="tCount" value="<?php echo $total_left_amount - $money_disbursed; ?>" autocomplete="off">
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
                                <div class="cellDivHeader">
                                    <p>Vilekh Sankhya</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Bainama Date</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Bainama Area</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Land Amount</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Parisampatti Amount</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Bainama Amount</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Payment Amount</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Payment Approval Date</p>
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
                                                <?php echo $row['VilekhSankhya'] ? $row['VilekhSankhya'] : '--'; ?>
                                            </div>
                                            <div class="cellDiv col4">
                                                <?php echo $row['AnshDate'] ? date('d-m-Y', $row['AnshDate']) : '--'; ?>
                                            </div>
                                            <div class="cellDiv col5">
                                                <?php echo $row['BainamaArea'] ? $row['BainamaArea'] : '--'; ?>
                                            </div>
                                            <div class="cellDiv col6">
                                                <?php echo format_rupees($row['LandAmount']); ?>
                                            </div>
                                            <div class="cellDiv col7">
                                                <?php echo format_rupees($row['ParisampattiAmount']); ?>
                                            </div>
                                            <div class="cellDiv col8">
                                                <?php echo format_rupees($row['BainamaAmount']); ?>
                                            </div>
                                            <div class="cellDiv col9">
                                                <?php echo format_rupees($row['PaymentAmount']); ?>
                                            </div>
                                            <div class="cellDiv col10">
                                                <?php echo $row['PaymentDate'] ? date('d-m-Y', $row['PaymentDate']) : '--'; ?>
                                            </div>
                                            <div class="cellDiv col11">
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