<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID   = $_GET['ID'];
$col_name   = $_GET['COL'];
$new_val   = str_replace("'","’",mysqli_real_escape_string($dw3_conn,$_GET['V']));

	$sql = "UPDATE realisation SET    
	 ".$col_name." = '" . $new_val . "'
	 WHERE id = '" . $ID . "'";
	if ($dw3_conn->query($sql) === TRUE) {
	  //ok
	} else {
	  echo $dw3_conn->error;
	}
echo "";
$dw3_conn->close();
?>