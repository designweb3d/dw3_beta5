<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$prID  = $_GET['prID'];
$html = "";
$gtot = 0;
$sql = "SELECT *
FROM product 
WHERE id = " . $prID . "
LIMIT 1";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {		
    while($row = $result->fetch_assoc()) {
        $filename= $row["url_img"];
        $qty_box= $row["qty_box"];
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
            $filename = "/img/nd.png";
        } else {
            if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
                $filename = "/img/nd.png";
            }else{
                $filename = "/fs/product/" . $row["id"] . "/" . $filename;
            }
        }  
        $html .= "<div id='divEDIT_HEADER' class='dw3_form_head'>
                    <h3>Transferts du produit #". $row["id"] ."</h3>
                    <button class='dw3_form_close' onclick='closeEDITOR(this);'><span class='material-icons'>close</span></button>
                </div>
                <div class='dw3_form_data'><img id='imgPRD' style='height:50px;width:auto;' src='" . $filename . "' onerror='this.onerror=null; this.src=\"/img/nd.png\";'>
                <table class='tblSEL'><tr><th style='text-align:right;'>Quantité</th><th style='text-align:left;'>Type</th><th>Storage ID</th><th>Date et heure</th></tr>";
    }
}

	$sql = "SELECT *
			FROM transfer 
			WHERE product_id = " . $prID . "
            ORDER BY date_created DESC
            LIMIT 1000";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {		
		while($row = $result->fetch_assoc()) {
          $html .= "<tr onclick='getTRF(\"".$row["id"]."\");'>";
            $html .= "  <td style='text-align:right;'>" . $row["quantity"] . "</td>";
            if ($row["kind"] == "MOVE"){$kind_desc = "Mouvement d'inventaire";}
            else if ($row["kind"] == "LOST"){$kind_desc = "-Perdu / +Retrouvé";}
            else if ($row["kind"] == "PROD"){$kind_desc = "Production";}
            else if ($row["kind"] == "EXPORT"){$kind_desc = "Expédition (vente)";}
            else if ($row["kind"] == "IMPORT"){$kind_desc = "Réception (achat)";}
            else if ($row["kind"] == "RETURN"){$kind_desc = "Retour d'expédition";}
            else if ($row["kind"] == "SUPP_RET"){$kind_desc = "Retourné au fournisseur";}
            else if ($row["kind"] == "CUST_RET"){$kind_desc = "Retourné du client";}
            else {$kind_desc = "Non défini";}
            $html .= "  <td style='text-align:left;'>" . $kind_desc . "</td>";
            $html .= "  <td style='text-align:center;'>" . $row["storage_id"] . "</td>";
            $html .= "  <td style='font-size:12px;'>" . $row["date_created"] . "</td>";
            $html .= "</tr>";
            $gtot += $row["quantity"];			
		}
        $html .= "</table></div><div class='dw3_form_foot'><div style='float:left;margin:0px 0px 0px 15px;font-size:10px;'>Total:<b style='font-size:20px;margin-left:10px;'>" . $gtot . "</b></div>";
        if ($APREAD_ONLY == false) { $html .= "<button class='green' onclick='openNEW();document.getElementById(\"newPRD\").value=\"" . $prID . "\";document.getElementById(\"newQTE\").value=\"" . $qty_box . "\";document.getElementById(\"newSTORAGE\").focus();'><span class='material-icons'>add</span> Transfert</button>";}
        $html .= "<button class='grey' onclick='closeEDITOR(this);'><span class='material-icons'>cancel</span> Fermer</button>";
        $html .= "</div>";
	}
$dw3_conn->close();
header('Status: 200');
die($html);
?>