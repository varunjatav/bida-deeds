<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../functions/common.function.php';
include_once '../dbcon/db_connect.php';
include_once '../core/dashboardChart.core.php';
?>
<div class="popup-overlay center-screen">
    <div class="popup-wrap pp-large-x">
        <form id="confrm" autocomplete="off">
            <div class="popup-header" style="cursor: move;">
                <span class="popup-title text-wrapping left">Dashboard Chart</span>
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
                    <div class="tbl-data right posrel hide" title="Export Qgis Excel">
                        <div class="posabsolut act_btn_ovrly"></div>
                        <a style="cursor:pointer;" class="export_qgis_excel" id="<?php echo $dashboard_data; ?>">
                            <img src="img/map.svg" height="22px">
                        </a>
                    </div>
                    <div class="ebasta_select dev_req_msg right">
                        <select id="filter_chart_village_code">
                            <option value="">Select Village</option>
                        </select>
                        <div class="ebasta_select__arrow"></div>
                    </div>
                    <div class="chart_date_range right rmarg" style="display: none;">
                        <div class="dev_req_msg left rmarg" style="width:100px;">
                            <span>Start Date</span>
                            <input type="text" class="frm-txtbox spbdate frm-focus" placeholder="" autocomplete="off" id="chart_sdate">
                        </div>
                        <div class="dev_req_msg left rmarg" style="width:100px;">
                            <span>End Date</span>
                            <input type="text" class="frm-txtbox spbedate frm-focus" placeholder="" autocomplete="off" id="chart_edate">
                        </div>
                    </div>
                    <div class="ebasta_select dev_req_msg right rmarg" style="min-width: 140px;">
                        <select id="date_type">
                            <option value="last_day">Last Day</option>
                            <option value="last_week">Last Week</option>
                            <option value="monthly" selected="selected">Monthly</option>
                            <option value="date_range">Date Range</option>
                        </select>
                        <div class="ebasta_select__arrow"></div>
                    </div>
                    <div class="ebasta_select dev_req_msg right rmarg" style="min-width: 140px;">
                        <select id="year">
                            <option value="2023">Year 2023</option>
                            <option value="2024" selected="selected">Year 2024</option>
                        </select>
                        <div class="ebasta_select__arrow"></div>
                    </div>
                    <div class="tbl-data right posrel rmarg" title="Switch to list mode">
                        <div class="posabsolut act_btn_ovrly"></div>
                        <a style="cursor:pointer;" class="list_mode_data" id="<?php echo $dashboard_data; ?>" name="<?php echo $title; ?>">
                            <img src="img/list1.svg" width="18">
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

                            <?php
                        } else if ($dashboard_data == '2') {
                            ?>

                            <?php
                        } else if ($dashboard_data == '3') {
                            ?>

                            <?php
                        } else if ($dashboard_data == '4') {
                            ?>

                            <?php
                        } else if ($dashboard_data == '49') {
                            ?>

                            <?php
                        } else if ($dashboard_data == '6') {
                            ?>
                            <div id="container"></div>
                            <script>
                                Highcharts.chart('container', {
                                    chart: {
                                        type: 'column'
                                    },
                                    title: {
                                        text: '<?php echo $text; ?>',
                                        align: 'left'
                                    },
                                    xAxis: {
                                        categories: <?php echo json_encode($x_axis); ?>,
                                        crosshair: true,
                                        accessibility: {
                                            description: 'Countries'
                                        }
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: 'Area (Hectares)'
                                        }
                                    },
                                    tooltip: {
                                        valueSuffix: ' (Hectares)'
                                    },
                                    plotOptions: {
                                        column: {
                                            pointPadding: 0.2,
                                            borderWidth: 0,
                                            dataLabels: {
                                                enabled: true,
                                                format: '{point.y:.1f}'
                                            }
                                        }
                                    },
                                    colors: <?php echo json_encode($color); ?>,
                                    series: [
                                        {
                                            name: 'Area acquired',
                                            colorByPoint: true,
                                            data: <?php echo json_encode($y_axis); ?>
                                        }
                                    ]
                                });
                                $('tCount').text(<?php echo $sum_on_title; ?>);
                            </script>
                            <?php
                        } else if ($dashboard_data == '7') {
                            ?>

                            <?php
                        } else if ($dashboard_data == '8') {
                            ?>

                            <?php
                        } else if ($dashboard_data == '9') {
                            ?>

                            <?php
                        } else if ($dashboard_data == '10') {
                            ?>

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