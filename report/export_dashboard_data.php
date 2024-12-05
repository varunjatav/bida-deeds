<?php

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);

include_once '../config.php';
include_once '../includes/checkSession.php';
include_once '../includes/get_time_zone.php';
include_once '../dbcon/db_connect.php';
include_once '../functions/common.function.php';
include_once '../core/dashboardSummary.core.php';
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
    while ($row = $village_count->fetch()) {
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
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '2') {
    while ($row = $village_acquired->fetch()) {
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
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '3') {
    while ($row = $village_acquired->fetch()) {
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
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '4') {
    while ($row = $kashtkar_count_query->fetch()) {
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
} else if ($dashboard_data == '5') {
    while ($row = $khastkar_bainama_query->fetch()) {
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
} else if ($dashboard_data == '6') {
    while ($row = $village_acquired->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $khata_no = $row['KhataNo'] ? $row['KhataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $rakba = $row['AnshRakba'] ? $row['AnshRakba'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';
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
                $sheet->setCellValue($index . $count, $khata_no);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $rakba);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $shreni);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '7') {
    while ($row = $ch4145_count->fetch()) {
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
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '8') {
    while ($row = $village_acquired->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $khata_no = $row['KhataNo'] ? $row['KhataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $rakba = $row['AnshRakba'] ? $row['AnshRakba'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';
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
                $sheet->setCellValue($index . $count, $khata_no);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $rakba);
            } else if ($colVal == 7) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $owner_name);
            } else if ($colVal == 8) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $owner_father);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '9') {
    while ($row = $ch1359_count->fetch()) {
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
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '10') {
    while ($row = $village_count->fetch()) {
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
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '11') {
    while ($row = $ebasta_count->fetch()) {
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
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '12') {
    while ($row = $block17_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';

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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '13') {
    while ($row = $block17_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';

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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '14') {
    while ($row = $block17_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';

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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '15') {
    while ($row = $block17_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $khata_no = $row['KhataNo'] ? $row['KhataNo'] : '--';
        $owner_name = $row['owner_name'] ? $row['owner_name'] : '--';
        $owner_father = $row['owner_father'] ? $row['owner_father'] : '--';
        $rakba = $row['AnshRakba'] ? $row['AnshRakba'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        
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
                $sheet->setCellValue($index . $count, $rakba);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $shreni);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '16') {
    while ($row = $block31_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $khata_no = $row['KhataNo'] ? $row['KhataNo'] : '--';
        $rakba = $row['AnshRakba'] ? $row['AnshRakba'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        
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
                $sheet->setCellValue($index . $count, $rakba);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $shreni);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '17') {
    while ($row = $block17_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';

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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '18') {
    while ($row = $block17_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';

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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '19') {
    while ($row = $block17_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';

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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '20') {
    while ($row = $block30_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $rakba = $row['AnshRakba'] ? $row['AnshRakba'] : '--';
        $area = $row['GataArea'] ? $row['GataArea'] : '--';

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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $rakba);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '21') {
    while ($row = $block30_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $rakba = $row['AnshRakba'] ? $row['AnshRakba'] : '--';
        $area = $row['GataArea'] ? $row['GataArea'] : '--';

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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $rakba);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '22') {
    while ($row = $block30_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $rakba = $row['AnshRakba'] ? $row['AnshRakba'] : '--';
        $area = $row['GataArea'] ? $row['GataArea'] : '--';

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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $rakba);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '23') {
    while ($row = $block30_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $rakba = $row['AnshRakba'] ? $row['AnshRakba'] : '--';
        $area = $row['GataArea'] ? $row['GataArea'] : '--';

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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $rakba);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '24') {
    while ($row = $block29_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $vilekh_sankhya = $row['VilekhSankhya'] ? $row['VilekhSankhya'] : '--';
        $kashtkar = $row['KashtkarName'] ? $row['KashtkarName'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $gata_area = $row['GataArea'] ? $row['GataArea'] : '--';
        $rakba = $row['Rakba'] ? $row['Rakba'] : '--';
        $bank_name = $row['BankName'] ? $row['BankName'] : '--';
        $acc_no = $row['AccountNo'] ? $row['AccountNo'] : '--';
        $ifsc = $row['IFSC'] ? $row['IFSC'] : '--';
        $bainama_date = $row['BainamaDate'] ? $row['BainamaDate'] : '--';
        $amount = $row['Amount'] ? format_rupees($row['Amount']) : '--';

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
                $sheet->setCellValue($index . $count, $kashtkar);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $gata_no);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $gata_area);
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $rakba);
            } else if ($colVal == 7) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $bank_name);
            } else if ($colVal == 8) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $acc_no);
            } else if ($colVal == 9) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $ifsc);
            } else if ($colVal == 10) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $bainama_date);
            } else if ($colVal == 11) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $amount);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '25') {
    while ($row = $block29_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $kashtkar = $row['KashtkarName'] ? $row['KashtkarName'] : '--';
        $bank_name = $row['BankName'] ? $row['BankName'] : '--';
        $acc_no = $row['AccountNo'] ? $row['AccountNo'] : '--';
        $khata_no = $row['KhataNo'] ? $row['KhataNo'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $rakba = $row['Rakba'] ? $row['Rakba'] : '--';
        $bainama_date = $row['BainamaDate'] ? $row['BainamaDate'] : '--';
        $amount = $row['Amount'] ? format_rupees($row['Amount']) : '--';
        $txn_no = $row['TxnNo'] ? $row['TxnNo'] : '--';

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
                $sheet->setCellValue($index . $count, $kashtkar);
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $bank_name);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $acc_no);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $khata_no);
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $gata_no);
            } else if ($colVal == 7) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $rakba);
            } else if ($colVal == 8) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $bainama_date);
            } else if ($colVal == 9) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $amount);
            } else if ($colVal == 10) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $txn_no);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '26') {
    while ($row = $block9_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';

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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '27') {
    while ($row = $block9_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';

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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '28') {
    while ($row = $block9_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';

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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '29') {
    while ($row = $block9_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';

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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '30') {
    while ($row = $block9_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';

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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '31') {
    while ($row = $block9_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';

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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '32') {
    while ($row = $block9_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';

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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '33') {
    while ($row = $block9_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';

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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '34') {
    while ($row = $block9_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';

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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '35') {
    while ($row = $block9_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';

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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '36') {
    while ($row = $kashtkar_count_query->fetch()) {
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
} else if ($dashboard_data == '37') {
    while ($row = $block23_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';
        $kashtkar_count = $row['Count'] ? $row['Count'] : '--';

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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $kashtkar_count);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '38') {
    while ($row = $kashtkar_ansh_query->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';
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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $owner_name);
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $owner_father);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '39') {
    while ($row = $block17_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';

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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '40') {
    while ($row = $block24_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';

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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '41') {
    while ($row = $block24_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $khata_no = $row['KhataNo'] ? $row['KhataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';

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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '42') {
    while ($row = $block24_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $khata_no = $row['KhataNo'] ? $row['KhataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';

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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '43') {
    while ($row = $block24_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $khata_no = $row['KhataNo'] ? $row['KhataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';
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
                $sheet->setCellValue($index . $count, $khata_no);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $owner_name);
            } else if ($colVal == 7) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $owner_father);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '44') {
    while ($row = $block25_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $khata_no = $row['KhataNo'] ? $row['KhataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';

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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '45') {
    while ($row = $block25_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $khata_no = $row['KhataNo'] ? $row['KhataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';

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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '46') {
    while ($row = $block33_count->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $khata_no = $row['KhataNo'] ? $row['KhataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';
        $khate_me_fasali_ke_anusar_kism = $row['khate_me_fasali_ke_anusar_kism'] ? $row['khate_me_fasali_ke_anusar_kism'] : '--';

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
                $sheet->setCellValue($index . $count, $shreni);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $area);
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $khate_me_fasali_ke_anusar_kism);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '47') {
    while ($row = $kashtkar_ansh_query->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $khata_no = $row['KhataNo'] ? $row['KhataNo'] : '--';
        $shreni = $row['Shreni'] ? $row['Shreni'] : '--';
        $area = $row['Area'] ? $row['Area'] : '--';
        $khate_me_fasali_ke_anusar_kism = $row['khate_me_fasali_ke_anusar_kism'] ? $row['khate_me_fasali_ke_anusar_kism'] : '--';

        $hcount = 0;
        foreach ($column_arr as $colVal) {
            if ($colVal == 0) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['UID']);
            } else if ($colVal == 1) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $village_name);
            } else if ($colVal == 2) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $village_code);
            } else if ($colVal == 3) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $gata_no);
            } else if ($colVal == 4) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $khata_no);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Area'] ? $row['Area'] : '--');
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['OwnerNo'] ? $row['OwnerNo'] : '--');
            } else if ($colVal == 7) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['Shreni'] ? $row['Shreni'] : '--');
            } else if ($colVal == 8) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['RequiredArea'] ? $row['RequiredArea'] : '--');
            } else if ($colVal == 9) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['BoardApproved'] ? $row['BoardApproved'] : '--');
            } else if ($colVal == 10) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['HoldByDM'] ? $row['HoldByDM'] : '--');
            } else if ($colVal == 11) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['HoldByBIDA'] ? $row['HoldByBIDA'] : '--');
            } else if ($colVal == 12) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['HoldByNirdharan'] ? $row['HoldByNirdharan'] : '--');
            } else if ($colVal == 13) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['BinamaHoldByBIDA'] ? $row['BinamaHoldByBIDA'] : '--');
            } else if ($colVal == 14) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['ch41_45_ke_anusar_sreni'] ? $row['ch41_45_ke_anusar_sreni'] : '--');
            } else if ($colVal == 15) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['ch41_45_ke_anusar_rakba'] ? $row['ch41_45_ke_anusar_rakba'] : '--');
            } else if ($colVal == 16) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['fasali_ke_anusar_sreni'] ? $row['fasali_ke_anusar_sreni'] : '--');
            } else if ($colVal == 17) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['fasali_ke_anusar_rakba'] ? $row['fasali_ke_anusar_rakba'] : '--');
            } else if ($colVal == 18) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['khate_me_fasali_ke_anusar_kism'] ? $row['khate_me_fasali_ke_anusar_kism'] : '--');
            } else if ($colVal == 19) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['fasali_me_kastkar_darj_status'] ? $row['fasali_me_kastkar_darj_status'] : '--');
            } else if ($colVal == 20) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['parisampatti_by_lkp'] ? $row['parisampatti_by_lkp'] : '--');
            } else if ($colVal == 21) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['dispute_status'] ? $row['dispute_status'] : '--');
            } else if ($colVal == 22) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['dispute_court_name'] ? $row['dispute_court_name'] : '--');
            } else if ($colVal == 23) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['dispute_court_number'] ? $row['dispute_court_number'] : '--');
            } else if ($colVal == 24) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['stay_court_status'] ? $row['stay_court_status'] : '--');
            } else if ($colVal == 25) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['adhisuchana_ke_anusar_mauke_ki_stithi'] ? $row['adhisuchana_ke_anusar_mauke_ki_stithi'] : '--');
            } else if ($colVal == 26) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['gata_notification_status'] ? $row['gata_notification_status'] : '--');
            } else if ($colVal == 27) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['gata_map_not_field'] ? $row['gata_map_not_field'] : '--');
            } else if ($colVal == 28) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['nahar_map_but_kastkar'] ? $row['nahar_map_but_kastkar'] : '--');
            } else if ($colVal == 29) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['sadak_map_but_kastkar'] ? $row['sadak_map_but_kastkar'] : '--');
            } else if ($colVal == 30) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['total_tree'] ? $row['total_tree'] : '--');
            } else if ($colVal == 31) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['vartaman_circle_rate'] ? $row['vartaman_circle_rate'] : '--');
            } else if ($colVal == 32) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['agricultural_area'] ? $row['agricultural_area'] : '--');
            } else if ($colVal == 33) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['current_circle_rate'] ? $row['current_circle_rate'] : '--');
            } else if ($colVal == 34) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['agri_amount'] ? $row['agri_amount'] : '--');
            } else if ($colVal == 35) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['road_area'] ? $row['road_area'] : '--');
            } else if ($colVal == 36) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['road_rate'] ? $row['road_rate'] : '--');
            } else if ($colVal == 37) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['road_amount'] ? $row['road_amount'] : '--');
            } else if ($colVal == 38) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['aabadi_area'] ? $row['aabadi_area'] : '--');
            } else if ($colVal == 39) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['aabadi_rate'] ? $row['aabadi_rate'] : '--');
            } else if ($colVal == 40) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['aabadi_amount'] ? $row['aabadi_amount'] : '--');
            } else if ($colVal == 41) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['govt_amount'] ? $row['govt_amount'] : '--');
            } else if ($colVal == 42) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['land_total_amount'] ? $row['land_total_amount'] : '--');
            } else if ($colVal == 43) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['parisampatti_name'] ? $row['parisampatti_name'] : '--');
            } else if ($colVal == 44) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['total_parisampatti_amount'] ? $row['total_parisampatti_amount'] : '--');
            } else if ($colVal == 45) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['extra_2015_amount'] ? $row['extra_2015_amount'] : '--');
            } else if ($colVal == 46) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['total_land_and_parisampatti_amount'] ? $row['total_land_and_parisampatti_amount'] : '--');
            } else if ($colVal == 47) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['total_land_parisampati_amount_roundof'] ? $row['total_land_parisampati_amount_roundof'] : '--');
            } else if ($colVal == 48) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['exp_stamp_duty'] ? $row['exp_stamp_duty'] : '--');
            } else if ($colVal == 49) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['exp_nibandh_sulk'] ? $row['exp_nibandh_sulk'] : '--');
            } else if ($colVal == 50) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['lekhpal_pratilipi_tax'] ? $row['lekhpal_pratilipi_tax'] : '--');
            } else if ($colVal == 51) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['grand_total'] ? $row['grand_total'] : '--');
            } else if ($colVal == 52) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['last_year_bainama_circle_rate'] ? $row['last_year_bainama_circle_rate'] : '--');
            } else if ($colVal == 53) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['last_two_year_bainama_circle_rate'] ? $row['last_two_year_bainama_circle_rate'] : '--');
            } else if ($colVal == 54) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['vrihad_pariyojna'] ? $row['vrihad_pariyojna'] : '--');
            } else if ($colVal == 55) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['sc_st_kashtkar'] ? $row['sc_st_kashtkar'] : '--');
            } else if ($colVal == 56) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['dhara_98'] ? $row['dhara_98'] : '--');
            } else if ($colVal == 57) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $row['dhara_80_143'] ? $row['dhara_80_143'] : '--');
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '48') {
    while ($row = $khastkar_bainama_query->fetch()) {
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
} else if ($dashboard_data == '49') {
    while ($row = $khastkar_bainama_query->fetch()) {
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
} else if ($dashboard_data == '50') {
    while ($row = $khastkar_bainama_query->fetch()) {
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
} else if ($dashboard_data == '51') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $khata_no = $row['KhataNo'] ? $row['KhataNo'] : '--';
        $mortgaged_amount = $row['MortgagedAmount'] ? $row['MortgagedAmount'] : '--';

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
                $sheet->setCellValue($index . $count, $mortgaged_amount);
            } 
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '52') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
        $owner_name = $row['owner_name'] ? $row['owner_name'] : '--';
        $owner_father = $row['owner_father'] ? $row['owner_father'] : '--';
        $gata_no = $row['GataNo'] ? $row['GataNo'] : '--';
        $khata_no = $row['KhataNo'] ? $row['KhataNo'] : '--';
        $area = $row['KashtkarAnsh'] ? $row['Area'] : '--';
        $mortgaged_amount = $row['MortgagedAmount'] ? $row['MortgagedAmount'] : '--';

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
                $sheet->setCellValue($index . $count, $owner_name);
            } else if ($colVal == 6) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $owner_father);
            } else if ($colVal == 7) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $mortgaged_amount);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '53') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
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
                $sheet->setCellValue($index . $count, $ansh);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $rakba);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '54') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
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
                $sheet->setCellValue($index . $count, $ansh);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $rakba);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '55') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
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
                $sheet->setCellValue($index . $count, $ansh);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $rakba);
            }
            $hcount++;
        }
        $count++;
    }
} else if ($dashboard_data == '56') {
    while ($row = $sql->fetch()) {
        $village_name = $row['VillageName'] ? $row['VillageName'] : '--';
        $village_code = $row['VillageCode'] ? $row['VillageCode'] : '--';
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
                $sheet->setCellValue($index . $count, $ansh);
            } else if ($colVal == 5) {
                $index = columnFromIndex($hcount);
                $sheet->setCellValue($index . $count, $rakba);
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
