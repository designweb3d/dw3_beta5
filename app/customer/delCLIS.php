<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$LST  = htmlspecialchars($_GET['LST']);
$LSTA = explode(",",str_replace("(", "",str_replace(")", "",$LST)));
//VERIFICATIONS
	foreach ($LSTA as $value) {
		if ($value == "0"){
            $dw3_conn->close();
			die ("Erreur: Le client par defaut ne peut etre supprime");
		}
	}

	$sql = "SELECT COUNT(customer_id) as rowCount FROM order_head WHERE customer_id IN " . $LST;
	$result = mysqli_query($dw3_conn, $sql);
	$data = mysqli_fetch_assoc($result);
	if ($data['rowCount'] >= 1) {
        $dw3_conn->close();
		die ("Erreur: Seul le status du client peut etre modifie apres avoir place une commande.");
	}
	$sql = "SELECT COUNT(*) as rowCount FROM customer WHERE stripe_id <> '' AND id IN " . $LST;
	$result = mysqli_query($dw3_conn, $sql);
	$data = mysqli_fetch_assoc($result);
	if ($data['rowCount'] >= 1) {
        $dw3_conn->close();
		die ("Erreur: Certains de ces clients ont un compte chez Stripe et doivent être supprimés un par un.");
	}


//DELETE BDCLNT	
	$sql = "DELETE FROM customer 
			WHERE id IN " . $LST;
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  //echo $sql . " " . $dw3_conn->error;
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
