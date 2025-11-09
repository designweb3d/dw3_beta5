<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php';  ?>
<!DOCTYPE html><html><head><meta charset="utf-8">
<title>Espace Client - <?php echo $CIE_NOM; ?></title>
	<script src="https://d3js.org/d3.v7.min.js"></script>	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<meta name="viewport" content="width=device-width, user-scalable=no" />
	<link rel="icon" type="image/png" href="/pub/img/favicon.png" />
	<meta name="application-name" content="<?php echo $CIE_NOM; ?>"/>
	<meta name="msapplication-TileColor" content="#FFFFFF" />
	<meta name="msapplication-TileImage" content="/pub/img/favicon.png" />
    <script src="https://js.stripe.com/v3/"></script>
<style> 
<?php include $_SERVER['DOCUMENT_ROOT'] . '/pub/css/main.css.php'; ?>
        .menu{
            cursor: pointer;
            text-align:right;
            font-size:17px;
        }
        .menu_container {        
            position:fixed;
            top:50px;
            right:0px;
            opacity:1;
            height: auto;
            width:110px;
            transition: 0.7s;
            border-radius:3px;
            overflow:hidden;
            background-color: #<?php echo $CIE_COLOR3; ?>;
            transform: translate(-20px,-275px) scale3d(0,0,0);
        }
        .menu_container button {
            background:#<?php echo $CIE_COLOR1; ?>;
            border:1px solid #<?php echo $CIE_COLOR2; ?>;
            border-radius:5px;
            color:#<?php echo $CIE_COLOR2; ?>;
            font-weight:bold;
            width:100px;
            padding:10px;
            filter: drop-shadow(1px 1px 1px #<?php echo $CIE_COLOR2; ?>);
            cursor: pointer;
        } 
        .menu_container button:hover {
            text-shadow: -2px 2px #000;
        } 
        .menu_bar1, .menu_bar2, .menu_bar3 {
            width: 45px;
            height: 6px;
            background-color: #<?php echo $CIE_COLOR2; ?>;
            margin: 6px 0;
            transition: 0.4s;
            border-radius:3px;
            filter: drop-shadow(1px 1px 1px #222);
        }
        .change .menu_bar1 {
            transform: translate(0, 24px);
            opacity: 0;
        }
        .change .menu_bar2 {
            opacity: 0;
            transform: translate(0, 12px);
        }
        .change .menu_bar3 {
            transform: translate(0, 6px);
            
        }
        .change2 {
            transform: initial;
        }
</style>
</head>
<body style="overflow-y:scroll;overflow-x:hidden;">
<div id='divFADE' onclick="closeMSG();"></div>
<div id='divFADE2'></div>
<div id='divMSG'></div>
<div id="divHEAD" style='left:0px;'>
	<table style="width:100%;margin:0px;white-space:nowrap;">
		<tr style="margin:0px;padding:0px;">
            <td style="width:40px;margin:0px;padding:0px;text-align: right; text-justify: inter-word;">
				<a href="https://<?php echo $_SERVER["SERVER_NAME"]; ?>"><button class="grey" style="margin:2px 0px 0px 0px;padding:7px;">
				<span class="material-icons">arrow_back</span><?php if ($USER_LANG == "FR"){ echo "Accueil"; }else{echo "Home";}?></button></a>
			 </td>
			<td width="*"><h4><img src="/pub/img/<?php echo $CIE_LOGO3."?t=" . rand(100,100000); ?>" style="height:32px;width:auto;max-width:100px;"> <?php if ($USER_LANG == "FR"){ echo "Espace-Client"; }else{echo "Customer Area";}?></h4></td>
			<td style="width:40px;margin:0px;padding:0px;text-align: right; text-justify: inter-word;">
				<button class="grey" style="margin:2px 0px 0px 0px;padding:7px;" onclick="logOUT_CTS();">
				    <span class="material-icons">logout</span><?php if ($USER_LANG == "FR"){ echo "Déconnexion"; }else{echo "Disconnect";}?>
                </button>
			 </td>
		</tr>
	</table>
</div>

<div class='divPAGE' id="divMainContent" style='margin-top:70px;max-width:500px;background:rgba(255,255,255,0.8);box-shadow:inset 0px 0px 5px 2px #555;'>
    <?php 
        if ($USER_LANG == "FR"){
            echo "<h3>Connexion à 2 facteurs</h3>Choisissez où envoyer le code pour la connexion à 2 facteurs."; 
        }else{
            echo "<h3>2 factors login</h3>Choose where to send the code for 2-factor login.";
        }?>
            <div class="divBOX"><input name='selector' type='radio' checked id='selEML' value='EML' style='margin:0px 5px;'> <label for='selEML' style='padding:10px;width:83%;border-radius:10px;border:1px solid grey;'>
                <?php if ($USER_LANG == "FR"){ echo " Courriel"; }else{echo " Email";}?>:
                <span style='text-align:center;font-weight:bold;'><?php echo $USER_EML1; ?></span></label>
            </div><br>
        <?php if ($USER_TEL1 != ""){ ?>
            <div class="divBOX"><input name='selector' type='radio' checked id='selTEL' value='TEL' style='margin:0px 5px;'> <label for='selTEL' style='padding:10px;width:83%;border-radius:10px;border:1px solid grey;'>
                <?php if ($USER_LANG == "FR"){ echo " Téléphone"; }else{echo " Phone";}?>:
                <span style='text-align:center;font-weight:bold;'><?php echo $USER_TEL1; ?></span></label>
            </div><br>
    <?php } ?>
    <button onclick="send2Factor();" id='btnSEND'><span class="material-icons">send</span><?php if ($USER_LANG == "FR"){ echo "Envoyer"; }else{echo "Send";}?></button>
</div>


<script src="/pub/js/multiavatar.min.js"></script>
<script>
var KEY = '<?php echo($_GET['KEY']??''); ?>';
var USER = '<?php echo($USER); ?>';
var USER_LANG = '<?php echo $USER_LANG??'FR'; ?>';

$(document).ready(function () {

});

function addMsg(text) { //rename to dw3_alert(text);
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = text ;
}

function closeMSG() { //rename to dw3_alert_close();
	document.getElementById("divFADE2").style.opacity = "0";
	document.getElementById("divFADE2").classList.remove('divFADE_IN');
    setTimeout(function () {
		document.getElementById("divFADE2").style.display = "none";

		}, 500);
	document.getElementById('divMSG').style.display = 'none';
}

function dw3_notif_add(text) { //rename to dw3_notif(text);
	//sNotifCount++;
    const newDiv = document.createElement("div");
    //const newContent = document.createTextNode(String());
    //const newContent2 = document.createTextNode(" X ");
    //newDiv.style.position = "fixed";
    //newDiv.style.right = "2px";
    //newDiv.style.top = (35*sNotifCount) + "px";
    newDiv.style.background = "#EEE";
    newDiv.style.borderRadius = "5px";
    newDiv.style.color = "darkgreen";
    newDiv.style.border = "1px dotted darkgreen";
    //newDiv.style.zIndex = "3000";
    newDiv.style.transition ="all 1s";
    newDiv.style.fontWeight ="bold";
    newDiv.style.width ="auto";
    newDiv.style.textShadow ="2px 2px #DDDDDD";
    newDiv.style.padding ="0px 5px 5px 5px";
    newDiv.style.margin ="5px";
    newDiv.style.cursor ="pointer";
    newDiv.style.display ="table";
    newDiv.style.float ="right";
    newDiv.style.whiteSpace ="nowrap";
    //newContent2.style.background = "white";
    //newContent2.style.color = "darkgreen";
    //newDiv.appendChild(newContent2);
    newDiv.innerHTML = "<span style='font-size:1.1em;margin-top:-3px;font-weight:normal;color:goldenrod;vertical-align:middle;'>&#x26A0;</span> <span style='vertical-align:middle;'>&nbsp; " + text + "&nbsp; </span> <sup><span class='material-icons' style='font-size:0.8em;font-weight:normal;color:#990000'>close</span></sup>";
    const currentDiv = document.getElementById("dw3_notif_container");
    //document.body.insertBefore(newDiv, currentDiv);
	currentDiv.appendChild(newDiv);
    newDiv.addEventListener("click", function(event) {
            newDiv.style.opacity = "0";
            setTimeout(function () {
                newDiv.style.display = "none";
            }, 1000);
    });
    setTimeout(function () {
		newDiv.style.opacity = "0";
	}, 5000);
    setTimeout(function () {
		newDiv.style.display = "none";
        newDiv.remove();
		//sNotifCount = sNotifCount-1;
	}, 6000);
}

//drag obj using first child 
function dw3_drag_init(elmnt) {
    var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
    document.getElementById(elmnt.id).firstChild.onmousedown = dragMouseDown;
    function dragMouseDown(e) {
      e = e || window.event;
      e.preventDefault();
      pos3 = e.clientX;
      pos4 = e.clientY;
      document.onmouseup = closeDragElement;
      document.onmousemove = elementDrag;
    }
    function elementDrag(e) {
      e = e || window.event;
      e.preventDefault();
      pos1 = pos3 - e.clientX;
      pos2 = pos4 - e.clientY;
      pos3 = e.clientX;
      pos4 = e.clientY;
      elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
      elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
    }
    function closeDragElement() {
      document.onmouseup = null;
      document.onmousemove = null;
    }
}
function send2Factor(){
    document.getElementById("btnSEND").disabled = true;
    document.getElementById("divFADE2").style.opacity = "0.6";
	document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divMSG").style.display = "inline-block";
    if (USER_LANG == "FR"){
	    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:70px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD."?t=" . rand(100,100000); ?>'>";
    }else{
	    document.getElementById("divMSG").innerHTML = "Please wait..<br><img style='width:70px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD."?t=" . rand(100,100000); ?>'>";
    }
    var sTYPE = document.querySelector('input[name="selector"]:checked').value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divMainContent").innerHTML = this.responseText;
        closeMSG();
        document.getElementById("txtCode").addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                validate2Factor();
            }
        });
	  }
	};
		xmlhttp.open('GET', 'send2Factor.php?KEY=' + KEY 
										+ '&TYPE=' + encodeURIComponent(sTYPE),
										true);
		xmlhttp.send();
}
function validate2Factor(){
    document.getElementById("btnSEND").disabled = true;
    document.getElementById("divFADE2").style.opacity = "0.6";
	document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divMSG").style.display = "inline-block";
    if (USER_LANG == "FR"){
	    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:70px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD."?t=" . rand(100,100000); ?>'>";
    }else{
	    document.getElementById("divMSG").innerHTML = "Please wait..<br><img style='width:70px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD."?t=" . rand(100,100000); ?>'>";
    }
    var sCODE = document.getElementById("txtCode").value.trim();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "invalid"){
            if (USER_LANG == "FR"){
                document.getElementById("divMSG").innerHTML = "Code invalide.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
            }else{
                document.getElementById("divMSG").innerHTML = "Invalid code.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
            }
            document.getElementById("btnSEND").disabled = false;
        } else if (this.responseText == "expired"){
            if (USER_LANG == "FR"){
                document.getElementById("divMSG").innerHTML = "Code expiré, rechargez la page pour recevoir un nouveau code.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";            }else{
                document.getElementById("divMSG").innerHTML = "Expired code, reload the page to receive a new code.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
            }
        } else {
            closeMSG();
            document.getElementById("txtCode").value = "";
            window.open(this.responseText,"_self");
        }
	  }
	};
		xmlhttp.open('GET', 'validate2Factor.php?KEY=' + KEY 
										+ '&CODE=' + encodeURIComponent(sCODE),
										true);
		xmlhttp.send();
}
function logOUT_CTS() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		//location.reload();
        window.open("https://<?php echo $_SERVER["SERVER_NAME"]; ?>","_self");
	  }
	};
		xmlhttp.open('GET', 'logout.php?KEY='+KEY, true);
		xmlhttp.send();
}
</script>
</body>
</html>
