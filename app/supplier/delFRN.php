<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID  = $_GET['frID'];

//clID 0 = Client cash
	if ($ID  == "0") {
		die ("Erreur: Le fournisseur par defaut ne peut etre supprime");
	}
	
//VERIFICATIONS
	$sql = "SELECT COUNT(supplier_id) as rowCount FROM purchase_head WHERE supplier_id = " . $ID;
	$result = mysqli_query($dw3_conn, $sql);
	$data = mysqli_fetch_assoc($result);
	if ($data['rowCount'] >= "1") {
		die ("Erreur: Seul le status, peut être modifié, après avoir été facturé pour un achat.");
	}

//BDCLNT DELETE
	$sql = "DELETE FROM supplier
	 WHERE id = '" . $ID ."' AND id <> 0
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo $ID;
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}

//RTE_CLI DELETE
	$sql = "DELETE FROM road_line
	 WHERE supplier_id = '" . $ID ."' AND supplier_id <> '' 
	 ";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo $ID;
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}	
$dw3_conn->close();
?>