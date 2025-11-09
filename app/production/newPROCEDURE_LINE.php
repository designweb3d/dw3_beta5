<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID  = $_GET['ID'];
//insert
	$sql = "INSERT INTO procedure_line
    (procedure_id,qty_by_unit)
    VALUES 
        (
         '".$ID."',
         '1')";
		//die("Erreur: ".$sql);
	if ($dw3_conn->query($sql) === TRUE) {
        echo $dw3_conn->insert_id;
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}

$dw3_conn->close();
?>
