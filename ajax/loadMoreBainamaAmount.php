<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/bainamaAmount.core.php';
if ($total_count) {
    ?>
    <div id="paginate-body" style="display: contents;">
        <?php
        while ($row = $sql->fetch()) {
            $patravali_status = '--';
            if ($row['PatravaliStatus'] == '1') {
                $patravali_status = 'तहसील के पास (Gulab Singh & Lalit)';
            } else if ($row['PatravaliStatus'] == '2') {
                $patravali_status = 'बंधक पत्रावली (RK Shukla)';
            } else if ($row['PatravaliStatus'] == '3') {
                $patravali_status = 'बंजर पत्रावली (Gulab singh & Lalit)';
            } else if ($row['PatravaliStatus'] == '4') {
                $patravali_status = 'तितिम्मा पत्रावली (Lal Krishna)⁠';
            } else if ($row['PatravaliStatus'] == '5') {
                $patravali_status = 'पेमेंट हो चुका';
            } else if ($row['PatravaliStatus'] == '6') {
                $patravali_status = 'SLAO के पास';
            }
            $ebasta_2 = json_decode($row['Ebasta2'], true);
            $file_name = $ebasta_2[0]['file_name'];
            //echo $row['EbastaIds'];
            ?>
            <div class="rowDiv">
                <div class="cellDiv col1">
                    <?php echo $row['VillageName'] ? $row['VillageName'] : '--'; ?>
                </div>
                <!--<div class="cellDiv col2" name="<?php echo $row['VillageCode'] ? $row['VillageCode'] : 0; ?>">
                <?php echo $row['VillageCode'] ? $row['VillageCode'] : "--"; ?>
                </div>-->
                <div class="cellDiv col2">
                    <div style="position: relative;">
                        <a class="" title="Download Document" target="_blank" href="download?file=<?php echo base64_encode($file_name); ?>&type=<?php echo base64_encode('gata_ebasta'); ?>">
                            <img src="img/download_1.svg" height="18px;">
                        </a>
                    </div>
                </div>
                <div class="cellDiv col3" name="<?php echo $row['AnshDate'] ? $row['AnshDate'] : 0; ?>">
                    <?php echo $row['AnshDate'] ? date('d-m-Y', $row['AnshDate']) : "--"; ?>
                </div>
                <div class="cellDiv col4" name="<?php echo $row['AnshRakba'] ? $row['AnshRakba'] : 0; ?>">
                    <?php echo $row['AnshRakba'] ? $row['AnshRakba'] : "--"; ?>
                </div>
                <div class="cellDiv col5">
                    <span class="vilekh_sankhya"><?php echo $row['VilekhSankhya'] ? $row['VilekhSankhya'] : "--"; ?></span>
                    <input type="text" class="frm-txtbox frm-txtbox-brdr vilekh hide" name="vilekh" maxlength="10" placeholder="Vilekh Sankhya">
                </div>
                <div class="cellDiv col6" name="<?php echo $row['BainamaArea'] ? $row['BainamaArea'] : 0; ?>">
                    <span class="bainama_area_text"><?php echo $row['BainamaArea'] ? $row['BainamaArea'] : "--"; ?></span>
                    <input type="text" class="frm-txtbox frm-txtbox-brdr bainama_area numeric hide" name="bainama_area" maxlength="14" placeholder="Bainama Area">
                </div>
                <div class="cellDiv col7" name="<?php echo $row['LandAmount'] ? $row['LandAmount'] : 0; ?>">
                    <span class="land_amount_text"><?php echo $row['LandAmount'] ? $row['LandAmount'] : "--"; ?></span>
                    <input type="text" class="frm-txtbox frm-txtbox-brdr land_amount numeric hide" name="land_amount" maxlength="14" placeholder="Land Amount">
                </div>
                <div class="cellDiv col8" name="<?php echo $row['ParisampattiAmount'] ? $row['ParisampattiAmount'] : 0; ?>">
                    <span class="pari_amount_text"><?php echo $row['ParisampattiAmount'] ? $row['ParisampattiAmount'] : "--"; ?></span>
                    <input type="text" class="frm-txtbox frm-txtbox-brdr pari_amount numeric hide" name="pari_amount" maxlength="14" placeholder="Parisampatti Amount">
                </div>
                <div class="cellDiv col9" name="<?php echo $row['BainamaAmount'] ? $row['BainamaAmount'] : 0; ?>">
                    <span class="bainama_amount"><?php echo $row['BainamaAmount'] ? $row['BainamaAmount'] : "--"; ?></span>
                    <input type="text" class="frm-txtbox frm-txtbox-brdr amount numeric hide" name="amount" maxlength="14" placeholder="Bainama Amount">
                </div>
                <!--<div class="cellDiv col8">
                <?php echo $patravali_status; ?>
                </div>-->
                <div class="cellDiv col10" name="<?php echo $row['PaymentAmount'] ? $row['PaymentAmount'] : 0; ?>">
                    <span class="payment_amount_text"><?php echo $row['PaymentAmount'] ? $row['PaymentAmount'] : "--"; ?></span>
                    <input type="text" class="frm-txtbox frm-txtbox-brdr payment_amount numeric hide" name="payment_amount" maxlength="14" placeholder="Payment Amount">
                </div>
                <div class="cellDiv col11" name="<?php echo $row['PaymentDate'] ? $row['PaymentDate'] : 0; ?>">
                    <span class="payment_date_text"><?php echo $row['PaymentDate'] ? date('d-m-Y', $row['PaymentDate']) : "--"; ?></span>
                    <input type="text" class="frm-txtbox frm-txtbox-brdr spbdate payment_date hide" name="payment_date" placeholder="Payment Date">
                </div>
                <div class="cellDiv col12 cellDivacts">
                    <?php if ($user_type == '0') { ?>
                        <img src="img/edit.svg" height="18" alt="" class="edit_bainama_amount" style="cursor:pointer;">
                        <div class="btn-min-actionwrap posrel action-btn hide">
                            <div class="posabsolut act_btn_ovrly"></div>
                            <a style="cursor: pointer;" class="pp-primact save_bainama_amount" id="<?php echo encryptIt($row['EbastaIds']); ?>" village_code="<?php echo encryptIt($row['VillageCode']); ?>" bainama_date="<?php echo $row['AnshDate'] ? $row['AnshDate'] : 0; ?>">Save</a>
                            <a style="cursor: pointer;" class="pp-secact cancel_bainama_amount">Cancel</a>
                        </div>
                    <?php } else if ($user_type == '8') { ?>
                        <div class="posrel tblactns">
                            <a style="cursor:pointer;" class="showAction">
                                <img src="img/more-vertical-dark.svg" alt="" height="18px">
                            </a>
                            <div class="posabsolut nwactdrops" style="display:none;">
                                <a style="cursor: pointer;" id="<?php echo encryptIt($row['EbastaIds']); ?>" class="update_patravali text-wrapping">Update Patravali</a>
                            </div>
                        </div>
                    <?php } ?>
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