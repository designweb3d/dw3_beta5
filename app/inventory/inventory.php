<?php /**
 +---------------------------------------------------------------------------------+
 | DW3 PME Kit BETA                                                                |
 | Version 0.6                                                                     |
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
				<input type="search" onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" id="inputSEARCH" oninput="getINV('',LIMIT);" placeholder="<?php echo $dw3_lbl["RECH"];?>.." title="<?php echo $dw3_lbl["RECH"];?>">
			</td>
			<td style="width:0;min-width:fit-content;margin:0px;padding:0px 0px 0px 5px;text-align:right;">
				<button style="margin:0px 2px 0px 2px;padding:8px;" onclick="openSTORAGE();"><span class="material-icons">warehouse</span></button>
				<button style="margin:0px 2px 0px 2px;padding:8px;" onclick="openSUPPLY();"><span class="material-icons">inventory_2</span></button>
				<?php if($APREAD_ONLY == false) { ?><button style="margin:0px 2px 0px 2px;padding:8px;" onclick="openNEW();document.getElementById('newPRD').focus();"><span class="material-icons">add</span></button> <?php } ?>
				<button class="grey" style="margin:0px 2px 0px 2px;padding:8px;" onclick="openPARAM();"><span class="material-icons">settings</span></button>
			 </td>
		</tr>
	</table>
</div>
<div id="divNEW" class="divEDITOR" style='max-width:450px;'>
	<div id='divNEW_HEADER' class='dw3_form_head'>
		<h2>Transfert d'inventaire</h2>
		<button  class='dw3_form_close' onclick='closeNEW();'><span class='material-icons'>close</span></button>
    </div> <div  class='dw3_form_data'>
        <div class="divBOX"><b>Type de transfert</b>:
            <select id='newKIND'>
                <option value='MOVE'>Mouvement d'inventaire</option>
                <option value='LOST'>Perdu / Trouvé</option>
                <option value='PROD'>Production</option>
                <option value='EXPORT'>Expédition (vente)</option>
                <option value='IMPORT'>Réception (achat)</option>
                <option value='SUPP_RET'>Retourner au fournisseur</option>
            </select>
        </div>
        <div class='divBOX'>Produit:
            <input id='newPRD' type='text' value="" style='width:280px;' oninput='scanUPC();' onclick="detectCLICK(event,this);">
            <button onclick='openSEL_PRD("NEW");'><span class="material-icons" style='font-size:14px;'>search</span></button>
        </div>
	    <div class='divBOX'>Emplacement:
            <input id='newSTORAGE' type='text' value="" style='width:280px;' onclick="detectCLICK(event,this);">
            <button onclick='openSEL_STORAGE("NEW");'><span class="material-icons" style='font-size:14px;'>search</span></button>
        </div>
        <div class="divBOX"><b>Quantité</b>:
            <input id="newQTE" type="text" value="" onclick="detectCLICK(event,this);">
        </div>
	    <div class='divBOX'><b>Achat #</b>:
            <input id='newORDER' type='text' value="" style='width:280px;' onclick="detectCLICK(event,this);">
            <button onclick='openSEL_PURCHASE("NEW");'><span class="material-icons" style='font-size:14px;'>search</span></button>
        </div>
	    <div class='divBOX'><b>Commande client#</b>:
            <input id='newPURCHASE' type='text' value="" style='width:280px;' onclick="detectCLICK(event,this);">
            <button onclick='openSEL_ORDER("NEW");'><span class="material-icons" style='font-size:14px;'>search</span></button>
        </div>
	</div><div id='divNEW_FOOT' class='dw3_form_foot'>
		<button class="grey" onclick="closeNEW();"><span class="material-icons">cancel</span> Fermer</button>
		<?php if($APREAD_ONLY == false) { ?><button class="blue" onclick="newTRF();"><span class="material-icons">move_down</span> Transférer</button><?php } ?>
	</div>
</div>

<div id="divSTORAGE" class="divEDITOR" style='max-width:450px;height:500px;max-height:500px;'>
	<div id='divSTORAGE_HEADER' class='dw3_form_head'>
		<h3>Stockage</h3>
		<button  class='dw3_form_close' onclick='closeSTORAGE();'><span class='material-icons'>close</span></button>
    </div> 
    <div id='storage_data' class='dw3_form_data' style='overflow-x:auto;'>
	</div>
    <div id='divNEW_FOOT' class='dw3_form_foot'>
		<button class="grey" onclick="closeSTORAGE();"><span class="material-icons">cancel</span> Fermer</button>
		<?php if($APREAD_ONLY == false) { ?><button class='blue' onclick="newSTORAGE();"><span class="material-icons">add</span> Ajouter</button><?php } ?>
	</div>
</div>

<div id="divSUPPLY" class="divEDITOR" style='max-width:450px;height:500px;max-height:500px;'>
	<div id='divSUPPLY_HEADER' class='dw3_form_head'>
		<h3>Emballages et fournitures</h3>
		<button  class='dw3_form_close' onclick='closeSUPPLY();'><span class='material-icons'>close</span></button>
    </div> 
    <div id='supply_data' class='dw3_form_data' style='overflow-x:auto;'>
	</div>
    <div id='divNEW_FOOT' class='dw3_form_foot'>
		<button class="grey" onclick="closeSUPPLY();"><span class="material-icons">cancel</span> Fermer</button>
		<?php if($APREAD_ONLY == false) { ?><button class='blue' onclick="newSUPPLY();"><span class="material-icons">add</span> Ajouter</button><?php } ?>
	</div>
</div>

<div id='divUPLOAD' style='display:none;'>
    <form id='frmUPLOAD' action="upload.php?KEY=<?php echo $KEY;?>" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload" onchange="document.getElementById('submitUPLOAD').click();">    
    <input type="text" name="fileName" id="fileName" value='0'>
    <input type="submit" value="Upload Image" name="submit" id='submitUPLOAD'>
    </form>
</div>

<div id="divMSG"></div>
<div id="divOPT"></div>
<div id='divMAIN' class='divMAIN' style="padding-top:50px;"></div>
<div id='divEDIT' class='divEDITOR' style='max-width:500px;'></div>


<div id='divFILTRE'>
<h3><?php echo $dw3_lbl["FILTER"];?></h3>
		<table style='width:100%'>
		<tr><td>Type de transfert</td><td width='*'>
		<select id='selKIND'>
            <option value='MOVE'>Mouvement d'inventaire</option>
            <option value='LOST'>Perdu / Trouvé</option>
            <option value='PROD'>Production</option>
            <option value='EXPORT'>Expédition (vente)</option>
            <option value='IMPORT'>Réception (achat)</option>
            <option value='SUPP_RET'>Retourner au fournisseur</option>
			<option selected value=''>Tous</option>
		</select></td></tr>
		<tr><td><?php echo $dw3_lbl["FRN1"];?></td><td>
		<select id='selFRN1'>
			<?php
				$sql = "SELECT DISTINCT(supplier_id), B.company_name as frNOM, B.id as frID
						FROM product A
                        LEFT JOIN supplier B ON A.supplier_id = B.id
						WHERE B.stat = 0
						ORDER BY frNOM
						LIMIT 100";
				$result = $dw3_conn->query($sql);
				if ($result->num_rows > 0) {	
					while($row = $result->fetch_assoc()) {
						echo "<option value='" . $row["frID"]  . "'>" . $row["frNOM"]  . "</option>";
					}
				}
			?>
			<option selected  value=''><?php echo $dw3_lbl["ALL"];?></option>
		</select></td></tr>
		<tr><td><?php echo $dw3_lbl["CAT"];?></td><td>
		<select id='selCAT'>
			<?php
				$sql = "SELECT DISTINCT(category_id), B.name_fr AS catNAME, B.id AS catID
						FROM product A
						LEFT JOIN product_category B ON A.category_id = B.id
						ORDER  BY catNAME
						LIMIT 100";
				$result = $dw3_conn->query($sql);
				if ($result->num_rows > 0) {	
					while($row = $result->fetch_assoc()) {
						echo "<option value='" . $row["catID"]  . "'>" . $row["catNAME"]  . "</option>";
					}
				}
			?>
			<option selected  value=''><?php echo $dw3_lbl["ALL"];?></option>
		</select></td></tr>
        </table><br>
		<div style='width:100%;text-align:center;'><button class='grey' onclick="closeFILTRE();"><span class="material-icons">cancel</span> Annuler</button><button onclick="closeFILTRE();getINV('',LIMIT);"><span class="material-icons">filter_alt</span> Filtrer</button></div>
</div>

<div id="divSEL_PRD" class="divSELECT" style='min-width:330px;max-width:100%;width:80%;min-height:90%;'><input id='whySEL_PRD' type='text' value='NEW' style='display:none;'>
    <div id="divSEL_PRD_HEADER" class='dw3_form_head'><h2>
	    Sélection ID <?php echo $dw3_lbl["PRD"]; ?></h2>
        <button onclick='closeSEL_PRD();' class='dw3_form_close'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'>
        <div class="divBOX">
            <input id="selPRD" oninput="getSEL_PRD('');" type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" onclick="detectCLICK(event,this);"  placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
        </div><br>
            <div id="divSEL_PRD_DATA" style="margin:10px;max-height:75%;">		
                Inscrire votre recherche pour trouver un fournisseur.
            </div>
    </div>
	<div class='dw3_form_foot'>
		<button class="grey" onclick="closeSEL_PRD();getElementById('divSEL_PRD_DATA').innerHTML='Inscrire votre recherche pour trouver un fournisseur.';"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>
	</div><br>
</div>

<div id="divSEL_STORAGE" class="divSELECT" style='min-width:330px;min-height:90%;'><input id='whySEL_STORAGE' type='text' value='NEW' style='display:none;'>
    <div id="divSEL_STORAGE_HEADER" class='dw3_form_head'><h3>
	    Sélection ID </h3>
        <button onclick='closeSEL_STORAGE();' class='dw3_form_close'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'>
        <div class="divBOX">
            <input id="selSTORAGE" oninput="getSEL_STORAGE('');" type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" onclick="detectCLICK(event,this);"  placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
        </div><br>
            <div id="divSEL_STORAGE_DATA" style="margin:10px;max-height:75%;">		
                Inscrire votre recherche pour trouver un fournisseur.
            </div>
    </div>
	<div class='dw3_form_foot'>
		<button class="grey" onclick="closeSEL_STORAGE();getElementById('divSEL_STORAGE_DATA').innerHTML='Inscrire votre recherche pour trouver un fournisseur.';"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>
	</div><br>
</div>

<div id="divPARAM"  class="divEDITOR" style="background: rgba(0, 0, 0, 0.7);color:white;overflow-y:auto;"></div>
<script type="text/javascript" src="/pub/js/main.js.php?t=<?php echo(rand(100,100000)); echo "&KEY=" . $KEY."&INACTIVE=".$USER_INACTIVE; ?>"></script>
<script src="/pub/js/multiavatar.min.js"></script>
<script>
var KEY = '<?php echo($_GET['KEY']); ?>';
LIMIT = '12';
$(document).ready(function ()
    {
		var body = document.body,
		html = document.documentElement;

		var height = Math.max( body.scrollHeight, body.offsetHeight, 
						   html.clientHeight, html.scrollHeight, html.offsetHeight );
		LIMIT = Math.floor((height-150)/55);
			
		getINV("",LIMIT);
        dragElement(document.getElementById('divNEW'));
        dragElement(document.getElementById('divSUPPLY'));
        dragElement(document.getElementById('divSTORAGE'));

});

function closeSUPPLY() {
    document.getElementById('divSUPPLY').style.display = "none";
	document.getElementById("divFADE").style.display = "none";
	document.getElementById("divFADE").style.opacity = "0";   
}
function newSUPPLY() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        modSUPPLY(this.responseText);
	  }
	};
	xmlhttp.open('GET', 'newSUPPLY.php?KEY=' + KEY  , true);
	xmlhttp.send();
}
function openSUPPLY() {
	document.getElementById('divSUPPLY').style.display = "inline-block";
	document.getElementById("divFADE").style.display = "inline-block";
	document.getElementById("divFADE").style.opacity = "0.6";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
			 document.getElementById('supply_data').innerHTML = this.responseText;
	  }
	};
	xmlhttp.open('GET', 'getSUPPLY.php?KEY=' + KEY  , true);
	xmlhttp.send();
}
function modSUPPLY(ID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
			 document.getElementById('supply_data').innerHTML = this.responseText;
	  }
	};
	xmlhttp.open('GET', 'modSUPPLY.php?KEY=' + KEY + '&ID=' + ID , true);
	xmlhttp.send();
}
function updSUPPLY(ID) {
	var sNAME = document.getElementById("spNAME").value;
	var GRPBOX = document.getElementById("spTYPE");
	var sTYPE  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var sDEPTH = document.getElementById("spDEPTH").value;
	var sWIDTH = document.getElementById("spWIDTH").value;
	var sHEIGHT = document.getElementById("spHEIGHT").value;
	var sWEIGHT = document.getElementById("spWEIGHT").value;

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("Modification terminée.");
        openSUPPLY();
	  }
	};
		xmlhttp.open('GET', 'updSUPPLY.php?KEY=' + KEY 
        + '&ID=' + ID
        + '&NAME=' + sNAME
        + '&TYPE=' + sTYPE
        + '&WIDTH=' + sWIDTH
        + '&HEIGHT=' + sHEIGHT
        + '&DEPTH=' + sDEPTH
        + '&WEIGHT=' + sWEIGHT
        , true);
		xmlhttp.send();	
}

function delSUPPLY(ID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
	    addNotif("Suppression terminée.");
        openSUPPLY();
	  }
	};
	xmlhttp.open('GET', 'delSUPPLY.php?KEY=' + KEY + '&ID=' + ID , true);
	xmlhttp.send();
}
function closeSTORAGE() {
    document.getElementById('divSTORAGE').style.display = "none";
	document.getElementById("divFADE").style.display = "none";
	document.getElementById("divFADE").style.opacity = "0";   
}
function newSTORAGE() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        modSTORAGE(this.responseText);
	  }
	};
	xmlhttp.open('GET', 'newSTORAGE.php?KEY=' + KEY  , true);
	xmlhttp.send();
}
function openSTORAGE() {
	document.getElementById('divSTORAGE').style.display = "inline-block";
	document.getElementById("divFADE").style.display = "inline-block";
	document.getElementById("divFADE").style.opacity = "0.6";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
			 document.getElementById('storage_data').innerHTML = this.responseText;
	  }
	};
	xmlhttp.open('GET', 'getSTORAGE.php?KEY=' + KEY  , true);
	xmlhttp.send();
}
function modSTORAGE(ID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
			 document.getElementById('storage_data').innerHTML = this.responseText;
	  }
	};
	xmlhttp.open('GET', 'modSTORAGE.php?KEY=' + KEY + '&ID=' + ID , true);
	xmlhttp.send();
}
function updSTORAGE(ID) {
	var GRPBOX = document.getElementById("stLOCATION");
	var sLOCATION  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var sLEVEL = document.getElementById("stLEVEL").value;
	var sLOCAL = document.getElementById("stLOCAL").value;
	var sROW = document.getElementById("stROW").value;
	var sSHELF = document.getElementById("stSHELF").value;
	var sSECTION = document.getElementById("stSECTION").value;

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("Modification terminée.");
        openSTORAGE();
	  }
	};
		xmlhttp.open('GET', 'updSTORAGE.php?KEY=' + KEY 
        + '&ID=' + ID
        + '&LOCATION=' + sLOCATION
        + '&LEVEL=' + sLEVEL
        + '&LOCAL=' + sLOCAL
        + '&ROW=' + sROW
        + '&SHELF=' + sSHELF
        + '&SECTION=' + sSECTION
        , true);
		xmlhttp.send();	
}

function delSTORAGE(ID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
	    addNotif("Suppression terminée.");
        openSTORAGE();
	  }
	};
	xmlhttp.open('GET', 'delSTORAGE.php?KEY=' + KEY + '&ID=' + ID , true);
	xmlhttp.send();
}

function openPARAM() {
	document.getElementById('divPARAM').style.display = "inline-block";
	document.getElementById("divFADE").style.display = "inline-block";
	document.getElementById("divFADE").style.opacity = "0.6";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 var sOBJ = this.responseText;
		 if (sOBJ != ""){
			 document.getElementById('divPARAM').innerHTML = sOBJ;
		 }
	  }
	};
	xmlhttp.open('GET', 'getPARAM.php?KEY=' + KEY  , true);
	xmlhttp.send();
}

function toggleFolder(sub,up){
	if(document.getElementById(sub).style.height=="0px"){
		document.getElementById(up).innerHTML="folder_open";
		document.getElementById(sub).style.height="auto";
		document.getElementById(sub).style.display="inline-block";
	} else {
		document.getElementById(up).innerHTML="folder";
		document.getElementById(sub).style.height="0px";
		document.getElementById(sub).style.display="none";
	}
}


function deleteTRF(ID) {
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "1";
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"];?><br><br><button style='background:red;' onclick='delTRF(" + ID + ");'><span class='material-icons' style='vertical-align:middle;'>delete</span><?php echo $dw3_lbl["DEL"];?></button> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"];?></button>";
}
function delTRF(ID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
				//document.getElementById("divFADE").style.width = "100%";
				//document.getElementById("divMSG").style.display = "inline-block";
				//document.getElementById("divMSG").innerHTML = "Suppression réussi.<br><br><button onclick='closeMSG();closeEDITOR();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				getINV("",LIMIT);
                getPRD(selectedPRD);
                //closeEDITOR();
                closeMSG();
                addNotif("Suppression du transfert #" + ID + " terminée");
		  } else {
				document.getElementById("divFADE").style.width = "100%";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'delTRF.php?KEY=' + KEY + '&ID=' + ID , true);
		xmlhttp.send();	
}
var selectedPRD = "";
function getPRD(prID) {
    selectedPRD = prID;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		//const elmnt = document.createElement("div");
		//elmnt.setAttribute("id", "divEDIT");
		//elmnt.classList.add('divEDITOR');
		//elmnt.style.height="95%";
		//elmnt.innerHTML = this.responseText;
		//document.body.appendChild(elmnt);
  		document.getElementById("divEDIT").style.height = "95%";
		document.getElementById("divEDIT").innerHTML = this.responseText;
		document.getElementById("divEDIT").style.display = "inline-block";
		window.scrollTo({
		  top: 0,
		  left: 0,
		  behavior: 'smooth'
		});
        dragElement(document.getElementById('divEDIT'));
	  }
	};
	document.getElementById("divFADE").style.opacity = "0.7";
	document.getElementById("divFADE").style.display = "inline-block";
		xmlhttp.open('GET', 'getPRD.php?KEY=' + KEY + '&prID=' + prID , true);
		xmlhttp.send();
		
}
function getINV(sOFFSET,sLIMIT) {
	var sS = document.getElementById("inputSEARCH").value;
	var GRPBOX  = document.getElementById("selCAT");
	var sCAT  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX  = document.getElementById("selKIND");
	var sKIND  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX  = document.getElementById("selFRN1");
	var sFRN1  = GRPBOX.options[GRPBOX.selectedIndex].value;

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divMAIN").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getINV.php?KEY=' + KEY + '&CAT='  + sCAT 
												+ '&FRN1=' + sFRN1
												+ '&SS=' + sS 
												+ '&KIND=' + sKIND 
												+ '&OFFSET=' + sOFFSET 
												+ '&LIMIT=' + sLIMIT 
												, true);
		xmlhttp.send();
		
}
function getTRF(ID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 addMsg(this.responseText);
	  }
	};
		xmlhttp.open('GET', 'getTRF.php?KEY=' + KEY + '&ID='  + ID, true);
		xmlhttp.send();
		
}

function scanUPC(){
	var prUPC = document.getElementById("newPRD").value;
    if (prUPC.length < 12){return;}
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.trim() != ""){
                result = JSON.parse(this.responseText);
                document.getElementById("newSTORAGE").focus();
                //document.getElementById("newPRD").disabled = true;
                document.getElementById("newPRD").value = result[0];
                //document.getElementById("imgNEW").src = result[2];
                document.getElementById("newQTE").value = result[3];
		  }
	  }
	};
		xmlhttp.open('GET', 'scanUPC.php?KEY=' + KEY  
										+ '&UPC=' + prUPC ,   
										true);
		xmlhttp.send();
}

function getPRD_INFO(sID){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.trim() != ""){
                result = JSON.parse(this.responseText);
                document.getElementById("newSTORAGE").focus();
                //document.getElementById("newPRD").disabled = true;
                document.getElementById("newPRD").value = result[0];
                //document.getElementById("imgNEW").src = result[2];
                document.getElementById("newQTE").value = result[3];
		  }
	  }
	};
		xmlhttp.open('GET', 'dw3_prd_info.php?KEY=' + KEY + '&ID=' + sID ,   
										true);
		xmlhttp.send();
}

function newTRF(){
	var sORDER = document.getElementById("newORDER").value;
	var sPURCHASE = document.getElementById("newPURCHASE").value;
	var sPRD = document.getElementById("newPRD").value;
	var sSTORAGE = document.getElementById("newSTORAGE").value;
	var sQTE = document.getElementById("newQTE").value;
	var GRPBOX = document.getElementById("newKIND");
	var sKIND = GRPBOX.options[GRPBOX.selectedIndex].value;
	if (sPRD == ""){
		document.getElementById("newPRD").style.boxShadow = "5px 10px 15px red";
		document.getElementById("newPRD").focus();
		return;
	} else {
		document.getElementById("newPRD").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
	}	
	if (sSTORAGE == ""){
		document.getElementById("newSTORAGE").style.boxShadow = "5px 10px 15px red";
		document.getElementById("newSTORAGE").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("newSTORAGE").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
		//document.getElementById("lblPRD").innerHTML = "";
	}	
    if (sQTE == "" || sQTE == "0"){
		document.getElementById("newQTE").style.boxShadow = "5px 10px 15px red";
		document.getElementById("newQTE").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("newQTE").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
		//document.getElementById("lblPRD").innerHTML = "";
	}	

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
            closeMSG();
            document.getElementById("newORDER").value = "";
            document.getElementById("newPURCHASE").value = "";
            document.getElementById("newPRD").value = "";
            document.getElementById("newSTORAGE").value = "";
            document.getElementById("newQTE").value = "";
            getINV("",LIMIT);
            getPRD(sPRD);
            closeNEW();
            addNotif("Transfert de " + sPRD + " " + sQTE +  "x terminé");
		  } else {
				document.getElementById("divFADE").style.width = "100%";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET','newTRF.php?KEY='+KEY+'&KIND='+encodeURIComponent(sKIND)+'&PRD='+encodeURIComponent(sPRD)+'&STORAGE='+encodeURIComponent(sSTORAGE)+'&QTE='+encodeURIComponent(sQTE)+'&PURCHASE='+encodeURIComponent(sPURCHASE)+'&ORDER='+encodeURIComponent(sORDER),true);
		xmlhttp.send();
}

function updPRM(){
	var GRPBOX = document.getElementById("prmLIMIT");
	var prmLIMIT = GRPBOX.options[GRPBOX.selectedIndex].value;
	//var GRPBOX = document.getElementById("prmRECH_COL");
	//var prmRECH_COL = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var GRPBOX = document.getElementById("prmORDERBY");
	var prmORDERBY = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX = document.getElementById("prmORDERWAY");
	var prmORDERWAY = GRPBOX.options[GRPBOX.selectedIndex].value;
	if (document.getElementById("DSP_COL_ID").checked == false){            var dspID = 0; } else {             var dspID = 1; }
	//if (document.getElementById("DSP_COL_STAT").checked == false){          var dspSTAT = 0; } else {           var dspSTAT = 1; }
	if (document.getElementById("DSP_COL_NOM").checked == false){           var dspNOM  = 0; } else {           var dspNOM  = 1; }
	if (document.getElementById("DSP_COL_DESC").checked == false){          var dspDESC = 0; } else {           var dspDESC = 1; }
	if (document.getElementById("DSP_COL_CAT").checked == false){           var dspCAT  = 0; } else {           var dspCAT  = 1; }
	if (document.getElementById("DSP_COL_FRN1").checked == false){          var dspFRN1 = 0; } else {           var dspFRN1 = 1; }
	if (document.getElementById("DSP_COL_PACK").checked == false){          var dspPACK = 0; } else {           var dspPACK = 1; }
	if (document.getElementById("DSP_COL_KG").checked == false){            var dspKG = 0; } else {             var dspKG = 1; }
	if (document.getElementById("DSP_COL_WIDTH").checked == false){         var dspWIDTH = 0; } else {          var dspWIDTH = 1; }
	if (document.getElementById("DSP_COL_HEIGHT").checked == false){        var dspHEIGHT = 0; } else {         var dspHEIGHT = 1; }
	if (document.getElementById("DSP_COL_DEPTH").checked == false){         var dspDEPTH = 0; } else {          var dspDEPTH = 1; }
	if (document.getElementById("DSP_COL_JOURS_CONSERV").checked == false){ var dspJOURS_CONSERV = 0; } else {  var dspJOURS_CONSERV = 1; }
	if (document.getElementById("DSP_COL_TOTAL").checked == false){      	var dspTOTAL = 0; } else {       	var dspTOTAL = 1; }
	//if (document.getElementById("DSP_COL_PRIX_VTE").checked == false){      var dspPRIX_VTE = 0; } else {       var dspPRIX_VTE = 1; }
	//if (document.getElementById("DSP_COL_PRIX_ACH").checked == false){      var dspPRIX_ACH = 0; } else {       var dspPRIX_ACH = 1; }
	if (document.getElementById("DSP_COL_DTAD").checked == false){          var dspDTAD = 0; } else {           var dspDTAD = 1; }
	if (document.getElementById("DSP_COL_DTMD").checked == false){          var dspDTMD = 0; } else {           var dspDTMD = 1; }
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		   //alert (this.responseText);
		  if (this.responseText == ""){
				//document.getElementById("divMSG").style.display = "inline-block";
				//document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["MODIFIED"];?><br><br><button onclick='closeMSG();closeEDITOR();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				closeMSG();
				closeEDITOR();
				getINV('',LIMIT);
		  } else {
			  	document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updPRM.php?KEY=' + KEY 
										+ '&LIMIT=' 	+ prmLIMIT
										+ '&ORDW='	+ prmORDERWAY
										+ '&ORDB='	+ prmORDERBY
										+ '&ID=' 	+ dspID
										+ '&NOM='	+ dspNOM  
										+ '&DESC=' 	+ dspDESC
										+ '&CAT=' 	+ dspCAT
										+ '&FRN1=' 	+ dspFRN1
										+ '&PACK=' 	+ dspPACK
										+ '&KG=' 	+ dspKG 
										+ '&WIDTH=' + dspWIDTH
										+ '&HEIGHT='+ dspHEIGHT
										+ '&DEPTH=' + dspDEPTH
										+ '&JOURS=' + dspJOURS_CONSERV
										+ '&TOTAL=' + dspTOTAL
										+ '&DTAD=' 	+ dspDTAD
										+ '&DTMD=' 	+ dspDTMD,
										true);
		xmlhttp.send();
		document.getElementById("divFADE").style.display = "inline-block";
		document.getElementById("divFADE").style.opacity = "0.4";
}

//SELECTION PRODUIT
function getSEL_PRD(sS) {
	if(sS==""){sS = document.getElementById("selPRD").value.trim();}
    why = document.getElementById("whySEL_PRD").value.trim();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divSEL_PRD_DATA").innerHTML = this.responseText;
         dragElement(document.getElementById('divSEL_PRD'));
	  }
	};
    xmlhttp.open('GET', 'getSEL_PRD.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim()) + "&why=" + why, true);
    xmlhttp.send();
}
function openSEL_PRD(why) {
    document.getElementById('divSEL_PRD').style.display = "inline-block";
    document.getElementById('whySEL_PRD').value = why;
    getSEL_PRD('');
}
function closeSEL_PRD() {
    document.getElementById('divSEL_PRD').style.display = "none";
}
function validatePRD(prID,why) {
    //var elNEW =  document.getElementById('newPRD');
    //if (typeof(elNEW) != 'undefined' && elNEW != null && why == "NEW") {elNEW.value = prID;}
    //getPRD_INFO(prID);
    //var elUPD =  document.getElementById('rPRODUCT_ID');
    //if (typeof(elUPD) != 'undefined' && elUPD != null && why == "UPD") {elUPD.value = prID;}
    document.getElementById('newPRD').value = prID;
    closeSEL_PRD();
}
//SELECTION STORAGE
function getSEL_STORAGE(sS) {
	if(sS==""){sS = document.getElementById("selSTORAGE").value.trim();}
    why = document.getElementById("whySEL_STORAGE").value.trim();
    selprod = document.getElementById("newPRD").value.trim();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divSEL_STORAGE_DATA").innerHTML = this.responseText;
         dragElement(document.getElementById('divSEL_STORAGE'));
	  }
	};
    xmlhttp.open('GET', 'getSEL_STORAGE.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim()) + "&why=" + why+ "&SP=" + selprod, true);
    xmlhttp.send();
}
function openSEL_STORAGE(why) {
    document.getElementById('divSEL_STORAGE').style.display = "inline-block";
    document.getElementById('whySEL_STORAGE').value = why;
    getSEL_STORAGE('');
}
function closeSEL_STORAGE() {
    document.getElementById('divSEL_STORAGE').style.display = "none";
}
function validateSTORAGE(sID,why) {
    //var elNEW =  document.getElementById('newSTORAGE_ID');
    //if (typeof(elNEW) != 'undefined' && elNEW != null && why == "NEW") {elNEW.value = sID;}
    //var elUPD =  document.getElementById('rPRODUCT_ID');
    //if (typeof(elUPD) != 'undefined' && elUPD != null && why == "UPD") {elUPD.value = prID;}
    document.getElementById('newSTORAGE').value = sID;
    closeSEL_STORAGE();
}
</script>
</body>
</html>
