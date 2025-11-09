<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$NOM   = str_replace("'", "’", htmlspecialchars($_GET['NOM']));
$NOM_CONTACT   = str_replace("'", "’", htmlspecialchars($_GET['NOM_CONTACT']));
$EML1   = $_GET['EML1'];
$TEL1  = $_GET['TEL1'];
$CP  = $_GET['CP'];
$ADR1  = str_replace("'", "’", htmlspecialchars($_GET['ADR1']));
$ADR2  = str_replace("'", "’", htmlspecialchars($_GET['ADR2']));
$VILLE  = str_replace("'", "’", htmlspecialchars($_GET['VILLE']));
$PROV  = str_replace("'", "’", htmlspecialchars($_GET['PROV']));
$PAYS  = str_replace("'", "’", htmlspecialchars($_GET['PAYS']));


//Verif
	if (trim($NOM) != ""){
	$sql = "SELECT COUNT(*) as counter FROM supplier
			WHERE TRIM(LCASE(company_name)) = '" . trim(strtolower($NOM))  . "';";
			$result = mysqli_query($dw3_conn, $sql);
			$data = mysqli_fetch_assoc($result);
			if ($data['counter'] != "0"){
				//$dw3_conn->close();
				die ("Erreur: Nom de fournisseur déjà utilisé.");
			}
	} else {
        die ("Erreur: Veuillez entrer un nom de fournisseur.");
    }
//get next id for return $data['maxID']
/* 	$sql = "SELECT (max(id)+1) as maxID FROM supplier";
			$result = mysqli_query($dw3_conn, $sql);
			$data = mysqli_fetch_assoc($result); */

//insert
	$sql = "INSERT INTO supplier
    (company_name,contact_name,tel1,eml1,adr1,adr2,city,province,country,postal_code,date_created,date_modified)
    VALUES 
        ('" . $NOM  . "',
         '" . $NOM_CONTACT  . "',
         '" . $TEL1  . "',
         '" . $EML1 . "',
         '" . $ADR1  . "',
         '" . $ADR2  . "',
         '" . $VILLE  . "',
         '" . $PROV  . "',
         '" . $PAYS  . "',
         '" . $CP  . "',
         '" . $datetime  . "',
         '" . $datetime  . "')";
	if ($dw3_conn->query($sql) === TRUE) {
      $inserted_id = $dw3_conn->insert_id;
	  echo $inserted_id;
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
?>