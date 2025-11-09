<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 

$laID   = $_GET['LOCID'];
$laNOM   = "";
$laTYPE  = "";
$laEML1  = "";
$laADR1  = "";
$laADR2  = "";
$laTEL1  = "";
$laVILLE = "";
$laPROV  = "";
$laPAYS  = "";
$laCP    = "";
$laSTAT  = "";
$laUSID  = "";
		
	$sql = "SELECT * FROM location WHERE id = " . $laID . " LIMIT 1";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {		
		while($row = $result->fetch_assoc()) {
			$laNOM   = htmlspecialchars($row["name"], ENT_QUOTES) ;
			$laTYPE  = $row["type"] ;
			$laPICKUP  = $row["allow_pickup"] ;
			$laEML1  = htmlspecialchars($row["eml1"], ENT_QUOTES) ;
			$laADR1  = htmlspecialchars($row["adr1"], ENT_QUOTES) ;
			$laADR2  = htmlspecialchars($row["adr2"], ENT_QUOTES) ;
			$laTEL1  = $row["tel1"] ;
			$laVILLE = htmlspecialchars($row["city"], ENT_QUOTES) ;
			$laPROV  = htmlspecialchars($row["province"], ENT_QUOTES) ;
			$laPAYS  = htmlspecialchars($row["country"], ENT_QUOTES) ;
			$laCP    = $row["postal_code"] ;
			$laLNG    = $row["longitude"] ;
			$laLAT    = $row["latitude"] ;
			$laSTAT  = $row["stat"] ;
			$laUSID  = $row["user_id"] ;
			$laSQUARE  = $row["square_id"] ;
		echo "<div class='dw3_form_data' style='top:240px;'>
                <div class='divBOX' style='width:100%;'><br>Status:
                    <select name='laSTAT' id='laSTAT'>
                    <option value='0'"; if 	($laSTAT =="0"){ echo " selected"; } echo ">Actif</option>
                    <option value='1'"; if 	($laSTAT =="1"){ echo " selected"; } echo ">Inactif</option>
                    <option value='2'"; if 	($laSTAT =="2"){ echo " selected"; } echo ">Prospection</option>
                    <option value='3'"; if 	($laSTAT =="3"){ echo " selected"; } echo ">En achat</option>
                    <option value='4'"; if 	($laSTAT =="4"){ echo " selected"; } echo ">En vente</option>
                    <option value='5'"; if 	($laSTAT =="5"){ echo " selected"; } echo ">En location</option>
                    <option value='6'"; if 	($laSTAT =="6"){ echo " selected"; } echo ">Vendu</option>
                    </select>
				</div>
				<div class='divBOX'><br>Type de localisation:
					  <select name='laTYPE' id='laTYPE'" ; if 	($laTYPE =="8" || $laTYPE =="7"){ echo " disabled "; } echo ">
							<option value='8'"; if 	($laTYPE =="8"){ echo " selected"; } echo ">Maison mère</option>
							<option value='1'"; if 	($laTYPE =="1"){ echo " selected"; } echo ">Succursale</option>
							<option value='2'"; if 	($laTYPE =="2"){ echo " selected"; } echo ">Franchise</option>
							<option value='7'"; if 	($laTYPE =="7"){ echo " selected"; } echo ">Détaillant</option>
							<option value='3'"; if 	($laTYPE =="3"){ echo " selected"; } echo ">Entrepôt</option>
							<option value='4'"; if 	($laTYPE =="4"){ echo " selected"; } echo ">Résidence</option>
							<option value='5'"; if 	($laTYPE =="5"){ echo " selected"; } echo ">Usine</option>
							<option value='6'"; if 	($laTYPE =="6"){ echo " selected"; } echo ">Bureaux</option>
						  </select>
                        <small>La maison mère ne peut être supprimée. Les détaillants sont des clients qui revendent nos produits et services. Ils peuvent êtres changés de type que par la fiche client.</small>
				</div>
                <div class='divBOX'><label for='laPICKUP' style='max-width:75%;'>Disponible pour les commandes web et ramassage en magasin:</label>
                    <input id='laPICKUP' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' "; if($laPICKUP == "1"){echo " checked ";} echo">
                </div>
				<div class='divBOX'><br>" . $dw3_lbl["NAME"] . ": 
					<input id='laNOM' type='text' value='" . $laNOM . "' onclick='detectCLICK(event,this);'>
				</div>
				<div class='divBOX'><br>" . $dw3_lbl["ADR1"] . ": 
					<input id='laADR1' type='text' value='" . $laADR1 . "' onclick='detectCLICK(event,this);'>
				</div>
				<div class='divBOX'><br>" . $dw3_lbl["ADR2"] . ": 
					<input id='laADR2' type='text' value='" . $laADR2 . "' onclick='detectCLICK(event,this);'>
				</div>
				<div class='divBOX'><br>" . $dw3_lbl["VILLE"] . ":
					<input id='laVILLE' type='text' value='" . $laVILLE . "' onclick='detectCLICK(event,this);'>
				</div>
				<div class='divBOX'><br>Province:
						<select name='laPROV' id='laPROV'>
							<option value='AB'"; if 	($laPROV =="AB"){ echo " selected"; } echo ">Alberta</option>
							<option value='BC'"; if 	($laPROV =="BC"){ echo " selected"; } echo ">Colombie-Britannique</option>
							<option value='PE'"; if 	($laPROV =="PE"){ echo " selected"; } echo ">Île-du-Prince-Édouard</option>
							<option value='MB'"; if 	($laPROV =="MB"){ echo " selected"; } echo ">Manitoba</option>
							<option value='NB'"; if 	($laPROV =="NB"){ echo " selected"; } echo ">Nouveau-Brunswick</option>
							<option value='NS'"; if 	($laPROV =="NS"){ echo " selected"; } echo ">Nouvelle-Écosse</option>
							<option value='NU'"; if 	($laPROV =="NU"){ echo " selected"; } echo ">Nunavut</option>
							<option value='ON'"; if 	($laPROV =="ON"){ echo " selected"; } echo ">Ontario</option>
							<option value='QC'"; if 	($laPROV =="QC"){ echo " selected"; } echo ">Québec</option>
							<option value='SK'"; if 	($laPROV =="SK"){ echo " selected"; } echo ">Saskatchewan </option>
							<option value='NF'"; if 	($laPROV =="NF"){ echo " selected"; } echo ">Terre-Neuve-et-Labrador</option>
							<option value='NT'"; if 	($laPROV =="NT"){ echo " selected"; } echo ">Territoires du Nord-Ouest</option>
							<option value='YT'"; if 	($laPROV =="YT"){ echo " selected"; } echo ">Yukon</option>
						  </select>
				</div>
				<div class='divBOX'><br>" . $dw3_lbl["PAYS"] . ":
					<input id='laPAYS' type='text' disabled value='Canada' onclick='detectCLICK(event,this);'>
				</div>
				<div class='divBOX'><br>" . $dw3_lbl["CP"] . ": 
					<input id='laCP' type='text' value='" . $laCP . "' onclick='detectCLICK(event,this);'>
				</div><br>
				<button class='blue' onclick='getLngLat();'><span class='material-icons'>where_to_vote</span> Lng/Lat selon l'adresse</button><br>			
				<div class='divBOX'><br>" . $dw3_lbl["LNG"] . ": 
					<input id='laLNG' type='text' value='" . $laLNG . "' onclick='detectCLICK(event,this);'>
				</div>				
				<div class='divBOX'><br>" . $dw3_lbl["LAT"] . ": 
					<input id='laLAT' type='text' value='" . $laLAT . "' onclick='detectCLICK(event,this);'>
				</div>
				<div class='divBOX'><br>" . $dw3_lbl["EML1"] . ": 
					<input id='laEML1' type='text' value='" . $laEML1 . "' onclick='detectCLICK(event,this);'>
				</div>				
				<div class='divBOX'><br>" . $dw3_lbl["TEL1"] . ": 
					<input id='laTEL1' type='text' value='" . $laTEL1 . "' onclick='detectCLICK(event,this);'>
				</div>
				<div class='divBOX'><br>Square ID: 
					<input id='laSQUARE' type='text' value='" . $laSQUARE . "' onclick='detectCLICK(event,this);'>
				</div>
				<div class='divBOX'><br>Administrateur:
					<select name='laUSID' id='laUSID'>";
				
				$sql2 = "SELECT * FROM user WHERE auth='ADM' OR auth='GES' ORDER BY auth DESC,last_name,first_name; ";

				$result2 = $dw3_conn->query($sql2);
				if ($result2->num_rows > 0) {	
					while($row2 = $result2->fetch_assoc()) {
						if ($laUSID == $row2["id"]){
							echo "<option value='". $row2["id"] . "' selected>"	. $row2["first_name"] . " " . $row2["last_name"] . "</option>";
						} else {
							echo "<option value='". $row2["id"] . "'>"	. $row2["first_name"] . " " . $row2["last_name"] . "</option>";
						}
					}
				}
				
				echo "</select>
				</div>
                </div>
                <div class='dw3_form_foot'>
                <button class='red' onclick='delLOC(\"" . $row["id"] . "\");'><span class='material-icons'>delete_forever</span>Supprimer</button>
				<button class='grey' onclick='closeEDITOR();document.getElementById(\"rfLOC\").scrollIntoView({behavior: \"smooth\", block: \"start\", inline: \"nearest\"});'><span class='material-icons'>cancel</span>Annuler</button> 
				<button class='green' onclick='updLOC(\"" . $row["id"] . "\");'><span class='material-icons'>save</span> Sauvegarder</button>
				</div>
				";
		}
	}
$dw3_conn->close();
?>
    