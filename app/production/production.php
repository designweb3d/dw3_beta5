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
				<input type="search" onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" id="inputSEARCH" oninput="getPROC('',LIMIT);" placeholder="<?php echo $dw3_lbl["RECH"];?>.." title="<?php echo $dw3_lbl["RECH"];?>">
			</td>
			<td style="width:0;min-width:fit-content;margin:0px;padding:0px 0px 0px 5px;text-align:right;">
				<button style="margin:0px 2px 0px 2px;padding:8px;" onclick="openPROCEDURES();"><span class="material-icons">token</span></button>
				<button class="grey" style="margin:0px 2px 0px 2px;padding:8px;" onclick="openPARAM();"><span class="material-icons">settings</span></button>
			 </td>
		</tr>
	</table>
</div>

<div id="divPROCEDURES" class="divEDITOR" style='max-width:450px;height:500px;max-height:500px;'>
	<div id='divPROCEDURES_HEADER' class='dw3_form_head'>
		<h3>Procédures de fabrication</h3>
		<button  class='dw3_form_close' onclick='closePROCEDURES();'><span class='material-icons'>close</span></button>
    </div> 
    <div id='procedures_data' class='dw3_form_data' style='overflow-x:auto;'>
	</div>
    <div id='divNEW_FOOT' class='dw3_form_foot'>
		<button class="grey" onclick="closePROCEDURES();"><span class="material-icons">cancel</span> Fermer</button>
		<?php if($APREAD_ONLY == false) { ?><button class="green" onclick="newPROCEDURE();"><span class="material-icons">add</span> Ajouter</button><?php } ?>
	</div>
</div>

<div id="divMSG"></div>
<div id="divOPT"></div>
<div id='divMAIN' class='divMAIN' style="padding-top:50px;"></div>
<div id='divEDIT' class='divEDITOR' style='max-width:500px;'></div>


<div id='divFILTRE'>
<h3><?php echo $dw3_lbl["FILTER"];?></h3>
		<table style='width:100%'>
		<tr><td>Status</td><td>
		<select id='selSTATUS'>
			<option selected value=''><?php echo $dw3_lbl["ALL"];?></option>
			<?php
				$sql = "SELECT DISTINCT(status)
						FROM production
						ORDER BY status";
				$result = $dw3_conn->query($sql);
				if ($result->num_rows > 0) {	
					while($row = $result->fetch_assoc()) {
						echo "<option value='" . $row["status"]  . "'>" . $row["status"]  . "</option>";
					}
				}
			?>
		</select></td></tr>
		<tr><td><?php echo $dw3_lbl["CAT"];?></td><td>
		<select id='selCAT'>
			<?php
				$sql = "SELECT DISTINCT(category_id), B.name_fr AS catNAME, B.id AS catID
						FROM product A
						LEFT JOIN product_category B ON A.category_id = B.id
						LEFT JOIN procedure_head C ON A.id = C.product_id
                        WHERE A.id IN (SELECT product_id FROM procedure_line)
						ORDER BY catNAME
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

<!-- SELECTION DE PRODUIT -->
<div id="divSEL_PRD" class="divSELECT" style='min-width:330px;max-width:100%;width:80%;min-height:90%;z-index:2800;'>
    <div id="divSEL_PRD_HEADER" class='dw3_form_head'><h2>
	    Sélection de composant</h2>
        <button onclick='closeSEL_PRD();' class='dw3_form_close'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'><input id='whySEL_PRD' type='text' value='HEAD' style='display:none;'>
        <div class="divBOX">
            <input id="selPRD" oninput="getSEL_PRD('');" type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" onclick="detectCLICK(event,this);"  placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
        </div><br>
            <div id="divSEL_PRD_DATA" style="margin:10px;max-height:75%;">		
                Inscrire votre recherche pour trouver un composant.
            </div>
    </div>
	<div class='dw3_form_foot'>
		<button class="grey" onclick="closeSEL_PRD();getElementById('divSEL_PRD_DATA').innerHTML='Inscrire votre recherche pour trouver un composant.';"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>
	</div><br>
</div>

<!-- SELECTION DE PROCEDURE -->
<div id="divSEL_PROCEDURE" class="divSELECT" style='min-width:330px;max-width:100%;width:80%;min-height:90%;'>
    <div id="divSEL_PROCEDURE_HEADER" class='dw3_form_head'><h2>
	    Sélection de procédure</h2>
        <button onclick='closeSEL_PROCEDURE();' class='dw3_form_close'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'>
        <div class="divBOX">
            <input id="selPROCEDURE" oninput="getSEL_PROCEDURE('');" type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" onclick="detectCLICK(event,this);"  placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
        </div><br>
            <div id="divSEL_PROCEDURE_DATA" style="margin:10px;max-height:75%;">		
                Inscrire votre recherche pour trouver une procédure.
            </div>
    </div>
	<div class='dw3_form_foot'>
		<button class="grey" onclick="closeSEL_PROCEDURE();getElementById('divSEL_PROCEDURE_DATA').innerHTML='Inscrire votre recherche pour trouver une procédure.';"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>
	</div><br>
</div>

<!-- SELECTION DE COMMANDE -->
<div id="divSEL_ORDER" class="divSELECT" style='min-width:330px;min-height:90%;'>
    <div id="divSEL_ORDER_HEADER" class='dw3_form_head'><h3>
	    Sélection ID </h3>
        <button onclick='closeSEL_ORDER();' class='dw3_form_close'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'>
        <div class="divBOX">
            <input id="selORDER" oninput="getSEL_ORDER('');" type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" onclick="detectCLICK(event,this);"  placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
        </div><br>
            <div id="divSEL_ORDER_DATA" style="margin:10px;max-height:75%;">		
                Inscrire votre recherche pour trouver une commande.
            </div>
    </div>
	<div class='dw3_form_foot'>
		<button class="grey" onclick="closeSEL_ORDER();getElementById('divSEL_ORDER_DATA').innerHTML='Inscrire votre recherche pour trouver une commande.';"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>
	</div><br>
</div>

<!-- SELECTION D'EMPLACEMENT -->
<div id="divSEL_STORAGE" class="divSELECT" style='min-width:330px;min-height:90%;'>
    <div id="divSEL_STORAGE_HEADER" class='dw3_form_head'><h3>
	    Sélection ID </h3>
        <button onclick='closeSEL_STORAGE();' class='dw3_form_close'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'>
        <div class="divBOX">
            <input id="selSTORAGE" oninput="getSEL_STORAGE('');" type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" onclick="detectCLICK(event,this);"  placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
        </div><br>
            <div id="divSEL_STORAGE_DATA" style="margin:10px;max-height:75%;">		
                Inscrire votre recherche pour trouver un emplacement.
            </div>
    </div>
	<div class='dw3_form_foot'>
		<button class="grey" onclick="closeSEL_STORAGE();getElementById('divSEL_STORAGE_DATA').innerHTML='Inscrire votre recherche pour trouver un emplacement.';"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>
	</div><br>
</div>

<!-- SELECTION DE L'EMBALLAGE -->
<div id="divSEL_SUPPLY" class="divSELECT" style='min-width:330px;min-height:90%;'>
    <div id="divSEL_SUPPLY_HEADER" class='dw3_form_head'><h3>
	    Sélection ID </h3>
        <button onclick='closeSEL_SUPPLY();' class='dw3_form_close'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'>
        <div class="divBOX">
            <input id="selSUPPLY" oninput="getSEL_SUPPLY('');" type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" onclick="detectCLICK(event,this);"  placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
        </div><br>
            <div id="divSEL_SUPPLY_DATA" style="margin:10px;max-height:75%;">		
                Inscrire votre recherche pour trouver un emballage.
            </div>
    </div>
	<div class='dw3_form_foot'>
		<button class="grey" onclick="closeSEL_SUPPLY();getElementById('divSEL_SUPPLY_DATA').innerHTML='Inscrire votre recherche pour trouver un emballage.';"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>
	</div><br>
</div>

<div id="divPARAM"  class="divEDITOR" style="background: rgba(0, 0, 0, 0.7);color:white;overflow-y:auto;">
    <div id='divPARAM_HEADER' class='dw3_form_head'>
        <h2 style='background: rgba(44, 44, 44, 0.9);color:white;'>Paramètres de l'application</h2>
        <button class='dw3_form_close' onclick='closePARAM();'><span class='material-icons'>cancel</span></button>
    </div>
    <div class='dw3_form_data' id="divPARAM_DATA"></div>
    <div class='EDIT_FOOT' style='text-align:right;padding:3px;background-image: linear-gradient(to right, rgba(0,0,0,0), rgba(44,44,44,1));'>
        <button class='blue' onclick='resetPRM()' style='margin:0px 2px 0px 2px;'><span class='material-icons'>restart_alt</span></button>
        <button class='grey' onclick='closePARAM()' style='margin:0px 2px 0px 2px;'><span class='material-icons'>cancel</span> Annuler</button>
        <button class='green' onclick='updPRM();' style='margin:0px 10px 0px 2px;'><span class='material-icons'>save</span> Enregistrer</button>
    </div>
</div>

<script type="text/javascript" src="/pub/js/main.js.php?t=<?php echo(rand(100,100000)); echo "&KEY=" . $KEY."&INACTIVE=".$USER_INACTIVE; ?>"></script>
<script src="/pub/js/multiavatar.min.js"></script>
<script>
var KEY = '<?php echo($_GET['KEY']); ?>';
LIMIT = '12';

$(document).ready(function ()
    {
		var body = document.body,
		html = document.documentElement;
		var height = Math.max( body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight );
		LIMIT = Math.floor((height-176)/51);
			
		getPRODUCTIONS("",LIMIT);
        dragElement(document.getElementById('divPARAM'));
        dragElement(document.getElementById('divPROCEDURES'));
        dragElement(document.getElementById('divSEL_PRD'));
        dragElement(document.getElementById('divSEL_PROCEDURE'));
        dragElement(document.getElementById('divSEL_STORAGE'));
        dragElement(document.getElementById('divSEL_ORDER'));

});

//PROCEDURES
function openPROCEDURES() {
	document.getElementById('divPROCEDURES').style.display = "inline-block";
	document.getElementById("divFADE").style.display = "inline-block";
	document.getElementById("divFADE").style.opacity = "0.6";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
			 document.getElementById('procedures_data').innerHTML = this.responseText;
	  }
	};
	xmlhttp.open('GET', 'getPROCEDURES.php?KEY=' + KEY  , true);
	xmlhttp.send();
}

function closePROCEDURES() {
    document.getElementById('divPROCEDURES').style.display = "none";
    //if (document.getElementById('divEDIT').style.display != "inline-block" && document.getElementById('divPROCEDURE').style.display != "inline-block"){
    if (document.getElementById('divEDIT').style.display != "inline-block"){
        document.getElementById("divFADE").style.display = "none";
        document.getElementById("divFADE").style.opacity = "0";   
    }
}

//PROCEDURE
function newPROCEDURE() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        getPROCEDURE(this.responseText);
	  }
	};
	xmlhttp.open('GET', 'newPROCEDURE.php?KEY=' + KEY  , true);
	xmlhttp.send();
}

function getPROCEDURE(ID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		document.getElementById("divEDIT").innerHTML = this.responseText;
		document.getElementById("divEDIT").style.display = "inline-block";
        dragElement(document.getElementById('divEDIT'));
        getPROCEDURE_LINES(ID);
	  }
	};
	document.getElementById("divFADE").style.opacity = "0.7";
	document.getElementById("divFADE").style.display = "inline-block";
    xmlhttp.open('GET', 'getPROCEDURE.php?KEY=' + KEY + '&ID=' + ID , true);
    xmlhttp.send();
}

function updPROCEDURE(procID) {
	var sNOM = document.getElementById("headNOM").value;
	var sPRD = document.getElementById("headPRD").value;
	var sSUPPLY = document.getElementById("headSUPPLY").value;
	var sDELAY = document.getElementById("headDELAY").value;
	var sQ1 = document.getElementById("headQ1").value;
	var sQ2 = document.getElementById("headQ2").value;
	var sQ3 = document.getElementById("headQ3").value;
	var sQ4 = document.getElementById("headQ4").value;

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("Modification terminée.");
        closePROCEDURE();
        openPROCEDURES();
	  }
	};
    xmlhttp.open('GET', 'updPROCEDURE.php?KEY=' + KEY 
    + '&ID=' + procID.trim()
    + '&NOM=' + encodeURIComponent(sNOM)
    + '&PRD=' + sPRD.trim()
    + '&SUPPLY=' + sSUPPLY.trim()
    + '&DELAY=' + sDELAY.trim()
    + '&Q1=' + encodeURIComponent(sQ1)
    + '&Q2=' + encodeURIComponent(sQ2)
    + '&Q3=' + encodeURIComponent(sQ3)
    + '&Q4=' + encodeURIComponent(sQ4)
    , true);
    xmlhttp.send();	
}

function deletePROCEDURE(procID) {
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "1";
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"];?><div style='height:20px;'> </div> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"];?></button> <button class='red' onclick='delPROCEDURE(" + procID + ");'><span class='material-icons' style='vertical-align:middle;'>delete</span><?php echo $dw3_lbl["DEL"];?></button>";
}

function delPROCEDURE(procID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText != ""){
            addMsg(this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        } else {
            addNotif("Suppression terminée.");
            closeEDITOR();
            openPROCEDURES();
            closeMsg();
        }
	  }
	};
	xmlhttp.open('GET', 'delPROCEDURE.php?KEY=' + KEY + '&ID=' + procID , true);
	xmlhttp.send();
}

function closePROCEDURE() {
    document.getElementById('divEDIT').style.display = "none";
    if (document.getElementById('divPROCEDURES').style.display != "inline-block"){
        document.getElementById("divFADE").style.display = "none";
        document.getElementById("divFADE").style.opacity = "0";   
    }
}

//PROCEDURE_LINES
function getPROCEDURE_LINES(procID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		document.getElementById("divEDIT_LINES").innerHTML = this.responseText;
	  }
	};
	document.getElementById("divFADE").style.opacity = "0.7";
	document.getElementById("divFADE").style.display = "inline-block";
    xmlhttp.open('GET', 'getPROCEDURE_LINES.php?KEY=' + KEY + '&ID=' + procID , true);
    xmlhttp.send();
}

function newPROCEDURE_LINE(procID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        getPROCEDURE_LINE(this.responseText);
        getPROCEDURE_LINES(procID);
	  }
	};
	xmlhttp.open('GET', 'newPROCEDURE_LINE.php?KEY=' + KEY + '&ID=' + procID, true);
	xmlhttp.send();
}

function getPROCEDURE_LINE(lineID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addMsg(this.responseText);
	  }
	};
	xmlhttp.open('GET', 'getPROCEDURE_LINE.php?KEY=' + KEY + '&ID=' + lineID, true);
	xmlhttp.send();
}

function updPROCEDURE_LINE(procID,lineID) {
	var sQTY = document.getElementById("lineQTY").value;
	var sPRD= document.getElementById("linePRD").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("Modification terminée.");
        closeMSG();
        getPROCEDURE_LINES(procID);
	  }
	};
	xmlhttp.open('GET', 'updPROCEDURE_LINE.php?KEY=' + KEY 
	+ '&ID=' + lineID
	+ '&PRD=' + sPRD
	+ '&QTY=' + sQTY
	, true);
	xmlhttp.send();	
}

function delPROCEDURE_LINE(procID,lineID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
	    addNotif("Suppression terminée.");
        getPROCEDURE_LINES(procID);
	  }
	};
	xmlhttp.open('GET', 'delPROCEDURE.php?KEY=' + KEY + '&ID=' + lineID , true);
	xmlhttp.send();
}


//PRODUCTION
function getPRODUCTIONS(sOFFSET,sLIMIT) {
    if (document.getElementById("inputSEARCH")){
        var sS = document.getElementById("inputSEARCH").value;
    } else {
        var sS = ""; 
    }
    if (document.getElementById("selCAT")){
        var GRPBOX  = document.getElementById("selCAT");
        var sCAT  = GRPBOX.options[GRPBOX.selectedIndex].value;
    } else {
        var sCAT = ""; 
    }
    if (document.getElementById("selSTAT")){
        var GRPBOX  = document.getElementById("selSTAT");
        var sSTAT  = GRPBOX.options[GRPBOX.selectedIndex].value;
    } else {
        var sSTAT = ""; 
    }
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		document.getElementById("divMAIN").innerHTML = this.responseText;
	  }
	};
    xmlhttp.open('GET', 'getPRODUCTIONS.php?KEY=' + KEY
    + '&CAT='  + sCAT 
    + '&SS=' + sS 
    + '&STAT=' + sSTAT 
    + '&OFFSET=' + sOFFSET 
    + '&LIMIT=' + sLIMIT 
    , true);
    xmlhttp.send();
}

function newPRODUCTION(procID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        closePROCEDURES();
        getPRODUCTION(this.responseText);
        getPRODUCTIONS("",LIMIT);
	  }
	};
	xmlhttp.open('GET', 'newPRODUCTION.php?KEY=' + KEY + '&procID=' + procID, true);
	xmlhttp.send();
}

function getPRODUCTION(ID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		document.getElementById("divEDIT").innerHTML = this.responseText;
		document.getElementById("divEDIT").style.display = "inline-block";
        dragElement(document.getElementById('divEDIT'));
	  }
	};
	document.getElementById("divFADE").style.opacity = "0.7";
	document.getElementById("divFADE").style.display = "inline-block";
    xmlhttp.open('GET', 'getPRODUCTION.php?KEY=' + KEY + '&ID=' + ID , true);
    xmlhttp.send();
}

function updPROD_STATUS(prodID,prodSTATUS) {
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "1";
		document.getElementById("divMSG").style.display = "inline-block";
		if (prodSTATUS == 'COMPLETED'){
			document.getElementById("divMSG").innerHTML = "Changer le status est irréversible, vérifiez si toutes les informations sont exactes avant de continuer.<div style='height:20px;'> </div> <button class='grey' onclick='closeMSG();'><span class='material-icons'>info</span> Vérifier</button> <button class='green' onclick=\"updPRODUCTION_STATUS('" + prodID + "','" + prodSTATUS + "');\"><span class='material-icons' style='vertical-align:middle;'>delete</span>Terminer la production</button>";
		} else if (prodSTATUS == 'CANCELLED'){
			document.getElementById("divMSG").innerHTML = "Changer le status est irréversible, vérifiez si toutes les informations sont exactes avant de continuer.<div style='height:20px;'> </div> <button class='grey' onclick='closeMSG();'><span class='material-icons'>info</span> Vérifier</button> <button class='red' onclick=\"updPRODUCTION_STATUS('" + prodID + "','" + prodSTATUS + "');\"><span class='material-icons' style='vertical-align:middle;'>delete</span>Annuler la production</button>";
		} else if (prodSTATUS == 'ON_HOLD'){
			updPRODUCTION_STATUS(prodID, prodSTATUS);
		} else if (prodSTATUS == 'IN_PRODUCTION'){
			document.getElementById("divMSG").innerHTML = "Changer le status est irréversible, vérifiez si toutes les informations sont exactes avant de continuer.<div style='height:20px;'> </div> <button class='grey' onclick='closeMSG();'><span class='material-icons'>info</span> Vérifier</button> <button class='blue' onclick=\"updPRODUCTION_STATUS('" + prodID + "','" + prodSTATUS + "');\"><span class='material-icons' style='vertical-align:middle;'>delete</span>Démarrer la production</button>";
		}
}
function updPRODUCTION_STATUS(prodID,prodSTATUS) {
	var sQTY_NEEDED = document.getElementById("prodQTY_NEEDED").value;
	var sQTY_PRODUCED = document.getElementById("prodQTY_PRODUCED").value;
	var sLOT = document.getElementById("prodLOT").value;
	var sORDER = document.getElementById("prodORDER").value;
	var sSTORAGE = document.getElementById("prodSTORAGE").value;
	var sQUALITY_1 = document.getElementById("prodQUALITY_1").value;
	var sQUALITY_2 = document.getElementById("prodQUALITY_2").value;
	var sQUALITY_3 = document.getElementById("prodQUALITY_3").value;
	var sQUALITY_4 = document.getElementById("prodQUALITY_4").value;
	var sSTART = document.getElementById("prodSTART").value;
	var sEND = document.getElementById("prodEND").value;

	if (Number(sQTY_NEEDED) == 0 || sQTY_NEEDED == ""){
		document.getElementById("prodQTY_NEEDED").style.boxShadow = "5px 10px 15px red";
		document.getElementById("prodQTY_NEEDED").focus();
		document.getElementById("lblQTY_NEEDED").innerHTML = "Veuillez entrer une quantité plus grande que zéro.";
		return;
	} else {
		document.getElementById("prodQTY_NEEDED").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
		document.getElementById("lblQTY_NEEDED").innerHTML = "";
	}

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("Modification terminée.");
		closeMSG();
        getPRODUCTION(prodID);
        getPRODUCTIONS("",LIMIT);
	  }
	};
    xmlhttp.open('GET', 'updPRODUCTION_STATUS.php?KEY=' + KEY 
    + '&ID=' + prodID
    + '&STATUS=' + encodeURIComponent(prodSTATUS)
    + '&QTY_NEEDED=' + encodeURIComponent(sQTY_NEEDED)
    + '&QTY_PRODUCED=' + encodeURIComponent(sQTY_PRODUCED)
    + '&LOT=' + encodeURIComponent(sLOT)
    + '&ORDER=' + encodeURIComponent(sORDER)
    + '&STORAGE=' + encodeURIComponent(sSTORAGE)
    + '&QUALITY_1=' + encodeURIComponent(sQUALITY_1)
    + '&QUALITY_2=' + encodeURIComponent(sQUALITY_2)
    + '&QUALITY_3=' + encodeURIComponent(sQUALITY_3)
    + '&QUALITY_4=' + encodeURIComponent(sQUALITY_4)
    + '&START=' + encodeURIComponent(sSTART)
    + '&END=' + encodeURIComponent(sEND)
    , true);
    xmlhttp.send();	

}
function updPRODUCTION(prodID) {
	//var sSTATUS = document.getElementById("prodSTATUS").value;
	var sQTY_NEEDED = document.getElementById("prodQTY_NEEDED").value;
	var sQTY_PRODUCED = document.getElementById("prodQTY_PRODUCED").value;
	var sLOT = document.getElementById("prodLOT").value;
	var sORDER = document.getElementById("prodORDER").value;
	var sSTORAGE = document.getElementById("prodSTORAGE").value;
	var sQUALITY_1 = document.getElementById("prodQUALITY_1").value;
	var sQUALITY_2 = document.getElementById("prodQUALITY_2").value;
	var sQUALITY_3 = document.getElementById("prodQUALITY_3").value;
	var sQUALITY_4 = document.getElementById("prodQUALITY_4").value;
	var sSTART = document.getElementById("prodSTART").value;
	var sEND = document.getElementById("prodEND").value;

	if (sQTY_NEEDED == ""){
		document.getElementById("prodQTY_NEEDED").style.boxShadow = "5px 10px 15px red";
		document.getElementById("prodQTY_NEEDED").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("prodQTY_NEEDED").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
		//document.getElementById("lblPRD").innerHTML = "";
	}

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("Modification terminée.");
        closeEDITOR();
        getPRODUCTIONS("",LIMIT);
	  }
	};
    xmlhttp.open('GET', 'updPRODUCTION.php?KEY=' + KEY 
    + '&ID=' + prodID
    + '&QTY_NEEDED=' + encodeURIComponent(sQTY_NEEDED)
    + '&QTY_PRODUCED=' + encodeURIComponent(sQTY_PRODUCED)
    + '&LOT=' + encodeURIComponent(sLOT)
    + '&ORDER=' + encodeURIComponent(sORDER)
    + '&STORAGE=' + encodeURIComponent(sSTORAGE)
    + '&QUALITY_1=' + encodeURIComponent(sQUALITY_1)
    + '&QUALITY_2=' + encodeURIComponent(sQUALITY_2)
    + '&QUALITY_3=' + encodeURIComponent(sQUALITY_3)
    + '&QUALITY_4=' + encodeURIComponent(sQUALITY_4)
    + '&START=' + encodeURIComponent(sSTART)
    + '&END=' + encodeURIComponent(sEND)
    , true);
    xmlhttp.send();	
}

function infoPROD_STATUS() {
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "1";
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "<b>Modifier le status a un impact sur les quantités en inventaire</b><br><br><div style='text-align:left;'><b>EN COURS:</b> Retire les quantités des composants de l'inventaire.<br><b>TERMINÉ:</b> Ajoute les quantités produites du produit maitre vers l'emplacement définit.<br><small><i>Ces actions sont irréversibles, la seule façon d'ajuster l'inventaire par la suite est par faire des transferts par l'application Inventaire.</i></small></div><div style='height:20px;'> </div> <button class='grey' onclick='closeMSG();'><span class='material-icons'>done</span> Ok</button>";
}
function deletePRODUCTION(procID) {
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "1";
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"];?><div style='height:20px;'> </div> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"];?></button> <button class='red' onclick='delPRODUCTION(" + procID + ");'><span class='material-icons' style='vertical-align:middle;'>delete</span><?php echo $dw3_lbl["DEL"];?></button>";
}

function delPRODUCTION(procID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText != ""){
            addMsg(this.responseText + "<div style='height:20px;'> </div> <button class='grey' onclick='closeMSG();'><span class='material-icons'>done</span> Ok</button>");
        } else {
            addNotif("Suppression terminée.");
            closeEDITOR();
            getPRODUCTIONS("",LIMIT);
			closeMSG();
        }
	  }
	};
	xmlhttp.open('GET', 'delPRODUCTION.php?KEY=' + KEY + '&ID=' + procID , true);
	xmlhttp.send();
}
function closePRODUCTION() {
    document.getElementById('divEDIT').style.display = "none";
    //if (document.getElementById('divPROCEDURES').style.display != "inline-block"){
        document.getElementById("divFADE").style.display = "none";
        document.getElementById("divFADE").style.opacity = "0";   
    //}
}

//PARAMETERS
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

function updPRM(){
	var GRPBOX = document.getElementById("prmLIMIT");
	var prmLIMIT = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX = document.getElementById("prmORDERBY");
	var prmORDERBY = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX = document.getElementById("prmORDERWAY");
	var prmORDERWAY = GRPBOX.options[GRPBOX.selectedIndex].value;
    var GRPBOX = document.getElementById("prmDOC_TYPE");
	var prmDOC_TYPE = GRPBOX.options[GRPBOX.selectedIndex].value;
	if (document.getElementById("DSP_COL_ID").checked == false){            var dspID = 0; } else {             var dspID = 1; }
	if (document.getElementById("DSP_COL_STAT").checked == false){          var dspSTAT = 0; } else {           var dspSTAT = 1; }
	if (document.getElementById("DSP_COL_NOM").checked == false){           var dspNOM  = 0; } else {           var dspNOM  = 1; }
	if (document.getElementById("DSP_COL_CAT").checked == false){           var dspCAT  = 0; } else {           var dspCAT  = 1; }
	if (document.getElementById("DSP_COL_PRD").checked == false){          var dspPRD = 0; } else {           var dspPRD = 1; }
	if (document.getElementById("DSP_COL_PROC").checked == false){          var dspPROC = 0; } else {           var dspPROC = 1; }
	if (document.getElementById("DSP_COL_QTY").checked == false){            var dspQTY = 0; } else {             var dspQTY = 1; }
	if (document.getElementById("DSP_COL_LOT").checked == false){         var dspLOT = 0; } else {          var dspLOT = 1; }
	if (document.getElementById("DSP_COL_ORDER").checked == false){        var dspORDER = 0; } else {         var dspORDER = 1; }
	if (document.getElementById("DSP_COL_STORAGE").checked == false){         var dspSTORAGE = 0; } else {          var dspSTORAGE = 1; }
	if (document.getElementById("DSP_COL_START").checked == false){ var dspSTART = 0; } else {  var dspSTART = 1; }
	if (document.getElementById("DSP_COL_DUE").checked == false){      	var dspDUE = 0; } else {       	var dspDUE = 1; }
	if (document.getElementById("DSP_COL_END").checked == false){          var dspEND = 0; } else {           var dspEND = 1; }
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		   //alert (this.responseText);
		  if (this.responseText == ""){
				//document.getElementById("divMSG").style.display = "inline-block";
				//document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["MODIFIED"];?><br><br><button onclick='closeMSG();closeEDITOR();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				closeMSG();
				closeEDITOR();
				getPROCEDURES('',LIMIT);
		  } else {
			  	document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
    xmlhttp.open('GET', 'updPRM.php?KEY=' + KEY 
    								+ '&DOC_TYPE=' 	+ prmDOC_TYPE
                                    + '&LIMIT=' + prmLIMIT
                                    + '&ORDW='	+ prmORDERWAY
                                    + '&ORDB='	+ prmORDERBY
                                    + '&ID=' 	+ dspID
                                    + '&STAT=' 	+ dspSTAT
                                    + '&NOM='	+ encodeURIComponent(dspNOM)
                                    + '&CAT=' 	+ encodeURIComponent(dspCAT)
                                    + '&PRD=' 	+ dspPRD
                                    + '&PROC=' 	+ dspPROC
                                    + '&QTY=' 	+ dspQTY
                                    + '&LOT=' + dspLOT
                                    + '&ORDER='+ dspORDER
                                    + '&STORAGE=' + dspSTORAGE
                                    + '&DUE=' + encodeURIComponent(dspDUE)
                                    + '&END=' 	+ encodeURIComponent(dspEND)
                                    + '&START=' 	+ encodeURIComponent(dspSTART),
                                    true);
    xmlhttp.send();
    document.getElementById("divFADE").style.display = "inline-block";
    document.getElementById("divFADE").style.opacity = "0.4";
}
function closePARAM() {
    document.getElementById('divPARAM').style.display = "none";
	document.getElementById("divFADE").style.display = "none";
	document.getElementById("divFADE").style.opacity = "0";   
}

//SELECTION PRODUIT
function getSEL_PRD(sS) {
	if(sS==""){sS = document.getElementById("selPRD").value.trim();}
    why = document.getElementById("whySEL_PRD").value.trim();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divSEL_PRD_DATA").innerHTML = this.responseText;
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

function validatePRD(prID,prNAME,why) {
    if (why =="HEAD"){
        document.getElementById('headPRD').value = prID;
        document.getElementById('headPRD_NAME').value = prNAME;
    } else if (why =="LINE"){
		document.getElementById('linePRD').value = prID;
		document.getElementById('linePRD_NAME').value = prNAME;
    }
    closeSEL_PRD();
}

//SELECTION STORAGE
function getSEL_STORAGE(sS) {
	if(sS==""){sS = document.getElementById("selSTORAGE").value.trim();}
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divSEL_STORAGE_DATA").innerHTML = this.responseText;
	  }
	};
    xmlhttp.open('GET', 'getSEL_STORAGE.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim()) , true);
    xmlhttp.send();
}

function openSEL_STORAGE() {
    document.getElementById('divSEL_STORAGE').style.display = "inline-block";
    getSEL_STORAGE('');
}

function closeSEL_STORAGE() {
    document.getElementById('divSEL_STORAGE').style.display = "none";
}

function validateSTORAGE(sID,sDESC) {
    document.getElementById('prodSTORAGE').value = sID;
    document.getElementById('prodSTORAGE_DESC').value = sDESC;
    closeSEL_STORAGE();
}

//SELECTION EMBALLAGE
function getSEL_SUPPLY(sS) {
	if(sS==""){sS = document.getElementById("selSUPPLY").value.trim();}
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divSEL_SUPPLY_DATA").innerHTML = this.responseText;
	  }
	};
    xmlhttp.open('GET', 'getSEL_SUPPLY.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim()) , true);
    xmlhttp.send();
}

function openSEL_SUPPLY() {
    document.getElementById('divSEL_SUPPLY').style.display = "inline-block";
    getSEL_SUPPLY('');
}

function closeSEL_SUPPLY() {
    document.getElementById('divSEL_SUPPLY').style.display = "none";
}

function validateSUPPLY(sID,sNAME) {
    document.getElementById('headSUPPLY').value = sID;
    document.getElementById('headSUPPLY_NAME').value = sNAME;
    closeSEL_SUPPLY();
}

//SELECTION COMMANDE
function getSEL_ORDER(sS) {
	if(sS==""){sS = document.getElementById("selORDER").value.trim();}
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divSEL_ORDER_DATA").innerHTML = this.responseText;
	  }
	};
    xmlhttp.open('GET', 'getSEL_ORDER.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim()), true);
    xmlhttp.send();
}
function openSEL_ORDER() {
    document.getElementById('divSEL_ORDER').style.display = "inline-block";
    getSEL_ORDER('');
}
function closeSEL_ORDER() {
    document.getElementById('divSEL_ORDER').style.display = "none";
}
function validateORDER(sID,sCLI) {
    document.getElementById('prodORDER').value = sID;
    document.getElementById('prodORDER_CLI').value = sCLI;
    closeSEL_ORDER();
}
</script>
</body>
</html>
