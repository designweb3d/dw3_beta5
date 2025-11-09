<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$day  = mysqli_real_escape_string($dw3_conn,$_GET['D']);
$year  = mysqli_real_escape_string($dw3_conn, $_GET['Y']);
$month  = mysqli_real_escape_string($dw3_conn, $_GET['M']);
$html = "<h2 style='text-align:left;'>Plage horaire</h2>";
$currentUSER = $_GET['USER_ID'];
$is_dispo = true;
//plage horaire
$sql = "SELECT A.*, B.name as location_name, B.adr1 as location_adr1, B.adr2 as location_adr2, B.city as location_city
            FROM schedule_head A
            LEFT JOIN location B ON A.location_id = B.id
			WHERE A.user_id = '" . $currentUSER . "' AND YEAR(A.start_date) = '" . $year . "' AND MONTH(A.start_date) = '" . $month . "'  AND DAY(A.start_date) = '" . $day . "' 
                OR A.user_id = '" . $currentUSER . "' AND YEAR(A.end_date) = '" . $year . "' AND MONTH(A.end_date) = '" . $month . "'  AND DAY(A.end_date) = '" . $day . "' 
			ORDER BY A.start_date";
            $html .= "<table class='tblDATA'><tr><th width='75'>Début</th><th width='75'>Fin</th><th width='150'>Durée</th><th width='*'>Lieu</th>";
            if ($APREAD_ONLY == false) {$html .= "<th colspan=2 width='70px'>Actions</th>";}
            $html .= "</tr>";
				$result = $dw3_conn->query($sql);
				if ($result->num_rows > 0) {	
					while($row = $result->fetch_assoc()) { 
                //calcul durée temps de travail programmé
                        $start_date = new DateTime($row["start_date"]);
                        $end_date = new DateTime($row["end_date"]);
                        //$diff = $end_date->diff($start_date);
                        //$diff->days.' days total<br>';
                        //$diff->y.' years<br>';
                        //$diff->m.' months<br>';
                        //$diff->d.' days<br>';
                        //$diff->h.' hours<br>';
                        //$diff->i.' minutes<br>';
                        //$diff->s.' seconds<br>'; 
                        $from_time = strtotime($row["start_date"]); 
                        $to_time = strtotime($row["end_date"]); 
                        $diff = round(abs($from_time - $to_time) / 60); 
                        if ($row["block_size"] == 0){ $row["block_size"] = 15;}                    
                        $total_block = floor($diff/$row["block_size"]);
                        if ($diff > 60){ 
                            if ($diff % 60 == 0) {
                                $dsp_time = floor($diff / 60) . " h";
                            } else {
                                $dsp_time = floor($diff / 60) . " h " . ($diff % 60) . " min";
                            }
                        } else { 
                            $dsp_time = $diff . " min";
                        }
						$html .= "<tr><td style='text-align:center;'>" . $start_date->format('H:i') . "</td>
                        <td style='text-align:center;'>" .$end_date->format('H:i') . "</td>
                        <td style='font-size:14px;'>" . $dsp_time . "<br>(" . $total_block . " x " . $row["block_size"] . " min)</td>";
                        if ($row["location_id"]== -1){
                            $row["location_name"] = "Télétravail";
                            $row["location_adr1"] = "";
                            $row["location_adr2"] = "";
                            $row["location_city"] = "";
                        }
                        $html .="<td style='font-size:15px;'>".$row["location_name"] . " " . $row["location_adr1"] . " ". $row["location_adr2"] . " " . $row["location_city"] . "</td>";
                        if ($APREAD_ONLY == false) {
                            $html .="<td width='35px' style='text-align:center;'><button onclick='openTS_REPEAT(\""   .  $row["id"]  . "\");'><span class='material-icons' style='font-size:16px;'>content_copy</span></button></td>
                            <td width='35px' style='text-align:center;'><button onclick='delHEAD(\""   .  $row["id"]  . "\");'><span class='material-icons' style='font-size:16px;'>backspace</span></button></td>";
                        }
                        $html .="</tr>";
                //calcul durée temps travaillé
                        $start_work = new DateTime($row["start_work"]);
                        $end_work = new DateTime($row["end_work"]);
                        $start_time = $start_work->format('H:i');
                        $end_time = $end_work->format('H:i');
                        //$diff = $end_date->diff($start_date);
                        //$diff->days.' days total<br>';
                        //$diff->y.' years<br>';
                        //$diff->m.' months<br>';
                        //$diff->d.' days<br>';
                        //$diff->h.' hours<br>';
                        //$diff->i.' minutes<br>';
                        //$diff->s.' seconds<br>'; 
                        $from_time = strtotime($row["start_work"]); 
                        $to_time = strtotime($row["end_work"]); 
                        $diff = round(abs($from_time - $to_time) / 60);
                        if ($diff > 60){ 
                            if ($diff % 60 == 0) {
                                $dsp_time = floor($diff / 60) . " h";
                            } else {
                                $dsp_time = floor($diff / 60) . " h " . ($diff % 60) . " min";
                            }
                        } else { 
                            $dsp_time = $diff . " min";
                        }                        
                        if ($row["start_work"] != "0000-00-00 00:00:00"){ $work_started = true; } else { $work_started = false; $dsp_time = ""; }
                        if ($row["end_work"] != "0000-00-00 00:00:00"){ $work_ended = true; } else { $work_ended = false; $dsp_time = "";}
                        $html .="<tr style='border-bottom: 2px solid #666;'><td style='text-align:center;'>";
                        //bouton commencer/modifier
                        if ($work_started == false && $APREAD_ONLY == false){
                            $html .="<button class='green' onclick='workSTART(\""   .  $row["id"]  . "\",false);'><span class='material-icons' style='font-size:16px;'>play_circle</span> Commencer</button>";
                        } else if ($work_started == true && $APREAD_ONLY == false){
                            $html .="<button class='blue' onclick=\"editSTART('"   .  $row["id"]  . "','".$start_time."');\"><span class='material-icons' style='font-size:16px;'>av_timer</span> ".$start_time."</button>";
                        } else {
                            $html .= $start_time;
                        }
                        $html .="</td><td style='text-align:center;'>";
                        //bouton terminer/modifier
                        if ($work_ended == false && $APREAD_ONLY == false){
                            $html .="<button"; if ($work_started == false){ $html .=" disabled  class='clear2'"; } else { $html .=" class='green'"; } $html .=" onclick=\"workEND('"   .  $row["id"]  . "',false);\"><span class='material-icons' style='font-size:16px;'>stop_circle</span> Terminer</button>";
                        } else if ($work_ended == true && $APREAD_ONLY == false){
                            $html .="<button class='blue' onclick=\"editEND('"   .  $row["id"]  . "','".$end_time."');\"><span class='material-icons' style='font-size:16px;'>av_timer</span> ".$end_work->format('H:i')."</button>";
                        } else {
                            $html .= $end_time;
                        }
                        $html .="</td><td style='text-align:center;'>" . $dsp_time . " </td>";
                        if ($row["virtual_enable"]==1){ $sVirtual = "<span style='padding:2px 4px;border-radius:10px;background-color:orange;color:white;font-size:12px;'>En ligne</span>"; } else { $sVirtual = ""; }
                        if ($row["road_enable"]==1){ $sRoad = "<span style='padding:2px 4px;border-radius:10px;background-color:#444;color:white;font-size:12px;'>Sur la route</span>"; } else { $sRoad = ""; }
                        if ($row["local_enable"]==1){ $sLocal = "<span style='padding:2px 4px;border-radius:10px;background-color:darkblue;color:white;font-size:12px;'>Bureau</span>"; } else { $sLocal = ""; }
                        if ($row["phone_enable"]==1){ $sPhone = "<span style='padding:2px 4px;border-radius:10px;background-color:darkgreen;color:white;font-size:12px;'>Téléphone</span>"; } else { $sPhone = ""; }
                        if ($row["is_public"]==1){ $sPublic = "<span style='padding:2px 4px;border-radius:10px;background-color:brown;color:white;font-size:12px;'>Public</span>"; } else { $sPublic = ""; }
                        $html .="<td>".$sVirtual." ".$sRoad." ".$sLocal." ".$sPhone." ".$sPublic."</td>";
                        if ( $APREAD_ONLY == false){
                            $html .="<td colspan='2'><button class='red' onclick='workOFF(\""   .  $row["id"]  . "\");'><span class='material-icons' style='font-size:16px;'>cancel</span> CALL OFF</button></td>";
                        }
                        $html .="</tr>";
					}
				} else {
                    $html .= "<tr><td colspan=5>Aucune plage horaire trouvée.</td></tr>";
                    $is_dispo = false;
                }
$html .= "</table><br>";

//taches
$html .= "<h2 style='text-align:left;'>Tâches";
    $html .= " <button style='float:right;' onclick=\"ExportToPDF('tblTASKS','Invoices');\"><span class='material-icons'>picture_as_pdf</span></button> ";
    $html .= " <button style='float:right;' onclick=\"ExportToExcel('tblTASKS','xlsx','Invoices');\"><span class='material-icons'>table_view</span></button> ";
$html .= "</h2>";
$sql = "SELECT * FROM event 
			WHERE user_id = '" . $currentUSER . "' AND event_type = 'TASK' AND YEAR(date_start) = '" . $year . "' AND MONTH(date_start) = '" . $month . "'  AND DAY(date_start) = '" . $day . "' 
                OR user_id = '" . $currentUSER . "' AND event_type = 'TASK' AND YEAR(end_date) = '" . $year . "' AND MONTH(end_date) = '" . $month . "'  AND DAY(end_date) = '" . $day . "' 
			ORDER  BY date_start";
$html .= "<table id='tblTASKS' class='tblSEL'><tr><th width='75'>Début</th><th width='75'>Fin</th><th width='*'>Tâche</th><th width='50'>Status</th><th width='50'>Priorité</th></tr>";
				$result = $dw3_conn->query($sql);
                //variables pour progression chart
                $numResults = $result->num_rows;
                $counter = 0;
                $var_label = "";
                $var_data = "";

				if ($result->num_rows > 0) {	
					while($row = $result->fetch_assoc()) {
                        //status de la tache
                        if ($row["status"] == "TO_DO"){
                            $status = "<span style='font-family:Roboto;font-size:13px;padding:5px;background-color:grey;color:white;border-radius:10px;width:75px;text-align:center;'>À FAIRE</span>";
                        }else if ($row["status"] == "IN_PROGRESS"){
                            $status = "<span style='font-family:Roboto;font-size:13px;padding:5px;background-color:grey;color:turquoise;border-radius:10px;width:75px;text-align:center;'>EN COURS</span>";
                        }else if ($row["status"] == "DONE"){
                            $status = "<span style='font-family:Roboto;font-size:13px;padding:5px;background-color:green;color:white;border-radius:10px;width:75px;text-align:center;'>TERMINÉ</span>";
                        } else {
                            $status = "<span style='font-family:Roboto;font-size:13px;padding:5px;background-color:grey;color:white;border-radius:10px;width:75px;text-align:center;'>N/A</span>";
                        }
                        //priorité de la tache
                        if ($row["priority"] == "LOW"){
                            $priority = "<span style='font-family:Roboto;font-size:13px;padding:5px;background-color:gold;color:white;border-radius:10px;width:75px;text-align:center;'>BASSE</span>";
                        }else if ($row["priority"] == "MEDIUM"){
                            $priority = "<span style='font-family:Roboto;font-size:13px;padding:5px;background-color:orange;color:white;border-radius:10px;width:75px;text-align:center;'>MOYENNE</span>";
                        }else if ($row["priority"] == "HIGH"){
                            $priority = "<span style='font-family:Roboto;font-size:13px;padding:5px;background-color:red;color:white;border-radius:10px;width:75px;text-align:center;'>HAUTE</span>";
                        } else {
                            $priority = "<span style='font-family:Roboto;font-size:13px;padding:5px;background-color:grey;color:white;border-radius:10px;width:75px;text-align:center;'>N/D</span>";
                        }
						$html .= "<tr onclick='getTASK(".$row["id"].")'><td>" . substr($row["date_start"],11,5)  . "</td><td>" . substr($row["end_date"],11,5)  . "</td><td style='white-space: pre-line;'>".  $row["name"]  . "</td><td>".$status."</td><td>".$priority."</td></tr>";
					}
				} else {
                    $html .= "<tr><td colspan=5>Aucunes tâches prévus.</td></tr>";
                }
$html .= "</table><br><canvas id='task_chart' style='position:relative;display:inline-block;width:300px;height:300px;background:#". $CIE_COLOR3 ."' width=\"300\" height=\"300\"></canvas>";
//progression chart    
$sql = "SELECT status, COUNT(*) as pourcent_done FROM event 
			WHERE user_id = '" . $currentUSER . "' AND event_type = 'TASK' AND YEAR(date_start) = '" . $year . "' AND MONTH(date_start) = '" . $month . "'  AND DAY(date_start) = '" . $day . "' 
                OR user_id = '" . $currentUSER . "' AND event_type = 'TASK' AND YEAR(end_date) = '" . $year . "' AND MONTH(end_date) = '" . $month . "'  AND DAY(end_date) = '" . $day . "' 
			GROUP BY status ORDER BY status";  
            //echo $sql;                  
    $result = mysqli_query($dw3_conn, $sql);
    $numResults = $result->num_rows;
    $counter = 0;
    $var_label = "";
    $var_data = "";
    $var_colors = "";
    date_default_timezone_set('America/New_York');
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $var_data .= $row["pourcent_done"];
            if ($row["status"] == "TO_DO") {$var_colors .= 'rgba(0,0,0,0.5)'; $var_label .= 'À faire';}
            else if ($row["status"] == "IN_PROGRESS") {$var_colors .= 'rgba(64, 224, 208,0.5)'; $var_label .= 'En cours';}
            else if ($row["status"] == "DONE") {$var_colors .= 'rgba(0,128,0,0.5)'; $var_label .= 'Terminé';}
            else {$var_colors .= 'rgba(0,0,0,0.3)'; $var_label .= 'N/A';}
            if (++$counter == $numResults) {
            // last row
                    //echo "";
            } else {
            // not last row
                    $var_label .= ",";
                    $var_data .= ",";
                    $var_colors .= ";";
            }
        }
    }
    $html .= "<input type='text' id='var_label' value=\"" . $var_label . "\" style='display:none;'>";
    $html .= "<input type='text' id='var_data' value=\"" . $var_data. "\" style='display:none;'>";
    $html .= "<input type='text' id='var_colors' value=\"" . $var_colors. "\" style='display:none;'>";

//lines
$html .= "<h2 style='text-align:left;'>Rendez-vous prévus</h2>";
$sql = "SELECT A.id as schedule_id, A.is_link_sent as is_link_sent, A.location_type as location_type, A.commentaire as comment, A.user_id as user_id,CONCAT(D.first_name, ' ',D.last_name) as user_name, A.customer_id, CONCAT(B.first_name, ' ',B.middle_name, ' ',B.last_name) as customer_name, A.product_id, C.name_fr as product_name,C.price1 as product_price,C.service_length as service_length,C.inter_length as inter_length, A.start_date as start_date, A.end_date as end_date, A.confirmed as confirmed
            FROM schedule_line A
            LEFT JOIN customer B ON B.id = A.customer_id
            LEFT JOIN product C ON C.id = A.product_id
            LEFT JOIN user D ON C.id = A.user_id
			WHERE A.user_id = '" . $currentUSER . "' AND YEAR(start_date) = '" . $year . "' AND MONTH(start_date) = '" . $month . "'  AND DAY(start_date) = '" . $day . "' 
                OR A.user_id = '" . $currentUSER . "' AND YEAR(end_date) = '" . $year . "' AND MONTH(end_date) = '" . $month . "'  AND DAY(end_date) = '" . $day . "' 
			ORDER  BY A.start_date";
$html .= "<table class='tblSEL'><tr><th width='75'>Début</th><th width='75'>Fin</th><th width='*'>Client - Produit/Service</th><th>Type</th><th width='50'>Conf.</th></tr>";
				$result = $dw3_conn->query($sql);
				if ($result->num_rows > 0) {	
					while($row = $result->fetch_assoc()) {
                        if ($row["location_type"] == "V"){ $loc_type = "Rencontre virtuelle"; }
                        else if ($row["location_type"] == "R"){$loc_type = "Chez le client";}
                        else if ($row["location_type"] == "L" || $row["location_type"] == "L0"){$loc_type = "Dans nos locaux";}
                        else if ($row["location_type"] == "P"){$loc_type = "Au téléphone";}
                        else {$loc_type = "ND";}
                        if ($row["confirmed"] == "1"){$confirmed = "<span class='dw3_font'>Ē</span>";}else{$confirmed = "<span class='dw3_font'>ē</span>";}
						$html .= "<tr onclick='getLINE(".$row["schedule_id"].")'><td>" . substr($row["start_date"],11,5)  . "</td><td>" . substr($row["end_date"],11,5)  . "</td><td style='white-space: pre-line;'>". dw3_decrypt($row["customer_name"]) ."-" .  $row["product_name"]  . "</td><td>".$loc_type."</td><td>".$confirmed."</td></tr>";
					}
				} else {
                    $html .= "<tr><td colspan=5>Aucuns rendez-vous prévus.</td></tr>";
                }
$html .= "</table><br>";

if ($is_dispo){
    //dispo
    $html .= "<h2 style='text-align:left;'>Ajouter un rendez-vous</h2><div class='divBOX' style='max-width:767px;text-align:center;'>
    <div style='width:95%;text-align:left;'>Type du lieu:</div>
    <div class='dw3_box' style='width:200px;vertical-align:middle;margin:5px;text-align:left;'><input style='cursor:pointer;vertical-align:middle;' name='service_type' id='service_type_V' type='radio' value='V'> <label for='service_type_V' style='cursor:pointer;width:175px;overflow:hidden;vertical-align:middle;'> Rencontre virtuelle</label></div>
    <div class='dw3_box' style='width:200px;vertical-align:middle;margin:5px;text-align:left;'><input style='cursor:pointer;vertical-align:middle;' name='service_type' id='service_type_R' type='radio' value='R'> <label for='service_type_R' style='cursor:pointer;width:175px;overflow:hidden;vertical-align:middle;'> À votre domicile</label></div>
    <div class='dw3_box' style='width:200px;vertical-align:middle;margin:5px;text-align:left;'><input style='cursor:pointer;vertical-align:middle;' name='service_type' id='service_type_L' type='radio' value='L' checked> <label for='service_type_L' style='cursor:pointer;width:175px;overflow:hidden;vertical-align:middle;'> Dans nos locaux</label></div>
    <div class='dw3_box' style='width:200px;vertical-align:middle;margin:5px;text-align:left;'><input style='cursor:pointer;vertical-align:middle;' name='service_type' id='service_type_P' type='radio' value='P'> <label for='service_type_P' style='cursor:pointer;width:175px;overflow:hidden;vertical-align:middle;'> Au téléphone</label></div>
    <div style='width:95%;text-align:left;'>Produits & Services:</div>";

    $sql2 = "SELECT *
    FROM product
    WHERE web_dsp= '1' AND is_scheduled = '1' AND stat=0 LIMIT 100";
        $result2 = $dw3_conn->query($sql2);
        if ($result2->num_rows > 0) {	
            while($row2 = $result2->fetch_assoc()) {
                $filenames = []; //asort(dw3_dir_to_array($_SERVER['DOCUMENT_ROOT'] ."/product/" .$row["id"] . "/"));
                $folder=scandir($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" .$row2["id"] . "/");
                foreach($folder as $file) {
                    if (!is_dir($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $file) && $file != "." && $file != ".."){
                        $filenames[] = $file;
                    }
                }
                $filename= $row2["url_img"];
                if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row2["id"] . "/" . $filename)){
                    $filename = "/pub/img/nd.png";
                } else {
                    if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row2["id"] . "/" . $filename)){
                        $filename = "/pub/img/nd.png";
                    }else{
                        $filename = "/fs/product/" . $row2["id"] . "/" . $filename;
                    }
                }
                $html .= "<div class='dw3_box' onmouseup=\"dw3_set_dispo('".floor($row2["service_length"]+$row2["inter_length"])."','".$row2["description_fr"]."')\" style='width:auto;padding:10px;min-height:50px;text-align:center;'><input style='cursor:pointer;vertical-align:top;margin-top:10px;' name='prd' id='product_".$row2["id"]."' type='radio' value='".$row2["id"]."'><label for='product_".$row2["id"]."' style='cursor:pointer;padding-top:0px;'> <img src='".$filename."' style='width:150px;height:auto;border-radius:4px;'><br>".$row2["name_fr"]."<br><span style='font-size:0.7em'>".$row2["service_length"]." minutes <sup>+".$row2["inter_length"]."</sup></span></label></div>";
            }
        }

    $html .= "</div><br>
    <div class='divBOX' style='max-width:767px;text-align:center;'><button onclick='getDISPO()'>Vérifier les disponibilités</button><div id='divDISPO'><div style='width:95%;text-align:left;'>Disponibilités.</div><br><small>Veuillez d'abord choisir un service</small></div></div>";

    //clients
    $html .= "<br><div class='divBOX' style='max-width:767px;text-align:center;'><div style='width:95%;text-align:left;'>Clients:</div>
            <input id='selCLI' onchange='getCLIS(\"\");' type='search' style='width:55%;' autocorrect='off' spellcheck='false' autocomplete='off'  placeholder='" . $dw3_lbl["RECH"]."' title='". $dw3_lbl["RECH"]."'>
            <br><input style='display:none;' id='newCLI' type='text'>
            <div id='divCLI' style='margin:10px;max-height:75%;'>		
                Type in search box to find a customer.
            </div><br><div id='divCONFIRM'> </div><button id='btnNEW' onclick='addRDV();'><span class='material-icons'>event_available</span> Ajouter le rendez-vous</button><br><small>Les rendez-vous ajoutés ici seront automatiquement considérés comme confirmés.</small></div><br>";

            $html .= "<br>"; 
} else {
    $html .= "<h2 style='text-align:left;'>Ajoutez un rendez-vous</h2><div class='divBOX' style='max-width:767px;text-align:center;'><div style='width:95%;text-align:left;'>Vous devez d'abord ajouter une plage horaire pour cette journée afin de pouvoir ajouter un rendez-vous.</div></div><br>";
}
$dw3_conn->close();
die($html);

?>