<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID     = $_GET['ID'];
$NOM    = dw3_crypt(mysqli_real_escape_string($dw3_conn,$_GET['NOM']));
$CIE    = mysqli_real_escape_string($dw3_conn,$_GET['CIE']);
$EML    = dw3_crypt(mysqli_real_escape_string($dw3_conn,$_GET['EML']));
$ADR1   = dw3_crypt(mysqli_real_escape_string($dw3_conn,$_GET['ADR1']));
$ADR2   = dw3_crypt(mysqli_real_escape_string($dw3_conn,$_GET['ADR2']));
$VILLE  = mysqli_real_escape_string($dw3_conn,$_GET['VILLE']);
$PROV   = mysqli_real_escape_string($dw3_conn,$_GET['PROV']);
$PAYS   = mysqli_real_escape_string($dw3_conn,$_GET['PAYS']);
$DTDU     = $_GET['DTDU'];
$CP     = $_GET['CP'];
$NOTE   = mysqli_real_escape_string($dw3_conn,$_GET['NOTE']);

	$sql = "UPDATE invoice_head
     SET    
	 name    = '" . $NOM    . "',
	 eml    = '" . $EML    . "',
	 company    = '" . $CIE    . "',
	 adr1   = '" . $ADR1   . "',
	 adr2   = '" . $ADR2   . "',
	 city  = '" . $VILLE  . "',
	 prov   = '" . $PROV   . "',
	 country   = '" . $PAYS   . "',
	 postal_code     = '" . $CP     . "',
	 note   = '" . $NOTE   . "',
	 date_modified   = '" . $datetime   . "',
	 user_modified   = '" . $USER   . "',
     date_due    = '" . $DTDU    . "'
	 
	 WHERE id = '" . $ID . "' 
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
