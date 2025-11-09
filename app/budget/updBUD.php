<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID   = $_GET['ID'];
$NAME   = str_replace("'","’",$_GET['NAME']);
$REV  = $_GET['REV'];
$START  = $_GET['START'];
$END  = $_GET['END'];
$FREQ  = $_GET['FREQ'];
$AMOUNT  = $_GET['AMOUNT'];

//update budget
		$sql = "UPDATE budget SET    
		name_fr = '" . $NAME   . "',
		revenu = '" . $REV   . "',
		date_start = '" . $START    . "',
		date_end = '" . $END    . "',
		freq = '" . $FREQ . "',
		amount = '" . $AMOUNT . "'
        WHERE id = '" . $ID . "' LIMIT 1";
     if ($dw3_conn->query($sql) === TRUE) {
	  //echo $sql;
	} else {
	  echo $dw3_conn->error;
	}

$dw3_conn->close();
?>