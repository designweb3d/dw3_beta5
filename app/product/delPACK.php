<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$pack_id   = $_GET['PACK'];

	$sql = "DELETE FROM product_pack WHERE id = '" . $pack_id ."' LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
exit();
?>