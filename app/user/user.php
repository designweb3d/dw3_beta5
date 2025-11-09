<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/menu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/common_header.php';
?>

<div id='divHEAD'>
<table style="width:100%;margin:0px;white-space:nowrap;"><tr style="margin:0px;padding:0px;"><td width="*" style="margin:0px;padding:0px;">
        <input type="search" onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" id="inputSEARCH" onkeyup="filterTable()" placeholder="<?php echo $APNAME; ?>.." title="Entrez votre recherche">
	  </td><td style="width:0;min-width:fit-content;margin:0px;padding:0px 0px 0px 5px;text-align:right;">
		<?php if($APREAD_ONLY == false) { ?><button class='blue' style="margin:0px 2px 0px 2px;padding:8px;"  onclick="openNEW();"><span class="material-icons">add</span></button> <?php } ?>
		<button class='grey' style="margin:0px 2px 0px 2px;padding:8px;" onclick="openPARAM();"><span class="material-icons">settings</span></button>
	  </td></tr></table>
</div>

<div id='divMAIN' class='divMAIN' style='margin-top:46px;'></div>
<div id="divEDIT" class="divEDITOR"></div>

<div id="divNEW" class="divEDITOR">
    <div id='divNEW_HEADER' class='dw3_form_head'>
        <h3><?php echo $dw3_lbl["NEW_USR"];?></h3>
		<button class='grey' style='top:0px;right:0px;padding:4px;position:absolute;' onclick='closeEDITOR(this);'><span class='material-icons'>close</span></button>
    </div>
    <div style='position:absolute;top:40px;left:0px;bottom:50px;overflow-x:hidden;overflow-y:auto;'>
        <div id='imgAVATAR2' style='width:50%;display: inline-block;'></div><br>
        <div class="divBOX"><br><?php echo $dw3_lbl["USER"]; ?>:
            <input id="newUSER" type="text" value="" oninput='dw3_avatar_change(this.value,"imgAVATAR2");' onclick="detectCLICK(event,this);">
        </div><br>
        <div class="divBOX"><br><?php echo $dw3_lbl["PREFIX"]; ?>:
            <input id="newPREFIX" type="text" value="" onclick="detectCLICK(event,this);">
        </div>	
        <div class="divBOX"><br><?php echo $dw3_lbl["PRENOM"]; ?>:
            <input id="newPRENOM" type="text" value="" onclick="detectCLICK(event,this);">
        </div>	
        <div class="divBOX"><br><?php echo $dw3_lbl["PRENOM2"]; ?>:
            <input id="newPRENOM2" type="text" value="" onclick="detectCLICK(event,this);">
        </div>	
        <div class="divBOX"><br><?php echo $dw3_lbl["NOM"]; ?>:
            <input id="newNOM" type="text" value="" onclick="detectCLICK(event,this);">
        </div>
        <div class="divBOX"><br><?php echo $dw3_lbl["SUFFIX"]; ?>:
            <input id="newSUFFIX" type="text" value="" onclick="detectCLICK(event,this);">
        </div>	
        <div class="divBOX"><br><?php echo $dw3_lbl["EML1"]; ?>:
            <input id="newEML1" type="text" value="" onclick="detectCLICK(event,this);">
        </div>
        <div class="divBOX"><br><?php echo $dw3_lbl["LANG"]; ?>:
            <select name="newLANG" id="newLANG">
                <option selected value="FR"><?php echo $dw3_lbl["FR"]; ?></option>
                <option value="EN"><?php echo $dw3_lbl["EN"]; ?></option>
            </select>
        </div>
        <div class="divBOX"><br><?php echo $dw3_lbl["SEXE"]; ?>:
            <select name="newSEXE" id="newSEXE">
                <option selected value=""><?php echo $dw3_lbl["UNDEFINED"]; ?></option>
                <option value="ML"><?php echo $dw3_lbl["MALE"]; ?></option>
                <option value="FM"><?php echo $dw3_lbl["FEMALE"]; ?></option>
            </select>
        </div>
        <div class="divBOX"><br><?php echo $dw3_lbl["LOC"]; ?>:
                <select name="newLOC" id="newLOC">
                    <?php
                    $sql = "SELECT * FROM location WHERE stat=0 ORDER BY name";

                    $result = $dw3_conn->query($sql);
                    if ($result->num_rows > 0) {	
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='". $row["id"] . "'>"	. $row["name"] . "</option>";
                        }
                    }
                    ?>
                </select>
        </div>
        <div class="divBOX"><br>Position:
                <select name="newPOS" id="newPOS">
                    <?php
                    $sql = "SELECT * FROM position ORDER BY name";

                    $result = $dw3_conn->query($sql);
                    if ($result->num_rows > 0) {	
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='". $row["id"] . "'>"	. $row["name"] . "</option>";
                        }
                    }
                    ?>
                </select>
        </div>
        <div class="divBOX"><br><?php echo $dw3_lbl["AUTH"]; ?>:
            <select name="newAUTH" id="newAUTH">
                <option <?php if ($USER_AUTH != "GES") {echo " disabled ";} ?> value="GES"><?php echo $dw3_lbl["GES"]; ?></option>
                <option <?php if ($USER_AUTH != "GES" || $USER_AUTH != "ADM") {echo " disabled ";} ?>value="ADM"><?php echo $dw3_lbl["ADM"]; ?></option>
                <option value="USR"><?php echo $dw3_lbl["USR"]; ?></option>
                <option value="AUD">Auditeur</option>
                <option value="MIA">Master IA</option>
                <option value="BOT">Robot</option>
                <option value="VST">Visiteur</option>
            </select>
        </div>
        <div class="divBOX">
            <span style='float:left;margin:15px 0px 0px 10px;'><input name='newINIT_PW' id='newINIT_PW' type='checkbox'></span> <label for='newINIT_PW' style='float:right;display:inline-block;max-width:85%;'>Envoyer un courriel pour initialiser le mot de passe</label>
        </div>
    </div>
    <div id='divNEW_FOOT' style='padding:3px;background:rgba(200, 200, 200, 0.7);'>
        <button class='grey' onclick="closeEDITOR();"><span class="material-icons">cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button>
        <button class='green' onclick="newUSER();"><span class="material-icons">save</span><?php echo $dw3_lbl["CREATE"]; ?></button>
	</div>
</div>

<div id="divMSG"></div>
<div id="divOPT"></div>

<div id="divPARAM"  class="divEDITOR" style="background: rgba(0, 0, 0, 0.7);color:white;overflow-y:auto;">
    <div id='divPARAM_HEADER' class='dw3_form_head'>
        <h2 style='background: rgba(44, 44, 44, 0.9);'>Paramètres de l'application</h2>
        <button class='dw3_form_close' onclick='closeEDITOR(this);'><span class='material-icons'>cancel</span></button>
    </div>
    <div class='dw3_form_data' id="divPARAM_DATA"></div>
    <div class='EDIT_FOOT' style='text-align:right;padding:3px;background-image: linear-gradient(to right, rgba(0,0,0,0), rgba(44,44,44,1));'>
        <button class='grey' onclick='resetPRM()' style='margin:0px 2px 0px 2px;'><span class='material-icons'>restart_alt</span> Réinitialiser</button>
        <button class='grey' onclick='closeEDITOR()' style='margin:0px 2px 0px 2px;'><span class='material-icons'>cancel</span> Annuler</button>
        <button class='green' onclick='updPRM();' style='margin:0px 10px 0px 2px;'><span class='material-icons'>save</span> Enregistrer</button>
    </div>
</div>

<script type="text/javascript" src="/pub/js/main.js.php?t=<?php echo(rand(100,100000)); echo "&KEY=" . $KEY."&INACTIVE=".$USER_INACTIVE; ?>"></script>
<script src="/pub/js/multiavatar.min.js"></script>
<script>
var KEY = '<?php echo($_GET['KEY']); ?>';
var active_input;
$(document).ready(function ()
    {
		getUSERS();
        let input_nom = document.getElementById('newNOM');
        let input_prenom = document.getElementById('newPRENOM');
        input_nom.addEventListener("input", genUSER_NAME);
        input_prenom.addEventListener("input", genUSER_NAME);
        dw3_avatar_change("","imgAVATAR2");
        dragElement(document.getElementById('divNEW'));
        dragElement(document.getElementById('divPARAM'));
	});

    
//fonction ajouter un caractere special au input/textarea actif
function addChar(char){
	if (active_input!=""){
		var textarea = document.getElementById(active_input);
		var start = textarea.selectionStart;
    	var finish = textarea.selectionEnd;
    	//var sel = textarea.value.substring(start, finish);
		textarea.value = textarea.value.substring(0, start) + char.replace(/<br\s*[\/]?>/gi, "\n") + textarea.value.substring(finish,textarea.value.length);
		textarea.focus();
		//alert(textarea.value);
		if (char == "<br>"){
			textarea.selectionStart = start + 1;
		}else{
			textarea.selectionStart = start + char.toString().length;
		}
		textarea.selectionEnd = textarea.selectionStart;
	}
}

function genUSER_NAME() {
    let name = dw3_capitalize(document.getElementById('newPRENOM').value.trim().toLowerCase()) + document.getElementById('newNOM').value.trim().toLowerCase();
    document.getElementById('newUSER').value = name;
    dw3_avatar_change(name,"imgAVATAR2");
}


function delUSER(userID) {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "0.6";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><br><br><button onclick='closeMSG();' style='background:#555;'><span class='material-icons'>cancel</span> Annuler</button> <button onclick='delUSER2(" + userID + ");' style='background:red;'><span class='material-icons' style='vertical-align:middle;'>delete</span> Delete</button>";
}
function delUSER2(userID) {
	closeMSG();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
                addNotif("<?php echo $dw3_lbl["DEL_OK"]; ?>");
				getUSERS();
                closeEDITOR();
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'delUSER.php?KEY=' + KEY + '&usID=' + userID , true);
		xmlhttp.send();
		
}
function delUSAP(sUSID,sAPID,sUAID){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == "0"){
				closeMSG();
				getUSAP(sUSID);
				getUSAP_REV(sUSID);
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'delUSAP.php?KEY=' + KEY + '&'
										+ 'usID=' + sUSID + '&apID=' + sAPID+ '&uaID=' + sUAID,    
										true);
		xmlhttp.send();
}
function changeUSAPAuth(userID, appID, isChecked){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){
				closeMSG();
                addNotif("<?php echo $dw3_lbl["MODIFIED"]; ?>");
				//getUSAP(userID);
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'changeUSAPAuth.php?KEY=' + KEY + '&'
										+ 'usID=' + userID + '&appID=' + appID + '&isChecked=' + isChecked,    
										true);
		xmlhttp.send();
}

function reinitPW_USR(sID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 addNotif("Un courriel sera envoyé pour réinitialiser le mot de passe.");
	  }
	};
		xmlhttp.open('GET', 'reinitPW_USR.php?KEY=' + KEY + '&USID=' + sID, true);
		xmlhttp.send();	
}
function openPARAM() {
	//var GRPBOX  = document.getElementById("rtID");
	//var srtID  = GRPBOX.options[GRPBOX.selectedIndex].value;
	document.getElementById('divPARAM').style.display = "inline-block";
	document.getElementById("divFADE").style.display = "inline-block";
	document.getElementById("divFADE").style.opacity = "0.6";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
			 document.getElementById('divPARAM_DATA').innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getPARAM.php?KEY=' + KEY, true);
		xmlhttp.send();
}

function addUSAP(sUSID,sAPID){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == "0"){
				closeMSG();
				getUSAP(sUSID);
				getUSAP_REV(sUSID);
		  } else {
				document.getElementById("divFADE2").style.display = "inline-block";
				document.getElementById("divFADE2").style.opacity = "0.6";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'addUSAP.php?KEY=' + KEY + '&'
										+ 'usID=' + sUSID + '&apID=' + sAPID,    
										true);
		xmlhttp.send();
}
function getUSAP(sID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divUSAP").innerHTML = this.responseText;
		
	  }
	};
		xmlhttp.open('GET', 'getUSAP.php?KEY=' + KEY + '&usID=' + sID, true);
		xmlhttp.send();	
}
function getUSAP_REV(sID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divUSAP_REV").innerHTML = this.responseText;
		
	  }
	};
		xmlhttp.open('GET', 'getUSAP_REV.php?KEY=' + KEY + '&usID=' + sID, true);
		xmlhttp.send();	
}
function getUSER(userID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0, 3) == "Err"){
            document.getElementById("divFADE2").style.display = "inline-block";
            document.getElementById("divFADE2").style.opacity = "0.6";
            document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
        } else {
         document.getElementById("divFADE").style.display = "inline-block";
         document.getElementById("divFADE").style.opacity = "0.6";
		 document.getElementById("divEDIT").innerHTML = this.responseText;
		 document.getElementById("divEDIT").style.display = "inline-block";
         dragElement(document.getElementById('divEDIT'));
        }
	  }
	};
		//document.getElementById("divFADE").style.width = "100%";
		xmlhttp.open('GET', 'getUSER.php?KEY=' + KEY + '&usID=' + userID , true);
		xmlhttp.send();
		
}
function getUSERS() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divMAIN").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getUSERS.php?KEY=' + KEY  , true);
		xmlhttp.send();
		
}

function clearNEW(){
	document.getElementById("newUSER").value = "";
	document.getElementById("newEML1").value = "";
	document.getElementById("newPREFIX").value = "";
	document.getElementById("newPRENOM").value = "";
	document.getElementById("newPRENOM2").value = "";
	document.getElementById("newNOM").value = "";
	document.getElementById("newSUFFIX").value = "";
}
function newUSER(){

	var GRPBOX  = document.getElementById("newLANG");
	var sLANG  = GRPBOX.options[GRPBOX.selectedIndex].value;
	
	var GRPBOX  = document.getElementById("newSEXE");
	var sSEXE  = GRPBOX.options[GRPBOX.selectedIndex].value;
	
	var GRPBOX  = document.getElementById("newAUTH");
	var sAUTH  = GRPBOX.options[GRPBOX.selectedIndex].value;
	
	var GRPBOX  = document.getElementById("newLOC");
	var sLOC = GRPBOX.options[GRPBOX.selectedIndex].value;
	
	var GRPBOX  = document.getElementById("newPOS");
	var sPOS = GRPBOX.options[GRPBOX.selectedIndex].value;
	
	var sINIT_PW  = document.getElementById("newINIT_PW").checked;
	var sUSER  = document.getElementById("newUSER").value;
	var sEML1  = document.getElementById("newEML1").value;
	var sPREFIX  = document.getElementById("newPREFIX").value;
	var sPRENOM  = document.getElementById("newPRENOM").value;
	var sPRENOM2  = document.getElementById("newPRENOM2").value;
	var sNOM  = document.getElementById("newNOM").value;
	var sSUFFIX  = document.getElementById("newSUFFIX").value;
	
	if (sPRENOM == ""){
		document.getElementById("newPRENOM").style.borderColor = "red";
		document.getElementById("newPRENOM").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("newPRENOM").style.borderColor = "lightgrey";
		//document.getElementById("lblPRD").innerHTML = "";
	}	
	if (sNOM == ""){
		document.getElementById("newNOM").style.borderColor = "red";
		document.getElementById("newNOM").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("newNOM").style.borderColor = "lightgrey";
		//document.getElementById("lblPRD").innerHTML = "";
	}	
	if (sEML1 == ""){
		document.getElementById("newEML1").style.borderColor = "red";
		document.getElementById("newEML1").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("newEML1").style.borderColor = "lightgrey";
		//document.getElementById("lblPRD").innerHTML = "";
	}

    document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;border-radius:7px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){	
    		  if (this.responseText.substr(0, 3) != "Eml"){	
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["CREATED"]; ?><br><br><button onclick='closeMSG();closeEDITOR();'><span class='material-icons' style='vertical-align:middle;'>done</span>Terminer</button><button onclick='closeMSG();clearNEW();'><span class='material-icons' style='vertical-align:middle;'>done</span>Créer un autre</button><button onclick='closeMSG();closeEDITOR();getUSER(\"" + this.responseText.trim() + "\")'><span class='material-icons' style='vertical-align:middle;'>edit</span><?php echo $dw3_lbl["MODIFY"]; ?></button>";
				getUSERS();
              }else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["CREATED"]; ?> Un courriel a été envoyé à " + sEML1 + " pour créer son mot de passe.<br><br><button onclick='closeMSG();closeEDITOR();'><span class='material-icons' style='vertical-align:middle;'>done</span>Terminer</button><button onclick='closeMSG();closeEDITOR();openNEW();'><span class='material-icons' style='vertical-align:middle;'>done</span>Continuer</button><button onclick='closeMSG();closeEDITOR();getUSER(\"" + this.responseText.trim() + "\")'><span class='material-icons' style='vertical-align:middle;'>edit</span><?php echo $dw3_lbl["MODIFY"]; ?></button>";
				getUSERS();           
              }
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'newUSER.php?KEY=' + KEY + '&'
										+ 'I=' + encodeURIComponent(sINIT_PW)  
										+ '&EML1=' + encodeURIComponent(sEML1)  
										+ '&PREFIX=' + encodeURIComponent(sPREFIX)   
										+ '&PRENOM=' + encodeURIComponent(sPRENOM)   
										+ '&PRENOM2=' + encodeURIComponent(sPRENOM2)   
										+ '&NOM=' + encodeURIComponent(sNOM)   
										+ '&SUFFIX=' + encodeURIComponent(sSUFFIX)   
										+ '&LANG=' + sLANG   
										+ '&USER=' + encodeURIComponent(sUSER)   
										+ '&LOC=' + sLOC   
										+ '&POS=' + sPOS   
										+ '&SEXE=' + sSEXE   
										+ '&AUTH=' + sAUTH  ,    
										true);
		xmlhttp.send();
		document.getElementById("divFADE").style.display = "inline-block";
		document.getElementById("divFADE").style.opacity = "0.6";
}

function updUSER_SERVICE(that,user_id,product_id){
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        //addnotif
	  }
	};
    if (that.checked == true){
		xmlhttp.open('GET', 'addUSER_SERVICE.php?KEY=' + KEY + '&USER=' + encodeURIComponent(user_id) + '&PRD=' + encodeURIComponent(product_id), true);
		xmlhttp.send();
    } else{
		xmlhttp.open('GET', 'delUSER_SERVICE.php?KEY=' + KEY + '&USER=' + encodeURIComponent(user_id) + '&PRD=' + encodeURIComponent(product_id), true);
		xmlhttp.send();
    }
}

function updUSER(){
	var sID  = document.getElementById("usID").value;
	var sUNAME  = document.getElementById("usNAME").value;
	if (document.getElementById("usSTAT").checked == true){
		var sSTAT = 0;
	} else {
		var sSTAT = 1; 
	}
	var GRPBOX  = document.getElementById("usLANG");
	var sLANG  = GRPBOX.options[GRPBOX.selectedIndex].value;
	
	var GRPBOX  = document.getElementById("usLOC");
	var sLOC  = GRPBOX.options[GRPBOX.selectedIndex].value;
	
	var GRPBOX  = document.getElementById("usPOS");
	var sPOS = GRPBOX.options[GRPBOX.selectedIndex].value;
	
	var GRPBOX  = document.getElementById("usAPLC");
	var sAPLC  = GRPBOX.options[GRPBOX.selectedIndex].value;
	
	var GRPBOX  = document.getElementById("usAUTH");
	var sAUTH  = GRPBOX.options[GRPBOX.selectedIndex].value;

	var GRPBOX  = document.getElementById("usTZ");
	var sTZ  = GRPBOX.options[GRPBOX.selectedIndex].value;

	
	var sPRENOM  = document.getElementById("usPRENOM").value;
	var sPRENOM2  = document.getElementById("usPRENOM2").value;
	var sNOM  = document.getElementById("usNOM").value;
	var sPREFIX  = document.getElementById("usPREFIX").value;
	var sSUFFIX  = document.getElementById("usSUFFIX").value;
	var sEML1  = document.getElementById("usEML1").value;
	var sEML2  = document.getElementById("usEML2").value;
	var sEML3  = document.getElementById("usEML3").value;
	var sADR1   = document.getElementById("usADR1").value;
	var sADR2   = document.getElementById("usADR2").value;
	var sTEL1   = document.getElementById("usTEL1").value;
	var sTEL2   = document.getElementById("usTEL2").value;
	var sVILLE  = document.getElementById("usVILLE").value;
	var GRPBOX  = document.getElementById("usPROV");
	var sPROV  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var sPAYS   = document.getElementById("usPAYS").value;
	var sCP     = document.getElementById("usCP").value;
	var sMSG_RDV     = document.getElementById("usMSG_RDV").value;
	var sINACTIVE    = document.getElementById("usINACTIVE").value;
	var sSALARY    = document.getElementById("usSALARY").value;
	//var sSTAT   = document.getElementById("usSTAT").value;
    if (document.getElementById("usSMS_RDV").checked == false){var sSMS_RDV = 0; } else {var sSMS_RDV = 1; }
    
	if (sUNAME == ""){
		document.getElementById("usNAME").style.borderColor = "red";
		document.getElementById("usNAME").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("usNAME").style.borderColor = "lightgrey";
		//document.getElementById("lblPRD").innerHTML = "";
	}	       
	if (sEML1 == ""){
		document.getElementById("usEML1").style.borderColor = "red";
		document.getElementById("usEML1").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("usEML1").style.borderColor = "lightgrey";
		//document.getElementById("lblPRD").innerHTML = "";
	}
	if (sNOM == ""){
		document.getElementById("usNOM").style.borderColor = "red";
		document.getElementById("usNOM").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("usNOM").style.borderColor = "lightgrey";
		//document.getElementById("lblPRD").innerHTML = "";
	}	
	
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){
                addNotif('<?php echo $dw3_lbl["MODIFIED"]; ?>');
                closeMSG();
                closeEDITOR();
				getUSERS();
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updUSER.php?KEY=' + KEY + '&ID=' + sID
										+ '&UN=' + encodeURIComponent(sUNAME)  
										+ '&SMS_RDV=' + encodeURIComponent(sSMS_RDV)  
										+ '&EML1=' + encodeURIComponent(sEML1)  
										+ '&EML2=' + encodeURIComponent(sEML2)  
										+ '&EML3=' + encodeURIComponent(sEML3)  
										+ '&PRENOM=' + encodeURIComponent(sPRENOM)   
										+ '&PRENOM2=' + encodeURIComponent(sPRENOM2)   
										+ '&NOM=' + encodeURIComponent(sNOM)   
										+ '&PREFIX=' + encodeURIComponent(sPREFIX)   
										+ '&SUFFIX=' + encodeURIComponent(sSUFFIX)   
										+ '&ADR1=' + encodeURIComponent(sADR1)   
										+ '&ADR2=' + encodeURIComponent(sADR2)   
										+ '&MRDV=' + encodeURIComponent(sMSG_RDV)   
										+ '&TZ=' + encodeURIComponent(sTZ)
										+ '&SALARY=' + encodeURIComponent(sSALARY)
										+ '&VILLE=' + sVILLE
										+ '&PROV=' + sPROV
										+ '&PAYS=' + sPAYS
										+ '&CP=' + sCP
										+ '&TEL1=' + sTEL1
										+ '&TEL2=' + sTEL2
										+ '&STAT=' + sSTAT
										+ '&AUTH=' + sAUTH
										+ '&APLC=' + sAPLC
										+ '&LANG=' + sLANG
										+ '&POS=' + sPOS
										+ '&INACTIVE=' + sINACTIVE
										+ '&LOC=' + sLOC  ,    
										true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.6";
}

</script>
</body>
</html>
<?php $dw3_conn->close(); ?>