<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID     = $_GET['ID'];
$TYPE     = $_GET['TYPE'];
$NAME    = mysqli_real_escape_string($dw3_conn,$_GET['NAME']);
$HEIGHT    = mysqli_real_escape_string($dw3_conn,$_GET['HEIGHT']);
$WIDTH    = mysqli_real_escape_string($dw3_conn,$_GET['WIDTH']);
$DEPTH    = mysqli_real_escape_string($dw3_conn,$_GET['DEPTH']);
$WEIGHT    = mysqli_real_escape_string($dw3_conn,$_GET['WEIGHT']);

$sql = "UPDATE supply SET    
name_fr = '" . $NAME . "',
height = '" . $HEIGHT . "',
width = '" . $WIDTH . "',
depth = '" . $DEPTH . "',
weight = '" . $WEIGHT . "',
supply_type = '" . $TYPE   . "'
WHERE id = '" . $ID . "' 
LIMIT 1";
if ($dw3_conn->query($sql) === TRUE) {
 echo "";
} else {
 echo $dw3_conn->error;
}
$dw3_conn->close();
?>
