<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$NAME   = str_replace("'","’",$_GET['NAME']);
$REV  = $_GET['REV'];
$YEAR  = $_GET['YEAR'];

//insert
	$sql = "INSERT INTO budget 
        (name_fr,revenu,amount,freq,date_start,date_end)
    VALUES 
        ('" . $NAME  . "',
         '" . $REV  . "',
         '0',
         'MONTHLY',
         '" . $YEAR . "/01/01" . "',
         '" . $YEAR . "/12/31" . "')";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo $dw3_conn->insert_id;
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
?>