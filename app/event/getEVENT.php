<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID  = $_GET['ID'];
$text_width  = $_GET['tw'];

	$sql = "SELECT * FROM event WHERE id = " . $ID . " LIMIT 1";
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
                <div style='position:absolute;top:50px;left:0px;right:0px;bottom:50px;overflow-x:hidden;overflow-y:auto;'>
                    <div class='divBOX'>Type d'évènement:
                        <select name='evTYPE' id='evTYPE'>
                            <option value=''"; if 	($row["event_type"] ==""){ echo " selected"; } echo ">Type d'évènement non spécifié</option>
                            <option value='TASK'"; if 	($row["event_type"] =="TASK"){ echo " selected"; } echo ">Tâche</option>
                            <option value='EMAIL'"; if 	($row["event_type"] =="EMAIL"){ echo " selected"; } echo ">Courriel envoyé</option>
                            <option value='PUBLIC'"; if 	($row["event_type"] =="PUBLIC"){ echo " selected"; } echo ">Évènement PUBLIQUE</option>
                            <option value='CALL_INFO'"; if 	($row["event_type"] =="CALL_INFO"){ echo " selected"; } echo ">Appel d'un client pour de l'information</option>
                            <option value='CALL_TECH'"; if 	($row["event_type"] =="CALL_TECH"){ echo " selected"; } echo ">Appel d'un client pour du support</option>
                            <option value='COMPLAINT'"; if 	($row["event_type"] =="COMPLAINT"){ echo " selected"; } echo ">Appel d'un client pour une plainte</option>
                            <option value='PRIVACY_INCIDENT'"; if 	($row["event_type"] =="PRIVACY_INCIDENT"){ echo " selected"; } echo ">Incident de confidentialité</option>
                            <option value='ROAD_INCIDENT'"; if 	($row["event_type"] =="ROAD_INCIDENT"){ echo " selected"; } echo ">Incident de la route</option>
                            <option value='LOGIN'"; if 	($row["event_type"] =="LOGIN"){ echo " selected"; } echo ">Tentative de connexion échouée</option>
                            <option value='SYSTEM'"; if 	($row["event_type"] =="SYSTEM"){ echo " selected"; } echo ">Action du système</option>
                            <option value='CUSTOMER'"; if 	($row["event_type"] =="CUSTOMER"){ echo " selected"; } echo ">Action au dossier client</option>
                            <option value='INVOICE'"; if 	($row["event_type"] =="INVOICE"){ echo " selected"; } echo ">Création / annulation de facture</option>
                            <option value='ORDER'"; if 	($row["event_type"] =="ORDER"){ echo " selected"; } echo ">Création de commande</option>
                            <option value='USER'"; if 	($row["event_type"] =="USER"){ echo " selected"; } echo ">Création de compte utilisateur</option>
                            <option value='UPDATE'"; if 	($row["event_type"] =="UPDATE"){ echo " selected"; } echo ">Mise à jour</option>
                        </select>
                    </div>             
                    <div class='divBOX'>Priorité:
                        <select name='evPRIORITY' id='evPRIORITY'>
                            <option value='LOW'"; if 	($row["priority"] =="LOW"){ echo " selected"; } echo ">Basse</option>
                            <option value='MEDIUM'"; if 	($row["priority"] =="MEDIUM"){ echo " selected"; } echo ">Moyenne</option>
                            <option value='HIGH'"; if 	($row["priority"] =="HIGH"){ echo " selected"; } echo ">Haute</option>
                        </select>
                    </div><br>              
                    <div class='divBOX'>Nom de l'évènement FR:
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
                    echo "
					<div id='divCharEvent' style='overflow-y:auto;overflow-x:hidden;height:150px;width:100%;vertical-align:middle;text-align:center;'>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('<br>');\">&#9166;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#8592;');\">&#8592;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#8593;');\">&#8593;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#8594;');\">&#8594;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#8595;');\">&#8595;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#9824;');\">&#9824;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#9827;');\">&#9827;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#9829;');\">&#9829;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#9830;');\">&#9830;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#129496;');\">&#129496;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#x2022; ');\">&#x2022;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#171;');\">&#171;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#187;');\">&#187;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#169;');\">&#169;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#174;');\">&#174;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#8482;');\">&#8482;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#163;');\">&#163;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#165;');\">&#165;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#162;');\">&#162;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#8364;');\">&#8364;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#8721;');\">&#8721;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#8719;');\">&#8719;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#8715;');\">&#8715;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#8713;');\">&#8713;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#8712;');\">&#8712;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#8711;');\">&#8711;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#8709;');\">&#8709;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#8707;');\">&#8707;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#8706;');\">&#8706;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#8704;');\">&#8704;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128512;');\">&#128512;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128513;');\">&#128513;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128514;');\">&#128514;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128515;');\">&#128515;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128516;');\">&#128516;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128517;');\">&#128517;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128518;');\">&#128518;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128519;');\">&#128519;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128520;');\">&#128520;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128521;');\">&#128521;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128522;');\">&#128522;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128523;');\">&#128523;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128524;');\">&#128524;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128525;');\">&#128525;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128526;');\">&#128526;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128527;');\">&#128527;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128528;');\">&#128528;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128529;');\">&#128529;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128530;');\">&#128530;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128531;');\">&#128531;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128532;');\">&#128532;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128533;');\">&#128533;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128534;');\">&#128534;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128535;');\">&#128535;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128536;');\">&#128536;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128537;');\">&#128537;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128538;');\">&#128538;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128539;');\">&#128539;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128540;');\">&#128540;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128541;');\">&#128541;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128542;');\">&#128542;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128543;');\">&#128543;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128544;');\">&#128544;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128545;');\">&#128545;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128546;');\">&#128546;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128547;');\">&#128547;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128548;');\">&#128548;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128549;');\">&#128549;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128550;');\">&#128550;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128551;');\">&#128551;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128552;');\">&#128552;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128553;');\">&#128553;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128554;');\">&#128554;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128555;');\">&#128555;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128556;');\">&#128556;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128557;');\">&#128557;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128558;');\">&#128558;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128559;');\">&#128559;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128560;');\">&#128560;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128561;');\">&#128561;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128562;');\">&#128562;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128563;');\">&#128563;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128564;');\">&#128564;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128565;');\">&#128565;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128566;');\">&#128566;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128567;');\">&#128567;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128568;');\">&#128568;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128569;');\">&#128569;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128570;');\">&#128570;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128571;');\">&#128571;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128572;');\">&#128572;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128573;');\">&#128573;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128574;');\">&#128574;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128575;');\">&#128575;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128576;');\">&#128576;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128577;');\">&#128577;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128578;');\">&#128578;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128579;');\">&#128579;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128580;');\">&#128580;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128581;');\">&#128581;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128582;');\">&#128582;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128583;');\">&#128583;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128584;');\">&#128584;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128585;');\">&#128585;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128586;');\">&#128586;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128587;');\">&#128587;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128588;');\">&#128588;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128589;');\">&#128589;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128590;');\">&#128590;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128591;');\">&#128591;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128592;');\">&#128592;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128593;');\">&#128593;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128594;');\">&#128594;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128595;');\">&#128595;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128596;');\">&#128596;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128597;');\">&#128597;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128598;');\">&#128598;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128599;');\">&#128599;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128600;');\">&#128600;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128601;');\">&#128601;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128602;');\">&#128602;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128603;');\">&#128603;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128604;');\">&#128604;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128605;');\">&#128605;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128606;');\">&#128606;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128607;');\">&#128607;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128608;');\">&#128608;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128609;');\">&#128609;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128610;');\">&#128610;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128611;');\">&#128611;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128612;');\">&#128612;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128613;');\">&#128613;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128614;');\">&#128614;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128615;');\">&#128615;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128616;');\">&#128616;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128617;');\">&#128617;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128618;');\">&#128618;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128619;');\">&#128619;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128620;');\">&#128620;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128621;');\">&#128621;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128622;');\">&#128622;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128623;');\">&#128623;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128624;');\">&#128624;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128625;');\">&#128625;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128626;');\">&#128626;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128627;');\">&#128627;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128628;');\">&#128628;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128629;');\">&#128629;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128630;');\">&#128630;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128631;');\">&#128631;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128632;');\">&#128632;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128633;');\">&#128633;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128634;');\">&#128634;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128635;');\">&#128635;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128636;');\">&#128636;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128637;');\">&#128637;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128638;');\">&#128638;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128639;');\">&#128639;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128640;');\">&#128640;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128641;');\">&#128641;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128642;');\">&#128642;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128643;');\">&#128643;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128644;');\">&#128644;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128645;');\">&#128645;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128646;');\">&#128646;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128647;');\">&#128647;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128648;');\">&#128648;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128649;');\">&#128649;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128650;');\">&#128650;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128651;');\">&#128651;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128652;');\">&#128652;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128653;');\">&#128653;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128654;');\">&#128654;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128655;');\">&#128655;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128656;');\">&#128656;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128657;');\">&#128657;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128658;');\">&#128658;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128659;');\">&#128659;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128660;');\">&#128660;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128661;');\">&#128661;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128662;');\">&#128662;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128663;');\">&#128663;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128664;');\">&#128664;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128665;');\">&#128665;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128666;');\">&#128666;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128667;');\">&#128667;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128668;');\">&#128668;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128669;');\">&#128669;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128670;');\">&#128670;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128671;');\">&#128671;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128672;');\">&#128672;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128673;');\">&#128673;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128674;');\">&#128674;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128675;');\">&#128675;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128676;');\">&#128676;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128677;');\">&#128677;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128678;');\">&#128678;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128679;');\">&#128679;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128680;');\">&#128680;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128681;');\">&#128681;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128682;');\">&#128682;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128683;');\">&#128683;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128684;');\">&#128684;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128685;');\">&#128685;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128686;');\">&#128686;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128687;');\">&#128687;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128688;');\">&#128688;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128689;');\">&#128689;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128690;');\">&#128690;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128691;');\">&#128691;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128692;');\">&#128692;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128693;');\">&#128693;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128694;');\">&#128694;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128695;');\">&#128695;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128696;');\">&#128696;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128697;');\">&#128697;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128698;');\">&#128698;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128699;');\">&#128699;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128700;');\">&#128700;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128701;');\">&#128701;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128702;');\">&#128702;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128703;');\">&#128703;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128704;');\">&#128704;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128705;');\">&#128705;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128706;');\">&#128706;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128707;');\">&#128707;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128708;');\">&#128708;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128709;');\">&#128709;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128710;');\">&#128710;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128711;');\">&#128711;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128712;');\">&#128712;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128713;');\">&#128713;</button>
					<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128714;');\">&#128714;</button>
					</div>
					";
                    echo "<div class='divBOX'>Status:
                        <select id='evSTATUS' style='width:100%;'>
                            <option value='TO_DO'"; if ($row["status"] == "TO_DO") { echo " selected"; } echo ">À FAIRE</option>
                            <option value='IN_PROGRESS'"; if ($row["status"] == "IN_PROGRESS") { echo " selected"; } echo ">EN COURS</option>
                            <option value='DONE'"; if ($row["status"] == "DONE") { echo " selected"; } echo ">TERMINÉ</option>
                            <option value='N/A'"; if ($row["status"] == "N/A" || $row["status"] == "") { echo " selected"; } echo ">Non applicable</option>
                        </select></div>";
                    echo "<div class='divBOX'>ID Utilisateur:";
                        if ($APREAD_ONLY == false) { echo "<button onclick=\"openSEL_USER('evUSER_ID')\" style='padding:5px;float:right;'><span class='material-icons'>saved_search</span></button>";}
                        echo "<input id='evUSER_ID' type='text' value='" . $row["user_id"] . "' onclick='detectCLICK(event,this);'>
                    </div>	
                    <div class='divBOX'>#ID du Projet:
                        <input id='evPRJ_ID' type='number' value='" . $row["project_id"] . "'>
                    </div>			
                    <div class='divBOX'>ID Client:";
                        if ($APREAD_ONLY == false) { echo "<button onclick=\"openSEL_CLI('evCLI_ID')\" style='padding:5px;float:right;'><span class='material-icons'>saved_search</span></button>";}
                        echo "<input id='evCLI_ID' type='text' value='" . $row["customer_id"] . "' onclick='detectCLICK(event,this);'>";
                    echo "</div><br>  		
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
                    echo "</select>
                    </div>		<br>  		
                    <div class='divBOX'>Date:
                        <input id='evDATE' type='date' value='" . substr($row["date_start"],0,10) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'>Heure de début:
                        <input oninput='' id='evDATE_START' type='time' value='" . substr($row["date_start"],11,5) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'>Heure de fin / due:
                        <input id='evDATE_END' type='time' value='" . substr($row["end_date"],11,5) . "' onclick='detectCLICK(event,this);'>
                        <div id='lblEV_DATE_END' style='color:white;font-size:0.8em;padding-left:10px;'></div>
                    </div>				
                    <div class='divBOX'>Durée (en minutes):
                        <input id='evDURATION' disabled type='text' value='" . $diff . "' onclick='detectCLICK(event,this);'>
                    </div>";	

                    if ($row["periodic"] == 1) {
                        if ($row["period_sequence"] == "1"){
                            echo "<div class='divBOX'>Événement périodique:";
                            if ($APREAD_ONLY == false) { echo "<button style='float:right;' class='red' onclick='deletePERIODIC(".$row["id"].");'><span class='material-icons'>delete</span> Supprimer les répétitions de cette tâche.</button>";}
                            echo "<br><span style='font-weight:bold;padding:0px 10px'>Séquence ->" . $row["period_sequence"] . " / ".$row["period_duration"]."</span>
                            </div>";
                        } else {
                            echo "<div class='divBOX'>Événement périodique:<br>
                                        <span style='font-weight:bold;padding:0px 10px'>Séquence -> " . $row["period_sequence"] . " / ".$row["period_duration"]."</span>
                                    </div>";
                        }
                    } else {
                        echo "<div class='divBOX'>Événement périodique: ";
                        if ($APREAD_ONLY == false) { echo "<button style='float:right;' class='blue' onclick='openPERIODIC(".$row["id"].");'><span class='material-icons'>event_repeat</span> Répéter</button>"; }
                        echo "</div>";
                    }

                    echo "<div class='divBOX'>Lien:
                        <input id='evHREF' type='text' value='" . $row["href"] . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'>Image:
                        <input id='evIMG' type='text' value='" . $row["img_src"] . "' onclick='detectCLICK(event,this);'>
                    </div>				
				<br><br></div><div class='dw3_form_foot'>";
                    if ($APREAD_ONLY == false) { echo "<button class='red' onclick='deleteEVENT(\"" . $row["id"] . "\");'><span class='material-icons'>delete</span></button>";}
                    echo "<button class='grey' onclick='closeEDITOR();'><span class='material-icons'>cancel</span> " . $dw3_lbl["CANCEL"] . "</button>";
                    if ($APREAD_ONLY == false) { echo "<button class='green' onclick='updEVENT(\"" . $row["id"] . "\");'><span class='material-icons'>save</span>" . $dw3_lbl["SAVE"] . "</button>";}
				echo "</div>";
		}
	
	}
$dw3_conn->close();
?>