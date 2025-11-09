<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID  = $_GET['ID'];

	$sql = "SELECT A.*, B.name AS loc_name, C.last_name AS cust_name, D.title AS proj_name, CONCAT(E.first_name, ' ', E.last_name) AS user_name
    FROM event A
    LEFT JOIN location B ON A.location_id = B.id
    LEFT JOIN customer C ON A.customer_id = C.id
    LEFT JOIN project D ON A.project_id = D.id
    LEFT JOIN user E ON A.user_id = E.id
    WHERE A.id = " . $ID . " LIMIT 1";
    //die($sql);
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {	

		while($row = $result->fetch_assoc()) {
				//calcul durée
				$from_time = strtotime($row["date_start"]); 
				$to_time = strtotime($row["end_date"]); 
				$diff = round(abs($from_time - $to_time) / 60);

			echo "<div id='divEDIT_HEADER' class='dw3_form_head'>
                        <h2>Évènement # " . $row["id"] . "</h2>
                         <button class='grey' style='top:0px;right:0px;padding:4px;position:absolute;' onclick='closeEDITOR(this);'><span class='material-icons'>cancel</span></button>
                </div>
                <div style='position:absolute;top:50px;left:0px;right:0px;bottom:50px;overflow-x:hidden;overflow-y:auto;'>";
//PRIORITY
                    echo "<div class='divBOX'>Priorité:
                        <select name='evPRIORITY' id='evPRIORITY'>
                            <option value='LOW'"; if 	($row["priority"] =="LOW"){ echo " selected"; } echo ">Basse</option>
                            <option value='MEDIUM'"; if 	($row["priority"] =="MEDIUM"){ echo " selected"; } echo ">Moyenne</option>
                            <option value='HIGH'"; if 	($row["priority"] =="HIGH"){ echo " selected"; } echo ">Haute</option>
                        </select>
                    </div>";              
//STATUS
                    echo "<div class='divBOX'>Status:
                        <select id='evSTATUS' style='width:100%;'>
                            <option value='TO_DO'"; if ($row["status"] == "TO_DO") { echo " selected"; } echo ">À FAIRE</option>
                            <option value='IN_PROGRESS'"; if ($row["status"] == "IN_PROGRESS") { echo " selected"; } echo ">EN COURS</option>
                            <option value='DONE'"; if ($row["status"] == "DONE") { echo " selected"; } echo ">TERMINÉ</option>
                            <option value='N/A'"; if ($row["status"] == "N/A" || $row["status"] == "") { echo " selected"; } echo ">Non applicable</option>
                        </select></div><br>";
//NAME AND DESC
                    echo "<div class='divBOX'>Nom de l'évènement FR:
                        <input id='evNAME' type='text' value='" . str_replace("'", "\'", htmlspecialchars($row["name"], ENT_QUOTES)) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'>Nom de l'évènement EN:
                        <input id='evNAME_EN' type='text' value='" . str_replace("'", "\'", htmlspecialchars($row["name_en"], ENT_QUOTES)) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'>Description FR:
                        <textarea id='evDESC_FR' onfocus='active_input=this.id;' style='height:200px;width:100%;'>" . str_replace("'", "\'", htmlspecialchars($row["description"], ENT_QUOTES)) . "</textarea>
                    </div>				
                    <div class='divBOX'>Description EN:
                        <textarea id='evDESC_EN' onfocus='active_input=this.id;' style='height:200px;width:100%;'>" . str_replace("'", "\'", htmlspecialchars($row["description_en"], ENT_QUOTES)) . "</textarea>
                    </div>";

                    echo "<div class='divBOX'>Utilisateur:
                        <input type='text' disabled value='" . $row["user_name"] . "'>
                    </div>	
                    <div class='divBOX'>Projet:<button onclick=\"openSEL_PRJ('evPRJ_ID')\" style='padding:5px;float:right;'><span class='material-icons'>saved_search</span></button>
                        <input type='text' disabled value='" . $row["proj_name"] . "'> 
                        <input id='evPRJ_ID' type='number' value='" . $row["project_id"] . "'>
                    </div>			
                    <div class='divBOX'>Client:<button onclick=\"openSEL_CLI('evCLI_ID')\" style='padding:5px;float:right;'><span class='material-icons'>saved_search</span></button>
                        <input type='text' disabled value='" . $row["cust_name"] . "'>
                        <input id='evCLI_ID' type='text' value='" . $row["customer_id"] . "' onclick='detectCLICK(event,this);'>
                    </div>		<br>  		
                    <div class='divBOX'>Emplacement:
                        <select name='evLOC_ID' id='evLOC_ID'>";
                        $sql2 ="SELECT * FROM location ORDER BY name";
                        $result2 = $dw3_conn->query($sql2);
                        if ($result2->num_rows > 0) {		
                            while($row2 = $result2->fetch_assoc()) {
                                $ISSELECTED = " ";
                                if ($row2["id"] == $row["location_id"]){ $ISSELECTED = " selected ";}
                                echo "<option " . $ISSELECTED . " value=" . $row2["id"] .">". $row2["name"] . "</option>";
                            }
                        } 
//DATES AND TIMES
                        $result2->close();
                    echo "</select>
                    </div>		<br>  		
                    <div class='divBOX'>Date:
                        <input id='evDATE' type='date' value='" . substr($row["date_start"],0,10) . "'>
                    </div>				
                    <div class='divBOX'>Heure de début:
                        <input id='evDATE_START' type='time' value='" . substr($row["date_start"],11,5) . "' oninput='calculateDuration();'>
                    </div>				
                    <div class='divBOX'>Heure de fin / due:
                        <input id='evDATE_END' type='time' value='" . substr($row["end_date"],11,5) . "' oninput='calculateDuration();'>
                        <div id='lblEV_DATE_END' style='color:white;font-size:0.8em;padding-left:10px;'></div>
                    </div>				
                    <div class='divBOX'>Durée (en minutes):
                        <input id='evDURATION' disabled type='text' value='" . $diff . "' onclick='detectCLICK(event,this);' style='text-align:middle;'>
                    </div><br>";	
//PERIODIC EVENT
                    if ($row["periodic"] == 1) {
                        if ($row["period_sequence"] == "1"){
                            echo "<div class='divBOX'>Événement périodique:
                            <button style='float:right;' class='red' onclick='deletePERIODIC(".$row["id"].");'><span class='material-icons'>delete</span> Supprimer les répétitions de cette tâche.</button>
                            <br><span style='font-weight:bold;padding:0px 10px'>Séquence ->" . $row["period_sequence"] . " / ".$row["period_duration"]."</span>
                            </div>";
                        } else {
                            echo "<div class='divBOX'>Événement périodique:<br>
                                        <span style='font-weight:bold;padding:0px 10px'>Séquence -> " . $row["period_sequence"] . " / ".$row["period_duration"]."</span>
                                    </div>";
                        }
                    } else {
                        echo "<div class='divBOX'>Événement périodique: <button style='float:right;' class='blue' onclick='openPERIODIC(".$row["id"].");'><span class='material-icons'>event_repeat</span> Répéter</button></div>";
                    }
//HREF AND IMG (unused for now)
                    echo "<br><div class='divBOX'>Lien:
                        <input id='evHREF' type='text' value='" . $row["href"] . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'>Image:
                        <input id='evIMG' type='text' value='" . $row["img_src"] . "' onclick='detectCLICK(event,this);'>
                    </div>				
				<br><br></div><div class='dw3_form_foot'>
                    <button class='red' onclick=\"deleteEVENT('" . $row["id"] . "');\"><span class='material-icons'>delete</span></button>
                    <button class='grey' onclick='closeEDITOR();'><span class='material-icons'>cancel</span> " . $dw3_lbl["CANCEL"] . "</button>
                    <button class='green' onclick=\"updEVENT('" . $row["id"] . "');\"><span class='material-icons'>save</span>" . $dw3_lbl["SAVE"] . "</button>
				</div>";
		}
	
	}
$dw3_conn->close();
?>