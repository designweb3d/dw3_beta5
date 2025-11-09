<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SS  = str_replace("\"", "\'", str_replace("'", "\'", $_GET['SS'])); //RECHERCHE 
$prjSTAT = $_GET['prjSTAT'];
$prjPAYS  = $_GET['prjPAYS'];
$prjPROV  = $_GET['prjPROV'];
$prjVILLE  = $_GET['prjVILLE'];
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

//GET TOTAL
$sql = "SELECT COUNT(*) as TOTR
				FROM project
				WHERE id > -1 " ;
if ($prjSTAT != ""){ $sql = $sql . " AND  stat = '" . $prjSTAT . "' "; }
if ($prjPAYS != ""){ $sql = $sql . " AND  country = '" . $prjPAYS . "' "; }
if ($prjPROV != ""){ $sql = $sql . " AND  prov = '" . $prjPROV . "' "; }
if ($prjVILLE != ""){ $sql = $sql . " AND  city = '" . $prjVILLE . "' "; }
if ($SS != ""){ $sql = $sql . " AND  CONCAT(title,adr, note) like '%" . $SS . "%' "; }

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
				case 'ID':
					$DSP_ID = $row["value"];
					break;
				case 'STAT':
					$DSP_STAT = $row["value"];
					break;
				case 'NOM':
					$DSP_NOM = $row["value"];
					break;
				case 'ADR':
					$DSP_ADR = $row["value"];
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
				case 'NOTE':
					$DSP_NOTE = $row["value"];
					break;
				case 'DTAD':
					$DSP_DTAD = $row["value"];
					break;
				case 'DTDU':
					$DSP_DTDU = $row["value"];
					break;
				case 'DTMD':
					$DSP_DTMD = $row["value"];
					break;
			}
		}
	} else {
					$DSP_ID = "1";
					$DSP_STAT = "1";
					$DSP_NOM = "1";
					$DSP_ADR = "1";
					$DSP_VILLE = "1";
					$DSP_PROV = "1";
					$DSP_PAYS = "0";
					$DSP_CP = "0";
					$DSP_NOTE = "0";
					$DSP_DTAD = "0";
					$DSP_DTDU = "1";
					$DSP_DTMD = "0";
	}

//ORDER BY & WAY
	if ($ORDERBY == "NOM"){ $ORDERBY = " trim(title) " ;}
	if ($ORDERBY == "ADR"){ $ORDERBY = " CONCAT(trim(country),trim(province),trim(city),prjSTREET)" ;}
	if ($ORDERBY == "DTAD"){ $ORDERBY = " date_created " ;}
	if ($ORDERBY == "DTDU"){ $ORDERBY = " date_due " ;}
	if ($ORDERBY == "DTMD"){ $ORDERBY = " date_modified " ;}
	if ($ORDERBY == ""){ $ORDERBY = " trim(title)" ;}
	if ($ORDERWAY == ""){ $ORDERWAY = " ASC " ;}
	
	
//WHERE

			$sql = "SELECT *,  SUBSTRING(`adr`, LOCATE(' ', `adr`)) as prjSTREET
            FROM project A
            WHERE A.id > -1 ";
			if ($prjSTAT != ""){ $sql = $sql . " AND  status = '" . $prjSTAT . "' "; }
			if ($prjPAYS != ""){ $sql = $sql . " AND  country = '" . $prjPAYS . "' "; }
			if ($prjPROV != ""){ $sql = $sql . " AND  province = '" . $prjPROV . "' "; }
			if ($prjVILLE != ""){ $sql = $sql . " AND  city = '" . $prjrVILLE . "' "; }
			if ($SS != "")		{ $sql = $sql . " AND  CONCAT(title,adr,note) like '%" . $SS . "%' "; }
			$sql = $sql . "
				ORDER BY " . $ORDERBY . " " . $ORDERWAY . "
				LIMIT " . $LIMIT . " OFFSET " . $OFFSET;
				
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {	
			echo "<div style='max-width:100%;width:100%;overflow-x:auto;'>" ;		
			echo "<form onsubmit='submitForm(event)' id='frmPRJ' class='submit-disabled'>
			<table id='dataTABLE' class='tblSEL'>
			<tr style='background:white;'><th></th>";
				if ($DSP_ID == "1") { echo "<th>" . $dw3_lbl["ID"] . "</th>"; }
				if ($DSP_STAT == "1") { echo "<th>" . $dw3_lbl["STAT"] . "</th>"; }
				if ($DSP_NOM == "1") { echo "<th>" . $dw3_lbl["NOM"] . "</th>"; }
				if ($DSP_ADR == "1") { echo "<th>" . $dw3_lbl["ADR"] . "</th>"; }
				if ($DSP_VILLE == "1") { echo "<th>" . $dw3_lbl["VILLE"] . "</th>"; }
				if ($DSP_PROV == "1") { echo "<th>" . $dw3_lbl["PROV"] . "</th>"; }
				if ($DSP_PAYS == "1") { echo "<th>" . $dw3_lbl["PAYS"] . "</th>"; }
				if ($DSP_CP == "1") { echo "<th>" . $dw3_lbl["CP"] . "</th>"; }
				if ($DSP_NOTE == "1") { echo "<th>" . $dw3_lbl["NOTE"] . "</th>"; }
				if ($DSP_DTAD == "1") { echo "<th>" . $dw3_lbl["DTAD"] . "</th>"; }
				if ($DSP_DTDU == "1") { echo "<th>" . $dw3_lbl["DTDU"] . "</th>"; }
				if ($DSP_DTMD == "1") { echo "<th>" . $dw3_lbl["DTMD"] . "</th>"; }
			echo "</tr>";
			while($row = $result->fetch_assoc()) {
				echo "
					 <tr><td style='width:20px;'><input id='chkPRJ" . $row["id"] . "' value='" . $row["id"] . "' type='checkbox'><input id='PRJADR" . $row["id"] . "' value='" . $row["adr"] . ", " . $row["city"] . " " . $row["province"] . " " . $row["country"] . "" . $row["postal_code"] . "' type='text' style='display:none;'></td>";
				if ($DSP_ID == "1") { echo "<td onclick='getPRJ(\"". $row["id"] . "\");'>". $row["id"] . "</td>";}
				if ($DSP_STAT == "1") { echo "<td onclick='getPRJ(\"". $row["id"] . "\");'>"; if ($row["status"] == "0") { echo "<b style='color:goldenrod;'>À Venir</b>"; } else if ($row["status"] == "1") { echo "<b style='color:blue;'>En cours</b>"; } else if ($row["status"] == "2") { echo "<b style='color:green;'>Terminé</b>"; } else if ($row["status"] == "3") { echo "<b style='color:red;'>Annulé</b>"; }  echo "</td>";}
				if ($DSP_NOM == "1") { echo "<td onclick='getPRJ(\"". $row["id"] . "\");'>". $row["title"] . "</td>";}
				if ($DSP_ADR == "1") { echo "<td onclick='getPRJ(\"". $row["id"] . "\");'>". $row["adr"] . "</td>";}
				if ($DSP_VILLE == "1") { echo "<td onclick='getPRJ(\"". $row["id"] . "\");'>". $row["city"] . "</td>";}
				if ($DSP_PROV == "1") { echo "<td onclick='getPRJ(\"". $row["id"] . "\");'>". $row["province"] . "</td>";}
				if ($DSP_PAYS == "1") { echo "<td onclick='getPRJ(\"". $row["id"] . "\");'>". $row["country"] . "</td>";}
				if ($DSP_CP == "1") { echo "<td onclick='getPRJ(\"". $row["id"] . "\");'>". $row["postal_code"] . "</td>";}
				if ($DSP_NOTE == "1") { echo "<td onclick='getPRJ(\"". $row["id"] . "\");'>". $row["note"] . "</td>";}
				if ($DSP_DTAD == "1") { echo "<td onclick='getPRJ(\"". $row["id"] . "\");'>". $row["date_created"] . "</td>";}
				if ($DSP_DTDU == "1") { echo "<td onclick='getPRJ(\"". $row["id"] . "\");'>". $row["date_due"] . "</td>";}
				if ($DSP_DTMD == "1") { echo "<td onclick='getPRJ(\"". $row["id"] . "\");'>". $row["date_modified"] . "</td>";}
				echo "</tr>";
			}
			echo "</table></form></div>";

				echo "<div id='hiddenDiv2' style='width:100%;text-align:left;display:inline-block;'>
						<button class='grey' onclick='selALL(\"frmPRJ\",\"checkbox\");'><span class='material-icons'>done_all</span></button>";
				echo "<button class='grey' onclick='selNONE(\"frmPRJ\",\"checkbox\");'><span class='material-icons'>remove_done</span></button> ";
                echo " <button onclick=\"ExportToPDF('dataTABLE','Projects');\"><span class='material-icons'>picture_as_pdf</span></button> ";
				echo " <button onclick=\"ExportToExcel('dataTABLE','xlsx','Projects');\"><span class='material-icons'>table_view</span></button> ";
				if ($APREAD_ONLY == false) {echo " <button class='red' onclick='deletePRJS();'><span class='material-icons'>delete_sweep</span></button> ";}
			echo "</div><div id='divFOOT'>";		
			//FIRST PAGE
			if ($OFFSET > 0){
				echo "<button onclick='getPRJS(\"\",\"\",\"" . $LIMIT . "\");'><span class='material-icons'>first_page</span></button>";
			} else {
				echo "<button style='background:#666666;' disabled><span class='material-icons'>first_page</span></button>";
			}
			//PREVIOUS PAGE
			if ($OFFSET > 0){
				$page = $OFFSET-$LIMIT;
				if ($page<0){$page=0;}
				echo "<button onclick='getPRJS(\"\",\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_before</span></button>";
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
				echo "<button onclick='getPRJS(\"\",\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_next</span></button>";
			} else {
				echo "<button style='background:#666666;' disabled><span class='material-icons'>navigate_next</span></button>";
			}
			//LASTPAGE
			if (($OFFSET+$LIMIT) < ($numrows)){
				$lastpage = $numrows-$LIMIT;
				echo "<button onclick='getPRJS(\"\",\"". $lastpage ."\",\"" . $LIMIT . "\");'><span class='material-icons'>last_page</span></button>";
			} else {
				echo "<button style='background:#666666;' disabled><span class='material-icons'>last_page</span></button>";
			}
			echo "</div>";
		} else {
			echo "<hr><table id='dataTABLE' class='tblDATA'>
					<tr><th>" . $APNAME . "</th><tr>
					<tr onclick='openNEW();'><td>Aucunes donn&#233;es trouv&#233; selon la recherche... Pour ajouter un nouveau appuyez sur [+]</td></tr>
					</table>";
		}
$dw3_conn->close();
?>
