<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$clID  = $_GET['clID'];
$text_width  = $_GET['tw'];

	$sql = "SELECT * FROM customer WHERE id = " . $clID . " LIMIT 1";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {	
		while($row = $result->fetch_assoc()) {
			if 	($row["gender"] =="F"){ $sexcolor = "box-shadow: rgba(245, 202, 245, 0.85) 0px 5px 5px;"; } else { $sexcolor = "box-shadow: rgba(202, 202, 245, 0.85) 0px 5px 5px;"; }
			echo "<div id='divEDIT_HEADER' class='dw3_form_head'>
                    <h3>Modification du client #". $row["id"] ."</h3>";
                    echo "<button class='grey' style='top:0px;right:0px;padding:4px;position:absolute;' onclick='closeEDITOR(this);'><span class='material-icons'>cancel</span></button>";
                echo "</div>";
                if ($CIE_GMAP_KEY!=""){
                    echo "<div style='background:#F0F0F0;position:absolute;top:200px;left:0px;right:0px;bottom:50px;overflow-x:hidden;overflow-y:auto;'>";
                } else {
                    echo "<div style='background:#F0F0F0;position:absolute;top:50px;left:0px;right:0px;bottom:50px;overflow-x:hidden;overflow-y:auto;'>";
                }
                if ($APREAD_ONLY == false) { 
                    if ($row["pw"]==""){
                        echo "<button onclick=\"initPW('".$row["id"]."');\"><span class='material-icons'>password</span> Envoyer un courriel pour initialiser le mot de passe</button><hr>";
                    } else {
                        echo "<button onclick=\"resetPW('".$row["id"]."');\"><span class='material-icons'>password</span> Envoyer un courriel pour réinitialiser le mot de passe</button><hr>";
                    }
                }
//INFOS GÉNÉRALES
                echo "<h4 onclick=\"toggleFolder('divSubCli1','Cliup1');\" style=\"background: rgba(255, 255, 255, 0.7);color:#333;text-shadow:none;text-align:left;padding:5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;text-shadow:none;border-bottom: 1mm ridge rgba(127, 127, 127, .6);\">
                        <span id='Cliup1' class=\"material-icons\">folder</span> Informations générales
                    </h4>
                    <div class=\"divMAIN\" id='divSubCli1' style='padding-top:0px;transition: height 1.5s;height:0px;display:none;'>";
                        echo "<div class='divBOX'># de client:
                            <input disabled id='clID' type='text' value='" . strrev(chunk_split(strrev(str_pad($row["id"], 9, '0', STR_PAD_LEFT)),3, ' ')) . "'>
                            <input disabled style='display:none;' id='customer_id' type='text' value='" . $row["id"] . "'>
                        </div>
                        <div class='divBOX'># Stripe:";
                        if ($row["stripe_id"] == "" && $CIE_STRIPE_KEY != ""){
                            echo "<button style='float:right;' onclick=\"addToSTRIPE('".$row["id"]."');\">Lier à Stripe</button>";
                        }
                            echo "<input disabled id='clSTRIPE_ID' type='text' value='" . $row["stripe_id"] . "'>
                        ";

                        echo "</div><div class='divBOX'>" . $dw3_lbl["STAT"] . ":
                            <select name='clSTAT' id='clSTAT'>
                                <option value='0'"; if 	($row["stat"] =="0"){ echo " selected"; } echo ">Actif</option>
                                <option value='1'"; if 	($row["stat"] =="1"){ echo " selected"; } echo ">Inactif</option>
                                <option value='2'"; if 	($row["stat"] =="2"){ echo " selected"; } echo ">Suspendu</option>
                                <option value='3'"; if 	($row["stat"] =="3"){ echo " selected"; } echo ">Banni</option>
                            </select>
                        </div>
                        <div class='divBOX'>Type de facturation:
                            <select name='clTYPE' id='clTYPE'>
                                <option value='PARTICULAR'";  if 	($row["type"] =="PARTICULAR"||$row["type"] ==""){ echo " selected"; } echo ">Particuliers</option>
                                <option value='COMPANY'"; if 	($row["type"] =="COMPANY"){ echo " selected"; } echo ">Compagnie</option>
                                <option value='RETAILER'"; if 	($row["type"] =="RETAILER"){ echo " selected"; } echo ">Détaillant / Succursale / Franchise</option>
                                <option value='INTERNAL'"; if 	($row["type"] =="INTERNAL"){ echo " selected"; } echo ">Interne (table, caisse, pos..)</option>
                            </select>
                        </div>";
                        echo "<div class='divBOX'>Crédit/Solde au compte:
                            <span id='balanceSpan' style='float:right;";if($row["balance"]<0){echo "color:red;";}else{echo "color:green;";} echo"'>$" . $row["balance"] . "</span>";
                            if ($APREAD_ONLY == false) { echo "<button id='balanceButton' "; if ($row["balance"]<=0){echo " disabled";} echo " onclick='sendCreditPayment(" . $row["id"] . ")'>Envoyer une confirmation de paiement le prochain jour ouvrable et remettre la balance à $0.00</button>";}
                            echo "<span style='font-size:13px;'>Dernière balance enregistrée: <span id='balanceBefore'>$".$row["balance_before"]."</span></span>
                        </div>
                        <div class='divBOX'>Magasin préféré:
                        <select id='clLOC'>";
                            $sql2 = "SELECT * FROM location WHERE stat='0' ORDER BY name";
                            $result2 = $dw3_conn->query($sql2);
                            echo "<option value='' selected disabled>Veuillez choisir un emplacement.</option>";
                            if ($result2->num_rows > 0) {	
                                while($row2 = $result2->fetch_assoc()) {
                                    if ($row2["id"] == $row["location_id"]){ $strTMP = " selected"; } else {$strTMP = " "; }
                                    echo "<option value='". $row2["id"] . "' " . $strTMP . ">"	. $row2["name"] . "</option>";
                                }
                            }
                        echo "</select></div>
                        <div class='divBOX' style='display:none;'><br>" . $dw3_lbl["PREFIX"] . ":
                            <input id='clPREFIX' type='text' value='" . htmlspecialchars($row["prefix"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);' style='". $sexcolor . "'>
                        </div>	
                        <div class='divBOX'><br>" . $dw3_lbl["FNAM"] . ":
                            <input id='clPRENOM' type='text' value='" . dw3_decrypt($row["first_name"]) . "' onclick='detectCLICK(event,this);' style='". $sexcolor . "'>
                        </div>	
                        <div class='divBOX' style='display:none;'><br>" . $dw3_lbl["MNAM"] . ":
                            <input id='clPRENOM2' type='text' value='" . htmlspecialchars(dw3_decrypt($row["middle_name"]), ENT_QUOTES) . "' onclick='detectCLICK(event,this);' style='". $sexcolor . "'>
                        </div>				
                        <div class='divBOX'>Nom:
                            <input id='clNOM' type='text' value='" . str_replace("'", "\'", htmlspecialchars(dw3_decrypt($row["last_name"]), ENT_QUOTES)) . "' onclick='detectCLICK(event,this);' style='". $sexcolor . "'>
                        </div>	
                        <div class='divBOX'>Compagnie:
                            <input id='clCIE' type='text' value='" . str_replace("'", "\'", htmlspecialchars($row["company"], ENT_QUOTES)) . "' onclick='detectCLICK(event,this);' style='". $sexcolor . "'>
                        </div>	
                        <div class='divBOX' style='display:none;'><br>" . $dw3_lbl["SUFFIX"] . ":
                            <input id='clSUFFIX' type='text' value='" . htmlspecialchars($row["suffix"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);' style='". $sexcolor . "'>
                        </div>	
                                            <div class='divBOX'>" . $dw3_lbl["TEL1"] . ":<a href='tel:". dw3_decrypt($row["tel1"]) . "' target='_blank'> <span class='material-icons' style='float:right;text-shadow:0px 0px 3px #" . $CIE_COLOR1 . ";'>call</span></a>
                            <input id='clTEL1' type='text' value='" . dw3_decrypt($row["tel1"]) . "' onclick='detectCLICK(event,this);'>
                        </div>
                        <div class='divBOX'>" . $dw3_lbl["TEL2"] . ":<a href='tel:". dw3_decrypt($row["tel2"]) . "' target='_blank'> <span class='material-icons' style='float:right;text-shadow:0px 0px 3px #" . $CIE_COLOR1 . ";'>call</span></a>
                            <input id='clTEL2' type='text' value='" . dw3_decrypt($row["tel2"]) . "' onclick='detectCLICK(event,this);'>
                        </div>
                        <div class='divBOX'>" . $dw3_lbl["EML1"] . ":<a href='mailto:". dw3_decrypt($row["eml1"]) . "' target='_blank'> <span class='material-icons' style='float:right;text-shadow:0px 0px 3px #" . $CIE_COLOR1 . ";'>contact_mail</span></a>
                            <input id='clEML1' type='text' value='" . dw3_decrypt($row["eml1"]) . "' onclick='detectCLICK(event,this);' style='". $sexcolor . "'>
                        </div>
                        <div class='divBOX'>" . $dw3_lbl["EML2"] . ":<a href='mailto:". dw3_decrypt($row["eml2"]) . "' target='_blank'> <span class='material-icons' style='float:right;text-shadow:0px 0px 3px #" . $CIE_COLOR1 . ";'>contact_mail</span></a>
                            <input id='clEML2' type='text' value='" . dw3_decrypt($row["eml2"]) . "' onclick='detectCLICK(event,this);' style='". $sexcolor . "'>
                        </div>
                        <div class='divBOX'>Site Web:<a href='". $row["web"] . "' target='_blank'> <span class='material-icons' style='float:right;text-shadow:0px 0px 3px #" . $CIE_COLOR1 . ";'>http</span></a>
                            <input id='clWEB' type='text' value='" . $row["web"] . "' onclick='detectCLICK(event,this);'>
                        </div>
                        <div class='divBOX'>" . $dw3_lbl["LANG"]. ":
                            <select name='clLANG' id='clLANG'>
                                <option value='FR'"; if 	($row["lang"] =="FR"){ echo " selected"; } echo ">FR</option>
                                <option value='EN'"; if 	($row["lang"] =="EN"){ echo " selected"; } echo ">EN</option>
                                <option value='ES'"; if 	($row["lang"] =="ES"){ echo " selected"; } echo ">ES</option>
                            </select>
                        </div>
                        <div class='divBOX'>" . $dw3_lbl["SEXE"] . ":
                                <select name='clSEXE' id='clSEXE' style='". $sexcolor . "'>
                                    <option value='M'"; if 	($row["gender"] =="M"){ echo " selected"; } echo ">M</option>
                                    <option value='F'"; if 	($row["gender"] =="F"){ echo " selected"; } echo ">F</option>
                                    <option value=''"; if 	($row["gender"] ==""){ echo " selected"; } echo ">Undefined</option>
                                </select>
                        </div>
                        <div class='divBOX'>Escomptes par fournisseur: ";
                        if ($APREAD_ONLY == false) {echo "<button style='padding:5px;float:right;' onclick=\"newDISCOUNT('".$row["id"]."')\"> + Ajouter</button>";}
                            echo "<div id='divCUSTOMER_DISCOUNT'>
                            <table class='tblSEL'>";
                                $sql2 = "SELECT A.*, IFNULL(B.company_name,'-') as company_name FROM customer_discount A LEFT JOIN (SELECT id AS sid, company_name FROM supplier) B ON A.supplier_id = B.sid WHERE customer_id='".$row["id"]."' ORDER BY escount_pourcent DESC";
                                $result2 = $dw3_conn->query($sql2);
                                //echo "<option disabled>Administrateurs</option>";
                                if ($result2->num_rows > 0) {	
                                    echo "<tr><th>%</th><th style='font-size:10px;'>Fournisseur de produit</th></tr>";
                                    //echo "<tr><th>%</th><th style='font-size:10px;'>ID Fournisseur</th><th style='font-size:10px;'>ID Produit</th><th style='font-size:10px;'>ID Catégorie</th></tr>";
                                    while($row2 = $result2->fetch_assoc()) {
                                        //if ($row2["supplier_id"] == "0"){$supplier_id = "-";} else {$supplier_id = $row2["supplier_id"];}
                                        //if ($row2["category_id"] == "0"){$category_id = "-";} else {$category_id = $row2["category_id"];}
                                        //if ($row2["product_id"] == "0"){$product_id = "-";} else {$product_id = $row2["product_id"];}
                                        //echo "<tr onclick=\"getDISCOUNT('". $row2["id"] . "','".$row["id"]."')\"><td>"	. $row2["escount_pourcent"] . "%</td><td>"	. $supplier_id . "</td><td>"	. $product_id . "</td><td>"	. $category_id . "</td></tr>";
                                        echo "<tr onclick=\"getDISCOUNT('". $row2["id"] . "','".$row["id"]."')\"><td>"	. $row2["escount_pourcent"] . "%</td><td>"	. $row2["company_name"] . "</td></tr>";
                                    }
                                } else {
                                    echo "<tr><td style='font-size:10px;'>Aucune escompte trouvée pour ce client</td></tr>";
                                }
//ADRESSES
                        echo "</table></div></div>
                        <h2>Adresse de facturation</h2>			
                        <div class='divBOX'>" . $dw3_lbl["ADR1"] . ":
                            <input id='clADR1' type='text' value='" . htmlspecialchars(dw3_decrypt($row["adr1"]), ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                        </div>				
                        <div class='divBOX'>" . $dw3_lbl["ADR2"] . ":
                            <input id='clADR2' type='text' value='" . htmlspecialchars(dw3_decrypt($row["adr2"]), ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                        </div>				
                        <div class='divBOX'>" . $dw3_lbl["VILLE"] . ":
                            <input id='clVILLE' type='text' class='dropbox' value='" . htmlspecialchars($row["city"], ENT_QUOTES) . "' >
                        </div>				
                        <div class='divBOX'>" . $dw3_lbl["PROV"] . ":
                            <select id='clPROV'>
                                <option "; if ($row["province"] == "AB"){echo "selected";} echo " value='AB'>Alberta</option>
                                <option "; if ($row["province"] == "BC"){echo "selected";} echo " value='BC'>Colombie-Britannique</option>
                                <option "; if ($row["province"] == "PE"){echo "selected";} echo " value='PE'>Île-du-Prince-Édouard</option>
                                <option "; if ($row["province"] == "MB"){echo "selected";} echo " value='MB'>Manitoba</option>
                                <option "; if ($row["province"] == "NB"){echo "selected";} echo " value='NB'>Nouveau-Brunswick</option>
                                <option "; if ($row["province"] == "NS"){echo "selected";} echo " value='NS'>Nouvelle-Écosse</option>
                                <option "; if ($row["province"] == "NU"){echo "selected";} echo " value='NU'>Nunavut</option>
                                <option "; if ($row["province"] == "ON"){echo "selected";} echo " value='ON'>Ontario</option>
                                <option "; if ($row["province"] == "QC" || $row["province"] == "Québec" || $row["province"] == "Quebec"){echo "selected";} echo " value='QC'>Québec</option>
                                <option "; if ($row["province"] == "SK"){echo "selected";} echo " value='SK'>Saskatchewan</option>
                                <option "; if ($row["province"] == "NL"){echo "selected";} echo " value='NL'>Terre-Neuve-et-Labrador</option>
                                <option "; if ($row["province"] == "NT"){echo "selected";} echo " value='NT'>Territoires du Nord-Ouest</option>
                                <option "; if ($row["province"] == "YT"){echo "selected";} echo " value='YT'>Yukon</option>
                            </select>
                        </div>				
                        <div class='divBOX'>" . $dw3_lbl["PAYS"] . ":
                            <input id='clPAYS' disabled type='text' value='" . htmlspecialchars($row["country"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                        </div>				
                        <div class='divBOX'>" . $dw3_lbl["CP"] . ":
                            <input id='clCP' type='text' value='" . htmlspecialchars($row["postal_code"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                        </div>
                        <h2>Adresse d'expédition</h2>";
                        if ($APREAD_ONLY == false) {echo "<button onclick='copyADR_TO_SH();'>Même adresse que la facturation</button>";}
                        echo "<br><div class='divBOX'>" . $dw3_lbl["ADR1"] . ":
                            <input id='clADR1_SH' type='text' value='" . htmlspecialchars(dw3_decrypt($row["adr1_sh"]), ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                        </div>				
                        <div class='divBOX'>" . $dw3_lbl["ADR2"] . ":
                            <input id='clADR2_SH' type='text' value='" . htmlspecialchars(dw3_decrypt($row["adr2_sh"]), ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                        </div>				
                        <div class='divBOX'>" . $dw3_lbl["VILLE"] . ":
                            <input id='clVILLE_SH' type='text' class='dropbox' value='" . htmlspecialchars($row["city_sh"], ENT_QUOTES) . "' >
                        </div>				
                        <div class='divBOX'>" . $dw3_lbl["PROV"] . ":
                            <select id='clPROV_SH'>
                                <option "; if ($row["province_sh"] == "AB"){echo "selected";} echo " value='AB'>Alberta</option>
                                <option "; if ($row["province_sh"] == "BC"){echo "selected";} echo " value='BC'>Colombie-Britannique</option>
                                <option "; if ($row["province_sh"] == "PE"){echo "selected";} echo " value='PE'>Île-du-Prince-Édouard.</option>
                                <option "; if ($row["province_sh"] == "MB"){echo "selected";} echo " value='MB'>Manitoba</option>
                                <option "; if ($row["province_sh"] == "NB"){echo "selected";} echo " value='NB'>Nouveau-Brunswick</option>
                                <option "; if ($row["province_sh"] == "NS"){echo "selected";} echo " value='NS'>Nouvelle-Écosse</option>
                                <option "; if ($row["province_sh"] == "NU"){echo "selected";} echo " value='NU'>Nunavut</option>
                                <option "; if ($row["province_sh"] == "ON"){echo "selected";} echo " value='ON'>Ontario</option>
                                <option "; if ($row["province_sh"] == "QC" || $row["province_sh"] == "Québec" || $row["province_sh"] == "Quebec"){echo "selected";} echo " value='QC'>Québec</option>
                                <option "; if ($row["province_sh"] == "SK"){echo "selected";} echo " value='SK'>Saskatchewan</option>
                                <option "; if ($row["province_sh"] == "NL"){echo "selected";} echo " value='NL'>Terre-Neuve-et-Labrador</option>
                                <option "; if ($row["province_sh"] == "NT"){echo "selected";} echo " value='NT'>Territoires du Nord-Ouest</option>
                                <option "; if ($row["province_sh"] == "YT"){echo "selected";} echo " value='YT'>Yukon</option>
                            </select>
                        </div>				
                        <div class='divBOX'>" . $dw3_lbl["PAYS"] . ":
                            <input id='clPAYS_SH' type='text' value='" . htmlspecialchars($row["country_sh"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                        </div>				
                        <div class='divBOX'>" . $dw3_lbl["CP"] . ":
                            <input id='clCP_SH' type='text' value='" . htmlspecialchars($row["postal_code_sh"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                        </div>                    
                        <div class='divBOX' style='width:97%;max-width:100%;'>" . $dw3_lbl["NOTE"] . ":
                            <textarea style='height:100px;width:100%;". $sexcolor . "' id='clNOTE'>" . $row["note"] . "</textarea>
                        </div>
                        <br><br>
                        <div class='divBOX'>" . $dw3_lbl["LNG"] . ":
                            <input id='clLNG' type='text' value='" . $row["longitude"] . "' onclick='detectCLICK(event,this);'>
                        </div>
                        <div class='divBOX'>" . $dw3_lbl["LAT"] . ":";
                        if ($APREAD_ONLY == false) {echo "<span onclick='getLngLat2()' class='material-icons' style='float:right;text-shadow:0px 0px 3px #" . $CIE_COLOR1 . ";cursor:pointer;'>share_location</span>";}
                            echo "<input id='clLAT' type='text' value='" . $row["latitude"] . "' onclick='detectCLICK(event,this);'>
                        </div>			
                        <div class='divBOX'>" . $dw3_lbl["DTAD"] . ":
                            <input id='clDTAD' type='text' value='" . $row["date_created"] . "' disabled'>
                        </div>			
                        <div class='divBOX'>" . $dw3_lbl["DTMD"] . ":
                            <input id='clDTMD' type='text' value='" . $row["date_modified"] . "' disabled'>
                        </div>
                    </div>";
//DOCUMENTS
                echo "<h4 onclick=\"toggleFolder('divSubCli0','Cliup0');\" style=\"background: rgba(255, 255, 255, 0.7);color:#333;text-shadow:none;text-align:left;padding:5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;text-shadow:none;border-bottom: 1mm ridge rgba(127, 127, 127, .6);\">
                    <span id='Cliup0' class=\"material-icons\">folder</span> Documents
                </h4>
                <div class=\"divMAIN\" id='divSubCli0' style='padding-top:0px;transition: height 1.5s;height:0px;display:none;'>";
                if ($APREAD_ONLY == false) {
                    if ($USER_LANG == "FR"){ 
                        echo "<button class='blue' onclick=\"document.getElementById('fileToUpload0').click();\"><span class='dw3_font'>5</span> Téléverser un fichier</button>";
                    } else {
                        echo "<button class='blue' onclick=\"document.getElementById('fileToUpload0').click();\"><span class='dw3_font'>5</span> Upload a file</button>";
                    }
                }
                echo "<hr>";
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/fs/customer/'.$clID)){
                    $dir = new RecursiveDirectoryIterator($_SERVER['DOCUMENT_ROOT'] . '/fs/customer/'.$clID);
                    $files = new RecursiveIteratorIterator($dir);
                    foreach($files as $file){
                        //$fn=basename($file->getFileName(), ".pdf");
                        $fn=basename($file->getFileName());
                        $file_wpath=$_SERVER['DOCUMENT_ROOT'] . '/fs/customer/'.$clID.'/'.$fn;
                        $file_ppath= '/fs/customer/'.$clID.'/'.$fn;
                        if ($fn!="." && $fn!=".."){
                            $daFileType = strtolower(pathinfo($file_wpath,PATHINFO_EXTENSION));
                            $file_size = filesize($file_wpath);
                            if ($file_size <= 1024){ 
                            $file_size = $file_size . " bytes";
                            }else if ($file_size >= 1048576){
                                $file_size = round(($file_size/1024)/1024,2) . "MB";
                            } else {
                                $file_size = round($file_size/1024) . "KB";
                            }
                            if (strlen($fn) > 30){
                                $fn_txt = substr($fn,0,26) . ".." . substr($fn,4);
                            } else {
                                $fn_txt = substr($fn,0,30);
                            }
                            echo "<div class='divBOX' style='height:auto;background:rgba(255,255,255,0.7);color:#222;margin:12px;border-radius:7px;text-align:center;'>";
                            if ($USER_LANG == "FR"){ 
                                echo "<table class='tblDATA'>
                                        <tr><td>Fichier</td><td  style='white-space: normal;text-align:left;'><b>". $fn_txt ."</b></td></tr>
                                        <tr><td>Taille</td><td style='text-align:right;'><b>". $file_size."</b></td></tr>
                                        <tr><td>Date modifié</td><td style='text-align:center;'><b>". date("Y-m-d", filemtime($file_wpath))."</b></td></tr>";
                                echo "</table>";
                            }else{
                                echo "<table class='tblDATA'>
                                        <tr><td>Filename</td><td  style='white-space: normal;text-align:left;'><b>". $fn_txt ."</b></td></tr>
                                        <tr><td>Size</td><td style='text-align:right;'><b>". $file_size."</b></td></tr>
                                        <tr><td>Modified date</td><td style='text-align:center;'><b>". date("Y-m-d", filemtime($file_wpath))."</b></td></tr>";
                                echo "</table>";
                        }
                            echo "<button class='red' onclick=\"deleteFILE('".$fn."','".$clID."');\" style='float:left;'><span class='material-icons'>delete</span></button>";
                            if($daFileType == "jpg" || $daFileType == "png" || $daFileType == "jpeg" || $daFileType == "gif" || $daFileType == "svg" || $daFileType == "tiff" || $daFileType == "bmp" || $daFileType == "webp" || $daFileType == "avif" || $daFileType == "ico" || $daFileType == "apng" ) {
                                echo "<img src='".$file_ppath."' style='height:50px;width:auto;max-width:150px;'>";
                            } else if ($daFileType == "pdf"){
                                echo "<span class='material-icons' style='font-size:50px;'>picture_as_pdf</span>";
                            } else {
                                echo "<span class='material-icons' style='font-size:50px;'>description</span>";
                            }
                            echo "<button onclick=\"dw3_secure_download('/fs/customer/".$clID."/".$fn."');\" style='float:right;'><span class='material-icons'>cloud_download</span></button>";
                            echo "</div>";
                        }
                    }
                }
                $sqlr = "SELECT A.*, B.name_fr as name_fr, B.description_fr as description_fr, B.total_type AS total_type, B.total_max AS total_max, B.next_id AS next_id , B.allow_user_reedit AS allow_user_reedit , B.allow_user_view AS allow_user_view 
                FROM prototype_report A
                LEFT JOIN prototype_head B ON B.id = A.head_id
                WHERE A.parent_id = '" . $clID . "' AND allow_user_view='1' ORDER BY A.date_completed DESC";
                $resultr = $dw3_conn->query($sqlr);
                $QTY_ROWS = $resultr->num_rows??0;
                if ($QTY_ROWS > 0) { 
                    while($rowr = $resultr->fetch_assoc()) {
                        echo "<div class='divBOX' style='height:auto;background:rgba(255,255,255,0.7);color:#222;margin:12px;border-radius:7px;'>";
                        if ($USER_LANG == "FR"){ 
                            echo "<table class='tblDATA'>
                                        <tr><td>Formulaire</td><td  style='white-space: normal;text-align:left;'><b>". $rowr["name_fr"] ."</b></td></tr>
                                        <tr><td>Description</td><td style='white-space: normal;text-align:left;font-size:0.7em;'><b>". $rowr["description_fr"] ."</b></td></tr>
                                        <tr><td>Date complété</td><td style='text-align:center;'><b>". substr($rowr["date_completed"],0,10) ."</b></td></tr>";
            /*                         if ($row["total_type"]=="POINTS"){
                                        echo "<tr><td>Total</td><td style='text-align:right;'><b>". number_format($row["result"],0). "</b></td></tr>";
                                    } else if ($row["total_type"]=="CASH"){
                                        echo "<tr><td>Total</td><td style='text-align:right;'><b>". number_format($row["result"],2,"."," "). "</b>$</td></tr>";
                                    } else if ($row["total_type"]=="POURCENT"){
                                        echo "<tr><td>Total</td><td style='text-align:right;'><b>". number_format($row["result"],0). "</b>%</td></tr>";
                                    } */
                                    echo "</table>";
                        }else{
                            echo "<table class='tblDATA'>
                                        <tr><td>Document</td><td  style='white-space: normal;text-align:left;'><b>". $rowr["name_fr"] ."</b></td></tr>
                                        <tr><td>Description</td><td style='white-space: normal;text-align:left;font-size:0.7em;'><b>". $rowr["description_fr"] ."</b></td></tr>
                                        <tr><td>Date completed</td><td style='text-align:center;'><b>". substr($rowr["date_completed"],0,10) ."</b></td></tr>";
            /*                         if ($row["total_type"]=="POINTS"){
                                        echo "<tr><td>Total</td><td style='text-align:right;'><b>". number_format($row["result"],0). "</b></td></tr>";
                                    } else if ($row["total_type"]=="CASH"){
                                        echo "<tr><td>Total</td><td style='text-align:right;'><b>". number_format($row["result"],2,"."," "). "</b>$</td></tr>";
                                    } else if ($row["total_type"]=="POURCENT"){
                                        echo "<tr><td>Total</td><td style='text-align:right;'><b>". number_format($row["result"],0). "</b>%</td></tr>";
                                    } */
                                    echo "</table>";
                                    //if ()
                        }
                        echo "</div>";
                    }
                    } else {
                        echo "<div class='divBOX' style='text-align:center;'>"; if ($USER_LANG == "FR"){ echo "Aucun document dans le dossier."; }else{echo "No document found.";} echo "</div>";            
                    }
                echo "</div>";
//SUIVI D'APPEL & EVENEMENTS
                echo "<h4 onclick=\"toggleFolder('divSubCli2','Cliup2');\" style=\"background: rgba(255, 255, 255, 0.7);color:#333;text-shadow:none;text-align:left;padding:5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;text-shadow:none;border-bottom: 1mm ridge rgba(127, 127, 127, .6);\">
                    <span id='Cliup2' class=\"material-icons\">folder</span> Suivi d'appels & Évènements
                </h4>
                <div class=\"divMAIN\" id='divSubCli2' style='padding-top:0px;transition: height 1.5s;height:0px;display:none;'>";
                if ($APREAD_ONLY == false) {
                    echo "<button class='red' style='margin:5px;padding:6px;float:right;' onclick=\"newEVENT('PRIVACY_INCIDENT');\"><span class='material-icons'>add</span> Incident </button>
                    <button class='orange' style='margin:5px;padding:6px;float:right;' onclick=\"newEVENT('COMPLAINT');\"><span class='material-icons'>add</span> Plainte </button>
                    <button class='blue' style='margin:5px;padding:6px;float:right;' onclick=\"newEVENT('CALL_TECH');\"><span class='material-icons'>add</span> Support </button>
                    <button class='green' style='margin:5px;padding:6px;float:right;' onclick=\"newEVENT('CALL_INFO');\"><span class='material-icons'>add</span> Appel </button>";
                }
                echo "<br><div id='divEVENTS'></div></div>";
//RENDEZ-VOUS
                echo "<h4 onclick=\"toggleFolder('divSubCli3','Cliup3');\" style=\"background: rgba(255, 255, 255, 0.7);color:#333;text-shadow:none;text-align:left;padding:5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;text-shadow:none;border-bottom: 1mm ridge rgba(127, 127, 127, .6);\">
                    <span id='Cliup3' class=\"material-icons\">folder</span> Rendez-vous
                </h4>
                <div class=\"divMAIN\" id='divSubCli3' style='padding-top:0px;transition: height 1.5s;height:0px;display:none;'>";
                    $sqlm = "SELECT A.id as schedule_id, A.commentaire as commentaire, A.user_id as user_id,CONCAT(D.first_name, ' ',D.last_name,' (',D.name,')') as user_name, A.customer_id, CONCAT(B.first_name, ' ',B.middle_name, ' ',B.last_name) as customer_name, A.product_id, C.name_fr as product_name,C.price1 as product_price,C.service_length as service_length,C.inter_length as inter_length, A.start_date as start_date, A.end_date as end_date, A.iso_start as iso_start, A.iso_end as iso_end
                    FROM schedule_line A
                    LEFT JOIN customer B ON B.id = A.customer_id
                    LEFT JOIN product C ON C.id = A.product_id
                    LEFT JOIN user D ON D.id = A.user_id
                    WHERE customer_id = '" . $clID . "'
                    ORDER  BY A.start_date DESC";
                        $resultm = $dw3_conn->query($sqlm);
                        echo "<table class='tblDATA'><tr><th>Quand</th><th>Avec Qui et Pourquoi</th><th>Confirmé?</th><th>Commentaire</th></tr>";
                        if ( $resultm->num_rows > 0) {
                            while($rowm = $resultm->fetch_assoc()) {
                                if ($rowm["start_date"] == "1"){
                                    $schedule_confirmed = "Oui";
                                } else {
                                    $schedule_confirmed = "Non";
                                }
                                echo "<tr><td>" . substr($rowm["start_date"],0,10)  . "<br>" . substr($rowm["start_date"],11,5)  . "-" . substr($rowm["end_date"],11,5)  . "</td><td>" . $rowm["user_name"]  . "<br>" . $rowm["product_name"]  . "</td><td style='width:25px;'>".$schedule_confirmed."</td><td style='white-space: normal;'>" . $rowm["commentaire"]  . "</td></tr>";  
                            }
                        } else{
                            echo "<tr><td colspan=4>Aucun rendez-vous trouvé.</td></tr>";
                        }
                echo "</table>";
                echo "</div>";
//OPTIONS
                echo "<h4 onclick=\"toggleFolder('divSubCli4','Cliup4');\" style=\"background: rgba(255, 255, 255, 0.7);color:#333;text-shadow:none;text-align:left;padding:5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;text-shadow:none;border-bottom: 1mm ridge rgba(127, 127, 127, .6);\">
                    <span id='Cliup4' class=\"material-icons\">folder</span> Options
                </h4>
                <div class=\"divMAIN\" id='divSubCli4' style='padding-top:0px;transition: height 1.5s;height:0px;display:none;'>";
                echo "
                    <div class='divBOX'><label for='clNEWS'>Le client veut recevoir les infolettres:</label>
                        <div style='float:right;padding-right:5px;vertical-align:middle;'>
                            <input id='clNEWS' type='checkbox' style='margin-top:5px;'"; if ($row["news_stat"] == true){echo " checked"; } echo ">
                        </div>
                    </div>			
                    <div class='divBOX'><label for='clNEWS'>Le client accepte de recevoir des sms:</label>
                        <div style='float:right;padding-right:5px;vertical-align:middle;'>
                            <input id='clSMS' type='checkbox' style='margin-top:5px;'"; if ($row["sms_stat"] == true){echo " checked"; } echo ">
                        </div>
                    </div>			
                    <div class='divBOX'><label for='clNEWS'>Autentification à deux facteurs:</label>
                        <div style='float:right;padding-right:5px;vertical-align:middle;'>
                            <input id='clTWO_FAC' type='checkbox' style='margin-top:5px;'"; if ($row["two_factor_req"] == true){echo " checked"; } echo ">
                        </div>
                    </div>	
                    <div class='divBOX'>Dernière connexion:
                        <div style='float:right;padding-right:5px;vertical-align:middle;'>
                            ".$row["last_login"]."
                        </div>
                    </div>	
                ";
                echo "</div>";
				echo "</div>
                <br><br></div><div class='dw3_form_foot'>";
				if ($APREAD_ONLY == false) { echo "<button class='red' onclick='deleteCLI(\"" . $row["id"] . "\");'><span class='material-icons'>delete</span></button>";}
				echo "<button class='grey' onclick='closeEDITOR();'><span class='material-icons'>cancel</span> " . $dw3_lbl["CLOSE"] . "</button>";
				if ($APREAD_ONLY == false) { echo "<button class='green' id='dw3_updcl_btn' onclick='updCLI(\"" . $row["id"] . "\");'><span class='material-icons'>save</span>" . $dw3_lbl["SAVE"] . "</button>";}
				echo "</div>";
		}
	
	}
$dw3_conn->close();
?>
