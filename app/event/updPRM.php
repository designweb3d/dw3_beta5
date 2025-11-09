<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$LIMIT    = $_GET['LIMIT'];
$RECH_COL = $_GET['RCOL']??'';
$ORDERBY = $_GET['ORDB'];
$ORDERWAY = $_GET['ORDW'];
$ID   	 = $_GET['ID'];
$TYPE     = $_GET['TYPE'];
$NAME      = $_GET['NAME'];
$DESC    = $_GET['DESC'];
$DTMD    = $_GET['DTMD'];
               
	$sql = "INSERT INTO app_prm
    (app_id, user_id,name,value)
    VALUES 
        ('" . $APID . "', '" . $USER . "','ORDERBY', '" . $ORDERBY  . "'),
        ('" . $APID . "', '" . $USER . "','ORDERWAY', '" . $ORDERWAY  . "'),
        ('" . $APID . "', '" . $USER . "','LIMIT', '" . $LIMIT  . "'),
        ('" . $APID . "', '" . $USER . "','RECH_COL', '" . $RECH_COL  . "'),
        ('" . $APID . "', '" . $USER . "','ID', '" . $ID  . "'),
        ('" . $APID . "', '" . $USER . "','TYPE', '" . $TYPE   . "'),
        ('" . $APID . "', '" . $USER . "','NAME', '" . $NAME    . "'),
        ('" . $APID . "', '" . $USER . "','DESC', '" . $DESC  . "'),
        ('" . $APID . "', '" . $USER . "','DTMD', '" . $DTMD  . "')
        ON DUPLICATE KEY UPDATE value = VALUES(value);";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>