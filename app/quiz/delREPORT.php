<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID  = $_GET['ID'];

	$sql = "DELETE FROM prototype_report WHERE id = '" . $ID ."' LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  //echo $ID;
	} else {
        $dw3_conn->close();
	    die("Erreur: " . $dw3_conn->error);
	}

	$sql = "DELETE FROM prototype_data WHERE report_id = '" . $ID ."' ";
	if ($dw3_conn->query($sql) === TRUE) {
	  //echo $ID;
	} else {
        $dw3_conn->close();
	    die("Erreur: " . $dw3_conn->error);
	}	
$dw3_conn->close();
die("");
?>