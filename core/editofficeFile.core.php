<?php

$file_id = decryptIt(myUrlEncode($_REQUEST['file_id']));

$office_file = $db->prepare("SELECT  T1.ID, T1.DepartmentName, T1.FileNo, T1.Name, T1.Subject, T1.FolderNameForNoteSheet, T1.FileCreator, T1.Active
                                                FROM lm_eoffice T1
                                                WHERE  T1.RowDeleted = ?
                                                AND T1.ID = ?
                                                ");
$office_file->bindValue(1, 0);
$office_file->bindParam(2, $file_id);
$office_file->execute();
$office_file->setFetchMode(PDO::FETCH_ASSOC);
$office_fileInfo = $office_file->fetch();
