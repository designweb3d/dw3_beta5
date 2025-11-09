<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID = $_GET['prjID'];

	$sql = "SELECT COUNT(id) as rowCount FROM purchase_head WHERE project_id = '" . $ID . "'";
	$result = mysqli_query($dw3_conn, $sql);
	$data = mysqli_fetch_assoc($result);
	if ($data['rowCount'] >= 1) {
		die ("Erreur: Seul le status peut être modifié après avoir entré un achat associé à ce projet.");
	}
	$sql = "SELECT COUNT(id) as rowCount FROM order_head WHERE project_id = '" . $ID . "'";
	$result = mysqli_query($dw3_conn, $sql);
	$data = mysqli_fetch_assoc($result);
	if ($data['rowCount'] >= 1) {
		die ("Erreur: Seul le status peut être modifié après avoir entré une commande associé à ce projet.");
	}

//CFLNG DELETE
	$sql = "DELETE FROM project
	 WHERE id = '" . $ID ."' LIMIT 1 ";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}	
$dw3_conn->close();
?>
