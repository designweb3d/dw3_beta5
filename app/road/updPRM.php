<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$CID   = $_GET['CID'];
$GPS    = $_GET['GPS'];
/* $HW = $_GET['HW'];
$FERRY = $_GET['FER']; */

               
	$sql = "INSERT INTO app_prm
    (app_id, user_id,name,value)
    VALUES 
        ('" . $APID . "', '" . $USER . "','CarteID', '" . $CID  . "'),
        ('" . $APID . "', '" . $USER . "','GPS', '" . $GPS  . "')
        ON DUPLICATE KEY UPDATE value = VALUES(value);";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>