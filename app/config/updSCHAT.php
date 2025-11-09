<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$schatKEY    = $_GET['SKEY'];
$schatKEY1    = $_GET['SKEY1'];
$schatKEY2    = $_GET['SKEY2'];
$schatCHECK    = $_GET['SCHECK'];

                  
	$sql = "INSERT INTO config (kind, code,text1,text2,text3,text4)
    VALUES 
        ('CIE', 'SCHAT_KEY', '" . $schatKEY . "','" . $schatKEY1 . "','" . $schatKEY2 . "','" . $schatCHECK . "')
        ON DUPLICATE KEY UPDATE text1 = VALUES(text1),text2 = VALUES(text2),text3 = VALUES(text3),text4 = VALUES(text4);";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "Les options pour l'AI Support Chat a été mise &#224; jour";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>