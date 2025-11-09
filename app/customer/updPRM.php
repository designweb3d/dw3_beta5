<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$LIMIT    = $_GET['LIMIT'];
$RECH_COL = $_GET['RCOL']??'';
$ORDERBY = $_GET['ORDB'];
$ORDERWAY = $_GET['ORDW'];
$ID   	 = $_GET['ID'];
$FULLNAME	 = $_GET['FNAME'];
$ADR   	 = $_GET['ADR'];
$LANG    = $_GET['LANG'];
$STAT     = $_GET['STAT'];
$TYPE     = $_GET['TYPE'];
$PRENOM    = $_GET['PRENOM'];
$NOM      = $_GET['NOM'];
$CIE      = $_GET['CIE'];
$ADR1    = $_GET['ADR1'];
$ADR2    = $_GET['ADR2'];
$VILLE    = $_GET['VILLE'];
$PROV    = $_GET['PROV'];
$PAYS    = $_GET['PAYS'];
$CP     = $_GET['CP'];
$TEL1    = $_GET['TEL1'];
$TEL2    = $_GET['TEL2'];
$EML1    = $_GET['EML1'];
$EML2    = $_GET['EML2'];
$LNG    = $_GET['LNG'];
$LAT    = $_GET['LAT'];
$NOTE    = $_GET['NOTE'];
$DTAD    = $_GET['DTAD'];
$DTMD    = $_GET['DTMD'];
$BALANCE    = $_GET['BALANCE'];
$FACTURED    = $_GET['FACTURED'];
               
	$sql = "INSERT INTO app_prm
    (app_id, user_id,name,value)
    VALUES 
        ('" . $APID . "', '" . $USER . "','ORDERBY', '" . $ORDERBY  . "'),
        ('" . $APID . "', '" . $USER . "','ORDERWAY', '" . $ORDERWAY  . "'),
        ('" . $APID . "', '" . $USER . "','LIMIT', '" . $LIMIT  . "'),
        ('" . $APID . "', '" . $USER . "','RECH_COL', '" . $RECH_COL  . "'),
        ('" . $APID . "', '" . $USER . "','ID', '" . $ID  . "'),
        ('" . $APID . "', '" . $USER . "','FULLNAME', '" . $FULLNAME  . "'),
        ('" . $APID . "', '" . $USER . "','ADR', '" . $ADR  . "'),
        ('" . $APID . "', '" . $USER . "','LANG', '" . $LANG  . "'),
        ('" . $APID . "', '" . $USER . "','STAT', '" . $STAT   . "'),
        ('" . $APID . "', '" . $USER . "','TYPE', '" . $TYPE   . "'),
        ('" . $APID . "', '" . $USER . "','PRENOM', '" . $PRENOM  . "'),
        ('" . $APID . "', '" . $USER . "','NOM', '" . $NOM    . "'),
        ('" . $APID . "', '" . $USER . "','CIE', '" . $CIE    . "'),
        ('" . $APID . "', '" . $USER . "','ADR1', '" . $ADR1  . "'),
        ('" . $APID . "', '" . $USER . "','ADR2', '" . $ADR2  . "'),
        ('" . $APID . "', '" . $USER . "','VILLE', '" . $VILLE  . "'),
        ('" . $APID . "', '" . $USER . "','PROV', '" . $PROV  . "'),
        ('" . $APID . "', '" . $USER . "','PAYS', '" . $PAYS  . "'),
        ('" . $APID . "', '" . $USER . "','CP', '" . $CP   . "'),
        ('" . $APID . "', '" . $USER . "','TEL1', '" . $TEL1  . "'),
        ('" . $APID . "', '" . $USER . "','TEL2', '" . $TEL2  . "'),
        ('" . $APID . "', '" . $USER . "','EML1', '" . $EML1  . "'),
        ('" . $APID . "', '" . $USER . "','EML2', '" . $EML2  . "'),
        ('" . $APID . "', '" . $USER . "','LNG', '" . $LNG  . "'),
        ('" . $APID . "', '" . $USER . "','LAT', '" . $LAT  . "'),
        ('" . $APID . "', '" . $USER . "','DTAD', '" . $DTAD  . "'),
        ('" . $APID . "', '" . $USER . "','DTMD', '" . $DTMD  . "'),
        ('" . $APID . "', '" . $USER . "','BALANCE', '" . $BALANCE  . "'),
        ('" . $APID . "', '" . $USER . "','FACTURED', '" . $FACTURED  . "'),
        ('" . $APID . "', '" . $USER . "','NOTE', '" . $NOTE  . "')
        ON DUPLICATE KEY UPDATE value = VALUES(value);";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>