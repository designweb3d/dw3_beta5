<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';

$POSTE_USER    = mysqli_real_escape_string($dw3_conn,$_GET['POSTE_USER']);
$POSTE_PW    = mysqli_real_escape_string($dw3_conn,$_GET['POSTE_PW']);
$POSTE_KEY    = mysqli_real_escape_string($dw3_conn,$_GET['POSTE_KEY']);
$POSTE_MODE    = mysqli_real_escape_string($dw3_conn,$_GET['POSTE_MODE']);
              
/* $user_ini = "username = ". $POSTE_USER . "\n"
."password = ".$POSTE_PW ."\n"
. "customerNumber = ".$POSTE_KEY . "\n";
file_put_contents($_SERVER['DOCUMENT_ROOT'].'/api/poste_canada/REST/rating/user.ini', $user_ini); */

	$sql = "INSERT INTO config
    (kind, code,text1)
    VALUES 
        ('CIE', 'POSTE_MODE', '" . $POSTE_MODE    . "'),
        ('CIE', 'POSTE_USER', '" . $POSTE_USER    . "'),
        ('CIE', 'POSTE_PW', '" . $POSTE_PW    . "'),
        ('CIE', 'POSTE_KEY', '" . $POSTE_KEY    . "')
        ON DUPLICATE KEY UPDATE text1 = VALUES(text1);";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "Les options pour l'API Poste Canada ont étés mises à jour";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>