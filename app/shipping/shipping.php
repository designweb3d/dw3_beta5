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
				<input type="search" onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" id="inputSEARCH" oninput="getSHIPS('','',LIMIT);" placeholder="<?php echo $APNAME; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
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
			<option value='0'>En traitement</option>
			<option value='1'>Prêt à expédier</option>
			<option value='2'>Sur la route</option>
			<option value='3'>Vers la destination</option>
			<option value='4'>Livrée</option>
			<option selected value=''><?php echo $dw3_lbl["ALL"]; ?></option>
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
		<div style='width:100%;text-align:center;'><button class='grey' onclick="closeFILTRE();"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button><button onclick="closeFILTRE();getCMDS('','',LIMIT);"><span class="material-icons">filter_alt</span> <?php echo $dw3_lbl["FILTER"]; ?></button></div>
</div>

<div id='divMAIN' class='divMAIN' style="padding-top:50px;">
<img src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>
</div>
<div  style='height:48px;'></div>
<div id="divSHIP" class="divEDITOR"></div>

<div id="divNEW" class="divEDITOR" style='width:100%;max-width:900px;height:90%;max-height:90%;min-height:300px;'>
    <div id="divNEW_HEADER" class='dw3_form_head'>
	    <h3>Nouvelle expédition</h3>
        <button onclick='closeNEW();' class='dw3_form_close'><span class='material-icons'>close</span></button>
    </div>
	<div class="divBOX">Choisissez une commande client:<br>
		<input id="selCMD" oninput="getCMDS('');" type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" onclick="detectCLICK(event,this);"  placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
	</div><br>
		<div id="divCMD" style="position:absolute;top:100px;bottom:0px;left:0px;right:0px;overflow-x:auto;overflow-y:scroll;">		
			Type in search box to find an order.
		</div><input style="display:none;" id="newCMD" type="text">
</div>

<div id="divPARAM"  class="divEDITOR" style="background: rgba(0, 0, 0, 0.7);color:white;overflow-y:auto;">
    <div id='divPARAM_HEADER' class='dw3_form_head'>
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
var KEY = '<?php echo($_GET['KEY']); ?>';
var USER_LANG = '<?php echo $USER_LANG; ?>';
var LIMIT = '12';

$(document).ready(function ()
    {
        //responsive rownb limit calculations
		var body = document.body,
		html = document.documentElement;
		var height = Math.max( body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight );
		//LIMIT = Math.floor(height/58);
        const windowWidth = window.innerWidth;
		if (windowWidth >= 900){				   
		    LIMIT = Math.floor((height-176)/36);				   
        } else {
            LIMIT = Math.floor((height-176)/31);
        }
		getCMDS('');
        getSHIPS('','',LIMIT);
		document.getElementsByTagName("BODY")[0].onresize = function() {bodyResize()};

    dragElement(document.getElementById("divNEW"));
    dragElement(document.getElementById("divPARAM"));
	});

function bodyResize() {
	var max_width = Math.max(window.innerWidth, document.documentElement.clientWidth, document.body.clientWidth)/100*95;
	var text_width = Math.floor(max_width/335)*335;
		if (text_width=='0'){text_width='335'} 
	if (document.getElementById("enNOTE")) {
		document.getElementById("enNOTE").style.width = text_width + "px";
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

function validateCMD(enID,that) {
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
	document.getElementById("newCMD").value = enID;
	//document.getElementById("btnNEW").enabled = true;
    newSHIP();
}


function deleteSHIPS() {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><div style='height:20px;'> </div> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span>Annuler</button> <button class='red' onclick='delSHIPS();'><span class='material-icons' style='vertical-align:middle;'>delete</span>Delete</button>";
}
function delSHIPS() {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	var sLST = "";

	var frmSHIP  = document.getElementById("frmSHIP");
	var sVIRGULE = "";
	
	for (var i = 0; i < frmSHIP.elements.length; i++ ) 
	{
		if (frmSHIP.elements[i].type == 'checkbox')
		{
			if (frmSHIP.elements[i].checked == true)
			{
				if(sLST != ""){sVIRGULE = ","} else { sLST = "("; }
				sLST += sVIRGULE + frmSHIP.elements[i].value ;
			}
		}
	}	
	if (sLST == ""){
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["ERR_SEL1"]; ?><div style='height:20px;'> <button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		return;
	} else { sLST += ")"; }
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){
				getSHIPS('','',LIMIT);
				closeMSG();
		  } else {
				document.getElementById("divFADE2").style.display= "inline-block"; 
                document.getElementById("divFADE2").style.opacity= "0.6";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				getSHIPS('','',LIMIT);
		  } 
	  }
	};
		xmlhttp.open('GET', 'delSHIPS.php?KEY=' + KEY + '&LST=' + encodeURIComponent(sLST) , true);
		xmlhttp.send();
}

function getSHIP(shID) {
    document.getElementById("divFADE").style.display = "inline-block";
	document.getElementById("divFADE").style.opacity = "0.4";
	var max_width = Math.max(window.innerWidth, document.documentElement.clientWidth, document.body.clientWidth)/100*95;
	var text_width = Math.floor(max_width/335)*335;
	if (text_width=='0'){text_width='335'} 
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divSHIP").innerHTML = this.responseText;
		 document.getElementById("divSHIP").style.display = "inline-block";
         dragElement(document.getElementById("divSHIP"));
		 document.getElementById("divSHIP").scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
	  }
	};
    document.getElementById("divFADE").style.display= "inline-block"; 
    document.getElementById("divFADE").style.opacity= "0.6";
    xmlhttp.open('GET', 'getSHIP.php?KEY=' + KEY + '&shID=' + shID + '&tw=' + text_width , true);
    xmlhttp.send();
		
}


function getSHIPS(shSTAT,sOFFSET,sLIMIT) {
	var sS = document.getElementById("inputSEARCH").value;
	
	//STAT
	if (shSTAT.trim() == ""){
		var GRPBOX = document.getElementById("selSTAT");
		var shSTAT = GRPBOX.options[GRPBOX.selectedIndex].value;		
	}
	//PAYS
	var GRPBOX = document.getElementById("selPAYS");
	var shPAYS = GRPBOX.options[GRPBOX.selectedIndex].value;	
	//PROV
	var GRPBOX = document.getElementById("selPROV");
	var shPROV = GRPBOX.options[GRPBOX.selectedIndex].value;	
	//VILLE
	var GRPBOX = document.getElementById("selVILLE");
	var shVILLE = GRPBOX.options[GRPBOX.selectedIndex].value;	


	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divMAIN").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getSHIPS.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim())
									+ '&STAT=' + shSTAT
									+ '&PAYS=' + shPAYS
									+ '&PROV=' + shPROV
									+ '&VILLE=' + shVILLE
									+ '&OFFSET=' + sOFFSET 
									+ '&LIMIT=' + sLIMIT  
									, true);
		xmlhttp.send();
		
}



//delete Poste Canada order
function delShipment(ID) {
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Voulez-vous vraiment supprimer cet envoi? <div style='height:20px;'> </div><button class='grey' onclick=\"closeMSG();\"><span class='material-icons' style='vertical-align:middle;'>cancel</span> Annuler</button> <button class='red' onclick='deleteShipment("+ID+");closeMSG();'><span class='material-icons' style='vertical-align:middle;'>delete</span> Supprimer</button>";
}
function deleteShipment(ID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
	  }
	};
		//xmlhttp.open('GET', '/api/poste_canada/REST/tracking/GetTrackingDetails/GetTrackingDetails.php?KEY=' + KEY + '&shID=' + ID , true);
	xmlhttp.open('GET', '/api/poste_canada/REST/shipping/VoidShipment/VoidShipment.php?KEY=' + KEY + '&shID=' + ID , true);
	xmlhttp.send();
}
//delete Montreal Dropship order
function delShipment2(ID) {
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Voulez-vous vraiment supprimer cet envoi? <div style='height:20px;'> </div><button class='grey' onclick=\"closeMSG();\"><span class='material-icons' style='vertical-align:middle;'>cancel</span> Annuler</button> <button class='red' onclick='deleteShipment2("+ID+");closeMSG();'><span class='material-icons' style='vertical-align:middle;'>delete</span> Supprimer</button>";
}
function deleteShipment2(ID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		closeSHIP();
	  }
	};
	xmlhttp.open('GET', '/api/livar/delete.php?KEY=' + KEY + '&ID=' + ID , true);
	xmlhttp.send();
	document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='border-radius:10px;width:100px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
}
//informations sur le shipping
function infoSHIP() {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<div style='text-align:left;'>Étapes d'une expédition:<ol style='margin-left:20px;'><li><b>Préparation: </b> Imprimez le feuillet de ramassage et préparez le colis.</li><li><b>Prêt à expédier:</b> Imprimez le feuillet d'expédition ou l'étiquette et collez le/la sur la boîte.</li><li><b>Expédié:</b> Remettez le colis au transporteur ou placez le colis dans le camion.</li><li><b>Vers la destination:</b> Le transporteur est en direction de l'adresse de livraison.</li><li><b>Livré:</b> Vérifiez que le colis a bien été livré.</li></ol></div><div style='height:20px;'> </div> <button class='grey' onclick='closeMSG();'><span class='material-icons'>close</span> Ok</button>";
}
//delete internal shipping records
function deleteSHIP(shID) {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><div style='height:20px;'> </div> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button> <button class='red' onclick='delSHIP(" + shID + ");closeMSG();'><span class='material-icons' style='vertical-align:middle;'>delete</span><?php echo $dw3_lbl["DEL"]; ?></button>";
}
function delSHIP(shID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			  if (this.responseText.trim() == ""){
					closeSHIP();
					//document.getElementById("divMSG").style.display = "inline-block";
					//document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_OK"]; ?><div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
					getSHIPS('','',LIMIT);
			  } else {
					document.getElementById("divMSG").style.display = "inline-block";
					document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
			  } 
		  
		}
	};
		xmlhttp.open('GET', 'delSHIP.php?KEY=' + KEY + '&shID=' + shID , true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
}


function getTracking(ID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
	  }
	};
		//xmlhttp.open('GET', '/api/poste_canada/REST/tracking/GetTrackingDetails/GetTrackingDetails.php?KEY=' + KEY + '&shID=' + ID , true);
		xmlhttp.open('GET', '/api/poste_canada/REST/tracking/GetTrackingSummary/GetTrackingSummary.php?KEY=' + KEY + '&shID=' + ID , true);
		xmlhttp.send();
}
function getShipingStatus(shID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
        if (this.responseText == "Livré"){
            updateOrderStatus(shID,'5');
        }
	  }
	};
    xmlhttp.open('GET', '/api/livar/status.php?KEY=' + KEY + '&shID=' + shID , true);
    xmlhttp.send();
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='border-radius:10px;width:100px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";

}

function updateShippingStatus(ship_id,ship_status,carrier) {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "";
	if (ship_status == '1'){
	    /* En traitement -> Prêt à expédier */
		document.getElementById("divMSG").innerHTML = "Voulez-vous vraiment continuer ? <br><span style='font-size:0.7em;'>L'inventaire sera modifié et le client sera avisé <i>(ou il pourra le voir avec son # de tracking)</i> que l'expédition est prête à expédier ou à ramasser.</span><div style='height:20px;'> </div> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button> <button class='blue' onclick=\"createShipment('" + ship_id + "','" + carrier + "');closeMSG();\"><span class='material-icons'>local_shipping</span> Prêt à expédier</button>";
	} else if (ship_status == '2'){
	    /* Prêt à expédier -> Départ du centre de tri */
		document.getElementById("divMSG").innerHTML = "Voulez-vous vraiment continuer ? <br><span style='font-size:0.7em;'>Le client sera avisé <i>(ou il pourra le voir avec son # de tracking)</i> que l'expédition sera livré aujourd'hui.</span><div style='height:20px;'> </div> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button> <button class='blue' onclick=\"updShippingStatus('" + ship_id + "','" + ship_status + "');closeMSG();\"><span class='material-icons'>local_shipping</span> Départ du centre de tri</button>";
	} else if (ship_status == '3'){
	    /* Sur la route -> Vers la destination */
		document.getElementById("divMSG").innerHTML = "Voulez-vous vraiment continuer ? <br><span style='font-size:0.7em;'>Le client sera avisé <i>(ou il pourra le voir avec son # de tracking)</i> que l'expédition est en route vers sa destination.</span><div style='height:20px;'> </div> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button> <button class='blue' onclick=\"updShippingStatus('" + ship_id + "','" + ship_status + "');closeMSG();\"><span class='material-icons'>local_shipping</span> Vers la destination</button>";
	} else if (ship_status == '4'){
	    /* Vers la destination -> Livrée */
		document.getElementById("divMSG").innerHTML = "Voulez-vous vraiment continuer ? <br><span style='font-size:0.7em;'>Le client sera avisé <i>(ou il pourra le voir avec son # de tracking)</i> que l'expédition a été livrée.</span><div style='height:20px;'> </div> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button> <button class='blue' onclick=\"updShippingStatus('" + ship_id + "','" + ship_status + "');closeMSG();\"><span class='material-icons'>local_shipping</span> Confirmer la livraison</button>";
	} else if (ship_status == '5'){
	    /* Annuler */
		document.getElementById("divMSG").innerHTML = "Voulez-vous vraiment continuer ? <br><span style='font-size:0.7em;'>L'inventaire sera remis en stock et le client sera avisé <i>(ou il pourra le voir avec son # de tracking)</i> que l'expédition a été annulée.</span><div style='height:20px;'> </div> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button> <button class='red' onclick=\"updShippingStatus('" + ship_id + "','" + ship_status + "');closeMSG();\"><span class='material-icons'>local_shipping</span> Annuler l'expédition</button>";
	} else if (ship_status == '0'){
	    /* Annuler */
		document.getElementById("divMSG").innerHTML = "Voulez-vous vraiment continuer ? <br><span style='font-size:0.7em;'>Le client sera avisé <i>(ou il pourra le voir avec son # de tracking)</i> que l'expédition a été remise en préparation.</span><div style='height:20px;'> </div> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button> <button class='blue' onclick=\"updShippingStatus('" + ship_id + "','" + ship_status + "');closeMSG();\"><span class='material-icons'>local_shipping</span> Replacer en préparation</button>";
	}
}
function getPickList(ship_id) {
    window.open('getPICK_LIST.php?KEY=' + KEY + '&ID=' + ship_id, '_blank');
}
function getShipSlip(ship_id) {
    window.open('getSHIP_SLIP.php?KEY=' + KEY + '&ID=' + ship_id, '_blank');
}

function updShippingStatus(ship_id,ship_status) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
            addNotif("Status de l'expédition mise à jour.");
			getSHIPS('','',LIMIT);
            getSHIP(ship_id);
        }
	};
    xmlhttp.open('GET', 'updSHIP_STAT.php?KEY=' + KEY + '&ID=' + ship_id + '&S=' + ship_status , true);
    xmlhttp.send();
}

function createShipment(ID,carrier) {
    document.getElementById("createShipmentbtn").disabled = true;
	if (document.getElementById("quoteShipmentbtn")) {
        document.getElementById("quoteShipmentbtn").disabled = true;
    }
	document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='border-radius:10px;width:100px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		getSHIP(ID);
	  }
	};
    if (carrier == "DOM.RP" || carrier == "DOM.XP" || carrier == "DOM.EP"){
		xmlhttp.open('GET', '/api/poste_canada/REST/ncshipping/CreateNCShipment/CreateNCShipment.php?KEY=' + KEY + '&shID=' + ID , true);
    } else if (carrier == "ICS" || carrier == "DICOM" || carrier == "NATIONEX" || carrier == "PUROLATOR" || carrier == "UPS" || carrier == "POSTE"){
		xmlhttp.open('GET', '/api/livar/order.php?KEY=' + KEY + '&shID=' + ID , true);
    } else if (carrier == "INTERNAL"){
		xmlhttp.open('GET', 'setSHIP.php?KEY=' + KEY + '&shID=' + ID , true);
    } else {
		document.getElementById("divMSG").innerHTML = "Transporteur non valide pour une expédition.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
	}
	xmlhttp.send();
        //document.getElementById("divFADE2").style.display = "inline-block";
		//document.getElementById("divFADE2").style.opacity = "0.4";
}

function getSHIP_BOX() {
	var GRPBOX = document.getElementById("shBOX");
	var sBOX = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		const response = JSON.parse(this.responseText);
		document.getElementById("boxWEIGHT").value = Number(response.weight) + Number(document.getElementById("calcWEIGHT").value);
		document.getElementById("boxLENGTH").value = response.depth;
		document.getElementById("boxHEIGHT").value = response.height;
		document.getElementById("boxWIDTH").value = response.width;
		document.getElementById("span_box_total").innerHTML = (response.width*response.height*response.depth);
		document.getElementById("divFADE2").style.opacity = "0";
		setTimeout(function () {
			document.getElementById("divFADE2").style.display = "none";
		}, 500);
		closeMSG();
	  }
	};
		xmlhttp.open('GET', '../order/getSHIP_BOX.php?KEY=' + KEY + '&ID=' + sBOX , true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:40px;height:auto;border-radius:20px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
}

function applyBoxToShipment(sID){
	var sWEIGHT      = document.getElementById("boxWEIGHT").value;
	var sLENGTH      = document.getElementById("boxLENGTH").value;
	var sHEIGHT      = document.getElementById("boxHEIGHT").value;
	var sWIDTH      = document.getElementById("boxWIDTH").value;

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		   //alert (this.responseText);
		  if (this.responseText == ""){
		        closeMSG();
                addNotif("<?php echo $dw3_lbl["MODIFIED"]; ?>");
				document.getElementById("shWEIGHT").value = sWEIGHT;
				document.getElementById("shLENGTH").value = sLENGTH;
				document.getElementById("shHEIGHT").value = sHEIGHT;
				document.getElementById("shWIDTH").value = sWIDTH;
		  } else {
			  	document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updSHIP_BOX.php?KEY=' + KEY 
										+ '&ID=' + encodeURIComponent(sID)    
										+ '&WIDTH=' + encodeURIComponent(sWIDTH)  
										+ '&LENGTH=' + encodeURIComponent(sLENGTH)  
										+ '&HEIGHT=' + encodeURIComponent(sHEIGHT)  
										+ '&WEIGHT=' + encodeURIComponent(sWEIGHT),                 
										true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";

}
function closeSHIP() {
	document.getElementById("divFADE").style.display = "none";
	document.getElementById("divFADE").style.opacity = "0";
	document.getElementById("divSHIP").style.display = "none";
}
function updSHIP(sID){
	var GRPBOX = document.getElementById("shDROP");
	var sDROP = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var GRPBOX = document.getElementById("shLOC");
	var sLOC = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var sNAME     = document.getElementById("shNAME").value;
	var sCOMPANY    = document.getElementById("shCOMPANY").value;
	var sNOM    = document.getElementById("shNAME").value;
	var sADR1    = document.getElementById("shADR1").value;
	var sADR2    = document.getElementById("shADR2").value;
	var sVILLE   = document.getElementById("shCITY").value;
	var sPROV    = document.getElementById("shPROVINCE").value;
	var sPAYS    = document.getElementById("shCOUNTRY").value;
	var sCP      = document.getElementById("shCP").value;
	var sEML      = document.getElementById("shEML").value;
	var sTEL      = document.getElementById("shTEL").value;
	var sWEIGHT      = document.getElementById("shWEIGHT").value;
	var sLENGTH      = document.getElementById("shLENGTH").value;
	var sHEIGHT      = document.getElementById("shHEIGHT").value;
	var sWIDTH      = document.getElementById("shWIDTH").value;
	var sAMOUNT      = document.getElementById("shAMOUNT").value;

	if (document.getElementById("shNOTIF_SHIP").checked == false){ var sSH = 0; } else { var sSH = 1; }
	if (document.getElementById("shNOTIF_EXCEPT").checked == false){ var sEX = 0; } else { var sEX = 1; }
	if (document.getElementById("shNOTIF_DELIV").checked == false){ var sDE = 0; } else { var sDE = 1; }

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		   //alert (this.responseText);
		  if (this.responseText == ""){
		        closeMSG();
                addNotif("<?php echo $dw3_lbl["MODIFIED"]; ?>");
				if(document.getElementById("createShipmentbtn")){
					document.getElementById("createShipmentbtn").disabled = false;
					document.getElementById("quoteShipmentbtn").disabled = false;
				}
				if(document.getElementById("updShipmentbtn")){
					document.getElementById("updShipmentbtn").disabled = true;
				}
		  } else {
			  	document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updSHIP.php?KEY=' + KEY 
										+ '&ID=' + encodeURIComponent(sID)  
										+ '&DROP=' + encodeURIComponent(sDROP)  
										+ '&AMOUNT=' + encodeURIComponent(sAMOUNT)  
										+ '&LOC=' + encodeURIComponent(sLOC)  
										+ '&SH=' + encodeURIComponent(sSH)  
										+ '&EX=' + encodeURIComponent(sEX)  
										+ '&DE=' + encodeURIComponent(sDE)  
										+ '&WIDTH=' + encodeURIComponent(sWIDTH)  
										+ '&LENGTH=' + encodeURIComponent(sLENGTH)  
										+ '&HEIGHT=' + encodeURIComponent(sHEIGHT)  
										+ '&WEIGHT=' + encodeURIComponent(sWEIGHT)  
										+ '&NOM=' + encodeURIComponent(sNAME)    
										+ '&CIE=' + encodeURIComponent(sCOMPANY)    
										+ '&ADR1=' + encodeURIComponent(sADR1)   
										+ '&ADR2=' + encodeURIComponent(sADR2)   
										+ '&VILLE=' + encodeURIComponent(sVILLE)   
										+ '&PROV=' + encodeURIComponent(sPROV)   
										+ '&PAYS=' + encodeURIComponent(sPAYS)   
										+ '&CP=' + encodeURIComponent(sCP)    
										+ '&TEL=' + encodeURIComponent(sTEL)    
										+ '&EML=' + encodeURIComponent(sEML),                 
										true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";

}

function newSHIP(ship_type = ""){
	var enID  = document.getElementById("newCMD").value;
	
	if (enID == ""){
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
				closeMSG();
				getSHIP(this.responseText.trim());
				getSHIPS('','',LIMIT);
		  } else {
			if (this.responseText.trim() == "Err1"){
				document.getElementById("divMSG").style.display = "inline-block";
				if (USER_LANG == "FR") {
					document.getElementById("divMSG").innerHTML = "Aucun mode de transport de défini pour cette commande.<br>Veuillez en choisir un.<br>"
					+ "<button class='blue' style='width:175px;' onclick=\"newSHIP('PICKUP');\">Ramassage par le client</button><br>"
					+ "<button class='blue' style='width:175px;' onclick=\"newSHIP('INTERNAL');\">Transport interne</button><br>"
					+ "<button class='blue' style='width:175px;' onclick=\"newSHIP('POSTE_CANADA');\">Poste Canada</button><br>"
					+ "<button class='blue' style='width:175px;' onclick=\"newSHIP('MONTREAL_DROPSHIP');\">Livraison à Rabais</button>"
					+ "<div style='height:20px;'> </div><button class='grey' onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Annuler</button>";
				} else {
					document.getElementById("divMSG").innerHTML = "No shipping method defined for this order.<br>Please choose one.<br>"
					+ "<button class='blue' style='width:175px;' onclick=\"newSHIP('PICKUP');\">Customer Pickup</button><br>"
					+ "<button class='blue' style='width:175px;' onclick=\"newSHIP('INTERNAL');\">Internal Shipping</button><br>"
					+ "<button class='blue' style='width:175px;' onclick=\"newSHIP('POSTE_CANADA');\">Canada Post</button><br>"
					+ "<button class='blue' style='width:175px;' onclick=\"newSHIP('MONTREAL_DROPSHIP');\">Montreal Dropship</button>"
					+ "<div style='height:20px;'> </div><button class='grey' onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Cancel</button>";
				}
				
			} else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
			}
		  } 
	  }
	};
    xmlhttp.open('GET', 'newSHIP.php?KEY=' + KEY 
                                    + '&CMD=' + encodeURIComponent(enID)   
                                    + '&SHIP_TYPE=' + ship_type,
                                    true);
    xmlhttp.send();
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.opacity = "0.4";
}


function updLGN_QTY_SHIPPED(headID,lineID,lineQTE){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
				getSHIP(headID);
                addNotif("Mise à jour de la quantité terminée");
                closeMSG();
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
    xmlhttp.open('GET', 'updLGN_QTE_SHIP.php?KEY=' + KEY 
                                    + '&ID=' + lineID 
                                    + '&QTE=' + lineQTE ,   
                                    true);
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
	if (document.getElementById("DSP_COL_STAT").checked == false){ var dspSTAT = 0; } else { var dspSTAT = 1; }
	if (document.getElementById("DSP_COL_NOM").checked == false){ var dspNOM = 0; } else { var dspNOM = 1; }
	if (document.getElementById("DSP_COL_ORDER").checked == false){ var dspORDER = 0; } else { var dspORDER = 1; }
	if (document.getElementById("DSP_COL_CIE").checked == false){ var dspCIE = 0; } else { var dspCIE = 1; }
	if (document.getElementById("DSP_COL_ADR1").checked == false){ var dspADR1 = 0; } else { var dspADR1 = 1; }
	if (document.getElementById("DSP_COL_ADR2").checked == false){ var dspADR2 = 0; } else { var dspADR2 = 1; }
	if (document.getElementById("DSP_COL_VILLE").checked == false){ var dspVILLE = 0; } else { var dspVILLE = 1; }
	if (document.getElementById("DSP_COL_PROV").checked == false){ var dspPROV = 0; } else { var dspPROV = 1; }
	if (document.getElementById("DSP_COL_PAYS").checked == false){ var dspPAYS = 0; } else { var dspPAYS = 1; }
	if (document.getElementById("DSP_COL_CP").checked == false){ var dspCP = 0; } else { var dspCP = 1; }
	if (document.getElementById("DSP_COL_NOTE").checked == false){ var dspNOTE = 0; } else { var dspNOTE = 1; }
	if (document.getElementById("DSP_COL_DTAD").checked == false){ var dspDTAD = 0; } else { var dspDTAD = 1; }
	if (document.getElementById("DSP_COL_DTLV").checked == false){ var dspDTLV = 0; } else { var dspDTLV = 1; }
	if (document.getElementById("DSP_COL_TRACKING").checked == false){ var dspTRACKING = 0; } else { var dspTRACKING = 1; }

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		   //alert (this.responseText);
		  if (this.responseText == ""){
				getSHIPS('','',LIMIT);
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
                                    + '&STAT='		+ dspSTAT 
                                    + '&NOM='		+ dspNOM  
                                    + '&ORDER='		+ dspORDER  
                                    + '&CIE='		+ dspCIE  
                                    + '&ADR1=' 		+ dspADR1
                                    + '&ADR2=' 		+ dspADR2
                                    + '&VILLE=' 	+ dspVILLE
                                    + '&PROV=' 		+ dspPROV
                                    + '&PAYS=' 		+ dspPAYS
                                    + '&CP=' 		+ dspCP 
                                    + '&DTAD=' 		+ dspDTAD
                                    + '&DTLV=' 		+ dspDTLV
                                    + '&TRACKING=' 		+ dspTRACKING
                                    + '&NOTE=' 		+ dspNOTE,
                                    true);
    xmlhttp.send();
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.opacity = "0.4";
}
</script>
</body>
</html>
<?php $dw3_conn->close(); ?>