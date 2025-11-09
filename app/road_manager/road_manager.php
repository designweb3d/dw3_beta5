<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/menu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/common_header.php'; 
?>

<div id='divHEAD'><table style="width:100%;margin:0px;white-space:nowrap;"><tr style="margin:0px;padding:0px;"><td width="*" style="margin:0px;padding:0px;">
	  <select name="selID" id="selID" onchange="getRTE();">
		<?php
		$sql = "SELECT * FROM road_head ORDER BY name";
		$result = $dw3_conn->query($sql);
		//echo "<option disabled>Administrateurs</option>";
		if ($result->num_rows > 0) {
			echo "<optgroup label='Routes'>";
			while($row = $result->fetch_assoc()) {
				echo " <option value='". $row["id"] . "'>"	. $row["name"] . "</option>";
			}
			echo "</optgroup>";
		} else {
			echo " <option value='-1' disabled>Pour créér une route appuyez sur --> [+]</option>";
		}
		?>
	  </select>
	  </td><td width="100" style="margin:0px;padding:0px;text-align:right;">
		<button style="margin:0px 2px 0px 2px;padding:8px;"  onclick="openHEAD_POPUP();"><span class="material-icons">add</span></button>
		<button style="margin:0px 2px 0px 2px;padding:8px;background:#555555;" onclick="showTB(0);"><span class="material-icons">settings</span></button>
	  </td></tr></table>
</div>
<div id="divHEAD_POPUP">
	<button onclick="openNewRTE();" style="width:140px;"> + Route</button>
	<button onclick="openNewUSR();" style="width:140px;"> + Utilisateur</button>
	<button onclick="openNewCLI();" style="width:140px;"> + Destination</button>
</div>

<div id='divMAIN' class='divMAIN' style="padding-top:50px;">
</div>
<br><br>
<div id="divEDIT" class="divEDITOR">
    <div id='divEDIT_HEADER' style='cursor:move;position:absolute;top:0px;right:0px;left:0px;height:40px;background:rgba(207, 205, 205, 0.9);'>
        <h3 style='vertical-align:middle;height:40px;'><div style='display: grid;align-items: center;height:40px;'>Utilisateurs de la route</div></h3>
		<button style='background:#555555;top:0px;right:0px;padding:4px;position:absolute;' onclick='closeEDITOR(this);'><span class='material-icons'>close</span></button>
    </div>
<div id="divEDIT_MAIN" style='position:absolute;top:40px;left:0px;width:100%;bottom:50px;overflow-x:hidden;overflow-y:auto;'></div>
</div>
<div id="divNEW" class="divEDITOR">
    <div id='divNEW_HEADER' style='cursor:move;position:absolute;top:0px;right:0px;left:0px;height:40px;background:rgba(207, 205, 205, 0.9);'>
        <h3 style='vertical-align:middle;height:40px;'><div style='display: grid;align-items: center;height:40px;'>Nouvelle route</div></h3>
		<button style='background:#555555;top:0px;right:0px;padding:4px;position:absolute;' onclick='closeEDITOR(this);'><span class='material-icons'>close</span></button>
    </div>
    <div style='position:absolute;top:40px;left:0px;width:100%;bottom:50px;overflow-x:hidden;overflow-y:auto;'>
        <div class="divBOX"><br>Nom/# de route:
            <input id="newNOM" type="text" value="" onclick="detectCLICK(event,this);">
        </div>
        <div class="divBOX"><br>Adresse de départ:
                <select name="newLOC" id="newLOC">
                    <?php
                    $sql = "SELECT *
                            FROM location
                            WHERE stat=0				
                            ORDER BY name";

                    $result = $dw3_conn->query($sql);
                    //echo "<option disabled>Administrateurs</option>";
                    if ($result->num_rows > 0) {	
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='". $row["id"] . "'>"	. $row["name"] . " - " . substr($row["adr1"],0,20)  . "</option>";
                        }
                    }
                    ?>
                </select>
        </div>	
        <br><br><hr>Fréquence des visites :<br>
        <div class='divBOX'>En jours:
            <input id='newFREQ_JOUR' type='number' value="0" onclick='detectCLICK(event,this);'>
        </div>
        <div class='divBOX'>ET heures :<br>
            <input id='newFREQ_HEURE' type='number' value="0" onclick='detectCLICK(event,this);'>
        </div>
        <br><br><hr>Paramètres de carte par default :<br>
        <div class='divBOX'>Éviter les autoroutes:<br>
            <label class='switch'>
            <input id='newMAP_HIGHWAY' type='checkbox'>
            <span class='slider round'></span>
            </label>	</div>
        <div class='divBOX'>Éviter les traversiers:<br>
            <label class='switch'>
            <input id='newMAP_FERRIE' type='checkbox'>
            <span class='slider round'></span>
            </label>
        </div>
    </div>
    <div id='divNEW_FOOT' style='padding:3px;background:rgba(200, 200, 200, 0.7);'>
        <button style="background:#444444;" onclick="closeEDITOR();"><span class="material-icons">cancel</span>Annuler</button>
        <button onclick="newRTE();"><span class="material-icons">save</span>Créer</button>
    </div>
</div>

<div id="divMAP">
    <input type="text" id="rDEST">
    <select id="fDEST">
        <option value="0">Aucun filtre</option>
        <option value="1">Filtrer les destinations deja sur cette route</option>
        <option selected value="2">Filtrer les destinations qui ont deja une route</option>
    </select>
	<div id='googleMap' style='height:400px;'></div>
	<button style="background:#444444;" onclick="closeMAP();"><span class="material-icons">close</span> Fermer</button>
	<button id='btnNewSearch' onclick="newSearch();" style="display:none;"><span class="material-icons">refresh</span>Nouvelle recherche</button>
	<button id='btnSearch' onclick="getMapOutput();"><span class="material-icons">search</span>Rechercher cette zone</button>
	<div id='mapOutput' style='width:100%;'></div>
</div>
<div id="divMSG"></div>
<div id="divOPT"></div>
<script type="text/javascript" src="/pub/js/main.js.php?t=<?php echo(rand(100,100000)); echo "&KEY=" . $KEY."&INACTIVE=".$USER_INACTIVE; ?>"></script>
<script src="/pub/js/multiavatar.min.js"></script>
<script>
$(document).ready(function ()
    {
		document.getElementById("divHEAD_POPUP").style.display = "none";
		
		//$("#googleMap").height(500);
		var selID = document.getElementById("selID");
		if (selID.options.length > 0){
			selID.selectedIndex = 0;
			selID.onchange();
		}
        dragElement(document.getElementById("divEDIT"));
        dragElement(document.getElementById("divNEW"));

	});
	
$(window).resize(function(){

      //  $("#googleMap").height(500);

});
var KEY = '<?php echo ($KEY); ?>';
var map;
var mapRECT;
var markers = [];
var dest = JSON.parse('{"data":[{"id":"0"},{"id":"24"}]}');
var rectangle;
var activeInfoWindow;

function initMap() {
	  map = new google.maps.Map(document.getElementById("googleMap"), {
		center: { lat: 45.64, lng: -73.71 },
		zoom: 11,
	  });
	  //MARKERS
		//getDEST();
	  
	  //RECT
	  mapRECT = {
		north: 45.66,
		south: 45.59,
		east: -73.66,
		west: -73.75,
	  };
	  
	  rectangle = new google.maps.Rectangle({
		bounds: mapRECT,
		editable: true,
		draggable: true,
		strokeColor: "#FF0000",
		strokeOpacity: 0.7,
		strokeWeight: 2,
		fillColor: "#FF0000",
		fillOpacity: 0.35
	  });

	  rectangle.setMap(map);
	  // listen to changes
	  //["bounds_changed", "dragstart", "drag", "dragend"].forEach((eventName) => {
	  ["bounds_changed", "dragend"].forEach((eventName) => {
		rectangle.addListener(eventName, () => {
		  console.log({ bounds: rectangle.getBounds()?.toJSON(), eventName });
		  mapRECT = rectangle.getBounds()?.toJSON();
		});
	  });
}


function newSearch() {
	clearMarkers();
	document.getElementById("mapOutput").innerHTML = "";
	document.getElementById("btnNewSearch").style.display = "none";
	document.getElementById("btnSearch").style.display = "inline-block";
	showRect();
}
function clearMarkers() {
  for (let i = 0; i < markers.length; i++) {
    markers[i].setMap(null);
  }
  markers = [];
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
function mapZOOM(sLAT,sLNG,sZOOM) {	
	//const El = document.getElementById('CLIENTS');
	//El.scrollTo({top: 0, behavior: 'smooth'});
	map.setCenter(new google.maps.LatLng(sLAT, sLNG));
	map.setZoom(sZOOM); 
	//map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
}


function showRect(){
		rectangle.setMap(null);
		rectangle = new google.maps.Rectangle({map: map,
		bounds: mapRECT,
		editable: true,
		draggable: true,
		strokeColor: "#FF0000",
		strokeOpacity: 0.7,
		strokeWeight: 2,
		fillColor: "#FF2323",
		fillOpacity: 0.30});
		rectangle.setMap(map);
	  ["bounds_changed", "dragend"].forEach((eventName) => {
		rectangle.addListener(eventName, () => {
		  console.log({ bounds: rectangle.getBounds()?.toJSON(), eventName });
		  mapRECT = rectangle.getBounds()?.toJSON();
		});
	  });
}
function hideRect(){
		rectangle.setMap(null);
		rectangle = new google.maps.Rectangle({map: map,
		bounds: mapRECT,
		editable: false,
		draggable: false,
		strokeColor: "#DD3333",
		strokeOpacity: 0.6,
		strokeWeight: 1,
		fillColor: "#666666",
		fillOpacity: 0.15});
		rectangle.setMap(map);
}
function getMapOutput(){
	var GRPBOX  = document.getElementById("selID");
	var rtID  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX  = document.getElementById("fDEST");
	var fDEST  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var rDEST  = document.getElementById("rDEST").value;
	clearMarkers();
	document.getElementById("divHEAD_POPUP").style.display = "none";
	//document.getElementById("divFADE").style.opacity = "0.6";
	//document.getElementById("divFADE").style.display = "inline-block";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		document.getElementById("mapOutput").innerHTML = this.responseText;
		document.getElementById("btnSearch").style.display = "none";
		document.getElementById("btnNewSearch").style.display = "inline-block";
		getDEST();
		hideRect();
	  }
	};
		xmlhttp.open('GET', 'getCLIS.php?KEY=' + KEY + '&rtID=' + rtID + "&f=" + fDEST + "&r=" + encodeURIComponent(rDEST)
									 + '&n=' + mapRECT.north
									 + '&s=' + mapRECT.south
									 + '&e=' + mapRECT.east
									 + '&w=' + mapRECT.west
												, true);
		xmlhttp.send();
}
function getDEST(){
	var GRPBOX  = document.getElementById("selID");
	var rtID  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX  = document.getElementById("fDEST");
	var fDEST  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var rDEST  = document.getElementById("rDEST").value;

    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		dest = JSON.parse(this.responseText);
		for (let i = 0; i < dest.data.length; i++) {
			addMarkerWithTimeout(dest.data[i].lat,dest.data[i].lng, i * 150,dest.data[i].ord,dest.data[i].couleur,dest.data[i].id,dest.data[i].adr,dest.data[i].nom,dest.data[i].heure,dest.data[i].note);
		}
	  }
	};
		xmlhttp.open('GET', 'getDEST.php?KEY=' + KEY + '&rtID=' + rtID + "&f=" + fDEST + "&r=" + encodeURIComponent(rDEST)
									 + '&n=' + mapRECT.north
									 + '&s=' + mapRECT.south
									 + '&e=' + mapRECT.east
									 + '&w=' + mapRECT.west , true);
		xmlhttp.send();
}

function openNewRTE(){
	document.getElementById("divHEAD_POPUP").style.display = "none";
	document.getElementById("divNEW").style.display = "inline-block";
	document.getElementById("divFADE").style.opacity = "0.6";
	document.getElementById("divFADE").style.display = "inline-block";
    document.getElementById("newNOM").focus();
}

function openNewUSR(){
	var GRPBOX  = document.getElementById("selID");
    var rtID  = GRPBOX.options[GRPBOX.selectedIndex].value;
    if (rtID  == "-1"){
        document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "Vous devaz d'abbord créer une route.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='closeMSG();openNewRTE()'><span class='material-icons' style='vertical-align:middle;'>map</span>Créer une route</button>";
        return false;
    }
	document.getElementById("divHEAD_POPUP").style.display = "none";
	 document.getElementById("divFADE").style.opacity = "0.6";
	 document.getElementById("divFADE").style.display = "inline-block";
	 
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divEDIT_MAIN").innerHTML = this.responseText;
		 document.getElementById("divEDIT").style.display = "inline-block";
		 document.getElementById("divEDIT").style.opacity = "1";
	  }
	};
		xmlhttp.open('GET', 'getUSERS.php?KEY=' + KEY + '&rtID=' + rtID , true);
		xmlhttp.send();
}


/* function openNewCLI_old(){
	document.getElementById("divHEAD_POPUP").style.display = "none";
	var GRPBOX  = document.getElementById("selID");
	var rtID  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divEDIT").innerHTML = this.responseText;
		 document.getElementById("divEDIT").style.display = "inline-block";
		 document.getElementById("divEDIT").style.opacity = "1";
	  }
	};
		xmlhttp.open('GET', 'getCLIS.php?KEY=' + KEY + '&rtID=' + rtID , true);
		xmlhttp.send();
} */
function openNewCLI(){
	document.getElementById("divHEAD_POPUP").style.display = "none";
    var GRPBOX  = document.getElementById("selID");
    var rtID  = GRPBOX.options[GRPBOX.selectedIndex].value;
    if (rtID  == "-1"){
        document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "Vous devaz d'abbord créer une route.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='closeMSG();openNewRTE()'><span class='material-icons' style='vertical-align:middle;'>map</span>Créer une route</button>";
        return false;
    }
	document.getElementById("divMAP").style.display = "inline-block"; 
}
	
function getRTE() {
	var GRPBOX  = document.getElementById("selID");
    if (GRPBOX.options[GRPBOX.selectedIndex].value !=""){
        var rtID  = GRPBOX.options[GRPBOX.selectedIndex].value;
        
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("divMAIN").innerHTML = this.responseText;
                if ($('#TBody1').length > 0) {
                document.getElementById("TBody1").setAttribute("hidden", "hidden");
                }
                if ($('#TBody0').length > 0) {
                document.getElementById("TBody0").setAttribute("hidden", "hidden");
                }
        }
        };
            //document.getElementById("divFADE2").style.width = "100%";
            xmlhttp.open('GET', 'getRTE.php?KEY=' + KEY + '&rtID=' + rtID , true);
            xmlhttp.send();
    }
}

    function submitForm(event){
        event.preventDefault();


    }

function calcDESTS(rtID){
document.getElementById("divFADE2").style.display = "inline-block";
document.getElementById("divFADE2").style.opacity = "1";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.trim() == ""){
				//window.location.reload();
				//document.getElementById("divMSG").style.display = "inline-block";
				//document.getElementById("divMSG").innerHTML = "Triage termin&#233;<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				getRTE();
                closeMSG();
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'calcDESTS.php?KEY=' + KEY + '&rtID=' + rtID,    
										true);
		xmlhttp.send();

}

function newRTE(){
		document.getElementById("divFADE").style.display = "inline-block";
		document.getElementById("divFADE").style.opacity = "1";
	var sNOM  = document.getElementById("newNOM").value;
	var sFJR  = document.getElementById("newFREQ_JOUR").value;
	var sFHR  = document.getElementById("newFREQ_HEURE").value;
	if (document.getElementById("newMAP_HIGHWAY").checked == true){var sMHW  = "1"; } else { var sMHW  = "0"; }
	if (document.getElementById("newMAP_FERRIE").checked == true){var sMFR  = "1"; } else { var sMFR  = "0"; }

	var GRPBOX  = document.getElementById("newLOC");
	var sLOC = GRPBOX.options[GRPBOX.selectedIndex].value;
	
	if (sNOM == ""){
		document.getElementById("newNOM").style.boxShadow = "5px 10px 15px red";
		document.getElementById("newNOM").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("newNOM").style.borderColor = "lightgrey";
		//document.getElementById("lblPRD").innerHTML = "";
	}	
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  const response = JSON.parse(this.responseText);
		  if (response.result == "ok"){
                closeEDITOR();
                var x = document.getElementById("selID");
                var option = document.createElement("option");
                option.text = sNOM;
                option.value = response.data;
                option.disabled = false;
                option.selected = true;
                x.add(option);
                addNotif("La route " + sNOM + " a été ajouté.");
                x.onchange();

		  } else {
		
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'newRTE.php?KEY=' + KEY + '&'
										+ 'NOM=' + encodeURIComponent(sNOM)   
										+ '&LOC=' + sLOC    
										+ '&FJR=' + sFJR    
										+ '&FHR=' + sFHR    
										+ '&MHW=' + sMHW    
										+ '&MFR=' + sMFR ,   
										true);
		xmlhttp.send();
}
function updRTE(){
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	var GRPBOX  = document.getElementById("selID");
	var sID  = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var GRPBOX  = document.getElementById("rtLOC");
	var sLOC  = GRPBOX.options[GRPBOX.selectedIndex].value;
	
	var sNOM  = document.getElementById("rtNOM").value;
	var sFJR  = document.getElementById("rtFREQ_JOUR").value;
	var sFHR  = document.getElementById("rtFREQ_HEURE").value;
	if (document.getElementById("rtMAP_HIGHWAY").checked == true){var sMHW  = "1"; } else { var sMHW  = "0"; }
	if (document.getElementById("rtMAP_FERRIE").checked == true){var sMFR  = "1"; } else { var sMFR  = "0"; }
	
	if (sNOM == ""){
		document.getElementById("rtNOM").style.boxShadow = "5px 10px 15px red";
		document.getElementById("rtNOM").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("rtNOM").style.boxShadow = "0px";
		//document.getElementById("lblPRD").innerHTML = "";
	}
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		   //alert (this.responseText);
		  if (this.responseText == ""){
				//document.getElementById("divMSG").style.display = "inline-block";
				//document.getElementById("divMSG").innerHTML = "Modification réussi.<br><br><button onclick='closeMSG();closeEDITOR();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				getRTE();
                closeMSG();
                //closeEDITOR();
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updRTE.php?KEY=' + KEY + '&'
										+ 'ID=' + sID  
										+ '&NOM=' + encodeURIComponent(sNOM)   
										+ '&LOC=' + sLOC     
										+ '&FJR=' + sFJR     
										+ '&FHR=' + sFHR 
										+ '&MHW=' + sMHW     
										+ '&MFR=' + sMFR ,    
										true);
		xmlhttp.send();
}
function addUSERS(){
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "1";
		
	var sLST = "";
	var GRPBOX  = document.getElementById("selID");
	var rtID  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var frmSEL  = document.getElementById("frmSEL");
	var sVIRGULE = "";
	
	for (var i = 0; i < frmSEL.elements.length; i++ ) 
	{
		if (frmSEL.elements[i].type == 'checkbox')
		{
			if (frmSEL.elements[i].checked == true)
			{
				if(sLST != ""){sVIRGULE = ","}
				sLST += sVIRGULE + "(" + rtID + "," + frmSEL.elements[i].value + ")";
			}
		}
	}	
	if (sLST == ""){
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "Aucun utilisateur choisi<button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		return;
	}

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		   //alert (this.responseText);
		  if (this.responseText == ""){
				//document.getElementById("divMSG").style.display = "inline-block";
				//document.getElementById("divMSG").innerHTML = "Ajout terminé avec succès.<br><br><button onclick='closeMSG();closeEDITOR();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				getRTE();
                closeMSG();closeEDITOR();
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'addUSERS.php?KEY=' + KEY
										+ '&USER=' + encodeURIComponent(sLST),    
										true);
		xmlhttp.send();
}

function addCLIS(){
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	var sLST = "";
	var GRPBOX  = document.getElementById("selID");
	var rtID  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var frmSEL  = document.getElementById("frmDEST");
	var sVIRGULE = "";
	
	for (var i = 0; i < frmSEL.elements.length; i++ ) 
	{
		if (frmSEL.elements[i].type == 'checkbox')
		{
			if (frmSEL.elements[i].checked == true)
			{
				if(sLST != ""){sVIRGULE = ","}
				sLST += sVIRGULE + "(" + rtID + "," + frmSEL.elements[i].value + ")";
			}
		}
	}	
	if (sLST == ""){
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "Aucune destination choisie<button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		return;
	}
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		   //alert (this.responseText);
		  if (this.responseText == ""){
				//document.getElementById("divMSG").style.display = "inline-block";
				//document.getElementById("divMSG").innerHTML = "Ajout terminé avec succès.<br><br><button onclick='closeMSG();closeMAP();document.getElementById(\"mapOutput\").innerHTML = \"\";activeInfoWindow.close();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				getRTE();closeMSG();closeEDITOR();
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'addCLIS.php?KEY=' + KEY + '&'
										+ 'rtID=' + rtID  
										+ '&CLIS=' + encodeURIComponent(sLST),    
										true);
		xmlhttp.send();
}
function updORD(that,sRtId, sClId){
	var sORD  = that.value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		   //alert (this.responseText);
		  if (this.responseText == ""){
				getRTE();
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updORD.php?KEY=' + KEY + '&'
										+ 'clID=' + sClId  
										+ '&rtID=' + sRtId   
										+ '&clORD=' + sORD ,    
										true);
		xmlhttp.send();
}
function delRTE() {
	var GRPBOX  = document.getElementById("selID");
	var rtID  = GRPBOX.options[GRPBOX.selectedIndex].value;
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Voulez vous vraiment supprimer la route ?<br><br> <button style='background:#444444;' onclick='closeMSG();'><span class='material-icons'>cancel</span>Annuler</button> <button style='background:red;' onclick='delRTE2(" + rtID + ");'><span class='material-icons' style='vertical-align:middle;'>delete</span>Delete</button>";
}
function delRTE2(rtID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){
				//document.getElementById("divMSG").style.display = "inline-block";
				//document.getElementById("divMSG").innerHTML = "Suppression réussi.<br><br><button onclick='closeMSG();closeEDITOR();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				//getRTES();
				closeMSG();closeEDITOR();
                window.location.reload();
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'delRTE.php?KEY=' + KEY + '&ID=' + rtID , true);
		xmlhttp.send();
		
}

function delUSR() {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	var sLST = "";
	var GRPBOX  = document.getElementById("selID");
	var rtID  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var frmUSR  = document.getElementById("frmUSR");
	var sVIRGULE = "";
	
	for (var i = 0; i < frmUSR.elements.length; i++ ) 
	{
		if (frmUSR.elements[i].type == 'checkbox')
		{
			if (frmUSR.elements[i].checked == true)
			{
				if(sLST != ""){sVIRGULE = ","} else { sLST = "("; }
				sLST += sVIRGULE + frmUSR.elements[i].value ;
			}
		}
	}	
	if (sLST == ""){
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "Aucun utilisateur choisie<button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		return;
	} else { sLST += ")"; }
	
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){
				//document.getElementById("divFADE").style.width = "100%";
				//document.getElementById("divMSG").style.display = "inline-block";
				//document.getElementById("divMSG").innerHTML = "Suppression réussi.<br><br><button onclick='closeMSG();closeEDITOR();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				getRTE();closeMSG();
		  } else {
				document.getElementById("divFADE").style.width = "100%";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'delUSR.php?KEY=' + KEY + '&ID=' + rtID + '&LST=' + encodeURIComponent(sLST) , true);
		xmlhttp.send();
		
}

function delCLI() {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	var sLST = "";
	var GRPBOX  = document.getElementById("selID");
	var rtID  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var frmCLI  = document.getElementById("frmCLI");
	var sVIRGULE = "";
	
	for (var i = 0; i < frmCLI.elements.length; i++ ) 
	{
		if (frmCLI.elements[i].type == 'checkbox')
		{
			if (frmCLI.elements[i].checked == true)
			{
				if(sLST != ""){sVIRGULE = ","} else { sLST = "("; }
				sLST += sVIRGULE + frmCLI.elements[i].value ;
			}
		}
	}	
	if (sLST == ""){
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "Aucune destination choisie<button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		return;
	} else { sLST += ")"; }
	
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){
				//document.getElementById("divFADE").style.width = "100%";
				//document.getElementById("divMSG").style.display = "inline-block";
				//document.getElementById("divMSG").innerHTML = "Suppression réussi.<br><br><button onclick='closeMSG();closeEDITOR();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				getRTE();closeMSG();
		  } else {
				document.getElementById("divFADE").style.width = "100%";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'delCLI.php?KEY=' + KEY + '&ID=' + rtID + '&LST=' + encodeURIComponent(sLST) , true);
		xmlhttp.send();
		
}

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $CIE_GMAP_KEY; ?>&callback=initMap&v=weekly" defer ></script>

</body>
</html>