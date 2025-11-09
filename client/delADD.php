<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
$addID  = $_GET['ID'];
	$sql = "DELETE FROM classified WHERE id = '" . $addID ."' LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  //echo $sql;
	} else {
        $dw3_conn->close();
        die("Erreur: " . $dw3_conn->error);
	}
$dw3_conn->close();
die("");
?>
