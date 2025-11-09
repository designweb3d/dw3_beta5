<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
	$sql = "UPDATE user SET key_128 = ''
			WHERE id = " . $USER . "
			LIMIT 1";
	if ($dw3_conn->query($sql) === FALSE) {
		//err
	}	
setcookie("KEY", "", time() + 86400 , "/"); 
$dw3_conn->close();		
header("Location: https://" . $_SERVER["SERVER_NAME"] . "/");
exit();
?>
