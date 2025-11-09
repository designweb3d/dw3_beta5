<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$clID  = $_GET['ID'];
$clNOTE  = str_replace(PHP_EOL, '<br>', htmlspecialchars($_GET['NOTE']));

	$sql = "UPDATE customer SET    
	 note  = '" . $clNOTE   . "'
	 WHERE id = '" . $clID . "' 
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
