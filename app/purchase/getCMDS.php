<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SS  = str_replace("\"", "\'", str_replace("'", "\'", $_GET['SS'])); //RECHERCHE 
$enSTAT = $_GET['enSTAT'];
$enPAYS  = $_GET['enPAYS'];
$enPROV  = $_GET['enPROV'];
$enVILLE  = $_GET['enVILLE'];
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
				FROM purchase_head
				WHERE id > -1 " ;
if ($enSTAT != ""){ $sql = $sql . " AND  stat = '" . $enSTAT . "' "; }
if ($enPAYS != ""){ $sql = $sql . " AND  country = '" . $enPAYS . "' "; }
if ($enPROV != ""){ $sql = $sql . " AND  prov = '" . $enPROV . "' "; }
if ($enVILLE != ""){ $sql = $sql . " AND  city = '" . $enVILLE . "' "; }
if ($SS != ""){ $sql = $sql . " AND  CONCAT(name,adr1, adr2, note) like '%" . $SS . "%' "; }

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
				case 'PID':
					$DSP_PID = $row["value"];
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
				case 'STOT':
					$DSP_STOT = $row["value"];
					break;
			}
		}
	} else {
					$DSP_ID = "0";
					$DSP_PID = "0";
					$DSP_STAT = "0";
					$DSP_NOM = "1";
					$DSP_ADR1 = "0";
					$DSP_ADR2 = "0";
					$DSP_VILLE = "1";
					$DSP_PROV = "0";
					$DSP_PAYS = "0";
					$DSP_CP = "0";
					$DSP_NOTE = "1";
					$DSP_DTAD = "0";
					$DSP_DTDU = "1";
					$DSP_DTMD = "0";
					$DSP_STOT = "1";
	}

//ORDER BY & WAY
	if ($ORDERBY == "NOM"){ $ORDERBY = " trim(name) " ;}
	if ($ORDERBY == "ADR"){ $ORDERBY = " CONCAT(trim(country),trim(prov),trim(city),enSTREET)" ;}
	if ($ORDERBY == "DTCR"){ $ORDERBY = " date_created " ;}
	if ($ORDERBY == "DTDU"){ $ORDERBY = " date_due " ;}
	if ($ORDERBY == "DTMD"){ $ORDERBY = " date_modified " ;}
	if ($ORDERBY == ""){ $ORDERBY = " trim(name)" ;}
	if ($ORDERWAY == ""){ $ORDERWAY = " ASC " ;}
	
	
//WHERE

			$sql = "SELECT *,  SUBSTRING(`adr1`, LOCATE(' ', `adr1`)) as enSTREET, IFNULL(B.stotal,0) AS enNET
            FROM purchase_head A
            LEFT JOIN (SELECT head_id, SUM(qty_order*price) AS stotal FROM purchase_line GROUP BY head_id) B ON B.head_id = A.id
            WHERE A.id > -1 ";
			if ($enSTAT != ""){ $sql = $sql . " AND  stat = '" . $enSTAT . "' "; }
			if ($enPAYS != ""){ $sql = $sql . " AND  country = '" . $enPAYS . "' "; }
			if ($enPROV != ""){ $sql = $sql . " AND  prov = '" . $enPROV . "' "; }
			if ($enVILLE != ""){ $sql = $sql . " AND  city = '" . $enrVILLE . "' "; }
			if ($SS != "")		{ $sql = $sql . " AND  CONCAT(name,adr1, adr2,note) like '%" . $SS . "%' "; }
			$sql = $sql . "
				ORDER BY " . $ORDERBY . " " . $ORDERWAY . "
				LIMIT " . $LIMIT . " OFFSET " . $OFFSET;
				
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {	
			echo "<div style='max-width:100%;width:100%;overflow-x:auto;'>" ;		
			echo "<form onsubmit='submitForm(event)' id='frmCMD' class='submit-disabled'>
			<table id='dataTABLE' class='tblSEL'>
			<tr style='background:white;'><th></th>";
				if ($DSP_ID == "1") { echo "<th>" . $dw3_lbl["ID"] . "</th>"; }
				if ($DSP_PID == "1") { echo "<th>Supplier " . $dw3_lbl["ID"] . "</th>"; }
				if ($DSP_STAT == "1") { echo "<th>" . $dw3_lbl["STAT"] . "</th>"; }
				if ($DSP_NOM == "1") { echo "<th>" . $dw3_lbl["NOM"] . "</th>"; }
				if ($DSP_ADR1 == "1") { echo "<th>" . $dw3_lbl["ADR1"] . "</th>"; }
				if ($DSP_ADR2 == "1") { echo "<th>" . $dw3_lbl["ADR2"] . "</th>"; }
				if ($DSP_VILLE == "1") { echo "<th>" . $dw3_lbl["VILLE"] . "</th>"; }
				if ($DSP_PROV == "1") { echo "<th>" . $dw3_lbl["PROV"] . "</th>"; }
				if ($DSP_PAYS == "1") { echo "<th>" . $dw3_lbl["PAYS"] . "</th>"; }
				if ($DSP_CP == "1") { echo "<th>" . $dw3_lbl["CP"] . "</th>"; }
				if ($DSP_NOTE == "1") { echo "<th>" . $dw3_lbl["NOTE"] . "</th>"; }
				if ($DSP_DTAD == "1") { echo "<th>" . $dw3_lbl["DTAD"] . "</th>"; }
				if ($DSP_DTDU == "1") { echo "<th>" . $dw3_lbl["DTDU"] . "</th>"; }
				if ($DSP_DTMD == "1") { echo "<th>" . $dw3_lbl["DTMD"] . "</th>"; }
				if ($DSP_STOT == "1") { echo "<th style='text-align:right;'>" . $dw3_lbl["STOT"] . "</th>"; }
			echo "</tr>";
			while($row = $result->fetch_assoc()) {
				echo "
					 <tr><td style='width:20px;'><input id='chkEN" . $row["id"] . "' value='" . $row["id"] . "' type='checkbox'><input id='ENADR" . $row["id"] . "' value='" . $row["adr1"] . " " . $row["adr2"] . ", " . $row["city"] . " " . $row["prov"] . " " . $row["country"] . "" . $row["postal_code"] . "' type='text' style='display:none;'></td>";
				if ($DSP_ID == "1") { echo "<td onclick='getCMD(\"". $row["id"] . "\");'>". $row["id"] . "</td>";}
				if ($DSP_PID == "1") { echo "<td onclick='getCMD(\"". $row["id"] . "\");'>". $row["supplier_pid"] . "</td>";}
				if ($DSP_STAT == "1") { echo "<td onclick='getCMD(\"". $row["id"] . "\");'>"; if ($row["stat"] == "0") { echo "<b style='color:#DFC000;'>Non-payé</b>"; } else if ($row["stat"] == "1") { echo "<b style='color:green;'>Payé</b>"; } else if ($row["stat"] == "2") { echo "<b style='color:red;'>Annulé</b>"; } else if ($row["stat"] == "3") { echo "<b style='color:red;'>A defenir</b>"; }  echo "</td>";}
				if ($DSP_NOM == "1") { echo "<td onclick='getCMD(\"". $row["id"] . "\");'>". $row["name"] . "</td>";}
				if ($DSP_ADR1 == "1") { echo "<td onclick='getCMD(\"". $row["id"] . "\");'>". $row["adr1"] . "</td>";}
				if ($DSP_ADR2 == "1") { echo "<td onclick='getCMD(\"". $row["id"] . "\");'>". $row["adr2"] . "</td>";}
				if ($DSP_VILLE == "1") { echo "<td onclick='getCMD(\"". $row["id"] . "\");'>". $row["city"] . "</td>";}
				if ($DSP_PROV == "1") { echo "<td onclick='getCMD(\"". $row["id"] . "\");'>". $row["prov"] . "</td>";}
				if ($DSP_PAYS == "1") { echo "<td onclick='getCMD(\"". $row["id"] . "\");'>". $row["country"] . "</td>";}
				if ($DSP_CP == "1") { echo "<td onclick='getCMD(\"". $row["id"] . "\");'>". $row["postal_code"] . "</td>";}
				if ($DSP_NOTE == "1") { echo "<td onclick='getCMD(\"". $row["id"] . "\");'>". $row["note"] . "</td>";}
				if ($DSP_DTAD == "1") { echo "<td onclick='getCMD(\"". $row["id"] . "\");'>". $row["date_created"] . "</td>";}
				if ($DSP_DTDU == "1") { echo "<td onclick='getCMD(\"". $row["id"] . "\");'>". $row["date_due"] . "</td>";}
				if ($DSP_DTMD == "1") { echo "<td onclick='getCMD(\"". $row["id"] . "\");'>". $row["date_modified"] . "</td>";}
				if ($DSP_STOT == "1") { echo "<td onclick='getCMD(\"". $row["id"] . "\");' style='text-align:right;'>". number_format($row["enNET"],2,'.',' ') . "$</td>";}
				echo "</tr>";
			}
			echo "</table></form></div>";

				echo "<div id='hiddenDiv2' style='width:100%;text-align:left;display:inline-block;'>
						<button style='background:#444444;' onclick='selALL(\"frmCMD\",\"checkbox\");'><span class='material-icons'>done_all</span></button>";
				echo "<button style='background:#444444;' onclick='selNONE(\"frmCMD\",\"checkbox\");'><span class='material-icons'>remove_done</span></button> ";
				echo " <button onclick=\"ExportToPDF('dataTABLE','Purchases');\"><span class='material-icons'>picture_as_pdf</span></button> ";
				echo " <button onclick=\"ExportToExcel('dataTABLE','xlsx','Purchases');\"><span class='material-icons'>table_view</span></button> ";
				echo " <button style='background:red;' onclick='deleteCMDS();'><span class='material-icons'>delete_sweep</span></button> ";
			echo "</div><div id='divFOOT'>";		
			//FIRST PAGE
			if ($OFFSET > 0){
				echo "<button onclick='getCMDS(\"\",\"\",\"" . $LIMIT . "\");'><span class='material-icons'>first_page</span></button>";
			} else {
				echo "<button style='background:#666666;' disabled><span class='material-icons'>first_page</span></button>";
			}
			//PREVIOUS PAGE
			if ($OFFSET > 0){
				$page = $OFFSET-$LIMIT;
				if ($page<0){$page=0;}
				echo "<button onclick='getCMDS(\"\",\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_before</span></button>";
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
				echo "<button onclick='getCMDS(\"\",\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_next</span></button>";
			} else {
				echo "<button style='background:#666666;' disabled><span class='material-icons'>navigate_next</span></button>";
			}
			//LASTPAGE
			if (($OFFSET+$LIMIT) < ($numrows)){
				$lastpage = $numrows-$LIMIT;
				echo "<button onclick='getCMDS(\"\",\"". $lastpage ."\",\"" . $LIMIT . "\");'><span class='material-icons'>last_page</span></button>";
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
