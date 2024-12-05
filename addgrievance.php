<?php
include_once 'config.php';
include_once 'includes/kashtCheckSession.php';
include_once 'includes/get_time_zone.php';
include_once 'dbcon/db_connect.php';
include_once 'functions/common.function.php';
include_once 'core/grievance.core.php';
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
                            <?php
                            if ($sahmatiInfo['Status'] == '2') {
                                ?>
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="defaultSelect" class="form-label" style="font-weight: 600;font-size: 0.95em;">Last Status: <span class="<?php echo $status_color; ?>"><?php echo $status; ?></span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Account -->
                                </div>
                                <?php
                            }
                            ?>
                            <h4 class="fw-bold py-3 mb-4">
                                शिकायत दर्ज करें
                            </h4>
                            <form id="frm" class="mb-3" autocomplete="off">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="defaultSelect" class="form-label">गाँव चुनें</label>
                                                <select name="village_code" class="form-select fldrequired village_code">
                                                    <option value="">गाँव चुनें</option>
                                                    <?php foreach ($villageInfo as $dKey => $dValue) { ?>
                                                        <option value="<?php echo $dValue['VillageCode']; ?>">
                                                            <?php echo $dValue['VillageName']; ?> (<?php echo $dValue['VillageNameHi']; ?>)
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="defaultSelect" class="form-label">गाटा चुनें</label>
                                                <select name="gata_no" class="form-select fldrequired village_gata">
                                                    <option value="">गाटा चुनें</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="defaultSelect" class="form-label">खाता चुनें</label>
                                                <select name="khata_no" class="form-select fldrequired village_khata">
                                                    <option value="">खाता चुनें</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="defaultSelect" class="form-label">काश्तकार चुनें</label>
                                                <select name="kashtkar" class="form-select fldrequired kashtkar" id="griev_kashtkar">
                                                    <option value="">काश्तकार चुनें</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="defaultSelect" class="form-label">शिकायत चुनें</label>
                                                <select name="type" class="form-select fldrequired type">
                                                    <option value="">शिकायत चुनें</option>
                                                    <?php foreach ($grievInfo as $dKey => $dValue) { ?>
                                                        <option value="<?php echo $dValue['ID']; ?>">
                                                            <?php echo $dValue['Type']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Account -->
                                </div>
                                <input type="hidden" name="mobile" id="mobile" value="<?php echo $mobile; ?>">
                                <div class="frm_hidden_data"></div>
                                <div class="frm_hidden_data_1"></div>
                                <div class="mt-2">
                                    <a class="btn btn-secondary me-1" href="#multiCollapseExample1" onclick="history.go(-1);">पीछे जाएं</a>
                                    <button class="btn btn-primary" id="save_grievance">शिकायत दर्ज करें</button>
                                </div>
                            </form>
                            <div id="notify" style="position: fixed; bottom: 0; width: 91%; z-index: 10;"></div>
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