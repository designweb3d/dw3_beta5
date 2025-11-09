<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID     = $_GET['ID'];
$STAT     = $_GET['STAT'];
$LOC    = mysqli_real_escape_string($dw3_conn,$_GET['LOC']);
$CIE    = mysqli_real_escape_string($dw3_conn,$_GET['CIE']);
$NOM    = dw3_crypt(mysqli_real_escape_string($dw3_conn,$_GET['NOM']));
$ADR1   = dw3_crypt(mysqli_real_escape_string($dw3_conn,$_GET['ADR1']));
$ADR2   = dw3_crypt(mysqli_real_escape_string($dw3_conn,$_GET['ADR2']));
$VILLE  = mysqli_real_escape_string($dw3_conn,$_GET['VILLE']);
$PROV   = mysqli_real_escape_string($dw3_conn,$_GET['PROV']);
$PAYS   = mysqli_real_escape_string($dw3_conn,$_GET['PAYS']);
$CP     = mysqli_real_escape_string($dw3_conn,$_GET['CP']);
$ADR1_SH   = dw3_crypt(mysqli_real_escape_string($dw3_conn,$_GET['ADR1_SH']));
$ADR2_SH   = dw3_crypt(mysqli_real_escape_string($dw3_conn,$_GET['ADR2_SH']));
$VILLE_SH  = mysqli_real_escape_string($dw3_conn,$_GET['VILLE_SH']);
$PROV_SH   = mysqli_real_escape_string($dw3_conn,$_GET['PROV_SH']);
$PAYS_SH   = mysqli_real_escape_string($dw3_conn,$_GET['PAYS_SH']);
$CP_SH     = mysqli_real_escape_string($dw3_conn,$_GET['CP_SH']);
$EML   = dw3_crypt(trim(strtolower($_GET['EML'])));
$TRP   = mysqli_real_escape_string($dw3_conn,$_GET['TRP']);
$DISCOUNT   = mysqli_real_escape_string($dw3_conn,$_GET['DSC']);
$TEL   = dw3_crypt(mysqli_real_escape_string($dw3_conn,$_GET['TEL']));
$DTLV     = $_GET['DTLV'];
$NOTE   = mysqli_real_escape_string($dw3_conn,$_GET['NOTE']);

	$sql = "UPDATE order_head
     SET    
	 stat    = '" . $STAT    . "',
	 location_id    = '" . $LOC    . "',
	 name    = '" . $NOM    . "',
	 company    = '" . $CIE    . "',
	 adr1   = '" . $ADR1   . "',
	 adr2   = '" . $ADR2   . "',
	 city  = '" . $VILLE  . "',
	 prov   = '" . $PROV   . "',
	 country   = '" . $PAYS   . "',
	 postal_code     = '" . $CP     . "',
	 adr1_sh   = '" . $ADR1_SH   . "',
	 adr2_sh   = '" . $ADR2_SH   . "',
	 city_sh  = '" . $VILLE_SH  . "',
	 province_sh   = '" . $PROV_SH   . "',
	 country_sh   = '" . $PAYS_SH   . "',
	 postal_code_sh     = '" . $CP_SH     . "',
	 transport     = '" . $TRP     . "',
	 discount     = '" . $DISCOUNT  . "',
	 eml     = '" . $EML     . "',
	 tel     = '" . $TEL     . "',
	 note   = '" . $NOTE   . "',
	 date_modified   = '" . $datetime   . "',
	 user_modified   = '" . $USER   . "',
     date_delivery    = '" . $DTLV    . "'
	 WHERE id = '" . $ID . "' 
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
