<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$enID  = $_GET['enID'];

//data from head
$sql = "SELECT *
FROM purchase_head 
WHERE id = '" . $enID . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$head_stat= $data['stat'];

$html = "";
    $sql = "SELECT A.*, IFNULL(B.name_fr,A.name_fr), B.url_img, B.upc
    FROM purchase_line A
    LEFT JOIN product B ON A.product_id = B.id
    WHERE A.head_id = " . $enID . "
    ORDER BY A.line DESC";
    $counter= 0;
	$result = $dw3_conn->query($sql);
    $numrows = $result->num_rows;
        $html .= "<h4 onclick=\"toggleSub('divSub2','up2');\" style=\"text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;border-bottom: 1mm ridge rgba(250, 199, 0, .6);background: rgba(200, 200, 200, 0.7);\">
        <span class=\"material-icons\">inventory_2</span> Produits en achat (" . $numrows . ")<span id='up2' class=\"material-icons\" style='float:right;margin-right:5px;'>keyboard_arrow_down</span>
        </h4>";
        $html .= "<div class='divMAIN' id='divSub2' style='width:100%;overflow-y:auto;margin:0px;padding:0px;'>
        <table id='dataTABLE' class='tblDATA'><tr><th></th><th>Produit/Service</th><th>Quantité</th><th>$ unitaire</th><th style='font-size:12px;'>TPS</th><th style='font-size:12px;'>TVQ</th><th style='text-align:right'>Avant taxe</th></tr>";
    if ($numrows > 0 ) {
		while($row = $result->fetch_assoc()) {
            if($counter==0){$hl_last_line = " style='background:#afc;'";}else{$hl_last_line = "";}
            $counter ++;
           if ($head_stat=="0" && $APREAD_ONLY == false){
                $html .= "<tr" . $hl_last_line ."><td width='32px'><button onclick='deleteLINE(".$enID."," . $row["id"] . ");' style='padding:3px;background:red;'><span class=\"material-icons\" style=''>delete</span></button></td>";
                //$html .= "<td width='7%'><button onclick='selEXPENSE(" . $row["id"] . ");' style='padding:3px;'><span class=\"material-icons\">local_atm</span></button>";
                //if ($row["gl_group"]!=""){$html .= "<span class=\"material-icons\">thumb_up</span>";}$html .= "</td>";
                $html .= "<td width='*'><input id='line_name' type='text' value='" . $row["name_fr"] . "' onchange='updLGN_NAME(\"" . $row["id"] . "\");'></td>";
                $html .= "<td width='7%'><input style='padding:5px;text-align:right;' id='qty_order' type='text' value='" . $row["qty_order"] . "' onchange='updLGN_QTY(\"" . $row["id"] . "\",this.value);'></td>";
                $html .= "<td width='7%'><input style='padding:5px;text-align:right;' id='lgPRIX' type='text' value='" .number_format( $row["price"],2,'.',''). "'  onchange='updLGN_PRICE(\"" . $row["id"] . "\",this.value);'></td>";
                $PRIX_LGN = $row["qty_order"] * $row["price"];
                $html .= "<td width='3%'><input id='lgTAX_FED_" . $row["id"] . "' type='checkbox' oninput='updLGN_TPS(\"" . $row["id"] . "\");'' style='margin-top:5px;'"; if ($row["tax_fed"] == true){ $html .= " checked"; } $html .= "></td>";
                $html .= "<td width='3%'><input id='lgTAX_PROV_" . $row["id"] . "' type='checkbox' oninput='updLGN_TVQ(\"" . $row["id"] . "\");'' style='margin-top:5px;'"; if ($row["tax_prov"] == true){ $html .= " checked"; } $html .= "></td>";
                $html .= "<td style='text-align:right'>" . number_format($PRIX_LGN,2,'.','')  . "$</td>";
                $html .= "</tr>";
           }else{
                $html .= "<tr" . $hl_last_line ."><td></td>";
                $html .= "<td><input id='line_name' disabled type='text' value='" . $row["name_fr"] . "' ></td>";
                $html .= "<td><input id='qty_order' disabled type='text' value='" . $row["qty_order"] . "'></td>";
                $html .= "<td><input id='lgPRIX' disabled type='text' value='" .number_format( $row["price"],2,'.','')."'></td>";
                $PRIX_LGN = $row["qty_order"] * $row["price"];
                $html .= "<td><input id='lgTAX_FED_" . $row["id"] . "' type='checkbox' disabled style='margin-top:5px;'"; if ($row["tax_fed"] == true){ $html .= " checked"; } $html .= "></td>";
                $html .= "<td><input id='lgTAX_PROV_" . $row["id"] . "' type='checkbox' disabled style='margin-top:5px;'"; if ($row["tax_prov"] == true){ $html .= " checked"; } $html .= "></td>";
                $html .= "<td style='text-align:right'>" . number_format($PRIX_LGN,2,'.','') . "</td>";
                $html .= "</tr>";
           }
		}
    } 
$html .= "</table></div>
";
$dw3_conn->close();
die($html);
?>