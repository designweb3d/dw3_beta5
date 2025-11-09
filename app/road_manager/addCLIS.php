<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$LST  = htmlspecialchars($_GET['CLIS']);
$rtID  = $_GET['rtID'];

	$sql = "INSERT INTO road_line (road_id, customer_id) VALUES " . $LST;
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  //echo $sql . " " . $dw3_conn->error;
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>