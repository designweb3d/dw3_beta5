<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$prID  = $_GET['prID'];
$html = "";
	$sql = "SELECT A.*, 
    IFNULL(B.company_name,'Non défini') AS supplier_name, 
    IFNULL(C.user_name,'Non défini') AS created_name, IFNULL(D.user_name,'Non défini') AS modified_name
    FROM product A 
    LEFT JOIN (SELECT id, company_name FROM supplier) B ON A.supplier_id = B.id
    LEFT JOIN (SELECT id, name as user_name FROM user) C ON A.user_created = C.id
    LEFT JOIN (SELECT id, name as user_name FROM user) D ON A.user_modified = D.id
    WHERE A.id = " . $prID . " LIMIT 1";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {		
		while($row = $result->fetch_assoc()) {
            $filenames = [];
            $folder=scandir($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" .$row["id"] . "/");
            foreach($folder as $file) {
                if (!is_dir($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $file) && $file != "." && $file != ".."){
                    $filenames[] = $file;
                }
            }
            $filename= $row["url_img"];
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
                $filename = "/pub/img/dw3/nd.png";
            } else {
                if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
                    $filename = "/pub/img/dw3/nd.png";
                }else{
                    $filename = "/fs/product/" . $row["id"] . "/" . $filename;
                }
            } 
			$html .= "<div id='divEDIT_HEADER' class='dw3_form_head'>
                        <h3>Modification du produit #". $row["id"] ."</h3>
                        <button class='dw3_form_close' onclick='closeEDITOR(this);'><span class='material-icons'>cancel</span></button>
                    </div>
                    <div class='dw3_form_data'><input style='display:none;' id='currentPRD' type='text' value=\"" . $row["id"] . "\">
                    <img id='imgPRD' style='position:absolute;top:0px;left:0px;z-index:-1;width:100%;height:auto;' src='" . $filename . "?t=".rand(1,100000)."' onerror='this.onerror=null; this.src=\"/pub/img/dw3/nd.png\";'>";
//STATUS & NAME
                $html .= "<div class='divBOX'><b>" . $dw3_lbl["STAT"] . "</b>:
                        <select name='prSTAT' id='prSTAT'>";
                    $sql2 = "SELECT *
                            FROM config
                            WHERE kind = 'PRODUCT_STAT'				
                            ORDER BY code";
                    $result2 = $dw3_conn->query($sql2);
                    if ($result2->num_rows > 0) {
                        $html .= "<option disabled value=''>Veuillez choisir un status</option>";
                        while($row2 = $result2->fetch_assoc()) {
                            if ($row2["code"] == $row["stat"]){ $opt_SELECTED = " selected ";} else { $opt_SELECTED = " "; }
                            $html .= "<option " . $opt_SELECTED . " value='". $row2["code"] . "'>"	. $row2["code"] . " - " . $row2["text1"] . "</option>";		}
                    } else { $html .= "<option disabled selected value=''>Aucun status de produit de crée</option>"; }
                    $html .= "</select></div><br>";
                $html .= "<div class='divBOX'><b>" . $dw3_lbl["PRD_NAME"]. " FR</b>:
                            <input id='prNOM' type='text' value=\"" . $row["name_fr"] . "\">
                        </div>";
                $html .= "<div class='divBOX'><b>" . $dw3_lbl["PRD_NAME"]. " EN</b>:
                            <input id='prNOM_EN' type='text' value=\"" . $row["name_en"] . "\">
                        </div>";
//IMAGES
                    $html .= "<h4 onclick=\"toggleFolder('divSubPrd1','Prdup1');\" style=\"background: rgba(255, 255, 255, 0.7);color:#333;text-shadow:none;text-align:left;padding:5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;text-shadow:none;border-bottom: 1mm ridge rgba(127, 127, 127, .6);\">
                        <span id='Prdup1' class=\"material-icons\">folder</span>Dossier du produit <span style='color:grey;font-size:11px;'><i>/fs/product/" .$row["id"] . "/</i></span>
                    </h4>
                    <div class=\"divMAIN\" id='divSubPrd1' style='padding-top:0px;transition: height 1.5s;height:0px;display:none;'>
                        <div id='divFILES' style='padding:5px;'>";
                        if(count($filenames)>=1){
                            foreach($filenames as $file) {
                                if ($row["url_img"] == $file){
                                   $html .= "<button onclick='getFILE_INFO(\"".$prID."\",\"".$file."\");' class='image' style='margin:0px 3px 0px 3px;color:#111;height:100px;width:auto;min-width:100px;max-width:200px;background-image: url(\"/fs/product/".$row["id"]."/" . $file . "?t=".rand(1,100000)."\");'><span class='material-icons' style='color:goldenrod;font-size:25px;float:left;margin:-15px 0px 0px -15px;text-shadow: 1px 1px #000;'>grade</span><br><div style='background:rgba(255,255,255,0.7);padding:3px;border-radius:3px;margin-top:70px;text-shadow: 1px 1px #1baff3;'>" . $file . "</div></button>";
                                } else {
                                   $html .= "<button onclick='getFILE_INFO(\"".$prID."\",\"".$file."\");' class='image' style='margin:0px 3px 0px 3px;color:#111;text-shadow: 1px 1px #1baff3;height:100px;width:auto;min-width:100px;max-width:200px;background-image: url(\"/fs/product/".$row["id"]."/" . $file . "?t=".rand(1,100000)."\");'><div style='background:rgba(255,255,255,0.7);padding:3px;border-radius:3px;margin-top:70px;'>" . $file . "</div></button>";
                                }
                            }
                        }
                $html .= "</div><br>
                            <div id='divFILE_INFO' style='line-height:1em;font-size:13px;text-align:left;'>
                                <u>File</u>:<br>
                                <u>Extension</u>:<br>
                                <u>Size</u>:<br>
                                <u>Width</u>:<br>
                                <u>Height</u>:<br>
                                <u>Last modified</u>:<br>
                                <u>Last accessed</u>:<br>
                            </div>
                            <table style='width:100%;'><tr><td><input type='text' id='prURL_IMG'></td><td style='width:40px;'>";
                            if ($APREAD_ONLY == false) { $html .= "<button onclick='renameFILE(". $row["id"] .");'><span style='font-size:18px;' class=\"material-icons\">edit_square</span></button>";}
                            $html .= "</td></tr></table>";
                            if ($APREAD_ONLY == false) { $html .= "<button class='red' onclick='deleteFILE(". $row["id"] .");'><span class=\"material-icons\">delete</span></button>";}
                            if ($APREAD_ONLY == false) { $html .= "<button onclick='updFILE_URL(". $row["id"] .");'><span class=\"material-icons\" style='color:goldenrod;'>grade</span>Image Principale</button>";}
                            if ($APREAD_ONLY == false) { $html .= "<button class='blue' onclick=\"dw3_file_replace='unknow';document.getElementById('fileNamePrd').value='" . $row["id"] . "';document.getElementById('fileToPrd').click();\"><span class=\"material-icons\">add</span>Ajouter</button>";}
                    $html .= "</div>";
//INFORMATIONS GÉNÉRALES
                $html .= "<h4 onclick=\"toggleFolder('divSubPrd2','Prdup2');\" style=\"background: rgba(255, 255, 255, 0.7);color:#333;text-shadow:none;text-align:left;padding:5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);\">
                            <span id='Prdup2' class=\"material-icons\">folder</span>Informations générales
                        </h4>
                    <div class=\"divMAIN\" id='divSubPrd2' style='padding-top:0px;transition: height 1.5s;height:0px;display:none;'>";
                $html .= "<div class='divBOX'><b>Ventes / téléchargements</b>:
                            <input disabled type='text' style='text-align:right;' value='" . $row["purchase_qty"] . "'>
                        </div>";
                $html .= "<div class='divBOX'><b>Clics / demandes d'informations</b>:
                            <input disabled type='text' style='text-align:right;' value='" . $row["qty_visited"] . "'>
                        </div>";
                $html .= "<div class='divBOX'><b>" . $dw3_lbl["CAT"] . " 1</b>:<select name='prCAT' id='prCAT'><option value='0'>Non défini</option>";
                        $sql2 = "SELECT * FROM product_category ORDER BY parent_name, name_fr LIMIT 1000";
                        $result2 = $dw3_conn->query($sql2);
                        $parent_cat = "";
                        $row2_num = 0;
                        if ($result2->num_rows > 0) {	
                            while($row2 = $result2->fetch_assoc()) {
                                $row2_num++;
                                if ($row2["parent_name"]=="" && $row2_num == 1){ $html .=  "<option disabled value='' style='text-align:center;'>Catégories principales</option>";}
                                else if ($row2["parent_name"]!="" && $row2_num == 1){ 
                                    $html .=  "<option disabled value='' style='text-align:center;'>".$row["parent_name"]."</option>";
                                    $parent_cat = $row2["parent_name"];
                                } else { 
                                    if ($parent_cat != $row2["parent_name"]){
                                        $html .=  "<option disabled value='' style='text-align:center;'>".$row2["parent_name"]."</option>";
                                        $parent_cat = $row2["parent_name"];  
                                    }
                                }
                                $html .= "<option "; if ($row2["id"] == $row["category_id"]){$html .= "selected ";} $html .= "value='" . $row2["id"]  . "'>(".str_pad($row2["id"],3,"0",STR_PAD_LEFT) .") " . $row2["name_fr"]  . "</option>";
                            }
                        }
                $html .= "</select></div> ";
                $html .= "<div class='divBOX'><b>" . $dw3_lbl["CAT"] . " 2</b>:<select name='prCAT2' id='prCAT2'><option value='0'>Non défini</option>";
                        $sql2 = "SELECT * FROM product_category ORDER BY parent_name, name_fr LIMIT 1000";
                        $result2 = $dw3_conn->query($sql2);
                        $parent_cat = "";
                        $row2_num = 0;
                        if ($result2->num_rows > 0) {	
                            while($row2 = $result2->fetch_assoc()) {
                                $row2_num++;
                                if ($row2["parent_name"]=="" && $row2_num == 1){ $html .=  "<option disabled value='' style='text-align:center;'>Catégories principales</option>";}
                                else if ($row2["parent_name"]!="" && $row2_num == 1){ 
                                    $html .=  "<option disabled value='' style='text-align:center;'>".$row["parent_name"]."</option>";
                                    $parent_cat = $row2["parent_name"];
                                } else { 
                                    if ($parent_cat != $row2["parent_name"]){
                                        $html .=  "<option disabled value='' style='text-align:center;'>".$row2["parent_name"]."</option>";
                                        $parent_cat = $row2["parent_name"];  
                                    }
                                }
                                $html .= "<option "; if ($row2["id"] == $row["category2_id"]){$html .= "selected ";} $html .= "value='" . $row2["id"]  . "'>(".str_pad($row2["id"],3,"0",STR_PAD_LEFT) .") " . $row2["name_fr"]  . "</option>";
                            }
                        }
                $html .= "</select></div> ";
                $html .= "<div class='divBOX'><b>" . $dw3_lbl["CAT"] . " 3</b>:<select name='prCAT3' id='prCAT3'><option value='0'>Non défini</option>";
                        $sql2 = "SELECT * FROM product_category ORDER BY parent_name, name_fr LIMIT 1000";
                        $result2 = $dw3_conn->query($sql2);
                        $parent_cat = "";
                        $row2_num = 0;
                        if ($result2->num_rows > 0) {	
                            while($row2 = $result2->fetch_assoc()) {
                                $row2_num++;
                                if ($row2["parent_name"]=="" && $row2_num == 1){ $html .=  "<option disabled value='' style='text-align:center;'>Catégories principales</option>";}
                                else if ($row2["parent_name"]!="" && $row2_num == 1){ 
                                    $html .=  "<option disabled value='' style='text-align:center;'>".$row["parent_name"]."</option>";
                                    $parent_cat = $row2["parent_name"];
                                } else { 
                                    if ($parent_cat != $row2["parent_name"]){
                                        $html .=  "<option disabled value='' style='text-align:center;'>".$row2["parent_name"]."</option>";
                                        $parent_cat = $row2["parent_name"];  
                                    }
                                }
                                $html .= "<option "; if ($row2["id"] == $row["category3_id"]){$html .= "selected ";} $html .= "value='" . $row2["id"]  . "'>(".str_pad($row2["id"],3,"0",STR_PAD_LEFT) .") " . $row2["name_fr"]  . "</option>";
                            }
                        }
                $html .= "</select></div> ";
                $html .= "<div class='divBOX' style='width:95%;max-width:680px;'><b>" . $dw3_lbl["DESC_FR"] . "</b>:";
                    if ($CIE_DEEPL_KEY != "" && $APREAD_ONLY == false) { $html .= "<button onclick=\"dw3_translate('prDESC','fr','en','prDESC_EN');\"><span class='material-icons' style='font-size:12px;'>translate</span> FR -> EN</button>";}
                    $html .= "<textarea rows=10 id='prDESC' onfocus='active_input=this.id;' style='line-height:1em;'>" . str_replace("<br />","\n",str_replace("<br/>","\n",str_replace("<br>","\n",$row["description_fr"]))) . "</textarea>
                    </div>
                    <div class='divBOX' style='width:95%;max-width:680px;'><b>" . $dw3_lbl["DESC_EN"] . "</b>:";
                    if ($CIE_DEEPL_KEY != "" && $APREAD_ONLY == false) { $html .= "<button onclick=\"dw3_translate('prDESC_EN','en','fr','prDESC');\"><span class='material-icons' style='font-size:12px;'>translate</span> EN -> FR</button>"; }
                    $html .= "<textarea rows=10 id='prDESC_EN' onfocus='active_input=this.id;' style='line-height:1em;'>" . str_replace("<br />","\n",str_replace("<br/>","\n",str_replace("<br>","\n",$row["description_en"]))) . "</textarea>
                    </div>
                    <div class='divBOX' style='width:95%;max-width:680px;'><b>Description par DataIA FR</b> (HTML):
                    <div style='display:flex;'><select id='dia_db' onchange=\"dataia_desc_get('dia_db','prNOM','prDESC_IA_FR')\">
                        <option value=''>Choisir une base de donnée</option>
                        <optgroup label='Vie'>
                        <option value='ANIMAL'>Animaux</option>
                        <option value='PLANT'>Arbres, Fleurs et Plantes</option>
                        </optgroup>
                        <optgroup label='Alimentation'>
                        <option value='RECIPE'>Recettes</option>
                        <option value='FOOD_FRUIT'>Aliments transformés</option>
                        <option value='FOOD_FRUIT'>Boissons</option>
                        <option value='FOOD_FRUIT'>Boissons alcoolisées</option>
                        <option value='FOOD_FRUIT'>Déssets et grignotines</option>
                        <option value='FOOD_FRUIT'>Féculents et les légumes secs</option>
                        <option value='FOOD_FRUIT'>Fruits & Légumes</option>
                        <option value='FOOD_FRUIT'>Huiles et Épices</option>
                        <option value='FOOD_FRUIT'>Produits laitiers</option>
                        <option value='FOOD_FRUIT'>Produits céréaliers</option>
                        <option value='FOOD_VIANDE'>Viande, Poisson et Fruits de mer</option>
                        <option value='FOOD_FRUIT'>Vitamines et minéraux</option>
                        </optgroup>
                        <optgroup label='Objets'>
                        <option value='OBJ_ELECTRO'>Appareils électroniques</option>
                        <option value='OBJ_ANIMAL'>Articles pour animaux</option>
                        <option value='OBJ_ANIMAL'>Bagages et accessoires de voyage</option>
                        <option value='OBJ_SANTE'>Bijoux et Montres</option>
                        <option value='OBJ_SANTE'>Bottes et Chaussures</option>
                        <option value='OBJ_DIY'>DIY et produits artisanaux</option>
                        <option value='OBJ_SANTE'>Instruments de musique</option>
                        <option value='OBJ_SANTE'>Livres</option>
                        <option value='OBJ_SANTE'>Produits pour la maison</option>
                        <option value='OBJ_SPORT'>Produits et accessoires pour le sport</option>
                        <option value='OBJ_BABY'>Produits pour bébés et enfants</option>
                        <option value='OBJ_INDUSTRY'>Produits industriels et scientifiques</option>
                        <option value='OBJ_ELECTRO'>Véhicules</option>
                        <option value='OBJ_SANTE'>Vêtements</option>
                        <option value='OBJ_SANTE'>Santé & Beauté</option>
                        </optgroup>
                    </select>";
                    if ($APREAD_ONLY == false) { $html .= "<button onclick=\"dataia_desc_get('dia_db','prNOM','prDESC_IA_FR')\"><span class=\"material-icons\">travel_explore</span></button>"; }
                    $html .= "<textarea rows=10 id='prDESC_IA_FR' oninput=\"document.getElementById('DIA_FR_VIEW').innerHTML=this.value;\" onchange=\"document.getElementById('DIA_FR_VIEW').innerHTML=this.value;\" onfocus='active_input=this.id;' style='line-height:1em;'>" . str_replace("<br />","\n",str_replace("<br/>","\n",str_replace("<br>","\n",$row["desc_dataia_fr"]))) . "</textarea>
                    <i><b>Aperçu</b></i>:<br><div id='DIA_FR_VIEW'>".$row["desc_dataia_fr"]."</div>
                    </div>
                ";
                $html .= "
					<div id='divCharPERSO1' style='overflow-y:auto;overflow-x:hidden;height:150px;width:100%;vertical-align:middle;text-align:center;'>
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
					</div></div>
					";
//FACTURATION & EXPÉDITION
                $html .= "</div><h4 onclick=\"toggleFolder('divSubPrd3','Prdup3');\" style=\"background: rgba(255, 255, 255, 0.7);color:#333;text-shadow:none;text-align:left;padding:5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);\">
                            <span id='Prdup3' class=\"material-icons\">folder</span>Facturation & Expédition
                        </h4>
                    <div class=\"divMAIN\" id='divSubPrd3' style='padding-top:0px;transition: height 1.5s;height:0px;display:none;'>";

                $html .= "<div class='divBOX' style='max-width:680px;'><b>". $dw3_lbl["PRD_FCT"] ."</b>:
                        <select id='prBILLING'>";
                $html .= "<option disabled style='text-align:center;'>Produit avec inventaire</option>";
                $html .= "<option "; if ($row["billing"] == ""){ $html .= "selected "; } $html .= "value=''>Non défini</option>";
                $html .= "<option "; if ($row["billing"] == "FINAL" ){ $html .= "selected "; } $html .= "value='FINAL'>". $dw3_lbl["PRD_FCT_FINAL"] . "</option>";
                $html .= "<option "; if ($row["billing"] == "LOCATION"){ $html .= "selected "; } $html .= "value='LOCATION'>". $dw3_lbl["PRD_FCT_LOCATION"] . "</option>";
                $html .= "<option disabled style='text-align:center;'>Service ou produit numérique</option>";
                $html .= "<option "; if ($row["billing"] == "SERVICE"){ $html .= "selected "; } $html .= "value='SERVICE'>Service divers</option>";
                $html .= "<option "; if ($row["billing"] == "ACCES"){ $html .= "selected "; } $html .= "value='ACCES'>". $dw3_lbl["PRD_FCT_ACCES"] . "</option>";
                $html .= "<option "; if ($row["billing"] == "DECOMPTE"){ $html .= "selected "; } $html .= "value='DECOMPTE'>". $dw3_lbl["PRD_FCT_DECOMPTE"] . "</option>";
                $html .= "<option disabled style='text-align:center;'>Abonnements</option>";
                $html .= "<option "; if ($row["billing"] == "HEBDO"){ $html .= "selected "; } $html .= "value='HEBDO'>". $dw3_lbl["PRD_FCT_HEBDO"] . "</option>";
                $html .= "<option "; if ($row["billing"] == "MENSUEL"){ $html .= "selected "; } $html .= "value='MENSUEL'>". $dw3_lbl["PRD_FCT_MENSUEL"] . "</option>";
                $html .= "<option "; if ($row["billing"] == "ANNUEL"){ $html .= "selected "; } $html .= "value='ANNUEL'>". $dw3_lbl["PRD_FCT_ANNUEL"] . "</option>";
                $html .= "<option disabled style='text-align:center;'>Financement</option>";
                $html .= "<option "; if ($row["billing"] == "FINANCE1"){ $html .= "selected "; } $html .= "value='FINANCE1'>". $dw3_lbl["PRD_FCT_FINANCE1"] . "</option>";
                $html .= "<option "; if ($row["billing"] == "FINANCE3"){ $html .= "selected "; } $html .= "value='FINANCE3'>". $dw3_lbl["PRD_FCT_FINANCE3"] . "</option>";
                $html .= "<option "; if ($row["billing"] == "FINANCE6"){ $html .= "selected "; } $html .= "value='FINANCE6'>". $dw3_lbl["PRD_FCT_FINANCE6"] . "</option>";
                $html .= "<option "; if ($row["billing"] == "FINANCE12"){ $html .= "selected "; } $html .= "value='FINANCE12'>". $dw3_lbl["PRD_FCT_FINANCE12"] . "</option>";
                $html .= "<option "; if ($row["billing"] == "FINANCE24"){ $html .= "selected "; } $html .= "value='FINANCE24'>". $dw3_lbl["PRD_FCT_FINANCE24"] . "</option>";
                $html .= "<option "; if ($row["billing"] == "FINANCE36"){ $html .= "selected "; } $html .= "value='FINANCE36'>". $dw3_lbl["PRD_FCT_FINANCE36"] . "</option>";
                $html .= "<option "; if ($row["billing"] == "FINANCE48"){ $html .= "selected "; } $html .= "value='FINANCE48'>". $dw3_lbl["PRD_FCT_FINANCE48"] . "</option>";
                $html .= "<option "; if ($row["billing"] == "FINANCE60"){ $html .= "selected "; } $html .= "value='FINANCE60'>". $dw3_lbl["PRD_FCT_FINANCE60"] . "</option>";
                $html .= "<option "; if ($row["billing"] == "FINANCE72"){ $html .= "selected "; } $html .= "value='FINANCE72'>". $dw3_lbl["PRD_FCT_FINANCE72"] . "</option>";
                $html .= "</select></div>";

                $html .= "<div class='divBOX'><b>Type de shipping</b>:
                        <select id='prSHIP' onchange='checkShipType();'>";
                $html .= "<option "; if ($row["ship_type"] == ""||$row["ship_type"] == "N/A"||$row["ship_type"] == "NONE"){ $html .= "selected "; } $html .= "value=''>Non applicable</option>";
                $html .= "<option "; if ($row["ship_type"] == "INTERNAL"){ $html .= "selected "; } $html .= "value='INTERNAL'>Livraison interne seulement</option>";
                if ($CIE_TRANSPORT != "INTERNAL"){ $html .= "<option "; if ($row["ship_type"] == "CARRIER"){ $html .= "selected ";  } $html .= "value='CARRIER'>".$CIE_TRANSPORT."</option>";}
                $html .= "</select></div>
                        <div class='divBOX'><div style='padding:5px;width:285px;display:inline-block;cursor:pointer;vertical-align:middle;' onclick='document.getElementById(\"prPICKUP\").focus();document.getElementById(\"prPICKUP\").click();'>
                            <b>Permettre le ramassage</b>:</div>
                            <div style='float:right;padding-right:5px;vertical-align:middle;'>
                                <input id='prPICKUP' type='checkbox' style='margin-top:5px;'"; if ($row["allow_pickup"] == true){ $html .= " checked"; } $html .= ">
                            </div>
                        </div>	
                        <div class='divBOX'><b>" . $dw3_lbl["PRIX_ACH"]  . " ou coût de production</b>:
                            <input id='prPRIX_ACH' type='number' style='background: url(/pub/img/dw3/arrow-money.png) 99% / 20px no-repeat #ddd;;' value='" . $row["prod_cost"] . "'>
                        </div>

                        <div class='divBOX' style='display:none;'>Quantité <b>MAX</b>imum par achat:
                            <input id='prQTY_MAX_SOLD' type='number' class='cm' value='" . $row["qty_max_sold"] . "'>
                        </div>
                        <div class='divBOX' style='min-height:25px;'>
                            <div style='padding:5px;width:285px;display:inline-block;cursor:pointer;vertical-align:middle;' onclick='document.getElementById(\"prQTY_MAX_BY_INV\").focus();document.getElementById(\"prQTY_MAX_BY_INV\").click();'>
                            Maximum par achat selon l'inventaire:</div>
                            <div style='float:right;padding-right:5px;vertical-align:middle;'>
                                <input id='prQTY_MAX_BY_INV' type='checkbox' style='margin-top:5px;'"; if ($row["qty_max_by_inv"] == true){ $html .= " checked"; } $html .= ">
                            </div>
                        </div>		
                        <div class='divBOX'><b>Montant de la consigne (si applicable)</b>:
                            <input id='prCONSIGNE' type='number' value='" . $row["consigne"] . "' style='background: url(/pub/img/dw3/arrow-money.png) 99% / 20px no-repeat #ddd;'>
                        </div>
                        <div class='divBOX'><b>Jours de garantie post-vente:
                            <input id='prJOURS_CONSERV' type='number' value='" . $row["conservation_days"] . "'>
                        </div>
                        <div class='divBOX'>
                            <b>Le prix inclus ces frais environementaux</b>*:
                            <input id='prTAX_VERTE' type='number' value='" . $row["tax_verte"] . "'>
                            <span style='font-size:12px;'>*Ne sera pas affiché si le montant est à 0.00$.<br>
                            <u><a href='https://www.legisquebec.gouv.qc.ca/fr/document/rc/Q-2,%20r.%2040.1#se:7'>Lien vers le règlement sur la récupération et la valorisation de produits par les entreprises au Québec</a></u></span>
                        </div>
                    </div>";
//LISTE DE PRIX
        $html .= "<h4 onclick=\"toggleFolder('divSubPrd7','Prdup7');\" style=\"background: rgba(255, 255, 255, 0.7);color:#333;text-shadow:none;text-align:left;padding:5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);\">
                    <span id='Prdup7' class=\"material-icons\">folder</span>Liste de prix
                </h4>
                <div class=\"divMAIN\" id='divSubPrd7' style='padding-top:0px;transition: height 1.5s;height:0px;display:none;'>
                        <div class='divBOX'><div style='padding:5px;width:285px;display:inline-block;cursor:pointer;vertical-align:middle;' onclick='document.getElementById(\"prTAX_FED\").focus();document.getElementById(\"prTAX_FED\").click();'>
                            <b>Taxable au fédéral</b>:</div>
                            <div style='float:right;padding-right:5px;vertical-align:middle;'>
                                <input id='prTAX_FED' type='checkbox' oninput='calcPR_TX();' style='margin-top:5px;'"; if ($row["tax_fed"] == true){ $html .= " checked"; } $html .= ">
                            </div>
                        </div>
                        <div class='divBOX'><div style='padding:5px;width:285px;display:inline-block;cursor:pointer;vertical-align:middle;' onclick='document.getElementById(\"prTAX_PROV\").focus();document.getElementById(\"prTAX_PROV\").click();'>
                            <b>Taxable au provincial</b>:</div>
                            <div style='float:right;padding-right:5px;vertical-align:middle;'>
                                <input id='prTAX_PROV' type='checkbox' oninput='calcPR_TX();' style='margin-top:5px;'"; if ($row["tax_prov"] == true){ $html .= " checked"; } $html .= ">
                            </div>
                        </div>
                        <div class='divBOX'><b>Prix de vente unitaire</b>: <span id='PR_TX' style='float:right;'></span>
                            <input id='prPRIX_VTE' type='number' style='background: url(/pub/img/dw3/arrow-money.png) 99% / 20px no-repeat #ddd;' oninput='calcPR_TX();' value='" . $row["price1"] . "'>
                        </div>	
                        <div class='divBOX' style='font-weight:normal;'>Quantité <b>Minimum</b> par achat:
                            <input id='prQTY_MIN_SOLD' type='number' class='cm' value='" . $row["qty_min_sold"] . "'>
                        </div>
                        <div class='divBOX'><b>Prix additionnel de transport</b>:
                            <input id='prPRIX_TRP' type='number' style='background: url(/pub/img/dw3/arrow-money.png) 99% / 20px no-repeat #ddd;' value='" . $row["transport_supp"] . "'>
                        </div>	
                        <div class='divBOX' style='display:none;'><b>Quantité minimum pour prix 2*</b>:
                            <input id='prMIN_P2' type='number' value='" . $row["qty_min_price2"] . "'>
                            <span style='font-size:12px;'>*Ne sera pas affiché si la valeur est à 0.</span>
                        </div>	
                        <div class='divBOX' style='display:none;'><b>Prix 2*</b>: <span id='PR_TX2' style='float:right;'></span>
                            <input id='prPRIX_VTE2' type='number' style='background: url(/pub/img/dw3/arrow-money.png) 99% / 20px no-repeat #ddd;' oninput='calcPR_TX();' value='" . $row["price2"] . "'>
                            <span style='font-size:12px;'>*Ne sera pas affiché si le prix est à 0.00$.</span>
                        </div>
                        <div class='divBOX'><b>Prix en promotion</b>:";
                        $date_promo = new DateTime($row["promo_expire"]);
                        $now = new DateTime();
                        if($date_promo > $now) {
                           $html .="<span style='color:gold;text-shadow:1px 1px 2px goldenrod;'><span class='material-icons'>new_releases</span> Active!</span>";
                        }
                        $html .= " <span id='PR_TX3' style='float:right;'></span>
                            <input id='prPROMO_PRIX' type='number' style='background: url(/pub/img/dw3/arrow-money.png) 99% / 20px no-repeat #ddd;;' oninput='calcPR_TX();' value='" . $row["promo_price"] . "'>
                            Jusqu'à:
                            <input id='prPROMO_EXPIRE' type='datetime-local' value='" . $row["promo_expire"] . "'>
                        </div><br>";
                    if ($APREAD_ONLY == false) { $html .= "<button onclick='addPACK(". $row["id"] .");'><span class=\"material-icons\">price_check</span>Ajouter un prix</button>";}
                    $html .= "<div id='divPrdPack'></div>
                </div>";

//DÉTAILS TECHNIQUES
            $html .= "<h4 onclick=\"toggleFolder('divSubPrd4','Prdup4');\" style=\"background: rgba(255, 255, 255, 0.7);color:#333;text-shadow:none;text-align:left;padding:5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);\">
                        <span id='Prdup4' class=\"material-icons\">folder</span>Détails techniques
                    </h4>
                <div class=\"divMAIN\" id='divSubPrd4' style='padding-top:0px;transition: height 1.5s;height:0px;display:none;'>";
            $html .= "<div class='divBOX'><b>". $dw3_lbl["FRN1"] ."</b>:
                        <input id='prFRN1' type='text' value='" . $row["supplier_id"] . "' style='display:none;'>
                        <input id='prFRN_NAME' disabled type='text' value='" . $row["supplier_name"] . "' style='width:280px;'>";
                        if ($APREAD_ONLY == false) { $html .="<button onclick=\"openSEL_SUPPLIER();\"><span class='material-icons' style='font-size:14px;'>search</span></button>";}
                    $html .= "</div>";
                    $html .= "<div class='divBOX'><b>SKU</b> (# du fournisseur):
                        <input id='prSKU' type='text' value='" . $row["sku"] . "'>
                    </div>";
                    //UPC BARCODE
                    $html .= "<div class='divBOX'><b>UPC</b> / Code barre:
                        <input id='prUPC' type='text' value='" . $row["upc"] . "' oninput=\"showBARCODE(this.value);\">
                        <div style='width:100%;text-align:center;margin-top:7px;'><img id='prdBARCODE'/></div>";
                    $html .= "<span id='prdUPCerror' style='color:red;font-size:0.8em;'></span>";
                    $html .="</div><br>";
                    $html .="<div class='divBOX'><b>ID de l'emplacement entreposage</b>:
                        <input id='prSTORAGE_IMPORT' style='width:280px;' type='number' value='" . $row["import_storage_id"] . "'>";
                        if ($APREAD_ONLY == false) { $html .="<button onclick=\"openSEL_STORAGE('IMPORT');\"><span class='material-icons' style='font-size:14px;'>search</span></button>";}
                    $html .="</div>				
                    <div class='divBOX'><b>ID de l'emplacement boutique</b>:
                        <input id='prSTORAGE_EXPORT' style='width:280px;' type='number' value='" . $row["export_storage_id"] . "'>";
                        if ($APREAD_ONLY == false) { $html .="<button onclick=\"openSEL_STORAGE('EXPORT');\"><span class='material-icons' style='font-size:14px;'>search</span></button>";}
                    $html .="</div>				
                    <div class='divBOX'><b>Fabriquant</b>:
                        <input id='prBRAND' type='text' value='" . $row["model_year"] . "'>
                    </div>				
                    <div class='divBOX'><b># de Modèle</b>:
                        <input id='prMODEL' type='text' value='" . $row["model_year"] . "'>
                    </div>				
                    <div class='divBOX'><b>Année du modèle</b>:
                        <input id='prMODEL_YEAR' type='number' value='" . $row["model_year"] . "'>
                    </div>
                    <div class='divBOX'>
                        <div style='padding:5px;width:285px;display:inline-block;cursor:pointer;vertical-align:middle;' onclick='document.getElementById(\"prIS_BIO\").focus();document.getElementById(\"prIS_BIO\").click();'>
                        <b>Biologique</b>:</div>
                        <div style='float:right;padding-right:5px;vertical-align:middle;'>
                            <input id='prIS_BIO' type='checkbox' style='margin-top:5px;'"; if ($row["is_bio"] == true){ $html .= " checked"; } $html .= ">
                        </div>
                    </div>		<br>
                    <div class='divBOX' style='min-height:25px;vertical-align:middle;'>
                        <label for='prIS_SCHEDULED'><div style='padding:5px;width:280px;display:inline-block;cursor:pointer;vertical-align:middle;'>
                            <b>Service au taux horaire accessible au publique</b>:</div></label>
                        <div style='float:right;padding-right:5px;vertical-align:middle;'>
                            <input id='prIS_SCHEDULED' type='checkbox'  style='margin-top:5px;'"; if ($row["is_scheduled"] == true){ $html .= " checked"; } $html .= ">
                        </div>
                    </div>        
                    <div class='divBOX'><b>Durée du service</b>:
                        <input id='prSERV_LEN' type='number' value='" . $row["service_length"] . "'>
                    </div>				
                    <div class='divBOX'><b>Délais après le service</b>:
                        <input id='prINTER_LEN' type='number' value='" . $row["inter_length"] . "'>
                    </div>				
                    <div class='divBOX'><b>Incrémenter le panier de x quantité </b>:
                        <input id='prSTEP' type='number' value='" . $row["qty_step"]. "'>
                    </div>	
                    <div class='divBOX'><b>" . $dw3_lbl["KG"]  . "</b>(0.1 = 100g):
                        <input id='prKG' type='number' class='kg' value='" . $row["kg"]. "'>
                    </div>	
                    <div class='divBOX'><b>Litres</b> (0.1 = 100ml):
                        <input id='prLITER' type='number' value='" . $row["liter"] . "'>
                    </div>				
                    <div class='divBOX'><b>" . $dw3_lbl["HEIGHT"]  . "</b>:
                        <input id='prHEIGHT' type='number' class='cm' value='" . $row["height"] . "'>
                    </div>				
                    <div class='divBOX'><b>" . $dw3_lbl["DEPTH"]  . "</b>:
                        <input id='prDEPTH' type='number' class='cm' value='" . $row["depth"] . "'>
                    </div>				
                    <div class='divBOX'><b>" . $dw3_lbl["WIDTH"]  . "</b>:
                        <input id='prWIDTH' type='number' class='cm' value='" . $row["width"] . "'>
                    </div>
                    <div class='divBOX' style='display:none;'><b>Mesure quantitative par emballage</b>:
                        <input id='prPACK' type='number' value='" . $row["pack"] . "'>
                    </div>";	
                    $html .= "<div class='divBOX'><b>Type de mesure</b>:
                            <input type='list' list='PACK_DESC' name='PACK_DESC' id='prPACK_DESC' value='".$row["pack_desc"]."'>
                                <datalist id='PACK_DESC'>";
                        $sql2 = "SELECT DISTINCT pack_desc FROM product ORDER BY pack_desc ASC LIMIT 100;";
                        $result2 = $dw3_conn->query($sql2);
                        if ($result2->num_rows > 0) {
                            while($row2 = $result2->fetch_assoc()) {
                                $html .= "<option value='". $row2["pack_desc"] . "'>";		
                            }
                        }
/*                     $html .= "<div class='divBOX' style=''><b>Type de mesure</b>:
                            <select name='prPACK_DESC' id='prPACK_DESC'>";
                        $sql2 = "SELECT *
                                FROM config
                                WHERE kind = 'PRODUCT_PACK'				
                                ORDER BY code";
                        $result2 = $dw3_conn->query($sql2);
                        if ($result2->num_rows > 0) {
                            $html .= "<option disabled selected value=''>Veuillez choisir un type d'unité</option>";
                            while($row2 = $result2->fetch_assoc()) {
                                if ($row2["code"] == $row["pack_desc"]){ $opt_SELECTED = " selected ";} else { $opt_SELECTED = " "; }
                                $html .= "<option " . $opt_SELECTED . " value='". $row2["code"] . "'>"	. $row2["code"] . " - " . $row2["text1"] . "</option>";		}
                        } else { $html .= "<option disabled selected value=''>Aucun type de mesure de crée</option>"; } */
                    $html .= "</datalist></div>   
                </div>";
//OPTIONS
        $html .= "<h4 onclick=\"toggleFolder('divSubPrd6','Prdup6');\" style=\"background: rgba(255, 255, 255, 0.7);color:#333;text-shadow:none;text-align:left;padding:5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);\">
                    <span id='Prdup6' class=\"material-icons\">folder</span>Options
                </h4>
                <div class=\"divMAIN\" id='divSubPrd6' style='padding-top:0px;transition: height 1.5s;height:0px;display:none;'>";
                    if ($APREAD_ONLY == false) { $html .= "<button class='blue' onclick='addOPTION(". $row["id"] .");'><span class=\"material-icons\">flaky</span> Ajouter une option</button><small>";}
                    $html .="<span class='material-icons'>star</span>Option par défaut</small>
                    <div id='divPrdOpt'></div>
                </div>";

//AFFICHAGE
                    $html .= "<h4 onclick=\"toggleFolder('divSubPrd5','Prdup5');\" style=\"background: rgba(255, 255, 255, 0.7);color:#333;text-shadow:none;text-align:left;padding:5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);\">
                        <span id='Prdup5' class=\"material-icons\">folder</span>Affichage
                        </h4>
                    <div class=\"divMAIN\" id='divSubPrd5' style='padding-top:0px;transition: height 1.5s;height:0px;display:none;'>
                    <div class='divBOX'>
                        <div style='padding:5px;width:285px;display:inline-block;cursor:pointer;vertical-align:middle;' onclick='document.getElementById(\"prMAG_DSP\").focus();document.getElementById(\"prMAG_DSP\").click();'>
                        <b>" . $dw3_lbl["MAG_DSP"]  . "</b>:</div>
                        <div style='float:right;padding-right:5px;vertical-align:middle;'>
                            <input id='prMAG_DSP' type='checkbox' style='margin-top:5px;'"; if ($row["mag_dsp"] == true){ $html .= " checked"; } $html .= ">
                        </div>
                    </div>
                    <div class='divBOX'>
                        <div style='padding:5px;width:285px;display:inline-block;cursor:pointer;vertical-align:middle;' onclick='document.getElementById(\"prWEB_DSP\").focus();document.getElementById(\"prWEB_DSP\").click();'>
                       <b>" . $dw3_lbl["WEB_DSP"] . "</b>:</div>
                        <div style='float:right;padding-right:5px;vertical-align:middle;'>
                            <input id='prWEB_DSP' type='checkbox' style='margin-top:5px;'"; if ($row["web_dsp"] == true){ $html .= " checked"; } $html .= ">
                        </div>
                    </div><br>                    
                    <div class='divBOX' style='min-height:25px;display:none;'>
                        <div style='padding:5px;width:285px;display:inline-block;cursor:pointer;vertical-align:middle;' onclick='document.getElementById(\"prDSP_STATUS\").focus();document.getElementById(\"prDSP_STATUS\").click();'>
                       <b>" . $dw3_lbl["DSP_STATUS"] . "</b>:</div>
                        <div style='float:right;padding-right:5px;vertical-align:middle;'>
                            <input id='prDSP_STATUS' type='checkbox' style='margin-top:5px;'"; if ($row["dsp_status"] == true){ $html .= " checked"; } $html .= ">
                        </div>
                    </div>
                    <div class='divBOX'>
                        <div style='padding:5px;width:285px;display:inline-block;cursor:pointer;vertical-align:middle;' onclick='document.getElementById(\"prDSP_UPC\").focus();document.getElementById(\"prDSP_UPC\").click();'>
                       <b>" . $dw3_lbl["DSP_UPC"] . "</b>:</div>
                        <div style='float:right;padding-right:5px;vertical-align:middle;'>
                            <input id='prDSP_UPC' type='checkbox' style='margin-top:5px;'"; if ($row["dsp_upc"] == true){ $html .= " checked"; } $html .= ">
                        </div>
                    </div>
                    <div class='divBOX' style='min-height:25px;display:none;'>
                        <div style='padding:5px;width:285px;display:inline-block;cursor:pointer;vertical-align:middle;' onclick='document.getElementById(\"prDSP_OPT\").focus();document.getElementById(\"prDSP_OPT\").click();'>
                       <b>" . $dw3_lbl["DSP_OPT"] . "</b>:</div>
                        <div style='float:right;padding-right:5px;vertical-align:middle;'>
                            <input id='prDSP_OPT' type='checkbox' style='margin-top:5px;'"; if ($row["dsp_opt"] == true){ $html .= " checked"; } $html .= ">
                        </div>
                    </div>
                    <div class='divBOX' style='min-height:25px;display:none;'>
                        <div style='padding:5px;width:285px;display:inline-block;cursor:pointer;vertical-align:middle;' onclick='document.getElementById(\"prDSP_EXPORT\").focus();document.getElementById(\"prDSP_EXPORT\").click();'>
                       <b>Afficher emplacement dans le magasin</b>:</div>
                        <div style='float:right;padding-right:5px;vertical-align:middle;'>
                            <input id='prDSP_EXPORT' type='checkbox' style='margin-top:5px;'"; if ($row["dsp_export_storage"] == true){ $html .= " checked"; } $html .= ">
                        </div>
                    </div>
                    <div class='divBOX'>
                        <div style='padding:5px;width:285px;display:inline-block;cursor:pointer;vertical-align:middle;' onclick='document.getElementById(\"prDSP_MESURE\").focus();document.getElementById(\"prDSP_MESURE\").click();'>
                       <b>Afficher les mesures</b>:</div>
                        <div style='float:right;padding-right:5px;vertical-align:middle;'>
                            <input id='prDSP_MESURE' type='checkbox' style='margin-top:5px;'"; if ($row["dsp_mesure"] == true){ $html .= " checked"; } $html .= ">
                        </div>
                        <span style='font-size:12px;margin:30px 0px 0px 7px;'>*Affichés si la valeur les valeur ne sont pas à 0.</span>
                    </div>
                    <div class='divBOX' style='min-height:45px;'>
                        <div style='padding:5px;width:285px;display:inline-block;cursor:pointer;vertical-align:middle;' onclick='document.getElementById(\"prDSP_MESURE\").focus();document.getElementById(\"prDSP_MESURE\").click();'>
                       <b>Afficher la marque, modèle* et l'année*</b>:</div>
                        <div style='float:right;padding-right:5px;vertical-align:middle;'>
                            <input id='prDSP_BRAND' type='checkbox' style='margin-top:5px;'"; if ($row["dsp_model"] == true){ $html .= " checked"; } $html .= ">                           
                        </div>
                        <span style='font-size:12px;margin:30px 0px 0px 7px;'>*Affichés si les valeur ne sont pas vide.</span>
                    </div>
                    <div class='divBOX'>
                        <div style='padding:5px;width:285px;display:inline-block;cursor:pointer;vertical-align:middle;' onclick='document.getElementById(\"prDSP_INV\").focus();document.getElementById(\"prDSP_INV\").click();'>
                       <b>" . $dw3_lbl["DSP_INV"] . "</b>:</div>
                        <div style='float:right;padding-right:5px;vertical-align:middle;'>
                            <input id='prDSP_INV' type='checkbox' style='margin-top:5px;'"; if ($row["dsp_inv"] == true){ $html .= " checked"; } $html .= ">
                        </div>
                    </div>
                    <div class='divBOX'><b>" . $dw3_lbl["PRIX_TEXT"] . "</b>:
                        <input id='prPRIX_TEXT' type='text' value='" . $row["price_text_fr"]. "'>
                    </div>
                    <div class='divBOX'><b>" . $dw3_lbl["PRIX_TEXT_EN"] . "</b>:
                        <input id='prPRIX_TEXT_EN' type='text' value='" . $row["price_text_en"] . "'>
                    </div>
                    <div class='divBOX'><b>" . $dw3_lbl["PRIX_SUFFIX"] . "</b>:
                        <input id='prPRIX_SUFFIX' type='text' value='" . $row["price_suffix_fr"] . "'>
                    </div>
                    <div class='divBOX'><b>" .  $dw3_lbl["PRIX_SUFFIX_EN"] . "</b>:
                        <input id='prPRIX_SUFFIX_EN' type='text' value='" . $row["price_suffix_en"]. "'>
                    </div>    
                    <hr>";
//BOUTON ACTION
                    $html .="<div class='divBOX'><h3>Bouton Action</h3>
                        <b>" . $dw3_lbl["WEB_BTN_FR"] . "</b>:
                        <input id='prWEB_BTN_FR' type='text' value=\"" . $row["web_btn_fr"]. "\">
                        <b>" . $dw3_lbl["WEB_BTN_EN"] . "</b>:
                        <input id='prWEB_BTN_EN' type='text' value='" . $row["web_btn_en"] . "'>
                        <b>Action du boutton de droite</b>:
                        <select id='prBTN_ACTION1'>
                            <option value='DOWNLOAD' "; if ($row["btn_action1"] == "DOWNLOAD"){ $html .= " selected "; } $html .= ">Télécharger, sans payer, ni ouvrir de compte</option>
                            <option value='SUBMIT' "; if ($row["btn_action1"] == "SUBMIT"){ $html .= " selected "; } $html .= ">Formulaire de soumission</option>
                            <option value='CART' "; if ($row["btn_action1"] == "CART"){ $html .= " selected "; } $html .= ">Ajouter au panier</option>
                            <option value='LINK' "; if ($row["btn_action1"] == "LINK"){ $html .= " selected "; } $html .= ">Ouvrir URL Action 1</option>
                            <option value='BUY' "; if ($row["btn_action1"] == "BUY"){ $html .= " selected "; } $html .= ">Payer directement</option>
                            <option value='SUBSCRIBE' "; if ($row["btn_action1"] == "SUBSCRIBE"){ $html .= " selected "; } $html .= ">S'abonner</option>
                            <option value='WISH' "; if ($row["btn_action1"] == "WISH"){ $html .= " selected "; } $html .= ">Ajouter à la liste de favoris</option>
                            <option value='NONE' "; if ($row["btn_action1"] == "NONE"){ $html .= " selected "; } $html .= ">Ne pas afficher ce boutton</option>
                        </select>
                        <b>URL Action 1</b>:
                        <input id='prURL_ACTION1' type='text' value='" . $row["url_action1"] . "'>
                        <b>Icon</b>:
                        <input style='width:80%' id='prWEB_BTN_ICON' type='text' value=\"" . $row["web_btn_icon"]. "\">";
                        if ($APREAD_ONLY == false) { 
                            $html .="<button style='margin:5px;min-width:50px;float:right;' onclick='selICON();'><span id='idhICON_SPAN' class=\"dw3_font\">" . $row["web_btn_icon"] . "</span> ..</button>";
                        }
//BOUTON INFO
                    $html .="</div>
                    <div class='divBOX'><h3>Bouton Info</h3>
                        <b>" . $dw3_lbl["WEB_BTN_FR"] . "2</b>:
                        <input id='prWEB_BTN2_FR' type='text' value=\"" . $row["web_btn2_fr"]. "\">
                        <b>" . $dw3_lbl["WEB_BTN_EN"] . "2</b>:
                        <input id='prWEB_BTN2_EN' type='text' value='" . $row["web_btn2_en"] . "'>
                        <b>Action du boutton de gauche</b>:
                        <select id='prBTN_ACTION2'>
                            <option value='INFO' "; if ($row["btn_action2"] == "INFO"){ $html .= " selected "; } $html .= ">Plus d'infos</option>
                            <option value='NONE' "; if ($row["btn_action2"] == "NONE"){ $html .= " selected "; } $html .= ">Ne pas afficher ce boutton</option>
                        </select>
                        <b>URL Action2</b>:
                        <input id='prURL_ACTION2' type='text' value='" . $row["url_action2"]. "'>
                        <b>Icon 2</b>:
                        <input style='width:80%' id='prWEB_BTN2_ICON' type='text' value='" . $row["web_btn2_icon"] . "'>";
                        if ($APREAD_ONLY == false) { $html .="<button style='margin:5px;min-width:50px;float:right;' onclick='selICON2();'><span id='idhICON2_SPAN' class=\"dw3_font\">" .$row["web_btn2_icon"] . "</span> ..</button>";}
                    $html .="</div><br>   
                    <a href='https://fonts.google.com/icons?selected=Material+Icons' target='_blank'>Google Material Icons - https://fonts.google.com/icons</a>                
                    </div>";	
//DATES DE CRÉATION ET MODIFICATION + API's IDS
                $html .= "<div class='divBOX'><b>Date et utilisateur de création:</b><br>
                ".$row["date_created"]." (".$row["created_name"].")</div>";			
                $html .= "<div class='divBOX'><b>Dernière modification:</b><br>
                ".$row["date_modified"]." (".$row["modified_name"].")</div>";
                $html .= "<div class='divBOX'><b>Square ID</b>:
                            <input disabled type='text' value=\"" . $row["square_id"] . "\">
                        </div>";
                $html .= "
                       <div style='' class='divBOX'><b>Stripe price ID</b>:
                            <input disabled type='text' value=\"" . $row["stripe_price_id"] . "\">
                        </div>
                        <div class='divBOX' style=''>Stripe ID: 
                        ";
                        if ($row["stripe_id"] == ""){
                            $html .= "<button id='btnAddToStripe' style='float:right;' onclick=\"addToSTRIPE('".  $prID ."');this.disabled=true;this.innerHTML='En cours...';\">Associer à Stripe</button>";
                        } else {
                           // $html .= "<button onclick=\"delToSTRIPE('".  $prID ."')\">Dissocier de Stripe</button>";
                        }
                $html .= "<input id='prSTRIPE' disabled type='text' value=\"" . $row["stripe_id"] . "\"></div>";
			$html .= "</div><div class='dw3_form_foot'>";
            if ($APREAD_ONLY == false) { 
				$html .= "<button class='red' onclick='deletePRD(\"" . $row["id"] . "\");'><span class='material-icons'>delete</span></button>
				<button class='blue' onclick='duplicatePRD(\"" . $row["id"] . "\");'><span class='material-icons'>control_point_duplicate</span> Dupliquer</button>
				<button class='green' onclick='updPRD(\"" . $row["id"] . "\");'><span class='material-icons'>save</span></button>";
            } else {
                $html .= "<button class='grey' onclick='closePRD();'><span class='material-icons'>cancel</span> Fermer</button>";
            }
				$html .= "</div>";
		}
	}
$dw3_conn->close();
header('Status: 200');
die($html);
?>