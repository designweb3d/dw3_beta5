<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$LIMIT    = $_GET['LIMIT'];
//$RECH_COL = $_GET['RCOL'];
$ORDERBY = $_GET['ORDB'];
$ORDERWAY = $_GET['ORDW'];
$ID   	 = $_GET['ID'];
$STAT     = $_GET['STAT'];
$NOM      = $_GET['NOM'];
$ADR    = $_GET['ADR'];
$VILLE    = $_GET['VILLE'];
$PROV    = $_GET['PROV'];
$PAYS    = $_GET['PAYS'];
$CP     = $_GET['CP'];
$NOTE    = $_GET['NOTE'];
$DTAD    = $_GET['DTAD'];
$DTDU    = $_GET['DTDU'];
$DTMD    = $_GET['DTMD'];
               
	$sql = "INSERT INTO app_prm
    (app_id, user_id,name,value)
    VALUES 
        ('" . $APID . "', '" . $USER . "','ORDERBY', '" . $ORDERBY  . "'),
        ('" . $APID . "', '" . $USER . "','ORDERWAY', '" . $ORDERWAY  . "'),
        ('" . $APID . "', '" . $USER . "','LIMIT', '" . $LIMIT  . "'),
        ('" . $APID . "', '" . $USER . "','ID', '" . $ID  . "'),
        ('" . $APID . "', '" . $USER . "','STAT', '" . $STAT   . "'),
        ('" . $APID . "', '" . $USER . "','NOM', '" . $NOM    . "'),
        ('" . $APID . "', '" . $USER . "','ADR', '" . $ADR  . "'),
        ('" . $APID . "', '" . $USER . "','VILLE', '" . $VILLE  . "'),
        ('" . $APID . "', '" . $USER . "','PROV', '" . $PROV  . "'),
        ('" . $APID . "', '" . $USER . "','PAYS', '" . $PAYS  . "'),
        ('" . $APID . "', '" . $USER . "','CP', '" . $CP   . "'),
        ('" . $APID . "', '" . $USER . "','DTAD', '" . $DTAD  . "'),
        ('" . $APID . "', '" . $USER . "','DTDU', '" . $DTDU  . "'),
        ('" . $APID . "', '" . $USER . "','DTMD', '" . $DTMD  . "'),
        ('" . $APID . "', '" . $USER . "','NOTE', '" . $NOTE  . "')
        ON DUPLICATE KEY UPDATE value = VALUES(value);";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
