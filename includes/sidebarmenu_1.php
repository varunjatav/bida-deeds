<?php
include_once '../core/permission.core.php';
include_once '../languages/' . $lang_file;
$dashboard_url_array = array('dashboard');
$syndata_url_array = array('syndata');
$ebasta_url_array = array('ebasta');
$report_url_array = array('reports');
$mis_dashboard_url_array = array('misdashboard', 'misreport');
$mis_report_url_array = array('misreport');
$feed_report_url_array = array('feedbacks');
$slao_report_url_array = array('slaoreport');
$bank_report_url_array = array('bankreport');
$treas_report_url_array = array('treasreport');
$bank_ebasta_url_array = array('bankebasta');
$e_office_url_array = array("eoffice");
$grievances_url_array = array("grievances");
$kashtkar_url_array = array("sahmatilist");
$lekhpal_url_array = array("lekhpalreport", "lekhpalreportview", "lekhpalappreport", "lekhpalappreportview");
$map_url_array = array("bidamap");
$bainama_amt_url_array = array("bainamaamount");
$parisampattimodule_module_url_array = array("parisampattimodule");
$landacquisition_module_url_array = array("masterdatalist", "masterdatadetails");
$payment_module_url_array = array("paymentmodule");
$landrate_module_url_array = array("landratemodule");
$office_order_module_url_array = array("officeordermodule");
$gis_url_array = array("bidamap");
$misc_url_array = array('syndata', 'ebasta', 'reports', 'misdashboard', 'misreport', 'feedbacks', 'eoffice', 'lekhpalreport', 'lekhpalreportview', 'lekhpalappreport', 'lekhpalappreportview', 'sahmatilist');
$village_module_url_array = array("villagelist", "villagelistdatadetails");
?>
<style>/* Default state - collapsed */
/* Wrapper and Column Layout */
.wrapper {
    display: flex;
}

.col-wrapper, .right {
    flex-grow: 1;
    transition: all 0.3s ease-in-out;
}

/* Sidebar Styles */
.sidebar {
    width: 250px; /* Expanded width */
    height: 100vh;
    background-color: #333;
    position: fixed;
    transition: width 0.3s ease;
    overflow: hidden;
}

.sidebar.collapsed {
    width: 50px; /* Collapsed width */
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar ul li {
    padding: 10px;
}

.sidebar ul li a {
    color: #fff;
    text-decoration: none;
    display: flex;
    align-items: center;
}

.sidebar .actn {
    margin-right: 10px;
}

.sidebar .actnme {
    transition: opacity 0.3s ease;
}

.sidebar.collapsed .actnme {
    opacity: 0; /* Hide text when collapsed */
}

/* Toggle Button Styles */
.sidebar-toggle {
    position: absolute;
    bottom: 20px;
    left: 100%; /* Position outside sidebar */
    cursor: pointer;
}

.sidebar-toggle img {
    width: 20px;
    height: 20px;
    transition: transform 0.3s ease;
}

.sidebar.collapsed .sidebar-toggle img {
    transform: rotate(180deg); /* Rotate arrow when collapsed */
}

/* Full Column Layout Adjustments */
.full-column {
    width: calc(100% - 250px); /* Width when sidebar is expanded */
    transition: width 0.3s ease;
}

.sidebar.collapsed + .full-column {
    width: calc(100% - 50px); /* Adjust content width when sidebar is collapsed */
}

/* Right Content Margin Adjustments */
.right {
    margin-left: 250px; /* Adjust content margin when sidebar is expanded */
}

.sidebar.collapsed + .right {
    margin-left: 50px; /* Adjust content margin when sidebar is collapsed */
}

</style>
<div class="sidebar left  collapsed" id="sidebar">
    <div class="sidebar-toggle">
        <img src="img/arrow.svg" alt="Toggle Sidebar">
    </div>
    <?php if ($_SESSION['UserType'] == '0' || $_SESSION['UserType'] == '1') { ?>
        <ul>
            <!-- <li>
                <a href="dashboard" class="<?php if (in_array($urlStr, $dashboard_url_array)) { ?>active<?php } ?>">
                    <span class="acticn"><img src="img/homeh.svg" alt="" height="18px" width="18px"></span>
                    <span class="actnme text-wrapping left">Dashboard</span>
                    <div class="clr"></div>
                </a>
            </li> -->
            <li>
                <a href="masterdatalist" class="<?php if (in_array($urlStr, $landacquisition_module_url_array)) { ?>active<?php } ?>">
                    <span class="acticn"><img src="img/report.svg" alt="" height="18px" width="18px"></span>
                    <span class="actnme text-wrapping left"><?php echo $side_menu['land_master_data']; ?></span>
                    <div class="clr"></div>
                </a>
            </li>
            <li>
                <a href="villagelist" class="<?php if (in_array($urlStr, $village_module_url_array)) { ?>active<?php } ?>">
                    <span class="acticn"><img src="img/report.svg" alt="" height="18px" width="18px"></span>
                    <span class="actnme text-wrapping left"><?php echo $side_menu['village_master_data']; ?></span>
                    <div class="clr"></div>
                </a>
            </li>
            <?php if ($_SESSION['UserType'] == '0') { ?>
                <!-- <li>
                    <a href="bainamaamount" class="<?php if (in_array($urlStr, $bainama_amt_url_array)) { ?>active<?php } ?>">
                        <span class="acticn"><img src="img/currency.svg" alt="" height="18px" width="18px"></span>
                        <span class="actnme text-wrapping left">Vilekh Module</span>
                        <div class="clr"></div>
                    </a>
                </li>
                <li>
                    <a href="paymentmodule" class="<?php if (in_array($urlStr, $payment_module_url_array)) { ?>active<?php } ?>">
                        <span class="acticn"><img src="img/payment.svg" alt="" height="18px" width="18px"></span>
                        <span class="actnme text-wrapping left">Payment Module</span>
                        <div class="clr"></div>
                    </a>
                </li>
                <li>
                    <a href="parisampattimodule" class="<?php if (in_array($urlStr, $parisampattimodule_module_url_array)) { ?>active<?php } ?>">
                        <span class="acticn"><img src="img/file_office.svg" alt="" height="18px" width="18px"></span>
                        <span class="actnme text-wrapping left">Parisampatti Module</span>
                        <div class="clr"></div>
                    </a>
                </li>
                <li>
                    <a href="grievances" class="<?php if (in_array($urlStr, $grievances_url_array)) { ?>active<?php } ?>">
                        <span class="acticn"><img src="img/grievance.svg" alt="" height="18px" width="18px"></span>
                        <span class="actnme text-wrapping left">Grievance Module</span>
                        <div class="clr"></div>
                    </a>
                </li>
                <li>
                    <a href="landratemodule" class="<?php if (in_array($urlStr, $landrate_module_url_array)) { ?>active<?php } ?>">
                        <span class="acticn"><img src="img/calculation.svg" alt="" height="18px" width="18px"></span>
                        <span class="actnme text-wrapping left">Land Rate Module</span>
                        <div class="clr"></div>
                    </a>
                </li>
                <li>
                    <a href="officeordermodule" class="<?php if (in_array($urlStr, $office_order_module_url_array)) { ?>active<?php } ?>">
                        <span class="acticn"><img src="img/office.svg" alt="" height="18px" width="18px"></span>
                        <span class="actnme text-wrapping left">Office Order Module</span>
                        <div class="clr"></div>
                    </a>
                </li>
                <li>
                    <a href="bidamap" class="<?php if (in_array($urlStr, $map_url_array)) { ?>active<?php } ?>">
                        <span class="acticn"><img src="img/map1.svg" alt="" height="18px" width="18px"></span>
                        <span class="actnme text-wrapping left">Map Module</span>
                        <div class="clr"></div>
                    </a>
                </li>
                <li>
                    <a href="bidamap" class="<?php if (in_array($urlStr, $gis_url_array)) { ?>active<?php } ?>">
                        <span class="acticn"><img src="img/map1.svg" alt="" height="18px" width="18px"></span>
                        <span class="actnme text-wrapping left">GIS Encroachment Module</span>
                        <div class="clr"></div>
                    </a>
                </li> -->
            <?php } ?>
            <!-- <li class="sidedropdown">
                <a href="javascript:void(0)" class="dropbtn <?php if (in_array($urlStr, $misc_url_array)) { ?>active<?php } ?>">
                    <span class="acticn">
                        <img src="img/misc.svg" alt="" height="18px" width="18px">
                    </span>
                    <span class="actnme text-wrapping left">Miscellaneous</span>
                    <div class="clr"></div>
                </a>
                <div class="dropdown-content" style="<?php if (in_array($urlStr, $misc_url_array)) { ?>display:block;<?php } ?>">
                    <a href="syndata" class="d-flex <?php if (in_array($urlStr, $syndata_url_array)) { ?>active<?php } ?>">
                        <span class="acticn"><img src="img/cloud-sync.svg" alt="" height="18px" width="18px"></span>
                        <span class="actnme text-wrapping left">Upload & Sync</span>
                        <div class="clr"></div>
                    </a>
                    <a href="ebasta" class="d-flex <?php if (in_array($urlStr, $ebasta_url_array)) { ?>active<?php } ?>">
                        <span class="acticn"><img src="img/cloud-upload.svg" alt="" height="18px" width="18px"></span>
                        <span class="actnme text-wrapping left">E-BASTA</span>
                        <div class="clr"></div>
                    </a>
                    <a href="reports" class="d-flex <?php if (in_array($urlStr, $report_url_array)) { ?>active<?php } ?>">
                        <span class="acticn"><img src="img/report.svg" alt="" height="18px" width="18px"></span>
                        <span class="actnme text-wrapping left">Village Gata Reports</span>
                        <div class="clr"></div>
                    </a>
            <?php if ($_SESSION['UserType'] == '0') { ?>
                            <a href="lekhpalreport" class="d-flex <?php if (in_array($urlStr, $lekhpal_url_array)) { ?>active<?php } ?>">
                                <span class="acticn"><img src="img/analytics.svg" alt="" height="18px" width="18px"></span>
                                <span class="actnme text-wrapping left">Lekhpal Reports</span>
                                <div class="clr"></div>
                            </a>
                            <a href="misdashboard" class="d-flex <?php if (in_array($urlStr, $mis_dashboard_url_array)) { ?>active<?php } ?>">
                                <span class="acticn"><img src="img/mis-dashboard.svg" alt="" height="18px" width="18px"></span>
                                <span class="actnme text-wrapping left">OSD MIS Module</span>
                                <div class="clr"></div>
                            </a>
                            <a href="sahmatilist" class="d-flex <?php if (in_array($urlStr, $kashtkar_url_array)) { ?>active<?php } ?>">
                                <span class="acticn"><img src="img/group.svg" alt="" height="18px" width="18px"></span>
                                <span class="actnme text-wrapping left">Kashtkar Sahmati</span>
                                <div class="clr"></div>
                            </a>
                            <a href="feedbacks" class="d-flex <?php if (in_array($urlStr, $feed_report_url_array)) { ?>active<?php } ?>">
                                <span class="acticn"><img src="img/feedbacks.svg" alt="" height="18px" width="18px"></span>
                                <span class="actnme text-wrapping left">DM Feedback Module</span>
                                <div class="clr"></div>
                            </a>
                            <a href="eoffice" class="d-flex <?php if (in_array($urlStr, $e_office_url_array)) { ?>active<?php } ?>">
                                <span class="acticn"><img src="img/file_office.svg" alt="" height="18px" width="18px"></span>
                                <span class="actnme text-wrapping left">E-Office</span>
                                <div class="clr"></div>
                            </a>
            <?php } ?>
                </div>
            </li> -->
        </ul>
    <?php } else if ($_SESSION['UserType'] == '1') { ?>
        <!-- <ul>
            <li>
                <a href="misdashboard" class="<?php if (in_array($urlStr, $mis_dashboard_url_array)) { ?>active<?php } ?>">
                    <span class="acticn"><img src="img/mis-dashboard.svg" alt="" height="18px" width="18px"></span>
                    <span class="actnme text-wrapping left">OSD MIS Module</span>
                    <div class="clr"></div>
                </a>
            </li>
            <li>
                <a href="reports" class="<?php if (in_array($urlStr, $report_url_array)) { ?>active<?php } ?>">
                    <span class="acticn"><img src="img/report.svg" alt="" height="18px" width="18px"></span>
                    <span class="actnme text-wrapping left">Village Gata Reports</span>
                    <div class="clr"></div>
                </a>
            </li>
            <li>
                <a href="sahmatilist" class="<?php if (in_array($urlStr, $kashtkar_url_array)) { ?>active<?php } ?>">
                    <span class="acticn"><img src="img/group.svg" alt="" height="18px" width="18px"></span>
                    <span class="actnme text-wrapping left">Kashtkar Sahmati Module</span>
                    <div class="clr"></div>
                </a>
            </li>
            <li>
                <a href="grievances" class="<?php if (in_array($urlStr, $grievances_url_array)) { ?>active<?php } ?>">
                    <span class="acticn"><img src="img/grievance.svg" alt="" height="18px" width="18px"></span>
                    <span class="actnme text-wrapping left">Grievance Module</span>
                    <div class="clr"></div>
                </a>
            </li>
        </ul>
    <?php } else if ($_SESSION['UserType'] == '3') { ?>
        <ul>
            <li>
                <a href="slaoreport" class="<?php if (in_array($urlStr, $slao_report_url_array)) { ?>active<?php } ?>">
                    <span class="acticn"><img src="img/homeh.svg" alt="" height="18px" width="18px"></span>
                    <span class="actnme text-wrapping left">Dashboard</span>
                    <div class="clr"></div>
                </a>
            </li>
            <li>
                <a href="reports" class="<?php if (in_array($urlStr, $report_url_array)) { ?>active<?php } ?>">
                    <span class="acticn"><img src="img/report.svg" alt="" height="18px" width="18px"></span>
                    <span class="actnme text-wrapping left">Reports</span>
                    <div class="clr"></div>
                </a>
            </li>
        </ul>
    <?php } else if ($_SESSION['UserType'] == '4') { ?>
        <ul>
        <?php if ($_SESSION['UserID'] == '8') { ?>
                    <li>
                        <a href="bankreport" class="<?php if (in_array($urlStr, $bank_report_url_array)) { ?>active<?php } ?>">
                            <span class="acticn"><img src="img/homeh.svg" alt="" height="18px" width="18px"></span>
                            <span class="actnme text-wrapping left">Dashboard</span>
                            <div class="clr"></div>
                        </a>
                    </li>
        <?php } ?>
            <li>
                <a href="bankebasta" class="<?php if (in_array($urlStr, $bank_ebasta_url_array)) { ?>active<?php } ?>">
                    <span class="acticn"><img src="img/cloud-upload.svg" alt="" height="18px" width="18px"></span>
                    <span class="actnme text-wrapping left">Mortagage</span>
                    <div class="clr"></div>
                </a>
            </li>
        </ul>
    <?php } else if ($_SESSION['UserType'] == '5') { ?>
        <ul>
            <li>
                <a href="treasreport" class="<?php if (in_array($urlStr, $treas_report_url_array)) { ?>active<?php } ?>">
                    <span class="acticn"><img src="img/homeh.svg" alt="" height="18px" width="18px"></span>
                    <span class="actnme text-wrapping left">Dashboard</span>
                    <div class="clr"></div>
                </a>
            </li>
        </ul> -->
    <?php } else if ($_SESSION['UserType'] == '6') { ?>
        <!-- <ul>
            <li>
                <a href="reports" class="<?php if (in_array($urlStr, $report_url_array)) { ?>active<?php } ?>">
                    <span class="acticn"><img src="img/report.svg" alt="" height="18px" width="18px"></span>
                    <span class="actnme text-wrapping left">Village Gata Reports</span>
                    <div class="clr"></div>
                </a>
            </li>
        </ul>
    <?php } else if ($_SESSION['UserType'] == '8') { ?>
        <ul>
            <li>
                <a href="bainamaamount" class="<?php if (in_array($urlStr, $bainama_amt_url_array)) { ?>active<?php } ?>">
                    <span class="acticn"><img src="img/currency.svg" alt="" height="18px" width="18px"></span>
                    <span class="actnme text-wrapping left">Vilekh Module</span>
                    <div class="clr"></div>
                </a>
            </li>
        </ul> -->
    <?php } ?>
<!--    <button id="toggleSidebar">
        <img src="img/arrow-expand.svg" alt="Toggle Sidebar" width="18px">
    </button>-->
    <div class="sidebar-toggle">
    <img src="img/arrow-expand.svg" alt="Toggle Sidebar">
</div>
</div>
<script src="../scripts/jquery-ui.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const toggleButton = document.querySelector('.sidebar-toggle');

        toggleButton.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
            const rightColumn = document.querySelector('.right');
            rightColumn.classList.toggle('expanded');
        });
    });
</script>
