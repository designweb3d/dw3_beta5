<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';

$GENR	= mysqli_real_escape_string($dw3_conn,$_GET['GENR']);
$CODE  = mysqli_real_escape_string($dw3_conn,$_GET['CODE']);

if (trim($GENR) == "PRODUCT_STAT" && trim($CODE) == "0"){die($dw3_lbl["DEL_ERR1"]);}
if (trim($GENR) == "PRODUCT_STAT" && trim($CODE) == "1"){die($dw3_lbl["DEL_ERR1"]);}

	$sql = "DELETE FROM config WHERE kind = '" . $GENR  . "' AND code = '" . $CODE  . "' ;";
	if ($dw3_conn->query($sql) === TRUE) {
	    echo $GENR . "/" . $CODE . " " . $dw3_lbl["DELETED"];
	} else {
	    echo $dw3_conn->error;
	}
$dw3_conn->close();
?>