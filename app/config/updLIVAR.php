<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$LIVAR_KEY = $_GET['AUTH'];
$LIVAR_DEV = $_GET['DEV'];
$LIVAR_MODE = $_GET['MODE'];
                  
	$sql = "INSERT INTO config (kind, code,text1, text2) VALUES 
        ('CIE', 'LIVAR_KEY', '" . $LIVAR_KEY    . "','" . $LIVAR_DEV    . "'),
        ('CIE', 'LIVAR_MODE', '" . $LIVAR_MODE    . "','')
        ON DUPLICATE KEY UPDATE text1 = VALUES(text1),text2 = VALUES(text2);";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "Les options pour l'API de Livraison à Rabais ont étés mises à jour.";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>