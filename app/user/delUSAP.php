<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$usID   = $_GET['usID'];
$apID   = $_GET['apID'];

if ($apID == "1") {
	die ("Cette application ne peut etre effacée.");
}

	$sql = "DELETE FROM app_user
	 WHERE app_id = " . $apID . " AND user_id = " . $usID . " LIMIT 1" ;
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "0";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>