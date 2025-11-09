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
				<input type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" id="inputSEARCH" onkeyup="getCMDS('','',LIMIT);" placeholder="<?php echo $APNAME; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
			</td>
			<td style="width:0;min-width:fit-content;margin:0px;padding:0px 0px 0px 5px;text-align:right;">
				<button style="display:none;margin:0px 2px 0px 2px;padding:8px;" onclick="openEXPENSE();"><span class="material-icons">paid</span></button>
				<?php if($APREAD_ONLY == false) { ?><button class='blue' style="margin:0px 2px 0px 2px;padding:8px;" onclick="openNEW();getFRNS('');getElementById('selFRN').focus();"><span class="material-icons">add</span></button> <?php } ?>
				<button class='grey' style="margin:0px 2px 0px 2px;padding:8px;" onclick="openPARAM();"><span class="material-icons">settings</span></button>
			 </td>
		</tr>
	</table>
</div>

<div id='divFILTRE'>
<h3><?php echo $dw3_lbl["FILTER"]; ?></h3>
		<table style='width:100%'>
		<tr><td><?php echo $dw3_lbl["STAT"]; ?></td><td width='*'>
		<select id='selSTAT'>
			<option value='0'><?php echo $dw3_lbl["ACTIF"]; ?></option>
			<option value='1'><?php echo $dw3_lbl["DONE"]; ?></option>
			<option value='2'><?php echo $dw3_lbl["CANCELED"]; ?></option>
			<option selected value=''><?php echo $dw3_lbl["ALL"]; ?></option>
		</select></td></tr>
		<tr><td><?php echo $dw3_lbl["PAYS"]; ?></td><td>
		<select id='selPAYS'>
			<?php
				$sql = "SELECT DISTINCT(country)
						FROM supplier
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
						FROM supplier 
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
						FROM supplier
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
		<div style='width:100%;text-align:center;'><button style='background:#444;' onclick="closeFILTRE();"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button><button onclick="closeFILTRE();getCMDS('','',LIMIT);"><span class="material-icons">filter_alt</span> <?php echo $dw3_lbl["FILTER"]; ?></button></div>
</div>

<div id='divMAIN' class='divMAIN' style="padding-top:50px;">
<img src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>
</div>
<div id="divEXPENSE" class="divEDITOR" style='max-width:100%;z-index:2500;'>
</div>
<div id="divEDIT" class="divEDITOR" style='max-width:100%;'>
	<div id="divEDIT_MAIN"></div>
</div>
<div id="divNEW" class="divEDITOR" style='min-width:100px;max-width:400px;min-height:400px;'>
    <div id="divNEW_HEADER" class='dw3_form_head'>
        <h3 style='vertical-align:middle;height:40px;'><div style='display: grid;align-items: center;height:40px;'><?php echo $dw3_lbl["NEW_ACH"]; ?></div></h3>
        <button onclick='closeNEW();' class='dw3_form_close grey'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'>
        <div class="divBOX"><br><?php echo $dw3_lbl["SUPPLIER"]; ?>:
            <input id="selFRN" onkeyup="getFRNS('');" type="search">
        </div><br>
        <div id="divFRN" style="margin:10px;max-height:75%;">		
            Type in search box to find a supplier.
        </div><br>
    </div>
	<div  class='dw3_form_foot'>
		<input style="display:none;" id="newFRN" type="text">
		<button class="green" onclick="closeNEW();getElementById('divFRN').innerHTML='Type in search box to find a supplier.';"><span class="material-icons">cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button>
	</div>
</div>

<div id="divPARAM"  class="divEDITOR" style="background: rgba(0, 0, 0, 0.7);color:white;overflow-y:auto;">
    <div id='divNEW_HEADER' class='dw3_form_head'>
        <h2 style='background: rgba(44, 44, 44, 0.9);'>Paramètres de l'application</h2>
        <button class='dw3_form_close' onclick='closeEDITOR(this);'><span class='material-icons'>cancel</span></button>
    </div>
    <div class='dw3_form_data' id="divPARAM_DATA"></div>
    <div class='EDIT_FOOT' style='text-align:right;padding:3px;background-image: linear-gradient(to right, rgba(0,0,0,0), rgba(44,44,44,1));'>
        <button class='blue'  onclick='resetPRM()' style='margin:0px 2px 0px 2px;'><span class='material-icons'>restart_alt</span> Réinitialiser</button>
        <button class='grey'  onclick='closeEDITOR()' style='margin:0px 2px 0px 2px;'><span class='material-icons'>cancel</span> Annuler</button>
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
		LIMIT = Math.floor(height/53);				   
		getCMDS('','',LIMIT);
        getFRNS('');
		document.getElementsByTagName("BODY")[0].onresize = function() {bodyResize()};
	//alert ("<?php echo "1:" . $PAGE1 . " 2:" . $PAGE2; ?>");

    dragElement(document.getElementById("divNEW"));
	});


function getFCT_FILE(fn) {
    window.open('/sbin/secure_download.php?KEY=' + KEY + '&fn=/fs/purchase/' + fn);
}

		// Bar chart
/*         new Chart(document.getElementById("bar-chart"), {
            type: 'horizontalBar',
            data: {
            labels: ["En attentes de paiment", "Payés partiellement", "Retard de paiment", "En livraison aujourd'hui", "Livré partiellement"],
            datasets: [
                {
                label: "Nb de commandes",
                backgroundColor: ["#3e95cd", "#8e5ea2","#339933","gold","#ff3300"],
                data: [78,7,34,84,3]
                }
            ]
            },
            options: {
            legend: { display: false },
            title: {
                display: true,
                text: 'Today orders by status chart:'
            }
            }
        }); */
		


function bodyResize() {
	var max_width = Math.max(window.innerWidth, document.documentElement.clientWidth, document.body.clientWidth)/100*95;
	var text_width = Math.floor(max_width/335)*335;
		if (text_width=='0'){text_width='335'} 
	if (document.getElementById("enNOTE")) {
		document.getElementById("enNOTE").style.width = text_width + "px";
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
function newEXPENSELINE() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		openEXPENSE();
	  }
	};
	xmlhttp.open('GET', 'newEXPENSE.php?KEY=' + KEY  , true);
	xmlhttp.send();	
}

function openEXPENSE() {
	document.getElementById('divEXPENSE').style.display = "inline-block";
	document.getElementById("divFADE").style.display = "inline-block";
	document.getElementById("divFADE").style.opacity = "0.6";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 var sOBJ = this.responseText;
		 if (sOBJ != ""){
			 document.getElementById('divEXPENSE').innerHTML = sOBJ;
		 }
	  }
	};
	xmlhttp.open('GET', 'getEXPENSE.php?KEY=' + KEY  , true);
	xmlhttp.send();	
}
function selEXPENSE(line_id) {
	document.getElementById('divEXPENSE').style.display = "inline-block";
	document.getElementById("divFADE").style.display = "inline-block";
	document.getElementById("divFADE").style.opacity = "0.6";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 var sOBJ = this.responseText;
		 if (sOBJ != ""){
			 document.getElementById('divEXPENSE').innerHTML = sOBJ;
		 }
	  }
	};
	xmlhttp.open('GET', 'selEXPENSE.php?KEY=' + KEY +'&ID='+line_id, true);
	xmlhttp.send();	
}
function addEXPENSE(line_id,group_name) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
			addNotif(this.responseText);
			document.getElementById('divEXPENSE').style.display = "none";
			getCMD_LINE(document.getElementById("enID").value);
	  }
	};
	xmlhttp.open('GET', 'addEXPENSE.php?KEY=' + KEY +'&ID='+line_id+'&G='+ encodeURIComponent(group_name), true);
	xmlhttp.send();	
}
function delEXPENSE(xID){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
                addNotif("Suppression du record est terminée");
				openEXPENSE();
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'delEXPENSE.php?KEY=' + KEY 
										+ '&ID=' + xID ,   
										true);
		xmlhttp.send();
}
function modEXPENSE(xID){
	var xNAME = document.getElementById("ES_N_"+xID).value;
	var xKIND = document.getElementById("ES_K_"+xID).value;
	var xCODE = document.getElementById("ES_C_"+xID).value;
	var xAMOUNT = document.getElementById("ES_A_"+xID).value;

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
                addNotif("Mise à jour du record est terminée");
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updEXPENSE.php?KEY=' + KEY 
										+ '&ID=' + xID 
                                        + '&N=' + encodeURIComponent(xNAME)   
                                        + '&K=' + encodeURIComponent(xKIND)  
                                        + '&C=' + encodeURIComponent(xCODE)  
                                        + '&A=' + encodeURIComponent(xAMOUNT) ,   
										true);
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

function deleteCMD(enID) {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><br><br><button style='background:red;' onclick=\"delCMD('" + enID + "');closeMSG();\"><span class='material-icons' style='vertical-align:middle;'>delete</span><?php echo $dw3_lbl["DEL"]; ?></button> <button style='background:#555555;' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button>";
}

function delCMD(enID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			  if (this.responseText.trim() == ""){
					closeEDITOR();
					//document.getElementById("divMSG").style.display = "inline-block";
					//document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_OK"]; ?><br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
					getCMDS('','',LIMIT);
			  } else {
					document.getElementById("divMSG").style.display = "inline-block";
					document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
			  } 
		  
		}
	};
		xmlhttp.open('GET', 'delCMD.php?KEY=' + KEY + '&enID=' + enID , true);
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

function deleteLINE(enID,lgID) {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><br><br><button style='background:red;' onclick='delLINE(" + enID + "," + lgID + ");closeMSG();'><span class='material-icons' style='vertical-align:middle;'>delete</span><?php echo $dw3_lbl["DEL"]; ?></button> <button style='background:#555555;' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button>";
}

function delLINE(enID,lgID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			  if (this.responseText.trim() == ""){
                    getCMD_LINE(enID);
					//document.getElementById("divMSG").style.display = "inline-block";
					//document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_OK"]; ?><br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
					getTOTAL(enID);
                    addNotif("<?php echo $dw3_lbl["DEL_OK"]; ?>");
                    document.getElementById("newPRD").focus();
			  } else {
					document.getElementById("divMSG").style.display = "inline-block";
					document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
			  } 
		  
		}
	};
		xmlhttp.open('GET', 'delLINE.php?KEY=' + KEY + '&enID=' + enID + '&lgID=' + lgID , true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
}

function validateFRN(frID,that) {
	var table = document.getElementById("dataFRNS");
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
	document.getElementById("newFRN").value = frID;
	//document.getElementById("btnNEW").enabled = true;
    newCMD();
}

function deleteCMDS() {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><br><br><button style='background:red;' onclick='delCMDS();'><span class='material-icons' style='vertical-align:middle;'>delete</span>Delete</button> <button style='background:#555555;' onclick='closeMSG();'><span class='material-icons'>cancel</span>Annuler</button>";
}
function delCMDS() {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	var sLST = "";

	var frmCMD  = document.getElementById("frmCMD");
	var sVIRGULE = "";
	
	for (var i = 0; i < frmCMD.elements.length; i++ ) 
	{
		if (frmCMD.elements[i].type == 'checkbox')
		{
			if (frmCMD.elements[i].checked == true)
			{
				if(sLST != ""){sVIRGULE = ","} else { sLST = "("; }
				sLST += sVIRGULE + frmCMD.elements[i].value ;
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
				getCMDS('','',LIMIT);
				closeMSG();
		  } else {
				document.getElementById("divFADE").style.width = "100%";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				getCMDS('','',LIMIT);
		  } 
	  }
	};
		xmlhttp.open('GET', 'delCMDS.php?KEY=' + KEY + '&LST=' + encodeURIComponent(sLST) , true);
		xmlhttp.send();
}

function getCMD(enID) {
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
         scanUPC();
         getCMD_LINE(enID);
         getTOTAL(enID);
         document.getElementById("newPRD").focus();
	  }
	};
		document.getElementById("divFADE").style.width = "100%";
		xmlhttp.open('GET', 'getCMD.php?KEY=' + KEY + '&enID=' + enID + '&tw=' + text_width , true);
		xmlhttp.send();
		
}

function setFCT_FILE(ID) {
    let fileupload = document.getElementById("fileUpload");
    let formData = new FormData();           
    if (fileupload.files[0] != ""){
        formData.append("fileUpload", fileupload.files[0]);
        fetch('uploadFCT_FILE.php?KEY='+'<?php echo $KEY; ?>'+'&id='+ID, {
        method: "POST", 
        body: formData
        }).then(resp => {
            addNotif("Téléversement de la facture d'achat terminé.");
            document.getElementById('fileUpload').value="";
            document.getElementById('fileuploadbtn').removeAttribute("disabled");
            //getCMD(ID);
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

function getCMD_LINE(enID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divCMD_LINE").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getCMD_LINE.php?KEY=' + KEY + '&enID=' + enID, true);
		xmlhttp.send();
		
}

function getCMDS(enSTAT,sOFFSET,sLIMIT) {
	var sS = document.getElementById("inputSEARCH").value;
	
	//STAT
	if (enSTAT.trim() == ""){
		var GRPBOX = document.getElementById("selSTAT");
		var enSTAT = GRPBOX.options[GRPBOX.selectedIndex].value;		
	}
	//PAYS
	var GRPBOX = document.getElementById("selPAYS");
	var enPAYS = GRPBOX.options[GRPBOX.selectedIndex].value;	
	//PROV
	var GRPBOX = document.getElementById("selPROV");
	var enPROV = GRPBOX.options[GRPBOX.selectedIndex].value;	
	//VILLE
	var GRPBOX = document.getElementById("selVILLE");
	var enVILLE = GRPBOX.options[GRPBOX.selectedIndex].value;	


	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divMAIN").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getCMDS.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim())
									+ '&enSTAT=' + enSTAT
									+ '&enPAYS=' + enPAYS
									+ '&enPROV=' + enPROV
									+ '&enVILLE=' + enVILLE
									+ '&OFFSET=' + sOFFSET 
									+ '&LIMIT=' + sLIMIT  
									, true);
		xmlhttp.send();
		
}

function getFRNS(sS) {
	if(sS==""){sS = document.getElementById("selFRN").value.trim();}
	//if(sS==""){sS="0";}
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divFRN").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getFRNS.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim()) , true);
		xmlhttp.send();
}

function newCMD(){
	var frID  = document.getElementById("newFRN").value;
	
	if (frID == ""){
		document.getElementById("newFRN").style.boxShadow = "5px 10px 15px red";
		document.getElementById("newFRN").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("newFRN").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
		//document.getElementById("lblPRD").innerHTML = "";
	}	
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.substr(0, 3) != "Err"){
				closeNEW();
				getCMD(this.responseText.trim());
				document.getElementById("divFADE2").style.display = "none";
				document.getElementById("divFADE2").style.opacity = "0";
				getCMDS('','',LIMIT);
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'newCMD.php?KEY=' + KEY 
										+ '&FRN=' + encodeURIComponent(frID)  ,   
										true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
}

//FONCTION QUE SI ELLE TROUVE UN #UPC AJOUTE UNE LIGNE SINON AFFICHE UNE LISTE DE PRD selon 
function scanUPC(){
    var enID  = document.getElementById("enID").value;
	var prUPC = document.getElementById("newPRD").value;
	var lgQTE = document.getElementById("newQTE").value;

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
				addNEW_by_UPC(prUPC);
                document.getElementById("newPRD").focus();
                document.getElementById("newPRD").select();
                getTOTAL(enID);
		  } else {
				document.getElementById("lstPRD").style.display = "inline-block";
				//document.getElementById("divMSG").style.top = "100px";
				document.getElementById("lstPRD").innerHTML = this.responseText;
		  } 
	  }
	};
		xmlhttp.open('GET', 'scanUPC.php?KEY=' + KEY  
										+ '&UPC=' + prUPC    
										+ '&QTE=' + lgQTE ,   
										true);
		xmlhttp.send();
}
function pay_purchase(){
	var enID  = document.getElementById("enID").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
                writeGLS(enID);
                getCMDS('','',LIMIT);
                addNotif("Paiement ajouté.");
                //closeMSG();
                //getTOTAL(enID);
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'subPrepaidCash.php?KEY=' + KEY 
										+ '&enID=' + enID,   
										true);
		xmlhttp.send();
}

function writeGLS(enID) {
    if (enID == "" && document.getElementById("enID")){
        enID = document.getElementById("enID").value;
    }
    document.getElementById("divFADE").style.display = "inline-block";
	document.getElementById("divFADE").style.opacity = "0.4";
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 addNotif(this.responseText);
         getCMD(enID);
         closeMSG();
	  }
	};
		xmlhttp.open('GET', 'writeGLS.php?KEY=' + KEY + '&enID=' + enID, true);
		xmlhttp.send();
}

function addNEW_by_UPC(prUPC){
	var enID  = document.getElementById("enID").value;
	var lgQTE  = document.getElementById("newQTE").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
				getCMD_LINE(enID);
                addNotif("Produit " + prUPC +  " ajouté " + lgQTE + "x");
                closeMSG();
                getTOTAL(enID);
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'addNEW_by_UPC.php?KEY=' + KEY 
										+ '&enID=' + enID 
                                        + '&prUPC=' + prUPC
                                        + '&lgQTE=' + lgQTE ,   
										true);
		xmlhttp.send();
}
function addBlankLine(){
	var enID  = document.getElementById("enID").value;
	var lgQTE  = document.getElementById("newQTE").value;
	var lgDESC  = document.getElementById("newPRD").value;
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
				getCMD_LINE(enID);
                addNotif("Nouvelle ligne ajouté, quantité: " + lgQTE + "x");
                closeMSG();
                getTOTAL(enID);
                document.getElementById("newPRD").focus();
                document.getElementById("newPRD").select();
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'addNEW_Blank.php?KEY=' + KEY 
										+ '&enID=' + enID 
                                        + '&desc=' + lgDESC
                                        + '&lgQTE=' + lgQTE ,   
										true);
		xmlhttp.send();
}
function addNEW_by_ID(prID){
	var enID  = document.getElementById("enID").value;
	var lgQTE  = document.getElementById("newQTE").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
				getCMD_LINE(enID);
                addNotif("Produit " + prID +  " ajouté " + lgQTE + "x");
                closeMSG();
                getTOTAL(enID);
                document.getElementById("newPRD").focus();
                document.getElementById("newPRD").select();
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'addNEW_by_ID.php?KEY=' + KEY 
										+ '&enID=' + enID 
                                        + '&prID=' + prID
                                        + '&lgQTE=' + lgQTE ,   
										true);
		xmlhttp.send();
}
function updLGN_TPS(lgID){
	var enID  = document.getElementById("enID").value;
    if (document.getElementById("lgTAX_FED_"+lgID).checked == false){ var lgTPS = '0'; } else { var lgTPS = '1'; }
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
				getCMD_LINE(enID);
                addNotif("Mise à jour de la TPS terminée");
                closeMSG();
                getTOTAL(enID);
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updLGN_TPS.php?KEY=' + KEY 
										+ '&ID=' + lgID 
                                        + '&T=' + encodeURIComponent(lgTPS) ,   
										true);
		xmlhttp.send();
}
function updLGN_TVQ(lgID){
	var enID  = document.getElementById("enID").value;
    if (document.getElementById("lgTAX_PROV_"+lgID).checked == false){ var lgTVQ = '0'; } else { var lgTVQ = '1'; }
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
				getCMD_LINE(enID);
                addNotif("Mise à jour de la TPS terminée");
                closeMSG();
                getTOTAL(enID);
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updLGN_TVQ.php?KEY=' + KEY 
										+ '&ID=' + lgID 
                                        + '&T=' + encodeURIComponent(lgTVQ) ,   
										true);
		xmlhttp.send();
}
function updLGN_NAME(lgID){
	var enID  = document.getElementById("enID").value;
	var lgNAME  = document.getElementById("line_name").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
				getCMD_LINE(enID);
                addNotif("Mise à jour de la description est terminée");
                closeMSG();
                getTOTAL(enID);
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updLGN_NAME.php?KEY=' + KEY 
										+ '&ID=' + lgID 
                                        + '&N=' + encodeURIComponent(lgNAME) ,   
										true);
		xmlhttp.send();
}
function updLGN_QTY(lgID,lgQTE){
	var enID  = document.getElementById("enID").value;

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
				getCMD_LINE(enID);
                addNotif("Mise à jour de la quantité terminée");
                closeMSG();
                getTOTAL(enID);
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updLGN_QTY.php?KEY=' + KEY 
										+ '&ID=' + lgID 
                                        + '&QTE=' + lgQTE ,   
										true);
		xmlhttp.send();
}
function updLGN_PRICE(lgID,lgPRICE){
	var enID  = document.getElementById("enID").value;

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
				getCMD_LINE(enID);
                addNotif("Mise à jour du prix terminée");
                closeMSG();
                getTOTAL(enID);
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updLGN_PRICE.php?KEY=' + KEY 
										+ '&ID=' + lgID 
                                        + '&PRICE=' + lgPRICE ,   
										true);
		xmlhttp.send();
}
function delLGN(lgID){
	var enID  = document.getElementById("enID").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
				getCMD_LINE(enID);
                addNotif("Suppression terminée");
                closeMSG();
                getTOTAL(enID);
                toggleSub('divSub2','up2');
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'delLINE.php?KEY=' + KEY 
										+ '&ID=' + lgID,   
										true);
		xmlhttp.send();
}
function sendOrderEmail(){
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divMSG").style.display = "inline-block";
    var usEML  = document.getElementById("enUSEML").value;
    if (usEML != ""){
        document.getElementById("divMSG").innerHTML = "<b style='color:red;'>Une confirmation par courriel a déjà été envoyé.</b><br>Voulez-vous vraiment envoyer une autre confirmation par courriel?<br><br><button onclick='closeMSG();' style='background:#444;'><span class='material-icons' style='vertical-align:middle;'>cancel</span>Annuler</button><button onclick='sendOrderEmail2();'><span class='material-icons' style='vertical-align:middle;'>outgoing_mail</span> Envoyer</button>";
    }else{
        document.getElementById("divMSG").innerHTML = "Voulez-vous vraiment envoyer une confirmation par courriel?<br><br><button onclick='closeMSG();' style='background:#444;'><span class='material-icons' style='vertical-align:middle;'>cancel</span>Annuler</button><button onclick='sendOrderEmail2();'><span class='material-icons' style='vertical-align:middle;'>outgoing_mail</span> Envoyer</button>";
    }
}
function sendOrderEmail2(){
	var enID  = document.getElementById("enID").value;
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;' src='/pub/img/load.gif'>";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
            closeMSG();
            addNotif("Confirmation de commande envoyée");
            getCMDS('','',LIMIT);
            closeEDITOR();
            document.getElementById("divFADE2").style.display = "none";
            document.getElementById("divFADE2").style.opacity = "0";
		  } else  {
            document.getElementById("divMSG").style.display = "inline-block";
            document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'sendOrderEmail.php?KEY=' + KEY 
										+ '&enID=' + enID,   
										true);
		xmlhttp.send();
}
function payMoney(){
	var enID  = document.getElementById("enID").value;
	var AMOUNT  = document.getElementById("cashAMOUNT").value;
    if (AMOUNT == 0){
		document.getElementById("cashAMOUNT").style.boxShadow = "5px 10px 15px red";
		document.getElementById("cashAMOUNT").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("cashAMOUNT").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
		//document.getElementById("lblPRD").innerHTML = "";
	}

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
				//getCMD_LINE(enID);
                addNotif("Paiement de " + AMOUNT + "$ en argent confirmé");
                closeMSG();
                getTOTAL(enID);
                //toggleSub('divSub2','up2');
                document.getElementById("cashAMOUNT").value = 0.00;
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'addPrepaidCash.php?KEY=' + KEY 
										+ '&ID=' + enID  
										+ '&AMOUNT=' + AMOUNT,   
										true);
		xmlhttp.send();
}
function returnMoney(){
	var enID  = document.getElementById("enID").value;
	var AMOUNT  = document.getElementById("cashAMOUNT").value;
    if (AMOUNT == 0){
		document.getElementById("cashAMOUNT").style.boxShadow = "5px 10px 15px red";
		document.getElementById("cashAMOUNT").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("cashAMOUNT").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
		//document.getElementById("lblPRD").innerHTML = "";
	}
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
				//getCMD_LINE(enID);
                addNotif("Remboursement de " + AMOUNT + "$ en argent confirmé");
                closeMSG();
                getTOTAL(enID);
                //toggleSub('divSub2','up2');
                document.getElementById("cashAMOUNT").value = 0.00;
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'subPrepaidCash.php?KEY=' + KEY 
										+ '&ID=' + enID  
										+ '&AMOUNT=' + AMOUNT,   
										true);
		xmlhttp.send();
}
function updCMD(sID){
	//var GRPBOX = document.getElementById("enSTAT");
	//var sSTAT = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var sDTAD     = document.getElementById("enDTAD").value;
	var sDTDU     = document.getElementById("enDTDU").value;
	var sNOTE    = document.getElementById("enNOTE").value;
	var sNOM    = document.getElementById("enNOM").value;
	var sADR1    = document.getElementById("enADR1").value;
	var sADR2    = document.getElementById("enADR2").value;
	var sVILLE   = document.getElementById("enVILLE").value;
	var sPROV    = document.getElementById("enPROV").value;
	var sPAYS    = document.getElementById("enPAYS").value;
	var sCP      = document.getElementById("enCP").value;
	var sPID      = document.getElementById("enPID").value;
	var sPRJ      = document.getElementById("enPRJ").value;

//VERIF ADR1
	if (sADR1 == ""){
		document.getElementById("enADR1").style.boxShadow = "5px 10px 15px red";
		document.getElementById("enADR1").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("enADR1").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
		//document.getElementById("lblPRD").innerHTML = "";
	}
//VERIF NOM
	if (sNOM == ""){
		document.getElementById("enNOM").style.boxShadow = "5px 10px 15px red";
		document.getElementById("enNOM").focus();
		return;
	} else {
		document.getElementById("enNOM").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
	}	
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		   //alert (this.responseText);
		  if (this.responseText == ""){
				//document.getElementById("divMSG").style.display = "inline-block";
				//document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["MODIFIED"]; ?><br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				getCMDS('','',LIMIT);
				//closeEDITOR();
                closeMSG();
                addNotif("<?php echo $dw3_lbl["MODIFIED"]; ?>");
                toggleSub('divSub1','up1');
		  } else {
			  	document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updCMD.php?KEY=' + KEY 
										+ '&ID=' + encodeURIComponent(sID)  
										+ '&PRJ=' + encodeURIComponent(sPRJ)  
										+ '&NOM=' + encodeURIComponent(sNOM)    
										+ '&DTAD=' + encodeURIComponent(sDTAD)    
										+ '&DTDU=' + encodeURIComponent(sDTDU)    
										+ '&ADR1=' + encodeURIComponent(sADR1)   
										+ '&ADR2=' + encodeURIComponent(sADR2)   
										+ '&VILLE=' + encodeURIComponent(sVILLE)   
										+ '&PROV=' + encodeURIComponent(sPROV)   
										+ '&PAYS=' + encodeURIComponent(sPAYS)   
										+ '&CP=' + encodeURIComponent(sCP)    
										+ '&PID=' + encodeURIComponent(sPID)    
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
	if (document.getElementById("DSP_COL_PID").checked == false){ var dspPID = 0; } else { var dspPID = 1; }
	if (document.getElementById("DSP_COL_STAT").checked == false){ var dspSTAT = 0; } else { var dspSTAT = 1; }
	if (document.getElementById("DSP_COL_NOM").checked == false){ var dspNOM = 0; } else { var dspNOM = 1; }
	if (document.getElementById("DSP_COL_ADR1").checked == false){ var dspADR1 = 0; } else { var dspADR1 = 1; }
	if (document.getElementById("DSP_COL_ADR2").checked == false){ var dspADR2 = 0; } else { var dspADR2 = 1; }
	if (document.getElementById("DSP_COL_VILLE").checked == false){ var dspVILLE = 0; } else { var dspVILLE = 1; }
	if (document.getElementById("DSP_COL_PROV").checked == false){ var dspPROV = 0; } else { var dspPROV = 1; }
	if (document.getElementById("DSP_COL_PAYS").checked == false){ var dspPAYS = 0; } else { var dspPAYS = 1; }
	if (document.getElementById("DSP_COL_CP").checked == false){ var dspCP = 0; } else { var dspCP = 1; }
	if (document.getElementById("DSP_COL_NOTE").checked == false){ var dspNOTE = 0; } else { var dspNOTE = 1; }
	if (document.getElementById("DSP_COL_DTAD").checked == false){ var dspDTAD = 0; } else { var dspDTAD = 1; }
	if (document.getElementById("DSP_COL_DTDU").checked == false){ var dspDTDU = 0; } else { var dspDTDU = 1; }
	if (document.getElementById("DSP_COL_DTMD").checked == false){ var dspDTMD = 0; } else { var dspDTMD = 1; }
	if (document.getElementById("DSP_COL_STOT").checked == false){ var dspSTOT = 0; } else { var dspSTOT = 1; }

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		   //alert (this.responseText);
		  if (this.responseText == ""){
				//document.getElementById("divMSG").style.display = "inline-block";
				//document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["MODIFIED"]; ?><br><br><button onclick='closeMSG();closeEDITOR();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				getCMDS('','',LIMIT);
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
										+ '&PID=' 		+ dspPID
										+ '&STAT='		+ dspSTAT 
										+ '&NOM='		+ dspNOM  
										+ '&ADR1=' 		+ dspADR1
										+ '&ADR2=' 		+ dspADR2
										+ '&VILLE=' 	+ dspVILLE
										+ '&PROV=' 		+ dspPROV
										+ '&PAYS=' 		+ dspPAYS
										+ '&CP=' 		+ dspCP 
										+ '&DTAD=' 		+ dspDTAD
										+ '&DTDU=' 		+ dspDTDU
										+ '&DTMD=' 		+ dspDTMD
										+ '&STOT=' 		+ dspSTOT
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