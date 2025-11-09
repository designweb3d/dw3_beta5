<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$NOM   = mysqli_real_escape_string($dw3_conn,$_GET['NOM']);
$EML1   = mysqli_real_escape_string($dw3_conn,$_GET['EML1']);
$ADR1  = mysqli_real_escape_string($dw3_conn,$_GET['ADR1']);
$ADR2  = mysqli_real_escape_string($dw3_conn,$_GET['ADR2']);
$TEL1  = mysqli_real_escape_string($dw3_conn,$_GET['TEL1']);
$VILLE = mysqli_real_escape_string($dw3_conn,$_GET['VILLE']);
$PROV  = mysqli_real_escape_string($dw3_conn,$_GET['PROV']);
$PAYS  = mysqli_real_escape_string($dw3_conn,$_GET['PAYS']??"Canada");
$CP    = mysqli_real_escape_string($dw3_conn,$_GET['CP']);
$TYPE    = mysqli_real_escape_string($dw3_conn,$_GET['TYPE']);

	$sql = "INSERT INTO location
    (name,type,eml1,adr1,adr2,tel1,city,province,country,postal_code)
    VALUES 
        ('" . $NOM   . "',
         '" . $TYPE   . "',
         '" . $EML1   . "',
         '" . $ADR1  . "',
         '" . $ADR2  . "',
         '" . $TEL1  . "',
         '" . $VILLE . "',
         '" . $PROV  . "',
         'Canada',
         '" . $CP    . "')";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "0";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>