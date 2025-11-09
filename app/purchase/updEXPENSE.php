<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID     = $_GET['ID'];
$N = mysqli_real_escape_string($dw3_conn,$_GET['N']);
$K = mysqli_real_escape_string($dw3_conn,$_GET['K']);
$C = mysqli_real_escape_string($dw3_conn,$_GET['C']);
$A = mysqli_real_escape_string($dw3_conn,$_GET['A']);

	$sql = "UPDATE expense
     SET    
	 group_name = '" . $N  . "',
	 kind = '" . $K  . "',
	 gl_code = '" . $C  . "',
	 amount = '" . $A  . "'
	 WHERE id = '" . $ID . "' 
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
