<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$COMPANY  =  str_replace("'","’",$_GET['CIE']);
$PRENOM  =  dw3_crypt(str_replace("'","’",$_GET['PRENOM']));
$PRENOM2  =  dw3_crypt(str_replace("'","’",$_GET['PRENOM2']));
$NOM   =  dw3_crypt(str_replace("'","’",$_GET['NOM']));
$TYPE   = str_replace("'","’",$_GET['TYPE']);
$EML1   = dw3_crypt(strtolower(trim($_GET['EML1'])));
$WEB   = str_replace("'","’",$_GET['WEB']);
$TEL1  =  dw3_crypt($_GET['TEL1']);
$ADR1  =  dw3_crypt(str_replace("'","’",$_GET['ADR1']));
$ADR2  =  dw3_crypt(str_replace("'","’",$_GET['ADR2']));
$VILLE  = str_replace("'","’",$_GET['VILLE']);
$PROV  = str_replace("'","’",$_GET['PROV']);
$PAYS  ="Canada";
$CP  = str_replace("'","’",$_GET['CP']);
$LANG  = strtoupper($_GET['LANG']);
$LNG  = strtoupper($_GET['LNG']);
$LAT  = str_replace("'","’",$_GET['LAT']);
$PREFIX  = str_replace("'","’",$_GET['PREFIX']);
$SUFFIX  = str_replace("'","’",$_GET['SUFFIX']);


//Verif
$err_desc = "";
    //if (!preg_match("/^[a-zA-Z-' ]*$/",$NOM)) {
       // $err_desc = "Only letters and white space allowed for first and last name";
    //}
	if (trim($EML1) == ""){
        //$err_desc = "Adresse courriel requise pour créer un compte";
    } else {
        $sql = "SELECT COUNT(*) as counter FROM customer
                WHERE eml1 = '" . $EML1   . "';";
        $result = mysqli_query($dw3_conn, $sql);
        $data = mysqli_fetch_assoc($result);
        if ($data['counter'] > 0){
            $err_desc = "Erreur: Adresse courriel déjà utilisée.";
        }
        if (!filter_var($_GET['EML1'], FILTER_VALIDATE_EMAIL) && trim($_GET['EML1']) != "") {
            $err_desc = "Invalid email format";
        }
    }
    if ($err_desc!=""){
        $dw3_conn->close();
        header('Status: 400');
        die ($err_desc);
    }

//if retailer add to location table
if ($TYPE == "RETAILER"){
	$sql = "INSERT INTO location
    (name,type,allow_pickup,eml1,adr1,adr2,tel1,city,province,country,postal_code)
    VALUES 
        ('" . $COMPANY   . "',
         '7',
         '1',
         '" . $EML1   . "',
         '" . $ADR1  . "',
         '" . $ADR2  . "',
         '" . $TEL1  . "',
         '" . $VILLE . "',
         '" . $PROV  . "',
         'Canada',
         '" . $CP    . "')";
	if ($dw3_conn->query($sql) === TRUE) {
        $RET_LOC_ID = $dw3_conn->insert_id;
	} else {
	    echo $dw3_conn->error;
	}
} else{
    $RET_LOC_ID = 0;
}

//insert
	$sql = "INSERT INTO customer
    (activated,retailer_loc_id,location_id,first_name,middle_name,last_name,type,company,prefix,suffix,tel1,eml1,web,adr1,adr2,city,province,country,postal_code,lang,longitude,latitude,date_created,date_modified,crypted)
    VALUES 
        ('1',
         '".$RET_LOC_ID."',
         '".$CIE_ADR2."',
         '" . $PRENOM  . "',
         '" . $PRENOM2  . "',
         '" . $NOM  . "',
         '" . $TYPE  . "',
         '" . $COMPANY  . "',
         '" . $PREFIX  . "',
         '" . $SUFFIX  . "',
         '" . $TEL1  . "',
         '" . $EML1 . "',
         '" . $WEB . "',
         '" . $ADR1  . "',
         '" . $ADR2  . "',
         '" . $VILLE  . "',
         '" . $PROV  . "',
         '" . $PAYS  . "',
         '" . $CP  . "',
         '" . $LANG  . "',
         '" . $LNG  . "',
         '" . $LAT  . "',
         '" . $datetime  . "',
         '" . $datetime  . "',1)";
	if ($dw3_conn->query($sql) === TRUE) {
		//get next id to return $data['maxID']{"firstName":"John", "lastName":"Doe"}
		//$sql = "SELECT (max(clID)+1) as maxID FROM BDCLNT";
/* 		$sql = "SELECT LAST_INSERT_ID() as ID;";
		$result = mysqli_query($dw3_conn, $sql);
		$data = mysqli_fetch_assoc($result); */
		//echo $data['maxID'];
        $inserted_id = $dw3_conn->insert_id;
		echo '{"status":"ok", "data":"' . $inserted_id . '"} ';
        if(!file_exists($_SERVER['DOCUMENT_ROOT'] . "/fs/customer/" . $inserted_id)){
            mkdir($_SERVER['DOCUMENT_ROOT'] . "/fs/customer/" . $inserted_id);
        }

	} else {
		echo '{"status":"err", "data":"' . $dw3_conn->error . '"} ';
	}

    //ajout évènement
    $sql_task = "INSERT INTO event (event_type,name,description,date_start,customer_id,user_id) 
        VALUES('CUSTOMER','Client ajouté','Ajouté par: ".$USER_FULLNAME ."','". $datetime ."','".$inserted_id."','".$USER."')";
    $result_task = $dw3_conn->query($sql_task); 

$dw3_conn->close();
?>
