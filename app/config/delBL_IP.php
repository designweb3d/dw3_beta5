<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$IP = $_GET['IP'];
	$sql = "DELETE FROM blacklist WHERE ip = '" . $IP . "'";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>