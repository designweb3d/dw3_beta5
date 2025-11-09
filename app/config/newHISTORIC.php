<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
	$sql = "INSERT INTO `historic` (`id`,`sort_number`) VALUES (NULL,(SELECT MAX(sort_number) + 1 FROM historic));";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo $dw3_conn->insert_id;
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
?>