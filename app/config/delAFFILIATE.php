<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID = $_GET['ID'];
	$sql = "DELETE FROM affiliate
	 WHERE id = '" . $ID . "'";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "0";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>