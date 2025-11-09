<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID   = $_GET['ID'];

if ($ID == "") {
	die ("Erreur ligne de produit inconnue.");
}

	$sql = "DELETE FROM invoice_line
	 WHERE id = '" . $ID ."'
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
?>