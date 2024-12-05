<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../functions/common.function.php';
include_once '../dbcon/db_connect.php';
include_once '../core/parisampattiDetails.core.php';
?>
<div class="popup-overlay center-screen">
    <div class="popup-wrap pp-large-x">
        <form id="confrm" autocomplete="off">
            <div class="popup-header" style="cursor: move;">
                <span class="popup-title text-wrapping left">परिसम्पत्ति  विवरण (<?php echo $total_count; ?>)</span>
                <span class="popup-close right">
                    <a style="cursor:pointer;" id="cancel_popup">
                        <img src="img/clear-w.svg" alt="" width="18px">
                    </a>
                </span>
                <div class="clr"></div>
            </div>

            <div class="popup-body pp-large-y">
                <div class="filter-div" style="display: flex; margin-left: -5px;">
                    <div class="popup_header">
                        <div class="left" style="font-size: 16px; font-weight: 600;">विभाग का नाम: </div>
                        <p class="pop_header_name"><?php echo $department_name . ', '; ?></p>
                    </div>
                    <div class="popup_header">
                        <div class="left" style="font-size: 16px; font-weight: 600;">गाँव का नाम: </div>
                        <p class="pop_header_name"><?php echo $village_name . ', '; ?></p>
                    </div>
                    <div class="popup_header">
                        <div class="left" style="font-size: 16px; font-weight: 600;">गाटा का नम्बर:</div>
                        <p class="pop_header_name"><?php echo $gata_no . ', '; ?></p>
                    </div>
                    <div class="popup_header">
                        <div class="left" style="font-size: 16px; font-weight: 600;">खाता का नम्बर:</div>
                        <p class="pop_header_name"><?php echo $khata_no; ?></p>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="scrl-tblwrap">
                    <div class="containerDiv posrel">
                        <div class="rowDivHeader">
                            <div class="cellDivHeader">
                                <p>वृक्ष का नाम</p>
                            </div>
                            <div class="cellDivHeader">
                                <p>उप वृक्ष का नाम</p>
                            </div>
                            <div class="cellDivHeader">
                                <p>छोटी संपत्ति का नाम</p>
                            </div>
                            <div class="cellDivHeader">
                                <p>संपत्ति का नाम</p>
                            </div>
                            <div class="cellDivHeader">
                                <p>वृक्ष का आयाम</p>
                            </div>
                            <div class="cellDivHeader">
                                <p>एक वृक्ष का मूल्य</p>
                            </div>
                            <div class="cellDivHeader">
                                <p>कुल वृक्षों की संख्या</p>
                            </div>
                            <div class="cellDivHeader">
                                <p>वृक्षों की कुल राशि (सॉफ्टवेर द्वारा)</p>
                            </div>
                            <div class="cellDivHeader">
                                <p>कुल राशि</p>
                            </div>
                        </div>
                        <div id="main-body" style="display: contents;">
                            <div id="paginate-body" style="display: contents;">
                                <?php
                                while ($row = $sql->fetch()) {

                                    if ($row['DifferentAmountType'] == '1') {
                                        $row_color = 'row-highlight-yellow';
                                    } else {
                                        $row_color = '';
                                    }
                                    if ($row['DimensionNumber'] == '1'){
                                        $dimentionNumber = '0-1';
                                    } else if ($row['DimensionNumber'] == '2'){
                                         $dimentionNumber = '1-2';
                                    } else if ($row['DimensionNumber'] == '3'){
                                         $dimentionNumber = '2-3';
                                    } else if ($row['DimensionNumber'] == '4'){
                                         $dimentionNumber = '3-4';
                                    } else if ($row['DimensionNumber'] == '5'){
                                         $dimentionNumber = '4-5';
                                    } else if ($row['DimensionNumber'] == '6'){
                                         $dimentionNumber = '5-6';
                                    } else if ($row['DimensionNumber'] == '7'){
                                         $dimentionNumber = '6-7';
                                    } else {
                                        $dimentionNumber = $row['DimensionNumber'] ? $row['DimensionNumber'] : '--';
                                    }
                                    ?>
                                    <div class="rowDiv <?php echo $row_color; ?>">
                                        <div class="cellDiv col1">
                                            <?php echo $row['TreeName'] ? $row['TreeName'] : '--'; ?>
                                        </div>
                                        <div class="cellDiv col2">
                                            <?php echo $row['SubTreeName'] ? $row['SubTreeName'] : '--'; ?>
                                        </div>
                                        <div class="cellDiv col3">
                                            <?php echo $row['MinorPropertyName'] ? $row['MinorPropertyName'] : '--'; ?>
                                        </div>
                                        <div class="cellDiv col4">
                                            <?php echo $row['PropertyName'] ? $row['PropertyName'] : '--'; ?>
                                        </div>
                                        <div class="cellDiv col5">
                                            <?php echo $dimentionNumber; ?>
                                        </div>
                                        <div class="cellDiv col6">
                                            <?php echo format_rupees($row['DimensionAmount'] ? $row['DimensionAmount'] : 0); ?>
                                        </div>
                                        <div class="cellDiv col7">
                                            <?php echo $row['TotalDimentsionCount'] ? $row['TotalDimentsionCount'] : '--'; ?>
                                        </div>
                                        <div class="cellDiv col8">
                                            <?php echo format_rupees($row['TotalDimensionAmount'] ? $row['TotalDimensionAmount'] : 0); ?>
                                        </div>
                                        <div class="cellDiv col9">
                                            <?php echo format_rupees($row['Amount'] ? $row['Amount'] : 0); ?>
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
            <div class="frm_hidden_data"></div>
        </form>
    </div>
</div>