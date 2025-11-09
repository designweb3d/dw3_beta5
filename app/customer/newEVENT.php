<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$clID  = htmlspecialchars($_GET['clID']);
$TYPE  = htmlspecialchars($_GET['TYPE']);

//insert
	$sql = "INSERT INTO event
    (event_type,name,customer_id,user_id)
    VALUES 
        ('" . $TYPE  . "','" . $TYPE  . "','" . $clID  . "','".$USER."')";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo $dw3_conn->insert_id;
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
?>