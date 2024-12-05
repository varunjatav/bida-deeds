<?php
include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/syncData.core.php';
if ($total_count == 0) {
    ?>
    <div class="blank-widget">
        <a>No Data Found</a>
    </div>
<?php } else { ?>
    <div id="paginate-body" style="display: contents;">
        <?php
        while ($row = $sql->fetch()) {
            ?>
            <div class="rowDiv">
                <div class="cellDiv col1">
                    <?php echo $row['UID'] ? $row['UID'] : '--'; ?>
                </div>
                <div class="cellDiv col2">
                    <?php echo $row['VillageName'] ? $row['VillageName'] : "--"; ?>
                </div>
                <div class="cellDiv col3">
                    <?php echo $row['VillageCode'] ? $row['VillageCode'] : "--"; ?>
                </div>
                <div class="cellDiv col4">
                    <?php echo $row['GataNo'] ? $row['GataNo'] : "--"; ?>
                </div>
                <div class="cellDiv col5">
                    <?php echo $row['KhataNo'] ? $row['KhataNo'] : '--'; ?>
                </div>
                <div class="cellDiv col6">
                    <?php echo $row['Area'] ? $row['Area'] : '--'; ?>
                </div>
                <div class="cellDiv col7">
                    <?php echo $row['OwnerNo'] ? $row['OwnerNo'] : '--'; ?>
                </div>
                <div class="cellDiv col8">
                    <?php echo $row['Shreni'] ? $row['Shreni'] : '--'; ?>
                </div>
                <div class="cellDiv col9">
                    <?php echo $row['RequiredArea'] ? $row['RequiredArea'] : '--'; ?>
                </div>
                <div class="cellDiv col10">
                    <?php echo $row['BoardApproved'] ? $row['BoardApproved'] : '--'; ?>
                </div>
                <div class="cellDiv col11">
                    <?php echo $row['HoldByDM'] ? $row['HoldByDM'] : '--'; ?>
                </div>
                <div class="cellDiv col12">
                    <?php echo $row['HoldByBIDA'] ? $row['HoldByBIDA'] : '--'; ?>
                </div>
                <div class="cellDiv col13">
                    <?php echo $row['HoldByNirdharan'] ? $row['HoldByNirdharan'] : '--'; ?>
                </div>
                <div class="cellDiv col14">
                    <?php echo $row['BinamaHoldByBIDA'] ? $row['BinamaHoldByBIDA'] : '--'; ?>
                </div>
                <div class="cellDiv col15">
                    <?php echo $row['ch41_45_ke_anusar_sreni'] ? $row['ch41_45_ke_anusar_sreni'] : '--'; ?>
                </div>
                <div class="cellDiv col16">
                    <?php echo $row['ch41_45_ke_anusar_rakba'] ? $row['ch41_45_ke_anusar_rakba'] : '--'; ?>
                </div>
                <div class="cellDiv col17">
                    <?php echo $row['fasali_ke_anusar_sreni'] ? $row['fasali_ke_anusar_sreni'] : '--'; ?>
                </div>
                <div class="cellDiv col18">
                    <?php echo $row['fasali_ke_anusar_rakba'] ? $row['fasali_ke_anusar_rakba'] : '--'; ?>
                </div>
                <div class="cellDiv col19">
                    <?php echo $row['khate_me_fasali_ke_anusar_kism'] ? $row['khate_me_fasali_ke_anusar_kism'] : '--'; ?>
                </div>
                <div class="cellDiv col20">
                    <?php echo $row['fasali_me_kastkar_darj_status'] ? $row['fasali_me_kastkar_darj_status'] : '--'; ?>
                </div>
                <div class="cellDiv col21">
                    <?php echo $row['parisampatti_by_lkp'] ? $row['parisampatti_by_lkp'] : '--'; ?>
                </div>                                        
                <div class="cellDiv col22">
                    <?php echo $row['dispute_status'] ? $row['dispute_status'] : '--'; ?>
                </div>
                <div class="cellDiv col23">
                    <?php echo $row['dispute_court_name'] ? $row['dispute_court_name'] : '--'; ?>
                </div>
                <div class="cellDiv col24">
                    <?php echo $row['dispute_court_number'] ? $row['dispute_court_number'] : '--'; ?>
                </div>
                <div class="cellDiv col25">
                    <?php echo $row['stay_court_status'] ? $row['stay_court_status'] : '--'; ?>
                </div>
                <div class="cellDiv col26">
                    <?php echo $row['adhisuchana_ke_anusar_mauke_ki_stithi'] ? $row['adhisuchana_ke_anusar_mauke_ki_stithi'] : '--'; ?>
                </div>
                <div class="cellDiv col27">
                    <?php echo $row['gata_notification_status'] ? $row['gata_notification_status'] : '--'; ?>
                </div>
                <div class="cellDiv col28">
                    <?php echo $row['gata_map_not_field'] ? $row['gata_map_not_field'] : '--'; ?>
                </div>
                <div class="cellDiv col29">
                    <?php echo $row['nahar_map_but_kastkar'] ? $row['nahar_map_but_kastkar'] : '--'; ?>
                </div>
                <div class="cellDiv col30">
                    <?php echo $row['sadak_map_but_kastkar'] ? $row['sadak_map_but_kastkar'] : '--'; ?>
                </div>
                <div class="cellDiv col31">
                    <?php echo $row['total_tree'] ? $row['total_tree'] : '--'; ?>
                </div>
                <div class="cellDiv col32">
                    <?php echo $row['vartaman_circle_rate'] ? $row['vartaman_circle_rate'] : '--'; ?>
                </div>
                <div class="cellDiv col33">
                    <?php echo $row['agricultural_area'] ? $row['agricultural_area'] : '--'; ?>
                </div>
                <div class="cellDiv col34">
                    <?php echo $row['current_circle_rate'] ? $row['current_circle_rate'] : '--'; ?>
                </div>
                <div class="cellDiv col35">
                    <?php echo $row['agri_amount'] ? $row['agri_amount'] : '--'; ?>
                </div>
                <div class="cellDiv col36">
                    <?php echo $row['road_area'] ? $row['road_area'] : '--'; ?>
                </div>
                <div class="cellDiv col37">
                    <?php echo $row['road_rate'] ? $row['road_rate'] : '--'; ?>
                </div>
                <div class="cellDiv col38">
                    <?php echo $row['road_amount'] ? $row['road_amount'] : '--'; ?>
                </div>
                <div class="cellDiv col39">
                    <?php echo $row['aabadi_area'] ? $row['aabadi_area'] : '--'; ?>
                </div>
                <div class="cellDiv col40">
                    <?php echo $row['aabadi_rate'] ? $row['aabadi_rate'] : '--'; ?>
                </div>
                <div class="cellDiv col41">
                    <?php echo $row['aabadi_amount'] ? $row['aabadi_amount'] : '--'; ?>
                </div>
                <div class="cellDiv col42">
                    <?php echo $row['govt_amount'] ? $row['govt_amount'] : '--'; ?>
                </div>
                <div class="cellDiv col43">
                    <?php echo $row['land_total_amount'] ? $row['land_total_amount'] : '--'; ?>
                </div>
                <div class="cellDiv col44">
                    <?php echo $row['parisampatti_name'] ? $row['parisampatti_name'] : '--'; ?>
                </div>
                <div class="cellDiv col45">
                    <?php echo $row['total_parisampatti_amount'] ? $row['total_parisampatti_amount'] : '--'; ?>
                </div>
                <div class="cellDiv col46">
                    <?php echo $row['extra_2015_amount'] ? $row['extra_2015_amount'] : '--'; ?>
                </div>
                <div class="cellDiv col47">
                    <?php echo $row['total_land_and_parisampatti_amount'] ? $row['total_land_and_parisampatti_amount'] : '--'; ?>
                </div>
                <div class="cellDiv col48">
                    <?php echo $row['total_land_parisampati_amount_roundof'] ? $row['total_land_parisampati_amount_roundof'] : '--'; ?>
                </div>
                <div class="cellDiv col49">
                    <?php echo $row['exp_stamp_duty'] ? $row['exp_stamp_duty'] : '--'; ?>
                </div>
                <div class="cellDiv col50">
                    <?php echo $row['exp_nibandh_sulk'] ? $row['exp_nibandh_sulk'] : '--'; ?>
                </div>
                <div class="cellDiv col51">
                    <?php echo $row['lekhpal_pratilipi_tax'] ? $row['lekhpal_pratilipi_tax'] : '--'; ?>
                </div>
                <div class="cellDiv col52">
                    <?php echo $row['grand_total'] ? $row['grand_total'] : '--'; ?>
                </div>
                <div class="cellDiv col53">
                    <?php echo $row['last_year_bainama_circle_rate'] ? $row['last_year_bainama_circle_rate'] : '--'; ?>
                </div>
                <div class="cellDiv col54">
                    <?php echo $row['last_two_year_bainama_circle_rate'] ? $row['last_two_year_bainama_circle_rate'] : '--'; ?>
                </div>
                <div class="cellDiv col55">
                    <?php echo $row['vrihad_pariyojna'] ? $row['vrihad_pariyojna'] : '--'; ?>
                </div>
                <div class="cellDiv col56">
                    <?php echo $row['sc_st_kashtkar'] ? $row['sc_st_kashtkar'] : '--'; ?>
                </div>
                <div class="cellDiv col57">
                    <?php echo $row['dhara_98'] ? $row['dhara_98'] : '--'; ?>
                </div>
                <div class="cellDiv col58">
                    <?php echo $row['dhara_80_143'] ? $row['dhara_80_143'] : '--'; ?>
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
        <div class="clr"></div>
    </div>
    <?php
}
?>
<input type="hidden" name="total_count" id="total_count" value="<?php echo $total_count; ?>" autocomplete="off">