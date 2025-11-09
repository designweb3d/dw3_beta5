<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID     = $_GET['ID'];
$HEIGHT    = mysqli_real_escape_string($dw3_conn,$_GET['HEIGHT']);
$WIDTH    = mysqli_real_escape_string($dw3_conn,$_GET['WIDTH']);
$LENGTH    = mysqli_real_escape_string($dw3_conn,$_GET['LENGTH']);
$WEIGHT    = mysqli_real_escape_string($dw3_conn,$_GET['WEIGHT']);

	$sql = "UPDATE shipment_head SET    
	 height = '" . $HEIGHT . "',
	 width = '" . $WIDTH . "',
	 length = '" . $LENGTH . "',
	 weight = '" . $WEIGHT . "'
	 WHERE id = '" . $ID . "' 
	 LIMIT 1";
     //error_log($sql);
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>