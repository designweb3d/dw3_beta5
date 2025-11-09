<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$APP = $_GET['APP']??'';
$sql = "DELETE FROM app_prm
			WHERE app_id = '" . $APP . "'
			AND   user_id = '" . $USER . "';";
	$result = $dw3_conn->query($sql);

$dw3_conn->close(); 
die($result);
?>