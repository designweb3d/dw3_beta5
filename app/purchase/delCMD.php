<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID  = $_GET['enID'];

//CFENT DELETE
	$sql = "DELETE FROM purchase_head
	 WHERE id = '" . $ID ."' 
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}

//CFLNG DELETE
	$sql = "DELETE FROM purchase_line
	 WHERE head_id = '" . $ID ."' 
	 ";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}	
$dw3_conn->close();
?>
