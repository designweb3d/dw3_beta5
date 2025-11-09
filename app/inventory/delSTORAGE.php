<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID  = $_GET['ID'];
	$sql = "DELETE FROM storage
	 WHERE id = '" . $ID ."' LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo $ID;
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
?>