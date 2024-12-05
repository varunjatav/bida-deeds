<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/feedbacks.core.php';
if ($total_count) {
    ?>
    <div id="paginate-body" style="display: contents;">
        <?php
        //$srno = 0;
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
    <div class="pagination">
        <div class="left rsltpp">
            <div class="rsl-hding left">Result Per Page</div>
            <div class="rsl-counter left posrel">
                <a style="cursor:pointer;" class="perPage"><?php echo $limit; ?></a>
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
        <input type="hidden" id="pagelimit" autocomplete="off" value="<?php echo $limit; ?>">
        <input type="hidden" id="srno" autocomplete="off" value="<?php echo $srno; ?>">
        <div class="clr"></div>
    </div>
    <?php
} else {
    echo '';
}