<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SS  = str_replace("\"", "\'", str_replace("'", "\'", $_GET['SS'])); //RECHERCHE 
$frSTAT  = $_GET['frSTAT'];
$frLANG  = $_GET['frLANG'];
$frPAYS  = $_GET['frPAYS'];
$frPROV  = $_GET['frPROV'];
$frVILLE  = $_GET['frVILLE'];
$OFFSET  = $_GET['OFFSET'];
$LIMIT  = $_GET['LIMIT'];
if ($OFFSET == ""){
	$OFFSET = "0";	
}
if ($LIMIT == "" || $LIMIT == "0"){
	$LIMIT = "12";	
}

//GET TOTAL
$sql = "SELECT COUNT(*) as TOTR
				FROM supplier
				WHERE id > -1 " ;
if ($frSTAT != ""){ $sql = $sql . " AND  stat = '" . $frSTAT . "' "; }
if ($frLANG != ""){ $sql = $sql . " AND  lang = '" . $frLANG . "' "; }
if ($frPAYS != ""){ $sql = $sql . " AND  country = '" . $frPAYS . "' "; }
if ($frPROV != ""){ $sql = $sql . " AND  province = '" . $frPROV . "' "; }
if ($frVILLE != ""){ $sql = $sql . " AND  city = '" . $frVILLE . "' "; }
if ($SS != ""){ $sql = $sql . " AND  CONCAT(company_name, adr1, adr2,tel1,tel2,eml1,eml2,note) like '%" . $SS . "%' "; }

	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$numrows = $row["TOTR"] ;
		}
	}

	//PARAMETRES D'AFFICHAGE
	$sql = "SELECT *
			FROM app_prm
			WHERE app_id = '" . $APID . "'
			AND   user_id = '" . $USER . "' 
			ORDER BY value";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {
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
				case 'ADR':
					$DSP_ADR = $row["value"];
					break;
				case 'ID':
					$DSP_ID = $row["value"];
					break;
				case 'LANG':
					$DSP_LANG = $row["value"];
					break;
				case 'STAT':
					$DSP_STAT = $row["value"];
					break;
				case 'NOM':
					$DSP_NOM = $row["value"];
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
				case 'TEL1':
					$DSP_TEL1 = $row["value"];
					break;
				case 'TEL2':
					$DSP_TEL2 = $row["value"];
					break;
				case 'EML1':
					$DSP_EML1 = $row["value"];
					break;
				case 'EML2':
					$DSP_EML2 = $row["value"];
					break;
				case 'LNG':
					$DSP_LNG = $row["value"];
					break;
				case 'LAT':
					$DSP_LAT = $row["value"];
					break;
				case 'NOTE':
					$DSP_NOTE = $row["value"];
					break;
				case 'DTAD':
					$DSP_DTAD = $row["value"];
					break;
				case 'DTMD':
					$DSP_DTMD = $row["value"];
					break;
			}
		}
	} else {
					$DSP_ADR = "0";
					$DSP_ID = "0";
					$DSP_LANG = "";
					$DSP_STAT = "0";
					$DSP_NOM = "1";
					$DSP_ADR1 = "0";
					$DSP_ADR2 = "0";
					$DSP_VILLE = "1";
					$DSP_PROV = "0";
					$DSP_PAYS = "0";
					$DSP_CP = "0";
					$DSP_TEL1 = "1";
					$DSP_TEL2 = "0";
					$DSP_EML1 = "1";
					$DSP_EML2 = "0";
					$DSP_LNG = "0";
					$DSP_LAT = "0";
					$DSP_NOTE = "0";
					$DSP_DTAD = "0";
					$DSP_DTMD = "1";
	}

//ORDER BY & WAY
    if ($ORDERBY??"" == ""){ $ORDERBY = " company_name " ;}
    if ($ORDERBY == "NOM"){ $ORDERBY = " company_name " ;}
	if ($ORDERBY == "ADR"){ $ORDERBY = " CONCAT(trim(country),trim(province),trim(city),frSTREET)" ;}
	if ($ORDERBY == "DTAD"){ $ORDERBY = " date_created " ;}
	if ($ORDERBY == "DTMD"){ $ORDERBY = " date_modified " ;}
	if ($ORDERWAY??"" == ""){ $ORDERWAY = " ASC " ;}
	
	
//WHERE

			$sql = "SELECT *,  SUBSTRING(`adr1`, LOCATE(' ', `adr1`))as frSTREET
				FROM supplier
				WHERE id > -1 ";
			if ($frSTAT != ""){ $sql = $sql . " AND  stat = '" . $frSTAT . "' "; }
			if ($frLANG != ""){ $sql = $sql . " AND  lang = '" . $frLANG . "' "; }
			if ($frPAYS != ""){ $sql = $sql . " AND  country = '" . $frPAYS . "' "; }
			if ($frPROV != ""){ $sql = $sql . " AND  province = '" . $frPROV . "' "; }
			if ($frVILLE != ""){ $sql = $sql . " AND  city = '" . $frVILLE . "' "; }
			if ($SS != "")		{ $sql = $sql . " AND  CONCAT(company_name, adr1, adr2, tel1, tel2, eml1, eml2, note) like '%" . $SS . "%' "; }
			$sql = $sql . "
				ORDER BY " . $ORDERBY . " " . $ORDERWAY . "
				LIMIT " . $LIMIT . " OFFSET " . $OFFSET;
				
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {	
			echo "<div style='max-width:100%;width:100%;overflow-x:auto;'>" ;		
			echo "<form onsubmit='submitForm(event)' id='frmFRN' class='submit-disabled'>
			<table id='dataTABLE' class='tblSEL'>
			<tr style='background:white;'><th></th>";
				if ($DSP_ID == "1") { echo "<th>" . $dw3_lbl["ID"] . "</th>"; }
				if ($DSP_STAT == "1") { echo "<th>" . $dw3_lbl["STAT"] . "</th>"; }
				if ($DSP_NOM == "1") { echo "<th>" . $dw3_lbl["NOM"] . "</th>"; }
				if ($DSP_ADR == "1") { echo "<th>" . $dw3_lbl["ADR"] . "</th>"; }
				if ($DSP_LANG == "1") { echo "<th><span class='material-icons'>translate</span></th>"; }
				if ($DSP_ADR1 == "1") { echo "<th>" . $dw3_lbl["ADR1"] . "</th>"; }
				if ($DSP_ADR2 == "1") { echo "<th>" . $dw3_lbl["ADR2"] . "</th>"; }
				if ($DSP_VILLE == "1") { echo "<th>" . $dw3_lbl["VILLE"] . "</th>"; }
				if ($DSP_PROV == "1") { echo "<th>" . $dw3_lbl["PROV"] . "</th>"; }
				if ($DSP_PAYS == "1") { echo "<th>" . $dw3_lbl["PAYS"] . "</th>"; }
				if ($DSP_CP == "1") { echo "<th>" . $dw3_lbl["CP"] . "</th>"; }
				if ($DSP_TEL1 == "1") { echo "<th>" . $dw3_lbl["TEL1"] . "</th>"; }
				if ($DSP_TEL2 == "1") { echo "<th>" . $dw3_lbl["TEL2"] . "</th>"; }
				if ($DSP_EML1 == "1") { echo "<th>" . $dw3_lbl["EML1"] . "</th>"; }
				if ($DSP_EML2 == "1") { echo "<th>" . $dw3_lbl["EML2"] . "</th>"; }
				if ($DSP_LNG == "1") { echo "<th>" . $dw3_lbl["LNG"] . "</th>"; }
				if ($DSP_LAT == "1") { echo "<th>" . $dw3_lbl["LAT"] . "</th>"; }
				if ($DSP_NOTE == "1") { echo "<th>" . $dw3_lbl["NOTE"] . "</th>"; }
				if ($DSP_DTAD == "1") { echo "<th>" . $dw3_lbl["DTAD"] . "</th>"; }
				if ($DSP_DTMD == "1") { echo "<th>" . $dw3_lbl["DTMD"] . "</th>"; }
			echo "</tr>";
			while($row = $result->fetch_assoc()) {
				echo "
					 <tr><td style='width:20px;'><input id='chkFR" . $row["id"] . "' value='" . $row["id"] . "' type='checkbox'><input id='FRADR" . $row["id"] . "' value='" . $row["adr1"] . " " . $row["adr2"] . ", " . $row["city"] . " " . $row["province"] . " " . $row["country"] . "" . $row["postal_code"] . "' type='text' style='display:none;'></td>";
				if ($DSP_ID == "1") { echo "<td onclick='getFRN(\"". $row["id"] . "\");'>". $row["id"] . "</td>";}
				if ($DSP_STAT == "1") { echo "<td onclick='getFRN(\"". $row["id"] . "\");'>"; if ($row["stat"] == "0") { echo "<b style='color:green;'>" . $dw3_lbl["STAT0"] . "</b>"; } else if ($row["stat"] == "1") { echo "<b style='color:#DFC000;'>" .$dw3_lbl["STAT1"] . "</b>"; } else if ($row["stat"] == "2") { echo "<b style='color:#E38600;'>" .$dw3_lbl["STAT2"] . "</b>"; } else if ($row["stat"] == "3") { echo "<b style='color:red;'>" .$dw3_lbl["STAT3"] . "</b>"; }  echo "</td>";}
				if ($DSP_NOM == "1") { echo "<td onclick='getFRN(\"". $row["id"] . "\");'>". $row["company_name"] . "</td>";}
				if ($DSP_ADR == "1") { echo "<td onclick='getFRN(\"". $row["id"] . "\");'>". $row["adr1"] . " ". $row["adr2"] . ", ". $row["city"] . " " . $row["province"] . " " . $row["postal_code"] . " ". $row["country"] . "</td>";}
				if ($DSP_LANG == "1") { echo "<td onclick='getFRN(\"". $row["id"] . "\");'>". $row["lang"] . "</td>";}
				if ($DSP_ADR1 == "1") { echo "<td onclick='getFRN(\"". $row["id"] . "\");'>". $row["adr1"] . "</td>";}
				if ($DSP_ADR2 == "1") { echo "<td onclick='getFRN(\"". $row["id"] . "\");'>". $row["adr2"] . "</td>";}
				if ($DSP_VILLE == "1") { echo "<td onclick='getFRN(\"". $row["id"] . "\");'>". $row["city"] . "</td>";}
				if ($DSP_PROV == "1") { echo "<td onclick='getFRN(\"". $row["id"] . "\");'>". $row["province"] . "</td>";}
				if ($DSP_PAYS == "1") { echo "<td onclick='getFRN(\"". $row["id"] . "\");'>". $row["country"] . "</td>";}
				if ($DSP_CP == "1") { echo "<td onclick='getFRN(\"". $row["id"] . "\");'>". $row["postal_code"] . "</td>";}
				if ($DSP_TEL1 == "1") { echo "<td onclick='getFRN(\"". $row["id"] . "\");'>". $row["tel1"] . "</td>";}
				if ($DSP_TEL2 == "1") { echo "<td onclick='getFRN(\"". $row["id"] . "\");'>". $row["tel2"] . "</td>";}
				if ($DSP_EML1 == "1") { echo "<td onclick='getFRN(\"". $row["id"] . "\");'>". $row["eml1"] . "</td>";}
				if ($DSP_EML2 == "1") { echo "<td onclick='getFRN(\"". $row["id"] . "\");'>". $row["eml2"] . "</td>";}
				if ($DSP_LNG == "1") { echo "<td onclick='getFRN(\"". $row["id"] . "\");'>". $row["longitude"] . "</td>";}
				if ($DSP_LAT == "1") { echo "<td onclick='getFRN(\"". $row["id"] . "\");'>". $row["latitude"] . "</td>";}
				if ($DSP_NOTE == "1") { echo "<td onclick='getFRN(\"". $row["id"] . "\");'>". $row["note"] . "</td>";}
				if ($DSP_DTAD == "1") { echo "<td onclick='getFRN(\"". $row["id"] . "\");'>". $row["date_created"] . "</td>";}
				if ($DSP_DTMD == "1") { echo "<td onclick='getFRN(\"". $row["id"] . "\");'>". $row["date_modified"] . "</td>";}
				echo "</tr>";
			}
			echo "</table></form></div>";

				echo "<div id='hiddenDiv2' style='width:100%;text-align:left;display:inline-block;'>
						<button style='background:#444444;' onclick='selALL(\"frmFRN\",\"checkbox\");'><span class='material-icons'>done_all</span></button>";
				echo "<button style='background:#444444;' onclick='selNONE(\"frmFRN\",\"checkbox\");'><span class='material-icons'>remove_done</span></button> ";
                echo " <button onclick=\"ExportToPDF('dataTABLE','Suppliers');\"><span class='material-icons'>picture_as_pdf</span></button> ";
                echo " <button onclick=\"ExportToExcel('dataTABLE','xlsx','Suppliers');\"><span class='material-icons'>table_view</span></button> ";                
				if ($APREAD_ONLY == false) {echo " <button style='background:red;' onclick='deleteFRNS();'><span class='material-icons'>delete_sweep</span></button> ";}
				if ($APREAD_ONLY == false) {echo " <button onclick='updateGPS();'><span class='material-icons'>where_to_vote</span></button> ";}
			echo "</div><div id='divFOOT'>";		
			//FIRST PAGE
			if ($OFFSET > 0){
				echo "<button onclick='getFRNS(\"\",\"\",\"" . $LIMIT . "\");'><span class='material-icons'>first_page</span></button>";
			} else {
				echo "<button style='background:#666666;' disabled><span class='material-icons'>first_page</span></button>";
			}
			//PREVIOUS PAGE
			if ($OFFSET > 0){
				$page = $OFFSET-$LIMIT;
				if ($page<0){$page=0;}
				echo "<button onclick='getFRNS(\"\",\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_before</span></button>";
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
				echo "<button onclick='getFRNS(\"\",\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_next</span></button>";
			} else {
				echo "<button style='background:#666666;' disabled><span class='material-icons'>navigate_next</span></button>";
			}
			//LASTPAGE
			if (($OFFSET+$LIMIT) < ($numrows)){
				$lastpage = $numrows-$LIMIT;
				echo "<button onclick='getFRNS(\"\",\"". $lastpage ."\",\"" . $LIMIT . "\");'><span class='material-icons'>last_page</span></button>";
			} else {
				echo "<button style='background:#666666;' disabled><span class='material-icons'>last_page</span></button>";
			}
			echo "</div>";
		} else {
			echo "<hr><table id='dataTABLE' class='tblSEL'>
					<tr><th>" . $APNAME . "</th><tr>
					<tr onclick='openNEW();'><td>Aucunes donn&#233;es trouv&#233; selon la recherche... Pour ajouter un nouveau appuyez sur [+]</td></tr>
					</table>";
		}
$dw3_conn->close();
?>