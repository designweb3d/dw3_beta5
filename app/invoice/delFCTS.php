<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$LST  = htmlspecialchars($_GET['LST']);
$sql = "UPDATE invoice_head SET stat = '3',date_modified   = '" . $datetime   . "',user_modified   = '" . $USER   . "' WHERE id IN " . $LST;
$result = mysqli_query($dw3_conn, $sql);
$dw3_conn->close();
?>
