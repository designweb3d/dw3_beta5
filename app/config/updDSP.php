<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$L1 = $_GET['L1'];
$L2 = $_GET['L2'];
$L3 = $_GET['L3'];
$L4 = $_GET['L4'];
$L5 = $_GET['L5'];
$B1 = $_GET['B1'];
$B2 = $_GET['B2'];
$B3 = $_GET['B3'];
$B4 = $_GET['B4'];
$B4_PAD = $_GET['B4_PAD'];
$B5 = $_GET['B5']; 
$FRAME = $_GET['F'];
$FADE = $_GET['A'];
$LOAD = $_GET['L'];
$COOKIES = $_GET['C'];
$BTN_RAD = $_GET['R'];
$BTN_SHADOW = $_GET['S'];
$BTN_BORDER = $_GET['B'];
                  
	$sql = "INSERT INTO config (kind, code,text1,text2) VALUES 
        ('CIE', 'LOGO1', '" . trim($L1)    . "',''),
        ('CIE', 'LOGO2', '" . trim($L2)    . "',''),
        ('CIE', 'LOGO3', '" . trim($L3)    . "',''),
        ('CIE', 'LOGO4', '" . trim($L4)    . "',''),
        ('CIE', 'LOGO5', '" . trim($L5)    . "',''),
        ('CIE', 'BG1', '" . trim($B1)    . "',''),
        ('CIE', 'BG2', '" . trim($B2)    . "',''),
        ('CIE', 'BG3', '" . trim($B3)    . "',''),
        ('CIE', 'BG4', '" . trim($B4)    . "','" . trim($B4_PAD)    . "'),
        ('CIE', 'BG5', '" . trim($B5)    . "',''),
        ('CIE', 'FRAME', '" . trim($FRAME)    . "',''),
        ('CIE', 'FADE', '" . trim($FADE)    . "',''),
        ('CIE', 'LOAD', '" . trim($LOAD)    . "',''),
        ('CIE', 'BTN_RADIUS', '" . $BTN_RAD    . "',''),
        ('CIE', 'BTN_SHADOW', '" . $BTN_SHADOW    . "',''),
        ('CIE', 'BTN_BORDER', '" . $BTN_BORDER    . "','')
        ON DUPLICATE KEY UPDATE text1 = VALUES(text1),text2 = VALUES(text2);";

	if ($dw3_conn->query($sql) === TRUE) {
        $sql = "UPDATE config set text3 = '".$COOKIES."' WHERE kind='CIE' AND code='COOKIE_MSG';";
    	if ($dw3_conn->query($sql) === TRUE) {}
        $dw3_conn->close();
        header('Status: 200');
	    die("Les options d'affichage ont étés mises &#224; jour.");
	} else {
	  die($dw3_conn->error);
	}
?>