<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID   = $_GET['ID'];
$STAT   = $_GET['STAT'];
$LANG   = $_GET['LANG'];
$TYPE   = $_GET['TYPE']??"";
$NOM    = str_replace("'","’", $_GET['NOM']);
$NOM_CONTACT    = str_replace("'","’", $_GET['NOM_CONTACT']);
$TEL1   = str_replace("'","’", $_GET['TEL1']);
$TEL2   = str_replace("'","’", $_GET['TEL2']);
$ADR1   = str_replace("'","’", $_GET['ADR1']);
$ADR2   = str_replace("'","’", $_GET['ADR2']);
$VILLE  = str_replace("'","’", $_GET['VILLE']);
$PROV   = str_replace("'","’", $_GET['PROV']);
$PAYS   = str_replace("'","’", $_GET['PAYS']);
$CP     = str_replace("'","’", $_GET['CP']);
$EML1   = str_replace("'","’", $_GET['EML1']);
$EML2   = str_replace("'","’", $_GET['EML2']);
$NOTE   = str_replace("'","’", $_GET['NOTE']);
$LNG  = str_replace("'","’", $_GET['LNG']);
$LAT  = str_replace("'","’", $_GET['LAT']);

	$sql = "UPDATE supplier
     SET    
	 date_modified   = '" . $datetime   . "',
	 stat   = '" . $STAT   . "',
	 lang   = '" . $LANG   . "',
	 type   = '" . $TYPE   . "',
	 company_name    = '" . $NOM    . "',
	 contact_name    = '" . $NOM_CONTACT   . "',
	 tel1   = '" . $TEL1   . "',
	 tel2   = '" . $TEL2   . "',
	 adr1   = '" . $ADR1   . "',
	 adr2   = '" . $ADR2   . "',
	 city  = '" . $VILLE  . "',
	 province   = '" . $PROV   . "',
	 country   = '" . $PAYS   . "',
	 postal_code     = '" . $CP     . "',
	 eml1   = '" . $EML1   . "',
	 eml2   = '" . $EML2   . "',
	 note   = '" . $NOTE   . "',
     longitude    = '" . $LNG    . "',
     latitude    = '" . $LAT    . "'
	 
	 WHERE id = '" . $ID . "' 
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>