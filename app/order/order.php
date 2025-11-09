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
				<input type="search" onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" id="inputSEARCH" oninput="getCMDS('','',LIMIT);" placeholder="<?php echo $APNAME; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
			</td>
			<td style="width:0;min-width:fit-content;margin:0px;padding:0px 0px 0px 5px;text-align:right;">
				<?php if($APREAD_ONLY == false) { ?><button class='blue' style="margin:0px 2px 0px 2px;padding:8px;" onclick="openNEW();getCLIS('');getElementById('selCLI').focus();"><span class="material-icons">add</span></button> <?php } ?>
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
			<option value='1'>En facturation</option>
			<option value='2'>À expédier</option>
			<option value='3'>En expédition</option>
			<option value='5'>Payée et livrée</option>
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
<div id="divEDIT" class="divEDITOR" style='max-width:100%;width:100%;max-height:100%;top:0%;height:100%;border-radius:0px;'>
	<div id="divEDIT_MAIN"></div>
</div>
<div id="divSHIP" class="divEDITOR">
</div>

<div id="divNEW" class="divEDITOR" style='width:100%;max-width:900px;height:90%;max-height:90%;min-height:300px;'>
    <div id="divNEW_HEADER" style='padding:10px;background: rgba(100, 100, 100, 0.7);cursor:move;width:100%;text-align:left;'>
	    <?php echo $dw3_lbl["NEW_CMD"]; ?>
        <button onclick='closeNEW();' class='dw3_form_close'><span class='material-icons'>close</span></button>
    </div>

	<div class="divBOX">Choisissez un client:
		<input id="selCLI" oninput="getCLIS('');" type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" onclick="detectCLICK(event,this);"  placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
	</div><br>
		<div id="divCLI" style="position:absolute;top:150px;bottom:25px;left:10px;right:10px;overflow-x:hidden;overflow-y:scroll;">		
			Type in search box to find a customer.
		</div><br><input style="display:none;" id="newCLI" type="text">
        <div style="font-size:0.7em;position:absolute;height:25px;bottom:0px;left:10px;right:10px;overflow:hidden;">		
            <span style='box-shadow: inset 0px 0px 4px 2px blue;margin:0px 2px;padding:3px;'>Particulier</span>
            <span style='box-shadow: inset 0px 0px 4px 2px green;margin:0px 2px;padding:3px;'>Compagnie</span>
            <span style='box-shadow: inset 0px 0px 4px 2px orange;margin:0px 2px;padding:3px;'>Détaillant</span>
            <span style='box-shadow: inset 0px 0px 4px 2px grey;margin:0px 2px;padding:3px;'>Interne</span>
        </div>
</div>

<div id="divOPTIONS"  class="divEDITOR">
    <div id='divOPTIONS_HEADER' class='dw3_form_head'>
        <h2>Options</h2>
        <button class='dw3_form_close' onclick='closeOPTIONS();'><span class='material-icons'>cancel</span></button>
    </div>
    <div class='dw3_form_data' id="divOPTIONS_DATA" style='bottom:0px;'></div>
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
var KEY = '<?php echo($_GET['KEY']); ?>';
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
		getCMDS('','',LIMIT);
        getCLIS('');
		document.getElementsByTagName("BODY")[0].onresize = function() {bodyResize()};
	//alert ("<?php echo "1:" . $PAGE1 . " 2:" . $PAGE2; ?>");

    dragElement(document.getElementById("divNEW"));
	});

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

	
//var is_lockQTY = FALSE;
var is_lockQTY = false;
function lockQTY(){
    if (is_lockQTY){
        is_lockQTY = false;
        document.getElementById("span_lockQTY").innerText = "lock_open";
    } else {
        is_lockQTY = true;
        document.getElementById("span_lockQTY").innerText = "lock";
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
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><div style='height:20px;'> </div> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button> <button class='red' onclick='delCMD(" + enID + ");closeMSG();'><span class='material-icons' style='vertical-align:middle;'>delete</span><?php echo $dw3_lbl["DEL"]; ?></button>";
}

function delCMD(enID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			  if (this.responseText.trim() == ""){
					closeEDITOR();
					//document.getElementById("divMSG").style.display = "inline-block";
					//document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_OK"]; ?><div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
					getCMDS('','',LIMIT);
			  } else {
					document.getElementById("divMSG").style.display = "inline-block";
					document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
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
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><div style='height:20px;'> </div> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button> <button class='red' onclick='delLINE(" + enID + "," + lgID + ");closeMSG();'><span class='material-icons' style='vertical-align:middle;'>delete</span><?php echo $dw3_lbl["DEL"]; ?></button>";
}

function delLINE(enID,lgID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			  if (this.responseText.trim() == ""){
                    getCMD_LINE(enID);
					//document.getElementById("divMSG").style.display = "inline-block";
					//document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_OK"]; ?><div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
					getTOTAL(enID);
                    addNotif("<?php echo $dw3_lbl["DEL_OK"]; ?>");
                    document.getElementById("newPRD").focus();
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

function validateCLI(clID,that) {
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
	document.getElementById("newCLI").value = clID;
	//document.getElementById("btnNEW").enabled = true;
    newCMD();
}


function deleteCMDS() {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><div style='height:20px;'> </div> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span>Annuler</button> <button class='red' onclick='delCMDS();'><span class='material-icons' style='vertical-align:middle;'>delete</span>Delete</button>";
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
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
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

function getTOTAL(enID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divTOTAL").innerHTML = this.responseText;
         getGTOTAL(enID);
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

function getCLIS(sS) {
	if(sS==""){sS = document.getElementById("selCLI").value.trim();}
	//if(sS==""){sS="0";}
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divCLI").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getCLIS.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim()) , true);
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
		//xmlhttp.open('GET', '/api/poste_canada/REST/tracking/GetTrackingDetails/GetTrackingDetails.php?KEY=' + KEY + '&enID=' + ID , true);
	xmlhttp.open('GET', '/api/poste_canada/REST/shipping/VoidShipment/VoidShipment.php?KEY=' + KEY + '&enID=' + ID , true);
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
		setEXPED(ID);
	  }
	};
	xmlhttp.open('GET', '/api/livar/delete.php?KEY=' + KEY + '&ID=' + ID , true);
	xmlhttp.send();
	document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='border-radius:10px;width:100px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
}

function getTracking(ID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
	  }
	};
		//xmlhttp.open('GET', '/api/poste_canada/REST/tracking/GetTrackingDetails/GetTrackingDetails.php?KEY=' + KEY + '&enID=' + ID , true);
		xmlhttp.open('GET', '/api/poste_canada/REST/tracking/GetTrackingSummary/GetTrackingSummary.php?KEY=' + KEY + '&enID=' + ID , true);
		xmlhttp.send();
}
function getShipingStatus(enID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
        if (this.responseText == "Livré"){
            updateOrderStatus(enID,'5');
        }
	  }
	};
    xmlhttp.open('GET', '/api/livar/status.php?KEY=' + KEY + '&enID=' + enID , true);
    xmlhttp.send();
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='border-radius:10px;width:100px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";

}
function updateOrderStatus(cmd_id,order_status) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
            addNotif("Status de la commande mise à jour.");
            getCMD(cmd_id);
        }
	};
		xmlhttp.open('GET', 'updSTAT.php?KEY=' + KEY + '&enID=' + cmd_id + '&S=' + order_status , true);
		xmlhttp.send();
}
function getQuote(cmd_id,cmd_trp) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
            document.getElementById("divMSG").style.display = "inline-block";
            document.getElementById("divMSG").innerHTML = "Prix chargé au client: "+cmd_trp+"$<br>Nouveaux prix: "+this.responseText + "$<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
        }
	};
	xmlhttp.open('GET', '/api/livar/quote_one.php?KEY=' + KEY + '&enID=' + cmd_id , true);
	xmlhttp.send();
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "0.6";
	document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='border-radius:10px;width:100px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";

}

function disableExped() {
	if(document.getElementById("createShipmentbtn")){
    	document.getElementById("createShipmentbtn").disabled = true;
    	document.getElementById("quoteShipmentbtn").disabled = true;
	}
	if(document.getElementById("updShipmentbtn")){
    	document.getElementById("updShipmentbtn").disabled = false;
	}
}
function createShipment(ID,carrier) {
    document.getElementById("createShipmentbtn").disabled = true;
    document.getElementById("quoteShipmentbtn").disabled = true;
	document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='border-radius:10px;width:100px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		setEXPED(ID);
	  }
	};
    if (carrier == "DOM.RP" || carrier == "DOM.XP" || carrier == "DOM.EP"){
		xmlhttp.open('GET', '/api/poste_canada/REST/ncshipping/CreateNCShipment/CreateNCShipment.php?KEY=' + KEY + '&enID=' + ID , true);
    } else if (carrier == "ICS" || carrier == "DICOM" || carrier == "NATIONEX" || carrier == "PUROLATOR" || carrier == "UPS" || carrier == "POSTE"){
		xmlhttp.open('GET', '/api/livar/order.php?KEY=' + KEY + '&enID=' + ID , true);
    } else if (carrier == "INTERNAL"){
		xmlhttp.open('GET', 'setSHIP.php?KEY=' + KEY + '&enID=' + ID , true);
    } else {
		document.getElementById("divMSG").innerHTML = "Transporteur invalide pour une expédition.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
	}
	xmlhttp.send();
        //document.getElementById("divFADE2").style.display = "inline-block";
		//document.getElementById("divFADE2").style.opacity = "0.4";
}
function updPRD_OPTION(lnID,optID,optlID,enlnID) {
    var enID  = document.getElementById("enID").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("Option mise à jour.");
        getCMD_LINE(enID);
	  }
	};
		xmlhttp.open('GET', 'updPRD_OPTION.php?KEY=' + KEY + '&lnID=' + lnID + '&optID=' + optID + '&optlID=' + optlID+ '&enlnID=' + enlnID , true);
		xmlhttp.send();
}
function getPRD_OPTIONS(lnID,prID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divOPTIONS").style.display = "inline-block";
		 document.getElementById("divOPTIONS_DATA").innerHTML = this.responseText;
         dragElement(document.getElementById("divOPTIONS"));
	  }
	};
		xmlhttp.open('GET', 'getPRD_OPTIONS.php?KEY=' + KEY + '&lnID=' + lnID + '&prdID=' + prID , true);
		xmlhttp.send();
}
function setEXPED(ID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divSHIP").style.display = "inline-block";
		 document.getElementById("divSHIP").innerHTML = this.responseText;
         dragElement(document.getElementById("divSHIP"));
	  }
	};
		xmlhttp.open('GET', 'getSHIP.php?KEY=' + KEY + '&enID=' + ID , true);
		xmlhttp.send();
}
function getSHIP_BOX() {
	var GRPBOX = document.getElementById("shBOX");
	var sBOX = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		const response = JSON.parse(this.responseText);
		document.getElementById("boxWEIGHT").value = Math.round(response.weight);
		document.getElementById("boxLENGTH").value = Math.round(response.depth);
		document.getElementById("boxHEIGHT").value = Math.round(response.height);
		document.getElementById("boxWIDTH").value = Math.round(response.width);
		document.getElementById("span_box_total").innerHTML = Math.round(response.width*response.height*response.depth);
		document.getElementById("divFADE2").style.opacity = "0";
		setTimeout(function () {
			document.getElementById("divFADE2").style.display = "none";
		}, 500);
		closeMSG();
	  }
	};
		xmlhttp.open('GET', 'getSHIP_BOX.php?KEY=' + KEY + '&ID=' + sBOX , true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
}
function closeSHIP() {
	document.getElementById("divFADE2").style.display = "none";
	document.getElementById("divFADE2").style.opacity = "0";
	document.getElementById("divSHIP").style.display = "none";
}
function closeOPTIONS() {
	document.getElementById("divFADE2").style.display = "none";
	document.getElementById("divFADE2").style.opacity = "0";
	document.getElementById("divOPTIONS").style.display = "none";
}
function applyBoxToOrder(sID){
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
function stripe_cancel_subscription(orderID){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
				getCMD(orderID);
                addNotif("Abonnement annulé.");
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
    xmlhttp.open('GET', '../invoice/stripe_cancel_subscription.php?KEY=' + KEY 
                                    + '&orderID=' + orderID ,   
                                    true);
    xmlhttp.send();
}
function newCMD(){
	var clID  = document.getElementById("newCLI").value;
	
	if (clID == ""){
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
				getCMD(this.responseText.trim());
				document.getElementById("divFADE2").style.display = "none";
				document.getElementById("divFADE2").style.opacity = "0";
				getCMDS('','',LIMIT);
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'newCMD.php?KEY=' + KEY 
										+ '&CLI=' + encodeURIComponent(clID)  ,   
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
                document.getElementById("newPRD").value = "";
                scanUPC();
                if (!is_lockQTY){
                    document.getElementById("newQTE").value = "1";
                }
		  } else {
				document.getElementById("lstPRD").style.display = "inline-block";
				//document.getElementById("divMSG").style.top = "100px";
				document.getElementById("lstPRD").innerHTML = this.responseText;
		  } 
	  }
	};
		xmlhttp.open('GET', 'scanUPC.php?KEY=' + KEY  
										+ '&enID=' + enID    
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
				getCMD_LINE(enID);
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
				getCMD_LINE(enID);
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
function updLGN_DESC(lgID,lgDESC){
	var enID  = document.getElementById("enID").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
				//getCMD_LINE(enID);
                addNotif("Mise à jour de la description terminée");
                closeMSG();
                //getTOTAL(enID);
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updLGN_DESC.php?KEY=' + KEY 
										+ '&ID=' + lgID 
                                        + '&DESC=' + encodeURIComponent(lgDESC) ,   
										true);
		xmlhttp.send();
}
function updLGN_QTY_SHIPPED(lgID,lgQTE){
	var enID  = document.getElementById("enID").value;

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
				//getCMD_LINE(enID);
                addNotif("Mise à jour de la quantité terminée");
                closeMSG();
                //getTOTAL(enID);
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updLGN_QTE_SHIP.php?KEY=' + KEY 
										+ '&ID=' + lgID 
                                        + '&QTE=' + lgQTE ,   
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
function updLGN_RENEW(lgID,lgCHECKED){
	var enID  = document.getElementById("enID").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
				getCMD_LINE(enID);
                addNotif("Mise à jour du renouvellement terminée.");
                closeMSG();
                getTOTAL(enID);
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updLINE_RENEW.php?KEY=' + KEY 
										+ '&ID=' + lgID 
                                        + '&CHECKED=' + lgCHECKED ,   
										true);
		xmlhttp.send();
}
function updLGN_PRICE(lgID,lgPRICE){
	var enID  = document.getElementById("enID").value;
    if (lgPRICE < 0){
        document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "Le prix ne peut pas être négatif. Vous pouvez entrer une escompte dans l'entête de la commande.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
        getCMD_LINE(enID);
        return false;
    }
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
				getCMD_LINE(enID);
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
function sendOrderEmail(){
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divMSG").style.display = "inline-block";
    var usEML  = document.getElementById("enUSEML").value;
    var enEML  = document.getElementById("txtEML").value;
    if (enEML == ""){
        document.getElementById("divMSG").innerHTML = "Veuillez entrer un email de destination<div style='height:20px;'> </div><button onclick='closeMSG();document.getElementById(\"txtEML\").focus();' class='grey'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>";
    }else if (usEML != ""){
        document.getElementById("divMSG").innerHTML = "<b style='color:red;'>Une confirmation par courriel a déjà été envoyé.</b><br>Voulez-vous vraiment envoyer une autre confirmation par courriel?<div style='height:20px;'> </div><button onclick='closeMSG();' class='grey'><span class='material-icons' style='vertical-align:middle;'>cancel</span>Annuler</button><button onclick='sendOrderEmail2();'><span class='material-icons' style='vertical-align:middle;'>outgoing_mail</span> Envoyer</button>";
    }else{
        document.getElementById("divMSG").innerHTML = "Voulez-vous vraiment envoyer une confirmation par courriel?<div style='height:20px;'> </div><button onclick='closeMSG();' class='grey'><span class='material-icons' style='vertical-align:middle;'>cancel</span>Annuler</button><button onclick='sendOrderEmail2();'><span class='material-icons' style='vertical-align:middle;'>outgoing_mail</span> Envoyer</button>";
    }
}
function sendOrderEmail2(){
	var enID  = document.getElementById("enID").value;
    var enEML  = document.getElementById("txtEML").value;
	document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
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
            document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'sendOrderEmail.php?KEY=' + KEY 
										+ '&enID=' + enID 
										+ '&enEML=' + enEML,   
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
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
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
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'subPrepaidCash.php?KEY=' + KEY 
										+ '&ID=' + enID  
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

function updCMD(sID){
	var GRPBOX = document.getElementById("enSTAT");
	var sSTAT = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var sLOC     = document.getElementById("enLOC").value;
	var sDTLV     = document.getElementById("enDTLV").value;
	var sNOTE    = document.getElementById("enNOTE").value;
	var sCIE    = document.getElementById("enCIE").value;
	var sNOM    = document.getElementById("enNOM").value;
	var sADR1    = document.getElementById("enADR1").value;
	var sADR2    = document.getElementById("enADR2").value;
	var sVILLE   = document.getElementById("enVILLE").value;
	var sPROV    = document.getElementById("enPROV").value;
	var sPAYS    = document.getElementById("enPAYS").value;
	var sCP      = document.getElementById("enCP").value;
	var sADR1sh    = document.getElementById("enADR1_SH").value;
	var sADR2sh    = document.getElementById("enADR2_SH").value;
	var sVILLEsh   = document.getElementById("enVILLE_SH").value;
	var sPROVsh    = document.getElementById("enPROV_SH").value;
	var sPAYSsh    = document.getElementById("enPAYS_SH").value;
	var sCPsh      = document.getElementById("enCP_SH").value;
	var sEML      = document.getElementById("txtEML").value;
	var sTEL      = document.getElementById("enTEL").value;
	var sTRP      = document.getElementById("enTRP").value;
	var sDSC      = document.getElementById("enDISCOUNT").value;

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
				getCMDS('','',LIMIT);
                closeMSG();
                addNotif("<?php echo $dw3_lbl["MODIFIED"]; ?>");
                toggleSub('divSub1','up1');
		  } else {
			  	document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updCMD.php?KEY=' + KEY 
										+ '&ID=' + encodeURIComponent(sID)  
										+ '&STAT=' + encodeURIComponent(sSTAT)  
										+ '&LOC=' + encodeURIComponent(sLOC)  
										+ '&CIE=' + encodeURIComponent(sCIE)    
										+ '&NOM=' + encodeURIComponent(sNOM)    
										+ '&DTLV=' + encodeURIComponent(sDTLV)    
										+ '&ADR1=' + encodeURIComponent(sADR1)   
										+ '&ADR2=' + encodeURIComponent(sADR2)   
										+ '&VILLE=' + encodeURIComponent(sVILLE)   
										+ '&PROV=' + encodeURIComponent(sPROV)   
										+ '&PAYS=' + encodeURIComponent(sPAYS)   
										+ '&CP=' + encodeURIComponent(sCP)    
										+ '&ADR1_SH=' + encodeURIComponent(sADR1sh)   
										+ '&ADR2_SH=' + encodeURIComponent(sADR2sh)   
										+ '&VILLE_SH=' + encodeURIComponent(sVILLEsh)   
										+ '&PROV_SH=' + encodeURIComponent(sPROVsh)   
										+ '&PAYS_SH=' + encodeURIComponent(sPAYSsh)   
										+ '&CP_SH=' + encodeURIComponent(sCPsh)    
										+ '&EML=' + encodeURIComponent(sEML)    
										+ '&TEL=' + encodeURIComponent(sTEL)    
										+ '&TRP=' + encodeURIComponent(sTRP)    
										+ '&DSC=' + encodeURIComponent(sDSC)    
										+ '&NOTE=' + encodeURIComponent(sNOTE)   ,                 
										true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
}
function copyADR_TO_SH() {
    document.getElementById("enADR1_SH").value =   document.getElementById("enADR1").value ;
    document.getElementById("enADR2_SH").value =   document.getElementById("enADR2").value ;
    document.getElementById("enVILLE_SH").value =  document.getElementById("enVILLE").value ;
    document.getElementById("enPROV_SH").value =   document.getElementById("enPROV").value ;
    document.getElementById("enPAYS_SH").value =   document.getElementById("enPAYS").value ;
    document.getElementById("enCP_SH").value =     document.getElementById("enCP").value ;
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
	if (document.getElementById("DSP_COL_DTMD").checked == false){ var dspDTMD = 0; } else { var dspDTMD = 1; }
	if (document.getElementById("DSP_COL_STOT").checked == false){ var dspSTOT = 0; } else { var dspSTOT = 1; }

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		   //alert (this.responseText);
		  if (this.responseText == ""){
				getCMDS('','',LIMIT);
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
										+ '&CIE='		+ dspCIE  
										+ '&ADR1=' 		+ dspADR1
										+ '&ADR2=' 		+ dspADR2
										+ '&VILLE=' 	+ dspVILLE
										+ '&PROV=' 		+ dspPROV
										+ '&PAYS=' 		+ dspPAYS
										+ '&CP=' 		+ dspCP 
										+ '&DTAD=' 		+ dspDTAD
										+ '&DTLV=' 		+ dspDTLV
										+ '&DTMD=' 		+ dspDTMD
										+ '&STOT=' 		+ dspSTOT
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