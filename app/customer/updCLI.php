<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
//die($CIE_STRIPE_MODE . " p:".$CIE_STRIPE_KEY." t:".$CIE_STRIPE_TKEY);
if($CIE_STRIPE_KEY!=""){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/api/stripe/init.php');
    if ($CIE_STRIPE_MODE == "" || $CIE_STRIPE_MODE == "DEV"){
        $stripe = new \Stripe\StripeClient($CIE_STRIPE_TKEY);
    } else if ($CIE_STRIPE_MODE == "PROD"){
        $stripe = new \Stripe\StripeClient($CIE_STRIPE_KEY);
    }
}
$ID     = $_GET['ID'];
$LOC    = $_GET['LOC'];
$STAT   = $_GET['STAT'];
$LANG   = $_GET['LANG'];
$TYPE   = $_GET['TYPE']??'PARTICULAR';
$SEXE   = $_GET['SEXE'];
$PREFIX = str_replace("'","’", $_GET['PREFIX']);
$PRENOM =  str_replace("'","’", $_GET['PRENOM']);
$PRENOM2 =  str_replace("'","’", $_GET['PRENOM2']);
$NOM    =  str_replace("'","’", $_GET['NOM']);
$CIE    =  str_replace("'","’", $_GET['CIE']);
$SUFFIX    = str_replace("'","’", $_GET['SUFFIX']);
$TEL1   =  str_replace("'","’",$_GET['TEL1']);
$TEL2   =  str_replace("'","’",$_GET['TEL2']);
$ADR1   =  str_replace("'","’", $_GET['ADR1']);
$ADR2   =  str_replace("'","’", $_GET['ADR2']);
$VILLE  = str_replace("'","’", $_GET['VILLE']);
$PROV   = str_replace("'","’", $_GET['PROV']);
$PAYS   = "Canada";
$CP     = str_replace("'","’",$_GET['CP']);
$ADR1s   =  str_replace("'","’", $_GET['ADR1s']);
$ADR2s   =  str_replace("'","’", $_GET['ADR2s']);
$VILLEs  = str_replace("'","’", $_GET['VILLEs']);
$PROVs   = str_replace("'","’", $_GET['PROVs']);
$PAYSs   = str_replace("'","’", $_GET['PAYSs']);
$CPs     = str_replace("'","’",$_GET['CPs']);
$EML1   = strtolower(trim($_GET['EML1']));
$EML2   = strtolower(trim($_GET['EML2']));
$WEB   = str_replace("'","’",$_GET['WEB']);
$NOTE   = str_replace("'","’", $_GET['NOTE']);
$NEWS 		= $_GET['NEWS'];if ($NEWS=="false"){$NEWS=0;}else{$NEWS=1;}
$SMS 		= $_GET['SMS'];if ($SMS=="false"){$SMS=0;}else{$SMS=1;}
$TWO_FAC 		= $_GET['TWO_FAC'];if ($TWO_FAC=="false"){$TWO_FAC=0;}else{$TWO_FAC=1;}
$LNG  = $_GET['LNG'];
$LAT  = $_GET['LAT'];
$RET_LOC_ID = "0";
//Verif
$err_desc = "";
    //if (!preg_match("/^[a-zA-Z-' ]*$/",$NOM)) {
       // $err_desc = "Only letters and white space allowed for first and last name";
    //}
	if (trim($EML1) == ""){
        //$err_desc = "Adresse courriel requise pour créer un compte";
    }else{
        $sql = "SELECT COUNT(*) as counter FROM customer
                WHERE eml1 = '" . dw3_crypt($EML1)   . "' AND id <> '" . $ID . "';";
        $result = mysqli_query($dw3_conn, $sql);
        //die($sql);
        $data = mysqli_fetch_assoc($result);
        if ($data['counter'] > 0){
            $err_desc = "Erreur: Adresse courriel déjà utilisée.";
        }
    }
    if (!filter_var($EML1, FILTER_VALIDATE_EMAIL) && trim($EML1) != "") {
        $err_desc = "Adresse courriel invalide";
      }

    if ($err_desc!=""){
        $dw3_conn->close();
        //header('Status: 400');
        die ($err_desc);
    }

//if retailer add to location table else remove it
$sql = "SELECT A.*, IFNULL(B.id,-1) AS is_set_ret FROM customer A
LEFT JOIN (SELECT id FROM location) B ON A.retailer_loc_id = B.id
WHERE A.id = '" . $ID . "';";
$result = mysqli_query($dw3_conn, $sql);
//die($sql);
$data = mysqli_fetch_assoc($result);
    if ($TYPE == "RETAILER"){
        if ($data['is_set_ret'] == -1){
            $sql = "INSERT INTO location
            (name,type,allow_pickup,eml1,adr1,adr2,tel1,city,province,country,postal_code)
            VALUES 
                ('" . $CIE   . "',
                '7','1',
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
        } else if ($data['is_set_ret'] > 0){
            $sql = "UPDATE location SET
            	name  = '" . $CIE   . "',
                eml1 = '" . $EML1  . "',
                adr1 = '" . $ADR1  . "',
                adr2 = '" . $ADR2  . "',
                tel1 = '" . $TEL1  . "',
                city= '" . $VILLE . "',
                province = '" . $PROV  . "',
                country = 'Canada',
                longitude = '" . $LNG  . "',
                latitude = '" . $LAT  . "',
                postal_code   = '" . $CP    . "'
            WHERE id = '".$data['is_set_ret']."' LIMIT 1";
            $result = mysqli_query($dw3_conn, $sql);
            $RET_LOC_ID = $data['is_set_ret'];
        }
    }  else if ($data['is_set_ret'] > 0){
        $sql = "DELETE FROM location WHERE id = '".$data['is_set_ret']."' LIMIT 1";
        $result = mysqli_query($dw3_conn, $sql);
        $RET_LOC_ID = "0";
    }


//update
	$sql = "UPDATE customer
     SET    
	 date_modified   = '" . $datetime   . "',
	 type   = '" . $TYPE   . "',
	 retailer_loc_id   = '" . $RET_LOC_ID   . "',
	 location_id  = '" . $LOC   . "',
	 stat   = '" . $STAT   . "',
	 lang   = '" . $LANG   . "',
	 type   = '" . $TYPE   . "',
	 gender   = '" . $SEXE   . "',
	 prefix = '" . $PREFIX . "',
	 first_name = '" . dw3_crypt($PRENOM) . "',
	 middle_name = '" . dw3_crypt($PRENOM2) . "',
	 last_name    = '" . dw3_crypt($NOM)    . "',
	 company    = '" . $CIE    . "',
	 suffix    = '" . $SUFFIX    . "',
	 tel1   = '" . dw3_crypt($TEL1)   . "',
	 tel2   = '" . dw3_crypt($TEL2)   . "',
	 adr1   = '" . dw3_crypt($ADR1)   . "',
	 adr2   = '" . dw3_crypt($ADR2)   . "',
	 city  = '" . $VILLE  . "',
	 province   = '" . $PROV   . "',
	 country   = '" . $PAYS   . "',
	 postal_code     = '" . $CP     . "',
	 adr1_sh   = '" . dw3_crypt($ADR1s)   . "',
	 adr2_sh   = '" . dw3_crypt($ADR2s)   . "',
	 city_sh  = '" . $VILLEs  . "',
	 province_sh   = '" . $PROVs   . "',
	 country_sh   = '" . $PAYSs   . "',
	 postal_code_sh     = '" . $CPs   . "',
	 eml1   = '" . dw3_crypt($EML1)   . "',
	 eml2   = '" . dw3_crypt($EML2)   . "',
	 web   = '" . $WEB   . "',
	 note   = '" . $NOTE   . "',
     longitude    = '" . $LNG    . "',
     latitude    = '" . $LAT    . "',
    news_stat = '" . $NEWS  . "',
    sms_stat = '" . $SMS  . "',
    two_factor_req = '" . $TWO_FAC  . "',
     date_modified = '".$datetime."'

	 WHERE id = '" . $ID . "' 
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
        //aller chercher stripe_id pour updater Stripe
        $sql = "SELECT * FROM customer WHERE id = '" . $ID . "' LIMIT 1";;
        $result = mysqli_query($dw3_conn, $sql);
        $data = mysqli_fetch_assoc($result);
        $stripe_id = $data['stripe_id'];
        if($stripe_id != "" && ($CIE_STRIPE_KEY!="" || $CIE_STRIPE_TKEY!="")){
            if ($TYPE=="" || $TYPE=="PARTICULAR"){
                $cleanName = substr(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $PRENOM . ' ' . $NOM)),0,20);
            }else if ($CIE != "" && $TYPE=="COMPANY"){
                $cleanName = substr(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $CIE)),0,20);
            } else {
                $cleanName = substr(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $PRENOM . ' ' . $NOM)),0,20);
            }
            try {
            $stripe_result = $stripe->customers->update($stripe_id,[
                'description' => 'Customer #' . $ID  . ' ' . $EML1,
                'address' => [
                    'city' => $VILLE,
                    'country' => $PAYS,
                    'line1' => substr($ADR1,0,20),
                    'line2' => substr($ADR2,0,20),
                    'postal_code' => $CP,
                    'state' => $PROV
                ],    
                'name' => $cleanName,    
                'balance' => 0,   
                'phone' => substr(str_replace("-", "",str_replace(" ", "",$TEL1)),0,20),    
                'email' => $EML1]);
                } catch  (Exception $e) {
                    echo "Error Stripe: " . $e->getMessage();
                }
        }
        echo "";
	} else {
	    echo $dw3_conn->error;
	}
$dw3_conn->close();
?>