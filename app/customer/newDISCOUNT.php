<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$CID  = $_GET['CID'];

//insert
	$sql = "INSERT INTO customer_discount (customer_id) VALUES ('".$CID."')";
	if ($dw3_conn->query($sql) === TRUE) {
        $inserted_id = $dw3_conn->insert_id;
		echo $inserted_id;
	} else {
		echo '{"status":"error", "data":"' . $dw3_conn->error . '"} ';
	}
	
$dw3_conn->close();
?>
