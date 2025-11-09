<?php 
/**
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
				<input type="search" onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" id="inputSEARCH" onkeyup="getFRNS('','',LIMIT);" placeholder="<?php echo $APNAME; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
			</td>
			<td style="width:0;min-width:fit-content;margin:0px;padding:0px 0px 0px 5px;text-align:right;">
				<?php if($APREAD_ONLY == false) { ?><button style="margin:0px 2px 0px 2px;padding:8px;" onclick="openNEW();"><span class="material-icons">add</span></button> <?php } ?>
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
			<option value='0'>Actif</option>
			<option value='1'>Inactif</option>
			<option value='2'>Fermé</option>
			<option value='3'>Banni</option>
			<option selected value=''><?php echo $dw3_lbl["ALL"]; ?></option>
		</select></td></tr>
		<tr><td><?php echo $dw3_lbl["LANG"]; ?></td><td>
		<select id='selLANG'>
			<?php
				$sql = "SELECT DISTINCT(lang)
						FROM supplier 
						WHERE lang <> ''
						ORDER  BY lang
						LIMIT 100";
				$result = $dw3_conn->query($sql);
				if ($result->num_rows > 0) {	
					while($row = $result->fetch_assoc()) {
						echo "<option value='" . $row["lang"]  . "'>" . $row["lang"]  . "</option>";
					}
				}
			?>
			<option selected  value=''><?php echo $dw3_lbl["ALL"]; ?></option>
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
						ORDER BY province
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
		<div style='width:100%;text-align:center;'><button style='background:#444;' onclick="closeFILTRE();"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button><button onclick="closeFILTRE();getFRNS('','',LIMIT);"><span class="material-icons">filter_alt</span> <?php echo $dw3_lbl["FILTER"]; ?></button></div>
</div>

<div id='divMAIN' class='divMAIN' style="padding-top:50px;">
<img src='/pub/img/<?php echo $CIE_LOAD; ?>'>
</div>
<div id="divEDIT" class="divEDITOR">
    <div id='googleMap' style='width:100%;height:200px;margin-top:40px;'></div>
	<div id="divEDIT_MAIN"></div>
</div>
<div id="divNEW" class="divEDITOR">
    <div id='divNEW_HEADER' class='dw3_form_head'>
        <h3><?php echo $dw3_lbl["NEW_FRN"];?></h3>
		<button class='grey' style='top:0px;right:0px;padding:4px;position:absolute;' onclick='closeEDITOR(this);'><span class='material-icons'>cancel</span></button>
    </div> 
    <div style='position:absolute;top:40px;left:0px;bottom:50px;overflow-x:hidden;overflow-y:auto;'>
        <div class="divBOX"><br><?php echo $dw3_lbl["NOM_COMPAGNIE"]; ?>:
            <input id="newNOM" type="text" value="" onclick="detectCLICK(event,this);">
        </div>
        <div class="divBOX"><br><?php echo $dw3_lbl["NOM_CONTACT"]; ?>:
            <input id="newNOM_CONTACT" type="text" value="" onclick="detectCLICK(event,this);">
        </div>
        <div class='divBOX'><br><?php echo $dw3_lbl["ADR1"]; ?>:
            <input id='newADR1' type='text' value="" onclick='detectCLICK(event,this);'>
        </div>
        <div class='divBOX'><br><?php echo $dw3_lbl["ADR2"]; ?>:
            <input id='newADR2' type='text' value="" onclick='detectCLICK(event,this);'>
        </div>
        <div class='divBOX'><br><?php echo $dw3_lbl["VILLE"]; ?>:
            <input id='newVILLE' type='text' value="<?php echo $CIE_VILLE;?>" onclick='detectCLICK(event,this);'>
        </div>
        <div class='divBOX'><br><?php echo $dw3_lbl["PROV"]; ?>:
            <input id='newPROV' type='text' value="Québec" onclick='detectCLICK(event,this);'>
        </div>
        <div class='divBOX'><br><?php echo $dw3_lbl["PAYS"]; ?>:
            <input id='newPAYS' type='text' value="Canada" disabled onclick='detectCLICK(event,this);'>
        </div>
        <div class='divBOX'><br><?php echo $dw3_lbl["CP"]; ?>:
            <input id='newCP' type='text' value="" onclick='detectCLICK(event,this);'>
        </div>
        <div class="divBOX"><br><?php echo $dw3_lbl["TEL1"]; ?>:
            <input id="newTEL1" type="text" value="" onclick="detectCLICK(event,this);">
        </div>	
        <div class="divBOX"><br><?php echo $dw3_lbl["EML1"]; ?>:
            <input id="newEML1" type="text" value="" onclick="detectCLICK(event,this);">
        </div> 
        <br><br>
	</div>
    <div id='divNEW_FOOT' style='padding:3px;background:rgba(200, 200, 200, 0.7);'>
        <button style="background:#555555;" onclick="closeNEW();"><span class="material-icons">cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button>
        <button onclick="newFRN();"><span class="material-icons">add</span><?php echo $dw3_lbl["CREATE"]; ?></button>
	</div>
</div>

<div id="divPARAM"  class="divEDITOR" style="background: rgba(0, 0, 0, 0.7);color:white;overflow-y:auto;">
    <div id='divNEW_HEADER' class='dw3_form_head'>
        <h2 style='background: rgba(44, 44, 44, 0.9);'>Paramètres de l'application</h2>
        <button class='dw3_form_close' onclick='closeEDITOR(this);'><span class='material-icons'>cancel</span></button>
    </div>
    <div class='dw3_form_data' id="divPARAM_DATA"></div>
    <div class='EDIT_FOOT' style='text-align:right;padding:3px;background-image: linear-gradient(to right, rgba(0,0,0,0), rgba(44,44,44,1));'>
        <button onclick='resetPRM()' style='margin:0px 2px 0px 2px;background:#555555;'><span class='material-icons'>restart_alt</span> Réinitialiser</button>
        <button onclick='closeEDITOR()' style='margin:0px 2px 0px 2px;background:#555555;'><span class='material-icons'>cancel</span> Annuler</button>
        <button onclick='updPRM();' style='margin:0px 10px 0px 2px;'><span class='material-icons'>save</span> Enregistrer</button>
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
		getFRNS('','',LIMIT);
		document.getElementsByTagName("BODY")[0].onresize = function() {bodyResize()};
        dragElement(document.getElementById('divNEW'));
	});

function bodyResize() {
	var max_width = Math.max(window.innerWidth, document.documentElement.clientWidth, document.body.clientWidth)/100*95;
	var text_width = Math.floor(max_width/335)*335;
		if (text_width=='0'){text_width='335'} 
	if (document.getElementById("clNOTE")) {
		document.getElementById("clNOTE").style.width = text_width + "px";
	}
}

	
//_	
var KEY = '<?php echo($_GET['KEY']); ?>';
var map;
LIMIT = '12';
function initMap() {
	navigator.geolocation.getCurrentPosition(function(position) {
		var pos = {
				lat: position.coords.latitude,
				lng: position.coords.longitude
		};
		window.pos = pos;
		directionsService = new google.maps.DirectionsService;
		directionsDisplay = new google.maps.DirectionsRenderer;
		directionsRenderer = new google.maps.DirectionsRenderer();
		map = new google.maps.Map(document.getElementById("googleMap"), {
			zoom: 16,
			center: {lat: pos.lat, lng: pos.lng},
		});
		directionsDisplay.setMap(map);
		directionsRenderer.setMap(map);
		var me = new google.maps.LatLng(pos.lat, pos.lng);
		myloc = new google.maps.Marker({
			clickable: false,
			icon: new google.maps.MarkerImage('//maps.gstatic.com/mapfiles/mobile/mobileimgs2.png',
															new google.maps.Size(22,22),
															new google.maps.Point(0,18),
															new google.maps.Point(11,11)),
			shadow: null,
			zIndex: 999,
			map: map
		});	
		myloc.setPosition(me);
	});
}
function setMapPos() {
var pos = {
				lat: 45.571837076516665, 
				lng:-73.66364002065602
		};
	
window.pos = pos;
		map = new google.maps.Map(document.getElementById("googleMap"), {
			zoom: 18,
			center: {lat: pos.lat, lng: pos.lng},
			mapTypeId: 'satellite',
			heading:0,
			tilt:45	
		});
		var me = new google.maps.LatLng(pos.lat, pos.lng);
		myloc = new google.maps.Marker({
			clickable: false,
			icon: new google.maps.MarkerImage('//maps.gstatic.com/mapfiles/mobile/mobileimgs2.png',
															new google.maps.Size(22,22),
															new google.maps.Point(0,18),
															new google.maps.Point(11,11)),
			shadow: null,
			zIndex: 999,
			map: map
		});	
		myloc.setPosition(me);
}
function getLngLat() {
var geocoder = new google.maps.Geocoder();
var address = document.getElementById("newADR1").value;
geocoder.geocode( { 'address': address}, function(results, status) {
  if (status == google.maps.GeocoderStatus.OK)
  {
      document.getElementById("newLNG").value = results[0].geometry.location.lng();
      document.getElementById("newLAT").value = results[0].geometry.location.lat();
  }
});
}	
function getLngLat2() {
var geocoder = new google.maps.Geocoder();
var address = document.getElementById("frADR1").value
				+ " " + document.getElementById("frADR2").value
				+ ", " + document.getElementById("frVILLE").value
				+ " " + document.getElementById("frCP").value
				+ " " + document.getElementById("frPROV").value
				+ " " + document.getElementById("frPAYS").value;
geocoder.geocode( { 'address': address}, function(results, status) {
  if (status == google.maps.GeocoderStatus.OK)
  {
      document.getElementById("frLNG").value = results[0].geometry.location.lng();
      document.getElementById("frLAT").value = results[0].geometry.location.lat();
	  setMapPos();
  }
});
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

//UPDATE GPS 1IER ETAPE 
function updateGPS() {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	var frmFRN  = document.getElementById("frmFRN");

	if (frmFRN.elements.length == 0 || !frmFRN.elements){
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["ERR_SEL1"]; ?><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		return;
	}
	for (var i = 0; i < frmFRN.elements.length; i++ ) 
	{
		if (frmFRN.elements[i].type == 'checkbox')
		{
			if (frmFRN.elements[i].checked == true)
			{
				var sFRN = frmFRN.elements[i].value;
				var sOBJ = "FRADR" + sFRN;
				var sADR  = document.getElementById(sOBJ).value;
				getLngLat3(sFRN,sADR);
			}
		}
	}	
	document.getElementById("divFADE").style.width = "100%";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["MODIFIED"]; ?><br><br><button onclick='closeMSG();closeEDITOR();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
	getFRNS('','',LIMIT);
}
//UPDATE GPS 2IEM ETAPE
function getLngLat3(frID,address) {
	var geocoder = new google.maps.Geocoder();
	geocoder.geocode( { 'address': address}, function(results, status) {
	  if (status == google.maps.GeocoderStatus.OK)
	  {
		  var rlng = results[0].geometry.location.lng();
		  var rlat = results[0].geometry.location.lat();
		  updGPS(frID,rlng,rlat);
	  }
	});
}
//UPDATE GPS 3IEM ET DERNIERE ETAPE
function updGPS(frID,rlng,rlat){	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){
				//document.getElementById("divFADE").style.width = "100%";
				//document.getElementById("divMSG").style.display = "inline-block";
				//document.getElementById("divMSG").innerHTML = "Mise a jour réussi.<br><br><button onclick='closeMSG();closeEDITOR();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				
		  } else {
				//document.getElementById("divFADE").style.width = "100%";
				//document.getElementById("divMSG").style.display = "inline-block";
				//document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'updGPS.php?KEY=' + KEY + '&frID=' + frID + '&LNG=' + encodeURIComponent(rlng) + '&LAT=' + encodeURIComponent(rlat) , true);
		xmlhttp.send();
	
}

function deleteFRN(frID) {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><br><br><button style='background:red;' onclick='delFRN(" + frID + ");'><span class='material-icons' style='vertical-align:middle;'>delete</span><?php echo $dw3_lbl["DEL"]; ?></button> <button style='background:#555555;' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button>";
}

function delFRN(frID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
            addNotif("<?php echo $dw3_lbl["DEL_OK"]; ?>");
            closeMSG();
			getFRNS('','',LIMIT);
            closeEDITOR();
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'delFRN.php?KEY=' + KEY + '&frID=' + frID , true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
        document.getElementById("divMSG").style.display = "inline-block";
        document.getElementById("divMSG").innerHTML = "Veuillez patienter<br><br><img style='border-radius:5px;' src='/pub/img/<?php echo $CIE_LOAD; ?>'>";

}
function deleteFRNS() {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><br><br><button style='background:red;' onclick='delFRNS();'><span class='material-icons' style='vertical-align:middle;'>delete</span>Delete</button> <button style='background:#555555;' onclick='closeMSG();'><span class='material-icons'>cancel</span>Annuler</button>";
}
function delFRNS() {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	var sLST = "";

	var frmFRN  = document.getElementById("frmFRN");
	var sVIRGULE = "";
	
	for (var i = 0; i < frmFRN.elements.length; i++ ) 
	{
		if (frmFRN.elements[i].type == 'checkbox')
		{
			if (frmFRN.elements[i].checked == true)
			{
				if(sLST != ""){sVIRGULE = ","} else { sLST = "("; }
				sLST += sVIRGULE + frmFRN.elements[i].value ;
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
				document.getElementById("divFADE").style.width = "100%";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_OK"]; ?><br><br><button onclick='closeMSG();closeEDITOR();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				getFRNS('','',LIMIT);
		  } else {
				document.getElementById("divFADE").style.width = "100%";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				getFRNS('','',LIMIT);
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'delFRNS.php?KEY=' + KEY + '&LST=' + encodeURIComponent(sLST) , true);
		xmlhttp.send();
		
}

function getFRN(frID) {
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
		 setMapPos();
	  }
	};
		document.getElementById("divFADE").style.width = "100%";
		xmlhttp.open('GET', 'getFRN.php?KEY=' + KEY + '&frID=' + frID + '&tw=' + text_width , true);
		xmlhttp.send();
		
}
function getFRNS(frSTAT,sOFFSET,sLIMIT) {
	var sS = document.getElementById("inputSEARCH").value;
	
	//STAT
	if (frSTAT.trim() == ""){
		var GRPBOX = document.getElementById("selSTAT");
		frSTAT = GRPBOX.options[GRPBOX.selectedIndex].value;		
	}
	//LANG
	var GRPBOX = document.getElementById("selLANG");
	frLANG = GRPBOX.options[GRPBOX.selectedIndex].value;	
	//PAYS
	var GRPBOX = document.getElementById("selPAYS");
	frPAYS = GRPBOX.options[GRPBOX.selectedIndex].value;	
	//PROV
	var GRPBOX = document.getElementById("selPROV");
	frPROV = GRPBOX.options[GRPBOX.selectedIndex].value;	
	//VILLE
	var GRPBOX = document.getElementById("selVILLE");
	frVILLE = GRPBOX.options[GRPBOX.selectedIndex].value;	


	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divMAIN").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getFRNS.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim())
									+ '&frSTAT=' + frSTAT
									+ '&frLANG=' + frLANG
									+ '&frPAYS=' + frPAYS
									+ '&frPROV=' + frPROV
									+ '&frVILLE=' + frVILLE
									+ '&OFFSET=' + sOFFSET 
									+ '&LIMIT=' + sLIMIT  
									, true);
		xmlhttp.send();
		
}
function newFRN(){
	var sNOM  = document.getElementById("newNOM").value;
	var sNOM_CONTACT  = document.getElementById("newNOM_CONTACT").value;
	var sTEL1  = document.getElementById("newTEL1").value;
	var sEML1  = document.getElementById("newEML1").value;
	var sADR1  = document.getElementById("newADR1").value;
	var sADR2  = document.getElementById("newADR2").value;
	var sVILLE  = document.getElementById("newVILLE").value;
	var sPROV  = document.getElementById("newPROV").value;
	var sPAYS  = document.getElementById("newPAYS").value;
	var sCP  = document.getElementById("newCP").value;
	
	if (sNOM == ""){
		document.getElementById("newNOM").style.boxShadow = "5px 10px 15px red";
		document.getElementById("newNOM").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("newNOM").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
		//document.getElementById("lblPRD").innerHTML = "";
	}	
	//if (sADR1 == ""){
		//document.getElementById("newADR1").style.boxShadow = "5px 10px 15px red";
		//document.getElementById("newADR1").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		//return;
	//} else {
		//document.getElementById("newADR1").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
		//document.getElementById("lblPRD").innerHTML = "";
	//}	
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.substr(0, 3) != "Err"){
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["CREATED"]; ?><br><br>"
													+ "<button style='width:100px;height:75px;' onclick='closeMSG();closeNEW();'><span class='material-icons' style='vertical-align:middle;'>done</span><br><?php echo $dw3_lbl["DONE"]; ?></button>"
													+ "<button style='width:100px;height:75px;'  onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>add</span><br><?php echo $dw3_lbl["ANOTHER"]; ?></button>"
													+ "<button style='width:100px;height:75px;'  onclick='closeMSG();closeNEW();getFRN(\"" + this.responseText.trim() + "\")'><span class='material-icons' style='vertical-align:middle;'>edit</span><?php echo $dw3_lbl["REMOD"]; ?></button>";
				getFRNS('','',LIMIT);
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'newFRN.php?KEY=' + KEY 
										+ '&EML1=' + encodeURIComponent(sEML1)   
										+ '&NOM_CONTACT=' + encodeURIComponent(sNOM_CONTACT)    
										+ '&NOM=' + encodeURIComponent(sNOM)    
										+ '&ADR1=' + encodeURIComponent(sADR1)   
										+ '&ADR2=' + encodeURIComponent(sADR2)   
										+ '&VILLE=' + encodeURIComponent(sVILLE)   
										+ '&PROV=' + encodeURIComponent(sPROV)   
										+ '&PAYS=' + encodeURIComponent(sPAYS)   
										+ '&CP=' + encodeURIComponent(sCP)   
										+ '&TEL1='  + encodeURIComponent(sTEL1) ,   
										true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
}
function updFRN(sID){
	var GRPBOX = document.getElementById("frSTAT");
	var sSTAT = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var sNOM     = document.getElementById("frNOM").value;
	var sNOM_CONTACT     = document.getElementById("frNOM_CONTACT").value;
	var sTEL1    = document.getElementById("frTEL1").value;
	var sTEL2    = document.getElementById("frTEL2").value;
	var sADR1    = document.getElementById("frADR1").value;
	var sADR2    = document.getElementById("frADR2").value;
	var sVILLE   = document.getElementById("frVILLE").value;
	var sPROV    = document.getElementById("frPROV").value;
	var sPAYS    = document.getElementById("frPAYS").value;
	var sCP      = document.getElementById("frCP").value;
	var sEML1    = document.getElementById("frEML1").value;
	var sEML2    = document.getElementById("frEML2").value;
	var GRPBOX = document.getElementById("frLANG");
	var sLANG = GRPBOX.options[GRPBOX.selectedIndex].value;
	var sNOTE    = document.getElementById("frNOTE").value;
	var sLNG     = document.getElementById("frLNG").value;
	var sLAT     = document.getElementById("frLAT").value;
	
	if (sNOM == ""){
		document.getElementById("frNOM").style.boxShadow = "5px 10px 15px red";
		document.getElementById("frNOM").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("frNOM").style.boxShadow = "5px 10px 15px #333";
		//document.getElementById("lblPRD").innerHTML = "";
	}
	
	if (sADR1 == ""){
		document.getElementById("frADR1").style.boxShadow = "5px 10px 15px red";
		document.getElementById("frADR1").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("frADR1").style.boxShadow =  "5px 10px 15px #333";
		//document.getElementById("lblPRD").innerHTML = "";
	}
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		   //alert (this.responseText);
		  if (this.responseText == ""){
				//document.getElementById("divMSG").style.display = "inline-block";
				//document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["MODIFIED"]; ?><br><br><button onclick='closeMSG();closeEDITOR();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				getFRNS('','',LIMIT);
                addNotif("<?php echo $dw3_lbl["MODIFIED"]; ?>");
                closeMSG();closeEDITOR();
		  } else {
			  	document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updFRN.php?KEY=' + KEY 
										+ '&ID=' + encodeURIComponent(sID)  
										+ '&STAT=' + encodeURIComponent(sSTAT)     
										+ '&LANG=' + encodeURIComponent(sLANG)     
										+ '&NOM=' + encodeURIComponent(sNOM)   
										+ '&NOM_CONTACT=' + encodeURIComponent(sNOM_CONTACT)   
										+ '&TEL1=' + encodeURIComponent(sTEL1)   
										+ '&TEL2=' + encodeURIComponent(sTEL2)   
										+ '&ADR1=' + encodeURIComponent(sADR1)   
										+ '&ADR2=' + encodeURIComponent(sADR2)   
										+ '&VILLE=' + encodeURIComponent(sVILLE)   
										+ '&PROV=' + encodeURIComponent(sPROV)   
										+ '&PAYS=' + encodeURIComponent(sPAYS)   
										+ '&CP=' + encodeURIComponent(sCP)   
										+ '&EML1=' + encodeURIComponent(sEML1)   
										+ '&EML2=' + encodeURIComponent(sEML2)   
										+ '&NOTE=' + encodeURIComponent(sNOTE)   
										+ '&LNG=' + encodeURIComponent(sLNG)   
										+ '&LAT=' + sLAT ,                 
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
	if (document.getElementById("DSP_COL_ADR").checked == false){ var dspADR = 0; } else { var dspADR = 1; }
	if (document.getElementById("DSP_COL_LANG").checked == false){ var dspLANG = 0; } else { var dspLANG = 1; }
	if (document.getElementById("DSP_COL_STAT").checked == false){ var dspSTAT = 0; } else { var dspSTAT = 1; }
	if (document.getElementById("DSP_COL_NOM").checked == false){ var dspNOM = 0; } else { var dspNOM = 1; }
	//if (document.getElementById("DSP_COL_NOM_CONTACT").checked == false){ var dspNOM_CONTACT = 0; } else { var dspNOM_CONTACT = 1; }
	if (document.getElementById("DSP_COL_ADR1").checked == false){ var dspADR1 = 0; } else { var dspADR1 = 1; }
	if (document.getElementById("DSP_COL_ADR2").checked == false){ var dspADR2 = 0; } else { var dspADR2 = 1; }
	if (document.getElementById("DSP_COL_VILLE").checked == false){ var dspVILLE = 0; } else { var dspVILLE = 1; }
	if (document.getElementById("DSP_COL_PROV").checked == false){ var dspPROV = 0; } else { var dspPROV = 1; }
	if (document.getElementById("DSP_COL_PAYS").checked == false){ var dspPAYS = 0; } else { var dspPAYS = 1; }
	if (document.getElementById("DSP_COL_CP").checked == false){ var dspCP = 0; } else { var dspCP = 1; }
	if (document.getElementById("DSP_COL_TEL1").checked == false){ var dspTEL1 = 0; } else { var dspTEL1 = 1; }
	if (document.getElementById("DSP_COL_TEL2").checked == false){ var dspTEL2 = 0; } else { var dspTEL2 = 1; }
	if (document.getElementById("DSP_COL_EML1").checked == false){ var dspEML1 = 0; } else { var dspEML1 = 1; }
	if (document.getElementById("DSP_COL_EML2").checked == false){ var dspEML2 = 0; } else { var dspEML2 = 1; }
	if (document.getElementById("DSP_COL_LNG").checked == false){ var dspLNG = 0; } else { var dspLNG = 1; }
	if (document.getElementById("DSP_COL_LAT").checked == false){ var dspLAT = 0; } else { var dspLAT = 1; }
	if (document.getElementById("DSP_COL_NOTE").checked == false){ var dspNOTE = 0; } else { var dspNOTE = 1; }
	if (document.getElementById("DSP_COL_DTAD").checked == false){ var dspDTAD = 0; } else { var dspDTAD = 1; }
	if (document.getElementById("DSP_COL_DTMD").checked == false){ var dspDTMD = 0; } else { var dspDTMD = 1; }

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		   //alert (this.responseText);
		  if (this.responseText == ""){
				//document.getElementById("divMSG").style.display = "inline-block";
				//document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["MODIFIED"]; ?><br><br><button onclick='closeMSG();closeEDITOR();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				getFRNS('','',LIMIT);
                //addNotif("<?php echo $dw3_lbl["MODIFIED"]; ?>");
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
										+ '&ADR='		+ dspADR
										+ '&LANG=' 		+ dspLANG
										+ '&STAT='		+ dspSTAT 
										+ '&NOM='		+ dspNOM    
										+ '&ADR1=' 		+ dspADR1
										+ '&ADR2=' 		+ dspADR2
										+ '&VILLE=' 	+ dspVILLE
										+ '&PROV=' 		+ dspPROV
										+ '&PAYS=' 		+ dspPAYS
										+ '&CP=' 		+ dspCP 
										+ '&TEL1=' 		+ dspTEL1
										+ '&TEL2=' 		+ dspTEL2
										+ '&EML1=' 		+ dspEML1
										+ '&EML2=' 		+ dspEML2
										+ '&LNG=' 		+ dspLNG
										+ '&LAT=' 		+ dspLAT
										+ '&DTAD=' 		+ dspDTAD
										+ '&DTMD=' 		+ dspDTMD
										+ '&NOTE=' 		+ dspNOTE,
										true);
		xmlhttp.send();
		//document.getElementById("divFADE2").style.display = "inline-block";
		//document.getElementById("divFADE2").style.opacity = "0.4";
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $CIE_GMAP_KEY; ?>&callback=initMap"></script>
</body>
</html>
<?php $dw3_conn->close(); ?>