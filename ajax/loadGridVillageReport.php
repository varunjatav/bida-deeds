<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/gridVillageReport.core.php';
?>
<div class="rowDivHeader">
    <div class="repoCellDivHeaderCenter">
        <p>Village Name</p>
    </div>
    <div class="repoCellDivHeaderCenter">
        <p>Village Code</p>
    </div>
    <div class="repoCellDivHeaderCenter">
        <p>कितने गाटे 1359 फसली खतौनी में उपलब्ध नहीं है ?</p>
    </div>
    <div class="repoCellDivHeaderCenter">
        <p>कितने गाटे सीएच 41-45 में उपलब्ध नहीं है ?</p>
    </div>
    <div class="repoCellDivHeaderCenter">
        <p>ऐसे गाटो की संख्या जो 1359 फसली खसरे के अनुसर सुरक्षित श्रेणि में है</p>
    </div>
    <div class="repoCellDivHeaderCenter">
        <p>ऐसे गाटो की संख्या जिनकी वर्तमान श्रेनी सीएच 41-45 के समान नहीं है</p>
    </div>
    <div class="repoCellDivHeaderCenter">
        <p>ऐसे गाटो की संख्या जिनका वर्तमान रकबा 1359 फसली के रकबे के बराबर नहीं है</p>
    </div>
    <div class="repoCellDivHeaderCenter">
        <p>ऐसे गाटो की संख्या जिनका वर्तमान रकबा सीएच 41-45 के रकबे के बराबर नहीं है</p>
    </div>
    <div class="repoCellDivHeaderCenter">
        <p>ऐसे गाटो की संख्या जहां कृषि दर निर्धारित नहीं की गई है</p>
    </div>
    <div class="repoCellDivHeaderCenter">
        <p>ऐसे गाटो की संख्या जहां आबादी दर निर्धारित नहीं की गई है</p>
    </div>
    <div class="repoCellDivHeaderCenter">
        <p>ऐसे गाटो की संख्या जहां सड़क किनारे की दर निर्धारित नहीं की गई है</p>
    </div>
    <div class="repoCellDivHeaderCenter">
        <p>ऐसे गाटो की संख्या जहां एक से अधिक प्रकार की दर निर्धारित की गई है</p>
    </div>
    <div class="repoCellDivHeaderCenter">
        <p>ऐसे गाटो की संख्या जहां पिछले एक साल की मार्केट रेट गाटे की सर्कल रेट अधिक है</p>
    </div>
    <div class="repoCellDivHeaderCenter">
        <p>ऐसे गाटो की संख्या जहां पिछले दो साल में सर्किल रेट अधिक है</p>
    </div>
    <div class="repoCellDivHeaderCenter">
        <p>ऐसे गाटो की संख्या जहां गाटे का भूमि मूल्य सर्किल रेट के चार गुने से अधिक है</p>
    </div>
    <div class="repoCellDivHeaderCenter">
        <p>ऐसे गाटो की संख्या जहां परिसम्पत्तियों का मुल्य कुल भूमि के मुल्य के 10 प्रतिषत से अधिक है</p>
    </div>
    <div class="repoCellDivHeaderCenter">
        <p>ऐसे गाटो की संख्या जहां परिसम्पत्तियों का मूल्य 10 लाख रूपये से अधिक है</p>
    </div>
    <div class="repoCellDivHeaderCenter">
        <p>ऐसे गाटो की संख्या जिन्हे जिलाधिकरी द्वार विज्ञपति से पहले रोका गया है</p>
    </div>
    <div class="repoCellDivHeaderCenter">
        <p>ऐसे गाटो की संख्या जिन्हे बीड़ा द्वार प्रेस विज्ञपति से पूर्व रोका गया है</p>
    </div>
    <div class="repoCellDivHeaderCenter">
        <p>ऐसे गाटो की संख्या जिन्हे दर निर्धारण समिति द्वारा रोका गया है</p>
    </div>
    <div class="repoCellDivHeaderCenter">
        <p>ऐसे गाटो की संख्या जिनका बैनामा बीड़ा द्वार दर निर्धारण के उपरान्त रोका गया है</p>
    </div>
    <div class="repoCellDivHeaderCenter">
        <p>ऐसे गाटो की संख्या जो नक्शे पर है परंतु मौके पर नहीं है</p>
    </div>
    <div class="repoCellDivHeaderCenter">
        <p>ऐसे गाटो की संख्या जो मानचित्र/मौके पर नहर है परंतु खतौनी में काश्तकार के नाम दर्ज है</p>
    </div>
    <div class="repoCellDivHeaderCenter">
        <p>ऐसे गाटो की संख्या जो मानचित्र/मौके पर सड़क है परंतु खतौनी में काश्तकार के नाम दर्ज हैं</p>
    </div>
    <div class="repoCellDivHeaderCenter">
        <p>ऐसे बैनामे जहाँ गाटों का दर निर्धारण नहीं हुआ</p>
    </div>
    <div class="repoCellDivHeaderCenter">
        <p>ऐसे बैनामे जहाँ दर निर्धारण से ज्यादा भुगतान हो गया है</p>
    </div>
    <div class="repoCellDivHeaderCenter">
        <p>ऐसे बैनामे जहाँ एक ही काश्तकार का एक ही गाटा पर एक से ज्यादा बार बैनामा हुआ है</p>
    </div>
    <div class="repoCellDivHeaderCenter">
        <p>ऐसे बैनामे जिनमें तितिम्मा हुआ है</p>
    </div>
</div>
<div id="main-body" style="display: contents;">
    <div id="paginate-body" style="display: contents;">
        <?php
        $srno = 0;
        $point_1_total = 0;
        $point_2_total = 0;
        foreach ($villageInfo as $vKey => $vValue) {
            $srno++;
            for ($j = 1; $j < 27; $j++) {
                ${"point_" . $j . "_total"} += (float) ${"point_" . $j}[$vValue['VillageCode']];
            }
            ?>
            <div class="rowDiv">
                <div class="cellDivCenter col1">
                    <?php echo $vValue['VillageName']; ?>
                </div>
                <div class="cellDivCenter col2">
                    <?php echo $vValue['VillageCode']; ?>
                </div>
                <div class="cellDivCenter col3">
                    <?php if ((float) $point_1[$vValue['VillageCode']] > 0) { ?>
                        <a style="cursor: pointer;" class="view_grid_data" id="1" village_code="<?php echo $vValue['VillageCode']; ?>"><?php echo $point_1[$vValue['VillageCode']]; ?></a>
                    <?php } else { ?>
                        <?php echo $point_1[$vValue['VillageCode']]; ?>
                    <?php } ?>
                </div>
                <div class="cellDivCenter col4">
                    <?php if ((float) $point_2[$vValue['VillageCode']] > 0) { ?>
                        <a style="cursor: pointer;" class="view_grid_data" id="2" village_code="<?php echo $vValue['VillageCode']; ?>"><?php echo $point_2[$vValue['VillageCode']]; ?></a>
                    <?php } else { ?>
                        <?php echo $point_2[$vValue['VillageCode']]; ?>
                    <?php } ?>
                </div>
                <div class="cellDivCenter col5">
                    <?php if ((float) $point_3[$vValue['VillageCode']] > 0) { ?>
                        <a style="cursor: pointer;" class="view_grid_data" id="3" village_code="<?php echo $vValue['VillageCode']; ?>"><?php echo $point_3[$vValue['VillageCode']]; ?></a>
                    <?php } else { ?>
                        <?php echo $point_3[$vValue['VillageCode']]; ?>
                    <?php } ?>
                </div>
                <div class="cellDivCenter col6">
                    <?php if ((float) $point_4[$vValue['VillageCode']] > 0) { ?>
                        <a style="cursor: pointer;" class="view_grid_data" id="4" village_code="<?php echo $vValue['VillageCode']; ?>"><?php echo $point_4[$vValue['VillageCode']]; ?></a>
                    <?php } else { ?>
                        <?php echo $point_4[$vValue['VillageCode']]; ?>
                    <?php } ?>
                </div>
                <div class="cellDivCenter col7">
                    <?php if ((float) $point_5[$vValue['VillageCode']] > 0) { ?>
                        <a style="cursor: pointer;" class="view_grid_data" id="5" village_code="<?php echo $vValue['VillageCode']; ?>"><?php echo $point_5[$vValue['VillageCode']]; ?></a>
                    <?php } else { ?>
                        <?php echo $point_5[$vValue['VillageCode']]; ?>
                    <?php } ?>
                </div>
                <div class="cellDivCenter col8">
                    <?php if ((float) $point_6[$vValue['VillageCode']] > 0) { ?>
                        <a style="cursor: pointer;" class="view_grid_data" id="6" village_code="<?php echo $vValue['VillageCode']; ?>"><?php echo $point_6[$vValue['VillageCode']]; ?></a>
                    <?php } else { ?>
                        <?php echo $point_6[$vValue['VillageCode']]; ?>
                    <?php } ?>
                </div>
                <div class="cellDivCenter col9">
                    <?php if ((float) $point_7[$vValue['VillageCode']] > 0) { ?>
                        <a style="cursor: pointer;" class="view_grid_data" id="7" village_code="<?php echo $vValue['VillageCode']; ?>"><?php echo $point_7[$vValue['VillageCode']]; ?></a>
                    <?php } else { ?>
                        <?php echo $point_7[$vValue['VillageCode']]; ?>
                    <?php } ?>
                </div>
                <div class="cellDivCenter col10">
                    <?php if ((float) $point_8[$vValue['VillageCode']] > 0) { ?>
                        <a style="cursor: pointer;" class="view_grid_data" id="8" village_code="<?php echo $vValue['VillageCode']; ?>"><?php echo $point_8[$vValue['VillageCode']]; ?></a>
                    <?php } else { ?>
                        <?php echo $point_8[$vValue['VillageCode']]; ?>
                    <?php } ?>
                </div>
                <div class="cellDivCenter col11">
                    <?php if ((float) $point_9[$vValue['VillageCode']] > 0) { ?>
                        <a style="cursor: pointer;" class="view_grid_data" id="9" village_code="<?php echo $vValue['VillageCode']; ?>"><?php echo $point_9[$vValue['VillageCode']]; ?></a>
                    <?php } else { ?>
                        <?php echo $point_9[$vValue['VillageCode']]; ?>
                    <?php } ?>
                </div>
                <div class="cellDivCenter col12">
                    <?php if ((float) $point_10[$vValue['VillageCode']] > 0) { ?>
                        <a style="cursor: pointer;" class="view_grid_data" id="10" village_code="<?php echo $vValue['VillageCode']; ?>"><?php echo $point_10[$vValue['VillageCode']]; ?></a>
                    <?php } else { ?>
                        <?php echo $point_10[$vValue['VillageCode']]; ?>
                    <?php } ?>
                </div>
                <div class="cellDivCenter col13">
                    <?php if ((float) $point_11[$vValue['VillageCode']] > 0) { ?>
                        <a style="cursor: pointer;" class="view_grid_data" id="11" village_code="<?php echo $vValue['VillageCode']; ?>"><?php echo $point_11[$vValue['VillageCode']]; ?></a>
                    <?php } else { ?>
                        <?php echo $point_11[$vValue['VillageCode']]; ?>
                    <?php } ?>
                </div>
                <div class="cellDivCenter col14">
                    <?php if ((float) $point_12[$vValue['VillageCode']] > 0) { ?>
                        <a style="cursor: pointer;" class="view_grid_data" id="12" village_code="<?php echo $vValue['VillageCode']; ?>"><?php echo $point_12[$vValue['VillageCode']]; ?></a>
                    <?php } else { ?>
                        <?php echo $point_12[$vValue['VillageCode']]; ?>
                    <?php } ?>
                </div>
                <div class="cellDivCenter col15">
                    <?php if ((float) $point_13[$vValue['VillageCode']] > 0) { ?>
                        <a style="cursor: pointer;" class="view_grid_data" id="13" village_code="<?php echo $vValue['VillageCode']; ?>"><?php echo $point_13[$vValue['VillageCode']]; ?></a>
                    <?php } else { ?>
                        <?php echo $point_13[$vValue['VillageCode']]; ?>
                    <?php } ?>
                </div>
                <div class="cellDivCenter col16">
                    <?php if ((float) $point_14[$vValue['VillageCode']] > 0) { ?>
                        <a style="cursor: pointer;" class="view_grid_data" id="14" village_code="<?php echo $vValue['VillageCode']; ?>"><?php echo $point_14[$vValue['VillageCode']]; ?></a>
                    <?php } else { ?>
                        <?php echo $point_14[$vValue['VillageCode']]; ?>
                    <?php } ?>
                </div>
                <div class="cellDivCenter col17">
                    <?php if ((float) $point_15[$vValue['VillageCode']] > 0) { ?>
                        <a style="cursor: pointer;" class="view_grid_data" id="15" village_code="<?php echo $vValue['VillageCode']; ?>"><?php echo $point_15[$vValue['VillageCode']]; ?></a>
                    <?php } else { ?>
                        <?php echo $point_15[$vValue['VillageCode']]; ?>
                    <?php } ?>
                </div>
                <div class="cellDivCenter col18">
                    <?php if ((float) $point_16[$vValue['VillageCode']] > 0) { ?>
                        <a style="cursor: pointer;" class="view_grid_data" id="16" village_code="<?php echo $vValue['VillageCode']; ?>"><?php echo $point_16[$vValue['VillageCode']]; ?></a>
                    <?php } else { ?>
                        <?php echo $point_16[$vValue['VillageCode']]; ?>
                    <?php } ?>
                </div>
                <div class="cellDivCenter col19">
                    <?php if ((float) $point_17[$vValue['VillageCode']] > 0) { ?>
                        <a style="cursor: pointer;" class="view_grid_data" id="17" village_code="<?php echo $vValue['VillageCode']; ?>"><?php echo $point_17[$vValue['VillageCode']]; ?></a>
                    <?php } else { ?>
                        <?php echo $point_17[$vValue['VillageCode']]; ?>
                    <?php } ?>
                </div>
                <div class="cellDivCenter col20">
                    <?php if ((float) $point_18[$vValue['VillageCode']] > 0) { ?>
                        <a style="cursor: pointer;" class="view_grid_data" id="18" village_code="<?php echo $vValue['VillageCode']; ?>"><?php echo $point_18[$vValue['VillageCode']]; ?></a>
                    <?php } else { ?>
                        <?php echo $point_18[$vValue['VillageCode']]; ?>
                    <?php } ?>
                </div>
                <div class="cellDivCenter col21">
                    <?php if ((float) $point_19[$vValue['VillageCode']] > 0) { ?>
                        <a style="cursor: pointer;" class="view_grid_data" id="19" village_code="<?php echo $vValue['VillageCode']; ?>"><?php echo $point_19[$vValue['VillageCode']]; ?></a>
                    <?php } else { ?>
                        <?php echo $point_19[$vValue['VillageCode']]; ?>
                    <?php } ?>
                </div>
                <div class="cellDivCenter col22">
                    <?php if ((float) $point_20[$vValue['VillageCode']] > 0) { ?>
                        <a style="cursor: pointer;" class="view_grid_data" id="20" village_code="<?php echo $vValue['VillageCode']; ?>"><?php echo $point_20[$vValue['VillageCode']]; ?></a>
                    <?php } else { ?>
                        <?php echo $point_20[$vValue['VillageCode']]; ?>
                    <?php } ?>
                </div>
                <div class="cellDivCenter col23">
                    <?php if ((float) $point_21[$vValue['VillageCode']] > 0) { ?>
                        <a style="cursor: pointer;" class="view_grid_data" id="21" village_code="<?php echo $vValue['VillageCode']; ?>"><?php echo $point_21[$vValue['VillageCode']]; ?></a>
                    <?php } else { ?>
                        <?php echo $point_21[$vValue['VillageCode']]; ?>
                    <?php } ?>
                </div>
                <div class="cellDivCenter col24">
                    <?php if ((float) $point_22[$vValue['VillageCode']] > 0) { ?>
                        <a style="cursor: pointer;" class="view_grid_data" id="22" village_code="<?php echo $vValue['VillageCode']; ?>"><?php echo $point_22[$vValue['VillageCode']]; ?></a>
                    <?php } else { ?>
                        <?php echo $point_22[$vValue['VillageCode']]; ?>
                    <?php } ?>
                </div>
                <div class="cellDivCenter col25">
                    <?php if ((float) $point_23[$vValue['VillageCode']] > 0) { ?>
                        <a style="cursor: pointer;" class="view_grid_data" id="23" village_code="<?php echo $vValue['VillageCode']; ?>"><?php echo $point_23[$vValue['VillageCode']]; ?></a>
                    <?php } else { ?>
                        0
                    <?php } ?>
                </div>
                <div class="cellDivCenter col26">
                    <?php if ((float) $point_24[$vValue['VillageCode']] > 0) { ?>
                        <a style="cursor: pointer;" class="view_grid_data" id="24" village_code="<?php echo $vValue['VillageCode']; ?>"><?php echo $point_24[$vValue['VillageCode']]; ?></a>
                    <?php } else { ?>
                        0
                    <?php } ?>
                </div>
                <div class="cellDivCenter col27">
                    <?php if ((float) $point_25[$vValue['VillageCode']] > 0) { ?>
                        <a style="cursor: pointer;" class="view_grid_data" id="25" village_code="<?php echo $vValue['VillageCode']; ?>"><?php echo $point_25[$vValue['VillageCode']]; ?></a>
                    <?php } else { ?>
                        0
                    <?php } ?>
                </div>
                <div class="cellDivCenter col28">
                    <?php if ((float) $point_26[$vValue['VillageCode']] > 0) { ?>
                        <a style="cursor: pointer;" class="view_grid_data" id="26" village_code="<?php echo $vValue['VillageCode']; ?>"><?php echo $point_26[$vValue['VillageCode']]; ?></a>
                    <?php } else { ?>
                        0
                    <?php } ?>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="rowDiv">
            <div class="cellDivCenter col1">

            </div>
            <div class="cellDivCenter col2">

            </div>
            <?php
            for ($j = 1; $j < 27; $j++) {
                ?>
                <div class="cellDivCenter col<?php echo ($j + 2); ?>" style="font-weight: 600; font-size: 16px;">
                    <a style="cursor: pointer; color: #000;" class="view_grid_total_data" id="<?php echo $j; ?>"><?php echo ${"point_" . $j . "_total"}; ?></a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>