<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';
$ID = $_GET['ID'];
$sql = "UPDATE product SET purchase_qty = purchase_qty + 1 WHERE id = '" . $ID . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$dw3_conn->close();
?>