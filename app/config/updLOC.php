<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID   = $_GET['ID'];
$SQUARE   = $_GET['SQUARE'];
$NOM   = mysqli_real_escape_string($dw3_conn,$_GET['NOM']);
$TYPE  = mysqli_real_escape_string($dw3_conn,$_GET['TYPE']);
$EML1   = mysqli_real_escape_string($dw3_conn,$_GET['EML1']);
$ADR1  = str_replace("'","’",mysqli_real_escape_string($dw3_conn,$_GET['ADR1']));
$ADR2  = str_replace("'","’",mysqli_real_escape_string($dw3_conn,$_GET['ADR2']));
$TEL1  = mysqli_real_escape_string($dw3_conn,$_GET['TEL1']);
$VILLE = str_replace("'","’",mysqli_real_escape_string($dw3_conn,$_GET['VILLE']));
$PROV  = mysqli_real_escape_string($dw3_conn,$_GET['PROV']);
$USID  = $_GET['USID'];
$STAT  = $_GET['STAT'];
$PICKUP  = $_GET['PICKUP'];
$CP    = mysqli_real_escape_string($dw3_conn,$_GET['CP']);
$LNG    = $_GET['LNG'];
$LAT    = $_GET['LAT'];

	$sql = "UPDATE location
     SET    
	 name  = '" . $NOM   . "',
	 square_id  = '" . $SQUARE   . "',
	 type = '" . $TYPE  . "',
	 allow_pickup = '" . $PICKUP  . "',
	 eml1 = '" . $EML1  . "',
	 adr1 = '" . $ADR1  . "',
	 adr2 = '" . $ADR2  . "',
	 tel1 = '" . $TEL1  . "',
	 city= '" . $VILLE . "',
	 province = '" . $PROV  . "',
	 country = 'Canada',
	 user_id = '" . $USID  . "',
	 stat = '" . $STAT  . "',
	 longitude = '" . $LNG  . "',
	 latitude = '" . $LAT  . "',
	 postal_code   = '" . $CP    . "'
	 WHERE id = '" . $ID . "'";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "0";
	} else {
	  echo $dw3_conn->error;
	}

if ($ID == "1"){
	$sql = "INSERT INTO config
    (kind, code,text1)
    VALUES 
        ('CIE', 'ADR1', '" . $ADR1  . "'),
        ('CIE', 'ADR2', '" . $ADR2  . "'),
        ('CIE', 'VILLE', '" . $VILLE  . "'),
        ('CIE', 'PROV', '" . $PROV  . "'),
        ('CIE', 'CP', '" . $CP  . "')
        ON DUPLICATE KEY UPDATE text1 = VALUES(text1);";
        if ($dw3_conn->query($sql) === TRUE) {
            $dw3_conn->close();
            die("");
          } else {
            $dw3_conn->close();
            die($dw3_conn->error);
          }
}else{
    $dw3_conn->close();
    die(""); 
}
?>