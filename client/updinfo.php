<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
if($CIE_STRIPE_KEY!=""){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/api/stripe/init.php');
    if ($CIE_STRIPE_MODE == "" || $CIE_STRIPE_MODE == "DEV"){
        $stripe = new \Stripe\StripeClient($CIE_STRIPE_TKEY);
    } else if ($CIE_STRIPE_MODE == "PROD"){
        $stripe = new \Stripe\StripeClient($CIE_STRIPE_KEY);
    }
}
$ID = $_GET['ID'];
$LANG = $_GET['LANG'];
$NEW_USER_NAME = $_GET['USER_NAME'];
$FACTOR = $_GET['F'];
$WEB = str_replace("'","’",$_GET['WEB']);
$NOM = dw3_crypt(str_replace("'","’",$_GET['NOM']));
$CIE = str_replace("'","’",$_GET['CIE']);
$TEL1 = dw3_crypt(str_replace("'","’",$_GET['TEL1']));
$ADR1 = dw3_crypt(str_replace("'","’",$_GET['ADR1'])); 
$ADR2 = dw3_crypt(str_replace("'","’",$_GET['ADR2']));  
$VILLE = str_replace("'","’",$_GET['VILLE']); 
$PROV = str_replace("'","’",$_GET['PROV']);
$CP = str_replace("'","’",$_GET['CP']);
$ADR1s = dw3_crypt(str_replace("'","’",$_GET['ADR1_SH'])); 
$ADR2s = dw3_crypt(str_replace("'","’",$_GET['ADR2_SH']));  
$VILLEs = str_replace("'","’",$_GET['VILLE_SH']);
$PROVs = str_replace("'","’",$_GET['PROV_SH']);   
$CPs = str_replace("'","’",$_GET['CP_SH']);

if (strtolower($NEW_USER_NAME) == "admin" && strtolower($NEW_USER_NAME) == "administrateur" && strtolower($NEW_USER_NAME) == "administrator" && strtolower($NEW_USER_NAME) == "moderator" && strtolower($NEW_USER_NAME) == "moderateur" && strtolower($NEW_USER_NAME) == "dev"  && strtolower($NEW_USER_NAME) == "info") {
    $dw3_conn->close();
    die("Nom d'utilisateur déjà existant.");
}

$sql = "SELECT * FROM user WHERE LCASE(name) = '".strtolower($NEW_USER_NAME )."' ;";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {	
    $dw3_conn->close();
    die("Nom d'utilisateur déjà existant.");
}
$sql = "SELECT * FROM customer WHERE LCASE(user_name) = '".strtolower($NEW_USER_NAME )."' AND id<>".$ID." ;";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {	
    $dw3_conn->close();
    die("Nom d'utilisateur déjà existant.");
}

	$sql = "UPDATE customer SET
        lang = '" . $LANG . "',
        two_factor_req = '" . $FACTOR . "',
        user_name = '" . $NEW_USER_NAME . "',
        last_name = '" . $NOM . "',
        company = '" . $CIE . "',
        web = '" . $WEB . "',
        tel1 ='" . $TEL1 . "',
        adr1 ='" . $ADR1 . "',
        adr2 ='" . $ADR2 . "',
        city ='" . $VILLE . "',
        province ='" . $PROV . "',
        postal_code = '" . $CP . "',
        country = 'Canada',
        adr1_sh ='" . $ADR1s . "',
        adr2_sh ='" . $ADR2s . "',
        city_sh ='" . $VILLEs . "',
        province_sh ='" . $PROVs . "',
        country_sh = 'Canada',
        postal_code_sh = '" . $CPs . "' 
	 WHERE id = '" . $ID . "'
	 LIMIT 1";
	if ($dw3_conn->query($sql) == TRUE) {
        //aller chercher stripe_id pour updater Stripe
        $sql = "SELECT * FROM customer WHERE id = '" . $ID . "' LIMIT 1";
        $result = mysqli_query($dw3_conn, $sql);
        $data = mysqli_fetch_assoc($result);
        $stripe_id = $data['stripe_id'];
        $EML1 = dw3_decrypt($data['eml1']);
        if($stripe_id != "" && $CIE_STRIPE_KEY!=""){
            $cleanName = substr(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", str_replace("'","’", $_GET['NOM']))),0,20);
            try {
            $stripe_result = $stripe->customers->update($stripe_id,[
                'description' => 'Customer #' . $ID,
                'address' => [
                    'city' => $VILLE,
                    'country' => 'Canada',
                    'line1' => substr(str_replace("'","’", $_GET['ADR1']),0,20),
                    'line2' => substr(str_replace("'","’", $_GET['ADR2']),0,20),
                    'postal_code' => $CP,
                    'state' => $PROV
                ],    
                'name' => $cleanName,    
                'balance' => 0,   
                'phone' => substr(str_replace("'","’", $_GET['TEL1']),0,20),    
                'email' => $EML1]);
                } catch (Error $e) {
                    echo "Error Stripe: " . $e->getMessage();
                }
        }
        //if retailer update location table
            if ($data['type'] == "RETAILER"){
                    $sql = "UPDATE location SET
                        name  = '" . $CIE . "',
                        web  = '" . $WEB . "',
                        adr1 = '" . $_GET['ADR1'] . "',
                        adr2 = '" . $_GET['ADR2'] . "',
                        tel1 = '" . $_GET['TEL1'] . "',
                        city= '" . $VILLE . "',
                        province = '" . $PROV . "',
                        country = 'Canada',
                        postal_code   = '" . $CP . "'
                    WHERE id = '".$data['retailer_loc_id']."' LIMIT 1";
                    $result = mysqli_query($dw3_conn, $sql);
            }
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>