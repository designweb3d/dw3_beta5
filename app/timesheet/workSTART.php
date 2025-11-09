<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID   = $_GET['ID'];
$DT   = $_GET['DT']??$datetime;

//update schedule header
		$sql = "UPDATE schedule_head SET start_work = '" . $DT . "' WHERE id = '" . $ID . "' LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  //echo $sql;
	} else {
	  echo $dw3_conn->error;
	}

$dw3_conn->close();
?>