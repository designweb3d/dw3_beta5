<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$LST  = htmlspecialchars($_GET['LST']);

//VERIFICATIONS
	$sql = "SELECT COUNT(id) as rowCount FROM invoice_head WHERE id IN " . $LST;
	$result = mysqli_query($dw3_conn, $sql);
	$data = mysqli_fetch_assoc($result);
	if ($data['rowCount'] >= 1) {
		die ("Erreur: Seul le status peut être modifié après avoir entré une facture du fournisseur.");
	}

//DELETE CFENT
	$sql = "DELETE FROM purchase_head
			WHERE id IN " . $LST;
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  //echo $sql . " " . $dw3_conn->error;
	  echo $dw3_conn->error;
	}
	
//CFLNG DELETE
	$sql = "DELETE FROM purchase_line
	 WHERE head_id IN " . $LST; 
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}	
$dw3_conn->close();
?>
