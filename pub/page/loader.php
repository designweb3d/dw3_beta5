<?php
date_default_timezone_set('America/New_York');
$REDIR = "<html><head><title>Server Maintenance</title><meta http-equiv=\"refresh\" content=\"9;URL='https://" . $_SERVER["SERVER_NAME"] . "\"></head><body>Sorry! the server is currently in maintenance. Verifying status every 10 seconds..</body></html>";  
$remote_ip = $_SERVER['REMOTE_ADDR'];
/* $arin_url = "https://rdap.arin.net/registry/ip/" . $remote_ip;
$arin_curl = curl_init();
curl_setopt($arin_curl, CURLOPT_URL, $arin_url);
curl_setopt($arin_curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($arin_curl, CURLOPT_HEADER, false);
$arin_data = curl_exec($arin_curl);
curl_close($arin_curl);
$arin_json_data = json_decode($arin_data, true);
$arin_first_handle = $arin_json_data['entities'][0]['handle'];
$arin_country_array= $arin_json_data['entities'][0]['vcardArray'];
$arin_country_string = json_encode($arin_country_array);
if (strpos(strtoupper($arin_country_string), "CANADA") == ""){$arin_country = "unknown";}else{$arin_country = "Canada";}
if (strpos(strtoupper($arin_country_string), "UNITED STATES") == "" && $arin_country == "unknown"){$arin_country = "United States";}
if (strpos(strtoupper($arin_country_string), "AUSTRALIA") == "" && $arin_country == "unknown"){$arin_country = "Australia";}
if (strpos(strtoupper($arin_country_string), "NETHERLANDS") == "" && $arin_country == "unknown"){$arin_country = "Netherlands";}
if (strpos(strtoupper($arin_country_string), "IRELAND") == "" && $arin_country == "unknown"){$arin_country = "Ireland";}
if ($arin_country != "Canada"){
    error_log("Outsider:".$remote_ip. " " .$arin_country_string);
    //die ($REDIR);    
}else{
    error_log("Canadian:".$remote_ip. " " .$arin_country_string);
} */
$arin_country = "Unknown";

$dw3_ini = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/sbin/config.ini");
$dw3_conn = new mysqli($dw3_ini["mysqli_servername"],$dw3_ini["mysqli_username"], $dw3_ini["mysqli_password"], $dw3_ini["mysqli_dbname"]);
if ($dw3_conn->connect_error) {
    die($REDIR);
}
$PAGE_ID = $_GET['PID']??"";
$PAGE_P1 = $_GET['P1']??"";
if ($_GET['P2']??"" != ""){$PAGE_P2 = urldecode($_GET['P2']);} else {$PAGE_P2 = "";}
$PAGE_P2 = urldecode($_GET['P2'])??"";
$today = date("Y-m-d");
$time = date("H:i:s");
$datetime = date("Y-m-d H:i:s");  
$dw3_conn->set_charset('utf8mb4');
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/dw3_func.php';

    $KEY = $_GET['KEY']??"";
    $USER = "";
    $USER_ID = "";
    $USER_NAME = "";
    $USER_LANG = "";
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
    $COOKIE_PREF1 = "OK";
    $COOKIE_PREF2 = "NO";
    $COOKIE_PREF3 = "OK";
    $COOKIE_PREF4 = "OK";
    $dw3_cart_string = "";
    $dw3_cart=array();
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

        if (substr($key, 0, 5) == "CART_" && $val != "0" || substr($key, 0, 3) == "AD_" && $val != "0"){
            $dw3_cart_count++;
        }
        if (substr($key, 0, 5) == "CART_" && $val != "0"){
            $dw3_cart[$key]=$val;
            $dw3_cart_string .= ltrim($key,"CART_") . ",";
        }
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
    $dw3_cart_string = rtrim($dw3_cart_string,",");
    $dw3_wish_string = rtrim($dw3_wish_string,",");
    $dw3_wish2_string = rtrim($dw3_wish2_string,",");

require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/env_var.php';

if(isset($_COOKIE["LANG"])) { 
    if ($_COOKIE["LANG"] != "") {
        $USER_LANG = $_COOKIE["LANG"];
    }
} else if ($INDEX_LANG != ""){
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
 $dw3_section="";
 $dw3_sql = "SELECT * FROM index_head WHERE parent_id=0 AND target='page' OR parent_id=0 AND target='sub' OR parent_id=0 AND target='button' OR parent_id = '".$PAGE_ID."' AND target='section' ORDER BY menu_order ASC;";
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
    
$SECTION_HEADER = $INDEX_HEADER;
$SECTION_SCENE = "";
$SECTION_PID = "0";
$SECTION_TITLE = "";
$SECTION_TITLE_EN = "";
$SECTION_IMG = "";
$SECTION_SCENE ="";
$SECTION_IMG_DSP = "";
$SECTION_TITLE_DSP = "";
$SECTION_ICON_DSP = "";
$SECTION_TARGET = "";
$SECTION_MENU = "";
$SECTION_ICON ="";
$SECTION_LIST = "";
$SECTION_ID = "";
$SECTION_OPACITY = "";
$SECTION_BG ="";
$SECTION_FG ="";
$SECTION_FONT ="";
$SECTION_MAXW ="";
$SECTION_MARGIN = "";
$SECTION_RADIUS = "";
$SECTION_SHADOW ="";
$SECTION_HTML_FR = "";
$SECTION_HTML_EN = "";
$SECTION_VISITED = "";
if (!isset($SECTION_URL)){$SECTION_URL = "";}

//info sur la page ACTUELLE 
if ($PAGE_ID !="" && $PAGE_ID != "0"){
    $sql = "SELECT *
    FROM index_head
    WHERE id = '".$PAGE_ID."'";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
                $SECTION_PID = $row["parent_id"];
                if ($row["header_path"] != ""){$SECTION_HEADER = $row["header_path"];}
                $SECTION_TITLE = $row["title"];
                $SECTION_TITLE_EN = $row["title_en"];
                $SECTION_IMG = $row["img_url"];
                $SECTION_SCENE = $row["scene"];
                $SECTION_IMG_DSP = $row["img_display"];
                $SECTION_TITLE_DSP = $row["title_display"];
                $SECTION_ICON_DSP = $row["icon_display"];
                $SECTION_TARGET = $row["target"];
                $SECTION_MENU = $row["is_in_menu"];
                $SECTION_ICON = $row["icon"];
                $SECTION_LIST = $row["cat_list"];
                $SECTION_ID = $row["id"];
                $SECTION_OPACITY = $row["opacity"];
                $SECTION_BG = $row["background"];
                $SECTION_FG = $row["foreground"];
                $SECTION_FONT = $row["font_family"];
                $SECTION_MAXW = $row["max_width"];
                $SECTION_MARGIN = $row["margin"];
                $SECTION_RADIUS = $row["border_radius"];
                $SECTION_SHADOW = $row["boxShadow"];
                $SECTION_HTML_FR = $row["html_fr"];
                $SECTION_HTML_EN = $row["html_en"];
                $SECTION_VISITED = $row["total_visited"];
                $SECTION_URL = $row["url"];
                $CIE_BG1 = $row["img_url"];
        }
    } else {
        header("Location: https://" . $_SERVER["SERVER_NAME"] . "/");
        die();
    }
    $sql2 ="UPDATE index_head SET total_visited = total_visited + 1 WHERE id = '".trim($PAGE_ID)."' LIMIT 1;"; 
    if ($dw3_conn->query($sql2) === TRUE) {}else{}
} else {
    $PAGE_ID ="";
    if ($_SERVER['SCRIPT_FILENAME'] == $_SERVER["DOCUMENT_ROOT"] . "/pub/page/contact3/index.php"){
        $SECTION_TITLE = "Contact";
        $SECTION_TITLE_EN = "Contact us";
    }
    if ($_SERVER['SCRIPT_FILENAME'] == $_SERVER["DOCUMENT_ROOT"] . "/pub/page/agenda/index.php"){
        $SECTION_TITLE = "Agenda";
        $SECTION_TITLE_EN = "Agenda";
    }
}
?>