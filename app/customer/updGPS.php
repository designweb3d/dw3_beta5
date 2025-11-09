<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/security.php';
$clID  = $_GET['clID'];
$clLNG  = $_GET['LNG'];
$clLAT  = $_GET['LAT'];

	$sql = "UPDATE BDCLNT 
			SET clLNG = '" . $clLNG . "' 
			, clLAT = '" . $clLAT . "' 
			WHERE clID = '" . $clID . "'
			LIMIT 1" ;
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  //echo $sql . " " . $dw3_conn->error;
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>