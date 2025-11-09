<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID  = $_GET['ID'];
$html = "";
$sql = "SELECT A.*, B.*,C.LocationName as LocationName, D.tots AS tots FROM transfer A 
LEFT JOIN (SELECT id as storageID, location_id,level,local,row,shelf,section FROM storage) B ON B.storageID = A.storage_id
LEFT JOIN (SELECT id as locationID, name as LocationName FROM location) C ON B.location_id = C.locationID
LEFT JOIN (SELECT product_id AS prod_id,SUM(quantity) AS tots FROM transfer GROUP BY prod_id) D ON A.product_id = D.prod_id
WHERE A.id = '".$ID."' LIMIT 1";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {		
    while($row = $result->fetch_assoc()) {
        $html .= "<table class='tblDATA' style='text-align:left;'><tr><th>Type de transfert</th><td>";
            if ($row["kind"] == "MOVE"){$html .= "Mouvement d'inventaire";}
            else if ($row["kind"] == "LOST"){$html .= "Perdu / Trouvé";}
            else if ($row["kind"] == "PROD"){$html .= "Production";}
            else if ($row["kind"] == "EXPORT"){$html .= "Expédition (vente)";}
            else if ($row["kind"] == "IMPORT"){$html .= "Réception (achat)";}
            else if ($row["kind"] == "SUPP_RET"){$html .= "Retourné au fournisseur";}
            else if ($row["kind"] == "CUST_RET"){$html .= "Retourné du client";}
            else {$html .= "Non défini";}
            $html .= "  </td></tr>";
            $html .= "<tr><th>Location</th><td>" . $row["LocationName"] . "</td></tr>";
            $html .= "<tr><th>Étage</th><td style='text-align:center;font-weight:bold;'>" . $row["level"] . "</td></tr>";
            $html .= "<tr><th>Local</th><td style='text-align:center;font-weight:bold;'>" . $row["local"] . "</td></tr>";
            $html .= "<tr><th>Allée</th><td style='text-align:center;font-weight:bold;'>" . $row["row"] . "</td></tr>";
            $html .= "<tr><th>Étagère</th><td style='text-align:center;font-weight:bold;'>" . $row["shelf"] . "</td></tr>";
            $html .= "<tr><th>Section</th><td style='text-align:center;font-weight:bold;'>" . $row["section"] . "</td></tr>";
            $html .= "<tr><th>Quantité transféré</th><td style='text-align:center;'>" . $row["quantity"] . "</td></tr>";
            $html .= "<tr><th>Quantité actuelle</th><td style='text-align:center;font-weight:bold;'>" . $row["tots"] . "</td></tr>";
            $html .= "<tr><th>Date de création</th><td>" . $row["date_created"] . "</td></tr>";
            $html .= "<tr><th>Utilisateur</th><td>" . $row["user_created"] . "</td></tr>";
            $html .= "<tr><th>Commande #</th><td>" . $row["order_id"] . "</td></tr>";
            $html .= "<tr><th>Achat #</th><td>" . $row["purchase_id"] . "</td></tr>";
            $html .= "</table>";
            if ($APREAD_ONLY == false) { $html .= "<button class='red' onclick='deleteTRF(".$ID.");'><span class='material-icons'>delete</span> Effacer le transfert</button> ";}
            $html .= "<button class='grey' onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Fermer</button>";
		}
	}
$dw3_conn->close();
header('Status: 200');
die($html);
?>