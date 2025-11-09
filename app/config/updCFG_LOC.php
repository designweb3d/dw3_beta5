<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';

$LOC_TITLE_FR = htmlspecialchars($_GET['PTF']);
$LOC_TITLE_EN = htmlspecialchars($_GET['PTE']);
$ADR1 = htmlspecialchars($_GET['ADR1']);
$ADR2 = htmlspecialchars($_GET['ADR2']);
$ADR3 = htmlspecialchars($_GET['ADR3']);

	$sql = "INSERT INTO config
    (kind, code,text1,text2,text3)
    VALUES 
        ('CIE', 'DFT_ADR1', '" . $ADR1  . "','',''),
        ('CIE', 'DFT_ADR2', '" . $ADR2  . "','',''),
        ('CIE', 'DFT_ADR3', '" . $ADR3  . "','".$LOC_TITLE_FR."','".$LOC_TITLE_EN."')
        ON DUPLICATE KEY UPDATE text1 = VALUES(text1),text2 = VALUES(text2),text3 = VALUES(text3);";
	if ($dw3_conn->query($sql) === TRUE) {
        header('Status: 200');
	    echo "L'adresse choisie a été mises &#224; jour.";
	} else {
	  echo $dw3_conn->error;
	}
    //error_log($sql);
$dw3_conn->close();
?>