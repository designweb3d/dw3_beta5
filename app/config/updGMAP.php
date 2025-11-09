<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$GANALYTICS    = mysqli_real_escape_string($dw3_conn,$_GET['GANALYTICS']);
$GEMINI_KEY    = mysqli_real_escape_string($dw3_conn,$_GET['GEMINI_KEY']);
$GMAP_KEY    = mysqli_real_escape_string($dw3_conn,$_GET['GMAP_KEY']);
$GCAP_KEY    = mysqli_real_escape_string($dw3_conn,$_GET['GCAP_KEY']);
$GMAP_MAP    = mysqli_real_escape_string($dw3_conn,$_GET['GMAP_MAP']);
$GMAP_ID    = mysqli_real_escape_string($dw3_conn,$_GET['GMAP_ID']);
$GMAP_SECRET    = mysqli_real_escape_string($dw3_conn,$_GET['GMAP_SECRET']);
$GMAP_IMG    = mysqli_real_escape_string($dw3_conn,$_GET['GMAP_IMG']);
                  
	$sql = "INSERT INTO config
    (kind, code,text1)
    VALUES 
        ('CIE', 'GANALYTICS', '" . $GANALYTICS    . "'),
        ('CIE', 'G_ID', '" . $GMAP_ID    . "'),
        ('CIE', 'G_SECRET', '" . $GMAP_SECRET    . "'),
        ('CIE', 'G_IMG', '" . $GMAP_IMG   . "'),
        ('CIE', 'GEMINI_KEY', '" . $GEMINI_KEY    . "'),
        ('CIE', 'GMAP_KEY', '" . $GMAP_KEY    . "'),
        ('CIE', 'GMAP_MAP', '" . $GMAP_MAP    . "')
        ON DUPLICATE KEY UPDATE text1 = VALUES(text1);";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "Les options pour les APIs Google ont étés mises &#224; jour";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>