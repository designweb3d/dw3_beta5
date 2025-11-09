<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$USERNAME   = trim(mysqli_real_escape_string($dw3_conn,$_GET['USERNAME']));
$PW   = trim(mysqli_real_escape_string($dw3_conn,$_GET['PW']));
$EML1   = trim(mysqli_real_escape_string($dw3_conn,$_GET['EML1']));
$EML2   = trim(mysqli_real_escape_string($dw3_conn,$_GET['EML2']));
//$EML3   = trim(mysqli_real_escape_string($dw3_conn,$_GET['EML3']));
$TEL1  = trim(mysqli_real_escape_string($dw3_conn,$_GET['TEL1']));
$LANG  = $_GET['LANG'];
$APLC    = $_GET['APLC'];

	if ($EML1 == "") {
		$dw3_conn->close();
		die ('Veuillez entrer un courriel');
	}	
	if ($USERNAME == "") {
		$dw3_conn->close();
		die ('Veuillez entrer un utilisateur');
	} 
	if ($PW == "") {
		$dw3_conn->close();
		die ('Veuillez entrer un mot de passe');
	} 
	if (strlen($PW) <= 7) {
		$dw3_conn->close();
		die ('Veuillez entrer un mot de passe de minimum 8 caractères');
	} 

	$DATA_COUNT = 0;
	$sql = "SELECT COUNT(*) as DATA_COUNT FROM user
	 WHERE id <> " . $USER . " 
	 AND UPPER(eml1) = '" . strtoupper($USERNAME) . "' 
	 OR id <> " . $USER . "
	 AND UPPER(name) = '" . strtoupper($USERNAME) . "'";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {		
		while($row = $result->fetch_assoc()) {
			$DATA_COUNT = $row["DATA_COUNT"];
		}
	}
	if ($DATA_COUNT <> 0) {
		$dw3_conn->close();
		die ("Ce nom d'utilisateur est déjà associé à un autre compte");
	} 	
	$DATA_COUNT = 0;
	$sql = "SELECT COUNT(*) as DATA_COUNT FROM user
	 WHERE id <> " . $USER . " 
	 AND UPPER(eml1) = '" . strtoupper($EML1) . "' 
	 OR id <> " . $USER . "
	 AND UPPER(name) = '" . strtoupper($EML1) . "'";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {		
		while($row = $result->fetch_assoc()) {
			$DATA_COUNT = $row["DATA_COUNT"];
		}
	}
	if ($DATA_COUNT <> 0) {
		$dw3_conn->close();
		die ('Cette adresse courriel est déjà utilisé pour un autre compte');
	} 
//verifications si un client utilise ce email	 
	$DATA_COUNT = 0;
	$sql = "SELECT COUNT(*) as DATA_COUNT FROM customer
	 WHERE 
	 UPPER(eml1) = '" . strtoupper($EML1) . "'";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {		
		while($row = $result->fetch_assoc()) {
			$DATA_COUNT = $row["DATA_COUNT"];
		}
	}
	if ($DATA_COUNT <> 0) {
		$dw3_conn->close();
		die ('Cette adresse courriel est utilisé pour un compte client');
	} 	

	$sql = "UPDATE user
     SET    
	 name  = '" . $USERNAME   . "',
	 pw  = '" . $PW   . "',
	 eml1 = '" . $EML1  . "',
	 eml2 = '" . $EML2  . "',
	 tel1 = '" . $TEL1  . "',
	 lang = '" . $LANG  . "',
	 app_id = " . $APLC  . " 
	 WHERE id = " . $USER . " LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  //echo $LBL_ERROR . $dw3_conn->error;
	  echo $sql;
	}
$dw3_conn->close();
?>