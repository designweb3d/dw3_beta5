<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/menu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/common_header.php'; 
?>

<div id='divHEAD'>
	<table style="width:100%;margin:0px;white-space:nowrap;">
		<tr style="margin:0px;padding:0px;">
			<td width="40"><button style="margin:0px 2px 0px 2px;padding:8px;font-size:0.8em;" onclick="openFILTRE();"><span class="material-icons">filter_alt</span></button></td>
			<td width="*" style="margin:0px;padding:0px;">
				<input type="search" onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" id="inputSEARCH" oninput="getFCTS('','',LIMIT);" placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
			</td>
			<td style="width:0;min-width:fit-content;margin:0px;padding:0px 0px 0px 5px;text-align:right;">
				<?php if($APREAD_ONLY == false) { ?><button class='blue' style="margin:0px 2px 0px 2px;padding:8px;" onclick="openNEW();getCMDS('');getElementById('selCMD').focus();"><span class="material-icons">add</span></button> <?php } ?>
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
			<option value='0'>Non facturé</option>
			<option value='1'>Facturé</option>
			<option value='2'>Payé</option>
			<option value='3'>Annulé</option>
			<option selected value=''><?php echo $dw3_lbl["ALL"]; ?></option>
		</select></td></tr>
		<tr><td>ID Projet</td><td>
		    <input id='selPROJECT' type='number'></td></tr>
		<tr><td>Source</td><td>
		<select id='selSOURCE'>
                <option value='product'>Produits</option>";
                <option value='classified'>Annonces</option>";
    			<option value='' selected><?php echo $dw3_lbl["ALL"]; ?></option>
		</select></td></tr>
		<tr><td><?php echo $dw3_lbl["PAYS"]; ?></td><td>
		<select id='selPAYS'>
			<?php
				$sql = "SELECT DISTINCT(country)
						FROM customer
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
						FROM customer 
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
						FROM customer
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
		<div style='width:100%;text-align:center;'><button class='grey' onclick="closeFILTRE();"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button><button onclick="closeFILTRE();getFCTS('','',LIMIT);"><span class="material-icons">filter_alt</span> <?php echo $dw3_lbl["FILTER"]; ?></button></div>
</div>

<div id='divMAIN' class='divMAIN' style="padding-top:50px;margin-bottom:55px;">
<img style='width:100px;height:auto;border-radius:10px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>
</div>
<div id="divEDIT" class="divEDITOR">
	<div id="divEDIT_MAIN"></div>
</div>
<div id="divNEW" class="divEDITOR" style='width:auto;min-height:300px;'>
    <div id="divNEW_HEADER" style='padding:10px;background: rgba(100, 100, 100, 0.7);cursor:move;width:100%;text-align:left;'>
	    Nouvelle Facture
        <button onclick='closeNEW();' class='dw3_form_close'><span class='material-icons'>close</span></button>
    </div>

	<div class="divBOX"><br>Choisissez une commande:
		<input id="selCMD" oninput="getCMDS('');" type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" onclick="detectCLICK(event,this);"  placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
	</div><br>
		<div id="divCMD" style="margin:10px;max-height:75%;">		
			Type in search box to find a customer.
		</div><br>
	<div  style="display:fixed;bottom:0px;">
		<input style="display:none;" id="newCMD" type="text">
		<button class='grey' onclick="closeNEW();getElementById('divCMD').innerHTML='Type in search box to find a customer.';"><span class="material-icons">cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button>
	</div><br>
</div>

<div id="divPARAM"  class="divEDITOR" style="background: rgba(0, 0, 0, 0.7);color:white;overflow-y:auto;">
    <div id='divPARAM_HEADER' class='dw3_form_head'>
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
var KEY = '<?php echo($KEY); ?>';
var APPID = '<?php echo($APID); ?>';
var dw3_on_open_func = '<?php echo($_GET["of"]??""); ?>';
var dw3_on_open_parm = '<?php echo($_GET["op"]??""); ?>';
LIMIT = '12';
$(document).ready(function ()
    {
		var body = document.body,
		html = document.documentElement;
		var height = Math.max( body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight );
		const windowWidth = window.innerWidth;
		if (windowWidth >= 900){				   
		    LIMIT = Math.floor((height-176)/36);				   
        } else {
            LIMIT = Math.floor((height-176)/31);
        }				   
		getFCTS('','',LIMIT);
        getCMDS('');
		document.getElementsByTagName("BODY")[0].onresize = function() {bodyResize()};
        dragElement(document.getElementById("divNEW"));
        dragElement(document.getElementById("divPARAM"));

        if (dw3_on_open_func == "getFCT"){
            getFCT(dw3_on_open_parm);
        }

});
/* 
new Chart(document.getElementById("bar-chart"), {
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
	if (document.getElementById("divFCT")) {
        let newheight = document.getElementById("divTOTAL").offsetHeight;
        document.getElementById("divFCT").style.bottom = newheight + "px";
    }

	if (document.getElementById("enNOTE")) {
		document.getElementById("enNOTE").style.width = text_width + "px";
	}
}


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

function rewritePDF(fctID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			  if (this.responseText.trim() == ""){
                    addNotif("Un nouveau PDF a été créé.");
			  } else {
					document.getElementById("divMSG").style.display = "inline-block";
					document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
			  } 
		  
		}
	};
		xmlhttp.open('GET', 'rewritePDF.php?KEY=' + KEY + '&enID=' + fctID, true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
}
function addQTY() {
    document.getElementById("newQTE").value = Number(document.getElementById("newQTE").value) + 1;
    //document.getElementById("newPRD").focus();
}
function subQTY() {
    if (Number(document.getElementById("newQTE").value) > 1 ){
        document.getElementById("newQTE").value = Number(document.getElementById("newQTE").value) - 1;
    }
    //document.getElementById("newPRD").focus();
}

function deleteLINE(enID,lgID) {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><div style='height:20px;'> </div><button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button><button class='red' onclick='delLINE(" + enID + "," + lgID + ");closeMSG();'><span class='material-icons' style='vertical-align:middle;'>delete</span><?php echo $dw3_lbl["DEL"]; ?></button> ";
}

function delLINE(enID,lgID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			  if (this.responseText.trim() == ""){
                    getFCT_LINE(enID);
					getTOTAL(enID);
                    addNotif("<?php echo $dw3_lbl["DEL_OK"]; ?>");
			  } else {
					document.getElementById("divMSG").style.display = "inline-block";
					document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
			  } 
		  
		}
	};
		xmlhttp.open('GET', 'delLINE.php?KEY=' + KEY + '&enID=' + enID + '&lgID=' + lgID , true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
}

function validateCMD(ID,that) {
	var table = document.getElementById("dataCMDS");
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
	document.getElementById("newCMD").value = ID;
	//document.getElementById("btnNEW").enabled = true;
    newFCT();
}

//NEST PLUS UTILISÉ
/* function deleteFCTS() {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Voulez-vous vraiment annuler ces factures ? <div style='height:20px;'> </div><button style='background:red;' onclick='delFCTS();'><span class='material-icons' style='vertical-align:middle;'>delete</span>Delete</button> <button style='background:#555555;' onclick='closeMSG();'><span class='material-icons'>cancel</span>Annuler</button>";
}
function delFCTS() { 
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	var sLST = "";

	var frmFCT  = document.getElementById("frmFCT");
	var sVIRGULE = "";
	
	for (var i = 0; i < frmFCT.elements.length; i++ ) 
	{
		if (frmFCT.elements[i].type == 'checkbox')
		{
			if (frmFCT.elements[i].checked == true)
			{
				if(sLST != ""){sVIRGULE = ","} else { sLST = "("; }
				sLST += sVIRGULE + frmFCT.elements[i].value ;
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
				getFCTS('','',LIMIT);
                addNotif("Les factures ont étés annulées.");
				closeMSG();
		  } else {
				document.getElementById("divFADE").style.width = "100%";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				getFCTS('','',LIMIT);
		  } 
	  }
	};
		xmlhttp.open('GET', 'delFCTS.php?KEY=' + KEY + '&LST=' + encodeURIComponent(sLST) , true);
		xmlhttp.send();
} */

function getFCT(enID) {
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
         //scanUPC();
         getFCT_LINE(enID);
         getTRANSACTION(enID);
         getTOTAL(enID);
         //document.getElementById("newPRD").focus();
	  }
	};
		document.getElementById("divFADE").style.width = "100%";
		xmlhttp.open('GET', 'getFCT.php?KEY=' + KEY + '&enID=' + enID + '&tw=' + text_width , true);
		xmlhttp.send();
		
}

function writeGLS(enID) {
    if (enID == "" && document.getElementById("enID")){
        enID = document.getElementById("enID").value;
    }
    document.getElementById("divFADE").style.display = "inline-block";
	document.getElementById("divFADE").style.opacity = "0.4";
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;border-radius:10px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 addNotif(this.responseText);
         getFCTS('','',LIMIT);
         getFCT(enID);
         rewritePDF(enID);
         closeMSG();
	  }
	};
		xmlhttp.open('GET', 'writeGLS.php?KEY=' + KEY + '&enID=' + enID, true);
		xmlhttp.send();
		
}
function getTOTAL(enID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divTOTAL").innerHTML = this.responseText;
         let newheight = document.getElementById("divTOTAL").offsetHeight;
         document.getElementById("divFCT").style.bottom = newheight + "px";
	  }
	};
		xmlhttp.open('GET', 'getTOTAL.php?KEY=' + KEY + '&enID=' + enID, true);
		xmlhttp.send();
		
}
/* function getSTOTAL(ID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("lbl_total_head").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getSTOTAL.php?KEY=' + KEY + '&ID=' + ID, true);
		xmlhttp.send();
		
} */

function getFCT_LINE(enID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divFCT_LINE").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getFCT_LINE.php?KEY=' + KEY + '&enID=' + enID, true);
		xmlhttp.send();
		
}


function getTRANSACTION(enID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divTRANSACTION").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getTRN.php?KEY=' + KEY + '&ID=' + enID, true);
		xmlhttp.send();
		
}

function getFCTS(enSTAT,sOFFSET,sLIMIT) {
	var sS = document.getElementById("inputSEARCH").value;
	var enPROJECT = document.getElementById("selPROJECT").value;
	
	//STAT
	if (enSTAT.trim() == ""){
		var GRPBOX = document.getElementById("selSTAT");
		var enSTAT = GRPBOX.options[GRPBOX.selectedIndex].value;		
	}
	//SOURCE
	var GRPBOX = document.getElementById("selSOURCE");
	var enSOURCE = GRPBOX.options[GRPBOX.selectedIndex].value;	
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
		xmlhttp.open('GET', 'getFCTS.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim())
									+ '&enSTAT=' + enSTAT
									+ '&enSOURCE=' + enSOURCE
									+ '&enPRJ=' + enPROJECT
									+ '&enPAYS=' + enPAYS
									+ '&enPROV=' + enPROV
									+ '&enVILLE=' + enVILLE
									+ '&OFFSET=' + sOFFSET 
									+ '&LIMIT=' + sLIMIT  
									, true);
		xmlhttp.send();
		
}

function getCMDS(sS) {
	if(sS==""){sS = document.getElementById("selCMD").value.trim();}
	//if(sS==""){sS="0";}
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divCMD").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getCMDS.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim()) , true);
		xmlhttp.send();
}

function newFCT(){
	var ID  = document.getElementById("newCMD").value;
	if (ID == ""){
		document.getElementById("newCMD").style.boxShadow = "5px 10px 15px red";
		document.getElementById("newCMD").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("newCMD").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
		//document.getElementById("lblPRD").innerHTML = "";
	}	
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.substr(0, 3) != "Err"){
				closeNEW();
				getFCT(this.responseText.trim());
				document.getElementById("divFADE2").style.display = "none";
				document.getElementById("divFADE2").style.opacity = "0";
				getFCTS('','',LIMIT);
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'newFCT.php?KEY=' + KEY 
										+ '&CMD=' + encodeURIComponent(ID)  ,   
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
function addNEW_by_UPC(prUPC){
	var enID  = document.getElementById("enID").value;
	var lgQTE  = document.getElementById("newQTE").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
				getFCT_LINE(enID);
				getTRANSACTION(enID);
                addNotif("Produit " + prUPC +  " ajouté " + lgQTE + "x");
                closeMSG();
                getTOTAL(enID);
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
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
function addNEW_by_ID(prID){
	var enID  = document.getElementById("enID").value;
	var lgQTE  = document.getElementById("newQTE").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
				getFCT_LINE(enID);
				getTRANSACTION(enID);
                addNotif("Produit " + prID +  " ajouté " + lgQTE + "x");
                closeMSG();
                getTOTAL(enID);
                document.getElementById("newQTE").value = "1";
                document.getElementById("newPRD").focus();
                document.getElementById("newPRD").select();
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
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
function updLGN_QTY(lgID,lgQTE){
	var enID  = document.getElementById("enID").value;

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
				getFCT_LINE(enID);
				getTRANSACTION(enID);
                addNotif("Mise à jour de la quantité terminée");
                closeMSG();
                getTOTAL(enID);
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updLGN_QTY.php?KEY=' + KEY 
										+ '&ID=' + lgID 
                                        + '&QTE=' + lgQTE ,   
										true);
		xmlhttp.send();
}
function stripe_cancel_subscription(orderID,invoiceID){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
				getFCT(invoiceID);
                addNotif("Abonnement annulé.");
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
    xmlhttp.open('GET', 'stripe_cancel_subscription.php?KEY=' + KEY 
                                    + '&orderID=' + orderID ,   
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
				getFCT_LINE(enID);
				getTRANSACTION(enID);
                addNotif("Mise à jour du prix terminée");
                closeMSG();
                getTOTAL(enID);
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
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
				getFCT_LINE(enID);
				getTRANSACTION(enID);
                addNotif("Suppression terminée");
                closeMSG();
                getTOTAL(enID);
                toggleSub('divSub2','up2');
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'delLINE.php?KEY=' + KEY 
										+ '&ID=' + lgID,   
										true);
		xmlhttp.send();
}

//annuler une facture non-facturée
function cancelInvoice(){
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Voulez-vous vraiment ANNULER la facture ?<div style='height:20px;'> </div><button onclick='closeMSG();' class='grey'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Non</button><button class='red' onclick='cancelInvoice2();'><span class='material-icons' style='vertical-align:middle;'>delete</span> Oui annuler</button>";
}
function cancelInvoice2(){
    document.getElementById("divMSG").innerHTML = "Quelle est la raison pour annuler la facture ?<input type='text' id='txtCancelReason'><br><span style='float:left;margin:10px;'><input id='chkCancelCMD' type='checkbox'><label for='chkCancelCMD'> Annuler aussi la commande</label></span><div style='height:20px;'> </div><button onclick='closeMSG();' class='grey'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Fermer</button><button class='red' onclick='cancelInvoice3();'><span class='material-icons' style='vertical-align:middle;'>delete</span> Annuler la facture</button>"; 
}
function cancelInvoice3(){
	var sReason  = document.getElementById("txtCancelReason").value;
    if (sReason == ""){
        document.getElementById("txtCancelReason").style.boxShadow = "0px 0px 3px 5px orange";
        document.getElementById("txtCancelReason").focus();
        return false;
    }

	var enID  = document.getElementById("enID").value;
	var cmdID  = document.getElementById("cmdID").value;
    if (document.getElementById("chkCancelCMD").checked == false){ var is_cmd_canceled = 0; } else { var is_cmd_canceled = 1; }
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;border-radius:10px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
            closeMSG();
            addNotif("Facture annulée.");
            getFCTS('','',LIMIT);
            closeEDITOR();
            rewritePDF(enID);
            document.getElementById("divFADE2").style.display = "none";
            document.getElementById("divFADE2").style.opacity = "0";
		  } else  {
            document.getElementById("divMSG").style.display = "inline-block";
            document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
    xmlhttp.open('GET', 'delFCT.php?KEY=' + KEY + '&ID=' + enID + '&CID=' + cmdID + '&R=' + sReason + '&CC=' + is_cmd_canceled, true);
    xmlhttp.send();
}

//renverser une facture facturée
function reverseInvoice(sPaid,sTotal){
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Voulez-vous vraiment RENVERSER la facture ?<div style='height:20px;'> </div><button onclick='closeMSG();' class='grey'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Non</button> <button class='red' onclick=\"reverseInvoice2('"+sPaid+"','"+sTotal+"');\"><span class='material-icons' style='vertical-align:middle;'>delete</span> Oui renverser</button>";
}
function reverseInvoice2(sPaid,sTotal){
    if (sPaid == "" || sPaid == "0" || sPaid == "0.00" || sPaid == "0.0000"){
        document.getElementById("divMSG").innerHTML = "Quelle est la raison pour renverser la facture ?<input type='text' id='txtCancelReason'><br><span style='float:left;margin:10px;'><input id='chkCancelCMD' type='checkbox'><label for='chkCancelCMD'> Annuler aussi la commande</label></span><div style='height:20px;'> </div><button onclick='closeMSG();' class='grey'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Fermer</button><button class='red' onclick='reverseInvoice3();'><span class='material-icons' style='vertical-align:middle;'>delete</span> Renverser la facture</button>"; 
    } else {
        document.getElementById("divMSG").innerHTML = "Quelle est la raison pour renverser la facture ?<input type='text' id='txtCancelReason'><br><span style='float:left;margin:10px;'><input id='chkCancelCMD' type='checkbox'><label for='chkCancelCMD'> Annuler aussi la commande</label></span><div style='height:20px;'> </div>Quelle est le montant à rembourser?<input type='number' id='txtCancelAmount' value='"+sPaid+"' style='background: url(/pub/img/dw3/arrow-money.png) 99% / 20px no-repeat #EEE;'><br>Payé: <b>"+sPaid+"</b>$ sur un total de: <b>"+sTotal+"</b>$<div style='height:20px;'> </div><button onclick='closeMSG();' class='grey'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Fermer</button><button class='red' onclick='reverseInvoice3();'><span class='material-icons' style='vertical-align:middle;'>delete</span> Renverser la facture</button>"; 
    }
}
function reverseInvoice3(sTotal){
    if ( document.getElementById("txtCancelAmount")){
        var sAmount  = document.getElementById("txtCancelAmount").value;
        if (sAmount > sTotal){
            document.getElementById("txtCancelAmount").style.boxShadow = "0px 0px 3px 5px orange";
            document.getElementById("txtCancelAmount").focus();
            addNotif("Le montant est trop élevé.");
            return false;   
        }
    } else {
        sAmount = "nd"; 
    }
    var sReason  = document.getElementById("txtCancelReason").value;
    if (sReason == ""){
        document.getElementById("txtCancelReason").style.boxShadow = "0px 0px 3px 5px orange";
        document.getElementById("txtCancelReason").focus();
        return false;
    }

	var enID  = document.getElementById("enID").value;
    var enEML  = document.getElementById("txtEML").value;
    if (document.getElementById("chkCancelCMD").checked == false){ var is_cmd_canceled = 0; } else { var is_cmd_canceled = 1; }
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;border-radius:10px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == "" || this.responseText.trim() == "1"){
            if (this.responseText.trim() == "1"){
                document.getElementById("divMSG").innerHTML = "Un crédit a été appliqué au compte-client.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
            } else {
                addNotif("Facture renversée.");
                document.getElementById("divFADE2").style.display = "none";
                document.getElementById("divFADE2").style.opacity = "0";
                closeMSG();
            }
            getFCTS('','',LIMIT);
            closeEDITOR();
            rewritePDF(enID);
		  } else  {
            document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'writeGLS_REV.php?KEY=' + KEY + '&enID=' + enID + '&R=' + sReason+'&A='+sAmount+ '&CC=' + is_cmd_canceled, true);
		xmlhttp.send();
}

//rembourser une facture payé
function repayInvoice(sAmount,sTotal){
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Voulez-vous vraiment REMBOURSER la facture?<br>Payé: <b>"+sAmount+"</b>$ sur un total de: <b>"+sTotal+"</b>$<div style='height:20px;'> </div><button onclick='closeMSG();' class='grey'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Non</button> <button class='red' onclick=\"repayInvoice2('"+sAmount+"','"+sTotal+"');\"><span class='material-icons' style='vertical-align:middle;'>delete</span> Oui rembourser</button>";
}
function repayInvoice2(sAmount,sTotal){
    document.getElementById("divMSG").innerHTML = "Quelle est la raison pour rembourser la facture ?<input type='text' id='txtCancelReason'><br><span style='float:left;margin:10px;'><input id='chkCancelCMD' type='checkbox'><label for='chkCancelCMD'> Annuler aussi la commande</label></span><div style='height:20px;'> </div>Quelle est le montant à rembourser?<input type='number' id='txtCancelAmount' value='"+sAmount+"' style='background: url(/pub/img/dw3/arrow-money.png) 99% / 20px no-repeat #EEE;'><br>Payé: <b>"+sAmount+"</b>$ sur un total de: <b>"+sTotal+"</b>$<div style='height:20px;'> </div><button onclick='closeMSG();' class='grey'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Fermer</button><button class='red' onclick=\"repayInvoice3('"+sTotal+"');\"><span class='material-icons' style='vertical-align:middle;'>delete</span> Rembourser la facture</button>"; 
}
function repayInvoice3(sTotal){
    var sAmount  = document.getElementById("txtCancelAmount").value;
    if (sAmount > sTotal){
        document.getElementById("txtCancelAmount").style.boxShadow = "0px 0px 3px 5px orange";
        document.getElementById("txtCancelAmount").focus();
        addNotif("Le montant est trop élevé.");
        return false;   
    }

    var sReason  = document.getElementById("txtCancelReason").value;
    if (sReason == ""){
        document.getElementById("txtCancelReason").style.boxShadow = "0px 0px 3px 5px orange";
        document.getElementById("txtCancelReason").focus();
        return false;
    }

	var enID  = document.getElementById("enID").value;
    var enEML  = document.getElementById("txtEML").value;
    if (document.getElementById("chkCancelCMD").checked == false){ var is_cmd_canceled = 0; } else { var is_cmd_canceled = 1; }
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;border-radius:10px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == "" || this.responseText.trim() == "1"){
            if (this.responseText.trim() == "1"){
                document.getElementById("divMSG").innerHTML = "Un crédit a été appliqué au compte-client.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
            } else {
                addNotif("Facture renversée.");
                document.getElementById("divFADE2").style.display = "none";
                document.getElementById("divFADE2").style.opacity = "0";
                closeMSG();
            }
            getFCTS('','',LIMIT);
            closeEDITOR();
            rewritePDF(enID);
		  } else  {
            document.getElementById("divMSG").style.display = "inline-block";
            document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'writeGLS_REV.php?KEY=' + KEY + '&enID=' + enID + '&R=' + sReason+'&A='+sAmount+ '&CC=' + is_cmd_canceled, true);
		xmlhttp.send();
}

//facture 1er avis
function sendInvoiceEmail(){
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divMSG").style.display = "inline-block";
    var usEML  = document.getElementById("enUSEML").value;
    var enEML  = document.getElementById("txtEML").value;
    if (enEML == ""){
        document.getElementById("divMSG").innerHTML = "Veuillez entrer un email de destination<div style='height:20px;'> </div><button onclick='closeMSG();document.getElementById(\"txtEML\").focus();' class='grey'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>";
    }else if (usEML != ""){
        document.getElementById("divMSG").innerHTML = "<b style='color:red;'>Une facture par courriel a déjà été envoyé.</b><br>Voulez-vous vraiment envoyer un deuxième courriel à "+ enEML + "?<div style='height:20px;'> </div><button onclick='closeMSG();' style='background:#444;'><span class='material-icons' style='vertical-align:middle;'>cancel</span>Annuler</button><button onclick='sendInvoiceEmail2(1);'><span class='material-icons' style='vertical-align:middle;'>outgoing_mail</span> Envoyer</button>";
    }else{
        document.getElementById("divMSG").innerHTML = "Voulez-vous vraiment envoyer la facture par courriel à "+ enEML + " ?<div style='height:20px;'> </div><button onclick='closeMSG();' class='grey'><span class='material-icons' style='vertical-align:middle;'>cancel</span>Annuler</button><button onclick='sendInvoiceEmail2(1);'><span class='material-icons' style='vertical-align:middle;'>outgoing_mail</span> Envoyer</button>";
    }
}

function sendInvoiceEmail2(no_avis){
	var enID  = document.getElementById("enID").value;
    var enEML  = document.getElementById("txtEML").value;
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;border-radius:10px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
            closeMSG();
            addNotif("Facture envoyée par courriel à "+enEML);
            getFCTS('','',LIMIT);
            closeEDITOR();
            document.getElementById("divFADE2").style.display = "none";
            document.getElementById("divFADE2").style.opacity = "0";
		  } else  {
            document.getElementById("divMSG").style.display = "inline-block";
            document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'sendInvoiceEmail.php?KEY=' + KEY 
										+ '&enID=' + enID 
										+ '&no_avis=' + no_avis 
										+ '&enEML=' + enEML,    
										true);
		xmlhttp.send();
}
//facture 2iem avis
function sendInvoice2Email(){
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divMSG").style.display = "inline-block";
    var usEML  = document.getElementById("enUSEML").value;
    var enEML  = document.getElementById("txtEML").value;
    if (enEML == ""){
        document.getElementById("divMSG").innerHTML = "Veuillez entrer un email de destination<div style='height:20px;'> </div><button onclick='closeMSG();document.getElementById(\"txtEML\").focus();' class='grey'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>";
    }else if (usEML == ""){
        document.getElementById("divMSG").innerHTML = "<b style='color:red;'>Aucune première facture par courriel n'a d'abbord été envoyé.</b><br>Quel type de facture voulez-vous envoyer?<div style='height:20px;'> </div><button onclick='closeMSG();' class='grey'><span class='material-icons' style='vertical-align:middle;'>cancel</span>Annuler</button><button onclick='sendInvoiceEmail2(1);'><span class='material-icons' style='vertical-align:middle;'>outgoing_mail</span> 1er Avis</button><button onclick='sendInvoiceEmail2(2);'><span class='material-icons' style='vertical-align:middle;'>outgoing_mail</span> 2iem Avis</button>";
    }else if (enEML != ""){
        document.getElementById("divMSG").innerHTML = "Voulez-vous vraiment envoyer un deuxième avis par courriel à "+ enEML + " ?<div style='height:20px;'> </div><button onclick='closeMSG();' class='grey'><span class='material-icons' style='vertical-align:middle;'>cancel</span>Annuler</button><button onclick='sendInvoiceEmail2(2);'><span class='material-icons' style='vertical-align:middle;'>outgoing_mail</span> Envoyer</button>";
    }
}

//facture payé
function sendInvoice3Email(){
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divMSG").style.display = "inline-block";
    var usEML  = document.getElementById("enUSEML").value;
    var enEML  = document.getElementById("txtEML").value;
    if (enEML == ""){
        document.getElementById("divMSG").innerHTML = "Veuillez entrer un email de destination<div style='height:20px;'> </div><button onclick='closeMSG();document.getElementById(\"txtEML\").focus();' class='grey'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>";
    }else if (enEML != ""){
        document.getElementById("divMSG").innerHTML = "Voulez-vous vraiment envoyer une confirmation de facture <b style='color:green;'>payé</b> par courriel à "+ enEML + " ?<div style='height:20px;'> </div><button onclick='closeMSG();' class='grey'><span class='material-icons' style='vertical-align:middle;'>cancel</span>Annuler</button><button onclick='sendInvoiceEmail2(0);'><span class='material-icons' style='vertical-align:middle;'>outgoing_mail</span> Envoyer</button>";
    }
}
//facture annulé
function sendCanceledInvoice(){
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divMSG").style.display = "inline-block";
    var usEML  = document.getElementById("enUSEML").value;
    var enEML  = document.getElementById("txtEML").value;
    if (enEML == ""){
        document.getElementById("divMSG").innerHTML = "Veuillez entrer un email de destination<div style='height:20px;'> </div><button onclick='closeMSG();document.getElementById(\"txtEML\").focus();' class='grey'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>";
    }else if (enEML != ""){
        document.getElementById("divMSG").innerHTML = "Voulez-vous vraiment envoyer une confirmation de facture <b style='color:red;'>ANNULÉE</b> par courriel à "+ enEML + " ?<div style='height:20px;'> </div><button onclick='closeMSG();' class='grey'><span class='material-icons' style='vertical-align:middle;'>cancel</span>Annuler</button> <button onclick='sendCanceledInvoice2();'><span class='material-icons' style='vertical-align:middle;'>outgoing_mail</span> Envoyer</button>";
    }
}

function sendCanceledInvoice2(){
	var enID  = document.getElementById("enID").value;
    var enEML  = document.getElementById("txtEML").value;
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;border-radius:10px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
            closeMSG();
            addNotif("Facture envoyée par courriel à "+enEML);
            getFCTS('','',LIMIT);
            closeEDITOR();
            document.getElementById("divFADE2").style.display = "none";
            document.getElementById("divFADE2").style.opacity = "0";
		  } else  {
            document.getElementById("divMSG").style.display = "inline-block";
            document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'sendCanceledInvoice.php?KEY=' + KEY 
										+ '&enID=' + enID 
										+ '&enEML=' + enEML,    
										true);
		xmlhttp.send();
}
function payCASH(){
	var enID  = document.getElementById("enID").value;
	var AMOUNT  = document.getElementById("txtToPay").value;
    if (AMOUNT == 0 || AMOUNT == "" || isNaN(AMOUNT)){
		document.getElementById("txtToPay").style.boxShadow = "5px 10px 15px red";
		document.getElementById("txtToPay").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("txtToPay").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
		//document.getElementById("lblPRD").innerHTML = "";
	}

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
				//getFCT_LINE(enID);
                getTRANSACTION(enID);
                addNotif("Paiement de " + AMOUNT + "$ en argent confirmé.");
                closeMSG();
                getTOTAL(enID);
                getFCTS('','',LIMIT);
                //toggleSub('divSub2','up2');
                document.getElementById("txtToPay").value = 0.00;
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'payCASH.php?KEY=' + KEY 
										+ '&ID=' + enID  
										+ '&AMOUNT=' + AMOUNT,   
										true);
		xmlhttp.send();
}
function payINTERAC(){
	var enID  = document.getElementById("enID").value;
	var AMOUNT  = document.getElementById("txtToPay").value;
    if (AMOUNT == 0 || AMOUNT == "" || isNaN(AMOUNT)){
		document.getElementById("txtToPay").style.boxShadow = "5px 10px 15px red";
		document.getElementById("txtToPay").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("txtToPay").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
		//document.getElementById("lblPRD").innerHTML = "";
	}

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
				//getFCT_LINE(enID);
                getTRANSACTION(enID);
                addNotif("Paiement de " + AMOUNT + "$ par Interac confirmé.");
                closeMSG();
                getTOTAL(enID);
                getFCTS('','',LIMIT);
                //toggleSub('divSub2','up2');
                document.getElementById("txtToPay").value = 0.00;
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'payINTERAC.php?KEY=' + KEY 
										+ '&ID=' + enID  
										+ '&AMOUNT=' + AMOUNT,   
										true);
		xmlhttp.send();
}
function payCHECK_NUMBER(){
    document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "No de chèque:<br><input type='text' id='txtCheckNo' style='text-align:center;'><div style='height:20px;'> </div><button class='grey' onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Annuler</button><button class='green' onclick=\"payCHECK(document.getElementById('txtCheckNo').value);closeMSG();\"><span class='material-icons' style='vertical-align:middle;'>done</span> Confirmer</button>";
}
function payCHECK(check_number){
	var enID  = document.getElementById("enID").value;
	var AMOUNT  = document.getElementById("txtToPay").value;
    if (AMOUNT == 0 || AMOUNT == "" || isNaN(AMOUNT)){
		document.getElementById("txtToPay").style.boxShadow = "5px 10px 15px red";
		document.getElementById("txtToPay").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("txtToPay").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
		//document.getElementById("lblPRD").innerHTML = "";
	}

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
				//getFCT_LINE(enID);
                getTRANSACTION(enID);
                addNotif("Paiement de " + AMOUNT + "$ en chèque confirmé.");
                closeMSG();
                getTOTAL(enID);
                getFCTS('','',LIMIT);
                //toggleSub('divSub2','up2');
                document.getElementById("txtToPay").value = 0.00;
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'payCHECK.php?KEY=' + KEY 
										+ '&ID=' + enID  
										+ '&CHECK_NO=' + check_number  
										+ '&AMOUNT=' + AMOUNT,   
										true);
		xmlhttp.send();
}
function payBANK_NUMBER(){
    document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "No de transfert:<br><input type='text' id='txtCheckNo' style='text-align:center;'><div style='height:20px;'> </div><button class='grey' onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Annuler</button><button class='green' onclick=\"payBANK(document.getElementById('txtCheckNo').value);closeMSG();\"><span class='material-icons' style='vertical-align:middle;'>done</span> Confirmer</button>";
}
function payBANK(check_number){
	var enID  = document.getElementById("enID").value;
	var AMOUNT  = document.getElementById("txtToPay").value;
    if (AMOUNT == 0 || AMOUNT == "" || isNaN(AMOUNT)){
		document.getElementById("txtToPay").style.boxShadow = "5px 10px 15px red";
		document.getElementById("txtToPay").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("txtToPay").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
		//document.getElementById("lblPRD").innerHTML = "";
	}

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
				//getFCT_LINE(enID);
                getTRANSACTION(enID);
                addNotif("Paiement de " + AMOUNT + "$ confirmé.");
                closeMSG();
                getTOTAL(enID);
                getFCTS('','',LIMIT);
                //toggleSub('divSub2','up2');
                document.getElementById("txtToPay").value = 0.00;
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'payBANK.php?KEY=' + KEY 
										+ '&ID=' + enID  
										+ '&CHECK_NO=' + check_number  
										+ '&AMOUNT=' + AMOUNT,   
										true);
		xmlhttp.send();
}

function updPRJ_ID(sID){
    var sPRJ     = document.getElementById("enPRJ").value;
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		   //alert (this.responseText);
		  if (this.responseText == ""){
                addNotif("<?php echo $dw3_lbl["MODIFIED"]; ?>");
		  } else {
			  	document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updPRJ_ID.php?KEY=' + KEY 
										+ '&ID=' + encodeURIComponent(sID)  
										+ '&PRJ=' + encodeURIComponent(sPRJ) ,                 
										true);
		xmlhttp.send();
}

function updFCT(sID){
	//var GRPBOX = document.getElementById("enSTAT");
	//var sSTAT = GRPBOX.options[GRPBOX.selectedIndex].value;	

	var sEML    = document.getElementById("txtEML").value;
	var sDTDU     = document.getElementById("enDTDU").value;
	var sNOTE    = document.getElementById("enNOTE").value;
	var sNOM    = document.getElementById("enNOM").value;
	var sCIE    = document.getElementById("enCIE").value;
	var sADR1    = document.getElementById("enADR1").value;
	var sADR2    = document.getElementById("enADR2").value;
	var sVILLE   = document.getElementById("enVILLE").value;
	var sPROV    = document.getElementById("enPROV").value;
	var sPAYS    = document.getElementById("enPAYS").value;
	var sCP      = document.getElementById("enCP").value;

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
		  if (this.responseText == ""){
				getFCTS('','',LIMIT);
                closeMSG();
                addNotif("<?php echo $dw3_lbl["MODIFIED"]; ?>");
                toggleSub('divSub1','up1');
		  } else {
			  	document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updFCT.php?KEY=' + KEY 
										+ '&ID=' + encodeURIComponent(sID)  
										+ '&NOM=' + encodeURIComponent(sNOM)    
										+ '&EML=' + encodeURIComponent(sEML)    
										+ '&CIE=' + encodeURIComponent(sCIE)    
										+ '&DTDU=' + encodeURIComponent(sDTDU)    
										+ '&ADR1=' + encodeURIComponent(sADR1)   
										+ '&ADR2=' + encodeURIComponent(sADR2)   
										+ '&VILLE=' + encodeURIComponent(sVILLE)   
										+ '&PROV=' + encodeURIComponent(sPROV)   
										+ '&PAYS=' + encodeURIComponent(sPAYS)   
										+ '&CP=' + encodeURIComponent(sCP)    
										+ '&NOTE=' + encodeURIComponent(sNOTE)   ,                 
										true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
}
function resetPRM() {
    document.getElementById("divPARAM_DATA").innerHTML = "<img style='width:100px;height:auto;border-radius:10px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        openPARAM();
        addNotif("Paramètres réinitialisés.");
	  }
	};
		xmlhttp.open('GET', '../resetPRM.php?KEY=' + KEY + "&APP="+ APPID, true);
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
	
	if (document.getElementById("DSP_COL_ID").checked == false){ var dspID = 0; } else { var dspID = 1; }
	if (document.getElementById("DSP_COL_ORDER_ID").checked == false){ var dspORDER_ID = 0; } else { var dspORDER_ID = 1; }
	if (document.getElementById("DSP_COL_PROJECT_ID").checked == false){ var dspPROJECT_ID = 0; } else { var dspPROJECT_ID = 1; }
	if (document.getElementById("DSP_COL_STAT").checked == false){ var dspSTAT = 0; } else { var dspSTAT = 1; }
	if (document.getElementById("DSP_COL_SOURCE").checked == false){ var dspSOURCE = 0; } else { var dspSOURCE = 1; }
	if (document.getElementById("DSP_COL_NOM").checked == false){ var dspNOM = 0; } else { var dspNOM = 1; }
	if (document.getElementById("DSP_COL_CIE").checked == false){ var dspCIE = 0; } else { var dspCIE = 1; }
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
	if (document.getElementById("DSP_COL_TAX").checked == false){ var dspTAX = 0; } else { var dspTAX = 1; }
	if (document.getElementById("DSP_COL_TRP").checked == false){ var dspTRP = 0; } else { var dspTRP = 1; }
	if (document.getElementById("DSP_COL_TOT").checked == false){ var dspTOT = 0; } else { var dspTOT = 1; }

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){
				getFCTS('','',LIMIT);
				closeEDITOR();
                closeMSG();
                addNotif("<?php echo $dw3_lbl["MODIFIED"]; ?>");
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
										+ '&ORDER_ID=' 		+ dspORDER_ID
										+ '&PROJECT_ID=' 		+ dspPROJECT_ID
										+ '&STAT='		+ dspSTAT 
										+ '&SOURCE='		+ dspSOURCE
										+ '&CIE='		+ dspCIE  
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
										+ '&TAX=' 		+ dspTAX
										+ '&TRP=' 		+ dspTRP
										+ '&TOT=' 		+ dspTOT
										+ '&NOTE=' 		+ dspNOTE,
										true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
}
</script>
</body>
</html>
