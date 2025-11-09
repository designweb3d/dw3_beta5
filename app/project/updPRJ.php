<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID     = $_GET['ID'];
$STAT     = $_GET['STAT'];
$NOM    = mysqli_real_escape_string($dw3_conn,$_GET['NOM']);
$ADR   = mysqli_real_escape_string($dw3_conn,$_GET['ADR']);
$VILLE  = mysqli_real_escape_string($dw3_conn,$_GET['VILLE']);
$PROV   = mysqli_real_escape_string($dw3_conn,$_GET['PROV']);
$PAYS   = mysqli_real_escape_string($dw3_conn,$_GET['PAYS']);
$DTAD     = $_GET['DTAD'];
$DTDU     = $_GET['DTDU'];
$CP     = $_GET['CP'];
$DESC   = mysqli_real_escape_string($dw3_conn,$_GET['DESC']);
$NOTE   = mysqli_real_escape_string($dw3_conn,$_GET['NOTE']);

	$sql = "UPDATE project
     SET    
	 title    = '" . $NOM . "',
	 status    = '" . $STAT . "',
	 adr   = '" . $ADR . "',
	 city  = '" . $VILLE  . "',
	 province   = '" . $PROV   . "',
	 country   = '" . $PAYS   . "',
	 postal_code     = '" . $CP     . "',
	 note   = '" . $NOTE   . "',
	 description   = '" . $DESC   . "',
	 date_created   = '" . $DTAD   . "',
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
