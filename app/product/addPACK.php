<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$PRD  = htmlspecialchars($_GET['PRD']);
    
//insert
	$sql = "INSERT INTO product_pack
    (product_id,pack_name_fr,pack_name_en,pack_qty,pack_price)
    VALUES 
        ('".$PRD."',
         'Nouveau prix',
         'New price',
         '0',
         '0')";
	if ($dw3_conn->query($sql) === TRUE) {
        $inserted_id = $dw3_conn->insert_id;
        echo $inserted_id;
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
    
$dw3_conn->close();
?>
