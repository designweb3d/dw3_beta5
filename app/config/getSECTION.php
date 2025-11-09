<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$head_id   = $_GET['ID'];
		
	$sql = "SELECT * FROM index_head WHERE id = '" . $head_id . "' LIMIT 1";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {		
		while($row = $result->fetch_assoc()) {
            $file = $_SERVER['DOCUMENT_ROOT'] . '/pub/upload/'.$row["img_url"];
            if (file_exists($file) && is_file($file)){
                $IMG_path = '/pub/upload/'.$row["img_url"];
            }else{
                $IMG_path = '/pub/img/dw3/nd.png';
            }
            if ($row["icon"]==""){
                $ICON_name = 'question_mark';
            }else{
                $ICON_name = $row["icon"];
            }

			echo "<div class='dw3_form_data' style='bottom:50px;'>";
            if ($row["target"]  =="page"){ echo "<h4>Total des visites sur cette page: <u>".$row["total_visited"]."</u></h4>"; }
            if ($row["parent_id"]  !="0"){ 
                echo '<button onclick="getSECTION(\''.$row["parent_id"].'\',\'page\');"><- Parent Page</button><hr>';
            }
            if ($row["target"]  =="page"){echo '<a href="https://'.$_SERVER['SERVER_NAME'].$row["url"].'?PID='.$head_id.'&P1='.$row["cat_list"].'" target="_blank">https://'.$_SERVER['SERVER_NAME'].$row["url"].'?PID='.$head_id.'&P1='.$row["cat_list"].'</a><hr>';}
//TITRE
                    echo"<h3>TITRE & ICONE</h3>";
                    echo "<div class='divBOX'>Titre FR:";
                    if ($CIE_DEEPL_KEY != ""){ echo "<button style='float:right;padding:4px 8px;' onclick=\"dw3_translate(encodeURIComponent('idhTITLE'),'fr','en','idhTITLE_EN');\"><span class='material-icons' style='font-size:12px;'>translate</span> fr->en</button>";}
                        echo "<input id='idhTITLE' type='text' value='".$row["title"]."' onclick='detectCLICK(event,this);' oninput='section_updated = true;'>
                        <hr>Titre EN:";
                        if ($CIE_DEEPL_KEY != ""){ echo "<button style='float:right;padding:4px 8px;' onclick=\"dw3_translate(encodeURIComponent('idhTITLE_EN'),'en','fr','idhTITLE');\"><span class='material-icons' style='font-size:12px;'>translate</span> en->fr</button>";}
                            echo "<input id='idhTITLE_EN' type='text' value='".$row["title_en"]."' onclick='detectCLICK(event,this);' oninput='section_updated = true;'>
                        <div style='"; if ($row["target"]  != "section" || substr($row["url"],0,16)  == "/pub/section/sub"){ echo " display:none;"; } echo "'><hr>Affichage du titre:
                            <select name='idhTITLE_DSP' id='idhTITLE_DSP' style='width:50%;float:right;' onchange='section_updated = true;'>
                                <option value='none'"; if ($row["title_display"]  =="none"){ echo " selected"; } echo ">Ne pas afficher</option>
                                <option value='left'"; if ($row["title_display"]  =="left"){ echo " selected"; } echo ">À gauche</option>
                                <option value='center'"; if ($row["title_display"]  =="center"){ echo " selected"; } echo ">Centré</option>
                                <option value='right'"; if ($row["title_display"]  =="right"){ echo " selected"; } echo ">À droite</option>
                            </select>
                        </div>
                    </div><br>";
//ICONE
                    echo "<div class='divBOX'>
                        <div style='display:flex;width:100%;justify-content: space-around;'><div style='width:50%;'>Icone: </div><div style='width:50%;text-align:right;'><button style='padding:0px;min-width:50px;' onclick='selICON(\"idhICON\");'><span id='idhICON_SPAN' class=\"dw3_font\">" . $ICON_name . "</span> ..</button><input style='display:none;' id='idhICON' type='text' value='" . $row["icon"] . "' onclick='detectCLICK(event,this);'></div></div>
                        <hr><div style='display:flex;width:100%;justify-content: space-around;'><div style='width:50%;'>Couleur:</div><div style='width:50%;text-align:right;'><input type='color' style='width:40px;border-radius:5px;' value='" . $row["icon_color"] . "' oninput=\"document.getElementById('idhICON_COLOR').value = this.value;\"><input style='width:70%;' id='idhICON_COLOR' type='text' value='" . $row["icon_color"] . "' onclick='detectCLICK(event,this);'></div></div>
                        <hr><div style='display:flex;width:100%;justify-content: space-around;'><div style='width:50%;'>Ombre:</div><div style='width:50%;text-align:right;'><input id='idhICON_TS' type='text' value='" . $row["icon_textShadow"] . "' onclick='detectCLICK(event,this);'></div></div>";
                    echo "<select name='idhICON_DSP' id='idhICON_DSP' style='display:none;width:70%;float:right;vertical-align:middle;' onchange='section_updated = true;'>
                            <option value='none'"; if 	($row["img_display"]  =="none"){ echo " selected"; } echo ">Ne pas afficher</option>
                            <option value='menu'"; if 	($row["img_display"]  =="header"){ echo " selected"; } echo ">Menu seulement</option>
                            <option value='both'"; if 	($row["img_display"]  =="both"){ echo " selected"; } echo ">Menu & centré</option>
                            <option value='left'"; if 	($row["img_display"]  =="left"){ echo " selected"; } echo ">À gauche</option>
                            <option value='center'"; if ($row["img_display"]  =="center"){ echo " selected"; } echo ">Centré</option>
                            <option value='right'"; if 	($row["img_display"]  =="right"){ echo " selected"; } echo ">À droite</option>
                        </select>";
                    echo "</div>
                    <br>
                    <div class='divBOX' style='display:none;'>Type: //Ne peut être midifié et sera affiché dans le titre de la boite de dialogue
                            <select name='idhTARGET' id='idhTARGET' style='width:80%;float:right;vertical-align:middle;' onchange='section_updated = true;'>
                                <option value='page'"; if ($row["target"]  =="page"){ echo " selected"; } echo ">Page complète</option>
                                <option value='section'"; if ($row["target"]  =="section"){ echo " selected"; } echo ">Section de l'index</option>
                                <option value='button'"; if ($row["target"]  =="button"){ echo " selected"; } echo ">Boutton du menu</option>
                            </select>
                    </div>";
//ENTETE DE LA PAGE
					if ($row["target"]  =="page"){
                        echo"<h3>PARAMETRES DE LA PAGE</h3>";
						echo "<div class='divBOX'>Entête de page:
							<select id='idhHEADER' onchange='section_updated = true;'>
								<option "; if ($row["header_path"] == '/pub/section/header0.php') {echo 'selected';} echo " value='/pub/section/header0.php'>Minimal</option>
                                <option "; if ($row["header_path"] == '/pub/section/header9.php') {echo 'selected';} echo " value='/pub/section/header9.php'>Minimal (Flex)</option>
								<option "; if ($row["header_path"] == '/pub/section/header6.php') {echo 'selected';} echo " value='/pub/section/header6.php'>Transparent épuré</option>
								<option "; if ($row["header_path"] == '/pub/section/header13.php') {echo 'selected';} echo " value='/pub/section/header13.php'>Transparent minimal (Flex)</option>
								<option "; if ($row["header_path"] == '/pub/section/header22.php') {echo 'selected';} echo " value='/pub/section/header22.php'>Transparent (Flex)</option>
								<option "; if ($row["header_path"] == '/pub/section/header23.php') {echo 'selected';} echo " value='/pub/section/header23.php'>Transparent</option>
								<option "; if ($row["header_path"] == '/pub/section/header1.php') {echo 'selected';} echo " value='/pub/section/header1.php'>Avec entête +contact</option>
								<option "; if ($row["header_path"] == '/pub/section/header17.php') {echo 'selected';} echo " value='/pub/section/header17.php'>Avec entête défilante (Flex)</option>
								<option "; if ($row["header_path"] == '/pub/section/header2.php') {echo 'selected';} echo " value='/pub/section/header2.php'>Haut sans entête</option>
								<option "; if ($row["header_path"] == '/pub/section/header7.php') {echo 'selected';} echo " value='/pub/section/header7.php'>Haut sans entête 2</option>
								<option "; if ($row["header_path"] == '/pub/section/header10.php') {echo 'selected';} echo " value='/pub/section/header10.php'>Haut semi-transparent (Flex)</option>
								<option "; if ($row["header_path"] == '/pub/section/header11.php') {echo 'selected';} echo " value='/pub/section/header11.php'>Haut semi-transparent 2 (Flex)</option>
                                <option "; if ($row["header_path"] == '/pub/section/header14.php') {echo 'selected';} echo " value='/pub/section/header14.php'>Minimal Haut avec redimension</option>
                                <option "; if ($row["header_path"] == '/pub/section/header19.php') {echo 'selected';} echo " value='/pub/section/header19.php'>Minimal Haut avec redimension (Flex)</option>
								<option "; if ($row["header_path"] == '/pub/section/header3.php') {echo 'selected';} echo " value='/pub/section/header3.php'>Haut avec redimension +contacts</option>
								<option "; if ($row["header_path"] == '/pub/section/header20.php') {echo 'selected';} echo " value='/pub/section/header20.php'>Haut avec redimension +contacts (Flex)</option>
								<option "; if ($row["header_path"] == '/pub/section/header16.php') {echo 'selected';} echo " value='/pub/section/header16.php'>Avec redimension texte bas +contacts</option>
								<option "; if ($row["header_path"] == '/pub/section/header18.php') {echo 'selected';} echo " value='/pub/section/header18.php'>Avec redimension texte haut</option>
								<option "; if ($row["header_path"] == '/pub/section/header4.php') {echo 'selected';} echo " value='/pub/section/header4.php'>Sans redimension +contacts</option>
								<option "; if ($row["header_path"] == '/pub/section/header5.php') {echo 'selected';} echo " value='/pub/section/header5.php'>Haut avec entête</option>
								<option "; if ($row["header_path"] == '/pub/section/header21.php') {echo 'selected';} echo " value='/pub/section/header21.php'>Haut avec entête transparent</option>
								<option "; if ($row["header_path"] == '/pub/section/header8.php') {echo 'selected';} echo " value='/pub/section/header8.php'>Haut avec logo surdimensionné</option>
								<option "; if ($row["header_path"] == '/pub/section/header12.php') {echo 'selected';} echo " value='/pub/section/header12.php'>Entete de choix de location</option>
								<option "; if ($row["header_path"] == '/pub/section/header15.php') {echo 'selected';} echo " value='/pub/section/header15.php'>Dualité logo sans menu</option>
							</select>
						</div>";
//META DE LA PAGE
                        echo "<div class='divBOX'>Description META: 
                            <input id='idhMETA_DESC' type='text' value='" . $row["meta_description"] . "' oninput='section_updated = true;'>
                        </div>
                        <div class='divBOX'>Mots clés META (keywords): 
                            <input id='idhMETA_KEYW' type='text' value='" . $row["meta_keywords"] . "' oninput='section_updated = true;'>
                        </div>
                        ";
//SCENE 3D
                        if ($row["target"] =="page" && $row["url"]!="/"){ 
                            echo "<div class='divBOX'>Arrière scène (3D WebGL):
                            <select name='idhSCENE' id='idhSCENE' onchange='section_updated = true;'>";
                                echo "<option value=''"; if ($row["scene"] == '') {echo "selected";} echo ">Aucune arrière scene</option>";
                                $path = $_SERVER['DOCUMENT_ROOT'] . "/pub/scene";
                                $dirHandle = opendir($path);
                                while($item = readdir($dirHandle)) {
                                    $newPath = $path."/".$item;
                                    if(is_dir($newPath) && $item != '.' && $item != '..') {
                                        echo "<option value='".$item."'"; if ($row["scene"] == $item) {echo "selected";} echo ">".$item."</option>";
                                    }
                                }
                            echo "</select>
                                    </div>";
                        }
					}

                    echo"<h3>OPTIONS</h3>";
//AFFICHER DANS LE MENU?
                    echo "<div class='divBOX' style='"; if ($row["target"]  =="button"){ echo " display:none;"; } echo "'><label for='idhMENU'>Afficher dans le menu:</label>
                            <input id='idhMENU' type='checkbox' style='margin:5px;float:right;vertical-align:middle;' "; if($row["is_in_menu"] == "true"){echo " checked ";} echo "' oninput='section_updated = true;'>
                        </div>";
//ORDRE AU MENU ET DANS LA PAGE
                    echo "<div class='divBOX'>Ordre dans le menu / page: 
                            <input id='idhORDER' type='number' style='width:25%;float:right;vertical-align:middle;' value='" . $row["menu_order"] . "' oninput='section_updated = true;'>
                        </div>";
//URL OU FONCTION DU BOUTTON
                    echo "<div class='divBOX' style='"; if ($row["target"]  =="sub" ||$row["url"]=="/pub/page/home/index.php"){ echo " display:none;"; } echo "'>Url ou fonction du boutton: 
                            <input id='idhURL' type='text' style='' value='" .$row["url"] . "' onclick='detectCLICK(event,this);' oninput='section_updated = true;'>
                        </div>";
//POLICE
                    echo"<h3>STYLE</h3>";
                    echo "<div class='divBOX'>Police:
                        <select id='idhFONT' style='width:70%;float:right;vertical-align:middle;' onchange='section_updated = true;'>";
                        echo "<option "; if ($row["font_family"] == "Verdana") {echo "selected";} echo " value='Verdana'>Verdana (Web Safe)</option>";
                        echo "<option "; if ($row["font_family"] == "Tahoma") {echo "selected";} echo " value='Tahoma'>Tahoma (Web Safe)</option>";
                        echo "<option "; if ($row["font_family"] == "Trebuchet") {echo "selected";} echo " value='Trebuchet'>Trebuchet (Web Safe)</option>";
                        echo "<option "; if ($row["font_family"] == "Times New Roman") {echo "selected";} echo " value='Times New Roman'>Times New Roman (Web Safe)</option>";
                        echo "<option "; if ($row["font_family"] == "Georgia") {echo "selected";} echo " value='Georgia'>Georgia (Web Safe)</option>";
                        echo "<option "; if ($row["font_family"] == "Garamond") {echo "selected";} echo " value='Garamond'>Garamond (Web Safe)</option>";
                        echo "<option "; if ($row["font_family"] == "Brush Script MT") {echo "selected";} echo " value='Brush Script MT'>Brush Script MT (Web Safe)</option>";
                                $dir = new RecursiveDirectoryIterator($_SERVER['DOCUMENT_ROOT'] . '/pub/font');
                                $files = new RecursiveIteratorIterator($dir);
                                //$sorted = new ExampleSortedIterator($files);
                                foreach($files as $file){
                                    $fn=basename($file->getFileName(), ".ttf");
                                    //$fn=pathinfo($file->getFileName(), PATHINFO_FILENAME);
                                    if ($fn!="." && $fn!=".." && $fn!="dw3" && $fn!="MaterialIcons-Regular"){
                                        echo "<option "; if ($row["font_family"] == $fn || ($row["font_family"] == "" && $CIE_FONT1 == $fn)) {echo "selected";} echo " value='". $fn ."'>".$fn."</option>";
                                    }
                                }
                        echo "</select>
                    </div>";
//ANIMATION CSS DE LA SECTION
                    echo "<div class='divBOX' style='"; if ($row["target"] !="section"){ echo " display:none;"; } echo "'>Animation:
                            <select name='idhANIM' id='idhANIM' style='width:70%;float:right;vertical-align:middle;' onchange='section_updated = true;'>
                                <option value='none'"; if ($row["anim_class"]  =="none"){ echo " selected"; } echo ">Aucune animation</option>
                                <option value='translateH'"; if ($row["anim_class"]  =="translateH"){ echo " selected"; } echo ">Déplacement Hauteur</option>
                                <option value='translateH2'"; if ($row["anim_class"]  =="translateH2"){ echo " selected"; } echo ">Déplacement & Redimension</option>
                                <option value='scale3D'"; if ($row["anim_class"]  =="scale3D"){ echo " selected"; } echo ">Redimension 3D 10%</option>
                                <option value='scale3D2'"; if ($row["anim_class"]  =="scale3D2"){ echo " selected"; } echo ">Redimension 3D 20%</option>
                                <option value='scale3D3'"; if ($row["anim_class"]  =="scale3D3"){ echo " selected"; } echo ">Redimension 3D 45%</option>
                                <option value='scale3D4'"; if ($row["anim_class"]  =="scale3D4"){ echo " selected"; } echo ">Redimension 3D 90%</option>
                                <option value='scaleX'"; if ($row["anim_class"]  =="scaleX"){ echo " selected"; } echo ">Redimension Largeur 45%</option>
                                <option value='scaleX2'"; if ($row["anim_class"]  =="scaleX2"){ echo " selected"; } echo ">Redimension Largeur 90%</option>
                                <option value='scaleY'"; if ($row["anim_class"]  =="scaleY"){ echo " selected"; } echo ">Redimension Hauteur 45%</option>
                                <option value='scaleY2'"; if ($row["anim_class"]  =="scaleY2"){ echo " selected"; } echo ">Redimension Hauteur 90%</option>
                                <option value='rotate'"; if ($row["anim_class"]  =="rotate"){ echo " selected"; } echo ">Tourner Axe Z 89deg</option>
                                <option value='rotate2'"; if ($row["anim_class"]  =="rotate2"){ echo " selected"; } echo ">Tourner Axe Z 180deg</option>
                                <option value='rotate3'"; if ($row["anim_class"]  =="rotate3"){ echo " selected"; } echo ">Tourner Axe Z 360deg</option>
                                <option value='rotate4'"; if ($row["anim_class"]  =="rotate4"){ echo " selected"; } echo ">Tourner Axe X 180deg</option>
                                <option value='rotate5'"; if ($row["anim_class"]  =="rotate5"){ echo " selected"; } echo ">Tourner Axe X 360deg</option>
                                <option value='rotate6'"; if ($row["anim_class"]  =="rotate6"){ echo " selected"; } echo ">Tourner Axe X 720deg</option>
                                <option value='rotate7'"; if ($row["anim_class"]  =="rotate7"){ echo " selected"; } echo ">Tourner Axe Y 180deg</option>
                                <option value='rotate8'"; if ($row["anim_class"]  =="rotate8"){ echo " selected"; } echo ">Tourner Axe Y 360deg</option>
                                <option value='skew'"; if ($row["anim_class"]  =="skew"){ echo " selected"; } echo ">Tordu 15deg</option>
                                <option value='translateR'"; if ($row["anim_class"]  =="translateR"){ echo " selected"; } echo ">Déplacement Droite</option>
                                <option value='translateL'"; if ($row["anim_class"]  =="translateL"){ echo " selected"; } echo ">Déplacement Gauche</option>
                                <option value='opacity'"; if ($row["anim_class"]  =="opacity"){ echo " selected"; } echo ">Transparence seulement</option>
                            </select>
                    </div>";
//CSS STYLE
                    echo "<div class='divBOX' style='"; if ($row["target"] !="section" && substr($row["url"],0,16)  != "/pub/page/profil"){ echo " display:none;"; } echo "'> Marge: 
                        <input id='idhMARGIN' type='text' style='width:50%;float:right;' value='" .$row["margin"] . "' onclick='detectCLICK(event,this);' oninput='section_updated = true;'>
                    </div>
                    <div class='divBOX' style='"; if ($row["target"]  !="section" && substr($row["url"],0,16)  != "/pub/page/profil"){ echo " display:none;"; } echo "'> Largeur maximum: 
                        <input id='idhMAXW' type='text' style='width:40%;float:right;' value='" .$row["max_width"] . "' onclick='detectCLICK(event,this);' oninput='section_updated = true;'>
                    </div>
                    <div class='divBOX' style='"; if ($row["target"]  !="section" && substr($row["url"],0,16)  != "/pub/page/profil"){ echo " display:none;"; } echo "'> Radius: 
                        <input id='idhRADIUS' type='text' style='width:50%;float:right;' value='" .$row["border_radius"] . "' onclick='detectCLICK(event,this);' oninput='section_updated = true;'>
                    </div>
                    <div class='divBOX' style='"; if ($row["target"]  !="section" && substr($row["url"],0,16)  != "/pub/page/profil"){ echo " display:none;"; } echo "'> Ombre: 
                        <input id='idhSHADOW' type='text' style='width:50%;float:right;' value='" .$row["boxShadow"] . "' onclick='detectCLICK(event,this);' oninput='section_updated = true;'>
                    </div>
                    <div class='divBOX' style='"; if ($row["target"]  !="section" && substr($row["url"],0,16)  != "/pub/page/profil"){ echo " display:none;"; } echo "'> Opacité entre (0.00 et 1): 
                        <input id='idhOPACITY' type='text' style='width:20%;float:right;vertical-align:middle;' value='" . $row["opacity"] . "' oninput='section_updated = true;'>
                    </div>
                    <div class='divBOX' style='"; if (trim($row["url"])  == "/"){ echo " display:none;"; } echo "'> Couleur du fond: 
                        <br><input type='color' style='width:40px;border-radius:5px;' value='" . $row["background"] . "' oninput=\"document.getElementById('idhBG').value = this.value;section_updated = true;\">
                        <input id='idhBG' type='text'  style='width:80%;float:right;vertical-align:middle;' value='" . $row["background"] . "'>
                    </div>
                    <div class='divBOX' style='"; if ($row["target"]  !="section" && substr($row["url"],0,16)  != "/pub/page/profil" && substr($row["url"],0,13)  != "/pub/page/job"){ echo " display:none;"; } echo "'> Couleur du texte: 
                        <br><input type='color' style='width:40px;border-radius:5px;' value='" . $row["background"] . "' oninput=\"document.getElementById('idhFG').value = this.value;section_updated = true;\">
                        <input id='idhFG' type='text'  style='width:80%;float:right;vertical-align:middle;' value='" . $row["foreground"] . "'>
                    </div>";
//PARAMETRES SUPPLEMENTAIRES
                    echo"<h3>PARAMÈTRES SUPPLEMENTAIRES</h3>";
                    echo "<div class='divBOX' style='"; if ($row["target"]  !="section" && $row["target"]  !="page"){ echo " display:none;"; } echo "'>Paramètres URL #1: 
                        <input id='idhLIST' type='text' value='" . $row["cat_list"] . "' oninput='section_updated = true;'>
                    </div>";
                    echo "<div class='divBOX' style='"; if ($row["target"]  !="section" && $row["target"]  !="page"){ echo " display:none;"; } echo "'>Paramètres URL #2: 
                        <input id='idhP2' type='text' value='' oninput='section_updated = true;'>
                    </div>";
//GALLERIES PHOTOS
                echo "<br>";
					if (substr($row["url"],0,22)  == "/pub/section/slideshow" || substr($row["url"],0,20)  == "/pub/section/gallery"){ 
						echo "<div class='divPAGE'><div class='divBOX' style='max-height:0px;max-width:90%;'>Pour un affichage optimal toutes les images doivent avoir les mêmes largeurs et hauteurs.</div>
						<div class='dw3_drop_area' ondrop=\"dw3_upload_file(event,'".$row["id"]."')\" ondragover=\"this.style.background='rgba(190,220,180,0.5)'; return false\" ondragleave=\"this.style.background='transparent'; return false\">
							<span class='material-icons' style='font-size:40px;'>cloud_upload</span>
							<div id='drop_header'>Glissez des documents ici pour les afficher dans la gallerie</div>
							<span>OU</span>
							<button id='dw3_btn_upload'>Choisir un ou plusieurs fichiers</button>
							<span>OU</span>
							<button onclick='dw3_up_to_slide(".$row["id"].")'>Choisir un fichiers existant</button>
							<input type='file' name='dw3_file' id='dw3_file' hidden multiple>
							</div></div>
							<div id='section_gallery'></div>
							";
					}
//IMAGE DE FOND
                    echo "<div class='divBOX' style='margin-bottom:30px;max-width:680px;"; if ($row["target"] !="section" && $row["target"] !="page"){ echo " display:none;"; } echo "'>Image: 
                        <input id='idhIMG' type='text' style='width:60%;float:right;vertical-align:middle;' value='" . $row["img_url"] . "'>                  
                        <select onchange='selIMG_TYPE(this.value)' name='idhIMG_DSP' id='idhIMG_DSP' style='width:60%;float:right;vertical-align:middle;"; if ($row["target"] !="section"){ echo " display:none;"; } echo "' onchange='section_updated = true;'>
                            <option value='none'"; if 	($row["img_display"]  =="none"){ echo " selected"; } echo ">Ne pas afficher</option>
                            <option value='background'"; if 	($row["img_display"]  =="background"){ echo " selected"; } echo ">En arrière-plan fixe</option>
                            <option value='background2'"; if 	($row["img_display"]  =="background2"){ echo " selected"; } echo ">En arrière-plan</option>
                            <option value='header'"; if 	($row["img_display"]  =="header"){ echo " selected"; } echo ">En entête</option>
                            <option value='floatRight'"; if 	($row["img_display"]  =="floatRight"){ echo " selected"; } echo ">À droite</option>
                            <option value='floatLeft'"; if 	($row["img_display"]  =="floatLeft"){ echo " selected"; } echo ">À gauche</option>
                            <option value='gradiant'"; if 	($row["img_display"]  =="gradiant"){ echo " selected"; } echo ">Dégradé de couleurs</option>
                        </select>
                        <select id='idhIMG_ANIM' style='width:60%;float:right;vertical-align:middle;"; if ($row["target"] !="section"){ echo " display:none;"; } echo "' onchange='section_updated = true;'>
                            <option value=''"; if 	($row["img_anim"]  ==""){ echo " selected"; } echo ">Ne pas animer</option>
                            <option value='dw3_pan_infinite'"; if 	($row["img_anim"]  =="dw3_pan_infinite"){ echo " selected"; } echo ">De gauche à droite et droite à gauche infini</option>
                            <option value='dw3_zoom_infinite'"; if 	($row["img_anim"]  =="dw3_zoom_infinite"){ echo " selected"; } echo ">Zoom/dézoom infini (Hauteur Max)</option>
                            <option value='dw3_zoom2_infinite'"; if 	($row["img_anim"]  =="dw3_zoom2_infinite"){ echo " selected"; } echo ">Zoom/dézoom infini (Largeur Max)</option>
                            <option value='dw3_unzoom'"; if 	($row["img_anim"]  =="dw3_unzoom"){ echo " selected"; } echo ">Dézoom une fois (Hauteur Max)</option>
                            <option value='dw3_unzoom2'"; if 	($row["img_anim"]  =="dw3_unzoom2"){ echo " selected"; } echo ">Dézoom une fois (Largeur Max)</option>
                        </select>
                            <div style='"; if ($row["target"] !="section"){ echo " display:none;"; } echo "'>
                                <label for='idhIMG_ANIM_TIME'>Durée animation (<b><span id='img_time'>".$row["img_anim_time"]."</span></b> secondes):</label>
                                <input type='range' id='idhIMG_ANIM_TIME' min='5' max='50' value='".$row["img_anim_time"]."' oninput=\"document.getElementById('img_time').innerText = this.value;section_updated = true;\">
                            </div>
                        <button id='btnSECTION_GRAD' style='"; if ($row["img_display"] !="gradiant"){ echo " display:none;"; } echo "margin-top:7px;float:right;background-image:".$row["img_url"].";width:75px;height:25px;' onclick=\"selGRADIANT();\"> </button><br>
                        <button id='btnSECTION_IMG' style='"; if ($row["img_display"] =="gradiant"){ echo " display:none;"; } echo "min-width:50px;float:right;' onclick=\"selUPLOAD('idhIMG');\"><img id='idhIMG_IMG' src='" . $IMG_path . "' style='width:250px;height:auto;'> ..</button>
                    </div><br>
                    <div style='text-align:left;"; if ($row["url"]!="/pub/section/perso1/index.php" && $row["url"]!="/pub/section/chatbot/index.php" && $row["url"]!="/pub/page/classifieds/index.php" && substr($row["url"],0,22)  != "/pub/section/slideshow" && substr($row["url"],0,20)  != "/pub/section/gallery" && substr($row["url"],0,23)  != "/pub/section/navigation" && substr($row["url"],0,21)  != "/pub/section/historic" && substr($row["url"],0,24)  != "/pub/section/realisation" && substr($row["url"],0,18)  != "/pub/page/retailer" && substr($row["url"],0,21)  != "/pub/section/contact3" && substr($row["url"],0,16)  != "/pub/page/profil" && substr($row["url"],0,17)  != "/pub/section/sub/"){ echo " display:none;"; } 
//HTML FR ET ENG
                        echo "'>HTML en français : <button class='red' style='float:right;padding:4px 8px;' title='Enlever les retour chariot' onclick=\"dw3_remove_input_BR('idhHTML_FR')\">x <span class='material-icons' style='font-size:11px;'>keyboard_return</span></button>";
                            if ($CIE_DEEPL_KEY != ""){ echo "<button style='float:right;padding:4px 8px;' onclick=\"dw3_translate(encodeURIComponent('idhHTML_FR'),'fr','en','idhHTML_EN');\"><span class='material-icons' style='font-size:12px;'>translate</span> fr->en</button>";}
                        echo "<textarea id='idhHTML_FR' onfocus='active_input=this.id;' oninput='section_updated = true;' style='height:300px;width:100%;'>".str_replace("<br />","&#13;&#10;",str_replace("<br/>","&#13;&#10;",str_replace("<br>","&#13;&#10;",$row["html_fr"])))."</textarea>
                            HTML en anglais : <button class='red' style='float:right;padding:4px 8px;' title='Enlever les retour chariot' onclick=\"dw3_remove_input_BR('idhHTML_EN')\">x <span class='material-icons' style='font-size:11px;'>keyboard_return</span></button>";
                            if ($CIE_DEEPL_KEY != ""){ echo "<button style='float:right;padding:4px 8px;' onclick=\"dw3_translate(encodeURIComponent('idhHTML_EN'),'en','fr','idhHTML_FR');\"><span class='material-icons' style='font-size:12px;'>translate</span> en->fr</button>";}            
                        echo "<textarea id='idhHTML_EN' onfocus='active_input=this.id;' oninput='section_updated = true;' style='height:300px;width:100%;'>".str_replace("<br />","&#13;&#10;",str_replace("<br/>","&#13;&#10;",str_replace("<br>","&#13;&#10;",$row["html_en"])))."</textarea><br>
                    </div>";
//SOUS-SECTIONS
                    if ($row["url"]=="/pub/section/tabs2/index.php" || $row["url"]=="/pub/section/tabs3/index.php" || $row["url"]=="/pub/section/tabs4/index.php" || $row["url"]=="/pub/section/sub2/index.php" || $row["url"]=="/pub/section/sub3/index.php"){
                        $sub_row_num = 0;
                        $sql_sub = "SELECT * FROM index_line WHERE head_id = '".$row["id"]."' ORDER BY sort_order ASC;";
                        $result_sub = $dw3_conn->query($sql_sub);
                        if ($result_sub->num_rows > 0) {
                            echo "<div class='divBOX'>Sous-sections:<div style='width:100%;text-align:center;'>";
                            while($row_sub = $result_sub->fetch_assoc()) {
                                $sub_row_num++;
                                echo "<button onclick=\"getSUB_SECTION('".$row_sub["id"]."','Tab ".$sub_row_num."')\">Sub ".$sub_row_num."</button>";
                            }
                            echo "</div></div>";
                        }
                    }
//CARACTERES SPECIAUX
					echo "
					<div id='divCharPERSO1' style='"; 
                    if ($row["url"]!="/pub/section/perso1/index.php" && substr($row["url"],0,22)  != "/pub/section/slideshow" && substr($row["url"],0,20)  != "/pub/section/gallery" && substr($row["url"],0,21)  != "/pub/section/historic" && substr($row["url"],0,24)  != "/pub/section/realisation" && substr($row["url"],0,18)  != "/pub/page/retailer" && substr($row["url"],0,21)  != "/pub/section/contact3" && substr($row["url"],0,16)  != "/pub/page/profil"){                         
                        echo " display:none;"; 
                    } else { echo "display:inline-block;";} 
                    echo "overflow-y:auto;overflow-x:hidden;height:150px;width:100%;vertical-align:middle;text-align:center;'>
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
//SOUS PAGES & SOUS SECTIONS
                if ($row["target"] == "sub"){
                    echo "<hr>";
                    echo "<button onclick=\"newSECTION('page','" . $row["id"] . "');\"><span class='material-icons' style='vertical-align:middle;'>add</span><span style='vertical-align:middle;margin-top:2px;'> Page</span></button>";
                    echo "<button onclick=\"newSECTION('button','" . $row["id"] . "');\"><span class='material-icons' style='vertical-align:middle;'>add</span><span style='vertical-align:middle;margin-top:2px;'> Boutton</span></button>";                
                    $sql2 = "SELECT * FROM index_head where parent_id = '" . $row["id"] . "' ORDER BY menu_order ASC";
                    $result2 = $dw3_conn->query($sql2);
                        if ($result2->num_rows > 0) {
                            echo "<br>Sous-Pages & Sous-Sections: <br><table class='tblSEL'><tr><th></th><th>Titre</th><th>Url</th><th>Type</th><th>au Menu</th><th>Visites</th></tr>";
                            while($row2 = $result2->fetch_assoc()) {
                                echo '<tr onclick="getSECTION(\''.$row2["id"].'\',\''.$row2["target"].'\');"><td><span class="dw3_font" style="color:'.$row2["icon_color"].';text-shadow:'.$row2["icon_textShadow"].';">'.$row2["icon"].'</span> '.$row2["menu_order"].'</td><td>'.$row2["title"].'</td>'
                                                . '<td>'.$row2["url"].'</td>'
                                                . '<td>'.$row2["target"].'</td>'
                                                . '<td>'.$row2["is_in_menu"].'</td><td>';
                                                if ($row2["target"]=="page"){
                                                    echo $row2["total_visited"];
                                                }else{
                                                    echo "n/a";
                                                }
                                                echo '</td></tr>';
                            }
                            echo "</table>";
                        } else{
                            echo "<br>Aucunes sous-page ou sous-section trouvé pour cette page.<br>";
                        }
                        
                }else if ($row["target"] == "page" && $row["url"]=="/pub/page/home/index.php"){
                    echo "<hr>";
                    echo "<button onclick=\"newSECTION('section','" . $row["id"] . "');\"><span class='material-icons' style='vertical-align:middle;'>add</span><span style='vertical-align:middle;margin-top:2px;'> Section</span></button>";  
                    echo "<br>À utiliser si vous voulez que le menu soit différent que sur les autres pages:<br><button onclick=\"newSECTION('page','" . $row["id"] . "');\"><span class='material-icons' style='vertical-align:middle;'>add</span><span style='vertical-align:middle;margin-top:2px;'> Page</span></button>";
                    echo "<button onclick=\"newSECTION('button','" . $row["id"] . "');\"><span class='material-icons' style='vertical-align:middle;'>add</span><span style='vertical-align:middle;margin-top:2px;'> Boutton</span></button> 
                    <button onclick=\"newSECTION('sub','" . $row["id"] . "');\"><span class='material-icons' style='vertical-align:middle;'>add</span><span style='vertical-align:middle;margin-top:2px;'> Sous-menu</span></button>";
                    $sql2 = "SELECT * FROM index_head where parent_id = '" . $row["id"] . "' ORDER BY menu_order ASC";
                    $result2 = $dw3_conn->query($sql2);
                        if ($result2->num_rows > 0) {
                            echo "<br>Sous-Pages & Sous-Sections: <br><table class='tblSEL'><tr><th></th><th>Titre</th><th>Url</th><th>Type</th><th>au Menu</th><th>Visites</th></tr>";
                            while($row2 = $result2->fetch_assoc()) {
                                echo '<tr onclick="getSECTION(\''.$row2["id"].'\',\''.$row2["target"].'\');"><td><span class="dw3_font" style="color:'.$row2["icon_color"].';text-shadow:'.$row2["icon_textShadow"].';">'.$row2["icon"].'</span> '.$row2["menu_order"].'</td><td>'.$row2["title"].'</td>'
                                                . '<td>'.$row2["url"].'</td>'
                                                . '<td>'.$row2["target"].'</td>'
                                                . '<td>'.$row2["is_in_menu"].'</td><td>';
                                                if ($row2["target"]=="page"){
                                                    echo $row2["total_visited"];
                                                }else{
                                                    echo "n/a";
                                                }
                                                echo '</td></tr>';
                            }
                            echo "</table>";
                        } else{
                            echo "<br>Aucunes sous-page ou sous-section trouvé pour cette page.<br>";
                        }
                        
                }else if ($row["target"] == "page" && $row["url"]!="/pub/page/home/index.php"){
                    echo "<hr>À utiliser si vous voulez que le menu soit différent que sur les autres pages:<br><button onclick=\"newSECTION('page','" . $row["id"] . "');\"><span class='material-icons' style='vertical-align:middle;'>add</span><span style='vertical-align:middle;margin-top:2px;'> Page</span></button>";                    
                    echo "<button onclick=\"newSECTION('button','" . $row["id"] . "');\"><span class='material-icons' style='vertical-align:middle;'>add</span><span style='vertical-align:middle;margin-top:2px;'> Boutton</span></button> 
                    <button onclick=\"newSECTION('sub','" . $row["id"] . "');\"><span class='material-icons' style='vertical-align:middle;'>add</span><span style='vertical-align:middle;margin-top:2px;'> Sous-menu</span></button>";
                    $sql2 = "SELECT * FROM index_head where parent_id = '" . $row["id"] . "' ORDER BY menu_order ASC";
                    $result2 = $dw3_conn->query($sql2);
                        if ($result2->num_rows > 0) {
                            echo "<br>Pages pour le menu: <br><table class='tblSEL'><tr><th>#</th><th>Titre</th><th>Url</th><th>Type</th><th>au Menu</th><th>Visites</th></tr>";
                            while($row2 = $result2->fetch_assoc()) {
                                echo '<tr onclick="getSECTION(\''.$row2["id"].'\',\''.$row2["target"].'\');"><td>'.$row2["menu_order"].'</td><td>'.$row2["title"].'</td>'
                                                . '<td>'.$row2["url"].'</td>'
                                                . '<td>'.$row2["target"].'</td>'
                                                . '<td>'.$row2["is_in_menu"].'</td><td>';
                                                if ($row2["target"]=="page"){
                                                    echo $row2["total_visited"];
                                                }else{
                                                    echo "n/a";
                                                }
                                                echo '</td></tr>';
                            }
                            echo "</table>";
                        } else{
                            echo "<br>Aucun menu ou sous-section trouvé pour cette page.<br>";
                        }
                }
//FIN SOUS PAGES & SOUS SECTIONS
                echo "</div>
                <div class='dw3_form_foot'>
                    <button class='red' onclick='delSECTION(\"" . $row["id"] . "\");'><span class='material-icons'>delete_forever</span></button> 
                    <button class='grey' onclick='closeSECTION();'><span class='material-icons'>cancel</span></button>";
                    if ($row["target"] == "section"){
                        echo "<button class='blue' onclick=\"copySECTIONto('".$row["id"]."','".$row["parent_id"]."');\"><span class='material-icons'>copy_all</span>Dupliquer</button>";
                    }
                    if ($row["target"] == "page"){
                        echo "<button class='blue' onclick=\"copyPAGE('".$row["id"]."');\"><span class='material-icons'>copy_all</span>Dupliquer</button>";
                    }
				echo "<button class='green' onclick='updSECTION(\"" . $row["id"] . "\");'><span class='material-icons'>save</span></button>
				</div>";
		}
	}
$dw3_conn->close();
?>