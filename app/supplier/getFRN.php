<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$frID  = $_GET['frID'];
$text_width  = $_GET['tw'];

	$sql = "SELECT *
			FROM supplier 
			WHERE id = " . $frID . "
			LIMIT 1";

	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {	

		while($row = $result->fetch_assoc()) {
			echo "<div id='divEDIT_HEADER' class='dw3_form_head'>
                        <h3>". $dw3_lbl["SUPPLIER"] ." # " . $row["id"] . "</h3>
                         <button style='background:#555555;top:0px;right:0px;padding:4px;position:absolute;' onclick='closeEDITOR(this);'><span class='material-icons'>cancel</span></button>
                </div>
                <div style='position:absolute;top:240px;left:0px;right:0px;bottom:50px;overflow-x:hidden;overflow-y:auto;'>
                    <div class='divBOX'><br>" . $dw3_lbl["STAT"] . ":
                        <select name='frSTAT' id='frSTAT'>
                            <option value='0'"; if 	($row["stat"] =="0"){ echo " selected"; } echo ">Actif</option>
                            <option value='1'"; if 	($row["stat"] =="1"){ echo " selected"; } echo ">Inactif</option>
                            <option value='2'"; if 	($row["stat"] =="2"){ echo " selected"; } echo ">Proscrit</option>
                            <option value='3'"; if 	($row["stat"] =="3"){ echo " selected"; } echo ">Banni</option>
                        </select>
                    </div>
                
                    <div class='divBOX'><br>" . $dw3_lbl["NOM_COMPAGNIE"] . ":
                        <input id='frNOM' type='text' value='" . str_replace("'", "\'", htmlspecialchars($row["company_name"], ENT_QUOTES)) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'><br>" . $dw3_lbl["NOM_CONTACT"] . ":
                        <input id='frNOM_CONTACT' type='text' value='" . str_replace("'", "\'", htmlspecialchars($row["contact_name"], ENT_QUOTES)) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'><br>" . $dw3_lbl["ADR1"] . ":
                        <input id='frADR1' type='text' value='" . htmlspecialchars($row["adr1"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'><br>" . $dw3_lbl["ADR2"] . ":
                        <input id='frADR2' type='text' value='" . htmlspecialchars($row["adr2"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'><br>" . $dw3_lbl["VILLE"] . ":
                        <input id='frVILLE' type='text' value='" . htmlspecialchars($row["city"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'><br>" . $dw3_lbl["PROV"] . ":
                        <input id='frPROV' type='text' value='" . htmlspecialchars($row["province"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'><br>" . $dw3_lbl["PAYS"] . ":
                        <input id='frPAYS' type='text' value='" . htmlspecialchars($row["country"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'><br>" . $dw3_lbl["CP"] . ":
                        <input id='frCP' type='text' value='" . htmlspecialchars($row["postal_code"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>
                    <div class='divBOX'><br>" . $dw3_lbl["TEL1"] . ":<a href='tel:". $row["tel1"] . "' target='_blank'> <span class='material-icons' style='float:right;color:#" . $CIE_COLOR1 . ";'>call</span></a>
                        <input id='frTEL1' type='text' value='" . $row["tel1"] . "' onclick='detectCLICK(event,this);'>
                    </div>
                    <div class='divBOX'><br>" . $dw3_lbl["TEL2"] . ":<a href='tel:". $row["tel2"] . "' target='_blank'> <span class='material-icons' style='float:right;color:#" . $CIE_COLOR1 . ";'>call</span></a>
                        <input id='frTEL2' type='text' value='" . $row["tel2"] . "' onclick='detectCLICK(event,this);'>
                    </div>
                    <div class='divBOX'><br>" . $dw3_lbl["EML1"] . ":<a href='mailto:". $row["eml1"] . "' target='_blank'> <span class='material-icons' style='float:right;color:#" . $CIE_COLOR1 . ";'>contact_mail</span></a>
                        <input id='frEML1' type='text' value='" . $row["eml1"] . "' onclick='detectCLICK(event,this);'>
                    </div>	
                    <div class='divBOX'><br>" . $dw3_lbl["EML2"] . ":<a href='mailto:". $row["eml2"] . "' target='_blank'> <span class='material-icons' style='float:right;color:#" . $CIE_COLOR1 . ";'>contact_mail</span></a>
                        <input id='frEML2' type='text' value='" . $row["eml2"] . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'><br>" . $dw3_lbl["LANG"]. ":
                            <select name='frLANG' id='frLANG'>
                                <option value='FR'"; if 	($row["lang"] =="FR"){ echo " selected"; } echo ">FR</option>
                                <option value='EN'"; if 	($row["lang"] =="EN"){ echo " selected"; } echo ">EN</option>
                                <option value='ES'"; if 	($row["lang"] =="ES"){ echo " selected"; } echo ">ES</option>
                            </select>
                    </div>
                    <div class='divBOX' style='width:auto;max-width:100%;'><br>" . $dw3_lbl["NOTE"] . ":<br>
                        <textarea style='height:100px;width:" . $text_width . "px;' id='frNOTE'>" . $row["note"] . "</textarea>
                    </div>
                    <br><br>
                    <div class='divBOX'><br>" . $dw3_lbl["LNG"] . ":
                        <input id='frLNG' type='text' value='" . $row["longitude"] . "' onclick='detectCLICK(event,this);'>
                    </div>
                    <div class='divBOX'><br>" . $dw3_lbl["LAT"] . ":";
                        if ($APREAD_ONLY == false) {echo "<span onclick='getLngLat2()' class='material-icons' style='float:right;color:#" . $CIE_COLOR1 . ";cursor:pointer;'>share_location</span>";}
                        echo "<input id='frLAT' type='text' value='" . $row["latitude"] . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'><br>" . $dw3_lbl["DTAD"] . ":
                        <input id='frDTAD' type='text' value='" . $row["date_created"] . "' disabled'>
                    </div>			
                    <div class='divBOX'><br>" . $dw3_lbl["DTMD"] . ":
                        <input id='frDTMD' type='text' value='" . $row["date_modified"] . "' disabled'>
                    </div>
                
				<br><br></div><div class='dw3_form_foot'>";
                    if ($APREAD_ONLY == false) {echo "<button class='red' onclick='deleteFRN(\"" . $row["id"] . "\");'><span class='material-icons'>delete</span></button>";}
                     echo "<button class='grey' onclick='closeEDITOR();'><span class='material-icons'>cancel</span> " . $dw3_lbl["CLOSE"] . "</button>";
                    if ($APREAD_ONLY == false) {echo "<button onclick='updFRN(\"" . $row["id"] . "\");'><span class='material-icons'>save</span>" . $dw3_lbl["SAVE"] . "</button>";}
				echo "</div>";
		}
	
	}
$dw3_conn->close();
?>