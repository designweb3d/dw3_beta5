<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID     = $_GET['ID'];
$LOCATION     = $_GET['LOCATION'];
$LEVEL    = mysqli_real_escape_string($dw3_conn,$_GET['LEVEL']);
$LOCAL    = mysqli_real_escape_string($dw3_conn,$_GET['LOCAL']);
$ROW    = mysqli_real_escape_string($dw3_conn,$_GET['ROW']);
$SHELF    = mysqli_real_escape_string($dw3_conn,$_GET['SHELF']);
$SECTION    = mysqli_real_escape_string($dw3_conn,$_GET['SECTION']);

$sql = "UPDATE storage SET    
location_id = '" . $LOCATION . "',
level = '" . $LEVEL . "',
local = '" . $LOCAL . "',
row = '" . $ROW . "',
shelf = '" . $SHELF . "',
section = '" . $SECTION   . "'
WHERE id = '" . $ID . "' 
LIMIT 1";
if ($dw3_conn->query($sql) === TRUE) {
 echo "";
} else {
 echo $dw3_conn->error;
}
$dw3_conn->close();
?>
