<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';

$FN1    = $_GET['F1'];
$FN2    = $_GET['F2'];
$FN3    = $_GET['F3'];
$FN4    = $_GET['F4'];
                  
	$sql = "INSERT INTO config
    (kind, code,text1)
    VALUES 
        ('CIE', 'FONT1', '" . $FN1    . "'),
        ('CIE', 'FONT2', '" . $FN2    . "'),
        ('CIE', 'FONT3', '" . $FN3    . "'),
        ('CIE', 'FONT4', '" . $FN4    . "')
        ON DUPLICATE KEY UPDATE text1 = VALUES(text1);";
	if ($dw3_conn->query($sql) === TRUE) {
        header('Status: 200');
	    echo "Les polices de caractères ont étés mises &#224; jour.";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>