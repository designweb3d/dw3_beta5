<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$LIMIT    = $_GET['LIMIT'];
//$RECH_COL = $_GET['RCOL'];
$ORDERBY = $_GET['ORDB'];
$ORDERWAY = $_GET['ORDW'];
$ID   = $_GET['ID'];
$KIND  = $_GET['KIND'];
$NOM   = $_GET['NOM'];
$DESC  = $_GET['DESC'];
$CAT   = $_GET['CAT'];
$TOTAL   = $_GET['CAT'];
$FRN1  = $_GET['FRN1'];
$PACK  = $_GET['PACK'];
$KG    = $_GET['KG'];
$WIDTH = $_GET['WIDTH'];
$HEIGHT = $_GET['HEIGHT'];
$DEPTH = $_GET['DEPTH'];
$JOURS = $_GET['JOUR'];
$TOTAL = $_GET['TOTAL'];
$DTAD = $_GET['DTAD'];
$DTMD = $_GET['DTMD'];
               
	$sql = "INSERT INTO app_prm
    (app_id, user_id,name,value)
    VALUES 
        ('" . $APID . "', '" . $USER . "','ORDERBY', '" . $ORDERBY  . "'),
        ('" . $APID . "', '" . $USER . "','ORDERWAY', '" . $ORDERWAY  . "'),
        ('" . $APID . "', '" . $USER . "','LIMIT', '" . $LIMIT  . "'),
        ('" . $APID . "', '" . $USER . "','RECH_COL', '" . $RECH_COL  . "'),
        ('" . $APID . "', '" . $USER . "','ID', '" . $ID  . "'),
        ('" . $APID . "', '" . $USER . "','KIND', '" .  $KIND   . "'),
        ('" . $APID . "', '" . $USER . "','NOM', '" .   $NOM    . "'),
        ('" . $APID . "', '" . $USER . "','DESC', '" .  $DESC  . "'),
        ('" . $APID . "', '" . $USER . "','CAT', '" .   $CAT   . "'),
        ('" . $APID . "', '" . $USER . "','TOTAL', '" .   $TOTAL   . "'),
        ('" . $APID . "', '" . $USER . "','FRN1', '" .  $FRN1  . "'),
        ('" . $APID . "', '" . $USER . "','PACK', '" .  $PACK  . "'),
        ('" . $APID . "', '" . $USER . "','KG', '" .    $KG . "'),
        ('" . $APID . "', '" . $USER . "','WIDTH', '" . $WIDTH  . "'),
        ('" . $APID . "', '" . $USER . "','HEIGHT', '" .$HEIGHT  . "'),
        ('" . $APID . "', '" . $USER . "','DEPTH', '" . $DEPTH  . "'),
        ('" . $APID . "', '" . $USER . "','JOURS_CONSERV', '" . $JOURS_CONSERV . "'),
        ('" . $APID . "', '" . $USER . "','DTAD', '" .  $DTAD  . "'),
        ('" . $APID . "', '" . $USER . "','DTMD', '" .  $DTMD  . "')
        ON DUPLICATE KEY UPDATE value = VALUES(value);";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>