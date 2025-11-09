<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';

$SID    = mysqli_real_escape_string($dw3_conn,$_GET['SID']);
$AUTH    = mysqli_real_escape_string($dw3_conn,$_GET['AUTH']);
$SENDER    = mysqli_real_escape_string($dw3_conn,$_GET['SENDER']);
                  
	$sql = "INSERT INTO config
    (kind, code,text1)
    VALUES 
        ('CIE', 'TWILIO_SID', '" . $SID    . "'),
        ('CIE', 'TWILIO_AUTH', '" . $AUTH    . "'),
        ('CIE', 'TWILIO_SENDER', '" . $SENDER    . "')
        ON DUPLICATE KEY UPDATE text1 = VALUES(text1);";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "Les options pour l'API Twilio a été mise &#224; jour";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>