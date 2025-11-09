<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$rtID  = $_GET['rtID'];

if (trim($rtID)==""){
    $dw3_conn->close();
    die("");
}

$sql = "SELECT COUNT(*) as qtyUSR FROM road_user WHERE road_id = '" . $rtID . "'";
	$result = $dw3_conn->query($sql);
	//echo '<option disabled>Administrateurs</option>';
	if ($result->num_rows > 0) {	
		while($row = $result->fetch_assoc()) {
			$qtyUSR = $row['qtyUSR'];
		}
	}
	$sql = "SELECT COUNT(*) as qtyCLI FROM road_line WHERE road_id = '" . $rtID . "'";
	$result = $dw3_conn->query($sql);
	//echo '<option disabled>Administrateurs</option>';
	if ($result->num_rows > 0) {	
		while($row = $result->fetch_assoc()) {
			$qtyCLI = $row['qtyCLI'];
		}
	}	
	$sql = "SELECT * FROM road_head WHERE id = '" . $rtID . "'";
	$result = $dw3_conn->query($sql);
	//echo '<option disabled>Administrateurs</option>';
	if ($result->num_rows > 0) {	
		while($row = $result->fetch_assoc()) {
			$rtNOM = $row['name'];
			$rtLOC = $row['location_id'];
			$rtFREQ_JOUR = $row['freq_day'];
			$rtFREQ_HEURE = $row['freq_hour'];
			$rtMAP_HIGHWAY = $row['highway'];
			$rtMAP_FERRIE = $row['ferrie'];
		}
	
	
		echo "<table class='tblDATA'><tr onclick='showTB(0);'><th style='cursor:pointer;'><span class='material-icons' style='font-size:1em;'>settings</span> Paramètres de la route<span class='material-icons'>expand_more</span></th></tr><tbody id='TBody0' hidden></tbody></table>";		
		echo "<div id='hiddenDiv0' style='display:none;'><br><div class='divBOX'><b>Paramètres de base</b><br>Nom descriptif:<br>
			<input id='rtNOM' type='text' value='" . $rtNOM . "' onclick='detectCLICK(event,this);'>
			<br>Adresse de départ:<br>
			  <select name='rtLOC' id='rtLOC'>";
				
				$sql = 'SELECT *
						FROM location
						WHERE stat=0				
						ORDER BY name';

				$result = $dw3_conn->query($sql);
				//echo '<option disabled>Administrateurs</option>';
				if ($result->num_rows > 0) {	
					while($row = $result->fetch_assoc()) {
						echo "<option"; 
							if ($row['id'] == $rtLOC){ echo " selected";}
						echo " value='". $row['id'] . "'>"	. $row['name'] . "</option>";
					}
				}
				
			  echo "</select>
					</div>	
						
						<div class='divBOX'><hr><b>Fréquence des visites</b><br>
						En jours:<br>
							<input id='rtFREQ_JOUR' type='number' value='" . $rtFREQ_JOUR . "' onclick='detectCLICK(event,this);'>
						<br>
						et heures:<br>
							<input id='rtFREQ_HEURE' type='number' value='" . $rtFREQ_HEURE . "' onclick='detectCLICK(event,this);'>
						</div>
						
						<div class='divBOX'><hr><b>Paramètres de carte de l'utilisateur</b><br>
						Éviter les autoroutes:<br>
							<label class='switch'>
							  <input id='rtMAP_HIGHWAY' type='checkbox' ";
						if ($rtMAP_HIGHWAY == '1'){ echo " checked";}
						echo ">
							  <span class='slider round'></span>
							</label>
							<br>
							Éviter les traversiers:<br>
							<label class='switch'>
							  <input id='rtMAP_FERRIE' type='checkbox' ";
						if ($rtMAP_FERRIE == '1'){ echo " checked";}
						echo ">
							  <span class='slider round'></span>
							</label>
						</div><br>";
			echo "<button style='margin:0px 2px 0px 2px;padding:8px;background:red;'  onclick='delRTE();'><span class='material-icons'>delete_forever</span> Supprimer la route</button>
					<button onclick='updRTE();'><span class='material-icons'>save</span> Enregistrer</button></div>";
	}
echo "<hr>";

	$sql = "SELECT A.id as usID,CONCAT(A.first_name,' ',A.last_name) as usNOM,A.name as usUSER,A.eml1 as usEML1
			FROM user A
            LEFT JOIN (SELECT * FROM road_user WHERE road_id = '" . $rtID . "') B ON A.id = B.user_id  
			WHERE A.id IN(SELECT DISTINCT user_id FROM road_user 
						WHERE road_id = '" . $rtID . "')
			ORDER BY name";

	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {
		echo "<form id='frmUSR' class='submit-disabled'><table class='tblDATA'><tr onclick='showTB(1);'><th colspan='3' style='cursor:pointer;'><span class='material-icons' style='font-size:1em;'>face</span> Utilisateurs (" . $qtyUSR . ") <span class='material-icons'>expand_more</span></th></tr><tbody id='TBody1' hidden>";		
		while($row = $result->fetch_assoc()) {
			echo "
					<tr>
					<td style='width:20px;'><input id='chkUS" . $row["usID"] . "' value='" . $row["usID"] . "' type='checkbox'></td>
					<td onclick='selCHK(\"chkUS" . $row["usID"] . "\");'>" . $row["usNOM"] . "</td>
					<td onclick='selCHK(\"chkUS" . $row["usID"] . "\");'>" . $row["usEML1"] . "</td></tr>";
		}
		echo "</tbody></table></form>";
		echo "<div id='hiddenDiv1' style='text-align:left;display:none;'>
			<button style='background:#444444;' onclick='selALL(\"frmUSR\",\"checkbox\");'><span class='material-icons'>done_all</span></button>";
		echo "<button style='background:#444444;' onclick='selNONE(\"frmUSR\",\"checkbox\");'><span class='material-icons'>remove_done</span></button>";
		echo "<button style='background:red;' onclick='delUSR();'><span class='material-icons'>delete_sweep</span></button>
					<button onclick='openNewUSR();'><span class='material-icons'>add</span></button>
					</div>";

		} else {
		echo "<table class='tblDATA'><tr><th>Utilisateurs (0)</th></tr>";		
		echo " <tr onclick='openNewUSR();'><td>Pour ajouter un utilisateur appuyez sur [+]</td></tr>";
		echo "</table>";
	}
	
echo "<hr>";
//DESTINATIONS
//depart
	$sql = "SELECT *
			FROM location
			WHERE id IN (SELECT location_id FROM road_head WHERE id = '" . $rtID . "')
			LIMIT 1";

	$result = $dw3_conn->query($sql);
	//echo '<option disabled>Administrateurs</option>';
	if ($result->num_rows > 0) {	
		while($row = $result->fetch_assoc()) {
			$LOC_ROW = "<tr><td colspan=2>" . $row["name"] . "</td><td>" . $row["adr1"] . " " . $row["city"] . "</td><td>Depart</td></tr>";
		}
	}	
//autres destinations	
	$sql = "SELECT CONCAT(A.first_name,' ',A.last_name) as clNOM,A.adr1 as clADR1, A.id as clID,B.sort_number as bclORD
			FROM customer A
            LEFT JOIN (SELECT * FROM road_line WHERE road_id = " . $rtID . ") B ON A.id = B.customer_id  
			WHERE A.id IN(SELECT DISTINCT customer_id FROM road_line 
						WHERE road_id = " . $rtID . ")
			ORDER BY bclORD";

	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {
		echo "<form onsubmit='submitForm(event)' id='frmCLI' class='submit-disabled' style='width:100%;overflow:auto;margin-bottom:50px;'><table class='tblDATA'><tr><th colspan='4' style='cursor:default;'><span class='material-icons' style='font-size:1em;'>my_location</span> Destinations (" . $qtyCLI . ") </th></tr>";		
		echo $LOC_ROW;
		while($row = $result->fetch_assoc()) {
			echo "<tr><td style='width:30px;text-align:center;'><input id='chkCL" . $row["clID"] . "' value='" . $row["clID"] . "' type='checkbox'></td>
				    <td style='width:20%;max-width: 100px;' class='short' onclick='selCHK(\"chkCL" . $row["clID"] . "\");'>" . dw3_decrypt($row["clNOM"]) . "</td>
					<td style='max-width: 200px;' class='short' onclick='selCHK(\"chkCL" . $row["clID"] . "\");'>" . dw3_decrypt($row["clADR1"]) . "</td>
					<td style='width:60px;'><input  min='1' max='999' onchange='updORD(this,\"" . $rtID . "\",\"" . $row["clID"] . "\");'' type='number' value='" . $row["bclORD"] . "'></td>
				 </tr>";
		}
		echo "</table></form><div id='divFOOT' >";
		echo "<button style='background:#444444;' onclick='selALL(\"frmCLI\",\"checkbox\");'><span class='material-icons'>done_all</span></button>";
		echo "<button style='background:#444444;' onclick='selNONE(\"frmCLI\",\"checkbox\");'><span class='material-icons'>remove_done</span></button>";
		echo "<button style='background:red;' onclick='delCLI();'><span class='material-icons'>delete_sweep</span></button>
				<button onclick='openNewCLI();'><span class='material-icons'>add</span></button>
                <button onclick='calcDESTS(\"" . $rtID . "\");'><span class='material-icons'>sort</span></button>
						</div>";
		//echo "<button onclick='calcMATRIX(\"" . $rtID . "\");'><span class='material-icons'></span></button>";

	} else {
		echo "<table class='tblDATA'><tr><th>Destinations (0)</th></tr>";		
		echo " <tr onclick='openNewCLI();'><td>Pour ajouter une destination appuyez sur [+]</td></tr>";
		echo "</table>";
	}
	


$dw3_conn->close();
?>