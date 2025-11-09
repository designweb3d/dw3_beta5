<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SS  = mysqli_real_escape_string($dw3_conn, $_GET['SS']); //RECHERCHE 
$enSTAT = $_GET['enSTAT'];
$enPRJ = $_GET['enPRJ'];
$enPAYS  = $_GET['enPAYS'];
$enPROV  = $_GET['enPROV'];
$enVILLE  = $_GET['enVILLE'];
$enSOURCE  = $_GET['enSOURCE'];
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
	$numrows =$result->num_rows;
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
				case 'ORDER_ID':
					$DSP_ORDER_ID = $row["value"];
					break;
				case 'PROJECT_ID':
					$DSP_PROJECT_ID = $row["value"];
					break;
				case 'SOURCE':
					$DSP_SOURCE = $row["value"];
					break;
				case 'STAT':
					$DSP_STAT = $row["value"];
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
				case 'TAX':
					$DSP_TAX = $row["value"];
					break;
				case 'TRP':
					$DSP_TRP = $row["value"];
					break;
				case 'TOT':
					$DSP_TOT = $row["value"];
					break;
			}
		}
	} else {
					$DSP_ORDER_ID = "0";
					$DSP_PROJECT_ID = "1";
					$DSP_ID = "1";
					$DSP_SOURCE = "1";
					$DSP_STAT = "1";
					$DSP_NOM = "1";
					$DSP_CIE = "1";
					$DSP_ADR1 = "0";
					$DSP_ADR2 = "0";
					$DSP_VILLE = "0";
					$DSP_PROV = "0";
					$DSP_PAYS = "0";
					$DSP_CP = "0";
					$DSP_NOTE = "0";
					$DSP_DTAD = "0";
					$DSP_DTDU = "1";
					$DSP_DTMD = "0";
                    $DSP_STOT = "1";
                    $DSP_TAX = "1";
                    $DSP_TRP = "1";
                    $DSP_TOT = "1";
	}

//ORDER BY & WAY
	if ($ORDERBY == "ID"){ $ORDERBY = " id " ;}
	if ($ORDERBY == "NOM"){ $ORDERBY = " trim(name) " ;}
	if ($ORDERBY == "PRJ"){ $ORDERBY = " project_id " ;}
	if ($ORDERBY == "CIE"){ $ORDERBY = " trim(company) " ;}
	if ($ORDERBY == "ADR"){ $ORDERBY = " CONCAT(trim(country),trim(prov),trim(city),enSTREET)" ;}
	if ($ORDERBY == "DTAD"){ $ORDERBY = " date_created " ;}
	if ($ORDERBY == "DTDU"){ $ORDERBY = " date_due " ;}
	if ($ORDERBY == "DTMD"){ $ORDERBY = " date_modified " ;}
	if ($ORDERBY == ""){ $ORDERBY = " date_modified" ;}
	if ($ORDERWAY == ""){ $ORDERWAY = " DESC " ;}
	
	
//get row count
			$sql = "SELECT *,  SUBSTRING(`adr1`, LOCATE(' ', `adr1`)) as enSTREET
				FROM invoice_head WHERE id > -1 ";
			if ($enSTAT != ""){ $sql = $sql . " AND  stat = '" . $enSTAT . "' "; }
			if ($enPRJ != ""){ $sql = $sql . " AND  project_id = '" . $enPRJ . "' "; }
			if ($enSOURCE != ""){ $sql = $sql . " AND  line_source = '" . $enSOURCE . "' "; }
			if ($enPAYS != ""){ $sql = $sql . " AND  country = '" . $enPAYS . "' "; }
			if ($enPROV != ""){ $sql = $sql . " AND  prov = '" . $enPROV . "' "; }
			if ($enVILLE != ""){ $sql = $sql . " AND  city = '" . $enrVILLE . "' "; }
			if ($SS != "")		{ $sql = $sql . " AND  name like '%" . dw3_crypt(ucwords($SS)) . "%' "; }
                if ($SS != ""){ $sql = $sql . " OR id > -1 ";
                if ($enSTAT != ""){ $sql = $sql . " AND  stat = '" . $enSTAT . "' "; }
    			if ($enPRJ != ""){ $sql = $sql . " AND  project_id = '" . $enPRJ . "' "; }
                if ($enSOURCE != ""){ $sql = $sql . " AND  line_source = '" . $enSOURCE . "' "; }
                if ($enPAYS != ""){ $sql = $sql . " AND  country = '" . $enPAYS . "' "; }
                if ($enPROV != ""){ $sql = $sql . " AND  prov = '" . $enPROV . "' "; }
                if ($enVILLE != ""){ $sql = $sql . " AND  city = '" . $enVILLE . "' ";}
                $sql = $sql . " AND UCASE(CONCAT(city,prov,company)) like '%" . strtoupper($SS) . "%'";} 
                    if ($SS != ""){ $sql = $sql . " OR id > -1 ";
                    if ($enSTAT != ""){ $sql = $sql . " AND  stat = '" . $enSTAT . "' "; }
        			if ($enPRJ != ""){ $sql = $sql . " AND  project_id = '" . $enPRJ . "' "; }
                    if ($enSOURCE != ""){ $sql = $sql . " AND  line_source = '" . $enSOURCE . "' "; }
                    if ($enPAYS != ""){ $sql = $sql . " AND  country = '" . $enPAYS . "' "; }
                    if ($enPROV != ""){ $sql = $sql . " AND  prov = '" . $enPROV . "' "; }
                    if ($enVILLE != ""){ $sql = $sql . " AND  city = '" . $enVILLE . "' ";}
                    $sql = $sql . " AND tel like '%" . dw3_crypt($SS) . "%'";} 
				
		$result = $dw3_conn->query($sql);
        $numrows = $result->num_rows;
//sql with limit
			$sql = "SELECT *,  SUBSTRING(`adr1`, LOCATE(' ', `adr1`)) as enSTREET
				FROM invoice_head WHERE id > -1 ";
			if ($enSTAT != ""){ $sql = $sql . " AND  stat = '" . $enSTAT . "' "; }
			if ($enPRJ != ""){ $sql = $sql . " AND  project_id = '" . $enPRJ . "' "; }
			if ($enSOURCE != ""){ $sql = $sql . " AND  line_source = '" . $enSOURCE . "' "; }
			if ($enPAYS != ""){ $sql = $sql . " AND  country = '" . $enPAYS . "' "; }
			if ($enPROV != ""){ $sql = $sql . " AND  prov = '" . $enPROV . "' "; }
			if ($enVILLE != ""){ $sql = $sql . " AND  city = '" . $enrVILLE . "' "; }
			if ($SS != "")		{ $sql = $sql . " AND  name like '%" . dw3_crypt(ucwords($SS)) . "%' "; }
                if ($SS != ""){ $sql = $sql . " OR id > -1 ";
                if ($enSTAT != ""){ $sql = $sql . " AND  stat = '" . $enSTAT . "' "; }
    			if ($enPRJ != ""){ $sql = $sql . " AND  project_id = '" . $enPRJ . "' "; }
                if ($enSOURCE != ""){ $sql = $sql . " AND  line_source = '" . $enSOURCE . "' "; }
                if ($enPAYS != ""){ $sql = $sql . " AND  country = '" . $enPAYS . "' "; }
                if ($enPROV != ""){ $sql = $sql . " AND  prov = '" . $enPROV . "' "; }
                if ($enVILLE != ""){ $sql = $sql . " AND  city = '" . $enVILLE . "' ";}
                $sql = $sql . " AND UCASE(CONCAT(city,prov,company)) like '%" . strtoupper($SS) . "%'";} 
                    if ($SS != ""){ $sql = $sql . " OR id > -1 ";
                    if ($enSTAT != ""){ $sql = $sql . " AND  stat = '" . $enSTAT . "' "; }
         			if ($enPRJ != ""){ $sql = $sql . " AND  project_id = '" . $enPRJ . "' "; }
                   if ($enSOURCE != ""){ $sql = $sql . " AND  line_source = '" . $enSOURCE . "' "; }
                    if ($enPAYS != ""){ $sql = $sql . " AND  country = '" . $enPAYS . "' "; }
                    if ($enPROV != ""){ $sql = $sql . " AND  prov = '" . $enPROV . "' "; }
                    if ($enVILLE != ""){ $sql = $sql . " AND  city = '" . $enVILLE . "' ";}
                    $sql = $sql . " AND tel like '%" . dw3_crypt($SS) . "%'";} 
			$sql = $sql . "
				ORDER BY " . $ORDERBY . " " . $ORDERWAY . "
				LIMIT " . $LIMIT . " OFFSET " . $OFFSET;
				
		$result = $dw3_conn->query($sql);
        //$numrows = $result->num_rows;
		if ($numrows > 0) {	
			echo "<div style='max-width:100%;width:100%;overflow-x:auto;'>" ;		
			echo "<form onsubmit='submitForm(event)' id='frmFCT' class='submit-disabled'>
			<table id='dataTABLE' class='tblSEL'>
			<tr style='background:white;'><th></th>";
				if ($DSP_ID == "1") { echo "<th>" . $dw3_lbl["ID"] . "</th>"; }
				if ($DSP_ORDER_ID == "1") { echo "<th>" . $dw3_lbl["ORDER_ID"] . "</th>"; }
				if ($DSP_PROJECT_ID == "1") { echo "<th>Projet</th>"; }
				if ($DSP_SOURCE == "1") { echo "<th>Source</th>"; }
				if ($DSP_STAT == "1") { echo "<th>" . $dw3_lbl["STAT"] . "</th>"; }
				if ($DSP_NOM == "1") { echo "<th>" . $dw3_lbl["NOM"] . "</th>"; }
				if ($DSP_CIE == "1") { echo "<th>Compagnie</th>"; }
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
   				if ($DSP_STOT == "1") { echo "<th>" . $dw3_lbl["STOT"] . "</th>"; }
   				if ($DSP_TAX == "1") { echo "<th>Tx</th>"; }
   				if ($DSP_TRP == "1") { echo "<th>Transport</th>"; }
   				if ($DSP_TOT == "1") { echo "<th>Total</th>"; }
			echo "</tr>";
            $date_now = time();
			while($row = $result->fetch_assoc()) {
				echo "<tr><td style='width:20px;'><input id='chkEN" . $row["id"] . "' value='" . $row["id"] . "' type='checkbox'><input id='ENADR" . $row["id"] . "' value='" . dw3_decrypt($row["adr1"]) . " " . $row["adr2"] . ", " . $row["city"] . " " . $row["prov"] . " " . $row["country"] . "" . $row["postal_code"] . "' type='text' style='display:none;'></td>";
				if ($DSP_ID == "1") { echo "<td onclick='getFCT(\"". $row["id"] . "\");'>". $row["id"] . "</td>";}
				if ($DSP_ORDER_ID == "1") { echo "<td onclick='getFCT(\"". $row["id"] . "\");'>". $row["order_id"] . "</td>";}
				if ($DSP_PROJECT_ID == "1") { echo "<td onclick='getFCT(\"". $row["id"] . "\");' style='text-align:center;'>". $row["project_id"] . "</td>";}
				if ($DSP_SOURCE == "1") { echo "<td onclick='getFCT(\"". $row["id"] . "\");'>"; if ($row["line_source"] == "product") { echo "<b style='color:darkblue;'>Produits</b>"; } else if ($row["line_source"] == "classified") { echo "<b style='color:goldenrod;'>Annonces</b>"; }  echo "</td>";}
				if ($DSP_STAT == "1") { echo "<td onclick='getFCT(\"". $row["id"] . "\");'>"; if ($row["stat"] == "0") { echo "<b style='color:#DFC000;'>Non-facturé</b>"; } else if ($row["stat"] == "1") { echo "<b style='color:darkblue;'>Facturé</b>"; } else if ($row["stat"] == "2") { echo "<b style='color:green;'>Payé</b>"; } else if ($row["stat"] == "3") { echo "<b style='color:#E38600;'>Annulé</b>"; }  echo "</td>";}
				if ($DSP_NOM == "1") { echo "<td onclick='getFCT(\"". $row["id"] . "\");'>". dw3_decrypt($row["name"]) . "</td>";}
				if ($DSP_CIE == "1") { echo "<td onclick='getFCT(\"". $row["id"] . "\");'>". $row["company"] . "</td>";}
				if ($DSP_ADR1 == "1") { echo "<td onclick='getFCT(\"". $row["id"] . "\");'>". dw3_decrypt($row["adr1"]) . "</td>";}
				if ($DSP_ADR2 == "1") { echo "<td onclick='getFCT(\"". $row["id"] . "\");'>". $row["adr2"] . "</td>";}
				if ($DSP_VILLE == "1") { echo "<td onclick='getFCT(\"". $row["id"] . "\");'>". $row["city"] . "</td>";}
				if ($DSP_PROV == "1") { echo "<td onclick='getFCT(\"". $row["id"] . "\");'>". $row["prov"] . "</td>";}
				if ($DSP_PAYS == "1") { echo "<td onclick='getFCT(\"". $row["id"] . "\");'>". $row["country"] . "</td>";}
				if ($DSP_CP == "1") { echo "<td onclick='getFCT(\"". $row["id"] . "\");'>". $row["postal_code"] . "</td>";}
				if ($DSP_NOTE == "1") { echo "<td onclick='getFCT(\"". $row["id"] . "\");'>". $row["note"] . "</td>";}
				if ($DSP_DTAD == "1") { echo "<td onclick='getFCT(\"". $row["id"] . "\");'>". $row["date_created"] . "</td>";}
				if ($DSP_DTDU == "1") { 
                    $date_convert = strtotime($row["date_due"]);
                    if ($date_now > $date_convert && $row["stat"] == "1") {
                        echo "<td style='color:red;' onclick='getFCT(\"". $row["id"] . "\");'>". substr($row["date_due"],0,10) . "</td>";
                    } else {
                        echo "<td onclick='getFCT(\"". $row["id"] . "\");'>". substr($row["date_due"],0,10) . "</td>";
                    }
                    
                }
				if ($DSP_DTMD == "1") { echo "<td onclick='getFCT(\"". $row["id"] . "\");'>". $row["date_modified"] . "</td>";}
				if ($DSP_STOT == "1") { echo "<td onclick='getFCT(\"". $row["id"] . "\");' style='text-align:right;'><b>". number_format($row["stotal"],2,'.',' '). "</b>$</td>";}
				if ($DSP_TAX == "1") { echo "<td onclick='getFCT(\"". $row["id"] . "\");' style='text-align:right;'><b>". number_format($row["tvp"]+$row["tvh"]+$row["tps"],2,'.',' '). "</b>$</td>";}
				if ($DSP_TRP == "1") { echo "<td onclick='getFCT(\"". $row["id"] . "\");' style='text-align:right;'><b>". number_format($row["transport"],2,'.',' '). "</b>$</td>";}
				if ($DSP_TOT == "1") { echo "<td onclick='getFCT(\"". $row["id"] . "\");' style='text-align:right;'><b>". number_format($row["total"],2,'.',' '). "</b>$</td>";}
                echo "</tr>";
			}
			echo "</table></form></div>";

				echo "<div id='hiddenDiv2' style='width:100%;text-align:left;display:inline-block;'>
						<button style='background:#444444;' onclick='selALL(\"frmFCT\",\"checkbox\");'><span class='material-icons'>done_all</span></button>";
				echo "<button style='background:#444444;' onclick='selNONE(\"frmFCT\",\"checkbox\");'><span class='material-icons'>remove_done</span></button> ";
				//canceled button or rewrite all pdfs with cancelled echo " <button style='background:red;display:none;' onclick='deleteFCTS();'><span class='material-icons'>delete_sweep</span></button> ";
				echo " <button onclick=\"ExportToPDF('dataTABLE','Invoices');\"><span class='material-icons'>picture_as_pdf</span></button> ";
				echo " <button onclick=\"ExportToExcel('dataTABLE','xlsx','Invoices');\"><span class='material-icons'>table_view</span></button> ";

			echo "</div><div id='divFOOT'>";		
			//FIRST PAGE
			if ($OFFSET > 0){
				echo "<button onclick='getFCTS(\"\",\"\",\"" . $LIMIT . "\");'><span class='material-icons'>first_page</span></button>";
			} else {
				echo "<button style='background:#666666;' disabled><span class='material-icons'>first_page</span></button>";
			}
			//PREVIOUS PAGE
			if ($OFFSET > 0){
				$page = $OFFSET-$LIMIT;
				if ($page<0){$page=0;}
				echo "<button onclick='getFCTS(\"\",\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_before</span></button>";
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
				echo "<button onclick='getFCTS(\"\",\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_next</span></button>";
			} else {
				echo "<button style='background:#666666;' disabled><span class='material-icons'>navigate_next</span></button>";
			}
			//LASTPAGE
			if (($OFFSET+$LIMIT) < ($numrows)){
				$lastpage = $numrows-$LIMIT;
				echo "<button onclick='getFCTS(\"\",\"". $lastpage ."\",\"" . $LIMIT . "\");'><span class='material-icons'>last_page</span></button>";
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
