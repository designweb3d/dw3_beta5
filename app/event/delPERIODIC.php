<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID   = $_GET['ID'];

$sql = "UPDATE event SET    
     periodic = 0
     WHERE id = '" . $ID . "' 
     LIMIT 1";
$result = $dw3_conn->query($sql);

$sql = "DELETE FROM event WHERE parent_id = '" . $ID . "';";
$result = $dw3_conn->query($sql); 
if ($dw3_conn->query($sql) === TRUE) {
  //echo "";
} else {
  echo $dw3_conn->error;
}
$dw3_conn->close();
exit();
?>