<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$USER  = htmlspecialchars($_GET['USER']);

	$sql = "INSERT INTO road_user (road_id, user_id) VALUES ".$USER." ;";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $sql . "" . $dw3_conn->error;
	}
$dw3_conn->close();
?>