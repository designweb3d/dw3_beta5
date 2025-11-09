<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$PRD  = htmlspecialchars($_GET['PRD']);
    
//insert
	$sql = "INSERT INTO product_option
    (product_id,name_fr,name_en)
    VALUES 
        ('".$PRD."',
         'Nouvelle option',
         'New option')";
	if ($dw3_conn->query($sql) === TRUE) {
        $inserted_id = $dw3_conn->insert_id;
        echo $inserted_id;
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
    
$dw3_conn->close();
?>
