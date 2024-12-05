<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/sahmati.core.php';
if ($total_count == 0) {
    ?>
    <div class="blank-widget">
        <a>No Data Found</a>
    </div>
<?php } else { ?>
    <div id="paginate-body" style="display: contents;">
        <?php
        while ($row = $sql->fetch()) {
            $srno++;
            $status = 'Pending';
            $color = '';
            if ($row['Status'] == '1') {
                $status = 'Solved';
                $color = 'row-highlight-green';
            }
            $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
            $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
            $khata_no = $row['KhataNo'] ? $row['KhataNo'] : '--';
            $area = $row['Area'] ? $row['Area'] : '--';
            $mobile = $row['Mobile'] ? $row['Mobile'] : '--';
            $owner_name = $row['OwnerName'] ? $row['OwnerName'] : '--';
            $owner_father = $row['OwnerFather'] ? $row['OwnerFather'] : '--';
            $grievance = $row['Grievance'] ? $row['Grievance'] : '--';
            $remarks = $row['Remarks'] ? $row['Remarks'] : '--';
            $ansh = $row['Ansh'] ? $row['Ansh'] : '--';
            ?>
            <div class="rowDiv <?php echo $color; ?>">
                <div class="cellDiv col1">
                    <?php echo $srno; ?>
                </div>
                <div class="cellDiv col2">
                    <?php echo $village_name; ?>
                </div>
                <div class="cellDiv col3">
                    <?php echo $gata_no; ?>
                </div>
                <div class="cellDiv col4">
                    <?php echo $khata_no; ?>
                </div>
                <div class="cellDiv col5" name="<?php echo $mobile; ?>">
                    <?php echo $mobile; ?>
                </div>
                <div class="cellDiv col6">
                    <?php echo $owner_name; ?>
                </div>
                <div class="cellDiv col7">
                    <?php echo $owner_father; ?>
                </div>
                <div class="cellDiv col8">
                    <?php echo $ansh; ?>
                </div>
                <div class="cellDiv col9" name="<?php echo str_replace('.', '', $area); ?>">
                    <?php echo $area; ?>
                </div>
                <div class="cellDiv col10" style="text-align: center;">
                    <?php if ($row['Attachment']) { ?>
                        <a class="" title="Download Sahmati" target="_blank" href="download?file=<?php echo base64_encode($row['Attachment']); ?>&type=<?php echo base64_encode('kashtkar_sahmati'); ?>">
                            <img src="img/download_1.svg" height="18px">
                        </a>
                    <?php } else { ?>
                        --
                    <?php } ?>
                </div>
                <div class="cellDiv col11">
                    <?php echo date('d-m-Y g:i A', $row['DateCreated']); ?>
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