<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
	$sql = "INSERT INTO `faq` (`id`,`sort_index`) SELECT NULL, MAX(`sort_index`)+1 FROM `faq`;";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo $dw3_conn->insert_id;
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
?>