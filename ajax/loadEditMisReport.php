<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/village.core.php';
include_once '../core/misReport.core.php';
if ($report_type == '1') {
    ?>
    <div id="main-body" style="display: contents;">
        <div class="rowDivHeader">
            <div class="repoCellDivHeader">
                <p>ग्राम का नाम</p>
            </div>
            <div class="repoCellDivHeader">
                <p>कुल गाटों की संख्या जो क्रय की जानी है</p>
            </div>
            <div class="repoCellDivHeader">
                <p>कुल कृषक जिनसे बैनामें किये जाने हैं</p>
            </div>
            <div class="repoCellDivHeader">
                <p>कुल रकबा जो क्रय किया जाना है</p>
            </div>
            <div class="repoCellDivHeader">
                <p>निर्धारित कार्ययोजना के अनुसार कुल रकबा जिस पर आज सहमति की गयी</p>
            </div>
            <div class="repoCellDivHeader">
                <p>कुल रकबा जिस पर आज तक सहमति प्राप्त  हो गयी है</p>
            </div>
            <div class="repoCellDivHeader">
                <p>खतौनी के अनुसार कुल कितने गाटों का अंश निर्धारित  किया जाना है</p>
            </div>
            <div class="repoCellDivHeader">
                <p>खतौनी के अनुसार कुल कितने कृषकों का अंश निर्धारित किया जाना है</p>
            </div>
            <div class="repoCellDivHeader">
                <p>आज दिनांक को कुल कितने कृषकों का अंश निर्धारित किया गया है</p>
            </div>
            <div class="repoCellDivHeader">
                <p>खतौनी के अनुसार ऐसा रकबा जहां अंश निर्धारित नहीं किया जाना है</p>
            </div>
            <div class="repoCellDivHeader">
                <p>आज दिनांक को ऐसा रकबा जहां अंश निर्धारित नहीं किया जाना है के संबंध में कितने रकबे पर सहमति प्राप्त की गयी</p>
            </div>
            <div class="repoCellDivHeader">
                <p>लेखपाल का नाम जिसके द्वारा हिस्सा निर्धारण किया जाना था</p>
            </div>
            <div class="repoCellDivHeader">
                <p>लेखपाल द्वारा कुल कितने हिस्से का निर्धारण किया जाना था</p>
            </div>
            <div class="repoCellDivHeader">
                <p>आज दिनांक को कितना हिस्सा निर्धारण  किया गया</p>
            </div>
            <div class="repoCellDivHeader">
                <p>लेखपाल द्वारा कितनी सहमति ली जानी थी</p>
            </div>
            <div class="repoCellDivHeader">
                <p>आज दिनांक को कितनी सहमति प्राप्त की गयी</p>
            </div>
        </div>
        <div id="paginate-body" style="display: contents;">
            <?php
            foreach ($villageInfo as $key => $value) {
                $cell_count = 0;
                $data = json_decode($reportInfo[$value['VillageCode']]['Report'], true);
                ?>
                <div class="rowDiv">
                    <div class="cellDiv col1">
                        <?php echo $value['VillageName'] ? $value['VillageName'] : '--'; ?>
                        <input type="hidden" class="frm-txtbox frm-txtbox-brdr" name="village_code[]" value="<?php echo $value['VillageCode']; ?>" maxlength="45" placeholder="">
                    </div>
                    <div class="cellDiv col2">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col3">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col4">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col5">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col6">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col7">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col8">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col9">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col10">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col11">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col11">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col11">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col11">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col11">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col11">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else if ($report_type == '2') {
    ?>
    <div id="main-body" style="display: contents;">
        <div class="rowDivHeader">
            <div class="repoCellDivHeader">
                <p>ग्राम का नाम</p>
            </div>
            <div class="repoCellDivHeader">
                <p>कुल गाटे जिनसे भूमि क्रय  की जानी है</p>
            </div>
            <div class="repoCellDivHeader">
                <p>कुल कृषक जिनसे बैनामें किये जाने हैं</p>
            </div>
            <div class="repoCellDivHeader">
                <p>कुल रकबा जो क्रय किया जाना है</p>
            </div>
            <div class="repoCellDivHeader">
                <p>जिलाधिकारी के स्तर से पत्र के क्रम में प्राप्त बैनामों की संख्या</p>
            </div>
            <div class="repoCellDivHeader">
                <p>जिलाधिकारी को कार्यालय आदेश-29/बीडा/सा0प्र0/2023-24 दिनांक 20.03.2024 के क्रम में ओएडी श्री शुक्ला द्वारा वापस किये गये बैनामों की संख्या</p>
            </div>
            <div class="repoCellDivHeader">
                <p>कार्यालय आदेश-28/बीडा/सा0प्र0/कार्य आ0/2023-24 दिनांक 19.03.2024 के क्रम में विशेष कार्याधिकारी  द्वारा परीक्षण उपरान्त ग्रहण योग्य पाये गये बैनामों की संख्या</p>
            </div>
            <div class="repoCellDivHeader">
                <p>ग्रहण हेतु योग्य पाये गये बैनामों के सापेक्ष कुल रकबा</p>
            </div>
            <div class="repoCellDivHeader">
                <p>ग्रहण हेतु योग्य पाये गये बैनामों में कुल कृषकों की संख्या</p>
            </div>
            <div class="repoCellDivHeader">
                <p>बैनामें हेतु अवशेष रकबा</p>
            </div>
            <div class="repoCellDivHeader">
                <p>आईआईडीसी महोदय की सोमवार की बैठक हेतु जिलाधिकारी स्तर से उपलब्ध करायी गयी सूचना के आधार पर अब तक कुल बैनामों की संख्या</p>
            </div>
        </div>
        <div id="paginate-body" style="display: contents;">
            <?php
            foreach ($villageInfo as $key => $value) {
                $cell_count = 0;
                $data = json_decode($reportInfo[$value['VillageCode']]['Report'], true);
                ?>
                <div class="rowDiv">
                    <div class="cellDiv col1">
                        <?php echo $value['VillageName'] ? $value['VillageName'] : '--'; ?>
                        <input type="hidden" class="frm-txtbox frm-txtbox-brdr" name="village_code[]" value="<?php echo $value['VillageCode']; ?>" maxlength="45" placeholder="">
                    </div>
                    <div class="cellDiv col2">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col3">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col4">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col5">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col6">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col7">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col8">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col9">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col10">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col11">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else if ($report_type == '3') {
    ?>
    <div id="main-body" style="display: contents;">
        <div class="rowDivHeader">
            <div class="repoCellDivHeader">
                <p>ग्राम का नाम</p>
            </div>
            <div class="repoCellDivHeader">
                <p>कुल गाटों की संख्या जो क्रय की जानी है</p>
            </div>
            <div class="repoCellDivHeader">
                <p>कुल खाते जिनसे भूमि क्रय  की जानी है</p>
            </div>
            <div class="repoCellDivHeader">
                <p>कुल कृषक जिनसे बैनामें किये जाने हैं</p>
            </div>
            <div class="repoCellDivHeader">
                <p>कुल रकबा जो क्रय किया जाना है</p>
            </div>
            <div class="repoCellDivHeader">
                <p>कुल गाटे जिनका पूर्णग्रहण किया जाना है</p>
            </div>
            <div class="repoCellDivHeader">
                <p>कुल रकवा जिनका पूर्णग्रहण किया जाना है</p>
            </div>
            <div class="repoCellDivHeader">
                <p>उप जिलाधिकारी के स्तर से प्राप्त पत्र-2/र0 का0/ बीडा/ अलदरामद/2023-24 दिनांक 28.03.2024 के क्रम में प्राप्त खतौनी में ऐसे क्रय गाटों की संख्या जिनमें बीड़ा का नाम अंकित हो</p>
            </div>
            <div class="repoCellDivHeader">
                <p>उप जिलाधिकारी के स्तर से प्राप्त पत्र दिनांक 28.03.2024 के क्रम में प्राप्त खतौनी में ऐसे क्रय खातों की संख्या जिनमें बीडा का नाम अंकित हो गया है</p>
            </div>
            <div class="repoCellDivHeader">
                <p>उप जिलाधिकारी के स्तर से प्राप्त पत्र दिनांक 28.03.2024 के क्रम में प्राप्त खतौनी में ऐसे क्रय किया गया कुल रकबा जिस पर बीडा का नाम अंकित हो गया है</p>
            </div>
            <div class="repoCellDivHeader">
                <p>कुल शासकीय गाटे  जिसका पुर्नग्रहण हो गया है</p>
            </div>
            <div class="repoCellDivHeader">
                <p>कुल शासकीय रकबा जिसका पुर्नग्रहण हो गया है</p>
            </div>
            <div class="repoCellDivHeader">
                <p>कुल अधिकृत रकबा (11+13)</p>
            </div>
            <div class="repoCellDivHeader">
                <p>उक्त ग्राम में अब तक प्राप्त सहमति के आधार पर कुल रकबा</p>
            </div>
            <div class="repoCellDivHeader">
                <p>ऐसे गाटों की संख्या जहां अंश निर्धारण नहीं हुआ (गाटों की संख्या)</p>
            </div>
            <div class="repoCellDivHeader">
                <p>ऐसे गाटों की संख्या जहां अंश निर्धारण नहीं हुआ (रकबा)</p>
            </div>
        </div>
        <div id="paginate-body" style="display: contents;">
            <?php
            foreach ($villageInfo as $key => $value) {
                $cell_count = 0;
                $data = json_decode($reportInfo[$value['VillageCode']]['Report'], true);
                ?>
                <div class="rowDiv">
                    <div class="cellDiv col1">
                        <?php echo $value['VillageName'] ? $value['VillageName'] : '--'; ?>
                        <input type="hidden" class="frm-txtbox frm-txtbox-brdr" name="village_code[]" value="<?php echo $value['VillageCode']; ?>" maxlength="45" placeholder="">
                    </div>
                    <div class="cellDiv col2">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col3">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col4">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col5">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col6">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col7">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col8">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col9">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col10">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col11">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col11">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col11">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col11">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col11">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col11">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col11">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else if ($report_type == '4') {
    ?>
    <div id="main-body" style="display: contents;">
        <div class="rowDivHeader">
            <div class="repoCellDivHeader">
                <p>ग्राम का नाम</p>
            </div>
            <div class="repoCellDivHeader">
                <p>कुल भूमि जिसका क्रय किया जा चुका है</p>
            </div>
            <div class="repoCellDivHeader">
                <p>क्रय की गयी भूमि के सापेक्ष भुगतान की जाने वाली धनराशि</p>
            </div>
            <div class="repoCellDivHeader">
                <p>क्रय की भूमि में कास्तकारों की संख्या</p>
            </div>
            <div class="repoCellDivHeader">
                <p>ऐसे कास्तकारों की संख्या जिनके खाता संबंधित विवरण प्राप्त हो गये हैं</p>
            </div>
            <div class="repoCellDivHeader">
                <p>ऐसे कास्तकारों की संख्या जिन्हें भुगतान किया जा चुका है</p>
            </div>
            <div class="repoCellDivHeader">
                <p>भुगतान की गयी धनराशि</p>
            </div>
            <div class="repoCellDivHeader">
                <p>भुगतान हेतु अवशेष कास्तकारों की संख्या</p>
            </div>
            <div class="repoCellDivHeader">
                <p>भुगतान हेतु अवशेष धनराशि</p>
            </div>
        </div>
        <div id="paginate-body" style="display: contents;">
            <?php
            foreach ($villageInfo as $key => $value) {
                $cell_count = 0;
                $data = json_decode($reportInfo[$value['VillageCode']]['Report'], true);
                ?>
                <div class="rowDiv">
                    <div class="cellDiv col1">
                        <?php echo $value['VillageName'] ? $value['VillageName'] : '--'; ?>
                        <input type="hidden" class="frm-txtbox frm-txtbox-brdr" name="village_code[]" value="<?php echo $value['VillageCode']; ?>" maxlength="45" placeholder="">
                    </div>
                    <div class="cellDiv col2">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col3">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col4">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col5">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col6">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col7">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col8">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col9">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else if ($report_type == '5') {
    ?>
    <div id="main-body" style="display: contents;">
        <div class="rowDivHeader">
            <div class="repoCellDivHeader">
                <p>ग्राम का नाम</p>
            </div>
            <div class="repoCellDivHeader">
                <p>कुल गाटों की संख्या जो भूमि क्रय की जानी है</p>
            </div>
            <div class="repoCellDivHeader">
                <p>कुल खाते जिनसे भूमि क्रय की जानी है</p>
            </div>
            <div class="repoCellDivHeader">
                <p>कुल कृषक जिनसे बैनामें किये जाने हैं</p>
            </div>
            <div class="repoCellDivHeader">
                <p>कुल रकबा जो क्रय किया जाना है</p>
            </div>
            <div class="repoCellDivHeader">
                <p>कुल रकबा जिसके सापेक्ष बीडा का नाम खतौनी में अंकित हो गया है</p>
            </div>
            <div class="repoCellDivHeader">
                <p>कुल कृषक जिनसे कब्जा प्राप्त कर लिया गया है।</p>
            </div>
            <div class="repoCellDivHeader">
                <p>कुल रकबा जिस पर कब्जा प्राप्त कर लिया गया है</p>
            </div>
            <div class="repoCellDivHeader">
                <p>कुल लम्बाई जिस पर फैंसिग की कार्यवाही कर ली गयी है</p>
            </div>
            <div class="repoCellDivHeader">
                <p>बीडा के स्तर से कब्जा प्राप्त करने वाले अधिकारी कर्मचारी का नाम</p>
            </div>
            <div class="repoCellDivHeader">
                <p>तहसील के स्तर से कब्जा प्राप्त करने वाले अधिकारी कर्मचारी का नाम</p>
            </div>
            <div class="repoCellDivHeader">
                <p>साप्ताहिक रूप से एडीएम के स्तर से सूचना के आधार पर ऐसा बैनामा पूर्ण कर लिया गया है</p>
            </div>
            <div class="repoCellDivHeader">
                <p>कुल गाटा जिनकी फोटो लांगीटयूट / लैटिटयूट पर अपलोड ली गयी है</p>
            </div>
        </div>
        <div id="paginate-body" style="display: contents;">
            <?php
            foreach ($villageInfo as $key => $value) {
                $cell_count = 0;
                $data = json_decode($reportInfo[$value['VillageCode']]['Report'], true);
                ?>
                <div class="rowDiv">
                    <div class="cellDiv col1">
                        <?php echo $value['VillageName'] ? $value['VillageName'] : '--'; ?>
                        <input type="hidden" class="frm-txtbox frm-txtbox-brdr" name="village_code[]" value="<?php echo $value['VillageCode']; ?>" maxlength="45" placeholder="">
                    </div>
                    <div class="cellDiv col2">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col3">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col4">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col5">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col6">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col7">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col8">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col9">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col10">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col11">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col11">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                    <div class="cellDiv col11">
                        <input type="text" class="frm-txtbox frm-txtbox-brdr" name="<?php echo $value['VillageCode']; ?>_cell[]" maxlength="45" placeholder="" value="<?php $cell_count += 1; echo $data[$cell_count]['value'] ? $data[$cell_count]['value'] : ""; ?>">
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
}