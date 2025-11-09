<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID  = $_GET['enID'];

//enID 0 = Premiere commande
//	if ($ID  == "0") {
//		die ("Erreur: Cette commande ne peut etre supprime");
//	}
	
//VERIFICATIONS
	$sql = "SELECT COUNT(id) as rowCount FROM invoice_head WHERE id = " . $ID;
	$result = mysqli_query($dw3_conn, $sql);
	$data = mysqli_fetch_assoc($result);
	if ($data['rowCount'] >= "1") {
		die ("Erreur: Seul le status peut etre modifie apres avoir facture le client.");
	}

//CFENT DELETE
	$sql = "DELETE FROM order_head
	 WHERE id = '" . $ID ."' 
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}

//CFLNG DELETE
	$sql = "DELETE FROM order_line
	 WHERE head_id = '" . $ID ."' 
	 ";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}	
$dw3_conn->close();
?>
