<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$usTO   = mysqli_real_escape_string($dw3_conn,$_GET['usTO']);
$MSG   = mysqli_real_escape_string($dw3_conn,$_GET['MSG']);

//insert
	$sql = "INSERT INTO message
    (user_from,user_to,message,date_time)
    VALUES 
        ('" . $USER   . "',
         '" . $usTO  . "',
         '" . $MSG  . "',
         '" . $datetime  . "')";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
?>