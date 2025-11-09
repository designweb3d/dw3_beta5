<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';

//insert
	$sql = "INSERT INTO procedure_head
    (name_fr,quality_v1_desc)
    VALUES 
        (
         'Nouvelle procédure',
         'Résultat qualité #1')";
		//die("Erreur: ".$sql);
	if ($dw3_conn->query($sql) === TRUE) {
        echo $dw3_conn->insert_id;
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}

$dw3_conn->close();
?>
