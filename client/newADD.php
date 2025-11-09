<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
	$sql = "INSERT INTO classified
    (customer_id)
    VALUES 
    ('" . $USER  . "')";
	if ($dw3_conn->query($sql) === TRUE) {
      $inserted_id = $dw3_conn->insert_id;
	  echo $inserted_id;
	}
$dw3_conn->close();
?>