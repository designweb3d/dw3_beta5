<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$LST  = htmlspecialchars($_GET['LST']);
$LSTA = explode(",",str_replace("(", "",str_replace(")", "",$LST)));

//VERIFICATIONS
	foreach ($LSTA as $value) {
		if ($value == "0"){
			die ("Erreur: Le fournisseur par defaut ne peut etre supprime");
		}
	}

	$sql = "SELECT COUNT(supplier_id) as rowCount FROM purchase_head WHERE supplier_id IN " . $LST;
	$result = mysqli_query($dw3_conn, $sql);
	$data = mysqli_fetch_assoc($result);
	if ($data['rowCount'] >= 1) {
		die ("Erreur: Seul le status peut être modifié apres avoir placé un achat.");
	}

//DELETE suppliers	
	$sql = "DELETE FROM supplier
			WHERE id IN " . $LST;
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  //echo $sql . " " . $dw3_conn->error;
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
