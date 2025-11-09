<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID  = $_GET['ID'];

echo "<div id='divEDIT_LINE_HEADER' class='dw3_form_head'>
        <h2>Question # " . $ID . "</b>
        <button style='background:#555555;top:0px;right:0px;padding:4px;position:absolute;' onclick='closeEDIT_LINE();'><span class='material-icons'>cancel</span></button>
    </div>";

	$sql = "SELECT * FROM prototype_line WHERE id = '" . $ID . "' LIMIT 1";
	$result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {	
		while($row = $result->fetch_assoc()) {
            if ($row["mandatory"]=="1"){$req=" checked "; }else { $req="";}
            if ($row["multiplier"]=="1"){$mult=" checked "; }else { $mult="";}
            if ($row["is_total"]=="1"){$is_tot=" checked "; }else { $is_tot="";}
            if ($row["last_on_page"]=="1"){$last=" checked "; }else { $last="";}
            if ($row["exclude_multiplier"]=="1"){$is_excluded=" checked "; }else { $is_excluded="";}
                echo "<div style='position:absolute;top:40px;left:0px;right:0px;bottom:50px;overflow-x:hidden;overflow-y:auto;'>
                    <div class='divBOX' style='max-width:684px;'>Question / Titre de section:<br>
                        <span style='vertical-align:center;font-size:0.8em;'>FR: </span><input id='lnNAME' type='text' value=\"" . $row["name_fr"]. "\" onclick='detectCLICK(event,this);' style='width:75%;'>";
                        if ($CIE_DEEPL_KEY != ""){ echo "<button onclick=\"dw3_translate('lnNAME','fr','en','lnNAME_EN');\"><span class='material-icons' style='font-size:12px;'>translate</span>FR->EN</button>"; }
                        echo "<br>
                        <span style='vertical-align:center;font-size:0.8em;'>EN: </span><input id='lnNAME_EN' type='text' value=\"" . $row["name_en"]. "\" onclick='detectCLICK(event,this);' style='width:75%;'>";
                        if ($CIE_DEEPL_KEY != ""){ echo "<button onclick=\"dw3_translate('lnNAME_EN','en','fr','lnNAME');\"><span class='material-icons' style='font-size:12px;'>translate</span>EN->FR</button>"; }
                    echo "</div>						
                    <div class='divBOX'>Type de réponse:
                    <select id='lnTYPE'>
                        <option value='NONE'"; if 	($row["response_type"] =="NONE"){ echo " selected"; } echo ">Aucune (Information ou titre de section)</option>
                        <option value='TEXT'"; if 	($row["response_type"] =="TEXT"){ echo " selected"; } echo ">Texte / nombre</option>
                        <option value='MULTI-TEXT'"; if 	($row["response_type"] =="MULTI-TEXT"){ echo " selected"; } echo ">Texte / nombre multiple</option>
                        <option value='CHECKBOX'"; if 	($row["response_type"] =="CHECKBOX"){ echo " selected"; } echo ">Case à cocher</option>
                        <option value='YES/NO'"; if 	($row["response_type"] =="YES/NO"){ echo " selected"; } echo ">Oui / Non</option>
                        <option value='CHOICE'"; if 	($row["response_type"] =="CHOICE"){ echo " selected"; } echo ">Choix de réponses</option>
                        <option value='MULTI-CHOICE'"; if 	($row["response_type"] =="MULTI-CHOICE"){ echo " selected"; } echo ">Choix de réponses multiples</option>
                        <option value='FILE'"; if 	($row["response_type"] =="FILE"){ echo " selected"; } echo ">Fichier</option>
                        <option value='COLOR'"; if 	($row["response_type"] =="COLOR"){ echo " selected"; } echo ">Couleur</option>
                        <option value='PASSWORD'"; if 	($row["response_type"] =="PASSWORD"){ echo " selected"; } echo ">Mot de passe</option>
                        <option value='TIME'"; if 	($row["response_type"] =="TIME"){ echo " selected"; } echo ">Heure</option>
                        <option value='DATE'"; if 	($row["response_type"] =="DATE"){ echo " selected"; } echo ">Date</option>
                        <option value='SIGNATURE'"; if 	($row["response_type"] =="SIGNATURE"){ echo " selected"; } echo ">Signature</option>
                        <option value='SIG-USER'"; if 	($row["response_type"] =="SIG-USER"){ echo " selected"; } echo ">Signature de l'employé</option>
                        <option value='PICKTIME'"; if 	($row["response_type"] =="PICKTIME"){ echo " selected"; } echo ">Date et heure de ramassage</option>
                    </select>
                    </div><hr>
                    <div class='divBOX' style='max-width:162px;'>Record associé:
                    <select id='lnREC'>
                        <option value='NONE'"; if 	($row["record_name"] =="NONE"){ echo " selected"; } echo ">Aucun</option>
                        <option value='CIE'"; if 	($row["record_name"] =="CIE"){ echo " selected"; } echo ">Compagnie</option>
                        <option value='NAME'"; if 	($row["record_name"] =="NAME"){ echo " selected"; } echo ">Nom</option>
                        <option value='ADR1'"; if 	($row["record_name"] =="ADR1"){ echo " selected"; } echo ">Adresse ligne 1</option>
                        <option value='ADR2'"; if 	($row["record_name"] =="ADR2"){ echo " selected"; } echo ">Adresse ligne 2</option>
                        <option value='CITY'"; if 	($row["record_name"] =="CITY"){ echo " selected"; } echo ">Ville</option>
                        <option value='PROV'"; if 	($row["record_name"] =="PROV"){ echo " selected"; } echo ">Province</option>
                        <option value='COUNTRY'"; if 	($row["record_name"] =="COUNTRY"){ echo " selected"; } echo ">Pays</option>
                        <option value='CP'"; if 	($row["record_name"] =="CP"){ echo " selected"; } echo ">Code Postal</option>
                        <option value='TEL1'"; if 	($row["record_name"] =="TEL1"){ echo " selected"; } echo ">Téléphone</option>
                        <option value='LANG'"; if 	($row["record_name"] =="LANG"){ echo " selected"; } echo ">Langue</option>
                        <option value='GENRE'"; if 	($row["record_name"] =="GENRE"){ echo " selected"; } echo ">Sex</option>
                        <option value='NAISS'"; if 	($row["record_name"] =="NAISS"){ echo " selected"; } echo ">Date de naissance</option>
                    </select>
                    </div>
                    <div class='divBOX' style='max-width:162px;'><label for='lnREQ'>Obligatoire:</label>
                        <input id='lnREQ' type='checkbox' " . $req . " style='float:right;margin:5px;' onclick='detectCLICK(event,this);'>
                    </div>	
                    <div class='divBOX'><label for='lnREQ'>Total entré manuellement?:</label>
                        <input id='lnTOT' type='checkbox' " . $is_tot . " style='float:right;margin:5px;' onclick='detectCLICK(event,this);'>
                        <br>
                        <div style='font-size:0.7em;'>Doit être du type 'Texte / nombre multiple'. Valeurs (1=Sous-total, 2=TPS, 3=TVP et 4=Total). Un bouton sera ajouté pour faire le calcul à partir du sous-total sur le formulaire des questionnaires complétés. (Visible à l'interne seulement)</div>
                    </div>	
                    <div class='divBOX' style='max-width:162px;'><label for='lnMULT'>Multiplicateur:</label>
                        <input id='lnMULT' type='checkbox' " . $mult . " style='float:right;margin:5px;' onclick='detectCLICK(event,this);'>
                        <br>
                        Question multiplié:
                        <input id='lnMULT_L' type='number' value='" . $row["multiplied"] . "' style='width:50%;text-align:right;-moz-appearance: range;' onclick='detectCLICK(event,this);'>
                        <button onclick=\"selMULT_LINE('".$row["head_id"]."','". $ID ."');\"><span class='material-icons'>manage_search</span></button>
                        <div style='font-size:0.7em;'>Si la valeur est à 0, c'est le total qui sera multiplié.</div>
                    </div>
                    <div class='divBOX' style='max-width:162px;'><label for='lnEXCLUDE'>Exclure du multiplicateur:</label>
                        <input id='lnEXCLUDE' type='checkbox' " . $is_excluded . " style='float:right;margin:5px;' onclick='detectCLICK(event,this);'>
                    </div>		
                    <div class='divBOX' style='max-width:162px;'>Position:
                        <input id='lnPOS' type='number' value='" . $row["position"] . "' style='text-align:right;-moz-appearance: range;' onclick='detectCLICK(event,this);'>
                    </div><br>
                    <div class='divBOX' style='max-width:684px;'>Description / Information:<br>
                        <span style='vertical-align:center;font-size:0.8em;'>FR:</span>";
                        if ($CIE_DEEPL_KEY != ""){ echo "<button onclick=\"dw3_translate('lnDESC','fr','en','lnDESC_EN');\" style='padding:4px;'><span class='material-icons' style='font-size:12px;'>translate</span>FR->EN</button>"; }
                        echo "<textarea id='lnDESC' rows='4' style='resize:none;' style='width:70%;'>" . $row["description_fr"]. "</textarea>
                        <br><span style='vertical-align:center;font-size:0.8em;'>EN:</span>";
                        if ($CIE_DEEPL_KEY != ""){ echo "<button onclick=\"dw3_translate('lnDESC_EN','en','fr','lnDESC');\" style='padding:4px;'><span class='material-icons' style='font-size:12px;'>translate</span>EN->FR</button>"; }
                    echo "<textarea id='lnDESC_EN' rows='4' style='resize:none;' style='width:70%;'>" . $row["description_en"]. "</textarea></div>				
                    <div class='divBOX'>Taille de la boite question-réponse:
                    <select id='lnSIZE'>
                        <option value='SMALL'"; if 	($row["box_size"] =="SMALL"){ echo " selected"; } echo ">Petite</option>
                        <option value='MEDIUM'"; if 	($row["box_size"] =="MEDIUM"){ echo " selected"; } echo ">Moyenne</option>
                        <option value='LARGE'"; if 	($row["box_size"] =="LARGE"){ echo " selected"; } echo ">Large</option>
                    </select>
                    </div>
                    <div class='divBOX'>Alignement réponse (type texte):
                    <select id='lnALIGN'>
                        <option value=''"; if 	($row["response_align"] ==""){ echo " selected"; } echo ">Juste après la question</option>
                        <option value='LEFT'"; if 	($row["response_align"] =="LEFT"){ echo " selected"; } echo ">Gauche</option>
                        <option value='CENTER'"; if 	($row["response_align"] =="CENTER"){ echo " selected"; } echo ">Centre</option>
                        <option value='RIGHT'"; if 	($row["response_align"] =="RIGHT"){ echo " selected"; } echo ">Droite</option>
                    </select>
                    </div>
                    <div class='divBOX'>#Produit associé:
                        <input style='width:30%;' id='lnPRD' type='text' value='" . $row["product_id"] . "' onclick='detectCLICK(event,this);'>
                        <button onclick=\"openSEL_PRD('')\" style='padding:5px;float:right;'><span class='material-icons'>saved_search</span></button>
                        <div style='font-size:0.7em;'>Sur une case à cocher la quantité sera de 1 si cochée, sur un choix la valeur choisie sera utilisé comme quantité et sur du texte la valeur 1 sera utilisé comme quantité.</div>
                    </div>
                    <div class='divBOX' style='max-width:162px;'><label for='lnLAST'>Changement de page après cette question:</label>
                        <input id='lnLAST' type='checkbox' " . $last . " style='float:right;margin:5px;' onclick='detectCLICK(event,this);'>
                    </div>	
                    <hr>            
                    <button style='min-width:50px;' onclick='selIMG(1);'><img id='imgIMG1' src='/pub/upload/". $row["choice_img1"]."' style='width:100px;height:auto;'> ..</button>
                    <div class='divBOX'>Choix / Réponse 1:<br>
                        <span style='vertical-align:center;font-size:0.8em;'>FR:</span><input id='lnCHOICE1' type='text' value='" . $row["choice_name1"] . "' onclick='detectCLICK(event,this);' style='width:70%;'>";
                        if ($CIE_DEEPL_KEY != ""){ echo "<button onclick=\"dw3_translate('lnCHOICE1','fr','en','lnCHOICE1_EN');\" style='padding:4px;'><span class='material-icons' style='font-size:12px;'>translate</span>FR->EN</button>"; }
                        echo "<br><span style='vertical-align:center;font-size:0.8em;'>EN:</span><input id='lnCHOICE1_EN' type='text' value='" . $row["choice_name1_en"] . "' onclick='detectCLICK(event,this);' style='width:70%;'>";
                        if ($CIE_DEEPL_KEY != ""){ echo "<button onclick=\"dw3_translate('lnCHOICE1_EN','en','fr','lnCHOICE1');\" style='padding:4px;'><span class='material-icons' style='font-size:12px;'>translate</span>EN->FR</button>"; }
                        echo "</div>
                    <div class='divBOX'>Valeur de la réponse 1:
                        <input id='lnVALUE1' style='width:100px;' type='number' value='" . $row["choice_value1"] . "' onclick='detectCLICK(event,this);'>
                    </div>
                    <div class='divBOX' style='display:none;'>Image de la réponse 1:
                        <input id='lnIMG1' style='width:100px;' type='text' value='" . $row["choice_img1"] . "'>
                    </div>
                    <hr>
                    <button style='min-width:50px;' onclick='selIMG(2);'><img id='imgIMG2' src='/pub/upload/". $row["choice_img2"]."' style='width:100px;height:auto;'> ..</button>
                    <div class='divBOX'>Choix / Réponse 2:<br>
                        <span style='vertical-align:center;font-size:0.8em;'>FR:</span><input id='lnCHOICE2' type='text' value='" . $row["choice_name2"] . "' onclick='detectCLICK(event,this);' style='width:70%;'>";
                        if ($CIE_DEEPL_KEY != ""){ echo "<button onclick=\"dw3_translate('lnCHOICE2','fr','en','lnCHOICE2_EN');\" style='padding:4px;'><span class='material-icons' style='font-size:12px;'>translate</span>FR->EN</button>"; }
                        echo "<br><span style='vertical-align:center;font-size:0.8em;'>EN:</span><input id='lnCHOICE2_EN' type='text' value='" . $row["choice_name2_en"] . "' onclick='detectCLICK(event,this);' style='width:70%;'>";
                        if ($CIE_DEEPL_KEY != ""){ echo "<button onclick=\"dw3_translate('lnCHOICE2_EN','en','fr','lnCHOICE2');\" style='padding:4px;'><span class='material-icons' style='font-size:12px;'>translate</span>EN->FR</button>"; }
                        echo "</div>
                    <div class='divBOX'>Valeur de la réponse 2:
                        <input id='lnVALUE2' style='width:100px;' type='number' value='" . $row["choice_value2"] . "' onclick='detectCLICK(event,this);'>
                    </div>
                    <div class='divBOX' style='display:none;'>Image de la réponse 2:
                        <input id='lnIMG2' style='width:100px;' type='text' value='" . $row["choice_img2"] . "'>
                    </div>
                    <hr>
                    <button style='min-width:50px;' onclick='selIMG(3);'><img id='imgIMG3' src='/pub/upload/". $row["choice_img3"]."' style='width:100px;height:auto;'> ..</button>
                    <div class='divBOX'>Choix / Réponse 3:<br>
                        <span style='vertical-align:center;font-size:0.8em;'>FR:</span><input id='lnCHOICE3' type='text' value='" . $row["choice_name3"] . "' onclick='detectCLICK(event,this);' style='width:70%;'>";
                        if ($CIE_DEEPL_KEY != ""){ echo "<button onclick=\"dw3_translate('lnCHOICE3','fr','en','lnCHOICE3_EN');\" style='padding:4px;'><span class='material-icons' style='font-size:12px;'>translate</span>FR->EN</button>"; }
                        echo "<br><span style='vertical-align:center;font-size:0.8em;'>EN:</span><input id='lnCHOICE3_EN' type='text' value='" . $row["choice_name3_en"] . "' onclick='detectCLICK(event,this);' style='width:70%;'>";
                        if ($CIE_DEEPL_KEY != ""){ echo "<button onclick=\"dw3_translate('lnCHOICE3_EN','en','fr','lnCHOICE3');\" style='padding:4px;'><span class='material-icons' style='font-size:12px;'>translate</span>EN->FR</button>"; }
                        echo "</div>
                    <div class='divBOX'>Valeur de la réponse 3:
                        <input id='lnVALUE3' style='width:100px;' type='number' value='" . $row["choice_value3"] . "' onclick='detectCLICK(event,this);'>
                    </div>
                    <div class='divBOX' style='display:none;'>Image de la réponse 3:
                        <input id='lnIMG3' style='width:100px;' type='text' value='" . $row["choice_img3"] . "'>
                    </div>
                    <hr>
                    <button style='min-width:50px;' onclick='selIMG(4);'><img id='imgIMG4' src='/pub/upload/". $row["choice_img4"]."' style='width:100px;height:auto;'> ..</button>
                    <div class='divBOX'>Choix / Réponse 4:<br>
                        <span style='vertical-align:center;font-size:0.8em;'>FR:</span><input id='lnCHOICE4' type='text' value='" . $row["choice_name4"] . "' onclick='detectCLICK(event,this);' style='width:70%;'>";
                        if ($CIE_DEEPL_KEY != ""){ echo "<button onclick=\"dw3_translate('lnCHOICE4','fr','en','lnCHOICE4_EN');\" style='padding:4px;'><span class='material-icons' style='font-size:12px;'>translate</span>FR->EN</button>"; }
                        echo "<br><span style='vertical-align:center;font-size:0.8em;'>EN:</span><input id='lnCHOICE4_EN' type='text' value='" . $row["choice_name4_en"] . "' onclick='detectCLICK(event,this);' style='width:70%;'>";
                        if ($CIE_DEEPL_KEY != ""){ echo "<button onclick=\"dw3_translate('lnCHOICE4_EN','en','fr','lnCHOICE4');\" style='padding:4px;'><span class='material-icons' style='font-size:12px;'>translate</span>EN->FR</button>"; }
                        echo "</div>
                    <div class='divBOX'>Valeur de la réponse 4:
                        <input id='lnVALUE4' style='width:100px;' type='number' value='" . $row["choice_value4"] . "' onclick='detectCLICK(event,this);'>
                    </div>
                    <div class='divBOX' style='display:none;'>Image de la réponse 4:
                        <input id='lnIMG4' style='width:100px;' type='text' value='" . $row["choice_img4"] . "'>
                    </div>
                    <hr>
                    <button style='min-width:50px;' onclick='selIMG(5);'><img id='imgIMG5' src='/pub/upload/". $row["choice_img5"]."' style='width:100px;height:auto;'> ..</button>
                    <div class='divBOX'>Choix / Réponse 5:<br>
                        <span style='vertical-align:center;font-size:0.8em;'>FR:</span><input id='lnCHOICE5' type='text' value='" . $row["choice_name5"] . "' onclick='detectCLICK(event,this);' style='width:70%;'>";
                        if ($CIE_DEEPL_KEY != ""){ echo "<button onclick=\"dw3_translate('lnCHOICE5','fr','en','lnCHOICE5_EN');\" style='padding:4px;'><span class='material-icons' style='font-size:12px;'>translate</span>FR->EN</button>"; }
                        echo "<br><span style='vertical-align:center;font-size:0.8em;'>EN:</span><input id='lnCHOICE5_EN' type='text' value='" . $row["choice_name5_en"] . "' onclick='detectCLICK(event,this);' style='width:70%;'>";
                        if ($CIE_DEEPL_KEY != ""){ echo "<button onclick=\"dw3_translate('lnCHOICE5_EN','en','fr','lnCHOICE5');\" style='padding:4px;'><span class='material-icons' style='font-size:12px;'>translate</span>EN->FR</button>"; }
                        echo "</div>
                    <div class='divBOX'>Valeur de la réponse 5:
                        <input id='lnVALUE5' style='width:100px;' type='number' value='" . $row["choice_value5"] . "' onclick='detectCLICK(event,this);'>
                    </div>
                    <div class='divBOX' style='display:none;'>Image de la réponse 5:
                        <input id='lnIMG5' style='width:100px;' type='text' value='" . $row["choice_img5"] . "'>
                    </div>
                    <hr>
                    <button style='min-width:50px;' onclick='selIMG(6);'><img id='imgIMG6' src='/pub/upload/". $row["choice_img6"]."' style='width:100px;height:auto;'> ..</button>
                    <div class='divBOX'>Choix / Réponse 6:<br>
                        <span style='vertical-align:center;font-size:0.8em;'>FR:</span><input id='lnCHOICE6' type='text' value='" . $row["choice_name6"] . "' onclick='detectCLICK(event,this);' style='width:70%;'>";
                        if ($CIE_DEEPL_KEY != ""){ echo "<button onclick=\"dw3_translate('lnCHOICE6','fr','en','lnCHOICE6_EN');\" style='padding:4px;'><span class='material-icons' style='font-size:12px;'>translate</span>FR->EN</button>"; }
                        echo "<br><span style='vertical-align:center;font-size:0.8em;'>EN:</span><input id='lnCHOICE6_EN' type='text' value='" . $row["choice_name6_en"] . "' onclick='detectCLICK(event,this);' style='width:70%;'>";
                        if ($CIE_DEEPL_KEY != ""){ echo "<button onclick=\"dw3_translate('lnCHOICE6_EN','en','fr','lnCHOICE6');\" style='padding:4px;'><span class='material-icons' style='font-size:12px;'>translate</span>EN->FR</button>"; }
                        echo "</div>
                    <div class='divBOX'>Valeur de la réponse 6:
                        <input id='lnVALUE6' style='width:100px;' type='number' value='" . $row["choice_value6"] . "' onclick='detectCLICK(event,this);'>
                    </div>
                    <div class='divBOX' style='display:none;'>Image de la réponse 6:
                        <input id='lnIMG6' style='width:100px;' type='text' value='" . $row["choice_img6"] . "'>
                    </div>
                    <hr>
                    <button style='min-width:50px;' onclick='selIMG(7);'><img id='imgIMG7' src='/pub/upload/". $row["choice_img7"]."' style='width:100px;height:auto;'> ..</button>
                    <div class='divBOX'>Choix / Réponse 7:<br>
                        <span style='vertical-align:center;font-size:0.8em;'>FR:</span><input id='lnCHOICE7' type='text' value='" . $row["choice_name7"] . "' onclick='detectCLICK(event,this);' style='width:70%;'>";
                        if ($CIE_DEEPL_KEY != ""){ echo "<button onclick=\"dw3_translate('lnCHOICE7','fr','en','lnCHOICE7_EN');\" style='padding:4px;'><span class='material-icons' style='font-size:12px;'>translate</span>FR->EN</button>"; }
                        echo "<br><span style='vertical-align:center;font-size:0.8em;'>EN:</span><input id='lnCHOICE7_EN' type='text' value='" . $row["choice_name7_en"] . "' onclick='detectCLICK(event,this);' style='width:70%;'>";
                        if ($CIE_DEEPL_KEY != ""){ echo "<button onclick=\"dw3_translate('lnCHOICE7_EN','en','fr','lnCHOICE7');\" style='padding:4px;'><span class='material-icons' style='font-size:12px;'>translate</span>EN->FR</button>"; }
                        echo "</div>
                    <div class='divBOX'>Valeur de la réponse 7:
                        <input id='lnVALUE7' style='width:100px;' type='number' value='" . $row["choice_value7"] . "' onclick='detectCLICK(event,this);'>
                    </div>                    
                    <div class='divBOX' style='display:none;'>Image de la réponse 7:
                        <input id='lnIMG7' style='width:100px;' type='text' value='" . $row["choice_img7"] . "'>
                    </div>
                    <hr>
                    <button style='min-width:50px;' onclick='selIMG(8);'><img id='imgIMG8' src='/pub/upload/". $row["choice_img8"]."' style='width:100px;height:auto;'> ..</button>
                    <div class='divBOX'>Choix / Réponse 8:<br>
                        <span style='vertical-align:center;font-size:0.8em;'>FR:</span><input id='lnCHOICE8' type='text' value='" . $row["choice_name8"] . "' onclick='detectCLICK(event,this);' style='width:70%;'>";
                        if ($CIE_DEEPL_KEY != ""){ echo "<button onclick=\"dw3_translate('lnCHOICE8','fr','en','lnCHOICE8_EN');\" style='padding:4px;'><span class='material-icons' style='font-size:12px;'>translate</span>FR->EN</button>"; }
                        echo "<br><span style='vertical-align:center;font-size:0.8em;'>EN:</span><input id='lnCHOICE8_EN' type='text' value='" . $row["choice_name8_en"] . "' onclick='detectCLICK(event,this);' style='width:70%;'>";
                        if ($CIE_DEEPL_KEY != ""){ echo "<button onclick=\"dw3_translate('lnCHOICE8_EN','en','fr','lnCHOICE8');\" style='padding:4px;'><span class='material-icons' style='font-size:12px;'>translate</span>EN->FR</button>"; }
                        echo "</div>
                    <div class='divBOX'>Valeur de la réponse 8:
                        <input id='lnVALUE8' style='width:100px;' type='number' value='" . $row["choice_value8"] . "' onclick='detectCLICK(event,this);'>
                    </div>
                    <div class='divBOX' style='display:none;'>Image de la réponse 8:
                        <input id='lnIMG8' style='width:100px;' type='text' value='" . $row["choice_img8"] . "'>
                    </div>
                    <hr>
                    <button style='min-width:50px;' onclick='selIMG(9);'><img id='imgIMG9' src='/pub/upload/". $row["choice_img9"]."' style='width:100px;height:auto;'> ..</button>
                    <div class='divBOX'>Choix / Réponse 9:<br>
                        <span style='vertical-align:center;font-size:0.8em;'>FR:</span><input id='lnCHOICE9' type='text' value='" . $row["choice_name9"] . "' onclick='detectCLICK(event,this);' style='width:70%;'>";
                        if ($CIE_DEEPL_KEY != ""){ echo "<button onclick=\"dw3_translate('lnCHOICE9','fr','en','lnCHOICE9_EN');\" style='padding:4px;'><span class='material-icons' style='font-size:12px;'>translate</span>FR->EN</button>"; }
                        echo "<br><span style='vertical-align:center;font-size:0.8em;'>EN:</span><input id='lnCHOICE9_EN' type='text' value='" . $row["choice_name9_en"] . "' onclick='detectCLICK(event,this);' style='width:70%;'>";
                        if ($CIE_DEEPL_KEY != ""){ echo "<button onclick=\"dw3_translate('lnCHOICE9_EN','en','fr','lnCHOICE9');\" style='padding:4px;'><span class='material-icons' style='font-size:12px;'>translate</span>EN->FR</button>"; }
                        echo "</div>
                    <div class='divBOX'>Valeur de la réponse 9:
                        <input id='lnVALUE9' style='width:100px;' type='number' value='" . $row["choice_value9"] . "' onclick='detectCLICK(event,this);'>
                    </div>
                    <div class='divBOX' style='display:none;'>Image de la réponse 9:
                        <input id='lnIMG9' style='width:100px;' type='text' value='" . $row["choice_img9"] . "'>
                    </div>
                    <hr>
                    <button style='min-width:50px;' onclick='selIMG(0);'><img id='imgIMG0' src='/pub/upload/". $row["choice_img0"]."' style='width:100px;height:auto;'> ..</button>
                    <div class='divBOX'>Choix / Réponse 10:<br>
                         <span style='vertical-align:center;font-size:0.8em;'>FR:</span><input id='lnCHOICE0' type='text' value='" . $row["choice_name0"] . "' onclick='detectCLICK(event,this);' style='width:70%;'>";
                        if ($CIE_DEEPL_KEY != ""){ echo "<button onclick=\"dw3_translate('lnCHOICE0','fr','en','lnCHOICE0_EN');\" style='padding:4px;'><span class='material-icons' style='font-size:12px;'>translate</span>FR->EN</button>"; }
                        echo "<br><span style='vertical-align:center;font-size:0.8em;'>EN:</span><input id='lnCHOICE0_EN' type='text' value='" . $row["choice_name0_en"] . "' onclick='detectCLICK(event,this);' style='width:70%;'>";
                        if ($CIE_DEEPL_KEY != ""){ echo "<button onclick=\"dw3_translate('lnCHOICE0_EN','en','fr','lnCHOICE0');\" style='padding:4px;'><span class='material-icons' style='font-size:12px;'>translate</span>EN->FR</button>"; }
                        echo "</div>
                    <div class='divBOX'>Valeur de la réponse 10:
                        <input id='lnVALUE0' style='width:100px;' type='number' value='" . $row["choice_value0"] . "' onclick='detectCLICK(event,this);'>
                    </div>
                    <div class='divBOX' style='display:none;'>Image de la réponse 10:
                        <input id='lnIMG0' style='width:100px;' type='text' value='" . $row["choice_img0"] . "'>
                    </div>
                    ";
		}
	}

    echo "</table>";
    echo "<br><br></div><div class='dw3_form_foot'>
        <button class='red' onclick='deleteLINE(\"" .$ID . "\");'><span class='material-icons'>delete</span></button>
        <button class='grey' onclick='closeEDIT_LINE();'><span class='material-icons'>cancel</span> " . $dw3_lbl["CANCEL"] . "</button>
        <button class='green' onclick='updLINE(\"" . $ID . "\");'><span class='material-icons'>save</span>" . $dw3_lbl["SAVE"] . "</button>
    </div>";
    $dw3_conn->close();
?>