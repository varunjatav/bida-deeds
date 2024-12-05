<?php
$user_id = $_SESSION['UserID'];
$user_type = $_SESSION['UserType'];
$file_id = decryptIt(myUrlEncode($_REQUEST['file_id']));

$sql = "SELECT SQL_CALC_FOUND_ROWS T1.ID, T1.VillageName, T1.VillageNameHi, T1.VillageCode, T1.Type
                        FROM lm_village T1
                        WHERE T1.ID  = ?
                        AND T1.Active = ?
                        GROUP BY T1.ID
                        ";
 $sql = $db->prepare($sql);
 $sql->bindParam(1, $file_id);
  $sql->bindValue(2, 1);
 $sql->execute();
 $sql->setFetchMode(PDO::FETCH_ASSOC);
 $data = $sql->fetch();