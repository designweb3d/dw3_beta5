<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$option_id  = $_GET['OPT'];
$name_fr  = $_GET['FR'];
$name_en  = $_GET['EN'];
$sql = "UPDATE product_option SET name_fr = '" . $name_fr . "',name_en = '" . $name_en . "' WHERE id = '" . $option_id . "'  LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo $sql;
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>