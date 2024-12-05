<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../functions/common.function.php';
include_once '../dbcon/db_connect.php';
include_once '../core/resourceFeedbacks.core.php';
?>
<div class="popup-overlay center-screen">
    <div class="popup-wrap pp-large-x">
        <form id="confrm" autocomplete="off">
            <div class="popup-header" style="cursor: move;">
                <span class="popup-title text-wrapping"><?php echo $_GET['title']; ?></span>
            </div>
            <div class="popup-body pp-large-y">
                <div class="form-field-wrap posrel dev_req_msg">
                    <div style="font-size: 16px; font-weight: 600;"><?php echo $_GET['text']; ?></div>
                    <div class="logintype tmarg rmarg">
                        <label>
                            <span class="left">
                                <input type="radio" name="report_feedback" class="chk chk_report_feedback" value="1" checked="checked">
                            </span>
                            <p class="left"><strong>YES &nbsp;</strong></p>
                        </label>
                        <div class="clr"></div>
                        <div class="frm-er-msg"></div>
                    </div>
                    <div class="logintype tmarg">
                        <label>
                            <span class="left">
                                <input type="radio" name="report_feedback" class="chk chk_report_feedback" value="2">
                            </span>
                            <p class="left"><strong>NO &nbsp;</strong></p>
                        </label>
                        <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                    <div class="frm-er-msg"></div>
                </div>
                <?php
                if ($_GET['remarks']) {
                    ?>
                    <div class="remarks_div <?php if ($_GET['remarks_enabled'] == 'no') { ?>hide<?php } ?>" style="margin-bottom: 20px;">
                        <div class="form-field-wrap posrel">
                            <div class="posabsolut frm-lbl-actv"></div>
                            <div class="form-type dev_req_msg">
                                <textarea class="str-txarea frm-txarea <?php if ($_GET['remarks_mandatory']) { ?>fldrequired<?php } ?>" data-maxlength="320" placeholder="Message" oninput="validateMaxlength(0)" onpaste="return false;" ondrop="return false;" name="message" id="message_txt"></textarea>
                                <div class="frm-er-msg"></div>
                            </div>
                        </div>
                        <span><i class="msg_txt" style="color:red;">* 320 characters remaining.</i></span>
                    </div>
                    <?php
                }
                ?>
                <input type="hidden" name="resource_type" value="<?php echo myUrlEncode($_GET['resource_type']); ?>" autocomplete="off">
                <input type="hidden" name="report_type" value="<?php echo myUrlEncode($_GET['report_type']); ?>" autocomplete="off">
                <input type="hidden" name="village_code" value="<?php echo myUrlEncode($_GET['village_code']); ?>" autocomplete="off">
                <input type="hidden" name="village_gata" value="<?php echo myUrlEncode($_GET['village_gata']); ?>" autocomplete="off">
                <input type="hidden" name="report_no" value="<?php echo myUrlEncode($_GET['report_no']); ?>" autocomplete="off">

                <?php
                if ($total_count) {
                    ?>
                    <div class="form-field-wrap posrel" style="margin-bottom: 0px;">
                        <div style="font-size: 16px; font-weight: 600;">Previous Feedbacks</div>
                        <div class="clr"></div>
                    </div>
                    <div class="scrl-tblwrap">
                        <div class="containerDiv">

                            <div class="rowDivHeader">
                                <div class="cellDivHeader">
                                    <p>Sr.No.</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Resource</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Report Type</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Village Name</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Gata No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Report No</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Satisfied</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Date Posted</p>
                                </div>
                                <div class="cellDivHeader">
                                    <p>Remarks</p>
                                </div>
                            </div>
                            <div id="main-body" style="display: contents;">
                                <div id="paginate-body" style="display: contents;">
                                    <?php
                                    $srno = 0;
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
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="popup-actionwrap posrel">
                <div class="posabsolut act_btn_ovrly"></div>
                <a style="cursor: pointer;" id="<?php echo $_GET['btn_id']; ?>" class="pp-primact right"><?php echo $_GET['btn_name']; ?></a>
                <a style="cursor: pointer;" id="cancel_popup" class="pp-secact right cancel">Cancel</a>
                <div class="clr"></div>
            </div>
            <div class="frm_hidden_data"></div>
        </form>
    </div>
</div>