<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$COLOR1 = $_GET['COLOR1'];
$COLOR1_2 = $_GET['COLOR1_2'];
$COLOR1_3 = $_GET['COLOR1_3'];
$COLOR2 = $_GET['COLOR2'];
$COLOR3 = $_GET['COLOR3'];
$COLOR4 = $_GET['COLOR4'];
$COLOR5 = $_GET['COLOR5'];
$COLOR0 = $_GET['COLOR0'];
$COLOR0_1 = $_GET['COLOR0_1'];
$COLOR6 = $_GET['COLOR6'];
$COLOR6_2 = $_GET['COLOR6_2'];
$COLOR7 = $_GET['COLOR7'];
$COLOR7_2 = $_GET['COLOR7_2'];
$COLOR7_3 = $_GET['COLOR7_3'];
$COLOR7_4 = $_GET['COLOR7_4'];
$COLOR8 = $_GET['COLOR8'];
$COLOR8_2 = $_GET['COLOR8_2'];
$COLOR8_3 = $_GET['COLOR8_3'];
$COLOR8_3S = $_GET['COLOR8_3S'];
$COLOR8_4 = $_GET['COLOR8_4'];
$COLOR8_4S = $_GET['COLOR8_4S'];
$COLOR9 = $_GET['COLOR9'];
$COLOR10 = $_GET['COLOR10'];
$COLOR11_1 = $_GET['COLOR11_1'];
$COLOR11_2 = $_GET['COLOR11_2'];
$COLOR11_3 = $_GET['COLOR11_3'];
                  
	$sql = "INSERT INTO config
    (kind, code, text1, text2, text3, text4)
    VALUES 
        ('CIE', 'COLOR1', '" . $COLOR1 . "','','',''),
        ('CIE', 'COLOR1_2', '" . $COLOR1_2 . "','','',''),
        ('CIE', 'COLOR1_3', '" . $COLOR1_3 . "','','',''),
        ('CIE', 'COLOR2', '" . $COLOR2 . "','','',''),
        ('CIE', 'COLOR3', '" . $COLOR3 . "','','',''),
        ('CIE', 'COLOR4', '" . $COLOR4 . "','','',''),
        ('CIE', 'COLOR5', '" . $COLOR5 . "','','',''),
        ('CIE', 'COLOR0', '" . $COLOR0 . "','','',''),
        ('CIE', 'COLOR0_1', '" . $COLOR0_1 . "','','',''),
        ('CIE', 'COLOR6', '" . $COLOR6 . "','" . $COLOR6_2 . "','',''),
        ('CIE', 'COLOR7', '" . $COLOR7 . "','" . $COLOR7_2 . "','" . $COLOR7_3 . "','" . $COLOR7_4 . "'),
        ('CIE', 'COLOR8', '" . $COLOR8 . "','','',''),
        ('CIE', 'COLOR8_2', '" . $COLOR8_2 . "','','',''),
        ('CIE', 'COLOR8_3', '" . $COLOR8_3 . "','','',''),
        ('CIE', 'COLOR8_3S', '" . $COLOR8_3S . "','','',''),
        ('CIE', 'COLOR8_4', '" . $COLOR8_4 . "','','',''),
        ('CIE', 'COLOR8_4S', '" . $COLOR8_4S . "','','',''),
        ('CIE', 'COLOR9', '" . $COLOR9 . "','','',''),
        ('CIE', 'COLOR10', '" . $COLOR10 . "','','',''),
        ('CIE', 'COLOR11', '" . $COLOR11_1 . "','" . $COLOR11_2 . "','" . $COLOR11_3 . "','')
        ON DUPLICATE KEY UPDATE text1 = VALUES(text1),text2 = VALUES(text2),text3 = VALUES(text3),text4 = VALUES(text4);";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "0";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>