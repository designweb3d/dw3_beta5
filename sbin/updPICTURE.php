<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';

$PIC_TYPE  = trim(mysqli_real_escape_string($dw3_conn,$_GET['T']??""));
$PIC_URL  = trim(mysqli_real_escape_string($dw3_conn,$_GET['U']??""));


	if ($PIC_TYPE == "") {
		$dw3_conn->close();
		die ('Erreur type invalide.');
	}	

	$sql = "UPDATE user
     SET    
	 picture_type = '" . $PIC_TYPE  . "',
	 picture_url = '" . $PIC_URL  . "' 
	 WHERE id = '" . $USER . "' LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "Mise à jour terminée.";
	} else {
	  //echo $LBL_ERROR . $dw3_conn->error;
	  echo $sql;
	}
$dw3_conn->close();
die();
?>