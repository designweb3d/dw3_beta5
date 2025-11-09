<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID  = $_GET['ID'];
$html = "";
	$sql = "SELECT A.*, IFNULL(B.name_fr,'Non défini') AS product_name, IFNULL(C.name_fr,'Non défini') AS supply_name
    FROM procedure_head A 
    LEFT JOIN (SELECT id, name_fr FROM product) B ON A.product_id = B.id
    LEFT JOIN (SELECT id, name_fr FROM supply) C ON A.supply_id = C.id
    WHERE A.id = '" . $ID . "' LIMIT 1";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {		
		while($row = $result->fetch_assoc()) {
			$html .= "<div id='divEDIT_HEADER' class='dw3_form_head'>
                        <h3>Procédure #". $row["id"] ."</h3>
                        <button class='dw3_form_close' onclick='closePROCEDURE();'><span class='material-icons'>cancel</span></button>
                    </div>
                    <div class='dw3_form_data'>"; 
            $html .= "<input id='procID' type='hidden' value='" . $row["id"] . "'>";           
//NAME
            $html .= "<div class='divBOX'><b>Nom</b>:
                        <input id='headNOM' type='text' value=\"" . $row["name_fr"] . "\">
                    </div>";
//PRODUCT
            $html .= "<div class='divBOX'><b>Produit #</b>:";
            if ($APREAD_ONLY == false) { $html .= "<button class='blue' style='float:right;padding:0px;' onclick=\"openSEL_PRD('HEAD');\"><span class='material-icons'>search</span></button>";}
            $html .= "<input id='headPRD_NAME' disabled type='text' value=\"" . $row["product_name"] . "\">
                        <input id='headPRD' type='number' value=\"" . $row["product_id"] . "\">
                    </div>";
//EMBALLAGE
            $html .= "<div class='divBOX'><b>Emballage #</b>:";
            if ($APREAD_ONLY == false) { $html .= "<button class='blue' style='float:right;padding:0px;' onclick=\"openSEL_SUPPLY();\"><span class='material-icons'>search</span></button>";}
            $html .= "<input id='headSUPPLY_NAME' disabled type='text' value=\"" . $row["supply_name"] . "\">
                        <input id='headSUPPLY' type='number' value=\"" . $row["supply_id"] . "\">
                    </div>";
//TEMPS ESTIMÉ
            $html .= "<div class='divBOX'><b>Délai par unité (minutes)</b>:
                        <input id='headDELAY' type='number' value=\"" . $row["delay_by_unit"] . "\">
                    </div>";
//NAME VERIF 1
            $html .= "<div class='divBOX'><b>Nom verif. 1 qualité</b>:
                        <input id='headQ1' type='text' value=\"" . $row["quality_v1_desc"] . "\">
                    </div>";
//NAME VERIF 2
            $html .= "<div class='divBOX'><b>Nom verif. 2 qualité</b>:
                        <input id='headQ2' type='text' value=\"" . $row["quality_v2_desc"] . "\">
                    </div>";
//NAME VERIF 3
            $html .= "<div class='divBOX'><b>Nom verif. 3 qualité</b>:
                        <input id='headQ3' type='text' value=\"" . $row["quality_v3_desc"] . "\">
                    </div>";
//NAME VERIF 4
            $html .= "<div class='divBOX'><b>Nom verif. 4 qualité</b>:
                        <input id='headQ4' type='text' value=\"" . $row["quality_v4_desc"] . "\">
                    </div><hr>";
//LINES
            $html .= "<div style='font-size:0.9em;text-align:left;'><b>Lignes de la procédure</b>: ";
            if ($APREAD_ONLY == false) { $html .= "<button class='green' style='float:right;padding:0px;margin:7px;' onclick=\"newPROCEDURE_LINE('" . $row["id"] . "');\"><span class='material-icons'>add</span></button>"; }
            $html .= "  <div id='divEDIT_LINES' style='margin-top:10px;'></div></div>";
			$html .= "</div><div class='dw3_form_foot'>";
				if ($APREAD_ONLY == false) { 
                    $html .= "<button class='red' onclick=\"deletePROCEDURE('" . $row["id"] . "');\"><span class='material-icons'>delete</span></button>
                        <button class='blue' onclick=\"duplicatePROCEDURE('" . $row["id"] . "');\"><span class='material-icons'>control_point_duplicate</span> Dupliquer</button>
                        <button class='green' onclick=\"updPROCEDURE('" . $row["id"] . "');\"><span class='material-icons'>save</span></button>";
                } else {
                    $html .= "<button class='grey' onclick=\"closePROCEDURE();\"><span class='material-icons'>close</span> Fermer</button>";
                }
				$html .= "</div>";
		}
	}
$dw3_conn->close();
header('Status: 200');
die($html);
?>