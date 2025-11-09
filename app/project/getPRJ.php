<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID  = $_GET['ID'];
$html = "";
$text_width  = $_GET['tw'];

	$sql = "SELECT A.*, IFNULL(B.last_name,'') as customer_name, IFNULL(B.tel1,'') as customer_tel, IFNULL(B.eml1,'') as customer_eml, IFNULL(C.name,'') as user_modified, IFNULL(D.name,'') as user_created
			FROM project A
            LEFT JOIN (SELECT * FROM customer) B ON B.id = A.customer_id 
            LEFT JOIN (SELECT id,name FROM user) C ON C.id = A.user_modified 
            LEFT JOIN (SELECT id,name FROM user) D ON D.id = A.user_created 
			WHERE A.id = '" . $ID . "'
            ORDER BY A.date_modified ASC
			LIMIT 1";

	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {	

		while($row = $result->fetch_assoc()) {
			$html .= "<div id='divEDIT_HEADER' class='dw3_form_head'>
                            <span style='font-size:0.8em;position:absolute;top:5px;left:15px;background:#" .$CIE_COLOR2 . ";border-radius:6px;padding:3px;'>";
                                if 	($row["status"] =="0"){ $html .= " <b style='color:goldenrod;'>(À VENIR)</b>"; }
                                if 	($row["status"] =="1"){ $html .= " <b style='color:blue;'>(EN COURS)</b>"; }
                                if 	($row["status"] =="2"){ $html .= " <b style='color:green;'>(TERMINÉ)</b>"; }
                                if 	($row["status"] =="3"){ $html .= " <b style='color:red;'>(ANNULÉ)</b>"; }
                $html .= " </span>
                            <h3 style='vertical-align:middle;height:40px;'><div style='display: grid;align-items: center;height:40px;'>Projet #" . $row["id"]."</div></h3>
                            <button class='grey' style='top:0px;right:0px;padding:4px;position:absolute;' onclick='closeEDITOR(this);'><span class='material-icons'>cancel</span></button>
                        </div>";
            $html .= "<div style='position:absolute;top:40px;left:0px;width:100%;bottom:0px;overflow-x:hidden;overflow-y:auto;'> 
                        <div id='divTOTAL' style='padding:3px;background:rgba(200, 200, 200, 0.7);text-align:right;'></div>";

            $html .= "<h4 onclick=\"toggleSub('divSub7','up7');\" style=\"text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;border-bottom: 1mm ridge rgba(0, 199, 30, .6);background: rgba(200, 200, 200, 0.7);\">
                    <span class=\"material-icons\">sticky_note_2</span> Entête de projet <span id='up7' class=\"material-icons\" style='float:right;margin-right:5px;'>keyboard_arrow_up</span>
                 </h4>
                <div class='divMAIN' id='divSub7' style='height:0px;display:none;margin-bottom:0px;'>			
                    <div class='divBOX'>Nom du projet:
                        <input id='prjID' style='display:none;' type='text' value='" . $row["id"] . "'>
                        <input id='prjCLI' style='display:none;' type='text' value='" . $row["customer_id"] . "'>
                        <input id='prjNOM' type='text' value='" . str_replace("'", "\'", htmlspecialchars($row["title"], ENT_QUOTES)) . "' onclick='detectCLICK(event,this);'>
                    </div>";			
                    $html .="<div class='dw3_box'>Status du projet<select id='prjSTAT'>
                        <option "; if ($row["status"] =="0"){ $html .= "selected"; }$html .=" value='0'>À VENIR</option>
                        <option "; if ($row["status"] =="1"){ $html .= "selected"; }$html .=" value='1'>EN COURS</option>
                        <option "; if ($row["status"] =="2"){ $html .= "selected"; }$html .=" value='2'>TERMINÉ</option>
                        <option "; if ($row["status"] =="3"){ $html .= "selected"; }$html .=" value='3'>ANNULÉ</option>
		            </select></div><br>";
                    $html .="<div class='divBOX' style='width:auto;max-width:100%;'>Description:<br>
                        <textarea style='height:50px;width:" . $text_width . "px;' id='prjDESC'>" . $row["description"] . "</textarea>
                    </div><br>                    
                    <div class='divBOX'>" .$dw3_lbl["ADR"] . ":
                        <input id='prjADR' type='text' value='" . htmlspecialchars($row["adr"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'>" .$dw3_lbl["VILLE"] . ":
                        <input id='prjVILLE' type='text' value='" . htmlspecialchars($row["city"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'>" .$dw3_lbl["PROV"] . ":
                        <input id='prjPROV' type='text' value='" . htmlspecialchars($row["province"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'><br>" .$dw3_lbl["PAYS"] . ":
                        <input id='prjPAYS' type='text' value='" . htmlspecialchars($row["country"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'>" .$dw3_lbl["CP"] . ":
                        <input id='prjCP' type='text' value='" . htmlspecialchars($row["postal_code"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div><br>
                    <div class='divBOX' style='width:auto;max-width:100%;'>Notes:<br>
                        <textarea style='height:100px;width:" . $text_width . "px;' id='prjNOTE'>" . $row["note"] . "</textarea>
                    </div><br>";                  
             if ($APREAD_ONLY == false) { $html .="<button class='red' onclick='deletePRJ(\"" . $row["id"] . "\");'><span class='material-icons'>delete</span> Supprimer</button>";}
             if ($APREAD_ONLY == false) { $html .="<button class='green' onclick='updPRJ(\"" . $row["id"] . "\");'><span class='material-icons'>save</span> Enregistrer</button>";}
                $html .= "<br>
                    <div class='divBOX'>" .$dw3_lbl["DTDU"] . ":
                        <input id='prjDTDU' type='datetime-local' value='" . $row["date_due"] . "'>
                    </div>	
                <br>
                    <div class='divBOX'>" .$dw3_lbl["DTAD"] . ":
                        <input id='prjDTAD' type='datetime-local' value='" . $row["date_created"] . "'>
                        <input id='prjUSAD' type='text' value='" . $row["user_created"] . "' disabled>
                    </div>			
                    <div class='divBOX'>" .$dw3_lbl["DTMD"] . ":
                        <input id='prjDTMD' type='datetime-local' value='" . $row["date_modified"] . "' disabled>
                        <input id='prjUSMD' type='text' value='" . $row["user_modified"] . "' disabled>
                    </div>
                </div>";
		}
	
	}

//GET LGNS
    $html .= "<div id='divPRJ_LINES'></div>";


$dw3_conn->close();
die($html);
?>
