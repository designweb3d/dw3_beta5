<?php
header("X-Robots-Tag: noindex, nofollow", true);
$cid = trim($_GET['cid']??"");
$uid = trim($_GET['uid']??"");
$eml = trim($_GET['eml']??"");
if ($cid == "" && $uid == "" && $eml == "") {
    die ('Option invalide');
}	
date_default_timezone_set('America/New_York');
$dw3_ini = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/sbin/config.ini");
$dw3_conn = new mysqli($dw3_ini["mysqli_servername"],$dw3_ini["mysqli_username"], $dw3_ini["mysqli_password"], $dw3_ini["mysqli_dbname"]);
$dw3_conn->set_charset("utf8mb4");

if ($dw3_conn->connect_error) {
   //$dw3_conn->close();
   die("Erreur");
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/dw3_func.php'; 

if ($cid != "") {
    $sql = "SELECT * FROM customer WHERE key_128 = '" . $cid . "' LIMIT 1;";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $out_msg = "F";
    } else {
        $out_msg = "NF";
        $data = "";
    }

    $sql = "UPDATE customer SET news_stat = 0, key_128 = '' WHERE key_128 = '" . $cid . "' AND key_128 <> '';";
    //die($sql);
    $response = $dw3_conn->query($sql);
} else if ($uid != "") {
    $sql = "SELECT * FROM user WHERE id = '" . $uid . "' LIMIT 1;";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $out_msg = "F";
    } else {
        $out_msg = "NF";
        $data = "";
    }

    $sql = "UPDATE user SET news_stat = 0 WHERE id = '" . $uid . "';";
    //die($sql);
    $response = $dw3_conn->query($sql);
} else if ($eml != "") {
    $sql = "SELECT * FROM customer WHERE eml1 = '" . dw3_crypt(strtolower($eml)) . "' LIMIT 1;";
    $sql_o = $sql;
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $out_msg = "F";
    } else {
        $out_msg = "NF";
        $data = "";
    }
    $sql = "UPDATE customer SET news_stat = 0 WHERE eml1 = '" . dw3_crypt(strtolower($eml)) . "';";
    //die($sql);
    $response = $dw3_conn->query($sql);
}

//GLOBAL
$sql = "SELECT *
FROM config
WHERE kind = 'CIE'";

$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if ($row["code"] == "TITRE")			{$CIE_TITRE = $row["text1"];
        } else if ($row["code"] == "NOM")		{$CIE_NOM = $row["text1"];	
        } else if ($row["code"] == "THEME")	{$CIE_THEME = $row["text1"]; //css theme	
        } else if ($row["code"] == "HOME")	{$CIE_HOME = $row["text1"];
        } else if ($row["code"] == "TYPE")	{$CIE_TYPE = $row["text1"];
        } else if ($row["code"] == "CAT")		{$CIE_CAT = $row["text1"];
        } else if ($row["code"] == "EML1")	{$CIE_EML1 = $row["text1"];			
        } else if ($row["code"] == "EML2")	{$CIE_EML2 = $row["text1"];		
        } else if ($row["code"] == "COLOR1")	{$CIE_COLOR1 = $row["text1"];
        } else if ($row["code"] == "COLOR1_2")	{$CIE_COLOR1_2 = trim($row["text1"]);
        } else if ($row["code"] == "COLOR1_3")	{$CIE_COLOR1_3 = trim($row["text1"]);
        } else if ($row["code"] == "COLOR2")	{$CIE_COLOR2 = $row["text1"];
        } else if ($row["code"] == "COLOR3")	{$CIE_COLOR3 = $row["text1"];
        } else if ($row["code"] == "COLOR4")	{$CIE_COLOR4 = $row["text1"];
        } else if ($row["code"] == "COLOR5")	{$CIE_COLOR5 = $row["text1"];
        } else if ($row["code"] == "COLOR6")	{$CIE_COLOR6 = $row["text1"];
        } else if ($row["code"] == "COLOR7")	{$CIE_COLOR7 = $row["text1"];
        } else if ($row["code"] == "COLOR8")	{$CIE_COLOR8 = $row["text1"];
        } else if ($row["code"] == "COLOR8_2")	{$CIE_COLOR8_2 = trim($row["text1"]);
        } else if ($row["code"] == "COLOR8_3")	{$CIE_COLOR8_3 = trim($row["text1"]);
        } else if ($row["code"] == "COLOR8_4")	{$CIE_COLOR8_4 = trim($row["text1"]);
        } else if ($row["code"] == "COLOR8_3S")	{$CIE_COLOR8_3S = trim($row["text1"]);
        } else if ($row["code"] == "COLOR8_4S")	{$CIE_COLOR8_4S = trim($row["text1"]);
        } else if ($row["code"] == "COLOR9")	{$CIE_COLOR9 = $row["text1"];
        } else if ($row["code"] == "COLOR10")	{$CIE_COLOR10 = trim($row["text1"]);
        } else if ($row["code"] == "EML1")	{$CIE_EML1 = $row["text1"];		
        } else if ($row["code"] == "EML2")	{$CIE_EML2 = $row["text1"];	
        } else if ($row["code"] == "EML3")	{$CIE_EML3 = $row["text1"];
        } else if ($row["code"] == "EML4")	{$CIE_EML4 = $row["text1"];	
        } else if ($row["code"] == "LOGO1")	{$CIE_LOGO1 = $row["text1"];
        } else if ($row["code"] == "LOGO2")	{$CIE_LOGO2 = $row["text1"];
        } else if ($row["code"] == "LOGO3")	{$CIE_LOGO3 = $row["text1"];
        } else if ($row["code"] == "LOGO4")	{$CIE_LOGO4 = $row["text1"];
        } else if ($row["code"] == "LOGO5")	{$CIE_LOGO5 = $row["text1"];
        } else if ($row["code"] == "FONT")	{$CIE_FONT = $row["text1"];
        } else if ($row["code"] == "FONT_SERIF")	{$CIE_FONT_SERIF = $row["text1"];
        } else if ($row["code"] == "ADR1")	{$CIE_ADR1 = $row["text1"];						
        } else if ($row["code"] == "ADR2")	{$CIE_ADR2 = $row["text1"];						
        } else if ($row["code"] == "TEL1")	{$CIE_TEL1 = $row["text1"];										
        } else if ($row["code"] == "TEL2")	{$CIE_TEL2 = $row["text1"];												
        } else if ($row["code"] == "VILLE")		{$CIE_VILLE_ID = $row["text1"];			
        } else if ($row["code"] == "PROV")		{$CIE_PROV_ID = $row["text1"];			
        } else if ($row["code"] == "PAYS")		{$CIE_PAYS_ID = $row["text1"];						
        }
    }
}
$dw3_conn->close();
?><!DOCTYPE html>
<html><head>
	<meta charset="utf-8">
	<title><?php echo $CIE_NOM; ?></title>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Orelega+One&family=Roboto:wght@100&display=swap" rel="stylesheet">	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<meta name="viewport" content="width=device-width, user-scalable=no" />
	<meta name="msapplication-TileImage" content="https://dw3.ca/img/favicon.ico" />
    <link rel="icon" type="image/png" href="/pub/img/favicon.ico">
<style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/pub/css/index.css.php'; ?>
</style></head><body style='text-align:center;'>
<div id="divHEAD" style='left:0px;border-radius:0px;height:40px;background:rgba(0,0,0,0.8);color:#fff;'>
	<table width="100%"><tr>
		<td onclick="window.open('https://<?php echo $_SERVER["SERVER_NAME"]; ?>','_self');" style="text-align:center;vertical-align:middle;cursor:pointer;">
            <img src="/pub/img/<?php echo $CIE_LOGO3; ?>" style="vertical-align:middle;height:32px;width:auto;"> <?php echo $CIE_NOM; ?>
        </td>
		<td width="30" onclick="window.open('https://<?php echo $_SERVER["SERVER_NAME"]; ?>/client','_self');" style="vertical-align:middle;text-align:center;cursor:pointer;background-color:#eee;border-radius:10px;"> 
            <span id="dw3_lang_span" class="material-icons" style="cursor:pointer;font-size:24px;color:#333;">login</span>
        </td>
	</tr></table>
</div>
<div class='divMAIN' style='background:rgba(0,0,0,0.8);color:#fff;line-height:2;box-shadow:3px 3px 6px 2px #333;width:auto;padding:10px 0px;position:fixed;top: 50%;left: 50%;-moz-transform: translateX(-50%) translateY(-50%);-webkit-transform: translateX(-50%) translateY(-50%);transform: translateX(-50%) translateY(-50%);min-width:350px;border-style: double;border:1px solid #777;border-radius:20px;'>  
    <br>
    <?php 
    if ($out_msg == "F"){ ?>
        <div class='divBOX' style='font-size:0.8em;max-width:400px;'>Votre adresse courriel a été retirée de la liste d'envoi des infolettres.</div><hr><br>
        <div class='divBOX' style='font-size:0.8em;max-width:400px;'>Your email address has been removed from the newsletter mailing list.</div><br>
    <?php } else if ($out_msg == "NF") { ?>
        <div class='divBOX' style='font-size:0.8em;max-width:400px;'>Le lien a expiré. Veuillez-vous connecter pour modifier vos préférences de communications.<br>
            <button onclick="window.open('https://<?php echo $_SERVER["SERVER_NAME"]; ?>/client','_self');">Se connecter</button>
        </div><hr><br>
        <div class='divBOX' style='font-size:0.8em;max-width:400px;'>The link has expired. Please log in to change your communication preferences.<br>
            <button onclick="window.open('https://<?php echo $_SERVER["SERVER_NAME"]; ?>/client','_self');">LogIn</button>
        </div><br>
    <?php } ?>
</div>

</body></html>