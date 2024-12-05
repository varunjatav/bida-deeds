<?php
include_once 'config.php';
include_once 'includes/checkSession.php';
include_once 'includes/get_time_zone.php';
include_once 'dbcon/db_connect.php';
include_once 'functions/common.function.php';
include_once 'core/permission.core.php';
//include_once 'core/misDashboard.core.php';
header('location: landdatalist');
exit();
?>
<!doctype html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>BIDA LAMS</title>
        <link href="css/stylus.css" rel="stylesheet" type="text/css" />
        <link href="css/common_master.css" rel="stylesheet" type="text/css" />
        <link href="css/font.css" rel="stylesheet" type="text/css" />
        <link href="css/jquery-ui.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="css/style.css">
        <script src="scripts/jquery.min.js"></script>
        <script>
            document.write('<style type="text/css">body{display:none}</style>');
            jQuery(function (a) {
                a("body").css("display", "block")
            });
        </script>
    </head>

    <body>
        <?php include "includes/header.php"; ?>

        <div class="col-wrapper dev_wrap">
            <?php include "includes/sidebarmenu.php"; ?>
            <div class="full-column db-cont-wrap right">
                <div class="column-head">
                    <div class="left pageback" style="display:flex;">
                        <a style="cursor: pointer;" onclick="history.go(-1)">
                            <img src="img/back.svg" alt="" width="18px">
                        </a>
                        <div class="col-pagename left">OSD MIS Module
                        </div>
                        <div class="clr"></div>
                    </div>
                    <?php if ($user_type == '2') { ?>
                        <div class="tbl-data right posrel" title="Give report feedback">
                            <div class="posabsolut act_btn_ovrly"></div>
                            <a style="cursor:pointer;" class="report_feedback" id="5" report_type="mis_dashboard">
                                <img src="img/click_action.svg" height="25px">
                            </a>
                        </div>
                    <?php } ?>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
                <div class="filter-div">
                    <div style="" class="left">
                        <div class="tabl3">
                            <a href="misdashboard" class="active">
                                <p>MIS Dashboard</p>
                            </a>
                            <a href="misreport">
                                <p>MIS Report</p>
                            </a>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="chb-db">
                    <div class="left untdtls">
                        <a>कुल गाटा, जो क्रय किये जाने हैं</a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block1; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>

                    <div class="left untdtls">
                        <a>कुल कृषक जिनसे भूमि क्रय की जानी है</a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block2; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="left untdtls">
                        <a>कुल रकबा जो क्रय किया जाना है</a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block3; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="left untdtls">
                        <a>कुल गाटे, जिन पर सहमति प्राप्त की गयी</a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block4; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="left untdtls">
                        <a>कुल रकवा, जिस पर सहमति प्राप्त की गयी</a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block5; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="left untdtls hide">
                        <a>कुल कृषक, जिनसे सहमति प्राप्त की गयी</a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block6; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="left untdtls">
                        <a>कितने गाटों में अंश निर्धारण किया जाना है</a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block7; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="left untdtls">
                        <a>कितने कृषकों का अंश निर्धारण किया जाना है</a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block8; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="left untdtls">
                        <a>क्रय किये गाटों की संख्या जहाँ बीडा का नाम अंकित हो गया है</a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block9; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="left untdtls">
                        <a>क्रय किये गये खातों की संख्या जहाँ बीडा का नाम अंकित हो गया है</a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block10; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="left untdtls">
                        <a>क्रय किया गया रकवा जिस पर बीडा का नाम अंकित हो गया है</a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block11; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="left untdtls">
                        <a>बैनामा हेतु अवशेष रकवा</a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block12; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="left untdtls">
                        <a>कूल गाटे, जिनका पुनर्ग्रहण किया जाना है</a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block13; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="left untdtls">
                        <a>कुल रकवा, जिसका पुनर्ग्रहण किया जाना है</a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block14; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="left untdtls">
                        <a>ऐसे गाटों की संख्या जहाँ  पुनर्ग्रहण होने के पश्चात बीडा का नाम दर्ज हो  गया है</a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block15; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="left untdtls">
                        <a>पुनर्ग्रहण हेतु अवशेष रकवा</a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block16; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="left untdtls">
                        <a>जिलाधिकारी कार्यालय से प्राप्त बैनामों की संख्या</a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block17; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="left untdtls">
                        <a>विशेष कार्याधिकारी द्वारा वापस किये गये त्रुटिपूर्ण बैनामों की संख्या</a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block18; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="left untdtls">
                        <a>विशेष कार्याधिकारी द्वारा जॉच में सही / ग्रहण योग्य पाये गये बैनामों की संख्या</a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block19; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="left untdtls">
                        <a>ग्रहण योग्य पाये गये बैनामों में कृषकों की संख्या</a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block20; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="left untdtls">
                        <a>ऐसे कास्तकारों की संख्या जिनके खाता संबंधित विवरण प्राप्त हो गये हैं</a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block21; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="left untdtls">
                        <a>ऐसे कास्तकारों की संख्या जिन्हे भुगतान किया जा चुका है </a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block22; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="left untdtls">
                        <a>भुगतान की गयी धनराशि</a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block23; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="left untdtls">
                        <a>भुगतान हेतु अवशेष कास्तकारों की संख्या</a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block24; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="left untdtls">
                        <a>भुगतान हेतु अवशेष धनराशि</a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block25; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="left untdtls">
                        <a>कुल कृषक जिनसे कब्जा प्राप्त कर लिया गया है</a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block26; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="left untdtls">
                        <a>कुल रकवा जिस पर कब्जा प्राप्त कर लिया गया है</a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block27; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="left untdtls">
                        <a>कब्जा हेतु अवशेष रकवा</a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block28; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="left untdtls">
                        <a>कुल लम्बाई जिस पर फेंसिंग कार्य प्रारम्भ हो गया है</a>
                        <div class="unitnmbrs">
                            <span class="left"><?php echo $block29; ?></span>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="clr"></div>
                </div>
            </div>
            <div class="clr"></div>
            <div id="notify"></div>
        </div>
    </body>
    <script src="scripts/common.js"></script>
    <script src="scripts/dashboard.js"></script>
</html>