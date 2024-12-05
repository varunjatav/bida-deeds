<?php
include_once 'config.php';
include_once 'includes/checkSession.php';
include_once 'includes/get_time_zone.php';
include_once 'dbcon/db_connect.php';
include_once 'functions/common.function.php';
include_once 'core/permission.core.php';
include_once 'core/village.core.php';
?>
<!doctype html>

<head>
    <meta charset="UTF-8">
    <title>BIDA LAMS</title>
    <link href="css/stylus.css" rel="stylesheet" type="text/css">
    <link href="css/common_master.css" rel="stylesheet" type="text/css">
    <link href="css/font.css" rel="stylesheet" type="text/css">
    <link href="css/jquery-ui.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/style.css">
    <script src="scripts/jquery.min.js"></script>
    <script>
        document.write('<style type="text/css">body{display:none}</style>');
        jQuery(function (a) {
            a("body").css("display", "block");
        });
    </script>
    <style type="text/css">
        .map_iframe{
            height: 100vh;
            width: 100vw;
            border: 0;
        }
    </style>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <div id="appendFilter"></div>
    <div class="wrapper">
        <div class="col-wrapper">
            <?php include "includes/sidebarmenu.php"; ?>
            <div class="full-column db-cont-wrap right">
                <div class="column-head">
                    <div class="left pageback" style="display:flex;">
                        <a style="cursor: pointer;" onclick="history.go(-1)">
                            <img src="img/back.svg" alt="" width="18px">
                        </a>
                        <div class="col-pagename left">Bida Map
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                </div>

                <div class="clr"></div>
                <iframe src="https://qgiscloud.com/ajeetyadav93/Cloud_Map/" class="map_iframe"></iframe>
            </div>
            <div class="clr"></div>
            <?php include "includes/footer.php"; ?>
        </div>
    </div>
    <div id="notify"></div>
</body>
<script src="scripts/jquery-ui.min.js"></script>
<script src="scripts/jquery.confirm.js"></script>
<script src="scripts/common.js"></script>
<script src="scripts/bank.js"></script>
</html>