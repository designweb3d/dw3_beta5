<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$FRN_ID    = $_GET['FRN_ID'];
$TRANSIT   = mysqli_real_escape_string($dw3_conn,$_GET['TRANSIT']);
$FOLIO    = mysqli_real_escape_string($dw3_conn,$_GET['FOLIO']);
$COMPTE    = mysqli_real_escape_string($dw3_conn,$_GET['COMPTE']);
$SOLDE    = $_GET['SOLDE'];
            
	$sql = "INSERT INTO config
    (kind, code,text1)
    VALUES 
        ('BANK', 'FRN_ID', '" . $FRN_ID  . "'),
        ('BANK', 'TRANSIT', '" . $TRANSIT  . "'),
        ('BANK', 'FOLIO', '" . $FOLIO    . "'),
        ('BANK', 'COMPTE', '" . $COMPTE    . "'),
        ('BANK', 'SOLDE', '" . $SOLDE    . "')
        ON DUPLICATE KEY UPDATE text1 = VALUES(text1);";
	if ($dw3_conn->query($sql) === TRUE) {
        header('Status: 200');
	    echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>