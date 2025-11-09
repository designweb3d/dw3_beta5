<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$line_id   = $_GET['ID'];
echo "<div class='dw3_form_data' style='bottom:50px;'>";
$section_url = "";
	$sql = "SELECT A.*,B.url as section_url FROM index_line A
    LEFT JOIN (SELECT id,url FROM index_head) B ON B.id = A.head_id
    WHERE A.id = '" . $line_id . "' LIMIT 1";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {		
		while($row = $result->fetch_assoc()) {
            $section_url = $row["section_url"];
            echo"<div class='divBOX'>Titre FR: 
                <input id='subTITLE' type='text' style='width:60%;float:right;' value='".$row["title_fr"]."' onclick='detectCLICK(event,this);'>
            </div>";
            echo"<div class='divBOX'>Titre EN:
            <input id='subTITLE_EN' type='text' style='width:60%;float:right;' value='".$row["title_en"]."' onclick='detectCLICK(event,this);'>
            </div>";
            echo"<div class='divBOX' style='display:none;'>Ordre:
            <input id='subORDER' type='text' style='width:60%;float:right;' value='".$row["sort_order"]."' onclick='detectCLICK(event,this);'>
            </div>";
            echo "<div>
                    HTML en français : <button class='red' style='float:right;' title='Enlever les retour chariot' onclick=\"dw3_remove_input_BR('subHTML_FR')\"><span class='material-icons'>free_cancellation</span></button>";
                    if ($CIE_DEEPL_KEY != ""){ echo "<button style='float:right;padding:4px 8px;' onclick=\"dw3_translate(encodeURIComponent('subHTML_FR'),'fr','en','subHTML_EN');\"><span class='material-icons' style='font-size:12px;'>translate</span> fr->en</button>";}
                    echo "<textarea id='subHTML_FR' onfocus='active_input=this.id;' style='height:200px;width:100%;'>".str_replace("<br />","&#13;&#10;",str_replace("<br/>","&#13;&#10;",str_replace("<br>","&#13;&#10;",$row["html_fr"])))."</textarea>
                    HTML en anglais : <button class='red' style='float:right;' title='Enlever les retour chariot' onclick=\"dw3_remove_input_BR('subHTML_EN')\"><span class='material-icons'>free_cancellation</span></button>";
                    if ($CIE_DEEPL_KEY != ""){ echo "<button style='float:right;padding:4px 8px;' onclick=\"dw3_translate(encodeURIComponent('subHTML_EN'),'en','fr','subHTML_FR');\"><span class='material-icons' style='font-size:12px;'>translate</span> en->fr</button>";}            
                    echo "<textarea id='subHTML_EN' onfocus='active_input=this.id;' style='height:200px;width:100%;'>".str_replace("<br />","&#13;&#10;",str_replace("<br/>","&#13;&#10;",str_replace("<br>","&#13;&#10;",$row["html_en"])))."</textarea><br>
                  </div>";
        }
    }
    echo "</div>
    <div class='dw3_form_foot'>";
    if ($section_url != "/pub/section/tabs2/index.php" && $section_url != "/pub/section/tabs3/index.php" && $section_url != "/pub/section/tabs4/index.php"){
        echo "<button class='red' onclick='delSUB_SECTION(\"" . $line_id . "\");'><span class='material-icons'>delete_forever</span></button>";
    }
    echo "<button class='grey' onclick='closeSUB_SECTION();'><span class='material-icons'>cancel</span>Fermer</button> 
        <button class='green' onclick='updSUB_SECTION(\"" . $line_id . "\");'><span class='material-icons'>save</span>Sauvegarder</button>";
    echo "</div>
    ";
$dw3_conn->close();
?>
            