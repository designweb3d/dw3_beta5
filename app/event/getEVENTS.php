<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SS  = str_replace("\"", "\'", str_replace("'", "\'", $_GET['SS'])); //RECHERCHE 
$evTYPE  = $_GET['TYPE'];
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
				case 'NAME':
					$DSP_NAME = $row["value"];
					break;
				case 'ID':
					$DSP_ID = $row["value"];
					break;
				case 'TYPE':
					$DSP_TYPE = $row["value"];
					break;
				case 'DESC':
					$DSP_DESC = $row["value"];
					break;
				case 'DTMD':
					$DSP_DTMD = $row["value"];
					break;
			}
		}
	} else {
        $DSP_NAME = "1";
        $DSP_ID = "0";
        $DSP_TYPE = "1";
        $DSP_DESC = "0";
        $DSP_DTMD = "1";
        $ORDERBY = "";
        $ORDERWAY = "";

	}
//ORDER BY & WAY
	if ($ORDERBY == ""){ $ORDERBY = " id " ;}
    if ($ORDERBY == "NAME"){ $ORDERBY = " name " ;}
    if ($ORDERBY == "TYPE"){ $ORDERBY = " event_type " ;}
	if ($ORDERBY == "ID"){ $ORDERBY = " id " ;}
	if ($ORDERBY == "DTMD"){ $ORDERBY = " date_start " ;}
	if ($ORDERWAY == ""){ $ORDERWAY = " ASC " ;}
    	

//GET TOTAL
$sql = "SELECT COUNT(*) as TOTR
				FROM event
				WHERE id > -1 " ;
if ($evTYPE != ""){ $sql = $sql . " AND  event_type = '" . $evTYPE . "' "; }
if ($SS != ""){ $sql = $sql . " AND  CONCAT(name, event_type, description) like '%" . $SS . "%' "; }

	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$numrows = $row["TOTR"] ;
		}
	}


			$sql = "SELECT * FROM event
				WHERE id > -1 ";
			if ($evTYPE != ""){ $sql = $sql . " AND  event_type = '" . $evTYPE . "' "; }
            if ($SS != ""){ $sql = $sql . " AND  CONCAT(name, event_type, description) like '%" . $SS . "%' "; }			$sql = $sql . "
				ORDER BY " . $ORDERBY . " " . $ORDERWAY . " 
				LIMIT " . $LIMIT . " OFFSET " . $OFFSET;
				
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {	
			echo "<div style='max-width:100%;width:100%;overflow-x:auto;'>" ;		
			echo "<form onsubmit='submitForm(event)' id='frmEVENT' class='submit-disabled'>
			<table id='dataTABLE' class='tblSEL'>";
			//<tr style='background:white;'><th>Date et heure</th><th>Type d'évenement</th><th>Nom de l'evenement</th></tr>";
                echo "<tr><th style='text-align:center;overflow:hidden;'><span class='material-icons' style='vertical-align:middle;font-size:18px;margin-left:-4px;'>check_box</span></th>";
                if ($DSP_ID == "1") { echo "<th>#ID</th>"; }
                if ($DSP_DTMD == "1") { echo "<th>Date et heure</th>"; }
                if ($DSP_TYPE == "1") { echo "<th>Type</th>"; }
                if ($DSP_NAME == "1") { echo "<th>Nom de l'evenement</th>"; }
                if ($DSP_DESC == "1") { echo "<th>Description</th>"; }
			while($row = $result->fetch_assoc()) {	
                //status de la tache
                if ( $row["event_type"] == "TASK"){
                    if ($row["status"] == "TO_DO"){
                        $status = "<span style='font-family:Roboto;font-size:11px;padding:3px;background-color:grey;color:white;border-radius:10px 0px 0px 10px;width:60px;text-align:center;'>À FAIRE</span>";
                    }else if ($row["status"] == "IN_PROGRESS"){
                        $status = "<span style='font-family:Roboto;font-size:11px;padding:3px;background-color:grey;color:turquoise;border-radius:10px 0px 0px 10px;width:60px;text-align:center;'>EN COURS</span>";
                    }else if ($row["status"] == "DONE"){
                        $status = "<span style='font-family:Roboto;font-size:11px;padding:3px;background-color:green;color:white;border-radius:10px 0px 0px 10px;width:60px;text-align:center;'>TERMINÉ</span>";
                    } else {
                        $status = "<span style='font-family:Roboto;font-size:11px;padding:3px;background-color:grey;color:white;border-radius:10px 0px 0px 10px;width:60px;text-align:center;'>N/A</span>";
                    }
                    //priorité de la tache
                    if ($row["priority"] == "LOW"){
                        $priority = "<span style='font-family:Roboto;font-size:11px;padding:3px;background-color:gold;color:white;border-radius:0px 10px 10px 0px;width:60px;text-align:center;'>BASSE</span>";
                    }else if ($row["priority"] == "MEDIUM"){
                        $priority = "<span style='font-family:Roboto;font-size:11px;padding:3px;background-color:orange;color:white;border-radius:0px 10px 10px 0px;width:60px;text-align:center;'>MOYENNE</span>";
                    }else if ($row["priority"] == "HIGH"){
                        $priority = "<span style='font-family:Roboto;font-size:11px;padding:3px;background-color:red;color:white;border-radius:0px 10px 10px 0px;width:60px;text-align:center;'>HAUTE</span>";
                    } else {
                        $priority = "<span style='font-family:Roboto;font-size:11px;padding:3px;background-color:grey;color:white;border-radius:0px 10px 10px 0px;width:60px;text-align:center;'>N/D</span>";
                    } 
                } else {
                    $status = "";
                    $priority = "";
                }
				echo "<tr><td onclick=\"document.getElementById('chkEVENT" . $row["id"] . "').click();\"><div style='width:20px;'><input id='chkEVENT" . $row["id"] . "' value='" . $row["id"] . "' type='checkbox' style='pointer-events: none;'></div></td>";
                if ($DSP_ID == "1") { echo "<td onclick='getEVENT(\"". $row["id"] . "\");'>". $row["id"] . "</td>"; }
                if ($DSP_DTMD == "1") { echo "<td onclick='getEVENT(\"". $row["id"] . "\");'>". $row["date_start"] . "</td>"; }
                if ($DSP_TYPE == "1") { echo "<td onclick='getEVENT(\"". $row["id"] . "\");'>". $row["event_type"] . "</td>"; }
                if ($DSP_NAME == "1") { echo "<td onclick='getEVENT(\"". $row["id"] . "\");'>".$status.$priority. " ". $row["name"] . "</td>"; }
                if ($DSP_DESC == "1") { echo "<td onclick='getEVENT(\"". $row["id"] . "\");'>". $row["description"] . "</td>"; }
				echo "</tr>";
			}
			echo "</table></form></div>";

            echo "<div style='text-align:left;width:100%;padding:5px 0px;margin-bottom:50px;'><br>Total de <b>" . $numrows . "</b> évènements selon la recherche et les filtres.</div>";
				echo "<div id='divFOOT'><div id='hiddenDiv2' style='text-align:left;display:inline-block;'>
						<button style='background:#444444;margin:3px;' onclick='selALL(\"frmEVENT\",\"checkbox\");'><span class='material-icons'>done_all</span></button>";
				echo "<button style='background:#444444;margin:3px;' onclick='selNONE(\"frmEVENT\",\"checkbox\");'><span class='material-icons'>remove_done</span></button> ";
				echo " <button style='background:#444444;margin:3px;' onclick='openBatch();'><span class='material-icons'>ballot</span></button>";
                echo " <div id='divBATCH' style='color:white;background:#444444;border-radius:5px;position:fixed;transition: all 1s;bottom:-300px;left:50%;-webkit-transform: translateX(-65%);padding:5px'>";
                echo "<br><button style='margin:3px;' onclick=\"ExportToPDF('dataTABLE','Events');\"><span class='material-icons'>picture_as_pdf</span></button> PDF";
                echo "<br><button style='margin:3px;' onclick=\"ExportToExcel('dataTABLE','xlsx','Events');\"><span class='material-icons'>table_view</span></button> XLSX";
				echo "<br><button style='background:red;margin:3px;' onclick='deleteEVENTS();'><span class='material-icons'>delete_sweep</span></button> Supprimer";
                echo "        </div>";
                echo "</div>";		
			//FIRST PAGE
			if ($OFFSET > 0){
				echo "<button onclick='getEVENTS(\"\",\"\",\"" . $LIMIT . "\");'><span class='material-icons'>first_page</span></button>";
			} else {
				echo "<button style='background:#666666;' disabled><span class='material-icons'>first_page</span></button>";
			}
			//PREVIOUS PAGE
			if ($OFFSET > 0){
				$page = $OFFSET-$LIMIT;
				if ($page<0){$page=0;}
				echo "<button onclick='getEVENTS(\"\",\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_before</span></button>";
			} else {
				echo "<button style='background:#666666;' disabled><span class='material-icons'>navigate_before</span></button>";
			}
			//CURRENT PAGE
			echo "<b>" . ceil(($OFFSET/$LIMIT)+1) 
			. "</b> / <b>" . ceil($numrows/$LIMIT) 
			. "</b>";
			//NEXTPAGE
			if (($OFFSET+$LIMIT) < ($numrows)){
				$page = $OFFSET+$LIMIT;
				echo "<button onclick='getEVENTS(\"\",\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_next</span></button>";
			} else {
				echo "<button style='background:#666666;' disabled><span class='material-icons'>navigate_next</span></button>";
			}
			//LASTPAGE
			if (($OFFSET+$LIMIT) < ($numrows)){
				$lastpage = $numrows-$LIMIT;
				echo "<button onclick='getEVENTS(\"\",\"". $lastpage ."\",\"" . $LIMIT . "\");'><span class='material-icons'>last_page</span></button>";
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