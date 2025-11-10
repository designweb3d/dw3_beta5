<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';
$ID = $_GET['ID'];

$sql = "DELETE FROM cart_line WHERE id = '".$ID."';";
$result = mysqli_query($dw3_conn, $sql);
$sql = "DELETE FROM cart_option WHERE line_id = '".$ID."';";
$result = mysqli_query($dw3_conn, $sql);

$dw3_conn->close();
?>