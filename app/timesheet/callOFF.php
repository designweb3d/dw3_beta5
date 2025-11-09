<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID   = $_GET['ID'];

	$sql = "UPDATE schedule_head SET start_work = '0000-00-00 00:00:00', end_work = '0000-00-00 00:00:00', is_public = 0 WHERE id = '" . $ID . "' LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  //echo $sql;
	} else {
	  echo $dw3_conn->error;
	}

$dw3_conn->close();
?>