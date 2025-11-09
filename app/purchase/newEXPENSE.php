<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
	$sql = "INSERT INTO expense (group_name,kind,gl_code,amount)
    VALUES ('a new expense group name','DEBIT','1060','0.00')";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
