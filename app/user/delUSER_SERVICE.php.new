<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$usID   = $_GET['USER'];
$prID   = $_GET['PRD'];

	$sql = "DELETE FROM user_service WHERE user_id = '" . $usID   . "' AND product_id = '" . $prID  . "'";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
?>