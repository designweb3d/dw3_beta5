<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID  = $_GET['ID'];
$text_width  = $_GET['tw'];

	$sql = "SELECT A.*, IFNULL(B.readings,0) AS readings, IFNULL(C.readers,0) AS readers 
    FROM article A
    LEFT JOIN (SELECT article_id,AVG(minuts) AS readings FROM article_readings WHERE article_id = '".$ID."' GROUP BY article_id) B ON A.id = B.article_id
    LEFT JOIN (SELECT article_id,COUNT(*) AS readers FROM article_readings WHERE article_id = '".$ID."' GROUP BY article_id) C ON A.id = C.article_id
    WHERE A.id = " . $ID . " LIMIT 1";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {	

		while($row = $result->fetch_assoc()) {
			echo "<div id='divEDIT_HEADER' class='dw3_form_head'>
                        <h2>Article # " . $row["id"] . "</h2>
                         <button class='grey' style='top:0px;right:0px;padding:4px;position:absolute;' onclick='closeART();'><span class='material-icons'>cancel</span></button>
                </div>
                <div class='dw3_form_data'>
                    <div  style='margin:10px;'><a href='/pub/download/Article_".$row["id"].".pdf' target='_blank'><img src='/pub/img/dw3/pdf.png' style='width:auto;height:25px;vertical-align:middle;'> <u>PDF français</u></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='/pub/download/News_".$row["id"].".pdf' target='_blank'><img src='/pub/img/dw3/pdf.png' style='width:auto;height:25px;vertical-align:middle;'> <u>PDF anglais</u></a></div>
                    <div class='divBOX'>Status:
                        <select name='artACTIVE' id='artACTIVE' onchange='art_updated = true;'>
                            <option value='0'"; if 	($row["is_active"] =="0"){ echo " selected"; } echo ">Inactif</option>
                            <option value='1'"; if 	($row["is_active"] =="1"){ echo " selected"; } echo ">Actif</option>
                        </select>
                        <small>Les articles inactifs peuvent êtres envoyés comme infolettres mais ne pourront pas être visibles sur le site web.</small>
                    </div>    
                    <div class='divBOX'>Auteur:
                        <input id='artAUTHOR' type='text' value='" . $row["author_name"] . "' onclick='detectCLICK(event,this);' oninput='art_updated = true;'>
                    </div>	
                    <br>                 
                    <div class='divBOX'>Catégorie FR:";
                        if ($CIE_DEEPL_KEY != "" && $APREAD_ONLY == false){ echo "<button onclick=\"dw3_translate('artCATEGORY_FR','fr','en','artCATEGORY_EN');\" style='float:right;'>FR -> EN</button>";}
                        echo "<input type='text' list='lstCATEGORY_FR' id='artCATEGORY_FR' value='" . $row["category_fr"] . "' oninput='art_updated = true;'>
                        <datalist id='lstCATEGORY_FR'>";
                            $sqlC = "SELECT DISTINCT category_fr FROM article ORDER BY category_fr ASC";
                            $resultC = $dw3_conn->query($sqlC);
                            if ($resultC->num_rows > 0) {	
                                while($rowC = $resultC->fetch_assoc()) {
                                    echo "<option value='" . htmlspecialchars($rowC["category_fr"], ENT_QUOTES) . "'>";
                                }
                            }
                        echo "</datalist>
                    </div>                                     
                    <div class='divBOX'>Catégorie EN:";
                        if ($CIE_DEEPL_KEY != "" && $APREAD_ONLY == false){ echo "<button onclick=\"dw3_translate('artCATEGORY_EN','en','fr','artCATEGORY_FR');\" style='float:right;'>EN -> FR</button>";}
                        echo "<input type='text' list='lstCATEGORY_EN' id='artCATEGORY_EN' value='" . $row["category_en"] . "' oninput='art_updated = true;'>
                        <datalist id='lstCATEGORY_EN'>";
                            $sqlC = "SELECT DISTINCT category_en FROM article ORDER BY category_en ASC";
                            $resultC = $dw3_conn->query($sqlC);
                            if ($resultC->num_rows > 0) {	
                                while($rowC = $resultC->fetch_assoc()) {
                                    echo "<option value='" . htmlspecialchars($rowC["category_en"], ENT_QUOTES) . "'>";
                                }
                            }
                        echo "</datalist>
                    </div>                                     	
                    <br>              
                    <div class='divBOX'>Titre de l'article FR:";
                        if ($CIE_DEEPL_KEY != "" && $APREAD_ONLY == false){ echo "<button onclick=\"dw3_translate('artTITLE_FR','fr','en','artTITLE_EN');\" style='float:right;'>FR -> EN</button>";}
                        echo "<input id='artTITLE_FR' type='text' value='" . str_replace("'", "\'", htmlspecialchars($row["title_fr"], ENT_QUOTES)) . "' onclick='detectCLICK(event,this);' oninput='art_updated = true;'>
                    </div>				
                    <div class='divBOX'>Titre de l'article EN:";
                        if ($CIE_DEEPL_KEY != "" && $APREAD_ONLY == false){ echo "<button onclick=\"dw3_translate('artTITLE_EN','en','fr','artTITLE_FR');\" style='float:right;'>FR -> EN</button>";}
                        echo "<input id='artTITLE_EN' type='text' value='" . str_replace("'", "\'", htmlspecialchars($row["title_en"], ENT_QUOTES)) . "' onclick='detectCLICK(event,this);' oninput='art_updated = true;'>
                    </div>		<br>
                    <div class='divBOX'>Description FR:";
                        if ($CIE_DEEPL_KEY != "" && $APREAD_ONLY == false){ echo "<button onclick=\"dw3_translate('artDESC_FR','fr','en','artDESC_EN');\" style='float:right;'>FR -> EN</button>";}
                        echo "<textarea id='artDESC_FR' style='height:100px;width:100%;' oninput='art_updated = true;'>" . $row["description_fr"] . "</textarea>
                    </div>	
                    <div class='divBOX'>Description EN:";
                        if ($CIE_DEEPL_KEY != "" && $APREAD_ONLY == false){ echo "<button onclick=\"dw3_translate('artDESC_EN','en','fr','artDESC_FR');\" style='float:right;'>EN -> FR</button>";}
                        echo "<textarea id='artDESC_EN' style='height:100px;width:100%;' oninput='art_updated = true;'>" . $row["description_en"] . "</textarea>
                    </div>		<br>	
                    <div class='divBOX' style='max-width:670px;'>Image principale:";
                    if ($CIE_GROK_KEY != "" && $APREAD_ONLY == false){ echo "<button onclick=\"dw3_grok_image('artDESC_FR','imgART_IMG','artIMG','/pub/upload/');\" style='float:right;'><span style='font-size:16px;' title='Générer un article à partir de la description française avec Grok AI' class='material-icons'>auto_awesome</span> Grok</button>";}
                    if ($CIE_GPT_KEY != "" && $APREAD_ONLY == false){ echo "<button onclick=\"dw3_gpt_image('artDESC_FR','imgART_IMG','artIMG','/pub/upload/');\" style='float:right;'><span style='font-size:16px;' title='Générer un article à partir de la description française avec ChatGPT AI' class='material-icons'>auto_awesome</span> ChatGPT</button>";}
                        echo "<input id='artIMG' type='text' value='" . $row["img_link"] . "' onclick='detectCLICK(event,this);' oninput='art_updated = true;'>";
                        if ($APREAD_ONLY == false){
                            echo "<button onclick=\"rotate_art_img('90');\"><span class='material-icons'>rotate_90_degrees_ccw</span></button>
                            <button onclick=\"rotate_art_img('-90');\"><span class='material-icons'>rotate_90_degrees_cw</span></button>
                            <button class='blue' onclick='selTOP_IMG();'><span class='material-icons'>add_a_photo</span></button>";
                        }
                        echo "<img id='imgART_IMG' style='width:100%;height:auto;' src='/pub/upload/" . $row["img_link"] . "'>
                    </div><br>		
                    <div class='divBOX' style='max-width:670px;'>HTML FR:";
                        if ($CIE_GPT_KEY != "" && $APREAD_ONLY == false){ echo "<button onclick=\"dw3_gpt_chat('artDESC_FR','artHTML_FR');\" style='float:right;'><span style='font-size:16px;' title='Générer un article à partir de la description française avec ChatGPT AI' class='material-icons'>auto_awesome</span> Chat GPT</button>";}
                        if ($CIE_GROK_KEY != "" && $APREAD_ONLY == false){ echo "<button onclick=\"dw3_grok_chat('artDESC_FR','artHTML_FR');\" style='float:right;'><span style='font-size:16px;' title='Générer un article à partir de la description française avec Grok AI' class='material-icons'>auto_awesome</span> Grok</button>";}
                        if ($CIE_DEEPL_KEY != "" && $APREAD_ONLY == false){ echo "<button onclick=\"dw3_translate('artHTML_FR','fr','en','artHTML_EN');\" style='float:right;'>FR -> EN</button>";}
                        echo "<br><button class='white' onclick=\"active_input='artHTML_FR';showCharAdd()\">😈</button>";
                        echo "<button class='white' onclick=\"active_input='artHTML_FR';toggleBOLD()\" title='Gras'><b>B</b></button>";
                        echo "<button class='white' onclick=\"active_input='artHTML_FR';toggleITALIC()\" title='Italique'><i>I</i></button>";
                        echo "<button class='white' onclick=\"active_input='artHTML_FR';toggleUNDERLINE()\" title='Soulignement'><u>U</u></button>";
                        echo "<button class='white' onclick=\"active_input='artHTML_FR';toggleH3()\" title='Entête #3'><b>H3</b></button>";
                        echo "<button class='white' onclick=\"active_input='artHTML_FR';toggleH4()\" title='Entête #4'><b>H4</b></button>";
                        echo "<button class='white' onclick=\"active_input='artHTML_FR';selINLINE_IMG()\" title='Ajouter une photo'><span class='material-icons' style='font-size:16px;'>add_a_photo</span></button>";
                        echo "<button class='white' onclick='wygART_FR();' title='Voir le résultat'><span class='material-icons' style='font-size:16px;'>visibility</span></button>";
                        echo "<textarea id='artHTML_FR' onfocus='active_input=this.id;' oninput='wygART_FR();art_updated = true;' style='height:200px;width:100%;'>" . str_replace("<br />","\n",str_replace("<br/>","\n",str_replace("<br>","\n",$row["html_fr"]))) . "</textarea>
                    </div>				
                    <div class='divBOX' style='max-width:670px;'>HTML EN:";
                    if ($CIE_GPT_KEY != "" && $APREAD_ONLY == false){ echo "<button onclick=\"dw3_gpt_chat('artDESC_EN','artHTML_EN');\" style='float:right;'><span style='font-size:16px;' title='Générer un article à partir de la description anglaise avec ChatGPT AI' class='material-icons'>auto_awesome</span> Chat GPT</button>";}
                    if ($CIE_GROK_KEY != "" && $APREAD_ONLY == false){ echo "<button onclick=\"dw3_grok_chat('artDESC_EN','artHTML_EN');\" style='float:right;'><span style='font-size:16px;' title='Générer un article à partir de la description anglaise avec Grok AI' class='material-icons'>auto_awesome</span> Grok</button>";}
                    if ($CIE_DEEPL_KEY != "" && $APREAD_ONLY == false){ echo "<button onclick=\"dw3_translate('artHTML_EN','en','fr','artHTML_FR');\" style='float:right;'>EN -> FR</button>";}
                        echo "<br><button class='white' onclick=\"active_input='artHTML_EN';showCharAdd()\">😈</button>";
                        echo "<button class='white' onclick=\"active_input='artHTML_EN';toggleBOLD()\" title='Bold'><b>B</b></button>";
                        echo "<button class='white' onclick=\"active_input='artHTML_EN';toggleITALIC()\" title='Italic'><i>I</i></button>";
                        echo "<button class='white' onclick=\"active_input='artHTML_EN';toggleUNDERLINE()\" title='Underline'><u>U</u></button>";
                        echo "<button class='white' onclick=\"active_input='artHTML_EN';toggleH3()\" title='Header #3'><b>H3</b></button>";
                        echo "<button class='white' onclick=\"active_input='artHTML_EN';toggleH4()\" title='Header #4'><b>H4</b></button>";
                        echo "<button class='white' onclick=\"active_input='artHTML_EN';selINLINE_IMG()\" title='Add a picture'><span class='material-icons' style='font-size:16px;'>add_a_photo</span></button>";
                        echo "<button class='white' onclick='wygART_EN();' title='View result'><span class='material-icons' style='font-size:16px;'>visibility</span></button>";
                        echo "<textarea id='artHTML_EN' onfocus='active_input=this.id;' oninput='wygART_EN();art_updated = true;' style='height:200px;width:100%;'>" . str_replace("<br />","\n",str_replace("<br/>","\n",str_replace("<br>","\n",$row["html_en"]))) . "</textarea>
                    </div>";

                    echo "<br>
                    <div class='divBOX'>Permettre les commentaires:
                        <select id='artCOMMENT' onchange='art_updated = true;'>
                            <option value='0'"; if 	($row["allow_comments"] =="0"){ echo " selected"; } echo ">Non</option>
                            <option value='1'"; if 	($row["allow_comments"] =="1"){ echo " selected"; } echo ">Oui</option>
                        </select>
                    </div>  	
                    <div class='divBOX'>Date de publication:
                        <input id='artCREATED' type='datetime-local' value='" . $row["date_created"] . "' onclick='detectCLICK(event,this);' oninput='art_updated = true;'>
                    </div>				
                    <div class='divBOX'>Date de la dernière modification:
                        <input id='artMODIFIED' type='datetime-local' value='" . $row["date_modified"] . "' onclick='detectCLICK(event,this);' oninput='art_updated = true;'>
                    </div>										
                    <div class='divBOX'><b>Lectures</b><br>
                        Temps de lecture calculé selon le nombre de mots:
                        <input type='text' value='" . round(str_word_count($row["html_fr"])/130) . " min.' style='text-align:right;' onclick='detectCLICK(event,this);' oninput='art_updated = true;'>
                        Moyenne de temps des lecteurs:
                        <input disabled type='text' value='" . round($row["readings"],2) . " min.' style='text-align:right;' onclick='detectCLICK(event,this);'>
                        Nombre total de lecteurs:
                        <input disabled type='text' value='" . $row["readers"] . "' style='text-align:right;' onclick='detectCLICK(event,this);'>
                    </div>										
				<br><br></div><div class='dw3_form_foot' style='padding-top:5px;'>";
                    if ($APREAD_ONLY == false) { echo  "<button class='red' onclick='deleteART(\"" . $row["id"] . "\");'><span class='material-icons'>delete</span></button>"; }
                    echo "<button class='grey' onclick='closeART();'><span class='material-icons'>cancel</span></button>";
                    if ($APREAD_ONLY == false) { echo "<button class='blue' onclick='sendART(\"" . $row["id"] . "\",\"\");'><span class='material-icons'>send</span> Envoyer</button>";}
                    if ($APREAD_ONLY == false) { echo "<button class='green' onclick='updART(\"" . $row["id"] . "\");'><span class='material-icons'>save</span></button>";}
				echo "</div>";
		}
	
	}
$dw3_conn->close();
exit();
?>