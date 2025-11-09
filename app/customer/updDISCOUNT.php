<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$DID     = $_GET['DID'];
$DP    = $_GET['DP']??'0';
$DS   = $_GET['DS'];
$DC   = $_GET['DC']??'0';
$D1   = $_GET['D1'];

//update
	$sql = "UPDATE customer_discount SET    
	 product_id = '" . $DP   . "',
	 supplier_id = '" . $DS   . "',
	 category_id = '" . $DC   . "',
	 escount_pourcent = '" . $D1   . "'
	 WHERE id = '" . $DID . "' LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
        echo "";
	} else {
	    echo $dw3_conn->error;
	}
$dw3_conn->close();
?>