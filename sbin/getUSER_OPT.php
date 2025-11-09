<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/js/Multiavatar.php';
$multiavatar = new Multiavatar();
$avatarsvg = $multiavatar($USER_NAME, null, null);
$html="";
	$sql = "SELECT *
			FROM user 
			WHERE id = " . $USER . "
			LIMIT 1";

	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {		
		while($row = $result->fetch_assoc()) {
			//echo "<img id='imgAVATAR' src='https://api.multiavatar.com/" . $row["usUSER"]  . ".png' style='width:200px;height:auto;'>";
			$html .= "<div id='divOPT_HEADER' class='dw3_form_head'>
                        <h2>Options</h2>
                        <button  class='dw3_form_close' onclick='closeOPT();'><span class='material-icons'>close</span></button>
                    </div><div  class='dw3_form_data'>";
			if ($row["picture_type"] == "AVATAR"){
				$html .= "<div id='divAVATAR' style='width:100%;text-align:center;'><a href='https://multiavatar.com/' target='_blank'><div id='imgAVATAR' style='width:50%;display: inline-block;'>" . $avatarsvg . "</div></a></div>";
				$html .= "<div id='divPHOTO' style='width:100%;text-align:center;display:none;'><div id='opt_camera'><video id='opt_video'>Caméra non disponible.</video><button id='opt_startbutton'><span class='material-icons'>photo_camera</span></button></div><canvas id='opt_canvas'> </canvas><div id='opt_output'><img id='opt_photo' src='/pub/img/load/".$CIE_LOAD."' /></div></div><hr>";
			} else if ($row["picture_type"] == "PHOTO"){
				$html .= "<div id='divAVATAR' style='width:100%;text-align:center;display:none;'><a href='https://multiavatar.com/' target='_blank'><div id='imgAVATAR' style='width:50%;display: inline-block;'>" . $avatarsvg . "</div></a></div>";
				$html .= "<div id='divPHOTO' style='width:100%;text-align:center;'><div id='opt_camera'><video id='opt_video'>Caméra non disponible.</video><button id='opt_startbutton'><span class='material-icons'>photo_camera</span></button></div><canvas id='opt_canvas'> </canvas><div id='opt_output'><img id='opt_photo' src='/fs/user/" . $row["id"] . ".png?t=".rand(1,9999999)."' /></div></div><hr>";
			} else if ($row["picture_type"] == "PICTURE"){
				$html .= "<div id='divAVATAR' style='width:100%;text-align:center;display:none;'><a href='https://multiavatar.com/' target='_blank'><div id='imgAVATAR' style='width:50%;display: inline-block;'>" . $avatarsvg . "</div></a></div>";
				$html .= "<div id='divPHOTO' style='width:100%;text-align:center;'><div id='opt_camera'><video id='opt_video'>Caméra non disponible.</video><button id='opt_startbutton'><span class='material-icons'>photo_camera</span></button></div><canvas id='opt_canvas'> </canvas><div id='opt_output'><img id='opt_photo' src='/pub/upload/" . $row["picture_url"] . "?t=".rand(1,9999999)."' /></div></div><hr>";
			} else if ($row["picture_type"] == "PICTURE2"){
				$html .= "<div id='divAVATAR' style='width:100%;text-align:center;display:none;'><a href='https://multiavatar.com/' target='_blank'><div id='imgAVATAR' style='width:50%;display: inline-block;'>" . $avatarsvg . "</div></a></div>";
				$html .= "<div id='divPHOTO' style='width:100%;text-align:center;'><div id='opt_camera'><video id='opt_video'>Caméra non disponible.</video><button id='opt_startbutton'><span class='material-icons'>photo_camera</span></button></div><canvas id='opt_canvas'> </canvas><div id='opt_output'><img id='opt_photo' src='/pub/img/avatar/" . $row["picture_url"] . "?t=".rand(1,9999999)."' /></div></div><hr>";
			}				
			$html .= htmlspecialchars($row["first_name"]) . " " . htmlspecialchars($row["last_name"]) . "
            <button style='background:#555555;top:0px;left:0px;padding:4px;position:absolute;width:85px;height:30px;overflow:hidden;' onclick='defaultAVATAR();'><span class='material-icons' style='font-size:17px;'>face</span> Avatar</button>
            <button style='background:#555555;top:30px;left:0px;padding:4px;position:absolute;width:85px;height:30px;overflow:hidden;' onclick='opt_open_cam();'><span class='material-icons' style='font-size:17px;'>photo_camera</span> Photo</button>
            <button style='background:#555555;top:60px;left:0px;padding:4px;position:absolute;width:85px;height:30px;overflow:hidden;' onclick=\"choosePICTURE('opt_photo');\"><span class='material-icons' style='font-size:17px;'>portrait</span> Upload</button>
            <button style='background:#555555;top:90px;left:0px;padding:4px;position:absolute;width:85px;height:30px;overflow:hidden;' onclick=\"choosePICTURE2('opt_photo');\"><span class='material-icons' style='font-size:17px;'>portrait</span> Image</button>
                <hr>
				<input id='usID_OPT' type='text' style='display:none;' value='" . $row["id"] . "'>				
				<div class='divBOX'>" . $dw3_lbl["USER"] . ":
					<input id='usUSER_OPT' onkeyup='dw3_avatar_change(this.value,\"imgAVATAR\");' type='text' value='" . htmlspecialchars($row["name"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
				</div>
				<div class='divBOX'>" . $dw3_lbl["PW"] . ":
					<input id='usPW_OPT' type='password' class='eye_on' value='" . htmlspecialchars($row["pw"], ENT_QUOTES) . "' onclick='showPW(event,this);'>
                </div>	
				<div class='divBOX'>" . $dw3_lbl["EML1"] . ":
					<input id='usEML1_OPT' type='text' value='" . htmlspecialchars($row["eml1"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
				</div>				
				<div class='divBOX'>Gmail:
					<input id='usEML2_OPT' type='text' value='" . htmlspecialchars($row["eml2"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
				</div>				
				<div class='divBOX'>Courriel de compagnie:
					<input id='usEML3_OPT' disabled type='text' value='" . htmlspecialchars($row["eml3"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
				</div>
                <button style='background: #444; color:#FFF;margin-top:0px;display:none;' onclick=\"dw3_mail_open('UNSEEN','" . $USER . "');\"><span class='material-icons'>mail</span> Lire les courriels</button>		
				<div class='divBOX'>" . $dw3_lbl["TEL1"] . ":
					<input id='usTEL1_OPT' type='text' value='" . $row["tel1"] . "' onclick='detectCLICK(event,this);'>
				</div>";

                $sig_path = $_SERVER['DOCUMENT_ROOT'] . "/fs/user/". $USER . "/signature.png";
                $sig_path_pub = "/fs/user/". $USER . "/signature.png";
                if (file_exists($sig_path)){
                    $RNDSEQ = rand(10,100000);
                    $html .=  "<div class='divBOX'>Signature<br>
                        <img id='user_signature_img' src='" . $sig_path_pub . "?t=" . $RNDSEQ . "' style='width:auto;max-width:335px;height:90px;'>
                        <canvas class='signature_pads' id='user_signature_pad' width='335' height='90' style=\"position:relative;display:none;  font-family: 'Imperial';font-style normal;font-weight: 400;font-size: 40px;\"></canvas><br>
                        <button type='button' id='user_signature_clear'><span class='material-icons'>cancel_presentation</span> <span> Effacer </span></button>
                        <button type='button' onclick=\"makeUSER_SIGNATURE('".str_replace("'","’",$USER_FULLNAME)."')\"><span class='material-icons' style='font-size:12px;'>auto_awesome</span> <span> Auto </span></button>
                    </div>";                
                } else {
                    $html .=  "<div class='divBOX'>Signature<br>
                        <img id='user_signature_img' src='' style='width:auto;max-width:335px;height:90px;'>
                        <canvas class='signature_pads' id='user_signature_pad' width='335' height='90' style=\"position:relative;display:none;  font-family: 'Imperial';font-style:normal;font-weight: 400;font-size: 40px;\"></canvas><br>
                        <button type='button' id='user_signature_clear'><span class='material-icons'>cancel_presentation</span> <span> Effacer </span></button>
                        <button type='button' onclick=\"makeUSER_SIGNATURE('".str_replace("'","’",$USER_FULLNAME)."')\"><span class='material-icons' style='font-size:12px;'>auto_awesome</span> <span> Auto </span></button>
                    </div>";
                } 

				$html .= "<div class='divBOX'>" . $dw3_lbl["LANG"] . ":
					  <select name='usLANG_OPT' id='usLANG_OPT'>
						<option"; if 	($row["lang"] =="FR"){ $html .= " selected"; } $html .= " value='FR'>" . $dw3_lbl["FR"] . "</option>
						<option"; if 	($row["lang"] =="EN"){ $html .= " selected"; } $html .= " value='EN'>" . $dw3_lbl["EN"] . "</option>
						<option"; if 	($row["lang"] =="ES"){ $html .= " selected"; } $html .= " value='ES'>" . $dw3_lbl["ES"] . "</option>
					  </select>
				</div>";
				$html .= "<div class='divBOX'>" . $dw3_lbl["APLC_DFT"] . " :"; 
						$sql2 ="SELECT *
								FROM app_user
								LEFT JOIN app on app_user.app_id = app.id
								WHERE user_id = '" . $row["id"] . "'
								ORDER BY sort_number";

						$result2 = $dw3_conn->query($sql2);
						$html .= "<select id='usAPLC_OPT'>";
						if ($result2->num_rows > 0) {		
							while($row2 = $result2->fetch_assoc()) {
								$ISSELECTED = " ";
								if ($row2["app_id"] == $row["app_id"]){ $ISSELECTED = " selected ";}
                                    if ($USER_LANG == "FR"){
                                        $html .= "<option " . $ISSELECTED . " value=" . $row2["app_id"] .">". $row2["name_fr"] . "</option>";
                                    } else {
                                        $html .= "<option " . $ISSELECTED . " value=" . $row2["app_id"] .">". $row2["name_en"] . "</option>";
                                    }
							}
						} else { $html .= "<option value='0'>" . $dw3_lbl["APLC_NOTFOUND"] . "</option>"; }
					$html .= "</select></div>";
                $html .= "</div><div class='dw3_form_foot' style='padding-top:10px;'>
                            <button style='background: #444; color:#FFF;margin-top:0px;' onclick='closeOPT();'><span class='material-icons'>cancel</span>" . $dw3_lbl["CANCEL"] . "</button>
                            <button style='margin-top:0px;' onclick='updUSER_OPT();'><span class='material-icons'>save</span>" . $dw3_lbl["SAVE"] . "</button>
                        </div>";
		}
	}
echo $html;
$dw3_conn->close();
?>