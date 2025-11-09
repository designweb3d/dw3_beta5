<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$clID  = $_GET['clID'];

	$sql = "UPDATE customer
     SET    
	 last_visit_hour  = '" . $time   . "',
	 last_visit_day = '" . $today  . "'
	 WHERE id = '" . $clID . "' 
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
