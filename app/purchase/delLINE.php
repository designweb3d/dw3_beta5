<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$lgID   = $_GET['lgID'];

if ($lgID == "") {
	die ("Erreur ligne de produit inconnue.");
}

	$sql = "DELETE FROM purchase_line
	 WHERE id = '" . $lgID ."'
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  //echo $ID;
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
?>