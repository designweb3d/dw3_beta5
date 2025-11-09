<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$sid  = $_GET['sid'];
$mid  = $_GET['mid'];

	$sql = "UPDATE schedule_line 
			SET msm_msg_id = '" . $mid . "' 
			WHERE id = '" . $sid . "'
			LIMIT 1" ;
	if ($dw3_conn->query($sql) === TRUE) {
	  //echo $sql;
	  echo "";
	} else {
	  //echo $sql . " " . $dw3_conn->error;
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>