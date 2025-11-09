<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';

$SMS_KEY    = mysqli_real_escape_string($dw3_conn,$_GET['SMS_KEY']);
$SMS_SENDER    = mysqli_real_escape_string($dw3_conn,$_GET['SMS_SENDER']);
                  
	$sql = "INSERT INTO config
    (kind, code,text1)
    VALUES 
        ('CIE', 'SMS_KEY', '" . $SMS_KEY    . "'),
        ('CIE', 'SMS_SENDER', '" . $SMS_SENDER    . "')
        ON DUPLICATE KEY UPDATE text1 = VALUES(text1);";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "Les options pour l'API SMS.to a été mise &#224; jour";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>