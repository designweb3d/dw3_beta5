<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$FROM  = mysqli_real_escape_string($dw3_conn,$_GET['FROM']);
$TO  = mysqli_real_escape_string($dw3_conn,$_GET['TO']);
$folder=$_SERVER['DOCUMENT_ROOT'] ."/pub/upload/";
$html = rename($folder.$FROM,$folder.$TO);
$dw3_conn->close();
header('Status: 200');
die($html);
?>