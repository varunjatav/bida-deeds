<?php

$tree_id = $_REQUEST['tree_id'];
$dimention_val = $_REQUEST['dimention_val'];

$query = "SELECT T1.ID, T1.TreeValue FROM lm_asset_tree_rate_mapping T1 WHERE T1.TreeID = ?";

if ($tree_id && $dimention_val == '1') {
    $query .= " AND (T1.RangeFrom <= ? AND T1.RangeTo >= ?) AND T1.RangeTo != ?";
} else if ($tree_id && $dimention_val == '2') {
    $query .= " AND (T1.RangeFrom <= ? AND T1.RangeTo >= ?) AND T1.RangeTo != ?";
} else if ($tree_id && $dimention_val == '3') {
    $query .= " AND (T1.RangeFrom <= ? AND T1.RangeTo >= ?) AND T1.RangeTo != ?";
} else if ($tree_id && $dimention_val == '4') {
    $query .= " AND (T1.RangeFrom <= ? AND T1.RangeTo >= ?) AND T1.RangeTo != ?";
} else if ($tree_id && $dimention_val == '5') {
    $query .= " AND (T1.RangeFrom <= ? AND T1.RangeTo >= ?) AND T1.RangeTo != ?";
} else if ($tree_id && $dimention_val == '6') {
    $query .= " AND (T1.RangeFrom <= ? AND T1.RangeTo >= ?) AND T1.RangeTo != ?";
} else if ($tree_id && $dimention_val == '7') {
    $query .= " AND T1.RangeFrom <= ? AND T1.RangeTo = ?";
}
$query .= " LIMIT 1";
$i = 1;
$tree = $db->prepare($query);
$tree->bindParam($i++, $tree_id);

if ($tree_id && $dimention_val == '1') {
    $tree->bindValue($i++, '0');
    $tree->bindValue($i++, '30');
    $tree->bindValue($i++, '-1');
} else if ($tree_id && $dimention_val == '2') {
    $tree->bindValue($i++, '31');
    $tree->bindValue($i++, '60');
    $tree->bindValue($i++, '-1');
} else if ($tree_id && $dimention_val == '3') {
    $tree->bindValue($i++, '61');
    $tree->bindValue($i++, '90');
    $tree->bindValue($i++, '-1');
} else if ($tree_id && $dimention_val == '4') {
    $tree->bindValue($i++, '91');
    $tree->bindValue($i++, '120');
    $tree->bindValue($i++, '-1');
} else if ($tree_id && $dimention_val == '5') {
    $tree->bindValue($i++, '121');
    $tree->bindValue($i++, '150');
    $tree->bindValue($i++, '-1');
} else if ($tree_id && $dimention_val == '6') {
    $tree->bindValue($i++, '151');
    $tree->bindValue($i++, '180');
    $tree->bindValue($i++, '-1');
} else if ($tree_id && $dimention_val == '7') {
    $tree->bindValue($i++, '180');
    $tree->bindValue($i++, '-1');
}
$tree->execute();
$tree->setFetchMode(PDO::FETCH_ASSOC);
$treeAmountInfo = $tree->fetch();
