<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/consolidateVillageReport.core.php';
?>
<style type="text/css">
    .cellDivHeader p {
        font-size: 16px;
        font-weight: 600;
    }
</style>
<div class="rowDivHeader" style="">
    <div class="cellDivHeader">
        <p>क्रo सo</p>
    </div>
    <div class="cellDivHeader">
        <p>गाटे के परीक्षण का बिंदु/सवाल</p>
    </div>
    <div class="cellDivHeader">
        <p>रिजल्ट</p>
    </div>
</div>
<div id="main-body" style="display: contents; font-size: 16px;">
    <div id="paginate-body" style="display: contents;">
        <div class="rowDiv <?php echo $answer_color_1; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                कितने गाटे 1359 फसली खतौनी में उपलब्ध नहीं है ?
            </div>
            <div class="cellDiv col3">
                <a style="cursor:pointer;" class="view_report_data" id="report_data_1"><?php echo $answer_1; ?></a>
            </div>
        </div>
        <div class="rowDiv <?php echo $answer_color_2; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                कितने गाटे सीएच 41-45 में उपलब्ध नहीं है ?
            </div>
            <div class="cellDiv col3">
                <a style="cursor:pointer;" class="view_report_data" id="report_data_2"><?php echo $answer_2; ?></a>
            </div>
        </div>
    </div>
</div>

<div class="rowDivHeader">
    <div class="cellDivHeader">
        <p>क्रo सo</p>
    </div>
    <div class="cellDivHeader">
        <p>गाटे की श्रेणी के संबंध में</p>
    </div>
    <div class="cellDivHeader">
        <p>रिजल्ट</p>
    </div>
</div>
<div id="main-body" style="display: contents; font-size: 16px;">
    <div id="paginate-body" style="display: contents;">
        <div class="rowDiv <?php echo $answer_color_6; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                ऐसे गाटो की संख्या जो 1359 फसली खसरे के अनुसर सुरक्षित श्रेणि में है
            </div>
            <div class="cellDiv col3">
                <a style="cursor:pointer;" class="view_report_data" id="report_data_3"><?php echo $answer_6; ?></a>
            </div>
        </div>
        <div class="rowDiv <?php echo $answer_color_7; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                ऐसे गाटो की संख्या जिनकी वर्तमान श्रेनी सीएच 41-45 के समान नहीं है
            </div>
            <div class="cellDiv col3">
                <a style="cursor:pointer;" class="view_report_data" id="report_data_4"><?php echo $answer_7; ?></a>
            </div>
        </div>
    </div>
</div>

<div class="rowDivHeader">
    <div class="cellDivHeader">
        <p>क्रo सo</p>
    </div>
    <div class="cellDivHeader">
        <p>गाटे की रकबे के संबंध में</p>
    </div>
    <div class="cellDivHeader">
        <p>रिजल्ट</p>
    </div>
</div>
<div id="main-body" style="display: contents; font-size: 16px;">
    <div id="paginate-body" style="display: contents;">
        <div class="rowDiv <?php echo $answer_color_8; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                ऐसे गाटो की संख्या जिनका वर्तमान रकबा 1359 फसली के रकबे के बराबर नहीं है
            </div>
            <div class="cellDiv col3">
                <a style="cursor:pointer;" class="view_report_data" id="report_data_5"><?php echo $answer_8; ?></a>
            </div>
        </div>
        <div class="rowDiv <?php echo $answer_color_10; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                ऐसे गाटो की संख्या जिनका वर्तमान रकबा सीएच 41-45 के रकबे के बराबर नहीं है
            </div>
            <div class="cellDiv col3">
                <a style="cursor:pointer;" class="view_report_data" id="report_data_6"><?php echo $answer_10; ?></a>
            </div>
        </div>
    </div>
</div>

<div class="rowDivHeader">
    <div class="cellDivHeader">
        <p>क्रo सo</p>
    </div>
    <div class="cellDivHeader">
        <p>गाटे के दर निर्धारण के सम्बन्ध में</p>
    </div>
    <div class="cellDivHeader">
        <p>रिजल्ट</p>
    </div>
</div>
<div id="main-body" style="display: contents; font-size: 16px;">
    <div id="paginate-body" style="display: contents;">
        <div class="rowDiv">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                ऐसे गाटो की संख्या जहां कृषि दर निर्धारित नहीं की गई है
            </div>
            <div class="cellDiv col3">
                <a style="cursor:pointer;" class="view_report_data" id="report_data_7"><?php echo $answer_12; ?></a>
            </div>
        </div>
        <div class="rowDiv">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                ऐसे गाटो की संख्या जहां आबादी दर निर्धारित नहीं की गई है
            </div>
            <div class="cellDiv col3">
                <a style="cursor:pointer;" class="view_report_data" id="report_data_8"><?php echo $answer_13; ?></a>
            </div>
        </div>
        <div class="rowDiv">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                ऐसे गाटो की संख्या जहां सड़क किनारे की दर निर्धारित नहीं की गई है
            </div>
            <div class="cellDiv col3">
                <a style="cursor:pointer;" class="view_report_data" id="report_data_9"><?php echo $answer_14; ?></a>
            </div>
        </div>
        <div class="rowDiv">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                ऐसे गाटो की संख्या जहां एक से अधिक प्रकार की दर निर्धारित की गई है
            </div>
            <div class="cellDiv col3">
                <a style="cursor:pointer;" class="view_report_data" id="report_data_10"><?php echo $answer_15; ?></a>
            </div>
        </div>
        <div class="rowDiv">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                ऐसे गाटो की संख्या जहां पिछले एक साल की मार्केट रेट गाटे की सर्कल रेट अधिक है
            </div>
            <div class="cellDiv col3">
                <a style="cursor:pointer;" class="view_report_data" id="report_data_11"><?php echo $answer_16; ?></a>
            </div>
        </div>
        <div class="rowDiv">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                ऐसे गाटो की संख्या जहां पिछले दो साल में सर्किल रेट अधिक है
            </div>
            <div class="cellDiv col3">
                <a style="cursor:pointer;" class="view_report_data" id="report_data_12"><?php echo $answer_17; ?></a>
            </div>
        </div>
        <div class="rowDiv">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                ऐसे गाटो की संख्या जहां गाटे का भूमि मूल्य सर्किल रेट के चार गुने से अधिक है
            </div>
            <div class="cellDiv col3">
                <a style="cursor:pointer;" class="view_report_data" id="report_data_13"><?php echo $answer_18; ?></a>
            </div>
        </div>
        <div class="rowDiv">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                ऐसे गाटो की संख्या जहां परिसम्पत्तियों का मुल्य कुल भूमि के मुल्य के 10 प्रतिषत से अधिक है
            </div>
            <div class="cellDiv col3">
                <a style="cursor:pointer;" class="view_report_data" id="report_data_14"><?php echo $answer_19; ?></a>
            </div>
        </div>
        <div class="rowDiv">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                ऐसे गाटो की संख्या जहां परिसम्पत्तियों का मूल्य 10 लाख रूपये से अधिक है
            </div>
            <div class="cellDiv col3">
                <a style="cursor:pointer;" class="view_report_data" id="report_data_15"><?php echo $answer_20; ?></a>
            </div>
        </div>
    </div>
</div>

<div class="rowDivHeader">
    <div class="cellDivHeader">
        <p>क्रo सo</p>
    </div>
    <div class="cellDivHeader">
        <p>गाटे के होल्ड करने के सम्बन्ध में</p>
    </div>
    <div class="cellDivHeader">
        <p>रिजल्ट</p>
    </div>
</div>
<div id="main-body" style="display: contents; font-size: 16px;">
    <div id="paginate-body" style="display: contents;">
        <div class="rowDiv">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                ऐसे गाटो की संख्या जिन्हे जिलाधिकरी द्वार विज्ञपति से पहले रोका गया है
            </div>
            <div class="cellDiv col3">
                <a style="cursor:pointer;" class="view_report_data" id="report_data_16"><?php echo $answer_21; ?></a>
            </div>
        </div>
        <div class="rowDiv">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                ऐसे गाटो की संख्या जिन्हे बीड़ा द्वार प्रेस विज्ञपति से पूर्व रोका गया है
            </div>
            <div class="cellDiv col3">
                <a style="cursor:pointer;" class="view_report_data" id="report_data_17"><?php echo $answer_22; ?></a>
            </div>
        </div>
        <div class="rowDiv">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                ऐसे गाटो की संख्या जिन्हे दर निर्धारण समिति द्वारा रोका गया है
            </div>
            <div class="cellDiv col3">
                <a style="cursor:pointer;" class="view_report_data" id="report_data_18"><?php echo $answer_23; ?></a>
            </div>
        </div>
        <div class="rowDiv">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                ऐसे गाटो की संख्या जिनका बैनामा बीड़ा द्वार दर निर्धारण के उपरान्त रोका गया है
            </div>
            <div class="cellDiv col3">
                <a style="cursor:pointer;" class="view_report_data" id="report_data_19"><?php echo $answer_24; ?></a>
            </div>
        </div>
        <div class="rowDiv">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                ऐसे गाटो की संख्या जो नक्शे पर है परंतु मौके पर नहीं है
            </div>
            <div class="cellDiv col3">
                <a style="cursor:pointer;" class="view_report_data" id="report_data_20"><?php echo $answer_25; ?></a>
            </div>
        </div>
        <div class="rowDiv">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                ऐसे गाटो की संख्या जो मानचित्र/मौके पर नहर है परंतु खतौनी में काश्तकार के नाम दर्ज है
            </div>
            <div class="cellDiv col3">
                <a style="cursor:pointer;" class="view_report_data" id="report_data_21"><?php echo $answer_26; ?></a>
            </div>
        </div>
        <div class="rowDiv">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                ऐसे गाटो की संख्या जो मानचित्र/मौके पर सड़क है परंतु खतौनी में काश्तकार के नाम दर्ज हैं
            </div>
            <div class="cellDiv col3">
                <a style="cursor:pointer;" class="view_report_data" id="report_data_22"><?php echo $answer_27; ?></a>
            </div>
        </div>
    </div>
</div>