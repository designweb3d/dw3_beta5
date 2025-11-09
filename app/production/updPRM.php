<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$DOC_TYPE    = $_GET['DOC_TYPE'];
$LIMIT    = $_GET['LIMIT'];
//$RECH_COL = $_GET['RCOL'];
$ORDERBY = $_GET['ORDB'];
$ORDERWAY = $_GET['ORDW'];
$ID   = $_GET['ID'];
$STAT  = $_GET['STAT'];
$NOM   = $_GET['NOM'];
$PROC  = $_GET['PROC'];
$CAT   = $_GET['CAT'];
$ORDER   = $_GET['ORDER'];
$STORAGE  = $_GET['STORAGE'];
$LOT  = $_GET['LOT'];
$QTY  = $_GET['QTY'];
$START  = $_GET['START'];
$DUE    = $_GET['DUE'];
$END    = $_GET['END'];

	$sql = "INSERT INTO app_prm
    (app_id, user_id,name,value)
    VALUES 
        ('" . $APID . "', '" . $USER . "','DOC_TYPE', '" . $DOC_TYPE  . "'),
        ('" . $APID . "', '" . $USER . "','ORDERBY', '" . $ORDERBY  . "'),
        ('" . $APID . "', '" . $USER . "','ORDERWAY', '" . $ORDERWAY  . "'),
        ('" . $APID . "', '" . $USER . "','LIMIT', '" . $LIMIT  . "'),
        ('" . $APID . "', '" . $USER . "','ID', '" . $ID  . "'),
        ('" . $APID . "', '" . $USER . "','STAT', '" .  $STAT   . "'),
        ('" . $APID . "', '" . $USER . "','NOM', '" .   $NOM    . "'),
        ('" . $APID . "', '" . $USER . "','PROC', '" .  $PROC  . "'),
        ('" . $APID . "', '" . $USER . "','CAT', '" .   $CAT   . "'),
        ('" . $APID . "', '" . $USER . "','ORDER', '" .   $ORDER   . "'),
        ('" . $APID . "', '" . $USER . "','STORAGE', '" .  $STORAGE  . "'),
        ('" . $APID . "', '" . $USER . "','LOT', '" .  $LOT  . "'),
        ('" . $APID . "', '" . $USER . "','QTY', '" .  $QTY  . "'),
        ('" . $APID . "', '" . $USER . "','START', '" .  $START  . "'),
        ('" . $APID . "', '" . $USER . "','DUE', '" .    $DUE . "'),
        ('" . $APID . "', '" . $USER . "','END', '" . $END  . "')
        ON DUPLICATE KEY UPDATE value = VALUES(value);";

	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>