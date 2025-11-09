<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID   = $_GET['ID'];
$SMS_RDV   = $_GET['SMS_RDV'];
$TZ   = $_GET['TZ'];
$SALARY   = $_GET['SALARY'];
$PREFIX   = str_replace("'","’",$_GET['PREFIX']);
$PRENOM   = str_replace("'","’",$_GET['PRENOM']);
$PRENOM2   = str_replace("'","’",$_GET['PRENOM2']);
$NOM   = str_replace("'","’",$_GET['NOM']);
$SUFFIX   = str_replace("'","’",$_GET['SUFFIX']);
$EML1   = str_replace("'","’",$_GET['EML1']);
$EML2   = str_replace("'","’",$_GET['EML2']);
$EML3   = str_replace("'","’",$_GET['EML3']);
$ADR1  = str_replace("'","’",$_GET['ADR1']);
$ADR2  = str_replace("'","’",$_GET['ADR2']);
$TEL1  = str_replace("'","’",$_GET['TEL1']);
$TEL2  = str_replace("'","’",$_GET['TEL2']);
$VILLE = str_replace("'","’",$_GET['VILLE']);
$PROV  = str_replace("'","’",$_GET['PROV']);
$PAYS  = str_replace("'","’",$_GET['PAYS']);
$MSG_RDV  = str_replace("'","’",$_GET['MRDV']);
//$USID  = $_GET['USID'];
$UNAME  = $_GET['UN'];
$LANG  = $_GET['LANG'];
$STAT  = $_GET['STAT'];
$CP    = $_GET['CP'];
$APLC    = $_GET['APLC'];
$AUTH   = $_GET['AUTH'];
$LOC    = $_GET['LOC'];
$POS    = $_GET['POS'];
$INACTIVE    = $_GET['INACTIVE'];

//verif si autorite pour modifier ce user
$sql = "SELECT * FROM user WHERE id = " . $ID;
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$can_user_mod = true;
if ($USER_AUTH != "USR" && $USER_AUTH != "ADM" && $USER_AUTH != "GES"){$can_user_mod = false;}
if ($USER_AUTH == "ADM" && $data["auth"] == "GES"){$can_user_mod = false;}
if (($USER_AUTH == "USR" && $data["auth"] == "GES") || ($USER_AUTH == "USR" && $data["auth"] == "ADM")){$can_user_mod = false;}

if ($can_user_mod == false){
    $dw3_conn->close();
    die("Erreur: Vous ne disposez pas de l'autorité necessaire pour faire cette modification.");
}

//verif si username pas utilisé
$DATA_COUNT = 0;
$sql = "SELECT COUNT(*) as DATA_COUNT FROM user
 WHERE id <> " . $ID . " 
 AND UPPER(name) = '" . strtoupper($UNAME) . "'";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {		
    while($row = $result->fetch_assoc()) {
        $DATA_COUNT = $row["DATA_COUNT"];
    }
}
if ($DATA_COUNT <> 0) {
    $dw3_conn->close();
    die ("Le nom d'utilisateur `" . $UNAME . "` est déjà utilisé.");
} 
//verifications si un autre user utilise ce email
$DATA_COUNT = 0;
$sql = "SELECT COUNT(*) as DATA_COUNT FROM user
 WHERE id <> " . $ID . " 
 AND UPPER(eml1) = '" . strtoupper($EML1) . "' 
 AND UPPER(eml1) <> '' 
OR id <> " . $ID . "
 AND UPPER(name) = '" . strtoupper($EML1) . "'  
OR id <> " . $ID . "
 AND UPPER(eml2) = '" . strtoupper($EML1) . "' 
 AND UPPER(eml2) <> '' 
OR id <> " . $ID . "
 AND UPPER(eml3) = '" . strtoupper($EML1) . "' 
 AND UPPER(eml3) <> '' 
OR id <> " . $ID . "
 AND UPPER(eml1) = '" . strtoupper($EML2) . "' 
 AND UPPER(eml1) <> '' 
 OR id <> " . $ID . "
 AND UPPER(eml2) = '" . strtoupper($EML2) . "' 
 AND UPPER(eml2) <> '' 
OR id <> " . $ID . "
 AND UPPER(eml3) = '" . strtoupper($EML2) . "' 
 AND UPPER(eml3) <> '' 
OR id <> " . $ID . "
 AND UPPER(eml1) = '" . strtoupper($EML3) . "' 
 AND UPPER(eml1) <> '' 
OR id <> " . $ID . "
 AND UPPER(eml2) = '" . strtoupper($EML3) . "' 
 AND UPPER(eml2) <> '' 
OR id <> " . $ID . "
 AND UPPER(eml3) = '" . strtoupper($EML3) . "'
 AND UPPER(eml3) <> '' ";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {		
    while($row = $result->fetch_assoc()) {
        $DATA_COUNT = $row["DATA_COUNT"];
    }
}
if ($DATA_COUNT <> 0) {
    $dw3_conn->close();
    die ("Une des adresses courriel est déjà utilisé pour un autre compte");
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
    die ("L'adresse courriel " . $EML1 . " est déjà utilisé pour un compte client");
} 	

	$sql = "UPDATE user
     SET    
	 sms_rdv  = '" . $SMS_RDV   . "',
	 salary  = '" . $SALARY   . "',
	 name  = '" . $UNAME   . "',
	 prefix  = '" . $PREFIX   . "',
	 first_name  = '" . $PRENOM   . "',
	 middle_name  = '" . $PRENOM2   . "',
	 last_name  = '" . $NOM   . "',
	 suffix  = '" . $SUFFIX   . "',
	 eml1 = '" . $EML1  . "',
	 eml2 = '" . $EML2  . "',
	 eml3 = '" . $EML3  . "',
	 adr1 = '" . $ADR1  . "',
	 adr2 = '" . $ADR2  . "',
	 tel1 = '" . $TEL1  . "',
	 tel2 = '" . $TEL2  . "',
	 city= '" . $VILLE . "',
	 province = '" . $PROV  . "',
	 country = '" . $PAYS  . "',
	 postal_code   = '" . $CP    . "',
	 timezone_offset = '" . $TZ  . "',
	 auth = '" . $AUTH  . "',
	 lang = '" . $LANG  . "',
	 inactive_minutes = '" . $INACTIVE  . "',
	 app_id = '" . $APLC  . "',
	 stat = '" . $STAT  . "',
	 msg_rdv = '" . $MSG_RDV  . "',
	 position_id   = '" . $POS    . "',
	 location_id   = '" . $LOC    . "'
	 WHERE id = " . $ID . " LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo "Error: " . $dw3_conn->error;
	}
$dw3_conn->close();
?>