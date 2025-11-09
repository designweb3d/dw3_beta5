<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$rtID  = $_GET['ID'];
$rtNOM  = htmlspecialchars($_GET['NOM']);
$rtLOC  = $_GET['LOC'];
$rtFJR  = $_GET['FJR'];
$rtFHR  = $_GET['FHR'];
$rtMHW  = $_GET['MHW'];
$rtMFR  = $_GET['MFR'];

	$sql = "UPDATE road_head
     SET    
	 name  = '" . $rtNOM   . "'
	 ,location_id  = '" . $rtLOC   . "'
	 ,freq_day = '" . $rtFJR   . "'
	 ,freq_hour = '" . $rtFHR   . "'
	 ,highway = '" . $rtMHW   . "'
	 ,ferrie = '" . $rtMFR   . "'
	 WHERE id = '" . $rtID . "' 
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>