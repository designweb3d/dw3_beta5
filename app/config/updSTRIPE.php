<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$STRIPE_KEY    = $_GET['STRIPE_KEY'];
$STRIPE_SECRET    = $_GET['STRIPE_SECRET'];
$STRIPE_TKEY    = $_GET['STRIPE_TKEY'];
$STRIPE_TSECRET    = $_GET['STRIPE_TSECRET'];
$STRIPE_MODE    = $_GET['STRIPE_MODE'];
                  
	$sql = "INSERT INTO config
    (kind, code,text1,text2,text3)
    VALUES 
        ('CIE', 'STRIPE_KEY', '" . $STRIPE_KEY    . "','" . $STRIPE_TKEY    . "','" . $STRIPE_MODE    . "'),
        ('CIE', 'STRIPE_SECRET', '" . $STRIPE_SECRET    . "','" . $STRIPE_TSECRET    . "','')
        ON DUPLICATE KEY UPDATE text1 = VALUES(text1),text2 = VALUES(text2),text3 = VALUES(text3);";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "Les options pour l'API Stripe ont étés mises à jour";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>