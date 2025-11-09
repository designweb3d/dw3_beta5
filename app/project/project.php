<?php /**
 +---------------------------------------------------------------------------------+
 | DW3 PME Kit BETA                                                                |
 | Version 0.1                                                                     |
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
				<input type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" id="inputSEARCH" onkeyup="getPRJS('','',LIMIT);" placeholder="<?php echo $APNAME; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
			</td>
			<td style="width:0;min-width:fit-content;margin:0px;padding:0px 0px 0px 5px;text-align:right;">
				<?php if($APREAD_ONLY == false) { ?><button style="margin:0px 2px 0px 2px;padding:8px;" onclick="openNEW();getCLIS('');getElementById('selCLI').focus();"><span class="material-icons">add</span></button> <?php } ?>
				<button style="margin:0px 2px 0px 2px;padding:8px;background:#555555;" onclick="openPARAM();"><span class="material-icons">settings</span></button>
			 </td>
		</tr>
	</table>
</div>

<div id='divFILTRE'>
<h3><?php echo $dw3_lbl["FILTER"]; ?></h3>
		<table style='width:100%'>
		<tr><td><?php echo $dw3_lbl["STAT"]; ?></td><td width='*'>
		<select id='selSTAT'>
			<option value='0'>À VENIR</option>
			<option value='1'>EN COURS</option>
			<option value='2'>TERMINÉ</option>
			<option value='3'>ANNULÉ</option>
			<option selected value=''><?php echo $dw3_lbl["ALL"]; ?></option>
		</select></td></tr>
		<tr><td><?php echo $dw3_lbl["PAYS"]; ?></td><td>
		<select id='selPAYS'>
			<?php
				$sql = "SELECT DISTINCT(country)
						FROM project
						WHERE country <> '' 
						ORDER  BY country
						LIMIT 100";
				$result = $dw3_conn->query($sql);
				if ($result->num_rows > 0) {	
					while($row = $result->fetch_assoc()) {
						echo "<option value='" . $row["country"]  . "'>" . $row["country"]  . "</option>";
					}
				}
			?>
			<option selected  value=''><?php echo $dw3_lbl["ALL"]; ?></option>
		</select></td></tr>
		<tr><td><?php echo $dw3_lbl["PROV"]; ?></td><td>
		<select id='selPROV'>
			<?php
				$sql = "SELECT DISTINCT(province)
						FROM project 
						WHERE province <> '' 
						ORDER  BY province
						LIMIT 100";
				$result = $dw3_conn->query($sql);
				if ($result->num_rows > 0) {	
					while($row = $result->fetch_assoc()) {
						echo "<option value='" . $row["province"]  . "'>" . $row["province"]  . "</option>";
					}
				}
			?>
			<option selected  value=''><?php echo $dw3_lbl["ALL"]; ?></option>
		</select></td></tr>
		<tr><td><?php echo $dw3_lbl["VILLE"]; ?></td><td>
		<select id='selVILLE'>
			<?php
				$sql = "SELECT DISTINCT(city)
						FROM project
						WHERE city <> '' 
						ORDER  BY city
						LIMIT 100";
				$result = $dw3_conn->query($sql);
				if ($result->num_rows > 0) {	
					while($row = $result->fetch_assoc()) {
						echo "<option value='" . $row["city"]  . "'>" . $row["city"]  . "</option>";
					}
				}
			?>
			<option selected value=''><?php echo $dw3_lbl["ALL"]; ?></option>
		</select></td></tr></table><br>
		<div style='width:100%;text-align:center;'><button style='background:#444;' onclick="closeFILTRE();"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button><button onclick="closeFILTRE();getPRJS('','',LIMIT);"><span class="material-icons">filter_alt</span> <?php echo $dw3_lbl["FILTER"]; ?></button></div>
</div>

<div id='divMAIN' class='divMAIN' style="padding-top:50px;">
<img src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>
</div>

<div id="divEDIT" class="divEDITOR" style='max-width:100%;'>
	<div id="divEDIT_MAIN"></div>
</div>

<div id="divNEW" class="divEDITOR" style='min-width:100px;max-width:400px;min-height:400px;'>
    <div id="divNEW_HEADER" class='dw3_form_head'>
        <h3 style='vertical-align:middle;height:40px;'><div style='display: grid;align-items: center;height:40px;'>Nouveau projet</div></h3>
        <button onclick='closeNEW();' class='dw3_form_close'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'>
        <div class="divBOX"><br>Nom du client:
            <input id="selCLI" onkeyup="getCLIS('');" type="search">
        </div><br>
        <div id="divCLIS" style="margin:10px;max-height:75%;">		
            Faites une recherche pour trouver un client.
        </div><br>
    </div>
	<div  class='dw3_form_foot'>
		<input style="display:none;" id="newCLI" type="text">
		<button class='grey' onclick="closeNEW();getElementById('divCLIS').innerHTML='Faites une recherche pour trouver un client.';"><span class="material-icons">cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button>
	</div>
</div>

<!-- Sélection de commande, facture ou achat pour l'associer au projet -->
<div id="divSEL_ENT" class="divSELECT" style='min-width:330px;min-height:90%;'><input id='whySEL_ENT' type='text' value='NEW' style='display:none;'>
    <div id="divSEL_ENT_HEADER" class='dw3_form_head'><h3>
	    Sélection ID </h3>
        <button onclick='closeSEL_ENT();' class='dw3_form_close'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'>
        <div class="divBOX">Rechercher dans les #ID et les noms:
            <input id="selENT" oninput="getSEL_ENT('');" type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" onclick="detectCLICK(event,this);"  placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
        </div><br>
            <div id="divSEL_ENT_DATA" style="margin:10px;max-height:75%;">		
                Inscrire votre recherche pour trouver une commande.
            </div>
    </div>
	<div class='dw3_form_foot'>
		<button class="grey" onclick="closeSEL_ENT();getElementById('divSEL_ENT_DATA').innerHTML='Inscrire votre recherche pour trouver une commande.';"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>
	</div><br>
</div>

<!-- Sélection de tâche --> 
<div id="divSEL_TASK" class="divSELECT" style='min-width:330px;min-height:90%;'><input id='whySEL_TASK' type='text' value='NEW' style='display:none;'>
    <div id="divSEL_TASK_HEADER" class='dw3_form_head'><h3>
	    Sélection de tâches </h3>
        <button onclick='closeSEL_TASK();' class='dw3_form_close'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'>
        <div class="divBOX">Rechercher:
            <input id="selTASK" oninput="getSEL_TASK('');" type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" onclick="detectCLICK(event,this);"  placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
        </div><br>
            <div id="divSEL_TASK_DATA" style="margin:10px;max-height:75%;">		
                Inscrire votre recherche pour trouver une tâche.
            </div>
    </div>
	<div class='dw3_form_foot'>
		<button class="grey" onclick="closeSEL_TASK();getElementById('divSEL_TASK_DATA').innerHTML='Inscrire votre recherche pour trouver une tâche.';"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>
	</div><br>
</div>

<div id="divPARAM"  class="divEDITOR" style="background: rgba(0, 0, 0, 0.7);color:white;overflow-y:auto;">
    <div id='divNEW_HEADER' class='dw3_form_head'>
        <h2 style='background: rgba(44, 44, 44, 0.9);'>Paramètres de l'application</h2>
        <button class='dw3_form_close' onclick='closeEDITOR(this);'><span class='material-icons'>cancel</span></button>
    </div>
    <div class='dw3_form_data' id="divPARAM_DATA"></div>
    <div class='EDIT_FOOT' style='text-align:right;padding:3px;background-image: linear-gradient(to right, rgba(0,0,0,0), rgba(44,44,44,1));'>
        <button class='blue' onclick='resetPRM()' style='margin:0px 2px 0px 2px;'><span class='material-icons'>restart_alt</span> Réinitialiser</button>
        <button class='grey' onclick='closeEDITOR()' style='margin:0px 2px 0px 2px;'><span class='material-icons'>cancel</span> Annuler</button>
        <button class='green' onclick='updPRM();' style='margin:0px 10px 0px 2px;'><span class='material-icons'>save</span> Enregistrer</button>
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
		const windowWidth = window.innerWidth;
		if (windowWidth >= 900){				   
		    LIMIT = Math.floor((height-176)/36);				   
        } else {
            LIMIT = Math.floor((height-176)/31);
        }				   
		getPRJS('','',LIMIT);
        getCLIS('');
		document.getElementsByTagName("BODY")[0].onresize = function() {bodyResize()};
	//alert ("<?php echo "1:" . $PAGE1 . " 2:" . $PAGE2; ?>");

    dragElement(document.getElementById("divNEW"));
    dragElement(document.getElementById("divSEL_ENT"));
    dragElement(document.getElementById("divSEL_TASK"));
    
	});


function getFCT_FILE(fn) {
    window.open('/sbin/secure_download.php?KEY=' + KEY + '&fn=/fs/invoice/' + fn);
}
function getACH_FILE(fn) {
    window.open('/sbin/secure_download.php?KEY=' + KEY + '&fn=/fs/purchase/' + fn);
}

function bodyResize() {
	var max_width = Math.max(window.innerWidth, document.documentElement.clientWidth, document.body.clientWidth)/100*95;
	var text_width = Math.floor(max_width/335)*335;
		if (text_width=='0'){text_width='335'} 
        if (document.getElementById("prjNOTE")) {
            document.getElementById("prjNOTE").style.width = text_width + "px";
        }
}

	
//_	
var KEY = '<?php echo($_GET['KEY']); ?>';

LIMIT = '12';
function toggleSub(sub,up){
	if(document.getElementById(sub).style.height=="0px"){
		document.getElementById(up).innerHTML="keyboard_arrow_down";
		document.getElementById(sub).style.height="auto";
		document.getElementById(sub).style.display="inline-block";
	} else {
		document.getElementById(up).innerHTML="keyboard_arrow_up";
		document.getElementById(sub).style.height="0px";
		document.getElementById(sub).style.display="none";
	}
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
			 document.getElementById('divPARAM_DATA').innerHTML = sOBJ;
             dragElement(document.getElementById("divPARAM"));
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

function deletePRJ(prjID) {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><br><br><button class='red' onclick=\"delPRJ('" + prjID + "');closeMSG();\"><span class='material-icons' style='vertical-align:middle;'>delete</span><?php echo $dw3_lbl["DEL"]; ?></button> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button>";
}

function delPRJ(prjID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			  if (this.responseText.trim() == ""){
					closeEDITOR();
					//document.getElementById("divMSG").style.display = "inline-block";
					//document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_OK"]; ?><br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
					getPRJS('','',LIMIT);
			  } else {
					document.getElementById("divMSG").style.display = "inline-block";
					document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
			  } 
		  
		}
	};
		xmlhttp.open('GET', 'delPRJ.php?KEY=' + KEY + '&prjID=' + prjID , true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
}
function addQTY() {
    document.getElementById("newQTE").value = Number(document.getElementById("newQTE").value) + 1;
    document.getElementById("newPRD").focus();
}
function subQTY() {
    if (Number(document.getElementById("newQTE").value) > 1 ){
        document.getElementById("newQTE").value = Number(document.getElementById("newQTE").value) - 1;
    }
    document.getElementById("newPRD").focus();
}

function validateCLI(ID,that) {
	var table = document.getElementById("dataCLIS");
		for (var i = 0, row; row = table.rows[i]; i++) {
		      //alert (row.className + " len: " + rows.length);           
			  if (i % 2 == 0) { 
				row.classList.remove("selected");
				row.classList.remove("odd");
				row.className = "even";
			  } else { 
				row.classList.remove("selected"); 
				row.classList.remove("even"); 
				row.className = "odd"; 
			  }       
		} 
	that.className = "selected";
	document.getElementById("newCLI").value = ID;
	//document.getElementById("btnNEW").enabled = true;
    newPRJ();
}

function deletePRJS() {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><br><br><button class='red' onclick='delPRJS();'><span class='material-icons' style='vertical-align:middle;'>delete</span>Delete</button> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span>Annuler</button>";
}
function delPRJS() {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	var sLST = "";

	var frmPRJ  = document.getElementById("frmPRJ");
	var sVIRGULE = "";
	
	for (var i = 0; i < frmPRJ.elements.length; i++ ) 
	{
		if (frmPRJ.elements[i].type == 'checkbox')
		{
			if (frmPRJ.elements[i].checked == true)
			{
				if(sLST != ""){sVIRGULE = ","} else { sLST = "("; }
				sLST += sVIRGULE + frmPRJ.elements[i].value ;
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
				getPRJS('','',LIMIT);
				closeMSG();
                addNotif("Suppression terminée")
		  } else {
				document.getElementById("divFADE").style.width = "100%";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				getPRJS('','',LIMIT);
		  } 
	  }
	};
		xmlhttp.open('GET', 'delPRJS.php?KEY=' + KEY + '&LST=' + encodeURIComponent(sLST) , true);
		xmlhttp.send();
}

function getPRJ(ID) {
    document.getElementById("divFADE").style.display = "inline-block";
	document.getElementById("divFADE").style.opacity = "0.4";
	var max_width = Math.max(window.innerWidth, document.documentElement.clientWidth, document.body.clientWidth)/100*95;
	var text_width = Math.floor(max_width/335)*335;
	if (text_width=='0'){text_width='335'} 
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divEDIT_MAIN").innerHTML = this.responseText;
		 document.getElementById("divEDIT").style.display = "inline-block";
         dragElement(document.getElementById("divEDIT"));
		 document.getElementById("divEDIT").scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
         getPRJ_LINES(ID);
	  }
	};
		document.getElementById("divFADE").style.width = "100%";
		xmlhttp.open('GET', 'getPRJ.php?KEY=' + KEY + '&ID=' + ID + '&tw=' + text_width , true);
		xmlhttp.send();
		
}

function upload_FILE(ID) {
    let fileupload = document.getElementById("fileUpload");
    let formData = new FormData();           
    if (fileupload.files[0] != ""){
        formData.append("fileUpload", fileupload.files[0]);
        fetch('uploadILE.php?KEY='+'<?php echo $KEY; ?>'+'&id='+ID, {
        method: "POST", 
        body: formData
        }).then(resp => {
            addNotif("Téléversement du fichier terminé.");
            document.getElementById('fileUpload').value="";
            document.getElementById('fileuploadbtn').removeAttribute("disabled");
        });
    }
}


function getTOTAL(enID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divTOTAL").innerHTML = this.responseText;
        getGTOTAL(enID);
        const sample_image = document.getElementById('fileUpload');
        const sample_imagebtn = document.getElementById('fileuploadbtn');
        sample_imagebtn.addEventListener('click', () => {
            sample_image.click();
        });
        sample_image.addEventListener('change', () => {
            setFCT_FILE(enID);
        });
	  }
	};
		xmlhttp.open('GET', 'getTOTAL.php?KEY=' + KEY + '&enID=' + enID, true);
		xmlhttp.send();	
}

function getGTOTAL(enID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("lbl_total_head").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getGTOTAL.php?KEY=' + KEY + '&enID=' + enID, true);
		xmlhttp.send();
		
}

function getPRJ_LINES(ID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divPRJ_LINES").innerHTML = this.responseText;
         dspTASK_CHART();
	  }
	};
		xmlhttp.open('GET', 'getPRJ_LINES.php?KEY=' + KEY + '&ID=' + ID, true);
		xmlhttp.send();
		
}


function dspTASK_CHART() {
	const ctx = document.getElementById('task_chart');
	const var_label = document.getElementById('var_label').value.split(",");
	const var_data = document.getElementById('var_data').value.split(",");
	const var_colors = document.getElementById('var_colors').value.split(";");
	if (var_label != ""){
		new Chart(ctx, {
			type: 'polarArea',
			data: {
			labels: var_label,
			datasets: [{
				label: 'Progression des tâches',
				data: var_data,
				backgroundColor: var_colors,
				borderWidth: 1
			}]
			},
				options: {
					responsive: false,    
                    scales: {
                    r: { // Radial scale
                        beginAtZero: true, // Ensure the scale starts at zero
                        ticks: {
                            stepSize: 1 // Set the step size to 5 units
                        }
                    }
                },
			}
		});
		ctx.style.display = "inline-block";
	} else {
		ctx.style.display = "none";
	}
}

function getPRJS(prjSTAT,sOFFSET,sLIMIT) {
	var sS = document.getElementById("inputSEARCH").value;
	
	//STAT
	if (prjSTAT.trim() == ""){
		var GRPBOX = document.getElementById("selSTAT");
		var prjSTAT = GRPBOX.options[GRPBOX.selectedIndex].value;		
	}
	//PAYS
	var GRPBOX = document.getElementById("selPAYS");
	var prjPAYS = GRPBOX.options[GRPBOX.selectedIndex].value;	
	//PROV
	var GRPBOX = document.getElementById("selPROV");
	var prjPROV = GRPBOX.options[GRPBOX.selectedIndex].value;	
	//VILLE
	var GRPBOX = document.getElementById("selVILLE");
	var prjVILLE = GRPBOX.options[GRPBOX.selectedIndex].value;	


	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divMAIN").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getPRJS.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim())
									+ '&prjSTAT=' + prjSTAT
									+ '&prjPAYS=' + prjPAYS
									+ '&prjPROV=' + prjPROV
									+ '&prjVILLE=' + prjVILLE
									+ '&OFFSET=' + sOFFSET 
									+ '&LIMIT=' + sLIMIT  
									, true);
		xmlhttp.send();
		
}

//SELECTION COMMANDE, ACHAT POUR LE PROJET
function getSEL_ENT(LOOK_FOR) {
	if(LOOK_FOR==""){LOOK_FOR = document.getElementById("selENT").value.trim();}
    sDB = document.getElementById("whySEL_ENT").value.trim();
    sPRJ = document.getElementById("prjID").value.trim();
    sCLI = document.getElementById("prjCLI").value.trim();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divSEL_ENT_DATA").innerHTML = this.responseText;
	  }
	};
    xmlhttp.open('GET', 'getSEL_ENT.php?KEY=' + KEY + '&LOOK_FOR=' + encodeURIComponent(LOOK_FOR.trim()) + "&DB=" + sDB + "&PRJ="  +sPRJ + "&CLI="+sCLI , true);
    xmlhttp.send();
}
function openSEL_ENT(sDB) {
    document.getElementById('divSEL_ENT').style.display = "inline-block";
    document.getElementById('whySEL_ENT').value = sDB;
    getSEL_ENT('');
}
function closeSEL_ENT() {
    document.getElementById('divSEL_ENT').style.display = "none";
}
function validateENT(entID,prjID,sDB,Bypass_Err1) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 //document.getElementById("divCLIS").innerHTML = this.responseText;
		 //getPRJ_LINES(prjID);
		 if (this.responseText == "ERR1"){
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = "Déjà associé à un autre projet. Voulez-vous le modifier quand même?<br><br><button class='grey' onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Non</button><button class='red' onclick=\"closeMSG();validateENT('"+entID+"','"+prjID+"','"+sDB+"','true')\"><span class='material-icons' style='vertical-align:middle;'>done</span> Oui</button>";
		 } else {
			 openSEL_ENT(sDB);
			 getPRJ_LINES(prjID);
		 }
		 //closeSEL_ENT();
	  }
	};
		xmlhttp.open('GET', 'updENT_PRJ.php?KEY=' + KEY + '&ID=' + entID + '&PRJ=' + prjID + '&DB=' + sDB + '&BP1=' + Bypass_Err1, true);
		xmlhttp.send();
}
//SELECTION de TâCHE
function getSEL_TASK(LOOK_FOR) {
	if(LOOK_FOR==""){LOOK_FOR = document.getElementById("selTASK").value.trim();}
    sPRJ = document.getElementById("prjID").value.trim();
    sCLI = document.getElementById("prjCLI").value.trim();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divSEL_TASK_DATA").innerHTML = this.responseText;
	  }
	};
    xmlhttp.open('GET', 'getSEL_TASK.php?KEY=' + KEY + '&LOOK_FOR=' + encodeURIComponent(LOOK_FOR.trim()) + "&PRJ="  +sPRJ + "&CLI="+sCLI , true);
    xmlhttp.send();
}
function openSEL_TASK() {
    document.getElementById('divSEL_TASK').style.display = "inline-block";
    getSEL_TASK('');
}
function closeSEL_TASK() {
    document.getElementById('divSEL_TASK').style.display = "none";
}
function validateTASK(taskID,prjID,cliID,Bypass_Err1) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 //document.getElementById("divCLIS").innerHTML = this.responseText;
		 //getPRJ_LINES(prjID);
		 if (this.responseText == "ERR1"){
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = "Déjà associé à un autre projet. Voulez-vous le modifier quand même?<br><br><button class='grey' onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Non</button><button class='red' onclick=\"closeMSG();validateTASK('"+taskID+"','"+prjID+"','"+sDB+"','true')\"><span class='material-icons' style='vertical-align:middle;'>done</span> Oui</button>";
		 } else {
			 openSEL_TASK();
			 getPRJ_LINES(prjID);
		 }
		 //closeSEL_ENT();
	  }
	};
		xmlhttp.open('GET', 'updTASK_PRJ.php?KEY=' + KEY + '&ID=' + taskID + '&PRJ=' + prjID+ '&CLI=' + cliID + '&BP1=' + Bypass_Err1, true);
		xmlhttp.send();
}

function getCLIS(sS) {
	if(sS==""){sS = document.getElementById("selCLI").value.trim();}
	//if(sS==""){sS="0";}
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divCLIS").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getCLIS.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim()) , true);
		xmlhttp.send();
}

function newPRJ(){
	var cliID  = document.getElementById("newCLI").value;
	
	if (cliID == ""){
		document.getElementById("newCLI").style.boxShadow = "5px 10px 15px red";
		document.getElementById("newCLI").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("newCLI").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
		//document.getElementById("lblPRD").innerHTML = "";
	}	
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.substr(0, 3) != "Err"){
				closeNEW();
				getPRJ(this.responseText.trim());
				document.getElementById("divFADE2").style.display = "none";
				document.getElementById("divFADE2").style.opacity = "0";
				getPRJS('','',LIMIT);
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'newPRJ.php?KEY=' + KEY 
										+ '&CLI=' + encodeURIComponent(cliID)  ,   
										true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
}

function updPRJ(sID){
	var GRPBOX = document.getElementById("prjSTAT");
	var sSTAT = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var sDTAD     = document.getElementById("prjDTAD").value;
	var sDTDU     = document.getElementById("prjDTDU").value;
	var sDESC    = document.getElementById("prjDESC").value;
	var sNOTE    = document.getElementById("prjNOTE").value;
	var sNOM    = document.getElementById("prjNOM").value;
	var sADR    = document.getElementById("prjADR").value;
	var sVILLE   = document.getElementById("prjVILLE").value;
	var sPROV    = document.getElementById("prjPROV").value;
	var sPAYS    = document.getElementById("prjPAYS").value;
	var sCP      = document.getElementById("prjCP").value;

//VERIF ADR1
	if (sADR == ""){
		document.getElementById("prjADR").style.boxShadow = "5px 10px 15px red";
		document.getElementById("prjADR").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("prjADR").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
		//document.getElementById("lblPRD").innerHTML = "";
	}
//VERIF NOM
	if (sNOM == ""){
		document.getElementById("prjNOM").style.boxShadow = "5px 10px 15px red";
		document.getElementById("prjNOM").focus();
		return;
	} else {
		document.getElementById("prjNOM").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
	}	
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		   //alert (this.responseText);
		  if (this.responseText == ""){
				//document.getElementById("divMSG").style.display = "inline-block";
				//document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["MODIFIED"]; ?><br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				getPRJS('','',LIMIT);
				getPRJ(sID);
                closeMSG();
                addNotif("<?php echo $dw3_lbl["MODIFIED"]; ?>");
                //toggleSub('divSub7','up7');
		  } else {
			  	document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updPRJ.php?KEY=' + KEY 
										+ '&ID=' + encodeURIComponent(sID)  
										+ '&NOM=' + encodeURIComponent(sNOM)    
										+ '&STAT=' + encodeURIComponent(sSTAT)    
										+ '&DTAD=' + encodeURIComponent(sDTAD)    
										+ '&DTDU=' + encodeURIComponent(sDTDU)    
										+ '&ADR=' + encodeURIComponent(sADR)   
										+ '&VILLE=' + encodeURIComponent(sVILLE)   
										+ '&PROV=' + encodeURIComponent(sPROV)   
										+ '&PAYS=' + encodeURIComponent(sPAYS)   
										+ '&CP=' + encodeURIComponent(sCP)    
										+ '&DESC=' + encodeURIComponent(sDESC)    
										+ '&NOTE=' + encodeURIComponent(sNOTE)   ,                 
										true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
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
	
	if (document.getElementById("DSP_COL_ID").checked == false){ var dspID = 0; } else { var dspID = 1; }
	if (document.getElementById("DSP_COL_STAT").checked == false){ var dspSTAT = 0; } else { var dspSTAT = 1; }
	if (document.getElementById("DSP_COL_NOM").checked == false){ var dspNOM = 0; } else { var dspNOM = 1; }
	if (document.getElementById("DSP_COL_ADR").checked == false){ var dspADR = 0; } else { var dspADR = 1; }
	if (document.getElementById("DSP_COL_VILLE").checked == false){ var dspVILLE = 0; } else { var dspVILLE = 1; }
	if (document.getElementById("DSP_COL_PROV").checked == false){ var dspPROV = 0; } else { var dspPROV = 1; }
	if (document.getElementById("DSP_COL_PAYS").checked == false){ var dspPAYS = 0; } else { var dspPAYS = 1; }
	if (document.getElementById("DSP_COL_CP").checked == false){ var dspCP = 0; } else { var dspCP = 1; }
	if (document.getElementById("DSP_COL_NOTE").checked == false){ var dspNOTE = 0; } else { var dspNOTE = 1; }
	if (document.getElementById("DSP_COL_DTAD").checked == false){ var dspDTAD = 0; } else { var dspDTAD = 1; }
	if (document.getElementById("DSP_COL_DTDU").checked == false){ var dspDTDU = 0; } else { var dspDTDU = 1; }
	if (document.getElementById("DSP_COL_DTMD").checked == false){ var dspDTMD = 0; } else { var dspDTMD = 1; }

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		   //alert (this.responseText);
		  if (this.responseText == ""){
				//document.getElementById("divMSG").style.display = "inline-block";
				//document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["MODIFIED"]; ?><br><br><button onclick='closeMSG();closeEDITOR();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				getPRJS('','',LIMIT);
				closeEDITOR();
                closeMSG();
                addNotif("<?php echo $dw3_lbl["MODIFIED"]; ?>");
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
										+ '&ID=' 		+ dspID
										+ '&STAT='		+ dspSTAT 
										+ '&NOM='		+ dspNOM  
										+ '&ADR=' 		+ dspADR
										+ '&VILLE=' 	+ dspVILLE
										+ '&PROV=' 		+ dspPROV
										+ '&PAYS=' 		+ dspPAYS
										+ '&CP=' 		+ dspCP 
										+ '&DTAD=' 		+ dspDTAD
										+ '&DTDU=' 		+ dspDTDU
										+ '&DTMD=' 		+ dspDTMD
										+ '&NOTE=' 		+ dspNOTE,
										true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
}

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
</script>
</body>
</html>
<?php $dw3_conn->close(); ?>