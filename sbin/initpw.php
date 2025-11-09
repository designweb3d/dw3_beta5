<?php
header("X-Robots-Tag: noindex, nofollow", true);
$REDIR = "<html><head><title>Redirected</title><meta http-equiv=\"refresh\" content=\"0;URL='https://" . $_SERVER["SERVER_NAME"] . "'\"></head></html>";  
$REDIR_EXPIRE = "<html><head><title>Redirected</title><meta http-equiv=\"refresh\" content=\"5;URL='https://" . $_SERVER["SERVER_NAME"] . "'\"></head><body>Le lien pour initialiser votre mot de passe est invalide, veuillez faire une requête de mot de passe perdu à l'adresse suivante: <a href='https://" .$_SERVER["SERVER_NAME"] . "' target='_self'>" .$_SERVER["SERVER_NAME"] . "</a><hr>Redirection dans quelques secondes..</body></html>";  
$KEY = htmlspecialchars($_GET['KEY']);
//check if eml exist
if ($KEY=="") {
    die($REDIR);
}
date_default_timezone_set('America/New_York');
$dw3_ini = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/sbin/config.ini");
$dw3_conn = new mysqli($dw3_ini["mysqli_servername"],$dw3_ini["mysqli_username"], $dw3_ini["mysqli_password"], $dw3_ini["mysqli_dbname"]);
$dw3_conn->set_charset("utf8mb4");
if ($dw3_conn->connect_error) {
    $dw3_conn->close();
    die($REDIR);
}		

    $sql = "SELECT * FROM user WHERE key_128 = '" . $KEY . "' AND pw = '' AND key_expire > '" .date("Y-m-d H:i:s"). "' LIMIT 1";

    //check user first
	$result = $dw3_conn->query($sql);
	if ($result->num_rows == 0) {      
            $dw3_conn->close();
            die($sql);
            die($REDIR_EXPIRE);
    } else { //a user was found	
		while($row = $result->fetch_assoc()) {
            $USER_EMLs = $row["eml1"] . " " . $row["eml2"];
            $USER_NAME = $row["name"];
            $USER_LANG = $row["lang"];
	    }
    }
    $sql = "SELECT *
        FROM config
        WHERE kind = 'CIE'";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {

            //no related to language data
            if ($row["code"] == "HOME")	{$CIE_HOME = $row["text1"];	
            } else if ($row["code"] == "TYPE")	{$CIE_TYPE = $row["text1"];
            } else if ($row["code"] == "NOM")	{$CIE_NOM = $row["text1"];
            } else if ($row["code"] == "CAT")		{$CIE_CAT = $row["text1"];
            } else if ($row["code"] == "EML1")	{$CIE_EML1 = $row["text1"];			
            } else if ($row["code"] == "EML2")	{$CIE_EML2 = $row["text1"];		
			} else if ($row["code"] == "COLOR1")	{$CIE_COLOR1 = trim($row["text1"]);
            } else if ($row["code"] == "COLOR1_2")	{$CIE_COLOR1_2 = trim($row["text1"]);
            } else if ($row["code"] == "COLOR1_3")	{$CIE_COLOR1_3 = trim($row["text1"]);
			} else if ($row["code"] == "COLOR2")	{$CIE_COLOR2 = trim($row["text1"]);
			} else if ($row["code"] == "COLOR3")	{$CIE_COLOR3 = trim($row["text1"]);
			} else if ($row["code"] == "COLOR4")	{$CIE_COLOR4 = trim($row["text1"]);
			} else if ($row["code"] == "COLOR5")	{$CIE_COLOR5 = trim($row["text1"]);
			} else if ($row["code"] == "COLOR0")	{$CIE_COLOR0 = trim($row["text1"]);
			} else if ($row["code"] == "COLOR0_1")	{$CIE_COLOR0_1 = trim($row["text1"]);
			} else if ($row["code"] == "COLOR6")	{$CIE_COLOR6 = trim($row["text1"]);$CIE_COLOR6_2 = trim($row["text2"]);
			} else if ($row["code"] == "COLOR7")	{$CIE_COLOR7 = trim($row["text1"]);$CIE_COLOR7_2 = trim($row["text2"]);$CIE_COLOR7_3 = trim($row["text3"]);
			} else if ($row["code"] == "COLOR8")	{$CIE_COLOR8 = trim($row["text1"]);
            } else if ($row["code"] == "COLOR8_2")	{$CIE_COLOR8_2 = trim($row["text1"]);
            } else if ($row["code"] == "COLOR8_3")	{$CIE_COLOR8_3 = trim($row["text1"]);
            } else if ($row["code"] == "COLOR8_4")	{$CIE_COLOR8_4 = trim($row["text1"]);
            } else if ($row["code"] == "COLOR8_3S")	{$CIE_COLOR8_3S = trim($row["text1"]);
            } else if ($row["code"] == "COLOR8_4S")	{$CIE_COLOR8_4S = trim($row["text1"]);
			} else if ($row["code"] == "COLOR9")	{$CIE_COLOR9 = trim($row["text1"]);
            } else if ($row["code"] == "COLOR10")	{$CIE_COLOR10 = trim($row["text1"]);
            } else if ($row["code"] == "COLOR11")	{$CIE_COLOR11_1 = trim($row["text1"]);$CIE_COLOR11_2 = trim($row["text2"]);$CIE_COLOR11_3 = trim($row["text3"]);
            } else if ($row["code"] == "EML1")	{$CIE_EML1 = $row["text1"];$CIE_EML1PW = trim($row["text2"]);			
			} else if ($row["code"] == "EML2")	{$CIE_EML2 = $row["text1"];$CIE_EML2PW = trim($row["text2"]);		
			} else if ($row["code"] == "EML3")	{$CIE_EML3 = $row["text1"];$CIE_EML3PW = trim($row["text2"]);
			} else if ($row["code"] == "EML4")	{$CIE_EML4 = $row["text1"];$CIE_EML4PW = trim($row["text2"]);	
			} else if ($row["code"] == "LOGO1")	{$CIE_LOGO1 = $row["text1"];
			} else if ($row["code"] == "LOGO2")	{$CIE_LOGO2 = $row["text1"];
			} else if ($row["code"] == "LOGO3")	{$CIE_LOGO3 = $row["text1"];
			} else if ($row["code"] == "LOGO4")	{$CIE_LOGO4 = $row["text1"];
			} else if ($row["code"] == "LOGO5")	{$CIE_LOGO5 = $row["text1"];
            } else if ($row["code"] == "CIE_FONT")	{$CIE_CIE_FONT = $row["text1"];
            } else if ($row["code"] == "CIE_FONT_SERIF")	{$CIE_FONT_SERIF = $row["text1"];
            } else if ($row["code"] == "ADR1")	{$CIE_ADR1 = $row["text1"];						
            } else if ($row["code"] == "ADR2")	{$CIE_ADR2 = $row["text1"];						
            } else if ($row["code"] == "TEL1")	{$CIE_TEL1 = $row["text1"];										
            } else if ($row["code"] == "PTPS")	{$CIE_PTPS = $row["text1"];			
            } else if ($row["code"] == "TPS")		{$CIE_TPS = $row["text1"];			
            } else if ($row["code"] == "PTVQ")	{$CIE_PTVQ = $row["text1"];			
            } else if ($row["code"] == "TVQ")		{$CIE_TVQ = $row["text1"];			
            } else if ($row["code"] == "NEQ")		{$CIE_NEQ = $row["text1"];			
            } else if ($row["code"] == "RBQ")		{$CIE_RBQ = $row["text1"];			
            }

        }
    }

?>	
<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
	<title><?php echo $CIE_NOM; ?></title>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Orelega+One&family=Roboto:wght@100&display=swap" rel="stylesheet">	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<meta name="viewport" content="width=device-width, user-scalable=no" />
	<meta name="msapplication-TileImage" content="https://dw3.ca/pub/img/favicon.png" />
    <link rel="icon" type="image/png" href="/pub/img/favicon.png">

    <style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/pub/css/main.css.php'; ?>
    </style>
</head>
<body style='text-align:center;'>
<div id="bg"></div>
<div id="divHEAD" style='background-color:rgba(255,255,255,0.8);left:5px;'>
	<table width="100%"><tr>
		<td onclick="window.open('https://<?php echo $_SERVER["SERVER_NAME"]; ?>','_self');" style="vertical-align:middle;cursor:pointer;">
            <img src="/pub/img/<?php echo $CIE_LOGO1; ?>" style="vertical-align:middle;height:45px;width:auto;">
            <b style="color:#333;"> <?php echo $CIE_NOM; ?></b>
        </td>
<!-- 		<td width="30" onclick='openLANG();' style="vertical-align:middle;text-align:center;cursor:pointer;background-color:rgba(255,255,255,0.4);border-radius:10px;padding:5px;"> 
            <span class="material-icons" style="cursor:pointer;font-size:24px;color:#000;">translate</span>
        </td> -->
	</tr></table>
</div>
<div id="imgAVATAR" style='position:fixed;top:50px;left:0px;width:100%;'></div>
<div class='divMAIN' style='position:absolute;top:50px;left:0px;min-width:350px;border-bottom-left-radius:20px;border-bottom-right-radius:20px;'>
    <input type='text' class='none' disabled id='txtEML' style='border:0;text-align:center;padding:7px;vertical-align:middle;' value="<?php echo $USER_EMLs; ?>">
    
    <div class='divBOX' style='font-size:0.8em;max-width:400px;'>
    <b>Bonjour <?php echo $USER_NAME; ?>,</b><br>
        Veuillez entrer votre nouveau mot de passe:<br>
        <input type='text' id='txtPW' style='width:150px;text-align:center;padding:7px;vertical-align:middle;' value="">
        <input type='text' id='txtPW2' style='width:150px;text-align:center;padding:7px;vertical-align:middle;' value="">
        <button onclick='setPW();' style='float:right;'><span class='material-icons' style='cursor:pointer;font-size:22px;vertical-align:middle;'>explore</span> Créer</button>
	</div>
</div>


</div>
<div id='divFADE' onclick="closeMSG();"></div>
<div id="divMSG"></div>
<div id="bg_fade"></div>
<script src="/pub/js/multiavatar.min.js"></script>

<script>
var KEY = '<?php echo $KEY; ?>';
var LANG = '<?php if(isset($_COOKIE["LANG"])) { echo $_COOKIE["LANG"]; } else if ($USER_LANG != "") { echo $USER_LANG; } ?>';
var USER_NAME = '<?php echo $USER_NAME; ?>';
changeAVATAR(USER_NAME);

function openLANG() {
    document.getElementById("divFADE").innerHTML = "<img style='width:100px;height:auto;' src='/img/<?php echo $CIE_LOAD; ?>'>";
    document.getElementById("divFADE").style.display = "inline-block";
    document.getElementById("divFADE").style.opacity = "1";
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Veuillez choisir votre langue:<br><button onclick='setLANG(\"FR\");'><img src=\"https://dataia.ca/img/flags/84.png\"' style='height:32px;width:auto;'> Français</button> <button onclick='setLANG(\"EN\");'><img src=\"https://dataia.ca/img/flags/86.png\"' style='height:32px;width:auto;'> English</button>";
}
function changeAVATAR(avatarId){
    if (avatarId == ""){avatarId = " ";}
	var svgCode = multiavatar(avatarId);
	document.getElementById("imgAVATAR").innerHTML=svgCode;
}
function closeMSG() {
	document.getElementById('divFADE').style.display = 'none';
	document.getElementById('divMSG').style.display = 'none';

}
function setPW() {
	var sPW = document.getElementById("txtPW").value;
	var sPW2 = document.getElementById("txtPW2").value;
    if (sPW.trim() == ""){
        document.getElementById("divFADE").style.opacity = "0.6";
	    document.getElementById("divFADE").style.display = "inline-block";
        document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "Veuillez entrer un mot de passe.<br><br><button onclick='closeMSG();document.getElementById(\"inUSER\").focus();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide</button>";
        document.getElementById("txtPW").style.boxShadow = "5px 10px 15px red";
		document.getElementById("txtPW").focus();
        return;
    }
    if (sPW.trim().lenght <= 7){
        document.getElementById("divFADE").style.opacity = "0.6";
	    document.getElementById("divFADE").style.display = "inline-block";
        document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "Le mot de passe est trop court. Minimum 8 caractères.<br><br><button onclick='closeMSG();document.getElementById(\"inUSER\").focus();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide</button>";
        document.getElementById("txtPW").style.boxShadow = "5px 10px 15px red";
		document.getElementById("txtPW").focus();
        return;
    }
    if (sPW2.trim() == ""){
        document.getElementById("divFADE").style.opacity = "0.6";
	    document.getElementById("divFADE").style.display = "inline-block";
        document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "Veuillez confirmer le mot de passe.<br><br><button onclick='closeMSG();document.getElementById(\"inUSER\").focus();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide</button>";
        document.getElementById("txtPW2").style.boxShadow = "5px 10px 15px red";
		document.getElementById("txtPW2").focus();
        return;
    }
    if (sPW2.trim() != sPW.trim()){
        document.getElementById("divFADE").style.opacity = "0.6";
	    document.getElementById("divFADE").style.display = "inline-block";
        document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "Les mots de passe doivent être identiques.<br><br><button onclick='closeMSG();document.getElementById(\"inUSER\").focus();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide</button>";
        document.getElementById("txtPW2").style.boxShadow = "5px 10px 15px red";
		document.getElementById("txtPW2").focus();
        return;
    }

    document.getElementById("txtPW").style.boxShadow = "5px 10px 15px grey";
    document.getElementById("txtPW2").style.boxShadow = "5px 10px 15px grey";

		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
		  if (this.readyState == 4 && this.status == 200) {
			if (this.responseText=="") {
                document.getElementById("divFADE").style.opacity = "0.6";
	            document.getElementById("divFADE").style.display = "inline-block";
                document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = "Le mot de passe a été créé. Rendez-vous sur la page d'accueil pour vous connecter.<br><br><button onclick=\"closeMSG();window.open('https://<?php echo $_SERVER["SERVER_NAME"]; ?>', '_self');return false;\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
			} else {
                document.getElementById("divFADE").style.opacity = "0.6";
	            document.getElementById("divFADE").style.display = "inline-block";
                document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText;
			}
		  }
		};
		xmlhttp.open('GET', 'newPW.php?KEY=' + KEY + '&PW=' + encodeURIComponent(sPW), true);
		xmlhttp.send();

}
</script>
</body>
</html>
