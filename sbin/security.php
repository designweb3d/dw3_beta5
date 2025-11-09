<?php 
//header("X-Robots-Tag: noindex, nofollow", true);
$KEY = $_GET['KEY']??'';
if ($KEY == ''){
    $KEY= $_POST['KEY']??'';
    if ($KEY == ''){
        header("Location: https://" . $_SERVER["SERVER_NAME"] . "/");
        exit;
    }
}
$RIP = $_SERVER['REMOTE_ADDR'];
$PAGE1 = strtok(substr($_SERVER["REQUEST_URI"],strrpos($_SERVER["REQUEST_URI"],"/")+1),'?'); 
//$PAGE2 = str_replace("/", "",dirname($_SERVER['REQUEST_URI'])) . ".php"; 
$PAGE2 = strtok(substr(dirname($_SERVER["REQUEST_URI"]),strrpos(dirname($_SERVER["REQUEST_URI"]),"/")+1),'?') . ".php"; 
date_default_timezone_set('America/New_York');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$today = date("Y-m-d"); // 2023-02-23
$time = date("H:i:s"); // 11:00:30
$datetime = date("Y-m-d H:i:s"); // 2023-02-23 11:00:30
$domain_path = "https://" . $_SERVER["SERVER_NAME"] . "/";  //-> https://dw3.ca/
$domain_name = strtok(substr($_SERVER["DOCUMENT_ROOT"],strrpos($_SERVER["DOCUMENT_ROOT"],"/")+1),'?');  // dw3.ca
$domain_shortname = substr($domain_name,0,strrpos($domain_name,".")); // dw3
$headers = apache_request_headers(); // Array
$method = $_SERVER['REQUEST_METHOD']; // GET, POST,..
//$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1)); // Array 
$remote_agent = $_SERVER['HTTP_USER_AGENT']??null; //Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36
$req_root = $_SERVER["DOCUMENT_ROOT"]; // /home/uaqkv257/dw3.ca
$req_url = $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI']; // dw3.ca/security_user.php
$req_filename = basename(__FILE__);  // security_user.php
$req_dirname = dirname($_SERVER['REQUEST_URI']); if ($req_dirname =="/app/config"){$PAGE2 = "config.php";}
$dw3_ini = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/sbin/config.ini");
$dw3_conn = new mysqli($dw3_ini["mysqli_servername"],$dw3_ini["mysqli_username"], $dw3_ini["mysqli_password"], $dw3_ini["mysqli_dbname"]);
$dw3_conn->set_charset("utf8mb4");
if ($dw3_conn->connect_error) {
    $dw3_conn->close();
    header("Location: https://" . $_SERVER["SERVER_NAME"] . "/");
    exit;
}
//$client_info = mysqli_get_client_info();
//$client_stats = mysqli_get_client_stats();
//$client_version = mysqli_get_client_version();
//***_TO_DO_*** 
//check if remote ip is in the blacklist database
//key vs navigator changed since last login and validation with the user



//Validation de l'utilisateur avec KEY
//verifier si cle valide et chercher USERID
	$sql = "SELECT * FROM user WHERE key_128 = '" . $KEY . "' LIMIT 1";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows == 0) {
        //error_log("Invalid key: ". $KEY. " ip:".$RIP); 
        $dw3_conn->close();
        header("Location: https://" . $_SERVER["SERVER_NAME"] . "/");
        exit;
	} 
	while($row = $result->fetch_assoc()) {
		$USER = $row["id"];
		$USER_LANG = strtoupper($row["lang"]);
		$USER_AUTH = $row["auth"];
		$USER_LOC = $row["location_id"];
		$USER_APLC = $row["app_id"];
		$USER_NAME = $row["name"];
		$USER_FULLNAME = trim($row["first_name"]." ".$row["last_name"]);
        $USER_INACTIVE = $row["inactive_minutes"];
		$USER_EMAIL = $row["eml1"];
		$USER_FULLNAME = $row["first_name"] . " " . $row["last_name"];
		$USER_RTE = $row["road_id"] ;
	}
	
//Verifier si user a droit SUR LA PAGE QUI FAIT LA REQUETE REQUEST_URI
    $sql = "SELECT *,app.name_fr as app_name
    FROM app_user
    LEFT JOIN app on app_user.app_id = app.id
    WHERE app_user.user_id = '" . $USER . "'
    AND CONCAT(app.filename,'.php') = '" . $PAGE1 . "'
    OR
    app_user.user_id = '" . $USER . "'
    AND CONCAT(app.filename,'.php') = '" . $PAGE2 . "'
    LIMIT 1";
    $APNAME ="";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows == 0) {		
        if ($PAGE1 != "resetPRM.php" && $PAGE1 != "scene.php" && $PAGE1 != "selUSER.php" && $PAGE1 != "selCLI.php" && $PAGE1 != "selPRD.php" && $req_dirname != "/sbin" && substr($req_dirname,0,4) != "/api" && substr($req_dirname,0,3) != "/js" && substr($req_dirname,0,4) != "/doc" && substr($req_dirname,0,5) != "/font" && substr($req_dirname,0,4) != "/img") {
            //echo $PAGE1;
            $dw3_conn->close();
            //error_log("no app" . $req_dirname); 
            header("Location: https://" . $_SERVER["SERVER_NAME"] . "/");
            exit;
        }
    } else {
        while($row = $result->fetch_assoc()) {
            $APID = $row["app_id"];
            $APNAME = $row["app_name"];
            $APFNAME = $row["filename"];
            if ($row["read_only"] == "1") { $APREAD_ONLY = true; } else { $APREAD_ONLY = false; }
            if (strtoupper($USER_LANG) == "FR"){ $LBL_HEAD  = $row["name_fr"]; } else { $LBL_HEAD  = $row["name_en"];}
        }
    }
    //echo $PAGE1 . $PAGE2 . $USER_LANG;


require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/env_var.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/dw3_func.php';

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
?>
