<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$rtID  = $_GET['rtID'];
$clID  = $_GET['clID'];
$from  = $_GET['from'];
$to  = $_GET['to'];
	$sql = "UPDATE road_line SET    
	 sort_number  = '" . $to   . "'
	 WHERE customer_id = '" . $clID . "' 
	   AND road_id = '" . $rtID . "' 
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  //echo "";
	} else {
	  echo $dw3_conn->error;
	}
	$sql = "UPDATE road_line
     SET    
	 sort_number  = '" . $from   . "'
	 WHERE customer_id <> '" . $clID . "' 
	   AND road_id = '" . $rtID . "' 
	   AND sort_number = '" . $to . "' 
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  //echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
