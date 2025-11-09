<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SQUARE_APP   = $_GET['SQUARE_APP'];
$SQUARE_KEY    = $_GET['SQUARE_KEY'];
$SQUARE_DEV    = $_GET['SQUARE_DEV'];
$SQUARE_MODE    = $_GET['SQUARE_MODE'];
                  
	$sql = "INSERT INTO config
    (kind, code,text1,text2,text3,text4)
    VALUES 
        ('CIE', 'SQUARE_KEY', '" . $SQUARE_KEY . "','" . $SQUARE_DEV . "','" . $SQUARE_MODE . "','" . $SQUARE_APP . "')
        ON DUPLICATE KEY UPDATE text1 = VALUES(text1),text2 = VALUES(text2),text3 = VALUES(text3),text4 = VALUES(text4);";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "Les options pour l'API Square ont étés mises à jour";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>