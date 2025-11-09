<?php
date_default_timezone_set('America/New_York');
setlocale(LC_ALL, 'fr_CA');
$dw3_ini = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/sbin/config.ini");
$dw3_conn = new mysqli($dw3_ini["mysqli_servername"],$dw3_ini["mysqli_username"], $dw3_ini["mysqli_password"], $dw3_ini["mysqli_dbname"]);
$today = date("Y-m-d");
$time = date("H:i:s");
$datetime = date("Y-m-d H:i:s");  
$dw3_conn->set_charset('utf8mb4');

	if ($dw3_conn->connect_error) {
		$dw3_conn->close();
		die("");
	}
    require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/dw3_func.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/env_var.php';
    
$PAGE_ID = $_GET['PID']??"";
$PAGE_P1 = $_GET['P1']??"";
if ($_GET['P2']??"" != ""){$PAGE_P2 = urldecode($_GET['P2']);} else {$PAGE_P2 = "";}
$cat_lst = $PAGE_P1;

    $KEY = "";
    $USER = "";
    $USER_ID = "";
    $USER_NAME = "";
    $USER_TYPE = "";
    $USER_LANG = "FR";
	if(isset($_COOKIE["KEY"])) {
		$KEY = $_COOKIE["KEY"];
		$sql = "SELECT * FROM user WHERE key_128 = '" . $KEY . "' LIMIT 1";
        $result = $dw3_conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $USER = $row["id"];
                $USER_ID = $row["id"];
                $USER_NAME = $row["name"];
                $USER_TYPE = "user";
                $USER_LANG = strtoupper($row["lang"]);
            }
        } else {
            $sql = "SELECT * FROM customer WHERE key_128 = '" . $KEY . "' LIMIT 1";
            $result = $dw3_conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $USER = $row["id"];
                    $USER_ID = $row["id"];
                    $USER_NAME = dw3_decrypt($row["eml1"]);
                    $USER_TYPE = "customer";
                    $USER_LANG = strtoupper($row["lang"]);
                }
            }
	    }
    } else {
 /*        $cookie_name = "KEY";
        $cookie_value = "";
        $cookie_domain = $_SERVER["SERVER_NAME"];
        setcookie($cookie_name, $cookie_value, [
            'expires' => time() + 86400,
            'path' => '/',
            'domain' => $cookie_domain,
            'secure' => true,
            'httponly' => true,
            'samesite' => 'None',
        ]); */
        //setcookie($cookie_name, $cookie_value, time() + 86400 , "/"); 
}

//langue
    if(isset($_COOKIE["LANG"])) { 
        if ($_COOKIE["LANG"] != "") {
            $USER_LANG = $_COOKIE["LANG"];
        }
    } else if ($USER_LANG != ""){
        //$USER_LANG = $USER_LANG;
    } else if ($INDEX_LANG != ""){ 
        $USER_LANG = $INDEX_LANG;
    } else {
        $USER_LANG = "FR";
    }

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
//TEXTE & TRADUCTIONS PAR APP 
if ($APNAME??"" != ""){
    $sql = "SELECT * FROM config WHERE kind = 'LBL_".strtoupper($APNAME)."'" ;
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
//user favorite store
if(isset($_COOKIE["STORE"])) { 
    if ($_COOKIE["STORE"] != "") {
        $USER_STORE = $_COOKIE["STORE"];
    } else {
        $USER_STORE = $CIE_DFT_ADR3; 
    }
} else { 
    $USER_STORE = $CIE_DFT_ADR3;
}
//user favorite delivery method
if(isset($_COOKIE["DELIVERY"])) { 
    if ($_COOKIE["DELIVERY"] != "") {
        $USER_DELIVERY = $_COOKIE["DELIVERY"];
    } else {
        $USER_DELIVERY = "";
    }
} else {
    $USER_DELIVERY = "";
}


    $COOKIE_PREF1 = "OK";
    $COOKIE_PREF2 = "NO";
    $COOKIE_PREF3 = "OK";
    $COOKIE_PREF4 = "OK";
    //$dw3_cart_string = "";
    //$dw3_cart=array();
    $dw3_cart_count = 0;
    $dw3_wish_count = 0;
    $dw3_wish_string = "";
    $dw3_wish=array();
    $dw3_wish_count = 0;
    foreach ($_COOKIE as $key=>$val)
    {
        if ($key == "COOKIE_PREF1"){$COOKIE_PREF1 = $val;}
        if ($key == "COOKIE_PREF2"){$COOKIE_PREF2 = $val;}
        if ($key == "COOKIE_PREF3"){$COOKIE_PREF3 = $val;}
        if ($key == "COOKIE_PREF4"){$COOKIE_PREF4 = $val;}

/*         if (substr($key, 0, 5) == "CART_" && $val != "0" || substr($key, 0, 3) == "AD_" && $val != "0"){
            $dw3_cart_count++;
        }
        if (substr($key, 0, 5) == "CART_" && $val != "0"){
            $dw3_cart[$key]=$val;
            $dw3_cart_string .= ltrim($key,"CART_") . ",";
        } */

/*         if (substr($key, 0, 10) == "CART_COUNT" && $val != "0"){
            $dw3_cart_count = $dw3_cart_count + $val;
        } */

        if (substr($key, 0, 3) == "AD_" && $val != "0"){
            $dw3_cart_count++;
        }
        if (substr($key, 0, 5) == "WISH_" && $val != "0"){
        $dw3_wish_count++;
        $dw3_wish[$key]=$val;
        $dw3_wish_string .= ltrim($key,"WISH_") . ",";
        }
    }
/*         $sql = "SELECT COUNT(*) as cart_count FROM cart_line WHERE device_id = '" . $USER_DEVICE . "';";
        $result = mysqli_query($dw3_conn, $sql);
        if ($result->num_rows > 0) {
            $data = mysqli_fetch_assoc($result);
            $dw3_cart_count = $data["cart_count"];
        }
        $cookie_name = "CART_COUNT";
        $cookie_value = $dw3_cart_count;
        setcookie($cookie_name, $cookie_value, time() + 86400 , "/"); */

    //$dw3_cart_string = rtrim($dw3_cart_string,",");
    //$dw3_wish_string = rtrim($dw3_cart_string,",");

?>