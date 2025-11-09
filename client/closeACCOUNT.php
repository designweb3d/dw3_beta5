<?php
//cart to order to invoice
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
$sql="UPDATE customer SET stat = '1' WHERE id = '".$USER."' LIMIT 1 ;"; 
if ($dw3_conn->query($sql) === TRUE) {
    $dw3_conn->close();
    die("");
} else {
    $dw3_conn->close();
    die("Erreur le compte n'a pas pu être fermé. Veuillez communiquer avec nous pour de plus amples renseignements.");
}
?>