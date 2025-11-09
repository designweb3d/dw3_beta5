<?php
require_once 'security_db.php';
	$sql = "UPDATE customer SET key_128 = '' WHERE id = " . $USER . " LIMIT 1";
	if ($dw3_conn->query($sql) === FALSE) {
		//err
	}	
//setcookie("KEY", "", time() + 86400 , "/"); 
$cookie_domain = "." . $_SERVER["SERVER_NAME"];
setcookie("KEY", "", [
    'expires' => time() + 86400,
    'path' => '/',
    'domain' => $cookie_domain,
    'secure' => true,
    'httponly' => true,
    'samesite' => 'None',
]);
$dw3_conn->close();		
die("");
?>
