<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$rtID  = $_GET['rtID'];

$LOC_ID = "0";
$LOC_ADR = "";

//parametres de l'application selon l'utilisateur
echo "<h2 style='z-index:300;position:sticky;top:0px;background: rgba(44, 44, 44, 0.9);'>" . $dw3_lbl["PARAM"] . "</h2><br>";

	//GPS
	$sql = "SELECT *
			FROM app_prm
			WHERE app_id = '" . $APID . "'
			AND   user_id = '" . $USER . "' 
			AND   name = 'GPS' 
			LIMIT 1";
	$result = $dw3_conn->query($sql);
	echo "<div id='divRTE_CFG_USR' style='background: rgba(33, 133, 33, 0.3);color:#ffffff;padding:5px;text-align:left;'>";
	echo "Activer la localisation GPS:";
	if ($result->num_rows > 0) {	
		while($row = $result->fetch_assoc()) {
			echo "<br>
					  <input ";
			if ($row["value"] == "1"){ echo " checked ";}
			echo "type='radio' id='RTE_GPS_1' name='RTE_GPS' value='1'>
				  <label for='RTE_GPS_1'>Oui</label><br>
				  <input ";
			if ($row["value"] == "0"){ echo " checked ";}
			echo "type='radio' id='RTE_GPS_2' name='RTE_GPS' value='0'>
				  <label for='RTE_GPS_2'>Non</label><br><br>";
		}	
	} else {
		echo "<br>
					  <input type='radio' id='RTE_GPS_1' name='RTE_GPS' value='1'>
			  <label for='RTE_GPS_1'>Oui</label><br>
			  <input checked type='radio' id='RTE_GPS_2' name='RTE_GPS' value='0'>
			  <label for='RTE_GPS_2'>Non</label><br><br>";
	}
	
	//CarteID roadmap/satellite/hybrid/terrain  https://developers.google.com/maps/documentation/javascript/maptypes
	$sql = "SELECT *
			FROM app_prm
			WHERE app_id = '" . $APID . "'
			AND   user_id = '" . $USER . "' 
			AND   name = 'CarteID' 
			LIMIT 1";
	$result = $dw3_conn->query($sql);
	echo "Type de carte:  <select name='CarteID' id='CarteID' onchange='chgCarteID();'>";	
	if ($result->num_rows > 0) {	
		while($row = $result->fetch_assoc()) {
			//roadmap
			echo "<option ";
			if ($row["value"] == 'roadmap'){ echo "selected ";}
			echo "value='roadmap'>RoadMap</option>";
			//satellite
			echo "<option ";
			if ($row["value"] == 'satellite'){ echo "selected ";}
			echo "value='satellite'>Satellite</option>";
			//hybrid
			echo "<option ";
			if ($row["value"] == 'hybrid'){ echo "selected ";}
			echo "value='hybrid'>Hybrid</option>";
			//terrain
			echo "<option ";
			if ($row["value"] == 'terrain'){ echo "selected ";}
			echo "value='terrain'>Terrain</option>";
		}
	} else {
			//roadmap
			echo "<option selected value='roadmap'>RoadMap</option>";
			//satellite
			echo "<option value='satellite'>Satellite</option>";
			//hybrid
			echo "<option value='hybrid'>Hybrid</option>";
			//terrain
			echo "<option value='terrain'>Terrain</option>";
	}
	echo "</select></div><br>";	


//parametres de la ROUTE
/* echo "<h2>Parametres de la route</h2><br>";
		$sql = "SELECT * FROM road_head
			WHERE id = " . $rtID . "
			LIMIT 1";

	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {		
		while($row = $result->fetch_assoc()) {
				echo "<div id='divRTE_CFG_MAIN' style='background: rgba(133, 33, 33, 0.3);padding:5px;color:#ffffff;text-align:left;'>";

				echo "Eviter les autoroutes : <br>
					  <input ";
				if ($row["highway"] == "1"){ echo "checked ";}
				echo "type='radio' id='RTE_HW_1' name='RTE_HW' value='1'>
					  <label for='RTE_HW_1'>Oui</label><br>
					  <input ";
				if ($row["highway"] == "0"){ echo "checked ";}
				echo "type='radio' id='RTE_HW_2' name='RTE_HW' value='0'>
					  <label for='RTE_HW_2'>Non</label><br><br>";

				echo "Eviter les traversiers : <br>
					  <input ";
				if ($row["ferrie"] == "1"){ echo "checked ";}
				echo "type='radio' id='RTE_FERRIE_1' name='RTE_FERRIE' value='1'>
					  <label for='RTE_FERRIE_1'>Oui</label><br>
					  <input ";
				if ($row["ferrie"] == "0"){ echo "checked ";}
				echo "type='radio' id='RTE_FERRIE_2' name='RTE_FERRIE' value='0'>
					  <label for='RTE_FERRIE_2'>Non</label>";

				$LOC_ID = $row["location_id"];
				
				echo "</div><br>";
			
		}
	}
 */
/* echo "<div id='divRTE_CFG_CLI' style='background: rgba(33, 33, 133, 0.3);color:#ffffff;padding:5px;text-align:left;'>"; */
//adresse de depart
/* 	$sql = "SELECT * FROM location";

	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {	
		echo "Adresse de depart :  <select id='rtLOC'>";	
		while($row = $result->fetch_assoc()) {
			echo "<option ";
			if ($LOC_ID ==$row["id"]){ echo "selected ";}
			echo "value='" . $row["id"] . "'>" . $row["adr1"] . "</option>";
		}
		echo "</select></div>";	
	
	} */
		echo "<hr><div style='margin-bottom:15px;'><button style='margin:0px 2px 0px 2px;background:#555555;' onclick='closeEDITOR()'><span class='material-icons'>cancel</span>Annuler</button>
		<button onclick='updPRM()' style='margin:0px 2px 0px 2px;'><span class='material-icons'>save</span> Sauvegarder</button></div>";

$dw3_conn->close();
?>
