<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$DID  = $_GET['DID'];

//BDCLNT DELETE
	$sql = "DELETE FROM customer_discount WHERE id = '" . $DID ."' LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} 

$dw3_conn->close();
die("");
?>
