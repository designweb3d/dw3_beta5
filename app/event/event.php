<?php 
/**
 +---------------------------------------------------------------------------------+
 | DW3 BETA                                                                        |
 | Version 1                                                                       |
 |                                                                                 | 
 |  The MIT License                                                                |
 |  Copyright © 2023 Design Web 3D                                                 | 
 |                                                                                 |
 |  Permission is hereby granted, free of charge, to any person obtaining a copy   |
 |   of this software and associated documentation files (the "Software"), to deal |
 |   in the Software without restriction, including without limitation the rights  |
 |   to use, copy, modify, merge, publish, distribute, sublicense, and/or sell     |
 |   copies of the Software, and to permit persons to whom the Software is         |
 |   furnished to do so, subject to the following conditions:                      | 
 |                                                                                 |
 |   The above copyright notice and this permission notice shall be included in    | 
 |   all copies or substantial portions of the Software.                           |
 |                                                                                 | 
 |   THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR    |
 |   IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,      |
 |   FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE   | 
 |   AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER        |
 |   LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, | 
 |   OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN     |
 |   THE SOFTWARE.                                                                 |
 |                                                                                 |
 +---------------------------------------------------------------------------------+
 | Author: Julien Béliveau <info@dw3.ca>                                           |
 +---------------------------------------------------------------------------------+*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/menu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/common_header.php'; 
?>

<div id='divHEAD'>
	<table style="width:100%;margin:0px;white-space:nowrap;">
		<tr style="margin:0px;padding:0px;">
			<td width="40"><button style="margin:0px 2px 0px 2px;padding:8px;font-size:0.8em;" onclick="openFILTRE();"><span class="material-icons">filter_alt</span></button></td>
			<td width="*" style="margin:0px;padding:0px;">
				<input type="search" onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" id="inputSEARCH" onkeyup="getEVENTS('','',LIMIT);" placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
			</td>
			<td style="width:0;min-width:fit-content;margin:0px;padding:0px 0px 0px 5px;text-align:right;">
				<button style="margin:0px 2px 0px 2px;padding:8px;" onclick="saveToPDF();"><span class="material-icons">picture_as_pdf</span></button>
				<?php if($APREAD_ONLY == false) { ?><button class='blue' style="margin:0px 2px 0px 2px;padding:8px;" onclick="clearNEW();openNEW();"><span class="material-icons">add</span></button><?php } ?>
				<button class='grey' style="margin:0px 2px 0px 2px;padding:8px;" onclick="openPARAM();"><span class="material-icons">settings</span></button>
			 </td>
		</tr>
	</table>
</div>

<div id='divFILTRE'>
<h3><?php echo $dw3_lbl["FILTER"]; ?></h3>
		<table style='width:100%'>
            <tr><td>Type d'evenement</td><td>
            <select id='selTYPE'>
            <option selected  value=''><?php echo $dw3_lbl["ALL"]; ?></option>
            <?php
				$sql = "SELECT DISTINCT(event_type) as event_type FROM event ";
				$result = $dw3_conn->query($sql);
				if ($result->num_rows > 0) {	
					while($row = $result->fetch_assoc()) {
						$event_type = $row["event_type"];
						if ($row["event_type"] == "TASK"){$event_type = "Tâche";}
						if ($row["event_type"] == "PUBLIC"){$event_type = "Évènement publique";}
						if ($row["event_type"] == "ROAD_INCIDENT"){$event_type = "Incident de la route";}
						if ($row["event_type"] == "CALL_INFO"){$event_type = "Appel pour de l'information";}
						if ($row["event_type"] == "TICKET"){$event_type = "Ticket pour support";}
						if ($row["event_type"] == "COMPLAINT"){$event_type = "Plainte";}
						if ($row["event_type"] == "PRIVACY_INCIDENT"){$event_type = "Incident de confidentialité";}
						if ($row["event_type"] == "EMAIL"){$event_type = "Courriel envoyé";}
						if ($row["event_type"] == "CUSTOMER"){$event_type = "Évènement client";}
						if ($row["event_type"] == "ORDER"){$event_type = "Évènement commande";}
						if ($row["event_type"] == "INVOICE"){$event_type = "Évènement facture";}
						if ($row["event_type"] == "PRODUCT"){$event_type = "Évènement produit";}
						if ($row["event_type"] == "USER"){$event_type = "Évènement utilisateur";}
						if ($row["event_type"] == "DOCUMENT"){$event_type = "Évènement document";}
						if ($row["event_type"] == "UPDATE"){$event_type = "Mise à jour système";}
						if ($row["event_type"] == "LOGIN"){$event_type = "Erreur de login";}
						if ($row["event_type"] == "SYSTEM"){$event_type = "Action du système";}
						echo "<option value='" . $row["event_type"]  . "'>" . $event_type . "</option>";
					}
				}
            ?>
            </select></td></tr>
        </table><br>
		<div style='width:100%;text-align:center;'><button class='grey' onclick="closeFILTRE();"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button><button onclick="closeFILTRE();getEVENTS('','',LIMIT);"><span class="material-icons">filter_alt</span> <?php echo $dw3_lbl["FILTER"]; ?></button></div>
</div>

<div id='divMAIN' class='divMAIN' style="padding-top:50px;min-height:100vh;">
<img src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>
</div>
<div id="divEDIT" class="divEDITOR">
	<div id="divEDIT_MAIN"></div>
</div>

<div id="divNEW" class="divEDITOR" style='width:336px;min-height:25%;height:590px;max-height:90%;'>
    <div id='divNEW_HEADER' class='dw3_form_head'>
        <h3 style='vertical-align:middle;height:40px;'><div style='display: grid;align-items: center;height:40px;'><?php if ($USER_LANG == "FR"){echo "Nouvel évènement";}else{echo "New event";} ?></div></h3>
		<button class='grey' style='top:0px;right:0px;padding:4px;position:absolute;' onclick='closeEDITOR(this);'><span class='material-icons'>cancel</span></button>
    </div> 
    <div  class='dw3_form_data'>
        <div class='divBOX'>Type d'évènement:
            <select id='newTYPE'>
                <option value='TASK'>Tâche</option>
                <option value='PUBLIC'>Évènement PUBLIQUE</option>
                <option value='ROAD_INCIDENT'>Incident de la route</option>
                <option value='CALL_INFO'>Appel d'un client pour de l'information</option>
                <option value='TICKET'>Ticket pour support</option>
                <option value='COMPLAINT'>Plainte</option>
                <option value='PRIVACY_INCIDENT'>Incident de confidentialité</option>
            </select>
        </div><br>
        <div class="divBOX">Nom de l'évènement:
            <input id="newNAME" type="text" value="" onclick="detectCLICK(event,this);">
        </div><br>
        <div class='divBOX'>Priorité:
            <select id='newPRIORITY'>
                <option value='LOW'>Basse</option>
                <option value='MEDIUM'>Moyenne</option>
                <option value='HIGH'>Haute</option>
            </select>
        </div><br>
        <div class='divBOX'>Date:
            <input id='newDATE' type='date' value="" onclick='detectCLICK(event,this);'>
        </div><br>
        <div class='divBOX'>Heure de début:
            <input id='newDATE_START' type='time' value="" onclick='detectCLICK(event,this);'>
        </div><br>
        <div class='divBOX'>Heure de fin / due:
            <input id='newDATE_END' type='time' value="" onclick='detectCLICK(event,this);'>
            <div id='lblDATE_END' style='color:white;font-size:0.8em;padding-left:10px;'></div>
        </div>
	</div>
    <div id='divNEW_FOOT'>
        <button class='grey' onclick="closeNEW();"><span class="material-icons">cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button>
        <button class='blue' onclick="newEVENT();"><span class="material-icons">add</span><?php echo $dw3_lbl["CREATE"] . " & " . $dw3_lbl["MODIFY"]; ?></button>
	</div>
</div>

<!-- SELECTION DE L'UTILISATEUR -->
<div id="divSEL_USER" class="divSELECT" style='min-width:330px;min-height:90%;'><input id='whySEL_USER' type='text' value='NEW' style='display:none;'>
    <div id="divSEL_USER_HEADER" class='dw3_form_head'><h3>
	    Sélection d'utilisateur</h3>
        <button onclick='closeSEL_USER();' class='dw3_form_close'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'>
        <div class="divBOX">
            <input id="selUSER" oninput="getSEL_USER('');" type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" onclick="detectCLICK(event,this);"  placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
        </div><br>
            <div id="divSEL_USER_DATA" style="margin:10px;max-height:75%;">		
                Inscrire votre recherche pour trouver un employé.
            </div>
    </div>
	<div class='dw3_form_foot'>
		<button class='grey' onclick="closeSEL_USER();getElementById('divSEL_USER_DATA').innerHTML='Inscrire votre recherche pour trouver un employé.';"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>
	</div><br>
</div>

<!-- SELECTION DU CLIENT -->
<div id="divSEL_CLI" class="divSELECT" style='min-width:330px;min-height:90%;'><input id='whySEL_CLI' type='text' value='NEW' style='display:none;'>
    <div id="divSEL_CLI_HEADER" class='dw3_form_head'><h3>
	    Sélection d'utilisateur</h3>
        <button onclick='closeSEL_CLI();' class='dw3_form_close'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'>
        <div class="divBOX">
            <input id="selCLI" oninput="getSEL_CLI('');" type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" onclick="detectCLICK(event,this);"  placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
        </div><br>
            <div id="divSEL_CLI_DATA" style="margin:10px;max-height:75%;">		
                Inscrire votre recherche pour trouver un employé.
            </div>
    </div>
	<div class='dw3_form_foot'>
		<button class='grey' onclick="closeSEL_CLI();getElementById('divSEL_CLI_DATA').innerHTML='Inscrire votre recherche pour trouver un employé.';"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>
	</div><br>
</div>

<div id="divPARAM"  class="divEDITOR" style="background: rgba(0, 0, 0, 0.7);color:white;overflow-y:auto;">
    <div id='divPARAM_HEADER' class='dw3_form_head'>
        <h2 style='background: rgba(44, 44, 44, 0.9);'>Paramètres de l'application</h2>
        <button class='dw3_form_close' onclick='closeEDITOR(this);'><span class='material-icons'>cancel</span></button>
    </div>
    <div class='dw3_form_data' id="divPARAM_DATA"></div>
    <div class='EDIT_FOOT' style='text-align:right;padding:3px;background-image: linear-gradient(to right, rgba(0,0,0,0), rgba(44,44,44,1));'>
        <button class='white' onclick='resetPRM()' style='margin:0px 2px 0px 2px;'><span class='material-icons'>restart_alt</span> Réinitialiser</button>
        <button class='grey' onclick='closeEDITOR()' style='margin:0px 2px 0px 2px;'><span class='material-icons'>cancel</span> Annuler</button>
        <button class='green' onclick='updPRM();' style='margin:0px 10px 0px 2px;'><span class='material-icons'>save</span> Enregistrer</button>
    </div>
</div>

<div id="divPERIODIC"  class="divEDITOR" style="background: rgba(0, 0, 0, 0.7);color:white;overflow-y:auto;min-height:250px;max-width:350px;">
    <div id='divPERIODIC_HEADER' class='dw3_form_head'>
        <h2 style='background: rgba(44, 44, 44, 0.9);'>Répéter la tâche</h2>
        <button class='dw3_form_close' onclick='closePERIODIC();'><span class='material-icons'>cancel</span></button>
    </div>
    <input id='eventID' type='text' value='' style='display:none;'>
    <div class='dw3_form_data' id="divPARAM_DATA">
        <div class='divBOX'>Type de répétition:
            <select id='periodTYPE' style='width:100%;' onchange='detectCLICK(event,this);'>
                <option value='DAILY'>Quotidien</option>
                <option value='WEEKLY'>Hebdomadaire</option>
                <option value='BI-WEEKLY'>Aux deux semaines</option>
                <option value='MONTHLY'>Mensuel</option>
                <option value='MONTHLY3'>Trimestriel (3 mois)</option>
                <option value='MONTHLY6'>Semestriel (6 mois)</option>
                <option value='YEARLY'>Annuel</option>
            </select>
        </div><br>
        <div class='divBOX'>Nombre d'occurrences additionnelles:
            <input id='periodDURATION' type='number' value='1' min='1' style='width:100%;' onclick='detectCLICK(event,this);'>
        </div>
    </div>
    <div class='EDIT_FOOT' style='text-align:right;padding:3px;background-image: linear-gradient(to right, rgba(0,0,0,0), rgba(44,44,44,1));'>
        <button class='grey' onclick='closePERIODIC()' style='margin:0px 2px 0px 2px;'><span class='material-icons'>cancel</span> Annuler</button>
        <button class='green' onclick='setPERIODIC();' style='margin:0px 10px 0px 2px;'><span class='material-icons'>event_repeat</span> Créer les tâches</button>
    </div>
</div>

<div id="divMSG"></div>
<div id="divOPT"></div>
<script type="text/javascript" src="/pub/js/main.js.php?t=<?php echo(rand(100,100000)); echo "&KEY=" . $KEY."&INACTIVE=".$USER_INACTIVE; ?>"></script>
<script src="/pub/js/multiavatar.min.js"></script>
<script>
//jQ
$(document).ready(function ()
    {
		var body = document.body,
		html = document.documentElement;

		var height = Math.max( body.scrollHeight, body.offsetHeight, 
						   html.clientHeight, html.scrollHeight, html.offsetHeight );
		LIMIT = Math.floor(height/53);				   
		getEVENTS('','',LIMIT);

        var now = new Date();
        document.getElementById("newDATE").value = now.toISOString().slice(0,10);
        document.getElementById("newDATE_START").value = now.toISOString().slice(11,16);
        document.getElementById("newDATE_END").value = now.toISOString().slice(11,16);

        dragElement(document.getElementById('divNEW'));
        dragElement(document.getElementById('divPARAM'));
        dragElement(document.getElementById('divPERIODIC'));
	});
	
//_	
var KEY = '<?php echo($_GET['KEY']); ?>';
var active_input;
var LIMIT = '12';

function openPARAM() {
	document.getElementById('divPARAM').style.display = "inline-block";
	document.getElementById("divFADE").style.display = "inline-block";
	document.getElementById("divFADE").style.opacity = "0.6";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 var sOBJ = this.responseText;
		 if (sOBJ != ""){
			 document.getElementById('divPARAM_DATA').innerHTML = sOBJ;
		 }
	  }
	};
	xmlhttp.open('GET', 'getPARAM.php?KEY=' + KEY  , true);
	xmlhttp.send();
}
function detectSEARCH(event,that){
	var x = event.offsetX;
	if (x > (that.offsetWidth-25)){
		that.setSelectionRange(0, that.value.length);
		
	}
}
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

function deleteEVENT(ID) {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><br><br><button class='red' onclick='delEVENT(" + ID + ");'><span class='material-icons' style='vertical-align:middle;'>delete</span><?php echo $dw3_lbl["DEL"]; ?></button> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button>";
}

function saveToPDF() {
    var sS = document.getElementById("inputSEARCH").value;
    var GRPBOX = document.getElementById("selTYPE");
    sTYPE = GRPBOX.options[GRPBOX.selectedIndex].value;		
    window.open('saveToPDF.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim()) + '&TYPE=' + sTYPE,'_blank');
}

function delEVENT(ID, DEL_NEXT='') {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
                addNotif("<?php echo $dw3_lbl["DEL_OK"]; ?>");
                getEVENTS('','',LIMIT);
                closeMSG();
                closeEDITOR();
		  } else {
             if (this.responseText == "Err_PARENT"){
				document.getElementById("divMSG").style.display = "inline-block";
	            document.getElementById("divMSG").innerHTML = "Évenement périodique. Effacer les événements suivants aussi?<br><br><button class='red' onclick='delEVENT(" + ID + ",2);'><span class='material-icons' style='vertical-align:middle;'>delete</span>Oui tout effacer</button> <button class='red' onclick='delEVENT(" + ID + ",1);'><span class='material-icons'>cancel</span>Seulement celui-ci</button> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>";
             } else {
                document.getElementById("divMSG").style.display = "inline-block";
                document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
             }
		  }
	  }
	};
		xmlhttp.open('GET', 'delEVENT.php?KEY=' + KEY + '&ID=' + ID + '&DEL_NEXT=' + DEL_NEXT, true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
}

function deleteEVENTS() {
	closeBatch();
	var selectedId = -1;
	var selectedCount = 0;
    var frmCLI  = document.getElementById("frmEVENT");
	for (var i = 0; i < frmEVENT.elements.length; i++ ) 
	{
		if (frmEVENT.elements[i].type == 'checkbox' && frmEVENT.elements[i].checked == true)
		{
			selectedCount++;
			selectedID = frmEVENT.elements[i].value;
		}
	}
	if(selectedCount == 1 && selectedID > 0){
		deleteEVENT(selectedID);
		return;
	}
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "0.6";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><div style='height:20px;'> </div><button class='red' onclick='delEVENTS();'><span class='material-icons' style='vertical-align:middle;'>delete</span>Delete</button> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span>Annuler</button>";
}
function delEVENTS() {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "0.6";
	var sLST = "";

	var frmEVENT  = document.getElementById("frmEVENT");
	var sVIRGULE = "";
	
	for (var i = 0; i < frmEVENT.elements.length; i++ ) 
	{
		if (frmEVENT.elements[i].type == 'checkbox')
		{
			if (frmEVENT.elements[i].checked == true)
			{
				if(sLST != ""){sVIRGULE = ","} else { sLST = "("; }
				sLST += sVIRGULE + frmEVENT.elements[i].value ;
			}
		}
	}	
	if (sLST == ""){
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["ERR_SEL1"]; ?><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		return;
	} else { sLST += ")"; }
	
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){
			  	getEVENTS('','',LIMIT);
                closeMSG();
                addNotif("Évènement(s) supprimé(s).");
          } else {
				document.getElementById("divFADE").style.width = "100%";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'delEVENTS.php?KEY=' + KEY + '&LST=' + encodeURIComponent(sLST) , true);
		xmlhttp.send();
		
}

function getEVENT(ID) {
    closeBatch();
	var max_width = Math.max(window.innerWidth, document.documentElement.clientWidth, document.body.clientWidth)/100*95;
	var text_width = Math.floor(max_width/335)*335;
	if (text_width=='0'){text_width='335'} 
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divEDIT_MAIN").innerHTML = this.responseText;
		 document.getElementById("divEDIT").style.display = "inline-block";
		 dragElement(document.getElementById('divEDIT'));
		 document.getElementById("divEDIT").scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"})
		 //setMapPos();
	  }
	};
		document.getElementById("divFADE").style.width = "100%";
		xmlhttp.open('GET', 'getEVENT.php?KEY=' + KEY + '&ID=' + ID + '&tw=' + text_width , true);
		xmlhttp.send();
		
}

function getEVENTS(sTYPE,sOFFSET,sLIMIT) {
	var sS = document.getElementById("inputSEARCH").value;
	//STAT
	if (sTYPE.trim() == ""){
		var GRPBOX = document.getElementById("selTYPE");
		sTYPE = GRPBOX.options[GRPBOX.selectedIndex].value;		
	}

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divMAIN").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getEVENTS.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim())
									+ '&TYPE=' + sTYPE
									+ '&OFFSET=' + sOFFSET 
									+ '&LIMIT=' + sLIMIT  
									, true);
		xmlhttp.send();
		
}
function clearNEW(){
	var now = new Date();
	document.getElementById("newDATE").value = now.toISOString().slice(0,10);
	document.getElementById("newDATE_START").value = now.toISOString().slice(11,16);
	document.getElementById("newDATE_END").value = now.toISOString().slice(11,16);
	document.getElementById("newNAME").value = "";
	document.getElementById("newTYPE").selectedIndex = 0;
	document.getElementById("newPRIORITY").selectedIndex = 0;
	document.getElementById("newNAME").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
	document.getElementById("newDATE_END").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
	document.getElementById("lblDATE_END").innerHTML = "";
}

function newEVENT(){
	var GRPBOX = document.getElementById("newTYPE");
	var sTYPE = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var GRPBOX = document.getElementById("newPRIORITY");
	var sPRIORITY = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var sNAME  = document.getElementById("newNAME").value;
	var sDATE  = document.getElementById("newDATE").value;
	var sDATE_START  = sDATE + " " + document.getElementById("newDATE_START").value;
	var sDATE_END  = sDATE + " " + document.getElementById("newDATE_END").value;
	
    //verification si un nom d'évènement a été entré
	if (sNAME == ""){
		document.getElementById("newNAME").style.boxShadow = "5px 10px 15px red";
		document.getElementById("newNAME").focus();
		return;
	} else {
		document.getElementById("newNAME").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
	}	
	//vérification si la date de fin est après la date de début
	if (document.getElementById("newDATE_START").value > document.getElementById("newDATE_END").value){
		document.getElementById("newDATE_END").style.boxShadow = "0px 10px 15px red";
		document.getElementById("newDATE_END").focus();
		document.getElementById("lblDATE_END").innerHTML = "L'heure de fin doit être après l'heure de début.";
		return;
	} else {
		document.getElementById("newDATE_END").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
		document.getElementById("lblDATE_END").innerHTML = "";
	}	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
				addNotif("<?php echo $dw3_lbl["CREATED"]; ?>");
                getEVENTS('','',LIMIT);
                getEVENT(this.responseText);
                closeNEW();
		  } else {
            document.getElementById("divFADE2").style.display = "inline-block";
		    document.getElementById("divFADE2").style.opacity = "0.4";
            document.getElementById("divMSG").style.display = "inline-block";
            document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'newEVENT.php?KEY=' + KEY  
										+ '&TYPE=' + encodeURIComponent(sTYPE)    
										+ '&PRIORITY=' + encodeURIComponent(sPRIORITY)
										+ '&NAME=' + encodeURIComponent(sNAME)    
										+ '&DATE_START=' + encodeURIComponent(sDATE_START)   
										+ '&DATE_END=' + encodeURIComponent(sDATE_END),   
										true);
		xmlhttp.send();

}
function updEVENT(sID, updNEXT = ''){
	var GRPBOX = document.getElementById("evTYPE");
	var sTYPE = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var GRPBOX = document.getElementById("evPRIORITY");
	var sPRIORITY = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var GRPBOX = document.getElementById("evSTATUS");
	var sSTATUS = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var GRPBOX = document.getElementById("evLOC_ID");
	var sLOC_ID = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var sUSER_ID  = document.getElementById("evUSER_ID").value;
	var sCLI_ID  = document.getElementById("evCLI_ID").value;
	var sPRJ_ID  = document.getElementById("evPRJ_ID").value;
	var sNAME  = document.getElementById("evNAME").value;
	var sNAME_EN  = document.getElementById("evNAME_EN").value;
	var sDATE  = document.getElementById("evDATE").value;
	var sDATE_START  = sDATE + " " + document.getElementById("evDATE_START").value;
	var sDATE_END  = sDATE + " " + document.getElementById("evDATE_END").value;
	var sDURATION  = document.getElementById("evDURATION").value;
	var sDESC  = document.getElementById("evDESC_FR").value.replace(/(?:\r\n|\r|\n)/g, '<br>');
	var sDESC_EN  = document.getElementById("evDESC_EN").value.replace(/(?:\r\n|\r|\n)/g, '<br>');
	var sHREF  = document.getElementById("evHREF").value;
	var sIMG  = document.getElementById("evIMG").value;
	
    //verification si un nom d'évènement a été entré
	if (sNAME == ""){
		document.getElementById("evNAME").style.boxShadow = "5px 10px 15px red";
		document.getElementById("evNAME").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("evNAME").style.boxShadow = "5px 10px 15px #333";
		//document.getElementById("lblPRD").innerHTML = "";
	}
	//vérification si la date de fin est après la date de début
	if (document.getElementById("evDATE_START").value > document.getElementById("evDATE_END").value){
		document.getElementById("evDATE_END").style.boxShadow = "0px 10px 15px red";
		document.getElementById("evDATE_END").focus();
		document.getElementById("lblEV_DATE_END").innerHTML = "L'heure de fin doit être après l'heure de début.";
		return;
	} else {
		document.getElementById("evDATE_END").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
		document.getElementById("lblEV_DATE_END").innerHTML = "";
	}	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
          if (this.responseText.substr(0, 3) != "Err"){
				getEVENTS('','',LIMIT);
                addNotif("<?php echo $dw3_lbl["MODIFIED"]; ?>");
                closeMSG();
                closeEDITOR();
		  } else {
             if (this.responseText == "Err_PARENT"){
				document.getElementById("divMSG").style.display = "inline-block";
	            document.getElementById("divMSG").innerHTML = "Évenement périodique. Mettre à jour les événements suivants aussi?<br><br><button class='green' onclick='updEVENT(" + sID + ",2);'><span class='material-icons' style='vertical-align:middle;'>save</span> Oui tout mettre à jour</button> <button class='green' onclick='updEVENT(" + sID + ",1);'><span class='material-icons'>save</span> Seulement celui-ci</button>";
             } else {
                document.getElementById("divMSG").style.display = "inline-block";
                document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
             }
		  }
	  }
	};
	xmlhttp.open('GET', 'updEVENT.php?KEY=' + KEY 
									+ '&ID=' + encodeURIComponent(sID)  
									+ '&USER=' + encodeURIComponent(sUSER_ID)   
									+ '&TYPE=' + encodeURIComponent(sTYPE)    
									+ '&PRIORITY=' + encodeURIComponent(sPRIORITY)    
									+ '&STATUS=' + encodeURIComponent(sSTATUS)    
									+ '&NAME=' + encodeURIComponent(sNAME)    
									+ '&NAME_EN=' + encodeURIComponent(sNAME_EN)    
									+ '&DESC=' + encodeURIComponent(sDESC)   
									+ '&DESC_EN=' + encodeURIComponent(sDESC_EN)   
									+ '&CLI=' + encodeURIComponent(sCLI_ID)   
									+ '&PRJ=' + encodeURIComponent(sPRJ_ID)   
									+ '&LOC=' + encodeURIComponent(sLOC_ID)   
									+ '&START=' + encodeURIComponent(sDATE_START)   
									+ '&END=' + encodeURIComponent(sDATE_END)   
									+ '&DURATION=' + encodeURIComponent(sDURATION)   
									+ '&IMG=' + encodeURIComponent(sIMG)   
									+ '&HREF=' + encodeURIComponent(sHREF)
									+ '&UPD_NEXT=' + updNEXT,                 
									true);
	xmlhttp.send();
	document.getElementById("divFADE").style.display = "inline-block";
	document.getElementById("divFADE").style.opacity = "0.6";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:70px;height:auto;border-radius:7px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
}



//SELECTION USER
function getSEL_USER(LOOK_FOR) {
	if(LOOK_FOR=="" && document.getElementById("selUSER") != undefined){LOOK_FOR = document.getElementById("selUSER").value.trim();}
    var OUTPUT_ID = document.getElementById("whySEL_USER").value.trim();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById('divSEL_USER').style.display = "inline-block";
		document.getElementById("divSEL_USER_DATA").innerHTML = this.responseText;
        dragElement(document.getElementById('divSEL_USER'));
	  }
	};
    xmlhttp.open('GET', '/app/selUSER.php?KEY=' + KEY + '&LOOK_FOR=' + encodeURIComponent(LOOK_FOR.trim()) + "&OUTPUT_ID=" + OUTPUT_ID, true);
    xmlhttp.send();
}
function openSEL_USER(OUTPUT_ID) {
    document.getElementById('divSEL_USER').style.display = "inline-block";
    document.getElementById('whySEL_USER').value = OUTPUT_ID;
    getSEL_USER('');
}
function closeSEL_USER() {
    document.getElementById('divSEL_USER').style.display = "none";
}
function validateUSER(sID,OUTPUT_ID) {
    document.getElementById(OUTPUT_ID).value = sID;
    closeSEL_USER();
}

//SELECTION CLIENT
function getSEL_CLI(LOOK_FOR) {
	if(LOOK_FOR=="" && document.getElementById("selCLI") != undefined){LOOK_FOR = document.getElementById("selCLI").value.trim();}
    var OUTPUT_ID = document.getElementById("whySEL_CLI").value.trim();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById('divSEL_CLI').style.display = "inline-block";
		document.getElementById("divSEL_CLI_DATA").innerHTML = this.responseText;
        dragElement(document.getElementById('divSEL_CLI'));
	  }
	};
    xmlhttp.open('GET', '/app/selCLI.php?KEY=' + KEY + '&LOOK_FOR=' + encodeURIComponent(LOOK_FOR.trim()) + "&OUTPUT_ID=" + OUTPUT_ID, true);
    xmlhttp.send();
}
function openSEL_CLI(OUTPUT_ID) {
    document.getElementById('divSEL_CLI').style.display = "inline-block";
    document.getElementById('whySEL_CLI').value = OUTPUT_ID;
    getSEL_CLI('');
}
function closeSEL_CLI() {
    document.getElementById('divSEL_CLI').style.display = "none";
}
function validateCLI(sID,OUTPUT_ID) {
    document.getElementById(OUTPUT_ID).value = sID;
    closeSEL_CLI();
}

//PERIODIC TASK
function closePERIODIC() {
    document.getElementById('divPERIODIC').style.display = "none";
    document.getElementById("divFADE2").style.display = "none";
    document.getElementById("divFADE2").style.opacity = "0";
}
function openPERIODIC(taskID) {
    document.getElementById('divPERIODIC').style.display = "inline-block";
    document.getElementById('eventID').value = taskID;
}
function setPERIODIC(){
    var taskID =  document.getElementById('eventID').value;
    var GRPBOX = document.getElementById("periodTYPE");
    var periodTYPE = GRPBOX.options[GRPBOX.selectedIndex].value;	
    var periodDURATION = document.getElementById("periodDURATION").value;

    if (isNaN(periodDURATION) || periodDURATION < 1 || periodDURATION > 999){
        if (sNOM == ""){
            document.getElementById("periodDURATION").style.boxShadow = "5px 10px 15px red";
            document.getElementById("periodDURATION").focus();
            //document.getElementById("spanDURATION").innerHTML = "Veuillez entrer un nombre entre 1 et 999.";
            return;
        } else {
            document.getElementById("periodDURATION").style.boxShadow = "5px 10px 15px goldenrod";
            //document.getElementById("spanDURATION").innerHTML = "";
        }	
    }

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          if (this.responseText == ""){
            closePERIODIC();
            getEVENTS('','',LIMIT);
            getEVENT(taskID);
            addNotif("Les tâches périodiques ont été créées.");
          } else {
              	document.getElementById("divMSG").style.display = "inline-block";
                document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
          } 
      }
    };

        xmlhttp.open('GET', 'setPERIODIC.php?KEY=' + KEY 
                                        + '&ID=' 	+ taskID
                                        + '&TYPE='	+ periodTYPE
                                        + '&DURATION='	+ periodDURATION,true);
        xmlhttp.send();
        document.getElementById("divFADE2").style.display = "inline-block";
        document.getElementById("divFADE2").style.opacity = "0.4";
}

function deletePERIODIC(taskID) {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Voulez-vous vraiment effacer toutes les tâches périodiques associées à cet événement ?<br><br><button class='red' onclick='delPERIODIC(" + taskID + ");'><span class='material-icons' style='vertical-align:middle;'>delete</span><?php echo $dw3_lbl["DEL"]; ?></button> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button>";
}
function delPERIODIC(taskID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
                addNotif("<?php echo $dw3_lbl["DEL_OK"]; ?>");
                getEVENTS('','',LIMIT);
                getEVENT(taskID);
                closeMSG();
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'delPERIODIC.php?KEY=' + KEY + '&ID=' + taskID , true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
}

//PARAMETRES DE L'APPLICATION
function resetPRM() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        openPARAM();
	  }
	};
	xmlhttp.open('GET', '../resetPRM.php?KEY=' + KEY + '&APP=' + <?php echo $APID; ?> , true);
	xmlhttp.send();
}
function updPRM(){
	var GRPBOX = document.getElementById("prmLIMIT");
	var prmLIMIT = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var GRPBOX = document.getElementById("prmORDERBY");
	var prmORDERBY = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX = document.getElementById("prmORDERWAY");
	var prmORDERWAY = GRPBOX.options[GRPBOX.selectedIndex].value;
	
	if (document.getElementById("DSP_COL_ID").checked == false){ var dspID = 0; } else { var dspID = 1; }
	if (document.getElementById("DSP_COL_NAME").checked == false){ var dspNAME = 0; } else { var dspNAME = 1; }
	if (document.getElementById("DSP_COL_TYPE").checked == false){ var dspTYPE = 0; } else { var dspTYPE = 1; }
	if (document.getElementById("DSP_COL_DESC").checked == false){ var dspDESC = 0; } else { var dspDESC = 1; }
	if (document.getElementById("DSP_COL_DTMD").checked == false){ var dspDTMD = 0; } else { var dspDTMD = 1; }

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){
            closeMSG();
            closeEDITOR();
            getEVENTS('','',LIMIT);
            addNotif("Les paramètres ont été mis &#224; jour.");
		  } else {
			  	document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};

		xmlhttp.open('GET', 'updPRM.php?KEY=' + KEY 
										+ '&LIMIT=' 	+ prmLIMIT
										+ '&ORDW='	+ prmORDERWAY
										+ '&ORDB='	+ prmORDERBY
										+ '&ID=' 		+ dspID
										+ '&NAME='		+ dspNAME
										+ '&TYPE=' 		+ dspTYPE
										+ '&DESC=' 		+ dspDESC
										+ '&DTMD=' 		+ dspDTMD,true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
}

</script>

</body>
</html>
