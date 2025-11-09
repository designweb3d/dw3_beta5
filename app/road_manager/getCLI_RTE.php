<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$clID  = $_GET['clID'];

if ($USER_LANG == "FR"){
	$LBL_HEAD = "Clients";
	$LBL_SAVE = "Sauvegarder";
	$LBL_NAME = "Nom";
	$LBL_ADR1 = "Adresse";
	$LBL_VILLE= "Ville";
	$LBL_PROV = "Province";
	$LBL_PAYS = "Pays";
	$LBL_CP   = "Code postal";
	$LBL_EML1 = "Courriel";
	$LBL_TEL1 = "Telephone";
	$LBL_LNG = "Longitude";
	$LBL_LAT = "Latitude";
// } else if ($USER_LANG == "ES"){ 
} else {
	$LBL_HEAD = "Customers";
	$LBL_SAVE = "Save";
	$LBL_NAME = "Name";
	$LBL_ADR1 = "Adress";
	$LBL_VILLE= "City";
	$LBL_PROV = "State";
	$LBL_PAYS = "Country";
	$LBL_CP   = "Zip Code";
	$LBL_EML1 = "Email";
	$LBL_TEL1 = "Phone";
	$LBL_LNG = "Longitude";
	$LBL_LAT = "Latitude";	
}


	$sql = "SELECT *
			FROM customer 
			WHERE id = " . $clID . "
			LIMIT 1";

	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {		
		while($row = $result->fetch_assoc()) {
			echo dw3_decrypt($row["adr1"]) . "
				<br>
				<div class='divBOX' style='color:#bbbbbb'><br><b style='color:#ffffff'>" . $LBL_ADR1 . ":</b>
				</div>
				<div class='divBOX' style='color:#bbbbbb'><br><b style='color:#ffffff'>" . $LBL_NAME . ":</b>
					" . dw3_decrypt($row["last_name"]). "
				</div>				
				<div class='divBOX' style='color:#bbbbbb'><br><b style='color:#ffffff'>" . $LBL_EML1 . ":</b>
					" . $row["eml1"] . "
				</div>	
				<div class='divBOX' style='color:red;'><br><b style='color:#ffffff'>" . $LBL_TEL1 . ":</b>
					<a style='color:#bbbbbb;' href='tel:+" . dw3_decrypt($row["tel1"]) . "'><u>" . dw3_decrypt($row["tel1"]) . "</u></a>
				</div><br>
				<div style='width:95%;text-align:left;margin:10px;'>
					<b style='color:#ffffff'>Notes:</b>
					<textarea id='clNOTE' style='width:100%;height:60px;' >" . $row["note"] . "</textarea>
					<br><br>
					<hr><sub>Envoi de SMS</sub><br>
					<div class='divBOX' style='color:#bbbbbb;width:100%;'>
						<select style='width:auto;'>
							<option>Avis arriver dans 15 mins.</option>
							<option>Avis arriver dans 30 mins.</option>
							<option>Avis arriver dans 60 mins.</option>
							<option>Avis de vehicule emcombrant</option>
						</select><button>Envoyer</button>
						<br>
					</div>
				</div><hr>
					<br>
				<button style='background:red;' onclick='delCLI_RTE(\"" . $row["id"] . "\");'><span class='material-icons'>delete</span> Delete</button>
				<button style='background:#555555;' onclick='closeEDITOR();'><span class='material-icons'>cancel</span> Annuler</button>
				<button onclick='updCLI_RTE(\"" . $row["id"] . "\");'><span class='material-icons'>save</span> Sauvegarder</button>
				<br><br>";
		}
	}
$dw3_conn->close();
?>