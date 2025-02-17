<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/permission.core.php';
include_once '../core/userDataList.core.php';
include_once '../languages/' . $lang_file;
if ($total_count == 0) {
?>
    <div class="blank-widget">
        <a>No Data Found</a>
    </div>
<?php } else { ?>
    <div id="paginate-body" style="display: contents;">
        <?php
        $srno = 0;
        while ($row = $sql->fetch()) {
            $srno++;
            $id = $row['ID'] ? $row['ID'] : '--';
            $name = $row['Name'] ? $row['Name'] : '--';
            $username = $row['User_Name'] ? $row['User_Name'] : '--';
            $email = $row['Email'] ? $row['Email'] : '--';
            $designation = $row['Designation'] ? $row['Designation'] : '--';
            $address = $row['Address'] ? $row['Address'] : '--';
            $gender = $row['Gender'] ? $row['Gender'] : '--';
            $mobile_no = $row['Mobile_NO'] ? $row['Mobile_NO'] : '--';
        ?>
            <div class="rowDiv <?php echo $validate_color; ?>">
                <div class="cellDiv col1" name="<?php echo $id; ?>">
                    <?php echo $id; ?>
                </div>
                <div class="cellDiv col2">
                    <?php echo $name; ?>
                </div>
                <div class="cellDiv col3">
                    <?php echo $username; ?>
                </div>
                <div class="cellDiv col4">
                    <?php echo $email; ?>
                </div>
                <div class="cellDiv col5">
                    <?php echo $designation; ?>
                </div>
                <div class="cellDiv col6">
                    <?php echo $address; ?>
                </div>
                <div class="cellDiv col7">
                    <?php echo $gender; ?>
                </div>
                <div class="cellDiv col8">
                    <?php echo $mobile_no; ?>
                </div>

                <div class="cellDiv cellDivacts col10">
                    <div class="posrel tblactns">
                        <a style="cursor:pointer;" class="showAction">
                            <img src="img/more-vertical-dark.svg" alt="" height="18px">
                        </a>
                        <div class="posabsolut nwactdrops" style="display:none;">
                            <a style="cursor:pointer;" class="edit_file" id="<?php echo encryptIt(myUrlEncode($row['ID'])); ?>">
                                <?php echo $master_data_details['edit']; ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
    <?php }
    }
    ?>
    </div>
    <?php
    if ($output) {
    ?>
        <div class="pagination">
            <div class="left rsltpp">
                <div class="rsl-hding left">Result Per Page</div>
                <div class="rsl-counter left posrel">
                    <a style="cursor:pointer;" class="perPage">10</a>
                    <ul class="posabsolut" style="display: none;">
                        <li><a style="cursor:pointer;" class="setPage">2</a></li>
                        <li><a style="cursor:pointer;" class="setPage">5</a></li>
                        <li><a style="cursor:pointer;" class="setPage">10</a></li>
                        <li><a style="cursor:pointer;" class="setPage">15</a></li>
                        <li><a style="cursor:pointer;" class="setPage">20</a></li>
                    </ul>
                </div>
                <div class="clr"></div>
            </div>
            <div class="right pgntn">
                <?php echo $output; ?>
                <div class="clr"></div>
            </div>
            <input type="hidden" id="pagelimit" autocomplete="off" value="10">
            <input type="hidden" id="srno" autocomplete="off" value="<?php echo $srno; ?>">
            <div class="clr"></div>
        </div>
    <?php
    }
    ?>
    <input type="hidden" name="total_count" id="total_count" value="<?php echo $total_count; ?>" autocomplete="off">