<?php

$user_id = $_SESSION['UserID'];
$user_type = $_SESSION['UserType'];

$village_query = $db->prepare("SELECT Distinct T1.VillageName
                                FROM lm_slao_report T1
                                ORDER BY T1.VillageName ASC
                                ");
$village_query->execute();
$village_query->setFetchMode(PDO::FETCH_ASSOC);
$villageInfo = $village_query->fetchAll();
