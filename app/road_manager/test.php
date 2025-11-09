<?php
require '../security.php';
require '../global.php';
require '../menu.php';

if ($USER_LANG == "FR"){
	$LBL_HEAD = "Clients";
	$LBL_CLI = "Nom utilisateur";
	$LBL_SAVE = "Sauvegarder";
	$LBL_FIRSTNAME = "Prenom";
	$LBL_NOM = "Nom";
	$LBL_AUTH = "Type";
	$LBL_NEW = "Nouvelle route";
	$LBL_ADR1 = "Adresse ligne 1";
	$LBL_ADR2 = "Adresse ligne 2";
	$LBL_VILLE= "Ville";
	$LBL_PROV = "Province";
	$LBL_PAYS = "Pays";
	$LBL_CP   = "Code postal";
	$LBL_EML1 = "Courriel";
	$LBL_EML2 = "Courriel secondaire";
	$LBL_PWD = "Mot de passe";
	$LBL_TEL1 = "Telephone";
	$LBL_TEL1 = "Telephone secondaire";
	$LBL_SUPP = "Supérieur immédiat";
	$LBL_LNG = "Longitude";
	$LBL_LAT = "Latitude";
// } else if ($USER_LANG == "ES"){ 
// } else if ($USER_LANG == "IT") {
} else {
	$LBL_HEAD = "Staff";
	$LBL_CLI = "Customers";
	$LBL_SAVE = "Save";
	$LBL_FIRSTNAME = "First Name";
	$LBL_NOM = "Last Name";
	$LBL_AUTH = "Type";
	$LBL_NEW = "New route";
	$LBL_ADR1 = "Adress";
	$LBL_VILLE= "City";
	$LBL_PROV = "State";
	$LBL_PAYS = "Country";
	$LBL_CP   = "Zip Code";
	$LBL_EML1 = "Email";
	$LBL_PWD = "Password";
	$LBL_TEL1 = "Phone";
	$LBL_SUPP = "Immediate superior";
	$LBL_LNG = "Longitude";
	$LBL_LAT = "Latitude";
}	
?>
<html>
  <head>
    <title>User-Editable Shapes</title>
    <script src=""></script>
    <script>
      const process = { env: {} };
      process.env.GOOGLE_MAPS_API_KEY =
        "";
    </script>
  </head>
<body>
<div id="googleMap"></div>


<style>
	#googleMap {
  height: 100%;
}

/* 
 * Optional: Makes the sample page fill the window. 
 */
html,
body {
  height: 100%;
  margin: 0;
  padding: 0;
}
</style>
<script>
var map;
function initMap() {
	  map = new google.maps.Map(document.getElementById("googleMap"), {
		center: { lat: 44.5452, lng: -78.5389 },
		zoom: 9,
	  });
	  const bounds = {
		north: 44.599,
		south: 44.49,
		east: -78.443,
		west: -78.649,
	  };
	  // Define a rectangle and set its editable property to true.
	  const rectangle = new google.maps.Rectangle({
		bounds: bounds,
		editable: true,
		draggable: true,
	  });

	  rectangle.setMap(map);
	  // listen to changes
	  ["bounds_changed", "dragstart", "drag", "dragend"].forEach((eventName) => {
		rectangle.addListener(eventName, () => {
		  console.log({ bounds: rectangle.getBounds()?.toJSON(), eventName });
		});
	  });
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4dHsVkRG9nt3mRegKSxt_3PKeaBAjuVo&callback=initMap&v=weekly" defer ></script>
</body>
</html>