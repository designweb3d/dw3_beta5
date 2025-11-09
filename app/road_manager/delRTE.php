<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$rtID  = $_GET['ID'];

	$sql = "DELETE FROM road_line 
			WHERE road_id = '" . $rtID . "' ";

	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  //echo $sql . " " . $dw3_conn->error;
	  echo $dw3_conn->error;
	}
	
	$sql = "DELETE FROM road_user 
			WHERE road_id = '" . $rtID . "' ";

	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  //echo $sql . " " . $dw3_conn->error;
	  echo $dw3_conn->error;
	}
	
	
	$sql = "DELETE FROM road_head
			WHERE id = '" . $rtID . "' ";

	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  //echo $sql . " " . $dw3_conn->error;
	  echo $dw3_conn->error;
	}
	
$dw3_conn->close();
?>