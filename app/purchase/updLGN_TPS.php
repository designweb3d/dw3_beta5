<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID     = $_GET['ID'];
$TX     = $_GET['T'];

	$sql = "UPDATE purchase_line
     SET    
	 tax_fed   = '" . $TX  . "'
	 WHERE id = '" . $ID . "' 
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
