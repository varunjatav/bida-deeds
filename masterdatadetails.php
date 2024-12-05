<?php
include_once 'config.php';
include_once 'includes/checkSession.php';
include_once 'includes/get_time_zone.php';
include_once 'dbcon/db_connect.php';
include_once 'functions/common.function.php';
include_once 'core/permission.core.php';
include_once 'core/masterDataDetails.core.php';
include_once 'languages/' . $lang_file;
?>
<!doctype html>

<head>
    <meta charset="UTF-8">
    <title>DGMS</title>
    <link href="css/stylus.css" rel="stylesheet" type="text/css">
    <link href="css/common_master.css" rel="stylesheet" type="text/css">
    <link href="css/font.css" rel="stylesheet" type="text/css">
    <link href="css/jquery-ui.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/style.css">
    <script src="scripts/jquery.min.js"></script>
    <script>
        document.write('<style type="text/css">body{display:none}</style>');
        jQuery(function (a) {
            a("body").css("display", "block");
        });
    </script>
</head>
<style>
    .popup-cnftop {
        background: #2F232B;
        padding: 10px;
    }
</style>

<body>
    <?php include "includes/header.php"; ?>
    <div id="appendFilter"></div>
    <div class="wrapper">
        <div class="col-wrapper">
            <?php include "includes/sidebarmenu.php"; ?>
            <div class="full-column db-cont-wrap right  dev_wrap">
                <div class="column-head">
                    <div class="left pageback" style="display:flex;">
                        <a style="cursor: pointer;" onclick="history.go(-1)">
                            <img src="img/back.svg" alt="" width="18px">
                        </a>
                        <div class="col-pagename left"><?php echo $master_data_details['title']; ?> <?php echo $data['GataNo'] ;?>
                        </div>
                        <div class="clr"></div>
                    </div>
                    <?php if ($data['tehsildar_validate_status'] == 0) { ?>
                        <form id="frm">
                            <div class="master-creation right" style="margin-left:10px;">
                                <div class="posabsolut act_btn_ovrly"></div>
                                <a style="cursor:pointer;" class="tehsildar_validate">
                                    <span class="crticn"></span>
                                    <span class="crtxt"><?php echo $master_data_details['validate']; ?></span>
                                    <div class="clr"></div>
                                </a>
                            </div>
                            <div class="frm_hidden_data"></div> 
                            <input type="hidden" name="file_id" value="<?php echo $_REQUEST['id']; ?>" autocomplete="off">
                        </form>
                    <?php } else { ?>
                        <div class="master-creation right" style="margin-left:10px;">
                            <div class="posabsolut act_btn_ovrly"></div>
                            <span class="crticn"></span>
                            <span class="crtxt" style="color:red;"><?php echo $master_data_details['validate_message']; ?> <?php echo date('d-m-Y', $data['update_date']); ?></span>
                            <div class="clr"></div>
                        </div>
                    <?php } ?>
                    <div id="notify"></div>
                    <?php if ($data['tehsildar_validate_status'] != 1) { ?>
                        <div class="master-creation right">
                            <div class="posabsolut act_btn_ovrly"></div>
                            <a style="cursor:pointer;" class="edit_file" id="<?php echo myUrlEncode($_REQUEST['id']); ?>">
                                <span class="crticn"><img src="img/edit.svg" alt="" width="16px"></span>
                                <span class="crtxt"><?php echo $master_data_details['edit']; ?></span>
                                <div class="clr"></div>
                            </a>
                        </div>
                    <?php } ?>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>

                <div class="scrl-tblwrap">
                    <div class="col-pagename"><?php echo $master_data_details['sub_title']; ?></div>
                    <div class="clr"></div>  
                    <div class="containerDiv">
                        <div class="rowDivHeader">
                            <div class="cellDivHeader">
                                <p><?php echo $master_data_details['kashtkar_name']; ?></p></a>
                            </div>
                            <div class="cellDivHeader">
                                <p><?php echo $master_data_details['father_name']; ?></p></a>
                            </div>
                            <div class="cellDivHeader">
                                <p><?php echo $master_data_details['rakba']; ?></p></a>
                            </div>
                        </div>
                        <div id="main-body" style="display: contents;">
                            <div id="paginate-body" style="display: contents;">
                                <?php foreach ($kastakar_details as $key => $val) { ?>
                                    <div class="rowDiv <?php echo $color; ?>">
                                        <div class="cellDiv col1">
                                            <?php echo $val; ?>
                                        </div>
                                        <div class="cellDiv col2">
                                            <?php echo $owner_father[$key]; ?>
                                        </div>
                                        <div class="cellDiv col2">
                                            <?php echo $Kashtkar_Area[$key]; ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-pagename"><?php echo $master_data_details['gata_details']; ?></div>
                    <div class="clr"></div>
                    <div class="containerDiv">
                        <div class="rowDivHeader">
                            <!--                            <div class="cellDivHeader">
                                                            <p>Label</p></a>
                                                        </div>-->
                            <!--                            <div class="cellDivHeader">
                                                            <p>Value</p></a>
                                                        </div>-->
                        </div>
                        <div id="main-body" style="display: contents;">
                            <div id="paginate-body" style="display: contents;">

                                <div class="rowDiv <?php echo $color; ?>">
                                    <div class="cellDiv col1">
                                        <b><?php echo $master_data_details['sr']; ?></b>
                                    </div>
                                    <div class="cellDiv col2">
                                        <?php echo $data['UID']; ?>
                                    </div>
                                </div>
                                <div class="rowDiv <?php echo $color; ?>">
                                    <div class="cellDiv col1">
                                        <b><?php echo $master_data_details['village_name']; ?></b>
                                    </div>
                                    <div class="cellDiv col2">
                                        <?php echo $data['VillageName']; ?>
                                    </div>
                                </div>
                                <div class="rowDiv <?php echo $color; ?>">
                                    <div class="cellDiv col1">
                                        <b><?php echo $master_data_details['shreni']; ?></b>
                                    </div>
                                    <div class="cellDiv col2">
                                        <?php echo $data['Shreni']; ?>
                                    </div>
                                </div>
                                <div class="rowDiv <?php echo $color; ?>">
                                    <div class="cellDiv col1">
                                        <b><?php echo $master_data_list['rakba']; ?></b>
                                    </div>
                                    <div class="cellDiv col2">
                                        <?php echo $data['Area']; ?>
                                    </div>
                                </div>
<!--                                <div class="rowDiv <?php echo $color; ?>">
                                    <div class="cellDiv col1">
                                        <b><?php //echo $master_data_details['village_code'];      ?></b>
                                    </div>
                                    <div class="cellDiv col2">
                                <?php //echo $data['VillageCode']; ?>
                                    </div>
                                </div>-->
<!--                                <div class="rowDiv <?php echo $color; ?>">
                                    <div class="cellDiv col1">
                                        <b><?php //echo $master_data_details['gata_no'];      ?></b>
                                    </div>
                                    <div class="cellDiv col2">
                                <?php //echo $data['GataNo']; ?>
                                    </div>
                                </div>-->
                                <div class="rowDiv <?php echo $color; ?>">
                                    <div class="cellDiv col1">
                                        <b><?php echo $master_data_details['khata_no']; ?></b>
                                    </div>
                                    <div class="cellDiv col2">
                                        <?php echo $data['KhataNo']; ?>
                                    </div>
                                </div>
                                <div class="rowDiv <?php echo $color; ?>">
                                    <div class="cellDiv col1">
                                        <b><?php echo $master_data_details['area_required']; ?></b>
                                    </div>
                                    <div class="cellDiv col2">
                                        <?php echo $data['RequiredArea']; ?>
                                    </div>
                                </div>
                                <div class="rowDiv <?php echo $color; ?>">
                                    <div class="cellDiv col1">
                                        <b><?php echo $master_data_details['board_approved']; ?></b>
                                    </div>
                                    <div class="cellDiv col2">
                                        <?php echo $data['BoardApproved']; ?>
                                    </div>
                                </div>
                                <?php if ($chakbandi_status_array == 1) { ?>
                                    <div class="rowDiv <?php echo $color; ?>">
                                        <div class="cellDiv col1">
                                            <b><?php echo $master_data_details['shreni_4145']; ?></b>
                                        </div>
                                        <div class="cellDiv col2">
                                            <?php echo $data['ch41_45_ke_anusar_sreni']; ?>
                                        </div>
                                    </div>
                                    <div class="rowDiv <?php echo $color; ?>">
                                        <div class="cellDiv col1">
                                            <b><?php echo $master_data_details['rakba_4145']; ?></b>
                                        </div>
                                        <div class="cellDiv col2">
                                            <?php echo $data['ch41_45_ke_anusar_rakba']; ?>
                                        </div>
                                    </div>
                                <?php } else If ($chakbandi_status_array == 0) { ?>
                                    <div class="rowDiv <?php echo $color; ?>">
                                        <div class="cellDiv col1">
                                            <b><?php echo $master_data_details['shreni_1359']; ?></b>
                                        </div>
                                        <div class="cellDiv col2">
                                            <?php echo $data['fasali_ke_anusar_sreni']; ?>
                                        </div>
                                    </div>
                                    <div class="rowDiv <?php echo $color; ?>">
                                        <div class="cellDiv col1">
                                            <b><?php echo $master_data_details['rakba_1359']; ?></b>
                                        </div>
                                        <div class="cellDiv col2">
                                            <?php echo $data['fasali_ke_anusar_rakba']; ?>
                                        </div>
                                    </div>
                                    <div class="rowDiv <?php echo $color; ?>">
                                        <div class="cellDiv col1">
                                            <b><?php echo $master_data_details['khate_me_fasli_kism']; ?></b>
                                        </div>
                                        <div class="cellDiv col2">
                                            <?php echo $data['khate_me_fasali_ke_anusar_kism']; ?>
                                        </div>
                                    </div>
                                    <div class="rowDiv <?php echo $color; ?>">
                                        <div class="cellDiv col1">
                                            <b><?php echo $master_data_details['kashtkar_darj_status']; ?></b>
                                        </div>
                                        <div class="cellDiv col2">
                                            <?php echo $data['fasali_me_kastkar_darj_status']; ?>
                                        </div>
                                    </div>
                                    <div class="rowDiv ">
                                        <div class="cellDiv col1">
                                            <b><?php echo $edit_master_data_details['original_gata_fasli_khatauni_1359']; ?></b>
                                        </div>
                                        <div class="cellDiv col2">
                                            <?php echo $data['1359_phasalee_khataunee_mein_mool_gaata']; ?>
                                        </div>
                                    </div>
                                <?php } ?>
<!--                                <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['gata_hold_by_DM']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['HoldByDM']; ?>
                            </div>
                        </div>-->
<!--                                <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['gata_hold_by_bida']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['HoldByBIDA']; ?>
                            </div>
                        </div>-->
                        <!-- <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b>Adhisuchna ke Anusar Mauke k Stithi</b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['UID']; ?>
                            </div>
                        </div> -->
<!--                                <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['agricultural_area']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['agricultural_area']; ?>
                            </div>
                        </div>-->
<!--                                <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['current_circle_rate']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['current_circle_rate']; ?>
                            </div>
                        </div>-->
<!--                                <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['agri_amount']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['agri_amount']; ?>
                            </div>
                        </div>-->
<!--                                <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['road_area']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['road_area']; ?>
                            </div>
                        </div>-->
<!--                                <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['road_rate']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['road_rate']; ?>
                            </div>
                        </div>-->
<!--                                <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['road_amount']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['road_amount']; ?>
                            </div>
                        </div>-->
<!--                                <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['aadbadi_area']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['aabadi_area']; ?>
                            </div>
                        </div>-->
<!--                                <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['aadbadi_rate']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['aabadi_rate']; ?>
                            </div>
                        </div>-->
<!--                                <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['abadi_amount']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['aabadi_amount']; ?>
                            </div>
                        </div>-->
<!--                                <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['goverment_amount']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['govt_amount']; ?>
                            </div>
                        </div>-->
<!--                                <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['land_total_amount']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['land_total_amount']; ?>
                            </div>
                        </div>-->
<!--                                <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['parisampatti_name']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['parisampatti_name']; ?>
                            </div>
                        </div>-->
<!--                                <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['total_parisampatti_amount']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['total_parisampatti_amount']; ?>
                            </div>
                        </div>-->
<!--                                <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['extra_2015_amount']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['extra_2015_amount']; ?>
                            </div>
                        </div>-->
<!--                                <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['total_land_and_parisampatti_amount']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['total_land_and_parisampatti_amount']; ?>
                            </div>
                        </div>-->
<!--                                <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['total_land_parisampatti_amount_roudoff']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['total_land_parisampati_amount_roundof']; ?>
                            </div>
                        </div>-->
<!--                                <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['exp_stamp_duty']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['exp_stamp_duty']; ?>
                            </div>
                        </div>-->
<!--                                <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['exp_nibandh_sulk']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['exp_nibandh_sulk']; ?>
                            </div>
                        </div>-->
<!--                                <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['lekhpal_pratilipi_tax']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['lekhpal_pratilipi_tax']; ?>
                            </div>
                        </div>-->
<!--                                <div class="rowDiv <?php echo $color; ?>">
                            <div class="cellDiv col1">
                                <b><?php echo $master_data_details['grand_total']; ?></b>
                            </div>
                            <div class="cellDiv col2">
                                <?php echo $data['grand_total']; ?>
                            </div>
                        </div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="name_order" value="asc">
            <div class="clr"></div>
            <?php include "includes/footer.php"; ?>
        </div>
    </div>
    <div id="notify"></div>
    <div id="saveFilter" class="hide"></div>
</body>
<script type="text/javascript">
    var validateMessageConfirmation = <?php echo json_encode($validate_message_confirmation); ?>;
</script>
<script src="scripts/jquery-ui.min.js"></script>
<script src="scripts/jquery.confirm.js"></script>
<script src="scripts/common.js"></script>
<script src="scripts/masterdatalist.js"></script>