<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID   = $_GET['usID'];

if ($ID == "0") {
	die ("Erreur: Cet utilisateur ne peut etre effacé, ni modifié.");
}

	$sql = "DELETE FROM user
	 WHERE id = '" . $ID ."' AND id <> 0
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo $ID;
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
?>