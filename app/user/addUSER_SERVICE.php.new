<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$usID   = $_GET['USER'];
$prID   = $_GET['PRD'];

	$sql = "INSERT INTO user_service (user_id,product_id,is_public)
    VALUES 
        ('" . $usID   . "',
         '" . $prID  . "',1)";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
?>