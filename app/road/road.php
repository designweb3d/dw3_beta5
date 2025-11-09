<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/menu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/common_header.php'; 
?>

<div id='divHEAD'><table style="width:100%;margin:0px;white-space:nowrap;"><tr style="margin:0px;padding:0px;"><td width="*" style="margin:0px;padding:0px;">
	  <select name="rtID" id="rtID" onchange="getRTE();">
		<?php
		$sql = "SELECT * FROM road_head
				WHERE id IN(SELECT road_id FROM road_user WHERE user_id = " . $USER . ")				
				ORDER BY name";

		$result = $dw3_conn->query($sql);
		//echo "<option disabled>Administrateurs</option>";
		if ($result->num_rows > 0) {
			if ($USER_RTE == '-1'){
				echo "<option disabled value=''>Veuillez choisir une route ou definir une route par defaut dans vos options utilisateur.</option>";
			}
			while($row = $result->fetch_assoc()) { 
				echo "<option"; if ($USER_RTE == $row["id"]){echo" selected";} echo " value='". $row["id"] . "'>"	. $row["name"] . "</option>";
			}
		}
		?>
	  </select>
	  </td><td width="100"  style="margin:0px;padding:0px;text-align:right;">
		<button style="margin:0px 2px 0px 2px;padding:8px;" id="btnSET_LOC" onclick="SET_LOC();"><span class="material-icons">gps_off</span></button>
		<button style="margin:0px 2px 0px 2px;padding:8px;background:#555555;" onclick="openPARAM();"><span class="material-icons">settings</span></button>
	  </td></tr></table>
</div>
<div id="divNEW"></div>
<div id="divMSG" style='display:inline-block;'>Loading Map<br><img src='/pub/img/load/<?php echo $CIE_LOAD; ?>' style='height:30px;width:auto;margin-top :10px;border-radius:7px;'></div>
<div id="divOPT"></div>
<div id="iMap"></div>
<div id="divEDIT" class="divEDITOR" style="background: rgba(0, 0, 0, 0.3);color:white;">
	<div id='googleMap2' style='display:none;width:100%;height:200px;'></div>
	<div id="panorama" style='width:100%;height:200px;'></div>	
	<div id="divEDIT_MAIN" style="background: rgba(0, 0, 0, 0.7);color:white;"></div>
</div>
<div id='googleMap' style='position:fixed;left:0px;top:46px;bottom:0px;width:100%;'></div>
<div id="directionsPanel" style="position:fixed;right:0px;top:46px;bottom:0px;width:150px;font-size:0.7em;"></div>
<div id="divPARAM" class="divEDITOR" style="padding:10px;background: rgba(55, 55, 55, 0.8);color:white;"><div id="divEDIT_PARAM" style="background: rgba(0, 0, 0, 0.7);color:white;max-height:90vh;overflow-y:auto;"></div></div>
<div id="divFOOT" style='border-radius:0px;left:0px;right:0px;'><table style="width:100%;margin:0px;white-space:nowrap;"><tr style="margin:0px;padding:0px;"><td width="*" style="margin:0px;padding:0px;">
		 <select name="rtCLI" id="rtCLI" onchange="calcRoute('');">
				<option>À definir</option>
	  </select>
	  </td><td width="100" style="margin:0px;padding:0px;text-align:right;">
		<button style="margin:0px 2px 0px 2px;padding:8px;" id="btnSET_LOC" onclick="GO_LOC();"><span class="material-icons">share_location</span></button>
		<button style="margin:0px 2px 0px 2px;padding:8px;" onclick="nextVISITE('');LOC_ON();"><span class="material-icons">skip_next</span></button>
	  </td></tr></table>
</div>
<script type="text/javascript" src="/pub/js/main.js.php?t=<?php echo(rand(100,100000)); echo "&KEY=" . $KEY."&INACTIVE=".$USER_INACTIVE; ?>"></script>
<script src="/pub/js/multiavatar.min.js"></script>
<script>
var KEY = '<?php echo $KEY; ?>';
var startDate  = '2022-01-01';
var endDate    = '2022-03-15';
var diffInMs   = new Date(endDate) - new Date(startDate);
var diffInDays = diffInMs / (1000 * 60 * 60 * 24);
var watchProcess = null;
var markers = [];
var oJ1S1 = JSON.parse('{"data":[{"id":"0"},{"id":"24"}]}');
var destI = 0;
var destID = 0;
var destORD = 0;
var destLAT = 0;
var destLNG = 0;
var destPHONE = 0;
var bReady = false;
var inactivityID;
var inactivityDelay = 10000; //ms
var optDETECT_ALL = true;
var map;
var map2;
var myloc; //marker
var me; //mycoord
var oldPos,newPos;
var opciones = {enableHighAccuracy: true};
var directionsService = null;
//var directionsDisplay = null;
var directionsRenderer = null;
var headerHeight = $("#divHEAD").outerHeight();
var footerHeight = $("#divFOOT").outerHeight();
var windowHeight = window.innerHeight;
var mapContainerHeight = headerHeight + footerHeight;
var totalMapHeight = windowHeight - mapContainerHeight;

$("#googleMap").height(totalMapHeight);
$(window).resize(function(){
        var headerHeight = $("#divHEAD").outerHeight();
        var footerHeight = $("#divFOOT").outerHeight();
        var windowHeight = window.innerHeight;
        var mapContainerHeight = headerHeight + footerHeight;
        var totalMapHeight = windowHeight - mapContainerHeight;
        //$("#googleMap").css("margin-top", headerHeight);
        $("#googleMap").height(totalMapHeight);
        //map.fitBounds(group1.getBounds());
});
	
$(document).ready(function (){
        inactivityID = setInterval(LOC_ON, inactivityDelay);
});

async function initMap() {
	navigator.geolocation.getCurrentPosition(function(position) {
		var pos = {
				lat: position.coords.latitude,
				lng: position.coords.longitude
		};
		oldPos,newPos = new google.maps.LatLng(pos.lat, pos.lng);
		window.pos = pos;
		directionsService = new google.maps.DirectionsService;
		//directionsDisplay = new google.maps.DirectionsRenderer;
		directionsRenderer = new google.maps.DirectionsRenderer({
          preserveViewport: true,
          suppressMarkers: false
        });
		map = new google.maps.Map(document.getElementById("googleMap"), {
			zoom: 18,
			center: {lat: pos.lat, lng: pos.lng},
			heading:0,
			tilt:45,
			mapId: "<?php echo $CIE_GMAP_MAP; ?>",		
		});	
    
		map2 = new google.maps.Map(document.getElementById("googleMap2"), {
			zoom: 16,
			center: {lat: pos.lat, lng: pos.lng},			
		});
		  map.addListener("dragstart", () => {
				if (watchProcess !== null) {
					navigator.geolocation.clearWatch(watchProcess);
					watchProcess = null;
					document.getElementById('btnSET_LOC').innerHTML = "<span class='material-icons'>gps_off</span>";
                    clearInterval(inactivityID);
                    //inactivityID = setInterval(LOC_ON, inactivityDelay);
				}
		  });
		
		//directionsDisplay.setMap(map);
		directionsRenderer.setMap(map);
        directionsRenderer.setPanel(document.getElementById('directionsPanel'));
		me = new google.maps.LatLng(pos.lat, pos.lng);
		var icon = { 
			path: 'M -1.1500216e-4,0 C 0.281648,0 0.547084,-0.13447 0.718801,-0.36481 l 17.093151,-22.89064 c 0.125766,-0.16746 0.188044,-0.36854 0.188044,-0.56899 0,-0.19797 -0.06107,-0.39532 -0.182601,-0.56215 -0.245484,-0.33555 -0.678404,-0.46068 -1.057513,-0.30629 l -11.318243,4.60303 0,-26.97635 C 5.441639,-47.58228 5.035926,-48 4.534681,-48 l -9.06959,0 c -0.501246,0 -0.906959,0.41772 -0.906959,0.9338 l 0,26.97635 -11.317637,-4.60303 c -0.379109,-0.15439 -0.812031,-0.0286 -1.057515,0.30629 -0.245483,0.33492 -0.244275,0.79809 0.0055,1.13114 L -0.718973,-0.36481 C -0.547255,-0.13509 -0.281818,0 -5.7002158e-5,0 Z',
			strokeColor: 'black',
			strokeOpacity: 1,
			strokeWeight: 1,
			fillColor: '#fefe99',
			fillOpacity: 1,
			rotation: 0,
			scale: 1.0
    	}
		myloc = new google.maps.Marker({
			clickable: false,
			icon: '/pub/img/dw3/myloc2.png',
			shadow: null,
			zIndex: 999,
			map: map
		});	
		myloc.setPosition(me);
		$('#divEDIT').appendTo($('#googleMap').find('div')[0]);
		$('#divMSG').appendTo($('#googleMap').find('div')[0]);
		$('#divFADE2').appendTo($('#googleMap').find('div')[0]);
	setTimeout(function() {
			SET_LOC();
			}, 2000);

    setTimeout(function() {
            var sel = document.getElementById('rtID');
            sel.onchange(); 
            }, 4000);
			
	});
}
function angleFromCoordinate(lat1,long1,  lat2, long2) {
	var p1 = {
	x: lat1,
	y: long1
};

var p2 = {
	x: lat2,
	y: long2
};

// angle in radians
var angleRadians = Math.atan2(p2.y - p1.y, p2.x - p1.x);

// angle in degrees
var angleDeg = Math.atan2(p2.y - p1.y, p2.x - p1.x) * 180 / Math.PI;
return angleDeg;
}
function handle_geolocation_query(position) {
	if (newPos.coords){oldPos = newPos;}else{oldPos=position;}
	newPos = position;
	me = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
	myloc.setPosition(me);
	map.setCenter(me);
	var point1 = new google.maps.LatLng(oldPos.lat, oldPos.lng);
	var point2 = new google.maps.LatLng(newPos.lat, newPos.lng);
	//var heading = google.maps.geometry.spherical.computeHeading(point1,point2);
	var distx = Math.abs(oldPos.coords.latitude - newPos.coords.latitude);
	var disty = Math.abs(oldPos.coords.longitude - newPos.coords.longitude);
	var distt = distx + disty;
	//addNotif(distt);
	if (distt > 0.00006){
		var heading = angleFromCoordinate(oldPos.coords.latitude, oldPos.coords.longitude,newPos.coords.latitude, newPos.coords.longitude);
		//myloc.rotation = heading;
		//marker.setIcon('../img/myloc2.png');
		map.setHeading(heading);
	}
	if (distt > 0.00008){
		var heading = angleFromCoordinate(oldPos.coords.latitude, oldPos.coords.longitude,newPos.coords.latitude, newPos.coords.longitude);
		myloc.rotation = heading;
	}
			var pos = {
					lat: position.coords.latitude,
					lng: position.coords.longitude
			};
            if (optDETECT_ALL==false){
                var offsetLAT = Math.abs(destLAT - pos.lat);
                var offsetLNG = Math.abs(destLNG - pos.lng);
                if (bReady == true && offsetLAT <= 0.0004 && offsetLNG <= 0.0004){
                    bReady = false;
                    //alert((dest.lat - pos.lat).toString() + " - " + (dest.lng - pos.lng).toString());
                    //alert (destORD + "\nposlng:" + pos.lng + "\nposlat:" + pos.lat + "\ndestlng:" + destLNG + "\ndestlat:" + destLAT + "\noffsetlng:" + offsetLNG + "\noffsetlat:" + offsetLAT);
                    updVISITE(destID,true);
                    nextVISITE('');
                    //alert (destORD + "\ndestlng:" + destLNG + "\ndestlat:" + destLAT);
                }
            } else {
                let xclnext = 0;
                let xfoundi = 0;
                let bfoundone = false;
                for (let i = 0; i < oJ1S1.data.length; i++) {
                    var offsetLAT = Math.abs(oJ1S1.data[i].lat - pos.lat);
                    var offsetLNG = Math.abs(oJ1S1.data[i].lng - pos.lng);
                    if (bReady == true && offsetLAT <= 0.0004 && offsetLNG <= 0.0004){
                        //bReady = false;
                        //alert((dest.lat - pos.lat).toString() + " - " + (dest.lng - pos.lng).toString());
                        //alert (destORD + "\nposlng:" + pos.lng + "\nposlat:" + pos.lat + "\ndestlng:" + destLNG + "\ndestlat:" + destLAT + "\noffsetlng:" + offsetLNG + "\noffsetlat:" + offsetLAT);
                        if (oJ1S1.data[i].couleur != "SeaGreen"){
                            sendSMS(oJ1S1.data[i].phone,"DW3 - Déneigement en cours. Vérifiez si un véhicule bloque le déneigement du stationnement.");
							oJ1S1.data[i].couleur = "SeaGreen";
                        }
                        updVISITE(oJ1S1.data[i].id,false);
                        //oJ1S1.data[i].phone = "0";
                        //nextVISITE();
                        //alert (destORD + "\ndestlng:" + destLNG + "\ndestlat:" + destLAT);
                        if (destID==oJ1S1.data[i].id){
                            nextVISITE();
                        }
                        bfoundone = true;
                        xfoundi = i;
                    } else {
                        if (bfoundone == true && xclnext == 0){xclnext=i;}
                    }
                    //if (bfoundone == false && xclnext == 0){xclnext=i;}
                }
                //if (bfoundone == true && xclnext == 0) {xclnext = xfoundi+1;}
                //if (xclnext > 0 && xclnext != destI){bReady = false;nextVISITE(xclnext);}
            }
}

function handle_errors(error) {
	switch (error.code) {
		case error.PERMISSION_DENIED:
			//alert("PERMISSION_DENIED");
			break;
		case error.POSITION_UNAVAILABLE:
			//alert("POSITION_UNAVAILABLE");
			break;
		case error.TIMEOUT:
			//alert("TIMEOUT");
			break;
		default:
			//alert("Error desconocido");
			break;
	}
}

function getStreetView(lat, lng) {
    let panorama = new google.maps.StreetViewPanorama(
      document.getElementById('panorama'), {
      position: {lat: parseFloat(lat), lng: parseFloat(lng)},
	  addressControlOptions: {
        position: google.maps.ControlPosition.TOP_LEFT,
      },
	  linksControl: false,
      panControl: false,
      enableCloseButton: false,
    })
    let service = new google.maps.StreetViewService
    service.getPanoramaByLocation(panorama.getPosition(), 50, function(panoData) {
      if (panoData) {
        let panoCenter = panoData.location.latLng
        let heading = google.maps.geometry.spherical.computeHeading(panoCenter, {lat: lat, lng: lng})
        let pov = panorama.getPov()
        pov.heading = heading
        panorama.setPov(pov)
      } else {
        alert('no streetview found')
      }
    })
    map2.setStreetView(panorama) // set dude on map
}

function updVISITE(clID,bNext) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 if (this.responseText == ""){
			 //client updated, referesh markers and go next location ?
			 getRTES1(clID);
			//if (bNext){nextVISITE();}
		 } else {
			document.getElementById("divFADE2").style.display = "inline-block";
			document.getElementById("divFADE2").style.opacity = "0.5";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		 }
	  }
	};
		xmlhttp.open('GET', 'updVISITE.php?KEY=' + KEY + '&clID=' + clID , true);
		xmlhttp.send();
	

}

function updCLI_RTE(sID){
	var sNOTE  = document.getElementById("clNOTE").value;
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		   //alert (this.responseText);
		  if (this.responseText == ""){
				//document.getElementById("divFADE2").style.display = "inline-block";
				//document.getElementById("divFADE2").style.opacity = "0.5";
				//document.getElementById("divMSG").style.display = "inline-block";
				//document.getElementById("divMSG").innerHTML = "Modification réussi.<br><br><button onclick='closeMSG();closeEDITOR();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				getRTES(false);
				closeEDITOR();
		  } else {
				document.getElementById("divFADE2").style.display = "inline-block";
				document.getElementById("divFADE2").style.opacity = "0.5";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updCLI_RTE.php?KEY=' + KEY 
										+ '&ID=' + sID  
										+ '&NOTE=' + encodeURIComponent(sNOTE),    
										true);
		xmlhttp.send();
}



function getRTE() {
	var GRPBOX  = document.getElementById("rtID");
    if (GRPBOX.selectedIndex==-1){return false;}
	var srtID  = GRPBOX.options[GRPBOX.selectedIndex].value;
	if (srtID != ''){
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
		  if (this.readyState == 4 && this.status == 200) {
			  if (this.responseText == ""){
				 document.getElementById("rtCLI").innerHTML = "<option disabled>Aucunes destinations sur cette route actuellement..</option>";
				 document.getElementById("rtCLI").options[0].selected = true;
				 clearMarkers();
				 //directionsDisplay.setMap(null);
				 directionsRenderer.setMap(null);
			  } else {
				 document.getElementById("rtCLI").innerHTML = this.responseText.trim();
				 getRTES(true);
			  }
		  }
		};
		xmlhttp.open('GET', 'getRTE.php?KEY=' + KEY + '&rtID=' + srtID , true);
		xmlhttp.send();
	}	
}
function getRTES(bDRIVE) {
	var GRPBOX  = document.getElementById("rtID");
	var srtID  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  var sOBJ = this.responseText;
		 if (sOBJ != ""){
			 oJ1S1 = JSON.parse(sOBJ);
			 myMap(1);
			destID = oJ1S1.data[destI].id;
			destORD = oJ1S1.data[destI].ord;
			destLNG = oJ1S1.data[destI].lng;
			destLAT = oJ1S1.data[destI].lat;
			destPHONE = oJ1S1.data[destI].phone;
			//alert ("getRTES " + destID);
			 if (bDRIVE){calcRoute('');}
		 }
	  }
	};
		xmlhttp.open('GET', 'getRTES.php?KEY=' + KEY + '&rtID=' + srtID + '&clID=' , true);
		xmlhttp.send();
		
}
function getRTES1(clID) {
	var GRPBOX  = document.getElementById("rtID");
	var srtID  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  var sOBJ = this.responseText;
		  var oONE = JSON.parse(sOBJ);
		 if (sOBJ.trim() != ""){
			for (let i = 0; i < oJ1S1.data.length; i++) {
				if (oJ1S1.data[i].id == clID){
						//oJ1S1.data[i].ord = oONE.data[0].ord;
						//oJ1S1.data[i].lng = oONE.data[0].lng;
						//oJ1S1.data[i].lat = oONE.data[0].lat;
						oJ1S1.data[i].couleur = oONE.data[0].couleur;
						oJ1S1.data[i].note = oONE.data[0].note;
						oJ1S1.data[i].ord = oONE.data[0].ord;
                        var label= { color: '#000', fontWeight: 'bold', fontSize: '19px', text: oONE.data[0].ord };
                        markers[i].setLabel(label);
						markers[i].setIcon({	path: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z',
						fillColor: oONE.data[0].couleur,
						fillOpacity: 1,
						strokeColor: '#000',
						strokeWeight: 2,
						scale: 1.3,
						labelOrigin: new google.maps.Point(0, -29),	});
				return;
				}
			}
		 }
	  }
	};
		xmlhttp.open('GET', 'getRTES.php?KEY=' + KEY + '&rtID=' + srtID+ '&clID=' + clID , true);
		xmlhttp.send();
		
}

function nextVISITE(arrayIndex) {
    textToSpeech(destNOTE);	
	//alert ("next");
	var GRPBOX  = document.getElementById("rtCLI");
	var OPTLEN  = document.getElementById("rtCLI").options.length ;
    if (arrayIndex > 0){
        if (OPTLEN > arrayIndex){
            GRPBOX.options[arrayIndex].selected = true;
        } else if (OPTLEN > 0) {
            GRPBOX.options[0].selected = true;
        }
    }else {
        if (OPTLEN > (GRPBOX.selectedIndex + 1)){
            GRPBOX.options[GRPBOX.selectedIndex + 1].selected = true;
        } else if (OPTLEN > 0) {
            GRPBOX.options[0].selected = true;
        }
    }
	//setDEST();
	GRPBOX.onchange();
}

function setDEST() {
	var GRPBOX  = document.getElementById("rtCLI");
			for (let i = 0; i < oJ1S1.data.length; i++) {
				if (oJ1S1.data[i].id == GRPBOX.options[GRPBOX.selectedIndex].value){
					//alert ("setDEST" + destID);
						destID = oJ1S1.data[i].id;
						destORD = oJ1S1.data[i].ord;
						destLNG = oJ1S1.data[i].lng;
						destLAT = oJ1S1.data[i].lat;
						destNOM= oJ1S1.data[i].nom;
						destNOTE= oJ1S1.data[i].note;
						destPHONE= oJ1S1.data[i].phone;
						destI = i;
				}
			}
}

function textToSpeech(text) {
	if ('speechSynthesis' in window) {
	  var synthesis = window.speechSynthesis;

	  // Get the first `en` language voice in the list
	  var voice = synthesis.getVoices().filter(function (voice) {
		return voice.lang === 'fr';
	  })[0];

	  // Create an utterance object
	  var utterance = new SpeechSynthesisUtterance(text.replace(/&#10;/g, " "));

	  // Set utterance properties
	  utterance.voice = voice;
	  utterance.pitch = 0.8;
	  utterance.rate = 0.8;
	  utterance.volume = 0.8;

	  // Speak the utterance
	  synthesis.speak(utterance);
	} else {
	  console.log('Text-to-speech not supported.');
	}
}

function chgCLI(sID) {
	var GRPBOX  = document.getElementById("rtCLI");
    ///if (sID > GRPBOX.length){sID=1;}
	for (let i = 0; i < GRPBOX.length; i++) {
		if (sID == GRPBOX.options[i].value){
			GRPBOX.options[i].selected = true;
			GRPBOX.onchange();
		}
	}	
}


function calcRoute(end) {
    //addNotif("test");
setDEST();
	if (end == ""){
		end = {
				lat: parseFloat(destLAT),
				lng: parseFloat(destLNG)
			};
	}
	//var path = new google.maps.MVCArray();
	//var poly = new google.maps.Polyline({ map: map, strokeColor: '#dd0000' }); // #4986E7

		var request = {
		origin: me,
		destination: end,
		travelMode: google.maps.DirectionsTravelMode.DRIVING,
        unitSystem: google.maps.UnitSystem.METRIC
		};
		activeInfoWindow&&activeInfoWindow.close();
		directionsService.route(request, function(result, status) {
			if (status == 'OK') {
				//for (var i = 0, len = result.routes[0].overview_path.length; i < len; i++){
                    //path.push(result.routes[0].overview_path[i]);
                //}
			  directionsRenderer.setDirections(result);
			      setTimeout(function () {
					bReady = true;
					}, 5000);
			 
			}
		});

}
function calcAllRoute() {
  //var start = document.getElementById('start').value;
  //var end = document.getElementById('end').value;
  //activeInfoWindow&&activeInfoWindow.close();
  var request = {
	  origin: myloc.position,
	  destination: waypts[waypts.lenght],
	  waypoints: waypts,
	  provideRouteAlternatives: false,
	  travelMode: 'DRIVING',
	  avoidHighways: true,
	  avoidFerries: true,
	  drivingOptions: {
		departureTime: new Date(/* now, or future date */),
		trafficModel: 'pessimistic'
	  },
	  unitSystem: google.maps.UnitSystem.METRIC
	};
  directionsService.route(request, function(result, status) {
    if (status == 'OK') {
      directionsRenderer.setDirections(result);
    }
  });
}


function closeRTE_CFG() {
document.getElementById('divRTE_CFG').style.display = "none";
document.getElementById("divFADE").style.width = "0px";
}

function GO_LOC() {
	LOC_OFF();
	var GRPBOX  = document.getElementById("rtCLI");
	//google.maps.event.trigger( markers[GRPBOX.selectedIndex], 'click' );
	map.setCenter( markers[GRPBOX.selectedIndex].getPosition());
    clearInterval(inactivityID);
    inactivityID = setInterval(LOC_ON, inactivityDelay*2);
}

function LOC_OFF(){
	navigator.geolocation.clearWatch(watchProcess);
	watchProcess = null;
	document.getElementById('btnSET_LOC').innerHTML = "<span class='material-icons'>gps_off</span>";
}
function LOC_ON(){
    if (watchProcess === null) {
        myloc.setPosition(me);
        map.setCenter(me);
        //map.setZoom(16);
        watchProcess = navigator.geolocation.watchPosition(handle_geolocation_query, handle_errors, opciones);
        document.getElementById('btnSET_LOC').innerHTML = "<span class='material-icons'>my_location</span>";
    }
    //calcRoute('');
}

function SET_LOC() {
	if (watchProcess === null) {
		navigator.geolocation.getCurrentPosition(function(position) {
			var pos = {
					lat: position.coords.latitude,
					lng: position.coords.longitude
			};
		
			window.pos = pos;
			me = new google.maps.LatLng(pos.lat, pos.lng);
			myloc.setPosition(me);
			map.setCenter(me);
			map.setZoom(18);
			document.getElementById('divFADE2').style.display= 'none';
			document.getElementById('divFADE2').style.opacity= '0';
			document.getElementById('divMSG').style.display= 'none';
		});
		document.getElementById('btnSET_LOC').innerHTML = "<span class='material-icons'>my_location</span>";
		watchProcess = navigator.geolocation.watchPosition(handle_geolocation_query, handle_errors, opciones);
		
	} else if (watchProcess !== null) {
		navigator.geolocation.clearWatch(watchProcess);
		watchProcess = null;
		document.getElementById('btnSET_LOC').innerHTML = "<span class='material-icons'>gps_off</span>";
	}
}

const waypts = [];
function dropMarkers(sday) {
  clearMarkers();
  
	switch(sday) {
		case 0: //dimanche/drops		
			for (let i = 0; i < oDROPS.data.length; i++) {
				//addMarkerWithTimeout(oDROPS.data[i].lat,oDROPS.data[i].lng, i * 150,oDROPS.data[i].ord,oDROPS.data[i].couleur,oDROPS.data[i].id,oDROPS.data[i].nbj,oDROPS.data[i].j14,oDROPS.data[i].adr,oDROPS.data[i].nom);
			}
			break;
		case 1: //lundi		
			for (let i = 0; i < oJ1S1.data.length; i++) {
				var latlng = new google.maps.LatLng(parseFloat(oJ1S1.data[i].lat), parseFloat(oJ1S1.data[i].lng));
				waypts.push({
					location: latlng,
					stopover: false
				});
				addMarkerWithTimeout(oJ1S1.data[i].lat,oJ1S1.data[i].lng, i * 100,oJ1S1.data[i].ord,oJ1S1.data[i].couleur,oJ1S1.data[i].id,oJ1S1.data[i].adr,oJ1S1.data[i].nom,oJ1S1.data[i].jour,oJ1S1.data[i].heure,oJ1S1.data[i].note,oJ1S1.data[i].phone);
			}
			break;
		case 2: //mardi
			for (let i = 0; i < oJ2S1.data.length; i++) {
				//addMarkerWithTimeout(oJ2S1.data[i].lat,oJ2S1.data[i].lng, i * 150,oJ2S1.data[i].ord,oJ2S1.data[i].couleur,oJ2S1.data[i].id,oJ2S1.data[i].nbj,oJ2S1.data[i].j14,oJ2S1.data[i].adr,oJ2S1.data[i].nom,oJ2S1.data[i].heure);
			}
			break;
		case 3: //mercredi
			for (let i = 0; i < oJ3S1.data.length; i++) {
				//addMarkerWithTimeout(oJ3S1.data[i].lat,oJ3S1.data[i].lng, i * 150,oJ3S1.data[i].ord,oJ3S1.data[i].couleur,oJ3S1.data[i].id,oJ3S1.data[i].nbj,oJ3S1.data[i].j14,oJ3S1.data[i].adr,oJ3S1.data[i].nom,oJ3S1.data[i].heure);
			}
			break;
		case 4: //jeudi
			for (let i = 0; i < oJ4S1.data.length; i++) {
				//addMarkerWithTimeout(oJ4S1.data[i].lat,oJ4S1.data[i].lng, i * 150,oJ4S1.data[i].ord,oJ4S1.data[i].couleur,oJ4S1.data[i].id,oJ4S1.data[i].nbj,oJ4S1.data[i].j14,oJ4S1.data[i].adr,oJ4S1.data[i].nom,oJ4S1.data[i].heure);
			}
			break;
		case 5: //vendredi
			for (let i = 0; i < oJ5S1.data.length; i++) {
				//addMarkerWithTimeout(oJ5S1.data[i].lat,oJ5S1.data[i].lng, i * 150,oJ5S1.data[i].ord,oJ5S1.data[i].couleur,oJ5S1.data[i].id,oJ5S1.data[i].nbj,oJ5S1.data[i].j14,oJ5S1.data[i].adr,oJ5S1.data[i].nom,oJ5S1.data[i].heure);
			}
			break;
	}
}

var activeInfoWindow;
function addMarkerWithTimeout(lat,lng, timeout,ord,couleur,id,adr,nom,jour,heure,note,phone) {
	var latlng = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));
	window.setTimeout(() => {
		var marker = new google.maps.Marker({
			position: latlng,
			map,
            icon: {
				path: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z',
				fillColor: couleur,
				fillOpacity: 1,
				strokeColor: '#000',
				strokeWeight: 2,
				scale: 1.3,
				labelOrigin: new google.maps.Point(0, -29),				
			},
			label: {
			  text: ord.toString(),
			  fontSize: '19px',
			  color: 'black',
			  fontWeight: 'bold',

			},
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
				+ "<button style='color:#000000;position:absolute;top:-10px;left:-10px;background:#ffffff;padding:5px;border-radius:20px;' onclick='mapZOOM(" + lat + "," + lng + ",18);activeInfoWindow&&activeInfoWindow.close();' class='btnMap'><span class='material-icons' style='font-size:22px;vertical-align:center;' >zoom_in</span></button>"
					+ '<b style="font-size:1.5em;">' + nom + '</b>'
					+ "<p><b>" + adr + " </b></p><p>" + note + "</p>"
				+ "</div>"
				+ '<div class="content_header2">'
					+ '<hr><b style="font-size:0.8em;">Dernière visite: ' + jour + ' ' + heure + '</b>'
				+ "</div>"
				+ "<div class='content_body'>"
					+ "<button style='font-size:8px;padding:5px;border-radius:5px;' class='btnMap' onclick='chgCLI(\"" + id + "\");LOC_ON();activeInfoWindow&&activeInfoWindow.close();'><span class='material-icons'>play_arrow</span><br><span>Trajet</span></button>"				
					+ "<button style='font-size:8px;padding:5px;border-radius:5px;' class='btnMap' onclick='chgORD(\"" + id + "\",\"" + ord + "\");activeInfoWindow&&activeInfoWindow.close();'><span class='material-icons'>edit_location_alt</span><br><span>Edit</span></button>"				
					+ "<button style='background:#555555;color:#ffffff;font-size:8px;padding:5px;border-radius:5px;' onclick='EDIT_CLI(\"" + id + "\",\"" + lng + "\",\"" + lat + "\");activeInfoWindow&&activeInfoWindow.close();' class='btnMap'><span class='material-icons'>contact_phone</span><br><span>Infos</span></button>"
					+ "<button style='background:green;font-size:8px;padding:5px;border-radius:5px;' onclick='updVISITE(\"" + id + "\",false);activeInfoWindow&&activeInfoWindow.close();' class='btnMap'><span class='material-icons'>done</span><br><span>Fait!</span></button>"
				+ "</div></div>";
			const infoWindo = new google.maps.InfoWindow({
				content: contentString,
                closeBoxMargin: "0px 0px 2px 2px",
                closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif",
			});
			
			marker.addListener('click', function() {
                LOC_OFF();
                clearInterval(inactivityID);
                //inactivityID = setInterval(LOC_ON, inactivityDelay);
				activeInfoWindow&&activeInfoWindow.close();
				infoWindo.open(map, marker);
				activeInfoWindow = infoWindo;
			});

			markers.push(marker);

		}, timeout);
}

function updORD(sID){
	var GRPBOX  = document.getElementById("rtID");
	var srtID  = GRPBOX.options[GRPBOX.selectedIndex].value;
    var newORD  = document.getElementById("txtORD").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 if (this.responseText == ""){
            addNotif("La position a été mise &#224; jour.");
            closeEDITOR;
            getRTES1(sID);
		 } else {
            document.getElementById("txtORD").style.borderColor = "1px solid red";
         }
	  }
	};
		xmlhttp.open('GET', 'updORD.php?KEY=' + KEY + '&clID=' + sID + '&to=' + newORD + '&rtID=' + srtID, true);
		xmlhttp.send();
}
function switchORD(sID,ord){
	var GRPBOX  = document.getElementById("rtID");
	var srtID  = GRPBOX.options[GRPBOX.selectedIndex].value;
    var newORD  = document.getElementById("txtORD_SWITCH").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 if (this.responseText == ""){
            addNotif("Les positions ont étés mis &#224; jour.");
            closeEDITOR;
            getRTES(false);
		 } else {
            document.getElementById("txtORD").style.borderColor = "1px solid red";
         }
	  }
	};
		xmlhttp.open('GET', 'switchORD.php?KEY=' + KEY + '&clID=' + sID + '&from=' + ord + '&to=' + newORD + '&rtID=' + srtID, true);
		xmlhttp.send();
}

function chgORD(sID,ord){
    clearInterval(inactivityID);
    //inactivityID = setInterval(LOC_ON, inactivityDelay*2);
    document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "0.5";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<h4>Current position: <u>" + ord +"</u></h4><div style='width:250px;margin-top:10px;text-align:left;padding:10px 10px 0 10px;'>To position #:<br><input id='txtORD' type='number' value='' style='vertical-align:center;float:none;display:inline-block;'>"
                                                + "<button onclick=\"updORD('" + sID + "');closeMSG();\"><span class='material-icons' style='vertical-align:middle;'>save</span> Save</button><br>"
	                                            + "<hr>Or switch with position #:<br><input id='txtORD_SWITCH' type='number' value='' style='vertical-align:center;float:none;display:inline-block;'>"
                                                + "<button onclick=\"switchORD('" + sID + "','" + ord + "');closeMSG();\"><span class='material-icons' style='vertical-align:middle;'>change_circle</span> Switch</button>"
                                                + "</div><br><button onclick='closeMSG();' style='background:#555;'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Close</button>";
}


function clearMarkers() {
  for (let i = 0; i < markers.length; i++) {
    markers[i].setMap(null);
  }
  markers = [];
}

function EDIT_CLI(clID, clLNG, clLAT) {
	document.getElementById("divFADE").style.width = "100%";
	 document.getElementById("divFADE").style.display = "inline-block";
     clearInterval(inactivityID);
    //inactivityID = setInterval(LOC_ON, inactivityDelay*2);
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  document.getElementById("divEDIT_MAIN").innerHTML = this.responseText;
		  document.getElementById("divEDIT").style.display = "inline-block";
		  getStreetView(clLAT, clLNG);
	  }
	};
		xmlhttp.open('GET', 'getCLI_RTE.php?KEY=' + KEY + '&clID=' + clID , true);
		xmlhttp.send();
}

function getLocationLNG() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPositionLNG);
  } else { 
    document.getElementById("CLI_LNG").innerHTML = "0";
  }
}
function getLocationLAT() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPositionLAT);
  } else { 
	document.getElementById("CLI_LAT").innerHTML = "0";
  }
}
function showPositionLNG(position) {
	document.getElementById("CLI_LNG").value = position.coords.longitude;
}
function showPositionLAT(position) {
	document.getElementById("CLI_LAT").value = position.coords.latitude; 
}
function myMap(sDAY) {	
	dropMarkers(sDAY);
	switch(sDAY) {
	case 0: //dimanche	
		//var latlng = new google.maps.LatLng(parseFloat(oDROPS.data[0].lat), parseFloat(oDROPS.data[0].lng));
		break;
	case 1: //lundi	
		//var latlng = new google.maps.LatLng(parseFloat(oJ1S1.data[0].lat), parseFloat(oJ1S1.data[0].lng));
		break;
	case 2: //mardi	
		//var latlng = new google.maps.LatLng(parseFloat(oJ2S1.data[0].lat), parseFloat(oJ2S1.data[0].lng));
		break;
	case 3: //mercredi	
		//var latlng = new google.maps.LatLng(parseFloat(oJ3S1.data[0].lat), parseFloat(oJ3S1.data[0].lng));
		break;
	case 4: //jeudi	
		//var latlng = new google.maps.LatLng(parseFloat(oJ4S1.data[0].lat), parseFloat(oJ4S1.data[0].lng));
		break;
	case 5: //vendredi	
		//var latlng = new google.maps.LatLng(parseFloat(oJ5S1.data[0].lat), parseFloat(oJ5S1.data[0].lng));
		break;
	}
}
function chgCarteID() {
    var GRPBOX  = document.getElementById("CarteID");
	var srtID  = GRPBOX.options[GRPBOX.selectedIndex].value;
    if (srtID == 'roadmap'){
        map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
    } else if (srtID == 'satellite'){
        map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
    } else if (srtID == 'hybrid'){
        map.setMapTypeId(google.maps.MapTypeId.HYBRID);
    } else if (srtID == 'terrain'){
        map.setMapTypeId(google.maps.MapTypeId.TERRAIN);
    } else {
        map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
    }
    //closeEDITOR();
    addNotif("Type de carte modifié "+map.getMapTypeId()+" -> "+srtID);
}
function mapZOOM(sLAT,sLNG,sZOOM) {	
	//const El = document.getElementById('CLIENTS');
	//El.scrollTo({top: 0, behavior: 'smooth'});
	map.setCenter(new google.maps.LatLng(sLAT, sLNG));
	map.setZoom(sZOOM); 
	map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
}

function openPARAM() {
	var GRPBOX  = document.getElementById("rtID");
	var srtID  = GRPBOX.options[GRPBOX.selectedIndex].value;
	document.getElementById('divPARAM').style.display = "inline-block";
	document.getElementById("divFADE").style.display = "inline-block";
	document.getElementById("divFADE").style.opacity = "0.6";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 var sOBJ = this.responseText;
		 if (sOBJ != ""){
			 document.getElementById('divEDIT_PARAM').innerHTML = sOBJ;
		 }
	  }
	};
        document.getElementById('divPARAM').style.minHeight = "none";
		xmlhttp.open('GET', 'getPARAM.php?KEY=' + KEY + '&rtID=' + srtID , true);
		xmlhttp.send();
}

function updPRM(){
	var GRPBOX = document.getElementById("CarteID");
	var prmCID= GRPBOX.options[GRPBOX.selectedIndex].value;	
    var prmGPS = document.querySelector('input[name="RTE_GPS"]:checked').value;	
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		   //alert (this.responseText);
		  if (this.responseText == ""){
				closeMSG();
				closeEDITOR();
		  } else {
			  	document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};

		xmlhttp.open('GET', 'updPRM.php?KEY=' + KEY 
										+ '&CID=' 	+ prmCID
										+ '&GPS='	+ prmGPS,
										true);
		xmlhttp.send();
		document.getElementById("divFADE").style.display = "inline-block";
		document.getElementById("divFADE").style.opacity = "0.4";
}

</script>
<?php $dw3_conn->close(); ?>
<script async src="https://maps.googleapis.com/maps/api/js?key=<?php echo $CIE_GMAP_KEY; ?>&callback=initMap&libraries=geometry"></script>
</body>
</html>