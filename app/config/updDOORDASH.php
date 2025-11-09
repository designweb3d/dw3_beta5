<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$DDDEV    = mysqli_real_escape_string($dw3_conn,$_GET['DD_DEV']);
$DDKEY    = mysqli_real_escape_string($dw3_conn,$_GET['DD_KEY']);
$DDSECRET    = mysqli_real_escape_string($dw3_conn,$_GET['DD_SECRET']);
$DDAUTH    = mysqli_real_escape_string($dw3_conn,$_GET['DD_AUTH']);
                  
	$sql = "INSERT INTO config
    (kind, code,text1)
    VALUES 
        ('CIE', 'DOORDASH_DEV', '" . $DDDEV    . "'),
        ('CIE', 'DOORDASH_KEY', '" . $DDKEY    . "'),
        ('CIE', 'DOORDASH_AUTH', '" . $DDAUTH    . "'),
        ('CIE', 'DOORDASH_SECRET', '" . $DDSECRET    . "')
        ON DUPLICATE KEY UPDATE text1 = VALUES(text1);";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "Les options pour l'API DoorDash ont étés mises à jour";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>