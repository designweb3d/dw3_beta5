<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$LST  = htmlspecialchars($_GET['LST']);

//VERIFICATIONS
	$sql = "SELECT COUNT(id) as rowCount FROM purchase_head WHERE project_id IN " . $LST;
	$result = mysqli_query($dw3_conn, $sql);
	$data = mysqli_fetch_assoc($result);
	if ($data['rowCount'] >= 1) {
		die ("Erreur: Seul le status peut être modifié après avoir entré unachat associé à ce projet.");
	}
	$sql = "SELECT COUNT(id) as rowCount FROM order_head WHERE project_id IN " . $LST;
	$result = mysqli_query($dw3_conn, $sql);
	$data = mysqli_fetch_assoc($result);
	if ($data['rowCount'] >= 1) {
		die ("Erreur: Seul le status peut être modifié après avoir entré une commande associé à ce projet.");
	}

//DELETE CFENT
	$sql = "DELETE FROM project
			WHERE id IN " . $LST;
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  //echo $sql . " " . $dw3_conn->error;
	  echo $dw3_conn->error;
	}
	
$dw3_conn->close();
?>
