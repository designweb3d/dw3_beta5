<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$LST  = htmlspecialchars($_GET['LST']);
$LSTA = explode(",",str_replace("(", "",str_replace(")", "",$LST)));
//VERIFICATIONS
	foreach ($LSTA as $value) {
		if ($value == "0"){
			//die ("Erreur: Le client par defaut ne peut etre supprime");
		}
	}

	$sql = "SELECT COUNT(id) as rowCount FROM invoice_line WHERE product_id IN " . $LST;
	$result = mysqli_query($dw3_conn, $sql);
	$data = mysqli_fetch_assoc($result);
	if ($data['rowCount'] >= 1) {
		die ("Erreur: Seul le status du produit peut etre modifié apres avoir été facturé.");
	}
	$sql = "SELECT COUNT(*) as rowCount FROM product WHERE stripe_id <> '' AND id IN " . $LST;
	$result = mysqli_query($dw3_conn, $sql);
	$data = mysqli_fetch_assoc($result);
	if ($data['rowCount'] >= 1) {
        $dw3_conn->close();
		die ("Erreur: Certains de ces produits ont un fichier chez Stripe et doivent être supprimés un par un.");
	}

//DELETE BDCLNT	
	$sql = "DELETE FROM product 
			WHERE id IN " . $LST;
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  //echo $sql . " " . $dw3_conn->error;
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
