<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
//$PPKEY    = $_GET['PPKEY'];
//$PPSECRET    = $_GET['PPSECRET'];
//$PPKEY_DEV    = $_GET['PPKEY_DEV'];
//$PPSECRET_DEV    = $_GET['PPSECRET_DEV'];
$PPMODE    = $_GET['PPMODE'];
$PPUSER    = $_GET['PPUSER'];
$PPUSER_DEV    = $_GET['PPUSERDEV'];
//$PPPW    = $_GET['PPPW'];
                  
	$sql = "INSERT INTO config (kind, code,text1,text2,text3,text4)
    VALUES 
        ('CIE', 'PAYPAL_KEY', '" . $PPUSER . "','" . $PPUSER_DEV . "','" . $PPMODE . "','')
        ON DUPLICATE KEY UPDATE text1 = VALUES(text1),text2 = VALUES(text2),text3 = VALUES(text3),text4 = VALUES(text4);";
/* 	$sql = "INSERT INTO config (kind, code,text1,text2,text3,text4)
    VALUES 
        ('CIE', 'PAYPAL_KEY', '" . $PPKEY . "','" . $PPSECRET . "','" . $PPKEY_DEV . "','" . $PPSECRET_DEV . "'),
        ('CIE', 'PAYPAL_MODE', '" . $PPMODE . "', '" . $PPUSER . "','" . $PPPW . "','')
        ON DUPLICATE KEY UPDATE text1 = VALUES(text1),text2 = VALUES(text2),text3 = VALUES(text3),text4 = VALUES(text4);"; */
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "Les options pour l'API Paypal ont étés mises à jour";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>