<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SS  = str_replace("\"", "\'", str_replace("'", "\'", $_GET['SS'])); //RECHERCHE 
$enSTAT = $_GET['STAT'];
$enPAYS  = $_GET['PAYS'];
$enPROV  = $_GET['PROV'];
$enVILLE  = $_GET['VILLE'];
$OFFSET  = $_GET['OFFSET'];
$LIMIT  = $_GET['LIMIT'];
$ORDERBY = "";
$ORDERWAY = "";
if ($OFFSET == ""){
	$OFFSET = "0";	
}
if ($LIMIT == "" || $LIMIT == "0"){
	$LIMIT = "12";	
}

	//PARAMETRES D'AFFICHAGE
	$sql = "SELECT *
			FROM app_prm
			WHERE app_id = '" . $APID . "'
			AND   user_id = '" . $USER . "' 
			ORDER BY value";
	$result = $dw3_conn->query($sql);
    $numrows = $result->num_rows;
	if ($numrows > 0) {
		while($row = $result->fetch_assoc()) {
			switch ($row["name"]) {
				case 'ORDERBY':
					$ORDERBY = $row["value"];
					break;						
				case 'ORDERWAY':
					$ORDERWAY = $row["value"];
					break;				
				case 'LIMIT':
					if ($row["value"] != ''){ $LIMIT = $row["value"]; }
					break;
				case 'ID':
					$DSP_ID = $row["value"];
					break;
				case 'STAT':
					$DSP_STAT = $row["value"];
					break;
				case 'ORDER':
					$DSP_ORDER = $row["value"];
					break;
				case 'NOM':
					$DSP_NOM = $row["value"];
					break;
				case 'CIE':
					$DSP_CIE = $row["value"];
					break;
				case 'ADR1':
					$DSP_ADR1 = $row["value"];
					break;
				case 'ADR2':
					$DSP_ADR2 = $row["value"];
					break;
				case 'VILLE':
					$DSP_VILLE = $row["value"];
					break;
				case 'PROV':
					$DSP_PROV = $row["value"];
					break;
				case 'PAYS':
					$DSP_PAYS = $row["value"];
					break;
				case 'CP':
					$DSP_CP = $row["value"];
					break;
				case 'DTAD':
					$DSP_DTAD = $row["value"];
					break;
				case 'DTLV':
					$DSP_DTLV = $row["value"];
					break;
				case 'TRACKING':
					$DSP_TRACKING = $row["value"];
					break;
			}
		}
	} else {
					$DSP_ID = "0";
					$DSP_STAT = "1";
					$DSP_ORDER = "1";
					$DSP_NOM = "1";
					$DSP_CIE = "1";
					$DSP_ADR1 = "0";
					$DSP_ADR2 = "0";
					$DSP_VILLE = "1";
					$DSP_PROV = "0";
					$DSP_PAYS = "0";
					$DSP_CP = "0";
					$DSP_DTAD = "0";
					$DSP_DTLV = "1";
					$DSP_TRACKING = "1";
	}

//ORDER BY & WAY
	if ($ORDERBY == "NOM"){ $ORDERBY = " trim(B.name) " ;}
	if ($ORDERBY == "ADR"){ $ORDERBY = " CONCAT(trim(B.country_sh),trim(B.province_sh),trim(B.city_sh),enSTREET)" ;}
	if ($ORDERBY == "DTCR"){ $ORDERBY = " A.date_created " ;}
	if ($ORDERBY == "DTLV"){ $ORDERBY = " A.date_estimated " ;}
	if ($ORDERBY == ""){ $ORDERBY = " trim(A.date_created)" ;}
	if ($ORDERWAY == ""){ $ORDERWAY = " DESC " ;}
	
	
//TOTAL_ROWS

			$sql = "SELECT A.*,  SUBSTRING(B.adr1_sh, LOCATE(' ', B.adr1_sh)) as enSTREET, B.name as enNAME, B.company as enCOMPANY, B.adr1_sh as enADR1, B.adr2_sh as enADR2, B.city_sh as enCITY, B.province_sh as enPROVINCE, B.country_sh as enCOUNTRY, B.postal_code_sh as enPOSTAL_CODE, B.tel as enTEL
				FROM shipment_head A
                LEFT JOIN order_head B ON B.id = A.order_id 
                LEFT JOIN customer C ON C.id = B.customer_id 
				WHERE A.id > -1 ";
			if ($enSTAT != ""){ $sql = $sql . " AND  A.stat = '" . $enSTAT . "' "; }
			if ($enPAYS != ""){ $sql = $sql . " AND  B.country_sh = '" . $enPAYS . "' "; }
			if ($enPROV != ""){ $sql = $sql . " AND  B.province_sh = '" . $enPROV . "' "; }
			if ($enVILLE != ""){ $sql = $sql . " AND  B.city_sh = '" . $enVILLE . "' "; }
			if ($SS != "")		{ $sql = $sql . " AND  B.name like '%" . dw3_crypt(ucwords($SS)) . "%' "; }
                if ($SS != ""){ $sql = $sql . " OR A.id > -1 ";
                if ($enSTAT != ""){ $sql = $sql . " AND  A.stat = '" . $enSTAT . "' "; }
                if ($enPAYS != ""){ $sql = $sql . " AND  B.country_sh = '" . $enPAYS . "' "; }
                if ($enPROV != ""){ $sql = $sql . " AND  B.province_sh = '" . $enPROV . "' "; }
                if ($enVILLE != ""){ $sql = $sql . " AND  B.city_sh = '" . $enVILLE . "' ";}
                $sql = $sql . " AND UCASE(CONCAT(B.city_sh,B.province_sh,B.company)) like '%" . strtoupper($SS) . "%'";} 
                    if ($SS != ""){ $sql = $sql . " OR A.id > -1 ";
                    if ($enSTAT != ""){ $sql = $sql . " AND  A.stat = '" . $enSTAT . "' "; }
                    if ($enPAYS != ""){ $sql = $sql . " AND  B.country_sh = '" . $enPAYS . "' "; }
                    if ($enPROV != ""){ $sql = $sql . " AND  B.province_sh = '" . $enPROV . "' "; }
                    if ($enVILLE != ""){ $sql = $sql . " AND  B.city_sh = '" . $enVILLE . "' ";}
                    $sql = $sql . " AND B.tel like '%" . dw3_crypt($SS) . "%'";} 
				//die( $sql);
		$result = $dw3_conn->query($sql);
        $numrows = $result->num_rows;
//TOTAL_ROWS

			$sql = $sql . "
				ORDER BY " . $ORDERBY . " " . $ORDERWAY . "
				LIMIT " . $LIMIT . " OFFSET " . $OFFSET;
				
		$result = $dw3_conn->query($sql);
        //$numrows = $result->num_rows;
		if ($result->num_rows > 0) {	
			echo "<div style='max-width:100%;width:100%;overflow-x:auto;'>" ;		
			echo "<form onsubmit='submitForm(event)' id='frmSHIP' class='submit-disabled'>
			<table id='dataTABLE' class='tblSEL'>
			<tr style='background:white;'><th></th>";
				if ($DSP_ID == "1") { echo "<th>" . $dw3_lbl["ID"] . "</th>"; }
				if ($DSP_STAT == "1") { echo "<th>" . $dw3_lbl["STAT"] . "</th>"; }
				if ($DSP_ORDER == "1") { echo "<th>" . $dw3_lbl["ORDER"] . " #</th>"; }
				if ($DSP_NOM == "1") { echo "<th>" . $dw3_lbl["NOM"] . "</th>"; }
				if ($DSP_CIE == "1") { echo "<th>" . $dw3_lbl["TRANSPORT"] . "</th>"; }
				if ($DSP_ADR1 == "1") { echo "<th>" . $dw3_lbl["ADR1"] . "</th>"; }
				if ($DSP_ADR2 == "1") { echo "<th>" . $dw3_lbl["ADR2"] . "</th>"; }
				if ($DSP_VILLE == "1") { echo "<th>" . $dw3_lbl["VILLE"] . "</th>"; }
				if ($DSP_PROV == "1") { echo "<th>" . $dw3_lbl["PROV"] . "</th>"; }
				if ($DSP_PAYS == "1") { echo "<th>" . $dw3_lbl["PAYS"] . "</th>"; }
				if ($DSP_CP == "1") { echo "<th>" . $dw3_lbl["CP"] . "</th>"; }
				if ($DSP_TRACKING == "1") { echo "<th>" . $dw3_lbl["TRACKING"] . " #</th>"; }
				if ($DSP_DTAD == "1") { echo "<th>" . $dw3_lbl["DTAD"] . "</th>"; }
				if ($DSP_DTLV == "1") { echo "<th>" . $dw3_lbl["DTLV"] . "</th>"; }
			echo "</tr>";
			while($row = $result->fetch_assoc()) {
                if ($USER_LANG == "FR"){
                    if($row["ship_type"] == ""){$ship_name = "Non défini";}
                    if($row["ship_type"] == "INTERNAL"){$ship_name = "Transport interne";}
                    if($row["ship_type"] == "PICKUP"){$ship_name = "Ramassage";}
                    if($row["ship_type"] == "DOM.RP"){$ship_name = "Poste Canada Régulier";}
                    if($row["ship_type"] == "DOM.EP"){$ship_name = "Poste Canada Accéléré";}
                    if($row["ship_type"] == "DOM.XP"){$ship_name = "Poste Canada Express";}
                    if($row["ship_type"] == "ICS"){$ship_name = "ICS Courrier";}
                    if($row["ship_type"] == "DICOM"){$ship_name = "Dicom (GLS)";}
                    if($row["ship_type"] == "NATIONEX"){$ship_name = "Nationex";}
                    if($row["ship_type"] == "PUROLATOR"){$ship_name = "Purolator";}
                    if($row["ship_type"] == "UPS"){$ship_name = "UPS";}
                    if($row["ship_type"] == "POSTE"){$ship_name = "Poste Canada";}
                } else {
                    if($row["ship_type"] == ""){$ship_name = "Not defined";}
                    if($row["ship_type"] == "INTERNAL"){$ship_name = "Internal Transport";}
                    if($row["ship_type"] == "PICKUP"){$ship_name = "Pickup";}
                    if($row["ship_type"] == "DOM.RP"){$ship_name = "Canada Post Regular";}
                    if($row["ship_type"] == "DOM.EP"){$ship_name = "Canada Post Expedited";}
                    if($row["ship_type"] == "DOM.XP"){$ship_name = "Canada Post Express";}
                    if($row["ship_type"] == "ICS"){$ship_name = "ICS";}
                    if($row["ship_type"] == "DICOM"){$ship_name = "Dicom (GLS)";}
                    if($row["ship_type"] == "NATIONEX"){$ship_name = "Nationex";}
                    if($row["ship_type"] == "PUROLATOR"){$ship_name = "Purolator";}
                    if($row["ship_type"] == "UPS"){$ship_name = "UPS";}
                    if($row["ship_type"] == "POSTE"){$ship_name = "Poste Canada";}
                }
				echo "
					 <tr><td style='width:20px;'><input id='chkSH" . $row["id"] . "' value='" . $row["id"] . "' type='checkbox'><input id='SHADR" . $row["id"] . "' value='" . $row["enADR1"] . " " . $row["enADR2"] . ", " . $row["enCITY"] . " " . $row["enPROVINCE"] . " " . $row["enCOUNTRY"] . " " . $row["enPOSTAL_CODE"] . "' type='text' style='display:none;'></td>";
				if ($DSP_ID == "1") { echo "<td onclick='getSHIP(\"". $row["id"] . "\");'>". $row["id"] . "</td>";}
				if ($DSP_STAT == "1") { echo "<td onclick='getSHIP(\"". $row["id"] . "\");'>"; 
                    if ($row["stat"] == "0") { echo "<b style='color:black;'>En traitement</b>"; } 
                    else if ($row["stat"] == "1") { echo "<b style='color:blue;'>Prêt à expédier</b>"; } 
                    else if ($row["stat"] == "2") { echo "<b style='color:darkgrey;'>Sur la route</b>"; } 
                    else if ($row["stat"] == "3") { echo "<b style='color:orange;'>Vers la destination</b>"; } 
                    else if ($row["stat"] == "4") { echo "<b style='color:green;'>Livré</b>"; }  
                    else if ($row["stat"] == "5") { echo "<b style='color:red;'>Annulé</b>"; }  echo "</td>";}
				if ($DSP_ORDER == "1") { echo "<td onclick='getSHIP(\"". $row["id"] . "\");'>". $row["order_id"] . "</td>";}
				if ($DSP_NOM == "1") { echo "<td onclick='getSHIP(\"". $row["id"] . "\");'>". $row["enCOMPANY"] . " " . dw3_decrypt($row["enNAME"]) . "</td>";}
				if ($DSP_CIE == "1") { echo "<td onclick='getSHIP(\"". $row["id"] . "\");'>". $ship_name . "</td>";}
				if ($DSP_ADR1 == "1") { echo "<td onclick='getSHIP(\"". $row["id"] . "\");'>". dw3_decrypt($row["enADR1"]) . "</td>";}
				if ($DSP_ADR2 == "1") { echo "<td onclick='getSHIP(\"". $row["id"] . "\");'>". dw3_decrypt($row["enADR2"]) . "</td>";}
				if ($DSP_VILLE == "1") { echo "<td onclick='getSHIP(\"". $row["id"] . "\");'>". $row["enCITY"] . "</td>";}
				if ($DSP_PROV == "1") { echo "<td onclick='getSHIP(\"". $row["id"] . "\");'>". $row["enPROVINCE"] . "</td>";}
				if ($DSP_PAYS == "1") { echo "<td onclick='getSHIP(\"". $row["id"] . "\");'>". $row["enCOUNTRY"] . "</td>";}
				if ($DSP_CP == "1") { echo "<td onclick='getSHIP(\"". $row["id"] . "\");'>". $row["enPOSTAL_CODE"] . "</td>";}
				if ($DSP_TRACKING == "1") { echo "<td onclick='getSHIP(\"". $row["id"] . "\");'>". $row["tracking_number"] . "</td>";}
				if ($DSP_DTAD == "1") { echo "<td onclick='getSHIP(\"". $row["id"] . "\");'>". $row["date_created"] . "</td>";}
				if ($DSP_DTLV == "1") { echo "<td onclick='getSHIP(\"". $row["id"] . "\");'>". $row["date_estimated"] . "</td>";}
                echo "</tr>";
			}
			echo "</table></form></div>";

				echo "<div id='hiddenDiv2' style='width:100%;text-align:left;display:inline-block;'>
						<button class='grey' onclick='selALL(\"frmSHIP\",\"checkbox\");'><span class='material-icons'>done_all</span></button>";
				echo "<button class='grey' onclick='selNONE(\"frmSHIP\",\"checkbox\");'><span class='material-icons'>remove_done</span></button> ";
				if ($APREAD_ONLY == false) { echo " <button class='red' onclick='deleteSHIPS();'><span class='material-icons'>delete_sweep</span></button> ";}
				echo " <button onclick=\"ExportToPDF('dataTABLE','Shipping');\"><span class='material-icons'>picture_as_pdf</span></button> ";
				echo " <button onclick=\"ExportToExcel('dataTABLE','xlsx','Shipping');\"><span class='material-icons'>table_view</span></button> ";
			echo "</div><div id='divFOOT'>";		
			//FIRST PAGE
			if ($OFFSET > 0){
				echo "<button onclick='getSHIPS(\"\",\"\",\"" . $LIMIT . "\");'><span class='material-icons'>first_page</span></button>";
			} else {
				echo "<button style='background:#666666;' disabled><span class='material-icons'>first_page</span></button>";
			}
			//PREVIOUS PAGE
			if ($OFFSET > 0){
				$page = $OFFSET-$LIMIT;
				if ($page<0){$page=0;}
				echo "<button onclick='getSHIPS(\"\",\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_before</span></button>";
			} else {
				echo "<button style='background:#666666;' disabled><span class='material-icons'>navigate_before</span></button>";
			}
			//CURRENT PAGE
			echo "Total: <b><u>" . $numrows . "</u></b> Page: <b>" . ceil(($OFFSET/$LIMIT)+1) 
			. "</b> / <b>" . ceil($numrows/$LIMIT) 
			. "</b>";
			//NEXTPAGE
			if (($OFFSET+$LIMIT) < ($numrows)){
				$page = $OFFSET+$LIMIT;
				echo "<button onclick='getSHIPS(\"\",\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_next</span></button>";
			} else {
				echo "<button style='background:#666666;' disabled><span class='material-icons'>navigate_next</span></button>";
			}
			//LASTPAGE
			if (($OFFSET+$LIMIT) < ($numrows)){
				$lastpage = $numrows-$LIMIT;
				echo "<button onclick='getSHIPS(\"\",\"". $lastpage ."\",\"" . $LIMIT . "\");'><span class='material-icons'>last_page</span></button>";
			} else {
				echo "<button style='background:#666666;' disabled><span class='material-icons'>last_page</span></button>";
			}
			echo "</div>";
		} else {
			echo "<table id='dataTABLE' class='tblSEL'>
					<tr><th>" . $APNAME . "</th><tr>
					<tr onclick='openNEW();'><td>Aucunes donn&#233;es trouv&#233; selon la recherche... Pour ajouter un nouveau appuyez sur [+]</td></tr>
					</table>";
		}
$dw3_conn->close();
?>
