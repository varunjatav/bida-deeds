<?php

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);

include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/newDashboardSummary.core.php';
include_once "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Add headers
$hcount = 0;
foreach ($column_head as $colValue) {
    $index = columnFromIndex($hcount);
    $sheet->setCellValue($index . '1', $colValue);
    $hcount++;
}

// Add rows
$count = 2;
if ($dashboard_data == '1') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $owner_name = $row['owner_name'] ? $row['owner_name'] : '--';
        $owner_father = $row['owner_father'] ? $row['owner_father'] : '--';

        $hcount = 0;
        foreach ($column_arr as $colVal) {
            if ($colVal == 0) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $village_name);
            } else if ($colVal == 1) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $village_code);
            } else if ($colVal == 2) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $gata_no);
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $owner_name);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $owner_father);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '2') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $khata_no = $row['KhataNo'] ? $row['KhataNo'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $total_land_and_parisampatti_amount = $row['total_land_and_parisampatti_amount'] ? $row['total_land_and_parisampatti_amount'] : '--';

        $hcount = 0;
        foreach ($column_arr as $colVal) {
            if ($colVal == 0) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $village_name);
            } else if ($colVal == 1) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $village_code);
            } else if ($colVal == 2) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $gata_no);
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $khata_no);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $total_land_and_parisampatti_amount);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '3') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $owner_name = $row['owner_name'] ? $row['owner_name'] : '--';
        $owner_father = $row['owner_father'] ? $row['owner_father'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $khata_no = $row['KhataNo'] ? $row['KhataNo'] : '--';
        $ansh = $row['KashtkarAnsh'] ? $row['KashtkarAnsh'] : '--';
        $rakba = $row['AnshRakba'] ? $row['AnshRakba'] : '--';

        $hcount = 0;
        foreach ($column_arr as $colVal) {
            if ($colVal == 0) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $village_name);
            } else if ($colVal == 1) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $village_code);
            } else if ($colVal == 2) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $gata_no);
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $khata_no);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $owner_name);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $owner_father);
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $ansh);
            } else if ($colVal == 7) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $rakba);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '4') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $vilekh_sankhya = $row['VilekhSankhya'] ? $row['VilekhSankhya'] : '--';
        $bainama_date = $row['AnshDate'] ? date('d-m-Y', $row['AnshDate']) : '--';
        $area = $row['Area'] ? $row['Area'] : '--';
        $land_amount = $row['LandAmount'] ? $row['LandAmount'] : '--';
        $pari_amount = $row['ParisampattiAmount'] ? $row['ParisampattiAmount'] : '--';
        $bainama_amount = $row['BainamaAmount'] ? $row['BainamaAmount'] : '--';
        $payment_amount = $row['PaymentAmount'] ? $row['PaymentAmount'] : '--';
        $payment_date = $row['PaymentDate'] ? date('d-m-Y', $row['PaymentDate']) : '--';

        $hcount = 0;
        foreach ($column_arr as $colVal) {
            if ($colVal == 0) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $village_name);
            } else if ($colVal == 1) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $village_code);
            } else if ($colVal == 2) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $vilekh_sankhya);
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $bainama_date);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $land_amount);
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $pari_amount);
            } else if ($colVal == 7) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $bainama_amount);
            } else if ($colVal == 8) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $payment_amount);
            } else if ($colVal == 9) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $payment_date);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '5') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $vilekh_sankhya = $row['VilekhSankhya'] ? $row['VilekhSankhya'] : '--';
        $bainama_date = $row['AnshDate'] ? date('d-m-Y', $row['AnshDate']) : '--';
        $area = $row['Area'] ? $row['Area'] : '--';
        $land_amount = $row['LandAmount'] ? $row['LandAmount'] : '--';
        $pari_amount = $row['ParisampattiAmount'] ? $row['ParisampattiAmount'] : '--';
        $bainama_amount = $row['BainamaAmount'] ? $row['BainamaAmount'] : '--';
        $payment_amount = $row['PaymentAmount'] ? $row['PaymentAmount'] : '--';
        $payment_date = $row['PaymentDate'] ? date('d-m-Y', $row['PaymentDate']) : '--';

        $hcount = 0;
        foreach ($column_arr as $colVal) {
            if ($colVal == 0) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $village_name);
            } else if ($colVal == 1) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $village_code);
            } else if ($colVal == 2) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $vilekh_sankhya);
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $bainama_date);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $land_amount);
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $pari_amount);
            } else if ($colVal == 7) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $bainama_amount);
            } else if ($colVal == 8) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $payment_amount);
            } else if ($colVal == 9) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $payment_date);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '6') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $vilekh_sankhya = $row['VilekhSankhya'] ? $row['VilekhSankhya'] : '--';
        $bainama_date = $row['AnshDate'] ? date('d-m-Y', $row['AnshDate']) : '--';
        $area = $row['Area'] ? $row['Area'] : '--';
        $land_amount = $row['LandAmount'] ? $row['LandAmount'] : '--';
        $pari_amount = $row['ParisampattiAmount'] ? $row['ParisampattiAmount'] : '--';
        $bainama_amount = $row['BainamaAmount'] ? $row['BainamaAmount'] : '--';
        $payment_amount = $row['PaymentAmount'] ? $row['PaymentAmount'] : '--';
        $payment_date = $row['PaymentDate'] ? date('d-m-Y', $row['PaymentDate']) : '--';

        $hcount = 0;
        foreach ($column_arr as $colVal) {
            if ($colVal == 0) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $village_name);
            } else if ($colVal == 1) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $village_code);
            } else if ($colVal == 2) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $vilekh_sankhya);
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $bainama_date);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $land_amount);
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $pari_amount);
            } else if ($colVal == 7) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $bainama_amount);
            } else if ($colVal == 8) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $payment_amount);
            } else if ($colVal == 9) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $payment_date);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '7') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $vilekh_sankhya = $row['VilekhSankhya'] ? $row['VilekhSankhya'] : '--';
        $bainama_date = $row['AnshDate'] ? date('d-m-Y', $row['AnshDate']) : '--';
        $area = $row['Area'] ? $row['Area'] : '--';
        $land_amount = $row['LandAmount'] ? $row['LandAmount'] : '--';
        $pari_amount = $row['ParisampattiAmount'] ? $row['ParisampattiAmount'] : '--';
        $bainama_amount = $row['BainamaAmount'] ? $row['BainamaAmount'] : '--';
        $payment_amount = $row['PaymentAmount'] ? $row['PaymentAmount'] : '--';
        $payment_date = $row['PaymentDate'] ? date('d-m-Y', $row['PaymentDate']) : '--';

        $hcount = 0;
        foreach ($column_arr as $colVal) {
            if ($colVal == 0) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $village_name);
            } else if ($colVal == 1) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $village_code);
            } else if ($colVal == 2) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $vilekh_sankhya);
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $bainama_date);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $land_amount);
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $pari_amount);
            } else if ($colVal == 7) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $bainama_amount);
            } else if ($colVal == 8) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $payment_amount);
            } else if ($colVal == 9) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $payment_date);
            }
            $hcount++;
        }
        $count++;
    }
}

$target_dir = dirname(dirname(__FILE__)) . "/" . $media_export . "/";
$file_name = 'dashboard_data_' . date('d_m_Y_H_i_s') . '.xlsx';
$filename = $target_dir . $file_name;

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=$filename');
header('Cache-Control: max-age=0');
$db_respose_data = json_encode(array('status' => '1', 'url' => base64_encode($file_name)));
print_r($db_respose_data);
exit();
