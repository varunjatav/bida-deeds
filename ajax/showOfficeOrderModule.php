<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';

$sql = $db->prepare("SELECT MIN(T1.OrderMonth) AS OrderMonth FROM lm_office_order_module T1 WHERE T1.RowDeleted = ? LIMIT 1");
$sql->bindValue(1, 0);
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
$row = $sql->fetch();
$year = $row['OrderMonth'] ? date('Y', $row['OrderMonth']) : 2021;
?>
<div class="popup-overlay">
    <div class="popup-wrap pp-medium-x">
        <div class="popup-header" style="cursor: move;">
            <span class="popup-title text-wrapping left">Select filters to apply</span>
            <span class="popup-close right">
                <a style="cursor: pointer;" id="cancelFilter">
                    <img src="img/clear-w.svg" alt="" width="18px">
                </a>
            </span>
            <div class="clr"></div>
        </div>
        <div id="popupDiv">
            <div class="popup-body pp-medium-y">
                <form id="ffrm">
                    <div class="filter-box">
                        <div class="filter-tabber left">
                            <a style="cursor:pointer;" id="1" class="ftab active">Order Year & Month</a>
                            <a style="cursor:pointer;" id="2" class="ftab">Subject</a>
                            <a style="cursor:pointer;" id="3" class="ftab">Order No</a>
                            <a style="cursor:pointer;" id="4" class="ftab">Creation Date</a> 
                        </div>

                        <div class="left filter-taboptions">
                            <div class="tab1" id="stab_1" style="border: none;">
                                <div class="frm-lbl-actv" style="margin-bottom: 5px;">Select Year & Month:</div>
                                <div style="display: flex;">
                                    <div class="select dev_req_msg left rmarg">
                                        <select name="year" id="yearSelect" class="apply_filter_change"> 
                                            <option value="">Select Year</option>
                                            <?php
                                            foreach (range($year, (int) date("Y")) as $year) {
                                                ?>
                                                <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <div class="select__arrow"></div>
                                    </div>

                                    <div class="select dev_req_msg left rmarg">
                                        <select name="month" id="monthSelect" class="apply_filter_change">
                                            <option value="">Select Month</option>
                                            <?php
                                            $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                                            foreach ($months as $month) {
                                                ?>
                                                <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <div class="select__arrow"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab1" id="stab_2" style="display:none; border: none;">
                                <div class="frm-lbl-actv">Subject:</div>
                                <input type="text" name="subject" class="frm-txtbox dept-frm-input apply_filter_keyup" maxlenth="750" placeholder="Enter Subject" autocomplete="off">
                            </div>
                            <div class="tab1" id="stab_3" style="display:none; border: none;">
                                <div class="frm-lbl-actv">Order No:</div>
                                <input type="text" name="order_no" class="frm-txtbox dept-frm-input apply_filter_keyup" maxlenth="25" placeholder="Enter Order No" autocomplete="off">
                            </div>
                            <div class="tab1" id="stab_4" style="display:none; border: none;">
                                From:
                                <div class="filter-choice">
                                    <input type="text" name="sdate"
                                           class="frm-txtbox dept-frm-input spbdate apply_filter_change calshow"
                                           placeholder="Start Date">
                                </div>
                                To:
                                <div class="filter-choice">
                                    <input type="text" name="edate"
                                           class="frm-txtbox dept-frm-input spbedate apply_filter_change calshow"
                                           placeholder="End Date">
                                </div>
                            </div>
                        </div>
                        <div class="clr"></div>
                    </div>
                    <input type="hidden" id="nav" name="status" value="<?php echo $_REQUEST['status']; ?>" autocomplete="off">
                </form>
            </div>
        </div>
    </div>
</div>