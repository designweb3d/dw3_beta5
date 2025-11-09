<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/js/Multiavatar.php';
$multiavatar = new Multiavatar();
$usID  = $_GET['usID'];

	$sql = "SELECT * FROM user WHERE id = " . $usID . " LIMIT 1";
	$result = $dw3_conn->query($sql);
    $html = "";
	if ($result->num_rows > 0) {		
		while($row = $result->fetch_assoc()) {

            $can_user_mod = true;
            if ($USER_AUTH != "USR" && $USER_AUTH != "ADM" && $USER_AUTH != "GES"){$can_user_mod = false;}
            if ($USER_AUTH == "ADM" && $row["auth"] == "GES"){$can_user_mod = false;}
            if (($USER_AUTH == "USR" && $row["auth"] == "GES") || ($USER_AUTH == "USR" && $row["auth"] == "ADM")){$can_user_mod = false;} 

            if ($can_user_mod == false){
                $dw3_conn->close();
                die("Erreur: Vous ne disposez pas de l'autorité necessaire pour modifier cet utilisateur.");
            }

            $avatarsvg = $multiavatar($row["name"], null, null);
			$html .= "
            <div id='divEDIT_HEADER' class='dw3_form_head'>                        
                <span style='font-size:0.8em;position:absolute;top:5px;left:15px;background:#" .$CIE_COLOR2 . ";border-radius:6px;padding:3px;'>";
            if 	($row["stat"] =="0"){ $html .= " <b style='color:green;'>(ACTIF)</b>"; }
            if 	($row["stat"] =="1"){ $html .= " <b style='color:yellow;'>(INACTIF)</b>"; }
            if 	($row["stat"] =="2"){ $html .= " <b style='color:red;'>(SUSPENDU)</b>"; }
    $html .= " </span> 
                <h3>". $row["prefix"] ." ". $row["first_name"] ." ". $row["middle_name"] ."". $row["last_name"] ."". $row["suffix"] ."</h3>
            <button class='grey' style='top:0px;right:0px;padding:4px;position:absolute;' onclick='closeEDITOR(this);'><span class='material-icons'>close</span></button>
            </div>
            <div style='position:absolute;top:40px;left:0px;bottom:50px;overflow-x:hidden;overflow-y:auto;'>";
            //$html .= "<div id='imgAVATAR' style='width:50%;max-width:300px;display: inline-block;'>" . $avatarsvg . "</div>";
            if ($row["picture_type"] == "AVATAR"){
                $avatarsvg = $multiavatar($row["name"], null, null);
                $html .=  "<div id='imgAVATAR3' style='width:250px;height:250px;border-radius:4px;display: inline-block;vertical-align:middle;'>" . $avatarsvg . "</div>";
            } else if ($row["picture_type"] == "PHOTO"){
                $html .=  "<img src='/fs/user/" . $row["id"] . ".png?t=".rand(1,9999999)."' style='width:250px;height:auto;border-radius:4px;display: inline-block;' />";
            } else if ($row["picture_type"] == "PICTURE"){
                $html .=  "<img src='/pub/upload/" . $row["picture_url"] . "?t=".rand(1,9999999)."' style='width:250px;height:auto;border-radius:4px;display: inline-block;' />";
            } else if ($row["picture_type"] == "PICTURE2"){
                $html .=  "<img src='/pub/img/avatar/" . $row["picture_url"] . "?t=".rand(1,9999999)."' style='width:250px;height:auto;border-radius:4px;display: inline-block;' />";
            }
			$html .= "<br>
				<input id='usID' type='text' style='display:none;' value='" . $row["id"] . "'>
				<div class='divBOX'>
					Status:
					<label class='switch' style='float:right;'>
					  <input id='usSTAT' type='checkbox' "; if 	($row["stat"] =="0"){ $html .= " checked"; } $html .= ">
					  <span class='slider round'></span>
					</label>
				</div>					
				<div class='divBOX'>Nom d'utilisateur:
					<input id='usNAME' oninput='dw3_avatar_change(this.value,\"imgAVATAR3\")' type='text' value='" . htmlspecialchars($row["name"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
				</div><hr>
				<div class='divBOX'>" . $dw3_lbl["PREFIX"] . ":
					<input id='usPREFIX' type='text' value='" . htmlspecialchars($row["prefix"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
				</div>
				<div class='divBOX'>" . $dw3_lbl["PRENOM"] . ":
					<input id='usPRENOM' type='text' value='" . htmlspecialchars($row["first_name"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
				</div>
				<div class='divBOX'>" . $dw3_lbl["PRENOM2"] . ":
					<input id='usPRENOM2' type='text' value='" . htmlspecialchars($row["middle_name"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
				</div>
				<div class='divBOX'>" . $dw3_lbl["NOM"] . ":
					<input id='usNOM' type='text' value='" . htmlspecialchars($row["last_name"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
				</div>
				<div class='divBOX'>" . $dw3_lbl["SUFFIX"] . ":
					<input id='usSUFFIX' type='text' value='" . htmlspecialchars($row["suffix"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
				</div>	
				<div class='divBOX'>Courriel personnel:
					<input id='usEML1' type='text' value='" . htmlspecialchars($row["eml1"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
					<span style='font-size:11px;'>Adresse personnelle, peut être la même que celle des API Google.</span>
                    <button style='font-size: 12px;' onclick='reinitPW_USR(\"" . $row["id"] . "\");'><span class='material-icons'>mail</span>Envoyer un courriel pour réinitialiser le mot de passe</button>
				</div>	
				<div class='divBOX'>Courriel GMail:
					<input id='usEML2' type='text' value='" . htmlspecialchars($row["eml2"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
					<span style='font-size:11px;'>Adresse réservée pour les API Google doit se terminer par @gmail.com</span>
				</div>				
				<div class='divBOX'>Courriel de compagnie:
					<input id='usEML3' type='text' value='" . htmlspecialchars($row["eml3"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
					<span style='font-size:11px;'>Adresse de la compagnie. Devrait se terminer par @".$_SERVER["SERVER_NAME"]."</span>
				</div>				
				<div class='divBOX'>" . $dw3_lbl["TEL1"] . ":
					<input id='usTEL1' type='text' value='" . $row["tel1"] . "' onclick='detectCLICK(event,this);'>
				</div>					
				<div class='divBOX'>" . $dw3_lbl["TEL2"] . ":
					<input id='usTEL2' type='text' value='" . $row["tel2"] . "' onclick='detectCLICK(event,this);'>
				</div>				
				<div class='divBOX'>" . $dw3_lbl["ADR1"] . ":
					<input id='usADR1' type='text' value='" . htmlspecialchars($row["adr1"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
				</div>				
				<div class='divBOX'>" . $dw3_lbl["ADR2"] . ":
					<input id='usADR2' type='text' value='" . htmlspecialchars($row["adr2"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
				</div>
				<div class='divBOX'>" . $dw3_lbl["VILLE"] . ":
					<input id='usVILLE' type='text' value='" . $row["city"] . "' onclick='detectCLICK(event,this);'>
				</div>
				<div class='divBOX'>" . $dw3_lbl["CP"] . ":
					<input id='usCP' type='text' value='" . $row["postal_code"] . "' onclick='detectCLICK(event,this);'>
				</div>
				<div class='divBOX'>" . $dw3_lbl["PROV"] . ":						
						<select name='usPROV' id='usPROV'>
							<option value='QC'"; if 	($row["province"] =="QC"){ $html .= " selected"; } $html .= ">Québec</option>
							<option value='ON'"; if 	($row["province"] =="ON"){ $html .= " selected"; } $html .= ">Ontario</option>
							<option value='AB'"; if 	($row["province"] =="AB"){ $html .= " selected"; } $html .= ">Alberta</option>
							<option value='BC'"; if 	($row["province"] =="BC"){ $html .= " selected"; } $html .= ">Colombie-Britannique</option>
							<option value='PE'"; if 	($row["province"] =="PE"){ $html .= " selected"; } $html .= ">l'Île-du-Prince-Édouard</option>
							<option value='MB'"; if 	($row["province"] =="MB"){ $html .= " selected"; } $html .= ">Manitoba</option>
							<option value='NB'"; if 	($row["province"] =="NB"){ $html .= " selected"; } $html .= ">Nouveau-Brunswick</option>
							<option value='NS'"; if 	($row["province"] =="NS"){ $html .= " selected"; } $html .= ">Nouvelle-Écosse</option>
							<option value='SK'"; if 	($row["province"] =="SK"){ $html .= " selected"; } $html .= ">Saskatchewan </option>
							<option value='NF'"; if 	($row["province"] =="NF"){ $html .= " selected"; } $html .= ">Terre-Neuve-et-Labrador</option>
						</select>
				</div>
				<div class='divBOX'>" . $dw3_lbl["PAYS"] . ":
					<input id='usPAYS' type='text' value='" . $row["country"] . "' onclick='detectCLICK(event,this);'>
				</div>
				<div class='divBOX'>Timezone:						
                    <select name='usTZ' id='usTZ'>
                        <option value='-12:00'"; if 	($row["timezone_offset"] =="-12:00"){ $html .= " selected"; } $html .= ">Etc/GMT+12</option>
                        <option value='-11:00'"; if 	($row["timezone_offset"] =="-11:00"){ $html .= " selected"; } $html .= ">Pacific/Midway</option>
                        <option value='-10:00'"; if 	($row["timezone_offset"] =="-10:00"){ $html .= " selected"; } $html .= ">Pacific/Honolulu</option>
                        <option value='-09:30'"; if 	($row["timezone_offset"] =="-09:30"){ $html .= " selected"; } $html .= ">Pacific/Marquesas</option>
                        <option value='-09:00'"; if 	($row["timezone_offset"] =="-09:00"){ $html .= " selected"; } $html .= ">America/Hawaii</option>
                        <option value='-08:00'"; if 	($row["timezone_offset"] =="-08:00"){ $html .= " selected"; } $html .= ">America/Anchorage</option>
                        <option value='-07:00'"; if 	($row["timezone_offset"] =="-07:00"){ $html .= " selected"; } $html .= ">America/Vancouver</option>
                        <option value='-06:00'"; if 	($row["timezone_offset"] =="-06:00"){ $html .= " selected"; } $html .= ">America/Edmonton</option>
                        <option value='-05:00'"; if 	($row["timezone_offset"] =="-05:00"){ $html .= " selected"; } $html .= ">America/Winnipeg</option>
                        <option value='-04:00'"; if 	($row["timezone_offset"] =="-04:00"){ $html .= " selected"; } $html .= ">America/Toronto</option>
                        <option value='-03:30'"; if 	($row["timezone_offset"] =="-03:30"){ $html .= " selected"; } $html .= ">America/St_Johns</option>
                        <option value='-03:00'"; if 	($row["timezone_offset"] =="-03:00"){ $html .= " selected"; } $html .= ">America/Halifax</option>
                        <option value='-02:00'"; if 	($row["timezone_offset"] =="-02:00"){ $html .= " selected"; } $html .= ">America/Nuuk</option>
                        <option value='-01:00'"; if 	($row["timezone_offset"] =="-01:00"){ $html .= " selected"; } $html .= ">Atlantic/Cape_Verde</option>
                        <option value='+00:00'"; if 	($row["timezone_offset"] =="+00:00"){ $html .= " selected"; } $html .= ">UTC</option>
                        <option value='+01:00'"; if 	($row["timezone_offset"] =="+01:00"){ $html .= " selected"; } $html .= ">Europe/Amsterdam</option>
                        <option value='+02:00'"; if 	($row["timezone_offset"] =="+02:00"){ $html .= " selected"; } $html .= ">Europe/Athens</option>
                        <option value='+03:00'"; if 	($row["timezone_offset"] =="+03:00"){ $html .= " selected"; } $html .= ">Europe/Istanbul</option>
                        <option value='+03:30'"; if 	($row["timezone_offset"] =="+03:30"){ $html .= " selected"; } $html .= ">Asia/Tehran</option>
                        <option value='+04:00'"; if 	($row["timezone_offset"] =="+04:00"){ $html .= " selected"; } $html .= ">Asia/Dubai</option>
                        <option value='+04:30'"; if 	($row["timezone_offset"] =="+04:30"){ $html .= " selected"; } $html .= ">Asia/Kabul</option>
                        <option value='+05:00'"; if 	($row["timezone_offset"] =="+05:00"){ $html .= " selected"; } $html .= ">Asia/Ashkhabad</option>
                        <option value='+05:30'"; if 	($row["timezone_offset"] =="+05:30"){ $html .= " selected"; } $html .= ">Asia/Colombo</option>
                        <option value='+06:00'"; if 	($row["timezone_offset"] =="+06:00"){ $html .= " selected"; } $html .= ">Asia/Omsk</option>
                        <option value='+06:30'"; if 	($row["timezone_offset"] =="+06:30"){ $html .= " selected"; } $html .= ">Asia/Rangoon</option>
                        <option value='+07:00'"; if 	($row["timezone_offset"] =="+07:00"){ $html .= " selected"; } $html .= ">Indian/Christmas</option>
                        <option value='+08:00'"; if 	($row["timezone_offset"] =="+08:00"){ $html .= " selected"; } $html .= ">Asia/Hong_Kong</option>
                        <option value='+09:00'"; if 	($row["timezone_offset"] =="+09:00"){ $html .= " selected"; } $html .= ">Asia/Tokyo</option>
                        <option value='+09:30'"; if 	($row["timezone_offset"] =="+09:30"){ $html .= " selected"; } $html .= ">Australia/Darwin</option>
                        <option value='+10:00'"; if 	($row["timezone_offset"] =="+10:00"){ $html .= " selected"; } $html .= ">Australia/Sydney</option>
                        <option value='+10:30'"; if 	($row["timezone_offset"] =="+10:30"){ $html .= " selected"; } $html .= ">Australia/Lord_Howe</option>
                        <option value='+11:00'"; if 	($row["timezone_offset"] =="+11:00"){ $html .= " selected"; } $html .= ">Pacific/Guadalcanal</option>
                        <option value='+12:00'"; if 	($row["timezone_offset"] =="+12:00"){ $html .= " selected"; } $html .= ">Pacific/Tarawa</option>
                    </select>
				</div>
                <div class='divBOX'>Durée d'inactivité avant déconnexion:
					<input id='usINACTIVE' type='number' value='" . $row["inactive_minutes"] . "' onclick='detectCLICK(event,this);'>
				</div><hr>
				<div class='divBOX'>Taux horaire:
					<input id='usSALARY' type='number' value='" . $row["salary"] . "' onclick='detectCLICK(event,this);'>
				</div><hr>
				<div class='divBOX'>" . $dw3_lbl["LANG"] . ":
					  <select name='usLANG' id='usLANG'>
						<option"; if 	($row["lang"] =="FR"){ $html .= " selected"; } $html .= " value='FR'>" . $dw3_lbl["FR"] . "</option>
						<option"; if 	($row["lang"] =="EN"){ $html .= " selected"; } $html .= " value='EN'>" . $dw3_lbl["EN"] . "</option>
					  </select>
				</div>
				<div class='divBOX'>" . $dw3_lbl["LOC"] . ":"; 
						$sql2 ="SELECT *
								FROM location
								ORDER BY name";

						$result2 = $dw3_conn->query($sql2);
						$html .= "<select id='usLOC'>";
						if ($result2->num_rows > 0) {		
							while($row2 = $result2->fetch_assoc()) {
								$ISSELECTED = " ";
								if ($row2["id"] == $row["location_id"]){ $ISSELECTED = " selected ";}
								$html .= "<option " . $ISSELECTED . " value=" . $row2["id"] .">". $row2["name"] . "</option>";
							}
						} 
						$html .= "</select>";
				$html .= "</div>
				<div class='divBOX'>Position:"; 
						$sql2 ="SELECT *
								FROM position
								ORDER BY name";

						$result2 = $dw3_conn->query($sql2);
						$html .= "<select id='usPOS'>";
						if ($result2->num_rows > 0) {		
							while($row2 = $result2->fetch_assoc()) {
								$ISSELECTED = " ";
								if ($row2["id"] == $row["position_id"]){ $ISSELECTED = " selected ";}
								$html .= "<option " . $ISSELECTED . " value=" . $row2["id"] .">". $row2["name"] . "</option>";
							}
						} 
						$html .= "</select>";
				$html .= "</div>
                <div class='divBOX'>" . $dw3_lbl["TYPE"] . ":
                    <select name='usAUTH' id='usAUTH'>";
                    $html .= "<option "; if ($USER_AUTH !="GES"){$html .= " disabled"; } if 	($row["auth"] =="GES"){ $html .= " selected"; } $html .= " value='GES'>" . $dw3_lbl["GES"] . " (GES)</option>";
                    $html .= "<option "; if ($row["auth"] =="ADM"){$html .= " selected"; } $html .= " value='ADM'>" . $dw3_lbl["ADM"] . " (ADM)</option>
                    <option "; if 	($row["auth"] =="USR"){ $html .= " selected"; } $html .= " value='USR'>" . $dw3_lbl["USR"] . " (USR)</option>
                    <option "; if 	($row["auth"] =="AUD"){ $html .= " selected"; } $html .= " value='AUD'>Auditeur (AUD)</option>
                    <option "; if 	($row["auth"] =="MIA"){ $html .= " selected"; } $html .= " value='MIA'>Master IA (MIA)</option>
                    <option "; if 	($row["auth"] =="BOT"){ $html .= " selected"; } $html .= " value='BOT'>Robot (BOT)</option>
                    <option "; if 	($row["auth"] =="VST"){ $html .= " selected"; } $html .= " value='VST'>Visiteur (VST)</option>
                    </select>
                </div><hr>";
	
				$html .= "<div class='divBOX' style='width:95%;max-width:95%;'>Applications disponibles pour cet utilisateur:
					  <div id='divUSAP'>"; 
						$sql2 ="SELECT *
								FROM app_user
								LEFT JOIN app on app_user.app_id = app.id
								WHERE user_id = '" . $row["id"] . "'
								ORDER BY name_fr ASC";

                        $result2 = $dw3_conn->query($sql2);
                        if ($result2->num_rows > 0) {	
                            if ($APREAD_ONLY == false) {		
                                $html .=  "<table class='tblSEL'><tr><th style='font-size: 12px;'>Read<br>Only</th><th>Application</th></tr>";
                            } else {
                                $html .=  "<table class='tblDATA'><tr><th style='font-size: 12px;'>Read<br>Only</th><th>Application</th></tr>";
                            }
                            while($row2 = $result2->fetch_assoc()) {
                                if ($row2["app_id"] == "1" || $row2["app_id"] == "3" || $row2["app_id"] == "5" || $row2["app_id"] == "12" || $row2["app_id"] == "14" || $row2["app_id"] == "16" || $row2["app_id"] == "17" || $row2["app_id"] == "18" || $row2["app_id"] == "19" || $row2["app_id"] == "20" || $row2["app_id"] == "21" || $row2["app_id"] == "22" || $row2["app_id"] == "23" || $row2["app_id"] == "29" || $row2["app_id"] == "33") {
                                    $dsp_ro = "display:none;";
                                    $dsp_ro2 = "<span style='border:2px solid black;border-radius:3px;background:#fff;color:#333;font-size:12px;'>N/A</span>";
                                } else {
                                    $dsp_ro = "";
                                    $dsp_ro2 = "";
                                }
                                if ($APREAD_ONLY == false) {
                                    $html .=  "<tr><td width='20px;'>".$dsp_ro2."<input style='".$dsp_ro."' type='checkbox' ".($row2["read_only"] == "1" ? "checked" : "")." onclick=\"changeUSAPAuth('". $row2["user_id"] . "','". $row2["app_id"] . "',this.checked)\"></td><td style='cursor: zoom-out;' onclick=\"delUSAP('". $row2["user_id"] . "','". $row2["app_id"] . "')\"><span class='material-icons'>". $row2["icon"] . "</span> <b> ". $row2["name_fr"] ."</b>". " (". $row2["auth"] . ")</td></tr>";
                                } else {
                                    $html .=  "<tr><td width='20px;'>".$dsp_ro2."<input style='".$dsp_ro."' disabled type='checkbox' ".($row2["read_only"] == "1" ? "checked" : "")."></td><td><span class='material-icons'>". $row2["icon"] . "</span> <b> ". $row2["name_fr"] ."</b>". " (". $row2["auth"] . ")</td></tr>";
                                }
                            }
                            $html .=  "</table>";
                        } else { $html .= "<small> -> " . $dw3_lbl["APLC_NOTFOUND"] . "</small>"; }

				$html .= "</div>-<hr>+					
					<div id='divUSAP_REV'>Applications bloqués pour cet utilisateur:"; 
						$sql2 ="SELECT *
								FROM app
								WHERE id NOT IN 
									(SELECT app_id from app_user where user_id = " . $row["id"] . ")
                                    AND id <> 29
                                    AND id <> 26
								ORDER BY name_fr ASC";

						$result2 = $dw3_conn->query($sql2);
						if ($result2->num_rows > 0) {	
                            if ($APREAD_ONLY == false) {	
							    $html .= "<table class='tblSEL'>";
                            } else {
                                $html .= "<table class='tblDATA'>";
                            }
							while($row2 = $result2->fetch_assoc()) {
                                if ($APREAD_ONLY == false) {
								    $html .= "<tr style='cursor: zoom-in;' onclick='addUSAP(\"". $row["id"] . "\",\"". $row2["id"] . "\")'><td><span class='material-icons'>". $row2["icon"] . "</span> <b> ". $row2["name_fr"] ."</b>". " (". $row2["auth"] . ")</td></tr>";
                                } else {
                                    $html .= "<tr><td><span class='material-icons'>". $row2["icon"] . "</span> <b> ". $row2["name_fr"] ."</b>". " (". $row2["auth"] . ")</td></tr>";
                                }
							}
							$html .= "</table>";
						} else { $html .= "<small> -> " . $dw3_lbl["APLC_COMPLETE"] . "</small>"; }

				$html .= "</div></div>";
                $html .= "<div class='divBOX'>" . $dw3_lbl["APLC_DFT"] . " :"; 
                $sql2 ="SELECT *
                        FROM app_user
                        LEFT JOIN app on app_user.app_id = app.id
                        WHERE user_id = '" . $row["id"] . "'
                        ORDER BY sort_number";

                $result2 = $dw3_conn->query($sql2);
                $html .= "<select id='usAPLC'>";
                if ($result2->num_rows > 0) {		
                    while($row2 = $result2->fetch_assoc()) {
                        $ISSELECTED = " ";
                        if ($row2["app_id"] == $row["app_id"]){ $ISSELECTED = " selected ";}
                        $html .= "<option " . $ISSELECTED . " value=" . $row2["app_id"] .">". $row2["name_fr"] . "</option>";
                    }
                } else { $html .= "<option value='0'>" . $dw3_lbl["APLC_NOTFOUND"] . "</option>"; }
                $html .= "</select>";
                $html .= "</div><br>				
                <div class='divBOX'>Services appliqués:"; 
                $sql2 ="SELECT A.id AS pr_id, A.name_fr AS name_fr, IFNULL(B.is_public,-1) as service_is_public FROM product A
                        LEFT JOIN (SELECT * FROM user_service where user_id = '" . $row["id"] . "') B ON A.id = B.product_id
                        WHERE is_scheduled = 1 and stat = 0
                        ORDER BY name_fr";
                $result2 = $dw3_conn->query($sql2);
                if ($result2->num_rows > 0) {		
                    while($row2 = $result2->fetch_assoc()) {
                        $ISSELECTED = " ";
                        if ($row2["service_is_public"] != "-1"){ $ISSELECTED = " checked ";}
                        $html .= "<div style='width:100%;'><input onclick=\"updUSER_SERVICE(this,'" . $row["id"] . "','" . $row2["pr_id"] ."');\" id='user_service" . $row2["pr_id"] ."' type='checkbox' " . $ISSELECTED . "> <label for='user_service" . $row2["pr_id"] ."'> ". $row2["name_fr"] . "</label></div>";
                    }
                }else {
					$html .= "<div style='width:100%;'>Aucun produit avec l'option 'Service au taux horaire accessible au publique' activée.</div>";
				} 
        $html .= "</div><br>
        <div class='divBOX'>
            Recevoir un SMS lors de la prise de rendez-vous:
            <label class='switch' style='float:right;'>
            <input id='usSMS_RDV' type='checkbox' "; if 	($row["sms_rdv"] =="1"){ $html .= " checked"; } $html .= ">
            <span class='slider round'></span>
            </label>
        </div>	<br>
        <span style='font-size:0.9em;width:100%;max-width:600px;text-align:left;'>Message additionel envoyé au client lors de la prise de rendez-vous :</span>
        <textarea id='usMSG_RDV' onfocus='active_input=this.id;' style='height:200px;width:100%;max-width:600px;'>".str_replace("<br />","\n",str_replace("<br/>","\n",str_replace("<br>","\n",$row["msg_rdv"])))."</textarea><br>
                    ";
					$html .=  "
					<div id='divCharPERSO' style='display:inline-block;overflow-y:auto;overflow-x:hidden;height:150px;width:100%;vertical-align:middle;text-align:center;'>
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
                $html .=  "</div>
				</div>";				
				$html .= "<div id='divEDIT_FOOT' style='padding:3px;background:rgba(200, 200, 200, 0.7);'>";
                             if ($APREAD_ONLY == false) {$html .= "<button class='red' onclick='delUSER(\"" . $row["id"] . "\");'><span class='material-icons'>delete</span></button>";}
                             $html .= "<button class='grey' onclick='closeEDITOR();'><span class='material-icons'>cancel</span>" . $dw3_lbl["CLOSE"] . "</button>";
                             if ($APREAD_ONLY == false) {$html .= "<button class='green' onclick='updUSER(\"" . $row["id"] . "\");'><span class='material-icons'>save</span>" . $dw3_lbl["SAVE"] . "</button>";}
                          $html .= "</div>";
		}
	}
$dw3_conn->close();
die($html);
?>