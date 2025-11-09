<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$enID  = $_GET['enID'];
$html = "";
$text_width  = $_GET['tw'];

	$sql = "SELECT A.*, IFNULL(B.name,A.user_created) as user_cr_name, IFNULL(C.name,A.user_modified) as user_md_name, IFNULL(D.name,'') as user_eml_name
			FROM order_head A
            LEFT JOIN (SELECT id,name FROM user) B ON B.id = A.user_created 
            LEFT JOIN (SELECT id,name FROM user) C ON C.id = A.user_modified 
            LEFT JOIN (SELECT id,name FROM user) D ON D.id = A.user_email 
			WHERE A.id = " . $enID . "
            ORDER BY A.date_modified ASC
			LIMIT 1";

	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
            $head_stat = $row['stat'];
			$html .= "<div id='divEDIT_HEADER' style='border-radius:0px;cursor:move;position:absolute;top:0px;right:0px;left:0px;height:40px;background:#" .$CIE_COLOR1 . ";color:#" .$CIE_COLOR2 . ";'>
                        <span style='font-size:0.8em;position:absolute;top:7px;left:15px;background:#333;border-radius:6px;padding:2px 2px 2px 2px ;'>";
                            if ($row["stat"] =="7"){ $html .= " <b style='color:violet;'>(Soumission)</b>"; }
                            if ($row["stat"] =="0"){ $html .= " <b style='color:lightgreen;'>(En traitement)</b>"; }
                            if ($row["stat"] =="1"){ $html .= " <b style='color:lightblue;'>(En facturation)</b>"; }
                            if ($row["stat"] =="2"){ $html .= " <b style='color:red;'>(À expédier)</b>"; }
                            if ($row["stat"] =="3"){ $html .= " <b style='color:orange;'>(En expédition)</b>"; }
                            if ($row["stat"] =="5"){ $html .= " <b style='color:white;'>(Payée et livrée)</b>"; }
                            if ($row["stat"] =="4"){ $html .= " <b style='color:lightgrey;'>(Annulée)</b>"; }
            $html .= " </span>
                    <h3 style='vertical-align:middle;height:40px;'><div style='display: grid;align-items: center;height:40px;'>" .$dw3_lbl["ORDER"] . " #" . $row["id"]."</div></h3>
                            <button class='grey' style='top:0px;right:0px;padding:4px;position:absolute;' onclick=\"closeEDITOR(this);getCMDS('','',LIMIT);\"><span class='material-icons'>cancel</span></button>
                        </div>
            <div style='position:absolute;top:40px;left:0px;width:100%;bottom:0px;overflow-x:hidden;overflow-y:auto;'>
                    <div class='divBOX'>Status:
                        <select oninput='updateOrderStatus($enID,this.value);' id='enSTAT'>                            
                            <option value='7'"; if 	($row["stat"] =="7"){  $html .= " selected"; }  $html .= ">Soumission</option>
                            <option value='0'"; if 	($row["stat"] =="0"){  $html .= " selected"; }  $html .= ">En traitement</option>
                            <option value='1'"; if 	($row["stat"] =="1"){  $html .= " selected"; }  $html .= ">En facturation</option>
                            <option value='2'"; if 	($row["stat"] =="2"){  $html .= " selected"; }  $html .= ">À expédier</option>
                            <option value='3'"; if 	($row["stat"] =="3"){  $html .= " selected"; }  $html .= ">En expédition</option>
                            <option value='5'"; if 	($row["stat"] =="5"){  $html .= " selected"; }  $html .= ">Payée et livrée</option>
                            <option value='4'"; if 	($row["stat"] =="4"){  $html .= " selected"; }  $html .= ">Annulée</option>
                        </select></div>
                <div class='divBOX'>#ID du Projet:";
                if ($APREAD_ONLY == false) { $html .= "<button onclick='updPRJ_ID(".$row["id"].")' style='float:right;padding:2px;'><span class='material-icons'>save</span></button>";}
                    $html .= "<input id='enPRJ' type='number' value='" . $row["project_id"] . "'>";
                $html .= "</div><br>";
                if ($row["subscription_stat"] == "active"){
                    $html .= "<div class='divBOX' style='background-color:rgba(0,255,0,0.1);padding:5px;border-radius:8px;'>
                                <span style='width:100%;text-align:center'><span class='material-icons' style='vertical-align:middle;color:green;'>autorenew</span> Abonnement actif</span>
                                <br>Prochaine facture le: " . substr($row["date_renew"],0,10) . "
                                <span style='width:100%;text-align:center'><button class='red' onclick=\"stripe_cancel_subscription('" . $row["id"] . "','" . $row["id"] . "')\"><span class='material-icons'>block</span> Annuler l'abonnement</button></span>
                            </div>";
                } else if ($row["subscription_stat"] == "canceled"){
                    $html .= "<div class='divBOX' style='background-color:rgba(255,0,0,0.1);padding:5px;border-radius:8px;'><span class='material-icons' style='vertical-align:middle;color:red;'>block</span> Abonnement annulé</div>";
                } else if ($row["subscription_stat"] == "expired"){
                    $html .= "<div class='divBOX' style='background-color:rgba(255,0,0,0.1);padding:5px;border-radius:8px;'>
                                <span style='width:100%;text-align:center'><span class='material-icons' style='vertical-align:middle;color:red;'>cancel</span> Abonnement expiré</span>
                                <br>Expiration: " . substr($row["date_renew"],0,10) . "
                                <br><span style='width:100%;text-align:center'><button class='red' onclick=\"stripe_cancel_subscription('" . $row["id"] . "','" . $row["id"] . "')\"><span class='material-icons'>block</span> Annuler l'abonnement</button></span>
                                </div>";
                } else if ($row["subscription_stat"] == "unpaid"){
                    $html .= "<div class='divBOX' style='background-color:rgba(255,0,0,0.1);padding:5px;border-radius:8px;'>
                                <span style='width:100%;text-align:center'><span class='material-icons' style='vertical-align:middle;color:red;'>error</span> Abonnement impayé</span>
                                <br>Prochaine facture le: " . substr($row["date_renew"],0,10) . "
                                <br><span style='width:100%;text-align:center'><button class='red' onclick=\"stripe_cancel_subscription('" . $row["id"] . "','" . $row["id"] . "')\"><span class='material-icons'>block</span> Annuler l'abonnement</button></span>
                            </div>";
                }
            /* if 	($row["stat"] =="0"|| $row["stat"] =="1"|| $row["stat"] =="2"|| $row["stat"] =="3"){
                if ($APREAD_ONLY == false) { $html .= "<button onclick='setEXPED(".$row["id"].");' class='grey'><span class='material-icons'>local_shipping</span> Expédition</button> ";}
            } */
            $html .= "<h4 onclick=\"toggleSub('divSub1','up1');\" style=\"text-align:left;width:100%;padding:0px 5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;border-bottom: 1mm ridge rgba(0, 199, 30, .6);background: rgba(200, 200, 200, 0.7);\">
                    <span class=\"material-icons\">sticky_note_2</span> Entete de commande <sup><span id='lbl_total_head'></span></sup><span id='up1' class=\"material-icons\" style='float:right;margin-right:5px;'>keyboard_arrow_up</span>
                 </h4>
                <div class='divMAIN' id='divSub1' style='height:0px;display:none;margin-bottom:0px;'>
                <div style='"; if ($row["stat"]!=0 && $row["stat"]!=7){$html .= "opacity: 0.4;pointer-events: none;";} $html .= "'>
                    <div class='divBOX'>" .$dw3_lbl["FULLNAME"] . ":
                        <input id='enID' style='display:none;' type='text' value='" . $row["id"] . "'>
                        <input id='enNOM' type='text' value='" . str_replace("'", "\'", htmlspecialchars(dw3_decrypt($row["name"]), ENT_QUOTES)) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'>Compagnie:
                        <input id='enCIE' type='text' value='" . htmlspecialchars($row["company"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>								
                    <div class='divBOX'>" .$dw3_lbl["TEL"] . ":
                        <input id='enTEL' type='text' value='" . htmlspecialchars(dw3_decrypt($row["tel"]), ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>	
                <h2>Adresse de facturation</h2>
                    <div class='divBOX'>" .$dw3_lbl["ADR1"] . ":
                        <input id='enADR1' type='text' value='" . htmlspecialchars(dw3_decrypt($row["adr1"]), ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'>" .$dw3_lbl["ADR2"] . ":
                        <input id='enADR2' type='text' value='" . htmlspecialchars(dw3_decrypt($row["adr2"]), ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'>" .$dw3_lbl["VILLE"] . ":
                        <input id='enVILLE' type='text' value='" . htmlspecialchars($row["city"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'>" .$dw3_lbl["PROV"] . ":
                        <input id='enPROV' type='text' value='" . htmlspecialchars($row["prov"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'>" .$dw3_lbl["PAYS"] . ":
                        <input id='enPAYS' type='text' value='" . htmlspecialchars($row["country"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'>" .$dw3_lbl["CP"] . ":
                        <input id='enCP' type='text' value='" . htmlspecialchars($row["postal_code"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>
                <h2>Adresse d'expédition</h2>";
                if ($APREAD_ONLY == false) { $html .= "<button onclick='copyADR_TO_SH();'>Même adresse que la facturation</button><br>";}
                $html .= "<div class='divBOX'>" .$dw3_lbl["ADR1"] . ":
                        <input id='enADR1_SH' type='text' value='" . htmlspecialchars(dw3_decrypt($row["adr1_sh"]), ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'>" .$dw3_lbl["ADR2"] . ":
                            <input id='enADR2_SH' type='text' value='" . htmlspecialchars(dw3_decrypt($row["adr2_sh"]), ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'>" .$dw3_lbl["VILLE"] . ":
                        <input id='enVILLE_SH' type='text' value='" . htmlspecialchars($row["city_sh"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'>" .$dw3_lbl["PROV"] . ":
                        <input id='enPROV_SH' type='text' value='" . htmlspecialchars($row["province_sh"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'>" .$dw3_lbl["PAYS"] . ":
                        <input id='enPAYS_SH' type='text' value='" . htmlspecialchars($row["country_sh"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'>" .$dw3_lbl["CP"] . ":
                        <input id='enCP_SH' type='text' value='" . htmlspecialchars($row["postal_code_sh"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div><br>
                    <div class='divBOX' style='width:auto;max-width:100%;'>" .$dw3_lbl["NOTE"] . ":<br>
                        <textarea style='height:100px;width:" . $text_width . "px;' id='enNOTE'>" . $row["note"] . "</textarea>
                    </div>
                <br>
                    <div class='divBOX'>Expédier de:
                        <select id='enLOC'>";
                        $sql2 = "SELECT * FROM location WHERE stat='0' ORDER BY name";
                        $result2 = $dw3_conn->query($sql2);
                        //echo "<option disabled>Administrateurs</option>";
                        if ($result2->num_rows > 0) {	
                            while($row2 = $result2->fetch_assoc()) {
                                if ($row2["id"] == $row["location_id"]){ $strTMP = " selected"; } else {$strTMP = " "; }
                                $html .= "<option value='". $row2["id"] . "' " . $strTMP . ">"	. $row2["name"] . "</option>";
                            }
                        }
                    $html .= "</select></div>				
                    <div class='divBOX'>Type de livraison:
                        <input type='text' disabled value='" . $row["ship_type"] . "'>
                    </div>
                    <div class='divBOX'>Date livraison / ramassage:
                        <input id='enDTLV' type='datetime-local' value='" . $row["date_delivery"] . "'>
                    </div>
                    <div class='divBOX'>$ Transport: <button class='gold' onclick='dw3_tool_calc()' style='padding:3px;float:right;'><span class='material-icons' style='vertical-align:middle;'>calculate</span></button>
                        <input id='enTRP' type='number' min='0.00' value='" . $row["transport"] . "' onclick='detectCLICK(event,this);'>
                    </div><br>	
                    <div class='divBOX'>$ Escompte:
                        <input id='enDISCOUNT' type='number' min='0.00' value='" . $row["discount"] . "' onclick='detectCLICK(event,this);'>
                    </div><br>	
                    <div class='divBOX'>Confirmation de commande par courriel:
                        <input id='enDTEML' type='datetime-local' value='" . $row["date_email"] . "'  disabled>
                        <input id='enUSEML' type='text' value='" . $row["user_eml_name"] . "' disabled>
                        <input id='txtEML' type='text' value='" . dw3_decrypt($row['eml']) . "'>";
                        if ($APREAD_ONLY == false) { $html .= "<button onclick='sendOrderEmail();' style='width:100%;'><span class='material-icons'>outgoing_mail</span> Envoyer une confirmation par courriel</button>";}
                    $html .= "</div>
                <br>
                    <div class='divBOX'>" .$dw3_lbl["DTAD"] . ":
                        <input id='enDTAD' type='datetime-local' value='" . $row["date_created"] . "' disabled>
                        <input id='enUSAD' type='text' value='" . $row["user_cr_name"] . "' disabled>
                    </div>			
                    <div class='divBOX'>" .$dw3_lbl["DTMD"] . ":
                        <input id='enDTMD' type='datetime-local' value='" . $row["date_modified"] . "' disabled>
                        <input id='enUSMD' type='text' value='" . $row["user_md_name"] . "' disabled>
                    </div>
                    <br>
                    <div id='divTOTAL' style='padding:3px;background:rgba(200, 200, 200, 0.7);display:none;'></div>";
                    if ($APREAD_ONLY == false) { $html .= "<button style='"; if ($row["stat"]!=0 && $row["stat"]!=7){$html .= "display:none;";} $html .= "' class='red' onclick='deleteCMD(\"" . $row["id"] . "\");'><span class='material-icons'>delete</span> " .$dw3_lbl["DEL"] . "</button>";}
                    if ($APREAD_ONLY == false) { $html .= "<button style='"; if ($row["stat"]!=0 && $row["stat"]!=7){$html .= "display:none;";} $html .= "' class='green' onclick='updCMD(\"" . $row["id"] . "\");'><span class='material-icons'>save</span> " .$dw3_lbl["SAVE"] . "</button> ";}
                $html .="</div>
                </div>";
		}
	
	}

//GET LGNS
    $html .= "<div id='divCMD_LINE'></div>";
//ADD TO ORDER SECTION
    $html .= "<h4 onclick=\"toggleSub('divSub3','up3');\" style=\"text-align:left;"; if ($head_stat !=0){$html .= "display:none;";} $html .= "width:100%;padding:0px 5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;border-bottom: 1mm ridge rgba(0, 199, 250, .6);background: rgba(200, 200, 200, 0.7);\">
                <span class=\"material-icons\">inventory_2</span> Ajouter un item<span id='up3' class=\"material-icons\" style='float:right;margin-right:5px;'>keyboard_arrow_down</span>
                </h4>
                <div class='divMAIN' id='divSub3' style='"; if ($head_stat !=0){$html .= "display:none;";} $html .= "width:100%;overflow-x:scroll;margin:0px;padding:0px;'>
                    <div class='divBOX' style='margin:0px;padding:1px;min-height:0px;max-width:100%;background: rgba(180, 180, 180, 0.7);'>	
                        <table style='width:100%;'><tr>
                            <td width='*'><input id='newPRD' onkeyup='scanUPC();' type='text' value=''></td>
                            <td style='width:20px;text-align:center;'><button style=\"margin:0px 2px 0px 2px;padding:2px;\" onclick=\"subQTY();\"><span class=\"material-icons\">arrow_circle_down</span></button></td>
                            <td style='width:80px;'><input id='newQTE' type='number' value='1'></td>
                            <td style='width:20px;text-align:center;'><button style=\"margin:0px 2px 0px 2px;padding:2px;\" onclick=\"addQTY();\"><span class=\"material-icons\">arrow_circle_up</span></button></td>
                            <td style='width:20px;text-align:center;'><button style=\"margin:0px 2px 0px 2px;padding:2px;\" onclick=\"lockQTY();\"><span id='span_lockQTY' class='material-icons'>lock_open</span></button></td>
                        </tr></table>
                    </div>
                    <div id='lstPRD' style='width:100%;background:rgba(0, 0, 0, 0.3);'></div>
                </div>";
//TOTAL & FUNCTIONS 
    $html .= "</div>";

$dw3_conn->close();
die($html);
?>
