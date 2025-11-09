<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
$ID  = $_GET['ID'];
$QTY = $_GET['Q'];

$sql = "UPDATE classified SET  
qty_available ='" . $QTY . "'
WHERE id = '" . $ID . "' 
LIMIT 1";
if ($dw3_conn->query($sql) == TRUE) {
    echo "";
} else {
  echo $dw3_conn->error;
}
$dw3_conn->close();
?>