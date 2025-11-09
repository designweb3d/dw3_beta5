<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$clID  = $_GET['clID'];
$rtID  = $_GET['rtID'];
$clORD  = $_GET['clORD'];

	$sql = "UPDATE road_line
     SET    
	 sort_number  = '" . $clORD   . "'
	 WHERE customer_id = '" . $clID . "' 
	 AND   road_id = '" . $rtID . "' 
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>