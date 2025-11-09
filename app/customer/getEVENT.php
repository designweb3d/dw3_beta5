  <?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID  = $_GET['ID'];

	$sql = "SELECT * FROM event WHERE id = " . $ID . " LIMIT 1";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {	

		while($row = $result->fetch_assoc()) {
			echo "<div style='position:absolute;top:50px;left:0px;right:0px;bottom:50px;overflow-x:hidden;overflow-y:auto;'>
                    <div class='divBOX'>Type d'évènement:
                        <select name='evTYPE' id='evTYPE'>
                            <option value='EMAIL'"; if 	($row["event_type"] =="EMAIL"){ echo " selected"; } echo ">Courriel</option>
                            <option value='TASK'"; if 	($row["event_type"] =="TASK"){ echo " selected"; } echo ">Tâche</option>
                            <option value='CALL_INFO'"; if 	($row["event_type"] =="CALL_INFO"){ echo " selected"; } echo ">Appel d'un client pour de l'information</option>
                            <option value='CALL_TECH'"; if 	($row["event_type"] =="CALL_TECH"){ echo " selected"; } echo ">Appel d'un client pour du support</option>
                            <option value='COMPLAINT'"; if 	($row["event_type"] =="COMPLAINT"){ echo " selected"; } echo ">Plainte du client</option>
                            <option value='ROAD_INCIDENT'"; if 	($row["event_type"] =="ROAD_INCIDENT"){ echo " selected"; } echo ">Incident de la route</option>
                            <option value='PRIVACY_INCIDENT'"; if 	($row["event_type"] =="PRIVACY_INCIDENT"){ echo " selected"; } echo ">Incident de confidentialité</option>
                        </select>
                    </div>              
                    <div class='divBOX'>Nom de l'évènement:
                        <input id='evNAME' type='text' value='" . str_replace("'", "\'", htmlspecialchars($row["name"], ENT_QUOTES)) . "' onclick='detectCLICK(event,this);'>
                    </div><br>		
                    <div class='divBOX'>Priorité:
                        <select name='evPRIORITY' id='evPRIORITY'>
                            <option value='LOW'"; if 	($row["priority"] =="LOW"){ echo " selected"; } echo ">Basse</option>
                            <option value='MEDIUM'"; if 	($row["priority"] =="MEDIUM"){ echo " selected"; } echo ">Moyenne</option>
                            <option value='HIGH'"; if 	($row["priority"] =="HIGH"){ echo " selected"; } echo ">Haute</option>
                        </select>
                    </div>";                    				
                    echo "<div class='divBOX'>Status:
                    <select id='evSTATUS' style='width:100%;'>
                        <option value='TO_DO'"; if ($row["status"] == "TO_DO") { echo " selected"; } echo ">À FAIRE</option>
                        <option value='IN_PROGRESS'"; if ($row["status"] == "IN_PROGRESS") { echo " selected"; } echo ">EN COURS</option>
                        <option value='DONE'"; if ($row["status"] == "DONE") { echo " selected"; } echo ">TERMINÉ</option>
                        <option value='N/A'"; if ($row["status"] == "N/A" || $row["status"] == "") { echo " selected"; } echo ">Non applicable</option>
                    </select></div>";
                    echo "<div class='divBOX' style='max-width:98%;'>Description:
                        <textarea id='evDESC_FR' style='height:200px;width:100%;'>" . str_replace("'", "\'", str_replace("<br>", "\n", $row["description"])) . "</textarea>
                    </div>";
                    echo "<br>  		
                    <div class='divBOX'>Date:
                        <input id='evDATE' type='date' value='" . substr($row["date_start"],0,10) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'>Heure de début:
                        <input id='evDATE_START' type='time' value='" .substr($row["date_start"],11,5) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'>Heure de fin:
                        <input id='evDATE_END' type='time' value='" .substr($row["end_date"],11,5) . "' onclick='detectCLICK(event,this);'>
                    </div>									
                    <div class='divBOX'>Lien:
                        <input id='evHREF' type='text' value='" . $row["href"] . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'>Image:
                        <input id='evIMG' type='text' value='" . $row["img_src"] . "' onclick='detectCLICK(event,this);'>
                    </div>				
				<br><br></div><div class='dw3_form_foot'>";
                    if ($APREAD_ONLY == false) { echo "<button class='red' onclick='deleteEVENT(\"" . $row["id"] . "\");'><span class='material-icons'>delete</span></button>";}
                    echo "<button class='grey' onclick='closeEVENT();'><span class='material-icons'>cancel</span> " . $dw3_lbl["CANCEL"] . "</button>";
                    if ($APREAD_ONLY == false) { echo "<button class='green' onclick='updEVENT(\"" . $row["id"] . "\");'><span class='material-icons'>save</span>" . $dw3_lbl["SAVE"] . "</button>";}
				echo "</div>";
		}
	
	}
$dw3_conn->close();
?>