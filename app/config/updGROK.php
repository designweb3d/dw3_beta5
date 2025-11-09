<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$GPT_KEY    = mysqli_real_escape_string($dw3_conn,$_GET['GPT_KEY']);
$GPT_USER    = mysqli_real_escape_string($dw3_conn,$_GET['GPT_USER']);
                  
	$sql = "INSERT INTO config
    (kind, code,text1)
    VALUES 
        ('CIE', 'GROK_KEY', '" . $GPT_KEY    . "')
        ON DUPLICATE KEY UPDATE text1 = VALUES(text1);";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "Les options pour l'API Grok ont étés mises à jour";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>