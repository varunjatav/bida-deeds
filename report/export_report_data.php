<?php

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);

include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/reportSummary.core.php';
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
if ($report_data == '1') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';

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
                $sheet->setCellValue($index . $count, $row['GataNo'] ? $row['GataNo'] : '--');
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['KhataNo'] ? $row['KhataNo'] : '--');
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Shreni'] ? $row['Shreni'] : '--');
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['fasali_ke_anusar_sreni'] ? $row['fasali_ke_anusar_sreni'] : '--');
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['fasali_ke_anusar_rakba'] ? $row['fasali_ke_anusar_rakba'] : '--');
            }
            $hcount++;
        }
        $count++;
    }
} else if ($report_data == '2') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';

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
                $sheet->setCellValue($index . $count, $row['GataNo'] ? $row['GataNo'] : '--');
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['KhataNo'] ? $row['KhataNo'] : '--');
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Shreni'] ? $row['Shreni'] : '--');
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['ch41_45_ke_anusar_sreni'] ? $row['ch41_45_ke_anusar_sreni'] : '--');
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['ch41_45_ke_anusar_rakba'] ? $row['ch41_45_ke_anusar_rakba'] : '--');
            }
            $hcount++;
        }
        $count++;
    }
} else if ($report_data == '3') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';

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
                $sheet->setCellValue($index . $count, $row['GataNo'] ? $row['GataNo'] : '--');
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['KhataNo'] ? $row['KhataNo'] : '--');
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Shreni'] ? $row['Shreni'] : '--');
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['khate_me_fasali_ke_anusar_kism'] ? $row['khate_me_fasali_ke_anusar_kism'] : '--');
            }
            $hcount++;
        }
        $count++;
    }
} else if ($report_data == '4') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';

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
                $sheet->setCellValue($index . $count, $row['GataNo'] ? $row['GataNo'] : '--');
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['KhataNo'] ? $row['KhataNo'] : '--');
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Shreni'] ? $row['Shreni'] : '--');
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['ch41_45_ke_anusar_sreni'] ? $row['ch41_45_ke_anusar_sreni'] : '--');
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['ch41_45_ke_anusar_rakba'] ? $row['ch41_45_ke_anusar_rakba'] : '--');
            }
            $hcount++;
        }
        $count++;
    }
} else if ($report_data == '5') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';

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
                $sheet->setCellValue($index . $count, $row['GataNo'] ? $row['GataNo'] : '--');
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['KhataNo'] ? $row['KhataNo'] : '--');
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Shreni'] ? $row['Shreni'] : '--');
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Area'] ? $row['Area'] : '--');
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['fasali_ke_anusar_sreni'] ? $row['fasali_ke_anusar_sreni'] : '--');
            } else if ($colVal == 7) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['fasali_ke_anusar_rakba'] ? $row['fasali_ke_anusar_rakba'] : '--');
            }
            $hcount++;
        }
        $count++;
    }
} else if ($report_data == '6') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';

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
                $sheet->setCellValue($index . $count, $row['GataNo'] ? $row['GataNo'] : '--');
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['KhataNo'] ? $row['KhataNo'] : '--');
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Shreni'] ? $row['Shreni'] : '--');
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Area'] ? $row['Area'] : '--');
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['ch41_45_ke_anusar_sreni'] ? $row['ch41_45_ke_anusar_sreni'] : '--');
            } else if ($colVal == 7) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['ch41_45_ke_anusar_rakba'] ? $row['ch41_45_ke_anusar_rakba'] : '--');
            }
            $hcount++;
        }
        $count++;
    }
} else if ($report_data == '7') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';

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
                $sheet->setCellValue($index . $count, $row['GataNo'] ? $row['GataNo'] : '--');
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['KhataNo'] ? $row['KhataNo'] : '--');
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Shreni'] ? $row['Shreni'] : '--');
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Area'] ? $row['Area'] : '--');
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['current_circle_rate'] ? $row['current_circle_rate'] : '--');
            }
            $hcount++;
        }
        $count++;
    }
} else if ($report_data == '8') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';

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
                $sheet->setCellValue($index . $count, $row['GataNo'] ? $row['GataNo'] : '--');
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['KhataNo'] ? $row['KhataNo'] : '--');
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Shreni'] ? $row['Shreni'] : '--');
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Area'] ? $row['Area'] : '--');
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['aabadi_rate'] ? $row['aabadi_rate'] : '--');
            }
            $hcount++;
        }
        $count++;
    }
} else if ($report_data == '9') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';

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
                $sheet->setCellValue($index . $count, $row['GataNo'] ? $row['GataNo'] : '--');
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['KhataNo'] ? $row['KhataNo'] : '--');
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Shreni'] ? $row['Shreni'] : '--');
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Area'] ? $row['Area'] : '--');
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['road_rate'] ? $row['road_rate'] : '--');
            }
            $hcount++;
        }
        $count++;
    }
} else if ($report_data == '10') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';

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
                $sheet->setCellValue($index . $count, $row['GataNo'] ? $row['GataNo'] : '--');
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['KhataNo'] ? $row['KhataNo'] : '--');
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Shreni'] ? $row['Shreni'] : '--');
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Area'] ? $row['Area'] : '--');
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['current_circle_rate'] ? $row['current_circle_rate'] : '--');
            } else if ($colVal == 7) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['aabadi_rate'] ? $row['aabadi_rate'] : '--');
            } else if ($colVal == 7) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['road_rate'] ? $row['road_rate'] : '--');
            }
            $hcount++;
        }
        $count++;
    }
} else if ($report_data == '11') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';

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
                $sheet->setCellValue($index . $count, $row['GataNo'] ? $row['GataNo'] : '--');
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['KhataNo'] ? $row['KhataNo'] : '--');
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Shreni'] ? $row['Shreni'] : '--');
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Area'] ? $row['Area'] : '--');
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['last_year_bainama_circle_rate'] ? $row['last_year_bainama_circle_rate'] : '--');
            } else if ($colVal == 7) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['land_total_amount'] ? $row['land_total_amount'] : '--');
            }
            $hcount++;
        }
        $count++;
    }
} else if ($report_data == '12') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';

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
                $sheet->setCellValue($index . $count, $row['GataNo'] ? $row['GataNo'] : '--');
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['KhataNo'] ? $row['KhataNo'] : '--');
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Shreni'] ? $row['Shreni'] : '--');
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Area'] ? $row['Area'] : '--');
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['last_two_year_bainama_circle_rate'] ? $row['last_two_year_bainama_circle_rate'] : '--');
            } else if ($colVal == 7) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['land_total_amount'] ? $row['land_total_amount'] : '--');
            }
            $hcount++;
        }
        $count++;
    }
} else if ($report_data == '13') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';

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
                $sheet->setCellValue($index . $count, $row['GataNo'] ? $row['GataNo'] : '--');
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['KhataNo'] ? $row['KhataNo'] : '--');
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Shreni'] ? $row['Shreni'] : '--');
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Area'] ? $row['Area'] : '--');
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['agricultural_area'] ? $row['agricultural_area'] : '--');
            } else if ($colVal == 7) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['land_total_amount'] ? $row['land_total_amount'] : '--');
            } else if ($colVal == 8) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['current_circle_rate'] ? $row['current_circle_rate'] : '--');
            } else if ($colVal == 9) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['aabadi_rate'] ? $row['aabadi_rate'] : '--');
            } else if ($colVal == 10) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['road_rate'] ? $row['road_rate'] : '--');
            }
            $hcount++;
        }
        $count++;
    }
} else if ($report_data == '14') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';

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
                $sheet->setCellValue($index . $count, $row['GataNo'] ? $row['GataNo'] : '--');
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['KhataNo'] ? $row['KhataNo'] : '--');
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Shreni'] ? $row['Shreni'] : '--');
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Area'] ? $row['Area'] : '--');
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['total_parisampatti_amount'] ? $row['total_parisampatti_amount'] : '--');
            } else if ($colVal == 7) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['land_total_amount'] ? $row['land_total_amount'] : '--');
            }
            $hcount++;
        }
        $count++;
    }
} else if ($report_data == '15') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';

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
                $sheet->setCellValue($index . $count, $row['GataNo'] ? $row['GataNo'] : '--');
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['KhataNo'] ? $row['KhataNo'] : '--');
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Shreni'] ? $row['Shreni'] : '--');
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Area'] ? $row['Area'] : '--');
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['total_parisampatti_amount'] ? $row['total_parisampatti_amount'] : '--');
            } else if ($colVal == 7) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['land_total_amount'] ? $row['land_total_amount'] : '--');
            }
            $hcount++;
        }
        $count++;
    }
} else if ($report_data == '16') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';

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
                $sheet->setCellValue($index . $count, $row['GataNo'] ? $row['GataNo'] : '--');
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['KhataNo'] ? $row['KhataNo'] : '--');
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Area'] ? $row['Area'] : '--');
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Shreni'] ? $row['Shreni'] : '--');
            }
            $hcount++;
        }
        $count++;
    }
} else if ($report_data == '17') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';

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
                $sheet->setCellValue($index . $count, $row['GataNo'] ? $row['GataNo'] : '--');
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['KhataNo'] ? $row['KhataNo'] : '--');
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Area'] ? $row['Area'] : '--');
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Shreni'] ? $row['Shreni'] : '--');
            }
            $hcount++;
        }
        $count++;
    }
} else if ($report_data == '18') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';

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
                $sheet->setCellValue($index . $count, $row['GataNo'] ? $row['GataNo'] : '--');
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['KhataNo'] ? $row['KhataNo'] : '--');
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Area'] ? $row['Area'] : '--');
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Shreni'] ? $row['Shreni'] : '--');
            }
            $hcount++;
        }
        $count++;
    }
} else if ($report_data == '19') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';

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
                $sheet->setCellValue($index . $count, $row['GataNo'] ? $row['GataNo'] : '--');
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['KhataNo'] ? $row['KhataNo'] : '--');
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Area'] ? $row['Area'] : '--');
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Shreni'] ? $row['Shreni'] : '--');
            }
            $hcount++;
        }
        $count++;
    }
} else if ($report_data == '20') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';

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
                $sheet->setCellValue($index . $count, $row['GataNo'] ? $row['GataNo'] : '--');
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['KhataNo'] ? $row['KhataNo'] : '--');
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Area'] ? $row['Area'] : '--');
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Shreni'] ? $row['Shreni'] : '--');
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['gata_map_not_field'] ? $row['gata_map_not_field'] : '--');
            }
            $hcount++;
        }
        $count++;
    }
} else if ($report_data == '21') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';

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
                $sheet->setCellValue($index . $count, $row['GataNo'] ? $row['GataNo'] : '--');
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['KhataNo'] ? $row['KhataNo'] : '--');
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Area'] ? $row['Area'] : '--');
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Shreni'] ? $row['Shreni'] : '--');
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['nahar_map_but_kastkar'] ? $row['nahar_map_but_kastkar'] : '--');
            }
            $hcount++;
        }
        $count++;
    }
} else if ($report_data == '22') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';

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
                $sheet->setCellValue($index . $count, $row['GataNo'] ? $row['GataNo'] : '--');
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['KhataNo'] ? $row['KhataNo'] : '--');
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Area'] ? $row['Area'] : '--');
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Shreni'] ? $row['Shreni'] : '--');
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['sadak_map_but_kastkar'] ? $row['sadak_map_but_kastkar'] : '--');
            }
            $hcount++;
        }
        $count++;
    }
} else if ($report_data == '23') {
    while ($row = $sql->fetch()) {
        $ebasta_1 = json_decode($row['Ebasta2'], true);
        $file_name = $ebasta_1[0]['file_name'];
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';

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
                $sheet->setCellValue($index . $count, $row['GataNo'] ? $row['GataNo'] : '--');
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['KhataNo'] ? $row['KhataNo'] : '--');
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['AnshRakba'] ? $row['AnshRakba'] : '--');
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $file_name);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($report_data == '24') {
    while ($row = $sql->fetch()) {
        $ebasta_1 = json_decode($row['Ebasta2'], true);
        $file_name = $ebasta_1[0]['file_name'];
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';

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
                $sheet->setCellValue($index . $count, $row['GataNo'] ? $row['GataNo'] : '--');
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['KhataNo'] ? $row['KhataNo'] : '--');
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['AnshRakba'] ? $row['AnshRakba'] : '--');
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['current_circle_rate'] ? $row['current_circle_rate'] : '0');
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['road_rate'] ? $row['road_rate'] : '0');
            } else if ($colVal == 7) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['aabadi_rate'] ? $row['aabadi_rate'] : '0');
            } else if ($colVal == 8) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['BainamaAmount'] ? $row['BainamaAmount'] : '0');
            } else if ($colVal == 9) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $file_name);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($report_data == '25') {
    while ($row = $sql->fetch()) {
        $ebasta_1 = json_decode($row['Ebasta2'], true);
        $file_name = $ebasta_1[0]['file_name'];
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
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
                $sheet->setCellValue($index . $count, $row['GataNo'] ? $row['GataNo'] : '--');
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['KhataNo'] ? $row['KhataNo'] : '--');
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['VilekhSankhya'] ? $row['VilekhSankhya'] : '--');
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, implode(',', $kashtkar_names));
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, implode(', ', $kashtkar_ansh_info));
            } else if ($colVal == 7) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $file_name);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($report_data == '26') {
    while ($row = $sql->fetch()) {
        $ebasta_1 = json_decode($row['Ebasta5'], true);
        $file_name = $ebasta_1[0]['file_name'];
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';

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
                $sheet->setCellValue($index . $count, $row['VilekhSankhya'] ? $row['VilekhSankhya'] : '--');
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['BainamaAmount'] ? $row['BainamaAmount'] : '0');
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $file_name);
            }
            $hcount++;
        }
        $count++;
    }
}

$target_dir = dirname(dirname(__FILE__)) . "/" . $media_export . "/";
$file_name = 'report_data_' . date('d_m_Y_H_i_s') . '.xlsx';
$filename = $target_dir . $file_name;

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=$filename');
header('Cache-Control: max-age=0');
$db_respose_data = json_encode(array('status' => '1', 'url' => base64_encode($file_name)));
print_r($db_respose_data);
exit();
