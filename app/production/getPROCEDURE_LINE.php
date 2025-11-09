<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID  = $_GET['ID'];
$html = "";
	$sql = "SELECT A.*, IFNULL(B.name_fr,'Non défini') AS product_name
    FROM procedure_line A 
    LEFT JOIN (SELECT id, name_fr FROM product) B ON A.product_id = B.id
    WHERE A.id = '" . $ID . "' LIMIT 1";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {		
		while($row = $result->fetch_assoc()) {
            //$html .= "<input id='lineID' type='text' style='display:none;' value='" . $row["id"] . "'>";           
//PRODUCT
            $html .= "<div class='divBOX'><b>Produit #:</b>";
            if ($APREAD_ONLY == false) { $html .= "<button class='blue' style='float:right;padding:0px;' onclick=\"openSEL_PRD('LINE');\"><span class='material-icons'>search</span></button>";}
            $html .= "<input id='linePRD_NAME' disabled type='text' value=\"" . $row["product_name"] . "\">
                        <input id='linePRD' type='number' value=\"" . $row["product_id"] . "\">
                    </div><br>";
//QUANTITÉ
            $html .= "<div class='divBOX'><b>Quantité par unité produite:</b>
                        <input id='lineQTY' type='number' value=\"" . $row["qty_by_unit"] . "\">
                    </div>";
            if ($APREAD_ONLY == false) { $html .= "<br><button class='red' onclick=\"deletePROCEDURE_LINE('" . $row["id"] . "');\"><span class='material-icons'>delete</span></button>";} else { $html .="<br>";}
            $html .= "<button class='grey' onclick=\"closeMSG();\"><span class='material-icons'>close</span> Fermer</button>";
            if ($APREAD_ONLY == false) { $html .= "<button class='green' onclick=\"updPROCEDURE_LINE('" . $row["procedure_id"] . "','" . $row["id"] . "');\"><span class='material-icons'>save</span> Enregistrer</button>";}
		}
	}
$dw3_conn->close();
header('Status: 200');
die($html);
?>