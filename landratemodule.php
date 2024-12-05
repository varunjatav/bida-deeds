<?php
include_once 'config.php';
include_once 'includes/checkSession.php';
include_once 'includes/get_time_zone.php';
include_once 'dbcon/db_connect.php';
include_once 'functions/common.function.php';
include_once 'core/permission.core.php';
//include_once 'core/parisampattiModule.core.php';
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

    <style>
        .p-heading{
            padding: 10px 20px;
            font-size: 18px;
            font-weight: 600;
        }
    </style>

</head>

<body>
    <?php include "includes/header.php"; ?>
    <div id="appendFilter"></div>
    <div class="wrapper">
        <div class="col-wrapper">
            <?php include "includes/sidebarmenu.php"; ?>
            <div class="full-column db-cont-wrap right dev_wrap" style="border:none;">
                <div class="column-head">
                    <div class="left pageback" style="display:flex;">
                        <a style="cursor: pointer;" onclick="history.go(-1)">
                            <img src="img/back.svg" alt="" width="18px">
                        </a>
                        <div class="col-pagename left">Land Rate Updation Module
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                </div>

                <div class="expDiv" style="margin-top: 20px;">
                    <div class="hero-box" style="margin-top: 20px;">
                        <div class="left-box" style="width: 99.5%; border: none;">
                            <div class="main-card">
                                <p class="p-heading">Without Development cost</p>
                                <ul class="cards">
                                    <li class="cards_item posrel" id="data_block_1">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo 'Rate of current purchased area (Total amount/Purchased area)'; ?></span><span class="view_data card_text" id="dashboard_data_1"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_2">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo 'Rate of Dar nirdharit area excluding resumpted area. (Total Dar nirdharit Amount/Total dar nirdharit area)'; ?></span><span class="view_data card_text" id="dashboard_data_2"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_3">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content">
                                                <p><span class="text-name"><?php echo 'Rate of Dar nirdharit area including resumpted area. (Total Dar nirdharit Amount/(Total dar nirdharit area+resumpted area)'; ?></span><span class="view_data card_text" id="dashboard_data_3"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <p class="p-heading">With Development cost</p>
                                <ul class="cards">
                                    <li class="cards_item posrel" id="data_block_4">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo 'Rate of current purchased area (Total amount/Purchased area)'; ?></span><span class="view_data card_text" id="dashboard_data_4"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_5">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo 'Rate of Dar nirdharit area excluding resumpted area. (Total Dar nirdharit Amount/Total dar nirdharit area)'; ?></span><span class="view_data card_text" id="dashboard_data_5"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_6">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content">
                                                <p><span class="text-name"><?php echo 'Rate of Dar nirdharit area including resumpted area. (Total Dar nirdharit Amount/(Total dar nirdharit area+resumpted area)'; ?></span><span class="view_data card_text" id="dashboard_data_6"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <p class="p-heading">With Administrative cost</p>
                                <ul class="cards">
                                    <li class="cards_item posrel" id="data_block_7">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo 'Rate of current purchased area (Total amount/Purchased area)'; ?></span><span class="view_data card_text" id="dashboard_data_7"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_8">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content posrel">
                                                <div class="posabsolut act_btn_ovrly"></div>
                                                <p><span class="text-name"><?php echo 'Rate of Dar nirdharit area excluding resumpted area. (Total Dar nirdharit Amount/Total dar nirdharit area)'; ?></span><span class="view_data card_text" id="dashboard_data_8"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cards_item posrel" id="data_block_9">
                                        <div class="block_loader"></div>
                                        <div class="card">
                                            <div class="card_content">
                                                <p><span class="text-name"><?php echo 'Rate of Dar nirdharit area including resumpted area. (Total Dar nirdharit Amount/(Total dar nirdharit area+resumpted area)'; ?></span><span class="view_data card_text" id="dashboard_data_9"></span></p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="name_order" value="asc">
    <div class="clr"></div>
    <?php include "includes/footer.php"; ?>
</div>
</div>
<input type="hidden" id="village_codes">
<div id="notify"></div>
<div id="saveFilter" class="hide"></div>
</body>
<script src="scripts/jquery-ui.min.js"></script>
<script src="scripts/jquery.confirm.js"></script>
<script src="scripts/common.js"></script>
<script src="scripts/landupdatemodule.js"></script>
<script>
                            $(document).ready(function () {
                                $('.full-column').on('click', '.paginate', function () {
                                    loadMoreParisampattiModule(parseInt($(this).text()) - 1);
                                });
                                $('.full-column').on('click', '.paginate_next', function () {
                                    loadMoreParisampattiModule(parseInt($('.current').attr('id')));
                                });
                                $('.full-column').on('click', '.paginate_prev', function () {
                                    loadMoreParisampattiModule(parseInt($('.current').attr('id')) - 2);
                                });
                                $('.full-column').on('click', '.paginate_last', function () {
                                    loadMoreParisampattiModule(parseInt($('.paginate:last').text()) - 1);
                                });
                            });

                            const slider = document.querySelector('.scrl-tblwrap');
                            let mouseDown = false;
                            let startX, scrollLeft;

                            let startDragging = function (e) {
                                mouseDown = true;
                                startX = e.pageX - slider.offsetLeft;
                                scrollLeft = slider.scrollLeft;
                            };
                            let stopDragging = function (event) {
                                mouseDown = false;
                            };

                            slider.addEventListener('mousemove', (e) => {
                                e.preventDefault();
                                if (!mouseDown) {
                                    return;
                                }
                                const x = e.pageX - slider.offsetLeft;
                                const scroll = x - startX;
                                slider.scrollLeft = scrollLeft - scroll;
                            });

                            slider.addEventListener('mousedown', startDragging, false);
                            slider.addEventListener('mouseup', stopDragging, false);
                            slider.addEventListener('mouseleave', stopDragging, false);
</script>

</html>