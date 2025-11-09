<?php
date_default_timezone_set('America/New_York');
setlocale(LC_ALL, 'fr_CA');
$REDIR = "<html><head><title>Server Maintenance</title><meta http-equiv=\"refresh\" content=\"9;URL='https://" . $_SERVER["SERVER_NAME"] . "\"></head><body>Sorry! the server is currently in maintenance. Verifying status every 10 seconds..</body></html>";  
$remote_ip = $_SERVER['REMOTE_ADDR'];

$dw3_ini = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/sbin/config.ini");
$dw3_conn = new mysqli($dw3_ini["mysqli_servername"],$dw3_ini["mysqli_username"], $dw3_ini["mysqli_password"], $dw3_ini["mysqli_dbname"]);
if ($dw3_conn->connect_error) {
    die($REDIR);
}
$PAGE_ID = $_GET['PID']??"";
$PAGE_P1 = $_GET['P1']??"";
if ($_GET['P2']??"" != ""){$PAGE_P2 = urldecode($_GET['P2']);} else {$PAGE_P2 = "";}
$cat_lst = $PAGE_P1;

$today = date("Y-m-d");
$time = date("H:i:s");
$datetime = date("Y-m-d H:i:s");  
$dw3_conn->set_charset('utf8mb4');
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/dw3_func.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/env_var.php';

    $KEY = $_GET['KEY']??"";
    $USER = "";
    $USER_ID = "";
    $USER_NAME = "";
    $USER_LANG = "";
    $USER_TYPE = "nd";
    if(isset($_GET['EML'])) {
        $USER_EML = $_GET['EML'];
    } else {
        $USER_EML = "";
    }
	if($KEY != "" || isset($_COOKIE["KEY"])) {
        if($KEY == ""){$KEY = $_COOKIE["KEY"];}
		$sql = "SELECT * FROM user WHERE key_128 = '" . $KEY . "' LIMIT 1";
        $result = $dw3_conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $USER = $row["id"];
                $USER_ID = $row["id"];
                $USER_NAME = $row["name"];
                $USER_LANG = strtoupper($row["lang"]);
                $USER_EML = $row["eml1"];
                $USER_TYPE = "user";
            }
        } else {
            $sql = "SELECT * FROM customer WHERE key_128 = '" . $KEY . "' LIMIT 1";
            $result = $dw3_conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $USER = $row["id"];
                    $USER_ID = $row["id"];
                    $USER_NAME = dw3_decrypt($row["eml1"]);
                    $USER_LANG = strtoupper($row["lang"]);
                    $USER_EML = dw3_decrypt($row["eml1"]);
                    $USER_TYPE = "customer";
                }
            }
	    }
    }else{
/*         $cookie_name = "KEY";
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

    if(isset($_COOKIE["LANG"])) { 
        if ($_COOKIE["LANG"] != "") {
            $USER_LANG = $_COOKIE["LANG"];
        }
    } else if ($USER_LANG != ""){
        //$USER_LANG = $USER_LANG;
    } else if (isset($INDEX_LANG) && $INDEX_LANG != ""){
        //$cookie_name = "LANG";
        //$cookie_value = $INDEX_LANG;
        //setcookie($cookie_name, $cookie_value, time() + 86400 , "/"); 
        $USER_LANG  = $INDEX_LANG;
    } else {
        //$cookie_name = "LANG";
        //$cookie_value = "FR";
        //setcookie($cookie_name, $cookie_value, time() + 86400 , "/"); 
        $USER_LANG  = "FR";
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
    } else if(isset($CIE_DFT_ADR3)) {
        $USER_STORE = $CIE_DFT_ADR3; 
    }
} else  if(isset($CIE_DFT_ADR3)){
    $USER_STORE = $CIE_DFT_ADR3;
} else {
    $USER_STORE = "1";
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
    $dw3_wish_string = "";
    $dw3_wish=array();
    $dw3_wish2_string = "";
    $dw3_wish2=array();
    $dw3_wish_count = 0;
    foreach ($_COOKIE as $key=>$val)
    {
        if ($key == "COOKIE_PREF1"){$COOKIE_PREF1 = $val;}
        if ($key == "COOKIE_PREF2"){$COOKIE_PREF2 = $val;}
        if ($key == "COOKIE_PREF3"){$COOKIE_PREF3 = $val;}
        if ($key == "COOKIE_PREF4"){$COOKIE_PREF4 = $val;}

        if (substr($key, 0, 3) == "AD_" && $val != "0"){
            $dw3_cart_count++;
        }
/*         if (substr($key, 0, 10) == "CART_COUNT" && $val != "0"){
            $dw3_cart_count = $dw3_cart_count + $val;
        } */
/*         if (substr($key, 0, 5) == "CART_" && $val != "0"){
            $dw3_cart[$key]=$val;
            $dw3_cart_string .= ltrim($key,"CART_") . ",";
        } */
        if (substr($key, 0, 5) == "WISH_" && $val != "0"){
        $dw3_wish_count++;
        $dw3_wish[$key]=$val;
        $dw3_wish_string .= ltrim($key,"WISH_") . ",";
        }
        if (substr($key, 0, 5) == "WISH2" && $val != "0"){
        $dw3_wish_count++;
        $dw3_wish2[$key]=$val;
        $dw3_wish2_string .= ltrim($key,"WISH2_") . ",";
        }
    }
    $sql = "SELECT COUNT(*) as cart_count FROM cart_line WHERE device_id = '" . $USER_DEVICE . "' AND product_id IN( SELECT id FROM product WHERE stat = 0 AND web_dsp = 1);";
    $result = mysqli_query($dw3_conn, $sql);
    if ($result->num_rows > 0) {
        $data = mysqli_fetch_assoc($result);
        $dw3_cart_count = $dw3_cart_count + $data["cart_count"];
    }
        $cookie_name = "CART_COUNT";
        $cookie_value = $dw3_cart_count;
        $cookie_domain = ".".$_SERVER["SERVER_NAME"];
        setcookie($cookie_name, $cookie_value, [
        'expires' => 'Session',
        'path' => '/',
        'domain' => $cookie_domain,
        'secure' => false,
        'httponly' => false,
        'samesite' => '',
        ]);

    //$dw3_cart_string = rtrim($dw3_cart_string,",");
    $dw3_wish_string = rtrim($dw3_wish_string,",");
    $dw3_wish2_string = rtrim($dw3_wish2_string,",");

$sql = "SELECT * FROM index_head WHERE id = '" . str_replace("'", "", $PAGE_ID) . "';";
$result = mysqli_query($dw3_conn, $sql);
if ($result->num_rows > 0) {
    $data = mysqli_fetch_assoc($result);
    if ($data["url"]=="/"){
        $PAGE_ID = 0;
    }
}
 $dw3_section="";
 $dw3_sql = "SELECT * FROM index_head WHERE parent_id = '".$PAGE_ID."' AND target='section' ORDER BY menu_order ASC;";
 //$dw3_sql = "SELECT * FROM index_head WHERE parent_id = '0' ORDER BY menu_order ASC";
 $dw3_result = $dw3_conn->query($dw3_sql);
    if ($dw3_result->num_rows > 0) {
        while($row = $dw3_result->fetch_assoc()) {
            $dw3_section .= '{"id":"'.$row["id"].'",'
                            . '"title":"'.$row["title"].'",'
                            . '"url":"'.$row["url"].'",'
                            . '"scene":"'.$row["scene"].'",'
                            . '"target":"'.$row["target"].'",'
                            . '"menu":"'.$row["is_in_menu"].'",'
                            . '"cat_list":"'.$row["cat_list"].'",'
                            . '"img_url":"'.$row["img_url"].'",'
                            . '"img_display":"'.$row["img_display"].'",'
                            . '"title_display":"'.$row["title_display"].'",'
                            . '"icon_display":"'.$row["icon_display"].'",'
                            . '"opacity":"'.$row["opacity"].'",'
                            . '"background":"'.$row["background"].'",'
                            . '"foreground":"'.$row["foreground"].'",'
                            . '"max_width":"'.$row["max_width"].'",'
                            . '"border_radius":"'.$row["border_radius"].'",'
                            . '"anim":"'.$row["anim_class"].'",'
                            . '"margin":"'.$row["margin"].'",'
                            . '"icon":"'.$row["icon"].'"},';
        }
    } else {
        $dw3_section .= '{"id":"0",'
            . '"title":"Accueil",'
            . '"url":"/",'
            . '"target":"page",'
            . '"menu":"true",'
            . '"cat_list":"",'
            . '"img_url":"",'
            . '"img_display":"none",'
            . '"title_display":"none",'
            . '"opacity":"1",'
            . '"icon_display":"inline-block",'
            . '"icon":"home"},';
    }
    $dw3_section = substr($dw3_section, 0, -1);
    
$PAGE_HEADER = $INDEX_HEADER;
$PAGE_SCENE = "";
$PAGE_PID = "0";
$PAGE_TITLE = "";
$PAGE_TITLE_EN = "";
$PAGE_META_DESC = "";
$PAGE_META_KEYW = "";
$PAGE_IMG = "";
$PAGE_SCENE ="";
$PAGE_IMG_DSP = "";
$PAGE_TITLE_DSP = "";
$PAGE_ICON_DSP = "";
$PAGE_TARGET = "";
$PAGE_MENU = "";
$PAGE_ICON ="";
$PAGE_LIST = "";
$PAGE_OPACITY = "";
$PAGE_BG ="";
$PAGE_FG ="";
$PAGE_FONT ="";
$PAGE_MAXW ="";
$PAGE_MARGIN = "";
$PAGE_RADIUS = "";
$PAGE_SHADOW ="";
$PAGE_HTML_FR = "";
$PAGE_HTML_EN = "";
$PAGE_VISITED = "";
$PAGE_URL = "";

//info sur la page ACTUELLE 
if ($PAGE_ID !="" && $PAGE_ID != "0"){
    $sql = "SELECT *
    FROM index_head
    WHERE id = '".$PAGE_ID."'";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
                $PAGE_PID = $row["parent_id"];
                if ($row["header_path"] != ""){$PAGE_HEADER = $row["header_path"];}
                $PAGE_TITLE = $row["title"];
                $PAGE_TITLE_EN = $row["title_en"];
                $PAGE_META_DESC = $row["meta_description"];
                $PAGE_META_KEYW = $row["meta_keywords"];
                $PAGE_IMG = $row["img_url"];
                $PAGE_SCENE = $row["scene"];
                $PAGE_IMG_DSP = $row["img_display"];
                $PAGE_TITLE_DSP = $row["title_display"];
                $PAGE_ICON_DSP = $row["icon_display"];
                $PAGE_TARGET = $row["target"];
                $PAGE_MENU = $row["is_in_menu"];
                $PAGE_ICON = $row["icon"];
                $PAGE_LIST = $row["cat_list"];
                $PAGE_ID = $row["id"];
                $PAGE_OPACITY = $row["opacity"];
                $PAGE_BG = $row["background"];
                $PAGE_FG = $row["foreground"];
                $PAGE_FONT = $row["font_family"];
                $PAGE_MAXW = $row["max_width"];
                $PAGE_MARGIN = $row["margin"];
                $PAGE_RADIUS = $row["border_radius"];
                $PAGE_SHADOW = $row["boxShadow"];
                $PAGE_HTML_FR = $row["html_fr"];
                $PAGE_HTML_EN = $row["html_en"];
                $PAGE_VISITED = $row["total_visited"];
                $PAGE_URL = $row["url"];
                $CIE_BG1 = $row["img_url"];
        }
    } else {
        header("Location: https://" . $_SERVER["SERVER_NAME"] . "/");
        die();
    }
    $sql2 ="UPDATE index_head SET total_visited = total_visited + 1 WHERE id = '".trim($PAGE_ID)."' LIMIT 1;"; 
    if ($dw3_conn->query($sql2) === TRUE) {}else{}
} else {
    if ($PAGE_ID==""){
        if ($_SERVER['SCRIPT_FILENAME'] == $_SERVER["DOCUMENT_ROOT"] . "/pub/page/contact3/index.php"){
            $PAGE_TITLE = "Contact";
            $PAGE_TITLE_EN = "Contact us";
        }
        if ($_SERVER['SCRIPT_FILENAME'] == $_SERVER["DOCUMENT_ROOT"] . "/pub/page/agenda/index.php"){
            $PAGE_TITLE = "Agenda";
            $PAGE_TITLE_EN = "Agenda";
        }
    } 
}
if ($_SERVER['SCRIPT_FILENAME'] == $_SERVER["DOCUMENT_ROOT"] . "/index.php"){
    $sql2 ="UPDATE config SET text1 = CONVERT(CAST(text1 AS INTEGER)+1, CHAR) WHERE kind='INDEX' AND code='TOTAL_VISITED'";
    if ($dw3_conn->query($sql2) === TRUE) {}else{}
    $PAGE_ID = "0";
}

if ($PAGE_META_DESC != ""){ $INDEX_META_DESC = $PAGE_META_DESC;}
if ($PAGE_META_KEYW != ""){ $INDEX_META_KEYW = $PAGE_META_KEYW;}

?>