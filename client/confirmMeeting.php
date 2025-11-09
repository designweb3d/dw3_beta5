<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
$MID  = $_GET['MID'];

$sql = "UPDATE schedule_line SET  
confirmed = '1'
WHERE id = '" . $MID . "' 
LIMIT 1";
if ($dw3_conn->query($sql) == TRUE) {
    echo "";
} else {
  echo $dw3_conn->error;
}
$dw3_conn->close();
?>