<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$pack_id  = $_GET['PACK'];
$name_fr  = $_GET['FR'];
$name_en  = $_GET['EN'];
$pack_qty  = $_GET['QTY'];
$pack_price  = $_GET['PRICE'];
$sql = "UPDATE product_pack SET pack_name_fr = '" . $name_fr . "',pack_name_en = '" . $name_en . "',pack_qty = '" . $pack_qty . "',pack_price = '" . $pack_price . "' WHERE id = '" . $pack_id . "'  LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo $sql;
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>