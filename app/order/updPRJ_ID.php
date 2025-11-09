<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID     = $_GET['ID'];
$PRJ     = $_GET['PRJ'];

	$sql = "UPDATE order_head SET project_id = '" . $PRJ . "' WHERE id = '" . $ID . "'  LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
