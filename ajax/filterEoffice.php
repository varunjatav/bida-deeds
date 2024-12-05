<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/eoffice.core.php';
if ($total_count == 0) {
    ?>
    <div class="blank-widget">
        <a>No Data Found</a>
    </div>
<?php } else { ?>
    <div id="paginate-body" style="display: contents;">
        <?php
        while ($row = $sql->fetch()) {
            $first_val = implode(',', array_slice(explode(',', $row['Subject']), 0, 4));
            $subject_count = count_(explode(',', $row['Subject']));

            $first_val_spc = implode(' ', array_slice(explode(' ', $row['Subject']), 0, 7));
            $subject_count_spc = count_(explode(' ', $row['Subject']));

            $rest_val_count = '';
            if ($subject_count > 4) {
                $first_val = $first_val_spc;
                $rest_val_count = ' + see more';
            } else if ($subject_count_spc > 8) {
                $first_val = $first_val_spc;
                $rest_val_count = ' + see more';
            }
            $subject_short = $first_val . ' ' . '<span style="color:blue;cursor:pointer;">' . $rest_val_count . '</span>';
            ?>
            <div class="rowDiv">
                <div class="cellDiv col1">
                    <a style="cursor: pointer; color:blue; font-weight: 600;" class="edit_file" id="<?php echo encryptIt($row['ID']); ?>">
                        <?php echo $row['DepartmentName'] ? $row['DepartmentName'] : '--'; ?>
                    </a>
                </div>
                <div class="cellDiv col2">
                    <?php echo $row['FileNo'] ? $row['FileNo'] : "--"; ?>
                </div>
                <div class="cellDiv col3">
                    <?php echo $row['Name'] ? $row['Name'] : "--"; ?>
                </div>
                <div class="cellDiv col4">
                    <span class="tool" data-tip="<?php echo $row['Subject']; ?>"><?php echo $subject_short; ?></span>
                </div>
                <div class="cellDiv col5">
                    <?php echo $row['FolderNameForNoteSheet'] ? $row['FolderNameForNoteSheet'] : '--'; ?>
                </div>
                <div class="cellDiv col6">
                    <?php echo $row['FileCreator'] ? $row['FileCreator'] : '--'; ?>
                </div>
                <div class="cellDiv col7 <?php echo $row['Active'] == '1' ? 'grntxt' : 'redtxt'; ?>">
                    <?php echo $row['Active'] == '1' ? 'Active' : 'Inactive'; ?>
                </div>
                <div class="cellDiv cellDivacts">
                    <div class="posrel tblactns">
                        <a style="cursor:pointer;" class="showAction">
                            <img src="img/more-vertical-dark.svg" alt="" height="18px">
                        </a>

                        <div class="posabsolut nwactdrops" style="display:none;">
                            <a style="cursor: pointer;" class="edit_file" id="<?php echo encryptIt($row['ID']); ?>">Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
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
                <a style="cursor:pointer;" class="perPage">100</a>
                <ul class="posabsolut" style="display: none;">
                    <li><a style="cursor:pointer;" class="setPage">1000</a></li>
                    <li><a style="cursor:pointer;" class="setPage">500</a></li>
                    <li><a style="cursor:pointer;" class="setPage">200</a></li>
                    <li><a style="cursor:pointer;" class="setPage">100</a></li>
                    <li><a style="cursor:pointer;" class="setPage">50</a></li>
                </ul>
            </div>
            <div class="clr"></div>
        </div>
        <div class="right pgntn">
            <?php echo $output; ?>
            <div class="clr"></div>
        </div>
        <input type="hidden" id="pagelimit" autocomplete="off" value="100">
        <input type="hidden" id="srno" autocomplete="off" value="<?php echo $srno; ?>">
        <div class="clr"></div>
    </div>
    <?php
}
?>
<input type="hidden" name="total_count" id="total_count" value="<?php echo $total_count; ?>" autocomplete="off">