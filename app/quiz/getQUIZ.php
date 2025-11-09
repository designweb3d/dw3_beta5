<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID  = $_GET['ID'];

echo "<div id='divEDIT_HEADER' class='dw3_form_head'>
<h2>Questionnaire # " . $ID . "</b>
 <button style='background:#555555;top:0px;right:0px;padding:4px;position:absolute;' onclick='closeEDITOR(this);'><span class='material-icons'>cancel</span></button>
</div>";

	$sql = "SELECT * FROM prototype_head WHERE id = '" . $ID . "' LIMIT 1";
	$result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {	
		while($row = $result->fetch_assoc()) {
            $isPublished = $row["published"];
            if ($row['link_to_user']){$link_to_user = " checked ";}else{$link_to_user = "";}
            if ($row['captcha_required']){$captcha_required = " checked ";}else{$captcha_required = "";}
            if ($row['allow_user_reedit']){$allow_user_reedit = " checked ";}else{$allow_user_reedit = "";}
            if ($row['allow_user_view']){$allow_user_view = " checked ";}else{$allow_user_view = "";}
            if ($row['auto_add']){$auto_add = " checked ";}else{$auto_add = "";}
            if ($row["published"]=="0"){
                echo "<div style='position:absolute;top:40px;left:0px;right:0px;bottom:50px;overflow-x:hidden;overflow-y:auto;'><div style='font-size:0.7em;line-height:0.4em;'>Lien pour tester le document: <a href='https://".$_SERVER["SERVER_NAME"]."/pub/page/quiz/index.php?ID=".$ID."' target='_blank'>https://".$_SERVER["SERVER_NAME"]."/pub/page/quiz/index.php?ID=".$ID."</a> <button style='margin:2px;' id='btn_copy_url' onclick=\"copy_report_url('".$ID."');\"><span class='material-icons' style='font-size:10px;'>content_copy</span></button></div>";
            } else {
                echo "<div style='position:absolute;top:40px;left:0px;right:0px;bottom:50px;overflow-x:hidden;overflow-y:auto;'>
                <br><b><div style='font-size:0.7em;line-height:0.4em;'><u>Les documents publiés ne peuvent être modifiés, seulement copiés sous un autre nom ou supprimés. </u><br class='br_small'>Lien pour remplir le document: <a href='https://".$_SERVER["SERVER_NAME"]."/pub/page/quiz/index.php?ID=".$ID."' target='_blank'>https://".$_SERVER["SERVER_NAME"]."/pub/page/quiz/index.php?ID=".$ID."</a> <button style='margin:2px;' id='btn_copy_url' onclick=\"copy_report_url('".$ID."');\"><span class='material-icons' style='font-size:10px;'>content_copy</span></button></div></b><br>
                <div style='pointer-events: none;opacity: 0.5;'>";
            }
                    echo "<br>
                    <div class='divBOX'>Titre:<br>
                        <span style='vertical-align:center;font-size:0.8em;'>FR:</span><input id='qzNAME' type='text' value='" . str_replace("'", "\'", htmlspecialchars($row["name_fr"], ENT_QUOTES)) . "' onclick='detectCLICK(event,this);' style='width:90%'><br>
                        <span style='vertical-align:center;font-size:0.8em;'>EN:</span><input id='qzNAME_EN' type='text' value='" . str_replace("'", "\'", htmlspecialchars($row["name_en"], ENT_QUOTES)) . "' onclick='detectCLICK(event,this);' style='width:90%'>
                    </div>				
                    <div class='divBOX'>Description:<br>
                        <span style='vertical-align:center;font-size:0.8em;'>FR:</span><input id='qzDESC' type='text' value='" . str_replace("'", "\'", htmlspecialchars($row["description_fr"], ENT_QUOTES)) . "' onclick='detectCLICK(event,this);' style='width:90%'><br>
                        <span style='vertical-align:center;font-size:0.8em;'>EN:</span><input id='qzDESC_EN' type='text' value='" . str_replace("'", "\'", htmlspecialchars($row["description_en"], ENT_QUOTES)) . "' onclick='detectCLICK(event,this);' style='width:90%'>
                    </div>						
                    <div class='divBOX' style='width:200px;'>#Document suivant:
                        <input id='qzNEXT' type='text' value='" . $row["next_id"]. "' style='width:100px; float:right;text-align:center;' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX' style='width:160px;'>Destinataire:
                        <select id='qzPARENT'>
                            <option value='customer'"; if 	($row["parent_table"] =="customer"){ echo " selected"; } echo ">Client</option>
                            <option value='user'"; if 	($row["parent_table"] =="user"){ echo " selected"; } echo ">Employé</option>
                        </select>
                    </div>
                    <div class='divBOX' style='width:160px;'>Type de total:
                    <select id='qzTYPE'>
                        <option value='NONE'"; if 	($row["total_type"] =="NONE"){ echo " selected"; } echo ">Aucun</option>
                        <option value='CASH'"; if 	($row["total_type"] =="CASH"){ echo " selected"; } echo ">Argent</option>
                        <option value='POINTS'"; if 	($row["total_type"] =="POINTS"){ echo " selected"; } echo ">Points</option>
                        <option value='POURCENT'"; if 	($row["total_type"] =="POURCENT"){ echo " selected"; } echo ">Pourcentage</option>
                    </select>
                    </div>
                    <div class='divBOX' style='width:160px;'>Total maximum:
                        <input id='qzMAX' type='number' value='" . $row["total_max"] . "' onclick='detectCLICK(event,this);'>
                    </div>
                    <div class='divBOX'><label for='qzLINK_TO'>Tenter de trouver le compte par le courriel:</label>
                        <input id='qzLINK_TO' type='checkbox'  style='float:right;margin:5px;'" . $link_to_user . " onclick='detectCLICK(event,this);'>
                    </div>	
                    <div class='divBOX'><label for='qzREEDIT'>Permettre la modification par l'utilisateur après la transmission:</label>
                        <input id='qzREEDIT' type='checkbox'  style='float:right;margin:5px;'" . $allow_user_reedit . " onclick='detectCLICK(event,this);'>
                    </div>	
                    <div class='divBOX'><label for='qzREEDIT'>Demander une réponse Captcha pour envoyer le formulaire:</label>
                        <input id='qzCAPTCHA' type='checkbox'  style='float:right;margin:5px;'" . $captcha_required . " onclick='detectCLICK(event,this);'>
                    </div>	
                    <div class='divBOX'><label for='qzVIEW'>Permettre l'utilisateur de voir le document:</label>
                        <input id='qzVIEW' type='checkbox'  style='float:right;margin:5px;'" . $allow_user_view . " onclick='detectCLICK(event,this);'>
                    </div>	
                    <div class='divBOX'><label for='qzAUTO_ADD'>Ajouter automatiquement pour chaque nouvel utilisateur:</label>
                        <input id='qzAUTO_ADD' type='checkbox'  style='float:right;margin:5px;'" . $auto_add . " onclick='detectCLICK(event,this);'>
                    </div>	
                    ";
		}
	}
    echo "<div id='DIV_LINES'></div>";
    if ($isPublished=="1"){ 
        echo "</div>
            <br><br></div><div class='dw3_form_foot'>
            <button style='background:red;' onclick='deleteQUIZ(\"" .$ID . "\");'><span class='material-icons'>delete</span></button>
            <button onclick='copyQUIZ(\"" . $ID . "\");'><span class='material-icons'>content_copy</span> Copier</button>
        </div>"; 
    } else {
        echo "<br><br></div><div class='dw3_form_foot'>
            <button class='red' onclick='deleteQUIZ(\"" .$ID . "\");'><span class='material-icons'>delete</span></button>
            <button class='blue' onclick='newLINE();'><span class='material-icons'>add</span></button>
            <button class='green' onclick='updQUIZ(\"" . $ID . "\");'><span class='material-icons'>save</span>" . $dw3_lbl["SAVE"] . "</button>
            <button class='orange' onclick='pubQUIZ(\"" . $ID . "\");'><span class='material-icons'>send</span>Publier</button>
        </div>";
    }

    $dw3_conn->close();
?>