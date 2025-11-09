<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';

$THA_KEY    = mysqli_real_escape_string($dw3_conn,$_GET['MONERIS_KEY']);
                  
	$sql = "INSERT INTO config
    (kind, code,text1)
    VALUES 
        ('CIE', 'SMS_KEY', '" . $THA_KEY    . "')
        ON DUPLICATE KEY UPDATE text1 = VALUES(text1);";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "Les options pour l'API Moneris a été mise &#224; jour";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>