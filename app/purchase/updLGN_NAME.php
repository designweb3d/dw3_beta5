<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID     = $_GET['ID'];
$NM     = mysqli_real_escape_string($dw3_conn,$_GET['N']);

	$sql = "UPDATE purchase_line
     SET    
	 name_fr = '" . $NM  . "'
	 WHERE id = '" . $ID . "' 
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
