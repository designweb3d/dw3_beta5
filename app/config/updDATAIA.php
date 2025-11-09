<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$DKEY    = mysqli_real_escape_string($dw3_conn,$_GET['DKEY']);
                  
	$sql = "INSERT INTO config
    (kind, code,text1)
    VALUES 
        ('CIE', 'DATAIA_KEY', '" . $DKEY    . "')
        ON DUPLICATE KEY UPDATE text1 = VALUES(text1);";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "Les options pour l'API Data IA ont étés mises à jour";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>