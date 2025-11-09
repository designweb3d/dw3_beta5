<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID  = $_GET['ID'];
$html = "";
$sql = "SELECT A.*, B.name_fr AS product_name, C.quality_v1_desc, C.quality_v2_desc, C.quality_v3_desc, C.quality_v4_desc, F.name AS customer_name, C.delay_by_unit,
        CONCAT(IFNULL(E.name,'Adresse'), ' (', IFNULL(D.local,''), ' ', IFNULL(D.row,'Non définie'), ' ', IFNULL(D.shelf,''), ' ', IFNULL(D.section,''), ')') AS storage_desc
FROM production A 
LEFT JOIN (SELECT id, product_id,quality_v1_desc, quality_v2_desc, quality_v3_desc, quality_v4_desc, delay_by_unit FROM procedure_head) C ON A.procedure_id = C.id
LEFT JOIN (SELECT id, name_fr FROM product) B ON C.product_id = B.id
LEFT JOIN storage D ON D.id = A.storage_id
LEFT JOIN location E ON D.location_id = E.id
LEFT JOIN order_head F ON A.order_id = F.id
WHERE A.id = '".$ID."' LIMIT 1";
$result = $dw3_conn->query($sql);
$qty_needed = 0;
if ($result->num_rows > 0) {		
    while($row = $result->fetch_assoc()) {
        $PROC_ID = $row["procedure_id"];
        $PROD_STATUS = $row["status"];
        $estimated_time = $row["delay_by_unit"]*$row["qty_needed"];
        $date_estimated = date('Y-m-d H:i:s', strtotime($row["date_start"] . ' +' . $estimated_time . ' minutes'));
        $html .= "<div id='divEDIT_HEADER' class='dw3_form_head'>
                <h3>Production #". $row["id"] ."</h3>
                <button class='dw3_form_close' onclick='closePRODUCTION();'><span class='material-icons'>cancel</span></button>
            </div>
        <div class='dw3_form_data'><table class='tblSIDE_TH' style='text-align:left;font-size:0.8em;white-space:normal;'>";
            $html .= "<tr><th>Status: ";
            if ($PROD_STATUS=='TO_DO'){$html .= "<span style='float:right;margin-right:5px;color:white;background-color:darkgrey;padding:1px 4px;border-radius:10px;'>À faire</span>";}
            if ($PROD_STATUS=='IN_PRODUCTION'){$html .= "<span style='float:right;margin-right:5px;color:white;background-color:blue;padding:1px 4px;border-radius:10px;'>En cours</span>";}
            if ($PROD_STATUS=='ON_HOLD'){$html .= "<span style='float:right;margin-right:5px;color:white;background-color:gold;padding:1px 4px;border-radius:10px;'>En attente</span>";}
            if ($PROD_STATUS=='COMPLETED'){$html .= "<span style='float:right;margin-right:5px;color:white;background-color:green;padding:1px 4px;border-radius:10px;'>Complété</span>";}
            if ($PROD_STATUS=='CANCELLED'){$html .= "<span style='float:right;margin-right:5px;color:white;background-color:red;padding:1px 4px;border-radius:10px;'>Annulé</span>";}
            $html .= "</th><td>";
            if ($APREAD_ONLY == false) { 
                if($PROD_STATUS=='TO_DO'){
                    $html .= " <button class='blue' onclick=\"updPROD_STATUS('".$row["id"]."','IN_PRODUCTION');\">Démarrer</button>";
                } elseif($PROD_STATUS=='IN_PRODUCTION'){
                    $html .= " <button class='gold' onclick=\"updPROD_STATUS('".$row["id"]."','ON_HOLD');\">En attente</button>";
                    $html .= " <button class='green' onclick=\"updPROD_STATUS('".$row["id"]."','COMPLETED');\">Complété</button>";
                    $html .= " <button class='red' onclick=\"updPROD_STATUS('".$row["id"]."','CANCELLED');\">Annuler</button>";
                } elseif($PROD_STATUS=='ON_HOLD'){
                    $html .= " <button class='blue' onclick=\"updPROD_STATUS('".$row["id"]."','IN_PRODUCTION');\">Reprendre</button>";
                    $html .= " <button class='red' onclick=\"updPROD_STATUS('".$row["id"]."','CANCELLED');\">Annuler</button>";
                } elseif($PROD_STATUS=='COMPLETED'){
                    //$html .= " <button onclick=\"updPROD_STATUS('IN_PRODUCTION');\">Remettre en production</button>";
                } elseif($PROD_STATUS=='CANCELLED'){
                    //$html .= " <button onclick=\"updPROD_STATUS('TO_DO');\">Remettre à faire</button>";
                }
            $html .= "<button style='padding:0px;float:right' onclick='infoPROD_STATUS();'><span class='material-icons'>info</span></button></td></tr>";
            }
            $html .= "<tr><th>Produit</th><td style='text-align:center;font-weight:bold;'>" . $row["product_name"] . "</td></tr>";
            $html .= "<tr><th>Quantité à produire</th><td style='text-align:center;font-weight:bold;'><input id='prodQTY_NEEDED' type='number' value='" . $row["qty_needed"] . "'><span id='lblQTY_NEEDED' style='color:red;font-size:0.8em;'></span></td></tr>";
            $html .= "<tr><th>Quantité produite</th><td style='text-align:center;font-weight:bold;'><input id='prodQTY_PRODUCED' type='number' value='" . $row["qty_produced"] . "'></td></tr>";
            $html .= "<tr><th>Lot #</th><td style='text-align:center;font-weight:bold;'><input id='prodLOT' type='text' value='" . $row["lot_no"] . "'><span id='lblLOT' style='color:red;font-size:0.8em;'></span></td></tr>";
            $html .= "<tr><th>Commande</th><td style='text-align:left;font-weight:bold;'>
                                <input id='prodORDER_CLI' disabled type='text' value='" . dw3_decrypt($row["customer_name"]) . "'>
                                <input id='prodORDER' type='number' value='" . $row["order_id"] . "' style='width:85%;'>";
                                if ($APREAD_ONLY == false) { $html .= "<button style='padding:0px;float:right' onclick='openSEL_ORDER();'><span class='material-icons'>search</span></button></td></tr>";}
            $html .= "<tr><th>Emplacement post-production</th><td style='text-align:left;font-weight:bold;'>
                                <input id='prodSTORAGE_DESC' disabled type='text' value='" . $row["storage_desc"] . "'>
                                <input id='prodSTORAGE' type='number' value='" . $row["storage_id"] . "' style='width:85%;'>";
                                if ($APREAD_ONLY == false) { $html .= "<button style='padding:0px;float:right' onclick='openSEL_STORAGE();'><span class='material-icons'>search</span></button>";}
                                $html .= "<span id='lblSTORAGE' style='color:red;font-size:0.8em;'></span></td></tr>";
            $html .= "<tr"; if ($row["quality_v1_desc"] == "") { $html .=" style='display:none;' "; } $html .= "><th style='max-width:250px;'>".$row["quality_v1_desc"]."</th><td style='text-align:center;font-weight:bold;'><input id='prodQUALITY_1' type='text' value='" . $row["quality_val1"] . "'></td></tr>";
            $html .= "<tr"; if ($row["quality_v2_desc"] == "") { $html .=" style='display:none;' "; } $html .= "><th style='max-width:250px;'>".$row["quality_v2_desc"]."</th><td style='text-align:center;font-weight:bold;'><input id='prodQUALITY_2' type='text' value='" . $row["quality_val2"] . "'></td></tr>";
            $html .= "<tr"; if ($row["quality_v3_desc"] == "") { $html .=" style='display:none;' "; } $html .= "><th style='max-width:250px;'>".$row["quality_v3_desc"]."</th><td style='text-align:center;font-weight:bold;'><input id='prodQUALITY_3' type='text' value='" . $row["quality_val3"] . "'></td></tr>";
            $html .= "<tr"; if ($row["quality_v4_desc"] == "") { $html .=" style='display:none;' "; } $html .= "><th style='max-width:250px;'>".$row["quality_v4_desc"]."</th><td style='text-align:center;font-weight:bold;'><input id='prodQUALITY_4' type='text' value='" . $row["quality_val4"] . "'></td></tr>";
            $html .= "<tr><th>Mis en production</th><td><input id='prodSTART' type='datetime-local' value='" . $row["date_start"] . "'></td></tr>";
            $html .= "<tr><th>Durée estimée</th><td><input disabled type='text' value='" . $estimated_time . " min.'></td></tr>";
            $html .= "<tr><th>Fin estimée</th><td><input disabled type='datetime-local' value='" . $date_estimated . "'></td></tr>";
            $html .= "<tr><th>Fin de production</th><td><input id='prodEND' type='datetime-local' value='" . $row["date_end"] . "'></td></tr>";
            $html .= "</table>";		
		}
	}
//LINES OF THE PROCEDURE
    $html .= "<div style='font-size:0.9em;text-align:left;'>";
	$sql = "SELECT A.*, IFNULL(B.name_fr,'Non défini') AS product_name
    FROM procedure_line A 
    LEFT JOIN (SELECT id, name_fr FROM product) B ON A.product_id = B.id
    WHERE A.procedure_id = '" . $PROC_ID . "'";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {	
        $html .= "<table class='tblDATA' style='text-align:left;font-size:0.8em;'><tr><th>Composants</th><th style='width:50px;text-align:center;'>Qte/Un</th><th style='width:50px;text-align:center;'>Total</th></tr>";	
		while($row = $result->fetch_assoc()) {
            $html .= "<tr>";
            $html .= "<td>" . $row["product_name"] . "</td>";
            $html .= "<td style='text-align:center;'>" . $row["qty_by_unit"] . "</td>";
            $html .= "<td style='text-align:center;'>" . $row["qty_by_unit"] * $qty_needed. "</td>";
            $html .= "</tr>";
        }
        $html .= "</table>";           
	} else {
        $html .= "<div style='text-align:center;font-size:0.9em;color:grey;padding:20px;'><i>Aucune ligne définie dans cette procédure.</i></div>";
    }
    $html .= "</div></div><div class='dw3_form_foot'>";
        if ($APREAD_ONLY == false) { $html .= "<button class='red' onclick='deletePRODUCTION(".$ID.");'><span class='material-icons'>delete</span></button>"; }
        if ($APREAD_ONLY == false) {
            $html .= "<button class='grey' onclick='closePRODUCTION();'><span class='material-icons' style='vertical-align:middle;'>cancel</span></button>";
        } else {
            $html .= "<button class='grey' onclick='closePRODUCTION();'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Fermer</button>";
        }
        if($PROD_STATUS != 'COMPLETED' && $PROD_STATUS != 'CANCELLED' && $APREAD_ONLY == false) {
            $html .= "<button class='green' onclick='updPRODUCTION(".$ID.");'><span class='material-icons' style='vertical-align:middle;'>save</span> Enregistrer</button>";
        }
    $html .= "</div>";    

$dw3_conn->close();
header('Status: 200');
die($html);
?>