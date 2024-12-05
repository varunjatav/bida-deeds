<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/reportSummary.core.php';
?>
<?php
if ($report_data == '1') {
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
            <p>Shreni</p>
        </div>
        <div class="cellDivHeader">
            <p>fasali_ke_anusar_sreni</p>
        </div>
        <div class="cellDivHeader">
            <p>fasali_ke_anusar_rakba</p>
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
                        <?php echo $row['KhataNo']; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['Shreni']; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo $row['fasali_ke_anusar_sreni']; ?>
                    </div>
                    <div class="cellDiv col7">
                        <?php echo $row['fasali_ke_anusar_rakba']; ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else if ($report_data == '2') {
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
            <p>Shreni</p>
        </div>
        <div class="cellDivHeader">
            <p>ch41_45_ke_anusar_sreni</p>
        </div>
        <div class="cellDivHeader">
            <p>ch41_45_ke_anusar_rakba</p>
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
                        <?php echo $row['KhataNo']; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['Shreni']; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo $row['ch41_45_ke_anusar_sreni']; ?>
                    </div>
                    <div class="cellDiv col7">
                        <?php echo $row['ch41_45_ke_anusar_rakba']; ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else if ($report_data == '3') {
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
            <p>Shreni</p>
        </div>
        <div class="cellDivHeader">
            <p>khate_me_fasali_ke_anusar_kism</p>
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
                        <?php echo $row['KhataNo']; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['Shreni']; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo $row['khate_me_fasali_ke_anusar_kism']; ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else if ($report_data == '4') {
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
            <p>Shreni</p>
        </div>
        <div class="cellDivHeader">
            <p>ch41_45_ke_anusar_sreni</p>
        </div>
        <div class="cellDivHeader">
            <p>ch41_45_ke_anusar_rakba</p>
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
                        <?php echo $row['KhataNo']; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['Shreni']; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo $row['ch41_45_ke_anusar_sreni']; ?>
                    </div>
                    <div class="cellDiv col7">
                        <?php echo $row['ch41_45_ke_anusar_rakba']; ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else if ($report_data == '5') {
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
            <p>Shreni</p>
        </div>
        <div class="cellDivHeader">
            <p>Area</p>
        </div>
        <div class="cellDivHeader">
            <p>fasali_ke_anusar_sreni</p>
        </div>
        <div class="cellDivHeader">
            <p>fasali_ke_anusar_rakba</p>
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
                        <?php echo $row['KhataNo']; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['Shreni']; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo $row['Area']; ?>
                    </div>
                    <div class="cellDiv col7">
                        <?php echo $row['fasali_ke_anusar_sreni']; ?>
                    </div>
                    <div class="cellDiv col8">
                        <?php echo $row['fasali_ke_anusar_rakba']; ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else if ($report_data == '6') {
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
            <p>Shreni</p>
        </div>
        <div class="cellDivHeader">
            <p>Area</p>
        </div>
        <div class="cellDivHeader">
            <p>ch41_45_ke_anusar_sreni</p>
        </div>
        <div class="cellDivHeader">
            <p>ch41_45_ke_anusar_rakba</p>
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
                        <?php echo $row['KhataNo']; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['Shreni']; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo $row['Area']; ?>
                    </div>
                    <div class="cellDiv col7">
                        <?php echo $row['ch41_45_ke_anusar_sreni']; ?>
                    </div>
                    <div class="cellDiv col8">
                        <?php echo $row['ch41_45_ke_anusar_rakba']; ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else if ($report_data == '7') {
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
            <p>Shreni</p>
        </div>
        <div class="cellDivHeader">
            <p>Area</p>
        </div>
        <div class="cellDivHeader">
            <p>current_circle_rate</p>
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
                        <?php echo $row['KhataNo']; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['Shreni']; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo $row['Area']; ?>
                    </div>
                    <div class="cellDiv col7">
                        <?php echo $row['current_circle_rate']; ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else if ($report_data == '8') {
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
            <p>Shreni</p>
        </div>
        <div class="cellDivHeader">
            <p>Area</p>
        </div>
        <div class="cellDivHeader">
            <p>aabadi_rate</p>
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
                        <?php echo $row['KhataNo']; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['Shreni']; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo $row['Area']; ?>
                    </div>
                    <div class="cellDiv col7">
                        <?php echo $row['aabadi_rate']; ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else if ($report_data == '9') {
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
            <p>Shreni</p>
        </div>
        <div class="cellDivHeader">
            <p>Area</p>
        </div>
        <div class="cellDivHeader">
            <p>road_rate</p>
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
                        <?php echo $row['KhataNo']; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['Shreni']; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo $row['Area']; ?>
                    </div>
                    <div class="cellDiv col7">
                        <?php echo $row['road_rate']; ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else if ($report_data == '10') {
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
            <p>Shreni</p>
        </div>
        <div class="cellDivHeader">
            <p>Area</p>
        </div>
        <div class="cellDivHeader">
            <p>current_circle_rate</p>
        </div>
        <div class="cellDivHeader">
            <p>aabadi_rate</p>
        </div>
        <div class="cellDivHeader">
            <p>road_rate</p>
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
                        <?php echo $row['KhataNo']; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['Shreni']; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo $row['Area']; ?>
                    </div>
                    <div class="cellDiv col7">
                        <?php echo $row['current_circle_rate']; ?>
                    </div>
                    <div class="cellDiv col8">
                        <?php echo $row['aabadi_rate']; ?>
                    </div>
                    <div class="cellDiv col9">
                        <?php echo $row['road_rate']; ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else if ($report_data == '11') {
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
            <p>Shreni</p>
        </div>
        <div class="cellDivHeader">
            <p>Area</p>
        </div>
        <div class="cellDivHeader">
            <p>last_year_bainama_circle_rate</p>
        </div>
        <div class="cellDivHeader">
            <p>land_total_amount</p>
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
                        <?php echo $row['KhataNo']; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['Shreni']; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo $row['Area']; ?>
                    </div>
                    <div class="cellDiv col7">
                        <?php echo $row['last_year_bainama_circle_rate']; ?>
                    </div>
                    <div class="cellDiv col8">
                        <?php echo $row['land_total_amount']; ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else if ($report_data == '12') {
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
            <p>Shreni</p>
        </div>
        <div class="cellDivHeader">
            <p>Area</p>
        </div>
        <div class="cellDivHeader">
            <p>last_two_year_bainama_circle_rate</p>
        </div>
        <div class="cellDivHeader">
            <p>land_total_amount</p>
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
                        <?php echo $row['KhataNo']; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['Shreni']; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo $row['Area']; ?>
                    </div>
                    <div class="cellDiv col7">
                        <?php echo $row['last_two_year_bainama_circle_rate']; ?>
                    </div>
                    <div class="cellDiv col8">
                        <?php echo $row['land_total_amount']; ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else if ($report_data == '13') {
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
            <p>Shreni</p>
        </div>
        <div class="cellDivHeader">
            <p>Area</p>
        </div>
        <div class="cellDivHeader">
            <p>agricultural_area</p>
        </div>
        <div class="cellDivHeader">
            <p>land_total_amount</p>
        </div>
        <div class="cellDivHeader">
            <p>current_circle_rate</p>
        </div>
        <div class="cellDivHeader">
            <p>aabadi_rate</p>
        </div>
        <div class="cellDivHeader">
            <p>road_rate</p>
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
                        <?php echo $row['KhataNo']; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['Shreni']; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo $row['Area']; ?>
                    </div>
                    <div class="cellDiv col7">
                        <?php echo $row['agricultural_area']; ?>
                    </div>
                    <div class="cellDiv col8">
                        <?php echo $row['land_total_amount']; ?>
                    </div>
                    <div class="cellDiv col9">
                        <?php echo $row['current_circle_rate']; ?>
                    </div>
                    <div class="cellDiv col10">
                        <?php echo $row['aabadi_rate']; ?>
                    </div>
                    <div class="cellDiv col11">
                        <?php echo $row['road_rate']; ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else if ($report_data == '14') {
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
            <p>Shreni</p>
        </div>
        <div class="cellDivHeader">
            <p>Area</p>
        </div>
        <div class="cellDivHeader">
            <p>total_parisampatti_amount</p>
        </div>
        <div class="cellDivHeader">
            <p>land_total_amount</p>
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
                        <?php echo $row['KhataNo']; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['Shreni']; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo $row['Area']; ?>
                    </div>
                    <div class="cellDiv col7">
                        <?php echo $row['total_parisampatti_amount']; ?>
                    </div>
                    <div class="cellDiv col8">
                        <?php echo $row['land_total_amount']; ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else if ($report_data == '15') {
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
            <p>Shreni</p>
        </div>
        <div class="cellDivHeader">
            <p>Area</p>
        </div>
        <div class="cellDivHeader">
            <p>total_parisampatti_amount</p>
        </div>
        <div class="cellDivHeader">
            <p>land_total_amount</p>
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
                        <?php echo $row['KhataNo']; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['Shreni']; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo $row['Area']; ?>
                    </div>
                    <div class="cellDiv col7">
                        <?php echo $row['total_parisampatti_amount']; ?>
                    </div>
                    <div class="cellDiv col8">
                        <?php echo $row['land_total_amount']; ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else if ($report_data == '16') {
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
            <p>Area</p>
        </div>
        <div class="cellDivHeader">
            <p>Shreni</p>
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
                        <?php echo $row['KhataNo']; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['Area']; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo $row['Shreni']; ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else if ($report_data == '17') {
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
            <p>Area</p>
        </div>
        <div class="cellDivHeader">
            <p>Shreni</p>
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
                        <?php echo $row['KhataNo']; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['Area']; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo $row['Shreni']; ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else if ($report_data == '18') {
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
            <p>Area</p>
        </div>
        <div class="cellDivHeader">
            <p>Shreni</p>
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
                        <?php echo $row['KhataNo']; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['Area']; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo $row['Shreni']; ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else if ($report_data == '19') {
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
            <p>Area</p>
        </div>
        <div class="cellDivHeader">
            <p>Shreni</p>
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
                        <?php echo $row['KhataNo']; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['Area']; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo $row['Shreni']; ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else if ($report_data == '20') {
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
            <p>Area</p>
        </div>
        <div class="cellDivHeader">
            <p>Shreni</p>
        </div>
        <div class="cellDivHeader">
            <p>gata_map_not_field</p>
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
                        <?php echo $row['KhataNo']; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['Area']; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo $row['Shreni']; ?>
                    </div>
                    <div class="cellDiv col7">
                        <?php echo $row['gata_map_not_field']; ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else if ($report_data == '21') {
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
            <p>Area</p>
        </div>
        <div class="cellDivHeader">
            <p>Shreni</p>
        </div>
        <div class="cellDivHeader">
            <p>nahar_map_but_kastkar</p>
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
                        <?php echo $row['KhataNo']; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['Area']; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo $row['Shreni']; ?>
                    </div>
                    <div class="cellDiv col7">
                        <?php echo $row['nahar_map_but_kastkar']; ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else if ($report_data == '22') {
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
            <p>Area</p>
        </div>
        <div class="cellDivHeader">
            <p>Shreni</p>
        </div>
        <div class="cellDivHeader">
            <p>sadak_map_but_kastkar</p>
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
                        <?php echo $row['KhataNo']; ?>
                    </div>
                    <div class="cellDiv col5">
                        <?php echo $row['Area']; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo $row['Shreni']; ?>
                    </div>
                    <div class="cellDiv col7">
                        <?php echo $row['sadak_map_but_kastkar']; ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else if ($report_data == '23') {
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
            <p>Area</p>
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
                $ebasta_1 = json_decode($row['Ebasta2'], true);
                $file_name = $ebasta_1[0]['file_name'];
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
                        <?php echo $row['AnshRakba']; ?>
                    </div>
                    <div class="cellDiv col6">
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
} else if ($report_data == '24') {
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
            <p>Area</p>
        </div>
        <div class="cellDivHeader">
            <p>Current Circle Rate</p>
        </div>
        <div class="cellDivHeader">
            <p>Road Rate</p>
        </div>
        <div class="cellDivHeader">
            <p>Aabadi Rate</p>
        </div>
        <div class="cellDivHeader">
            <p>Bainama Amount</p>
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
                $ebasta_1 = json_decode($row['Ebasta2'], true);
                $file_name = $ebasta_1[0]['file_name'];
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
                        <?php echo $row['AnshRakba']; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php echo format_rupees($row['current_circle_rate']); ?>
                    </div>
                    <div class="cellDiv col7">
                        <?php echo format_rupees($row['road_rate']); ?>
                    </div>
                    <div class="cellDiv col8">
                        <?php echo format_rupees($row['aabadi_rate']); ?>
                    </div>
                    <div class="cellDiv col9">
                        <?php echo format_rupees($row['BainamaAmount']); ?>
                    </div>
                    <div class="cellDiv col10">
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
} else if ($report_data == '25') {
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
            <p>Vilekh Sankhya</p>
        </div>
        <div class="cellDivHeader">
            <p>Owner Name</p>
        </div>
        <div class="cellDivHeader">
            <p>Ansh Details</p>
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
                $ebasta_1 = json_decode($row['Ebasta2'], true);
                $file_name = $ebasta_1[0]['file_name'];
                $owner_names = array();
                $owner_fathers = array();
                $kashtkar_names = array();
                $kashtkar_ansh_info = array();
                $owner_names = explode(',', $row['owner_names']);
                $owner_fathers = explode(',', $row['owner_fathers']);
                $kashtkar_ka_ansh = explode(',', $row['KashtkarKaAnsh']);
                $ansh_ka_rakba = explode(',', $row['AnshKaRakba']);
                foreach ($owner_names as $key => $value) {
                    $kashtkar_names[] = $value . ' (' . $owner_fathers[$key] . ')';
                }
                foreach ($kashtkar_ka_ansh as $key => $value) {
                    $kashtkar_ansh_info[] = 'Ansh: (' . $value . ') Area: (' . $ansh_ka_rakba[$key] . ')';
                }
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
                        <?php echo $row['VilekhSankhya']; ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php
                        echo implode(',', $kashtkar_names);
                        ?>
                    </div>
                    <div class="cellDiv col6">
                        <?php
                        echo implode(', ', $kashtkar_ansh_info);
                        ?>
                    </div>
                    <div class="cellDiv col8">
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
} else if ($report_data == '26') {
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
            <p>Bainama Amount</p>
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
                $ebasta_1 = json_decode($row['Ebasta5'], true);
                $file_name = $ebasta_1[0]['file_name'];
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
                        <?php echo format_rupees($row['BainamaAmount']); ?>
                    </div>
                    <div class="cellDiv col5">
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