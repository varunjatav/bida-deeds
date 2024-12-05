<?php

$script_file_name = basename($_SERVER['SCRIPT_FILENAME']);
include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.php';
include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/vendor/autoload.php';
include_once dirname(dirname(dirname(__FILE__))) . '/apiAccess.php';
$api_validate = 1; //apiValidate($_REQUEST, $script_file_name);

if ($api_validate == 1) {
    include_once dirname(dirname(dirname(__FILE__))) . '/get_time_zone.php';
    include_once dirname(dirname(dirname(__FILE__))) . '/common_functions.php';
    include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/dbcon/db_connect.php';

    $village_code = $_REQUEST['village_code'];
    $user_id = $_REQUEST['userid'];

    if ($user_id && $village_code) {

        $count = 1;
        $answer_1 = 0;
        $answer_2 = 0;
        $answer_6 = 0;
        $answer_7 = 0;
        $answer_8 = 0;
        $answer_9 = 0;
        $answer_10 = 0;
        $answer_11 = 0;
        $answer_12 = 0;
        $answer_13 = 0;
        $answer_14 = 0;
        $answer_15 = 0;
        $answer_16 = 0;
        $answer_17 = 0;
        $answer_18 = 0;
        $answer_19 = 0;
        $answer_20 = 0;
        $answer_21 = 0;
        $answer_22 = 0;
        $answer_23 = 0;
        $answer_24 = 0;
        $answer_25 = 0;
        $answer_26 = 0;
        $answer_27 = 0;
        $answer_28 = 0;
        $answer_29 = 0;
        $answer_15_count = 0;
        $answer_info_1 = 0;
        $answer_color_1 = 0;
        $answer_color_2 = 0;
        $answer_info_2 = 0;
        $answer_color_6 = 0;
        $answer_info_6 = 0;
        $answer_color_7 = 0;
        $answer_info_7 = 0;
        $answer_color_8 = 0;
        $answer_info_8 = 0;
        $answer_color_10 = 0;
        $answer_info_10 = 0;

        $chakbandi_query = $db->prepare("SELECT T1.VillageCode,
                                        SUM(CASE
                                        WHEN (T1.ch41_45_ke_anusar_rakba != ? AND T1.ch41_45_ke_anusar_rakba != ?) THEN 1
                                        ELSE 0
                                        END) AS Count
                                FROM lm_gata T1
                                WHERE T1.VillageCode = ?
                                GROUP BY T1.VillageCode
                                HAVING Count > 0
                                ");
        $chakbandi_query->bindValue(1, '');
        $chakbandi_query->bindValue(2, '--');
        $chakbandi_query->bindParam(3, $village_code);
        $chakbandi_query->execute();
        $chakbandi_query->setFetchMode(PDO::FETCH_ASSOC);
        $chakbandi_status_array = array();
        while ($row = $chakbandi_query->fetch()) {
            $chakbandi_status_array[] = $row['VillageCode'];
        }

        $village_query = $db->prepare("SELECT T1.*, T2.VillageName
                                FROM lm_gata T1
                                LEFT JOIN lm_village T2 ON T2.VillageCode = T1.VillageCode
                                WHERE T1.BoardApproved = ?
                                AND T1.VillageCode = ?
                                ");
        $village_query->bindValue(1, 'YES');
        $village_query->bindParam(2, $village_code);
        $village_query->execute();
        $village_query->setFetchMode(PDO::FETCH_ASSOC);
        $village_count = $village_query->rowCount();
        if ($village_count > 0) {
            while ($gataInfo = $village_query->fetch()) {
                if ($gataInfo['fasali_ke_anusar_sreni'] != '--' || $gataInfo['fasali_ke_anusar_rakba'] > 0) {
                    
                } else {
                    $answer_1++;
                }

                /*                 * ********* */
                if (in_array($gataInfo['VillageCode'], $chakbandi_status_array)) {
                    if ((float) $gataInfo['ch41_45_ke_anusar_rakba']) {
                        
                    } else {
                        $answer_2++;
                    }
                }

                /*                 * ********* */
                if ($gataInfo['Shreni'] == '1-क' && $gataInfo['khate_me_fasali_ke_anusar_kism'] != '--') {
                    //$var = array_keys(explode('(', $gataInfo['khate_me_fasali_ke_anusar_kism']));
                    $data = strtolower($gataInfo['khate_me_fasali_ke_anusar_kism']);
                    if (str_contains($data, 'nala') || str_contains($data, 'nali') || str_contains($data, 'pathar') || str_contains($data, 'patthar') || str_contains($data, 'paatthar') || str_contains($data, 'paathar') || str_contains($data, 'pathaar') || str_contains($data, 'pahad') || str_contains($data, 'paahaad') || str_contains($data, 'pahaad') || str_contains($data, 'paahad') || str_contains($data, 'pukhariya') || str_contains($data, 'pokhar') || str_contains($data, 'talab') || str_contains($data, 'dev sthan') || str_contains($data, 'khaliyan') || str_contains($data, 'khalihan') || str_contains($data, 'rasta') || str_contains($data, 'rashta') || str_contains($data, 'gochar') || str_contains($data, 'chakroad') || str_contains($data, 'chakmarg') || str_contains($data, 'jhadi') || str_contains($data, 'aabadi') || str_contains($data, 'abadi') || str_contains($data, 'abaadi') || str_contains($data, 'nadi') || str_contains($data, 'nahar') || str_contains($data, 'tauriya') || str_contains($data, 'jangal') || str_contains($data, 'van')) {
                        $answer_6++;
                    } else {
                        
                    }
                } else {
                    
                }

                /*                 * ********* */
                if (in_array($gataInfo['VillageCode'], $chakbandi_status_array)) {
                    if ($gataInfo['ch41_45_ke_anusar_sreni'] != '--') {
                        if (substr($gataInfo['ch41_45_ke_anusar_sreni'], 0, 1) == substr($gataInfo['Shreni'], 0, 1)) {
                            
                        } else {
                            $answer_7++;
                        }
                    } else {
                        
                    }
                }

                /*                 * ********* */
                if ((float) $gataInfo['fasali_ke_anusar_rakba']) {
                    if ((float) $gataInfo['Area'] == (float) $gataInfo['fasali_ke_anusar_rakba']) {
                        
                    } else {
                        $answer_8++;
                    }
                }

                /*                 * ********* */
                if (in_array($gataInfo['VillageCode'], $chakbandi_status_array)) {
                    if ((float) $gataInfo['ch41_45_ke_anusar_rakba']) {
                        if ((float) $gataInfo['Area'] == (float) $gataInfo['ch41_45_ke_anusar_rakba']) {
                            
                        } else {
                            $answer_10++;
                        }
                    }
                }

                /*                 * ********* */
                if ((float) $gataInfo['current_circle_rate'] > 0) {
                    $answer_15_count++;
                } else {
                    $answer_12++;
                }

                /*                 * ********* */
                if ((float) $gataInfo['aabadi_rate'] > 0) {
                    $answer_15_count++;
                } else {
                    $answer_13++;
                }

                /*                 * ********* */
                if ((float) $gataInfo['road_rate'] > 0) {
                    $answer_15_count++;
                } else {
                    $answer_14++;
                }

                /*                 * ********* */
                if (((float) $gataInfo['current_circle_rate'] > 0 && (float) $gataInfo['aabadi_rate'] > 0) || ((float) $gataInfo['aabadi_rate'] > 0 && (float) $gataInfo['road_rate'] > 0) || ((float) $gataInfo['current_circle_rate'] > 0 && (float) $gataInfo['road_rate'] > 0)) {
                    $answer_15++;
                } else {
                    
                }

                /*                 * ********* */
                if ((float) $gataInfo['land_total_amount']) {
                    if ((float) $gataInfo['last_year_bainama_circle_rate'] > ((float) $gataInfo['land_total_amount'] / 4)) {
                        $answer_16++;
                    } else {
                        
                    }
                } else {
                    
                }

                /*                 * ********* */
                if ((float) $gataInfo['land_total_amount']) {
                    if ((float) $gataInfo['last_two_year_bainama_circle_rate'] > ((float) $gataInfo['land_total_amount'] / 4)) {
                        $answer_17++;
                    } else {
                        
                    }
                } else {
                    
                }

                /*                 * ********* */
                if ((float) $gataInfo['land_total_amount']) {
                    $data = (float) $gataInfo['agricultural_area'] ? ((float) $gataInfo['land_total_amount'] / (4 * (float) $gataInfo['agricultural_area'])) : 0;
                    if (((float) $gataInfo['current_circle_rate'] > 0 && $data > (float) $gataInfo['current_circle_rate']) || ((float) $gataInfo['road_rate'] > 0 && $data > (float) $gataInfo['road_rate']) || ((float) $gataInfo['aabadi_rate'] > 0 && $data > (float) $gataInfo['aabadi_rate'])) {
                        $answer_18++;
                    } else {
                        
                    }
                } else {
                    
                }

                /*                 * ********* */
                if ((float) $gataInfo['total_parisampatti_amount']) {
                    $data = (10 * (float) $gataInfo['land_total_amount'] / 100);
                    if ((float) $gataInfo['total_parisampatti_amount'] > $data) {
                        $answer_19++;
                    } else {
                        
                    }
                } else {
                    
                }

                /*                 * ********* */
                if ((float) $gataInfo['total_parisampatti_amount']) {
                    if ((float) $gataInfo['total_parisampatti_amount'] > 1000000) {
                        $answer_20++;
                    } else {
                        
                    }
                } else {
                    
                }

                /*                 * ********* */
                if (strtolower($gataInfo['HoldByDM']) == 'yes') {
                    $answer_21++;
                } else {
                    
                }

                /*                 * ********* */
                if (strtolower($gataInfo['HoldByBIDA']) == 'yes') {
                    $answer_22++;
                } else {
                    
                }

                /*                 * ********* */
                if (strtolower($gataInfo['HoldByNirdharan']) == 'yes') {
                    $answer_23++;
                } else {
                    
                }

                /*                 * ********* */
                if (strtolower($gataInfo['BinamaHoldByBIDA']) == 'yes') {
                    $answer_24++;
                } else {
                    
                }

                /*                 * ********* */
                if ($gataInfo['gata_map_not_field'] && $gataInfo['gata_map_not_field'] != '--') {
                    $answer_25++;
                } else {
                    
                }

                /*                 * ********* */
                if ($gataInfo['nahar_map_but_kastkar'] && $gataInfo['nahar_map_but_kastkar'] != '--') {
                    $answer_26++;
                } else {
                    
                }

                /*                 * ********* */
                if ($gataInfo['sadak_map_but_kastkar'] && $gataInfo['sadak_map_but_kastkar'] != '--') {
                    $answer_27++;
                } else {
                    
                }
            }

            // Define dynamic questions and answers
            $consolidate_reports = [
                [
                    "header" => "गाटे के परीक्षण का बिंदु/सवाल",
                    "items" => [
                        [
                            "tab" => "क्रo सo " . $count++,
                            "id" => strval(1),
                            "question" => "कितने गाटे 1359 फसली खतौनी में उपलब्ध नहीं है?",
                            "result" => strval($answer_1)
                        ],
                        [
                            "tab" => "क्रo सo " . $count++,
                            "id" => strval(2),
                            "question" => "कितने गाटे सीएच 41-45 में उपलब्ध नहीं है?",
                            "result" => strval($answer_2)
                        ]
                    ]
                ],
                [
                    "header" => "गाटे की श्रेणी के संबंध में",
                    "items" => [
                        [
                            "tab" => "क्रo सo " . $count++,
                            "id" => strval(3),
                            "question" => "ऐसे गाटो की संख्या जो 1359 फसली खसरे के अनुसर सुरक्षित श्रेणि में है",
                            "result" => strval($answer_6),
                        ],
                        [
                            "tab" => "क्रo सo " . $count++,
                            "id" => strval(4),
                            "question" => "ऐसे गाटो की संख्या जिनकी वर्तमान श्रेनी सीएच 41-45 के समान नहीं है",
                            "result" => strval($answer_7),
                        ]
                    ]
                ],
                [
                    "header" => "गाटे की रकबे के संबंध में",
                    "items" => [
                        [
                            "tab" => "क्रo सo " . $count++,
                            "id" => strval(5),
                            "question" => "ऐसे गाटो की संख्या जिनका वर्तमान रकबा 1359 फसली के रकबे के बराबर नहीं है",
                            "result" => strval($answer_8),
                        ],
                        [
                            "tab" => "क्रo सo " . $count++,
                            "id" => strval(6),
                            "question" => "ऐसे गाटो की संख्या जिनका वर्तमान रकबा सीएच 41-45 के रकबे के बराबर नहीं है",
                            "result" => strval($answer_10),
                        ]
                    ]
                ],
                [
                    "header" => "गाटे के दर निर्धारण के सम्बन्ध में",
                    "items" => [
                        [
                            "tab" => "क्रo सo " . $count++,
                            "id" => strval(7),
                            "question" => "ऐसे गाटो की संख्या जहां कृषि दर निर्धारित नहीं की गई है",
                            "result" => strval($answer_12),
                        ],
                        [
                            "tab" => "क्रo सo " . $count++,
                            "id" => strval(8),
                            "question" => "ऐसे गाटो की संख्या जहां आबादी दर निर्धारित नहीं की गई है",
                            "result" => strval($answer_13),
                        ],
                        [
                            "tab" => "क्रo सo " . $count++,
                            "id" => strval(9),
                            "question" => "ऐसे गाटो की संख्या जहां सड़क किनारे की दर निर्धारित नहीं की गई है",
                            "result" => strval($answer_14),
                        ],
                        [
                            "tab" => "क्रo सo " . $count++,
                            "id" => strval(10),
                            "question" => "ऐसे गाटो की संख्या जहां एक से अधिक प्रकार की दर निर्धारित की गई है ",
                            "result" => strval($answer_15),
                        ],
                        [
                            "tab" => "क्रo सo " . $count++,
                            "id" => strval(11),
                            "question" => "ऐसे गाटो की संख्या जहां पिछले एक साल की मार्केट रेट गाटे की सर्कल रेट अधिक है",
                            "result" => strval($answer_16),
                        ],
                        [
                            "tab" => "क्रo सo " . $count++,
                            "id" => strval(12),
                            "question" => "ऐसे गाटो की संख्या जहां पिछले दो साल में सर्किल रेट अधिक है।",
                            "result" => strval($answer_17),
                        ],
                        [
                            "tab" => "क्रo सo " . $count++,
                            "id" => strval(13),
                            "question" => "ऐसे गाटो की संख्या जहां गाटे का भूमि मूल्य सर्किल रेट के चार गुने से अधिक है",
                            "result" => strval($answer_18),
                        ],
                        [
                            "tab" => "क्रo सo " . $count++,
                            "id" => strval(14),
                            "question" => "ऐसे गाटो की संख्या जहां परिसम्पत्तियों का मुल्य कुल भूमि के मुल्य के 10 प्रतिषत से अधिक है",
                            "result" => strval($answer_19),
                        ],
                        [
                            "tab" => "क्रo सo " . $count++,
                            "id" => strval(15),
                            "question" => "ऐसे गाटो की संख्या जहां परिसम्पत्तियों का मूल्य 10 लाख रूपये से अधिक है",
                            "result" => strval($answer_20),
                        ]
                    ]
                ],
                [
                    "header" => "गाटे के होल्ड करने के सम्बन्ध में",
                    "items" => [
                        [
                            "tab" => "क्रo सo " . $count++,
                            "id" => strval(16),
                            "question" => "ऐसे गाटो की संख्या जिन्हे जिलाधिकरी द्वार विज्ञपति से पहले रोका गया है",
                            "result" => strval($answer_21),
                        ],
                        [
                            "tab" => "क्रo सo " . $count++,
                            "id" => strval(17),
                            "question" => "ऐसे गाटो की संख्या जिन्हे बीड़ा द्वार प्रेस विज्ञपति से पूर्व रोका गया है",
                            "result" => strval($answer_22),
                        ],
                        [
                            "tab" => "क्रo सo " . $count++,
                            "id" => strval(18),
                            "question" => "ऐसे गाटो की संख्या जिन्हे दर निर्धारण समिति द्वारा रोका गया है",
                            "result" => strval($answer_23),
                        ],
                        [
                            "tab" => "क्रo सo " . $count++,
                            "id" => strval(19),
                            "question" => "ऐसे गाटो की संख्या जिनका बैनामा बीड़ा द्वार दर निर्धारण के उपरान्त रोका गया है",
                            "result" => strval($answer_24),
                        ],
                        [
                            "tab" => "क्रo सo " . $count++,
                            "id" => strval(20),
                            "question" => "ऐसे गाटो की संख्या जो नक्शे पर है परंतु मौके पर नहीं है",
                            "result" => strval($answer_25),
                        ],
                        [
                            "tab" => "क्रo सo " . $count++,
                            "id" => strval(21),
                            "question" => "ऐसे गाटो की संख्या जो मानचित्र/मौके पर नहर है परंतु खतौनी में काश्तकार के नाम दर्ज है",
                            "result" => strval($answer_26),
                        ],
                        [
                            "tab" => "क्रo सo " . $count++,
                            "id" => strval(22),
                            "question" => "ऐसे गाटो की संख्या जो मानचित्र/मौके पर सड़क है परंतु खतौनी में काश्तकार के नाम दर्ज हैं",
                            "result" => strval($answer_27),
                        ]
                    ]
                ]
            ];

            $data = array('status' => true, 'message' => 'Data Fetched Successfully', 'consolidateReports' => $consolidate_reports);
        } else {
            $data = array('status' => false, 'message' => 'Data Not Found');
        }
    } else {
        //Creating JSON
        $data = array('status' => false, 'message' => 'Oops.. something went wrong.');
    }
    $data = removeEmptyValues($data);
    print(json_encode($data, JSON_ERROR_UTF8 | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
}
