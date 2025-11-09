<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$POSTE   = mysqli_real_escape_string($dw3_conn,$_GET['POSTE']);

	$sql = "DELETE FROM position
	 WHERE name = '" . $POSTE . "'";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "0";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>