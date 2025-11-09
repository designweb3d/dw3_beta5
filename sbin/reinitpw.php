<?php
header("X-Robots-Tag: noindex, nofollow", true);
$REDIR = "<html><head><title>Redirected</title><meta http-equiv=\"refresh\" content=\"0;URL='https://" . $_SERVER["SERVER_NAME"] . "'\"></head></html>";  
$REDIR_EXPIRE = "<html><head><title>Redirected</title><meta http-equiv=\"refresh\" content=\"3;URL='https://" . $_SERVER["SERVER_NAME"] . "/client'\"></head><body><h2>La clé pour réinitialiser votre mot de passe a expiré</h2><br><br>Veuillez faire une nouvelle requête à l'adresse suivante: <a href='https://" .$_SERVER["SERVER_NAME"] . "/client' target='_self'>" .$_SERVER["SERVER_NAME"] . "/client</a><hr><br>Redirection dans quelques secondes..</body></html>";  

    $KEY = trim(htmlspecialchars($_GET['KEY']??""));
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
            } else if ($row["code"] == "BG1")	{$CIE_BG1 = $row["text1"];
            } else if ($row["code"] == "BG2")	{$CIE_BG2 = $row["text1"];
            } else if ($row["code"] == "FONT1")	{$CIE_FONT1 = $row["text1"];
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
            } else if ($row["code"] == "LOGO3")	{$CIE_LOGO3 = $row["text1"];					
            } else if ($row["code"] == "TEL1")	{$CIE_TEL1 = $row["text1"];										
            } else if ($row["code"] == "PTPS")	{$CIE_PTPS = $row["text1"];			
            } else if ($row["code"] == "TPS")		{$CIE_TPS = $row["text1"];			
            } else if ($row["code"] == "PTVQ")	{$CIE_PTVQ = $row["text1"];			
            } else if ($row["code"] == "TVQ")		{$CIE_TVQ = $row["text1"];			
            } else if ($row["code"] == "NEQ")		{$CIE_NEQ = $row["text1"];			
            } else if ($row["code"] == "RBQ")		{$CIE_RBQ = $row["text1"];			
            } else if ($row["code"] == "FADE")		{$CIE_FADE = $row["text1"];	
            } else if ($row["code"] == "FRAME")	    {$CIE_FRAME = trim($row["text1"]);		
            } else if ($row["code"] == "LOAD")		{$CIE_LOAD = $row["text1"];			
            }

        }
    }
    require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/dw3_func.php';
    $sql = "SELECT * FROM user WHERE key_reset = '" . $KEY . "' AND key_expire > '" .date("Y-m-d H:i:s"). "' LIMIT 1";
    $sql2 = "SELECT * FROM customer WHERE key_reset = '" . $KEY . "' AND key_expire > '". date("Y-m-d H:i:s") ."' LIMIT 1";

    //check user first
	$result = $dw3_conn->query($sql);
	if ($result->num_rows == 0) {
        //if not a user maybe a customer
        $result2 = $dw3_conn->query($sql2);
        if ($result2->num_rows == 0) { //no user and no customer found exit         
            $dw3_conn->close();
            die($REDIR_EXPIRE);
        } else { //a customer was found
            while($row2 = $result2->fetch_assoc()) {
                $USER_EML = dw3_decrypt($row2["eml1"]) ;
                $USER_NAME = dw3_decrypt($row2["last_name"]);
                $USER_LANG = $row2["lang"];
                $USER_TYPE = "CLIENT";
            }
        }
    } else { //a user was found	
		while($row = $result->fetch_assoc()) {
            $USER_EML = $row["eml1"] ;
            $USER_NAME = $row["name"];
            $USER_LANG = $row["lang"];
            $USER_TYPE = "USER";
	    }
    }
if(isset($_COOKIE["LANG"])) {
    if ($_COOKIE["LANG"] != "") {
        $USER_LANG = $_COOKIE["LANG"];
    }
}

?>	
<!DOCTYPE html>
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
<?php include $_SERVER['DOCUMENT_ROOT'] . '/pub/css/main.css.php'; ?>
#message {
  background: #f1f1f1;
  color: #000;
  position: relative;
  padding: 5px;
  margin: 0px 10px;
  text-align:left;
  line-height:1.15em;
}

#message div {
  padding: 1px 5px;
  font-size: 12px;
}

/* Add a green text color and a checkmark when the requirements are right */
.valid {
  color: green;
}

.valid:before {
  position: relative;
  left: -5px;
  content: "☑";
}

/* Add a red text color and an "x" icon when the requirements are wrong */
.invalid {
  color: red;
}

.invalid:before {
  position: relative;
  left: -5px;
  content: "⍚";
}
td.active {
  background: rgba(255,255,255,0);
}
#imgAVATAR{
    position:fixed;
    top:50px;
    left:10px;
    width:150px;
}
</style></head><body style='text-align:center;'>
<div id="divHEAD" style='left:0px;border-radius:0px;height:40px;'>
	<table width="100%"><tr>
		<td onclick="window.open('https://<?php echo $_SERVER["SERVER_NAME"]; ?>','_self');" style="text-align:center;vertical-align:middle;cursor:pointer;">
            <img src="/pub/img/<?php echo $CIE_LOGO3; ?>" style="vertical-align:middle;height:32px;width:auto;">
        </td>
		<td width="30" onclick='openLANG();' style="vertical-align:middle;text-align:center;cursor:pointer;background-color:#eee;color:#333;border-radius:10px;"> 
            <span id="dw3_lang_span" class="material-icons" style="cursor:pointer;font-size:24px;">translate</span>
        </td>
	</tr></table>
</div>
<div id="imgAVATAR" style="<?php if($USER_TYPE == "CLIENT"){echo "display:none;";} ?>"></div>
<div class='divMAIN' style='background:rgba(0,0,0,0.6);color:#fff;box-shadow:3px 3px 6px 2px #333;width:auto;padding:10px 0px;position:fixed;top: 40%;left: 50%;-moz-transform: translateX(-50%) translateY(-50%);-webkit-transform: translateX(-50%) translateY(-50%);transform: translateX(-50%) translateY(-50%);min-width:350px;border-style: double;border:1px solid #777;border-radius:20px;'>  
    <?php echo $USER_EML; ?>
    <br>
    <div class='divBOX' style='font-size:0.8em;max-width:400px;'>
    <b><?php if($USER_LANG == "FR"){ echo "Bonjour"; }else{echo "Hi";} ?><?php echo " ".$USER_NAME; ?>,</b><br>
        <span style='font-size:14px;'><?php if($USER_LANG == "FR"){ echo "Veuillez entrer et confirmer votre nouveau mot de passe:"; }else{echo "Please enter and confirm your new password:";} ?></span><br>
        <table style='width:100%'><tr><td style='width:260px;'>
            <input type='password' id='txtPW' style='width:250px;text-align:center;padding:7px;vertical-align:middle;margin:5px;' value=""><br>
            <input type='password' id='txtPW2' style='width:250px;text-align:center;padding:7px;vertical-align:middle;margin:5px;' value="">
        </td>
        <td style='vertical-align:middle;text-align:left;'>< <span  onclick="showPW();" class='material-icons' id='span_pw' style='box-shadow:0px 0px 4px 2px #777;font-size:36px;cursor:pointer;border-radius:4px;'>visibility_off</span></td>
        </tr></table>
        <button id='btnReset' disabled onclick='resetPW();' style='float:right;padding:10px;border-radois:4px;'><span class='material-icons' style='cursor:pointer;font-size:22px;vertical-align:middle;'>explore</span> <?php if($USER_LANG == "FR"){ echo "Modifier" ;}else{echo "Modify";} ?></button>
	</div><br>
    <div id="message" style='background-color:rgba(255,255,255,0.9);color:#222;font-size:13px;display:block;margin:10px 5px;max-width:600px;display:inline-block;border-radius:10px;'>
            <?php if($USER_LANG == "FR"){ echo "Le mot de passe doit contenir les éléments suivants:" ;}else{echo "The password must contain the following elements:";} ?>
            <br>
            <div id="letter" class="invalid" style='display:inline-block;font-size:18px;'><span style='font-size:12px;'><b><?php if($USER_LANG == "FR"){ echo "Minuscule"; }else{echo "Lowercase";} ?></b></span></div> 
            <div id="capital" class="invalid" style='display:inline-block;font-size:18px;'><span style='font-size:12px;'><b><?php if($USER_LANG == "FR"){ echo "Majuscule"; }else{echo "Uppercase";} ?></b></div> 
            <div id="number" class="invalid" style='display:inline-block;font-size:18px;'><span style='font-size:12px;'><b><?php if($USER_LANG == "FR"){ echo "Nombre" ;}else{echo "Number";} ?></b></div> 
            <div id="length" class="invalid" style='display:inline-block;font-size:18px;'><span style='font-size:12px;'><b><?php if($USER_LANG == "FR"){ echo "8 caractères"; }else{echo "8 characters";} ?></b></div> 
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
var USER_TYPE = '<?php echo $USER_TYPE; ?>';
var USER_NAME = '<?php echo $USER_NAME; ?>';
if (USER_NAME !=""){
    changeAVATAR(USER_NAME);
} else {
    document.getElementById("imgAVATAR").innerHTML = "<img src='/pub/img/<?php echo $CIE_BG1;?>' style='height:100%;'>";
}

var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");
var button_before_color = document.getElementById("btnReset").style.color;

$(document).ready(function (){
      document.getElementById("txtPW").focus();
});


var dw3_login_listen = document.getElementById("txtPW");
dw3_login_listen.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
    event.preventDefault();
	resetPW();
  } else {
    checkPW();
  }
});
var dw3_login_listen2 = document.getElementById("txtPW2");
dw3_login_listen2.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
    event.preventDefault();
	resetPW();
  } else {
    checkPW();
  }
});

function showPW() {  //rename to dw3_pw_show(event,that);
  	var that = document.getElementById("txtPW");
  	var that2 = document.getElementById("txtPW2");
  	var thut = document.getElementById("span_pw");
	  if (that.type === "password") {
        that.type ="text";
        that2.type ="text";
        thut.innerHTML ="visibility";
	  } else {
		that.type = "password";
		that2.type = "password";
        thut.innerHTML ="visibility_off";
	  }
}

function dw3_lang_set(language) {
    document.getElementById("divMSG").style.display = "none";
    document.getElementById("divFADE").innerHTML = "<img style='position:fixed;top: 40%;left: 50%;-moz-transform: translateX(-50%) translateY(-50%);-webkit-transform: translateX(-50%) translateY(-50%);transform: translateX(-50%) translateY(-50%);width:100px;height:auto;border-radius:10px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open('GET', '/pub/page/set_lang.php?LANG=' + language , true);
	xmlhttp.send();
    var myDate = new Date();
    myDate.setMonth(myDate.getMonth() + 12);
    document.cookie = "LANG="+language+";expires=" + myDate +";path=/;domain=.<?php echo $_SERVER['SERVER_NAME']; ?>;";
    if (document.getElementById('dw3_lang_span')) {
        document.getElementById('dw3_lang_span').innerHTML = "<img src='/pub/img/load/<?php echo $CIE_LOAD; ?>' style='border-radius:5px;width:24px;height:24px;margin-top:-6px;'>";
    }
    setTimeout(() => {
        closeMSG();
        location.reload();
        return false;
    }, "1500");

}

function checkPW() {
    var bVALID = true;
    var lowerCaseLetters = /[a-z]/g;
    if(dw3_login_listen.value.match(lowerCaseLetters)) {
        letter.classList.remove("invalid");
        letter.classList.add("valid");
    } else {
        letter.classList.remove("valid");
        letter.classList.add("invalid");
        bVALID = false;
    }

    // Validate capital letters
    var upperCaseLetters = /[A-Z]/g;
    if(dw3_login_listen.value.match(upperCaseLetters)) {
        capital.classList.remove("invalid");
        capital.classList.add("valid");
    } else {
        capital.classList.remove("valid");
        capital.classList.add("invalid");
        bVALID = false;
    }

    // Validate numbers
    var numbers = /[0-9]/g;
    if(dw3_login_listen.value.match(numbers)) {
        number.classList.remove("invalid");
        number.classList.add("valid");
    } else {
        number.classList.remove("valid");
        number.classList.add("invalid");
        bVALID = false;
    }

    // Validate length
    if(dw3_login_listen.value.length >= 8) {
        length.classList.remove("invalid");
        length.classList.add("valid");
    } else {
        length.classList.remove("valid");
        length.classList.add("invalid");
        bVALID = false;
    }

    // Validate confirmation
   // if(dw3_login_listen.value == dw3_login_listen2.value) {
        //length.classList.remove("invalid");
        //length.classList.add("valid");
    //} else {
        //length.classList.remove("valid");
        //length.classList.add("invalid");
       // bVALID = false;
    //}

    if (bVALID == true){
        document.getElementById("btnReset").disabled = false;
        document.getElementById("btnReset").style.color = button_before_color;
    } else {
        document.getElementById("btnReset").disabled = true;
        //document.getElementById("btnReset").style.color = "darkred";
    }
}

function openLANG() {
    //document.getElementById("divFADE").innerHTML = "<img style='width:100px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
    document.getElementById("divFADE").style.display = "inline-block";
    document.getElementById("divFADE").style.opacity = "0.5";
    document.getElementById("divMSG").style.display = "inline-block";
    if (LANG == "FR"){
        document.getElementById("divMSG").innerHTML = "Veuillez choisir votre langue:<br><button onclick=\"dw3_lang_set('FR');\"><img src=\"https://dataia.ca/img/flags/84.png\"' style='height:32px;width:auto;'> Français</button> <button onclick=\"dw3_lang_set('EN');\"><img src=\"https://dataia.ca/img/flags/86.png\"' style='height:32px;width:auto;'> English</button>";
    }else{
        document.getElementById("divMSG").innerHTML = "Please choose your language:<br><button onclick=\"dw3_lang_set('FR');\"><img src=\"https://dataia.ca/img/flags/84.png\"' style='height:32px;width:auto;'> Français</button> <button onclick=\"dw3_lang_set('EN');\"><img src=\"https://dataia.ca/img/flags/86.png\"' style='height:32px;width:auto;'> English</button>";
    }
}

function changeAVATAR(avatarId){
	var svgCode = multiavatar(avatarId);
	document.getElementById("imgAVATAR").innerHTML=svgCode;
}
function closeMSG() {
	document.getElementById('divFADE').style.display = 'none';
	document.getElementById('divMSG').style.display = 'none';

}
function resetPW() {
	var sPW = document.getElementById("txtPW").value;
	var sPW2 = document.getElementById("txtPW2").value;
    if (sPW.trim() == ""){
        document.getElementById("divFADE").style.opacity = "0.6";
	    document.getElementById("divFADE").style.display = "inline-block";
        document.getElementById("divMSG").style.display = "inline-block";
        if (LANG == "FR"){
		    document.getElementById("divMSG").innerHTML = "Veuillez entrer un mot de passe.<br><br><button onclick='closeMSG();document.getElementById(\"inUSER\").focus();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide</button>";
        } else {
		    document.getElementById("divMSG").innerHTML = "Please enter a password.<br><br><button onclick='closeMSG();document.getElementById(\"inUSER\").focus();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide</button>";
        }
        document.getElementById("txtPW").style.boxShadow = "5px 10px 15px red";
		document.getElementById("txtPW").focus();
        return;
    }
    if (sPW.trim().lenght <= 7){
        document.getElementById("divFADE").style.opacity = "0.6";
	    document.getElementById("divFADE").style.display = "inline-block";
        document.getElementById("divMSG").style.display = "inline-block";
        if (LANG == "FR"){
		    document.getElementById("divMSG").innerHTML = "Le mot de passe est trop court. Minimum 8 caractères.<br><br><button onclick='closeMSG();document.getElementById(\"inUSER\").focus();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide</button>";
        } else {
		    document.getElementById("divMSG").innerHTML = "The password is too short. Minimum 8 caractères.<br><br><button onclick='closeMSG();document.getElementById(\"inUSER\").focus();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide</button>";
        }
        document.getElementById("txtPW").style.boxShadow = "5px 10px 15px red";
		document.getElementById("txtPW").focus();
        return;
    }
    if (sPW2.trim() == ""){
        document.getElementById("divFADE").style.opacity = "0.6";
	    document.getElementById("divFADE").style.display = "inline-block";
        document.getElementById("divMSG").style.display = "inline-block";
        if (LANG == "FR"){
    		document.getElementById("divMSG").innerHTML = "Veuillez confirmer le mot de passe.<br><br><button onclick=\"closeMSG();document.getElementById('txtPW2').focus();\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide</button>";
        } else{
    		document.getElementById("divMSG").innerHTML = "Please confirm the password.<br><br><button onclick=\"closeMSG();document.getElementById('txtPW2').focus();\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide</button>";
        }
        document.getElementById("txtPW2").style.boxShadow = "5px 10px 15px red";
        return;
    }
    if (sPW2.trim() != sPW.trim()){
        document.getElementById("divFADE").style.opacity = "0.6";
	    document.getElementById("divFADE").style.display = "inline-block";
        document.getElementById("divMSG").style.display = "inline-block";
        if (LANG == "FR"){
		    document.getElementById("divMSG").innerHTML = "Les mots de passe doivent être identiques.<br><br><button onclick=\"closeMSG();document.getElementById('txtPW2').focus();\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide</button>";
        } else {
		    document.getElementById("divMSG").innerHTML = "Passwords must be the same.<br><br><button onclick=\"closeMSG();document.getElementById('txtPW2').focus();\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide</button>";
        }
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
                if (LANG == "FR"){
				    document.getElementById("divMSG").innerHTML = "Le mot de passe a été modifié!<br>Vous serez redirigé vers la page de connexion.<br><br><button onclick=\"closeMSG();window.open('/client','_self');return false;\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                } else {
				    document.getElementById("divMSG").innerHTML = "The password has been changed!<br>You will be redirected to the login page.<br><br><button onclick=\"closeMSG();window.open('/client','_self');return false;\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                }
			} else {
                document.getElementById("divFADE").style.opacity = "0.6";
	            document.getElementById("divFADE").style.display = "inline-block";
                document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText;
			}
		  }
		};
		xmlhttp.open('GET', 'updPW.php?KEY=' + KEY + '&PW=' + encodeURIComponent(sPW) + "&TYPE=" + USER_TYPE, true);
		xmlhttp.send();

}
</script>
</body>
</html>
