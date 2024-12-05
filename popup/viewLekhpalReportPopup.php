<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../functions/common.function.php';
include_once '../dbcon/db_connect.php';
include_once '../core/viewLekhpalReport.core.php';
?>
<div class="popup-overlay center-screen">
    <div class="popup-wrap pp-large-x">
        <form id="confrm" autocomplete="off">
            <div class="popup-header" style="cursor: move;">
                <span class="popup-title text-wrapping left">Lekhpal Report</span>
                <span class="popup-close right">
                    <a style="cursor:pointer;" id="cancel_popup">
                        <img src="img/clear-w.svg" alt="" width="18px">
                    </a>
                </span>
                <div class="clr"></div>
            </div>

            <div class="popup-body pp-large-y">
                <div class="filter-div">
                    <div class="left" style="font-size: 16px; font-weight: 600; line-height: 34px;"><?php echo $lekhpal_name; ?> : <?php echo $title; ?></div>
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
                        <a style="cursor:pointer;" class="export_lekhpal_view_report" id="<?php echo $dashboard_data; ?>">
                            <img src="img/excel.svg" height="22px">
                        </a>
                    </div>
                    <div class="ebasta_select dev_req_msg right">
                        <input type="text" class="frm-txtbox dept-frm-input" id="search_data" maxlenth="45" placeholder="Enter Gata, Owner" autocomplete="off"  style="width: 190px !important;">
                    </div>
                    <div class="clr"></div>
                    <div class="filter-nos left hide"></div>
                    <div id="appliedFilter"></div>
                    <div class="clr"></div>
                </div>
                <div class="scrl-tblwrap">
                    <div class="containerDiv posrel">
                        <div class="rowDivHeader">
                            <div class="cellDivHeader">
                                <p>Gata No</p>
                            </div>
                            <div class="cellDivHeader">
                                <p>Khata No</p>
                            </div>
                            <div class="cellDivHeader">
                                <p>Owner Name</p>
                            </div>
                            <div class="cellDivHeader">
                                <p>Owner Father</p>
                            </div>
                            <div class="cellDivHeader" style="text-align: center;">
                                <p>Sahmati</p>
                            </div>
                            <div class="cellDivHeader" style="text-align: center;">
                                <p>Bainama</p>
                            </div>
                            <div class="cellDivHeader" style="text-align: center;">
                                <p>Khatauni</p>
                            </div>
                            <div class="cellDivHeader" style="text-align: center;">
                                <p>Kabza</p>
                            </div>
                        </div>
                        <div id="main-body" style="display: contents;">
                            <div id="paginate-body" style="display: contents;">
                                <?php
                                $srno = 0;
                                while ($row = $sql->fetch()) {
                                    $srno++;
                                    $ebasta_1 = json_decode($row['Ebasta1'], true);
                                    $sahmati_file_name = $ebasta_1[0]['file_name'];
                                    $ebasta_2 = json_decode($row['Ebasta2'], true);
                                    $bainama_file_name = $ebasta_2[0]['file_name'];
                                    $ebasta_3 = json_decode($row['Ebasta3'], true);
                                    $khatauni_file_name = $ebasta_3[0]['file_name'];
                                    $ebasta_4 = json_decode($row['Ebasta4'], true);
                                    $kabza_file_name = $ebasta_4[0]['file_name'];
                                    ?>
                                    <div class="rowDiv">
                                        <div class="cellDiv col1">
                                            <?php echo $row['GataNo']; ?>
                                        </div>
                                        <div class="cellDiv col2">
                                            <?php echo $row['KhataNo']; ?>
                                        </div>
                                        <div class="cellDiv col2">
                                            <?php echo $row['owner_name']; ?>
                                        </div>
                                        <div class="cellDiv col2">
                                            <?php echo $row['owner_father']; ?>
                                        </div>
                                        <div class="cellDiv col2" style="text-align: center;">
                                            <?php if ($sahmati_file_name) { ?>
                                                <a class="" title="Download Sahmati" target="_blank" href="download?file=<?php echo base64_encode($sahmati_file_name); ?>&type=<?php echo base64_encode('gata_ebasta'); ?>">
                                                    <div style="position: relative;">
                                                        <img src="img/download_1.svg" height="18px;">
                                                    </div>
                                                </a>
                                            <?php } else { ?>
                                                --
                                            <?php } ?>
                                        </div>
                                        <div class="cellDiv col2" style="text-align: center;">
                                            <?php if ($bainama_file_name) { ?>
                                                <a class="" title="Download Bainama" target="_blank" href="download?file=<?php echo base64_encode($bainama_file_name); ?>&type=<?php echo base64_encode('gata_ebasta'); ?>">
                                                    <div style="position: relative;">
                                                        <img src="img/download_1.svg" height="18px;">
                                                    </div>
                                                </a>
                                            <?php } else { ?>
                                                --
                                            <?php } ?>
                                        </div>
                                        <div class="cellDiv col2" style="text-align: center;">
                                            <?php if ($khatauni_file_name) { ?>
                                                <a class="" title="Download Bainama" target="_blank" href="download?file=<?php echo base64_encode($khatauni_file_name); ?>&type=<?php echo base64_encode('gata_ebasta'); ?>">
                                                    <div style="position: relative;">
                                                        <img src="img/download_1.svg" height="18px;">
                                                    </div>
                                                </a>
                                            <?php } else { ?>
                                                --
                                            <?php } ?>
                                        </div>
                                        <div class="cellDiv col2" style="text-align: center;">
                                            <?php if ($kabza_file_name) { ?>
                                                <a class="" title="Download Bainama" target="_blank" href="download?file=<?php echo base64_encode($kabza_file_name); ?>&type=<?php echo base64_encode('gata_ebasta'); ?>">
                                                    <div style="position: relative;">
                                                        <img src="img/download_1.svg" height="18px;">
                                                    </div>
                                                </a>
                                            <?php } else { ?>
                                                --
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup-actionwrap posrel">
                <div class="posabsolut act_btn_ovrly"></div>
                <a style="cursor: pointer;" id="cancel_popup" class="pp-secact right cancel">Cancel</a>
                <div class="clr"></div>
            </div>
            <input type="hidden" id="lekhpal_user_id" value="<?php echo encryptIt($lekhpal_user_id); ?>" autocomplete="off">
            <input type="hidden" id="village_code" value="<?php echo encryptIt($village_code); ?>" autocomplete="off">
            <div class="frm_hidden_data"></div>
        </form>
    </div>
</div>