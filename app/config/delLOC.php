<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID   = $_GET['ID'];

if ($ID == "1") {
	die ("Cette adresse ne peut etre effacée, seulement modifiée.");
}

	$sql = "DELETE FROM location
	 WHERE id = " . $ID ;
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "0";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>