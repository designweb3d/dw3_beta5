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
$APNAME = "Adresses et Divisions";
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/common_header.php';
?>
<div id="divHEAD">
	<table style="width:100%;margin:0px;white-space:nowrap;margin-top:5px;">
		<tr style="margin:0px;padding:0px;">
			<td width="*">
                <select id="config_select" onchange="window.open(this.value+'?KEY='+KEY,'_self')">
                    <option value="/app/config/config.php"> Tableau de Bord </option>
                    <option value="/app/config/config_1_info.php"> Infos générales & Facturation </option>
                    <option selected value="/app/config/config_2_location.php"> Adresses et Divisions </option>
                    <option value="/app/config/config_3_structure.php"> Structure de l'entreprise </option>
                    <option value="/app/config/config_4_gouv.php"> Renseignements Gouvernementaux </option>
                    <option value="/app/config/config_5_plan.php"> Plan d'affaire </option>
                    <option value="/app/config/config_6_display.php"> Affichage </option>
                    <option value="/app/config/config_7_index.php"> Index & Pages Web </option>
                    <option value="/app/config/config_8_api.php"> API's, IA's et Réseaux Sociaux </option>
                    <option value="/app/config/config_9_update.php"> Mises à jour & Sécurité </option>
                    <option value="/app/config/config_10_license.php"> Licenses, politiques, conditions et sitemap </option>
                </select>
            </td>
		</tr>
	</table>
</div>

<div id="divMSG"></div>
<div id="divOPT"></div>

<div class="divMAIN" style="margin-top:50px;">
    <div class='divPAGE'>
    <button onclick="openNEW();"><span class="material-icons">add</span>Nouvelle adresse</button><br>
        <div class="divBOX">Adresse facturation:
                <select name='cfgADR1' id='cfgADR1' onchange='saveCFG_LOC();'>
                    <?php
                    echo "<option value='' disabled selected>Veuillez choisir un emplacement.</option>";
                    $sql = "SELECT * FROM location WHERE stat='0' ORDER BY name";
                    $result = $dw3_conn->query($sql);
                    if ($result->num_rows > 0) {	
                        while($row = $result->fetch_assoc()) {
                            if ($row["id"] == $CIE_DFT_ADR1)
                            { 
                                echo "<option value='". $row["id"] . "' selected>"	. $row["name"] . "</option>";
                            } else {
                                echo "<option value='". $row["id"] . "'>"	. $row["name"] . "</option>";
                            }
                        }
                    }
                    ?>
                </select>
        </div>
        <div class="divBOX">Adresse expeditions par défaut:
                <select name="cfgADR2" id="cfgADR2" onchange='saveCFG_LOC();'>
                    <?php
                    echo "<option value='' disabled selected>Veuillez choisir un emplacement.</option>";
                    $sql = "SELECT * FROM location WHERE stat='0' ORDER BY name";
                    $result = $dw3_conn->query($sql);
                    //echo "<option disabled>Administrateurs</option>";
                    if ($result->num_rows > 0) {	
                        while($row = $result->fetch_assoc()) {
                            if ($row["id"] == $CIE_DFT_ADR2)
                            { 
                                $strTMP = " selected"; 
                            } else {
                                $strTMP = " "; 
                            }
                            echo "<option value='". $row["id"] . "' " . $strTMP . ">"	. $row["name"] . "</option>";
                        }
                    }
                    ?>
                </select>
        </div>	
        <div class="divBOX">Adresse ramassage par défaut:
                <select name="cfgADR3" id="cfgADR3" onchange='saveCFG_LOC();'>
                    <?php
                    echo "<option value='' disabled selected>Veuillez choisir un emplacement.</option>";
                    $sql = "SELECT * FROM location WHERE stat='0' AND allow_pickup=1 ORDER BY name";
                    $result = $dw3_conn->query($sql);
                    //echo "<option disabled>Administrateurs</option>";
                    if ($result->num_rows > 0) {	
                        while($row = $result->fetch_assoc()) {
                            if ($row["id"] == $CIE_DFT_ADR3)
                            { 
                                $strTMP = " selected"; 
                            } else {
                                $strTMP = " "; 
                            }
                            echo "<option value='". $row["id"] . "' " . $strTMP . ">"	. $row["name"] . "</option>";
                        }
                    }
                    ?>
                </select>
        </div>	
        <div class="divBOX">
			Titre des adresses pour le choix de location de ramassage / magasin préféré FR:
			<input id="cfgLOC_TITLE_FR" type="text" onchange='saveCFG_LOC();' value="<?php echo $CIE_LOC_TITLE_FR; ?>" onclick="detectCLICK(event,this);">
		</div>
        <div class="divBOX">
			Titre des adresses pour le choix de location de ramassage / magasin préféré EN:
			<input id="cfgLOC_TITLE_EN" type="text" onchange='saveCFG_LOC();' value="<?php echo $CIE_LOC_TITLE_EN; ?>" onclick="detectCLICK(event,this);">
		</div>
        <div id='divLOCS'></div>
    </div>
</div>

<div id="divNEW" class="dw3_form">
	<div class='dw3_form_head' id="divNEW_HEADER">
        <h3 style='vertical-align:middle;height:40px;'><div style='display: grid;align-items: center;height:40px;'><?php echo $dw3_lbl["NEW_LOC"]; ?></div></h3>
		<button class='dw3_form_close' onclick='closeNEW();'><span class='material-icons'>cancel</span></button>
    </div>
	<div  class='dw3_form_data'>
		<div class="divBOX">
			<?php echo $dw3_lbl["NAME"]; ?>:	
			<input id="newNOM" type="text" value="" onclick="detectCLICK(event,this);">
		</div>
        <div class="divBOX">Type:
            <select id='newTYPE'>
                <option value='1'>Succursale</option>
                <option value='6'>Bureaux</option>
                <option value='3'>Entrepôt</option>
                <option value='2'>Franchise</option>
                <option value='5'>Usine</option>
                <option value='4'>Résidence</option>
            </select>
        </div>
		<div class="divBOX">
			Adresse:
			<input id="newADR1" type="text" value="" onclick="detectCLICK(event,this);">
		</div>
		<div class="divBOX">
			Ville:
			<input id="newVILLE" type="text" value="" onclick="detectCLICK(event,this);">
		</div>
		<div class="divBOX">
			Code Postal:
			<input id="newCP" type="text" value="" onclick="detectCLICK(event,this);">
		</div>
		<div class="divBOX">
			Province:
			<select name="newPROV" id="newPROV">
					<option value="QC">Québec</option>
					<option value="ON">Ontario</option>
					<option value="AB">Alberta</option>
					<option value="BC">Colombie-Britannique</option>
					<option value="PE">l'Île-du-Prince-Édouard</option>
					<option value="MB">Manitoba</option>
					<option value="NB">Nouveau-Brunswick</option>
					<option value="NS">Nouvelle-Écosse</option>
					<option value="SK">Saskatchewan </option>
					<option value="NF">Terre-Neuve-et-Labrador</option>
				</select>
		</div>
		<div class="divBOX">Pays:
			<input disabled id="newPAYS" type="text" value="Canada" onclick="detectCLICK(event,this);">
		</div>
		<div class="divBOX">Telephone:
			<input id="newTEL1" type="text" value="" onclick="detectCLICK(event,this);">
		</div>
		<div class="divBOX">Email:
			<input id="newEML1" type="text" value="" onclick="detectCLICK(event,this);">
		</div>
		<br><br>
	</div>
	<div class='dw3_form_foot'>
		<button class='grey' onclick="closeEDITOR();"><span class="material-icons">cancel</span>Annuler</button>  
		<button class='blue' onclick="saveNEW_LOC();"><span class="material-icons">save</span> Créer</button>
    </div>

</div>

<div id="divEDIT" class="divEDITOR">
    <div id="divEDIT_HEADER" class='dw3_form_head'>
    <h3 style='vertical-align:middle;height:40px;'><div style='display: grid;align-items: center;height:40px;'><?php if ($USER_LANG == "FR"){echo "Location";}else{echo "Location";} ?></div></h3>
        <button class='dw3_form_close' onclick='closeEDITOR();closeMSG();'><span class='material-icons'>close</span></button>
    </div>
        <div id='googleMap' style='width:100%;height:200px;margin-top:40px;'></div>
        <div id="divEDIT_MAIN"></div>
</div>

<script type="text/javascript" src="/pub/js/main.js.php?t=<?php echo(rand(100,100000)); echo "&KEY=" . $KEY."&INACTIVE=".$USER_INACTIVE; ?>"></script>
<script src="/pub/js/multiavatar.min.js"></script>
<script>
var KEY = '<?php echo($_GET['KEY']); ?>';
var client_devtools = function() {};
var cfgHOME = "<?php echo $CIE_HOME; ?>";
var myloc;
var map;

$(document).ready(function (){
    dragElement(document.getElementById('divNEW'));
    dragElement(document.getElementById('divEDIT'));
    document.getElementById('config_select').value="/app/config/config_2_location.php";
    getLOCS();
});

window.addEventListener( "pageshow", function ( event ) {
  var historyTraversal = event.persisted || 
                         ( typeof window.performance != "undefined" && 
                              window.performance.navigation.type === 2 );
  if ( historyTraversal ) {
    window.location.reload();
  }
});

function initMap() {
	  map = new google.maps.Map(document.getElementById("googleMap"), {
		center: { lat: 45.64, lng: -73.71 },
		zoom: 11,
	  });
}

function getLOCS() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divLOCS").innerHTML = this.responseText;
		
	  }
	};
		xmlhttp.open('GET', 'getLOCS.php?KEY=' + KEY, true);
		xmlhttp.send();
		
}

function setMapPos() {
if (document.getElementById("laLAT").value.length) {var sLAT = document.getElementById("laLAT").value;} else { var sLAT = 45.7;}
if (document.getElementById("laLAT").value.length) {var sLNG = document.getElementById("laLNG").value;} else {var sLNG = -73.7; }
var pos = {
				lat: parseFloat(sLAT),
				lng: parseFloat(sLNG)
		};
		
window.pos = pos;
		map = new google.maps.Map(document.getElementById("googleMap"), {
			zoom: 16,
			center: {lat: pos.lat, lng: pos.lng},
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

function getLOC(laID) {
	document.getElementById("divFADE").style.opacity = "0.6";
    document.getElementById("divFADE").style.display = "inline-block";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divEDIT_MAIN").innerHTML = this.responseText;
		 document.getElementById("divEDIT").style.display = "inline-block";
         <?php if ($CIE_GMAP_KEY!=""){ ?>
		 setTimeout(setMapPos, 1000);
         <?php } ?>
         dragElement(document.getElementById('divEDIT'));
	  }
	};
		xmlhttp.open('GET', 'getLOC.php?KEY=' + KEY + '&LOCID=' + laID , true);
		xmlhttp.send();
}


//nouvelle location
function saveNEW_LOC(){
	var sNOM = document.getElementById("newNOM").value;
	var GRPBOX  = document.getElementById("newTYPE");
	var sTYPE  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var sEML1  = document.getElementById("newEML1").value;
	var sADR1  = document.getElementById("newADR1").value;
	var sTEL1  = document.getElementById("newTEL1").value;
	var sVILLE = document.getElementById("newVILLE").value;
	var GRPBOX = document.getElementById("newPROV");
	var sPROV  = GRPBOX.options[GRPBOX.selectedIndex].value;
	//var sPAYS  = document.getElementById("newPAYS").value;
	var sCP    = document.getElementById("newCP").value;
	//var GRPBOX = document.getElementById("newSTAT");
	//var sSTAT  = GRPBOX.options[GRPBOX.selectedIndex].value;
	//var sUSID  = document.getElementById("newUSID").value;
	
	if (sNOM == ""){
		document.getElementById("newNOM").style.borderColor = "red";
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("newNOM").style.borderColor = "grey";
		//document.getElementById("lblPRD").innerHTML = "";
	}
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == "0"){
				//document.getElementById("divFADE").style.opacity = "0.6";
                //document.getElementById("divFADE").style.display = "inline-block";
				//document.getElementById("divMSG").style.display = "inline-block";
				//document.getElementById("divMSG").innerHTML = "Location créée.<div style='height:20px;'> </div><button onclick='closeMSG();closeEDITOR();document.getElementById(\"rfLOC\").scrollIntoView({behavior: \"smooth\", block: \"start\", inline: \"nearest\"});'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                addNotif("Location créée.");
                closeEDITOR();
				getLOCS();
		  } else {
				document.getElementById("divFADE").style.opacity = "0.6";
                document.getElementById("divFADE").style.display = "inline-block";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'newLOC.php?KEY=' + KEY
										+ '&NOM=' +   encodeURIComponent(sNOM)
										+ '&EML1=' + encodeURIComponent(sEML1)  
										+ '&ADR1=' + encodeURIComponent(sADR1)  
										+ '&TYPE=' + sTYPE  
										+ '&TEL1=' + sTEL1  
										+ '&VILLE='+ sVILLE 
										+ '&PROV=' + sPROV   
										+ '&CP='   + sCP,    
										true);
		xmlhttp.send();
}


function updLOC(sID){
	var sSQUARE   = document.getElementById("laSQUARE").value;
	var sNOM   = document.getElementById("laNOM").value;
	var GRPBOX = document.getElementById("laTYPE");
	var sTYPE  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var sEML1  = document.getElementById("laEML1").value;
	var sADR1  = document.getElementById("laADR1").value;
	var sADR2  = document.getElementById("laADR2").value;
	var sTEL1  = document.getElementById("laTEL1").value;
	var sVILLE = document.getElementById("laVILLE").value;
	var GRPBOX = document.getElementById("laPROV");
	var sPROV  = GRPBOX.options[GRPBOX.selectedIndex].value;
	//var sPAYS  = document.getElementById("laPAYS").value;
	var sCP    = document.getElementById("laCP").value;
	var sLNG    = document.getElementById("laLNG").value;
	var sLAT    = document.getElementById("laLAT").value;
	var GRPBOX = document.getElementById("laSTAT");
	var sSTAT  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX = document.getElementById("laUSID");
	var sUSID  = GRPBOX.options[GRPBOX.selectedIndex].value;
    if (document.getElementById("laPICKUP").checked == false){var sPICKUP = "0"; } else { var sPICKUP ="1"; }

	if (sNOM == ""){
		document.getElementById("laNOM").style.borderColor = "red";
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("laNOM").style.borderColor = "grey";
		//document.getElementById("lblPRD").innerHTML = "";
	}
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == "0"){
                closeEDITOR();
                addNotif("Sauvegarde réussi.");
				getLOCS();
		  } else {
				document.getElementById("divFADE").style.opacity = "0.6";
                document.getElementById("divFADE").style.display = "inline-block";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updLOC.php?KEY=' + KEY
										+ '&NOM=' +   encodeURIComponent(sNOM)
										+ '&ID=' + sID
										+ '&SQUARE=' + sSQUARE
										+ '&TYPE=' + sTYPE
										+ '&PICKUP=' + sPICKUP
										+ '&EML1=' +  encodeURIComponent(sEML1)  
										+ '&ADR1=' + encodeURIComponent(sADR1)  
										+ '&ADR2=' + encodeURIComponent(sADR2)  
										+ '&TEL1=' + encodeURIComponent(sTEL1)  
										+ '&VILLE='+ encodeURIComponent(sVILLE) 
										+ '&PROV=' + encodeURIComponent(sPROV)   
										+ '&USID=' + sUSID  
										+ '&STAT=' + sSTAT
										+ '&LNG=' + sLNG
										+ '&LAT=' + sLAT 
										+ '&CP='   + sCP,    
										true);
		xmlhttp.send();
}

function delLOC(sID){

	if (sID == "1"){
				document.getElementById("divFADE").style.opacity = "0.6";
                document.getElementById("divFADE").style.display = "inline-block";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = "Cet emplacement ne peut être supprimé.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		return;
	}
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == "0"){
				document.getElementById("divFADE").style.opacity = "0.6";
                document.getElementById("divFADE").style.display = "inline-block";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = "Suppression terminée.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				getLOCS();
                closeEDITOR();
		  } else {
				document.getElementById("divFADE").style.opacity = "0.6";
                document.getElementById("divFADE").style.display = "inline-block";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'delLOC.php?KEY=' + KEY 
										+ '&ID=' + sID,    
										true);
		xmlhttp.send();
}
function saveCFG_LOC(){
	var sLOC_TITLE_FR = document.getElementById("cfgLOC_TITLE_FR").value;
	var sLOC_TITLE_EN = document.getElementById("cfgLOC_TITLE_EN").value;
	var GRPBOX  = document.getElementById("cfgADR1");
	var sADR1  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX  = document.getElementById("cfgADR2");
	var sADR2  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX  = document.getElementById("cfgADR3");
	var sADR3  = GRPBOX.options[GRPBOX.selectedIndex].value;
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif(this.responseText);
	  }
	};
		xmlhttp.open('GET', 'updCFG_LOC.php?KEY=' + KEY 
										+ '&PTF=' + encodeURIComponent(sLOC_TITLE_FR)  
										+ '&PTE=' + encodeURIComponent(sLOC_TITLE_EN)  
										+ '&ADR1=' + encodeURIComponent(sADR1)  
										+ '&ADR2=' + encodeURIComponent(sADR2) 
										+ '&ADR3=' + encodeURIComponent(sADR3) ,
										true);
		xmlhttp.send();
}

function getLngLat() {
var geocoder = new google.maps.Geocoder();
var address = document.getElementById("laADR1").value + " " + document.getElementById("laADR2").value + " " + document.getElementById("laVILLE").value + " " + document.getElementById("laPROV").value + " " + document.getElementById("laPAYS").value + " " + document.getElementById("laCP").value;
geocoder.geocode( { 'address': address}, function(results, status) {
  if (status == google.maps.GeocoderStatus.OK)
    {
        document.getElementById("laLNG").value = results[0].geometry.location.lng();
        document.getElementById("laLAT").value = results[0].geometry.location.lat();
        setMapPos();
    }
    });
}


function addMarkerWithTimeout(lat,lng, timeout,ord,couleur,id,adr,nom,heure,note) {
	var latlng = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));
	window.setTimeout(() => {
		var marker = new google.maps.Marker({
			position: latlng,
			map,
			
			animation: google.maps.Animation.DROP,
			});
			var iLnk = "<a href='http://maps.apple.com/?daddr=" + lat + "," + lng + "&dirflg=d'><button class='btnMap' style='font-size:8px;padding:5px;'><span class='material-icons'>explore</span><br><span>Drive</span></button></a>";
			var isIphone = !!navigator.platform.match(/iPhone|iPod|iPad/);
			if (!isIphone){
				iLnk = "<a href='https://www.google.com/maps/dir/?api=1&destination=" + lat + "," + lng + "'><button class='btnMap' style='font-size:8px;padding:5px;border-radius:5px;'><span class='material-icons'>map</span><br><span>Drive</span></button></a>";
			}
			const contentString =
				  '<div id="content_' + id + '">'
				+ '<div class="content_header" >'
				+ "<button style='color:#000000;position:absolute;top:-10px;left:-10px;background:#ffffff;padding:5px;border-radius:20px;' onclick='mapZOOM(" + lat + "," + lng + ",18)' class='btnMap'><span class='material-icons' style='font-size:22px;vertical-align:center;' >zoom_in</span></button>"
					+ '<b style="font-size:1.5em;">' + nom + '</b>'
				+ "</div>"
				+ '<div class="content_header2">'
					+ "<p><b>" + adr + " </b></p><br><p>" + note + "</p>"
				+ "</div>"
				+ "<div class='content_body'>"
					+ "<button style='background:#555555;color:#ffffff;font-size:8px;padding:5px;border-radius:5px;' onclick='EDIT_CLI(\"" + id + "\",\"" + lng + "\",\"" + lat + "\");' class='btnMap'><span class='material-icons'>edit</span><br><span>Infos</span></button>"
					+ "<button style='font-size:8px;padding:5px;border-radius:5px;' class='btnMap' onclick='document.getElementById(\"chkCLI" + id + "\").checked = true;'><span class='material-icons'>check_box</span><br><span>Selectionner</span></button>"				
				+ "</div></div>";
			const infoWindo = new google.maps.InfoWindow({
				content: contentString,
			});
			marker.addListener('click', function() {
				activeInfoWindow&&activeInfoWindow.close();
				infoWindo.open(map, marker);
				activeInfoWindow = infoWindo;
			});
			markers.push(marker);

		}, timeout);
}

</script>
<?php if ($CIE_GMAP_KEY!=""){ ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $CIE_GMAP_KEY; ?>&callback=initMap&v=weekly" defer ></script>
<?php } ?>
</body>
</html>
<?php $dw3_conn->close();exit(); ?>
