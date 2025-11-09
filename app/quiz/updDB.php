<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$DB   = $_GET['DB'];
$ROW  = $_GET['ROW'];
$VAL  = $_GET['VAL'];
$ID  = $_GET['ID'];

if($DB == "customer" && $ROW == "name"){
    $ROW = "last_name";
    $VAL = dw3_crypt($VAL);
} else if($DB == "customer" && $ROW == "tel1"){
    $VAL = dw3_crypt($VAL);
} else if($DB == "customer" && $ROW == "adr1"){
    $VAL = dw3_crypt($VAL);
} else if($DB == "customer" && $ROW == "adr2"){
    $VAL = dw3_crypt($VAL);
}

$sql = "UPDATE ".$DB." SET    
	 ".$ROW."   = '" . $VAL   . "'
	 WHERE id = '" . $ID . "' 
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
exit();
?>