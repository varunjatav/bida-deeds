<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/gataReport.core.php';
?>
<style type="text/css">
    .cellDivHeader p {
        font-size: 16px;
        font-weight: 600;
    }
</style>
<div class="rowDivHeader" style="background-color: #ededed;">
    <div class="cellDivHeader">
        <p></p>
    </div>
    <div class="cellDivHeader">
        <p style="color: #000;">क्या गाटे का अधिग्रहण किया जा रहा है ?</p>
    </div>
    <div class="cellDivHeader">
        <p style="color: #000;"><?php echo $answer_0; ?></p>
    </div>
</div>

<br>

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
    <div class="cellDivHeader">
        <p>विवरण</p>
    </div>
</div>
<div id="main-body" style="display: contents; font-size: 16px;">
    <div id="paginate-body" style="display: contents;">
        <div class="rowDiv <?php echo $answer_color_1; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                क्या गाटा 1359 फसली खतौनी में उपलब्ध है ?
            </div>
            <div class="cellDiv col3">
                <?php echo $answer_1; ?>
            </div>
            <div class="cellDiv col4">
                <?php echo $answer_info_1; ?>
            </div>
        </div>
        <div class="rowDiv <?php echo $answer_color_2; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                क्या गाटा सीएच 41-45 में उपलब्ध है ?
            </div>
            <div class="cellDiv col3">
                <?php echo $answer_2; ?>
            </div>
            <div class="cellDiv col4">
                <?php echo $answer_info_2; ?>
            </div>
        </div>
        <!--<div class="rowDiv">
            <div class="cellDiv col1">
        <?php //echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                गाटे की 1359 फसली खसरे में किस्म क्या हैं?
            </div>
            <div class="cellDiv col3">
        <?php //echo $answer_3; ?>
            </div>
            <div class="cellDiv col4">

            </div>
        </div>
        <div class="rowDiv">
            <div class="cellDiv col1">
        <?php //echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                क्या गाटे पर 1359 फसली खसरे में काश्तकार दर्ज है ?
            </div>
            <div class="cellDiv col3">
        <?php //echo $answer_4; ?>
            </div>
            <div class="cellDiv col4">

            </div>
        </div>
        <div class="rowDiv">
            <div class="cellDiv col1">
        <?php //echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                क्या एग्री स्टेक के अनुसार मौके पर फसल हैं ?
            </div>
            <div class="cellDiv col3">
        <?php //echo $answer_5; ?>
            </div>
            <div class="cellDiv col4">

            </div>
        </div>-->
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
    <div class="cellDivHeader">
        <p>विवरण</p>
    </div>
</div>
<div id="main-body" style="display: contents; font-size: 16px;">
    <div id="paginate-body" style="display: contents;">
        <div class="rowDiv <?php echo $answer_color_6; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                क्या गाटे की वर्तमान खतौनी 1-क है और 1359 फसली खसरे के अनुसार सुरक्षित श्रेणी में है ?
            </div>
            <div class="cellDiv col3">
                <?php echo $answer_6; ?>
            </div>
            <div class="cellDiv col4">
                <?php echo $answer_info_6; ?>
            </div>
        </div>
        <div class="rowDiv <?php echo $answer_color_7; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                क्या गाटे की वर्तमान श्रेणी सीएच 41-45 के समान हैं ?
            </div>
            <div class="cellDiv col3">
                <?php echo $answer_7; ?>
            </div>
            <div class="cellDiv col4">
                <?php echo $answer_info_7; ?>
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
    <div class="cellDivHeader">
        <p>विवरण</p>
    </div>
</div>
<div id="main-body" style="display: contents; font-size: 16px;">
    <div id="paginate-body" style="display: contents;">
        <div class="rowDiv <?php echo $answer_color_8; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                गाटे का वर्तमान रकबा 1359 फसली खतौनी के रकबे के बराबर है या नहीं ?
            </div>
            <div class="cellDiv col3">
                <?php echo $answer_8; ?>
            </div>
            <div class="cellDiv col4">
                <?php echo $answer_info_8; ?>
            </div>
        </div>
        <div class="rowDiv <?php echo $answer_color_10; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                गाटे का वर्तमान रकबा 41-45 के रकबे के बराबर है या नहीं ?
            </div>
            <div class="cellDiv col3">
                <?php echo $answer_10; ?>
            </div>
            <div class="cellDiv col4">
                <?php echo $answer_info_10; ?>
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
    <div class="cellDivHeader">
        <p>विवरण</p>
    </div>
</div>
<div id="main-body" style="display: contents; font-size: 16px;">
    <div id="paginate-body" style="display: contents;">
        <div class="rowDiv <?php echo $answer_color_12; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                गाटे की कृषि दर क्या निर्धारित की गयी हैं ?
            </div>
            <div class="cellDiv col3">
                <?php echo $answer_12; ?>
            </div>
            <div class="cellDiv col4">

            </div>
        </div>
        <div class="rowDiv <?php echo $answer_color_13; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                गाटे की आबादी दर क्या निर्धारित की गयी हैं ?
            </div>
            <div class="cellDiv col3">
                <?php echo $answer_13; ?>
            </div>
            <div class="cellDiv col4">

            </div>
        </div>
        <div class="rowDiv <?php echo $answer_color_14; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                गाटे की सड़क किनारे की दर क्या निर्धारित की गयी हैं ?
            </div>
            <div class="cellDiv col3">
                <?php echo $answer_14; ?>
            </div>
            <div class="cellDiv col4">

            </div>
        </div>
        <div class="rowDiv <?php echo $answer_color_15; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                क्या गाटे पर एक से अधिक प्रकार की दर निर्धारित की गयी है ?
            </div>
            <div class="cellDiv col3">
                <?php echo $answer_15; ?>
            </div>
            <div class="cellDiv col4">

            </div>
        </div>
        <div class="rowDiv <?php echo $answer_color_16; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                क्या पिछले एक साल की मार्केट रेट गाटे की सर्किल रेट से अधिक है ?
            </div>
            <div class="cellDiv col3">
                <?php echo $answer_16; ?>
            </div>
            <div class="cellDiv col4">
                <?php echo $answer_info_16; ?>
            </div>
        </div>
        <div class="rowDiv <?php echo $answer_color_17; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                क्या पिछले दो साल की मार्केट रेट गाटे की सर्किल रेट से अधिक है ?
            </div>
            <div class="cellDiv col3">
                <?php echo $answer_17; ?>
            </div>
            <div class="cellDiv col4">
                <?php echo $answer_info_17; ?>
            </div>
        </div>
        <div class="rowDiv <?php echo $answer_color_18; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                क्या गाटे का भूमि मूल्य सर्किल के 4 गुने से अधिक हैं ?
            </div>
            <div class="cellDiv col3">
                <?php echo $answer_18; ?>
            </div>
            <div class="cellDiv col4">
                <?php echo $answer_info_18; ?>
            </div>
        </div>
        <div class="rowDiv <?php echo $answer_color_19; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                क्या परिसंपत्तियों का मूल्य कुल भूमि के मूल्य के 10 प्रतिशत से अधिक है ?
            </div>
            <div class="cellDiv col3">
                <?php echo $answer_19; ?>
            </div>
            <div class="cellDiv col4">
                <?php echo $answer_info_19; ?>
            </div>
        </div>
        <div class="rowDiv <?php echo $answer_color_20; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                क्या परिसंपत्तियों का मूल्य 10 लाख रुपये से अधिक है ?
            </div>
            <div class="cellDiv col3">
                <?php echo $answer_20; ?>
            </div>
            <div class="cellDiv col4">
                <?php echo $answer_info_20; ?>
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
    <div class="cellDivHeader">
        <p>विवरण</p>
    </div>
</div>
<div id="main-body" style="display: contents; font-size: 16px;">
    <div id="paginate-body" style="display: contents;">
        <div class="rowDiv <?php echo $answer_color_21; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                क्या गाटा जिलाधिकारी द्वारा प्रेस विज्ञप्ति के पूर्व रोका गया है ?
            </div>
            <div class="cellDiv col3">
                <?php echo $answer_21; ?>
            </div>
            <div class="cellDiv col4">
                <?php echo $answer_info_21; ?>
            </div>
        </div>
        <div class="rowDiv <?php echo $answer_color_22; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                क्या गाटा बीडा द्वारा प्रेस विज्ञप्ति से पहले रोका गया है ?
            </div>
            <div class="cellDiv col3">
                <?php echo $answer_22; ?>
            </div>
            <div class="cellDiv col4">
                <?php echo $answer_info_22; ?>
            </div>
        </div>
        <div class="rowDiv <?php echo $answer_color_23; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                क्या गाटा दर निर्धारण समिति द्वारा रोका गया है ?
            </div>
            <div class="cellDiv col3">
                <?php echo $answer_23; ?>
            </div>
            <div class="cellDiv col4">
                <?php echo $answer_info_23; ?>
            </div>
        </div>
        <div class="rowDiv <?php echo $answer_color_24; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                क्या गाटे का बैनामा बीडा द्वारा दर निर्धारण उपरान्त रोका गया है ?
            </div>
            <div class="cellDiv col3">
                <?php echo $answer_24; ?>
            </div>
            <div class="cellDiv col4">
                <?php echo $answer_info_24; ?>
            </div>
        </div>
        <div class="rowDiv <?php echo $answer_color_25; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                क्या गाटा नक्शे पर है, परन्तु मौके पर नहीं है?
            </div>
            <div class="cellDiv col3">
                <?php echo $answer_25; ?>
            </div>
            <div class="cellDiv col4">
                <?php echo $answer_info_25; ?>
            </div>
        </div>
        <div class="rowDiv <?php echo $answer_color_26; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                क्या मानचित्र/मौके पर नहर है एवं खतौनी में काश्तकार हैं ?
            </div>
            <div class="cellDiv col3">
                <?php echo $answer_26; ?>
            </div>
            <div class="cellDiv col4">
                <?php echo $answer_info_26; ?>
            </div>
        </div>
        <div class="rowDiv <?php echo $answer_color_27; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                क्या मानचित्र/मौके पर सड़क है एवं खतौनी में काश्तकार हैं ?
            </div>
            <div class="cellDiv col3">
                <?php echo $answer_27; ?>
            </div>
            <div class="cellDiv col4">
                <?php echo $answer_info_27; ?>
            </div>
        </div>
    </div>
</div>

<div class="rowDivHeader">
    <div class="cellDivHeader">
        <p>क्रo सo</p>
    </div>
    <div class="cellDivHeader">
        <p>अन्य बिन्दु</p>
    </div>
    <div class="cellDivHeader">
        <p>रिजल्ट</p>
    </div>
    <div class="cellDivHeader">
        <p>विवरण</p>
    </div>
</div>
<div id="main-body" style="display: contents; font-size: 16px;">
    <div id="paginate-body" style="display: contents;">
        <div class="rowDiv">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                गाटे पर कुल वृक्ष कितने है ?
            </div>
            <div class="cellDiv col3">
                <?php echo $answer_28; ?>
            </div>
            <div class="cellDiv col4">

            </div>
        </div>
        <div class="rowDiv">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                गाटा पर परिसम्पत्तियाँ क्या-क्या है?
            </div>
            <div class="cellDiv col3">
                <?php if ($answer_29 == '--') { ?>
                    <?php echo $answer_29_short; ?>
                <?php } else { ?>
                    <span class="tool" data-tip="<?php echo $answer_29; ?>"><?php echo $answer_29_short; ?></span>
                <?php } ?>
            </div>
            <div class="cellDiv col4">

            </div>
        </div>
        <div class="rowDiv">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                क्या एग्री स्टेक के अनुसार मौके पर फसल हैं ?
            </div>
            <div class="cellDiv col3">
                <?php echo $answer_5; ?>
            </div>
            <div class="cellDiv col4">

            </div>
        </div>
        <div class="rowDiv <?php echo $answer_color_30; ?>">
            <div class="cellDiv col1">
                <?php echo $count++; ?>
            </div>
            <div class="cellDiv col2">
                क्या भूमि बंधक है ?
            </div>
            <div class="cellDiv col3">
                <?php echo $answer_30; ?>
            </div>
            <div class="cellDiv col4">

            </div>
        </div>
    </div>
</div>