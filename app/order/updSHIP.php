<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID     = $_GET['ID'];
$DROP     = $_GET['DROP'];
$SH     = $_GET['SH'];
$DE     = $_GET['DE'];
$EX     = $_GET['EX'];
$LOC     = $_GET['LOC'];
$AMOUNT     = $_GET['AMOUNT'];
$HEIGHT    = mysqli_real_escape_string($dw3_conn,$_GET['HEIGHT']);
$WIDTH    = mysqli_real_escape_string($dw3_conn,$_GET['WIDTH']);
$LENGTH    = mysqli_real_escape_string($dw3_conn,$_GET['LENGTH']);
$WEIGHT    = mysqli_real_escape_string($dw3_conn,$_GET['WEIGHT']);
$NOM    = dw3_crypt(mysqli_real_escape_string($dw3_conn,$_GET['NOM']));
$CIE    = mysqli_real_escape_string($dw3_conn,$_GET['CIE']);
$ADR1   = dw3_crypt(mysqli_real_escape_string($dw3_conn,$_GET['ADR1']));
$ADR2   = dw3_crypt(mysqli_real_escape_string($dw3_conn,$_GET['ADR2']));
$VILLE  = mysqli_real_escape_string($dw3_conn,$_GET['VILLE']);
$PROV   = mysqli_real_escape_string($dw3_conn,$_GET['PROV']);
$PAYS   = mysqli_real_escape_string($dw3_conn,$_GET['PAYS']);
$EML   = dw3_crypt(trim(strtolower($_GET['EML'])));
$TEL   = dw3_crypt(trim(strtolower($_GET['TEL'])));
$CP   = mysqli_real_escape_string($dw3_conn,$_GET['CP']);

	$sql = "UPDATE order_head
     SET    
	 name = '" . $NOM . "',
	 company = '" . $CIE . "',
	 location_id = '" . $LOC . "',
	 sh_drop = '" . $DROP . "',
	 transport = '" . $AMOUNT . "',
	 notif_shipment = '" . $SH . "',
	 notif_exception = '" . $EX . "',
	 notif_delivery = '" . $DE . "',
	 height = '" . $HEIGHT . "',
	 width = '" . $WIDTH . "',
	 length = '" . $LENGTH . "',
	 weight = '" . $WEIGHT . "',
	 adr1_sh = '" . $ADR1 . "',
	 adr2_sh = '" . $ADR2 . "',
	 city_sh = '" . $VILLE . "',
	 province_sh = '" . $PROV . "',
	 country_sh = '" . $PAYS . "',
	 postal_code_sh = '" . $CP . "',
	 eml = '" . $EML . "',
	 tel= '" . $TEL . "',
	 postal_code = '" . $CP . "',
	 date_modified = '" . $datetime . "',
	 user_modified = '" . $USER   . "'
	 WHERE id = '" . $ID . "' 
	 LIMIT 1";
     //error_log($sql);
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>