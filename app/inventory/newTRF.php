<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$PRD  = mysqli_real_escape_string($dw3_conn,$_GET['PRD']);
$KIND  = mysqli_real_escape_string($dw3_conn,$_GET['KIND']);
$STORAGE  = mysqli_real_escape_string($dw3_conn,$_GET['STORAGE']);
$ORDER  = mysqli_real_escape_string($dw3_conn,$_GET['ORDER']);
$PURCHASE  = mysqli_real_escape_string($dw3_conn,$_GET['PURCHASE']);
$QTE  = mysqli_real_escape_string($dw3_conn,$_GET['QTE']);
if (!is_numeric($QTE)){         
    $dw3_conn->close();
    die("Quantité " . $QTE . " invalide");
}
//verif
    $sql = "SELECT * FROM product
    WHERE id = '" . $PRD . "' LIMIT 1";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows == 0) {
        $dw3_conn->close();
        die("Produit ID# " . $PRD . " introuvable");
    }
    $sql = "SELECT * FROM storage
    WHERE id = '" . $STORAGE . "' LIMIT 1";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows == 0) {
        $dw3_conn->close();
        die("Storage ID# " . $STORAGE . " introuvable");
    }
//insert
	$sql = "INSERT INTO transfer
    (product_id,kind,storage_id,order_id,purchase_id,quantity)
    VALUES 
        ('" . $PRD  . "',
         '" . $KIND  . "',
         '" . $STORAGE  . "',
         '" . $ORDER  . "',
         '" . $PURCHASE  . "',
         '" . $QTE  . "')";
	if ($dw3_conn->query($sql) === TRUE) {
        echo "";
	} else {
	    echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
?>