<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$frID  = $_GET['frID'];
$frLNG  = $_GET['LNG'];
$frLAT  = $_GET['LAT'];

	$sql = "UPDATE supplier 
			SET longitude = '" . $frLNG . "' 
			, latitude = '" . $frLAT . "' 
			WHERE id = '" . $frID . "'
			LIMIT 1" ;
	if ($dw3_conn->query($sql) === TRUE) {
	  echo $sql;
	} else {
	  //echo $sql . " " . $dw3_conn->error;
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>