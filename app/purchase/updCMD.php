<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID     = $_GET['ID'];
$PRJ     = $_GET['PRJ'];
$NOM    = mysqli_real_escape_string($dw3_conn,$_GET['NOM']);
$ADR1   = mysqli_real_escape_string($dw3_conn,$_GET['ADR1']);
$ADR2   = mysqli_real_escape_string($dw3_conn,$_GET['ADR2']);
$VILLE  = mysqli_real_escape_string($dw3_conn,$_GET['VILLE']);
$PROV   = mysqli_real_escape_string($dw3_conn,$_GET['PROV']);
$PAYS   = mysqli_real_escape_string($dw3_conn,$_GET['PAYS']);
$DTAD     = $_GET['DTAD'];
$DTDU     = $_GET['DTDU'];
$CP     = $_GET['CP'];
$PID     = $_GET['PID'];
$NOTE   = mysqli_real_escape_string($dw3_conn,$_GET['NOTE']);

	$sql = "UPDATE purchase_head
     SET    
	 name    = '" . $NOM    . "',
	 project_id    = '" . $PRJ . "',
	 adr1   = '" . $ADR1   . "',
	 adr2   = '" . $ADR2   . "',
	 city  = '" . $VILLE  . "',
	 prov   = '" . $PROV   . "',
	 country   = '" . $PAYS   . "',
	 postal_code     = '" . $CP     . "',
	 supplier_pid     = '" . $PID     . "',
	 note   = '" . $NOTE   . "',
	 date_created   = '" . $DTAD   . "',
	 date_modified   = '" . $datetime   . "',
	 user_modified   = '" . $USER   . "',
     date_due    = '" . $DTDU    . "'
	 
	 WHERE id = '" . $ID . "' 
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
      	$sql2 = "UPDATE gls SET  year = '" . substr($DTDU,0,4) . "',  period = '" . substr($DTDU,5,2) . "'
        WHERE source = 'PURCHASE' AND source_id = '" . $ID . "' AND source_id <> 0;";
        $dw3_conn->query($sql2);
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
