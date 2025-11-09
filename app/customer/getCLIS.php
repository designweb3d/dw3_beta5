<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SS  = str_replace("\"", "\'", str_replace("'", "\'", $_GET['SS'])); //RECHERCHE 
$clSTAT  = $_GET['clSTAT'];
$clTYPE  = $_GET['clTYPE'];
$clLANG  = $_GET['clLANG'];
$clPAYS  = $_GET['clPAYS'];
$clPROV  = $_GET['clPROV'];
$clVILLE  = $_GET['clVILLE'];
$OFFSET  = $_GET['OFFSET'];
$LIMIT  = $_GET['LIMIT'];
$ORDERBY  = $_GET['ORDERBY'];

if ($OFFSET == ""){
	$OFFSET = "0";	
}
if ($LIMIT == "" || $LIMIT == "0"){
	$LIMIT = "12";	
}

if ($ORDERBY != ""){
    //aller chercher le orderway
	$sql = "SELECT * FROM app_prm WHERE app_id = '" . $APID . "' AND   user_id = '" . $USER . "'" . " AND name = 'ORDERWAY' ";
	$result = mysqli_query($dw3_conn, $sql);
	$data = mysqli_fetch_assoc($result);
	$ORDERWAY = $data['value'];
    if ($ORDERWAY == "" || $ORDERWAY == "DESC"){
        $ORDERWAY = "ASC";
    } else {
        $ORDERWAY = "DESC";
    }
    	$sql = "INSERT INTO app_prm
    (app_id, user_id,name,value)
    VALUES 
        ('" . $APID . "', '" . $USER . "','ORDERBY', '" . $ORDERBY  . "'),
        ('" . $APID . "', '" . $USER . "','ORDERWAY', '" . $ORDERWAY  . "')
        ON DUPLICATE KEY UPDATE value = VALUES(value);";
	$dw3_conn->query($sql);
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
                    if ($ORDERBY == ""){$ORDERBY = $row["value"];}
					break;						
				case 'ORDERWAY':
					$ORDERWAY = $row["value"];
					break;				
				case 'LIMIT':
					if ($row["value"] != ''){ $LIMIT = $row["value"]; }
					break;
				case 'FULLNAME':
					$DSP_FULLNAME = $row["value"];
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
				case 'TYPE':
					$DSP_TYPE = $row["value"];
					break;
				case 'PRENOM':
					$DSP_PRENOM = $row["value"];
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
				case 'BALANCE':
					$DSP_BALANCE = $row["value"];
					break;
				case 'FACTURED':
					$DSP_FACTURED = $row["value"];
					break;
			}
		}
	} else {
        $DSP_FULLNAME = "1";
        $DSP_ADR = "1";
        $DSP_ID = "0";
        $DSP_LANG = "1";
        $DSP_STAT = "1";
        $DSP_TYPE = "1";
        $DSP_PRENOM = "0";
        $DSP_NOM = "0";
        $DSP_CIE = "1";
        $DSP_ADR1 = "0";
        $DSP_ADR2 = "0";
        $DSP_VILLE = "0";
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
        $DSP_BALANCE = "1";
        $DSP_FACTURED = "1";
        $ORDERBY = "";
        $ORDERWAY = "";

	}
//ORDER BY & WAY
	if ($ORDERBY == ""){ $ORDERBY = "CONCAT(trim(last_name), trim(first_name))" ;}
    if ($ORDERBY == "ID"){ $ORDERBY = " id " ;}
    if ($ORDERBY == "STAT"){ $ORDERBY = " stat " ;}
    if ($ORDERBY == "TYPE"){ $ORDERBY = " type " ;}
    if ($ORDERBY == "FULLNAME"){ $ORDERBY = " CONCAT(trim(last_name), trim(first_name)) " ;}
    if ($ORDERBY == "NOM"){ $ORDERBY = " trim(last_name) " ;}
    if ($ORDERBY == "PRENOM"){ $ORDERBY = " trim(first_name) " ;}
    if ($ORDERBY == "CIE"){ $ORDERBY = " company " ;}
    if ($ORDERBY == "LANG"){ $ORDERBY = " lang " ;}
	if ($ORDERBY == "ADR"){ $ORDERBY = " CONCAT(trim(country),trim(province),trim(city),clSTREET)" ;}
	if ($ORDERBY == "ADR1"){ $ORDERBY = " adr1 " ;}
	if ($ORDERBY == "ADR2"){ $ORDERBY = " adr2 " ;}
	if ($ORDERBY == "VILLE"){ $ORDERBY = " city " ;}
	if ($ORDERBY == "PROV"){ $ORDERBY = " province " ;}
	if ($ORDERBY == "PAYS"){ $ORDERBY = " country " ;}
	if ($ORDERBY == "CP"){ $ORDERBY = " postal_code " ;}
	if ($ORDERBY == "TEL1"){ $ORDERBY = " tel1 " ;}
	if ($ORDERBY == "TEL2"){ $ORDERBY = " tel2 " ;}
	if ($ORDERBY == "EML1"){ $ORDERBY = " eml1 " ;}
	if ($ORDERBY == "EML2"){ $ORDERBY = " eml2 " ;}
	if ($ORDERBY == "LNG"){ $ORDERBY = " lng " ;}
	if ($ORDERBY == "LAT"){ $ORDERBY = " lat " ;}
	if ($ORDERBY == "NOTE"){ $ORDERBY = " note " ;}
	if ($ORDERBY == "DTCR"){ $ORDERBY = " date_created " ;}
	if ($ORDERBY == "DTMD"){ $ORDERBY = " date_modified " ;}
	if ($ORDERBY == "BALANCE"){ $ORDERBY = " balance " ;}
	if ($ORDERBY == "FACTURED"){ $ORDERBY = " factured " ;}
	if ($ORDERWAY == ""){ $ORDERWAY = " ASC " ;}
    	
	
//ROW COUNT
		$sqlx = "SELECT COUNT(*) as rowCount FROM customer  WHERE id > -1 ";
		$sqly = "SELECT A.*, IFNULL(B.factured,0) AS factured, SUBSTRING(`adr1`, LOCATE(' ', `adr1`)) as clSTREET FROM customer A LEFT JOIN (SELECT customer_id, SUM(total) as factured FROM invoice_head WHERE stat=1 GROUP BY customer_id) B ON A.id = B.customer_id WHERE id > -1 ";
		$sql = "";
		if ($clSTAT != ""){ $sql = $sql . " AND  stat = '" . $clSTAT . "' "; }
		if ($clTYPE != ""){ $sql = $sql . " AND  type = '" . $clTYPE . "' "; }
		if ($clLANG != ""){ $sql = $sql . " AND  lang = '" . $clLANG . "' "; }
		if ($clPAYS != ""){ $sql = $sql . " AND  country = '" . $clPAYS . "' "; }
		if ($clPROV != ""){ $sql = $sql . " AND  province = '" . $clPROV . "' "; }
		if ($clVILLE != ""){ $sql = $sql . " AND  city = '" . $clVILLE . "' "; }
		if ($SS != ""){ $sql = $sql . " AND  CONCAT(company,last_name,first_name) like '%" . dw3_crypt(ucwords($SS)) . "%'";}
		if ($SS != ""){ $sql = $sql . " OR id > -1 ";
		if ($clSTAT != ""){ $sql = $sql . " AND  stat = '" . $clSTAT . "' "; }
        if ($clTYPE != ""){ $sql = $sql . " AND  type = '" . $clTYPE . "' "; }
		if ($clLANG != ""){ $sql = $sql . " AND  lang = '" . $clLANG . "' "; }
		if ($clPAYS != ""){ $sql = $sql . " AND  country = '" . $clPAYS . "' "; }
		if ($clPROV != ""){ $sql = $sql . " AND  province = '" . $clPROV . "' "; }
		if ($clVILLE != ""){ $sql = $sql . " AND  city = '" . $clVILLE . "' ";}
		$sql = $sql . " AND eml1 like '%" . dw3_crypt($SS) . "%'";} 
		if ($SS != ""){ $sql = $sql . " OR id > -1 ";
		if ($clSTAT != ""){ $sql = $sql . " AND  stat = '" . $clSTAT . "' "; }
        if ($clTYPE != ""){ $sql = $sql . " AND  type = '" . $clTYPE . "' "; }
		if ($clLANG != ""){ $sql = $sql . " AND  lang = '" . $clLANG . "' "; }
		if ($clPAYS != ""){ $sql = $sql . " AND  country = '" . $clPAYS . "' "; }
		if ($clPROV != ""){ $sql = $sql . " AND  province = '" . $clPROV . "' "; }
		if ($clVILLE != ""){ $sql = $sql . " AND  city = '" . $clVILLE . "' ";}
		$sql = $sql . " AND tel1 like '%" . dw3_crypt($SS) . "%'";} 
		//if ($SS != "")		{ $sql = $sql . " AND  CONCAT(company, last_name, first_name, adr1, adr2,tel1,tel1,eml1,eml2) like '%" . $SS . "%' "; }
		//die($sqlx.$sql);
		$result = mysqli_query($dw3_conn, $sqlx.$sql);
        if ($result->num_rows > 0) {
		    $data = mysqli_fetch_assoc($result);
		    $numrows = $data['rowCount'];
        }else {
            $numrows = 0;
        }
//NOW WITH LIMIT	
		$sql = $sql . " ORDER BY " . $ORDERBY . " " . $ORDERWAY . " LIMIT " . $LIMIT . " OFFSET " . $OFFSET;		
		$result = $dw3_conn->query($sqly.$sql);
		if ($numrows  > 0) {	
			echo "<div style='max-width:100%;width:100%;overflow-x:auto;'>" ;		
			echo "<form onsubmit='submitForm(event)' id='frmCLI' class='submit-disabled'>
			<table id='dataTABLE' class='tblSEL'>
			<tr style='background:white;'><th style='text-align:center;overflow:hidden;'><span class='material-icons' style='vertical-align:middle;font-size:18px;margin-left:-4px;'>check_box</span></th>";
				if ($DSP_ID == "1") { echo "<th onclick=\"getCLIS('','',LIMIT,'ID');\">" . $dw3_lbl["ID"] . "</th>"; }
				if ($DSP_STAT == "1") { echo "<th onclick=\"getCLIS('','',LIMIT,'STAT');\">" . $dw3_lbl["STAT"] . "</th>"; }
				if ($DSP_TYPE == "1") { echo "<th onclick=\"getCLIS('','',LIMIT,'TYPE');\">Type</th>"; }
				if ($DSP_FULLNAME == "1") { echo "<th onclick=\"getCLIS('','',LIMIT,'FULLNAME');\">" . $dw3_lbl["FULLNAME"] . "</th>"; }
				if ($DSP_CIE == "1") { echo "<th onclick=\"getCLIS('','',LIMIT,'CIE');\">Compagnie</th>"; }
				if ($DSP_ADR == "1") { echo "<th onclick=\"getCLIS('','',LIMIT,'ADR');\">" . $dw3_lbl["ADR"] . "</th>"; }
				if ($DSP_LANG == "1") { echo "<th onclick=\"getCLIS('','',LIMIT,'LANG');\"><span class='material-icons'>translate</span></th>"; }
				if ($DSP_PRENOM == "1") { echo "<th onclick=\"getCLIS('','',LIMIT,'PRENOM');\">" . $dw3_lbl["PRENOM"] . "</th>"; }
				if ($DSP_NOM == "1") { echo "<th onclick=\"getCLIS('','',LIMIT,'NOM');\">" . $dw3_lbl["NOM"] . "</th>"; }
				if ($DSP_ADR1 == "1") { echo "<th onclick=\"getCLIS('','',LIMIT,'ADR1');\">" . $dw3_lbl["ADR1"] . "</th>"; }
				if ($DSP_ADR2 == "1") { echo "<th onclick=\"getCLIS('','',LIMIT,'ADR2');\">" . $dw3_lbl["ADR2"] . "</th>"; }
				if ($DSP_VILLE == "1") { echo "<th onclick=\"getCLIS('','',LIMIT,'VILLE');\">" . $dw3_lbl["VILLE"] . "</th>"; }
				if ($DSP_PROV == "1") { echo "<th onclick=\"getCLIS('','',LIMIT,'PROV');\">" . $dw3_lbl["PROV"] . "</th>"; }
				if ($DSP_PAYS == "1") { echo "<th onclick=\"getCLIS('','',LIMIT,'PAYS');\">" . $dw3_lbl["PAYS"] . "</th>"; }
				if ($DSP_CP == "1") { echo "<th onclick=\"getCLIS('','',LIMIT,'CP');\">" . $dw3_lbl["CP"] . "</th>"; }
				if ($DSP_TEL1 == "1") { echo "<th onclick=\"getCLIS('','',LIMIT,'TEL1');\">" . $dw3_lbl["TEL1"] . "</th>"; }
				if ($DSP_TEL2 == "1") { echo "<th onclick=\"getCLIS('','',LIMIT,'TEL2');\">" . $dw3_lbl["TEL2"] . "</th>"; }
				if ($DSP_EML1 == "1") { echo "<th onclick=\"getCLIS('','',LIMIT,'EML1');\">" . $dw3_lbl["EML1"] . "</th>"; }
				if ($DSP_EML2 == "1") { echo "<th onclick=\"getCLIS('','',LIMIT,'EML2');\">" . $dw3_lbl["EML2"] . "</th>"; }
				if ($DSP_LNG == "1") { echo "<th onclick=\"getCLIS('','',LIMIT,'LNG');\">" . $dw3_lbl["LNG"] . "</th>"; }
				if ($DSP_LAT == "1") { echo "<th onclick=\"getCLIS('','',LIMIT,'LAT');\">" . $dw3_lbl["LAT"] . "</th>"; }
				if ($DSP_NOTE == "1") { echo "<th onclick=\"getCLIS('','',LIMIT,'NOTE');\">" . $dw3_lbl["NOTE"] . "</th>"; }
				if ($DSP_DTAD == "1") { echo "<th onclick=\"getCLIS('','',LIMIT,'DTAD');\">" . $dw3_lbl["DTAD"] . "</th>"; }
				if ($DSP_DTMD == "1") { echo "<th onclick=\"getCLIS('','',LIMIT,'DTMD');\">" . $dw3_lbl["DTMD"] . "</th>"; }
				if ($DSP_BALANCE == "1") { echo "<th onclick=\"getCLIS('','',LIMIT,'BALANCE');\">Compte</th>"; }
				if ($DSP_FACTURED == "1") { echo "<th onclick=\"getCLIS('','',LIMIT,'FACTURED');\">Impayé</th>"; }
			echo "</tr>";
			while($row = $result->fetch_assoc()) {
				echo "
					 <tr><td onclick=\"document.getElementById('chkCL" . $row["id"] . "').click();\"><div style='width:20px;'><input id='chkCL" . $row["id"] . "' value='" . $row["id"] . "' type='checkbox' style='pointer-events: none;'><input id='CLADR" . $row["id"] . "' value='" . $row["adr1"] . " " . $row["adr2"] . ", " . $row["city"] . " " . $row["province"] . " " . $row["country"] . "" . $row["postal_code"] . "' type='text' style='display:none;'></div></td>";
				if ($DSP_ID == "1") { echo "<td onclick='getCLI(\"". $row["id"] . "\");'>". $row["id"] . "</td>";}
				if ($DSP_STAT == "1") { echo "<td onclick='getCLI(\"". $row["id"] . "\");'>"; if ($row["stat"] == "0") { echo "<b style='color:green;'>Actif</b>"; } else if ($row["stat"] == "1") { echo "<b style='color:#DFC000;'>Inactif</b>"; } else if ($row["stat"] == "2") { echo "<b style='color:#E38600;'>Suspendu</b>"; } else if ($row["stat"] == "3") { echo "<b style='color:red;'>Banni</b>"; }  echo "</td>";}
				if ($DSP_TYPE == "1") { echo "<td onclick='getCLI(\"". $row["id"] . "\");'>"; if ($row["type"] == "PARTICULAR") { echo "Particulier"; } else if ($row["type"] == "COMPANY") { echo "Compagnie"; } else if ($row["type"] == "RETAILER") { echo "Détaillant"; } else if ($row["type"] == "INTERNAL") { echo "Interne"; }  echo "</td>";}
				if ($DSP_FULLNAME == "1") { echo "<td onclick='getCLI(\"". $row["id"] . "\");'>" .$row["prefix"] . " ". dw3_decrypt($row["first_name"]) . " ". dw3_decrypt($row["middle_name"]) . " ". dw3_decrypt($row["last_name"]) . " ". $row["suffix"] ."</td>";}
				if ($DSP_CIE == "1") { echo "<td onclick='getCLI(\"". $row["id"] . "\");'>". $row["company"]. "</td>";}
				if ($DSP_ADR == "1") { echo "<td onclick='getCLI(\"". $row["id"] . "\");'>". trim(dw3_decrypt($row["adr1"]) . " ". dw3_decrypt($row["adr2"])) . ", ". $row["city"] . " " . $row["province"] . " " . $row["postal_code"] . " ". $row["country"] . "</td>";}
				if ($DSP_LANG == "1") { echo "<td onclick='getCLI(\"". $row["id"] . "\");'>". $row["lang"] . "</td>";}
				if ($DSP_PRENOM == "1") { echo "<td onclick='getCLI(\"". $row["id"] . "\");'>". dw3_decrypt($row["first_name"]) . "</td>";}
				if ($DSP_NOM == "1") { echo "<td onclick='getCLI(\"". $row["id"] . "\");'>". dw3_decrypt($row["last_name"]) . "</td>";}
				if ($DSP_ADR1 == "1") { echo "<td onclick='getCLI(\"". $row["id"] . "\");'>". dw3_decrypt($row["adr1"]) . "</td>";}
				if ($DSP_ADR2 == "1") { echo "<td onclick='getCLI(\"". $row["id"] . "\");'>". dw3_decrypt($row["adr2"]) . "</td>";}
				if ($DSP_VILLE == "1") { echo "<td onclick='getCLI(\"". $row["id"] . "\");'>". $row["city"] . "</td>";}
				if ($DSP_PROV == "1") { echo "<td onclick='getCLI(\"". $row["id"] . "\");'>". $row["province"] . "</td>";}
				if ($DSP_PAYS == "1") { echo "<td onclick='getCLI(\"". $row["id"] . "\");'>". $row["country"] . "</td>";}
				if ($DSP_CP == "1") { echo "<td onclick='getCLI(\"". $row["id"] . "\");'>". $row["postal_code"] . "</td>";}
				if ($DSP_TEL1 == "1") { echo "<td onclick='getCLI(\"". $row["id"] . "\");'>". dw3_decrypt($row["tel1"]) . "</td>";}
				if ($DSP_TEL2 == "1") { echo "<td onclick='getCLI(\"". $row["id"] . "\");'>". dw3_decrypt($row["tel2"]) . "</td>";}
				if ($DSP_EML1 == "1") { echo "<td onclick='getCLI(\"". $row["id"] . "\");'>". dw3_decrypt($row["eml1"]) . "</td>";}
				if ($DSP_EML2 == "1") { echo "<td onclick='getCLI(\"". $row["id"] . "\");'>". dw3_decrypt($row["eml2"]) . "</td>";}
				if ($DSP_LNG == "1") { echo "<td onclick='getCLI(\"". $row["id"] . "\");'>". $row["longitude"] . "</td>";}
				if ($DSP_LAT == "1") { echo "<td onclick='getCLI(\"". $row["id"] . "\");'>". $row["latitude"] . "</td>";}
				if ($DSP_NOTE == "1") { echo "<td onclick='getCLI(\"". $row["id"] . "\");'>". $row["note"] . "</td>";}
				if ($DSP_DTAD == "1") { echo "<td onclick='getCLI(\"". $row["id"] . "\");'>". $row["date_created"] . "</td>";}
				if ($DSP_DTMD == "1") { echo "<td onclick='getCLI(\"". $row["id"] . "\");'>". $row["date_modified"] . "</td>";}
				if ($DSP_BALANCE == "1") { echo "<td onclick='getCLI(\"". $row["id"] . "\");' style='text-align:right;";if($row["balance"]<0){echo "color:red;";}else if ($row["balance"]>0){echo "color:green;";} echo "'>". number_format($row["balance"],2,'.',' ') . "</td>";}
				if ($DSP_FACTURED == "1") { echo "<td onclick='getCLI(\"". $row["id"] . "\");' style='text-align:right;'>". number_format($row["factured"],2,'.',' ') . "</td>";}
				echo "</tr>";
			}
			echo "</table></form></div>";
            echo "<div style='text-align:left;width:100%;padding:5px 0px;margin-bottom:50px;'>Total de <b>" . $numrows . "</b> clients selon la recherche et les filtres.</div>";
				echo "<div id='divFOOT'><div id='hiddenDiv2' style='text-align:left;display:inline-block;'>
						<button style='background:#444444;margin:3px;' onclick='selALL(\"frmCLI\",\"checkbox\");'><span class='material-icons'>done_all</span></button>";
				echo "<button style='background:#444444;margin:3px;' onclick='selNONE(\"frmCLI\",\"checkbox\");'><span class='material-icons'>remove_done</span></button> ";
				echo " <button style='background:#444444;margin:3px;' onclick='openBatch();'><span class='material-icons'>ballot</span></button>";
                echo " <div id='divBATCH' style='color:white;background:#444444;border-radius:5px;position:fixed;transition: all 1s;bottom:-300px;left:50%;-webkit-transform: translateX(-65%);padding:5px'>";
				echo "<u>Selon la selection:</u><br><button style='margin:3px;' onclick='updateGPS();'><span class='material-icons'>where_to_vote</span></button> MaJ GPS";
				echo "<br><button style='margin:3px;' onclick='ExportToExcel(\"dataTABLE\",\"xlsx\");'><span class='material-icons'>description</span></button> XLS";
				echo "<br><button style='margin:3px;' onclick='ExportToPDF(\"dataTABLE\",\"clients.pdf\");'><span class='material-icons'>picture_as_pdf</span></button> PDF";
				echo "<br><button style='background:red;margin:3px;' onclick='deleteCLIS();'><span class='material-icons'>delete_sweep</span></button> Supprimer";
                echo "        </div>";
                echo "</div>";		
			//FIRST PAGE
			if ($OFFSET > 0){
				echo "<button onclick='getCLIS(\"\",\"\",\"" . $LIMIT . "\");'><span class='material-icons'>first_page</span></button>";
			} else {
				echo "<button style='background:#666666;' disabled><span class='material-icons'>first_page</span></button>";
			}
			//PREVIOUS PAGE
			if ($OFFSET > 0){
				$page = $OFFSET-$LIMIT;
				if ($page<0){$page=0;}
				echo "<button onclick='getCLIS(\"\",\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_before</span></button>";
			} else {
				echo "<button style='background:#666666;' disabled><span class='material-icons'>navigate_before</span></button>";
			}
			//CURRENT PAGE
			echo "<b style='font-size:1.2em;'>" . ceil(($OFFSET/$LIMIT)+1) 
			. "</b>/<b>" . ceil($numrows/$LIMIT) 
			. "</b>";
			//NEXTPAGE
			if (($OFFSET+$LIMIT) < ($numrows)){
				$page = $OFFSET+$LIMIT;
				echo "<button onclick='getCLIS(\"\",\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_next</span></button>";
			} else {
				echo "<button style='background:#666666;' disabled><span class='material-icons'>navigate_next</span></button>";
			}
			//LASTPAGE
			if (($OFFSET+$LIMIT) < ($numrows)){
				$lastpage = $numrows-$LIMIT;
				echo "<button onclick='getCLIS(\"\",\"". $lastpage ."\",\"" . $LIMIT . "\");'><span class='material-icons'>last_page</span></button>";
			} else {
				echo "<button style='background:#666666;' disabled><span class='material-icons'>last_page</span></button>";
			}
			echo "</div>";
		} else {
			echo "<table id='dataTABLE' class='tblSEL'>
					<tr><th>Clients</th><tr>
					<tr onclick='openNEW();'><td>Aucun client trouvé selon la recherche... Pour ajouter un client appuyez sur [+]</td></tr>
					</table>";
		}
$dw3_conn->close();
?>