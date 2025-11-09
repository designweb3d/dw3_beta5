<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID  = $_GET['shID'];

	$sql = "SELECT COUNT(id) as rowCount FROM invoice_head WHERE shipment_id = '" . $ID . "'";
	$result = mysqli_query($dw3_conn, $sql);
	$data = mysqli_fetch_assoc($result);
	if ($data['rowCount'] >= 1) {
		die ("Erreur: Seul le status peut être modifié après avoir entré une facture associé à cette expédition.");
	}

//DELETE HEAD
	$sql = "DELETE FROM shipment_head
	 WHERE id = '" . $ID . "' LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}	

//DELETE LINES
	$sql = "DELETE FROM shipment_line
	 WHERE head_id = '" . $ID ."' ";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}	
$dw3_conn->close();
?>
