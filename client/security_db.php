<?php 
header("X-Robots-Tag: noindex, nofollow", true);
$REDIR = "<html><head><title>Redirected</title><meta http-equiv=\"refresh\" content=\"0;URL='https://" . $_SERVER["SERVER_NAME"] . "'\"></head></html>";  
$KEY = $_GET['KEY']??null;
$CURRENT_FCT = $_GET["FCT"]??'';
$HNDL = $_GET['HNDL']??'';
$STRIPE_RESULT = $_GET['STRIPE_RESULT']??null;
$PAYPAL_RESULT = $_GET['PAYPAL_RESULT']??null;
$SQUARE_RESULT = $_GET['SQUARE_RESULT']??null;
if ($KEY == "" || $KEY == null){
    foreach ($_COOKIE as $ckey=>$val){
        if (substr($ckey, 0, 3) == "KEY" && $val != ""){
            $KEY=$val;
            break;
        }}
}

$RIP = $_SERVER['REMOTE_ADDR'];
date_default_timezone_set('America/New_York');
$today = date("Y-m-d");
$time = date("H:i:s");
$datetime = date("Y-m-d H:i:s");  
$dw3_ini = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/sbin/config.ini");
$dw3_conn = new mysqli($dw3_ini["mysqli_servername"],$dw3_ini["mysqli_username"], $dw3_ini["mysqli_password"], $dw3_ini["mysqli_dbname"]);
$dw3_conn->set_charset("utf8");
if ($dw3_conn->connect_error) {
    $dw3_conn->close();
    die($REDIR);
}

//langue
$USER_LANG  = "FR";
if(isset($_COOKIE["LANG"])) { 
    if ($_COOKIE["LANG"] != "") {
        $USER_LANG = $_COOKIE["LANG"];
    }
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/env_var.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/dw3_func.php';
if ($KEY == "" || $KEY == null){
    include $_SERVER['DOCUMENT_ROOT'] . '/client/db_login.php';
    //$dw3_conn->close();
    die ("");
}   

$sql = "SELECT * FROM location ORDER BY id ASC LIMIT 1";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $CIE_LNG = $row["longitude"];			
        $CIE_LAT = $row["latitude"];			
    }
}

if($CIE_STRIPE_KEY!=""){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/api/stripe/init.php');
    if ($CIE_STRIPE_MODE == "" || $CIE_STRIPE_MODE == "DEV"){
        $stripe = new \Stripe\StripeClient($CIE_STRIPE_TKEY);
    } else if ($CIE_STRIPE_MODE == "PROD"){
        $stripe = new \Stripe\StripeClient($CIE_STRIPE_KEY);
    }
}

//Validation du client avec KEY
//verifier si cle valide et chercher clID
	$sql = "SELECT * FROM customer WHERE key_128 = '" . $KEY . "' LIMIT 1";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows == 0) {
        include $_SERVER['DOCUMENT_ROOT'] . '/client/db_login.php';
        exit();
	} 
	while($row = $result->fetch_assoc()) {
        if ($row["two_factor_req"] == "1" && $row["two_factor_valid"] == "0" && $_SERVER["SCRIPT_FILENAME"] != $_SERVER['DOCUMENT_ROOT'] . "/client/two-factor.php" && $_SERVER["SCRIPT_FILENAME"] != $_SERVER['DOCUMENT_ROOT'] . "/client/send2Factor.php" && $_SERVER["SCRIPT_FILENAME"] != $_SERVER['DOCUMENT_ROOT'] . "/client/validate2Factor.php"){
            include $_SERVER['DOCUMENT_ROOT'] . '/client/db_login.php';
            $dw3_conn->close();
            die ("");
        }
		$USER = $row["id"];
		$USER_LOC = $row["location_id"];
		$USER_USER_NAME = $row["user_name"];
		$USER_TYPE = $row["type"];
		$USER_COMPANY = $row["company"];
		$USER_WEB = $row["web"];
		$USER_PW = dw3_decrypt($row["pw"]);
		$USER_2FACTOR = $row["two_factor_req"];
		$USER_CREATED = $row["date_created"];
		$USER_LASTLOGIN = $row["last_login"];
		$USER_ACTIVATED = $row["activated"];
		$USER_FIRST_NAME = dw3_decrypt($row["first_name"]);
		$USER_MIDDLE_NAME = dw3_decrypt($row["middle_name"]);
		$USER_LAST_NAME = dw3_decrypt($row["last_name"]);
		$USER_PREFIX = $row["prefix"];
		$USER_SUFFIX = $row["suffix"];
		$USER_EML1 = dw3_decrypt($row["eml1"]);
		$USER_TEL1 = dw3_decrypt($row["tel1"]);
		$USER_ADR1 = dw3_decrypt($row["adr1"]);
		$USER_ADR2 = dw3_decrypt($row["adr2"]);
		$USER_VILLE = $row["city"];
		$USER_PROV = $row["province"];
		$USER_PAYS = $row["country"];
		$USER_CP = $row["postal_code"];
		$USER_ADR1_SH = dw3_decrypt($row["adr1_sh"]);
		$USER_ADR2_SH = dw3_decrypt($row["adr2_sh"]);
		$USER_VILLE_SH = $row["city_sh"];
		$USER_PROV_SH = $row["province_sh"];
		$USER_PAYS_SH = $row["country_sh"];
		$USER_CP_SH = $row["postal_code_sh"];
		$USER_LANG = strtoupper($row["lang"]);
		$USER_SEXE = $row["gender"];
		$USER_FULLNAME=trim($USER_PREFIX." ".$USER_FIRST_NAME." ".$USER_MIDDLE_NAME." ".$USER_LAST_NAME." ".$USER_SUFFIX);
		$USER_NAME=trim($USER_FIRST_NAME." ".$USER_MIDDLE_NAME)." ".$USER_LAST_NAME;
		$USER_FULLADR=$USER_ADR1." ".$USER_ADR2.", ".$USER_VILLE." ".$USER_PROV.", ".$USER_PAYS." ".$USER_CP;
        $cleanName = substr($USER_LAST_NAME,0,20);
	}

    $USER_ACTIVATE = "0";
    if ($HNDL == "1" && $USER_ACTIVATED == "0" || $HNDL == "2" && $USER_ACTIVATED == "0"){
        $USER_ACTIVATE = "1";
        if ($CIE_STRIPE_KEY != ""){
            $stripe_result = $stripe->customers->create([
                'description' => 'Customer #' . $USER  . ' ' . $USER_EML1,
                'address' => [
                    'city' => $USER_VILLE,
                    'country' => $USER_PAYS,
                    'line1' => $USER_ADR1,
                    'line2' => $USER_ADR2,
                    'postal_code' => $USER_CP,
                    'state' => $USER_PROV
                ],    
                'name' => $cleanName,    
                'balance' => 0,   
                'phone' => $USER_TEL1,    
                'email' => $USER_EML1
            ]);
            //echo $result;
            $new_stripe_id = $stripe_result->id;
        }else{
            $new_stripe_id = "";
        }
        //$jresult = json_decode($result, true);
        //$new_stripe_id = $jresult['id'];
        $sql = "UPDATE customer SET    
        date_modified   = '" . $datetime   . "',
        stripe_id   = '" .  $new_stripe_id . "',
        activated = 1
        WHERE id = '" . $USER . "' 
        LIMIT 1";
        if ($dw3_conn->query($sql) === TRUE) {
            //echo $new_stripe_id;
        } else {
            //echo $dw3_conn->error;
        }
    }
    //clear cart after stripe checkout
    if ($STRIPE_RESULT == "SUCCESS" || $PAYPAL_RESULT == "SUCCESS" || $SQUARE_RESULT == "SUCCESS"){
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                if (substr($name,0,10) == 'CART_COUNT' || substr($name,0,3) == 'AD_'){
                    setcookie($name, '0', time()-1000);
                    setcookie($name, '0', time()-1000, '/');
                }
            }
        }
    }
    //user device id used for the cart
    if(isset($_COOKIE["DEVICE"])) { 
        if ($_COOKIE["DEVICE"] != "") {
            $USER_DEVICE = $_COOKIE["DEVICE"]; 
        } else {
            $USER_DEVICE = dw3_make_key(64); 
            $cookie_name = "DEVICE";
            $cookie_value = $USER_DEVICE;
            $cookie_domain = $_SERVER["SERVER_NAME"];
            setcookie($cookie_name, $cookie_value, [
                'expires' => time() + 34560000,
                'path' => '/',
                'domain' => $cookie_domain,
                'secure' => true,
                'httponly' => true,
                'samesite' => 'None',
            ]);
        }
    } else {
        $USER_DEVICE = dw3_make_key(64);
        $cookie_name = "DEVICE";
        $cookie_value = $USER_DEVICE;
        $cookie_domain = $_SERVER["SERVER_NAME"];
        setcookie($cookie_name, $cookie_value, [
            'expires' => time() + 34560000,
            'path' => '/',
            'domain' => $cookie_domain,
            'secure' => true,
            'httponly' => true,
            'samesite' => 'None',
        ]);
    }
    
//TEXTE & TRADUCTIONS GENERALES
/* $dw3_lbl = array("DW3"=>"Design Web 3D");
$sql = "SELECT *
FROM config WHERE kind = 'LBL'";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
            $code = strval($row["code"]);
            if ($USER_LANG == "FR"){ $val = strval($row["text1"]); }
            else if($USER_LANG == "EN") { $val = strval($row["text2"]); }
            else if($USER_LANG == "ES") { $val = strval($row["text3"]); }
            else if($USER_LANG == "IT") { $val = strval($row["text4"]); }
            else { $val = strval($row["text1"]); }
            $dw3_lbl += array($code=>$val);
        }
    } */

//'&#8216; à&#224; â&#226; ç&#231; î&#238; é&#233; è&#232; ê&#234;  https://lilith.fisica.ufmg.br/~wag/TRANSF/codehtml.html
//TEXTE & TRADUCTIONS GENERAL MAIN 
if (!isset($USER_LANG)){$USER_LANG = "FR";}
$dw3_lbl = array("DW3"=>"Design Web 3D");
$sql = "SELECT *
FROM config WHERE kind = 'LBL'";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
            $code = strval($row["code"]);
            if ($USER_LANG == "FR"){ $val = strval($row["text1"]); }
            else if($USER_LANG == "EN") { $val = strval($row["text2"]); }
            else if($USER_LANG == "ES") { $val = strval($row["text3"]); }
            else if($USER_LANG == "IT") { $val = strval($row["text4"]); }
            else { $val = strval($row["text2"]); }
            $dw3_lbl += array($code=>$val);
        }
    }

//data from current fct
/* if ($CURRENT_FCT != ''){
    $sql = "SELECT * FROM gls WHERE source_id = '" . $CURRENT_FCT . "' LIMIT 1;";
    $result = mysqli_query($dw3_conn, $sql);
    if ($result->num_rows > 0) {
        $CURRENT_FCT = '';
    } 
} */

?>
