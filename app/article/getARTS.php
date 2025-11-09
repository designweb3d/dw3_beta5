<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SS  = str_replace("\"", "\'", str_replace("'", "\'", $_GET['SS'])); //RECHERCHE 
$evAUTHOR  = str_replace("\"", "\'", str_replace("'", "\'", $_GET['AUTHOR']));
$ACTIVE  = $_GET['ACTIVE'];
$OFFSET  = $_GET['OFFSET'];
$LIMIT  = $_GET['LIMIT'];
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
				case 'ACTIVE':
					$DSP_ACTIVE = $row["value"];
					break;
				case 'AUTHOR':
					$DSP_AUTHOR = $row["value"];
					break;
				case 'TITLE':
					$DSP_TITLE = $row["value"];
					break;
				case 'CATEGORY':
					$DSP_CAT = $row["value"];
					break;
				case 'ID':
					$DSP_ID = $row["value"];
					break;
				case 'DTMD':
					$DSP_DTMD = $row["value"];
					break;
			}
		}
	} else {
        $DSP_ACTIVE = "1";
        $DSP_AUTHOR = "1";
        $DSP_TITLE = "1";
        $DSP_CAT = "1";
        $DSP_ID = "1";
        $DSP_DTMD = "1";
        $ORDERBY = "";
        $ORDERWAY = "";

	}
//ORDER BY & WAY
	if ($ORDERBY == ""){ $ORDERBY = " id " ;}
    if ($ORDERBY == "ACTIVE"){ $ORDERBY = " is_active " ;}
    if ($ORDERBY == "AUTHOR"){ $ORDERBY = " author_name " ;}
    if ($ORDERBY == "TITLE"){ $ORDERBY = " title_fr " ;}
    if ($ORDERBY == "CAT"){ $ORDERBY = " caterory_fr " ;}
	if ($ORDERBY == "ID"){ $ORDERBY = " id " ;}
	if ($ORDERBY == "DTMD"){ $ORDERBY = " date_start " ;}
	if ($ORDERWAY == ""){ $ORDERWAY = " ASC " ;}
    	

//GET TOTAL
$sql = "SELECT COUNT(*) as TOTR
				FROM article
				WHERE id > -1 " ;
if ($evAUTHOR != ""){ $sql = $sql . " AND  author_name = '" . $evAUTHOR . "' "; }
if ($SS != ""){ $sql = $sql . " AND  CONCAT(title_fr, title_en, author_name,category_fr,category_en) like '%" . $SS . "%' "; }

	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$numrows = $row["TOTR"] ;
		}
	}


			$sql = "SELECT * FROM article
				WHERE id > -1 ";
                if ($evAUTHOR != ""){ $sql = $sql . " AND  author_name = '" . $evAUTHOR . "' "; }
                if ($SS != ""){ $sql = $sql . " AND  CONCAT(title_fr, title_en, author_name,category_fr,category_en) like '%" . $SS . "%' "; }			
            $sql = $sql . "
				ORDER BY " . $ORDERBY . " " . $ORDERWAY . " 
				LIMIT " . $LIMIT . " OFFSET " . $OFFSET;
				
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {	
			echo "<div style='max-width:100%;width:100%;overflow-x:auto;'>" ;		
			echo "<form onsubmit='submitForm(event)' id='frmART' class='submit-disabled'>
			<table id='dataTABLE' class='tblSEL'>";
			//<tr style='background:white;'><th>Date et heure</th><th>Type d'évenement</th><th>Nom de l'evenement</th></tr>";
                echo "<tr><th style='text-align:center;overflow:hidden;'><span class='material-icons' style='vertical-align:middle;font-size:18px;margin-left:-4px;'>check_box</span></th>";
                if ($DSP_ID == "1") { echo "<th>#ID</th>"; }
                if ($DSP_ACTIVE == "1") { echo "<th>Actif</th>"; }
                if ($DSP_AUTHOR == "1") { echo "<th>Auteur</th>"; }
                if ($DSP_TITLE == "1") { echo "<th>Titre</th>"; }
                if ($DSP_CAT == "1") { echo "<th>Catégorie</th>"; }
                if ($DSP_DTMD == "1") { echo "<th>Date modifié</th>"; }
			while($row = $result->fetch_assoc()) {	
				echo "<tr><td onclick=\"document.getElementById('chkART" . $row["id"] . "').click();\"><div style='width:20px;'><input id='chkART" . $row["id"] . "' value='" . $row["id"] . "' type='checkbox' style='pointer-events: none;'></div></td>";
                if ($DSP_ID == "1") { echo "<td onclick='getART(\"". $row["id"] . "\");'>". $row["id"] . "</td>"; }
                if ($DSP_ACTIVE == "1") {echo "<td onclick='getART(\"". $row["id"] . "\");'>"; if ( $row["is_active"] == "1") {echo "<b style='color:green;'>Actif</b>"; } else if ($row["is_active"] == "0") {echo"<b style='color:#DFC000;'>Inactif</b>"; }echo"</td>";}
                if ($DSP_AUTHOR == "1") { echo "<td onclick='getART(\"". $row["id"] . "\");'>". $row["author_name"] . "</td>"; }
                if ($DSP_TITLE == "1") { echo "<td onclick='getART(\"". $row["id"] . "\");'>". $row["title_fr"] . "</td>"; }
                if ($DSP_CAT == "1") { echo "<td onclick='getART(\"". $row["id"] . "\");'>". $row["category_fr"] . "</td>"; }
                if ($DSP_DTMD == "1") { echo "<td onclick='getART(\"". $row["id"] . "\");'>". $row["date_modified"] . "</td>"; }
				echo "</tr>";
			}
			echo "</table></form></div>";

            echo "<div style='text-align:left;width:100%;padding:5px 0px;margin-bottom:50px;'><br>Total de <b>" . $numrows . "</b> évènements selon la recherche et les filtres.</div>";
				echo "<div id='divFOOT'><div id='hiddenDiv2' style='text-align:left;display:inline-block;'>
						<button class='grey' style='margin:3px;' onclick='selALL(\"frmART\",\"checkbox\");'><span class='material-icons'>done_all</span></button>";
				echo "  <button class='grey' style='margin:3px;' onclick='selNONE(\"frmART\",\"checkbox\");'><span class='material-icons'>remove_done</span></button> ";
				echo "  <button class='grey' style='margin:3px;' onclick='openBatch();'><span class='material-icons'>ballot</span></button>";
                echo " <div id='divBATCH' style='color:white;background:#444444;border-radius:5px;position:fixed;transition: all 1s;bottom:-300px;left:50%;-webkit-transform: translateX(-65%);padding:5px'>";
				echo "  <br><button style='margin:3px;' onclick='ExportToExcel(\"dataTABLE\",\"xlsx\");'><span class='material-icons'>description</span></button> XLS";
				echo "  <br><button style='margin:3px;' onclick='ExportToPDF(\"dataTABLE\",\"clients.pdf\");'><span class='material-icons'>picture_as_pdf</span></button> PDF";
                echo " </div>";
                echo "</div>";		
			//FIRST PAGE
			if ($OFFSET > 0){
				echo "<button onclick='getARTS(\"\",\"\",\"" . $LIMIT . "\");'><span class='material-icons'>first_page</span></button>";
			} else {
				echo "<button style='background:#666666;' disabled><span class='material-icons'>first_page</span></button>";
			}
			//PREVIOUS PAGE
			if ($OFFSET > 0){
				$page = $OFFSET-$LIMIT;
				if ($page<0){$page=0;}
				echo "<button onclick='getARTS(\"\",\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_before</span></button>";
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
				echo "<button onclick='getARTS(\"\",\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_next</span></button>";
			} else {
				echo "<button style='background:#666666;' disabled><span class='material-icons'>navigate_next</span></button>";
			}
			//LASTPAGE
			if (($OFFSET+$LIMIT) < ($numrows)){
				$lastpage = $numrows-$LIMIT;
				echo "<button onclick='getARTS(\"\",\"". $lastpage ."\",\"" . $LIMIT . "\");'><span class='material-icons'>last_page</span></button>";
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