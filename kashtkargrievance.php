<?php
include_once 'config.php';
include_once 'includes/kashtCheckSession.php';
include_once 'includes/get_time_zone.php';
include_once 'dbcon/db_connect.php';
include_once 'functions/common.function.php';
include_once 'core/kashtkarGrievance.core.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
        <title>Grievance</title>
        <meta name="description" content="">
        <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico">
        <link href="css/font.css" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css">
        <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css">
        <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css">
        <link rel="stylesheet" href="assets/css/demo.css">
        <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css">
        <link rel="stylesheet" href="assets/vendor/css/pages/page-auth.css">
        <script src="assets/vendor/libs/jquery/jquery.js"></script>
    </head>

    <body>
        <div id="popup" style="position: fixed; z-index: 1090; background-color: #fff; overflow: auto;height: 100vh;"></div>

        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                <!-- Menu -->

                <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme" data-bg-class="bg-menu-theme">
                    <div class="app-brand demo">
                        <a href="kashtkargrievance" class="app-brand-link">
                            <span class="app-brand-logo demo">
                            </span>
                            <span class="app-brand-text demo menu-text fw-bolder ms-2">काश्तकार पोर्टल</span>
                        </a>
                        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
                            <i class="bx bx-chevron-left bx-sm align-middle"></i>
                        </a>
                    </div>
                    <div class="menu-inner-shadow"></div>
                    <?php include_once 'includes/kasht_sidebar.php'; ?>
                </aside>
                <!-- / Menu -->

                <!-- Layout container -->
                <div class="layout-page">
                    <?php include_once 'includes/kashtheader.php'; ?>
                    <!-- Content wrapper -->
                    <div class="content-wrapper">
                        <!-- Content -->

                        <div class="container-xxl flex-grow-1 container-p-y">
                            <div class="card">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0" style="font-weight: 600;">दर्ज की गयी शिकायतें</h5>
                                    <small class="text-muted float-end">
                                        <a href="addgrievance" class="d-flex align-items-center justify-content-end add_gata_more">
                                            <i class="bx bx-plus-circle scaleX-n1-rtl bx-sm"></i>&nbsp;<span style="font-size: 1em; font-weight: 600;">नयी शिकायत दर्ज करें</span>
                                        </a>
                                    </small>
                                </div>
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr class="text-nowrap">
                                                <th style="font-size: 1.1em;">#</th>
                                                <th style="font-size: 1.1em;">गाँव</th>
                                                <th style="font-size: 1.1em;">गाटा</th>
                                                <th style="font-size: 1.1em;">खाता</th>
                                                <th style="font-size: 1.1em;">शिकायत</th>
                                                <th style="font-size: 1.1em;">दिनांक</th>
                                                <th style="font-size: 1.1em;">स्थिति</th>
                                                <th style="font-size: 1.1em;">रिपोर्ट</th>
                                                <th style="font-size: 1.1em;">टिप्पणी</th>
                                                <th style="font-size: 1.1em;">संपर्क करें</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($grievInfo as $key => $value) {
                                                $status = 'निस्तारण नहीं हुआ';
                                                $attachment = '';
                                                $color = '';
                                                if ($value['Status'] == '1') {
                                                    $status = 'निस्तारण हो चुका';
                                                    $color = 'color:#00A300';
                                                }
                                                if ($value['Attachment']) {
                                                    $attachment = '1';
                                                }
                                                ?>
                                                <tr>
                                                    <th scope="row"><?php echo ($key + 1); ?></th>
                                                    <td><?php echo $value['VillageNameHi']; ?></td>
                                                    <td><?php echo $value['GataNo']; ?></td>
                                                    <td><?php echo $value['KhataNo']; ?></td>
                                                    <td><?php echo $value['Grievance']; ?></td>
                                                    <td><?php echo date('d-m-Y g:i A', $value['DateCreated']); ?></td>
                                                    <td style="<?php echo $color; ?>"><?php echo $status; ?></td>
                                                    <?php if ($attachment == '1') { ?>
                                                        <td><a target="_blank" href="download?file=<?php echo base64_encode($value['Attachment']); ?>&type=<?php echo base64_encode('grievance_report'); ?>">रिपोर्ट देखें</a></td>
                                                    <?php } else { ?>
                                                        <td>--</td>
                                                    <?php } ?>
                                                    <td><?php echo $value['Remarks'] ? $value['Remarks'] : '--'; ?></td>
                                                    <?php if ($value['LekhpalMobile'] && $value['OsdMobile'] == '') { ?>
                                                        <td>Lekhpal (<?php echo $value['LekhpalMobile']; ?>)</td>
                                                    <?php } else if ($value['LekhpalMobile'] == '' && $value['OsdMobile']) { ?>
                                                        <td>OSD (<?php echo $value['OsdMobile']; ?>)</td>
                                                    <?php } else if ($value['LekhpalMobile'] && $value['OsdMobile']) { ?>
                                                        <td>Lekhpal (<?php echo $value['LekhpalMobile']; ?>), OSD (<?php echo $value['OsdMobile']; ?>)</td>
                                                    <?php } else { ?>
                                                        <td>--</td>
                                                    <?php } ?>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- / Content -->

                        <!-- Footer -->
                        <?php include 'includes/kasht_footer.php'; ?>
                        <!-- / Footer -->

                        <div class="content-backdrop fade"></div>
                    </div>
                    <!-- Content wrapper -->
                </div>
                <!-- / Layout page -->
            </div>
            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>
        </div>
    </body>
    <script src="assets/vendor/js/helpers.js"></script>
    <script src="assets/js/config.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/js/menu.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="scripts/buttons.js"></script>
    <script src="scripts/common.js"></script>
    <script src="scripts/kashtkar.js"></script>
</html>