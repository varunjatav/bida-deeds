<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/newDashboardSummary.core.php';
?>
<?php
if ($dashboard_data == '1') {
    ?>
    <div class="rowDivHeader">
        <div class="cellDivHeader">
            <p>Village Name</p>
        </div>
        <div class="cellDivHeader">
            <p>Village Code</p>
        </div>
        <div class="cellDivHeader">
            <p>Gata No</p>
        </div>
        <div class="cellDivHeader">
            <p>Owner Name</p>
        </div>
        <div class="cellDivHeader">
            <p>Owner Father</p>
        </div>
    </div>
    <div id="main-body" style="display: contents;">
        <div id="paginate-body" style="display: contents;">
            <?php
            $srno = 0;
            while ($row = $sql->fetch()) {
                $srno++;
                ?>
                <div class="rowDiv">
                    <div class="cellDiv col1">
                        <?php echo $row['VillageName']; ?>
                    </div>
                    <div class="cellDiv col2">
                        <?php echo $row['VillageCode']; ?>
                    </div>
                    <div class="cellDiv col3">
                        <?php echo $row['GataNo']; ?>
                    </div>
                    <div class="cellDiv col4">
                        <?php echo $row['owner_name']; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['owner_father']; ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else if ($dashboard_data == '2') {
    ?>
    <div class="rowDivHeader">
        <div class="cellDivHeader">
            <p>Village Name</p>
        </div>
        <div class="cellDivHeader">
            <p>Village Code</p>
        </div>
        <div class="cellDivHeader">
            <p>Gata No</p>
        </div>
        <div class="cellDivHeader">
            <p>Khata No</p>
        </div>
        <div class="cellDivHeader">
            <p>Gata Area</p>
        </div>
        <div class="cellDivHeader">
            <p>Shreni</p>
        </div>
        <div class="cellDivHeader">
            <p>total_land_and_parisampatti_amount</p>
        </div>
    </div>
    <div id="main-body" style="display: contents;">
        <div id="paginate-body" style="display: contents;">
            <?php
            $srno = 0;
            $total_land_and_parisampatti_amount = 0;
            while ($row = $sql->fetch()) {
                $srno++;
                $total_land_and_parisampatti_amount += $row['total_land_and_parisampatti_amount'];
                ?>
                <div class="rowDiv">
                    <div class="cellDiv col1">
                        <?php echo $row['VillageName']; ?>
                    </div>
                    <div class="cellDiv col2">
                        <?php echo $row['VillageCode']; ?>
                    </div>
                    <div class="cellDiv col3">
                        <?php echo $row['GataNo']; ?>
                    </div>
                    <div class="cellDiv col4">
                        <?php echo $row['KhataNo']; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['Area']; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo $row['Shreni']; ?>
                    </div>
                    <div class="cellDiv col7">
                        <?php echo format_rupees($row['total_land_and_parisampatti_amount']); ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <input type="hidden" id="tCount" value="<?php echo $total_land_and_parisampatti_amount; ?>" autocomplete="off">
    </div>
    <?php
} else if ($dashboard_data == '3') {
    ?>
    <div class="rowDivHeader">
        <div class="cellDivHeader">
            <p>Village Name</p>
        </div>
        <div class="cellDivHeader">
            <p>Village Code</p>
        </div>
        <div class="cellDivHeader">
            <p>Gata No</p>
        </div>
        <div class="cellDivHeader">
            <p>Khata No</p>
        </div>
        <div class="cellDivHeader">
            <p>Kashtkar Name</p>
        </div>
        <div class="cellDivHeader">
            <p>Father Name</p>
        </div>
        <div class="cellDivHeader">
            <p>Ansh</p>
        </div>
        <div class="cellDivHeader">
            <p>Rakba</p>
        </div>
        <div class="cellDivHeader">
            <p>Download</p>
        </div>
    </div>
    <div id="main-body" style="display: contents;">
        <div id="paginate-body" style="display: contents;">
            <?php
            $srno = 0;
            while ($row = $sql->fetch()) {
                $srno++;
                $ebasta_2 = json_decode($row['Ebasta2'], true);
                $file_name = $ebasta_2[0]['file_name'];
                ?>
                <div class="rowDiv">
                    <div class="cellDiv col1">
                        <?php echo $row['VillageName']; ?>
                    </div>
                    <div class="cellDiv col2">
                        <?php echo $row['VillageCode']; ?>
                    </div>
                    <div class="cellDiv col3">
                        <?php echo $row['GataNo']; ?>
                    </div>
                    <div class="cellDiv col4">
                        <?php echo $row['KhataNo']; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['owner_name']; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo $row['owner_father']; ?>
                    </div>
                    <div class="cellDiv col7">
                        <?php echo $row['KashtkarAnsh']; ?>
                    </div>
                    <div class="cellDiv col8">
                        <?php echo $row['AnshRakba']; ?>
                    </div>
                    <div class="cellDiv col9">
                        <a class="" title="Download Document" target="_blank" href="download?file=<?php echo base64_encode($file_name); ?>&type=<?php echo base64_encode('gata_ebasta'); ?>">
                            <div style="position: relative;">
                                <img src="img/download_1.svg" height="18px;">
                            </div>
                        </a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else if ($dashboard_data == '4') {
    ?>
    <div class="rowDivHeader">
        <div class="cellDivHeader">
            <p>Village Name</p>
        </div>
        <div class="cellDivHeader">
            <p>Village Code</p>
        </div>
        <div class="cellDivHeader">
            <p>Vilekh Sankhya</p>
        </div>
        <div class="cellDivHeader">
            <p>Bainama Date</p>
        </div>
        <div class="cellDivHeader">
            <p>Bainama Area</p>
        </div>
        <div class="cellDivHeader">
            <p>Land Amount</p>
        </div>
        <div class="cellDivHeader">
            <p>Parisampatti Amount</p>
        </div>
        <div class="cellDivHeader">
            <p>Bainama Amount</p>
        </div>
        <div class="cellDivHeader">
            <p>Payment Amount</p>
        </div>
        <div class="cellDivHeader">
            <p>Payment Approval Date</p>
        </div>
        <div class="cellDivHeader">
            <p>Download</p>
        </div>
    </div>
    <div id="main-body" style="display: contents;">
        <div id="paginate-body" style="display: contents;">
            <?php
            $srno = 0;
            $total_bainama_amount = 0;
            while ($row = $sql->fetch()) {
                $srno++;
                $ebasta_2 = json_decode($row['Ebasta2'], true);
                $file_name = $ebasta_2[0]['file_name'];
                $total_bainama_amount += $row['BainamaAmount'];
                ?>
                <div class="rowDiv">
                    <div class="cellDiv col1">
                        <?php echo $row['VillageName']; ?>
                    </div>
                    <div class="cellDiv col2">
                        <?php echo $row['VillageCode']; ?>
                    </div>
                    <div class="cellDiv col3">
                        <?php echo $row['VilekhSankhya'] ? $row['VilekhSankhya'] : '--'; ?>
                    </div>
                    <div class="cellDiv col4">
                        <?php echo $row['AnshDate'] ? date('d-m-Y', $row['AnshDate']) : '--'; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['BainamaArea'] ? $row['BainamaArea'] : '--'; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo format_rupees($row['LandAmount']); ?>
                    </div>
                    <div class="cellDiv col7">
                        <?php echo format_rupees($row['ParisampattiAmount']); ?>
                    </div>
                    <div class="cellDiv col8">
                        <?php echo format_rupees($row['BainamaAmount']); ?>
                    </div>
                    <div class="cellDiv col9">
                        <?php echo format_rupees($row['PaymentAmount']); ?>
                    </div>
                    <div class="cellDiv col10">
                        <?php echo $row['PaymentDate'] ? date('d-m-Y', $row['PaymentDate']) : '--'; ?>
                    </div>
                    <div class="cellDiv col11">
                        <a class="" title="Download Document" target="_blank" href="download?file=<?php echo base64_encode($file_name); ?>&type=<?php echo base64_encode('gata_ebasta'); ?>">
                            <div style="position: relative;">
                                <img src="img/download_1.svg" height="18px;">
                            </div>
                        </a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <input type="hidden" id="tCount" value="<?php echo $total_bainama_amount; ?>" autocomplete="off">
    </div>
    <?php
} else if ($dashboard_data == '5') {
    ?>
    <div class="rowDivHeader">
        <div class="cellDivHeader">
            <p>Village Name</p>
        </div>
        <div class="cellDivHeader">
            <p>Village Code</p>
        </div>
        <div class="cellDivHeader">
            <p>Vilekh Sankhya</p>
        </div>
        <div class="cellDivHeader">
            <p>Bainama Date</p>
        </div>
        <div class="cellDivHeader">
            <p>Bainama Area</p>
        </div>
        <div class="cellDivHeader">
            <p>Land Amount</p>
        </div>
        <div class="cellDivHeader">
            <p>Parisampatti Amount</p>
        </div>
        <div class="cellDivHeader">
            <p>Bainama Amount</p>
        </div>
        <div class="cellDivHeader">
            <p>Payment Amount</p>
        </div>
        <div class="cellDivHeader">
            <p>Payment Approval Date</p>
        </div>
        <div class="cellDivHeader">
            <p>Download</p>
        </div>
    </div>
    <div id="main-body" style="display: contents;">
        <div id="paginate-body" style="display: contents;">
            <?php
            $srno = 0;
            $total_payment_amount = 0;
            while ($row = $sql->fetch()) {
                $srno++;
                $ebasta_2 = json_decode($row['Ebasta2'], true);
                $file_name = $ebasta_2[0]['file_name'];
                $total_payment_amount += $row['PaymentAmount'];
                ?>
                <div class="rowDiv">
                    <div class="cellDiv col1">
                        <?php echo $row['VillageName']; ?>
                    </div>
                    <div class="cellDiv col2">
                        <?php echo $row['VillageCode']; ?>
                    </div>
                    <div class="cellDiv col3">
                        <?php echo $row['VilekhSankhya'] ? $row['VilekhSankhya'] : '--'; ?>
                    </div>
                    <div class="cellDiv col4">
                        <?php echo $row['AnshDate'] ? date('d-m-Y', $row['AnshDate']) : '--'; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['BainamaArea'] ? $row['BainamaArea'] : '--'; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo format_rupees($row['LandAmount']); ?>
                    </div>
                    <div class="cellDiv col7">
                        <?php echo format_rupees($row['ParisampattiAmount']); ?>
                    </div>
                    <div class="cellDiv col8">
                        <?php echo format_rupees($row['BainamaAmount']); ?>
                    </div>
                    <div class="cellDiv col9">
                        <?php echo format_rupees($row['PaymentAmount']); ?>
                    </div>
                    <div class="cellDiv col10">
                        <?php echo $row['PaymentDate'] ? date('d-m-Y', $row['PaymentDate']) : '--'; ?>
                    </div>
                    <div class="cellDiv col11">
                        <a class="" title="Download Document" target="_blank" href="download?file=<?php echo base64_encode($file_name); ?>&type=<?php echo base64_encode('gata_ebasta'); ?>">
                            <div style="position: relative;">
                                <img src="img/download_1.svg" height="18px;">
                            </div>
                        </a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <input type="hidden" id="tCount" value="<?php echo $total_payment_amount; ?>" autocomplete="off">
    </div>
    <?php
} else if ($dashboard_data == '6') {
    ?>
    <div class="rowDivHeader">
        <div class="cellDivHeader">
            <p>Village Name</p>
        </div>
        <div class="cellDivHeader">
            <p>Village Code</p>
        </div>
        <div class="cellDivHeader">
            <p>Vilekh Sankhya</p>
        </div>
        <div class="cellDivHeader">
            <p>Bainama Date</p>
        </div>
        <div class="cellDivHeader">
            <p>Bainama Area</p>
        </div>
        <div class="cellDivHeader">
            <p>Land Amount</p>
        </div>
        <div class="cellDivHeader">
            <p>Parisampatti Amount</p>
        </div>
        <div class="cellDivHeader">
            <p>Bainama Amount</p>
        </div>
        <div class="cellDivHeader">
            <p>Payment Amount</p>
        </div>
        <div class="cellDivHeader">
            <p>Payment Approval Date</p>
        </div>
        <div class="cellDivHeader">
            <p>Download</p>
        </div>
    </div>
    <div id="main-body" style="display: contents;">
        <div id="paginate-body" style="display: contents;">
            <?php
            $srno = 0;
            $total_left_amount = 0;
            while ($row = $sql->fetch()) {
                $srno++;
                $ebasta_2 = json_decode($row['Ebasta2'], true);
                $file_name = $ebasta_2[0]['file_name'];
                $total_left_amount += $row['BainamaAmount'] - $row['PaymentAmount'];
                ?>
                <div class="rowDiv">
                    <div class="cellDiv col1">
                        <?php echo $row['VillageName']; ?>
                    </div>
                    <div class="cellDiv col2">
                        <?php echo $row['VillageCode']; ?>
                    </div>
                    <div class="cellDiv col3">
                        <?php echo $row['VilekhSankhya'] ? $row['VilekhSankhya'] : '--'; ?>
                    </div>
                    <div class="cellDiv col4">
                        <?php echo $row['AnshDate'] ? date('d-m-Y', $row['AnshDate']) : '--'; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['BainamaArea'] ? $row['BainamaArea'] : '--'; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo format_rupees($row['LandAmount']); ?>
                    </div>
                    <div class="cellDiv col7">
                        <?php echo format_rupees($row['ParisampattiAmount']); ?>
                    </div>
                    <div class="cellDiv col8">
                        <?php echo format_rupees($row['BainamaAmount']); ?>
                    </div>
                    <div class="cellDiv col9">
                        <?php echo format_rupees($row['PaymentAmount']); ?>
                    </div>
                    <div class="cellDiv col10">
                        <?php echo $row['PaymentDate'] ? date('d-m-Y', $row['PaymentDate']) : '--'; ?>
                    </div>
                    <div class="cellDiv col11">
                        <a class="" title="Download Document" target="_blank" href="download?file=<?php echo base64_encode($file_name); ?>&type=<?php echo base64_encode('gata_ebasta'); ?>">
                            <div style="position: relative;">
                                <img src="img/download_1.svg" height="18px;">
                            </div>
                        </a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <input type="hidden" id="tCount" value="<?php echo $total_left_amount; ?>" autocomplete="off">
    </div>
    <?php
} else if ($dashboard_data == '7') {
    ?>
    <div class="rowDivHeader">
        <div class="cellDivHeader">
            <p>Village Name</p>
        </div>
        <div class="cellDivHeader">
            <p>Village Code</p>
        </div>
        <div class="cellDivHeader">
            <p>Vilekh Sankhya</p>
        </div>
        <div class="cellDivHeader">
            <p>Bainama Date</p>
        </div>
        <div class="cellDivHeader">
            <p>Bainama Area</p>
        </div>
        <div class="cellDivHeader">
            <p>Land Amount</p>
        </div>
        <div class="cellDivHeader">
            <p>Parisampatti Amount</p>
        </div>
        <div class="cellDivHeader">
            <p>Bainama Amount</p>
        </div>
        <div class="cellDivHeader">
            <p>Payment Amount</p>
        </div>
        <div class="cellDivHeader">
            <p>Payment Approval Date</p>
        </div>
        <div class="cellDivHeader">
            <p>Download</p>
        </div>
    </div>
    <div id="main-body" style="display: contents;">
        <div id="paginate-body" style="display: contents;">
            <?php
            $srno = 0;
            while ($row = $sql->fetch()) {
                $srno++;
                $ebasta_2 = json_decode($row['Ebasta2'], true);
                $file_name = $ebasta_2[0]['file_name'];
                ?>
                <div class="rowDiv">
                    <div class="cellDiv col1">
                        <?php echo $row['VillageName']; ?>
                    </div>
                    <div class="cellDiv col2">
                        <?php echo $row['VillageCode']; ?>
                    </div>
                    <div class="cellDiv col3">
                        <?php echo $row['VilekhSankhya'] ? $row['VilekhSankhya'] : '--'; ?>
                    </div>
                    <div class="cellDiv col4">
                        <?php echo $row['AnshDate'] ? date('d-m-Y', $row['AnshDate']) : '--'; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['BainamaArea'] ? $row['BainamaArea'] : '--'; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo format_rupees($row['LandAmount']); ?>
                    </div>
                    <div class="cellDiv col7">
                        <?php echo format_rupees($row['ParisampattiAmount']); ?>
                    </div>
                    <div class="cellDiv col8">
                        <?php echo format_rupees($row['BainamaAmount']); ?>
                    </div>
                    <div class="cellDiv col9">
                        <?php echo format_rupees($row['PaymentAmount']); ?>
                    </div>
                    <div class="cellDiv col10">
                        <?php echo $row['PaymentDate'] ? date('d-m-Y', $row['PaymentDate']) : '--'; ?>
                    </div>
                    <div class="cellDiv col11">
                        <a class="" title="Download Document" target="_blank" href="download?file=<?php echo base64_encode($file_name); ?>&type=<?php echo base64_encode('gata_ebasta'); ?>">
                            <div style="position: relative;">
                                <img src="img/download_1.svg" height="18px;">
                            </div>
                        </a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
}